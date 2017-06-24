<?php

if ( ! class_exists('CV_Footer_Settings') ) :

/**
 * Footer settings page
 *
 * @package    WordPress
 * @subpackage Canvys
 * @since      Version 1.0
 */
class CV_Footer_Settings extends CV_Settings_Page {

   /**
    * Function to create page configuration
    *
    * @return void
    */
   public function __construct() {

      global $canvys;

      $this->config = array(
         'tab_title' => __( 'Footer', 'canvys' ),
         'slug' => 'footer',
         'priority' => 90,
         'defaults' => array(
            'bread_crumbs'       => true,
            'enable_socket'      => true,
            'socket_layout'      => 'inline',
            'socket_text'        => null,
            'socket_attribution' => false,
            'socket_menu'        => true,
            'social_outlets'     => null,
            'enable_widgets'     => false,
            'layout'             => '13',
         ),
      );

   }

   /**
    * Loading additional styles to the settings page
    *
    * @return void
    */
   public function additional_styles() { ?>
      <style id="cv-theme-settings-footer-style">
         .footer-layout .footer-layout-option label,
         .footer-layout .footer-layout-option .column {
            -webkit-transition: all 0.15s ease;
            -moz-transition: all 0.15s ease;
            -ms-transition: all 0.15s ease;
            -o-transition: all 0.15s ease;
            transition: all 0.15s ease;
         }

         .footer-layout .footer-layout-option .column {
            -webkit-border-radius: 3px !important;
            border-radius: 3px !important;
            background: #eee;
            text-align: center;
            letter-spacing: 2px;
            font-weight: 600;
            color: #888;
            text-shadow: #fff 0px 1px 2px;
            padding: 15px 0;
         }
         .footer-layout .footer-layout-option input {
            display: none
         }
         .footer-layout .footer-layout-option label {
            display: block;
            padding: 10px;
            margin: 5px 0;
            background: transparent;
            border: 1px solid transparent;
            -webkit-border-radius: 3px !important;
            border-radius: 3px !important;
         }
         .footer-layout .footer-layout-option input:checked + label {
            border: 1px solid #A2D164;
            background: #F0F7E6;
         }
         .footer-layout .footer-layout-option label:hover .column {
            text-shadow: none;
            background: #777;
            color: #fff;
         }
         .footer-layout .footer-layout-option input:checked + label .column {
            text-shadow: #111 0px 1px 2px;
            background: #666;
            color: #fff;
         }
      </style>
   <?php }

