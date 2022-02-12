<div class="page-container">
	<div class="page-content-wrapper">
		<div class="page-content">
		<?php 
		
		$cat = $row[0]; 
		
		?>
			<div class="portlet box blue">
				<div class="portlet-title">
					<div class="caption"><i class="fa fa-users"></i>Edit Category</strong></div>
					<a class="btn btn-success" href="<?php echo site_url("marketing/viewcat"); ?>" title="Back">Back</a>
				</div>
			</div>
			
			<form role="form" id="editCat" enctype="multipart/form-data" method="post" >
			<div class="form-group">
				<label class="control-label">Category Name*</label>
				<input required type="text" name="category_name" placeholder="Category Name" class="form-control" value="<?php echo $cat->category_name;?>" /> 
			</div>
			
						
			<div class="margiv-top-10">
				<input type="hidden" name="cat_id" value="<?php echo $cat->id;?>"/>
				<button type="submit" class="btn green uppercase update_category">Update Category</button>
			</div>
		</form>
		<div id="resEd"></div>
		
	</div>
	<!-- END CONTENT BODY -->
<script type="text/javascript">
jQuery(document).ready(function($){
	var form = $("#editCat");
	var resp = $("#resEd");
	var ajaxReq;
	form.validate({
		rules: {
			category_name:{
				required: true
			},
		},
		submitHandler: function(form) {
			var formData = $("#editCat").serializeArray();
			if (ajaxReq) {
				ajaxReq.abort();
			}
				
			ajaxReq = jQuery.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>" + "AjaxRequest/ajax_edit_cat",
				dataType: 'json',
				data: formData,
				beforeSend: function(){
					resp.html('<p><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
				},
				success: function(res) {
					if (res.status == true){
						resp.html('<div class="alert alert-success"><strong>Success!</strong>'+res.msg+'</div>');
						//console.log("done");
						window.location.href = "<?php echo site_url("marketing/viewcat");?>";
					}else{
						resp.html('<div class="alert alert-danger"><strong>Error!</strong>'+res.msg+'</div>');
					//	console.log("error");
					}
				},
				error: function(){
						//console.log("error");
					//response.html('<div class="alert alert-danger"><strong>Error!</strong>Please Try again later! </div>');
				}
			});
			return false;
		}
	});	
});
</script>
