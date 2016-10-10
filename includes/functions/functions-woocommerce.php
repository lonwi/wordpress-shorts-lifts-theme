<?php
/* Global
******************************************************************/

// Add theme support
add_action( 'after_setup_theme', 'woocommerce_support' );
function woocommerce_support() {
	add_theme_support( 'woocommerce' );
}
// Remove Update Admin Notice
remove_action( 'admin_notices', 'woothemes_updater_notice' );

// Remove Default CSS
add_filter( 'woocommerce_enqueue_styles', '__return_false' );

// Remove Styled Select
add_action( 'wp_enqueue_scripts', 'woo_remove_scripts', 100 );
function woo_remove_scripts () {
	wp_dequeue_script( 'select2');
	wp_deregister_script('select2');

	//wp_deregister_script('wc-address-i18n');
	//wp_register_script( 'wc-address-i18n', THEME_ASSETS . '/js/address-i18n.js', array( 'jquery' ), false, true );
}
// Change Products Per Page
add_filter( 'loop_shop_per_page', create_function( '$cols', 'return 12 ;' ), 20 );

// Change Products Thumbnail
add_action( 'init', 'custom_fix_thumbnail' );
function custom_fix_thumbnail() {
 	add_filter('woocommerce_placeholder_img_src', 'custom_woocommerce_placeholder_img_src');

	function custom_woocommerce_placeholder_img_src( $src ) {
		$src = THEME_ASSETS . 'images/shorts-placeholder-image.png';
		return $src;
	}
}

//Remove WooCommerce Generator Tag
add_action('get_header','remove_woo_commerce_generator_tag');
function remove_woo_commerce_generator_tag() {
    remove_action( 'wp_head', array( $GLOBALS['woocommerce'], 'generator' ) );
	//remove_action( 'wp_enqueue_scripts', array( $GLOBALS['woocommerce'], 'frontend_scripts' ) );
}

add_action("wp_ajax_woo_update_cart", "woo_update_cart_amount");
add_action("wp_ajax_nopriv_woo_update_cart", "woo_update_cart_amount");
function woo_update_cart_amount(){
	ob_start();
	?>
	<?php _e('Shopping Basket', 'shorts');?> ( <?php echo WC()->cart->cart_contents_count;?> )
	<?php
	$content = ob_get_clean();
	echo $content;
	die();
}

add_filter( 'woocommerce_add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment' );
function woocommerce_header_add_to_cart_fragment( $fragments ) {
	ob_start();
	?>
	<a class="cart-contents" href="<?php echo WC()->cart->get_cart_url(); ?>" title="<?php _e( 'View your shopping basket' ); ?>">
		<?php _e('Shopping Basket', 'shorts');?> ( <?php echo WC()->cart->cart_contents_count;?> )
	</a>
	<?php
	$fragments['a.cart-contents'] = ob_get_clean();
	return $fragments;
}

function woo_get_ancestor($current_cat = "" , $field = 'term_id' ){
	global $wp_query, $post, $woocommerce;
	$parent = "";
	if (is_product_category()) {
		if(empty($current_cat)){
			$current_cat  = $wp_query->queried_object;
		}
		if(isset($current_cat) && !empty($current_cat)){
			if($current_cat->parent == 0){
				$parent = $current_cat->$field;
			}else{
				if($ancestors = get_ancestors( $current_cat->$field, 'product_cat' )){
					foreach ( $ancestors as $ancestor ) {
					$ancestor = get_term( $ancestor, 'product_cat' );
						if($ancestor->parent == 0){
							$parent = $ancestor->$field;
							break;
						}
					}
				}
			}
			return $parent;
		}
	}elseif( is_product() ) {

		if($ancestors = get_the_terms( $post->ID, 'product_cat' )){
			foreach ( $ancestors as $ancestor ) {
				if($ancestor->parent == 0){
					$parent = $ancestor->$field;
					break;
				}
			}
			if($parent !== 0){
				$ancestor = $ancestors[0];
				$cat = get_term($ancestor->parent, 'product_cat');
				if(isset($cat->parent) && $cat->parent === 0){
					$parent = $cat->$field;
				}else{

					if($ancestors = get_ancestors( $ancestor->parent, 'product_cat' )){

						foreach ( $ancestors as $ancestor ) {
						$ancestor = get_term( $ancestor, 'product_cat' );
							if($ancestor->parent == 0){
								$parent = $ancestor->$field;
								break;
							}
						}
					}
				}
			}
			return $parent;
		}
	}
	return $parent;
}

function get_product_name($post_id){
	global $post;
	$name = false;
	if(isset($post_id) && !empty($post_id)){
		$id = $post_id;
	}else{
		$id = $post->ID;
	}
	if(isset($id) && !empty($id)) {
		$name = get_post_meta( $id, '_shorts_product_name', true );
	}
	return $name;
}
function get_product_subtitle($post_id){
	global $post;
	$name = false;
	if(isset($post_id) && !empty($post_id)){
		$id = $post_id;
	}else{
		$id = $post->ID;
	}
	if(isset($id) && !empty($id)) {
		$name = get_post_meta( $id, '_shorts_product_subtitle', true );
	}
	return $name;
}

function get_user_resticted_manufacturers(){
	global $product;
	$manufacturers = array();
	$restricted_manufacturers = array();

	if(isset($product) && !empty($product)){
		if ( is_user_logged_in()) {

			if($user_id = get_current_user_id())
				$restricted_manufacturers = get_field('restricted_manufacturers', 'user_'.$user_id);

			if(empty($restricted_manufacturers)){
				return false;
			}

			if( $attributes = $product->get_attributes() ){

				if( isset( $attributes[ 'pa_manufacturer' ]) ){

					$attribute = $attributes[ 'pa_manufacturer' ];

					if ( $attribute['is_taxonomy'] ) {
						$manufacturers = wc_get_product_terms( $product->id, $attribute['name'], array( 'fields' => 'ids' ) );
					}

					if(empty($manufacturers)){
						return false;
					}


				}
			}

			if(!empty($restricted_manufacturers) && !empty($manufacturers)){
				$result = array_intersect($restricted_manufacturers, $manufacturers);
				if(!empty($result)){
					return true;
				}
			}

		}
	}
	return false;
}
add_filter( 'woocommerce_get_price_html', 'get_user_resticted_manufacturers_price', 100, 2 );
function get_user_resticted_manufacturers_price( $price, $product ){
	if(get_user_resticted_manufacturers() === true){
		return '<span class="amount">P.O.A.</span>';
	}else{
		return $price;
	}
}
function get_replaced_ids($post_id){
	global $post;
	$product_ids = false;
	if(isset($post_id) && !empty($post_id)){
		$id = $post_id;
	}else{
		$id = $post->ID;
	}
	if(isset($id) && !empty($id)) {
		$replaced_ids = preg_replace('/\s+/', '', get_post_meta( $id, '_product_replaced_by_ids', true ));
		$replaced_ids = str_replace(',', '|', $replaced_ids);
		$replaced_ids = (array) explode('|',  $replaced_ids);
		foreach ( $replaced_ids as $replaced_id ) {
			if($product_id = wc_get_product_id_by_sku($replaced_id)){
				$product_ids[] = $product_id;
			}
		}
	}
	return $product_ids;
}

function is_wc_endpoint( $endpoint = false ) {
	 global $wp;

	 $wc_endpoints = WC()->query->get_query_vars();

	 if ( $endpoint ) {
		 if ( ! isset( $wc_endpoints[ $endpoint ] ) ) {
			 return false;
		 } else {
			 $endpoint_var = $wc_endpoints[ $endpoint ];
		 }

		 return isset( $wp->query_vars[ $endpoint_var ] );
	 } else {
		 foreach ( $wc_endpoints as $key => $value ) {
			 if ( isset( $wp->query_vars[ $key ] ) ) {
				 return true;
			 }
		 }
		 return false;
	 }
}
function is_product_alternative_layout($post_id = false){
	global $post;
	$result = false;
	if(!$post_id){
		$post_id = $post->ID;
	}
	if($partent =  woo_get_ancestor()) {
		 if($partent == 28 || $partent == 33)
			$result = true;
	}
	if('yes' == get_post_meta( $post->ID, '_alternative_layout', true )){
		$result = true;
	}
	return $result;
}
/* Per Page
******************************************************************/
//add_action('wppp_before_dropdown', 'woocommerce_products_per_page_dropdown_get_fix', 10);

function woocommerce_products_per_page_dropdown_get_fix(){
	$method = in_array( get_option( 'wppp_method', 'post' ), array( 'post', 'get' ) ) ? get_option( 'wppp_method', 'post' ) : 'post';

	if($method === 'get'){
		$filters = $_GET;
		if(isset($filters) && !empty($filters)){
			foreach($filters as $key => $value){
				if(substr($key, 0, 6) === 'filter') {
					echo '<input type="hidden" name="'.$key.'" value="'.$value.'">';
				}
			}
		}
	}

}

/* Global Layout
******************************************************************/

