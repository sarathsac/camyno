<?php

if ( ! class_exists('CV_Toggle_Group') ) :

/**
 * Toggle Groups
 *
 * @package      WordPress
 * @subpackage   Canvys
 * @since        Version 1.0
 */
class CV_Toggle_Group extends CV_Shortcode {

   /**
    * Function to create shortcode configuration
    *
    * @return void
    */
   public function __construct() {

      $this->config = array(

         // Handle will be used to use this shortcode
         'handle' => 'cv_toggle_group',

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
         'title' => __( 'Toggle Group', 'canvys' ),

         // Icon will be used to represent this shortcode in composer/builder
         // List of available icons can be found in icons.json
         'icon' => 'menu',

         // Whether or not shortcode is self closing
         'self_closing' => false,

         // If shortcode is not self closing, specify its default content
         'default_content' => '[cv_toggle title="' . __( 'Toggle 1 Title', 'canvys' ) . '"][/cv_toggle]'
                            . '[cv_toggle title="' . __( 'Toggle 2 Title', 'canvys' ) . '"][/cv_toggle]',

         // Specify whether or not content is directly editable
         'content_editor' => false,

         // Specify whether or not the content is composed of another shortcode
         'content_element' => 'cv_toggle',

         // Provide an explanation of what this shortcode does
         'explanation' => __( 'Toggle groups allow you to add any number of toggles, which can optionally have tags applied to them. If one or more toggles has atleast one tag then the entire toggle group will be filterable. The list of filters will be automatically created based on the tags specified for each toggle.', 'canvys' ),

         // Array of shortcode settings and their respective attributes
         'attributes' => array(

            new CV_Shortcode_Select_Control( 'first_open', array(
               'title'         => __( 'First Toggle Open on Load', 'canvys' ),
               'description'   => __( 'Specify whether or not the first toggle should be open upon page load.', 'canvys' ),
               'default'       => 'true',
               'options'       => array(
                  'true'  => __( 'Yes, first toggle should be open', 'canvys' ),
                  'false' => __( 'No, all toggles should be closed', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Select_Control( 'allow_multi', array(
               'title'         => __( 'Allow Multiple Toggles to be Open', 'canvys' ),
               'description'   => __( 'Specify whether or not multiple toggles should be allowed open at one time.', 'canvys' ),
               'type'          => 'select',
               'default'       => 'true',
               'options'       => array(
                  'true'  => __( 'Yes, allow multiple toggles to be open at once', 'canvys' ),
                  'false' => __( 'No, toggle group should behave like an accordion', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Select_Control( 'spacing', array(
               'title'         => __( 'Spacing', 'canvys' ),
               'description'   => __( 'Add spacing between each toggle.', 'canvys' ),
               'type'          => 'select',
               'default'       => 'true',
               'options'       => array(
                  'true'  => __( 'Yes, display spacing after each toggle', 'canvys' ),
                  'false' => __( 'No, do not display spacing', 'canvys' ),
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
           ".js " . $section_tag . " .cv-toggle-group .toggle-filters a {"
         . "color: " . cv_hex_to_rgba( $colors['content'], 0.74 ) . ";"
         . "}"
         . ".js " . $section_tag . " .cv-toggle-group .toggle-filters a:hover {"
         . "color: {$colors['content']};"
         . "}"
         . ".js " . $section_tag . " .cv-toggle-group .toggle-filters .is-active > a {"
         . "color: {$colors['accent']};"
         . "}"
         ;

         // Toggles
         echo
           ".js " . $section_tag . " .cv-toggle-group {"
         . "border-bottom: 1px solid {$colors['borders']};"
         . "}"
         . ".js " . $section_tag . " .cv-toggle-group .toggle-title {"
         . "border: 1px solid {$colors['borders']};"
         . "}"
         . ".js " . $section_tag . " .cv-toggle-group .toggle > div {"
         . "border: 1px solid {$colors['borders']};"
         . "}"
         . ".js " . $section_tag . " .cv-toggle-group .toggle.is-open .toggle-handle {"
         . "background: {$colors['secondary_bg']};"
         . "}"
         . ".js " . $section_tag . " .cv-toggle-group .toggle .toggle-content {"
         . "border-top: 1px solid {$colors['borders']};"
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

      global $cv_toggles;

      // Start with an empty array
      $cv_toggles = array();

      // Fill the toggles array
      do_shortcode( $content );

      // Make sure there is atleast 1 toggle
      if ( empty( $cv_toggles ) ) {
         return;
      }

      // Create the filters array
      $filters = array();
      foreach ( $cv_toggles as $toggle_config ) {
         if ( $toggle_config['tags'] ) {
            foreach ( explode( ',', $toggle_config['tags'] ) as $tag ) {
               $filters[] = $tag;
            }
         }
      }
      $filters = empty( $filters ) ? null : array_unique( $filters );

      // Create attributes array by sanitizing provided values
      extract( $this->get_sanitized_attributes( $atts ) );

      // Toggle group wrapper
      $o = new CV_HTML( '<div>', array(
         'class' => 'cv-toggle-group'
      ) );

      // Aplpy collapsed class
      if ( ! cv_make_bool( $spacing ) ) {
         $o->add_class('is-collapsed');
      }

      // JSON Configuration object
      $config = json_encode( array(
         'firstOpen' => $first_open,
         'allowMulti' => $allow_multi,
      ) );
      $o->data( 'config', $config );

      // Insert the filters, if there are any
      if ( $filters ) {

         // Filters wrapper
         $filters_control = new CV_HTML( '<ul>', array(
            'class' => 'toggle-filters cloud-list js-only',
         ) );

         // Add the `All` filter
         $filters_control->append( '<li class="is-active"><a data-filter="all">' . __( 'All', 'canvys' ) . '</a></li>' );

         // Insert the filters
         foreach ( $filters as $filter ) {
            $filters_control->append( '<li><a data-filter="' . cv_slug( $filter ) . '">' . $filter . '</a></li>' );
         }

         // Append the filter control
         $o->append( $filters_control );

      }

      // insert the toggles
      $counter = 0;
      foreach ( $cv_toggles as $toggle_config ) {

         $counter++;

         // Toggle wrapper
         $toggle = new CV_HTML( '<div>', array(
            'class' => 'toggle',
         ) );

         // If first toggle should be open
         if ( cv_make_bool( $first_open ) && 1 === $counter ) {
            $toggle->add_class('is-open');
         }

         // Add any tags
         if ( $toggle_config['tags'] ) {
            $taglist = '';
            foreach ( explode( ',', $toggle_config['tags'] ) as $tag ) {
               $taglist .= cv_slug( $tag ) . ',';
            }
            $toggle->data( 'tags', trim( $taglist, ',' ) );
         }

         // Insert the title
         $toggle->append( '<h3 class="toggle-title toggle-handle"><span>' . $toggle_config['title'] . '</span></h3>' );

         // Insert the content
         $auto_height = cv_make_bool( $first_open ) && 1 === $counter ? ' style="height:auto;"' : null;
         $toggle->append( '<div' . $auto_height . '><div class="toggle-content">' . apply_filters( 'the_content', $toggle_config['content'] ) . '</div></div>' );

         // Append the toggle
         $o->append( $toggle );

      }

      return $o->render();

   }

}
endif;