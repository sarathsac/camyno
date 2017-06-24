<?php

if ( ! function_exists( 'cv_banner_settings_meta_box' ) ) :

/**
 * Helper function to display the banner settings meta box
 *
 * @return nothing
 */
function cv_banner_settings_meta_box( $post, $metabox ) {

   global $canvys;

   // Get the current values
   $values = get_post_meta( $post->ID, '_cv_banner_settings', true );

   /* Banner Setting
      ========================================= */

   // Allowed banner settings
   $display_options = array(
      'default' => __( 'Default settings', 'canvys' ),
      'hide'    => __( 'Hide the banner', 'canvys' ),
      'custom'  => __( 'Custom settings', 'canvys' ),
   );

   // Determine if the banner value exists
   $display = isset( $values['display'] ) ? cv_filter( $values['display'], array_keys( $display_options ) ) : 'default';

   /* Typography Style Settings
      ========================================= */

   // Allowed background image settings
   $text_style_options = array(
      'inline' => __( 'Inline, on a single line', 'canvys' ),
      'center' => __( 'Centered, on multiple lines', 'canvys' ),
      'left'   => __( 'Left aligned, on multiple lines', 'canvys' ),
      'right'  => __( 'Right aligned, on multiple lines', 'canvys' ),
      'hidden' => __( 'Hidden, do not display textual information', 'canvys' ),
   );

   // Determine if the banner value exists
   $text_style = isset( $values['text_style'] ) ? cv_filter( $values['text_style'], array_keys( $text_style_options ) ) : 'default';

   /* Enable Breadcrumbg Setting
      ========================================= */

   // Determine if the value exists
   $show_crumbs = isset( $values['show_crumbs'] ) && $values['show_crumbs'] ? true : false;

   /* Background Image Source Settings
      ========================================= */

   // Allowed background image settings
   $bg_image_source_options = array(
      'none'    => __( 'No Background Image', 'canvys' ),
      'custom'  => __( 'Custom image', 'canvys' ),
      'preset'  => __( 'Background preset', 'canvys' ),
   );

   // Determine if the banner value exists
   $bg_image_source = isset( $values['bg_image_source'] ) ? cv_filter( $values['bg_image_source'], array_keys( $bg_image_source_options ) ) : 'none';

   /* Background Image Attachment Settings
      ========================================= */

   // Allowed background image settings
   $bg_attachment_options = array(
      'scroll' => __( 'Scroll, background image will scroll with page', 'canvys' ),
      'fixed'  => __( 'Fixed, background image will remain fixed in place', 'canvys' ),
   );

   // Determine if the banner value exists
   $bg_attachment = isset( $values['bg_attachment'] ) ? cv_filter( $values['bg_attachment'], array_keys( $bg_attachment_options ) ) : 'none';

   /* Background Custom Image Settings
      ========================================= */

   // Determine if the background preset value exists
   $bg_custom = isset($values['bg_custom']) ? $values['bg_custom'] : null;

   /* Foreground overlay opacity options
      ========================================= */

   // Allowed background image settings
   $overlay_opacity_options = array(
      'none' => __( 'None, do not display an overlay color', 'canvys' ),
   );

   for ( $i=10; $i<=90; $i+=10 ) {
      $overlay_opacity_options[$i] = $i . '%';
   }

   // Determine if the banner value exists
   $overlay_opacity = isset( $values['overlay_opacity'] ) ? cv_filter( $values['overlay_opacity'], array_keys( $overlay_opacity_options ) ) : 'none';

   /* Foreground overlay color
      ========================================= */

   // Determine if the background color value exists
   $overlay_color = isset($values['overlay_color']) ? $values['overlay_color'] : null;

   /* Background Image Attachment Settings
      ========================================= */

   // Allowed background image settings
   $bg_style_options = array(
      'cover' => __( 'Automatic, image will be scaled to cover the banner', 'canvys' ),
      'tiled' => __( 'Tiled, image will be tiled to cover the banner', 'canvys' ),
   );

   // Determine if the banner value exists
   $bg_style = isset( $values['bg_style'] ) ? cv_filter( $values['bg_style'], array_keys( $bg_style_options ) ) : 'none';

   /* Background Custom image
      ========================================= */

   // Determine if the background preset value exists
   $bg_custom = isset($values['bg_custom']) ? $values['bg_custom'] : null;

   /* Background Preset Settings
      ========================================= */

   // Determine if the background preset value exists
   $bg_preset = isset($values['bg_preset']) ? $values['bg_preset'] : null;

   /* Background Color Settings
      ========================================= */

   // Determine if the background color value exists
   $bg_color = isset($values['bg_color']) ? $values['bg_color'] : null;

   /* Typography Color Settings
      ========================================= */

   // Determine if the typography color value exists
   $text_color = isset($values['text_color']) ? $values['text_color'] : null;

   /* Custom Height Settings
      ========================================= */

   // Determine if the display title value exists
   $custom_height = isset($values['custom_height']) ? $values['custom_height'] : null;

   /* Display Title Settings
      ========================================= */

   // Determine if the display title value exists
   $display_title = isset($values['display_title']) ? $values['display_title'] : null;

   /* Description Settings
      ========================================= */

   // Determine if the description value exists
   $display_description = isset($values['display_description']) ? $values['display_description'] : null;

   // WP Nonce for security
   wp_nonce_field( 'cv_banner_settings_meta_box_update_action', 'cv_banner_settings_meta_box_nonce' ); ?>

   <div class="cv-page-settings-box">

      <table class="form-table cv-banner-settings-form-table" id="cv-banner-settings-form-table">

         <!-- * Display Title
              * =========================================== -->

         <tr id="cv_banner_display_title_control_wrap">
            <th>
               <p><label for="cv_banner_display_title"><strong><?php _e('Display Title', 'canvys'); ?></strong></label></p>
            </th>
            <td>
               <p>
                  <input type="text" class="regular-text" id="cv_banner_display_title" name="_cv_banner_settings[display_title]" value="<?php echo $display_title; ?>" />
               </p>
               <p class="description"><?php _e( 'The display title will only be shown in the banner area, if this is left blank the actual title will be used.', 'canvys' ); ?></p>
            </td>
         </tr>

         <!-- * Display Description
              * =========================================== -->

         <tr id="cv_banner_description_control_wrap">
            <th>
               <p><label for="cv_banner_display_description"><strong><?php _e('Description', 'canvys'); ?></strong></label></p>
            </th>
            <td>
               <p>
                  <input type="text" class="regular-text" id="cv_banner_display_description" name="_cv_banner_settings[display_description]" value="<?php echo $display_description; ?>" />
               <p class="description"><?php _e( 'Optionally enter a short description for this page, will be displayed adjacent to the display title in the banner.', 'canvys' ); ?></p>
               </p>
            </td>
         </tr>


         <!-- * Display Settings
              * =========================================== -->

         <tr id="cv_banner_display_control_wrap" class="no-border">

            <th>
               <p><label for="cv_banner_display"><strong><?php _e('Display Settings', 'canvys'); ?></strong></label></p>
            </th>

            <td>
               <p>
                  <select id="cv_banner_display" name="_cv_banner_settings[display]">
                     <?php foreach ( $display_options as $key => $name ) {
                        echo '<option value="' . $key . '" ' . selected( $key, $display, false) . '>' . $name . '</option>';
                     } ?>
                  </select>
               </p>
               <p class="description"><?php _e( 'Default banner settings can be set in Appearance > Theme Settings > Header > Banner.', 'canvys' ); ?></p>
            </td>

         </tr>

         <!-- * Typography Style
              * =========================================== -->

         <tr id="cv_banner_text_style_control_wrap" class="custom-settings-option">

            <th>
               <p><label for="cv_banner_text_style"><strong><?php _e('Typography Style', 'canvys'); ?></strong></label></p>
            </th>

            <td>
               <p>
                  <select id="cv_banner_text_style" name="_cv_banner_settings[text_style]">
                     <?php foreach ( $text_style_options as $key => $name ) {
                        echo '<option value="' . $key . '" ' . selected( $key, $text_style, false) . '>' . $name . '</option>';
                     } ?>
                  </select>
               </p>
               <p class="description"><?php _e( 'Specify how the title/description should be displayed within the banner, if at all.', 'canvys' ); ?></p>

               <?php $hidden = 'hidden' == $text_style ? ' style="display: none;"' : null; ?>
               <div id="cv_banner_show_crumbs-wrap"<?php echo $hidden; ?>>

                  <hr style="margin:25px 0;" />

                  <p><strong><?php _e('Display Breadcrumbs', 'canvys'); ?></strong></p>
                  <p>
                     <label for="cv_banner_show_crumbs">
                        <input value="enabled" type="checkbox" id="cv_banner_show_crumbs" name="_cv_banner_settings[show_crumbs]" <?php checked( $show_crumbs ); ?> />
                        <?php _e('Display bread crumbs in the banner when applicable.', 'canvys'); ?>
                     </label>
                  </p>

               </div>

            </td>

         </tr>

         <!-- * Custom Height
              * =========================================== -->

         <tr id="cv_banner_height_control_wrap" class="custom-settings-option">
            <th>
               <p><label for="cv_banner_height"><strong><?php _e('Custom Height', 'canvys'); ?></strong></label></p>
            </th>
            <td>
               <p>
                  <input type="text" class="regular-text code" id="cv_banner_height" name="_cv_banner_settings[custom_height]" value="<?php echo $custom_height; ?>" />
               </p>
               <p class="description"><?php _e( 'Specify a custom height for the banner, only enter a numeric value in pixels. If header transparency is enabled then the height of the header will be added to the height of the banner automatically.', 'canvys' ); ?></p>
            </td>
         </tr>

         <!-- * Background Color
              * =========================================== -->

         <tr id="cv_banner_bg_color_control_wrap" class="custom-settings-option">
            <th>
               <p><label for="cv_banner_bg_color"><strong><?php _e('Background Color', 'canvys'); ?></strong></label></p>
            </th>
            <td>
               <p>
                  <input type="text" class="cv-color-picker" id="cv_banner_bg_color" name="_cv_banner_settings[bg_color]" value="<?php echo $bg_color; ?>" />
               </p>
               <p class="description"><?php _e( 'Optionally select a background color to be used for the banner. <strong>Pro Tip: When using a background image set this color to one remotely similar to the overall image, this way as the image is loading the color will be visible.</strong>', 'canvys' ); ?></p>
            </td>
         </tr>

         <!-- * Typography Color
              * =========================================== -->

         <tr id="cv_banner_text_color_control_wrap" class="custom-settings-option">
            <th>
               <p><label for="cv_banner_text_color"><strong><?php _e('Typography Color', 'canvys'); ?></strong></label></p>
            </th>
            <td>
               <p>
                  <input type="text" class="cv-color-picker" id="cv_banner_text_color" name="_cv_banner_settings[text_color]" value="<?php echo $text_color; ?>" />
               </p>
               <p class="description"><?php _e( 'Optionally select a color to be used for the banner typography.', 'canvys' ); ?></p>
            </td>
         </tr>

         <!-- * Background Image Source
              * =========================================== -->

         <tr id="cv_banner_bg_image_source_control_wrap" class="custom-settings-option">

            <th>
               <p><label for="cv_banner_bg_image_source"><strong><?php _e('Background Image', 'canvys'); ?></strong></label></p>
            </th>

            <td>

               <p>
                  <select id="cv_banner_bg_image_source" name="_cv_banner_settings[bg_image_source]">
                     <?php foreach ( $bg_image_source_options as $key => $name ) {
                        echo '<option value="' . $key . '" ' . selected( $key, $bg_image_source, false) . '>' . $name . '</option>';
                     } ?>
                  </select>
               </p>
               <p class="description"><?php _e( 'Select the source for the banner\'s background image.', 'canvys' ); ?></p>

               <div class="image-controls" data-source="<?php echo $bg_image_source; ?>">

                  <!-- * Background Custom Image
                       * =========================================== -->

                  <?php $has_image = $bg_custom ? ' class="has-image"' : null; ?>
                  <div id="cv_banner_bg_custom_control_wrap" <?php echo $has_image; ?>>
                     <hr style="margin:25px 0;" />
                     <p><label for="cv_banner_bg_custom"><strong><?php _e('Custom Image', 'canvys'); ?></strong></label></p>
                     <div class="cv_banner_bg_custom_preview" id="cv_banner_bg_custom_preview">
                     <?php if ( $img_data = wp_get_attachment_image_src( $bg_custom, 'large' ) ) {
                        $url = $img_data[0];
                     } else {
                        $url = null;
                     } ?>
                     <img src="<?php echo $url; ?>" alt="<?php _e( 'Image URL is broken', 'canvys' ); ?>" />
                     </div>
                     <input type="hidden" id="cv_banner_bg_custom" name="_cv_banner_settings[bg_custom]" value="<?php echo $bg_custom; ?>" />
                     <p>
                        <a class="button" id="cv_banner_bg_custom_select_image"><?php _e( 'Select Image', 'canvys' ); ?></a>
                        <a class="button" id="cv_banner_bg_custom_remove_image"><?php _e( 'Remove Image', 'canvys' ); ?></a>
                     </p>
                     <p class="description"><?php _e( 'Select a custom image for the banner\'s background.', 'canvys' ); ?></p>

                     <div id="cv_banner_bg_style_control_wrap">
                        <hr style="margin:25px 0;" />
                        <p><label for="cv_banner_bg_style"><strong><?php _e('Background Image Style', 'canvys'); ?></strong></label></p>
                        <p>
                           <select id="cv_banner_bg_style" name="_cv_banner_settings[bg_style]">
                              <?php foreach ( $bg_style_options as $key => $name ) {
                                 echo '<option value="' . $key . '" ' . selected( $key, $bg_style, false) . '>' . $name . '</option>';
                              } ?>
                           </select>
                        </p>
                        <p class="description"><?php _e( 'Select how the background image should be displayed.', 'canvys' ); ?></p>
                     </div>

                     <hr style="margin:25px 0;" />
                     <p><label for="cv_banner_overlay_opacity"><strong><?php _e('Foreground Overlay Opacity', 'canvys'); ?></strong></label></p>
                     <p>
                        <select id="cv_banner_overlay_opacity" name="_cv_banner_settings[overlay_opacity]">
                           <?php foreach ( $overlay_opacity_options as $key => $name ) {
                              echo '<option value="' . $key . '" ' . selected( $key, $overlay_opacity, false) . '>' . $name . '</option>';
                           } ?>
                        </select>
                     </p>
                     <p class="description"><?php _e( 'Specify whether or not a color should be overlayed on top of the banner, and at what opacity.', 'canvys' ); ?></p>

                     <div id="cv_banner_overlay_color-wrap">

                        <hr style="margin:25px 0;" />
                        <p><label for="cv_banner_overlay_color"><strong><?php _e('Foreground Overlay Color', 'canvys'); ?></strong></label></p>
                        <p>
                           <input type="text" class="cv-color-picker" id="cv_banner_overlay_color" name="_cv_banner_settings[overlay_color]" value="<?php echo $overlay_color; ?>" />
                        </p>
                        <p class="description"><?php _e( 'Specify a color to be overlayed on top of the banner.', 'canvys' ); ?></p>

                     </div>

                  </div>

                  <!-- * Background Image Presets
                       * =========================================== -->

                  <div id="cv_banner_bg_preset_control_wrap">
                     <hr style="margin:25px 0;" />
                     <p><strong><?php _e('Background Presets', 'canvys'); ?></strong></p>
                     <p>
                        <div id="cv-background-presets" class="cv-background-presets">
                           <ul class="cv-grid-5 has-clearfix spacing-1">
                              <?php foreach ( $canvys['bg_patterns'] as $preset => $title ) {
                                 $url = THEME_DIR . 'assets/img/patterns/' . $preset . '.png';
                                 $quick_preview_style = ' style="background-image:url(' . $url . ');"';
                                 $id = 'cv_banner_bg_preset_option-' . $preset;
                                 echo '<li class="background-preset-option">';
                                 echo '<input type="radio" id="' . $id . '" name="_cv_banner_settings[bg_preset]" value="' . $preset . '" ' . checked( $preset, $bg_preset, false ) . ' />';
                                 echo '<label for="' . $id . '">';
                                 echo '<strong><i class="icon-circle-empty"></i><i class="icon-circle"></i>' . $title . '</strong>';
                                 echo '<div class="quick-preview"' . $quick_preview_style . '></div>';
                                 echo '</label>';
                                 echo '</li>';
                              } ?>
                           </ul>
                        </div>
                     </p>
                  </div>

                  <!-- * Background Image Attachment
                       * =========================================== -->

                  <div id="cv_banner_bg_attachment_control_wrap">
                     <hr style="margin:25px 0;" />
                     <p><label for="cv_banner_bg_attachment"><strong><?php _e('Background Image Attachment', 'canvys'); ?></strong></label></p>
                     <p>
                        <select id="cv_banner_bg_attachment" name="_cv_banner_settings[bg_attachment]">
                           <?php foreach ( $bg_attachment_options as $key => $name ) {
                              echo '<option value="' . $key . '" ' . selected( $key, $bg_attachment, false) . '>' . $name . '</option>';
                           } ?>
                        </select>
                     </p>
                     <p class="description"><?php _e( 'Specify how the banner\'s background image should behave as the page is scrolled.', 'canvys' ); ?></p>
                  </div>

               </div>
            </td>

         </tr>

      </table>

   </div>

<?php }
endif;