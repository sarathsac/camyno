<?php

if ( ! function_exists( 'cv_filter_search_query' ) ) :

add_filter('pre_get_posts','cv_filter_search_query');

/**
 * Helper function to modify the WordPress search query appropriately
 */
function cv_filter_search_query( $query ) {

   if ( ! $query->is_search || ! isset( $_GET['cv_post_type'] ) ) {
     return $query;
   }

   if ( ! $request = $_GET['cv_post_type'] ) {
      $request = 'any';
   }

   $query->set( 'post_type', $request );

   return $query;

}

endif;

if ( ! class_exists('CV_Sarch_Bar') ) :

/**
 * Search Bar
 *
 * @package      WordPress
 * @subpackage   Canvys
 * @since        Version 1.0
 */
class CV_Sarch_Bar extends CV_Shortcode {

   /**
    * Function to create shortcode configuration
    *
    * @return void
    */
   public function __construct() {

      $search_type_options = array(
         'all'  => __( 'All content', 'canvys' ),
         'posts' => __( 'Blog Posts', 'canvys' ),
         'pages' => __( 'Pages', 'canvys' ),
         'portfolio' => __( 'Portfolio Items', 'canvys' ),
      );

      if ( class_exists( 'woocommerce') ) {
         $search_type_options['shop'] = __( 'WooCommerce Products', 'canvys' );
      }

      if ( class_exists( 'bbPress') ) {
         $search_type_options['forums'] = __( 'bbPress Forums', 'canvys' );
      }

      $this->config = array(

         // Handle will be used to use this shortcode
         'handle' => 'cv_search_bar',

         // Whether or not this is a shortcode composer element
         'composer_element' => true,

         // Whether or not this is a template builder element
         'builder_element' => true,

         // Used by the template builder to determine where module can be dropped
         'drop_target' => 2,

         // Used by the template builder to determine where module can have other
         // modules dropped inside of it
         'drop_zone' => false,

         // Title will be used to identify this shortcode
         'title' => __( 'Search Bar', 'canvys' ),

         // Icon will be used to represent this shortcode in composer/builder
         // List of available icons can be found in icons.json
         'icon' => 'search',

         // Whether or not shortcode is self closing
         'self_closing' => true,

         // If shortcode is not self closing, specify its default content
         'default_content' => null,

         // Specify whether or not content is directly editable
         'content_editor' => false,

         // Specify whether or not the content is composed of another shortcode
         'content_element' => false,

         // Provide an explanation of what this shortcode does
         'explanation' => __( 'This shortcode will display a stylish search bar wherever you need one, it also supports several 3rd party plugins which when installed will allow this shortcode to be set up to search through their content.', 'canvys' ),

         // Array of shortcode settings and their respective attributes
         'attributes' => array(

            new CV_Shortcode_Select_Control( 'search_type', array(
               'title'         => __( 'Search Type', 'canvys' ),
               'description'   => __( 'Specify which content should be searched for.', 'canvys' ),
               'type'          => 'select',
               'default'       => 'all',
               'options'       => $search_type_options,
            ) ),

            new CV_Shortcode_Select_Control( 'autocomplete', array(
               'title'         => __( 'Search Autocomplete', 'canvys' ),
               'description'   => __( 'Specify whether or not browser driven autocomplete should be enabled or not.', 'canvys' ),
               'type'          => 'select',
               'default'       => 'true',
               'options'       => array(
                  'true' => __( 'Yes, enable the autocomplete feature', 'canvys' ),
                  'false' => __( 'No, disable the autocomplete feature', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Select_Control( 'size', array(
               'title'         => __( 'Size', 'canvys' ),
               'description'   => __( 'Specify the size of this search bar.', 'canvys' ),
               'type'          => 'select',
               'default'       => 'normal',
               'options'       => array(
                  'small' => __( 'Small', 'canvys' ),
                  'normal' => __( 'Normal', 'canvys' ),
                  'large' => __( 'Large', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Text_Control( 'placeholder', array(
               'title'       => __( 'Placeholder', 'canvys' ),
               'description' => __( 'Specify the text to be used as the placeholder for the search bar.', 'canvys' ),
               'placeholder' => __( 'Search...', 'canvys' ),
            ) ),

            new CV_Shortcode_Text_Control( 'button_text', array(
               'title'       => __( 'Button Text', 'canvys' ),
               'description' => __( 'Specify the text to be used for the search button text.', 'canvys' ),
               'placeholder' => __( 'Go', 'canvys' ),
            ) ),

            new CV_Shortcode_Select_Control( 'button_style', array(
               'title'       => __( 'Button Style', 'canvys' ),
               'description' => __( 'Specify the style for the submit button.', 'canvys' ),
               'default'     => 'glassy',
               'options'     => array(
                  'ghost' => __( 'Ghost', 'canvys' ),
                  'filled' => __( 'Filled', 'canvys' ),
                  'glassy' => __( 'Glassy', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Select_Control( 'button_color', array(
               'title'       => __( 'Button Color', 'canvys' ),
               'description' => __( 'Specify the color for the submit button.', 'canvys' ),
               'default'     => 'content',
               'options'     => array(
                  'theme_colors' => array(
                     'label' => __( 'Theme Colors', 'canvys' ),
                     'options' => array(
                        'content' => __( 'Normal Content', 'canvys' ),
                        'headers' => __( 'Headers', 'canvys' ),
                        'accent' => __( 'Accent', 'canvys' ),
                        'focused' => __( 'Accent Focused', 'canvys' ),
                     ),
                  ),
                  'custom_color' => array(
                     'label' => __( 'Select Custom', 'canvys' ),
                     'options' => array(
                        'custom' => __( 'Custom Color', 'canvys' ),
                     ),
                  ),
               ),
            ) ),

            new CV_Shortcode_Color_Control( 'button_custom_color', array(
               'title'       => __( 'Button Custom Color', 'canvys' ),
               'description' => __( 'Specify a custom color to use for the submit button.', 'canvys' ),
            ) ),

         ),

      );
   }

   /**
    * Renders inline JavaScript/CSS required by the shortcode composer
    *
    * @return mixed
    */
   public function composer_additional_assets() { ?>

      <script id="cv-builder-cv_search_bar-script">
         (function($){
            "use strict";
            $(document).on( 'cv-composer-load-cv_search_bar', function() {
               var $modal = $('#cv-composer-absolute-container').children().last();
               $modal.find('.control-button_color select').on( 'change', function() {
                  var $this = $(this), val = $this.val(),
                      $customColor = $modal.find('.control-button_custom_color');
                  if ( 'custom' === val ) {
                     $customColor.fadeIn();
                  }
                  else {
                     $customColor.hide();
                  }
               }).trigger('change');
            });
         })(jQuery);
      </script>

   <?php }

   /**
    * Callback function for front end display of shortcode
    *
    * @param array  $atts      Array of provided attributes
    * @param string $content   Content of shortcode
    * @return string
    */
   public function callback( $atts, $content = null ) {

      static $num_forms;
      $num_forms++;

      // Create attributes array by sanitizing provided values
      extract( $this->get_sanitized_attributes( $atts ) );

      // Make sure there is a button text value
      $button_text = $button_text ? $button_text : __( 'Go', 'canvys' );

      // Set up the autocomplete attribute
      $autocomplete_attr = ! cv_make_bool( $autocomplete ) ? ' autocomplete="off"' : null;

      // Create the box
      $o = new CV_HTML( '<form>', array(
         'class' => 'cv-search-form',
         'action' => home_url( '/' ),
         'method' => 'get',
         'id' => 'cv-search-form-' . $num_forms,
         'role' => 'search',
      ) );

      // Apply the size class
      $o->add_class( 'is-' . $size );

      // Add the appropriate fields
      switch ( $search_type ) {

         case 'shop':

            // make sure woocommerce is active
            if ( ! class_exists( 'woocommerce') ) {
               return;
            }

            // Modify the form
            $o->append( '<input type="hidden" name="post_type" value="product" />' );
            $o->append( '<input type="text" name="s" value="" placeholder="' . $placeholder . '"' . $autocomplete_attr . ' />' );

            break;

         case 'forums':

            // make sure bbPress is active
            if ( ! class_exists( 'bbPress') ) {
               return;
            }

            // grab the forums search URL
            ob_start(); bbp_search_url(); $search_url = ob_get_clean();

            // Modify the form
            $o->attr( 'action', $search_url );
            $o->append( '<input type="hidden" name="action" value="bbp-search-request" />' );
            $o->append( '<input type="text" name="bbp_search" value="" placeholder="' . $placeholder . '"' . $autocomplete_attr . ' />' );

            break;

         case 'portfolio':
            $o->append( '<input type="hidden" name="cv_post_type" value="portfolio_item" />' );
            $o->append( '<input type="text" name="s" value="" placeholder="' . $placeholder . '"' . $autocomplete_attr . ' />' );
            break;

         case 'posts':
            $o->append( '<input type="hidden" name="cv_post_type" value="post" />' );
            $o->append( '<input type="text" name="s" value="" placeholder="' . $placeholder . '"' . $autocomplete_attr . ' />' );
            break;

         case 'pages':
            $o->append( '<input type="hidden" name="cv_post_type" value="page" />' );
            $o->append( '<input type="text" name="s" value="" placeholder="' . $placeholder . '"' . $autocomplete_attr . ' />' );
            break;

         default:
            $o->append( '<input type="text" name="s" value="" placeholder="' . $placeholder . '"' . $autocomplete_attr . ' />' );
            break;

      }

      // Create the submit button
      $submit = new CV_HTML( '<input />', array(
         'class' => 'cv-button button',
         'type' => 'submit',
         'value' => $button_text,
      ) );

      // Add the style class
      $submit->add_class( 'is-' . $button_style );

      // Add the color class
      if ( in_array( $button_color, array( 'headers', 'accent', 'focused' ) ) ) {
         $submit->add_class( 'color-' . $button_color );
      }

      // Apply the custom color
      else if ( 'custom' == $button_color && $button_custom_color ) {
         $submit->data( 'color', $button_custom_color );
      }

      // Add the submit button
      $o->append( $submit );

      return $o->render();

   }

}
endif;