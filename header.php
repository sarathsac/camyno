<?php

global $canvys;

/**
 * The header for our theme
 *
 * Displays all of the <head> section and the beginning of the body
 *
 * @package    WordPress
 * @subpackage Canvys
 * @since      Version 1.0
 */

?><!DOCTYPE html>

<html <?php language_attributes(); ?> <?php cv_html_class(); ?>>
<head>

   <meta charset="<?php bloginfo( 'charset' ); ?>">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <title><?php echo cv_set_front_title(); ?></title>
   <link rel="profile" href="http://gmpg.org/xfn/11">
   <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

   <!-- Plugin and theme output with wp_head()-->
   <?php

      /* add javascript to pages with threaded comments */
      if ( is_singular() && get_option('thread_comments') ) {
         wp_enqueue_script('comment-reply');
      }

      /* Always have wp_head() just before the closing </head>
       * tag of your theme, or you will break many plugins, which
       * generally use this hook to add elements to <head> such
       * as styles, scripts, and meta tags.
       */
      wp_head();

?></head>
<body <?php body_class(); ?>>
<script> document.body.className = document.body.className.replace('no-js','js'); </script>

<!-- Top Anchor  -->
<div id="top"></div>

<div id="container" class="page-container">

   <div class="wrap-all"><?php

      // Display the header
      if ( cv_is_header_active() ) :

         // Check if header is stretched
         $stretched_class = cv_theme_setting( 'header', 'enable_stretched' ) ? ' is-free' : null;

         /* include Secondary Bar */
         if ( ! cv_is_page_slide_active() && cv_is_additional_bar_active() ) { ?>
            <section class="header-additional-bar has-clearfix" id="header-additional-bar">
               <div class="wrap <?php echo $stretched_class; ?>">
                  <div class="cv-user-font">
                     <?php get_template_part( 'inc/content/additional-bar' ); ?>
                  </div>
               </div>
            </section>
         <?php }

         /* Include header marker if sticky header is active */
         if ( cv_is_header_sticky() ) {
            $collapsing_class = cv_is_header_collapsing() ? 'is-collapsing' : null;
            $transparent_class = cv_is_header_transparent() ? ' transparency-active' : null;
            echo '<div id="header-marker" class="' . $collapsing_class . $transparent_class . '"></div>';
         } ?>

         <header id="header" <?php cv_top_header_class(); ?>>
            <div class="wrap has-clearfix<?php echo $stretched_class; ?>">
               <div class="cv-user-font"><?php

                  // Include Logo
                  get_template_part( 'inc/content/logo' );

                  // Include Primary navigation
                  get_template_part( 'inc/content/main-navigation' );

                  // Allow users to add content to the header
                  do_action('cv_header'); ?>

               <!-- End .cv-user-font -->
               </div>

            <!-- End #header .wrap -->
            </div>

         <!-- End #header -->
         </header>

         <div class="clearfix"></div>

      <?php endif;

      // After header action
      do_action('cv_after_header');

      // Banner area
      if ( cv_is_banner_active() ) {
         get_template_part( 'inc/content/banner' );
      }

      // After banner action
      do_action('cv_after_banner'); ?>

      <div id="body">

      <?php do_action('cv_body_start'); ?>