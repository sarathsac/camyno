<?php

if ( ! function_exists( 'cv_render_settings_styles' ) ) :

add_action( 'cv_render_dynamic_stylesheet', 'cv_render_settings_styles', null );

/**
 * Generate theme settings styles
 *
 * @return void
 */
function cv_render_settings_styles() {

   global $canvys;

   /* Render typography scheme */
   $setting = cv_theme_setting( 'visual', 'font_scheme', 'business' );
   $scheme  = $canvys['typography_schemes'][$setting]['scheme'];
   foreach ( $scheme as $tag => $styles ) {
      echo $tag . " {";
      foreach ( $styles as $attr => $val ) {
         echo "{$attr}: {$val};";
      }
      echo "}";
   }

   /* Modify typography size */
   switch ( cv_theme_setting( 'visual', 'font_size', 'smaller' ) ) {
      case 'much-smaller': $font_size = '0.75em';   break;
      case 'smaller':      $font_size = '0.8125em'; break;
      case 'larger':       $font_size = '0.9375em'; break;
      case 'much-larger':  $font_size = '1em';      break;
      default: $font_size = '0.875em';
   }
   echo ".cv-user-font {";
   echo "font-size: {$font_size}";
   echo "}";

   /* Modify user logo */
   if ( $logo = cv_theme_setting( 'header', 'logo' ) ) {
      echo ".cv-logo .primary-logo {";
      echo "background-image: url({$logo});";
      echo "}";
      echo ".cv-logo .primary-logo .displayed-title {";
      echo "display: none;";
      echo "}";
   }
   else {
      echo ".cv-logo .primary-logo .displayed-title {";
      echo "display: block;";
      echo "}";
   }

   /* Modify header layout */
   $align = cv_theme_setting( 'header', 'alignment', 'left' );
   $logo_align = 'left' === $align ? 'left'  : 'right';
   $nav_align  = 'left' === $align ? 'right' : 'left';
   echo "#header .header-logo {";
   echo "float: {$logo_align};";
   echo "text-align: {$logo_align};";
   echo "}";
   echo "#header .primary-tools {";
   echo "{$logo_align}: 0;";
   echo "}";
   echo "#header .navigation-container {";
   echo "float: {$nav_align};";
   echo "}";


}
endif;