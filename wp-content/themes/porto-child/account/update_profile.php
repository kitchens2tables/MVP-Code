<div class="watermark-heading">
    <h3>Profile Details</h3>
    <div>Profile Details</div>
</div>
<?php
$userdata = wp_get_current_user();
?>
	<style>
		.um-profile-body {
			display: none;
		}
		
		.um-meta-text {
			display: none;
		}
	</style>
	<ul class="nav nav-tabs">
		<li class="nav-item active"><a data-toggle="tab" class="nav-link" href="#profile">Update Profile</a></li>
		<li class="nav-item"><a data-toggle="tab" class="nav-link" href="#password">Change Password</a></li>
		<li class="nav-item"><a data-toggle="tab" class="nav-link" href="#privacy">Privacy</a></li>
	</ul>
	<div class="tab-content">
		<div id="profile" class="tab-pane in active">
			<?php echo do_shortcode('[ultimatemember form_id="3429"]'); ?>
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
						<textarea type="text" id="about_your_self" class="form-control" ><?php echo get_user_meta($userdata->ID, 'description', true);?></textarea>
					</div>
                                        
                                        <span id="UP_feedback" ></span>
                                    	<p class="um-notice success" id="updateprofilefeedback" style="display:none;"><i class="um-icon-ios-close-empty" onclick="jQuery(this).parent().fadeOut();"></i>Your account was updated successfully.</p>
					<div class="form-group text-center mb-4">
						<input type="button" class="btn cm-orange-btn" id="updateprofile" value="Update Profile"> </div>
				</form>
		</div>
		<div id="password" class="tab-pane fade mx-auto my-3">
			<div class="form-group">
				<label for="Current Password">Current Password</label>
				<input type="password" id="current_password" class="form-control" value=""> </div>
			<div class="form-group">
				<label for="New Password">New Password</label>
				<input type="password" id="new_password" class="form-control" value=""> </div>
			<div class="form-group">
				<label for="Confirm Password">Confirm Password</label>
				<input type="password" id="confirm_password" class="form-control" value=""> </div>
			<p class="um-notice success" id="changepasswordfeedback" style="display:none;"><i class="um-icon-ios-close-empty" onclick="jQuery(this).parent().fadeOut();"></i><span id="changePwdMsg"></span></p>
			<div class="form-group text-center">
				<input type="button" class="btn cm-orange-btn" id="change_password" value="Change Password"> </div>
		</div>
		<div id="privacy" class="tab-pane fade my-3 text-center">
			<label>Hide my profile from directory ?</label>
			<div class="row mb-2 mt-3">
				<div class="col text-right pr-3">
                                    <?php $hidMember = get_user_meta($userdata->ID, 'hide_in_members', true); ?>
                                        <input type="radio" class="form-check-input" id="hide_in_members_no" name="hide_in_members" value="2" <?php if($hidMember) { if($hidMember==2){ echo 'checked'; } } else { echo 'checked'; } ?> >
                                        <label class="form-check-label" for="hide_in_members_no" > No </label>
                                        
				</div>
				<div class="col text-left pl-3">
					<input type="radio" class="form-check-input" id="hide_in_members_yes" name="hide_in_members" value="1" <?php if($hidMember==1){ echo 'checked'; } ?>>
					<label class="form-check-label" for="hide_in_members_yes"> Yes </label>
				</div>
			</div>
			<p class="um-notice success" id="hidememberfeedback" style="display:none;"><i class="um-icon-ios-close-empty" onclick="jQuery(this).parent().fadeOut();"></i><span id="hidememberMsg"></span></p>
			<div class="form-group">
				<input type="button" class="btn cm-orange-btn" id="hideme" value="Save"> </div>
		</div>
	</div>
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
				var description = jQuery("#about_your_self").val();
                                
                                if(first_name=='')
                                {
                                    jQuery("#UP_feedback").html('<div class="alert alert-warning alert-dismissible fade show" role="alert"><strong>Error!</strong> First name can not be left blank.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                                }
                                else if(last_name=='')
                                {
                                    jQuery("#UP_feedback").html('<div class="alert alert-warning alert-dismissible fade show" role="alert"><strong>Error!</strong> Last name can not be left blank.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                                }
                                else if(email_address=='')
                                {
                                    jQuery("#UP_feedback").html('<div class="alert alert-warning alert-dismissible fade show" role="alert"><strong>Error!</strong> Email Id can not be left blank.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                                }
                                else if(license_info=='')
                                {
                                    jQuery("#UP_feedback").html('<div class="alert alert-warning alert-dismissible fade show" role="alert"><strong>Error!</strong> License Info can not be left blank.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                                }
                                else
                                {
                                        jQuery(".ajaxloader").css("display", "block");
                                        jQuery.ajax({
                                            type: 'POST'
                                            , url: ajaxurl
                                            , data: {
                                                    action: 'updateprofile'
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
                                                    jQuery(".ajaxloader").css("display", "none");
                                                    jQuery("#updateprofilefeedback").css("display", "block");
                                            }
                                    });
                                }
			});
		});
		// Change Password
		jQuery(document).ready(function () {
			jQuery("#change_password").click(function (e) {
				e.preventDefault();
				var current_password = jQuery("#current_password").val();
				var new_password = jQuery("#new_password").val();
				var confirm_password = jQuery("#confirm_password").val();
				if (!current_password) {
					jQuery("#changepasswordfeedback").css("background", "#ff5722db");
					jQuery("#changepasswordfeedback").css("display", "block");
					jQuery("#changePwdMsg").html('Current Password can not blank');
				}
				else if (!new_password) {
					jQuery("#changepasswordfeedback").css("background", "#ff5722db");
					jQuery("#changepasswordfeedback").css("display", "block");
					jQuery("#changePwdMsg").html('New Password can not blank');
				}
				else if (!confirm_password) {
					jQuery("#changepasswordfeedback").css("background", "#ff5722db");
					jQuery("#changepasswordfeedback").css("display", "block");
					jQuery("#changePwdMsg").html('Confirm Password can not blank');
				}
				else if (new_password != confirm_password) {
					jQuery("#changepasswordfeedback").css("background", "#ff5722db");
					jQuery("#changepasswordfeedback").css("display", "block");
					jQuery("#changePwdMsg").html("Password do not match");
				}
				else {
                                        jQuery(".ajaxloader").css("display", "block");
					jQuery("#changepasswordfeedback").css("display", "none");
					jQuery.ajax({
						type: 'POST'
						, url: ajaxurl
						, data: {
							action: 'changepasswords'
							, current_password: current_password
							, new_password: new_password
							, confirm_password: confirm_password
						}
						, success: function (msg) {
							if (msg == 1) {
								jQuery("#changepasswordfeedback").css("background", "#7ACF58");
								jQuery("#changepasswordfeedback").css("display", "block");
								jQuery("#changePwdMsg").html('Password change successfully');
								location.reload();
							}
							else if (msg == 2) {
								jQuery("#changepasswordfeedback").css("background", "#ff5722db");
								jQuery("#changepasswordfeedback").css("display", "block");
                                                                jQuery(".ajaxloader").css("display", "none");
								jQuery("#changePwdMsg").html('Current password not match');
							}
                                                        
						}
					});
				}
			});
		});
		// Change Password
		jQuery(document).ready(function () {
			jQuery("#hideme").click(function (e) {
				e.preventDefault();
				if (jQuery('#hide_in_members_yes').is(":checked")) {
					var hideme = '1';
				}
				else if (jQuery('#hide_in_members_no').is(":checked")) {
					var hideme = '2';
				}
				jQuery.ajax({
					type: 'POST'
					, url: ajaxurl
					, data: {
						action: 'hidemember'
						, hideme: hideme
					}
					, success: function (msg) {
						if (hideme == 1) {
							jQuery("#hidememberfeedback").css("display", "block");
							jQuery("#hidememberMsg").html('Hide profile successfully');
						}
						else if (hideme == 2) {
							jQuery("#hidememberfeedback").css("display", "block");
							jQuery("#hidememberMsg").html('Show profile successfully');
						}
					}
				});
			});
		});
	</script>