(function($) {

   var $document = $(document);

   $.CV_Template_Builder = function() {
      this.$builder          = $('#cv-builder');
      this.$toolbar          = $('#cv-toolbar');
      this.$canvas           = $('#cv-builder-canvas');
      this.$history          = $('#cv-history');
      this.$activeEditor     = $('#cv-active-editor');
      this.$templateValue    = $('#cv-page-template-value');
      this.$defaultEditor    = $('#cv-default-editor-wrap');
      this.$advancedEditor   = $('#cv_template_builder');
      this.init();
      return;
   };

   $.CV_Template_Builder.prototype = {

      /**
       * Call inititation functions
       */
      init: function() {

         var builder = this;

         builder.applyEvents();

         // Append the loader to the body
         $('body').append('<div id="cv-loading-indicator"><div class="loading-icon"></div> '+cv_builder_localize.builder_loading+'</div>' );

      },

      /**
       * Apply all events to the builder upon load
       */
      applyEvents: function() {

         var builder = this;

         /* == Pressing the Escape key == */

         $document.on( 'keydown', function(e) {

            // Make sure the escape key was pressed
            if ( 27 !== e.keyCode ) {
               return;
            }

            // Make sure fullscreen is active
            if ( $('body').hasClass('cv-fullscreen-active') ) {
               e.stopImmediatePropagation();
               e.preventDefault();
               $('#cv-toggle-fullscreen').trigger('click');
            }

         });

         /* == Managing the Builder == */

         // Toggle active editor
         $('#cv-toggle-active-editor').on( 'click', function(e) {
            e.preventDefault();
            builder.toggleEditor();
         });

         // Toggle Full Screen
         $('#cv-toggle-fullscreen').on( 'click', function(e) {
            e.preventDefault();
            builder.toggleFullScreen();
         });

         // Capture form submission event
         $('#post').on( 'submit', function() {
            builder.updateBuilderValue();
         });

         /* == Editing module content == */

         // Clicking the content preview will also launch the content editor
         $document.on('click', '.cv-composer-content-editor-current-content-preview, .cv-composer-content-editor-current-content-preview *', function(event) {
            event.preventDefault();
            var content = $(this).closest('.cv-composer-content-editor-wrap').find('.cv-composer-content-editor-launch').trigger('click');
         });

         // Launching the content editor
         $document.on( 'click', '.cv-composer-content-editor-launch', function() {
            var content = $(this).closest('.cv-composer-content-editor-wrap').find('.cv-composer-content-editor-current-content').val();
            if ( content ) {
               var visualEditorActive = $('#wp-shortcode_wp_editor_content-wrap').hasClass('tmce-active');

               // Switch to text editor to get content correctly, if visual is active
               if ( visualEditorActive ) {
                  $('#shortcode_wp_editor_content-html')[0].click();
               }

               // Set the content while in text mode
               $('#shortcode_wp_editor_content').val(content);

               // Switch back to visual editor if it was active before
               //
               // This is for consistency, WordPress remembers which editor was last
               // active and will use that setting to load each editor thereafter.
               if ( visualEditorActive ) {
                  $('#shortcode_wp_editor_content-tmce')[0].click();
               }
            }
            $('body').addClass('cv-shortcode-content-wp-editor-active');
         });

         // Canceling the content editor
         $document.on( 'click', '#cv-shortcode-content-wp-editor-wrap-cancel', function() {
            var visualEditorActive = $('#wp-shortcode_wp_editor_content-wrap').hasClass('tmce-active');

            // Switch to text editor to get content correctly, if visual is active
            if ( visualEditorActive ) {
               $('#shortcode_wp_editor_content-html')[0].click();
            }

            // Set the content while in text mode
            $('#shortcode_wp_editor_content').val('');

            // Switch back to visual editor if it was active before
            //
            // This is for consistency, WordPress remembers which editor was last
            // active and will use that setting to load each editor thereafter.
            if ( visualEditorActive ) {
               $('#shortcode_wp_editor_content-tmce')[0].click();
            }

            // Close the editor window
            $('body').removeClass('cv-shortcode-content-wp-editor-active');
         });

         // Submitting the content editor
         $document.on( 'click', '#cv-shortcode-content-wp-editor-wrap-submit', function() {
            var visualEditorActive = $('#wp-shortcode_wp_editor_content-wrap').hasClass('tmce-active');

            // Switch to text editor to get content correctly, if visual is active
            if ( visualEditorActive ) {
               $('#shortcode_wp_editor_content-html')[0].click();
            }

            // Grab the content while in text mode
            var content = $('#shortcode_wp_editor_content').val();

            // Clear the content after retrieving it
            $('#shortcode_wp_editor_content').val('');

            // Switch back to visual editor if it was active before
            //
            // This is for consistency, WordPress remembers which editor was last
            // active and will use that setting to load each editor thereafter.
            if ( visualEditorActive ) {
               $('#shortcode_wp_editor_content-tmce')[0].click();
            }

            // Insert our freshly created content
            $('#cv-composer-absolute-container').children().last().find('.cv-composer-content-editor-current-content').val(content);
            $('#cv-composer-absolute-container').children().last().find('.cv-composer-content-editor-current-content-preview').html( window.switchEditors.wpautop(content) );

            // Finally, close the editor window
            $('body').removeClass('cv-shortcode-content-wp-editor-active');
         });

         /* == Revealing shortcode explanation == */

         $document.on( 'click', '.show-shortcode-explanation', function() {
            $(this).hide().next().show();
         });
         $document.on( 'click', '.shortcode-explanation', function() {
            $(this).hide().prev().show();
         });

         /* == Managing Modules == */

         // Deleting a module
         $document.on( 'click', '.cv-module-remove', function(e) {
            var $this = $(e.target);
            var $module = $this.closest('.cv-builder-module');
            $module.trigger('remove-module');
         });

         $document.on( 'remove-module', '.cv-builder-module', function(e) {
            e.stopPropagation();
            builder.removeModule( $(e.target) );
         });

         // Duplicating a module
         $document.on( 'click', '.cv-module-duplicate', function(e) {
            var $this = $(e.target);
            var $module = $this.closest('.cv-builder-module');
            $module.trigger('duplicate-module');
         });

         $document.on( 'duplicate-module', '.cv-builder-module', function(e) {
            e.stopPropagation();
            builder.duplicateModule( $(e.target) );
         });

         // Editing a module
         $document.on( 'click', '.cv-module-edit', function(e) {
            var $this = $(e.target);
            var $module = $this.closest('.cv-builder-module');
            $module.trigger('edit-module');
         });

         $document.on( 'edit-module', '.cv-builder-module', function(e) {
            e.stopPropagation();
            builder.editModule( $(e.target) );
         });

         // Moving a module to the top
         builder.$canvas.on( 'click', '.cv-module-move-up', function(e) {
            var $this = $(e.target);
            var $module = $this.closest('.cv-builder-module');
            $module.trigger('move-module-up');
         });

         builder.$canvas.on( 'move-module-up', '.cv-builder-module', function(e) {
            e.stopPropagation();
            builder.moveModuleUp( $(e.target) );
         });

         // Moving a module to the bottom
         builder.$canvas.on( 'click', '.cv-module-move-down', function(e) {
            var $this = $(e.target);
            var $module = $this.closest('.cv-builder-module');
            $module.trigger('move-module-down');
         });

         builder.$canvas.on( 'move-module-down', '.cv-builder-module', function(e) {
            e.stopPropagation();
            builder.moveModuleDown( $(e.target) );
         });

         // Preview Changes Button
         $('#cv-preview-changes').on( 'click', function() {
            $('#post-preview').trigger('click');
         });

         // Save Changes Button
         $('#cv-save-changes').on( 'click', function() {
            $('#publish').trigger('click');
         });

         /* == Adding New Modules == */

         $document.on( 'click', '.cv-add-module', function() {

            var $this = $(this);
            var $dropzone = $this.prev();
            var title = $this.children('span').eq(0).html();


            // If add new button can only load one module
            if ( $this.data('handle') ) {

               // New shortcode handle
               var handle = $this.data('handle');

               // Load new module template
               var $newModule = $( $('#tmpl-cv-builder-'+handle).html() );

               // Insert the new module
               $dropzone.append( $newModule );

               // Update the DOM
               $document.trigger('dom-change');

               return;

            }

            var droptarget = $this.data('droptarget');

            new $.CVComposerModal( {
               title: title,
               submit_button: false,
               content: $('#tmpl-cv-builder-module-options-dropzone-'+droptarget).html(),
               on_load: function( $modal ) {

                  var hold_down_timeout = 0;
                  $modal.on( 'mousedown', '.cv-composer-available-module', function() {
                     var $this = $(this);
                     hold_down_timeout = setTimeout( function() {
                        $this.trigger('clickhold');
                     }, 250 );
                  }).on('mouseup mouseleave', function() {
                     clearTimeout(hold_down_timeout);
                  });


                  $modal.on( 'click clickhold', '.cv-composer-available-module', function(e) {

                     e.preventDefault();

                     // New shortcode handle
                     var handle = $(this).data('handle');

                     // Load new module template
                     var $newModule = $( $('#tmpl-cv-builder-'+handle).html() );

                     // Insert the new module
                     $dropzone.append( $newModule );

                     // Update the DOM
                     $document.trigger('dom-change');

                     // Add current state to history
                     builder.captureState( cv_builder_localize.add_module_title.replace('%s', $newModule.data('title') ), 'plus-circled' );

                     // Close the modal
                     $modal.trigger('submit-modal');

                     // Edit the new module automatically
                     if ( 'clickhold' === e.type ) {
                        $newModule.find('.cv-module-edit').eq(0).trigger('click');
                     }

                  });
               }
            });

         });

         /* == Toolbar Dropdown Functionality == */

         // Apply toolbar dropdown click events
         builder.$toolbar.on( 'click', '.cv-dropdown-control > a', function() {

            var $this = $(this).closest('.cv-dropdown-control');

            // Dsabled dropdowns can not be opened
            if ( $this.hasClass('is-disabled') ) {
               return;
            }

            var $dropdown = $this.children('.cv-dropdown').eq(0);

            // Make sure this is the only active dropdown
            $this.siblings().removeClass('is-active');
            $this.toggleClass('is-active');

            // Scroll to the bottom of the history
            if ( $dropdown.hasClass('cv-history') && $dropdown[0].scrollHeight > $dropdown.height() ) {
               var distance = 0, height;
               $dropdown.children('.cv-state-container.active-item').eq(0).prevAll().each( function() {
                  height = $(this).outerHeight();
                  distance += parseInt(height);
               });
               $dropdown.animate({ scrollTop: distance}, 500 );
            }

         });

         builder.$canvas.on( 'click mousedown touchstart', function() {
            builder.$toolbar.find('.cv-dropdown-control.is-active').eq(0).removeClass('is-active');
         });

         /* == History Management == */

         // Insert lauch state
         builder.captureState( cv_builder_localize.launch_builder, 'rocket' );

         // Loading a history state
         builder.$history.on( 'click', 'a', function() {

            var $button = $(this);

            // Remove active class from active state and apply to this state
            $button.parent().siblings('.active-item').eq(0).removeClass('active-item');
            $button.parent().addClass('active-item');

            // Grab the template at the new state
            var template = $button.next().val();

            // Load the state
            builder.insertTemplate( template, 'replace', false );

            // Update the builders history status
            builder.assessHistory();

         });

         // Step Backward
         $('#cv-step-backward').on( 'click', function() {

            // Determine which state is active
            var $activeItem = builder.$history.find('.active-item').eq(0);

            // Activate the previous state
            $activeItem.prev().children('a').eq(0).trigger('click');

            // Update the builders history status
            builder.assessHistory();

         });

         // Step Forward
         $('#cv-step-forward').on( 'click', function() {

            // Determine which state is active
            var $activeItem = builder.$history.find('.active-item').eq(0);

            // Activate the next state
            $activeItem.next().children('a').eq(0).trigger('click');

            // Update the builders history status
            builder.assessHistory();

         });

         /* == Template Management == */

         // Opening/closing the template creator
         $('#cv-cancel-new-template, #cv-add-template-button').on( 'click', function() {

            if ( 'cv-add-template-button' === $(this).attr('id') ) {

               // Capture the current template
               var template = builder.captureTemplate();

               // First make sure template is not empty
               if ( ! template ) {
                  alert(cv_builder_localize.empty_template_name);
                  return;
               }

            }

            // Show / hide the template creator
            $('#cv-templates').toggleClass('cv-creating-template');

            // Auto focus & clear the name input
            $('#cv-new-template-name').val('').trigger('focus');

         });

         // Submitting the template name
         $('#cv-submit-template-name').on( 'click', function() {

            // Capture the current template
            var template = builder.captureTemplate();

            // Grabe & sanitize the name of the template
            var name = $('#cv-new-template-name').val();
                name = name.replace(/[^a-z\d\s]+/gi, '');

            // Insert sanitized name
            $('#cv-new-template-name').val(name);

            // Make sure name is long enough
            if ( 3 > name.length ) {
               alert(cv_builder_localize.short_template_name);
               return;
            }

            var exists = false;

            // Make sure name doesn't exist already
            $('#cv-templates').find('.cv-custom-template .cv-load-template').each( function() {
               if ( name === $(this).data('title') ) {
                  exists = true;
               }
            });

            // Do not continue if it does
            if ( exists ) {
               alert(cv_builder_localize.taken_template_name);
               return;
            }

            // Create the button
            var button  = '<li class="cv-template-container cv-custom-template">';
                button += '<a class="cv-load-template has-icon" ';
                button += 'data-title="'+name+'"';
                button += '><i class="icon-folder"></i>'+name;
                button += '<span class="cv-delete-template">'+cv_builder_localize.delete+'</span>';
                button += '</a>';
                button += '<textarea name="cv_builder_templates['+name.replace(/ /g,'')+'][template]" class="cv-saved-template">'+template+'</textarea>';
                button += '<input type="hidden" name="cv_builder_templates['+name.replace(/ /g,'')+'][name]" value="'+name+'" />';
                button += '</li>';

            // Insert the button
            $('#cv-templates').append(button);

            // Just in case this was the first template saved
            $('#cv-templates').removeClass('is-empty');

            // Close the template creator
            $('#cv-templates').removeClass('cv-creating-template');

            // Call function to update the saved templates using AJAX
            builder.updateTemplateManager();

         });

         // Loading a template
         $('#cv-templates').on( 'click', '.cv-load-template', function(e) {

            // If template is being deleted
            if ( $(e.target).hasClass('cv-delete-template') ) {

               // make sure the user wants to delete the template
               var r = confirm( cv_builder_localize.confirm_delete_template );
               if ( ! r ) { return; }

               var $container = $(this).parent();

               // Add removing animation
               $container.addClass('being-removed');

               setTimeout( function() {

                  // Remove from DOM
                  $container.remove();

                  // update the teplate manager
                  builder.updateTemplateManager();

                  // Just in case this was the last saved template
                  if ( ! $('#cv-no-templates-notice').next().length ) {
                     $('#cv-templates').addClass('is-empty');
                  }

               }, 500 );

               return;

            }

            var $button = $(this);

            // grab the value of the template
            var template = $button.next().val();

            // Capture the current template
            var currentTemplate = builder.captureTemplate();

            // If there is no current template, insert chosen template immediately
            if ( ! currentTemplate ) {

               // Inser the template
               builder.insertTemplate( template, 'replace', true, function() {
                  builder.captureState( cv_builder_localize.load_template_title.replace('%s', $button.data('title') ), 'flash' );
               } );

            }

            // If there is already content ask user what to do with the chosen template
            else {

               var title = cv_builder_localize.template_modal_title.replace('%s', $button.data('title') );
               new $.CVComposerModal( {
                  title: title,
                  content: $('#tmpl-cv-builder-template-options').html(),
                  submit_button: false,
                  on_load: function( $modal ) {
                     $modal.on( 'click', '.cv-composer-large-option', function() {
                        var action = $(this).data('action');
                        builder.insertTemplate( template, action, true, function() {
                           builder.captureState( cv_builder_localize[action+'_template_title'].replace('%s', $button.data('title') ), 'flash' );
                        } );
                        $modal.trigger('submit-modal');
                     });
                  },
               } );

            }

            // Close the templates dropdown
            $('#cv-toolbar-templates').removeClass('is-active');

         });

         // Apply Drag & Drop
         builder.applySorting();

         // When DOM changes
         $document.on( 'dom-change', $.proxy( builder.applySorting, builder ) );

      },

      /**
       * Switch between the default & advanced editors
       */
      toggleEditor: function() {

         var builder = this;
         var activeEditor = builder.$activeEditor.val();
         var $button = $('#cv-toggle-active-editor');
         var newEditor;

         switch (activeEditor) {

            // Activate advanced editor
            case 'default':
               newEditor = 'advanced';
               break;

            // Activate default editor
            case 'advanced':
               newEditor = 'default';
               break;

         }

         // Update the body class
         $('body').toggleClass('cv-builder-active cv-builder-hidden');

         // Update the button
         $button.toggleClass('button-primary');
         $button.html( $button.data(newEditor+'-label') );

         // Update the value of the active editor
         builder.$activeEditor.val( newEditor );

         // Trigger a DOM chnge event
         $document.trigger('dom-change');

         // Create opbject for AJAX callback
         var data = {
            current_editor: newEditor,
            post_ID: $button.data('post-id'),
            action: 'cv_ajax_update_editor_value'
         };

         $.ajax({
            type: 'POST',
            url: cv_builder_localize.ajax_url,
            data: data,
            // timeout: parseInt( cv_builder_localize.ajax_timeout ),
         });

      },

      /**
       * Switch between the default & advanced editors
       */
      toggleFullScreen: function() {

         var builder = this;
         var $button = $('#cv-toggle-fullscreen');
         builder.$builder.toggleClass('is-fullscreen');
         $('body').toggleClass('cv-fullscreen-active');

         // Enter Full Screen mode
         if ( builder.$builder.hasClass('is-fullscreen') ) {
            $button.html( $button.data('compress') );
         }

         // Exit Full Screen Mode
         else {
            $button.html( $button.data('expand') );
         }
      },

      /**
       * Called to make sure history
       * Undo/Redo buttons work appropriately
       */
      assessHistory: function() {

         var builder = this;
         var $activeItem = builder.$history.find('.active-item').eq(0);
         var $backward = $('#cv-step-backward').parent();
         var $forward = $('#cv-step-forward').parent();

         // Enable the history dropdown
         if ( 1 < builder.$history.children().length ) {
            builder.$history.parent().removeClass('is-disabled');
         }

         // Disable/Enable the back button
         if ( 0 === $activeItem.prevAll().length ) {
            $backward.addClass('is-disabled');
         }
         else {
            $backward.removeClass('is-disabled');
         }

         // Disable/Enable the forward button
         if ( 0 === $activeItem.nextAll().length ) {
            $forward.addClass('is-disabled');
         }
         else {
            $forward.removeClass('is-disabled');
         }

      },

      /**
       * Applies dragging functionality
       * needs to be called when new modules are added
       */
      applySorting: function() {

         var builder = this;

         $('.cv-dropzone').each( function() {

            var $this = $(this);
            var dropzone = $this.data('dropzone');

            // Check if sorting has already been called
            if ( $this.data('cvdrop') ) {
               return;
            }

            // make sure sorting won't be overwritten
            $this.data('cvdrop', true);

            // Apply sortable
            $this.sortable({

               connectWith: '.cv-dropzone[data-dropzone="'+dropzone+'"]',
               placeholder: 'cv-module-placeholder',
               appendTo: '#cv-builder',
               helper: 'clone',

               // start = drag start
               start: function( e, ui ) {

                  // Check if the duplicate button is being used as the drag handle
                  var target = $(e.srcElement);
                  if ( target.hasClass('cv-module-duplicate') || target.parent().hasClass('cv-module-duplicate') ) {

                     var $module = target.closest('.cv-builder-module');
                     var $duplicate = $module.clone().removeAttr('style');

                     // Make sure placeholder does not show immediately
                     $module.parent().addClass('hide-placeholder');

                     // Duplicate/insert module
                     $module.after( $duplicate );
                     $document.trigger('dom-change');
                     builder.captureState( cv_builder_localize.duplicate_module_title.replace('%s', ui.item.data('title') ), 'docs' );

                  }

                  ui.item.data('start-pos', ui.item.index() );
                  ui.item.data('start-dropzone', ui.item.parent() );
                  ui.helper.addClass('cv-dragging');
                  ui.placeholder.css('height', ui.helper.outerHeight() );
               },

               // stop = drag stop
               stop: function( e, ui ) {
                  ui.item.data('start-dropzone').removeClass('is-empty hide-placeholder');
                  if ( ui.item.data('start-pos') !== ui.item.index() ||
                       ! ui.item.data('start-dropzone').is( ui.item.parent() ) ) {
                     builder.captureState( cv_builder_localize.move_module_title.replace('%s', ui.item.data('title') ), 'shuffle' );
                     $document.trigger( 'cv-composer-module-dropped');
                  }
               },

               // over = move over potential new position
               over: function( e, ui ) {
                  $(ui.placeholder).parent().removeClass('hide-placeholder');
                  if ( 1 === ui.item.data('start-dropzone').children().length && 'none' === ui.item.data('start-dropzone').children().eq(0).css('display') ) {
                    ui.item.data('start-dropzone').addClass('is-empty');
                  }
                  if ( 2 === ui.item.data('start-dropzone').children().length ) {
                     ui.item.data('start-dropzone').removeClass('is-empty');
                  }
                  $document.trigger( 'cv-composer-module-over');
               },

            });

         });

      },

      /**
       * Function to remove a module
       */
      removeModule: function( $module ) {

         var builder = this;
         var droptarget = $module.data('droptarget');


               // Remove the module completely
               $module.remove();

               // Update the DOM
               $document.trigger('dom-change');

               // Add current state to history
               if ( 3 !== droptarget ) {
                  builder.captureState( cv_builder_localize.remove_module_title.replace('%s', $module.data('title') ), 'trash' );
               }

               return;

         // Prepare css3 transitions
         builder.$canvas.css( 'height', 'auto' );
         $module.addClass('being-removed').css( 'height', $module.outerHeight() );

         // Excessive timing functions for correct css3 transitions
         setTimeout( function() {
            $module.addClass('is-removed');
            setTimeout( function() {

               // Remove the module completely
               $module.remove();

               // Update the DOM
               $document.trigger('dom-change');

               // Add current state to history
               if ( 3 !== droptarget ) {
                  builder.captureState( cv_builder_localize.remove_module_title.replace('%s', $module.data('title') ), 'trash' );
               }

            }, 260 );
         }, 10);

      },

      /**
       * Function to duplicate a module
       */
      duplicateModule: function( $module ) {

         var builder = this;
         var $duplicate = $module.clone();
         var moduleHeight = $module.outerHeight();
         var droptarget = $module.data('droptarget');

         // Prepare css3 transitions
         builder.$canvas.css( 'height', 'auto' );
         $duplicate.addClass('being-added is-added');
         $duplicate.css( 'height', '0px !important');
         $module.after( $duplicate );

         // Excessive timing functions for correct css3 transitions
         setTimeout( function() {
            $duplicate.css( 'height', moduleHeight ).removeClass('is-added');
            setTimeout( function() {

               // Remove unnecessary attributes/styles
               $duplicate.removeClass('being-added');
               $duplicate.removeAttr('style');

               // Update the DOM
               $document.trigger('dom-change');

               // Add current state to history
               if ( 3 !== droptarget ) {
                  builder.captureState( cv_builder_localize.duplicate_module_title.replace('%s', $duplicate.data('title') ), 'docs' );
               }

            }, 260 );
         }, 10);
      },

      /**
       * Function to edit a module
       */
      editModule: function( $module ) {

         var builder = this;
         var handle = $module.data('handle');
         var title = cv_builder_localize.edit_module_title.replace('%s', $module.data('title') );
         var shortcode = builder.captureModuleShortcode( $module );
         var droptarget = $module.data('droptarget');

         builder.startLoading();

         // Display the options modal
         new $.CVComposerModal( {
            title: title,
            action: handle,
            ajax_callback: 'render_composer_controls',
            ajax_param: shortcode,
            add_class: 'editing-'+handle,
            on_load: function() {
               // Deactivate the loading state
               builder.doneLoading();
            },
            on_submit: function( $modal ) {

            var submitted = {};
            var content = '';
            var $control;
            var $this;

            // Apply loading state to module
            $module.addClass( 'being-edited' );

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
            else if ( $modal.find('.cv-composer-content-editor-current-content').length ) {
               submitted.content = $modal.find('.cv-composer-content-editor-current-content').val();
            }

            // Check if content was supplied via dropzone
            else if ( $modal.find('textarea[name="shortcode_dropzone_content"]').length ) {
               submitted.content = $modal.find('textarea[name="shortcode_dropzone_content"]').val();
            }

            // Convert to JSON
            submitted = JSON.stringify(submitted);

               // Activate the loading state
               builder.startLoading();

               // Create object for AJAX callback
               var data = {
                  submitted: submitted,
                  action: 'cv_ajax_refresh_edited_module',
               };

               // Fetch the processed module using AJAX
               $.ajax({

                  type: 'POST',
                  url: cv_builder_localize.ajax_url,
                  data: data,
                  // timeout: parseInt( cv_builder_localize.ajax_timeout ),

                  success: function( response ) {

                     var $response = $(response);

                     // Store original value
                     var original = builder.captureModuleShortcode($module);

                     // Insert new module
                     $module.replaceWith( $response );

                     builder.$builder.imagesLoaded( function() {
                        $document.trigger('dom-change');
                     });

                     // Update the DOM
                     $document.trigger('dom-change');

                     // Store edited value
                     var edited = builder.captureModuleShortcode($response);

                     // Make sure the settings were actually changed
                     if ( original !== edited && 3 !== droptarget ) {

                        // Add current state to history
                        builder.captureState( cv_builder_localize.edit_module_title.replace('%s', $response.data('title') ), 'pencil' );

                     }

                     // Deactivate the loading state
                     builder.doneLoading();

                  }
               });

            }
         });

      },

      /**
       * Function to move a module up
       */
      moveModuleUp: function( $module ) {

         var builder = this;
         var $duplicate = $module.clone();
         var $previous = $module.prev();

         // Make sure module can be moved up
         if ( ! $previous.length ) {
            alert(cv_builder_localize.module_at_top);
            return;
         }

         // Move module
         $module.parent().prepend($duplicate);
         $module.remove();

         // Update the DOM
         $document.trigger('dom-change');

         // Add current state to history
         builder.captureState( cv_builder_localize.move_module_up_title.replace('%s', $module.data('title') ), 'up-dir' );

      },

      /**
       * Function to move a module down
       */
      moveModuleDown: function( $module ) {

         var builder = this;
         var $duplicate = $module.clone();
         var $next = $module.next();

         // Make sure module can be moved down
         if ( ! $next.length ) {
            alert(cv_builder_localize.module_at_bottom);
            return;
         }

         // Move module
         $module.parent().append($duplicate);
         $module.remove();

         // Update the DOM
         $document.trigger('dom-change');

         // Add current state to history
         builder.captureState( cv_builder_localize.move_module_down_title.replace('%s', $module.data('title') ), 'down-dir' );

      },

      /**
       * Grab the shortcode value of a module
       */
      captureModuleShortcode: function( $module ) {

         var shortcode = '';

         // Capture the module shortcode
         $module.find('.cv-builder-piece').each( function() {
            shortcode += $(this).val();
         });

         return shortcode;

      },

      /**
       * Function to render the value
       * of the template builder at it's current state
       */
      captureTemplate: function() {

         var builder = this;
         var template = '';

         // Grab value of each template piece
         builder.$canvas.find('.cv-builder-piece').each( function() {
            template += $(this).val();
         });

         return template;
      },

      /**
       * Function to update the value
       * of the template builder at it's current state
       */
      updateBuilderValue: function() {

         var builder = this;

         // Grab current value of the builder
         var template = this.captureTemplate();
         builder.$templateValue.val(template);
      },

      /**
       * Function to update the value
       * of the template builder at it's current state
       */
      updateTemplateManager: function() {

         var templates = {};
         var $this, slug, name, template;

         $('#cv-templates').find('.cv-custom-template').each( function() {
            $this = $(this);
            name = $this.find('input').val();
            template = $this.find('textarea').val();
            slug = name.replace(/ /g,'');
            templates[slug] = {};
            templates[slug]['name'] = name;
            templates[slug]['template'] = template;
         });

         // Create opbject for AJAX callback
         var data = {
            templates: JSON.stringify(templates),
            action: 'cv_ajax_update_template_manager'
         };

         $.ajax({
            type: 'POST',
            url: cv_builder_localize.ajax_url,
            data: data,
            // timeout: parseInt( cv_builder_localize.ajax_timeout ),
            error: function() {
               alert(cv_builder_localize.error_loading_template);
            }
         });

      },

      /**
       * Function to capture the state of the template
       * and record it in the template builder history bar
       */
      captureState: function( title, icon ) {

         var builder = this;

         // Add default icon
         if ( ! icon ) {
            icon = 'arrows-ccw';
         }

         // Grab current state
         var template = builder.captureTemplate();

         // Create the button
         var button  = '<li class="cv-state-container active-item">';
             button += '<a class="cv-state-button has-icon"><i class="icon-'+icon+'"></i>'+title+'</a>';
             button += '<textarea class="cv-state-template">'+template+'</textarea>';
             button += '</li>';

         // In case current state is a past state, remove any inactive states
         builder.$history.children('.active-item').eq(0).nextAll().remove();

         // Set new state to active
         builder.$history.children('.active-item').eq(0).removeClass('active-item');
         builder.$history.append( button );

         // Update the history
         builder.assessHistory();

      },

      /**
       * Function to insert the rendered output value of a template string
       */
      insertTemplate: function( template, action, animation, callback ) {

         var builder = this;
         var $canvas = builder.$canvas.children().eq(0);
         var $template;

         // Create opbject for AJAX callback
         var data = {
            template: template,
            action: 'cv_ajax_load_template'
         };

         // Activate the loading state
         builder.startLoading();

         $.ajax({

            type: 'POST',
            url: cv_builder_localize.ajax_url,
            data: data,
            // timeout: parseInt( cv_builder_localize.ajax_timeout ),

            success: function( response ) {

               // Determine if new content should be animated
               if ( response ) {
                  $template = animation ? $('<div class="cv-new-modules">'+response+'</div>') : $(response);
               }
               else {
                  $template = '';
               }

               // Determine what to do with the new content
               switch (action) {
                  case 'prepend':
                     $canvas.prepend($template);
                     break;
                  case 'replace':
                     $canvas.html($template);
                     break;
                  case 'append':
                     $canvas.append($template);
                     break;
               }

               // Apply css3 timing
               if ( response && animation ) {
                  setTimeout( function() {
                     $template.addClass('being-added');
                     setTimeout( function() {
                        $template.children().eq(0).unwrap();
                     }, 760);
                  }, 10);
               }

               if ( callback && 'function' === typeof callback ) {
                  callback();
               }

               // Deactivate the loading state
               builder.doneLoading();

               // Update the DOM
               $document.trigger('dom-change');

            }
         });

      },

      /**
       * Function to activate the loading state
       */
      startLoading: function() {
         $('body').addClass( 'cv-builder-is-loading cv-suspend-modal-events' );
      },

      /**
       * Function to deactivate the loading state
       */
      doneLoading: function() {
         $('body').removeClass( 'cv-builder-is-loading cv-suspend-modal-events' );
      },

   };

   // Activate the template builder
   $document.on( 'ready', function() {
      $document.data( 'cv-template-builder', new $.CV_Template_Builder() );
   } );

})(jQuery);

