<?php
function get_sl_slider($id){
	$result = '';
	if(!isset($id))
		return $result;
	
	$slides = get_field( 'slides', $id );
	
	if(isset($slides) && !empty($slides)){
		$result .= '<div class="sl-slider-container"><ul id="sl-slider-'.$id.'" class="sl-slider sl-slider-'.$id.'">';
		foreach($slides as $slide){
			$result .= get_sl_slide($slide);
		}
		$result .= '</ul></div>';
		
	}
	
	$result .= '
	<script>
		jQuery(window).load(function() {
		var slSlider'.$id.' = jQuery("#sl-slider-'.$id.'");
		if(slSlider'.$id.'.length > 0){
			slSlider'.$id.'.bxSlider({
				auto: true,
				pause: 8000,
				pager: false,
				mode: "fade",
			});
		};
		});
	</script>';
	//print_result($slides);
	
	return $result;
}
function get_sl_slide($slide){
	$result = '';
	if(!isset($slide))
		return $result;
	
	$title = $slide['title'];
	$url = $slide['url'];
	$image = $slide['image'];
	if($url){
		$result = '<li><a href="'.$url.'" title="'.$title.'"><img src="'.$image.'" alt="'.$title.'"></a></li>';
	}else {
		$result = '<li><img src="'.$image.'" alt="'.$title.'"></li>';
	}
	
	return $result;
}