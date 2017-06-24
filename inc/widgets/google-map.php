<?php

if ( ! class_exists( 'WP_Widget' ) ) return;

/**
 * Recent Posts Widget
 *
 * @return nothing
 */
class cv_google_map_widget extends WP_Widget {

   /**
    * Register widget with WordPress
    */
   public function cv_google_map_widget() {

      $widget_ops = array(
         'classname' => 'cv-google-map-widget',
         'description' => __( 'Displays a Google Map.', 'canvys' )
      );

      $control_ops = array(
         'width' => 300,
         'height' => 350,
         'id_base' => 'cv_google_map'
      );

      parent::__construct(
         'cv_google_map',
         sprintf( __('%s Google Map', 'canvys'), THEME_WIDGET_NAME ),
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

      echo $before_widget;

      if ( $title ) {
         echo $before_title . apply_filters( 'widget_title', $title ) . $after_title;
      }

      if ( $lat && $lng ) {

         $marker = '[cv_map_marker coordinates="' . $lat . ',' . $lng . '"][/cv_map_marker]';

         echo $canvys['shortcodes']['cv_map']->callback( array(
            'controls' => $controls,
            'height' => $height,
            'zoom' => $zoom,
            'color_scheme' => $color_scheme,
         ), $marker );

      }

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
         'title' => '',
         'address' => null,
         'lat' => null,
         'lng' => null,
         'height' => null,
         'controls' => 'none',
         'zoom' => '15',
      );

      // Available Zoom levels
      $zoom_levels = array();
      for ( $i = 1; $i < 22; $i++ ) {
         $zoom_levels[$i] = $i;
      }

      // Available Color Scheme Options
      $color_scheme_options = array(
         'none'      => __( 'Default map styling', 'canvys' ),
         'main'      => __( 'Match the main content', 'canvys' ),
         'alternate' => __( 'Match the alternate content', 'canvys' ),
         'footer'    => __( 'Match the footer', 'canvys' ),
         'socket'    => __( 'Match the socket', 'canvys' ),
      );

      // Available Control Options
      $control_options = array(
         'none'    => __( 'No controls', 'canvys' ),
         'default' => __( 'Pan & zoom', 'canvys' ),
         'pan'     => __( 'Pan only', 'canvys' ),
         'zoom'    => __( 'Zoom only', 'canvys' ),
      );

      // Create current instance using any available options
      $instance = wp_parse_args( (array) $instance, $defaults ); ?>

      <p>
         <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'canvys'); ?></label>
         <input type="text" id="<?php echo $this->get_field_id('title'); ?>" class="widefat" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
      </p>
      <p>
         <label for="<?php echo $this->get_field_id('color_scheme'); ?>"><?php _e('Color Scheme:', 'canvys'); ?></label>
         <select id="<?php echo $this->get_field_id('color_scheme'); ?>" name="<?php echo $this->get_field_name('color_scheme'); ?>" class="widefat">
            <?php foreach ($color_scheme_options as $key => $name) {
               echo '<option value="' . $key . '" ' . selected( $key, $instance['color_scheme'], false) . '>' . $name . '</option>';
            } ?>
         </select>
      </p>
      <p>
         <label for="<?php echo $this->get_field_id('controls'); ?>"><?php _e('Controls:', 'canvys'); ?></label>
         <select id="<?php echo $this->get_field_id('controls'); ?>" name="<?php echo $this->get_field_name('controls'); ?>" class="widefat">
            <?php foreach ($control_options as $key => $name) {
               echo '<option value="' . $key . '" ' . selected( $key, $instance['controls'], false) . '>' . $name . '</option>';
            } ?>
         </select>
      </p>
      <p>
         <label for="<?php echo $this->get_field_id('zoom'); ?>"><?php _e('Zoom Level:', 'canvys'); ?></label>
         <select id="<?php echo $this->get_field_id('zoom'); ?>" name="<?php echo $this->get_field_name('zoom'); ?>" class="widefat">
            <?php foreach ($zoom_levels as $key => $name) {
               echo '<option value="' . $key . '" ' . selected( $key, $instance['zoom'], false) . '>' . $name . '</option>';
            } ?>
         </select>
      </p>
      <p>
         <label for="<?php echo $this->get_field_id('height'); ?>"><?php _e( 'Custom Height:', 'canvys' ); ?></label>
         <input type="text" class="widefat number" id="<?php echo $this->get_field_id('height'); ?>" name="<?php echo $this->get_field_name('height'); ?>" value="<?php echo $instance['height']; ?>" size="3" placeholder="300" />
      </p>
      <p>
         <label for="<?php echo $this->get_field_id('address'); ?>"><?php _e( 'Address:', 'canvys' ); ?></label>
         <input type="text" class="widefat cv-map-address" id="<?php echo $this->get_field_id('address'); ?>" name="<?php echo $this->get_field_name('address'); ?>" value="<?php echo $instance['address']; ?>" size="3" />
      </p>
      <p>
         <a class="button cv-get-map-coordinates"><?php _e( 'Get Coordinates', 'canvys' ); ?></a>
      </p>
         <?php _e( 'First enter a full address in the specified field above, then press the "Get Coordinates" button above to convert the address into usable coordinates. Alternatively you can enter your own coordinates in the fields below.', 'canvys' ); ?>
      <p>
         <label for="<?php echo $this->get_field_id('lat'); ?>"><?php _e( 'Latitude:', 'canvys' ); ?></label>
         <input type="text" class="widefat number cv-map-lat" id="<?php echo $this->get_field_id('lat'); ?>" name="<?php echo $this->get_field_name('lat'); ?>" value="<?php echo $instance['lat']; ?>" size="3" />
      </p>
      <p>
         <label for="<?php echo $this->get_field_id('lng'); ?>"><?php _e( 'Longitude:', 'canvys' ); ?></label>
         <input type="text" class="widefat number cv-map-lng" id="<?php echo $this->get_field_id('lng'); ?>" name="<?php echo $this->get_field_name('lng'); ?>" value="<?php echo $instance['lng']; ?>" size="3" />
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

      // Available Zoom levels
      $zoom_levels = array();
      for ( $i = 1; $i < 22; $i++ ) {
         $zoom_levels[$i] = $i;
      }

      // Available Control Options
      $control_options = array( 'default', 'pan', 'zoom', 'none', );

      // Available Color Scheme Options
      $color_scheme_options = array( 'none', 'main', 'alternate', 'footer', 'socket', );

      return array(
         'title' => cv_filter( $new_instance['title'], 'text' ),
         'address' => cv_filter( $new_instance['address'], 'text' ),
         'lat' => cv_filter( $new_instance['lat'], 'text' ),
         'lng' => cv_filter( $new_instance['lng'], 'text' ),
         'height' => cv_filter( $new_instance['height'], 'integer' ),
         'controls' => cv_filter( $new_instance['controls'], $control_options ),
         'color_scheme' => cv_filter( $new_instance['color_scheme'], $color_scheme_options ),
         'zoom' => cv_filter( $new_instance['zoom'], $zoom_levels ),
      );

   }

}