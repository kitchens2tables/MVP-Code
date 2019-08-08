<?php
 
/*
 Template Name: Chef Account 
 */



get_header(); 


$userdata = get_currentuserinfo();
$user_roles=$userdata->roles[0];



if($user_roles=='customer')
{
    wp_redirect(SITE_URL().'/my-account');
}



?>


  <div class="page-loader-css ajaxloader">
    <div style="width:100%;height:100%" class="page-loader-ripple">
      <div></div>
      <div></div>
    </div>
  </div>

  <div class="tabs  tabs-center tabs-simple">
    <ul class="nav nav-tabs featured-boxes featured-boxes-style-6">
        <li class="nav-item chef-nav-item active" id="update_profile_li"><a data-toggle="tab" class="nav-link" href="#update_profile"><p class="featured-box featured-box-effect-6"><span class="box-content" style="height: 85px;"><i class="icon-featured fas fa-user"></i></span></p>Update Profile</a></li>
        <li class="nav-item chef-nav-item" id="input_menus_li"><a data-toggle="tab" class="nav-link" href="#input_menus"><p class="featured-box featured-box-effect-6"><span class="box-content" style="height: 85px;"><i class="icon-featured fas fa-clipboard-list"></i></span></p>Input Menus</a></li>
        <li class="nav-item chef-nav-item" id="order_backlog_li"><a data-toggle="tab" class="nav-link" href="#order_backlog"><p class="featured-box featured-box-effect-6"><span class="box-content" style="height: 85px;"><i class="icon-featured fas fa-hand-holding-usd"></i></span></p>Order Backlog</a></li>
      <!--li><a data-toggle="tab" href="#questions">Questions </a></li-->
    </ul>
  </div>




  <div class="tab-content">
    <div id="update_profile" class="tab-pane chef-tab-pane in active">
      <?php get_template_part('account/update_profile');?>
    </div>

    <div id="input_menus" class="tab-pane chef-tab-pane fade">
      <?php get_template_part('account/input_menus');?>
    </div>


    <div id="order_backlog" class="tab-pane chef-tab-pane fade">
      <?php get_template_part('account/order_backlog');?>
    </div>

      
      
      
    <div id="item_edit" class="tab-pane chef-tab-pane fade">
    
        
        
        <?php get_template_part('account/item.edit');?>
    </div>

    <!--div id="questions" class="tab-pane fade">
        <?php //get_template_part('account/questions');?>
    </div-->
  </div>


 <script>  
    var tabtype = window.location.hash.substr(1);

    if(tabtype == 'item_edit')
    {
       jQuery(".chef-tab-pane").removeClass("active in");
       jQuery(".chef-nav-item").removeClass("active");
       jQuery("#item_edit").addClass("active in show");
       jQuery("#input_menus_li").addClass("active");
    }
    else if(tabtype != '')
    {
       jQuery(".chef-tab-pane").removeClass("active in");
       jQuery(".chef-nav-item").removeClass("active");
       jQuery("#" + tabtype).addClass("active in show");
       jQuery("#" + tabtype+"_li").addClass("active");
    }
</script>   
  
  <?php
get_footer();