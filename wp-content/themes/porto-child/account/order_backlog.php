

<!-- start -->
<div id="iOrderList">
    <div class="watermark-heading">
          <h3>Order List</h3>
          <div>Order List</div>
    </div>        
    <table class="table table-striped">
    <thead>
      <tr>
        <th>Sub-Order#</th>
        <th>Order #</th>
        <th>Order Date</th>
        <th>Customer Name</th>
        <th>Total Cost</th>
        <th>Order Status</th>
        <th>Star Rating</th>
        <th></th>
      </tr>
    </thead> 

    <tbody>
    <?php 
    $user = wp_get_current_user();

    if($user->roles[0]=='dc_vendor')
    {
        $vendor_id=   $user->id;   
        $table_name ='wp_wcmp_vendor_orders';

        // echo"SELECT * FROM $table_name where vendor_id='$vendor_id'  ORDER BY `wp_wcmp_vendor_orders`.`ID` DESC"; 
        $iVendorOrder = $wpdb->get_results("SELECT {$wpdb->prefix}wcmp_vendor_orders.*, {$wpdb->prefix}posts.post_status FROM wp_wcmp_vendor_orders LEFT JOIN wp_posts ON wp_posts.ID = wp_wcmp_vendor_orders.order_id where wp_wcmp_vendor_orders.vendor_id={$vendor_id} and wp_posts.post_status NOT IN ('trash','wc-failed')GROUP BY wp_wcmp_vendor_orders.commission_id ORDER BY wp_wcmp_vendor_orders.ID DESC"); 
        if($iVendorOrder)
        {
            foreach($iVendorOrder  as $row)
            {
                $SubOrderStatus = get_post_meta($row->commission_id, '_sub_order_status', true);
                
                if($SubOrderStatus=='')
                {
                    $SubOrderStatus = 'wc-processing';
                }
                
                
                $sOrderSt = order_status_string($SubOrderStatus);  
                
                $iSubOrderItem = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}wcmp_vendor_orders where order_id='{$row->order_id}' and  commission_id = '{$row->commission_id}' ORDER BY created DESC"); 
                $subTotalPrice = 0;
                foreach($iSubOrderItem as $iSubOrderItemList)
                {
                    $itemPrice = wc_get_order_item_meta( $iSubOrderItemList->order_item_id, '_line_subtotal', true );
                    $subTotalPrice += $itemPrice;
                }
                ?>
                <tr> 
                    <td>
                        <a href="javascript:void(0)" onclick="vieworderdetails('<?php echo $row->order_id; ?>','<?php echo $row->commission_id; ?>');" > <?php  echo $row->commission_id;  ?></a>
                    </td>
                    <td><?php echo $row->order_id;?></td>
                    <td><?php $date = new DateTime($row->created); echo $date->format('m/d/Y');?></td>
                    <td><?php  
                          $order = wc_get_order( $row->order_id);
                          $user = $order->get_user();
                          $user_id=$user->id;
                          $first_name = get_user_meta($user_id, 'first_name', true ); $last_name = get_user_meta($user_id, 'last_name', true ); echo $first_name.' '.$last_name;
                          ?>
                    </td>
                    <td><?php echo get_woocommerce_currency_symbol().$subTotalPrice; ?></td>
                    <td style="text-transform:capitalize"><?php echo $sOrderSt; ?></td>
                    <td>  
                        <?php
                        $comment_id = $totalRating = $starRating = '';
                        $sql = "SELECT * FROM wp_commentmeta WHERE meta_key = 'vendor_order_id' and meta_value='$row->commission_id'";
                        $results = $wpdb->get_results($sql);
                        if(!empty($results)){
                            $comment_id=$results[0]->comment_id;
                        }
                        $sql1 = "SELECT * FROM wp_commentmeta WHERE comment_id = '$comment_id' and meta_key='vendor_rating'";
                        $results1 = $wpdb->get_results($sql1);
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
                    <td><a href="javascript:void(0)" onclick="vieworderdetails('<?php echo $row->order_id; ?>','<?php echo $row->commission_id; ?>');" > <i class="fa fa-eye"></i></a></td> 
                </tr>
     <?php  }    
        } 
    } ?>

    </tbody>

  </table>
 
   
    
</div>
<div id="iOrderDetail"></div>





<script>
    
function vieworderdetails(order_id,commision_id)
{

    jQuery(".ajaxloader").css("display", "block");
    jQuery("#iOrderList").css("display", "none");
    jQuery("#iOrderDetail").css("display", "block");
    jQuery("#iOrderDetail").load("<?php echo SITE_URL(); ?>/wp-content/themes/porto-child/account/order_backlog.details.php?id="+order_id+"&commision_id="+commision_id, function() 
    {
          jQuery(".ajaxloader").css("display", "none");
    });
 



}


        
</script>

<?php if($_REQUEST['order'] && $_REQUEST['suborder']) { ?>
<script> vieworderdetails('<?php echo $_REQUEST['order']; ?>','<?php echo $_REQUEST['suborder']; ?>'); </script>
<?php } ?>

<!-- end -->