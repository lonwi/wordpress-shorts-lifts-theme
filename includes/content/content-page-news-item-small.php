<div class="news-item news-item-small clearfix">
    <article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
        <header class="news-item-header">
            <div class="news-item-image clearfix">
                <a href="<?php echo get_permalink();?>" title="<?php echo get_the_title();?>" class="">
                    <?php if ( has_post_thumbnail() ) :?>
                        <?php echo get_the_post_thumbnail($post->ID, 'post-thumbnail'); ?>
                    <?php else:?>
                        <img src="<?php echo IMAGE_PLACEHOLDER_SMALL; ?>" alt="<?php echo get_the_title();?>"></a>
                    <?php endif;?>
                </a>
            </div>
            <h4 class="news-item-title"><a href="<?php echo get_permalink();?>" rel="bookmark" title="<?php echo get_the_title();?>"><?php echo get_the_title();?></a></h4>
        </header>
        
        <div class="news-item-meta">Posted on <span class="green"><?php echo date('l, jS F Y', strtotime(get_the_date('Y-m-d')));?></span> in <?php the_category(', '); ?></div>
        <div class="news-item-excerpt"><?php echo truncate(get_the_excerpt(), 140);?></div>
        <footer class="news-item-footer">
        	<a href="<?php echo get_permalink(); ?>" rel="bookmark" title="<?php echo get_the_title();?>" class="button gray next">Read more</a>
        </footer>
    </article>
</div>