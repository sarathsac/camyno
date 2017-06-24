<?php

if ( ! class_exists('CV_Post_Format_Settings') ) :

/**
 * Post Formats Meta Controller
 * used to allow users to easily edit post formats appropriately
 *
 * @package    WordPress
 * @subpackage Canvys
 * @since      Version 1.0
 */
class CV_Post_Format_Settings {

   /**
    * Initially load the formats controller
    *
    * @return void
    */
   public function __construct() {

      // Load initial actions
      add_action( 'load-post.php',     array( $this, 'admin_init' ) );
      add_action( 'load-post-new.php', array( $this, 'admin_init' ) );

      // Array containing each AJAX action
      $actions = array(
         'render_format_gallery',
      );

      // register each AJAX action
      foreach ( $actions as $action ) {
         add_action('wp_ajax_' . 'cv_ajax_' . $action, array( $this, $action . '_callback' ) );
         add_action('wp_ajax_nopriv_' . 'cv_ajax_' . $action, array( $this, $action . '_callback' ) );
      }

   }

   /**
    * Called on admin post pages
    *
    * @return void
    */
   public function admin_init() {

      // Grab current screen
      $screen = get_current_screen();

      // Make sure we're on the correct screen
      if ( $screen->id != 'post' ) {
         return;
      }

      $this->add_actions();
      $this->load_assets();

   }

   /**
    * Apply various required actions
    *
    * @return void
    */
   public function add_actions() {

      // Insert the settings HTML template
      add_action( 'admin_footer', array( $this, 'render_template' ) );

      // Add the function to update our meta boxes
      add_action('save_post', array( $this, 'update' ) );

   }

   /**
    * Loads required CSS & JavaScript files
    *
    * @return void
    */
   public function load_assets() {

      global $canvys;

      // Admin assets directory
      $dir = THEME_DIR . 'config/post-formats/assets/';

      // Load formats settings Stylesheet file
      wp_enqueue_style( 'cv-format-setings', $dir . 'format-settings.css' );

      // Load formats settings JS file
      wp_enqueue_script( 'cv-format-setings', $dir . 'compressed/jquery.format-settings.min.js' );
      wp_localize_script( 'cv-format-setings', 'cv_formats_meta_localize', $canvys['post_formats_meta_localization'] );

   }

