<?php

if ( ! class_exists('CV_Sidebar_Settings') ) :

/**
 * General settings page
 *
 * @package    WordPress
 * @subpackage Canvys
 * @since      Version 1.0
 */
class CV_Sidebar_Settings extends CV_Settings_Page {

   /**
    * Function to create page configuration
    *
    * @return void
    */
   public function __construct() {

      global $canvys;

      $this->config = array(
         'tab_title' => __( 'Sidebars', 'canvys' ),
         'slug' => 'sidebar',
         'priority' => 60,
         'defaults' => array(
            'responsive_behavior' => 'normal',
            'page_layout'         => 'sidebar-right',
            'search_layout'       => 'sidebar-right',
            'portfolio_layout'    => 'sidebar-right',
            'blog_layout'         => 'sidebar-right',
            'single_layout'       => 'sidebar-right',
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
         <strong class="option-title"><?php _e( 'Custom Sidebars', 'canvys' ); ?></strong>
         <p class="option-description"><?php printf( __( 'Custom sidebars can be created/managed from the <a href="%s">widgets page</a>. Once you have created at least one custom sidebar you will be able to use your custom sidebars on your pages.', 'canvys' ), admin_url( 'widgets.php' ) ); ?></p>
      </div>
      <div class="option-wrap">
         <label class="option-title" for="sidebar-responsive_behavior"><?php _e( 'Responsive Behavior', 'canvys' ); ?></label>
         <select name="<?php echo $name; ?>[responsive_behavior]" id="sidebar-responsive_behavior">
            <option value="normal" <?php selected( $input['responsive_behavior'], 'normal' ); ?>><?php _e( 'Visible on all screen sizes', 'canvys' ); ?></option>
            <option value="hide" <?php selected( $input['responsive_behavior'], 'hide' ); ?>><?php _e( 'Visible on large screens only', 'canvys' ); ?></option>
         </select>
         <p class="option-description"><?php _e( 'Control how sidebars should behave when viewed on different screen sizes, this is only applicable if responsive behavior for the theme has not been disabled.', 'canvys' ); ?></p>
      </div>

      <div class="option-wrap">
         <label class="option-title" for="sidebar-page_layout"><?php _e( 'Default Page Layout', 'canvys' ); ?></label>
         <select name="<?php echo $name; ?>[page_layout]" id="sidebar-page_layout">
            <option value="sidebar-left" <?php selected( $input['page_layout'], 'sidebar-left' ); ?>><?php _e( 'Left Sidebar', 'canvys' ); ?></option>
            <option value="sidebar-right" <?php selected( $input['page_layout'], 'sidebar-right' ); ?>><?php _e( 'Right Sidebar', 'canvys' ); ?></option>
            <option value="no-sidebar" <?php selected( $input['page_layout'], 'no-sidebar' ); ?>><?php _e( 'No Sidebar', 'canvys' ); ?></option>
         </select>
         <p class="option-description"><?php _e( 'Default sidebar layout for pages, can be overriden for each page.', 'canvys' ); ?></p>
      </div>

      <div class="option-wrap">
         <label class="option-title" for="sidebar-search_layout"><?php _e( 'Search Results Page Layout', 'canvys' ); ?></label>
         <select name="<?php echo $name; ?>[search_layout]" id="sidebar-search_layout">
            <option value="sidebar-left" <?php selected( $input['search_layout'], 'sidebar-left' ); ?>><?php _e( 'Left Sidebar', 'canvys' ); ?></option>
            <option value="sidebar-right" <?php selected( $input['search_layout'], 'sidebar-right' ); ?>><?php _e( 'Right Sidebar', 'canvys' ); ?></option>
            <option value="no-sidebar" <?php selected( $input['search_layout'], 'no-sidebar' ); ?>><?php _e( 'No Sidebar', 'canvys' ); ?></option>
         </select>
         <p class="option-description"><?php _e( 'Sidebar layout for the search results page.', 'canvys' ); ?></p>
      </div>

      <div class="option-wrap">
         <label class="option-title" for="sidebar-portfolio_layout"><?php _e( 'Default Single Portfolio Item Layout', 'canvys' ); ?></label>
         <select name="<?php echo $name; ?>[portfolio_layout]" id="sidebar-portfolio_layout">
            <option value="sidebar-left" <?php selected( $input['portfolio_layout'], 'sidebar-left' ); ?>><?php _e( 'Left Sidebar', 'canvys' ); ?></option>
            <option value="sidebar-right" <?php selected( $input['portfolio_layout'], 'sidebar-right' ); ?>><?php _e( 'Right Sidebar', 'canvys' ); ?></option>
            <option value="no-sidebar" <?php selected( $input['portfolio_layout'], 'no-sidebar' ); ?>><?php _e( 'No Sidebar', 'canvys' ); ?></option>
         </select>
         <p class="option-description"><?php _e( 'Default sidebar layout for single portfolio items, can be overriden for each portfolio item.', 'canvys' ); ?></p>
      </div>

      <div class="option-wrap">
         <label class="option-title" for="sidebar-blog_layout"><?php _e( 'Blog Layout', 'canvys' ); ?></label>
         <select name="<?php echo $name; ?>[blog_layout]" id="sidebar-blog_layout">
            <option value="sidebar-left" <?php selected( $input['blog_layout'], 'sidebar-left' ); ?>><?php _e( 'Left Sidebar', 'canvys' ); ?></option>
            <option value="sidebar-right" <?php selected( $input['blog_layout'], 'sidebar-right' ); ?>><?php _e( 'Right Sidebar', 'canvys' ); ?></option>
            <option value="no-sidebar" <?php selected( $input['blog_layout'], 'no-sidebar' ); ?>><?php _e( 'No Sidebar', 'canvys' ); ?></option>
         </select>
         <p class="option-description"><?php _e( 'Sidebar layout for the blog page and other blog related pages including archives.', 'canvys' ); ?></p>
      </div>

      <div class="option-wrap">
         <label class="option-title" for="sidebar-single_layout"><?php _e( 'Single Post Layout', 'canvys' ); ?></label>
         <select name="<?php echo $name; ?>[single_layout]" id="sidebar-single_layout">
            <option value="sidebar-left" <?php selected( $input['single_layout'], 'sidebar-left' ); ?>><?php _e( 'Left Sidebar', 'canvys' ); ?></option>
            <option value="sidebar-right" <?php selected( $input['single_layout'], 'sidebar-right' ); ?>><?php _e( 'Right Sidebar', 'canvys' ); ?></option>
            <option value="no-sidebar" <?php selected( $input['single_layout'], 'no-sidebar' ); ?>><?php _e( 'No Sidebar', 'canvys' ); ?></option>
         </select>
         <p class="option-description"><?php _e( 'Sidebar layout for single post pages.', 'canvys' ); ?></p>
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
         'responsive_behavior' => isset( $input['responsive_behavior'] ) ? cv_filter( $input['responsive_behavior'], array( 'normal', 'hide' ) ) : 'normal',
         'page_layout'         => isset( $input['page_layout'] ) ? cv_filter( $input['page_layout'], array( 'sidebar-left', 'sidebar-right', 'no-sidebar' ) ) : 'sidebar-right',
         'search_layout'       => isset( $input['search_layout'] ) ? cv_filter( $input['search_layout'], array( 'sidebar-left', 'sidebar-right', 'no-sidebar' ) ) : 'sidebar-right',
         'portfolio_layout'    => isset( $input['portfolio_layout'] ) ? cv_filter( $input['portfolio_layout'], array( 'sidebar-left', 'sidebar-right', 'no-sidebar' ) ) : 'sidebar-right',
         'blog_layout'         => isset( $input['blog_layout'] ) ? cv_filter( $input['blog_layout'], array( 'sidebar-left', 'sidebar-right', 'no-sidebar' ) ) : 'sidebar-right',
         'single_layout'       => isset( $input['single_layout'] ) ? cv_filter( $input['single_layout'], array( 'sidebar-left', 'sidebar-right', 'no-sidebar' ) ) : 'sidebar-right',
      );
   }

}
endif;