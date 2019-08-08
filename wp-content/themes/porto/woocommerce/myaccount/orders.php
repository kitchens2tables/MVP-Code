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

?>

<?php










if(isset($_POST)){
    
$OrderId=$_POST[OrderId]; 
    
$star_val=$_POST['star_rate'];
$vendor_id=$_POST['itemId'];
$star_val=$_POST['star_rate'];
$user_id=$_POST['UserId'];

$comment_content=$_POST['comment'];

$user = get_userdata($user_id);






$comment_id = wp_insert_comment( array(
    'comment_post_ID'      => $vendor_id, // <=== The product ID where the review will show up
    'comment_author'       => $user->user_login,
    'comment_author_email' => $user->user_email, // <== Important
    'comment_author_url'   => '',
    'comment_content'      => $comment_content,
    'comment_type'         => 'wcmp_vendor_rating',
    'comment_parent'       => 0,
    'user_id'              => $user_id, // <== Important
    'comment_author_IP'    => '',
    'comment_agent'        => '',
    'comment_date'         => date('Y-m-d H:i:s'),
    'comment_approved'     => 1,
) );





// HERE inserting the rating (an integer from 1 to 5)
update_comment_meta( $comment_id, 'vendor_rating', $star_val );
update_comment_meta( $comment_id, 'vendor_rating_id', $star_val );
update_comment_meta( $comment_id, 'vendor_order_id', $OrderId );

$all_meta_for_user = get_user_meta($vendor_id);



 $id_v=$all_meta_for_user['_vendor_term_id'][0];
     $rating_info = wcmp_get_vendor_review_info($id_v);

 

$starRating = $rating_info["avg_rating"];




global $wpdb;

$rowcount = $wpdb->get_var("SELECT COUNT(*) FROM wp_usermeta WHERE (user_id = '". $vendor_id."'  AND meta_key='ultimate_rating')");

if($rowcount>0)
{
    update_user_meta( $vendor_id, 'ultimate_rating', $starRating );
    
}
else
{
    
add_user_meta( $vendor_id, 'ultimate_rating', $starRating);

}

}
?>

<?php do_action( 'woocommerce_before_account_orders', $has_orders ); ?>

<?php if ( $has_orders ) : ?>
	<h3>Current Order</h3>

	<table class="woocommerce-orders-table woocommerce-MyAccount-orders shop_table shop_table_responsive my_account_orders account-orders-table test1">
		<thead>
			<tr>
				<?php foreach ( wc_get_account_orders_columns() as $column_id => $column_name ) : ?>
					<th class="woocommerce-orders-table__header woocommerce-orders-table__header-<?php echo esc_attr( $column_id ); ?>"><span class="nobr"><?php echo esc_html( $column_name ); ?></span></th>
				<?php endforeach; ?>
			</tr>
		</thead>

