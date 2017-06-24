<?php

$show_featured_image = has_post_thumbnail();
$featured = null;

if ( $gallery = cv_get_format_meta( 'gallery' ) ) {
   if ( isset( $gallery['ids'] ) && $gallery['ids'] ) {

      // Create the array of ID`s
      $ids = array_slice( explode( ',', $gallery['ids'] ), 0, 8 );

      // Create array of images
      $images = array();
      foreach ( $ids as $id ) {

         // Grab the WP post object
         $img_object = get_post( $id );

         // Grab the two image sizes
         $full_size = wp_get_attachment_image_src( $id, 'full' );
         $inline_size = wp_get_attachment_image_src( $id, 'cv_featured_large' );

         // Create the html
         if ( $img_object && $full_size ) {
            $img  = '<a href="' . $full_size[0] . '" title="' . $img_object->post_excerpt . '" class="image-hover no-scaling cv-lightbox-gallery-item" data-icon="expand">';
            $img .= '<span class="cv-scalable-5x2">';
            $img .= '<span class="scalable-content bg-style-cover" style="background-image:url(' . $inline_size[0] . ');"></span>';
            $img .= '</span>';
            $img .= '</a>';
         }
         else {
            $img = __( 'There was an error retrieving the image', 'canvys' );
         }

         $images[] = $img;

      }

      // Determine the best layout
      switch ( count( $ids ) ) {
         case 8: $layout = array( 4, 4 ); break;
         case 7: $layout = array( 3, 4 ); break;
         case 6: $layout = array( 2, 4 ); break;
         case 5: $layout = array( 1, 4 ); break;
         case 4: $layout = array( 1, 3 ); break;
         case 3: $layout = array( 1, 2 ); break;
         case 2: $layout = array( 2    ); break;
         case 1: $layout = array( 1    ); break;
      }

      $position = 0;
      $featured = '<div class="post-featured-gallery cv-lightbox-gallery">';
      foreach ( $layout as $row ) {
         $featured .= 1 == $row ? '<div>' : '<div class="cv-split-' . $row . ' spacing-1 not-responsive has-clearfix">';
         for ( $i=0; $i<$row; $i++ ) {
            $featured .= '<div>' . $images[$position] . '</div>';
            $position++;
         }
         $featured .= '</div>';
      }
      $featured .= '</div>';

      // Do not show the standard featured image
      $show_featured_image = false;

   }
} ?>

<?php if ( ! is_single() && ( $featured || $show_featured_image ) ) {
   echo '<div class="post-featured-content">';
   if ( $show_featured_image ) cv_entry_featured_image();
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

<?php if ( is_single() && ( $featured || $show_featured_image ) ) {
   echo '<div class="post-featured-content">';
   if ( $show_featured_image ) cv_entry_featured_image();
   echo $featured;
   echo '</div>';
} ?>

<?php $content = is_single() || ! get_option('rss_use_excerpt') ? get_the_content() : get_the_excerpt(); ?>
<div class="entry-content"><?php echo apply_filters( 'the_content', $content ); ?></div>
</div>