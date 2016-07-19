<?php
/*
Template Name: Page Assisted Search
*/
remove_action('websquare_after_header','websquare_after_header', 10);
?>
<?php get_header(); ?>
<div id="content" class="background-pattern">
	
    <div class="content clearfix">	
    
        <div class="container">
        
        	<div id="main" class="clearfix" role="main">
    
    			<article id="post-404" class="clearfix">
                	
                    <div class="row">
                    
                        <div class="fourcol first">
                            <header class="entry-header">
                                <h1 class="entry-title"><?php _e("404!", GETTEXT_DOMAIN); ?></h1>
                            </header><!-- /entry-header -->
                        </div>
                        <div class="eightcol last">
                            <div class="entry-content">
                                <p class="semi-bold"><?php _e("Sorry this page doesn't exist.", GETTEXT_DOMAIN); ?></p>
                                <p><?php _e("We searched high and low but couldn't<br>find the page you were looking for!", GETTEXT_DOMAIN); ?></p>
                            </div><!-- /entry-content -->
                        </div>
                    
                    </div>
                    
                    <footer class="entry-footer">
                        <p class="text-center"><?php _e("Click on one of the below sections to help you on your way...", GETTEXT_DOMAIN); ?></p>
                        
                        <?php get_template_part('includes/blocks/block', 'section-boxes');?>
                        
                        <?php /*
                        <div class="row">
							
                            <div class="fourcol first">
                            	<a href="<?php echo get_term_link( 'complete-lifts', 'product_cat' );?>" title="<?php _e('Complete Lifts', GETTEXT_DOMAIN );?>">
                                	<img src="<?php echo THEME_ASSETS;?>images/404-boxes/complete-lifts.jpg" alt="<?php _e('Complete Lifts Banner', GETTEXT_DOMAIN );?>" class="">
                                </a>
                            </div>
                            
                            <div class="fourcol">
                            	<a href="<?php echo get_term_link( 'lift-components', 'product_cat' );?>" title="<?php _e('Lift Components', GETTEXT_DOMAIN );?>">
                                	<img src="<?php echo THEME_ASSETS;?>images/404-boxes/lift-components.jpg" alt="<?php _e('Complete Lifts Banner', GETTEXT_DOMAIN );?>" class="">
                                </a>
                            </div>
                            
                            <div class="fourcol last">
                            	<a href="<?php echo get_permalink(236);?>" title="<?php _e('Lift Spares', GETTEXT_DOMAIN );?>">
                                	<img src="<?php echo THEME_ASSETS;?>images/404-boxes/lift-spares.jpg" alt="<?php _e('Complete Lifts Banner', GETTEXT_DOMAIN );?>" class="">
                                </a>
                            </div>
                            
                        
                        </div> <!-- /.row -->
						*/?>
                        
                    </footer><!-- /entry-footer -->
                
                </article>
            
            </div> <!-- / #main -->
            
        </div> <!-- / .container -->
    
    </div>  <!-- / .content -->

</div>  <!-- / #content -->
<?php get_footer(); ?>