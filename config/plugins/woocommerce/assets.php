<?php

/**
 * Load all included WooCommerce assets
 */
if ( ! function_exists( 'cv_load_woocommerce_assets' ) ) :

add_action( 'wp_enqueue_scripts', 'cv_load_woocommerce_assets' );

/**
 * Function to load included WooComerce assets
 *
 * @return void
 */
function cv_load_woocommerce_assets() {

   // prevent default lightbox from loading
   wp_dequeue_script( 'prettyPhoto' );

   // Register compressed WooCommerce jQuery file
   wp_register_script('jquery-theme-woocommerce', THEME_PLUGIN_DIR . 'woocommerce/assets/compressed/jquery.woocommerce.min.js', null, THEME_VER, true );

   // Register Primary WooCommerce Stylesheet
   wp_register_style( 'cv-woocommerce', THEME_PLUGIN_DIR . 'woocommerce/assets/woocommerce.css');

   // Enqueue all frontend scripts
   wp_enqueue_script('jquery-theme-woocommerce');

   // Enque all stylesheets
   wp_enqueue_style( 'cv-woocommerce' );

}
endif;