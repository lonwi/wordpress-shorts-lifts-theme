<?php
$theme_version = '1.0.10';

add_action( 'after_setup_theme', 'websquare_theme_setup', 16 );
function websquare_theme_setup () {
	add_action( 'init', 'websquare_head_cleanup' );
    add_action( 'wp_enqueue_scripts', 'websquare_theme_css', 999 );
	add_action( 'wp_enqueue_scripts', 'websquare_theme_js', 999 );
	websquare_theme_support();
	add_action( 'widgets_init', 'websquare_register_sidebars' );

}

function websquare_head_cleanup(){
	remove_action( 'wp_head', 'wp_generator' );
}

function websquare_theme_support() {

	add_theme_support('post-thumbnails');
	set_post_thumbnail_size(350, 235, array( 'center', 'center'));

	add_image_size( 'team-single', 300, 450, true );
	add_image_size( 'team-list', 220, 330, true );

	add_image_size( 'post-thumbnails-big', 700, 470, array( 'center', 'center'));

	add_image_size( 'top-banner', 960 );
	add_image_size( 'full-width-product', 920 );
	//add_image_size( 'slider-960', 960, 280, true );
	//add_image_size( 'slider-720', 720, 280, true );

	add_theme_support('automatic-feed-links');
	add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );
	add_theme_support( 'menus' );
	register_nav_menus(
		array(
			'main-nav' => __( 'The Main Menu', 'shorts' ),   // main nav in header
			'footer-links' => __( 'Footer Links', 'shorts' ), // secondary nav in footer
			'account-nav' => __( 'Account Links', 'shorts' ), // secondary nav in footer
		)
	);

}
function websquare_theme_css() {
	global $wp_styles, $theme_version;

	if (!is_admin()) {
		//wp_register_style( 'font-proxima', '//fast.fonts.net/cssapi/1c3c7b94-136d-4927-a979-fa6140ef8cb7.css', array(), '1.0', 'all' );
		wp_register_style( 'font-open-sans', 'https://fonts.googleapis.com/css?family=Open+Sans:400,600,700', array(), '1.0', 'all' );

		wp_register_style('main-css', THEME_ASSETS . 'css/style.css', array(), $theme_version, 'all');
		wp_register_style('ie-css', THEME_ASSETS . 'css/ie.css', array(), $theme_version, 'all');

		//wp_enqueue_style( 'font-proxima' );
		wp_enqueue_style( 'font-open-sans' );
		wp_enqueue_style( 'main-css' );
		wp_enqueue_style( 'ie-css' );

		$wp_styles->add_data( 'ie-css', 'conditional', 'lt IE 9' ); // add conditional wrapper around ie stylesheet

		add_filter( 'cpsh_load_styles', '__return_false' );

	}
}
function websquare_theme_js() {
	global $wp_styles, $theme_version;
	if (!is_admin()) {
		wp_register_script( 'modernizr-js', THEME_ASSETS . 'js/modernizr.custom.min.js', array(), '2.5.3', false );
		wp_register_script( 'plugins-js', THEME_ASSETS . 'js/plugins.js', array( 'jquery' ), $theme_version, true );
		wp_register_script( 'scripts-js', THEME_ASSETS . 'js/scripts.js', array( 'jquery' ), $theme_version, true );
		//wp_register_script( 'threesixty-js', THEME_ASSETS . 'js/threesixty.min.js', array( 'jquery' ), '1.0.9', true );
		//wp_register_script( 'threesixty-full-js', THEME_ASSETS . 'js/threesixty.fullscreen.js', array( 'jquery' ), '1.0.0', true );

		wp_register_script( 'expo360-js', THEME_ASSETS . 'js/expo360.min.js', array( 'jquery' ), $theme_version, false );
		wp_localize_script( 'scripts-js', 'myAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));
		
		wp_localize_script( 'scripts-js', 'iePostodes', array( 'postcodes' => get_ie_postcodes()));

		// enqueue scripts
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'modernizr-js' );

		if(is_product()){
			wp_enqueue_script( 'expo360-js' );
		}
		wp_enqueue_script( 'plugins-js' );
		wp_enqueue_script( 'scripts-js' );
	}
}

