<?php

if ( ! class_exists('CV_Shortcode') ) :

/**
 * Shortcode Template
 * used to manage each included shortcode
 *
 * @package    WordPress
 * @subpackage Canvys
 * @since      Version 1.0
 */
class CV_Shortcode {

   /**
    * Will be overwritten to contain the configuration of each shortcode
    *
    * @var array
    */
   public $config = array();

   /**
    * Helper function to initiate each shortcode
    *
    * @return array
    */
   public function init() {

      // Add any additional composer assets
      add_action( 'cv_composer_inline_assets', array( $this, 'composer_additional_assets' ) );

      // Add any additional composer styles
      add_action( 'cv_composer_inline_styles', array( $this, 'composer_additional_styles' ) );

      // Add any additional builder assets
      add_action( 'cv_builder_inline_assets', array( $this, 'builder_additional_assets' ) );

      // Add any additional builder styles
      add_action( 'cv_builder_inline_styles', array( $this, 'builder_additional_styles' ) );

      // Add the required builder module template
      add_action( 'cv_builder_inline_assets', array( $this, 'builder_module_template' ) );

      // Make sure callback method exists
      if ( method_exists( $this, 'callback' ) ) {

         // Register the shortcode
         add_shortcode( $this->config['handle'], array( $this, 'callback' ) );

         // Add any front end styles
         if ( method_exists( $this, 'front_end_styles' ) ) {
            add_action( 'cv_render_dynamic_stylesheet', array( $this, 'front_end_styles' ), null, 1 );
         }

      }

   }

   /**
    * Helper function to determine the default attributes of each shortcode
    *
    * @return array
    */
   public function get_default_attributes() {

      // Start with an empty array
      $defaults = array();

      // Make sure shortcode has attributes
      if ( ! $this->config['attributes'] ) {
         return;
      }

      // Fill defaults with each setting and its default
      foreach ( $this->config['attributes'] as $control ) {
         $defaults[$control->handle] = $control->config['default'];
      }

      // Return filled array
      return $defaults;

   }

   /**
    * Helper function to sanitize user input
    *
    * @param array $input Array of user defined attributes
    * @return array
    */
   public function get_sanitized_attributes( $input ) {

      global $canvys;

      // Make sure shortcode has attributes
      if ( ! $this->config['attributes'] ) {
         return;
      }

      // Create attributes array by overwriting defaults with user input
      $atts = shortcode_atts( $this->get_default_attributes(), $input, $this->config['handle'] );
      $o = array();

      // Iterate through each setting to sanitize attributes
      foreach ( $this->config['attributes'] as $control ) {

         $input = $atts[$control->handle];
         $o[$control->handle] = $control->sanitize_input( $input );

      }

      return $o;

   }

   /**
    * Helper function to display a formatted string of attributes
    *
    * @param array $input Array of user defined attributes
    * @return string
    */
   public function get_rendered_attributes( $input ) {

      // Make sure shortcode has attributes
      if ( ! $this->config['attributes'] ) {
         return;
      }

      $attributes = '';
      foreach ( $this->get_sanitized_attributes( $input ) as $attribute => $value ) {
         $attributes .= ' ' . $attribute . '="' . $value . '"';
      }
      return trim( $attributes );
   }

   /**
    * Callback function for rendering a complete callable shortcode tag
    *
    * @param array  $atts       Array of provided attributes
    * @param string $content    Content of shortcode
    * @param bool   $formatting Whether or not returned shortcode should be formtted
    * @return string
    */
   public function get_rendered_shortcode( $atts, $content = null ) {

      // Get rendered list of attributes, if shortcode has attributes
      $attributes = $this->config['attributes'] ?' ' . $this->get_rendered_attributes( $atts ) : null;

      // Open initial shortcode tag
      $shortcode = '[' . $this->config['handle'] . $attributes . ']';

      // Insert any content
      if ( ! $this->config['self_closing'] ) {

         // Ensures correct spacing if tinymce editor is in use
         if ( $this->config['content_editor'] ) {
            $content = str_replace( '&', '&amp;', $content );
         }

         $shortcode .= $content . '[/' . $this->config['handle'] . ']';

      }

      return $shortcode;

   }

   /**
    * Supply additional controls to the Canvys builder
    *
    * @return mixed
    */
   public function render_additional_controls() {}

   /**
    * Renders inline JavaScript/CSS required by the shortcode composer
    *
    * @return mixed
    */
   public function composer_additional_assets() {}

   /**
    * Renders inline CSS required by the shortcode composer
    *
    * @return mixed
    */
   public function composer_additional_styles() {}

   /**
    * Renders inline JavaScript/CSS required by the template builder
    *
    * @return mixed
    */
   public function builder_additional_assets() {}

   /**
    * Renders inline CSS required by the template builder
    *
    * @return mixed
    */
   public function builder_additional_styles() {}

