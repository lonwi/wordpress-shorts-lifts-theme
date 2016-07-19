<?php
/**
 * Order details
 *
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$order = wc_get_order( $order_id );
?>
<h2 class="title-small"><?php _e( 'Order Summary', 'woocommerce' ); ?></h2>
<table class="shop_table order_summary">
	<tbody>
    	<tr>
        	<th><?php _e( 'Status:', 'shorts' ); ?></td>
            <td><?php echo wc_get_order_status_name( $order->get_status() );?></td>
        </tr>
    	<tr>
        	<th><?php _e( 'Web Reference Number:', 'shorts' ); ?></td>
            <td><?php echo $order->get_order_number();?></td>
        </tr>
        <tr>
        	<th><?php _e( 'Purchase Order Number:', 'shorts' ); ?></td>
            <td><?php echo get_purchase_order_number($order->id); ?></td>
        </tr>
        <tr>
        	<th><?php _e( 'Date of Order:', 'shorts' ); ?></td>
            <td><?php echo date_i18n( get_option( 'date_format' ), strtotime( $order->order_date ) );?></td>
        </tr>
    </tbody>
</table>
<h2><?php _e( 'Order Details', 'woocommerce' ); ?></h2>
<table class="shop_table order_details">
	<thead>
		<tr>
        	<th class="product-code"><?php _e( 'Product Code', 'woocommerce' ); ?></th>
			<th class="product-name"><?php _e( 'Product', 'woocommerce' ); ?></th>
			<th class="product-total"><?php _e( 'Total', 'woocommerce' ); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php
			foreach( $order->get_items() as $item_id => $item ) {
				wc_get_template( 'order/order-details-item.php', array(
					'order'   => $order,
					'item_id' => $item_id,
					'item'    => $item,
					'product' => apply_filters( 'woocommerce_order_item_product', $order->get_product_from_item( $item ), $item )
				) );
			}
		?>
		<?php do_action( 'woocommerce_order_items_table', $order ); ?>
	</tbody>
	<tfoot>
		<?php
			foreach ( $order->get_order_item_totals() as $key => $total ) {
				?>
                <?php if($total['label'] == "Discount:") $total['label'] = __('Online Discount:','shorts');?>
				<tr>
					<th scope="row"><?php echo $total['label']; ?></th>
					<td><?php echo $total['value']; ?></td>
				</tr>
				<?php
			}
		?>
	</tfoot>
</table>

<?php do_action( 'woocommerce_order_details_after_order_table', $order ); ?>

<?php wc_get_template( 'order/order-details-customer.php', array( 'order' =>  $order ) ); ?>
