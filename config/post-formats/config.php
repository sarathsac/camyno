<?php

global $canvys;

/*
 * Enable support for Post Formats.
 * See http://codex.wordpress.org/Post_Formats
 */
add_theme_support( 'post-formats', array_keys( $canvys['supported_post_formats'] ) );

/**
 * Activate included page builder
 */
if ( ! class_exists('CV_Post_Format_Settings') ) {
   require dirname(__FILE__) . '/class-format-settings.php';
}

// Create the post formats object
new CV_Post_Format_Settings();

if ( ! function_exists( 'cv_get_format_meta' ) ) :

/**
 * Streamlined way to access post format meta
 * must be used within the loop
 *
 * @param string $format The specific format meta to be retrieved
 * @return mixed
 */
function cv_get_format_meta( $format = null ) {
   $format_meta = get_post_meta( get_the_ID(), '_cv_format_meta', true );
   if ( $format ) return isset( $format_meta[$format] ) ? $format_meta[$format] : null;
   return $format_meta;
}
endif;