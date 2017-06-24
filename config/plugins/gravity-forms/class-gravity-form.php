<?php

if ( ! class_exists('CV_Gravity_Form') ) :

/**
 * Gravity Form
 * Class that handles the creation and configuration
 * of the Gravity Form shortcode in the template builder
 *
 * @package      WordPress
 * @subpackage   Canvys
 * @since        Version 1.0
 */
class CV_Gravity_Form extends CV_Shortcode {

   /**
    * Function to create shortcode configuration
    *
    * @return void
    */
   public function __construct() {

      // set up the options
      $gravity_forms = class_exists('RGFormsModel') ? RGFormsModel::get_forms( null, 'title' ) : null;
      $this->form_options = array(
         'none' => __( 'None', 'canvys' ),
      );
      if ( is_array( $gravity_forms ) ) {
         foreach ( $gravity_forms as $form ) {
            if ( isset( $form->id ) && isset( $form->title ) ) {
               $this->form_options[$form->id] = $form->title;
            }
         }
      }

      $this->config = array(

         // Handle will be used to use this shortcode
         'handle' => 'gravityform',

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
         'title' => __( 'Gravity Form', 'canvys' ),

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

         // Provide an explanation of what this shortcode does
         'explanation' => __( 'Gravity Forms is a 3rd party plugin, and can only be created/edited from its respective plugin page. Once you have created at least one Gravity Form you will be able to easily display it using this module.', 'canvys' ),

         // Array of shortcode settings and their respective attributes
         'attributes' => array(

            new CV_Shortcode_Select_Control( 'id', array(
               'title'         => __( 'Gravity Form', 'canvys' ),
               'description'   => __( 'Select the Gravity Forms form to display.', 'canvys' ),
               'default'       => 'none',
               'options'       => $this->form_options,
            ) ),

            new CV_Shortcode_Select_Control( 'title', array(
               'title'         => __( 'Display the Title', 'canvys' ),
               'description'   => __( 'Specify whether or not the title should be displayed automatically.', 'canvys' ),
               'default'       => 'true',
               'options'       => array(
                  'true'  => __( 'Yes, display the title', 'canvys' ),
                  'false' => __( 'No, do not display the title', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Select_Control( 'description', array(
               'title'         => __( 'Display the Description', 'canvys' ),
               'description'   => __( 'Specify whether or not the description should be displayed automatically.', 'canvys' ),
               'default'       => 'true',
               'options'       => array(
                  'true'  => __( 'Yes, display the description', 'canvys' ),
                  'false' => __( 'No, do not display the description', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Select_Control( 'ajax', array(
               'title'         => __( 'Enable AJAX', 'canvys' ),
               'description'   => __( 'Specify whether or not the form should be able to be submitted via AJAX.', 'canvys' ),
               'default'       => 'false',
               'options'       => array(
                  'true'  => __( 'Yes, allow AJAX', 'canvys' ),
                  'false' => __( 'No, do not allow AJAX', 'canvys' ),
               ),
            ) ),

         ),
      );
   }

   /**
    * Callback function for display of preview in builder module
    *
    * @param array  $atts      Array of provided attributes
    * @param string $content   Content of shortcode
    * @return string
    */
   public function builder_module_preview( $atts, $content = null ) {
      if ( ! isset( $atts['id'] ) || 'none' === $atts['id'] || ! class_exists( 'RGFormsModel' ) ) {
         return false;
      }
      if ( ! $form = RGFormsModel::get_form_meta_by_id( $atts['id'] ) ) {
         return false;
      }
      if ( ! isset( $form[0]['fields'] ) || empty( $form[0]['fields'] ) ) {
         return false;
      }
      $o = '<h2 style="margin-bottom:20px !important;text-align:center;">' . $this->form_options[$atts['id']] . '</h2>';
      foreach ( array_slice( $form[0]['fields'], 0, 12 ) as $field ) {
         if ( ! isset( $field['label'] ) ) {
            continue;
         }
         if ( ! trim( $field['label'] ) ) $field['label'] = __( 'Untitled', 'canvys' );
         $o .= '<div class="cv-builder-module no-dropzone has-clearfix" data-droptarget="3" style="width:23%;margin-left:1%;margin-right:1%;float:left;clear:none;">';
         $o .= '<strong class="cv-module-title">' . $field['label'] . '</strong>';
         $o .= '</div>';
      }
      return $o;
   }

}
endif;