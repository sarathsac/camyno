<?php

global $canvys, $num_columns;

$num_columns = $num_columns ? $num_columns : 3;

if ( have_posts() ) :

   echo '<div class="posts-wrapper style-masonry masonry-layout cv-grid-' . $num_columns . ' spacing-2 has-clearfix">';

   while ( have_posts() ) : the_post(); ?>

   <div class="post-layout-wrapper">

      <article id="post-<?php echo get_the_ID(); ?>" <?php post_class('style-masonry'); ?>>

         <?php get_template_part( 'inc/formats/' . cv_get_post_format() ); ?>

         <p class="post-masonry-meta has-clearfix">
            <?php
            echo '<a class="date" href="' . get_permalink() . '">' . get_the_date() . '</a>';
            if ( comments_open() && 'page' != get_post_type() ) {
               echo '<a class="comments" href="' . get_comments_link() . '"><i class="icon-comment"></i> ' . get_comments_number() . '</a>';
            } ?>
         </p>

      </article>

   </div>

   <?php endwhile;

   echo '</div>';

endif;