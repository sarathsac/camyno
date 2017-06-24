<?php

if ( ! function_exists( 'cv_update_banner_settings' ) ) :

/**
 * Helper function to update banner settings
 *
 * @return nothing
 */
function cv_update_banner_settings( $post_id ) {

   global $canvys;

   // If the post is being autosaved, no need to update values
   if ( defined('DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
      return $post_id;
   }

   // Verify the nonce before proceeding.
   if ( ! isset( $_POST['cv_banner_settings_meta_box_nonce'] ) || ! wp_verify_nonce( $_POST['cv_banner_settings_meta_box_nonce'], 'cv_banner_settings_meta_box_update_action' ) ) {
      return $post_id;
   }

   $input = $_POST['_cv_banner_settings'];
   $clean = get_post_meta( $post_id, '_cv_banner_settings', true );
   if ( ! is_array( $clean ) ) $clean = array();

   /* Update Banner Display Settings
      ========================================= */

   if ( isset( $input['display'] ) ) {

      // Allowed banner settingss
      $allowed_display_settings = array( 'default', 'hide', 'custom' );

      // Validate Input
      $clean['display'] = cv_filter( $input['display'], $allowed_display_settings );

   }

   /* Update Show Crumbs
      ========================================= */

   // Validate Input
   $clean['show_crumbs'] = isset( $input['show_crumbs'] ) && $input['show_crumbs'] ? true : false;

   /* Update Typography Settings
      ========================================= */

   if ( isset( $input['text_style'] ) ) {

      // Allowed banner settingss
      $allowed_text_style_settings = array( 'inline', 'center', 'left', 'right', 'hidden' );

      // Validate Input
      $clean['text_style'] = cv_filter( $input['text_style'], $allowed_text_style_settings );

   }

   /* Update Style Scheme Setting
      ========================================= */

   if ( isset( $input['scheme_source'] ) ) {

      // Allowed banner settingss
      $allowed_scheme_source_settings = array( 'default', 'custom' );

      // Validate Input
      $clean['scheme_source'] = cv_filter( $input['scheme_source'], $allowed_scheme_source_settings );

   }

   /* Update Background Source
      ========================================= */

   if ( isset( $input['bg_image_source'] ) ) {

      // Allowed banner settingss
      $allowed_bg_image_source_settings = array( 'none', 'custom', 'preset' );

      // Validate Input
      $clean['bg_image_source'] = cv_filter( $input['bg_image_source'], $allowed_bg_image_source_settings );

   }

   /* Update Custom Background
      ========================================= */

   if ( isset( $input['bg_custom'] ) ) {

      // Validate Input
      $clean['bg_custom'] = cv_filter( $input['bg_custom'], 'integer' );

   }

   /* Update Overlay Opacity
      ========================================= */

   if ( isset( $input['overlay_opacity'] ) ) {

      // Allowed background image settings
      $allowed_overlay_opacity_settings = array( 'none' );

      for ( $i=10; $i<=90; $i+=10 ) {
         $allowed_overlay_opacity_settings[] = $i;
      }

      // Validate Input
      $clean['overlay_opacity'] = cv_filter( $input['overlay_opacity'], $allowed_overlay_opacity_settings );

   }

   /* Update Overlay Color
      ========================================= */

   if ( isset( $input['overlay_color'] ) ) {

      // Validate Input
      $clean['overlay_color'] = cv_filter( $input['overlay_color'], 'hex' );

   }

   /* Update Background Style
      ========================================= */

   if ( isset( $input['bg_style'] ) ) {

      // Allowed banner settingss
      $allowed_bg_style_settings = array( 'cover', 'tiled' );

      // Validate Input
      $clean['bg_style'] = cv_filter( $input['bg_style'], $allowed_bg_style_settings );

   }

   /* Update Background Preset
      ========================================= */

   if ( isset( $input['bg_preset'] ) ) {

      // Validate Input
      $clean['bg_preset'] = cv_filter( $input['bg_preset'], array_keys( $canvys['bg_patterns'] ) );

   }

   /* Update Background Attachment
      ========================================= */

   if ( isset( $input['bg_attachment'] ) ) {

      // Allowed banner settingss
      $allowed_bg_attachment_settings = array( 'fixed', 'scroll' );

      // Validate Input
      $clean['bg_attachment'] = cv_filter( $input['bg_attachment'], $allowed_bg_attachment_settings );

   }

   /* Update Background Color
      ========================================= */

   if ( isset( $input['bg_color'] ) ) {

      // Validate Input
      $clean['bg_color'] = cv_filter( $input['bg_color'], 'hex' );

   }

   /* Update typography Color
      ========================================= */

   if ( isset( $input['text_color'] ) ) {

      // Validate Input
      $clean['text_color'] = cv_filter( $input['text_color'], 'hex' );

   }

   /* Update custom height
      ========================================= */

   if ( isset( $input['custom_height'] ) ) {

      // Validate Input
      $clean['custom_height'] = cv_filter( $input['custom_height'], 'integer' );

   }

   /* Update Display Title
      ========================================= */

   if ( isset( $input['display_title'] ) ) {

      // Sanitize the value
      $display_title = strip_tags( $input['display_title'], '<b><u><i><strong>' );
      $display_title = stripslashes( $display_title );

      $clean['display_title'] = $display_title;

   }

   /* Update Description
      ========================================= */

   if ( isset( $input['display_description'] ) ) {

      // Sanitize the value
      $display_description = strip_tags( $input['display_description'], '<b><u><i><strong>' );
      $display_description = stripslashes( $display_description );

      $clean['display_description'] = $display_description;

   }

   // Finally, update the setting
   update_post_meta( $post_id, '_cv_banner_settings', $clean );

}
endif;