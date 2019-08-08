<?php

// Load CSS
function porto_child_css() {
	// porto child theme styles
	wp_deregister_style( 'styles-child' );
	wp_register_style( 'styles-child', get_stylesheet_directory_uri() . '/style.css' );
	
	 

	wp_enqueue_style( 'styles-child' );
 
	if ( is_rtl() ) {
		wp_deregister_style( 'styles-child-rtl' );
		wp_register_style( 'styles-child-rtl', get_stylesheet_directory_uri() . '/style_rtl.css' );
     
	 
		wp_enqueue_style( 'styles-child-rtl' ); 
	} 
}
add_action( 'wp_enqueue_scripts', 'porto_child_css', 1001 );

function my_enqueued_assets() {
  wp_enqueue_style( 'styles-child-select2', get_stylesheet_directory_uri() . '/css/select2_child.css' );
    wp_enqueue_script( 'custom-script', get_stylesheet_directory_uri() . '/js/custom.js');
    wp_enqueue_script( 'rating-script', get_stylesheet_directory_uri() . '/js/rating.js');
   wp_enqueue_script( 'datepicker-script', get_stylesheet_directory_uri() . '/js/datepicker.js');
    wp_enqueue_script( 'select2_child', get_stylesheet_directory_uri() . '/js/select2_child.js');
} 
add_action( 'wp_enqueue_scripts', 'my_enqueued_assets' ); 


add_filter( 'woocommerce_get_item_data','your_function_name',10,2 );
function your_function_name( $item_data, $cart_item ){
    
    $vendor_id = $cart_item[ 'data' ]->post->post_author;
   // $display_name = get_display_name($vendor_id);
    $user_info = get_userdata($vendor_id);
    $firstname = $user_info->first_name." ".$user_info->last_name;
    $item_data[] = array('key'=>'Cook', 'value'=>$firstname);
    return $item_data;
}


add_filter(  'gettext',  'wps_translate_words_array'  );
add_filter(  'ngettext',  'wps_translate_words_array'  );
function wps_translate_words_array( $translated ) {
     $words = array(
                // 'word to translate' = > 'translation'
               'Related Products' => 'Check out these related Dishes',  
               'Products' => 'Dishes',
               'Product' => 'Dish',
     );
     $translated = str_ireplace(  array_keys($words),  $words,  $translated );
     return $translated;
}



// Add to cart custom
if ( is_user_logged_in() ) {
add_action( 'wp_ajax_add_to_cart_custom', 'my_ajax_add_to_cart_custom_handler' );
} else {
add_action( 'wp_ajax_nopriv_add_to_cart_custom', 'my_ajax_add_to_cart_custom_handler' );   
}
function my_ajax_add_to_cart_custom_handler() 
{
    $product_id = $_POST['pid'];
    $product_qty = $_POST['qty'];
    
    $iNewProductAuthor = get_post_field('post_author',$product_id);
    
    $userdata = get_currentuserinfo();
    $user_id = $userdata->ID;

    $_product = wc_get_product( $product_id );





    //update_user_meta($user_id,'order_spacial_request','asdfdfdf sdg srg sg gsgs gsdg sdg');
    global $woocommerce;
    $current_cart_items = $woocommerce->cart->get_cart();

  
    if(count($current_cart_items)>0)
    {
        $cartQty = '';






        foreach($current_cart_items as $item => $values) { 


      /*    $price = $values['data']->get_price();


           $values['data']->set_price( ( $price ) ); */

            if($values['product_id']==$product_id)
            {
               $cartQty =  $values['quantity'];
            }  
        }
    }
     $totalstock = $_product->get_stock_quantity();
     if($cartQty)
     {
        $totalstock = $totalstock - $cartQty;
     }
     
    if($totalstock >= $product_qty)
    {
        echo 1;
        die();
    }    
    echo 2;
        
            die();
        /*
        echo 'New '.$iNewProductAuthor;
        echo 'Old '.$iLastAuthor;
        */
        
       
    
    die();
}



// Store Special checkout and move to checkout
if ( is_user_logged_in() ) {
add_action( 'wp_ajax_order_checkout_w_s', 'my_ajax_order_checkout_w_s_handler' );
} else {
add_action( 'wp_ajax_nopriv_order_checkout_w_s', 'my_ajax_order_checkout_w_s_handler' );   
}
function my_ajax_order_checkout_w_s_handler() 
{
   
        global $woocommerce;
        $items = $woocommerce->cart->get_cart();
        if(empty($items))
        {
            echo 2;
        }
        
    setcookie( 'order_spacial_request', $_POST['special_request'], time() + (86400 * 30), "/" );    
        
    if(get_current_user_id())
    {
        $userdata = get_currentuserinfo();
        $user_id = $userdata->ID;
        update_user_meta($user_id,'order_spacial_request',$_POST['special_request']);
    }
    die();
    
}



// load script on checkout page
add_action('wp_enqueue_scripts', 'checkout_scripts');
function checkout_scripts() 
{
    
    global $woocommerce;
    $items = $woocommerce->cart->get_cart();
    setcookie('order_spacial_request', '', time() - 3600);
    if(empty($items))
    {
        if(get_user_meta(get_current_user_id(),'order_spacial_request',true))
        {
            delete_user_meta(get_current_user_id(),'order_spacial_request');
        }
    }
}



// Update Profile 
add_action( 'wp_ajax_updateprofile', 'my_ajax_updateprofile_handler' );
function my_ajax_updateprofile_handler() 
{
   $userdata = get_currentuserinfo();
   $user_id = $userdata->ID;
   wp_update_user(array (  'ID' => $user_id,  'user_email' => $_POST['email_address'] ));
   
   update_user_meta( $user_id, 'first_name', $_POST['first_name']); 
   update_user_meta( $user_id, 'last_name', $_POST['last_name']); 
   update_user_meta( $user_id, 'Address_Line_1', $_POST['address_line_1']); 
   update_user_meta( $user_id, 'Address_Line_2', $_POST['address_line_2']); 
   update_user_meta( $user_id, 'City', $_POST['u_city']); 
   update_user_meta( $user_id, 'State', $_POST['u_state']); 
   update_user_meta( $user_id, 'Zip', $_POST['u_zip']); 
   update_user_meta( $user_id, 'License_Info', $_POST['license_info']); 
   update_user_meta( $user_id, 'description', $_POST['about_yourself']); 
   
    die();
// Make your response and echo it.

    // Don't forget to stop execution afterward.
    //wp_die();
}



