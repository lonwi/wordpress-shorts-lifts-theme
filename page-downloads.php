<?php
/*
Template Name: Page Downloads
*/
?>
<?php if( isset($_GET['download_id']) && !empty($_GET['download_id']) ):?>
<?php
$postid = $_GET['download_id'];
$terms = get_the_terms($postid, 'download-categories');
$restricted_category = get_field('restricted_category', $terms[0]);
if( $restricted_category == true && !is_user_logged_in()){
	wp_safe_redirect( get_permalink( 7 )); exit;
}else{
	$download = get_field('file', $postid);
	if(isset($download) && !empty($download)){
		$fullsize_path = get_attached_file( $download['id'] );
		header('Content-Type: '.$download['mime_type'].'');	
		header('Content-Disposition: attachment; filename="'.basename($fullsize_path).'"');
		header('Content-Transfer-Encoding: Binary'); 
		readfile($fullsize_path);
	}
	exit;
}
?>
<?php else:?>
<?php get_header(); ?>
<div id="content" class="content clearfix">
    
    <div class="container">
        
        <div id="main" class="clearfix" role="main">

            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <?php get_template_part( 'includes/content/content', 'page-downloads' ); ?>
            <?php endwhile; ?>	
            <?php else : ?>
                <?php get_template_part( 'includes/content/content', 'not-found' ); ?>
            <?php endif; ?>
        
        </div> <!-- / #main -->
        
    </div> <!-- / .container -->

</div>  <!-- / #content -->
<?php get_footer(); ?>
<?php endif;?>