<?php $user_profile = get_user_info(); ?>
<?php if( !empty( $user_profile ) ){ ?>
<?php $u_data = $user_profile[0]; ?>
<div class="page-container">
	<div class="page-content-wrapper">
		<div class="page-content ">
			<div class="portlet box blue">
			<div class="portlet-title ">
				<div class="caption">
					<i class="fa fa-user"></i> Welcome: <strong><?php echo $u_data->user_name; ?></strong>
				</div>
				<a class="btn btn-success" href="<?php echo site_url("dashboard"); ?>" title="Back">Back</a>
			</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<!-- BEGIN PROFILE SIDEBAR -->
					<div class="profile-sidebar">
						<!-- PORTLET MAIN -->
						<div class="portlet light profile-sidebar-portlet ">
							<!-- SIDEBAR USERPIC -->
							<div class="profile-userpic">
								<?php $defalut_logo = 'yatra_logo.png'; ?>
								<?php $usr_pic = $u_data->user_pic ? $u_data->user_pic: $defalut_logo; ?>
								<img alt="" class="img-responsive user-profile-image" src="<?php echo site_url() . 'site/images/userprofile/' . $usr_pic; ?>" />
							</div>
							<!-- END SIDEBAR USERPIC -->
							<!-- SIDEBAR USER TITLE -->
							<div class="profile-usertitle">
								<div class="profile-usertitle-name"> <?php echo ucfirst($u_data->first_name) ? ucfirst($u_data->first_name): ucfirst($u_data->user_name); ?> </div>
								<div class="profile-usertitle-job"> 
									<?php if($u_data->user_type == 99){
										echo $u_data->is_super_admin == 1 ? "Super Admin" : "Administrator";
									}elseif($u_data->user_type == 98){
										echo $u_data->is_super_manager == 1 ? "Super Manager" : "Manager";
									}elseif($u_data->user_type == 97){
										echo "Service Team";
									}elseif($u_data->user_type == 96){
										echo "Sales Team";
									}else{
										echo "Leads Team";
									} ?>
								</div>
							</div>
						</div>
					</div>
					<!-- END BEGIN PROFILE SIDEBAR -->
					<!-- BEGIN PROFILE CONTENT -->
					<div class="profile-content">
						<div class="row">
							<div class="col-md-12">
								<div class="portlet light ">
									<div class="portlet-title tabbable-line">
										<div class="caption caption-md">
											<i class="icon-globe theme-font hide"></i>
											<span class="caption-subject font-blue-madison bold uppercase">Profile Account</span>
										</div>
										<ul class="nav nav-tabs">
											<li class="active">
												<a href="#tab_1_1" data-toggle="tab">Personal Info</a>
											</li>
											<li>
												<a href="#tab_1_2" data-toggle="tab">Change Avatar</a>
											</li>
											<li>
												<a href="#tab_1_3" data-toggle="tab">Change Password</a>
											</li>
										   
										</ul>
									</div>
									<div class="portlet-body">
										<div class="tab-content">
											<!-- PERSONAL INFO TAB -->
											<div class="tab-pane active" id="tab_1_1">
												<form role="form" id="UpdateForm" enctype="multipart/form-data" >
													<div class="form-group">
														<label class="control-label">First Name</label>
														<input required type="text" name="firstname" placeholder="First Name" class="form-control" value="<?php echo $u_data->first_name;?>" /> </div>
													<div class="form-group">
														<label class="control-label">Last Name</label>
														<input required type="text" placeholder="Last Name" name="lastname" class="form-control" value="<?php echo $u_data->last_name;?>" /> 
													</div>
													
													<div class="form-group">
														<label class="control-label">Mobile Number</label>
														<input required type="text" placeholder="Mobile" name="mobile" class="form-control" value="<?php echo $u_data->mobile;?>"/> </div>
													<div class="form-group">
													   <label class="control-label">Gender</label>
													   <input required name="gender" value="male" <?php if($u_data->gender=='male'){ echo "checked=checked";}  ?> type="radio"> Male
													   <input name="gender" <?php if($u_data->gender=='female'){ echo "checked=checked";}  ?> value="female" type="radio"> Female
													</div>
												 
											 
													<div class="margiv-top-10">
														<input type="hidden" name="user_id" value="<?php echo $u_data->user_id;?>"/>
														<button type="submit" class="btn green uppercase update_profile">Update Profile</button>
													</div>
												</form>
												<div id="reponseUpdate"></div>
											</div>
											<!-- END PERSONAL INFO TAB -->
											<!-- CHANGE AVATAR TAB -->
											<div class="tab-pane" id="tab_1_2">
												<form role="form" id="changePic" enctype="multipart/form-data">
													<div class="form-group">
														<div class="fileinput fileinput-new" data-provides="fileinput">
															<div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
																
																<img alt="" class="img-responsive" src="<?php echo site_url() . 'site/images/userprofile/' . $usr_pic;?>" />
																</div>
															<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
															<div>
																<span class="btn default btn-file">
																	<span class="fileinput-newa"> Select image </span>
																	<span class="fileinput-existss"> Change </span>
																	<input id="profile_pic" type="file" name="profile_pic"> </span>
																<a href="javascript:;" class="btn default fileinput-exists" data-dismiss="fileinput"> Remove </a>
															</div>
														</div>
														<div class="clearfix margin-top-10">
															<span class="label label-danger">NOTE! </span>
															<span>Image size not bigger then 1 MB and size(350 X 200).</span>
														</div>
													</div>
													<div class="margin-top-10">
														<input type="hidden" name="user_id" value="<?php echo $u_data->user_id;?>"/>
														<button type="submit" class="btn green uppercase">Change Profile Pic</button>
													</div>
												</form>
												<div id="changePicRes"></div>
											</div>
											<!-- END CHANGE AVATAR TAB -->
											<!-- CHANGE PASSWORD TAB -->
											<div class="tab-pane" id="tab_1_3">
												<form id="changePass">
													<div class="form-group">
														<label class="control-label">Current Password</label>
														<input required type="password" class="form-control" placeholder="Enter your current password" name="oldPass"/> 
													</div>
													<div class="form-group">
														<label class="control-label">New Password</label>
														<input required id="password" placeholder="Enter new password" type="password" class="form-control" name="currentPass"/> </div>
													<div class="form-group">
														<label class="control-label">Retype Password</label>
													<input required type="password" placeholder="Retype new password" class="form-control" name="password_again"/> </div>
										  
													<div class="margin-top-10">
														<input type="hidden" name="user_id" value="<?php echo $u_data->user_id;?>"/>
														<button type="submit" class="btn green uppercase">Change Password</button>
													</div>
												</form>
												<div id="ajaxResChangePass"></div>
											</div>
											<!-- END CHANGE PASSWORD TAB -->
											
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
<?php } ?>

