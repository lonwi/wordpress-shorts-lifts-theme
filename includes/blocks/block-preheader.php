<div class="pre-header clearfix">
    
    <div class="container">
    
        <div class="row">
        
            <div class="pre-header-element pre-header-search">
                <a href="#searchform" title="<?php _e( 'Search the Website', GETTEXT_DOMAIN ); ?>"><span class="icon-search">&nbsp;</span> </a>
                <form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                    <input type="text" class="searchfield" name="s" id="s" placeholder="<?php _e( 'Search', GETTEXT_DOMAIN ); ?>" >
                </form>
                
                
            </div>
            
            <div class="pre-header-element pre-header-newsletter">
                <a href="#block-newsletter-sign-up" class="popup"><span class="icon-newsletter"></span> <?php _e( 'Sign up to newsletter', GETTEXT_DOMAIN); ?></a>
            </div>
            
            <div class="pre-header-element pre-header-contact">
                <a href="tel:00441274305066"><span class="icon-phone">&nbsp;</span> 01274 305066</a>
            </div>
            
            <div class="pre-header-element pre-header-account">
                 <a href="<?php echo get_permalink(7);?>"><span class="icon-lock">&nbsp;</span> Sign in / My Account</a>
            </div>
            
            <div class="pre-header-element pre-header-basket">
                <a class="cart-contents" href="<?php echo WC()->cart->get_cart_url(); ?>" title="<?php _e('View your shopping basket', GETTEXT_DOMAIN); ?>">
                    <span class="icon-basket">&nbsp;</span> Basket ( <?php echo WC()->cart->cart_contents_count;?> )
                </a>
            </div>

            
        </div>
    
    </div>
        
</div>