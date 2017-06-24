<?php

if ( ! class_exists('CV_Background') ) :

/**
 * background customizer
 * used to manage the theme color scheme
 *
 * @package    WordPress
 * @subpackage Canvys
 * @since      Version 1.0
 */
class CV_Background {

   /**
    * Initially load the color scheme manager
    *
    * @return void
    */
   public function __construct() {
      add_action( 'init', array( $this, 'check_capabilities' ) );
   }

   /**
    * Make sure user can edit theme options before loading
    *
    * @return nothing
    */
   public function check_capabilities() {

      add_action('admin_init', array( $this, 'init' ) );

      // Make sure user can edit theme options
      if ( ! current_user_can('edit_theme_options') ) {
         return;
      }

      // Add the menu item
      add_action('admin_menu', array( $this, 'create_menu' ) );

      // Load required asstes
      add_action('admin_enqueue_scripts', array( $this, 'load_assets' ) );

   }

   /**
    * Initiate the administration panel
    *
    * @return nothing
    */
   public function init() {

      // Make sure the option exists
      if ( ! get_option( 'cv_background' ) ) {
         add_option( 'cv_background', cv_get_background() );
      }

      // Register the setting with its callback
      if ( method_exists( $this, 'update_background' ) ) {
         register_setting('cv_background', 'cv_background', array( $this, 'update_background' ) );
      }

   }

   /**
    * Load required assets
    *
    * @return nothing
    */
   public function load_assets( $hook ) {

      // Make sure we're on the right page
      if ( 'appearance_page_cv-background' != $hook ) {
         return;
      }

      // Admin assets directory
      $dir = THEME_DIR . 'config/background/assets/';

      // Load the media uploader scripts
      wp_enqueue_media();

      // Load theme icons stylesheet
      wp_enqueue_style( 'cv-icons', THEME_DIR . 'assets/css/icons.css' );

      // Load color scheme specific assets
      wp_enqueue_style( 'cv-background', $dir . 'background.css' );
      wp_enqueue_script( 'cv-background-manager', $dir . 'compressed/jquery.background.min.js', array('wp-color-picker') );

   }

   /**
    * Create the menu pages
    *
    * @return nothing
    */
   public function create_menu() {

      global $canvys;

      $page = add_theme_page(
         __( 'Background', 'canvys' ),
         __( 'Background', 'canvys' ),
         'edit_theme_options',
         'cv-background',
         array( $this, 'render_page' )
      );

      // Add the help tab
      add_action( 'load-' . $page, array( $this, 'render_help' ) );

   }

