<?php

if ( ! function_exists( 'cv_eventscalendar_modify_banner_config' ) ) :

/**
 * Adds support for the banner settings meta box to the event post type
 *
 * @param array $screens Screens the banner settings meta box is applied to
 * @return void
 */
function cv_eventscalendar_modify_banner_config( $banner_config ) {

   if ( tribe_get_current_template() ) {
      $banner_config['text_style'] = 'hidden';
      $banner_config['custom_height'] = 0;
   }

   return $banner_config;
}

add_filter( 'cv_banner_config', 'cv_eventscalendar_modify_banner_config' );

endif;