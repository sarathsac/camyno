<?php

if ( ! class_exists('CV_Shortcode_Composer') ) :

/**
 * Shortcode Composer
 * used to create and edit shortcodes
 *
 * @package    WordPress
 * @subpackage Canvys
 * @since      Version 1.0
 */
class CV_Shortcode_Composer {

   /**
    * Initially load the template builder
    *
    * @return void
    */
   public function __construct( $screens ) {

      // Array of screen ID's the editor can be applied to
      $this->screens = $screens;

      // Shortcode composer CSS path
      $this->composer_assets_path = THEME_DIR . 'config/shortcode-composer/assets/';

      // Template builder CSS path
      $this->builder_assets_path = THEME_DIR . 'config/template-builder/assets/';


      // Load initial actions
      add_action( 'load-post.php',     array( $this, 'admin_init' ) );
      add_action( 'load-post-new.php', array( $this, 'admin_init' ) );

      // Array containing each AJAX action
      $actions = array(
         'render_composer_controls',
         'render_available_shortcodes',
         'render_shortcode'
      );

      // register each AJAX action
      foreach ( $actions as $action ) {
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
      $this->load_assets();
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

      add_action( 'media_buttons', array( $this, 'render_button' ) );
      add_action( 'admin_head',    array( $this, 'load_additional_styles' ) );
      add_action( 'admin_footer',  array( $this, 'load_additional_assets' ) );
      add_action( 'admin_footer',  array( $this, 'render_modal_template' ) );
      add_action( 'admin_footer',  array( $this, 'insert_modal_container' ) );
      add_action( 'admin_footer',  array( $this, 'insert_shortcode_content_wp_editor' ) );

   }

   /**
    * Loads required CSS & JavaScript files
    *
    * @return void
    */
   public function load_assets() {

      global $canvys;

      // Grab current screen
      $screen = get_current_screen();

      // Make sure we're on the correct screen
      if ( ! in_array( $screen->id, $this->screens ) ) {
         return;
      }

      // Load composer Stylesheet file
      wp_enqueue_style( 'cv-shortcode-composer', $this->composer_assets_path . 'shortcode-composer.css' );

      // Load builder Stylesheet file
      wp_enqueue_style( 'cv-template-builder', $this->builder_assets_path . 'canvys-builder.css' );

      // Load theme icons stylesheet
      wp_enqueue_style( 'cv-icons', THEME_DIR . 'assets/css/icons.css' );

      // Register compressed jQuery plugins file
      $api_key = cv_theme_setting( 'advanced', 'google_maps_api_key' );
      $google_maps_api_url = $api_key ? '://maps.googleapis.com/maps/api/js?key='.$api_key : '://maps.google.com/maps/api/js?sensor=true';
      wp_enqueue_script('cv-gmaps-api', is_ssl() ? 'https'.$google_maps_api_url : 'http'.$google_maps_api_url, null, THEME_VER, false );

      // Composer jQuery file
      wp_enqueue_script( 'cv-composer', $this->composer_assets_path . 'compressed/jquery.canvys-composer.min.js' );
      wp_localize_script( 'cv-composer', 'cv_composer_localize', $canvys['composer_localization'] );

      // Builder jQuery file
      wp_enqueue_script( 'cv-template-builder', $this->builder_assets_path . 'compressed/jquery.canvys-builder.min.js' );
      wp_localize_script( 'cv-template-builder', 'cv_builder_localize', $canvys['builder_localization'] );

      // Modal jQuery file
      wp_enqueue_script( 'cv-composer-modal', $this->composer_assets_path . 'compressed/jquery.canvys-modal.min.js', array( 'wp-color-picker', 'underscore' ) );
      wp_localize_script( 'cv-composer-modal', 'cv_modal_localize', $canvys['modal_localization'] );

      // Load WP Color Picker
      wp_enqueue_style( 'wp-color-picker' );

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

      /**
       * Include any additional assets required by the controls
       */
      foreach ( get_declared_classes() as $class ) {

         // make sure class is a shortcode control
         if ( ! is_subclass_of( $class, 'CV_Shortcode_Control' ) ) {
            continue;
         }

         echo call_user_func( array( $class, 'composer_additional_assets' ) );

      }

      // include any additional assets sent by shortcodes
      do_action( 'cv_composer_inline_assets' );

   }

   /**
    * Loads additional inline styles
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

      /**
       * Include any additional assets required by the controls
       */
      foreach ( get_declared_classes() as $class ) {

         // make sure class is a shortcode control
         if ( ! is_subclass_of( $class, 'CV_Shortcode_Control' ) ) {
            continue;
         }

         echo call_user_func( array( $class, 'composer_additional_styles' ) );

      }

      // include any additional assets sent by shortcodes
      do_action( 'cv_composer_inline_styles' );

   }

