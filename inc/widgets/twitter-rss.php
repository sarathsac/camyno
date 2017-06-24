<?php

if ( ! class_exists( 'WP_Widget' ) ) return;

/**
 * RSS & Twitter Widget
 *
 * @return nothing
 */
class cv_twitter_rss_widget extends WP_Widget {

   /**
    * Register widget with WordPress
    */
   public function cv_twitter_rss_widget() {

      $widget_ops = array(
         'classname' => 'cv-rss-twitter-widget',
         'description' => __( 'Displays links to your Twitter & RSS feeds.', 'canvys' )
      );

      $control_ops = array(
         'width' => 300,
         'height' => 350,
         'id_base' => 'cv_twitter_rss'
      );

      parent::__construct(
         'cv_twitter_rss',
         sprintf( __('%s Twitter & RSS Feed', 'canvys'), THEME_WIDGET_NAME ),
         $widget_ops, $control_ops
      );
   }

   /**
    * Front end display of widget
    *
    * @param array $args - Widget arguments.
    * @param array $instance - Saved values from database.
    */
   public function widget( $args, $instance ) {

      // Extract settings
      extract( $args ); extract( $instance );

      if ( ! $twitter && ! $rss ) {
         return;
      }

      echo $before_widget;

      if ( $title ) {
         echo $before_title . apply_filters( 'widget_title', $title ) . $after_title;
      }

      echo '<div class="cv-twitter-rss-widget cv-split-2 not-responsive has-clearfix">';

      // Twitter feed URL
      if ( $twitter ) {
         echo '<a href="' . $twitter . '" class="twitter-feed">';
         echo '<i class="icon-twitter"></i>';
         echo '<strong>' . __( 'Follow', 'canvys' ) . '</strong>';
         echo '<span>' . __( 'On Twitter', 'canvys' ) . '</span>';
         echo '</a>';
      }

      // RSS Feed URL
      if ( $rss ) {
         echo '<a href="' . $rss . '" class="rss-feed">';
         echo '<i class="icon-rss"></i>';
         echo '<strong>' . __( 'Subscribe', 'canvys' ) . '</strong>';
         echo '<span>' . __( 'To RSS Feed', 'canvys' ) . '</span>';
         echo '</a>';
      }

      // Empty column
      if ( ! $twitter || ! $rss ) {
         echo '<div></div>';
      }

      echo '</div>';

      echo $after_widget;

   }

   /**
    * back end display of widget form
    *
    * @param array $instance Previously saved values from database.
    */
   public function form( $instance ) {

     global $canvys;

      // Set up default settings
      $defaults = array(
         'title' => '',
         'twitter' => '',
         'rss' => '',
      );

      // Create current instance using any available options
      $instance = wp_parse_args( (array) $instance, $defaults ); ?>

      <p>
         <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'canvys'); ?></label>
         <input type="text" id="<?php echo $this->get_field_id('title'); ?>" class="widefat" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
      </p>

      <p>
         <label for="<?php echo $this->get_field_id('twitter'); ?>"><?php _e('Twitter URL:', 'canvys'); ?></label>
         <input type="text" id="<?php echo $this->get_field_id('twitter'); ?>" class="widefat" name="<?php echo $this->get_field_name('twitter'); ?>" value="<?php echo $instance['twitter']; ?>" />
      </p>

      <p>
         <label for="<?php echo $this->get_field_id('rss'); ?>"><?php _e('RSS Feed URL:', 'canvys'); ?></label>
         <input type="text" id="<?php echo $this->get_field_id('rss'); ?>" class="widefat" name="<?php echo $this->get_field_name('rss'); ?>" value="<?php echo $instance['rss']; ?>" />
      </p>

   <?php }

   /**
    * Sanitize widget form values as they are saved
    *
    * @param array $new_instance - Values just sent to be saved.
    * @param array $old_instance - Previously saved values from database.
    *
    * @return array
    */
   public function update( $new_instance, $old_instance ) {

      return array(
         'title' => cv_filter( $new_instance['title'], 'text' ),
         'twitter' => cv_filter( $new_instance['twitter'], 'url' ),
         'rss' => cv_filter( $new_instance['rss'], 'url' ),
      );

   }

}