// Become a Chef Customer 
add_action( 'wp_ajax_become_chef_customer', 'my_ajax_become_chef_customer_handler' );
function my_ajax_become_chef_customer_handler() 
{
   $userdata = get_currentuserinfo();
   $user_id = $userdata->ID;
   wp_update_user(array (  'ID' => $user_id,  'user_email' => $_POST['email_address'] ));
   
   update_user_meta( $user_id, 'first_name', $_POST['first_name']); 
   update_user_meta( $user_id, 'last_name', $_POST['last_name']); 
   update_user_meta( $user_id, 'Address_Line_1', $_POST['address_line_1']); 
   update_user_meta( $user_id, 'Address_Line_2', $_POST['address_line_2']); 
   update_user_meta( $user_id, 'City', $_POST['u_city']); 
   update_user_meta( $user_id, 'State', $_POST['u_state']); 
   update_user_meta( $user_id, 'Zip', $_POST['u_zip']); 
   update_user_meta( $user_id, 'License_Info', $_POST['license_info']); 
   update_user_meta( $user_id, 'description', $_POST['about_yourself']); 
   update_user_meta( $user_id, 'account_status', 'awaiting_admin_review'); 
   
   
   //echo add_role('dc_vendor','Vendor',array()).'----';
    $u = new WP_User($user_id);
    // Remove role
    $u->remove_role('customer');
    // Add role
    $u->add_role( 'dc_vendor' );
    
    if( !session_id())
      session_start();
    $_SESSION['user_id_for_confirmation'] = $user_id;
    
    wp_logout();
    die();
// Make your response and echo it.

    // Don't forget to stop execution afterward.
    //wp_die();
}



// Update Profile 
add_action( 'wp_ajax_chef_product_status_update', 'my_ajax_chef_product_status_update_handler' );
function my_ajax_chef_product_status_update_handler()  
{
    global $wpdb, $woocommerce;
    $vendor = wp_get_current_user();

    $main_order_id = $_POST['order_id'];
    $order_status=$_POST['order_status'];  
    $commision_id=$_POST['commision_id']; 
    $user_id = get_post_meta($main_order_id, '_customer_user', true);
    
    // Update Vendor Status
    $user_info = get_userdata($user_id);
    $user_email_data=$user_info->user_email; 
    if(!empty($commision_id))
    {
        update_post_meta($commision_id, '_sub_order_status', $order_status);  
        
        if($order_status=='wc-delivered')
            {
                update_post_meta($commision_id, '_delivery_date', date('M d Y h:i A', current_time( 'timestamp' )));
            }
        
        sub_order_email_send($main_order_id, $commision_id, $order_status, true, true); 
    
        $ordernote = array(
                            'comment_post_ID' => $main_order_id,
                            'comment_author' => $vendor->data->display_name,
                            'comment_author_email' => $vendor->data->user_email,
                            'comment_content' => 'Changed sub order status to '.$order_status,
                            'comment_approved' => '1',
                            'comment_agent' => 'WooCommerce',
                            'comment_type' => 'order_note'
                        );
        
        wp_insert_comment($ordernote);
    }
    
    // Update Main Status
    main_order_status_update($main_order_id);
    
    if($order_status=="wc-delivered" || $order_status=="wc-failed" || $order_status=="wc-cancelled" ){ $disabled = 'disabled'; }
    
    if($order_status=="wc-ready")
        { 
            $wcready = 'selected';
            $disableprocess = 'disabled="disabled"';
            $disablecancel = 'disabled="disabled"';
        }
    elseif($order_status=="wc-processing")
        { 
            $wcprocess = 'selected';
            $disabledelivery = 'disabled="disabled"';
        }
    elseif($order_status=="wc-delivered")
        { 
            $wcdelivered = 'selected';
            $disableprocess = 'disabled="disabled"';
            $disableready = 'disabled="disabled"';
        }
    elseif($order_status=="wc-cancelled")
        { 
            $wccancel = 'selected';
            $disableprocess = 'disabled="disabled"';
            $disableready = 'disabled="disabled"';
            $disabledelivery = 'disabled="disabled"';
        }
        
    echo '<select id="order_status" style="color:black;" '.$disabled.'>
            <option value="wc-processing" '.$wcprocess.' '.$disableprocess.'> Processing </option>
            <option value="wc-ready" '.$wcready.' '.$disableready.'> Ready for pickup </option>
            <option value="wc-delivered" '.$wcdelivered. ' '.$disabledelivery.'> Delivered </option>
            <option value="wc-cancelled" '.$wccancel. ' '.$disablecancel.'> Cancelled </option>
        </select>';
    
    
    die();
}


// Change password
add_action( 'wp_ajax_changepasswords', 'my_ajax_changepassword_handler' );
function my_ajax_changepassword_handler() 
{
    $userdata = wp_get_current_user();
    $user_id = $userdata->ID;
   
    if(wp_check_password($_POST['current_password'], $userdata->user_pass)) 
    {
        wp_set_password($_POST['new_password'],$user_id); 
        echo 1;
    }
    else
    {
      echo 2;  
    }   
    die();
}


// Privacy (Hide/Show my profile)
add_action( 'wp_ajax_hidemember', 'my_ajax_hidemember_handler' );
function my_ajax_hidemember_handler() 
{
    $userdata = wp_get_current_user();
    $user_id = $userdata->ID;
    update_user_meta( $user_id, 'hide_in_members', $_POST['hideme']); 
    die();
}   


// Add Chef Item 
add_action( 'wp_ajax_add_chef_item', 'my_ajax_add_chef_item_handler' );
function my_ajax_add_chef_item_handler() 
{
    $userdata = wp_get_current_user();
    $user_id = $userdata->ID;
    $new_cuisine= $_POST['cuisine'];
    $ultimate_option = get_option('um_fields'); 

     




   if(!empty($ultimate_option['cusine']['options'])){
      
      if(!in_array($new_cuisine, $ultimate_option['cusine']['options'])){


       
      
           array_push($ultimate_option['cusine']['options'],$new_cuisine);   





            update_option( 'um_fields', $ultimate_option);




      }

   } 
  

               



       
    $new_product_post_id = wp_insert_post(
                                            array(
                                                    'post_content'  =>  $_POST['description'],
                                                    'post_title'    =>  $_POST['dish_name'],
                                                    'post_status'   =>  'publish',
                                                    'post_type'     =>  'product'
                                                )
                                        );
    
    //make product type be simple:    
    wp_set_object_terms($new_product_post_id, 'simple', 'product_type');
    
    
    
    //echo $new_product_post_id;
    update_post_meta( $new_product_post_id, '_visibility', 'visible' ); 
    update_post_meta($new_product_post_id, '_regular_price', $_POST['price_unit'], true );
    update_post_meta($new_product_post_id, '_price', $_POST['price_unit'], true );
    update_post_meta($new_product_post_id, '_product_cuisine_type', $_POST['cuisine'], true );
    update_post_meta($new_product_post_id, '_stock', $_POST['meal'], true ); 
    update_post_meta($new_product_post_id, '_product_delivery_type', $_POST['delivery'], true );  
    update_post_meta($new_product_post_id, '_product_available_date', $_POST['available_date'], true );   
    update_post_meta($new_product_post_id, '_manage_stock', 'yes', true ); 
    update_post_meta($new_product_post_id, '_dryincredient', $_POST['dryincredient'], true ); 
    update_post_meta($new_product_post_id, '_wetincredient', $_POST['wetincredient'], true );  
    update_post_meta($new_product_post_id, '_miscincredient', $_POST['miscincredient'], true );  

    $term = get_term_by('name', $_POST['category'], 'product_cat');
    wp_set_object_terms($new_product_post_id, $term->term_id, 'product_cat'); 
    
    
     // Update Cuisine
    if(!in_array($_POST['cuisine'],get_user_meta($user_id, 'cusine')))
    {
        add_user_meta($user_id, 'cusine', $_POST['cuisine'] );
    }
    
    // Update Cuisine
    if(!in_array($_POST['delivery'],get_user_meta($user_id, 'DELIVERY_STATUS')))
    {
        add_user_meta($user_id, 'DELIVERY_STATUS', $_POST['delivery'] );
    }
    
    // Update Price
   /* if($_POST['price_unit']==10 && !in_array($_POST['price_unit'],get_user_meta($user_id, 'price')))
    {
        add_user_meta($user_id, 'price', $_POST['price_unit'] );
    }
    elseif($_POST['price_unit']<10 && !in_array('<10',get_user_meta($user_id, 'price')))
    {
        add_user_meta($user_id, 'price', '<10');
    }
    elseif($_POST['price_unit']>10 && !in_array('>10',get_user_meta($user_id, 'price')))
    {
        add_user_meta($user_id, 'price', '>10');
    }*/
    

if($_POST['price_unit'] <= 10 && !in_array('<$10', get_user_meta($user_id, 'price')))
{
add_user_meta($user_id, 'price', '<$10' );
}
elseif( ( $_POST['price_unit'] >= 11 && $_POST['price_unit'] <= 15) && !in_array('$11-$15',get_user_meta($user_id, 'price')))
{
add_user_meta($user_id, 'price', '$11-$15');
}
elseif($_POST['price_unit']>15 && !in_array('>$15',get_user_meta($user_id, 'price')))
{
add_user_meta($user_id, 'price', '>$15');
}

 
    
    echo $new_product_post_id;
    die;
}


