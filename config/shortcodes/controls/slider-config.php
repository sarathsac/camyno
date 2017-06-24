<?php

if ( ! function_exists( 'cv_apply_slider_config_attributes' ) ) :

/**
 * Converts the value used to create a shortcode link attribute to usable HTML attributes
 *
 * @return CV_HTML
 */
function cv_apply_slider_config_attributes( $obj, $input = null ) {

   $transition_options = array(
      'horizontal', 'vertical', 'fade',
   );

   $auto_options = array(
      'false', 'true',
   );

   $controls_options = array(
      'both','controls','pager','none',
   );

   $config = explode( '|', $input );
   $transition = cv_filter( $config[0], array_keys( $transition_options ) );
   $auto = cv_filter( $config[1], array_keys( $auto_options ) );
   $delay = cv_filter( $config[2], 'integer' );
   $controls = cv_filter( $config[3], array_keys( $controls_options ) );

   $obj->add_class( 'cv-slider' );

   $obj->data( 'mode', $transition );
   $obj->data( 'auto', $auto );

   if ( cv_make_bool( $auto ) ) {
      $obj->data( 'delay', $delay );
   }

   switch ( $controls ) {
      case 'both':
         $obj->data( 'controls', 'true' );
         $obj->data( 'pager', 'true' );
         break;
      case 'controls':
         $obj->data( 'controls', 'true' );
         $obj->data( 'pager', 'false' );
         break;
      case 'pager':
         $obj->data( 'controls', 'false' );
         $obj->data( 'pager', 'true' );
         break;
      case 'none':
         $obj->data( 'controls', 'false' );
         $obj->data( 'pager', 'false' );
         break;
   }

   return $obj;

}
endif;

if ( ! class_exists('CV_Shortcode_Slider_Control') ) :

/**
 * SLider Combo Control
 * used to manage each included shortcode's controls
 *
 * @package    WordPress
 * @subpackage Canvys
 * @since      Version 1.0
 */
class CV_Shortcode_Slider_Control extends CV_Shortcode_Control {

   // Used to identify the shortcode type
   public $type = 'slider_config';

   /**
    * Renders inline JavaScript/CSS required by the shortcode composer
    *
    * @return mixed
    */
   static function composer_additional_assets() { ?>

      <script id="cv-composer-slider_config-control-script">
         (function($) {
            "use strict";

            function strpos (haystack, needle, offset) {
               var i = (haystack+'').indexOf(needle, (offset || 0));
               return i === -1 ? false : i;
            }

            var $document = $(document);

            $document.on( 'change', '.cv-slider-control-wrap .cv-slider-control-transition', function() {
               var $this = $(this), val = $this.val(), $wrap = $this.closest('.cv-slider-control-wrap'),
                   $input = $wrap.find('input[type="text"]'), config = $input.val().split('|');
               config[0] = val;
               $input.val( config.join('|') );
            });

            $document.on( 'change', '.cv-slider-control-wrap .cv-slider-control-auto', function() {
               var $this = $(this), val = $this.val(), $wrap = $this.closest('.cv-slider-control-wrap'),
                   $input = $wrap.find('input[type="text"]'), config = $input.val().split('|');
               config[1] = val;
               $input.val( config.join('|') );
               if ( 'true' === val ) {
                  $('.cv-slider-control-delay-wrap').show();
               }
               else {
                  $('.cv-slider-control-delay-wrap').hide();
               }
            });

            $document.on( 'change', '.cv-slider-control-wrap .cv-slider-control-delay', function() {
               var $this = $(this), val = $this.val(), $wrap = $this.closest('.cv-slider-control-wrap'),
                   $input = $wrap.find('input[type="text"]'), config = $input.val().split('|');
               config[2] = val;
               $input.val( config.join('|') );
            });

            $document.on( 'change', '.cv-slider-control-wrap .cv-slider-control-controls', function() {
               var $this = $(this), val = $this.val(), $wrap = $this.closest('.cv-slider-control-wrap'),
                   $input = $wrap.find('input[type="text"]'), config = $input.val().split('|');
               config[3] = val;
               $input.val( config.join('|') );
            });

         })(jQuery);
      </script>

   <?php }

