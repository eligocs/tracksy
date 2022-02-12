<div class="page-container">
	<div class="page-content-wrapper">
		<div class="page-content">
		<?php $message = $this->session->flashdata('success'); 
				if($message){ echo '<span class="help-block help-block-success">'.$message.'</span>'; }
			?>
		<?php if($m_user){ 	$muser = $m_user[0];		?>
			<div class="portlet box blue">
			<div class="portlet-title">
					<div class="caption"><i class="fa fa-user"></i>Edit Reference Customer</div>
					<a class="btn btn-success" href="<?php echo site_url("reference_customers"); ?>" title="Back">Back</a>
				</div>
			</div>
			<form role="form" id="updateUser" method="post">
			<div class="portlet-body">
				<div class="col-md-4">	
				<div class="form-group">
					<label class="control-label">Full Name*</label>
					<input  type="text" required placeholder="Full Name" name="inp[name]" class="form-control" value="<?php echo $muser->name;?>" /> 
				</div>
				</div>
				
				<div class="col-md-4">
				<div class="form-group">
					<label class="control-label">Email Id*</label>
					<input type="text" required placeholder="Email Id" name="inp[email]" class="form-control" value="<?php echo $muser->email;?>" /> 
				</div>
				</div>
				
				<div class="col-md-4">
				<div class="form-group">
					<label class="control-label">Contact Number*</label>
					<input type="text" required placeholder="Contact Number" name="inp[contact]" class="form-control" value="<?php echo $muser->contact;?>" /> 
				</div>
				</div>
				<div class="clearfix"></div>
				<div class="col-md-4">
				<label class="control-label">Address ( State )</label>
					<div class="form-group">
						<?php $state_list = get_indian_state_list(); 
						if( $state_list ){
							echo "<select name='inp[state]' class='form-control' id='state'>";
								echo '<option value="">Select State</option>';
								foreach($state_list as $state){
									$selected = $muser->state == $state->id ? "selected='selected'" : "";
									echo '<option '. $selected .' value="'.$state->id.'">'.$state->name.'</option>';
								}
							echo "</select>";
						}else{ ?>
							<input type="text" placeholder="State Name" name="inp[state]" class="form-control" value="<?php echo $muser->state; ?>" /> 
						<?php } ?>	
					</div>
				</div>
				<div class="col-md-4">
					<div id ="city_list">
						<div class='form-group'>
							<label>City:</label>
							<select name='inp[city]' class='form-control city'>
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
			<div class="clearfix"></div>
			<hr>
			<div class="col-md-12">
				<div class="margiv-top-2 ">
					<input type="hidden" name="id" id="id" value="<?php echo $muser->id; ?>">
					<button type="submit" class="btn green uppercase update_user">Update customer</button>
				</div>
			</div>	
			</form>
				<div class="clearfix"></div>
				<div id="addresEd"></div>	
			</div><!-- portlet body -->
			</div> <!-- portlet -->
		<?php }else{
			redirect("reference_customers");
		} ?>
	</div>
	<!-- END CONTENT BODY -->
<script type="text/javascript">
jQuery(document).ready(function($){
	var form = $("#updateUser");
	var resp = $("#addresEd");
	var id = $("#id").val();
	var ajaxReq;
	form.validate({
		submitHandler: function(form) {
			var formData = $("#updateUser").serializeArray();
			if (ajaxReq) {
				ajaxReq.abort();
			}
				
			ajaxReq = jQuery.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>" + "reference_customers/ajax_update_ref_customer",
				dataType: 'json',
				data: formData,
				beforeSend: function(){
					resp.html('<p><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
					console.log("sending...");
				},
				success: function(res) {
					if (res.status == true){
						resp.html('<div class="alert alert-success"><strong>Success!</strong>'+res.msg+'</div>');
						console.log("done");
						window.location.href = "<?php echo site_url("reference_customers/view/"); ?>" + id;
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
