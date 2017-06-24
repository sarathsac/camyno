<?php

if ( ! class_exists('CV_Progress_Bars') ) :

/**
 * Progress bars
 *
 * @package      WordPress
 * @subpackage   Canvys
 * @since        Version 1.0
 */
class CV_Progress_Bars extends CV_Shortcode {

   /**
    * Function to create shortcode configuration
    *
    * @return void
    */
   public function __construct() {

      $this->config = array(

         // Handle will be used to use this shortcode
         'handle' => 'cv_progress_bars',

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
         'title' => __( 'Progress bars', 'canvys' ),

         // Icon will be used to represent this shortcode in composer/builder
         // List of available icons can be found in icons.json
         'icon' => 'tasks',

         // Whether or not shortcode is self closing
         'self_closing' => false,

         // If shortcode is not self closing, specify its default content
         'default_content' => '[cv_progress_task title="' . __( 'Task One', 'canvys' ) . '" progress="50%"]'
                            . '[cv_progress_task title="' . __( 'Task Two', 'canvys' ) . '" progress="50%"]',

         // Specify whether or not content is directly editable
         'content_editor' => false,

         // Specify whether or not the content is composed of another shortcode
         'content_element' => 'cv_progress_task',

         // Provide an explanation of what this shortcode does
         'explanation' => __( 'Progress bars allow you to visually demonstrate a group of tasks progress, they can also be used to demonstrate you or your companys level of proficiency at various tasks.', 'canvys' ),

         // Array of shortcode settings and their respective attributes
         'attributes' => array(

            new CV_Shortcode_Select_Control( 'animation', array(
               'title'         => __( 'Animated Entrance', 'canvys' ),
               'description'   => __( 'Specify whether or not the progress bars should come into view using an animated entrance.', 'canvys' ),
               'default'       => 'true',
               'options'       => array(
                  'true'  => __( 'Yes, use a subtle animation', 'canvys' ),
                  'false' => __( 'No, do not use any animation', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Select_Control( 'percentages', array(
               'title'         => __( 'Show Percentages', 'canvys' ),
               'description'   => __( 'Specify whether or not each tasks progress should be visible.', 'canvys' ),
               'default'       => 'true',
               'options'       => array(
                  'true'  => __( 'Yes, display the percentages', 'canvys' ),
                  'false' => __( 'No, do not display the percentages', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Select_Control( 'orientation', array(
               'title'         => __( 'Orientation', 'canvys' ),
               'description'   => __( 'Specify which orientation these progress bars should be displayed in. Use the vertical orientation with caution, when this is in use the progress bars no longer have a fluid width.', 'canvys' ),
               'default'       => 'horizontal',
               'options'       => array(
                  'horizontal'  => __( 'Horizontal', 'canvys' ),
                  'vertical' => __( 'Vertical', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Color_Control( 'default_color', array(
               'title'       => __( 'Custom Default Color', 'canvys' ),
               'description' => __( 'Each task can have a unique background color, use this control to change the default color for tasks which do not have a specified custom color. If this is left blank the accent color for the section will be used.', 'canvys' ),
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
           $section_tag . " .cv-progress-bars .task-wrapper .task-rail {"
         . "background: {$colors['secondary_bg']};"
         . "}"
         . $section_tag . " .cv-progress-bars .task-wrapper .task-progress {"
         . "background: {$colors['accent']};"
         . "}"
         . $section_tag . " .cv-progress-bars .task-wrapper .task-rail .task-percentage {"
         . "background: {$colors['secondary_bg']};"
         . "color: {$colors['secondary_content']};"
         . "border: 1px solid {$colors['borders']};"
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

      global $cv_progress_tasks;

      // Start with an empty array
      $cv_progress_tasks = array();

      // Fill the toggles array
      do_shortcode( $content );

      // Make sure there is atleast 1 toggle
      if ( empty( $cv_progress_tasks ) ) {
         return;
      }

      // Create attributes array by sanitizing provided values
      extract( $this->get_sanitized_attributes( $atts ) );

      // Progress bars wrapper
      $o = new CV_HTML( '<div>', array(
         'class' => 'cv-progress-bars'
      ) );

      // Apply the vertical align class
      if ( 'vertical' == $orientation ) $o->add_class( 'v-align-middle' );

      // Apply the entrance data
      if ( cv_make_bool( $animation ) ) {
         $o->add_class( 'has-animation' );
         $o->attr( 'data-trigger-entrances', 'true' );
         $entrance_delay = 0;
      }

      // Apply the show percentages class
      if ( cv_make_bool( $percentages ) ) {
         $o->add_class( 'has-percentages' );
      }

      // tasks container
      $all_tasks = new CV_HTML( '<div>', array(
         'class' => 'tasks-container has-clearfix'
      ) );

      foreach ( $cv_progress_tasks as $task_config ) {

         // task prgoress
         $progress = cv_limit_int( $task_config['progress'], 0, 100 );

         // Task wrapper
         $task = new CV_HTML( '<div>', array(
            'class' => 'task-wrapper',
         ) );

         // Add the title
         if ( $task_config['title'] ) $task->append( '<p class="task-label">' . $task_config['title'] . '</p>' );

         // Task progress
         $task_progress = new CV_HTML( '<div>', array(
            'class' => 'task-progress',
            'style' => 'width:' . $progress . '%',
         ) );

         // Apply the custom BG color
         $color = $task_config['color'] ? $task_config['color'] : $default_color;
         if ( $color ) $task_progress->css( 'background-color', $color );

         // Apply the entrance data
         if ( cv_make_bool( $animation ) ) {
            $task_progress->data( 'entrance' );
            $task_progress->data( 'chained', 'true' );
            $task_progress->data( 'delay', $entrance_delay );
            $entrance_delay += 100;
         }

         // Add the percentage count
         $task_percentage = cv_make_bool( $percentages ) ? '<p class="task-percentage"><span>' . $progress . '%</span></p>' : null;

         // Add the task progress bar
         $task->append( '<div class="task-rail has-clearfix">' . $task_progress . $task_percentage . '</div>');

         // Add the task to the progress bars
         $all_tasks->append( $task );

      }

      // Add the tasks to the wrapper
      $o->append( $all_tasks );

      return $o->render();

   }

}
endif;