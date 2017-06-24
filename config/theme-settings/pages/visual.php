<?php

if ( ! class_exists('CV_Visual_Settings') ) :

/**
 * Visual settings page
 *
 * @package    WordPress
 * @subpackage Canvys
 * @since      Version 1.0
 */
class CV_Visual_Settings extends CV_Settings_Page {

   /**
    * Function to create page configuration
    *
    * @return void
    */
   public function __construct() {

      global $canvys;

      $this->config = array(
         'tab_title' => __( 'Visual', 'canvys' ),
         'slug' => 'visual',
         'priority' => 10,
         'defaults' => array(
            'container_layout'   => 'free',
            'wrap_layout'        => 'constrained-70',
            'font_size'          => 'smaller',
            'font_scheme'        => 'open_sans',
            'overlay_color'      => '#2EBF9D',
            'image_hover_color'  => '#000000',
         ),
      );

   }

   /**
    * Loading additional styles to the settings page
    *
    * @return void
    */
   public function additional_styles() {
      global $canvys; ?>
      <style id="cv-theme-settings-visual-style">

         <?php foreach ( $canvys['typography_schemes'] as $slug => $config ) {

            if ( ! isset( $config['families'] ) ) {
               continue;
            }

            // Create the @import
            $url = '//fonts.googleapis.com/css?family=';
            foreach ( $config['families'] as $family => $weights ) {
               $url .= $family . ':';
               foreach ( $weights as $weight ) {
                  $url .= $weight . ',';
               }
               $url = trim( $url, ',' ) . '|';
            }
            $url = trim( $url, '|' );

            echo "@import url('{$url}');\n";

         }

         echo "\n";

         foreach ( $canvys['typography_schemes'] as $slug => $config ) {

            foreach ( $config['scheme'] as $tag => $styles ) {
               if ( 'body' == $tag ) $tag = null;
               echo '.visual-font-preview[data-scheme="' . $slug . '"] ' . $tag . " {";
               foreach ( $styles as $attr => $val ) {
                  echo "{$attr}: {$val};";
               }
               echo "}";
            }
         } ?>

         .visual-font-preview {
            margin-bottom: 35px;
            border: 1px solid #eee;
            color: #777 !important;
         }
         .visual-font-preview .secondary-content {
            margin-top: 0.5em;
            padding: 0.75em;
            border: 1px solid rgba(0,0,0,0.15);
            background: rgba(0,0,0,0.025);
         }
         .visual-font-preview h1,
         .visual-font-preview h2,
         .visual-font-preview h3,
         .visual-font-preview h4,
         .visual-font-preview h5,
         .visual-font-preview h6 {
            line-height: 1 !important;
            margin: 0 0 10px !important;
            padding: 0 !important;
            color: #333 !important;
         }
         .visual-font-preview p { font-size: 1em !important; }

      </style>
   <?php }

   /**
    * Loading additional scripts to the settings page
    *
    * @return void
    */
   public function additional_scripts() { ?>
      <script id="cv-theme-settings-visual-script">
         (function($) {
            $(document).ready( function() {

               $('#visual-font_scheme').on( 'change', function() {
                  $('#visual-font-preview').attr( 'data-scheme', $(this).val() );
               });

               $('#visual-font_size').on( 'change', function() {
                  switch ( $(this).val() ) {
                     case 'much-smaller': var fontSize = '12px'; break;
                     case 'smaller': var fontSize = '13px'; break;
                     case 'normal': var fontSize = '14px'; break;
                     case 'larger': var fontSize = '15px'; break;
                     case 'much-larger': var fontSize = '16px'; break;
                  }
                  $('#visual-font-preview').css( 'font-size', fontSize );
               }).trigger('change');

               $('#general-container_layout').on( 'change', function() {
                  var $this = $(this), $wrap = $this.parent(),
                      newVal = $this.val(), currentVal = $this.data('current'),
                      $infoMessage = $wrap.find('.info-message'),
                      $alertMessage = $wrap.find('.alert-message');
                  if ( 'free' === currentVal && 'free' !== newVal ) {
                     $infoMessage.slideDown();
                     $alertMessage.slideUp();
                  }
                  else if ( 'free' !== currentVal && 'free' === newVal ) {
                     $infoMessage.slideUp();
                     $alertMessage.slideDown();
                  }
                  else if ( 'free' === currentVal && 'free' === newVal ) {
                     $infoMessage.slideUp();
                     $alertMessage.slideUp();
                  }
                  else if ( 'free' !== currentVal && 'free' !== newVal ) {
                     $infoMessage.slideUp();
                     $alertMessage.slideUp();
                  }
               });

            });
         })(jQuery);
      </script>
   <?php }

