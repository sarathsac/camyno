<?php

if ( ! class_exists('CV_Contact_Form') ) :

/**
 * Contact Form
 * Class that handles the creation and configuration
 * of the contact form shortcode
 *
 * @package      WordPress
 * @subpackage   Canvys
 * @since        Version 1.0
 */
class CV_Contact_Form extends CV_Shortcode {

   /**
    * Function to create shortcode configuration
    *
    * @return void
    */
   public function __construct() {

      $this->config = array(

         // Handle will be used to use this shortcode
         'handle' => 'cv_contact_form',

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
         'title' => __( 'Contact Form', 'canvys' ),

         // Icon will be used to represent this shortcode in composer/builder
         // List of available icons can be found in icons.json
         'icon' => 'mail',

         // Whether or not shortcode is self closing
         'self_closing' => false,

         // If shortcode is not self closing, specify its default content
         'default_content' => '[cv_form_field type="text" width="1/2" label="' . __( 'Full Name', 'canvys' ) . '"][/cv_form_field]'
                            . '[cv_form_field type="email" width="1/2" label="' . __( 'Valid E-Mail Address', 'canvys' ) . '"][/cv_form_field]'
                            . '[cv_form_field type="textarea" label="' . __( 'Message', 'canvys' ) . '"][/cv_form_field]',

         // Specify whether or not content is directly editable
         'content_editor' => false,

         // Specify whether or not the content is composed of another shortcode
         'content_element' => 'cv_form_field',

         // Provide an explanation of what this shortcode does
         'explanation' => __( 'This is a simplified contact form builder designed to get your site up and running with beautiful custom contact forms as quickly as possible. For a more thorough form builder it is recommended you use the popular Gravity Forms plugin which is fully supported by this theme.', 'canvys' ),

         // Array of shortcode settings and their respective attributes
         'attributes' => array(

            new CV_Shortcode_Text_Control( 'title', array(
               'title'       => __( 'Optional Form Title', 'canvys' ),
               'description' => __( 'Specify a title for this form which will be displayed just above the form.', 'canvys' ),
            ) ),

            new CV_Shortcode_Select_Control( 'alt_style', array(
               'title'       => __( 'Form Style', 'canvys' ),
               'description' => __( 'Specify which style to use to display the form.', 'canvys' ),
               'default'     => 'false',
               'options'     => array(
                  'false' => __( 'Standard', 'canvys' ),
                  'true'  => __( 'Alternate', 'canvys' ),
               ),
            ) ),

            new CV_Shortcode_Text_Control( 'recipient_email', array(
               'title'       => __( 'Recipient E-mail Address', 'canvys' ),
               'description' => sprintf( __( 'Specify the email address that form submissions should be sent to, if left blank any form submissions will be sent to the admin email address (<i>%s</i>). You can specify multiple email addresses, they must be separatd by only a comma.', 'canvys' ), get_option('admin_email') ),
               'placeholder' => get_option('admin_email'),
            ) ),

            new CV_Shortcode_Text_Control( 'button_label', array(
               'title'       => __( 'Submit Button Label', 'canvys' ),
               'description' => __( 'Specify the label for the submit form button. Defaults to <i>Submit</i> if left blank.', 'canvys' ),
               'placeholder' => __( 'Submit', 'canvys' ),
            ) ),

            new CV_Shortcode_Text_Control( 'sent_message', array(
               'title'       => __( 'Form Submitted Message', 'canvys' ),
               'description' => sprintf( __( 'Specify the message that users will see after submitting this form. Defaults to %s if left blank.', 'canvys' ), '<i>' . CV_FORM_MESSAGE_SENT_DEFAULT . '</i>' ),
               'placeholder' => __( 'Your message has been sent!', 'canvys' ),
            ) ),

            new CV_Shortcode_Text_Control( 'email_subject', array(
               'title'       => __( 'Recieved E-Mail Subject', 'canvys' ),
               'description' => sprintf( __( 'Specify the subject of the emails you will recieve from this form, if left blank it will default to <i>New Message [Sent by contact form at %s]</i>.', 'canvys' ), get_bloginfo('name') ),
               'placeholder' => sprintf( __( 'New Message [Sent by contact form at %s]', 'canvys' ), get_bloginfo('name') ),
            ) ),

         ),
      );
   }

