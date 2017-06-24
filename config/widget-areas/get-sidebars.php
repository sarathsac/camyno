<?php

if ( ! function_exists( 'cv_get_sidebars' ) ) :

/**
 * Helper function to return a list of registered widget areas
 *
 * @return array
 */
function cv_get_sidebars() {

   // Begin array with default sidebars
   $areas = array(

      'sidebar' => array(
         'name' => __( 'Default Sidebar', 'canvys' ),
         'desc' => __( 'Displayed everywhere when the Page, Portfolio Item, or Blog sidebar has not been utilized nor a custom sidebar.', 'canvys' )
      ),

      'page_sidebar' => array(
         'name' => __( 'Page Sidebar', 'canvys' ),
         'desc' => __( 'Displayed on all pages where a custom sidebar cannot be specified, or when a custom sidebar has not been specified. The default sidebar will be used if this sidebar is not active.', 'canvys' )
      ),

      'blog_sidebar' => array(
         'name' => __( 'Blog Sidebar', 'canvys' ),
         'desc' => __( 'Displayed on all blog related pages (Posts page, archives, single post pages, etc). The default sidebar will be used if this sidebar is not active.', 'canvys' )
      ),

      'portfolio_sidebar' => array(
         'name' => __( 'Portfolio Sidebar', 'canvys' ),
         'desc' => __( 'The default sidebar for all portfolio items, will be displayed when a custom sidebar has not been specified. The default sidebar will be used if this sidebar is not active.', 'canvys' )
      ),

      'search_sidebar' => array(
         'name' => __( 'Search Page Sidebar', 'canvys' ),
         'desc' => __( 'The sidebar displayed on search results pages. The default sidebar will be used if this sidebar is not active.', 'canvys' )
      ),

   );

   // ALlow other sidebars to be registered here
   $areas = apply_filters( 'cv_registered_sidebars', $areas );

   // Only show appropriate number of footer columns
   if ( cv_theme_setting( 'footer', 'enable_widgets', true ) ) {

      // Determine number of columns to display
      switch ( $layout = cv_theme_setting( 'footer', 'layout', '13' ) ) {

         case '12': $number_columns = 2; break;
         case '13': $number_columns = 3; break;
         case '14': $number_columns = 4; break;
         case '15': $number_columns = 5; break;
         case '16': $number_columns = 6; break;

         default:
            $number_columns = explode( '-', $layout );
            $number_columns = count( $number_columns );
            break;

      }

      // Add the appropriate number of widget areas
      for ( $i=1; $i<=$number_columns; $i++ ) {
         $areas["footer_column_{$i}"] = array(
            'name' => sprintf( __( 'Footer - Column %s', 'canvys' ), $i ),
         );
      }

   }

   // grab user sidebars, if any
   $user_sidebars = get_option( 'cv_sidebars' );

   // If any custom sidebars are available, create them
   if ( is_array( $user_sidebars ) ) {
      foreach ( $user_sidebars as $id => $name ) {
         $areas['cv_user_sidebar_' . $id] = array(
            'name' => $name,
         );
      }
   }

   return $areas;
}
endif;