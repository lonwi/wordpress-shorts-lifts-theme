<?php
/*
Template Name: Page Account
*/
//remove_action('websquare_after_header','websquare_after_header', 10);
?>
<?php get_header(); ?>
<div id="content" class="content clearfix">

    <div class="container">
    	<?php if(is_user_logged_in()):?>
        <?php get_sidebar('account'); ?>
    	<?php endif;?>
        <div id="main" class="main account-area-main <?php if(is_user_logged_in()):?>ninecol last<?php endif;?>" role="main">

            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <?php get_template_part( 'includes/content/content', 'page-account' ); ?>
            <?php endwhile; ?>	
            <?php else : ?>
                <?php get_template_part( 'includes/content/content', 'not-found' ); ?>
            <?php endif; ?>
        
        </div> <!-- / #main -->
        
    </div> <!-- / .container -->

</div>  <!-- / #content -->
<?php get_footer(); ?>