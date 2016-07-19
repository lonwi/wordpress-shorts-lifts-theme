<article id="post-<?php the_ID(); ?>" <?php post_class('lift-spares-search-page clearfix'); ?>>
	
	<header class="entry-header">
		<!--<h1 class="entry-title"><?php the_title(); ?></h1>-->
	</header><!-- /entry-header -->
	<div class="entry-content">
		<?php the_content(); ?>
        <div class="row">
        <form id="lift-spares-search" class="lift-spares-search clearfix" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">

            <input type="text" name="s" value="<?php echo get_search_query();?>" id="searchfield" class="searchfield" placeholder="<?php _e('Search for Product Keywords, Product Code, Dimensions, Product Name...', GETTEXT_DOMAIN );?>">
            <input type="submit" name="" id="searchsubmit" class="searchsubmit" value="Search">

            <input type="hidden" name="product_cat" value="lift-spares">
            <input type="hidden" name="post_type" value="product">
            
        </form>
        </div>
	</div><!-- /entry-content -->
	
	<footer class="entry-footer">
		<div class="row text-center">
        	<div class="sixcol first">
            	<a href="<?php echo get_term_link( 'lift-spares', 'product_cat' );?>" class="button gray next"><?php _e('View All Products', GETTEXT_DOMAIN );?></a>
            </div>
            <div class="sixcol last">
           		<a href="<?php echo get_permalink(238);?>" class="button next"><?php _e('Filtered Search', GETTEXT_DOMAIN );?></a>
            </div>
        	
        </div>
	</footer><!-- /entry-footer -->
</article><!-- /post-<?php the_ID(); ?> -->