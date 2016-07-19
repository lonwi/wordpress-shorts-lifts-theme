<?php
/**
 * Loop Price
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product;
?>
<?php if(is_user_logged_in() ):?>
	<?php if ( $price_html = $product->get_price_html() ) : ?>
	<p class="price"><?php echo $price_html; ?>
    <?php if($product->get_price() > 0 ):?>
    	<?php if(get_user_resticted_manufacturers() === false):?>
        <span class="discount-note">Order online<br><span class="bold">Get 2% Off</span>*</span>
        <?php endif;?>
    <?php endif; ?>
    </p>
    <?php endif; ?>
<?php else:?>
<?php //echo '<div class="please-log-in clearfix"><a href="'.get_permalink(7).'">'.__('Log in to view prices', GETTEXT_DOMAIN).'</a></div>';?>
<?php endif;?>