<?php

if ( ! function_exists( 'cv_get_post_format' ) ) :

/**
 * Helper function to determine the format of a post
 * Must be used within the loop
 *
 * @return string
 */
function cv_get_post_format() {
   return ! cv_theme_setting( 'blog', 'disable_formats' ) && get_post_format() ? get_post_format() : 'standard';
}
endif;

if ( ! function_exists('cv_get_attachment_caption') ) :
/**
 * Returns the caption for an attachment using its ID.
 *
 * @since Themefyre Page Builder 0.0.0
 *
 * @param int $attachment_id The ID of the image to use
 * @return string
 */
function cv_get_attachment_caption( $attachment_id ) {
   $attachment = get_post( $attachment_id );
   return $attachment->post_excerpt;
}
endif;

if ( ! function_exists('cv_get_attachment_alt') ) :
/**
 * Returns the alt text for an attachment using its ID.
 *
 * This function will first look for a custom entered alt text
 * entered by the user, if none is found the title will be used,
 * if the title is not found then the ID will be used as is, this
 * way the image will always have some kind of alt text.
 *
 * @since Themefyre Page Builder 0.0.0
 *
 * @param int $attachment_id The ID of the image to use
 * @return string
 */
function cv_get_attachment_alt( $attachment_id ) {
   if ( $alt = get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ) ) {
      return $alt;
   }
   if ( $caption = cv_get_attachment_caption( $attachment_id ) ) {
      return $caption;
   }
   if ( $title = get_the_title( $attachment_id ) ) {
      return $title;
   }
   return $attachment_id;
}
endif;

if ( ! function_exists( 'cv_get_post_format_icon' ) ) :

/**
 * Helper function to return an icon representative of the post format
 * must be used within the loop
 *
 * @return string
 */
function cv_get_post_format_icon( $additional_class = null ) {
   switch ( cv_get_post_format() ) {
      case 'aside':   return 'book'; break;
      case 'audio':   return 'note-beamed'; break;
      case 'chat':    return 'comment'; break;
      case 'gallery': return 'picture'; break;
      case 'image':   return 'picture-1'; break;
      case 'link':    return 'link'; break;
      case 'quote':   return 'quote'; break;
      case 'video':   return 'video-1'; break;
   }
   return 'forward';
}
endif;

if ( ! function_exists( 'cv_image_id_from_url' ) ) :

/**
 * Helper function to determine an images ID using its URL
 *
 * @param string $url image URL
 * @return int
 */
function cv_image_id_from_url( $url ) {

   global $wpdb;
   $id = false;

   // If there is no url, return.
   if ( ! $url )
      return false;

   // Get the upload directory paths
   $upload_dir_paths = wp_upload_dir();

   // Make sure the upload path base directory exists in the attachment URL, to verify that we're working with a media library image
   if ( false !== strpos( $url, $upload_dir_paths['baseurl'] ) ) {

      // If this is the URL of an auto-generated thumbnail, get the URL of the original image
      $url = preg_replace( '/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $url );

      // Remove the upload path base directory from the attachment URL
      $url = str_replace( $upload_dir_paths['baseurl'] . '/', '', $url );

      // Finally, run a custom database query to get the attachment ID from the modified attachment URL
      $id = $wpdb->get_var( $wpdb->prepare( "SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'", $url ) );

   }

   return $id;

}
endif;

if ( ! function_exists( 'cv_hex_to_rgba' ) ) :

/**
 * Helper function to convert a hex value to an rgba value
 *
 * @param string $hex 3 or 6 character hex code
 * @param string $alpha Alpha for generated RGBA
 * @return nothing
 */
function cv_hex_to_rgba( $hex, $alpha = 1 ) {

   $hex = str_replace('#', '', $hex);

   // Convert hex to 6 character, if needed
   if ( strlen($hex) == 3 ) {
      $hex_1 = str_repeat( substr($hex, 0, 1), 2 );
      $hex_2 = str_repeat( substr($hex, 1, 1), 2 );
      $hex_3 = str_repeat( substr($hex, 2, 1), 2 );
      $hex = $hex_1 . $hex_2 . $hex_3;
   }

   if ( 6 !== strlen($hex) ) return $hex;

   // Get RGB values
   $r = hexdec( substr($hex, 0, 2) );
   $g = hexdec( substr($hex, 2, 2) );
   $b = hexdec( substr($hex, 4, 2) );

   return 'rgba(' . $r . ',' . $g . ',' . $b . ',' . $alpha . ')';

}
endif;

if ( ! function_exists( 'cv_hex_brightness' ) ) :

/**
 * Helper function to get the brightness of a hex code
 *
 * @param string $hex 3 or 6 character hex code
 * @return nothing
 */
function cv_hex_brightness( $hex ) {

   $hex = str_replace('#', '', $hex);

   // Convert hex to 6 character, if needed
   if ( 3 == strlen($hex) ) {
      $hex_1 = str_repeat( substr($hex, 0, 1), 2 );
      $hex_2 = str_repeat( substr($hex, 1, 1), 2 );
      $hex_3 = str_repeat( substr($hex, 2, 1), 2 );
      $hex = $hex_1 . $hex_2 . $hex_3;
   }

   if ( 6 !== strlen($hex) ) return false;

   // Get RGB values
   $r = hexdec( substr($hex, 0, 2) );
   $g = hexdec( substr($hex, 2, 2) );
   $b = hexdec( substr($hex, 4, 2) );

   $rgb = array( $r, $g, $b );

   $brightness = ( max( $rgb ) + min( $rgb ) ) / 2.0;

   return round( $brightness / 255, 3 );

}
endif;

if ( ! function_exists( 'cv_saturate_hex' ) ) :

/**
 * Helper function to get the brightness of a hex code
 *
 * @param string $hex 3 or 6 character hex code
 * @return nothing
 */
function cv_saturate_hex( $hex, $saturation = 0 ) {

   if ( ! $saturation ) {
      return $hex;
   }

   $steps = $saturation * 255;
   $steps = max( -255, min(255, $steps) );

   $hex = str_replace('#', '', $hex);

   // Convert hex to 6 character, if needed
   if ( 3 == strlen($hex) ) {
      $hex_1 = str_repeat( substr($hex, 0, 1), 2 );
      $hex_2 = str_repeat( substr($hex, 1, 1), 2 );
      $hex_3 = str_repeat( substr($hex, 2, 1), 2 );
      $hex = $hex_1 . $hex_2 . $hex_3;
   }

   if ( 6 !== strlen($hex) ) return false;

   // Get RGB values
   $r = max( 0, min(255, hexdec( substr($hex, 0, 2) ) + $steps) );
   $g = max( 0, min(255, hexdec( substr($hex, 2, 2) ) + $steps) );
   $b = max( 0, min(255, hexdec( substr($hex, 4, 2) ) + $steps) );

   // Convert back to hex
   $r_hex = str_pad( dechex( $r ), 2, '0', STR_PAD_LEFT );
   $g_hex = str_pad( dechex( $g ), 2, '0', STR_PAD_LEFT );
   $b_hex = str_pad( dechex( $b ), 2, '0', STR_PAD_LEFT );

   return '#' . $r_hex . $g_hex . $b_hex;

}
endif;