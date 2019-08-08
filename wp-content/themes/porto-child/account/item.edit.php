<?php
/*
require( '../../../../wp-load.php' );
global $wpdb;
 * 
 */



$link = $_SERVER['REQUEST_URI'];
$link_array = explode('/',$link);
end($link_array);
$itemId = prev($link_array);
    

$iPostMeta = get_post_meta($itemId);
$post_content = get_post($itemId);
$description = $post_content->post_content;


$dryincredient=   get_post_meta($itemId,'_dryincredient',true);
$wetincredient=   get_post_meta($itemId,'_wetincredient',true);
$miscincredient=   get_post_meta($itemId,'_miscincredient',true);
$ultimate_option = get_option('um_fields');
$iCuisine_type = $ultimate_option['cusine']['options'];
$iDelivery_status = $ultimate_option['DELIVERY_STATUS']['options'];
$iNo_of_meals =  get_post_meta($itemId,'_stock',true);;

$iTcategory = get_the_terms($itemId,'product_cat')[0]->name;


?>

<div class="modal-header">
	<h3> Edit Item </h3>
</div>

<div class="modal-body" id="modal">
	
    <form method="post">
        <div class='row'>
                <div class="col-md-6">
                        <div class="form-group">
                                <label><strong>Item ID</strong></label> :
                                <strong><?php echo $itemId; ?></strong>
                        </div>

                        <div class="form-group">
                                <label>Cuisine Type</label>
                                <select class="form-control" id="e_cuisine" required="">
                                        <option selected value="">Cuisine Type</option>
                                        <?php foreach($iCuisine_type as $iCList) { ?>
                                                <option <?php if(get_post_meta($itemId, '_product_cuisine_type',true)==$iCList) { echo 'selected'; } ?> >
                                                        <?php echo $iCList; ?>
                                                </option>
                                                <?php } ?>
                                </select>
                        </div>

                        <div class="form-group">
                                <label>Name of Dish</label>
                                <input type="text" class="form-control" id="e_dish_name" placeholder="Name of Dish" name="dish_name" required="" value="<?php echo get_the_title($itemId); ?>">
                        </div>

                        <div class="form-group">
                                <label>Price Per Unit/Order</label>
                                        <input type="number" class="form-control" id="e_price_unit" placeholder="Price Per Unit/Order" name="price_unit" required value="<?php echo get_post_meta($itemId,'_price',true); ?>">
                        </div>

                        <div class="row">
                                <div class="form-group col-md-6">
                                        <label>Delivery Type</label>
                                        <select id="e_delivery" class="form-control" name="delivery" required>
                                                <option selected value="">Select Delivery</option>
                                                <?php foreach($iDelivery_status as $iDeliveryList) { ?>
                                                        <option <?php if(get_post_meta($itemId, '_product_delivery_type',true)==$iDeliveryList) { echo 'selected'; } ?> >
                                                                <?php echo $iDeliveryList; ?>
                                                        </option>
                                                        <?php } ?>
                                        </select>
                                </div>

                                <div class="form-group col-md-6">
                                        <label>No.Of Meals</label>
                                <!-- 	<select id="e_meal" class="form-control" name="meal" required>
                                        <option selected value="">No.Of Meals</option>
                                        <?php foreach($iNo_of_meals as $iMealsList) { ?>
                                                <option <?php if(get_post_meta($itemId, '_stock',true)==$iMealsList) { echo 'selected'; } ?> >
                                                        <?php echo $iMealsList; ?>
                                                </option>
                                                <?php } ?>
                                </select> -->

        <input type='text' id="e_meal" name='meal' class="form-control" value=<?php echo $iNo_of_meals; ?>></input>

                                </div>
                        </div>



                        <div class="form-group">
                                <label>Available Date</label>
                                <input type="text" class="datepicker form-control" id="e_available_date" placeholder="Available Date" value="<?php echo get_post_meta($itemId,'_product_available_date',true); ?>" required/>
                        </div>

                        <div class="form-group">
                                <label>Category</label>
                                <select id="e_category" class="form-control" name="category" required>
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
                                                <option <?php if($iTcategory==$category->name){ echo 'selected'; } ?> >
                                                        <?php echo $category->name; ?>
                                                </option>
                                                <?php }?>
                                </select>
                        </div>

                        <div class="form-group">
                                <label>Description</label>
                                <textarea class="form-control" id="e_description" placeholder="Description" name="description"><?php echo $description; ?></textarea>
                        </div>


                        <span id="iEditItemMsg"></span>

                        <div class="row">
                                <div class="col-md-6">
                                        <input id="iEdititem" type="button" class="btn btn-primary" Value="Update" />
                                </div>
                                <div class="col-md-6" align="right">
                                        <a href="<?php echo SITE_URL(); ?>/account/#input_menus" class="btn btn-default" >Back</a>
                                </div>
                        </div>


        </div>


                <div class="col-md-6 border-left">
                    <div class="inner-title-right display-2 mb-4"> Ingredients </div>
                     <ul class="nav nav-tabs ing-tab">
                        <li class="active"><a data-toggle="tab" href="#e_dry_ing">Dry Ingredients</a></li>
                        <li><a data-toggle="tab" href="#e_wet_ing">Wet Ingredients</a></li>
                        <li><a data-toggle="tab" href="#e_misc_ing">Misc Info/Allergen Info</a></li>
                      </ul>

                      <div class="tab-content">
                        <div id="e_dry_ing" class="tab-pane fade in active show">
                            <?php wp_editor(stripcslashes($dryincredient), '_dryincredient', array( 'editor_height' => 180, 'media_buttons' => false )); 
                            ?> 
                        </div>
                        <div id="e_wet_ing" class="tab-pane fade">
                            <?php wp_editor(stripcslashes($wetincredient), '_wetincredient', array( 'editor_height' => 180, 'media_buttons' => false )); ?> 
                        </div>
                        <div id="e_misc_ing" class="tab-pane fade">
                            <?php wp_editor(stripcslashes($miscincredient), '_miscincredient', array( 'editor_height' => 180, 'media_buttons' => false ) ); ?> 
                        </div>
                      </div>   
                </div>


        </div>
    </form>