// Add Chef Item 
add_action( 'wp_ajax_edit_chef_item', 'my_ajax_edit_chef_item_handler' );
function my_ajax_edit_chef_item_handler() 
{
    global $wpdb;
    $product_post_id = $_POST['itemId'];
    wp_update_post(
                                            array(
                                                    'ID'            =>  $product_post_id,
                                                    'post_content'  =>  $_POST['description'],
                                                    'post_title'    =>  $_POST['dish_name'],
                                                )
                                        );
        
    //echo $new_product_post_id;
    update_post_meta($product_post_id, '_price', $_POST['price_unit'] );
    update_post_meta($product_post_id, '_product_cuisine_type', $_POST['cuisine'] );
    update_post_meta($product_post_id, '_stock', $_POST['meal'] ); 
    update_post_meta($product_post_id, '_product_delivery_type', $_POST['delivery'] );  
    update_post_meta($product_post_id, '_product_available_date', $_POST['available_date'] );  

    update_post_meta($product_post_id, '_manage_stock', 'yes' );  
    
    if($_POST['meal'] > 0)
    {
         update_post_meta($product_post_id, '_stock_status', 'instock' );
    }
    elseif($_POST['meal'] <= 0)
    {
         update_post_meta($product_post_id, '_stock_status', 'outofstock' );
    }
    
    
     update_post_meta($product_post_id, '_dryincredient', $_POST['dryincredient'] ); 
    update_post_meta($product_post_id, '_wetincredient', $_POST['wetincredient'] );  
    update_post_meta($product_post_id, '_miscincredient', $_POST['miscincredient'] );  

    $term = get_term_by('name', $_POST['category'], 'product_cat');
    wp_set_post_terms($product_post_id,$term,'product_cat');
    
    
    // Update Cuisine
    if(!in_array($_POST['cuisine'],get_user_meta($user_id, 'cusine')))
    {
        add_user_meta($user_id, 'cusine', $_POST['cuisine'] );
    }
    
    // Update Cuisine
    if(!in_array($_POST['delivery'],get_user_meta($user_id, 'DELIVERY_STATUS')))
    {
        add_user_meta($user_id, 'DELIVERY_STATUS', $_POST['delivery'] );
    }
    
    // Update Price
   /* if($_POST['price_unit']==10 && !in_array($_POST['price_unit'],get_user_meta($user_id, 'price')))
    {
        add_user_meta($user_id, 'price', $_POST['price_unit'] );
    }
    elseif($_POST['price_unit']<10 && !in_array('<10',get_user_meta($user_id, 'price')))
    {
        add_user_meta($user_id, 'price', '<10');
    }
    elseif($_POST['price_unit']>10 && !in_array('>10',get_user_meta($user_id, 'price')))
    {
        add_user_meta($user_id, 'price', '>10');
    }*/
    
    if($_POST['price_unit'] <= 10 && !in_array('<$10', get_user_meta($user_id, 'price')))
    {
    add_user_meta($user_id, 'price', '<$10' );
    }
    elseif( ( $_POST['price_unit'] >= 11 && $_POST['price_unit'] <= 15) && !in_array('$11-$15',get_user_meta($user_id, 'price')))
    {
    add_user_meta($user_id, 'price', '$11-$15');
    }
    elseif($_POST['price_unit']>15 && !in_array('>$15',get_user_meta($user_id, 'price')))
    {
    add_user_meta($user_id, 'price', '>$15');
    }
    die; 
}
 

// Add Chef Item 
add_action( 'wp_ajax_remove_chef_item', 'my_ajax_remove_chef_item_handler' );
function my_ajax_remove_chef_item_handler() 
{
    global $wpdb;
    $product_post_id = $_POST['itemId'];
    
    wp_delete_post($product_post_id);
    //delete_post_meta($product_post_id);
    
    die;
}


add_filter( 'wc_order_statuses', 'so_39252649_remove_processing_status' );
function so_39252649_remove_processing_status( $statuses )
{
    if( isset( $statuses['wc-on-hold'] ) ){
        unset( $statuses['wc-on-hold'] );
    }
     if( isset( $statuses['wc-cancel-request'] ) ){
        unset( $statuses['wc-cancel-request'] );
    }
     if( isset( $statuses['wc-refunded'] ) ){
        unset( $statuses['wc-refunded'] );
    }
      if( isset( $statuses['wc-completed'] ) ){
        unset( $statuses['wc-completed'] );
    }
    return $statuses;
}


add_action( 'init', 'register_my_new_order_statuses' );
function register_my_new_order_statuses() {
    register_post_status( 'wc-ready', array(
        'label'                     => _x( 'Ready for pickup', 'Order status', 'woocommerce' ),
        'public'                    => true,
        'exclude_from_search'       => false,
        'show_in_admin_all_list'    => true,
        'show_in_admin_status_list' => true,
        'label_count'               => _n_noop( 'Ready for pickup <span class="count">(%s)</span>', 'Ready for pickup<span class="count">(%s)</span>', 'woocommerce' )
    ) );
}


