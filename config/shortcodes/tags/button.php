<?php

if ( ! class_exists('CV_Button') ) :

/**
 * Buttons
 *
 * @package      WordPress
 * @subpackage   Canvys
 * @since        Version 1.0
 */
class CV_Button extends CV_Shortcode {

   /**
    * Function to create shortcode configuration
    *
    * @return void
    */
   public function __construct() {

      $this->config = array(

         // Handle will be used to use this shortcode
         'handle' => 'cv_button',

         // Whether or not this is a shortcode composer element
         'composer_element' => true,

         // Whether or not this is a template builder element
         'builder_element' => false,

         // Used by the template builder to determine where module can be dropped
         'drop_target' => 2,

         // Used by the template builder to determine where module can have other
         // modules dropped inside of it
         'drop_zone' => false,

         // Title will be used to identify this shortcode
         'title' => __( 'Button', 'canvys' ),

         // Icon will be used to represent this shortcode in composer/builder
         // List of available icons can be found in icons.json
         'icon' => 'link',

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

            new CV_Shortcode_Text_Control( 'text', array(
               'title'       => __( 'Text', 'canvys' ),
               'description' => __( 'Specify the text for this button, if left blank the button will not be displayed.', 'canvys' ),
            ) ),

            new CV_Shortcode_Link_Control( 'url', array(
               'title'       => __( 'URL', 'canvys' ),
               'description' => __( 'Specify the URL for this button.', 'canvys' ),
            ) ),

            new CV_Shortcode_Select_Control( 'size', array(
               'title'       => __( 'Size', 'canvys' ),
               'description' => __( 'Specify the size for this button.', 'canvys' ),
               'default'     => 'standard',
               'options'     => array(
                  'small' => __( 'Small', 'canvys' ),
                  'medium' => __( 'Medium', 'canvys' ),
                  'large' => __( 'Large', 'canvys' ),
               ),
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

            new CV_Shortcode_Select_Control( 'color', array(
               'title'       => __( 'Color', 'canvys' ),
               'description' => __( 'Specify the color for this button.', 'canvys' ),
               'default'     => 'content',
               'options'     => array(
                  'theme_colors' => array(
                     'label' => __( 'Theme Colors', 'canvys' ),
                     'options' => array(
                        'content' => __( 'Normal Content', 'canvys' ),
                        'headers' => __( 'Headers', 'canvys' ),
                        'accent' => __( 'Accent', 'canvys' ),
                        'focused' => __( 'Accent Focused', 'canvys' ),
                     ),
                  ),
                  'preset_colors' => array(
                     'label' => __( 'Preset Colors', 'canvys' ),
                     'options' => array(
                        'green' => __( 'Green', 'canvys' ),
                        'blue' => __( 'Blue', 'canvys' ),
                        'red' => __( 'Red', 'canvys' ),
                     ),
                  ),
                  'custom_color' => array(
                     'label' => __( 'Select Custom', 'canvys' ),
                     'options' => array(
                        'custom' => __( 'Custom Color', 'canvys' ),
                     ),
                  ),
               ),
            ) ),

            new CV_Shortcode_Color_Control( 'custom_color', array(
               'title'       => __( 'Custom Color', 'canvys' ),
               'description' => __( 'Specify a custom color to use for this button.', 'canvys' ),
            ) ),

            new CV_Shortcode_Select_Control( 'icon_position', array(
               'title'       => __( 'Icon Position', 'canvys' ),
               'description' => __( 'Specify whether or not this button should have an icon, and where it should be placed.', 'canvys' ),
               'default'     => 'none',
               'options'     => array(
                  'none' => __( 'No Icon', 'canvys' ),
                  'after' => __( 'After the button', 'canvys' ),
                  'before' => __( 'Before the button', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Icon_Control( 'icon', array(
               'title'       => __( 'Icon', 'canvys' ),
               'description' => __( 'Specify an icon to be displayed within this button.', 'canvys' ),
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

      <script id="cv-builder-cv_button-script">
         (function($){
            "use strict";
            $(document).on( 'cv-composer-load-cv_button', function() {
               var $modal = $('#cv-composer-absolute-container').children().last();
               $modal.find('.control-color select').on( 'change', function() {
                  var $this = $(this), val = $this.val(),
                      $customColor = $modal.find('.control-custom_color');
                  if ( 'custom' === val ) {
                     $customColor.fadeIn();
                  }
                  else {
                     $customColor.hide();
                  }
               }).trigger('change');
               $modal.find('.control-icon_position select').on( 'change', function() {
                  var $this = $(this), val = $this.val(),
                      $iconPicker = $modal.find('.control-icon');
                  if ( 'none' === val ) {
                     $iconPicker.hide();
                  }
                  else {
                     $iconPicker.fadeIn();
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

         $rgb = 0.85 > cv_hex_brightness( $colors['content'] ) ? '255,255,255' : '0,0,0';
         echo
           $section_tag . " .button {"
         . "color: rgb({$rgb});"
         . "background: {$colors['content']};"
         . "}"
         . $section_tag . " .button:hover {"
         . "color: rgb({$rgb});"
         . "background:  " . cv_hex_to_rgba( $colors['content'], 0.75 ) . ";"
         . "}"
         . $section_tag . " .button.is-glassy {"
         . "border-color: " . cv_hex_to_rgba( $colors['content'], 0.25 ) . ";"
         . "background:  " . cv_hex_to_rgba( $colors['content'], 0.1 ) . ";"
         . "color: {$colors['content']};"
         . "}"
         . $section_tag . " .button.is-glassy:hover {"
         . "border-color:  " . cv_hex_to_rgba( $colors['content'], 0.5 ) . ";"
         . "background:  " . cv_hex_to_rgba( $colors['content'], 0.15 ) . ";"
         . "}"
         . $section_tag . " .button.is-ghost {"
         . "color: {$colors['content']};"
         . "background:  " . cv_hex_to_rgba( $colors['content'], 0.05 ) . ";"
         . "}"
         . $section_tag . " .button.is-ghost:hover {"
         . "background:  " . cv_hex_to_rgba( $colors['content'], 0.075 ) . ";"
         . "}"
         ;

         foreach ( $colors as $label => $color ) {
            $rgb = 0.85 > cv_hex_brightness( $color ) ? '255,255,255' : '0,0,0';
            echo
              $section_tag . " .button.color-" . $label . " {"
            . "color: rgb({$rgb});"
            . "background: {$color};"
            . "}"
            . $section_tag . " .button.color-" . $label . ":hover {"
            . "color: rgb({$rgb});"
            . "background:  " . cv_hex_to_rgba( $color, 0.75 ) . ";"
            . "}"
            . $section_tag . " .button.color-" . $label . ".is-glassy {"
            . "border-color: " . cv_hex_to_rgba( $color, 0.75 ) . ";"
            . "background:  " . cv_hex_to_rgba( $color, 0.1 ) . ";"
            . "color: {$color};"
            . "}"
            . $section_tag . " .button.color-" . $label . ".is-glassy:hover {"
            . "border-color:  " . cv_hex_to_rgba( $color, 0.75 ) . ";"
            . "background:  " . cv_hex_to_rgba( $color, 0.15 ) . ";"
            . "}"
            . $section_tag . " .button.color-" . $label . ".is-ghost {"
            . "color: {$color};"
            . "background:  " . cv_hex_to_rgba( $color, 0.05 ) . ";"
            . "}"
            . $section_tag . " .button.color-" . $label . ".is-ghost:hover {"
            . "background:  " . cv_hex_to_rgba( $color, 0.075 ) . ";"
            . "}"
            ;
         }

      }

   }

   /**
    * Callback function for displaying the template builder module title
    *
    * @param array  $atts      Array of provided attributes
    * @param string $content   Content of shortcode
    * @return string
    */
   public function builder_module_title( $atts, $content = null ) {
      extract( $this->get_sanitized_attributes( $atts ) );
      return $text ? sprintf( __( 'Button: %s', 'canvys' ), $text ) : $this->config['title'];
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
      $o = new CV_HTML( '<a>', array(
         'class' => 'cv-button button',
         'content' => $text,
      ) );

      // Add the size class
      if ( 'small' != $size ) {
         $o->add_class( 'is-' . $size );
      }

      // Add the style class
      if ( in_array( $style, array( 'ghost', 'glassy' ) ) ) {
         $o->add_class( 'is-' . $style );
      }

      // Add the color class
      if ( in_array( $color, array( 'headers', 'accent', 'focused' ) ) ) {
         $o->add_class( 'color-' . $color );
      }

      // Apply the custom color
      else if ( 'custom' == $color && $custom_color ) {
         $o->data( 'color', $custom_color );
      }

      // Apply the preset color
      else if ( in_array( $color, array( 'black', 'white', 'green', 'blue', 'red' ) ) ) {
         switch ( $color ) {
            case 'green': $color = '#8FB53E'; break;
            case 'blue': $color = '#36A7C9'; break;
            case 'red': $color = '#E63549'; break;
         }
         $rgb = 0.85 > cv_hex_brightness( $color ) ? '255,255,255' : '0,0,0';
         $o->data( 'color', $color );
         $o->data( 'rgb', $rgb );
      }

      // Apply the HREF attribute
      if ( $href = cv_get_shortcode_link_control_url( $url ) ) { $o->attr( 'href', $href ); }
      if ( cv_get_shortcode_link_control_target( $url ) ) { $o->attr( 'target', '_blank' ); }

      // Add the icon
      if ( in_array( $icon_position, array( 'before', 'after' ) ) ) {
         $icon = '<i class="button-icon icon-' . $icon . '"></i>';
         $o->add_class( 'has-icon icon-' . $icon_position );
         $o->append( $icon );
      }

      return $o->render();

   }

}
endif;