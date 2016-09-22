<?php
/* Before Header Hooks */

add_action('websquare_before_header','websquare_before_header', 10);
function websquare_before_header(){
	get_template_part( 'includes/blocks/block', 'cookie-policy' );
	if(is_front_page()){
	}else {
	}
}

/* After Header Hooks */

add_action('websquare_after_header','websquare_after_header', 10);
function websquare_after_header(){
	if(is_front_page()){

	}else {
		if(($partent =  woo_get_ancestor()) && ($partent == 32)){
			get_template_part( 'includes/blocks/block', 'product-search' );	
			get_template_part( 'includes/blocks/block', 'breadcrumbs' );
		}else{
			if(is_product()){
				global $post;
				$terms = get_the_terms( $post->ID, 'product_cat' );
				foreach ($terms as $term) {
					$product_cat = $term;
					break;
				}
				if(isset($product_cat) && ($partent =  woo_get_ancestor($product_cat)) && ($partent == 32)){
					get_template_part( 'includes/blocks/block', 'product-search' );
					get_template_part( 'includes/blocks/block', 'banner' );	
					get_template_part( 'includes/blocks/block', 'breadcrumbs' );
				}else{

					get_template_part( 'includes/blocks/block', 'banner' );
					get_template_part( 'includes/blocks/block', 'breadcrumbs' );
				}
			}else{
				get_template_part( 'includes/blocks/block', 'banner' );
				get_template_part( 'includes/blocks/block', 'breadcrumbs' );
			}
		}
	}
}

/* Before Footer Hooks */
add_action('websquare_before_footer','websquare_before_footer', 10);
function websquare_before_footer(){

}

/* After Footer Hooks */
add_action('websquare_after_footer','websquare_after_footer', 10);
function websquare_after_footer(){
	get_template_part( 'includes/blocks/block', 'newsletter-sign-up' );
}