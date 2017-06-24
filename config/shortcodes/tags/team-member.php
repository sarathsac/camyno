<?php

if ( ! class_exists('CV_Team_Member') ) :

/**
 * Team Member
 *
 * @package      WordPress
 * @subpackage   Canvys
 * @since        Version 1.0
 */
class CV_Team_Member extends CV_Shortcode {

   /**
    * Function to create shortcode configuration
    *
    * @return void
    */
   public function __construct() {

      $this->config = array(

         // Handle will be used to use this shortcode
         'handle' => 'cv_team_member',

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
         'title' => __( 'Team Member', 'canvys' ),

         // Icon will be used to represent this shortcode in composer/builder
         // List of available icons can be found in icons.json
         'icon' => 'user',

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

            new CV_Shortcode_Image_Control( 'img_id', array(
               'title'       => __( 'Image', 'canvys' ),
               'description' => __( 'Select the image to be used as this members profile picture.', 'canvys' ),
            ) ),

            new CV_Shortcode_Text_Control( 'name', array(
               'title'       => __( 'Displayed Name', 'canvys' ),
               'description' => __( 'Specify this members displayed name', 'canvys' ),
            ) ),

            new CV_Shortcode_Text_Control( 'role', array(
               'title'       => __( 'Role', 'canvys' ),
               'description' => __( 'Specify the role this team member plays in the company.', 'canvys' ),
            ) ),

            new CV_Shortcode_List_Control( 'contacts', array(
               'title'       => __( 'Contacts', 'canvys' ),
               'description' => __( 'Vertical Bar delimited list of ways to contact this member. This includes any social media profiles, personal websites, and email addresses. Example: http://www.facebook.com|http://www.twitter.com|http://www.flickr.com', 'canvys' ),
               'separator'   => '|',
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
      return isset($atts['name']) && $atts['name'] ? $atts['name'] : $this->config['title'];
   }

   /**
    * Callback function for front end display of shortcode
    *
    * @param array  $atts      Array of provided attributes
    * @param string $content   Content of shortcode
    * @return string
    */
   public function callback( $atts, $content = null ) {

      global $cv_team_members;

      if ( ! is_array( $cv_team_members ) ) {
         $cv_team_members = array();
      }

      // Create attributes array by sanitizing provided values
      extract( $this->get_sanitized_attributes( $atts ) );

      $cv_team_members[] = array(
         'img_id'   => $img_id,
         'name' => $name,
         'role' => $role,
         'contacts' => $contacts,
      );

   }

}
endif;