// Register in wc_order_statuses.
add_filter( 'wc_order_statuses', 'my_new_wc_order_statuses' );
function my_new_wc_order_statuses( $order_statuses ) {
    $order_statuses['wc-ready'] = _x( 'Ready for pickup', 'Order status', 'woocommerce' );

    return $order_statuses;
}


add_filter( 'init', 'wpex_wc_register_post_statuses' );
function wpex_wc_register_post_statuses() {
	register_post_status( 'wc-delivered', array(
		'label'						=> _x( 'Delivered', 'WooCommerce Order status', 'text_domain' ),
		'public'					=> true,
		'exclude_from_search'		=> false,
		'show_in_admin_all_list'	=> true,
		'show_in_admin_status_list'	=> true,
		'label_count'				=> _n_noop( 'Delivered (%s)', 'Delivered (%s)', 'text_domain' )
	) );
}



// Add New Order Statuses to WooCommerce
add_filter( 'wc_order_statuses', 'wpex_wc_add_order_statuses' );
function wpex_wc_add_order_statuses( $order_statuses ) {
	$order_statuses['wc-delivered'] = _x( 'Delivered', 'WooCommerce Order status', 'text_domain' );
	return $order_statuses;
}



add_action( 'wp_enqueue_scripts', 'wpse218610_theme_styles' );
function wpse218610_theme_styles() {
    wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/css/all.min.css' );
}



add_filter( 'woocommerce_login_redirect', 'iconic_login_redirect', 10, 2 ); 
function iconic_login_redirect($redirect, $user ) 
    {
        if(in_array( 'dc_vendor', (array) $user->roles )) 
        {
            wp_redirect(SITE_URL().'/account');
        }
        else
        {
            wp_redirect(SITE_URL());
        }
    }


add_shortcode('howdoitext', 'how_do_i_text');
function how_do_i_text()
{
    if ( is_user_logged_in() ) 
        {
            $current_user = wp_get_current_user();
            $current_user_id = $current_user->ID;
            $first_name = get_user_meta($current_user_id, 'first_name', true );
        ?>
            <p>Hi, <strong><?php  echo $first_name; ?></strong> What can we help you with?</p>
    <?php } else { ?>
        <p>Hello. What can we help you with? </p>
    <?php }
}


//Called by Ajax from App - list the contents of the folder so they can be downloaded and stored locally
add_action('wp_ajax_folder_contents_data', 'folder_contents_data');
add_action('wp_ajax_nopriv_folder_contents_data', 'folder_contents_data');
function folder_contents_data() 
{

  $name = $_POST['name'];
  $email = $_POST['email'];
  $comment = $_POST['comment'];
 

$new_post = array(
     
        'post_content' => $comment,
        'post_type'    => 'general_feedback',
        'post_status'  => 'publish',
            
    );


$id = wp_insert_post($new_post);



update_post_meta($id,'Name',$name);
update_post_meta($id,'Email',$email); 



}


//add_filter( 'woocommerce_checkout_update_customer_data', '__return_false' );
add_action( 'woocommerce_checkout_create_order', 'change_total_on_checking', 20, 1 );

// Update sub order status
add_action( 'woocommerce_order_status_changed',  'update_suborder_status',  10,  3 );
function update_suborder_status()
{
    $OrderVendor = get_post_meta(get_the_ID(), '_commission_ids', true);
    foreach($OrderVendor as $oList)
    {
        $SubOrderStatus = get_post_meta($oList, '_sub_order_status', true);
        update_post_meta($oList, '_sub_order_status', $_REQUEST['order_status']);
        if($_REQUEST['order_status']=='wc-delivered')
        {
            update_post_meta($oList, '_delivery_date', date('M d Y h:i A', current_time( 'timestamp' )));
        }
    }
}



function order_status_string($SubOrderStatus)
{
    if(empty($SubOrderStatus) || $SubOrderStatus=='wc-processing')
    { $sOrderSt = 'Processing'; }
    elseif($SubOrderStatus=='wc-ready')
    { $sOrderSt = 'Ready for pickup'; }
    elseif($SubOrderStatus=='wc-delivered')
    { $sOrderSt = 'Delivered'; }
    elseif($SubOrderStatus=='wc-cancelled')
    { $sOrderSt = 'Cancelled'; }
    elseif($SubOrderStatus=='wc-failed')
    { $sOrderSt = 'Failed'; }
    elseif($SubOrderStatus=='wc-pending')
    { $sOrderSt = 'Pending payment'; }
    return $sOrderSt;
}


function email_send($order_id_data,$order_status_data) 
{
    $admin_email = get_option('admin_email');
    $order = wc_get_order( $order_id_data );
    $user_id   = $order->get_user_id();

    $user = get_userdata($user_id);
    
    $email = $user->user_email;
    

    $file_path_twitter=site_url().'/wp-content/uploads/2019/05/twitter.png';
    $file_path_instagram_=site_url().'/wp-content/uploads/2019/03/instagram.png';
    $file_path_facebook=site_url().'/wp-content/uploads/2019/03/facebook.png';
    $file_path_logo=site_url().'/wp-content/uploads/2019/02/logo.png';

    $title   = '[Kitchen2Tables]: Order Status Update #'.$order_id_data;
    $headers = array('From: '.$order_id_data.' <'.$order.'>');
    $message = '

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="background: #f9f9f9;">
  <tbody>
    <tr>
      <td align="center" valign="middle" style="background:#e0e3eb;" height="230">
        <img style="display:block; line-height:0px; font-size:0px; border:0px;" src='.$file_path_logo.' alt="logo"> 
      </td>
    </tr>
    <tr>
      <td align="center">
        <table width="600" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-left:20px; margin-right:20px;background: #ffffff;padding:30px 60px;border-left: 11px solid #f05120;min-height: 220px;margin-top: -50px">
          <tbody>
            <tr>
              <td style="font-family: Playfair Display;font-weight: 600;font-size: 30px;line-height: 50px;color: #333333;"><a href='.site_url().'>Kitchen2Tables</a>,</td>
            </tr>

            <tr>
              <td style="font-family: lato;font-size: 16px;line-height: 24px;font-weight: 300;color: #333333;">
                '.$order_id_data.' Order Status has been Updated to <span style="font-weight: 600;font-size: 16px;text-transform: capitalize;">'. $order_status_data.'</span>

              </td>
            </tr>



            

          </tbody>
        </table>
      </td>
    </tr>

    <tr>
      <td align="center">
        

        <table align="center" width="150px" border="0" cellspacing="0" cellpadding="0">
          <tbody>
            <tr>
              <td align="center" width="30%" style="vertical-align: top;">
                <a href="#" target="_blank">
                  <img  src='.$file_path_twitter.' alt="twitter">
                </a>
              </td>

              <td align="center" class="margin" width="30%" style="vertical-align: top;">
                <a href="#" target="_blank">
                  <img src='.$file_path_facebook.' alt="facebook">
                </a>
              </td>

              <td align="center" width="30%" style="vertical-align: top;">
                <a href="#" target="_blank">
                  <img src='.$file_path_instagram.' alt="instagram"> 
                </a>
              </td>
            </tr> 
          </tbody>
        </table>
      </td>
    </tr>



    <tr>
      <td align="center">
        <table align="center" width="600" border="0" cellspacing="0" cellpadding="0" style="opacity: 0.7">
          <tbody>
            <tr>
              <td>
                <p style="font-family: lato, sans-serif;text-align: center; width: 100%; margin: 0 auto;color: #333;font-size: 14px;font-weight: 300; line-height: 24px;margin-top: 40px;">Kitchens2Tables, 1234 Street, City, State, Country.
                  <br>
                  <br> <span style="color: #333333">This email is intended for <span style="color: #e84b08">'.$admin_email .'</span>. You are receiving this email because you have registered on  </span><a href='. site_url().' style="color: #e84b08"><strong>Kitchen2Tables</strong></a>.
                </p>
                <ul style="text-align: center;margin-top: 30px;padding-left: 0;">
                  <li style="display: inline-block; padding: 0 15px;"><a style="color: #f05120; font-weight: bold;" href='.site_url('/privacy-policy/').'>Privacy Policy</a></li>
<li style="display: inline-block; padding: 0 15px;"><a style="color: #f05120; font-weight: bold;" href='.site_url('/terms-and-conditions/').'>Terms and Conditions</a></li>
<li style="display: inline-block; padding: 0 15px;"><a style="color: #f05120; font-weight: bold;" href='.site_url('/give-feedback/'). '>Feedback</a></li>
                </ul>
                <p style="font-family: lato, sans-serif;text-align: center; margin-top: 35px; color: #333333; font-weight: 300; margin-bottom: 15px;">©2019 - KitchensToTables  |   All right reserved</p>
              </td>
            </tr>
          </tbody>
        </table>
      </td>
    </tr>



  </tbody>
</table>';

    //Send the email
    add_filter('wp_mail_content_type', create_function('', 'return "text/html"; '));
    $email = wp_mail($email, $title, $message, $headers);
    remove_filter('wp_mail_content_type', 'set_html_content_type');

    return $email;
}

