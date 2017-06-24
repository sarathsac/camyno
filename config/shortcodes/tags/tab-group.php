<?php

if ( ! class_exists('CV_Tab_Group') ) :

/**
 * Tab Groups
 *
 * @package      WordPress
 * @subpackage   Canvys
 * @since        Version 1.0
 */
class CV_Tab_Group extends CV_Shortcode {

   /**
    * Function to create shortcode configuration
    *
    * @return void
    */
   public function __construct() {

      $this->config = array(

         // Handle will be used to use this shortcode
         'handle' => 'cv_tab_group',

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
         'title' => __( 'Tab Group', 'canvys' ),

         // Icon will be used to represent this shortcode in composer/builder
         // List of available icons can be found in icons.json
         'icon' => 'folder',

         // Whether or not shortcode is self closing
         'self_closing' => false,

         // If shortcode is not self closing, specify its default content
         'default_content' => '[cv_tab title="' . __( 'Tab 1 Title', 'canvys' ) . '" icon="camera"][/cv_tab]'
                            . '[cv_tab title="' . __( 'Tab 2 Title', 'canvys' ) . '" icon="anchor"][/cv_tab]',

         // Specify whether or not content is directly editable
         'content_editor' => false,

         // Specify whether or not the content is composed of another shortcode
         'content_element' => 'cv_tab',

         // Provide an explanation of what this shortcode does
         'explanation' => __( 'Tab groups allow you to add any number of tabs, which can optionally have icons applied to them.', 'canvys' ),

         // Array of shortcode settings and their respective attributes
         'attributes' => array(

            new CV_Shortcode_Select_Control( 'orientation', array(
               'title'         => __( 'Orientation', 'canvys' ),
               'description'   => __( 'Specify the orientation for the tabs and panes.', 'canvys' ),
               'default'       => 'horizontal',
               'options'       => array(
                  'horizontal'       => __( 'Tabs above panes', 'canvys' ),
                  'horizontal is-boxed' => __( 'Tabs above panes with boxed panes', 'canvys' ),
                  'vertical-left'    => __( 'Tabs to the left of panes', 'canvys' ),
                  'vertical-right'   => __( 'Tabs to the right of panes', 'canvys' ),
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

         // Global style
         echo
           ".js " . $section_tag . " .cv-tab-group {"
         . "border: 1px solid {$colors['borders']};"
         . "}"
         . ".js " . $section_tag . " .cv-tab-group > .tabs li a {"
         . "color: {$colors['content']};"
         . "}"
         . ".js " . $section_tag . " .cv-tab-group > .tabs li.is-active a {"
         . "color: {$colors['headers']};"
         . "}"
         ;

         // Mobile style
         echo
           ".js " . $section_tag . " .cv-tab-group > .panes .inner-pane-title {"
         . "color: {$colors['content']};"
         . "border-top: 1px solid {$colors['borders']};"
         . "}"
         . ".js " . $section_tag . " .cv-tab-group > .panes .is-active .inner-pane-title {"
         . "color: {$colors['secondary_content']};"
         . "background: {$colors['secondary_bg']};"
         . "}"
         . ".js " . $section_tag . " .cv-tab-group > .panes .pane-content {"
         . "border-top: 1px solid {$colors['borders']};"
         . "}"
         ;

         // Horizontal style
         echo
           "/* Breakpoint: 2 */"
         . "@media all and (min-width: 50em) {"
         . ".js.responsive " . $section_tag . " .cv-tab-group.is-horizontal > .tabs li {"
         . "border-top: 1px solid {$colors['borders']};"
         . "border-bottom: 1px solid {$colors['borders']};"
         . "}"
         . ".js.responsive " . $section_tag . " .cv-tab-group.is-horizontal > .tabs li.is-active {"
         . "border-bottom: 1px solid {$colors['primary_bg']};"
         . "background: {$colors['primary_bg']};"
         . "}"
         . "html:not([dir='rtl']) .js.responsive " . $section_tag . " .cv-tab-group.is-horizontal > .tabs li {"
         . "border-right: 1px solid {$colors['borders']};"
         . "}"
         . "html:not([dir='rtl']) .js.responsive " . $section_tag . " .cv-tab-group.is-horizontal > .tabs > li:first-child {"
         . "border-left: 1px solid {$colors['borders']};"
         . "}"
         . "html[dir='rtl'] .js.responsive " . $section_tag . " .cv-tab-group.is-horizontal > .tabs li {"
         . "border-left: 1px solid {$colors['borders']};"
         . "}"
         . "html[dir='rtl'] .js.responsive " . $section_tag . " .cv-tab-group.is-horizontal > .tabs > li:first-child {"
         . "border-right: 1px solid {$colors['borders']};"
         . "}"
         . ".js.responsive " . $section_tag . " .cv-tab-group.is-horizontal > .panes {"
         . "border-top: 1px solid {$colors['borders']};"
         . "}"
         . ".js.responsive " . $section_tag . " .cv-tab-group.is-horizontal.is-boxed > .panes {"
         . "border: 1px solid {$colors['borders']};"
         . "}"
         . "}"
         . ".js.not-responsive " . $section_tag . " .cv-tab-group.is-horizontal > .tabs li {"
         . "border-top: 1px solid {$colors['borders']};"
         . "border-bottom: 1px solid {$colors['borders']};"
         . "}"
         . ".js.not-responsive " . $section_tag . " .cv-tab-group.is-horizontal > .tabs li.is-active {"
         . "border-bottom: 1px solid {$colors['primary_bg']};"
         . "background: {$colors['primary_bg']};"
         . "}"
         . "html:not([dir='rtl']) .js.not-responsive " . $section_tag . " .cv-tab-group.is-horizontal > .tabs li {"
         . "border-right: 1px solid {$colors['borders']};"
         . "}"
         . "html:not([dir='rtl']) .js.not-responsive " . $section_tag . " .cv-tab-group.is-horizontal > .tabs > li:first-child {"
         . "border-left: 1px solid {$colors['borders']};"
         . "}"
         . "html[dir='rtl'] .js.not-responsive " . $section_tag . " .cv-tab-group.is-horizontal > .tabs li {"
         . "border-left: 1px solid {$colors['borders']};"
         . "}"
         . "html[dir='rtl'] .js.not-responsive " . $section_tag . " .cv-tab-group.is-horizontal > .tabs > li:first-child {"
         . "border-right: 1px solid {$colors['borders']};"
         . "}"
         . ".js.not-responsive " . $section_tag . " .cv-tab-group.is-horizontal > .panes {"
         . "border-top: 1px solid {$colors['borders']};"
         . "}"
         ;

         // Vertical style
         echo
           "/* Breakpoint: 1 */"
         . "@media all and (min-width: 40em) {"
         . ".js " . $section_tag . " .cv-tab-group[class*='is-vertical-'] > .tabs li {"
         . "border-bottom: 1px solid {$colors['borders']};"
         . "}"
         . ".js " . $section_tag . " .cv-tab-group[class*='is-vertical-'] > .tabs li:first-child {"
         . "border-top: 1px solid {$colors['borders']};"
         . "}"
         . ".js " . $section_tag . " .cv-tab-group[class*='is-vertical-'] > .tabs li.is-active {"
         . "background: {$colors['primary_bg']};"
         . "}"
         . "}"
         ;

         // Vertical left style
         echo
           "/* Breakpoint: 1 */"
         . "@media all and (min-width: 40em) {"
         . ".js " . $section_tag . " .cv-tab-group.is-vertical-left > .tabs {"
         . "border-right: 1px solid {$colors['borders']};"
         . "}"
         . ".js " . $section_tag . " .cv-tab-group.is-vertical-left > .panes {"
         . "border-left: 1px solid {$colors['borders']};"
         . "}"
         . "}"
         ;

         // Vertical right style
         echo
           "/* Breakpoint: 1 */"
         . "@media all and (min-width: 40em) {"
         . ".js " . $section_tag . " .cv-tab-group.is-vertical-right > .tabs {"
         . "border-left: 1px solid {$colors['borders']};"
         . "}"
         . ".js " . $section_tag . " .cv-tab-group.is-vertical-right > .panes {"
         . "border-right: 1px solid {$colors['borders']};"
         . "}"
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

      global $cv_tabs;

      // Start with an empty array
      $cv_tabs = array();

      // Fill the toggles array
      do_shortcode( $content );

      // Make sure there is atleast 1 toggle
      if ( empty( $cv_tabs ) ) {
         return;
      }

      // Create attributes array by sanitizing provided values
      extract( $this->get_sanitized_attributes( $atts ) );

      // tab group wrapper
      $o = new CV_HTML( '<div>', array(
         'class' => 'cv-tab-group has-clearfix'
      ) );

      // Apply the orientation class
      $o->add_class( 'is-' . $orientation );

      // Tabs wrapper
      $tabs = new CV_HTML( '<ul>', array(
         'class' => 'tabs has-clearfix js-only',
      ) );
      $counter = 0;
      foreach ( $cv_tabs as $tab_config ) {
         $counter++;
         $active_class = 1 === $counter ? ' class="is-active"' : null;
         $icon = cv_make_bool( $tab_config['with_icon'] ) ? '<i class="tab-icon icon-' . $tab_config['icon'] . '"></i>' : null;
         $tabs->append( '<li' . $active_class . '><a>' . $icon . $tab_config['title'] . '</a></li>' );
      }

      // Append the tabs
      $o->append( $tabs );

      // Panes wrapper
      $panes = new CV_HTML( '<div>', array(
         'class' => 'panes',
      ) );
      $counter = 0;
      foreach ( $cv_tabs as $tab_config ) {
         $counter++;
         $icon = cv_make_bool( $tab_config['with_icon'] ) ? '<i class="tab-icon icon-' . $tab_config['icon'] . '"></i>' : null;
         $active_class = 1 === $counter ? ' is-active"' : null;
         $pane  = '<div class="pane' . $active_class . '">';
         $pane .= '<h3 class="inner-pane-title">' . $icon . $tab_config['title'] . '</h3>';
         $pane .= '<div class="pane-content">' . apply_filters( 'the_content', $tab_config['content'] ) . '</div>';
         $pane .= '</div>';
         $panes->append( $pane );
      }

      // Append the panes
      $o->append( $panes );

      return $o->render();

   }

}
endif;