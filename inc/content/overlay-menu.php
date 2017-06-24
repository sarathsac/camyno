<?php

if ( cv_theme_setting( 'general', 'disable_responsive' ) ) return;

// Determine which menu location to show
$location = is_user_logged_in() && has_nav_menu('overlay_menu_user') ? 'overlay_menu_user' : 'overlay_menu';

// Grab the menu
$menu = wp_nav_menu( array(
   'theme_location' => $location,
   'fallback_cb'    => 'cv_default_overlay_menu',
   'container'      => false,
   'echo'           => false,
   'depth'          => 3,
   'menu_class'     => 'overlay-menu menu',
) );

?><div id="cv-overlay-menu" class="cv-fullscreen-overlay overlay-menu-wrap">
   <div class="overlay-content v-align-middle">
      <div class="overlay-content">
         <?php echo $menu; ?>
      </div>
   </div>
   <div class="close-button">
      <div class="cv-overlay-x"></div>
   </div>
</div>