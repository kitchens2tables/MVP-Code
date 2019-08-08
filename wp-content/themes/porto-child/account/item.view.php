<?php

require( '../../../../wp-load.php' );
global $wpdb;

$itemId = $_GET['id'];

$iPostMeta = get_post_meta($_GET['id']);
$post_content = get_post($itemId);
$description = $post_content->post_content;

$iTcategory = get_the_terms($itemId,'product_cat')[0]->name;
?>


<div class="modal-header">
	<h3> View Item </h3>
	</div>
	<div class="modal-body py-0">

		<div class="row">
                    <div class="col-md-6">
                    <p><strong> View Item Details </strong></p>
                    
                    <div class="row border-bottom py-2 bg-light">
                        <div class="col">Item ID</div>
                        <div class="col"><?php echo $itemId; ?></div>
                    </div>

                    <div class="row border-bottom py-2">
                        <div class="col">Cuisine type</div>
                        <div class="col"><?php echo get_post_meta($itemId,'_product_cuisine_type',true); ?></div>
                    </div>

                    <div class="row border-bottom py-2 bg-light">
                        <div class="col">Name of Dish</div>
                        <div class="col"><?php echo get_the_title($itemId); ?></div>
                    </div>

                    <div class="row border-bottom py-2">
                        <div class="col">Price</div>
                        <div class="col"><?php echo get_woocommerce_currency_symbol(). get_post_meta($itemId,'_price',true); ?></div>
                    </div>

                    <div class="row border-bottom py-2 bg-light">
                        <div class="col">Delivery</div>
                        <div class="col"><?php echo get_post_meta($itemId,'_product_delivery_type',true); ?></div>
                    </div>

                    <div class="row border-bottom py-2">
                        <div class="col">No of Meals</div>
                        <div class="col"><?php echo get_post_meta($itemId,'_stock',true); ?></div>
                    </div>

                    <div class="row border-bottom py-2 bg-light">
                        <div class="col">Available Date</div>
                        <div class="col"><?php echo get_post_meta($itemId,'_product_available_date',true); ?></div>
                    </div>

                    <div class="row border-bottom py-2">
                        <div class="col">Category</div>
                        <div class="col"><?php echo $iTcategory; ?></div>
                    </div>

                    <div class="row py-2 bg-light">
                        <div class="col">Description</div>
                        <div class="col"><?php echo $description; ?></div>
                    </div>

                    </div>
                    
                    <div class="col-md-6 border-left">

                        <div class="inner-title-right display-2 mb-4"> Ingredients </div>
                        
                        
                        <div class="accordion" id="accordionExample">
                            <div class="card">
                              <div class="card-header" id="headingOne">
                                <h2 class="mb-0">
                                  <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                   Dry Ingredients
                                  </button>
                                </h2>
                              </div>

                              <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                                <div class="card-body">
                                  <?php echo get_post_meta($itemId,'_dryincredient',true); ?>  </div>
                              </div>
                            </div>
                            <div class="card">
                              <div class="card-header" id="headingTwo">
                                <h2 class="mb-0">
                                  <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    Wet Ingredients
                                  </button>
                                </h2>
                              </div>
                              <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                <div class="card-body">
                                    <?php echo get_post_meta($itemId,'_wetincredient',true); ?>
                               </div>
                              </div>
                            </div>
                            <div class="card">
                              <div class="card-header" id="headingThree">
                                <h2 class="mb-0">
                                  <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    Misc Info/Allergen Info
                                  </button>
                                </h2>
                              </div>
                              <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                                <div class="card-body">
                                    <?php echo get_post_meta($itemId,'_miscincredient',true); ?>
                                </div>
                              </div>
                            </div>
                          </div>
                        
                        
                       
                        
                        
                        

                        <!--ul class="nav nav-tabs ing-tab">
                           <li class="nav active"><a data-toggle="tab" href="#v_dry_ing">Dry Ingredient</a></li>
                           <li class="nav"><a data-toggle="tab" href="#v_wet_ing">Wet Ingredient</a></li>
                           <li class="nav"><a data-toggle="tab" href="#v_misc_ing">Misc Info/Allergen Info</a></li>
                         </ul>

                         <div class="tab-content">
                           <div id="v_dry_ing" class="tab-pane fade in active show">
                               <?php echo get_post_meta($itemId,'_dryincredient',true); ?>
                           </div>
                           <div id="v_wet_ing" class="tab-pane fade">
                               <?php echo get_post_meta($itemId,'_wetincredient',true); ?>
                           </div>
                           <div id="v_misc_ing" class="tab-pane fade">
                               <?php echo get_post_meta($itemId,'_miscincredient',true); ?>
                           </div>
                         </div-->   

                    </div>

            </div>



</div>
<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>