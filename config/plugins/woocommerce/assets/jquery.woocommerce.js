(function($) {
   "use strict";

   var $document = $(document);

   $document.ready( function() {

      var $body = $('body');

      // Remove number attribute from quantity input
      $('.woocommerce .quantity input[type="number"]').attr( 'type', 'text' );

      // Hook into cart AJAX
      $body.on( 'added_to_cart', function( e, parts, hash ) {

         if ( ! parts['div.widget_shopping_cart_content'] ) return;

         var $cart = $( parts['div.widget_shopping_cart_content'] ),
             $cartButton = $('#cv-header-cart-button').show(),
             $cartCount = $('#cv-header-cart-count'),
             $cartPreview = $('#cv-header-cart-preview'),
             currentTotal = parseInt( $cartCount.text() ) || 0;

         // Update cart icon in the header
         $cartCount.html( currentTotal + 1 );

         // Insert the cart preview
         if ( $cartPreview.length ) {
            $cartPreview.parent().removeClass('is-hidden');
            $cartPreview.html( $cart );
         }

         // make sure the tools divider is visible when applicable
         $('#primary-tools').addClass('show-divider');

      });

      // Star Rating
      $('.product.is-single #respond .stars a').on( 'click', function() {
         $(this).parent().addClass('is-rated');
      });
      $('.product.is-single #respond #reply-title').on( 'click', function() {
        $(this).toggleClass('is-active').next().slideToggle(250);
      });

      // Turn off the shipping calculator toggle
      $('.woocommerce .cart-collaterals .shipping_calculator h2 a').off('click');

      // Modify checkout alternate delivery address
      $('#ship-to-different-address input').off('change').on( 'change', function() {
         $( 'div.shipping_address' ).hide();
         if ( $( this ).is( ':checked' ) ) {
            $( 'div.shipping_address' ).fadeIn();
         }
      });

   });

})(jQuery);