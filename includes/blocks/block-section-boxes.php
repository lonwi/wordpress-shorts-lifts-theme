<?php $boxes = get_field('homepage_boxes', 'options');?>

<?php if(isset($boxes) && !empty($boxes)):?>
<div class="block-section-boxes container">
	<div class="row">
    	<?php foreach($boxes as $key => $box):?>
        	<div class="onethirdcol <?php if($key == 0) echo 'first';?><?php if($key == 2) echo 'last';?>">
                <a href="<?php echo $box['box_url'];?>" title="<?php echo $box['box_title'];?>" class="block-section-box">
                    <img src="<?php echo $box['box_image'];?>" alt="<?php echo $box['box_title'];?>">
                </a>
            </div>
        <?php endforeach;?>
    </div>
</div>
<?php endif;?>
