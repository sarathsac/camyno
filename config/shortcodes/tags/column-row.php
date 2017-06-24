<?php

if ( ! class_exists('CV_Column_Row') ) :

/**
 * Column Row
 * Class that handles the creation and configuration
 * of the column row shortcode
 *
 * @package      WordPress
 * @subpackage   Canvys
 * @since        Version 1.0
 */
class CV_Column_Row extends CV_Shortcode {

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
         'handle' => 'cv_column_row',

         // Whether or not this is a shortcode composer element
         'composer_element' => true,

         // Whether or not this is a template builder element
         'builder_element' => true,

         // Used by the template builder to determine where module can be dropped
         'drop_target' => 1,

         // Used by the template builder to determine where module can have other
         // modules dropped inside of it
         'drop_zone' => 2,

         // Title will be used to identify this shortcode
         'title' => __( 'Column Row', 'canvys' ),

         // Icon will be used to represent this shortcode in composer/builder
         // List of available icons can be found in icons.json
         'icon' => 'columns',

         // Whether or not shortcode is self closing
         'self_closing' => false,

         // If shortcode is not self closing, specify its default content
         'default_content' => '[cv_column][/cv_column]'
                            . '[cv_column][/cv_column]',

         // Specify whether or not content is directly editable
         'content_editor' => false,

         // Specify whether or not the content is composed of another shortcode
         'content_element' => false,

         // Provide an explanation of what this shortcode does
         'explanation' => __( 'Column rows allow you to control the horizontal layout of your website. The columns used by this theme are percentage based instead of grid based, which allows for a  more fluid and optimized experience for your website\'s visitors.', 'canvys' ),

