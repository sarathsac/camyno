<?php

if ( ! function_exists( 'cv_filter' ) ) :

/**
 * Function to filter multiple types of input
 *
 * @param mixed $input          The value to be filtered
 * @param mixed $sanitization   The sanitization filter to be applied
 * @param mixed $config         Any additional configuration
 * @return mixed
 */
function cv_filter( $input, $sanitization, $config = null ) {

   // Begin by trimming output;
   $input = trim($input);

   // Set output equal to null
   $o = null;

   // If an array of allowed values was provided
   if ( is_array( $sanitization ) ) {

      // Check if input is in allowed values
      if ( ! in_array( $input, $sanitization ) ) {
         $o = is_null( $config ) ? $sanitization[0] : $config;
      }

   }

   // Else apply specified sanitization
   else {

      switch ( $sanitization ) {

         /**
          * Filter for standard text fields
          */
         case 'text' :
            $o = sanitize_text_field( $input );
            break;

         /**
          * Filter for a HEX code
          */
         case 'hex' :

            if ( ! $input ) { return ''; }

            $o = str_replace( array( '#', ' ' ), '', $input );

            // Convert hex to 6 character, if needed
            if ( strlen( $o ) == 3 ) {
               $hex_1 = str_repeat( substr($o, 0, 1), 2 );
               $hex_2 = str_repeat( substr($o, 1, 1), 2 );
               $hex_3 = str_repeat( substr($o, 2, 1), 2 );
               $o = $hex_1 . $hex_2 . $hex_3;
            }

            $o = '#' . $o;

            break;

         /**
          * Filter for standard text fields
          */
         case 'shortcode_attr' :
            $o = sanitize_text_field( $input );

            // Remove any double quote caracters which would break the shortcode tag
            $o = str_replace( '"', '', $o );
            break;

         /**
          * Filter for textareas
          */
         case 'textarea' :
            $o = sanitize_text_field( $input );
            break;

         /**
          * Filter for integer values
          */
         case 'integer' :
            $o = $input ? intval( preg_replace( '/[^0-9]/', '', $input ) ) : null;
            break;

         /**
          * Filter for float values
          */
         case 'float' :
            $o = floatval( preg_replace( '/[^0-9.]/', '', $input ) );
            break;

         /**
          * Filter for float values
          */
         case 'quantity' :

            // First make sure output is numeric
            $o = floatval( preg_replace( '/[^0-9.]/', '', $input ) );

            // Check if min/max have been provided
            if ( is_array( $config ) ) {
               if ( array_key_exists( 'min', $config ) && $o < $config['min'] ) {
                  $o = $config['min'];
               }
               if ( array_key_exists( 'max', $config ) && $o > $config['max'] ) {
                  $o = $config['max'];
               }
               if ( ! in_array( 'allow_float', $config ) ) {
                  $o = intval($o);
               }
            }
            break;

         /**
          * Filter for email addresses
          */
         case 'email' :
            $o = sanitize_email( $input );
            break;

         /**
          * Filter for URL's
          */
         case 'url' :
            $o = filter_var( $input, FILTER_SANITIZE_URL );
            break;

         /**
          * Filter for image URL's
          */
         case 'image' :
            $o = filter_var( $input, FILTER_SANITIZE_URL );
            break;

         /**
          * Filter for email addresses
          */
         case 'checkbox' :
            $o = isset( $input ) && $input ? true : false;
            break;

         /**
          * Default functionality assumes sanitization supplied is a separate function
          */
         default:
            if ( function_exists( $sanitization ) ) {
               $o = call_user_func( $sanitization, $input );
            }
            break;

      }

   }

   // Return sanitized value, if it exists
   return is_null($o) ? $input : $o;

}
endif;

if ( ! function_exists( 'cv_make_string' ) ) :

/**
 * Function to convert true/false bool to 'true'/'false' string
 *
 * @param bool $input The boolean value to be converted to a string
 * @return string
 */
function cv_make_string( $input ) {

   if ( $input ) {
      return 'true';
   }

   return 'false';

}
endif;

if ( ! function_exists( 'cv_make_bool' ) ) :

/**
 * Function to convert 'true'/'false' string to true/false bool
 *
 * @param bool $input The boolean value to be converted to a string
 * @return string
 */
function cv_make_bool( $input ) {

   if ( 'true' == $input ) {
      return true;
   }

   return false;

}
endif;

if ( ! function_exists( 'cv_limit_int' ) ) :

/**
 * Function to limit the size of an integer
 *
 * @param int $input The integer to be limited
 * @param int $min The minimum value
 * @param int $max The maximum value
 * @return int
 */
function cv_limit_int( $input, $min = 0, $max = 100 ) {

   // Make sure input is numeric
   $input = cv_filter( $input, 'integer' );

   // Sanitize the value
   if ( $input < $min ) $input = $min;
   if ( $input > $max ) $input = $max;

   return $input;

}
endif;

if ( ! function_exists( 'cv_slug' ) ) :

/**
 * Function to convert a string to a usable slug
 *
 * @param bool $input The boolean value to be converted to a string
 * @return string
 */
function cv_slug( $input ) {

   // replace non letter or digits by -
   $input = preg_replace('~[^\\pL\d]+~u', '-', $input);

   // trim
   $input = trim( $input, '-' );

   // transliterate
   $input = iconv( 'utf-8', 'us-ascii//TRANSLIT', $input );

   // lowercase
   $input = strtolower( $input );

   // remove unwanted characters
   $input = preg_replace( '~[^-\w]+~', '', $input );

   if ( empty( $input ) ) {
      return 'n-a';
   }

   return $input;

}
endif;