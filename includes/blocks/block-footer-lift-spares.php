<?php $lift_spares_footer_banner = get_field('lift_spares_footer_banner', 'options');?>
<?php if($lift_spares_footer_banner != "" && (($partent =  woo_get_ancestor()) && ($partent == 32))):?>
<div class="block-lift-spares-footer container clearfix">
	<a href="<?php echo $lift_spares_footer_banner[0]['url'];?>"><img src="<?php echo $lift_spares_footer_banner[0]['image'];?>" alt="<?php echo $lift_spares_footer_banner[0]['title'];?>" /></a>
</div>
<?php endif;?>