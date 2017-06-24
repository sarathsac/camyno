<?php

if ( ! function_exists( 'cv_render_eventscalendar_styles' ) ) :

add_action( 'cv_render_dynamic_stylesheet', 'cv_render_eventscalendar_styles', null, 1 );

/**
 * Generate dynamic events calendar styles
 *
 * @param array $sections Color scheme settings
 * @return string
 */
function cv_render_eventscalendar_styles( $sections ) {

   // Events Notifications
   echo
     ".tribe-events-notices li {"
   . "color: {$sections['main']['secondary_content']} !important;"
   . "border-left: 1px solid {$sections['main']['accent']} !important;"
   . "background: {$sections['main']['secondary_bg']} !important;"
   . "}"
   ;

   // Events Toolbar
   echo
     "#tribe-bar-form label {"
   . "color: " . cv_hex_to_rgba( $sections['main']['secondary_content'], 0.5 ) . " !important;"
   . "}"
   . "#tribe-bar-form #tribe-bar-collapse-toggle {"
   . "color: {$sections['main']['secondary_content']} !important;"
   . "border: 1px solid {$sections['main']['borders']} !important;"
   . "}"
   . "#tribe-bar-form #tribe-bar-collapse-toggle .tribe-bar-toggle-arrow {"
   . "border-color: {$sections['main']['secondary_content']} !important;"
   . "}"
   . "#body #tribe-events-pg-template .tribe-bar-views-list {"
   . "background: {$sections['main']['secondary_bg']} !important;"
   . "}"
   . "#body #tribe-events-pg-template .tribe-bar-views-inner, #body #tribe-events-pg-template .tribe-bar-views-inner a {"
   . "background: {$sections['main']['secondary_bg']} !important;"
   . "color: {$sections['main']['secondary_content']} !important;"
   . "}"
   . "#body #tribe-events-pg-template #tribe-bar-views.tribe-bar-views-open .tribe-bar-views-inner li:not(.tribe-bar-active) a {"
   . "background: " . cv_hex_to_rgba( $sections['main']['secondary_content'], 0.85 ) . " !important;"
   . "text-shadow: {$sections['main']['secondary_content']} 0px 1px 3px !important;"
   . "color: {$sections['main']['secondary_bg']} !important;"
   . "}"
   . "#body #tribe-events-pg-template #tribe-bar-views.tribe-bar-views-open .tribe-bar-views-inner li:not(.tribe-bar-active) a:hover {"
   . "background: {$sections['main']['secondary_content']} !important;"
   . "}"
   . "#tribe-bar-form {"
   . "background: {$sections['main']['secondary_bg']} !important;"
   . "}"
   . '#tribe-bar-form .tribe-bar-filters input[type="text"] {'
   . "color: {$sections['main']['secondary_content']} !important;"
   . "border-bottom: 1px dotted " . cv_hex_to_rgba( $sections['main']['secondary_content'], 0.25 ) . " !important;"
   . "}"
   . "#tribe-bar-form .tribe-bar-filters .tribe-events-button {"
   . "color: " . cv_hex_to_rgba( $sections['main']['secondary_content'], 0.75 ) . " !important;"
   . "border: 2px solid " . cv_hex_to_rgba( $sections['main']['secondary_content'], 0.25 ) . " !important;"
   . "}"
   . "#tribe-bar-form .tribe-bar-filters .tribe-events-button:hover {"
   . "color: {$sections['main']['accent']} !important;"
   . "border: 2px solid {$sections['main']['accent']} !important;"
   . "}"
   . '#tribe-bar-form input[name*="tribe-bar-"]::-webkit-input-placeholder {'
   . "color: {$sections['main']['secondary_content']} !important;"
   . "}"
   . '#tribe-bar-form input[name*="tribe-bar-"]::-moz-placeholder {'
   . "color: {$sections['main']['secondary_content']} !important;"
   . "}"
   . '#tribe-bar-form .placeholder {'
   . "color: {$sections['main']['secondary_content']} !important;"
   . "}"
   ;

   // Calendar View
   $over_accent_color = 0.85 > cv_hex_brightness( $sections['main']['accent'] ) ? '255,255,255' : '0,0,0';
   echo
     ".tribe-events-calendar thead {"
   . "background: {$sections['main']['accent']} !important;"
   . "border: 1px solid {$sections['main']['accent']} !important;"
   . "}"
   . ".tribe-events-calendar thead th {"
   . "color: rgba({$over_accent_color},0.85) !important;"
   . "}"
   . ".tribe-events-calendar td,"
   . ".tribe-events-calendar tr {"
   . "border-color: {$sections['main']['borders']} !important;"
   . "}"
   . ".tribe-events-calendar .vevent + .vevent {"
   . "border-top: 1px solid {$sections['main']['borders']} !important;"
   . "}"
   . ".tribe-events-calendar th {"
   . "color: " . cv_hex_to_rgba( $sections['main']['content'], 0.75 ) . " !important;"
   . "}"
   . '.tribe-events-calendar [id*="tribe-events-daynum-"] {'
   . "background: " . cv_hex_to_rgba( $sections['main']['secondary_bg'], 0.5 ) . " !important;"
   . "color: {$sections['main']['secondary_content']} !important;"
   . "}"
   . '.tribe-events-calendar [id*="tribe-events-daynum-"] a {'
   . "background: " . cv_hex_to_rgba( $sections['main']['secondary_bg'], 0.5 ) . " !important;"
   . "color: {$sections['main']['secondary_content']} !important;"
   . "}"
   . '.tribe-events-calendar .mobile-active [id*="tribe-events-daynum-"],' . ""
   . '.tribe-events-calendar .mobile-active [id*="tribe-events-daynum-"] a {'
   . "color: rgba({$over_accent_color},0.85) !important;"
   . "}"
   . ".tribe-events-calendar .tribe-events-has-events:after {"
   . "background: {$sections['main']['accent']} !important;"
   . "}"
   . ".tribe-events-calendar .mobile-active,"
   . ".tribe-events-calendar .mobile-active:hover {"
   . "background: {$sections['main']['accent']} !important;"
   . "}"
   ;

   // Grid (Week) View
   $over_accent_color = 0.85 > cv_hex_brightness( $sections['main']['accent'] ) ? '255,255,255' : '0,0,0';
   echo
     ".tribe-events-grid {"
   . "border-bottom: 1px solid {$sections['main']['borders']} !important;"
   . "}"
   . ".tribe-events-grid .tribe-grid-header {"
   . "background: {$sections['main']['accent']} !important;"
   . "border: 1px solid {$sections['main']['accent']} !important;"
   . "}"
   . ".tribe-events-grid .tribe-grid-header a {"
   . "color: rgba({$over_accent_color},0.85) !important;"
   . "}"
   . ".tribe-events-grid .tribe-grid-content-wrap .column {"
   . "border-left: 1px solid {$sections['main']['borders']} !important;"
   . "}"
   . ".tribe-events-grid .tribe-grid-allday {"
   . "background: {$sections['main']['primary_bg']} !important;"
   . "border-left: 1px solid {$sections['main']['borders']} !important;"
   . "border-right: 1px solid {$sections['main']['borders']} !important;"
   . "border-bottom: 1px solid {$sections['main']['borders']} !important;"
   . "}"
   . ".tribe-events-grid .tribe-grid-allday .first {"
   . "background: {$sections['main']['secondary_bg']} !important;"
   . "}"
   . ".tribe-events-grid .slimScrollDiv {"
   . "border-left: 1px solid {$sections['main']['borders']} !important;"
   . "border-right: 1px solid {$sections['main']['borders']} !important;"
   . "}"
   . ".tribe-events-grid .tribe-grid-allday .first span {"
   . "color: {$sections['main']['secondary_content']} !important;"
   . "}"
   . ".tribe-events-grid .tribe-week-grid-hours {"
   . "background: {$sections['main']['secondary_bg']} !important;"
   . "color: {$sections['main']['secondary_content']} !important;"
   . "}"
   . ".tribe-events-grid .tribe-week-grid-block div {"
   . "border-top: 1px solid {$sections['main']['borders']} !important;"
   . "border-bottom: 1px dotted {$sections['main']['borders']} !important;"
   . "}"
   . ".tribe-events-grid .hentry.vevent > div:not(.tribe-events-tooltip) {"
   . "border-color: {$sections['main']['accent']} !important;"
   . "background: " . cv_hex_to_rgba( $sections['main']['accent'], 0.15 ) . " !important;"
   . "}"
   . ".tribe-events-grid .hentry.vevent:hover > div:not(.tribe-events-tooltip) {"
   . "background: " . cv_hex_to_rgba( $sections['main']['accent'], 0.25 ) . " !important;"
   . "}"
   . ".tribe-events-grid .hentry.vevent > div:not(.tribe-events-tooltip) h3 a {"
   . "color: {$sections['main']['accent']} !important;"
   . "}"
   . ".tribe-mobile-day-date {"
   . "background: {$sections['main']['secondary_bg']} !important;"
   . "color: {$sections['main']['secondary_content']} !important;"
   . "}"
   ;

   // Photo View
   echo
     "#tribe-events-photo-events .tribe-events-photo-event-wrap {"
   . "background: {$sections['main']['secondary_bg']} !important;"
   . "color: {$sections['main']['secondary_content']} !important;"
   . "}"
   . "#tribe-events-photo-events .event-is-recurring {"
   . "color: {$sections['main']['secondary_content']} !important;"
   . "}"
   . "#tribe-events-photo-events .tribe-events-list-event-title a {"
   . "color: {$sections['main']['headers']} !important;"
   . "}"
   . "#tribe-events-photo-events .tribe-events-event-meta {"
   . "border-bottom: 1px solid {$sections['main']['borders']} !important;"
   . "}"
   ;

   // List View
   $over_accent_color = 0.85 > cv_hex_brightness( $sections['main']['accent'] ) ? '255,255,255' : '0,0,0';
   echo
     ".tribe-events-loop:not(#tribe-events-photo-events) .tribe-events-event-cost span {"
   . "background: {$sections['main']['accent']} !important;"
   . "border: 5px solid {$sections['main']['primary_bg']} !important;"
   . "color: rgba({$over_accent_color},0.85) !important;"
   . "}"
   . ".tribe-events-loop:not(#tribe-events-photo-events) .tribe-events-event-meta a {"
   . "color: {$sections['main']['content']} !important;"
   . "}"
   . ".tribe-events-loop:not(#tribe-events-photo-events) .event-is-recurring {"
   . "color: {$sections['main']['content']} !important;"
   . "}"
   . ".tribe-events-loop:not(#tribe-events-photo-events) .tribe-events-read-more {"
   . "border: 2px solid {$sections['main']['accent']} !important;"
   . "}"
   . ".tribe-events-loop:not(#tribe-events-photo-events) .tribe-events-read-more:hover {"
   . "background: {$sections['main']['accent']} !important;"
   . "color: rgba({$over_accent_color},0.85) !important;"
   . "}"
   ;

   // List View Mobile .tribe-events-venue-details
   echo
     "@media (max-width: 768px) {"
   . ".tribe-events-loop .tribe-events-event-meta {"
   . "background: {$sections['main']['secondary_bg']} !important;"
   . "border: 1px solid {$sections['main']['borders']} !important;"
   . "color: {$sections['main']['secondary_content']} !important;"
   . "}"
   . ".tribe-events-loop:not(#tribe-events-photo-events) .tribe-events-event-meta a {"
   . "color: {$sections['main']['accent']} !important;"
   . "}"
   . ".tribe-events-loop:not(#tribe-events-photo-events) .tribe-events-event-meta .event-is-recurring {"
   . "color: {$sections['main']['secondary_content']} !important;"
   . "}"
   . ".tribe-events-loop .tribe-events-event-meta .tribe-events-venue-details {"
   . "border-top: 1px solid {$sections['main']['borders']} !important;"
   . "}"
   . "}"
   ;

   // List View Separators
   echo
     '[class*="tribe-events-list-separator-"] span {'
   . "background: {$sections['main']['primary_bg']} !important;"
   . "}"
   ;

   // Day View
   echo
     ".tribe-events-day-time-slot h5 {"
   . "background: {$sections['main']['secondary_bg']} !important;"
   . "color: {$sections['main']['secondary_content']} !important;"
   . "}"
   ;

   // List View
   echo
     '[class*="tribe-events-list-separator-"]:after {'
   . "border-color: " . cv_hex_to_rgba( $sections['main']['content'], 0.25 ) . " !important;"
   . "}"
   . '[class*="tribe-events-list-separator-"] span {'
   . "color: " . cv_hex_to_rgba( $sections['main']['content'], 0.75 ) . " !important;"
   . "}"
   ;

   // Sub Navigation
   echo
     "@media (max-width: 768px) {"
   . ".tribe-events-sub-nav {"
   . "background: {$sections['main']['secondary_bg']} !important;"
   . "}"
   . ".tribe-events-sub-nav a {"
   . "color: {$sections['main']['secondary_content']} !important;"
   . "}"
   . "}"
   . "@media (min-width: 768px) {"
   . "#tribe-events-footer .tribe-events-sub-nav a {"
   . "border: 2px solid " . cv_hex_to_rgba( $sections['main']['content'], 0.25 ) . " !important;"
   . "color: " . cv_hex_to_rgba( $sections['main']['content'], 0.75 ) . " !important;"
   . "}"
   . "#tribe-events-footer .tribe-events-sub-nav a:hover {"
   . "border: 2px solid {$sections['main']['accent']} !important;"
   . "color: {$sections['main']['accent']} !important;"
   . "}"
   . "}"
   ;

   // Single event pages
   echo
     ".single-tribe_events .cv-events-return-button {"
   . "border: 2px solid {$sections['main']['borders']};"
   . "color: {$sections['main']['secondary_content']};"
   . "}"
   . ".single-tribe_events .cv-events-return-button:hover {"
   . "border: 2px solid {$sections['main']['accent']};"
   . "color: {$sections['main']['accent']};"
   . "}"
   . ".single-tribe_events .tribe-events-event-meta {"
   . "background: {$sections['main']['secondary_bg']} !important;"
   . "color: {$sections['main']['secondary_content']} !important;"
   . "}"
   . ".single-tribe_events .event-is-recurring {"
   . "color: {$sections['main']['content']} !important;"
   . "}"
   . ".single-tribe_events .tribe-events-divider {"
   . "color: {$sections['main']['borders']} !important;"
   . "}"
   ;

   // Tribe Events Buttons
   $over_accent_color = 0.85 > cv_hex_brightness( $sections['main']['accent'] ) ? '255,255,255' : '0,0,0';
   echo
     ".tribe-events-button {"
   . "background: {$sections['main']['accent']} !important;"
   . "color: rgb({$over_accent_color}) !important;"
   . "}"
   ;

}
endif;