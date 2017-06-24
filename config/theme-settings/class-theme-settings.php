<?php

if ( ! class_exists('CV_Theme_Settings') ) :

/**
 * Front End Color Scheme
 * used to manage the theme color scheme
 *
 * @package    WordPress
 * @subpackage Canvys
 * @since      Version 1.0
 */
class CV_Theme_Settings {

   /**
    * Initially load the theme settings
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

      global $canvys;

      // Gather the default settings
      // update_option( 'cv_theme_settings', apply_filters( 'cv_theme_settings_gather_defaults', array() ) );

      $saved = get_option( 'cv_theme_settings' );
      $defaults = apply_filters( 'cv_theme_settings_gather_defaults', array() );

      foreach ( $defaults as $page => $values ) {
         if ( ! isset( $saved[$page] ) || empty( $saved[$page] ) ) {
            $saved[$page] = $values;
         }
      }

      update_option( 'cv_theme_settings', $saved );

      // Make sure the option exists
      if ( ! get_option( 'cv_theme_settings' ) ) {
         $defaults = apply_filters( 'cv_theme_settings_gather_defaults', array() );
         add_option( 'cv_theme_settings', $defaults );
      }

      // Register the setting with its callback
      if ( method_exists( $this, 'update_theme_settings' ) ) {
         register_setting('cv_theme_settings', 'cv_theme_settings', array( $this, 'update_theme_settings' ) );
      }

   }

   /**
    * Load required assets
    *
    * @return nothing
    */
   public function load_assets( $hook ) {

      // Make sure we're on the right page
      if ( 'appearance_page_cv-theme-settings' != $hook ) {
         return;
      }

      // Load the media uploader scripts
      wp_enqueue_media();

      // Admin assets directory
      $dir = THEME_DIR . 'config/theme-settings/assets/';

      // Load color picker stylesheet
      wp_enqueue_style( 'wp-color-picker' );

      // Load theme icons stylesheet
      wp_enqueue_style( 'cv-icons', THEME_DIR . 'assets/css/icons.css' );

      // Load the base stylesheet
      wp_enqueue_style( 'cv-theme-settings', $dir . 'theme-settings.css' );

      // Load the theme settings script
      wp_enqueue_script( 'cv-theme-settings', $dir . 'compressed/jquery.theme-settings.min.js', array('wp-color-picker') );

      // Load inline styles
      add_action( 'admin_head', array( $this, 'load_inline_styles' ) );

      // Load inline javascript
      add_action( 'admin_footer', array( $this, 'load_inline_scripts' ) );

   }

   /**
    * Loads inline styles provided by the pages
    *
    * @return nothing
    */
   public function load_inline_styles() {
      do_action( 'cv_theme_settings_inline_styles' );
   }

   /**
    * Loads inline scripts provided by the pages
    *
    * @return nothing
    */
   public function load_inline_scripts() {
      do_action( 'cv_theme_settings_inline_scripts' );
   }

   /**
    * Create the menu pages
    *
    * @return nothing
    */
   public function create_menu() {

      global $canvys;

      $page = add_theme_page(
         __( 'Theme Settings', 'canvys' ),
         __( 'Theme Settings', 'canvys' ),
         'edit_theme_options',
         'cv-theme-settings',
         array( $this, 'render_page' )
      );

      // Add the help tab
      add_action( 'load-' . $page, array( $this, 'render_help' ) );

   }

   /**
    * Render the color scheme manager page
    *
    * @return nothing=
    */
   public static function render_page() {

      $notification = null;
      if ( isset( $_GET['settings-updated'] ) && $_GET['settings-updated'] ) {

         // Display a saved message
         $notification  = '<div class="updated below-h2">';
         $notification .= '<p>' . sprintf( __( 'Settings updated. <a href="%s">Visit your site</a> to see how it looks.', 'canvys' ), get_home_url() ) . '</p>';
         $notification .= '</div>';

      } ?>

      <div class="wrap cv-admin-page cv-admin-theme_settings">
         <h2><?php _e( 'Theme Settings', 'canvys' ); ?></h2>
         <?php echo $notification; ?>
         <form id="cv_theme_settings" method="post" action="options.php">

            <div class="settings-submit-box">
               <input class="button button-large restore-defaults" type="submit" name="cv_theme_settings[restore_defaults]" value="<?php _e( 'Restore Defaults', 'canvys' ); ?>" />
               <input class="button button-large button-primary" type="submit" name="cv_theme_settings[save_settings]" value="<?php _e( 'Save Settings', 'canvys' ); ?>" />
            </div>

            <div class="cv-theme-settings has-clearfix" id="cv-theme-settings">

               <?php
                  // Load WordPress required fields
                  settings_errors('cv_theme_settings');
                  settings_fields('cv_theme_settings'); ?>

               <div class="cv-split-14-34 has-clearfix not-responsive">

                  <div>
                     <nav class="cv-theme-settings-tabs" id="cv-theme-settings-tabs">
                        <?php do_action( 'cv_theme_settings_render_menu', get_option('cv_theme_settings') ); ?>
                     </nav>
                  </div>

                  <div>
                     <div class="cv-theme-settings-panes" id="cv-theme-settings-panes">
                        <?php do_action( 'cv_theme_settings_render_pages', get_option('cv_theme_settings') ); ?>
                     </div>
                  </div>

               </div>

            </div>

            <div class="settings-submit-box">
               <input class="button button-large restore-defaults" type="submit" name="cv_theme_settings[restore_defaults]" value="<?php _e( 'Restore Defaults', 'canvys' ); ?>" />
               <input class="button button-large button-primary" type="submit" name="cv_theme_settings[save_settings]" value="<?php _e( 'Save Settings', 'canvys' ); ?>" />
            </div>

         </form>
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
   public static function update_theme_settings( $input ) {

      if ( isset( $input['restore_defaults'] ) ) {
         $input = apply_filters( 'cv_theme_settings_gather_defaults', array() );
      }
      return apply_filters( 'cv_theme_settings_sanitize_input', $input );

   }

}
endif;