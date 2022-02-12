<?php if( isset( $review_data ) && !empty( $review_data ) ){ ?>
<?php $review = $review_data[0]; ?>
<div class="page-container">
	<div class="page-content-wrapper">
		<div class="page-content">
			<div class="portlet box blue">
				<div class="portlet-title">
					<div class="caption">
						<i class="icon-plus"></i>Edit Review
					</div>
					<a class="btn btn-success" href="<?php echo site_url("clientsection/reviews"); ?>" title="Back">Back</a>
				</div>
			</div>	
			<div class="portlet-body">
			<form role="form" id="editReview">
			<div class="row">
				<div class="col-md-4">
				<div class="form-group">
					<label class="control-label">Client Name*</label>
					<input type="text" required placeholder="eg: Mr. Naveen Sharma" name="inp[client_name]" class="form-control" value="<?php if(isset( $review->client_name ) ){ echo $review->client_name; } ?>"/> 
				</div>
				</div>
				<div class="col-md-4">
				<div class="form-group">
					<label class="control-label">Client Contact*</label>
					<input type="number" required placeholder="eg: 989898989" name="inp[client_contact]" class="form-control" value="<?php if(isset( $review->client_contact ) ){ echo $review->client_contact; } ?>"/> 
				</div>
				</div>
				<div class="col-md-4">
				<div class="form-group">
					<label class="control-label">Package Name*</label>
					<input type="text" required placeholder="eg: Shimla Manali" name="inp[package_name]" class="form-control" value="<?php if(isset( $review->package_name ) ){ echo $review->package_name; } ?>"/> 
				</div>
				</div>
				<div class="col-md-6">
				<div class="form-group">
					<label class="control-label">Feedback*</label>
					<textarea required placeholder="Client review" name="inp[feedback]" class="form-control"><?php if(isset( $review->feedback ) ){ echo $review->feedback; } ?></textarea> 
				</div>
				</div>
				
				<div class="col-md-6">
				<div class="form-group">
					<label class="control-label">Client Rating*</label>
					<div class="star-rating">
					  <fieldset>
						<input type="radio" required id="star5" name="inp[rating]" <?php if(isset( $review->rating ) && $review->rating == 5 ){ echo "checked"; } ?> value="5" /><label for="star5" title="Outstanding">5 stars</label>
						<input type="radio" required id="star4" <?php if(isset( $review->rating ) && $review->rating == 4 ){ echo "checked"; } ?> name="inp[rating]" value="4" /><label for="star4" title="Very Good">4 stars</label>
						<input type="radio" required id="star3" name="inp[rating]" <?php if(isset( $review->rating ) && $review->rating == 3 ){ echo "checked"; } ?> value="3" /><label for="star3" title="Good">3 stars</label>
						<input type="radio" required id="star2" name="inp[rating]" <?php if(isset( $review->rating ) && $review->rating == 2 ){ echo "checked"; } ?> value="2" /><label for="star2" title="Poor">2 stars</label>
						<input type="radio" required id="star1" name="inp[rating]" <?php if(isset( $review->rating ) && $review->rating == 1 ){ echo "checked"; } ?> value="1" /><label for="star1" title="Very Poor">1 star</label>
					  </fieldset>
					</div>
				</div>
				</div>
			</div>
			<hr>
			<div class="col-md-10">
			<div class="margiv-top-10">
				<input type="hidden" name="inp[agent_id]" value="<?php if(isset( $review->agent_id ) ){ echo $review->agent_id; } ?>"/> 
				<input type="hidden" name="review_id" id="rev_id" value="<?php if(isset( $review->id ) ){ echo $review->id; } ?>"/> 
				<button type="submit" class="btn green uppercase add_vehicle">Update Review</button>
			</div>
			</div>
			</form>
			<div class="clearfix"></div>
			<div id="addresEd"></div>		
			</div><!-- portlet body -->
			</div> <!-- portlet -->
		</div>
	<!-- END CONTENT BODY -->
	</div>
<?php }else{
	redirect("404");
} ?>
<script type="text/javascript">
jQuery(document).ready(function($){
	var form = $("#editReview");
	var rev_id = $("#rev_id").val();
	var resp = $("#addresEd"),ajaxReq;
	$("#editReview").validate({
		submitHandler: function(form) {
			var formData = $("#editReview").serializeArray();
			//console.log(formData);
			if (ajaxReq) {
				ajaxReq.abort();
			}
			ajaxReq = $.ajax({
				type: "POST",
				url: "<?php echo base_url('clientsection/ajax_edit_review'); ?>" ,
				dataType: 'json',
				data: formData,
				beforeSend: function(){
					resp.html('<p><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
				},
				success: function(res) {
					if (res.status == true){
						resp.html('<div class="alert alert-success"><strong>Success! </strong>'+res.msg+'</div>');
						//console.log("done");
						$("#editReview")[0].reset();
						window.location.href = "<?php echo site_url("clientsection/review_view/");?>" + rev_id; 
					}else{
						resp.html('<div class="alert alert-danger"><strong>Error! </strong>'+res.msg+'</div>');
						//console.log("error");
					}
				},
				error: function(e){
						//console.log(e);
					resp.html('<div class="alert alert-danger"><strong>Error!</strong>Please Try again later! </div>');
				}
			});
			return false;
		}
	});	
}); 
</script>
