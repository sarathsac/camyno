<?php

// Secondary menu
if ( cv_theme_setting( 'header', 'secondary_menu' ) ) {

   // Determine which menu location to show
   $location = is_user_logged_in() && has_nav_menu('secondary_menu_user') ? 'secondary_menu_user' : 'secondary_menu';

   // grab the menu
   $secondary_menu = wp_nav_menu( array(
      'theme_location' => $location,
      'fallback_cb'    => '__return_false',
      'container'      => false,
      'echo'           => false,
      'depth'          => 1,
      'menu_class'     => 'menu',
   ) );

   // Left or right orientation
   $menu_position = cv_theme_setting( 'header', 'secondary_menu_position' );

   // Display the secondary menu
   if ( $secondary_menu ) {
      echo '<nav class="header-additional-menu" data-position="' . $menu_position . '">';
      echo $secondary_menu;
      echo '</nav>';
   }

}

// Social Media
$saved_outlets = cv_theme_setting( 'header', 'social_outlets' );
if ( cv_theme_setting( 'header', 'enable_social' ) && 'inline' != cv_theme_setting( 'header', 'social_position', 'right' ) && ! empty( $saved_outlets ) ) {

   // Left or right orientation
   $social_position = cv_theme_setting( 'header', 'social_position' );

   if ( $profiles = cv_get_social_outlets( $saved_outlets ) ) {
      $profiles->data( 'position', $social_position );
      echo $profiles;
   }

}

// Display any additional text
if ( $additional_text = cv_theme_setting( 'header', 'additional_text' ) ) {

   // Create the object
   $additional_text = new CV_HTML( '<p>', array(
      'class'   => 'header-additional-text',
      'id'      => 'header-additional-text',
      'content' => $additional_text,
   ) );

   // Apply float style
   $additional_text->data( 'position', cv_theme_setting( 'header', 'additional_text_position' ) );

   echo $additional_text;

}