<?php
/**
 * Customer new account email
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates/Emails/Plain
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$user = get_user_by( 'login', $user_login );
$user_first_name = $user->first_name;

echo "= " . $email_heading . " =\n\n";

echo $user_first_name . ",\n\n";

echo "Thank you for choosing Shorts for your Complete Lifts, Lift Components and Lift Spares.\n\n";
echo "Your Online Account application is currently being processed, requests are normally approved within 1 hour but may on occasions take longer. If you have any questions regarding you application please contact us on 01274 305066.\n\n";
echo "Please note that Online Accounts are only available to Lift Companies, Qualified Lift Engineers and Building Service Companies employing Qualified Lift Engineers operating within the UK and Ireland.\n\n";

echo "\n=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=\n\n";

echo apply_filters( 'woocommerce_email_footer_text', get_option( 'woocommerce_email_footer_text' ) );
