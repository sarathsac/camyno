(function($) {
   "use strict";

   var $document = $(document);

   $.CVComposer = function() {
      this.applyEvents();
      return;
   };

   $.CVComposer.prototype = {

      /**
       * Apply all events to the composer upon load
       */
      applyEvents: function() {

         // Opening the composer
         $document.on( 'click', '.cv-composer-launch', function() {

            var activeEditor = $(this).closest('.wp-editor-wrap').hasClass('tmce-active') ? 'tmce' : 'html';
            var editorID = $(this).closest('.wp-editor-wrap').find('.wp-editor-area').attr('id');

            $document.data('cv-template-builder').startLoading();

            new $.CVComposerModal( {
               title: cv_composer_localize.select_shortcode_title,
               submit_button: false,
               ajax_callback: 'render_available_shortcodes',
               on_load: function( $modal ) {
                  $document.data('cv-template-builder').doneLoading();
                  $modal.on( 'click', '.cv-composer-available-module', function() {

                     // New shortcode handle
                     var handle = $(this).data('handle');
                     var title = $(this).find('strong').html();

                     $modal.trigger('cancel-modal');

                     $document.data('cv-template-builder').startLoading();

                     // Display the options modal
                     new $.CVComposerModal( {
                        title: cv_composer_localize.add_shortcode_title.replace( '%s', title ),
                        action: handle,
                        ajax_callback: 'render_composer_controls',
                        ajax_param: handle,
                        add_class: 'editing-'+handle,
                        on_load: function() {
                           $document.data('cv-template-builder').doneLoading();
                        },
                        on_submit: function( $modal ) {

                           var submitted = {};
                           var content = '';
                           var $control;
                           var $this;

                           // Add the handle for processing
                           submitted.handle = handle;

                           // Create attributes object
                           submitted.attributes = {};
                           $modal.find('#cv-composer-form .standard-attributes .control-wrap').each( function() {
                              $this = $(this);
                              switch ( $this.data('type') ) {

                                 case 'layout':
                                 case 'iconpicker':
                                 case 'bg-pattern':
                                    $control = $this.find('[name]:checked');
                                    submitted.attributes[$control.attr('name')] = $control.val();
                                    break;

                                 case 'list':
                                    var val = '';
                                    $control = $this.find('[name]');
                                    var separator = $control.data('separator');
                                    $control.next().children().each( function() {
                                       val += $(this).find('span').html()+separator;
                                    });
                                    val = val.slice(0, -1);
                                    submitted.attributes[$control.attr('name')] = val;
                                    break;

                                 case 'multiple-select':
                                    $control = $this.find('[name]');
                                    val = $control.val() ? $control.val().join(',') : '';
                                    submitted.attributes[$control.attr('name')] = val;
                                    break;

                                 default:
                                    $control = $this.find('[name]');
                                    submitted.attributes[$control.attr('name')] = $control.val();
                                    break;

                              }
                           });

                           // Check if shortcode has a content element
                           if ( $modal.find('.content-elements').length ) {

                              // Create the content value
                              $modal.find('.cv-builder-piece').each( function() {
                                 content += $(this).val();
                              });
                              submitted.content = content;

                           }

                           // Check if content was supplied via mce editor
                           else if ( $modal.find('.cv-composer-content-editor-current-content') ) {
                              submitted.content = $modal.find('.cv-composer-content-editor-current-content').val();
                           }

                           // Convert to JSON
                           submitted = JSON.stringify(submitted);

                           // Create object for AJAX callback
                           var data = {
                              submitted: submitted,
                              editor: activeEditor,
                              action: 'cv_ajax_render_shortcode'
                           };

                           $document.data('cv-template-builder').startLoading();

                           // Fetch the processed shortcode using AJAX
                           $.ajax({

                              type: 'POST',
                              url: cv_composer_localize.ajax_url,
                              data: data,

                              success: function( response ) {
                                 wpActiveEditor = editorID;
                                 send_to_editor( response );
                                 $document.data('cv-template-builder').doneLoading();
                              }

                           });

                        }
                     });

                  });
               }
            });

         });

      },

   };

   // Activate the template builder
   $document.ready( function() {
      $document.data( 'cv-shortcode-composer', new $.CVComposer() );
   } );

})(jQuery);