<?php

global $canvys;

/**
 * The framework for our theme
 *
 * @package    WordPress
 * @subpackage Canvys
 * @since      Version 1.0
 */



// Setup the theme
add_action( 'after_setup_theme', 'cv_framework_setup' );

if ( ! function_exists( 'cv_framework_setup' ) ) :

/**
 * Load the theme and all of its assets
 *
 * This function will do all of the following:
 * - Load required files from all directories
 *
 * @return void
 */
function cv_framework_setup() {

   global $canvys;

   // Define variables
   $theme_name = 'Camyno';
   $theme_widget_name = '(' . $theme_name . ')';
   $theme_slug = str_replace( ' ', '', strtolower( $theme_name ) );
   $theme_ver  = 3.2;

   // Global theme name, only defined once
   define( 'THEME_NAME', $theme_name );
   $canvys['theme_name'] = $theme_name;

   // Global theme name in widget titles
   define( 'THEME_WIDGET_NAME', $theme_widget_name );
   $canvys['theme_widget_name'] = $theme_widget_name;

   // Global theme slug, only defined once
   define( 'THEME_SLUG', $theme_slug );
   $canvys['theme_slug'] = $theme_slug;

   // Global theme version
   define( 'THEME_VER', $theme_ver );
   $canvys['theme_ver'] = $theme_ver;

   // Global theme directory
   define( 'THEME_DIR', trailingslashit( get_template_directory_uri() ) );

   // Global theme PHP path
   define( 'THEME_PATH', trailingslashit( dirname(__FILE__) ) );

   // Global theme plugins config directory
   define( 'THEME_PLUGIN_DIR', THEME_DIR . 'config/plugins/' );

   // General required files
   include dirname(__FILE__) . '/inc/animations.php';
   include dirname(__FILE__) . '/inc/assets.php';
   include dirname(__FILE__) . '/inc/class-html.php';
   include dirname(__FILE__) . '/inc/conditionals.php';
   include dirname(__FILE__) . '/inc/custom-menus.php';
   include dirname(__FILE__) . '/inc/dynamic-styles.php';
   include dirname(__FILE__) . '/inc/editor-style.php';
   include dirname(__FILE__) . '/inc/frontend.php';
   include dirname(__FILE__) . '/inc/globals.php';
   include dirname(__FILE__) . '/inc/helpers.php';
   include dirname(__FILE__) . '/inc/localization.php';
   include dirname(__FILE__) . '/inc/static-text.php';
   include dirname(__FILE__) . '/inc/style.php';
   include dirname(__FILE__) . '/inc/typography.php';
   include dirname(__FILE__) . '/inc/validation.php';
   include dirname(__FILE__) . '/inc/widgets.php';

   // Include plugin config
   include dirname(__FILE__) . '/inc/plugins/class-tgm-plugin-activation.php';
   include dirname(__FILE__) . '/inc/plugins/register-plugins.php';

   // Include widgets config
   include dirname(__FILE__) . '/inc/widgets/google-map.php';
   include dirname(__FILE__) . '/inc/widgets/qr-code.php';
   include dirname(__FILE__) . '/inc/widgets/recent-portfolio.php';
   include dirname(__FILE__) . '/inc/widgets/recent-posts.php';
   include dirname(__FILE__) . '/inc/widgets/social-media.php';
   include dirname(__FILE__) . '/inc/widgets/twitter-rss.php';

   // Include settings config
   include dirname(__FILE__) . '/config/theme-settings/class-settings-page.php';
   include dirname(__FILE__) . '/config/theme-settings/class-theme-settings.php';
   include dirname(__FILE__) . '/config/theme-settings/dynamic-styles.php';
   include dirname(__FILE__) . '/config/theme-settings/config.php';

   // Include banner settings config
   include dirname(__FILE__) . '/config/banner-settings/assets.php';
   include dirname(__FILE__) . '/config/banner-settings/register.php';
   include dirname(__FILE__) . '/config/banner-settings/render.php';
   include dirname(__FILE__) . '/config/banner-settings/update.php';
   include dirname(__FILE__) . '/config/banner-settings/config.php';

   // Include page settings config
   include dirname(__FILE__) . '/config/page-settings/assets.php';
   include dirname(__FILE__) . '/config/page-settings/register.php';
   include dirname(__FILE__) . '/config/page-settings/render.php';
   include dirname(__FILE__) . '/config/page-settings/update.php';
   include dirname(__FILE__) . '/config/page-settings/config.php';

   // Include color scheme editor
   include dirname(__FILE__) . '/config/color-scheme/class-color-scheme.php';
   include dirname(__FILE__) . '/config/color-scheme/register-schemes.php';
   include dirname(__FILE__) . '/config/color-scheme/dynamic-styles.php';
   include dirname(__FILE__) . '/config/color-scheme/config.php';

   // Include widget areas config
   include dirname(__FILE__) . '/config/widget-areas/class-sidebar-manager.php';
   include dirname(__FILE__) . '/config/widget-areas/get-sidebars.php';
   include dirname(__FILE__) . '/config/widget-areas/register-widget-areas.php';
   include dirname(__FILE__) . '/config/widget-areas/config.php';

   // Include portfolio config
   include dirname(__FILE__) . '/config/portfolio/config.php';

   // Include shortcodes config
   include dirname(__FILE__) . '/config/shortcodes/class-shortcode-control.php';
   include dirname(__FILE__) . '/config/shortcodes/class-shortcode.php';
   include dirname(__FILE__) . '/config/shortcodes/shortcode-regex.php';
   include dirname(__FILE__) . '/config/shortcodes/config.php';

   // Add support for post formats
   if ( ! cv_theme_setting( 'blog', 'disable_formats' ) ) {
      include dirname(__FILE__) . '/config/post-formats/class-format-settings.php';
      include dirname(__FILE__) . '/config/post-formats/config.php';
   }

   // Add the background customizer, if applicable
   if ( 'free' != cv_theme_setting( 'visual', 'container_layout', 'free' ) ) {
      include dirname(__FILE__) . '/config/background/class-background.php';
      include dirname(__FILE__) . '/config/background/dynamic-styles.php';
      include dirname(__FILE__) . '/config/background/config.php';
   }

   // Include LayerSlider Integration
   if ( class_exists('LS_Sliders') ) {
      include dirname(__FILE__) . '/config/plugins/layerslider/class-fullscreen-layerslider.php';
      include dirname(__FILE__) . '/config/plugins/layerslider/class-layerslider.php';
      include dirname(__FILE__) . '/config/plugins/layerslider/config.php';
   }

   // Include Events Calendar Integration
   if ( class_exists('TribeEvents') ) {
      include dirname(__FILE__) . '/config/plugins/events-calendar/modify-theme.php';
      include dirname(__FILE__) . '/config/plugins/events-calendar/dynamic-styles.php';
      include dirname(__FILE__) . '/config/plugins/events-calendar/config.php';
   }

   // Include Contact Form 7 Integration
   if ( class_exists( 'WPCF7_ContactForm') ) {
      include dirname(__FILE__) . '/config/plugins/contact-form-7/class-contact-form-7.php';
      include dirname(__FILE__) . '/config/plugins/contact-form-7/config.php';
   }

   // Include Gravity Forms Integration
   if ( class_exists( 'GFForms') ) {
      include dirname(__FILE__) . '/config/plugins/gravity-forms/class-gravity-form.php';
      include dirname(__FILE__) . '/config/plugins/gravity-forms/dynamic-styles.php';
      include dirname(__FILE__) . '/config/plugins/gravity-forms/config.php';
   }

   // Include WooCommerce Integration
   if ( class_exists( 'woocommerce') ) {
      include dirname(__FILE__) . '/config/plugins/woocommerce/add-actions.php';
      include dirname(__FILE__) . '/config/plugins/woocommerce/assets.php';
      include dirname(__FILE__) . '/config/plugins/woocommerce/cart-button.php';
      include dirname(__FILE__) . '/config/plugins/woocommerce/dynamic-styles.php';
      include dirname(__FILE__) . '/config/plugins/woocommerce/modify-actions.php';
      include dirname(__FILE__) . '/config/plugins/woocommerce/modify-theme.php';
      include dirname(__FILE__) . '/config/plugins/woocommerce/settings-page.php';
      include dirname(__FILE__) . '/config/plugins/woocommerce/config.php';
   }

   // Include bbPress Integration
   if ( class_exists( 'bbPress') ) {
      include dirname(__FILE__) . '/config/plugins/bbpress/dynamic-styles.php';
      include dirname(__FILE__) . '/config/plugins/bbpress/modify-theme.php';
      include dirname(__FILE__) . '/config/plugins/bbpress/settings-page.php';
      include dirname(__FILE__) . '/config/plugins/bbpress/config.php';
   }

   // Include Administration Configuration
   if ( is_admin() ) {
      include dirname(__FILE__) . '/config/shortcode-composer/class-shortcode-composer.php';
      include dirname(__FILE__) . '/config/shortcode-composer/config.php';
      include dirname(__FILE__) . '/config/template-builder/class-template-builder.php';
      include dirname(__FILE__) . '/config/template-builder/config.php';
   }

}
endif;

if ( ! function_exists( 'cv_theme_setting' ) ) :

/**
 * Grabs a value from the themes settings
 *
 * @param string $category The slug of the page which contains the option
 * @param string $dirs The slug of the setting to grab
 * @param mixed $fallback The fallback value if the setting is not found
 * @return mixed
 */
function cv_theme_setting( $category, $id, $fallback = null ) {
   $settings = get_option( 'cv_theme_settings' );
   $value = isset( $settings[$category][$id] ) ? $settings[$category][$id] : $fallback;
   return apply_filters( 'cv_theme_setting_' . $category . '_' . $id, $value );
}
endif;