<?php

if ( ! function_exists( 'cv_content_section' ) ) :

/**
 * Cals the callback to display a content section
 *
 * @param array  $atts      Array of provided attributes
 * @param string $content   Content of shortcode
 * @return string
 */
function cv_content_section( $atts, $content = null ) {
   global $canvys;
   return $canvys['shortcodes']['cv_section']->callback( $atts, $content );
}
endif;

if ( ! class_exists('CV_Section') ) :

/**
 * Sections
 * Class that handles the creation and configuration
 * of the section shortcode
 *
 * @package      WordPress
 * @subpackage   Canvys
 * @since        Version 1.0
 */
class CV_Section extends CV_Shortcode {

   /**
    * Function to create shortcode configuration
    *
    * @return void
    */
   public function __construct() {

      global $canvys;

      // Allowed background image settings
      $overlay_opacity_options = array(
         'none' => __( 'None, do not display an overlay color', 'canvys' ),
      );

      for ( $i=10; $i<=90; $i+=10 ) {
         $overlay_opacity_options[$i] = $i . '%';
      }

      $min_height_options = array( 'none' => __( 'None, let the content dictate the height', 'canvys' ) );
      for ($i=5;$i<=100;$i+=5 ) {
         $min_height_options[$i] = $i.'%';
      }

      $this->config = array(

         // Handle will be used to use this shortcode
         'handle' => 'cv_section',

         // Whether or not this is a shortcode composer element
         'composer_element' => false,

         // Whether or not this is a template builder element
         'builder_element' => true,

         // Used by the template builder to determine where module can be dropped
         'drop_target' => 0,

         // Used by the template builder to determine where module can have other
         // modules dropped inside of it
         'drop_zone' => 1,

         // Title will be used to identify this shortcode
         'title' => __( 'Content Section', 'canvys' ),

         // Icon will be used to represent this shortcode in composer/builder
         // List of available icons can be found in icons.json
         'icon' => 'progress-0',

         // Whether or not shortcode is self closing
         'self_closing' => false,

         // If shortcode is not self closing, specify its default content
         'default_content' => null,

         // Specify whether or not content is directly editable
         'content_editor' => false,

         // Specify whether or not the content is composed of another shortcode
         'content_element' => false,

         // Provide an explanation of what this shortcode does
         'explanation' => __( 'Full screen content sections are the foundation for your pages content, they provide the background images, color schemes, and the perfect way to divide the content of your page and add some organization. Content sections can contain any number or row modules which can be used to further organize your content.', 'canvys' ),

         // Array of shortcode settings and their respective attributes
         'attributes' => array(

            new CV_Shortcode_Text_Control( 'id', array(
               'title'       => __( 'Section ID', 'canvys' ),
               'description' => __( 'Set the ID attribute for this section, this allows you to apply unique styles to this section with CSS or to link to this section in the creation of a one page website.', 'canvys' ),
            ) ),

            new CV_Shortcode_Select_Control( 'color_scheme', array(
               'title'       => __( 'Color Scheme', 'canvys' ),
               'description' => __( 'This will control the control scheme for the section itself and all of the modules placed inside of it. These different color schemes can be edited by navigating to Appearance > Color Scheme.', 'canvys' ),
               'default'     => 'main',
               'options'     => array(
                  'main'      => __( 'Main Content', 'canvys' ),
                  'alternate' => __( 'Alternate Content', 'canvys' ),
                  'header'    => __( 'Header', 'canvys' ),
                  'footer'    => __( 'Footer', 'canvys' ),
                  'socket'    => __( 'Socket', 'canvys' ),
                  'white'     => __( 'All White Content (For sections with dark backgrounds)', 'canvys' ),
                  'black'     => __( 'All Black Content (For sections with light backgrounds)', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Select_Control( 'bg_source', array(
               'title'       => __( 'Background Source', 'canvys' ),
               'description' => __( 'Specify how the background of this section should be dislayed.', 'canvys' ),
               'default'     => 'default',
               'options'     => array(
                  'default' => __( 'Default background', 'canvys' ),
                  'color'   => __( 'Custom color', 'canvys' ),
                  'preset'  => __( 'Preset pattern', 'canvys' ),
                  'image'   => __( 'Custom image', 'canvys' ),
                  'video'   => __( 'HTML5 video', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_BG_Pattern_Control( 'bg_preset_pattern', array(
               'title'       => __( 'Preset Patterns', 'canvys' ),
               'description' => __( 'Select a preset pattern to use as the background for this section.', 'canvys' ),
            ) ),

            new CV_Shortcode_Color_Control( 'bg_color', array(
               'title'       => __( 'Background Color', 'canvys' ),
               'description' => __( 'Specify a custom background color to be used for this section, leave this blank to use the default background color.', 'canvys' ),
            ) ),

            new CV_Shortcode_Image_Control( 'bg_image', array(
               'title'       => __( 'Background Image', 'canvys' ),
               'description' => __( 'The background image for this section. This will be displayed on top of the background color.', 'canvys' ),
            ) ),

            new CV_Shortcode_Select_Control( 'bg_style', array(
               'title'       => __( 'Background Image Style', 'canvys' ),
               'description' => __( 'Whether or not the background image should be tiled, or cover the section completely. Tiled will display the image at its actual size but it will repeat to fill the section. Cover will (potentially) increase or decrease either the width or height of the image to ensure that it will cover the section, please note that the image will be scaled proportionately.', 'canvys' ),
               'default'     => 'cover',
               'options'     => array(
                  'cover'   => __( 'Cover', 'canvys' ),
                  'tile'    => __( 'Tiled', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Select_Control( 'bg_attachment', array(
               'title'       => __( 'Background Image Attachment', 'canvys' ),
               'description' => __( 'This will dictate how the image should behave as the page is scrolled. Scroll will allow the background image to scroll normally with the rst of the page, while fixed will leave the image fixed in place as the page scrolles for what is commonly reffered to as a "parrallax" effect.', 'canvys' ),
               'default'     => 'scroll',
               'options'     => array(
                  'scroll' => __( 'Scroll', 'canvys' ),
                  'fixed'  => __( 'Fixed', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Image_Control( 'bg_video_fallback', array(
               'title'       => __( 'HTML5 Video Background Fallback Image', 'canvys' ),
               'description' => __( 'Select an image to be used as the background on devices that dont fully support HTML5 video elements. Please note that this inlcudes nearly all mobile devices and tablets.', 'canvys' ),
            ) ),

            new CV_Shortcode_File_Control( 'bg_video_webm', array(
               'title'       => __( 'HTML5 Video Background .webm file', 'canvys' ),
               'description' => __( 'Specify the webm file to use for the video background.', 'canvys' ),
               'file_type'   => 'video',
            ) ),

            new CV_Shortcode_File_Control( 'bg_video_ogv', array(
               'title'       => __( 'HTML5 Video Background .ogv file', 'canvys' ),
               'description' => __( 'Specify the ogv file to use for the video background.', 'canvys' ),
               'file_type'   => 'video',
            ) ),

            new CV_Shortcode_File_Control( 'bg_video_mp4', array(
               'title'       => __( 'HTML5 Video Background .mp4 file', 'canvys' ),
               'description' => __( 'Specify the mp4 file to use for the video background.', 'canvys' ),
               'file_type'   => 'video',
            ) ),

            new CV_Shortcode_Select_Control( 'bg_scrolling', array(
               'title'       => __( 'Scrolling Background Direction', 'canvys' ),
               'description' => __( 'Enable scrolling background effect for this section. Keep in mind this works best with background images that tile perfectly.', 'canvys' ),
               'default'     => 'none',
               'options'     => array(
                  'none'    => __( 'No scrolling effect', 'canvys' ),
                  'top' => array(
                     'label'   => __( 'Upwards', 'canvys' ),
                     'options' => array(
                        'up-left' => __( 'Up Left', 'canvys' ),
                        'up' => __( 'Up', 'canvys' ),
                        'up-right' => __( 'Up Right', 'canvys' ),
                     ),
                  ),
                  'middle' => array(
                     'label'   => __( 'Horizontal', 'canvys' ),
                     'options' => array(
                        'left' => __( 'Left', 'canvys' ),
                        'right' => __( 'Right', 'canvys' ),
                     ),
                  ),
                  'bottom' => array(
                     'label'   => __( 'Downwards', 'canvys' ),
                     'options' => array(
                        'down-left' => __( 'Down Left', 'canvys' ),
                        'down' => __( 'Down', 'canvys' ),
                        'down-right' => __( 'Down Right', 'canvys' ),
                     ),
                  ),
               ),
            ) ),

            new CV_Shortcode_Select_Control( 'bg_scrolling_speed', array(
               'title'       => __( 'Scrolling Background Speed', 'canvys' ),
               'description' => __( 'Specify how quickly the background should scroll.', 'canvys' ),
               'default'     => 'normal',
               'options'     => array(
                  'slow'    => __( 'Slow', 'canvys' ),
                  'normal' => __( 'Normal', 'canvys' ),
                  'fast'  => __( 'Fast', 'canvys' ),
                  'very-fast'  => __( 'very Fast', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Select_Control( 'overlay_opacity', array(
               'title'       => __( 'Background Overlay Opacity', 'canvys' ),
               'description' => __( 'Specify whether or not a color should be overlayed on top of the section background, and at what opacity.', 'canvys' ),
               'default'     => 'none',
               'options'     => $overlay_opacity_options,
            ) ),

            new CV_Shortcode_Color_Control( 'overlay_color', array(
               'title'       => __( 'Background Overlay Color', 'canvys' ),
               'description' => __( 'Specify a color to be overlayed on top of the section background.', 'canvys' ),
            ) ),

            new CV_Shortcode_Select_Control( 'sidebar_layout', array(
               'title'       => __( 'Sidebar Layout', 'canvys' ),
               'description' => __( 'The layout of this section, if you use either left or right sidebar you will be able to shoose which sidebar is displayed.', 'canvys' ),
               'default'     => 'no-sidebar',
               'options'     => array(
                  'no-sidebar'    => __( 'No sidebar', 'canvys' ),
                  'sidebar-right' => __( 'Right Sidebar', 'canvys' ),
                  'sidebar-left'  => __( 'Left Sidebar', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Sidebar_Select_Control( 'sidebar', array(
               'title'       => __( 'Sidebar', 'canvys' ),
               'description' => __( 'The sidebar to be displayed.', 'canvys' ),
               'default'     => 'sidebar',
            ) ),

            new CV_Shortcode_Select_Control( 'parallax', array(
               'title'       => __( 'Enable Parallax', 'canvys' ),
               'description' => __( 'Enable parallax scrolling effect for this sections content', 'canvys' ),
               'default'     => 'false',
               'options'     => array(
                  'false' => __( 'No parallax effect', 'canvys' ),
                  'true'  => __( 'Yes, enable parallax scrolling', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Select_Control( 'min_height', array(
               'title'       => __( 'Minimum Height', 'canvys' ),
               'description' => __( 'The mimimun height of the section (if specified) will be based on a percentage of total screen height.', 'canvys' ),
               'default'     => 'none',
               'options'     => $min_height_options,
            ) ),

            new CV_Shortcode_Select_Control( 'stretched', array(
               'title'       => __( 'Stretched Content', 'canvys' ),
               'description' => __( 'Allow the content of this section to stretch to the size of the layout.', 'canvys' ),
               'default'     => 'false',
               'options'     => array(
                  'false'      => __( 'No, do not enable stretched content', 'canvys' ),
                  'free'       => __( 'yes, stretched with side padding', 'canvys' ),
                  'stretched'  => __( 'yes, stretched without side padding', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Select_Control( 'border_top', array(
               'title'       => __( 'Top Border', 'canvys' ),
               'description' => __( 'Specify how the top border should be styled', 'canvys' ),
               'default'     => 'none',
               'options'     => array(
                  'none'    => __( 'No special styling', 'canvys' ),
                  'border'  => __( 'Simple line border', 'canvys' ),
                  'shadow' => __( 'Faint inner shadow', 'canvys' ),
                  'shadow-border' => __( 'Line border & shadow', 'canvys' ),
                  'arrow' => __( 'Arrow pointing up', 'canvys' ),
                  'arrow-border' => __( 'Arrow pointing up & border', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Select_Control( 'border_bottom', array(
               'title'       => __( 'Bottom Border', 'canvys' ),
               'description' => __( 'Specify how the bottom border should be styled', 'canvys' ),
               'default'     => 'none',
               'options'     => array(
                  'none'    => __( 'No special styling', 'canvys' ),
                  'border'  => __( 'Simple line border', 'canvys' ),
                  'shadow' => __( 'Faint inner shadow', 'canvys' ),
                  'shadow-border' => __( 'Line border & shadow', 'canvys' ),
                  'arrow' => __( 'Arrow pointing down', 'canvys' ),
                  'arrow-border' => __( 'Arrow pointing down & border', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Select_Control( 'padding_top', array(
               'title'       => __( 'Top Padding', 'canvys' ),
               'description' => __( 'The empty space above the content in this section.', 'canvys' ),
               'default'     => 'normal',
               'options'     => array(
                  'none'      => __( 'None', 'canvys' ),
                  'less'      => __( 'Less', 'canvys' ),
                  'normal'    => __( 'Normal', 'canvys' ),
                  'more'      => __( 'More', 'canvys' ),
                  'much-more' => __( 'Much More', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Select_Control( 'padding_bottom', array(
               'title'       => __( 'Bottom Padding', 'canvys' ),
               'description' => __( 'The empty space below the content in this section.', 'canvys' ),
               'default'     => 'normal',
               'options'     => array(
                  'none'      => __( 'None', 'canvys' ),
                  'less'      => __( 'Less', 'canvys' ),
                  'normal'    => __( 'Normal', 'canvys' ),
                  'more'      => __( 'More', 'canvys' ),
                  'much-more' => __( 'Much More', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Select_Control( 'visibility', array(
               'title'       => __( 'Visibility', 'canvys' ),
               'description' => __( 'Which devices this section should be visible on. This is great for optimizing your website for all devices. Please note that this setting is not applicable when full page content sliding is active.', 'canvys' ),
               'default'     => 'all',
               'options'     => $canvys['visibility_options'],
            ) ),

            new CV_Shortcode_Dev_Control( 'forced_height', array(
               'default' => null,
            ) ),

            new CV_Shortcode_Dev_Control( 'class', array(
               'default' => null,
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

      <script id="cv-builder-cv_section-script">
         (function($){
            "use strict";
            $(document).on( 'cv-composer-load-cv_section', function() {
               var $modal = $('#cv-composer-absolute-container').children().last();

               // Show appropriate background controls
               $modal.find('.control-bg_source select').on( 'change', function() {
                  var $this = $(this), val = $this.val();
                  switch ( val ) {
                     case 'default':
                        $modal.find('.control-bg_scrolling, .control-bg_preset_pattern, .control-bg_video_fallback, .control-bg_video_webm, .control-bg_video_ogv, .control-bg_video_mp4, .bg_video_poster, .control-bg_color, .control-bg_image, .control-bg_style, .control-bg_attachment, .control-overlay_opacity').hide().find('input, select').trigger('change');
                        break;
                     case 'color':
                        $modal.find('.control-bg_color').fadeIn();
                        $modal.find('.control-bg_scrolling, .control-bg_preset_pattern, .control-bg_video_fallback, .control-bg_video_webm, .control-bg_video_ogv, .control-bg_video_mp4, .bg_video_poster, .control-bg_image, .control-bg_style, .control-bg_attachment, .control-overlay_opacity').hide().find('input, select').trigger('change');
                        break;
                     case 'preset':
                        $modal.find('.control-bg_scrolling, .control-bg_preset_pattern, .control-bg_attachment, .control-overlay_opacity').fadeIn().find('input, select').trigger('change');
                        $modal.find('.control-bg_video_fallback, .control-bg_video_webm, .control-bg_video_ogv, .control-bg_video_mp4, .bg_video_poster, .control-bg_color, .control-bg_image, .control-bg_style').hide().find('input, select').trigger('change');
                        break;
                     case 'image':
                        $modal.find('.control-bg_scrolling, .control-bg_color, .control-bg_image, .control-bg_style, .control-bg_attachment, .control-overlay_opacity').fadeIn().find('input, select').trigger('change');
                        $modal.find('.control-bg_preset_pattern, .control-bg_video_fallback, .control-bg_video_webm, .control-bg_video_ogv, .control-bg_video_mp4, .bg_video_poster').hide();
                        break;
                     case 'video':
                        $modal.find('.control-bg_scrolling, .control-bg_preset_pattern, .control-bg_image, .control-bg_style, .control-bg_attachment').hide().find('input, select').trigger('change');
                        $modal.find('.control-bg_color, .control-bg_video_fallback, .control-bg_video_webm, .control-bg_video_ogv, .control-bg_video_mp4, .bg_video_poster, .control-overlay_opacity').fadeIn().find('select, input').trigger('change');
                        break;
                  }
               }).trigger('change');

               // Show / hide sidebar selector
               $modal.find('.control-sidebar_layout select').on( 'change', function() {
                  var $this = $(this), val = $this.val(),
                      $otherControls = $modal.find('.control-sidebar');
                  if ( 'no-sidebar' !== val ) {
                     $otherControls.fadeIn();
                  }
                  else {
                     $otherControls.hide();
                  }
               }).trigger('change');

               // Show / Hide overlay color control
               $modal.find('.control-overlay_opacity select').on( 'change', function() {
                  var $this = $(this), val = $this.val(),
                      $colorControl = $modal.find('.control-overlay_color'),
                      $bgStyleControl = $modal.find('.control-bg_source select');
                  if ( 'none' === val ) {
                     $colorControl.hide();
                  }
                  else if ( 'default' != $bgStyleControl.val() && 'color' != $bgStyleControl.val() ) {
                     $colorControl.fadeIn();
                  }
                  else {
                     $colorControl.hide();
                  }
               }).trigger('change');

               // Show / Hide BG scrolling speed control
               $modal.find('.control-bg_scrolling select').on( 'change', function() {
                  var $this = $(this), val = $this.val(),
                      $speedControl = $modal.find('.control-bg_scrolling_speed'),
                      $bgStyleControl = $modal.find('.control-bg_source select');
                  if ( 'none' === val ) {
                     $speedControl.hide();
                  }
                  else if ( 'default' != $bgStyleControl.val() && 'color' != $bgStyleControl.val() ) {
                     $speedControl.fadeIn();
                  }
                  else {
                     $speedControl.hide();
                  }
               }).trigger('change');

            });
         })(jQuery);
      </script>

   <?php }

   /**
    * Renders inline CSS required by the template builder
    *
    * @return mixed
    */
   public function builder_additional_styles() { ?>

      <style id="cv-builder-cv_section-module">
         .cv-module-cv_section .cv-sidebar-representation {
            display: none;
         }
         @media (min-width: 800px) {
            .cv-module-cv_section:not(.sidebar_layout-no-sidebar) > .cv-sidebar-representation {
               display: block;
               position: absolute;
               top: 0; bottom: 0;
               margin: auto 0;
               height: 35px;
               line-height: 35px;
               width: 125px;
               text-align: center;
               font-weight: 400;
               font-size: 14px;
               color: #999;
            }
            .cv-module-cv_section:not(.sidebar_layout-no-sidebar) > .cv-module-content {
               min-height: 185px;
            }
            .cv-module-cv_section.sidebar_layout-sidebar-left > .cv-module-content {
               border-left: 125px solid #eee !important;
            }
            .cv-module-cv_section.sidebar_layout-sidebar-left > .cv-sidebar-representation {
               left: 0;
            }
            .cv-module-cv_section.sidebar_layout-sidebar-right > .cv-module-content {
               border-right: 125px solid #eee !important;
            }
            .cv-module-cv_section.sidebar_layout-sidebar-right > .cv-sidebar-representation {
               right: 0;
            }
            html:not([dir="rtl"]) .cv-module-cv_section.sidebar_layout-sidebar-right > .cv-module-content {
               -webkit-border-radius: 0px 3px 3px 0px;
               border-radius: 0px 3px 3px 0px;
            }
            html:not([dir="rtl"]) .cv-module-cv_section.sidebar_layout-sidebar-left > .cv-sidebar-representation {
               left: 35px;
            }
            html[dir="rtl"] .cv-module-cv_section.sidebar_layout-sidebar-left > .cv-module-content {
               -webkit-border-radius: 3px 0px 0px 3px;
               border-radius: 3px 0px 0px 3px;
            }
            html[dir="rtl"] .cv-module-cv_section.sidebar_layout-sidebar-right > .cv-sidebar-representation {
               right: 35px;
            }
         }
      </style>

   <?php }

   /**
    * Callback function for displaying the template builder module container
    *
    * @return CV_HTML
    */
   public function builder_module_container( $title = null ) {

      // Create the module
      $module = new CV_HTML( '<div>', array(
         'class' => 'cv-builder-module cv-is-draggable has-clearfix',
         'data-droptarget' => strval( $this->config['drop_target'] ),
         'data-handle' => $this->config['handle'],
         'data-title' => $this->config['title'],
      ) );

      // Apply additional classes
      $module->add_class( 'cv-module-' . $this->config['handle'] );
      $module->add_class( 'has-dropzone' );

      // Insert sidebar representation
      $module->append('<div class="cv-sidebar-representation">' . __( 'Sidebar', 'canvys' ) . '</div>');

      return $module;

   }

   /**
    * Callback function for front end display of shortcode
    *
    * @param array  $atts      Array of provided attributes
    * @param string $content   Content of shortcode
    * @return string
    */
   public function callback( $atts, $content = null ) {

      global $canvys;

      // Records number of sections
      static $num_sections;
      $num_sections++;

      // Extract sanitized attributes
      extract( $this->get_sanitized_attributes( $atts ) );

      // Set the global sidebar layout
      $canvys['current_sidebar_layout'] = $sidebar_layout;

      // The row container
      $o = new CV_HTML( '<section>', array(
         'class' => 'cv-content-section',
      ) );

      // Apply the section number class
      $o->add_class( 'cv-section-' . $num_sections );

      // Create the ID attribute
      $section_id = $id ? $id : 'cv-section-' . $num_sections;

      // Apply the ID attribute
      $o->attr( 'id', sanitize_html_class( $section_id ) );

      // Apply the color scheme class
      $o->add_class( 'cv-section-' . $color_scheme );

      // Apply the visibility class
      if ( ! cv_is_page_slide_active() ) {
         $o->data( 'visibility', $visibility );
      }

      // Certain settings are not applicable when page sliding is active
      if ( cv_is_page_slide_active() ) {
         $min_height = 'none';
         $forced_height = null;
         $border_top = 'none';
         $border_bottom = 'none';
         $bg_attachment = 'scroll';
         if ( 'video' == $bg_source ) $bg_source = 'default';
      }

      // Apply the border styling
      foreach ( array( 'top' => $border_top, 'bottom' => $border_bottom ) as $border => $styles ) {

         // Do not apply any classes
         if ( 'none' == $styles ) {
            continue;
         }

         foreach ( explode( '-', $styles ) as $style ) {
            $o->add_class( $border . '-' . $style );
            if ( 'arrow' == $style ) $o->append( '<div class="cv-' . $border . '-arrow"></div>' );
            if ( 'shadow' == $style ) $o->append( '<div class="cv-' . $border . '-shadow"></div>' );
         }

      }

      // Add the BG source class
      $o->add_class( 'bg-source-' . $bg_source );

      // Apply the correct background styling
      switch ( $bg_source ) {

         case 'color':
            if ( $bg_color ) {

               $o->css( 'background-color', $bg_color );

               // Apply the border styling
               foreach ( array( 'top' => $border_top, 'bottom' => $border_bottom ) as $border => $styles ) {

                  // Determine which border to style
                  $border_target = 'top' == $border ? 'bottom' : 'top';

                  // Determine which color the border should be
                  $saturation = 0.15 > cv_hex_brightness( $bg_color ) ? 0.25 : -0.25;
                  $border_color = cv_saturate_hex( $bg_color, $saturation );

                  $inline_styles = null;

                  // Create the styles to be applied
                  if ( false !== strpos( $styles, 'arrow' ) ) {
                     $inline_styles .= '#' . $section_id . '.' . $border . '-arrow .cv-' . $border . '-arrow:after {border-' . $border_target . '-color:' . $bg_color . ' !important;}';
                     $inline_styles .= '#' . $section_id . '.' . $border . '-arrow.' . $border . '-border .cv-' . $border . '-arrow:before {border-' . $border_target . '-color:' . $border_color . ' !important;}';
                  }
                  if ( false !== strpos( $styles, 'border' ) ) {
                     $inline_styles .= '#' . $section_id . '.' . $border . '-border {border-' . $border_target . '-color:' . $border_color . ' !important;}';
                  }

                  if ( $inline_styles ) {

                     // Render the loading styles
                     ?><script id="<?php echo $section_id; ?>-inline-border-<?php echo $border; ?>-script">

                        var css = '<?php echo $inline_styles; ?>',
                            style = document.createElement('style');

                        if ( style.styleSheet ){
                           style.styleSheet.cssText = css;
                        }
                        else {
                           style.appendChild( document.createTextNode( css ) );
                        }

                        // Add the new style rules
                        document.head.appendChild( style );

                        // Remove this node
                        var element = document.getElementById('<?php echo $section_id; ?>-inline-border-<?php echo $border; ?>-script');
                        element.parentNode.removeChild(element);

                     </script><?php

                  }

               }

            }

            break;

         case 'image':
            if ( $bg_color ) {
               $o->css( 'background-color', $bg_color );
            }
            if ( $bg_image ) {

               // Apply the bg image
               if ( $img_data = wp_get_attachment_image_src( $bg_image, 'cv_full' ) ) {

                  // Apply the background scrolling attribute
                  if ( 'none' !== $bg_scrolling ) {
                     $o->data( 'bg-scrolling', $bg_scrolling );
                     $o->data( 'bg-scrolling-speed', $bg_scrolling_speed );
                  }

                  // Fade in image after it has loaded
                  if ( $bg_color ) {

                     // Apply the loading class
                     $o->add_class( 'is-loading-bg-image' );

                     // Create box shadow CSS
                     $box_shadow = 'inset ' . $bg_color . ' 0px 0px 0px 5000px !important';
                     $box_shadow = '-webkit-box-shadow:' . $box_shadow . ';box-shadow:' . $box_shadow . ';'

                     // Render the loading styles
                     ?><script id="<?php echo $section_id; ?>-inline-script">

                        var css = '#<?php echo $section_id; ?>.is-loading-bg-image {<?php echo $box_shadow; ?>}',
                            style = document.createElement('style');

                        if ( style.styleSheet ){
                           style.styleSheet.cssText = css;
                        }
                        else {
                           style.appendChild( document.createTextNode( css ) );
                        }

                        // Add the new style rules
                        document.head.appendChild( style );

                        // Remove this node
                        var element = document.getElementById('<?php echo $section_id; ?>-inline-script');
                        element.parentNode.removeChild(element);

                     </script><?php

                  }

                  // Apply the background styles
                  $o->css( array(
                     'background-image' => "url({$img_data[0]})",
                     'background-attachment' => $bg_attachment,
                     'background-position' => 'center center',
                  ) );
                  if ( 'cover' == $bg_style ) {
                     $o->css( 'background-size', 'cover' );
                  }

                  // Apply the overlay style
                  if ( 'none' !== $overlay_opacity && $overlay_color ) {
                     $overlay_opacity = $overlay_opacity / 100;
                     $box_shadow = 'inset ' . cv_hex_to_rgba( $overlay_color, $overlay_opacity ) . ' 0px 0px 0px 5000px';
                     $o->css( array(
                        '-webkit-box-shadow' => $box_shadow,
                        'box-shadow' => $box_shadow,
                     ) );
                  }

               }

            }
            break;

         case 'preset':

            // Apply the background scrolling attribute
            if ( 'none' !== $bg_scrolling ) {
               $o->data( 'bg-scrolling', $bg_scrolling );
               $o->data( 'bg-scrolling-speed', $bg_scrolling_speed );
            }

            // Grab the pattern image URL
            $img_url = THEME_DIR . 'assets/img/patterns/' . $bg_preset_pattern . '.png';

            // Apply the background styles
            $o->css( array(
               'background-image' => "url({$img_url})",
               'background-attachment' => $bg_attachment,
               'background-position' => 'center center',
               'background-repeat' => 'repeat',
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

            break;

         case 'video':

            if ( $bg_color ) {
               $o->css( 'background-color', $bg_color );
            }

            $sources = null;

            if ( $bg_video_webm ) {
               $sources .= '<source src="' . $bg_video_webm . '" type="video/webm" />';
            }
            if ( $bg_video_ogv ) {
               $sources .= '<source src="' . $bg_video_ogv . '" type="video/ogg" />';
            }
            if ( $bg_video_mp4 ) {
               $sources .= '<source src="' . $bg_video_mp4 . '" type="video/mp4" />';
            }

            // If atleast one source has been specified
            if ( $sources ) {

               // Determine if an image fallback has been provided
               $img_info = $bg_video_fallback ? wp_get_attachment_image_src( $bg_video_fallback, 'cv_full' ) : null;
               if ( $img_fallback = $img_info ? $img_info[0] : null ) {
                  $o->append( '<div class="bg-video-image-fallback bg-style-cover" style="background-image:url(' . $img_fallback . ')"></div>' );
               }

               // Apply the has video class
               $o->add_class( 'has-video-bg' );

               // Add the video element
               $video = new CV_HTML( '<video>', array(
                  'class' => 'bg-video',
                  'id' => $section_id . '-video_bg',
                  'preload' => 'auto',
                  'autoplay' => 'autoplay',
                  'loop' => 'loop',
                  'muted' => 'muted',
                  'content' => $sources,
               ) );

               // Add the video to the section
               $o->append( '<div class="bg-video-wrapper v-align-middle"><div>' . $video . '</div></div>' );

               // Add the video overlay
               $overlay = new CV_HTML( '<div>', array(
                  'class' => 'bg-video-overlay'
               ) );

               // Apply the overlay style
               if ( 'none' !== $overlay_opacity && $overlay_color ) {
                  $overlay_opacity = $overlay_opacity / 100;
                  $box_shadow = 'inset ' . cv_hex_to_rgba( $overlay_color, $overlay_opacity ) . ' 0px 0px 0px 5000px';
                  $overlay->css( array(
                     '-webkit-box-shadow' => $box_shadow,
                     'box-shadow' => $box_shadow,
                  ) );
               }

               // Add the overlay to the section
               $o->append( $overlay );

            }

            break;

      }

      // The section content wrap
      $wrap = new CV_HTML( '<div>', array(
         'class' => 'wrap has-clearfix',
      ) );

      // Apply the stretched layout class
      if ( ! cv_make_bool( $stretched ) ) $wrap->add_class( 'is-' . $stretched );

      // Apply the sidebar layout class
      $wrap->add_class( $sidebar_layout );
      if ( 'no-sidebar' != $sidebar_layout ) {
         $wrap->add_class( 'has-sidebar' );
      }

      // Turn section into a typography scaler
      $scaling_class = null;
      $scaling_data = null;
      if ( cv_is_page_slide_active() ) {
         switch ( cv_theme_setting( 'visual', 'font_size', 'smaller' ) ) {
            case 'much-smaller': $max_font = '12';   break;
            case 'smaller':      $max_font = '13'; break;
            case 'larger':       $max_font = '15'; break;
            case 'much-larger':  $max_font = '16';      break;
            default: $max_font = '14';
         }
         $scaling_class = ' cv-scaling-typography';
         $scaling_data  = ' data-max="' . $max_font . '"';
         $scaling_data .= ' data-min="10"';
      }

      // Append the content
      $wrap->append( '<div class="content-section-detail"><div class="cv-user-font' . $scaling_class . '"' . $scaling_data . '>' . "\n\n" . do_shortcode( $content ) . "\n\n" . '</div></div>' );

      // Add the sidebar if there is one and it is active
      if ( 'no-sidebar' != $sidebar_layout && 'none' != $sidebar && is_active_sidebar( $sidebar ) ) {

         // Create the sidebar
         ob_start();
         echo '<div class="sidebar content-section-sidebar"><div class="cv-user-font">';
         do_action( 'cv_before_sidebar' ); dynamic_sidebar($sidebar); do_action( 'cv_after_sidebar' );
         echo '</div></div>';
         $sidebar = ob_get_clean();

         // Add the sidebar
         $wrap->append( $sidebar );

      }

      // Apply padding classes
      $o->add_class( 'padding-top-' . $padding_top );
      $o->add_class( 'padding-bottom-' . $padding_bottom );

      // Wraps and sizes the content
      $wrap_container = new CV_HTML( '<div>', array(
         'class' => 'cv-wrap-wrapper',
         'content' => '<div>' . $wrap . '</div>',
      ) );

      // Apply the parallax class
      if ( cv_make_bool( $parallax ) ) {
         $wrap_container->add_class( 'cv-parallax-content' );
      }

      // Apply the forced height style
      if ( $forced_height ) {
         $min_height = 'none';
         $wrap_container->add_class( 'v-align-middle' );
         $wrap_container->css( array(
            'height' => $forced_height,
            'max-height' => $forced_height,
            'overflow' => 'hidden',
         ) );
      }

      // Apply the min height attribute
      if ( 'none' !== $min_height ) {
         $wrap_container->data( 'min-height', $min_height );
         $wrap_container->add_class( 'v-align-middle' );
      }

      // Add the content
      $o->append( $wrap_container );

      // Apply any additional classes
      $o->add_class( $class );

      return $o->render();

   }

}
endif;