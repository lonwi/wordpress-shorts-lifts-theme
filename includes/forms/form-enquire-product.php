<?php if(is_user_logged_in()) {
	global $current_user, $product;
	$slname = $current_user->first_name.' '.$current_user->last_name;
	$slemail = $current_user->user_email;
	$slphone = get_user_meta( $current_user->ID, 'phone', true );
	$slpartnumber = $product->get_sku();
}

if(isset($_POST['slsubmit'])){
	if(isset($_POST['slpartnumber'])){
		$slpartnumber = $_POST['slpartnumber'];
	}
	if(isset($_POST['slname'])){
		$slname = $_POST['slname'];
	}
	if(isset($_POST['slemail'])){
		$slemail = $_POST['slemail'];
	}
	if(isset($_POST['slphone'])){
		$slphone = $_POST['slphone'];
	}
	if(isset($_POST['slmessage'])){
		$slmessage = $_POST['slmessage'];
	}
}


?>

<div class="enquire-form clearfix">

<h4 class="title"><?php _e('Enquire Now',GETTEXT_DOMAIN);?></h4>
<form class="" id="" action="<?php echo get_permalink();?>" method="post">
	<input type="text" value="" class="hidden" name="email">
    <input type="text" value="" class="hidden" name="name">
    
    <div class="form-row">
    	<label><?php _e('Part Number',GETTEXT_DOMAIN);?>:</label>
		<input type="text" name="slpartnumber" value="<?php if(isset($slpartnumber)) echo $slpartnumber;?>" class="slpartnumber">
    </div>
	
    <div class="form-row">
    	<label><?php _e('Your Name',GETTEXT_DOMAIN);?>:<span class="red">*</span></label>
		<input type="text" name="slname" value="<?php if(isset($slname)) echo $slname;?>" class="slname required">
    </div>
    
    <div class="form-row">
    	<div class="sixcol first">
        	<label><?php _e('Your Email',GETTEXT_DOMAIN);?>:<span class="red">*</span></label>
            <input type="text" name="slemail" value="<?php if(isset($slemail)) echo $slemail;?>" class="slemail required">
        </div>
        <div class="sixcol last">
       	 	<label for="slphone"><?php _e('Your Phone',GETTEXT_DOMAIN);?>:<span class="red">*</span></label>
            <input id="slphone" type="text" name="slphone" value="<?php if(isset($slphone)) echo $slphone;?>" class="slphone required">
        </div>
    </div>
   
    <div class="form-row">
    	<label for="slmessage"><?php _e('Your Message',GETTEXT_DOMAIN);?>:<span class="red">*</span></label>
        <textarea id="slmessage" name="slmessage" class="slmessage required"><?php if(isset($slmessage)) echo $slmessage;?></textarea>
    </div>
    <div class="form-row">
    	<input type="submit" value="Enquire" name="slsubmit" class="button next">
    </div>
</form>

</div>