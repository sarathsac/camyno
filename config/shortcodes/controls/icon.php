<?php

if ( ! class_exists('CV_Shortcode_Icon_Control') ) :

/**
 * Shortcode Icon Picker Control
 * used to manage each included shortcode's controls
 *
 * @package    WordPress
 * @subpackage Canvys
 * @since      Version 1.0
 */
class CV_Shortcode_Icon_Control extends CV_Shortcode_Control {

   // Used to identify the shortcode type
   public $type = 'iconpicker';

   /**
    * Callback function for initializing the control
    *
    * @return void
    */
   public function init() {
      $this->icons = array();
      ob_start();
      include THEME_PATH . 'inc/icons.json';
      $json_object = ob_get_clean();
      $icons = json_decode( $json_object, true );
      $icons = $icons['glyphs'];
      foreach ( $icons as $icon ) {
         $this->icons[] = $icon['css'];
      }
      $this->config['default'] = 'mail-1';
   }

   /**
    * Renders inline CSS required by the shortcode composer
    *
    * @return mixed
    */
   static function composer_additional_styles() { ?>

      <style id="cv-composer-icon-control-style">
         .cv-icon-picker {
            overflow-y: auto;
            overflow-x: hidden;
            border: 1px solid #ddd;
            height: 360px;
         }
         .cv-icon-picker input {
            display: none;
         }
         .cv-icon-picker label {
            float: left;
            width: 20%;
            height: 60px;
            line-height: 60px;
            text-align: center;
            font-size: 22px;
            border: 1px solid #f9f9f9;
            color: #555;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
         }
         @media (min-width: 600px) {
            .cv-icon-picker label {
               width: 12.5%;
            }
         }
         @media (min-width: 900px) {
            .cv-icon-picker label {
               width: 8.33%;
            }
         }
         .cv-icon-picker label:hover {
            background: #f9f9f9;
            color: #000;
         }
         .cv-icon-picker input:checked + label {
            color: #000;
            border: 1px solid #A2D164;
            background: #F0F7E6;
         }
      </style>

   <?php }

   /**
    * Callback function for rendering the complete control
    *
    * @param mixed $input The input value
    * @return string
    */
   public function render_complete_control( $input = null ) {

      if ( ! $input ) {
         $input = 'mail-1';
      }

      $o  = '<div class="control-padding">';
      $o .= '<label class="cv-attribute-title" for="' . $this->id . '">' . $this->config['title'] . '</label>';
      if ( isset( $this->config['description'] ) ) {
         $o .= '<p class="cv-attribute-description">' . $this->config['description'] . '</p>';
      }
      $o .= '<div class="cv-icon-picker">';

      foreach ( $this->icons as $icon ) {
         $o .= '<input ' . checked( $icon, $input, 0 ) . ' type="radio" id="' . $this->id . '-' . $icon . '" name="' . $this->handle . '" value="' . $icon . '" />';
         $o .= '<label for="' . $this->id . '-' . $icon . '" title="' . $icon . '"><i class="icon-' . $icon . '"></i></label>';
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

      // Return sanitized value
      return cv_filter( $input, $this->icons, 'mail-1' );

   }

}
endif;