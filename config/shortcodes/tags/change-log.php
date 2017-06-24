<?php

if ( ! class_exists('CV_Change_Log') ) :

/**
 * Change Logs
 *
 * @package      WordPress
 * @subpackage   Canvys
 * @since        Version 1.0
 */
class CV_Change_Log extends CV_Shortcode {

   /**
    * Function to create shortcode configuration
    *
    * @return void
    */
   public function __construct() {

      $this->config = array(

         // Handle will be used to use this shortcode
         'handle' => 'cv_change_log',

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
         'title' => __( 'Change Log Update', 'canvys' ),

         // Icon will be used to represent this shortcode in composer/builder
         // List of available icons can be found in icons.json
         'icon' => 'clock',

         // Whether or not shortcode is self closing
         'self_closing' => false,

         // If shortcode is not self closing, specify its default content
         'default_content' => __( 'Additional update information', 'canvys' ),

         // Specify whether or not content is directly editable
         'content_editor' => true,

         // Specify whether or not the content is composed of another shortcode
         'content_element' => false,

         // Provide an explanation of what this shortcode does
         'explanation' => __( 'Change logs allow you to efficiently display updates and changes to pretty much anything, including any of your products, the progress of something you are working on, or changes to the site itself. The content of this shortcode will be displayed as additional update information.', 'canvys' ),

         // Array of shortcode settings and their respective attributes
         'attributes' => array(

            new CV_Shortcode_Text_Control( 'date', array(
               'title'       => __( 'Release Date', 'canvys' ),
               'description' => __( 'Specify the date that this update was released. Date can be formatted any way you see fit.', 'canvys' ),
            ) ),

            new CV_Shortcode_Text_Control( 'version', array(
               'title'       => __( 'Version Number', 'canvys' ),
               'description' => __( 'Specify the version number for this update. Version number can be formatted any way you see fit.', 'canvys' ),
            ) ),

            new CV_Shortcode_Text_Control( 'title', array(
               'title'       => __( 'Update Title', 'canvys' ),
               'description' => __( 'Specify the title for this update, the title can include version number or other relevant information.<br /><br /><strong>Formatting Quick Tags:</strong><br />(b)<strong>Bold</strong>(/b)<br />(i)<em>italics</em>(/i)<br />(u)<u>underlined</u>(/u)<br />(s)<del>Striked</del>(/s)<br />', 'canvys' ),
            ) ),

            new CV_Shortcode_List_Control( 'added', array(
               'title'       => __( 'Features Added', 'canvys' ),
               'description' => __( 'Vertical Bar delimited list of features that have been added in this update. Example: Feature 1|Feature 2|Feature 3<br /><br /><strong>Formatting Quick Tags:</strong><br />(b)<strong>Bold</strong>(/b)<br />(i)<em>italics</em>(/i)<br />(u)<u>underlined</u>(/u)<br />(s)<del>Striked</del>(/s)<br />', 'canvys' ),
               'separator'   => '|',
            ) ),

            new CV_Shortcode_List_Control( 'updated', array(
               'title'       => __( 'Features Updated', 'canvys' ),
               'description' => __( 'Vertical Bar delimited list of features that have been updated in this update. Example: Feature 1|Feature 2|Feature 3<br /><br /><strong>Formatting Quick Tags:</strong><br />(b)<strong>Bold</strong>(/b)<br />(i)<em>italics</em>(/i)<br />(u)<u>underlined</u>(/u)<br />(s)<del>Striked</del>(/s)<br />', 'canvys' ),
               'separator'   => '|',
            ) ),

            new CV_Shortcode_List_Control( 'removed', array(
               'title'       => __( 'Features Removed', 'canvys' ),
               'description' => __( 'Vertical Bar delimited list of features that have been removed in this update. Example: Feature 1|Feature 2|Feature 3<br /><br /><strong>Formatting Quick Tags:</strong><br />(b)<strong>Bold</strong>(/b)<br />(i)<em>italics</em>(/i)<br />(u)<u>underlined</u>(/u)<br />(s)<del>Striked</del>(/s)<br />', 'canvys' ),
               'separator'   => '|',
            ) ),

         ),
      );
   }

