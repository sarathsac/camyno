<?php

if ( ! cv_theme_setting( 'social', 'share_buttons', true ) ) return;

$enabled_outlets = cv_theme_setting( 'social', 'enabled_share_buttons', array(
   'twitter' => true,
   'facebook' => true,
   'google' => true,
   'linkedin' => true,
   'pinterest' => true,
   'xing' => true,
   'tumblr' => true,
   'vk' => true,
) );

if ( is_array( $enabled_outlets ) ) {

   $is_enabled = false;
   $buttons = array();

   foreach ( $enabled_outlets as $outlet => $enabled ) {
      if ( $enabled ) {
         $is_enabled = true;
         $buttons[] = $outlet;
      }
   }

   if ( ! $is_enabled ) return;

   echo '<nav class="share-buttons">';

   foreach ( $buttons as $outlet ) {

      $icon = $outlet;

      switch ( $outlet ) {

         case 'twitter':
            $color = '#00aced';
            $label = 'Twitter';
            $url = 'https://twitter.com/intent/tweet?text=' . get_the_title() . '&url=' . get_permalink();
            break;

         case 'facebook':
            $color = '#3B5998';
            $label = 'Facebook';
            $url = 'https://www.facebook.com/sharer/sharer.php?u=' . get_permalink();
            break;

         case 'google':
            $color = '#dd4b39';
            $label = 'Google +';
            $url = 'https://plus.google.com/share?url=' . get_permalink();
            $icon = 'gplus';
            break;

         case 'linkedin':
            $color = '#007bb6';
            $label = 'LinkedIn';
            $url = 'https://www.linkedin.com/shareArticle?mini=true&url=' . get_permalink() . '&title=' . get_the_title() . '&source=' . get_permalink();
            break;

         case 'pinterest':
            $media_url = '';
            if ( has_post_thumbnail() ) {
               $id = get_post_thumbnail_id();
               if ( $img_info = wp_get_attachment_image_src( $id, 'cv_featured_tall' ) ) {
                  $media_url = '&media=' . $img_info[0];
               }
            }
            $color = '#cb2027';
            $label = 'Pinterest';
            $url = 'https://pinterest.com/pin/create/button/?url=' . get_permalink() . '&description=' . get_the_title() . $media_url;
            break;

         case 'xing':
            $color = '#175e60';
            $label = 'Xing';
            $url = 'https://www.xing-share.com/app/user?op=share;sc_p=xing-share;url=' . get_permalink();
            break;

         case 'tumblr':
            $color = '#32506d';
            $label = 'Tumblr';
            $url = 'http://www.tumblr.com/share';
            break;

         case 'vk':
            $media_url = '';
            if ( has_post_thumbnail() ) {
               $id = get_post_thumbnail_id();
               if ( $img_info = wp_get_attachment_image_src( $id, 'cv_featured_tall' ) ) {
                  $media_url = '&image=' . $img_info[0];
               }
            }
            $color = '#5e82a8';
            $label = 'VK';
            $url = 'https://vk.com/share.php?url=' . get_permalink() . '&title=' . get_the_title() . $media_url . '&noparse=true';
            $icon = 'vkontakte';
            break;

      }

      echo '<a href="' . $url . '" style="color:' . $color . '" title="' . sprintf( __( 'Share this on %s', 'canvys' ), $label ) . '" class="no-lightbox tooltip" target="_blank"><i class="icon-' . $icon . '"></i></a>';

   }

   echo '</nav>';

}