<script type="text/javascript">

// Ajax Update Account 
jQuery(document).ready(function($) {
	$("#UpdateForm").validate({
		submitHandler: function(form) {
			var response = $("#reponseUpdate");
			var formData = $("#UpdateForm").serializeArray();
			jQuery.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>" + "AjaxRequest/ajax_profileUpdate",
				dataType: 'json',
				data: formData,
				beforeSend: function(){
					response.html('<p><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
				},
				success: function(res) {
					if (res.status == true){
						response.html('<div class="alert alert-success"><strong>Success! </strong>'+res.msg+'</div>');
						location.reload();
						//console.log("done");
					}else{
						response.html('<div class="alert alert-danger"><strong>Error! </strong>'+res.msg+'</div>');
						//console.log("error");
					}
				},
				error: function(){
					response.html('<div class="alert alert-danger"><strong>Error! </strong>Please Try again later! </div>');
				}
			});
			return false;
		}
	});	
	/* Change Password */
	$("#changePass").validate({
		rules: {
			currentPass:{
				required: true,
				minlength: 6
			},
			password_again: {
			  equalTo: "#password"
			}
		},

		submitHandler: function(form1) {
			var res_change = $("#ajaxResChangePass");
			var formData = $("#changePass").serializeArray();
			jQuery.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>" + "AjaxRequest/ajaxChangePass",
				dataType: 'json',
				data: formData,
				beforeSend: function(){
					res_change.html('<p><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
				},
				success: function(res) {
					if (res.status == true){
						res_change.html('<div class="alert alert-success"><strong>Success! </strong>'+res.msg+'</div>');
						location.reload();
						//console.log("done" + res);
					}else{
						res_change.html('<div class="alert alert-danger"><strong>Error! </strong>'+res.msg+'</div>');
						//console.log("error");
					}
				},
				error: function(){
					res_change.html('<div class="alert alert-danger"><strong>Error! </strong>Please Try again later! </div>');
				}
			});
			return false;
		}
	});	
	
	/* Change pic */
	$(document).on("submit",'#changePic', function(e){
		e.preventDefault();
		var res = $("#changePicRes");
		if( $('#profile_pic').val() == '' ){
			res.html('<div class="alert alert-danger"><strong>Error! </strong>Please Select the file! </div>');
		}
		else{
			$.ajax({
				url: "<?php echo base_url(); ?>" + "AjaxRequest/ajax_upload", 
				type: "POST",
				data: new FormData(this),
				contentType: false,
				cache: false,
				processData:false,
				beforeSend: function(){
					res.html('<p><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
				},
				success:function(data){
					if( data == "success" ){
						res.html('<div class="alert alert-success"><strong>Success: </strong>Profile successfully uploaded!</div>');
						var delay = 2000; 
						setTimeout(function(){ location.reload(); }, delay);
					}else{
						res.html(data);
					}
				}
			});
		}
	}); 
});	

</script>