   /**
    * Renders inline JavaScript/CSS required by the template builder
    *
    * @return mixed
    */
   public function builder_module_template() {
      echo '<script type="text/html" id="tmpl-cv-builder-' . $this->config['handle'] . '">' . $this->builder_module_callback( $this->get_default_attributes(), $this->config['default_content'] ) . '</script>';
   }

   /**
    * Callback function for displaying the template builder module container
    *
    * @param string $title The module title
    * @return CV_HTML
    */
   public function builder_module_container( $title = null ) {

      // Setup the title
      $title = $title ? strip_tags( $title ) : $this->config['title'];

      // Create the module
      $module = new CV_HTML( '<div>', array(
         'class' => 'cv-builder-module cv-is-draggable has-clearfix',
         'data-droptarget' => strval( $this->config['drop_target'] ),
         'data-handle' => $this->config['handle'],
         'data-title' => $title,
      ) );

      // Determine if element contains a drop zone
      $drop_zone_class = false === $this->config['drop_zone'] ? 'no-dropzone' : 'has-dropzone';

      // Apply additional classes
      $module->add_class( 'cv-module-' . $this->config['handle'] );
      $module->add_class( $drop_zone_class );

      return $module;

   }

   /**
    * Callback function for displaying the template builder module container
    *
    * @param array   $atts    Array of provided attributes
    * @param string  $content Content of shortcode
    * @param CV_HTML $module  The existing module object
    * @return CV_HTML
    */
   public function modify_builder_module_container( $atts, $content = null, $module ) {
      return $module;
   }

   /**
    * Callback function for displaying the template builder module title
    *
    * @param array  $atts      Array of provided attributes
    * @param string $content   Content of shortcode
    * @return string
    */
   public function builder_module_title( $atts, $content = null ) {
      $icon = isset( $this->config['icon'] ) ? '<i class="cv-module-icon icon-' . $this->config['icon'] . '"></i>' : null;
      return $icon . $this->config['title'];
   }

   /**
    * Callback function for displaying the template builder module controls
    *
    * @param array  $atts      Array of provided attributes
    * @param string $content   Content of shortcode
    * @return string
    */
   public function builder_module_controls( $title = null ) {

      // Setup the title
      $title = $title ? strip_tags( $title ) : $this->config['title'];

      // Create the controls
      $controls = new CV_HTML( '<nav>', array(
         'class' => 'cv-module-controls has-clearfix',
      ) );

      // Add edit module control
      if ( $this->config['attributes'] || $this->config['content_editor'] || $this->config['content_element'] ) {
         $controls->append( new CV_HTML( '<a>', array(
            'class' => 'cv-module-control cv-module-edit',
            'content' => '<i class="cv-control-icon icon-pencil"></i>',
            'title' => sprintf( __( 'Edit %s', 'canvys' ), $title ),
         ) ) );
      }

      // Add duplicate module control
      $controls->append( new CV_HTML( '<a>', array(
         'class' => 'cv-module-control cv-module-duplicate',
         'content' => '<i class="cv-control-icon icon-docs"></i>',
         'title' => sprintf( __( 'Duplicate %s', 'canvys' ), $title ),
      ) ) );

      // Add remove module control
      $controls->append( new CV_HTML( '<a>', array(
         'class' => 'cv-module-control cv-module-remove',
         'content' => '<i class="cv-control-icon icon-cancel"></i>',
         'title' => sprintf( __( 'Delete %s', 'canvys' ), $title ),
      ) ) );

      // Add move up/down controls
      if ( 0 === $this->config['drop_target'] ) {

         // Add move up control
         $controls->append( new CV_HTML( '<a>', array(
            'class' => 'cv-module-control cv-module-move-up',
            'content' => '<i class="cv-control-icon icon-up-dir"></i>',
            'title' => sprintf( __( 'Move %s to the top', 'canvys' ), $title ),
         ) ) );

         // Add move down control
         $controls->append( new CV_HTML( '<a>', array(
            'class' => 'cv-module-control cv-module-move-down',
            'content' => '<i class="cv-control-icon icon-down-dir"></i>',
            'title' => sprintf( __( 'Move %s to the bottom', 'canvys' ), $title ),
         ) ) );

      }

      // Add the controls
      return $controls->render();

   }

   /**
    * Callback function for display of preview in builder module
    *
    * @param array  $atts      Array of provided attributes
    * @param string $content   Content of shortcode
    * @return string
    */
   public function builder_module_preview( $atts, $content = null ) {
      global $canvys;
      if ( 2 == $this->config['drop_target'] && $this->config['content_element'] ) {
         $canvys['shortcodes'][$this->config['content_element']]->activate_builder_module_preview_callback();
         return do_shortcode( $content );
      }
      return false;
   }

