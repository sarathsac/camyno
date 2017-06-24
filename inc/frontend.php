<?php

if ( ! function_exists( 'cv_content_clearfix' ) ) :

add_filter( 'the_content', 'cv_content_clearfix' );

/**
 * Append clearfix to content
 *
 * @param  string $content
 * @return string
 */
function cv_content_clearfix( $content) {
   if ( '' !== trim( $content ) ) $content .= '<div class="clearfix"></div>';
   return $content;
}
endif;

if ( ! function_exists( 'cv_set_front_title' ) ) :

/**
 * Helper function to output the content for the <title> attribute
 *
 * @return nothing
 */
function cv_set_front_title() {
   $o  = get_bloginfo('name') . ' | ';
   $o .= is_front_page() ? get_bloginfo('description') : wp_title( '', false );
   return apply_filters( 'cv_title_tag', $o, wp_title('', false) );
}
endif;

if ( ! function_exists( 'cv_footer_action' ) ) :

add_action( 'wp_footer', 'cv_footer_action' );

/**
 * Helper function to output the user defined JavaScript
 *
 * @return nothing
 */
function cv_footer_action() {

   // User defined Javascript
   if ( $user_script = cv_theme_setting( 'advanced', 'js' ) ) {
      echo '<script id="cv-user-defined-javascript">' . $user_script . '</script>';
   }

   // Pageslide navigation labels
   if ( cv_is_page_slide_active() ) {
      $cv_meta = get_post_meta( get_the_ID(), '_cv_page_settings', true );
      $labels = isset( $cv_meta['page_slide_nav_labels'] ) ? $cv_meta['page_slide_nav_labels'] : '';
      echo '<script id="cv-inline-page-slide-javascript">var cv_page_slide_nav_labels = "' . $labels . '";</script>';
   }

}
endif;

if ( ! function_exists( 'cv_header_action' ) ) :

add_action( 'wp_head', 'cv_header_action' );

/**
 * Helper function to output the header meta
 *
 * @return nothing
 */
function cv_header_action() {

   // Output the dynamic stylesheet
   echo '<style id="cv-dynamic-stylesheet">';
   cv_render_dynamic_stylesheet();
   echo '</style>';

   // Ouput any user defined HTML
   echo cv_theme_setting( 'advanced', 'header' );

   // Output the inline JavaScript for instant layout calculation
   if ( ! cv_is_page_slide_active() ) {
      ?><script>

      var css = '.cv-content-section > .cv-wrap-wrapper[data-min-height="25"] { height: '+(screen.height*0.25)+'px; }'
              + '.cv-content-section > .cv-wrap-wrapper[data-min-height="50"] { height: '+(screen.height*0.50)+'px; }'
              + '.cv-content-section > .cv-wrap-wrapper[data-min-height="75"] { height: '+(screen.height*0.75)+'px; }'
              + '.cv-content-section > .cv-wrap-wrapper[data-min-height="100"] { height: '+(screen.height)+'px; }';

      var style = document.createElement('style');

      if ( style.styleSheet ) {
         style.styleSheet.cssText = css;
      }
      else {
         style.appendChild( document.createTextNode( css ) );
      }

      // Add the new style rules
      document.head.appendChild( style );

      </script><?php
   }

}
endif;

if ( ! function_exists( 'cv_parse_quicktags' ) ) :

/**
 * Helper function to output a formatted string
 *
 * @param string $string The inout string to be formatted
 * @return nothing
 */
function cv_parse_quicktags( $string ) {
   $search  = array( '(b)', '(/b)', '(i)', '(/i)', '(u)', '(/u)', '(s)', '(/s)' );
   $replace = array( '<span style="font-weight:600;">', '</span>', '<span style="font-style:italic;">', '</span>', '<span style="text-decoration:underline;">', '</span>', '<span style="text-decoration:line-through;">', '</span>' );
   return str_replace( $search, $replace, $string );
}
endif;

if ( ! function_exists( 'cv_page_slide_styles' ) ) :

add_action( 'wp_head', 'cv_page_slide_styles' );

/**
 * Helper function to output page slide styles
 *
 * @return nothing
 */
