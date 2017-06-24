<?php

if ( ! class_exists('CV_Template_Builder') ) :

/**
 * Template Builder
 * used to create and edit page content
 *
 * @package    WordPress
 * @subpackage Canvys
 * @since      Version 1.0
 */
class CV_Template_Builder {

   /**
    * Initially load the template builder
    *
    * @return void
    */
   public function __construct( $screens ) {

      /**
       * Array of screen ID's the editor can be applied to
       *
       * @var array
       */
      $this->screens = $screens;

      // Load initial actions
      add_action( 'load-post.php',     array( $this, 'admin_init' ) );
      add_action( 'load-post-new.php', array( $this, 'admin_init' ) );

      // Array containing each AJAX action
      $ajax_actions = array(
         'load_template',
         'update_template_manager',
         'refresh_edited_module',
         'update_editor_value'
      );

      // register each AJAX action
      foreach ( $ajax_actions as $action ) {
         add_action('wp_ajax_' . 'cv_ajax_' . $action, array( $this, $action . '_callback' ) );
         add_action('wp_ajax_nopriv_' . 'cv_ajax_' . $action, array( $this, $action . '_callback' ) );
      }

   }

   /**
    * Called on admin post pages
    *
    * @return void
    */
   public function admin_init() {
      $this->add_actions();
      $this->apply_editor_wrap();
      $this->activate_builder_callbacks();
   }

   /**
    * Apply various required actions
    *
    * @return void
    */
   public function add_actions() {

      // Grab current screen
      $screen = get_current_screen();

      // Make sure we're on the correct screen
      if ( ! in_array( $screen->id, $this->screens ) ) {
         return;
      }

      add_action( 'save_post',        array( $this, 'update_builder_value' ) );
      add_filter( 'content_save_pre', array( $this, 'update_searchable_content_value' ), 10, 1 );
      add_action( 'admin_head',       array( $this, 'load_additional_styles' ) );
      add_action( 'admin_footer',     array( $this, 'load_additional_assets' ) );
      add_filter( 'admin_body_class', array( $this, 'add_body_class' ) );

   }

   /**
    * Loads required CSS & JavaScript files
    *
    * @return void
    */
   public function add_body_class( $class ) {

      global $post_ID;

      // Grab the existing value for the custom template
      $active_editor = get_post_meta( $post_ID, '_cv_active_editor', true );
      $active_editor = cv_filter( $active_editor, array( 'default', 'advanced' ) );

      // Add the appropriate class
      return 'advanced' === $active_editor ? 'cv-builder-active' : 'cv-builder-hidden';

   }

   /**
    * Loads additional inline JavaScript
    *
    * @return void
    */
   public function load_additional_assets() {

      // Grab current screen
      $screen = get_current_screen();

      // Make sure we're on the correct screen
      if ( ! in_array( $screen->id, $this->screens ) ) {
         return;
      }

      do_action( 'cv_builder_inline_assets' );

      // Render template options callback for modal
      $this->render_template_options_template();

      // Render module options for modal
      $this->render_available_modules_template();

   }

   /**
    * Loads additional inline JavaScript
    *
    * @return void
    */
   public function load_additional_styles() {

      // Grab current screen
      $screen = get_current_screen();

      // Make sure we're on the correct screen
      if ( ! in_array( $screen->id, $this->screens ) ) {
         return;
      }

      do_action( 'cv_builder_inline_styles' );

   }

   /**
    * Wraps the default editor appropriately
    *
    * @return void
    */
   public function apply_editor_wrap() {

      // Grab current screen
      $screen = get_current_screen();

      // Make sure we're on the correct screen
      if ( ! in_array( $screen->id, $this->screens ) ) {
         return;
      }

      add_action( 'edit_form_after_title',  array( $this, 'before_editor' ), 100000 );
      add_action( 'edit_form_after_editor', array( $this, 'after_editor' ),  1 );

   }