   /**
    * Render the color scheme manager page
    *
    * @return nothing
    */
   public static function render_page() {
      global $canvys;
      $background_settings = get_option('cv_background');

      $notification = null;
      if ( isset( $_GET['settings-updated'] ) && $_GET['settings-updated'] ) {

         // Display a saved message
         $notification  = '<div class="updated below-h2">';
         $notification .= '<p>' . sprintf( __( 'Background updated. <a href="%s">Visit your site</a> to see how it looks.', 'canvys' ), get_home_url() ) . '</p>';
         $notification .= '</div>';

      } ?>

      <div class="wrap cv-admin-page cv-admin-background">
         <h2 style="display:none;"></h2>
         <?php echo $notification; ?>
         <div id="cv-background">
            <form id="cv_background" method="post" action="options.php">

               <?php // Load WordPress required fields
               settings_errors('cv_background');
               settings_fields('cv_background'); ?>

               <!-- Preview -->
               <div id="cv-background-fullscreen-preview" class="cv-background-fullscreen-preview"></div>
               <?php $preview = new CV_HTML( '<div>', array(
                  'class' => 'cv-background-preview',
                  'id' => 'cv-background-preview',
                  'content' => '<strong class="view-full-preview visible-over-3 is-inline-block">' . __( 'View Fullscreen Preview', 'canvys' ) . '</strong>',
               ) );

               $source = $background_settings['source'];

               if ( 'custom' == $source ) {
                  $preview->add_class('is-custom');
                  $preview->css( array(
                     'background-color' => $background_settings['color'],
                     'background-image' => 'url(' . $background_settings['image'] . ')',
                  ) );
                  if ( 'tile' == $background_settings['style'] ) {
                     $preview->css( array(
                        'background-size' => '150px',
                        'background-repeat' => $background_settings['repeat'],
                        'background-position' => $background_settings['position'],
                        'background-attachment' => $background_settings['custom_attachment'],
                     ) );
                  }
                  else {
                     $preview->css( array(
                        'background-size' => 'cover',
                        'background-attachment' => 'fixed',
                     ) );
                  }
               }
               else {
                  $preview->css( array(
                     'background-image' => 'url(' . THEME_DIR . 'assets/img/patterns/' . $source . '.png)',
                     'background-attachment' => $background_settings['preset_attachment'] . ' !important',
                     'background-repeat' => 'repeat',
                  ) );
               }

               echo $preview; ?>

               <!-- Tabs -->
               <h2 id="cv-background-tabs" class="nav-tab-wrapper cv-background-tabs">
                  <?php
                     $preset_active = 'custom' != $background_settings['source'] ? ' nav-tab-active' : null;
                     $custom_active = 'custom' == $background_settings['source'] ? ' nav-tab-active' : null;
                     echo '<a class="cv-background-tab nav-tab' . $preset_active . '" data-source="presets">' . __( 'Background Presets', 'canvys' ) . '</a>';
                     echo '<a class="cv-background-tab nav-tab' . $custom_active . '" data-source="custom">' . __( 'Custom Background', 'canvys' ) . '</a>';
                  ?>
               </h2>

               <!-- Hidden radio for recorind the source value -->
               <input style="display:none;" id="cv-bg-source-custom" type="radio" name="cv_background[source]" value="custom" <?php checked( 'custom', $background_settings['source'] ); ?> />

               <div id="cv-background-panes" class="cv-background-panes">

                  <!-- Preset Backgrounds Pane -->
                  <?php $preset_active = 'custom' != $background_settings['source'] ? ' is-active' : null; ?>
                  <div id="cv-presets-pane" class="background-settings-pane presets-pane<?php echo $preset_active; ?>" data-source="presets">

                     <!-- Background Sources -->
                     <div id="cv-background-presets" class="cv-background-presets">
                        <ul class="cv-grid-5 has-clearfix spacing-1">
                           <?php foreach ( $canvys['bg_patterns'] as $preset => $title ) {
                              $url = THEME_DIR . 'assets/img/patterns/' . $preset . '.png';
                              $update_preview_data = 'data-pattern="' . $url . '"';
                              $quick_preview_style = ' style="background-image:url(' . $url . ');"';
                              $id = 'cv-bg-preset-option-' . $preset;
                              echo '<li class="background-preset-option"' . $update_preview_data . ' data-preset="' . $preset . '">';
                              echo '<input type="radio" id="' . $id . '" name="cv_background[source]" value="' . $preset . '" ' . checked( $preset, $background_settings['source'], false ) . ' />';
                              echo '<label for="' . $id . '">';
                              echo '<strong><i class="icon-circle-empty"></i><i class="icon-circle"></i>' . $title . '</strong>';
                              echo '<div class="quick-preview"' . $quick_preview_style . '></div>';
                              echo '</label>';
                              echo '</li>';
                           } ?>
                        </ul>
                     </div>

                     <?php $hidden = 'custom' == $background_settings['source'] ? ' style="display:none;"' : null; ?>
                     <div id="cv-bg-preset-attachment-wrap" class="preset-attachment-picker"<?php echo $hidden; ?>>
                        <label class="option-title" for="cv-bg-preset-attachment"><?php _e( 'Background Attachment', 'canvys' ); ?></label>
                        <select name="cv_background[preset_attachment]" id="cv-bg-preset-attachment">
                           <option value="scroll" <?php selected( 'scroll', $background_settings['preset_attachment'] ); ?>><?php _e( 'Scroll, background image will scroll with page', 'canvys' ); ?></option>
                           <option value="fixed"  <?php selected( 'fixed',  $background_settings['preset_attachment'] ); ?>><?php _e( 'Fixed, background image will remain fixed in place', 'canvys'  ); ?></option>
                        </select>
                     </div>

                  </div>

                  <!-- Custom Background Pane -->
                  <?php $custom_active = 'custom' == $background_settings['source'] ? ' is-active' : null; ?>
                  <div id="cv-custom-pane" class="background-settings-pane custom-pane<?php echo $custom_active; ?>" data-source="custom">

                     <div class="option-row cv-split-3 has-clearfix spacing-2">
                        <div>
                           <div class="option-wrap">
                              <label class="option-title"><?php _e( 'Underlying Color', 'canvys' ); ?></label>
                              <input class="wp-color-picker" type="text" name="cv_background[color]" value="<?php echo $background_settings['color']; ?>" id="cv-bg-color" />
                           </div>
                        </div>
                        <div>
                           <div class="option-wrap">
                              <label class="option-title" for="cv-bg-image"><?php _e( 'Background Image', 'canvys' ); ?></label>
                              <div class="cv-split-34-14 spacing-1 has-clearfix">
                              <div><input style="width:100%;" type="text" name="cv_background[image]" value="<?php echo $background_settings['image']; ?>" id="cv-bg-image" placeholder="<?php _e( 'Enter image URL or select an image', 'canvys' ); ?>" /></div>
                              <div><a class="button" id="cv-background-upload"><?php _e( 'Select Image', 'canvys' ); ?></a></div>
                              </div>
                           </div>
                        </div>
                        <div>
                           <?php $hidden = $background_settings['image'] ? null : ' style="display:none;"'; ?>
                           <div class="option-wrap" id="cv-bg-style-wrap"<?php echo $hidden; ?>>
                              <label class="option-title" for="cv-bg-style"><?php _e( 'Background Style', 'canvys' ); ?></label>
                              <select id="cv-bg-style" name="cv_background[style]">
                                 <option <?php selected( $background_settings['style'], 'cover' ); ?> value="cover"><?php _e( 'Automatic, background image will be scaled automatically to cover the screen', 'canvys' ); ?></option>
                                 <option <?php selected( $background_settings['style'], 'tile' ); ?> value="tile"><?php _e( 'Custom, background image can be tiled and positioned in different ways to fit the screen', 'canvys' ); ?></option>
                              </select>
                           </div>
                        </div>
                     </div>


                     <?php $hidden = 'cover' == $background_settings['style'] ? ' style="display: none;"' : null; ?>
                     <div class="option-row" id="cv-bg-custom-advanced-controls"<?php echo $hidden; ?>>
                        <div class="cv-split-3 has-clearfix spacing-2">
                           <div>
                              <div class="option-wrap">
                                 <label class="option-title" for="cv-bg-position"><?php _e( 'Background Position', 'canvys' ); ?></label>
                                 <select id="cv-bg-position" name="cv_background[position]">
                                    <?php foreach ( $canvys['bg_position_options'] as $value => $title ) : ?>
                                       <option <?php selected( $background_settings['position'], $value ); ?> value="<?php echo $value; ?>"><?php echo $title; ?></option>
                                    <?php endforeach; ?>
                                 </select>
                              </div>
                           </div>
                           <div>
                              <div class="option-wrap">
                                 <label class="option-title" for="cv-bg-repeat"><?php _e( 'Background Repeat', 'canvys' ); ?></label>
                                 <select id="cv-bg-repeat" name="cv_background[repeat]">
                                    <?php foreach ( $canvys['bg_repeat_options'] as $value => $title ) : ?>
                                       <option <?php selected( $background_settings['repeat'], $value ); ?> value="<?php echo $value; ?>"><?php echo $title; ?></option>
                                    <?php endforeach; ?>
                                 </select>
                              </div>
                           </div>
                           <div>
                              <div class="option-wrap">
                                 <label class="option-title" for="cv-bg-custom-attachment"><?php _e( 'Background Attachment', 'canvys' ); ?></label>
                                 <select name="cv_background[custom_attachment]" id="cv-bg-custom-attachment">
                                    <option value="scroll" <?php selected( 'scroll', $background_settings['custom_attachment'] ); ?>><?php _e( 'Scroll', 'canvys' ); ?></option>
                                    <option value="fixed"  <?php selected( 'fixed',  $background_settings['custom_attachment'] ); ?>><?php _e( 'Fixed', 'canvys' ); ?></option>
                                 </select>
                              </div>
                           </div>
                        </div>
                        <p class="description"><?php _e( '* Please note that the image used in the preview above is not being displayed at its actual size, it has been limited to better demonstrate the various background settings. For a more accurate representation of your background mouse over the "View Fullscreen Preview" text above, this will display a preview with the images actual size.', 'canvys' ); ?></p>
                     </div>

                  </div>

               </div>

               <!-- Color Scheme Submit Box -->
               <div id="cv-background-submit-box" class="cv-background-submit-box">
                  <input type="submit" name="submit" class="button button-primary button-large" value="<?php _e( 'Save Settings', 'canvys' ); ?>" />
               </div>

            </form>
         </div>
      </div>
   <?php }

   /**
    * Render the color scheme manager help tab
    *
    * @return nothing
    */
   public static function render_help() {

      // Grab the current screen
      $screen = get_current_screen();

   }

   /**
    * Update the customized color scheme
    *
    * @param array $input The user input
    * @return nothing
    */
   public static function update_background( $input ) {
      global $canvys;
      return array(
         'source' => cv_filter( $input['source'], array_merge( array_keys( $canvys['bg_patterns'] ), array( 'custom' ) ), 'gplaypattern' ),
         'color' => cv_filter( $input['color'], 'hex' ),
         'image' => cv_filter( $input['image'], 'url' ),
         'style' => cv_filter( $input['style'], array( 'cover', 'tile' ) ),
         'repeat' => cv_filter( $input['repeat'], array_keys( $canvys['bg_repeat_options'] ) ),
         'position' => cv_filter( $input['position'], array_keys( $canvys['bg_position_options'] ) ),
         'preset_attachment' => cv_filter( $input['preset_attachment'], array( 'scroll', 'fixed' ) ),
         'custom_attachment' => cv_filter( $input['custom_attachment'], array( 'scroll', 'fixed' ) ),
      );
   }

}
endif;