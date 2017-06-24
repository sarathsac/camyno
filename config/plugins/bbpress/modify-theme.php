<?php

if ( ! function_exists('cv_bbpress_modify_button_color') ) :

/**
 * Function to modify the color of bbPress search butons
 *
 * @return string
 */
function cv_bbpress_modify_button_color() { ?>
   <script>
   ;(function($) {
      $(document).ready( function() {
         $('[id="bbp_search_submit"]').addClass('color-accent');
      })
   })(jQuery);
   </script>
<?php }

add_action( 'wp_footer', 'cv_bbpress_modify_button_color' );

endif;

/* ===================================================================== *
 * Modify banner title
 * ===================================================================== */

if ( ! function_exists( 'cv_bbpress_modify_banner_title' ) ) :

/**
 * Function to modify the output of the banner title on bbpress pages
 *
 * @return string
 */
function cv_bbpress_modify_banner_title( $title ) {

   if ( is_bbpress() ) {

      if ( $forum_page = get_page_by_path( bbp_get_root_slug() ) ) {

         // Get the current values
         $values = get_post_meta( $forum_page->ID, '_cv_banner_settings', true );
         $display_title = isset( $values['display_title'] ) ? $values['display_title'] : null;
         $display_description = isset( $values['display_description'] ) ? $values['display_description'] : null;

         // Determine which title to show
         $title = $display_title ? $display_title : get_the_title();

         $title = '<h3>' . $title . '</h3>';

         if ( bbp_is_forum_archive() && $display_description ) {
            $title .= '<h5>' . $display_description . '</h5>';
         }

      }

      else {
         $title = '<h3>' . __( 'Forums', 'canvys' ) . '</h3>';
      }

   }

   return $title;

}

add_filter( 'cv_banner_title', 'cv_bbpress_modify_banner_title' );

endif;

/* ===================================================================== *
 * Modify bread crumbs
 * ===================================================================== */

if ( ! function_exists( 'cv_bbpress_modify_bread_crumbs' ) ) :

/**
 * Function to modify the output of the banner title on bbpress pages
 *
 * @return string
 */
function cv_bbpress_modify_bread_crumbs( $crumbs ) {

   if ( is_bbpress() ) {

      // Display link to home page
      $crumbs = '<li><a href="' . home_url() . '">' . __( 'Home', 'canvys' ) . '</a></li>';

      // Display bbPress breadcrumbs
      $crumbs .= bbp_get_breadcrumb( array(
         'sep'=> '&ensp;',
         'crumb_before' => '<li>',
         'crumb_after' => '</li>',
         'before' => '',
         'after' => '',
         'include_home' => false
      ) );

   }

   return $crumbs;

}

add_filter( 'cv_bread_crumbs', 'cv_bbpress_modify_bread_crumbs' );

endif;

/* ===================================================================== *
 * Modify banner configuration
 * ===================================================================== */

if ( ! function_exists( 'cv_bbpress_modify_banner_config' ) ) :

/**
 * Function to modify how the banner is styled
 *
 * @return array
 */
function cv_bbpress_modify_banner_config( $banner_config ) {

   if ( is_bbPress() && 'forum_page' == cv_theme_setting( 'bbpress', 'banner_behavior' ) && $forum_page = get_page_by_path( bbp_get_root_slug() ) ) {

      // Grab the ID of the forum page
      $forum_page_id = $forum_page->ID;

      // Grab the banner meta settings
      $custom_settings = get_post_meta( $forum_page_id, '_cv_banner_settings', true );
      $display_setting = isset( $custom_settings['display'] ) ? $custom_settings['display'] : 'default';

      if ( 'custom' == $display_setting ) {

         $banner_config['scheme_source'] = 'custom';
         foreach ( $banner_config as $setting => $current_value ) {
            if ( isset( $custom_settings[$setting] ) ) {
               $banner_config[$setting] = $custom_settings[$setting];
            }
         }
      }

   }

   return $banner_config;

}

add_filter( 'cv_banner_config', 'cv_bbpress_modify_banner_config' );

endif;

/* ===================================================================== *
 * Modify banner state conditional
 * ===================================================================== */

if ( ! function_exists( 'cv_bbpress_modify_is_baner_active' ) ) :

/**
 * Function to modify whether or not the banner is active
 *
 * @return bool
 */
function cv_bbpress_modify_is_baner_active( $is_active ) {

   // Product archive page
   if ( is_bbPress() && 'forum_page' == cv_theme_setting( 'bbpress', 'banner_behavior' ) && $forum_page = get_page_by_path( bbp_get_root_slug() ) ) {

      // Grab the ID of the forum page
      $forum_page_id = $forum_page->ID;

      // Grab the banner meta settings
      $custom_settings = get_post_meta( $forum_page_id, '_cv_banner_settings', true );
      $display_setting = isset( $custom_settings['display'] ) ? $custom_settings['display'] : 'default';

      if ( 'hide' == $display_setting ) return false;

   }

   return $is_active;

}

