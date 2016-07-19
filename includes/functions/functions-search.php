<?php
/* Product Meta Search
******************************************************************/
/*add_filter('posts_where', 'advanced_search_query' );
function advanced_search_query( $where ) {
	global $wp_the_query,$wpdb;
	// If this is not a WC Query, do not modify the query
	if ( empty( $wp_the_query->query_vars['wc_query'] ) || empty( $wp_the_query->query_vars['s'] ) )
		    return $where;	
				
  	if( !is_admin() && is_search() ) {

    
    $query = get_search_query();
    $query = wpdb::esc_like( $query );

    // include postmeta in search
    $where .=" OR {$wpdb->posts}.ID IN (SELECT {$wpdb->postmeta}.post_id FROM {$wpdb->posts}, {$wpdb->postmeta} WHERE {$wpdb->postmeta}.meta_value LIKE '%$query%' AND {$wpdb->posts}.ID = {$wpdb->postmeta}.post_id)";

    // include taxonomy in search
    //$where .=" OR {$wpdb->posts}.ID IN (SELECT {$wpdb->posts}.ID FROM {$wpdb->posts},{$wpdb->term_relationships},{$wpdb->terms} WHERE {$wpdb->posts}.ID = {$wpdb->term_relationships}.object_id AND {$wpdb->term_relationships}.term_taxonomy_id = {$wpdb->terms}.term_id AND {$wpdb->terms}.name LIKE '%$query%')";


    }
    return $where;
}
*/
add_filter('posts_orderby','advanced_search_query_sort',10,2);
function advanced_search_query_sort( $orderby, $query ) {
	global $wp_the_query, $wpdb;
	// If this is not a WC Query, do not modify the query
	if ( empty( $wp_the_query->query_vars['wc_query'] ) || empty( $wp_the_query->query_vars['s'] ) )
		return $orderby;		
		
  	if( !is_admin() && is_search() ) 
		//$orderby =  $wpdb->postmeta.".meta_value LIKE '%$query%' ASC";
		$orderby = '';
	return  $orderby;
}

/* Assisted Search
******************************************************************/


function get_assisted_search(){
	
	$a = get_transient( 'get_assisted_search' );
	if( $a === false ){
		$manufacturers = get_assisted_search_terms('pa_manufacturer');
		$categories = get_assisted_search_terms('pa_product-group');
		$subcategories = get_assisted_search_terms('pa_product-category');
		
		$a = array();
		foreach($manufacturers as $manufacturer){
			foreach($categories as $category){
				if(get_assisted_search_term_products(array( $manufacturer, $category) )){
					$a[$manufacturer->slug][]= $category->term_id;
					foreach($subcategories as $subcategory){
						if(get_assisted_search_term_products(array( $manufacturer, $category, $subcategory) )){
							$a[$category->slug][]= $subcategory->term_id;
						}
					}
				}
			}
		}
		
		set_transient( 'get_assisted_search', $a, WEEK_IN_SECONDS );
	}
	
	return $a;

}
function get_assisted_search_terms($taxonomy = "", $args = ""){
	if(isset($taxonomy) && !empty($taxonomy)){
		$terms = get_transient( 'assisted-search-terms-'.$taxonomy);
		if( $terms === false ){
			$args  = array(
				//'fields' => 'ids',
				'hide_empty' => true,
			); 
			$terms = get_terms($taxonomy, $args);
			set_transient( 'assisted-search-terms-'.$taxonomy, $terms, WEEK_IN_SECONDS );
		}
		return $terms;
	}
	return false;
}

function get_assisted_search_term_products($taxterms = ""){

	if($taxterms != ""){
		
		$tax_query = array(
			'relation' => 'AND',
		);
		foreach ($taxterms as $taxterm){
			
			$tax_query[] = array(
				'taxonomy' => $taxterm->taxonomy,
				'field' => 'id',
				'terms' => $taxterm->term_id,
			);
					
		}
		
		$meta_query = array();
		$meta_query[] = WC()->query->visibility_meta_query();
		$meta_query[] = WC()->query->stock_status_meta_query();

		$args = array(
			'numberposts' 		=> 1,
			'post_type'        	=> 'product',
			'fields' 			=> 'ids',
			'no_found_rows' 	=> true,
			'post_status'		=> 'publish',
			'cache_results' 	=> false,
			'tax_query' 		=> $tax_query,
			'meta_query'     	=> $meta_query,

		);
		$product_ids = get_posts($args);
		
		if(isset($product_ids) && !empty($product_ids)){
			return $product_ids;
		}
		return false;
		
	}
	return false;
}