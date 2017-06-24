<?php

if ( ! class_exists('CV_Icon_Box_Child') ) :

/**
 * Icon Boxes as a child element
 *
 * @package      WordPress
 * @subpackage   Canvys
 * @since        Version 1.0
 */
class CV_Icon_Box_Child extends CV_Shortcode {

   /**
    * Function to create shortcode configuration
    *
    * @return void
    */
   public function __construct() {

      $this->config = array(

         // Handle will be used to use this shortcode
         'handle' => 'cv_icon_box_child',

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
         'title' => __( 'Icon Box', 'canvys' ),

         // Icon will be used to represent this shortcode in composer/builder
         // List of available icons can be found in icons.json
         'icon' => 'info-circled',

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
               'description' => __( 'Icon Box Title, will default to "Check this out" if left blank.', 'canvys' ),
               'placeholder' => __( 'Check this out', 'canvys' ),
            ) ),

            new CV_Shortcode_Link_Control( 'url', array(
               'title'       => __( 'Icon Box Link', 'canvys' ),
               'description' => __( 'Wrap this icon box in a link. <strong>Do not use this setting if you plan on placing a link within the content of this icon box.</strong>', 'canvys' ),
            ) ),

            new CV_Shortcode_Color_Control( 'icon_color', array(
               'title'       => __( 'Icon Color', 'canvys' ),
               'description' => __( 'Specify a custom color to use for the icon, if none is specified the default color will be used.', 'canvys' ),
            ) ),

            new CV_Shortcode_Icon_Control( 'icon', array(
               'title'       => __( 'Icon', 'canvys' ),
               'description' => __( 'Select the icon for this icon box.', 'canvys' ),
            ) ),

         ),

      );
   }

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
      return '<i class="icon-' . $icon . '"></i> ' . $title;
   }

   /**
    * Callback function for front end display of shortcode
    *
    * @param array  $atts      Array of provided attributes
    * @param string $content   Content of shortcode
    * @return string
    */
   public function callback( $atts, $content = null ) {

      global $cv_icon_boxes;

      if ( ! is_array( $cv_icon_boxes ) ) {
         $cv_icon_boxes = array();
      }

      // Create attributes array by sanitizing provided values
      extract( $this->get_sanitized_attributes( $atts ) );

      $cv_icon_boxes[] = array(
         'title'   => $title,
         'url'   => $url,
         'icon' => $icon,
         'icon_color' => $icon_color,
         'content' => $content,
      );

   }

}
endif;