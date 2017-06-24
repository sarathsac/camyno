<?php

if ( ! class_exists('CV_Instructions') ) :

/**
 * Ordered Instructions
 *
 * @package      WordPress
 * @subpackage   Canvys
 * @since        Version 1.0
 */
class CV_Instructions extends CV_Shortcode {

   /**
    * Function to create shortcode configuration
    *
    * @return void
    */
   public function __construct() {

      global $canvys;

      $this->config = array(

         // Handle will be used to use this shortcode
         'handle' => 'cv_instructions',

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
         'title' => __( 'Ordered Steps', 'canvys' ),

         // Icon will be used to represent this shortcode in composer/builder
         // List of available icons can be found in icons.json
         'icon' => 'share',

         // Whether or not shortcode is self closing
         'self_closing' => false,

         // If shortcode is not self closing, specify its default content
         'default_content' => '[cv_instructions_step title="' . __( 'Step 1 Title', 'canvys' ) . '"][/cv_instructions_step]'
                            . '[cv_instructions_step title="' . __( 'Step 2 Title', 'canvys' ) . '"][/cv_instructions_step]',

         // Specify whether or not content is directly editable
         'content_editor' => false,

         // Specify whether or not the content is composed of another shortcode
         'content_element' => 'cv_instructions_step',

         // Provide an explanation of what this shortcode does
         'explanation' => __( 'Use this shortcode to communicate any form of ordered information, this could be ordered instructions, the steps in a process, or your websites progress towards accomplishing a goal.', 'canvys' ),

         // Array of shortcode settings and their respective attributes
         'attributes' => array(

            new CV_Shortcode_Select_Control( 'icon_location', array(
               'title'         => __( 'Icon Location', 'canvys' ),
               'description'   => __( 'Specify where the icons for each step should be placed.', 'canvys' ),
               'type'          => 'select',
               'default'       => 'left',
               'options'       => array(
                  'left'  => __( 'left of the step', 'canvys' ),
                  'right' => __( 'Right of the step', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Select_Control( 'entrance', array(
               'title'       => __( 'Animated Entrance', 'canvys' ),
               'description' => __( 'Specify if this icon list should come into view using a subtle animated entrance', 'canvys' ),
               'default'     => 'true',
               'options'       => array(
                  'true'  => __( 'yes, use a subtle animation', 'canvys' ),
                  'false' => __( 'No, do not use a subtle animation', 'canvys' ),
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
           $section_tag . " .cv-ordered-instructions .step-wrap .step-icon {"
         . "border: 1px solid {$colors['borders']};"
         . "color: {$colors['content']};"
         . "}"
         . $section_tag . " .cv-ordered-instructions .step-wrap:hover .step-icon {"
         . "border: 1px solid {$colors['accent']};"
         . "color: {$colors['accent']};"
         . "}"
         . $section_tag . " .cv-ordered-instructions .step-wrap:after {"
         . "background-color: {$colors['borders']};"
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

      global $cv_steps;

      // Start with an empty array
      $cv_steps = array();

      // Fill the toggles array
      do_shortcode( $content );

      // Make sure there is atleast 1 toggle
      if ( empty( $cv_steps ) ) {
         return;
      }

      // Create attributes array by sanitizing provided values
      extract( $this->get_sanitized_attributes( $atts ) );

      // Toggle group wrapper
      $o = new CV_HTML( '<div>', array(
         'class' => 'cv-ordered-instructions'
      ) );

      // Apply the alignment class
      $o->add_class( 'align-' . $icon_location );

      // Apply the entrance trigger class
      if ( cv_make_bool( $entrance ) ) $o->data( 'trigger-entrances', 'true' );

      // Add the steps
      $delay_timer = 0;
      $counter = 0;
      foreach ( $cv_steps as $step_config ) {

         $counter++;

         // Create animated entrance attribute
         $entrance_data = null;
         if ( cv_make_bool( $entrance ) ) {
            $entrance_data  = ' data-entrance="zoomIn"';
            if ( $delay_timer ) {
               $entrance_data .= ' data-delay="' . $delay_timer . '"';
            }
            $entrance_data .= ' data-chained="true"';
            $delay_timer += 100;
         }

         // Step container
         $step = new CV_HTML( '<div>', array(
            'class' => 'step',
         ) );

         // Create the icon
         $number = $step_config['icon_number'] ? $step_config['icon_number'] : $counter;
         $icon = 'icon' == $step_config['icon_source'] ? '<i class="icon-' . $step_config['icon'] . '"></i>' : '<span class="numeric">' . $number . '</span>';

         // Add the icon
         $step->append( '<p class="step-icon"' . $entrance_data . '>' . $icon . '</p>' );

         // Add the title & content
         $title = '<h3 class="step-title">' . $step_config['title'] . '</h3>';
         $content = '<div class="step-content">' . $step_config['content'] . '</div>';
         $step->append( '<div class="step-info">' .$title . $content . '</div>' );

         // Add the step
         $o->append( '<div class="step-wrap has-clearfix">' . $step . '</div>' );

      }

      return $o->render();

   }

}
endif;