   /**
    * Renders content to be placed before the editor
    *
    * @return void
    */
   public function before_editor() {

      global $post_ID;

      // Grab the existing value for the custom template
      $active_editor = get_post_meta( $post_ID, '_cv_active_editor', true );
      $active_editor = cv_filter( $active_editor, array( 'default', 'advanced' ) );

      // Create button array
      $display_labels = array(
         'default' =>  '<i class="icon-tools"></i> ' . __( 'Page Builder', 'canvys' ),
         'advanced' => __( 'Default Editor', 'canvys' ),
      );

      // Create the button
      $button = new CV_HTML( '<a>', array(
         'class' => 'button button-large',
         'id' => 'cv-toggle-active-editor',
         'data-default-label' => $display_labels['default'],
         'data-advanced-label' => $display_labels['advanced'],
         'content' => $display_labels[$active_editor],
         'style' => 'margin-bottom: 10px',
         'data-post-id' => $post_ID,
      ) );

      if ( 'default' == $active_editor ) {
         $button->add_class('button-primary');
      }

      // Determine if default editor should be displayed
      $hidden_class = 'advanced' == $active_editor ? ' cv-hidden' : null;

      // Display the wrap
      echo $button . '<div id="cv-default-editor-wrap" class="cv-default-editor-wrap' . $hidden_class . '">';

   }

   /**
    * Renders content to be placed after the editor
    *
    * @return void
    */
   public function after_editor() {
      echo '</div>';
      $this->render_builder();
   }

   /**
    * Loads alternate shortcode callbacks for display within the builder
    *
    * @return void
    */
   public function activate_builder_callbacks() {

      global $canvys;

      // Loop through each shortcode
      foreach ( $canvys['shortcodes'] as $shortcode ) {

         // Skip shortcode if it is not a builder element
         if ( ! $shortcode->config['builder_element'] ) {
            continue;
         }

         // Remove front end display of shortcode
         remove_shortcode( $shortcode->config['handle'] );

         // Activate back end display of shortcode
         add_shortcode( $shortcode->config['handle'], array( $shortcode, 'builder_module_callback' ) );

      }

   }

