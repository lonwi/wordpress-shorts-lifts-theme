<?php
/**
 * Thankyou page
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.2.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>
<div class="checkout-bar-steps row">
	<div class="threecol first">
    	<a href="#checkout-step-1" class="checkout-bar-step checkout-bar-step-1 completed disabled"><span>1</span>Billing Details</a>
    </div>
    <div class="threecol">
    	<a href="#checkout-step-2" class="checkout-bar-step checkout-bar-step-2 completed disabled"><span>2</span>Shipping Details</a>
    </div>
    <div class="threecol">
    	<a href="#checkout-step-3" class="checkout-bar-step checkout-bar-step-3 completed disabled"><span>3</span>Review Your Order</a>
    </div>
    <div class="threecol last">
    	<a href="#checkout-step-4" class="checkout-bar-step checkout-bar-step-4 current"><span>4</span>Confirmation</a>
    </div>
</div>

<div id="checkout-step-4" class="checkout-step-tab checkout-step-tab-4 current">
<?php
if ( $order ) : ?>

	<?php if ( $order->has_status( 'failed' ) ) : ?>

		<p><?php _e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction.', 'woocommerce' ); ?></p>

		<p><?php
			if ( is_user_logged_in() )
				_e( 'Please attempt your purchase again or go to your account page.', 'woocommerce' );
			else
				_e( 'Please attempt your purchase again.', 'woocommerce' );
		?></p>

		<p>
			<a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="button pay"><?php _e( 'Pay', 'woocommerce' ) ?></a>
			<?php if ( is_user_logged_in() ) : ?>
			<a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'myaccount' ) ) ); ?>" class="button pay"><?php _e( 'My Account', 'woocommerce' ); ?></a>
			<?php endif; ?>
		</p>

	<?php else : ?>

		<h1><?php _e('Thank you. Your order is now being processed.', 'shorts');?></h1>
        <p><?php _e('Please contact the office on 01274 305066 should you have any queries.', 'shorts');?></p>
		
        <?php /* ?>
		<ul class="order_details">
			<li class="order">
				<?php _e( 'Order:', 'woocommerce' ); ?>
				<strong><?php echo $order->get_order_number(); ?></strong>
			</li>
			<li class="date">
				<?php _e( 'Date:', 'woocommerce' ); ?>
				<strong><?php echo date_i18n( get_option( 'date_format' ), strtotime( $order->order_date ) ); ?></strong>
			</li>
			<li class="total">
				<?php _e( 'Total:', 'woocommerce' ); ?>
				<strong><?php echo $order->get_formatted_order_total(); ?></strong>
			</li>
			<?php if ( $order->payment_method_title ) : ?>
			<li class="method">
				<?php _e( 'Payment method:', 'woocommerce' ); ?>
				<strong><?php echo $order->payment_method_title; ?></strong>
			</li>
			<?php endif; ?>
		</ul>
		<?php */ ?>
		<div class="clear"></div>

	<?php endif; ?>

	<?php do_action( 'woocommerce_thankyou_' . $order->payment_method, $order->id ); ?>
	<?php do_action( 'woocommerce_thankyou', $order->id ); ?>

<?php else : ?>

	<p><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', __( 'Thank you. Your order is now being processed.<br>Please contact the office on 01274 305066 should you have any queries.', 'woocommerce' ), null ); ?></p>

<?php endif; ?>
</div>