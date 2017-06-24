<?php

if ( ! class_exists('CV_bbPress_Index') ) :

/**
 * WooCommerce Shopping Cart Shortcode
 * Class that handles the creation and configuration
 * of the WooCommerce Shopping Cart shortcode in the template builder
 *
 * @package      WordPress
 * @subpackage   Canvys
 * @since        Version 1.0
 */
class CV_bbPress_Index extends CV_Shortcode {

   /**
    * Function to create shortcode configuration
    *
    * @return void
    */
   public function __construct() {

      $this->config = array(

         // Handle will be used to use this shortcode
         'handle' => 'cv_bbp_index', // bbp-forum-index

         // Whether or not this is a shortcode composer element
         'composer_element' => false,

         // Whether or not this is a template builder element
         'builder_element' => true,

         // Used by the template builder to determine where module can be dropped
         'drop_target' => 1,

         // Used by the template builder to determine where module can have other
         // modules dropped inside of it
         'drop_zone' => false,

         // Title will be used to identify this shortcode
         'title' => __( 'bbPress Forum Index', 'canvys' ),

         // Icon will be used to represent this shortcode in composer/builder
         // List of available icons can be found in icons.json
         'icon' => 'chat',

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

            new CV_Shortcode_Select_Control( 'search_bar', array(
               'title'       => __( 'Search Bar', 'canvys' ),
               'description' => __( 'Specify whether or not the large search bar above the forums should be displayed.', 'canvys' ),
               'default'     => 'true',
               'options'     => array(
                  'true' => __( 'Yes, display the search bar', 'canvys' ),
                  'false'  => __( 'No, do not display the search bar', 'canvys' ),
               ),
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

      // Create attributes array by sanitizing provided values
      extract( $this->get_sanitized_attributes( $atts ) );

      $search_bar_class = cv_make_bool( $search_bar ) ? ' with-search' : ' no-search';

      return '<div class="cv-bbp-forum-index-wrap' . $search_bar_class . '">' . do_shortcode( '[bbp-forum-index]' ) . '</div>';

   }

}
endif;