<?php

if ( ! class_exists('CV_Shortcode_Number_Control') ) :

/**
 * Shortcode Number Control
 * used to manage each included shortcode's controls
 *
 * @package    WordPress
 * @subpackage Canvys
 * @since      Version 1.0
 */
class CV_Shortcode_Number_Control extends CV_Shortcode_Control {

   // Used to identify the shortcode type
   public $type = 'number';

   /**
    * Callback function for rendering only the control
    *
    * @param mixed $input The input value
    * @return string
    */
   public function render_control( $input = null ) {
      $control = new CV_HTML( '<input />', array(
         'type'  => 'text',
         'name'  => $this->handle,
         'id'    => $this->id,
         'value' => $input,
      ) );

      if ( isset( $this->config['placeholder'] ) ) {
         $control->attr( 'placeholder', $this->config['placeholder'] );
      }

      return $control->render();
   }

   /**
    * Sanitize any user input
    *
    * @param mixed $input The input value
    * @return string
    */
   public function sanitize_input( $input = null ) {
      return cv_filter( $input, 'integer' );
   }

}
endif;