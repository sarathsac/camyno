<?php

global $canvys;

if ( have_posts() ) :

   $is_single_class = is_single() ? 'is-single' : 'not-single';
   echo '<div class="posts-wrapper style-standard ' . $is_single_class . '">';

   while ( have_posts() ) : the_post(); ?>

   <article id="post-<?php echo get_the_ID(); ?>" <?php post_class('style-standard'); ?>>

      <?php get_template_part( 'inc/formats/' . cv_get_post_format() ); ?>

   </article>

   <?php endwhile;

   echo '</div>';

endif;