function sub_order_email_send($mainOrderID, $subOrderID, $subOrderStatus, $tochef=false, $toadmin=false)
{
    global $wpdb;
    $subOrderStatus = order_status_string($subOrderStatus);
    
    
    $getVeDetail  = $wpdb->get_row("SELECT * FROM {$wpdb->prefix}wcmp_vendor_orders where order_id='{$mainOrderID}' and  commission_id = '{$subOrderID}'"); 
    $iVendorDetail = get_user_by( 'ID', $getVeDetail->vendor_id );
        
    $admin_email = get_option( 'admin_email', false );
    $sub_order_id = $subOrderID;
    $user_id = get_post_meta($mainOrderID, '_customer_user', true);
    $user_info = get_userdata($user_id);
    $user_email_data = $user_info->user_email; 

    $file_path_twitter1=site_url().'/wp-content/uploads/2019/05/twitter.png';
    $file_path_instagram1=site_url().'/wp-content/uploads/2019/03/instagram.png';
    $file_path_facebook1=site_url().'/wp-content/uploads/2019/03/facebook.png';
    $file_path_logo1=site_url().'/wp-content/uploads/2019/02/logo.png';
    $file_path_logo2=site_url().'/wp-content/uploads/2019/03/gray-logo.png';
    
    $subject = '[Kitchen2Tables]:- Order(#'.$mainOrderID.') Status For Sub Order Id #'. $sub_order_id;
    $bodyhead = '<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="background: #f9f9f9;">
                  <tbody>
                    <tr>
                      <td align="center" valign="middle" style="background:#e0e3eb;" height="230">
                        <img style="display:block; line-height:0px; font-size:0px; border:0px;" src="'.$file_path_logo1.'" alt="logo">
                      </td>
                    </tr>';

    $c_body = '<tr>
                      <td align="center">
                        <table width="600" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-left:20px; margin-right:20px;background: #ffffff;padding:30px 60px;border-left: 11px solid #f05120;min-height: 220px;margin-top: -50px">
                            <tbody>
                                <tr><td>Order Id : '.$mainOrderID.' </td></tr> 
                                <tr><td> #'.$sub_order_id.' Sub order status has been updated to <span style="font-weight: 600;font-size: 16px;text-transform: capitalize;">'.ucfirst($subOrderStatus).'</span></td></tr>
                                <tr><td> <a href="'.SITE_URL().'/my-account/view-order/'.$mainOrderID.'" style="color: white;background: #374977;padding: 10px 12px;text-decoration: none;" > View Order </a></td></tr>
                            </tbody>
                        </table>
                      </td>
                    </tr>';
    $v_body = '<tr>
                <td align="center">
                  <table width="600" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-left:20px; margin-right:20px;background: #ffffff;padding:30px 60px;border-left: 11px solid #f05120;min-height: 220px;margin-top: -50px">
                        <tbody>
                                <tr><td>Order Id : '.$mainOrderID.' </td></tr> 
                                <tr><td> #'.$sub_order_id.' Sub order status has been updated to <span style="font-weight: 600;font-size: 16px;text-transform: capitalize;">'.ucfirst($subOrderStatus).'</span></td></tr>
                                <tr><td> <a href="'.SITE_URL().'/account/?order='.$mainOrderID.'&suborder='.$subOrderStatus.'#order_backlog" style="color: white;background: #374977;padding: 10px 12px;text-decoration: none;" > View Order </a></td></tr>
                            </tbody>
                        </table>
                </td>
              </tr>';

    $bodyfooter =     '<tr>
                      <td align="center">
                        <table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tbody>
                            <tr>
                              <td align="center" valign="middle" height="100px;">
                                <img style="display:block; line-height:0px; font-size:0px; border:0px;margin-bottom: 30px;margin-top: 15px;" src="'.$file_path_logo2.'" alt="footer logo">
                              </td>
                            </tr>
                          </tbody>
                        </table>

                        <table align="center" width="150px" border="0" cellspacing="0" cellpadding="0">
                          <tbody>
                            <tr>
                              <td align="center" width="30%" style="vertical-align: top;">
                                <a href="#" target="_blank">
                                  <img src="'.$file_path_twitter1.'" alt="twitter">
                                </a>
                              </td>

                              <td align="center" class="margin" width="30%" style="vertical-align: top;">
                                <a href="#" target="_blank">
                                  <img src="'.$file_path_facebook1.'" alt="facebook">
                                </a>
                              </td>

                              <td align="center" width="30%" style="vertical-align: top;">
                                <a href="#" target="_blank">
                                  <img src="'.$file_path_instagram1.'" alt="instagram">
                                </a>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </td>
                    </tr>
                    <tr>
                      <td align="center">
                        <table align="center" width="600" border="0" cellspacing="0" cellpadding="0" style="opacity: 0.7">
                          <tbody>
                            <tr>
                              <td>
                                <p style="font-family: lato, sans-serif;text-align: center; width: 100%; margin: 0 auto;color: #333;font-size: 14px;font-weight: 300; line-height: 24px;margin-top: 40px;">Kitchens2Tables, 1234 Street, City, State, Country.
                                  <br>
                                  <br> <span style="color: #333333">This email is intended for <span style="color: #e84b08">'.$admin_email.'</span>. You are receiving this email because you have registered on  </span><a href='.site_url().' style="color: #e84b08"><strong>Kitchens2Tables</strong></a>.
                                </p>
                                <ul style="text-align: center;margin-top: 30px;padding-left: 0;">
                                    <li style="display: inline-block; padding: 0 15px;"><a style="color: #f05120; font-weight: bold;" href='.site_url().'/privacy-policy/">Privacy Policy</a></li>
                                    <li style="display: inline-block; padding: 0 15px;"><a style="color: #f05120; font-weight: bold;" href='.site_url().'/terms-and-conditions/">Terms and Conditions</a></li>
                                    <li style="display: inline-block; padding: 0 15px;"><a style="color: #f05120; font-weight: bold;" href='.site_url().'/give-feedback/">Feedback</a></li>
                                </ul>
                                <p style="font-family: lato, sans-serif;text-align: center; margin-top: 35px; color: #333333; font-weight: 300; margin-bottom: 15px;">©2019 - KitchensToTables  |   All right reserved</p>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </td>
                    </tr>
                  </tbody>
                </table>';
    $headers = array('Content-Type: text/html; charset=UTF-8');
    
    wp_mail( $user_email_data, $subject, $bodyhead.$c_body.$bodyfooter, $headers );
    
    if($tochef)
    {
         wp_mail( $iVendorDetail->user_email, $subject, $bodyhead.$v_body.$bodyfooter, $headers );
    }
    if($toadmin)
    {
        if($subOrderStatus == 'wc-cancelled')
        {
           $aBody =  $bodyhead.$c_body.$bodyfooter;
        }
        else
        {
           $aBody =  $bodyhead.$v_body.$bodyfooter;
        }
        wp_mail($admin_email, $subject, $aBody, $headers );
    }
    
    
}