function cv_page_slide_styles() {

   if ( ! cv_is_page_slide_active() ) return;

   // Grab the page slide settings
   $cv_meta = get_post_meta( get_the_ID(), '_cv_page_settings', true );

   // Nav Base color
   $nav_bg_color = isset( $cv_meta['page_slide_nav_bg_color'] ) && $cv_meta['page_slide_nav_bg_color'] ? $cv_meta['page_slide_nav_bg_color'] : null;

   // Nav Base color
   $nav_base_color = isset( $cv_meta['page_slide_nav_base_color'] ) ? $cv_meta['page_slide_nav_base_color'] : null;

   // Nav Hover Color
   $nav_hover_color = isset( $cv_meta['page_slide_nav_hover_color'] ) && $cv_meta['page_slide_nav_hover_color'] ? $cv_meta['page_slide_nav_hover_color'] : $nav_base_color;

   // Tooltip text color
   $tooltip_color = 0.85 > cv_hex_brightness( $nav_hover_color ) ? '#fff' : '#000';?>

   <style id="cv-page-slide-styles">

      <?php if ( $nav_base_color ) : ?>

         html.full-page-slider-active #fullPage-nav {
            display: block;
         }

         <?php if ( $nav_bg_color ) : ?>
            html.full-page-slider-active #fullPage-nav {
               background: <?php echo cv_hex_to_rgba( $nav_bg_color, 0.1); ?>;
            }
         <?php endif; ?>

         html.full-page-slider-active #fullPage-nav span,
         html.full-page-slider-active .fullPage-slidesNav span {
            border-color: <?php echo $nav_base_color; ?>;
            background-color: <?php echo $nav_base_color; ?>;
         }

         html.full-page-slider-active #fullPage-nav li:hover span,
         html.full-page-slider-active .fullPage-slidesNav li:hover span {
            border-color: <?php echo $nav_hover_color; ?>;
            background-color: <?php echo $nav_hover_color; ?>;
         }

         html.full-page-slider-active .fullPage-tooltip {
            background: <?php echo $nav_hover_color; ?>;
            color: <?php echo $tooltip_color; ?>;
         }

         html.full-page-slider-active .fullPage-tooltip.right:after {
            border-left-color: <?php echo $nav_hover_color; ?>;
         }

         html.full-page-slider-active .fullPage-tooltip.left:after {
            border-right-color: <?php echo $nav_hover_color; ?>;
         }

      <?php endif; ?>

   </style>

<?php }
endif;

if ( ! function_exists( 'cv_transparent_header_styles' ) ) :

add_action( 'wp_head', 'cv_transparent_header_styles' );

/**
 * Helper function to output transparent header styles
 *
 * @return nothing
 */
