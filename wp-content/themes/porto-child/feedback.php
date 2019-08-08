<?php /*
 Template Name: feedback
 */
?>
<?php echo get_header();

global $current_user;




?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css"></script>

 
<div class="row">
<div class="col-sm-12">
<form id="ratingForm" method="POST">

<div class="alert alert-success alert-dismissible" style='display:none;' id='success_message'>
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Thank You !</strong>  For Your Feedback.
</div>


<div class="form-group">
<label for="usr">Name*</label>
<input type="text" class="form-control" id="name" name="name" value="<?php echo get_user_meta($current_user->ID, 'first_name', true).' '.get_user_meta($current_user->ID, 'last_name', true); ?>" required>
</div>

<div class="form-group">
<label for="usr">Email*</label>
<input type="email" class="form-control" id="email" name="email" value="<?php echo $current_user->user_email; ?>" required>
</div>


<div class="form-group">
<label for="comment">Comment</label>
<textarea class="form-control" rows="5" id="comment" name="comment" ></textarea>
</div>
<div class="form-group">
<button type="submit" class="btn cm-orange-btn" id="saveReview">Save Feedback</button>
 <a href="<?php echo site_url(); ?>"><button type="button" class="btn  cm-default-btn" id="cancelReview">Cancel</button>
</a>
</div>
</form>
</div>
</div>
<script>

jQuery(document).ready(function () {
jQuery('#ratingForm').on('submit', function(event){
event.preventDefault();
var name = jQuery("#name").val(); 
var email = jQuery("#email").val(); 

var comment = jQuery("#comment").val(); 
 

jQuery.ajax({
type : 'POST',
  url: "<?php echo site_url('/wp-admin/admin-ajax.php'); ?>", 
data: {
            'action':'folder_contents_data',
            'name' : name,
            'email' : email,
            
            'comment' : comment
        },



success:function(response){ 

	
	  jQuery("#success_message").css({"display":"block"});
	  jQuery("#ratingForm")[0].reset();




}
});
});
});
</script>

 <?php echo get_footer(); ?>
 
 
 