<?php $cat = $row[0]; ?>
		<div class="page-content-wrapper">
			<div class="page-content">
				<div class="portlet box blue">
					<div class="portlet-title">
						<div class="caption"><i class="fa fa-newspaper-o" aria-hidden="true"></i>Edit Package Category</div>
						<a class="btn btn-success pull-right" href="<?php echo site_url("packages/viewCategory"); ?>" title="Back">Back</a>
					</div>
				</div>
				<form id="editCat" method="post">
					
					<div class="portlet-body form">
						
							
						<div class="form-group">
							<label class="control-label">Package Category Name
								<span class="required"> * </span>
							</label>
							<input type="text" class="form-control" name="package_cat_name" value="<?php echo $cat->package_cat_name; ?>" placeholder="Category Name"/>
							
						</div>
						<div class="margiv-top-10">
							<button type="submit" id="SubmitForm" class="btn green uppercase update_category">Update Category</button>
						</div>
						
						<input id="package_id" type="hidden" name="cat_id" value="<?php echo $cat->p_cat_id; ?>">
						
					</div>
				</form>	
				<div id="res"></div>
			
 
	</div>
</div>

<script type="text/javascript">
	jQuery(document).ready(function($){
		//submit form
	$("#editCat").validate({
		submitHandler: function(){
			var formData = $('#editCat').serializeArray();
			var resp = $("#res");
			var ajaxReq;
			if (ajaxReq) {
				ajaxReq.abort();
			}
			ajaxReq = $.ajax({
				type: "POST",
				url: "<?php echo base_url('packages/ajax_edit_cat'); ?>",
			   data: formData,
			   dataType: "json",
				beforeSend: function(){
					resp.html('<p><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
				},
				success: function(res) {
					if (res.status == true){
						resp.html('<div class="alert alert-success"><strong>Success! </strong>'+res.msg+'</div>');
						//console.log("done");
						$('#editCat')[0].reset();
						//console.log(res.msg);
						window.location.href = "<?php echo site_url('packages/viewCategory');?>";
						
					}else{
						resp.html('<div class="alert alert-danger"><strong>Error! </strong>'+res.msg+'</div>');
						//console.log("error");
					}
				},
				error: function(e){
					console.log(e);
					resp.html('<div class="alert alert-danger"><strong>Error!</strong> Please Try again later! </div>');
				}
			});
		}	
		//add here some ajax code to submit your form or just call form.submit() if you want to submit the form without ajax
	});
});
</script>
