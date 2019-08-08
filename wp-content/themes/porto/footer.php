<?php
global $porto_settings, $porto_layout;

$default_layout = porto_meta_default_layout();
$wrapper        = porto_get_wrapper_type();
?>
		<?php get_sidebar(); ?>

		<?php if ( porto_get_meta_value( 'footer', true ) ) : ?>

			<?php

			$cols = 0;
			for ( $i = 1; $i <= 4; $i++ ) {
				if ( is_active_sidebar( 'content-bottom-' . $i ) ) {
					$cols++;
				}
			}

			if ( is_404() ) {
				$cols = 0;
			}

			if ( $cols ) :
				?>
				<?php if ( 'boxed' == $wrapper || 'fullwidth' == $porto_layout || 'left-sidebar' == $porto_layout || 'right-sidebar' == $porto_layout ) : ?>
					<div class="container sidebar content-bottom-wrapper">
					<?php
				else :
					if ( 'fullwidth' == $default_layout || 'left-sidebar' == $default_layout || 'right-sidebar' == $default_layout ) :
						?>
					<div class="container sidebar content-bottom-wrapper">
					<?php else : ?>
					<div class="container-fluid sidebar content-bottom-wrapper">
						<?php
					endif;
				endif;
				?>

				<div class="row">

					<?php
					$col_class = array();
					switch ( $cols ) {
						case 1:
							$col_class[1] = 'col-md-12';
							break;
						case 2:
							$col_class[1] = 'col-md-12';
							$col_class[2] = 'col-md-12';
							break;
						case 3:
							$col_class[1] = 'col-lg-4';
							$col_class[2] = 'col-lg-4';
							$col_class[3] = 'col-lg-4';
							break;
						case 4:
							$col_class[1] = 'col-lg-3';
							$col_class[2] = 'col-lg-3';
							$col_class[3] = 'col-lg-3';
							$col_class[4] = 'col-lg-3';
							break;
					}
					?>
						<?php
						$cols = 1;
						for ( $i = 1; $i <= 4; $i++ ) {
							if ( is_active_sidebar( 'content-bottom-' . $i ) ) {
								?>
								<div class="<?php echo esc_attr( $col_class[ $cols++ ] ); ?>">
									<?php dynamic_sidebar( 'content-bottom-' . $i ); ?>
								</div>
								<?php
							}
						}
						?>

					</div>
				</div>
			<?php endif; ?>

			</div><!-- end main -->

			<?php
			do_action( 'porto_after_main' );
			$footer_view = porto_get_meta_value( 'footer_view' );
			?>

			<div class="footer-wrapper<?php echo 'wide' == $porto_settings['footer-wrapper'] ? ' wide' : ''; ?> <?php echo esc_attr( $footer_view ); ?>">

				<?php if ( porto_get_wrapper_type() != 'boxed' && 'boxed' == $porto_settings['footer-wrapper'] ) : ?>
				<div id="footer-boxed">
				<?php endif; ?>

				<?php if ( is_active_sidebar( 'footer-top' ) && ! $footer_view ) : ?>
					<div class="footer-top">
						<div class="container">
							<?php dynamic_sidebar( 'footer-top' ); ?>
						</div>
					</div>
				<?php endif; ?>

				<?php
					get_template_part( 'footer/footer' );
				?>

				<?php if ( porto_get_wrapper_type() != 'boxed' && 'boxed' == $porto_settings['footer-wrapper'] ) : ?>
				</div>
				<?php endif; ?>

			</div>

		<?php else : ?>

			</div><!-- end main -->

			<?php
			do_action( 'porto_after_main' );
		endif;
		?>

	</div><!-- end wrapper -->
	<?php do_action( 'porto_after_wrapper' ); ?>

<?php

if ( isset( $porto_settings['mobile-panel-type'] ) && 'side' === $porto_settings['mobile-panel-type'] ) {
	// navigation panel
	get_template_part( 'panel' );
}

?>

<!--[if lt IE 9]>
<script src="<?php echo esc_url( porto_js ); ?>/libs/html5shiv.min.js"></script>
<script src="<?php echo esc_url( porto_js ); ?>/libs/respond.min.js"></script>
<![endif]-->

