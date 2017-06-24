<?php

global $canvys, $post;

// Make sure we`re on a single post page
if ( ! is_single() ) return;

// Post formats which can have related posts
$allowed_formats = array( 'image', 'video', 'audio', 'chat', 'aside', 'gallery' );

// Make sure current post format is supported
if ( ! in_array( cv_get_post_format(), array_merge( array('standard'), $allowed_formats ) ) ) return;

// Create list of formats to not include
$disallowed_formats = array();
foreach ( array( 'quote', 'link', 'aside' ) as $format ) {
   $disallowed_formats[] = 'post-format-' . $format;
}

$sidebar_layout = isset( $canvys['current_sidebar_layout'] ) ? $canvys['current_sidebar_layout'] : null;

$per_row = 'no-sidebar' == $sidebar_layout ? 3 : 2;
$num_rows = 2;

$cat_ids = '';
if ( $categories = get_the_category() ) {
   foreach ( $categories as $category ) {
      $cat_ids .= $category->term_id . ',';
   }
}
$cat_ids = trim( $cat_ids, ',' );

// Grab related posts
$posts = get_posts( array(
   'cat' => $cat_ids,
   'posts_per_page' => $per_row*$num_rows,
   'post__not_in' => array( get_the_ID() ),
   'tax_query' => array( array(
      'taxonomy' => 'post_format',
      'field' => 'slug',
      'terms' => $disallowed_formats,
      'operator' => 'NOT IN'
   ) ),
) );

if ( is_array( $posts ) && ( $per_row - 1 ) < count( $posts ) ) :

   $counter = 0;

   echo '<div class="related-posts">';
   echo '<h4>' . __( 'Related Posts', 'canvys' ) . '</h4>';
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