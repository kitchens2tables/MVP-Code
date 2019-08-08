<?php
 
/*
 Template Name: Customer Order Feedback Detail 
 */

if($_GET['order_id'])
{
	$order_id= $_GET['order_id'];

	$order = new WC_Order($order_id);
  $a=$order->get_items();



$user_id = get_post_meta($order_id, '_customer_user', true);




$comment_data = $wpdb->get_results("SELECT *  FROM `kitchens2tables`.`wp_comments` WHERE  user_id='$user_id'");


}


get_header();
?>
<div class="container">

	 <div class="form-group">
        <label>Order Id  : </label>
          
            <p> <?php if($_GET['order_id'])
{
	echo $_GET['order_id'];
} ?> </p>
    </div>
    <div class="form-group">
        <label>Customer Details: </label>
<?php $user_info = get_userdata($user_id );
      echo '<p>'.$user_info->first_name .  " " . $user_info->last_name . "</p>";
?>
            
    </div>
    
    <div class="form-group">
        <label for="usr">Feedback Details*</label>
        <?php 
if(!empty($comment_data)){


	echo '<p>'.$comment_data[0]->comment_content.'</p>';   



}

        ?>
    </div>
    
    
</div>

<?php  echo get_footer();?>