function main_order_status_update($orderID)
{
    global $woocommerce;
    $mainCount = $processingCount = $readyCount = $deliveredCount = $cancelCount = 0;
    $statusArray = array();
    
    $subOrderIds = get_post_meta($orderID,'_commission_ids', true);
    $TotalSubPrder = count($subOrderIds);
    
    foreach($subOrderIds as $SubIds)
    {
        $subOrderIds = get_post_meta($SubIds,'_sub_order_status', true);
        switch ($subOrderIds) {
            /*
            case 'wc-processing':
                array_push($statusArray, 'wc-processing');
                $processingCount++;
                $mainCount++;
                break;
            
            case 'wc-ready':
                array_push($statusArray, 'wc-ready');
                $readyCount++;
                $mainCount++;
                break;
            */
            case 'wc-delivered':
                array_push($statusArray, 'wc-delivered');
                $deliveredCount++;
                $mainCount++;
                break;
            
            case 'wc-cancelled':
                array_push($statusArray, 'wc-cancelled');
                $cancelCount++;
                $mainCount++;
                break;
        }
    }    
    $OrderStatus = '';
    if($mainCount==$TotalSubPrder)
    {
        if(in_array('wc-delivered', $statusArray))
        {
            $OrderStatus = 'delivered';
            email_send($orderID,'wc-delivered');
        }
        elseif($cancelCount==$TotalSubPrder)
        {
            $OrderStatus = 'cancelled';
        }
        /*
        elseif($readyCount==$TotalSubPrder)
        {
            $OrderStatus = 'ready';
        }
        */
        $_order = new WC_Order( $orderID ); // here
        $MorderStus = $_order->update_status($OrderStatus);
    }

    
}




 function time_elapsed_string($datetime, $full = false)
    {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }
    
    
    
    
     
add_action('init', function(){
   add_rewrite_rule( 
      '^cook-profile/([^/]+)([/]?)(.*)', 
      //!IMPORTANT! THIS MUST BE IN SINGLE QUOTES!:
      'index.php?pagename=cook-profile&user=$matches[1]', 
      'top'
   );   
});

add_filter('query_vars', function( $vars ){
    $vars[] = 'cook-profile'; 
    $vars[] = 'user'; 
    return $vars;
});




// Chef login redirection
function wcmp_vendor_login_via_wc($redirect, $user){
    if ($user && in_array('dc_vendor', $user->roles)) {
        // vendor redirect page url, Ex- Vendor order
        $redirect = wcmp_get_vendor_dashboard_endpoint_url( get_wcmp_vendor_settings( 'wcmp_vendor_orders_endpoint', 'vendor', 'general', 'vendor-orders' ) );
    }
    return SITE_URL().'/account';
}
add_filter('woocommerce_login_redirect', 'wcmp_vendor_login_via_wc', 99, 2);

function wcmp_vendor_login_via_wp($redirect, $requested_redirect_to, $user){
    if ($user && in_array('dc_vendor', $user->roles)) {
        // vendor redirect page url, Ex- Vendor order
        $redirect = wcmp_get_vendor_dashboard_endpoint_url( get_wcmp_vendor_settings( 'wcmp_vendor_orders_endpoint', 'vendor', 'general', 'vendor-orders' ) );
    }
    return SITE_URL().'/account';
}
add_filter('login_redirect', 'wcmp_vendor_login_via_wp', 99, 3);





/**
 * Removed Order Notes Text on checkout page - WooCommerce
 * 
 */
add_filter('woocommerce_enable_order_notes_field', '__return_false');


/**
 * After checkout - WooCommerce
 * 
 */
add_action('woocommerce_thankyou', 'thankyoupage', 10, 1);
function thankyoupage( $order_id ) {
    if ( ! $order_id )
        return;
 
    echo '<script>localStorage.removeItem("special_request")</script>';
    //print_r($order_id);
    //die;
    
}



// Remove cart item if product availabe date expire
function remove_auto_cart_item()
{
    global $woocommerce;
 
    $cart = $woocommerce->cart->get_cart();
    foreach ($cart as $cartData) {
        
        $product_id = $cartData['product_id'];
        
        $stock_status = get_post_meta($product_id,'_stock_status',true);   // Get product stock status
        
        $_product_available_date = get_post_meta($product_id,'_product_available_date',true); // Product available in date
        $productdate = date_create($_product_available_date); // Product available in date format
        $CutoffUnixtime = strtotime('-12 hour',strtotime(date_format($productdate,"Y/m/d H:i:s")));  // Product Cut of time
        $currentDateTime = current_time('timestamp'); // Current Time
        
        if($stock_status=='outofstock' || $CutoffUnixtime <= $currentDateTime)
        {
            WC()->cart->remove_cart_item($cartData['key']); // Remove item by cart item key
        }
    }
}
add_action('wp_footer', 'remove_auto_cart_item');