<?php wp_footer(); ?>

<?php
// js code (Theme Settings/General)
if ( isset( $porto_settings['js-code'] ) && $porto_settings['js-code'] ) {
	?>
	<script>
	    
	// new code added by Girish
		jQuery(document).ready(function(){
		    setTimeout(function() {
		        jQuery("#user_email-2709").val("");
		        jQuery("#user_password-2709").val("");
		        
		        jQuery("#user_email-2695").val("");
		        jQuery("#user_password-2695").val("");
		    },2000);
        
            jQuery('.um-field-label > label').after('<span class="required">*</span>' );
            
           jQuery('.um-2709 .um-col-alt').after('<a class="orange-link" href="http://lsc1.acapqa.net/kitchens2tables/my-account/">Already a Customer?</a>' );
           
        jQuery("#first_name-2709, #last_name-2709, #user_email-2709, #user_password-2709, #confirm_user_password-2709").keyup(function(){
          jQuery(".um-field-area span").remove();
          
        });
        
           
    jQuery('#pum-2683 .register-btn').on('click', DoPrevent);
    jQuery("#pum-2683 .register-btn").click(function(e){
    
     	 var fname =  jQuery('#first_name-2709').val();
     	 var lname =  jQuery('#last_name-2709').val();
     	 var email =  jQuery('#user_email-2709').val();
     	 var pass =  jQuery('#user_password-2709').val();
     	 var cpass =  jQuery('#confirm_user_password-2709').val();
        
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
     	
           
           if(fname =='' || lname =='' || email =='' || pass =='' || cpass ==''){
               jQuery(".um-field-area span").remove();

               if(fname == ''){
                   jQuery('#first_name-2709').after("<span class='error-msg'>Please fill out First Name</span>");
               }
               if(lname == ''){
                   jQuery('#last_name-2709').after("<span class='error-msg'>Please fill out Last Name</span>");
               }
               if(email == ''){
                   jQuery('#user_email-2709').after("<span class='error-msg'>Please fill out Email</span>");
               }else if(regex.test(email) != true){
                   jQuery(".um-field-area span").remove();
                   jQuery('#user_email-2709').after("<span class='error-msg'>Email is not valid</span>");
                }
               if(pass == ''){
                   jQuery('#user_password-2709').after("<span class='error-msg'>Please fill out Password</span>");
               }
               if(cpass == ''){
                   jQuery('#confirm_user_password-2709').after("<span class='error-msg'>Please fill out Confirm Password</span>");
               }
               if(pass != cpass){
                   jQuery(".um-field-area span").remove();
                   jQuery('#confirm_user_password-2709').after("<span class='error-msg'>Password not matched</span>");
               }

           }
           else if(regex.test(email) != true){
               jQuery(".um-field-area span").remove();
               jQuery('#user_email-2709').after("<span class='error-msg'>Email is not valid</span>");

           }
           else if(pass != cpass){
               jQuery(".um-field-area span").remove();
               jQuery('#confirm_user_password-2709').after("<span class='error-msg'>Password not matched</span>");

           }
            else{
               jQuery('#pum-2683 .register-btn').off('click', DoPrevent);
        	   jQuery(this).closest('form').submit();
       		   
            }
     	
     	
    });
    
    jQuery("#first_name-2695, #last_name-2695, #user_email-2695, #user_password-2695, #confirm_user_password-2695, #Address_Line_1, #Address_Line_2, #City-2695, #States-2695, #Zip-2695, #License_Info-2695").keyup(function(){
          jQuery(".um-field-error, .error-msg").hide();
          
    });
    
    jQuery('#pum-2680 .register-btn').on('click', DoPrevent);
    jQuery("#pum-2680 .register-btn").click(function(e){
        var fname =  jQuery('#first_name-2695').val();
     	var lname =  jQuery('#last_name-2695').val();
     	var email =  jQuery('#user_email-2695').val();
     	var pass =  jQuery('#user_password-2695').val();
     	var cpass =  jQuery('#confirm_user_password-2695').val();
     	var address_1 =  jQuery('#Address_Line_1').val();
     	var address_2 =  jQuery('#Address_Line_2').val();
     	var city =  jQuery('#City-2695').val();
     	var state =  jQuery('#States-2695').val();
     	var zip =  jQuery('#Zip-2695').val();
     	var licese_info =  jQuery('#License_Info-2695').val();
     	var cuisine =  jQuery('#cusine').val();
     	var price_test =  jQuery('#PRICE_TEST').val();
     	
     	var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
     	
     	if(fname =='' || lname =='' || email =='' || pass =='' || cpass =='' || address_1=='' || address_2=='' || city=='' || state=='' || zip=='' || licese_info ==''){
     	    jQuery(".um-field-error, .error-msg").remove();
     	    
     	    if(fname ==''){
     	        jQuery('#first_name-2695').after("<span class='error-msg'>Please fill out First Name</span>");
     	    }
     	    if(lname ==''){
     	        jQuery('#last_name-2695').after("<span class='error-msg'>Please fill out Last Name</span>");
     	    }
     	    if(email ==''){
     	        jQuery('#user_email-2695').after("<span class='error-msg'>Please fill out Email Id</span>");
     	    }else if(regex.test(email) != true){
     	        jQuery(".um-field-error, .error-msg").remove();
     	        jQuery('#user_email-2695').after("<span class='error-msg'>Email Id is not valid</span>");
     	    }
     	    if(pass ==''){
     	        jQuery('#user_password-2695').after("<span class='error-msg'>Please fill out Password</span>");
     	    }
     	    if(cpass ==''){
     	        jQuery('#confirm_user_password-2695').after("<span class='error-msg'>Please fill out Confirm Password</span>");
     	    }
     	    if(pass != cpass){
     	        jQuery(".um-field-error, .error-msg").remove();
     	        jQuery('#confirm_user_password-2695').after("<span class='error-msg'>Password not matched</span>");
     	    }
     	    if(address_1 ==''){
     	        jQuery('#Address_Line_1').after("<span class='error-msg'>Please fill out Address Line 1</span>");
     	    }
     	    if(address_2 ==''){
     	        jQuery('#Address_Line_2').after("<span class='error-msg'>Please fill out Address Line 2</span>");
     	    }
     	    if(city ==''){
     	        jQuery('#City-2695').after("<span class='error-msg'>Please fill out City</span>");
     	    }
     	    if(state ==''){
     	        jQuery('#States-2695').after("<span class='error-msg'>Please fill out State</span>");
     	    }
     	    if(zip ==''){
     	        jQuery('#Zip-2695').after("<span class='error-msg'>Please fill out Zip Code</span>");
     	    }
     	    if(licese_info ==''){
     	        jQuery('#License_Info-2695').after("<span class='error-msg'>Please fill out License Number</span>");
     	    }
     	    
     	   
     	}else if(regex.test(email) != true){
     	    jQuery(".um-field-error, .error-msg").remove();
     	    jQuery('#user_email-2695').after("<span class='error-msg'>Email Id is not valid</span>");
     	}else if(pass != cpass){
 	        jQuery(".um-field-error, .error-msg").remove();
 	        jQuery('#confirm_user_password-2695').after("<span class='error-msg'>Password not matched</span>");
     	}else{
           jQuery('#pum-2680 .register-btn').off('click', DoPrevent);
    	   jQuery(this).closest('form').submit();
       		   
        }
     	
     	
    });
    
    function DoPrevent(e) {
      e.preventDefault();
      e.stopPropagation();
    }
    
    

});
        //end of new code added by Girish
           
		<?php echo porto_filter_output( $porto_settings['js-code'] ); ?>
	
	</script>
<?php } ?>
<?php if ( isset( $porto_settings['page-share-pos'] ) && $porto_settings['page-share-pos'] ) : ?>
	<div class="page-share position-<?php echo esc_attr( $porto_settings['page-share-pos'] ); ?>">
		<?php get_template_part( 'share' ); ?>
	</div>
<?php endif; ?>
</body>
</html>
