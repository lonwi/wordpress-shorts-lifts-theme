<?php
/**
 * Cart totals
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.6
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>
<div class="cart_totals <?php if ( WC()->customer->has_calculated_shipping() ) echo 'calculated_shipping'; ?>">

	<?php do_action( 'woocommerce_before_cart_totals' ); ?>
	
    <div class="row cart-subtotal">
    	<div class="sixcol first text-right">
        	<?php _e( 'Goods Total', 'woocommerce' ); ?>:
        </div>
        <div class="sixcol last text-right">
        	<?php wc_cart_totals_subtotal_html(); ?>
        </div>
    </div>
    
    <?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
    <div class="row cart-discount coupon-<?php echo esc_attr( $code ); ?>">
    	<div class="sixcol first text-right">
        	<?php wc_cart_totals_coupon_label( $coupon ); ?>:
        </div>
        <div class="sixcol last text-right">
        	<?php wc_cart_totals_coupon_html( $coupon ); ?>
        </div>
    </div>
    <?php endforeach; ?>
    
    <?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
	<div class="row fee">
    	<div class="sixcol first text-right">
        	<?php echo esc_html( $fee->name ); ?>:
        </div>
        <div class="sixcol last text-right">
        	<?php wc_cart_totals_fee_html( $fee ); ?>
        </div>
    </div>
	<?php endforeach; ?>
	
    <?php do_action( 'woocommerce_cart_totals_before_order_total' ); ?>
    
    <div class="row order-total">
        <div class="sixcol first text-right"><?php _e( 'Order Total', 'woocommerce' ); ?>:</div>
        <div class="sixcol last text-right"><?php echo wc_price(WC()->cart->cart_contents_total);?><?php //wc_cart_totals_order_total_html(); ?></div>
    </div>
	
    <p><small><?php _e('Shipping and taxes are not included and will be calculated during checkout based on your billing and shipping information.', 'shorts');?></small></p>

    <div class="wc-proceed-to-checkout text-right">

		<?php do_action( 'woocommerce_proceed_to_checkout' ); ?>

	</div>

	<?php do_action( 'woocommerce_after_cart_totals' ); ?>
	
</div>