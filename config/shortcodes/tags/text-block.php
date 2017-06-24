<?php

if ( ! class_exists('CV_Text_Block') ) :

/**
 * Text Block
 * Class that handles the creation and configuration
 * of basic text blocks
 *
 * @package      WordPress
 * @subpackage   Canvys
 * @since        Version 1.0
 */
class CV_Text_Block extends CV_Shortcode {

   /**
    * Function to create shortcode configuration
    *
    * @return void
    */
   public function __construct() {

      $this->config = array(

         // Handle will be used to use this shortcode
         'handle' => 'cv_text_block',

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
         'title' => __( 'Text Block', 'canvys' ),

         // Icon will be used to represent this shortcode in composer/builder
         // List of available icons can be found in icons.json
         'icon' => 'doc-text-inv',

         // Whether or not shortcode is self closing
         'self_closing' => false,

         // If shortcode is not self closing, specify its default content
         'default_content' => __( 'Click here to add your own content', 'canvys' ),

         // Specify whether or not content is directly editable
         'content_editor' => true,

         // Specify whether or not the content is composed of another shortcode
         'content_element' => false,

         // Array of shortcode settings and their respective attributes
         'attributes' => null,

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
      return $content ? stripslashes( wpautop( trim( html_entity_decode( $content ) ) ) ) : false;
   }

   /**
    * Renders inline CSS required by the template builder
    *
    * @return mixed
    */
   public function builder_additional_styles() { ?>

      <style id="cv-builder-cv_text_block-preview">

         /* Blockquotes */
         .cv-module-cv_text_block .cv-module-preview blockquote {
            font-style: italic;
            border-left: 2px solid rgba(255,255,255,0.2);
            margin: 0.5em 0;
            padding: 0 0.5em;
         }

         /* Media Alignment */
         .cv-module-cv_text_block .cv-module-preview .alignnone {
            margin: 5px 20px 20px 0;
         }
         .cv-module-cv_text_block .cv-module-preview .aligncenter,
         .cv-module-cv_text_block .cv-module-preview div.aligncenter {
            display: block;
            margin: 5px auto 5px auto;
         }
         .cv-module-cv_text_block .cv-module-preview .alignright {
            float:right;
            margin: 5px 0 20px 20px;
         }
         .cv-module-cv_text_block .cv-module-preview .alignleft {
            float: left;
            margin: 5px 20px 20px 0;
         }
         .cv-module-cv_text_block .cv-module-preview .aligncenter {
            display: block;
            margin: 5px auto 5px auto;
         }
         .cv-module-cv_text_block .cv-module-preview a img.alignright {
            float: right;
            margin: 5px 0 20px 20px;
         }
         .cv-module-cv_text_block .cv-module-preview a img.alignnone {
            margin: 5px 20px 20px 0;
         }
         .cv-module-cv_text_block .cv-module-preview a img.alignleft {
            float: left;
            margin: 5px 20px 20px 0;
         }
         .cv-module-cv_text_block .cv-module-preview a img.aligncenter {
            display: block;
            margin-left: auto;
            margin-right: auto
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
      return apply_filters( 'the_content', $content );
   }

}
endif;