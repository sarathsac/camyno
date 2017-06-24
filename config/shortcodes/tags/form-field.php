<?php

if ( ! class_exists('CV_Form_Field') ) :

/**
 * Contact Form Field
 * Class that handles the creation and configuration
 * of the form field shortcode which is a child of the contact form shortcode
 *
 * @package      WordPress
 * @subpackage   Canvys
 * @since        Version 1.0
 */
class CV_Form_Field extends CV_Shortcode {

   /**
    * Function to create shortcode configuration
    *
    * @return void
    */
   public function __construct() {

      $this->config = array(

         // Handle will be used to use this shortcode
         'handle' => 'cv_form_field',

         // Whether or not this is a shortcode composer element
         'composer_element' => false,

         // Whether or not this is a template builder element
         'builder_element' => true,

         // Used by the template builder to determine where module can be dropped
         'drop_target' => 3,

         // Used by the template builder to determine where module can have other
         // modules dropped inside of it
         'drop_zone' => false,

         // Title will be used to identify this shortcode
         'title' => __( 'Field', 'canvys' ),

         // Icon will be used to represent this shortcode in composer/builder
         // List of available icons can be found in icons.json
         'icon' => 'mail',

         // Whether or not shortcode is self closing
         'self_closing' => true,

         // If shortcode is not self closing, specify its default content
         'default_content' =>  null,

         // Specify whether or not content is directly editable
         'content_editor' => false,

         // Specify whether or not the content is composed of another shortcode
         'content_element' => false,

         // Array of shortcode settings and their respective attributes
         'attributes' => array(

            new CV_Shortcode_Select_Control( 'type', array(
               'title'       => __( 'Field Type', 'canvys' ),
               'default'     => 'text',
               'options'     => array(
                  'text'     => __( 'Basic Text Input', 'canvys' ),
                  'numeric'  => __( 'Numeric Input', 'canvys' ),
                  'email'    => __( 'E-Mail Address', 'canvys' ),
                  'checkbox' => __( 'Checkbox', 'canvys' ),
                  'textarea' => __( 'Textarea', 'canvys' ),
                  'select'   => __( 'Select Box', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Text_Control( 'label', array(
               'title' => __( 'Field Label', 'canvys' ),
            ) ),

            new CV_Shortcode_Text_Control( 'placeholder', array(
               'title'       => __( 'Field Placeholder', 'canvys' ),
               'description' => __( 'Optionaly add a placeholder for this field.', 'canvys' ),
            ) ),

            new CV_Shortcode_Select_Control( 'required', array(
               'title'       => __( 'Required Field', 'canvys' ),
               'description' => __( 'Specify whether or not this field is required, for checkboxes this means that the checkbox must be checked to submit the form.', 'canvys' ),
               'default'     => 'true',
               'options'     => array(
                  'true'  => __( 'yes, this field is required', 'canvys' ),
                  'false' => __( 'No, this field is not required', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Select_Control( 'width', array(
               'title'       => __( 'Field Width', 'canvys' ),
               'description' => __( 'Specify the displayed width of this field, fields will be placed side by side to fill the width of the form.', 'canvys' ),
               'default'     => 'full',
               'options'     => array(
                  'full' => __( 'Full Width', 'canvys' ),
                  '1/2'  => __( '1/2 Width (50%)', 'canvys' ),
                  '1/3'  => __( '1/3 Width (33%)', 'canvys' ),
                  '1/4'  => __( '1/4 Width (25%)', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_List_Control( 'options', array(
               'title'       => __( 'Available Options', 'canvys' ),
               'description' => __( 'Vertical Bar delimited list of available options, the first option will be used as the default. Example: Option 1|Option 2|Option 3', 'canvys' ),
               'separator'   => '|',
            ) ),

            new CV_Shortcode_Select_Control( 'initial_status', array(
               'title'       => __( 'Initial Checkbox Status', 'canvys' ),
               'description' => __( 'Specify whether or not the checkbox should be checked upon page load.', 'canvys' ),
               'default'     => 'false',
               'options'     => array(
                  'false' => __( 'No, checkbox should not be checked', 'canvys' ),
                  'true'  => __( 'Yes, checkbox should be checked', 'canvys' ),
               ),
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

      <script id="cv-builder-cv_form_field-script">
         (function($){
            "use strict";

            $(document).on( 'cv-composer-load-cv_form_field', function() {

               var $modal = $('#cv-composer-absolute-container').children().last();
               var $typeControl = $modal.find('.control-type select');
               var $placeholderControl = $modal.find('.control-placeholder');
               var $optionsControl = $modal.find('.control-options');
               var $sizeControl = $modal.find('.control-width');
               var $initialControl = $modal.find('.control-initial_status');
               var $requiredControl = $modal.find('.control-required');

               $typeControl.on( 'change', function() {

                  var val = $typeControl.val();

                  // Select
                  if ( 'select' === val ) {
                     $optionsControl.fadeIn();
                     $requiredControl.hide().find('select').val('false');
                  }
                  else {
                     $optionsControl.hide().find('.cv-commalist-items').html('');
                     $requiredControl.fadeIn();
                  }

                  // Checkbox
                  if ( 'checkbox' === val ) { $initialControl.fadeIn(); }
                  else { $initialControl.hide().find('select').val('false'); }

                  // Show/Hide size control
                  if ( 'textarea' === val || 'checkbox' === val ) { $sizeControl.hide().find('select').val('full'); }
                  else { $sizeControl.fadeIn(); }

                  // Show / hide placeholder control
                  if ( 'checkbox' === val || 'textarea' === val || 'select' === val ) { $placeholderControl.hide().find('input').val(''); }
                  else { $placeholderControl.fadeIn(); }

               }).trigger('change');
            });
         })(jQuery);
      </script>

   <?php }

   /**
    * Renders inline CSS required by the shortcode composer
    *
    * @return mixed
    */
   public function composer_additional_styles() { ?>

      <style id="cv-builder-cv_form_field">

         .cv-module-cv_form_field {
            width: 98% !important;
            clear: none !important;
            margin-left: 1%;
            margin-right: 1%;
            float: left;
         }

         .cv-module-preview .cv-module-cv_form_field .cv-module-title strong {
            display: none;
         }

         /* Style different sizes */
         @media (min-width: 800px) {
            .cv-module-cv_form_field.width-12 {
               width: 48% !important;
            }
            .cv-module-cv_form_field.width-13 {
               width: 31% !important;
            }
            .cv-module-cv_form_field.width-14 {
               width: 23% !important;
            }
         }

      </style>

   <?php }

   /**
    * Callback function for displaying the template builder module title
    *
    * @param array  $atts      Array of provided attributes
    * @param string $content   Content of shortcode
    * @return string
    */
   public function builder_module_title( $atts, $content = null ) {
      $title = isset($atts['label']) && $atts['label'] ? $atts['label'] : __( 'No Label', 'canvys' );
      switch ( $atts['type'] ) {
         case 'text': $type = __( 'Text Box:', 'canvys' ); break;
         case 'numeric': $type = __( 'Numeric:', 'canvys' ); break;
         case 'email': $type = __( 'E-Mail:', 'canvys' ); break;
         case 'checkbox': $type = __( 'Checkbox:', 'canvys' ); break;
         case 'textarea': $type = __( 'Textarea:', 'canvys' ); break;
         case 'select': $type = __( 'Select Box:', 'canvys' ); break;
      }
      return '<strong>' . $type . '</strong>' . ' ' . $title;
   }

   /**
    * Callback function for front end display of shortcode
    *
    * @param array  $atts      Array of provided attributes
    * @param string $content   Content of shortcode
    * @return string
    */
   public function callback( $atts, $content = null ) {

      global $cv_form_fields;

      if ( ! is_array( $cv_form_fields ) ) {
         $cv_form_fields = array();
      }

      // Create attributes array by sanitizing provided values
      extract( $this->get_sanitized_attributes( $atts ) );

      $cv_form_fields[] = array(
         'type'           => $type,
         'label'          => $label,
         'placeholder'    => $placeholder,
         'required'       => $required,
         'width'          => $width,
         'options'        => $options,
         'initial_status' => $initial_status,
      );

   }

}
endif;