<?php
/**
 * Edit address form
 *
 * @author      WooThemes
 * @package     WooCommerce/Templates
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$current_user = wp_get_current_user();

$page_title = ( $load_address === 'billing' ) ? __( 'Billing Address', 'woocommerce' ) : __( 'Shipping Address', 'woocommerce' );
?>
<?php wc_print_notices(); ?>

<?php if ( ! $load_address ) : ?>

	<?php wc_get_template( 'myaccount/my-address.php' ); ?>

<?php else : ?>

	<script>
		jQuery(document).ready(function() {
			var postcodes = <?php echo json_encode(get_ie_postcodes());?>;
			var form = jQuery('form#account_edit_address_form_<?php echo $load_address;?>');
			
			var formCountry = form.find('select#<?php echo $load_address;?>_country');
			var formPostcode = form.find('input#<?php echo $load_address;?>_postcode');
			
			var formPostcodeContainer = jQuery('<span id="<?php echo $load_address;?>_postcode_ie_container" style="display:block;" class="hidden"><select name="<?php echo $load_address;?>_postcode_ie" id="<?php echo $load_address;?>_postcode_ie"></select></span>');

			formPostcodeContainer.appendTo('form#account_edit_address_form_<?php echo $load_address;?> #<?php echo $load_address;?>_postcode_field');
			
			var ieFormPostcode = jQuery('select#<?php echo $load_address;?>_postcode_ie');
		
			jQuery.each( postcodes, function( key, value ) {
				ieFormPostcode.append(jQuery('<option value="'+value+'">'+value+'</option>'));
			});
			
			ieFormPostcode.not( ".hasCustomSelect" ).customSelect();
			
			if(formCountry.val() === 'IE'){
				formPostcode.addClass('hidden');
				formPostcodeContainer.removeClass('hidden');
				
				if(form.find('select#<?php echo $load_address;?>_postcode_ie option[value="'+formPostcode.val()+'"]').length > 0){
					ieFormPostcode.val(formPostcode.val()).trigger('render');
				}
				formPostcode.val(ieFormPostcode.val());
			}
			
			formCountry.on('change', function() {
				var country = this.value;
				
				formPostcode.removeClass('hidden');
				formPostcodeContainer.removeClass('hidden');
				ieFormPostcode.trigger('render');
				
				if(country === 'IE'){
					formPostcode.addClass('hidden');
					if(form.find('select#<?php echo $load_address;?>_postcode_ie option[value="'+formPostcode.val()+'"]').length > 0){
						ieFormPostcode.val(formPostcode.val()).trigger('render');
					}
					formPostcode.val(ieFormPostcode.val());
				}else{
					formPostcodeContainer.addClass('hidden');
				}
				
			});
			
			ieFormPostcode.on('change', function() {
				var ieFormPostcodeValue = this.value;
				formPostcode.val(ieFormPostcodeValue);
			});
		});
	</script>

	<form method="post" id="account_edit_address_form_<?php echo $load_address;?>">

		<!--<h3 class="title"><?php echo apply_filters( 'woocommerce_my_account_edit_address_title', $page_title ); ?></h3>-->

		<?php do_action( "woocommerce_before_edit_address_form_{$load_address}" ); ?>
		
		<?php foreach ( $address as $key => $field ) : ?>

			<?php woocommerce_form_field( $key, $field, ! empty( $_POST[ $key ] ) ? wc_clean( $_POST[ $key ] ) : $field['value'] ); ?>

		<?php endforeach; ?>
		
		<?php do_action( "woocommerce_after_edit_address_form_{$load_address}" ); ?>

		<p>
        	<?php if($load_address === "shipping" || $load_address === "billing"){ ?>
            	<input type="submit" class="button" name="save_address" value="<?php echo sprintf(__( 'Save %s Address', 'woocommerce' ), $load_address); ?>" />
				
				
			<?php }else{ ?>
				<?php if($load_address === "add-new-address"){ ?>
                <input type="submit" class="button" name="save_address" value="<?php echo sprintf(__( 'Save %s Address', 'woocommerce' ), __('New', 'shorts')); ?>" />
                <?php }else{?>
					
                <input type="submit" class="button" name="save_address" value="<?php echo sprintf(__( 'Save %s Address', 'woocommerce' ), get_user_meta( $current_user->ID, 'multiple_customer_' . $load_address. '_adresses_name', true )); ?>" />
                <?php }?>
            <?php }	?>
			<?php wp_nonce_field( 'woocommerce-edit_address' ); ?>
			<input type="hidden" name="action" value="edit_address" />
		</p>

	</form>

<?php endif; ?>
