<?php

if ( ! class_exists('CV_WooCommerce_Product_List') ) :

/**
 * Galleries
 *
 * @package      WordPress
 * @subpackage   Canvys
 * @since        Version 1.0
 */
class CV_WooCommerce_Product_List extends CV_Shortcode {

   /**
    * Function to create shortcode configuration
    *
    * @return void
    */
   public function __construct() {

      global $canvys;

      $products_array = array();
      foreach ( get_posts( array(
         'post_type' => 'product',
         'posts_per_page' => '-1',
         'orderby' => 'title',
         'order' => 'ASC',
      ) ) as $product ) {
         $products_array[$product->ID] = $product->post_title;
      }

      $this->config = array(

         // Handle will be used to use this shortcode
         'handle' => 'cv_woocommerce_product_list',

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
         'title' => __( 'WooCommerce Products List', 'canvys' ),

         // Icon will be used to represent this shortcode in composer/builder
         // List of available icons can be found in icons.json
         'icon' => 'tags',

         // Whether or not shortcode is self closing
         'self_closing' => true,

         // If shortcode is not self closing, specify its default content
         'default_content' => null,

         // Specify whether or not content is directly editable
         'content_editor' => false,

         // Specify whether or not the content is composed of another shortcode
         'content_element' => false,

         // Array of shortcode settings and their respective attributes
         'attributes' => array(

            new CV_Shortcode_Text_Control( 'title', array(
               'title'       => __( 'Title', 'canvys' ),
               'description' => __( 'products List title, will be displayed immediately before the products.', 'canvys' ),
            ) ),

            new CV_Shortcode_Select_Control( 'product_style', array(
               'title'         => __( 'Product Style', 'canvys' ),
               'description'   => __( 'Specify how the products should be displayed.', 'canvys' ),
               'default'       => 'default',
               'options'       => array(
                  'default'   => __( 'Default shop loop style', 'canvys' ),
                  'alternate' => __( 'Alternate with captions visible on hover', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Select_Control( 'query_type', array(
               'title'         => __( 'Query Type', 'canvys' ),
               'description'   => __( 'Specify how the products should be listed.', 'canvys' ),
               'default'       => 'recent',
               'options'       => array(
                  'recent'   => __( 'Recent products', 'canvys' ),
                  'sale'     => __( 'On sale products', 'canvys' ),
                  'featured' => __( 'Featured products', 'canvys' ),
                  'category' => __( 'From a specific category', 'canvys' ),
                  'custom'   => __( 'Select custom products', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Product_category_Select_Control( 'product_cat', array(
               'title'       => __( 'Product Category', 'canvys' ),
               'description' => __( 'Select a category to list products from.', 'canvys' ),
            ) ),

            new CV_Shortcode_Multiple_Select_Control( 'product_ids', array(
               'title'       => __( 'Selected Products', 'canvys' ),
               'description' => __( 'Select which products should be displayed (products are listed alphabetically).', 'canvys' ),
               'options'     => $products_array,
            ) ),

            new CV_Shortcode_Number_Control( 'num_products', array(
               'title'       => __( 'Maximum Number of Products', 'canvys' ),
               'description' => __( 'Specify how many products can be displayed in this list, ener a numeric vaue only, leave this blank to display as many prducts as possible.', 'canvys' ),
               'placeholder' => __( 'As many products as possible', 'canvys' ),
            ) ),

            new CV_Shortcode_Select_Control( 'list_style', array(
               'title'         => __( 'List Style', 'canvys' ),
               'description'   => __( 'Specify how this product list should be displayed.', 'canvys' ),
               'default'       => 'grid',
               'options'       => array(
                  'grid'    => __( 'Grid', 'canvys' ),
                  'carousel'  => __( 'Carousel', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Carousel_Control( 'carousel_config', array(
               'title'       => __( 'Carousel Configuration', 'canvys' ),
               'description' => __( 'Specify how this carousel should behave.', 'canvys' ),
            ) ),

            new CV_Shortcode_Select_Control( 'columns', array(
               'title'       => __( 'Number of Columns', 'canvys' ),
               'description' => __( 'Specify how many columns should be used to display this product list.', 'canvys' ),
               'default'     => '3',
               'options'     => array(
                  '2' => __( '2 Columns', 'canvys' ),
                  '3' => __( '3 Columns', 'canvys' ),
                  '4' => __( '4 Columns', 'canvys' ),
                  '5' => __( '5 Columns', 'canvys' ),
                  '6' => __( '6 Columns', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Select_Control( 'spacing', array(
               'title'         => __( 'Spacing', 'canvys' ),
               'description'   => __( 'Specify the amount of spacing that should be used to separate the columns', 'canvys' ),
               'default'       => 'normal',
               'options'       => array(
                  'none' => __( 'None', 'canvys' ),
                  '1'    => __( 'Less', 'canvys' ),
                  '2'    => __( 'Normal', 'canvys' ),
               ),
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

      <script id="cv-builder-cv_woocommerce_product_list-script">
         (function($){
            "use strict";
            $(document).on( 'cv-composer-load-cv_woocommerce_product_list', function() {
               var $modal = $('#cv-composer-absolute-container').children().last();

               $modal.find('.control-list_style select').on( 'change', function() {
                  var $this = $(this), val = $this.val();
                  switch ( val ) {
                     case 'carousel':
                        $modal.find('.control-carousel_config').fadeIn();
                        $modal.find('.control-columns, .control-spacing').hide();
                        break;
                     case 'grid':
                        $modal.find('.control-carousel_config').hide();
                        $modal.find('.control-columns, .control-spacing').fadeIn();
                        break;
                  }
               }).trigger('change');

               $modal.find('.control-query_type select').on( 'change', function() {
                  var $this = $(this), val = $this.val();
                  switch (val) {
                     case 'recent':
                     case 'sale':
                     case 'featured':
                        $modal.find('.control-product_cat').hide();
                        $modal.find('.control-product_ids').hide();
                        $modal.find('.control-num_products').fadeIn();
                        break;
                     case 'category':
                        $modal.find('.control-product_cat').fadeIn();
                        $modal.find('.control-product_ids').hide();
                        $modal.find('.control-num_products').fadeIn();
                        break;
                     case 'custom':
                        $modal.find('.control-product_cat').hide();
                        $modal.find('.control-product_ids').fadeIn();
                        $modal.find('.control-num_products').hide();
                        break;
                  }
               }).trigger('change');

            });
         })(jQuery);
      </script>

   <?php }

   /**
    * Callback function for front end shortcode styles
    *
    * @param array $sections Color scheme settings
    * @return string
    */
   public static function front_end_styles( $sections ) {

      // Caption Overlay Style
      $overlay_bg = cv_theme_setting( 'visual', 'image_hover_color', '#000000' ) ? cv_theme_setting( 'visual', 'image_hover_color', '#000000' ) : '#000000';
      $overlay_color = 0.85 > cv_hex_brightness( $overlay_bg ) ? '255,255,255' : '0,0,0';
      $overlay_inverse_color = '255,255,255' == $overlay_color ? '0,0,0' : '255,255,255';
      echo
        ".woocommerce .cv-woocommerce-product-list .product-caption {"
      . "text-shadow: {$overlay_bg} 0px 0px 2px;"
      . "background: " . cv_hex_to_rgba( $overlay_bg, 0.85 ) . ";"
      . "background: -moz-linear-gradient(top, " . cv_hex_to_rgba( $overlay_bg, 0.25 ) . " 0%, " . cv_hex_to_rgba( $overlay_bg, 0.85 ) . " 71%, " . cv_hex_to_rgba( $overlay_bg, 0.85 ) . " 100%);"
      . "background: -webkit-gradient(left top, left bottom, color-stop(0%, " . cv_hex_to_rgba( $overlay_bg, 0.25 ) . "), color-stop(71%, " . cv_hex_to_rgba( $overlay_bg, 0.85 ) . "), color-stop(100%, " . cv_hex_to_rgba( $overlay_bg, 0.85 ) . "));"
      . "background: -webkit-linear-gradient(top, " . cv_hex_to_rgba( $overlay_bg, 0.25 ) . " 0%, " . cv_hex_to_rgba( $overlay_bg, 0.85 ) . " 71%, " . cv_hex_to_rgba( $overlay_bg, 0.85 ) . " 100%);"
      . "background: -o-linear-gradient(top, " . cv_hex_to_rgba( $overlay_bg, 0.25 ) . " 0%, " . cv_hex_to_rgba( $overlay_bg, 0.85 ) . " 71%, " . cv_hex_to_rgba( $overlay_bg, 0.85 ) . " 100%);"
      . "background: -ms-linear-gradient(top, " . cv_hex_to_rgba( $overlay_bg, 0.25 ) . " 0%, " . cv_hex_to_rgba( $overlay_bg, 0.85 ) . " 71%, " . cv_hex_to_rgba( $overlay_bg, 0.85 ) . " 100%);"
      . "background: linear-gradient(to bottom, " . cv_hex_to_rgba( $overlay_bg, 0.25 ) . " 0%, " . cv_hex_to_rgba( $overlay_bg, 0.85 ) . " 71%, " . cv_hex_to_rgba( $overlay_bg, 0.85 ) . " 100%);"
      . "filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='" . $overlay_bg . "', endColorstr='" . $overlay_bg . "', GradientType=0 );"
      . "}"
      . ".woocommerce .cv-woocommerce-product-list .product-caption h3 {"
      . "color: rgb(" . $overlay_color . ");"
      . "}"
      . ".woocommerce .cv-woocommerce-product-list .product-caption .price {"
      . "color: rgb(" . $overlay_color . ") !important;"
      . "}"
      . ".woocommerce .cv-woocommerce-product-list .product-caption .price del {"
      . "color: rgba(" . $overlay_color . ",0.85) !important;"
      . "}"
      . ".woocommerce .cv-woocommerce-product-list .product-caption .star-rating,"
      . ".woocommerce .cv-woocommerce-product-list .product-caption .star-rating .star-indicator:after,"
      . ".woocommerce .cv-woocommerce-product-list .product-caption .star-rating .star-indicator:before {"
      . "color: rgb(" . $overlay_color . ") !important;"
      . "}"
      ;

      foreach ( $sections as $section => $colors ) {

         $section_tag = '.cv-section-' . $section;

         // Caption Below Style
         echo
           $section_tag . " .portfolio-outer-wrap .tile-wrap.style-below .tile-caption {"
         // . "background: {$colors['secondary_bg']};"
         // . "color: " . cv_hex_to_rgba( $colors['content'], 0.5 ) . ";"
         . "}"
         . $section_tag . " .portfolio-outer-wrap .tile-wrap.style-below .tile-caption h3 a {"
         // . "color: {$colors['headers']} !important;"
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

      global $post;

      // Create attributes array by sanitizing provided values
      extract( $this->get_sanitized_attributes( $atts ) );

      if ( 'alternate' == $product_style ) {
         $tag = '<div>'; $slide_tag = 'div';
      }

      else {
         $tag = '<ul>'; $slide_tag = 'li';
      }

      // Create the box
      $o = new CV_HTML( $tag, array(
         'class' => 'cv-woocommerce-product-list products shop-loop product-loop',
         'data-slide-tag' => $slide_tag,
      ) );

      // Apply te style class
      $o->add_class( 'is-' . $list_style );

      switch ( $list_style ) {

         case 'carousel':
            $o = cv_apply_carousel_config_attributes( $o, $carousel_config );
            break;

         case 'grid':
            $o->add_class( 'cv-grid-' . $columns );
            $o->add_class( 'has-clearfix' );
            if ( 'none' != $spacing ) $o->add_class( 'spacing-' . $spacing );
            break;

      }

      $query_args = array(
         'post_status'   => 'publish',
         'post_type'     => 'product',
      );

      $num_products = $num_products ? $num_products : '-1';

      // Get the list of product ids
      switch ( $query_type ) {

         case 'sale':
            $query_args['posts_per_page'] = $num_products;
            $product_ids_on_sale = wc_get_product_ids_on_sale();
            $product_ids_on_sale[] = 0;
            $query_args['post__in'] = $product_ids_on_sale;
            break;

         case 'featured':
            $query_args['posts_per_page'] = $num_products;
            $query_args['meta_query'][] = array(
               'key'   => '_featured',
               'value' => 'yes'
            );
            break;

         case 'category':
            $query_args['posts_per_page'] = $num_products;
            $query_args['product_cat'] = $product_cat;
            break;

         case 'custom':
            $query_args['post__in'] = explode( ',', $product_ids );
            $query_args['posts_per_page'] = $num_products;
            break;

         default:
            $query_args['posts_per_page'] = $num_products;
            break;

      }

      // Determine the correct ratio to display images with
      $catalog_image_sizes = get_option( 'shop_catalog_image_size' );
      $ratio = intval( $catalog_image_sizes['height'] ) / intval( $catalog_image_sizes['width'] ) * 100;

      // Output each product
      foreach ( get_posts( $query_args ) as $post ) : setup_postdata( $post );

         if ( 'alternate' == $product_style ) {

            $img_url = null;

            if ( has_post_thumbnail() ) {
               $id = get_post_thumbnail_id();
               if ( $img_info = wp_get_attachment_image_src( $id, 'shop_catalog' ) ) {
                  $img_url = $img_info[0];
               }
            }

            else if ( wc_placeholder_img_src() ) {
               $img_url = wc_placeholder_img_src();
            }

            if ( $img_url ) : ob_start(); ?>

               <div class="wc-loop-thumbnail bg-style-cover" style="background-image:url(<?php echo $img_url; ?>);">
                  <div style="padding-top:<?php echo $ratio; ?>%;"></div>
                  <div class="product-caption">
                     <div class="v-align-bottom">
                        <div class="cv-scaling-typography">
                           <h3><?php echo get_the_title(); ?></h3>
                           <?php woocommerce_template_single_price(); ?>
                           <?php woocommerce_template_loop_rating(); ?>
                        </div>
                     </div>
                  </div>
                  <p class="overlay-link-wrap">
                     <a class="overlay-link" href="<?php echo get_permalink(); ?>"></a>
                  </p>
               </div>

            <?php endif; $product = ob_get_clean();

            $product = '<div>' . $product . '</div>';

         }

         else {
            ob_start();
            wc_get_template_part( 'content', 'product' );
            $product = ob_get_clean();
         }

         $o->append( $product );

      endforeach; wp_reset_query();

      // Render the output
      $o = $title ? '<h2>' . $title . '</h2>' . $o : $o->render();
      return '<div class="woocommerce">' . $o . '</div>';

   }

   /**
    * Callback function for displaying the template builder module title
    *
    * @param array  $atts      Array of provided attributes
    * @param string $content   Content of shortcode
    * @return string
    */
   public function builder_module_title( $atts, $content = null ) {
      $text = isset($atts['title']) && $atts['title'] ? $atts['title'] : $this->config['title'];
      return '<i class="cv-module-icon icon-tags"></i> ' . $text;
   }

}
endif;

if ( ! class_exists('CV_Shortcode_Product_category_Select_Control') ) :

/**
 * Product categories Select Control
 *
 * @package    WordPress
 * @subpackage Canvys
 * @since      Version 1.0
 */
class CV_Shortcode_Product_category_Select_Control extends CV_Shortcode_Control {

   // Used to identify the shortcode type
   public $type = 'select';

   /**
    * Callback function for rendering only the control
    *
    * @param mixed $input The input value
    * @return string
    */
   public function render_control( $input = null ) {
      $control = new CV_HTML( '<select>', array(
         'name' => $this->handle,
         'id'   => $this->id,
      ) );

      // Add the options
      foreach ( get_terms( 'product_cat', array() ) as $category ) {
         $control->append('<option value="' . $category->slug . '" ' . selected( $input, $category->slug, 0 ) . '>' . $category->name . ' (' . $category->count . ')</option>');
      }
      return $control->render();
   }

   /**
    * Sanitize any user input
    *
    * @param mixed $input The input value
    * @return string
    */
   public function sanitize_input( $input = null ) {

      $allowed = array();

      // Create usable array of options
      foreach ( get_terms( 'product_cat', array() ) as $category ) {
         $allowed[] = $category->slug;
      }

      // Return sanitized value
      return cv_filter( $input, $allowed, $this->config['default'] );

   }

}
endif;