<?php

if ( ! class_exists('CV_Portfolio') ) :

/**
 * Portfolio
 * Class that handles the creation and configuration
 * of the portfolio shortcode
 *
 * @package      WordPress
 * @subpackage   Canvys
 * @since        Version 1.0
 */
class CV_Portfolio extends CV_Shortcode {

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
         'handle' => 'cv_portfolio',

         // Whether or not this is a shortcode composer element
         'composer_element' => true,

         // Whether or not this is a template builder element
         'builder_element' => true,

         // Used by the template builder to determine where module can be dropped
         'drop_target' => 1,

         // Used by the template builder to determine where module can have other
         // modules dropped inside of it
         'drop_zone' => false,

         // Title will be used to identify this shortcode
         'title' => __( 'Portfolio', 'canvys' ),

         // Icon will be used to represent this shortcode in composer/builder
         // List of available icons can be found in icons.json
         'icon' => 'box',

         // Whether or not shortcode is self closing
         'self_closing' => true,

         // If shortcode is not self closing, specify its default content
         'default_content' => null,

         // Specify whether or not content is directly editable
         'content_editor' => false,

         // Specify whether or not the content is composed of another shortcode
         'content_element' => false,

         // Provide an explanation of what this shortcode does
         'explanation' => __( 'This shortcode displays your complete portfolio, optionally with filters and/or pagination.', 'canvys' ),

