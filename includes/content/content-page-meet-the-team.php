<?php $members = get_posts(array( 'post_type' => 'team-member', 'posts_per_page' => -1, 'post_status' => 'publish', 'orderby' => 'date title', 'order' => 'ASC'));?>
<?php $departments = get_terms( 'departments', array() );?>
<?php 
	$defaultimage = wp_get_attachment_image_src( 70, "team-list");
	$defaultimage = $defaultimage[0];
?>

<section id="post-<?php the_ID(); ?>" <?php post_class('meet-the-team-page clearfix'); ?>>
	
    <div class="filter-options team-member-list-filters clearfix">
    		
            <a href="#all" data-group="all" class="filter-all active">All</a>
        	
		<?php foreach($departments as $department):?>
        
        	<a href="#<?php echo $department->slug;?>" data-group="<?php echo $department->slug;?>" class="filter-<?php echo $department->slug;?>"><?php echo $department->name;?></a>
        
		<?php endforeach;?>
    
    </div><!-- /filter-options -->
    
    <div class="team-member-list clearfix">	
    	<?php $department = "";?>
    	<?php foreach($members as $member):?>
        <?php $department = array_shift(get_the_terms( $member->ID, 'departments' ));?>	
        <div class="team-member-list-item" data-groups='["all","<?php echo $department->slug;?>"]'>
        	<a href="<?php echo get_permalink($member->ID);?>">
				<div class="team-member-list-item-image">
                	<?php if ( has_post_thumbnail($member->ID) ) :?>
                        <?php echo get_the_post_thumbnail($member->ID, 'team-list', array('alt' => $member->post_title)); ?>
                    <?php else:?>
                        <img src="<?php echo $defaultimage; ?>" alt="Shorts Placeholder Image">
                    <?php endif;?>

                </div>
				<div class="team-member-list-item-name"><?php echo $member->post_title;?></div>
				<div class="team-member-list-item-title"><?php echo get_field('job_title', $member->ID);?></div>
            </a>
        </div>
    	<?php endforeach;?>
    </div>
	

	<footer class="entry-footer">
		
	</footer>
</section><!-- /post-<?php the_ID(); ?> -->