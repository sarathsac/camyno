<?php

if ( ! function_exists( 'cv_get_social_outlets' ) ) :

/**
 * Displays a list of all user social media profiles
 *
 * @return CV_HTML
 */
function cv_get_social_outlets( $requested = null ) {

   global $canvys;

   // Grab profiles, if there are any
   $profiles = cv_theme_setting( 'social', 'profiles', array() );

   // make sure there is at least one profile to show
   if ( ! is_array( $profiles ) || empty( $profiles ) ) {
      return false;
   }

   $o = new CV_HTML( '<ul>', array(
      'class' => 'cv-social-profiles',
   ) );

   $target_attr = cv_theme_setting( 'social', 'new_window' ) ? ' target="_blank"' : null;

   foreach ( $profiles as $outlet => $url ) {

      // Make sure there is a URL
      if ( ! $url ) {
         continue;
      }

      // Check if specific outlets have been requested
      if ( is_array( $requested ) && ! in_array( $outlet, $requested ) ) {
         continue;
      }

      // Create the profile
      $profile  = '<li class="social-profile">';
      $profile .= '<a class="no-lightbox" href="' . $url . '"' . $target_attr . '>';
      $profile .= '<i class="icon-' . $outlet . '"></i> ';
      $profile .= '<span>' . $canvys['social_outlets'][$outlet] . '</span>';
      $profile .= '</a></li>';

      // Add the profile
      $o->append( $profile );

   }

   // Make sure atleast one outlet has been added
   if ( ! $o->content ) return false;

   return $o;

}
endif;

if ( ! class_exists('CV_Social_Settings') ) :

/**
 * Social media settings page
 *
 * @package    WordPress
 * @subpackage Canvys
 * @since      Version 1.0
 */
class CV_Social_Settings extends CV_Settings_Page {

   /**
    * Function to create page configuration
    *
    * @return void
    */
   public function __construct() {

      global $canvys;

      $this->config = array(
         'tab_title' => __( 'Social', 'canvys' ),
         'slug' => 'social',
         'priority' => 30,
         'defaults' => array(
            'share_buttons' => true,
            'enabled_share_buttons' => array(
               'twitter' => true,
               'facebook' => true,
               'google' => true,
               'linkedin' => true,
               'pinterest' => true,
               'tumblr' => true,
            ),
            'new_window' => false,
            'profiles' => array(),
         ),
      );

   }