function cv_transparent_header_styles() {

   global $post;

   // Make sure transparency has been enabled
   if ( ! cv_is_header_transparent() ) {
      return;
   }

   // Set up the default color
   $color = cv_theme_setting( 'header', 'transparency_color', '#555555' );
   if ( ! $color ) $color = '#555555';

   // Check if the color was overriden
   if ( isset( $post ) && get_the_ID() ) {
      $cv_meta = get_post_meta( get_the_ID(), '_cv_page_settings', true );
      if ( isset( $cv_meta['transparency'] ) && 'custom' == $cv_meta['transparency'] ) {
         $color = isset( $cv_meta['transparency_color'] ) && $cv_meta['transparency_color'] ? $cv_meta['transparency_color'] : $color;
      }
   }

   // Allow single posts to match the blog page
   if ( ( is_single() || is_archive() ) && 'post' == get_post_type() ) {
      if ( in_array( cv_theme_setting( 'blog', 'banner_behavior', 'default' ), array( 'blog_page', 'blog_page-hidden') ) ) {
         $blog_page = cv_theme_setting( 'blog', 'blog_page' );
         if ( $blog_page && 'none' != $blog_page ) {
            $cv_meta = get_post_meta( $blog_page, '_cv_page_settings', true );
            if ( isset( $cv_meta['transparency'] ) && 'custom' == $cv_meta['transparency'] ) {
               $color = isset( $cv_meta['transparency_color'] ) && $cv_meta['transparency_color'] ? $cv_meta['transparency_color'] : $color;
            }
         }
      }
   }

   // See if styles were overriden by a portfolio item
   if ( is_single() && 'portfolio_item' == get_post_type() ) {

      // Check if the transparency has been enabled
      $cv_meta = get_post_meta( get_the_ID(), '_cv_page_settings', true );
      if ( isset( $cv_meta['transparency'] ) && 'custom' == $cv_meta['transparency'] ) {
         $color = isset( $cv_meta['transparency_color'] ) && $cv_meta['transparency_color'] ? $cv_meta['transparency_color'] : $color;
      }

      // Allow portfolio items to match the portfolio page
      else if ( in_array( cv_theme_setting( 'portfolio', 'banner_behavior', 'default' ), array( 'portfolio_page', 'portfolio_page-hidden') ) ) {
         $portfolio_page = cv_theme_setting( 'portfolio', 'portfolio_page' );
         if ( $portfolio_page && 'none' != $portfolio_page ) {
            $cv_meta = get_post_meta( $portfolio_page, '_cv_page_settings', true );
            if ( isset( $cv_meta['transparency'] ) && 'custom' == $cv_meta['transparency'] ) {
               $color = isset( $cv_meta['transparency_color'] ) && $cv_meta['transparency_color'] ? $cv_meta['transparency_color'] : $color;
            }
         }
      }
   }

   // Allow the color to be modified externally
   $color = apply_filters( 'cv_header_transparency_color', $color );

   // Determine the RGB setting
   $rgb = 0.85 > cv_hex_brightness( $color ) ? '255,255,255' : '0,0,0'; ?>

   <style id="cv-header-transparency-styles">

      #header.is-transparent .header-logo .displayed-title {
         color: <?php echo $color; ?> !important;
      }
      #header.is-transparent {
         border-bottom: 1px solid transparent !important;
      }
      #header.is-transparent .primary-tools:before {
         background: <?php echo cv_hex_to_rgba( $color, 0.5 ); ?> !important;;
      }

      #header.is-transparent #header-logo {
         text-shadow: rgba(<?php echo $rgb; ?>,0.5) 0px 0px 1px;
      }
      <?php if ( cv_is_header_glassy() ) : ?>
         #header.is-transparent {
            background: rgba(<?php echo $rgb; ?>,0.075) !important;
         }
         <?php if ( cv_theme_setting( 'header', 'enable_border', true ) ) : ?>
            #header.is-transparent {
               border-bottom: 1px solid rgba(<?php echo $rgb; ?>,0.075) !important;
            }
         <?php endif; ?>
      <?php else: ?>
         /* Breakpoint: 1 */
         @media all and (max-width: 40em) {
            #header.is-transparent {
               border-bottom: 1px solid <?php echo cv_hex_to_rgba( $color, 0.5 ); ?>  !important;
            }
         }
      <?php endif; ?>

      /* Breakpoint: 1 */
      @media all and (min-width: 40em) {
         #header.is-transparent #primary-navigation {
            text-shadow: rgba(<?php echo $rgb; ?>,0.5) 0px 0px 1px;
         }
         #header.is-transparent .navigation-container > nav > a,
         #header.is-transparent .navigation-container > ul > li > a,
         #header.is-transparent .navigation-container > nav > ul > li > a {
            color: <?php echo $color; ?> !important;
         }
         #header.is-transparent .dropdown-menu > li:hover > a {
            background: transparent !important;
         }
         #header.is-transparent .primary-tools a {
            border-color: transparent !important;
         }
      }

      <?php if ( 'modern' == cv_theme_setting( 'header', 'menu_style', 'dropdown' ) ) : ?>

         /* Modern Menu Styling */
         #header.is-transparent.has-menu-tree .modern-menu > li.current_page_item:after,
         #header.is-transparent.has-menu-tree .modern-menu > li.current-menu-item:after,
         #header.is-transparent.has-menu-tree .modern-menu > li.current_page_ancestor:after,
         #header.is-transparent.has-menu-tree .modern-menu > li.current-menu-ancestor:after {
            border-left: 1px solid <?php echo cv_hex_to_rgba( $color, 0.25 ); ?> !important;
         }
         #header.is-transparent.has-menu-tree .navigation-container {
            border-bottom-color: <?php echo cv_hex_to_rgba( $color, 0.25 ); ?> !important;
         }
         #header.is-transparent .modern-menu > li.page_item_has_children > ul a,
         #header.is-transparent .modern-menu > li.menu-item-has-children > ul a,
         #header.is-transparent .modern-menu > li.current_page_ancestor > ul a,
         #header.is-transparent .modern-menu > li.current-menu-ancestor > ul a {
            color: <?php echo cv_hex_to_rgba( $color, 0.65 ); ?> !important;
         }
         #header.is-transparent .modern-menu > li.current_page_item .current_page_item a,
         #header.is-transparent .modern-menu > li.current-menu-item .current-menu-item a,
         #header.is-transparent .modern-menu > li.current_page_ancestor .current_page_item a,
         #header.is-transparent .modern-menu > li.current-menu-ancestor .current-menu-item a {
            color: <?php echo $color; ?> !important;
         }

      <?php endif; ?>

      <?php do_action( 'cv_transparent_header_styles', $color, $rgb ); ?>

   </style>

<?php }
endif;

if ( ! function_exists( 'cv_modify_body_class' ) ) :

// Apply the function
add_filter( 'body_class', 'cv_modify_body_class' );

/**
 * Helper function to modify the output of body_class
 *
 * @return nothing
 */
function cv_modify_body_class( $classes ) {

   // No JS class
   $classes[] = 'no-js';

   // Calculating class
   if ( ! cv_is_page_slide_active() ) $classes[] = 'is-calculating-layout';

   // Container width class
   $container_size = cv_theme_setting( 'visual', 'container_layout', 'wide' );
   $classes[] = 'container-layout-' . $container_size;

   // Content width class
   $classes[] = 'wrap-layout-' . cv_theme_setting( 'visual', 'wrap_layout', 'constrained-65' );

   // Menu style class
   $classes[] = 'menu-style-' . cv_theme_setting( 'header', 'menu_style', 'dropdown' );

   // Reneral responsive class
   $classes[] = cv_theme_setting( 'general', 'disable_responsive' ) ? 'not-responsive' : 'responsive';

   // Sidebars responsive class
   $classes[] = 'sidebar-behavior-' . cv_theme_setting( 'sidebar', 'responsive_behavior', 'normal' );

   // Header transparency class
   if ( cv_is_header_transparent() ) {
      $classes[] = 'header-transparency-active';
   }

   // Sticky header class
   if ( cv_is_header_sticky() ) {
      $classes[] = 'sticky-header-active';
   }

   // Add page featured image class
   if ( is_page() && has_post_thumbnail() ) {
      $classes[] = 'large-featured-image';
   }

   // Add single post type class
   if ( is_single() && 'post' == get_post_type() ) {
      $classes[] = 'post-style-' . cv_theme_setting( 'blog', 'single_type', 'standard' );
   }

   return $classes;

}
endif;

