<?php

global $canvys;

// Calculate the layout / number of columns
 switch ( cv_theme_setting( 'footer', 'layout', '13' ) ) {
   case '16': $layout = '6'; $num_columns = 6; break;
   case '15': $layout = '5'; $num_columns = 5; break;
   case '14': $layout = '4'; $num_columns = 4; break;
   case '13': $layout = '3'; $num_columns = 3; break;
   case '12': $layout = '2'; $num_columns = 2; break;
   case 'single': $layout = false; $num_columns = 1; break;
   default:
      $layout = cv_theme_setting( 'footer', 'layout' );
      $num_columns = explode( '-', $layout );
      $num_columns = count( $num_columns );
}

// Display the columns
if ( $layout ) {
   echo '<div class="cv-column-row cv-split-' . $layout . ' spacing-2 has-clearfix">';
}
for ( $i=1; $i<=$num_columns; $i++ ) {
   echo '<div class="sidebar footer-column footer-column' . $i . '">';
   dynamic_sidebar( "footer_column_{$i}" );
   echo '</div>';
}
if ( $layout ) {
   echo '</div>';
}