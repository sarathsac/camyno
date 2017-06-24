<div class="header-logo cv-logo" id="header-logo">

   <h1 id="site-title"><?php bloginfo('name'); ?></h1>
   <h2 id="site-description"><?php bloginfo('description'); ?></h2>

   <a href="<?php echo home_url(); ?>" class="logo-image primary-logo">
      <span class="displayed-title"><?php bloginfo('name'); ?></span>
   </a>

   <?php if ( cv_is_header_transparent() ) {

      global $post;

      // Grab the normal logo
      $normal_logo = cv_theme_setting( 'header', 'logo' ) ? cv_theme_setting( 'header', 'logo' ) : null;

      // grab the default transparency logo
      $transparent_logo = cv_theme_setting( 'header', 'transparency_logo' ) ? cv_theme_setting( 'header', 'transparency_logo' ) : $normal_logo;

      // Check if the transparency logo was overriden
      if ( isset( $post ) && get_the_ID() ) {

         // Grab the meta information, if any
         $cv_meta = get_post_meta( get_the_ID(), '_cv_page_settings', true );

         // If custom settings are enabled
         if ( isset( $cv_meta['transparency'] ) && 'custom' == $cv_meta['transparency'] ) {
            if ( isset( $cv_meta['transparency_logo'] ) ) {
               $img_data = wp_get_attachment_image_src( $cv_meta['transparency_logo'], 'full' );
               $transparent_logo = $img_data ? $img_data[0] : $transparent_logo;
            }
         }

         else {

            // Allow single posts to match the blog page
            if ( ( is_single() || is_archive() ) && 'post' == get_post_type() ) {
               if ( in_array( cv_theme_setting( 'blog', 'banner_behavior', 'default' ), array( 'blog_page', 'blog_page-hidden') ) ) {
                  $blog_page = cv_theme_setting( 'blog', 'blog_page' );
                  if ( $blog_page && 'none' != $blog_page ) {
                     $cv_meta = get_post_meta( $blog_page, '_cv_page_settings', true );
                     if ( isset( $cv_meta['transparency'] ) && 'custom' == $cv_meta['transparency'] ) {
                        if ( isset( $cv_meta['transparency_logo'] ) ) {
                           $img_data = wp_get_attachment_image_src( $cv_meta['transparency_logo'], 'full' );
                           $transparent_logo = $img_data ? $img_data[0] : $transparent_logo;
                        }
                     }
                  }
               }
            }

            // Allow portfolio items to match the portfolio page
            else if ( is_single() && 'portfolio_item' == get_post_type() ) {
               if ( 'portfolio_page' == cv_theme_setting( 'portfolio', 'banner_behavior', 'default' ) ) {
                  $portfolio_page = cv_theme_setting( 'portfolio', 'portfolio_page' );
                  if ( $portfolio_page && 'none' != $portfolio_page ) {
                     $cv_meta = get_post_meta( $portfolio_page, '_cv_page_settings', true );
                     if ( isset( $cv_meta['transparency'] ) && 'custom' == $cv_meta['transparency'] ) {
                        if ( isset( $cv_meta['transparency_logo'] ) ) {
                           $img_data = wp_get_attachment_image_src( $cv_meta['transparency_logo'], 'full' );
                           $transparent_logo = $img_data ? $img_data[0] : $transparent_logo;
                        }
                     }
                  }
               }
            }

         }

      }

      // Allow the logo to be modified externally
      $transparent_logo = apply_filters( 'cv_header_transparency_logo', $transparent_logo );

      // Render the transparency logo
      $has_logo_class = $transparent_logo ? ' has-logo' : ' no-logo';
      $inline_style   = $transparent_logo ? ' style="background-image:url(' . $transparent_logo . ');"' : null;
      echo '<a href="' . home_url() . '" class="logo-image secondary-logo' . $has_logo_class . '"' . $inline_style . '>';
      echo '<span class="displayed-title">' . get_bloginfo('name') . '</span>';
      echo '</a>';

   }

?></div>