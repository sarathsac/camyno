<?php

// grab the menu style
$menu_style = cv_theme_setting( 'header', 'menu_style', 'dropdown' );

// If modern or dropdown menu is active
if ( in_array( $menu_style, array( 'dropdown', 'modern' ) ) ) {

   // Determine which menu location to show
   $location = is_user_logged_in() && has_nav_menu('header_menu_user') ? 'header_menu_user' : 'header_menu';

   // Determine the menu depth
   $menu_depth = 'modern' == $menu_style ? 2 : 0;

   // Grab the menu
   $menu = wp_nav_menu( array(
      'theme_location' => $location,
      'fallback_cb'    => 'cv_default_main_menu',
      'container'      => false,
      'echo'           => false,
      'depth'          => $menu_depth,
      'menu_class'     => "primary-menu menu {$menu_style}-menu",
   ) );

}

// If overlay menu is in use
else if ( 'overlay' == $menu_style ) {
   $menu = false;
} ?>

<div id="primary-navigation" class="navigation-container"><?php

   // Display the main menu
   if ( isset( $menu ) && $menu ) {
      echo '<nav class="primary-menu-wrapper visible-over-3" id="primary-menu">';
      echo $menu;
      do_action( 'cv_primary_menu' );
      echo '</nav>';
   }

   // Display navigation tools
   $responsive = cv_theme_setting( 'general', 'disable_responsive' ) ? false : true;
   $show_search = cv_theme_setting( 'header', 'search', true );
   $show_additional = cv_is_additional_bar_active();
   $show_social = cv_theme_setting( 'header', 'enable_social' ) && 'inline' == cv_theme_setting( 'header', 'social_position', 'right' ) && cv_get_social_outlets( cv_theme_setting( 'header', 'social_outlets' ) ) ? true : false;

   // Display the divider by default
   $show_divider_class = $show_search || $show_social ? true : false;
   $show_divider_class = apply_filters( 'cv_show_tools_divider', $show_divider_class ) ? ' show-divider' : null;

   if ( 'overlay' == $menu_style || $responsive || $show_search || has_action( 'cv_primary_tools' ) ) {
      echo '<nav class="primary-tools' . $show_divider_class . '" id="primary-tools">';
      if ( 'overlay' == $menu_style || $responsive )  echo '<a class="launch-fullscreen-overlay menu-button is-inline" data-overlay="cv-overlay-menu"><i class="icon-menu"></i></a>';
      if ( $show_search ) echo '<a class="search-button launch-fullscreen-overlay" data-overlay="cv-overlay-search"><i class="icon-search-1"></i></a>';
      if ( $responsive && $show_additional ) echo '<a class="launch-fullscreen-overlay visible-under-3" data-overlay="cv-overlay-additional"><i class="icon-plus"></i></a>';
      do_action( 'cv_primary_tools' );
      echo '</nav>';
   }

   // Display social media
   if ( cv_theme_setting( 'header', 'enable_social' ) && 'inline' == cv_theme_setting( 'header', 'social_position', 'right' ) ) {
      if ( $profiles = cv_get_social_outlets( cv_theme_setting( 'header', 'social_outlets' ) ) ) {
         $profiles->add_class( 'primary-social visible-over-3' );
         ob_start(); do_action('cv_header_inline_social'); $profiles->append( ob_get_clean() );
         echo $profiles;
      }
   }

   do_action( 'cv_primary_navigation'); ?>

<!-- End .navigation-container -->
</div>