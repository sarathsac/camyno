<?php

if ( ! class_exists('CV_The_Team') ) :

/**
 * Toggle Groups
 *
 * @package      WordPress
 * @subpackage   Canvys
 * @since        Version 1.0
 */
class CV_The_Team extends CV_Shortcode {

   /**
    * Function to create shortcode configuration
    *
    * @return void
    */
   public function __construct() {

      $this->config = array(

         // Handle will be used to use this shortcode
         'handle' => 'cv_the_team',

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
         'title' => __( 'Team Grid', 'canvys' ),

         // Icon will be used to represent this shortcode in composer/builder
         // List of available icons can be found in icons.json
         'icon' => 'users',

         // Whether or not shortcode is self closing
         'self_closing' => false,

         // If shortcode is not self closing, specify its default content
         'default_content' => '[cv_team_member name="' . __( 'John Doe', 'canvys' ) . '" role="' . __( 'Company Founder', 'canvys' ) . '"][/cv_team_member]'
                            . '[cv_team_member name="' . __( 'Jane Doe', 'canvys' ) . '" role="' . __( 'Company Founder', 'canvys' ) . '"][/cv_team_member]',

         // Specify whether or not content is directly editable
         'content_editor' => false,

         // Specify whether or not the content is composed of another shortcode
         'content_element' => 'cv_team_member',

         // Provide an explanation of what this shortcode does
         'explanation' => __( 'Efficiently display your team members in a stylish grid.', 'canvys' ),

         // Array of shortcode settings and their respective attributes
         'attributes' => array(

            new CV_Shortcode_Select_Control( 'columns', array(
               'title'       => __( 'Number of Columns', 'canvys' ),
               'description' => __( 'Specify how many columns should be used to display your team members.', 'canvys' ),
               'default'     => '3',
               'options'     => array(
                  '2' => __( '2 Columns', 'canvys' ),
                  '3' => __( '3 Columns', 'canvys' ),
                  '4' => __( '4 Columns', 'canvys' ),
                  '5' => __( '5 Columns', 'canvys' ),
                  '6' => __( '6 Columns', 'canvys' ),
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

         // Member profiles
         $overlay_bg = cv_theme_setting( 'visual', 'image_hover_color', '#000000' ) ? cv_theme_setting( 'visual', 'image_hover_color', '#000000' ) : '#000000';
         echo
           $section_tag . " .cv-the-team .member-profile .below-image {"
         . "background: {$colors['secondary_bg']};"
         . "}"
         . $section_tag . " .cv-the-team .member-profile .member-contacts {"
         . "background: " . cv_hex_to_rgba( $overlay_bg, 0.25 ) . ";"
         . "background: -moz-linear-gradient(top, " . cv_hex_to_rgba( $overlay_bg, 0.25 ) . " 0%, " . cv_hex_to_rgba( $overlay_bg, 0.75 ) . " 71%, " . cv_hex_to_rgba( $overlay_bg, 0.75 ) . " 100%);"
         . "background: -webkit-gradient(left top, left bottom, color-stop(0%, " . cv_hex_to_rgba( $overlay_bg, 0.25 ) . "), color-stop(71%, " . cv_hex_to_rgba( $overlay_bg, 0.75 ) . "), color-stop(100%, " . cv_hex_to_rgba( $overlay_bg, 0.75 ) . "));"
         . "background: -webkit-linear-gradient(top, " . cv_hex_to_rgba( $overlay_bg, 0.25 ) . " 0%, " . cv_hex_to_rgba( $overlay_bg, 0.75 ) . " 71%, " . cv_hex_to_rgba( $overlay_bg, 0.75 ) . " 100%);"
         . "background: -o-linear-gradient(top, " . cv_hex_to_rgba( $overlay_bg, 0.25 ) . " 0%, " . cv_hex_to_rgba( $overlay_bg, 0.75 ) . " 71%, " . cv_hex_to_rgba( $overlay_bg, 0.75 ) . " 100%);"
         . "background: -ms-linear-gradient(top, " . cv_hex_to_rgba( $overlay_bg, 0.25 ) . " 0%, " . cv_hex_to_rgba( $overlay_bg, 0.75 ) . " 71%, " . cv_hex_to_rgba( $overlay_bg, 0.75 ) . " 100%);"
         . "background: linear-gradient(to bottom, " . cv_hex_to_rgba( $overlay_bg, 0.25 ) . " 0%, " . cv_hex_to_rgba( $overlay_bg, 0.75 ) . " 71%, " . cv_hex_to_rgba( $overlay_bg, 0.75 ) . " 100%);"
         . "filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='" . $overlay_bg . "', endColorstr='" . $overlay_bg . "', GradientType=0 );"
         . "}"
         . $section_tag . " .cv-the-team .member-profile .below-image h4 {"
         . "color: {$colors['secondary_content']};"
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

      global $canvys, $cv_team_members;

      // Start with an empty array
      $cv_team_members = array();

      // Fill the toggles array
      do_shortcode( $content );

      // Make sure there is atleast 1 team member
      if ( empty( $cv_team_members ) ) {
         return;
      }

      // Create attributes array by sanitizing provided values
      extract( $this->get_sanitized_attributes( $atts ) );

      // Sanitize team members
      $sanitized_members = array();
      foreach ( $cv_team_members as $member_config ) {

         if ( ! wp_get_attachment_image_src( $member_config['img_id'] ) ) {
            continue;
         }

         if ( ! $member_config['name'] ) {
            continue;
         }

         $sanitized_members[] = $member_config;

      }

      // Profiles container
      $profiles = new CV_HTML( '<div>', array(
         'class' => 'cv-the-team masonry-layout cv-grid-' . $columns . ' spacing-1 has-clearfix',
      ) );

      foreach ( $sanitized_members as $member_id => $member_config ) {

         $has_contacts = $this->render_contacts( $member_config['contacts'] ) ? ' has-contacts' : null;

         // Create the profile
         $profile  = '<div class="member-profile' . $has_contacts . '">';

         $img_info = wp_get_attachment_image_src( $member_config['img_id'], 'cv_square_large' );

         // Profile Meta
         $first_name = explode( ' ', $member_config['name'] );

         $profile .= '<div class="cv-scalable-1x1">';
         $profile .= '<div style="background-image:url(' . $img_info[0] . ');" class="scalable-content bg-style-cover"></div>';
         $profile .= $this->render_contacts( $member_config['contacts'], $first_name[0] );
         $profile .= '</div>';


         $profile .= '<div class="below-image">';
         $profile .= '<h3 class="member-name">' . $member_config['name'] . '</h3>';
         if ( $member_config['role'] ) {
            $profile .= '<h4 class="member-role">' . $member_config['role'] . '</h4>';
         }
         $profile .= '</div>';


         $profile .= '</div>';

         // Add the profile
         $profiles->append( '<div>' . $profile . '</div>' );

      }


      return $profiles->render();

   }

   /**
    * Callback function for front end display of contact links
    *
    * @param string $contacts Array of provided contact URLs
    * @return string
    */
   public function render_contacts( $contact_urls, $member_name = null ) {

      global $canvys;

      if ( ! $contact_urls ) {
         return;
      }

      $overlay_bg = cv_theme_setting( 'visual', 'image_hover_color', '#000000' ) ? cv_theme_setting( 'visual', 'image_hover_color', '#000000' ) : '#000000';
      $button_color = 0.85 > cv_hex_brightness( $overlay_bg ) ? '#ffffff' : '#000000';

      $contacts = '<div class="member-contacts scalable-content"><div class="v-align-middle"><div>';
      foreach ( explode( '|', $contact_urls ) as $contact ) {
         $icon = 'link';
         $title = str_replace( array( 'http://', 'www.' ), '', $contact );
         $url = $contact;
         foreach ( $canvys['social_outlets'] as $outlet => $name ) {
            if ( strpos( $contact, $outlet ) ) {
               $icon = $outlet;
               $title = sprintf( __( '%s on %s', 'canvys' ), $member_name, $name );
            }
         }
         if( filter_var( $contact, FILTER_VALIDATE_EMAIL ) ) {
            $title = str_replace( '@', '[at]', $contact );
            $title = sprintf( __( 'Email %s', 'canvys' ), $member_name );
            $url = 'mailto:' . $contact;
            $icon = 'mail';
         }
         $contacts .= '<a class="cv-button button is-thin is-ghost is-circular tooltip" data-color="' . $button_color . '" data-rgb href="' . $url . '" title="' . $title . '"><i class="icon-' . $icon . '"></i></a>';
      }
      $contacts .= '</div></div></div>';

      return $contacts;

   }

}
endif;