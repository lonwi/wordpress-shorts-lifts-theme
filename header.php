<?php global $woocommerce;?>
<!doctype html>
<!--[if IEMobile 7 ]> <html <?php language_attributes(); ?>class="no-js iem7"> <![endif]-->
<!--[if lt IE 7 ]> <html <?php language_attributes(); ?> class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]>    <html <?php language_attributes(); ?> class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>    <html <?php language_attributes(); ?> class="no-js ie8"> <![endif]-->
<!--[if (gte IE 9)|(gt IEMobile 7)|!(IEMobile)|!(IE)]><!--><html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->

	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<title><?php wp_title( '|', true, 'right' ); ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="apple-touch-icon" href="<?php echo THEME_ASSETS ?>images/favicons/apple-icon-touch.png">
		<link rel="icon" href="<?php echo THEME_ASSETS ?>images/favicons/favicon.png">

		<!--[if IE]>
			<link rel="shortcut icon" href="<?php echo THEME_ASSETS; ?>images/favicons/favicon.ico">
		<![endif]-->

        <meta name="msapplication-TileColor" content="#70bd0a">
		<meta name="msapplication-TileImage" content="<?php echo THEME_ASSETS ?>images/favicons/win8-tile-icon.png">

  		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
		<!-- wordpress head functions -->
		<?php wp_head(); ?>
		<!-- end of wordpress head -->

		<!-- html5.js -->
		<!--[if lt IE 9]>
			<script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7/html5shiv.min.js"></script>
		<![endif]-->

        <!-- media-queries.js (fallback) -->
		<!--[if lt IE 9]>
			<script src="//css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
		<![endif]-->

        <!--
        <?php // google analytics ?>
        <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-3780910-4', 'auto');
        ga('send', 'pageview');

        </script>
        <?php // end google analytics ?>
        -->

		<script>
            (function(h,o,t,j,a,r){
                h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
                h._hjSettings={hjid:290386,hjsv:5};
                a=o.getElementsByTagName('head')[0];
                r=o.createElement('script');r.async=1;
                r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
                a.appendChild(r);
            })(window,document,'//static.hotjar.com/c/hotjar-','.js?sv=');
        </script>

	</head>

	<body <?php body_class(); ?>>

        <?php do_action('websquare_before_header');?>

    	<header id="header">

            <?php //get_template_part('includes/blocks/block', 'preheader');?>

        	<div class="header clearfix">

            	<div class="container">

                	<div class="row">

                    	<div class="threecol first">

                        	<div id="logo" class="logo clearfix">
                                <a href="<?php echo get_bloginfo('url');?>" rel="home">
                                    <img src="<?php echo THEME_ASSETS; ?>images/logo.png" alt="<?php echo get_bloginfo('name');?> Logo">
                                </a>
                            </div>

                        </div>

                        <div class="ninecol last">

                        	<div class="header-top row">

                                <div class="eightcol first">

                                    <div class="header-search">

                                        <form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                                            <input type="text" class="searchfield" name="s" id="s" placeholder="<?php _e( 'Website Search', GETTEXT_DOMAIN ); ?>" >
                                            <input type="submit" class="submit" name="submit" id="searchsubmit" value="<?php _e( 'Search', GETTEXT_DOMAIN ); ?>" >
                                        </form>

                                    </div>

                                </div>

                                <div class="fourcol last">

                                	<div class="header-top-nav">
                                    	<nav>
                                        	<ul>
                                            	<?php if(!is_user_logged_in()):?>
                                            	<li><a href="<?php echo get_permalink(7);?>">Sign in</a></li>
                                                <li>|</li>
                                                <li><a href="<?php echo get_permalink(7);?>">Register</a></li>
                                                <?php else:?>
                                                <li><a href="<?php echo get_permalink(7);?>">My account</a></li>
                                                <li>|</li>
                                                <li><a href="<?php echo wc_get_endpoint_url('customer-logout', '', get_permalink(7));?>">Logout</a></li>
                                                <?php endif;?>
                                            </ul>
                                        </nav>
                                    </div> <!-- /.header-top-nav -->

                                    <div class="header-top-cart">

                                        <a class="cart-contents" href="<?php echo $woocommerce->cart->get_cart_url(); ?>" title="<?php _e('View your shopping basket', GETTEXT_DOMAIN); ?>">
											<?php _e('Shopping Basket', GETTEXT_DOMAIN);?> ( <?php echo $woocommerce->cart->cart_contents_count;?> )
                                        </a>

                                    </div> <!-- /.header-top-cart -->

                                </div>

                        	</div> <!-- /.header-top -->

                            <div class="header-navigation clearfix">

                                <nav role="navigation" class="clearfix">
                                    <?php wp_nav_menu( array( 'theme_location' => 'main-nav', 'depth' => 3, 'container_class' => '' ) ); ?>
                                </nav>

                        	</div> <!-- /.header-navigation -->

                        </div>

                        <div class="clearfix"></div>

                    </div> <!-- /.row -->

                </div>  <!-- /.container -->

            </div>  <!-- /.header -->

        </header>  <!-- /#header -->

        <?php do_action('websquare_after_header');?>