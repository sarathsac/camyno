<?php

if ( ! class_exists('CV_Notification') ) :

/**
 * Notification Boxes
 *
 * @package      WordPress
 * @subpackage   Canvys
 * @since        Version 1.0
 */
class CV_Notification extends CV_Shortcode {

   /**
    * Function to create shortcode configuration
    *
    * @return void
    */
   public function __construct() {

      $this->config = array(

         // Handle will be used to use this shortcode
         'handle' => 'cv_notification',

         // Whether or not this is a shortcode composer element
         'composer_element' => true,

         // Whether or not this is a template builder element
         'builder_element' => true,

         // Used by the template builder to determine where module can be dropped
         'drop_target' => 2,

         // Used by the template builder to determine where module can have other
         // modules dropped inside of it
         'drop_zone' => false,

         // Title will be used to identify this shortcode
         'title' => __( 'Notification Box', 'canvys' ),

         // Icon will be used to represent this shortcode in composer/builder
         // List of available icons can be found in icons.json
         'icon' => 'attention',

         // Whether or not shortcode is self closing
         'self_closing' => true,

         // If shortcode is not self closing, specify its default content
         'default_content' => null,

         // Specify whether or not content is directly editable
         'content_editor' => false,

         // Specify whether or not the content is composed of another shortcode
         'content_element' => false,

         // Array of shortcode settings and their respective attributes
         'attributes' => array(

            new CV_Shortcode_Select_Control( 'type', array(
               'title'       => __( 'Notification Type', 'canvys' ),
               'description' => __( 'Specify which type of notification this is.', 'canvys' ),
               'default'     => 'neutral',
               'options'     => array(
                  'neutral' => __( 'Neutral (Match the section)', 'canvys' ),
                  'info'    => __( 'Informational (Blue)', 'canvys' ),
                  'success' => __( 'Success (Green)', 'canvys' ),
                  'error'   => __( 'Error (Red)', 'canvys' ),
                  'warning' => __( 'Warning (Yellow)', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Text_Control( 'text', array(
               'title'       => __( 'Notification Text', 'canvys' ),
               'description' => __( 'Specify the text to be displayed in the notification box.', 'canvys' ),
            ) ),

            new CV_Shortcode_Select_Control( 'icon_source', array(
               'title'       => __( 'Icon', 'canvys' ),
               'description' => __( 'Each notification type has a unique default icon, you can choose whether to use this icon, a custom one, or hide the icon altogether.', 'canvys' ),
               'default'     => 'default',
               'options'     => array(
                  'default'  => __( 'Use the default icon', 'canvys' ),
                  'custom' => __( 'Select a custom icon', 'canvys' ),
                  'none'  => __( 'Hide the icon', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Icon_Control( 'icon', array(
               'title'       => __( 'Icon', 'canvys' ),
               'description' => __( 'Specify a custom icon to be used for this notification box.', 'canvys' ),
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

      <script id="cv-builder-cv_notification-script">
         (function($){
            "use strict";
            $(document).on( 'cv-composer-load-cv_notification', function() {
               var $modal = $('#cv-composer-absolute-container').children().last();
               $modal.find('.control-icon_source select').on( 'change', function() {
                  var $this = $(this), val = $this.val(),
                      $iconControl = $modal.find('.control-icon');
                  if ( 'custom' === val ) {
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
    * Callback function for front end shortcode styles
    *
    * @param array $sections Color scheme settings
    * @return string
    */
   public static function front_end_styles( $sections ) {

      foreach ( $sections as $section => $colors ) {

         $section_tag = '.cv-section-' . $section;

         echo
           $section_tag . " .cv-notification.is-neutral {"
         . "background: {$colors['secondary_bg']};"
         . "color: {$colors['secondary_content']};"
         . "}"
         ;

      }

   }

   /**
    * Callback function for display of preview in builder module
    *
    * @param array  $atts      Array of provided attributes
    * @param string $content   Content of shortcode
    * @return string
    */
   public function builder_module_preview( $atts, $content = null ) {
      extract( $this->get_sanitized_attributes( $atts ) );
      if ( ! $text ) return false;
      $icon = null;
      if ( 'none' != $icon_source ) {
         switch ( $type ) {
            case 'neutral': $default_icon = 'asterisk'; break;
            case 'info': $default_icon = 'info'; break;
            case 'success': $default_icon = 'ok'; break;
            case 'error': $default_icon = 'alert'; break;
            case 'warning': $default_icon = 'attention'; break;
         }
         $icon = 'custom' == $icon_source ? $icon : $default_icon;
      }
      if ( $icon ) $icon = '<i class="icon-' . $icon . '"></i>';
      return '<strong>' . $icon . ' ' . $text . '</strong>';
   }

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

      // Create the notification
      $o = new CV_HTML( '<div>', array(
         'class' => 'cv-notification',
      ) );

      // Apply the notification type class
      $o->add_class( 'is-' . $type );

      // Add the icon
      if ( 'none' != $icon_source ) {
         switch ( $type ) {
            case 'neutral': $default_icon = 'asterisk'; break;
            case 'info': $default_icon = 'info'; break;
            case 'success': $default_icon = 'ok'; break;
            case 'error': $default_icon = 'alert'; break;
            case 'warning': $default_icon = 'attention'; break;
         }
         $icon = 'custom' == $icon_source ? $icon : $default_icon;
         $o->append( '<p><i class="notification-icon icon-' . $icon . '"></i></p>' );
      }

      // Add the text
      if ( $text ) {
         $o->append( '<p class="notification-title">' . $text . '</p>' );
      }

      return $o->render();

   }

}
endif;