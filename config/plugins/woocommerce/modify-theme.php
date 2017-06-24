<?php

/* ===================================================================== *
 * Modify transparent header styles
 * ===================================================================== */

if ( ! function_exists( 'cv_woocommerce_modify_transparent_header_styles' ) ) :

/**
 * Function to modify the output of the banner title on WooCommerce pages
 *
 * @return string
 */
function cv_woocommerce_modify_transparent_header_styles( $color, $rgb ) { ?>

   /* Breakpoint: 1 */
   @media all and (min-width: 40em) {
      #header.is-transparent .primary-tools .cart-button .cart-count {
         background: <?php echo $color; ?> !important;
         color: rgba(<?php echo $rgb; ?>,0.75) !important;
      }
   }

<?php }

add_action( 'cv_transparent_header_styles', 'cv_woocommerce_modify_transparent_header_styles', null, 2 );

endif;

/* ===================================================================== *
 * Modify banner title
 * ===================================================================== */

if ( ! function_exists( 'cv_woocommerce_modify_banner_title' ) ) :

/**
 * Function to modify the output of the banner title on WooCommerce pages
 *
 * @return string
 */
function cv_woocommerce_modify_banner_title( $title ) {

   // Product archive page
   if ( is_shop() || is_product() ) {

      // Grab the ID of the shop page
      $shop_page_id = get_option( 'woocommerce_shop_page_id' );

      // Get the page meta
      $values = get_post_meta( $shop_page_id, '_cv_banner_settings', true );
      $display_title = isset( $values['display_title'] ) ? $values['display_title'] : null;
      $display_description = isset( $values['display_description'] ) ? $values['display_description'] : null;

      $display_title = $display_title ? $display_title : get_the_title( $shop_page_id );

      $title = '<h3>' . $display_title . '</h3>';

      if ( $display_description ) {
         $title .= '<h5>' . $display_description . '</h5>';
      }

   }

   else if ( is_product_category() || is_product_tag() ) {

      $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );

      // Display the main title
      $title = '<h3>' . $term->name . '</h3>';

      if ( $term->description ) {
         $title .= '<h5>' . $term->description . '</h5>';
      }


   }

   return $title;

}

add_filter( 'cv_banner_title', 'cv_woocommerce_modify_banner_title' );

endif;

/* ===================================================================== *
 * Modify bread crumbs
 * ===================================================================== */

if ( ! function_exists( 'cv_woocommerce_modify_bread_crumbs' ) ) :

/**
 * Function to modify the output of the banner title on WooCommerce pages
 *
 * @return string
 */
function cv_woocommerce_modify_bread_crumbs( $crumbs ) {

   // Product archive page
   if ( is_shop() || is_product() || is_product_category() || is_product_tag() ) {

      // Grab the ID of the shop page
      $shop_page_id = get_option( 'woocommerce_shop_page_id' );
      $shop_page = get_page( $shop_page_id );

      // Display link to home page
      $crumbs = '<li><a href="' . home_url() . '">' . __( 'Home', 'canvys' ) . '</a></li>';

      // Check if the shop page has parents
      if ( $shop_page && $shop_page->post_parent ) {
         foreach ( array_reverse( get_post_ancestors( $shop_page_id ) ) as $parent ) {
            $crumbs .= '<li><a href="' . get_permalink( $parent ) . '">' . get_the_title( $parent ) . '</a></li>';
         }
      }

      // Display link to shop page
      $shop_link = is_shop() && ! is_search() ? '<span>' . get_the_title( $shop_page_id ) . '</span>' : '<a href="' . get_permalink( $shop_page_id ) . '">' . get_the_title( $shop_page_id ) . '</a>';
      $crumbs .= '<li>' . $shop_link . '</li>';

      if ( is_search() ) {
         $crumbs .= '<li><span>' . __( 'Search Results', 'canvys' ) . '</span></li>';
      }

   }

   // Single product page
   if ( is_product() ) {

      // Link to first category
      $category = get_the_terms( get_the_ID(), 'product_cat' );
      if ( is_array( $category ) && $first_cat = reset($category) ) {
         $crumbs .= '<li>';
         $crumbs .= '<a href="' . get_term_link( $first_cat ) . '">' . $first_cat->name . '</a>';
         $crumbs .= '</li>';
      }

      // Display link to current product
      $crumbs .= '<li><span>' . get_the_title() . '</span></li>';

   }

   // Product category archive
   else if ( is_product_category() || is_product_tag() ) {

      $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );

      if ( isset( $term->parent ) && $term->parent ) {

         $parent = get_term_by( 'id', $term->parent, get_query_var( 'taxonomy' ) );
         $all_parents = array( $parent );

         while ( 0 != $parent->parent ) {
            $term_id = $parent->parent;
            $parent = get_term_by( 'id', $term_id, get_query_var( 'taxonomy' ) );
            $all_parents[] = $parent;
         }

         foreach ( array_reverse( $all_parents ) as $parent ) {
            $crumbs .= '<li><a href="' . get_term_link( $parent ) . '">' . $parent->name . '</a></li>';
         }

      }

      // Display link to product category
      $crumbs .= '<li><a href="' . get_term_link( $term ) . '">' . $term->name . '</a></li>';

   }

   return $crumbs;

}

