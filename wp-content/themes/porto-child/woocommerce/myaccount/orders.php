<?php
/**
 * Orders
 *
 * Shows orders on the account page.
 *
 * @version 3.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $wpdb;
?>

<?php

do_action( 'woocommerce_before_account_orders', $has_orders ); ?>

<?php 


if($_REQUEST['rm']==1)
{ ?>
        <p class="um-notice success" >
            <i class="um-icon-ios-close-empty" onclick="jQuery(this).parent().fadeOut();"></i>
            <span> You have rated Cook successfully !</span>
        </p>
<?php	
}
?>


<?php if ( $has_orders ) : ?>
<h3>Current Order</h3>

<table class="woocommerce-orders-table woocommerce-MyAccount-orders shop_table shop_table_responsive my_account_orders account-orders-table test1">
    <thead>
        <tr>
            <th class="woocommerce-orders-table__header woocommerce-orders-table__header-order-number"><span class="nobr">Orders</span></th>
            <th class="woocommerce-orders-table__header woocommerce-orders-table__header-order-vendor_name"><span class="nobr">Cook</span></th>
            <th class="woocommerce-orders-table__header woocommerce-orders-table__header-order-date"><span class="nobr">Order Date</span></th>
            <th class="woocommerce-orders-table__header woocommerce-orders-table__header-order-dish_name"><span class="nobr">Dish</span></th>
            <th class="woocommerce-orders-table__header woocommerce-orders-table__header-order-status"><span class="nobr">Status</span></th>
            <th class="woocommerce-orders-table__header woocommerce-orders-table__header-order-total"><span class="nobr">Total</span></th>
            <th class="woocommerce-orders-table__header woocommerce-orders-table__header-order-actions"><span class="nobr">Actions</span></th>
        </tr>
    </thead>
    <tbody>
    <?php
    foreach($customer_orders->orders as $customer_order2 ) :
        $order = wc_get_order( $customer_order2 );
        if($order->status !='delivered' && $order->status !='cancelled')
        {
            $items = $order->get_items();
            $item_count = $order->get_item_count();
            ?>
            <tr class="woocommerce-orders-table__row woocommerce-orders-table__row--status-<?php echo esc_attr( $order->get_status() ); ?> order">
                <?php foreach ( wc_get_account_orders_columns() as $column_id => $column_name ) : 
                    if(($column_name != 'Rating') && ($column_name != 'Feedback') && ($column_id != 'order-delivery-date') ) {  ?>
                    <td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-<?php echo esc_attr( $column_id ); ?>" data-title="<?php echo esc_attr( $column_name ); ?>">
                    <?php if ( has_action( 'woocommerce_my_account_my_orders_column_' . $column_id ) ) : ?>
                        <?php do_action( 'woocommerce_my_account_my_orders_column_' . $column_id, $order ); ?>
                    <?php elseif ( 'order-number' === $column_id ) : ?>
                        <a href="<?php echo esc_url( $order->get_view_order_url() ); ?>">
                                <?php echo esc_html_x( '#', 'hash before order number', 'porto' ) . $order->get_order_number(); ?>
                        </a>
                    <?php elseif ( 'order-vendor_name' === $column_id ) : ?>
                        <p>
                             <?php
                            $vendor_id=array();
                            foreach ( $items as $item ) 
                            {
                                $product_id = $item->get_product_id();
                                $vendor_id[] = get_post_field( 'post_author', $product_id );
                            } 

                            $data=array_unique($vendor_id);

                            $index = 0;
                            foreach ($data as $res){
                            $index++;
                            
                           
                            
                            //$vendor = get_userdata( $res );
                             $first_name = get_user_meta( $res, 'first_name', true );
                            $last_name = get_user_meta( $res, 'last_name', true );
                           // $vendor->user_login
                           
                          
                            echo $first_name.' '.$last_name. ($index == count($data)?"":",");
                             
                            
                            }
                            ?>
                    <?php elseif ( 'order-dish_name' === $column_id ) : ?>
                        <p>
                            <?php
                                $index = 0;
                                foreach ( $items as $item ) 
                                {
                                    $index++;
                                    echo $item->get_name(). ($index == count($items)?"":",");;
                                } 
                            ?>
                        </p>

                  


                    <?php elseif ( 'order-payment_status' === $column_id ) : ?>
                        <p>
                           <?php
                            
                            
                              $payment_method=$order->data['payment_method']; 
                            
                            
                            
                              $order_status= wc_get_order_status_name( $order->get_status());
                              
                               
                             
                             
                             
                              if($payment_method==='cod' and($order_status!='Delivered' or $order_status!='Cancelled')  )
                              {
                                  
                                 
                              
                                  
                                   echo '<p style="color:red;">Pending Amount</p>';
                              }
                              
                              
                              else if($payment_method==='authorize')
                              {
                                  
                                 
                              
                                  
                                   echo '<p style="color:green;">Paid</p>';
                              }
                              
                              else 
                              {
                                  
                                 
                              
                                  
                                   echo '<p style="color:green;">Paid</p>';
                              }
                              
                              
                            
                            ?>
                        </p>



                    <?php elseif ( 'order-date' === $column_id ) : ?>
                        <time datetime="<?php echo esc_attr( $order->get_date_created()->date( 'c' ) ); ?>">
                            <?php echo esc_html( wc_format_datetime( $order->get_date_created() ) ); ?>
                        </time>


                    <?php elseif ( 'order-status' === $column_id ) : ?>
                        <?php echo esc_html( wc_get_order_status_name( $order->get_status() ) ); ?>


                    <?php elseif ( 'order-total' === $column_id ) : ?>
                            <?php
                            /* translators: 1: formatted order total 2: total order items */
                           // printf( _n( '%1$s for %2$s item', '%1$s for %2$s items', $item_count, 'porto' ), $order->get_formatted_order_total(), $item_count );
                              printf( _n( '%1$s', '%1$s', $item_count, 'porto' ), $order->get_formatted_order_total(), $item_count );
                            ?>

                    <?php elseif ( 'order-actions' === $column_id ) : ?>
                        <?php
                            if ( version_compare( WC_VERSION, '3.2', '>=' ) )
                            {
                                $actions = wc_get_account_orders_actions( $order );
                                
                               
                                if ( ! empty( $actions ) ) 
                                { 
                                    
                                    unset($actions['cancel']); 
                                    
                                    foreach ( $actions as $key => $action ) 
                                        {
                                            echo '<a href="' . esc_url( $action['url'] ) . '" class="woocommerce-button button ' . sanitize_html_class( $key ) . '">' . esc_html( $action['name'] ) . '</a>';
                                        
                                           //echo '<a href="#" onclick="ConfirmDelete('. $order->id.')"   class="woocommerce-button button ' . sanitize_html_class( $key ) . '">' . esc_html( 'Cancel' ) . '</a>';
                                        }
                                        




                                       
                                        
                                        
                                }
                            } 
                            else 
                            {
                                $actions = array(
                                                    'pay'    => array(
                                                            'url'  => $order->get_checkout_payment_url(),
                                                            'name' => __( 'Pay', 'porto' ),
                                                    ),
                                                    'view'   => array(
                                                            'url'  => $order->get_view_order_url(),
                                                            'name' => __( 'View', 'porto' ),
                                                    ),
                                    /*                
                                    'cancel' => array(
                                                            'url'  => $order->get_cancel_order_url( wc_get_page_permalink( 'myaccount' ) ),
                                                            'name' => __( 'Cancel', 'porto' ),
                                                    ),
                                     * 
                                     */
                                                );

                                                if ( ! $order->needs_payment() ) {
                                                        unset( $actions['pay'] );
                                                }

                                                if ( ! in_array( $order->get_status(), apply_filters( 'woocommerce_valid_order_statuses_for_cancel', array( 'pending', 'failed' ), $order ) ) ) {
                                                        unset( $actions['cancel'] );
                                                }

                                                if ( $actions = apply_filters( 'woocommerce_my_account_my_orders_actions', $actions, $order ) ) {
                                                        foreach ( $actions as $key => $action ) {
                                                                echo '<a href="' . esc_url( $action['url'] ) . '" class="woocommerce-button button ' . sanitize_html_class( $key ) . '">' . esc_html( $action['name'] ) . '</a>';
                                                        }
                                                }
                            }
                        ?> 
                    <?php endif; ?>
                    </td>
                    <?php } endforeach; ?>
            </tr>
  <?php } ?>
            
    <?php endforeach; ?>
    </tbody>
