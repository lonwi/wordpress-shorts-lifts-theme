<?php
/**
 * Checkout Form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div class="checkout-bar-steps row">
	<div class="threecol first">
    	<a href="#checkout-step-1" class="checkout-bar-step checkout-bar-step-1 current"><span>1</span>Billing Details</a>
    </div>
    <div class="threecol">
    	<a href="#checkout-step-2" class="checkout-bar-step checkout-bar-step-2"><span>2</span>Shipping Details</a>
    </div>
    <div class="threecol">
    	<a href="#checkout-step-3" class="checkout-bar-step checkout-bar-step-3"><span>3</span>Review Your Order</a>
    </div>
    <div class="threecol last">
    	<a href="#checkout-step-4" class="checkout-bar-step checkout-bar-step-4"><span>4</span>Confirmation</a>
    </div>
</div>

<?php
wc_print_notices();

do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the user cannot checkout
if ( ! $checkout->enable_signup && ! $checkout->enable_guest_checkout && ! is_user_logged_in() ) {
	echo apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) );
	return;
}
// filter hook for include new pages inside the payment method
$get_checkout_url = apply_filters( 'woocommerce_get_checkout_url', WC()->cart->get_checkout_url() ); ?>
<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( $get_checkout_url ); ?>" enctype="multipart/form-data">

<div class="checkout-step-tabs clearfix">

	<?php if ( sizeof( $checkout->checkout_fields ) > 0 ) : ?>
    <div id="checkout-step-1" class="checkout-step-tab checkout-step-tab-1 current">
    	<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

		<?php do_action( 'woocommerce_checkout_billing' ); ?>

		<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>
        <div class="row checkout-step-tab-footer">

            <div class="sixcol first">
            	<a href="<?php echo WC()->cart->get_cart_url();?>" class="button gray-light previous"><?php _e('Back to Shopping Basket', 'woocommerce');?></a>
            </div>
            <div class="sixcol last text-right">
            	<a href="#checkout-step-2" class="button next change-step"><?php _e('Shipping Details', 'woocommerce');?></a>
            </div>

        </div>
    </div>

    <div id="checkout-step-2" class="checkout-step-tab checkout-step-tab-2">
    	<?php do_action( 'woocommerce_checkout_shipping' ); ?>

        <div class="row checkout-step-tab-footer">

            <div class="sixcol first">
            	<a href="#checkout-step-1" class="button gray-light previous change-step"><?php _e('Billing Details', 'woocommerce');?></a>
            </div>
            <div class="sixcol last text-right">
            	<a href="#checkout-step-3" class="button next change-step"><?php _e('Order Review', 'woocommerce');?></a>
            </div>

        </div>
    </div>
    <?php endif; ?>

    <div id="checkout-step-3" class="checkout-step-tab checkout-step-tab-3">
    	<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

        <div id="order_review" class="woocommerce-checkout-review-order">

            <h3 class="title"><?php _e('Review Your Order','shorts');?></h3>

            <!--
            <p class="purchase-order-number-review bold"><?php _e( 'Purchase Order Number', 'woocommerce' ); ?>: <span class="normal">&nbsp;</span></p>
            -->


            <!--
            <div class="col2-set addresses">
                <div class="col-1 address">
                    <h3 class="title-small">Billing Address</h3>
                    <div class="address">
                        <p></p>
                    </div>
                </div>
                <div class="col-2 address">
                    <h3 class="title-small">Shipping Address</h3>
                    <div class="address">
                        <p></p>
                    </div>
                </div>
            </div>
            -->

            <?php do_action( 'woocommerce_checkout_order_review' ); ?>

        </div>

        <?php do_action( 'woocommerce_checkout_after_order_review' ); ?>

        <div class="row checkout-step-tab-footer">

            <div class="sixcol first">
            	<a href="#checkout-step-2" class="button gray-light previous change-step"><?php _e('Shipping Details', 'woocommerce');?></a>
            </div>

            <div class="sixcol last text-right">
            	<?php
				$order_button_text = apply_filters( 'woocommerce_order_button_text', __( 'Place order', 'woocommerce' ) );

				echo apply_filters( 'woocommerce_order_button_html', '<input type="submit" class="button next" name="woocommerce_checkout_place_order" id="place_order" value="' . esc_attr( $order_button_text ) . '" data-value="' . esc_attr( $order_button_text ) . '" />' );
				?>
            </div>

        </div>
    </div>

    <div id="checkout-step-4" class="checkout-step-tab checkout-step-tab-4">
    	<?php do_action( 'woocommerce_checkout_order_confirmation' ); ?>
    </div>

</div>

</form>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>