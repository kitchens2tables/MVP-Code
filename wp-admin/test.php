<?php


require_once("../../../../wp-load.php");

global $WCMp;

$id2= $_POST['id'];


 $id_data=intval( $id2 );




  $all_meta_for_user = get_user_meta($id_data);
  
  
 $id=$all_meta_for_user['_vendor_term_id'][0];



  
  
     $rating_info = wcmp_get_vendor_review_info($id);
 
 
 $meta_value=$rating_info['avg_rating'];




    


  global $wpdb;


    $tablename=$wpdb->prefix.'usermeta';
    
 

    $data=array(
        'user_id' => $user->ID, 
        'meta_key' => 'raing_data',
         'meta_value' => $meta_value
        );




     $wpdb->insert( $tablename, $data);


?>