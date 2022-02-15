<div class="page-container">
<div class="page-content-wrapper">
<div class="page-content">
   <!--Show success message if hotel edit/add -->
   <?php if($agent){ 	$agent = $agent[0];		?>
   <div class="portlet box blue">
      <div class="portlet-title">
         <div class="caption"><i class="fa fa-users"></i>User Name: <strong><?php echo $agent->user_name; ?></strong></div>
         <a class="btn btn-success" href="<?php echo site_url("agents"); ?>" title="Back">Back</a>
      </div>
   </div>
	<div class="second_custom_card">
		<form role="form" id="editAgent" enctype="multipart/form-data" >
		<div class="col-md-4">
			<div class="form-group">
				<label class="control-label">First Name*</label>
				<input required type="text" name="firstname" placeholder="First Name" class="form-control" value="<?php echo $agent->first_name;?>" /> 
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<label class="control-label">Last Name*</label>
				<input required type="text" placeholder="Last Name" name="lastname" class="form-control" value="<?php echo $agent->last_name;?>" /> 
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<label class="control-label">Email*</label>
				<input required type="email" placeholder="Email" name="email" class="form-control" value="<?php echo $agent->email;?>" /> 
			</div>
		</div>
		<div class="clearfix"></div>
		<div class="col-md-4">
			<div class="form-group">
				<label class="control-label">Change Password</label>
				<input type="password" name="newpassword" placeholder="Enter new password" class="form-control" value="" /> 
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<label class="control-label">Alternate Password</label><span style='font-size: 11px; color: red;'> (Accessible by manager/admin)</span>
				<input type="text" name="alt_pass" maxlength="8" placeholder="Alternate password" class="form-control alt_pass" value="<?php echo isset($agent->alt_pass) ? $agent->alt_pass : "";?>" /> 
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<label class="control-label">Office Timing*</label>
				<div class="input-group input-large date-picker input-daterange" data-date="10/11/2012" data-date-format="mm/dd/yyyy">
				<input name="in_time" type="text" class="form-control timepicker timepicker-no-seconds" value="<?php echo $agent->in_time;?>"/>
				<span class="input-group-addon"> to </span>
				<input name="out_time" type="text" class="form-control timepicker timepicker-no-seconds" value="<?php echo $agent->out_time;?>"/>
				</div>
			</div>
		</div>
		<div class="clearfix"></div>
		<div class="col-md-4">
			<div class="form-group">
				<label class="control-label">Mobile Number*</label>
				<input required type="text" placeholder="Mobile" name="mobile" class="form-control" value="<?php echo $agent->mobile;?>"/> 
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<label class="control-label">Gender*</label><br>
				<input required name="gender" value="male" <?php if($agent->gender=='male'){ echo "checked=checked";}  ?> type="radio"> Male
				<input required name="gender" <?php if($agent->gender=='female'){ echo "checked=checked";}  ?> value="female" type="radio"> Female
			</div>
		</div>
		<?php $get_all_users_role = get_all_users_role(); ?>
		<div class="col-md-4">
			<div class="form-group">
				<label class="control-label">User Role*</label>
				<?php if( is_admin() ){ ?>
				<select required name="user_type" class="form-control">
				<?php 
				if( $get_all_users_role ){
					foreach($get_all_users_role as $role ){
						$selected = $role->role_id == $agent->user_type ? "selected" : "";
						echo "<option {$selected} value='{$role->role_id}'>". ucwords($role->role_name) ."</option>";
					}
				}
				?>
				</select>
				<?php }else{ ?>
				<select required name="user_type" class="form-control">
				<?php 
				if( $get_all_users_role ){
					foreach($get_all_users_role as $role ){
						if( $role->role_id == 99 || $role->role_id == 98 ) continue;
						$selected = $role->role_id == $agent->user_type ? "selected" : "";
						echo "<option {$selected} value='{$role->role_id}'>". ucwords($role->role_name) ."</option>";
					}
				}
				?>
				</select>
				<?php } ?>
			</div>
		</div>
		<div class="clearfix"></div>
		<div class="col-md-4">
			<div class="form-group">
				<label class="control-label">User Status*</label>
				<select required name="user_status" class="form-control" id="user_status" >
				<option value="active" <?php if ($agent->user_status == "active" ) { ?> selected="selected" <?php } ?>>Active</option>
				<option value="inactive" <?php if ($agent->user_status == "inactive" ) { ?> selected="selected" <?php } ?>>Inactive</option>
				<option value="block" <?php if ($agent->user_status == "block" ) { ?> selected="selected" <?php } ?>>Block</option>
				</select>
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<label class="control-label">Mobile Number For Login*</label><span style='font-size: 11px; color: red;'> (Visible for manager/admin only.)</span>
				<input  type="text" placeholder="Mobile number for login otp. Should be unique." maxlength="10" id="mobile_otp" name="mobile_otp" class="form-control" data-otp_val="<?php echo $agent->mobile_otp;?>" value="<?php echo $agent->mobile_otp;?>" /> 
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<label class="control-label">Website</label>
				<input type="text" placeholder="Website" name="website" class="form-control" value="<?php echo $agent->website;?>" /> 
			</div>
		</div>
		<div class="clearfix"></div>
		<div class="margiv-top-10 margin_left_15">
			<input type="hidden" name="user_id" id="user_id" value="<?php echo $agent->user_id;?>"/>
			<button type="submit" class="btn green uppercase update_profile">Update User</button>
		</div>
		</form>
	</div>
   <div id="resEd"></div>
   <?php }else{
      echo "invalid user id";
      } ?>
