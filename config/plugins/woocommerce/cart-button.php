<?php

/**
 * Adds the WooCommerce cart button
 */
if ( ! function_exists( 'cv_add_woocommerce_cart_button' ) ) :

// Make sure button is enabled before preceeding
if ( cv_theme_setting( 'woocommerce', 'enable_cart_button', true ) ) {
   add_action( 'cv_primary_tools', 'cv_add_woocommerce_cart_button' );
   add_action( 'wp_head', 'cv_woocommerce_show_tools_divider' );
}

function cv_woocommerce_show_tools_divider() {

   global $woocommerce;

   // Number of items in the cart
   $count = $woocommerce->cart->cart_contents_count;

   if ( ! ( cv_theme_setting( 'woocommerce', 'hide_empty_cart' ) && ! $count ) ) {
      add_filter( 'cv_show_tools_divider', '__return_true', 99 );
   }

}

function cv_add_woocommerce_cart_button() {

   global $woocommerce;

   // Do not display on the cart page
   // if ( is_cart() ) return;

   // Number of items in the cart
   $count = $woocommerce->cart->cart_contents_count;

   // Create the button
   $cart_button = new CV_HTML( '<a>', array(
      'id'    => 'cv-header-cart-button',
      'class' => 'cart-button',
      'title' => __( 'View your shopping cart', 'canvys' ),
      'href'  => $woocommerce->cart->get_cart_url()
   ) );

   // Insert the icon
   $cart_button->append('<i class="icon-basket"></i> ');

   if ( cv_theme_setting( 'woocommerce', 'hide_empty_cart' ) && ! $count ) {
      $cart_button->css('display', 'none');
   }

   // Add the cart count
   if ( $count == 0 ) $count = '';
   $cart_count = '<sup><span id="cv-header-cart-count" class="cart-count">' . $count . '</span></sup>';
   if ( is_rtl() ) $cart_button->prepend( $cart_count ); else $cart_button->append( $cart_count );

   // Display the cart button
   echo $cart_button;

   /* Render the cart preview */
   if ( cv_theme_setting( 'woocommerce', 'show_cart_preview', true ) ) {
      $hidden_class = $count ? null : ' is-hidden';
      echo '<div class="cart-preview-wrap' . $hidden_class . '">';
      echo '<div id="cv-header-cart-preview" class="cart-preview has-clearfix">';
      echo '<div class="widget_shopping_cart_content"></div>';
      echo '</div>';
      echo '</div>';
   }

}
endif;