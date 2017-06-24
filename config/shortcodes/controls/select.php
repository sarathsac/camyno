<?php

if ( ! class_exists('CV_Shortcode_Select_Control') ) :

/**
 * Shortcode Select Control
 * used to manage each included shortcode's controls
 *
 * @package    WordPress
 * @subpackage Canvys
 * @since      Version 1.0
 */
class CV_Shortcode_Select_Control extends CV_Shortcode_Control {

   // Used to identify the shortcode type
   public $type = 'select';

   /**
    * Callback function for rendering only the control
    *
    * @param mixed $input The input value
    * @return string
    */
   public function render_control( $input = null ) {
      $control = new CV_HTML( '<select>', array(
         'name' => $this->handle,
         'id'   => $this->id,
      ) );
      foreach ( $this->config['options'] as $slug => $config ) {
         if ( ! is_array( $config ) ) {
            $control->append('<option value="' . $slug . '" ' . selected( $input, $slug, 0 ) . '>' . $config . '</option>');
            continue;
         }
         $group = new CV_HTML( '<optgroup>', array(
            'label' => $config['label'],
         ) );
         foreach ( $config['options'] as $val => $label ) {
            $group->append('<option value="' . $val . '" ' . selected( $input, $val, 0 ) . '>' . $label . '</option>');
         }
         $control->append( $group );
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

      $allowed = array();

      // Create usable array of options
      foreach ( $this->config['options'] as $slug => $config ) {
         if ( ! is_array( $config ) ) {
            $allowed[] = $slug;
            continue;
         }
         foreach ( $config['options'] as $val => $label ) {
            $allowed[] = $val;
         }
      }

      // Return sanitized value
      return cv_filter( $input, $allowed, $this->config['default'] );

   }

}
endif;