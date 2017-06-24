<?php
/**
 * Loop Rating
 *
 * @package    WordPress
 * @subpackage Canvys
 * @since      Version 1.0
 * @version    3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product;

if ( get_option( 'woocommerce_enable_review_rating' ) === 'no' )
   return;

$count   = $product->get_rating_count();
$average = $product->get_average_rating();

if ( ! $count > 0 ) { ?>

   <strong class="woocommerce-product-rating star-rating no-ratings">
      <?php _e( 'No Ratings Yet', 'canvys' ); ?>
   </strong>

   <?php return;
}

$stars = '';
$floor = floor( $average );
$difference = $average - $floor;
$empty_stars = 5;

for ( $i=0; $i<$floor; $i++ ) {
   $stars .= '<span class="star-indicator whole-star"></span>';
   $empty_stars--;
}

if ( $difference && 0.5 < $difference ) {
   $stars .= '<span class="star-indicator half-star"></span>';
   $empty_stars--;
}

for ( $i=0; $i<$empty_stars; $i++ ) {
   $stars .= '<span class="star-indicator empty-star"></span>';
} ?>

<strong class="woocommerce-product-rating star-rating" itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating" title="<?php printf( __( 'Rated %s out of 5, based on %s customer reviews.', 'canvys' ), $average, $count ); ?>">
   <span class="inner-stars-wrapper"><?php echo $stars; ?></span>
</strong>