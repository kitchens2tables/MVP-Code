<?php

$ultimate_option = get_option('um_fields');
$iCuisine_type = $ultimate_option['cusine']['options'];
$iDelivery_status = $ultimate_option['DELIVERY_STATUS']['options'];



?>  

<style>
.bigdrop {
    width: 600px !important;
}
</style>

<!--style>
.loader {
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid #3498db;
  width: 120px;
  height: 120px;
  -webkit-animation: spin 2s linear infinite; /* Safari */
  animation: spin 2s linear infinite;
}

/* Safari */
@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>
<div class="loader-holder" >
<div class="loader"></div>
</div-->




    <div id="itemListDiv"  >  
        <div class="watermark-heading">
          <h3>Item List</h3>
          <div>Item List</div>
        </div>        
        <a href="javascript:void(0)" id="add_items"  class="btn cm-orange-btn" style="margin-top: 0 !important;">Add item</a>        
        <div class="w-100 my-3" >
            <span id="insertitemfedback" ></span>
        </div>
        
        <table style="width:100%" id="itemTable">
        <tr>
            <th>Item #</th>
            <th>Item</th>
            <th>Cuisine</th>
            <th>Cost</th>
            <th>Available Until</th>
            <th>Action</th>
        </tr>
            <tbody>
            <?php  
            $iProduct = $wpdb->get_results("select * from ".$wpdb->posts." where post_author =".get_current_vendor_id()." and post_type='product' and post_status='publish' order by id desc ");
            if (count($iProduct) > 0)
            {
                foreach($iProduct as $product)
                {  
                            $meta = get_post_meta( $product->ID );

                        ?>    

                        <tr>
                            <td><?php echo $product->ID; ?> </td>
                            <td><?php $iproduct = wc_get_product($product->ID);  echo $iproduct->name; ?></td>
                            <td><?php  echo $meta['_product_cuisine_type'][0];  ?></td>
                            <td><i class="fa fa-usd" ></i> <?php  echo $iproduct->price;?></td>
                            <td><?php  echo get_post_meta($product->ID,'_product_available_date',true);?></td>
                            <td>
                                <a href="javascript:void(0)" onclick="viewvendorItem(<?php echo $product->ID; ?>)"  ><i class="fas fa-eye" ></i></a>
                                <a href="<?php echo SITE_URL().'/account/'.$product->ID.'/#item_edit'; ?>" ><i class="fas fa-pencil-alt" ></i></a>
                                <a href="javascript:void(0)" id="jqRemoveId" data-id="<?php echo $product->ID; ?>" data-toggle="modal" data-target="#removeItemModel" ><i class="fas fa-times text-danger" ></i></a>

                               
                            </td>
                        </tr>
        <?php  } 
            } 
            else
            {?>
                        <tr> <td colspan="6"> No record found... </td></tr>  
                <?php } ?>
            </tbody>        
  </table>
        
    </div> 
    
<div id="add_item_div" style="display:none" >  
        <div class="watermark-heading">
          <h3>Item Detail</h3>
          <div>Item Detail</div>
        </div>   
    <form method="post" id="addItemForm">            
            <div class="row">    
                <div class="col-md-6">
                                 
                        <div class="form-group">
                            <select class="form-control select2"  id="cuisine" required="">
                                <option selected value="">Cuisine Type</option>
                                <?php foreach($iCuisine_type as $iCList) { ?>
                                <option><?php echo $iCList; ?></option>
                                <?php } ?>
                           </select>
                        </div>
                        
                        <div class="row">
                        <div class="form-group col-md-6">
                            <input type="text" class="form-control" id="dish_name" placeholder="Name of Dish" name="dish_name" required="">
                        </div>

                        <div class="form-group col-md-6">
                            <input type="number" class="form-control" id="price_unit" placeholder="Price Per Unit/Order"  name="price_unit" required>
                        </div>
                       </div>                          

                        <div class="row">
                            <div class="form-group col-md-6" >
                             <select id="delivery" class="form-control" name="delivery" required>
                                <option selected value="">Select Delivery</option>
                                <?php foreach($iDelivery_status as $iDeliveryList) { ?>
                                <option><?php echo $iDeliveryList; ?></option>
                                <?php } ?>
                              </select>
                            </div>

                            <div class="form-group col-md-6" >
                               
                               
                                <input type='number' name='no_of_meals' id="meal" placeholder="No Of Meals" ></input>
                                
                           
                            </div>
                        </div>

                       <div class="row">
                        <div class="form-group col-lg-4 col-md-6">
                           <input type="text" class="datepicker" id="available_date" placeholder="Available Date" required/>
                        </div> 

                        <div class="form-group col-lg-8 col-md-6">
                            <select id="category" class="form-control" name="category" required> 
                                <option selected>Category</option>
                                <?php    
                                 $args = array(
                                   'taxonomy'   => "product_cat",
                                   'number'     => $number,
                                   'orderby'    => $orderby,
                                   'order'      => $order,
                                   'hide_empty' => $hide_empty,
                                   'include'    => $ids
                                 );
                                 $product_categories = get_terms($args);
                                 foreach ($product_categories as $category){   ?>
                                       <option><?php echo $category->name; ?></option>
                                <?php }?>
                            </select>
                        </div>