         // Array of shortcode settings and their respective attributes
         'attributes' => array(

            new CV_Shortcode_Select_Control( 'spacing', array(
               'title'       => __( 'Horizontal Spacing', 'canvys' ),
               'description' => __( 'Specify the amount of horizontal space between each column', 'canvys' ),
               'default'     => 'normal',
               'options'     => array(
                  'none'      => __( 'None', 'canvys' ),
                  'less'      => __( 'Less', 'canvys' ),
                  'normal'    => __( 'Normal', 'canvys' ),
                  'more'      => __( 'More', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Select_Control( 'v_align', array(
               'title'       => __( 'Vertical Align', 'canvys' ),
               'description' => __( 'Specify whether or not the content of the columns should be automatically vertically aligned.', 'canvys' ),
               'default'     => 'false',
               'options'     => array(
                  'false' => __( 'No, do not vertically align columns.', 'canvys' ),
                  'true'  => __( 'Yes, vertically align columns.', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Select_Control( 'styling', array(
               'title'       => __( 'Special Styling', 'canvys' ),
               'description' => __( 'Specify whether or not the content of the columns should be automatically vertically aligned.', 'canvys' ),
               'default'     => 'none',
               'options'     => array(
                  'none'     => __( 'No special styling', 'canvys' ),
                  'dividers' => __( 'Display vertical dividers between columns', 'canvys' ),
                  'boxed'    => __( 'Wrap each column in a separate box', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Select_Control( 'entrance', array(
               'title'       => __( 'Animated Entrance', 'canvys' ),
               'description' => __( 'Specify an aminated entrance for the columns to come into view, animations will occur consecutively.', 'canvys' ),
               'default'     => 'none',
               'options'     => $animation_options,
            ) ),

            new CV_Shortcode_Layout_Control( 'layout', array(
               'title'       => __( 'Layout', 'canvys' ),
               'description' => __( 'Use this control to specify the layout for this column row.', 'canvys' ),
               'default'     => '1/2',
               'options'     => $canvys['column_layouts'],
            ) ),

            new CV_Shortcode_Select_Control( 'visibility', array(
               'title'       => __( 'Visibility', 'canvys' ),
               'description' => __( 'Which devices this column row should be visible on. This is great for optimizing your website for all devices.', 'canvys' ),
               'default'     => 'all',
               'options'     => $canvys['visibility_options'],
            ) ),

         ),
      );
   }

   /**
    * Callback function for display of shortcode within the builder
    *
    * @param array  $atts      Array of provided attributes
    * @param string $content   Content of shortcode
    * @return string
    */
   public function builder_module_callback( $atts, $content = null ) {

      global $cv_columns;

      $cv_columns = array();

      do_shortcode( $content );

      if ( ! is_array( $cv_columns ) ) {
         return;
      }

      // Create attributes array by sanitizing provided values
      extract( $this->get_sanitized_attributes( $atts ) );

      // Make layout into a usable value
      $layout = str_replace( array('/', '+'), array('', '-'), $layout );

      // Determine number of columns
      switch ( $layout ) {
         case '12': $num_columns = 2; $layout = '2'; break;
         case '13': $num_columns = 3; $layout = '3'; break;
         case '14': $num_columns = 4; $layout = '4'; break;
         case '15': $num_columns = 5; $layout = '5'; break;
         case '16': $num_columns = 6; $layout = '6'; break;
         default: $num_columns = count( explode( '-', $layout ) ); break;
      }

      // Set up variables
      $handle = $this->config['handle'];
      $drop_zone = $this->config['drop_zone'];

      // Create the module
      $module = $this->builder_module_container();

      // Display module controls
      $o = $this->builder_module_controls();

      // Module content
      $o .= '<div class="cv-module-content">';
      $o .= '<textarea class="cv-builder-piece">[' . $handle . ' ' . $this->get_rendered_attributes( $atts ) . ']</textarea>';

      $o .= '<div class="cv-split-' . $layout . ' spacing-1 has-clearfix">';

      for ( $i=0; $i<$num_columns; $i++ ) {
         $column = isset( $cv_columns[$i] ) ? $cv_columns[$i] : null;
         $o .= '<div>';
         $o .= '<textarea class="cv-builder-piece">[cv_column]</textarea>';
         $o .= '<div class="cv-dropzone has-clearfix" data-dropzone="2">' . do_shortcode( $column ) . '</div>';
         $o .= '<a class="cv-add-module" data-droptarget="' . $drop_zone . '">';
         $o .= '<i class="icon-plus-squared"></i><span>' . __( 'Add Module', 'canvys' ) . '</span>';
         $o .= '</a>';
         $o .= '<textarea class="cv-builder-piece">[/cv_column]</textarea>';
         $o .= '</div>';

      }

      $o .= '</div>';

      $o .= '<textarea class="cv-builder-piece">[/' . $handle . ']</textarea>';

      $o .= '</div>';

      // Render & return the module
      return $module->render($o);

   }

   /**
    * Callback function for rendering a complete callable shortcode tag
    *
    * @param array  $atts       Array of provided attributes
    * @param string $content    Content of shortcode
    * @param bool   $formatting Whether or not returned shortcode should be formtted
    * @return string
    */
   public function get_rendered_shortcode( $atts, $content = null ) {

      // Make layout into a usable value
      $layout = str_replace( array('/', '+'), array('', '-'), $atts['layout'] );

      // Determine number of columns
      switch ( $layout ) {
         case '12': $num_columns = 2; break;
         case '13': $num_columns = 3; break;
         case '14': $num_columns = 4; break;
         case '15': $num_columns = 5; break;
         case '16': $num_columns = 6; break;
         default: $num_columns = count( explode( '-', $layout ) ); break;
      }

      // Get rendered list of attributes, if shortcode has attributes
      $attributes = $this->config['attributes'] ? ' ' . $this->get_rendered_attributes( $atts ) : null;

      // Open initial shortcode tag
      $shortcode = '[' . $this->config['handle'] . $attributes . ']';

      // Add the columns
      for ( $i=0; $i<$num_columns; $i++ ) {
         $shortcode .= '[cv_column][/cv_column]';
      }

      // Close the shortcode
      $shortcode .= '[/' . $this->config['handle'] . ']';

      return $shortcode;

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

         // Vertical dividers
         echo
           $section_tag . " .v-dividers > *:after {"
         . "   background: {$colors['borders']};"
         . "}"
         . $section_tag . " .cv-column-row.is-boxed > div > .column-inner {"
         . "   background: {$colors['secondary_bg']};"
         . "   color: {$colors['secondary_content']};"
         . "   border: 1px solid {$colors['borders']};"
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

      global $cv_columns;

      $cv_columns = array();

      do_shortcode( $content );

      // Make sure there are columns to show
      if ( empty( $cv_columns ) ) {
         return;
      }

      // Extract sanitized attributes
      extract( $this->get_sanitized_attributes( $atts ) );

      // Make layout into a usable value
      $layout = str_replace( array('/', '+'), array('', '-'), $layout );

      // Determine number of columns
      switch ( $layout ) {
         case '12': $num_columns = 2; $layout = '2'; break;
         case '13': $num_columns = 3; $layout = '3'; break;
         case '14': $num_columns = 4; $layout = '4'; break;
         case '15': $num_columns = 5; $layout = '5'; break;
         case '16': $num_columns = 6; $layout = '6'; break;
         default: $num_columns = count( explode( '-', $layout ) );
      }

      // Determine spacing amount
      switch ( $spacing ) {
         case 'none': $spacing = '0'; break;
         case 'less': $spacing = '1'; break;
         case 'more': $spacing = '4'; break;
         default: $spacing = '2';
      }

      // The row container
      $o = new CV_HTML( '<div>', array(
         'class' => 'cv-column-row has-clearfix',
      ) );

      // Apply the layout class
      $o->add_class( 'cv-split-' . $layout );

      // Apply the spacing class
      $o->add_class( 'spacing-' . $spacing );

      // Apply the v-align class if applicable
      if ( cv_make_bool( $v_align ) ) $o->add_class( 'v-align-columns' );

      // Apply the vertical borders class
      if ( 'dividers' == $styling ) $o->add_class( 'v-dividers' );

      // Apply the boxed class
      if ( 'boxed' == $styling ) $o->add_class( 'is-boxed' );

      // Insert the columns w/ content
      $delay_timer = 0;
      for ( $i=0; $i<$num_columns; $i++ ) {

         // Grab the appropriatecontent
         $content = isset( $cv_columns[$i] ) ? $cv_columns[$i] : null;

         // Create animated entrance attribute
         $entrance_data = null;
         if ( 'none' !== $entrance ) {
            $entrance_data  = ' data-entrance="' . $entrance . '"';
            if ( $delay_timer ) {
               $entrance_data .= ' data-delay="' . $delay_timer . '"';
            }
            $delay_timer += 250;
         }

         // Add the column
         $content =  "\n\n" . do_shortcode( $content ) . "\n\n";
         $o->append( '<div' . $entrance_data . '><div class="column-inner">' . $content . '</div></div>' . "\n\n" );

      }

      // Render the output
      $o = $o->render();

      // Apply the alignment wrapper
      if ( cv_make_bool( $v_align ) ) {
         $o = '<div class="v-align-columns-wrapper spacing-' . $spacing . '">' . $o . '</div>';
      }

      // Apply visibility wrapper
      if ( 'all' !== $visibility ) {
         $o = '<div data-visibility="' . $visibility . '">' . $o . '</div>';
      }

      return  $o;

   }

}
endif;