<?php

if ( ! class_exists('CV_Button_Group_Button') ) :

/**
 * Buttons as child element of a button group
 *
 * @package      WordPress
 * @subpackage   Canvys
 * @since        Version 1.0
 */
class CV_Button_Group_Button extends CV_Shortcode {

   /**
    * Function to create shortcode configuration
    *
    * @return void
    */
   public function __construct() {

      $this->config = array(

         // Handle will be used to use this shortcode
         'handle' => 'cv_button_child',

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
               'description' => __( 'Specify whather or not this button should have an icon, and where it should be placed.', 'canvys' ),
               'default'     => 'ghost',
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

      <script id="cv-builder-cv_button_child-script">
         (function($){
            "use strict";
            $(document).on( 'cv-composer-load-cv_button_child', function() {
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
    * Renders inline CSS required by the shortcode composer
    *
    * @return mixed
    */
   public function composer_additional_styles() { ?>

      <style id="cv-builder-cv_button_child">

         /* Style different sizes */
         @media (min-width: 800px) {
            .cv-module-preview .cv-module-cv_button_child {
               width: 23% !important;
               float: left;
               clear: none;
               margin-left: 1%;
               margin-right: 1%;
               text-align: center;
            }
         }

      </style>

   <?php }

   /**
    * Callback function for displaying the template builder module title
    *
    * @param array  $atts      Array of provided attributes
    * @param string $content   Content of shortcode
    * @return string
    */
   public function builder_module_title( $atts, $content = null ) {
      extract( $this->get_sanitized_attributes( $atts ) );
      return $text ? $text : $this->config['title'];
   }

   /**
    * Callback function for front end display of shortcode
    *
    * @param array  $atts      Array of provided attributes
    * @param string $content   Content of shortcode
    * @return string
    */
   public function callback( $atts, $content = null ) {

      global $cv_buttons;

      if ( ! is_array( $cv_buttons ) ) {
         $cv_buttons = array();
      }

      // Create attributes array by sanitizing provided values
      extract( $this->get_sanitized_attributes( $atts ) );

      $cv_buttons[] = array(
         'text'   => $text,
         'url'   => $url,
         'style' => $style,
         'color' => $color,
         'custom_color' => $custom_color,
         'icon_position' => $icon_position,
         'icon' => $icon,
      );

   }

}
endif;