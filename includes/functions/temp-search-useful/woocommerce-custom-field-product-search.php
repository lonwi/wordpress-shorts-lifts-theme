<?php
/*
Plugin Name: WooCommerce Custom Field Product Search
Plugin URI: http://www.wpworking.com/
Description:Includes Product Custom Fields to WooCommerce Search Criteria
Version: 1.0.0
Author: Alvaro Neto
Author URI: http://www.wpworking.com/
*/
add_filter('the_posts', 'woo_custom_fields_query');
add_action( 'pre_get_posts', 'woo_add_custom_post_search' );
function woo_add_custom_post_search($query) {
	if (! is_admin() && $query->is_main_query() && $query->is_search()){
		$noIds = array(0);
		$mPosts = get_post_by_custom_field(get_search_query(), $noIds);
		echo '<pre>';
		print_r($mPosts);
		echo '</pre>';
		// Ensure filters are set
		WC()->query->unfiltered_product_ids = $global_th_posts;
		
		WC()->query->layered_nav_post__in = $global_th_post__in;
		WC()->query->filtered_product_ids = $global_th_post__in;
		//$query->set( 'cat', '123' );
	}
}
function woo_custom_fields_query($posts, $query = false) {
    if (is_search()){
		$noIds = array(0);
        foreach($posts as $post){
            $noIds[] = $post->ID;
        }
		
        $mPosts = get_post_by_custom_field(get_search_query(), $noIds);      
		
        if ($mPosts){
            foreach($mPosts as $product_id){
                $posts[] = get_post($product_id->post_id);
				$posts_ids[] =   $product_id->post_id;            
            }
        }
		
        return $posts;
    }
    return $posts;
}
//
function get_post_by_custom_field($qrval, $noIds) {
    global $wpdb, $wp_query;
    
    $pstArr = array();

    $noIdsQrl = implode(",", $noIds);
    $vrvspsts = $wpdb->get_results(
                    "
          SELECT p.post_parent as post_id FROM $wpdb->posts as p
          join $wpdb->postmeta pm
          on p.ID = pm.post_id         
          and pm.meta_value LIKE '%$qrval%'
          join $wpdb->postmeta visibility
          on p.post_parent = visibility.post_id    
          and visibility.meta_key = '_visibility'
          and visibility.meta_value <> 'hidden'
          where 1
          AND p.post_parent <> 0
          and p.ID not in ($noIdsQrl)
          and p.post_status = 'publish'
          group by p.post_parent
          "
    );

    foreach($vrvspsts as $post){
        $noIds[] = $post->post_id;
    }

    $noIdsQrl = implode(",", $noIds);

    $rglprds = $wpdb->get_results(
        "SELECT p.ID as post_id FROM $wpdb->posts as p
        join $wpdb->postmeta pm
        on p.ID = pm.post_id        
        AND pm.meta_value LIKE '%$qrval%' 
        join $wpdb->postmeta visibility
        on p.ID = visibility.post_id    
        and visibility.meta_key = '_visibility'
        and visibility.meta_value <> 'hidden'
        where 1
        and (p.post_parent = 0 or p.post_parent is null)
        and p.ID not in ($noIdsQrl)
        and p.post_status = 'publish'
        group by p.ID

");
    
    $pstArr = array_merge($vrvspsts, $rglprds);
    $wp_query->found_posts += sizeof($pstArr);    
    return $pstArr;
}
?>