// Remove Breadcrumbs
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );


/* Catalog Layout
******************************************************************/

// Remove raiting
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );

// Remove Price
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );

// Remove add to cart button
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );

// Page title
function override_page_title() {
	global $wp_query, $post, $woocommerce;
	if(!is_product_category()) return false;
	$current_cat = $wp_query->queried_object;
	if( isset( $current_cat ) && ( $current_cat->term_id == 28 || $current_cat->term_id == 33 ) ) {
		return false;
	} elseif (isset( $current_cat ) && ( $current_cat->term_id == 32)){
		return false;
	} elseif (isset( $current_cat ) && ( $ancestor = woo_get_ancestor($current_cat))){
		if($ancestor == 32){
			return false;
		} else {
			return true;
		}
	} else {
		return true;
	}

}
add_filter('woocommerce_show_page_title', 'override_page_title');


// Product columns
add_filter( 'body_class', 'woocommerce_pac_columns' );
function woocommerce_pac_columns( $classes ) {
	$columns 	= 3;
	$classes[] 	= 'product-columns-' . $columns;
	return $classes;
}

add_filter( 'loop_shop_columns', 'woocommerce_pac_products_row' );
function woocommerce_pac_products_row() {
	$columns 	= 3;
	return $columns;
}

add_filter( 'woocommerce_product_thumbnails_columns', 'woocommerce_product_thumbnails_columns_new' );
function woocommerce_product_thumbnails_columns_new() {
	$columns 	= 4;
	return $columns;
}

// Remove Sidebar
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

// Add sidebar
add_action('woocommerce_custom_sidebar', 'woocommerce_get_sidebar', 10);


/* Single Layout
******************************************************************/
// Remove Product Title
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );

// Remove Signle Price
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );

// Remove Product Excerpt
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );

// Remove Add to cart
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );

// Remove Product Meta
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );

// Remove Product Share
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );

// Remove Related Products
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );


// Add Product Title
add_action( 'woocommerce_single_product_summary', 'woocommerce_single_title_with_sku', 5 );
function woocommerce_single_title_with_sku(){
	global $product;
	if($sku = $product->get_sku()){
		echo '<span class="title-note">'.__('Shorts Part Number:','woocommerce').'</span>';
		echo '<span class="sku" itemprop="sku">'.$sku.'</span>';
	}
	if($title = get_product_name($product->id)){
		echo '<span class="title-note">'.__('Description:','woocommerce').'</span>';
		echo '<h1 itemprop="name" class="product_title entry-title">'.$title.'</h1>';
	}
}
function woocommerce_single_title_with_sku_complete_lifts(){
	global $product;
	echo '<span class="title-note">'.__('Product','woocommerce').'</span>';
	if($sku = $product->get_sku()){
	echo '<span class="product-sku" itemprop="sku">'.$sku.'</span>';
	}
	if($title = get_product_name($product->id)){
	echo '<h1 itemprop="name" class="entry-title product-title">'.$title.'</h1>';
	}
}
function woocommerce_single_title_layout_2(){
	global $product;
	echo '<span class="title-note">'.__('Product','woocommerce').'</span>';
	if($title = get_product_name($product->id)){
	echo '<h1 class="product-title">'.$title.'</span>';
	}
	if($subtitle = get_product_subtitle($product->id)){
	echo '<h2 class="product-subtitle">'.$subtitle.'</h2>';
	}
}
function woocommerce_single_replaced_product(){
	global $woocommerce, $post, $product;
	$replaced_ids = get_replaced_ids($post->ID);
	if($replaced_ids){
		echo '<span class="replaced-by-title">Product Replaced by:</span>';
		foreach($replaced_ids as $product_id){
			echo '<span class="replaced-by-sku"><a href="'.get_permalink($product_id).'" style="display:block" title ="'.get_product_name($product_id).' - '.get_post_meta( $product_id, '_sku', true ).'">'.get_post_meta( $product_id, '_sku', true ).'</a></span>';
		}
	}
}
// Add Social Share
add_action( 'woocommerce_after_single_product_summary', 'woo_single_social_share', 10 );
function woo_single_social_share(){
	echo get_template_part( 'includes/blocks/block', 'social-share' );
}
// Price: POA istead of FREE
add_filter('woocommerce_free_price_html', 'woo_my_custom_free_message');
function woo_my_custom_free_message() {
	return '<span class="amount">P.O.A.</span>';
}
function woo_single_add_to_cart_ajax(){
	global $post, $product;
	echo '<div class="single-ajax-add-to-cart-container cart clearfix">';

	if ( ! $product->is_sold_individually() ){
		echo '<div class="single-quatity-box">';
		echo '<span class="single-quatity-box-title clearfix">'. __('QUANTITY', 'shorts').'</span>';
		woocommerce_quantity_input( array(
			'min_value' => apply_filters( 'woocommerce_quantity_input_min', 1, $product ),
			'max_value' => apply_filters( 'woocommerce_quantity_input_max', $product->backorders_allowed() ? '' : $product->get_stock_quantity(), $product )
		) );
		echo '</div>';
	}

	echo '<div class="single-buttons-box">';

	echo sprintf( '<a href="%s" rel="nofollow" data-jckqvpid="%s" data-product_id="%s" data-product_sku="%s" class="addtocart button %s product_type_%s">%s</a>',
		esc_url( $product->add_to_cart_url() ),
		esc_attr( $product->id ),
		esc_attr( $product->id ),
		esc_attr( $product->get_sku() ),
		$product->is_purchasable() && $product->is_in_stock() ? 'single_add_to_cart_button' : '',
		esc_attr( $product->product_type ),
		esc_html( __('Add To Basket', 'shorts') )
	);
	echo '</div>';
	echo '</div>';
}
/* Single Layout - Shop Mode
******************************************************************/
add_action( 'woocommerce_before_main_content', 'woo_single_shop_layout_hack' );
function woo_single_shop_layout_hack(){
	global $post,$product;
	if(is_product()){
		if(($partent =  woo_get_ancestor()) && ($partent == 28)){


		}else{
			$shopmode = get_post_meta( $post->ID, '_enquire_mode', true );
			$enable_3d_view = get_post_meta( $post->ID, '_enable_3d_view', true );
			$replaced_ids = get_replaced_ids($post->ID);
			if(isset($shopmode) && $shopmode != 'yes' && is_user_logged_in() ){
				if(isset($product->price) && $product->price > 0) {
					if($replaced_ids){
						add_action( 'woocommerce_single_product_summary', 'woocommerce_single_replaced_product', 30 );
					}else{
						if(get_user_resticted_manufacturers() === true){
							// Add price
							add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 15 );

							// Add Enquire Button
							add_action( 'woocommerce_single_product_summary', 'woo_single_enquire_button', 60 );

							// Add Enquire Form
							add_action( 'woocommerce_single_enquire_form', 'woo_single_enquire_form', 60 );

						}else{
							// Add price
							add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 15 );

							// Add to cart
							if($product->is_type('simple')){
								add_action( 'woocommerce_single_product_summary', 'woo_single_add_to_cart_ajax', 30 );
							}else{
								add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
							}
							// Add Notice
							add_action( 'woocommerce_single_product_summary', 'woo_single_minimum_notice', 60 );
						}
					}
				} else {
					// Add price
					add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 15 );

					// Add Enquire Button
					add_action( 'woocommerce_single_product_summary', 'woo_single_enquire_button', 60 );

					// Add Enquire Form
					add_action( 'woocommerce_single_enquire_form', 'woo_single_enquire_form', 60 );
				}

			}
			if(isset($shopmode) && $shopmode != 'yes' && !is_user_logged_in() ){
				if(isset($product->price) && $product->price > 0) {
				// Add Please Log In
				add_action( 'woocommerce_single_product_summary', 'woo_single_please_log_in', 60 );
				}else{
				add_action( 'woocommerce_single_product_summary', 'woo_single_please_log_in', 60 );
				}

			}
			if(isset($shopmode) && $shopmode == 'yes' ){

				if(is_user_logged_in()){
					// Add price
					add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 15 );

					// Add Enquire Button
					add_action( 'woocommerce_single_product_summary', 'woo_single_enquire_button', 60 );

					// Add Enquire Form
					add_action( 'woocommerce_single_enquire_form', 'woo_single_enquire_form', 60 );

				}else{

					add_action( 'woocommerce_single_product_summary', 'woo_single_please_log_in', 60 );

				}

			}

			if(isset($enable_3d_view) && $enable_3d_view == 'yes'){
				remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20);
				remove_action( 'woocommerce_product_thumbnails', 'woocommerce_show_product_thumbnails', 20 );
				remove_action( 'wp', 'setup_dynamic_gallery', 20);

				add_action( 'woocommerce_before_single_product_summary', 'render_expo_360' );
			}
		}
	}

}
function render_expo_360(){
	global $product, $post;
	
	if ( has_post_thumbnail() ) {
		$thumbnail_id 	= get_post_thumbnail_id();
		$attachment_ids  = $product->get_gallery_attachment_ids();
		$attachment_count = count( $attachment_ids );
		$images_urls = array();
		$images_urlsBig = array();
		$images_urlsName = array();
		$timg = wp_get_attachment_image_src((int) $thumbnail_id, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ) );
		$width = $timg[1];
		$height = $timg[2];
	
		if ( $attachment_count > 1 ) {
			
			array_unshift($attachment_ids, $thumbnail_id);
			
			foreach ( $attachment_ids as $image_id ) {
				if ( is_numeric( $image_id ) ) {
					$timg = wp_get_attachment_image_src((int) $image_id, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ) );
					$images_urls[] = $timg[0];
					$images_urlsBig[] = wp_get_attachment_url( (int) $image_id );
					$tname = explode('/', wp_get_attachment_url( (int) $image_id ));
					$images_urlsName[] = array_pop($tname );
					
				}
			}
	
			?>
			<div class="images">
				<div class="image woocommerce-360-container" style="max-width:458px;">
				<div id="viewer" style="position:relative; overflow:hidden;" class=""></div>
				</div>
			</div>
			<script type="text/javascript">
				jQuery(document).ready(function($) {
					var imgArray = <?php echo json_encode( $images_urls );?>;
					var imgArrayBig = <?php echo json_encode( $images_urlsBig );?>;
					var imgArrayName = <?php echo json_encode( $images_urlsName );?>;
	
					//console.log(imgArrayName.length);
					var expo = new Expo360({xml:"<?php echo THEME_ASSETS . 'js/360/settings.xml';?>", where:"#viewer", imgArray:imgArray, imgArrayBig:imgArrayBig, imgArrayName:imgArrayName, width: <?php echo $width;?>, height:<?php echo $height;?>});
				});
			</script>
			
			<?php
		}
	}
}
add_action( 'websquare_before_header', 'woo_single_enquire_form_validation', 9999);
function woo_single_minimum_notice(){
	?>
    <div class="discount-note-terms"><p><?php _e('*Discount applicable to goods only when order is placed online','shorts');?></p></div>
	<?php /*
    <div class="alert clearfix">
		<?php _e('Please Note: Minimum Order Value of materials is &pound;15', 'shorts');?>
	</div>
	*/?>
	<?php
}
function woo_single_please_log_in(){
	?>
    <?php woocommerce_single_replaced_product();?>
	<div class="please-log-in clearfix"><a href="<?php echo get_permalink(7);?>"><?php _e('Log in to view prices and order online', 'shorts');?></a></div>
    <span class="discount-note-block">Order online <span class="bold">Get 2% Off</span>*</span>
	<div class="discount-note-terms"><p><?php _e('*Discount applicable to goods only when order is placed online','shorts');?></p></div>
	<?php
}
function woo_single_enquire_button(){
}
function woo_single_enquire_form_validation(){
	global $product, $post;
	//if(isset($product) && $product->post_title != ""){
		if(isset($_POST['slsubmit'])){
			$errors = array();
			if(getenv("HTTP_REFERER") != get_permalink()){
				$errors['spam'] = __( 'Spam Detected', 'shorts' );
			}else{
				if(!empty($_POST["name"]) || !empty($_POST["email"])){
					$errors['spam'] = __( 'Spam Detected', 'shorts' );
				}
				if(empty($_POST["slname"])){
					$errors['slname'] = __( 'Your Name field should not be empty.', 'shorts' );
				}
				if(empty($_POST["slemail"]) || !is_email($_POST["slemail"])){
					$errors['slemail'] = __( 'Your Email field should not be empty.', 'shorts' );
				}
				if(empty($_POST["slphone"])){
					$errors['slphone'] = __( 'Your Phone field should not be empty.', 'shorts' );
				}
				if(empty($_POST["slmessage"])){
					$errors['slmessage'] = __( 'Your Message field should not be empty.', 'shorts' );
				}
			}

			if(!sizeof($errors)){
				$slpartnumber = esc_html($_POST["slpartnumber"]);

				$slemail = esc_html($_POST["slemail"]);
				$slname = esc_html($_POST["slname"]);
				$slphone = esc_html($_POST['slphone']);
				$slmessage = esc_textarea($_POST['slmessage']);

				// From
				$header = 'From: Shorts Industries Limited <info@shorts-lifts.co.uk>' . "\r\n";
				// Details
				$message = "Product Name: " . $slpartnumber . "\n\n";
				$message .= "Name: " . $slname . "\n";
				$message .= "Email: " . $slemail . "\n";
				$message .= "Phone: " . $slphone . "\n";
				$message .= "Message: " . $slmessage . "\n\n";

				$to ='info@shorts-lifts.co.uk';
				//$to ='wojciech@websquare.co.uk';
				$subject = 'Product Enquiry: '.$slpartnumber;
				if(wp_mail($to,$subject,$message,$header)){
					wc_add_notice( __( 'Thank you for contacting Shorts. We\'ll get back to you very soon. For urgent enquiries please call us on 01274 305066.', 'shorts' ), $notice_type = 'success' );
					$_POST['slname'] = '';
					$_POST['slemail'] = '';
					$_POST['slphone'] = '';
					$_POST['slmessage'] = '';
				}else{
					wc_add_notice( __( 'Errors occurred! Your enquiry was not sent. Please try again later or call us on 01274 305066.', 'shorts' ), $notice_type = 'error' );
				}
			}else{
				wc_add_notice( __( 'Errors occurred! Your enquiry was not sent. Please try again later or call us on 01274 305066.', 'shorts' ), $notice_type = 'error' );
				foreach($errors as $error){
					wc_add_notice( $error, $notice_type = 'error' );
				}
			}
		}
	//}
}
function woo_single_enquire_form(){
	get_template_part( 'includes/forms/form', 'enquire-product' );
}
// Add to cart text
add_filter( 'add_to_cart_text', 'woo_custom_cart_button_text' );
add_filter( 'woocommerce_product_single_add_to_cart_text', 'woo_custom_cart_button_text' );
function woo_custom_cart_button_text() {
	return __( 'Add To Basket', 'woocommerce' );
}

