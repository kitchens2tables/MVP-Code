
<?php 
/*
* 
*Template Name: Chef Order History
*
*/
?>
<?php 


get_header(); 



if(isset($_POST['submit']))
{
   
 $order_status=$_POST['order_status'];  
 $order_id_data = $_GET['order_id'];

 $order = new WC_Order($order_id_data); 

if (!empty($order)) {
  $order->update_status($order_status);
}
 

 

 
}

if (isset($_GET['order_id'])) {
  $order_id_data = $_GET['order_id'];
}
 $order = wc_get_order($order_id_data);
 
  $os= 'wc-'.$order->status;

 
 

 $date = new DateTime($order->date_created); 


 
 ?>
<h2>Order Details</h2>
<form method="post">
<div class="order-details" style="background: beige; margin-bottom: 30px;" id="order-details_data">
    <table>
        <tr>
            <td style="width:33%;">Order number is: <?php  echo  $order_id_data; echo " | "; echo $date->format('m/d/Y'); ?></td>
        <td style="width:33%;">Status: 
            <select name='order_status'>
                <?php foreach(wc_get_order_statuses() as $key=>$_status) {
                    
                    
                    
                
                
                ?> 
        
        
       <option value='<?php echo $key; ?>' <?php if(($os)===$key){ echo 'selected'; } ?>   >   <?php echo $_status;?>  </option>
       <?php }?>
        
        </select>
        
        
        
        
        </td><td style="width:33%;"><strong>Rating Received:</strong> <?php echo wc_get_rating_html( $average, $rating_count ); ?></td></tr>
        <tr><td><strong>Billing Details:</strong><?php echo $order->get_formatted_shipping_address(); ?></td><td><strong>Customer Feedback:</strong></td></tr>
    </table>
</div>

<div class="second-order-details" style="background: aliceblue;">
    <table>
        <tr style="background: beige;"><td></td><td><strong>Delivery Date</strong></td><td><strong>Chef</strong></td><td><strong>Dish Name</strong></td><td><strong>Price</strong></td><td><strong>Quantity</strong></td><td><strong>Amount</strong></td></tr>
        
        <?php 
       
$order = wc_get_order($order_id_data);
$items = $order->get_items(); 
$order_data = $order->get_data();
foreach ($items as  $key=>$item)
{
       ?> 
        
        
        <tr><td></td> <td></td><td> <?php echo $firstname; 
         
         $id= $order_data['customer_id'];
    
    $first_name = get_user_meta( $id, 'first_name', true );
    
     $last_name = get_user_meta( $id, 'last_name', true );
     
     echo $first_name.' '.$last_name;
        
        ?></td><td><?php echo $item['name']; ?></td><td><?php echo "&#36;". $item['subtotal'];
?></td><td><?php echo $item['quantity']; ?></td><td><?php echo "&#36;".$item['total']; ?></td></tr>
    
    <?php 

}      ?>
    
    
    </table>
</div>

<div class="form-group">
        <input type="submit" class="btn" id="updateorder" value="Update Order" name="submit">
         <a href='<?php echo site_url('account/#order_backlog'); ?>'><input type="button" class="btn" id="back" value="Back"></a>
    </div>

</form>

 <?php get_footer();

?>



