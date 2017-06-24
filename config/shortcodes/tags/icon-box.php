<?php

if ( ! class_exists('CV_Icon_Box') ) :

/**
 * Icon Boxes
 *
 * @package      WordPress
 * @subpackage   Canvys
 * @since        Version 1.0
 */
class CV_Icon_Box extends CV_Shortcode {

   /**
    * Function to create shortcode configuration
    *
    * @return void
    */
   public function __construct() {

      $this->config = array(

         // Handle will be used to use this shortcode
         'handle' => 'cv_icon_box',

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

         // Provide an explanation of what this shortcode does
         'explanation' => __( 'Icon boxes are a staple in any modern website, they can be used for many prposes including a list of services or showing off some of your companys best attributes.', 'canvys' ),

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

            new CV_Shortcode_Select_Control( 'style', array(
               'title'       => __( 'Style', 'canvys' ),
               'description' => __( 'Specify the style for this icon box', 'canvys' ),
               'default'     => 'standard',
               'options'     => array(
                  'standard' => __( 'Standard, large icon above title', 'canvys' ),
                  'side' => __( 'Sideways, large icon adjacent to box', 'canvys' ),
                  'inline'   => __( 'Inline, icon displayed on same line as title', 'canvys' ),
                  'inline-centered'   => __( 'Inline & Centered', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Select_Control( 'icon_style', array(
               'title'       => __( 'Icon Style', 'canvys' ),
               'description' => __( 'Specify how the icon should be styled for this icon box', 'canvys' ),
               'default'     => 'standard',
               'options'     => array(
                  'standard' => __( 'Standard, no special styling', 'canvys' ),
                  'enscribed'  => __( 'Enscribed in a circle', 'canvys' ),
                  'enscribed-border'  => __( 'Enscribed in a circle with border', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Color_Control( 'icon_color', array(
               'title'       => __( 'Icon Color', 'canvys' ),
               'description' => __( 'Specify a custom color to use for the icon, if none is specified the section\'s accent color will be used.', 'canvys' ),
            ) ),

            new CV_Shortcode_Icon_Control( 'icon', array(
               'title'       => __( 'Icon', 'canvys' ),
               'description' => __( 'Select the icon for this icon box.', 'canvys' ),
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

         // begin output
         echo
           $section_tag . " .cv-icon-box .cv-icon-box-icon {"
         . "color: {$colors['accent']};"
         . "}"
         . $section_tag . " .cv-icon-box.icon-style-enscribed .cv-icon-box-icon {"
         . "background: {$colors['secondary_bg']};"
         . "color: {$colors['content']};"
         . "}"
         . $section_tag . " .cv-icon-box.icon-style-enscribed.with-border .cv-icon-box-icon {"
         . "border: 1px solid " . cv_hex_to_rgba( $colors['accent'], 0.5 ) . ";"
         . "color: {$colors['accent']};"
         . "}"
         . $section_tag . " .cv-icon-box.icon-style-enscribed.with-border:hover .cv-icon-box-icon {"
         . "border-color: {$colors['accent']};"
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
      $title = $atts['title'] ? $atts['title'] : __( 'Check this out', 'canvys' );
      $o  = '<i class="box-icon icon-' . $atts['icon'] . '"></i>';
      $o .= '<h3 class="box-title">' . $title . '</h3>';
      if ( $content ) {
         $o .= stripslashes( wpautop( trim( html_entity_decode( $content ) ) ) );
      }
      return $o;
   }

   /**
    * Renders inline CSS required by the template builder
    *
    * @return mixed
    */
   public function builder_additional_styles() { ?>

      <style id="cv-builder-cv_icon_box-preview">
         .cv-module-cv_icon_box .cv-module-preview .box-icon {
            display: block;
            background: rgba(255,255,255,0.05);
            -webkit-border-radius: 60px;
            border-radius: 60px;
            height: 60px; width: 60px;
            line-height: 60px;
            text-align: center;
            margin: 10px auto;
            color: #eee !important;
            font-size: 20px;
         }
         .cv-module-cv_icon_box .cv-module-preview .box-title {
            text-align: center;
            margin: 0 0 10px !important;
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

      // Create the box
      $o = new CV_HTML( '<div>', array(
         'class' => 'cv-icon-box',
      ) );

      if ( 'inline-centered' == $style ) {
         $style = 'inline';
         $o->css( 'text-align', 'center' );
      }

      // Apply the icon style class
      if ( 'enscribed-border' == $icon_style ) $icon_style = 'enscribed with-border';
      $o->add_class( 'icon-style-' . $icon_style );

      // Apply the style class
      $o->add_class('style-' . $style);

      // Set up the icon color attribute
      $icon_color = $icon_color ? ' style="color:' . $icon_color . ';"' : null;

      // Add the title & icon
      switch ( $style ) {

         case 'standard':
            $o->append( '<div class="cv-icon-box-icon icon-' . $icon . '"' . $icon_color . '></div>' );
            $o->append( '<h3 class="cv-icon-box-title">' . $title . '</h3>' );
            break;

         case 'side':
            $o->append( '<div class="cv-icon-box-icon icon-' . $icon . '"' . $icon_color . '></div>' );
            $o->append( '<h3 class="cv-icon-box-title"><span>' . $title . '</span></h3>' );
            break;

         case 'inline':
            $o->append( '<h3 class="cv-icon-box-title"><i class="cv-icon-box-icon icon-' . $icon . '"' . $icon_color . '></i>' . $title . '</h3>' );
            break;

      }


      // Add the content
      if ( $content ) {
         $o->append( '<div class="cv-icon-box-content">' . apply_filters( 'the_content', $content ) . '</div>' );
      }

      // Add the superlink class when applicable
      if ( $href = cv_get_shortcode_link_control_url( $url ) ) {
         $o->add_class( 'cv-superlink' );

         // Create the link
         $link = new CV_HTML( '<a>', array(
            'content' => $title,
            'class'   => 'cv-icon-box-link',
            'href'    => $href,
            'style'   => 'display:none;',
         ) );

         // Apply the target attribute
         if ( cv_get_shortcode_link_control_target( $url ) ) {
            $link->attr( 'target', '_blank' );
         }

         // Append the link to the content
         $o->append( $link );
      }

      return $o->render();

   }

}
endif;