<div class="page-container">
	<div class="page-content-wrapper">
		<div class="page-content">
		<?php $message = $this->session->flashdata('success'); 
				if($message){ echo '<span class="help-block help-block-success">'.$message.'</span>'; }
			?>
		<?php if($m_user){ 	$muser = $m_user[0];		?>
			<form role="form" id="updateUser" method="post">
			<div class="portlet box blue">
			<div class="portlet-title">
					<div class="caption"><i class="fa fa-user"></i>Add user</div>
					<a class="btn btn-success" href="<?php echo site_url("marketing"); ?>" title="Back">Back</a>
				</div>
			</div>
			<div class="portlet-body">
				<div class="col-md-4">	
					<div class="form-group">
						<label class="control-label">Choose Category*</label>
						<?php if(!empty($row)) { ?>
						<select required name="cat_id" class="form-control">
							<option value="">Select Category</option>
							<?php foreach($row as $cat){?>
								<option <?php if( $muser->cat_id == $cat->id ){ echo "selected='selected'"; } ?> value="<?php echo $cat->id;?>"><?php echo $cat->category_name;?></option>
							<?php }	?>
								
						</select>
						<?php } else {?>
							</br><span>No category found ! Please <a href="<?php echo site_url("marketing/addcat");?>">Click Here to Add category</a></span>
						<?php }?>
					</div>
				</div>		
				<div class="col-md-4">	
				<div class="form-group">
					<label class="control-label">Full Name*</label>
					<input  type="text" required placeholder="Full Name" name="name" class="form-control" value="<?php echo $muser->name;?>" /> 
				</div>
				</div>
				
				<div class="col-md-4">
				<div class="form-group">
					<label class="control-label">Email Id*</label>
					<input type="text" required placeholder="Email Id" name="email_id" class="form-control" value="<?php echo $muser->email_id;?>" /> 
				</div>
				</div>
				<div class="clearfix"></div>
				<div class="col-md-4">
				<div class="form-group">
					<label class="control-label">Contact Number*</label>
					<input type="text" required placeholder="Contact Number" name="contact_number" class="form-control" value="<?php echo $muser->contact_number;?>" /> 
				</div>
				</div>
				
				
				<div class="col-md-4">
				<div class="form-group">
					<label class="control-label">Whats App Number</label>
					<input  type="number"  placeholder="Whats App Number" name="whats_app_number" class="form-control" value="<?php echo $muser->whats_app_number; ?>" /> 
				</div>
				</div>
				
				
				<div class="col-md-4">
				<div class="form-group">
					<label class="control-label">Business Name*</label>
					<input  type="text" required placeholder="Business Name" name="company_name" class="form-control" value="<?php echo $muser->company_name;?>" /> 
				</div>
				</div>
				
				<div class="clearfix"></div>
				<div class="col-md-3">
				<label class="control-label">Address ( State )</label>
					<div class="form-group">
						<?php $state_list = get_indian_state_list(); 
						if( $state_list ){
							echo "<select name='state' class='form-control' id='state'>";
								echo '<option value="">Select State</option>';
								foreach($state_list as $state){
									$selected = $muser->state == $state->id ? "selected='selected'" : "";
									echo '<option '. $selected .' value="'.$state->id.'">'.$state->name.'</option>';
								}
							echo "</select>";
						}else{ ?>
							<input type="text" placeholder="State Name" name="state" class="form-control" value="<?php echo $muser->state; ?>" /> 
						<?php } ?>	
					</div>
				</div>
				<div class="col-md-3">
					<div id ="city_list">
						<div class='form-group'>
							<label>City:</label>
							<select name='city' class='form-control city'>
								<option value="">Select City</option>
								<?php $cities = get_city_list($muser->state);
								if($cities){
									foreach( $cities as $city ){ ?>
										<option value="<?php echo $city->id;?>" <?php if ($city->id == $muser->city ) { ?> selected="selected" <?php } ?> > <?php echo $city->name ; ?></option>
										
									<?php }
								}
								?>
							</select>
						</div>
					</div>
				</div>
				<div class="col-md-3">
				<label class="control-label">Place</label>
					<div class="form-group">
						<input  type="text" placeholder="Place" name="place" class="form-control" value="<?php echo $muser->place; ?>" /> 
					</div>
				</div>
				
				<div class="col-md-3">
				<label class="control-label">Website</label>
					<div class="form-group">
						<input  type="url" placeholder="website" name="website" class="form-control" value="<?php echo $muser->website; ?>" /> 
					</div>
				</div>
				
			
			<div class="clearfix"></div>
			<hr>
			<div class="col-md-12">
				<div class="margiv-top-2 ">
					<input type="hidden" name="m_id" id="id" value="<?php echo $muser->id; ?>">
					<button type="submit" class="btn green uppercase update_user">Update User</button>
				</div>
			</div>	
			</form>
				<div class="clearfix"></div>
			<div id="resEd"></div>	
			</div><!-- portlet body -->
			</div> <!-- portlet -->
			
		<?php }else{
			redirect("marketing");
		} ?>
	</div>
	<!-- END CONTENT BODY -->
<script type="text/javascript">
jQuery(document).ready(function($){
	//Email id validation
	jQuery.validator.addMethod("multiemail", function (value, element) {
        if (this.optional(element)) {
            return true;
        }
        var emails = value.split(','),
            valid = true;
        for (var i = 0, limit = emails.length; i < limit; i++) {
            value = emails[i];
            valid = valid && jQuery.validator.methods.email.call(this, value, element);
        }
        return valid;
    }, "Separate valid email with a comma without spaces.");
	
	//Multiphone number validation
	$.validator.addMethod("multi_phone", function(value, element) {
        return this.optional(element) || /^[0-9 + ,]*$/i.test(value);
    }, "Separate valid Contact Number with a comma without spaces");
	
	var form = $("#updateUser");
	var resp = $("#resEd");
	var id = $("#id").val();
	var ajaxReq;
	form.validate({
		rules: {
			email_id: {
				required: true,
				multiemail:true 
			},
			contact_number:{
				multi_phone: true,
			},
			whats_app_number:{
				multi_phone: true,
			}

		},
		submitHandler: function(form) {
			var formData = $("#updateUser").serializeArray();
			if (ajaxReq) {
				ajaxReq.abort();
			}
				
			ajaxReq = jQuery.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>" + "marketing/ajax_update_muser",
				dataType: 'json',
				data: formData,
				beforeSend: function(){
					resp.html('<p><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
				},
				success: function(res) {
					if (res.status == true){
						resp.html('<div class="alert alert-success"><strong>Success!</strong>'+res.msg+'</div>');
						//console.log("done");
						window.location.href = "<?php echo site_url("marketing/view/"); ?>" + id;
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

<script type="text/javascript">
	jQuery(document).ready(function(){
		/*get cities from state*/
		$(document).on('change', 'select#state', function() {
			var selectState = $("#state option:selected").val();
			var _this = $(this);
			$("#place").val("");
			_this.parent().append('<p class="bef_send"><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
			$.ajax({
				type: "POST",
				url: "<?php echo base_url('marketing/cityListByStateId'); ?>",
				data: { state: selectState } 
			}).done(function(data){
				$(".bef_send").hide();
				$(".city").html(data);
				$(".city").removeAttr("disabled");
			}).error(function(){
				$("#city_list").html("Error! Please try again later!");
			});
		});
	});
</script>
