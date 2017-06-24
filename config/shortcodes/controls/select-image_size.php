<?php

if ( ! class_exists('CV_Shortcode_Select_Image_Size_Control') ) :

/**
 * Shortcode Select Control
 * used to manage each included shortcode's controls
 *
 * @package    WordPress
 * @subpackage Canvys
 * @since      Version 1.0
 */
class CV_Shortcode_Select_Image_Size_Control extends CV_Shortcode_Control {

   // Used to identify the shortcode type
   public $type = 'image_size_select';

   /**
    * Callback function for initializing the control
    *
    * @return void
    */
   public function init() {
      $this->image_sizes = array(
         'cv_full' => __( 'Full, actual size', 'canvys' ),
         'thumbnail' => __( 'Thumbnail', 'canvys' ) . ' (' . get_option( 'thumbnail_size_w' ) . ' x ' . get_option( 'thumbnail_size_h' ) . ')',
         'medium' => __( 'Medium', 'canvys' ) . ' (' . get_option( 'medium_size_w' ) . ' x ' . get_option( 'medium_size_h' ) . ')',
         'large' => __( 'Large', 'canvys' ) . ' (' . get_option( 'large_size_w' ) . ' x ' . get_option( 'large_size_h' ) . ')',
         'cv_square_small' => __( 'Small Square', 'canvys' ) . ' (150 x 150)',
         'cv_square_medium' => __( 'Medium Square', 'canvys' ) . ' (350 x 350)',
         'cv_square_large' => __( 'Large Square', 'canvys' ) . ' (650 x 650)',
      );
   }

   /**
    * Callback function for rendering only the control
    *
    * @param mixed $input The input value
    * @return string
    */
   public function render_control( $input = null ) {

      global $_wp_additional_image_sizes;

      $control = new CV_HTML( '<select>', array(
         'name' => $this->handle,
         'id'   => $this->id,
      ) );
      foreach ( $this->image_sizes as $val => $label ) {
         $control->append('<option value="' . $val . '" ' . selected( $input, $val, 0 ) . '>' . $label . '</option>');
      }
      return $control->render();
   }

   /**
    * Callback function for rendering the complete control
    *
    * @param mixed $input The input value
    * @return string
    */
   public function render_complete_control( $input = null ) {

      // Render the control
      $o  = '<div class="explanation">';
      $o .= '<label class="cv-attribute-title" for="' . $this->id . '">' . __( 'Image Size', 'canvys' ) . '</label>';
      $o .= '<p class="cv-attribute-description">' . __( 'Specify which image size to use. WordPress creates multiple versions of each image at different sizes, you can select which size image to use here. Please note that in some cases the size will not be created, if this is the case the full size image will be used.', 'canvys' ) . '</p>';
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

      // Return sanitized value
      return cv_filter( $input, array_keys( $this->image_sizes ), $this->config['default'] );

   }

}
endif;