<?php

if ( ! function_exists( 'cv_get_shortcode_link_control_url' ) ) :

/**
 * Converts the value used to create a shortcode link attribute to a usable URL
 *
 * @return CV_HTML
 */
function cv_get_shortcode_link_control_url( $input = null ) {

   if ( ! is_string( $input ) || ! $input ) {
      return '';
   }

   $input = trim( $input );

   global $canvys;

   // Begin with the input
   $url = $input;

   // Grab all public post types
   $supported_post_types = get_post_types( array( 'public' => true ) );

   // Grab all public taxonomies
   $supported_taxonomies = array();
   foreach ( get_taxonomies( array( 'public' => true ) ) as $taxonomy ) {
      if ( get_terms( $taxonomy ) ) {
         $supported_taxonomies[] = $taxonomy;
      }
   }

   // Grab all supported social outlets
   $supported_social_outlets = array_keys( $canvys['social_outlets'] );

   // Check if link is supposed to open in a new tab
   $new_window = false;
   if ( false !== strpos( $input, '?target=blank' ) ) {
      $new_window = true;
      $input = str_replace( '?target=blank', '', $input );
   }

   // Check if link is to a post type
   if ( 0 === strpos( $input, 'post:' ) && in_array( get_post_type( str_replace( 'post:', '', $input ) ), $supported_post_types ) ) {
      $url = get_permalink( str_replace( 'post:', '', $input ) );
   }

   // Check if link is to a taxonomy
   if ( 0 === strpos( $input, 'taxonomy:' ) ) {
      $parts = explode( ':', $input );
      if ( in_array( $parts[1], $supported_taxonomies ) ) {
         $url = get_term_link( intval( $parts[2] ), $parts[1] );
      }
   }

   // Check if link is to a social profile
   if ( in_array( str_replace( 'social:', '', $input ), $supported_social_outlets ) ) {
      $social_outlet = str_replace( 'social:', '', $input );
      $profiles = cv_theme_setting( 'social', 'profiles' );
      if ( isset( $profiles[$social_outlet] ) ) $url = $profiles[$social_outlet];
      else $url = null;
   }

   return is_string( $url ) ? $url : '';

}
endif;

if ( ! function_exists( 'cv_get_shortcode_link_control_target' ) ) :

/**
 * Converts the value used to create a shortcode link attribute to usable HTML attributes
 *
 * @return CV_HTML
 */
function cv_get_shortcode_link_control_target( $input = null ) {
   if ( ! cv_get_shortcode_link_control_url( $input ) || ! is_string( $input ) ) return;
   return false !== strpos( $input, '?target=blank' ) ? '_blank' : null;
}
endif;

if ( ! function_exists( 'cv_get_shortcode_link_control_attrs' ) ) :

/**
 * Converts the value used to create a shortcode link attribute to usable HTML attributes
 *
 * @return CV_HTML
 */
function cv_get_shortcode_link_control_attrs( $input = null ) {
   if ( ! $url = cv_get_shortcode_link_control_url( $input ) ) return;
   $new_window = false !== strpos( $input, '?target=blank' ) ? ' target="_blank"' : null;
   return 'href="' . $url . '"' . $new_window;
}
endif;

if ( ! class_exists('CV_Shortcode_Link_Control') ) :

/**
 * Shortcode Link Control
 * used to manage each included shortcode's controls
 *
 * @package    WordPress
 * @subpackage Canvys
 * @since      Version 1.0
 */
class CV_Shortcode_Link_Control extends CV_Shortcode_Control {

   // Used to identify the shortcode type
   public $type = 'link';

