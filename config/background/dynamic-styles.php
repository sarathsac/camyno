<?php

if ( ! function_exists( 'cv_render_background_styles' ) ) :

add_action( 'cv_render_dynamic_stylesheet', 'cv_render_background_styles', null );

/**
 * Generate dynamic background styles
 *
 * @return void
 */
function cv_render_background_styles() {

   // Current background settings
   $bg_settings = apply_filters( 'cv_background', get_option( 'cv_background' ) );

   // Begin styles object
   $styles = array(
      'color' => $bg_settings['color'],
   );

   // Fill the styles object
   if ( 'custom' != $bg_settings['source'] ) {
      $styles['image']      = 'url(' . THEME_DIR . 'assets/img/patterns/' . $bg_settings['source'] . '.png)';
      $styles['repeat']     = 'repeat';
      $styles['position']   = 'left top';
      $styles['attachment'] = $bg_settings['preset_attachment'];
   }

   else if ( $bg_settings['image'] ) {

      $styles['image']      = 'url(' . $bg_settings['image'] . ')';

      if ( 'cover' == $bg_settings['style'] ) {
         $styles['size']       = 'cover';
         $styles['attachment'] = 'fixed';
      }

      else {
         $styles['repeat']     = $bg_settings['repeat'];
         $styles['position']   = $bg_settings['position'];
         $styles['attachment'] = $bg_settings['custom_attachment'];
      }

   }

   // output the CSS
   echo '/* Breakpoint: 1 */';
   echo '@media all and (min-width: 40em) {';
   echo 'body {';
   foreach ( $styles as $attr => $val ) {
      echo 'background-' . $attr .': ' . $val . ';';
   }
   echo '}';
   echo '}';

}
endif;