<?php


require( '../../../wp-load.php' );
global $wpdb;

$orderId = $_GET['order_id'];

?>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css"></script>
<script type="text/javascript" src="/kitchens2tables/wp-content/themes/porto-child/js/rating.js?ver=5.0.4"></script>

 <div class="modal-header">
          <button type="button" class="pum-close popmake-close" aria-label="Close">CLOSE </button>
          <h4 class="modal-title">Modal Header</h4>
        </div>
        <div class="modal-body">
          
<div class="row">
<div class="col-sm-12">
<form id="ratingForm" method="POST">
<div class="form-group">
<h4>Rate this product</h4>

<div class="container">	
    <div class="row lead">
        <div id="stars" class="starrr"></div>
         <input type='text' id="count" value='' name='star_rate'> </input> 
	</div>
    
</div>



<input type="hidden" class="form-control" id="Vendor" name="itemId" value="<?php echo $itemId; ?>">
<input type="hidden" class="form-control" id="User" name="UserId" value="<?php echo $userId; ?>">
<input type="hidden" class="form-control" id="Order" name="OrderId" value="<?php echo $orderId; ?>">


</div>
<div class="form-group">
<label for="usr">Title*</label>
<input type="text" class="form-control" id="title" name="title" required>
</div>
<div class="form-group">
<label for="comment">Comment*</label>
<textarea class="form-control" rows="5" id="comment" name="comment" required></textarea>
</div>
<div class="form-group">
<button type="submit" class="btn btn-info" id="saveReview">Save Review</button> <button type="button" class="btn btn-info" id="cancelReview">Cancel</button>
</div>
</form>
</div>
</div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>