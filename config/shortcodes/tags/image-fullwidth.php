<?php

if ( ! class_exists('CV_Fullwidth_Image') ) :

/**
 * Fullwidth Image
 *
 * @package      WordPress
 * @subpackage   Canvys
 * @since        Version 1.0
 */
class CV_Fullwidth_Image extends CV_Shortcode {

   /**
    * Function to create shortcode configuration
    *
    * @return void
    */
   public function __construct() {

      global $canvys;

      $this->config = array(

         // Handle will be used to use this shortcode
         'handle' => 'cv_fullwidth_image',

         // Whether or not this is a shortcode composer element
         'composer_element' => false,

         // Whether or not this is a template builder element
         'builder_element' => true,

         // Used by the template builder to determine where module can be dropped
         'drop_target' => 0,

         // Used by the template builder to determine where module can have other
         // modules dropped inside of it
         'drop_zone' => false,

         // Title will be used to identify this shortcode
         'title' => __( 'Full Width Image', 'canvys' ),

         // Icon will be used to represent this shortcode in composer/builder
         // List of available icons can be found in icons.json
         'icon' => 'picture-1',

         // Whether or not shortcode is self closing
         'self_closing' => true,

         // If shortcode is not self closing, specify its default content
         'default_content' => null,

         // Specify whether or not content is directly editable
         'content_editor' => false,

         // Specify whether or not the content is composed of another shortcode
         'content_element' => false,

         // Provide an explanation of what this shortcode does
         'explanation' => __( 'Fullwidth images will be displayed at their actual size but scaled to fit the width of the layout. If you are attempting to create a full screen image use a content section and set the minimum height attribute to 100% and add the image as a background image instead.', 'canvys' ),

         // Array of shortcode settings and their respective attributes
         'attributes' => array(

            new CV_Shortcode_Image_Control( 'id', array(
               'title'       => __( 'Image', 'canvys' ),
               'description' => __( 'Select the image to be displayed', 'canvys' ),
            ) ),

            new CV_Shortcode_Select_Control( 'visibility', array(
               'title'       => __( 'Visibility', 'canvys' ),
               'description' => __( 'Which devices this image should be visible on. This is great for optimizing your website for all devices.', 'canvys' ),
               'default'     => 'all',
               'options'     => $canvys['visibility_options'],
            ) ),

         ),
      );
   }

   /**
    * Callback function for front end display of shortcode
    *
    * @param array  $atts      Array of provided attributes
    * @param string $content   Content of shortcode
    * @return string
    */
   public function callback( $atts, $content = null ) {

      // Extract sanitized attributes
      extract( $this->get_sanitized_attributes( $atts ) );

      // Make sure there is an image to show
      if ( ! $id ) {
         return;
      }

      // Grab the image URL
      $img_data = wp_get_attachment_image_src( $id, 'cv_full' );

      // The row container
      $o = new CV_HTML( '<img />', array(
         'class' => 'cv-fullwidth-image',
         'data-visibility' => $visibility,
         'src' => $img_data[0],
         'alt' => cv_get_attachment_alt( $id ),
      ) );

      return $o->render();

   }

}
endif;