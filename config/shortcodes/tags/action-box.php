<?php

if ( ! class_exists('CV_Action_Box') ) :

/**
 * Promo Boxes
 *
 * @package      WordPress
 * @subpackage   Canvys
 * @since        Version 1.0
 */
class CV_Action_Box extends CV_Shortcode {

   /**
    * Function to create shortcode configuration
    *
    * @return void
    */
   public function __construct() {

      global $canvys;

      $this->config = array(

         // Handle will be used to use this shortcode
         'handle' => 'cv_action_box',

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
         'title' => __( 'Call to Action', 'canvys' ),

         // Icon will be used to represent this shortcode in composer/builder
         // List of available icons can be found in icons.json
         'icon' => 'compass',

         // Whether or not shortcode is self closing
         'self_closing' => false,

         // If shortcode is not self closing, specify its default content
         'default_content' => '[cv_button_child text="' . __( 'Default Button', 'canvys' ) . '"]',

         // Specify whether or not content is directly editable
         'content_editor' => false,

         // Specify whether or not the content is composed of another shortcode
         'content_element' => 'cv_button_child',

         // Provide an explanation of what this shortcode does
         'explanation' => __( 'Call to action elements are a great way to grab your website users attention and point them in the right direction, create one or more buttons and specify and your call to action is good to go.', 'canvys' ),

         // Array of shortcode settings and their respective attributes
         'attributes' => array(

            new CV_Shortcode_Text_Control( 'title', array(
               'title'       => __( 'Title', 'canvys' ),
               'description' => __( 'Specify the title for this call to action.', 'canvys' ),
            ) ),

            new CV_Shortcode_Text_Control( 'description', array(
               'title'       => __( 'Description', 'canvys' ),
               'description' => __( 'Specify the description for this call to action.', 'canvys' ),
            ) ),

         ),

      );
   }

   /**
    * Callback function for front end shortcode styles
    *
    * @param array $sections Color scheme settings
    * @return string
    */
   public static function front_end_styles( $sections ) {

      foreach ( $sections as $section => $colors ) {

         $section_tag = '.cv-section-' . $section;

         echo
           $section_tag . " .cv-action-box {"
         . "background: {$colors['secondary_bg']};"
         . "border: 1px solid {$colors['borders']};"
         . "}"
         ;

      }

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

      // Create attributes array by sanitizing provided values
      extract( $this->get_sanitized_attributes( $atts ) );

      // Create the promo box
      $o = new CV_HTML( '<div>', array(
         'class' => 'cv-action-box has-clearfix',
      ) );

      // Create the lines
      $lines = '';
      if ( $title ) $lines .= '[cv_header_stack_line tag="h2" size_adjustment="1.2" weight="300" text="' . $title . '"]';
      if ( $description ) $lines .= '[cv_header_stack_line tag="h4" size_adjustment="0.8" weight="600" text="' . $description . '"]';

      // Make sure there is at least one line of text
      if ( ! $lines ) return;

      // Add the lines
      $o->append( $canvys['shortcodes']['cv_header_stack']->callback( array( 'min' => '10', 'max' => '24', 'multiplier' => 20 ), $lines ) );

      // Add the buttons
      if ( ! empty( $cv_buttons ) ) {

         // Determine the best button size
         switch ( count( $cv_buttons ) ) {
            case '1': $size = 'large'; break;
            case '2': $size = 'medium'; break;
            default: $size = 'small';
         }

         // Buttons wrap
         $buttons = '<div class="buttons"><div>';

         // Add each button
         foreach ( $cv_buttons as $button_config ) {
            $button_config['size'] = $size;
            $button_config['weight'] = 'thin';
            $buttons .= $canvys['shortcodes']['cv_button']->callback( $button_config );
         }

         // Add the buttons
         $buttons .= '</div></div>';
         $o->append( $buttons );

      }

      return $o->render();

   }

}
endif;