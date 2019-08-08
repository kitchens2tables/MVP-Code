<?php

require( '../../../../wp-load.php' );
global $wpdb;

$order_id_data = $_GET['id'];
$commision_id_data = $_GET['commision_id'];
$order = wc_get_order($order_id_data);

$os= get_post_meta($commision_id_data, '_sub_order_status', true);

$date = new DateTime($order->date_created); 
$sql = "SELECT * FROM wp_commentmeta WHERE meta_key = 'vendor_order_id' and meta_value='$commision_id_data'";
$results = $wpdb->get_results($sql);
$comment_id=$results[0]->comment_id;
$sql1 = "SELECT * FROM wp_commentmeta WHERE comment_id = '$comment_id' and meta_key='vendor_rating'";
$results1 = $wpdb->get_results($sql1);



?>

<div class="watermark-heading">
	<h3>Order Details</h3>
	<div>Order Details</div>
</div>

<form method="post">
<div class="order-details  featured-box featured-box-primary" id="order-details_data">
    <div class="box-content text-left">
        <table id="O-detail">
        <tr>
            <td style="width:33%;">
                <legend>Sub Order number is: <strong class="text-orange"><?php  echo  $commision_id_data; ?></strong> </legend>
                <span>Main Order ID : <strong class="text-orange"><?php   echo $order_id_data; ?></strong></span><br>
                <span>Order Date : <?php   echo $date->format('m/d/Y'); ?></span>
            </td>
            <td style="width:33%;"><span class="mr-2">Status:</span>
                <?php
                if($os=="wc-delivered" || $os=="wc-failed" || $os=="wc-cancelled" || $order_status=="wc-cancelled"){ $disabled = 'disabled'; }
                
                if($os=="wc-processing" || !$os)
                    { 
                        $wcprocess = 'selected';
                        $disabledelivery = 'disabled="disabled"';
                    }
                elseif($os=="wc-ready")
                    { 
                        $wcready = 'selected';
                        $disableprocess = 'disabled="disabled"';
                        $disablecancel = 'disabled="disabled"';
                    }
                elseif($os=="wc-delivered")
                    { 
                        $wcdelivered = 'selected';
                        $disableprocess = 'disabled="disabled"';
                        $disableready = 'disabled="disabled"';
                        $disablecancel = 'disabled="disabled"';
                    }
                elseif($os=="wc-cancelled")
                    { 
                        $wccancel = 'selected';
                        $disableprocess = 'disabled="disabled"';
                        $disableready = 'disabled="disabled"';
                        $disabledelivery = 'disabled="disabled"';
                    }
                ?> 
                <span id="order_status_feedback" >
                    <select id="order_status" style="color:black;" <?php echo $disabled;?> >
                        <option value="wc-processing" <?php echo  $wcprocess.' '.$disableprocess;?> > Processing </option>
                        <option value="wc-ready" <?php echo $wcready.' '.$disableready;?> > Ready for pickup </option>
                        <option value="wc-delivered" <?php echo $wcdelivered.' '.$disabledelivery;?> > Delivered </option>
                        <option value="wc-cancelled" <?php echo $wccancel.' '.$disablecancel;?> > Cancelled </option>
                    </select>
                </span>    
                
            </td>
            <td style="width:33%;"><strong>Rating Received:</strong> 
            
            
            <?php
            
            
            
$rating = $results1[0]->meta_value; 


$totalRating = 5;
$starRating = $rating; 


for ($i = 1; $i <= $totalRating; $i++) {
     if($starRating < $i ) {
        if(is_float($starRating) && (round($starRating) == $i)){
            echo "<i class='fa fa-star-half-o' aria-hidden='true'></i>";
        }else{
            echo "<i class='fa fa-star-o'></i>";
        }
     }else {
        echo "<i class='fa fa-star' aria-hidden='true'></i>";
     }
}




?>
            
            
            
            
            
            </td>
        </tr>
        <tr>
            <td><h4 class="mb-1 text-dark">Billing Details:</h4><?php echo $order->get_formatted_shipping_address(); ?></td>
            <td><strong>Customer Feedback:</strong>
                <?php 
                $sql2 = "SELECT * FROM wp_comments WHERE comment_ID = '$comment_id'";
                $results2 = $wpdb->get_results($sql2);

                echo $results2[0]->comment_content;?>
            </td>
            <td>
                <?php
                $deliveryDatas = get_post_meta($commision_id_data, '_delivery_date', true);
                if($deliveryDatas){ ?><strong>Delivery Date :</strong>  <?php   echo $deliveryDatas;  } 
                ?>    
               
            </td>
        </tr>
        <?php if($order->customer_note){ ?>
        <tr >
            <td colspan="3"><?php if($order->customer_note){ echo '<div class="bg-light py-3 px-4"><b>Special Request</b> : '.$order->customer_note."</div>"; } ?> </td>
        </tr>
        <?php } ?>
    </table>
    </div>
