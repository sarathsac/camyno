<?php

if ( ! function_exists( 'cv_render_WPGF_styles' ) ) :

add_action( 'cv_render_dynamic_stylesheet', 'cv_render_WPGF_styles', null, 1 );

/**
 * Generate dynamic WPGF styles
 *
 * @param array $sections Color scheme settings
 * @return string
 */
function cv_render_WPGF_styles( $sections ) {

   foreach ( $sections as $section => $colors ) {

      $section_tag = '.cv-section-' . $section;

      // general styling
      echo
        $section_tag . " .gform_wrapper .gsection,"
      . $section_tag . " .gform_wrapper .gf_page_steps,"
      . $section_tag . " .gform_wrapper .gform_page_footer {"
      . "border-color: {$colors['borders']} !important;"
      . "}"
      . $section_tag . " .gform_wrapper .gf_page_steps .gf_step_active {"
      . "color: {$colors['headers']} !important;"
      . "}"
      ;

      // Errors
      echo
        'html:not([dir="rtl"]) ' . $section_tag . " .gform_wrapper li.gfield.gfield_error.gfield_contains_required {"
      . "border-left: 2px solid {$colors['accent']} !important;"
      . "}"
      . 'html[dir="rtl"] ' . $section_tag . " .gform_wrapper li.gfield.gfield_error.gfield_contains_required {"
      . "border-right: 2px solid {$colors['accent']} !important;"
      . "}"
      . $section_tag . " .gform_wrapper .validation_error {"
      . "color: {$colors['accent']} !important;"
      . "}"
      . $section_tag . " .gform_wrapper li.gfield.gfield_error textarea,"
      . $section_tag . " .gform_wrapper li.gfield.gfield_error input[type='text'] {"
      . "border-color: {$colors['accent']} !important;"
      . "}"
      . $section_tag . " .gform_wrapper li.gfield.gfield_error .gfield_label,"
      . $section_tag . " .gform_wrapper li.gfield.gfield_error .validation_message {"
      . "color: {$colors['accent']} !important;"
      . "}"
      ;

   }

}
endif;