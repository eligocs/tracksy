<div class="page-container">
	<div class="page-content-wrapper">
		<div class="page-content">
			<div class="portlet box blue">
				<div class="portlet-title">
					<div class="caption">
						<i class="icon-plus"></i>Add New Vehicle
					</div>
					<a class="btn btn-success" href="<?php echo site_url("vehicles"); ?>" title="Back">Back</a>
				</div>
			</div>	
			<div class="portlet-body">
			<form role="form" id="addVehicles">
			<div class="row">
				<div class="col-md-6">
				<div class="form-group">
					<label class="control-label">Vehicle Name*</label>
					<input type="text" required placeholder="Cab Name" name="inp[car_name]" class="form-control" value=""/> 
				</div>
				</div>
				<div class="col-md-6">
				<div class="form-group">
					<label class="control-label">Max Person*</label>
					<select name="inp[max_person]" class="form-control" required >
						<option value="">Select Max Person</option>
						<?php for($i = 2 ; $i<= 40; $i++ ){
							echo "<option value={$i}>{$i}</option>";
						} ?>
					</select>
				</div>
				</div>
				
				<div class="clearfix"></div>
				
				<div class="col-md-6">
				<div class="form-group">
					<label class="control-label">Rate per/day*</label>
					<input type="number" required placeholder="Vehicle Rate per/day" name="inp[car_rate]" class="form-control price_input" value=""/> 
				</div>
				</div>
			</div>
			<div class="clearfix"></div>
				<div class="col-md-10">
				<div class="margiv-top-10">
					<button type="submit" class="btn green uppercase add_vehicle">Add Vehicle</button>
				</div>
				</div>
				
			</form>
			<div class="clearfix"></div>
			<div id="addresEd"></div>		
			</div><!-- portlet body -->
			</div> <!-- portlet -->
		</div>
	<!-- END CONTENT BODY -->
	</div>
<!-- Modal -->
 </div>
<script type="text/javascript">
jQuery(document).ready(function($){
	
	//Prevent Dot from number field
	$(".price_input").on('keyup keypress', function(e) {
		var keyCode = e.keyCode || e.which;
		if (keyCode === 46) { 
			e.preventDefault();
			return false;
		}
	});
	
	var form = $("#addVehicles");
	var resp = $("#addresEd"),ajaxReq;
	$("#addVehicles").validate({
		submitHandler: function(form) {
			var formData = $("#addVehicles").serializeArray();
			//console.log(formData);
			if (ajaxReq) {
				ajaxReq.abort();
			}
			ajaxReq = $.ajax({
				type: "POST",
				url: "<?php echo base_url('AjaxRequest/addVehicles'); ?>" ,
				dataType: 'json',
				data: formData,
				beforeSend: function(){
					resp.html('<div class="alert alert-success"><i class="fa fa-spinner fa-spin"></i> Please wait...</div>');
				},
				success: function(res) {
					if (res.status == true){
						resp.html('<div class="alert alert-success"><strong>Success! </strong>'+res.msg+'</div>');
						//console.log("done");
						$("#addVehicles")[0].reset();
						window.location.href = "<?php echo site_url("vehicles");?>"; 
					}else{
						resp.html('<div class="alert alert-danger"><strong>Error! </strong>'+res.msg+'</div>');
						//console.log("error");
					}
				},
				error: function(e){
						//console.log(e);
					resp.html('<div class="alert alert-danger"><strong>Error!</strong>Please Try again later! </div>');
				}
			});
			return false;
		}
	});	
}); 
</script>
