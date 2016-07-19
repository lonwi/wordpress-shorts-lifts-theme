<div class="block-product-search clearfix">
	<div class="container">
    	
        <div class="twocol first">
        	<span class="block-product-search-label"><?php _e('Search Product', 'shorts' );?></span>
    	</div>
        
        <div class="sixcol">
            <form id="lift-spares-search" class="lift-spares-search clearfix" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    
                <input type="text" name="s" value="<?php echo get_search_query();?>" id="searchfield" class="searchfield" placeholder="<?php _e('Search for Lift Spares...', 'shorts' );?>">
                <input type="submit" name="" id="searchsubmit" class="searchsubmit" value="Search">
    
                <input type="hidden" name="product_cat" value="lift-spares">
                <input type="hidden" name="post_type" value="product">
                
            </form>
        </div>
        
        <div class="fourcol last text-right">
        	<a href="<?php echo get_permalink(238);?>" class="block-product-search-link"><span class="black"><?php _e('Click to try our', 'shorts' );?></span> <?php _e('Filtered Search', 'shorts' );?></a>
    	</div>
        
    </div>
</div>