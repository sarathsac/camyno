<?php

if ( ! class_exists('CV_LayerSlider') ) :

/**
 * Full Screen LayerSlider
 * Class that handles the creation and configuration
 * of the full screen LayerSlider shortcode
 *
 * @package      WordPress
 * @subpackage   Canvys
 * @since        Version 1.0
 */
class CV_LayerSlider extends CV_Shortcode {

   /**
    * Function to create shortcode configuration
    *
    * @return void
    */
   public function __construct() {

      $this->slider_options = array(
         'none' => __('None', 'canvys'),
      );

      if ( class_exists('LS_Sliders') ) {

         $layerSliders = LS_Sliders::find(array(
            'orderby' => 'date_m',
            'limit' => 30,
            'data' => false
         ));

         foreach ( $layerSliders as $slider ) {
            $this->slider_options[$slider['id']] = $slider['name'] ? $slider['name'] : sprintf( __( 'Unnamed Slider [ID: %s]', 'canvys' ), $slider['id'] );
         }

      }

      $this->config = array(

         // Handle will be used to use this shortcode
         'handle' => 'layerslider',

         // Whether or not this is a shortcode composer element
         'composer_element' => false,

         // Whether or not this is a template builder element
         'builder_element' => true,

         // Used by the template builder to determine where module can be dropped
         'drop_target' => 2,

         // Used by the template builder to determine where module can have other
         // modules dropped inside of it
         'drop_zone' => false,

         // Title will be used to identify this shortcode
         'title' => __( 'LayerSlider', 'canvys' ),

         // Icon will be used to represent this shortcode in composer/builder
         // List of available icons can be found in icons.json
         'icon' => 'picture',

         // Whether or not shortcode is self closing
         'self_closing' => true,

         // If shortcode is not self closing, specify its default content
         'default_content' => null,

         // Specify whether or not content is directly editable
         'content_editor' => false,

         // Specify whether or not the content is composed of another shortcode
         'content_element' => false,

         // Provide an explanation of what this shortcode does
         'explanation' => __( 'LayerSlider is a 3rd party plugin, and can only be created/edited from its respective plugin page. Once you have created at least one LayerSlider you will be able to easily display it using this module.', 'canvys' ),

         // Array of shortcode settings and their respective attributes
         'attributes' => array(

            new CV_Shortcode_Select_Control( 'id', array(
               'title'         => __( 'LayerSlider', 'canvys' ),
               'description'   => __( 'Select the LayerSlider to display. Refer to the explanation above for more information.', 'canvys' ),
               'default'       => 'none',
               'options'       => $this->slider_options,
            ) ),

         ),
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
      $atts = $this->get_sanitized_attributes( $atts );
      return '<i class="cv-module-icon icon-' . $this->config['icon'] . '"></i><strong>' . $this->config['title'] . ':</strong> ' . $this->slider_options[$atts['id']];
   }

}
endif;