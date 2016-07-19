<?php 
if($post->post_parent > 0){
	wp_redirect(get_permalink($post->post_parent));
}else{
	wp_redirect( home_url('/') );
}