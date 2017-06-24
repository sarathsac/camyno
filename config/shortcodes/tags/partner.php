<?php

if ( ! class_exists('CV_Partner') ) :

/**
 * Toggle
 * Class that handles the creation and configuration
 * of the toggle shortcode which is a child of the toggle group shortcode
 *
 * @package      WordPress
 * @subpackage   Canvys
 * @since        Version 1.0
 */
class CV_Partner extends CV_Shortcode {

   /**
    * Function to create shortcode configuration
    *
    * @return void
    */
   public function __construct() {

      $this->config = array(

         // Handle will be used to use this shortcode
         'handle' => 'cv_partner',

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
         'title' => __( 'Partner', 'canvys' ),

         // Icon will be used to represent this shortcode in composer/builder
         // List of available icons can be found in icons.json
         'icon' => 'water',

         // Whether or not shortcode is self closing
         'self_closing' => true,

         // If shortcode is not self closing, specify its default content
         'default_content' =>  null,

         // Specify whether or not content is directly editable
         'content_editor' => false,

         // Specify whether or not the content is composed of another shortcode
         'content_element' => false,

         // Array of shortcode settings and their respective attributes
         'attributes' => array(

            new CV_Shortcode_Text_Control( 'tooltip', array(
               'title'       => __( 'Tooltip Text', 'canvys' ),
               'description' => __( 'Add text to be displayed in a tooltip when this partner logo is hovered over.', 'canvys' ),
            ) ),

            new CV_Shortcode_Link_Control( 'url', array(
               'title'       => __( 'Partner Website', 'canvys' ),
               'description' => __( 'Specify a website for this partner to be linked to.', 'canvys' ),
            ) ),

            new CV_Shortcode_Image_Control( 'logo_id', array(
               'title'       => __( 'Logo', 'canvys' ),
               'description' => __( 'Select an image to be used as the logo for this partner.', 'canvys' ),
            ) ),

         ),
      );
   }

   /**
    * Callback function for front end display of shortcode
    *
    * @param array  $atts      Array of provided attributes
    * @param string $content   Content of shortcode
    * @return string
    */
   public function callback( $atts, $content = null ) {

      global $cv_partners;

      if ( ! is_array( $cv_partners ) ) {
         $cv_partners = array();
      }

      // Create attributes array by sanitizing provided values
      extract( $this->get_sanitized_attributes( $atts ) );

      $cv_partners[] = array(
         'tooltip'   => $tooltip,
         'url' => $url,
         'logo_id' => $logo_id,
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
      return isset($atts['tooltip']) && $atts['tooltip'] ? substr( $atts['tooltip'], 0, 35 ) : $this->config['title'];
   }

}
endif;