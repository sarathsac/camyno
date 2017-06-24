<?php

if ( ! class_exists('CV_Promo_Box') ) :

/**
 * Promo Boxes
 *
 * @package      WordPress
 * @subpackage   Canvys
 * @since        Version 1.0
 */
class CV_Promo_Box extends CV_Shortcode {

   /**
    * Function to create shortcode configuration
    *
    * @return void
    */
   public function __construct() {

      // Allowed background image settings
      $overlay_opacity_options = array(
         'none' => __( 'None, do not display an overlay color', 'canvys' ),
      );

      for ( $i=10; $i<=90; $i+=10 ) {
         $overlay_opacity_options[$i] = $i . '%';
      }

      $this->config = array(

         // Handle will be used to use this shortcode
         'handle' => 'cv_promo_box',

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
         'title' => __( 'Promo Box', 'canvys' ),

         // Icon will be used to represent this shortcode in composer/builder
         // List of available icons can be found in icons.json
         'icon' => 'flash',

         // Whether or not shortcode is self closing
         'self_closing' => false,

         // If shortcode is not self closing, specify its default content
         'default_content' => '[cv_promo_box_line text="' . __( 'This is line one', 'canvys' ) . '"]'
                            . '[cv_promo_box_line text="' . __( 'this is line two', 'canvys' ) . '"]',

         // Specify whether or not content is directly editable
         'content_editor' => false,

         // Specify whether or not the content is composed of another shortcode
         'content_element' => 'cv_promo_box_line',

         // Provide an explanation of what this shortcode does
         'explanation' => __( 'Promo boxes will be displayed as text on top of a background which you customize, the entire box can then optionally be linked to any URL of your choice.', 'canvys' ),

         // Array of shortcode settings and their respective attributes
         'attributes' => array(

            new CV_Shortcode_Link_Control( 'link', array(
               'title'       => __( 'Link', 'canvys' ),
               'description' => __( 'Specify if this promo box should be linked to anything.', 'canvys' ),
            ) ),

            new CV_Shortcode_Select_Control( 'ratio', array(
               'title'       => __( 'Box Proportions (Width X Height)', 'canvys' ),
               'description' => __( 'Specify the ratio that should be used to dictate the size of this promo box.', 'canvys' ),
               'default'     => '1x1',
               'options'     => array(
                  '6x2'  => __( '6 X 2', 'canvys' ),
                  '5x2'  => __( '5 X 2', 'canvys' ),
                  '4x2'  => __( '4 X 2', 'canvys' ),
                  '3x2'  => __( '3 X 2', 'canvys' ),
                  '1x1'  => __( '1 X 1', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Select_Control( 'position', array(
               'title'       => __( 'Text Position', 'canvys' ),
               'description' => __( 'Specify where the text for this promo box should be positioned.', 'canvys' ),
               'default'     => 'center-middle',
               'options'     => array(
                  'top' => array(
                     'label'   => __( 'Top', 'canvys' ),
                     'options' => array(
                        'left-top' => __( 'Top Left', 'canvys' ),
                        'center-top' => __( 'Top Center', 'canvys' ),
                        'right-top' => __( 'Top Right', 'canvys' ),
                     ),
                  ),
                  'middle' => array(
                     'label'   => __( 'Center', 'canvys' ),
                     'options' => array(
                        'left-middle' => __( 'Center Left', 'canvys' ),
                        'center-middle' => __( 'Center Center', 'canvys' ),
                        'right-middle' => __( 'Center Right', 'canvys' ),
                     ),
                  ),
                  'bottom' => array(
                     'label'   => __( 'Bottom', 'canvys' ),
                     'options' => array(
                        'left-bottom' => __( 'Bottom Left', 'canvys' ),
                        'center-bottom' => __( 'Bottom Center', 'canvys' ),
                        'right-bottom' => __( 'Bottom Right', 'canvys' ),
                     ),
                  ),
               ),
            ) ),

            new CV_Shortcode_Color_Control( 'color', array(
               'title'       => __( 'Text Color', 'canvys' ),
               'description' => __( 'Specify the color for the text, if none is specified the color will be black.', 'canvys' ),
            ) ),

            new CV_Shortcode_Color_Control( 'bg_color', array(
               'title'       => __( 'Background Color', 'canvys' ),
               'description' => __( 'Specify a background color for this promo box, if none is specified the background color will be transparent. <strong>Pro Tip: When using a background image set this color to one remotely similar to the overall image, this way as the image is loading this color will be visible.</strong> ', 'canvys' ),
            ) ),

            new CV_Shortcode_Image_Control( 'bg_image', array(
               'title'       => __( 'Background Image', 'canvys' ),
               'description' => __( 'The background image for this promo box. This will be displayed on top of the background color.', 'canvys' ),
            ) ),

            new CV_Shortcode_Select_Control( 'overlay_opacity', array(
               'title'       => __( 'Background Overlay Opacity', 'canvys' ),
               'description' => __( 'Specify whether or not a color should be overlayed on top of the promo box background, and at what opacity.', 'canvys' ),
               'default'     => 'none',
               'options'     => $overlay_opacity_options,
            ) ),

            new CV_Shortcode_Color_Control( 'overlay_color', array(
               'title'       => __( 'Background Overlay Color', 'canvys' ),
               'description' => __( 'Specify a color to be overlayed on top of the promo box background.', 'canvys' ),
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

      <script id="cv-builder-cv_promo_box-script">
         (function($){
            "use strict";
            $(document).on( 'cv-composer-load-cv_promo_box', function() {
               var $modal = $('#cv-composer-absolute-container').children().last();
               $modal.find('.control-overlay_opacity select').on( 'change', function() {
                  var $this = $(this), val = $this.val(),
                      $colorControl = $modal.find('.control-overlay_color');
                  if ( 'none' === val ) {
                     $colorControl.hide();
                  }
                  else {
                     $colorControl.fadeIn();
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

      global $cv_promo_box_lines;

      static $num_promo_boxes;

      // Start with an empty array
      $cv_promo_box_lines = array();

      // Fill the toggles array
      do_shortcode( $content );

      // Make sure there is atleast 1 toggle
      if ( empty( $cv_promo_box_lines ) ) {
         return;
      }

      // Total number of promo boxes
      $num_promo_boxes++;

      // Create attributes array by sanitizing provided values
      extract( $this->get_sanitized_attributes( $atts ) );

      // The ID to identify the promo box
      $promo_box_id = 'cv-promo-box-' . $num_promo_boxes;

      // Detrmine horizontal & vertical alignment
      $position = explode( '-', $position );
      $h_align = $position[0];
      $v_align = $position[1];

      // Create the promo box
      $o = new CV_HTML( '<div>', array(
         'class' => 'cv-promo-box bg-style-cover',
         'id' => $promo_box_id,
      ) );

      // Apply the overlay style
      if ( 'none' !== $overlay_opacity && $overlay_color ) {
         $overlay_opacity = $overlay_opacity / 100;
         $box_shadow = 'inset ' . cv_hex_to_rgba( $overlay_color, $overlay_opacity ) . ' 0px 0px 0px 5000px';
         $o->css( array(
            '-webkit-box-shadow' => $box_shadow,
            'box-shadow' => $box_shadow,
         ) );
      }

      // Apply the scaling class to the promo box
      $o->add_class( 'cv-scalable-' . $ratio );

      // Apply the background color
      if ( $bg_color ) $o->css( 'background-color', $bg_color );

      // Apply the background image
      if ( $bg_image && $img_info = wp_get_attachment_image_src( $bg_image, 'cv_full' ) ) {
         $o->css( 'background-image', 'url(' . $img_info[0] . ')' );
      }

      if ( $bg_color || ( 'none' !== $overlay_opacity && $overlay_color ) ) {

         // Loading box shadow state
         $css = '';

         if ( $bg_color && $bg_image && wp_get_attachment_image_src( $bg_image, 'cv_full' ) ) {
            $o->add_class( 'is-loading-bg-image' );
            $loading_box_shadow = 'inset ' . $bg_color . ' 0px 0px 0px 5000px !important';
            $loading_box_shadow = '-webkit-box-shadow:' . $loading_box_shadow . ';box-shadow:' . $loading_box_shadow . ';';
            $css .= '#' . $promo_box_id . '.is-loading-bg-image {' . $loading_box_shadow . '}';
         }

         if ( 'none' !== $overlay_opacity && $overlay_color ) {
            $hover_box_shadow = 'inset ' . cv_hex_to_rgba( $overlay_color, $overlay_opacity+0.2 ) . ' 0px 0px 0px 5000px !important';
            $hover_box_shadow = '-webkit-box-shadow:' . $hover_box_shadow . ';box-shadow:' . $hover_box_shadow . ';';
            $css .= '#' . $promo_box_id . ':not(.is-loading-bg-image):hover {' . $hover_box_shadow . '}';
         }

         // Render the loading styles
         if ( $css ) : ?><script id="<?php echo $promo_box_id; ?>-inline-script">

            var css = '<?php echo $css; ?>',
                style = document.createElement('style');

            if ( style.styleSheet ) {
               style.styleSheet.cssText = css;
            }
            else {
               style.appendChild( document.createTextNode( css ) );
            }

            // Add the new style rules
            document.head.appendChild( style );

            // Remove this node
            var element = document.getElementById('<?php echo $promo_box_id; ?>-inline-script');
            element.parentNode.removeChild(element);

         </script><?php endif;

      }

      // Create the text wraper
      $caption = new CV_HTML( '<div>', array(
         'class' => 'promo-box-caption cv-scaling-typography',
      ) );

      // Apply the color
      $color = $color ? $color : '#000000';
      $caption->css( 'color', $color );

      // Apply the text shadow
      $rgb = 0.85 > cv_hex_brightness( $color ) ? '255,255,255' : '0,0,0';
      $caption->css( 'text-shadow', 'rgba(' . $rgb . ',0.75) 0px 0px 1px' );

      // Add the lines
      foreach ( $cv_promo_box_lines as $line_config ) {

         // Create the line
         $line = new CV_HTML( '<span>', array(
            'class' => 'promo-box-line',
         ) );

         // Add the content
         switch ( $line_config['source'] ) {
            case 'text': $line->append( '<span style="opacity:' . $line_config['opacity'] . '">' . $line_config['text'] . '</span>' ); break;
            case 'icon': $line->append( '<i class="icon-' . $line_config['icon'] . '" style="opacity:' . $line_config['size_adjustment'] . '"></i>' ); break;
         }

         // Apply the size adjustment
         $line->css( 'font-size', $line_config['size_adjustment'] . 'em' );

         // Apply the weight adjustment
         if ( 'none' != $line_config['weight'] ) {
            $line->css( 'font-weight', $line_config['weight'] );
         }

         // Add the line
         $caption->append( $line );

      }

      // Create the scaling wrapper
      $scaler = new CV_HTML( '<div>', array(
         'class' => 'scalable-content',
      ) );

      // Add the caption to the scaled content
      $scaler->append( '<div class="v-align-' . $v_align . '" style="text-align:' . $h_align . '">' . $caption . '</div>' );

      // Add the scaler to the promo box
      $o->append( $scaler );

      // Add the link, if any
      if ( $link ) {
         $url = cv_get_shortcode_link_control_attrs( $link );
         $o->append( '<a ' . $url . '"></a>' );
      }

      return $o->render();

   }

}
endif;