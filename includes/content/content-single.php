<div class="news-item news-item-large clearfix">
    <article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
        <header class="news-item-header">
            <div class="news-item-image clearfix">
            	<?php if(!is_single()):?>
                <a href="<?php echo get_permalink();?>" title="<?php echo get_the_title();?>" class="news-item-image-link">
                <?php endif;?>
                    <?php if ( has_post_thumbnail() ) :?>
                        <?php echo get_the_post_thumbnail($post->ID, 'post-thumbnails-big'); ?>
                    <?php else:?>
                        <img src="<?php echo IMAGE_PLACEHOLDER_LARGE; ?>" alt="<?php echo get_the_title();?>"></a>
                    <?php endif;?>
                <?php if(!is_single()):?>    
                </a>
                <?php endif;?>
            </div>
            <h3 class="news-item-title"><a href="<?php echo get_permalink();?>" rel="bookmark" title="<?php echo get_the_title();?>"><?php echo get_the_title();?></a></h3>
        </header>
        
        <div class="news-item-meta">Posted on <span class="green"><?php echo date('l, jS F Y', strtotime(get_the_date('Y-m-d')));?></span> in <?php the_category(', '); ?></div>
        <div class="news-item-content"><?php echo the_content();?></div>
        <footer class="news-item-footer">
        	<?php get_template_part('includes/blocks/block','social-share');?>
        </footer>
    </article>
</div>