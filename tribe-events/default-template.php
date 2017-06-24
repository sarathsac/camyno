<?php
/**
 * Default Events Template
 *
 * @package    WordPress
 * @subpackage Canvys
 * @since      Version 1.0
 *
 */

if ( !defined('ABSPATH') ) { die('-1'); }

// Call the header
get_header();

?><div id="tribe-events-pg-template"><?php

   // Set the global sidebar layout
   $canvys['current_sidebar_layout'] = 'no-sidebar';

   $atts = array();

   ob_start();
   tribe_events_before_html();
   tribe_get_view();
   tribe_events_after_html();

   echo cv_content_section( $atts, ob_get_clean() );

?></div><?php

// Call the footer
get_footer();