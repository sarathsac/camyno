<?php

if ( ! class_exists('CV_Column') ) :

/**
 * Column
 * Class that handles the creation and configuration
 * of the column shortcode
 *
 * @package      WordPress
 * @subpackage   Canvys
 * @since        Version 1.0
 */
class CV_Column extends CV_Shortcode {

   /**
    * Function to create shortcode configuration
    *
    * @return void
    */
   public function __construct() {

      $this->config = array(

         // Handle will be used to use this shortcode
         'handle' => 'cv_column',

         // Whether or not this is a shortcode composer element
         'composer_element' => false,

         // Whether or not this is a template builder element
         'builder_element' => false,

         // Used by the template builder to determine where module can be dropped
         'drop_target' => null,

         // Used by the template builder to determine where module can have other
         // modules dropped inside of it
         'drop_zone' => null,

         // Title will be used to identify this shortcode
         'title' => __( 'Column', 'canvys' ),

         // Icon will be used to represent this shortcode in composer/builder
         // List of available icons can be found in icons.json
         'icon' => 'columns',

         // Whether or not shortcode is self closing
         'self_closing' => false,

         // If shortcode is not self closing, specify its default content
         'default_content' =>  null,

         // Specify whether or not content is directly editable
         'content_editor' => false,

         // Specify whether or not the content is composed of another shortcode
         'content_element' => false,

         // Array of shortcode settings and their respective attributes
         'attributes' => null,

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

      global $cv_columns;

      // Make sure columns is an array
      if ( ! is_array($cv_columns) ) {
        $cv_columns = array();
      }

      $cv_columns[] = $content;

   }

}
endif;