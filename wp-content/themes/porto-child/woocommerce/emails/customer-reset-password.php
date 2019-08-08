<?php
/**
 * Customer Reset Password email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/customer-reset-password.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates/Emails
 * @version 3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) { 
	exit; // Exit if accessed directly.
}



 $user = get_userdatabylogin($user_login);
 
$userFirstname = get_user_meta($user->ID,'first_name',true);
if(!$userFirstname)
{
    $userFirstname = $user_login;
};
 
 
?>




<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="background: #f9f9f9;">


	<tbody>
		<tr> 
			<td align="center" valign="middle" style="background:#e0e3eb;" height="230">
				<img style="display:block; line-height:0px; font-size:0px; border:0px;" src="<?php echo SITE_URL(); ?>/wp-content/uploads/2019/02/logo.png" alt="logo">
			</td>
		</tr>

 <tr style="text-align: center;">
<td style="font-family:Playfair Display;font-weight:600;font-size: 25px;line-height:50px;color: #f8f8f8;background: #f05020;width: 600px !important;display: inline-block;padding: 20px 0;text-align: left;box-sizing: border-box;padding-left: 60px;">Password Change Request</td>
						</tr>

		<tr> 
			<td align="center">
				<table width="600" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-left:20px; margin-right:20px;background: #ffffff;padding:30px 60px;border-left: 11px solid #f05120;min-height: 220px;margin-top: -50px">
					<tbody>
						<tr>
						    
							<td style="font-family: Playfair Display;font-weight: 600;font-size: 30px;line-height: 50px;color: #333333;"><?php printf( esc_html__( 'Hi %s,', 'woocommerce' ), esc_html( $userFirstname ) ); ?></td>
						</tr>
 
 

 
						<tr>
							<td style="font-family: lato;font-size: 16px;line-height: 24px;font-weight: 300;color: #333333;">
							<p><?php printf( esc_html__( 'Someone has requested a new password for the following account on %s:', 'woocommerce' ), esc_html( wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES ) ) ); ?></p>
							<p><?php printf( esc_html__( 'Username: %s', 'woocommerce' ), esc_html( $user_login ) ); ?></p>
							<p><?php esc_html_e( 'If you didn\'t make this request, just ignore this email. If you\'d like to proceed:', 'woocommerce' ); ?></p>
							 
							<p><a href="<?php echo esc_url( add_query_arg( array( 'key' => $reset_key, 'id' => $user_id ), wc_get_endpoint_url( 'lost-password', '', wc_get_page_permalink( 'myaccount' ) ) ) ); ?>" style="font-weight: 700; color: #e84b08;text-decoration: none;">Click Here to reset your password </a></p> 
                            <p><?php esc_html_e( 'Thanks,', 'woocommerce' ); ?></p>
                                <p><a href="<?php echo site_url();?>" style="font-weight: 700; color: #e84b08;text-decoration: none;">Kitchen2Tables</a>.</p>
							</td>
						</tr>

					</tbody>
				</table>
			</td>
		</tr>

		<tr>
			<td align="center">
				<table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
					<tbody>
						<tr>
							<td align="center" valign="middle" height="100px;">
								<img style="display:block; line-height:0px; font-size:0px; border:0px;margin-bottom: 30px;margin-top: 15px;" src="<?php echo SITE_URL(); ?>/wp-content/uploads/2019/03/gray-logo.png" alt="footer logo">
							</td>
						</tr>
					</tbody>
				</table>

				<table align="center" width="150px" border="0" cellspacing="0" cellpadding="0">
					<tbody>
						<tr>
							<td align="center" width="30%" style="vertical-align: top;">
								<a href="#" target="_blank">
									<img src="<?php echo SITE_URL(); ?>/wp-content/uploads/2019/03/twitter.png" alt="twitter">
								</a>
							</td>

							<td align="center" class="margin" width="30%" style="vertical-align: top;">
								<a href="#" target="_blank">
									<img src="<?php echo SITE_URL(); ?>/wp-content/uploads/2019/03/facebook.png" alt="facebook">
								</a>
							</td>

							<td align="center" width="30%" style="vertical-align: top;">
								<a href="#" target="_blank">
									<img src="<?php echo SITE_URL(); ?>/wp-content/uploads/2019/03/instagram.png" alt="instagram">
								</a>
							</td>
						</tr>
					</tbody>
				</table>
			</td> 
		</tr>



		<tr>
			<td align="center">
				<table align="center" width="600" border="0" cellspacing="0" cellpadding="0" style="opacity: 0.7">
					<tbody>
						<tr>
							<td>
								<p style="font-family: lato, sans-serif;text-align: center; width: 100%; margin: 0 auto;color: #333;font-size: 14px;font-weight: 300; line-height: 24px;margin-top: 40px;">Kitchens2Tables, 1234 Street, City, State, Country.
									<br>
									<br> <span style="color: #333333">This email is intended for <span style="color: #e84b08"><?php if($user) {echo $user->user_email;} ?>
 
									
									</span>. You are receiving this email because you have registered on  </span>
									
									<a href="<?php echo site_url();?>" style="font-weight: 700; color: #e84b08;text-decoration: none;"><strong>Kitchen2Tables</strong></a>.
									
								</p>
								<ul style="text-align: center;margin-top: 30px;padding-left: 0;">
									<li style="display: inline-block; padding: 0 15px;"><a style="color: #f05120; font-weight: bold;" href="<?php echo site_url().'/privacy-policy/';?>">Privacy Policy</a></li>
<li style="display: inline-block; padding: 0 15px;"><a style="color: #f05120; font-weight: bold;" href="<?php echo site_url().'/terms-and-conditions/'?>">Terms and Conditions</a></li>
<li style="display: inline-block; padding: 0 15px;"><a style="color: #f05120; font-weight: bold;" href="<?php echo site_url().'/give-feedback/'?>">Feedback</a></li>
								</ul>
								<p style="font-family: lato, sans-serif;text-align: center; margin-top: 35px; color: #333333; font-weight: 300; margin-bottom: 15px;">©2019 - KitchensToTables  |   All right reserved</p>
							</td>
						</tr> 
					</tbody>
				</table>
			</td>
		</tr> 



	</tbody>
</table>










