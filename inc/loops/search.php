<?php

global $canvys;

if ( have_posts() ) :

   echo '<div class="posts-wrapper style-search">';

   while ( have_posts() ) : the_post();

   // grap the post type
   $post_type_obj = get_post_type_object( get_post_type() );
   $post_type_name = $post_type_obj->labels->singular_name;

   // Standard post-title
   $standard_title = '<h2 class="post-title"><a href="' . get_permalink() . '">' . get_the_title() . '</a></h2>'; ?>

   <article id="post-<?php echo get_the_ID(); ?>" <?php post_class('search-result'); ?>>

   <?php if ( 'post' == get_post_type() ) {
      switch ( cv_get_post_format() ) {

         case 'quote':
            echo '<h2 class="post-title"><a href="' . get_permalink() . '">' . get_the_content() . '</a></h2>';
            echo '<h4 class="quote-author">' . get_the_title() . '</h4>';
            break;

         case 'aside':
            echo '<div class="post-content">' . get_the_content() . '</div>';
            break;

         default:
            echo $standard_title;
            break;
      }
   }

   else {
      echo $standard_title;
   } ?>

   <p class="result-meta">
      <a class="permalink" href="<?php echo get_permalink(); ?>" title="<?php _e( 'Permalink', 'canvys' ); ?>">
         <?php echo $post_type_name; ?> &middot;
         <?php echo get_the_date(); ?>
      </a>
   </p>

   </article>

   <?php endwhile;

   echo '</div>';

else: ?>

<p><?php _e( 'No results found, please try a different search.', 'canvys' ); ?></p>

<?php endif;