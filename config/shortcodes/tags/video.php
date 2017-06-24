<?php

if ( ! class_exists('CV_Video') ) :

/**
 * Video Embed
 *
 * @package      WordPress
 * @subpackage   Canvys
 * @since        Version 1.0
 */
class CV_Video extends CV_Shortcode {

   /**
    * Function to create shortcode configuration
    *
    * @return void
    */
   public function __construct() {

      $this->config = array(

         // Handle will be used to use this shortcode
         'handle' => 'cv_video',

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
         'title' => __( 'Video Embed', 'canvys' ),

         // Icon will be used to represent this shortcode in composer/builder
         // List of available icons can be found in icons.json
         'icon' => 'video-1',

         // Whether or not shortcode is self closing
         'self_closing' => true,

         // If shortcode is not self closing, specify its default content
         'default_content' => null,

         // Specify whether or not content is directly editable
         'content_editor' => false,

         // Specify whether or not the content is composed of another shortcode
         'content_element' => false,

         // Provide an explanation of what this shortcode does
         'explanation' => __( 'This shortcode allows you to easily display either an embedded video or self hosted HTML5 video.', 'canvys' ),

         // Array of shortcode settings and their respective attributes
         'attributes' => array(

            new CV_Shortcode_Select_Control( 'source', array(
               'title'       => __( 'Video Source', 'canvys' ),
               'description' => __( 'Specify the source for this video.', 'canvys' ),
               'default'     => 'embed',
               'options'     => array(
                  'embed'  => __( 'External Video Embed', 'canvys' ),
                  'hosted' => __( 'Self hosted video', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Text_Control( 'embed', array(
               'title'       => __( 'External Video Embed', 'canvys' ),
               'description' => sprintf( __( 'A list of all supported Video Services can be found on <a href="%s">WordPress.org</a>. <em>Please note that only Youtube/Vimeo videos will be responsive.</em><br /><br /><strong>Working Examples:</strong><br />https://www.youtube.com/watch?v=jJ054AEGQHA<br />http://vimeo.com/68208871', 'canvys' ), 'http://codex.wordpress.org/Embeds#Okay.2C_So_What_Sites_Can_I_Embed_From.3F' ),
            ) ),

            new CV_Shortcode_File_Control( 'webm', array(
               'title'       => __( 'HTML5 Video WebM URL', 'canvys' ),
               'description' => __( '<strong>WebM</strong> file to use for the video.', 'canvys' ),
               'file_type'   => 'video',
            ) ),

            new CV_Shortcode_File_Control( 'ogg', array(
               'title'       => __( 'HTML5 Video Ogg URL', 'canvys' ),
               'description' => __( '<strong>Ogg</strong> file to use for the video.', 'canvys' ),
               'file_type'   => 'video',
            ) ),

            new CV_Shortcode_File_Control( 'mp4', array(
               'title'       => __( 'HTML5 Video MP4 URL', 'canvys' ),
               'description' => __( '<strong>MP4</strong> file to use for the video.', 'canvys' ),
               'file_type'   => 'video',
            ) ),

            new CV_Shortcode_Select_Control( 'auto', array(
               'title'         => __( 'Autoplay', 'canvys' ),
               'type'          => 'select',
               'default'       => 'true',
               'options'       => array(
                  'true'  => __( 'Yes, automatically start the video', 'canvys' ),
                  'false' => __( 'No, video must be started manually', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Select_Control( 'audio', array(
               'title'         => __( 'Audio', 'canvys' ),
               'type'          => 'select',
               'default'       => 'true',
               'options'       => array(
                  'true'  => __( 'Yes, enable video audio', 'canvys' ),
                  'false' => __( 'No, video will be muted', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Select_Control( 'loop', array(
               'title'         => __( 'Loop', 'canvys' ),
               'type'          => 'select',
               'default'       => 'false',
               'options'       => array(
                  'true'  => __( 'Yes, video will loop continually', 'canvys' ),
                  'false' => __( 'No, video will play once and then stop', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Select_Control( 'controls', array(
               'title'         => __( 'Controls', 'canvys' ),
               'type'          => 'select',
               'default'       => 'true',
               'options'       => array(
                  'true'  => __( 'Yes, video will have manual controls', 'canvys' ),
                  'false' => __( 'No, video will have no controls', 'canvys' ),
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

      <script id="cv-builder-cv_video-script">
         (function($){
            "use strict";
            $(document).on( 'cv-composer-load-cv_video', function() {
               var $modal = $('#cv-composer-absolute-container').children().last();
               $modal.find('.control-source select').on( 'change', function() {
                  var $this = $(this), val = $this.val(),
                      $embedControls = $modal.find('.control-embed'),
                      $hostedControls = $modal.find('.control-webm, .control-ogg, .control-mp4, .control-auto, .control-audio, .control-loop, .control-controls');
                  if ( 'embed' === val ) {
                     $embedControls.fadeIn();
                     $hostedControls.hide();
                  }
                  else {
                     $embedControls.hide();
                     $hostedControls.fadeIn();
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

      // Create attributes array by sanitizing provided values
      extract( $this->get_sanitized_attributes( $atts ) );

      switch ( $source ) {

         case 'embed':
            return wp_oembed_get( $embed );
            break;

         case 'hosted':
            $sources_html = '';
            if ( ! empty( $webm ) ) {
               $sources_html .= '<source src="'.$webm.'" type="video/webm" />';
            }
            if ( ! empty( $ogg ) ) {
               $sources_html .= '<source src="'.$ogg.'" type="video/ogg" />';
            }
            if ( ! empty( $mp4 ) ) {
               $sources_html .= '<source src="'.$mp4.'" type="video/mp4" />';
            }

            // This means we have at least one `valid` source
            if ( $sources_html ) {
               $auto = cv_make_bool( $auto ) ? ' autoplay' : '';
               $audio = ! cv_make_bool( $audio ) ? ' muted' : '';
               $loop = cv_make_bool( $loop ) ? ' loop' : '';
               $controls = cv_make_bool( $controls ) ? ' controls' : '';
               return '<video'.$auto.$audio.$loop.$controls.'>'.$sources_html.'</video>';
            }
            break;

      }

   }

}
endif;