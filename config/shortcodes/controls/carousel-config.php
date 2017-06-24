<?php

if ( ! function_exists( 'cv_apply_carousel_config_attributes' ) ) :

/**
 * Converts the value used to create a shortcode link attribute to usable HTML attributes
 *
 * @return CV_HTML
 */
function cv_apply_carousel_config_attributes( $obj, $input = null ) {

   if ( empty( $input ) || 6 != count( explode( '|', $input ) ) ) {
      return '4|single|false|4000|under|normal';
   }

   $scroll_options = array(
      'single', 'all',
   );

   $auto_options = array(
      'false', 'true',
   );

   $controls_options = array(
      'under', 'over', 'none',
   );

   $spacing_options = array(
      'normal', 'none', 'more',
   );

   $config = explode( '|', $input );
   $columns = cv_filter( $config[0], 'integer' );
   $scroll = cv_filter( $config[1], $scroll_options );
   $auto = cv_filter( $config[2], $auto_options );
   $delay = cv_filter( $config[3], 'integer' );
   $controls = cv_filter( $config[4], $controls_options );
   $spacing = cv_filter( $config[5], $spacing_options );

   $obj->add_class( 'cv-carousel' );
   $obj->add_class( 'controls-' . $controls );

   switch ( $controls ) {
      case 'under':
         $obj->data( 'arrows', 'true' );
         $obj->data( 'dots', 'true' );
         break;
      case 'over':
         $obj->data( 'arrows', 'true' );
         $obj->data( 'dots', 'false' );
         break;
      case 'none':
         $obj->data( 'arrows', 'false' );
         $obj->data( 'dots', 'false' );
         break;
   }

   $obj->data( 'columns', $columns );
   $obj->data( 'auto', $auto );

   if ( cv_make_bool( $auto ) ) {
      $obj->data( 'delay', $delay );
   }

   switch ( $scroll ) {
      case 'single': $obj->data( 'scroll', '1' ); break;
      case 'all': $obj->data( 'scroll', $columns ); break;
   }

   switch ( $spacing ) {
      case 'normal': $obj->add_class( 'spacing-1' ); break;
      case 'more': $obj->add_class( 'spacing-2' ); break;
   }

   return $obj;

}
endif;

if ( ! class_exists('CV_Shortcode_Carousel_Control') ) :

/**
 * Carousel Combo Control
 * used to manage each included shortcode's controls
 *
 * @package    WordPress
 * @subpackage Canvys
 * @since      Version 1.0
 */
class CV_Shortcode_Carousel_Control extends CV_Shortcode_Control {

   // Used to identify the shortcode type
   public $type = 'carousel_config';