if ( ! function_exists( 'cv_html_class' ) ) :

/**
 * Helper function to output the header class
 *
 * @return nothing
 */
function cv_html_class() {

   // Core classes
   $classes = array();

   // Page Slider Active
   if ( cv_is_page_slide_active() ) {
      $classes[] = 'full-page-slider-active';
   }

   // Create output
   $classes = apply_filters( 'cv_html_class', $classes );
   echo 'class="' . implode( ' ', $classes ) . '"';

}
endif;

if ( ! function_exists( 'cv_top_header_class' ) ) :

/**
 * Helper function to output the header class
 *
 * @return nothing
 */
function cv_top_header_class() {

   // Core classes
   $core_classes = array( 'top-header', 'cv-section-header', 'has-clearfix' );

   // Header transparency
   if ( cv_is_header_transparent() ) {
      $core_classes[] = 'is-transparent';
      $core_classes[] = 'transparency-active';
   }

   // Menu Style
   $core_classes[] = 'menu-style-' . cv_theme_setting( 'header', 'menu_style', 'dropdown' );

   // menu tree class
   if ( cv_is_menu_tree_active() ) {
      $core_classes[] = 'has-menu-tree';
   }

   // Create output
   $classes = apply_filters( 'cv_top_header_class', $core_classes );
   echo 'class="' . implode( ' ', $classes ) . '"';

}
endif;

if ( ! function_exists( 'cv_get_banner_title' ) ) :

/**
 * Helper function to determine if the banner area is active
 *
 * @return nothing
 */
function cv_get_banner_title() {

   $o = '';

   // If the posts page is a static page we pull the title information from there
   if ( 'page' === get_option( 'show_on_front' ) && ( $posts_page_id = get_option( 'page_for_posts' ) ) && is_home() ) {

      // Get the current values
      $values = get_post_meta( $posts_page_id, '_cv_banner_settings', true );
      $display_title = isset( $values['display_title'] ) ? $values['display_title'] : null;
      $display_description = isset( $values['display_description'] ) ? $values['display_description'] : null;

      $title = $display_title ? $display_title : get_the_title( $posts_page_id );

      $o .= '<h3>' . $title . '</h3>';

      if ( $display_description ) {
         $o .= '<h5>' . $display_description . '</h5>';
      }

   }

   // If not we just hide the banner title altoether
   else if ( is_home() ) {

      // No banner title
      return false;

   }
   else if ( is_404() ) {

      $o .= '<h3>' . __( '404 Error', 'canvys' ) . '</h3>';

   }
   else if ( wp_attachment_is_image() ) {

      $o .= '<h3>' . get_the_title() . '</h3>';

   }
   else if ( is_single() && 'portfolio_item' == get_post_type() ) {

      // Get the current values
      $values = get_post_meta( get_the_ID(), '_cv_banner_settings', true );
      $display_title = isset( $values['display_title'] ) ? $values['display_title'] : null;
      $display_description = isset( $values['display_description'] ) ? $values['display_description'] : null;

      // Determine which title to show
      $title = $display_title ? $display_title : get_the_title();

      $o .= '<h3>' . $title . '</h3>';

      if ( $display_description ) {
         $o .= '<h5>' . $display_description . '</h5>';
      }

   }
   else if ( is_single() ) {

      $blog_page = cv_theme_setting( 'blog', 'blog_page' );
      if ( $blog_page && 'none' != $blog_page ) {

         // Get the current values
         $values = get_post_meta( $blog_page, '_cv_banner_settings', true );
         $display_title = isset( $values['display_title'] ) ? $values['display_title'] : null;
         $display_description = isset( $values['display_description'] ) ? $values['display_description'] : null;

         // Determine which title to show
         $title = $display_title ? $display_title : get_the_title( $blog_page );

         $o .= '<h3>' . $title . '</h3>';

         if ( $display_description ) {
            $o .= '<h5>' . $display_description . '</h5>';
         }
      }

   }
   else if ( is_page() ) {

      // Get the current values
      $values = get_post_meta( get_the_ID(), '_cv_banner_settings', true );
      $display_title = isset( $values['display_title'] ) ? $values['display_title'] : null;
      $display_description = isset( $values['display_description'] ) ? $values['display_description'] : null;

      $title = $display_title ? $display_title : get_the_title();

      $o .= '<h3>' . $title . '</h3>';

      if ( $display_description ) {
         $o .= '<h5>' . $display_description . '</h5>';
      }

   }
   else if ( is_category() ) {

      $o .= '<h3>' . single_cat_title( '',false ) . '</h3>';

   }
   else if ( is_day() ) {

      $o .= '<h3>' . get_the_time('F jS, Y') . '</h3>';

   }
   else if ( is_month() ) {

      $o .= '<h3>' . get_the_time('F, Y') . '</h3>';

   }
   else if ( is_year() ) {

      $o .= '<h3>' . get_the_time('Y') . '</h3>';

   }
   else if ( is_search() ) {

      global $wp_query;
      $num_results = isset( $wp_query->found_posts ) ? $wp_query->found_posts . ' ' : null;
      $o .= '<h3>' . sprintf( __( '%s Search Results For: %s', 'canvys' ), $num_results, $_GET['s'] ) . '</h3>';

   }
   else if ( is_author() ) {

      $author = ( get_query_var('author_name') ) ? get_user_by( 'slug', get_query_var('author_name') ) : get_userdata( get_query_var('author') );
      $o .= '<h3>' . $author->display_name . '</h3>';

   }
   else if ( is_tag() ) {

      $o .= '<h3>' . single_tag_title('',false) . '</h3>';

   }
   else if ( is_tax() ) {

      $term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));

      switch ($term->name) {

         case 'Aside':
         case 'Audio':
         case 'Chat':
         case 'Gallery':
         case 'Image':
         case 'Link':
         case 'Quote':
         case 'Video':
            $o .= '<h3>' . $term->name . '</h3>';
            break;

         default:
            $o .= '<h3>' . $term->name . '</h3>';
            break;

      }

   }
   else if ( is_archive() ) {

      $o .= '<h3>' . __( 'Archive', 'canvys' ) . '</h3>';

   }

   return apply_filters( 'cv_banner_title', $o );

}
endif;

