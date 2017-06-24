<?php

if ( ! function_exists( 'cv_is_menu_tree_active' ) ) :

/**
 * Helper function to determine if the menu tree is active
 * only applicable if the modern inline menu is in use
 *
 * @return bool
 */
function cv_is_menu_tree_active() {

   $menu_style = cv_theme_setting( 'header', 'menu_style', 'dropdown' );

   if ( 'modern' != $menu_style ) {
      return false;
   }

   // Determine which menu location to show
   $location = is_user_logged_in() && has_nav_menu('header_menu_user') ? 'header_menu_user' : 'header_menu';

   // Grab the menu
   $menu = wp_nav_menu( array(
      'theme_location' => $location,
      'fallback_cb'    => 'cv_default_main_menu',
      'container'      => false,
      'echo'           => false,
      'depth'          => 2,
   ) );

   // Create the menu DOM object
   $menu_dom = new DOMDocument();
   $menu_dom->loadHTML( $menu );

   // grab all top level list items
   $top_level_lis = $menu_dom->getElementsByTagName('ul')->item(0)->childNodes;

   // See if current page requires special class
   foreach( $top_level_lis as $li ) {
      if ( is_a( $li, 'DOMElement' ) ) {
         $class = $li->attributes->getNamedItem("class")->value;
         if ( ( strpos( $class, 'current-menu-ancestor' ) )
         ||   ( strpos( $class, 'current_page_ancestor' ) )
         ||   ( strpos( $class, 'menu-item-has-children' ) && strpos( $class, 'current-menu-item' ) )
         ||   ( strpos( $class, 'page_item_has_children' ) && strpos( $class, 'current_page_item' ) )
         )    { return true; }
      }
   }

   return false;

}
endif;

if ( ! function_exists( 'cv_is_header_active' ) ) :

/**
 * Helper function to determine if the socket is active
 *
 * @return bool
 */
function cv_is_header_active() {
   $condition = ! is_page_template( 'template-noheader.php' ) && ! is_page_template( 'template-blank.php' );
   return apply_filters( 'cv_is_header_active', $condition );
}
endif;

if ( ! function_exists( 'cv_is_additional_bar_active' ) ) :

/**
 * Helper function to determine if the additional bar is active
 *
 * @return bool
 */
function cv_is_additional_bar_active() {

   // Check if additional text is set
   if ( cv_theme_setting( 'header', 'additional_text' ) ) return true;

   // Check if social links were enabled
   if ( cv_theme_setting( 'header', 'enable_social' )
   && 'inline' != cv_theme_setting( 'header', 'social_position', 'right' ) ) {
      if ( $profiles = cv_theme_setting( 'social', 'profiles' ) ) {
         if ( ! empty( $profiles ) ) {
            return true;
         }
      }
   }

   // Check if additional menu is active
   if ( cv_theme_setting( 'header', 'secondary_menu' ) ) {
      $location = is_user_logged_in() && has_nav_menu('secondary_menu_user') ? 'secondary_menu_user' : 'secondary_menu';
      if ( has_nav_menu( $location ) ) {
         return true;
      }
   }

   return false;

}
endif;

if ( ! function_exists( 'cv_is_footer_crumbs_active' ) ) :

/**
 * Helper function to determine if the socket is active
 *
 * @return bool
 */
function cv_is_footer_crumbs_active() {
   $is_active = cv_get_bread_crumbs() && cv_theme_setting( 'footer', 'bread_crumbs', true );
   if ( cv_is_page_slide_active() ) $is_active = false;
   if ( ! cv_is_footer_active() && ! cv_is_socket_active() ) $is_active = false;
   return apply_filters( 'cv_is_footer_crumbs_active', $is_active );
}
endif;

if ( ! function_exists( 'cv_is_socket_active' ) ) :

/**
 * Helper function to determine if the socket is active
 *
 * @return bool
 */
function cv_is_socket_active() {

   global $post;

   // Blank page template
   if ( is_page_template( 'template-blank.php' ) ) return false;

   // Check if it was disabled in the settings panel
   if ( ! cv_theme_setting( 'footer', 'enable_socket', true ) ) return false;

   // Check if it was disabled via the meta box option
   if ( isset( $post ) && get_the_ID() ) {
      $cv_meta = get_post_meta( get_the_ID(), '_cv_page_settings', true );
      if ( $cv_meta && isset( $cv_meta['footer'] ) && in_array( $cv_meta['footer'], array( 'socket', 'both' ) ) ) return false;
   }

   return apply_filters( 'cv_is_socket_active', true );

}
endif;

