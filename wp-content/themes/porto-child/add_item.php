<?php
/**
* Template Name: Add_item Page
*
* @package WordPress
* @subpackage Twenty_Fourteen
* @since Twenty Fourteen 1.0
*/
 
if(isset($_POST['submit']))
{

    global $wpdb;
       
    $new_product_post_id = wp_insert_post(
                                            array(
                                                    'post_content'  =>  $_POST['description'],
                                                    'post_title'    =>  $_POST['dish_name'],
                                                    'post_status'   =>  'publish',
                                                    'post_type'     =>  'product'
                                                )
                                        );
        
    //echo $new_product_post_id;
    update_post_meta( $new_product_post_id, '_visibility', 'visible' ); 
    add_post_meta($new_product_post_id, '_price', $_POST['price_unit'], true );
    add_post_meta($new_product_post_id, '_product_cuisine_type', $_POST['cuisine'], true );
    add_post_meta($new_product_post_id, '_stock', $_POST['meal'], true ); 
    add_post_meta($new_product_post_id, '_product_delivery_type', $_POST['delivery'], true );  
    add_post_meta($new_product_post_id, '_product_available_date', $_POST['available_date'], true );  

    $term = get_term_by('name', $_POST['category'], 'product_cat');
    wp_set_object_terms($new_product_post_id, $term->term_id, 'product_cat'); 
    
}

?>






<html class="no-js">
<head>
    <meta charset="">
    <meta name="viewport" content="width=device-width, initial-scale=1">




   <?php echo get_header();; ?>




<style>

.inner-title{
    font-size: 25px;
    margin: 10px 0px 10px 0px;
    font-weight: 800;
}

.inner-title-right {
    font-size: 20px;
    margin: 15px 0px 15px 0px;
    font-weight: 600;
}

.inner-subtitle1-right
{
   color: #0b48af;
    font-size: 15px;
    font-weight: 600;
}

.hr
{
   color: #0b48af;
    font-size: 15px;
    font-weight: 600;
    border-bottom: 4px solid #0b48af;
    margin: 5px 0px 10px 0px;
    width: 28px;
    padding: 0px;
}
 p
{
  
    margin:  0px;
   
    padding: 0px;
}


</style>


</head>
<body>

<form method="post">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                
                 
  <div class="form-row col-md-6" style="float:left; border-right:1px solid;">
       <div class="inner-title"> ITEM Details </div>
    <div class="form-group">
        <select id="inputState" class="form-control"  name="cuisine">
            <option selected value="">Cuisine Type</option>
            <option>Indian</option>
            <option>Chinese</option>
       </select>
    </div>
    <div class="form-group">
     <input type="text" class="form-control" id="dish_name" placeholder="Name Of The Dish" name="dish_name">
    </div>
    
    <div class="form-group">
    <input type="text" class="form-control" id="price_unit" placeholder="Price Per Unit/Order"  name="price_unit">
  </div>
  
   <div class="form-row col-md-12">
    <div class="form-group col-md-6" style="float:left;">
     <select id="inputState" class="form-control" name="delivery">
        <option selected value="">Select Delivery</option>
        <option >Pickup</option>
      </select>
    </div>
    <div class="form-group col-md-6" style="float:left;">
       <select id="inputState" class="form-control" name="meal"> 
        <option selected>No.Of Meals</option>
        <option>1</option>
        <option>2</option>
      </select>
    </div>
    </div>
    
    
     <div class="form-group">
     
         <input type="text" class="datepicker" name="available_date" placeholder="Available Date"/>
       </div> 
     <div class="form-group">
         
  
          <select id="category" class="form-control" name="category"> 
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
    <div class="form-group">
        <input type="text" class="form-control" id="description" placeholder="Description" name="description">
      
    </div>
  </div>
 
 
 <div class="form-row col-md-6" style="float:left;">
   
   <div class="inner-title-right"> Ingredient </div>
       <div style="margin-bottom:5px;">
     <div class="inner-subtitle1-right">Dry Incredient  </div>
     <hr class="hr">
    <p><i class="fa fa-check" aria-hidden="true"></i> lorem ipsum </p> 
    <p><i class="fa fa-check" aria-hidden="true"></i> lorem ipsum </p> 
    <p><i class="fa fa-check" aria-hidden="true"></i> lorem ipsum </p> 
    </div>
     

   
       <div style="margin-bottom:5px;">
      <div class="inner-subtitle1-right">Wet Incredient </div>
       <hr class="hr">
      
    <p>  <i class="fa fa-check" aria-hidden="true"></i>lorem ipsum </p> 
    <p><i class="fa fa-check" aria-hidden="true"></i> lorem ipsum </p> 
    <p><i class="fa fa-check" aria-hidden="true"></i> lorem ipsum </p> 
    </div>
     
     
       <div style="margin-bottom:5px;">
      <div class="inner-subtitle1-right">Misc Info/Allergen Info  </div>
       <hr class="hr">
    <p><i class="fa fa-check" aria-hidden="true"></i> lorem ipsum </p> 
    <p><i class="fa fa-check" aria-hidden="true"></i> lorem ipsum </p> 
    <p><i class="fa fa-check" aria-hidden="true"></i> lorem ipsum </p> 
    </div>
     
 
  </div>
  </div>
  </div>
  </div>
 
 
  <input name="submit" type="submit" class="btn btn-primary" Value="Submit"/>
  
</form>
    
<script>
    jQuery(document).ready(function($) {
        $(".datepicker").datepicker();
    });
</script>


<?php echo get_footer(); ?>
</body>
</html>
 

