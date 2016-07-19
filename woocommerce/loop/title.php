<?php
/**
 * Product loop title
 *
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
global $product, $post;
?>

<?php if( (($partent =  woo_get_ancestor()) && ($partent == 28 || $partent == 33)) ||  'yes' == get_post_meta( $post->ID, '_alternative_layout', true )):?>
<h3><?php if($title = get_product_name($product->id)) echo '<span class="product-sku">'. $title. '</span><br>';?><?php if($subtitle = get_product_subtitle($product->id)) echo '<span class="product-name">'.$subtitle.'</span>';?></h3>
<?php else:?>
<h3><?php if($sku = $product->get_sku()) echo '<span class="product-sku">'. $sku. '</span><br>';?><span class="product-name"><?php echo get_product_name($product->id); ?></span></h3>
<?php endif;?>
