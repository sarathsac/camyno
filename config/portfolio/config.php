<?php

// The labels used throughout the theme
if ( ! defined( 'CV_PORTFOLIO_SINGULAR_LABEL' ) ) {
   $default = __( 'Project', 'canvys' );
   $label = cv_theme_setting( 'portfolio', 'singular_label', $default );
   $label = $label ? $label : $default;
   define( 'CV_PORTFOLIO_SINGULAR_LABEL', $label );
}
if ( ! defined( 'CV_PORTFOLIO_PLURAL_LABEL' ) ) {
   $default = __( 'Projects', 'canvys' );
   $label = cv_theme_setting( 'portfolio', 'plural_label', $default );
   $label = $label ? $label : $default;
   define( 'CV_PORTFOLIO_PLURAL_LABEL', $label );
}

if ( ! function_exists( 'cv_register_portfolio_post_type' ) ) :

add_action( 'init', 'cv_register_portfolio_post_type' );

/**
 * Register the included portfoli post type
 *
 * @return void
 */
function cv_register_portfolio_post_type() {

   register_post_type( 'portfolio_item', array(

      'labels' => array(
         'name' => __('Portfolio', 'canvys'),
         'singular_name' => __('Portfolio Item', 'canvys'),
         'add_new' => __('Add New Item', 'Portfolio Item', 'canvys'),
         'add_new_item' => __('Add New Portfolio Item', 'canvys'),
         'edit_item' => __('Edit Portfolio Item', 'canvys'),
         'new_item' => __('New Portfolio Item', 'canvys'),
         'view_item' => __('View Portfolio Item', 'canvys'),
         'search_items' => __('Search Portfolio Items', 'canvys'),
         'not_found' =>  __('No Portfolio Items found', 'canvys'),
         'not_found_in_trash' => __('No Portfolio Items found in Trash', 'canvys'),
         'parent_item_colon' => ''
      ),

      'public' => true,
      'supports' => array( 'title', 'thumbnail', 'editor', 'comments', 'custom-fields' ),
      'exclude_from_search' => false,
      'has_archive' => true

   ) );

   register_taxonomy('portfolio_categories', 'portfolio_item', array(

      'hierarchical' => false,

      'labels' => array(
         'name' => _x('Portfolio Category', 'taxonomy general name', 'canvys'),
         'singular_name' => __('Portfolio Category', 'taxonomy singular name', 'canvys'),
         'search_items' =>  __('Search Portfolio Categories', 'canvys'),
         'all_items' => __('All Portfolio Categories', 'canvys'),
         'edit_item' => __('Edit Portfolio Category', 'canvys'),
         'update_item' => __('Update Portfolio Category', 'canvys'),
         'add_new_item' => __('Add New Portfolio Category', 'canvys'),
         'new_item_name' => __('New Portfolio Category Name', 'canvys'),
         'menu_name' => __('Portfolio Categories', 'canvys'),
      ),

      'rewrite' => array(
         'slug' => 'type',
         'with_front' => false,
         'hierarchical' => false
      ),

   ) );

}
endif;