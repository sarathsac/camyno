<?php

global $canvys;

/**
 * Activate sidebar manager
 */
if ( ! class_exists('CV_Sidebar_Manager') ) {
   require dirname(__FILE__) . '/class-sidebar-manager.php';
}

// Load the custom sidebar manager
$canvys['sidebar_manager'] = new CV_Sidebar_Manager();

// Allow shortcodes to be displayed within widgets
add_filter('widget_text', 'do_shortcode');

// Register default and custom widget areas
add_action('widgets_init', 'cv_register_widget_areas');