<?php

global $canvys, $post, $num_columns;

// Make sure we`re on a page
if ( ! is_page() ) return;

// Determine the number of columns to use
$sidebar_layout = isset( $canvys['current_sidebar_layout'] ) ? $canvys['current_sidebar_layout'] : 'no-sidebar';
$num_columns = 'no-sidebar' == $sidebar_layout ? 4 : 3;

// Get all descedant pages
$posts = get_pages( array(
   'hierarchical' => false,
   'parent' => get_the_ID(),
) );

if ( is_array( $posts ) ) :

   // Active color scheme
   $color_scheme = cv_get_color_scheme();
   $color_scheme = $color_scheme['scheme']['main'];

   // Overlay color settings
   $overlay_bg = cv_theme_setting( 'visual', 'image_hover_color', '#000000' ) ? cv_theme_setting( 'visual', 'image_hover_color', '#000000' ) : '#000000';
   $overlay_color = 0.85 > cv_hex_brightness( $overlay_bg ) ? '#ffffff' : '#000000'; ?>

   <div class="posts-wrapper cv-grid-<?php echo $num_columns; ?> spacing-2 has-clearfix">

   <?php foreach ( $posts as $post ) : setup_postdata( $post );

      // Config array for promo box
      $config = array(
         'link' => get_permalink(),
         'ratio' => '3x2',
         'color' => $color_scheme['headers'],
         'bg_color' => $color_scheme['secondary_bg'],
      );

      // Create the title
      $title = '[cv_promo_box_line text="' . get_the_title() . '" weight="300"]';

      // Add the thumbnail
      if ( has_post_thumbnail() ) :
         $config['bg_image'] = get_post_thumbnail_id();
         $config['bg_color'] = $overlay_bg;
         $config['color'] = $overlay_color;
         $config['overlay_opacity'] = '50';
         $config['overlay_color'] = $overlay_bg;
      endif; ?>

      <div class="post-layout-wrapper">

         <article id="post-<?php echo get_the_ID(); ?>" <?php post_class(); ?>>

            <?php echo $canvys['shortcodes']['cv_promo_box']->callback( $config, $title ); ?>

         </article>

      </div>

   <?php endforeach; wp_reset_query(); ?>

   </div>

<?php endif;