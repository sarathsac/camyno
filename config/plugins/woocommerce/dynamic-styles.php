<?php

if ( ! function_exists( 'cv_render_woocommerce_styles' ) ) :

add_action( 'cv_render_dynamic_stylesheet', 'cv_render_woocommerce_styles', null, 1 );

/**
 * Generate dynamic woocommerce styles
 *
 * @param array $sections Color scheme settings
 * @return string
 */
function cv_render_woocommerce_styles( $sections ) {

   // Shopping cart item count
   $cart_color = 0.85 > cv_hex_brightness( $sections['header']['accent'] ) ? '255,255,255' : '0,0,0';
   echo
     " .primary-tools .cart-button .cart-count {"
   . "color: rgba({$cart_color},0.75);"
   . "background: {$sections['header']['accent']};"
   . "}"
   ;

   // Shopping cart preview font size
   switch ( cv_theme_setting( 'visual', 'font_size', 'smaller' ) ) {
      case 'much-smaller': $cart_font_size = '12px';   break;
      case 'smaller':      $cart_font_size = '13px'; break;
      case 'larger':       $cart_font_size = '15px'; break;
      case 'much-larger':  $cart_font_size = '16px';      break;
      default: $cart_font_size = '14px';
   }
   echo
     " .primary-tools .cart-preview {"
   . "font-size: {$cart_font_size};"
   . "}"
   ;

   /* Shopping cart preview color scheme */
   echo
     ".primary-tools .cart-preview {"
   . "background: {$sections['header']['primary_bg']};"
   . "border: 1px solid {$sections['header']['borders']};"
   . "border-top: 1px solid {$sections['header']['accent']};"
   . "}"
   . ".primary-tools .cart-preview li {"
   . "border-bottom: 1px solid {$sections['header']['borders']};"
   . "}"
   . " .primary-tools .cart-preview li .quantity {"
   . "color: {$sections['header']['content']} !important;"
   . "}"
   . ".primary-tools .cart-preview .total {"
   . "background: {$sections['header']['secondary_bg']};"
   . "color: {$sections['header']['secondary_content']};"
   . "}"
   . "#header .primary-tools .cart-preview .buttons .button {"
   . "background: {$sections['header']['primary_bg']} !important;"
   . "border: 1px solid {$sections['header']['borders']} !important;"
   . "color: {$sections['header']['content']} !important;"
   . "}"
   . "#header .primary-tools .cart-preview .buttons .button:hover {"
   . "border: 1px solid {$sections['header']['accent']} !important;"
   . "color: {$sections['header']['accent']} !important;"
   . "}"
   ;

   // Add appropriate spacing above cart preview
   if ( cv_theme_setting( 'header', 'enable_border', true ) ) {
      echo
        "#header:not(.sticky-menu-active) .primary-tools .cart-preview {"
      . "margin-top: 0px !important;"
      . "}"
      ;
   }

   // Sale badge
   $sale_color = 0.85 > cv_hex_brightness( $sections['main']['accent'] ) ? '#fff' : '#000';
   echo
     ".product.is-single .onsale {"
   . "background: {$sections['main']['accent']};"
   . "color: {$sale_color};"
   . "}"
   ;

   // Single product star rating
   echo
     ".product .star-rating .whole-star,"
   . ".product .star-rating .half-star:after {"
   . "color: {$sections['main']['accent']};"
   . "}"
   . ".product .star-rating .empty-star,"
   . ".product .star-rating .half-star:before {"
   . "color: " . cv_hex_to_rgba( $sections['main']['content'], 0.25 ) . ";"
   . "}"
   ;

   // Single View More link
   echo
     ".product.is-single .single-product-view-more {"
   . "border-top: 1px solid " . cv_hex_to_rgba( $sections['main']['borders'], 0.5 ) . ";"
   . "border-bottom: 1px solid " . cv_hex_to_rgba( $sections['main']['borders'], 0.5 ) . ";"
   . "}"
   . ".product.is-single .single-product-view-more a {"
   . "color: {$sections['main']['content']};"
   . "}"
   . ".product.is-single .single-product-view-more a:hover {"
   . "color: {$sections['main']['focused']};"
   . "}"
   ;

   // Single Product Reviews link
   echo
     ".product.is-single .woocommerce-review-link {"
   . "color: " . cv_hex_to_rgba( $sections['main']['content'], 0.5 ) . ";"
   . "}"
   ;

   // Single Product Price
   echo
     ".product.is-single .price del {"
   . "color: " . cv_hex_to_rgba( $sections['main']['content'], 0.75 ) . ";"
   . "}"
   ;

   // Single Product Variations
   echo
     ".product.is-single .variations_form.cart {"
   . "border: 1px solid {$sections['main']['borders']} !important;"
   . "background: {$sections['main']['secondary_bg']};"
   . "}"
   . ".product.is-single .variations_form.cart select {"
   . "border: 1px solid {$sections['main']['borders']} !important;"
   . "background: {$sections['main']['primary_bg']};"
   . "}"
   . ".product.is-single .variations_form.cart .cv-select-box:after {"
   . "background: {$sections['main']['primary_bg']};"
   . "color: {$sections['main']['content']};"
   . "}"
   ;

   // Single Product Quantity
   echo
     ".woocommerce .quantity {"
   . "border: 1px solid {$sections['main']['borders']} !important;"
   . "background: {$sections['main']['secondary_bg']};"
   . "color: {$sections['main']['secondary_content']};"
   . "}"
   . ".product_list_widget .quantity {"
   . "color: " . cv_hex_to_rgba( $sections['main']['content'], 0.75 ) . ";"
   . "}"
   ;

   // Single Product tabs
   echo
     ".product.is-single .woocommerce-tabs .tabs {"
   . "border-top: 1px solid {$sections['main']['borders']};"
   . "border-left: 1px solid {$sections['main']['borders']};"
   . "}"
   . ".product.is-single .woocommerce-tabs .tabs a {"
   . "border: 1px solid {$sections['main']['borders']};"
   . "border-bottom: 1px solid {$sections['main']['borders']};"
   . "color: " . cv_hex_to_rgba( $sections['main']['content'], 0.75 ) . ";"
   . "}"
   . ".product.is-single .woocommerce-tabs .tabs .active a {"
   . "border-bottom: 1px solid {$sections['main']['accent']};"
   . "background: {$sections['main']['primary_bg']};"
   . "color: {$sections['main']['headers']};"
   . "}"
   . "/* Breakpoint: 2 */"
   . "@media all and (min-width: 50em) {"
   . ".responsive .product.is-single .woocommerce-tabs .tabs .active a {"
   . "border-bottom: 1px solid {$sections['main']['primary_bg']};"
   . "}"
   . "}"
   . ".not-responsive .product.is-single .woocommerce-tabs .tabs .active a {"
   . "border-bottom: 1px solid {$sections['main']['primary_bg']};"
   . "}"
   . ".product.is-single .woocommerce-tabs .panel {"
   . "border: 1px solid {$sections['main']['borders']};"
   . "}"
   ;

   // Single product reviews
   echo
     ".product.is-single #comments .meta {"
   . "border-bottom: 1px solid {$sections['main']['borders']};"
   . "}"
   . ".product.is-single #respond #reply-title {"
   . "background: {$sections['main']['secondary_bg']};"
   . "color: " . cv_hex_to_rgba( $sections['main']['secondary_content'], 0.75 ) . ";"
   . "}"
   . ".product.is-single #respond .stars a {"
   . "color: {$sections['main']['primary_bg']};"
   . "}"
   . ".product.is-single #respond .stars a:after {"
   . "color: " . cv_hex_to_rgba( $sections['main']['content'], 0.5 ) . ";"
   . "}"
   . ".product.is-single #respond .stars .is-rated > a:after {"
   . "color: {$sections['main']['accent']};"
   . "}"
   . ".product.is-single #respond .stars .is-rated > a.active ~ a:after {"
   . "color: " . cv_hex_to_rgba( $sections['main']['content'], 0.5 ) . ";"
   . "}"
   ;

   // Checkout page
   echo
     "#payment .payment_methods {"
   . "border-bottom: 1px solid {$sections['main']['borders']};"
   . "}"
   . "#payment .payment_methods li {"
   . "border: 1px solid {$sections['main']['borders']};"
   . "}"
   ;

   foreach ( $sections as $section => $colors ) {

      $section_tag = '.cv-section-' . $section;

      // Product Loops
      echo
        $section_tag . " ul.products .product .product-inner-wrap {"
      . "border: 1px solid {$colors['borders']};"
      . "}"
      . $section_tag . " ul.products .product .product-inner-wrap .onsale {"
      . "background: {$colors['accent']};"
      . "color: {$colors['primary_bg']};"
      . "}"
      . $section_tag . " ul.products .product .product-inner-wrap .star-rating .empty-star,"
      . $section_tag . " ul.products .product .product-inner-wrap .star-rating .half-star:before {"
      . "color: " . cv_hex_to_rgba( $colors['content'], 0.25 ) . ";"
      . "}"
      . $section_tag . " ul.products .product .product-inner-wrap .star-rating.no-ratings {"
      . "color: " . cv_hex_to_rgba( $colors['content'], 0.5 ) . ";"
      . "}"
      . $section_tag . " ul.products .product .product-inner-wrap .price {"
      . "color: {$colors['content']};"
      . "}"
      . $section_tag . " ul.products .product .product-inner-wrap .price del {"
      . "color: " . cv_hex_to_rgba( $colors['content'], 0.5 ) . ";"
      . "}"
      . $section_tag . " ul.products .product .product-inner-wrap .add_to_cart_button,"
      . $section_tag . " ul.products .product .product-inner-wrap .product_type_grouped {"
      . "border-top: 1px solid " . cv_hex_to_rgba( $colors['borders'], 0.35 ) . ";"
      . "color: " . cv_hex_to_rgba( $colors['content'], 0.35 ) . ";"
      . "}"
      . $section_tag . " ul.products .product .product-inner-wrap:hover .add_to_cart_button,"
      . $section_tag . " ul.products .product .product-inner-wrap:hover .product_type_grouped {"
      . "border-top: 1px solid {$colors['borders']};"
      . "color: {$colors['content']};"
      . "}"
      . $section_tag . " ul.products .product .product-inner-wrap:hover .add_to_cart_button:hover,"
      . $section_tag . " ul.products .product .product-inner-wrap:hover .product_type_grouped:hover {"
      . "color: {$colors['accent']};"
      . "}"
      ;

      // Price Filter Widget
      echo
        $section_tag . " .price_slider_wrapper .price_slider {"
      . "background: {$colors['primary_bg']};"
      . "border: 1px solid {$colors['borders']};"
      // . "-webkit-box-shadow: inset {$colors['borders']} 0px 0px 0px 1px;"
      // . "box-shadow: inset {$colors['borders']} 0px 0px 0px 1px;"
      . "}"
      . $section_tag . " .price_slider_wrapper .ui-slider-handle {"
      . "background: {$colors['primary_bg']};"
      . "border: 1px solid {$colors['accent']};"
      // . "box-shadow: inset " . cv_hex_to_rgba( $colors['primary_bg'], 0.65 ) . " 0px 0px 8px 0px;"
      . "}"
      . $section_tag . " .price_slider_wrapper .ui-slider-range {"
      . "background: {$colors['accent']};"
      // . "box-shadow: inset " . cv_hex_to_rgba( $colors['accent'], 0.35 ) . " 0px 0px 0px 50px, inset " . cv_hex_to_rgba( $colors['accent'], 0.5 ) . " 0px 0px 0px 1px;"
      . "}"
      . $section_tag . " .price_slider_amount {"
      . "border: 1px solid {$colors['borders']};"
      . "}"
      . $section_tag . " .price_slider_amount .button {"
      . "color: {$colors['content']} !important;"
      . "border-left: 1px solid {$colors['borders']} !important;"
      . "}"
      . $section_tag . " .price_slider_amount .button:hover {"
      . "color: {$colors['secondary_content']} !important;"
      . "background: {$colors['secondary_bg']} !important;"
      . "}"
      ;

      // Cart Page
      echo
        $section_tag . " .woocommerce .shop_table.cart .product-name a:not(:hover) {"
      . "color: {$colors['headers']};"
      . "}"
      . $section_tag . " .woocommerce .shop_table.cart .product-remove a:not(:hover) {"
      . "color: " . cv_hex_to_rgba( $colors['content'], 0.5 ) . ";"
      . "}"
      . $section_tag . " .woocommerce .cart-collaterals .shipping_calculator h2 a {"
      . "color: {$colors['headers']} !important;"
      . "}"
      . $section_tag . " .woocommerce .cart-collaterals .shipping-calculator-form {"
      . "border: 1px solid {$colors['borders']};"
      . "}"
      ;

      // Checkout Page
      echo
        ".woocommerce-checkout " . $section_tag . " .login,"
      . ".woocommerce-checkout " . $section_tag . " .checkout_coupon {"
      . "border: 1px solid {$colors['borders']};"
      . "}"
      ;

      // Review Page
      echo
        $section_tag . " .woocommerce .order_details {"
      . "border: 1px solid {$colors['borders']};"
      . "}"
      . $section_tag . " .woocommerce .order_details li {"
      . "border-bottom: 1px solid {$colors['borders']};"
      . "}"
      ;

      // Product Lists
      echo
        $section_tag . " .widget .cart_list li.empty {"
      . "border-bottom: 1px solid {$colors['borders']} !important;"
      . "}"
      ;

   }

}
endif;