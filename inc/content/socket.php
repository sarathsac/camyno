<?php

// Additional Text
$text = cv_theme_setting( 'footer', 'socket_text' ) ? cv_theme_setting( 'footer', 'socket_text' ) : '&copy; ' . date("Y") . ' ' . get_bloginfo('name');
$copyright = apply_filters( 'cv_socket_copyright', $text ) ? '<p class="socket-text">' . apply_filters( 'cv_socket_copyright', $text ) . '</p>' : null;

// Social Media
if ( $social = cv_get_social_outlets( cv_theme_setting( 'footer', 'social_outlets' ) ) ) {
   $social->add_class( 'socket-social' );
   $social->attr( 'id', 'socket-social' );
}

// Socket Menu
$menu = null;
if ( cv_theme_setting( 'footer', 'socket_menu' ) ) {

   // Determine which menu location to show
   $location = is_user_logged_in() && has_nav_menu('socket_menu_user') ? 'socket_menu_user' : 'socket_menu';

   // grab the menu
   $secondary_menu = wp_nav_menu( array(
      'theme_location' => $location,
      'fallback_cb'    => '__return_false',
      'container'      => false,
      'echo'           => false,
      'depth'          => 1,
      'menu_class'     => 'socket-menu menu',
   ) );

   if ( $secondary_menu ) {
      $menu .= '<nav class="socket-menu" id="socket-menu">';
      $menu .= $secondary_menu;
      $menu .= '</nav>';
   }

}

// Combine the contents
$layout = cv_theme_setting( 'footer', 'socket_layout', 'inline' );
switch ( $layout ) {
   case 'centered': $socket_content = $menu . $social . $copyright; break;
   default: $socket_content = $copyright . $social . $menu;
}

// Display the socket area
echo cv_content_section( array(
   'class' => 'layout-' . $layout,
   'color_scheme' => 'socket',
   'apply_filters' => false,
   'id' => 'socket',
   'padding_bottom' => 'less',
   'padding_top' => 'less',
), $socket_content );