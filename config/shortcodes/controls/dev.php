<?php

if ( ! class_exists('CV_Shortcode_Dev_Control') ) :

/**
 * Shortcode Text Control
 * used to manage each included shortcode's controls
 *
 * @package    WordPress
 * @subpackage Canvys
 * @since      Version 1.0
 */
class CV_Shortcode_Dev_Control extends CV_Shortcode_Control {

   // Used to identify the shortcode type
   public $type = 'developer';

   /**
    * Callback function for rendering the complete control
    *
    * @param mixed $input The input value
    * @return string
    */
   public function render_complete_control( $input = null ) { return null; }

   /**
    * Renders inline CSS required by the shortcode composer
    *
    * @return mixed
    */
   static function composer_additional_styles() { ?>

      <style id="cv-composer-developer-control-style">
         .control-wrap[data-type="developer"] { display: none !important; }
      </style>

   <?php }

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