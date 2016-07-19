<?php
/**
 * Product Loop Start
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */
?>
<?php
if(($partent =  woo_get_ancestor()) && ($partent == 28 || $partent == 33)){
	_e('<h1 class="title">Select your Product</h1>', GETTEXT_DOMAIN);
}
?>
<ul class="products">