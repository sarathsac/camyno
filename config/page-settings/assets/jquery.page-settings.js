(function($) {
   "use strict";

   var $document = $(document);

   $document.ready( function() {

      // Load color picker
      $('.cv-color-picker').wpColorPicker();

      // Appropriately show/hide extra page slide controls
      $('#cv_page_slide').on( 'change', function() {
         var $this = $(this), $pageSlideControls = $('#cv_page_slide_extra_controls_wrap');
         if ( $this.prop('checked') ) {
            $pageSlideControls.slideDown()
         }
         else {
            $pageSlideControls.slideUp();
         }
      });

      // Appropriately show/hide transparency controls
      $('#cv_transparency').on( 'change', function() {
         var $this = $(this), val = $this.val(),
             $transparencyControls = $('#cv_transparency_extra_controls_wrap');
         if ( 'custom' === val ) {
            $transparencyControls.slideDown()
         }
         else {
            $transparencyControls.slideUp();
         }
      });

      // Appropriately show/hide sidebar selector
      $('#cv_layout').on( 'change', function() {
         var $this = $(this), val = $this.val(), $sidebarControl = $('#cv_sidebar_control_wrap');
         if ( 'no-sidebar' === val ) {
            $sidebarControl.slideUp();
         }
         else {
            $sidebarControl.slideDown();
         }
      });

      $('#cv_transparency_select_logo, #cv_transparency_logo_preview img').on( 'click', function(e) {

         var $input = $('#cv_transparency_logo'),
             $previewWrap = $('#cv_transparency_logo_preview'),
             $wrap = $('#cv_transparency_extra_controls_wrap');

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
            var url = attachment.url, id = attachment.id;

            $input.val(id).trigger('change');
            $previewWrap.show().find('img').attr('src', url);
            $wrap.addClass('has-image');

         });

         // Finally, open the modal.
         frame.open();

      });

      $('#cv_transparency_remove_logo').on( 'click', function() {

            $('#cv_transparency_logo').val('');
            $('#cv_transparency_extra_controls_wrap').removeClass('has-image');
            $('#cv_transparency_logo_preview').slideUp( function() {
               $(this).find('img').attr('src', '');
            });

      });

   });

})(jQuery);