   /**
    * Displays the meta box on the edit screen
    *
    * @return void
    */
   public function render_template() {

      // grab the current post ID
      $post_id = get_the_ID();

      // Get the current values
      $values = get_post_meta( $post_id, '_cv_format_meta', true );

      // Audio Format Meta
      $audio['mp3'] = isset( $values['audio']['mp3'] ) ? $values['audio']['mp3'] : null;
      $audio['ogg'] = isset( $values['audio']['ogg'] ) ? $values['audio']['ogg'] : null;

      // Gallery format meta
      $gallery['ids'] = isset( $values['gallery']['ids'] ) ? $values['gallery']['ids'] : null;

      // Link Format Meta
      $link['url'] = isset( $values['link']['url'] ) ? $values['link']['url'] : null;

      // Video Format Meta
      $video['source'] = isset( $values['video']['source'] ) ? $values['video']['source'] : 'hosted';
      $video['mp4']    = isset( $values['video']['mp4'] ) ? $values['video']['mp4'] : null;
      $video['ogv']    = isset( $values['video']['ogv'] ) ? $values['video']['ogv'] : null;
      $video['poster'] = isset( $values['video']['poster'] ) ? $values['video']['poster'] : null;
      $video['embed']  = isset( $values['video']['embed'] ) ? $values['video']['embed'] : null; ?>

      <script id="cv-tmpl-format-settings">

         <div id="cv-post-format-meta" class="cv-post-format-meta">

            <!-- Audio Format Meta -->
            <div class="cv-post-format-meta-pane" data-format="audio">

               <p><label for="cv-audio-format-mp3"><strong><?php _e( 'MP3 File URL', 'canvys' ); ?></strong></label></p>
               <p>
                  <input type="text" id="cv-audio-format-mp3" name="_cv_format_meta[audio][mp3]" class="widefat cv-file-input code" value="<?php echo $audio['mp3']; ?>" />
               </p>
               <p>
                  <a class="button cv-select-file" data-type="audio" data-sync="cv-audio-format-mp3"><?php _e( 'Select File', 'canvys' ); ?></a>
                  <a class="button cv-remove-file" data-sync="cv-audio-format-mp3"><?php _e( 'Remove File', 'canvys' ); ?></a>
               </p>
               <p class="description"><?php _e( 'Enter a full .mp3 URL here. You must include both file types for full browser support.', 'canvys' ); ?></p>

               <p><label for="cv-audio-format-oga"><strong><?php _e( 'OGG File URL', 'canvys' ); ?></strong></label></p>
               <p>
                  <input type="text" id="cv-audio-format-ogg" name="_cv_format_meta[audio][ogg]" class="widefat cv-file-input code" value="<?php echo $audio['ogg']; ?>" />
               </p>
               <p>
                  <a class="button cv-select-file" data-type="audio" data-sync="cv-audio-format-ogg"><?php _e( 'Select File', 'canvys' ); ?></a>
                  <a class="button cv-remove-file" data-sync="cv-audio-format-ogg"><?php _e( 'Remove File', 'canvys' ); ?></a>
               </p>
               <p class="description"><?php _e( 'Enter a full .ogg or .oga URL here. You must include both file types for full browser support.', 'canvys' ); ?></p>

            </div>

            <!-- Gallery Format Meta -->
            <div class="cv-post-format-meta-pane" data-format="gallery">

               <p><strong><?php _e( 'Featured Gallery', 'canvys' ); ?></strong></p>
               <input type="hidden" id="cv-gallery-format-ids" name="_cv_format_meta[gallery][ids]" class="widefat" value="<?php echo $gallery['ids']; ?>" />
               <div id="cv-gallery-format-preview" class="cv-gallery-format-preview cv-format-meta-manage-gallery">
               <?php $this->render_format_gallery_callback( $gallery['ids'] ); ?>
               </div>
               <p id="cv-gallery-format-controls">
                  <?php $hidden = $gallery['ids'] ? ' style="display:none;"' : null; ?>
                  <a class="button cv-format-meta-manage-gallery" <?php echo $hidden; ?>><?php _e( 'Create Gallery', 'canvys' ); ?></a>
                  <?php $hidden = $gallery['ids'] ? null : ' style="display:none;"'; ?>
                  <a class="button cv-format-meta-remove-gallery" <?php echo $hidden; ?>><?php _e( 'Remove Gallery', 'canvys' ); ?></a>
               </p>

            </div>

            <!-- Image Format Meta -->
            <!-- <div class="cv-post-format-meta-pane" data-format="image">
               <p><strong><?php _e( 'The featured image of this post will be treated as the post format specific image.', 'canvys' ); ?></strong></p>
            </div> -->

            <!-- Link Format Meta -->
            <div class="cv-post-format-meta-pane" data-format="link">
               <p><label for="cv-link-format-url"><strong><?php _e( 'Link URL', 'canvys' ); ?></strong></label></p>
               <p>
                  <input type="text" id="cv-link-format-url" name="_cv_format_meta[link][url]" class="widefat code" value="<?php echo $link['url']; ?>" placeholder="http://" />
               </p>
               <p class="description"><?php _e( 'Enter a full URL here, the title of this post will be used as the link text.', 'canvys' ); ?></p>
            </div>

            <!-- Quote Format Meta -->
            <div class="cv-post-format-meta-pane" data-format="quote">
               <p><strong><?php _e( 'The title of this post will be treated as the quote author, and the content will be treated as the quote.', 'canvys' ); ?></strong></p>
            </div>

            <!-- Video Format Meta -->
            <div class="cv-post-format-meta-pane" data-format="video">

               <p><label for="cv-video-format-source"><strong><?php _e( 'Video Source', 'canvys' ); ?></strong></label></p>
               <p>
                  <select id="cv-video-format-source" name="_cv_format_meta[video][source]">
                     <option value="hosted" <?php selected( $video['source'], 'hosted' ); ?>><?php _e( 'Self Hosted Video', 'canvys' ); ?></option>
                     <option value="embed"  <?php selected( $video['source'], 'embed' );  ?>><?php _e( 'YouTube/Vimeo Embed', 'canvys' ); ?></option>
                  </select>
               </p>

               <div data-video-source="hosted">

                  <p><label for="cv-video-format-mp4"><strong><?php _e( 'MP4 File URL', 'canvys' ); ?></strong></label></p>
                  <p>
                     <input type="text" id="cv-video-format-mp4" name="_cv_format_meta[video][mp4]" class="widefat cv-file-input code" value="<?php echo $video['mp4']; ?>" />
                  </p>
                  <p>
                     <a class="button cv-select-file" data-type="video" data-sync="cv-video-format-mp4"><?php _e( 'Select File', 'canvys' ); ?></a>
                     <a class="button cv-remove-file" data-sync="cv-video-format-mp4"><?php _e( 'Remove File', 'canvys' ); ?></a>
                  </p>
                  <p class="description"><?php _e( 'Enter a full .mp4 URL here. You must include both file types.', 'canvys' ); ?></p>

                  <p><label for="cv-video-format-ogv"><strong><?php _e( 'OGV File URL', 'canvys' ); ?></strong></label></p>
                  <p>
                     <input type="text" id="cv-video-format-ogv" name="_cv_format_meta[video][ogv]" class="widefat cv-file-input code" value="<?php echo $video['ogv']; ?>" />
                  </p>
                  <p>
                     <a class="button cv-select-file" data-type="video" data-sync="cv-video-format-ogv"><?php _e( 'Select File', 'canvys' ); ?></a>
                     <a class="button cv-remove-file" data-sync="cv-video-format-ogv"><?php _e( 'Remove File', 'canvys' ); ?></a>
                  </p>
                  <p class="description"><?php _e( 'Enter a full .ogv URL here. You must include both file types.', 'canvys' ); ?></p>

                  <p><label for="cv-video-format-poster"><strong><?php _e( 'Poster Image URL', 'canvys' ); ?></strong></label></p>
                  <p>
                     <input type="text" id="cv-video-format-poster" name="_cv_format_meta[video][poster]" class="widefat cv-file-input code" value="<?php echo $video['poster']; ?>" />
                  </p>
                  <p>
                     <a class="button cv-select-file" data-type="image" data-sync="cv-video-format-poster"><?php _e( 'Select Image', 'canvys' ); ?></a>
                     <a class="button cv-remove-file" data-sync="cv-video-format-poster"><?php _e( 'Remove Image', 'canvys' ); ?></a>
                  </p>
                  <p class="description"><?php _e( 'here you cn optionally select an image to be displayed in place of the video before it isplayed.', 'canvys' ); ?></p>

               </div>

               <div data-video-source="embed">

                  <p><label for="cv-video-format-embed"><strong><?php _e( 'YouTube/Vimeo Embed', 'canvys' ); ?></strong></label></p>
                  <p>
                     <input type="text" id="cv-video-format-embed" name="_cv_format_meta[video][embed]" class="widefat code" value="<?php echo $video['embed']; ?>" />
                  </p>
                  <p class="description"><?php _e( 'Enter either a YouTube or Vimeo video page URL here, it is not necessary to enter the actual embed URL.', 'canvys' ); ?></p>

               </div>

            </div>

            <?php wp_nonce_field( 'cv_update_format_meta_action', '_cv_format_meta_nonce' ); ?>

         </div>

      </script>

   <?php }

