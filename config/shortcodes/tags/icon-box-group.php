<?php

if ( ! class_exists('CV_Icon_Box_Group') ) :

/**
 * Icon Boxe Groups
 *
 * @package      WordPress
 * @subpackage   Canvys
 * @since        Version 1.0
 */
class CV_Icon_Box_Group extends CV_Shortcode {

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
         'handle' => 'cv_icon_box_group',

         // Whether or not this is a shortcode composer element
         'composer_element' => true,

         // Whether or not this is a template builder element
         'builder_element' => true,

         // Used by the template builder to determine where module can be dropped
         'drop_target' => 1,

         // Used by the template builder to determine where module can have other
         // modules dropped inside of it
         'drop_zone' => false,

         // Title will be used to identify this shortcode
         'title' => __( 'Icon Box Group', 'canvys' ),

         // Icon will be used to represent this shortcode in composer/builder
         // List of available icons can be found in icons.json
         'icon' => 'info-circled',

         // Whether or not shortcode is self closing
         'self_closing' => false,

         // If shortcode is not self closing, specify its default content
         'default_content' => '[cv_icon_box_child title="' . __( 'Icon Box One', 'canvys' ) . '"][/cv_icon_box_child]'
                            . '[cv_icon_box_child title="' . __( 'Icon Box Two', 'canvys' ) . '"][/cv_icon_box_child]',

         // Specify whether or not content is directly editable
         'content_editor' => false,

         // Specify whether or not the content is composed of another shortcode
         'content_element' => 'cv_icon_box_child',

         // Provide an explanation of what this shortcode does
         'explanation' => __( 'This shortcode allows you to more efficiently display a group of icon boxes. This allows you to make changes to each icon box simultaneously as opposed to editing each one individually.', 'canvys' ),

         // Array of shortcode settings and their respective attributes
         'attributes' => array(

            new CV_Shortcode_Select_Control( 'style', array(
               'title'       => __( 'Style', 'canvys' ),
               'description' => __( 'Specify the style for these icon boxes', 'canvys' ),
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
               'description' => __( 'Specify how the icons should be styled', 'canvys' ),
               'default'     => 'standard',
               'options'     => array(
                  'standard' => __( 'Standard, no special styling', 'canvys' ),
                  'enscribed'  => __( 'Enscribed in a circle', 'canvys' ),
                  'enscribed-border'  => __( 'Enscribed in a circle with border', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Select_Control( 'boxed', array(
               'title'       => __( 'Boxed', 'canvys' ),
               'description' => __( 'Specify whether or not the icon boxes should be displayed inside of individual boxes.', 'canvys' ),
               'default'     => 'false',
               'options'     => array(
                  'false' => __( 'No, do not wrap each icon box', 'canvys' ),
                  'true'  => __( 'yes, wrap each icon box in a box', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Color_Control( 'default_icon_color', array(
               'title'       => __( 'Default Icon Color', 'canvys' ),
               'description' => __( 'Specify a custom color to be used as the default for each icon box, if none is specified the section\'s accent color will be used.', 'canvys' ),
            ) ),

            new CV_Shortcode_Select_Control( 'columns', array(
               'title'       => __( 'Number of Columns', 'canvys' ),
               'description' => __( 'Specify how many columns should be used to display these icon boxes.', 'canvys' ),
               'default'     => '3',
               'options'     => array(
                  '2' => __( '2 Columns', 'canvys' ),
                  '3' => __( '3 Columns', 'canvys' ),
                  '4' => __( '4 Columns', 'canvys' ),
                  '5' => __( '5 Columns', 'canvys' ),
                  '6' => __( '6 Columns', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Select_Control( 'entrance', array(
               'title'       => __( 'Animated Entrance', 'canvys' ),
               'description' => __( 'Specify an aminated entrance for the icon boxes to come into view, animations will occur consecutively.', 'canvys' ),
               'default'     => 'none',
               'options'     => $animation_options,
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
           $section_tag . " .cv-icon-box-group.is-boxed .inner-box {"
         . "   border: 1px solid {$colors['borders']};"
         . "   background: {$colors['secondary_bg']};"
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

      global $cv_icon_boxes, $canvys;

      // Start with an empty array
      $cv_icon_boxes = array();

      // Fill the toggles array
      do_shortcode( $content );

      // Make sure there is atleast 1 toggle
      if ( empty( $cv_icon_boxes ) ) {
         return;
      }

      // Create attributes array by sanitizing provided values
      extract( $this->get_sanitized_attributes( $atts ) );

      // Default config for each icon box
      $default_config = array(
         'style' => $style,
         'icon_style' => $icon_style,
         'icon_color' => $default_icon_color,
      );

      // Create the box
      $o = new CV_HTML( '<div>', array(
         'class' => 'cv-icon-box-group spacing-2 has-clearfix',
      ) );

      // Determine which layout to use
      $layout_class = $columns == count( $cv_icon_boxes ) ? 'split' : 'grid';

      // Apply the layout class
      $o->add_class( 'cv-' . $layout_class . '-' . $columns );

      if ( 'grid' == $layout_class ) {
         $o->add_class( 'masonry-layout' );
      }

      // Apply the entrance attribute
      if ( 'none' !== $entrance ) {
         $o->data( 'trigger-entrances', 'true' );
      }

      // Apply the boxed class
      if ( cv_make_bool( $boxed ) ) $o->add_class( 'is-boxed' );

      // Add the icon boxes
      $delay_timer = 0;
      foreach ( $cv_icon_boxes as $icon_box_config ) {

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

         // Set up the individual config
         $config = array_merge( $default_config, array(
            'title' => $icon_box_config['title'],
            'url' => $icon_box_config['url'],
            'icon' => $icon_box_config['icon'],
         ) );

         // Apply the custom color
         if ( $icon_box_config['icon_color'] ) {
            $config['icon_color'] = $icon_box_config['icon_color'];
         }

         // Create the icon box
         $icon_box = $canvys['shortcodes']['cv_icon_box']->callback( $config, $icon_box_config['content'] );

         // Add the icon box
         $o->append( '<div' . $entrance_data . '><div class="inner-box">' . $icon_box . '</div></div>' );

      }

      return $o->render();

   }

}
endif;