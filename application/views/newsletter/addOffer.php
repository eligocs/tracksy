<link href="<?php echo base_url();?>site/assets/bootstrap-summernote/summernote.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url();?>site/assets/bootstrap-summernote/summernote.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>site/assets/js/components-editors.js" type="text/javascript"></script>
       
	<div class="page-content-wrapper">
		<div class="page-content">
			<div class="portlet box blue">
				<div class="portlet-title">
					<div class="caption"><i class="fa fa-newspaper-o" aria-hidden="true"></i>Create Text Template </div>
					<a class="btn btn-success pull-right" href="<?php echo site_url("newsletters/offers"); ?>" title="Back">Back</a>
				</div>
			</div>
	
			<div class="portlet-body">
				<form role="form" enctype="multipart/form-data" method="post" action="<?php echo base_url('newsletters/ajax_update_offer'); ?>" >
					 
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label">Offer Title 1</label>
								<input type="text" required name="title1" placeholder="Offer Title 1" class="form-control">
							</div>
						</div> 
					</div> <div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label">Offer Content 1</label>
								<textarea id="summernote_3"   name="content1"></textarea>
							</div>
						</div> 
					</div> 
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label">Offer Title 2</label>
								<input type="text" required name="title2" placeholder="Offer Title 2" class="form-control">
							</div>
						</div> 
					</div> 
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label">Offer Content 2</label>
								<textarea id="summernote_4"   name="content2"></textarea>
							</div>
						</div> 
					</div> 
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label">Offer Title 3</label>
								<input type="text" required name="title3" placeholder="Offer Title 3" class="form-control">
							</div>
						</div> 
					</div> 
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label">Offer Content 3</label>
								<textarea id="summernote_5"   name="content3"></textarea>
							</div>
						</div> 
					</div> 
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label">Offer Image</label>
								<input type="file" name="image" class="form-control">
							</div>
						</div> 
					</div> 
				</div>    
						
						
						
							<div class="margin-top-10">
								<input type="submit" value="Save Changes" class="btn green">
								<a href="<?php echo base_url('/newsletters/offers'); ?>" class="btn default">Cancel </a>
							</div>
						</form>
													<div id="res"></div>
	
					</div>
				</div>
			</div>

	</div>
		<!-- END CONTENT BODY -->
	</div>
	<!-- END CONTENT -->
 
<script type="text/javascript">
// Ajax a Account 
jQuery(document).ready(function($) {
	 var ajaxRstr;
	//$("#defalutTextTemplate").submit(function(e){
		$("#offer").validate({
			submitHandler: function(){
			var response = $("#res");
			var formData = $("#offer").serializeArray();
			console.log(formData);
			if (confirm("Are you sure to save changes ?")) {
				if (ajaxRstr) {
					ajaxRstr.abort();
				}
				ajaxRstr =	jQuery.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>" + "newsletters/ajax_update_offer",
					dataType: 'json',
					data: formData,
					beforeSend: function(){
						response.html('<p><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
					},
					success: function(res) {
						if (res.status == true){
							response.html('<div class="alert alert-success"><strong>Success! </strong>'+res.msg+'</div>');
							//console.log("done");
					window.location.href = '<?php echo base_url('newsletters/offers'); ?>';
						}else{
							response.html('<div class="alert alert-danger"><strong>Error! </strong>'+res.msg+'</div>');
							//console.log("error");
						}
					},
					error: function(){
						response.html('<div class="alert alert-danger"><strong>Error! </strong>Please Try again later! </div>');
					}
				});
			}	
		}	
		
	});	 
});	
</script>
