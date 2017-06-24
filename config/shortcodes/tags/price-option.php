<?php

if ( ! class_exists('CV_Price_Option') ) :

/**
 * Price table option
 *
 * @package      WordPress
 * @subpackage   Canvys
 * @since        Version 1.0
 */
class CV_Price_Option extends CV_Shortcode {

   /**
    * Function to create shortcode configuration
    *
    * @return void
    */
   public function __construct() {

      $this->config = array(

         // Handle will be used to use this shortcode
         'handle' => 'cv_price_option',

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
         'title' => __( 'Price Option', 'canvys' ),

         // Icon will be used to represent this shortcode in composer/builder
         // List of available icons can be found in icons.json
         'icon' => 'tag',

         // Whether or not shortcode is self closing
         'self_closing' => false,

         // If shortcode is not self closing, specify its default content
         'default_content' =>  null,

         // Specify whether or not content is directly editable
         'content_editor' => false,

         // Specify whether or not the content is composed of another shortcode
         'content_element' => false,

         // Array of shortcode settings and their respective attributes
         'attributes' => array(

            new CV_Shortcode_Text_Control( 'title', array(
               'title'       => __( 'Title', 'canvys' ),
               'description' => __( 'Specify the title of this option.', 'canvys' ),
            ) ),

            new CV_Shortcode_Text_Control( 'price', array(
               'title'       => __( 'Price', 'canvys' ),
               'description' => __( 'Specify the price of this option.', 'canvys' ),
            ) ),

            new CV_Shortcode_Text_Control( 'below_price', array(
               'title'       => __( 'Text Below Price', 'canvys' ),
               'description' => __( 'Enter any text that should be displayed underneath the price, such as recrring payment information.', 'canvys' ),
            ) ),

            new CV_Shortcode_List_Control( 'attributes', array(
               'title'       => __( 'Attributes', 'canvys' ),
               'description' => __( 'Vertical Bar delimited list of attributes. Example: Attribute 1|Attribute 2|Attribute 3', 'canvys' ),
               'separator'   => '|',
            ) ),

            new CV_Shortcode_Text_Control( 'text', array(
               'title'       => __( 'Button Text', 'canvys' ),
               'description' => __( 'Specify the text for the button, if left blank the button will not be displayed.', 'canvys' ),
            ) ),

            new CV_Shortcode_Link_Control( 'url', array(
               'title'       => __( 'URL', 'canvys' ),
               'description' => __( 'Specify the URL for the button.', 'canvys' ),
            ) ),

            new CV_Shortcode_Select_Control( 'icon_position', array(
               'title'       => __( 'Icon Position', 'canvys' ),
               'description' => __( 'Specify whether or not the button should have an icon, and where it should be placed.', 'canvys' ),
               'default'     => 'none',
               'options'     => array(
                  'none' => __( 'No Icon', 'canvys' ),
                  'after' => __( 'After the button', 'canvys' ),
                  'before' => __( 'Before the button', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Icon_Control( 'icon', array(
               'title'       => __( 'Icon', 'canvys' ),
               'description' => __( 'Specify an icon to be displayed within the button.', 'canvys' ),
            ) ),

            new CV_Shortcode_Select_Control( 'featured', array(
               'title'       => __( 'Featured Option', 'canvys' ),
               'description' => __( 'Specify whether or not this option should be featured.', 'canvys' ),
               'default'     => 'false',
               'options'     => array(
                  'false'    => __( 'No, this option should be displayed normally', 'canvys' ),
                  'true'      => __( 'Yes, this option should be featured', 'canvys' ),
               ),
            ) ),

         ),
      );
   }

   /**
    * Callback function for display of preview in builder module
    *
    * @param array  $atts      Array of provided attributes
    * @param string $content   Content of shortcode
    * @return string
    */
   public function builder_module_preview( $atts, $content = null ) {
      if ( ! isset( $atts['attributes'] ) || ! $atts['attributes'] ) {
         return false;
      }
      $attributes = explode( '|', $atts['attributes'] );
      $o = '<ul class="has-clearfix">';
      foreach ( $attributes as $attribute ) {
         $o .= '<li>' . $attribute . '</li>';
      }
      $o .= '</ul>';
      return $o;
   }

   /**
    * Renders inline JavaScript/CSS required by the shortcode composer
    *
    * @return mixed
    */
   public function composer_additional_assets() { ?>

      <script id="cv-builder-cv_price_option-script">
         (function($){
            "use strict";
            $(document).on( 'cv-composer-load-cv_price_option', function() {
               var $modal = $('#cv-composer-absolute-container').children().last();
               $modal.find('.control-text input').on( 'change keyup', function() {
                  var $this = $(this), val = $this.val(),
                      $buttonControls = $modal.find('.control-icon_position, .control-url');
                  if ( val ) {
                     $buttonControls.fadeIn().find('input,select');
                     $modal.find('.control-icon_position').trigger('change');
                  }
                  else {
                     $buttonControls.hide().find('input,select');
                     $modal.find('.control-icon_position').trigger('change');
                  }
               }).trigger('change');
               $modal.find('.control-icon_position select').on( 'change', function() {
                  var $this = $(this), val = $this.val(),
                      buttonText = $modal.find('.control-text input').val(),
                      $iconPicker = $modal.find('.control-icon');
                  if ( ! buttonText || 'none' === val ) {
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

      <style id="cv-builder-cv_price_option-preview">
         .cv-module-cv_price_option .cv-module-preview ul {
            list-style: none !important;
            margin: 0;
         }
         .cv-module-cv_price_option .cv-module-preview li {
            padding: 5px 10px;
            border: 1px solid rgba(0,0,0,0.05);
            background: rgba(255,255,255,0.5);
            margin: 3px;
            -webkit-border-radius: 3px;
            border-radius: 3px;
            font-weight: 400;
         }
         html:not([dir="rtl"]) .cv-module-cv_price_option .cv-module-preview li {
            float: left;
         }
         html[dir="rtl"] .cv-module-cv_price_option .cv-module-preview li {
            float: right;
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

      global $cv_price_options;

      if ( ! is_array( $cv_price_options ) ) {
         $cv_price_options = array();
      }

      // Create attributes array by sanitizing provided values
      extract( $this->get_sanitized_attributes( $atts ) );

      $cv_price_options[] = array(
         'title'   => $title,
         'price' => $price,
         'below_price' => $below_price,
         'attributes' => $attributes,
         'featured' => $featured,
         'text' => $text,
         'url' => $url,
         'icon_position' => $icon_position,
         'icon' => $icon,
      );

   }

   /**
    * Callback function for displaying the template builder module title
    *
    * @param array  $atts      Array of provided attributes
    * @param string $content   Content of shortcode
    * @return string
    */
   public function builder_module_title( $atts, $content = null ) {
      return isset($atts['title']) && $atts['title'] ? $atts['title'] : $this->config['title'];
   }

}
endif;