   /**
    * Renders inline CSS required by the shortcode composer
    *
    * @return mixed
    */
   public function composer_additional_styles() { ?>

      <style id="cv-builder-cv_contact_form">
         .cv-compose-shortcode.editing-cv_contact_form .content-elements-size-limiter {
            max-width: 850px;
         }
         .cv-compose-shortcode.editing-cv_contact_form .content-elements-size-limiter .cv-module-placeholder {
            float: left;
            margin-left: 1%;
            margin-right: 1%;
         }
         .cv-compose-shortcode.editing-cv_contact_form .content-elements-size-limiter .cv-add-module {
            margin-left: 1%;
            margin-right: 1%;
         }
      </style>

   <?php }

   /**
    * Callback function for front end shortcode styles
    *
    * @param array $sections Color scheme settings
    * @return string
    */
   public static function front_end_styles( $sections ) {

      foreach ( $sections as $section => $colors ) {

         $section_tag = '.cv-section-' . $section;

         // Alt style
         echo
           $section_tag . " .cv-form.alt-style select {"
         . "color: " . cv_hex_to_rgba( $colors['content'], 0.5 ) . ";"
         . "}"
         . $section_tag . " .cv-form.alt-style .cv-select-box:after {"
         . "color: " . cv_hex_to_rgba( $colors['content'], 0.35 ) . ";"
         . "}"
         . $section_tag . " .cv-form.alt-style .cv-select-box:hover:after {"
         . "color: " . cv_hex_to_rgba( $colors['content'], 0.75 ) . ";"
         . "}"
         . $section_tag . " .cv-form.alt-style input::-webkit-input-placeholder {"
         . "color: " . cv_hex_to_rgba( $colors['content'], 0.5 ) . ";"
         . "}"
         . $section_tag . " .cv-form.alt-style input:-moz-placeholder {"
         . "color: " . cv_hex_to_rgba( $colors['content'], 0.5 ) . ";"
         . "}"
         . $section_tag . " .cv-form.alt-style input::-moz-placeholder {"
         . "color: " . cv_hex_to_rgba( $colors['content'], 0.5 ) . ";"
         . "}"
         . $section_tag . " .cv-form.alt-style input:-ms-placeholder {"
         . "color: " . cv_hex_to_rgba( $colors['content'], 0.5 ) . ";"
         . "}"
         ;

      }

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

      static $num_forms;

      // Start with an empty array
      $cv_form_fields = array();

      // Fill the toggles array
      do_shortcode( $content );

      // Make sure there is atleast 1 toggle
      if ( empty( $cv_form_fields ) ) {
         return;
      }

      // Total number of forms
      $num_forms++;

      // Create attributes array by sanitizing provided values
      extract( $this->get_sanitized_attributes( $atts ) );

      // The slug to identify the form when being submitted
      $form_slug = 'cv-form-' . $num_forms;

      // Setup some variables
      $submitted = isset( $_POST[$form_slug . '-submitted'] );
      $success = false;
      $email_body = '';
      $sender_email = false;
      $form_error = false;
      $num_fields = 0;
      $o = null;

      // Determine which style to use
      $alt_style = cv_make_bool( $alt_style ) ? ' alt-style' : null;

      // Form wrapper
      $o .= '<form method="post" action="" class="cv-form' . $alt_style . '" id="' . $form_slug . '">';

      // Form Title
      if ( $title ) {
         $o .= '<div class="form-title"><h2>' . $title . '</h2></div>';
      }

      // Fields wrapper
      $o .= '<div class="form-fields has-clearfix">';

      $row_width = 0;
      foreach ( $cv_form_fields as $field ) {

         // Keep track of number of fields
         $num_fields++;

         //  Create a unique ID
         $id = $form_slug . '-field-' . $num_fields;

         // Grab the value
         $val = $submitted && isset( $_POST[$id] ) ? 'checkbox' == $field['type'] ? true : $_POST[$id] : false;
         $val = $val ? stripslashes($val) : false;

         // Set has error to false
         $field_error = false;

         // Whether or not field is required
         $required = cv_make_bool( $field['required'] );

         // Create the label
         $label = new CV_HTML( '<label>', array(
            'content' => $field['label'],
            'for' => $id,
         ) );

         // Add the required marker
         if ( $required ) {
            $label->append( '<span class="required-marker">*</span>' );
         }

         // Start with an empty control
         $control = null;

         // Create field wrapper
         $field_wrap = new CV_HTML( '<div>', array(
            'class' => 'cv-field has-' . $field['type'],
         ) );

         // Apply the width style
         $field_wrap->add_class( 'width-' . str_replace( '/', '', $field['width'] ) );

         // Create the control
         switch ( $field['type'] ) {

            /* Text Input */
            case 'text':

               // Validate input
               if ( $submitted ) {

                  // Throw an error
                  if ( ! $val && $required ) $field_error = true;

                  // Sanitize input
                  $val = cv_filter( $val, 'text' );

                  // Add field to email
                  $email_body .= $field['label'] . ": " . $val . "\r\n\n";

               }

               // Create the control
               $control = new CV_HTML( '<input />', array(
                  'type' => 'text',
                  'name' => $id,
                  'id' => $id,
                  'value' => $val,
                  'placeholder' => $field['placeholder'],
               ) );

               // Apply required attribute
               if ( $required ) {
                  $control->attr( 'required' );
               }

               break;

            /* Numeric Input */
            case 'numeric':

               // Validate input
               if ( $submitted ) {

                  // Throw an error
                  if ( $required && ( ! $val || ! is_numeric( $val ) ) ) $field_error = true;

                  // Sanitize input
                  $val = cv_filter( $val, 'integer' );

                  // Add field to email
                  $email_body .= $field['label'] . ": " . $val . "\r\n\n";

               }

               // Create the control
               $control = new CV_HTML( '<input />', array(
                  'type' => 'number',
                  'name' => $id,
                  'id' => $id,
                  'value' => $val,
                  'placeholder' => $field['placeholder'],
               ) );

               // Apply required attribute
               if ( $required ) {
                  $control->attr( 'required' );
               }

               break;

            /* Email Input */
            case 'email':

               // Validate input
               if ( $submitted ) {

                  // Throw an error
                  if ( $required && ( ! $val || ! filter_var( $val, FILTER_VALIDATE_EMAIL ) ) ) $field_error = true;

                  // Sanitize input
                  $val = cv_filter( $val, 'email' );

                  // Add field to email
                  $email_body .= $field['label'] . ": " . $val . "\r\n\n";

               }

               // Create the control
               $control = new CV_HTML( '<input />', array(
                  'type' => 'email',
                  'name' => $id,
                  'id' => $id,
                  'value' => $val,
                  'placeholder' => $field['placeholder'],
               ) );

               // Apply required attribute
               if ( $required ) {
                  $control->attr( 'required' );
               }

               break;

            /* Checkbox Input */
            case 'checkbox':

               // Throw an error
               if ( $submitted && $required && ! $val ) $field_error = true;

               if ( $submitted ) {

                  // Add field to email
                  $email_body .= $field['label'] . ": ";
                  $email_body .= $val ? __('Was Checked', 'canvys') : __('Was Left Unchecked', 'canvys');
                  $email_body .= "\r\n\n";

               }

               // Create the control
               $control = new CV_HTML( '<input />', array(
                  'type' => 'checkbox',
                  'name' => $id,
                  'id' => $id,
                  'value' => '1',
               ) );

               // Apply the checked attribute
               if ( $val || ( ! $submitted && 'true' == $field['initial_status'] ) ) {
                  $control->attr( 'checked', 'checked' );
               }

               // Apply the checked by default attribute
               if ( 'true' == $field['initial_status'] ) {
                  $control->data( 'default', 'checked' );
               }

               // Apply required attribute
               if ( $required ) {
                  $control->attr( 'required' );
               }

               // Add the control to the label
               $label->prepend( $control );
               $control = null;

               break;

            /* Textarea Input */
            case 'textarea':

               // Validate input
               if ( $submitted ) {

                  // Throw an error
                  if ( ! $val && $required ) $field_error = true;

                  // Sanitize input
                  $val = cv_filter( $val, 'text' );

                  // Add field to email
                  $email_body .= $field['label'] . ": " . $val . "\r\n\n";

               }

               // Create the control
               $control = new CV_HTML( '<textarea>', array(
                  'name' => $id,
                  'id' => $id,
                  'content' => $val,
               ) );

               // Apply required attribute
               if ( $required ) {
                  $control->attr( 'required' );
               }

               break;

            /* Select Input */
            case 'select':

               // Create options array
               $options = array();
               foreach ( explode( '|', $field['options'] ) as $option ) {
                  $options[] = $option;
               }

               if ( $submitted ) {

                  // Sanitize the value
                  $val = cv_filter( $val, $options );

                  // Add field to email
                  $email_body .= $field['label'] . ": " . $val . "\r\n\n";

               }

               // Create the control
               $control = new CV_HTML( '<select>', array(
                  'name' => $id,
                  'id' => $id,
               ) );

               // Add the options
               foreach ( $options as $option ) {
                  $control->append( '<option value="' . $option . '" ' . selected( $val, $option, false ) . '>' . $option . '</option>' );
               }

               break;

         }

         // Apply the error class
         if ( $field_error ) {
            $form_error = true;
            $field_wrap->add_class( 'has-error' );
         }

         // Add the label & control
         $field_wrap->append( $label . $control );

         switch ( $field['width'] ) {
            case 'full': $row_width = 1; $o .= '<div class="clearfix"></div>'; break;
            case '1/2': $row_width += 0.5; break;
            case '1/3': $row_width += 0.33; break;
            case '1/4': $row_width += 0.25; break;
         }

         // Add the field to the form
         $o .= $field_wrap;

         if ( 0.9 < $row_width ) {
            $o .= '<div class="clearfix"></div>';
            $row_width = 0;
         }

      }

      // Close the form
      $button_label = $button_label ? $button_label : __( 'Submit', 'canvys' );
      $o .= '</div>';
      $o .= '<div class="submit-box has-clearfix">';
      $o .= '<input type="hidden" name="' . $form_slug . '-submitted" value="true" />';
      $o .= '<button type="button" class="button is-thin is-ghost color-content clear-form">' .__( 'Clear Form', 'canvys' ) . '</button> ';
      $o .= '<button type="submit" class="button is-thin is-ghost color-accent">' . $button_label . '</button>';
      $o .= '</div>';
      $o .= '</form>';

      // if form has been submitted without any errors
      if ( $submitted && ! $form_error ) {

         // Determine which address the email should be sent to
         if ( ! $recipient_email ) $recipient_email = get_option('admin_email');

         // Provide an informative title for our message
         $subject = $email_subject ? $email_subject : sprintf( __( 'New Message [Sent by contact form at %s]', 'canvys' ), get_bloginfo('name') );

         // If an email address was not provided in the form, use the recipient email
         if ( ! $sender_email ) $sender_email = $recipient_email;

         // Create the headers depending on whether or not an email was provided
         $headers = 'From: ' . $sender_email . ' <' . $sender_email . '>' . "\r\n" . 'Reply-To: ' . $sender_email;

         // Call the function to send the message
         wp_mail( $recipient_email, $subject, $email_body, $headers);

         // Review Wrapper
         $sent_message = $sent_message ? $sent_message : CV_FORM_MESSAGE_SENT_DEFAULT;
         $o  = '<div class="form-submitted is-animated">';
         $o .= '<h2>' . $sent_message . '</h2>';
         if ( CV_FORM_REVIEW_MESSAGE ) $o .= '<h3>' . CV_FORM_REVIEW_MESSAGE . '</h3>';
         $o .= '<ul>';

         $num_fields = 0;
         foreach ( $cv_form_fields as $field ) {

            // Keep track of number of fields
            $num_fields++;

            if ( 'captcha' == $field['type'] ) {
               continue;
            }

            //  Create a unique ID
            $id = $form_slug . '-field-' . $num_fields;

            // Grab value if form has been submitted
            $val = isset( $_POST[$id] ) ? 'checkbox' == $field['type'] ? true : $_POST[$id] : false;
            $val = stripslashes( $val );

            if ( $val && 'checkbox' == $field['type'] ) {
               $val = __( 'Was Checked', 'canvys' );
            }

            else if ( 'checkbox' == $field['type'] ) {
               $val = __( 'Was Not Checked', 'canvys' );
            }

            if ( ! $val ) {
               $val = __( 'Was left blank', 'canvys' );
            }

            $o .= '<li><strong>' . $field['label'] . ': </strong>' . $val . '</li>';

         }

         // Close review section
         $o .= '</div>';
         $o .= '<ul>';

      }

      return $o;

   }

}
endif;