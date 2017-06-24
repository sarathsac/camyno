<?php

if ( ! class_exists('CV_Sidebar_Manager') ) :

/**
 * Sidebar Manager
 * used to manage custom sidebars
 *
 * @package    WordPress
 * @subpackage Canvys
 * @since      Version 1.0
 */
class CV_Sidebar_Manager {

   /**
    * Initially load the sidebar manager
    *
    * @return void
    */
   public function __construct() {

      add_action( 'init', array( $this, 'check_capabilities' ) );

      // Array containing each AJAX action
      $ajax_actions = array(
         'add_sidebar',
         'delete_sidebar',
      );

      // register each AJAX action
      foreach ( $ajax_actions as $action ) {
         add_action('wp_ajax_' . 'cv_ajax_' . $action, array( $this, $action . '_callback' ) );
         add_action('wp_ajax_nopriv_' . 'cv_ajax_' . $action, array( $this, $action . '_callback' ) );
      }

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

      // Load the assets
      add_action( 'load-widgets.php', array( $this, 'load_assets' ) , 5 );

   }

   /**
    * Initially create the option in the database
    *
    * @return nothing
    */
   public function init() {

      $default = array();

      // Make sure the option exists
      if ( ! get_option( 'cv_sidebars' ) ) {
         add_option( 'cv_sidebars', $default );
      }

   }

   /**
    * Load the required assets
    *
    * @return nothing
    */
   public function load_assets() {

      global $canvys;

      // Insert the sidebar generator template
      add_action( 'admin_print_scripts', array( $this, 'sidebar_generator_template' ) );

      $dir = THEME_DIR . 'config/widget-areas/assets/';

      // Load google maps API
      $api_key = cv_theme_setting( 'advanced', 'google_maps_api_key' );
      $google_maps_api_url = $api_key ? '://maps.googleapis.com/maps/api/js?key='.$api_key : '://maps.google.com/maps/api/js?sensor=true';
      wp_enqueue_script('cv-gmaps-api', is_ssl() ? 'https'.$google_maps_api_url : 'http'.$google_maps_api_url, null, THEME_VER, false );

      // Load theme icons stylesheet
      wp_enqueue_style( 'cv-icons', THEME_DIR . 'assets/css/icons.css' );

      // Widget options script
      wp_enqueue_script( 'cv-widget-options' , $dir . 'compressed/jquery.widget-options.min.js' );
      wp_localize_script( 'cv-widget-options', 'cv_widget_options_localize', $canvys['widget_options_localization'] );

      // Sidebar manager script
      wp_enqueue_script( 'cv-sidebar-manager' , $dir . 'compressed/jquery.sidebar-manager.min.js' );
      wp_localize_script( 'cv-sidebar-manager', 'cv_sidebar_manager_localize', $canvys['sidebar_manager_localization'] );

      // Sidebar manager styles
      wp_enqueue_style( 'cv-sidebar-manager' , $dir . 'sidebar-manager.css' );

   }

   /**
    * The template for the sidebar generator
    *
    * @return nothing
    */
   public static function sidebar_generator_template() { ?>
      <script type="text/html" id="tmpl-cv-sidebar-manager">
         <div class="cv-sidebar-generator">
            <h3><?php _e( 'New Sidebar', 'canvys' ); ?></h3>
            <input id="cv-new-sidebar-name" placeholder="<?php _e( 'New sidebar name', 'canvys' ); ?>" />
            <a id="cv-create-new-sidebar" class="button button-large button-primary"><?php _e( 'Add Sidebar', 'canvys' ); ?></a>
         </div>
      </script>
   <?php }

   /**
    * AJAX calback for adding a new sidebar
    *
    * @return nothing
    */
   public function add_sidebar_callback() {

      $existing = get_option( 'cv_sidebars' );

      // Make sure the option exists
      if ( ! is_array( $existing ) ) {
         $existing = array();
      }

      // Grab the name
      $name = $_POST['sidebar_name'];

      $existing[cv_slug($name)] = $name;

      update_option( 'cv_sidebars', $existing );

      die();

   }

   /**
    * AJAX calback for deleting a sidebar
    *
    * @return nothing
    */
   public function delete_sidebar_callback() {

      $existing = get_option( 'cv_sidebars' );

      // Make sure the option exists
      if ( ! is_array( $existing ) ) {
         $existing = array();
      }

      // Grab the name
      $id = $_POST['sidebar_id'];

      if ( array_key_exists( $id, $existing ) ) {
         unset( $existing[$id] );
      }

      update_option( 'cv_sidebars', $existing );

      die();

   }

}
endif;