<?php

global $post;

// Create the configuration array
$banner_config = array(
   'text_style'      => cv_theme_setting( 'header', 'banner_text_style', 'inline' ),
   'show_crumbs'     => cv_theme_setting( 'header', 'banner_show_crumbs', true ),
   'scheme_source'   => cv_theme_setting( 'header', 'banner_scheme_source', 'main' ),
   'custom_height'   => cv_theme_setting( 'header', 'banner_custom_height' ),
   'text_color'      => cv_theme_setting( 'header', 'banner_text_color' ),
   'bg_color'        => cv_theme_setting( 'header', 'banner_bg_color' ),
   'bg_image_source' => cv_theme_setting( 'header', 'banner_bg_image_source', 'none' ),
   'bg_preset'       => cv_theme_setting( 'header', 'banner_bg_preset', 'shattered' ),
   'bg_custom'       => cv_theme_setting( 'header', 'banner_bg_custom' ),
   'bg_style'        => cv_theme_setting( 'header', 'banner_bg_style', 'cover' ),
   'bg_attachment'   => cv_theme_setting( 'header', 'banner_bg_attachment', 'scroll' ),
   'overlay_opacity' => cv_theme_setting( 'header', 'banner_overlay_opacity', 'none' ),
   'overlay_color'   => cv_theme_setting( 'header', 'banner_overlay_color' ),
);

// Grab the current post ID
$post_ID = ! is_search() && isset( $post ) && get_the_ID() ? get_the_ID() : '';

// When viewing the blog page, change the ID to reflect this
if ( 'page' === get_option( 'show_on_front' ) && ( $posts_page_id = get_option( 'page_for_posts' ) ) && is_home() ) {
   $post_ID = $posts_page_id;
}

// If settings have been overwritten
if ( $post_ID ) {

   // Grab the banner meta settings
   $custom_settings = get_post_meta( $post_ID, '_cv_banner_settings', true );
   $display_setting = isset( $custom_settings['display'] ) ? $custom_settings['display'] : 'default';

   if ( 'default' == $display_setting ) {

      // Allow single posts to match the blog page
      if ( ( is_single() || is_archive() ) && 'post' == get_post_type() ) {
         if ( in_array( cv_theme_setting( 'blog', 'banner_behavior', 'default' ), array( 'blog_page', 'blog_page-hidden') ) ) {
            $blog_page = cv_theme_setting( 'blog', 'blog_page' );
            if ( $blog_page && 'none' != $blog_page ) {
               $custom_settings = get_post_meta( $blog_page, '_cv_banner_settings', true );
               $display_setting = isset( $custom_settings['display'] ) ? $custom_settings['display'] : 'default';
            }
         }
      }

      // Allow portfolio items to match the portfolio page
      if ( is_single() && 'portfolio_item' == get_post_type() ) {
         if ( in_array( cv_theme_setting( 'portfolio', 'banner_behavior', 'default' ), array( 'portfolio_page', 'portfolio_page-hidden') ) ) {
            $portfolio_page = cv_theme_setting( 'portfolio', 'portfolio_page' );
            if ( $portfolio_page && 'none' != $portfolio_page ) {
               $custom_settings = get_post_meta( $portfolio_page, '_cv_banner_settings', true );
               $display_setting = isset( $custom_settings['display'] ) ? $custom_settings['display'] : 'default';
               $custom_settings['custom_height'] = 0;
            }
         }
      }

   }

   if ( 'custom' == $display_setting ) {

      $banner_config['scheme_source'] = 'custom';
      foreach ( $banner_config as $setting => $current_value ) {
         if ( isset( $custom_settings[$setting] ) ) {
            $banner_config[$setting] = $custom_settings[$setting];
         }
      }
   }

}

// Extract the configuration variables
extract( apply_filters( 'cv_banner_config', $banner_config ) );

// Do not display the banner
if ( 'custom' != $scheme_source && 'hidden' == $text_style ) {
   return;
}

// Allows banner to be disabled on single pages
if ( is_single() && 'post' == get_post_type() && in_array( cv_theme_setting( 'blog', 'banner_behavior', 'default' ), array( 'hidden', 'blog_page-hidden' ) ) ) {
   $text_style = 'hidden';
}

// Allows banner to be disabled on single pages
if ( is_single() && 'portfolio_item' == get_post_type() && in_array( cv_theme_setting( 'portfolio', 'banner_behavior', 'default' ), array( 'hidden', 'portfolio_page-hidden' ) ) ) {
   $text_style = 'hidden';
}

// Do not display text if there is no title
if ( ! cv_get_banner_title() ) {
   $text_style = 'hidden';
}

// Create the banner object
$banner = new CV_HTML( '<div>', array(
   'class' => 'top-banner',
   'id'    => 'top-banner',
) );

