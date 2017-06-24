<?php

if ( ! class_exists('CV_Gallery') ) :

/**
 * Galleries
 *
 * @package      WordPress
 * @subpackage   Canvys
 * @since        Version 1.0
 */
class CV_Gallery extends CV_Shortcode {

   /**
    * Function to create shortcode configuration
    *
    * @return void
    */
   public function __construct() {

      global $canvys;

      $animation_options = array(
         'none' => __( 'None', 'canvys' ),
      );

      $animation_options = array_merge( $animation_options, $canvys['animations'] );

      $this->config = array(

         // Handle will be used to use this shortcode
         'handle' => 'cv_gallery',

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
         'title' => __( 'Gallery', 'canvys' ),

         // Icon will be used to represent this shortcode in composer/builder
         // List of available icons can be found in icons.json
         'icon' => 'picture',

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

            new CV_Shortcode_gallery_Control( 'ids', array(
               'title'       => __( 'Images', 'canvys' ),
               'description' => __( 'Select which images should be displayed.', 'canvys' ),
            ) ),

            new CV_Shortcode_Select_Control( 'style', array(
               'title'         => __( 'Style', 'canvys' ),
               'description'   => __( 'Specify how this gallery should be displayed.', 'canvys' ),
               'default'       => 'grid',
               'options'       => array(
                  'grid'    => __( 'Perfect grid', 'canvys' ),
                  'masonry' => __( 'Masonry', 'canvys' ),
                  'slider'  => __( 'Slider', 'canvys' ),
                  'carousel'  => __( 'Carousel', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Slider_Control( 'slider_config', array(
               'title'       => __( 'Slider Configuration', 'canvys' ),
               'description' => __( 'Specify how this slider should behave.', 'canvys' ),
            ) ),

            new CV_Shortcode_Carousel_Control( 'carousel_config', array(
               'title'       => __( 'Carousel Configuration', 'canvys' ),
               'description' => __( 'Specify how this carousel should behave.', 'canvys' ),
            ) ),

            new CV_Shortcode_Select_Control( 'columns', array(
               'title'       => __( 'Number of Columns', 'canvys' ),
               'description' => __( 'Specify how many columns should be used to display this gallery.', 'canvys' ),
               'default'     => '3',
               'options'     => array(
                  '2' => __( '2 Columns', 'canvys' ),
                  '3' => __( '3 Columns', 'canvys' ),
                  '4' => __( '4 Columns', 'canvys' ),
                  '5' => __( '5 Columns', 'canvys' ),
                  '6' => __( '6 Columns', 'canvys' ),
                  '7' => __( '7 Columns', 'canvys' ),
                  '8' => __( '8 Columns', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Select_Control( 'spacing', array(
               'title'         => __( 'Spacing', 'canvys' ),
               'description'   => __( 'Specify the amount of spacing that should be used to separate the columns', 'canvys' ),
               'default'       => 'normal',
               'options'       => array(
                  'none' => __( 'None', 'canvys' ),
                  '1'    => __( 'Less', 'canvys' ),
                  '2'    => __( 'Normal', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Select_Control( 'responsive', array(
               'title'         => __( 'Responsive', 'canvys' ),
               'description'   => __( 'Specify whether or not the layout of this gallery should be responsive, only applicable if responsiveness for the theme has not been enabled.', 'canvys' ),
               'default'       => 'true',
               'options'       => array(
                  'true'  => __( 'Yes, gallery should be responsive', 'canvys' ),
                  'false' => __( 'No, gallery columns should remain fixed', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Select_Control( 'links', array(
               'title'         => __( 'Image Links', 'canvys' ),
               'description'   => __( 'Specify how the images should be linked.', 'canvys' ),
               'default'       => 'lightbox',
               'options'       => array(
                  'lightbox' => __( 'Open image in a lightbox', 'canvys' ),
                  'true' => __( 'Open image in current tab', 'canvys' ),
                  'window' => __( 'Open image in new tab/window', 'canvys' ),
                  'none' => __( 'Do not add any link to the images', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Select_Control( 'ratio', array(
               'title'       => __( 'Image Proportions (Width X Height)', 'canvys' ),
               'description' => __( 'Specify the ratio that should be used to dictate the size of each image.', 'canvys' ),
               'default'     => '1x1',
               'options'     => array(
                  '6x2'  => __( '6 X 2', 'canvys' ),
                  '5x2'  => __( '5 X 2', 'canvys' ),
                  '4x2'  => __( '4 X 2', 'canvys' ),
                  '3x2'  => __( '3 X 2', 'canvys' ),
                  '1x1'  => __( '1 X 1', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Select_Image_Size_Control( 'img_size', array(
               'default'     => 'full',
            ) ),

            new CV_Shortcode_Select_Control( 'entrance', array(
               'title'       => __( 'Animated Entrance', 'canvys' ),
               'description' => __( 'Specify an aminated entrance for the gallery images to come into view, animations will occur consecutively.', 'canvys' ),
               'default'     => 'none',
               'options'     => $animation_options,
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

      <script id="cv-builder-cv_gallery-script">
         (function($){
            "use strict";
            $(document).on( 'cv-composer-load-cv_gallery', function() {
               var $modal = $('#cv-composer-absolute-container').children().last();
               $modal.find('.control-style select').on( 'change', function() {
                  var $this = $(this), val = $this.val(), allControls = {};
                  allControls.slider = $modal.find('.control-slider_config, .control-ratio, .control-img_size, .control-entrance');
                  allControls.carousel = $modal.find('.control-carousel_config, .control-ratio, .control-img_size');
                  allControls.grid = $modal.find('.control-columns, .control-spacing, .control-responsive, .control-ratio, .control-img_size, .control-entrance');
                  allControls.masonry = $modal.find('.control-columns, .control-spacing, .control-responsive, .control-entrance');
                  _.each( ['slider', 'carousel', 'grid', 'masonry'], function( style ) { allControls[style].hide(); });
                  allControls[val].fadeIn();
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
      extract( $this->get_sanitized_attributes( $atts ) );
      $o = null;
      if ( $ids ) {
         $o .= '<ul class="cloud-list has-clearfix spacing-1">';
         foreach ( explode( ',', $ids ) as $id ) {
            $img_data = wp_get_attachment_image_src( $id, 'thumbnail' );
            $o .= '<li><img height="40" width="40" style="display:block;height:40px;width:40px;" src="' .$img_data[0] . '" alt="' . cv_get_attachment_alt( $id ) . '" /></li>';
         }
         $o .= '</ul>';
      }
      return $o;
   }

   /**
    * Callback function for front end display of shortcode
    *
    * @param array  $atts      Array of provided attributes
    * @param string $content   Content of shortcode
    * @return string
    */
   public function callback( $atts, $content = null ) {

      static $instance;

      $instance++;

      // Create attributes array by sanitizing provided values
      extract( $this->get_sanitized_attributes( $atts ) );

      // Create the box
      $o = new CV_HTML( '<div>', array(
         'class' => 'cv-gallery',
      ) );

      // Enable lightbox
      if ( 'lightbox' == $links ) $o->add_class( 'cv-lightbox-gallery' );

      // Apply te style class
      $o->add_class( 'is-' . $style );

      switch ( $style ) {

         case 'slider':
            $o->add_class( 'is-gallery' );
            $o = cv_apply_slider_config_attributes( $o, $slider_config );
            break;

         case 'carousel':
            $o->add_class( 'is-carousel' );
            $o = cv_apply_carousel_config_attributes( $o, $carousel_config );
            break;

         case 'grid':
            $o->add_class( 'cv-grid-' . $columns );
            $o->add_class( 'has-clearfix' );
            if ( 'none' != $spacing ) $o->add_class( 'spacing-' . $spacing );
            if ( ! cv_make_bool( $responsive ) ) $o->add_class( 'not-responsive' );
            if ( 'none' != $entrance ) $o->data( 'trigger-entrances', 'true' );
            break;

         case 'masonry':
            $o->add_class( 'cv-grid-' . $columns );
            $o->add_class( 'has-clearfix' );
            if ( 'none' != $spacing ) $o->add_class( 'spacing-' . $spacing );
            if ( ! cv_make_bool( $responsive ) ) $o->add_class( 'not-responsive' );
            if ( 'none' != $entrance ) $o->data( 'trigger-entrances', 'true' );
            $o->add_class( 'masonry-layout' );
            $img_size = 'cv_square_tall';
            break;

      }

      $delay_timer = 0;
      foreach ( explode( ',', $ids ) as $id ) {

         $image = null;

         // Create animated entrance attribute
         $entrance_data = null;
         if ( 'none' !== $entrance ) {
            $entrance_data  = ' data-entrance="' . $entrance . '"';
            if ( $delay_timer ) {
               $entrance_data .= ' data-delay="' . $delay_timer . '"';
            }
            $entrance_data .= ' data-chained="true"';
            $delay_timer += 100;
         }

         // Grab the image info
         $img_data = wp_get_attachment_image_src( $id, $img_size );

         switch ( $style ) {

            case 'slider':
            case 'carousel':
               $image  = '<div class="cv-scalable-' . $ratio . '">';
               $image .= '<div class="scalable-content bg-style-cover" style="background-image:url(' . $img_data[0] . ')"></div>';
               $image .= '</div>';
               break;

            case 'grid':
               $image  = '<div class="cv-scalable-' . $ratio . '"' . $entrance_data . '>';
               $image .= '<div class="scalable-content bg-style-cover" style="background-image:url(' . $img_data[0] . ')"></div>';
               $image .= '</div>';
               break;

            case 'masonry':
               $image = '<img style="display:block;" src="' . $img_data[0] . '"' . $entrance_data . ' alt="'.cv_get_attachment_alt( $id ).'" />';
               break;

         }

         // Add the link
         $anchor = null;
         if ( 'none' != $links ) {

            // Full size image info
            $img_data = wp_get_attachment_image_src( $id, 'full' );

            // Create the link
            $anchor = new CV_HTML( '<a>', array(
               'href' => $img_data[0],
            ) );

            // Enable lightbox
            if ( 'lightbox' == $links ) $anchor->add_class( 'cv-lightbox-gallery-item' );

            // Open in new window
            if ( 'window' == $links ) $anchor->attr( 'target', '_blank' );

         }

         $o->append( '<div><div class="image-container">' . $image . $anchor . '</div></div>' );

      }

      // Render the output
      $o = $o->render();

      if ( 'none' !== $entrance && 'slider' == $style ) {
         $o = '<div data-entrance="' . $entrance . '">' . $o . '</div>';
      }

      return $o;

   }

}
endif;