<?php

if ( ! class_exists('CV_Testimonial') ) :

/**
 * Testimonial
 *
 * @package      WordPress
 * @subpackage   Canvys
 * @since        Version 1.0
 */
class CV_Testimonial extends CV_Shortcode {

   /**
    * Function to create shortcode configuration
    *
    * @return void
    */
   public function __construct() {

      $this->config = array(

         // Handle will be used to use this shortcode
         'handle' => 'cv_testimonial',

         // Whether or not this is a shortcode composer element
         'composer_element' => false,

         // Whether or not this is a template builder element
         'builder_element' => true,

         // Used by the template builder to determine where module can be dropped
         'drop_target' => 3,

         // Used by the template builder to determine where module can have other
         // modules dropped inside of it
         'drop_zone' => false,

         // Title will be used to identify this shortcode
         'title' => __( 'Testimonial', 'canvys' ),

         // Icon will be used to represent this shortcode in composer/builder
         // List of available icons can be found in icons.json
         'icon' => 'smile',

         // Whether or not shortcode is self closing
         'self_closing' => false,

         // If shortcode is not self closing, specify its default content
         'default_content' =>  null,

         // Specify whether or not content is directly editable
         'content_editor' => true,

         // Specify whether or not the content is composed of another shortcode
         'content_element' => false,

         // Array of shortcode settings and their respective attributes
         'attributes' => array(

            new CV_Shortcode_Image_Control( 'author_img', array(
               'title'       => __( 'Author Image', 'canvys' ),
               'description' => __( 'Select an image to be used to represent the author.', 'canvys' ),
            ) ),

            new CV_Shortcode_Text_Control( 'author_name', array(
               'title'       => __( 'Author Name', 'canvys' ),
               'description' => __( 'Specify the full name of the author of this testimonial.', 'canvys' ),
               'placeholder' => __( 'John Doe', 'canvys' ),
            ) ),

            new CV_Shortcode_Text_Control( 'author_info', array(
               'title'       => __( 'Author Information', 'canvys' ),
               'description' => __( 'Optionally enter some extra information about the author, this could be their job title for example. ', 'canvys' ),
               'placeholder' => __( 'Job Title', 'canvys' ),
            ) ),

            new CV_Shortcode_Text_Control( 'company_name', array(
               'title'       => __( 'Company Name', 'canvys' ),
               'description' => __( 'Specify the name of the company that the author is employed at.', 'canvys' ),
            ) ),

            new CV_Shortcode_Link_Control( 'company_url', array(
               'title'       => __( 'Company Link', 'canvys' ),
               'description' => __( 'Specify a url for the authors company to be linked to.', 'canvys' ),
            ) ),

         ),
      );
   }

   /**
    * Callback function for display of preview in builder module
    *
    * @param array  $atts      Array of provided attributes
    * @param string $content   Content of shortcode
    * @return string
    */
   public function builder_module_preview( $atts, $content = null ) {
      return $content;
   }

   /**
    * Callback function for front end display of shortcode
    *
    * @param array  $atts      Array of provided attributes
    * @param string $content   Content of shortcode
    * @return string
    */
   public function callback( $atts, $content = null ) {

      global $cv_testimonials;

      if ( ! is_array( $cv_testimonials ) ) {
         $cv_testimonials = array();
      }

      // Create attributes array by sanitizing provided values
      extract( $this->get_sanitized_attributes( $atts ) );

      $cv_testimonials[] = array(
         'author_img'   => $author_img,
         'author_name'  => $author_name,
         'author_info'  => $author_info,
         'company_name' => $company_name,
         'company_url'  => $company_url,
         'content'      => $content,
      );

   }

   /**
    * Callback function for displaying the template builder module title
    *
    * @param array  $atts      Array of provided attributes
    * @param string $content   Content of shortcode
    * @return string
    */
   public function builder_module_title( $atts, $content = null ) {
      return isset($atts['author_name']) && $atts['author_name'] ? $atts['author_name'] : $this->config['title'];
   }

}
endif;