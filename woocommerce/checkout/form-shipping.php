<?php
/**
 * Checkout shipping information form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.2.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>
<div class="woocommerce-shipping-fields row">
	
    <div class="sixcol first">
    	
    	<h3 class="title"><?php _e( 'Address Book', 'woocommerce' ); ?></h3>
        
        <?php do_action( 'woocommerce_before_checkout_address_book', $checkout ); ?>
        
        <?php do_action( 'woocommerce_after_checkout_address_book', $checkout ); ?>
        
        <h3 class="title"><?php _e( 'Additional Information', 'woocommerce' ); ?></h3>
    
		<?php do_action( 'woocommerce_before_order_notes', $checkout ); ?>
    
        <?php foreach ( $checkout->checkout_fields['order'] as $key => $field ) : ?>
    
            <?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>
    
        <?php endforeach; ?>
    
        <?php do_action( 'woocommerce_after_order_notes', $checkout ); ?>
   
    </div>
    <div class="sixcol last">
	<?php if ( WC()->cart->needs_shipping_address() === true ) : ?>

		<?php
			$ship_to_different_address = 1;
		?>

		<h3 id="ship-to-different-address" class="hidden">
			<label for="ship-to-different-address-checkbox" class="checkbox"><?php _e( 'Ship to a different address?', 'woocommerce' ); ?></label>
			<input id="ship-to-different-address-checkbox" class="input-checkbox" <?php checked( $ship_to_different_address, 1 ); ?> type="checkbox" name="ship_to_different_address" value="1" />
		</h3>
		
        <h3 class="title"><?php _e( 'Shipping Details', 'woocommerce' ); ?> <label for="same-as-billing-checkbox" class="checkbox"><input id="same-as-billing-checkbox" class="input-checkbox" type="checkbox" name="same_as_billing" value="1" /><?php _e( 'Same as Billing Address', 'woocommerce' ); ?></label></h3>
        
        <?php //print_result($checkout);?>
        
		<div class="shipping_address">

			<?php do_action( 'woocommerce_before_checkout_shipping_form', $checkout ); ?>

			<?php foreach ( $checkout->checkout_fields['shipping'] as $key => $field ) : ?>
				
				<?php woocommerce_form_field( $key, $field, false/*$checkout->get_value( $key )*/ ); ?>

			<?php endforeach; ?>

			<?php do_action( 'woocommerce_after_checkout_shipping_form', $checkout ); ?>

		</div>

	<?php endif; ?>
	
    </div>
</div>
