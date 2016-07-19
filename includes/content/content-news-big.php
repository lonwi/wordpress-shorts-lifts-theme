<div class="news-item clearfix">
    <article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
        <header>
            <div class="blog-item-image clearfix">
                <a href="<?php echo get_permalink();?>" title="<?php echo get_the_title();?>" class="">
                    <?php if ( has_post_thumbnail() ) :?>
                        <?php echo get_the_post_thumbnail($post->ID, 'medium'); ?>
                    <?php else:?>
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/default.png" alt="<?php echo get_the_title();?>"></a>
                    <?php endif;?>
                </a>
                <div class="blog-item-date bold">
                    <div class="blog-item-date-inner">
                        <?php echo date('jS',strtotime(get_the_date('Y-m-d')));?><br /><?php echo date('M',strtotime(get_the_date('Y-m-d')));?>
                    </div>
                </div>
            </div>
            <h3 class="blog-item-title"><a href="<?php echo get_permalink();?>" rel="bookmark" title="<?php echo get_the_title();?>"><?php echo get_the_title();?></a></h3>
           <?php get_template_part( 'inc/blog-meta' ); ?>
            
        </header>
        <div class="blog-item-excerpt"><?php echo get_the_excerpt();?></div>
        <a href="<?php echo get_permalink(); ?>" rel="bookmark" title="<?php echo get_the_title();?>" class="btn btn-bg-no btn-arrow-blue">Read more</a>
    </article>
</div>
