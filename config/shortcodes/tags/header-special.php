<?php

if ( ! class_exists('CV_Special_Header') ) :

/**
 * Special headers
 *
 * @package      WordPress
 * @subpackage   Canvys
 * @since        Version 1.0
 */
class CV_Special_Header extends CV_Shortcode {

   /**
    * Function to create shortcode configuration
    *
    * @return void
    */
   public function __construct() {

      $bottom_margin_options = array( '0' => __( 'None', 'canvys' ) );
      for ( $i=0.5; $i<9; $i+=0.5 ) {
         $bottom_margin_options[sprintf( '%sem', $i )] = sprintf( '%sem', $i );
      }

      $this->config = array(

         // Handle will be used to use this shortcode
         'handle' => 'cv_special_header',

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
         'title' => __( 'Special Header', 'canvys' ),

         // Icon will be used to represent this shortcode in composer/builder
         // List of available icons can be found in icons.json
         'icon' => 'asterisk',

         // Whether or not shortcode is self closing
         'self_closing' => false,

         // If shortcode is not self closing, specify its default content
         'default_content' => null,

         // Specify whether or not content is directly editable
         'content_editor' => false,

         // Specify whether or not the content is composed of another shortcode
         'content_element' => false,

         // Provide an explanation of what this shortcode does
         'explanation' => __( 'Special headers add some unique styling to a standard header.', 'canvys' ),

         // Array of shortcode settings and their respective attributes
         'attributes' => array(

            new CV_Shortcode_Text_Control( 'text', array(
               'title'       => __( 'Header Text', 'canvys' ),
               'description' => __( 'Specify the text for this header.<br /><br /><strong>Formatting Quick Tags:</strong><br />(b)<strong>Bold</strong>(/b)<br />(i)<em>italics</em>(/i)<br />(u)<u>underlined</u>(/u)<br />(s)<del>Striked</del>(/s)<br />', 'canvys' ),
            ) ),

            new CV_Shortcode_Select_Control( 'align', array(
               'title'       => __( 'Text Align', 'canvys' ),
               'description' => __( 'Specify how the header text should be aligned.', 'canvys' ),
               'default'     => 'none',
               'options'     => array(
                  'none'   => __( 'No alignment', 'canvys' ),
                  'left'   => __( 'Left', 'canvys' ),
                  'right'  => __( 'Right', 'canvys' ),
                  'center' => __( 'Center', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Select_Control( 'size', array(
               'title'       => __( 'Font Size', 'canvys' ),
               'description' => __( 'Specify the font size for this header.', 'canvys' ),
               'default'     => 'normal',
               'options'     => array(
                  'smaller' => __( 'Smaller', 'canvys' ),
                  'normal'  => __( 'Normal', 'canvys' ),
                  'larger'  => __( 'Larger', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Select_Control( 'margin', array(
               'title'       => __( 'Bottom Margin', 'canvys' ),
               'description' => __( 'Specify the amount of white space to be displayed below the header.', 'canvys' ),
               'default'     => '0',
               'options'     => $bottom_margin_options,
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

         // begin output
         echo
           $section_tag . " .cv-special-header:before {"
         . "background: " . cv_hex_to_rgba( $colors['borders'], 0.5 ) . ";"
         . "}"
         . $section_tag . " .cv-special-header .inner-text {"
         . "background: {$colors['primary_bg']};"
         . "}"
         ;

      }

   }

   /**
    * Callback function for display of preview in builder module
    *
    * @param array  $atts      Array of provided attributes
    * @param string $content   Content of shortcode
    * @return string
    */
   public function builder_module_preview( $atts, $content = null ) {
      return $atts['text'] ? '<h3>' . $atts['text'] . '</h3>' : null;
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

      // Create the box
      $o = new CV_HTML( '<h2>', array(
         'class' => 'cv-special-header',
      ) );

      // Apply the alignment
      if ( 'none' !== $align ) {
         $o->css( 'text-align', $align );
         $o->add_class( 'text-align-' . $align );
      }

      // Apply the size setting
      switch ( $size ) {
         case 'smaller': $font_size = '1.25em'; break;
         case 'larger': $font_size = '1.5em'; break;
         default: $font_size = '1.75em';
      }
      $o->css( 'font-size', $font_size );

      // Create the inner text
      $inner_text = new CV_HTML( '<span>', array(
         'class' => 'inner-text',
         'content' => cv_parse_quicktags( $text ),
      ) );

      // Render the output
      return $margin ? '<div style="margin-bottom:' . $margin . '">' . $o->render( $inner_text ) . '</div>' : $o->render( $inner_text );

   }

}
endif;