   /**
    * Creates the front end display of the meta box
    *
    * @param WP_Post $post The object for the current post
    * @return void
    */
   public function render_builder() {

      global $post;
      global $canvys;

      // Grab & sanitize existing template value
      $existing_template = get_post_meta( $post->ID, '_cv_page_template', true );
      $existing_template = cv_strip_inactive_plugin_shortcodes( $existing_template );
      update_post_meta( $post->ID, '_cv_page_template', $existing_template );

      // Determine which editor to display
      $active_editor = get_post_meta( $post->ID, '_cv_active_editor', true );

      // If no prior value has been set
      if ( ! $active_editor ) {
         $active_editor = $existing_template ? 'active' : 'default';
      }

      // Grab any existing saved templates
      $saved_templates = get_option('cv_builder_templates');

      // Declare it as null
      if ( empty( $saved_templates ) ) {
         $saved_templates = null;
      }

      // Display correct back/forward buttons
      if ( is_rtl() ) {
         $backward_icon = 'icon-right-open';
         $forward_icon = 'icon-left-open';
      }
      else {
         $backward_icon = 'icon-left-open';
         $forward_icon = 'icon-right-open';
      } ?>

      <div id="cv_template_builder" class="postbox cv-hidden">
      <div id="cv-builder" class="cv-builder">

      <!-- Builder Toolbar -->
      <ul class="cv-builder-toolbar has-clearfix" id="cv-toolbar">

         <!-- Undo Button -->
         <li class="cv-toolbar-control is-disabled">
            <a id="cv-step-backward" class="cv-control-button">
               <i class="<?php echo $backward_icon; ?>"></i>
            </a>
         </li>

         <!-- Redo Button -->
         <li class="cv-toolbar-control is-disabled">
            <a id="cv-step-forward" class="cv-control-button">
               <i class="<?php echo $forward_icon; ?>"></i>
            </a>
         </li>

         <!-- History Manager -->
         <li id="cv-toolbar-history" class="cv-toolbar-control cv-dropdown-control is-disabled visible-over-2">
            <a class="cv-control-button has-icon">
               <i class="icon-arrows-ccw"></i><?php _e( 'History', 'canvys' ); ?>
            </a>
            <ul id="cv-history" class="cv-dropdown cv-history"></ul>
         </li>

         <!-- Templates manager -->
         <li id="cv-toolbar-templates" class="cv-toolbar-control cv-dropdown-control">

            <a class="cv-control-button has-icon">
               <i class="icon-folder"></i>
               <?php _e( 'Templates', 'canvys' ); ?>
            </a>

            <!-- Template Dropdown -->
            <ul id="cv-templates" class="cv-dropdown cv-templates<?php echo ! $saved_templates ? ' is-empty' : ''; ?>">

               <!-- New Template Button -->
               <li class="cv-add-template">
                  <a class="has-icon" id="cv-add-template-button"><i class="icon-download-1"></i>Save Page as Template</a>
               </li>

               <!-- Template Creator -->
               <li class="cv-dropdown-info cv-create-template">
                  <input type="text" id="cv-new-template-name" placeholder="<?php _e( 'New Template Name', 'canvys' ); ?>" autocomplete="off" />
                  <div class="cv-split-12 not-responsive has-clearfix">
                     <a style="text-align:center;" id="cv-cancel-new-template"><?php _e( 'Cancel', 'canvys' ); ?></a>
                     <a style="text-align:center;" id="cv-submit-template-name"><?php _e( 'Save', 'canvys' ); ?></a>
                  </div>
                  <p><?php _e( 'Template names must have atleast 3 characters and can only contain alphanumeric characters and whitespace.', 'canvys' ); ?></p>
               </li>

               <!-- Display Saved Templates -->
               <li class="cv-dropdown-info" id="cv-no-templates-notice">
                  <p><?php _e( 'No saved templates were found, you can create one by pressing Save Page as Template above.', 'canvys' ); ?></p>
               </li>
               <?php if ( is_array( $saved_templates ) ) : foreach ( $saved_templates as $slug => $template ) : ?>
                  <li class="cv-template-container cv-custom-template">
                     <a class="cv-load-template has-icon" data-title="<?php echo $template['name']; ?>">
                        <i class="icon-folder"></i><?php echo $template['name']; ?>
                        <span class="cv-delete-template"><?php _e( 'Delete', 'canvys' ); ?></span>
                     </a>
                     <textarea name="cv_builder_templates[<?php echo $slug; ?>][template]" class="cv-saved-template"><?php echo $template['template']; ?></textarea>
                     <input type="hidden" name="cv_builder_templates[<?php echo $slug; ?>][name]" value="<?php echo $template['name']; ?>" />
                  </li>
               <?php endforeach; endif; ?>

            </ul>

         </li>

         <!-- Full Screen Control -->
         <li class="cv-toolbar-control cv-control-right">
            <a id="cv-toggle-fullscreen" class="cv-control-button has-icon"
            data-expand="<i class='icon-resize-full'></i><?php _e( 'Full Screen', 'canvys' ); ?>"
            data-compress="<i class='icon-resize-small'></i><?php _e( 'Exit Full Screen', 'canvys' ); ?>">
               <i class='icon-resize-full'></i><?php _e( 'Full Screen', 'canvys' ); ?>
            </a>
         </li>

         <!-- Preview Changes Control -->
         <li class="cv-toolbar-control cv-control-right cv-preview-control cv-fullscreen-only">
            <a id="cv-preview-changes" class="cv-control-button has-icon">
               <i class="icon-eye-1"></i></i><?php _e( 'Preview Changes', 'canvys' ); ?>
            </a>
         </li>

         <!-- Save Changes Control -->
         <li class="cv-toolbar-control cv-control-right cv-save-control cv-fullscreen-only">
            <a id="cv-save-changes" class="cv-control-button has-icon">
               <i class="icon-download-1"></i></i><?php _e( 'Save Changes', 'canvys' ); ?>
            </a>
         </li>

         <!-- Quick Tips Control -->
         <li class="cv-toolbar-control cv-dropdown-control cv-control-right visible-over-4">
            <a id="cv-quick-tips" class="cv-control-button has-icon">
               <i class="icon-help-circled"></i></i><?php _e( 'Quick Tips', 'canvys' ); ?>
            </a>

            <!-- Quick Tips Dropdown -->
            <ul class="cv-dropdown cv-quick-tips">
               <li class="cv-dropdown-header">
                  <strong><?php _e( 'Hot Keys', 'canvys' ); ?></strong>
               </li>
               <li class="cv-dropdown-info">
                  <p>
                     <strong><?php _e( 'Exiting Fullscreen', 'canvys' ); ?></strong><br />
                     <?php _e( 'When fullscreen editing is active simply press the escape (esc) key to return to normal editing.', 'canvys' ); ?>
                  </p>
                  <p>
                     <strong><?php _e( 'Confirming/Canceling Changes', 'canvys' ); ?></strong><br />
                     <?php _e( 'When editing a modules settings, you can either press the escape (esc) key to cancel any changes, or press the enter key to confirm them.', 'canvys' ); ?>
                  </p>
               </li>
               <li class="cv-dropdown-header">
                  <strong><?php _e( 'Drag to Duplicate', 'canvys' ); ?></strong>
               </li>
               <li class="cv-dropdown-info">
                  <p><?php _e( 'Modules can be duplicated and repositioned at the same time, simply drag a module by the duplicate button and a copy will be made instead of moving the existing module.', 'canvys' ); ?></p>
               </li>
               <li class="cv-dropdown-header">
                  <strong><?php _e( 'Auto Edit New Modules', 'canvys' ); ?></strong>
               </li>
               <li class="cv-dropdown-info">
                  <p><?php _e( 'When adding a new module click and hold the selected module and the edit screen will automatically be opened.', 'canvys' ); ?></p>
               </li>
            </ul>

         </li>

      </ul>

      <!-- Builder Canvas -->
      <div id="cv-builder-canvas" class="cv-builder-canvas">
         <div class="cv-dropzone" data-dropzone="0"><?php echo do_shortcode( $existing_template ); ?></div>
         <a class="cv-add-module" data-droptarget="0">
            <i class="icon-plus-squared"></i>
            <span><?php _e( 'Add Full Width Module', 'canvys' ); ?></span>
         </a>
      </div>

      <!-- Inputs used for storing the values for later -->
      <textarea id="cv-page-template-value" type="text" name="_cv_page_template"><?php echo $existing_template; ?></textarea>
      <input id="cv-active-editor" type="hidden" name="_cv_active_editor" value="<?php echo $active_editor; ?>" />

      </div><!-- End #builder-canvas -->

      </div><!-- End #cv_template_builder -->

   <?php }

