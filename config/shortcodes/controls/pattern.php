<?php

if ( ! class_exists('CV_Shortcode_BG_Pattern_Control') ) :

/**
 * Preset Background Control
 * used to manage each included shortcode's controls
 *
 * @package    WordPress
 * @subpackage Canvys
 * @since      Version 1.0
 */
class CV_Shortcode_BG_Pattern_Control extends CV_Shortcode_Control {

   // Used to identify the shortcode type
   public $type = 'bg-pattern';

   /**
    * Renders inline CSS required by the shortcode composer
    *
    * @return mixed
    */
   static function composer_additional_styles() { ?>
      <style id="cv-composer-bg-pattern-control-style">

         .cv-composer-modal .cv-background-presets .background-preset-option {
            padding-bottom: 10px !important;
            margin-bottom: 0 !important;
         }

         .cv-composer-modal .cv-background-presets .background-preset-option input { display: none; }

         .cv-composer-modal .cv-background-presets .background-preset-option label {
            display: block;
            padding: 5px;
         }
         .cv-composer-modal .cv-background-presets .background-preset-option label:hover,
         .cv-composer-modal .cv-background-presets .background-preset-option input:checked + label {
            background: rgba(0,0,0,0.05);
         }
         .cv-composer-modal .cv-background-presets .background-preset-option strong {
            display: block;
            margin: 0 0 5px !important;
            font-family: 'Open Sans', sans-serif;
            font-weight: normal;
            color: rgba(0,0,0,0.7);
            font-size: 11px;
         }

         .cv-composer-modal .cv-background-presets .background-preset-option strong i { margin-right: 5px; }

         .cv-composer-modal .cv-background-presets .background-preset-option input:not(:checked) + label .icon-circle,
         .cv-composer-modal .cv-background-presets .background-preset-option input:checked + label .icon-circle-empty { display: none; }

         .cv-composer-modal .cv-background-presets .background-preset-option .quick-preview {
            height: 40px;
            border: 2px solid #fff;
            box-shadow: #ddd 0px 0px 0px 1px;
         }

      </style>
   <?php }

   /**
    * Callback function for rendering only the control
    *
    * @param mixed $input The input value
    * @return string
    */
   public function render_complete_control( $input = null ) {

      global $canvys;

      ob_start(); ?>

      <div class="control-padding">

         <label class="cv-attribute-title"><?php echo $this->config['title']; ?></label>
         <?php if ( isset( $this->config['description'] ) ) {
            echo '<p class="cv-attribute-description">' . $this->config['description'] . '</p>';
         } ?>

         <div id="cv-background-presets" class="cv-background-presets">
            <ul class="cv-grid-5 has-clearfix spacing-1">
               <?php foreach ( $canvys['bg_patterns'] as $preset => $title ) {
                  $url = THEME_DIR . 'assets/img/patterns/' . $preset . '.png';
                  $quick_preview_style = ' style="background-image:url(' . $url . ');"';
                  $id = 'cv_banner_bg_preset_option-' . $preset;
                  echo '<li class="background-preset-option">';
                  echo '<input type="radio" id="' . $this->id . '-' . $preset . '" name="' . $this->handle . '" value="' . $preset . '" ' . checked( $preset, $input, false ) . ' />';
                  echo '<label for="' . $this->id . '-' . $preset . '">';
                  echo '<strong><i class="icon-circle-empty"></i><i class="icon-circle"></i>' . $title . '</strong>';
                  echo '<div class="quick-preview"' . $quick_preview_style . '></div>';
                  echo '</label>';
                  echo '</li>';
               } ?>
            </ul>
         </div>

      </div>

      <?php return ob_get_clean();

   }

   /**
    * Sanitize any user input
    *
    * @param mixed $input The input value
    * @return string
    */
   public function sanitize_input( $input = null ) {

      global $canvys;

      // Validate Input
      return cv_filter( $input, array_keys( $canvys['bg_patterns'] ) );

   }

}
endif;