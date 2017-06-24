<?php

if ( ! class_exists('CV_HTML') ) :

/**
 * Used to simplify the process of producing valid HTML
 * tags dynamically using PHP
 *
 * @package      WordPress
 * @subpackage   Canvys
 * @since        Version 1.0
 */
class CV_HTML {

   /**
    * Create initial settings
    *
    * @param string $tag     HTML element tag
    * @param string $id      ID attribute
    * @param string $class   space delimited list of classes
    * @param string $style   formatted inline style
    * @return void
    */
   public function __construct( $tag, $settings = null ) {

      /**
       * Determine if element is self closing
       *
       * @var bool
       */
      $this->self_closing = strpos( $tag, '/' ) ? true : false;

      /**
       * HTML tag of element
       *
       * @var string
       */
      $this->tag = strtolower( preg_replace( "/[^A-Za-z0-9]/", '', $tag ) );

      /**
       * ID attribute of element
       *
       * @var string
       */
      $this->ID = '';

      /**
       * Content of element
       *
       * @var string
       */
      $this->content = '';

      /**
       * Various attributes, stored as array for easy modification
       *
       * @var array
       */
      $this->atts = array();

      /**
       * Class attribute, stored as array for easy modification
       *
       * @var array
       */
      $this->class = array();

      /**
       * Style attribute, stored as array for easy modification
       *
       * @var array
       */
      $this->style = array();

      // If an array has been supplied for the settings array
      if ( is_array($settings) ) {

         // See if n values were supplied for each attribute
         if ( array_key_exists( 'id',        $settings) ) $this->ID = $settings['id'];
         if ( array_key_exists( 'content',   $settings) ) $this->content = $settings['content'];
         if ( array_key_exists( 'class',     $settings) ) $this->class = array_unique( explode( ' ', $settings['class'] ) );

         // Set attributes to settings array
         $atts = $settings;

         // Remove standard settings from atts array
         foreach ( array( 'tag', 'id', 'class', 'content', 'style' ) as $setting ) {
            unset( $atts[$setting] );
         }

         // Set attributes setting
         $this->atts = $atts;

         // Set any additional styles
         if ( array_key_exists('style', $settings) ) {
            $styles = explode( ';', $settings['style'] );
            if ( is_array( $styles ) ) {
               foreach ( $styles as $style ) {
                  if ( ! strpos($style, ':') ) {
                     continue;
                  }
                  $style = explode(':', $style);
                  $this->style[$style[0]] = $style[1];
               }
            }
         }

      }

   }

   /**
    * When class object is turned into a string
    *
    * @return string
    */
   public function __toString() {
      return $this->render();
   }

   /**
    * Change CSS attribute(s) of element
    *
    * @param mixed  $attr   Can be array of values to create or name of value
    * @param string $val    Can be value to set supplied $attr to or null
    * @return mixed
    */
   public function css($attr, $val = null) {
      if ( is_array($attr) ) {
         foreach ($attr as $attr => $val) {
            $this->style[$attr] = $val;
         }
      }
      else if ( $val ) {
         $this->style[$attr] = $val;
      }
      else {
         return $this->style[$attr];
      }
   }

   /**
    * Add or change data attribute of HTML element
    *
    * @param string $attr    The name of the data attribute to create/edit
    * @param string $value   The supplied value for the attribute
    * @return void
    */
   public function data($attr, $value = null) {
      $this->atts['data-' . trim($attr)] = $value;
   }

   /**
    * Add or change attribute of HTML element
    *
    * @param string $attr    The name of the  attribute to create/edit
    * @param string $value   The supplied value for the attribute
    * @return void
    */
   public function attr($attr, $value = null) {
      $this->atts[$attr] = trim($value);
   }

   /**
    * Remove existing data attribute(s) from HTML element
    *
    * @param string $target_data Space delimited list of data attributes to remove
    * @return void
    */
   public function remove_data($target_data) {
      $target_data = explode(' ', $target_data);
      foreach ($target_data as $target_att) {
         unset($this->atts[$target_att]);
      }
   }

   /**
    * Remove existing attribute(s) from HTML element
    *
    * @param string $target_atts Space delimited list of attributes to remove
    * @return void
    */
   public function remove_attr($target_atts) {
      $target_atts = explode(' ', $target_atts);
      foreach ($target_atts as $target_att) {
         unset($this->atts[$target_att]);
      }
   }

   /**
    * Add class to HTML element Space delimited list of classes to add
    *
    * @param string $new_class
    * @return void
    */
   public function add_class($new_class) {
      $new_class = explode(' ', $new_class);
      $this->class = array_unique( array_merge($this->class, $new_class) );
   }

   /**
    * Remove class from HTML element
    *
    * @param string $target_class Space delimited list of classes to remove
    * @return void
    */
   public function remove_class($target_class) {
      $target_class = explode(' ', $target_class);
      $this->class = array_diff($this->class, $target_class);
   }

   /**
    * Prepend content to content of HTML element
    *
    * @param string $content new content to be prepended
    * @return void
    */
   public function prepend($content) {
      $this->content = $content . $this->content;
   }

   /**
    * Append content to content of HTML element
    *
    * @param string $content new content to be appended
    * @return void
    */
   public function append($content) {
      $this->content = $this->content . $content;
   }

   /**
    * Render the HTML element
    *
    * @param string $content If supplied will be used as content instead of existing content
    * @return string
    */
   public function render( $content = null ) {

      // Create opening tag
      $o = '<' . $this->tag;

      // Insert ID if available
      if ( ! empty($this->ID) ) {
         $o .= ' id="' . trim($this->ID) . '"';
      }

      // Insert classes
      if ( isset( $this->class ) ) {
         for ( $i=0; $i<count($this->class); $i++ ) {
            $this->class[$i] = sanitize_html_class($this->class[$i]);
         }
         $o .= ' class="' . implode(' ', $this->class) . '"';
      }

      // Insert attributes
      if ( ! empty($this->atts) ) {

         foreach ($this->atts as $attr => $val) {

            // Check if value is a JSON object
            $is_JSON = 0 === strpos($val, '{') ? true : false;

            // Begin output of attribute
            $o .= ' ' . sanitize_html_class($attr);

            // If there is a value
            if ( ! is_null( trim($val) ) ) {
               $o .= '=';
               $o .= $is_JSON ? "'" : '"';
               $o .= $is_JSON ? trim($val) : esc_attr($val);
               $o .= $is_JSON ? "'" : '"';
            }

         }

      }

      // Insert any style attributes
      if ( ! empty($this->style) ) {
         $o .= ' style="';
         foreach ($this->style as $attr => $val) {
            if ( empty($val) ) {
               continue;
            }
            $o .= $attr . ':' . $val . ';';
         }
         $o .= '"';
      }

      // If element is self closing
      if ( $this->self_closing ) {
         return $o . ' />';
      }

      // Close opening tag
      $o .= '>';

      // Insert any content
      $o .= empty($content) ? trim($this->content) : trim($content);

      // Close the tag
      $o .= '</' . $this->tag . '>';

      return $o;

   }

}
endif;