<?php

if ( ! class_exists('CV_Media_Flag') ) :

/**
 * media Flag Shortcode
 *
 * @package      WordPress
 * @subpackage   Canvys
 * @since        Version 1.0
 */
class CV_Media_Flag extends CV_Shortcode {

   /**
    * Function to create shortcode configuration
    *
    * @return void
    */
   public function __construct() {

      global $canvys;

      $this->config = array(

         // Handle will be used to use this shortcode
         'handle' => 'cv_media_flag',

         // Whether or not this is a shortcode composer element
         'composer_element' => false,

         // Whether or not this is a template builder element
         'builder_element' => true,

         // Used by the template builder to determine where module can be dropped
         'drop_target' => 1,

         // Used by the template builder to determine where module can have other
         // modules dropped inside of it
         'drop_zone' => 2,

         // Title will be used to identify this shortcode
         'title' => __( 'Media Flag', 'canvys' ),

         // Icon will be used to represent this shortcode in composer/builder
         // List of available icons can be found in icons.json
         'icon' => 'flag',

         // Whether or not shortcode is self closing
         'self_closing' => false,

         // If shortcode is not self closing, specify its default content
         'default_content' => null,

         // Specify whether or not content is directly editable
         'content_editor' => false,

         // Specify whether or not the content is composed of another shortcode
         'content_element' => false,

         // Provide an explanation of what this shortcode does
         'explanation' => __( 'This shortcode will display a single column with any content you want adjacent to a media element of your choice (image or video embed).', 'canvys' ),

         // Array of shortcode settings and their respective attributes
         'attributes' => array(

            new CV_Shortcode_Select_Control( 'media_position', array(
               'title'       => __( 'Media Position', 'canvys' ),
               'description' => __( 'Specify where the media should be located.', 'canvys' ),
               'default'     => 'left',
               'options'     => array(
                  'left'  => __( 'Left of content', 'canvys' ),
                  'right' => __( 'Right of content', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Select_Control( 'responsive_behavior', array(
               'title'       => __( 'Responsive Behavior', 'canvys' ),
               'description' => __( 'Specify how this media flag should behave on mobile devices, disregard this if responsiveness for the theme has been disabled.', 'canvys' ),
               'default'     => 'above',
               'options'     => array(
                  'above'   => __( 'Media moved above content', 'canvys' ),
                  'below'   => __( 'Media moved below content', 'canvys' ),
                  'media'   => __( 'Hide content completely', 'canvys' ),
                  'content' => __( 'Hide media completely', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Select_Control( 'padding', array(
               'title'       => __( 'Content Padding', 'canvys' ),
               'description' => __( 'Specify how much padding should be displayed on either side of the content.', 'canvys' ),
               'default'     => 'normal',
               'options'     => array(
                  'none'      => __( 'None', 'canvys' ),
                  'normal'    => __( 'Normal', 'canvys' ),
                  'more'      => __( 'More', 'canvys' ),
                  'much-more' => __( 'Much More', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Select_Control( 'media_source', array(
               'title'       => __( 'Media Source', 'canvys' ),
               'description' => __( 'Specify the source for the media.', 'canvys' ),
               'default'     => 'image',
               'options'     => array(
                  'image'  => __( 'Image', 'canvys' ),
                  'embed'  => __( 'External Video Embed', 'canvys' ),
                  'hosted' => __( 'Self hosted video', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Image_Control( 'img', array(
               'title'       => __( 'Media Image', 'canvys' ),
               'description' => __( 'Select an image to be displayed adjactent to the content, please note that the image will be displayed at its full size.', 'canvys' ),
            ) ),

            new CV_Shortcode_Text_Control( 'embed', array(
               'title'       => __( 'External Video Embed', 'canvys' ),
               'description' => sprintf( __( 'A list of all supported Video Services can be found on <a href="%s">WordPress.org</a>. <em>Please note that only Youtube/Vimeo videos will be responsive.</em><br /><br /><strong>Working Examples:</strong><br />https://www.youtube.com/watch?v=jJ054AEGQHA<br />http://vimeo.com/68208871', 'canvys' ), 'http://codex.wordpress.org/Embeds#Okay.2C_So_What_Sites_Can_I_Embed_From.3F' ),
            ) ),

            new CV_Shortcode_File_Control( 'hosted', array(
               'title'       => __( 'Self Hosted Video URL', 'canvys' ),
               'description' => __( 'Different Browsers support different file types (mp4, ogv, webm). If you embed example.mp4 then video the video player will automatically check if an example.ogv and/or example.webm video is available and display those files when applicable.', 'canvys' ),
               'file_type'   => 'video',
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

      <script id="cv-builder-cv_media_flag-script">
         (function($){
            "use strict";
            $(document).on( 'cv-composer-load-cv_media_flag', function() {
               var $modal = $('#cv-composer-absolute-container').children().last();
               $modal.find('.control-media_source select').on( 'change', function() {
                  var $this = $(this), val = $this.val(),
                      $imageControl = $modal.find('.control-img'),
                      $embedControl = $modal.find('.control-embed'),
                      $hostedControl = $modal.find('.control-hosted');
                  if ( 'embed' === val ) {
                     $imageControl.hide();
                     $embedControl.fadeIn();
                     $hostedControl.hide();
                  }
                  else if ( 'hosted' === val ) {
                     $imageControl.hide();
                     $embedControl.hide();
                     $hostedControl.fadeIn();
                  }
                  else {
                     $imageControl.fadeIn();
                     $embedControl.hide();
                     $hostedControl.hide();
                  }
               }).trigger('change');
            });
         })(jQuery);
      </script>

   <?php }

   /**
    * Renders inline CSS required by the template builder
    *
    * @return mixed
    */
   public function builder_additional_styles() { ?>

      <style id="cv-builder-cv_media_flag-module">
         .cv-module-cv_media_flag > .feaured-media-indicator {
            position: absolute;
            top: 0;
            bottom: 0;
            margin: auto 0;
            width: 120px;
            height: 25px;
            line-height: 25px;
            text-align: center;
            text-transform: uppercase;
            font-weight: 600;
            letter-spacing: 1px;
            color: #555;
         }
         html:not([dir="rtl"]) .cv-module-cv_media_flag.media_position-left  > .feaured-media-indicator { left: 35px; }
         html[dir="rtl"] .cv-module-cv_media_flag.media_position-left  > .feaured-media-indicator { left: 0px; }
         html:not([dir="rtl"]) .cv-module-cv_media_flag.media_position-right  > .feaured-media-indicator { right: 0px; }
         html[dir="rtl"] .cv-module-cv_media_flag.media_position-right  > .feaured-media-indicator { right: 35px; }

         .cv-module-cv_media_flag > .cv-module-content {
            box-sizing: border-box;
            min-height: 115px;
         }
         .cv-module-cv_media_flag.media_position-left  > .cv-module-content { border-left: 120px solid #eee; }
         .cv-module-cv_media_flag.media_position-right > .cv-module-content { border-right: 120px solid #eee;  }

      </style>

   <?php }

   /**
    * Callback function for displaying the template builder module container
    *
    * @param array   $atts    Array of provided attributes
    * @param string  $content Content of shortcode
    * @param CV_HTML $module  The existing module object
    * @return CV_HTML
    */
   public function modify_builder_module_container( $atts, $content = null, $module ) {
      $module->append( '<div class="feaured-media-indicator">' . __( 'Media', 'canvys' ) . '</div>' );
      return $module;
   }

   /**
    * Callback function for front end display of shortcode
    *
    * @param array  $atts      Array of provided attributes
    * @param string $content   Content of shortcode
    * @return string
    */
   public function callback( $atts, $content = null ) {

      // Extract sanitized attributes
      extract( $this->get_sanitized_attributes( $atts ) );

      // The column container
      $o = new CV_HTML( '<div>', array(
         'class' => 'cv-media-flag has-clearfix',
      ) );

      // Apply the padding class
      $o->add_class( 'padding-' . $padding );

      // Apply the media position class
      $o->add_class( 'media-position-' . $media_position );

      // Apply the responsive behavior class
      $o->add_class( 'responsive-behavior-' . $responsive_behavior );

      // Add the content
      $flag_content  = '<div class="flag-content v-align-middle" style="height:300px">';
      $flag_content .= '<div class="flag-content-inner">' . do_shortcode( $content ) . '</div>';
      $flag_content .= '</div>';
      $o->append( $flag_content );

      // Create the media
      switch ( $media_source ) {
         case 'image':
            $img_data = wp_get_attachment_image_src( $img, 'cv_full' );
            $media = '<img class="is-block" src="' . $img_data[0] . '" alt="'.cv_get_attachment_alt( $img ).'" />';
            break;
         case 'embed': $media = wp_oembed_get( $embed ); break;
         case 'hosted': wp_oembed_get( $hosted ); break;
      }

      // Add the media
      $media = '<div class="flag-media"><div class="flag-media-inner">' . $media . '</div></div>';
      if ( 'below' == $responsive_behavior ) { $o->append( $media ); }
      else { $o->prepend( $media ); }

      return $o->render();

   }

}
endif;