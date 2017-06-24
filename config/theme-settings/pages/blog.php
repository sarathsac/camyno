<?php

if ( ! class_exists('CV_Blog_Settings') ) :

/**
 * General settings page
 *
 * @package    WordPress
 * @subpackage Canvys
 * @since      Version 1.0
 */
class CV_Blog_Settings extends CV_Settings_Page {

   /**
    * Function to create page configuration
    *
    * @return void
    */
   public function __construct() {

      global $canvys;

      $this->config = array(
         'tab_title' => __( 'Blog', 'canvys' ),
         'slug' => 'blog',
         'priority' => 70,
         'defaults' => array(
            'blog_page'           => 'none',
            'featured_image_full' => false,
            'disable_formats'     => false,
            'banner_behavior'     => 'default',
            'loop_type'           => 'standard',
            'masonry_columns'     => '2',
            'related_posts'       => true,
            'disabled_meta' => array(
               'author' => false,
               'comments' => false,
               'category' => false,
               'date' => false,
               'tags' => false,
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
      <style id="cv-theme-settings-blog-style">
         .disable-meta-option {
            padding-bottom: 0 !important;
         }
         .disable-meta-option label {
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
         .option-wrap:hover .disable-meta-option label {
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
      <script id="cv-theme-settings-blog-script">
         (function($) {
            $(document).ready( function() {

               $('#blog-loop_type').on( 'change', function() {
                  var $this = $(this), val = $this.val(),
                  $columnsControl = $('#cv-blog-masonry-columns-wrap');
                  if ( 'masonry' === val || 'masonry-stretched' === val ) { $columnsControl.fadeIn(); }
                  else { $columnsControl.fadeOut(); }
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
         <label class="option-title" for="blog-blog_page"><?php _e( 'Blog Page', 'canvys' ); ?></label>
         <?php wp_dropdown_pages( array(
            'show_option_none'  => __( 'None', 'canvys' ),
            'option_none_value' => 'none',
            'selected'          => $input['blog_page'],
            'name'              => $name . '[blog_page]',
            'id'                => 'blog-blog_page',
         ) ); ?>
         <p class="option-description"><?php _e( 'Specify the page which is currently serving as your main blog page, this is used for site mapping. If you do not have a blog page leave this set to "none".', 'canvys' ); ?></p>
      </div>

      <div class="option-wrap">
         <strong class="option-title"><?php _e( 'Blog Header & Banner Behavior', 'canvys' ); ?></strong>
         <select name="<?php echo $name; ?>[banner_behavior]" id="blog-banner_behavior">
            <option value="default" <?php selected( $input['banner_behavior'], 'default' ); ?>><?php _e( 'Use theme defaults (Set in Theme Settings > Header)', 'canvys' ); ?></option>
            <option value="blog_page" <?php selected( $input['banner_behavior'], 'blog_page' ); ?>><?php _e( 'Match the settings for the blog page specified above', 'canvys' ); ?></option>
            <option value="hidden" <?php selected( $input['banner_behavior'], 'hidden' ); ?>><?php _e( 'Use theme defaults (Set in Theme Settings > Header) and hide the banner text', 'canvys' ); ?></option>
            <option value="blog_page-hidden" <?php selected( $input['banner_behavior'], 'blog_page-hidden' ); ?>><?php _e( 'Match the settings for the blog page specified above, and hide the banner text', 'canvys' ); ?></option>
         </select>
         <p><?php _e( 'Specify how the banner and header on single post pages and archive pages should be displayed.', 'canvys' ); ?></p>
      </div>

      <div class="option-wrap">

         <div class="cv-split-2 has-clearfix spacing-2">
            <div>
               <label for="blog-loop_type" class="option-title"><?php _e( 'Blog Style', 'canvys' ); ?></label>
               <select name="<?php echo $name; ?>[loop_type]" id="blog-loop_type">
                  <option value="standard" <?php selected( $input['loop_type'], 'standard' ); ?>><?php _e( 'Standard', 'canvys' ); ?></option>
                  <option value="boxed" <?php selected( $input['loop_type'], 'boxed' ); ?>><?php _e( 'Boxed', 'canvys' ); ?></option>
                  <option value="masonry" <?php selected( $input['loop_type'], 'masonry' ); ?>><?php _e( 'Masonry', 'canvys' ); ?></option>
                  <option value="minimal" <?php selected( $input['loop_type'], 'minimal' ); ?>><?php _e( 'Minimal', 'canvys' ); ?></option>
                  <optgroup label="<?php _e( 'Stretched Layouts (Only applicable if the blog layout is set to no sidebar)', 'canvys' ); ?>">
                     <option value="masonry-stretched" <?php selected( $input['loop_type'], 'masonry-stretched' ); ?>><?php _e( 'Masonry - Stretched', 'canvys' ); ?></option>
                     <option value="minimal-stretched" <?php selected( $input['loop_type'], 'minimal-stretched' ); ?>><?php _e( 'Minimal - Stretched', 'canvys' ); ?></option>
                  </optgroup>
               </select>
            </div>

            <div>
               <div id="cv-blog-masonry-columns-wrap">
                  <label for="blog-masonry_columns" class="option-title"><?php _e( 'Number of Columns', 'canvys' ); ?></label>
                  <select name="<?php echo $name; ?>[masonry_columns]" id="blog-masonry_columns">
                     <?php for ( $i=2; $i<6; $i++ ) : ?>
                        <option value="<?php echo $i; ?>" <?php selected( $input['masonry_columns'], $i ); ?>><?php printf( __( '%s Columns', 'canvys' ), $i ); ?></option>
                     <?php endfor; ?>
                  </select>
               </div>
            </div>
         </div>

         <p></p>

         <p class="description"><?php _e( 'This setting is also applied to other blog related pages, including archives.', 'canvys' ); ?></p>

      </div>

      <div class="option-wrap">
         <strong class="option-title"><?php _e( 'Related Posts Below Single Posts', 'canvys' ); ?></strong>
         <label for="blog-related_posts">
            <input type="checkbox" id="blog-related_posts" value="1" <?php checked( $input['related_posts'] ); ?> name="<?php echo $name; ?>[related_posts]" />
            <span><?php _e( 'On single post pages display related posts below the post content.', 'canvys' ); ?></span>
         </label>
      </div>

      <div class="option-wrap">
         <strong class="option-title"><?php _e( 'Full Size Featured Images', 'canvys' ); ?></strong>
         <label for="blog-featured_image_full">
            <input type="checkbox" id="blog-featured_image_full" value="1" <?php checked( $input['featured_image_full'] ); ?> name="<?php echo $name; ?>[featured_image_full]" />
            <span><?php _e( 'On single post pages allow the featured image to be expanded to full size.', 'canvys' ); ?></span>
         </label>
      </div>

      <?php $disable_meta_options = array(
         'author' => __( 'Post Author', 'canvys' ),
         'comments' =>  __( 'Comment Count', 'canvys' ),
         'category' =>  __( 'Post Category', 'canvys' ),
         'date' =>  __( 'Post Date', 'canvys' ),
         'tags' =>  __( 'Post Tags', 'canvys' ),
      ); ?>

      <div class="option-wrap">
         <strong class="option-title"><?php _e( 'Disabled Post Meta', 'canvys' ); ?></strong>
         <div class="cv-grid-3 spacing-1 has-clearfix">
            <?php foreach ( $disable_meta_options as $option => $title ) : ?>
               <div class="disable-meta-option">
                  <label for="blog-disabled_meta-<?php echo $option; ?>">
                     <input type="checkbox" id="blog-disabled_meta-<?php echo $option; ?>" value="1" <?php checked( $input['disabled_meta'][$option] ); ?> name="<?php echo $name; ?>[disabled_meta][<?php echo $option; ?>]" />
                     <?php echo $title; ?>
                  </label>
               </div>
            <?php endforeach; ?>
         </div>
      </div>

      <div class="option-wrap">
         <strong class="option-title"><?php _e( 'Post Formats', 'canvys' ); ?></strong>
         <label for="blog-disable_formats">
            <input type="checkbox" id="blog-disable_formats" value="1" <?php checked( $input['disable_formats'] ); ?> name="<?php echo $name; ?>[disable_formats]" />
            <span><?php printf( __( 'Disable post formats, learn more about post formats <a href="%s">here</a>.', 'canvys' ), 'http://codex.wordpress.org/Post_Formats' ); ?></span>
         </label>
      </div>

   <?php }

   /**
    * Sanitizing the page specific input
    *
    * @param array $input The user specified input
    * @return array
    */
   public static function sanitize_input( $input ) {

      $disabled_meta = array();
      $meta_options = array( 'author', 'comments', 'category', 'date', 'tags' );
      foreach ( $meta_options as $option ) {
         $disabled_meta[$option] = isset( $input['disabled_meta'][$option] ) && $input['disabled_meta'][$option] ? true : false;
      }

      return array(
         'blog_page'            => isset( $input['blog_page'] ) ? $input['blog_page'] : 'none',
         'featured_image_full'  => isset( $input['featured_image_full'] ) && $input['featured_image_full'] ? true : false,
         'disable_formats'      => isset( $input['disable_formats'] ) && $input['disable_formats'] ? true : false,
         'banner_behavior'      => isset( $input['banner_behavior'] ) ? cv_filter( $input['banner_behavior'], array( 'default', 'blog_page', 'blog_page-hidden', 'hidden' ) ) : 'default',
         'loop_type'            => isset( $input['loop_type'] ) ? cv_filter( $input['loop_type'], array( 'standard', 'minimal', 'minimal-stretched', 'modern', 'author', 'boxed', 'boxed-modern', 'boxed-author', 'masonry', 'masonry-stretched' ) ) : 'standard',
         'masonry_columns'      => isset( $input['masonry_columns'] ) ? cv_filter( $input['masonry_columns'], 'integer' ) : '2',
         'related_posts'        => isset( $input['related_posts'] ) && $input['related_posts'] ? true : false,
         'disabled_meta'        => $disabled_meta,
      );
   }

}
endif;