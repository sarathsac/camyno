<?php

if ( ! function_exists( 'cv_extend_widgets' ) ) :

// Register Custom Widgets
add_action( 'widgets_init', 'cv_extend_widgets' );

/**
 * Helper function to register custom widgets
 *
 * @return nothing
 */
function cv_extend_widgets() {

   // List of custom widgets
   $widgets = array(
      'recent_posts',
      'recent_portfolio',
      'qr_code',
      'google_map',
      'social_media',
      'twitter_rss',
   );

   // Register each custom widget
   foreach ( $widgets as $widget ) {
      register_widget( 'cv_' . $widget . '_widget' );
   }

}
endif;