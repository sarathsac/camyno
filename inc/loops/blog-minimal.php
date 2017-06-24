<?php

global $canvys;

if ( have_posts() ) :

   $is_single_class = is_single() ? 'is-single' : 'not-single';

   echo '<div class="posts-wrapper style-minimal ' . $is_single_class . '">';

   while ( have_posts() ) : the_post();

      // grab the post class
      $post_class = ' class="' . implode( ' ', get_post_class( 'style-minimal' ) ) . '"';

      // Post Wrapper
      echo '<article id="post-' . get_the_ID() . '"' . $post_class . '>';
      echo '<div class="post-inner">';

      // Categories
      if ( $categories = get_the_category() ) {
         echo '<div class="post-category">';
         foreach ( $categories as $category ) {
            echo '<a href="' . get_category_link( $category->term_id ) . '" title="' . esc_attr( sprintf( __( 'View all posts in %s', 'canvys' ), $category->name ) ) . '">' . $category->cat_name . '</a>';
         }
         echo '</div>';
      }

      // Entry Title
      switch ( cv_get_post_format() ) {

         case 'quote':
            echo '<h2 class="post-title"><a href="' . get_permalink() . '">' . strip_tags( get_the_content() ) . '</a></h2>';
            break;

         case 'aside':
            echo '<div class="post-content">' . get_the_content() . '</div>';
            break;

         default:
            echo '<h2 class="post-title"><a href="' . get_permalink() . '">' . get_the_title() . '</a></h2>';
            break;

      }

      // Entry meta
      cv_entry_meta( array( 'date', 'author', 'comments' ) );

      echo '</div>';
      echo '</article>';

   endwhile;

   echo '</div>';

endif;