</div>
                        <div class="form-group">
                            <textarea class="form-control" id="description" placeholder="Description" name="description" rows="5" id='textarea_data'></textarea>
                            <p id="rchars">100</span> Character(s) Remaining </p>
                        </div>

                            
                        <span id="insertitemMsg" ></span>
                        
                        <div class="row" >
                            <div class="col-md-6" >
                                <input id="insertitem" type="button" class="btn cm-orange-btn" Value="Submit"/>
                            </div>
                            <div class="col-md-6" align="right">
                                <a href="javascript:void(0)" id="itemList" class="btn cm-default-btn" style="margin-top: 22px;padding: 15px 45px;">Cancel</a>
                            </div>
                        </div>
                    
                </div>    
                
                <div class="col-md-6 border-left" >
           
                   <div class="inner-title-right display-2 mb-4"> Ingredients </div>
                   
                   
                     <ul class="nav nav-tabs ing-tab">
                        <li class="active"><a data-toggle="tab" href="#dry_ing">Dry Ingredients</a></li>
                        <li><a data-toggle="tab" href="#wet_ing">Wet Ingredients</a></li>
                        <li><a data-toggle="tab" href="#misc_ing">Misc Info/Allergen Info</a></li>
                      </ul>

                      <div class="tab-content">
                        <div id="dry_ing" class="tab-pane fade in active show">
                            <?php wp_editor( '', 'dryincredient', array('editor_height' => 180, 'media_buttons' => false)); ?> 
                        </div>
                        <div id="wet_ing" class="tab-pane fade">
                            <?php wp_editor( '', 'wetincredient', array('editor_height' => 180 , 'media_buttons' => false)); ?> 
                        </div>
                        <div id="misc_ing" class="tab-pane fade">
                            <?php wp_editor( '', 'miscincredient', array('editor_height' => 180, 'media_buttons' => false ) ); ?> 
                        </div>
                      </div>    
                   
                       
                </div>
            </div>     
        </form>
    </div>
        



<!--- View Item Modal ---->
<div id="viewItemModel" class="modal fade" role="dialog" >
    <div class="modal-dialog" style='max-width: 931px !important;'><div class="modal-content" id="viewItemModelcontent"></div></div>
</div>

<!--- Edit Item Modal ---->
<div id="editItemModel" class="modal fade" role="dialog">
    <div class="modal-dialog" style='max-width: 931px !important;'><div class="modal-content" id="editItemModelcontent"></div></div>
</div>

<!--- Remove Item Modal ---->
<div id="removeItemModel" class="modal fade" role="dialog">
    <div class="modal-dialog"  >
        <div class="modal-content" >
           <div class="modal-header justify-content-center">
           <div class="watermark-heading">
            <h3> Remove this item? </h3>
            <div>Remove ?</div>
           </div>            
            </div>
          <div class="modal-body">
            <div class="row" >
                <div class="col text-right" >
                    <button type="button" id="deleteItemButton" class="btn cm-orange-btn" >Yes</button>
                </div>
                <div class="col" >
                    <button type="button" class="btn cm-default-btn" data-dismiss="modal">No</button>
                </div>
            </div>
            </div>
            <input type="hidden" id="iDeleteItemList"  />
        </div>
    </div>
