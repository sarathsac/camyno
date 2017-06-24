<?php

if ( ! class_exists( 'WP_Widget' ) ) return;

/**
 * Recent Posts Widget
 *
 * @return nothing
 */
class cv_qr_code_widget extends WP_Widget {

   /**
    * Register widget with WordPress
    */
   public function cv_qr_code_widget() {

      $widget_ops = array(
         'classname' => 'cv-qr-code-widget',
         'description' => __( 'Displays a QR code from a URL.', 'canvys' )
      );

      $control_ops = array(
         'width' => 300,
         'height' => 350,
         'id_base' => 'cv_qr_code'
      );

      parent::__construct(
         'cv_qr_code',
         sprintf( __('%s QR Code', 'canvys'), THEME_WIDGET_NAME ),
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

      global $canvys;

      // Extract settings
      extract( $args ); extract( $instance );

      if ( ! $url ) {
         $url = $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
      }

      echo $before_widget;

      if ( $title ) {
         echo $before_title . apply_filters( 'widget_title', $title ) . $after_title;
      }

      // Create the box
      $qr_code = new CV_HTML( '<img />', array(
         'class' => 'cv-qr-code',
         'src' => 'https://chart.googleapis.com/chart?cht=qr&chs=400x400&chl=' . $url,
         'alt' => $url,
      ) );

      echo '<a href="' . $url . '">' . $qr_code . '</a>';

      echo $after_widget;

   }

   /**
    * back end display of widget form
    *
    * @param array $instance Previously saved values from database.
    */
   public function form( $instance ) {

      // Set up default settings
      $defaults = array(
         'title' => null,
         'url' => null,
      );

      // Create current instance using any available options
      $instance = wp_parse_args( (array) $instance, $defaults ); ?>

      <p>
         <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'canvys'); ?></label>
         <input type="text" id="<?php echo $this->get_field_id('title'); ?>" class="widefat" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
      </p>
      <p>
         <label for="<?php echo $this->get_field_id('url'); ?>"><?php _e( 'QR Code URL:', 'canvys' ); ?></label>
         <input type="text" class="widefat number" placeholder="http://..." id="<?php echo $this->get_field_id('url'); ?>" name="<?php echo $this->get_field_name('url'); ?>" value="<?php echo $instance['url']; ?>" />
      </p>
      <p class="description">
         <?php _e( 'Specify a valid URL the QR code should be linked to. If no URL is specified the generated QR code will automatically link to the page it is being displayed on.', 'canvys' ); ?>
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
         'url' => cv_filter( $new_instance['url'], 'url' ),
      );

   }

}