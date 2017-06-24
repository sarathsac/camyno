(function($) {
   "use strict";

   var $document = $(document);

   $document.ready( function() {

      // Insert the settings template
      var $settings = $( $('#cv-tmpl-format-settings').html() );
      $settings.insertAfter('#post-formats-select');

      // Settings panes
      var $panes = $('#cv-post-format-meta').children();

      // Display the correct settings pane
      $('input[name="post_format"]').on( 'change', function() {
         var val = $('input[name="post_format"]:checked').val();
         if ( ! val ) val = 'standard';
         $panes.removeClass('is-active');
         $panes.filter('[data-format="'+val+'"]').addClass('is-active');
      }).trigger('change');

      // File management
      $('.cv-file-input').each( function() {

         var $input = $(this), id = $input.attr('id'), val,
             $select = $('.cv-select-file[data-sync="'+id+'"]'),
             $remove = $('.cv-remove-file[data-sync="'+id+'"]'),
             fileType = $select.data('type');

         // Only show the appropriate controls
         $input.on( 'change keyup', function() {
            val = $input.val();
            if ( val ) { $select.hide(); $remove.show(); }
            else { $select.show(); $remove.hide(); }
         }).trigger('change');

         // Attach the remove file event
         $remove.on( 'click', function(e) {
            e.stopImmediatePropagation();
            $input.val('').trigger('change')
         });

         // Attach the upload event
         $select.on( 'click', function(e) {

            e.stopImmediatePropagation();

            // Create the media frame.
            var frame = wp.media({
               title: "Select a File",
               button: { text: "Use This File" },
               library: { type: fileType },
               multiple: false,
            });

            // When an image is selected, run a callback.
            frame.on( 'select', function() {

               // Grab the selected attachment.
               var attachment = frame.state().get('selection').first().toJSON();
               var url = attachment.url;
               $input.val(url).trigger('change');

            });

            // Finally, open the modal.
            frame.open();

         });

      });

      // Switching between video sources
      $('#cv-video-format-source').on( 'change', function() {
         var val = $(this).val();
         $('[data-video-source]').hide().filter('[data-video-source="'+val+'"]').show();
      }).trigger('change');

      // Updating the gallery meta preview
      $('#cv-gallery-format-ids').on( 'change', function() {

         var val = $(this).val();

         if ( ! val ) {
            $('#cv-gallery-format-preview').html('');
            $('#cv-gallery-format-controls').find('.cv-format-meta-manage-gallery').show();
            $('#cv-gallery-format-controls').find('.cv-format-meta-remove-gallery').hide();
            return;
         }

         $('#cv-gallery-format-controls').find('.cv-format-meta-manage-gallery').hide();
         $('#cv-gallery-format-controls').find('.cv-format-meta-remove-gallery').show();

         // Create object for AJAX callback
         var data = {
            action: 'cv_ajax_render_format_gallery',
            input: $(this).val(),
         };

         // Execute AJAX callback
         $.ajax({
            type: 'POST',
            url: cv_formats_meta_localize.ajax_url,
            data: data,
            error: function() {
               alert(cv_formats_meta_localize.gallery_error)
            },
            success: function(response) {

               // User was loged out
               if ( 0 === response ) {
                  alert(cv_formats_meta_localize.ajax_logged_out);
               }

               // Nonce timeout
               else if ( '-1' === response ) {
                  alert(cv_formats_meta_localize.ajax_nonce_error);
               }

               // Actual success
               else {
                  $('#cv-gallery-format-preview').html(response);
               }

            },
         });

      });

      // Removing the gallery meta
      $('.cv-format-meta-remove-gallery').on( 'click', function() {
         var $input = $('#cv-gallery-format-ids');
         $input.val('').trigger('change');
      });

      // Creating/managing the gallery meta
      $('.cv-format-meta-manage-gallery').on( 'click', function() {

         // Determine if a new gallery is being created
         var $input = $('#cv-gallery-format-ids'), create = $input.val() ? false : true;

         // Preexisting selection
         var selection;

         // if there is already a gallery to edit
         if ( ! create ) {

            // Grab the existing gallery value
            var current = $input.val();

            // Set up the arguments object
            var args = {
               orderby: "post__in",
               order: "ASC",
               type: "image",
               perPage: -1,
               post__in: current.split(',')
            };

            // Create attachments object
            var attachments = wp.media.query( args );

            // Update the current selection
            selection = new wp.media.model.Selection( attachments.models, {
                  props:    attachments.props.toJSON(),
                  multiple: true
            });

         }

         // The state of the media window
         var state = create ? 'gallery-library' : 'gallery-edit';

         // Create the media frame.
         var frame = wp.media({
            frame: 'post',
            state: state,
            library: { type: 'image' },
            selection: selection,
         });

         frame.on( 'select update insert', function(obj) {

            // Create the list of ID`s
            var ID_list = [];
            $.each( obj.models, function( id, val ) {
               ID_list.push( val.id );
            });
            ID_list = ID_list.join(',');
            $input.val(ID_list).trigger('change');

         });

         frame.on( 'close' , function() {
            $('body').removeClass('cv-gallery-editor-modal-active');
         });

         $('body').addClass('cv-gallery-editor-modal-active');
         frame.open();

      });

   });

})(jQuery);