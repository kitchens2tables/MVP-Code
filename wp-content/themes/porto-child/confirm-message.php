
<?php 
/*
* 
*Template Name: Confirm Message
*
*/



global $Wcmp,$wpdb;


if( !session_id())
        session_start();

$userID = $_SESSION['user_id_for_confirmation'];

$account_status = get_user_meta($userID,'account_status',true) ;






if(!in_array($account_status, array('awaiting_admin_review','checkmail','pending','awaiting_email_confirmation')) || is_user_logged_in())
{
    wp_redirect(SITE_URL());
}

$user_meta=get_userdata($userID); 
$user_roles=$user_meta->roles[0];
$firstname=get_user_meta($userID,'first_name',true);
       
get_header(); 
?>
<style>
.footer-top {
    display: none;
}

#footer:before {
    content: none;
}

div#footer {
    background: #374977 !important;
}

div#footer * {
    color: #fff !important;
}

#footer #menu-footer-bottom-menu li a {
    color: #fff !important;
}
</style>

<p>Hello <?php echo $firstname; ?>,</p>

<?php if($user_roles=='customer') { ?>
    <p> Thank you for registering. Before you can <g class="gr_ gr_5 gr-alert gr_spell gr_inline_cards gr_run_anim ContextualSpelling multiReplace" id="5" data-gr-id="5">login</g> we need you to activate your account by clicking the activation link in the email we just sent you. </p>
<?php } elseif($user_roles=='dc_vendor') { ?>
    <p>Welcome to Kitchens2Tables. We are glad to see you embark on this new journey in the culinary world. Our Kitchens2Tables team is working on setting you up and will reach out to you in the next 24 hours for next steps. You can choose to look around until then!!</p>
<?php } else { ?>
    <p> Welcome to Kitchens2Tables
<?php } ?>
<p>Cheers,<br>Kitchens2Tables</p>

    
<?php get_footer(); ?>