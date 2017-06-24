<?php

if ( ! class_exists('CV_Progress_Task') ) :

/**
 * Progress Bar Task
 *
 * @package      WordPress
 * @subpackage   Canvys
 * @since        Version 1.0
 */
class CV_Progress_Task extends CV_Shortcode {

   /**
    * Function to create shortcode configuration
    *
    * @return void
    */
   public function __construct() {

      $this->config = array(

         // Handle will be used to use this shortcode
         'handle' => 'cv_progress_task',

         // Whether or not this is a shortcode composer element
         'composer_element' => false,

         // Whether or not this is a template builder element
         'builder_element' => true,

         // Used by the template builder to determine where module can be dropped
         'drop_target' => 3,

         // Used by the template builder to determine where module can have other
         // modules dropped inside of it
         'drop_zone' => false,

         // Title will be used to identify this shortcode
         'title' => __( 'Task', 'canvys' ),

         // Icon will be used to represent this shortcode in composer/builder
         // List of available icons can be found in icons.json
         'icon' => 'tasks',

         // Whether or not shortcode is self closing
         'self_closing' => true,

         // If shortcode is not self closing, specify its default content
         'default_content' =>  null,

         // Specify whether or not content is directly editable
         'content_editor' => false,

         // Specify whether or not the content is composed of another shortcode
         'content_element' => false,

         // Array of shortcode settings and their respective attributes
         'attributes' => array(

            new CV_Shortcode_Text_Control( 'title', array(
               'title'       => __( 'Title', 'canvys' ),
               'description' => __( 'Specify the title of this task.', 'canvys' ),
            ) ),

            new CV_Shortcode_Number_Control( 'progress', array(
               'title'       => __( 'Progress Percentage', 'canvys' ),
               'description' => __( 'Specify the percentage completed for this task, enter a numeric value only.', 'canvys' ),
               'placeholder' => '0 - 100',
            ) ),

            new CV_Shortcode_Color_Control( 'color', array(
               'title'       => __( 'Custom Color', 'canvys' ),
               'description' => __( 'Specify a custom color to be used for this task, if none is specified te default color will be used.', 'canvys' ),
            ) ),

         ),
      );
   }

   /**
    * Callback function for displaying the template builder module title
    *
    * @param array  $atts      Array of provided attributes
    * @param string $content   Content of shortcode
    * @return string
    */
   public function builder_module_title( $atts, $content = null ) {
      extract( $this->get_sanitized_attributes( $atts ) );
      $progress = $progress ? $progress : '0';
      $title = $title ? $title : $this->config['title'];
      return $title . ' - ' . $progress . '%';
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

      if ( ! is_array( $cv_progress_tasks ) ) {
         $cv_progress_tasks = array();
      }

      // Create attributes array by sanitizing provided values
      extract( $this->get_sanitized_attributes( $atts ) );

      $cv_progress_tasks[] = array(
         'title'   => $title,
         'progress' => $progress,
         'color' => $color,
      );

   }

}
endif;