<?php
	$manufacturers = get_assisted_search_terms('pa_manufacturer');
	$categories = get_assisted_search_terms('pa_product-group');
	$subcategories = get_assisted_search_terms('pa_product-category');
	$a = get_assisted_search();
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('lift-spares-assisted-search-page clearfix'); ?>>
	
	<header class="entry-header">
		<!--<h1 class="entry-title"><?php the_title(); ?></h1>-->
	</header><!-- /entry-header -->
	<div class="entry-content">
		<?php the_content(); ?>
        <div class="row">
        	<form id="lift-spares-assisted-search" class="lift-spares-assisted-search" action="<?php echo get_term_link( 'lift-spares', 'product_cat' );?>" method="get">
            
                <div class="row">
                
                    <div class="fourcol first">
                    	
                        <label for="filter_manufacturer"><?php _e('Select Manufacturer', 'shorts');?></label>
                        <select name="filter_manufacturer" class="custom-select">
                            <option value=""><?php _e('Select a manufacturer', 'shorts');?></option>
                            <?php foreach($manufacturers as $manufacturer):?>
                            	<?php
									$result = "";
									$data = "";
									if( isset($a[$manufacturer->slug]) && !empty($a[$manufacturer->slug]) )
									$data = array_unique($a[$manufacturer->slug]);
									
									if(isset($data) && !empty($data)){
										$result = implode(" ", $data);
									}

								?>
                                
                                <option value="<?php echo $manufacturer->term_id;?>" data-product-group="<?php if(isset($result) && !empty($result)) echo  $result;?>">
									<?php echo $manufacturer->name;?>
                                </option>
                            <?php endforeach;?>
                        </select>
                        
                    </div>
                    
                    <div class="fourcol">
                    	
                        <label for="filter_product-group"><?php _e('Select Product Group', 'shorts');?></label>
                        <select name="filter_product-group" class="custom-select" disabled>
                            <option value=""><?php _e('Please select a manufacturer first', 'shorts');?></option>
                            <?php foreach($categories as $category):?>
                            <?php
								$result = "";
								$data = "";
								if( isset($a[$category->slug]) && !empty($a[$category->slug]) )
								$data = array_unique($a[$category->slug]);
								
								if(isset($data) && !empty($data)){
									$result = implode(" ", $data);
								}

							?> 
                                <option value="<?php echo $category->term_id;?>" data-product-category="<?php if(isset($result) && !empty($result)) echo  $result;?>" class="hidden"> 
									<?php echo $category->name;?>
                                </option>
                            
                            <?php endforeach;?>
                        </select>
 
                    </div>
                    <div class="fourcol last">
                    
                        <label for="filter_product-category"><?php _e('Select Product Category', 'shorts');?></label>
                        <select name="filter_product-category" class="custom-select" disabled>
                            <option value=""><?php _e('Please select a product type first', 'shorts');?></option>
                            <?php foreach($subcategories as $subcategory):?>
                            				
                            	<option value="<?php echo $subcategory->term_id;?>" class="hidden">
                                	<?php echo $subcategory->name;?>
                                </option>
                            
                           	<?php endforeach;?>
                        </select>
 
                    </div>
                
                </div>
                <div class="row text-center">
                	<p class=""><small><?php _e('* Select up to three items from the drop down menu and click search', 'shorts');?></small></p>
                </div>
                <div class="row text-center">
                	<input type="submit" name="" value="Search" class="button large next">
                </div>
            </form>
        </div>
        
	</div><!-- /entry-content -->

	<footer class="entry-footer">
		<div class="row text-center">
        	<div class="sixcol first">
        		<a href="<?php echo get_permalink(236);?>" class="button gray-light previous"><?php _e('Back to Lift Spares Search', GETTEXT_DOMAIN );?></a>
            </div>
            <div class="sixcol last">
            	<a href="<?php echo get_term_link( 'lift-spares', 'product_cat' );?>" class="button gray next"><?php _e('View All Products', GETTEXT_DOMAIN );?></a>
            </div>
        </div>
	</footer><!-- /entry-footer -->
</article><!-- /post-<?php the_ID(); ?> -->