/* Single Layout - Info Mode
******************************************************************/
add_action( 'woocommerce_before_main_content', 'woo_single_info_layout_hack' );
function woo_single_info_layout_hack(){}

/* Catalog Menu
******************************************************************/

add_filter( 'woocommerce_product_categories_widget_args', 'woo_product_cat_widget_args' );
function woo_product_cat_widget_args( $cat_args ) {
	global $wp_query, $post, $woocommerce;

	if ( is_tax('product_cat') ) {

		$current_cat   = $wp_query->queried_object;

		if($ancestors = get_ancestors( $current_cat->term_id, 'product_cat' )){
			foreach ( $ancestors as $ancestor ) {
			$ancestor = get_term( $ancestor, get_query_var( 'taxonomy' ) );

				if($ancestor->parent == 0){
					$cat_args['child_of'] = $ancestor->term_id;
				}
			}
		} else {
			$cat_args['child_of'] = $current_cat->term_id;
		}

	}
	return $cat_args;
}



/* Rename Metabox
******************************************************************/

add_action( 'add_meta_boxes', 'woo_custom_rename_meta_boxes', 60 );
function woo_custom_rename_meta_boxes() {
	remove_meta_box( 'postexcerpt', 'product', 'normal' );
	add_meta_box( 'postexcerpt', __( 'Specification / Product Short Description', 'woocommerce' ), 'WC_Meta_Box_Product_Short_Description::output', 'product', 'normal' );
}

/* Product Page Display Mode
******************************************************************/

// Display Fields
add_action( 'woocommerce_product_options_general_product_data', 'woo_add_custom_general_fields' );
add_action( 'woocommerce_product_options_stock_status', 'woo_add_custom_stock_status' );
add_action( 'woocommerce_product_options_advanced', 'woo_add_custom_advanced' );

// Save Fields
add_action( 'woocommerce_process_product_meta', 'woo_add_custom_general_fields_save' );

function woo_add_custom_general_fields() {
	global $woocommerce, $post;

	echo '<div class="options_group">';

	// Text Field
	woocommerce_wp_text_input(
		array(
			'id'          => '_shorts_product_name',
			'label'       => __( 'Product Name', 'woocommerce' ),
			'desc_tip'    => false,
		)
	);

	// Text Field
	woocommerce_wp_text_input(
		array(
			'id'          => '_shorts_product_subtitle',
			'label'       => __( 'Product Subtitle', 'woocommerce' ),
			'description' => __( 'Used in alternative layout', 'woocommerce' ),
			'desc_tip'    => true,
		)
	);

	// Text Field
	woocommerce_wp_text_input(
		array(
			'id'          => '_oem_part_number',
			'label'       => __( 'OEM Part Number', 'woocommerce' ),
			'desc_tip'    => false,
		)
	);

	// Text Field
	woocommerce_wp_text_input(
		array(
			'id'          => '_shorts_old_part_number',
			'label'       => __( 'Shorts Old Part Number', 'woocommerce' ),
			'desc_tip'    => false,
		)
	);

	// Text Field
	woocommerce_wp_text_input(
		array(
			'id'          => '_search_keywords',
			'label'       => __( 'Additional Search Keywords', 'woocommerce' ),
			'desc_tip'    => false,
		)
	);

	// Text Field
	woocommerce_wp_text_input(
		array(
			'id'          => '_additional_product_info',
			'label'       => __( 'Additional Information', 'woocommerce' ),
			'desc_tip'    => false,
		)
	);

	echo '</div>';


}

