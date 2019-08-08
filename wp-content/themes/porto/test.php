<?php
// create by ajay

require_once('../../../wp-load.php');
 global $wpdb;
 global  $WCMp;
$id2= $_POST['id'];
 $id_data=intval( $id2 );
  $all_meta_for_user = get_user_meta($id_data);
 $id=$all_meta_for_user['_vendor_term_id'][0];
     $rating_info = wcmp_get_vendor_review_info($id);
 $meta_value=$rating_info['avg_rating'];
    $tablename=$wpdb->prefix.'usermeta';
    $data=array(
        'user_id' => $id2, 
        'meta_key' => 'RATING',
         'meta_value' => $meta_value
        );
     $results=$wpdb->get_results("select * from wp_usermeta where user_id='$id2' AND `meta_key`= 'RATING' ");
if (count($results)== 0){
              $wpdb->insert( $tablename, $data);
}
     else
     {
        $wpdb->update('wp_usermeta', array('meta_value'=>$meta_value), array('user_id'=>$id2,'meta_key'=>'RATING'));
        
     } 
?>