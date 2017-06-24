<?php

if ( ! class_exists('CV_Blog') ) :

/**
 * Blog Posts
 * Class that handles the creation and configuration
 * of blog post shortcode
 *
 * @package      WordPress
 * @subpackage   Canvys
 * @since        Version 1.0
 */
class CV_Blog extends CV_Shortcode {

   /**
    * Function to create shortcode configuration
    *
    * @return void
    */
   public function __construct() {

      $this->config = array(

         // Handle will be used to use this shortcode
         'handle' => 'cv_blog',

         // Whether or not this is a shortcode composer element
         'composer_element' => true,

         // Whether or not this is a template builder element
         'builder_element' => true,

         // Used by the template builder to determine where module can be dropped
         'drop_target' => 1,

         // Used by the template builder to determine where module can have other
         // modules dropped inside of it
         'drop_zone' => false,

         // Title will be used to identify this shortcode
         'title' => __( 'Blog', 'canvys' ),

         // Icon will be used to represent this shortcode in composer/builder
         // List of available icons can be found in icons.json
         'icon' => 'th-list',

         // Whether or not shortcode is self closing
         'self_closing' => true,

         // If shortcode is not self closing, specify its default content
         'default_content' => null,

         // Specify whether or not content is directly editable
         'content_editor' => false,

         // Specify whether or not the content is composed of another shortcode
         'content_element' => false,

         // Provide an explanation of what this shortcode does
         'explanation' => __( 'Display your posts in a complete blog, please note that it is best practice to have onl yone of these elements per page.', 'canvys' ),

         // Array of shortcode settings and their respective attributes
         'attributes' => array(

            new CV_Shortcode_Select_Control( 'style', array(
               'title'       => __( 'Blog Style', 'canvys' ),
               'description' => __( 'Select the style for this blog', 'canvys' ),
               'default'     => 'standard',
               'options'     => array(
                  'standard'     => __( 'Standard', 'canvys' ),
                  'boxed'        => __( 'Boxed', 'canvys' ),
                  'minimal'      => __( 'Minimal', 'canvys' ),
                  'masonry'      => __( 'Masonry', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Select_Control( 'masonry_columns', array(
               'title'       => __( 'Number of Columns', 'canvys' ),
               'description' => __( 'Specify how many columns should be used to display your posts.', 'canvys' ),
               'default'     => '3',
               'options'     => array(
                  '2' => __( '2 Columns', 'canvys' ),
                  '3' => __( '3 Columns', 'canvys' ),
                  '4' => __( '4 Columns', 'canvys' ),
                  '5' => __( '5 Columns', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Text_Control( 'per_page', array(
               'title'       => __( 'Posts Per Page', 'canvys' ),
               'description' => __( 'Enter the number of posts to be displayed per page, enter a number only. Default is to display all posts on one page.', 'canvys' ),
               'placeholder' => 'All Posts',
            ) ),

            new CV_Shortcode_Select_Control( 'pagination', array(
               'title'       => __( 'Page Pagination', 'canvys' ),
               'description' => __( 'Enable pagination when applicable.', 'canvys' ),
               'default'     => 'true',
               'options'     => array(
                  'true'  => __( 'yes, enable pagination', 'canvys' ),
                  'false' => __( 'No, disable pagination', 'canvys' ),
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

      <script id="cv-builder-cv_blog-script">
         (function($){
            "use strict";

            $(document).on( 'cv-composer-load-cv_blog', function() {

               var $modal = $('#cv-composer-absolute-container').children().last();
               var $styleControl = $modal.find('.control-style select');
               var $columnsControl = $modal.find('.control-masonry_columns');

               $styleControl.on( 'change', function() {

                  var val = $styleControl.val();

                  // Show/hide columns control
                  if ( 'masonry' === val ) {
                     $columnsControl.fadeIn();
                  }
                  else {
                     $columnsControl.hide();
                  }

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

      // Create attributes array by sanitizing provided values
      extract( $this->get_sanitized_attributes( $atts ) );

      // Set the number of columns, if masonry is active
      if ( 'masonry' == $style ) {
         global $num_columns;
         $num_columns = $masonry_columns;
      }

      $paged_query_var = is_front_page() ? 'page' : 'paged';

      $args = array(
         'posts_per_page' => $per_page ? cv_filter( $per_page, 'integer' ) : -1,
         'paged' => get_query_var($paged_query_var) ? get_query_var($paged_query_var) : 1,
      );

      query_posts( $args );

      // Grab the loop
      ob_start();
      get_template_part( 'inc/loops/blog-' . $style );
      if ( cv_make_bool( $pagination ) ) echo cv_pagination();
      $blog = ob_get_clean();

      wp_reset_query();

      return $blog;

   }

}
endif;