if ( ! function_exists( 'cv_is_footer_active' ) ) :

/**
 * Helper function to determine if the footer is active
 *
 * @return bool
 */
function cv_is_footer_active() {

   global $post;

   // Blank page template
   if ( is_page_template( 'template-blank.php' ) ) return false;

   // Check if it was disabled in the settings panel
   if ( ! cv_theme_setting( 'footer', 'enable_widgets' ) ) return false;

   // Check if it was disabled via the meta box option
   if ( isset( $post ) && get_the_ID() ) {
      $cv_meta = get_post_meta( get_the_ID(), '_cv_page_settings', true );
      if ( $cv_meta && isset( $cv_meta['footer'] ) && in_array( $cv_meta['footer'], array( 'columns', 'both' ) ) ) return false;
   }

   return apply_filters( 'cv_is_footer_active', true );

}
endif;

if ( ! function_exists( 'cv_is_page_slide_active' ) ) :

/**
 * Helper function to determine if page sliding is active
 *
 * @return bool
 */
function cv_is_page_slide_active() {
   global $post;
   if ( ! isset( $post ) ) return false;
   if ( 'advanced' !== get_post_meta( get_the_ID(), '_cv_active_editor', true ) ) return false;
   $cv_meta = get_post_meta( get_the_ID(), '_cv_page_settings', true );
   return isset( $cv_meta['page_slide'] ) ? $cv_meta['page_slide'] : false;
}
endif;

if ( ! function_exists( 'cv_is_header_sticky' ) ) :

/**
 * Helper function to determine if header is sticky
 *
 * @return bool
 */
function cv_is_header_sticky() {
   $menu_style = cv_theme_setting( 'header', 'menu_style', 'dropdown' );
   return 'modern' == $menu_style ? false : apply_filters( 'cv_is_header_sticky', cv_theme_setting( 'header', 'enable_sticky', true ) );
}
endif;

if ( ! function_exists( 'cv_is_header_collapsing' ) ) :

/**
 * Helper function to determine if header is collapsing
 *
 * @return bool
 */
function cv_is_header_collapsing() {
   return cv_is_header_sticky() ? cv_theme_setting( 'header', 'enable_collapse', true ) : false;
}
endif;

if ( ! function_exists( 'cv_is_header_transparent' ) ) :

/**
 * Helper function to determine if header transparency is active
 *
 * @return bool
 */
function cv_is_header_transparent() {

   global $post;

   // Check if custom settings were provided
   if ( ! is_search() && isset( $post ) && get_the_ID() ) {
      $cv_meta = get_post_meta( get_the_ID(), '_cv_page_settings', true );
      if ( isset( $cv_meta['transparency'] ) ) {
         switch ( $cv_meta['transparency'] ) {
            case 'enabled':  return true; break;
            case 'custom':   return true; break;
            case 'disabled': return false; break;
         }
      }
   }

   // Allow single posts to match the blog page
   if ( ( is_single() || is_archive() ) && 'post' == get_post_type() ) {
      if ( in_array( cv_theme_setting( 'blog', 'banner_behavior', 'default' ), array( 'blog_page', 'blog_page-hidden') ) ) {
         $blog_page = cv_theme_setting( 'blog', 'blog_page' );
         if ( $blog_page && 'none' != $blog_page ) {
            $cv_meta = get_post_meta( $blog_page, '_cv_page_settings', true );
            if ( isset( $cv_meta['transparency'] ) ) {
               switch ( $cv_meta['transparency'] ) {
                  case 'enabled':  return true; break;
                  case 'custom':   return true; break;
                  case 'disabled': return false; break;
               }
            }
         }
      }
   }

   // Allow portfolio items to match the portfolio page
   if ( is_single() && 'portfolio_item' == get_post_type() ) {
      if ( in_array( cv_theme_setting( 'portfolio', 'banner_behavior', 'default' ), array( 'portfolio_page', 'portfolio_page-hidden') ) ) {
         $portfolio_page = cv_theme_setting( 'portfolio', 'portfolio_page' );
         if ( $portfolio_page && 'none' != $portfolio_page ) {
            $cv_meta = get_post_meta( $portfolio_page, '_cv_page_settings', true );
            if ( isset( $cv_meta['transparency'] ) ) {
               switch ( $cv_meta['transparency'] ) {
                  case 'enabled':  return true; break;
                  case 'custom':   return true; break;
                  case 'disabled': return false; break;
               }
            }
         }
      }
   }

   // Return the default setting
   return apply_filters( 'cv_is_header_transparent', cv_theme_setting( 'header', 'transparency_default_enabled' ) );

}
endif;

