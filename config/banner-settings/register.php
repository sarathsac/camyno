<?php

if ( ! function_exists( 'cv_register_banner_settings' ) ) :

/**
 * Helper function to register included meta boxes
 *
 * @return nothing
 */
function cv_register_banner_settings() {

   $post_types = apply_filters( 'cv_banner_settings_post_types', array( 'page', 'portfolio_item' ) );

   foreach ( $post_types as $post_type ) {

      add_meta_box(
         THEME_SLUG . '_banner-settings_meta_box',
         sprintf( __( '%s Banner Settings', 'canvys' ), THEME_NAME ),
         'cv_banner_settings_meta_box',
         $post_type,
         'normal',
         'default'
      );

   }

}
endif;