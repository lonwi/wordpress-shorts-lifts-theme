<?php
/*
Template Name: Page News
*/
?>
<?php get_header(); ?>
<div id="content" class="content clearfix">	
    
    <div class="container">
    
        <?php get_sidebar('news'); ?>
    
        <div id="main" class="ninecol last" role="main">

            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                
            <?php endwhile; ?>	
            <?php endif; ?>
            
            <?php 
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
            if($paged > 1){
                $per_page = 5;
            }else{
                $per_page = 5;
            }
            $args = array( 'post_type' => 'post', 'post_status' => 'publish', 'posts_per_page' => $per_page, 'orderby' => 'date', 'order' => 'DESC', 'paged' => $paged);
            $my_query = null; $my_query = new WP_Query($args);
            $i = 0;
            if( $my_query->have_posts() ) :?>
            
                <?php while ($my_query->have_posts()) : $my_query->the_post(); ?>
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
                <?php endwhile;?>
            <?php endif;?>
            
            <?php if($my_query->max_num_pages > 1):?>
            <div class="after-loop-container clearfix">
            <?php if (function_exists("custom_pagination")) custom_pagination($my_query->max_num_pages, '2');?>
            </div>
            <?php endif;?>
            
            <?php wp_reset_query();?>
        
        </div> <!-- / #main -->
        
    </div> <!-- / .container -->

</div>  <!-- / #content -->
<?php get_footer(); ?>