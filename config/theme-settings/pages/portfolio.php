<?php

if ( ! class_exists('CV_Portfolio_Settings') ) :

/**
 * General settings page
 *
 * @package    WordPress
 * @subpackage Canvys
 * @since      Version 1.0
 */
class CV_Portfolio_Settings extends CV_Settings_Page {

   /**
    * Function to create page configuration
    *
    * @return void
    */
   public function __construct() {

      global $canvys;

      $this->config = array(
         'tab_title' => __( 'Portfolio', 'canvys' ),
         'slug' => 'portfolio',
         'priority' => 80,
         'defaults' => array(
            'singular_label'          => null,
            'portfolio_page'          => 'none',
            'related_portfolio_items' => true,
            'featured_image_visible'  => true,
            'featured_image_full'     => false,
            'banner_behavior'         => 'default',
         ),
      );

   }

   /**
    * Loading additional scripts to the settings page
    *
    * @return void
    */
   public function additional_scripts() { ?>
      <script id="cv-theme-settings-portfolio-script">
         (function($) {
            $(document).ready( function() {

               // Show/Hide Featured image full option
               $('#portfolio-featured_image_visible').on( 'change', function() {
                  var $this = $(this), $wrap = $('#portfolio-featured_image_full-wrap');
                  if ( $this.prop('checked') ) {
                     $wrap.slideDown();
                  }
                  else {
                     $wrap.slideUp();
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
         <strong class="option-title"><?php _e( 'Portfolio Item Labels', 'canvys' ); ?></strong>
         <div class="cv-split-2 spacing-2 has-clearfix">
            <div>
               <label class="sub-option-title" for="portfolio-singular_label"><?php _e( 'Singular Item Label', 'canvys' ); ?></label>
               <input type="text" class="widefat" id="portfolio-singular_label" value="<?php echo $input['singular_label']; ?>" name="<?php echo $name; ?>[singular_label]" placeholder="<?php _e( 'Project', 'canvys' ) ?>" />
            </div>
            <div>
               <label class="sub-option-title" for="portfolio-plural_label"><?php _e( 'Plural Item Label', 'canvys' ); ?></label>
               <input type="text" class="widefat" id="portfolio-plural_label" value="<?php echo $input['plural_label']; ?>" name="<?php echo $name; ?>[plural_label]" placeholder="<?php _e( 'Projects', 'canvys' ) ?>" />
            </div>
         </div>
         <p><?php _e( 'Specify the label used to describe each portfolio item. For example if your portfolio is comprised of a series of paintings you would enter <em>Painting</em>, or <em>Picture</em> for a photography based portfolio.', 'canvys' ); ?></p>
      </div>


      <div class="option-wrap">
         <label class="option-title" for="portfolio-portfolio_page"><?php _e( 'Portfolio Page', 'canvys' ); ?></label>
         <?php wp_dropdown_pages( array(
            'show_option_none'  => __( 'None', 'canvys' ),
            'option_none_value' => 'none',
            'selected'          => $input['portfolio_page'],
            'name'              => $name . '[portfolio_page]',
            'id'                => 'portfolio-portfolio_page',
         ) ); ?>
         <p class="option-description"><?php _e( 'Specify the page which is currently serving as your main portfolio page, this is used for site mapping. If you do not have a portfolio page leave this set to "none".', 'canvys' ); ?></p>
      </div>

      <div class="option-wrap">
         <label class="option-title" for="portfolio-banner_behavior"><?php _e( 'Portfolio Item Header & Banner Behavior', 'canvys' ); ?></label>
         <select name="<?php echo $name; ?>[banner_behavior]" id="portfolio-banner_behavior">
            <option value="default" <?php selected( $input['banner_behavior'], 'default' ); ?>><?php _e( 'Use theme defaults (Set in Theme Settings > Header)', 'canvys' ); ?></option>
            <option value="portfolio_page" <?php selected( $input['banner_behavior'], 'portfolio_page' ); ?>><?php _e( 'Match the settings for the portfolio page specified above', 'canvys' ); ?></option>
            <option value="hidden" <?php selected( $input['banner_behavior'], 'hidden' ); ?>><?php _e( 'Use theme defaults (Set in Theme Settings > Header) and hide the banner text', 'canvys' ); ?></option>
            <option value="portfolio_page-hidden" <?php selected( $input['banner_behavior'], 'portfolio_page-hidden' ); ?>><?php _e( 'Match the settings for the portfolio page specified above, and hide the banner text', 'canvys' ); ?></option>
         </select>
         <p><?php _e( 'Specify how the banner on portfolio item pages should be displayed, keep in mind that by default the item title is only displayed in the banner. You can override this setting for each item individually as well.', 'canvys' ); ?></p>
      </div>

      <div class="option-wrap">
         <strong class="option-title"><?php _e( 'Display Related Portfolio Items', 'canvys' ); ?></strong>
         <label for="portfolio-related_portfolio_items">
            <input type="checkbox" id="portfolio-related_portfolio_items" value="1" <?php checked( $input['related_portfolio_items'] ); ?> name="<?php echo $name; ?>[related_portfolio_items]" />
            <span><?php _e( 'On single portfolio item pages display related items below the post content.', 'canvys' ); ?></span>
         </label>
      </div>

      <div class="option-wrap">
         <strong class="option-title"><?php _e( 'Automatically Display Featured Images', 'canvys' ); ?></strong>
         <label for="portfolio-featured_image_visible">
            <input type="checkbox" id="portfolio-featured_image_visible" value="1" <?php checked( $input['featured_image_visible'] ); ?> name="<?php echo $name; ?>[featured_image_visible]" />
            <span><?php _e( 'Display the featured image immediately before the portfolio item content, this only applies to items whose content was not created using the page builder.', 'canvys' ); ?></span>
         </label>

         <div id="portfolio-featured_image_full-wrap">
            <div class="option-spacer"></div>
            <strong class="option-title"><?php _e( 'Full Size Featured Images', 'canvys' ); ?></strong>
            <label for="portfolio-featured_image_full">
               <input type="checkbox" id="portfolio-featured_image_full" value="1" <?php checked( $input['featured_image_full'] ); ?> name="<?php echo $name; ?>[featured_image_full]" />
               <span><?php _e( 'On portfolio item pages allow the featured image to be expanded to full size.', 'canvys' ); ?></span>
            </label>
         </div>
      </div>

   <?php }

   /**
    * Sanitizing the page specific input
    *
    * @param array $input The user specified input
    * @return array
    */
   public static function sanitize_input( $input ) {
      return array(
         'singular_label'          => isset( $input['singular_label'] ) ? cv_filter( $input['singular_label'], 'text' ) : null,
         'plural_label'            => isset( $input['plural_label'] ) ? cv_filter( $input['plural_label'], 'text' ) : null,
         'portfolio_page'          => isset( $input['portfolio_page'] ) ? $input['portfolio_page'] : 'none',
         'related_portfolio_items' => isset( $input['related_portfolio_items'] ) && $input['related_portfolio_items'] ? true : false,
         'featured_image_visible'  => isset( $input['featured_image_visible'] ) && $input['featured_image_visible'] ? true : false,
         'featured_image_full'     => isset( $input['featured_image_full'] ) && $input['featured_image_full'] ? true : false,
         'banner_behavior'         => isset( $input['banner_behavior'] ) ? cv_filter( $input['banner_behavior'], array( 'default', 'portfolio_page', 'hidden' ) ) : 'default',
      );
   }

}
endif;