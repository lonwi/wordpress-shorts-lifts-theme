<?php wc_print_notices();?>
<div id="post-<?php the_ID(); ?>" <?php post_class('contact-page clearfix'); ?>>
	<div class="contact-details clearfix">
        	
            <div class="row">
				<h2 class="title"><?php _e('Shorts Northern Office', GETTEXT_DOMAIN);?></h2>
                
                <div class="sevencol first">
                	<div class="google-map clearfix">
                    	<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2356.176667358871!2d-1.7526149999999767!3d53.80414!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x487be1511f5d153b%3A0xd20c50da7a3199eb!2sShorts+Lifts!5e0!3m2!1sen!2suk!4v1404229738502" width="550" height="480" frameborder="0" style="border:0;"></iframe>
                    </div>
                </div>
                
                <div class="fivecol last">
                
                	<div class="row">
                    	
                         <img src="<?php echo THEME_ASSETS; ?>images/shorts-office-bradford.jpg" alt="<?php _e('Shorts Northern Office', GETTEXT_DOMAIN);?>">
                                            	
                    </div>
                    
                    <div class="row">
                        <div class="fourcol first">
                        	<?php _e('Mailing Address:', GETTEXT_DOMAIN);?>
                        </div>
                        
                        <div class="eightcol last">
                        	PO Box 258,<br>Bradford, BD2 1QR
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="fourcol first">
                        	<?php _e('Branch Address:', GETTEXT_DOMAIN);?>
                        </div>
                        
                        <div class="eightcol last">
                        	15 Kings Gate,<br>Bradford Business Park,<br>Canal Road,<br>Bradford, BD1 4SJ
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="fourcol first">
                        	<?php _e('Phone:', GETTEXT_DOMAIN);?>
                        </div>
                        
                        <div class="eightcol last">
                        	01274 305066
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="fourcol first">
                        	<?php _e('Fax:', GETTEXT_DOMAIN);?>
                        </div>
                        
                        <div class="eightcol last">
                        	01274 736212
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="fourcol first">
                        	<?php _e('Email:', GETTEXT_DOMAIN);?>
                        </div>
                        
                        <div class="eightcol last">
                        	<a href="mailto:info@shorts-lifts.co.uk">info@shorts-lifts.co.uk</a>
                        </div>
                    </div>
                
                </div>
                
            </div><!-- /.row -->
            
            
            <div class="row">
				<h2 class="title"><?php _e('Shorts Southern Office', GETTEXT_DOMAIN);?></h2>
                
                <div class="sevencol first">
                	<div class="google-map clearfix">
                    	<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2484.1714045304275!2d-0.059565999999999994!3d51.491721999999996!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x487603179b9cf8d5%3A0xb6900ec35f7556d2!2sShorts+Industries+Ltd!5e0!3m2!1sen!2suk!4v1443178547853" width="550" height="480" frameborder="0" style="border:0" allowfullscreen></iframe>
                    </div>
                </div>
                
                <div class="fivecol last">
                
                	<div class="row">
                    	
                         <img src="<?php echo THEME_ASSETS; ?>images/shorts-office-south.jpg" alt="<?php _e('Shorts Southern Office', GETTEXT_DOMAIN);?>">
                                            	
                    </div>
                    
                    <div class="row">
                        <div class="fourcol first">
                        	<?php _e('Branch Address:', GETTEXT_DOMAIN);?>
                        </div>
                        
                        <div class="eightcol last">
                        	17 Almond Road,<br> London,<br>SE16 3LR
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="fourcol first">
                        	<?php _e('Phone:', GETTEXT_DOMAIN);?>
                        </div>
                        
                        <div class="eightcol last">
                        	020 7394 3080
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="fourcol first">
                        	<?php _e('Fax:', GETTEXT_DOMAIN);?>
                        </div>
                        
                        <div class="eightcol last">
                        	020 7394 3089
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="fourcol first">
                        	<?php _e('Email:', GETTEXT_DOMAIN);?>
                        </div>
                        
                        <div class="eightcol last">
                        	<a href="mailto:info@shorts-southern.co.uk">info@shorts-southern.co.uk</a>
                        </div>
                    </div>
                
                </div>
                
            </div><!-- /.row -->
            
            
            <div class="row">
            	<header class="entry-header">
                    <h2 class="entry-title"><?php _e('Enquire Now', GETTEXT_DOMAIN);?></h2>
                </header><!-- /entry-header -->
                
                <div class="entry-content">
                    <?php the_content();?>
                </div><!-- /entry-content -->
                
                <footer class="entry-footer">
                	<?php get_template_part('includes/forms/form', 'contact-us');?>
                </footer><!-- /entry-footer -->
            </div>

    </div>

</div><!-- /post-<?php the_ID(); ?> -->