   /**
    * Renders inline JavaScript/CSS required by the shortcode composer
    *
    * @return mixed
    */
   static function composer_additional_assets() { ?>

      <script id="cv-composer-link-control-script">
         (function($) {
            "use strict";

            function strpos (haystack, needle, offset) {
               var i = (haystack+'').indexOf(needle, (offset || 0));
               return i === -1 ? false : i;
            }

            var $document = $(document);

            $document.on( 'change', '.cv-link-control .link-source', function() {
               var $this = $(this), val = $this.val(), $wrap = $this.parent();
               if ( 'none' === val ) {
                  $wrap.find('.cv-link-new-window').hide();
               }
               else {
                  $wrap.find('.cv-link-new-window').show();
               }
               switch ( val ) {
                  case 'none':
                     $wrap.find('.cv-link-post_type-selector').hide().find('select').val('');
                     $wrap.find('.cv-link-input-value').hide().find('input').val('').trigger('change');
                     break;
                  case 'custom':
                     $wrap.find('.cv-link-post_type-selector').hide().find('select').val('');
                     $wrap.find('.cv-link-input-value').show().find('input').val('').trigger('change');
                     break;
                  default:
                     if ( false !== strpos(val, 'social:') ) {
                        $wrap.find('.cv-link-post_type-selector, .cv-link-taxonomy-selector').hide().find('select').val('');
                        $wrap.find('.cv-link-input-value').hide().find('input').val(val).trigger('change');
                     }
                     else if ( false !== strpos(val, 'post:') ) {
                        $wrap.find('.cv-link-post_type-selector, .cv-link-taxonomy-selector').hide().find('select').val('');
                        $wrap.find('.cv-link-post_type-selector[data-selector="'+val+'"]').show().find('select').val('');
                        $wrap.find('.cv-link-input-value').hide().find('input').val('').trigger('change');
                     }
                     else if ( false !== strpos(val, 'taxonomy:') ) {
                        $wrap.find('.cv-link-post_type-selector, .cv-link-taxonomy-selector').hide().find('select').val('');
                        $wrap.find('.cv-link-taxonomy-selector[data-selector="'+val+'"]').show().find('select').val('');
                        $wrap.find('.cv-link-input-value').hide().find('input').val('').trigger('change');
                     }
                     break;
               }
            });

            $document.on( 'change', '.cv-link-control .cv-link-post_type-selector select', function() {
               var $this = $(this), val = $this.val(), $wrap = $this.parent().parent();
               $wrap.find('.cv-link-input-value input').val(val).trigger('change');
            });

            $document.on( 'change', '.cv-link-control .cv-link-taxonomy-selector select', function() {
               var $this = $(this), val = $this.val(), $wrap = $this.parent().parent();
               $wrap.find('.cv-link-input-value input').val(val).trigger('change');
            });

            $document.on( 'change keyup', '.cv-link-input-value input', function() {
               var $this = $(this), val = $this.val(), $wrap = $this.parent().parent();
               if ( false !== strpos(val, '?target=blank') ) {
                  $wrap.find('[id="cv-link-new-window"]').prop( 'checked', true );
               }
               else {
                  $wrap.find('[id="cv-link-new-window"]').prop( 'checked', false );
               }
            });

            $document.on( 'change', '.cv-link-control [id="cv-link-new-window"]', function() {
               var $this = $(this), $wrap = $this.closest('.cv-link-control'),
               $input = $wrap.find('.cv-link-input-value input'),
               val = $input.val();
               if ( val && $this.prop('checked') ) {
                  $input.val(val+'?target=blank');
               }
               else {
                  $input.val(val.replace('?target=blank',''));
                  $this.prop('checked', false);
               }
            });

            $document.on( 'click', '.cv-link-control .cv-composer-link-select-image', function(e) {

               e.stopImmediatePropagation();

               var $wrap = $(this).closest('.cv-link-control');

               // Create the media frame.
               var frame = wp.media({
                  title: "<?php _e( 'Select an Image', 'canvys' ); ?>",
                  button: { text: "<?php _e( 'Use This Image', 'canvys' ); ?>" },
                  library: { type: 'image' },
                  multiple: false,
               });

               // When an image is selected, run a callback.
               frame.on( 'select', function() {
                  var attachment = frame.state().get('selection').first().toJSON();
                  var url = attachment.url;
                  $wrap.find('.cv-link-input-value input').val(url).trigger('change');
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

      <style id="cv-composer-link-control-style">
         .cv-link-control select {
            margin-bottom: 1em;
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

      global $canvys;

      // Grab all public post types
      $supported_post_types = get_post_types( array( 'public' => true ) );

      // Grab all public taxonomies
      $supported_taxonomies = array();
      foreach ( get_taxonomies( array( 'public' => true ) ) as $taxonomy ) {
         if ( get_terms( $taxonomy ) ) {
            $supported_taxonomies[] = $taxonomy;
         }
      }

      // Check if link is supposed to open in a new tab
      $new_window = false;
      if ( false !== strpos( $input, '?target=blank' ) ) {
         $new_window = true;
         $input = str_replace( '?target=blank', '', $input );
      }

      // Determine the source of the link

      $source_value = 'none';

      // Check if link is a post
      if ( 0 === strpos( $input, 'post:' ) ) {
         if ( $post_type = get_post_type( str_replace( 'post:', '', $input ) ) ) {
            $source_value = 'post:' . $post_type;
         }
      }

      // Check if link is a taxonomy
      if ( 0 === strpos( $input, 'taxonomy:' ) ) {
         $parts = explode( ':', $input );
         if ( in_array( $parts[1], $supported_taxonomies ) ) {
            $source_value = 'taxonomy:' . $parts[1];
         }
      }

      // Check if link is a social outlet
      if ( in_array( str_replace( 'social:', '', $input ), array_keys( $canvys['social_outlets'] ) ) ) {
         $source_value = $input;
      }

      // Custom URL
      if ( 'none' == $source_value && $input ) {
        $source_value = 'custom';
      }

      // Reappend the new window indicator
      if ( $new_window ) {
         $input .= '?target=blank';
      }

      $o = '<div class="cv-link-control">';

      // Source Selector
      $o .= '<select class="link-source">';
      $o .= '<option value="none" ' . selected( 'none', $source_value, 0 ) . '>' . __( 'None', 'canvys' ) . '</option>';
      $o .= '<option value="custom" ' . selected( 'custom', $source_value, 0 ) . '>' . __( 'Custom', 'canvys' ) . '</option>';
      $o .= '<optgroup label="' . __( 'Post Types', 'canvys' ) . '">';
      foreach ( $supported_post_types as $post_type ) {
         $obj = get_post_type_object( $post_type );
         $title = $obj->labels->singular_name;
         $o .= '<option value="post:' . $post_type . '" ' . selected( 'post:' . $post_type, $source_value, 0 ) . '>' . $title . '</option>';
      }
      $o .= '</optgroup>';
      $o .= '<optgroup label="' . __( 'Taxonomies', 'canvys' ) . '">';
      foreach ( $supported_taxonomies as $taxonomy ) {
         $obj = get_taxonomy( $taxonomy );
         $title = $obj->labels->singular_name;
         $o .= '<option value="taxonomy:' . $taxonomy . '" ' . selected( 'taxonomy:' . $taxonomy, $source_value, 0 ) . '>' . $title . '</option>';
      }
      $o .= '</optgroup>';

      if ( $profiles = cv_theme_setting( 'social', 'profiles' ) ) {
         if ( ! empty( $profiles ) ) {
            $o .= '<optgroup label="' . __( 'Saved Social Media Profiles', 'canvys' ) . '">';
            foreach ( $profiles as $outlet => $url ) {
               if ( ! $url ) continue;
               $o .= '<option value="social:' . $outlet . '" ' . selected( 'social:' . $outlet, $source_value, 0 ) . '>' . $canvys['social_outlets'][$outlet] . '</option>';
            }
            $o .= '</optgroup>';
         }
      }
      $o .= '</select>';

      // Post Selector
      foreach ( $supported_post_types as $post_type ) {
         $hidden = 'post:' . $post_type == $source_value ? null : ' style="display:none;"';
         $o .= '<div class="cv-link-post_type-selector" data-selector="post:' . $post_type . '"' . $hidden . '>';
         $o .= '<select>';
         foreach ( get_posts( array( 'posts_per_page' => -1, 'post_type' => $post_type ) ) as $post_obj ) {
            $title = get_the_title( $post_obj->ID ) ? get_the_title( $post_obj->ID ) : sprintf( __( 'No Title (ID: %s)', 'canvys' ), $post_obj->ID );
            $o .= '<option value="post:' . $post_obj->ID . '" ' . selected( 'post:' . $post_obj->ID, $input, 0 ) . '>' . $title . '</option>';
         }
         $o .= '</select>';
         $o .= '</div>';
      }

      // Taxonomy Selector
      foreach ( $supported_taxonomies as $taxonomy ) {
         $hidden = 'taxonomy:' . $taxonomy == $source_value ? null : ' style="display:none;"';
         $o .= '<div class="cv-link-taxonomy-selector" data-selector="taxonomy:' . $taxonomy . '"' . $hidden . '>';
         $o .= '<select>';
         foreach ( get_terms( $taxonomy, array( 'hide_empty' => false, 'hierarchical' => true ) ) as $taxonomy_obj ) {
            $o .= '<option value="taxonomy:' . $taxonomy . ':' . $taxonomy_obj->term_id . '" ' . selected( 'taxonomy:' . $taxonomy . ':' . $taxonomy_obj->term_id, $input, 0 ) . '>' . $taxonomy_obj->name . '</option>';
         }
         $o .= '</select>';
         $o .= '</div>';
      }

      // The actual value
      $hidden = 'custom' == $source_value ? null : ' style="display:none;"';
      $o .= '<div class="cv-link-input-value"' . $hidden . '>';
      $o .= new CV_HTML( '<input />', array(
         'type'  => 'text',
         'name'  => $this->handle,
         'id'    => $this->id,
         'value' => $input,
         'placeholder' => __( 'Valid URL, Valid anchor with #, or select image below', 'canvys' ),
      ) );

      // Image selector button
      $o .= '<p><a class="button cv-composer-link-select-image">' . __( 'Select Image', 'canvys' ) . '</a></p>';

      $o .= '</div>';

      // Open in new window/tab
      $hidden = 'none' == $source_value ? ' style="display:none;"' : null;
      $o .= '<div class="cv-link-new-window"' . $hidden . '>';
      $o .= '<label for="cv-link-new-window">';
      $checkbox = new CV_HTML( '<input />', array(
         'type'  => 'checkbox',
         'id'    => 'cv-link-new-window',
      ) );
      if ( $new_window ) {
         $checkbox->attr( 'checked', 'checked' );
      }
      $o .= $checkbox;
      $o .= __( 'Open in new tab/window.', 'canvys' ) . '</label>';
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
      return $input;
   }

}
endif;