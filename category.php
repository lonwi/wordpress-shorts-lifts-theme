<?php get_header(); ?>
<div id="content">
	
    <div class="content clearfix">	
    
        <div class="container">
        
        	<?php get_sidebar('news'); ?>
        
        	<div id="main" class="ninecol last" role="main">
    			<?php $paged = (get_query_var('paged')) ? get_query_var('paged') : 1; $i = 0;?>
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                    <?php if($paged == 1):?>
						<?php if($i == 0):?>
                        <?php get_template_part( 'includes/content/content', 'page-news-item' ); ?>
                        <?php else:?>
                        <div class="sixcol <?php if($i&1):?>first<?php else:?>last<?php endif;?>">
                            <?php get_template_part( 'includes/content/content', 'page-news-item-small' ); ?>
                        <?php endif;?>
                        
                        
                        <?php if($i == 0):?>
                        <div class="clearfix"></div>
                        <?php else:?>
                        </div>
                        
                        <?php if($i&1):?><?php else:?><div class="clearfix"></div><?php endif;?>
                        <?php endif;?>
                    <?php else:?>
                        <?php get_template_part( 'includes/content/content', 'page-news-item' ); ?>
                    <?php endif;?>
                    <?php $i++;?>
                <?php endwhile; ?>	
                <?php else : ?>
                    <?php get_template_part( 'includes/content/content', 'not-found' ); ?>
                <?php endif; ?>
                
                <?php if($wp_query->max_num_pages > 1):?>
                <div class="after-loop-container clearfix">
				<?php if (function_exists("custom_pagination")) custom_pagination($wp_query->max_num_pages, '1');?>
                </div>
                <?php endif;?>
            
            </div> <!-- / #main -->
            
        </div> <!-- / .container -->
    
    </div>  <!-- / .content -->

</div>  <!-- / #content -->
<?php get_footer(); ?>