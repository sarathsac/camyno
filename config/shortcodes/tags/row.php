<?php

if ( ! class_exists('CV_Row') ) :

/**
 * Basic Row
 * Class that handles the creation and configuration
 * of the row shortcode
 *
 * @package      WordPress
 * @subpackage   Canvys
 * @since        Version 1.0
 */
class CV_Row extends CV_Shortcode {

   /**
    * Function to create shortcode configuration
    *
    * @return void
    */
   public function __construct() {

      global $canvys;

      $animation_options = array(
         'none' => __( 'None', 'canvys' ),
      );

      $animation_options = array_merge( $animation_options, $canvys['animations'] );

      $this->config = array(

         // Handle will be used to use this shortcode
         'handle' => 'cv_row',

         // Whether or not this is a shortcode composer element
         'composer_element' => false,

         // Whether or not this is a template builder element
         'builder_element' => true,

         // Used by the template builder to determine where module can be dropped
         'drop_target' => 1,

         // Used by the template builder to determine where module can have other
         // modules dropped inside of it
         'drop_zone' => 2,

         // Title will be used to identify this shortcode
         'title' => __( 'Full Width Row', 'canvys' ),

         // Icon will be used to represent this shortcode in composer/builder
         // List of available icons can be found in icons.json
         'icon' => 'doc-landscape',

         // Whether or not shortcode is self closing
         'self_closing' => false,

         // If shortcode is not self closing, specify its default content
         'default_content' => null,

         // Specify whether or not content is directly editable
         'content_editor' => false,

         // Specify whether or not the content is composed of another shortcode
         'content_element' => false,

         // Provide an explanation of what this shortcode does
         'explanation' => __( 'this is a basic full width row and does not provide any horizontal or vertical spacing.', 'canvys' ),

         // Array of shortcode settings and their respective attributes
         'attributes' => array(

            new CV_Shortcode_Select_Control( 'entrance', array(
               'title'       => __( 'Animated Entrance', 'canvys' ),
               'description' => __( 'Specify an aminated entrance for this row to come into view.', 'canvys' ),
               'default'     => 'none',
               'options'     => $animation_options,
            ) ),

            new CV_Shortcode_Select_Control( 'visibility', array(
               'title'       => __( 'Visibility', 'canvys' ),
               'description' => __( 'Which devices this single column row should be visible on. This is great for optimizing your website for all devices.', 'canvys' ),
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

      // The column container
      $o = new CV_HTML( '<div>', array(
         'class' => 'cv-content-row has-clearfix',
         'content' => "\n\n" . do_shortcode( $content )
      ) );

      // Apply entrance data
      if ( 'none' !== $entrance ) $o->data( 'entrance', $entrance );

      // Apply the visibility class
      $o->data( 'visibility', $visibility );

      return $o->render();

   }

}
endif;