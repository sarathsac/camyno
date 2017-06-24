<?php

global $canvys;

function _cv_create_font_scheme( $custom_settings ) {

   $defaults = array(
      'h1' => array(
         'font-size' => '2.5em',
      ),
      'h2' => array(
         'font-size' => '2.25em',
      ),
      'h3' => array(
         'font-size' => '2em',
      ),
      'h4' => array(
         'font-size' => '1.75em',
      ),
      'h5' => array(
         'font-size' => '1.5em',
      ),
      'h6' => array(
         'font-size' => '1.25em',
      ),
   );

   $out = $defaults;

   foreach ( $custom_settings as $selector => $attributes ) {

      if ( array_key_exists( $selector, $defaults ) ) {
         foreach ( $attributes as $attribute => $value ) {
            $out[$selector][$attribute] = $value;
         }
      }

      else {
         $out[$selector] = $attributes;
      }

   }

   return $out;

}

$canvys['typography_schemes_by_family'] = array(
   'standard'    => array( 'arial', 'tahoma', 'georgia', ),
   'sans_serif'  => array( 'open_sans', 'ubuntu', 'lato', 'raleway', 'cabin', 'quattrocento_sans' ),
   'serif'       => array( 'volkhov', 'droid_serif', 'lora', 'playfair_display' ),
   'combination' => array( 'roboto_alegreya', 'dancing_garamond', 'josefin_amatic', 'lobster_cabin', 'raleway_bitter' ),
);

