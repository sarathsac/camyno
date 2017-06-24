<?php
/**
 * Single Product tabs
 *
 * @package    WordPress
 * @subpackage Canvys
 * @since      Version 1.0
 * @version    2.4.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Filter tabs and allow third parties to add their own
 *
 * Each tab is an array containing title, callback and priority.
 * @see woocommerce_default_product_tabs()
 */
$tabs = apply_filters( 'woocommerce_product_tabs', array() );

if ( empty( $tabs ) ) return; ?>

<div class="woocommerce-tabs">
   <ul class="tabs js-only cv-split-<?php echo count( $tabs ); ?> has-clearfix">
      <?php foreach ( $tabs as $key => $tab ) : ?>

         <li class="<?php echo $key ?>_tab">
            <a href="#tab-<?php echo $key ?>"><?php echo apply_filters( 'woocommerce_product_' . $key . '_tab_title', $tab['title'], $key ) ?></a>
         </li>

      <?php endforeach; ?>
   </ul>
   <div class="panels">
      <?php foreach ( $tabs as $key => $tab ) : ?>

         <div class="panel entry-content" id="tab-<?php echo $key ?>">
            <?php call_user_func( $tab['callback'], $key, $tab ) ?>
         </div>

      <?php endforeach; ?>
   </div>
</div>