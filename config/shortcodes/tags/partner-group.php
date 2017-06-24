<?php

if ( ! class_exists('CV_Partner_Group') ) :

/**
 * Icon Boxes
 *
 * @package      WordPress
 * @subpackage   Canvys
 * @since        Version 1.0
 */
class CV_Partner_Group extends CV_Shortcode {

   /**
    * Function to create shortcode configuration
    *
    * @return void
    */
   public function __construct() {

      $this->config = array(

         // Handle will be used to use this shortcode
         'handle' => 'cv_partner_group',

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
         'title' => __( 'Logo/Partner Group', 'canvys' ),

         // Icon will be used to represent this shortcode in composer/builder
         // List of available icons can be found in icons.json
         'icon' => 'water',

         // Whether or not shortcode is self closing
         'self_closing' => false,

         // If shortcode is not self closing, specify its default content
         'default_content' => '[cv_partner url="http://www.google.com/"][cv_partner url="http://www.wikipedia.com/"]',

         // Specify whether or not content is directly editable
         'content_editor' => false,

         // Specify whether or not the content is composed of another shortcode
         'content_element' => 'cv_partner',

         // Array of shortcode settings and their respective attributes
         'attributes' => array(

            new CV_Shortcode_Select_Control( 'style', array(
               'title'         => __( 'Style', 'canvys' ),
               'description'   => __( 'Specify how this partner group should be displayed.', 'canvys' ),
               'default'       => 'grid',
               'options'       => array(
                  'grid'    => __( 'Grid', 'canvys' ),
                  'slider'  => __( 'Carousel', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Carousel_Control( 'carousel_config', array(
               'title'         => __( 'Carousel Config', 'canvys' ),
               'description'   => __( 'Customize how the carousel element should behave.', 'canvys' ),
            ) ),

            new CV_Shortcode_Select_Control( 'columns', array(
               'title'       => __( 'Number of Columns', 'canvys' ),
               'description' => __( 'Specify how many columns should be used to display the logos.', 'canvys' ),
               'default'     => '3',
               'options'     => array(
                  '2' => __( '2 Columns', 'canvys' ),
                  '3' => __( '3 Columns', 'canvys' ),
                  '4' => __( '4 Columns', 'canvys' ),
                  '5' => __( '5 Columns', 'canvys' ),
                  '6' => __( '6 Columns', 'canvys' ),
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

      <script id="cv-builder-cv_partner_group-script">
         (function($){
            "use strict";
            $(document).on( 'cv-composer-load-cv_partner_group', function() {
               var $modal = $('#cv-composer-absolute-container').children().last();
               $modal.find('.control-style select').on( 'change', function() {
                  var $this = $(this), val = $this.val(),
                      $gridControls = $modal.find('.control-columns'),
                      $carouselControls = $modal.find('.control-carousel_config');
                  if ( 'grid' === val ) {
                     $gridControls.fadeIn();
                     $carouselControls.hide();
                  }
                  else {
                     $gridControls.hide();
                     $carouselControls.fadeIn();
                  }
               }).trigger('change');
            });
         })(jQuery);
      </script>

   <?php }

   /**
    * Callback function for display of preview in builder module
    *
    * @param array  $atts      Array of provided attributes
    * @param string $content   Content of shortcode
    * @return string
    */
   public function builder_module_preview( $atts, $content = null ) {
      return null;
   }

   /**
    * Callback function for front end display of shortcode
    *
    * @param array  $atts      Array of provided attributes
    * @param string $content   Content of shortcode
    * @return string
    */
   public function callback( $atts, $content = null ) {

      global $cv_partners;

      // Start with an empty array
      $cv_partners = array();

      // Fill the toggles array
      do_shortcode( $content );

      // Create sanitized array of partners
      $partners = array();
      foreach ( $cv_partners as $partner_config ) {
         if ( ! $partner_config['logo_id'] ) {
            continue;
         }
         $partners[] = $partner_config;
      }

      // Make sure there is atleast 1 toggle
      if ( empty( $partners ) ) {
         return;
      }

      // Create attributes array by sanitizing provided values
      extract( $this->get_sanitized_attributes( $atts ) );

      // Create the box
      $o = new CV_HTML( '<div>', array(
         'class' => 'cv-partner-group has-clearfix',
      ) );

      if ( 'slider' == $style ) {
         $o->add_class( 'is-slider is-carousel' );
         $o = cv_apply_carousel_config_attributes( $o, $carousel_config );
      }

      else {
         $o->add_class( 'is-grid cv-grid-' . $columns );
         $o->add_class( 'masonry-layout not-responsive' );
      }

      // Add the partners
      $counter = 0;
      foreach ( $partners as $partner_config ) {

         $counter++;

         $img_info = wp_get_attachment_image_src( $partner_config['logo_id'], 'full' );

         $tag = $partner_config['url'] ? '<a>' : '<span>';

         // create the partner element
         $partner = new CV_HTML( $tag, array(
            'class' => 'partner',
         ) );

         // Apply the HREF attribute
         if ( $url = cv_get_shortcode_link_control_url( $partner_config['url'] ) ) { $partner->attr( 'href', $url ); }
         if ( cv_get_shortcode_link_control_target( $partner_config['url'] ) ) { $partner->attr( 'target', '_blank' ); }

         // Add the image
         $partner->append( '<img src="' . $img_info[0] . '" alt="'.cv_get_attachment_alt($partner_config['logo_id']).'" />' );

         // Add the tooltip
         if ( $partner_config['tooltip'] ) {
            $partner->add_class( 'tooltip' );
            $partner->attr( 'title', $partner_config['tooltip'] );
         }

         // Wrap the partner element
         $partner = '<div><p>' . $partner . '</p></div>';

         // Add the partner to the output
         $o->append( $partner );

      }

      return $o->render();

   }

}
endif;