/* Typography Schemes */
$canvys['typography_schemes'] = array(

   'arial' => array(
      'title' => __( 'Arial', 'canvys' ),
      'scheme' => _cv_create_font_scheme( array(
         'body' => array(
            'font-family' => "Arial",
         ),
         'h1' => array(
            'font-family' => "Arial",
            'font-weight' => '400',
         ),
         'h2' => array(
            'font-family' => "Arial",
            'font-weight' => '400',
         ),
         'h3' => array(
            'font-family' => "Arial",
            'font-weight' => '400',
         ),
         'h4' => array(
            'font-family' => "Arial",
            'font-weight' => '400',
         ),
         'h5' => array(
            'font-family' => "Arial",
            'font-weight' => '600',
         ),
         'h6' => array(
            'font-family' => "Arial",
            'font-weight' => '600',
         ),
      ) ),
   ),

   'tahoma' => array(
      'title' => __( 'Tahoma', 'canvys' ),
      'scheme' => _cv_create_font_scheme( array(
         'body' => array(
            'font-family' => "Tahoma",
         ),
         'h1' => array(
            'font-family' => "Tahoma",
            'font-weight' => '400',
         ),
         'h2' => array(
            'font-family' => "Tahoma",
            'font-weight' => '400',
         ),
         'h3' => array(
            'font-family' => "Tahoma",
            'font-weight' => '400',
         ),
         'h4' => array(
            'font-family' => "Tahoma",
            'font-weight' => '400',
         ),
         'h5' => array(
            'font-family' => "Tahoma",
            'font-weight' => '600',
         ),
         'h6' => array(
            'font-family' => "Tahoma",
            'font-weight' => '600',
         ),
      ) ),
   ),

   'georgia' => array(
      'title' => __( 'Georgia', 'canvys' ),
      'scheme' => _cv_create_font_scheme( array(
         'body' => array(
            'font-family' => "Georgia",
         ),
         'h1' => array(
            'font-family' => "Georgia",
            'font-weight' => '400',
         ),
         'h2' => array(
            'font-family' => "Georgia",
            'font-weight' => '400',
         ),
         'h3' => array(
            'font-family' => "Georgia",
            'font-weight' => '400',
         ),
         'h4' => array(
            'font-family' => "Georgia",
            'font-weight' => '400',
         ),
         'h5' => array(
            'font-family' => "Georgia",
            'font-weight' => '600',
         ),
         'h6' => array(
            'font-family' => "Georgia",
            'font-weight' => '600',
         ),
      ) ),
   ),

   'open_sans' => array(
      'title' => __( 'Open Sans', 'canvys' ),
      'families' => array(
         'Open+Sans' => array( '300', '300italic', '400italic', '400', '600italic', '600' ),
         'Montserrat' => array( '400', '700' ),
      ),
      'scheme' => _cv_create_font_scheme( array(
         'body' => array(
            'font-family' => "'Open Sans', sans-serif",
         ),
         'h1' => array(
            'font-family' => "'Open Sans', sans-serif",
            'font-weight' => '300',
         ),
         'h2' => array(
            'font-family' => "'Open Sans', sans-serif",
            'font-weight' => '300',
         ),
         'h3' => array(
            'font-family' => "'Open Sans', sans-serif",
            'font-weight' => '400',
         ),
         'h4' => array(
            'font-family' => "'Open Sans', sans-serif",
            'font-weight' => '400',
         ),
         'h5' => array(
            'font-family' => "'Open Sans', sans-serif",
            'font-weight' => '600',
         ),
         'h6' => array(
            'font-family' => "'Open Sans', sans-serif",
            'font-weight' => '600',
         ),
         '.widget .widget-title' => array(
            'font-family' => "'Montserrat', sans-serif",
         ),
      ) ),
   ),

   'ubuntu' => array(
      'title' => __( 'Ubuntu', 'canvys' ),
      'families' => array(
         'Ubuntu' => array( '300', '300italic', '400italic', '400', '700italic', '700' ),
      ),
      'scheme' => _cv_create_font_scheme( array(
         'body' => array(
            'font-family' => "'Ubuntu', sans-serif",
         ),
         'h1' => array(
            'font-family' => "'Ubuntu', sans-serif",
            'font-weight' => '300',
         ),
         'h2' => array(
            'font-family' => "'Ubuntu', sans-serif",
            'font-weight' => '300',
         ),
         'h3' => array(
            'font-family' => "'Ubuntu', sans-serif",
            'font-weight' => '400',
         ),
         'h4' => array(
            'font-family' => "'Ubuntu', sans-serif",
            'font-weight' => '400',
         ),
         'h5' => array(
            'font-family' => "'Ubuntu', sans-serif",
            'font-weight' => '700',
         ),
         'h6' => array(
            'font-family' => "'Ubuntu', sans-serif",
            'font-weight' => '700',
         ),
      ) ),
   ),

   'lato' => array(
      'title' => __( 'Lato', 'canvys' ),
      'families' => array(
         'Lato' => array( '300', '300italic', '400italic', '400', '700italic', '700' ),
      ),
      'scheme' => _cv_create_font_scheme( array(
         'body' => array(
            'font-family' => "'Lato', sans-serif",
         ),
         'h1' => array(
            'font-family' => "'Lato', sans-serif",
            'font-weight' => '300',
         ),
         'h2' => array(
            'font-family' => "'Lato', sans-serif",
            'font-weight' => '300',
         ),
         'h3' => array(
            'font-family' => "'Lato', sans-serif",
            'font-weight' => '400',
         ),
         'h4' => array(
            'font-family' => "'Lato', sans-serif",
            'font-weight' => '400',
         ),
         'h5' => array(
            'font-family' => "'Lato', sans-serif",
            'font-weight' => '700',
         ),
         'h6' => array(
            'font-family' => "'Lato', sans-serif",
            'font-weight' => '700',
         ),
      ) ),
   ),

   'raleway' => array(
      'title' => __( 'Raleway', 'canvys' ),
      'families' => array(
         'Raleway' => array( '300', '300italic', '400italic', '400', '500', '600italic', '600' ),
      ),
      'scheme' => _cv_create_font_scheme( array(
         'body' => array(
            'font-family' => "'Raleway', sans-serif",
         ),
         'h1' => array(
            'font-family' => "'Raleway', sans-serif",
            'font-weight' => '300',
         ),
         'h2' => array(
            'font-family' => "'Raleway', sans-serif",
            'font-weight' => '300',
         ),
         'h3' => array(
            'font-family' => "'Raleway', sans-serif",
            'font-weight' => '400',
         ),
         'h4' => array(
            'font-family' => "'Raleway', sans-serif",
            'font-weight' => '400',
         ),
         'h5' => array(
            'font-family' => "'Raleway', sans-serif",
            'font-weight' => '600',
         ),
         'h6' => array(
            'font-family' => "'Raleway', sans-serif",
            'font-weight' => '600',
         ),
         '#header .dropdown-menu > li > a' => array(
            'font-weight' => '500 !important',
         ),
      ) ),
   ),

   'cabin' => array(
      'title' => __( 'Cabin', 'canvys' ),
      'families' => array(
         'Cabin' => array( '400italic', '400', '600italic', '600' ),
      ),
      'scheme' => _cv_create_font_scheme( array(
         'body' => array(
            'font-family' => "'Cabin', sans-serif",
         ),
         'h1' => array(
            'font-family' => "'Cabin', sans-serif",
            'font-weight' => '400',
         ),
         'h2' => array(
            'font-family' => "'Cabin', sans-serif",
            'font-weight' => '400',
         ),
         'h3' => array(
            'font-family' => "'Cabin', sans-serif",
            'font-weight' => '400',
         ),
         'h4' => array(
            'font-family' => "'Cabin', sans-serif",
            'font-weight' => '400',
         ),
         'h5' => array(
            'font-family' => "'Cabin', sans-serif",
            'font-weight' => '600',
         ),
         'h6' => array(
            'font-family' => "'Cabin', sans-serif",
            'font-weight' => '600',
         ),
         '.post .post-featured-box .primary-content' => array(
            'font-weight' => '300',
         ),
      ) ),
   ),

   'quattrocento_sans' => array(
      'title' => __( 'Quattrocento Sans', 'canvys' ),
      'families' => array(
         'Quattrocento+Sans' => array( '400italic', '400', '700italic', '700' ),
      ),
      'scheme' => _cv_create_font_scheme( array(
         'body' => array(
            'font-family' => "'Quattrocento Sans', sans-serif",
         ),
         'h1' => array(
            'font-family' => "'Quattrocento Sans', sans-serif",
            'font-weight' => '400',
         ),
         'h2' => array(
            'font-family' => "'Quattrocento Sans', sans-serif",
            'font-weight' => '400',
         ),
         'h3' => array(
            'font-family' => "'Quattrocento Sans', sans-serif",
            'font-weight' => '400',
         ),
         'h4' => array(
            'font-family' => "'Quattrocento Sans', sans-serif",
            'font-weight' => '400',
         ),
         'h5' => array(
            'font-family' => "'Quattrocento Sans', sans-serif",
            'font-weight' => '700',
         ),
         'h6' => array(
            'font-family' => "'Quattrocento Sans', sans-serif",
            'font-weight' => '700',
         ),
         '.post .post-featured-box .primary-content' => array(
            'font-weight' => '300',
         ),
         '.post.style-boxed .post-box .post-title' => array(
            'font-weight' => '700',
         ),
         '.top-banner h5' => array(
            'font-weight' => '400',
         ),
      ) ),
   ),

   'volkhov' => array(
      'title' => __( 'Volkhov', 'canvys' ),
      'families' => array(
         'Volkhov' => array( '400italic', '400', '700italic', '700' ),
      ),
      'scheme' => _cv_create_font_scheme( array(
         'body' => array(
            'font-family' => "'Volkhov', serif",
         ),
         'h1' => array(
            'font-family' => "'Volkhov', serif",
            'font-weight' => '400',
         ),
         'h2' => array(
            'font-family' => "'Volkhov', serif",
            'font-weight' => '400',
         ),
         'h3' => array(
            'font-family' => "'Volkhov', serif",
            'font-weight' => '400',
         ),
         'h4' => array(
            'font-family' => "'Volkhov', serif",
            'font-weight' => '400',
         ),
         'h5' => array(
            'font-family' => "'Volkhov', serif",
            'font-weight' => '700',
         ),
         'h6' => array(
            'font-family' => "'Volkhov', serif",
            'font-weight' => '700',
         ),
         '.post .post-featured-box .primary-content' => array(
            'font-weight' => '300',
         ),
         '.post.style-boxed .post-box .post-title' => array(
            'font-weight' => '700',
         ),
         '.top-banner h5' => array(
            'font-weight' => '400',
         ),
      ) ),
   ),

   'droid_serif' => array(
      'title' => __( 'Droid Serif', 'canvys' ),
      'families' => array(
         'Droid+Serif' => array( '400italic', '400', '700italic', '700' ),
      ),
      'scheme' => _cv_create_font_scheme( array(
         'body' => array(
            'font-family' => "'Droid Serif', serif",
         ),
         'h1' => array(
            'font-family' => "'Droid Serif', serif",
            'font-weight' => '400',
         ),
         'h2' => array(
            'font-family' => "'Droid Serif', serif",
            'font-weight' => '400',
         ),
         'h3' => array(
            'font-family' => "'Droid Serif', serif",
            'font-weight' => '400',
         ),
         'h4' => array(
            'font-family' => "'Droid Serif', serif",
            'font-weight' => '400',
         ),
         'h5' => array(
            'font-family' => "'Droid Serif', serif",
            'font-weight' => '700',
         ),
         'h6' => array(
            'font-family' => "'Droid Serif', serif",
            'font-weight' => '700',
         ),
         '.post .post-featured-box .primary-content' => array(
            'font-weight' => '300',
         ),
         '.post.style-boxed .post-box .post-title' => array(
            'font-weight' => '700',
         ),
         '.top-banner h5' => array(
            'font-weight' => '400',
         ),
      ) ),
   ),

   'lora' => array(
      'title' => __( 'Lora', 'canvys' ),
      'families' => array(
         'Lora' => array( '400italic', '400', '700italic', '700' ),
      ),
      'scheme' => _cv_create_font_scheme( array(
         'body' => array(
            'font-family' => "'Lora', serif",
         ),
         'h1' => array(
            'font-family' => "'Lora', serif",
            'font-weight' => '400',
         ),
         'h2' => array(
            'font-family' => "'Lora', serif",
            'font-weight' => '400',
         ),
         'h3' => array(
            'font-family' => "'Lora', serif",
            'font-weight' => '400',
         ),
         'h4' => array(
            'font-family' => "'Lora', serif",
            'font-weight' => '400',
         ),
         'h5' => array(
            'font-family' => "'Lora', serif",
            'font-weight' => '700',
         ),
         'h6' => array(
            'font-family' => "'Lora', serif",
            'font-weight' => '700',
         ),
         '.post-box .post-title' => array(
            'font-weight' => '400',
         ),
         '.post .post-featured-box .primary-content' => array(
            'font-weight' => '300',
         ),
         '.post.style-boxed .post-box .post-title' => array(
            'font-weight' => '700',
         ),
         '.top-banner h5' => array(
            'font-weight' => '400',
         ),
      ) ),
   ),

   'playfair_display' => array(
      'title' => __( 'Playfair Display', 'canvys' ),
      'families' => array(
         'Playfair+Display' => array( '400italic', '400', '700italic', '700' ),
      ),
      'scheme' => _cv_create_font_scheme( array(
         'body' => array(
            'font-family' => "'Playfair Display', serif",
         ),
         'h1' => array(
            'font-family' => "'Playfair Display', serif",
            'font-weight' => '400',
            'font-size' => '2.75em',
         ),
         'h2' => array(
            'font-family' => "'Playfair Display', serif",
            'font-weight' => '400',
            'font-size' => '2.5em',
         ),
         'h3' => array(
            'font-family' => "'Playfair Display', serif",
            'font-weight' => '400',
            'font-size' => '2em',
         ),
         'h4' => array(
            'font-family' => "'Playfair Display', serif",
            'font-weight' => '400',
            'font-size' => '1.75em',
         ),
         'h5' => array(
            'font-family' => "'Playfair Display', serif",
            'font-weight' => '700',
            'font-size' => '1.5em',
         ),
         'h6' => array(
            'font-family' => "'Playfair Display', serif",
            'font-weight' => '700',
            'font-size' => '1.25em',
         ),
         '.post-box .post-title' => array(
            'font-weight' => '400',
         ),
         '.post .post-featured-box .primary-content' => array(
            'font-weight' => '300',
         ),
         '.post.style-boxed .post-box .post-title' => array(
            'font-weight' => '700',
         ),
         '.top-banner h5' => array(
            'font-weight' => '400',
         ),
      ) ),
   ),

   'roboto_alegreya' => array(
      'title' => __( 'Roboto Alegreya', 'canvys' ),
      'families' => array(
         'Alegreya' => array( '400', '400italic', '700', '700itlic' ),
         'Roboto' => array( '300', '400', '400italic', '700' ),
         'Roboto+Condensed' => array( '300', '400', '400italic', '700' ),
      ),
      'scheme' => _cv_create_font_scheme( array(
         'body' => array(
            'font-family' => "'Roboto', sans-serif",
            'font-weight' => '400',
         ),
         'h1' => array(
            'font-family' => "'Alegreya', sans-serif",
            'font-weight' => '700',
            'font-size' => '3em',
         ),
         'h2' => array(
            'font-family' => "'Alegreya', sans-serif",
            'font-weight' => '400',
            'font-size' => '2.75em',
         ),
         'h3' => array(
            'font-family' => "'Roboto Condensed', sans-serif",
            'font-weight' => '400',
            'font-size' => '2em',
         ),
         'h4' => array(
            'font-family' => "'Roboto Condensed', sans-serif",
            'font-weight' => '400',
            'font-size' => '1.75em',
         ),
         'h5' => array(
            'font-family' => "'Roboto', sans-serif",
            'font-weight' => '700',
            'font-size' => '1.25em',
         ),
         'h6' => array(
            'font-family' => "'Roboto', sans-serif",
            'font-weight' => '700',
            'font-size' => '1em',
         ),
         '.post.is-single .post-title' => array(
            'font-size' => '2.5em',
         ),
         '.post .post-featured-box .primary-content' => array(
            'font-size' => '1.25em',
            'font-weight' => '400',
         ),
         '.post.style-boxed .post-box .post-title' => array(
            'font-weight' => '700',
         ),
         '.post.style-minimal .post-title' => array(
            'font-size' => '2.5em',
         ),
         '.top-banner h3' => array(
            'font-family' => "'Alegreya', sans-serif",
            'font-weight' => '700',
         ),
         '.top-banner h5' => array(
            'font-weight' => '300',
         ),
      ) ),
   ),

   'dancing_garamond' => array(
      'title' => __( 'Dancing Garamond', 'canvys' ),
      'families' => array(
         'Dancing+Script' => array( '400', '700' ),
         'EB+Garamond' => array( '400' ),
      ),
      'scheme' => _cv_create_font_scheme( array(
         'body' => array(
            'font-family' => "'EB Garamond', serif",
            'font-weight' => '400',
         ),
         'h1' => array(
            'font-family' => "'Dancing Script', cursive",
            'font-weight' => '400',
            'font-size' => '3.25em',
         ),
         'h2' => array(
            'font-family' => "'EB Garamond', serif",
            'font-weight' => '400',
            'font-size' => '2.25em',
         ),
         'h3' => array(
            'font-family' => "'EB Garamond', serif",
            'font-weight' => '400',
            'font-size' => '2em',
         ),
         'h4' => array(
            'font-family' => "'EB Garamond', serif",
            'font-weight' => '400',
            'font-size' => '1.75em',
         ),
         'h5' => array(
            'font-family' => "'EB Garamond', serif",
            'font-weight' => '400',
            'font-size' => '1.5em',
         ),
         'h6' => array(
            'font-family' => "'EB Garamond', serif",
            'font-weight' => '400',
            'font-size' => '1.25em',
         ),
         '.post-box .post-title' => array(
            'font-family' => "'Dancing Script', cursive",
            'font-size' => '2.25em',
         ),
         '.post.is-single .post-title' => array(
            'font-size' => '2.5em',
            'font-weight' => '400',
         ),
         '.post .post-featured-box .primary-content' => array(
            'font-size' => '1.75em',
            'font-weight' => '400',
         ),
         '.post.style-boxed .post-box .post-title' => array(
            'font-weight' => '600',
         ),
         '.top-banner h3' => array(
            'font-family' => "'Dancing Script', cursive",
            'font-weight' => '400',
         ),
         '.top-banner h5' => array(
            'font-weight' => '400',
         ),
         '.content-section-sidebar .widget-title' => array(
            'letter-spacing' => '2px',
         ),
         '#footer .widget-title' => array(
            'letter-spacing' => '2px',
         ),
      ) ),
   ),

   'josefin_amatic' => array(
      'title' => __( 'Josefin Amatic', 'canvys' ),
      'families' => array(
         'Amatic+SC' => array( '400', '700' ),
         'Josefin+Sans' => array( '300', '400', '600' ),
      ),
      'scheme' => _cv_create_font_scheme( array(
         'body' => array(
            'font-family' => "'Josefin Sans', sans-serif",
            'font-weight' => '400',
         ),
         'h1' => array(
            'font-family' => "'Amatic SC', cursive",
            'font-weight' => '700',
            'font-size' => '3.25em',
         ),
         'h2' => array(
            'font-family' => "'Amatic SC', cursive",
            'font-weight' => '700',
            'font-size' => '2.5em',
         ),
         'h3' => array(
            'font-family' => "'Josefin Sans', sans-serif",
            'font-weight' => '600',
            'font-size' => '2em',
         ),
         'h4' => array(
            'font-family' => "'Josefin Sans', sans-serif",
            'font-weight' => '600',
            'font-size' => '1.75em',
         ),
         'h5' => array(
            'font-family' => "'Josefin Sans', sans-serif",
            'font-weight' => '600',
            'font-size' => '1.5em',
         ),
         'h6' => array(
            'font-family' => "'Josefin Sans', sans-serif",
            'font-weight' => '600',
            'font-size' => '1.25em',
         ),
         '.post-box .post-title' => array(
            'font-size' => '2.25em',
         ),
         '.post.is-single .post-title' => array(
            'font-size' => '2.5em',
         ),
         '.post .post-featured-box .primary-content' => array(
            'font-size' => '1.75em',
            'font-weight' => '400',
         ),
         '.post.style-boxed .post-box .post-title' => array(
            'font-weight' => '600',
         ),
         '.top-banner h3' => array(
            'font-family' => "'Amatic SC', cursive",
            'font-weight' => '700',
         ),
         '.top-banner h5' => array(
            'font-weight' => '600',
         ),
         '.content-section-sidebar .widget-title' => array(
            'font-family' => "'Amatic SC', cursive",
            'font-weight' => '700',
            'font-size' => '2em',
         ),
         '#footer .widget-title' => array(
            'font-family' => "'Amatic SC', cursive",
            'font-weight' => '700',
            'font-size' => '2em',
         ),
      ) ),
   ),

   'lobster_cabin' => array(
      'title' => __( 'Lobster Cabin', 'canvys' ),
      'families' => array(
         'Lobster+Two' => array( '400' ),
         'Cabin' => array( '400italic', '400', '600italic', '600' ),
      ),
      'scheme' => _cv_create_font_scheme( array(
         'body' => array(
            'font-family' => "'Cabin', sans-serif",
            'font-weight' => '400',
         ),
         'h1' => array(
            'font-family' => "'Lobster Two', cursive",
            'font-weight' => '400',
            'font-size' => '3.25em',
         ),
         'h2' => array(
            'font-family' => "'Lobster Two', cursive",
            'font-weight' => '400',
            'font-size' => '2.5em',
         ),
         'h3' => array(
            'font-family' => "'Cabin', sans-serif",
            'font-weight' => '600',
            'font-size' => '2em',
         ),
         'h4' => array(
            'font-family' => "'Cabin', sans-serif",
            'font-weight' => '600',
            'font-size' => '1.75em',
         ),
         'h5' => array(
            'font-family' => "'Cabin', sans-serif",
            'font-weight' => '600',
            'font-size' => '1.5em',
         ),
         'h6' => array(
            'font-family' => "'Cabin', sans-serif",
            'font-weight' => '600',
            'font-size' => '1.25em',
         ),
         '.post-box .post-title' => array(
            'font-size' => '2.25em',
         ),
         '.post.is-single .post-title' => array(
            'font-size' => '2.5em',
         ),
         '.post .post-featured-box .primary-content' => array(
            'font-size' => '1.25em',
            'font-weight' => '400',
         ),
         '.post.style-boxed .post-box .post-title' => array(
            'font-weight' => '600',
         ),
         '.top-banner h3' => array(
            'font-family' => "'Lobster Two', cursive",
            'font-weight' => '400',
         ),
         '.top-banner h5' => array(
            'font-weight' => '600',
         ),
         '.content-section-sidebar .widget-title' => array(
            'font-family' => "'Lobster Two', cursive",
            'font-weight' => '400',
            'font-size' => '2em',
            'text-transform' => 'none',
            'letter-spacing' => '0px',
         ),
         '#footer .widget-title' => array(
            'font-family' => "'Lobster Two', cursive",
            'font-weight' => '400',
            'font-size' => '2em',
            'text-transform' => 'none',
            'letter-spacing' => '0px',
         ),
      ) ),
   ),

   'raleway_bitter' => array(
      'title' => __( 'Raleway Bitter', 'canvys' ),
      'families' => array(
         'Raleway' => array( '300', '300italic', '400italic', '400', '600italic', '600' ),
         'Bitter'  => array( '400italic', '400', '700italic', '700' ),
      ),
      'scheme' => _cv_create_font_scheme( array(
         'body' => array(
            'font-family' => "'Bitter', serif",
            'font-weight' => '400',
         ),
         'h1' => array(
            'font-family' => "'Raleway', sans-serif",
            'font-weight' => '300',
         ),
         'h2' => array(
            'font-family' => "'Raleway', sans-serif",
            'font-weight' => '300',
         ),
         'h3' => array(
            'font-family' => "'Raleway', sans-serif",
            'font-weight' => '400',
         ),
         'h4' => array(
            'font-family' => "'Raleway', sans-serif",
            'font-weight' => '400',
         ),
         'h5' => array(
            'font-family' => "'Raleway', sans-serif",
            'font-weight' => '600',
         ),
         'h6' => array(
            'font-family' => "'Raleway', sans-serif",
            'font-weight' => '600',
         ),
         '.post-box .post-title' => array(
            'font-weight' => '400',
         ),
         '.post .post-featured-box .primary-content' => array(
            'font-size' => '1.25em',
            'font-weight' => '400',
         ),
      ) ),
   ),

);