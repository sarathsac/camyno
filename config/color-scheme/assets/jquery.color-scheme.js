var cv_preview_primary_bg = function( $preview, target, color ) {
   var $target = $preview.find('#cv-preview-'+target);
   $target.css( 'background-color', color );
};
var cv_preview_secondary_bg = function( $preview, target, color ) {
   var $target = $preview.find('#cv-preview-'+target);
   $target.find('.secondary-bg').css( 'background-color', color );
};
var cv_preview_borders = function( $preview, target, color ) {
   var $target = $preview.find('#cv-preview-'+target);
   $target.find('.border-color').css( 'border-color', color );
   // $target.css( 'border-color', color );
};
var cv_preview_headers = function( $preview, target, color ) {
   var $target = $preview.find('#cv-preview-'+target);
   $target.find('.header').css( 'color', color );
};
var cv_preview_content = function( $preview, target, color ) {
   var $target = $preview.find('#cv-preview-'+target);
   $target.css( 'color', color );
};
var cv_preview_secondary_content = function( $preview, target, color ) {
   var $target = $preview.find('#cv-preview-'+target);
   $target.find('.secondary-content').css( 'color', color );
};
var cv_preview_accent = function( $preview, target, color ) {
   var $target = $preview.find('#cv-preview-'+target);
   $target.find('.accent').css( 'color', color );
};
var cv_preview_focused = function( $preview, target, color ) {
   var $target = $preview.find('#cv-preview-'+target);
   $target.find('.focused').css( 'color', color );
};

