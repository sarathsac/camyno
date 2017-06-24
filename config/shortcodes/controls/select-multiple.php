<?php

if ( ! class_exists('CV_Shortcode_Multiple_Select_Control') ) :

/**
 * Shortcode Select Control
 * used to manage each included shortcode's controls
 *
 * @package    WordPress
 * @subpackage Canvys
 * @since      Version 1.0
 */
class CV_Shortcode_Multiple_Select_Control extends CV_Shortcode_Control {

   // Used to identify the shortcode type
   public $type = 'multiple-select';

   /**
    * Callback function for rendering only the control
    *
    * @param mixed $input The input value
    * @return string
    */
   public function render_control( $input = null ) {

      // Control wrapper
      $control = new CV_HTML( '<select>', array(
         'name' => $this->handle,
         'id'   => $this->id,
         'multiple' => 'multiple',
         'style' => 'height:150px;',
      ) );

      // Convert input to array
      $input = $input ? explode( ',', $input ) : array();

      // Add the options
      foreach ( $this->config['options'] as $slug => $name ) {
         $control->append('<option value="' . $slug . '" ' . selected( in_array( $slug, $input ), true, 0 ) . '>' . $name . '</option>');
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

      // Convert input to an array
      $input = $input ? explode( ',', $input ) : array();

      // Start with empty string
      $sanitized = null;

      // Allowed values
      $allowed = array_keys( $this->config['options'] );

      foreach ( $input as $input ) {
         if ( in_array( $input, $allowed ) ) {
            $sanitized .= $input . ',';
         }
      }

      // Return sanitized value
      return trim( $sanitized, ',' );

   }

}
endif;