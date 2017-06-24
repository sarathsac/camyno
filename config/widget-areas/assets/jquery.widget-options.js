;(function($) {
   "use strict";

   $(document).on( 'click', '.cv-get-map-coordinates', function(e) {

      var geocoder = new google.maps.Geocoder(),
          $wrap = $(this).closest('.widget-content'),
          address = $wrap.find('.cv-map-address').val(),
          $latControl = $wrap.find('.cv-map-lat'),
          $lngControl = $wrap.find('.cv-map-lng');

      geocoder.geocode( { 'address': address}, function(results, status) {

        if ( status == google.maps.GeocoderStatus.OK ) {
          var latitude = results[0].geometry.location.lat(),
              longitude = results[0].geometry.location.lng();
          $latControl.val(latitude);
          $lngControl.val(longitude);
        }
        else {
            alert(cv_widget_options_localize.address_not_found);
        }
      });

   });

})(jQuery);