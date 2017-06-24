<?php

if ( ! class_exists('CV_Shortcode_Layout_Control') ) :

/**
 * Shortcode Column layout Control
 * used to manage each included shortcode's controls
 *
 * @package    WordPress
 * @subpackage Canvys
 * @since      Version 1.0
 */
class CV_Shortcode_Layout_Control extends CV_Shortcode_Control {

   // Used to identify the shortcode type
   public $type = 'layout';

   /**
    * Renders inline CSS required by the shortcode composer
    *
    * @return mixed
    */
   static function composer_additional_styles() { ?>
      <style id="cv-composer-layout-control-style">
         .cv-composer-layout-option label,
         .cv-composer-layout-option .column {
            -webkit-transition: all 0.15s ease;
            -moz-transition: all 0.15s ease;
            -ms-transition: all 0.15s ease;
            -o-transition: all 0.15s ease;
            transition: all 0.15s ease;
         }

         .cv-composer-layout-option .column {
            -webkit-border-radius: 3px !important;
            border-radius: 3px !important;
            background: #eee;
            text-align: center;
            letter-spacing: 2px;
            font-weight: 600;
            color: #888;
            text-shadow: #fff 0px 1px 2px;
            padding: 15px 0;
         }
         .cv-composer-layout-option input {
            display: none
         }
         .cv-composer-layout-option label {
            display: block;
            padding: 10px;
            margin: 5px 0;
            background: #fff;
            border: 1px solid transparent;
            -webkit-border-radius: 3px !important;
            border-radius: 3px !important;
         }
         .cv-composer-layout-option label:hover {
            border: 1px solid #eee;
            background: #f9f9f9;
         }
         .cv-composer-layout-option input:checked + label {
            border: 1px solid #A2D164;
            background: #F0F7E6;
         }
         .cv-composer-layout-option label:hover .column {
            text-shadow: none;
            background: #888;
            color: #fff;
         }
         .cv-composer-layout-option input:checked + label .column {
            text-shadow: #111 0px 1px 2px;
            background: #666;
            color: #fff;
         }
      </style>
   <?php }

   /**
    * Callback function for rendering only the control
    *
    * @param mixed $input The input value
    * @return string
    */
   public function render_complete_control( $input = null ) {

      global $canvys;

      $last_num_columns = '2';

      $o  = '<div class="control-padding">';
      $o .= '<div style="max-width:600px;margin:0 auto;">';
      $o .= '<strong style="display:block;margin:25px 0;text-align:center;font-size: 16px;">' . __( 'Column Layout', 'canvys' ) . '</strong>';
      $o .= '<strong style="display:block;margin:10px 0;text-align:center;font-weight:200;">' . __( '2 Columns', 'canvys' ) . '</strong>';

      foreach ( $canvys['column_layouts'] as $layout => $description ) {

         // Turn description into an array
         $description = explode( ' - ', $description );

         // Make layout into a usable value
         $layout_value = $layout;
         $layout = str_replace( array('/', '+'), array('', '-'), $layout );

         // Determine number of columns
         switch ( $layout ) {
            case '12': $num_columns = 2; $layout = '2'; break;
            case '13': $num_columns = 3; $layout = '3'; break;
            case '14': $num_columns = 4; $layout = '4'; break;
            case '15': $num_columns = 5; $layout = '5'; break;
            case '16': $num_columns = 6; $layout = '6'; break;
            default: $num_columns = count( explode( '-', $layout ) ); break;
         }

         if ( $num_columns != $last_num_columns ) {
            $last_num_columns = $num_columns;
            $o .= '<strong style="display:block;margin:10px 0;text-align:center;font-weight:200;">' . sprintf( __( '%s Columns', 'canvys' ), $num_columns ) . '</strong>';
         }

         $o .= '<div class="cv-composer-layout-option">';
         $o .= '<input ' . checked( $layout_value, $input, 0 ) . ' type="radio" id="' . $this->id . '-' . $layout_value . '" name="' . $this->handle . '" value="' . $layout_value . '" />';
         $o .= '<label for="' . $this->id . '-' . $layout_value . '">';
         $o .= '<div class="cv-split-' . $layout . ' has-clearfix spacing-1 not-responsive">';

         // Display the columns
         for ( $i=0; $i<$num_columns; $i++ ) {
            $sizes = explode( '/', $description[$i] );
            $size = round( ( $sizes[0] / $sizes[1] ), 3 );
            $size = $size*100 . '%';
            $o .= '<div>';
            $o .= '<div class="column">' . $size . '</div>';
            $o .= '</div>';
         }

         $o .= '</div>';
         $o .= '</label>';
         $o .= '</div>';

      }

      $o .= '</div>';
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
      global $canvys;
      $allowed = array();
      foreach ( $canvys['column_layouts'] as $option => $label ) {
         $allowed[] = $option;
      }
      return cv_filter( $input, $allowed, $this->config['default'] );
   }

}
endif;