function woo_add_custom_stock_status(){
	global $woocommerce, $post;

	// Text Field
	woocommerce_wp_text_input(
		array(
			'id'          => '_shorts_stock_information',
			'label'       => __( 'Stock Information', 'woocommerce' ),
			'description' => __( 'Used in alternative layout', 'woocommerce' ),
			'desc_tip'    => true,
		)
	);
}

function woo_add_custom_advanced(){
	global $woocommerce, $post;

	echo '<div class="options_group">';

	woocommerce_wp_checkbox(
		array(
			'id' => '_enquire_mode',
			'label' => __( 'Enquire Mode', 'woocommerce' ),
			'placeholder' => '',
			'desc_tip' => true,
			'description' => __( 'Please select to enable the enquire mode.', 'woocommerce' )
		)
	);

	woocommerce_wp_checkbox(
		array(
			'id' => '_alternative_layout',
			'label' => __( 'Alternative Layout', 'woocommerce' ),
			'placeholder' => '',
			'desc_tip' => true,
			'description' => __( 'Please select to enable the alternative layout.', 'woocommerce' )
		)
	);

	woocommerce_wp_checkbox(
		array(
			'id' => '_enable_3d_view',
			'label' => __( '3D View', 'woocommerce' ),
			'placeholder' => '',
			'desc_tip' => true,
			'description' => __( 'Please select to enable the 3D Product View.', 'woocommerce' )
		)
	);

	echo '</div>';
}

add_action( 'woocommerce_product_options_related', 'woo_add_custom_linked_products_fields' );
function woo_add_custom_linked_products_fields() {
	global $woocommerce, $product, $post;
	// Text Field
	woocommerce_wp_text_input(
		array(
			'id'          => '_product_replaced_by_ids',
			'label'       => __( 'Replaced By (SKUs)', 'woocommerce' ),
			'description' => __( '"|" or "," sparated values, no spaces', 'woocommerce' ),
			'desc_tip'    => true,
		)
	);
?>


<?php /*
<div class="options_group">
	<p class="form-field">
		<label for="product_replaced_by_ids"><?php _e( 'Replaced By', 'woocommerce' ); ?></label>
		<input type="hidden" class="wc-product-search" style="width: 50%;" id="product_replaced_by_ids" name="_product_replaced_by_ids" data-placeholder="<?php esc_attr_e( 'Search for a product&hellip;', 'woocommerce' ); ?>" data-action="woocommerce_json_search_products" data-multiple="true" data-exclude="<?php echo intval( $post->ID ); ?>" data-selected="<?php
			$product_ids = array_filter( array_map( 'absint', (array) get_post_meta( $post->ID, '_product_replaced_by_ids', true ) ) );
			$json_ids    = array();

			foreach ( $product_ids as $product_id ) {
				$product = wc_get_product( $product_id );
				if ( is_object( $product ) ) {
					$json_ids[ $product_id ] = wp_kses_post( html_entity_decode( $product->get_formatted_name(), ENT_QUOTES, get_bloginfo( 'charset' ) ) );
				}
			}

			echo esc_attr( json_encode( $json_ids ) );
		?>" value="<?php echo implode( ',', array_keys( $json_ids ) ); ?>" /> <img class="help_tip" data-tip='<?php esc_attr_e( 'It will display replaced by product link.', 'woocommerce' ) ?>' src="<?php echo WC()->plugin_url(); ?>/assets/images/help.png" height="16" width="16" />
	</p>
</div>
*/?>
<?php
}

// Save Fields
add_action( 'woocommerce_process_product_meta', 'woo_add_custom_general_fields_save' );

function woo_add_custom_general_fields_save( $post_id ){

	$woocommerce_shorts_product_name = $_POST['_shorts_product_name'];
	update_post_meta( $post_id, '_shorts_product_name', esc_attr( $woocommerce_shorts_product_name ) );

	$woocommerce_shorts_product_subtitle = $_POST['_shorts_product_subtitle'];
	update_post_meta( $post_id, '_shorts_product_subtitle', esc_attr( $woocommerce_shorts_product_subtitle ) );

	$woocommerce_oem_part_number = $_POST['_oem_part_number'];
	update_post_meta( $post_id, '_oem_part_number', esc_attr( $woocommerce_oem_part_number ) );

	$woocommerce_shorts_old_part_number = $_POST['_shorts_old_part_number'];
	update_post_meta( $post_id, '_shorts_old_part_number', esc_attr( $woocommerce_shorts_old_part_number ) );

	$woocommerce_search_keywords = $_POST['_search_keywords'];
	update_post_meta( $post_id, '_search_keywords', esc_attr( $woocommerce_search_keywords ) );

	$woocommerce_enquire_mode_checkbox = isset( $_POST['_enquire_mode'] ) ? 'yes' : 'no';
	update_post_meta( $post_id, '_enquire_mode', $woocommerce_enquire_mode_checkbox );

	$woocommerce_alternative_layout_checkbox = isset( $_POST['_alternative_layout'] ) ? 'yes' : 'no';
	update_post_meta( $post_id, '_alternative_layout', $woocommerce_alternative_layout_checkbox );

	$woocommerce_enable_3d_view_checkbox = isset( $_POST['_enable_3d_view'] ) ? 'yes' : 'no';
	update_post_meta( $post_id, '_enable_3d_view', $woocommerce_enable_3d_view_checkbox );

	$woocommerce_shorts_stock_information = $_POST['_shorts_stock_information'];
	update_post_meta( $post_id, '_shorts_stock_information', esc_attr( $woocommerce_shorts_stock_information ) );

	$_additional_product_info = $_POST['_additional_product_info'];
	update_post_meta( $post_id, '_additional_product_info', esc_attr( $_additional_product_info ) );

	$_product_replaced_by_ids = $_POST['_product_replaced_by_ids'];
	update_post_meta( $post_id, '_product_replaced_by_ids', esc_attr( $_product_replaced_by_ids ) );

}


/* Product Page Tabs
******************************************************************/

add_filter( 'woocommerce_product_tabs', 'woo_remove_product_tabs', 98 );

function woo_remove_product_tabs( $tabs ) {
 	global $post;
	if(($partent =  woo_get_ancestor()) && ($partent == 28 || $partent == 33)){
		unset( $tabs['reviews'] ); // Remove the reviews tab
		unset( $tabs['delivery_tab'] ); // Remove the delivery tab
	}

	//unset( $tabs['description'] ); // Remove the description tab
	//unset( $tabs['reviews'] ); // Remove the reviews tab
	//unset( $tabs['additional_information'] ); // Remove the additional information tab

	return $tabs;

}

add_filter ( 'woocommerce_product_description_heading', 'woo_custom_product_description_heading' );
function woo_custom_product_description_heading() {
	return '';
}

add_filter ( 'woocommerce_product_additional_information_heading', 'woo_custom_product_additional_information_heading' ) ;
function woo_custom_product_additional_information_heading() {
	return '';
}

add_filter( 'woocommerce_product_tabs', 'woo_new_product_tab' );
function woo_new_product_tab( $tabs ) {

	global $post;

	$tabs['delivery_tab'] = array(
		'title' => __( 'Delivery, Returns & Warranty', 'woocommerce' ),
		'priority' => 25,
		'callback' => 'woo_delivery_product_tab_content'
	);

	if($post->post_excerpt ){
		$tabs['specification_tab'] = array(
			'title' => __( 'Specification', 'woocommerce' ),
			'priority' => 20,
			'callback' => 'woo_specification_product_tab_content'
		);
	}else{
	}
	return $tabs;
}

function woo_delivery_product_tab_content(){
	global $woocommerce, $post, $product;
	$partent =  woo_get_ancestor();
	//echo '<h2>'.__('Delivery, Warranty & Returns', 'woocommerce').'</h2>';
	if($partent == 32){
		$delivery_post = get_post(4213);
	}elseif($partent == 33){
		$delivery_post = get_post(4213);
	}else{
		$delivery_post = get_post(4213);
	}
	$content = apply_filters('the_content', $delivery_post->post_content);
	echo $content;
	//echo '<div class="clearfix"></div>';
}

function woo_specification_product_tab_content(){
	global $woocommerce, $post, $product;

	$content = apply_filters( 'the_content', $post->post_excerpt );
	//echo '<h2>'.__('Specification', 'woocommerce').'</h2>';
	echo $content;
}

/* Modify Lifts Spares Section
******************************************************************/