</table>    
            
<h3>Past Order</h3>           
<table class="woocommerce-orders-table woocommerce-MyAccount-orders shop_table shop_table_responsive my_account_orders account-orders-table test1">
    <thead>
        <tr>
            <?php foreach ( wc_get_account_orders_columns() as $column_id => $column_name ) :  
                 if(($column_id != 'order-delivery-date') && ($column_name != 'Rating')  && ($column_name != 'Feedback')  ) 
                 {
                ?>
              <th class="woocommerce-orders-table__header woocommerce-orders-table__header-<?php echo esc_attr( $column_id ); ?>"><span class="nobr"><?php echo esc_html( $column_name ); ?></span></th>
                 <?php } endforeach; ?>
        </tr>
    </thead>
    <tbody>
    <?php
  
    foreach ( $customer_orders->orders as $customer_order ) :
        $order = wc_get_order( $customer_order );
        if($order->status ==='delivered' || $order->status ==='cancelled')
        {
            $items = $order->get_items();
            $item_count = $order->get_item_count();
            $checkAlreadyRated = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."comments as comments INNER JOIN ".$wpdb->prefix."commentmeta as commentmeta ON commentmeta.comment_id=comments.comment_ID WHERE comments.user_id = ".get_current_user_id()." and commentmeta.meta_key = 'vendor_order_id' and commentmeta.meta_value = ".$order->get_order_number());
                        
            ?>
            <tr class="woocommerce-orders-table__row woocommerce-orders-table__row--status-<?php echo esc_attr( $order->get_status() ); ?> order">
            <?php foreach ( wc_get_account_orders_columns() as $column_id => $column_name ) :
                if(($column_id != 'order-delivery-date') && ($column_name != 'Rating')  && ($column_name != 'Feedback') ) 
                { ?>
                <td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-<?php echo esc_attr( $column_id ); ?>" data-title="<?php echo esc_attr( $column_name ); ?>">
                    <?php if ( has_action( 'woocommerce_my_account_my_orders_column_' . $column_id ) ) : ?>
                        <?php do_action( 'woocommerce_my_account_my_orders_column_' . $column_id, $order ); ?>

                    <?php elseif ( 'order-number' === $column_id ) : ?>
                        <a href="<?php echo esc_url( $order->get_view_order_url() ); ?>">
                                <?php echo esc_html_x( '#', 'hash before order number', 'porto' ) . $order->get_order_number(); ?>
                        </a>

                    <?php elseif ( 'order-vendor_name' === $column_id ) : ?>
                        <p>
                            <?php
                            $vendor_id=array();
                            foreach ( $items as $item ) 
                            {
                                $product_id = $item->get_product_id();
                                $vendor_id[] = get_post_field( 'post_author', $product_id );
                            } 

                            $data=array_unique($vendor_id);

                            $index = 0;
                            foreach ($data as $res){
                            $index++;
                            
                           
                            
                            //$vendor = get_userdata( $res );
                             $first_name = get_user_meta( $res, 'first_name', true );
                            $last_name = get_user_meta( $res, 'last_name', true );
                           // $vendor->user_login
                            echo $first_name.' '.$last_name. ($index == count($data)?"":",");
                            
                            
                            }
                            ?>
                        </p>

                    <?php elseif ( 'order-dish_name' === $column_id ) : ?>
                        <p>
                            <?php
                            $index = 0;
                            foreach ( $items as $item ) 
                            {
                                $index++;
                                echo $item->get_name(). ($index == count($items)?"":",");;
                            } 
                            ?>
                        </p>
                        
                          <?php elseif ( 'order-payment_status' === $column_id ) : ?>
                        <p>
                            <?php
                            
                            
                              $payment_method=$order->data['payment_method']; 
                            
                            
                            
                              $order_status= wc_get_order_status_name( $order->get_status());
                              
                             
                              if($payment_method==='cod' and $order_status==='Delivered')
                              {
                                  
                                 
                              
                                  
                                   echo '<p style="color:green;">Paid</p>';
                              }
                              
                              else if($payment_method==='cod' and $order_status==='Cancelled')
                              {
                                  
                                 
                              
                                  
                                   echo 'Refund Pending';
                              }
                              
                              
                                else if($payment_method==='authorize' and $order_status==='Cancelled')
                              {
                                  
                                 
                              
                                  
                                 echo 'Refund Pending';
                              }
                              
                              
                              
                                else if($payment_method==='authorize')
                              {
                                  
                                 
                              
                                  
                                  echo '<p style="color:green;">Paid</p>';
                              }
                              
                              
                              else
                              
                              {
                                  
                                 
                                   echo '<p style="color:red;" >Pending Amount</p>';
                              }
                             
                            ?>
                        </p>


                    <?php elseif ( 'order-product_rating' === $column_id ) : ?>
                        <p>
                            <?php
                            if($order->status ==='delivered'){
                            if(count($checkAlreadyRated)>0)
                            {
                               $ratingstar = get_comment_meta($checkAlreadyRated[0]->comment_ID,'vendor_rating',true);
                               
                                for($x=1;$x<=$ratingstar;$x++) {
                                    echo '<i class="fa fa-star"></i>';
                                }
                                if (strpos($ratingstar,'.')) {
                                    echo '<i class="fa fa-star-half-o"></i>';
                                    $x++;
                                }
                                while ($x<=5) {
                                    echo '<i class="fa fa-star-o"></i>';
                                    $x++;
                                }
    
                                
                            }
                        else { ?> 
    
                            <a href="<?php echo SITE_URL(); ?>/customer-order-feedback/<?php echo $order->get_order_number(); ?>" > Rate Now </a>
     
                        <?php } }
                            
                                else{
                                
                           echo '-';
                           
                                    
                                    
                                }
                            
                            /*	$index = 0;
                                foreach ( $items as $item ) {
                                $index++;
                                $product = wc_get_product($item->get_product_id());
                                $rating_count = $product->get_rating_count();
                                $product_avg_rating = $product->get_average_rating();
                                echo wc_get_rating_html(  $product_avg_rating , $rating_count );
                                } 
                                */
                            ?>
                        </p>

                    <?php elseif ( 'order-product_feedback' === $column_id ) : 
                        if($order->status ==='delivered'){
                        if(count($checkAlreadyRated)>0)
                            {
                                echo '<a href='.SITE_URL().'/customer-feedback/?order_id='.$order->get_order_number().' >Show Feedback Detail</a>';
                            }
                        else
                        {
                            ?>
                                <a href="<?php echo SITE_URL(); ?>/customer-order-feedback/<?php echo $order->get_order_number(); ?>" >
                                    Provide Feedback
                                </a>
                     <?php  } } 
                     else
                     {
                         
                         echo '-';
                     }
                     
                     
                     
                     ?>
                    <?php elseif ( 'order-date' === $column_id ) : ?>
                            <time datetime="<?php echo esc_attr( $order->get_date_created()->date( 'c' ) ); ?>"><?php echo esc_html( wc_format_datetime( $order->get_date_created() ) ); ?></time>


                    <?php elseif ( 'order-status' === $column_id ) : ?>
                            <?php echo esc_html( wc_get_order_status_name( $order->get_status() ) ); ?>

                    <?php elseif ( 'order-total' === $column_id ) : ?>
                            <?php
                            /* translators: 1: formatted order total 2: total order items */
                            //printf( _n( '%1$s for %2$s item', '%1$s for %2$s items', $item_count, 'porto' ), $order->get_formatted_order_total(), $item_count );
                             printf( _n( '%1$s', '%1$s', $item_count, 'porto' ), $order->get_formatted_order_total(), $item_count );
                            ?>

                    <?php elseif ( 'order-actions' === $column_id ) : ?>
                            <?php
                            if ( version_compare( WC_VERSION, '3.2', '>=' ) ) {
                                    $actions = wc_get_account_orders_actions( $order );

                                    if ( ! empty( $actions ) ) {
                                            foreach ( $actions as $key => $action ) {
                                                    echo '<a href="' . esc_url( $action['url'] ) . '" class="woocommerce-button button ' . sanitize_html_class( $key ) . '">' . esc_html( $action['name'] ) . '</a>';
                                            }
                                    }
                            } else {
                                    $actions = array(
                                            'pay'    => array(
                                                    'url'  => $order->get_checkout_payment_url(),
                                                    'name' => __( 'Pay', 'porto' ),
                                            ),
                                            'view'   => array(
                                                    'url'  => $order->get_view_order_url(),
                                                    'name' => __( 'View', 'porto' ),
                                            ),
                                            'cancel' => array(
                                                    'url'  => $order->get_cancel_order_url( wc_get_page_permalink( 'myaccount' ) ),
                                                    'name' => __( 'Cancel', 'porto' ),
                                            ),
                                    );

                                    if ( ! $order->needs_payment() ) {
                                            unset( $actions['pay'] );
                                    }

                                    if ( ! in_array( $order->get_status(), apply_filters( 'woocommerce_valid_order_statuses_for_cancel', array( 'pending', 'failed' ), $order ) ) ) {
                                            unset( $actions['cancel'] );
                                    }

                                    if ( $actions = apply_filters( 'woocommerce_my_account_my_orders_actions', $actions, $order ) ) {
                                            foreach ( $actions as $key => $action ) {
                                                    echo '<a href="' . esc_url( $action['url'] ) . '" class="woocommerce-button button ' . sanitize_html_class( $key ) . '">' . esc_html( $action['name'] ) . '</a>';
                                            }
                                    }
                            }
                            ?>
                    <?php endif; ?>
                </td>
            <?php } endforeach; ?>
            </tr>

        <?php } ?>
    <?php endforeach; ?>
    </tbody>
