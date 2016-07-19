<?php

if(is_page()){
	$banner_image = get_field('banner_image', $post->ID);
	$banner_title = $post->post_title;
}

if(is_single()){
	$banner_image = get_field('banner_image', $post->ID);
	$banner_title = $post->post_title;
	/*
	if ( get_post_type() == 'product' && empty($banner_image) ) {
		$terms = get_the_terms($post->ID, 'product_cat');
		foreach($terms as $term){
			$top_parent = get_term_top_most_parent($term->term_id, 'product_cat');
		}
		if(isset($top_parent) && $top_parent != ""){
			$banner_image = get_field('banner_image', $top_parent->taxonomy.'_'.$top_parent->term_id);
			$banner_title = $top_parent->name;
		}
	}
	*/
	
}
if(is_tax() || is_category() || is_tag()) {
	$current_term = $wp_query->queried_object;
	
	$banner_image = get_field('banner_image', $current_term->taxonomy.'_'.$current_term->term_id);
	$banner_title = esc_html( $current_term->name );
	
	/*
	if( (!isset($banner_image) || empty($banner_image)) && $current_term->parent != 0 ){

		$ancestors = get_ancestors( $current_term->term_id, $current_term->taxonomy );
	
		foreach ( $ancestors as $ancestor ) {
			$ancestor = get_term( $ancestor, $current_term->taxonomy );
			if($ancestor->parent == 0){
				$banner_image = get_field('banner_image', $ancestor->taxonomy.'_'.$ancestor->term_id);
				$banner_title = esc_html( $ancestor->name );
			}
		}

	}
	*/
	
}
?>
<?php if(isset($banner_image) && $banner_image != ""):?>
<div class="block-banner container clearfix">
   <img src="<?php echo $banner_image['sizes']['top-banner'];?>" alt="<?php echo $banner_title;?> Banner Image">
</div>   
<?php endif;?>