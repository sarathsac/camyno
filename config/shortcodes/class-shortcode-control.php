<?php

if ( ! class_exists('CV_Shortcode_Control') ) :

/**
 * Shortcode Control Template
 * used to manage each included shortcode's controls
 *
 * @package    WordPress
 * @subpackage Canvys
 * @since      Version 1.0
 */
class CV_Shortcode_Control {

   // Used to identify the shortcode type
   public $type = 'none';

   /**
    * Initially load the template builder
    *
    * @return void
    */
   public function __construct( $handle, $config ) {

      $this->handle = $handle;
      $this->config = $config;
      $this->id = "cv-composer-control-{$handle}";
      $this->init();

      // Make sure a default value was set
      if ( ! array_key_exists( 'default', $this->config ) ) {
         $this->config['default'] = null;
      }

   }

   /**
    * Callback function for initializing the control
    *
    * @return void
    */
   public function init() {}

   /**
    * Renders inline JavaScript/CSS required by the shortcode composer
    *
    * @return mixed
    */
   static function composer_additional_assets() {}

   /**
    * Renders inline CSS required by the shortcode composer
    *
    * @return mixed
    */
   static function composer_additional_styles() {}

   /**
    * Callback function for rendering only the control
    *
    * @param mixed $input The input value
    * @return string
    */
   public function render_control( $input = null ) { return null; }

   /**
    * Callback function for rendering the complete control
    *
    * @param mixed $input The input value
    * @return string
    */
   public function render_complete_control( $input = null ) {

      // Render the control
      $o  = '<div class="explanation">';
      $o .= '<label class="cv-attribute-title" for="' . $this->id . '">' . $this->config['title'] . '</label>';
      if ( isset( $this->config['description'] ) ) {
         $o .= '<p class="cv-attribute-description">' . $this->config['description'] . '</p>';
      }
      $o .= '</div>';
      $o .= '<div class="control attribute-control">';
      $o .= $this->render_control( $input );
      $o .= '</div>';
      return $o;

   }

   /**
    * Sanitize any user input
    *
    * @param mixed $input The input value
    * @return string
    */
   public function sanitize_input( $input = null ) {

      // no sanitization by default
      return $input;

   }

}
endif;