<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
	<header class="entry-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>
	</header><!-- /entry-header -->
	<div class="entry-content">
		<?php the_content(); ?>
        
        <?php
		$taxonomy = "download-categories";
		$args = array('hide_empty' => false, 'parent' => 0);
		$terms = get_terms($taxonomy, $args);
		?>

        <?php foreach($terms as $term):?>
        
        <?php
		$restricted_category = get_field('restricted_category', $term);
		if( $restricted_category == true && !is_user_logged_in()):?>
        <div class="clearfix" style="margin:20px 0;">
        	<h4 class="title"><?php echo $term->name;?></h4>
            <div class="clearfix">
            	<div class="tencol first">
                	<?php echo $term->description;?>
                    <br><span class="bold"><a href="<?php echo get_permalink( 7 );?>">Login</a> is required for access.</span>
                </div>
                <div class="twocol last">
                	<a href="<?php echo get_permalink( 7 );?>" class="button small">Login</a>
                </div>
            </div>
        </div>
        <?php else:?>
        <div class="clearfix" style="margin:20px 0;">
        	<h4 class="title"><?php echo $term->name;?></h4>
            <div class="clearfix">
            	<div class="tencol first">
                	<?php echo $term->description;?>
                </div>
                <div class="twocol last">
                	<a href="<?php echo get_term_link( $term, $taxonomy ); ?>" class="button small">Open</a>
                </div>
            </div>
        </div>
        <?php endif;?>
        <?php endforeach;?>
        
	</div><!-- /entry-content -->
	
	<footer class="entry-footer">
		
	</footer><!-- /entry-footer -->
</article><!-- /post-<?php the_ID(); ?> -->