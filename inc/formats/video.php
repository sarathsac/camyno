<?php $featured = null;
if ( $video = cv_get_format_meta( 'video' ) ) {

   $source = isset ( $video['source'] ) ? $video['source'] : null;

   switch ( $source ) {
      case 'hosted':
         $mp4    = isset ( $video['mp4'] ) ? $video['mp4'] : null;
         $ogv    = isset ( $video['ogv'] ) ? $video['ogv'] : null;
         $poster = isset ( $video['poster'] ) ? ' poster="' . $video['poster'] . '"' : null;
         if ( $mp4 || $ogv ) {
            $featured  = '<div class="post-featured-video">';
            $featured .= '<video class="wp-video-shortcode" style=""' . $poster . ' controls>';
            if ( $mp4 ) $featured .= '<source src="' . $mp4 . '" type="video/mp4">';
            if ( $ogv ) $featured .= '<source src="' . $ogv . '" type="video/ogg">';
            $featured .= '<strong>' . __( 'Your browser does not support HTML5 video', 'canvys' ) . '</strong>';
            $featured .= '</video>';
            $featured .= '</div>';
         }
         break;
      case 'embed':
         if ( $embed = isset ( $video['embed'] ) ? $video['embed'] : false ) {
            $featured = wp_oembed_get( $embed );
         }
         break;
   }

} ?>

<?php if ( ! $featured ) {

   // No special styling required
   get_template_part( 'inc/formats/standard' );

   return;

} ?>

<?php if ( ! is_single() ) {
   echo '<div class="post-featured-content">';
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

<?php if ( is_single() ) {
   echo '<div class="post-featured-content">';
   echo $featured;
   echo '</div>';
} ?>

<?php $content = is_single() || ! get_option('rss_use_excerpt') ? get_the_content() : get_the_excerpt(); ?>
<div class="entry-content"><?php echo apply_filters( 'the_content', $content ); ?></div>
</div>