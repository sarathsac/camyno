<?php

global $canvys;

/* Supported post formats */
$canvys['supported_post_formats'] = array(
   'aside'   => __( 'Aside', 'canvys' ),
   'audio'   => __( 'Audio', 'canvys' ),
   'chat'    => __( 'Chat', 'canvys' ),
   'gallery' => __( 'Gallery', 'canvys' ),
   'image'   => __( 'Image', 'canvys' ),
   'link'    => __( 'Link', 'canvys' ),
   'quote'   => __( 'Quote', 'canvys' ),
   'video'   => __( 'Video', 'canvys' )
);

/* Supported social media profiles */
$canvys['social_outlets'] = array(
   'flickr' => 'Flickr',
   'youtube' => 'YouTube',
   'vimeo' => 'Vimeo',
   'twitter' => 'Twitter',
   'facebook' => 'Facebook',
   'gplus' => 'Google +',
   'pinterest' => 'Pinterest',
   'tumblr' => 'Tumblr',
   'linkedin' => 'LinkedIn',
   'dribbble' => 'Dribbble',
   'github' => 'GitHub',
   'lastfm' => 'Lastfm',
   'instagram' => 'Instagram',
   'flattr' => 'Flattr',
   'renren' => 'Renren',
   'sina-weibo' => 'Weibo',
   'soundcloud' => 'Soundcloud',
   'mixi' => 'Mixi',
   'behance' => 'Behance',
   'vkontakte' => 'VK',
);

/* Supported social media share buttons */
$canvys['share_buttons'] = array(
   'twitter' => 'Twitter',
   'facebook' => 'Facebook',
   'google' => 'Google',
   'linkedin' => 'LinkedIn',
   'pinterest' => 'Pinterest',
   'tumblr' => 'Tumblr',
);

/* Column Layouts */
$canvys['column_layouts'] = array(
   '1/2'         => '1/2 - 1/2',
   '1/3+2/3'     => '1/3 - 2/3',
   '2/3+1/3'     => '2/3 - 1/3',
   '2/5+3/5'     => '2/5 - 3/5',
   '3/5+2/5'     => '3/5 - 2/5',
   '3/4+1/4'     => '3/4 - 1/4',
   '1/4+3/4'     => '1/4 - 3/4',
   '1/3'         => '1/3 - 1/3 - 1/3',
   '1/2+1/4+1/4' => '1/2 - 1/4 - 1/4',
   '1/4+1/2+1/4' => '1/4 - 1/2 - 1/4',
   '1/4+1/4+1/2' => '1/4 - 1/4 - 1/2',
   '1/4'         => '1/4 - 1/4 - 1/4 - 1/4',
   '1/5'         => '1/5 - 1/5 - 1/5 - 1/5 - 1/5',
   '1/6'         => '1/6 - 1/6 - 1/6 - 1/6 - 1/6 - 1/6',
);

/* Device Size Visibility */
$canvys['visibility_options'] = array(
   'all'            => __( 'All Devices', 'canvys' ),
   'mobile'         => __( 'Mobile Only', 'canvys' ),
   'tablet'         => __( 'Tablet Only', 'canvys' ),
   'desktop'        => __( 'Desktop Only', 'canvys' ),
   'mobile-tablet'  => __( 'Mobile & Tablet Only', 'canvys' ),
   'tablet-desktop' => __( 'Tablet & Desktop Only', 'canvys' ),
);

/* Background Patterns */
$canvys['bg_patterns'] = array(
   'green_cup'              => __( 'Green Pond', 'canvys' ),
   'congruent_pentagon'     => __( 'Turtle Shell', 'canvys' ),
   'food'                   => __( 'Charismatic', 'canvys' ),
   'exclusive_paper'        => __( 'Exclusive Paper', 'canvys' ),
   'old_map'                => __( 'Old Map', 'canvys' ),
   'ricepaper_v3'           => __( 'Rice Paper', 'canvys' ),
   'fresh_snow'             => __( 'Fresh Snow', 'canvys' ),
   'subtle_white_feathers'  => __( 'Feathers', 'canvys' ),
   'gplaypattern'           => __( 'Mosaic', 'canvys' ),
   'grunge_wall'            => __( 'Grunge Wall', 'canvys' ),
   'mochaGrunge'            => __( 'Mocha Grunge', 'canvys' ),
   'tree_bark'              => __( 'Tree Bark', 'canvys' ),
   'whitediamond'           => __( 'White Diamond', 'canvys' ),
   'wood_pattern'           => __( 'Wood Pattern', 'canvys' ),
   'xv'                     => __( 'Olive Branch', 'canvys' ),
   'noisy_grid'             => __( 'Noisy Grid', 'canvys' ),
   'notebook'               => __( 'Notebook', 'canvys' ),
   'shattered'              => __( 'Shattered', 'canvys' ),
   'triangular'             => __( 'Triangular', 'canvys' ),
   'wild_oliva'             => __( 'Wild Oliva', 'canvys' ),
   'congruent_outline'      => __( 'Dark Turtle', 'canvys' ),
   'stardust'               => __( 'Stardust', 'canvys' ),
   'hixs_pattern_evolution' => __( 'Evolution', 'canvys' ),
   'type'                   => __( 'Typography', 'canvys' ),
   'grey_wash_wall'         => __( 'Grey Wall', 'canvys' ),
);

/* Background Repeat Options */
$canvys['bg_repeat_options'] = array(
   'repeat'    => __( 'Repeat All', 'canvys' ),
   'repeat-x'  => __( 'Repeat Horizontally', 'canvys' ),
   'repeat-y'  => __( 'Repeat Veritcally', 'canvys' ),
   'no-repeat' => __( 'No Repeat', 'canvys' ),
);

/* Background Position Options */
$canvys['bg_position_options'] = array(
   'left top'      => __( 'Left Top', 'canvys' ),
   'left center'   => __( 'Left Center', 'canvys' ),
   'left bottom'   => __( 'Left Bottom', 'canvys' ),
   'right top'     => __( 'Right Top', 'canvys' ),
   'right center'  => __( 'Right Center', 'canvys' ),
   'right bottom'  => __( 'Right Bottom', 'canvys' ),
   'center top'    => __( 'Center Top', 'canvys' ),
   'center center' => __( 'Center Center', 'canvys' ),
   'center bottom' => __( 'Center Bottom', 'canvys' ),
);