   /**
    * Loading additional styles to the settings page
    *
    * @return void
    */
   public function additional_styles() { ?>
      <style id="cv-theme-settings-social-style">
         .share-button-option {
            padding-bottom: 0 !important;
         }
         .share-button-option label {
            display: block;
            padding: 15px 10px;
            background: #f9f9f9;
            margin-bottom: 10px;
            -webkit-transition: all 0.25s ease;
            -moz-transition: all 0.25s ease;
            -ms-transition: all 0.25s ease;
            -o-transition: all 0.25s ease;
            transition: all 0.25s ease;
            -webkit-border-radius: 3px;
            border-radius: 3px;
         }
         .option-wrap:hover .share-button-option label {
            background: #fff;
         }
         #cv-social-profiles-container {
            background: #ddd;
            -webkit-box-shadow: inset rgba(0,0,0,0.05) 0px 0px 5px 5px;
            -moz-box-shadow: inset rgba(0,0,0,0.05) 0px 0px 5px 5px;
            box-shadow: inset rgba(0,0,0,0.05) 0px 0px 5px 5px;
         }
         .social-profile {
            position: relative;
            background: #fff;
            cursor: move;
         }
         .social-profile .option-title {
            display: inline-block !important;
         }
         .social-profile.cv-dragging {
            border-top: 1px solid #ddd;
            border-right: 1px solid #ddd;
            -webkit-box-shadow: rgba(0,0,0,0.05) 0px 0px 5px 5px;
            -moz-box-shadow: rgba(0,0,0,0.05) 0px 0px 5px 5px;
            box-shadow: rgba(0,0,0,0.05) 0px 0px 5px 5px;
         }
         .social-profile .delete-profile {
            position: absolute;
            top: 0;
            height: 25px; width: 25px;
            line-height: 25px;
            background: #999; color: #fff;
            text-align: center;
            -webkit-transition: all 0.25s ease;
            -moz-transition: all 0.25s ease;
            transition: all 0.25s ease;
         }
         .social-profile:hover .delete-profile {
            background: #777;
         }
         .social-profile:hover .delete-profile:hover {
            background: #C93A2A;
         }
         html:not([dir="rtl"]) .social-profile .delete-profile { right: 0; }
         html[dir="rtl"] .social-profile .delete-profile { left: 0; }
      </style>
   <?php }

   /**
    * Loading additional scripts to the settings page
    *
    * @return void
    */
   public function additional_scripts() {

      // Load jQuery sorting
      wp_enqueue_script( 'jquery-ui-sortable' );

      ?><script id="cv-theme-settings-general-script">
         (function($) {
            $(document).ready( function() {

               // Show/hide available share buttons
               $('#social-share_buttons').change( function(e) {
                  var $this = $(this), $enabledButtons  = $('#social-enabled-buttons-wrap');
                  if ( $this.prop('checked') ) {
                     $enabledButtons.slideDown();
                     if ( e.originalEvent !== undefined ) {
                        $enabledButtons.find('input').prop('checked', true);
                     }
                  }
                  else {
                     $enabledButtons.slideUp();
                     $enabledButtons.find('input').prop('checked', false);
                  }
               }).trigger('change');

               // Allow profiles to be sortable
               var $socialProfiles = $('#cv-social-profiles-container');
               $socialProfiles.sortable({
                  helper: 'clone',
                  appendTo: 'parent',
                  start: function( e, ui ) {
                     ui.helper.addClass('cv-dragging');
                  },
                  stop: function( e, ui ) {
                     ui.helper.removeClass('cv-dragging');
                  },
               });

               // Adding a new social profile
               $('#cv-new-profile-outlet').on( 'change', function() {
                  var $this = $(this), outlet = $this.val();

                  // Grab the outlet title
                  var title = $this.find('[value="'+outlet+'"]').text();

                  // Disable the option
                  $this.find('[value="'+outlet+'"]').prop('disabled', true);

                  // Reset to none
                  $this.val('none');

                  // grab the profile template
                  var $profile = $( $('#tmpl-cv-theme-settings-social_profile').html() );
                  $profile.attr( 'data-outlet', outlet );

                  // Add the icon/title
                  $profile.find('.option-title i').attr('class', 'icon-'+outlet).after(' '+title);

                  // Add the ID/for attributes
                  var id = 'social-profile-'+outlet;
                  $profile.find('.option-title').attr('for',id);
                  $profile.find('input').attr('id',id);

                  // Add the name attribute
                  var name = 'cv_theme_settings[social][profiles]['+outlet+']';
                  $profile.find('input').attr('name',name);

                  // Modify the description
                  var description = $profile.find('.option-description').text().replace( '%s', title );
                  $profile.find('.option-description').html(description);

                  // Add the new profile
                  $socialProfiles.css('height', 'auto' ).prepend( $profile.hide() );
                  $profile.slideDown( function() {
                     $socialProfiles.css('height', $socialProfiles.height() );
                     $profile.find('input').trigger('focus');
                  });

               });

               // Deleting a social profile
               $socialProfiles.on( 'click', '.delete-profile', function() {
                  var outlet = $(this).parent().data('outlet');
                  $('#cv-new-profile-outlet').find('[value="'+outlet+'"]').prop('disabled', false);
                  $socialProfiles.css('height', 'auto');
                  $(this).parent().slideUp( function() {
                     $socialProfiles.css('height', $socialProfiles.height() );
                     $(this).remove();
                  });
               });

            });
         })(jQuery);
      </script>
      <script id="tmpl-cv-theme-settings-social_profile" type="text/html">
         <div class="option-wrap social-profile">
            <label class="option-title"><i></i></label>
            <input type="text" class="widefat" placeholder="http://" />
            <p class="option-description"><?php _e( 'Enter your full %s URL.', 'canvys' ); ?></p>
            <a class="delete-profile" title="<?php _e( 'Delete Profile', 'canvys' ); ?>"><i class="icon-cancel"></i></a>
         </div>
      </script>
   <?php }

   /**
    * Rendering the inner page
    *
    * @param array $input The user specified input
    * @return void
    */
   public function render_inner_page( $input ) {
      global $canvys;
      $name = 'cv_theme_settings[' . $this->config['slug'] . ']';
      $input = $this->extract_input( $input ); ?>

      <div class="option-wrap">
         <strong class="option-title"><?php _e( 'Share Buttons', 'canvys' ); ?></strong>
         <label for="social-share_buttons">
            <input type="checkbox" id="social-share_buttons" value="1" <?php checked( $input['share_buttons'] ); ?> name="<?php echo $name; ?>[share_buttons]" />
            <span><?php _e( 'Display share buttons for various social media outlets.', 'canvys' ); ?></span>
         </label>

         <div id="social-enabled-buttons-wrap">

            <div class="option-spacer"></div>

            <strong class="option-title"><?php _e( 'Enabled Share Buttons', 'canvys' ); ?></strong>
            <div class="cv-grid-3 spacing-1 has-clearfix">
               <?php foreach ( $canvys['share_buttons'] as $outlet => $title ) : ?>
                  <div class="share-button-option">
                     <label for="social-enabled_share_buttons-<?php echo $outlet; ?>">
                        <input type="checkbox" id="social-enabled_share_buttons-<?php echo $outlet; ?>" value="1" <?php checked( $input['enabled_share_buttons'][$outlet] ); ?> name="<?php echo $name; ?>[enabled_share_buttons][<?php echo $outlet; ?>]" />
                        <?php echo $title; ?>
                     </label>
                  </div>
               <?php endforeach; ?>
            </div>
         </div>
      </div>

      <div class="option-wrap">
         <strong class="option-title"><?php _e( 'Social Media Profiles', 'canvys' ); ?></strong>
         <p class="option-description"><?php _e( 'Create a list of your social media profiles which can then be displayed in different ways throughout your website, just add at least one profile below and you\'ll be able to display your social media prescence all over your website.', 'canvys' ); ?></p>
         <p>
            <select id="cv-new-profile-outlet" style="min-width:175px;">
               <option value="none"><?php _e( 'Select an outlet', 'canvys' ); ?></option>
               <?php foreach ( $canvys['social_outlets'] as $slug => $outlet ) : ?>
                  <?php $disabled = is_array( $input['profiles'] ) && array_key_exists( $slug, $input['profiles'] ) ? ' disabled' : null; ?>
                  <option value="<?php echo $slug; ?>"<?php echo $disabled; ?>><?php echo $outlet; ?></option>
               <?php endforeach; ?>
            </select>
         </p>

         <div class="option-spacer"></div>

         <strong class="option-title"><?php _e( 'Open Social Links In New Window', 'canvys' ); ?></strong>
         <label for="social-new_window">
            <input type="checkbox" id="social-new_window" value="1" <?php checked( $input['new_window'] ); ?> name="<?php echo $name; ?>[new_window]" />
            <span><?php _e( 'Open all social media links in a new window/tab.', 'canvys' ); ?></span>
         </label>
      </div>

      <div id="cv-social-profiles-container">
         <?php if ( is_array( $input['profiles'] ) && ! empty( $input['profiles'] ) ) : ?>
            <?php foreach ( $input['profiles'] as $outlet => $url ) : ?>
               <div class="option-wrap social-profile" data-outlet="<?php echo $outlet; ?>">
                  <label class="option-title" for="social-profile-<?php echo $outlet; ?>"><i class="icon-<?php echo $outlet; ?>"></i> <?php echo $canvys['social_outlets'][$outlet]; ?></label>
                  <input placeholder="http://" id="social-profile-<?php echo $outlet; ?>"type="text" class="widefat" name="<?php echo $name; ?>[profiles][<?php echo $outlet; ?>]" value="<?php echo $url; ?>" />
                  <p class="option-description"><?php printf( __( 'Enter your full %s URL.', 'canvys' ), $canvys['social_outlets'][$outlet] ); ?></p>
                  <a class="delete-profile" title="<?php _e( 'Delete Profile', 'canvys' ); ?>"><i class="icon-cancel"></i></a>
               </div>
            <?php endforeach; ?>
         <?php endif; ?>
      </div>

   <?php }

   /**
    * Sanitizing the page specific input
    *
    * @param array $input The user specified input
    * @return array
    */
   public static function sanitize_input( $input ) {

      global $canvys;

      $clean_shares = array();
      foreach ( array_keys( $canvys['share_buttons'] ) as $outlet ) {
         $clean_shares[$outlet] = isset( $input['enabled_share_buttons'][$outlet] ) && $input['enabled_share_buttons'][$outlet] ? true : false;
      }

      /* Sanitize social profiles */
      $clean_profiles = array();
      if ( isset( $input['profiles'] ) && is_array( $input['profiles'] ) ) {
         foreach ( $input['profiles'] as $outlet => $url ) {
            $clean_profiles[$outlet] = cv_filter( $url, 'url' );
         }
      }

      return array(
         'share_buttons' => isset( $input['share_buttons'] ) && $input['share_buttons'] ? true : false,
         'new_window' => isset( $input['new_window'] ) && $input['new_window'] ? true : false,
         'enabled_share_buttons' => $clean_shares,
         'profiles' => $clean_profiles,
      );

      return $input;

   }

}
endif;