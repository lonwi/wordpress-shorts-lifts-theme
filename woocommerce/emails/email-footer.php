<?php
/**
 * Email Footer
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates/Emails
 * @version     2.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$base = get_option( 'woocommerce_email_base_color' );
$aftercredit = "
	background: $base;
	border:0;
	color: #fff;
	font-family: Arial;
	font-size:12px;
	font-weight:700!important;
	line-height:125%;
	text-align:center;
";
?>
															</div>
														</td>
                                                    </tr>
                                                </table>
                                                <!-- End Content -->
                                            </td>
                                        </tr>
                                    </table>
                                    <!-- End Body -->
                                </td>
                            </tr>
                        	<tr>
                            	<td align="center" valign="top">
                                    <!-- Footer -->
                                	<table border="0" cellpadding="10" cellspacing="0" width="600" id="template_footer"  style="<?php echo $template_footer; ?>">
                                    	<tr>
                                        	<td valign="top">
                                                <table border="0" cellpadding="10" cellspacing="0" width="100%">
                                                    <tr>
                                                        <td colspan="3" valign="middle" id="credit">
                                                        	<?php echo wpautop( wp_kses_post( wptexturize( apply_filters( 'woocommerce_email_footer_text', get_option( 'woocommerce_email_footer_text' ) ) ) ) ); ?>
                                                        </td>
                                                    </tr>
                                                    <tr style="background:<?php echo $base;?>;">
                                                    	<td colspan="1" valign="middle" style="<?php echo $aftercredit;?>">
                                                        	<p><a href="http://www.shorts-lifts.co.uk" target="_blank" style="color:#fff; text-decoration:none; font-weight:700;">www.shorts-lifts.co.uk</a></p>
                                                        </td>
                                                        <td colspan="1" valign="middle" style="<?php echo $aftercredit;?>">
                                                        	<p>Northern Office: 01274 305 066</p>
                                                        </td>
                                                        <td colspan="1" valign="middle" style="<?php echo $aftercredit;?>">
                                                        	<p>Southern Office: 0208 228 1111</p>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                    <!-- End Footer -->
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </body>
</html>