// Sidebars & Widgetizes Areas
function websquare_register_sidebars() {

	register_sidebar(array(
		'id' => 'sidebar-page',
		'name' => __( 'Page Sidebar', 'shorts' ),
		'description' => __( 'Sidebar for pages.', 'shorts' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));

	register_sidebar(array(
		'id' => 'sidebar-news',
		'name' => __( 'News Sidebar', 'shorts' ),
		'description' => __( 'Sidebar for news.', 'shorts' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));

	register_sidebar(array(
		'id' => 'sidebar-shop-1',
		'name' => __( 'Complete Lifts Sidebar', 'shorts' ),
		'description' => __( 'Sidebar for Complete Lifts.', 'shorts' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));

	register_sidebar(array(
		'id' => 'sidebar-shop-2',
		'name' => __( 'Complete Lifts Attributes Sidebar', 'shorts' ),
		'description' => __( 'Sidebar Attributes for Complete Lifts.', 'shorts' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle"><a href="#">',
		'after_title' => '<span></span></a></h4>',
	));

	register_sidebar(array(
		'id' => 'sidebar-shop-3',
		'name' => __( 'Lift Components Sidebar', 'shorts' ),
		'description' => __( 'Sidebar for Lift Components.', 'shorts' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));

	register_sidebar(array(
		'id' => 'sidebar-shop-4',
		'name' => __( 'Lift Components  Attributes Sidebar', 'shorts' ),
		'description' => __( 'Sidebar Attributes for Lift Components.', 'shorts' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle"><a href="#">',
		'after_title' => '<span></span></a></h4>',
	));

	register_sidebar(array(
		'id' => 'sidebar-shop-5',
		'name' => __( 'Lift Spares Sidebar', 'shorts' ),
		'description' => __( 'Sidebar for Lift Spares.', 'shorts' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));

	register_sidebar(array(
		'id' => 'sidebar-shop-6',
		'name' => __( 'Lift Spares Attributes Sidebar', 'shorts' ),
		'description' => __( 'Sidebar Attributes for Lift Spares.', 'shorts' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle"><a href="#">',
		'after_title' => '<span></span></a></h4>',
	));

	register_sidebar(array(
		'id' => 'sidebar-account',
		'name' => __( 'Account Sidebar', 'shorts' ),
		'description' => __( 'Sidebar for the account area.', 'shorts' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle"><a href="#">',
		'after_title' => '<span></span></a></h4>',
	));
}

function filter_ptags_on_images($content){
   return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}
add_filter('the_content', 'filter_ptags_on_images');

// custom excerpt length
function websquare_custom_excerpt_length( $length ) {
	return 100;
}
add_filter( 'excerpt_length', 'websquare_custom_excerpt_length', 999 );

// add more link to excerpt
function websquare_custom_excerpt_more($more) {
	global $post;
	return '';
}
add_filter('excerpt_more', 'websquare_custom_excerpt_more');

function fix_menu_parent($menu){

	global $wp_query, $post, $woocommerce;

	if ( 'team-member' == get_post_type() ) {
		$menu = str_replace( 'current_page_parent', '', $menu ); // remove all current_page_parent classes
		$menu = str_replace( 'menu-item-26', 'current-menu-item menu-item-26', $menu ); // add the current_page_parent class to the page you want
	}


	if( 'product' == get_post_type() ){

		$prod_terms = get_the_terms( $post->ID, 'product_cat' );



		if ( $prod_terms && ! is_wp_error ( $prod_terms ) ){
			$prod_term = array_shift( $prod_terms );

			$partent = woo_get_ancestor($prod_term);

			if($partent == 28){
				$menu = str_replace( 'current_page_parent', '', $menu ); // remove all current_page_parent classes
				$menu = str_replace( 'menu-item-153', 'current-menu-item menu-item-153', $menu ); // add the current_page_parent class to the page you want
			}
			if($partent == 32){
				$menu = str_replace( 'current_page_parent', '', $menu ); // remove all current_page_parent classes
				$menu = str_replace( 'menu-item-243', 'current-menu-item menu-item-243', $menu ); // add the current_page_parent class to the page you want
			}
			if($partent == 33){
				$menu = str_replace( 'current_page_parent', '', $menu ); // remove all current_page_parent classes
				$menu = str_replace( 'menu-item-154', 'current-menu-item menu-item-154', $menu ); // add the current_page_parent class to the page you want
			}
		}
	}
	if(is_product_category()) {

		$partent =  woo_get_ancestor();

		if($partent == 28){
			$menu = str_replace( 'current_page_parent', '', $menu ); // remove all current_page_parent classes
			$menu = str_replace( 'menu-item-153', 'current-menu-item menu-item-153', $menu ); // add the current_page_parent class to the page you want
		}
		if($partent == 32){
			$menu = str_replace( 'current_page_parent', '', $menu ); // remove all current_page_parent classes
			$menu = str_replace( 'menu-item-243', 'current-menu-item menu-item-243', $menu ); // add the current_page_parent class to the page you want
		}
		if($partent == 33){
			$menu = str_replace( 'current_page_parent', '', $menu ); // remove all current_page_parent classes
			$menu = str_replace( 'menu-item-154', 'current-menu-item menu-item-154', $menu ); // add the current_page_parent class to the page you want
		}

	}


	return $menu;
}
add_filter( 'nav_menu_css_class', 'fix_menu_parent', 0 );

function custom_regenerate_thumbs_cap(){
	return 'edit_pages';
}
add_filter( 'regenerate_thumbs_cap', 'custom_regenerate_thumbs_cap', 0 );
?>