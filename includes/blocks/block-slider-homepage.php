<?php $homepage_slider = get_field('homepage_slider', 'options');?>
<?php if($homepage_slider->ID != ""):?>
<div class="block-slider container clearfix">
    <div class="row">
        <?php echo get_sl_slider($homepage_slider->ID);?>
    </div>
</div>
<?php endif;?>