add_filter( 'cv_is_baner_active', 'cv_bbpress_modify_is_baner_active' );

endif;

/* ===================================================================== *
 * Modify header transparency conditional
 * ===================================================================== */

if ( ! function_exists( 'cv_bbpress_modify_is_header_transparent' ) ) :

/**
 * Function to modify header transparency color
 *
 * @return bool
 */
function cv_bbpress_modify_is_header_transparent( $is_active ) {

   if ( is_bbPress() && 'forum_page' == cv_theme_setting( 'bbpress', 'banner_behavior' ) && $forum_page = get_page_by_path( bbp_get_root_slug() ) ) {

      // Grab the ID of the forum page
      $forum_page_id = $forum_page->ID;

      // Check if settings were overwritten
      $cv_meta = get_post_meta( $forum_page_id, '_cv_page_settings', true );
      if ( isset( $cv_meta['transparency'] ) ) {
         switch ( $cv_meta['transparency'] ) {
            case 'enabled':  return true; break;
            case 'custom':   return true; break;
            case 'disabled': return false; break;
         }
      }

   }

   return $is_active;

}

add_filter( 'cv_is_header_transparent', 'cv_bbpress_modify_is_header_transparent' );

endif;

/* ===================================================================== *
 * Modify header glassy conditional
 * ===================================================================== */

if ( ! function_exists( 'cv_bbpress_modify_is_header_glassy' ) ) :

/**
 * Function to modify header glassy color
 *
 * @return bool
 */
function cv_bbpress_modify_is_header_glassy( $is_glassy ) {

   if ( is_bbPress() && 'forum_page' == cv_theme_setting( 'bbpress', 'banner_behavior' ) && $forum_page = get_page_by_path( bbp_get_root_slug() ) ) {

      // Grab the ID of the forum page
      $forum_page_id = $forum_page->ID;

      // Check if settings were overwritten
      $cv_meta = get_post_meta( $forum_page_id, '_cv_page_settings', true );
      if ( isset( $cv_meta['transparency'] ) && 'custom' == $cv_meta['transparency'] ) {
         return isset( $cv_meta['transparency_glassy'] ) && $cv_meta['transparency_glassy'];
      }

   }

   return $is_glassy;

}

add_filter( 'cv_is_header_glassy', 'cv_bbpress_modify_is_header_glassy' );

endif;

/* ===================================================================== *
 * Modify header transparency color
 * ===================================================================== */

if ( ! function_exists( 'cv_bbpress_modify_header_transparency_color' ) ) :

/**
 * Function to modify header transparency color
 *
 * @return string
 */
function cv_bbpress_modify_header_transparency_color( $color ) {

   if ( is_bbPress() && 'forum_page' == cv_theme_setting( 'bbpress', 'banner_behavior' ) && $forum_page = get_page_by_path( bbp_get_root_slug() ) ) {

      // Grab the ID of the forum page
      $forum_page_id = $forum_page->ID;

      // Check if settings were overwritten
      $cv_meta = get_post_meta( $forum_page_id, '_cv_page_settings', true );
      if ( isset( $cv_meta['transparency'] ) && 'custom' == $cv_meta['transparency'] ) {
         $color = isset( $cv_meta['transparency_color'] ) && $cv_meta['transparency_color'] ? $cv_meta['transparency_color'] : $color;
      }

   }

   return $color;

}

add_filter( 'cv_header_transparency_color', 'cv_bbpress_modify_header_transparency_color' );

endif;

/* ===================================================================== *
 * Modify header transparency logo
 * ===================================================================== */

if ( ! function_exists( 'cv_bbpress_modify_header_transparency_logo' ) ) :

/**
 * Function to modify the header transparency logo
 *
 * @return bool
 */
function cv_bbpress_modify_header_transparency_logo( $transparent_logo ) {

   if ( is_bbPress() && 'forum_page' == cv_theme_setting( 'bbpress', 'banner_behavior' ) && $forum_page = get_page_by_path( bbp_get_root_slug() ) ) {

      // Grab the ID of the forum page
      $forum_page_id = $forum_page->ID;

      // Grab the meta information, if any
      $cv_meta = get_post_meta( $forum_page_id, '_cv_page_settings', true );

      // If custom settings are enabled
      if ( isset( $cv_meta['transparency'] ) && 'custom' == $cv_meta['transparency'] ) {
         if ( isset( $cv_meta['transparency_logo'] ) ) {
            $img_data = wp_get_attachment_image_src( $cv_meta['transparency_logo'], 'full' );
            $transparent_logo = $img_data ? $img_data[0] : $transparent_logo;
         }
      }

   }

   return $transparent_logo;

}

add_filter( 'cv_header_transparency_logo', 'cv_bbpress_modify_header_transparency_logo' );

endif;