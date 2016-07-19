<?php $lift_spares_slider = get_field('lift_spares_slider', 'options');?>
<?php $lift_spares_boxes  = get_field('lift_spares_boxes', 'options');?>
<?php if($lift_spares_slider->ID != ""):?>
<div class="block-slider container clearfix">
    <div class="row">
    	<div class="twothirdcol lift-spares-slider first">
        	<?php echo get_sl_slider($lift_spares_slider->ID);?>
        </div>
        <div class="onethirdcol last">
        	<ul class="lift-spares-boxes">
			<?php foreach ($lift_spares_boxes as $lift_spares_box):?>
            	<li class="lift-spare-box">
                	<a href="<?php echo $lift_spares_box['box_url'];?>" title="<?php echo $lift_spares_box['box_title'];?>">
                    	<img src="<?php echo $lift_spares_box['box_image'];?>" alt="<?php echo $lift_spares_box['box_title'];?>">
                	</a>
            	</li>
            <?php endforeach;?> 
            </ul>
        </div>
    </div>
</div>
<?php endif;?>
