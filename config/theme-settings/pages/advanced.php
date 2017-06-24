<?php

if ( ! class_exists('CV_Advanced_Settings') ) :

/**
 * Advanced settings page
 *
 * @package    WordPress
 * @subpackage Canvys
 * @since      Version 1.0
 */
class CV_Advanced_Settings extends CV_Settings_Page {

   /**
    * Function to create page configuration
    *
    * @return void
    */
   public function __construct() {

      global $canvys;

      $this->config = array(
         'tab_title' => __( 'Advanced', 'canvys' ),
         'slug' => 'advanced',
         'priority' => 100,
         'defaults' => array(
            'google_maps_api_key' => null,
            'css'                 => null,
            'js'                  => null,
            'header'              => null,
         ),
      );

   }

   /**
    * Loading additional styles to the settings page
    *
    * @return void
    */
   public function additional_styles() { ?>
      <style id="cv-theme-settings-advanced-style">
         .css-selector {
            font-family: 'Oxygen Mono';
            background: rgba(0,0,0,0.025);
            border-radius: 3px;
            padding: 5px;
         }
      </style>
   <?php }

   /**
    * Rendering the inner page
    *
    * @param array $input The user specified input
    * @return void
    */
   public function render_inner_page( $input ) {
      $name = 'cv_theme_settings[' . $this->config['slug'] . ']';
      $input = $this->extract_input( $input ); ?>

      <div class="option-wrap">
         <label for="advanced-google_maps_api_key" class="option-title"><?php _e( 'Google Maps API Key', 'canvys' ); ?></label>
         <input type="text" class="widefat" id="advanced-google_maps_api_key" value="<?php echo $input['google_maps_api_key']; ?>" name="<?php echo $name; ?>[google_maps_api_key]" />
         <p class="option-description"><?php echo wp_kses( __( 'Enter your <a href="https://developers.google.com/maps/documentation/javascript/get-api-key">Google Maps JavaScript API key</a> here.', 'camyno' ), array('a'=>array('href'=>array())) ); ?></p>
      </div>

      <div class="option-wrap">
         <label for="advanced-css" class="option-title"><?php _e( 'Quick CSS', 'canvys' ); ?></label>
         <textarea class="monospace-font widefat" rows="8" id="advanced-css" name="<?php echo $name; ?>[css]"><?php echo $input['css']; ?></textarea>
         <p class="option-description"><?php printf( __( 'CSS will be added to the %s section of every page.', 'canvys' ), '&lt;head /&gt;' ); ?></p>
      </div>

      <div class="option-wrap">
         <label for="advanced-js" class="option-title"><?php _e( 'Quick JavaScript', 'canvys' ); ?></label>
         <textarea class="monospace-font widefat" rows="8" id="advanced-js" name="<?php echo $name; ?>[js]"><?php echo $input['js']; ?></textarea>
         <p class="option-description"><?php printf( __( 'JavaScript will be added immediately before the closing %s tag.', 'canvys' ), '&lt;body /&gt;' ); ?></p>
      </div>

      <div class="option-wrap">
         <label for="advanced-header" class="option-title"><?php _e( 'Additional Header HTML', 'canvys' ); ?></label>
         <textarea class="monospace-font widefat" rows="8" id="advanced-header" name="<?php echo $name; ?>[header]"><?php echo $input['header']; ?></textarea>
         <p class="option-description"><?php printf( __( 'Add any additional HTML to the %s section of every page.', 'canvys' ), '&lt;head /&gt;' ); ?></p>
      </div>

   <?php }

   /**
    * Sanitizing the page specific input
    *
    * @param array $input The user specified input
    * @return array
    */
   public static function sanitize_input( $input ) {
      $allowed_html = array(
         'script' => array(
            'id' => array(),
            'class' => array(),
         ),
         'style' => array(
            'id' => array(),
            'class' => array(),
         ),
      );
      return array(
        'google_maps_api_key' => isset( $input['google_maps_api_key'] ) ? stripslashes( $input['google_maps_api_key'] ) : null,
        'css'                 => isset( $input['css'] ) ? stripslashes( $input['css'] ) : null,
        'js'                  => isset( $input['js'] ) ? stripslashes( $input['js'] ) : null,
        'header'              => isset( $input['header'] ) ? $input['header'] : null,
      );
   }

}
endif;