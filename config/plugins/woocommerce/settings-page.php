<?php

if ( ! class_exists('CV_WooCommerce_Settings') ) :

/**
 * WooCommerce settings page
 *
 * @package    WordPress
 * @subpackage Canvys
 * @since      Version 1.0
 */
class CV_WooCommerce_Settings extends CV_Settings_Page {

   /**
    * Function to create page configuration
    *
    * @return void
    */
   public function __construct() {

      global $canvys;

      $this->config = array(
         'tab_title' => 'WooCommerce',
         'slug' => 'woocommerce',
         'priority' => 120,
         'defaults' => array(
            'enable_cart_button'  => true,
            'hide_empty_cart'     => false,
            'show_cart_preview'   => true,
            'enable_sorting'      => false,
            'enable_flipping'     => true,
            'hide_upsells'        => false,
            'hide_related'        => false,
            'shop_columns'        => '3',
            'per_page'            => '9',
            'banner_behavior'     => 'default',
            'product_layout'      => 'no-sidebar',
         ),
      );

   }

   /**
    * Loading additional scripts to the settings page
    *
    * @return void
    */
   public function additional_scripts() { ?>
      <script id="cv-theme-settings-woocommerce-script">
         (function($) {
            $(document).ready( function() {

               // show/hide cart button options
               $('#woocommerce-enable_cart_button').change( function() {
                  var $this = $(this), $cartOptions = $('#woocommerce-cart-controls-wrap');
                  if ( $this.prop('checked') ) {
                     $cartOptions.slideDown();
                  }
                  else {
                     $cartOptions.slideUp();
                  }
               }).trigger('change');

            });
         })(jQuery);
      </script>
   <?php }

   /**
    * Rendering the inner page
    *
    * @param array $input The user specified input
    * @return void
    */
   public function render_inner_page( $input ) {
      $name = 'cv_theme_settings[' . $this->config['slug'] . ']';
      $input = $this->extract_input( $input ); ?>

      <div class="option-wrap">
         <strong class="option-title"><?php _e( 'Cart Icon', 'canvys' ); ?></strong>
         <label for="woocommerce-enable_cart_button">
            <input type="checkbox" id="woocommerce-enable_cart_button" value="1" <?php checked( $input['enable_cart_button'] ); ?> name="<?php echo $name; ?>[enable_cart_button]" />
            <span><?php _e( 'Display a shopping cart icon in the header.', 'canvys' ); ?></span>
         </label>
         <div id="woocommerce-cart-controls-wrap">
            <div class="option-spacer"></div>
            <strong class="option-title"><?php _e( 'Empty Cart Icon', 'canvys' ); ?></strong>
            <label for="woocommerce-hide_empty_cart">
               <input type="checkbox" id="woocommerce-hide_empty_cart" value="1" <?php checked( $input['hide_empty_cart'] ); ?> name="<?php echo $name; ?>[hide_empty_cart]" />
               <span><?php _e( 'Hide the cart icon when it is empty.', 'canvys' ); ?></span>
            </label>
            <div class="option-spacer"></div>
            <strong class="option-title"><?php _e( 'Display Cart Preview', 'canvys' ); ?></strong>
            <label for="woocommerce-show_cart_preview">
               <input type="checkbox" id="woocommerce-show_cart_preview" value="1" <?php checked( $input['show_cart_preview'] ); ?> name="<?php echo $name; ?>[show_cart_preview]" />
               <span><?php _e( 'Display a preview of the cart when the cart icon is hovered over.', 'canvys' ); ?></span>
            </label>
         </div>
      </div>

      <div class="option-wrap">
         <strong class="option-title"><?php _e( 'Enable Catalog Ordering', 'canvys' ); ?></strong>
         <label for="woocommerce-enable_sorting">
            <input type="checkbox" id="woocommerce-enable_sorting" value="1" <?php checked( $input['enable_sorting'] ); ?> name="<?php echo $name; ?>[enable_sorting]" />
            <span><?php _e( 'Display a dropdown above the shop which will allow users to change the sorting order of the listed products.', 'canvys' ); ?></span>
         </label>
      </div>

      <div class="option-wrap">
         <strong class="option-title"><?php _e( 'Enable Shop Double Images', 'canvys' ); ?></strong>
         <label for="woocommerce-enable_flipping">
            <input type="checkbox" id="woocommerce-enable_flipping" value="1" <?php checked( $input['enable_flipping'] ); ?> name="<?php echo $name; ?>[enable_flipping]" />
            <span><?php _e( 'Products displayed within shop loops will display the first image in their gallery (if any) when hovered over.', 'canvys' ); ?></span>
         </label>
      </div>

      <div class="option-wrap">
         <strong class="option-title"><?php _e( 'Hide Upsells on Product Pages', 'canvys' ); ?></strong>
         <label for="woocommerce-hide_upsells">
            <input type="checkbox" id="woocommerce-hide_upsells" value="1" <?php checked( $input['hide_upsells'] ); ?> name="<?php echo $name; ?>[hide_upsells]" />
            <span><?php _e( 'Hide the upsells section displayed on single product pages.', 'canvys' ); ?></span>
         </label>
      </div>

      <div class="option-wrap">
         <strong class="option-title"><?php _e( 'Hide Related Products on Product Pages', 'canvys' ); ?></strong>
         <label for="woocommerce-hide_related">
            <input type="checkbox" id="woocommerce-hide_related" value="1" <?php checked( $input['hide_related'] ); ?> name="<?php echo $name; ?>[hide_related]" />
            <span><?php _e( 'Hide the related products section displayed on single product pages.', 'canvys' ); ?></span>
         </label>
      </div>

      <div class="option-wrap">

         <div class="cv-split-2 spacing-2 has-clearfix">
            <div>
               <label for="woocommerce-shop_columns" class="option-title"><?php _e( 'Shop Columns', 'canvys' ); ?></label>
               <select name="<?php echo $name; ?>[shop_columns]" id="woocommerce-shop_columns" class="widefat">
                  <?php for ( $i=2; $i<9; $i++ ) : ?>
                     <option value="<?php echo $i; ?>" <?php selected( $input['shop_columns'], $i ); ?>><?php printf( __( '%s Columns', 'canvys' ), $i ); ?></option>
                  <?php endfor; ?>
               </select>
               <p><?php _e( 'Specify how many columns your shop should be separated into.', 'canvys' ); ?></p>
            </div>

            <div>
               <label for="woocommerce-per_page" class="option-title"><?php _e( 'Products Per Page', 'canvys' ); ?></label>
               <input type="text" class="widefat code" name="<?php echo $name; ?>[per_page]" id="woocommerce-per_page" value="<?php echo $input['per_page']; ?>" placeholder="All products" />
               <p><?php _e( 'Numeric value only, if left blank all products will be displayed on one page.', 'canvys' ); ?></p>
            </div>
         </div>

      </div>

      <div class="option-wrap">
         <label for="shop-banner_behavior" class="option-title"><?php _e( 'Shop Header & Banner Behavior', 'canvys' ); ?></label>
         <select name="<?php echo $name; ?>[banner_behavior]" id="shop-banner_behavior">
            <option value="default" <?php selected( $input['banner_behavior'], 'default' ); ?>><?php _e( 'Use theme defaults (Set in Theme Settings > Header)', 'canvys' ); ?></option>
            <option value="shop_page" <?php selected( $input['banner_behavior'], 'shop_page' ); ?>><?php _e( 'Match the settings for the shop page specified in WooCommerce Settings', 'canvys' ); ?></option>
            <option value="hidden" <?php selected( $input['banner_behavior'], 'hidden' ); ?>><?php _e( 'Use theme defaults (Set in Theme Settings > Header) and hide the banner text on product pages', 'canvys' ); ?></option>
            <option value="shop_page-hidden" <?php selected( $input['banner_behavior'], 'shop_page-hidden' ); ?>><?php _e( 'Match the settings for the shop page specified in WooCommerce Settings, and hide the banner text on product pages', 'canvys' ); ?></option>
         </select>
         <p><?php _e( 'Specify how the banner and header on shop related pages, including category/tag archives, the Cart page, the Checkout page, the My Account page, and single product pages should be displayed.', 'canvys' ); ?></p>
      </div>

      <div class="option-wrap">
         <label class="option-title" for="woocommerce-product_layout"><?php _e( 'Single Product Layout', 'canvys' ); ?></label>
         <select name="<?php echo $name; ?>[product_layout]" id="woocommerce-product_layout">
            <option value="sidebar-left" <?php selected( $input['product_layout'], 'sidebar-left' ); ?>><?php _e( 'Left Sidebar', 'canvys' ); ?></option>
            <option value="sidebar-right" <?php selected( $input['product_layout'], 'sidebar-right' ); ?>><?php _e( 'Right Sidebar', 'canvys' ); ?></option>
            <option value="no-sidebar" <?php selected( $input['product_layout'], 'no-sidebar' ); ?>><?php _e( 'No Sidebar', 'canvys' ); ?></option>
         </select>
         <p class="option-description"><?php _e( 'Sidebar layout for single product pages.', 'canvys' ); ?></p>
      </div>

   <?php }

