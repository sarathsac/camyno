<?php

global $canvys;

/**
 * Activate theme settings
 */
if ( ! class_exists('CV_Theme_Settings') ) {
   require dirname(__FILE__) . '/class-theme-settings.php';
}
if ( ! class_exists('CV_Settings_Page') ) {
   require dirname(__FILE__) . '/class-settings-page.php';
}

// Load required directories
include dirname(__FILE__) . '/pages/advanced.php';
include dirname(__FILE__) . '/pages/blog.php';
include dirname(__FILE__) . '/pages/footer.php';
include dirname(__FILE__) . '/pages/general.php';
include dirname(__FILE__) . '/pages/header.php';
include dirname(__FILE__) . '/pages/portfolio.php';
include dirname(__FILE__) . '/pages/sidebar.php';
include dirname(__FILE__) . '/pages/social.php';
include dirname(__FILE__) . '/pages/visual.php';

foreach ( get_declared_classes() as $class ) {

   // make sure class is a settings page
   if ( ! is_subclass_of( $class, 'CV_Settings_Page' ) ) {
      continue;
   }

   // Create the page object
   $page = new $class();

   // Add page object to global canvys variable
   $canvys['theme_settings_pages'][$page->config['slug']] = $page;

   // Run the initialization function
   $page->init();

}

// Create the theme options object
$canvys['theme_settings'] = new CV_Theme_Settings();