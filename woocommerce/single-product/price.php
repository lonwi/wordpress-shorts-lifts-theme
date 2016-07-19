<?php
/**
 * Single Product Price, including microdata for SEO
 *
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.4.9
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

?>
<div itemprop="offers" itemscope itemtype="http://schema.org/Offer">

	<p class="price"><?php echo $product->get_price_html(); ?>
    <?php if($product->get_price() > 0 ):?>
    	<?php if(get_user_resticted_manufacturers() === false):?>
    	<span class="discount-note">Order online <span class="bold">Get 2% Off</span>*</span>
        <?php endif;?>
    <?php endif;?>
    </p>
	
    <?php if(get_user_resticted_manufacturers() === false ):?>
	<meta itemprop="price" content="<?php echo esc_attr( $product->get_price() ); ?>" />
	<meta itemprop="priceCurrency" content="<?php echo esc_attr( get_woocommerce_currency() ); ?>" />
	<link itemprop="availability" href="http://schema.org/<?php echo $product->is_in_stock() ? 'InStock' : 'OutOfStock'; ?>" />
    <?php endif;?>

</div>
