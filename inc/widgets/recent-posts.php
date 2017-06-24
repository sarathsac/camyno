<?php

if ( ! class_exists( 'WP_Widget' ) ) return;

/**
 * Recent Posts Widget
 *
 * @return nothing
 */
class cv_recent_posts_widget extends WP_Widget {

   /**
    * Register widget with WordPress
    */
   public function cv_recent_posts_widget() {

      $widget_ops = array(
         'classname' => 'cv-recent-posts-widget',
         'description' => __( 'Displays recent posts, optionally by format.', 'canvys' )
      );

      $control_ops = array(
         'width' => 300,
         'height' => 350,
         'id_base' => 'cv_recent_posts'
      );

      parent::__construct(
         'cv_recent_posts',
         sprintf( __('%s Recent Posts', 'canvys'), THEME_WIDGET_NAME ),
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

      echo $before_widget;

      if ( $title ) {
         echo $before_title . apply_filters( 'widget_title', $title ) . $after_title;
      }

      // If no format has been specified
      if ( 'none' == $format ) {

         $posts = get_posts( array(
            'posts_per_page' => $number
         ) );

      }

      // If standard format has been specified
      else if ( 'standard' == $format ) {

         $posts = get_posts( array(
            'posts_per_page' => $number,
            'tax_query' => array( array(
               'taxonomy' => 'post_format',
               'field' => 'slug',
               'terms' => array(
                  'post-format-aside',
                  'post-format-chat',
                  'post-format-gallery',
                  'post-format-link',
                  'post-format-image',
                  'post-format-video',
                  'post-format-quote'
               ),
               'operator' => 'NOT IN'
            ) )
         ) );

      }

      // If a format has been specified
      else {

         $posts = get_posts( array(
            'posts_per_page' => $number,
            'tax_query' => array( array(
               'taxonomy' => 'post_format',
               'field' => 'slug',
               'terms' => array( 'post-format-' . $format )
            ) )
         ) );

      }

      // Display posts, if there are any
      if ( is_array($posts) ) :

         echo '<ul class="cv-recent-posts">';

         foreach ( $posts as $post ) :

            echo '<li class="has-clearfix">';

            $bg_style = null;
            if ( has_post_thumbnail( $post->ID ) ) {
               $id = get_post_thumbnail_id( $post->ID );
               if ( $img_info = wp_get_attachment_image_src( $id, 'cv_square_small' ) ) {
                  $bg_style = ' style="background-image: url(' . $img_info[0] . ');"';
               }
            }
            echo '<a href="' . get_permalink( $post->ID ) . '" class="entry-thumbnail"' . $bg_style . '></a>';

            // Display the title
            echo '<div class="entry-title">';
            echo '<a href="' . get_permalink( $post->ID ) . '">' . get_the_title ( $post->ID ) . '</a>';
            echo '</div>';

            // Display the time
            echo '<div class="entry-description"><span>' . get_the_time( 'F j, Y - g:i a', $post->ID ) . '</span></div>';

            echo '</li>';

         endforeach;

         echo '</ul>';

      else:

         // If no posts to show, display a message
         echo '<p>' . __('Sorry, no posts to show!', 'canvys') . '</p>';

      endif;

      wp_reset_query();

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
         'format' => 'none',
         'number' => '5'
      );

      // Available Formats
      $formats = array_merge( array(
         'none' => __( 'All formats', 'canvys' ),
         'standard' => __( 'Standard format only', 'canvys' ),
      ), $canvys['supported_post_formats'] );

      // Create current instance using any available options
      $instance = wp_parse_args( (array) $instance, $defaults ); ?>

      <p>
         <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'canvys'); ?></label>
         <input type="text" id="<?php echo $this->get_field_id('title'); ?>" class="widefat" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
      </p>
      <p>
         <label for="<?php echo $this->get_field_id('format'); ?>"><?php _e('Format:', 'canvys'); ?></label>
         <select id="<?php echo $this->get_field_id('format'); ?>" name="<?php echo $this->get_field_name('format'); ?>" class="widefat">
            <?php foreach ($formats as $key => $name) {
               echo '<option value="' . $key . '" ' . selected( $key, $instance['format'], false) . '>' . $name . '</option>';
            } ?>
         </select>
      </p>
      <p>
         <label for="<?php echo $this->get_field_id('number'); ?>"><?php _e( 'Number of posts to show:', 'canvys' ); ?></label>
         <input type="text" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" value="<?php echo $instance['number']; ?>" size="3" />
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

      $formats = array( 'none', 'standard', 'aside', 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'video' );

      return array(
         'title' => cv_filter( $new_instance['title'], 'text' ),
         'format' => cv_filter( $new_instance['format'], $formats ),
         'number' => cv_filter( $new_instance['number'], 'integer' ),
      );

   }

}