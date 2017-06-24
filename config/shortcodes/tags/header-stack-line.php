<?php

if ( ! class_exists('CV_Header_Stack_Line') ) :

/**
 * Header stack line
 *
 * @package      WordPress
 * @subpackage   Canvys
 * @since        Version 1.0
 */
class CV_Header_Stack_Line extends CV_Shortcode {

   /**
    * Function to create shortcode configuration
    *
    * @return void
    */
   public function __construct() {

      $this->config = array(

         // Handle will be used to use this shortcode
         'handle' => 'cv_header_stack_line',

         // Whether or not this is a shortcode composer element
         'composer_element' => false,

         // Whether or not this is a template builder element
         'builder_element' => true,

         // Used by the template builder to determine where module can be dropped
         'drop_target' => 3,

         // Used by the template builder to determine where module can have other
         // modules dropped inside of it
         'drop_zone' => false,

         // Title will be used to identify this shortcode
         'title' => __( 'Line', 'canvys' ),

         // Icon will be used to represent this shortcode in composer/builder
         // List of available icons can be found in icons.json
         'icon' => 'font',

         // Whether or not shortcode is self closing
         'self_closing' => true,

         // If shortcode is not self closing, specify its default content
         'default_content' =>  null,

         // Specify whether or not content is directly editable
         'content_editor' => false,

         // Specify whether or not the content is composed of another shortcode
         'content_element' => false,

         // Array of shortcode settings and their respective attributes
         'attributes' => array(

            new CV_Shortcode_Select_Control( 'source', array(
               'title'       => __( 'Line Content Source', 'canvys' ),
               'description' => __( 'Specify whether this line should contain an icon or text.', 'canvys' ),
               'default'     => 'text',
               'options'     => array(
                  'text' => __( 'Textual Line', 'canvys' ),
                  'icon' => __( 'Single Icon', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Select_Control( 'tag', array(
               'title'       => __( 'Header Tag', 'canvys' ),
               'description' => __( 'Specify which header tag to use for this line.', 'canvys' ),
               'default'     => 'h1',
               'options'     => array(
                  'h1' => __( 'Header One (h1)', 'canvys' ),
                  'h2' => __( 'Header Two (h2)', 'canvys' ),
                  'h3' => __( 'Header Three (h3)', 'canvys' ),
                  'h4' => __( 'Header Four (h4)', 'canvys' ),
                  'h5' => __( 'Header Five (h5)', 'canvys' ),
                  'h6' => __( 'Header Six (h6)', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Select_Control( 'style', array(
               'title'       => __( 'Header Predefined Style', 'canvys' ),
               'description' => __( 'Apply custom style to this header.', 'canvys' ),
               'default'     => 'none',
               'options'     => array(
                  'none' => __( 'No Special Styling', 'canvys' ),
                  'hero-title' => __( 'Hero Title', 'canvys' ),
                  'hero-tagline' => __( 'Hero Tagline', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Text_Control( 'text', array(
               'title'       => __( 'Line Text', 'canvys' ),
               'description' => __( 'Specify the text for this line.<br /><br /><strong>Formatting Quick Tags:</strong><br />(b)<strong>Bold</strong>(/b)<br />(i)<em>italics</em>(/i)<br />(u)<u>underlined</u>(/u)<br />(s)<del>Striked</del>(/s)<br />', 'canvys' ),
            ) ),

            new CV_Shortcode_Select_Control( 'weight', array(
               'title'       => __( 'Line Font Weight', 'canvys' ),
               'description' => __( 'Each header tag will likely have a diferent weight already applied to it, this can be overridden here', 'canvys' ),
               'default'     => 'default',
               'options'     => array(
                  'default' => __( 'Use preset weight', 'canvys' ),
                  '300' => __( 'Light', 'canvys' ),
                  '400' => __( 'Normal', 'canvys' ),
                  '600' => __( 'Bold', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Icon_Control( 'icon', array(
               'title'       => __( 'Icon', 'canvys' ),
               'description' => __( 'Specify an icon to be used for this line.', 'canvys' ),
            ) ),

            new CV_Shortcode_Select_Control( 'size_adjustment', array(
               'title'       => __( 'Font Size Adjustment', 'canvys' ),
               'description' => __( 'Increase or decrease this lines relative font size.', 'canvys' ),
               'default'     => '1',
               'options'     => array(
                  '0.5' => __( '50%', 'canvys' ),
                  '0.6' => __( '60%', 'canvys' ),
                  '0.7' => __( '70%', 'canvys' ),
                  '0.8' => __( '80%', 'canvys' ),
                  '0.9' => __( '90%', 'canvys' ),
                  '1'   => __( 'No adjustment', 'canvys' ),
                  '1.1' => __( '110%', 'canvys' ),
                  '1.2' => __( '120%', 'canvys' ),
                  '1.3' => __( '130%', 'canvys' ),
                  '1.4' => __( '140%', 'canvys' ),
                  '1.5' => __( '150%', 'canvys' ),
                  '1.6' => __( '160%', 'canvys' ),
                  '1.7' => __( '170%', 'canvys' ),
                  '1.8' => __( '180%', 'canvys' ),
                  '1.9' => __( '190%', 'canvys' ),
                  '2.0' => __( '200%', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Select_Control( 'opacity', array(
               'title'       => __( 'Opacity', 'canvys' ),
               'description' => __( 'Specify this lines opacity.', 'canvys' ),
               'default'     => '1',
               'options'     => array(
                  '1'   => __( '100%', 'canvys' ),
                  '0.9' => __( '90%', 'canvys' ),
                  '0.8' => __( '80%', 'canvys' ),
                  '0.7' => __( '70%', 'canvys' ),
                  '0.6' => __( '60%', 'canvys' ),
                  '0.5' => __( '50%', 'canvys' ),
                  '0.4' => __( '40%', 'canvys' ),
                  '0.3' => __( '30%', 'canvys' ),
                  '0.2' => __( '20%', 'canvys' ),
                  '0.1' => __( '10%', 'canvys' ),
               ),
            ) ),

         ),
      );
   }

   /**
    * Renders inline JavaScript/CSS required by the shortcode composer
    *
    * @return mixed
    */
   public function composer_additional_assets() { ?>

      <script id="cv-builder-cv_header_stack_line-script">
         (function($){
            "use strict";
            $(document).on( 'cv-composer-load-cv_header_stack_line', function() {
               var $modal = $('#cv-composer-absolute-container').children().last();
               $modal.find('.control-source select').on( 'change', function() {
                  var $this = $(this), val = $this.val(),
                      $textControls = $modal.find('.control-tag, .control-text, .control-weight'),
                      $iconControl = $modal.find('.control-icon');
                  if ( 'text' === val ) {
                     $textControls.fadeIn();
                     $iconControl.hide();
                  }
                  else {
                     $iconControl.fadeIn();
                     $textControls.hide();
                  }
               }).trigger('change');
            });
         })(jQuery);
      </script>

   <?php }

   /**
    * Callback function for displaying the template builder module title
    *
    * @param array  $atts      Array of provided attributes
    * @param string $content   Content of shortcode
    * @return string
    */
   public function builder_module_title( $atts, $content = null ) {
      $source = isset( $atts['source'] ) ? $atts['source'] : 'text';
      switch ( $source ) {
         case 'text': return isset( $atts['text'] ) && $atts['text'] ? $atts['text'] : __( 'Enter line text', 'canvys' ); break;
         case 'icon': return isset( $atts['icon'] ) && $atts['icon'] ? '<i class="icon-' . $atts['icon'] . '"></i>' : __( 'Select line icon', 'canvys' ); break;
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

      if ( ! is_array( $cv_header_stack_lines ) ) {
         $cv_header_stack_lines = array();
      }

      // Create attributes array by sanitizing provided values
      extract( $this->get_sanitized_attributes( $atts ) );

      $cv_header_stack_lines[] = array(
         'source' => $source,
         'tag' => $tag,
         'style' => $style,
         'text' => cv_parse_quicktags( $text ),
         'weight' => $weight,
         'icon' => $icon,
         'size_adjustment' => $size_adjustment,
         'opacity' => $opacity,
      );

   }

}
endif;