<tbody>
			<?php
	    
	
		

	       
			foreach($customer_orders->orders as $customer_order2 ) :
			   
			 
				$order = wc_get_order( $customer_order2 );
				
				
				if($order->status !='delivered'){
	             $items = $order->get_items();

		
				$item_count = $order->get_item_count();
			?>
				<tr class="woocommerce-orders-table__row woocommerce-orders-table__row--status-<?php echo esc_attr( $order->get_status() ); ?> order">
					<?php foreach ( wc_get_account_orders_columns() as $column_id => $column_name ) : ?>
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
									foreach ( $items as $item ) {

    $product_id = $item->get_product_id();
   
   
   $vendor_id[] = get_post_field( 'post_author', $product_id );
   
   
   

   
   
} 

$data=array_unique($vendor_id);


	$index = 0;
foreach ($data as $res){
     $index++;
$vendor = get_userdata( $res ); 
  
   echo $vendor->user_login. ($index == count($data)?"":",");
}

?>
								</p>
								
								
								
							
									<?php elseif ( 'order-dish_name' === $column_id ) : ?>
								<p>
									<?php
								
 	$index = 0;
 
									foreach ( $items as $item ) {

      $index++;

 
   echo $item->get_name(). ($index == count($items)?"":",");;
   

   
   
} 




?>
								</p>
								
								
								
								
							<?php elseif ( 'order-date' === $column_id ) : ?>
								<time datetime="<?php echo esc_attr( $order->get_date_created()->date( 'c' ) ); ?>"><?php echo esc_html( wc_format_datetime( $order->get_date_created() ) ); ?></time>


							<?php elseif ( 'order-status' === $column_id ) : ?>
								<?php echo esc_html( wc_get_order_status_name( $order->get_status() ) ); ?>

							<?php elseif ( 'order-total' === $column_id ) : ?>
								<?php
								/* translators: 1: formatted order total 2: total order items */
								printf( _n( '%1$s for %2$s item', '%1$s for %2$s items', $item_count, 'porto' ), $order->get_formatted_order_total(), $item_count );
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
					<?php endforeach; ?>
				</tr>
				<?php
				}
				?>
			<?php endforeach; ?>
		
		
			<?php
			echo "<tr><td colspan='100%'><h3>Past Order</h3></td></tr>";
			
		

    
    
	
			foreach ( $customer_orders->orders as $customer_order ) :
				$order      = wc_get_order( $customer_order );
				
			
				
					if($order->status ==='delivered'){
	         
	             $items = $order->get_items();

		
				$item_count = $order->get_item_count();
				?>
				<tr class="woocommerce-orders-table__row woocommerce-orders-table__row--status-<?php echo esc_attr( $order->get_status() ); ?> order">
					<?php foreach ( wc_get_account_orders_columns() as $column_id => $column_name ) : ?>
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
									foreach ( $items as $item ) {

    $product_id = $item->get_product_id();
   
   
   $vendor_id[] = get_post_field( 'post_author', $product_id );
   
   
   

   
   
} 

$data=array_unique($vendor_id);


	$index = 0;
foreach ($data as $res){
     $index++;
$vendor = get_userdata( $res ); 
  
   echo $vendor->user_login. ($index == count($data)?"":",");
}

?>
								</p>
								
								
								
							
									<?php elseif ( 'order-dish_name' === $column_id ) : ?>
								<p>
									<?php
								
 	$index = 0;
 
									foreach ( $items as $item ) {

      $index++;

 
   echo $item->get_name(). ($index == count($items)?"":",");;
   

   
   
} 




?>
								</p>
								
								
								
									<?php elseif ( 'order-product_rating' === $column_id ) : ?>
								<p>
									<?php
								
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
				
				

									
																	 
 $current_user = wp_get_current_user();
 
if( $current_user->roles[0]=='customer'){
$first_name = get_user_meta(  $current_user->ID, 'first_name', true );
$last_name = get_user_meta(  $current_user->ID, 'last_name', true );	


  $user_info = get_userdata(  $current_user->ID );
  $email = $user_info->user_email;
$feedback_to = $order->get_order_number();

$items = $order->get_items();


 $vendor_id=array();
									foreach ( $items as $item ) {

    $product_id = $item->get_product_id();
   
   
   $vendor_id[] = get_post_field( 'post_author', $product_id );
   
   
   

   
   
} 

$data2=array_unique($vendor_id);
foreach ($data as $res){

									?>
									
									
									
									<a  onclick="viewvendorOrder(<?php echo $res; ?>, <?php echo $current_user->ID ;?>,<?php echo $feedback_to;?>)"   href="javascript:void(0)" data-toggle="modal" data-target="#viewItemModel">
									<?php echo "provide feedback" ?>
								</a>
								
								
								


								
								
								
								
								
								
								
								<?php } }?>

							<?php elseif ( 'order-date' === $column_id ) : ?>
								<time datetime="<?php echo esc_attr( $order->get_date_created()->date( 'c' ) ); ?>"><?php echo esc_html( wc_format_datetime( $order->get_date_created() ) ); ?></time>


							<?php elseif ( 'order-status' === $column_id ) : ?>
								<?php echo esc_html( wc_get_order_status_name( $order->get_status() ) ); ?>

							<?php elseif ( 'order-total' === $column_id ) : ?>
								<?php
								/* translators: 1: formatted order total 2: total order items */
								printf( _n( '%1$s for %2$s item', '%1$s for %2$s items', $item_count, 'porto' ), $order->get_formatted_order_total(), $item_count );
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
					<?php endforeach; ?>
				</tr>
				
				<?php
				}
				?>
				
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
		<a class="woocommerce-Button button btn-lg m-b" href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>">
			<?php esc_html_e( 'Go Shop', 'porto' ); ?>
		</a>
	</div>
<?php endif; ?>

<?php do_action( 'woocommerce_after_account_orders', $has_orders ); ?>





								
								<style>	
	.modal-backdrop.show {
    opacity: 0.0 !important;
}

.modal-backdrop
{
    position:absolute!important;
    z-index:999999999999!important;
    top:0  !imporatnt;
    left:0!imporatnt;
}
		</style>
		
	
		    
<div id="viewItemModel" class="modal fade" role="dialog">
    <div class="modal-dialog" ><div class="modal-content" id="viewItemModelcontent"></div></div>
</div>



<script>



function viewvendorOrder(vendor_id,user_id,order_id)

{
    
  jQuery(".ajaxloader").css("display", "block");
  jQuery("#viewItemModelcontent").load("<?php echo SITE_URL(); ?>/wp-content/themes/porto-child/order_view.php?id="+vendor_id+"&user_id="+user_id+"&order_id="+order_id, function() 
  {
        jQuery(".ajaxloader").css("display", "none");
  });
}


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
</script>
