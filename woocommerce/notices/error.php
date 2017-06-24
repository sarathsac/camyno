<?php
/**
 * Show error messages
 *
 * @package    WordPress
 * @subpackage Canvys
 * @since      Version 1.0
 * @version    1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! $messages ) return;
?>
<div class="cv-notification is-error">
   <ul class="woocommerce-error">
   	<?php foreach ( $messages as $message ) : ?>
   		<li><?php echo wp_kses_post( $message ); ?></li>
   	<?php endforeach; ?>
   </ul>
</div>