<?php
/**
 * Login Form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.2.6
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>
<?php wc_print_notices(); ?>

<?php do_action( 'woocommerce_before_customer_login_form' ); ?>

<?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>

<div class="row" id="customer_login">

	<div class="sixcol first">

<?php endif; ?>

		<h2 class="title"><?php _e( 'Please Sign In', 'woocommerce' ); ?></h2>

		<form method="post" class="login">

			<?php do_action( 'woocommerce_login_form_start' ); ?>

			<p class="form-row form-row-wide">
				<label for="username"><?php _e( 'Username or Email Address', 'woocommerce' ); ?> <abbr title="required" class="required">*</abbr></label>
				<input type="text" class="input-text" name="username" id="username" value="<?php if ( ! empty( $_POST['username'] ) ) echo esc_attr( $_POST['username'] ); ?>" />
			</p>
			<p class="form-row form-row-wide">
				<label for="password"><?php _e( 'Password', 'woocommerce' ); ?> <abbr title="required" class="required">*</abbr></label>
				<input class="input-text" type="password" name="password" id="password"/>
			</p>

			<?php do_action( 'woocommerce_login_form' ); ?>
			<div class="form-separator clearfix">&nbsp;</div>
			<p class="form-row">
				<?php wp_nonce_field( 'woocommerce-login' ); ?>
				<input type="submit" class="button next" name="login" value="<?php _e( 'Sign In', 'woocommerce' ); ?>" /> 
                <input type="hidden" name="redirect" value="<?php echo esc_url(wp_get_referer());?>" />
				<label for="rememberme" class="inline">
					<input name="rememberme" type="checkbox" id="rememberme" value="forever" class="input-checkbox" /><?php _e( 'Remember me', 'woocommerce' ); ?>
				</label>
			</p>
			<p class="lost_password">
				Forgot your password? <a href="<?php echo esc_url( wc_lostpassword_url() ); ?>"><?php _e( 'Click here', 'woocommerce' ); ?></a>.
			</p>
			<?php do_action( 'woocommerce_login_form_end' ); ?>

		</form>

<?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>

	</div>

	<div class="sixcol last">
        
		<h2 class="title"><?php _e( 'Create an Account', 'woocommerce' ); ?></h2>
        
        <div class="create-account-button-container" <?php if(isset($_POST['register'])) echo 'style="display:none"';?>>
        <p><?php _e( 'Create an account to view product prices and place orders online.', 'woocommerce' ); ?></p>
                
        <p><a href="#register" class="button create-account-button next">Create Account</a></p>
        
        </div>

		<form id="register" method="post" class="register create-account-register-form" <?php if(isset($_POST['register'])) echo 'style="display:block"';?>>

			<?php do_action( 'woocommerce_register_form_start' ); ?>
            <?php /*
            <p class="form-row form-row-wide">
                <label for="s_country"><?php _e( 'Country', 'woocommerce' ); ?> <abbr title="required" class="required">*</abbr></label>
                <select name="s_country" id="s_country" class="custom-select">
                	<option value="GB">United Kingdom</option>
                    <option value="IE">Republic of Ireland</option>
                </select>
			</p>
            */?>
            <p class="form-row form-row-wide">
            	<label for="reg_company"><?php _e('Company Name', 'woocommerce'); ?> <abbr title="required" class="required">*</abbr></label>
				<input type="text" class="input-text required" name="company" id="reg_company" size="30" value="<?php if ( ! empty( $_POST['company'] ) ) echo esc_attr( $_POST['company'] ); ?>" />
            </p>
            
            <p class="form-row form-row-first">
            	<label for="reg_firstname"><?php _e('First Name', 'woocommerce'); ?> <abbr title="required" class="required">*</abbr></label>
				<input type="text" class="input-text required" name="firstname" id="reg_firstname" size="30" value="<?php if ( ! empty( $_POST['firstname'] ) ) echo esc_attr( $_POST['firstname'] ); ?>" />
            </p>
            
            <p class="form-row form-row-last">
            	<label for="reg_lastname"><?php _e('Last Name', 'woocommerce'); ?> <abbr title="required" class="required">*</abbr></label>
				<input type="text" class="input-text required" name="lastname" id="reg_lastname" size="30" value="<?php if ( ! empty( $_POST['lastname'] ) ) echo esc_attr( $_POST['lastname'] ); ?>" />
            </p>
            
            <!--
            <p class="form-row form-row-wide">
            	<label for="reg_branch"><?php _e('Branch Name', 'woocommerce'); ?></label>
				<input type="text" class="input-text" name="branch" id="reg_branch" size="30" value="<?php if ( ! empty( $_POST['branch'] ) ) echo esc_attr( $_POST['branch'] ); ?>" />
            </p>
            -->
            
            <p class="form-row form-row-first">
            	<label for="reg_phone"><?php _e( 'Phone', 'woocommerce' ); ?> <abbr title="required" class="required">*</abbr></label>
				<input type="text" class="input-text required" name="phone" id="reg_phone" size="30" value="<?php if ( ! empty( $_POST['phone'] ) ) echo esc_attr( $_POST['phone'] ); ?>" />
            </p>
            
            <p class="form-row form-row-last">
            	<label for="promo_code"><?php _e( 'Promo Code (Optional)', 'woocommerce' ); ?></label>
				<input type="text" class="input-text" name="promo_code" id="promo_code" size="30" value="<?php if ( ! empty( $_POST['promo_code'] ) ) echo esc_attr( $_POST['promo_code'] ); ?>" />
            </p>
			<fieldset>
			<legend><?php _e( 'Sign In Details', 'woocommerce' ); ?></legend>
			
            <?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>

				<p class="form-row form-row-wide">
					<label for="reg_username"><?php _e( 'Username', 'woocommerce' ); ?> <abbr title="required" class="required">*</abbr></label>
					<input type="text" class="input-text required" name="username" id="reg_username" value="<?php if ( ! empty( $_POST['username'] ) ) echo esc_attr( $_POST['username'] ); ?>" />
				</p>

			<?php endif; ?>
            <p class="form-row form-row-first">
				<label for="reg_email"><?php _e( 'Email Address', 'woocommerce' ); ?> <abbr title="required" class="required">*</abbr></label>
				<input type="email" class="input-email required required-match-1" name="email" id="reg_email" value="<?php if ( ! empty( $_POST['email'] ) ) echo esc_attr( $_POST['email'] ); ?>" />
			</p>
            
            <p class="form-row form-row-last">
				<label for="reg_email_2"><?php _e( 'Confirm Email Address', 'woocommerce' ); ?> <abbr title="required" class="required">*</abbr></label>
				<input type="email" class="input-email required required-match-1" name="email2" id="reg_email_2" value="<?php if ( ! empty( $_POST['email2'] ) ) echo esc_attr( $_POST['email2'] ); ?>" />
			</p>
            
            <div class="clear"></div>
			
			<?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>
	
				<p class="form-row form-row-first">
					<label for="reg_password"><?php _e( 'Password', 'woocommerce' ); ?> <abbr title="required" class="required">*</abbr></label>
					<input type="password" class="input-text required required-match-2" name="password" id="reg_password" />
				</p>
                
                <p class="form-row form-row-last">
					<label for="reg_password_2"><?php _e( 'Re-enter Password', 'woocommerce' ); ?> <abbr title="required" class="required">*</abbr></label>
					<input type="password" class="input-text required required-match-2" name="password2" id="reg_password_2" />
				</p>
				
                <div class="clear"></div>
			<?php endif; ?>
            </fieldset>
            
            <div class="form-separator clearfix">&nbsp;</div>
            <h4><?php _e( 'Billing Address', 'woocommerce' ); ?> </h4>
            
            <p class="form-row form-row-wide">
            	<label for="reg_address_1"><?php _e( 'Address', 'woocommerce' ); ?> <abbr title="required" class="required">*</abbr></label>
				<input type="text" class="input-text required" name="address_1" id="reg_address_1" size="30" value="<?php if ( ! empty( $_POST['address_1'] ) ) echo esc_attr( $_POST['address_1'] ); ?>" placeholder="<?php _e('Address Line 1', 'woocommerce');?>" />
            </p>
            
            <p class="form-row form-row-wide">

				<input type="text" class="input-text" name="address_2" id="reg_address_2" size="30" value="<?php if ( ! empty( $_POST['address_2'] ) ) echo esc_attr( $_POST['address_2'] ); ?>" placeholder="<?php _e('Address Line 2', 'woocommerce');?>" />
            </p>
			
            <p class="form-row form-row-first">
                <label for="reg_city"><?php _e( 'Town / City', 'woocommerce' ); ?> <abbr title="required" class="required">*</abbr></label>
                <input type="text" class="input-text required" name="city" id="reg_city" size="30" value="<?php if ( ! empty( $_POST['city'] ) ) echo esc_attr( $_POST['city'] ); ?>" placeholder="<?php _e( 'Town / City', 'woocommerce' ); ?>" />            </p>
                
            <p class="form-row form-row-last">
                <label for="reg_postcode"><?php _e( 'Postcode', 'woocommerce' ); ?> <abbr title="required" class="required">*</abbr></label>
                <input type="text" class="input-text required" name="postcode" id="reg_postcode" size="30" value="<?php if ( ! empty( $_POST['postcode'] ) ) echo esc_attr( $_POST['postcode'] ); ?>" placeholder="<?php _e( 'Postcode', 'woocommerce' ); ?>" />
			</p>
            
            <p class="form-row form-row-wide">
                <label for="reg_state"><?php _e( 'County', 'woocommerce' ); ?> <abbr title="required" class="required">*</abbr></label>
                <input type="text" class="input-text required" name="state" id="reg_state" size="30" value="<?php if ( ! empty( $_POST['state'] ) ) echo esc_attr( $_POST['state'] ); ?>" />
			</p>
            
            <p class="form-row form-row-wide">
                <label for="reg_country"><?php _e( 'Country', 'woocommerce' ); ?> <abbr title="required" class="required">*</abbr></label>
                <select name="country" id="reg_country" class="custom-select">
                	<option value="GB" <?php if($_POST['country'] == 'GB') echo 'selected="selected"';?>>United Kingdom</option>
                    <option value="IE" <?php if($_POST['country'] == 'IE') echo 'selected="selected"';?>>Republic of Ireland</option>
                </select>
			</p>
            
            
            <div class="hidden">
            
                <div class="form-separator clearfix">&nbsp;</div>
                
                <div class="row">
                    <div class="sixcol first">
                        <h4><?php _e( 'Shipping Address', 'woocommerce' ); ?></h4>
                    </div>
                    <div class="sixcol last">
                        <label class="inline last" for="sameasshipping"><input type="checkbox" value="sameasbilling" id="sameasbilling" name="sameasbilling" <?php if( !empty( $_POST['sameasbilling']) || !isset($_POST['register']) ) : ?> checked<?php endif;?>> <?php _e( 'Same as Billing Address', 'woocommerce' ); ?></label>
                    </div>
                </div>
                
                <div class="register-shipping">
                
                <p class="form-row form-row-wide">
                    <label for="s_address_1"><?php _e( 'Address', 'woocommerce' ); ?> <abbr title="required" class="required">*</abbr></label>
                    <input type="text" class="input-text required" name="s_address_1" id="s_address_1" size="30" value="<?php if ( ! empty( $_POST['s_address_1'] ) ) echo esc_attr( $_POST['s_address_1'] ); ?>" placeholder="<?php _e('Address Line 1', 'woocommerce');?>" />
                </p>
                
                <p class="form-row form-row-wide">
                    <input type="text" class="input-text" name="s_address_2" id="s_address_2" size="30" value="<?php if ( ! empty( $_POST['s_address_2'] ) ) echo esc_attr( $_POST['s_address_2'] ); ?>" placeholder="<?php _e('Address Line 2', 'woocommerce');?>" />
                </p>
                
                <p class="form-row form-row-first">
                    <label for="s_city"><?php _e( 'Town / City', 'woocommerce' ); ?> <abbr title="required" class="required">*</abbr></label>
                    <input type="text" class="input-text required" name="s_city" id="s_city" size="30" value="<?php if ( ! empty( $_POST['s_city'] ) ) echo esc_attr( $_POST['s_city'] ); ?>" placeholder="<?php _e( 'Town / City', 'woocommerce' ); ?>" />            </p>
                    
                <p class="form-row form-row-last">
                    <label for="s_postcode"><?php _e( 'Postcode', 'woocommerce' ); ?> <abbr title="required" class="required">*</abbr></label>
                    <input type="text" class="input-text required" name="s_postcode" id="s_postcode" size="30" value="<?php if ( ! empty( $_POST['s_postcode'] ) ) echo esc_attr( $_POST['s_postcode'] ); ?>" placeholder="<?php _e( 'Postcode', 'woocommerce' ); ?>"/>
                </p>
                
                <p class="form-row form-row-wide">
                    <label for="s_state"><?php _e( 'County', 'woocommerce' ); ?> <abbr title="required" class="required">*</abbr></label>
                    <input type="text" class="input-text required" name="s_state" id="s_state" size="30" value="<?php if ( ! empty( $_POST['s_state'] ) ) echo esc_attr( $_POST['s_state'] ); ?>" />
                </p>
                
                <p class="form-row form-row-wide">
                    <label for="s_country"><?php _e( 'Country', 'woocommerce' ); ?> <abbr title="required" class="required">*</abbr></label>
                    <select name="s_country" id="s_country" class="custom-select">
                        <option value="GB">United Kingdom</option>
                        <option value="IE">Republic of Ireland</option>
                    </select>
                </p>
                
                </div>
            
            </div> <!-- hidden shipping address form -->
            
			<!-- Spam Trap -->
			<div style="left:-999em; position:absolute;"><label for="trap"><?php _e( 'Anti-spam', 'woocommerce' ); ?></label><input type="text" name="email_2" id="trap" tabindex="-1" /></div>

			<?php do_action( 'woocommerce_register_form' ); ?>
			<?php do_action( 'register_form' ); ?>
			
            <div class="form-separator clearfix">&nbsp;</div>
            
            <p class="">
            	<label for="register_accept_terms" class="inline">
					<input name="register_accept_terms" type="checkbox" id="register_accept_terms" class="input-checkbox required" value="accept" />I have read and accept the <a href="<?php echo get_permalink('62707');?>" target="_blank">Online Account Terms and Conditions</a>
				</label>
            </p>
            
			<p class="form-row">
				<?php wp_nonce_field( 'woocommerce-register' ); ?>
				<input type="submit" class="button" name="register" value="<?php _e( 'Register', 'woocommerce' ); ?>" />
			</p>

			<?php do_action( 'woocommerce_register_form_end' ); ?>

		</form>

	</div>

</div>
<p class="text-right"><span class="required">*</span> Required fields</p>
<?php endif; ?>

<?php do_action( 'woocommerce_after_customer_login_form' ); ?>
