(function($) {
   "use strict";

   var $document = $(document);

   $document.ready( function() {

      var $preview = $('#cv-background-preview'),
          $fullPreview = $('#cv-background-fullscreen-preview');

      // Full screen previewer
      $preview.find('.view-full-preview').on( {
         mouseenter: function() {
            $('html').addClass('cv-background-preview-active');
            $fullPreview.attr('style', $preview.attr('style') );
            if ( '150px' === $fullPreview.css('background-size') ) {
               $fullPreview.css( 'background-size', 'auto' );
            }
         },
         mouseleave: function() {
            $('html').removeClass('cv-background-preview-active');
            $fullPreview.removeAttr('style');
         }
      } );

      // Update the live preview with presets
      $('.background-preset-option').on( 'click', function() {
         var $this = $(this);
         $('#cv-bg-preset-attachment-wrap').slideDown();
         $preview.removeClass('is-custom').removeAttr('style').css({
            backgroundImage: 'url('+$this.data('pattern')+')',
            backgroundAttachment: $('#cv-bg-preset-attachment').val(),
            backgroundRepeat: 'repeat',
         });
      });
      $('#cv-bg-preset-attachment').on( 'change', function() {
         $preview.css({
            backgroundAttachment: $(this).val(),
         });
      });

      // Activate the Color Picker
      $('.wp-color-picker').each( function() {

         var $input = $(this);

         $input.iris({
            mode: 'hsl',
            hide: false,
            change: function( e, ui ) {
               var $target = $(e.target),
                   color = ui.color.toString();
               $target.css( 'background-color', color );
               $preview.css( 'background-color', color );
            }
         }).css( 'background-color', $input.val() );

         // Wrap the input in the color display
         // $input.wrap('<div class="cv-color-picker-display"></div>');

         // Apply the initial color to the wrap
         $input.next().wrap('<div class="cv-picker-wrap" style="display:none;"></div>');
         // $input.parent().css( 'background-color', $input.val() );

         // The actual color picker object
         var $picker = $input.next();

         $input.on( 'click', function(e) {
            e.stopImmediatePropagation();
            $picker.slideToggle();
         });

         $document.on( 'click', function() {
            $picker.slideUp();
         });

      });

      // Update the live preview with custom background settings
      $('#cv-bg-image').on( 'change keyup', function( ){
         var $this = $(this), $styleWrap = $('#cv-bg-style-wrap');
         $preview.css( 'background-image', 'url(' + $this.val() + ')' );
         if ( $this.val() ) {
            $styleWrap.fadeIn();
         }
         else {
            $styleWrap.fadeOut().find('select').val('cover').trigger('change');
         }
      });
      $('#cv-bg-repeat').on( 'change', function( ){
         $preview.css( 'background-repeat', $(this).val() );
      });
      $('#cv-bg-position').on( 'change', function( ){
         $preview.css( 'background-position', $(this).val() );
      });
      $('#cv-bg-custom-attachment').on( 'change', function( ){
         $preview.css( 'background-attachment', $(this).val() );
      });
      $('#cv-bg-style').on( 'change', function() {
         $preview.removeAttr('style').css({
            backgroundImage: 'url(' + $('#cv-bg-image').val() + ')',
            backgroundColor: $('#cv-bg-color').val(),
         });
         if ( 'tile' === $(this).val() ) {
            $preview.css({
               backgroundSize: '150px',
               backgroundRepeat: $('#cv-bg-repeat').val(),
               backgroundPosition: $('#cv-bg-position').val(),
               backgroundAttachment: $('#cv-bg-custom-attachment').val(),
            });
            $('#cv-bg-custom-advanced-controls').slideDown();
         }
         else {
            $preview.css({
               backgroundSize: 'cover',
               backgroundAttachment: 'fixed',
            });
            $('#cv-bg-custom-advanced-controls').slideUp();
         }
      });

      // Image upload field
      $('#cv-background-upload').on( 'click', function(e) {

         var $input = $('#cv-bg-image');

         e.stopImmediatePropagation();

         // Create the media frame.
         var frame = wp.media({
            title: 'Select an Image',
            button: { text: 'Use This Image' },
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

      // Switching between tabs
      $('#cv-background-tabs').children().on( 'click', function() {
         var $this = $(this), target = $this.data('source');

         // Change active tab
         $this.addClass('nav-tab-active').siblings().removeClass('nav-tab-active');

         // Display appropriate tab
         $('#cv-'+target+'-pane').show().siblings().hide();

         // Switching to custom tab
         if ( 'custom' === target ) {

            // Change source value
            $('#cv-bg-source-custom').prop( 'checked', true );

            // Hide the preset attachment chooser
            $('#cv-bg-preset-attachment-wrap').slideUp();

            // Update the preview
            $preview.addClass('is-custom').removeAttr('style').css({
               backgroundColor: $('#cv-bg-color').val(),
            });

            if ( $('#cv-bg-image').val() ) {

               $preview.css('background-image', 'url(' + $('#cv-bg-image').val() + ')' );

               if ( 'tile' === $('#cv-bg-style').val() ) {
                  $preview.css({
                     backgroundSize: '150px',
                     backgroundRepeat: $('#cv-bg-repeat').val(),
                     backgroundPosition: $('#cv-bg-position').val(),
                     backgroundAttachment: $('#cv-bg-custom-attachment').val(),
                  });
               }
               else {
                  $preview.css({
                     backgroundSize: 'cover',
                     backgroundAttachment: 'fixed',
                  });
               }

            }

         }

      });

   });

})(jQuery);