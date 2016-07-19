<?php
global $product;
if($upsells = $product->get_upsells()):
$id = $post->ID;
?>
<div class="block-product-slider <?php echo $i % 2 == 0 ? 'even' : 'odd';?>">
	<div class="container">
        <div class="row">
        	
            <div class="product-slider-container">
            	<ul id="product-slider-<?php echo $id;?>" class="product-slider product-slider-<?php echo $id;?>">
                	<?php foreach($upsells as $upsell):?>
                    <?php
					$upsell_points = get_field('upsell_points', $upsell);
					$upsell_image = get_field('upsell_image', $upsell);
					?>
                    <?php if($upsell_points && $upsell_image):?>
                	<li>
                    	<a href="<?php echo get_permalink($upsell);?>">
                        <h3 class="product-slider-title"><?php echo get_the_title($upsell);?></h3>
                        <div class="sixcol first">
                            <div class="product-slider-image">
                            	<img src="<?php echo $upsell_image['sizes']['large'];?>" alt="">
                            </div>
                        </div>
                        <div class="sixcol last">
                        	<?php foreach($upsell_points as $upsell_point):?>
                            <div class="product-slider-box" style="background-color:<?php echo $upsell_point['background_colour'];?>">
                                <div class="product-slider-box-inner">
                                <?php echo $upsell_point['content'];?>
                                </div>
                            </div>
                            <?php endforeach;?>
                        </div>
						</a>
                    </li>
                    <?php endif;?>
                    <?php endforeach;?>
                </ul>
            </div>
            
        </div>
    </div>
</div>
<script>
	jQuery(window).load(function() {
	var productSlider<?php echo $id;?> = jQuery("#product-slider-<?php echo $id;?>");
	if(productSlider<?php echo $id;?>.length > 0){
		productSlider<?php echo $id;?>.bxSlider({
			auto: true,
			pause: 8000,
			pager: false,
			mode: "fade",
		});
	};
	});
</script>;
<?php $i++; endif;?>