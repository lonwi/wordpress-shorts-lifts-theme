<?php
/*
Template Name: Page Assisted Search
*/
remove_action('websquare_after_header','websquare_after_header', 10);
?>
<?php get_header(); ?>
<div id="content" class="background-pattern content clearfix">
	
    <div class="clearfix">
    <?php get_template_part( 'includes/blocks/block', 'banner' ); ?>
	<?php get_template_part( 'includes/blocks/block', 'breadcrumbs' );?>
    </div>
    
    <div class="container">
    
        <div id="main" class="clearfix" role="main">

            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <?php get_template_part( 'includes/content/content', 'page-assisted-search' ); ?>
            <?php endwhile; ?>	
            <?php else : ?>
                <?php get_template_part( 'includes/content/content', 'not-found' ); ?>
            <?php endif; ?>
        
        </div> <!-- / #main -->
        
    </div> <!-- / .container -->

</div>  <!-- / #content -->
<?php get_footer(); ?>