</div>


<script>
        jQuery(document).ready(function() {
                jQuery("#iEdititem").click(function(e) {
                        e.preventDefault();

                        var cuisine = jQuery("#e_cuisine").val();
                        var dish_name = jQuery("#e_dish_name").val();
                        var price_unit = jQuery("#e_price_unit").val();
                        var delivery = jQuery("#e_delivery").val();
                        var meal = jQuery("#e_meal").val();
                        var available_date = jQuery("#e_available_date").val();
                        var category = jQuery("#e_category").val();
                        var description = jQuery("#e_description").val();
                        
                        var dryincredient  = tinyMCE.get('_dryincredient').getContent();
                        var wetincredient  = tinyMCE.get('_wetincredient').getContent();
                        var miscincredient = tinyMCE.get('_miscincredient').getContent();
                        

                        if (cuisine == '') {
                                jQuery("#iEditItemMsg").html('<div class="alert alert-warning alert-dismissible fade show" role="alert"><strong>Error!</strong> Cuisine Type can not blank.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                        } else if (dish_name == '') {
                                jQuery("#iEditItemMsg").html('<div class="alert alert-warning alert-dismissible fade show" role="alert"><strong>Error!</strong> Name of Dish can not blank. <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                        } else if (price_unit == '') {
                                jQuery("#iEditItemMsg").html('<div class="alert alert-warning alert-dismissible fade show" role="alert"><strong>Error!</strong> Price Per Unit/Order can not blank <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                        } else if (delivery == '') {
                                jQuery("#iEditItemMsg").html('<div class="alert alert-warning alert-dismissible fade show" role="alert"><strong>Error!</strong> Please select Delivery <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                        } else if (meal == '') {
                                jQuery("#iEditItemMsg").html('<div class="alert alert-warning alert-dismissible fade show" role="alert"><strong>Error!</strong> Please select No.Of Meals <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                        } else if (available_date == '') {
                                jQuery("#iEditItemMsg").html('<div class="alert alert-warning alert-dismissible fade show" role="alert"><strong>Error!</strong> Available Date can not blank <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                        } else if (category == '') {
                                jQuery("#iEditItemMsg").html('<div class="alert alert-warning alert-dismissible fade show" role="alert"><strong>Error!</strong> Please select Category<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                        } else {
                                jQuery(".ajaxloader").css("display", "block");
                                jQuery("#iEditItemMsg").html('');
                                jQuery.ajax({
                                        type: 'POST',
                                        url: "<?php echo admin_url('/admin-ajax.php'); ?>",
                                        data: {
                                                action: 'edit_chef_item',
                                                itemId: <?php echo $itemId; ?>,
                                                cuisine: cuisine,
                                                dish_name: dish_name,
                                                price_unit: price_unit,
                                                delivery: delivery,
                                                meal: meal,
                                                available_date: available_date,
                                                category: category,
                                                description: description,
                                                   dryincredient :  dryincredient,
                  wetincredient : wetincredient,
                  miscincredient: miscincredient
                                        },
                                        success: function(itemid) {
                                                //jQuery("#iEditItemMsg").html('<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Success!</strong> Item Updated <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                                              
                                              
                                                 window.location.replace("<?php echo SITE_URL(); ?>/account/#input_menus");

                                                jQuery("#itemTable").load(window.location + " #itemTable", function() {
                                                        jQuery(".ajaxloader").css("display", "none");
                                                });
                                        }
                                });
                        }
                });
        });



        // Datepicker    
        jQuery(document).ready(function($) {
                $(".datepicker").datepicker();
        });
</script>

      
        
     
