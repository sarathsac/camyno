<?php

global $canvys;

// Header Lines
$lines = null;
if ( CV_404_PAGE_ICON ) $lines .= '[cv_header_stack_line source="icon" icon="' . CV_404_PAGE_ICON . '" size_adjustment="1.4"]';
if ( CV_404_PAGE_LINE_ONE ) $lines .= '[cv_header_stack_line tag="h1" text="' . CV_404_PAGE_LINE_ONE . '" size_adjustment="1.8" weight="300"]';
if ( CV_404_PAGE_LINE_TWO ) $lines .= '[cv_header_stack_line tag="h3" text="' . CV_404_PAGE_LINE_TWO . '" size_adjustment="0.5" weight="600" opacity="0.7"]';

// Header Stack
$header_stack = $canvys['shortcodes']['cv_header_stack']->callback( array(
   'align' => 'center',
), $lines );

// Render the first section
echo cv_content_section( array(), $header_stack );

// Line three text
$column_content = '<p style="font-size:1.5em;font-weight:300;text-align: center;">' . CV_404_PAGE_LINE_THREE . '</p>';

// The spacer
$column_content .= '<div style="height:1.75em;"></div>';

// The search form
$column_content .= $canvys['shortcodes']['cv_search_bar']->callback( array(
   'button_color' => 'content',
   'size' => 'small',
   'placeholder' => CV_404_PAGE_PLACEHOLDER,
   'button_text' => CV_404_PAGE_BUTTON_TEXT,
   'button_style' => 'filled',
   'autocomplete' => 'false',
   'button_color' => 'accent',
) );

// Create the column
$column = $canvys['shortcodes']['cv_single_column']->callback( array(
   'max_width' => '50%',
), $column_content );

// Render the second section
echo cv_content_section( array(
   'color_scheme' => 'alternate',
   'border_top' => 'arrow-border',
), $column );