   /**
    * Rendering the inner page
    *
    * @param array $input The user specified input
    * @return void
    */
   public function render_inner_page( $input ) {
      global $canvys;
      $name = 'cv_theme_settings[' . $this->config['slug'] . ']';
      $input = $this->extract_input( $input ); ?>

      <div class="option-wrap">
         <div id="visual-font-preview" class="visual-font-preview option-description additional-message" data-scheme="<?php echo $input['font_scheme']; ?>">
            <div class="cv-split-2 spacing-2 has-clearfix">
               <div>
                  <h1><?php _e( 'Header One', 'canvys' ); ?></h1>
                  <h2><?php _e( 'Header Two', 'canvys' ); ?></h2>
                  <h3><?php _e( 'Header Three', 'canvys' ); ?></h3>
                  <h4><?php _e( 'Header Four', 'canvys' ); ?></h4>
                  <h5><?php _e( 'Header Five', 'canvys' ); ?></h5>
                  <h6><?php _e( 'Header Six', 'canvys' ); ?></h6>
               </div>
               <div>
                  <p style="margin:0 !important;"><strong>Lorem ipsum dolor</strong> <i>sit amet, consectetuer</i> adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet.</p>
                  <div class="secondary-content"><?php _e( 'Example secondary content.', 'canvys' ); ?></div>
               </div>
            </div>
         </div>
         <div class="cv-split-2 spacing-2 has-clearfix">
            <div>
               <label class="option-title" for="visual-font_scheme"><?php _e( 'Typography Scheme', 'canvys' ); ?></label>
               <select name="<?php echo $name; ?>[font_scheme]" id="visual-font_scheme">
                  <?php foreach ( $canvys['typography_schemes_by_family'] as $family => $schemes ) : ?>
                     <?php switch ( $family ) {
                        case 'standard': $family_label = __( 'Web Safe Fonts', 'canvys' ); break;
                        case 'sans_serif': $family_label = __( 'Sans Serif', 'canvys' ); break;
                        case 'serif': $family_label = __( 'Serif', 'canvys' ); break;
                        case 'combination': $family_label = __( 'Combinations', 'canvys' ); break;
                     } ?>
                     <optgroup label="<?php echo $family_label; ?>">
                     <?php foreach ( $schemes as $slug ) : ?>
                        <?php $config = $canvys['typography_schemes'][$slug]; ?>
                        <option value="<?php echo $slug; ?>" <?php selected( $input['font_scheme'], $slug ); ?>><?php echo $config['title']; ?></option>
                     <?php endforeach; ?>
                     </optgroup>
                  <?php endforeach; ?>
               </select>
            </div>
            <div>
               <label class="option-title" for="visual-font_size"><?php _e( 'General Font Size', 'canvys' ); ?></label>
               <select name="<?php echo $name; ?>[font_size]" id="visual-font_size">
                  <option value="much-smaller" <?php selected( $input['font_size'], 'much-smaller' ); ?>><?php _e( 'Much Smaller - 12px', 'canvys' ); ?></option>
                  <option value="smaller" <?php selected( $input['font_size'], 'smaller' ); ?>><?php _e( 'Smaller - 13px', 'canvys' ); ?></option>
                  <option value="normal" <?php selected( $input['font_size'], 'normal' ); ?>><?php _e( 'Normal - 14px', 'canvys' ); ?></option>
                  <option value="larger" <?php selected( $input['font_size'], 'larger' ); ?>><?php _e( 'Larger - 15px', 'canvys' ); ?></option>
                  <option value="much-larger" <?php selected( $input['font_size'], 'much-larger' ); ?>><?php _e( 'Much Larger - 16px', 'canvys' ); ?></option>
               </select>
            </div>
         </div>
      </div>

      <div class="option-wrap">
         <label class="option-title" for="general-container_layout"><?php _e( 'Outer Container Width', 'canvys' ); ?></label>
         <select name="<?php echo $name; ?>[container_layout]" id="general-container_layout" data-current="<?php echo $input['container_layout']; ?>">
            <option value="boxed-70" <?php selected( $input['container_layout'], 'boxed-70' ); ?>><?php _e( 'Boxed (Max Width: 1120px)', 'canvys' ); ?></option>
            <option value="boxed-75" <?php selected( $input['container_layout'], 'boxed-75' ); ?>><?php _e( 'Boxed (Max Width: 1200px)', 'canvys' ); ?></option>
            <option value="boxed-80" <?php selected( $input['container_layout'], 'boxed-80' ); ?>><?php _e( 'Boxed (Max Width: 1280px)', 'canvys' ); ?></option>
            <option value="boxed-85" <?php selected( $input['container_layout'], 'boxed-85' ); ?>><?php _e( 'Boxed (Max Width: 1360px)', 'canvys' ); ?></option>
            <option value="free" <?php selected( $input['container_layout'], 'free' ); ?>><?php _e( 'Free, fill the width of the screen', 'canvys' ); ?></option>
         </select>
         <p class="option-description"><?php _e( 'Control the container layout of your website, the container wraps all content and determines the outer width of your website.', 'canvys' ); ?></p>
         <p class="option-description additional-message info-message" style="display:none;"><?php _e( 'After theme settings have been saved you will be able to customize the background of your website by going to Appearance > Background.', 'canvys' ); ?></p>
         <p class="option-description additional-message alert-message" style="display:none;"><?php _e( 'After theme settings have been saved you will no longer be able to customize the background of your website. This is because the wide layout will cover the screen.', 'canvys' ); ?></p>
         <div class="option-spacer"></div>
         <label class="option-title" for="general-wrap_layout"><?php _e( 'Inner Container Width', 'canvys' ); ?></label>
         <select name="<?php echo $name; ?>[wrap_layout]" id="general-wrap_layout" data-current="<?php echo $input['wrap_layout']; ?>">
            <option value="constrained-60" <?php selected( $input['wrap_layout'], 'constrained-60' ); ?>><?php _e( 'Constrained Width (Max: 960px)', 'canvys' ); ?></option>
            <option value="constrained-65" <?php selected( $input['wrap_layout'], 'constrained-65' ); ?>><?php _e( 'Constrained Width (Max: 1040px)', 'canvys' ); ?></option>
            <option value="constrained-70" <?php selected( $input['wrap_layout'], 'constrained-70' ); ?>><?php _e( 'Constrained Width (Max: 1120px)', 'canvys' ); ?></option>
            <option value="constrained-75" <?php selected( $input['wrap_layout'], 'constrained-75' ); ?>><?php _e( 'Constrained Width (Max: 1200px)', 'canvys' ); ?></option>
            <option value="free" <?php selected( $input['wrap_layout'], 'free' ); ?>><?php _e( 'Free, will fill the width of the outer container', 'canvys' ); ?></option>
         </select>
         <p class="option-description"><?php _e( 'Control the layout of your website.', 'canvys' ); ?></p>
      </div>

      <div class="option-wrap">
         <label class="option-title" for="visual-overlay_color"><?php _e( 'Fullscreen Overlay Color', 'canvys' ); ?></label>
         <input type="text" class="cv-color-picker" id="visual-overlay_color" value="<?php echo $input['overlay_color']; ?>" name="<?php echo $name; ?>[overlay_color]" />
         <p class="option-description"><?php _e( 'Select the background color for fullscreen overlays, this includes the overlay menu and the overlay search bar. Please note that the content displayed in the overlay is semi transparent black & white.', 'canvys' ); ?></p>
      </div>

      <div class="option-wrap">
         <label class="option-title" for="visual-image_hover_color"><?php _e( 'Image Hover Effect Overlay Color', 'canvys' ); ?></label>
         <input type="text" class="cv-color-picker" id="visual-image_hover_color" value="<?php echo $input['image_hover_color']; ?>" name="<?php echo $name; ?>[image_hover_color]" />
         <p class="option-description"><?php _e( 'Select the background color used for image hover effects. Please note that the content displayed in the overlay will adjust to the color you select.', 'canvys' ); ?></p>
      </div>

   <?php }