</div>
<div class="porto-separator tall "><hr class="separator-line  align_center"></div>
<div class="second-order-details mb-5 featured-box featured-box-primary">
   <div class="box-content text-left p-0">
    <table class="mt-0 table-striped">
        <tr>
            <td></td>
            <td>Sr. No.</td>
            <td><strong>Dish Name</strong></td>
            <td><strong>Due date</strong></td>
            <td><strong>No of unit</strong></td>
            <td><strong>Price per unit</strong></td>
            <td><strong>Sub total</strong></td>
        </tr>
        
    <?php 
    $i = 1;
    $iVendorOrderItem = $wpdb->get_results("SELECT * FROM wp_wcmp_vendor_orders where commission_id={$commision_id_data} and order_id={$order_id_data} ORDER BY `wp_wcmp_vendor_orders`.`ID` DESC"); 
    $grandTotal = '';
    foreach ($iVendorOrderItem as $vendorOrderList)
    { 
        $subtotal = '';
        $subtotal = wc_get_order_item_meta( $vendorOrderList->order_item_id, '_line_subtotal', true );
        
        $order_item_woo = $wpdb->get_row("SELECT * FROM wp_woocommerce_order_items where order_item_id={$vendorOrderList->order_item_id} and order_item_type='line_item' "); 
        $grandTotal += $subtotal;
        ?><tr>
            <td></td>
            <td><?php echo $i++; ?></td>
            <td><?php echo $order_item_woo->order_item_name; ?></td>
            <td><?php echo get_post_meta($vendorOrderList->product_id,'_product_available_date',true); ?></td>
            <td><?php echo $vendorOrderList->quantity; ?></td>
            <td><?php echo get_woocommerce_currency_symbol().$subtotal/$vendorOrderList->quantity; ?></td>
            <td><?php echo get_woocommerce_currency_symbol().$subtotal; ?></td>
        </tr>
    <?php 
  } ?>
    
    
    </table>
    </div>
</div>
<legend>Total: <strong class="text-orange"><?php echo get_woocommerce_currency_symbol().$grandTotal; ?></strong> </legend>


    <span id="statusFeedback" ></span>
    <div class="form-group">
        <a href="javascript:void(0)" id="backtoorderlist" class="btn cm-default-btn" > Back </a>
        <?php if($os!="wc-delivered" && $os!="wc-cancelled"){ ?>
        <input type="button" class="btn cm-orange-btn pull-right" id="updateorderstatus" value="Update Order" name="submit">
        <?php } ?>
    </div>

</form>

<script>
    
   
    
jQuery(document).ready(function()
{
 jQuery("#updateorderstatus").click( function(e) {
 e.preventDefault();

    var order_status = jQuery("#order_status").val();
    jQuery(".ajaxloader").css("display", "block");
    jQuery.ajax({
                type:'POST',
                url: ajaxurl,
                data:{
                        action:'chef_product_status_update',
                        order_status:order_status,
                        commision_id:<?php echo $commision_id_data ; ?>,
                        order_id:<?php echo $order_id_data; ?>
                    },
                success: function(response){
                    jQuery("#order_status_feedback").html(response);
                    jQuery("#statusFeedback").html('<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Success!</strong> Order status updated <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    jQuery('.alert-success').fadeIn().delay(4000).fadeOut();                
                    jQuery(".ajaxloader").css("display", "none");
                }
        });
    });
});

 

jQuery(document).ready(function()
{
 jQuery("#backtoorderlist").click( function(e) {
 e.preventDefault();

    jQuery(".ajaxloader").css("display", "block");
    jQuery("#iOrderDetail").css("display", "none");
    jQuery("#iOrderList").css("display", "block");
    jQuery( "#iOrderList" ).load(window.location + " #iOrderList" , function() 
    {
          jQuery(".ajaxloader").css("display", "none");
    });
    

 });
});



jQuery(document).ready(function()
{
    jQuery("#order_status").change( function() 
    {
       jQuery('<div class="alert alert-warning">Order status have changed, you should update them!!</div>').insertBefore("#O-detail").delay(3000).fadeOut();     
    });
});

</script>



