<?php

if ( ! class_exists('CV_Shortcode_Sidebar_Select_Control') ) :

/**
 * Shortcode Sidebar Select Control
 * used to manage each included shortcode's controls
 *
 * @package    WordPress
 * @subpackage Canvys
 * @since      Version 1.0
 */
class CV_Shortcode_Sidebar_Select_Control extends CV_Shortcode_Control {

   // Used to identify the shortcode type
   public $type = 'sidebar_select';

   /**
    * Callback function for rendering only the control
    *
    * @param mixed $input The input value
    * @return string
    */
   public function render_control( $input = null ) {

      // Gather Sidebars
      $sidebars = array();
      foreach ( cv_get_sidebars() as $slug => $config ) {
         $sidebars[$slug] = $config['name'];
      }

      $control = new CV_HTML( '<select>', array(
         'name' => $this->handle,
         'id'   => $this->id,
      ) );
      foreach ( $sidebars as $val => $label ) {
         $control->append('<option value="' . $val . '" ' . selected( $input, $val, 0 ) . '>' . $label . '</option>');
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

      // Gather Sidebars
      $sidebars = array();
      foreach ( cv_get_sidebars() as $slug => $config ) {
         $sidebars[$slug] = $config['name'];
      }

      // Return sanitized value
      return cv_filter( $input, array_keys( $sidebars ), $this->config['default'] );

   }

}
endif;