(function($) {
   "use strict";

   var $document = $(document);

   $document.on( 'keydown', function(e) {

      // Make sure events have not been suspended
      if ( $('body').hasClass('cv-suspend-modal-events') ) {
         return;
      }

      // If the content editor modal is open
      if ( $('body').hasClass('cv-shortcode-content-wp-editor-active') ) {
         switch (e.keyCode) {
            case 27: // ESC Key
               $('#cv-shortcode-content-wp-editor-wrap-cancel').trigger('click');
               e.stopImmediatePropagation();
               e.preventDefault();
               break;
            case 13: // ENTER Key
               // Make sure user is not editing a textarea
               if ( e.target.tagName && e.target.tagName.toLowerCase() === 'textarea' ) {
                  return;
               }
               $('#cv-shortcode-content-wp-editor-wrap-submit').trigger('click');
               e.stopImmediatePropagation();
               e.preventDefault();
               break;
         }
      }


      // If at least one modal is active
      else if ( $('body').hasClass('cv-composer-active') ) {
         switch (e.keyCode) {
            case 27: // ESC Key
               $('#cv-composer-absolute-container').children().last().trigger( 'cancel-modal' );
               e.stopImmediatePropagation();
               e.preventDefault();
               break;
            case 13: // ENTER Key
               // Make sure user is not editing a textarea
               if ( e.target.tagName && e.target.tagName.toLowerCase() === 'textarea' ) {
                  return;
               }
               $('#cv-composer-absolute-container').children().last().trigger( 'submit-modal' );
               e.stopImmediatePropagation();
               e.preventDefault();
               break;
         }
      }


   });

   $.CVComposerModal = function( config ) {

      var defaults = {
         title: null,              // Modal display title
         action: null,             // Event to be triggered on document element when modal is loaded
         content: null,            // Will be used instead of AJAX
         ajax_callback: null,      // AJAX callback for rendering the content
         ajax_url: null,           // Custom AJAX URL
         ajax_param: '',           // AJAX paramater
         add_class: '',            // Extra classes to add to the modal
         modal_content: null,      // Predefined content to use instead of AJAX callback
         submit_button: true,      // Whether or not the submit button should be shown
         cancel_button: true,      // Whether or not the cancel button should be shown
         on_start: function() {},  // Function to be executed when modal begins
         on_load: function() {},   // Function to be executed when modal loads
         on_submit: function() {}, // Function to be executed when submit button is pressed
         on_cancel: function() {}, // Function to be executed when cancel button is pressed
         on_close: function() {},  // Function to be executed when modal closes
      };

      // Set up options
      this.config = $.extend( {}, defaults, config );

      // Make sure there is content to render
      if ( ! this.config.content && ! this.config.ajax_callback && ! this.config.ajax_url ) {
         return;
      }

      // Limit the length of the title
      var titleLimit = 50;
      if ( this.config.title.length > titleLimit ) {
         this.config.title = this.config.title.substring(0, titleLimit);
         this.config.title = this.config.title+"...";
      }

      // Grab the modal template
      this.$modal = $( $('#cv-tmpl-composer-modal').html() );
      this.$overlay = this.$modal.find('.cv-composer-overlay');
      this.$title = this.$modal.find('.cv-composer-title');

      // Append the modal
      $('#cv-composer-absolute-container').append(this.$modal);
      $('body').addClass('cv-composer-active');
      this.config.on_start( this.$modal );

      // Launch setup
      this.init();

   };

   $.CVComposerModal.prototype = {

      init: function() {
         this.attach_events();
         this.set_html();
         this.start();
      },

      attach_events: function() {

         var obj = this;

         // Pressing the dark area
         obj.$modal.on( 'click', function(e) {
            if ( 'cv-composer-overlay' === $(e.target).attr('class') ) {
               obj.$modal.trigger( 'cancel-modal' );
            }
         });

         // Pressing the update button
         if ( obj.config.submit_button ) {
            obj.$modal.find('.cv-composer-submit').eq(0).on( 'click', function() {
               obj.$modal.trigger( 'submit-modal' );
            });
         }

         // Pressing the cancel button
         if ( obj.config.cancel_button ) {
            obj.$modal.find('.cv-composer-cancel').eq(0).on( 'click', function() {
               obj.$modal.trigger( 'cancel-modal' );
            });
         }

         // When modal is submitted
         obj.$modal.on( 'submit-modal', function() {
            obj.config.on_submit( obj.$modal );
            obj.close();
         });

         // When modal is `cancelled`
         obj.$modal.on( 'cancel-modal', function() {
            obj.config.on_cancel( obj.$modal );
            obj.close();
         });

      },

      set_html: function() {

         var obj = this;

         // Set the title
         obj.$title.html( obj.config.title );

         // Add any additional classes
         obj.$modal.addClass( obj.config.add_class );

         // Remove submit button
         if ( ! obj.config.submit_button ) {
            obj.$modal.find('.cv-composer-submit').eq(0).remove();
         }

         // Remove cancel button
         if ( ! obj.config.cancel_button ) {
            obj.$modal.find('.cv-composer-cancel').eq(0).remove();
         }

         // Apply minimum height to container
         obj.$modal.find('.cv-composer-modal').eq(0).css('min-height', parseInt( $(window).outerHeight() )-55 );

      },

      start: function() {

         var obj = this;

         // If content has already been defined
         if ( obj.config.content ) {
            obj.$modal.find('.cv-composer-modal').eq(0).html(obj.config.content);
            obj.open();
            return;
         }

         // Create object for AJAX callback
         var data = {
            param: obj.config.ajax_param
         };

         if ( ! obj.config.ajax_url ) {
            data.action = 'cv_ajax_'+obj.config.ajax_callback;
         }

         var ajax_url = obj.config.ajax_url ? obj.config.ajax_url : cv_modal_localize.ajax_url;

         // Execute AJAX callback
         $.ajax({

            type: 'POST',
            url: ajax_url,
            data: data,

            error: function() {
               alert(cv_modal_localize.ajax_error)
            },

            success: function( response ) {

               // User was loged out
               if ( 0 === response ) {
                  alert(cv_modal_localize.ajax_logged_out);
               }

               // Nonce timeout
               else if ( '-1' === response ) {
                  alert(cv_modal_localize.ajax_nonce_error);
               }

               // Actual success
               else {
                  obj.$modal.find('.cv-composer-modal').eq(0).html(response);
                  obj.open();
               }

            },

         });

      },

      open: function() {
         var obj = this;
         setTimeout( function() {
            obj.config.on_load( obj.$modal );
            obj.$modal.find('.cv-composer-container').eq(0).css('opacity', 1);
            $document.trigger('dom-change');
            $document.trigger('cv-composer-load');
            $document.trigger('cv-composer-load-'+obj.config.action);
            obj.activateSorting();
         }, 10 );
      },

      close: function() {
         var obj = this;
         obj.config.on_close( obj.$modal );
         obj.$modal.remove();
         if ( ! $('#cv-composer-absolute-container').children().length ) {
            $('body').removeClass('cv-composer-active');
         }
      },

      activateSorting: function() {

         $('.cv-sortzone').each( function() {

            var $this = $(this);

            // Apply sortable
            $this.sortable({

               placeholder: 'cv-module-placeholder',
               appendTo: $this,
               helper: 'clone',

               // start = drag start
               start: function( e, ui ) {
                  ui.helper.addClass('cv-dragging');
                  ui.placeholder.css('height', ui.helper.outerHeight() );
                  ui.placeholder.css('width', ui.helper.outerWidth() );
               },

            });

         });

         $('.cv-list-items').each( function() {

            var $this = $(this);

            // Apply sortable
            $this.sortable({

               placeholder: 'cv-list-placeholder',
               appendTo: $this,
               helper: 'clone',

               // start = drag start
               start: function( e, ui ) {
                  ui.helper.addClass('cv-dragging');
                  ui.placeholder.css('height', ui.helper.height() );
                  ui.placeholder.css('width', ui.helper.width() );
               },

            });

         });

      },

   };

})(jQuery);