<?php
/**
 * Content wrappers
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>
		</div> <!-- / #main -->
    <?php if( is_single() && is_product_alternative_layout() == true):?>
    <?php else:?>
    </div> <!-- /.container -->
    <?php endif;?>
</div> <!-- / #content -->