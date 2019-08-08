<?php

require('../../../../../wp-load.php');

$order_id= $_POST['order_id_cancel'];



$order = new WC_Order($order_id); 
 
if (!empty($order)) {
  $result=  $order->update_status( 'cancelled' );
  
  
  
  
  if($result == false){
       
      
      echo json_encode([result => false]);
      
  }
    else
    {    
         echo json_encode([result => true]);
    }
  
  
} 

?>