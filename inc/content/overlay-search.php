<?php

// Make sure search bar is enabled
if ( ! cv_theme_setting( 'header', 'search', true ) ) return;

$search_type = cv_theme_setting( 'header', 'search_type', 'all' );

switch ( cv_theme_setting( 'header', 'search_type', 'all' ) ) {
   case 'shop':
      // make sure woocommerce is active
      if ( ! class_exists( 'woocommerce') ) {
         $search_type = 'all';
      }
      break;
   case 'forums':
      // make sure woocommerce is active
      if ( ! class_exists( 'bbPress') ) {
         $search_type = 'all';
      }
      break;
}

?><div id="cv-overlay-search" class="cv-fullscreen-overlay overlay-search-wrap">
   <div class="overlay-content v-align-middle">
      <div class="overlay-content"><?php

         // Create the box
         $form = new CV_HTML( '<form>', array(
            'action' => home_url( '/' ),
            'method' => 'get',
            'role' => 'search',
         ) );

         $form->append( '<div class="search-form">' );

         switch ( $search_type ) {

            case 'shop':

               // Modify the form
               $form->append( '<input type="hidden" name="post_type" value="product" />' );
               $form->append( '<input type="text" name="s" value="" placeholder="' . CV_OVERLAY_SEARCH_PLACEHOLDER . '" autocomplete="off" />' );

               break;

            case 'forums':

               // grab the forums search URL
               ob_start(); bbp_search_url(); $search_url = ob_get_clean();

               // Modify the form
               $form->attr( 'action', $search_url );
               $form->append( '<input type="hidden" name="action" value="bbp-search-request" />' );
               $form->append( '<input type="text" name="bbp_search" value="" placeholder="' . CV_OVERLAY_SEARCH_PLACEHOLDER . '" autocomplete="off" />' );

               break;

            case 'portfolio':
               $form->append( '<input type="hidden" name="cv_post_type" value="portfolio_item" />' );
               $form->append( '<input type="text" name="s" value="" placeholder="' . CV_OVERLAY_SEARCH_PLACEHOLDER . '" autocomplete="off" />' );
               break;

            case 'posts':
               $form->append( '<input type="hidden" name="cv_post_type" value="post" />' );
               $form->append( '<input type="text" name="s" value="" placeholder="' . CV_OVERLAY_SEARCH_PLACEHOLDER . '" autocomplete="off" />' );
               break;

            case 'pages':
               $form->append( '<input type="hidden" name="cv_post_type" value="page" />' );
               $form->append( '<input type="text" name="s" value="" placeholder="' . CV_OVERLAY_SEARCH_PLACEHOLDER . '" autocomplete="off" />' );
               break;

            default:
               $form->append( '<input type="text" name="s" value="" placeholder="' . CV_OVERLAY_SEARCH_PLACEHOLDER . '" autocomplete="off" />' );
               break;

         }

         $form->append( '<button type="submit"><i class="icon-search"></i></button>' );

         $form->append( '</div>' );

         echo $form;

      ?></div>
   </div>
   <div class="close-button">
      <div class="wrap">
         <div class="cv-overlay-x"></div>
      </div>
   </div>
</div>