// Apply the overlay style
if ( 'custom' == $scheme_source && 'custom' == $bg_image_source && 'none' !== $overlay_opacity && $overlay_color ) {
   $overlay_opacity = $overlay_opacity / 100;
   $box_shadow = 'inset ' . cv_hex_to_rgba( $overlay_color, $overlay_opacity ) . ' 0px 0px 0px 5000px';
   $banner->css( array(
      '-webkit-box-shadow' => $box_shadow,
      'box-shadow' => $box_shadow,
   ) );
}

// Add the banner content
if ( 'hidden' != $text_style ) {

   $parallax_class = 'inline' == $text_style ? null : 'cv-parallax-content';
   $parallax_class = apply_filters( 'cv_banner_parallax_class', $parallax_class );
   $parallax_class = $parallax_class ? ' class="' . $parallax_class . '"' : null;

   $content  = '<div' . $parallax_class . '>';
   $content .= '<div class="wrap has-clearfix">';
   $content .= '<div class="cv-user-font has-clearfix">';

   // Add the page title
   $scaling_class = 'inline' == $text_style ? null : ' cv-scaling-typography';
   $scaling_data  = 'inline' == $text_style ? null : ' data-max="50"';
   $content .= '<div class="banner-title has-clearfix' . $scaling_class . '"' . $scaling_data . '>' . cv_get_banner_title() . '</div>';

   // Add the bread crumbs
   if ( $show_crumbs && cv_get_bread_crumbs() ) {
      $content .= '<ul class="bread-crumbs">';
      $content .= cv_get_bread_crumbs();
      $content .= '</ul>';
   }

   $content .= '</div>';
   $content .= '</div>';
   $content .= '</div>';

   $banner->append( $content );

}

// Apply the text style class
$banner->add_class( 'text-style-' . $text_style );

// Apply the style source class
$banner->add_class( 'style-source-' . $scheme_source );

// Apply custom styles, if specified
if ( 'custom' == $scheme_source ) {

   $banner->add_class( 'v-align-middle' );

   // Apply the typography color
   if ( ! $text_color ) $text_color = '#000000';
   $banner->css( 'color', $text_color . ' !important' );
   $banner->add_class( 'has-custom-color' );

   // Apply custom height
   if ( 0 === $custom_height ) $custom_height = '0';
   if ( '' != $custom_height ) {
      $banner->css( 'height', $custom_height . 'px' );
   }

   // Apply the background color
   if ( ! $bg_color ) $bg_color = '#ffffff';
   $banner->add_class( 'has-custom-bg' );
   $banner->add_class( 'has-custom-bg-color' );
   $banner->css( 'background-color', $bg_color . ' !important' );

   // Apply the background image
   if ( 'none' != $bg_image_source ) {

      // Apply custom bg classes
      $banner->add_class( 'has-custom-bg' );
      $banner->add_class( 'has-custom-bg-image' );

      if ( 'custom' == $bg_image_source ) {

         // Apply the loading class
         $banner->add_class('is-loading');

         // Create box shadow CSS
         $box_shadow = 'inset ' . $bg_color . ' 0px 0px 0px 5000px !important';
         $box_shadow = '-webkit-box-shadow:' . $box_shadow . ';box-shadow:' . $box_shadow . ';'

         // Render the loading styles
         ?><script id="top-banner-inline-script">

            var css = '#top-banner.is-loading {<?php echo $box_shadow; ?>}',
                style = document.createElement('style');

            if ( style.styleSheet ){
               style.styleSheet.cssText = css;
            }
            else {
               style.appendChild( document.createTextNode( css ) );
            }

            // Add the new style rules
            document.head.appendChild( style );

            // Remove this node
            var element = document.getElementById('top-banner-inline-script');
            element.parentNode.removeChild(element);

         </script><?php

      }

      // Apply image attachment setting
      $banner->css( 'background-attachment', $bg_attachment );

      switch ( $bg_image_source ) {

         case 'preset':

            // See if an image preset was supplied
            if ( $bg_preset ) {

               // Apply the image
               $banner->css( array(
                  'background-image' => 'url(' . THEME_DIR . 'assets/img/patterns/' . $bg_preset . '.png)',
                  'background-position' => 'center center',
               ) );

            }

            break;

         case 'custom':

            // See if an image was supplied
            if ( $bg_custom ) {

               // If a URL is being supplied
               if( filter_var( $bg_custom, FILTER_VALIDATE_URL ) ) {
                  $img_url = $bg_custom;
               }

               // If an ID is being supplied
               else {

                  // Grab the image data
                  $img_data = wp_get_attachment_image_src( $bg_custom, 'full' );
                  $img_url = $img_data[0];

               }

               // Apply the background image
               if ( $img_url ) {

                  // Apply the image
                  $banner->css( array(
                     'background-image' => 'url(' . $img_url . ')',
                     'background-position' => 'center center',
                  ) );

                  // Apply the background style setting
                  if ( 'tiled' != $bg_style ) {
                     $banner->css( 'background-size', 'cover' );
                  }

               }

            }

            break;

      }

   }


}

// Render the banner
echo $banner;