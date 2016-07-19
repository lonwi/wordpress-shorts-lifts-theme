<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>
<?php
	 do_action( 'woocommerce_before_single_product' );

	 if ( post_password_required() ) {
	 	echo get_the_password_form();
	 	return;
	 }
	 global $product;
?>

<div id="product-<?php the_ID(); ?>" <?php post_class('product-layout-2'); ?>>
	
    <div class="container">
    	
        <div class="row">
        	<div class="sixcol first">
            	<?php woocommerce_single_title_layout_2();?>
            </div>
            <div class="sixcol last">
            	<?php if($product->is_in_stock()):?>
            	<div class="stock-box clearfix">
                	<span class="stock-box-status"><?php _e('In Stock', 'shorts');?></span>
                    <?php if($shorts_stock_information = get_post_meta( $post->ID, '_shorts_stock_information', true )):?>
                	<span class="stock-box-text"><?php echo $shorts_stock_information;?></span>
                    <?php endif;?>
                </div>
                <?php endif;?>
            </div>
        </div>
    </div>
    
    <div class="container">
    	
        <div class="row">
        
        	<div class="sixcol first">
				<?php do_action( 'woocommerce_before_single_product_summary' );?>
            </div>
            
            <div class="sixcol last">
            	<?php if($post->post_excerpt):?>
				<div class="product-excerpt clearfix">
                	<?php echo apply_filters('the_content', $post->post_excerpt);?>
                </div>
                <?php endif;?>
                <?php if($post->post_content):?>
                <div class="product-description clearfix">
                	<?php echo apply_filters('the_content', $post->post_content);?>
                </div>
                <?php endif;?>
                <div class="clearfix">
    				<a href="<?php echo get_permalink('11');?>" class="button-enquire"><?php _e('Enquire Now','nyla');?></a>
                </div>
                
            </div>
            
        </div>
        
    </div>
    <?php if($product_sections = get_field('product_sections', $post->ID)):?>
    <?php $i= 0; foreach($product_sections as $product_section):?>
    <div class="product-section <?php echo $i % 2 == 0 ? 'even' : 'odd';?>">
    	<div class="container">
    		<?php if($product_section['title']):?>
            <div class="row">
                <h3 class="product-section-title"><?php echo $product_section['title'];?></h3>
            </div>
            <?php endif;?>
            
            <?php if($product_section['content']):?>
            <div class="row">
                <div class="product-section-content clearfix">
                    <?php echo $product_section['content'];?>
                </div>
            </div>
            <?php endif;?>
            
            <?php if($product_section['left_column'] && $product_section['right_column']):?>
            <div class="row">
                <div class="sixcol first">
                    <div class="product-section-left clearfix">
					<?php foreach($product_section['left_column'] as $element):?>
                        <div class="product-section-element <?php echo $element['element_type'] ;?> clearfix" <?php if($element['background_colour']) echo 'style="background-color:'.$element['background_colour'].'"';?>>
                        
                        <?php if($element['element_type'] == 'image' && !empty($element['image'])):?>
                        	<div class="inner-image">
                            <img src="<?php echo $element['image']['sizes']['large'];?>" alt="<?php echo $element['image']['alt'];?>">
                            </div>
                        <?php endif;?>
                        
                        <?php if($element['element_type'] == 'content_box' && !empty($element['content']) ):?>
                        	<div class="inner-content">
                        	<?php echo $element['content'];?>
                            </div>
                        <?php endif;?>
                        
                        <?php if($element['element_type'] == 'image_box' && !empty($element['image']) && !empty($element['content']) ):?>
                        	<div class="inner-image">
                            <img src="<?php echo $element['image']['sizes']['shop_thumbnail'];?>" alt="<?php echo $element['image']['alt'];?>">
                            </div>
                            <div class="inner-content">
                            <?php echo $element['content'];?>
                            </div>
                        <?php endif;?>
                        
                        </div>
                    <?php endforeach;?>
                    </div>
                </div>
                <div class="sixcol last">
                    <div class="product-section-right clearfix">
                    <?php foreach($product_section['right_column'] as $element):?>
                        <div class="product-section-element <?php echo $element['element_type'] ;?> clearfix" <?php if($element['background_colour']) echo 'style="background-color:'.$element['background_colour'].'"';?>>
                        
                        <?php if($element['element_type'] == 'image' && !empty($element['image'])):?>
                        	<div class="inner-image">
                            <img src="<?php echo $element['image']['sizes']['large'];?>" alt="<?php echo $element['image']['alt'];?>">
                            </div>
                        <?php endif;?>
                        
                        <?php if($element['element_type'] == 'content_box' && !empty($element['content']) ):?>
                        	<div class="inner-content">
                        	<?php echo $element['content'];?>
                            </div>
                        <?php endif;?>
                        
                        <?php if($element['element_type'] == 'image_box' && !empty($element['image']) && !empty($element['content']) ):?>
                        	<div class="inner-image">
                            <img src="<?php echo $element['image']['sizes']['shop_thumbnail'];?>" alt="<?php echo $element['image']['alt'];?>">
                            </div>
                            <div class="inner-content">
                            <?php echo $element['content'];?>
                            </div>
                        <?php endif;?>
                        
                        </div>
                    <?php endforeach;?>
                    </div>
                </div>
            </div>
            <?php endif;?>
        </div>
    </div>
    <?php $i++; endforeach;?>
    <?php endif;?>
    <?php include_once(locate_template('includes/blocks/block-product-slider.php'));?>
    <?php //get_template_part('includes/blocks/block', 'product-slider');?>
    <?php include_once(locate_template('includes/blocks/block-product-boxes.php'));?>
    <?php //get_template_part('includes/blocks/block', 'product-boxes');?>
    
</div><!-- #product-<?php the_ID(); ?> -->