<?php
/**
 * Review order form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.8
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>
<?php if ( ! $is_ajax ) : ?><h3 class="title"><?php _e( 'Review Your Order', 'woocommerce' ); ?></h3><?php endif; ?>
<?php if ( ! $is_ajax ) : ?><div id="order_review"><?php endif; ?>
	
    <script type="text/javascript">
		jQuery(document).ready(function() {
			jQuery('select.shipping_method').customSelect();
		});
	</script>
	<table class="shop_table">
		<thead>
			<tr>
				<th class="product-name"><?php _e( 'Product', 'woocommerce' ); ?></th>
				<th class="product-total"><?php _e( 'Total', 'woocommerce' ); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php
				do_action( 'woocommerce_review_order_before_cart_contents' );

				foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
					$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );

					if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
						?>
						<tr class="<?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">
							<td class="product-name">
								<?php echo apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key ); ?>
								<?php echo apply_filters( 'woocommerce_checkout_cart_item_quantity', ' <strong class="product-quantity">' . sprintf( '&times; %s', $cart_item['quantity'] ) . '</strong>', $cart_item, $cart_item_key ); ?>
								<?php echo WC()->cart->get_item_data( $cart_item ); ?>
							</td>
							<td class="product-total">
								<?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); ?>
							</td>
						</tr>
						<?php
					}
				}

				do_action( 'woocommerce_review_order_after_cart_contents' );
			?>
		</tbody>
	</table>
	
    <div class="row">
    	<div class="sixcol first">
        	<?php //do_action( 'woocommerce_review_checkout_coupon_form' ); ?>
            <p><?php _e( 'Purchase Order Number:', 'woocommerce' ); ?></p>
            <div class="row">
            	<div class="sixcol first">
                	<p><?php _e( 'Delivery', 'woocommerce' ); ?></p>
                </div>
                <div class="sixcol last">
                	<p><?php _e( 'Billing', 'woocommerce' ); ?></p>
                </div>
            </div>
            <div class="row">
            	
                
                <?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>
    
                    <?php do_action( 'woocommerce_review_order_before_shipping' ); ?>
    
                    <?php wc_cart_totals_shipping_html(); ?>
    
                    <?php do_action( 'woocommerce_review_order_after_shipping' ); ?>
    
                <?php endif; ?>
                
                
            </div>
        </div>
    	<div class="sixcol last">
        	
            <div class="cart-totals clearfix">
            	<h4><?php _e( 'Order Summary', 'woocommerce' ); ?></h4>
                <div class="row cart-subtotal">
                    <div class="fourcol first text-right"><?php _e( 'Cart Subtotal', 'woocommerce' ); ?>:</div>
                    <div class="eightcol last text-right"><?php wc_cart_totals_subtotal_html(); ?></div>
                </div>
                
                <?php foreach ( WC()->cart->get_coupons( 'cart' ) as $code => $coupon ) :?>
                <div class="row cart-discount coupon-<?php echo esc_attr( $code ); ?>">
                    <div class="fourcol first text-right"><?php wc_cart_totals_coupon_label( $coupon ); ?>:</div>
                    <div class="eightcol last text-right"><?php wc_cart_totals_coupon_html( $coupon ); ?></div>
                </div>
                <?php endforeach; ?>
                
                
                
                
                <?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
                <div class="row fee">
                    <div class="fourcol first text-right"><?php echo esc_html( $fee->name ); ?>:</div>
                    <div class="eightcol last text-right"><?php wc_cart_totals_fee_html( $fee ); ?></div>
                </div>
                <?php endforeach; ?>
                
                <?php if ( WC()->cart->tax_display_cart === 'excl' ) : ?>
                    <?php if ( get_option( 'woocommerce_tax_total_display' ) === 'itemized' ) : ?>
                        <?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : ?>
                            <div class="row tax-rate tax-rate-<?php echo sanitize_title( $code ); ?>">
                                <div class="fourcol first text-right"><?php echo esc_html( $tax->label ); ?>:</div>
                                <div class="eightcol last text-right"><?php echo wp_kses_post( $tax->formatted_amount ); ?></div>
                            </div>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <div class="row tax-total">
                            <div class="fourcol first text-right"><?php echo esc_html( WC()->countries->tax_or_vat() ); ?>:</div>
                            <div class="eightcol last text-right"><?php echo wc_price( WC()->cart->get_taxes_total() ); ?></div>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
                
                <?php foreach ( WC()->cart->get_coupons( 'order' ) as $code => $coupon ) : ?>
                
                <div class="row order-discount coupon-<?php echo esc_attr( $code ); ?>">
                    <div class="fourcol first text-right"><?php wc_cart_totals_coupon_label( $coupon ); ?>:</div>
                    <div class="eightcol last text-right"><?php wc_cart_totals_coupon_html( $coupon ); ?></div>
                </div>
                
                <?php endforeach; ?>
                
                <?php do_action( 'woocommerce_review_order_before_order_total' ); ?>
                
                <div class="row order-total">
                    <div class="fourcol first text-right"><?php _e( 'Order Total', 'woocommerce' ); ?>:</div>
                    <div class="eightcol last text-right"><?php wc_cart_totals_order_total_html(); ?></div>
                </div>
                
                <?php do_action( 'woocommerce_review_order_after_order_total' ); ?>
            
            </div>
            
        </div>
    </div>
    
	<?php do_action( 'woocommerce_review_order_before_payment' ); ?>

	<div id="payment">
    	<input type="hidden" data-order_button_text="" value="pog" name="payment_method" class="input-text" id="payment_method_pog">

		<div class="form-row place-order">

			<noscript><?php _e( 'Since your browser does not support JavaScript, or it is disabled, please ensure you click the <em>Update Totals</em> button before placing your order. You may be charged more than the amount stated above if you fail to do so.', 'woocommerce' ); ?><br/><input type="submit" class="button alt" name="woocommerce_checkout_update_totals" value="<?php _e( 'Update totals', 'woocommerce' ); ?>" /></noscript>

			<?php wp_nonce_field( 'woocommerce-process_checkout' ); ?>

			<?php do_action( 'woocommerce_review_order_before_submit' ); ?>

			

			<?php if ( wc_get_page_id( 'terms' ) > 0 && apply_filters( 'woocommerce_checkout_show_terms', true ) ) { 
				$terms_is_checked = apply_filters( 'woocommerce_terms_is_checked_default', isset( $_POST['terms'] ) );
				?>
				<p class="form-row terms text-right">
					<label for="terms" class="checkbox"><?php printf( __( 'I&rsquo;ve read and accept the <a href="%s" target="_blank">terms &amp; conditions</a>', 'woocommerce' ), esc_url( get_permalink( wc_get_page_id( 'terms' ) ) ) ); ?></label>
					<input type="checkbox" class="input-checkbox" name="terms" <?php checked( $terms_is_checked, true ); ?> id="terms" />
				</p>
			<?php } ?>

			<?php do_action( 'woocommerce_review_order_after_submit' ); ?>

		</div>

		<div class="clear"></div>

	</div>

	<?php do_action( 'woocommerce_review_order_after_payment' ); ?>

<?php if ( ! $is_ajax ) : ?></div><?php endif; ?>