</div>


<script>
 

jQuery(document).on("click", "#jqRemoveId", function () {
    jQuery(".ajaxloader").css("display", "block");
     var ItemId = jQuery(this).data('id');
     jQuery("#iDeleteItemList").val( ItemId );
     jQuery(".ajaxloader").css("display", "none");
 });
 
function viewvendorItem(itemid)
{
  jQuery(".ajaxloader").css("display", "block");
  jQuery("#viewItemModelcontent").load("<?php echo SITE_URL(); ?>/wp-content/themes/porto-child/account/item.view.php?id="+itemid, function() 
  {
        jQuery('#viewItemModel').modal('show');
        jQuery(".ajaxloader").css("display", "none");
  });
}


function viewvendorIngredient(itemid)
{
  jQuery(".ajaxloader").css("display", "block");
  jQuery("#viewItemModelcontent").load("<?php echo SITE_URL(); ?>/wp-content/themes/porto-child/account/ingredient.view.php?id="+itemid, function() 
  {
        jQuery('#viewItemModel').modal('show');
        jQuery(".ajaxloader").css("display", "none");
  });
}




function editvendorItem(itemid)
{
  jQuery(".ajaxloader").css("display", "block");
  
  
  
   jQuery.ajax({
                type:'POST',
                url: ajaxurl,
                data:{
                        action:'editItemModelcontent',
                        itemId:itemid
                },
                success: function(data){
                   //jQuery("#itemTable").load(window.location + " #itemTable");
                            
                        console.log(data);
                        jQuery("#editItemModelcontent").html(data);
                        jQuery('#editItemModel').modal('show');
                        jQuery(".ajaxloader").css("display", "none");
                        
                }
            });
  
  /*
  jQuery("#editItemModelcontent").load("<?php echo SITE_URL(); ?>/wp-content/themes/porto-child/account/item.edit.php?id="+itemid, function() 
  {
        jQuery('#editItemModel').modal('show');
        jQuery(".ajaxloader").css("display", "none");
  });
        */
}
 
 
   
