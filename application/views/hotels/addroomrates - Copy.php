<div class="page-container">
	<div class="page-content-wrapper">
		<div class="page-content">
			<div class="portlet box blue">
				<div class="portlet-title">
					<div class="caption"><i class="fa fa-users"></i>Add Room Rate</div>
					<a class="btn btn-success" href="<?php echo site_url("hotels/viewroomrates"); ?>" title="Back">Back</a>
				</div>
			</div>
			<form role="form" id="addHotelRoomRate">
			<?php //echo get_country_name(101);	?>
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label">Select Country</label>
					<select name="country" class="form-control country">
						<option value="">Choose Country</option>
						<?php $country = get_country_list();
						if($country){
							foreach( $country as $c ){
								echo '<option value="'. $c->id . '">' . $c->name . '</option>';
							}
						}
						?>
					</select>
				</div>
			</div>
				<div class="col-md-4">
					<div id ="state_list">
						<div class='form-group'><label>State:</label><select disabled name='state' class='form-control state'><option value="">Select state</option></select></div>
					</div>
				</div>
				
				<div class="col-md-4">
					<div id ="city_list"><div class='form-group'><label>City:</label><select disabled name='city' class='form-control city'><option value="">Select City</option></select></div></div>
				</div>
			
				<div class="clearfix"></div>
				
				<div class="col-md-4">				
					<div id ="hotel_list"><div class='form-group'><label>Hotel:</label><select disabled name='hotel' class='form-control hotel'><option value="">Select Hotel</option></select></div></div>
				</div>

				
				
				<div class="col-md-4">				
				<div class="form-group">
					<label class="control-label">Room Category</label>
					<select disabled name="room_cat_id" class="form-control roomcat">
						<option value="">Choose Room Category</option>
						<?php $roomcat = get_room_categories();
						if($roomcat){
							foreach( $roomcat as $rcat ){
								echo '<option value="'. $rcat->room_cat_id . '">' . $rcat->room_cat_name . '</option>';
							}
						}
						?>
					</select>
				</div>
				</div>
				
				<div class="col-md-4">
				<div class="form-group">
					<label class="control-label">Room Rate</label>
					<input type="number" placeholder="Room Rate" maxlength="10" minlength="2" name="room_rates" class="form-control" value=""/> 
				</div>
				</div>
				
				<div class="col-md-4">
				<div class="form-group">
					<label class="control-label" >Extra Bed Rates</label>
					<input type="number" name="extra_bed_rate" maxlength="10" minlength="2" placeholder="Extra Bed Charges" class="form-control" value=""/> 
				</div>
				</div>
				
				<hr>
				<div class="col-md-12 text-left">
				<div class="margiv-top-10">
					<button type="submit" class="btn green uppercase add_hotel">Add Hotel Room Rates</button>
				</div>
				</div>
				
				<div class="clearfix"></div>
			</form>
			<div id="addresEd"></div>		
		</div>
	<!-- END CONTENT BODY -->
	</div>
<!-- Modal -->
 </div>


<script type="text/javascript">
 jQuery(document).ready(function($){
	/*get states from country*/
    $("select.country").change(function(){
        var selectCountry = $(".country option:selected").val();
		var _this = $(this);
		_this.parent().append('<p class="bef_send"><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
		$.ajax({
            type: "POST",
            url: "<?php echo base_url('AjaxRequest/hotelStateData'); ?>",
            data: { country: selectCountry } 
        }).done(function(data){
			$(".bef_send").hide();
			$(".state").removeAttr("disabled");
            $(".state").html(data);
			$(".city").html("<option value=''>Select City</option>");
			$(".hotel").html("<option value=''>Select hotel</option>");
		}).error(function(){
			$(".bef_send").hide();
			$("#state_list").html("Error! Please try again later!");
		});
    });
	/*get cities from state*/
	$(document).on('change', 'select.state', function() {
        var selectState = $(".state option:selected").val();
		var _this = $(this);
		_this.parent().append('<p class="bef_send"><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
		$.ajax({
            type: "POST",
            url: "<?php echo base_url('AjaxRequest/hotelCityData'); ?>",
            data: { state: selectState } 
        }).done(function(data){
			$(".bef_send").hide();
			$(".city").removeAttr("disabled");
			$(".city").html(data);
			$(".hotel").html("<option value=''>Select hotel</option>");
		}).error(function(){
			$(".bef_send").hide();
			$("#city_list").html("Error! Please try again later!");
		});
    });
	
	/*get Hotels from City*/
	$(document).on('change', 'select.city', function() {
        var selectCity = $(".city option:selected").val();
		var _this = $(this);
		_this.parent().append('<p class="bef_send"><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
		$.ajax({
            type: "POST",
            url: "<?php echo base_url('AjaxRequest/hotellistByCityId'); ?>",
            data: { hotel: selectCity } 
        }).done(function(data){
			$(".bef_send").hide();
			$(".hotel").removeAttr("disabled");
			$(".hotel").html(data);
			$(".roomcat").removeAttr("disabled");
		}).error(function(){
			$(".bef_send").hide();
			$(".hotel").html("Error! Please try again later!");
		});
    });
}); 

jQuery(document).ready(function($){
	var form = $("#addHotelRoomRate");
	var resp = $("#addresEd");
	form.validate({
		rules: {
			country: {required: true},
			state: {required: true},
			city: {required: true},
			hotel: {required: true},
			room_cat_id: {required: true},
			room_rates: {required: true},
			extra_bed_rate: {required: true},
			
		},
		submitHandler: function(form) {
			var formData = $("#addHotelRoomRate").serializeArray();
			//console.log(formData);
			$.ajax({
				type: "POST",
				url: "<?php echo base_url('AjaxRequest/addHotelRoomRates'); ?>" ,
				dataType: 'json',
				data: formData,
				beforeSend: function(){
					resp.html('<p><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
				},
				success: function(res) {
					if (res.status == true){
						resp.html('<div class="alert alert-success"><strong>Success! </strong>'+res.msg+'</div>');
						//console.log("done");
						$("#addHotelRoomRate")[0].reset();
						window.location.href = "<?php echo site_url("hotels/viewroomrates");?>"; 
					}else{
						resp.html('<div class="alert alert-danger"><strong>Error! </strong>'+res.msg+'</div>');
						//console.log("error");
					}
				},
				error: function(e){
						//console.log(e);
					resp.html('<div class="alert alert-danger"><strong>Error!</strong> Please Try again later! </div>');
				}
			});
			return false;
		}
	});	
}); 
</script>
