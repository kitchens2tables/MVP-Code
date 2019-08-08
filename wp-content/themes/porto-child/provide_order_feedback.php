
<?php 
/*
* 
*Template Name: Provide order feedback
*
*/


$uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri_segments = explode('/', $uri_path);
$order_id = $uri_segments[3];


$getvVendorDetails = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."wcmp_vendor_orders WHERE commission_id = ".$order_id);



$loginUserId = get_current_user_id();





$order = wc_get_order($getvVendorDetails->order_id );
if($order->get_user_id() != $loginUserId)
{
    echo 'Not Matched';
    die();
}

// Get Vendor ID
$items = $order->get_items();
$vendor_id=array();
foreach ( $items as $item ) 
{
    $product_id = $item->get_product_id();
    $vendor_id[] = get_post_field( 'post_author', $product_id );
} 
$vendor_id = $getvVendorDetails->vendor_id;
$vendor = get_userdata( $vendor_id ); 
$vendorName = $vendor->user_login;

$checkAlreadyRated = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."comments as comments INNER JOIN ".$wpdb->prefix."commentmeta as commentmeta ON commentmeta.comment_id=comments.comment_ID WHERE comments.user_id = ".$loginUserId." and commentmeta.meta_key = 'vendor_order_id' and commentmeta.meta_value = ".$order_id);


if(isset($_POST['submit_rating']) && empty($checkAlreadyRated))
{
    $user = get_userdata($loginUserId);
    $star_val = $_POST['star_rate'];
 
    $comment_id = wp_insert_comment( array(
                                                'comment_post_ID'      => $vendor_id, // <=== The product ID where the review will show up
                                                'comment_author'       => $user->user_login,
                                                'comment_author_email' => $user->user_email, // <== Important
                                                'comment_author_url'   => '',
                                                'comment_content'      => $_POST['comment'],
                                                'comment_type'         => 'wcmp_vendor_rating',
                                                'comment_parent'       => 0,
                                                'user_id'              => $loginUserId, // <== Important
                                                'comment_author_IP'    => '',
                                                'comment_agent'        => '',
                                                'comment_date'         => date('Y-m-d H:i:s'),
                                                'comment_approved'     => 1,
                                            ) );

    update_comment_meta( $comment_id, 'vendor_rating', $star_val );
    update_comment_meta( $comment_id, 'vendor_rating_id', $vendor_id );
    update_comment_meta( $comment_id, 'vendor_order_id', $order_id );

    
    $iVendorCurrent_rating = wcmp_get_vendor_review_info(get_user_meta($vendor_id, '_vendor_term_id', true)); 
    $starRating = $iVendorCurrent_rating["avg_rating"];
    
    $starRating = round($starRating*2)/2;

    $rowcount = $wpdb->get_var("SELECT COUNT(*) FROM wp_usermeta WHERE (user_id = '". $vendor_id."'  AND meta_key='ultimate_rating')");
    if($rowcount>0)
    {
        update_user_meta( $vendor_id, 'ultimate_rating', $starRating );
    }
    else
    {
        add_user_meta( $vendor_id, 'ultimate_rating', $starRating);
    }

    wp_redirect(SITE_URL().'/my-account/orders/?rm=1');
    
} 








get_header();


if(count($checkAlreadyRated)>0)
{
    echo '<h3> You have already rated</h3>';
}
else
{

?>


<form method="post" action="" >
    <div class="form-group">
        <label>Rating : </label>
            <div id="stars" class="starrr"></div>
            <input type='hidden' id="count" value='' name='star_rate'> </input> 
    </div>
    
    <div class="form-group">
        <label for="usr">Title*</label>
        <input type="text" class="form-control" id="title" name="title" required value="Feedback to <?php echo $vendorName; ?>">
    </div>
    <div class="form-group">
        <label for="comment">Comment*</label>
        <textarea class="form-control" rows="5" id="comment" name="comment" required></textarea>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-info" name="submit_rating"> Submit </button> 
        <a href="<?php echo SITE_URL(); ?>/my-account/orders/" > <button type="button" class="btn btn-info" id="cancelReview">Cancel</button> </a>
    </div>
</form>    
    
<?php }

get_footer();