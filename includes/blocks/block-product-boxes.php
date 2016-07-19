<?php $boxes = get_field('product_boxes', 'options');?>
<?php $product_boxes = get_field('product_boxes', $post->ID);?>
<?php if(isset($boxes) && !empty($boxes)):?>
<div class="block-product-boxes <?php echo $i % 2 == 0 ? 'even' : 'odd';?>">
	<div class="container">
        <div class="row">
            <?php foreach($boxes as $key => $box):?>
            	<?php
				$box_url = $product_boxes[$key]['box_url']? $product_boxes[$key]['box_url'] : $box['box_url'];
				$box_image = $product_boxes[$key]['box_image']? $product_boxes[$key]['box_image'] : $box['box_image'];
				$box_title = $product_boxes[$key]['box_title']? $product_boxes[$key]['box_title'] : $box['box_title'];
				?>
                <div class="onethirdcol <?php if($key == 0) echo 'first';?><?php if($key == 2) echo 'last';?>">
                    <a href="<?php echo $box_url;?>" title="<?php echo $box['box_title'];?>" class="block-product-box">
                        <img src="<?php echo $box_image;?>" alt="<?php echo $box_title;?>">
                    </a>
                </div>
            <?php endforeach;?>
        </div>
    </div>
</div>
<?php endif;?>
