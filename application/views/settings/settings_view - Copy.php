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
											<span class="caption-subject font-blue-madison bold uppercase">General settings</span>
										</div>
										<ul class="nav nav-tabs">
											<li class="active">
												<a href="#tab_1_1" data-toggle="tab">General Settings</a>
											</li>
										</ul>
									</div>
									<div class="portlet-body">
										<div class="tab-content">
											<!-- PERSONAL INFO TAB -->
											<div class="tab-pane active" id="tab_1_1">
												<form role="form" class="form-horizontal form-bordered" id="updateGeneralSettings">
												<div class="col-md-9">
													<div class="form-group">
														<label class="control-label col-md-3">Site Title:</label>
														<div class="col-md-9">
															<input type="text" class="form-control" name="inp[site_title]" value="<?php if($settings!= NULL){ echo $settings[0]->site_title; }?>"/>
														</div>	
													</div>	
													<div class="form-group">
														<label class="control-label col-md-3">Admin Email*:</label>
														<div class="col-md-9">
															<input type="email" class="form-control" name="inp[admin_email]" value="<?php if($settings!= NULL){ echo $settings[0]->admin_email; }?>"/>
														</div>	
													</div>	
													<div class="form-group">
														<label class="control-label col-md-3">Manager Email:</label>
														<div class="col-md-9">
															<input type="email" class="form-control" name="inp[manager_email]" value="<?php if($settings!= NULL){ echo $settings[0]->manager_email; }?>"/>
														</div>	
													</div>	
													<hr>
													<h4>Sales Team Details: </h4>
													<div class="form-group">
														<label class="control-label col-md-3">Name:</label>
														<div class="col-md-9">
															<input type="text" placeholder="Sales team person name. Eg: Mukesh Chauhan" class="form-control" name="inp[sales_team_name]" value="<?php if($settings!= NULL){ echo $settings[0]->sales_team_name; }?>"/>
														</div>	
													</div>	
													<div class="form-group">
														<label class="control-label col-md-3">Sales Team Contact:</label>
														<div class="col-md-9">
															<input type="text" placeholder="Sales team contact. Eg: 88888888,999999999" class="form-control" name="inp[sales_team_contact]" value="<?php if($settings!= NULL){ echo $settings[0]->sales_team_contact; }?>"/>
														</div>	
													</div>	
													<div class="form-group">
														<label class="control-label col-md-3">Sales Team Email:</label>
														<div class="col-md-9">
															<input type="email" class="form-control" name="inp[sales_email]" value="<?php if($settings!= NULL){ echo $settings[0]->sales_email; }?>"/>
														</div>	
													</div>	
													<hr>
													<h4>Hotel Booking Team Details: </h4>
													<div class="form-group">
														<label class="control-label col-md-3">Name:</label>
														<div class="col-md-9">
															<input type="text" class="form-control"  placeholder="Hotel team name. Eg: Sakshi Negi"  name="inp[hotel_team_name]" value="<?php if($settings!= NULL){ echo $settings[0]->hotel_team_name; }?>"/>
														</div>	
													</div>	
													<div class="form-group">
														<label class="control-label col-md-3">Contact:</label>
														<div class="col-md-9">
															<input type="text" placeholder="Hotel team contact. Eg: 88888888,999999999" class="form-control" name="inp[hotel_team_contact]" value="<?php if($settings!= NULL){ echo $settings[0]->hotel_team_contact; }?>"/>
														</div>	
													</div>
													<div class="form-group">
														<label class="control-label col-md-3">Hotel Team Email:</label>
														<div class="col-md-9">
															<input type="email" class="form-control" name="inp[hotel_email]" value="<?php if($settings!= NULL){ echo $settings[0]->hotel_email; }?>"/>
														</div>	
													</div>	
													<hr>
													<h4>Vehicle Booking Team Details: </h4>
													<div class="form-group">
														<label class="control-label col-md-3">Name:</label>
														<div class="col-md-9">
															<input type="text" class="form-control" placeholder="Vehicle booking team name. Eg: Ravi " name="inp[vehicle_team_name]" value="<?php if($settings!= NULL){ echo $settings[0]->vehicle_team_name; }?>"/>
														</div>	
													</div>	
													<div class="form-group">
														<label class="control-label col-md-3">Vehicle Booking Team Contact:</label>
														<div class="col-md-9">
															<input type="text"  placeholder="Vehicle booking team contact. Eg: 88888888,999999999" class="form-control" name="inp[vehicle_team_contact]" value="<?php if($settings!= NULL){ echo $settings[0]->vehicle_team_contact; }?>"/>
														</div>	
													</div>	
													<div class="form-group">
														<label class="control-label col-md-3">Vehicle Booking Email:</label>
														<div class="col-md-9">
															<input type="email" class="form-control" name="inp[vehicle_email]" value="<?php if($settings!= NULL){ echo $settings[0]->vehicle_email; }?>"/>
														</div>	
													</div>	
													<hr>
													<div class="form-group">
														<div class="form-actions">
															<div class="row">
																<div class="col-md-offset-2 col-md-10">
																	<input type="hidden" name="inp[id]" value="<?php if($settings!= NULL){ echo $settings[0]->id; }?>"/>	
																	<input type="hidden" name="type" value="<?php if($settings!= NULL){ echo "Update"; } else { echo "Add";}?>"/>
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
	$("#updateGeneralSettings").validate({
		rules: {
			admin_email: {
				required: true,
			},
		},
		submitHandler: function(form) {
			var response = $("#res");
			var formData = $("#updateGeneralSettings").serializeArray();
			if (confirm("Are you sure to save changes ?")) {
				if (ajaxReq) {
					ajaxReq.abort();
				}
				ajaxReq = jQuery.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>" + "Settings/ajax_updateGeneralsettings",
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
		