add_filter( 'woocommerce_checkout_fields' , 'default_values_checkout_fields' );
  function default_values_checkout_fields( $fields ) {
      
      $current_user_id  = get_current_user_id();
      
    // You can use this for postcode, address, company, first name, last name and such. 
    $fields['billing']['billing_first_name']['default'] = get_user_meta($current_user_id,'first_name',true);
    $fields['billing']['billing_last_name']['default'] = get_user_meta($current_user_id,'last_name',true);
         return $fields;
  }
  
  
add_filter( 'wp_footer' , 'special_order_comments' );
function special_order_comments() 
{
  ?> 
    <script>
    jQuery( "#special_request" ).keyup(function() 
    {
        var specialRequest =  jQuery('textarea#special_request').val();
        localStorage.setItem("special_request", specialRequest);
    });
    
    jQuery( "#order_comments" ).keyup(function() 
    {
        var specialRequest =  jQuery('textarea#order_comments').val();
        localStorage.setItem("special_request", specialRequest);
    });
    
    </script>
  <?php
  if(get_the_ID()=='3234')
  {
    echo '<script>jQuery("#special_request").val(localStorage.getItem("special_request"))</script>';
  }
  elseif(get_the_ID()=='7')
  {
    echo '<script>jQuery("#order_comments").val(localStorage.getItem("special_request"))</script>';
  }
      
}
  
  
  
/**
 * Rename "cart" in breadcrumb
 */
add_filter( 'woocommerce_breadcrumb_defaults', 'wcc_change_breadcrumb_home_text' );
function wcc_change_breadcrumb_home_text( $defaults ) {
    // Change the breadcrumb home text from 'Home' to 'Apartment'
    $defaults['shop'] = 'Apartment';
    return $defaults;
}



/**
 * Show the submit button
 *
 * @param $args
 */
