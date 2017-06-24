<?php

if ( ! class_exists('CV_Price_Table') ) :

/**
 * Price Table
 *
 * @package      WordPress
 * @subpackage   Canvys
 * @since        Version 1.0
 */
class CV_Price_Table extends CV_Shortcode {

   /**
    * Function to create shortcode configuration
    *
    * @return void
    */
   public function __construct() {

      global $canvys;

      $animation_options = array(
         'none' => __( 'None', 'canvys' ),
      );

      $animation_options = array_merge( $animation_options, $canvys['animations'] );

      $this->config = array(

         // Handle will be used to use this shortcode
         'handle' => 'cv_price_table',

         // Whether or not this is a shortcode composer element
         'composer_element' => true,

         // Whether or not this is a template builder element
         'builder_element' => true,

         // Used by the template builder to determine where module can be dropped
         'drop_target' => 2,

         // Used by the template builder to determine where module can have other
         // modules dropped inside of it
         'drop_zone' => false,

         // Title will be used to identify this shortcode
         'title' => __( 'Pricing Table', 'canvys' ),

         // Icon will be used to represent this shortcode in composer/builder
         // List of available icons can be found in icons.json
         'icon' => 'tag',

         // Whether or not shortcode is self closing
         'self_closing' => false,

         // If shortcode is not self closing, specify its default content
         'default_content' => '[cv_price_option title="' . __( 'Standard', 'canvys' ) . '" price="45.00" attributes="Attribute 1|Attribute 2|Attribute 3"]'
                            . '[cv_price_option title="' . __( 'Featured', 'canvys' ) . '" price="55.00" attributes="Attribute 1|Attribute 2|Attribute 3" featured="true"]'
                            . '[cv_price_option title="' . __( 'Premium', 'canvys' ) . '" price="65.00" attributes="Attribute 1|Attribute 2|Attribute 3"]',

         // Specify whether or not content is directly editable
         'content_editor' => false,

         // Specify whether or not the content is composed of another shortcode
         'content_element' => 'cv_price_option',

         // Array of shortcode settings and their respective attributes
         'attributes' => array(

            new CV_Shortcode_Select_Control( 'currency_position', array(
               'title'       => __( 'Currency Indicator Position', 'canvys' ),
               'description' => __( 'Specify where the currency indicator should be placed.', 'canvys' ),
               'default'     => 'after',
               'options'     => array(
                  'after'      => __( 'After the price', 'canvys' ),
                  'before'    => __( 'Before the price', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Text_Control( 'currency', array(
               'title'       => __( 'Currency Indicator', 'canvys' ),
               'description' => __( 'Specify the currency indicator to use. Will default to the dollar sign. ($)', 'canvys' ),
               'placeholder' => '$',
            ) ),

            new CV_Shortcode_Select_Control( 'entrance', array(
               'title'       => __( 'Animated Entrance', 'canvys' ),
               'description' => __( 'Specify an aminated entrance for the columns to come into view, animations will occur consecutively.', 'canvys' ),
               'default'     => 'none',
               'options'     => $animation_options,
            ) ),

         ),
      );
   }

   /**
    * Callback function for front end shortcode styles
    *
    * @param array $sections Color scheme settings
    * @return string
    */
   public static function front_end_styles( $sections ) {

      foreach ( $sections as $section => $colors ) {

         $section_tag = '.cv-section-' . $section;

         // Tables
         echo
           $section_tag . " .cv-price-table {"
         . "border: 1px solid {$colors['borders']};"
         . "}"
         . $section_tag . " .cv-price-table .label {"
         . "background: {$colors['secondary_bg']};"
         . "color: {$colors['secondary_content']};"
         . "}"
         . $section_tag . " .cv-price-table .price {"
         . "color: {$colors['headers']};"
         . "}"
         . $section_tag . " .cv-price-table .attributes .attribute {"
         . "border-top: 1px solid " . cv_hex_to_rgba( $colors['borders'], 0.5 ) . ";"
         . "}"
         . $section_tag . " .cv-price-table .attributes .attribute:nth-child(odd) {"
         // . "background: " . cv_hex_to_rgba( $colors['secondary_bg'], 0.75 ) . ";"
         // . "color: {$colors['secondary_content']};"
         . "}"
         . $section_tag . " .cv-price-table.is-featured:before {"
         . "background: {$colors['accent']};"
         . "}"
         ;

      }

   }

   /**
    * Callback function for front end display of shortcode
    *
    * @param array  $atts      Array of provided attributes
    * @param string $content   Content of shortcode
    * @return string
    */
   public function callback( $atts, $content = null ) {

      global $canvys, $cv_price_options;

      // Start with an empty array
      $cv_price_options = array();

      // Fill the price options array
      do_shortcode( $content );

      // Make sure there are atleast 2 options
      if ( empty( $cv_price_options ) ) {
         return;
      }

      // Limit the number of options to 6
      $cv_price_options = array_slice( $cv_price_options, 0, 6 );

      // Create attributes array by sanitizing provided values
      extract( $this->get_sanitized_attributes( $atts ) );

      // Determine how many attributes should be displayed
      $num_attributes = 0;
      foreach ( $cv_price_options as $option_config ) {
         if ( $attributes = explode( '|', $option_config['attributes'] ) ) {
            if ( count( $attributes ) > $num_attributes ) $num_attributes = count( $attributes );
         }
      }

      // Make sure a currency has been specified
      $currency = $currency ? $currency : '$';

      // Start with an empty values
      $price_options = '';

      $delay_timer = 0;
      foreach ( $cv_price_options as $option_config ) {

         // Create the option container
         $option = new CV_HTML( '<div>', array(
            'class' => 'cv-price-table has-clearfix',
         ) );

         // Check if this option is featured
         if ( cv_make_bool( $option_config['featured'] ) ) {
            $option->add_class( 'is-featured' );
         }

         // Add the label
         $option->append( '<p class="label">' . $option_config['title'] . '</p>' );

         // Add the price
         $price  = '<p class="price">';
         if ( 'before' == $currency_position ) $price .= '<sup class="currency">' . $currency . '</sup>';
         $price .= '<span class="amount">' . $option_config['price'] . '</span>';
         if ( 'after' == $currency_position ) $price .= '<sup class="currency">' . $currency . '</sup>';
         if ( $option_config['below_price'] ) $price .= '<span class="below-price">' . $option_config['below_price'] . '</span>';
         $price .= '</p>';
         $option->append( $price );

         // Create the attributes container
         $attributes = new CV_HTML( '<p>', array(
            'class' => 'attributes',
         ) );

         // Add the attributes
         if ( $num_attributes ) {
            $attributes_array = explode( '|', $option_config['attributes'] );
            for ( $i=0; $i<$num_attributes; $i++ ) {
               $attribute = isset( $attributes_array[$i] ) ? $attributes_array[$i] : null;
               $attributes->append( '<span class="attribute">' . $attribute . '</span>' );
            }
         }

         // Add the button
         if ( $option_config['text'] ) {
            $button_config = array_merge( array(
               'weight' => 'thin',
               'style' => cv_make_bool( $option_config['featured'] ) ? 'ghost' : 'ghost',
               'color' => cv_make_bool( $option_config['featured'] ) ? 'accent' : 'content',
            ), $option_config );
            $attributes->append( '<span class="attribute option-button">' . $canvys['shortcodes']['cv_button']->callback( $button_config ) . '</span>' );
         }

         // Add the attributes array
         $option->append( $attributes );

         // Create animated entrance attribute
         $entrance_data = null;
         if ( 'none' !== $entrance ) {
            $entrance_data  = ' data-entrance="' . $entrance . '"';
            if ( $delay_timer ) {
               $entrance_data .= ' data-delay="' . $delay_timer . '"';
            }
            $delay_timer += 250;
         }

         // Add the option
         if ( 1 < count( $cv_price_options ) ) {
            $price_options .= '<div' . $entrance_data . '><div class="column-inner">' . $option . '</div></div>';
         }
         else if ( $entrance_data ) {
            $price_options .= '<div' . $entrance_data . '>'.$option.'</div>';
         }
         else {
            $price_options .= $option;
         }

      }

      if ( 1 < count( $cv_price_options ) ) {

         $columns_wrapper = new CV_HTML( '<div>', array(
            'class' => 'has-clearfix spacing-2',
         ) );

         // Apply the layout class
         $columns_wrapper->add_class( 'cv-split-' . count( $cv_price_options ) );

         $out = $columns_wrapper->render( $price_options );
      }

      else {
         $out = $price_options;
      }

      // Output the options in a column row
      return $out;

   }

}
endif;