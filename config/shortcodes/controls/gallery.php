<?php

if ( ! class_exists('CV_Shortcode_Gallery_Control') ) :

/**
 * Shortcode Gallery Editor Control
 * used to manage each included shortcode's controls
 *
 * @package    WordPress
 * @subpackage Canvys
 * @since      Version 1.0
 */
class CV_Shortcode_Gallery_Control extends CV_Shortcode_Control {

   // Used to identify the shortcode type
   public $type = 'gallery';

   /**
    * Callback function for initializing the control
    *
    * @return void
    */
   public function init() {
      $action = 'render_gallery';
      add_action('wp_ajax_' . 'cv_ajax_' . $action, array( $this, $action . '_callback' ) );
      add_action('wp_ajax_nopriv_' . 'cv_ajax_' . $action, array( $this, $action . '_callback' ) );
   }

   /**
    * Renders inline JavaScript/CSS required by the shortcode composer
    *
    * @return mixed
    */
   static function composer_additional_assets() { ?>

      <script id="cv-composer-gallery-control-script">
         (function($) {
            "use strict";

            var $document = $(document);

            $document.on( 'click', '.cv-composer-create-gallery, .cv-gallery-preview, .cv-composer-change-gallery', function() {

               // Determine if a new gallery is being created
               var create = $(this).hasClass('cv-composer-create-gallery');

               // locate the container
               var $wrap = $(this).closest('.cv-gallery-editor');

               // Preexisting selection
               var selection;

               // if there is already a gallery to edit
               if ( ! create ) {

                  // Grab the existing gallery value
                  var current = $wrap.find('input').val();

                  // Set up the arguments object
                  var args = {
                     orderby: "post__in",
                     order: "ASC",
                     type: "image",
                     perPage: -1,
                     post__in: current.split(',')
                  };

                  // Create attachments object
                  var attachments = wp.media.query( args );

                  // Update the current selection
                  selection = new wp.media.model.Selection( attachments.models, {
                        props:    attachments.props.toJSON(),
                        multiple: true
                  });

               }

               // The state of the media window
               var state = create ? 'gallery-library' : 'gallery-edit';

               // Create the media frame.
               var frame = wp.media({
                  frame: 'post',
                  state: state,
                  library: { type: 'image' },
                  selection: selection,
               });

               frame.on( 'select update insert', function(obj) {

                  // Create the list of ID`s
                  var ID_list = [];
                  $.each( obj.models, function( id, val ) {
                     ID_list.push( val.id );
                  });

                  // Create object for AJAX callback
                  var data = {
                     action: 'cv_ajax_render_gallery',
                     input: ID_list.join(',')
                  };

                  // Execute AJAX callback
                  $.ajax({
                     type: 'POST',
                     url: "<?php echo admin_url('admin-ajax.php'); ?>",
                     data: data,
                     error: function() {
                        alert("<?php _e( 'There was an error retrieving the created gallery, please refresh the page and try again.', 'canvys' ); ?>")
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
                           $wrap.replaceWith(response);
                        }
                     },
                  });

               });

               frame.on( 'close' , function() {

                  $('body').removeClass('cv-gallery-editor-modal-active');

                  // Reapply keyboard events for the canvys modals
                  $('body').removeClass('cv-suspend-modal-events');

               });

               // Finally open the frame
               $('body').addClass('cv-gallery-editor-modal-active');
               frame.open();

               // Suspend keyboard events for the canvys modals
               $('body').addClass('cv-suspend-modal-events');

            });

            // Removing the gallery
            $document.on( 'click', '.cv-composer-remove-gallery', function() {
               var $editor = $(this).closest('.cv-gallery-editor');
               $editor.removeClass('has-gallery');
               $editor.find('.cv-gallery-preview').html('');
               $editor.find('.cv-composer-gallery-field').val('').trigger('change');;
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

      <style id="cv-composer-gallery-control-style">
         .cv-gallery-editor-modal-active .media-modal .gallery-settings {
            display: none;
         }
         .cv-gallery-editor {
            border: 1px solid #eee;
            background: #f9f9f9;
         }
         .cv-gallery-editor .cv-gallery-preview {
            cursor: pointer;
            background: #fff;
         }
         .cv-gallery-editor.has-gallery .cv-gallery-preview {
            padding: 5px;
         }
         .cv-gallery-editor .cv-gallery-preview img {
            display: block;
            padding: 5px;
            width: 100%;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
         }
         .cv-gallery-editor,
         .cv-gallery-editor .cv-gallery-preview img {
            -webkit-border-radius: 3px;
            border-radius: 3px;
         }
         .cv-gallery-editor .cv-composer-manage-gallery {
            border-top: 1px solid #eee;
         }
         .cv-gallery-editor a {
            display: block;
            line-height: 50px;
            font-size: 14px;
            text-align: center;
            color: #999;
         }
         .cv-gallery-editor a:hover {
            color: #656565;
         }
         .cv-gallery-editor .cv-composer-create-gallery {
            padding: 75px 0;
            line-height: 25px;
         }
         .cv-gallery-editor .cv-composer-create-gallery i {
            font-size: 28px;
         }
         .cv-gallery-editor:not(.has-gallery) .cv-composer-manage-gallery,
         .cv-gallery-editor.has-gallery .cv-composer-create-gallery {
            display: none;
         }
      </style>

   <?php }

   /**
    * AJAX callback for uploading an image
    *
    * @return void
    */
   public function render_gallery_callback() {
      echo $this->render_control( $_POST['input'] );
      die();
   }

   /**
    * Callback function for rendering the complete control
    *
    * @param mixed $input The input value
    * @return string
    */
   public function render_control( $input = null ) {
      // if ( ! $input ) $input = '217,218';
      $has_gallery_class = $input ? ' has-gallery' : null;
      if ( $columns = $input ) {
         $columns = count( explode( ',', $input ) );
         if ( $columns > 6 ) $columns = 6;
         $img_size = $columns > 3 ? 'cv_square_small' : $columns > 1 ? 'cv_square_medium' : 'large';
      }
      $o  = '<div class="cv-gallery-editor' . $has_gallery_class . '">';
      $o .= new CV_HTML( '<input />', array(
         'class' => 'cv-composer-gallery-field',
         'type' => 'hidden',
         'name' => $this->handle,
         'value' => $input,
      ) );
      $o .= '<div class="cv-gallery-preview">';
      $o .= '<ul class="cv-grid-' . $columns . ' not-responsive has-clearfix">';
      if ( $input ) {
         foreach ( explode( ',', $input ) as $id ) {
            if ( ! $img_data = wp_get_attachment_image_src( $id, $img_size ) ) {
               continue;
            }
            if ( ! $img_data[3] ) {
               $img_data = wp_get_attachment_image_src( $id, 'thumbnail' );
            }
            $url = $img_data ? $img_data[0] : null;
            if ( $url ) {
               $o .= '<li><img src="' . $url . '" alt="' . sprintf( __( 'Image ID: %s', 'canvys' ), $id ) . '" /></li>';
            }
         }
      }
      $o .= '</ul>';
      $o .= '</div>';
      $o .= '<a class="cv-composer-create-gallery"><i class="icon-picture"></i><br />' . __( 'Create Gallery', 'canvys' ) . '</a>';
      $o .= '<div class="cv-composer-manage-gallery cv-split-2 has-clearfix">';
      $o .= '<a class="cv-composer-change-gallery"><i class="icon-pencil"></i> ' . __( 'Edit Gallery', 'canvys' ) . '</a>';
      $o .= '<a class="cv-composer-remove-gallery"><i class="icon-cancel"></i> ' . __( 'Remove Images', 'canvys' ) . '</a>';
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
      $o = '';
      foreach ( explode( ',', $input ) as $id ) {
         $o .= cv_filter( $id, 'integer' ) . ',';
      }
      return trim( $o, ',' );
   }

}
endif;