   /**
    * Renders the launch button
    *
    * @return void
    */
   public function render_button() {

      // Create the composer button
      echo new CV_HTML( '<a>', array(
         'class'   => 'button cv-composer-launch',
         'content' => '<i class="icon-code-1"></i> ' . __( 'Add Shortcode', 'canvys' ),
         'title'   => __( 'Add/Edit Shortcode', 'canvys' ),
         'style'   => 'display:none;',
      ) );

   }

   /**
    * Renders the overlay modal container used to isolate the modals
    *
    * @return void
    */
   public function insert_modal_container() {
      echo '<div id="cv-composer-absolute-container"></div>';
   }

   /**
    * Renders the overlay modal
    *
    * @return void
    */
   public function render_modal_template() {

      global $canvys;

      $shortcodes = $canvys['shortcodes']; ?>

      <script type="text/html" id="cv-tmpl-composer-modal">

         <div class="cv-composer-overlay">

         <div class="cv-composer-container">

               <div class="cv-composer-header-wrap">
                  <header class="cv-composer-header">

                     <!-- Composer Title -->
                     <h3 class="cv-composer-title">Default Modal Title</h3>

                     <!-- Composer Toolbar -->
                     <nav class="cv-composer-toolbar">
                        <ul>
                           <li class="cv-composer-update-container">
                              <a class="cv-composer-submit">
                                 <i class="icon-check"></i>
                              </a>
                           </li>
                           <li class="cv-composer-cancel-container">
                              <a class="cv-composer-cancel">
                                 <i class="icon-cancel"></i>
                              </a>
                           </li>
                        </ul>
                     </nav>

                  <!-- End .cv-composer-header -->
                  </header>
               </div>

               <div class="cv-composer-modal-wrap">
                  <div class="cv-composer-modal">

                  <!-- End .cv-composer-modal -->
                  </div>
               </div>

            </div>

         <!-- End .cv-composer-overlay -->
         </div>

      </script>

   <?php }

   /**
    * Prints the HTML containing the shortcode content editor HTML
    *
    * @return void
    */
   public function insert_shortcode_content_wp_editor() {
      ?>
         <div id="cv-shortcode-content-wp-editor-wrap" style="display:none;">
            <div class="cv-shortcode-content-wp-editor-wrap-controls">
               <button type="button" id="cv-shortcode-content-wp-editor-wrap-cancel"><i class="icon-cancel"></i></button>
               <button type="button" id="cv-shortcode-content-wp-editor-wrap-submit"><i class="icon-check"></i></button>
            </div>
            <div class="cv-shortcode-content-wp-editor">
               <?php wp_editor( '', 'shortcode_wp_editor_content', array(
                  'editor_height' => 400,
                  'tinymce'=> array(
                     'toolbar1' => 'bold,italic,underline,strikethrough,bullist,numlist,blockquote,hr,alignjustify,alignleft,aligncenter,alignright,link,unlink,wp_adv',
                     'toolbar2' => 'formatselect,forecolor,pastetext,removeformat,charmap,outdent,indent,undo,redo',
                     'toolbar3' => '',
                  ),
               ) ); ?>
            </div>
         </div>
      <?php
   }

