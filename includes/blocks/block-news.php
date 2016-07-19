<?php
	$args = array(
		'post_type'        => 'post',
		'posts_per_page'   => 10,
		'post_status'      => 'publish',
		'orderby'          => 'post_date',
		'order'            => 'DESC',
	);
	$news_array = get_posts( $args ); 
?>
<?php if(isset($news_array) && $news_array != ""):?>
<div class="block-news container clearfix">
	<ul id="block-news-slider" class="block-news-slider">
 		<?php foreach($news_array as $news):?>
			<?php
				$category  = get_the_category($news->ID);
			?>
            <li><a href="<?php echo get_category_link($category[0]->term_id );?>" class="uppercase green bold"><?php echo $category[0]->cat_name;?>: </a></span> <a href="<?php echo get_permalink($news->ID);?>" title="<?php _e('Read more about: ',GETTEXT_DOMAIN);?> <?php echo $news->post_title;?>" class="black semi-bold"><?php echo truncate(wp_filter_nohtml_kses($news->post_content), 140, '...', true, true);?></a></li>
            
        <?php endforeach;?>
    </ul>
</div>
<?php endif;?>