if ( ! function_exists( 'cv_is_header_glassy' ) ) :

/**
 * Helper function to determine if header glassiness is active
 *
 * @return bool
 */
function cv_is_header_glassy() {

   // Make sure header is transparent
   if ( ! cv_is_header_transparent() ) return false;

   global $post;

   // Check if custom settings were provided
   if ( ! is_search() && isset( $post ) && get_the_ID() ) {
      $cv_meta = get_post_meta( get_the_ID(), '_cv_page_settings', true );
      if ( isset( $cv_meta['transparency'] ) && 'custom' == $cv_meta['transparency'] ) {
         return isset( $cv_meta['transparency_glassy'] ) && $cv_meta['transparency_glassy'];
      }
   }

   // Allow single posts to match the blog page
   if ( ( is_single() || is_archive() ) && 'post' == get_post_type() ) {
      if ( in_array( cv_theme_setting( 'blog', 'banner_behavior', 'default' ), array( 'blog_page', 'blog_page-hidden') ) ) {
         $blog_page = cv_theme_setting( 'blog', 'blog_page' );
         if ( $blog_page && 'none' != $blog_page ) {
            $cv_meta = get_post_meta( $blog_page, '_cv_page_settings', true );
            if ( isset( $cv_meta['transparency'] ) && 'custom' == $cv_meta['transparency'] ) {
               return isset( $cv_meta['transparency_glassy'] ) && $cv_meta['transparency_glassy'];
            }
         }
      }
   }

   // Allow portfolio items to match the portfolio page
   if ( is_single() && 'portfolio_item' == get_post_type() ) {
      if ( in_array( cv_theme_setting( 'portfolio', 'banner_behavior', 'default' ), array( 'portfolio_page', 'portfolio_page-hidden') ) ) {
         $portfolio_page = cv_theme_setting( 'portfolio', 'portfolio_page' );
         if ( $portfolio_page && 'none' != $portfolio_page ) {
            $cv_meta = get_post_meta( $portfolio_page, '_cv_page_settings', true );
            if ( isset( $cv_meta['transparency'] ) && 'custom' == $cv_meta['transparency'] ) {
               return isset( $cv_meta['transparency_glassy'] ) && $cv_meta['transparency_glassy'];
            }
         }
      }
   }

   // Return the default setting
   return apply_filters( 'cv_is_header_glassy', cv_theme_setting( 'header', 'transparency_glassy_enabled' ) );

}
endif;

if ( ! function_exists( 'cv_is_banner_active' ) ) :

/**
 * Helper function to determine if the banner area is active
 *
 * @return nothing
 */
function cv_is_banner_active() {

   global $post;

   // Blank page template
   if ( is_page_template( 'template-blank.php' ) ) return false;

   // Disable banner if page slide is active
   if ( cv_is_page_slide_active() ) return false;

   // Grab the current post ID
   $post_ID = ! is_search() && isset( $post ) && get_the_ID() ? get_the_ID() : '';

   // When viewing the blog page, change the ID to reflect this
   if ( 'page' === get_option( 'show_on_front' ) && ( $posts_page_id = get_option( 'page_for_posts' ) ) && is_home() ) {
      $post_ID = $posts_page_id;
   }

   // Allow pages to override the default setting
   if ( $post_ID ) {
      if ( $banner_settings = get_post_meta( $post_ID, '_cv_banner_settings', true ) ) {
         $setting = isset( $banner_settings['display'] ) ? $banner_settings['display'] : null;
         if ( 'hide' == $setting ) {
            return false;
         }
      }
   }

   return apply_filters( 'cv_is_baner_active', true );

}
endif;