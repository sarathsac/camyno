<?php

if ( ! function_exists( 'cv_get_shortcode_regex' ) ) :

/**
 * Modified version of get_shortcode_regex to ensure correct regex is returned
 *
 * The regular expression combines the shortcode tags in the regular expression
 * in a regex class.
 *
 * The regular expression contains 6 different sub matches to help with parsing.
 *
 * 1 - An extra [ to allow for escaping shortcodes with double [[]]
 * 2 - The shortcode name
 * 3 - The shortcode argument list
 * 4 - The self closing /
 * 5 - The content of a shortcode when it wraps some content.
 * 6 - An extra ] to allow for escaping shortcodes with double [[]]
 *
 * @return string
 */
function cv_get_shortcode_regex() {

   global $shortcode_tags, $canvys;

   // Already registered shortcode tags
   $registered_tagnames = array_keys( $shortcode_tags );

   // All tags from included shortcodes
   $canvys_tagnames = array_keys( $canvys['shortcodes'] );

   // Merge tagnames and make sure there are no duplicates
   $all_tagnames = array_unique( array_merge( $registered_tagnames, $canvys_tagnames ) );

   // Create the regex
   $tagregexp = join( '|', array_map('preg_quote', $all_tagnames) );

   // WARNING! Do not change this regex without changing do_shortcode_tag() and strip_shortcode_tag()
   // Also, see shortcode_unautop() and shortcode.js.
   return
        '\\['                              // Opening bracket
      . '(\\[?)'                           // 1: Optional second opening bracket for escaping shortcodes: [[tag]]
      . "($tagregexp)"                     // 2: Shortcode name
      . '(?![\\w-])'                       // Not followed by word character or hyphen
      . '('                                // 3: Unroll the loop: Inside the opening shortcode tag
      .     '[^\\]\\/]*'                   // Not a closing bracket or forward slash
      .     '(?:'
      .         '\\/(?!\\])'               // A forward slash not followed by a closing bracket
      .         '[^\\]\\/]*'               // Not a closing bracket or forward slash
      .     ')*?'
      . ')'
      . '(?:'
      .     '(\\/)'                        // 4: Self closing tag ...
      .     '\\]'                          // ... and closing bracket
      . '|'
      .     '\\]'                          // Closing bracket
      .     '(?:'
      .         '('                        // 5: Unroll the loop: Optionally, anything between the opening and closing shortcode tags
      .             '[^\\[]*+'             // Not an opening bracket
      .             '(?:'
      .                 '\\[(?!\\/\\2\\])' // An opening bracket not followed by the closing shortcode tag
      .                 '[^\\[]*+'         // Not an opening bracket
      .             ')*+'
      .         ')'
      .         '\\[\\/\\2\\]'             // Closing shortcode tag
      .     ')?'
      . ')'
      . '(\\]?)';                          // 6: Optional second closing brocket for escaping shortcodes: [[tag]]
}

endif;