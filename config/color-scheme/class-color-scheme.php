<?php

if ( ! class_exists('CV_Color_Scheme') ) :

/**
 * Front End Color Scheme
 * used to manage the theme color scheme
 *
 * @package    WordPress
 * @subpackage Canvys
 * @since      Version 1.0
 */
class CV_Color_Scheme {

   /**
    * Initially load the color scheme manager
    *
    * @return void
    */
   public function __construct() {
      add_action( 'init', array( $this, 'check_capabilities' ) );
   }

   /**
    * Make sure user can edit theme options before loading
    *
    * @return nothing
    */
   public function check_capabilities() {

      add_action('admin_init', array( $this, 'init' ) );

      // Make sure user can edit theme options
      if ( ! current_user_can('edit_theme_options') ) {
         return;
      }

      // Initiate the administration page
      add_action('admin_menu', array( $this, 'create_menu' ) );

      // Load required asstes
      add_action('admin_enqueue_scripts', array( $this, 'load_assets' ) );

   }

   /**
    * Initiate the administration panel
    *
    * @return nothing
    */
   public function init() {

      // Make sure the option exists
      if ( ! get_option( 'cv_color_scheme' ) ) {
         add_option( 'cv_color_scheme', cv_get_color_scheme() );
      }

      // Register the setting with its callback
      if ( method_exists( $this, 'update_color_scheme' ) ) {
         register_setting('cv_color_scheme', 'cv_color_scheme', array( $this, 'update_color_scheme' ) );
      }

   }

   /**
    * Load required assets
    *
    * @return nothing
    */
   public function load_assets( $hook ) {

      // Make sure we're on the right page
      if ( 'appearance_page_cv-color-scheme' != $hook ) {
         return;
      }

      // Admin assets directory
      $dir = THEME_DIR . 'config/color-scheme/assets/';

      // Load theme icons stylesheet
      wp_enqueue_style( 'cv-icons', THEME_DIR . 'assets/css/icons.css' );

      // Load color scheme specific assets
      wp_enqueue_style( 'cv-color-scheme', $dir . 'color-scheme.css' );
      wp_enqueue_script( 'cv-color-scheme-manager', $dir . 'compressed/jquery.color-scheme.min.js', array('wp-color-picker') );
      wp_enqueue_style( 'wp-color-picker' );

   }

   /**
    * Create the menu pages
    *
    * @return nothing
    */
   public function create_menu() {

      global $canvys;

      $page = add_theme_page(
         __( 'Color Scheme', 'canvys' ),
         __( 'Color Scheme', 'canvys' ),
         'edit_theme_options',
         'cv-color-scheme',
         array( $this, 'render_page' )
      );

      // Add the help tab
      add_action( 'load-' . $page, array( $this, 'render_help' ) );

   }