   /**
    * Sanitizing the page specific input
    *
    * @param array $input The user specified input
    * @return array
    */
   public static function sanitize_input( $input ) {
      return array(
         'enable_cart_button'  => isset( $input['enable_cart_button'] ) && $input['enable_cart_button'] ? true : false,
         'hide_empty_cart'     => isset( $input['hide_empty_cart'] ) && $input['hide_empty_cart'] ? true : false,
         'show_cart_preview'   => isset( $input['show_cart_preview'] ) && $input['show_cart_preview'] ? true : false,
         'enable_sorting'      => isset( $input['enable_sorting'] ) && $input['enable_sorting'] ? true : false,
         'enable_flipping'     => isset( $input['enable_flipping'] ) && $input['enable_flipping'] ? true : false,
         'hide_upsells'        => isset( $input['hide_upsells'] ) && $input['hide_upsells'] ? true : false,
         'hide_related'        => isset( $input['hide_related'] ) && $input['hide_related'] ? true : false,
         'shop_columns'        => isset( $input['shop_columns'] ) ? cv_filter( $input['shop_columns'], 'integer' ) : '3',
         'per_page'            => isset( $input['per_page'] ) ? cv_filter( $input['per_page'], 'integer' ) : '12',
         'banner_behavior'     => isset( $input['banner_behavior'] ) ? cv_filter( $input['banner_behavior'], array( 'default', 'shop_page', 'shop_page-hidden', 'hidden' ) ) : 'default',
         'product_layout'      => isset( $input['product_layout'] ) ? cv_filter( $input['product_layout'], array( 'sidebar-left', 'sidebar-right', 'no-sidebar' ) ) : 'no-sidebar',
      );
   }

}
endif;