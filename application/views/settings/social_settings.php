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
											<span class="caption-subject font-blue-madison bold uppercase">Social API settings</span>
										</div>
										<ul class="nav nav-tabs">
											<li class="active">
												<a href="#tab_1_1" data-toggle="tab">Facebook API Settings</a>
											</li>
											<li class="">
												<a href="#tab_1_2" data-toggle="tab">Twitter API Settings</a>
											</li>
										</ul>
									</div>
									<div class="portlet-body">
										<div class="tab-content">
											<!-- Facebook INFO TAB -->
											<div class="tab-pane active" id="tab_1_1">
												<form role="form" class="form-horizontal form-bordered" id="update_fb_settings">
												<p>Please enter auth details of <a target="_blank" href="https://developers.facebook.com/">Facebook</a> API.</p>
												<div class="col-md-9">
													<div class="form-group">
														<label class="control-label col-md-3">Facebook Page ID:</label>
														<div class="col-md-9">
															<input type="text" class="form-control" name="inp[fb_page_id]" value="<?php if($social_settings!= NULL){ echo $social_settings[0]->fb_page_id; }?>"/>
														</div>	
													</div>	
													<div class="form-group">
														<label class="control-label col-md-3">Facebook APP ID:</label>
														<div class="col-md-9">
															<input type="text" class="form-control" name="inp[fb_app_id]" value="<?php if($social_settings!= NULL){ echo $social_settings[0]->fb_app_id; }?>"/>
														</div>	
													</div>	
													<div class="form-group">
														<label class="control-label col-md-3">Facebook APP Secret:</label>
														<div class="col-md-9">
															<input type="text" class="form-control" name="inp[fb_app_secret]" value="<?php if($social_settings!= NULL){ echo $social_settings[0]->fb_app_secret; }?>"/>
														</div>	
													</div>	
													<div class="form-group">
														<label class="control-label col-md-3">Facebook Access Token:</label>
														<div class="col-md-9">
															<input type="text" class="form-control" name="inp[fb_access_token]" value="<?php if($social_settings!= NULL){ echo $social_settings[0]->fb_access_token; }?>"/>
														</div>	
													</div>	
													<hr>
													<div class="form-group">
														<div class="form-actions">
															<div class="row">
																<div class="col-md-offset-2 col-md-10">
																	<input type="hidden" name="inp[id]" value="<?php if($social_settings!= NULL){ echo $social_settings[0]->id; }?>"/>	
																	<input type="hidden" name="type" value="<?php if($social_settings!= NULL){ echo "Update"; } else { echo "Add";}?>"/>
																	<button type="submit" class="btn green">
																		<i class="fa fa-check"></i> Submit</button>
																
																</div>
															</div>
														</div>
													</div>
													</div>
												</form>
											</div>
											<!--Twitter API-->
											<div class="tab-pane" id="tab_1_2">
												<form role="form" class="form-horizontal form-bordered" id="update_twitter_settings">
												<p>Please enter auth details of <a target="_blank" href="https://dev.twitter.com/">Twitter</a> API.</p>
												<div class="col-md-9">
													<div class="form-group">
														<label class="control-label col-md-3">Twitter API Key:</label>
														<div class="col-md-9">
															<input type="text" class="form-control" name="inp[twitter_api_key]" value="<?php if($social_settings!= NULL){ echo $social_settings[0]->twitter_api_key; }?>"/>
														</div>	
													</div>	
													<div class="form-group">
														<label class="control-label col-md-3">Twitter API Secret:</label>
														<div class="col-md-9">
															<input type="text" class="form-control" name="inp[twitter_api_secret]" value="<?php if($social_settings!= NULL){ echo $social_settings[0]->twitter_api_secret; }?>"/>
														</div>	
													</div>	
													<div class="form-group">
														<label class="control-label col-md-3">Twitter Access Token:</label>
														<div class="col-md-9">
															<input type="text" class="form-control" name="inp[twitter_access_token]" value="<?php if($social_settings!= NULL){ echo $social_settings[0]->twitter_access_token; }?>"/>
														</div>	
													</div>	
													<div class="form-group">
														<label class="control-label col-md-3">Twitter Access Token Secret:</label>
														<div class="col-md-9">
															<input type="text" class="form-control" name="inp[twitter_access_token_secret]" value="<?php if($social_settings!= NULL){ echo $social_settings[0]->twitter_access_token_secret; }?>"/>
														</div>	
													</div>	
												
													<hr>
													<div class="form-group">
														<div class="form-actions">
															<div class="row">
																<div class="col-md-offset-2 col-md-10">
																	<input type="hidden" name="inp[id]" value="<?php if($social_settings!= NULL){ echo $social_settings[0]->id; }?>"/>	
																	<input type="hidden" name="type" value="<?php if($social_settings!= NULL){ echo "Update"; } else { echo "Add";}?>"/>
																	<button type="submit" class="btn green">
																		<i class="fa fa-check"></i> Submit</button>
																
																</div>
															</div>
														</div>
													</div>
													</div>
												</form>
												
											</div>
								<div class="clearfix"></div>
									<div id="res"></div>
										
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
	$("#update_fb_settings").validate({
		/* rules: {
			admin_email: {
				required: true,
			},
		}, */
		submitHandler: function(form) {
			var response = $("#res");
			var formData = $("#update_fb_settings").serializeArray();
			if (confirm("Are you sure to save changes ?")) {
				if (ajaxReq) {
					ajaxReq.abort();
				}
				ajaxReq = jQuery.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>" + "Settings/ajax_updatefbSettings",
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
	/* update twitter */
	$("#update_twitter_settings").validate({
		/* rules: {
			admin_email: {
				required: true,
			},
		}, */
		submitHandler: function(form) {
			var response = $("#res");
			var formData = $("#update_twitter_settings").serializeArray();
			if (confirm("Are you sure to save changes ?")) {
				if (ajaxReq) {
					ajaxReq.abort();
				}
				ajaxReq = jQuery.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>" + "Settings/ajax_updatetwitterSettings",
					dataType: 'json',
					data: formData,
					beforeSend: function(){
						response.show().html('<p><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
					},
					success: function(res) {
						if (res.status == true){
							response.html('<div class="alert alert-success"><strong>Success! </strong>'+res.msg+'</div>');
							//console.log("done");
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
		