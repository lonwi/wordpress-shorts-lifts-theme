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
<div id="content" class="content clearfix">
	<?php if( is_single() && is_product_alternative_layout() == true):?>
    <?php else:?>
    <div class="container">
    <?php endif;?>
		<?php if(is_single()):?>
        <div id="main" class="main clearfix" role="main">
        <?php else:?>
        <?php do_action( 'woocommerce_custom_sidebar' );?>
        <div id="main" class="main ninecol last " role="main">
        <?php endif;?>