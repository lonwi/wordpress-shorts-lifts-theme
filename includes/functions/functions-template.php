<?php
function truncate($text, $length = 100, $ending = '...', $exact = false, $considerHtml = true) {
	if ($considerHtml) {
		// if the plain text is shorter than the maximum length, return the whole text
		if (strlen(preg_replace('/<.*?>/', '', $text)) <= $length) {
			return $text;
		}
		// splits all html-tags to scanable lines
		preg_match_all('/(<.+?>)?([^<>]*)/s', $text, $lines, PREG_SET_ORDER);
		$total_length = strlen($ending);
		$open_tags = array();
		$truncate = '';
		foreach ($lines as $line_matchings) {
			// if there is any html-tag in this line, handle it and add it (uncounted) to the output
			if (!empty($line_matchings[1])) {
				// if it's an "empty element" with or without xhtml-conform closing slash
				if (preg_match('/^<(\s*.+?\/\s*|\s*(img|br|input|hr|area|base|basefont|col|frame|isindex|link|meta|param)(\s.+?)?)>$/is', $line_matchings[1])) {
					// do nothing
				// if tag is a closing tag
				} else if (preg_match('/^<\s*\/([^\s]+?)\s*>$/s', $line_matchings[1], $tag_matchings)) {
					// delete tag from $open_tags list
					$pos = array_search($tag_matchings[1], $open_tags);
					if ($pos !== false) {
					unset($open_tags[$pos]);
					}
				// if tag is an opening tag
				} else if (preg_match('/^<\s*([^\s>!]+).*?>$/s', $line_matchings[1], $tag_matchings)) {
					// add tag to the beginning of $open_tags list
					array_unshift($open_tags, strtolower($tag_matchings[1]));
				}
				// add html-tag to $truncate'd text
				$truncate .= $line_matchings[1];
			}
			// calculate the length of the plain text part of the line; handle entities as one character
			$content_length = strlen(preg_replace('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|[0-9a-f]{1,6};/i', ' ', $line_matchings[2]));
			if ($total_length+$content_length> $length) {
				// the number of characters which are left
				$left = $length - $total_length;
				$entities_length = 0;
				// search for html entities
				if (preg_match_all('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|[0-9a-f]{1,6};/i', $line_matchings[2], $entities, PREG_OFFSET_CAPTURE)) {
					// calculate the real length of all entities in the legal range
					foreach ($entities[0] as $entity) {
						if ($entity[1]+1-$entities_length <= $left) {
							$left--;
							$entities_length += strlen($entity[0]);
						} else {
							// no more characters left
							break;
						}
					}
				}
				$truncate .= substr($line_matchings[2], 0, $left+$entities_length);
				// maximum lenght is reached, so get off the loop
				break;
			} else {
				$truncate .= $line_matchings[2];
				$total_length += $content_length;
			}
			// if the maximum length is reached, get off the loop
			if($total_length>= $length) {
				break;
			}
		}
	} else {
		if (strlen($text) <= $length) {
			return $text;
		} else {
			$truncate = substr($text, 0, $length - strlen($ending));
		}
	}
	// if the words shouldn't be cut in the middle...
	if (!$exact) {
		// ...search the last occurance of a space...
		$spacepos = strrpos($truncate, ' ');
		if (isset($spacepos)) {
			// ...and cut the text in this position
			$truncate = substr($truncate, 0, $spacepos);
		}
	}
	// add the defined ending to the text
	$truncate .= $ending;
	if($considerHtml) {
		// close all unclosed html-tags
		foreach ($open_tags as $tag) {
			$truncate .= '</' . $tag . '>';
		}
	}
	return $truncate;
}

// determine the topmost parent of a term
function get_term_top_most_parent($term_id, $taxonomy){
    // start from the current term
    $parent  = get_term_by( 'id', $term_id, $taxonomy);
    // climb up the hierarchy until we reach a term with parent = '0'
    while ($parent->parent != '0'){
        $term_id = $parent->parent;

        $parent  = get_term_by( 'id', $term_id, $taxonomy);
    }
    return $parent;
}

