<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>
<?php
	 do_action( 'woocommerce_before_single_product' );
	 if ( post_password_required() ) {
	 	echo get_the_password_form();
	 	return;
	 }
?>

<div itemscope itemtype="<?php echo woocommerce_get_product_schema(); ?>" id="product-<?php the_ID(); ?>" <?php post_class('product-alternative-layout'); ?>>
	<div  class="row">
        <div class="sixcol first">
            <div class="summary entry-summary">
                <?php woocommerce_single_title_with_sku_complete_lifts();?>
            </div>
        </div>
        <div class="sixcol last">
            <a href="<?php echo get_permalink('11');?>" class="button-enquire"><?php _e('Enquire Now','nyla');?></a>
        </div>
    </div>
	<div class="row">
    <?php
		 wc_get_template( 'single-product/product-image-full-width.php' );
	?>
	</div>
    <div class="row">
	<?php
		do_action( 'woocommerce_after_single_product_summary' );
	?>
    </div>
    <div class="row">
    <a href="<?php echo get_permalink('11');?>" class="button-enquire"><?php _e('Enquire Now','nyla');?></a>
    </div>
	
	<meta itemprop="url" content="<?php the_permalink(); ?>" />

</div><!-- #product-<?php the_ID(); ?> -->

<?php do_action( 'woocommerce_after_single_product' ); ?>
