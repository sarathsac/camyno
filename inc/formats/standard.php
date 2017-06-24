
<?php if ( ! is_single() && has_post_thumbnail() ) {
   echo '<div class="post-featured-content">';
   cv_entry_featured_image();
   echo '</div>';
} ?>

<div class="post-box">
<?php
   if ( is_single() ) :
      the_title( '<h1 class="post-title">', '</h1>' );
   else :
      the_title( sprintf( '<h2 class="post-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
   endif;
?>
<?php cv_entry_meta( array( 'author', 'date', 'category', 'comments' ) ); ?>

<?php if ( is_single() && has_post_thumbnail() ) {
   echo '<div class="post-featured-content">';
   cv_entry_featured_image();
   echo '</div>';
} ?>

<?php $content = is_single() || ! get_option('rss_use_excerpt') ? get_the_content() : get_the_excerpt(); ?>
<div class="entry-content"><?php echo apply_filters( 'the_content', $content ); ?></div>
</div>