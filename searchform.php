<form action="<?php echo home_url( '/' ); ?>" id="searchform" method="get">
   <div class="search-form">
      <input type="text" id="search" name="s" value="" placeholder="<?php echo CV_WIDGET_SEARCH_PLACEHOLDER; ?>" />
      <input type="submit" id="search_submit" value="<?php _e( 'Search', 'canvys' ); ?>" />
   </div>
</form>