</table>

<?php do_action( 'woocommerce_before_account_orders_pagination' ); ?>

<?php if ( 1 < $customer_orders->max_num_pages ) : ?>
        <div class="woocommerce-pagination woocommerce-pagination--without-numbers woocommerce-Pagination">
                <?php if ( 1 !== $current_page ) : ?>
                        <a class="woocommerce-button woocommerce-button--previous woocommerce-Button woocommerce-Button--previous button" href="<?php echo esc_url( wc_get_endpoint_url( 'orders', $current_page - 1 ) ); ?>"><?php esc_html_e( 'Previous', 'porto' ); ?></a>
                <?php endif; ?>
                <?php if ( intval( $customer_orders->max_num_pages ) !== $current_page ) : ?>
                        <a class="woocommerce-button woocommerce-button--next woocommerce-Button woocommerce-Button--next button" href="<?php echo esc_url( wc_get_endpoint_url( 'orders', $current_page + 1 ) ); ?>"><?php esc_html_e( 'Next', 'porto' ); ?></a>
               <?php endif; ?>
        </div>
<?php endif; ?>

<?php else : ?>
	<div class="woocommerce-message--info woocommerce-Message woocommerce-Message--info">
		<p><?php esc_html_e( 'No order has been made yet.', 'porto' ); ?></p>
		<!-- <a class="woocommerce-Button button btn-lg m-b" href="<?php echo SITE_URL(); ?>/all_user/">
            <?php esc_html_e( 'Go Shop', 'porto' ); ?>
        </a> -->
	</div>
