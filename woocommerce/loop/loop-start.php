<?php
/**
 * Product Loop Start
 *
 * @package    WordPress
 * @subpackage Canvys
 * @since      Version 1.0
 * @version    2.0.0
 */
if ( is_product() || is_cart() ) {
   global $canvys;
   $num_columns = 'free' == cv_theme_setting( 'visual', 'wrap_layout', 'free' ) ? 8 : 4;
   if ( 'no-sidebar' != $canvys['current_sidebar_layout'] ) $num_columns = 8 == $num_columns ? 6 : 3;
}
else {
   global $woocommerce_loop;
   $num_columns = isset( $woocommerce_loop['columns'] ) ? $woocommerce_loop['columns'] : 4;
}
$num_columns = apply_filters( 'loop_shop_columns', $num_columns )?>
<ul class="products shop-loop product-loop cv-grid-<?php echo $num_columns; ?> spacing-1 has-clearfix">