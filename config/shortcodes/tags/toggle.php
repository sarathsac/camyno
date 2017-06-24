<?php

if ( ! class_exists('CV_Toggle') ) :

/**
 * Toggle
 * Class that handles the creation and configuration
 * of the toggle shortcode which is a child of the toggle group shortcode
 *
 * @package      WordPress
 * @subpackage   Canvys
 * @since        Version 1.0
 */
class CV_Toggle extends CV_Shortcode {

   /**
    * Function to create shortcode configuration
    *
    * @return void
    */
   public function __construct() {

      $this->config = array(

         // Handle will be used to use this shortcode
         'handle' => 'cv_toggle',

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
         'title' => __( 'Toggle', 'canvys' ),

         // Icon will be used to represent this shortcode in composer/builder
         // List of available icons can be found in icons.json
         'icon' => 'menu',

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

            new CV_Shortcode_List_Control( 'tags', array(
               'title'       => __( 'Tags', 'canvys' ),
               'description' => __( 'Comma delimited list of tags to identify this toggle, if tags are specified on at least one toggle then the toggle group will be filterable.', 'canvys' ),
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
      if ( ! isset( $atts['tags'] ) || ! $atts['tags'] ) {
         return false;
      }
      $tags = explode( ',', $atts['tags'] );
      $o = '<ul class="has-clearfix">';
      foreach ( $tags as $tag ) {
         $o .= '<li><i class="icon-tag-1"></i> ' . $tag . '</li>';
      }
      $o .= '</ul>';
      return $o;
   }

   /**
    * Renders inline CSS required by the shortcode composer
    *
    * @return mixed
    */
   public function composer_additional_styles() { ?>

      <style id="cv-builder-cv_toggle-preview">
         .cv-module-cv_toggle .cv-module-preview ul {
            list-style: none !important;
            margin: 0;
         }
         .cv-module-cv_toggle .cv-module-preview li {
            padding: 5px 10px;
            border: 1px solid rgba(0,0,0,0.05);
            background: rgba(255,255,255,0.5);
            margin: 3px;
            -webkit-border-radius: 3px;
            border-radius: 3px;
            font-weight: 400;
         }
         html:not([dir="rtl"]) .cv-module-cv_toggle .cv-module-preview li {
            float: left;
         }
         html[dir="rtl"] .cv-module-cv_toggle .cv-module-preview li {
            float: right;
         }
      </style>

   <?php }

   /**
    * Callback function for front end display of shortcode
    *
    * @param array  $atts      Array of provided attributes
    * @param string $content   Content of shortcode
    * @return string
    */
   public function callback( $atts, $content = null ) {

      global $cv_toggles;

      if ( ! is_array( $cv_toggles ) ) {
         $cv_toggles = array();
      }

      // Create attributes array by sanitizing provided values
      extract( $this->get_sanitized_attributes( $atts ) );

      $cv_toggles[] = array(
         'title'   => $title,
         'content' => $content,
         'tags' => $tags,
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