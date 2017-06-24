<?php

if ( ! class_exists('CV_Settings_Page') ) :

/**
 * Theme settings page
 * a simplified way to add new theme settings pages
 *
 * @package    WordPress
 * @subpackage Canvys
 * @since      Version 1.0
 */
class CV_Settings_Page {

   /**
    * Initiate each page
    *
    * @return array
    */
   public function init() {

      // Load the default values
      add_filter( 'cv_theme_settings_gather_defaults', array( $this, 'gather_defaults' ) );

      // Add sanitization filters
      add_filter( 'cv_theme_settings_sanitize_input', array( $this, 'gather_sanitized_values' ) );

      // Render the menu tab
      add_action( 'cv_theme_settings_render_menu', array( $this, 'render_menu_tab' ), $this->config['priority'], 1 );

      // Render the settings page
      add_action( 'cv_theme_settings_render_pages', array( $this, 'render_pane' ), $this->config['priority'], 1 );

      // Render any inline styles
      add_action( 'cv_theme_settings_inline_styles', array( $this, 'additional_styles' ) );

      // Render any inline scripts
      add_action( 'cv_theme_settings_inline_scripts', array( $this, 'additional_scripts' ) );

   }

   /**
    * Loading additional styles to the settings page
    *
    * @return void
    */
   public function additional_styles() {}

   /**
    * Loading additional scripts to the settings page
    *
    * @return void
    */
   public function additional_scripts() {}

   /**
    * Rendering the menu tab
    *
    * @return void
    */
   public function render_menu_tab() {
      $tab = new CV_HTML( '<a>', array(
         'class' => 'cv-settings-menu-tab',
         'id' => 'cv_menu_tab-' . $this->config['slug'],
         'data-pane' => $this->config['slug'],
         'content' => $this->config['tab_title'],
      ) );
      echo $tab;
   }

   /**
    * Rendering the page
    *
    * @param array $input The user specified input
    * @return void
    */
   public function render_pane( $input ) {
      $slug = $this->config['slug']; ?>
      <div class="cv-settings-pane" id="cv_settings_pane-<?php echo $slug; ?>" data-pane="<?php echo $slug; ?>">
      <input type="hidden" name="cv_theme_settings[<?php echo $slug; ?>]" />
      <?php $this->render_inner_page( $input ); ?>
      </div>
   <?php }

   /**
    * Rendering the inner page
    *
    * @param array $input The user specified input
    * @return void
    */
   public function render_inner_page( $input ) {}

   /**
    * Gathers the page specific defaults
    *
    * @return void
    */
   public function gather_defaults( $defaults ) {
      if ( ! is_array( $defaults ) ) {
         $defaults = array();
      }
      $defaults[$this->config['slug']] = $this->config['defaults'];
      return $defaults;
   }

   /**
    * Extracts the sanitized page specific values from the input array
    *
    * @param array $input The user specified input
    * @return array
    */
   public function extract_input( $input ) {
      if ( ! is_array( $input ) ) {
         $input = array();
      }
      if ( ! isset( $input[$this->config['slug']] ) ) {
         $input[$this->config['slug']] = $this->config['defaults'];
      }
      return array_merge( $this->config['defaults'], $this->sanitize_input( $input[$this->config['slug']] ) );
   }

   /**
    * Sanitizing the page specific input
    *
    * @param array $input The user specified input
    * @return array
    */
   public static function sanitize_input( $input ) { return $input; }

   /**
    * Sanitizing the page specific input
    *
    * @param array $input The user specified input
    * @return array
    */
   public function gather_sanitized_values( $clean ) {
      $clean[$this->config['slug']] = $this->sanitize_input($clean[$this->config['slug']]);
      return $clean;
   }

}
endif;