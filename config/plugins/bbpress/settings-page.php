<?php

if ( ! class_exists('CV_bbPress_Settings') ) :

/**
 * bbPress settings page
 *
 * @package    WordPress
 * @subpackage Canvys
 * @since      Version 1.0
 */
class CV_bbPress_Settings extends CV_Settings_Page {

   /**
    * Function to create page configuration
    *
    * @return void
    */
   public function __construct() {

      global $canvys;

      $this->config = array(
         'tab_title' => 'bbPress',
         'slug' => 'bbpress',
         'priority' => 130,
         'defaults' => array(
            'hide_search'     => false,
            'layout'          => 'sidebar-right',
            'banner_behavior' => 'default',
         ),
      );

   }

   /**
    * Rendering the inner page
    *
    * @param array $input The user specified input
    * @return void
    */
   public function render_inner_page( $input ) {
      $name = 'cv_theme_settings[' . $this->config['slug'] . ']';
      $input = $this->extract_input( $input ); ?>

      <div class="option-wrap">
         <strong class="option-title"><?php _e( 'Forum Search Bar', 'canvys' ); ?></strong>
         <label for="bbpress-hide_search">
            <input type="checkbox" id="bbpress-hide_search" value="1" <?php checked( $input['hide_search'] ); ?> name="<?php echo $name; ?>[hide_search]" />
            <span><?php _e( 'Hide the large search bar displayed above the forums index.', 'canvys' ); ?></span>
         </label>
      </div>

      <div class="option-wrap">
         <label class="option-title" for="bbpress-layout"><?php _e( 'Forums Layout', 'canvys' ); ?></label>
         <select name="<?php echo $name; ?>[layout]" id="bbpress-layout">
            <option value="sidebar-left" <?php selected( $input['layout'], 'sidebar-left' ); ?>><?php _e( 'Left Sidebar', 'canvys' ); ?></option>
            <option value="sidebar-right" <?php selected( $input['layout'], 'sidebar-right' ); ?>><?php _e( 'Right Sidebar', 'canvys' ); ?></option>
            <option value="no-sidebar" <?php selected( $input['layout'], 'no-sidebar' ); ?>><?php _e( 'No Sidebar', 'canvys' ); ?></option>
         </select>
         <p class="option-description"><?php _e( 'Default sidebar layout for all forum related pages.', 'canvys' ); ?></p>
      </div>

      <div class="option-wrap">
         <label for="bbpress-banner_behavior" class="option-title"><?php _e( 'Forum Pages Header & Banner Behavior', 'canvys' ); ?></label>
         <select name="<?php echo $name; ?>[banner_behavior]" id="bbpress-banner_behavior">
            <option value="default" <?php selected( $input['banner_behavior'], 'default' ); ?>><?php _e( 'Use theme defaults (Set in Theme Settings > Header)', 'canvys' ); ?></option>
            <option value="forum_page" <?php selected( $input['banner_behavior'], 'forum_page' ); ?>><?php _e( 'Match the settings for the page with the slug matching the one specified in bbPress Settings', 'canvys' ); ?></option>
         </select>
         <p><?php _e( 'Specify how the banner and header on all forums pages should be displayed.', 'canvys' ); ?></p>
      </div>

   <?php }

   /**
    * Sanitizing the page specific input
    *
    * @param array $input The user specified input
    * @return array
    */
   public static function sanitize_input( $input ) {
      return array(
         'hide_search'     => isset( $input['hide_search'] ) && $input['hide_search'] ? true : false,
         'layout'          => isset( $input['layout'] ) ? cv_filter( $input['layout'], array( 'sidebar-left', 'sidebar-right', 'no-sidebar' ) ) : 'no-sidebar',
         'banner_behavior' => isset( $input['banner_behavior'] ) ? cv_filter( $input['banner_behavior'], array( 'default', 'forum_page' ) ) : 'default',
      );
   }

}
endif;