   /**
    * Updates the value of the page builder upon form submission
    *
    * @param int $post_id The ID of the current post being updated
    * @return void
    */
   public function update_builder_value( $post_id ) {

      // Update template builder value
      if ( isset( $_POST['_cv_page_template'] ) ) {
         update_post_meta( $post_id, '_cv_page_template', $_POST['_cv_page_template'] );
      }

      // Update active editor setting
      if ( isset( $_POST['_cv_active_editor'] ) ) {
         $active_editor = cv_filter( $_POST['_cv_active_editor'], array( 'default', 'advanced' ) );
         update_post_meta( $post_id, '_cv_active_editor', $active_editor );
      }

   }

   /**
    * Updates the value of the content editor
    *
    * @param string $content The supplied content upon saving
    * @return mixed
    */
   public function update_searchable_content_value( $content ) {
      if ( isset( $_POST['_cv_page_template'] ) && isset( $_POST['_cv_active_editor'] ) && 'advanced' === $_POST['_cv_active_editor'] ) {
         return stripslashes( $_POST['_cv_page_template'] );
      }
      return $content;
   }

   /**
    * AJAX callback for loading templates
    *
    * @return void
    */
   public function load_template_callback() {

      // Make sure a template was submitted
      if ( ! isset($_POST['template']) ) {
         return;
      }
      // grabe the template being rendered
      $template = $_POST['template'];

      // Activate builder callbacks for the shortcodes
      $this->activate_builder_callbacks();

      // Remove inactive shortcodes
      $template = cv_strip_inactive_plugin_shortcodes( $template );

      // Display the rendered shortcodes
      echo do_shortcode( stripslashes( $template ) );

      die();

   }