add_filter( 'cv_bread_crumbs', 'cv_woocommerce_modify_bread_crumbs' );

endif;

/* ===================================================================== *
 * Modify banner configuration
 * ===================================================================== */

if ( ! function_exists( 'cv_woocommerce_modify_banner_config' ) ) :

/**
 * Function to modify how the banner is styled
 *
 * @return array
 */
function cv_woocommerce_modify_banner_config( $banner_config ) {

   $use_shop_config = false;

   if ( is_shop() || is_woocommerce() && in_array( cv_theme_setting( 'woocommerce', 'banner_behavior', 'default' ), array( 'shop_page', 'shop_page-hidden' ) ) ) {
      $use_shop_config = true;
   }

   if ( is_cart() || is_checkout() || is_account_page() ) {

      // Grab the banner meta settings
      $custom_settings = get_post_meta( get_the_ID(), '_cv_banner_settings', true );
      $display_setting = isset( $custom_settings['display'] ) ? $custom_settings['display'] : 'default';
      if ( 'default' == $display_setting && in_array( cv_theme_setting( 'woocommerce', 'banner_behavior', 'default' ), array( 'shop_page', 'shop_page-hidden' ) ) ) {
         $use_shop_config = true;
      }

   }

   if ( $use_shop_config ) {

      // Grab the ID of the shop page
      $shop_page_id = get_option( 'woocommerce_shop_page_id' );

      // Grab the banner meta settings
      $custom_settings = get_post_meta( $shop_page_id, '_cv_banner_settings', true );
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

   if ( is_product() && in_array( cv_theme_setting( 'woocommerce', 'banner_behavior', 'default' ), array( 'hidden', 'shop_page-hidden' ) ) ) {
      $banner_config['text_style'] = 'hidden';
      $banner_config['custom_height'] = 0;
   }

   return $banner_config;

}

add_filter( 'cv_banner_config', 'cv_woocommerce_modify_banner_config' );

endif;

/* ===================================================================== *
 * Modify banner state conditional
 * ===================================================================== */

if ( ! function_exists( 'cv_woocommerce_modify_is_baner_active' ) ) :

/**
 * Function to modify whether or not the banner is active
 *
 * @return bool
 */
function cv_woocommerce_modify_is_baner_active( $is_active ) {

   $use_shop_config = false;

   if ( is_shop() || is_woocommerce() && in_array( cv_theme_setting( 'woocommerce', 'banner_behavior', 'default' ), array( 'shop_page', 'shop_page-hidden' ) ) ) {
      $use_shop_config = true;
   }

   if ( is_cart() || is_checkout() || is_account_page() ) {

      // Grab the banner meta settings
      $custom_settings = get_post_meta( get_the_ID(), '_cv_banner_settings', true );
      $display_setting = isset( $custom_settings['display'] ) ? $custom_settings['display'] : 'default';
      if ( 'default' == $display_setting && in_array( cv_theme_setting( 'woocommerce', 'banner_behavior', 'default' ), array( 'shop_page', 'shop_page-hidden' ) ) ) {
         $use_shop_config = true;
      }

   }

   // Product archive page
   if ($use_shop_config ) {

      // Grab the ID of the shop page
      $shop_page_id = get_option( 'woocommerce_shop_page_id' );

      // Grab the banner meta settings
      $custom_settings = get_post_meta( $shop_page_id, '_cv_banner_settings', true );
      $display_setting = isset( $custom_settings['display'] ) ? $custom_settings['display'] : 'default';

      if ( 'hide' == $display_setting ) return false;

   }

   return $is_active;

}

add_filter( 'cv_is_baner_active', 'cv_woocommerce_modify_is_baner_active' );

endif;

/* ===================================================================== *
 * Modify header transparency conditional
 * ===================================================================== */

if ( ! function_exists( 'cv_woocommerce_modify_is_header_transparent' ) ) :

/**
 * Function to modify header transparency color
 *
 * @return bool
 */
function cv_woocommerce_modify_is_header_transparent( $is_active ) {

   $use_shop_config = false;

   if ( is_shop() || is_woocommerce() && in_array( cv_theme_setting( 'woocommerce', 'banner_behavior', 'default' ), array( 'shop_page', 'shop_page-hidden' ) ) ) {
      $use_shop_config = true;
   }

   if ( is_cart() || is_checkout() || is_account_page() ) {

      // Grab the banner meta settings
      $cv_meta = get_post_meta( get_the_ID(), '_cv_page_settings', true );
      $transparency_setting = isset( $cv_meta['transparency'] ) ? $cv_meta['transparency'] : 'default';
      if ( 'default' == $transparency_setting && in_array( cv_theme_setting( 'woocommerce', 'banner_behavior', 'default' ), array( 'shop_page', 'shop_page-hidden' ) ) ) {
         $use_shop_config = true;
      }

   }

   if ( $use_shop_config ) {

      // Grab the ID of the shop page
      $shop_page_id = get_option( 'woocommerce_shop_page_id' );

      // Check if settings were overwritten
      $cv_meta = get_post_meta( $shop_page_id, '_cv_page_settings', true );
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

add_filter( 'cv_is_header_transparent', 'cv_woocommerce_modify_is_header_transparent' );

endif;

/* ===================================================================== *
 * Modify header glassy conditional
 * ===================================================================== */

if ( ! function_exists( 'cv_woocommerce_modify_is_header_glassy' ) ) :

/**
 * Function to modify header glassy color
 *
 * @return bool
 */
function cv_woocommerce_modify_is_header_glassy( $is_glassy ) {

   $use_shop_config = false;

   if ( is_shop() || is_woocommerce() && in_array( cv_theme_setting( 'woocommerce', 'banner_behavior', 'default' ), array( 'shop_page', 'shop_page-hidden' ) ) ) {
      $use_shop_config = true;
   }

   if ( is_cart() || is_checkout() || is_account_page() ) {

      // Grab the banner meta settings
      $cv_meta = get_post_meta( get_the_ID(), '_cv_page_settings', true );
      $transparency_setting = isset( $cv_meta['transparency'] ) ? $cv_meta['transparency'] : 'default';
      if ( 'default' == $transparency_setting && in_array( cv_theme_setting( 'woocommerce', 'banner_behavior', 'default' ), array( 'shop_page', 'shop_page-hidden' ) ) ) {
         $use_shop_config = true;
      }

   }

   if ( $use_shop_config ) {

      // Grab the ID of the shop page
      $shop_page_id = get_option( 'woocommerce_shop_page_id' );

      // Check if settings were overwritten
      $cv_meta = get_post_meta( $shop_page_id, '_cv_page_settings', true );
      if ( isset( $cv_meta['transparency'] ) && 'custom' == $cv_meta['transparency'] ) {
         return isset( $cv_meta['transparency_glassy'] ) && $cv_meta['transparency_glassy'];
      }

   }

   return $is_glassy;

}

add_filter( 'cv_is_header_glassy', 'cv_woocommerce_modify_is_header_glassy' );

endif;

/* ===================================================================== *
 * Modify header transparency color
 * ===================================================================== */

if ( ! function_exists( 'cv_woocommerce_modify_header_transparency_color' ) ) :

/**
 * Function to modify header transparency color
 *
 * @return string
 */
function cv_woocommerce_modify_header_transparency_color( $color ) {

   $use_shop_config = false;

   if ( is_shop() || is_woocommerce() && in_array( cv_theme_setting( 'woocommerce', 'banner_behavior', 'default' ), array( 'shop_page', 'shop_page-hidden' ) ) ) {
      $use_shop_config = true;
   }

   if ( is_cart() || is_checkout() || is_account_page() ) {

      // Grab the banner meta settings
      $cv_meta = get_post_meta( get_the_ID(), '_cv_page_settings', true );
      $transparency_setting = isset( $cv_meta['transparency'] ) ? $cv_meta['transparency'] : 'default';
      if ( 'default' == $transparency_setting && in_array( cv_theme_setting( 'woocommerce', 'banner_behavior', 'default' ), array( 'shop_page', 'shop_page-hidden' ) ) ) {
         $use_shop_config = true;
      }

   }

   if ( $use_shop_config ) {

      // Grab the ID of the shop page
      $shop_page_id = get_option( 'woocommerce_shop_page_id' );

      // Check if settings were overwritten
      $cv_meta = get_post_meta( $shop_page_id, '_cv_page_settings', true );
      if ( isset( $cv_meta['transparency'] ) && 'custom' == $cv_meta['transparency'] ) {
         $color = isset( $cv_meta['transparency_color'] ) && $cv_meta['transparency_color'] ? $cv_meta['transparency_color'] : $color;
      }

   }

   return $color;

}

add_filter( 'cv_header_transparency_color', 'cv_woocommerce_modify_header_transparency_color' );

endif;

/* ===================================================================== *
 * Modify header transparency logo
 * ===================================================================== */

if ( ! function_exists( 'cv_woocommerce_modify_header_transparency_logo' ) ) :

/**
 * Function to modify the header transparency logo
 *
 * @return bool
 */
function cv_woocommerce_modify_header_transparency_logo( $transparent_logo ) {

   $use_shop_config = false;

   if ( is_shop() || is_woocommerce() && in_array( cv_theme_setting( 'woocommerce', 'banner_behavior', 'default' ), array( 'shop_page', 'shop_page-hidden' ) ) ) {
      $use_shop_config = true;
   }

   if ( is_cart() || is_checkout() || is_account_page() ) {

      // Grab the banner meta settings
      $cv_meta = get_post_meta( get_the_ID(), '_cv_page_settings', true );
      $transparency_setting = isset( $cv_meta['transparency'] ) ? $cv_meta['transparency'] : 'default';
      if ( 'default' == $transparency_setting && in_array( cv_theme_setting( 'woocommerce', 'banner_behavior', 'default' ), array( 'shop_page', 'shop_page-hidden' ) ) ) {
         $use_shop_config = true;
      }

   }

   if ( $use_shop_config ) {

      // Grab the ID of the shop page
      $shop_page_id = get_option( 'woocommerce_shop_page_id' );

      // Grab the meta information, if any
      $cv_meta = get_post_meta( $shop_page_id, '_cv_page_settings', true );

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

add_filter( 'cv_header_transparency_logo', 'cv_woocommerce_modify_header_transparency_logo' );

endif;

/* ===================================================================== *
 * Modify footer state conditional
 * ===================================================================== */

if ( ! function_exists( 'cv_woocommerce_modify_is_footer_active' ) ) :

/**
 * Function to modify the footer active conditional
 *
 * @return bool
 */
function cv_woocommerce_modify_is_footer_active( $is_active ) {

   // Product archive page
   if ( is_shop() ) {

      // Grab the ID of the shop page
      $shop_page_id = get_option( 'woocommerce_shop_page_id' );

      // Check if the settings were overriden
      $cv_meta = get_post_meta( $shop_page_id, '_cv_page_settings', true );
      if ( $cv_meta && isset( $cv_meta['footer'] ) && in_array( $cv_meta['footer'], array( 'columns', 'both' ) ) ) return false;

   }

   return $is_active;

}

add_filter( 'cv_is_footer_active', 'cv_woocommerce_modify_is_footer_active' );

endif;

/* ===================================================================== *
 * Modify socket state conditional
 * ===================================================================== */

if ( ! function_exists( 'cv_woocommerce_modify_is_socket_active' ) ) :

/**
 * Function to modify the socket active conditional
 *
 * @return bool
 */
function cv_woocommerce_modify_is_socket_active( $is_active ) {

   // Product archive page
   if ( is_shop() ) {

      // Grab the ID of the shop page
      $shop_page_id = get_option( 'woocommerce_shop_page_id' );

      // Check if the settings were overriden
      $cv_meta = get_post_meta( $shop_page_id, '_cv_page_settings', true );
      if ( $cv_meta && isset( $cv_meta['footer'] ) && in_array( $cv_meta['footer'], array( 'socket', 'both' ) ) ) return false;

   }

   return $is_active;

}

add_filter( 'cv_is_socket_active', 'cv_woocommerce_modify_is_socket_active' );

endif;