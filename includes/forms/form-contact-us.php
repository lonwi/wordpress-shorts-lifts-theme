<?php if(is_user_logged_in()) {
	global $current_user, $product;
	$slname = $current_user->first_name.' '.$current_user->last_name;
	$slemail = $current_user->user_email;
	$slphone = get_user_meta( $current_user->ID, 'billing_phone', true );
	$slcompany = get_user_meta( $current_user->ID, 'billing_company', true );
}

if(isset($_POST['slsubmit'])){
	if(isset($_POST['slcompany'])){
		$slcompany = $_POST['slcompany'];
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
<div class="contact-form clearfix">

<form class="form-contact-form" id="form-contact-form" action="<?php echo get_permalink();?>" method="post">
	<input type="text" value="" class="hidden" name="email">
    <input type="text" value="" class="hidden" name="name">
	
    <div class="form-row">
    	<div class="sixcol first">
    		<label><?php _e('Your Name',GETTEXT_DOMAIN);?>:<span class="red">*</span></label>
			<input type="text" name="slname" value="<?php if(isset($slname)) echo $slname;?>" class="slname required">
        </div>
        <div class="sixcol last">
        	<label for="slcompany"><?php _e('Company Name',GETTEXT_DOMAIN);?>:</label>
            <input id="slcompany" type="text" name="slcompany" value="<?php if(isset($slcompany)) echo $slcompany;?>" class="slcompany">
        </div>
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
        
	<?php /*?>
    <div class="sixcol last">
        <?php $slsource_array = array(
            __('Family or Friend',GETTEXT_DOMAIN) 		=> __('Family or Friend',GETTEXT_DOMAIN),
        
            __('Email/Newsletter',GETTEXT_DOMAIN) 		=> __('Email/Newsletter',GETTEXT_DOMAIN),
            __('Website/Search Engine',GETTEXT_DOMAIN) 	=> __('Website/Search Engine',GETTEXT_DOMAIN),
            
            __('Magazine',GETTEXT_DOMAIN)	 			=> __('Magazine',GETTEXT_DOMAIN),
            __('Newspaper',GETTEXT_DOMAIN) 				=> __('Newspaper',GETTEXT_DOMAIN),
            __('Online Advertisement',GETTEXT_DOMAIN)	=> __('Online Advertisement',GETTEXT_DOMAIN),
            __('TV Advertisemen',GETTEXT_DOMAIN) 		=> __('TV Advertisemen',GETTEXT_DOMAIN),
            
            __('Facebook',GETTEXT_DOMAIN) 				=> __('Facebook',GETTEXT_DOMAIN),
            __('Twitter',GETTEXT_DOMAIN) 				=> __('Twitter',GETTEXT_DOMAIN),
            __('YouTube',GETTEXT_DOMAIN) 				=> __('YouTube',GETTEXT_DOMAIN),
            __('Other Social Media',GETTEXT_DOMAIN) 	=> __('Other Social Media',GETTEXT_DOMAIN),
            
        );
        ?>
        <label for="slsource"><?php _e('How did you find us?',GETTEXT_DOMAIN);?>:</label>
        <select id="slsource" name="slsource" class="slsource">
            <option value="">---</option>
            <?php foreach($slsource_array as $slsource_value => $slsource_name):?>
            <option value="<?php echo $slsource_value;?>" <?php if(isset($_POST['slsource']) && $_POST['slsource'] == $slsource_value) echo 'selected';?>><?php echo $slsource_name;?></option>	
            <?php endforeach;?>      
        </select>
    </div>
    <?php */?>

    
    <div class="form-row">
    	<label for="slmessage"><?php _e('Your Message',GETTEXT_DOMAIN);?>:<span class="red">*</span></label>
        <textarea id="slmessage" name="slmessage" class="slmessage required"><?php if(isset($slmessage)) echo $slmessage;?></textarea>
    </div>
    <div class="form-row">
    	<input type="submit" value="Submit" name="slsubmit" class="button next">
    </div>
</form>

</div>