   /**
    * AJAX callback for updating the template manager
    *
    * @return void
    */
   public function update_template_manager_callback() {

      // Make sure a template was submitted
      if ( ! isset($_POST['templates']) ) {
         return;
      }

      // grabe the template being rendered
      $templates = $_POST['templates'];

      // Decode the templates for PHP use
      $templates = json_decode( stripslashes( $templates ) );

      // Confert to array
      $templates = get_object_vars( $templates );

      $sanitized_templates = array();
      foreach ( $templates as $slug => $template ) {
         $sanitized_templates[$slug] = get_object_vars( $template );
      }

      // Update the database option
      update_option( 'cv_builder_templates', $sanitized_templates );

      die();

   }

   /**
    * AJAX callback for displaying the options for loading templates
    *
    * @return void
    */
   public function render_template_options_template() { ?>

      <script type="text/html" id="tmpl-cv-builder-template-options">

         <div class="cv-modal-content-padding">

            <a class="cv-composer-large-option has-icon" data-action="prepend">
               <i class="icon-up-bold"></i>
               <strong><?php _e( 'Add Before Existing Content', 'canvys' ); ?></strong>
               <span><?php _e( 'Insert the selected template before the existing page content.', 'canvys' ); ?></span>
            </a>
            <a class="cv-composer-large-option has-icon" data-action="replace">
               <i class="icon-stop"></i>
               <strong><?php _e( 'Replace Existing Content', 'canvys' ); ?></strong>
               <span><?php _e( 'Replace the existing page content with the selected template.', 'canvys' ); ?></span>
            </a>
            <a class="cv-composer-large-option has-icon" data-action="append">
               <i class="icon-down-bold"></i>
               <strong><?php _e( 'Add After Existing Content', 'canvys' ); ?></strong>
               <span><?php _e( 'Insert the selected template after the existing page content.', 'canvys' ); ?></span>
            </a>

         </div>

      </script>

   <?php }

   /**
    * AJAX callback for updating the template manager
    *
    * @return void
    */
   public function render_available_modules_template() {

      global $canvys;

      // The specific drop target of the shortcodes to show
      for ( $i=0; $i<3; $i++ ) : ?>

      <script type="text/html" id="tmpl-cv-builder-module-options-dropzone-<?php echo $i; ?>">

         <div class="cv-modal-content-padding">

            <div class="cv-grid-6 has-clearfix spacing-2">

               <?php foreach ( $canvys['shortcodes'] as $shortcode ) {

                  if ( ! $shortcode->config['builder_element'] ) {
                     continue;
                  }

                  if ( (int) $i !== $shortcode->config['drop_target'] ) {
                     continue;
                  } ?>
                  <div>
                     <a class="cv-composer-available-module" data-handle="<?php echo $shortcode->config['handle']; ?>">
                        <i class="icon-<?php echo $shortcode->config['icon']; ?>"></i>
                        <strong><?php echo $shortcode->config['title']; ?></strong>
                     </a>
                  </div>
               <?php } ?>

            </div>

         </div>

      </script>

      <?php endfor;

   }

   /**
    * AJAX callback for updating the template manager
    *
    * @return void
    */
   public function refresh_edited_module_callback() {

      global $canvys;

      // grabe the template being rendered
      $submitted = stripslashes( $_POST['submitted'] );

      // Decode the submitted information
      $submitted = json_decode( $submitted );
      $submitted = get_object_vars( $submitted );

      // grab the handle
      $handle = $submitted['handle'];

      // grab the content
      $content = isset( $submitted['content'] ) ? $submitted['content'] : null;

      // Grab the attributes
      $attributes = get_object_vars( $submitted['attributes'] );

      // Activate builder callbacks for the shortcodes
      $this->activate_builder_callbacks();

      // gab the appropriate shortcode object
      $shortcode = $canvys['shortcodes'][$handle];

      // Create the new module
      echo $shortcode->builder_module_callback( $attributes, $content );

      die();

   }

   /**
    * AJAX callback for updating the value of the current editor
    *
    * Will be called every time the editor is switched
    *
    * @return void
    */
   public function update_editor_value_callback() {

      // grab current post ID
      $post_ID = $_POST['post_ID'];

      // grab current editor value
      $current_editor = $_POST['current_editor'];

      // Update the database option
      update_post_meta( $post_ID, '_cv_active_editor', $current_editor );

      die();

   }

}
endif;