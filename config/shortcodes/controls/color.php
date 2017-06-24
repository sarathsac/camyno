<?php

if ( ! class_exists('CV_Shortcode_Color_Control') ) :

/**
 * Shortcode Color Picker Control
 * used to manage each included shortcode's controls
 *
 * @package    WordPress
 * @subpackage Canvys
 * @since      Version 1.0
 */
class CV_Shortcode_Color_Control extends CV_Shortcode_Control {

   // Used to identify the shortcode type
   public $type = 'color';

   /**
    * Renders inline JavaScript/CSS required by the shortcode composer
    *
    * @return mixed
    */
   static function composer_additional_assets() { ?>

      <script id="cv-composer-color-control-script">
         (function($) {
            "use strict";
            $(document).on( 'cv-composer-load', function() {
               $('.cv-composer-color-picker').wpColorPicker();
            });
         })(jQuery);
      </script>

   <?php }

   /**
    * Renders inline CSS required by the shortcode composer
    *
    * @return mixed
    */
   static function composer_additional_styles() { ?>

      <style id="cv-composer-color-control-style">
         .cv-composer-modal .wp-picker-input-wrap {
            display: block !important;
            margin: 5px 0 !important;
         }
         .wp-picker-input-wrap input {
            width: 50% !important;
            padding: 5px !important;
            -webkit-border-radius: 0px !important;
            border-radius: 0px !important;
         }
         html:not([dir="rtl"]) .cv-composer-modal .cv-compose-shortcode .attribute-control .wp-picker-input-wrap input[type="text"] {
            border-right: 0 !important;
         }

         html[dir="rtl"] .cv-composer-modal .cv-compose-shortcode .attribute-control .wp-picker-input-wrap input[type="text"] {
            border-left: 0 !important;
         }
      </style>

   <?php }

   /**
    * Callback function for rendering only the control
    *
    * @param mixed $input The input value
    * @return string
    */
   public function render_control( $input = null ) {
      $control = new CV_HTML( '<input />', array(
         'class' => 'cv-composer-color-picker',
         'type'  => 'text',
         'name'  => $this->handle,
         'id'    => $this->id,
         'value' => $input,
         'data-default-color' => $this->config['default'],
      ) );
      return $control->render();
   }

   /**
    * Sanitize any user input
    *
    * @param mixed $input The input value
    * @return string
    */
   public function sanitize_input( $input = null ) {

      return $input;

   }

}
endif;