jQuery(document).ready(function(){
 jQuery("#deleteItemButton").click( function(e) {
 e.preventDefault();
                  
 var itemId = jQuery("#iDeleteItemList").val();
 jQuery('#removeItemModel').modal('toggle');
 jQuery("#itemListDiv").show();
 jQuery(".ajaxloader").css("display", "block");
            jQuery.ajax({
                type:'POST',
                url: ajaxurl,
                data:{
                        action:'remove_chef_item',
                        itemId:itemId
                },
                success: function(){
                   //jQuery("#itemTable").load(window.location + " #itemTable");
                       
                       jQuery( "#itemTable" ).load(window.location + " #itemTable" , function() 
                        {
                            jQuery(".ajaxloader").css("display", "none");
                            jQuery("#insertitemfedback").html('<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Success!</strong> Item Removed <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                
                        });
                   }
            });
       
        });
    });
     
   
   
jQuery(document).ready(function(){
 jQuery("#insertitem").click( function(e) {
 e.preventDefault();
                  
 var cuisine = jQuery("#cuisine").val();


 var dish_name =  jQuery("#dish_name").val();
 var price_unit =  jQuery("#price_unit").val();
 var delivery =  jQuery("#delivery").val();
 var meal =  jQuery("#meal").val();
 var available_date =  jQuery("#available_date").val();
 var category =  jQuery("#category").val();
 var description =  jQuery("#description").val();

/* 
 *  var dryincredient =  jQuery("#dryincredient").val();
    var wetincredient =  jQuery("#wetincredient").val();
    var miscincredient =  jQuery("#miscincredient").val();
*/

    var dryincredient  = tinyMCE.get('dryincredient').getContent();
    var wetincredient  = tinyMCE.get('wetincredient').getContent();
    var miscincredient = tinyMCE.get('miscincredient').getContent();




 if(cuisine=='')
 {
     jQuery("#insertitemMsg").html('<div class="alert alert-warning alert-dismissible fade show" role="alert"><strong>Error!</strong> Cuisine Type can not blank.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
 }
 else if(dish_name=='')
 {
     jQuery("#insertitemMsg").html('<div class="alert alert-warning alert-dismissible fade show" role="alert"><strong>Error!</strong> Name of Dish can not blank. <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
 }
 else if(price_unit=='')
 {
     jQuery("#insertitemMsg").html('<div class="alert alert-warning alert-dismissible fade show" role="alert"><strong>Error!</strong> Price Per Unit/Order can not blank <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
 }
 else if(delivery=='')
 {
     jQuery("#insertitemMsg").html('<div class="alert alert-warning alert-dismissible fade show" role="alert"><strong>Error!</strong> Please select Delivery <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
 }
 else if(meal=='')
 {
     jQuery("#insertitemMsg").html('<div class="alert alert-warning alert-dismissible fade show" role="alert"><strong>Error!</strong> Please select No.Of Meals <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
 }
 else if(available_date=='')
 {
     jQuery("#insertitemMsg").html('<div class="alert alert-warning alert-dismissible fade show" role="alert"><strong>Error!</strong> Available Date can not blank <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
 }
 else if(category=='')
 {
     jQuery("#insertitemMsg").html('<div class="alert alert-warning alert-dismissible fade show" role="alert"><strong>Error!</strong> Please select Category<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
 }
 else
 {
            jQuery(".ajaxloader").css("display", "block");
            jQuery("#insertitemMsg").html('');
            jQuery.ajax({
                type:'POST',
                url: ajaxurl,
                data:{
                        action:'add_chef_item',
                        cuisine:cuisine,
                        dish_name:dish_name,
                        price_unit:price_unit,
                        delivery:delivery,
                        meal:meal,
                        available_date:available_date,
                        category:category,
                        description:description,
                        dryincredient :  dryincredient,
                        wetincredient : wetincredient,
                        miscincredient: miscincredient
                },
                success: function(){
                   //jQuery("#itemTable").load(window.location + " #itemTable");
                   jQuery( "#itemTable" ).load(window.location + " #itemTable" , function() 
                        {
                            jQuery(".ajaxloader").css("display", "none");
                            jQuery("#add_item_div").hide();
                            jQuery('#addItemForm').trigger("reset");
                            jQuery("#cuisine").select2("val", "");
                            jQuery("#itemListDiv").show();
                            jQuery("#insertitemfedback").html('<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Success!</strong> Item Added <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                        });
                }
            });
        }
        });
    });
     
 /*   var maxLength = 15;
jQuery('textarea').keyup(function(e) {
  var textlen = maxLength - jQuery(this).val().length;

  if (textlen <= 0 && e.which !== 0 && e.charCode !== 0) {
        $('textarea').val((tval).substring(0, tlength - 1))
    }

  if(textlen>1){
  jQuery('#rchars').text(textlen+' Character(s) Remaining');}
else
{
  jQuery('#rchars').text(textlen+' Character Remaining');
}

});*/

 
jQuery('#description').keypress(function(e) {
    var tval = jQuery('#description').val(),
        tlength = tval.length, 
        set = 100,
        remain = parseInt(set - tlength);
    
if(remain>1){
  jQuery('#rchars').text(remain+' Character(s) Remaining');}
else
{
  jQuery('#rchars').text(remain+' Character Remaining');
}

    if (remain <= 0 && e.which !== 0 && e.charCode !== 0) {
        jQuery('#description').val((tval).substring(0, tlength - 1))
    }
})




    
// Datepicker    
jQuery(document).ready(function($) {
    $(".datepicker").datepicker();
});


// Hide Item List and Show Add Item
jQuery(document).ready(function(){
    jQuery("#add_items").click( function(e) {
        e.preventDefault();
            jQuery("#itemListDiv").hide();
            jQuery("#add_item_div").show();
        });
    });


 // Hide Add Item and Show Item List
jQuery(document).ready(function(){
    jQuery("#itemList").click( function(e) {
        e.preventDefault();
            jQuery("#add_item_div").hide();
            jQuery("#itemListDiv").show();
        });
    });
   
   
jQuery(".select2").select2({
    placeholder: "Cuisine Type",
    tags: true
})
     
</script>