(function($) {
   "use strict";

   var $document = $(document);

   $document.ready( function() {

      /* Captures all of the settings as they are */
      var cv_capture_full_scheme = function() {
         var scheme = {}, settings = {};
         settings.header = {};
         settings.main = {};
         settings.alternate = {};
         settings.footer = {};
         settings.socket = {};
         $('.cv-scheme-control').each( function() {
            var $this = $(this), section = $this.data('section'), option = $this.data('option');
            settings[section][option] = $this.val();
         });
         scheme.preset = $('#cv-scheme-presets').find('[name]:checked').val();
         scheme.settings = settings;
         return scheme;
      };

      /* Applies only the color scheme */
      var cv_apply_scheme = function( scheme ) {
         $.each( scheme, function( index, config ) {
            var section = index;
            $.each( config, function( index, value ) {
               $('[name="cv_color_scheme[scheme]['+section+']['+index+']"]').iris('color', value);
            });
         });
      };

      /* Creates a history state in the history tracker */
      var cv_capture_state = function() {
         var scheme = cv_capture_full_scheme();
         scheme = JSON.stringify( scheme );
         var $history = $('#cv-scheme-history');
         var $newState = $('<div class="new-state">'+scheme+'</div>');
         if ( $history.children().length ) {
            $history.find('.active-state').removeClass('active-state').after( $newState );
            $newState.removeClass('new-state').addClass('active-state').nextAll().remove();
         }
         else {
            $newState.removeClass('new-state').addClass('active-state');
            $history.append( $newState );
         }
         cv_assess_history();
      }

      /* Loads a history state */
      var cv_load_state = function( scheme ) {
         $('#cv-scheme-option-'+scheme.preset).prop( 'checked', true );
         $.each( scheme.settings, function( index, config ) {
            var section = index;
            $.each( config, function( index, value ) {
               $('[name="cv_color_scheme[scheme]['+section+']['+index+']"]').iris('color', value);
            });
         });
         cv_assess_history();
      }

      /* Assesing the current state */
      var cv_assess_history = function() {
         var $history = $('#cv-scheme-history');
         if ( ! $history.children().length ) {
            return;
         }
         var $currentState = $history.find('.active-state');
         if ( ! $currentState.next().length ) {
            $('#cv-scheme-step-forward').addClass('is-disabled');
         }
         else {
            $('#cv-scheme-step-forward').removeClass('is-disabled');
         }
         if ( ! $currentState.prev().length ) {
            $('#cv-scheme-step-backward').addClass('is-disabled');
         }
         else {
            $('#cv-scheme-step-backward').removeClass('is-disabled');
         }
      }

      // Capture initial state
      cv_capture_state();

      /* Pressing the back button */
      $('#cv-scheme-step-backward').on( 'click', function() {
         if ( $(this).hasClass('is-disabled') ) {
            return;
         }
         var $history = $('#cv-scheme-history');
         var $activeState = $history.find('.active-state').removeClass('active-state');
         var $newState = $activeState.prev().addClass('active-state');
         var scheme = $newState.html();
         scheme = JSON.parse( scheme );
         cv_load_state( scheme );
      });

      /* Pressing the forward button */
      $('#cv-scheme-step-forward').on( 'click', function() {
         if ( $(this).hasClass('is-disabled') ) {
            return;
         }
         var $history = $('#cv-scheme-history');
         var $activeState = $history.find('.active-state').removeClass('active-state');
         var $newState = $activeState.next().addClass('active-state');
         var scheme = $newState.html();
         scheme = JSON.parse( scheme );
         cv_load_state( scheme );
      });

      // Applying new schemes
      $('.cv-load-scheme').on( 'click', function() {
         var $this = $(this), scheme = $this.data('scheme');
         cv_apply_scheme( scheme );
         setTimeout( cv_capture_state, 100 );
      });

      // Activate color pickers
      var $preview = $('#cv-scheme-preview');
      var $colorPickers = $('.cv-color-picker');
      var fadeSpeed = 250;

      $colorPickers.each( function() {

         var $input = $(this);

         // Activate Iris Color Picker
         $input.iris({
            mode: 'hsl',
            hide: false,
            change: function( e, ui ) {
               var $target = $(e.target),
                   updateTarget = $target.data('section'),
                   updateFunction = $target.data('update'),
                   color = ui.color.toString();
               $target.parent().css( 'background-color', color );
               window[updateFunction]( $preview, updateTarget, color );
            }
         });

         // Wrap the input in the color display
         $input.wrap('<div class="cv-color-picker-display"></div>');

         // Apply the initial color to the wrap
         $input.parent().next().wrap('<div class="cv-picker-wrap" style="display:none;"></div>');
         $input.parent().css( 'background-color', $input.val() );

         // The actual color picker object
         var $picker = $input.parent().next();
         var title = $input.data('section-name')+' '+$input.data('option-name');
         $picker.prepend('<strong>'+title+'</strong>');

         // Apply click event to the input
         $input.on( 'click', function(e) {
            e.stopPropagation();
            $input.toggleClass('cv-picker-open');
            if ( $input.hasClass('cv-picker-open') ) {
               $input.data('former-color', $input.val());
               var isRTL = 'rtl' === $('html').attr('dir') ? true : false;
               var $preview = $('#cv-scheme-preview');
               var previewWidth = parseInt( $preview.outerWidth() );
               var leftOffset = parseInt( $preview.offset().left );
               var rightOffset = parseInt( $(window).width() ) - ( leftOffset + previewWidth );
               var fullSize = isRTL ? rightOffset + previewWidth : leftOffset + previewWidth;
               var gap = $(window).width() - fullSize;
               var CSSProp = isRTL ? 'right' : 'left';
               if ( gap > 250 ) {
                  $picker.css( CSSProp, (fullSize+15)+'px' ).fadeIn(fadeSpeed);
               }
               else {
                  $picker.css( CSSProp, 'auto' ).fadeIn(fadeSpeed);
               }
            }
            else {
               if ( $input.val() !== $input.data('former-color') ) {
                  $input.trigger('change');
               }
               $input.data('former-color', null);
               $picker.fadeOut(fadeSpeed);
            }
            $colorPickers.each( function() {
               var $this = $(this);
               if ( $this.hasClass('cv-picker-open') && ! $this.is($input) ) {
                  if ( $this.val() !== $this.data('former-color') ) {
                     $this.trigger('change');
                  }
                  $this.data('former-color', null);
                  $this.removeClass('cv-picker-open')
                  $this.parent().next().hide();
               }
            });
         });

         // Close open color pickers when body is clicked
         $document.on( 'click', function(e) {
            e.stopPropagation();
            $colorPickers.each( function() {
               var $this = $(this);
               if ( $this.hasClass('cv-picker-open') ) {
                  if ( $this.val() !== $this.data('former-color') ) {
                     $this.trigger('change');
                  }
                  $this.data('former-color', null);
                  $this.removeClass('cv-picker-open');
                  $this.parent().next().fadeOut(fadeSpeed);
               }
            });
         });

         // When an input changes capture a history state
         $input.on( 'change', function() {
            cv_capture_state();
         });

         // Trigger a change to update the live preview
         $input.iris('color', $input.val() );

      });

      // Switching between tabs
      $('#cv-scheme-tabs').children().on( 'click', function() {
         var $this = $(this), target = $this.data('section');

         // Change active tab
         $this.addClass('nav-tab-active').siblings().removeClass('nav-tab-active');

         // Display appropriate tab
         $('.cv-section-'+target).show().siblings().hide();

      });

   });

})(jQuery);