add_action( 'woocommerce_before_main_content', 'woo_lift_spares_layout_hack' );

function woo_lift_spares_layout_hack(){
	if(($partent =  woo_get_ancestor()) && ($partent == 32)){
	// Remove Results Count
	remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
	// Remove Ordering
	remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
	// Remove raiting
	remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
	// Remove Price
	remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
	// Remove add to cart button
	remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
	// Remove add to cart button
	remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination', 10 );


	// Add Banner to Product Archive
	add_action( 'woocommerce_before_shop_loop', 'woo_lift_spares_banner', 30 );
	// Add Custom Layout
	add_action( 'woocommerce_before_shop_loop', 'woo_lift_before_content', 50 );
	// Add Custom Layout
	add_action( 'woocommerce_after_shop_loop', 'woo_lift_after_content', 50 );
	// Add Results Count
	add_action( 'woocommerce_before_shop_loop_custom_1', 'woocommerce_result_count', 20 );
	// Add Results Count
	add_action( 'woocommerce_after_shop_loop_custom_1', 'woocommerce_result_count', 20 );


	// Add Results Count
	add_action( 'woocommerce_before_shop_loop_custom_3', 'woocommerce_pagination', 20 );
	// Add Results Count
	add_action( 'woocommerce_after_shop_loop_custom_3', 'woocommerce_pagination', 20 );
	// Add Links Under Title
	add_action( 'woocommerce_after_shop_loop_item', 'woo_lift_view_details', 20 );
	// Add Price
	add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_price', 10 );

	}
}
function woo_lift_spares_banner(){
	global $wp_query, $post, $woocommerce;
	if(is_tax() || is_category() || is_tag()) {
		$current_term = $wp_query->queried_object;

		$banner_image = get_field('banner_image', $current_term->taxonomy.'_'.$current_term->term_id);
		$banner_title = esc_html( $current_term->name );

		if( (!isset($banner_image) || empty($banner_image)) && $current_term->parent != 0 ){

			$ancestors = get_ancestors( $current_term->term_id, $current_term->taxonomy );

			foreach ( $ancestors as $ancestor ) {
				$ancestor = get_term( $ancestor, $current_term->taxonomy );
				if($ancestor->parent == 0){
					$banner_image = get_field('banner_image', $ancestor->taxonomy.'_'.$ancestor->term_id);
					$banner_title = esc_html( $ancestor->name );
				}
			}

		}

	}
	if(isset($banner_image) && $banner_image != ""){
    echo '<div class="block-banner-category clearfix">';
       echo '<img src="'.$banner_image['sizes']['top-banner'].'" alt="'.$banner_title.' Banner Image">';
    echo '</div>';
	}
}
function woo_lift_view_details(){
	global $post, $product;
	echo '<div class="product-under-title clearfix">';
	echo '<a href="'.get_permalink($post->ID).'" title="'.esc_html($post->post_title).'" class="product-details-link">View Details</a>';
	if(!is_user_logged_in() ){
		echo '<a href="'.get_permalink(7).'" class="product-details-please-log-in">Log in for prices</a>';
	}
	if(is_user_logged_in() ){
	$enquire_mode = get_post_meta( $post->ID, '_enquire_mode', true );
	if( ($product->is_purchasable() && $product->is_in_stock() && $product->price > 0 && $enquire_mode != 'yes' && get_user_resticted_manufacturers() === false) )
	echo apply_filters( 'woocommerce_loop_add_to_cart_link',
	sprintf( '<a href="%s" rel="nofollow" data-jckqvpid="%s" data-product_id="%s" data-product_sku="%s" class="product-add-link %s product_type_%s">%s</a>',
		esc_url( $product->add_to_cart_url() ),
		esc_attr( $product->id ),
		esc_attr( $product->id ),
		esc_attr( $product->get_sku() ),
		$product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
		esc_attr( $product->product_type ),
		esc_html( __('Add To Basket', 'shorts') )
	),
	$product );
	}
	echo '</div>';
}
function woo_lift_before_content(){

	echo '<div class="woo-before-loop-cont clearfix">';
	echo '<div class="fourcol first">';
	do_action( 'woocommerce_before_shop_loop_custom_1' );
	echo '</div>';
	echo '<div class="fourcol">';
	do_action( 'woocommerce_before_shop_loop_custom_2' );
	echo '</div>';
	echo '<div class="fourcol last">';
	do_action( 'woocommerce_before_shop_loop_custom_3' );
	echo '</div>';
	echo '</div>';
}
function woo_lift_after_content(){

	echo '<div class="woo-after-loop-cont clearfix">';
	echo '<div class="fourcol first">';
	do_action( 'woocommerce_after_shop_loop_custom_1' );
	echo '</div>';
	echo '<div class="fourcol">';
	do_action( 'woocommerce_after_shop_loop_custom_2' );
	echo '</div>';
	echo '<div class="fourcol last">';
	do_action( 'woocommerce_after_shop_loop_custom_3' );
	echo '</div>';
	echo '</div>';
	if(is_user_logged_in()){
	echo '<div class="woo-after-loop-notice clearfix">*Discount applicable to goods only when ordered online</div>';
	}
}


/* Modify Complere Lifts Section
******************************************************************/

add_action( 'woocommerce_before_main_content', 'woo_complete_lifts_layout_hack' );

function woo_complete_lifts_layout_hack(){

	if(($partent =  woo_get_ancestor()) && ($partent == 28 || $partent == 33)){
		// Sale Badge
		remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
		// Remove add to cart button
		remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
		// Remove raiting
		remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
		// Remove Price
		remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
		// Remove Results Count
		remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
		// Remove Ordering
		remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

	}
}
// Remove Category Count
add_filter( 'woocommerce_subcategory_count_html', 'wc_hide_category_count' );
function wc_hide_category_count() {}

function wc_add_meta_query($q) {
	global $wp_query, $post, $woocommerce;


	if ( ! $q->is_main_query() ) return;
	if ( ! is_tax('product_cat') ) return;

	if ( ! is_admin() ) {
		$current_cat   = $wp_query->queried_object;
		if($current_cat->parent == 0){
			$parentid = $current_cat->term_id;
		}else{
			if($ancestors = get_ancestors( $current_cat->term_id, 'product_cat' )){
				foreach ( $ancestors as $ancestor ) {
				$ancestor = get_term( $ancestor, 'product_cat' );
					if($ancestor->parent == 0){
						$parentid = $ancestor->term_id;
					}
				}
			}
		}

		if(isset($parentid) && ($parentid == 28 || $parentid == 33)) {
			$q->set( 'tax_query', array(array(
				'taxonomy' => 'product_cat',
				'field' => 'slug',
				'include_children' => 0,
				'terms' => array( $current_cat->slug ),
				'operator' => 'IN'
			)));

		}
	}
}
add_filter('pre_get_posts','wc_add_meta_query');

add_filter('woocommerce_product_subcategories_args', 'woocommerce_show_empty_categories');
function woocommerce_show_empty_categories($cat_args){
	$cat_args['hide_empty']=0;
	return $cat_args;
}

add_action('wc_after_shop_loop', 'wc_after_shop_loop_image_boxes');
function wc_after_shop_loop_image_boxes() {
	global $wp_query;
	if(is_product_category() && $current_cat  = $wp_query->queried_object){
		if($image_boxes = get_field('image_boxes', $current_cat)){
			foreach($image_boxes as $image_box){
				echo '<div class="category-image-box clearfix">';
				echo '<a href="'.$image_box['link'].'" title="'.$image_box['title'].'">';
				echo '<img src="'.$image_box['image'].'" alt="'.$image_box['title'].'">';
				echo '</a>';
				echo '</div>';
			}
		}
	}
}
/* Filters */
add_filter('woocommerce_layered_nav_link', 'wc_layered_nav_link');

function wc_layered_nav_link($link){
	global $wp_query;

	// Orderby
	if ( isset( $_GET['product_cat'] ) ) {
		$link = add_query_arg( 'product_cat', $_GET['product_cat'], $link );
	}
	return $link;
}

/* Only Registered Users
******************************************************************/
//add_filter('woocommerce_get_price_html','wc_members_only_price');
function wc_members_only_price($price){
	if(is_user_logged_in() ){
		return $price;
	}
	else return '';
}

function wc_members_only_cart(){
	if (!is_admin()) {
		if ( is_user_logged_in()) {
			$user_id = get_current_user_id();
			$approved_status = get_user_meta($user_id, 'wp-approve-user', true);
			if ( empty($approved_status) || $approved_status == 0 ) {
				if(function_exists('wc_empty_cart')){
					wc_empty_cart();
				}
			}
		}else{
			if(function_exists('wc_empty_cart')){
				wc_empty_cart();
			}
		}
	}
}
add_action('init', 'wc_members_only_cart');

