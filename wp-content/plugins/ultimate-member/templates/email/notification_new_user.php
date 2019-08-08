<?php

$file_path=site_url().'/wp-content/uploads/2019/05/twitter.png';


?>
<!--<div style="max-width: 560px;padding: 20px;background: #ffffff;border-radius: 5px;margin:40px auto;font-family: Open Sans,Helvetica,Arial;font-size: 15px;color: #666;">

	<div style="color: #444444;font-weight: normal;">
		<div style="text-align: center;font-weight:600;font-size:26px;padding: 10px 0;border-bottom: solid 3px #eeeeee;">{site_name}</div>
		
		<div style="clear:both"></div>
	</div>
	
	<div style="padding: 0 30px 30px 30px;border-bottom: 3px solid #eeeeee;">

		<div style="padding: 30px 0;font-size: 24px;text-align: center;line-height: 40px;">{display_name} has just created an account on {site_name}.</span></div>

		<div style="padding: 10px 0 50px 0;text-align: center;">To view their profile click here: {user_profile_link}</div>
		
		<div style="padding: 0 0 15px 0;">
		
			<div style="background: #eee;color: #444;padding: 12px 15px; border-radius: 3px;font-weight: bold;font-size: 16px;">Here is the submitted registration form:<br /><br />
				{submitted_registration}
			</div>
		</div>
		
	</div>
	
	<div style="color: #999;padding: 20px 30px">
		
		<div style="">Thank you!</div>
		<div style="">The <a href="{site_url}" style="color: #3ba1da;text-decoration: none;">{site_name}</a> Team</div>
		
	</div>

</div>-->



<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="background: #f9f9f9;">


	<tbody>
		<tr>
			<td align="center" valign="middle" style="background:#e0e3eb;" height="230">
				<img style="display:block; line-height:0px; font-size:0px; border:0px;" src="<?php echo site_url().'/wp-content/uploads/2019/02/logo.png';?>" alt="logo"> 
			</td>
		</tr>



		<tr>
			<td align="center">
				<table width="600" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-left:20px; margin-right:20px;background: #ffffff;padding:30px 60px;border-left: 11px solid #f05120;min-height: 220px;margin-top: -50px">
					<tbody>
						<tr>
							<td style="font-family: Playfair Display;font-weight: 600;font-size: 30px;line-height: 50px;color: #333333;">{site_name},</td>
						</tr>

						<tr>
							<td style="font-family: lato;font-size: 16px;line-height: 24px;font-weight: 300;color: #333333;">
								{display_name} has just created an account on {site_name}.

							</td>
						</tr>

<tr>
							<td style="font-family: lato;font-size: 16px;line-height: 24px;font-weight: 300;color: #333333;">
								Here is the submitted registration form:<br /><br />
				{submitted_registration}

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
									<img  src="<?php echo $file_path;?>" alt="twitter">
								</a>
							</td>

							<td align="center" class="margin" width="30%" style="vertical-align: top;">
								<a href="#" target="_blank">
									<img src="<?php echo site_url().'/wp-content/uploads/2019/03/facebook.png';?>" alt="facebook">
								</a>
							</td>

							<td align="center" width="30%" style="vertical-align: top;">
								<a href="#" target="_blank">
									<img src="<?php echo site_url().'/wp-content/uploads/2019/03/instagram.png';?>" alt="instagram"> 
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
									<br> <span style="color: #333333">This email is intended for <span style="color: #e84b08">{admin_email}</span>. You are receiving this email because you have registered on  </span><a href="{site_url}" style="color: #e84b08"><strong>{site_name}</strong></a>.
								</p>
								<ul style="text-align: center;margin-top: 30px;padding-left: 0;">
									<li style="display: inline-block; padding: 0 15px;"><a style="color: #f05120; font-weight: bold;" href="<?php echo site_url().'/privacy-policy/'; ?>">Privacy Policy</a></li>
<li style="display: inline-block; padding: 0 15px;"><a style="color: #f05120; font-weight: bold;" href="<?php echo site_url().'/terms-and-conditions/'; ?>">Terms and Conditions</a></li>
<li style="display: inline-block; padding: 0 15px;"><a style="color: #f05120; font-weight: bold;" href="<?php echo site_url().'/give-feedback/'; ?>">Feedback</a></li>
								</ul>
								<p style="font-family: lato, sans-serif;text-align: center; margin-top: 35px; color: #333333; font-weight: 300; margin-bottom: 15px;">©2019 - KitchensToTables  |   All right reserved</p>
							</td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>



	</tbody>
</table>