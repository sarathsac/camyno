<?php

if ( ! class_exists('CV_Sticky_Menu_Item') ) :

/**
 * Sticky Menu Item
 * Class that handles the creation and configuration
 * of the sticky menu item shortcode which is a child of the sticky menu shortcode
 *
 * @package      WordPress
 * @subpackage   Canvys
 * @since        Version 1.0
 */
class CV_Sticky_Menu_Item extends CV_Shortcode {

   /**
    * Function to create shortcode configuration
    *
    * @return void
    */
   public function __construct() {

      $this->config = array(

         // Handle will be used to use this shortcode
         'handle' => 'cv_sticky_menu_item',

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
         'title' => __( 'Sticky Menu Item', 'canvys' ),

         // Icon will be used to represent this shortcode in composer/builder
         // List of available icons can be found in icons.json
         'icon' => 'link',

         // Whether or not shortcode is self closing
         'self_closing' => true,

         // If shortcode is not self closing, specify its default content
         'default_content' =>  null,

         // Specify whether or not content is directly editable
         'content_editor' => false,

         // Specify whether or not the content is composed of another shortcode
         'content_element' => false,

         // Provide an explanation of what this shortcode does
         'explanation' => __( 'Sticky Menu Items can be linked to either a section of the page they are displayed on, or to an external page. When linking to an existing section make sure the ID setting of the target section and the Linked Section ID setting match exactly.', 'canvys' ),

         // Array of shortcode settings and their respective attributes
         'attributes' => array(

            new CV_Shortcode_Text_Control( 'label', array(
               'title'       => __( 'Label', 'canvys' ),
               'description' => __( 'Specify the displayed label of this menu item.', 'canvys' ),
            ) ),

            new CV_Shortcode_Link_Control( 'link', array(
               'title'       => __( 'Link', 'canvys' ),
               'description' => __( 'Specify how this menu item should be linked.', 'canvys' ),
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
      return isset($atts['label']) && $atts['label'] ? $atts['label'] : __( 'No Title', 'canvys' );
      // With Icon
      // return '<i class="cv-module-icon icon-' . $this->config['icon'] . '"></i>' . $title;
   }

   /**
    * Callback function for front end display of shortcode
    *
    * @param array  $atts      Array of provided attributes
    * @param string $content   Content of shortcode
    * @return string
    */
   public function callback( $atts, $content = null ) {

      global $cv_sticky_menu_items;

      if ( ! is_array( $cv_sticky_menu_items ) ) {
         $cv_sticky_menu_items = array();
      }

      // Create attributes array by sanitizing provided values
      extract( $this->get_sanitized_attributes( $atts ) );

      $cv_sticky_menu_items[] = array(
         'label' => $label,
         'link'  => $link,
      );

   }

}
endif;