if ( ! function_exists( 'cv_get_bread_crumbs' ) ) :

/**
 * Helper function to display bread crumbs
 *
 * @return nothing
 */
function cv_get_bread_crumbs() {

   if ( is_front_page() || is_404() ) {
      return false;
   }

   global $post;

   $o = '';

   // Display link to home page
   $o .= '<li><a href="' . home_url() . '">' . __( 'Home', 'canvys' ) . '</a></li>';

   // Check if the current page has parents
   if ( is_page() && $post->post_parent ) {
      foreach ( array_reverse( get_post_ancestors( $post->ID ) ) as $parent ) {
         $o .= '<li><a href="' . get_permalink( $parent ) . '">' . get_the_title( $parent ) . '</a></li>';
      }
   }

   // Check if this is the posts page
   if ( is_home() ) {
      $o .= '<li><span>' . __( 'Blog', 'canvys' ) . '</span></li>';
   }

   // Check if we are viewing an archive page
   else if ( is_archive() ) {

      $blog_page = cv_theme_setting('blog', 'blog_page');

      if ( 'none' == $blog_page ) {
         $blog_page = false;
      }

      if ( is_category() ) {
         $o .= '<li>';
         $o .= ( $blog_page ) ? '<a href="' . get_page_link( $blog_page ) . '">' . get_the_title( $blog_page ) . '</a>' : '<span>' . __( 'Blog', 'canvys' ) . '</span>';
         $o .= '</li>';
         $o .= '<li><span>' . single_cat_title('',false) . '</span></li>';
      }

      else if ( is_day() ) {
         $o .= '<li>';
         $o .= ( $blog_page ) ? '<a href="' . get_page_link( $blog_page ) . '">' . get_the_title( $blog_page ) . '</a>' : '<span>' . __( 'Blog', 'canvys' ) . '</span>';
         $o .= '</li>';
         $o .= '<li><span>' . get_the_time('F jS, Y') . '</span></li>';
      }

      else if ( is_month() ) {
         $o .= '<li>';
         $o .= ( $blog_page ) ? '<a href="' . get_page_link( $blog_page ) . '">' . get_the_title( $blog_page ) . '</a>' : '<span>' . __( 'Blog', 'canvys' ) . '</span>';
         $o .= '</li>';
         $o .= '<li><span>' . get_the_time('F, Y') . '</span></li>';
      }

      else if ( is_year() ) {
         $o .= '<li>';
         $o .= ( $blog_page ) ? '<a href="' . get_page_link( $blog_page ) . '">' . get_the_title( $blog_page ) . '</a>' : '<span>' . __( 'Blog', 'canvys' ) . '</span>';
         $o .= '</li>';
         $o .= '<li><span>' . get_the_time('Y') . '</span></li>';
      }

      else if ( is_author() ) {
         $author = (get_query_var('author_name')) ? get_user_by('slug', get_query_var('author_name')) : get_userdata(get_query_var('author'));
         $o .= '<li><span>' . __( 'Authors', 'canvys' ) . '</span></li>';
         $o .= '<li><span>' . $author->display_name . '</span></li>';
      }

      else if ( is_tag() ) {
         $o .= '<li>';
         $o .= ( $blog_page ) ? '<a href="' . get_page_link( $blog_page ) . '">' . get_the_title( $blog_page ) . '</a>' : '<span>' . __( 'Blog', 'canvys' ) . '</span>';
         $o .= '</li>';
         $o .= '<li><span>' . single_tag_title('',false) . '</span></li>';
      }

      else if ( is_tax() ) {
         $term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
         $o .= '<li><span>' . __( 'Archives', 'canvys' ) . '</span></li>';
         $o .= '<li><span>' . $term->name . '</span></li>';
      }

      else {
         $o .= '<li><span>' . __( 'Archives', 'canvys' ) . '</span></li>';
      }

   }

   else if ( is_search() ) {
      $o .= '<li><span>' . __( 'Search Results', 'canvys' ) . '</span></li>';
   }

   // Check if we are viewing a portfolio post
   else if ( is_single() && 'portfolio_item' == get_post_type() ) {

      $portfolio_page = cv_theme_setting( 'portfolio', 'portfolio_page' );

      if ( 'none' == $portfolio_page ) {
         $portfolio_page = false;
      }

      // Link to blog page
      $o .= '<li>';
      $o .= ( $portfolio_page ) ? '<a href="' . get_page_link( $portfolio_page ) . '">' . get_the_title( $portfolio_page ) . '</a>' : '<span>' . __('Portfolio', 'canvys') . '</span>';
      $o .= '</li>';
      $o .= '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
   }

   // Check if we are viewing a blog entry
   else if ( is_single() && 'post' == get_post_type() ) {

      $blog_page = cv_theme_setting( 'blog', 'blog_page' );

      if ( 'none' == $blog_page ) {
         $blog_page = false;
      }

      // Link to blog page
      $o .= '<li>';
      $o .= ( $blog_page ) ? '<a href="' . get_page_link( $blog_page ) . '">' . get_the_title( $blog_page ) . '</a>' : '<span>' . __( 'Blog', 'canvys' ) . '</span>';
      $o .= '</li>';

      // Link to first category
      $category = get_the_category();
      if ( $first_cat = $category[0] ) {
         $o .= '<li>';
         $o .= '<a href="' . get_term_link( $first_cat ) . '">' . $first_cat->name . '</a>';
         $o .= '</li>';
      }

      // Link to current post
      $o .= '<li><span>' . get_the_title() . '</a></span>';

   }

   // Display link to current page
   else if ( is_page() ) {
      $o .= '<li><span>' . get_the_title() . '</span></li>';
   }

   $o = apply_filters( 'cv_bread_crumbs', $o );

   if ( 2 > substr_count( $o, '</li>' ) ) {
      return false;
   }

   if ( cv_theme_setting( 'general', 'simple_breadcrumbs' ) ) {
      if ( 3 > substr_count( $o, '</li>' ) ) {
         return false;
      }
   }

   return $o;

}
endif;