function custom_pagination($pages = '', $range = 2)
{
     $showitems = ($range * 2)+1; 
 
     global $paged;
     if(empty($paged)) $paged = 1;
 
     if($pages == '')
     {
         global $wp_query;
         $pages = $wp_query->max_num_pages;
         if(!$pages)
         {
             $pages = 1;
         }
     }  
 
     if(1 != $pages)
     {
         echo "<nav class=\"pagination clearfix\">";
		 //echo "<span class=\"pagination-page\">Page ".$paged." of ".$pages."</span>";
         
		 if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagenum_link(1)."' class='first-page' title='".__("First Page", 'shorts')."'>".__("&laquo;", 'shorts')."</a>";
         if($paged > 1 && $showitems < $pages) echo "<a href='".get_pagenum_link($paged - 1)."' class='previous-page' title='".__("Previous Page", 'shorts')."'>".__("&lsaquo;", 'shorts')."</a>";
 
         for ($i=1; $i <= $pages; $i++)
         {
             if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
             {
                echo ($paged == $i)? "<span class=\"current page-number\">".$i."</span>":"<a href='".get_pagenum_link($i)."' class=\"inactive page-number\" title='".__("Page", 'shorts')." ".$i."'>".$i."</a>";
				if(1 != $pages && !($pages == $i || $i >= $paged+$range))
			 	{
				echo '<span class="separator">|</span>';
			 	}
             }
			 
         }
 
         if ($paged < $pages && $showitems < $pages) echo "<a href=\"".get_pagenum_link($paged + 1)."\" class='next-page' title='".__("Next Page", 'shorts')."'>".__("&rsaquo;", 'shorts')."</a>";
         if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($pages)."' class='last-page' title='".__("Last Page", 'shorts')."'>".__("&raquo;", 'shorts')."</a>";
         echo "</nav>\n";
     }
}

function print_result($result = ""){
	if($result != ""){
		echo '<pre>';
		print_r($result);
		echo '</pre>';
	}
}
add_action( 'websquare_before_header', 'shorts_contact_form_validation', 9999);

function shorts_contact_form_validation(){
	global $post;
	if(isset($post) && $post->ID == "11"){
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
				
				$slemail = esc_html($_POST["slemail"]);
				$slname = esc_html($_POST["slname"]);
				$slphone = esc_html($_POST['slphone']);
				$slcompany = esc_html($_POST['slcompany']);
				$slmessage = esc_textarea($_POST['slmessage']);
	
				// From
				$header = 'From: '.$slname.' <'.$slemail.'>' . "\r\n";
				// Details
				$message 	= "Name: " . $slname . "\n";
				$slcompany	.= "Company: " . $slcompany . "\n";
				$message 	.= "Email: " . $slemail . "\n";
				$message 	.= "Phone: " . $slphone . "\n";
				$message 	.= "Message: " . $slmessage . "\n\n";
	
				$to ='info@shorts-lifts.co.uk';
				//$to ='wojciech@websquare.co.uk';
				$subject = 'Contact Form Enquiry';
				if(wp_mail($to,$subject,$message,$header)){
					wc_add_notice( __( 'Thank you for contacting Shorts. We\'ll get back to you very soon. For urgent enquiries please call us on 01274 305066.', 'shorts' ), $notice_type = 'success' );
					$_POST['slname'] = '';
					$_POST['slemail'] = '';
					$_POST['slphone'] = '';
					$_POST['slcompany'] = '';
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
	}
}

function customize_customtaxonomy_archive_display ( $query ) {
    if (($query->is_main_query()) && (is_tax('download-categories'))){
         
    $query->set( 'posts_per_page', '16' );
    $query->set( 'orderby', 'menu_order' );
    $query->set( 'order', 'ASC' );
	}
}
add_action( 'pre_get_posts', 'customize_customtaxonomy_archive_display' );

function get_download_file_url($postid){
	$url = "";
	if(isset($postid) && !empty($postid)){
		$url = get_permalink(19).'?download_id='.$postid;
	}
	return $url;
}

function get_taxonomy_ancestor($current_cat = "" , $field = 'term_id', $taxonomy = 'product_cat' ){
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
				if($ancestors = get_ancestors( $current_cat->$field, $taxonomy )){
					foreach ( $ancestors as $ancestor ) {
					$ancestor = get_term( $ancestor, $taxonomy );
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
		
		if($ancestors = get_the_terms( $post->ID, $taxonomy )){
			foreach ( $ancestors as $ancestor ) {
				if($ancestor->parent == 0){
					$parent = $ancestor->$field;
					break;
				}
			}
			if($parent !== 0){
				$ancestor = $ancestors[0];
				$cat = get_term($ancestor->parent, $taxonomy);
				if(isset($cat->parent) && $cat->parent === 0){
					$parent = $cat->$field;
				}else{
					
					if($ancestors = get_ancestors( $ancestor->parent, $taxonomy )){
						
						foreach ( $ancestors as $ancestor ) {
						$ancestor = get_term( $ancestor, $taxonomy );
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