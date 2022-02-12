<link href="<?php echo base_url();?>site/assets/bootstrap-summernote/summernote.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url();?>site/assets/bootstrap-summernote/summernote.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>site/assets/js/components-editors.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>site/assets/form-repeater.min.js" type="text/javascript"></script>


	<div class="page-content-wrapper">
		<div class="page-content">
			<div class="portlet box blue">
				<div class="portlet-title">
					<div class="caption"><i class="fa fa-newspaper-o" aria-hidden="true"></i>Default Image Template </div>
					<a class="btn btn-success pull-right" href="<?php echo site_url("newsletters/templateList"); ?>" title="Back">Back</a>
				</div>
			</div>
	
								<div class="portlet-body">
                                       		<form method="post"  id="defalutTextTemplate" action="<?php echo base_url('newsletters/uploadImage'); ?>" enctype="multipart/form-data">
										<div class="row">
										<div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Upload Image</label>
                                                <input type="file" required id="file" name="file"  >
											</div>
										</div> 
									
										</div>		
										
											<div class="margin-top-10">
                                                <input type="submit" id="submit" value="Save Changes" class="btn green">
                                                <a href="javascript:;" class="btn default">Cancel </a>
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

<script>

/* 	$("#submit").submit(function(e){
	var img = $("#file").val();
	console.log(img);
		$.ajax({
			url: "<?php echo base_url('newsletters/uploadImage'); ?>",
			type: "POST",
			data: {"image":img},
			success: function (data) {
							if (res.status == true){
						response.html('<div class="alert alert-success"><strong>Success! </strong>'+res.msg+'</div>');
						//console.log("done");
						location.reload();
					}else{
						response.html('<div class="alert alert-danger"><strong>Error! </strong>'+res.msg+'</div>');
						//console.log("error");
					}
				},
				error: function(){
					response.html('<div class="alert alert-danger"><strong>Error! </strong>Please Try again later! </div>');
				}
			
		});
	}); */
</script>