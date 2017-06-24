<?php

if ( ! function_exists( 'cv_register_widget_areas' ) ) :

/**
 * Helper function to initiate both standard and cusom widget areas
 *
 * @return nothing
 */
function cv_register_widget_areas() {

   // Register all widget areas
   foreach ( cv_get_sidebars() as $id => $config ) {

      $description = isset( $config['desc'] ) ? $config['desc'] : null;

      register_sidebar( array(
         'id'            => $id,
         'name'          => $config['name'],
         'description'   => $description,
         'before_widget' => '<aside class="widget has-clearfix">',
         'after_widget'  => '</aside>',
         'before_title'  => '<h3 class="widget-title">',
         'after_title'   => '</h3>'
      ) );

   }

}
endif;