function custom_um_add_submit_button_to_register( $args ) {
	// DO NOT add when reviewing user's details
	if ( isset( UM()->user()->preview ) && UM()->user()->preview == true && is_admin() ) return;

	$primary_btn_word = $args['primary_btn_word'];
	/**
	 * UM hook
	 *
	 * @type filter
	 * @title um_register_form_button_one
	 * @description Change Register Form Primary button
	 * @input_vars
	 * [{"var":"$primary_btn_word","type":"string","desc":"Button text"},
	 * {"var":"$args","type":"array","desc":"Registration Form arguments"}]
	 * @change_log
	 * ["Since: 2.0"]
	 * @usage
	 * <?php add_filter( 'um_register_form_button_one', 'function_name', 10, 2 ); ?>
	 * @example
	 * <?php
	 * add_filter( 'um_register_form_button_one', 'my_register_form_button_one', 10, 2 );
	 * function my_register_form_button_one( $primary_btn_word, $args ) {
	 *     // your code here
	 *     return $primary_btn_word;
	 * }
	 * ?>
	 */
	$primary_btn_word = apply_filters('um_register_form_button_one', $primary_btn_word, $args );

	$secondary_btn_word = $args['secondary_btn_word'];
	/**
	 * UM hook
	 *
	 * @type filter
	 * @title um_register_form_button_two
	 * @description Change Registration Form Secondary button
	 * @input_vars
	 * [{"var":"$secondary_btn_word","type":"string","desc":"Button text"},
	 * {"var":"$args","type":"array","desc":"Registration Form arguments"}]
	 * @change_log
	 * ["Since: 2.0"]
	 * @usage
	 * <?php add_filter( 'um_register_form_button_two', 'function_name', 10, 2 ); ?>
	 * @example
	 * <?php
	 * add_filter( 'um_register_form_button_two', 'my_register_form_button_two', 10, 2 );
	 * function my_register_form_button_two( $secondary_btn_word, $args ) {
	 *     // your code here
	 *     return $secondary_btn_word;
	 * }
	 * ?>
	 */
	$secondary_btn_word = apply_filters( 'um_register_form_button_two', $secondary_btn_word, $args );

	$secondary_btn_url = ( isset( $args['secondary_btn_url'] ) && $args['secondary_btn_url'] ) ? $args['secondary_btn_url'] : um_get_core_page('login');
	/**
	 * UM hook
	 *
	 * @type filter
	 * @title um_register_form_button_two_url
	 * @description Change Registration Form Secondary button URL
	 * @input_vars
	 * [{"var":"$secondary_btn_url","type":"string","desc":"Button URL"},
	 * {"var":"$args","type":"array","desc":"Registration Form arguments"}]
	 * @change_log
	 * ["Since: 2.0"]
	 * @usage
	 * <?php add_filter( 'um_register_form_button_two_url', 'function_name', 10, 2 ); ?>
	 * @example
	 * <?php
	 * add_filter( 'um_register_form_button_two_url', 'my_register_form_button_two_url', 10, 2 );
	 * function my_register_form_button_two_url( $secondary_btn_url, $args ) {
	 *     // your code here
	 *     return $secondary_btn_url;
	 * }
	 * ?>
	 */
        
        
        // Register form id  = $args['form_id'] = 2709
        // Becoma chef form id  = $args['form_id'] = 2695
        
	$secondary_btn_url = apply_filters('um_register_form_button_two_url', $secondary_btn_url, $args ); ?>


        <span id="error-feedback-<?php echo $args['form_id']; ?>" ></span>
            

	
<script>
	jQuery(document).ready(function(){
            jQuery(".submit-become-chef-form").click(function(e){
                e.preventDefault();
            });
        });
	
	</script>
	<script>
            
        jQuery(document).ready(function(){
            jQuery(".submit-customer-register-form").click(function(e){
                e.preventDefault();
              
                var formid = '2709';
                var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                var pattern=  /^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,15}$/;

                var first_name = jQuery("#first_name-"+formid).val();
                var last_name = jQuery("#last_name-"+formid).val();
                var user_email = jQuery("#user_email-"+formid).val();
                var user_password = jQuery("#user_password-"+formid).val();
                var confirm_user_password = jQuery("#confirm_user_password-"+formid).val();

                if(first_name === '')
                {     
                  jQuery("#error-feedback-"+formid).html('<div class="alert alert-warning alert-dismissible"> First name can not be left blank </div>');
                }
                else if(last_name === '')
                {    
                  jQuery("#error-feedback-"+formid).html('<div class="alert alert-warning alert-dismissible"> Last name can not be left blank </div>');
                }
                else if(user_email === '')
                {    
                  jQuery("#error-feedback-"+formid).html('<div class="alert alert-warning alert-dismissible"> Email Address can not be left blank </div>');
                }
                else if(regex.test(user_email) === false)
                {    
                  jQuery("#error-feedback-"+formid).html('<div class="alert alert-warning alert-dismissible"> Please use valid Email Address </div>');
                }





                else if(user_password === '')
                {    
                  jQuery("#error-feedback-"+formid).html('<div class="alert alert-warning alert-dismissible"> Password can not be left blank </div>');
                }


 else if(pattern.test(user_password) === false)
                {    
                  jQuery("#error-feedback-"+formid).html('<div class="alert alert-warning alert-dismissible">Password should contain at least 1 digit, 1 letter in upper case, 1 special character and should be between 8 - 15 characters. </div>');
                }

                else if(confirm_user_password === '')
                {    
                  jQuery("#error-feedback-"+formid).html('<div class="alert alert-warning alert-dismissible"> Confirm Password can not be left blank </div>');
                }
                else if(confirm_user_password !== user_password)
                {    
                  jQuery("#error-feedback-"+formid).html('<div class="alert alert-warning alert-dismissible"> Password not match </div>');
                }
                else if(jQuery("input[name='use_gdpr_agreement']:checked").val()!= 1)
                {
                  jQuery("#error-feedback-"+formid).html('<div class="alert alert-warning alert-dismissible"> Please accept privacy policy. </div>');
                }
                else
                {
                  jQuery("#error-feedback-"+formid).html('');
                  jQuery("#um-submit-btn-"+formid).click();
                }
                
                setTimeout(function() {
                    jQuery('.alert-warning').fadeOut(); 
                   }, 4000 );
            });
        }); 
            
        var formiddata = '2695';
        jQuery("#Zip-"+formiddata).on('keyup keydown', function(e){

                if (jQuery(this).val() > 10000 
                    && e.keyCode != 46
                    && e.keyCode != 8
                   ) {
                   e.preventDefault();     

                }
            });


	jQuery(document).ready(function(){
            jQuery(".submit-become-chef-form").click(function(e){
                e.preventDefault();
                var formid = '2695';
                var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                var pattern=  /^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,15}$/;
                var reg = /^[0-9]+$/;
 

                var first_name = jQuery("#first_name-"+formid).val();
                var last_name = jQuery("#last_name-"+formid).val();
                var Address_Line_1 = jQuery("#Address_Line_1").val();
                var City = jQuery("#City-"+formid).val();
                var States = jQuery("#States-"+formid).val();
                var Zip = jQuery("#Zip-"+formid).val();
                var License_Info = jQuery("#License_Info-"+formid).val();
                var user_email = jQuery("#user_email-"+formid).val();
                var user_password = jQuery("#user_password-"+formid).val();
                var confirm_user_password = jQuery("#confirm_user_password-"+formid).val();
                var description = jQuery("#description").val();

                if(first_name === '')
                {    
                  jQuery("#error-feedback-"+formid).html('<div class="alert alert-warning alert-dismissible"> First name can not be left blank </div>');
                }
                else if(last_name === '')
                {    
                  jQuery("#error-feedback-"+formid).html('<div class="alert alert-warning alert-dismissible"> Last name can not be left blank </div>');
                }
                else if(Address_Line_1 === '')
                {    
                  jQuery("#error-feedback-"+formid).html('<div class="alert alert-warning alert-dismissible"> Address Line 1 can not be left blank </div>');
                }
                else if(City === '')
                {    
                  jQuery("#error-feedback-"+formid).html('<div class="alert alert-warning alert-dismissible"> City can not be left blank </div>');
                }
                else if(States === '')
                {    
                  jQuery("#error-feedback-"+formid).html('<div class="alert alert-warning alert-dismissible"> States can not be left blank </div>');
                }
                else if(Zip === '')
                {    
                  jQuery("#error-feedback-"+formid).html('<div class="alert alert-warning alert-dismissible"> Zip can not be left blank </div>');
                }
                else if ((Zip.length)< 5 || (Zip.length)>5 ){

                 jQuery("#error-feedback-"+formid).html('<div class="alert alert-warning alert-dismissible"> zipcode should only be 5 digits</div>');
                }
                else if(user_email === '')
                {    
                  jQuery("#error-feedback-"+formid).html('<div class="alert alert-warning alert-dismissible"> Email Address can not be left blank </div>');
                }
                else if(regex.test(user_email) === false)
                {    
                  jQuery("#error-feedback-"+formid).html('<div class="alert alert-warning alert-dismissible"> Please use valid Email Address </div>');
                }
                else if(user_password === '')
                {    
                  jQuery("#error-feedback-"+formid).html('<div class="alert alert-warning alert-dismissible"> Password can not be left blank </div>');
                }
                else if(pattern.test(user_password) === false)
                {    
                  jQuery("#error-feedback-"+formid).html('<div class="alert alert-warning alert-dismissible">Password should contain at least 1 digit, 1 letter in upper case, 1 special character and should be between 8 - 15 characters.</div>');
                }
                else if(confirm_user_password === '')
                {    
                  jQuery("#error-feedback-"+formid).html('<div class="alert alert-warning alert-dismissible"> Confirm Password can not be left blank </div>');
                }
                else if(confirm_user_password !== user_password)
                {    
                  jQuery("#error-feedback-"+formid).html('<div class="alert alert-warning alert-dismissible"> Password not match </div>');
                }
                else if(jQuery("input[name='use_gdpr_agreement']:checked").val()!= 1)
                {
                  jQuery("#error-feedback-"+formid).html('<div class="alert alert-warning alert-dismissible"> Please accept privacy policy. </div>');
                }
                else
                {
                  jQuery("#error-feedback-"+formid).html('');
                  jQuery("#um-submit-btn-"+formid).click();
                }
                 
                setTimeout(function() {
                    jQuery('.alert-warning').fadeOut(); 
                   }, 4000 );

            });
        }); 
           
           
           
       
	</script>
	    
<?php
}
add_action( 'um_after_register_fields', 'custom_um_add_submit_button_to_register', 1001 );




add_action( 'woocommerce_review_order_before_submit', 'bbloomer_add_checkout_privacy_policy', 9 );
function bbloomer_add_checkout_privacy_policy() {
   
woocommerce_form_field( 'privacy_policy', array(
   'type'          => 'checkbox',
   'class'         => array('form-row privacy'),
   'label_class'   => array('woocommerce-form__label woocommerce-form__label-for-checkbox checkbox'),
   'input_class'   => array('woocommerce-form__input woocommerce-form__input-checkbox input-checkbox'),
   'required'      => true,
   'label'         => 'I\'ve read and accept the <a href="'.site_url().'/customer-privacy-policy/">Privacy Policy</a>',
)); 
   
}
   
// Show notice if customer does not tick
    
add_action( 'woocommerce_checkout_process', 'bbloomer_not_approved_privacy' );
function bbloomer_not_approved_privacy() {
    if ( ! (int) isset( $_POST['privacy_policy'] ) ) {
        wc_add_notice( __( 'Please acknowledge the Privacy Policy' ), 'error' );
    }
}




add_filter('woocommerce_account_menu_items', 'webtoffee_remove_my_account_links');
function webtoffee_remove_my_account_links($menu_links) {
    //unset($menu_links['subscriptions']); // Subscriptions
    unset($menu_links['payment-methods']); // Payment methods
    return $menu_links;
}

