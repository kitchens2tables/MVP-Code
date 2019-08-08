<?php
/**
 * Order details
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/order-details.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.5.2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( ! $order = wc_get_order( $order_id ) ) {
	return;
}

global $wpdb, $current_user;

$order_items           = $order->get_items( apply_filters( 'woocommerce_purchase_order_item_types', 'line_item' ) );
$show_purchase_note    = $order->has_status( apply_filters( 'woocommerce_purchase_note_order_statuses', array( 'completed', 'processing' ) ) );
$show_customer_details = is_user_logged_in() && $order->get_user_id() === get_current_user_id();
$downloads             = $order->get_downloadable_items();
$show_downloads        = $order->has_downloadable_item() && $order->is_download_permitted();

if ( $show_downloads ) {
	wc_get_template( 'order/order-downloads.php', array( 'downloads' => $downloads, 'show_title' => true ) );
}


if(isset($_POST['suborderfId']))
{
    update_post_meta($_POST['suborderfId'], '_sub_order_status', 'wc-cancelled');   
    
    
    $ordernote = array(
                            'comment_post_ID' => $_POST['orderfId'],
                            'comment_author' => $current_user->display_name,
                            'comment_author_email' => $current_user->user_email,
                            'comment_content' => 'Customer cancelled sub order '.$_POST['suborderfId'],
                            'comment_approved' => '1',
                            'comment_agent' => 'WooCommerce',
                            'comment_type' => 'order_note'
                        );
    wp_insert_comment($ordernote);
    
    
    main_order_status_update($_POST['orderfId']);
    
    sub_order_email_send($_POST['orderfId'], $_POST['suborderfId'], 'wc-cancelled', true, true); 
    
    unset($_POST);
    echo '<script>window.location.replace(window.location.href);</script>';
}

?>
<section class="woocommerce-order-details">
    <?php // do_action( 'woocommerce_order_details_before_order_table', $order );
     if(get_the_ID()!=7) { ?>
    <p>Order ID #<mark class="order-number" style="color: #f05021;font-size: 22px;font-weight: 700;">
        <?php echo $order_id; ?></mark> is currently <mark class="order-status" style="color: #f05021;font-size: 18px;font-weight: 600;"> <?php echo order_status_string(get_post_status($order_id)); ?></mark></p>
    <h2 class="woocommerce-order-details__title"><?php _e( 'Order details', 'woocommerce' ); ?></h2>

 <?php } ?>
    
    <?php 
    
    $OrderVendor = get_post_meta($order_id, '_commission_ids', true);
    
    foreach($OrderVendor as $commissionId)
    { 
        $soc++;
        $iVendorDetail = $wpdb->get_row( "SELECT * FROM {$wpdb->prefix}wcmp_vendor_orders where order_id='{$order_id}' and  commission_id = '{$commissionId}' ");
       
        $SubOrderStatus = get_post_meta($commissionId, '_sub_order_status', true);
        $sOrderSt = order_status_string($SubOrderStatus);
        
        
    ?>
    
    <div class="bg-light py-3 px-4 my-4">
        <div class="row sub-order-heading" >
            <div class="col-md-2" >
                <h5><span>#<?php echo $soc; ?></span> <?php _e( 'Sub Order details', 'woocommerce' ); ?></h5>
            </div>
            <div class="col-md-10 text-right" >
                <label> Sub order Id : <span><?php echo $commissionId ?></span> </label> &nbsp;|&nbsp; 
                <label> Sold By : <span><?php echo get_user_meta($iVendorDetail->vendor_id,'first_name', true).' '.get_user_meta($iVendorDetail->vendor_id,'last_name', true); ?> </span></label> &nbsp;|&nbsp; 
                <label> Order Status :<span> <?php echo $sOrderSt; ?> </span></label> 
                <?php if(empty($SubOrderStatus) || $SubOrderStatus=='wc-processing')
                { ?> &nbsp;|&nbsp; <label> <a data-toggle="collapse" href="#cancelorder<?php echo $soc; ?>" role="button" aria-expanded="false" aria-controls="collapseExample" > Cancel Order </a> </label>
 
                <div class="row" >
                <div class="col-md-6 offset-6 text-left" >
                <div class="collapse" id="cancelorder<?php echo $soc; ?>">
                  <div class="card card-body">
                    Do you wish to cancel this order?
                    <div class="row" >
                        <div class="col-md-2 text-center" >
                            <form method="post" action="" >
                                <input type="hidden" name="orderfId" value="<?php echo $order_id; ?>" >
                                <input type="hidden" name="suborderfId" value="<?php echo $commissionId; ?>" >
                                <button type="submit" class="btn btn-warning" > Yes </button> 
                            </form>
                        </div>
                        <div class="col-md-2 text-left" >
                          <button class="btn " data-toggle="collapse" href="#cancelorder<?php echo $soc; ?>" role="button" aria-expanded="false" aria-controls="collapseExample"  > No </button>
                        </div>
                    </div>    
                    </div>
                </div>
                    </div>
                      </div>
                 <?php } 
                elseif($SubOrderStatus=='wc-delivered')
                { ?> &nbsp;|&nbsp; <label> Delivery Date :<span> <?php echo get_post_meta($commissionId, '_delivery_date', true); ?> </span> </label> 
                &nbsp;|&nbsp; <a href="<?php echo SITE_URL(); ?>/customer-order-feedback/<?php echo $commissionId; ?>/"> Provide Feedback </a></label> 
 <?php } ?>
                    
                    
                    
                    
            </div>
        </div>
        <table class="woocommerce-table woocommerce-table--order-details shop_table order_details sub-order-table">
            <thead>
                    <tr>
                        <th class="woocommerce-table__product-name product-name"><?php _e( 'Product', 'woocommerce' ); ?></th>
                        <th class="woocommerce-table__product-name product-name"><?php _e( 'Quantity', 'woocommerce' ); ?></th>
                        <th class="woocommerce-table__product-table product-total"><?php _e( 'Sub Total', 'woocommerce' ); ?></th>
                    </tr>
            </thead>
            <tbody>
            <?php
            $iSubOrderItem = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}wcmp_vendor_orders where order_id='{$order_id}' and  commission_id = '{$commissionId}' ORDER BY created DESC"); 
            $subTotalPrice = 0;
            foreach($iSubOrderItem as $iSubOrderItemList)
            {
                $itemPrice = wc_get_order_item_meta( $iSubOrderItemList->order_item_id, '_line_subtotal', true );
                $subTotalPrice += $itemPrice;
                $order_item_woo = $wpdb->get_row("SELECT * FROM wp_woocommerce_order_items where order_item_id={$iSubOrderItemList->order_item_id} and order_item_type='line_item' "); 
            ?>    
                <tr>
                    <td> <?php echo $order_item_woo->order_item_name; ?> </td>
                    <td><?php echo wc_get_order_item_meta( $iSubOrderItemList->order_item_id, '_qty', true ); ?></td>
                    <td><?php echo wc_price($itemPrice); ?></td>
                </tr>
            <?php } ?>    
            </tbody>
        </table>
        <div class="row sub-order-footer " >
            <div class="col-md-12" >
                <h5> Total : <span><?php echo wc_price($subTotalPrice); ?></span> </h5>
            </div>    
        </div>
    </div>
    
    <?php } ?>
    
        

	<?php // do_action( 'woocommerce_order_details_after_order_table', $order ); ?>
</section>

        <?php if($order->customer_note){ echo '<div class="bg-light py-3 px-4"><b>Special Request</b> : '.$order->customer_note."</div>"; } ?> 

<?php
if ( $show_customer_details ) {
	wc_get_template( 'order/order-details-customer.php', array( 'order' => $order ) );
}