function wc_member_only(){
	if ( is_user_logged_in()) {
		$user_id = get_current_user_id();
		$approved_status = get_user_meta($user_id, 'wp-approve-user', true);
		if ( empty($approved_status) || $approved_status == 0 ) {
			$redirect = esc_url( get_permalink( wc_get_page_id( 'myaccount' ) ) );
			wp_redirect( apply_filters( 'woocommerce_registration_redirect', $redirect ) );
			exit;
		}
	}else{
		$redirect = esc_url( get_permalink( wc_get_page_id( 'myaccount' ) ) );
		wp_redirect( apply_filters( 'woocommerce_registration_redirect', $redirect ) );
		exit;
	}
}
/*
function wc_user_autologout(){
	if ( is_user_logged_in()) {
		$user_id = get_current_user_id();
		$approved_status = get_user_meta($user_id, 'wp-approve-user', true);
		if ( empty($approved_status) || $approved_status == 0 ) {
			wp_logout_url( get_permalink(wc_get_page_id('myaccount')) . "?approved=false" );
			wp_logout();
		}
	}
}
*/
//add_action('init', 'wc_user_autologout');
//add_action('woocommerce_before_my_account', 'wc_user_autologout', 2);

remove_action('init', array('WC_Form_Handler','process_registration'));
add_action('init', 'wc_extened_process_registration');


function wc_extened_process_registration(){
	if ( ! empty( $_POST['register'] ) ) {

		wp_verify_nonce( $_POST['register'], 'woocommerce-register' );

		// Anti-spam trap
		if ( ! empty( $_POST['email_2'] ) ) {
			wc_add_notice( '<strong>' . __( 'ERROR', 'woocommerce' ) . '</strong>: ' . __( 'Anti-spam field was filled in.', 'woocommerce' ), 'error' );
			return;
		}

		// Get fields
		$username = isset( $_POST['username'] ) ? wc_clean( $_POST['username'] ) : '';

		$user_email = isset( $_POST['email'] ) ? sanitize_email( $_POST['email'] ) : '';
		$user_email_2 = isset( $_POST['email2'] ) ? sanitize_email( $_POST['email2'] ) : '';
		$password   = isset( $_POST['password'] ) ? trim( $_POST['password'] ) : '';
		$password2  = isset( $_POST['password2'] ) ? trim( $_POST['password2'] ) : '';

		$firstname = isset( $_POST['firstname'] ) ? trim( $_POST['firstname'] ) : '';
		$lastname = isset( $_POST['lastname'] ) ? trim( $_POST['lastname'] ) : '';
		$company = isset( $_POST['company'] ) ? trim( $_POST['company'] ) : '';
		$address_1 = isset( $_POST['address_1'] ) ? trim( $_POST['address_1'] ) : '';
		$city = isset( $_POST['city'] ) ? trim( $_POST['city'] ) : '';
		$state = isset( $_POST['state'] ) ? trim( $_POST['state'] ) : '';
		$postcode = isset( $_POST['postcode'] ) ? trim( $_POST['postcode'] ) : '';
		$country = isset( $_POST['country'] ) ? trim( $_POST['country'] ) : '';
		$phone = isset( $_POST['phone'] ) ? trim( $_POST['phone'] ) : '';
		$sameasbilling = isset( $_POST['sameasbilling'] ) ? trim( $_POST['sameasbilling'] ) : '';
		$s_address_1 = isset( $_POST['s_address_1'] ) ? trim( $_POST['s_address_1'] ) : '';
		$s_city = isset( $_POST['s_city'] ) ? trim( $_POST['s_city'] ) : '';
		$s_postcode = isset( $_POST['s_postcode'] ) ? trim( $_POST['s_postcode'] ) : '';
		$s_state = isset( $_POST['s_state'] ) ? trim( $_POST['s_state'] ) : '';
		$s_country = isset( $_POST['s_country'] ) ? trim( $_POST['s_country'] ) : '';

		$promo_code = isset( $_POST['promo_code'] ) ? trim( $_POST['promo_code'] ) : '';

		// username

		if ( ! empty( $username ) ) {
			$username = sanitize_user( $username );

			if ( ! validate_username( $username ) ) {
				wc_add_notice( '<strong>' . __( 'ERROR', 'woocommerce' ) . '</strong>: ' . __( 'This username is invalid because it uses illegal characters. Please enter a valid username.', 'woocommerce' ), 'error' );
				return;
			}

			if ( username_exists( $username ) ) {
				wc_add_notice( '<strong>' . __( 'ERROR', 'woocommerce' ) . '</strong>: ' . __( 'An account is already registered with that username. Please choose another.', 'woocommerce' ), 'error' );
				return;
			}

		}else{
			wc_add_notice( '<strong>' . __( 'ERROR', 'woocommerce' ) . '</strong>: ' . __( 'Please enter a username.', 'woocommerce' ), 'error' );
			return;
		}

		// Password
		if( ! empty( $password ) || ! empty( $password2 )) {

			if($password !== $password2){
				wc_add_notice( '<strong>' . __( 'ERROR', 'woocommerce' ) . '</strong>: ' . __( 'Your passwords do not match.', 'woocommerce' ), 'error' );
				return;
			}
		}else{
			wc_add_notice( '<strong>' . __( 'ERROR', 'woocommerce' ) . '</strong>: ' . __( 'Please enter an account password.', 'woocommerce' ), 'error' );
			return;
		}

		// Emails
		if( ! empty( $user_email ) || ! empty( $user_email_2 )) {
			if( !is_email( $user_email ) ) {
				wc_add_notice( '<strong>' . __( 'ERROR', 'woocommerce' ) . '</strong>: ' . __( 'The email address isn&#8217;t correct.', 'woocommerce' ), 'error' );
				return;
			}
			if( email_exists( $user_email) ) {
				wc_add_notice( '<strong>' . __( 'ERROR', 'woocommerce' ) . '</strong>: ' . __( 'This email is already registered, please choose another one.', 'woocommerce' ), 'error' );
				return;
			}
			if($user_email !== $user_email_2){
				wc_add_notice( '<strong>' . __( 'ERROR', 'woocommerce' ) . '</strong>: ' . __( 'Your email addresses do not match.', 'woocommerce' ), 'error' );
				return;
			}
		}else{
			wc_add_notice( '<strong>' . __( 'ERROR', 'woocommerce' ) . '</strong>: ' . __( 'Please type your e-mail address.', 'woocommerce' ), 'error' );
			return;
		}
		if($country == 'GB'){
			if($postcode == ''){
				wc_add_notice( '<strong>' . __( 'ERROR', 'woocommerce' ) . '</strong>: ' . __( 'Please, fill in all the required fields.', 'woocommerce' ), 'error' );
			return;
			}
		}
		if($firstname == '' || $lastname == '' || $company == '' || $address_1 == '' || $city == '' || $state == '' || $country == '' || $phone == '') {
			wc_add_notice( '<strong>' . __( 'ERROR', 'woocommerce' ) . '</strong>: ' . __( 'Please, fill in all the required fields.', 'woocommerce' ), 'error' );
			return;
		} else {
			if($sameasbilling != 'sameasbilling'){
				if($s_address_1 == '' || $s_city == '' || $s_state == '' || $s_country == ''){
					wc_add_notice( '<strong>' . __( 'ERROR', 'woocommerce' ) . '</strong>: ' . __( 'Please, fill in all the required fields.', 'woocommerce' ), 'error' );
					return;
				}
			}
		}

		$new_customer_data = apply_filters( 'woocommerce_new_customer_data', array(
			'user_login' => $username,
			'user_pass'  => $password,
			'user_email' => $user_email,
			'role'       => 'customer'
		) );

		$customer_id = wp_insert_user( $new_customer_data );

		if ( is_wp_error( $customer_id ) ) {
			wc_add_notice( '<strong>' . __( 'ERROR', 'woocommerce' ) . '</strong>: ' . __( 'Couldn&#8217;t register you&hellip; please contact us if you continue to have problems.', 'woocommerce' ), 'error' );
			return;
		}

		//wc_set_customer_auth_cookie( $new_customer );

		// Action
		do_action( 'woocommerce_created_customer', $customer_id );

		 // Get user
		$current_user = get_user_by( 'id', $customer_id );

		// send the user a confirmation and their login details
		//$mailer = new WC_Emails;
		//$mailer->customer_new_account( $customer_id, $password );
		
		$nucmessage = $username. ' - ' . $user_email . ' is pending for review.';
		wp_mail( 'info@shorts-lifts.co.uk', 'New User Has Registered', $nucmessage );

		wc_add_notice( __( 'Your account is pending and will be reviewed shortly. You will get email confirmation when your account has been activated by the Shorts Team. If you have any questions, please contact us on 01274 305 066.', 'woocommerce'), 'error' );

		// Redirect
		if ( wp_get_referer() ) {
			$redirect = esc_url( wp_get_referer() );
		} else {
			$redirect = esc_url( get_permalink( wc_get_page_id( 'myaccount' ) ) );
		}
		wp_redirect( apply_filters( 'woocommerce_registration_redirect', $redirect ) );

		exit;
	}
}


