<?php

if ( ! class_exists('CV_Button_Group') ) :

/**
 * Button Groups
 *
 * @package      WordPress
 * @subpackage   Canvys
 * @since        Version 1.0
 */
class CV_Button_Group extends CV_Shortcode {

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
         'handle' => 'cv_button_group',

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
         'title' => __( 'Button Group', 'canvys' ),

         // Icon will be used to represent this shortcode in composer/builder
         // List of available icons can be found in icons.json
         'icon' => 'link',

         // Whether or not shortcode is self closing
         'self_closing' => false,

         // If shortcode is not self closing, specify its default content
         'default_content' => '[cv_button_child text="' . __( 'Button 1 Title', 'canvys' ) . '"]'
                            . '[cv_button_child text="' . __( 'Button 2 Title', 'canvys' ) . '"]',

         // Specify whether or not content is directly editable
         'content_editor' => false,

         // Specify whether or not the content is composed of another shortcode
         'content_element' => 'cv_button_child',

         // Provide an explanation of what this shortcode does
         'explanation' => __( 'Button groups allow you to more efficiently create either a single button or a group of buttons with similar styles.', 'canvys' ),

         // Array of shortcode settings and their respective attributes
         'attributes' => array(

            new CV_Shortcode_Select_Control( 'size', array(
               'title'       => __( 'Size', 'canvys' ),
               'description' => __( 'Specify the size for the buttons in this group.', 'canvys' ),
               'default'     => 'standard',
               'options'     => array(
                  'small' => __( 'Small', 'canvys' ),
                  'medium' => __( 'Medium', 'canvys' ),
                  'large' => __( 'Large', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Select_Control( 'align', array(
               'title'       => __( 'Alignment', 'canvys' ),
               'description' => __( 'Select how the buttons should be aligned.', 'canvys' ),
               'default'     => 'none',
               'options'     => array(
                  'none'   => __( 'No alignment', 'canvys' ),
                  'left'   => __( 'Left', 'canvys' ),
                  'right'  => __( 'Right', 'canvys' ),
                  'center' => __( 'Center', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Select_Control( 'entrance', array(
               'title'       => __( 'Animated Entrance', 'canvys' ),
               'description' => __( 'Specify an aminated entrance for the header lines to come into view, animations will occur consecutively.', 'canvys' ),
               'default'     => 'none',
               'options'     => $animation_options,
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

      global $cv_buttons, $canvys;

      // Start with an empty array
      $cv_buttons = array();

      // Fill the toggles array
      do_shortcode( $content );

      // Make sure there is atleast 1 toggle
      if ( empty( $cv_buttons ) ) {
         return;
      }

      // Create attributes array by sanitizing provided values
      extract( $this->get_sanitized_attributes( $atts ) );

      // Create the group container
      $o = new CV_HTML( '<nav>', array(
         'class' => 'cv-button-group',
      ) );

      // Apply the correct alignment
      if ( 'none' != $align ) $o->css( 'text-align', $align );

      // Create animated entrance attribute
      if ( 'none' !== $entrance ) $o->data( 'entrance', $entrance );

      // Add the buttons
      foreach ( $cv_buttons as $button_config ) {
         $button_config['size'] = $size;
         $o->append( $canvys['shortcodes']['cv_button']->callback( $button_config ) );
      }

      return $o;

   }

}
endif;