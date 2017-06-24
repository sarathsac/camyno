<?php

if ( ! class_exists('CV_Testimonial_Group') ) :

/**
 * Testimonial Groups
 *
 * @package      WordPress
 * @subpackage   Canvys
 * @since        Version 1.0
 */
class CV_Testimonial_Group extends CV_Shortcode {

   /**
    * Function to create shortcode configuration
    *
    * @return void
    */
   public function __construct() {

      $this->config = array(

         // Handle will be used to use this shortcode
         'handle' => 'cv_testimonial_group',

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
         'title' => __( 'Testimonials', 'canvys' ),

         // Icon will be used to represent this shortcode in composer/builder
         // List of available icons can be found in icons.json
         'icon' => 'smile',

         // Whether or not shortcode is self closing
         'self_closing' => false,

         // If shortcode is not self closing, specify its default content
         'default_content' => '[cv_testimonial author_name="John Doe" author_url="http://www.google.com/"][/cv_testimonial]'
                            . '[cv_testimonial author_name="Jane Doe" author_url="http://www.google.com/"][/cv_testimonial]',

         // Specify whether or not content is directly editable
         'content_editor' => false,

         // Specify whether or not the content is composed of another shortcode
         'content_element' => 'cv_testimonial',

         // Provide an explanation of what this shortcode does
         'explanation' => __( 'Easily display your hard earned customer testimonials, or general quotes concerning your website & its content.', 'canvys' ),

         // Array of shortcode settings and their respective attributes
         'attributes' => array(

            new CV_Shortcode_Select_Control( 'style', array(
               'title'         => __( 'Style', 'canvys' ),
               'description'   => __( 'Specify how these testimonials should be displayed', 'canvys' ),
               'type'          => 'select',
               'default'       => 'slider',
               'options'       => array(
                  'slider' => __( 'Fading slider', 'canvys' ),
                  'single' => __( 'Single column', 'canvys' ),
                  'grid-2' => __( '2 column grid', 'canvys' ),
                  'grid-3' => __( '3 column grid', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Select_Control( 'display_images', array(
               'title'         => __( 'Display Author Images', 'canvys' ),
               'description'   => __( 'Whether or not each testimonial should be displayed with the supplied author image.', 'canvys' ),
               'type'          => 'select',
               'default'       => 'true',
               'options'       => array(
                  'true'  => __( 'Yes, display author images', 'canvys' ),
                  'false' => __( 'No, hide author images', 'canvys' ),
               ),
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
           $section_tag . " .cv-testimonial-group .testimonial-content {"
         . "border: 1px solid {$colors['borders']};"
         . "background: {$colors['primary_bg']};"
         . "}"
         . $section_tag . " .cv-testimonial-group .testimonial-content:after {"
         . "border-top-color: {$colors['primary_bg']};"
         . "}"
         . $section_tag . " .cv-testimonial-group .testimonial-content:before {"
         . "border-top-color: {$colors['borders']};"
         . "}"
         . $section_tag . " .cv-testimonial-group-slider .slick-dots button {"
         . "box-shadow: inset {$colors['content']} 0px 0px 0px 1px !important;"
         . "}"
         . $section_tag . " .cv-testimonial-group-slider .slick-dots .slick-active button {"
         . "box-shadow: inset {$colors['accent']} 0px 0px 0px 1px !important;"
         . "}"
         ;

      }

   }

   /**
    * Callback function for front end display of shortcode
    *
    * @param array  $atts      Array of provided attributes
    * @param string $content   Content of shortcode
    * @return string
    */
   public function callback( $atts, $content = null ) {

      global $cv_testimonials;

      // Start with an empty array
      $cv_testimonials = array();

      // Fill the toggles array
      do_shortcode( $content );

      // Make sure there is atleast 1 testimonial
      if ( empty( $cv_testimonials ) ) {
         return;
      }

      // Create attributes array by sanitizing provided values
      extract( $this->get_sanitized_attributes( $atts ) );

      // Testimonial group wrapper
      $o = new CV_HTML( '<div>', array(
         'class' => 'cv-testimonial-group'
      ) );

      switch ( $style ) {
         case 'slider':
            $o->add_class( 'cv-slider is-gallery' );
            $o->data( 'auto', 'true' );
            $o->data( 'delay', 8000 );
            $o->data( 'mode', 'fade' );
            $o->data( 'pager', 'true' );
            $o->data( 'controls', 'false' );
            break;
         case 'single':
            $o->add_class( 'is-single-column' );
            break;
         default:
            $o->add_class( 'is-grid cv-' . $style . ' spacing-2 has-clearfix masonry-layout' );
      }

      if ( false !== strpos( $style, 'grid-' ) ) {
         $o->data( 'trigger-entrances', 'true' );
      }

      // Add the testimonials
      $entrance_delay = 0;
      foreach ( $cv_testimonials as $testimonial_config ) {

         // Testimonial wrapper
         $testimonial = new CV_HTML( '<div>', array(
            'class' => 'testimonial-wrap'
         ) );

         // Add the content
         $testimonial->append( '<div class="testimonial-content"><div class="testimonial-quote v-align-middle"><div>' . apply_filters( 'the_content', $testimonial_config['content'] ) . '</div></div></div>' );

         $testimonial->append( '<div class="author-profile has-clearfix">' );

         // Add the image
         if ( $testimonial_config['author_img'] ) {
            $img_info = wp_get_attachment_image_src( $testimonial_config['author_img'], 'cv_square_medium' );
            $img_url = $img_info[0];
         }
         else {
            $img_url = THEME_DIR . 'assets/img/anonymous.png';
         }

         $entrance_data = null;
         if ( false !== strpos( $style, 'grid-' ) ) {
            $entrance_data = ' data-entrance="zoomIn" data-delay="' . $entrance_delay . '" data-chained="true"';
            $entrance_delay += 250;
         }

         if ( 'true' == $display_images ) {
            $testimonial->append( '<img class="testimonial-image" src="' . $img_url . '"' . $entrance_data . ' alt="'.cv_get_attachment_alt($testimonial_config['author_img']).'" />' );
         }

         $testimonial->append( '<div class="textual-information">' );

         // Add the author name
         $testimonial->append( '<h4 class="author-name">' . $testimonial_config['author_name'] . '</h4>' );

         // Add the author info
         if ( $testimonial_config['author_info'] || $testimonial_config['company_name'] ) {

            $testimonial->append( '<p class="company-info">' );

            if ( $author_info = $testimonial_config['author_info'] ) {
               $testimonial->append( '<span class="author-title">' . $author_info . '</span>' );
            }

            if ( $company_name = $testimonial_config['company_name'] ) {
               $testimonial->append( ' / ' );
               if ( $testimonial_config['company_url'] ) {
                  $testimonial->append( '<a href="'.$testimonial_config['company_url'].'" class="author-company">' . $company_name . '</a>' );
               }
               else {
                  $testimonial->append( '<span class="author-company">' . $company_name . '</span>' );
               }
            }

            $testimonial->append( '</p>' );

         }

         $testimonial->append( '</div>' );

         $testimonial->append( '</div>' );


         // Add the testimonial
         $o->append( '<div>' . $testimonial . '</div>' );

      }

      return 'slider' == $style ? '<div class="cv-testimonial-group-slider">' . $o . '</div>' : $o->render();

   }

}
endif;