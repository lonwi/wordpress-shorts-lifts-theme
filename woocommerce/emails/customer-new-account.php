<?php
/**
 * Customer new account email
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates/Emails
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$user = get_user_by( 'login', $user_login );
$user_first_name = $user->first_name;
?>

<?php do_action( 'woocommerce_email_header', $email_heading ); ?>
<p><?php echo $user_first_name;?>,</p>

<p><?php _e('Thank you for choosing Shorts for your Complete Lifts, Lift Components and Lift Spares.', 'shorts');?></p>
<p><?php _e('Your Online Account application is currently being processed, requests are normally approved within 1 hour but may on occasions take longer. If you have any questions regarding you application please contact us on 01274 305066.', 'shorts');?></p>
<p><?php _e('Please note that Online Accounts are only available to Lift Companies, Qualified Lift Engineers and Building Service Companies employing Qualified Lift Engineers operating within the UK and Ireland.', 'shorts');?></p>
<a href="http://shorts-lifts.us1.list-manage.com/subscribe?u=3b6abc33812fb1ff3c4c6c01a&id=f2934ecaf3" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/emails/lift-spares-catalogue.jpg" alt="Order Lift Spares Catalogue" /></a>
<?php do_action( 'woocommerce_email_footer' ); ?>