         // Array of shortcode settings and their respective attributes
         'attributes' => array(

            new CV_Shortcode_Select_Control( 'style', array(
               'title'       => __( 'Style', 'canvys' ),
               'description' => __( 'Specify how the portfolio item tiles should be displayed.', 'canvys' ),
               'default'     => 'below',
               'options'     => array(
                  'below'   => __( 'Caption below image', 'canvys' ),
                  'overlay' => __( 'Gallery style, caption visible on hover', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Select_Control( 'ratio', array(
               'title'       => __( 'Image Size Ratio', 'canvys' ),
               'description' => __( 'Specify the ratio that should be used to dictate the image size.', 'canvys' ),
               'default'     => '1x1',
               'options'     => array(
                  '1x1'  => __( '1 X 1 (Perfect square)', 'canvys' ),
                  '16x9' => __( '16 X 9 (Similar to a YouTube Video)', 'canvys' ),
                  '4x2'  => __( '4 X 2 (Perfect rectangle)', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Select_Control( 'columns', array(
               'title'       => __( 'Number of Columns', 'canvys' ),
               'description' => __( 'Specify how many columns should be used to display your portfolio.', 'canvys' ),
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
               'title'       => __( 'Item Spacing', 'canvys' ),
               'description' => __( 'Specify the amountof visible space between portfolio items.', 'canvys' ),
               'default'     => 'normal',
               'options'     => array(
                  'normal' => __( 'Normal', 'canvys' ),
                  'less'   => __( 'Less', 'canvys' ),
                  'none'   => __( 'None', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Text_Control( 'per_page', array(
               'title'       => __( 'Portfolio Items Per Page', 'canvys' ),
               'description' => __( 'Enter the number of portfolio items to be displayed per page, enter a number only. Default is to display all items on one page.', 'canvys' ),
               'placeholder' => 'All Portfolio Items',
            ) ),

            new CV_Shortcode_Select_Control( 'categories', array(
               'title'       => __( 'Dispay Categories', 'canvys' ),
               'description' => __( 'Specify whether or not eah portfolio item should be displayed with its categories.', 'canvys' ),
               'default'     => 'true',
               'options'     => array(
                  'true'  => __( 'yes, display categories', 'canvys' ),
                  'false' => __( 'No, do not display categories', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Select_Control( 'filtered', array(
               'title'       => __( 'Filtered', 'canvys' ),
               'description' => __( 'Enable portfolio filters, filters are based on portfolio item categories.', 'canvys' ),
               'default'     => 'true',
               'options'     => array(
                  'true'  => __( 'yes, enable filtering', 'canvys' ),
                  'false' => __( 'No, disable filtering', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Select_Control( 'pagination', array(
               'title'       => __( 'Page Pagination', 'canvys' ),
               'description' => __( 'Enable pagination when applicable.', 'canvys' ),
               'default'     => 'true',
               'options'     => array(
                  'true'  => __( 'yes, enable pagination', 'canvys' ),
                  'false' => __( 'No, disable pagination', 'canvys' ),
               ),
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

      // Caption Overlay Style
      $overlay_bg = cv_theme_setting( 'visual', 'image_hover_color', '#000000' ) ? cv_theme_setting( 'visual', 'image_hover_color', '#000000' ) : '#000000';
      $overlay_color = 0.85 > cv_hex_brightness( $overlay_bg ) ? '255,255,255' : '0,0,0';
      $overlay_inverse_color = '255,255,255' == $overlay_color ? '0,0,0' : '255,255,255';
      echo
        ".portfolio-outer-wrap .tile-wrap.style-below .caption-style-overlay,"
      . ".portfolio-outer-wrap .tile-wrap.style-overlay .tile-caption-inner {"
      . "text-shadow: {$overlay_bg} 0px 0px 2px;"
      . "background: " . cv_hex_to_rgba( $overlay_bg, 0.85 ) . ";"
      . "background: -moz-linear-gradient(top, " . cv_hex_to_rgba( $overlay_bg, 0.5 ) . " 0%, " . cv_hex_to_rgba( $overlay_bg, 0.85 ) . " 71%, " . cv_hex_to_rgba( $overlay_bg, 0.85 ) . " 100%);"
      . "background: -webkit-gradient(left top, left bottom, color-stop(0%, " . cv_hex_to_rgba( $overlay_bg, 0.5 ) . "), color-stop(71%, " . cv_hex_to_rgba( $overlay_bg, 0.85 ) . "), color-stop(100%, " . cv_hex_to_rgba( $overlay_bg, 0.85 ) . "));"
      . "background: -webkit-linear-gradient(top, " . cv_hex_to_rgba( $overlay_bg, 0.5 ) . " 0%, " . cv_hex_to_rgba( $overlay_bg, 0.85 ) . " 71%, " . cv_hex_to_rgba( $overlay_bg, 0.85 ) . " 100%);"
      . "background: -o-linear-gradient(top, " . cv_hex_to_rgba( $overlay_bg, 0.5 ) . " 0%, " . cv_hex_to_rgba( $overlay_bg, 0.85 ) . " 71%, " . cv_hex_to_rgba( $overlay_bg, 0.85 ) . " 100%);"
      . "background: -ms-linear-gradient(top, " . cv_hex_to_rgba( $overlay_bg, 0.5 ) . " 0%, " . cv_hex_to_rgba( $overlay_bg, 0.85 ) . " 71%, " . cv_hex_to_rgba( $overlay_bg, 0.85 ) . " 100%);"
      . "background: linear-gradient(to bottom, " . cv_hex_to_rgba( $overlay_bg, 0.5 ) . " 0%, " . cv_hex_to_rgba( $overlay_bg, 0.85 ) . " 71%, " . cv_hex_to_rgba( $overlay_bg, 0.85 ) . " 100%);"
      . "filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='" . $overlay_bg . "', endColorstr='" . $overlay_bg . "', GradientType=0 );"
      . "}"
      . ".portfolio-outer-wrap .tile-wrap.style-overlay .tile-caption-inner h3 {"
      . "color: rgb(" . $overlay_color . ");"
      . "}"
      . ".portfolio-outer-wrap .tile-wrap.style-overlay .tile-caption-inner span {"
      . "color: rgba(" . $overlay_color . ",0.75);"
      . "}"
      . ".portfolio-outer-wrap .tile-wrap.style-below .caption-style-overlay .caption-button,"
      . ".portfolio-outer-wrap .tile-wrap.style-overlay .tile-caption-inner .caption-button {"
      . "border: 1px solid rgba(" . $overlay_color . ",0.5);"
      . "color: rgb(" . $overlay_color . ");"
      . "}"
      . ".portfolio-outer-wrap .tile-wrap.style-below .caption-style-overlay .caption-button:hover,"
      . ".portfolio-outer-wrap .tile-wrap.style-overlay .tile-caption-inner .caption-button:hover {"
      . "background: rgba(" . $overlay_inverse_color . ",0.1);"
      . "}"
      ;

      foreach ( $sections as $section => $colors ) {

         $section_tag = '.cv-section-' . $section;

         // Normal filters styling
         echo
           $section_tag . " .portfolio-outer-wrap .filter-list li:not(:last-child):after {"
         . "color: " . cv_hex_to_rgba( $colors['content'], 0.75 ) . ";"
         . "}"
         . $section_tag . " .portfolio-outer-wrap .filter-list a {"
         . "color: {$colors['content']};"
         . "}"
         . $section_tag . " .portfolio-outer-wrap .filter-list .is-active a {"
         . "color: {$colors['accent']};"
         . "}"
         ;

         // Caption Below Style
         echo
           $section_tag . " .portfolio-outer-wrap .tile-wrap.style-below .tile-caption h3 a {"
         . "color: {$colors['headers']} !important;"
         . "}"
         . $section_tag . " .portfolio-outer-wrap .tile-wrap.style-below .tile-caption span {"
         . "color: {$colors['content']} !important;"
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

      // Create attributes array by sanitizing provided values
      extract( $this->get_sanitized_attributes( $atts ) );

      // Make spacing a usable value
      switch ( $spacing ) {
         case 'normal': $spacing_num = 2; break;
         case 'less':   $spacing_num = 1; break;
         case 'none':   $spacing_num = 0; break;
      }

      $paged_query_var = is_front_page() ? 'page' : 'paged';

      $args = array(
         'posts_per_page' => $per_page ? cv_filter( $per_page, 'integer' ) : -1,
         'paged'          => get_query_var($paged_query_var) ? get_query_var($paged_query_var) : 1,
         'post_type'      => 'portfolio_item',
         'meta_key'       => '_thumbnail_id',
      );

      query_posts( $args );

      $o = '';

      if ( have_posts() ) :

         // Create animated entrance attribute
         $trigger_entrances = 'none' !== $entrance ? ' data-trigger-entrances="true"' : null;
         $o .= '<div class="portfolio-outer-wrap spacing-' . $spacing . '" ' . $trigger_entrances . '>';

         $o .= '<div class="portfolio-wrapper posts-wrapper style-even masonry-layout cv-grid-' . $columns . ' spacing-' . $spacing_num . ' has-clearfix">';

         $delay_timer = 0;
         while ( have_posts() ) : the_post();

         // Grab item categories
         $terms = get_the_terms( get_the_ID(), 'portfolio_categories' );

         // Create list of terms
         $tags_list = ''; $tags_data = '';

         // Create the list of tags
         if ( is_array( $terms ) ) {
            foreach ( $terms as $term ) {
               $tags_list .= $term->name . '||';
            }
         }
         $tags_list = trim( $tags_list, '||' );

         // Create the filters list
         if ( cv_make_bool( $filtered ) ) {
            $tags_data = $tags_list ? ' data-tags="' . str_replace( '||', ',', $tags_list) . '"' : null;
         }

         // Create post class attribute
         $post_class = ' class="' . implode( ' ', get_post_class() ) . '"';

         // grab the image information
         $img_id = get_post_thumbnail_id();

         // Create animated entrance attribute
         $entrance_data = null;
         if ( 'none' !== $entrance ) {
            $entrance_data  = ' data-entrance="' . $entrance . '"';
            if ( $delay_timer ) {
               $entrance_data .= ' data-delay="' . $delay_timer . '"';
            }
            $entrance_data .= ' data-chained="true"';
            $delay_timer += 100;
         }

         // Outer tile wrap
         $o .= '<div class="tile-wrap post-layout-wrapper style-' . $style . '"' . $tags_data . '>';
         $o .= '<article id="post-' . get_the_ID() . '"' . $post_class . $entrance_data . '>';

         // The image
         $img_info = wp_get_attachment_image_src( $img_id, 'cv_square_large' );
         $o .= '<p class="cv-scalable-' . $ratio . '">';
         $o .= '<span class="scalable-content bg-style-cover" style="background-image: url(' . $img_info[0] . ');"></span>';
         $o .= '<a class="scalable-content" href="' . get_permalink() . '"></a>';

         if ( 'below' == $style ) {
            $o .= '<span class="caption-style-overlay">';
            $o .= '<span class="v-align-middle">';
            $o .= '<span>';
            $o .= '<a class="caption-button" href="' . get_permalink() . '">' . sprintf( __( 'View %s', 'canvys' ), CV_PORTFOLIO_SINGULAR_LABEL ) . '</a>';
            $o .= '</span>';
            $o .= '</span>';
            $o .= '</span>';
         }

         $o .= '</p>';

         // The caption
         $o .= '<a class="tile-caption" href="' . get_permalink() . '">';

         if ( 'overlay' == $style ) {
            $o .= '<div class="tile-caption-inner v-align-middle">';
            $o .= '<div>';
         }

         $o .= '<h3>' . get_the_title() . '</h3>';
         $o .= '<div>';

         if ( cv_make_bool( $categories ) ) {
            $o .= '<span>' . str_replace( '||', ' &middot; ', $tags_list) . '</span>';
         }

         $o .= '</div>';

         if ( 'overlay' == $style ) {
            $o .= '</div>';
            $o .= '</div>';
         }

         $o .= '</a>';

         // Outer tile wrap
         $o .= '</article>';
         $o .= '</div>';

         endwhile;

         $o .= '</div>';

         if ( cv_make_bool( $pagination ) ) $o .= cv_pagination();

         $o .= '</div>';

      endif;

      wp_reset_query();

      return $o;

   }

}
endif;