   /**
    * Sanitizing the page specific input
    *
    * @param array $input The user specified input
    * @return array
    */
   public static function sanitize_input( $input ) {
      global $canvys;
      return array(
         'font_size'          => isset( $input['font_size'] ) ? cv_filter( $input['font_size'], array( 'much-smaller', 'smaller', 'normal', 'larger', 'much-larger' ), 'normal' ) : 'normal',
         'font_scheme'        => isset( $input['font_scheme'] ) ? cv_filter( $input['font_scheme'], array_keys( $canvys['typography_schemes'] ), 'business' ) : 'open_sans',
         'overlay_color'      => isset( $input['overlay_color'] ) ? cv_filter( $input['overlay_color'], 'hex' ) : '#2EBF9D',
         'image_hover_color'  => isset( $input['image_hover_color'] ) ? cv_filter( $input['image_hover_color'], 'hex' ) : '#000000',
         'container_layout'   => isset( $input['container_layout'] ) ? cv_filter( $input['container_layout'], array( 'boxed-70', 'boxed-75', 'boxed-80', 'boxed-85', 'free' ) ) : 'free',
         'wrap_layout'        => isset( $input['wrap_layout'] ) ? cv_filter( $input['wrap_layout'], array( 'constrained-60', 'constrained-65', 'constrained-70', 'constrained-75', 'free' ) ) : 'constrained-65',
      );
   }

}
endif;