<?php

// Make sure bar is active
if ( ! cv_is_additional_bar_active() ) return;

// Make sure responsiveness is enabled
if ( cv_theme_setting( 'general', 'disable_responsive' ) ) return;

?><div id="cv-overlay-additional" class="cv-fullscreen-overlay overlay-additional-wrap">
   <div class="overlay-content v-align-middle">
      <div class="overlay-content">
         <?php get_template_part( 'inc/content/additional-bar' ); ?>
      </div>
   </div>
   <div class="close-button">
      <div class="cv-overlay-x"></div>
   </div>
</div>