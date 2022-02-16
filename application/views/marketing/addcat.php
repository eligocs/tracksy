<div class="page-container">
	<div class="page-content-wrapper">
		<div class="page-content">
			<form role="form" id="addCat" method="post">
			<div class="portlet box blue">
			<div class="portlet-title">
					<div class="caption"><i class="fa fa-user"></i>Add Category</div>
					<a class="btn btn-success" href="<?php echo site_url("marketing/viewcat"); ?>" title="Back">Back</a>
				</div>
			</div>
			<div class="portlet-body custom_card">
				<div class="form-group col-md-4">
					<label class="control-label">Category Name*</label>
					<input  required type="text" name="category_name" placeholder="Category Name" class="form-control" value="" /> </div>
				
				<div class="clearfix margiv-top-10">
					<!--input type="hidden" name="added_by" value="<?php //echo $user_id; ?>"-->
					<button type="submit" class="btn green uppercase add_agent">Add Category</button>
				</div>
			</form>
				<div class="clearfix"></div>
			</div><!-- portlet body -->
			</div> <!-- portlet -->
			
			<div id="addresEd"></div>		
		</div>
	<!-- END CONTENT BODY -->
	</div>
<!-- Modal -->
 </div>
<script type="text/javascript">
jQuery(document).ready(function($){
	var form = $("#addCat");
	var ajaxReq;
	$("#addCat").validate({
		rules: {
			category_name: {
			  required: true,
			},

		},
		submitHandler: function(form) {
			var resp = $("#addresEd");
			var formData = $("#addCat").serializeArray();
			//console.log(formData);
			if (ajaxReq) {
					ajaxReq.abort();
				}
				ajaxReq = $.ajax({
				type: "POST",
				url: "<?php echo base_url('AjaxRequest/ajaxAddCat'); ?>" ,
				dataType: 'json',
				data: formData,
				beforeSend: function(){
					resp.html('<p><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
				},
				success: function(res) {
					if (res.status == true){
						resp.html('<div class="alert alert-success"><strong>Success! </strong>'+res.msg+'</div>');
						//console.log("done");
						 $("#addCat")[0].reset();
						window.location.href = "<?php echo site_url("marketing/viewcat");?>"; 
					}else{
						resp.html('<div class="alert alert-danger"><strong>Error! </strong>'+res.msg+'</div>');
						console.log("error");
					}
				},
				error: function(e){
						console.log(e);
					//response.html('<div class="alert alert-danger"><strong>Error!</strong>Please Try again later! </div>');
				}
			});
			return false;
		}
	});	
}); 
</script>
