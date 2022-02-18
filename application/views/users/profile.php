	<link rel="stylesheet" href="<?php echo base_url(); ?>site/assets/css/croppie.css">
	<script src="<?php echo base_url(); ?>site/assets/js/croppie.js"></script>
   

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
								<?php $defalut_logo = $u_data->gender == "female" ? "profile_f.png" : "profile_m.png"; ?>
								<?php $usr_pic = $u_data->user_pic ? $u_data->user_pic: $defalut_logo; ?>
								<img alt="" class="img-responsive user-profile-image" src="<?php echo site_url() . 'site/images/userprofile/' . $usr_pic; ?>" />
							</div>
							<!-- END SIDEBAR USERPIC -->
							<!-- SIDEBAR USER TITLE -->
							<div class="profile-usertitle">
								<div class="profile-usertitle-name"> Name: <strong> <?php echo !empty( $u_data->first_name ) ? ucfirst($u_data->first_name) ." ". ucfirst($u_data->last_name): ucfirst($u_data->user_name); ?> </strong></div>
								<div class="profile-usertitle-name">Email: <strong><?php echo $u_data->email; ?></strong><div>
								<div class="profile-usertitle-name">Mobile: <strong><?php echo $u_data->mobile; ?></strong><div>
								
								
								<div class="profile-usertitle-job"> 
									<strong class="red">
									<?php if($u_data->user_type == 99){
										echo $u_data->is_super_admin == 1 ? "Super Admin" : "Administrator";
									}elseif($u_data->user_type == 98){
										$agent_type = get_manager_type( $u_data->is_super_manager );
										/* if(   $u_data->is_super_manager == 1 ){
											$agent_type = "Super Manager";
										}else if( $u_data->is_super_manager == 2 ){
											$agent_type = "Leads Manager";
										}else{
											$agent_type = get_role_name($u_data->user_type);
										} */
										echo $agent_type; 
										//echo $u_data->is_super_manager == 1 ? "Super Manager" : "Manager";
										//echo $u_data->is_super_manager == 1 ? "Super Manager" : $u_data->is_super_manager == 2 ? "Leads Manager" : "Manager";
									}else{
										echo get_role_name($u_data->user_type);
									}
								 ?> </strong>
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
														<input required type="text" name="firstname" placeholder="First Name" class="form-control" value="<?php echo $u_data->first_name;?>" /> 
													</div>
													
													<div class="form-group">
														<label class="control-label">Last Name</label>
														<input required type="text" placeholder="Last Name" name="lastname" class="form-control" value="<?php echo $u_data->last_name;?>" /> 
													</div>
													
													<div class="form-group">
														<label class="control-label">Mobile Number</label>
														<input required type="text" placeholder="Mobile" name="mobile" class="form-control" value="<?php echo $u_data->mobile;?>"/> 
													</div>
													
													<div class="form-group">
													   <label class="control-label">Gender</label>
													   <input required name="gender" value="male" <?php if($u_data->gender=='male'){ echo "checked=checked";}  ?> type="radio" id="lmale"> <label for="lmale">Male</label>
													   <input name="gender" <?php if($u_data->gender=='female'){ echo "checked=checked";}  ?> value="female" type="radio" id="lfemale"> <label for="lfemale">Female</label>
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
														<div class="col-md-6">
															<div id="upload-demo" style="width:400px;"></div>
															
																<div>
																	<span class="btn default btn-file">
																		<span class="fileinput-newa"> Click Here To Change </span>
																		<span class="fileinput-existss"> Avatar </span>
																		<input id="profile_pic" type="file" id = "profile_pic" name="profile_pic"> </span>
																</div>
																
																<div class="margin-top-10 clearfix">
																	<span class="label label-danger">NOTE! </span>
																	<span>&nbsp; &nbsp; Image size not bigger then 1 MB and size (350 X 200).</span>
																</div>
														</div>
														<div class="col-md-6">
															<div class="fileinput fileinput-new" data-provides="fileinput">
																<div class="fileinput-new thumbnail" style="width: 350px; height: 200px;">
																	<img alt="" class="img-responsive" src="<?php echo site_url() . 'site/images/userprofile/' . $usr_pic; ?>" />
																</div>
																
															</div>
														</div>
													</div>
													<div class="margin-top-10 clearfix"></div>
													<hr>
													<div class="margin-top-10">
														<input type="hidden" id="avatar_user_id" name="user_id" value="<?php echo $u_data->user_id;?>"/>
														<button type="submit" class="btn green uppercase upload-result">Update Profile</button>
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
	/*$(document).on("submit",'#changePic', function(e){
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
	});  */
});	
</script>
<!-- change avatar -->
<script type="text/javascript">
	$uploadCrop = $('#upload-demo').croppie({
		enableExif: true,
		viewport: {
			width: 350,
			height: 200,
			type: 'rectangle'
		},
		boundary: {
			width:400,
			height:250,
		}
	});


	$('#profile_pic').on('change', function () { 
		var reader = new FileReader();
		reader.onload = function (e) {
			$uploadCrop.croppie('bind', {
				url: e.target.result
			}).then(function(){
				console.log('jQuery bind complete');
			});
			
		}
		reader.readAsDataURL(this.files[0]);
	});


	$('.upload-result').on('click', function (ev) {
		ev.preventDefault();
		var id = $('#avatar_user_id').val();
		var res = $("#changePicRes");
		if( $('#profile_pic').val() == '' ){
			res.html('<div class="alert alert-danger"><strong>Error! </strong>Please Select the file! </div>');
		}else{
			$uploadCrop.croppie('result', {
				type: 'canvas',
				size: 'viewport'
			}).then(function (resp) {
				$.ajax({
					url: "<?php echo base_url('agents/update_user_avatar'); ?>",
					type: "POST",
					data: { "image":resp,'user_id': id },
					success: function (data) {
						if( data == "success" ){
							res.html('<div class="alert alert-success"><strong>Success: </strong> profile successfully uploaded!</div>');
							window.location.href = "<?php echo site_url("dashboard/profile");?>"; 
						}else{
							res.html(data);
						}
					},
					error: function(e){
						//console.log(e);
						res.html('<div class="alert alert-danger"><strong>Error!</strong>Please Try again later! </div>');
					}
				});
			});
		}	
	});

</script>