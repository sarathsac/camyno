<?php

if ( ! class_exists('CV_Divider') ) :

/**
 * Dividers
 *
 * @package      WordPress
 * @subpackage   Canvys
 * @since        Version 1.0
 */
class CV_Divider extends CV_Shortcode {

   /**
    * Function to create shortcode configuration
    *
    * @return void
    */
   public function __construct() {

      $this->config = array(

         // Handle will be used to use this shortcode
         'handle' => 'cv_divider',

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
         'title' => __( 'Divider', 'canvys' ),

         // Icon will be used to represent this shortcode in composer/builder
         // List of available icons can be found in icons.json
         'icon' => 'minus',

         // Whether or not shortcode is self closing
         'self_closing' => true,

         // If shortcode is not self closing, specify its default content
         'default_content' => null,

         // Specify whether or not content is directly editable
         'content_editor' => false,

         // Specify whether or not the content is composed of another shortcode
         'content_element' => false,

         // Array of shortcode settings and their respective attributes
         'attributes' => array(

            new CV_Shortcode_Select_Control( 'width', array(
               'title'       => __( 'Width', 'canvys' ),
               'description' => __( 'Specify the width of this divider.', 'canvys' ),
               'default'     => '75',
               'options'     => array(
                  '25' => __( '25%', 'canvys' ),
                  '50' => __( '50%', 'canvys' ),
                  '75' => __( '75%', 'canvys' ),
                  '100' => __( '100%', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Select_Control( 'align', array(
               'title'       => __( 'Alignment', 'canvys' ),
               'description' => __( 'Select how this divider should be aligned.', 'canvys' ),
               'default'     => 'center',
               'options'     => array(
                  'left'   => __( 'Left', 'canvys' ),
                  'center' => __( 'Center', 'canvys' ),
                  'right'  => __( 'Right', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Color_Control( 'base_color', array(
               'title'       => __( 'Base Color', 'canvys' ),
               'description' => __( 'Specify a custom color to be used for the base of this divider. If this is left blank the borders color for the section will be used.', 'canvys' ),
            ) ),

            new CV_Shortcode_Select_Control( 'style', array(
               'title'       => __( 'Style', 'canvys' ),
               'description' => __( 'Specify which style of divider should be displayed', 'canvys' ),
               'default'     => 'simple',
               'options'     => array(
                  'simple'   => __( 'Simple line divider', 'canvys' ),
                  'styled' => __( 'Line divider with square accent', 'canvys' ),
                  'text'  => __( 'With textual label', 'canvys' ),
                  'icon' => __( 'With single icon', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Text_Control( 'text', array(
               'title'       => __( 'Divider Text', 'canvys' ),
               'description' => __( 'Specify the text to be displayed within the divider.', 'canvys' ),
            ) ),

            new CV_Shortcode_Icon_Control( 'icon', array(
               'title'       => __( 'Icon', 'canvys' ),
               'description' => __( 'Specify an icon to be used for this divider.', 'canvys' ),
            ) ),

            new CV_Shortcode_Color_Control( 'accent', array(
               'title'       => __( 'Accent Color', 'canvys' ),
               'description' => __( 'Specify a custom color to be used for the accent of this divider. If this is left blank the accent color for the section will be used.', 'canvys' ),
            ) ),

            new CV_Shortcode_Select_Control( 'margins', array(
               'title'       => __( 'Margins', 'canvys' ),
               'description' => __( 'Use this control to specify the size of the white space before and after this divider.', 'canvys' ),
               'default'     => 'small',
               'options'     => array(
                  'small'  => __( 'Small', 'canvys' ),
                  'medium' => __( 'Medium', 'canvys' ),
                  'large'  => __( 'Large', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Text_Control( 'custom_margins', array(
               'title'       => __( 'Custom Margins Size', 'canvys' ),
               'description' => __( 'Enter a value here to override the default margins, value must include units for example "50px" or "3em".', 'canvys' ),
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

      <script id="cv-builder-cv_divider-script">
         (function($){
            "use strict";
            $(document).on( 'cv-composer-load-cv_divider', function() {
               var $modal = $('#cv-composer-absolute-container').children().last();
               $modal.find('.control-style select').on( 'change', function() {
                  var $this = $(this), val = $this.val(),
                      $textControls = $modal.find('.control-text'),
                      $iconControls = $modal.find('.control-icon'),
                      $styledControls = $modal.find('.control-accent');
                  $textControls.hide();
                  $iconControls.hide();
                  $styledControls.hide();
                  switch ( val ) {
                     case 'text':
                        $textControls.fadeIn();
                        break;
                     case 'icon':
                        $iconControls.fadeIn();
                        break;
                     case 'styled':
                        $styledControls.fadeIn();
                        break;
                  }
               }).trigger('change');
            });
         })(jQuery);
      </script>

   <?php }

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
           $section_tag . " .cv-divider .divider-inner {"
         . "background: {$colors['borders']};"
         . "color: " . cv_hex_to_rgba( $colors['content'], 0.75 ) . ";"
         . "}"
         . $section_tag . " .cv-divider .divider-inner.textual-divider .divider-text {"
         . "background: {$colors['primary_bg']};"
         . "}"
         . $section_tag . " .cv-divider .divider-inner.icon-divider .divider-text {"
         . "background: {$colors['primary_bg']};"
         . "}"
         . $section_tag . " .cv-divider .divider-inner.styled-divider .divider-accent {"
         . "background: {$colors['primary_bg']};"
         . "box-shadow: {$colors['primary_bg']} 0px 0px 0px 10px;"
         . "border: 2px solid {$colors['accent']};"
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

      // Create attributes array by sanitizing provided values
      extract( $this->get_sanitized_attributes( $atts ) );

      // Create the container
      $o = new CV_HTML( '<div>', array(
         'class' => 'divider-inner',
      ) );

      switch ( $style ) {

         /* With textual label */
         case 'text':
            $o->add_class( 'textual-divider' );
            if ( $text ) $o->append( '<p class="divider-text">' . $text . '</p>' );
            break;

         /* With single icon */
         case 'icon':
            $o->add_class( 'icon-divider' );
            if ( $icon ) $o->append( '<p class="divider-text"><i class="divider-icon icon-' . $icon . '"></i></p>' );
            break;

            /* With radial accent */
         case 'styled':
            $o->add_class( 'styled-divider' );
            $color_style = $accent ? ' style="border-color:' . $accent . ';"' : null;
            $o->append( '<div class="divider-accent"' . $color_style . '></div>' );
            break;

      }

      // Apply the width style
      $o->css( 'width', $width . '%' );

      // Apply the align style
      $o->add_class( 'align-' . $align );

      // Apply the custom color
      if ( $base_color ) $o->css( 'background-color', $base_color );
      if ( $base_color ) $o->css( 'color', $base_color );

      // Determine the margins size
      switch ( $margins ) {
        case 'small':  $margins = '1em'; break;
        case 'medium': $margins = '3em'; break;
        case 'large':  $margins = '5em'; break;
      }
      $margins = $custom_margins ? $custom_margins : $margins;

      // Render the divider
      return '<div class="cv-divider has-clearfix" style="margin:' . $margins . ' 0;">' . $o->render() . '</div>';

   }

}
endif;