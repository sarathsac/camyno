<?php

if ( ! function_exists( 'cv_page_settings_meta_box' ) ) :

/**
 * Helper function to display the page settings meta box
 *
 * @return nothing
 */
function cv_page_settings_meta_box( $post, $metabox ) {

   // Get the current values
   $values = get_post_meta( $post->ID, '_cv_page_settings', true );

   /* Page Slide Setting
      ========================================= */

   // Determine if the page slide value exists
   $page_slide = isset( $values['page_slide'] ) && $values['page_slide'] ? true : false;

   // Determine if the base nav color value exists
   $page_slide_nav_base_color = isset( $values['page_slide_nav_base_color'] ) ? cv_filter( $values['page_slide_nav_base_color'], 'hex' ) : '#000000';

   // Determine if the hover nav color value exists
   $page_slide_nav_hover_color = isset( $values['page_slide_nav_hover_color'] ) ? cv_filter( $values['page_slide_nav_hover_color'], 'hex' ) : '#00000';

   // Determine if the page slide bg color value exists
   $page_slide_nav_bg_color = isset( $values['page_slide_nav_bg_color'] ) ? cv_filter( $values['page_slide_nav_bg_color'], 'hex' ) : '#ffffff';

   // Determine if the hover nav color value exists
   $page_slide_nav_labels = isset( $values['page_slide_nav_labels'] ) ? cv_filter( $values['page_slide_nav_labels'], 'text' ) : null;

   /* Header Transparency Setting
      ========================================= */

   // Allowed footer settings
   $transparency_options = array(
      'default'  => __( 'Default settings', 'canvys' ),
      'enabled'  => __( 'Enabled, with theme settings defaults', 'canvys' ),
      'custom'   => __( 'Enabled, with custom settings', 'canvys' ),
      'disabled' => __( 'Disabled', 'canvys' ),
   );

   // Determine if the footer value exists
   $transparency = isset( $values['transparency'] ) ? cv_filter( $values['transparency'], array_keys( $transparency_options ) ) : 'default';

   // Determine if the glassy setting is enabled
   $transparency_glassy = isset( $values['transparency_glassy'] ) && $values['transparency_glassy'] ? true : false;

   // Determine if the transparency logo value exists
   $transparency_logo = isset( $values['transparency_logo'] ) ? cv_filter( $values['transparency_logo'], 'integer' ) : null;

   // Determine if the transparency color value exists
   $transparency_color = isset( $values['transparency_color'] ) ? cv_filter( $values['transparency_color'], 'hex' ) : null;

   /* Footer Setting
      ========================================= */

   // Allowed footer settings
   $footer_options = array(
      'default' => __( 'Default settings', 'canvys' ),
      'socket'  => __( 'Hide socket area', 'canvys' ),
      'columns' => __( 'Hide widgetized columns', 'canvys' ),
      'both'    => __( 'Hide both widgetized columns & socket', 'canvys' ),
   );

   // Determine if the footer value exists
   $footer = isset( $values['footer'] ) ? cv_filter( $values['footer'], array_keys( $footer_options ) ) : 'default';

   /* layout Options
      ========================================= */

   // Layout options
   $layout_options = array(
      'default'       => __('Default', 'canvys'),
      'sidebar-left'  => __('Left Sidebar', 'canvys'),
      'sidebar-right' => __('Right Sidebar', 'canvys'),
      'no-sidebar'    => __('No Sidebar', 'canvys'),
   );

   // Determine if the layout value exists
   $layout = isset( $values['layout'] ) ? cv_filter( $values['layout'], array_keys( $layout_options ) ) : 'default';

   /* Sidebar Options
      ========================================= */

   // Sidebar options
   $sidebar_options = array(
      'default' => __('Default', 'canvys'),
   );

   // Fill Sidebar options array
   $user_sidebars = get_option( 'cv_sidebars' );

   // If any custom sidebars are available, create them
   if ( is_array( $user_sidebars ) ) {
      foreach ( $user_sidebars as $id => $name ) {
         $sidebar_options['cv_user_sidebar_' . $id] = $name;
      }
   }

   // Determine if the sidebar value exists
   $sidebar = isset( $values['sidebar'] ) ? cv_filter( $values['sidebar'], array_keys( $sidebar_options ) ) : 'default';

   // WP Nonce for security
   wp_nonce_field( 'cv_page_settings_meta_box_update_action', 'cv_page_settings_meta_box_nonce' ); ?>

   <div class="cv-page-settings-box">

      <!-- * Page Slide Setting
           * =========================================== -->

      <div id="cv_page_slide_control_wrap">
         <p><strong><?php _e('Content Sliding', 'canvys'); ?></strong></p>
         <p>
            <label for="cv_page_slide">
               <input value="enabled" type="checkbox" id="cv_page_slide" name="_cv_page_settings[page_slide]" <?php checked( $page_slide ); ?> />
               <?php _e('Enable full page content sliding, please note that this will comletely hide the banner area.', 'canvys'); ?>
            </label>
         </p>
      </div>

      <?php $style = $page_slide ? null : ' style="display:none;"'; ?>
      <div id="cv_page_slide_extra_controls_wrap" <?php echo $style; ?>>

            <p><label for="cv_page_slide_nav_bg_color"><strong><?php _e('Side Navigation Background Color', 'canvys'); ?></strong></label></p>
            <input class="cv-color-picker" type="text" id="cv_page_slide_nav_bg_color" name="_cv_page_settings[page_slide_nav_bg_color]" value="<?php echo $page_slide_nav_bg_color; ?>" />
            <p class="description"><?php _e( 'The background color for the side navigation, leave this blank for a transparent background.', 'canvys' ); ?></p>

            <p><label for="cv_page_slide_nav_base_color"><strong><?php _e('Side Navigation Base Color', 'canvys'); ?></strong></label></p>
            <input class="cv-color-picker" type="text" id="cv_page_slide_nav_base_color" name="_cv_page_settings[page_slide_nav_base_color]" value="<?php echo $page_slide_nav_base_color; ?>" />
            <p class="description"><?php _e( 'The base color for the page navigation buttons, leave blank to hide the page navigation completely.', 'canvys' ); ?></p>

            <p><label for="cv_page_slide_nav_hover_color"><strong><?php _e('Side Navigation Hover Color', 'canvys'); ?></strong></label></p>
            <input class="cv-color-picker" type="text" id="cv_page_slide_nav_hover_color" name="_cv_page_settings[page_slide_nav_hover_color]" value="<?php echo $page_slide_nav_hover_color; ?>" />
            <p class="description"><?php _e( 'The hover color for the page navigation buttons, leave blank to use the base color. This will also be used for the tooltips background color.', 'canvys' ); ?></p>

            <p><label for="cv_page_slide_nav_hover_color"><strong><?php _e('Side Navigation Labels', 'canvys'); ?></strong></label></p>
            <p><textarea class="widefat" id="cv_page_slide_nav_labels" name="_cv_page_settings[page_slide_nav_labels]"><?php echo $page_slide_nav_labels; ?></textarea></p>
            <p class="description"><?php _e( 'Enter a comma delimited list of labels to be used by the automatically generated page navigation buttons.', 'canvys' ); ?></p>

      </div>

      <!-- * Transparency Setting
           * =========================================== -->

      <div id="cv_transparency_control_wrap">
         <p><label for="cv_transparency"><strong><?php _e('Header Transparency', 'canvys'); ?></strong></label></p>
         <p>
            <select id="cv_transparency" name="_cv_page_settings[transparency]">
               <?php foreach ( $transparency_options as $key => $name ) {
                  echo '<option value="' . $key . '" ' . selected( $key, $transparency, false) . '>' . $name . '</option>';
               } ?>
            </select>
         </p>
         <p class="description"><?php _e( 'Default settings can be set in Appearance > Theme Settings > Header > Transparency.', 'canvys' ); ?></p>
      </div>

      <?php $style = 'custom' == $transparency ? null : ' style="display:none;"'; ?>
      <?php $class = $transparency_logo ? ' class="has-image"' : null; ?>
      <div id="cv_transparency_extra_controls_wrap" <?php echo $style . $class; ?>>

         <p><strong><?php _e('Glassy Background', 'canvys'); ?></strong></p>
         <p>
            <label for="cv_transparency_glassy">
               <input value="enabled" type="checkbox" id="cv_transparency_glassy" name="_cv_page_settings[transparency_glassy]" <?php checked( $transparency_glassy ); ?> />
               <?php _e('Enable the glassy background effect for the transparent header.', 'canvys'); ?>
            </label>
         </p>

         <div id="cv_transparency_logo_control_wrap">
            <p><label for="cv_transparency_logo"><strong><?php _e('Transparency Logo', 'canvys'); ?></strong></label></p>
            <?php $hidden = $transparency_logo ? null : ' style="display:none;"'; ?>
            <div class="cv_transparency_logo_preview" id="cv_transparency_logo_preview" <?php echo $hidden; ?>>
            <?php if ( $img_data = wp_get_attachment_image_src( $transparency_logo, 'full' ) ) {
               $url = $img_data[0];
            } else {
               $url = null;
            } ?>
            <img src="<?php echo $url; ?>" alt="<?php _e( 'Image URL is broken', 'canvys' ); ?>" />
            </div>
            <input type="hidden" id="cv_transparency_logo" name="_cv_page_settings[transparency_logo]" value="<?php echo $transparency_logo; ?>" />
            <p>
               <a class="button" id="cv_transparency_select_logo"><?php _e( 'Select Image', 'canvys' ); ?></a>
               <a class="button" id="cv_transparency_remove_logo"><?php _e( 'Remove Image', 'canvys' ); ?></a>
            </p>
            <p class="description"><?php _e( 'Transparency logo will be displayed while the header is transparent, selected image should be 360px x 170px.', 'canvys' ); ?></p>
         </div>

         <div id="cv_transparency_color_control_wrap">
            <p><label for="cv_transparency_color"><strong><?php _e('Transparency Font Color', 'canvys'); ?></strong></label></p>
            <input class="cv-color-picker" type="text" id="cv_transparency_color" name="_cv_page_settings[transparency_color]" value="<?php echo $transparency_color; ?>" />
            <p class="description"><?php _e( 'The color for the navigation items in the header, will be displayed while header is transparent.', 'canvys' ); ?></p>
         </div>

      </div>

      <!-- * Footer Settings
           * =========================================== -->

      <div id="cv_footer_control_wrap">
         <p><label for="cv_footer"><strong><?php _e('Footer Settings', 'canvys'); ?></strong></label></p>
         <p>
            <select id="cv_footer" name="_cv_page_settings[footer]">
               <?php foreach ( $footer_options as $key => $name ) {
                  echo '<option value="' . $key . '" ' . selected( $key, $footer, false) . '>' . $name . '</option>';
               } ?>
            </select>
         </p>
         <p class="description"><?php _e( 'Default footer settings can be set in Appearance > Theme Settings > Footer', 'canvys' ); ?></p>
      </div>

      <!-- * Layout Setting
           * =========================================== -->

      <div id="cv_layout_control_wrap">
         <p><label for="cv_layout"><strong><?php _e('Layout', 'canvys'); ?></strong></label></p>
         <p>
            <select id="cv_layout" name="_cv_page_settings[layout]">
               <?php foreach ( $layout_options as $key => $name ) {
                  echo '<option value="' . $key . '" ' . selected( $key, $layout, false) . '>' . $name . '</option>';
               } ?>
            </select>
         </p>
         <p class="description"><?php _e( 'Default layout can be set in Appearance > Theme Settings > Sidebars', 'canvys' ); ?></p>
      </div>

      <!-- * Sidebar Setting
           * =========================================== -->

      <?php $hidden = 'no-sidebar' == $layout ? ' style="display:none;"' : null; ?>
      <div id="cv_sidebar_control_wrap" <?php echo $hidden; ?>>
         <p><label for="cv_sidebar"><strong><?php _e('Sidebar', 'canvys'); ?></strong></label></p>
         <p>
            <select id="cv_sidebar" name="_cv_page_settings[sidebar]">
               <?php foreach ( $sidebar_options as $key => $name ) {
                  echo '<option value="' . $key . '" ' . selected( $key, $sidebar, false) . '>' . $name . '</option>';
               } ?>
            </select>
         </p>
         <p class="description"><?php _e( 'New sidebars can be created on the widgets page (Appearance > Widgets).', 'canvys' ); ?></p>
      </div>

   </div>

<?php }
endif;