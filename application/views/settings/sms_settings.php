<div class="page-container">
	<div class="page-content-wrapper">
		<div class="page-content">
			<div class="row">
				<div class="col-md-12">
					<div class="profile-content">
						<div class="row">
							<div class="col-md-12">
								<div class="portlet light ">
									<div class="portlet-title tabbable-line">
										<div class="caption caption-md">
											<i class="icon-globe theme-font hide"></i>
											<span class="caption-subject font-blue-madison bold uppercase">Sms settings</span>
										</div>
										<ul class="nav nav-tabs">
											<li class="active">
												<a href="#tab_1_1" data-toggle="tab">Sms Settings</a>
											</li>
										</ul>
									</div>
									<div class="portlet-body">
										<div class="tab-content">
											<!-- PERSONAL INFO TAB -->
											<div class="tab-pane active" id="tab_1_1">
												<form role="form" class="form-horizontal form-bordered" id="update_sms_settings">
												<p>Please enter auth details of <a target="_blank" href="https://control.msg91.com/">msg91</a> api.</p>
												<div class="col-md-9">
													<div class="form-group">
														<label class="control-label col-md-3">Auth Key:</label>
														<div class="col-md-9">
															<input type="text" class="form-control" name="auth_key" value="<?php if($sms_settings!= NULL){ echo $sms_settings[0]->auth_key; }?>"/>
														</div>	
													</div>	
													<div class="form-group">
														<label class="control-label col-md-3">Sender Id:</label>
														<div class="col-md-9">
															<input type="text" class="form-control" name="sender_id" value="<?php if($sms_settings!= NULL){ echo $sms_settings[0]->sender_id; }?>"/>
														</div>	
													</div>	
													<hr>
													<div class="form-group">
														<div class="form-actions">
															<div class="row">
																<div class="col-md-offset-2 col-md-10">
																	<input type="hidden" name="id" value="<?php if($sms_settings!= NULL){ echo $sms_settings[0]->id; }?>"/>	
																	<input type="hidden" name="type" value="<?php if($sms_settings!= NULL){ echo "Update"; } else { echo "Add";}?>"/>
																	<button type="submit" class="btn green">
																		<i class="fa fa-check"></i> Submit</button>
																</div>
															</div>
														</div>
													</div>
													</div>
												</form>
												<div class="clearfix"></div>
												<div id="res"></div>
											</div>
										
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- END PROFILE CONTENT -->
				</div>
			</div>
		</div>
		<!-- END CONTENT BODY -->
	</div>
	<!-- END CONTENT -->

</div>


<script type="text/javascript">

// Ajax Update Settings 
jQuery(document).ready(function($) {
	var ajaxReq;
	$("#update_sms_settings").validate({
		/* rules: {
			admin_email: {
				required: true,
			},
		}, */
		submitHandler: function(form) {
			var response = $("#res");
			var formData = $("#update_sms_settings").serializeArray();
			if (confirm("Are you sure to save changes ?")) {
				if (ajaxReq) {
					ajaxReq.abort();
				}
				ajaxReq = jQuery.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>" + "Settings/ajax_updateSmsSettings",
					dataType: 'json',
					data: formData,
					beforeSend: function(){
						response.show().html('<p><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
					},
					success: function(res) {
						if (res.status == true){
							response.html('<div class="alert alert-success"><strong>Success! </strong>'+res.msg+'</div>');
							//console.log("done");
							//location.reload();
							setTimeout(function() { response.fadeOut('fast'); }, 2000); // <-- time in milliseconds
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
		