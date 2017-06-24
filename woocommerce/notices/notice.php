<?php
/**
 * Show messages
 *
 * @package    WordPress
 * @subpackage Canvys
 * @since      Version 1.0
 * @version    1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! $messages ) return;
?>

<?php foreach ( $messages as $message ) : ?>
   <div class="woocommerce-message cv-notification is-info">
      <p class="notification-title"><?php echo wp_kses_post( $message ); ?></p>
   </div>
<?php endforeach; ?>