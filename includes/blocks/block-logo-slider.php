<?php //if( is_page( array( 236, 238 ))) :?>
<?php
$manufacturers = get_terms('pa_manufacturer', array('hide_empty' => false));
$spareslink = get_term_link( 'lift-spares', 'product_cat' );
?>
<?php if(isset($manufacturers) && $manufacturers != ""):?>
<div class="block-logo container clearfix">
	<ul id="block-logo-slider" class="block-logo-slider">
    	<?php foreach($manufacturers as $manufacturer):?>
        	<?php 
			$image = "";
			$term_tax = 'pa_manufacturer_'.$manufacturer->term_id;
			$image = get_field('logo_image',$term_tax );?>
            <?php if( $image != ""):?>
        	<li>
            	<a href="<?php echo $spareslink;?>?filter_manufacturer=<?php echo $manufacturer->term_id;?>" title="<?php echo $manufacturer->name;?> Lift Spares">
                	<img src="<?php echo $image;?>" alt="<?php echo $manufacturer->name;?>">
                </a>
            </li>
        	<?php endif;?>
        <?php endforeach;?>
    </ul>
</div>
<?php endif;?>

<?php //endif;?>

