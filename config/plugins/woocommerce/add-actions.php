<?php

/* ===================================================================== *
 * Displays breadcrumbs below title on single product pages
 * ===================================================================== */

if ( ! function_exists( 'cv_woocommerce_insert_product_bread_crumbs' ) ) :

/**
 * Function to modify the socket active conditional
 *
 * @return nothing
 */
function cv_woocommerce_insert_product_bread_crumbs() {
   $category = get_the_terms( get_the_ID(), 'product_cat' );
   if ( ! isset( $category[0] ) ) return;
   $first_cat = $category[0]; ?>
   <p class="single-product-view-more">
      <a href="<?php echo get_term_link( $first_cat ); ?>"><i class="icon-th"></i> <?php printf( __( 'View more %s', 'canvys' ), $first_cat->name ); ?></a>
   </p>
<?php }

add_action( 'woocommerce_single_product_summary', 'cv_woocommerce_insert_product_bread_crumbs', 17 );

endif;

/* ===================================================================== *
 * Split the single product page into two columns
 * ===================================================================== */

if ( ! function_exists( 'cv_woocommerce_before_single_product_summary' ) ) :

/**
 * Function to modify the socket active conditional
 *
 * @return nothing
 */
function cv_woocommerce_before_single_product_summary() { ?>
   <div class="single-product-columns">
<?php }

add_action( 'woocommerce_before_single_product_summary', 'cv_woocommerce_before_single_product_summary', 0 );

endif;

if ( ! function_exists( 'cv_woocommerce_after_single_product_summary' ) ) :

/**
 * Function to modify the socket active conditional
 *
 * @return nothing
 */
function cv_woocommerce_after_single_product_summary() { ?>
   </div>
<?php }

add_action( 'woocommerce_after_single_product_summary', 'cv_woocommerce_after_single_product_summary', 0 );

endif;

/* ===================================================================== *
 * Relocate sales flash on single product pages
 * ===================================================================== */

if ( ! function_exists( 'cv_woocommerce_relocate_single_sales_flash' ) ) :

/**
 * Function to modify the socket active conditional
 *
 * @return nothing
 */
function cv_woocommerce_relocate_single_sales_flash( $html ) {
   ob_start();
   woocommerce_show_product_sale_flash();
   return ob_get_clean() . $html;
}

add_filter( 'woocommerce_single_product_image_html', 'cv_woocommerce_relocate_single_sales_flash', 100 );

endif;

/* ===================================================================== *
 * Insert appropriate title before content on search results pages
 * ===================================================================== */

if ( ! function_exists( 'cv_woocommerce_insert_search_results_title' ) ) :

/**
 * Function to modify the socket active conditional
 *
 * @return nothing
 */
function cv_woocommerce_insert_search_results_title() {
   if ( ! is_search() ) return;
   global $wp_query;
   echo '<h1 style="margin-bottom:10px;">' . sprintf( __( '%s Search results for: %s', 'canvys' ), $wp_query->found_posts, $_GET['s'] ) . '</h1>';
}

add_filter( 'woocommerce_before_shop_loop', 'cv_woocommerce_insert_search_results_title', 100 );

endif;

/* ===================================================================== *
 * Wrap product loop items in inner div
 * ===================================================================== */

if ( ! function_exists( 'cv_woocommerce_before_loop_item' ) ) :

/**
 * Wraps product items in a div
 *
 * @return nothing
 */
function cv_woocommerce_before_loop_item() {
   global $woocommerce;
   $in_cart_class = null;
   foreach( $woocommerce->cart->get_cart() as $cart_item_key => $values ) {
      $_product = $values['data'];
      if ( get_the_ID() == $_product->get_id() ) {
         $in_cart_class = ' in-cart';
      }
   } ?>
   <div class="product-inner-wrap<?php echo $in_cart_class; ?>">
<?php }

add_filter( 'woocommerce_before_shop_loop_item', 'cv_woocommerce_before_loop_item', 0 );

endif;

if ( ! function_exists( 'cv_woocommerce_after_loop_item' ) ) :

/**
 * Function to modify the socket active conditional
 *
 * @return nothing
 */
function cv_woocommerce_after_loop_item() { ?>
   </div><!-- End .product-inner-wrap -->
<?php }

add_filter( 'woocommerce_after_shop_loop_item', 'cv_woocommerce_after_loop_item', 2000 );