/*!
 * imagesLoaded PACKAGED v3.1.8
 * JavaScript is all like "You images are done yet or what?"
 * MIT License
 */
;(function(){function e(){}function t(e,t){for(var n=e.length;n--;)if(e[n].listener===t)return n;return-1}function n(e){return function(){return this[e].apply(this,arguments)}}var i=e.prototype,r=this,o=r.EventEmitter;i.getListeners=function(e){var t,n,i=this._getEvents();if("object"==typeof e){t={};for(n in i)i.hasOwnProperty(n)&&e.test(n)&&(t[n]=i[n])}else t=i[e]||(i[e]=[]);return t},i.flattenListeners=function(e){var t,n=[];for(t=0;e.length>t;t+=1)n.push(e[t].listener);return n},i.getListenersAsObject=function(e){var t,n=this.getListeners(e);return n instanceof Array&&(t={},t[e]=n),t||n},i.addListener=function(e,n){var i,r=this.getListenersAsObject(e),o="object"==typeof n;for(i in r)r.hasOwnProperty(i)&&-1===t(r[i],n)&&r[i].push(o?n:{listener:n,once:!1});return this},i.on=n("addListener"),i.addOnceListener=function(e,t){return this.addListener(e,{listener:t,once:!0})},i.once=n("addOnceListener"),i.defineEvent=function(e){return this.getListeners(e),this},i.defineEvents=function(e){for(var t=0;e.length>t;t+=1)this.defineEvent(e[t]);return this},i.removeListener=function(e,n){var i,r,o=this.getListenersAsObject(e);for(r in o)o.hasOwnProperty(r)&&(i=t(o[r],n),-1!==i&&o[r].splice(i,1));return this},i.off=n("removeListener"),i.addListeners=function(e,t){return this.manipulateListeners(!1,e,t)},i.removeListeners=function(e,t){return this.manipulateListeners(!0,e,t)},i.manipulateListeners=function(e,t,n){var i,r,o=e?this.removeListener:this.addListener,s=e?this.removeListeners:this.addListeners;if("object"!=typeof t||t instanceof RegExp)for(i=n.length;i--;)o.call(this,t,n[i]);else for(i in t)t.hasOwnProperty(i)&&(r=t[i])&&("function"==typeof r?o.call(this,i,r):s.call(this,i,r));return this},i.removeEvent=function(e){var t,n=typeof e,i=this._getEvents();if("string"===n)delete i[e];else if("object"===n)for(t in i)i.hasOwnProperty(t)&&e.test(t)&&delete i[t];else delete this._events;return this},i.removeAllListeners=n("removeEvent"),i.emitEvent=function(e,t){var n,i,r,o,s=this.getListenersAsObject(e);for(r in s)if(s.hasOwnProperty(r))for(i=s[r].length;i--;)n=s[r][i],n.once===!0&&this.removeListener(e,n.listener),o=n.listener.apply(this,t||[]),o===this._getOnceReturnValue()&&this.removeListener(e,n.listener);return this},i.trigger=n("emitEvent"),i.emit=function(e){var t=Array.prototype.slice.call(arguments,1);return this.emitEvent(e,t)},i.setOnceReturnValue=function(e){return this._onceReturnValue=e,this},i._getOnceReturnValue=function(){return this.hasOwnProperty("_onceReturnValue")?this._onceReturnValue:!0},i._getEvents=function(){return this._events||(this._events={})},e.noConflict=function(){return r.EventEmitter=o,e},"function"==typeof define&&define.amd?define("eventEmitter/EventEmitter",[],function(){return e}):"object"==typeof module&&module.exports?module.exports=e:this.EventEmitter=e}).call(this),function(e){function t(t){var n=e.event;return n.target=n.target||n.srcElement||t,n}var n=document.documentElement,i=function(){};n.addEventListener?i=function(e,t,n){e.addEventListener(t,n,!1)}:n.attachEvent&&(i=function(e,n,i){e[n+i]=i.handleEvent?function(){var n=t(e);i.handleEvent.call(i,n)}:function(){var n=t(e);i.call(e,n)},e.attachEvent("on"+n,e[n+i])});var r=function(){};n.removeEventListener?r=function(e,t,n){e.removeEventListener(t,n,!1)}:n.detachEvent&&(r=function(e,t,n){e.detachEvent("on"+t,e[t+n]);try{delete e[t+n]}catch(i){e[t+n]=void 0}});var o={bind:i,unbind:r};"function"==typeof define&&define.amd?define("eventie/eventie",o):e.eventie=o}(this),function(e,t){"function"==typeof define&&define.amd?define(["eventEmitter/EventEmitter","eventie/eventie"],function(n,i){return t(e,n,i)}):"object"==typeof exports?module.exports=t(e,require("wolfy87-eventemitter"),require("eventie")):e.imagesLoaded=t(e,e.EventEmitter,e.eventie)}(window,function(e,t,n){function i(e,t){for(var n in t)e[n]=t[n];return e}function r(e){return"[object Array]"===d.call(e)}function o(e){var t=[];if(r(e))t=e;else if("number"==typeof e.length)for(var n=0,i=e.length;i>n;n++)t.push(e[n]);else t.push(e);return t}function s(e,t,n){if(!(this instanceof s))return new s(e,t);"string"==typeof e&&(e=document.querySelectorAll(e)),this.elements=o(e),this.options=i({},this.options),"function"==typeof t?n=t:i(this.options,t),n&&this.on("always",n),this.getImages(),a&&(this.jqDeferred=new a.Deferred);var r=this;setTimeout(function(){r.check()})}function f(e){this.img=e}function c(e){this.src=e,v[e]=this}var a=e.jQuery,u=e.console,h=u!==void 0,d=Object.prototype.toString;s.prototype=new t,s.prototype.options={},s.prototype.getImages=function(){this.images=[];for(var e=0,t=this.elements.length;t>e;e++){var n=this.elements[e];"IMG"===n.nodeName&&this.addImage(n);var i=n.nodeType;if(i&&(1===i||9===i||11===i))for(var r=n.querySelectorAll("img"),o=0,s=r.length;s>o;o++){var f=r[o];this.addImage(f)}}},s.prototype.addImage=function(e){var t=new f(e);this.images.push(t)},s.prototype.check=function(){function e(e,r){return t.options.debug&&h&&u.log("confirm",e,r),t.progress(e),n++,n===i&&t.complete(),!0}var t=this,n=0,i=this.images.length;if(this.hasAnyBroken=!1,!i)return this.complete(),void 0;for(var r=0;i>r;r++){var o=this.images[r];o.on("confirm",e),o.check()}},s.prototype.progress=function(e){this.hasAnyBroken=this.hasAnyBroken||!e.isLoaded;var t=this;setTimeout(function(){t.emit("progress",t,e),t.jqDeferred&&t.jqDeferred.notify&&t.jqDeferred.notify(t,e)})},s.prototype.complete=function(){var e=this.hasAnyBroken?"fail":"done";this.isComplete=!0;var t=this;setTimeout(function(){if(t.emit(e,t),t.emit("always",t),t.jqDeferred){var n=t.hasAnyBroken?"reject":"resolve";t.jqDeferred[n](t)}})},a&&(a.fn.imagesLoaded=function(e,t){var n=new s(this,e,t);return n.jqDeferred.promise(a(this))}),f.prototype=new t,f.prototype.check=function(){var e=v[this.img.src]||new c(this.img.src);if(e.isConfirmed)return this.confirm(e.isLoaded,"cached was confirmed"),void 0;if(this.img.complete&&void 0!==this.img.naturalWidth)return this.confirm(0!==this.img.naturalWidth,"naturalWidth"),void 0;var t=this;e.on("confirm",function(e,n){return t.confirm(e.isLoaded,n),!0}),e.check()},f.prototype.confirm=function(e,t){this.isLoaded=e,this.emit("confirm",this,t)};var v={};return c.prototype=new t,c.prototype.check=function(){if(!this.isChecked){var e=new Image;n.bind(e,"load",this),n.bind(e,"error",this),e.src=this.src,this.isChecked=!0}},c.prototype.handleEvent=function(e){var t="on"+e.type;this[t]&&this[t](e)},c.prototype.onload=function(e){this.confirm(!0,"onload"),this.unbindProxyEvents(e)},c.prototype.onerror=function(e){this.confirm(!1,"onerror"),this.unbindProxyEvents(e)},c.prototype.confirm=function(e,t){this.isConfirmed=!0,this.isLoaded=e,this.emit("confirm",this,t)},c.prototype.unbindProxyEvents=function(e){n.unbind(e.target,"load",this),n.unbind(e.target,"error",this)},s});