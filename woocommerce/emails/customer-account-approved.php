<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$user = get_user_by( 'login', $user_login );
$user_first_name = $user->first_name;
?>
<?php do_action( 'woocommerce_email_header', $email_heading ); ?>
<p><?php echo $user_first_name;?>,</p>

<p><?php _e('Thank you for choosing Shorts for your Complete Lifts, Lift Components and Lift Spares. Your Online Account has been approved and your account is now active.', 'shorts');?></p>
<p><strong><?php printf( __('Your username is %s', 'shorts'), $user_login);?></strong></p>
<p><?php _e('You can now login using the username and password that you created when registering.', 'shorts');?></p>
<p><?php _e('Your Online Account gives you 24/7 access to our ever expanding range of lift parts, components and many other benefits.', 'shorts');?></p>
<ul>
    <li><?php _e('Order parts online quickly and conveniently', 'shorts');?></li>
    <li><?php _e('Get 2% OFF all online order*', 'shorts');?></li>
    <li><?php _e('Up to date price information', 'shorts');?></li>
    <li><?php _e('Latest product and service information', 'shorts');?></li>
    <li><?php _e('Quick access to online order history', 'shorts');?></li>
    <li><?php _e('Exclusive offers and discounts', 'shorts');?></li>
    <li><?php _e('Exclusive prize draws', 'shorts');?></li>
</ul>
<p><em><?php _e('*excludes delivery', 'shorts');?></em></p>
<p><?php _e('If you have any questions, or problems, then please do not hesitate to contact us on 01274 305066 or <a href="mailto:info@shorts-lifts.co.uk">info@shorts-lifts.co.uk</a>', 'shorts');?></p>
<a href="http://shorts-lifts.us1.list-manage.com/subscribe?u=3b6abc33812fb1ff3c4c6c01a&id=f2934ecaf3" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/emails/lift-spares-catalogue.jpg" alt="Order Lift Spares Catalogue" /></a>
<?php do_action( 'woocommerce_email_footer' ); ?>