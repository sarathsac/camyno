<?php

if ( ! function_exists( 'cv_load_page_settings_assets' ) ) :

add_action( 'load-post.php',     'cv_load_page_settings_assets' );
add_action( 'load-post-new.php', 'cv_load_page_settings_assets' );


/**
 * Load requred assets for meta boxes
 *
 * @return nothing
 */
function cv_load_page_settings_assets() {

   // Register compressed jQuery meta boxes file
   wp_register_script('cv-page-settings', THEME_DIR . 'config/page-settings/assets/compressed/jquery.page-settings.min.js', array( 'wp-color-picker' ), THEME_VER, true );
   wp_enqueue_script('cv-page-settings');

   // Register CSS meta boxes file
   wp_register_style('cv-page-settings', THEME_DIR . 'config/page-settings/assets/page-settings.css' );
   wp_enqueue_style('cv-page-settings');

}
endif;