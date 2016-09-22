<?php 
	$defaultimage = wp_get_attachment_image_src( 70, "team-single");
	$defaultimage = $defaultimage[0];
?>
<section id="post-<?php the_ID(); ?>" <?php post_class('meet-the-team-single clearfix'); ?>>
    
    <div class="fourcol first">
    
    	<?php if ( has_post_thumbnail($post->ID) ) :?>
			<?php echo get_the_post_thumbnail($post->ID, 'team-single', array('alt' => $post->post_title)); ?>
        <?php else:?>
            <img src="<?php echo $defaultimage; ?>" alt="">
        <?php endif;?>
    	
    </div>
    
    <div class="fourcol">
    	
        <header class="entry-header">
            <h1 class="entry-title" style="margin-bottom:0;"><?php the_title(); ?></h1>
            <h4 class="green"><?php echo get_field('job_title', $post->ID);?></h4>
        </header><!-- /entry-header -->
        <div class="entry-content">
            <?php the_content(); ?>
        </div><!-- /entry-content -->
        
        <footer class="entry-footer">
           
           	<?php if( $email = get_field('email', $post->ID) ) : ?>
           	
            <div class="icon-email-url">
            	<a href="mailto:<?php echo $email;?>"><span>&nbsp;</span><?php echo $email;?></a>
            </div>
            
            <?php endif;?>
            
            <?php if( $linkedin_url = get_field('linkedin_url', $post->ID) ) : ?>
            
            <div class="icon-linkedin-url">
            	<a href="<?php echo $linkedin_url;?>" target="_blank"><span>&nbsp;</span>Find me on LinkedIn</a> 
            </div>
            
            <?php endif;?>            
            
        </footer><!-- /entry-footer -->
    
    </div>
 	<?php
	$department = get_the_terms( $post->ID, 'departments' );
	if(isset($department) && !empty($department)){
		$department = array_shift($department);
		$team_members = get_posts( array ('post_type' => 'team-member', 'posts_per_page' => -1, 'exclude' => $post->ID, 'tax_query' => array( array( 'taxonomy' => $department->taxonomy, 'field' => 'id', 'terms' => $department->term_id, 'include_children' => false )), 'post_status' => 'publish', 'orderby' => 'date title', 'order' => 'ASC' ) );
	}
	?>
    <?php if(isset($team_members) && !empty($team_members)): ?>   
    <div class="threecol last">
    	<h2 class="title"><?php _e('The Team', GETTEXT_DOMAIN);?></h2>
        <?php foreach ($team_members as $team_member):?>
        <div class="team-member clearfix">
        	<a href="<?php echo get_permalink($team_member->ID);?>">
                <span class="team-member-name clearfix"><?php echo $team_member->post_title;?></span>
                <span class="team-member-title clearfix"><?php echo get_field('job_title', $team_member->ID);?></span>
            </a>
        </div>
        <?php endforeach;?>
    </div>
    <?php endif?>
</section><!-- /post-<?php the_ID(); ?> -->