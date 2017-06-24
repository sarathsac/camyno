<?php
/**
 * Loop Add to Cart
 *
 * @package    WordPress
 * @subpackage Canvys
 * @since      Version 1.0
 * @version    3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product;

if ( ! $product->is_in_stock() ) {
   echo '<a href="' . get_permalink( $product->get_id() ) . '" class="add_to_cart_button">' . __( 'Out of Stock', 'canvys' ) . '</a>';
   return;
}

echo apply_filters( 'woocommerce_loop_add_to_cart_link',
   sprintf( '<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" class="%s product_type_%s">%s</a>',
      esc_url( $product->add_to_cart_url() ),
      esc_attr( $product->get_id() ),
      esc_attr( $product->get_sku() ),
      $product->is_purchasable() ? 'add_to_cart_button' : '',
      esc_attr( $product->get_type() ),
      esc_html( $product->add_to_cart_text() )
   ),
$product );
