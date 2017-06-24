<?php

if ( ! class_exists('CV_Header_Stack') ) :

/**
 * Header Stack
 *
 * @package      WordPress
 * @subpackage   Canvys
 * @since        Version 1.0
 */
class CV_Header_Stack extends CV_Shortcode {

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

      $bottom_margin_options = array( '0' => __( 'None', 'canvys' ) );
      for ( $i=0.5; $i<9; $i+=0.5 ) {
         $bottom_margin_options[sprintf( '%sem', $i )] = sprintf( '%sem', $i );
      }

      $this->config = array(

         // Handle will be used to use this shortcode
         'handle' => 'cv_header_stack',

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
         'title' => __( 'Header Stack', 'canvys' ),

         // Icon will be used to represent this shortcode in composer/builder
         // List of available icons can be found in icons.json
         'icon' => 'font',

         // Whether or not shortcode is self closing
         'self_closing' => false,

         // If shortcode is not self closing, specify its default content
         'default_content' => '[cv_header_stack_line tag="h1" text="' . __( 'This is line one', 'canvys' ) . '"]'
                            . '[cv_header_stack_line tag="h1" text="' . __( 'this is line two', 'canvys' ) . '"]',

         // Specify whether or not content is directly editable
         'content_editor' => false,

         // Specify whether or not the content is composed of another shortcode
         'content_element' => 'cv_header_stack_line',

         // Provide an explanation of what this shortcode does
         'explanation' => __( 'A common design practice is to have multiple headers of different sizes displayed on top of each other, this shortcode makes it easy for you to do just that.', 'canvys' ),

         // Array of shortcode settings and their respective attributes
         'attributes' => array(

            new CV_Shortcode_Select_Control( 'align', array(
               'title'       => __( 'Alignment', 'canvys' ),
               'description' => __( 'Select how the content should be aligned.', 'canvys' ),
               'default'     => 'none',
               'options'     => array(
                  'none'   => __( 'No alignment', 'canvys' ),
                  'left'   => __( 'Left', 'canvys' ),
                  'right'  => __( 'Right', 'canvys' ),
                  'center' => __( 'Center', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Color_Control( 'color', array(
               'title'       => __( 'Default Color', 'canvys' ),
               'description' => __( 'Specify a color to be used for each line. If this is left blank the headers color for the section will be used.', 'canvys' ),
            ) ),

            new CV_Shortcode_Select_Control( 'entrance', array(
               'title'       => __( 'Animated Entrance', 'canvys' ),
               'description' => __( 'Specify an aminated entrance for the header lines to come into view, animations will occur consecutively.', 'canvys' ),
               'default'     => 'none',
               'options'     => $animation_options,
            ) ),

            new CV_Shortcode_Select_Control( 'margin', array(
               'title'       => __( 'Bottom Margin', 'canvys' ),
               'description' => __( 'Specify the amount of white space to be displayed below the header stack.', 'canvys' ),
               'default'     => '0',
               'options'     => $bottom_margin_options,
            ) ),

            new CV_Shortcode_Dev_Control( 'min', array(
               'default' => null,
            ) ),

            new CV_Shortcode_Dev_Control( 'max', array(
               'default' => null,
            ) ),

            new CV_Shortcode_Dev_Control( 'multiplier', array(
               'default' => null,
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
           $section_tag . " .cv-header-stack [class*='icon-'] {"
         . "color: {$colors['headers']};"
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

      global $cv_header_stack_lines;

      // Start with an empty array
      $cv_header_stack_lines = array();

      // Fill the toggles array
      do_shortcode( $content );

      // Make sure there is atleast 1 toggle
      if ( empty( $cv_header_stack_lines ) ) {
         return;
      }

      // Create attributes array by sanitizing provided values
      extract( $this->get_sanitized_attributes( $atts ) );

      // Create the header stack
      $o = new CV_HTML( '<div>', array(
         'class' => 'cv-header-stack cv-scaling-typography',
         'data-min' => $min ? $min : '20',
      ) );

      // Apply the correct alignment
      if ( 'none' != $align ) $o->css( 'text-align', $align );

      // Apply the animated entrance data
      if ( 'none' !== $entrance ) $o->data( 'trigger-entrances', 'true' );

      // Apply the max size, if one has been set
      if ( $max ) $o->data( 'max', $max );

      // Apply the multiplier, if one has been set
      if ( $multiplier ) $o->data( 'multiplier', $multiplier );

      // Add the lines
      $delay_timer = 0;
      foreach ( $cv_header_stack_lines as $line_config ) {


         // textual line
         if ( 'text' == $line_config['source'] ) {

            // Create the header
            $line = new CV_HTML( '<' . $line_config['tag'] . '>', array(
               'class' => 'cv-header-line cv-header-style-'.$line_config['style'],
               'content' => '<span style="opacity:' . $line_config['opacity'] . '">' . $line_config['text'] . '</span>',
            ) );

            // Apply the weight
            if ( 'default' != $line_config['weight'] ) {
               $line->css( 'font-weight', $line_config['weight'] );
            }

         }

         // Icon Line
         else if ( 'icon' == $line_config['source'] ) {
            $line = new CV_HTML( '<p>', array(
               'class' => 'cv-header-line',
               'content' => '<i style="opacity:' . $line_config['opacity'] . '" class="icon-' . $line_config['icon'] . '"></i>',
            ) );
         }

         if ( ! $line ) continue;

         // Apply the size adjustment
         $line->css( 'font-size', $line_config['size_adjustment'] . 'em' );

         // Apply the color
         if ( $color ) $line->css( 'color', $color );

         // Create animated entrance attribute
         if ( 'none' !== $entrance ) {
            $line->data( 'entrance', $entrance );
            $line->data( 'chained', 'true' );
            if ( $delay_timer ) $line->data( 'delay', $delay_timer );
            $delay_timer += 250;
         }

         // Add the line
         $o->append( $line );

      }

      return $margin ? '<div style="margin-bottom:' . $margin . '">' . $o . '</div>' : $o->render();

   }

}
endif;