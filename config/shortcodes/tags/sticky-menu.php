<?php

if ( ! class_exists('CV_Sticky_Menu') ) :

/**
 * Sticky Menu
 * Class that handles the creation and configuration
 * of the sticky menu shortcode
 *
 * @package      WordPress
 * @subpackage   Canvys
 * @since        Version 1.0
 */
class CV_Sticky_Menu extends CV_Shortcode {

   /**
    * Function to create shortcode configuration
    *
    * @return void
    */
   public function __construct() {

      global $canvys;

      $this->config = array(

         // Handle will be used to use this shortcode
         'handle' => 'cv_sticky_menu',

         // Whether or not this is a shortcode composer element
         'composer_element' => false,

         // Whether or not this is a template builder element
         'builder_element' => true,

         // Used by the template builder to determine where module can be dropped
         'drop_target' => 0,

         // Used by the template builder to determine where module can have other
         // modules dropped inside of it
         'drop_zone' => false,

         // Title will be used to identify this shortcode
         'title' => __( 'Sticky Menu', 'canvys' ),

         // Icon will be used to represent this shortcode in composer/builder
         // List of available icons can be found in icons.json
         'icon' => 'menu',

         // Whether or not shortcode is self closing
         'self_closing' => false,

         // If shortcode is not self closing, specify its default content
         'default_content' => '[cv_sticky_menu_item label="' . __( 'Link One', 'canvys' ) . '"][cv_sticky_menu_item label="' . __( 'Link Two', 'canvys' ) . '"]',

         // Specify whether or not content is directly editable
         'content_editor' => false,

         // Specify whether or not the content is composed of another shortcode
         'content_element' => 'cv_sticky_menu_item',

         // Provide an explanation of what this shortcode does
         'explanation' => __( 'Sticky menus can be used to navigate the page they are displayed on. The sticky menu will be stationary within the page content until it is scrolled to, at which point it will stick to the top of the screen and scroll with the user as they navigate the page.', 'canvys' ),

         // Array of shortcode settings and their respective attributes
         'attributes' => array(

            new CV_Shortcode_Select_Control( 'color_scheme', array(
               'title'       => __( 'Color Scheme', 'canvys' ),
               'description' => __( 'This will control the control scheme for the sticky menu. These different color schemes can be edited by navigating to Appearance > Color Scheme.', 'canvys' ),
               'default'     => 'main',
               'options'     => array(
                  'main'      => __( 'Main Content', 'canvys' ),
                  'alternate' => __( 'Alternate Content', 'canvys' ),
                  'header'    => __( 'Header', 'canvys' ),
                  'footer'    => __( 'Footer', 'canvys' ),
                  'socket'    => __( 'Socket', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Select_Control( 'borders', array(
               'title'       => __( 'Display Borders', 'canvys' ),
               'description' => __( 'Display a single pixel border above and below the sticky menu.', 'canvys' ),
               'default'     => 'true',
               'options'     => array(
                  'true'  => __( 'Yes, display borders', 'canvys' ),
                  'false' => __( 'No, do not display borders', 'canvys' ),
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

         echo
           "#cv-sticky-nav-marker.color-scheme-{$section}, .cv-sticky-nav.color-scheme-{$section} {"
         . "background: {$colors['primary_bg']};"
         . "}"
         . ".cv-sticky-nav.color-scheme-{$section} {"
         . "border-top: 1px solid {$colors['borders']};"
         . "border-bottom: 1px solid {$colors['borders']};"
         . "}"
         . ".cv-sticky-nav.color-scheme-{$section} a {"
         . "color: {$colors['content']};"
         . "}"
         . ".cv-sticky-nav.color-scheme-{$section} a.is-active {"
         . "color: {$colors['headers']};"
         . "}"
         . ".cv-sticky-nav.color-scheme-{$section} a.is-active:after {"
         . "border-top-color: {$colors['accent']};"
         . "}"
         . ".cv-sticky-nav.color-scheme-{$section} a:hover {"
         . "color: {$colors['headers']};"
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

      static $sticky_menus = 0;

      $sticky_menus++;

      if ( 1 < $sticky_menus ) return false;

      // Extract sanitized attributes
      extract( $this->get_sanitized_attributes( $atts ) );

      global $cv_sticky_menu_items;

      // Start with an empty array
      $cv_sticky_menu_items = array();

      // Fill the sticky items array
      do_shortcode( $content );

      // Make sure there is atleast 1 sticky item
      if ( empty( $cv_sticky_menu_items ) ) {
         return;
      }

      // Sticky Nav
      $o = new CV_HTML( '<div>', array(
         'id' =>    'cv-sticky-nav',
         'class' => 'cv-sticky-nav',
      ) );

      // Apply the color scheme
      $o->add_class( 'color-scheme-' . $color_scheme );

      // Borders class
      if ( ! cv_make_bool( $borders ) ) {
         $o->add_class( 'no-borders' );
      }

      // The nav wrapper
      $nav = new CV_HTML( '<nav>', array(
         'class' => 'cv-user-font',
      ) );

      // insert the items
      foreach ( $cv_sticky_menu_items as $item_config ) {

         // Menu item
         $item = new CV_HTML( '<a>', array(
            'class'   => 'sticky-menu-item',
            'content' => $item_config['label'],
         ) );

         // Apply the HREF attribute
         if ( $url = cv_get_shortcode_link_control_url( $item_config['link'] ) ) { $item->attr( 'href', $url ); }
         if ( cv_get_shortcode_link_control_target( $item_config['link'] ) ) { $item->attr( 'target', '_blank' ); }

         if ( 0 === strpos( $item_config['link'], '#' ) ) {
            $item->add_class('animate-scroll');
         }

         // Append the item
         $nav->append( $item );

      }

      $o->content = '<div class="wrap has-clearfix">' . $nav . '</div>';

      return '<div id="cv-sticky-nav-marker" class="color-scheme-' . $color_scheme . '"></div>' . $o->render();

   }

}
endif;