function wc_registration_message(){
	$not_approved_message = "
<p>Shorts is a Trade Only supplier and for reasons including but not limited to Health and Safety have a duty of care to only supply to Lift Companies, Qualified Lift Engineers and Building Service Companies employing Qualified Lift Engineers within the UK and Ireland.</p>
<p>All Account Applications will be reviewed for the relevant criteria before being approved.</p>
<p>If you’re not a member of the UK or Irish Lift Industries, please advise as to the nature of your enquiry and maybe we could provide assistance in the matter.</p>";

	echo '<div class="alert">'.$not_approved_message.'</div>';
}
add_action('woocommerce_before_customer_login_form', 'wc_registration_message', 2);

//Email Notifications
//Content parsing borrowed from: woocommerce/classes/class-wc-email.php
function wc_send_user_approve_email($user_id){

    global $woocommerce;
    //Instantiate mailer
    $mailer = new WC_Emails();

	if (!$user_id) return;

	$user = new WP_User($user_id);

	$user_id 	= $user_id;
	$user_login = stripslashes($user->user_login);
	$user_email = stripslashes($user->user_email);
	$user_pass  = "As specified during registration";

	$blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);

	//$subject  = apply_filters( 'woocommerce_email_subject_customer_new_account', sprintf( __( 'Your account on %s has been approved', 'woocommerce'), $blogname ), $user );
	$subject  = apply_filters( 'woocommerce_email_subject_customer_new_account', __( 'Your Online Account has been approved', 'woocommerce'), $user );

	//$email_heading  = "User $user_login has been approved";
	$email_heading  = "Your Online Account has been approved";

	// Buffer
	ob_start();

	// Get mail template
	wc_get_template('emails/customer-account-approved.php', array(
			'user_id'				=> $user_id,
			'user_login'    		=> $user_login,
			'user_pass'             => $user_pass,
			'blogname'              => $blogname,
			'email_heading' => $email_heading
   ));

	// Get contents
	$message = ob_get_clean();

	// Send the mail
	wc_mail( $user_email, $subject, $message, $headers = "Content-Type: text/htmlrn", $attachments = "" );
}
add_action('wpau_approve', 'wc_send_user_approve_email', 10, 1);

function wc_send_user_unapprove_email($user_id){
	return;
}
add_action('wpau_unapprove', 'wc_send_user_unapprove_email', 10, 1);

//Updating use meta after registration successful registration
add_action('woocommerce_created_customer','wc_adding_extra_reg_fields');

function wc_adding_extra_reg_fields($user_id) {
	extract($_POST);

	if(isset($firstname) && !empty($firstname))
		$firstname  = wc_clean($firstname);
	if(isset($lastname) && !empty($lastname))
		$lastname  = wc_clean($lastname);
	if(isset($company) && !empty($company))
		$company  = wc_clean($company);
	if(isset($branch) && !empty($branch))
		$branch  = wc_clean($branch);
	if(isset($address_1) && !empty($address_1))
		$address_1  = wc_clean($address_1);
	if(isset($address_2) && !empty($address_2))
		$address_2  = wc_clean($address_2);
	if(isset($city) && !empty($city))
		$city  = wc_clean($city);
	if(isset($state) && !empty($state))
		$state  = wc_clean($state);
	if(isset($postcode) && !empty($postcode))
		$postcode  = wc_clean($postcode);
	if(isset($country) && !empty($country))
		$country  = wc_clean($country);
	if(isset($phone) && !empty($phone))
		$phone  = wc_clean($phone);

	if(isset($sameasbilling) && !empty($sameasbilling))
		$sameasbilling  = wc_clean($sameasbilling);

	if(isset($s_address_1) && !empty($s_address_1))
		$s_address_1  = wc_clean($s_address_1);
	if(isset($s_address_2) && !empty($s_address_2))
		$s_address_2  = wc_clean($s_address_2);
	if(isset($s_city) && !empty($s_city))
		$s_city  = wc_clean($s_city);
	if(isset($s_state) && !empty($s_state))
		$s_state  = wc_clean($s_state);
	if(isset($s_postcode) && !empty($s_postcode))
		$s_postcode  = wc_clean($s_postcode);
	if(isset($s_country) && !empty($s_country))
		$s_country  = wc_clean($s_country);
	if(isset($s_phone) && !empty($s_phone))
		$s_phone  = wc_clean($s_phone);

	if(isset($promo_code) && !empty($promo_code))
		$promo_code  = wc_clean($promo_code);


    update_user_meta($user_id, 'first_name', $firstname);
	update_user_meta($user_id, 'billing_first_name', $firstname);
	update_user_meta($user_id, 'shipping_first_name', $firstname);

    update_user_meta($user_id, 'last_name', $lastname);
	update_user_meta($user_id, 'billing_last_name', $lastname);
	update_user_meta($user_id, 'shipping_last_name', $lastname);

	update_user_meta($user_id, 'company', $company);
	update_user_meta($user_id, 'billing_company', $company);
	update_user_meta($user_id, 'shipping_company', $company);

	//update_user_meta($user_id, 'branch', $branch);
	//update_user_meta($user_id, 'billing_branch', $branch);
	//update_user_meta($user_id, 'shipping_branch', $branch);

	update_user_meta($user_id, 'address_1', $address_1);
	update_user_meta($user_id, 'billing_address_1', $address_1);


	update_user_meta($user_id, 'address_2', $address_2);
	update_user_meta($user_id, 'billing_address_2', $address_2);


	update_user_meta($user_id, 'city', $city);
	update_user_meta($user_id, 'billing_city', $city);


	update_user_meta($user_id, 'state', $state);
	update_user_meta($user_id, 'billing_state', $state);


	update_user_meta($user_id, 'postcode', $postcode);
	update_user_meta($user_id, 'billing_postcode', $postcode);


	update_user_meta($user_id, 'country', $country);
	update_user_meta($user_id, 'billing_country', $country);


	update_user_meta($user_id, 'phone', $phone);
	update_user_meta($user_id, 'billing_phone', $phone);
	update_user_meta($user_id, 'shipping_phone', $phone);

	if($sameasbilling != 'sameasbilling'){
		update_user_meta($user_id, 'shipping_address_1', $s_address_1);
		update_user_meta($user_id, 'shipping_address_2', $s_address_2);
		update_user_meta($user_id, 'shipping_city', $s_city);
		update_user_meta($user_id, 'shipping_state', $s_state);
		update_user_meta($user_id, 'shipping_postcode', $s_postcode);
		update_user_meta($user_id, 'shipping_country', $s_country);
	}else{
		update_user_meta($user_id, 'shipping_address_1', $address_1);
		update_user_meta($user_id, 'shipping_address_2', $address_2);
		update_user_meta($user_id, 'shipping_city', $city);
		update_user_meta($user_id, 'shipping_state', $state);
		update_user_meta($user_id, 'shipping_postcode', $postcode);
		update_user_meta($user_id, 'shipping_country', $country);
	}

	update_user_meta($user_id, 'promo_code', $promo_code);
}

/* Minimum Order Number
******************************************************************/

add_action( 'woocommerce_checkout_process', 'wc_minimum_order_amount' );
add_action( 'woocommerce_before_cart' , 'wc_minimum_order_amount', 20 );

function wc_minimum_order_amount() {
	// Set this variable to specify a minimum order value
	$minimum = 15;
	//print_result(WC()->total);

	if ( WC()->cart->cart_contents_total < $minimum ) {

		if( is_cart() ) {

			wc_print_notice(
				sprintf( 'You must have an order with a minimum of %s to place your order, your current order total is %s.' ,
					woocommerce_price( $minimum ),
					woocommerce_price( WC()->cart->cart_contents_total )
				), 'error'
			);

		} else {

			wc_add_notice(
				sprintf( 'You must have an order with a minimum of %s to place your order, your current order total is %s.' ,
					woocommerce_price( $minimum ),
					woocommerce_price( WC()->cart->cart_contents_total )
				), 'error'
			);

		}
	}

}


/* Cart
******************************************************************/
remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display', 10 );
add_action( 'woocommerce_after_cart', 'woocommerce_cross_sell_display', 10 );