   /**
    * AJAX callback for displaying available shortcodes
    *
    * @return void
    */
   public function render_available_shortcodes_callback() {

      global $canvys; ?>

      <div class="cv-modal-content-padding">

         <div class="cv-grid-6 has-clearfix spacing-2">

            <?php foreach ( $canvys['shortcodes'] as $shortcode ) {

               if ( ! $shortcode->config['composer_element'] ) {
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

      <?php die();

   }

   /**
    * AJAX callback that generates the shortcode composer controls
    *
    * @return void
    */
   public function render_composer_controls_callback() {

      global $canvys;

      // If full shortcode was provided for editing
      if ( 0 === strpos( $_POST['param'], '[') ) {

         // Remove backslashes from the shortcode
         $param = stripslashes( $_POST['param'] );

         // Grab the regex pattern
         $pattern = cv_get_shortcode_regex();

         // Apply the regex
         preg_match( "/$pattern/s", $param, $pieces );

         // grab the handle
         $handle = $pieces[2];

         // grab the content
         $content = $pieces[5];

         // Grab the attributes
         $existing_attributes = shortcode_parse_atts( $pieces[3] );

      }

      // If only handle was supplied
      else {

         $handle = $_POST['param'];

      }

      $shortcode = $canvys['shortcodes'][$handle];

      echo '<div class="cv-modal-padding cv-compose-shortcode editing-' . $handle . '">';
      echo '<form id="cv-composer-form" class="shortcode-attributes">';

      if ( isset( $shortcode->config['explanation'] ) && $shortcode->config['explanation'] ) {
            echo '<div class="control-wrap has-clearfix shortcode-explanation-wrap">';
            echo '<div class="control-padding">';
            echo '<div style="max-width: 600px;margin: 0 auto;">';
            echo '<p class="show-shortcode-explanation" style="display: block;">' . sprintf( __( 'Additional Information', 'canvys' ), $shortcode->config['title'] ) . '</p>';
            echo '<p class="shortcode-explanation" style="display: none;" title="' . __( 'Click to hide', 'canvys' ) . '">' . $shortcode->config['explanation'] . '</p>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
      }

      // Check if module has a content element
      if ( $shortcode->config['content_element'] ) {

         // Grab existing content
         $existing_content = isset( $content ) ? $content : $shortcode->config['default_content'];

         // grab the content element
         $content_element = $canvys['shortcodes'][$shortcode->config['content_element']];

         // Activate the builder module callback
         $content_element->activate_builder_module_callback();

         // Display existing content modules
         echo '<div class="content-elements">';
         echo '<div class="content-elements-size-limiter">';
         echo '<div class="cv-sortzone has-clearfix">' . do_shortcode($existing_content) . '</div>';
         echo '<a class="cv-add-module" data-handle="' . $content_element->config['handle'] . '">';
         echo '<i class="icon-plus-squared"></i>' . sprintf( __( 'Add %s', 'canvys' ), $content_element->config['title'] );
         echo '</a>';
         echo '</div>';
         echo '</div>';

      }

      // Make sure module has attributes to edit
      if ( $shortcode->config['attributes'] ) {

         echo '<div class="standard-attributes">';

         foreach ( $shortcode->config['attributes'] as $control ) {

            // Wrap each control
            echo '<div class="control-wrap has-clearfix control-' . $control->handle . '" data-type="' . $control->type . '">';

            // Determine if the value fot each attribute already exists
            $value = isset( $existing_attributes[$control->handle] ) ? $existing_attributes[$control->handle] : $control->config['default'];

            // Display the control
            echo $control->render_complete_control( $value );

            echo '</div>';

         }

         echo '</div>';

      }

      // Display optional content editor
      if ( $shortcode->config['content_editor'] ) {

         $existing_content = isset( $content ) ? $content : $shortcode->config['default_content'];

         ?>
            <div class="cv-composer-content-editor-wrap">
               <strong class="cv-composer-content-editor-title"><?php printf( __( '%s Content', 'canvys' ), $shortcode->config['title'] ); ?></strong>
               <div style="margin-bottom: 15px;">
                  <button type="button" class="button cv-composer-content-editor-launch"><?php _e( 'Edit content', 'canvys' ); ?></button>
               </div>
               <div class="cv-composer-content-editor-current-content-preview"><?php echo $existing_content; ?></div>
               <textarea class="cv-composer-content-editor-current-content"><?php echo $existing_content; ?></textarea>
            </div>
         <?php
      }

      // If not display any existing content
      else if ( false !== $shortcode->config['drop_zone'] ) {
         $existing_content = isset( $content ) ? $content : $shortcode->config['default_content'];
         echo '<textarea style="display:none" name="shortcode_dropzone_content" class="original-content">' . $existing_content . '</textarea>';
      }

      // Display any additional controls
      if ( $shortcode->render_additional_controls() ) {
         echo '<div class="additional-controls">';
         echo $shortcode->render_additional_controls();
         echo '</div>';
      }

      echo '</form>';
      echo '</div>';

      die();

   }

   /**
    * AJAX callback for rendering a shortcode based on a JSON object
    *
    * @return void
    */
   public function render_shortcode_callback() {

      global $canvys;

      // grab the template being rendered
      $submitted = stripslashes( $_POST['submitted'] );

      // The editor class being used
      $active_editor = $_POST['editor'];

      // Decode the submitted information
      $submitted = json_decode( $submitted );
      $submitted = get_object_vars( $submitted );

      // grab the handle
      $handle = $submitted['handle'];

      // grab the content
      $content = isset( $submitted['content'] ) ? $submitted['content'] : null;

      // Grab the attributes
      $attributes = get_object_vars( $submitted['attributes'] );

      // Grab the appropriate shortcode object
      $object = $canvys['shortcodes'][$handle];

      // Render the shortcode
      $shortcode = $object->get_rendered_shortcode( $attributes, $content, true );

      // Declare columns as a content element for column rows
      if ( 'cv_column_row' == $object->config['handle'] ) {
         $object->config['content_element'] = 'cv_column';
      }

      // If shortcode contains a content elemnt
      if ( $object->config['content_element'] ) {

         // Grab the content element object
         $content_object = $canvys['shortcodes'][$object->config['content_element']];

         $preg_searches = array();
         $replace_searches = array();

         foreach ( array( $object, $content_object ) as $current_object ) {

            // Modify replace searches array
            if ( ! $current_object->config['self_closing'] ) {
               $replace_searches[] = '[/' . $current_object->config['handle'] . ']';
            }

            // Modify either replace or preg searches array
            if ( $current_object->config['attributes'] ) {
               $preg_searches[] = $current_object->config['handle'] . ' ';
            }
            else {
               $replace_searches[] = '[' . $current_object->config['handle'] . ']';
            }

         }

         // Determine what to do with matches
         $action = 'tmce' == $active_editor ? "<p>%s</p>" : "%s\n\n";

         // Use regular expression first
         foreach ( $preg_searches as $search ) {
            preg_match_all( "/\[" . preg_quote( $search ) . ".*?\]/", $shortcode, $matches );
            foreach ( array_unique( $matches[0] ) as $match ) {
               $shortcode = str_replace( $match, sprintf( $action, $match ), $shortcode );
            }
         }

         // Then normal str_replace
         foreach ( array_unique( $replace_searches ) as $search ) {
            $shortcode = str_replace( $search, sprintf( $action, $search ), $shortcode );
         }

         // Apply autop
         if ( 'tmce' == $active_editor ) {
            $shortcode = wpautop( $shortcode );
         }
         else {
            $shortcode = trim( $shortcode, "\n\n" );
         }

      }

      echo $shortcode;

      die();

   }

}
endif;