</div>
<!-- END CONTENT BODY -->
<script type="text/javascript">
   jQuery(document).ready(function($){
   	//user_status on change
   	$("#user_status").change(function(){
   		var _this_val = $(this).val();
   		var otp_val = $("#mobile_otp").attr("data-otp_val");
   		if( _this_val == "block" ){
   			$("#mobile_otp").val(0);
   		}else{
   			$("#mobile_otp").val(otp_val);
   		}
   		//console.log(_this_val);
   	});
   	
   	jQuery.validator.addMethod("strongPass", function (value, element) {
           if (this.optional(element)) {
               return true;
           }
   		//var pattern = new RegExp(/^(?=.*[a-zA-Z])(?=.*\d)(?=.*[!@#$%^&*()_+])[A-Za-z\d][A-Za-z\d!@#$%^&*()_+]{4,8}$/);
   		//console.log( pattern.test("1@3a") );
   		//var pattern = new RegExp(/(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}/);
   		var pattern = new RegExp(/(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*()_+]).{4,8}/);
   		valid = false;
   		if( pattern.test(value) ){
   			valid = true;
           }
           return valid;
       }, "At least one number/lowercase/uppercase/specail character.");
   	
   	var form = $("#editAgent");
   	var resp = $("#resEd");
   	var user_id	= $("#user_id").val();
   	var ajaxReq;
   	form.validate({
   		rules: {
   			email: {
   				required: true,
   				email: true
   			},
   			newpassword:{
   				minlength: 6
   			},
   			alt_pass:{
   				minlength: 4,
   				strongPass: true
   			},
   			mobile: {
   			  required: true,
   			  number: true
   			},
   			mobile_otp: {
   			  required: true,
   			  number: true
   			},
   		},
   		submitHandler: function(form) {
   			var formData = $("#editAgent").serializeArray();
   			if (ajaxReq) {
   				ajaxReq.abort();
   			}
   				
   			ajaxReq = jQuery.ajax({
   				type: "POST",
   				url: "<?php echo base_url(); ?>" + "AjaxRequest/ajax_admin_profileUpdate",
   				dataType: 'json',
   				data: formData,
   				beforeSend: function(){
   					resp.html('<p><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
   				},
   				success: function(res) {
   					if (res.status == true){
   						resp.html('<div class="alert alert-success"><strong>Success!</strong>'+res.msg+'</div>');
   						//console.log("done");
   						window.location.href = "<?php echo site_url("agents/view/");?>" + user_id;
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