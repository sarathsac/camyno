<?php

if ( ! class_exists('CV_Social_Group') ) :

/**
 * Icon Boxes
 *
 * @package      WordPress
 * @subpackage   Canvys
 * @since        Version 1.0
 */
class CV_Social_Group extends CV_Shortcode {

   /**
    * Function to create shortcode configuration
    *
    * @return void
    */
   public function __construct() {

      global $canvys;

      // Array of available social outlets
      $available_social_outlets = array();
      $saved_profiles = cv_theme_setting( 'social', 'profiles' );
      if ( ! empty( $saved_profiles ) ) {
         foreach ( $saved_profiles as $outlet => $url ) {
            if ( ! $url ) continue;
            $available_social_outlets[$outlet] = $canvys['social_outlets'][$outlet];
         }
      }

      $this->config = array(

         // Handle will be used to use this shortcode
         'handle' => 'cv_social_group',

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
         'title' => __( 'Social Media', 'canvys' ),

         // Icon will be used to represent this shortcode in composer/builder
         // List of available icons can be found in icons.json
         'icon' => 'shareable',

         // Whether or not shortcode is self closing
         'self_closing' => false,

         // If shortcode is not self closing, specify its default content
         'default_content' => null,

         // Specify whether or not content is directly editable
         'content_editor' => false,

         // Specify whether or not the content is composed of another shortcode
         'content_element' => false,

         // Provide an explanation of what this shortcode does
         'explanation' => __( 'This shortcode allows you to display any or all of the social media outlets you have created in the theme options panel.', 'canvys' ),

         // Array of shortcode settings and their respective attributes
         'attributes' => array(

            new CV_Shortcode_Multiple_Select_Control( 'social_outlets', array(
               'title'       => __( 'Social Media Outlets', 'canvys' ),
               'description' => __( 'Specify which of your social media outlets should be displayed.', 'canvys' ),
               'default'     => '1',
               'options'     => $available_social_outlets,
            ) ),

            new CV_Shortcode_Select_Control( 'columns', array(
               'title'       => __( 'Number of Columns', 'canvys' ),
               'description' => __( 'Specify how many columns should be used to display your social media outlets.', 'canvys' ),
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

            new CV_Shortcode_Select_Control( 'new_window', array(
               'title'       => __( 'Open in New Tab/Window', 'canvys' ),
               'description' => __( 'Specify whether or not links should be opened in a new tab/window.', 'canvys' ),
               'default'     => 'false',
               'options'     => array(
                  'false' => __( 'No, do not open links in a new tab/window', 'canvys' ),
                  'true' => __( 'Yes, open links in a new tab/window', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Select_Control( 'tooltips', array(
               'title'       => __( 'Display Tooltips', 'canvys' ),
               'description' => __( 'Specify whether or not tooltips containing the name of each social outlet should be added.', 'canvys' ),
               'default'     => 'false',
               'options'     => array(
                  'false' => __( 'No, do not show tooltips', 'canvys' ),
                  'true' => __( 'Yes, show tooltips', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Color_Control( 'color', array(
               'title'       => __( 'Custom Icon Color', 'canvys' ),
               'description' => __( 'Specify a custom color to be used for the outlet icons.', 'canvys' ),
            ) ),

         ),

      );
   }

   /**
    * Callback function for front end display of shortcode
    *
    * @param array  $atts      Array of provided attributes
    * @param string $content   Content of shortcode
    * @return string
    */
   public function callback( $atts, $content = null ) {

      global $canvys;

      // Grab profiles, if there are any
      $saved_profiles = cv_theme_setting( 'social', 'profiles', array() );

      // make sure there is at least one profile to show
      if ( ! is_array( $saved_profiles ) || empty( $saved_profiles ) ) {
         return false;
      }

      // Create attributes array by sanitizing provided values
      extract( $this->get_sanitized_attributes( $atts ) );

      $profiles = array();
      foreach ( explode( ',', $social_outlets ) as $outlet ) {
         if ( ! isset( $saved_profiles[$outlet] ) || ! $saved_profiles[$outlet] ) {
            continue;
         }
         $profiles[$outlet] = $saved_profiles[$outlet];
      }

      if ( empty( $profiles ) ) {
         return;
      }

      // Create the box
      $o = new CV_HTML( '<div>', array(
         'class' => 'cv-social-group has-clearfix spacing-2 not-responsive',
      ) );

      // Apply the layout class
      $o->add_class( 'cv-grid-' . $columns );

      $target_attr = cv_make_bool( $new_window ) ? ' target="_blank"' : null;

      foreach ( $profiles as $outlet => $url ) {

         // Make sure there is a URL
         if ( ! $url ) {
            continue;
         }

         // Create tooltip attribute
         $tooltip_data = cv_make_bool( $tooltips ) ? ' class="tooltip" title="' . $canvys['social_outlets'][$outlet] . '"' : null;

         // Create inlie style attribute
         $color_style = $color ? ' style="color:' . $color . '"' : null;

         // Create the profile
         $profile  = '<div class="social-profile">';
         $profile .= '<p class="cv-scaling-typography" data-multiplier="2" data-min="20" data-max="80">';
         $profile .= '<a href="' . $url . '"' . $tooltip_data . $color_style . $target_attr . '>';
         $profile .= '<i class="icon-' . $outlet . '"></i> ';
         $profile .= '</a></p></div>';

         // Add the profile
         $o->append( $profile );

      }

      return $o->render();

   }

}
endif;