


		
		<style>
		/*#um_account_submit_mytab{display:none;}*/
		</style>
		
	<div class="um-field">
		
	
	
<?php 

$id = um_user('ID'); 
$user_meta= get_userdata($id);
?>

            
   <div class="tab-content">
         
   <div id="itemList" class="tab-pane in active">  
    <h3>Input Menus</h3>
    
    <table style="width:100%">
    <tr>
        <th>Item #</th>
        <th>Item</th>
        <th>Cuisine</th>
        <th>Cost</th>
        <th>Preview</th>
        <th>Action</th>
    </tr>
    <?php  
    $vendor = get_wcmp_vendor(get_current_vendor_id());
    if (count($vendor->get_products()) > 0)
        {
            foreach ($vendor->get_products() as $product) 
            {  
                $meta = get_post_meta( $product->ID );
                
            ?>    

            <tr>
                <td><?php echo $product->ID; ?> </td>
                <td><?php $product = wc_get_product($product->ID);  echo $product->name; ?></td>
                <td><?php  echo $meta['_product_cuisine_type'][0];  ?></td>
                <td><?php  echo $product->price;?></td>
                <td><div class='quickview' data-id='<?php echo $product->ID; ?>' title='Preview Item'> Preview Item </div></td>
                <td><a href="javascript:void(0)" onclick="f1(<?php echo $product->ID; ?>)" ><i class="fa fa-times text-danger" ></i></a> </td>
            </tr>
    <?php  } 
       } 
    else
    {?>
            
            <tr> <td colspan="6"> No record found... </td></tr>  
    <?php } ?>        
	    </table>
   
   
   <div class="um-col-alt um-col-alt-b">
        <div class="um-left nav nav-tabs">
            <button class="btn blue-btn"><a data-toggle="tab" href="#add_item">Add item</a></button>
        </div>
        <div class="um-clear"></div>
    </div>

   </div>    

       
    <div id="add_item" class="tab-pane ">  
    
    <h3>Item Detail</h3>
    <div class="row">
        <div class="col-md-12">
            <div class="row">    
                <form method="post">
                    <div class="form-row col-md-6" style="float:left; border-right:1px solid;">
                    
                    
                        
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

                    <div class="row">
                        <div class="form-group col-md-6" >
                         <select id="inputState" class="form-control" name="delivery">
                            <option selected value="">Select Delivery</option>
                            <option >Pickup</option>
                          </select>
                        </div>
                        
                        <div class="form-group col-md-6" >
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
                  
                        <div class="row" >
                            <div class="col-md-6" >
                                <input name="submit" type="submit" class="btn btn-primary" Value="Submit"/>
                            </div>
                            <div class="col-md-6"><button class="btn blue-btn"><a data-toggle="tab" href="#itemList"  >Cancel</a></button></div>
                        </div>    
                    
                </div>
                </form>

                <div class="form-row col-md-6" >
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
</div>
        
</div>    
     

   
        

	
	
		 
	</div>		
	
	

	
<script>
function f1(id) {
    
    if(confirm('Are you really want remove ?'))
    {
    jQuery.ajax({ 
         data: {id:id},
         type: 'post',
        
         success: function(data) {
           location.reload();

        }
    });
    }

     
}
</script>

	
	
		
