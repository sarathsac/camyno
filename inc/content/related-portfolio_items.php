<?php

global $canvys, $post;

// Make sure we`re on a single post page
if ( ! is_single() ) return;

$sidebar_layout = isset( $canvys['current_sidebar_layout'] ) ? $canvys['current_sidebar_layout'] : null;

$per_row = 'no-sidebar' == $sidebar_layout ? 3 : 2;
$num_rows = 2;

$term_ids = array();
if ( $terms = get_the_terms( get_the_ID(), 'portfolio_categories' ) ) {
   foreach ( $terms as $term ) {
      $term_ids[] = $term->term_id;
   }
}

// Grab related posts
$posts = get_posts( array(
   'posts_per_page' => $per_row*$num_rows,
   'post__not_in' => array( get_the_ID() ),
   'post_type' => 'portfolio_item',
   'tax_query' => array(
      array(
         'taxonomy' => 'portfolio_categories',
         'field'    => 'id',
         'terms'    => $term_ids,
      ),
   ),
) );

if ( is_array( $posts ) && ( $per_row - 1 ) < count( $posts ) ) :

   $counter = 0;

   echo '<div class="related-posts">';
   echo '<h4>' . sprintf( __( 'Related %s', 'canvys' ), CV_PORTFOLIO_PLURAL_LABEL ) . '</h4>';
   echo '<div class="cv-grid-' . $per_row . ' spacing-1 has-clearfix">';

   foreach ( $posts as $post ) : setup_postdata( $post );

      $counter++;

      $visibility_class = $per_row < $counter ? ' visible-over-1' : null;

      echo '<div class="related-post' . $visibility_class . '">';
      echo cv_get_post_tile( array( 'ratio' => '5x2', 'img_size' => 'cv_square_large', 'hide_thumbnail' => false ) );
      echo '</div>';

   endforeach; wp_reset_query();

   echo '</div>';
   echo '</div>';

endif;