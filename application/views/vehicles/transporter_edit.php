<div class="page-container">
	<div class="page-content-wrapper">
		<div class="page-content">
		<?php if($vehicles){ 	$vehicle = $vehicles[0]; ?>
			<div class="portlet box blue">
				<div class="portlet-title">
					<div class="caption"><i class="fa fa-users"></i>Vehicle Name: <strong><?php  echo $vehicle->trans_name; ?></strong></div>
					<a class="btn btn-success" href="<?php echo site_url("vehicles/transporters"); ?>" title="Back">Back</a>
				</div>
			</div>
			<form role="form" id="editTrans">
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label">Transporter Name*:</label>
					<input required type="text" placeholder="Transporter Name" name="trans_name" class="form-control" value="<?php echo $vehicle->trans_name; ?>"/> 
				</div>
				</div>
				<div class="col-md-4">
				<div class="form-group">
					<label class="control-label">Email*:</label>
					<input type="email" placeholder="Email" name="trans_email" class="form-control" value="<?php echo $vehicle->trans_email; ?>"/> 
				</div>
				</div>
				<div class="col-md-4">
				<div class="form-group">
					<label class="control-label">Contact*:</label>
					<input required type="number" placeholder="Contact Number" name="trans_contact" class="form-control" value="<?php echo $vehicle->trans_contact; ?>"/> 
				</div>
				</div>
				<div class="clearfix"></div>
				<div class="col-md-6">
				<div class="form-group">
					<label class="control-label" >Address:</label>
					<textarea required name="trans_address" class="form-control"  placeholder="Transporter Full Address"><?php echo $vehicle->trans_address; ?></textarea>
				</div>
				</div>
				<?php 
					$car_list = $vehicle->trans_cars_list;
					$c = "";
					if( !empty($car_list) ){
						$clist = explode(",",$car_list);
					}
				?>
					<div class="col-md-6">
				<div class="form-group">
					<label class="control-label">Select Vehicles: </label>
					<select required multiple name="trans_cars_list[]" class="form-control">
						<?php $cars = get_car_categories(); 
							if( $cars ){
								foreach($cars as $car){ ?>
								<?php if( !empty($car_list)){ ?>
									<option value="<?php echo $car->id;?>" <?php if ( in_array($car->id, $clist ) ) { ?> selected="selected" <?php } ?> > <?php echo $car->car_name ; ?></option>
								<?php }else{ ?>
									<option value="<?php echo $car->id;?>"> <?php echo $car->car_name ; ?></option>
								<?php } 
								}
							}else{
								echo '<option value="">No Transporter available. </option>';
							}
						?>
					</select>
				</div>
				</div>
				<hr>
				<div class="margiv-top-10">
					<input type="hidden" name="id" id="tra_id" value="<?php echo $vehicle->id;?>"/>
					<button type="submit" class="btn green uppercase edit_hotel">Update Transporter</button>
				</div>
			</form>
			<div id="editHotelRes"></div>		
		<?php }else{
			echo "Invalid Trasporter id";
		}?>
		</div>
	<!-- END CONTENT BODY -->
	</div>
<!-- Modal -->
 </div>


<script type="text/javascript">
jQuery(document).ready(function($){
	var ajaxReq;
	$("#editTrans").validate({
		submitHandler: function(form) {
			var TRA_ID = $("#tra_id").val();
			var resp = $("#editHotelRes");
			var formData = $("#editTrans").serializeArray();
			//console.log(formData);
			if (ajaxReq) {
				ajaxReq.abort();
			}
			ajaxReq = $.ajax({
				type: "POST",
				url: "<?php echo base_url('AjaxRequest/editTransporter'); ?>" ,
				dataType: 'json',
				data: formData,
				beforeSend: function(){
					resp.html('<p><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
				},
				success: function(res) {
					if (res.status == true){
						resp.html('<div class="alert alert-success"><strong>Success! </strong>'+res.msg+'</div>');
						console.log("done");
						$("#editTrans")[0].reset();
						window.location.href = "<?php echo site_url("vehicles/transporterview/");?>" + TRA_ID; 
					}else{
						resp.html('<div class="alert alert-danger"><strong>Error! </strong>'+res.msg+'</div>');
						console.log("error");
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
