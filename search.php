<?php get_header(); ?>
<div id="content" class="content clearfix">
    
    <div class="container">
    
        <div id="main" class="clearfix" role="main">

            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <?php get_template_part( 'includes/content/content', 'search' ); ?>
            <?php endwhile; ?>	
            <?php else : ?>
                <?php get_template_part( 'includes/content/content', 'not-found' ); ?>
            <?php endif; ?>
            
            <?php if($wp_query->max_num_pages > 1):?>
            <div class="after-loop-container clearfix">
            <?php if (function_exists("custom_pagination")) custom_pagination($wp_query->max_num_pages, '2');?>
            </div>
            <?php endif;?>
        
        </div> <!-- / #main -->
        
    </div> <!-- / .container -->

</div>  <!-- / #content -->
<?php get_footer(); ?>