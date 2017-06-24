<?php

if ( ! class_exists('CV_Spacer') ) :

/**
 * Row Spacer
 * Class that handles the creation and configuration
 * of the spacer shortcode
 *
 * @package      WordPress
 * @subpackage   Canvys
 * @since        Version 1.0
 */
class CV_Spacer extends CV_Shortcode {

   /**
    * Function to create shortcode configuration
    *
    * @return void
    */
   public function __construct() {

      $this->config = array(

         // Handle will be used to use this shortcode
         'handle' => 'cv_spacer',

         // Whether or not this is a shortcode composer element
         'composer_element' => false,

         // Whether or not this is a template builder element
         'builder_element' => true,

         // Used by the template builder to determine where module can be dropped
         'drop_target' => 2,

         // Used by the template builder to determine where module can have other
         // modules dropped inside of it
         'drop_zone' => false,

         // Title will be used to identify this shortcode
         'title' => __( 'Spacer', 'canvys' ),

         // Icon will be used to represent this shortcode in composer/builder
         // List of available icons can be found in icons.json
         'icon' => 'arrow-combo',

         // Whether or not shortcode is self closing
         'self_closing' => true,

         // If shortcode is not self closing, specify its default content
         'default_content' => null,

         // Specify whether or not content is directly editable
         'content_editor' => false,

         // Specify whether or not the content is composed of another shortcode
         'content_element' => false,

         // Provide an explanation of what this shortcode does
         'explanation' => __( 'This shortcode allows you to add any amount of vertical space between two modules.', 'canvys' ),

         // Array of shortcode settings and their respective attributes
         'attributes' => array(

            new CV_Shortcode_Select_Control( 'size', array(
               'title'       => __( 'Spacer Size', 'canvys' ),
               'description' => __( 'Use this control to specify the size of this spacer', 'canvys' ),
               'default'     => 'small',
               'options'     => array(
                  'small'  => __( 'Small (1em)', 'canvys' ),
                  'medium' => __( 'Medium (3em)', 'canvys' ),
                  'large'  => __( 'Large (5em)', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Text_Control( 'custom', array(
               'title'       => __( 'Custom Size', 'canvys' ),
               'description' => __( 'Enter a value here to override the default settings, value must include units for example "50px" or "3em".', 'canvys' ),
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

      // The spacer element
      $o = new CV_HTML( '<div>', array(
         'class' => 'cv-spacer clearfix',
      ) );

      switch ( $size ) {
        case 'small':  $size = '1em'; break;
        case 'medium': $size = '3em'; break;
        case 'large':  $size = '5em'; break;
      }

      $size = $custom ? $custom : $size;

      $o->css( 'height', $size );

      return $o->render();

   }

}
endif;