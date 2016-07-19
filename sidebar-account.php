<div id="sidebar" class="sidebar-account threecol first">
   	<?php if(is_user_logged_in()){?>
    <?php 
	$current_user = wp_get_current_user();
	$user_id = $current_user->ID;
	$current_user_meta = get_user_meta($user_id);
	?>
    
    <div class="account-navigation sidebar-block clearfix">
    	<h4 class="sidebar-title"><?php _e('Account Settings','shorts');?></h4>
    
    	<?php if ( has_nav_menu( 'account-nav' ) ) : ?>
        	<?php 
        	wp_nav_menu(array(
                'theme_location' => 'account-nav',
                'menu_class'     => 'sidebar-nav',
                'depth' => 0,
            ));
			?>
       
        <?php endif; ?>
    
    </div><!-- /.account-navigation -->
    
    <div class="user-details sidebar-block clearfix">
    	<h4 class="sidebar-title"><?php _e('Account Details','shorts');?></h4>
    	<p><span class="semi-bold"><?php _e('Onilne Account ID','shorts');?></span><br><?php echo $user_id;?></p>
        <p><span class="semi-bold"><?php _e('Name','shorts');?></span><br><?php echo $current_user->user_firstname; ?> <?php echo $current_user->user_lastname; ?></p>
        <p><span class="semi-bold"><?php _e('Company Name','shorts');?></span><br><?php echo get_user_meta($user_id, 'company', true); ?></p>
        <?php if($branch = get_user_meta($user_id, 'branch', true)):?>
        <p><span class="semi-bold"><?php _e('Branch Name','shorts');?></span><br><?php echo $branch; ?></p>
        <?php endif;?>
        <p><span class="semi-bold"><?php _e('Phone Number','shorts');?></span><br><?php echo get_user_meta($user_id, 'phone', true); ?></p>
        <p><span class="semi-bold"><?php _e('Email','shorts');?></span><br><?php echo $current_user->user_email;?></p>
    </div>
    
    <?php if ( is_active_sidebar( 'sidebar-account' ) ) : ?>

        <?php dynamic_sidebar( 'sidebar-account' ); ?>
        
    <?php endif; ?>	
   	<?php } ?>
   
</div> <!-- / #sidebar -->