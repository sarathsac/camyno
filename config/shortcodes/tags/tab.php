<?php

if ( ! class_exists('CV_Tab') ) :

/**
 * Tabs
 *
 * @package      WordPress
 * @subpackage   Canvys
 * @since        Version 1.0
 */
class CV_Tab extends CV_Shortcode {

   /**
    * Function to create shortcode configuration
    *
    * @return void
    */
   public function __construct() {

      $this->config = array(

         // Handle will be used to use this shortcode
         'handle' => 'cv_tab',

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
         'title' => __( 'Tab', 'canvys' ),

         // Icon will be used to represent this shortcode in composer/builder
         // List of available icons can be found in icons.json
         'icon' => 'folder',

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

            new CV_Shortcode_Text_Control( 'title', array(
               'title'       => __( 'Title', 'canvys' ),
               'description' => __( 'Specify the title of this toggle.', 'canvys' ),
               'default'     => __( 'Click to Toggle', 'canvys' ),
            ) ),

            new CV_Shortcode_Select_Control( 'with_icon', array(
               'title'         => __( 'Display Icon', 'canvys' ),
               'description'   => __( 'Display an icon next to the title of this tab.', 'canvys' ),
               'type'          => 'select',
               'default'       => 'true',
               'options'       => array(
                  'true'  => __( 'Yes, display the icon', 'canvys' ),
                  'false' => __( 'No, do not display the icon', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Icon_Control( 'icon', array(
               'title'       => __( 'Icon', 'canvys' ),
               'description' => __( 'Select the icon for this tab.', 'canvys' ),
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

      <script id="cv-builder-cv_tab-script">
         (function($){
            "use strict";
            $(document).on( 'cv-composer-load-cv_tab', function() {
               var $modal = $('#cv-composer-absolute-container').children().last();
               $modal.find('.control-with_icon select').on( 'change', function() {
                  var $this = $(this), val = $this.val(),
                      $iconControl = $modal.find('.control-icon');
                  if ( 'true' === val ) {
                     $iconControl.fadeIn();
                  }
                  else {
                     $iconControl.hide();
                  }
               }).trigger('change');
            });
         })(jQuery);
      </script>

   <?php }

   /**
    * Renders inline CSS required by the shortcode composer
    *
    * @return mixed
    */
   public function composer_additional_styles() { ?>

      <style id="cv-builder-cv_tab">

         /* Style different sizes */
         @media (min-width: 800px) {
            .cv-module-preview .cv-module-cv_tab {
               width: 48% !important;
               float: left;
               clear: none;
               margin-left: 1%;
               margin-right: 1%;
               text-align: center;
            }
         }

      </style>

   <?php }

   /**
    * Callback function for displaying the template builder module title
    *
    * @param array  $atts      Array of provided attributes
    * @param string $content   Content of shortcode
    * @return string
    */
   public function builder_module_title( $atts, $content = null ) {
      $icon  = isset( $atts['with_icon'] ) && cv_make_bool( $atts['with_icon'] ) && isset( $atts['icon'] ) ? '<i class="icon-' . $atts['icon'] . '"></i> ' : null;
      $title  = isset( $atts['title'] ) && $atts['title'] ? $atts['title'] : $this->config['title'];
      return $icon . ' ' . $title;
   }

   /**
    * Callback function for front end display of shortcode
    *
    * @param array  $atts      Array of provided attributes
    * @param string $content   Content of shortcode
    * @return string
    */
   public function callback( $atts, $content = null ) {

      global $cv_tabs;

      if ( ! is_array( $cv_tabs ) ) {
         $cv_tabs = array();
      }

      // Create attributes array by sanitizing provided values
      extract( $this->get_sanitized_attributes( $atts ) );

      $cv_tabs[] = array(
         'title'   => $title,
         'with_icon' => $with_icon,
         'icon' => $icon,
         'content' => $content,
      );

   }

}
endif;