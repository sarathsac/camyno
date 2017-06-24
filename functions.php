<?php

global $canvys;

/**
 * The general functionality of our theme
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @package    WordPress
 * @subpackage Canvys
 * @since      Version 1.0
 */

/**
 * Include/activate the theme functionality
 */
get_template_part( 'functions', 'canvys' );

// Setup the theme
add_action( 'after_setup_theme', 'cv_theme_setup' );

if ( ! function_exists( 'cv_theme_setup' ) ) :

/**
 * Setup the theme
 *
 * This function will do all of the following:
 * - Make sure theme is translatable
 *
 * @return void
 */
function cv_theme_setup() {

   global $content_width, $canvys;

   /**
    * Make our theme available for translation.
    *
    * Translations can be added to the /lang/ directory.
    */
   load_theme_textdomain( 'canvys', get_template_directory() . '/lang' );

   /**
    * Switch default core markup for search form, comment form, and comments
    * to output valid HTML5.
    */
   add_theme_support( 'html5', array(
      'search-form', 'comment-form', 'comment-list'
   ) );

   /**
    * Automatic Feed Links
    * This feature adds RSS feed links to HTML <head>
    */
   add_theme_support( 'automatic-feed-links' );

   /**
    * Change maximum content width
    */
   if ( ! isset( $content_width ) ) $content_width = 1200;

   // Add support for the Themefyre Page Builder plugin.
   $targets = array(
      '.cv-logo .displayed-title' => esc_html__( 'Site Title', 'camyno' ),
      '#header .navigation-container .primary-menu.dropdown-menu > li > a, #header .navigation-container .primary-menu.modern-menu > li > a' => esc_html__( 'Header Top Level Menu Items', 'camyno' ),
      '#header .navigation-container .primary-menu.dropdown-menu ul a, #header .navigation-container .primary-menu.modern-menu ul a' => esc_html__( 'Header Secondary Level Menu Items', 'camyno' ),
      '.cv-fullscreen-overlay.overlay-menu-wrap .overlay-menu > li > a' => esc_html__( 'Overlay Top Level Menu Items', 'camyno' ),
      '.cv-fullscreen-overlay.overlay-menu-wrap .overlay-menu > li ul a' => esc_html__( 'Overlay Secondary Level Menu Items', 'camyno' ),
      '.cv-header-style-hero-title' => esc_html__( 'Hero Title', 'camyno' ),
      '.cv-header-style-hero-tagline' => esc_html__( 'Hero Tagline', 'camyno' ),
      '.widget .widget-title' => esc_html__( 'Widget Titles', 'camyno' ),
      // '' => esc_html__( '', 'camyno' ),
      // '' => esc_html__( '', 'camyno' ),
      // '' => esc_html__( '', 'camyno' ),
      // '' => esc_html__( '', 'camyno' ),
      // '' => esc_html__( '', 'camyno' ),
      // '' => esc_html__( '', 'camyno' ),
      // '' => esc_html__( '', 'camyno' ),
      // '' => esc_html__( '', 'camyno' ),
   );
   if ( class_exists( 'woocommerce') ) {
      $targets = array_merge( $targets, array(
         // 'body.single-product .product .entry-title' => esc_html__( 'Single Product Title', 'camyno' ),
         // 'body.single-product .product .price' => esc_html__( 'Single Product Price', 'camyno' ),
      ) );
   }
   add_theme_support( 'themefyre-typography', array(
      'targets'  => $targets,
      'force_important' => true,
   ) );

   /* Register required image sizes
    * =========================================== */

   // begin by adding support for thumbnails
   add_theme_support( 'post-thumbnails' );

   $canvys['img_sizes'] = array(

      /**
       * Varous sized "square" thumbnails for use by shortcodes
       * All sizes below are required
       */
      'cv_square_small' => array(
         'width'  => 150,
         'height' => 150,
         'crop'   => true,
      ),
      'cv_square_medium' => array(
         'width'  => 350,
         'height' => 350,
         'crop'   => true,
      ),
      'cv_square_large' => array(
         'width'  => 650,
         'height' => 650,
         'crop'   => true,
      ),
      'cv_square_tall' => array(
         'width'  => 750,
         'height' => 9999,
         'crop'   => false,
      ),

      /**
       * Varous sized images to be used as featured images
       * All sizes below are required
       */
      'cv_featured_tall' => array(
         'width'  => 1200,
         'height' => 99999,
         'crop'   => false,
      ),
      'cv_featured_large' => array(
         'width'  => 1200,
         'height' => 550,
         'crop'   => true,
      ),

      /**
       * largest image size used in theme
       */
      'cv_full' => array(
         'width'  => 1680,
         'height' => 9999,
         'crop'   => false,
      ),

   );

   foreach ( $canvys['img_sizes'] as $slug => $config ) {
      add_image_size( $slug, $config['width'], $config['height'], $config['crop'] );
   }

}
endif;

if ( ! function_exists( 'cv_theme_activated' ) ) :

add_action('after_switch_theme', 'cv_theme_activated');

/**
 * After theme activation
 *
 * @return void
 */
function cv_theme_activated() {

   // Display the quick start guide
   add_action('admin_notices', 'cv_quick_start_notice');

}

/**
 * Quick start guide
 *
 * @return void
 */
function cv_quick_start_notice() { ?>
   <div class="updated">
      <h3><?php _e( 'Welcome to Camyno!', 'canvys' ); ?></h3>
      <p><?php _e( 'We hope you enjoy creating with this theme as much as we did making it. Here are some pages to help get you started.', 'canvys' ); ?></p>
      <p>
         <a class="button button-primary" style="text-decoration: none;" href="<?php echo admin_url('themes.php?page=cv-theme-settings'); ?>">
            <?php _e( 'Customize settings', 'canvys' ); ?>
         </a>
         <a class="button" style="text-decoration: none;" href="<?php echo admin_url('themes.php?page=cv-color-scheme'); ?>">
            <?php _e( 'Choose a color scheme', 'canvys' ); ?>
         </a>
      </p>
   </div>
<?php }

endif;

// Register your custom function to override some LayerSlider data
function cv_layerslider_overrides() {

   // Disable auto-updates
   $GLOBALS['lsAutoUpdateBox'] = false;
}
add_action('layerslider_ready', 'cv_layerslider_overrides');

/**
 * Automatic updates
 *
 * Because this theme is not available through the WordPress repository updates
 * need to be supplied manually.
 */
require_once('inc/wp-updates-theme.php');
new WPUpdatesThemeUpdater_1844( 'http://wp-updates.com/api/2/theme', basename( get_template_directory() ) );