<?php
 
/*
 Template Name: cook-profile-detail 
 */
global $Wcmp, $wpdb, $woocommerce;

$username = explode('/',$wp->request)[1];
$useriDetails = get_user_by('slug',$username); 

if(empty($useriDetails))
{
    wp_redirect(SITE_URL());
}

get_header(); ?>

<style>
    .added_to_cart
    {
        display: none;
    } 
</style>
    
<div class="page-loader-css ajaxloader">
        <div style="width:100%;height:100%" class="page-loader-ripple">
            <div></div>
            <div></div>
        </div>
    </div>


    <div class="chef-details-wrapper mb-4">
        <div class="container">
            <div class="row">
                <div class="col-md-7 chef-profile-holder mb-5 mb-md-0">
                    <div class="row align-items-center align-items-md-start">
                                <div class="col-sm-4 text-left text-md-center">
                                    <?php 
                                        $userpickurl =  $_SERVER['DOCUMENT_ROOT'].'/kitchens2tables/wp-content/uploads/ultimatemember/'.$useriDetails->ID.'/'.get_user_meta($useriDetails->ID,'profile_photo',true);
                                        if(file_exists($userpickurl)) { 
                                            $iPicPath = SITE_URL().'/wp-content/uploads/ultimatemember/'.$useriDetails->ID.'/'.get_user_meta($useriDetails->ID,'profile_photo',true);
                                        }
                                        else 
                                        {
                                            $iPicPath =    SITE_URL().'/wp-content/plugins/ultimate-member/assets/img/default_avatar.jpg';
                                        }
                                        ?>
                            <img src="<?php echo $iPicPath; ?>" alt="">
                                <h4>
                    <?php echo get_user_meta($useriDetails->ID,'first_name',true).' '.get_user_meta($useriDetails->ID,'last_name',true); ?>
                </h4>
                                               
                <div>
                                
                                    <?php  
                                //echo $user->data->ID; 

                                $all_meta_for_user = get_user_meta($useriDetails->ID);
                                $id_v=$all_meta_for_user['_vendor_term_id'][0];
                                $rating_info = wcmp_get_vendor_review_info($id_v);
                                $totalRating = 5;
                                $starRating = $rating_info["avg_rating"];

                                for ($i = 1; $i <= $totalRating; $i++) {
                                   if($starRating < $i ) {
                                      if(is_float($starRating) && (round($starRating) == $i)){
                                          echo "<i class='fa fa-star-half-o' aria-hidden='true'></i>";
                                      }else{
                                          echo "<i class='fa fa-star-o'></i>";
                                      }
                                   }else {
                                      echo "<i class='fa fa-star' aria-hidden='true'></i>";
                                   }
                                }
                                ?>

                                </div>

 
                            </div>
                            <div class="col-sm-8">
                                <h3>About Cook</h3>
                                <p>
                                    <?php echo get_user_meta($useriDetails->ID,'description',true); ?>
                                </p>
                            </div>
                    </div>
                </div>
                
                <?php 
            
                    $comment_id = $wpdb->get_results("SELECT * FROM wp_commentmeta WHERE (meta_key = 'vendor_rating_id' AND meta_value = '". $useriDetails->ID ."') order by meta_id desc limit 5");
                ?>
                            
                <div class="col-md-5 chef-pReviews-holder">
                    
                    <h3>Past Reviews</h3>
                    <?php if(count($comment_id)>0){ 
                     
                        ?>
                    
                    
                    
                    
                    
                     <div class="owl-carousel-review owl-carousel" >
                                
                                <?php

                                foreach($comment_id as $commetlist)
                                {
                                   
                                $comment_id_data = $commetlist->comment_id;  
                                $comment_contant = get_comments( array('comment__in' => array($comment_id_data)))[0]; 
                                $rating = get_comment_meta( $comment_id_data, 'vendor_rating', true);

                                $comment_content_data = $comment_contant->comment_content;
                                $com_date = $comment_contant->comment_date;
                                $comment_user_id = $comment_contant->user_id;
                                $r_user_info = get_userdata($comment_user_id);
                                if($r_user_info) {
                                ?>
                                    
                                        <div>
                                            <div class="testi-name">
                                                <?php  echo $r_user_info->first_name.' '.$last_name; ?>
                                            </div>
                                            <span class="ratings">
                                                <?php 
                                                    $totalRating = 5;
                                                    $starRating = $rating;
                                                    for ($i = 1; $i <= $totalRating; $i++) {
                                                         if($starRating < $i ) {
                                                            if(is_float($starRating) && (round($starRating) == $i)){
                                                                echo "<i class='fa fa-star-half-o' aria-hidden='true'></i>";
                                                            }else{
                                                                echo "<i class='fa fa-star-o'></i>";
                                                            }
                                                         }else {
                                                            echo "<i class='fa fa-star' aria-hidden='true'></i>";
                                                         }
                                                    }
                                                ?> 
                                            </span>         
                                            <span class="testi-time">
                                            <?php 
                                                echo time_elapsed_string($com_date); ?>
                                            </span>
                                            <p><?php echo $comment_content_data; ?></p>
                                        </div>
                                <?php }} ?>  
                               
                    </div>
                    
                      
                  
                    
                    
                       
                            
                        <?php } else { ?>
                            <span class="default-testimonial"> <sup><i class="fa fa-quote-left" ></i></sup> All you need is love. But a little chocolate now and then doesn't hurt. <sub><i class="fa fa-quote-right" ></i></sub> </span>
                            <span> - Charles M. Schulz</span>
                        <?php } ?>
                </div>
                                
                <div class="col-sm-12 chef-items-holder">
                    <div class="row">
                        <div class="col-sm-12 table-responsive mb-4">
                            <table class="default-table table">
                                <tbody>
                                    <tr class="thead">
                                        <td>Cuisine</td>
                                        <td>Category</td>
                                        <td>Dish</td>
                                        <td>Details</td>
                                        <td>Quantity</td>
                                        <td>Price</td>
                                        <td style="width:11%;">Date Available</td>
                                        <td></td>
                                    </tr>
                                    <?php
                                    $proCount = 0;
                                    $iProduct = $wpdb->get_results("select * from ".$wpdb->posts." where post_author =".$useriDetails->ID." and post_type='product' and post_status='publish' order by id desc ");
                                    if(count($iProduct)>0) {
                                        
                                    foreach($iProduct as $proList)
                                    { 
                                        $_product_available_date = get_post_meta($proList->ID,'_product_available_date',true);
                                       
                                        $productdate = date_create($_product_available_date);
                                        
                                        $AvailableUnixtime = strtotime('+23 hour +59 minutes +59 seconds',strtotime(date_format($productdate,"Y/m/d H:i:s"))); 
                                        $currentDateTime = current_time('timestamp');
                                        
                                        
                                        if(($AvailableUnixtime >= $currentDateTime) && $_product_available_date) 
                                        {
                                        
                                            $stock = get_post_meta($proList->ID,'_stock',true); 
                                        $stock_status = get_post_meta($proList->ID,'_stock_status',true); 
                                        $proCount++;
                                         
                                        $CutoffUnixtime = strtotime('-12 hour',strtotime(date_format($productdate,"Y/m/d H:i:s"))); 
                                    
                                        ?>
                                        <tr class="<?php if($stock <= 0 || $stock_status=='outofstock' || $CutoffUnixtime <= $currentDateTime) { echo 'disable-row'; } ?>" >
                                            <td>
                                                <?php echo get_post_meta($proList->ID,'_product_cuisine_type',true); ?>
                                            </td>
                                            <td><?php echo get_the_terms($proList->ID,'product_cat')[0]->name; ?></td>
                                            <td>
                                                <?php echo $proList->post_title; ?>
                                            </td>
                                            <td>
                                                <?php echo $proList->post_content; ?>
                                                <br>
                                                <a href="javascript:void(0)" data-toggle="modal" data-target="#ingredient<?php echo $proList->ID; ?>" >Ingredient details</a>
                                            </td>
                                            <td>
                                                <?php if($stock > 0 && $stock_status!='outofstock') { ?> 
                                                <select name="quantity" id='quantity' <?php if($stock <= 0 || $stock_status=='outofstock' || $CutoffUnixtime <= $currentDateTime) { echo 'disabled'; } ?> onchange="getQuantity(this,<?php echo $proList->ID;?>)">
                                                        <option value="0">0</option>
                                                        
                                                        <?php for ($i = 1; $i <= $stock; $i++) : ?>
                                                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                        <?php endfor; ?>
                                                    </select>
                                                <?php } else { ?>
                                                    <span class="chef-outof-stock">Out Of Stock</span>
                                                <?php } ?>    
                                            </td>
                                            <td><?php echo get_woocommerce_currency_symbol(); ?><?php echo get_post_meta($proList->ID,'_price',true); ?></td>
                                            <td><?php echo  date('Y-m-d', strtotime(get_post_meta($proList->ID,'_product_available_date',true))); ?></td>
                                            <td id='replaceadd<?php echo $proList->ID; ?>'> 
                                                <a href="?add-to-cart=<?php echo $proList->ID; ?>" id="add_to_cart_link_<?php echo $proList->ID; ?>" data-quantity="1" class="viewcart-style-1 button product_type_simple add_to_cart_button ajax_add_to_cart added" data-product_id="<?php echo $proList->ID; ?>" style="display:none" ></a>
                                                <a style='text-decoration: none;background-color: cadetblue;'  href="javascript:void(0)" id="add_to_cart_display_button_<?php echo $proList->ID; ?>" onclick="" class="viewcart-style-1 button product_type_simple add_to_cart_button added" rel="nofollow" >Add to cart</a>
                                            </td>
                                        </tr>
                                                                                
                                        <div id="ingredient<?php echo $proList->ID; ?>" class="modal fade" role="dialog">
                                            <div class="modal-dialog">
                                              <!-- Modal content-->
                                              <div class="modal-content">
                                                <div class="modal-header" style="justify-content: flex-start;">
                                                  <div class="inner-title-left display-2 mb-0"> Ingredients </div>
                                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-4">
                                                        <div class="inner-subtitle1-right display-3 mb-2"> Dry Ingredients  </div>                       
                                                        <?php echo get_post_meta($proList->ID,'_dryincredient',true); ?> 
                                                    </div>
                                                    <div class="mb-4">
                                                        <div class="inner-subtitle1-right display-3 mb-2"> Wet Ingredients </div>                       
                                                        <?php echo get_post_meta($proList->ID,'_wetincredient',true); ?>
                                                    </div>
                                                    <div class="mb-4">
                                                        <div class="inner-subtitle1-right display-3 mb-2">Misc Info/Allergen Info  </div>                       
                                                        <?php echo get_post_meta($proList->ID,'_miscincredient',true); ?>
                                                    </div>
                                                </div>                                                                                        
                                              </div>
                                            </div>
                                        </div>
                                                                
                                        <?php  } }
                                        
                                        if($proCount == 0)
                                        {
                                            ?>
                                        <tr>
                                            <td colspan="8">Sorry! No Item available right now...</td>
                                        </tr>
                                        <?php 
                                        }  
                                        
                                        
                                        } else { ?>
                                        <tr>
                                            <td colspan="8">Sorry! No Item available right now...</td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-sm-8">
                            <div class="special-requests">
                                <div class="form-group">
                                    <label for="special-request" class="control-label">Any Special Request</label>
                                    <textarea id="special_request" value="" class="form-control" rows="4"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="float-none float-sm-right">
                            
                                                        
                                
                                                        <?php if(count($iProduct)>0 && $proCount != 0) {
                                                        
                                                       
                                                        ?>    
                                                            <!--a href="<?php echo SITE_URL(); ?>/cart" class="btn btn-default cm-orange-btn" >Cart</a-->
                                                            
                                                            <button class="btn btn-default cm-orange-btn" id="o_checkout" >Checkout</button>
                                                        <?php } ?>
                                                        </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

<div id="plsadditem" class="modal fade" role="dialog">
  <div class="modal-dialog">

          
    <!-- Modal content-->
    <div class="modal-content">
      
      <div class="modal-body">
          <h3 class="mb-0">Please add some item in cart</h3>
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn cm-orange-btn" data-dismiss="modal">Okay</button>
      </div>
    </div>

  </div>
</div>

<div id="selecteSameVendorOrder" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-body">
          <h3 class="mb-0">You can select only same vendor item in single order</h3>
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn cm-orange-btn" data-dismiss="modal">Okay</button>
      </div>
    </div>

  </div>
</div>

<div id="view_stock_error" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-body">
          <h3 class="mb-0">Please add new item. your request for this product is out of stock</h3>
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn cm-orange-btn" data-dismiss="modal">Okay</button>
      </div>
    </div>

  </div>
</div>


<script>





    function add_to_cart(pid, qty)
    {

        
        jQuery(".ajaxloader").css("display", "block");
        jQuery.ajax({
                        type: 'POST',
                        url: ajaxurl,
                        data: {
                                action: 'add_to_cart_custom',
                                pid: pid,
                                qty: qty
                        },
                        success: function(data) 
                        {
                            jQuery(".ajaxloader").css("display", "none");
                            if(data==1)
                            {
                                jQuery('#selecteSameVendorOrder').modal('show');
                            }

                           
                            else
                            {
                                jQuery("#add_to_cart_link_"+pid).trigger("click");
                                jQuery("#add_to_cart_display_button_"+pid).css('background-color', '#162245');
                            }    
                        }
                    });
    
    }
    
    jQuery(document).ready(function () {
    jQuery("#o_checkout").click(function (e) {
            e.preventDefault();
            
            var special_request = jQuery("#special_request").val();
            
            jQuery(".ajaxloader").css("display", "block");
            jQuery.ajax({
                            type: 'POST',
                            url: ajaxurl,
                            data: {
                                    action: 'order_checkout_w_s',
                                    special_request: special_request
                            },
                            success: function (data) {
                                    jQuery(".ajaxloader").css("display", "none");
                                    if(data==2)
                                    {
                                        jQuery('#plsadditem').modal('show');
                                    }
                                    else
                                    {                                    
                                        window.location.href = "<?php echo SITE_URL(); ?>/checkout";
                                    }    
                            }
                        });
        
         
                            
                        });
        });
   
</script>    


<script>




    
    function add_to_cart(pid, qty)
    {
       
        jQuery(".ajaxloader").css("display", "block");
        jQuery.ajax({
                        type: 'POST',
                        url: ajaxurl,
                        data: {
                                action: 'add_to_cart_custom',
                                pid: pid,
                                qty: qty
                        },
                        success: function(data) 
                        {

                           jQuery(".ajaxloader").css("display", "none");
                            if(data==3)
                            {
                                jQuery('#selecteSameVendorOrder').modal('show');
                            }

                            else if(data==2)
                            {
                               //console.log('hello1234');
                             
                                 //jQuery('#replaceadd').css('display','none');


                            }
                            else if(data==1)
                            {
                                jQuery("#add_to_cart_link_"+pid).trigger("click");
                                jQuery("#add_to_cart_display_button_"+pid).css('background-color', '#162245');
                            }    

                            
                        }
                    });
    
    }
    
    jQuery(document).ready(function () {
    jQuery("#o_checkout").click(function (e) {
            e.preventDefault();
            
            var special_request = jQuery("#special_request").val();
            
            jQuery(".ajaxloader").css("display", "block");
            jQuery.ajax({
                            type: 'POST',
                            url: ajaxurl,
                            data: {
                                    action: 'order_checkout_w_s',
                                    special_request: special_request
                            },
                            success: function (data) {
                                    jQuery(".ajaxloader").css("display", "none");
                                    if(data==2)
                                    {
                                        jQuery('#plsadditem').modal('show');
                                    }
                                    else
                                    {                                    
                                        window.location.href = "<?php echo SITE_URL(); ?>/checkout";
                                    }    
                            }
                        });
        
         
                            
                        });
        });
   
</script>    
    
<script>
 

function getQuantity(sel,id)
{
    var quantity=sel.value;
    var id=id;
   
   if(quantity==0)
   {
        jQuery("#replaceadd"+id).html('<a style="text-decoration: none;background-color: cadetblue;"  href="javascript:void(0)" id="add_to_cart_display_button_'+id+'" onclick="" class="viewcart-style-1 button product_type_simple add_to_cart_button added" rel="nofollow" >Add to cart</a>');
    }
    else
    {
        jQuery("#replaceadd"+id).html('<a href="?add-to-cart='+id+'" id="add_to_cart_link_'+id+'" data-quantity='+quantity +' class="viewcart-style-1 button product_type_simple add_to_cart_button ajax_add_to_cart added" data-product_id="'+id+'" style="display:none" ></a> <a href="javascript:void(0)" id="add_to_cart_display_button_'+id+'" onclick="add_to_cart('+"'"+id +"'"+','+ "'"+quantity+"'"+ ')" class="viewcart-style-1 button product_type_simple add_to_cart_button added" rel="nofollow" >Add to cart</a>');
    }    
}


</script>


<script>
jQuery(document).ready(function(){
    jQuery(".owl-carousel-review").owlCarousel({
                          center: false,
                          stagePadding: 0,
                          responsive:{
                                        0:{
                                            items:1
                                        },
                                        600:{
                                            items:1
                                        },
                                        1000:{
                                            items:1
                                        }
                                    }
                      });
                    });
</script>
                    
<?php get_footer(); ?>

