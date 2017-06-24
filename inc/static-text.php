<?php

$static_text = array(

   // Overlay search bar
   'CV_OVERLAY_SEARCH_PLACEHOLDER' => __( 'Search...', 'canvys' ),

   // Widget search placeholder
   'CV_WIDGET_SEARCH_PLACEHOLDER' => __( 'Search the Site', 'canvys' ),

   // Read more button text
   'CV_READ_MORE_BUTTON_TEXT' => __( 'Continue Reading', 'canvys' ),

   // Search results page
   'CV_SEARCH_RESULTS_PLACEHOLDER' => __( 'New search...', 'canvys' ),
   'CV_SEARCH_RESULTS_BUTTON_TEXT' => __( 'Go', 'canvys' ),

   // 404 Page
   'CV_404_PAGE_ICON' => 'frown',
   'CV_404_PAGE_LINE_ONE' => __( 'Page Not Found', 'canvys' ),
   'CV_404_PAGE_LINE_TWO' => __( 'It appears the page you are looking for was not found.', 'canvys' ),
   'CV_404_PAGE_LINE_THREE' => __( 'The page you are looking for is no longer here. You can try searching for what you\'re looking for using the form below. Alternatively you can always start over from our home page.', 'canvys' ),
   'CV_404_PAGE_PLACEHOLDER' => __( 'I am looking for...', 'canvys' ),
   'CV_404_PAGE_BUTTON_TEXT' => __( 'Go', 'canvys' ),

   // Change log shortcode
   'CV_CHANGE_LOG_ADDED' => __( 'Added', 'canvys' ),
   'CV_CHANGE_LOG_UPDATED' => __( 'Updated', 'canvys' ),
   'CV_CHANGE_LOG_REMOVED' => __( 'Removed', 'canvys' ),
   'CV_CHANGE_LOG_NOTES' => __( 'Notes', 'canvys' ),
   'CV_CHANGE_LOG_NOTES_TITLE' => __( 'Release Notes', 'canvys' ),
   'CV_CHANGE_LOG_BEFORE_VERSION' => __( 'V.', 'canvys' ),

   // Contact Form Shortcode
   'CV_FORM_MESSAGE_SENT_DEFAULT' => __( 'Your message has been sent!', 'canvys' ),
   'CV_FORM_REVIEW_MESSAGE' => __( 'Please review your submission below.', 'canvys' ),

);

foreach ( $static_text as $definition => $default ) {
   if ( ! defined( $definition ) ) {
      define( $definition, $default );
   }
}