<?php

// Register the init functions
add_action('load-post.php','cv_page_settings_init');
add_action('load-post-new.php', 'cv_page_settings_init');

// Add the function to update our meta boxes
add_action('save_post', 'cv_update_page_settings');

if ( ! function_exists( 'cv_page_settings_init' ) ) :

/**
 * Initiate the page settings meta box
 *
 * @return nothing
 */
function cv_page_settings_init() {

   // Add meta boxes on the 'add_meta_boxes' hook.
   add_action('add_meta_boxes', 'cv_register_page_settings');

}
endif;