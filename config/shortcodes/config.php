<?php

global $canvys;

// Load required directories
include dirname(__FILE__) . '/controls/carousel-config.php';
include dirname(__FILE__) . '/controls/color.php';
include dirname(__FILE__) . '/controls/coordinates.php';
include dirname(__FILE__) . '/controls/dev.php';
include dirname(__FILE__) . '/controls/file.php';
include dirname(__FILE__) . '/controls/gallery.php';
include dirname(__FILE__) . '/controls/icon.php';
include dirname(__FILE__) . '/controls/image.php';
include dirname(__FILE__) . '/controls/layout.php';
include dirname(__FILE__) . '/controls/link.php';
include dirname(__FILE__) . '/controls/list.php';
include dirname(__FILE__) . '/controls/number.php';
include dirname(__FILE__) . '/controls/pattern.php';
include dirname(__FILE__) . '/controls/select-image_size.php';
include dirname(__FILE__) . '/controls/select-multiple.php';
include dirname(__FILE__) . '/controls/select-page.php';
include dirname(__FILE__) . '/controls/select-sidebar.php';
include dirname(__FILE__) . '/controls/select.php';
include dirname(__FILE__) . '/controls/slider-config.php';
include dirname(__FILE__) . '/controls/text.php';

include dirname(__FILE__) . '/tags/action-box.php';
include dirname(__FILE__) . '/tags/animated-number.php';
include dirname(__FILE__) . '/tags/blog.php';
include dirname(__FILE__) . '/tags/button-child.php';
include dirname(__FILE__) . '/tags/button-group.php';
include dirname(__FILE__) . '/tags/button.php';
include dirname(__FILE__) . '/tags/change-log.php';
include dirname(__FILE__) . '/tags/column-row.php';
include dirname(__FILE__) . '/tags/column.php';
include dirname(__FILE__) . '/tags/divider-row.php';
include dirname(__FILE__) . '/tags/divider.php';
include dirname(__FILE__) . '/tags/form-field.php';
include dirname(__FILE__) . '/tags/form.php';
include dirname(__FILE__) . '/tags/fullwidth-slide-element.php';
include dirname(__FILE__) . '/tags/fullwidth-slide.php';
include dirname(__FILE__) . '/tags/fullwidth-slider.php';
include dirname(__FILE__) . '/tags/gallery.php';
include dirname(__FILE__) . '/tags/header-special.php';
include dirname(__FILE__) . '/tags/header-stack-line.php';
include dirname(__FILE__) . '/tags/header-stack.php';
include dirname(__FILE__) . '/tags/icon-box-child.php';
include dirname(__FILE__) . '/tags/icon-box-group.php';
include dirname(__FILE__) . '/tags/icon-box.php';
include dirname(__FILE__) . '/tags/image-fullwidth.php';
include dirname(__FILE__) . '/tags/image.php';
include dirname(__FILE__) . '/tags/instructions-step.php';
include dirname(__FILE__) . '/tags/instructions.php';
include dirname(__FILE__) . '/tags/map-fullwidth.php';
include dirname(__FILE__) . '/tags/map-marker.php';
include dirname(__FILE__) . '/tags/map.php';
include dirname(__FILE__) . '/tags/media-flag.php';
include dirname(__FILE__) . '/tags/notification.php';
include dirname(__FILE__) . '/tags/partner-group.php';
include dirname(__FILE__) . '/tags/partner.php';
include dirname(__FILE__) . '/tags/portfolio.php';
include dirname(__FILE__) . '/tags/price-option.php';
include dirname(__FILE__) . '/tags/price-table.php';
include dirname(__FILE__) . '/tags/progress-bars-task.php';
include dirname(__FILE__) . '/tags/progress-bars.php';
include dirname(__FILE__) . '/tags/promo-box-line.php';
include dirname(__FILE__) . '/tags/promo-box.php';
include dirname(__FILE__) . '/tags/recent-portfolio.php';
include dirname(__FILE__) . '/tags/recent-posts.php';
include dirname(__FILE__) . '/tags/row.php';
include dirname(__FILE__) . '/tags/search-bar.php';
include dirname(__FILE__) . '/tags/section.php';
include dirname(__FILE__) . '/tags/single-column.php';
include dirname(__FILE__) . '/tags/social-group.php';
include dirname(__FILE__) . '/tags/spacer-row.php';
include dirname(__FILE__) . '/tags/spacer.php';
include dirname(__FILE__) . '/tags/sticky-menu-item.php';
include dirname(__FILE__) . '/tags/sticky-menu.php';
include dirname(__FILE__) . '/tags/tab-group.php';
include dirname(__FILE__) . '/tags/tab.php';
include dirname(__FILE__) . '/tags/team-member.php';
include dirname(__FILE__) . '/tags/team.php';
include dirname(__FILE__) . '/tags/testimonial-group.php';
include dirname(__FILE__) . '/tags/testimonial.php';
include dirname(__FILE__) . '/tags/text-block.php';
include dirname(__FILE__) . '/tags/toggle-group.php';
include dirname(__FILE__) . '/tags/toggle.php';
include dirname(__FILE__) . '/tags/video.php';

/**
 * Call the activation function for each shortcode
 *
 * This is achieved by iterating through each declared class and
 * checking to see which ones are extensions of cv_Shortcode_Template
 * class, if it is then the init method is called.
 */
foreach ( get_declared_classes() as $class ) {

   // make sure class is a shortcode
   if ( ! is_subclass_of( $class, 'CV_Shortcode' ) ) {
      continue;
   }

   // Create shortcode object
   $shortcode = new $class();

   // Add shortcode object to global canvys variable
   $canvys['shortcodes'][$shortcode->config['handle']] = $shortcode;

   // Activate the shortcode
   $shortcode->init();

}