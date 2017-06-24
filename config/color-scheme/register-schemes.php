<?php

global $canvys;

// Color Scheme Sections
$canvys['color_scheme_sections'] = array(
   'header'    => __( 'Header', 'canvys' ),
   'main'      => __( 'Main Content', 'canvys' ),
   'alternate' => __( 'Alternate Content', 'canvys' ),
   'footer'    => __( 'Footer', 'canvys' ),
   'socket'    => __( 'Socket', 'canvys' ),
);

$canvys['color_scheme_options'] = array(
   'primary_bg'        => __( 'Primary Background', 'canvys' ),
   'secondary_bg'      => __( 'Secondary Background', 'canvys' ),
   'borders'           => __( 'Borders', 'canvys' ),
   'headers'           => __( 'Headers', 'canvys' ),
   'content'           => __( 'Typography', 'canvys' ),
   'secondary_content' => __( 'Secondary Typography', 'canvys' ),
   'accent'            => __( 'Accent', 'canvys' ),
   'focused'           => __( 'Accent Focused', 'canvys' ),
);

$canvys['color_scheme_presets'] = array(

   'executive' => array(
      'name'   => __( 'Executive', 'canvys' ),
      'scheme' => array(
         'header' => array(
            'primary_bg'  => '#ffffff',  'secondary_bg'       => '#f9f9f9',
            'borders'     => '#d3d3d3',  'headers'            => '#222222',
            'content'     => '#777777',  'secondary_content'  => '#454545',
            'accent'      => '#0073A4',  'focused'            => '#008FBA',
         ),
         'main' => array(
            'primary_bg'  => '#f9f9f9',  'secondary_bg'       => '#ffffff',
            'borders'     => '#d6d6d6',  'headers'            => '#444444',
            'content'     => '#777777',  'secondary_content'  => '#757575',
            'accent'      => '#0073A4',  'focused'            => '#008FBA',
         ),
         'alternate' => array(
            'primary_bg'  => '#ffffff',  'secondary_bg'       => '#f9f9f9',
            'borders'     => '#d5d5d5',  'headers'            => '#444444',
            'content'     => '#888888',  'secondary_content'  => '#656565',
            'accent'      => '#0073A4',  'focused'            => '#008FBA',
         ),
         'footer' => array(
            'primary_bg'  => '#252525',  'secondary_bg'       => '#1e1e1e',
            'borders'     => '#444444',  'headers'            => '#dddddd',
            'content'     => '#888888',  'secondary_content'  => '#757575',
            'accent'      => '#bbbbbb',  'focused'            => '#dddddd',
         ),
         'socket' => array(
            'primary_bg'  => '#1c1c1c',  'secondary_bg'       => '#212121',
            'borders'     => '#474747',  'headers'            => '#a5a5a5',
            'content'     => '#777777',  'secondary_content'  => '#888888',
            'accent'      => '#858585',  'focused'            => '#dddddd',
         ),
      ),
   ),

   'ignition' => array(
      'name'   => __( 'Ignition', 'canvys' ),
      'scheme' => array(
         'header' => array(
            'primary_bg'  => '#ffffff',  'secondary_bg'       => '#f9f9f9',
            'borders'     => '#d3d3d3',  'headers'            => '#222222',
            'content'     => '#777777',  'secondary_content'  => '#454545',
            'accent'      => '#C21A01',  'focused'            => '#F03C02',
         ),
         'main' => array(
            'primary_bg'  => '#f9f9f9',  'secondary_bg'       => '#ffffff',
            'borders'     => '#d6d6d6',  'headers'            => '#444444',
            'content'     => '#777777',  'secondary_content'  => '#757575',
            'accent'      => '#C21A01',  'focused'            => '#F03C02',
         ),
         'alternate' => array(
            'primary_bg'  => '#ffffff',  'secondary_bg'       => '#f9f9f9',
            'borders'     => '#d5d5d5',  'headers'            => '#444444',
            'content'     => '#888888',  'secondary_content'  => '#656565',
            'accent'      => '#C21A01',  'focused'            => '#F03C02',
         ),
         'footer' => array(
            'primary_bg'  => '#252525',  'secondary_bg'       => '#1e1e1e',
            'borders'     => '#444444',  'headers'            => '#dddddd',
            'content'     => '#888888',  'secondary_content'  => '#757575',
            'accent'      => '#bbbbbb',  'focused'            => '#dddddd',
         ),
         'socket' => array(
            'primary_bg'  => '#1c1c1c',  'secondary_bg'       => '#212121',
            'borders'     => '#474747',  'headers'            => '#a5a5a5',
            'content'     => '#777777',  'secondary_content'  => '#888888',
            'accent'      => '#858585',  'focused'            => '#dddddd',
         ),
      ),
   ),

   'growth' => array(
      'name'   => __( 'Growth', 'canvys' ),
      'scheme' => array(
         'header' => array(
            'primary_bg'  => '#ffffff',  'secondary_bg'       => '#f9f9f9',
            'borders'     => '#d3d3d3',  'headers'            => '#171717',
            'content'     => '#666666',  'secondary_content'  => '#454545',
            'accent'      => '#789048',  'focused'            => '#607848',
         ),
         'main' => array(
            'primary_bg'  => '#ffffff',  'secondary_bg'       => '#f9f9f9',
            'borders'     => '#d5d5d5',  'headers'            => '#444444',
            'content'     => '#888888',  'secondary_content'  => '#656565',
            'accent'      => '#789048',  'focused'            => '#607848',
         ),
         'alternate' => array(
            'primary_bg'  => '#f9f9f9',  'secondary_bg'       => '#ffffff',
            'borders'     => '#d3d3d3',  'headers'            => '#171717',
            'content'     => '#656565',  'secondary_content'  => '#757575',
            'accent'      => '#789048',  'focused'            => '#607848',
         ),
         'footer' => array(
            'primary_bg'  => '#252525',  'secondary_bg'       => '#1e1e1e',
            'borders'     => '#444444',  'headers'            => '#dddddd',
            'content'     => '#888888',  'secondary_content'  => '#757575',
            'accent'      => '#bbbbbb',  'focused'            => '#dddddd',
         ),
         'socket' => array(
            'primary_bg'  => '#1c1c1c',  'secondary_bg'       => '#212121',
            'borders'     => '#474747',  'headers'            => '#a5a5a5',
            'content'     => '#777777',  'secondary_content'  => '#888888',
            'accent'      => '#858585',  'focused'            => '#dddddd',
         ),
      ),
   ),

   'salmon' => array(
      'name'   => __( 'Salmon', 'canvys' ),
      'scheme' => array(
         'header' => array(
            'primary_bg'  => '#ffffff',  'secondary_bg'       => '#f9f9f9',
            'borders'     => '#d3d3d3',  'headers'            => '#171717',
            'content'     => '#666666',  'secondary_content'  => '#454545',
            'accent'      => '#F35F55',  'focused'            => '#a2433c',
         ),
         'main' => array(
            'primary_bg'  => '#ffffff',  'secondary_bg'       => '#f9f9f9',
            'borders'     => '#d5d5d5',  'headers'            => '#444444',
            'content'     => '#888888',  'secondary_content'  => '#656565',
            'accent'      => '#F35F55',  'focused'            => '#a2433c',
         ),
         'alternate' => array(
            'primary_bg'  => '#f9f9f9',  'secondary_bg'       => '#ffffff',
            'borders'     => '#d3d3d3',  'headers'            => '#171717',
            'content'     => '#656565',  'secondary_content'  => '#757575',
            'accent'      => '#F35F55',  'focused'            => '#a2433c',
         ),
         'footer' => array(
            'primary_bg'  => '#252525',  'secondary_bg'       => '#1e1e1e',
            'borders'     => '#444444',  'headers'            => '#dddddd',
            'content'     => '#888888',  'secondary_content'  => '#757575',
            'accent'      => '#bbbbbb',  'focused'            => '#dddddd',
         ),
         'socket' => array(
            'primary_bg'  => '#1c1c1c',  'secondary_bg'       => '#212121',
            'borders'     => '#474747',  'headers'            => '#a5a5a5',
            'content'     => '#777777',  'secondary_content'  => '#888888',
            'accent'      => '#858585',  'focused'            => '#dddddd',
         ),
      ),
   ),

   'midnight' => array(
      'name'   => __( 'Midnight', 'canvys' ),
      'scheme' => array(
         'header' => array(
            'primary_bg'  => '#353535',  'secondary_bg'       => '#333333',
            'borders'     => '#555555',  'headers'            => '#ffffff',
            'content'     => '#b5b5b5',  'secondary_content'  => '#b5b5b5',
            'accent'      => '#f8bd3f',  'focused'            => '#ebcd8e',
         ),
         'main' => array(
            'primary_bg'  => '#353535',  'secondary_bg'       => '#2f2f2f',
            'borders'     => '#5d5d5d',  'headers'            => '#ffffff',
            'content'     => '#b5b5b5',  'secondary_content'  => '#b5b5b5',
            'accent'      => '#f8bd3f',  'focused'            => '#ebcd8e',
         ),
         'alternate' => array(
            'primary_bg'  => '#2c2c2c',  'secondary_bg'       => '#313131',
            'borders'     => '#5d5d5d',  'headers'            => '#ffffff',
            'content'     => '#b5b5b5',  'secondary_content'  => '#b5b5b5',
            'accent'      => '#f8bd3f',  'focused'            => '#ebcd8e',
         ),
         'footer' => array(
            'primary_bg'  => '#222222',  'secondary_bg'       => '#1d1d1d',
            'borders'     => '#353535',  'headers'            => '#dddddd',
            'content'     => '#757575',  'secondary_content'  => '#757575',
            'accent'      => '#999999',  'focused'            => '#ebcd8e',
         ),
         'socket' => array(
            'primary_bg'  => '#1e1e1e',  'secondary_bg'       => '#252525',
            'borders'     => '#444444',  'headers'            => '#dddddd',
            'content'     => '#656565',  'secondary_content'  => '#656565',
            'accent'      => '#757575',  'focused'            => '#dddddd',
         ),
      ),
   ),

   'modern_tech' => array(
      'name'   => __( 'Modern Tech', 'canvys' ),
      'scheme' => array(
         'header' => array(
            'primary_bg'  => '#f9f9f9',  'secondary_bg'       => '#ffffff',
            'borders'     => '#d6d6d6',  'headers'            => '#444444',
            'content'     => '#777777',  'secondary_content'  => '#757575',
            'accent'      => '#11a7d9',  'focused'            => '#057093',
         ),
         'main' => array(
            'primary_bg'  => '#ffffff',  'secondary_bg'       => '#f9f9f9',
            'borders'     => '#d3d3d3',  'headers'            => '#171717',
            'content'     => '#555555',  'secondary_content'  => '#454545',
            'accent'      => '#11a7d9',  'focused'            => '#057093',
         ),
         'alternate' => array(
            'primary_bg'  => '#252525',  'secondary_bg'       => '#1e1e1e',
            'borders'     => '#444444',  'headers'            => '#dddddd',
            'content'     => '#888888',  'secondary_content'  => '#757575',
            'accent'      => '#bbbbbb',  'focused'            => '#dddddd',
         ),
         'footer' => array(
            'primary_bg'  => '#f9f9f9',  'secondary_bg'       => '#f2f2f2',
            'borders'     => '#dddddd',  'headers'            => '#171717',
            'content'     => '#454545',  'secondary_content'  => '#555555',
            'accent'      => '#353535',  'focused'            => '#057093',
         ),
         'socket' => array(
            'primary_bg'  => '#252525',  'secondary_bg'       => '#1e1e1e',
            'borders'     => '#444444',  'headers'            => '#dddddd',
            'content'     => '#888888',  'secondary_content'  => '#757575',
            'accent'      => '#bbbbbb',  'focused'            => '#dddddd',
         ),
      ),
   ),

   'forest' => array(
      'name'   => __( 'Forest', 'canvys' ),
      'scheme' => array(
         'header' => array(
            'primary_bg'  => '#fbfbf8',  'secondary_bg'       => '#ffffff',
            'borders'     => '#e1d2c1',  'headers'            => '#5a3d31',
            'content'     => '#7c6059',  'secondary_content'  => '#5a3d31',
            'accent'      => '#99ab10',  'focused'            => '#606d02',
         ),
         'main' => array(
            'primary_bg'  => '#fbfbf8',  'secondary_bg'       => '#f7f5f2',
            'borders'     => '#e1d2c1',  'headers'            => '#5a3d31',
            'content'     => '#7c6059',  'secondary_content'  => '#5a3d31',
            'accent'      => '#99ab10',  'focused'            => '#606d02',
         ),
         'alternate' => array(
            'primary_bg'  => '#f0ebe4',  'secondary_bg'       => '#f7f5f2',
            'borders'     => '#d8cbb4',  'headers'            => '#5a3d31',
            'content'     => '#7c6059',  'secondary_content'  => '#5a3d31',
            'accent'      => '#99ab10',  'focused'            => '#606d02',
         ),
         'footer' => array(
            'primary_bg'  => '#3a352b',  'secondary_bg'       => '#40382a',
            'borders'     => '#544830',  'headers'            => '#f1ece8',
            'content'     => '#ab9b7c',  'secondary_content'  => '#beae8c',
            'accent'      => '#c6b289',  'focused'            => '#d5b97f',
         ),
         'socket' => array(
            'primary_bg'  => '#2e2a22',  'secondary_bg'       => '#372f24',
            'borders'     => '#4e442c',  'headers'            => '#f1ece8',
            'content'     => '#837352',  'secondary_content'  => '#b49e73',
            'accent'      => '#b59d72',  'focused'            => '#d5b97f',
         ),
      ),
   ),

   'beach_day' => array(
      'name'   => __( 'Beach Day', 'canvys' ),
      'scheme' => array(
         'header' => array(
            'primary_bg'  => '#ffffff',  'secondary_bg'       => '#f8f7f6',
            'borders'     => '#d7d1b0',  'headers'            => '#626f68',
            'content'     => '#606e67',  'secondary_content'  => '#606e67',
            'accent'      => '#288b9a',  'focused'            => '#cc5419',
         ),
         'main' => array(
            'primary_bg'  => '#f8f8f5',  'secondary_bg'       => '#f2f2ec',
            'borders'     => '#d7d7cb',  'headers'            => '#3f4944',
            'content'     => '#3f4944',  'secondary_content'  => '#3f4944',
            'accent'      => '#237986',  'focused'            => '#cc5419',
         ),
         'alternate' => array(
            'primary_bg'  => '#f0f0e9',  'secondary_bg'       => '#f5f5f3',
            'borders'     => '#c9c9b9',  'headers'            => '#3f4944',
            'content'     => '#3f4944',  'secondary_content'  => '#3f4944',
            'accent'      => '#237986',  'focused'            => '#cc5419',
         ),
         'footer' => array(
            'primary_bg'  => '#3f4944',  'secondary_bg'       => '#3b443f',
            'borders'     => '#595e5a',  'headers'            => '#e7e7e3',
            'content'     => '#88887b',  'secondary_content'  => '#bfbeb2',
            'accent'      => '#bfbeb2',  'focused'            => '#e7e7e3',
         ),
         'socket' => array(
            'primary_bg'  => '#363e3a',  'secondary_bg'       => '#3b4440',
            'borders'     => '#4d5a52',  'headers'            => '#ffffff',
            'content'     => '#78786d',  'secondary_content'  => '#aba99a',
            'accent'      => '#bfbeb2',  'focused'            => '#e7e7e3',
         ),
      ),
   ),

   'wanderlust' => array(
      'name'   => __( 'Wanderlust', 'canvys' ),
      'scheme' => array(
         'header' => array(
            'primary_bg'  => '#ffffff',  'secondary_bg'       => '#f9f9f9',
            'borders'     => '#d3d3d3',  'headers'            => '#555555',
            'content'     => '#757575',  'secondary_content'  => '#656565',
            'accent'      => '#e59a61',  'focused'            => '#df843e',
         ),
         'main' => array(
            'primary_bg'  => '#ffffff',  'secondary_bg'       => '#f9f9f9',
            'borders'     => '#d3d3d3',  'headers'            => '#555555',
            'content'     => '#757575',  'secondary_content'  => '#656565',
            'accent'      => '#e59a61',  'focused'            => '#df843e',
         ),
         'alternate' => array(
            'primary_bg'  => '#f9f9f9',  'secondary_bg'       => '#ffffff',
            'borders'     => '#d3d3d3',  'headers'            => '#555555',
            'content'     => '#757575',  'secondary_content'  => '#656565',
            'accent'      => '#e59a61',  'focused'            => '#df843e',
         ),
         'footer' => array(
            'primary_bg'  => '#565656',  'secondary_bg'       => '#555555',
            'borders'     => '#686868',  'headers'            => '#dddddd',
            'content'     => '#999999',  'secondary_content'  => '#999999',
            'accent'      => '#c4c4c4',  'focused'            => '#dddddd',
         ),
         'socket' => array(
            'primary_bg'  => '#393939',  'secondary_bg'       => '#323232',
            'borders'     => '#454545',  'headers'            => '#bcbcbc',
            'content'     => '#777777',  'secondary_content'  => '#888888',
            'accent'      => '#858585',  'focused'            => '#dddddd',
         ),
      ),
   ),

   'maple' => array(
      'name'   => __( 'Maple', 'canvys' ),
      'scheme' => array(
         'header' => array(
            'primary_bg'  => '#fbfbf8',  'secondary_bg'       => '#ffffff',
            'borders'     => '#e1d2c1',  'headers'            => '#5a3d31',
            'content'     => '#7c6059',  'secondary_content'  => '#5a3d31',
            'accent'      => '#901F0F',  'focused'            => '#4E291E',
         ),
         'main' => array(
            'primary_bg'  => '#fbfbf8',  'secondary_bg'       => '#f7f5f2',
            'borders'     => '#e1d2c1',  'headers'            => '#5a3d31',
            'content'     => '#7c6059',  'secondary_content'  => '#5a3d31',
            'accent'      => '#901F0F',  'focused'            => '#4E291E',
         ),
         'alternate' => array(
            'primary_bg'  => '#f0ebe4',  'secondary_bg'       => '#f7f5f2',
            'borders'     => '#d8cbb4',  'headers'            => '#5a3d31',
            'content'     => '#7c6059',  'secondary_content'  => '#5a3d31',
            'accent'      => '#901F0F',  'focused'            => '#4E291E',
         ),
         'footer' => array(
            'primary_bg'  => '#3a352b',  'secondary_bg'       => '#40382a',
            'borders'     => '#544830',  'headers'            => '#f1ece8',
            'content'     => '#ab9b7c',  'secondary_content'  => '#beae8c',
            'accent'      => '#c6b289',  'focused'            => '#d5b97f',
         ),
         'socket' => array(
            'primary_bg'  => '#2e2a22',  'secondary_bg'       => '#372f24',
            'borders'     => '#4e442c',  'headers'            => '#f1ece8',
            'content'     => '#837352',  'secondary_content'  => '#b49e73',
            'accent'      => '#b59d72',  'focused'            => '#d5b97f',
         ),
      ),
   ),

   'violet' => array(
      'name'   => __( 'Violet', 'canvys' ),
      'scheme' => array(
         'header' => array(
            'primary_bg'  => '#ffffff',  'secondary_bg'       => '#f9f9f9',
            'borders'     => '#d3d3d3',  'headers'            => '#222222',
            'content'     => '#777777',  'secondary_content'  => '#454545',
            'accent'      => '#7343AE',  'focused'            => '#241A63',
         ),
         'main' => array(
            'primary_bg'  => '#f9f9f9',  'secondary_bg'       => '#ffffff',
            'borders'     => '#d6d6d6',  'headers'            => '#444444',
            'content'     => '#777777',  'secondary_content'  => '#757575',
            'accent'      => '#7343AE',  'focused'            => '#241A63',
         ),
         'alternate' => array(
            'primary_bg'  => '#ffffff',  'secondary_bg'       => '#f9f9f9',
            'borders'     => '#d5d5d5',  'headers'            => '#444444',
            'content'     => '#888888',  'secondary_content'  => '#656565',
            'accent'      => '#7343AE',  'focused'            => '#241A63',
         ),
         'footer' => array(
            'primary_bg'  => '#252525',  'secondary_bg'       => '#1e1e1e',
            'borders'     => '#444444',  'headers'            => '#dddddd',
            'content'     => '#888888',  'secondary_content'  => '#757575',
            'accent'      => '#bbbbbb',  'focused'            => '#dddddd',
         ),
         'socket' => array(
            'primary_bg'  => '#1c1c1c',  'secondary_bg'       => '#212121',
            'borders'     => '#474747',  'headers'            => '#a5a5a5',
            'content'     => '#777777',  'secondary_content'  => '#888888',
            'accent'      => '#858585',  'focused'            => '#dddddd',
         ),
      ),
   ),

   'viper' => array(
      'name'   => __( 'Viper', 'canvys' ),
      'scheme' => array(
         'header' => array(
            'primary_bg'  => '#ffffff',  'secondary_bg'       => '#f9f9f9',
            'borders'     => '#d3d3d3',  'headers'            => '#222222',
            'content'     => '#777777',  'secondary_content'  => '#454545',
            'accent'      => '#7AB317',  'focused'            => '#669415',
         ),
         'main' => array(
            'primary_bg'  => '#f9f9f9',  'secondary_bg'       => '#ffffff',
            'borders'     => '#d6d6d6',  'headers'            => '#444444',
            'content'     => '#777777',  'secondary_content'  => '#757575',
            'accent'      => '#7AB317',  'focused'            => '#669415',
         ),
         'alternate' => array(
            'primary_bg'  => '#ffffff',  'secondary_bg'       => '#f9f9f9',
            'borders'     => '#d5d5d5',  'headers'            => '#444444',
            'content'     => '#888888',  'secondary_content'  => '#656565',
            'accent'      => '#7AB317',  'focused'            => '#669415',
         ),
         'footer' => array(
            'primary_bg'  => '#2e372e',  'secondary_bg'       => '#2a312a',
            'borders'     => '#3e4b3e',  'headers'            => '#e0e5e0',
            'content'     => '#acb3ac',  'secondary_content'  => '#b4bab4',
            'accent'      => '#a5c4a5',  'focused'            => '#95d495',
         ),
         'socket' => array(
            'primary_bg'  => '#222922',  'secondary_bg'       => '#202620',
            'borders'     => '#333d33',  'headers'            => '#c3cac3',
            'content'     => '#627362',  'secondary_content'  => '#677967',
            'accent'      => '#768376',  'focused'            => '#b7ccb7',
         ),
      ),
   ),

   'the_agency' => array(
      'name'   => __( 'The Agency', 'canvys' ),
      'scheme' => array(
         'header' => array(
            'primary_bg'  => '#ffffff',  'secondary_bg'       => '#f9f9f9',
            'borders'     => '#dddddd',  'headers'            => '#222222',
            'content'     => '#777777',  'secondary_content'  => '#727272',
            'accent'      => '#e0222f',  'focused'            => '#9f040e',
         ),
         'main' => array(
            'primary_bg'  => '#ffffff',  'secondary_bg'       => '#f9f9f9',
            'borders'     => '#dddddd',  'headers'            => '#222222',
            'content'     => '#3f3f3f',  'secondary_content'  => '#2b2b2b',
            'accent'      => '#e0222f',  'focused'            => '#9f040e',
         ),
         'alternate' => array(
            'primary_bg'  => '#e0222f',  'secondary_bg'       => '#d21c28',
            'borders'     => '#e87c83',  'headers'            => '#ffffff',
            'content'     => '#f7d3d9',  'secondary_content'  => '#f8c3c8',
            'accent'      => '#fae4e6',  'focused'            => '#ffffff',
         ),
         'footer' => array(
            'primary_bg'  => '#252525',  'secondary_bg'       => '#222222',
            'borders'     => '#383838',  'headers'            => '#c1c1c1',
            'content'     => '#666666',  'secondary_content'  => '#777777',
            'accent'      => '#848484',  'focused'            => '#b5b5b5',
         ),
         'socket' => array(
            'primary_bg'  => '#1c1c1c',  'secondary_bg'       => '#212121',
            'borders'     => '#474747',  'headers'            => '#a5a5a5',
            'content'     => '#5b5b5b',  'secondary_content'  => '#777777',
            'accent'      => '#707070',  'focused'            => '#b7b7b7',
         ),
      ),
   ),

   'gold_flake' => array(
      'name'   => __( 'Gold Flake', 'canvys' ),
      'scheme' => array(
         'header' => array(
            'primary_bg'  => '#ffffff',  'secondary_bg'       => '#f8f8f5',
            'borders'     => '#e6e6d9',  'headers'            => '#8c8680',
            'content'     => '#8c8680',  'secondary_content'  => '#878177',
            'accent'      => '#d6b221',  'focused'            => '#e2b608',
         ),
         'main' => array(
            'primary_bg'  => '#ffffff',  'secondary_bg'       => '#f8f8f5',
            'borders'     => '#e6e6d9',  'headers'            => '#4b463d',
            'content'     => '#706a65',  'secondary_content'  => '#6f6961',
            'accent'      => '#d6b221',  'focused'            => '#e2b608',
         ),
         'alternate' => array(
            'primary_bg'  => '#f4f3ef',  'secondary_bg'       => '#fafaf9',
            'borders'     => '#dddace',  'headers'            => '#4b463d',
            'content'     => '#78726d',  'secondary_content'  => '#78736d',
            'accent'      => '#d6b221',  'focused'            => '#e2b608',
         ),
         'footer' => array(
            'primary_bg'  => '#67605a',  'secondary_bg'       => '#605852',
            'borders'     => '#978c80',  'headers'            => '#ebeae9',
            'content'     => '#c0bdb9',  'secondary_content'  => '#c7c5c0',
            'accent'      => '#e7e5e3',  'focused'            => '#e6d388',
         ),
         'socket' => array(
            'primary_bg'  => '#544b44',  'secondary_bg'       => '#4c423d',
            'borders'     => '#675d54',  'headers'            => '#b4aca6',
            'content'     => '#867a6e',  'secondary_content'  => '#928271',
            'accent'      => '#9b9082',  'focused'            => '#e6d388',
         ),
      ),
   ),

   'patternina' => array(
      'name'   => __( 'Patternina', 'canvys' ),
      'scheme' => array(
         'header' => array(
            'primary_bg'  => '#edf7f5',  'secondary_bg'       => '#f8fbfa',
            'borders'     => '#bae2d7',  'headers'            => '#325356',
            'content'     => '#34837e',  'secondary_content'  => '#3d968f',
            'accent'      => '#a64e5e',  'focused'            => '#7f3950',
         ),
         'main' => array(
            'primary_bg'  => '#edf7f5',  'secondary_bg'       => '#f8fbfa',
            'borders'     => '#bae2d7',  'headers'            => '#325356',
            'content'     => '#34837e',  'secondary_content'  => '#3d968f',
            'accent'      => '#a64e5e',  'focused'            => '#7f3950',
         ),
         'alternate' => array(
            'primary_bg'  => '#faeaea',  'secondary_bg'       => '#fcf2f2',
            'borders'     => '#f0c1c1',  'headers'            => '#bb4343',
            'content'     => '#d27c74',  'secondary_content'  => '#c44f44',
            'accent'      => '#be2927',  'focused'            => '#7f2b2b',
         ),
         'footer' => array(
            'primary_bg'  => '#592730',  'secondary_bg'       => '#66242f',
            'borders'     => '#89303f',  'headers'            => '#ffffff',
            'content'     => '#c9959c',  'secondary_content'  => '#f7e1e9',
            'accent'      => '#edbdc1',  'focused'            => '#ffffff',
         ),
         'socket' => array(
            'primary_bg'  => '#491e25',  'secondary_bg'       => '#56212b',
            'borders'     => '#703d47',  'headers'            => '#ffffff',
            'content'     => '#c9959c',  'secondary_content'  => '#c9959c',
            'accent'      => '#f9cdc7',  'focused'            => '#ffffff',
         ),
      ),
   ),

   'coffee_shop' => array(
      'name'   => __( 'Coffee Shop', 'canvys' ),
      'scheme' => array(
         'header' => array(
            'primary_bg'  => '#fbfbf8',  'secondary_bg'       => '#f7f1ed',
            'borders'     => '#d7c3ac',  'headers'            => '#5a3d31',
            'content'     => '#7c6059',  'secondary_content'  => '#5a3d31',
            'accent'      => '#197a1b',  'focused'            => '#07a50a',
         ),
         'main' => array(
            'primary_bg'  => '#fbfbf8',  'secondary_bg'       => '#ffffff',
            'borders'     => '#d7c3ac',  'headers'            => '#5a3d31',
            'content'     => '#7c6059',  'secondary_content'  => '#5a3d31',
            'accent'      => '#197a1b',  'focused'            => '#07a50a',
         ),
         'alternate' => array(
            'primary_bg'  => '#f0ebe4',  'secondary_bg'       => '#f7f5f2',
            'borders'     => '#d8cbb4',  'headers'            => '#5a3d31',
            'content'     => '#7c6059',  'secondary_content'  => '#5a3d31',
            'accent'      => '#197a1b',  'focused'            => '#07a50a',
         ),
         'footer' => array(
            'primary_bg'  => '#421313',  'secondary_bg'       => '#3a1111',
            'borders'     => '#623636',  'headers'            => '#dfcccc',
            'content'     => '#c79d9d',  'secondary_content'  => '#ceaaaa',
            'accent'      => '#d9c3c3',  'focused'            => '#e9e1e1',
         ),
         'socket' => array(
            'primary_bg'  => '#371010',  'secondary_bg'       => '#4b1515',
            'borders'     => '#583030',  'headers'            => '#d6c1c1',
            'content'     => '#a36f6f',  'secondary_content'  => '#b68f8f',
            'accent'      => '#b38888',  'focused'            => '#d6c6c6',
         ),
      ),
   ),

   'roses_are_pink' => array(
      'name'   => __( 'Roses Are Pink', 'canvys' ),
      'scheme' => array(
         'header' => array(
            'primary_bg'  => '#ffffff',  'secondary_bg'       => '#fff4f4',
            'borders'     => '#e2c4b5',  'headers'            => '#502815',
            'content'     => '#713b22',  'secondary_content'  => '#66341d',
            'accent'      => '#de7779',  'focused'            => '#b75b5d',
         ),
         'main' => array(
            'primary_bg'  => '#ffffff',  'secondary_bg'       => '#fff4f4',
            'borders'     => '#e2c4b5',  'headers'            => '#60301a',
            'content'     => '#713b22',  'secondary_content'  => '#66341d',
            'accent'      => '#de7779',  'focused'            => '#b75b5d',
         ),
         'alternate' => array(
            'primary_bg'  => '#ffe0e0',  'secondary_bg'       => '#ffeaea',
            'borders'     => '#fea9a9',  'headers'            => '#a14848',
            'content'     => '#bd6a6a',  'secondary_content'  => '#b55353',
            'accent'      => '#a43b3b',  'focused'            => '#7d2020',
         ),
         'footer' => array(
            'primary_bg'  => '#df7678',  'secondary_bg'       => '#e07f81',
            'borders'     => '#e7a6a8',  'headers'            => '#f9e6e6',
            'content'     => '#eec3c4',  'secondary_content'  => '#f2d3d4',
            'accent'      => '#f3d7d8',  'focused'            => '#f9e6ec',
         ),
         'socket' => array(
            'primary_bg'  => '#d85e60',  'secondary_bg'       => '#da6c6d',
            'borders'     => '#de8687',  'headers'            => '#f2cece',
            'content'     => '#e5adb0',  'secondary_content'  => '#efd1d3',
            'accent'      => '#f3d7d8',  'focused'            => '#faeff0',
         ),
      ),
   ),

   'vineyard' => array(
      'name'   => __( 'Vineyard', 'canvys' ),
      'scheme' => array(
         'header' => array(
            'primary_bg'  => '#ffffff',  'secondary_bg'       => '#f9f9f9',
            'borders'     => '#d3d3d3',  'headers'            => '#555555',
            'content'     => '#757575',  'secondary_content'  => '#656565',
            'accent'      => '#be5472',  'focused'            => '#962b49',
         ),
         'main' => array(
            'primary_bg'  => '#ffffff',  'secondary_bg'       => '#f9f9f9',
            'borders'     => '#d3d3d3',  'headers'            => '#555555',
            'content'     => '#757575',  'secondary_content'  => '#656565',
            'accent'      => '#be5472',  'focused'            => '#962b49',
         ),
         'alternate' => array(
            'primary_bg'  => '#be5472',  'secondary_bg'       => '#c2607b',
            'borders'     => '#cc899b',  'headers'            => '#f3e7ea',
            'content'     => '#daaebb',  'secondary_content'  => '#e6cad3',
            'accent'      => '#e9d7db',  'focused'            => '#faf4f5',
         ),
         'footer' => array(
            'primary_bg'  => '#565656',  'secondary_bg'       => '#555555',
            'borders'     => '#686868',  'headers'            => '#dddddd',
            'content'     => '#999999',  'secondary_content'  => '#999999',
            'accent'      => '#c4c4c4',  'focused'            => '#dddddd',
         ),
         'socket' => array(
            'primary_bg'  => '#393939',  'secondary_bg'       => '#323232',
            'borders'     => '#454545',  'headers'            => '#bcbcbc',
            'content'     => '#777777',  'secondary_content'  => '#888888',
            'accent'      => '#858585',  'focused'            => '#dddddd',
         ),
      ),
   ),

   'tuxedo' => array(
      'name'   => __( 'Tuxedo', 'canvys' ),
      'scheme' => array(
         'header' => array(
            'primary_bg'  => '#ffffff',  'secondary_bg'       => '#f9f9f9',
            'borders'     => '#d3d3d3',  'headers'            => '#171717',
            'content'     => '#555555',  'secondary_content'  => '#454545',
            'accent'      => '#555555',  'focused'            => '#777777',
         ),
         'main' => array(
            'primary_bg'  => '#ffffff',  'secondary_bg'       => '#f9f9f9',
            'borders'     => '#d3d3d3',  'headers'            => '#000000',
            'content'     => '#222222',  'secondary_content'  => '#333333',
            'accent'      => '#555555',  'focused'            => '#777777',
         ),
         'alternate' => array(
            'primary_bg'  => '#f9f9f9',  'secondary_bg'       => '#ffffff',
            'borders'     => '#d3d3d3',  'headers'            => '#000000',
            'content'     => '#222222',  'secondary_content'  => '#333333',
            'accent'      => '#555555',  'focused'            => '#777777',
         ),
         'footer' => array(
            'primary_bg'  => '#252525',  'secondary_bg'       => '#1e1e1e',
            'borders'     => '#444444',  'headers'            => '#cccccc',
            'content'     => '#777777',  'secondary_content'  => '#757575',
            'accent'      => '#bbbbbb',  'focused'            => '#dddddd',
         ),
         'socket' => array(
            'primary_bg'  => '#1c1c1c',  'secondary_bg'       => '#212121',
            'borders'     => '#474747',  'headers'            => '#a5a5a5',
            'content'     => '#777777',  'secondary_content'  => '#888888',
            'accent'      => '#858585',  'focused'            => '#dddddd',
         ),
      ),
   ),

   'shift' => array(
      'name'   => __( 'Shift', 'canvys' ),
      'scheme' => array(
         'header' => array(
            'primary_bg'  => '#393939',  'secondary_bg'       => '#323232',
            'borders'     => '#4f4f4f',  'headers'            => '#ffffff',
            'content'     => '#9e9e9e',  'secondary_content'  => '#a8a8a8',
            'accent'      => '#f3843e',  'focused'            => '#21cdec',
         ),
         'main' => array(
            'primary_bg'  => '#393939',  'secondary_bg'       => '#323232',
            'borders'     => '#4f4f4f',  'headers'            => '#ffffff',
            'content'     => '#9e9e9e',  'secondary_content'  => '#a8a8a8',
            'accent'      => '#f3843e',  'focused'            => '#21cdec',
         ),
         'alternate' => array(
            'primary_bg'  => '#f78f4e',  'secondary_bg'       => '#f79559',
            'borders'     => '#c5520b',  'headers'            => '#7b3103',
            'content'     => '#aa4608',  'secondary_content'  => '#a14206',
            'accent'      => '#a34105',  'focused'            => '#6d2b02',
         ),
         'footer' => array(
            'primary_bg'  => '#232323',  'secondary_bg'       => '#212121',
            'borders'     => '#383838',  'headers'            => '#ffffff',
            'content'     => '#686868',  'secondary_content'  => '#7f7f7f',
            'accent'      => '#b7b7b7',  'focused'            => '#21cdec',
         ),
         'socket' => array(
            'primary_bg'  => '#1e1e1e',  'secondary_bg'       => '#232323',
            'borders'     => '#3a3a3a',  'headers'            => '#dbdbdb',
            'content'     => '#5b5b5b',  'secondary_content'  => '#777777',
            'accent'      => '#848484',  'focused'            => '#d3d3d3',
         ),
      ),
   ),

);