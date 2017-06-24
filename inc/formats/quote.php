<div class="post-featured-box post-featured-quote">
   <div class="primary-content quote-content"><p><a href="<?php the_permalink(); ?>"><?php echo strip_tags( get_the_content() ); ?></a></p></div>
   <div class="secondary-content quote-author"><p><?php the_title(); ?></p></div>
</div>

<?php cv_entry_meta( array( 'author', 'date', 'category', 'comments' ) ); ?>