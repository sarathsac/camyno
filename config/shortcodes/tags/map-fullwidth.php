<?php

if ( ! class_exists('CV_Fullwidth_Map') ) :

/**
 * Full width Google Map
 *
 * @package      WordPress
 * @subpackage   Canvys
 * @since        Version 1.0
 */
class CV_Fullwidth_Map extends CV_Shortcode {

   /**
    * Function to create shortcode configuration
    *
    * @return void
    */
   public function __construct() {

      global $canvys;

      $zoom_levels = array();
      for ( $i = 1; $i < 22; $i++ ) {
         $zoom_levels[$i] = $i;
      }

      $this->config = array(

         // Handle will be used to use this shortcode
         'handle' => 'cv_fullwidth_map',

         // Whether or not this is a shortcode composer element
         'composer_element' => false,

         // Whether or not this is a template builder element
         'builder_element' => true,

         // Used by the template builder to determine where module can be dropped
         'drop_target' => 0,

         // Used by the template builder to determine where module can have other
         // modules dropped inside of it
         'drop_zone' => false,

         // Title will be used to identify this shortcode
         'title' => __( 'Full Width Map', 'canvys' ),

         // Icon will be used to represent this shortcode in composer/builder
         // List of available icons can be found in icons.json
         'icon' => 'map',

         // Whether or not shortcode is self closing
         'self_closing' => false,

         // If shortcode is not self closing, specify its default content
         'default_content' => '[cv_map_marker coordinates="40.7127837,-74.00594130000002" title="' . __( 'New York, NY', 'canvys' ) . '"]',

         // Specify whether or not content is directly editable
         'content_editor' => false,

         // Specify whether or not the content is composed of another shortcode
         'content_element' => 'cv_map_marker',

         // Provide an explanation of what this shortcode does
         'explanation' => __( 'This shortcode uses the Google Maps API to display a Google Map which can be configured to your preferences. If only one location marker has been added this marker will be used as the center of the map, if more than one has been added the center of the map will be the calculated center of the markers.', 'canvys' ),

         // Array of shortcode settings and their respective attributes
         'attributes' => array(

            new CV_Shortcode_Text_Control( 'id', array(
               'title'       => __( 'Map ID', 'canvys' ),
               'description' => __( 'Set the ID attribute for this map, this allows you to link to this map in the creation of a one page website.', 'canvys' ),
            ) ),

            new CV_Shortcode_Select_Control( 'zoom', array(
               'title'       => __( 'Zoom Level', 'canvys' ),
               'description' => __( 'Specify how much the map should be zoomed in upon load, 1 being 0% and 21 being 100%.', 'canvys' ),
               'default'     => '15',
               'options'     => $zoom_levels,
            ) ),

            new CV_Shortcode_Select_Control( 'controls', array(
               'title'       => __( 'Enabled Controls', 'canvys' ),
               'description' => __( 'Specify which controls should be displayed.', 'canvys' ),
               'default'     => 'default',
               'options'     => array(
                  'default' => __( 'Pan & zoom', 'canvys' ),
                  'pan'     => __( 'Pan only', 'canvys' ),
                  'zoom'    => __( 'Zoom only', 'canvys' ),
                  'none'    => __( 'No controls', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Select_Control( 'height', array(
               'title'       => __( 'Height', 'canvys' ),
               'description' => __( 'Specify the height for this map.', 'canvys' ),
               'default'     => 'none',
               'options'     => array(
                  'custom' => __( 'Custom height', 'canvys' ),
                  '50'   => __( '50% of the screen height', 'canvys' ),
                  '75'   => __( '75% of the screen height', 'canvys' ),
                  '100'  => __( '100% of the screen height', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Number_Control( 'custom_height', array(
               'title'       => __( 'Custom Height', 'canvys' ),
               'description' => __( 'Specify a custom height for this map in pixels, enter a numeric value only.', 'canvys' ),
               'placeholder' => 375,
            ) ),

            new CV_Shortcode_Select_Control( 'color_scheme', array(
               'title'       => __( 'Color Scheme', 'canvys' ),
               'description' => __( 'Specify how this map should be styled.', 'canvys' ),
               'default'     => 'none',
               'options'     => array(
                  'none'      => __( 'Default map styling', 'canvys' ),
                  'custom'    => __( 'Custom styling', 'canvys' ),
                  'main'      => __( 'Match the main content', 'canvys' ),
                  'alternate' => __( 'Match the alternate content', 'canvys' ),
                  'footer'    => __( 'Match the footer', 'canvys' ),
                  'socket'    => __( 'Match the socket', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Color_Control( 'hue', array(
               'title'       => __( 'Map Hue', 'canvys' ),
               'description' => __( 'Specify a custom color to be used as the color scheme for this map.', 'canvys' ),
            ) ),

            new CV_Shortcode_Color_Control( 'water_color', array(
               'title'       => __( 'Water Color', 'canvys' ),
               'description' => __( 'Specify a custom color to be used as the water color for this map.', 'canvys' ),
            ) ),

         ),
      );
   }

   /**
    * Renders inline JavaScript/CSS required by the shortcode composer
    *
    * @return mixed
    */
   public function composer_additional_assets() { ?>

      <script id="cv-builder-cv_fullwidth_map-script">
         (function($){
            "use strict";
            $(document).on( 'cv-composer-load-cv_fullwidth_map', function() {
               var $modal = $('#cv-composer-absolute-container').children().last();
               $modal.find('.control-height select').on( 'change', function() {
                  var $this = $(this), val = $this.val(),
                      $heightControl = $modal.find('.control-custom_height');
                  if ( 'custom' === val ) {
                     $heightControl.fadeIn().find('input').val('').trigger('change');
                  }
                  else {
                     $heightControl.hide().find('input').val('').trigger('change');
                  }
               }).trigger('change');
               $modal.find('.control-color_scheme select').on( 'change', function() {
                  var $this = $(this), val = $this.val(),
                      $schemeControls = $modal.find('.control-hue, .control-water_color');
                  if ( 'custom' === val ) {
                     $schemeControls.fadeIn();;
                  }
                  else {
                     $schemeControls.hide();;
                  }
               }).trigger('change');
            });
         })(jQuery);
      </script>
   <?php }

   /**
    * Callback function for front end display of shortcode
    *
    * @param array  $atts      Array of provided attributes
    * @param string $content   Content of shortcode
    * @return string
    */
   public function callback( $atts, $content = null ) {

      global $cv_map_markers, $canvys;

      static $num_maps;

      $num_maps++;

      // Load the Google Maps API
      wp_enqueue_script('cv-gmaps-api');

      // Start with an empty array
      $cv_map_markers = array();

      // Fill the slides array
      do_shortcode( $content );

      // Make sure there is atleast 1 marker
      if ( empty( $cv_map_markers ) ) {
         return;
      }

      // Create sanitized array of markers
      $map_markers = array();
      foreach ( $cv_map_markers as $marker_config ) {
         $coordinates = explode( ',', $marker_config['coordinates'] );
         if ( 2 !== count( $coordinates ) ) { continue; }
         $marker_config['lat'] = $coordinates[0];
         $marker_config['lng'] = $coordinates[1];
         $map_markers[] = $marker_config;
      }

      // Make sure there is atleast 1 marker
      if ( empty( $map_markers ) ) {
         return;
      }

      // Extract sanitized attributes
      extract( $this->get_sanitized_attributes( $atts ) );

      // Determine the ID of the map
      $id = $id ? $id : 'cv-fullwidth-map-' . $num_maps;
      $js_id = 'cv_fullwidth_map_' . $num_maps;

      // Grab the center coordinates
      if ( 1 == count( $map_markers ) ) {
         $center_lat = $map_markers[0]['lat'];
         $center_lng = $map_markers[0]['lng'];
      }
      else {
         $all_lats = array();
         $all_lngs = array();
         foreach ( $map_markers as $marker_config ) {
            $all_lats[] = $marker_config['lat'];
            $all_lngs[] = $marker_config['lng'];
         }
         $center_lat = ( max( $all_lats ) + min( $all_lats ) ) / 2;
         $center_lng = ( max( $all_lngs ) + min( $all_lngs ) ) / 2;
      }

      // Output the inline JavaScript
      ob_start(); ?>

         <script id="<?php echo $id; ?>-inline-script">

            (function($) {

               $(document).ready( function() {

                  var map, map_id = '<?php echo $js_id; ?>';

                  // Basic options
                  var options = {
                     scrollwheel: false,
                     disableDefaultUI: true,
                     center: new google.maps.LatLng(<?php echo $center_lat; ?>, <?php echo $center_lng; ?>),
                     zoom: <?php echo $zoom; ?>,
                  }

                  // Disable dragging
                  <?php if ( false ) : ?>
                     options.draggable = false;
                  <?php endif; ?>

                  // Show the pan control
                  <?php if ( in_array( $controls, array( 'default', 'pan' ) ) ) : ?>
                     options.panControl = true;
                  <?php endif; ?>

                  // Show the zoom control
                  <?php if ( in_array( $controls, array( 'default', 'zoom' ) ) ) : ?>
                     options.zoomControl = true;
                  <?php endif; ?>

                  <?php if ( 'none' !== $color_scheme ) :

                     if ( 'custom' !== $color_scheme ) {

                        // Grab the color scheme
                        $scheme = cv_get_color_scheme();
                        $scheme = $scheme['scheme'];

                        $hue = $scheme[$color_scheme]['accent'];
                        $water_color = $scheme[$color_scheme]['primary_bg'];

                     }

                     if ( $hue || $water_color ) : ?>

                        options.mapTypeControlOptions = {
                           mapTypeIds: [google.maps.MapTypeId.ROADMAP, map_id]
                        };

                        options.mapTypeId = map_id;

                        // Begin with an empty array
                        var style_options = [];
                        var style_map_options = {
                           name: map_id,
                        }

                        // Aply the hue
                        <?php if ( $hue ) : ?>
                           style_options.push({
                              stylers: [
                                 { hue: '<?php echo $hue; ?>' },
                                 { gamma: 0.5 },
                                 { weight: 0.5 },
                              ]
                           });
                        <?php endif; ?>

                        // Modify the water color
                        <?php if ( $water_color ) : ?>
                           style_options.push({
                              featureType: 'water',
                              stylers: [
                                 { color: '<?php echo $water_color; ?>' }
                              ]
                           });
                        <?php endif; ?>

                     <?php endif; ?>

                     map = new google.maps.Map( document.getElementById('<?php echo $id; ?>'), options );

                     var custom_map = new google.maps.StyledMapType( style_options, style_map_options );

                     map.mapTypes.set( map_id, custom_map );

                  <?php else: ?>

                  map = new google.maps.Map( document.getElementById('<?php echo $id; ?>'), options );

                  <?php endif; ?>

                  <?php $marker_count = 0; ?>

                  <?php foreach ( $map_markers as $marker_config ) : ?>

                     <?php $marker_count++; ?>

                     // Add the marker
                     var marker_<?php echo $marker_count; ?> = new google.maps.Marker({
                        position: new google.maps.LatLng(<?php echo $marker_config['lat']; ?>, <?php echo $marker_config['lng']; ?>),
                        map: map,
                        title: '<?php echo $marker_config['title']; ?>',
                     });

                     // Add the popup window
                     <?php if ( $marker_config['content'] && 'hidden' != $marker_config['window_visibility'] ) : ?>
                        var $marker = $('#<?php echo $id; ?>-marker-<?php echo $marker_count; ?>-content');
                        var marker_<?php echo $marker_count; ?>_window = new google.maps.InfoWindow({
                           content: $marker.html(),
                           maxWidth: 400,
                        });
                        google.maps.event.addListener( marker_<?php echo $marker_count; ?>, 'click', function() {
                           marker_<?php echo $marker_count; ?>_window.open( map, marker_<?php echo $marker_count; ?> );
                        });
                        <?php if ( 'visible' == $marker_config['window_visibility'] ) : ?>
                           marker_<?php echo $marker_count; ?>_window.open( map, marker_<?php echo $marker_count; ?> );
                        <?php endif; ?>
                        $marker.remove();
                     <?php endif; ?>

                  <?php endforeach; ?>

                  // Remove this node
                  var element = document.getElementById('<?php echo $id; ?>-inline-script');
                  element.parentNode.removeChild(element);

               });

            })(jQuery);

         </script>

      <?php $script = ob_get_clean();

      // HTML for the popup windows
      $markers = null;
      $marker_count = 0;
      foreach ( $map_markers as $marker_config ) {
         $marker_count++;
         if ( $marker_config['content'] && 'hidden' != $marker_config['window_visibility'] ) {
            $markers .= '<div style="display:none;" id="' . $id . '-marker-' . $marker_count . '-content">';
            $markers .= '<div class="' . $id . '-marker-' . $marker_count . '-content">';
            $markers .= '<div class="cv-user-font">' . apply_filters( 'the_content', $marker_config['content'] ) . '</div>';
            $markers .= '</div>';
            $markers .= '</div>';
         }
      }

      // Render the map
      $custom_height = $custom_height ? $custom_height : 375;
      $height_attr = 'custom' == $height ? ' style="height:' . $custom_height . 'px"' : ' data-height="' . $height . '"';
      return $script . $markers . '<section id="' . $id . '" class="cv-fullwidth-map"' . $height_attr . '></section>';

   }

}
endif;