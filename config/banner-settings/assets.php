<?php

if ( ! function_exists( 'cv_load_banner_settings_assets' ) ) :

add_action( 'load-post.php',     'cv_load_banner_settings_assets' );
add_action( 'load-post-new.php', 'cv_load_banner_settings_assets' );


/**
 * Load requred assets for meta boxes
 *
 * @return nothing
 */
function cv_load_banner_settings_assets() {

   // Register compressed jQuery meta boxes file
   wp_register_script('cv-banner-settings', THEME_DIR . 'config/banner-settings/assets/compressed/jquery.banner-settings.min.js', array( 'wp-color-picker' ), THEME_VER, true );
   wp_enqueue_script('cv-banner-settings');

   // Register CSS meta boxes file
   wp_register_style('cv-banner-settings', THEME_DIR . 'config/banner-settings/assets/banner-settings.css' );
   wp_enqueue_style('cv-banner-settings');

}
endif;