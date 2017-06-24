<?php

if ( ! class_exists('CV_Single_Column') ) :

/**
 * Single Column
 * Class that handles the creation and configuration
 * of the single column shortcode
 *
 * @package      WordPress
 * @subpackage   Canvys
 * @since        Version 1.0
 */
class CV_Single_Column extends CV_Shortcode {

   /**
    * Function to create shortcode configuration
    *
    * @return void
    */
   public function __construct() {

      global $canvys;

      $this->config = array(

         // Handle will be used to use this shortcode
         'handle' => 'cv_single_column',

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
         'title' => __( 'Single Column', 'canvys' ),

         // Icon will be used to represent this shortcode in composer/builder
         // List of available icons can be found in icons.json
         'icon' => 'doc',

         // Whether or not shortcode is self closing
         'self_closing' => false,

         // If shortcode is not self closing, specify its default content
         'default_content' => null,

         // Specify whether or not content is directly editable
         'content_editor' => false,

         // Specify whether or not the content is composed of another shortcode
         'content_element' => false,

         // Provide an explanation of what this shortcode does
         'explanation' => __( 'This shortcode will display a single column at the width you specify, this is useful for displaying content on top of a background image at different locations or simply to limit the size of certain content. This shortcode does not provide any added vertical spacing.', 'canvys' ),

         // Array of shortcode settings and their respective attributes
         'attributes' => array(

            new CV_Shortcode_Select_Control( 'max_width', array(
               'title'       => __( 'Maximum Width', 'canvys' ),
               'description' => __( 'The maximum width this column can achieve, actual width can not be set to allow for responsiveness.', 'canvys' ),
               'default'     => '50%',
               'options'     => array(
                  '25%' => '25%',
                  '50%' => '50%',
                  '75%' => '75%',
               ),
            ) ),

            new CV_Shortcode_Select_Control( 'align', array(
               'title'       => __( 'Column Align', 'canvys' ),
               'description' => __( 'How the column should be aligned.', 'canvys' ),
               'default'     => 'center',
               'options'     => array(
                  'left'   => __( 'left', 'canvys' ),
                  'center' => __( 'center', 'canvys' ),
                  'right'  => __( 'right', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Select_Control( 'visibility', array(
               'title'       => __( 'Visibility', 'canvys' ),
               'description' => __( 'Which devices this single column row should be visible on. This is great for optimizing your website for all devices.', 'canvys' ),
               'default'     => 'all',
               'options'     => $canvys['visibility_options'],
            ) ),

          ),

      );
   }

   /**
    * Renders inline CSS required by the template builder
    *
    * @return mixed
    */
   public function builder_additional_styles() { ?>

      <style id="cv-builder-cv_single_column-module">
         .cv-module-cv_single_column.max_width-25 > .cv-module-content { width: 25%; }
         .cv-module-cv_single_column.max_width-50 > .cv-module-content { width: 50%; }
         .cv-module-cv_single_column.max_width-75 > .cv-module-content { width: 75%; }
         .cv-module-cv_single_column.align-left > .cv-module-content   { float: left; }
         .cv-module-cv_single_column.align-center > .cv-module-content { margin: 0 auto !important; }
         .cv-module-cv_single_column.align-right > .cv-module-content  { float: right; }
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

      // Extract sanitized attributes
      extract( $this->get_sanitized_attributes( $atts ) );

      // The column container
      $o = new CV_HTML( '<div>', array(
         'class' => 'cv-single-column has-clearfix',
         'content' => '<div>' . do_shortcode( $content ) . '</div>'
      ) );

      // Add the width class
      $o->add_class( 'max-width-' . $max_width );

      // Add the alignment class
      $o->add_class( 'column-align-' . $align );

      // Apply the visibility class
      $o->data( 'visibility', $visibility );

      return $o->render();

   }

}
endif;