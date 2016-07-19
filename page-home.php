<?php
/*
Template Name: Page Home
*/
?>
<?php get_header(); ?>

<?php get_template_part('includes/blocks/block-slider', 'homepage');?>

<div id="content" class="content clearfix">

    <div class="container">
    
        <div id="main" class="clearfix" role="main">
        
            <div id="page-<?php the_ID(); ?>" <?php post_class(); ?>>
                
                <?php get_template_part('includes/blocks/block', 'section-boxes');?>
           
            </div>  <!-- /.page-<?php the_ID(); ?> -->
        
        </div>  <!-- / #main -->
        
    </div> 	<!-- /.container -->

</div>  <!-- / #content -->
<?php get_footer(); ?>