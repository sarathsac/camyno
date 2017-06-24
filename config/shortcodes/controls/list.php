<?php

if ( ! class_exists('CV_Shortcode_List_Control') ) :

/**
 * Shortcode Comma Delimited List Control
 * used to manage each included shortcode's controls
 *
 * @package    WordPress
 * @subpackage Canvys
 * @since      Version 1.0
 */
class CV_Shortcode_List_Control extends CV_Shortcode_Control {

   // Used to identify the shortcode type
   public $type = 'list';

   /**
    * Callback function for initializing the control
    *
    * @return void
    */
   public function init() {
      $this->separator = isset( $this->config['separator'] ) ? $this->config['separator'] : ',';
   }

   /**
    * Renders inline JavaScript/CSS required by the shortcode composer
    *
    * @return mixed
    */
   static function composer_additional_assets() { ?>

      <script id="cv-composer-list-control-script">
         (function($) {
            "use strict";

            var $document = $(document);

            // Adding new items
            $document.on( 'keyup', '.cv-list-new', function() {
               var $this = $(this), val = $this.val(), separator = $this.data('separator');

               // Check if last character was a separator
               if ( val.slice(-1) !== separator ) {
                  return;
               }

               // Remove the separator
               val = val.slice(0, -1);

               // Make sure there is still a value
               if ( /\S/.test(val) ) {
                  $.each( val.split(separator), function( index, value ) {
                     if ( /\S/.test(value) ) {
                        $this.next().append('<li><i class="icon-cancel"></i> <span>'+value+'</li>');
                     }
                  });
               }

               // Clear the field
               $this.val('');

            });

            // After changes were made
            $document.on( 'change', '.cv-list-new', function() {
               var $this = $(this), val = $this.val(), separator = $this.data('separator');

               // Make sure there is a value
               if ( ! val ) {
                  return;
               }

               // If last character was a separator, remove it
               if ( val.slice(-1) === separator ) {
                  val = val.slice(0, -1);
               }

               // Make sure there is still a value
               if ( /\S/.test(val) ) {
                  $.each( val.split(separator), function( index, value ) {
                     if ( /\S/.test(value) ) {
                        $this.next().append('<li><i class="icon-cancel"></i> <span>'+value+'</li>');
                     }
                  });
               }

               // Clear the field
               $this.val('');

            });

            // Removing an item
            $document.on( 'click', '.cv-list-items i', function() {
               $(this).parent().remove();
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

      <style id="cv-composer-list-control-style">
         .cv-list-items {
            list-style: none !important;
            margin: 3px 0;
         }
         .cv-list-items li {
            padding: 8px 12px;
            border: 1px solid #f9f9f9;
            background: #f9f9f9;
            margin: 3px;
            -webkit-border-radius: 3px;
            border-radius: 3px;
            font-weight: 400;
         }
         .cv-list-items .cv-list-placeholder {
            background: #F0F7E6;
            border: 1px dashed #A2D164;
         }
         .cv-list-items .cv-dragging {
            opacity: 0.9;
         }
         .cv-list-items li {
            cursor: move;
         }
         .cv-list-items li i {
            padding: 2px;
            cursor: pointer;
         }
         .cv-list-items li span {
            color: #656565;
         }
         html:not([dir="rtl"]) .cv-list-items li {
            float: left;
         }
         html[dir="rtl"] .cv-list-items li {
            float: right;
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
      $o = new CV_HTML( '<input />', array(
         'type'  => 'text',
         'class' => 'cv-list-new',
         'name'  => $this->handle,
         'id'    => $this->id,
         'value' => '',
         'data-separator' => $this->separator,
      ) );

      $o .= '<ul class="cv-list-items">';
      if ( $input ) {
         $input = explode( $this->separator, $input );
         foreach ( $input as $item ) {
            $o .= '<li><i class="icon-cancel"></i> <span>' . $item . '</span></li>';
         }
      }
      $o .= '</ul>';

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
      foreach ( explode( $this->separator, $input ) as $item ) {
         $o .= trim( cv_filter( $item, 'shortcode_attr' ) ) . $this->separator;
      }
      return trim( $o, $this->separator );
   }

}
endif;