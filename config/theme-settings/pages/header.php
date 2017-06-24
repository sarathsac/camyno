<?php

if ( ! class_exists('CV_Header_Settings') ) :

/**
 * Header settings page
 *
 * @package    WordPress
 * @subpackage Canvys
 * @since      Version 1.0
 */
class CV_Header_Settings extends CV_Settings_Page {

   /**
    * Function to create page configuration
    *
    * @return void
    */
   public function __construct() {

      global $canvys;

      $this->config = array(
         'tab_title' => __( 'Header', 'canvys' ),
         'slug' => 'header',
         'priority' => 50,
         'defaults' => array(

            /* General settings */
            'logo'                 => null,
            'alignment'            => 'left',

            /* Styling Settings */
            'menu_style'           => 'dropdown',
            'enable_sticky'        => true,
            'enable_collapse'      => true,
            'enable_border'        => true,
            'enable_shadow'        => true,
            'enable_stretched'     => false,

            /* Banner Styling */
            // general Settings
            'banner_text_style'      => 'inline', // inline, center, left, right, hidden
            'banner_show_crumbs'     => true, // bool
            // Scheme source
            'banner_scheme_source'    => 'main', // main, header, custom
            // Custom style settings
            'banner_custom_height'   => null, // Integer
            'banner_text_color'      => null, // HEX Code
            'banner_bg_color'        => null, // HEX Code
            'banner_overlay_opacity' => 'none', // none or integer
            'banner_overlay_color'   => null, // HEX Code
            'banner_bg_image_source' => 'none', // none, preset, custom
            'banner_bg_preset'       => 'shattered', // One of the patterns
            'banner_bg_custom'       => null, // Media library image ID
            'banner_bg_style'        => 'cover', // cover, tiled
            'banner_bg_attachment'   => 'scroll', // scroll, fixed

            /* Additional Elements settings */
            'search'                   => true,
            'search_type'            => true,
            'secondary_menu'           => false,
            'secondary_menu_position'  => 'left',
            'enable_social'            => false,
            'social_position'          => 'right',
            'social_outlet'            => null,
            'additional_text'          => null,
            'additional_text_position' => 'left',

            /* Transparency Settings */
            'transparency_default_enabled'    => false,
            'transparency_glassy_enabled'     => false,
            'transparency_logo'               => null,
            'transparency_color'              => '#555555',

         ),
      );

   }

   /**
    * Loading additional styles to the settings page
    *
    * @return void
    */
   public function additional_styles() {
      global $canvys; ?>
      <style id="cv-theme-settings-visual-style">

         #cv-header-preview-header {
            padding: 35px 5px;
         }

         .cv-header-preview {
            padding: 0 !important;
            border: 1px solid #eee;
            font-size: 11px;
         }

         /* Secondary Bar */
         .secondary-bar {
            border-bottom: 1px solid #eee;
            padding: 10px 5px;
         }
         .cv-header-preview .secondary-bar .secondary-menu,
         .cv-header-preview .secondary-bar .secondary-social {
            margin: 0 !important;
            padding: 0 5px;
         }
         .cv-header-preview .secondary-bar .secondary-menu li,
         .cv-header-preview .secondary-bar .secondary-social li {
            padding: 0 5px;
         }
         .cv-header-preview .secondary-bar .additional-text {
            padding: 0 5px;
         }

         /* Banner Area */
         .banner-area {
            border-top: 1px solid #eee;
            padding: 15px 0;
         }

         /* Banner Area Elements */
         .banner-area > * {
            margin: 6px 0;
            padding: 0 5px;
            display: inline;
         }
         .banner-area .banner-title {
            font-size: 16px !important;
            font-weight: 600;
         }
         .banner-area .banner-description {
            font-size: 16px !important;
            font-weight: 200;
         }

         /* Centered */
         .banner-area[data-style="center"] {
            text-align: center;
         }
         .banner-area[data-style="center"] > * {
            float: none !important;
            display: block;
         }

         /* Left Aligned */
         .banner-area[data-style="left"] {
            text-align: left;
         }
         .banner-area[data-style="left"] > * {
            float: none !important;
            display: block;
         }

         /* Right Aligned */
         .banner-area[data-style="right"] {
            text-align: right;
         }
         .banner-area[data-style="right"] > * {
            float: none !important;
            display: block;
         }

         /* Hidden */
         .banner-area[data-style="hidden"] {
            display: none !important;
         }

         /* Logo */
         .cv-header-preview .logo {
            width: 125px;
            padding: 0 5px;
         }
         .cv-header-preview .logo img {
            display: block;
         }

         /* main Navigation */
         .cv-header-preview .main-navigation {
            padding: 5px 0;
         }

         /* Modern inline menu style */
         .cv-header-preview .main-navigation[data-style="modern"] .main-menu span {
            font-weight: 600;
            font-size: 13px;
         }

         /* Overlay Style */
         .cv-header-preview .main-navigation[data-style="overlay"] {
            font-size: 16px;
         }
         .cv-header-preview .main-navigation[data-style="overlay"] .normal-menu,
         .cv-header-preview .main-navigation:not([data-style="overlay"]) .main-menu.overlay-menu {
            display: none;
         }

         .cv-header-preview .main-navigation .main-menu,
         .cv-header-preview .main-navigation .main-tools,
         .cv-header-preview .main-navigation .main-social {
            margin: 0 !important;
            padding: 0 5px;
         }
         .cv-header-preview .main-navigation .main-menu li,
         .cv-header-preview .main-navigation .main-tools li,
         .cv-header-preview .main-navigation .main-social li {
            padding: 0 5px;
         }

