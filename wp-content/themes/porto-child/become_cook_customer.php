<?php
 
/*
 Template Name: Become a Cook Customer
 */
global $Wcmp,$wpdb;

$user_meta=get_userdata(get_current_user_id());

$user_roles=$user_meta->roles;

if(!in_array('customer',$user_roles))
{
  // wp_redirect(SITE_URL()); 
}

get_header(); ?>

<div class="page-loader-css ajaxloader" ><div style="width:100%;height:100%" class="page-loader-ripple"><div></div><div></div></div></div>

	<form method="post" action="">
					<div class="form-group mb-4">
						<label for="Username">Username</label>
						<input type="text" class="form-control" value="<?php echo $userdata->data->user_login; ?>" readonly> </div>
					<div class="row">
						<div class="form-group col-md-6 mb-4">
							<label for="First Name">First Name</label>
							<input type="text" id="first_name" class="form-control" value="<?php echo get_user_meta($userdata->ID, 'first_name', true);?>"> </div>
						<div class="form-group col-md-6 mb-4">
							<label for="Last Name">Last Name</label>
							<input type="text" id="last_name" class="form-control" value="<?php echo get_user_meta($userdata->ID, 'last_name', true);?>"> </div>
					</div>
					<div class="form-group mb-4">
						<label for="E-mail Address">E-mail Address</label>
						<input type="text" id="email_address" class="form-control" value="<?php echo $userdata->data->user_email; ?>"> </div>
					<div class="form-group mb-4">
						<label for="Address Line 1">Address Line 1</label>
						<textarea type="text" id="address_line_1" class="form-control" ><?php echo get_user_meta($userdata->ID, 'Address_Line_1', true);?></textarea>
					</div>
					<div class="form-group mb-4">
						<label for="Address Line 2">Address Line 2</label>
						<textarea type="text" id="address_line_2" class="form-control" ><?php echo get_user_meta($userdata->ID, 'Address_Line_2', true);?></textarea>
					</div>
					<div class="row">
						<div class="form-group col-md-4 mb-4">
							<label for="City">City</label>
							<input type="text" id="u_city" class="form-control" value="<?php echo get_user_meta($userdata->ID, 'City', true);?>"> </div>
						<div class="form-group col-md-4 mb-4">
							<label for="State">State</label>
							<input type="text" id="u_state" class="form-control" value="<?php echo get_user_meta($userdata->ID, 'State', true);?>"> </div>
						<div class="form-group col-md-4 mb-4">
							<label for="Zip">Zip</label>
							<input type="text" id="u_zip" class="form-control" value="<?php echo get_user_meta($userdata->ID, 'Zip', true);?>"> </div>
					</div>
					<div class="form-group mb-4">
						<label for="License Info">License Info</label>
						<input type="text" id="license_info" class="form-control" value="<?php echo get_user_meta($userdata->ID, 'License_Info', true);?>"> 
                                        </div>
                                        <div class="form-group mb-4">
						<label for="Address Line 2">About your self</label>
						<textarea type="text" id="description" class="form-control" ><?php echo get_user_meta($userdata->ID, 'description', true);?></textarea>
					</div>
                                        <span id="BCCfeedback" ></span>
					<p class="um-notice success" id="updateprofilefeedback" style="display:none;"><i class="um-icon-ios-close-empty" onclick="jQuery(this).parent().fadeOut();"></i>Your account was updated successfully.</p>
					<div class="form-group text-center mb-4">
						<input type="button" class="btn cm-orange-btn" id="updateprofile" value="Update to Cook"> </div>
				</form>


<script>
		// Update Profile
		jQuery(document).ready(function () {
			jQuery("#updateprofile").click(function (e) {
				e.preventDefault();
				var first_name = jQuery("#first_name").val();
				var last_name = jQuery("#last_name").val();
				var email_address = jQuery("#email_address").val();
				var address_line_1 = jQuery("#address_line_1").val();
				var address_line_2 = jQuery("#address_line_2").val();
				var u_city = jQuery("#u_city").val();
				var u_state = jQuery("#u_state").val();
				var u_zip = jQuery("#u_zip").val();
				var license_info = jQuery("#license_info").val();
                                var description = jQuery("#description").val();
                                

                                if(first_name=='')
                                {
                                    jQuery("#BCCfeedback").html('<div class="alert alert-warning alert-dismissible fade show" role="alert"><strong>Error!</strong> First name can not be left blank.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                                }
                                else if(last_name=='')
                                {
                                    jQuery("#BCCfeedback").html('<div class="alert alert-warning alert-dismissible fade show" role="alert"><strong>Error!</strong> Last name can not be left blank.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                                }
                                else if(email_address=='')
                                {
                                    jQuery("#BCCfeedback").html('<div class="alert alert-warning alert-dismissible fade show" role="alert"><strong>Error!</strong> Email Id can not be left blank.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                                }
                                else if(license_info=='')
                                {
                                    jQuery("#BCCfeedback").html('<div class="alert alert-warning alert-dismissible fade show" role="alert"><strong>Error!</strong> License Info can not be left blank.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                                }
                                else if(description=='')
                                {
                                    jQuery("#BCCfeedback").html('<div class="alert alert-warning alert-dismissible fade show" role="alert"><strong>Error!</strong> Bio Info can not be left blank.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                                }
                                else
                                {
                                    jQuery(".ajaxloader").css("display", "block");
                                    jQuery.ajax({
                                            type: 'POST'
                                            , url: ajaxurl
                                            , data: {
                                                    action: 'become_chef_customer'
                                                    , first_name: first_name
                                                    , last_name: last_name
                                                    , email_address: email_address
                                                    , address_line_1: address_line_1
                                                    , address_line_2: address_line_2
                                                    , u_city: u_city
                                                    , u_state: u_state
                                                    , u_zip: u_zip
                                                    , license_info: license_info,
                                                    about_yourself: description

                                            , }
                                            , success: function () {
                                                    jQuery("#updateprofilefeedback").css("display", "block");
                                                    window.location.replace("<?php echo SITE_URL(); ?>/confirmation-message");



                                            }
                                    });
                                }
			});
		});
</script>                
                


	<?php get_footer(); ?>


