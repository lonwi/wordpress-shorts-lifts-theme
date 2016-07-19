<div id="sidebar" class="threecol first">
<?php /*
if ( is_tax( 'product_cat' ) ) {
	$current_term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );

	$ancestors = array_reverse( get_ancestors( $current_term->term_id, get_query_var( 'taxonomy' ) ) );

	foreach ( $ancestors as $ancestor ) {
		$ancestor = get_term( $ancestor, get_query_var( 'taxonomy' ) );
		if($ancestor->parent == 0){
			echo '<h2 class="title"><a href="' . get_term_link( $ancestor->slug, get_query_var( 'taxonomy' ) ) . '">' . esc_html( $ancestor->name ) . '</a></h2>';
		}
	}

} elseif ( is_tax( 'product_tag' ) ) {
	$current_term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );

	$ancestors = array_reverse( get_ancestors( $current_term->term_id, get_query_var( 'taxonomy' ) ) );

	foreach ( $ancestors as $ancestor ) {
		$ancestor = get_term( $ancestor, get_query_var( 'taxonomy' ) );
		if($ancestor->parent == 0){
		echo '<h2 class="title"><a href="' . get_term_link( $ancestor->slug, get_query_var( 'taxonomy' ) ) . '">' . esc_html( $ancestor->name ) . '</a></h2>';
		}
	}
}
*/
?>
<?php if(is_tax( 'product_cat' )) {
	//$current_term = get_term_by( 'slug', get_query_var( 'term' ), 'product_cat' );
	$current_term = $wp_query->queried_object;
	
	if($current_term->parent == 0){
		
		$parent = $current_term;
		$ancestors = array();
		
	}else{
	
	$ancestors = get_ancestors( $current_term->term_id, $current_term->taxonomy );

		foreach ( $ancestors as $ancestor ) {
			$ancestor = get_term( $ancestor, $current_term->taxonomy );
			if($ancestor->parent == 0){
				$parent = $ancestor;
			}
		}
	}
}?>
<?php if(is_tax( 'product_cat' )) :?>
	
    <?php if( (isset($parent) && $parent != "") && ($parent->term_id == 28 || $parent->term_id == 33 /*|| $parent->term_id == 32*/) ):?>
    <div id="woocommerce_product_categories" class="widget woocommerce widget_product_categories">
    
        <h4 class="widgettitle"><a href="<?php echo get_term_link( $parent->slug, $parent->taxonomy );?>"><?php echo esc_html( $parent->name ); ?></a></h4>
    	<?php  
        include_once( WC()->plugin_path() . '/includes/walkers/class-product-cat-list-walker.php' );
			$list_args = array (
				'show_count' => false, 
				'hierarchical' => true,
				'taxonomy' => 'product_cat', 
				'hide_empty' => false
			);
			$list_args['walker']                     	= new WC_Product_Cat_List_Walker;
			$list_args['title_li']                   	= '';
			$list_args['pad_counts']                 	= 1;
			$list_args['show_option_none']           	= __('No product categories exist.', 'woocommerce' );
			$list_args['current_category']          	= ( $current_term ) ? $current_term->term_id : '';
			$list_args['current_category_ancestors']	= $ancestors;
			$list_args['child_of'] 						= $parent->term_id;

			echo '<ul class="product-categories">';

			wp_list_categories( $list_args );

			echo '</ul>';
		?>
    </div>
    <?php endif;?>
    
    <?php if ( is_active_sidebar( 'sidebar-shop-1' ) && $parent->term_id == 28) : ?>
    
        <?php dynamic_sidebar( 'sidebar-shop-1' ); ?>
    
    <?php endif; ?>
    
    <?php if ( is_active_sidebar( 'sidebar-shop-2' ) && $parent->term_id == 28) : ?>
    
        <?php dynamic_sidebar( 'sidebar-shop-2' ); ?>
    
    <?php endif; ?>
    
    <?php if ( is_active_sidebar( 'sidebar-shop-3' ) && $parent->term_id == 33) : ?>
    
        <?php dynamic_sidebar( 'sidebar-shop-3' ); ?>
    
    <?php endif; ?>
    
    <?php if ( is_active_sidebar( 'sidebar-shop-4' ) && $parent->term_id == 33) : ?>
    
        <?php dynamic_sidebar( 'sidebar-shop-4' ); ?>
    
    <?php endif; ?>
    
    <?php if ( is_active_sidebar( 'sidebar-shop-5' ) && $parent->term_id == 32) : ?>
    
        <?php dynamic_sidebar( 'sidebar-shop-5' ); ?>
    
    <?php endif; ?>
    
    <?php if ( is_active_sidebar( 'sidebar-shop-6' ) && $parent->term_id == 32) : ?>
    
        <?php dynamic_sidebar( 'sidebar-shop-6' ); ?>
    
    <?php endif; ?>

<?php endif;?>
    
</div> <!-- / #sidebar -->