if ( ! function_exists( 'cv_entry_featured_image' ) ) :

/**
 * Helper function to consistently display post featured image
 * must be used within the loop
 *
 * @return nothing
 */
function cv_entry_featured_image() {

   if ( ! has_post_thumbnail() ) return false;

   $id = get_post_thumbnail_id();
   $size = 'cv_featured_large';
   $link_url = get_permalink();
   // $icon = is_single() ? 'expand' : 'forward';  class="image-hover" data-icon="' . $icon . '"

   if ( is_single() ) {
      if ( cv_theme_setting( 'blog', 'featured_image_full' ) ) {
         $full_size = wp_get_attachment_image_src( $id, 'full' );
         $size = 'cv_featured_large';
         $link_url = $full_size[0];
      }
      else {
         $size = 'cv_featured_tall';
         $link_url = false;
      }
   }

   // Grab Full size url
   if ( $img_info = wp_get_attachment_image_src( $id, $size ) ) {
      echo '<div class="post-featured-image">';
      if ( $link_url ) echo '<a href="' . $link_url . '">';
      echo '<img src="' . $img_info[0] . '" alt="' . esc_attr( get_the_title() ) . '" />';
      if ( $link_url ) echo '</a>';
      echo '</div>';
   }

}
endif;

if ( ! function_exists( 'cv_get_post_author' ) ) :

/**
 * Helper function to consistently display post author
 * must be used within the loop
 *
 * @return nothing
 */
