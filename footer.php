<?php

global $canvys;

/**
 * The footer for our theme
 *
 * Displays the remainder of the <body> tag
 *
 * @package    WordPress
 * @subpackage Canvys
 * @since      Version 1.0
 */

      // Allow users to add content before the footer
      do_action('cv_before_footer');

      // Display footer bread crumbs
      if ( cv_is_footer_crumbs_active() ) {
         echo '<div id="footer-bread-crumbs" class="scheme-footer">';
         echo '<div class="wrap"><div class="cv-user-font">';
         echo '<ul class="bread-crumbs has-clearfix">';
         echo cv_get_bread_crumbs();
         echo '</ul></div></div></div>';
      }

      // Display the footer
      if ( cv_is_footer_active() ) {
         ob_start();
         get_sidebar('footer');
         do_action('cv_footer');
         $content = ob_get_clean();
         echo cv_content_section( array(
            'color_scheme' => 'footer',
            'apply_filters' => false,
            'id' => 'footer',
         ), $content );
      }

      // Display the socket area
      if ( cv_is_socket_active() ) {
         get_template_part( 'inc/content/socket' );
      }

      do_action('cv_body_end'); ?>

      <!-- End #body -->
      </div>

   <!-- End .wrap-all -->
   </div>

<!-- End #container -->
</div>

<!-- Plugin and theme output with wp_footer() -->
<?php

   // Return to top link
   if ( cv_theme_setting( 'general', 'enable_floating_anchor', true ) ) {
      echo new CV_HTML( '<a>', array(
         'id' => 'cv-floating-anchor',
         'class' => 'animate-scroll',
         'href' => '#top',
         'content' => '<i class="icon-up-open-mini"></i>',
      ) );
   }

   // Include the overlay menu
   get_template_part( 'inc/content/overlay-menu' );

   // Include the additional bar overlay
   get_template_part( 'inc/content/overlay-additional' );

   // Include the search overlay
   get_template_part( 'inc/content/overlay-search' );

   /**
    * Always have wp_footer() just before the closing </body>
    * tag of your theme, or you will break many plugins, which
    * generally use this hook to reference JavaScript files.
    */
   wp_footer();

?><div id="horizontal-resize-indicator"></div>
</body>
</html>