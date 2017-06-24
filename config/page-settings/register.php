<?php

if ( ! function_exists( 'cv_register_page_settings' ) ) :

/**
 * Helper function to register included meta boxes
 *
 * @return nothing
 */
function cv_register_page_settings() {

   add_meta_box(
      THEME_SLUG . '_page_settings_meta_box',
      sprintf( __( '%s Page Settings', 'canvys' ), THEME_NAME ),
      'cv_page_settings_meta_box',
      'page',
      'side',
      'default'
   );

   add_meta_box(
      THEME_SLUG . '_meta_box',
      sprintf( __( '%s Page Settings', 'canvys' ), THEME_NAME ),
      'cv_page_settings_meta_box',
      'portfolio_item',
      'side',
      'default'
   );

}
endif;