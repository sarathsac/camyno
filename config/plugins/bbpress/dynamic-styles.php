<?php

if ( ! function_exists( 'cv_render_bbpress_styles' ) ) :

add_action( 'cv_render_dynamic_stylesheet', 'cv_render_bbpress_styles', null, 1 );

/**
 * Generate dynamic bbpress styles
 *
 * @param array $sections Color scheme settings
 * @return string
 */
function cv_render_bbpress_styles( $sections ) {

   if ( cv_theme_setting( 'bbpress', 'hide_search' ) ) {
      echo
        " #bbpress-forums .bbp-search-form {"
      . "display: none;"
      . "}"
      ;
   }

   foreach ( $sections as $section => $colors ) {

      $section_tag = '.cv-section-' . $section;

      // Fieldsets
      echo
        $section_tag . " #bbpress-forums fieldset {"
      . "border: 1px solid {$colors['borders']};"
      . "}"
      ;

      // Forum headers
      echo
        $section_tag . " #bbpress-forums li.bbp-header,"
      . $section_tag . " #bbpress-forums li.bbp-footer,"
      . $section_tag . " #bbpress-forums .bbp-forum-header,"
      . $section_tag . " #bbpress-forums .bbp-topic-header,"
      . $section_tag . " #bbpress-forums .bbp-reply-header {"
      . "}"
      ;

      // Admin links
      echo
        $section_tag . " #bbpress-forums .bbp-admin-links {"
      . "color: " . cv_hex_to_rgba( $colors['content'], 0.5 ) . ";"
      . "}"
      . $section_tag . " #bbpress-forums .bbp-admin-links a:not(:hover) {"
      . "color: " . cv_hex_to_rgba( $colors['content'], 0.5 ) . ";"
      . "}"
      ;

      // Permalinks

      // Author IP
      echo
        $section_tag . " #bbpress-forums .bbp-author-ip {"
      . "color: " . cv_hex_to_rgba( $colors['content'], 0.75 ) . ";"
      . "}"
      ;

      // Forum lists
      echo
        $section_tag . " #bbpress-forums .bbp-topic-started-by a {"
      . "color: {$colors['content']};"
      . "}"
      ;

      // Outer Borders
      echo
        $section_tag . " #bbpress-forums ul.bbp-lead-topic,"
      . $section_tag . " #bbpress-forums ul.bbp-topics,"
      . $section_tag . " #bbpress-forums ul.bbp-forums,"
      . $section_tag . " #bbpress-forums ul.bbp-replies,"
      . $section_tag . " #bbpress-forums ul.search-results {"
      . "border-top: 1px solid {$colors['borders']};"
      . "border-bottom: 1px solid {$colors['borders']};"
      . "}"
      . $section_tag . " #bbpress-forums ul.bbp-topics .topic,"
      . $section_tag . " #bbpress-forums ul.bbp-forums .forum {"
      . "border-top: 1px solid {$colors['borders']};"
      . "}"
      . $section_tag . " #bbpress-forums .bbp-forums,"
      . $section_tag . " #bbpress-forums .bbp-topics,"
      . $section_tag . " #bbpress-forums .bbp-replies .bbp-header {"
      . "border-left: 1px solid {$colors['borders']} !important;"
      . "border-right: 1px solid {$colors['borders']} !important;"
      . "}"
      ;

      // Forum lists
      echo
        "html:not([dir='rtl']) " . $section_tag . " #bbpress-forums .bbp-forums-list {"
      . "border-left: 2px solid {$colors['borders']};"
      . "}"
      . "html[dir='rtl'] " . $section_tag . " #bbpress-forums .bbp-forums-list {"
      . "border-right: 2px solid {$colors['borders']};"
      . "}"
      ;

      // Separating borders
      echo
        $section_tag . " div.bbp-forum-header,"
      . $section_tag . " div.bbp-topic-header,"
      . $section_tag . " li.bbp-body ul.forum,"
      . $section_tag . " li.bbp-body ul.topic,"
      . $section_tag . " #bbpress-forums li.bbp-footer {"
      . "border-top: 1px solid {$colors['borders']};"
      . "}"
      ;

      // Replies header
      echo
        $section_tag . " #bbpress-forums .bbp-replies .bbp-header {"
      . "border-bottom: 1px solid {$colors['borders']} !important;"
      . "}"
      ;

      // Pagination Links
      echo
        $section_tag . " #bbpress-forums .bbp-pagination-links a,"
      . $section_tag . " #bbpress-forums .bbp-pagination-links span.dots {"
      . "border: 1px solid {$colors['borders']};"
      . "color: {$colors['content']};"
      . "}"
      . $section_tag . " #bbpress-forums .bbp-pagination-links a:hover,"
      . $section_tag . " #bbpress-forums .bbp-pagination-links span.current {"
      . "border: 1px solid {$colors['accent']};"
      . "color: {$colors['accent']};"
      . "}"
      ;

      // Replies / Topics
      echo
        $section_tag . " #bbpress-forums .bbp-body .bbp-reply-content,"
      . $section_tag . " #bbpress-forums .bbp-body .bbp-topic-content {"
      . "background: {$colors['primary_bg']};"
      . "border: 1px solid {$colors['borders']};"
      . "}"
      . $section_tag . " #bbpress-forums .bbp-body .bbp-reply-content:after,"
      . $section_tag . " #bbpress-forums .bbp-body .bbp-topic-content:after {"
      . "border-color: {$colors['primary_bg']} !important;"
      . "}"
      . $section_tag . " #bbpress-forums .bbp-body .bbp-reply-content:before,"
      . $section_tag . " #bbpress-forums .bbp-body .bbp-topic-content:before {"
      . "border-color: {$colors['borders']} !important;"
      . "}"
      ;

      // Login widget
      echo
        $section_tag . " .sidebar .bbp-login-form,"
      . $section_tag . " .sidebar .bbp-logged-in {"
      . "border: 1px solid {$colors['borders']};"
      . "}"
      . $section_tag . " .sidebar .bbp-logged-in a {"
      . "color: {$colors['secondary_content']};"
      . "}"
      ;

      // Freshness color
      echo
        $section_tag . " #bbpress-forums .bbp-body .bbp-forum-freshness a,"
      . $section_tag . " #bbpress-forums .bbp-body .bbp-topic-freshness a {"
      . "color: {$colors['content']};"
      . "}"
      ;

      // Reply form
      $rgb = 0.85 > cv_hex_brightness( $colors['accent'] ) ? '255,255,255' : '0,0,0';
      echo
        $section_tag . " #bbpress-forums .quicktags-toolbar {"
      . "background: {$colors['accent']};"
      . "}"
      . $section_tag . " #bbpress-forums .quicktags-toolbar .button {"
      . "border-color: rgba({$rgb},0.75);"
      . "color: rgba({$rgb},0.75);"
      . "}"
      . $section_tag . " #bbpress-forums .quicktags-toolbar .button:hover {"
      . "border-color: rgba({$rgb},1);"
      . "color: rgba({$rgb},1);"
      . "}"
      ;

      // User navigation
      echo
        $section_tag . " #bbpress-forums #bbp-user-navigation a {"
      . "color: {$colors['content']} !important;"
      . "}"
      . $section_tag . " #bbpress-forums #bbp-user-navigation .current a {"
      . "color: {$colors['accent']} !important;"
      . "background: {$colors['secondary_bg']} !important;"
      . "}"
      ;

      // Edit profile screen
      echo
        $section_tag . " #bbpress-forums #bbp-your-profile fieldset input,"
      . $section_tag . " #bbpress-forums #bbp-your-profile fieldset textarea {"
      . "border: 1px solid {$colors['borders']};"
      . "background: {$colors['secondary_bg']};"
      . "}"
      ;

      // Sticky topics
      echo
        "html:not([dir='rtl']) " . $section_tag . " #bbpress-forums .bbp-topics .sticky {"
      . "border-left: 1px solid {$colors['borders']};"
      . "}"
      . "html:not([dir='rtl']) " . $section_tag . " #bbpress-forums .bbp-topics .super-sticky {"
      . "border-left: 1px solid {$colors['accent']};"
      . "}"
      . "html[dir='rtl'] " . $section_tag . " #bbpress-forums .bbp-topics .sticky {"
      . "border-right: 1px solid {$colors['borders']};"
      . "}"
      . "html[dir='rtl'] " . $section_tag . " #bbpress-forums .bbp-topics .super-sticky {"
      . "border-right: 1px solid {$colors['accent']};"
      . "}"
      ;

   }

}
endif;