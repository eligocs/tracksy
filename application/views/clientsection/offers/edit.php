<?php if( isset( $offer_data ) && !empty( $offer_data ) ){ ?>
<?php $offer = $offer_data[0]; ?>
<div class="page-container">
	<div class="page-content-wrapper">
		<div class="page-content">
			<div class="portlet box blue">
				<div class="portlet-title">
					<div class="caption">
						<i class="icon-plus"></i>Edit Offer
					</div>
					<a class="btn btn-success" href="<?php echo site_url("clientsection/offers"); ?>" title="Back">Back</a>
				</div>
			</div>	
			<div class="portlet-body">
			<form role="form" id="editOfferFrm">
			<div class="row">
				<div class="col-md-4">
				<div class="form-group">
					<label class="control-label">Title*</label>
					<input type="text" required placeholder="eg: Coupon Title" name="inp[title]" class="form-control" value="<?php echo isset($offer->title) ? $offer->title : "";  ?>"/> 
				</div>
				</div>
				<div class="col-md-4">
				<div class="form-group">
					<label class="control-label">Description*</label>
					<textarea required placeholder="offer description" name="inp[description]" class="description form-control"><?php echo isset($offer->description) ? $offer->description : "";  ?></textarea> 
				</div>
				</div>
				<div class="col-md-4">
				<div class="form-group">
					<label class="control-label">Offer Type*</label>
					<input type="text" required placeholder="eg: Weekend,diwali etc" name="inp[offer_type]" class="form-control" value="<?php echo isset($offer->offer_type) ? $offer->offer_type : "";  ?>"/> 
				</div>
				</div>
				<div class="clearfix"></div>
				<div class="col-md-4">
				<div class="form-group">
					<label class="control-label">Coupon Code*</label>
					<input type="text" required placeholder="eg: DIWALI20" onkeydown="upperCaseF(this)" maxlength="20" name="inp[coupon_code]" class="form-control" value="<?php echo isset($offer->coupon_code) ? $offer->coupon_code : "";  ?>"/> 
				</div>
				</div>
				<div class="col-md-4">
				<div class="form-group">
					<label class="control-label">Terms & Conditions*</label>
					<textarea required placeholder="Terms and Conditions.." name="inp[term_and_conditions]" class="form-control"><?php echo isset($offer->term_and_conditions) ? $offer->term_and_conditions : "";  ?></textarea> 
				</div>
				</div>
				<div class="col-md-4">
				<div class="form-group">
					<label class="control-label">Enable Coupon For Client</label>
					
					<select class="form-control" name="inp[offer_status]">
						<option value="">Select option</option>
						<option <?php isset($offer->offer_status) && $offer->offer_status == 1 ? "selected='selected'" : "";  ?>value="1">Enable</option>
						<option <?php isset($offer->offer_status) && $offer->offer_status == 0 ? "selected='selected'" : "";  ?>value="0">Enable Later</option>
					</select>
				</div>
				</div>
			</div>
			<hr>
			<div class="col-md-10">
			<div class="margiv-top-10">
				<input type="hidden" name="offer_id" id="offer_id" value="<?php if(isset( $offer->id ) ){ echo $offer->id; } ?>"/> 
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
	var form = $("#editOfferFrm");
	var resp = $("#addresEd"),ajaxReq;
	var offer_id = $("#offer_id").val();
	$("#editOfferFrm").validate({
		submitHandler: function(form) {
			var formData = $("#editOfferFrm").serializeArray();
			//console.log(formData);
			if (ajaxReq) {
				ajaxReq.abort();
			}
			ajaxReq = $.ajax({
				type: "POST",
				url: "<?php echo base_url('clientsection/ajax_edit_offer'); ?>" ,
				dataType: 'json',
				data: formData,
				beforeSend: function(){
					resp.html('<p><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
				},
				success: function(res) {
					if (res.status == true){
						resp.html('<div class="alert alert-success"><strong>Success! </strong>'+res.msg+'</div>');
						//console.log("done");
						$("#editOfferFrm")[0].reset();
						window.location.href = "<?php echo site_url("clientsection/offer_view/");?>" + offer_id; 
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

	function upperCaseF(a){
		setTimeout(function(){
			a.value = a.value.toUpperCase();
		}, 1);
	}

</script>
