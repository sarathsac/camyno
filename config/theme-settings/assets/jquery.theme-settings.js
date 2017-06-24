(function($) {
   "use strict";

   var $document = $(document);

   $document.ready( function() {

      $('.restore-defaults').on( 'click', function(e) {
         var r = confirm('Are you sure?');
         if ( ! r ) e.preventDefault();
      });

      var $tabs = $('#cv-theme-settings-tabs');
      var $panes = $('#cv-theme-settings-panes');

      // Set first tab & pane to active
      $tabs.children().eq(0).addClass('is-active');
      $panes.children().eq(0).addClass('is-active');

      // Switching between primary tabs
      $tabs.children().on( 'click', function() {

         if ( $(this).hasClass('is-active') ) return;

         if ( $document.data( 'cv-settings-animating' ) ) return;

         $document.data( 'cv-settings-animating', true );

         setTimeout( function() {
            $document.data( 'cv-settings-animating', false );
         }, 300 );

         var $this = $(this), pane = $this.data('pane');
         $this.addClass('is-active').siblings().removeClass('is-active');
         $panes.children('.is-active').fadeOut( 150, function() {
            $(this).removeClass('is-active');
            $panes.find('[data-pane="'+pane+'"]').fadeIn( 150, function() {
               $(this).addClass('is-active');
            });
         });

      });

      // Inner tabs/pane functionality
      var $innerTabs = $('.cv-settings-inner-tabs');

      $innerTabs.children().eq(0).addClass('is-active');
      $('.cv-settings-inner-panes').children().eq(0).addClass('is-active');

      $innerTabs.on( 'click', 'a', function() {

         if ( $(this).hasClass('is-active') ) return;

         if ( $document.data( 'cv-settings-animating' ) ) return;

         $document.data( 'cv-settings-animating', true );

         setTimeout( function() {
            $document.data( 'cv-settings-animating', false );
         }, 300 );

         var $this = $(this), pane = $this.data('pane');
         $this.addClass('is-active').siblings().removeClass('is-active');
         $this.parent().next().children('.is-active').fadeOut( 150, function() {
            $(this).removeClass('is-active');
            $this.parent().next().find('[data-pane="'+pane+'"]').fadeIn( 150, function() {
               $(this).addClass('is-active');
            });
         });
      });

      // Activate color pickers
      $('.cv-color-picker').wpColorPicker();

      // Image selection
      $('.cv-select-image').on( 'click', function(e) {

         var $input = $(this).prev();

         e.stopImmediatePropagation();

         // Create the media frame.
         var frame = wp.media({
            title: 'Select an Image',
            button: { text: 'Use this Image' },
            library: { type: 'image' },
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

      // Image preview
      $('.cv-image-with-preview').on( 'change keyup', function() {

         var $this = $(this), $parent = $this.parent(),
             $select = $parent.find('.cv-select-image'), val = $this.val();

         if ( val ) {

            // Preview already exists, update it
            if ( $select.next().hasClass('image-preview') ) {
               $select.next().find('img').attr( 'src', val );
            }

            // If not, create it
            else {
               var preview = '<p class="option-description additional-message image-preview">'
                           + '<img src="'+val+'" alt="" />'
                           + '<i class="icon-cancel cv-remove-image"></i>'
                           + '</p>';
               $select.after(preview);
            }
         }

         else if ( $select.next().hasClass('image-preview') ) {
            $select.next().slideUp( function() {
               $(this).remove();
            });
         }

      }).trigger('change');

      $document.on( 'click', '.cv-remove-image', function() {
         var $this = $(this), $preview = $this.parent(),
             $wrap = $preview.parent(), $input = $wrap.find('.cv-image-with-preview');

         $preview.slideUp( function() {
            $(this).remove();
            $input.val('');
         });

      });

   });

})(jQuery);