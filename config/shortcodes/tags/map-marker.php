<?php

if ( ! class_exists('CV_Map_Marker') ) :

/**
 * Toggle
 * Class that handles the creation and configuration
 * of the toggle shortcode which is a child of the toggle group shortcode
 *
 * @package      WordPress
 * @subpackage   Canvys
 * @since        Version 1.0
 */
class CV_Map_Marker extends CV_Shortcode {

   /**
    * Function to create shortcode configuration
    *
    * @return void
    */
   public function __construct() {

      $this->config = array(

         // Handle will be used to use this shortcode
         'handle' => 'cv_map_marker',

         // Whether or not this is a shortcode composer element
         'composer_element' => false,

         // Whether or not this is a template builder element
         'builder_element' => true,

         // Used by the template builder to determine where module can be dropped
         'drop_target' => 3,

         // Used by the template builder to determine where module can have other
         // modules dropped inside of it
         'drop_zone' => false,

         // Title will be used to identify this shortcode
         'title' => __( 'Marker', 'canvys' ),

         // Icon will be used to represent this shortcode in composer/builder
         // List of available icons can be found in icons.json
         'icon' => 'location',

         // Whether or not shortcode is self closing
         'self_closing' => false,

         // If shortcode is not self closing, specify its default content
         'default_content' =>  null,

         // Specify whether or not content is directly editable
         'content_editor' => true,

         // Specify whether or not the content is composed of another shortcode
         'content_element' => false,

         // Array of shortcode settings and their respective attributes
         'attributes' => array(

            new CV_Shortcode_Coordinates_Control( 'coordinates', array(
               'title'       => __( 'Coordinates', 'canvys' ),
               'description' => __( 'Specify the coordinates for this marker. First enter a full address then hit "Get Coordinates".', 'canvys' ),
            ) ),

            new CV_Shortcode_Text_Control( 'title', array(
               'title'       => __( 'Title', 'canvys' ),
               'description' => __( 'Specify the title of this marker. Please note that this title will not be displayed anywhere, it is simply a way for you to keep track of your markers.', 'canvys' ),
            ) ),

            new CV_Shortcode_Select_Control( 'window_visibility', array(
               'title'       => __( 'Popup Window', 'canvys' ),
               'description' => __( 'Specify how the popup window should be displayed, if at all.', 'canvys' ),
               'default'     => 'hidden',
               'options'     => array(
                  'hidden'  => __( 'No popup window', 'canvys' ),
                  'active'  => __( 'Active, visible on marker click', 'canvys' ),
                  'visible' => __( 'Active & visible on load', 'canvys' ),
               ),
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

      <script id="cv-builder-cv_map_marker-script">
         (function($){
            "use strict";
            $(document).on( 'cv-composer-load-cv_map_marker', function() {
               var $modal = $('#cv-composer-absolute-container').children().last();
               $modal.find('.control-window_visibility select').on( 'change', function() {
                  var $this = $(this), val = $this.val(),
                      $contentControl = $modal.find('.cv-composer-content-editor-wrap');
                  if ( 'hidden' === val ) {
                     $contentControl.hide();
                  }
                  else {
                     $contentControl.fadeIn();
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

      global $cv_map_markers;

      if ( ! is_array( $cv_map_markers ) ) {
         $cv_map_markers = array();
      }

      // Create attributes array by sanitizing provided values
      extract( $this->get_sanitized_attributes( $atts ) );

      $cv_map_markers[] = array(
         'title'   => $title,
         'coordinates' => $coordinates,
         'window_visibility' => $window_visibility,
         'content' => $content,
      );

   }

   /**
    * Callback function for displaying the template builder module title
    *
    * @param array  $atts      Array of provided attributes
    * @param string $content   Content of shortcode
    * @return string
    */
   public function builder_module_title( $atts, $content = null ) {
      return isset($atts['title']) && $atts['title'] ? $atts['title'] : $this->config['title'];
   }

}
endif;