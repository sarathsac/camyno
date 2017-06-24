(function($) {
   "use strict";

   $(document).ready( function() {

      // Sidebar manager HTML
      var manager_html = $('#tmpl-cv-sidebar-manager').html();

      // Insert the sidebar manager
      $('.widget-liquid-right').prepend(manager_html);

      // Add a delete button to custom sidebars
      var delete_button = '<span class="cv-delete-user-sidebar" title="'+cv_sidebar_manager_localize.delete_sidebar+'"><i class="icon-cancel"></i></span>';
      $('[id*="cv_user_sidebar_"]').append(delete_button);

      // Creating a new sidebar
      $('#cv-create-new-sidebar').on( 'click' , function() {

         var $this = $(this), $field = $this.prev(), name = $field.val().replace(/[^a-z\d\s]+/gi, '');

         if ( ! name ) {
            alert(cv_sidebar_manager_localize.empty_name);
            $field.val('');
            return;
         }

         if ( 3 > name.length ) {
            alert(cv_sidebar_manager_localize.short_name);
            $field.val('');
            return;
         }

         // Create object for AJAX callback
         var data = {
            sidebar_name: name,
            action: 'cv_ajax_add_sidebar'
         };

         // Fetch the processed module using AJAX
         $.ajax({

            type: 'POST',
            url: cv_sidebar_manager_localize.ajax_url,
            data: data,

            success: function() {
               location.reload();
            }

         });

      });

      // Deleting a sidebar
      $('.cv-delete-user-sidebar').on( 'click', function() {

         var $this = $(this), $wrap = $this.closest('.widgets-holder-wrap'),
         id = $this.parent().attr('id').replace('cv_user_sidebar_','');

         // Show the spinner
         $wrap.find('.spinner').css('display', 'inline-block');

         // Create object for AJAX callback
         var data = {
            sidebar_id: id,
            action: 'cv_ajax_delete_sidebar'
         };

         // Fetch the processed module using AJAX
         $.ajax({

            type: 'POST',
            url: cv_sidebar_manager_localize.ajax_url,
            data: data,

            success: function() {

               // Delete widgets
               $wrap.find('.widget-control-remove').trigger('click');

               // Remove the widget area
               $wrap.slideUp( function() {
                  $wrap.remove();
               });

            }

         });

      });

   });

})(jQuery);