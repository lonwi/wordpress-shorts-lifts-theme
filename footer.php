        <?php do_action('websquare_before_footer');?> 
        <footer id="footer" role="contentinfo">
        	
            <div class="footer clearfix">
            
            	<div class="container">
                
                    <div class="row">
                    
                    	<div class="ninecol first">             
                    
                            <nav role="navigation" class="clearfix">
                                <?php wp_nav_menu( array( 'theme_location' => 'footer-links', 'depth' => 1, 'container_class' => '' ) ); ?>
                            </nav>
                        
                        </div>
                        
                        <div class="threecol last">
                        	<div class="footer-newsletter">
                            	<a href="#block-newsletter-sign-up" class="popup"><span class="icon-newsletter"></span> <?php _e( 'Sign up to newsletter', 'shorts'); ?></a>
                            </div>
                        	<div class="footer-social clearfix">
                            
                            	<a href="https://www.youtube.com/user/Shortslifts" class="youtube" target="_blank" title="YouTube">YouTube</a>
                                
                                <a href="https://plus.google.com/102356191488686020864" class="google" target="_blank" title="Google+">Google+</a>
                                
                                <a href="https://twitter.com/shortslifts" class="twitter" target="_blank" title="Twitter">Twitter</a>
                                
                                <a href="https://www.facebook.com/pages/Shorts-Lifts/148560358545182" class="facebook" target="_blank" title="Facebook">Facebook</a>
                                
                                <a href="https://www.linkedin.com/company/shorts-lifts" class="linkedin" target="_blank" title="LinkedIn">LinkedIn</a>
                            
                            </div>
                        
                        </div>
                    
                    </div> <!-- /.row -->
                    
                    <div class="row">
                    
                    	<div class="eightcol first">
                        
                        	<p class="source-org copyright">&copy; <span class="bold"><?php echo date('Y'); ?> <?php _e('Shorts Industries Limited', 'shorts');?></span>.</p>
                            
                            <p class="company-reg-info"><?php _e('Registered in England No 1670669. Registered Office Address: 15 Kings Gate, Bradford Business Park, Bradford, BD1 4SJ', 'shorts');?></p>
                            
                            <p class="cookie-policy-footer"><a href="<?php echo get_permalink( 138 );?>"><?php echo get_the_title( 138 );?></a> | <a href="<?php echo get_permalink( 21 );?>"><?php echo get_the_title( 21 );?></a></p>
                            
                        
                        </div>
                        
                        <div class="fourcol last">
                        
                        	
                            <p><img src="<?php echo THEME_ASSETS ?>images/footer-iso-logos.png" alt="ISO 14001, ISO 9001, LEIA member" class="black-and-white"></p>
                            
                            <p class="websquare-logo"><a href="http://www.websquare.co.uk/" target="_blank" title="Websquare - Web Design Bradford"><img src="<?php echo THEME_ASSETS ?>images/websquare-credit-logo.png" alt="Websquare Creative Digital Agency Logo"></a></p>
                        
                        </div>
                    
                    </div> <!-- /.row -->
                
                </div>  <!-- /.container -->
            
            </div>  <!-- /.footer -->
		
        </footer>  <!-- /#footer -->
		<?php do_action('websquare_after_footer');?>
		<?php wp_footer(); // js scripts are inserted using this function ?>
	</body>
</html>