<?php endif; ?>

<?php do_action( 'woocommerce_after_account_orders', $has_orders ); ?>
								

	    
<div id="order_review_model" class="modal fade" role="dialog">
    <div class="modal-dialog" ><div class="modal-content" id="viewItemModelcontent"></div></div>
</div>





<script>


/*
function viewvendorOrder(vendor_id,user_id,order_id)

{
    
  
}*/


jQuery(document).ready(function () {
jQuery('#ratingForm').on('submit', function(event){
event.preventDefault();
var vendor_id =jQuery("#Vendor").val(); 
var user_id =jQuery("#User").val(); 
var order_id =jQuery("#Order").val(); 
var star_rate = jQuery("#count").val(); 

console.log(star_rate);
var dataString = 'star_rate='+ star_rate +'vendor_id='+ vendor_id+'user_id='+ user_id+'order_id='+ order_id;

jQuery.ajax({
type : 'POST',

data : dataString,
success:function(response){
jQuery("#ratingForm")[0].reset();
window.setTimeout(function(){window.location.reload()},1000)
}
});
});
});


                                       function ConfirmDelete(order_id)
{
 
     var dataString = 'order_id_cancel='+ order_id; 

jQuery.ajax({
type : 'POST',
url: "<?php echo get_stylesheet_directory_uri().'/woocommerce/myaccount/order_cancel.php'; ?>",
dataType: 'json',
data : dataString,
success:function(response){


if(response.result === true) 
{
   
    location.reload(); 
}
}
});
      
      
 
}

</script>
