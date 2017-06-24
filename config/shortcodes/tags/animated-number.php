<?php

if ( ! class_exists('CV_Animated_Number') ) :

/**
 * Animated numbers
 *
 * @package      WordPress
 * @subpackage   Canvys
 * @since        Version 1.0
 */
class CV_Animated_Number extends CV_Shortcode {

   /**
    * Function to create shortcode configuration
    *
    * @return void
    */
   public function __construct() {

      $this->config = array(

         // Handle will be used to use this shortcode
         'handle' => 'cv_animated_number',

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
         'title' => __( 'Animated Number', 'canvys' ),

         // Icon will be used to represent this shortcode in composer/builder
         // List of available icons can be found in icons.json
         'icon' => 'back-in-time',

         // Whether or not shortcode is self closing
         'self_closing' => true,

         // If shortcode is not self closing, specify its default content
         'default_content' => null,

         // Specify whether or not content is directly editable
         'content_editor' => false,

         // Specify whether or not the content is composed of another shortcode
         'content_element' => false,

         // Provide an explanation of what this shortcode does
         'explanation' => __( 'Animated numbers use a subtle "odometer" style animation to come fully into view.', 'canvys' ),

         // Array of shortcode settings and their respective attributes
         'attributes' => array(

            new CV_Shortcode_Number_Control( 'number', array(
               'title'       => __( 'Number', 'canvys' ),
               'description' => __( 'Enter a numeric value only, commas will be added automatically.', 'canvys' ),
               'default' => 1500
            ) ),

            new CV_Shortcode_Text_Control( 'after', array(
               'title'       => __( 'After Number', 'canvys' ),
               'description' => __( 'Specify any content to be displayed immediately after the number.', 'canvys' ),
            ) ),

            new CV_Shortcode_Text_Control( 'title', array(
               'title'       => __( 'Optional Title', 'canvys' ),
               'description' => __( 'The title displayed immediately below the number.', 'canvys' ),
            ) ),

            new CV_Shortcode_Text_Control( 'description', array(
               'title'       => __( 'Optional Descriptin', 'canvys' ),
               'description' => __( 'The description displayed immediately below the title.', 'canvys' ),
            ) ),

            new CV_Shortcode_Select_Control( 'size', array(
               'title'       => __( 'Font Size', 'canvys' ),
               'description' => __( 'Specify the size of the font used to display this animated number.', 'canvys' ),
               'default'     => 'normal',
               'options'     => array(
                  'smaller' => __( 'Smaller', 'canvys' ),
                  'normal'  => __( 'Normal', 'canvys' ),
                  'larger'  => __( 'Larger', 'canvys' ),
                  'much-larger'  => __( 'Much Larger', 'canvys' ),
               ),
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
           $section_tag . " .cv-animated-number .number,"
         . $section_tag . " .cv-animated-number .after-number {"
         . "color: {$colors['headers']};"
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
      extract( $this->get_sanitized_attributes( $atts ) );
      $number = $number ? $number : 1500;
      $o = '<h2>' . $number . ' ' . $after . '</h2>';
      if ( $title ) $o .= '<p><strong>' . $title . '</strong></p>';
      if ( $description ) $o .= '<p>' . $description . '</p>';
      return $o;
   }

   /**
    * Renders inline CSS required by the template builder
    *
    * @return mixed
    */
   public function builder_additional_styles() { ?>

      <style id="cv-builder-cv_text_block-preview">
         .cv-module-cv_animated_number .cv-module-preview {
            text-align: center;
         }
         .cv-module-cv_animated_number .cv-module-preview h2,
         .cv-module-cv_animated_number .cv-module-preview p {
            margin: 0;
         }
      </style>

   <?php }

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

      // Create the container
      $o = new CV_HTML( '<div>', array(
         'class' => 'cv-animated-number',
         'data-number' => $number,
      ) );

      switch ( $size ) {
         case 'smaller': $o->css( 'font-size', '0.85em' ); break;
         case 'larger':  $o->css( 'font-size', '1.5em' ); break;
         case 'much-larger':  $o->css( 'font-size', '2em' ); break;
      }

      $number_html  = '<div class="number-container" data-entrance="fadeIn">';

      // Add the js number
      $number_html .= '<div class="number js-only odometer"></div>';
      if ( $after ) $number_html .= '<div class="js-only after-number">' . $after . '</div>';

      // Add the no-js fallback
      $o->append( '<p class="number no-js-only">' . $number . $after . '</p>' );

      $number_html .= '</div>';

      // Add the number
      $o->append( $number_html );

      // Add the title, if there is one
      if ( $title ) $o->append( '<strong>' . $title . '</strong>' );

      // Add the description, if there is one
      if ( $description ) $o->append( '<p>' . $description . '</p>' );

      return $o->render();

   }

}
endif;