   /**
    * Render the color scheme manager page
    *
    * @return nothing
    */
   public static function render_page() {
      global $canvys;

      $notification = null;
      if ( isset( $_GET['settings-updated'] ) && $_GET['settings-updated'] ) {

         // Display a saved message
         $notification  = '<div class="updated below-h2">';
         $notification .= '<p>' . sprintf( __( 'Color scheme updated. <a href="%s">Visit your site</a> to see how it looks.', 'canvys' ), get_home_url() ) . '</p>';
         $notification .= '</div>';

      }

      $color_scheme = get_option('cv_color_scheme'); ?>

      <div class="wrap cv-admin-page cv-admin-color_scheme">
         <h2 style="display:none;"></h2>
         <?php echo $notification; ?>
         <div id="cv-color-scheme">
            <form id="cv_color_scheme" method="post" action="options.php">

               <?php
                  // Load WordPress required fields
                  settings_errors('cv_color_scheme');
                  settings_fields('cv_color_scheme'); ?>

               <!-- Color Scheme Presets -->
               <div id="cv-scheme-presets" class="cv-scheme-presets">
                  <ul class="cv-grid-5 has-clearfix spacing-1">
                     <?php foreach ( $canvys['color_scheme_presets'] as $slug => $config ) {
                        $id = 'cv-scheme-option-' . $slug;
                        $scheme = "'" . json_encode( $config['scheme'] ) . "'";
                        echo '<li class="scheme-option">';
                        echo '<input type="radio" id="' . $id . '" name="cv_color_scheme[preset]" value="' . $slug . '" ' . checked( $slug, $color_scheme['preset'], false ) . ' />';
                        echo '<label class="cv-load-scheme" for="' . $id . '" data-scheme=' . $scheme . '>';
                        echo '<strong><i class="icon-circle-empty"></i><i class="icon-circle"></i>' . $config['name'] . '</strong>';
                        echo '<div class="cv-grid-8 not-responsive has-clearfix">';
                        foreach ( $config['scheme']['main'] as $color ) {
                           echo '<div style="background-color:' . $color . ';height:15px;"></div>';
                        }
                        echo '</div>';
                        echo '</label>';
                        echo '</li>';
                     } ?>
                  </ul>
               </div>

               <!-- Color Scheme Preview -->
               <div id="cv-scheme-history" class="cv-scheme-history"></div>
               <div id="cv-history-bar" class="cv-history-bar">
                  <a id="cv-scheme-step-backward"><i class="icon-left-open"></i></a>
                  <a id="cv-scheme-step-forward"><i class="icon-right-open"></i></a>
               </div>
               <div id="cv-scheme-preview" class="cv-scheme-preview">
                  <header id="cv-preview-header" class="cv-preview-header has-clearfix">
                     <strong><span class="header"><?php _e( 'Website Header', 'canvys' ); ?></span> <?php _e( 'Regular inline text', 'canvys' ); ?></strong>
                     <nav>
                        <a href="#" class="accent"><?php _e( 'Menu Item', 'canvys' ); ?></a>
                        <a href="#" class="focused"><?php _e( 'Focused Menu Item', 'canvys' ); ?></a>
                        <a href="#" class="secondary-content secondary-bg border-color"><?php _e( 'Secondary content with borders', 'canvys' ); ?></a>
                     </nav>
                  </header>
                  <section id="cv-preview-main" class="cv-preview-main">
                     <div class="cv-split-23-13 spacing-2 has-clearfix">
                        <div>
                           <h2 class="header"><?php _e( 'Main Content Header', 'canvys' ); ?></h2>
                           <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.</p>
                           <a href="#" class="accent"><?php _e( 'Normal Link', 'canvys' ); ?></a> <a href="#" class="focused"><?php _e( 'Focused Link', 'canvys' ); ?></a>
                           <br /><div class="secondary-content secondary-bg border-color"><?php _e( 'Secondary content example, with borders', 'canvys' ); ?></div>
                        </div>
                        <div class="border-color" style="border-left: 1px solid transparent;">
                           <h4 class="header"><?php _e( 'Sidebar Title', 'canvys' ); ?></h4>
                           <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</p>
                           <h4 class="header"><?php _e( 'Sidebar Title', 'canvys' ); ?></h4>
                           <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</p>
                        </div>
                     </div>
                  </section>
                  <section id="cv-preview-alternate" class="cv-preview-alternate">
                     <div class="cv-split-13-23 spacing-2 has-clearfix">
                        <div class="border-color" style="border-right: 1px solid transparent;">
                           <h4 class="header"><?php _e( 'Sidebar Title', 'canvys' ); ?></h4>
                           <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</p>
                           <h4 class="header"><?php _e( 'Sidebar Title', 'canvys' ); ?></h4>
                           <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</p>
                        </div>
                        <div>
                           <h2 class="header"><?php _e( 'Alternate Content Header', 'canvys' ); ?></h2>
                           <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.</p>
                           <a href="#" class="accent"><?php _e( 'Normal Link', 'canvys' ); ?></a> <a href="#" class="focused"><?php _e( 'Focused Link', 'canvys' ); ?></a>
                           <br /><div class="secondary-content secondary-bg border-color"><?php _e( 'Secondary content example, with borders', 'canvys' ); ?></div>
                        </div>
                     </div>
                  </section>
                  <footer id="cv-preview-footer" class="cv-preview-footer">
                        <div class="cv-split-3 spacing-2 has-clearfix">
                           <div>
                              <h3 class="header"><?php _e( 'Footer Title', 'canvys' ); ?></h3>
                              <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</p>
                              <div class="secondary-content secondary-bg border-color"><?php _e( 'Secondary content example, with borders', 'canvys' ); ?></div>
                           </div>
                           <div>
                              <h3 class="header"><?php _e( 'Footer Title', 'canvys' ); ?></h3>
                              <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</p>
                              <a href="#" class="accent"><?php _e( 'Normal Link', 'canvys' ); ?></a> <a href="#" class="focused"><?php _e( 'Focused Link', 'canvys' ); ?></a>
                           </div>
                           <div>
                              <h3 class="header"><?php _e( 'Footer Title', 'canvys' ); ?></h3>
                              <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</p>
                           </div>
                        </div>
                  </footer>
                  <div id="cv-preview-socket" class="cv-preview-socket has-clearfix">
                     <strong><span class="header"><?php _e( 'Socket Area', 'canvys' ); ?></span> <?php _e( 'Regular inline text', 'canvys' ); ?></strong>
                     <nav>
                        <a href="#" class="accent"><?php _e( 'Menu Item', 'canvys' ); ?></a>
                        <a href="#" class="focused"><?php _e( 'Focused Menu Item', 'canvys' ); ?></a>
                        <a href="#" class="secondary-content secondary-bg border-color"><?php _e( 'Secondary content with borders', 'canvys' ); ?></a>
                     </nav>
                  </div>
               </div>

               <!-- Color Scheme Control Panel -->
               <div id="cv-scheme-controls">
                  <h2 id="cv-scheme-tabs" class="nav-tab-wrapper cv-scheme-tabs">
                     <?php $counter = 0; foreach ( $canvys['color_scheme_sections'] as $section => $name ) { $counter++;
                        $active_class = 1 === $counter ? ' nav-tab-active' : null;
                        echo '<a class="cv-scheme-tab nav-tab' . $active_class . '" data-section="' . $section . '">' . $name . '</a>';
                     } ?>
                  </h2>
                  <div id="cv-scheme-settings" class="cv-scheme-settings">
                     <?php $counter = 0; foreach ( $canvys['color_scheme_sections'] as $section_slug => $section ) { $counter++;
                        $active_class = 1 === $counter ? ' is-active' : null;
                        echo '<div class="cv-scheme-settings-pane cv-section-' . $section_slug . $active_class . '">';
                        echo '<div class="cv-grid-4 spacing-1 has-clearfix">';
                        foreach ( $canvys['color_scheme_options'] as $slug => $name ) {
                           $saved = isset( $color_scheme['scheme'][$section_slug][$slug] ) ? $color_scheme['scheme'][$section_slug][$slug] : null;
                           $value = $saved ? $saved : $canvys['color_scheme_presets'][$color_scheme['preset']]['scheme'][$section_slug][$slug];
                           echo '<div class="cv-scheme-option option-' . $slug . '">';
                           echo '<div class="cv-option-inner">';
                           echo '<h3>' . $name . '</h3>';
                           echo new CV_HTML( '<input />', array(
                              'class' => 'cv-scheme-control cv-color-picker',
                              'type' => 'text',
                              'name' => 'cv_color_scheme[scheme][' . $section_slug . '][' . $slug . ']',
                              'data-section-name' => $section,
                              'data-option-name' => $name,
                              'data-section' => $section_slug,
                              'data-option' => $slug,
                              'data-update' => 'cv_preview_' . $slug,
                              'autocomplete' => 'off',
                              'value' => $value,
                           ) );
                           echo '</div>';
                           echo '</div>';
                        }
                        echo '</div>';
                        echo '</div>';
                     } ?>
                  </div>
               </div>

               <!-- Color Scheme Submit Box -->
               <div id="cv-schemes-submit-box" class="cv-schemes-submit-box">
                  <input type="submit" name="submit" class="button button-primary button-large" value="<?php _e( 'Save Changes', 'canvys' ); ?>" />
               </div>

            </form>
         </div>
      </div>
   <?php }

   /**
    * Render the color scheme manager help tab
    *
    * @return nothing
    */
   public static function render_help() {

      // Grab the current screen
      $screen = get_current_screen();

   }

   /**
    * Update the customized color scheme
    *
    * @param array $input The user input
    * @return nothing
    */
   public static function update_color_scheme( $input ) {
      return $input;
   }

}
endif;