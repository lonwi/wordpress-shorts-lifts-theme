<div class="block-breadcrumbs container clearfix">

<?php

global $post, $wp_query, $current_user;

$prepend      	= '';
$delimiter		= '<span class="separator"> &rsaquo; </span>';
$wrap_before    = '<nav class="woocommerce-breadcrumb breadcrumbs" itemprop="breadcrumb">';
$wrap_after     = '</nav>';
$before      	= '';
$after      	= '';
$home      		=  _x( 'Home', 'breadcrumb', 'woocommerce' );

if ( ( ! is_home() && ! is_front_page() && ! ( is_post_type_archive() && get_option( 'page_on_front' ) == wc_get_page_id( 'shop' ) ) ) || is_paged() ) {

	echo $wrap_before;

	if ( ! empty( $home ) ) {
		echo $before . '<a class="home" href="' . apply_filters( 'woocommerce_breadcrumb_home_url', home_url() ) . '">' . $home . '</a>' . $after . $delimiter;
	}

	if ( is_category() ) {

		echo $before . '<a href="' . get_permalink( 13 ) . '">' . get_the_title( 13 ) . '</a>' . $after . $delimiter;
		
		$cat_obj = $wp_query->get_queried_object();
		$this_category = get_category( $cat_obj->term_id );

		if ( $this_category->parent != 0 ) {
			$parent_category = get_category( $this_category->parent );
			echo get_category_parents($parent_category, TRUE, $delimiter );
		}

		echo $before . single_cat_title( '', false ) . $after;
	} elseif ( is_tax( 'download-categories' ) ) {
		
		echo $prepend;

		$current_term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );

		$ancestors = array_reverse( get_ancestors( $current_term->term_id, get_query_var( 'taxonomy' ) ) );
		
		echo $before . '<a href="'.get_permalink(19).'">'.get_the_title(19). '</a>' . $after . $delimiter;

		foreach ( $ancestors as $ancestor ) {
			$ancestor = get_term( $ancestor, get_query_var( 'taxonomy' ) );

			echo $before .  '<a href="' . get_term_link( $ancestor->slug, get_query_var( 'taxonomy' ) ) . '">' . esc_html( $ancestor->name ) . '</a>' . $after . $delimiter;
		}
		
		echo $before . esc_html( $current_term->name ) . $after;
		
	} elseif ( is_tax( 'product_cat' ) ) {

		echo $prepend;

		$current_term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );

		$ancestors = array_reverse( get_ancestors( $current_term->term_id, get_query_var( 'taxonomy' ) ) );

		foreach ( $ancestors as $ancestor ) {
			$ancestor = get_term( $ancestor, get_query_var( 'taxonomy' ) );

			echo $before .  '<a href="' . get_term_link( $ancestor->slug, get_query_var( 'taxonomy' ) ) . '">' . esc_html( $ancestor->name ) . '</a>' . $after . $delimiter;
		}
		
		if($current_term->slug == 'lift-spares'){
			if(is_search()){
				echo $before . '<a href="'.get_permalink(236).'">'.esc_html( $current_term->name ). '</a>' . $after . $delimiter;
				
				echo $before . __( 'Search Results for &ldquo;', 'woocommerce' ) . get_search_query() . '&rdquo;' . $after;
			}else{
				echo $before . '<a href="'.get_permalink(236).'">'.esc_html( $current_term->name ). '</a>' . $after . $delimiter;
				
				echo $before . 'Search Results' . $after;
			}
		}else{
			echo $before . esc_html( $current_term->name ) . $after;
		}
	} elseif ( is_tax( 'product_tag' ) ) {

		$queried_object = $wp_query->get_queried_object();
		echo $prepend . $before . __( 'Products tagged &ldquo;', 'woocommerce' ) . $queried_object->name . '&rdquo;' . $after;

	} elseif ( is_day() ) {

		echo $before . '<a href="' . get_year_link( get_the_time( 'Y' ) ) . '">' . get_the_time( 'Y' ) . '</a>' . $after . $delimiter;
		echo $before . '<a href="' . get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ) . '">' . get_the_time( 'F' ) . '</a>' . $after . $delimiter;
		echo $before . get_the_time( 'd' ) . $after;

	} elseif ( is_month() ) {

		echo $before . '<a href="' . get_year_link( get_the_time( 'Y' ) ) . '">' . get_the_time( 'Y' ) . '</a>' . $after . $delimiter;
		echo $before . get_the_time( 'F' ) . $after;

	} elseif ( is_year() ) {

		echo $before . get_the_time( 'Y' ) . $after;

	} elseif ( is_post_type_archive( 'product' ) && get_option( 'page_on_front' ) !== wc_get_page_id( 'shop' ) ) {

		$_name = wc_get_page_id( 'shop' ) ? get_the_title( wc_get_page_id( 'shop' ) ) : '';

		if ( ! $_name ) {
			$product_post_type = get_post_type_object( 'product' );
			$_name = $product_post_type->labels->singular_name;
		}

		if ( is_search() ) {

			echo $before . '<a href="' . get_post_type_archive_link( 'product' ) . '">' . $_name . '</a>' . $delimiter . __( 'Search results for &ldquo;', 'woocommerce' ) . get_search_query() . '&rdquo;' . $after;

		} elseif ( is_paged() ) {

			echo $before . '<a href="' . get_post_type_archive_link( 'product' ) . '">' . $_name . '</a>' . $after;

		} else {

			echo $before . $_name . $after;

		}

	} elseif ( is_single() && ! is_attachment() ) {

		if ( get_post_type() == 'product' ) {

			echo $prepend;

			if ( $terms = wc_get_product_terms( $post->ID, 'product_cat', array( 'orderby' => 'parent', 'order' => 'DESC' ) ) ) {

				$main_term = $terms[0];
				
				if($main_term->term_id == 32){
					echo $before . '<a href="'.get_permalink(236).'">Lift Spares</a>' . $after . $delimiter;
					
					if(wp_get_referer() && strpos(wp_get_referer(),'product_cat=lift-spares') !== false){
						echo $before . '<a href="' . wp_get_referer() . '">' . __('Search Results','shorts') . '</a>' . $after . $delimiter;
					}else{
						echo $before . '<a href="' . get_term_link( $main_term->slug, 'product_cat' ) . '">' . __('Search Results','shorts') . '</a>' . $after . $delimiter;
					}
				}else{

					$ancestors = get_ancestors( $main_term->term_id, 'product_cat' );
	
					$ancestors = array_reverse( $ancestors );
	
					foreach ( $ancestors as $ancestor ) {
						$ancestor = get_term( $ancestor, 'product_cat' );
	
						if ( ! is_wp_error( $ancestor ) && $ancestor )
							echo $before . '<a href="' . get_term_link( $ancestor->slug, 'product_cat' ) . '">' . $ancestor->name . '</a>' . $after . $delimiter;
					}
	
					echo $before . '<a href="' . get_term_link( $main_term->slug, 'product_cat' ) . '">' . $main_term->name . '</a>' . $after . $delimiter;
				}

			}

			echo $before . get_the_title() . $after;

		} elseif ( get_post_type() == 'team-member' ) {
			
			echo $before . '<a href="' . get_permalink( 15 ) . '">' . get_the_title( 15 ) . '</a>' . $after . $delimiter;
			
			echo $before . '<a href="' . get_permalink( 17 ) . '">' . get_the_title( 17 ) . '</a>' . $after . $delimiter;
			
			echo $before . get_the_title() . $after;
			
		} elseif ( get_post_type() != 'post' ) {

			$post_type = get_post_type_object( get_post_type() );
			$slug = $post_type->rewrite;
				echo $before . '<a href="' . get_post_type_archive_link( get_post_type() ) . '">' . $post_type->labels->singular_name . '</a>' . $after . $delimiter;
			echo $before . get_the_title() . $after;

		} elseif( get_post_type() == 'post' ) {
			
			echo $before . '<a href="' . get_permalink( 13 ) . '">' . get_the_title( 13 ) . '</a>' . $after . $delimiter;
			
			echo $before . get_the_title() . $after;
		
		} else {
			
			//echo $before . '<a href="' . get_permalink( 13 ) . '">' . get_the_title( 13 ) . '</a>' . $after . $delimiter;
			$cat = current( get_the_category() );
			echo get_category_parents( $cat, true, $delimiter );
			echo $before . get_the_title() . $after;

		}

	} elseif ( is_404() ) {

		echo $before . __( 'Error 404', 'woocommerce' ) . $after;

	} elseif ( ! is_single() && ! is_page() && get_post_type() != 'post' && !is_search() ) {

		$post_type = get_post_type_object( get_post_type() );

		if ( $post_type )
			echo $before . $post_type->labels->singular_name . $after;

	} elseif ( is_attachment() ) {

		$parent = get_post( $post->post_parent );
		$cat = get_the_category( $parent->ID );
		if($cat){
			$cat = $cat[0];
			echo get_category_parents( $cat, true, '' . $delimiter );
		}
		echo $before . '<a href="' . get_permalink( $parent ) . '">' . $parent->post_title . '</a>' . $after . $delimiter;
		echo $before . get_the_title() . $after;

	} elseif ( is_page() && !$post->post_parent ) {
		
		if(is_wc_endpoint()){
			echo $before . '<a href="' . get_permalink($post->ID) . '">'. get_the_title() . '</a>' . $after . $delimiter;
			if(is_wc_endpoint('order-pay')){
				echo $before . __('Pay','shorts') . $after;
			}
			if(is_wc_endpoint('order-received')){
				echo $before . __('Order Received','shorts') . $after;
			}
			if(is_wc_endpoint('add-payment-method')){
				echo $before . __('Add Payment Method','shorts') . $after;
			}
			if(is_wc_endpoint('view-order')){
				echo $before . __('View Order','shorts') . $after;
			}
			if(is_wc_endpoint('edit-account')){
				echo $before . __('Edit Account','shorts') . $after;
			}
			if(is_wc_endpoint('edit-address')){
				if(empty($wp->query_vars['edit-address'])){
					echo $before . __('Edit Address Information','shorts') . $after;
				}else{
					echo $before . '<a href="' . get_permalink($post->ID) . 'edit-address/">'.  __('Edit Address Information','shorts') . '</a>' . $after . $delimiter;
					if($wp->query_vars['edit-address'] === 'shipping'){
						echo $before . __('Edit Shipping Address','shorts') . $after;
					}elseif($wp->query_vars['edit-address'] === 'billing'){
						echo $before . __('Edit Billing Address','shorts') . $after;
					}elseif($wp->query_vars['edit-address'] === 'add-new-address'){
						echo $before . __('Add New Address','shorts') . $after;
					}else{
						if($addressname = get_user_meta( $current_user->ID, 'multiple_customer_' . $wp->query_vars['edit-address']. '_adresses_name', true )){
							echo $before .sprintf(__( 'Edit %s Address', 'woocommerce' ), $addressname) . $after;
						}
					}
				}
			}
			if(is_wc_endpoint('lost-password')){
				echo $before . __('Lost Password','shorts') . $after;
			}
			if(is_wc_endpoint('customer-logout')){
				echo $before . __('Customer Logout','shorts') . $after;
			}
			
		}else{
			echo $before . get_the_title() . $after;
		}

	} elseif ( is_page() && $post->post_parent ) {

		$parent_id  = $post->post_parent;
		$breadcrumbs = array();

		while ( $parent_id ) {
			$page = get_page( $parent_id );
			$breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title( $page->ID ) . '</a>';
			$parent_id  = $page->post_parent;
		}

		$breadcrumbs = array_reverse( $breadcrumbs );

		foreach ( $breadcrumbs as $crumb )
			echo $crumb . '' . $delimiter;

		echo $before . get_the_title() . $after;

	} elseif ( is_search() ) {

		echo $before . __( 'Search results for &ldquo;', 'woocommerce' ) . get_search_query() . '&rdquo;' . $after;

	} elseif ( is_tag() ) {
		
			echo $before . '<a href="' . get_permalink( 13 ) . '">' . get_the_title( 13 ) . '</a>' . $after . $delimiter;

			echo $before . __( 'Posts tagged &ldquo;', 'woocommerce' ) . single_tag_title('', false) . '&rdquo;' . $after;

	} elseif ( is_author() ) {

		$userdata = get_userdata($author);
		echo $before . __( 'Author:', 'woocommerce' ) . ' ' . $userdata->display_name . $after;

	}

	if ( get_query_var( 'paged' ) )
		echo ' (' . __( 'Page', 'woocommerce' ) . ' ' . get_query_var( 'paged' ) . ')';

	echo $wrap_after;

}
?>
</div>