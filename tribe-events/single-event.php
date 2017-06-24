<?php
/**
 * Single Event Template
 *
 * @package    WordPress
 * @subpackage Canvys
 * @since      Version 1.0
 *
 */

if ( !defined('ABSPATH') ) { die('-1'); }

$event_id = get_the_ID();

?>

<div id="tribe-events-content" class="tribe-events-single">

   <!-- Notices -->
   <?php tribe_events_the_notices() ?>

   <?php while ( have_posts() ) :  the_post(); ?>
      <div id="post-<?php the_ID(); ?>" <?php post_class('vevent'); ?>>

         <div class="content-wrap">

            <div class="description-wrap has-clearfix">

               <!-- Event featured image -->
               <?php if ( has_post_thumbnail() ) {
                  $img_id = get_post_thumbnail_id();
                  $img_data = wp_get_attachment_image_src( $img_id, 'cv_featured_tall' );
                  echo '<div class="event-featured-image">';
                  echo '<img style="display:block;width:100%;" src="' . $img_data[0] . '" alt="' . get_the_title() . '" />';
                  echo '</div>';
               } ?>

               <!-- Event title -->
               <?php the_title( '<h2 class="tribe-events-single-event-title summary">', '</h2>' ); ?>

               <!-- Event info -->
               <div class="tribe-events-schedule updated published tribe-clearfix">
                  <?php echo tribe_events_event_schedule_details( $event_id, '<h3>', '</h3>'); ?>
                  <?php  if ( tribe_get_cost() ) :  ?>
                     <span class="tribe-events-divider">|</span>
                     <span class="tribe-events-cost"><?php echo tribe_get_cost( null, true ) ?></span>
                  <?php endif; ?>
               </div>

               <!-- Event content -->
               <?php do_action( 'tribe_events_single_event_before_the_content' ) ?>
               <div class="tribe-events-single-event-description tribe-events-content entry-content description">
                  <?php the_content(); ?>
               </div><!-- .tribe-events-single-event-description -->
               <?php do_action( 'tribe_events_single_event_after_the_content' ) ?>

            </div>

            <div class="meta-wrap">

               <!-- Back to events button -->
               <a href="<?php echo tribe_get_events_link(); ?>" class="cv-events-return-button visible-over-2">
                  <?php _e( 'Return To All Events', 'canvys' ); ?>
               </a>

               <!-- Event meta -->
               <?php do_action( 'tribe_events_single_event_before_the_meta' ) ?>
               <?php tribe_get_template_part( 'modules/meta' ); ?>

            </div>

         </div>

         <?php do_action( 'tribe_events_single_event_after_the_meta' ) ?>

      </div><!-- .hentry .vevent -->

      <?php if ( get_post_type() == TribeEvents::POSTTYPE && tribe_get_option( 'showComments', false ) ) comments_template(); ?>
   <?php endwhile; ?>

   <!-- Event footer -->
    <div id="tribe-events-footer">
      <!-- Navigation -->
      <!-- Navigation -->
      <h3 class="tribe-events-visuallyhidden"><?php _e( 'Event Navigation', 'canvys' ) ?></h3>
      <ul class="tribe-events-sub-nav">
         <li class="tribe-events-nav-previous"><?php tribe_the_prev_event_link( '<span>&laquo;</span> %title%' ) ?></li>
         <li class="tribe-events-nav-next"><?php tribe_the_next_event_link( '%title% <span>&raquo;</span>' ) ?></li>
      </ul><!-- .tribe-events-sub-nav -->
   </div><!-- #tribe-events-footer -->

</div><!-- #tribe-events-content -->