   /**
    * Loading additional scripts to the settings page
    *
    * @return void
    */
   public function additional_scripts() { ?>
      <script id="cv-theme-settings-footer-script">
         (function($) {
            $(document).ready( function() {
               $('#footer-enable_widgets').change( function() {
                  var $this = $(this), $layoutControl  = $this.closest('.option-wrap').next();
                  if ( $this.prop('checked') ) {
                     $layoutControl.slideDown();
                  }
                  else {
                     $layoutControl.slideUp().find('#footer-layout-option-13').prop('checked', true);
                  }
               }).trigger('change');
               $('#footer-enable_socket').change( function() {
                  var $this = $(this), $socketControls  = $this.closest('.option-wrap').next();
                  if ( $this.prop('checked') ) {
                     $socketControls.slideDown();
                  }
                  else {
                     $socketControls.slideUp();
                     $socketControls.find('input[type="text"]').val('');
                     $socketControls.find('input[type="checkbox"]').prop( 'checked', true );
                  }
               }).trigger('change');
            });
         })(jQuery);
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
         <strong class="option-title"><?php _e( 'Bread Crumbs', 'canvys' ); ?></strong>
         <label for="footer-bread_crumbs">
            <input type="checkbox" id="footer-bread_crumbs" value="1" <?php checked( $input['bread_crumbs'] ); ?> name="<?php echo $name; ?>[bread_crumbs]" />
            <span><?php _e( 'Display bread crumbs just above the footer/socket area.', 'canvys' ); ?></span>
         </label>
      </div>

      <div class="option-wrap">
         <strong class="option-title"><?php _e( 'Footer Socket', 'canvys' ); ?></strong>
         <label for="footer-enable_socket">
            <input type="checkbox" id="footer-enable_socket" value="1" <?php checked( $input['enable_socket'] ); ?> name="<?php echo $name; ?>[enable_socket]" />
            <span><?php _e( 'Display the socket area, which is immediately below the footer.', 'canvys' ); ?></span>
         </label>
      </div>

      <div class="option-wrap">

         <label class="option-title" for="footer-socket_layout"><?php _e( 'Socket Layout', 'canvys' ); ?></label>
         <select name="<?php echo $name; ?>[socket_layout]" id="footer-socket_layout">
            <option value="inline" <?php selected( $input['socket_layout'], 'inline' ); ?>><?php _e( 'Inline, all content dislpayed on one line', 'canvys' ); ?></option>
            <option value="centered" <?php selected( $input['socket_layout'], 'centered' ); ?>><?php _e( 'Centered, all content displayed on multiple lines', 'canvys' ); ?></option>
         </select>
         <p class="option-description"><?php _e( 'Specify the layout to use for the socket area.', 'canvys' ); ?></p>

         <div class="option-spacer"></div>

         <label for="footer-socket_text" class="option-title"><?php _e( 'Socket Text', 'canvys' ); ?></label>
         <input type="text" class="widefat" id="footer-socket_text" value="<?php echo $input['socket_text']; ?>" name="<?php echo $name; ?>[socket_text]" placeholder="<?php echo '&copy; ' . date("Y") . ' - ' . get_bloginfo('name'); ?>" />
         <p class="option-description"><?php printf( __( 'Usually copyright information such as %s.', 'canvys' ), '<strong>&copy; ' . date("Y") . ' - ' . get_bloginfo('name') . '</strong>' ); ?></p>

         <div class="option-spacer"></div>

         <strong class="option-title"><?php _e( 'Socket Menu', 'canvys' ); ?></strong>
         <label for="footer-socket_menu">
            <input type="checkbox" id="footer-socket_menu" value="1" <?php checked( $input['socket_menu'] ); ?> name="<?php echo $name; ?>[socket_menu]" />
            <span><?php printf( __( 'Display a menu in the socket area, menu can be chosen/edited <a href="%s">here</a> after theme settings have been saved.', 'canvys' ), admin_url( 'nav-menus.php' ) ); ?></span>
         </label>

         <div class="option-spacer"></div>

         <strong class="option-title"><?php _e( 'Socket Attribution', 'canvys' ); ?></strong>
         <label for="footer-socket_attribution">
            <input type="checkbox" id="footer-socket_attribution" value="1" <?php checked( $input['socket_attribution'] ); ?> name="<?php echo $name; ?>[socket_attribution]" />
            <span><?php _e( 'Hide the Themefyre attribution text in the socket area.', 'canvys' ); ?></span>
         </label>

         <div class="option-spacer"></div>

         <label class="option-title"><?php _e( 'Socket Social Media Outlets', 'canvys' ); ?></label>
         <?php $saved_social_outlets = cv_theme_setting( 'social', 'profiles' ); ?>
         <?php if ( ! empty( $saved_social_outlets ) ) : ?>
            <select class="widefat" style="height:150px;" id="footer-social_outlets" name="<?php echo $name; ?>[social_outlets][]" multiple>
            <?php foreach ( $saved_social_outlets as $outlet => $url ) {
               if ( ! $url ) continue;
               $saved_value = is_array( $input['social_outlets'] ) ? $input['social_outlets'] : array();
               echo '<option value="' . $outlet . '" ' . selected( in_array( $outlet, $saved_value ), true, 0 ) . '>' . $canvys['social_outlets'][$outlet] . '</option>';
            } ?>
            </select>
            <p class="option-description"><?php _e( 'Select which of your saved social media outlets, if any, should be displayed in the socket area.', 'canvys' ); ?></p>
         <?php else : ?>
            <p class="option-description additional-message info-message"><?php _e( 'You don\'t have any saved social media outlets. To set some up navigate to the social tab, follow the instructions and save changes.', 'canvys' ); ?></p>
         <?php endif; ?>

      </div>

      <div class="option-wrap">
         <strong class="option-title"><?php _e( 'Widgetized Columns', 'canvys' ); ?></strong>
         <label for="footer-enable_widgets">
            <input type="checkbox" id="footer-enable_widgets" value="1" <?php checked( $input['enable_widgets'] ); ?> name="<?php echo $name; ?>[enable_widgets]" />
            <span><?php _e( 'Enable the widgetized columns in the footer, you will be able to control the layout below.', 'canvys' ); ?></span>
         </label>
      </div>

      <div class="option-wrap footer-layout">
         <strong class="option-title"><?php _e( 'Footer Column Layout', 'canvys' ); ?></strong>
         <?php

            echo '<strong style="display:block;margin:10px 0;text-align:center;font-weight:200;">' . __( '1 Column', 'canvys' ) . '</strong>';

            echo '<div class="footer-layout-option">';
            echo '<input ' . checked( 'single', $input['layout'], false ) . ' type="radio" id="footer-layout-option-single" name="' . $name . '[layout]" value="single" />';
            echo '<label for="footer-layout-option-single">';
            echo '<div class="column">100%</div>';
            echo '</label>';
            echo '</div>';

            $last_num_columns = '2';
            echo '<strong style="display:block;margin:10px 0;text-align:center;font-weight:200;">' . __( '2 Columns', 'canvys' ) . '</strong>';

            foreach ( $canvys['column_layouts'] as $layout => $description ) {

               // Turn description into an array
               $description = explode( ' - ', $description );

               // Make layout into a usable value
               $layout = str_replace( array('/', '+'), array('', '-'), $layout );
               $layout_value = $layout;

               // Determine number of columns
               switch ( $layout ) {
                  case '12': $num_columns = 2; $layout = '2'; break;
                  case '13': $num_columns = 3; $layout = '3'; break;
                  case '14': $num_columns = 4; $layout = '4'; break;
                  case '15': $num_columns = 5; $layout = '5'; break;
                  case '16': $num_columns = 6; $layout = '6'; break;
                  default: $num_columns = count( explode( '-', $layout ) ); break;
               }

               if ( $num_columns != $last_num_columns ) {
                  $last_num_columns = $num_columns;
                  echo '<strong style="display:block;margin:10px 0;text-align:center;font-weight:200;">' . sprintf( __( '%s Columns', 'canvys' ), $num_columns ) . '</strong>';
               }

               echo '<div class="footer-layout-option">';
               echo '<input ' . checked( $layout_value, $input['layout'], false ) . ' type="radio" id="footer-layout-option-' . $layout_value . '" name="' . $name . '[layout]" value="' . $layout_value . '" />';
               echo '<label for="footer-layout-option-' . $layout_value . '">';
               echo '<div class="cv-split-' . $layout . ' has-clearfix spacing-1 not-responsive">';

               // Display the columns
               for ( $i=0; $i<$num_columns; $i++ ) {
                  $sizes = explode( '/', $description[$i] );
                  $size = round( ( $sizes[0] / $sizes[1] ), 3 );
                  $size = $size*100 . '%';
                  echo '<div>';
                  echo '<div class="column">' . $size . '</div>';
                  echo '</div>';
               }

               echo '</div>';
               echo '</label>';
               echo '</div>';

            }

         ?>
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
      $allowed_layouts = array('single');
      foreach ( $canvys['column_layouts'] as $layout => $description ) {
         $allowed_layouts[] = str_replace( array('/', '+'), array('', '-'), $layout );
      }
      return array(
         'bread_crumbs'       => isset( $input['bread_crumbs'] ) && $input['bread_crumbs'] ? true : false,
         'enable_socket'      => isset( $input['enable_socket'] ) && $input['enable_socket'] ? true : false,
         'socket_layout'      => isset( $input['socket_layout'] ) ? cv_filter( $input['socket_layout'], array( 'inline', 'centered' ) ) : 'inline',
         'socket_text'        => isset( $input['socket_text'] ) ? cv_filter( $input['socket_text'], 'text' ) : null,
         'socket_menu'        => isset( $input['socket_menu'] ) && $input['socket_menu'] ? true : false,
         'socket_attribution' => isset( $input['socket_attribution'] ) && $input['socket_attribution'] ? true : false,
         'social_outlets'     => isset( $input['social_outlets'] ) ? $input['social_outlets'] : null,
         'enable_widgets'     => isset( $input['enable_widgets'] ) && $input['enable_widgets'] ? true : false,
         'layout'             => isset( $input['layout'] ) ? cv_filter( $input['layout'], $allowed_layouts, '13' ) : '13',
      );
   }

}
endif;