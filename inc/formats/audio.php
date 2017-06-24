<?php $featured = null;
if ( $audio = cv_get_format_meta( 'audio' ) ) {
   $mp3 = isset ( $audio['mp3'] ) ? $audio['mp3'] : null;
   $ogg = isset ( $audio['ogg'] ) ? $audio['ogg'] : null;
   $featured  = '<div class="post-featured-audio">';
   $featured .= '[audio mp3="' . $mp3 . '" ogg="' . $ogg . '"]';
   $featured .= '</div>';
   $featured = do_shortcode( $featured );
} ?>

<?php if ( ! is_single() && ( $featured || has_post_thumbnail() ) ) {
   echo '<div class="post-featured-content">';
   cv_entry_featured_image();
   echo $featured;
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

<?php if ( is_single() && ( $featured || has_post_thumbnail() ) ) {
   echo '<div class="post-featured-content">';
   cv_entry_featured_image();
   echo $featured;
   echo '</div>';
} ?>

<?php $content = is_single() || ! get_option('rss_use_excerpt') ? get_the_content() : get_the_excerpt(); ?>
<div class="entry-content"><?php echo apply_filters( 'the_content', $content ); ?></div>
</div>