   /**
    * Callback function for front end shortcode styles
    *
    * @param array $sections Color scheme settings
    * @return string
    */
   public static function front_end_styles( $sections ) {

      foreach ( $sections as $section => $colors ) {

         $section_tag = '.cv-section-' . $section;

         // Filters
         echo
           $section_tag . " .cv-change-log .log-list {"
         . "border-bottom: 1px solid {$colors['borders']};"
         . "border-left: 1px solid {$colors['borders']};"
         . "border-right: 1px solid {$colors['borders']};"
         . "}"
         . $section_tag . " .cv-change-log .log-list li {"
         . "color: {$colors['secondary_content']};"
         . "background: {$colors['secondary_bg']};"
         . "border-top: 1px solid {$colors['borders']};"
         . "}"
         . $section_tag . " .update-notes {"
         . "color: {$colors['secondary_content']};"
         . "background: {$colors['secondary_bg']};"
         . "border: 1px solid {$colors['borders']};"
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

      // Create attributes array by sanitizing provided values
      extract( $this->get_sanitized_attributes( $atts ) );

      // Create the header
      if ( $date || $title ) {

         $separator = '*****';
         $header = null;

         if ( $version ) $header .= '<strong class="update-version">' . __( 'V.', 'canvys' ) . ' ' . $version . '</strong>' . $separator;
         if ( $date ) $header .= '<span class="update-date">' . $date . '</span>' . $separator;
         if ( $title ) $header .= cv_parse_quicktags( $title );

         $header = str_replace( $separator, '<span class="separator"> - </span>', trim( $header, $separator ) );

         return '<h4 class="update-title">' . $header . '</h4>';

      }

   }

   /**
    * Renders inline CSS required by the shortcode composer
    *
    * @return mixed
    */
   public function composer_additional_styles() { ?>

      <style id="cv-builder-cv_change_log-preview">
         .cv-module-cv_change_log .cv-module-preview li {
            margin-bottom: 0 !important;
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

      // Create attributes array by sanitizing provided values
      extract( $this->get_sanitized_attributes( $atts ) );

      // Toggle group wrapper
      $o = new CV_HTML( '<div>', array(
         'class' => 'cv-change-log'
      ) );

      if ( $content ) $o->add_class( 'has-update-notes' );

      // Create the header
      if ( $date || $title ) {

         $separator = '*****';
         $header = null;

         if ( $version ) $header .= '<strong class="update-version">' . CV_CHANGE_LOG_BEFORE_VERSION . $version . '</strong>' . $separator;
         if ( $date ) $header .= '<span class="update-date">' . $date . '</span>' . $separator;
         if ( $title ) $header .= cv_parse_quicktags( $title );

         $header = str_replace( $separator, '<span class="separator"> - </span>', trim( $header, $separator ) );

         if ( $content ) $header .= ' <span class="update-notes-toggle">(<span>' . CV_CHANGE_LOG_NOTES . '</span>)</span>';

         $o->append( '<h2 class="update-title">' . $header . '</h2>' );

      }

      if ( $content ) {
         $notes  = '<div class="update-notes-wrap">';
         $notes .= '<div class="update-notes">';
         if ( CV_CHANGE_LOG_NOTES_TITLE ) $notes .= '<p><strong class="update-notes-title">' . CV_CHANGE_LOG_NOTES_TITLE . '</strong></p>';
         $notes .= apply_filters( 'the_content', $content );
         $notes .= '</div></div>';
         $o->append( $notes );
      }

      foreach ( array( 'added' => $added, 'updated' => $updated, 'removed' => $removed ) as $change_type => $changes ) {

         // make sure atleast one change has been supplied
         if ( ! $changes ) {
            continue;
         }

         $change_type_titles = array(
            'added' => CV_CHANGE_LOG_ADDED,
            'updated' => CV_CHANGE_LOG_UPDATED,
            'removed' => CV_CHANGE_LOG_REMOVED,
         );

         $label = $change_type_titles[$change_type] ? '<strong>' . $change_type_titles[$change_type] . ' - </strong>' : null;

         // Split changes into an array
         $changes = explode( '|', $changes );

         $log = '<ul class="log-list log-type-' . $change_type . '">';

         foreach ( $changes as $change ) {
            $log .= '<li>' . $label . cv_parse_quicktags( $change ) . '</li>';
         }

         $log .= '</ul>';

         $o->append( $log );
      }

      return $o->render();

   }

}
endif;