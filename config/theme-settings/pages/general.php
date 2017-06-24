<?php

if ( ! class_exists('CV_General_Settings') ) :

/**
 * General settings page
 *
 * @package    WordPress
 * @subpackage Canvys
 * @since      Version 1.0
 */
class CV_General_Settings extends CV_Settings_Page {

   /**
    * Function to create page configuration
    *
    * @return void
    */
   public function __construct() {

      global $canvys;

      $this->config = array(
         'tab_title' => __( 'General', 'canvys' ),
         'slug' => 'general',
         'priority' => 20,
         'defaults' => array(
            'simple_breadcrumbs'       => false,
            'disable_responsive'       => false,
            'disable_builder_previews' => false,
            'enable_floating_anchor'   => true,
            'floating_anchor_color'    => '#000000',
            'disabled_comments' => array(
               'post' => false,
               'page' => false,
               'portfolio_item' => false,
            ),
         ),
      );

   }

   /**
    * Loading additional styles to the settings page
    *
    * @return void
    */
   public function additional_styles() { ?>
      <style id="cv-theme-settings-general-style">
         .disable-comments-option {
            padding-bottom: 0 !important;
         }
         .disable-comments-option label {
            display: block;
            padding: 15px 10px;
            background: #f9f9f9;
            margin-bottom: 10px;
            -webkit-transition: all 0.25s ease;
            -moz-transition: all 0.25s ease;
            -ms-transition: all 0.25s ease;
            -o-transition: all 0.25s ease;
            transition: all 0.25s ease;
            -webkit-border-radius: 3px;
            border-radius: 3px;
         }
         .option-wrap:hover .disable-comments-option label {
            background: #fff;
         }
      </style>
   <?php }

   /**
    * Loading additional scripts to the settings page
    *
    * @return void
    */
   public function additional_scripts() { ?>
      <script id="cv-theme-settings-general-script">
         (function($) {
            $(document).ready( function() {

               // Show / Hide anchor color control
               $('#general-enable_floating_anchor').change( function() {
                  var $this = $(this), $anchorColorControl = $('#visual-floating_anchor_color-wrap');
                  if ( $this.prop('checked') ) {
                     $anchorColorControl.slideDown();
                  }
                  else {
                     $anchorColorControl.slideUp();
                  }
               }).trigger('change');

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
      $name = 'cv_theme_settings[' . $this->config['slug'] . ']';
      $input = $this->extract_input( $input ); ?>

      <div class="option-wrap">
         <strong class="option-title"><?php _e( 'Simple Bread Crumbs', 'canvys' ); ?></strong>
         <label for="general-simple_breadcrumbs">
            <input type="checkbox" id="general-simple_breadcrumbs" value="1" <?php checked( $input['simple_breadcrumbs'] ); ?> name="<?php echo $name; ?>[simple_breadcrumbs]" />
            <span><?php _e( 'Hide simple bread crumbs, this refers to any time the current page is a direct child of the home page, for example "Home > Blog" or "Home > Shop".', 'canvys' ); ?></span>
         </label>
      </div>

      <div class="option-wrap">
         <strong class="option-title"><?php _e( 'Responsive Behavior', 'canvys' ); ?></strong>
         <label for="general-disable-responsive">
            <input type="checkbox" id="general-disable-responsive" value="1" <?php checked( $input['disable_responsive'] ); ?> name="<?php echo $name; ?>[disable_responsive]" />
            <span><?php _e( 'Disable all responsive features, website will not respond to different screen sizes.', 'canvys' ); ?></span>
         </label>
      </div>

      <div class="option-wrap">
         <strong class="option-title"><?php _e( 'Template Builder Module Previews', 'canvys' ); ?></strong>
         <label for="general-disable_builder_previews">
            <input type="checkbox" id="general-disable_builder_previews" value="1" <?php checked( $input['disable_builder_previews'] ); ?> name="<?php echo $name; ?>[disable_builder_previews]" />
            <span><?php _e( 'Disable the template builder module previews, recommended if you will be working with pages that have a lot of content.', 'canvys' ); ?></span>
         </label>
      </div>

      <div class="option-wrap">

         <strong class="option-title"><?php _e( 'Floating Back to Top Link', 'canvys' ); ?></strong>
         <label for="general-enable_floating_anchor">
            <input type="checkbox" id="general-enable_floating_anchor" value="1" <?php checked( $input['enable_floating_anchor'] ); ?> name="<?php echo $name; ?>[enable_floating_anchor]" />
            <span><?php _e( 'Enable the floating back to top link in the bottom corner of the screen.', 'canvys' ); ?></span>
         </label>

         <div id="visual-floating_anchor_color-wrap">

            <div class="option-spacer"></div>

            <label class="option-title" for="visual-floating_anchor_color"><?php _e( 'Floating Back to Top Link Color', 'canvys' ); ?></label>
            <input type="text" class="cv-color-picker" id="visual-floating_anchor_color" value="<?php echo $input['floating_anchor_color']; ?>" name="<?php echo $name; ?>[floating_anchor_color]" />
            <p class="option-description"><?php _e( 'Select the color to be used for the floating back to top link.', 'canvys' ); ?></p>

         </div>

      </div>

      <?php $disabled_comments_options = array(
         'post'           => __( 'Blog', 'canvys' ),
         'page'           =>  __( 'Pages', 'canvys' ),
         'portfolio_item' =>  __( 'Portfolio', 'canvys' ),
      ); ?>

      <div class="option-wrap">
         <strong class="option-title"><?php _e( 'Disable Comments', 'canvys' ); ?></strong>
         <div class="cv-grid-3 spacing-1 has-clearfix">
            <?php foreach ( $disabled_comments_options as $option => $title ) : ?>
               <div class="disable-comments-option">
                  <label for="general-disabled_comments-<?php echo $option; ?>">
                     <input type="checkbox" id="general-disabled_comments-<?php echo $option; ?>" value="1" <?php checked( $input['disabled_comments'][$option] ); ?> name="<?php echo $name; ?>[disabled_comments][<?php echo $option; ?>]" />
                     <?php echo $title; ?>
                  </label>
               </div>
            <?php endforeach; ?>
         </div>
         <p class="option-description"><?php _e( 'Specify which post types comments should be disabled on.', 'canvys' ); ?></p>
      </div>

   <?php }

   /**
    * Sanitizing the page specific input
    *
    * @param array $input The user specified input
    * @return array
    */
   public static function sanitize_input( $input ) {

      $disabled_comments = array();
      $disabled_comments_options = array( 'post', 'page', 'portfolio_item' );
      foreach ( $disabled_comments_options as $option ) {
         $disabled_comments[$option] = isset( $input['disabled_comments'][$option] ) && $input['disabled_comments'][$option] ? true : false;
      }

      return array(
         'simple_breadcrumbs'       => isset( $input['simple_breadcrumbs'] ) && $input['simple_breadcrumbs'] ? true : false,
         'disable_responsive'       => isset( $input['disable_responsive'] ) && $input['disable_responsive'] ? true : false,
         'disable_builder_previews' => isset( $input['disable_builder_previews'] ) && $input['disable_builder_previews'] ? true : false,
         'enable_floating_anchor'   => isset( $input['enable_floating_anchor'] ) && $input['enable_floating_anchor'] ? true : false,
         'floating_anchor_color'    => isset( $input['floating_anchor_color'] ) ? cv_filter( $input['floating_anchor_color'], 'hex' ) : '#000000',
         'disabled_comments'        => $disabled_comments,
      );

   }

}
endif;