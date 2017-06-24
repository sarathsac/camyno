<?php

if ( ! class_exists('CV_Image') ) :

/**
 * Customizable Images
 *
 * @package      WordPress
 * @subpackage   Canvys
 * @since        Version 1.0
 */
class CV_Image extends CV_Shortcode {

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
         'handle' => 'cv_image',

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
         'title' => __( 'Image', 'canvys' ),

         // Icon will be used to represent this shortcode in composer/builder
         // List of available icons can be found in icons.json
         'icon' => 'picture-1',

         // Whether or not shortcode is self closing
         'self_closing' => true,

         // If shortcode is not self closing, specify its default content
         'default_content' => null,

         // Specify whether or not content is directly editable
         'content_editor' => false,

         // Specify whether or not the content is composed of another shortcode
         'content_element' => false,

         // Provide an explanation of what this shortcode does
         'explanation' => __( 'This module allows you to add styled images to the page, if you are displaying multiple images adjacent to one another it is recomended that you use the gallery module.', 'canvys' ),

         // Array of shortcode settings and their respective attributes
         'attributes' => array(

            new CV_Shortcode_Image_Control( 'id', array(
               'title'       => __( 'Image', 'canvys' ),
               'description' => __( 'Select the image to be displayed.', 'canvys' ),
            ) ),

            new CV_Shortcode_Select_Image_Size_Control( 'size', array(
               'default'     => 'full',
            ) ),

            new CV_Shortcode_Number_Control( 'width', array(
               'title'       => __( 'Custom Width', 'canvys' ),
               'description' => __( 'Specify a custom maximum width for this image. Enter a numeric value only in pixels.', 'canvys' ),
            ) ),

            new CV_Shortcode_Select_Control( 'align', array(
               'title'       => __( 'Alignment', 'canvys' ),
               'description' => __( 'Select how the image should be aligned.', 'canvys' ),
               'default'     => 'none',
               'options'     => array(
                  'none'   => __( 'No alignment', 'canvys' ),
                  'left'   => __( 'Left', 'canvys' ),
                  'right'  => __( 'Right', 'canvys' ),
                  'center' => __( 'Center', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Link_Control( 'link', array(
               'title'       => __( 'Link', 'canvys' ),
               'description' => __( 'Specify if this image should be linked to anything. <strong>To allow the image to be opened in a lightbox window select custom and enter lightbox into the custom URL field.</strong>', 'canvys' ),
            ) ),

            new CV_Shortcode_Select_Control( 'style', array(
               'title'       => __( 'Applied Styles', 'canvys' ),
               'description' => __( 'Select how the image should be styled.', 'canvys' ),
               'default'     => 'none',
               'options'     => array(
                  'none'     => __( 'No special styling', 'canvys' ),
                  'rounded'  => __( 'Rounded corners', 'canvys' ),
                  'circular' => __( 'Circular (image must have square proportions)', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Select_Control( 'entrance', array(
               'title'       => __( 'Animated Entrance', 'canvys' ),
               'description' => __( 'Specify an aminated entrance for this image to come into view.', 'canvys' ),
               'default'     => 'none',
               'options'     => $animation_options,
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

      // Create attributes array by sanitizing provided values
      extract( $this->get_sanitized_attributes( $atts ) );

      if ( $id && $img_info = wp_get_attachment_image_src( $id, 'thumbnail' ) ) {
         return '<img src="' . $img_info[0] . '" alt="' . cv_get_attachment_alt( $id ) . '" />';
      }

   }

   /**
    * Renders inline CSS required by the template builder
    *
    * @return mixed
    */
   public function builder_additional_styles() { ?>

      <style id="cv-builder-cv_image-module">
         .cv-module-cv_image .cv-module-preview {
            text-align: center;
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

      // Make sure an image has been specified
      if ( ! $img_info = wp_get_attachment_image_src( $id, $size ) ) return;

      // Create the image HTML
      $image = new CV_HTML( '<img />', array(
         'class' => 'cv-user-image',
         'src' => $img_info[0],
         'alt' => cv_get_attachment_alt( $id ),
      ) );

      if ( $width ) {
         $image->css( 'max-width', $width.'px' );
      }

      // Render the image
      $o = $image;

      // Apply the styling
      switch ( $style ) {
         case 'rounded':
            $o->css( array(
               '-webkit-border-radius' => '3px',
               'border-radius' => '3px',
            ) );
            break;
         case 'circular':
            $o->css( array(
               '-webkit-border-radius' => '100%',
               'border-radius' => '100%',
            ) );
            break;
      }

      // Apply the image link
      if ( $link ) {
         if ( 'lightbox' == $link ) {
            if ( 'cv_full' == $size ) {
               $url = $img_info[0];
            }
            else {
               $full_img_info = wp_get_attachment_image_src( $id, 'cv_full' );
               $url = $full_img_info[0];
            }
         }
         else {
            $url = cv_get_shortcode_link_control_url( $link );
         }
         $anchor = new CV_HTML( '<a>', array(
            'class' => 'cv-user-image-link',
            'href' => $url,
            'content' => $o,
         ) );
         if ( cv_get_shortcode_link_control_target( $link ) ) { $anchor->attr( 'target', '_blank' ); }
         $o = $anchor;
      }

      // Apply the wrapper
      $o = '<div class="cv-user-image-wrap align-image-'.$align.'">'.$o.'</div>';

      // Create animated entrance attribute
      $entrance_data = 'none' !== $entrance ? ' data-entrance="' . $entrance . '"' : null;
      return $entrance_data ? '<div' . $entrance_data . '>' . $o . '</div>' : $o;

   }

}
endif;