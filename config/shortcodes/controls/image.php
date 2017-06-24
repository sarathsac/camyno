<?php

if ( ! class_exists('CV_Shortcode_Image_Control') ) :

/**
 * Shortcode Image Control
 * used to manage each included shortcode's controls
 *
 * @package    WordPress
 * @subpackage Canvys
 * @since      Version 1.0
 */
class CV_Shortcode_Image_Control extends CV_Shortcode_Control {

   // Used to identify the shortcode type
   public $type = 'image';

   /**
    * Callback function for initializing the control
    *
    * @return void
    */
   public function init() {
      $action = 'upload_image';
      add_action('wp_ajax_' . 'cv_ajax_' . $action, array( $this, $action . '_callback' ) );
      add_action('wp_ajax_nopriv_' . 'cv_ajax_' . $action, array( $this, $action . '_callback' ) );
   }

   /**
    * Renders inline JavaScript/CSS required by the shortcode composer
    *
    * @return mixed
    */
   static function composer_additional_assets() { ?>

      <script id="cv-composer-image-control-script">
         (function($) {
            "use strict";

            var $document = $(document);

            $document.on( 'click', '.cv-composer-upload-control img, .cv-composer-upload-image, .cv-composer-change-image', function(e) {

               e.stopImmediatePropagation();

               var $wrap = $(this).closest('.cv-composer-upload-control');

               // Create the media frame.
               var frame = wp.media({
                  title: "<?php _e( 'Select an Image', 'canvys' ); ?>",
                  button: { text: "<?php _e( 'Use This Image', 'canvys' ); ?>" },
                  library: { type: 'image' },
                  multiple: false,
               });

               // When an image is selected, run a callback.
               frame.on( 'select', function() {

                  // Grab the selected attachment.
                  var attachment = frame.state().get('selection').first().toJSON();
                  var id = attachment.id;

                  // Create object for AJAX callback
                  var data = {
                     action: 'cv_ajax_upload_image',
                     id: id
                  };

                  // Execute AJAX callback
                  $.ajax({
                     type: 'POST',
                     url: "<?php echo admin_url('admin-ajax.php'); ?>",
                     data: data,
                     error: function() {
                        alert("<?php _e( 'There was an error retrieving the selected image, please refresh the page and try again.', 'canvys' ); ?>")
                     },
                     success: function(response) {

                        // User was loged out
                        if ( 0 === response ) {
                           alert("<?php _e( 'It seems your are no longer logged in. Please log in and try again.', 'canvys' ); ?>");
                        }

                        // Nonce timeout
                        else if ( '-1' === response ) {
                           alert("<?php _e( 'Your session has timed out. Please reload the page and try again.', 'canvys' ); ?>");
                        }

                        // Actual success
                        else {
                           $wrap.find('.cv-composer-upload-field').val(id).trigger('change');
                           $wrap.find('img').attr('src', response);
                           $wrap.addClass('has-image');
                        }
                     },
                  });
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

            $document.on( 'click', '.cv-composer-remove-image', function() {
               var $wrap = $(this).closest('.cv-composer-upload-control');
               $wrap.find('.cv-composer-upload-field').val('').trigger('change');
               $wrap.find('img').attr('src', '');
               $wrap.removeClass('has-image');
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

      <style id="cv-composer-image-control-style">
         .cv-composer-upload-control {
            margin-bottom: 15px;
            background: #f9f9f9;
            border: 1px solid #eee;
         }
         .cv-composer-upload-control.has-image .image-wrap {
            padding: 10px 10px 0;
         }
         .cv-composer-upload-control img {
            width: 100%;
            cursor: pointer;
            display: block;
         }
         .cv-composer-upload-control.has-image .image-wrap {
            display: block;
         }
         .cv-composer-upload-control .image-wrap {
            display: none;
         }
         .cv-composer-upload-control,
         .cv-composer-upload-control img,
         .cv-composer-upload-control.has-image .image-wrap {
            -webkit-border-radius: 5px !important;
            border-radius: 5px !important;
         }
         .cv-composer-upload-control a {
            display: block;
            line-height: 50px;
            font-size: 14px;
            text-align: center;
            color: #999;
         }
         .cv-composer-upload-control a:hover {
            color: #656565;
         }
         .cv-composer-upload-control .cv-composer-upload-image {
            padding: 75px 0;
            line-height: 25px;
         }
         .cv-composer-upload-control .cv-composer-upload-image i {
            font-size: 28px;
         }
         .cv-composer-upload-control:not(.has-image) .cv-composer-change-image,
         .cv-composer-upload-control:not(.has-image) .cv-composer-remove-image,
         .cv-composer-upload-control.has-image .cv-composer-upload-image {
            display: none;
         }
      </style>

   <?php }

   /**
    * AJAX callback for uploading an image
    *
    * @return void
    */
   public function upload_image_callback() {
      $id = $_POST['id'];
      $url = wp_get_attachment_image_src( $id, 'large' );
      echo $url[0];
      die();
   }

   /**
    * Callback function for rendering only the control
    *
    * @param mixed $input The input value
    * @return string
    */
   public function render_control( $input = null ) {
      $img_data = wp_get_attachment_image_src( $input, 'large' );
      $url = $img_data ? $img_data[0] : null;
      $has_image_class = $url ? ' has-image' : null;
      $o  = '<div class="cv-composer-upload-control' . $has_image_class . '">';
      $o .= new CV_HTML( '<input />', array(
         'class' => 'cv-composer-upload-field',
         'type' => 'hidden',
         'name' => $this->handle,
         'value' => $input,
      ) );
      $o .= '<div class="image-wrap"><img src="' . $url . '" alt="" /></div>';
      $o .= '<a class="cv-composer-upload-image"><i class="icon-picture-1"></i><br />' . __( 'Add Image', 'canvys' ) . '</a>';
      $o .= '<div class="cv-split-2 has-clearfix">';
      $o .= '<a class="cv-composer-change-image"><i class="icon-arrows-ccw"></i> ' . __( 'Change', 'canvys' ) . '</a>';
      $o .= '<a class="cv-composer-remove-image"><i class="icon-cancel"></i> ' . __( 'Remove', 'canvys' ) . '</a>';
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
      return cv_filter( $input, 'image' );
   }

}
endif;