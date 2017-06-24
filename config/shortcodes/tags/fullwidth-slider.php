<?php

if ( ! class_exists('CV_Fullwidth_Slider') ) :

/**
 * Full width Slider
 *
 * @package      WordPress
 * @subpackage   Canvys
 * @since        Version 1.0
 */
class CV_Fullwidth_Slider extends CV_Shortcode {

   /**
    * Function to create shortcode configuration
    *
    * @return void
    */
   public function __construct() {

      global $canvys;

      $this->config = array(

         // Handle will be used to use this shortcode
         'handle' => 'cv_fullwidth_slider',

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
         'title' => __( 'Full Width Slider', 'canvys' ),

         // Icon will be used to represent this shortcode in composer/builder
         // List of available icons can be found in icons.json
         'icon' => 'docs',

         // Whether or not shortcode is self closing
         'self_closing' => false,

         // If shortcode is not self closing, specify its default content
         'default_content' => '[cv_fullwidth_slide][cv_fullwidth_slide_element][/cv_fullwidth_slide]',

         // Specify whether or not content is directly editable
         'content_editor' => false,

         // Specify whether or not the content is composed of another shortcode
         'content_element' => 'cv_fullwidth_slide',

         // Provide an explanation of what this shortcode does
         'explanation' => __( 'Full width sliders allow you to add any number of slides each with unique background and caption settings. If content sliding has been enabled for this page full width sliders will automatically resize to fit the height of the screen.', 'canvys' ),

         // Array of shortcode settings and their respective attributes
         'attributes' => array(

            new CV_Shortcode_Text_Control( 'id', array(
               'title'       => __( 'Slider ID', 'canvys' ),
               'description' => __( 'Set the ID attribute for this slider, this allows you to apply unique styles to this slider with CSS or to link to this slider in the creation of a one page website.', 'canvys' ),
            ) ),

            new CV_Shortcode_Slider_Control( 'slider_config', array(
               'title'       => __( 'Slider Configuration', 'canvys' ),
               'description' => __( 'Specify how this slider should behave.', 'canvys' ),
            ) ),

            new CV_Shortcode_Select_Control( 'parallax', array(
               'title'       => __( 'Enable Parallax', 'canvys' ),
               'description' => __( 'Enable parallax scrolling effect for this slider', 'canvys' ),
               'default'     => 'false',
               'options'     => array(
                  'false' => __( 'No parallax effect', 'canvys' ),
                  'true'  => __( 'Yes, enable parallax scrolling', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Select_Control( 'min_height', array(
               'title'       => __( 'Minimum Height', 'canvys' ),
               'description' => __( 'Specify a minimum height for this slider.', 'canvys' ),
               'default'     => 'none',
               'options'     => array(
                  'none' => __( 'None, let the content of each slide dictate the height', 'canvys' ),
                  '25'   => __( 'Atleast 25% of the screen height', 'canvys' ),
                  '50'   => __( 'Atleast 50% of the screen height', 'canvys' ),
                  '75'   => __( 'Atleast 75% of the screen height', 'canvys' ),
                  '100'  => __( 'Atleast 100% of the screen height', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Number_Control( 'forced_height', array(
               'title'       => __( 'Forced Height', 'canvys' ),
               'description' => __( 'Force each slide to be a certain height. Enter a numeric value only in pixels.', 'canvys' ),
            ) ),

            new CV_Shortcode_Select_Control( 'visibility', array(
               'title'       => __( 'Visibility', 'canvys' ),
               'description' => __( 'Which devices this slider should be visible on. This is great for optimizing your website for all devices. Please note that this setting is not applicable when full page content sliding is active.', 'canvys' ),
               'default'     => 'all',
               'options'     => $canvys['visibility_options'],
            ) ),

         ),
      );
   }

   /**
    * Callback function for front end display of shortcode
    *
    * @param array  $atts      Array of provided attributes
    * @param string $content   Content of shortcode
    * @return string
    */
   public function callback( $atts, $content = null ) {

      global $cv_fullwidth_slides;

      static $num_sliders;

      $num_sliders++;

      // Start with an empty array
      $cv_fullwidth_slides = array();

      // Fill the slides array
      do_shortcode( $content );

      // Make sure there are atleast 2 slides
      if ( empty( $cv_fullwidth_slides ) || 2 > count( $cv_fullwidth_slides ) ) {
         return;
      }

      global $canvys;

      // Extract sanitized attributes
      extract( $this->get_sanitized_attributes( $atts ) );

      // Create the slider ID
      $slider_id = $id ? $id : 'cv-fullwidth-slider-' . $num_sliders;

      // The slider container
      $o = new CV_HTML( '<div>', array(
         'class' => 'cv-fullwidth-slider',
         'id' => $slider_id,
      ) );

      // Modify slider if page sliding is not active
      if ( ! cv_is_page_slide_active() ) {

         // Visitibility
         $o->data( 'visibility', $visibility );

         // For styling
         $o->add_class( 'is-gallery' );

         $o->data( 'slide-tag', 'section' );

         // Apply the slider configuration
         $o = cv_apply_slider_config_attributes( $o, $slider_config );

         if ( 0 === strpos( $slider_config, 'vertical' ) ) {
            $parallax = false;
         }

      }

      // Apply min height attribute
      if ( 'none' != $min_height ) {
         $o->data( 'min-height', $min_height );
      }

      // Whether or not each slide should have a caption
      $has_captions = false;
      foreach ( $cv_fullwidth_slides as $slide_config ) {
         if ( ! empty( $slide_config['elements'] ) ) {
            $has_captions = true;
         }
      }

      // Add each slide
      foreach ( $cv_fullwidth_slides as $slide_config ) {

         // Determine the level of padding to use
         $padding = cv_is_page_slide_active() ? 'none' : 'normal';

         // Create the slide configuration
         $atts = array_merge( $slide_config, array(
            'bg_source' => 'image',
            'parallax' => $parallax,
            'padding_top' => $padding,
            'padding_bottom' => $padding,
            'bg_attachment' => 'scroll',
         ) );

         // Apply the forced height, if any
         if ( 'none' == $min_height && $forced_height ) {
            $atts['forced_height'] = $forced_height . 'px';
         }

         // Begin with an empty caption
         $caption = null;

         if ( ! empty( $slide_config['elements'] ) ) {

            // Create the caption
            $caption = new CV_HTML( '<div>', array(
               'class' => 'slider-caption',
            ) );

            // Determine which animation to use
            $entrance = $slide_config['entrance'];

            // Apply the caption alignment
            $caption->add_class( 'align-' . $slide_config['align'] );

            // Determine the default color
            $default_color = $slide_config['default_color'] ? $slide_config['default_color'] : '#ffffff';

            $button_row = null;
            $delay_timer = 0;

            foreach ( $slide_config['elements'] as $element_config ) {

               $element = null;

               switch ( $element_config['source'] ) {

                  /* Textual element */
                  case 'text':

                     // If a button row is open, append & close it
                     if ( $button_row ) {
                        $caption->append( '<div class="cv-scaling-typography" data-max="14" data-multiplier="25" data-min="9">' . $button_row . '</div>' );
                        $button_row = null;
                     }

                     // Create the header
                     $element = new CV_HTML( '<' . $element_config['tag'] . '>', array(
                        'class' => 'cv-fullwidth-slider-line',
                        'content' => $element_config['text'],
                     ) );

                     // Apply the weight
                     if ( 'default' != $element_config['weight'] ) {
                        $element->css( 'font-weight', $element_config['weight'] );
                     }

                     // Create animated entrance attribute
                     if ( 'none' !== $entrance ) {
                        $element->data( 'manual-trigger', 'true' );
                        $element->data( 'entrance', $entrance );
                        $element->data( 'delay', $delay_timer );
                        $delay_timer += 250;
                     }

                     break;

                  /* Icon Element */
                  case 'icon':

                     // If a button row is open, append & close it
                     if ( $button_row ) {
                        $caption->append( '<div class="cv-scaling-typography" data-max="14" data-multiplier="25" data-min="9">' . $button_row . '</div>' );
                        $button_row = null;
                     }

                     // Create the icon
                     $element = new CV_HTML( '<p>', array(
                        'class' => 'cv-fullwidth-slider-line',
                        'content' => '<i class="icon-' . $element_config['icon'] . '"></i>',
                     ) );

                     // Create animated entrance attribute
                     if ( 'none' !== $entrance ) {
                        $element->data( 'manual-trigger', 'true' );
                        $element->data( 'entrance', $entrance );
                        $element->data( 'delay', $delay_timer );
                        $delay_timer += 250;
                     }

                     break;

                  /* Button Element */
                  case 'button':

                     // Create the button row if one does not exist
                     if ( ! $button_row ) {

                        $button_row = new CV_HTML( '<p>', array(
                           'class' => 'cv-fullwidth-slider-line button-line',
                        ) );

                        // Create animated entrance attribute
                        if ( 'none' !== $entrance ) {
                           $button_row->data( 'manual-trigger', 'true' );
                           $button_row->data( 'entrance', $entrance );
                           $button_row->data( 'delay', $delay_timer );
                           $delay_timer += 250;
                        }

                     }

                     /* Modify the button configuration */
                     $element_config['custom_color'] = $element_config['color'] ? $element_config['color'] : $default_color;
                     $element_config['color'] = 'custom';
                     $element_config['size'] = 'medium';

                     // Create the button
                     $button = $canvys['shortcodes']['cv_button']->callback( $element_config );
                     $button = '<span style="font-size:' . $element_config['size_adjustment'] . 'em">' . $button . '</span>';

                     // Add the button
                     $button_row->append( $button );

                     break;

               }

               if ( ! $element ) continue;

               // Apply the size adjustment
               $element->css( 'font-size', $element_config['size_adjustment'] . 'em' );

               // Apply the color
               if ( $color = $element_config['color'] ? $element_config['color'] : $default_color ) {
                  $element->css( 'color', $color );
               }

               // Add the element
               $caption->append( '<div style="opacity:' . $element_config['opacity'] . ';"><div class="cv-scaling-typography">' . $element . '</div></div>' );

            }

            // make sure last button row is added
            if ( $button_row ) $caption->append( '<div class="cv-scaling-typography" data-max="14" data-multiplier="25" data-min="9">' . $button_row . '</div>' );

         }

         // Render the caption
         $caption = $has_captions ? '<div class="caption-wrap v-align-middle">' . $caption . '</div>' : null;

         // Create the slide
         $slide = cv_content_section( $atts, $caption );

         // Add the slide
         $o->append( $slide );

      }

      // Render the slider
      return $o->render();

   }

}
endif;