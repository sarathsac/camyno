<?php

if ( ! class_exists('CV_Contact_Form_7') ) :

/**
 * Contact Form 7 Shortcode
 * Class that handles the creation and configuration
 * of the contact form 7 shortcode in the template builder
 *
 * @package      WordPress
 * @subpackage   Canvys
 * @since        Version 1.0
 */
class CV_Contact_Form_7 extends CV_Shortcode {

   /**
    * Function to create shortcode configuration
    *
    * @return void
    */
   public function __construct() {

      $forms = get_posts( array(
         'post_type' => 'wpcf7_contact_form',
      ) );

      $form_options = array(
         'none' => __( 'None', 'canvys' ),
      );

      if ( is_array( $forms ) && ! empty( $forms ) ) {
         foreach ( $forms as $form ) {
            $form_options[$form->ID] = $form->post_title;
         }
      }

      $this->config = array(

         // Handle will be used to use this shortcode
         'handle' => 'contact-form-7',

         // Whether or not this is a shortcode composer element
         'composer_element' => true,

         // Whether or not this is a template builder element
         'builder_element' => true,

         // Used by the template builder to determine where module can be dropped
         'drop_target' => 2,

         // Used by the template builder to determine where module can have other
         // modules dropped inside of it
         'drop_zone' => false,

         // Title will be used to identify this shortcode
         'title' => __( 'Contact Form 7', 'canvys' ),

         // Icon will be used to represent this shortcode in composer/builder
         // List of available icons can be found in icons.json
         'icon' => 'mail-1',

         // Whether or not shortcode is self closing
         'self_closing' => true,

         // If shortcode is not self closing, specify its default content
         'default_content' => null,

         // Specify whether or not content is directly editable
         'content_editor' => false,

         // Specify whether or not the content is composed of another shortcode
         'content_element' => false,

         // Array of shortcode settings and their respective attributes
         'attributes' => array(

            new CV_Shortcode_Select_Control( 'id', array(
               'title'         => __( 'Contact Form', 'canvys' ),
               'description'   => __( 'Select the Contact Form 7 form to display.', 'canvys' ),
               'default'       => 'none',
               'options'       => $form_options,
            ) ),

            new CV_Shortcode_Text_Control( 'title', array(
               'title'         => __( 'Title', 'canvys' ),
               'description'   => __( 'Enter a title for this form', 'canvys' ),
            ) ),

         ),
      );
   }

   /**
    * Renders inline JavaScript/CSS required by the shortcode composer
    *
    * @return mixed
    */
   public function composer_additional_assets() { ?>
      <script id="cv-builder-contact-form-7-script">
         (function($){
            "use strict";
            $(document).on( 'cv-composer-load-contact-form-7', function() {
               var $modal = $('#cv-composer-absolute-container').children().last();
               var $idControl = $modal.find('.control-id select');
               var $titleControl = $modal.find('.control-title input');
               var title, val;
               $idControl.on( 'change', function() {
                  val = $idControl.val();
                  title = 'none' === val ? '' : $idControl.find('[value="'+val+'"]').html();
                  $titleControl.val(title).trigger('change');
               });
            });
         })(jQuery);
      </script>
   <?php }

   /**
    * Callback function for displaying the template builder module title
    *
    * @param array  $atts      Array of provided attributes
    * @param string $content   Content of shortcode
    * @return string
    */
   public function builder_module_title( $atts, $content = null ) {
      $atts = $this->get_sanitized_attributes( $atts );
      $title = isset( $atts['title'] ) && trim( $atts['title'] ) ? $atts['title'] : __( 'No Title', 'canvys' );
      return '<i class="cv-module-icon icon-' . $this->config['icon'] . '"></i><strong>' . $this->config['title'] . ': </strong>' . $title;
   }

}
endif;