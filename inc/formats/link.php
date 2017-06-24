<?php

$custom_url = false;
if ( $link_meta = cv_get_format_meta( 'link' ) ) {
   if ( isset( $link_meta['url'] ) && $link_meta['url'] ) {
      $custom_url = $link_meta['url'];
   }
}

$link_url = $custom_url ? $custom_url : get_permalink(); ?>

<div class="post-featured-box post-featured-link">
   <div class="primary-content link-content"><p><a href="<?php echo $link_url; ?>"><?php the_title(); ?></a></p></div>
   <div class="secondary-content link-address"><p><?php echo $custom_url; ?></p></div>
</div>

<?php cv_entry_meta( array( 'author', 'date', 'category', 'comments' ) ); ?>