function cv_get_post_author() {

   // First create the link
   $author_link = new CV_HTML( '<a>', array(
      'href' => get_author_posts_url( get_the_author_meta( 'ID' ) ),
      'title' => sprintf( __( 'View all posts by %s', 'canvys' ), get_the_author_meta('display_name') ),
      'content' => get_the_author_meta('display_name'),
   ) );

   return sprintf( __( '<span>By</span> %s', 'canvys' ), $author_link );

}
endif;

if ( ! function_exists( 'cv_entry_meta' ) ) :

/**
 * Helper function to render an entry's meta
 * must be used within the loop
 *
 * @return nothing
 */
function cv_entry_meta( $requests = array( 'date', 'author', 'category', 'comments' ) ) {

   $disabled_meta = cv_theme_setting( 'blog', 'disabled_meta' );

   $o = null;

   foreach ( $requests as $request ) {

      if ( isset( $disabled_meta[$request] ) && $disabled_meta[$request] ) continue;

      switch ( $request ) {

         case 'date':
            if ( ! in_array( get_post_type(), array( 'page', 'portfolio_item' ) ) ) {
               $o .= '<li class="post-date">';
               $o .= '<a href="' . get_permalink() . '">' . get_the_date() . '</a>';
               $o .= '</li>';
            }
            break;

         case 'author':
            if ( is_single() ) {
               $o .= '<li class="post-author">';
               $o .= cv_get_post_author();
               $o .= '</li>';
            }
            break;

         case 'category':
            if ( $categories = get_the_category() ) {
               $o .= '<li class="post-category">';
               foreach ( $categories as $category ) {
                  $o .= '<a href="' . get_category_link( $category->term_id ) . '" title="' . esc_attr( sprintf( __( 'View all posts in %s', 'canvys' ), $category->name ) ) . '">' . $category->cat_name . '</a>';
               }
               $o .= '</li>';
            }
            break;

         case 'comments':
            $disabled_comments = cv_theme_setting( 'general', 'disabled_comments' );
            $disabled = isset( $disabled_comments[get_post_type()] ) && $disabled_comments[get_post_type()] ? true : false;
            if ( ! $disabled && comments_open() && 'page' != get_post_type() ) {
               switch ( get_comments_number() ) {
                  case 1 :  $text = '<span>' . __( 'Comment', 'canvys' ) . '</span>'; break;
                  default : $text = '<span>' . __( 'Comments', 'canvys' ) . '</span>'; break;
               }
               $o .= '<li class="post-comments">';
               $o .= '<a href="' . get_comments_link() . '">' . get_comments_number() . ' ' . $text . '</a>';
               $o .= '</li>';
            }
            break;

      }
   }

   // Display edit post link
   if ( $o && current_user_can( 'edit_post', get_the_ID() ) ) {
      $o .= '<li class="post-edit">';
      $o .= '<a href="' . get_edit_post_link() . '">' . __( 'Edit Post', 'canvys' ) . '</a>';
      $o .= '</li>';
   }

   if ( $o ) echo '<ul class="post-meta cloud-list has-clearfix">' . $o . '</ul>';

}
endif;

if ( ! function_exists( 'cv_modify_post_class' ) ) :

add_filter( 'post_class', 'cv_modify_post_class' );

/**
 * Modify output of the post_class function
 *
 * @return string
 */
function cv_modify_post_class( $classes ) {
   $classes[] = is_single() ? 'is-single' : 'not-single';
   if ( ! in_array( 'post', $classes ) ) $classes[] = 'post';
   return $classes;
}
endif;

if ( ! function_exists( 'cv_modify_excerpt_more' ) ) :

add_filter('excerpt_more', 'cv_modify_excerpt_more');

/**
 * Helper function to remove the `[...]` displayed after the excerpt
 *
 * @return bool
 */
function cv_modify_excerpt_more( $more ) {
   return false;
}
endif;

if ( ! function_exists( 'cv_pagination' ) ) :

/**
 * Helper function to display page pagination
 *
 * @return string
 */
function cv_pagination( $additional_class = null ) {

   ob_start();
   the_posts_pagination( array(
      'prev_text' => '<i class="icon-left-open"></i>',
      'next_text' => '<i class="icon-right-open"></i>',
   ) );
   $pagination = ob_get_clean();

   if ( $pagination ) {
      return '<div class="cv-pagination '.$additional_class.'">'.$pagination.'</div>';
   }

   return '';
}
endif;

if ( ! function_exists( 'cv_add_copyright' ) ) :

function cv_add_copyright( $text ) {
   if ( cv_theme_setting( 'footer', 'socket_attribution' ) ) {
      return $text;
   }
   $link  = '<a'.' href="'.'http://www.themefyre.com'.'">Themefyre</a>';
   return $text . ' - ' . sprintf( __( 'Theme by %s', 'canvys' ), $link );
}

add_filter( 'cv_socket_copyright', 'cv_add_copyright', 10 );

endif;

if ( ! function_exists( 'cv_the_meta_widget' ) ) :

/**
 * Helper function to render a widget containing the posts meta information
 *
 * @return string
 */
