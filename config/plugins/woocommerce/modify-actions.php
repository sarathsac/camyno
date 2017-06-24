<?php

/* ===================================================================== *
 * Prevents all WooCommerce assets from loading
 * ===================================================================== */

add_filter( 'woocommerce_enqueue_styles', '__return_false' );
update_option( 'woocommerce_enable_lightbox', false );
update_option( 'woocommerce_frontend_css', false );

/* ===================================================================== *
 * Modify banner title
 * ===================================================================== */

/**
 * Content Wrappers
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

/**
 * Breadcrumbs
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );

/**
 * Products Loop
 */
if ( ! cv_theme_setting( 'woocommerce', 'enable_sorting' ) ) {
   remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
   remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
}

// hide standard thumbnails
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );

/**
 * Pagination after shop loops
 */
remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination', 10 );

/**
 * Archive Descriptions
 */
remove_action( 'woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10 );
remove_action( 'woocommerce_archive_description', 'woocommerce_product_archive_description', 10 );

/**
 * Sale Flashes
 */
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );

/**
 * Product Summary Box
 */
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 15 );

/**
 * Single Products
 */

/* Reposition Tabs */
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_output_product_data_tabs', 9999999 );

/* Hide Upsells */
if ( cv_theme_setting( 'woocommerce', 'hide_upsells' ) ) {
   remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
}

/* Hide Related Products */
if ( cv_theme_setting( 'woocommerce', 'hide_related' ) ) {
   remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
}

/**
 * Cart Page
 */

// Move cross sells below the shipping
remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );
add_action( 'woocommerce_after_cart', 'woocommerce_cross_sell_display' , 10);