endif;

/* ===================================================================== *
 * Wrap product loop item thumbnails in wrapper
 * ===================================================================== */

if ( ! function_exists( 'cv_woocommerce_insert_loop_description_wrap_open' ) ) :

/**
 * Wraps product items in a div
 *
 * @return nothing
 */
function cv_woocommerce_insert_loop_description_wrap_open() { ?>
   <div class="product-description">
<?php }

add_filter( 'woocommerce_before_shop_loop_item_title', 'cv_woocommerce_insert_loop_description_wrap_open', 25 );

endif;

if ( ! function_exists( 'cv_woocommerce_insert_loop_description_wrap_close' ) ) :

/**
 * Wraps product items in a div
 *
 * @return nothing
 */
function cv_woocommerce_insert_loop_description_wrap_close() { ?>
   </div>
<?php }

add_filter( 'woocommerce_after_shop_loop_item_title', 'cv_woocommerce_insert_loop_description_wrap_close', 100 );

endif;

/* ===================================================================== *
 * Add custom product loop thumbnails
 * ===================================================================== */

if ( ! function_exists( 'cv_woocommerce_insert_loop_thumbnails' ) ) :

/**
 * Inserts shop loop thumbnails
 *
 * @return nothing
 */
function cv_woocommerce_insert_loop_thumbnails() {

   echo '<div class="product-thumbnail">';

   $sizes = get_option( 'shop_catalog_image_size' );
   $height = $sizes['height'] ? intval( $sizes['height'] ) : 500;
   $width = $sizes['width'] ? intval( $sizes['width'] ) : 500;
   $ratio = $height / $width * 100;
   $img_url = null;

   if ( has_post_thumbnail() ) {
      $id = get_post_thumbnail_id();
      if ( $img_info = wp_get_attachment_image_src( $id, 'shop_catalog' ) ) {
         $img_url = $img_info[0];
      }
   }

   else if ( wc_placeholder_img_src() ) {
      $img_url = wc_placeholder_img_src();
   }

   if ( $img_url ) : ?>

      <span class="wc-loop-thumbnail bg-style-cover" style="background-image:url(<?php echo $img_url; ?>);">
      <span style="padding-top:<?php echo $ratio; ?>%;"></span>
      </span>

   <?php endif;

   // Grab the first thumbnail
   if ( cv_theme_setting( 'woocommerce', 'enable_flipping', true )
        && $product_gallery = get_post_meta( get_the_ID(), '_product_image_gallery', true ) ) :

      $gallery  = explode( ',', $product_gallery );
      $img_id = $gallery[0];

      if ( $img_info = wp_get_attachment_image_src( $img_id, 'shop_catalog' ) ) { ?>
         <span class="alternate-thumbnail">
            <span class="wc-loop-thumbnail bg-style-cover" style="background-image:url(<?php echo $img_info[0]; ?>);">
            <span style="padding-top:<?php echo $ratio; ?>%;"></span>
            </span>
         </span>
      <?php }

   endif;

   echo '</div><!-- End .product-thumbnail -->';

}

add_action( 'woocommerce_before_shop_loop_item_title', 'cv_woocommerce_insert_loop_thumbnails', 10 );

endif;

/* ===================================================================== *
 * Insert custom tabs to single product page
 * ===================================================================== */

if ( ! function_exists( 'cv_woocommerce_insert_tabs' ) ) :

/**
 * Function to modify the socket active conditional
 *
 * @return array
 */
function cv_woocommerce_insert_tabs( $tabs ) {
   $tabs['share'] = array(
      'title' => __( 'Share', 'canvys' ),
      'callback' => 'cv_woocommerce_insert_share_pane',
   );
   return $tabs;
}

add_filter( 'woocommerce_product_tabs', 'cv_woocommerce_insert_tabs', 100 );

endif;

/* ===================================================================== *
 * Insert custom panes to single product page
 * ===================================================================== */

if ( ! function_exists( 'cv_woocommerce_insert_share_pane' ) ) :

/**
 * Function to modify the socket active conditional
 *
 * @return nothing
 */
function cv_woocommerce_insert_share_pane() { ?>
   <h2><?php _e( 'Share This', 'canvys' ); ?></h2>
   <?php get_template_part( 'inc/content/share-buttons' ); ?>
<?php }

endif;