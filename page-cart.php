<?php
/*
Template Name: Page Basket
*/
//remove_action('websquare_after_header','websquare_after_header', 10);
wc_member_only();
?>
<?php get_header(); ?>
<div id="content" class="content clearfix">

    <div class="container">
    
        <div id="main" class="clearfix" role="main">

            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <?php get_template_part( 'includes/content/content', 'page' ); ?>
            <?php endwhile; ?>	
            <?php else : ?>
                <?php get_template_part( 'includes/content/content', 'not-found' ); ?>
            <?php endif; ?>
        
        </div> <!-- / #main -->
        
    </div> <!-- / .container -->

</div>  <!-- / #content -->
<?php get_footer(); ?>