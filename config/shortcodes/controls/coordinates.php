<?php

if ( ! class_exists('CV_Shortcode_Coordinates_Control') ) :

/**
 * Shortcode Image Control
 * used to manage each included shortcode's controls
 *
 * @package    WordPress
 * @subpackage Canvys
 * @since      Version 1.0
 */
class CV_Shortcode_Coordinates_Control extends CV_Shortcode_Control {

   // Used to identify the shortcode type
   public $type = 'coordinates';

   /**
    * Renders inline JavaScript/CSS required by the shortcode composer
    *
    * @return mixed
    */
   static function composer_additional_assets() { ?>

      <script id="cv-composer-coordinates-control-script">
         (function($) {
            "use strict";

            var $document = $(document);

            $document.on( 'click', '.cv-composer-get-coordinates', function(e) {

               var geocoder = new google.maps.Geocoder(),
                   $control = $(this).prev(),
                   address = $control.val();

               geocoder.geocode( { 'address': address}, function(results, status) {

                 if ( status == google.maps.GeocoderStatus.OK ) {
                   var latitude = results[0].geometry.location.lat(),
                       longitude = results[0].geometry.location.lng(),
                       coordinates = latitude + ',' + longitude;
                   $control.val(coordinates);
                 }
                 else {
                     alert('<?php _e( 'The address could not be found, please try again.', 'canvys' ); ?>');
                 }
               });

            });

         })(jQuery);
      </script>

   <?php }

   /**
    * Renders inline CSS required by the shortcode composer
    *
    * @return mixed
    */
   static function composer_additional_styles() { ?>

      <style id="cv-composer-coordinates-control-style">
         .cv-composer-get-coordinates {
            margin-top: 1em !important;
         }
      </style>

   <?php }

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
         'placeholder' => __( 'Enter an address then hit "Get Coordinates" below.', 'canvys' ),
      ) );

      // The select file button
      $control .= new CV_HTML( '<a>', array(
         'class' => 'button cv-composer-get-coordinates',
         'content' =>  __( 'Get Coordinates', 'canvys' ),
      ) );

      return $control;
   }

   /**
    * Sanitize any user input
    *
    * @param mixed $input The input value
    * @return string
    */
   public function sanitize_input( $input = null ) {
      return $input;
   }

}
endif;