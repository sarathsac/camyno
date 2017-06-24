<?php
/**
 * Single Product Rating
 *
 * @package    WordPress
 * @subpackage Canvys
 * @since      Version 1.0
 * @version    2.3.2
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product;

if ( get_option( 'woocommerce_enable_review_rating' ) === 'no' )
   return;

$count   = $product->get_rating_count();
$average = $product->get_average_rating();

if ( ! $count > 0 ) return;

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

<div class="woocommerce-product-rating has-clearfix" itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
   <div class="star-rating" title="<?php printf( __( 'Rated %s out of 5.', 'canvys' ), $average ); ?>">
      <span class="inner-stars-wrapper"><?php echo $stars; ?></span>
   </div>
   <span class="woocommerce-review-link"><?php printf( _n( 'Based on %s review', 'Based on %s reviews', $count, 'canvys' ), '<span itemprop="ratingCount" class="count">' . $count . '</span>' ); ?></span>
</div>