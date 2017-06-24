<?php

if ( ! class_exists('CV_Recent_Portfolio') ) :

/**
 * Recent Portfolio Items
 *
 * @package      WordPress
 * @subpackage   Canvys
 * @since        Version 1.0
 */
class CV_Recent_Portfolio extends CV_Shortcode {

   /**
    * Function to create shortcode configuration
    *
    * @return void
    */
   public function __construct() {

      global $canvys;

      $this->config = array(

         // Handle will be used to use this shortcode
         'handle' => 'cv_recent_portfolio',

         // Whether or not this is a shortcode composer element
         'composer_element' => true,

         // Whether or not this is a template builder element
         'builder_element' => true,

         // Used by the template builder to determine where module can be dropped
         'drop_target' => 2,

         // Used by the template builder to determine where module can have other
         // modules dropped inside of it
         'drop_zone' => false,

         // Title will be used to identify this shortcode
         'title' => __( 'Recent portfolio Items', 'canvys' ),

         // Icon will be used to represent this shortcode in composer/builder
         // List of available icons can be found in icons.json
         'icon' => 'box',

         // Whether or not shortcode is self closing
         'self_closing' => true,

         // If shortcode is not self closing, specify its default content
         'default_content' => null,

         // Specify whether or not content is directly editable
         'content_editor' => false,

         // Specify whether or not the content is composed of another shortcode
         'content_element' => false,

         // Array of shortcode settings and their respective attributes
         'attributes' => array(

            new CV_Shortcode_Text_Control( 'title', array(
               'title'       => __( 'Title', 'canvys' ),
               'description' => __( 'Recent portfolio items title, will be displayed immediately before the portfolio items.', 'canvys' ),
            ) ),

            new CV_Shortcode_Select_Control( 'tile_type', array(
               'title'         => __( 'Tile Type', 'canvys' ),
               'description'   => __( 'Specify which tile type should be displayed for each post.', 'canvys' ),
               'default'       => 'standard',
               'options'       => array(
                  'standard' => __( 'Standard, title below featured content', 'canvys' ),
                  'tile'     => __( 'Compact post tile', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Portfolio_category_Select_Control( 'cat_slug', array(
               'title'         => __( 'Category', 'canvys' ),
               'description'   => __( 'Specify a category for portfolio items to be pulled from.', 'canvys' ),
               'default'       => 'none',
            ) ),

            new CV_Shortcode_Select_Control( 'thumbnails', array(
               'title'         => __( 'Post Thumbnails Handling', 'canvys' ),
               'description'   => __( 'Specify how portfolio items with featured images should be handled.', 'canvys' ),
               'default'       => 'normal',
               'options'       => array(
                  'normal'  => __( 'Display post thumbnails normally', 'canvys' ),
                  'require' => __( 'Only show portfolio items which have thumbnails', 'canvys' ),
                  'hide'    => __( 'Do not display post thumbnails at all', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Number_Control( 'num_posts', array(
               'title'       => __( 'Number of Portoflio Items', 'canvys' ),
               'description' => __( 'Specify the maximum number of portfolio items that can be displayed, leave blank to not set a maximum.', 'canvys' ),
               'placeholder' => __( 'As many as possible', 'canvys' ),
            ) ),

            new CV_Shortcode_Select_Control( 'style', array(
               'title'         => __( 'Style', 'canvys' ),
               'description'   => __( 'Specify how these recent portfolio items should be displayed.', 'canvys' ),
               'default'       => 'grid',
               'options'       => array(
                  'grid'    => __( 'Grid', 'canvys' ),
                  'slider'  => __( 'Slider', 'canvys' ),
                  'carousel'  => __( 'Carousel', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Slider_Control( 'slider_config', array(
               'title'       => __( 'Slider Configuration', 'canvys' ),
               'description' => __( 'Specify how this slider should behave.', 'canvys' ),
            ) ),

            new CV_Shortcode_Carousel_Control( 'carousel_config', array(
               'title'       => __( 'Carousel Configuration', 'canvys' ),
               'description' => __( 'Specify how this carousel should behave.', 'canvys' ),
            ) ),

            new CV_Shortcode_Select_Control( 'columns', array(
               'title'       => __( 'Number of Columns', 'canvys' ),
               'description' => __( 'Specify how many columns should be used to display these recent portfolio items.', 'canvys' ),
               'default'     => '3',
               'options'     => array(
                  '2' => __( '2 Columns', 'canvys' ),
                  '3' => __( '3 Columns', 'canvys' ),
                  '4' => __( '4 Columns', 'canvys' ),
                  '5' => __( '5 Columns', 'canvys' ),
                  '6' => __( '6 Columns', 'canvys' ),
                  '7' => __( '7 Columns', 'canvys' ),
                  '8' => __( '8 Columns', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Select_Control( 'spacing', array(
               'title'         => __( 'Spacing', 'canvys' ),
               'description'   => __( 'Specify the amount of spacing that should be used to separate the columns', 'canvys' ),
               'default'       => '2',
               'options'       => array(
                  'none' => __( 'None', 'canvys' ),
                  '1'    => __( 'Less', 'canvys' ),
                  '2'    => __( 'Normal', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Select_Control( 'ratio', array(
               'title'       => __( 'Tile Proportions (Width X Height)', 'canvys' ),
               'description' => __( 'Specify the ratio that should be used to dictate the size of each tile.', 'canvys' ),
               'default'     => '1x1',
               'options'     => array(
                  '6x2'  => __( '6 X 2', 'canvys' ),
                  '5x2'  => __( '5 X 2', 'canvys' ),
                  '4x2'  => __( '4 X 2', 'canvys' ),
                  '3x2'  => __( '3 X 2', 'canvys' ),
                  '1x1'  => __( '1 X 1', 'canvys' ),
               ),
            ) ),

         ),

      );
   }

   /**
    * Renders inline JavaScript/CSS required by the shortcode composer
    *
    * @return mixed
    */
   public function composer_additional_assets() { ?>

      <script id="cv-builder-cv_recent_portfolio-script">
         (function($){
            "use strict";
            $(document).on( 'cv-composer-load-cv_recent_portfolio', function() {
               var $modal = $('#cv-composer-absolute-container').children().last();
               $modal.find('.control-style select').on( 'change', function() {
                  var $this = $(this), val = $this.val(), allControls = {};
                  allControls.slider = $modal.find('.control-slider_config, .control-ratio');
                  allControls.carousel = $modal.find('.control-carousel_config, .control-ratio');
                  allControls.grid = $modal.find('.control-columns, .control-spacing, .control-responsive, .control-ratio');
                  _.each( ['slider', 'carousel', 'grid'], function( style ) { allControls[style].hide(); });
                  allControls[val].fadeIn();
               }).trigger('change');
            });
         })(jQuery);
      </script>

   <?php }

   /**
    * Callback function for front end display of shortcode
    *
    * @param array  $atts      Array of provided attributes
    * @param string $content   Content of shortcode
    * @return string
    */
   public function callback( $atts, $content = null ) {

      global $post, $canvys;

      // Create attributes array by sanitizing provided values
      extract( $this->get_sanitized_attributes( $atts ) );

      // Start the query
      $query = array(
         'posts_per_page' => $num_posts,
         'post_type' => 'portfolio_item',
      );

      // Categories to retrieve posts from
      if ( 'none' != $cat_slug ) {
         $query['tax_query'] = array(
            array(
               'taxonomy' => 'portfolio_categories',
               'field'    => 'slug',
               'terms'    => $cat_slug,
            ),
         );
      }

      // If post thumbnails are required
      if ( 'require' == $thumbnails ) {
         $query['meta_key'] = '_thumbnail_id';
      }

      $posts_array = get_posts( $query );

      if ( ! $posts_array ) {
         return;
      }

      // Create the box
      $o = new CV_HTML( '<div>', array(
         'class' => 'cv-recent-posts',
      ) );

      // Apply te style class
      $o->add_class( 'is-' . $style );

      switch ( $style ) {

         case 'slider':
            $o->add_class( 'is-gallery' );
            $o = cv_apply_slider_config_attributes( $o, $slider_config );
            break;

         case 'carousel':
            $o->add_class( 'is-carousel' );
            $o = cv_apply_carousel_config_attributes( $o, $carousel_config );
            break;

         case 'grid':
            $layout_class = $columns == count( $posts_array ) ? 'split' : 'grid';
            $o->add_class( 'cv-' . $layout_class . '-' . $columns );
            $o->add_class( 'has-clearfix' );
            if ( 'grid' == $layout_class ) $o->add_class( 'masonry-layout' );
            if ( 'none' != $spacing ) $o->add_class( 'spacing-' . $spacing );
            break;

      }

      // Configuration for post tiles
      $tile_config = array(
         'ratio' => $ratio,
         'img_size' => 'cv_square_large',
         'hide_thumbnail' => 'hide' == $thumbnails ? true : false,
      );

      if ( 'standard' == $tile_type ) {
         $tile_config['hide_title'] = true;
      }

      // Number of posts to show
      $num_posts = $num_posts ? $num_posts : -1;

      foreach ( $posts_array as $post ) :

         setup_postdata( $post );

         $tile = cv_get_post_tile( $tile_config );

         if ( 'standard' == $tile_type ) {

            // Grab item categories
            $terms = get_the_terms( get_the_ID(), 'portfolio_categories' );

            // Create list of terms
            $cats_list = '';

            // Create the list of tags
            if ( is_array( $terms ) ) {
               foreach ( $terms as $term ) {
                  $cats_list .= $term->name . ' / ';
               }
            }
            $cats_list = trim( $cats_list, ' / ' );

            $tile .= '<p class="below-tile">';
            $tile .= '<a href="' . get_permalink() . '"><strong>' . get_the_title() . '</strong></a><br />';
            $tile .= '<a href="' . get_permalink() . '"><em>' . $cats_list . '</em></a>';
            $tile .= '</p>';
         }

         $o->append( '<div>' . $tile . '</div>' );

      endforeach;

      // Reset the loop
      wp_reset_postdata();

      // Render the output
      return $title ? '<h2>' . $title . '</h2>' . $o : $o->render();

   }

   /**
    * Callback function for displaying the template builder module title
    *
    * @param array  $atts      Array of provided attributes
    * @param string $content   Content of shortcode
    * @return string
    */
   public function builder_module_title( $atts, $content = null ) {
      $text = isset($atts['title']) && $atts['title'] ? $atts['title'] : $this->config['title'];
      return '<i class="cv-module-icon icon-box"></i> ' . $text;
   }

}
endif;

if ( ! class_exists('CV_Shortcode_Portfolio_category_Select_Control') ) :

/**
 * Product categories Select Control
 *
 * @package    WordPress
 * @subpackage Canvys
 * @since      Version 1.0
 */
class CV_Shortcode_Portfolio_category_Select_Control extends CV_Shortcode_Control {

   // Used to identify the shortcode type
   public $type = 'select';

   /**
    * Callback function for rendering only the control
    *
    * @param mixed $input The input value
    * @return string
    */
   public function render_control( $input = null ) {
      $control = new CV_HTML( '<select>', array(
         'name' => $this->handle,
         'id'   => $this->id,
      ) );

      $category_options = array( 'none' => __( 'All categories', 'canvys' ) );
      foreach ( get_terms( 'portfolio_categories' ) as $category ) {
         $category_options[$category->slug] = $category->name . ' (' . $category->count . ')';
      }

      // Add the options
      foreach ( $category_options as $val => $name ) {
         $control->append('<option value="' . $val . '" ' . selected( $input, $val, 0 ) . '>' . $name . '</option>');
      }
      return $control->render();
   }

   /**
    * Sanitize any user input
    *
    * @param mixed $input The input value
    * @return string
    */
   public function sanitize_input( $input = null ) {

      $allowed = array( 'none' );

      // Create usable array of options
      foreach ( get_terms('portfolio_categories') as $category ) {
         $allowed[] = $category->slug;
      }

      // Return sanitized value
      return cv_filter( $input, $allowed, $this->config['default'] );

   }

}
endif;