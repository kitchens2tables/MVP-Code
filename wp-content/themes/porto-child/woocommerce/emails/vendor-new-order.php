<?php
/**
 * The template for displaying demo plugin content.
 *
 * Override this template by copying it to yourtheme/dc-product-vendor/emails/vendor-new-order.php
 *
 * @author 		WC Marketplace
 * @package 	dc-product-vendor/Templates
 * @version   0.0.1
 */
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly 
global $WCMp;
$vendor = get_wcmp_vendor(absint($vendor_id));
?>


<?php
//do_action( 'woocommerce_email_header', $email_heading, $email );
?>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="background: #f9f9f9;">


<tbody>
<tr>
    <td align="center" valign="middle" style="background:#e0e3eb;" height="230">
        <img style="display:block; line-height:0px; font-size:0px; border:0px;" src="<?php echo SITE_URL(); ?>/wp-content/uploads/2019/02/logo.png" alt="logo">
    </td>
</tr>

                <tr style="text-align: center;">
                    <td style="font-family:Playfair Display;font-weight:600;font-size: 25px;line-height:50px;color: #f8f8f8;background: #f05020;width: 600px !important;display: inline-block;padding: 20px 0;text-align: left;box-sizing: border-box;padding-left: 60px;">New Order</td>
                </tr>

		<tr>
                    <td align="center">
                        <table width="600" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-left:20px; margin-right:20px;background: #ffffff;padding:30px 60px;border-left: 11px solid #f05120;min-height: 220px;margin-top: -50px">
                            <tbody>
                                <tr>
                                    <td style="font-family: lato;font-size: 16px;line-height: 24px;font-weight: 300;color: #333333;">
                                        
                                        <p><?php printf(__('A new order was received and marked as processing from %s. Their order is as follows:', 'dc-woocommerce-multi-vendor'), $order->get_billing_first_name() . ' ' . $order->get_billing_last_name()); ?></p>

                                        <?php do_action('woocommerce_email_before_order_table', $order, true, false); ?>
                                        <table cellspacing="0" cellpadding="6" style="width: 100%; border: 1px solid #eee;" border="1" bordercolor="#eee">
                                            <thead>
                                                <tr>
                                                    <?php do_action('wcmp_before_vendor_order_table_header', $order, $vendor->term_id); ?>
                                                    <th scope="col" style="text-align:left; border: 1px solid #eee;"><?php _e('Product', 'dc-woocommerce-multi-vendor'); ?></th>
                                                    <th scope="col" style="text-align:left; border: 1px solid #eee;"><?php _e('Quantity', 'dc-woocommerce-multi-vendor'); ?></th>
                                                    <th scope="col" style="text-align:left; border: 1px solid #eee;"><?php _e('Commission', 'dc-woocommerce-multi-vendor'); ?></th>
                                                    <?php do_action('wcmp_after_vendor_order_table_header', $order, $vendor->term_id); ?>
                                                </tr>
                                            </thead>
                                            <tbody class="hide-ul">
                                                <?php
                                                $vendor->vendor_order_item_table($order, $vendor->term_id);

                                                ?>
                                            </tbody>
                                        </table>
                                        <?php
                                        if (apply_filters('show_cust_order_calulations_field', true, $vendor->id)) {
                                            ?>
                                            <table cellspacing="0" cellpadding="6" style="width: 100%; border: 1px solid #eee;" border="1" bordercolor="#eee">
                                                <?php
                                                $totals = $vendor->wcmp_vendor_get_order_item_totals($order, $vendor->term_id);
                                                if ($totals) {
                                                    foreach ($totals as $total_key => $total) {
                                                        ?><tr>
                                                            <th scope="row" colspan="2" style="text-align:left; border: 1px solid #eee;"><?php echo $total['label']; ?></th>
                                                            <td style="text-align:left; border: 1px solid #eee;"><?php echo $total['value']; ?></td>
                                                        </tr><?php
                                                    }
                                                }
                                                ?>
                                            </table>
                                            <?php
                                        }
                                        if (apply_filters('show_cust_address_field', true, $vendor->id)) {
                                            ?>
                                            <h2><?php _e('Customer Details', 'dc-woocommerce-multi-vendor'); ?></h2>
                                            <?php if ($order->get_billing_email()) { ?>
                                                <p><strong><?php _e('Customer Name:', 'dc-woocommerce-multi-vendor'); ?></strong> <?php echo $order->get_billing_first_name() . ' ' . $order->get_billing_last_name(); ?></p>
                                                <p><strong><?php _e('Email:', 'dc-woocommerce-multi-vendor'); ?></strong> <?php echo $order->get_billing_email(); ?></p>
                                            <?php } ?>
                                            <?php if ($order->get_billing_phone()) { ?>
                                                <p><strong><?php _e('Telephone:', 'dc-woocommerce-multi-vendor'); ?></strong> <?php echo $order->get_billing_phone(); ?></p>
                                            <?php
                                            }
                                        }
                                        if (apply_filters('show_cust_billing_address_field', true, $vendor->id)) {
                                            ?>
                                            <table cellspacing="0" cellpadding="0" style="width: 100%; vertical-align: top;" border="0">
                                                <tr>
                                                    <td valign="top" width="50%">
                                                        <h3><?php _e('Billing Address', 'dc-woocommerce-multi-vendor'); ?></h3>
                                                        <p><?php echo $order->get_formatted_billing_address(); ?></p>
                                                    </td>
                                                </tr>
                                            </table>
                                            <?php }
                                        ?>

                                        <?php if (apply_filters('show_cust_shipping_address_field', true, $vendor->id)) { ?> 
                                            <?php if (( $shipping = $order->get_formatted_shipping_address())) { ?>
                                                <table cellspacing="0" cellpadding="0" style="width: 100%; vertical-align: top;" border="0">
                                                    <tr>
                                                        <td valign="top" width="50%">
                                                            <h3><?php _e('Shipping Address', 'dc-woocommerce-multi-vendor'); ?></h3>
                                                            <p><?php echo $shipping; ?></p>
                                                        </td>
                                                    </tr>
                                                </table>
                                            <?php
                                            }
                                        }
                                        ?>
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
                                                        <br> <span style="color: #333333">This email is intended for <span style="color: #e84b08"><?php $user = get_userdatabylogin($user_login);if($user) {echo $user->user_email;} ?></span>. You are receiving this email because you have registered on  </span>

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

<script>
     
    
         jQuery('table[id*=order-templ-create] tr td ul li:first-child').remove();

</script>
  
 

<?php //do_action('wcmp_email_footer'); ?>