function cv_the_meta_widget( $additional_class = null ) {
   echo '<div class="widget has-clearfix">';
   the_meta();
   echo '</div>';
}
endif;

if ( ! function_exists( 'cv_get_post_tile' ) ) :

/**
 * Helper function to render a post tile
 * must be used within the loop
 *
 * @return string
 */
function cv_get_post_tile( $config = array() ) {

   global $post;

   $defaults = array(
      'ratio' => '1x1',
      'img_size' => 'cv_square_large',
      'hide_thumbnail' => false,
      'hide_title' => false,
   );

   extract( shortcode_atts( $defaults, $config ) );

   // Create the tile object
   $tile = new CV_HTML( '<div>', array(
      'class' => 'cv-post-tile',
   ) );

   // Apply the scaling class
   $tile->add_class( 'cv-scalable-' . $ratio );

   // Apply the format class
   $tile->add_class( 'format-' . cv_get_post_format() );

   // Create the scaling wrapper
   $scaler = new CV_HTML( '<div>', array(
      'class' => 'scalable-content',
   ) );

   // Create the caption wrapper
   $caption = new CV_HTML( '<div>', array(
      'class' => 'tile-caption',
      // 'data-max' => 50,
      // 'data-min' => 10,
   ) );

   // Check for a post thumbnail
   if ( ! $hide_thumbnail && has_post_thumbnail() ) {
      $tile->add_class( 'has-thumbnail bg-style-cover' );
      $id = get_post_thumbnail_id();
      $img_info = wp_get_attachment_image_src( $id, $img_size );
      $tile->css( 'background-image', 'url(' . $img_info[0] . ')' );
   }

   // Apply the format icon
   else {
      $icon = cv_get_post_format_icon();
      $caption->append( '<div class="format-icon icon-' . $icon . '"></div>' );
   }

   // Add the title
   switch ( cv_get_post_format() ) {

      case 'quote':
         $caption->append( '<h2 class="post-title">' . get_the_content() . '</h2>' );
         if ( ! $hide_title ) $caption->append( '<h4 class="quote-author">' . get_the_title() . '</h4>' );
         break;

      case 'aside':
         $caption->append( '<span class="post-content">' . get_the_content() . '</span>' );
         break;

      default:
         if ( ! $hide_title ) $caption->append( '<h2 class="post-title">' . get_the_title() . '</h2>' );
         break;

   }

   // Add the date
   if ( ! $hide_title ) {
      switch ( get_post_type() ) {
         case 'post':
            $caption->append( '<p class="extra-info">' . get_the_date() . '</p>' );
            break;
         case 'portfolio_item':

            // Grab item categories
            $terms = get_the_terms( get_the_ID(), 'portfolio_categories' );

            // Create list of terms
            $cats_list = '';

            // Create the list of tags
            if ( is_array( $terms ) ) {
               foreach ( $terms as $term ) {
                  $cats_list .= $term->name . ' / ';
               }
            }
            $cats_list = trim( $cats_list, ' / ' );
            $caption->append( '<p class="extra-info">' . $cats_list . '</p>' );
            break;
      }
   }

   // Add the caption to the scaler
   if ( $caption->content ) {
      $scaler->append( '<div class="v-align-middle">' . $caption . '</div>' );
   }

   // Create the overlay link
   $link = new CV_HTML( '<a>', array(
      'class' => 'tile-link',
      'href' => get_permalink(),
   ) );

   // Return the tile
   return $tile->render( $scaler . $link );

}
endif;

if ( ! function_exists( 'cv_read_more_link' ) ) :

add_filter( 'get_the_excerpt', 'cv_read_more_link', 99 );

/**
 * Helper function to render a read more button after posts in a loop
 *
 * @return string
 */
function cv_read_more_link( $excerpt ) {

   global $canvys;

   if ( is_single() || 'post' !== get_post_type() || ! CV_READ_MORE_BUTTON_TEXT ) return $excerpt;

   if ( in_array( cv_get_post_format(), array( 'quote', 'aside', 'link', ) ) ) return $excerpt;

   /*$link = new CV_HTML( '<a>', array(
      'href' => get_permalink(),
      'content' => CV_READ_MORE_BUTTON_TEXT
      'title' => sprintf( __( 'Continue reading %s', 'canvys' ), get_the_title() ),
   ) );

   return $excerpt . '<p class="cv-read-more-button">' . $link . '</p>';*/

   $config = array(
      'url' => get_permalink(),
      'text' => CV_READ_MORE_BUTTON_TEXT,
      'icon_position' => 'after',
      'icon' => 'right-open-big',
      'color' => 'accent',
      'style' => 'filled',
   );

   $config = apply_filters( 'cv_read_more_button_config', $config );

   return $excerpt . '<p class="cv-read-more-button">' . $canvys['shortcodes']['cv_button']->callback( $config ) . '</p>';

}
endif;