         /* Language directions */
         html[dir="rtl"] .cv-header-preview .banner-area .bread-crumbs,
         html:not([dir="rtl"]) .cv-header-preview .banner-area .banner-title,
         html:not([dir="rtl"]) .cv-header-preview .banner-area .banner-description,
         html:not([dir="rtl"]) .cv-header-preview .main-navigation .main-menu,
         html:not([dir="rtl"]) .cv-header-preview .main-navigation .main-tools,
         html:not([dir="rtl"]) .cv-header-preview .main-navigation .main-social,
         html:not([dir="rtl"]) .cv-header-preview .main-navigation .main-menu li,
         html:not([dir="rtl"]) .cv-header-preview .main-navigation .main-tools li,
         html:not([dir="rtl"]) .cv-header-preview .main-navigation .main-social li,
         html:not([dir="rtl"]) .cv-header-preview .secondary-bar .secondary-menu li,
         html:not([dir="rtl"]) .cv-header-preview .secondary-bar .secondary-social li {
            float: left;
         }
         html:not([dir="rtl"]) .cv-header-preview .banner-area .bread-crumbs,
         html[dir="rtl"] .cv-header-preview .banner-area .banner-title,
         html[dir="rtl"] .cv-header-preview .main-navigation .main-menu,
         html[dir="rtl"] .cv-header-preview .main-navigation .main-tools,
         html[dir="rtl"] .cv-header-preview .main-navigation .main-social,
         html[dir="rtl"] .cv-header-preview .main-navigation .main-menu li,
         html[dir="rtl"] .cv-header-preview .main-navigation .main-tools li,
         html[dir="rtl"] .cv-header-preview .main-navigation .main-social li,
         html[dir="rtl"] .cv-header-preview .secondary-bar .secondary-menu li,
         html[dir="rtl"] .cv-header-preview .secondary-bar .secondary-social li {
            float: right;
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

               // Show/Hide Sticky header options
               $('#header-menu_style').change( function() {
                  var $this = $(this), val = $this.val(), $stickyWrap = $('#cv-sticky-header-wrap');
                  if ( 'modern' === val ) {
                     $stickyWrap.slideUp();
                     $stickyWrap.find('input').prop( 'checked', true ).trigger('change');
                  }
                  else {
                     $stickyWrap.slideDown();
                  }
               }).trigger('change');

               // show/hide collapsing header option
               $('#header-enable_sticky').change( function() {
                  var $this = $(this), $stickyOptions = $('#cv-sticky-header-options');
                  if ( $this.prop('checked') ) {
                     $stickyOptions.slideDown();
                  }
                  else {
                     $stickyOptions.slideUp();
                     $stickyOptions.find('input').prop( 'checked', true );
                  }
               }).trigger('change');

               // Apply menu style class to header
               $('#header-menu_style').on( 'change', function() {
                  $('#cv-header-preview-main-navigation').attr('data-style', $(this).val() );
               }).trigger('change');

               /* Header Preview Elements */
               var $logo = $('#cv-header-preview-logo'),
                   $mainNavigation = $('#cv-header-preview-main-navigation'),
                   $mainTools = $('#cv-header-preview-main-tools');
                   $secondaryBar = $('#cv-header-preview-secondary-bar'),
                   $mainSocial = $('#cv-header-preview-main-social'),
                   $secondarySocial = $('#cv-header-preview-secondary-social'),
                   $secondaryMenu = $('#cv-header-preview-secondary-menu'),
                   $additionalText = $('#cv-header-preview-additional-text'),
                   $bannerArea = $('#cv-header-preview-banner'),
                   $bannerTitle = $('#cv-header-preview-banner-title'),
                   $breadCrumbs = $('#cv-header-preview-bread-crumbs');

               /* Function to update the preview */
               function cv_assess_header_preview() {

                  var showAdditionalBar = false;

                  // Determine if additional bar is visible
                  $secondaryBar.children().each( function() {
                     if ( 'none' !== $(this).css('display') ) {
                        showAdditionalBar = true;
                     }
                  });
                  if ( showAdditionalBar ) { $secondaryBar.show(); }
                  else { $secondaryBar.hide(); }

               }

               // Logo/menu alignment
               $('#header-alignment').on( 'change', function() {
                  var $this = $(this), val = $this.val();
                  if ( 'left' === val ) {
                     $logo.css('float', 'left');
                     $mainNavigation.css('float', 'right');
                  }
                  else {
                     $logo.css('float', 'right');
                     $mainNavigation.css('float', 'left');
                  }
               }).trigger('change');

               // Banner Title visibility
               $('#header-banner_title').on( 'change', function() {
                  var $this = $(this);
                  if ( $this.prop('checked') ) { $bannerTitle.show(); }
                  else { $bannerTitle.hide(); }
                  cv_assess_header_preview();
               }).trigger('change');

               // Bread Crumbs visibility
               $('#header-bread_crumbs').on( 'change', function() {
                  var $this = $(this);
                  if ( $this.prop('checked') ) { $breadCrumbs.show(); }
                  else { $breadCrumbs.hide(); }
                  cv_assess_header_preview();
               }).trigger('change');

               // Search bar visibility
               $('#header-search').on( 'change', function() {
                  var $this = $(this);
                  if ( $this.prop('checked') ) {
                     $mainTools.show();
                     $('#cv-header-search_type-wrap').slideDown();
                  }
                  else {
                     $mainTools.hide();
                     $('#cv-header-search_type-wrap').slideUp();
                  }
               }).trigger('change');

               // Secondary menu visibility
               $('#header-secondary_menu').on( 'change', function() {
                  var $this = $(this);
                  if ( $this.prop('checked') ) { $secondaryMenu.show(); }
                  else { $secondaryMenu.hide(); }
                  cv_assess_header_preview();
               }).trigger('change');

               // Secondary Menu position
               $('#header-secondary_menu_position').on( 'change', function() {
                  var $this = $(this), val = $this.val();
                  $secondaryMenu.css('float', val );
               }).trigger('change');

               // Additional text visibility
               $('#header-additional_text').on( 'change keyup', function() {
                  var $this = $(this), val = $this.val();
                  if ( val ) {
                     $additionalText.html(val).show();
                     $('#header-additional_text_position').trigger('change');
                  }
                  else {
                     $additionalText.hide();
                  }
                  cv_assess_header_preview();
               }).trigger('change');

               // Additional Text position
               $('#header-additional_text_position').on( 'change', function() {
                  var $this = $(this), val = $this.val();
                  $additionalText.css('float', val );
               }).trigger('change');

               // Social Media visibility / position
               $('#header-enable_social').on( 'change', function() { $('#header-social_position').trigger('change'); });
               $('#header-social_position').on( 'change', function() {
                  var $this = $(this), val = $this.val(), visible = $('#header-enable_social').prop('checked');
                  $mainSocial.hide(); $secondarySocial.hide();
                  if ( visible ) {
                     if ( 'inline' === val ) { $mainSocial.show(); }
                     else { $secondarySocial.show().css( 'float', val ); }
                  }
                  cv_assess_header_preview();
               }).trigger('change');

               // Show / hide social position control
               $('#header-enable_social').on( 'change', function() {
                  var $this = $(this), $positionWrap = $('#header-social-controls-wrap');
                  if ( $this.prop('checked') ) { $positionWrap.slideDown(); }
                  else { $positionWrap.slideUp().find('select').val('right'); }
               }).trigger('change');

               // Show / hide secondary menu position control
               $('#header-secondary_menu').on( 'change', function() {
                  var $this = $(this), $positionWrap = $('#header-secondary-menu-position-wrap');
                  if ( $this.prop('checked') ) { $positionWrap.slideDown(); }
                  else { $positionWrap.slideUp().find('select').val('left'); }
               }).trigger('change');

               // Show / hide additional text position control
               $('#header-additional_text').on( 'keyup change', function() {
                  var $this = $(this), $positionWrap = $('#header-additional-text-position-wrap');
                  if ( $this.val() ) { $positionWrap.slideDown(); }
                  else { $positionWrap.slideUp().find('select').val('left'); }
               }).trigger('change');

               /* ===== Banner Controls ===== */

               // Show / hide bread crumb visibility control
               $('#header-banner_text_style').on( 'change', function() {
                  var $this = $(this), val = $this.val(),
                      $showCrumbsControl = $('#header-banner_show_crumbs-wrap'),
                      $textColorControl = $('#header-banner_text_color-wrap');
                  if ( 'hidden' === val ) {
                     $showCrumbsControl.slideUp();
                     $textColorControl.hide();
                  }
                  else {
                     $showCrumbsControl.slideDown();
                     $textColorControl.show();
                  }
               }).trigger('change');

               // Show / hide custom styling controls
               $('#header-banner_scheme_source').on( 'change', function() {
                  var $this = $(this), val = $this.val(),
                      $schemeControls = $('#header-banner-custom-scheme-controls');
                  if ( 'custom' === val ) { $schemeControls.slideDown(); }
                  else { $schemeControls.slideUp(); }
               }).trigger('change');

               // Show / hide appropriate background source settings
               $('#header-banner_bg_image_source').on( 'change', function() {
                  var $this = $(this), val = $this.val(),
                      $presetControls = $('#header-banner_bg_preset-wrap'),
                      $customControls = $('#header-banner_bg_custom-wrap'),
                      $attachmentControl = $('#header-banner_bg_attachment-wrap'),
                      $bgColorControl = $('#header-banner_bg_color-wrap');
                  switch ( val ) {
                     case 'none':
                        $presetControls.slideUp();
                        $customControls.slideUp();
                        $attachmentControl.slideUp();
                        break;
                     case 'preset':
                        $presetControls.show();
                        $customControls.hide();
                        $attachmentControl.show();
                        break;
                     case 'custom':
                        $presetControls.hide();
                        $customControls.show();
                        $attachmentControl.show();
                        break;
                  }
                  if ( 'preset' === val ) { $bgColorControl.hide(); }
                  else { $bgColorControl.show(); }
               }).trigger('change');

               // Show/hide overlay color control
               $('#header-banner_overlay_opacity').on( 'change', function() {
                  var $this = $(this), val = $this.val(), $colorControl = $('#header-banner_overlay_color-wrap');
                  if ( 'none' === val ) {
                     $colorControl.slideUp();
                  }
                  else {
                     $colorControl.slideDown();
                  }
               }).trigger('change');

               // Show appropriate banner text style preview
               $('#header-banner_text_style').on( 'change', function() {
                  var $this = $(this), val = $this.val();
                  $bannerArea.attr('data-style', val);
               }).trigger('change');

               // Show / hide banner bread crumbs
               $('#header-banner_show_crumbs').on( 'change', function() {
                  var $this = $(this);
                  if ( $this.prop('checked') ) { $breadCrumbs.show(); }
                  else { $breadCrumbs.hide(); }
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
         <div id="cv-header-preview" class="option-description additional-message cv-header-preview">
            <div class="secondary-bar has-clearfix" id="cv-header-preview-secondary-bar">
               <ul class="secondary-menu" id="cv-header-preview-secondary-menu">
                  <li><span>Legal</span></li>
                  <li><span>Terms</span></li>
                  <li><span>FAQ</span></li>
               </ul>
               <ul class="secondary-social" id="cv-header-preview-secondary-social">
                  <li><i class="icon-facebook"></i></li>
                  <li><i class="icon-twitter"></i></li>
                  <li><i class="icon-gplus"></i></li>
               </ul>
               <div class="additional-text" id="cv-header-preview-additional-text"></div>
            </div>
            <header class="header has-clearfix" id="cv-header-preview-header">
               <div class="logo" id="cv-header-preview-logo">
                  <img src="<?php echo THEME_DIR; ?>config/theme-settings/assets/camyno_logo.png" alt="" />
               </div>
               <nav class="main-navigation" id="cv-header-preview-main-navigation">
                  <ul class="main-menu normal-menu">
                     <li><span>Home</span></li>
                     <li><span>Contact</span></li>
                     <li><span>Portfolio</span></li>
                  </ul>
                  <ul class="main-menu overlay-menu">
                     <li><i class="icon-menu"></i></li>
                  </ul>
                  <ul class="main-tools" id="cv-header-preview-main-tools">
                     <li><i class="icon-search"></i></li>
                  </ul>
                  <ul class="main-social" id="cv-header-preview-main-social">
                     <li><i class="icon-facebook"></i></li>
                     <li><i class="icon-twitter"></i></li>
                     <li><i class="icon-gplus"></i></li>
                  </ul>
               </nav>
            </header>
            <div class="banner-area has-clearfix" id="cv-header-preview-banner">
               <strong class="banner-title" id="cv-header-preview-banner-title"><?php _e( 'Page Title', 'canvys' ); ?></strong>
               <strong class="banner-description" id="cv-header-preview-banner-description"><?php _e( 'Short description', 'canvys' ); ?></strong>
               <div class="bread-crumbs" id="cv-header-preview-bread-crumbs"><?php _e( 'Home / About / The Team', 'canvys' ); ?></div>
            </div>
         </div>
      </div>

      <nav class="cv-settings-inner-tabs has-clearfix">
         <a data-pane="header-general"><?php _e( 'General', 'canvys' ); ?></a>
         <a data-pane="header-styling"><?php _e( 'Styling', 'canvys' ); ?></a>
         <a data-pane="header-additionalelements"><?php _e( 'Additional Elements', 'canvys' ); ?></a>
         <a data-pane="header-banner"><?php _e( 'Banner', 'canvys' ); ?></a>
         <a data-pane="header-transparency"><?php _e( 'Transparency', 'canvys' ); ?></a>
      </nav>

      <div class="cv-settings-inner-panes">

         <!-- General Settings -->
         <div data-pane="header-general">
            <div class="option-wrap">
               <label for="header-logo" class="option-title"><?php _e( 'Custom Logo', 'canvys' ); ?></label>
               <input type="text" class="widefat cv-image-with-preview" style="max-width:200px;" id="header-logo" value="<?php echo $input['logo']; ?>" name="<?php echo $name; ?>[logo]" />
               <a class="button cv-select-image"><?php _e( 'Select Image', 'canvys' ); ?></a>
               <p class="option-description"><?php _e( 'Selected image should be 360px x 170px for optimal display. If no image is selected then a textual logo will be used consisting of your website title. You can either enter an image URL here or select one from the media library.', 'canvys' ); ?></p>
            </div>
            <div class="option-wrap">
               <label class="option-title" for="header-alignment"><?php _e( 'Logo / Menu Layout', 'canvys' ); ?></label>
               <select name="<?php echo $name; ?>[alignment]" id="header-alignment">
                  <option value="left" <?php selected( $input['alignment'], 'left' ); ?>><?php _e( 'Logo Left, Menu Right', 'canvys' ); ?></option>
                  <option value="right" <?php selected( $input['alignment'], 'right' ); ?>><?php _e( 'Logo Right, Menu Left', 'canvys' ); ?></option>
               </select>
            </div>
         </div>

         <!-- Styling Settings -->
         <div data-pane="header-styling">
            <div class="option-wrap">
               <label class="option-title" for="header-menu_style"><?php _e( 'Menu Style', 'canvys' ); ?></label>
               <select name="<?php echo $name; ?>[menu_style]" id="header-menu_style">
                  <option value="dropdown" <?php selected( $input['menu_style'], 'dropdown' ); ?>><?php _e( 'Dropdown', 'canvys' ); ?></option>
                  <option value="modern" <?php selected( $input['menu_style'], 'modern' ); ?>><?php _e( 'Inline Tree', 'canvys' ); ?></option>
                  <option value="overlay" <?php selected( $input['menu_style'], 'overlay' ); ?>><?php _e( 'Fullscreen overlay', 'canvys' ); ?></option>
               </select>
            </div>
            <div class="option-wrap" id="cv-sticky-header-wrap">
               <strong class="option-title"><?php _e( 'Sticky Header', 'canvys' ); ?></strong>
               <label for="header-enable_sticky">
                  <input type="checkbox" id="header-enable_sticky" value="1" <?php checked( $input['enable_sticky'] ); ?> name="<?php echo $name; ?>[enable_sticky]" />
                  <span><?php _e( 'Enable sticky behavior, meaning the header will scroll with the page.', 'canvys' ); ?></span>
               </label>
               <div id="cv-sticky-header-options">
                  <div class="option-spacer"></div>
                  <strong class="option-title"><?php _e( 'Collapsing Header', 'canvys' ); ?></strong>
                  <label for="header-enable_collapse">
                     <input type="checkbox" id="header-enable_collapse" value="1" <?php checked( $input['enable_collapse'] ); ?> name="<?php echo $name; ?>[enable_collapse]" />
                     <span><?php _e( 'Enable collapsing header, header will reduce to a smaller height when scrolled down.', 'canvys' ); ?></span>
                  </label>
               </div>
            </div>
            <div class="option-wrap">
               <strong class="option-title"><?php _e( 'Header Border', 'canvys' ); ?></strong>
               <label for="header-enable_border">
                  <input type="checkbox" id="header-enable_border" value="1" <?php checked( $input['enable_border'] ); ?> name="<?php echo $name; ?>[enable_border]" />
                  <span><?php _e( 'Display a small (1px) border beneath the header, for visual separation.', 'canvys' ); ?></span>
               </label>
            </div>
            <div class="option-wrap">
               <strong class="option-title"><?php _e( 'Header Drop Shadow', 'canvys' ); ?></strong>
               <label for="header-enable_shadow">
                  <input type="checkbox" id="header-enable_shadow" value="1" <?php checked( $input['enable_shadow'] ); ?> name="<?php echo $name; ?>[enable_shadow]" />
                  <span><?php _e( 'Display a light drop shadow below the header.', 'canvys' ); ?></span>
               </label>
            </div>
            <div class="option-wrap">
               <strong class="option-title"><?php _e( 'Stretched Header', 'canvys' ); ?></strong>
               <label for="header-enable_stretched">
                  <input type="checkbox" id="header-enable_stretched" value="1" <?php checked( $input['enable_stretched'] ); ?> name="<?php echo $name; ?>[enable_stretched]" />
                  <span><?php _e( 'Enable stretched header, which means the header will stretch to fill the width of the outer container.', 'canvys' ); ?></span>
               </label>
            </div>
         </div>

         <!-- Banner Settings -->
         <div data-pane="header-banner">

            <!-- <div class="option-wrap">
               <strong class="option-title"><?php _e( 'Header Banner', 'canvys' ); ?></strong>
               <p class="option-description"><?php _e( 'Header Banner refers to the section displayed immediately below the header. Its intended purpose is to display textual information about the current page. The settings below are used to determine the default settings and can be overwritten on certain pages individually.', 'canvys' ); ?></p>
            </div> -->

            <!-- Text Style -->
            <div class="option-wrap">
               <label class="option-title" for="header-banner_text_style"><?php _e( 'Text Style', 'canvys' ); ?></label>
               <select name="<?php echo $name; ?>[banner_text_style]" id="header-banner_text_style">
                  <option value="inline" <?php selected( $input['banner_text_style'], 'inline' ); ?>><?php _e( 'Inline, on a single line', 'canvys' ); ?></option>
                  <option value="center" <?php selected( $input['banner_text_style'], 'center' ); ?>><?php _e( 'Centered, on multiple lines', 'canvys' ); ?></option>
                  <option value="left" <?php selected( $input['banner_text_style'], 'left' ); ?>><?php _e( 'Left aligned, on multiple lines', 'canvys' ); ?></option>
                  <option value="right" <?php selected( $input['banner_text_style'], 'right' ); ?>><?php _e( 'Right aligned, on multiple lines', 'canvys' ); ?></option>
                  <option value="hidden" <?php selected( $input['banner_text_style'], 'hidden' ); ?>><?php _e( 'Hidden, do not display textual information', 'canvys' ); ?></option>
               </select>
               <p style="margin-bottom:0;" class="option-description"><?php _e( 'Specify how the textual information within the banner should be displayed. Setting this to hidden will hide the text but still allow you to customize the background if so desired, this is especially useful for when header transparency is enabled.', 'canvys' ); ?></p>

               <!-- Display Bread Crumbs -->
               <div id="header-banner_show_crumbs-wrap">
                  <div class="option-spacer"></div>
                  <strong class="option-title"><?php _e( 'Display Bread Crumbs', 'canvys' ); ?></strong>
                  <label for="header-banner_show_crumbs">
                     <input type="checkbox" id="header-banner_show_crumbs" value="1" <?php checked( $input['banner_show_crumbs'] ); ?> name="<?php echo $name; ?>[banner_show_crumbs]" />
                     <span><?php _e( 'Display bread crumbs in the header when applicable.', 'canvys' ); ?></span>
                  </label>
               </div>

            </div>

            <!-- Scheme Source -->
            <div class="option-wrap">
               <label class="option-title" for="header-banner_scheme_source"><?php _e( 'Style Source', 'canvys' ); ?></label>
               <select name="<?php echo $name; ?>[banner_scheme_source]" id="header-banner_scheme_source">
                  <option value="main" <?php selected( $input['banner_scheme_source'], 'main' ); ?>><?php _e( 'Use default styling', 'canvys' ); ?></option>
                  <option value="custom" <?php selected( $input['banner_scheme_source'], 'custom' ); ?>><?php _e( 'Custom styles', 'canvys' ); ?></option>
               </select>
               <p class="option-description"><?php _e( 'Specify how the banner should be styled, setting this to custom will allow you to select a custom background color/image and change the typography color.', 'canvys' ); ?></p>
            </div>

            <div id="header-banner-custom-scheme-controls">

               <!-- Typography / Background Colors -->
               <div class="option-wrap">

                  <label class="option-title" for="header-banner_custom_height"><?php _e( 'Custom height', 'canvys' ); ?></label>
                  <input type="text" id="header-banner_custom_height" name="<?php echo $name; ?>[banner_custom_height]" value="<?php echo $input['banner_custom_height']; ?>" class="widefat code" placeholder="250" />
                  <p class="option-description"><?php _e( 'Specify a custom height for the banner, only enter a numeric value in pixels. If header transparency is enabled then the height of the header will be added to the height of the banner automatically.', 'canvys' ); ?></p>

                  <div id="header-banner_text_color-wrap">

                     <div class="option-spacer"></div>

                     <label class="option-title" for="header-banner_text_color"><?php _e( 'Text Color', 'canvys' ); ?></label>
                     <input type="text" id="header-banner_text_color" name="<?php echo $name; ?>[banner_text_color]" value="<?php echo $input['banner_text_color']; ?>" class="cv-color-picker" />
                     <p class="option-description"><?php _e( 'Specify the color for the banner\'s typography.', 'canvys' ); ?></p>

                  </div>

                  <div id="header-banner_bg_color-wrap">

                     <div class="option-spacer"></div>

                     <label class="option-title" for="header-banner_bg_color"><?php _e( 'Background Color', 'canvys' ); ?></label>
                     <input type="text" id="header-banner_bg_color" name="<?php echo $name; ?>[banner_bg_color]" value="<?php echo $input['banner_bg_color']; ?>" class="cv-color-picker" />
                     <p class="option-description"><?php _e( 'Specify the color for the banner\'s background. <strong>Pro Tip: When using a background image set this color to one remotely similar to the overall image, this way as the image is loading the color will be visible.</strong>', 'canvys' ); ?></p>

                  </div>

                  <div class="option-spacer"></div>

                  <!-- BG Image Source -->
                  <label class="option-title" for="header-banner_bg_image_source"><?php _e( 'Background Image Source', 'canvys' ); ?></label>
                  <select name="<?php echo $name; ?>[banner_bg_image_source]" id="header-banner_bg_image_source">
                     <option value="none" <?php selected( $input['banner_bg_image_source'], 'none' ); ?>><?php _e( 'None, no background image', 'canvys' ); ?></option>
                     <option value="preset" <?php selected( $input['banner_bg_image_source'], 'preset' ); ?>><?php _e( 'Preset background', 'canvys' ); ?></option>
                     <option value="custom" <?php selected( $input['banner_bg_image_source'], 'custom' ); ?>><?php _e( 'Custom image', 'canvys' ); ?></option>
                  </select>
                  <p class="option-description"><?php _e( 'Select the source for the banner\'s background image.', 'canvys' ); ?></p>
               </div>

               <!-- Background Image Presets -->
               <div class="option-wrap" id="header-banner_bg_preset-wrap">
                  <strong class="option-title"><?php _e('Background Presets', 'canvys'); ?></strong>
                  <div id="cv-background-presets" class="cv-background-presets">
                     <ul class="cv-grid-5 has-clearfix spacing-0">
                        <?php foreach ( $canvys['bg_patterns'] as $preset => $title ) {
                           $url = THEME_DIR . 'assets/img/patterns/' . $preset . '.png';
                           $quick_preview_style = ' style="background-image:url(' . $url . ');"';
                           $id = 'header-banner_bg_preset_option-' . $preset;
                           echo '<li class="background-preset-option" data-pattern-url="' . $url . '">';
                           echo '<input type="radio" id="' . $id . '" name="' . $name . '[banner_bg_preset]" value="' . $preset . '" ' . checked( $preset, $input['banner_bg_preset'], false ) . ' />';
                           echo '<label for="' . $id . '">';
                           echo '<strong><i class="icon-circle-empty"></i><i class="icon-circle"></i>' . $title . '</strong>';
                           echo '<div class="quick-preview"' . $quick_preview_style . '></div>';
                           echo '</label>';
                           echo '</li>';
                        } ?>
                     </ul>
                  </div>
               </div>

               <!-- Custom BG Settings -->
               <div class="option-wrap" id="header-banner_bg_custom-wrap">
                  <label for="header-banner_bg_custom" class="option-title"><?php _e( 'Custom background Image', 'canvys' ); ?></label>
                  <input type="text" class="widefat cv-image-with-preview" style="max-width:200px;" id="header-banner_bg_custom" value="<?php echo $input['banner_bg_custom']; ?>" name="<?php echo $name; ?>[banner_bg_custom]" />
                  <a class="button cv-select-image"><?php _e( 'Select Image', 'canvys' ); ?></a>
                  <p class="option-description"><?php _e( 'Select a custom background image to use for the banner. You can either enter an image URL here or select one from the media library.', 'canvys' ); ?></p>

                  <div class="option-spacer"></div>

                  <label class="option-title" for="header-banner_bg_style"><?php _e( 'Background Image Style', 'canvys' ); ?></label>
                  <select name="<?php echo $name; ?>[banner_bg_style]" id="header-banner_bg_style">
                     <option value="cover" <?php selected( $input['banner_bg_style'], 'cover' ); ?>><?php _e( 'Automatic, image will be scaled to cover the banner', 'canvys' ); ?></option>
                     <option value="tiled" <?php selected( $input['banner_bg_style'], 'tiled' ); ?>><?php _e( 'Tiled, image will be tiled to cover the banner', 'canvys' ); ?></option>
                  </select>
                  <p class="option-description"><?php _e( 'Select how the background image should be displayed.', 'canvys' ); ?></p>

                  <div class="option-spacer"></div>

                  <label class="option-title" for="header-banner_overlay_opacity"><?php _e( 'Foreground Overlay Opacity', 'canvys' ); ?></label>
                  <select name="<?php echo $name; ?>[banner_overlay_opacity]" id="header-banner_overlay_opacity">
                     <option value="none" <?php selected( $input['banner_overlay_opacity'], 'none' ); ?>><?php _e( 'None, do not display an overlay color', 'canvys' ); ?></option>
                     <?php for ( $i=10; $i<=90; $i+=10 ) : ?>
                        <option value="<?php echo $i; ?>" <?php selected( $input['banner_overlay_opacity'], $i ); ?>><?php echo $i; ?>%</option>
                     <?php endfor; ?>
                  </select>
                  <p style="margin-bottom:0;padding-bottom:1em;" class="option-description"><?php _e( 'Specify whether or not a color should be overlayed on top of the banner, and at what opacity.', 'canvys' ); ?></p>

                  <div id="header-banner_overlay_color-wrap">

                     <div class="option-spacer"></div>

                     <label class="option-title" for="header-banner_overlay_color"><?php _e( 'Foreground Overlay Color', 'canvys' ); ?></label>
                     <input type="text" id="header-banner_overlay_color" name="<?php echo $name; ?>[banner_overlay_color]" value="<?php echo $input['banner_overlay_color']; ?>" class="cv-color-picker" />
                     <p class="option-description"><?php _e( 'Specify a color to be overlayed on top of the banner.', 'canvys' ); ?></p>

                  </div>

               </div>

               <!-- BG Image Attachment -->
               <div class="option-wrap" id="header-banner_bg_attachment-wrap">
                  <label class="option-title" for="header-banner_bg_attachment"><?php _e( 'Background Image Attachment', 'canvys' ); ?></label>
                  <select name="<?php echo $name; ?>[banner_bg_attachment]" id="header-banner_bg_attachment">
                     <option value="scroll" <?php selected( $input['banner_bg_attachment'], 'scroll' ); ?>><?php _e( 'Scroll, background image will scroll with page', 'canvys' ); ?></option>
                     <option value="fixed" <?php selected( $input['banner_bg_attachment'], 'fixed' ); ?>><?php _e( 'Fixed, background image will remain fixed in place', 'canvys' ); ?></option>
                  </select>
                  <p class="option-description"><?php _e( 'Specify how the banner\'s background image should behave as the page is scrolled.', 'canvys' ); ?></p>
               </div>

            </div>

         </div>

         <!-- Additional Elements Settings -->
         <div data-pane="header-additionalelements">

            <?php $search_type_options = array(
               'all'  => __( 'All content', 'canvys' ),
               'posts' => __( 'Blog Posts', 'canvys' ),
               'pages' => __( 'Pages', 'canvys' ),
               'portfolio' => __( 'Portfolio Items', 'canvys' ),
            );

            if ( class_exists( 'woocommerce') ) {
               $search_type_options['shop'] = __( 'WooCommerce Products', 'canvys' );
            }

            if ( class_exists( 'bbPress') ) {
               $search_type_options['forums'] = __( 'bbPress Forums', 'canvys' );
            } ?>

            <div class="option-wrap">

               <strong class="option-title"><?php _e( 'Search Bar', 'canvys' ); ?></strong>
               <label for="header-search">
                  <input type="checkbox" id="header-search" value="1" <?php checked( $input['search'] ); ?> name="<?php echo $name; ?>[search]" />
                  <span><?php _e( 'Display the search bar in the header.', 'canvys' ); ?></span>
               </label>

               <div id="cv-header-search_type-wrap">

                  <div class="option-spacer"></div>
                  <label class="option-title" for="header-search_type"><?php _e( 'Overlay Search Bar Type', 'canvys' ); ?></label>
                  <select name="<?php echo $name; ?>[search_type]" id="header-search_type">
                     <?php foreach ( $search_type_options as $val => $type ) {
                        echo '<option value="' . $val . '" ' . selected( $input['search_type'], $val, 0 ) . '>' . $type . '</option>';
                     } ?>
                  </select>
                  <p class="option-description"><?php _e( 'Clicking the search icon will launch a fullscreen overlay modal containing a large search bar, use this control to dictate which content of your website should be searched through when using this search bar.', 'canvys' ); ?></p>

               </div>


            </div>

            <div class="option-wrap">
               <strong class="option-title"><?php _e( 'Secondary Menu', 'canvys' ); ?></strong>
               <label for="header-secondary_menu">
                  <input type="checkbox" id="header-secondary_menu" value="1" <?php checked( $input['secondary_menu'] ); ?> name="<?php echo $name; ?>[secondary_menu]" />
                  <span><?php _e( 'Display the secondary menu in the header.', 'canvys' ); ?></span>
               </label>
               <div id="header-secondary-menu-position-wrap">
                  <div class="option-spacer"></div>
                  <label class="option-title" for="header-secondary_menu_position"><?php _e( 'Secondary Menu Position', 'canvys' ); ?></label>
                  <select name="<?php echo $name; ?>[secondary_menu_position]" id="header-secondary_menu_position">
                     <option value="left" <?php selected( $input['secondary_menu_position'], 'left' ); ?>><?php _e( 'Top bar, left side', 'canvys' ); ?></option>
                     <option value="right" <?php selected( $input['secondary_menu_position'], 'right' ); ?>><?php _e( 'Top bar, right side', 'canvys' ); ?></option>
                  </select>
               </div>
            </div>

            <div class="option-wrap">
               <strong class="option-title"><?php _e( 'Social Media', 'canvys' ); ?></strong>
               <label for="header-enable_social">
                  <input type="checkbox" id="header-enable_social" value="1" <?php checked( $input['enable_social'] ); ?> name="<?php echo $name; ?>[enable_social]" />
                  <span><?php _e( 'Display your social media profiles in the header.', 'canvys' ); ?></span>
               </label>
               <div id="header-social-controls-wrap">

                  <div class="option-spacer"></div>
                  <label class="option-title" for="header-social_position"><?php _e( 'Social Media Position', 'canvys' ); ?></label>
                  <select name="<?php echo $name; ?>[social_position]" id="header-social_position">
                     <option value="inline" <?php selected( $input['social_position'], 'inline' ); ?>><?php _e( 'Main Header Area (Will only be visible on large screens)', 'canvys' ); ?></option>
                     <option value="left" <?php selected( $input['social_position'], 'left' ); ?>><?php _e( 'Top bar, left side', 'canvys' ); ?></option>
                     <option value="right" <?php selected( $input['social_position'], 'right' ); ?>><?php _e( 'Top bar, right side', 'canvys' ); ?></option>
                  </select>

                  <div class="option-spacer"></div>
                  <label class="option-title" for="header-social_outlets"><?php _e( 'Displayed Social Media Outlets', 'canvys' ); ?></label>
                  <?php $saved_social_outlets = cv_theme_setting( 'social', 'profiles' ); ?>
                  <?php if ( ! empty( $saved_social_outlets ) ) : ?>
                     <select class="widefat" style="height:150px;" id="header-social_outlets" name="<?php echo $name; ?>[social_outlets][]" multiple>
                     <?php if ( ! is_array( $input['social_outlets'] ) ) {
                        $input['social_outlets'] = array();
                     }
                     foreach ( $saved_social_outlets as $outlet => $url ) {
                        if ( ! $url ) continue;
                        echo '<option value="' . $outlet . '" ' . selected( in_array( $outlet, $input['social_outlets'] ), true, 0 ) . '>' . $canvys['social_outlets'][$outlet] . '</option>';
                     } ?>
                     </select>
                     <p class="option-description"><?php _e( 'Select which of your saved social media outlets should be displayed.', 'canvys' ); ?></p>
                  <?php else : ?>
                     <p class="option-description additional-message info-message"><?php _e( 'You don\'t have any saved social media outlets. To set some up navigate to the social tab, follow the instructions and save changes.', 'canvys' ); ?></p>
                  <?php endif; ?>

               </div>
            </div>

            <div class="option-wrap">
               <label for="header-additional_text" class="option-title"><?php _e( 'Additional Information', 'canvys' ); ?></label>
               <input type="text" class="widefat" id="header-additional_text" value="<?php echo $input['additional_text']; ?>" name="<?php echo $name; ?>[additional_text]" />
               <p style="margin-bottom:0;" class="option-description"><?php _e( 'Text to be displayed in the top bar of the header.', 'canvys' ); ?></p>
               <div id="header-additional-text-position-wrap">
                  <div class="option-spacer"></div>
                  <label class="option-title" for="header-additional_text_position"><?php _e( 'Additional Information Position', 'canvys' ); ?></label>
                  <select name="<?php echo $name; ?>[additional_text_position]" id="header-additional_text_position">
                     <option value="left" <?php selected( $input['additional_text_position'], 'left' ); ?>><?php _e( 'Top bar, left side', 'canvys' ); ?></option>
                     <option value="right" <?php selected( $input['additional_text_position'], 'right' ); ?>><?php _e( 'Top bar, right side', 'canvys' ); ?></option>
                  </select>
               </div>
            </div>
         </div>

         <!-- Transparency Settings -->
         <div data-pane="header-transparency">

            <div class="option-wrap">
               <strong class="option-title"><?php _e( 'Enabled By Default', 'canvys' ); ?></strong>
               <label for="header-transparency_default_enabled">
                  <input type="checkbox" id="header-transparency_default_enabled" value="1" <?php checked( $input['transparency_default_enabled'] ); ?> name="<?php echo $name; ?>[transparency_default_enabled]" />
                  <span><?php _e( 'Enable header transparency on all pages by default, use this with caution. If this is checked make sure the header logo/text color will show up well on top of the banner.', 'canvys' ); ?></span>
               </label>
            </div>

            <div class="option-wrap">
               <strong class="option-title"><?php _e( 'Glassy Background', 'canvys' ); ?></strong>
               <label for="header-transparency_glassy_enabled">
                  <input type="checkbox" id="header-transparency_glassy_enabled" value="1" <?php checked( $input['transparency_glassy_enabled'] ); ?> name="<?php echo $name; ?>[transparency_glassy_enabled]" />
                  <span><?php _e( 'Enable the glassy background effect for the transparent header by default.', 'canvys' ); ?></span>
               </label>
            </div>

            <div class="option-wrap">
               <label for="header-transparency_logo" class="option-title"><?php _e( 'Default Transparency Logo', 'canvys' ); ?></label>
               <input type="text" class="widefat cv-image-with-preview" style="max-width:200px;" id="header-transparency_logo" value="<?php echo $input['transparency_logo']; ?>" name="<?php echo $name; ?>[transparency_logo]" />
               <a class="button cv-select-image"><?php _e( 'Select Image', 'canvys' ); ?></a>
               <p class="option-description"><?php _e( 'Selected image should be 360px x 170px for optimal display. This setting can be overriden on each page individually. You can either enter an image URL here or select one from the media library.', 'canvys' ); ?></p>
            </div>

            <div class="option-wrap">
               <label class="option-title" for="header-transparency_color"><?php _e( 'Default Transparency Color', 'canvys' ); ?></label>
               <input type="text" id="header-transparency_color" name="<?php echo $name; ?>[transparency_color]" value="<?php echo $input['transparency_color']; ?>" class="cv-color-picker" />
               <p class="option-description"><?php _e( 'Specify the the default color for the headers typography when it is transparent, this includes nvigation items & the textual logo. This setting can be overriden on each page individually.', 'canvys' ); ?></p>
            </div>
         </div>

      </div>

   <?php }

   /**
    * Sanitizing the page specific input
    *
    * @param array $input The user specified input
    * @return array
    */
   public static function sanitize_input( $input ) {

      $search_type_options = array(
         'all', 'posts', 'pages', 'portfolio',
      );

      if ( class_exists( 'woocommerce') ) array_push( $search_type_options, 'shop' );

      if ( class_exists( 'bbPress') ) array_push( $search_type_options, 'forums' );

      return array(

         /* General settings */
         'logo'                 => isset( $input['logo'] ) ? cv_filter( $input['logo'], 'url' ) : null,
         'alignment'            => isset( $input['alignment'] ) ? cv_filter( $input['alignment'], array( 'left', 'right' ) ) : 'left',

         /* Styling Settings */
         'menu_style'       => isset( $input['menu_style'] ) ? cv_filter( $input['menu_style'], array( 'dropdown', 'modern', 'overlay' ) ) : 'dropdown',
         'enable_sticky'    => isset( $input['enable_sticky'] ) && $input['enable_sticky'] ? true : false,
         'enable_shadow'    => isset( $input['enable_shadow'] ) && $input['enable_shadow'] ? true : false,
         'enable_collapse'  => isset( $input['enable_collapse'] ) && $input['enable_collapse'] ? true : false,
         'enable_border'    => isset( $input['enable_border'] ) && $input['enable_border'] ? true : false,
         'enable_stretched' => isset( $input['enable_stretched'] ) && $input['enable_stretched'] ? true : false,

         /* Banner Styling */
         // general Settings
         'banner_text_style'      => isset( $input['banner_text_style'] ) ? cv_filter( $input['banner_text_style'], array( 'inline', 'center', 'left', 'right', 'hidden' ) ) : 'inline',
         'banner_show_crumbs'     => isset( $input['banner_show_crumbs'] ) && $input['banner_show_crumbs'] ? true : false,
         // Color Scheme source
         'banner_scheme_source'    => isset( $input['banner_scheme_source'] ) ? cv_filter( $input['banner_scheme_source'], array( 'main', 'custom' ) ) : 'main',
         // Custom style settings
         'banner_custom_height'   => isset( $input['banner_custom_height'] ) ? cv_filter( $input['banner_custom_height'], 'integer' ) : null,
         'banner_text_color'      => isset( $input['banner_text_color'] ) ? cv_filter( $input['banner_text_color'], 'hex' ) : null,
         'banner_bg_color'        => isset( $input['banner_bg_color'] ) ? cv_filter( $input['banner_bg_color'], 'hex' ) : null,
         'banner_overlay_opacity' => isset( $input['banner_overlay_opacity'] ) ? $input['banner_overlay_opacity'] : 'none',
         'banner_overlay_color'   => isset( $input['banner_overlay_color'] ) ? cv_filter( $input['banner_overlay_color'], 'hex' ) : null,
         'banner_bg_image_source' => isset( $input['banner_bg_image_source'] ) ? cv_filter( $input['banner_bg_image_source'], array( 'none', 'preset', 'custom' ) ) : 'none',
         'banner_bg_preset'       => isset( $input['banner_bg_preset'] ) ? cv_filter( $input['banner_bg_preset'], 'text' ) : 'shattered',
         'banner_bg_custom'       => isset( $input['banner_bg_custom'] ) ? cv_filter( $input['banner_bg_custom'], 'url' ) : null,
         'banner_bg_style'        => isset( $input['banner_bg_style'] ) ? cv_filter( $input['banner_bg_style'], array( 'cover', 'tiled' ) ) : 'cover',
         'banner_bg_attachment'   => isset( $input['banner_bg_attachment'] ) ? cv_filter( $input['banner_bg_attachment'], array( 'scroll', 'fixed' ) ) : 'scroll',

         /* Additional Elements settings */
         'search'                   => isset( $input['search'] ) && $input['search'] ? true : false,
         'search_type'              => isset( $input['search_type'] ) ? cv_filter( $input['search_type'], $search_type_options ) : 'all',
         'secondary_menu'           => isset( $input['secondary_menu'] ) && $input['secondary_menu'] ? true : false,
         'secondary_menu_position'  => isset( $input['secondary_menu_position'] ) ? cv_filter( $input['secondary_menu_position'], array( 'left', 'right' ) ) : 'left',
         'enable_social'            => isset( $input['enable_social'] ) && $input['enable_social'] ? true : false,
         'social_position'          => isset( $input['social_position'] ) ? cv_filter( $input['social_position'], array( 'right', 'left', 'inline' ) ) : 'right',
         'social_outlets'           => isset( $input['social_outlets'] ) ? $input['social_outlets'] : null,
         'additional_text'          => isset( $input['additional_text'] ) ? cv_filter( $input['additional_text'], 'text' ) : null,
         'additional_text_position' => isset( $input['additional_text_position'] ) ? cv_filter( $input['additional_text_position'], array( 'left', 'right' ) ) : 'left',

         /* Transparency Settings */
         'transparency_default_enabled' => isset( $input['transparency_default_enabled'] ) && $input['transparency_default_enabled'] ? true : false,
         'transparency_glassy_enabled'  => isset( $input['transparency_glassy_enabled'] ) && $input['transparency_glassy_enabled'] ? true : false,
         'transparency_logo'            => isset( $input['transparency_logo'] ) ? cv_filter( $input['transparency_logo'], 'url' ) : null,
         'transparency_color'           => isset( $input['transparency_color'] ) ? cv_filter( $input['transparency_color'], 'hex' ) : '#555555',

      );
   }

}
endif;