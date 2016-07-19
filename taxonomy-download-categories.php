<?php
$current_cat  = $wp_query->queried_object;
if(isset($current_cat) && !empty($current_cat)){
	$restricted_category = get_field('restricted_category', $current_cat);
	if( $restricted_category == true && !is_user_logged_in()){
		wp_safe_redirect( get_permalink( 7 )); exit;
	}
}
?>
<?php get_header(); ?>
<div id="content">
	
    <div class="content clearfix">	
    
        <div class="container">
        
        	<div id="main" class="clearfix" role="main">
    			<div class="download-grid clearfix">
				<?php $paged = (get_query_var('paged')) ? get_query_var('paged') : 1; $i = 0;?>
				
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                	<?php if($download = get_download_file_url($post->ID)):?>
					<div class="download-grid-item">
                    	<a href="<?php echo $download;?>" title="<?php echo get_the_title();?>" class="download-grid-item-image">
							<?php if ( has_post_thumbnail() ) :?>
                                <?php echo get_the_post_thumbnail($post->ID, array(225,225)); ?>
                            <?php else:?>
                            	<?php $image = wp_get_attachment_image_src( 213, array(225,225));?>
                                <img src="<?php echo $image[0]; ?>" alt="<?php echo get_the_title();?>">
                            <?php endif;?>
                            <h3><?php echo get_the_title();?></h3>
                        </a>
                    </div>
                    <?php endif;?>
                    <?php $i++;?>
                <?php endwhile; ?>	
                <?php else : ?>
                    <?php get_template_part( 'includes/content/content', 'not-found' ); ?>
                <?php endif; ?>
                
                </div>
                
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