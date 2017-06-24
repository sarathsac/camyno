<?php

if ( ! class_exists('CV_Shortcode_Page_Select_Control') ) :

/**
 * Page Select Control
 * used to manage each included shortcode's controls
 *
 * @package    WordPress
 * @subpackage Canvys
 * @since      Version 1.0
 */
class CV_Shortcode_Page_Select_Control extends CV_Shortcode_Control {

   // Used to identify the shortcode type
   public $type = 'page_select';

   /**
    * Callback function for rendering only the control
    *
    * @param mixed $input The input value
    * @return string
    */
   public function render_control( $input = null ) {

      return wp_dropdown_pages( array(
         'selected' => $input,
         'echo'     => 0,
         'name'     => $this->handle,
      ) );

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