   /**
    * Renders inline JavaScript/CSS required by the shortcode composer
    *
    * @return mixed
    */
   static function composer_additional_assets() { ?>

      <script id="cv-composer-carousel_config-control-script">
         (function($) {
            "use strict";

            function strpos (haystack, needle, offset) {
               var i = (haystack+'').indexOf(needle, (offset || 0));
               return i === -1 ? false : i;
            }

            var $document = $(document);

            $document.on( 'change', '.cv-carousel-control-wrap .cv-carousel-control-columns', function() {
               var $this = $(this), val = $this.val(), $wrap = $this.closest('.cv-carousel-control-wrap'),
                   $input = $wrap.find('input[type="text"]'), config = $input.val().split('|');
               config[0] = val;
               $input.val( config.join('|') );
            });

            $document.on( 'change', '.cv-carousel-control-wrap .cv-carousel-control-scroll', function() {
               var $this = $(this), val = $this.val(), $wrap = $this.closest('.cv-carousel-control-wrap'),
                   $input = $wrap.find('input[type="text"]'), config = $input.val().split('|');
               config[1] = val;
               $input.val( config.join('|') );
            });

            $document.on( 'change', '.cv-carousel-control-wrap .cv-carousel-control-auto', function() {
               var $this = $(this), val = $this.val(), $wrap = $this.closest('.cv-carousel-control-wrap'),
                   $input = $wrap.find('input[type="text"]'), config = $input.val().split('|');
               config[2] = val;
               $input.val( config.join('|') );
               if ( 'true' === val ) {
                  $('.cv-carousel-control-delay-wrap').show();
               }
               else {
                  $('.cv-carousel-control-delay-wrap').hide();
               }
            });

            $document.on( 'change', '.cv-carousel-control-wrap .cv-carousel-control-delay', function() {
               var $this = $(this), val = $this.val(), $wrap = $this.closest('.cv-carousel-control-wrap'),
                   $input = $wrap.find('input[type="text"]'), config = $input.val().split('|');
               config[3] = val;
               $input.val( config.join('|') );
            });

            $document.on( 'change', '.cv-carousel-control-wrap .cv-carousel-control-controls', function() {
               var $this = $(this), val = $this.val(), $wrap = $this.closest('.cv-carousel-control-wrap'),
                   $input = $wrap.find('input[type="text"]'), config = $input.val().split('|');
               config[4] = val;
               $input.val( config.join('|') );
            });

            $document.on( 'change', '.cv-carousel-control-wrap .cv-carousel-control-spacing', function() {
               var $this = $(this), val = $this.val(), $wrap = $this.closest('.cv-carousel-control-wrap'),
                   $input = $wrap.find('input[type="text"]'), config = $input.val().split('|');
               config[5] = val;
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

      if ( empty( $input ) || 6 != count( explode( '|', $input ) ) ) {
         $input = '4|single|false|4000|under|normal';
      }

      $columns_options = array();
      for ( $i=3; $i<9; $i++ ) {
         $columns_options[$i] = sprintf( __( '%s Columns', 'canvys' ), $i );
      }

      $scroll_options = array(
         'single' => __( 'One element at a time', 'canvys' ),
         'all'   => __( 'Equal to the number of columns', 'canvys' ),
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
         'under' => __( 'Below the carousel', 'canvys' ),
         'over'  => __( 'On top of the carousel', 'canvys' ),
         'none'  => __( 'No controls', 'canvys' ),
      );

      $spacing_options = array(
         'none'   => __( 'None', 'canvys' ),
         'normal' => __( 'Normal', 'canvys' ),
         'more'   => __( 'More', 'canvys' ),
      );

      $config = explode( '|', $input );
      $columns = cv_filter( $config[0], array_keys( $columns_options ) );
      $scroll = cv_filter( $config[1], array_keys( $scroll_options ) );
      $auto = cv_filter( $config[2], array_keys( $auto_options ) );
      $delay = cv_filter( $config[3], array_keys( $delay_options ) );
      $controls = cv_filter( $config[4], array_keys( $controls_options ) );
      $spacing = cv_filter( $config[5], array_keys( $spacing_options ) );

      $o = '<div class="cv-carousel-control-wrap">';

      $o .= new CV_HTML( '<input />', array(
         'type'  => 'text',
         'class' => 'cv-carousel-control-value',
         'name'  => $this->handle,
         'id'    => $this->id,
         'value' => $input,
         'style' => 'display:none;',
      ) );

      $o .= '<p>';
      $o .= '<strong>' . __( 'Number of Columns', 'canvys' ) . '</strong>';
      $o .= new CV_HTML( '<select>', array(
         'class'   => 'cv-carousel-control-columns',
         'content' => $this->array_to_options( $columns_options, $columns ),
      ) );
      $o .= '</p>';

      $o .= '<p>';
      $o .= '<strong>' . __( 'Number of Elements Moved Per Slide', 'canvys' ) . '</strong>';
      $o .= new CV_HTML( '<select>', array(
         'class'   => 'cv-carousel-control-scroll',
         'content' => $this->array_to_options( $scroll_options, $scroll ),
      ) );
      $o .= '</p>';

      $o .= '<p>';
      $o .= '<strong>' . __( 'Automatically Change Slides', 'canvys' ) . '</strong>';
      $o .= new CV_HTML( '<select>', array(
         'class'   => 'cv-carousel-control-auto',
         'content' => $this->array_to_options( $auto_options, $auto ),
      ) );
      $o .= '</p>';

      $hidden = 'false' == $auto ? ' style ="display:none;"' : null;
      $o .= '<p class="cv-carousel-control-delay-wrap"' . $hidden . '>';
      $o .= '<strong>' . __( 'Automatic Transition Delay', 'canvys' ) . '</strong>';
      $o .= new CV_HTML( '<select>', array(
         'class'   => 'cv-carousel-control-delay',
         'content' => $this->array_to_options( $delay_options, $delay ),
      ) );
      $o .= '</p>';

      $o .= '<p>';
      $o .= '<strong>' . __( 'Displayed Controls', 'canvys' ) . '</strong>';
      $o .= new CV_HTML( '<select>', array(
         'class'   => 'cv-carousel-control-controls',
         'content' => $this->array_to_options( $controls_options, $controls ),
      ) );
      $o .= '</p>';

      $o .= '<p>';
      $o .= '<strong>' . __( 'Element Spacing', 'canvys' ) . '</strong>';
      $o .= new CV_HTML( '<select>', array(
         'class'   => 'cv-carousel-control-spacing',
         'content' => $this->array_to_options( $spacing_options, $spacing ),
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

      if ( empty( $input ) || 6 != count( explode( '|', $input ) ) ) {
         return '4|single|false|4000|under|normal';
      }

      $scroll_options = array(
         'single', 'all',
      );

      $auto_options = array(
         'false', 'true',
      );

      $controls_options = array(
         'under', 'over', 'none',
      );

      $spacing_options = array(
         'normal', 'none', 'more',
      );

      $config = explode( '|', $input );
      $columns = cv_filter( $config[0], 'integer' );
      $scroll = cv_filter( $config[1], $scroll_options );
      $auto = cv_filter( $config[2], $auto_options );
      $delay = cv_filter( $config[3], 'integer' );
      $controls = cv_filter( $config[4], $controls_options );
      $spacing = cv_filter( $config[5], $spacing_options );

      return implode( '|', array( $columns, $scroll, $auto, $delay, $controls, $spacing ) );

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