<?php

/* Register custom MCE editor styles
 * =========================================== */

if ( ! function_exists( 'cv_mce_buttons_2' ) ) :

add_filter('mce_buttons_2', 'cv_mce_buttons_2');

/**
 * Displays the style select dropdown
 *
 * @param array $settings Existing MCE buttons
 * @return array
 */
function cv_mce_buttons_2( $buttons ) {
   array_unshift( $buttons, 'styleselect' );
   return $buttons;
}

endif;

if ( ! function_exists( 'cv_custom_mce_before_init' ) ) :

add_filter( 'tiny_mce_before_init', 'cv_custom_mce_before_init' );

/**
 * Adds custom styles dropdown to MCE editor
 *
 * @param array $settings Existing MCE settings
 * @return array
 */
function cv_custom_mce_before_init( $settings ) {

   $style_formats = array(

      /* Dropcaps */
      array(
         'title'   => __( 'Dropcap Small','canvys'),
         'block'   => 'p',
         'classes' => 'cv-dropcap-small'
      ),
      array(
         'title'   => __( 'Dropcap Medium','canvys'),
         'block'   => 'p',
         'classes' => 'cv-dropcap-medium'
      ),
      array(
         'title'   => __( 'Dropcap Large','canvys'),
         'block'   => 'p',
         'classes' => 'cv-dropcap-large'
      ),

      /* Highlights */
      array(
         'title'   => __( 'Highlight Yellow','canvys'),
         'inline'  => 'span',
         'classes' => 'cv-highlight-yellow'
      ),
      array(
         'title'   => __( 'Highlight Blue','canvys'),
         'inline'  => 'span',
         'classes' => 'cv-highlight-blue'
      ),
      array(
         'title'   => __( 'Highlight Red','canvys'),
         'inline'  => 'span',
         'classes' => 'cv-highlight-red'
      ),
      array(
         'title'   => __( 'Highlight Green','canvys'),
         'inline'  => 'span',
         'classes' => 'cv-highlight-green'
      )
   );

   $settings['style_formats'] = json_encode( $style_formats );

   return $settings;

}

endif;

// Apply custom stylesheet
add_editor_style();