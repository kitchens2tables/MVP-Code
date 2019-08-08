<?php 

/*
* 
*Template Name: My Test
*
*/ 



        global $woocommerce,$wpdb;
       
            
    echo 'hi';    
$qty =  wc_get_order_item_meta( 3948, '_reduced_stock', true ); 

echo $qty;


$qty2 =  wc_get_order_item_meta( 490, '_reduced_stock', true ); 

echo $qty2;
?>