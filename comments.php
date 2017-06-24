<?php

/**
 * The template for displaying Comments
 *
 * The area of the page that contains comments and the comment form.
 *
 * @package WordPress
 * @subpackage Camyno
 * @since 1.0
 */

if ( post_password_required() ) {
   return;
}

?><div id="comments">

   <?php if ( have_comments() ) : /* Check if we have comments */ ?>

      <div class="comments-title cv-divider has-clearfix">

         <h3 id="comments-title">
            <?php printf( _n('1 Response' , '%1$s Responses' , get_comments_number(), 'canvys') , number_format_i18n( get_comments_number() ) ); ?>
         </h2>

         <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : ?>
            <span class="comment-page-nav has-clearfix">
               <span class="comment-page-nav-prev">
                  <?php previous_comments_link(__('Older', 'canvys')); ?>
               </span>
               <span class="comment-page-nav-next">
                  <?php next_comments_link(__('Newer','canvys')); ?>
               </span>
            </span>
         <?php endif; /* Comment navigation */ ?>
      </div>

      <ol class="comment-list">

         <?php
            // Call the function to display the list of comments
            wp_list_comments( array('callback' => 'cv_comments_list') ); ?>

      </ol>

      <?php if ( false && get_comment_pages_count() > 1 && get_option('page_comments') ) : ?>

         <nav class="comment-page-nav comment-page-nav-bottom has-clearfix">
            <span class="comment-page-nav-prev">
               <?php previous_comments_link(__('Older', 'canvys')); ?>
            </span>
            <span class="comment-page-nav-next">
               <?php next_comments_link(__('Newer','canvys')); ?>
            </span>
         </nav>

      <?php endif; /* Comment navigation */ ?>

   <?php elseif ( ! comments_open() ) : /* If there are no comments */ ?>

      <div class="comments-title cv-divider has-clearfix">
         <div class="divider-inner textual-divider" style="width:100%;">
            <h4 class="divider-text">
               <?php _e('Comments are closed', 'canvys'); ?>
            </h4>
         </div>
      </div>

   <?php endif; ?>

   <?php if ( comments_open() ) : ?>
      <div class="comment-form">
         <?php comment_form(); ?>
      </div>
   <?php endif; ?>

</div>

<?php

/**
 * Helper function that loops through and displays each comment
 *
 * @param string $url image URL
 * @return int
 */
function cv_comments_list( $comment, $args, $depth ) {

   $GLOBALS['comment'] = $comment; ?>

   <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">

      <div id="comment-<?php comment_ID(); ?>" class="comment has-clearfix">

         <div class="comment-author-icon visible-over-1">
            <?php echo get_avatar( $comment, '45' ); ?>
         </div>

         <div class="comment-container">

            <div class="comment-author">
               <strong class="author-name"><?php comment_author_link(); ?></strong>
            </div>

            <ul class="comment-meta cloud-list has-clearfix">

               <li>
                  <a class="time-stamp" href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>">
                     <?php printf( __( '%1$s - %2$s', 'canvys' ), get_comment_date(),  get_comment_time() ) ?>
                  </a>
               </li>

               <?php if ( $post = get_post( get_the_ID() ) ) :
                  if ( $comment->user_id === $post->post_author ) {
                     echo '<li><span class="author-note">' . __('Post Author', 'canvys') . '</span></li>';
                  }
               endif; ?>

               <?php comment_reply_link(array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'], 'before' => '<li>', 'after' => '</li>' ) ) ); ?>

               <?php edit_comment_link( __( __( 'Edit', 'canvys' ), 'canvys'), '<li>', '</li>' ) ?>

            </ul>

            <div class="comment-text">
               <?php comment_text(); ?>
               <?php if ( '0' == $comment->comment_approved ) : ?>
                  <em><?php _e('Your comment is awaiting moderation.','canvys') ?></em>
               <?php endif; ?>
            </div>

         </div>

      <!--end .comment-->
      </div>

   </li>

<?php
}