   /**
    * Callback function for display of shortcode within the builder
    *
    * @param array  $atts      Array of provided attributes
    * @param string $content   Content of shortcode
    * @return string
    */
   public function builder_module_callback( $atts, $content = null ) {

      global $canvys;

      // Set up variables
      $handle = $this->config['handle'];
      $drop_zone = $this->config['drop_zone'];
      $drop_target = $this->config['drop_target'];
      $title = $this->builder_module_title( $atts );
      $has_preview = $this->builder_module_preview( $atts, $content ) ? true : false;
      $has_preview = cv_theme_setting( 'general', 'disable_builder_previews' ) ? false : $has_preview;

      // Create the module
      $module = $this->builder_module_container( $title );

      // Add classes based on certain attributes
      if ( $this->config['attributes'] ) {
         foreach ( $this->config['attributes'] as $control ) {
            if ( is_a( $control, 'CV_Shortcode_Select_Control' ) ) {
               $value = isset( $atts[$control->handle] ) ? $atts[$control->handle] : $control->config['default'];
               $module->add_class( $control->handle . '-' . $value );
            }
         }
      }

      // Modify the container
      $module = $this->modify_builder_module_container( $atts, $content, $module );

      // Add has preview class to container
      if ( $has_preview ) {
         $module->add_class('cv-has-preview');
      }

      // Display module controls
      $o = $this->builder_module_controls( $title );

      // Display title if there is no drop zone in module
      if ( false === $drop_zone ) {
         $o .= '<strong class="cv-module-title">' . $title . '</strong>';
      }

      // Module content
      $o .= '<div class="cv-module-content has-clearfix">';

      // If this module can not contain any other modules
      if ( false === $drop_zone ) {

         // Add the builder value piece
         $o .= '<textarea class="cv-builder-piece">' . $this->get_rendered_shortcode( $atts, $content ) . '</textarea>';

         // Insert the preview, if there is one
         if ( $has_preview ) {

            $o .= '<div class="cv-module-preview has-clearfix">';
            $o .= $this->builder_module_preview( $atts, $content );
            $o .= '<div class="cv-module-preview-cover cv-module-edit"></div>';
            $o .= '</div>';

         }

      }

      // Or if it can
      else {

         switch ( $drop_zone ) {
            case 2: $add_text = __( 'Add Module', 'canvys' ); break;
            case 1: $add_text = __( 'Add Row', 'canvys' ); break;
            case 0: $add_text = __( 'Add Full Width Module', 'canvys' ); break;
         }

         $o .= '<textarea class="cv-builder-piece">[' . $handle . ' ' . $this->get_rendered_attributes( $atts ) . ']</textarea>';
         $o .= '<div class="cv-dropzone has-clearfix" data-dropzone="' . $drop_zone . '">' . do_shortcode( $content ) . '</div>';
         $o .= '<a class="cv-add-module" data-droptarget="' . $drop_zone . '">';
         $o .= '<i class="icon-plus-squared"></i><span>' . $add_text . '</span>';
         $o .= '</a>';
         $o .= '<textarea class="cv-builder-piece">[/' . $handle . ']</textarea>';

      }

      $o .= '</div>';

      // Render & return the module
      $module->prepend($o);
      return $module->render();

   }

   /**
    * Callback function for display of shortcode as a module preview
    *
    * @param array  $atts      Array of provided attributes
    * @param string $content   Content of shortcode
    * @return string
    */
   public function builder_module_preview_callback( $atts, $content = null ) {

      // grab the title
      $title = $this->builder_module_title( $atts );

      // Create the module
      $module = $this->builder_module_container( $title );

      // Add classes based on certain attributes
      if ( $this->config['attributes'] ) {
         foreach ( $this->config['attributes'] as $control ) {
            if ( is_a( $control, 'CV_Shortcode_Select_Control' ) ) {
               $value = isset( $atts[$control->handle] ) ? $atts[$control->handle] : $control->config['default'];
               $module->add_class( $control->handle . '-' . $value );
            }
         }
      }

      // Modify the container
      $module = $this->modify_builder_module_container( $atts, $content, $module );

      return $module->render('<strong class="cv-module-title">' . $title . '</strong>');
   }

   /**
    * Function for activating the builder module callback of this shortcode
    *
    * @return void
    */
   public function activate_builder_module_callback() {

      // Remove front end display of shortcode
      remove_shortcode( $this->config['handle'] );

      // Activate back end display of shortcode
      add_shortcode( $this->config['handle'], array( $this, 'builder_module_callback' ) );

   }

   /**
    * Function for activating the builder module callback of this shortcode
    *
    * @return void
    */
   public function activate_builder_module_preview_callback() {

      // Remove front end display of shortcode
      remove_shortcode( $this->config['handle'] );

      // Activate back end display of shortcode
      add_shortcode( $this->config['handle'], array( $this, 'builder_module_preview_callback' ) );

   }

   /**
    * Function for activating the standard callback, should be used to undo the activate_builder_module_callback method
    *
    * @return void
    */
   public function reactivate_callback() {

      // First, make sure the method exists
      if ( ! method_exists( $this, 'callback' ) ) {
         return;
      }

      // Remove front end display of shortcode
      remove_shortcode( $this->config['handle'] );

      // Activate back end display of shortcode
      add_shortcode( $this->config['handle'], array( $this, 'callback' ) );

   }

}
endif;