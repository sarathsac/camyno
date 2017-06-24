(function($) {
   "use strict";

   $(document).ready( function() {

      var $window = $(window);

      // Load color picker
      $('.cv-color-picker').wpColorPicker();

      // Show/hide custom controls
      $('#cv_banner_display').on( 'change', function() {
         var $this = $(this), $wrap = $this.closest('tr'), val = $this.val(),
             $customSettings = $('#cv-banner-settings-form-table').find('.custom-settings-option');
         if ( 'custom' === val ) {
            $customSettings.show();
            $wrap.removeClass('no-border');
         }
         else {
            $customSettings.hide();
            $wrap.addClass('no-border');
         }
      }).trigger('change');

      // Show / hide bread crumbs control
      $('#cv_banner_text_style').on( 'change', function() {
         var $this = $(this), val = $this.val(),
             $crumbsControlWrap = $('#cv_banner_show_crumbs-wrap');
         if ( 'hidden' === val ) {
            $crumbsControlWrap.hide();
         }
         else {
            $crumbsControlWrap.show();
         }
      });

      // Show appropriate image source option
      $('#cv_banner_bg_image_source').on( 'change', function() {
         var $this = $(this), val = $this.val(),
             $imageControlsWrap = $('#cv_banner_bg_image_source_control_wrap .image-controls');
         $imageControlsWrap.attr('data-source', val);
      });

      /* Custom background Image Uploader */
      $('#cv_banner_bg_custom_select_image, #cv_banner_bg_custom_preview img').on( 'click', function(e) {

         var $input = $('#cv_banner_bg_custom'),
             $previewWrap = $('#cv_banner_bg_custom_preview'),
             $wrap = $('#cv_banner_bg_custom_control_wrap');

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

      $('#cv_banner_bg_custom_remove_image').on( 'click', function() {
            $('#cv_banner_bg_custom').val('');
            $('#cv_banner_bg_custom_control_wrap').removeClass('has-image');
            $('#cv_banner_bg_custom_preview').hide().find('img').attr('src', '');
      });

      // Show / hide overlay color option
      $('#cv_banner_overlay_opacity').on( 'change', function() {
         var $this = $(this), val = $this.val(),
             $colorControl = $('#cv_banner_overlay_color-wrap');
         if ( 'none' === val ) {
            $colorControl.hide();
         }
         else {
            $colorControl.show();
         }
      }).trigger('change');

   });

})(jQuery);