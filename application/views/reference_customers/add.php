<div class="page-container">
	<div class="page-content-wrapper">
		<div class="page-content">
			<form role="form" id="addUser" method="post">
			<div class="portlet box blue">
			<div class="portlet-title">
					<div class="caption"><i class="fa fa-user"></i>Add Reference Customer</div>
					<a class="btn btn-success" href="<?php echo site_url("marketing"); ?>" title="Back">Back</a>
				</div>
			</div>
			<div class="portlet-body">
			
				<div class="col-md-4">	
				<div class="form-group">
					<label class="control-label">Full Name*</label>
					<input  type="text" required placeholder="Full Name" name="inp[name]" class="form-control" value="" /> 
				</div>
				</div>
				
				<div class="col-md-4">
				<div class="form-group">
					<label class="control-label">Email Id*</label>
					<input type="text" required placeholder="Email Id" name="inp[email]" class="form-control" value="" /> 
				</div>
				</div>
				
				<div class="col-md-4">
				<div class="form-group">
					<label class="control-label">Contact Number*</label>
					<input type="text" required placeholder="Contact Number" name="inp[contact]" class="form-control" value="" /> 
				</div>
				</div>
				<div class="clearfix"></div>
				<div class="col-md-4">
				<label class="control-label">Address( State )</label>
					<div class="form-group">
						<?php $state_list = get_indian_state_list(); 
						if( $state_list ){
							echo "<select name='inp[state]' class='form-control' id='state'>";
								echo '<option value="">Select State</option>';
								foreach($state_list as $state){
									echo '<option value="'.$state->id.'">'.$state->name.'</option>';
								}
							echo "</select>";
						}else{ ?>
							<input type="text" placeholder="State Name" name="inp[state]" class="form-control" value="" /> 
						<?php } ?>	
					</div>
				</div>
				<div class="col-md-4">
					<div id ="city_list">
						<div class='form-group'>
						<label>City:</label>
						<select name='inp[city]' disabled class='form-control city'>
							<option value="">Select City</option>
						</select>
						</div>
					</div>
				</div>
			<div class="clearfix"></div>
			<hr>
			<div class="col-md-12">
				<div class="margiv-top-10 text-left">
					<button type="submit" class="btn green uppercase add_user">Add Customer</button>
				</div>
			</div>	
			</form>
				<div class="clearfix"></div>
			</div><!-- portlet body -->
			</div> <!-- portlet -->
			
			<div id="addresEd"></div>		
		</div>
	<!-- END CONTENT BODY -->
	</div>
<!-- Modal -->
 </div>
<script type="text/javascript">
jQuery(document).ready(function($){
	var form = $("#addUser");
	var ajaxReq;
	$("#addUser").validate({
		rules: {
			
			name: {
			  required: true,
			},
			company_name: {
			  required: true,
			},

		},
		submitHandler: function(form) {
			var resp = $("#addresEd");
			var formData = $("#addUser").serializeArray();
			//console.log(formData);
			if (ajaxReq) {
					ajaxReq.abort();
				}
				ajaxReq = $.ajax({
				type: "POST",
				url: "<?php echo base_url('reference_customers/ajax_add_ref_customer'); ?>" ,
				dataType: 'json',
				data: formData,
				beforeSend: function(){
					resp.html('<p><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
				},
				success: function(res) {
					if (res.status == true){
						resp.html('<div class="alert alert-success"><strong>Success! </strong>'+res.msg+'</div>');
						//console.log("done");
						 $("#addUser")[0].reset();
						window.location.href = "<?php echo site_url("reference_customers/view/");?>" + res.id; 
					}else{
						resp.html('<div class="alert alert-danger"><strong>Error! </strong>'+res.msg+'</div>');
						console.log("error");
					}
				},
				error: function(e){
					console.log(e);
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