   /**
    * Displays the meta box on the edit screen
    *
    * @param int $post_id The ID of the post to be updated
    * @return void
    */
   public function update( $post_id ) {

      // If the post is being autosaved, no need to update values
      if ( defined('DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
         return $post_id;
      }

      // Verify the nonce before proceeding.
      if ( ! isset( $_POST['_cv_format_meta_nonce'] ) || ! wp_verify_nonce( $_POST['_cv_format_meta_nonce'], 'cv_update_format_meta_action' ) ) {
         return $post_id;
      }

      // Grab the input values
      $input = $_POST['_cv_format_meta'];
      $clean = array();

      // Audio format meta
      if ( isset( $input['audio'] ) ) {
         $clean['audio']['mp3'] = isset( $input['audio']['mp3'] ) ? cv_filter( $input['audio']['mp3'], 'url' ) : null;
         $clean['audio']['ogg'] = isset( $input['audio']['ogg'] ) ? cv_filter( $input['audio']['ogg'], 'url' ) : null;
      }

      // Gallery format meta
      if ( isset( $input['gallery'] ) ) {
         $clean['gallery']['ids'] = isset( $input['gallery']['ids'] ) ? $input['gallery']['ids'] : null;
      }

      // Link format meta
      if ( isset( $input['link'] ) ) {
         $clean['link']['url'] = isset( $input['link']['url'] ) ? cv_filter( $input['link']['url'], 'url' ) : null;
      }

      // Video format meta
      if ( isset( $input['video'] ) ) {
         $clean['video']['source'] = isset( $input['video']['source'] ) ? cv_filter( $input['video']['source'], array( 'hosted', 'embed' ) ) : 'hosted';
         $clean['video']['mp4']    = isset( $input['video']['mp4'] ) ? cv_filter( $input['video']['mp4'], 'url' ) : null;
         $clean['video']['ogv']    = isset( $input['video']['ogv'] ) ? cv_filter( $input['video']['ogv'], 'url' ) : null;
         $clean['video']['poster'] = isset( $input['video']['poster'] ) ? cv_filter( $input['video']['poster'], 'url' ) : null;
         $clean['video']['embed']  = isset( $input['video']['embed'] ) ? cv_filter( $input['video']['embed'], 'url' ) : null;
      }

      // Finally, update the setting
      update_post_meta( $post_id , '_cv_format_meta', $clean );

   }

   /**
    * Returns a list of images from a list of ID`s
    *
    * @return void
    */
   public function render_format_gallery_callback( $forced_input = null ) {
      $ajax_input = isset( $_POST['input'] ) ? $_POST['input'] : null;
      if ( $input = $ajax_input ? $ajax_input : $forced_input ) {
         foreach ( explode( ',', $input ) as $id ) {
            if ( ! $img_data = wp_get_attachment_image_src( $id, 'thumbnail' ) ) continue;
            echo '<div><img src="' . $img_data[0] . '" alt="' . sprintf( __( 'Image ID: %s', 'canvys' ), $id ) . '" /></div>';
         }
      }
      if ( $ajax_input ) die();
   }

}
endif;