<?php

if ( ! function_exists( 'cv_render_base_styles' ) ) :

add_action( 'cv_render_dynamic_stylesheet', 'cv_render_base_styles', null, 1 );

/**
 * Generate general styles
 *
 * @param array $sections Color scheme settings
 * @return string
 */
function cv_render_base_styles( $sections ) {

   /* Wide layout background */
   if ( 'free' == cv_theme_setting( 'visual', 'container_layout', 'free' ) ) {

      $body_bg_color = $sections['main']['primary_bg'];

      if ( cv_is_footer_active() ) {
         $body_bg_color = $sections['footer']['primary_bg'];
      }

      if ( cv_is_socket_active() ) {
         $body_bg_color = $sections['socket']['primary_bg'];
      }

      /* Base color */
      echo
        "body {"
      . "background: {$body_bg_color};"
      . "}"
      ;

   }

   /* Base color */
   echo
     "#body {"
   . "background: {$sections['main']['primary_bg']};"
   . "}"
   ;

   /* Additional header bar */
   echo
     "#header-additional-bar {"
   . "color: " . cv_hex_to_rgba( $sections['header']['secondary_content'], 0.75 ) . ";"
   . "background: {$sections['header']['secondary_bg']};"
   . "}"
   . "#header-additional-bar a {"
   . "color: {$sections['header']['secondary_content']};"
   . "}"
   . "#header-additional-bar a:hover {"
   . "color: {$sections['header']['headers']};"
   . "}"
   ;

   /* Header */
   echo
     "#header-marker {"
   . "background: {$sections['header']['primary_bg']};"
   . "}"
   . "#header .header-logo .displayed-title {"
   . "color: {$sections['header']['headers']};"
   . "}"
   . "#header.is-stuck:not(.sticky-menu-active) {"
   . "background: " . cv_hex_to_rgba( $sections['header']['primary_bg'], 0.975 ) . ";"
   . "}"
   . "#header .primary-menu a,"
   . "#header .primary-tools a,"
   . "#header .primary-social a {"
   . "color: {$sections['header']['content']};"
   . "}"
   . "#header .primary-tools a:hover,"
   . "#header .primary-social a:hover {"
   . "color: {$sections['header']['accent']};"
   . "}"
   . "#header .primary-tools {"
   . "border-bottom: 1px solid {$sections['header']['borders']};"
   . "background: {$sections['header']['primary_bg']};"
   . "}"
   . "#header .dropdown-menu > li:hover > a {"
   . "color: {$sections['header']['accent']};"
   . "}"
   . "#header .modern-menu > li.current_page_item > a,"
   . "#header .modern-menu > li.current-menu-item > a,"
   . "#header .modern-menu > li.current_page_ancestor > a,"
   . "#header .modern-menu > li.current-menu-ancestor > a {"
   . "color: {$sections['header']['accent']};"
   . "}"
   . "#header .modern-menu > li > a {"
   . "color: {$sections['header']['content']};"
   . "}"
   . "#header .modern-menu > li.page_item_has_children > ul a,"
   . "#header .modern-menu > li.menu-item-has-children > ul a,"
   . "#header .modern-menu > li.current_page_ancestor > ul a,"
   . "#header .modern-menu > li.current-menu-ancestor > ul a {"
   . "color: " . cv_hex_to_rgba( $sections['header']['content'], 0.75 ) . ";"
   . "}"
   . "#header .modern-menu > li.current_page_item .current_page_item a,"
   . "#header .modern-menu > li.current-menu-item .current-menu-item a,"
   . "#header .modern-menu > li.current_page_ancestor .current_page_item a,"
   . "#header .modern-menu > li.current-menu-ancestor .current-menu-item a {"
   . "color: {$sections['header']['accent']};"
   . "}"
   . "#header .modern-menu a:hover {"
   . "color: {$sections['header']['focused']};"
   . "}"
   . "#header.has-menu-tree .modern-menu > li.current_page_item:after,"
   . "#header.has-menu-tree .modern-menu > li.current-menu-item:after,"
   . "#header.has-menu-tree .modern-menu > li.current_page_ancestor:after,"
   . "#header.has-menu-tree .modern-menu > li.current-menu-ancestor:after {"
   . "border-left: 1px solid " . cv_hex_to_rgba( $sections['header']['borders'], 0.5 ) . ";"
   . "}"
   . "#header.has-menu-tree .navigation-container {"
   . "border-bottom-color: " . cv_hex_to_rgba( $sections['header']['borders'], 0.5 ) . ";"
   . "}"
   ;

   /* Header Sub Menus */
   echo
     "#header .primary-menu.dropdown-menu ul > li:first-child {"
   . "border-top: 1px solid {$sections['header']['accent']};"
   . "}"
   . "#header .primary-menu.dropdown-menu ul > li:first-child {"
   . "border-top: 1px solid {$sections['header']['accent']};"
   . "}"
   . "#header .primary-menu.dropdown-menu ul a {"
   . "border-left: 1px solid {$sections['header']['borders']};"
   . "border-right: 1px solid {$sections['header']['borders']};"
   . "color: {$sections['header']['content']} !important;"
   . "background: {$sections['header']['primary_bg']};"
   . "}"
   . "#header .primary-menu.dropdown-menu ul > li:last-child a {"
   . "border-bottom: 1px solid {$sections['header']['borders']};"
   . "}"
   . "#header .primary-menu.dropdown-menu ul li:hover > a {"
   . "color: {$sections['header']['headers']} !important;"
   . "background: {$sections['header']['secondary_bg']};"
   . "}"
   . "#header .primary-menu.dropdown-menu > .mega-menu > ul {"
   . "border: 1px solid {$sections['header']['borders']};"
   . "border-top: 1px solid {$sections['header']['accent']};"
   . "background: {$sections['header']['primary_bg']};"
   . "}"
   . "#header .primary-menu.dropdown-menu > .mega-menu li.title > a {"
   . "color: {$sections['header']['headers']} !important;"
   . "}"
   . "#header .primary-menu.dropdown-menu > .mega-menu > ul > li:not(.title):hover > a:not(:hover) {"
   . "color: {$sections['header']['content']} !important;"
   . "}"
   . "#header .primary-menu.dropdown-menu > .mega-menu > ul > li {"
   . "border-right: 1px solid " . cv_hex_to_rgba( $sections['header']['borders'], 0.5 ) . " !important;"
   . "}"
   ;

   /* Header Border */
   $header_border_color = cv_theme_setting( 'header', 'enable_border', true ) ? $sections['header']['borders'] : $sections['header']['primary_bg'];
   echo
     "#header {"
   . "border-bottom: 1px solid  {$header_border_color};"
   . "}"
   ;

   if ( cv_theme_setting( 'header', 'enable_border', true ) ) {
      echo
        "#header:not(.sticky-menu-active) .primary-menu.dropdown-menu > li ul {"
      . "margin-top: -1px !important;"
      . "}"
      ;
   }

   /* Header Drop Shadow */
   if ( cv_theme_setting( 'header', 'enable_shadow', true ) ) {
      echo
        "#header:not(.is-transparent) {"
      . "box-shadow: rgba(0,0,0,0.05) 0 4px 2px -2px;"
      . "}"
      ;
   }

   // Banner - Default color scheme
   echo
     "#top-banner.style-source-main {"
   . "background: {$sections['main']['primary_bg']};"
   . "}"
   . "#top-banner.style-source-main:not(.has-custom-bg) {"
   . "border-bottom: 1px solid {$sections['main']['borders']};"
   . "}"
   . "#top-banner.style-source-main .banner-title h3 {"
   . "color: {$sections['main']['headers']};"
   . "}"
   . "#top-banner.style-source-main .banner-title h5 {"
   . "color: {$sections['main']['secondary_content']};"
   . "}"
   . "#top-banner.style-source-main .bread-crumbs {"
   . "color: {$sections['main']['content']};"
   . "}"
   . "#top-banner.style-source-main .bread-crumbs a,"
   . "#top-banner.style-source-main .bread-crumbs span {"
   . "color: {$sections['main']['content']};"
   . "}"
   ;

   /* Socket Area */
   echo
     "#socket .socket-menu a,"
   . "#socket.layout-inline .socket-social a {"
   . "color: {$sections['socket']['accent']};"
   . "}"
   . "#socket.layout-centered .socket-social a {"
   . "background: {$sections['socket']['secondary_bg']};"
   . "color: {$sections['socket']['secondary_content']};"
   . "}"
   . "#socket .socket-menu .current-menu-item a,"
   . "#socket .socket-menu a:hover,"
   . "#socket .cv-social-profiles a:hover {"
   . "color: {$sections['socket']['focused']};"
   . "}"
   ;

   /* Fullscreen Overlays */
   echo
     ".cv-fullscreen-overlay,"
   . ".cv-fullscreen-overlay .close-button {"
   . "background: " . cv_theme_setting( 'visual', 'overlay_color', '#2EBF9D' ) . ";"
   . "}"
   ;

   // Image hover
   $overlay_bg = cv_theme_setting( 'visual', 'image_hover_color', '#000000' ) ? cv_theme_setting( 'visual', 'image_hover_color', '#000000' ) : '#000000';
   $overlay_color = 0.85 > cv_hex_brightness( $overlay_bg ) ? '255,255,255' : '0,0,0';
   echo
     " .image-hover-bg,"
   . " .image-hover:before {"
   . "background: " . cv_hex_to_rgba( $overlay_bg, 0.75 ) . ";"
   . "background: -moz-linear-gradient(top, " . cv_hex_to_rgba( $overlay_bg, 0.25 ) . " 0%, " . cv_hex_to_rgba( $overlay_bg, 0.75 ) . " 71%, " . cv_hex_to_rgba( $overlay_bg, 0.75 ) . " 100%);"
   . "background: -webkit-gradient(left top, left bottom, color-stop(0%, " . cv_hex_to_rgba( $overlay_bg, 0.25 ) . "), color-stop(71%, " . cv_hex_to_rgba( $overlay_bg, 0.75 ) . "), color-stop(100%, " . cv_hex_to_rgba( $overlay_bg, 0.75 ) . "));"
   . "background: -webkit-linear-gradient(top, " . cv_hex_to_rgba( $overlay_bg, 0.25 ) . " 0%, " . cv_hex_to_rgba( $overlay_bg, 0.75 ) . " 71%, " . cv_hex_to_rgba( $overlay_bg, 0.75 ) . " 100%);"
   . "background: -o-linear-gradient(top, " . cv_hex_to_rgba( $overlay_bg, 0.25 ) . " 0%, " . cv_hex_to_rgba( $overlay_bg, 0.75 ) . " 71%, " . cv_hex_to_rgba( $overlay_bg, 0.75 ) . " 100%);"
   . "background: -ms-linear-gradient(top, " . cv_hex_to_rgba( $overlay_bg, 0.25 ) . " 0%, " . cv_hex_to_rgba( $overlay_bg, 0.75 ) . " 71%, " . cv_hex_to_rgba( $overlay_bg, 0.75 ) . " 100%);"
   . "background: linear-gradient(to bottom, " . cv_hex_to_rgba( $overlay_bg, 0.25 ) . " 0%, " . cv_hex_to_rgba( $overlay_bg, 0.75 ) . " 71%, " . cv_hex_to_rgba( $overlay_bg, 0.75 ) . " 100%);"
   . "filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='" . $overlay_bg . "', endColorstr='" . $overlay_bg . "', GradientType=0 );"
   . "}"
   . " .image-hover-color,"
   . " .image-hover:after {"
   . "color: rgb(" . $overlay_color . ");"
   . "}"
   ;

   // Floating anchor background color
   echo
     "#cv-floating-anchor {"
   . "background-color: " . cv_theme_setting( 'general', 'floating_anchor_color', '#000000' ) . ";"
   . "}"
   ;

   // Search results page
   echo
     ".posts-wrapper.style-search .search-result {"
   // . "border-bottom: 1px solid " . cv_hex_to_rgba( $sections['main']['borders'], 0.5 ) . ";"
   . "}"
   . ".posts-wrapper.style-search .search-result .result-meta a {"
   . "color: {$sections['main']['content']};"
   . "}"
   ;

   // Footer Bread Crumbs
   if ( cv_is_footer_crumbs_active() ) :
      $footer_trail_source = cv_is_footer_active() ? 'footer' : 'socket';
      echo
        "#footer-bread-crumbs {"
      . "color: {$sections[$footer_trail_source]['content']};"
      . "background: {$sections[$footer_trail_source]['primary_bg']};"
      . "border-bottom: 1px solid {$sections[$footer_trail_source]['borders']};"
      . "}"
      . "#footer-bread-crumbs li a,"
      . "#footer-bread-crumbs li span {"
      . "color: {$sections[$footer_trail_source]['content']};"
      . "}"
      . "#footer-bread-crumbs li a:hover {"
      . "color: {$sections[$footer_trail_source]['headers']};"
      . "}"
      ;
      if ( ! cv_theme_setting( 'general', 'disable_responsive' ) ) {
         echo
           "/* Breakpoint: 1 */"
         . "@media all and (min-width: 40em) {"
         ;
      }
      echo
        "#footer-bread-crumbs li a:hover {"
      . "background: {$sections[$footer_trail_source]['secondary_bg']};"
      . "}"
      . "html:not([dir='rtl']) #footer-bread-crumbs li a:before,"
      . "html:not([dir='rtl']) #footer-bread-crumbs li span:before {"
      . "border-left-color: {$sections[$footer_trail_source]['borders']} !important;"
      . "}"
      . "html[dir='rtl'] #footer-bread-crumbs li a:before,"
      . "html[dir='rtl'] #footer-bread-crumbs li span:before {"
      . "border-right-color: {$sections[$footer_trail_source]['borders']} !important;"
      . "}"
      . "html:not([dir='rtl']) #footer-bread-crumbs li a:after,"
      . "html:not([dir='rtl']) #footer-bread-crumbs li span:after {"
      . "border-left-color: {$sections[$footer_trail_source]['primary_bg']} !important;"
      . "}"
      . "html[dir='rtl'] #footer-bread-crumbs li a:after,"
      . "html[dir='rtl'] #footer-bread-crumbs li span:after {"
      . "border-right-color: {$sections[$footer_trail_source]['primary_bg']} !important;"
      . "}"
      . "html:not([dir='rtl']) #footer-bread-crumbs li:not(:first-child) a:hover:after {"
      . "border-left-color: {$sections[$footer_trail_source]['secondary_bg']} !important;"
      . "}"
      . "html[dir='rtl'] #footer-bread-crumbs li:not(:first-child) a:hover:after {"
      . "border-right-color: {$sections[$footer_trail_source]['secondary_bg']} !important;"
      . "}"
      ;
      if ( ! cv_theme_setting( 'general', 'disable_responsive' ) ) {
         echo "}";
      }
   endif;

   // Footer Widgets
   echo
   "#footer .widget li a {"
   . "color: {$sections['footer']['accent']};"
   . "}"
   . "#footer .widget li a:hover {"
   . "color: {$sections['footer']['focused']};"
   . "}"
   . "#footer .widget li ul {"
   . "border-left: 1px solid {$sections['footer']['borders']};"
   . "}"
   ;

   foreach ( $sections as $section => $colors ) {

      $section_tag = '.cv-section-' . $section;

      // WP Captions
      echo
        $section_tag . " .wp-caption {"
      . "border: 1px solid {$colors['borders']};"
      . "background: {$colors['secondary_bg']};"
      . "}"
      . $section_tag . " .wp-caption-text {"
      . "color: {$colors['secondary_content']};"
      . "}"
      ;

      // Tables
      echo
        $section_tag . " table {"
      . "border: 1px solid {$colors['borders']};"
      . "}"
      . $section_tag . " table tr {"
      . "border-bottom: 1px solid {$colors['borders']};"
      . "}"
      . $section_tag . " table th {"
      . "color: {$colors['headers']};"
      . "}"
      . $section_tag . " table caption {"
      . "color: {$colors['headers']};"
      . "}"
      . $section_tag . " table th,"
      . $section_tag . " table td {"
      . "border-right: 1px solid {$colors['borders']};"
      . "}"
      ;

      // Blockquotes
      echo
        $section_tag . " blockquote {"
      . "border: 1px dotted {$colors['borders']};"
      . "}"
      . "html:not([dir='rtl']) " . $section_tag . " blockquote {"
      . "border-left: 2px solid {$colors['accent']};"
      . "}"
      . "html[dir='rtl'] " . $section_tag . " blockquote {"
      . "border-right: 2px solid {$colors['accent']};"
      . "}"
      ;

      // Preformatted text
      echo
        $section_tag . " pre {"
      . "background: {$colors['secondary_bg']};"
      . "color: {$colors['secondary_content']};"
      . "}"
      . "html:not([dir='rtl']) " . $section_tag . " pre {"
      . "border-left: 2px solid {$colors['accent']};"
      . "}"
      . "html[dir='rtl'] " . $section_tag . " pre {"
      . "border-right: 2px solid {$colors['accent']};"
      . "}"
      ;

      // Blog
      echo
        $section_tag . " .post .post-title a {"
      . "color: {$colors['headers']};"
      . "}"
      . $section_tag . " .post .post-meta,"
      . $section_tag . " .post .post-meta a {"
      . "color: {$colors['headers']};"
      . "}"
      . $section_tag . " .post.style-standard .post-meta a:hover {"
      . "color: {$colors['accent']};"
      . "}"
      . $section_tag . " .post.style-standard .post-featured-box {"
      . "background: {$colors['secondary_bg']};"
      . "}"
      . "html:not([dir=\"rtl\"]) " . $section_tag . " .post.style-standard .post-featured-box {"
      . "border-left: 2px solid {$colors['accent']};"
      . "}"
      . "html[dir=\"rtl\"] " . $section_tag . " .post.style-standard .post-featured-box {"
      . "border-right: 2px solid {$colors['accent']};"
      . "}"
      . $section_tag . " .post.style-standard .post-featured-box .primary-content a,"
      . $section_tag . " .post.style-standard .post-featured-box:after {"
      . "color: {$colors['headers']};"
      . "}"
      . $section_tag . " .post.style-standard .post-featured-box .secondary-content {"
      . "color: {$colors['secondary_content']};"
      . "}"
      . $section_tag . " .post.style-modern .post-side-date a .day {"
      . "color: {$colors['headers']};"
      . "}"
      . $section_tag . " .post.style-modern .post-side-date a .month {"
      . "color: {$colors['headers']};"
      . "}"
      ;

      // Masonry Blog
      echo
        $section_tag . " .posts-wrapper.style-masonry .post {"
      . "border: 1px solid {$colors['borders']};"
      . "}"
      . $section_tag . " .posts-wrapper.style-masonry .post.sticky {"
      . "border: 1px solid {$colors['accent']};"
      . "}"
      . $section_tag . " .posts-wrapper.style-masonry .post-featured-box {"
      . "background: {$colors['secondary_bg']};"
      . "color: {$colors['secondary_content']};"
      . "}"
      . $section_tag . " .post.style-masonry .post-meta:not(:last-child) {"
      . "border-bottom: 1px solid {$colors['borders']};"
      . "}"
      . $section_tag . " .post.style-masonry .post-masonry-meta {"
      . "border-top: 1px solid {$colors['borders']};"
      . "}"
      . $section_tag . " .post.style-masonry .post-masonry-meta a {"
      . "color: " . cv_hex_to_rgba( $colors['content'], 0.65 ) . ";"
      . "}"
      . $section_tag . " .post.style-masonry .post-masonry-meta a:hover {"
      . "color: " . cv_hex_to_rgba( $colors['content'], 1 ) . ";"
      . "}"
      . $section_tag . " .post.style-masonry .post-featured-box .primary-content a {"
      . "color: {$colors['headers']};"
      . "}"
      ;

      // Boxed Blog
      echo
        $section_tag . " .post.style-boxed .post-box {"
      . "background: {$colors['secondary_bg']};"
      . "color: {$colors['secondary_content']};"
      . "}"
      ;

      // Minimal blog
      echo
        $section_tag . " .post.style-minimal:not(:last-child) {"
      . "border-bottom: 1px solid {$colors['borders']};"
      . "}"
      . $section_tag . " .post.style-minimal.sticky {"
      . "background: {$colors['secondary_bg']};"
      . "}"
      . $section_tag . " .post.style-minimal .post-meta a {"
      . "color: " . cv_hex_to_rgba( $colors['content'], 0.75 ) . ";"
      . "}"
      . $section_tag . " .post.style-minimal .post-meta a:hover {"
      . "color: {$colors['accent']};"
      . "}"
      ;

      // Post Tags
      echo
        $section_tag . " .post-tags a {"
      . "border: 1px solid {$colors['secondary_bg']} !important;"
      . "background: {$colors['secondary_bg']} !important;"
      . "color: {$colors['secondary_content']} !important;"
      . "}"
      . $section_tag . " .post-tags a:hover {"
      . "border: 1px solid {$colors['accent']} !important;"
      . "background: {$colors['primary_bg']} !important;"
      . "color: {$colors['accent']} !important;"
      . "}"
      ;

      // Related Posts
      echo
        $section_tag . " .related-posts .title {"
      . "background: {$colors['secondary_bg']} !important;"
      . "color: {$colors['secondary_content']} !important;"
      . "}"
      ;

      // Single Post Styles
      echo
        $section_tag . " .below-single-post {"
      . "border-top: 2px solid {$colors['accent']};"
      . "}"
      ;

      // Comments
      echo
        $section_tag . " #comments .comment-container,"
      . $section_tag . " ol ul li .comment {"
      . "background: {$colors['secondary_bg']};"
      . "}"
      . $section_tag . " #comments .author-note {"
      . "color: " . cv_hex_to_rgba( $colors['headers'], 0.5 ) . ";"
      . "}"
      . $section_tag . " #comments .comment-meta a {"
      . "color: " . cv_hex_to_rgba( $colors['secondary_content'], 0.75 ) . ";"
      . "}"
      . $section_tag . " #comments .comment-meta .comment-edit-link {"
      . "color: {$colors['accent']};"
      . "}"
      . $section_tag . " #comments .comment-reply-link:not(:hover) {"
      . "color: {$colors['content']};"
      . "}"
      . $section_tag . " #comments .comment #respond {"
      . "background: {$colors['secondary_bg']};"
      . "color: {$colors['secondary_content']};"
      . "border-top: 1px solid {$colors['borders']};"
      . "}"
      . $section_tag . " #comments .comment #respond input[type='text'],"
      . $section_tag . " #comments .comment #respond select,"
      . $section_tag . " #comments .comment #respond textarea {"
      . "background: {$colors['primary_bg']};"
      . "color: {$colors['content']};"
      . "}"
      . $section_tag . " #comments .comment-page-nav {"
      . "background: {$colors['primary_bg']};"
      . "}"
      . $section_tag . " #comments .comment-page-nav a:not(:hover) {"
      . "color: {$colors['content']};"
      . "}"
      . $section_tag . " #comments .comment-edit-link {"
      . "color: {$colors['content']};"
      . "}"
      ;

      // Share Buttons
      echo
        $section_tag . " .share-buttons a {"
      . "border: 1px solid {$colors['secondary_bg']};"
      . "background: {$colors['secondary_bg']};"
      . "}"
      . $section_tag . " .share-buttons a:not(:hover) {"
      . "color: " . cv_hex_to_rgba( $colors['content'], 0.75 ) . " !important;"
      . "}"
      . $section_tag . " .share-buttons a:hover {"
      . "border: 1px solid {$colors['borders']};"
      . "background: {$colors['primary_bg']};"
      . "}"
      ;

      // Pagination
      $rgb = 0.85 > cv_hex_brightness( $colors['accent'] ) ? '255,255,255' : '0,0,0';
      echo
        $section_tag . " .cv-pagination a,"
      . $section_tag . " .cv-pagination span {"
      . "color: " . cv_hex_to_rgba( $colors['content'], 0.5 ) . ";"
      . "border: 1px solid " . cv_hex_to_rgba( $colors['content'], 0.25 ) . ";"
      . "}"
      . $section_tag . " .cv-pagination a:hover {"
      . "color: {$colors['accent']};"
      . "border: 1px solid {$colors['accent']};"
      . "}"
      . $section_tag . " .cv-pagination .current {"
      . "background: {$colors['accent']};"
      . "color: rgb({$rgb});"
      . "border: 1px solid {$colors['accent']};"
      . "}"
      ;

      // Content Section Widgets
      echo
        $section_tag . " .content-section-sidebar .widget li {"
      // . "border-bottom: 1px solid " . cv_hex_to_rgba( $colors['borders'], 0.5 ) . ";"
      . "}"
      . $section_tag . " .content-section-sidebar .widget li ul,"
      . $section_tag . " .content-section-sidebar .widget li li:not(:first-child) {"
      // . "border-top: 1px solid " . cv_hex_to_rgba( $colors['borders'], 0.5 ) . " !important;"
      . "}"
      . $section_tag . " .content-section-sidebar .widget li a {"
      . "color: {$colors['accent']};"
      . "}"
      . $section_tag . " .content-section-sidebar .widget li a:hover {"
      . "color: {$colors['focused']};"
      . "}"
      ;

      // Menu widget
      echo
        $section_tag . " .sidebar .widget .menu .current-menu-item > a {"
      . "color: {$colors['headers']} !important;"
      . "}"
      ;

      // Custom Recent Posts Widget
      echo
        $section_tag . " .sidebar .cv-recent-posts .entry-thumbnail:not([style]) {"
      . "color: " . cv_hex_to_rgba( $colors['content'], 0.75 ) . ";"
      . "border: 1px solid {$colors['borders']};"
      . "}"
      ;

      // Tag Cloud Widget
      $button_hover_color = 0.85 > cv_hex_brightness( $colors['accent'] ) ? '255,255,255' : '0,0,0';
      echo
        $section_tag . " .sidebar .tagcloud a {"
      . "color: {$colors['content']};"
      . "background: {$colors['secondary_bg']};"
      . "}"
      . $section_tag . " .sidebar .tagcloud a:hover {"
      . "color: #fff;"
      . "background: {$colors['accent']};"
      . "}"
      ;

      // Form Fields
      echo
        $section_tag . " input,"
      . $section_tag . " select,"
      . $section_tag . " textarea {"
      . "color: {$colors['secondary_content']};"
      . "background: {$colors['secondary_bg']};"
      . "border: 1px solid {$colors['borders']};"
      . "}"
      . $section_tag . " input::-webkit-input-placeholder {"
      . "color: " . cv_hex_to_rgba( $colors['secondary_content'], 0.85 ) . ";"
      . "}"
      . $section_tag . " input:-moz-placeholder {"
      . "color: " . cv_hex_to_rgba( $colors['secondary_content'], 0.85 ) . ";"
      . "}"
      . $section_tag . " input::-moz-placeholder {"
      . "color: " . cv_hex_to_rgba( $colors['secondary_content'], 0.85 ) . ";"
      . "}"
      . $section_tag . " input:-ms-placeholder {"
      . "color: " . cv_hex_to_rgba( $colors['secondary_content'], 0.85 ) . ";"
      . "}"
      . $section_tag . " .cv-select-box:after {"
      . "color: " . cv_hex_to_rgba( $colors['secondary_content'], 0.75 ) . ";"
      . "background: {$colors['secondary_bg']};"
      . "}"
      . $section_tag . " .cv-select-box:hover:after {"
      . "color: {$colors['secondary_content']};"
      . "}"
      ;

      // Fieldsets
      echo
        $section_tag . " fieldset {"
      . "border: 1px solid {$colors['borders']};"
      . "}"
      ;

      // Slick Slider
      echo
        $section_tag . " .cv-carousel.slick-slider.controls-under .slick-next:before,"
      . $section_tag . " .cv-carousel.slick-slider.controls-under .slick-prev:before {"
      . "color: {$colors['content']} !important;"
      . "border: 1px solid {$colors['borders']} !important;"
      . "}"
      . $section_tag . " .cv-carousel.slick-slider.controls-under .slick-next:not(.slick-disabled):hover:before,"
      . $section_tag . " .cv-carousel.slick-slider.controls-under .slick-prev:not(.slick-disabled):hover:before {"
      . "color: {$colors['focused']} !important;"
      . "border: 1px solid {$colors['focused']} !important;"
      . "}"
      . $section_tag . " .cv-carousel.slick-slider.controls-under .slick-dots li button {"
      . "border: 1px solid {$colors['content']};"
      . "background: {$colors['secondary_bg']};"
      . "}"
      . $section_tag . " .cv-carousel.slick-slider.controls-under .slick-dots li button:hover,"
      . $section_tag . " .cv-carousel.slick-slider.controls-under .slick-dots li.slick-active button {"
      . "border: 1px solid {$colors['focused']};"
      . "}"
      ;

      // Post tiles
      echo
        $section_tag . " .cv-post-tile {"
      . "background-color: {$colors['secondary_bg']};"
      . "}"
      . $section_tag . " .cv-post-tile:not(.has-thumbnail) {"
      . "box-shadow: inset {$colors['borders']} 0 0 0px 1px;"
      . "}"
      . $section_tag . " .cv-post-tile:not(.has-thumbnail) .tile-caption {"
      . "text-shadow: {$colors['secondary_bg']} 0 0 5px;"
      . "}"
      . $section_tag . " .cv-post-tile:not(.has-thumbnail) .tile-caption * {"
      . "color: {$colors['secondary_content']} !important;"
      . "}"
      . $section_tag . " .cv-post-tile:not(.has-thumbnail) .format-icon {"
      . "color: " . cv_hex_to_rgba( $colors['secondary_content'], 0.1 ) . " !important;"
      . "}"
      ;

   }

}
endif;