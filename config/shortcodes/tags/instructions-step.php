<?php

if ( ! class_exists('CV_Instructions_Step') ) :

/**
 * Instructions List Step
 *
 * @package      WordPress
 * @subpackage   Canvys
 * @since        Version 1.0
 */
class CV_Instructions_Step extends CV_Shortcode {

   /**
    * Function to create shortcode configuration
    *
    * @return void
    */
   public function __construct() {

      $this->config = array(

         // Handle will be used to use this shortcode
         'handle' => 'cv_instructions_step',

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
         'title' => __( 'Step', 'canvys' ),

         // Icon will be used to represent this shortcode in composer/builder
         // List of available icons can be found in icons.json
         'icon' => 'share',

         // Whether or not shortcode is self closing
         'self_closing' => false,

         // If shortcode is not self closing, specify its default content
         'default_content' => null,

         // Specify whether or not content is directly editable
         'content_editor' => true,

         // Specify whether or not the content is composed of another shortcode
         'content_element' => false,

         // Array of shortcode settings and their respective attributes
         'attributes' => array(

            new CV_Shortcode_Text_Control( 'title', array(
               'title'       => __( 'Title', 'canvys' ),
               'description' => __( 'Specify the title for this step', 'canvys' ),
            ) ),

            new CV_Shortcode_Select_Control( 'icon_source', array(
               'title'         => __( 'Icon Source', 'canvys' ),
               'description'   => __( 'Specify whether the icon should be numeric or an icon font character.', 'canvys' ),
               'default'       => 'number',
               'options'       => array(
                  'number' => __( 'Numeric', 'canvys' ),
                  'icon'  => __( 'Icon font character', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Number_Control( 'icon_number', array(
               'title'         => __( 'Number', 'canvys' ),
               'description'   => __( 'Enter a number to represent this step (Numeric value only, maximum of 3 characters). <strong>Leave this blank to use an automatically assigned number based on the number of steps</strong>.', 'canvys' ),
               'placeholder'   => 'Maximum of 3 characters',
            ) ),

            new CV_Shortcode_Icon_Control( 'icon', array(
               'title'       => __( 'Icon', 'canvys' ),
               'description' => __( 'Select the icon for this step.', 'canvys' ),
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

      <script id="cv-builder-cv_instructions_step-script">
         (function($){
            "use strict";
            $(document).on( 'cv-composer-load-cv_instructions_step', function() {
               var $modal = $('#cv-composer-absolute-container').children().last();
               $modal.find('.control-icon_source select').on( 'change', function() {
                  var $this = $(this), val = $this.val(),
                      $iconControl = $modal.find('.control-icon'),
                      $numberControl = $modal.find('.control-icon_number');
                  switch (val) {
                     case 'number':
                        $iconControl.hide();
                        $numberControl.fadeIn();
                        break;
                     case 'icon':
                        $iconControl.fadeIn();
                        $numberControl.hide();
                        break;
                  }
               }).trigger('change');
            });
         })(jQuery);
      </script>

   <?php }

   /**
    * Callback function for display of preview in builder module
    *
    * @param array  $atts      Array of provided attributes
    * @param string $content   Content of shortcode
    * @return string
    */
   public function builder_module_preview( $atts, $content = null ) {
      if ( $content ) {
         return stripslashes( wpautop( trim( html_entity_decode( $content ) ) ) );
      }
   }

   /**
    * Callback function for displaying the template builder module title
    *
    * @param array  $atts      Array of provided attributes
    * @param string $content   Content of shortcode
    * @return string
    */
   public function builder_module_title( $atts, $content = null ) {
      extract( $this->get_sanitized_attributes( $atts ) );
      $title = $title ? $title : $this->config['title'];
      $icon = 'icon' == $icon_source ? '<i class="icon-' . $icon . '"></i> ' : null;
      return $icon . $title;
   }

   /**
    * Callback function for front end display of shortcode
    *
    * @param array  $atts      Array of provided attributes
    * @param string $content   Content of shortcode
    * @return string
    */
   public function callback( $atts, $content = null ) {

      global $cv_steps;

      if ( ! is_array( $cv_steps ) ) {
         $cv_steps = array();
      }

      // Create attributes array by sanitizing provided values
      extract( $this->get_sanitized_attributes( $atts ) );

      $cv_steps[] = array(
         'title'   => $title,
         'icon_source' => $icon_source,
         'icon_number' => $icon_number,
         'icon' => $icon,
         'content' => $content,
      );

   }

}
endif;