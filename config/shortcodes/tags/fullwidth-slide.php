<?php

if ( ! class_exists('CV_Fullwidth_Slide') ) :

/**
 * Fullwidth Slider
 *
 * @package      WordPress
 * @subpackage   Canvys
 * @since        Version 1.0
 */
class CV_Fullwidth_Slide extends CV_Shortcode {

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

      // Allowed background image settings
      $overlay_opacity_options = array(
         'none' => __( 'None, do not display an overlay color', 'canvys' ),
      );

      for ( $i=10; $i<=90; $i+=10 ) {
         $overlay_opacity_options[$i] = $i . '%';
      }

      $this->config = array(

         // Handle will be used to use this shortcode
         'handle' => 'cv_fullwidth_slide',

         // Whether or not this is a shortcode composer element
         'composer_element' => false,

         // Whether or not this is a template builder element
         'builder_element' => false,

         // Used by the template builder to determine where module can be dropped
         'drop_target' => 3,

         // Used by the template builder to determine where module can have other
         // modules dropped inside of it
         'drop_zone' => false,

         // Title will be used to identify this shortcode
         'title' => __( 'Slide', 'canvys' ),

         // Icon will be used to represent this shortcode in composer/builder
         // List of available icons can be found in icons.json
         'icon' => 'doc',

         // Whether or not shortcode is self closing
         'self_closing' => false,

         // If shortcode is not self closing, specify its default content
         'default_content' => null,

         // Specify whether or not content is directly editable
         'content_editor' => false,

         // Specify whether or not the content is composed of another shortcode
         'content_element' => 'cv_fullwidth_slide_element',

         // Provide an explanation of what this shortcode does
         'explanation' => null,

         // Array of shortcode settings and their respective attributes
         'attributes' => array(

            new CV_Shortcode_Select_Control( 'entrance', array(
               'title'       => __( 'Animated Entrance', 'canvys' ),
               'description' => __( 'Specify an aminated entrance for the slide elements to come into view, animations will occur consecutively.', 'canvys' ),
               'default'     => 'none',
               'options'     => $animation_options,
            ) ),

            new CV_Shortcode_Select_Control( 'align', array(
               'title'       => __( 'Elements Alignment', 'canvys' ),
               'description' => __( 'Select how the elements in this slide should be aligned.', 'canvys' ),
               'default'     => 'center',
               'options'     => array(
                  'left'   => __( 'Left', 'canvys' ),
                  'center' => __( 'Center', 'canvys' ),
                  'right'  => __( 'Right', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Color_Control( 'default_color', array(
               'title'       => __( 'Content Color', 'canvys' ),
               'description' => __( 'Specify a custom color to be used for this slides content, if none is specified the content will be white by default.', 'canvys' ),
            ) ),

            new CV_Shortcode_Color_Control( 'bg_color', array(
               'title'       => __( 'Background Color', 'canvys' ),
               'description' => __( 'Specify a custom background color to be used for this theme, leave this blank to use the default background color.', 'canvys' ),
            ) ),

            new CV_Shortcode_Image_Control( 'bg_image', array(
               'title'       => __( 'Background Image', 'canvys' ),
               'description' => __( 'The background image for this section. This will be displayed on top of the background color.', 'canvys' ),
            ) ),

            new CV_Shortcode_Select_Control( 'bg_style', array(
               'title'       => __( 'Background Image Style', 'canvys' ),
               'description' => __( 'Whether or not the background image should be tiled, or cover the section completely. Tiled will display the image at its actual size but it will repeat to fill the section. Cover will (potentially) increase or decrease either the width or height of the image to ensure that it will cover the section, please note that the image will be scaled proportionately.', 'canvys' ),
               'default'     => 'cover',
               'options'     => array(
                  'cover'   => __( 'Cover', 'canvys' ),
                  'tile'    => __( 'Tiled', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Select_Control( 'overlay_opacity', array(
               'title'       => __( 'Background Overlay Opacity', 'canvys' ),
               'description' => __( 'Specify whether or not a color should be overlayed on top of the section background, and at what opacity.', 'canvys' ),
               'default'     => 'none',
               'options'     => $overlay_opacity_options,
            ) ),

            new CV_Shortcode_Color_Control( 'overlay_color', array(
               'title'       => __( 'Background Overlay Color', 'canvys' ),
               'description' => __( 'Specify a color to be overlayed on top of the section background.', 'canvys' ),
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

      <script id="cv-builder-cv_fullwidth_slide-script">
         (function($){
            "use strict";
            $(document).on( 'cv-composer-load-cv_fullwidth_slide', function() {
               var $modal = $('#cv-composer-absolute-container').children().last();

               // Show / Hide overlay color control
               $modal.find('.control-overlay_opacity select').on( 'change', function() {
                  var $this = $(this), val = $this.val(),
                      $colorControl = $modal.find('.control-overlay_color'),
                      $bgStyleControl = $modal.find('.control-bg_source select');
                  if ( 'none' === val ) {
                     $colorControl.hide();
                  }
                  else if ( 'default' != $bgStyleControl.val() && 'color' != $bgStyleControl.val() ) {
                     $colorControl.fadeIn();
                  }
                  else {
                     $colorControl.hide();
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
      return $this->config['title'];
   }

   /**
    * Callback function for display of preview in builder module
    *
    * @param array  $atts      Array of provided attributes
    * @param string $content   Content of shortcode
    * @return string
    */
   public function builder_module_preview( $atts, $content = null ) {

      // Create attributes array by sanitizing provided values
      extract( $this->get_sanitized_attributes( $atts ) );

      if ( $img_data = wp_get_attachment_image_src( $bg_image, 'thumbnail' ) ) {
         return '<div style="text-align:center;"><img src="' . $img_data[0] . '" alt="'.cv_get_attachment_alt( $bg_image ).'" /></div>';
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

      global $cv_fullwidth_slides, $cv_fullwidth_slide_elements;

      // Start with an empty array
      $cv_fullwidth_slide_elements = array();

      // Fill the slide elements array
      do_shortcode( $content );

      // Make sure the slides array exists
      if ( ! is_array( $cv_fullwidth_slides ) ) {
         $cv_fullwidth_slides = array();
      }

      // Create attributes array by sanitizing provided values
      extract( $this->get_sanitized_attributes( $atts ) );

      $cv_fullwidth_slides[] = array(
         'entrance'          => $entrance,
         'align'             => $align,
         'default_color'     => $default_color,
         'bg_color'          => $bg_color,
         'bg_image'          => $bg_image,
         'bg_style'          => $bg_style,
         'overlay_opacity'   => $overlay_opacity,
         'overlay_color'     => $overlay_color,
         'elements'          => $cv_fullwidth_slide_elements,
      );

   }

}
endif;