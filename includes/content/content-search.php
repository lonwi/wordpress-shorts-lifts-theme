<?php
$button_text = __('Read more', 'shorts');
$permalink = get_permalink();
$subtitle = "";
if($post->post_type == 'page'){
	$subtitle = __('Content Page', 'shorts');
	$button_text = __('Read more', 'shorts');	
}
if($post->post_type == 'team-member'){
	$subtitle = __('Team Member', 'shorts');
	$button_text = __('Read more', 'shorts');
}
if($post->post_type == 'product'){
	$subtitle = __('Product', 'shorts');
	$button_text = __('View details', 'shorts');	
}
if($post->post_type == 'download'){
	$subtitle = __('Download', 'shorts');
	$button_text = __('Download', 'shorts');
	$permalink = get_download_file_url($post->ID);
}
?>
<div class="search-post clearfix">
    <article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
        <header class="search-post-header">
        	<?php /* if ( has_post_thumbnail() ) :?>
        	<div class="search-post-image clearfix">
                <a href="<?php echo get_permalink();?>" title="<?php echo get_the_title();?>" class="search-post-image-link">
                    <?php echo get_the_post_thumbnail($post->ID, 'full-width-product'); ?>
                </a>
            </div>
            <?php endif; */?>
            <h3 class="search-post-title">
            	<a href="<?php echo $permalink;?>" rel="bookmark" title="<?php echo get_the_title();?>"><?php echo get_the_title();?></a>
            </h3>
            <?php if(isset($subtitle) && !empty($subtitle)):?>
            <h4 class="search-post-subtitle"><?php echo $subtitle;?></h4>
            <?php endif;?>
        </header>

        <div class="search-post-excerpt">
        	<?php if($post->post_type == 'product'):?>
            <p><?php echo truncate(strip_tags($post->post_content), 500);?></p>
            <?php elseif($post->post_excerpt):?>
            <p><?php echo truncate(strip_tags($post->post_excerpt), 500);?></p>
			<?php else:?>
        	<p><?php //echo truncate(strip_tags($post->post_content), 500);?></p>
            <?php endif;?>
        </div>
        <footer class="search-post-footer">
        	<a href="<?php echo $permalink; ?>" rel="bookmark" title="<?php echo get_the_title();?>" class="button gray next"><?php echo $button_text;?></a>
        </footer>
    </article>
</div>