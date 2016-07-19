<?php
/*
Template Name: Page Search
*/
remove_action('websquare_after_header','websquare_after_header', 10);
?>
<?php get_header(); ?>
<div id="content" class="background-pattern content clearfix">
	
    <div class="clearfix">
    <?php get_template_part( 'includes/blocks/block', 'breadcrumbs' );?>
    <?php get_template_part( 'includes/blocks/block-slider', 'lift-spares' ); ?>
    </div>
    
    <div class="container">
    
        <div id="main" class="clearfix" role="main">

            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <?php get_template_part( 'includes/content/content', 'page-search' ); ?>
            <?php endwhile; ?>	
            <?php else : ?>
                <?php get_template_part( 'includes/content/content', 'not-found' ); ?>
            <?php endif; ?>
        
        </div> <!-- / #main -->
        
    </div> <!-- / .container -->

</div>  <!-- / #content -->
<?php get_footer(); ?>