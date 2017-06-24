<?php

if ( ! function_exists( 'cv_update_page_settings' ) ) :

/**
 * Helper function to update page settings
 *
 * @return nothing
 */
function cv_update_page_settings( $post_id ) {

   // If the post is being autosaved, no need to update values
   if ( defined('DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
      return $post_id;
   }

   // Verify the nonce before proceeding.
   if ( ! isset( $_POST['cv_page_settings_meta_box_nonce'] ) || ! wp_verify_nonce( $_POST['cv_page_settings_meta_box_nonce'], 'cv_page_settings_meta_box_update_action' ) ) {
      return $post_id;
   }

   $input = $_POST['_cv_page_settings'];
   $clean = get_post_meta( $post_id, '_cv_page_settings', true );
   if ( ! is_array( $clean ) ) { $clean = array(); }

   /* Update Page Slide
      ========================================= */

   // Validate Input
   $clean['page_slide'] = isset( $input['page_slide'] ) && $input['page_slide'] ? true : false;

   /* Update Page Slide Base Nav Color
      ========================================= */

   if ( isset( $input['page_slide_nav_base_color'] ) ) {

      // Validate Input
      $clean['page_slide_nav_base_color'] = cv_filter( $input['page_slide_nav_base_color'], 'hex' );

   }

   /* Update Page Slide Hover Nav Color
      ========================================= */

   if ( isset( $input['page_slide_nav_hover_color'] ) ) {

      // Validate Input
      $clean['page_slide_nav_hover_color'] = cv_filter( $input['page_slide_nav_hover_color'], 'hex' );

   }

   /* Update Page Slide BG Color
      ========================================= */

   if ( isset( $input['page_slide_nav_bg_color'] ) ) {

      // Validate Input
      $clean['page_slide_nav_bg_color'] = cv_filter( $input['page_slide_nav_bg_color'], 'hex' );

   }

   /* Update Page Slide Nav Labels
      ========================================= */

   if ( isset( $input['page_slide_nav_labels'] ) ) {

      // Validate Input
      $clean['page_slide_nav_labels'] = cv_filter( $input['page_slide_nav_labels'], 'text' );

   }

   /* Update Header Transparency
      ========================================= */

   if ( isset( $input['transparency'] ) ) {

      // Allowed transparency settingss
      $allowed_transparency_options = array( 'default', 'enabled', 'custom', 'disabled' );

      // Validate Input
      $clean['transparency'] = cv_filter( $input['transparency'], $allowed_transparency_options );

   }

   /* Update Header Transparency Glassy effect
      ========================================= */

   // Validate Input
   $clean['transparency_glassy'] = isset( $input['transparency_glassy'] ) && $input['transparency_glassy'] ? true : false;

   /* Update Header Transparency Logo
      ========================================= */

   if ( isset( $input['transparency_logo'] ) ) {

      // Validate Input
      $clean['transparency_logo'] = cv_filter( $input['transparency_logo'], 'integer' );

   }

   /* Update Header Transparency Color
      ========================================= */

   if ( isset( $input['transparency_color'] ) ) {

      // Validate Input
      $clean['transparency_color'] = cv_filter( $input['transparency_color'], 'hex' );

   }

   /* Update Footer Settings
      ========================================= */

   if ( isset( $input['footer'] ) ) {

      // Allowed footer settingss
      $allowed_footers = array( 'default', 'socket', 'columns', 'both' );

      // Validate Input
      $clean['footer'] = cv_filter( $input['footer'], $allowed_footers );

   }

   /* Update Layout
      ========================================= */

   if ( isset( $input['layout'] ) ) {

      // Allowed layouts
      // if ( is_page() ) {
         $allowed_layouts = array( 'default', 'sidebar-left', 'sidebar-right', 'no-sidebar' );
      // }

      // Validate Input
      $clean['layout'] = cv_filter( $input['layout'], $allowed_layouts );

   }

   /* Update Sidebar
      ========================================= */

   if ( isset( $input['sidebar'] ) ) {

      // Sidebar options
      $allowed_sidebars = array( 'default', 'blog_sidebar' );

      // Fill Sidebar options array
      $user_sidebars = get_option( 'cv_sidebars' );

      // If any custom sidebars are available, create them
      if ( is_array( $user_sidebars ) ) {
         foreach ( $user_sidebars as $id => $name ) {
            $allowed_sidebars[] = 'cv_user_sidebar_' . $id;
         }
      }

      // Validate input
      $clean['sidebar'] = cv_filter( $input['sidebar'], $allowed_sidebars );

   }

   // Finally, update the setting
   update_post_meta( $post_id, '_cv_page_settings', $clean );

}
endif;