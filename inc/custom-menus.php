<?php

// Register custom menus
if ( function_exists('register_nav_menus') ) {

   // Register standard menus
   register_nav_menus( array(
      'header_menu'       => __('Header Menu', 'canvys'),
      'header_menu_user'  => __('Header Menu (Logged In User)', 'canvys'),
      'overlay_menu'       => __('Fullscreen Overlay Menu', 'canvys'),
      'overlay_menu_user'  => __('Fullscreen Overlay Menu (Logged In User)', 'canvys'),
   ) );

   // Secondary menu
   if ( cv_theme_setting( 'header', 'secondary_menu', true ) ) {
      register_nav_menus( array(
         'secondary_menu'      => __('Secondary Header Menu', 'canvys'),
         'secondary_menu_user' => __('Secondary Header Menu (Logged In User)', 'canvys'),
      ) );
   }

   // Socket menu
   if ( cv_theme_setting( 'footer', 'socket_menu', true ) ) {
      register_nav_menus( array(
         'socket_menu'      => __('Socket Menu', 'canvys'),
         'socket_menu_user' => __('Socket Menu (Logged In User)', 'canvys'),
      ) );
   }

}

if ( ! function_exists( 'cv_default_main_menu' ) ) :

/**
 * Helper function to display a default navigation menu
 *
 * @return string
 */
function cv_default_main_menu() {

   // Determine the menu style
   $menu_style = cv_theme_setting( 'header', 'menu_style', 'dropdown' );

   // Determine the menu depth
   $menu_depth = 'modern' == $menu_style ? 2 : 0;

   ob_start();

   echo '<ul class="primary-menu menu ' . $menu_style . '-menu">';
   echo wp_list_pages( array(
      'title_li' => false,
      'depth'    => $menu_depth
   ) );
   echo '</ul>';

   return ob_get_clean();

}
endif;

if ( ! function_exists( 'cv_default_overlay_menu' ) ) :

/**
 * Helper function to display a default overlay navigation menu
 *
 * @return string
 */
function cv_default_overlay_menu() {

   ob_start(); ?>

   <ul class="overlay-menu menu">

   <?php wp_list_pages( array(
      'title_li' => false,
      'depth'    => 2,
   ) ); ?>

   </ul>

   <?php return ob_get_clean();

}
endif;