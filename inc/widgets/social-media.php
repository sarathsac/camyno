<?php

if ( ! class_exists( 'WP_Widget' ) ) return;

/**
 * Recent Posts Widget
 *
 * @return nothing
 */
class cv_social_media_widget extends WP_Widget {

   /**
    * Register widget with WordPress
    */
   public function cv_social_media_widget() {

      $widget_ops = array(
         'classname' => 'cv-social-media-widget',
         'description' => __( 'Displays your saved social media outlets.', 'canvys' )
      );

      $control_ops = array(
         'width' => 300,
         'height' => 350,
         'id_base' => 'cv_social_media'
      );

      parent::__construct(
         'cv_social_media',
         sprintf( __('%s Social Media', 'canvys'), THEME_WIDGET_NAME ),
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

      echo cv_get_social_outlets( $outlets );

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
         'outets' => null,
      );

      // Array of available social outlets
      $available_social_outlets = array();
      $saved_social_outlets = cv_theme_setting( 'social', 'profiles' );
      if ( ! empty( $saved_social_outlets ) ) {
         foreach ( $saved_social_outlets as $outlet => $url ) {
            if ( ! $url ) continue;
            $available_social_outlets[$outlet] = $canvys['social_outlets'][$outlet];
         }
      }

      // Create current instance using any available options
      $instance = wp_parse_args( (array) $instance, $defaults ); ?>

      <p>
         <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'canvys'); ?></label>
         <input type="text" id="<?php echo $this->get_field_id('title'); ?>" class="widefat" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
      </p>
      <p>
         <label for="<?php echo $this->get_field_id('outlets'); ?>"><?php _e('Social media Outlets:', 'canvys'); ?></label>
         <select style="height: 150px;" id="<?php echo $this->get_field_id('outlets'); ?>" name="<?php echo $this->get_field_name('outlets'); ?>[]" class="widefat" multiple="multiple">
            <?php foreach ($available_social_outlets as $key => $name) {
               echo '<option value="' . $key . '" ' . selected( in_array( $key, $instance['outlets'] ), true, false) . '>' . $name . '</option>';
            } ?>
         </select>
      </p>
      <p class="description"><?php _e('Select which social media outlets should be displayed, if none are selected then all outlets will be shown.', 'canvys'); ?></p>

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
         'outlets' => $new_instance['outlets'],
      );

   }

}