add_filter( 'wc_add_to_cart_message', 'woo_custom_add_to_cart_message' );
function woo_custom_add_to_cart_message(){
	$product_id = $_REQUEST[ 'add-to-cart' ];
	$quantity = $_REQUEST[ 'quantity' ];

	if ( is_array( $product_id ) ) {

		$titles = array();

		foreach ( $product_id as $id ) {
			$titles[] = get_the_title( $id );
		}

		$added_text = sprintf( __( 'Added &quot;%s&quot; to your basket.', 'woocommerce' ), join( __( '&quot; and &quot;', 'woocommerce' ), array_filter( array_merge( array( join( '&quot;, &quot;', array_slice( $titles, 0, -1 ) ) ), array_slice( $titles, -1 ) ) ) ) );

	} else {
		$added_text = sprintf( __( '%s &times; &quot;%s&quot; was successfully added to your basket.', 'woocommerce' ), $quantity, get_the_title( $product_id ) );
	}

	// Output success messages
	if ( get_option( 'woocommerce_cart_redirect_after_add' ) == 'yes' ) :

		$return_to 	= apply_filters( 'woocommerce_continue_shopping_redirect', wp_get_referer() ? wp_get_referer() : home_url() );
		$message = $added_text;
		//$message 	= sprintf('<a href="%s" class="button wc-forward">%s</a> %s', $return_to, __( 'Continue Shopping', 'woocommerce' ), $added_text );

	else :
		$message = $added_text;
		//$message 	= sprintf('<a href="%s" class="button wc-forward">%s</a> %s', get_permalink( wc_get_page_id( 'cart' ) ), __( 'View Cart', 'woocommerce' ), $added_text );

	endif;

	return $message;

}

add_filter('woocommerce_cart_totals_coupon_label', 'woo_custom_cart_totals_coupon_label');
function woo_custom_cart_totals_coupon_label( $coupon ){

	$coupon = str_replace ( "Coupon:" , "Discount Code -" , $coupon );

	if( $coupon == 'Discount Code - onlinediscount'){
		$coupon = 'Online Discount';
	}
	return $coupon;
}

add_action( 'woocommerce_before_cart', 'woo_custom_apply_matched_coupons', 10 );

function woo_custom_apply_matched_coupons(){

	$coupon_code = 'onlinediscount'; // your coupon code here
	if ( WC()->cart->has_discount( $coupon_code ) )
	return;

    if ( WC()->cart->cart_contents_total > 0 ) {
        WC()->cart->add_discount( $coupon_code );
		wc_clear_notices();
    }

}

/* Checkout
******************************************************************/
remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_login_form', 10 );
remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );

add_action( 'woocommerce_billing_checkout_coupon_form', 'woocommerce_checkout_coupon_form', 10 );

/* Account
******************************************************************/

function get_purchase_order_number($orderid){
	$po_number = get_post_meta( $orderid, 'po_number', true);
	return $po_number;
}

add_action( 'woocommerce_save_account_details', 'woo_save_account_details' );
function woo_save_account_details( $user_id ){

	$phone = ! empty( $_POST['account_phone'] ) ? wc_clean( $_POST['account_phone'] ) : '';
	update_user_meta($user_id, 'phone', $phone);

	$company = ! empty( $_POST['account_company'] ) ? wc_clean( $_POST['account_company'] ) : '';
	update_user_meta($user_id, 'company', $company);

	$branch = ! empty( $_POST['account_branch'] ) ? wc_clean( $_POST['account_branch'] ) : '';
	update_user_meta($user_id, 'branch', $branch);
}
add_filter( 'woocommerce_get_country_locale', 'woo_custom_get_country_locale' );
function woo_custom_get_country_locale($fields){

	$fields['IE'] = array(
		'postcode'  => array(
			'label'       => __( 'Postcode', 'woocommerce' ),
			'placeholder' => __( 'Postcode', 'woocommerce' ),
			'required'    => false,
		),
		'state'     => array(
			'label'       => __( 'County', 'woocommerce' ),
			//'placeholder' => __( 'County', 'woocommerce' ),
			'required'    => false
		)

	);
	$fields['GB'] = array(
		'postcode'  => array(
			'label'       => __( 'Postcode', 'woocommerce' ),
			'placeholder' => __( 'Postcode', 'woocommerce' ),
		),
		'state'     => array(
			'label'       => __( 'County', 'woocommerce' ),
			//'placeholder' => __( 'County', 'woocommerce' ),
			'required'    => false
		)
	);
	

	return $fields;
}

add_filter( 'woocommerce_default_address_fields', 'woo_custom_address_fields' );
function woo_custom_address_fields( $address_fields ) {
	global $wp;
	$address_fields['address_1']['placeholder'] = __('Address Line 1', 'shorts');
	$address_fields['address_2']['placeholder'] = __('Address Line 2', 'shorts');

	$address_fields['city']['placeholder'] = "";

	$address_fields['state']['label'] = __('County', 'shorts');
	$address_fields['state']['placeholder'] = "";

	$address_fields['postcode']['label'] = __('Postcode', 'shorts');
	$address_fields['postcode']['placeholder'] = "";

	$address_fields['company']['required'] = true;

	if(is_wc_endpoint('edit-address') && $wp->query_vars['edit-address'] === 'add-new-address'){
		$extrafields = array(
			'multiple_customer_adresses_name' => array(
				'label' => __('Name of address (ie. home, office)','mcsafw'),
				'class' => array('form-row-wide'),
				'required' => 1,
			),
		);
		$address_fields = array_merge( $extrafields, $address_fields );

	}

	return $address_fields;
}
/* Emails
******************************************************************/
//add_action( 'woocommerce_email_order_meta', 'woo_add_purchase_order_number_to_email' );
add_action( 'woocommerce_email_before_order_table', 'woo_add_purchase_order_number_to_email', 10, 2 );
function woo_add_purchase_order_number_to_email($order, $is_admin){
	$po_number = get_purchase_order_number($order->id);
	echo '<h2>Puchase Order Number: '.$po_number.'</h2>';
}
//add_filter('woocommerce_email_order_meta_keys', 'my_woocommerce_email_order_meta_keys');
function my_woocommerce_email_order_meta_keys( $keys ) {
	$keys['Puchase Order Number'] = 'po_number';
	return $keys;
}

/* Extra Fields for User */
add_action( 'show_user_profile', 'add_extra_fields_to_user' );
add_action( 'edit_user_profile', 'add_extra_fields_to_user' );
if (!function_exists('add_extra_fields_to_user')) {
	function add_extra_fields_to_user($user){
		?>
        <h3>Promo Code</h3>
        <table class="form-table">
            <tr>
                <th><label for="promo_code">Promo Code</label></th>
                <td><input type="text" name="promo_code" value="<?php echo esc_attr( get_the_author_meta( 'promo_code', $user->ID ) ); ?>" class="regular-text" /></td>
            </tr>

        </table>
        <?php
	}
}

add_action( 'personal_options_update', 'save_extra_fields_to_user' );
add_action( 'edit_user_profile_update', 'save_extra_fields_to_user' );
if ( !function_exists('save_extra_fields_to_user') ) {
	function save_extra_fields_to_user( $user_id ){
		update_user_meta( $user_id,'promo_code', sanitize_text_field( $_POST['promo_code'] ) );
	}
}

add_filter( 'woocommerce_get_product_attributes', 'woocommerce_display_extra_attribute', 20 );
function woocommerce_display_extra_attribute( $attributes ) {
	$_oem_part_number = get_post_meta( get_the_ID(), '_oem_part_number', true );
	if($_oem_part_number){
		$attribute = array(
			'name'         => 'Manufacturer Part Number',
			'value'        => $_oem_part_number,
			'is_visible'   => '1',
			'is_taxonomy'  => '0',
			'is_variation' => '0',
			'position'     => '10',
		);
		$attributes['oem_part_number'] = $attribute;
	}

	$_additional_product_info = get_post_meta( get_the_ID(), '_additional_product_info', true );
	if($_additional_product_info){
		$attribute = array(
			'name'         => 'Additional Information',
			'value'        => $_additional_product_info,
			'is_visible'   => '1',
			'is_taxonomy'  => '0',
			'is_variation' => '0',
			'position'     => '11',
		);
		$attributes['additional_product_info'] = $attribute;
	}

	return $attributes;
}
if( current_user_can('manage_options') ) {
add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );
}
function custom_override_checkout_fields( $fields ) {
     //$fields['order']['order_comments']['placeholder'] = 'My new placeholder';
	 //print_result($fields);
     return $fields;
}

add_filter( 'woocommerce_billing_fields', 'custom_woocommerce_billing_fields', 10, 1 );
function custom_woocommerce_billing_fields( $address_fields ) {

	$address_fields['billing_postcode']['validate'] = '';
	return $address_fields;
}

add_filter( 'woocommerce_shipping_fields', 'custom_woocommerce_shipping_fields', 10, 1 );
function custom_woocommerce_shipping_fields( $address_fields ) {

	$address_fields['shipping_postcode']['validate'] = '';
	return $address_fields;
}

function get_ie_postcodes(){
	$postcodes = array(
		'Dublin 1',
		'Dublin 2',
		'Dublin 3',
		'Dublin 4',
		'Dublin 5',
		'Dublin 6',
		'Dublin 7',
		'Dublin 8',
		'Dublin 9',
		'Dublin 10',
		'Dublin 11',
		'Dublin 12',
		'Dublin 13',
		'Dublin 14',
		'Dublin 15',
		'Dublin 16',
		'Dublin 17',
		'Dublin 18',
		'Dublin 19',
		'Dublin 20',
		'Dublin 21',
		'Dublin 22',
		'Dublin 23',
		'Dublin 24',
		'All other areas'
	);
	return $postcodes;
}