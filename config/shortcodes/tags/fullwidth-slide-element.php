<?php

if ( ! class_exists('CV_Fullwidth_Slide_Element') ) :

/**
 * Fullwidth slide element
 *
 * @package      WordPress
 * @subpackage   Canvys
 * @since        Version 1.0
 */
class CV_Fullwidth_Slide_Element extends CV_Shortcode {

   /**
    * Function to create shortcode configuration
    *
    * @return void
    */
   public function __construct() {

      $this->config = array(

         // Handle will be used to use this shortcode
         'handle' => 'cv_fullwidth_slide_element',

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
         'title' => __( 'Element', 'canvys' ),

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
               'title'       => __( 'Element Type', 'canvys' ),
               'description' => __( 'Specify what type of element should be displayed', 'canvys' ),
               'default'     => 'text',
               'options'     => array(
                  'text' => __( 'Textual Line', 'canvys' ),
                  'icon' => __( 'Single Icon', 'canvys' ),
                  'button' => __( 'Single Button', 'canvys' ),
               ),
            ) ),

            /* ===== Textual Line & Button Source ===== */

            new CV_Shortcode_Text_Control( 'text', array(
               'title'       => __( 'Text', 'canvys' ),
               'description' => __( 'Specify the text for this element.<br /><br /><strong>Formatting Quick Tags:</strong><br />(b)<strong>Bold</strong>(/b)<br />(i)<em>italics</em>(/i)<br />(u)<u>underlined</u>(/u)<br />(s)<del>Striked</del>(/s)<br />', 'canvys' ),
            ) ),

            /* ===== Textual Line Source ===== */

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

            /* ===== Button Source ===== */

            new CV_Shortcode_Link_Control( 'url', array(
               'title'       => __( 'URL', 'canvys' ),
               'description' => __( 'Specify the URL for this button.', 'canvys' ),
            ) ),

            new CV_Shortcode_Select_Control( 'style', array(
               'title'       => __( 'Style', 'canvys' ),
               'description' => __( 'Specify the style for this button.', 'canvys' ),
               'default'     => 'ghost',
               'options'     => array(
                  'ghost' => __( 'Ghost', 'canvys' ),
                  'filled' => __( 'Filled', 'canvys' ),
                  'glassy' => __( 'Glassy', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Select_Control( 'icon_position', array(
               'title'       => __( 'Icon Position', 'canvys' ),
               'description' => __( 'Specify whather or not this button should have an icon, and where it should be placed.', 'canvys' ),
               'default'     => 'ghost',
               'options'     => array(
                  'none' => __( 'No Icon', 'canvys' ),
                  'after' => __( 'After the button', 'canvys' ),
                  'before' => __( 'Before the button', 'canvys' ),
               ),
            ) ),

            /* ===== Icon & Button Source ===== */

            new CV_Shortcode_Icon_Control( 'icon', array(
               'title'       => __( 'Icon', 'canvys' ),
               'description' => __( 'Specify an icon to be used for this line.', 'canvys' ),
            ) ),

            /* ===== Always Visible ===== */

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
                  '1.75' => __( '175%', 'canvys' ),
                  '2.25' => __( '225%', 'canvys' ),
                  '3'    => __( '300%', 'canvys' ),
                  '4'    => __( '400%', 'canvys' ),
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

            new CV_Shortcode_Color_Control( 'color', array(
               'title'       => __( 'Element Color', 'canvys' ),
               'description' => __( 'Specify a custom color to be used for this element.', 'canvys' ),
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

      <script id="cv-builder-cv_fullwidth_slide_element-script">
         (function($){
            "use strict";
            $(document).on( 'cv-composer-load-cv_fullwidth_slide_element', function() {
               var $modal = $('#cv-composer-absolute-container').children().last();
               $modal.find('.control-source select').on( 'change', function() {
                  var $this = $(this), val = $this.val(),
                      $textControls = $modal.find('.control-tag, .control-text, .control-weight, .control-opacity'),
                      $iconControl = $modal.find('.control-icon, .control-opacity'),
                      $buttonControls = $modal.find('.control-text, .control-style, .control-icon_position, .control-url');
                  $textControls.hide().find('input,select');
                  $iconControl.hide().find('input,select');
                  $buttonControls.hide().find('input,select');
                  if ( 'text' === val ) {
                     $textControls.fadeIn().find('input,select');
                  }
                  else if ( 'icon' === val ) {
                     $iconControl.fadeIn().find('input,select');
                  }
                  else if ( 'button' === val ) {
                     $buttonControls.fadeIn().find('input,select');
                  }
                  $modal.find('.control-icon_position select').trigger('change');
               }).trigger('change');
               $modal.find('.control-icon_position select').on( 'change', function() {
                  var $this = $(this), val = $this.val(),
                      source = $modal.find('.control-source select').val(),
                      $iconPicker = $modal.find('.control-icon');
                  if ( 'icon' === source ) {
                     $iconPicker.fadeIn();
                  }
                  else if ( 'text' === source ) {
                     $iconPicker.hide();
                  }
                  else if ( 'button' === source ) {
                     if ( 'none' === val ) {
                        $iconPicker.hide();
                     }
                     else {
                        $iconPicker.fadeIn();
                     }
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
         case 'button': return isset( $atts['text'] ) && $atts['text'] ? sprintf( __( 'Button: %s', 'canvys' ), $atts['text'] ) : __( 'Enter button text', 'canvys' ); break;
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

      global $cv_fullwidth_slide_elements;

      if ( ! is_array( $cv_fullwidth_slide_elements ) ) {
         $cv_fullwidth_slide_elements = array();
      }

      // Create attributes array by sanitizing provided values
      extract( $this->get_sanitized_attributes( $atts ) );

      $cv_fullwidth_slide_elements[] = array(
         'source' => $source,
         'text' => cv_parse_quicktags( $text ),
         'tag' => $tag,
         'weight' => $weight,
         'url' => $url,
         'icon_position' => $icon_position,
         'icon' => $icon,
         'style' => $style,
         'size_adjustment' => $size_adjustment,
         'opacity' => $opacity,
         'color' => $color,
      );

   }

}
endif;