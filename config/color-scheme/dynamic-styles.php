<?php

if ( ! function_exists( 'cv_render_color_scheme_styles' ) ) :

add_action( 'cv_render_dynamic_stylesheet', 'cv_render_color_scheme_styles', null, 1 );

/**
 * Generate dynamic color scheme styles
 *
 * @param array $sections Color scheme settings
 * @return string
 */
function cv_render_color_scheme_styles( $sections ) {

   foreach ( $sections as $section => $colors ) {

      $section_tag = '.cv-section-' . $section;

      /* Section Styles */
      echo
        $section_tag . " {"
      . "background-color: {$colors['primary_bg']};"
      . "color: {$colors['content']};"
      . "}"
      . $section_tag . ".top-both,"
      . $section_tag . ".top-border {"
      . "border-top: 1px solid {$colors['borders']};"
      . "}"
      . $section_tag . ".bottom-both,"
      . $section_tag . ".bottom-border {"
      . "border-bottom: 1px solid {$colors['borders']};"
      . "}"
      . $section_tag . ".top-arrow .cv-top-arrow:after {"
      . "border-bottom-color: {$colors['primary_bg']};"
      . "}"
      . $section_tag . ".top-arrow.top-border .cv-top-arrow:before {"
      . "border-bottom-color: {$colors['borders']};"
      . "}"
      . $section_tag . ".bottom-arrow .cv-bottom-arrow:after {"
      . "border-top-color: {$colors['primary_bg']};"
      . "}"
      . $section_tag . ".bottom-arrow.bottom-border .cv-bottom-arrow:before {"
      . "border-top-color: {$colors['borders']};"
      . "}"
      ;

      /* Text Selection */
      $rgb = 0.85 > cv_hex_brightness( $sections['header']['accent'] ) ? '255,255,255' : '0,0,0';
      echo
        $section_tag . " *::selection {"
      . "background: {$colors['accent']};"
      . "color: rgba({$rgb},0.85);"
      . "}"
      . $section_tag . " *::-moz-selection {"
      . "background: {$colors['accent']};"
      . "color: rgba({$rgb},0.85);"
      . "}"
      ;

      /* Headers */
      echo
        $section_tag . " h1,"
      . $section_tag . " h2,"
      . $section_tag . " h3,"
      . $section_tag . " h4,"
      . $section_tag . " h5,"
      . $section_tag . " h6 {"
      . "color: {$colors['headers']};"
      . "}"
      ;

      /* Strong text */
      echo
        $section_tag . " strong {"
      . "color: {$colors['headers']};"
      . "}"
      ;

      /* Links */
      echo
        $section_tag . " a {"
      . "color: {$colors['accent']};"
      . "}"
      . $section_tag . " .sidebar a:not(.button) {"
      . "color: {$colors['content']};"
      . "}"
      . $section_tag . " a:hover {"
      . "color: {$colors['focused']};"
      . "}"
      ;

   }

}
endif;