   /**
    * Callback function for rendering only the control
    *
    * @param mixed $input The input value
    * @return string
    */
   public function render_control( $input = null ) {

      if ( empty( $input ) || 4 != count( explode( '|', $input ) ) ) {
         $input = 'horizontal|false|4000|both';
      }

      $transition_options = array(
         'horizontal' => __( 'Slide Horizontally', 'canvys' ),
         'vertical'   => __( 'Slide Vertically', 'canvys' ),
         'fade'       => __( 'Fade', 'canvys' ),
      );

      $auto_options = array(
         'false' => __( 'No, do not automatically change slides', 'canvys' ),
         'true'   => __( 'Yes, automatically change slides', 'canvys' ),
      );

      $delay_options = array(
         '2000'  => __( '2 seconds', 'canvys' ),
         '3000'  => __( '3 seconds', 'canvys' ),
         '4000'  => __( '4 seconds', 'canvys' ),
         '5000'  => __( '5 seconds', 'canvys' ),
         '6000'  => __( '6 seconds', 'canvys' ),
         '7000'  => __( '7 seconds', 'canvys' ),
         '8000'  => __( '8 seconds', 'canvys' ),
         '9000'  => __( '9 seconds', 'canvys' ),
         '10000' => __( '10 seconds', 'canvys' ),
      );

      $controls_options = array(
         'both'     => __( 'Next/Prev control & Pager', 'canvys' ),
         'controls' => __( 'Next/Prev control only', 'canvys' ),
         'pager'    => __( 'Pager only', 'canvys' ),
         'none'     => __( 'No controls', 'canvys' ),
      );

      $config = explode( '|', $input );
      $transition = cv_filter( $config[0], array_keys( $transition_options ) );
      $auto = cv_filter( $config[1], array_keys( $auto_options ) );
      $delay = cv_filter( $config[2], array_keys( $delay_options ) );
      $controls = cv_filter( $config[3], array_keys( $controls_options ) );

      $o = '<div class="cv-slider-control-wrap">';

      $o .= new CV_HTML( '<input />', array(
         'type'  => 'text',
         'class' => 'cv-slider-control-value',
         'name'  => $this->handle,
         'id'    => $this->id,
         'value' => $input,
         'style' => 'display:none;',
      ) );

      $o .= '<p>';
      $o .= '<strong>' . __( 'Transition Mode', 'canvys' ) . '</strong>';
      $o .= new CV_HTML( '<select>', array(
         'class'   => 'cv-slider-control-transition',
         'content' => $this->array_to_options( $transition_options, $transition ),
      ) );
      $o .= '</p>';

      $o .= '<p>';
      $o .= '<strong>' . __( 'Automatically Change Slides', 'canvys' ) . '</strong>';
      $o .= new CV_HTML( '<select>', array(
         'class'   => 'cv-slider-control-auto',
         'content' => $this->array_to_options( $auto_options, $auto ),
      ) );
      $o .= '</p>';

      $hidden = 'false' == $auto ? ' style ="display:none;"' : null;
      $o .= '<p class="cv-slider-control-delay-wrap"' . $hidden . '>';
      $o .= '<strong>' . __( 'Automatic Transition Delay', 'canvys' ) . '</strong>';
      $o .= new CV_HTML( '<select>', array(
         'class'   => 'cv-slider-control-delay',
         'content' => $this->array_to_options( $delay_options, $delay ),
      ) );
      $o .= '</p>';

      $o .= '<p>';
      $o .= '<strong>' . __( 'Displayed Controls', 'canvys' ) . '</strong>';
      $o .= new CV_HTML( '<select>', array(
         'class'   => 'cv-slider-control-controls',
         'content' => $this->array_to_options( $controls_options, $controls ),
      ) );
      $o .= '</p>';
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

      if ( empty( $input ) || 4 != count( explode( '|', $input ) ) ) {
         return 'horizontal|false|4000|both';
      }

      $transition_options = array(
         'horizontal', 'vertical', 'fade',
      );

      $auto_options = array(
         'false', 'true',
      );

      $controls_options = array(
         'both','controls','pager','none',
      );

      $config = explode( '|', $input );
      $transition = cv_filter( $config[0], $transition_options );
      $auto = cv_filter( $config[1], $auto_options );
      $delay = cv_filter( $config[2], 'integer' );
      $controls = cv_filter( $config[3], $controls_options );

      return implode( '|', array( $transition, $auto, $delay, $controls ) );

   }

   /**
    * Sanitize any user input
    *
    * @param mixed $input The input value
    * @return string
    */
   public function array_to_options( $input = null, $value = null ) {
      if ( ! $input ) return;
      $out = '';
      foreach ( $input as $val => $label ) {
         $out .= '<option value="' . $val . '" ' . selected( $val, $value, 0 ) . '>' . $label . '</option>';
      }
      return $out;
   }

}
endif;