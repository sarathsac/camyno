<?php

if ( ! class_exists('CV_Shortcode_File_Control') ) :

/**
 * Shortcode File Control
 * used to manage each included shortcode's controls
 *
 * @package    WordPress
 * @subpackage Canvys
 * @since      Version 1.0
 */
class CV_Shortcode_File_Control extends CV_Shortcode_Control {

   // Used to identify the shortcode type
   public $type = 'file';

   /**
    * Callback function for initializing the control
    *
    * @return void
    */
   public function init() {
      $this->file_type = isset( $this->config['file_type'] ) ? $this->config['file_type'] : null;
   }

   /**
    * Renders inline JavaScript/CSS required by the shortcode composer
    *
    * @return mixed
    */
   static function composer_additional_assets() { ?>

      <script id="cv-composer-file-control-script">
         (function($) {
            "use strict";

            var $document = $(document);

            $document.on( 'click', '.cv-composer-upload-file', function(e) {

               e.stopImmediatePropagation();

               var $button = $(this),
                   $input = $(this).prev(), id = $input.attr('id'), val,
                   fileType = $button.data('type');

               e.stopImmediatePropagation();

               // Create the media frame.
               var frame = wp.media({
                  title: "<?php _e( 'Select a File', 'canvys' ); ?>",
                  button: { text: "<?php _e( 'Use this File', 'canvys' ); ?>" },
                  library: { type: fileType },
                  multiple: false,
               });

               // When an image is selected, run a callback.
               frame.on( 'select', function() {

                  // Grab the selected attachment.
                  var attachment = frame.state().get('selection').first().toJSON();
                  var url = attachment.url;
                  $input.val(url).trigger('change');

               });

               frame.on( 'close', function() {

                  // Reapply keyboard events for the canvys modals
                  $('body').removeClass('cv-suspend-modal-events');

               });

               // Finally, open the modal.
               frame.open();

               // Suspend keyboard events for the canvys modals
               $('body').addClass('cv-suspend-modal-events');

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

      <style id="cv-composer-file-control-style">
         .cv-composer-upload-file {
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
      ) );

      if ( isset( $this->config['placeholder'] ) ) {
         $control->attr( 'placeholder', $this->config['placeholder'] );
      }

      // The select file button
      $control .= new CV_HTML( '<a>', array(
         'class' => 'button cv-composer-upload-file',
         'content' =>  __( 'Select File', 'canvys' ),
         'data-type' => $this->file_type,
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
      return cv_filter( $input, 'url' );
   }

}
endif;