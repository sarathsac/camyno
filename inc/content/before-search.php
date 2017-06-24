<?php

global $wp_query, $canvys;

// Number of results
$num_results = $wp_query->found_posts;

$search_bar = $canvys['shortcodes']['cv_search_bar']->callback( array(
   'button_color' => 'content',
   'size' => 'small',
   'placeholder' => CV_SEARCH_RESULTS_PLACEHOLDER,
   'button_text' => CV_SEARCH_RESULTS_BUTTON_TEXT,
   'button_style' => 'filled',
   'button_color' => 'accent',
) );

echo '<div class="cv-before-search">';

echo $canvys['shortcodes']['cv_row']->callback( array(), $search_bar );

echo '</div>';