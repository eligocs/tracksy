<div class="page-container">
	<div class="page-content-wrapper">
		<div class="page-content">
		<?php if($roomrates){ 	$rate = $roomrates[0]; ?>
			<div class="portlet box blue">
				<div class="portlet-title">
					<div class="caption"><i class="fa fa-hotel"></i>Hotel Name: <strong><?php  echo get_hotel_name($rate->hotel_id); ?></strong></div>
					<a class="btn btn-success" href="<?php echo site_url("hotels/viewroomrates"); ?>" title="Back">Back</a>
				</div>
			</div>
			<form role="form" id="editRoomRates">
				<div class="form-group">
					<label class="control-label">Hotel Country: </label>
					<select disabled name="country" class="form-control country">
					<option value="">Select Country</option>
						
						<?php $country = get_country_list();
						if($country){ 
							foreach( $country as $c ){ ?>
								<option value="<?php echo $c->id;?>" <?php if ($c->id == $rate->country_id ) { ?> selected="selected" <?php } ?> > <?php echo $c->name ; ?></option>
							<?php }
						}
						?>
						
					</select>
				</div>
				<div id ="state_list">
					<div class="form-group">
						<label class="control-label">Hotel State: </label>
						<select disabled name="state" class="form-control state">
							<option value="">Select State</option>
							<?php $states = get_state_list($rate->country_id);
							if($states){
								foreach( $states as $state ){ ?>
									<option value="<?php echo $state->id;?>" <?php if ($state->id == $rate->state_id ) { ?> selected="selected" <?php } ?> > <?php echo $state->name ; ?></option>
								<?php }
							}
							?>
						</select>
					</div>
				</div>	
				<div id ="city_list">
					<div class="form-group">
						<label class="control-label">Hotel City: </label>
						<select disabled name="city" class="form-control city">
							<option value="">Select City</option>
							<?php $cities = get_city_list($rate->state_id);
							if($cities){
								foreach( $cities as $city ){ ?>
									<option value="<?php echo $city->id;?>" <?php if ($city->id == $rate->city_id ) { ?> selected="selected" <?php } ?> > <?php echo $city->name ; ?></option>
									
								<?php }
							}
							?>
						</select>
					</div>
				</div>

				<div id ="hotel_list">
					<div class="form-group">
						<label class="control-label">Hotel Name: </label>
						<select disabled name="hotel" class="form-control hgtel">
							<option value="">Select Hotel</option>
							<?php $hotels = get_hotel_list($rate->city_id);
							if($hotels){
								foreach( $hotels as $hotel ){ ?>
									<option value="<?php echo $hotel->id;?>" <?php if ($hotel->id == $rate->hotel_id ) { ?> selected="selected" <?php } ?> > <?php echo $hotel->hotel_name ; ?></option>
									
								<?php }
							}
							?>
						</select>
					</div>
				</div>
			
				<div class="form-group">
					<label class="control-label">Room Category</label>
					<select disabled name="room_cat_id" class="form-control roomcat">
						<option value="">Choose Room Category</option>
						<?php $roomcat = get_room_categories();
						if($roomcat){
							foreach( $roomcat as $rcat ){ ?>
							
								<option value="<?php echo $rcat->room_cat_id;?>" <?php if ($rcat->room_cat_id == $rate->room_cat_id ) { ?> selected="selected" <?php } ?> > <?php echo $rcat->room_cat_name ; ?></option>
							<?php }
						}
						else {?> 
								<option value="<?php echo $rcat->room_cat_id; ?>"><?php echo $rcat->room_cat_name; ?></option>
						<?php }
						?>
					</select>
				</div>
				
				
				<div class="form-group">
					<label class="control-label">Room Rates</label>
					<input type="number" placeholder="Room Rates" name="room_rates" maxlength="10" minlength="2"  class="form-control" value="<?php echo $rate->room_rates; ?>"/> 
				</div>
				
				<div class="form-group">
					<label class="control-label">Extra Bed Rates</label>
					<input type="number" placeholder="Extra Room Rates" maxlength="10" minlength="2" name="extra_bed_rate" class="form-control" value="<?php echo $rate->extra_bed_rate; ?>"/> 
				</div>
				
			 
			
				<div class="margiv-top-10">
					<input type="hidden" name="id" value="<?php echo $rate->htr_id;?>"/>
					<button type="submit" class="btn green uppercase edit_roomrates">Save Changes</button>
				</div>
			</form>
			<div id="editHotelRoomRates"></div>		
		<?php }else{
			echo "Invalid Room Rates id";
		}?>
		</div>
	<!-- END CONTENT BODY -->
	</div>
<!-- Modal -->
 </div>


<script type="text/javascript">
jQuery(document).ready(function($){
	/*   jQuery.validator.addMethod("multiemail", function (value, element) {
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
    }, "Please separate valid email addresses with a comma and do not use spaces."); */
	/*get states from country*/
    $("select.country").change(function(){
        var selectCountry = $(".country option:selected").val();
		//console.log(selectCountry);
		$.ajax({
            type: "POST",
            url: "<?php echo base_url('AjaxRequest/hotelStateData'); ?>",
            data: { country: selectCountry } 
        }).done(function(data){
            $("#state_list").html("<div class='form-group'><label>State:</label><select name='state' class='form-control state'>" + data + "</select></div>");
		}).error(function(){
			$("#state_list").html("Error! Please try again later!");
		});
    });
	/*get cities from state*/
	$(document).on('change', 'select.state', function() {
        var selectState = $(".state option:selected").val();
	//	console.log(selectState);
		$.ajax({
            type: "POST",
            url: "<?php echo base_url('AjaxRequest/hotelCityData'); ?>",
            data: { state: selectState } 
        }).done(function(data){
            $("#city_list").html("<div class='form-group'><label>City:</label><select name='city' class='form-control city'>" + data + "</select></div>");
		}).error(function(){
			$("#city_list").html("Error! Please try again later!");
		});
    });
	
	$(document).on('change', 'select.city', function() {
        var selectCity = $(".city option:selected").val();
		$.ajax({
            type: "POST",
            url: "<?php echo base_url('AjaxRequest/hotellistByCityId'); ?>",
            data: { hotel: selectCity } 
        }).done(function(data){
			$("#hotel_list").html("<div class='form-group'><label>Hotel:</label><select name='hotel' class='form-control hotel'>" + data + "</select></div>");
		}).error(function(){
			$("#hotel_list").html("Error! Please try again later!");
		});
    });
	
	
}); 

jQuery(document).ready(function($){
	var form = $("#editRoomRates");
	var resp = $("#editHotelRoomRates");
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
			var formData = $("#editRoomRates").serializeArray();
			//console.log(formData);
			$.ajax({
				type: "POST",
				url: "<?php echo base_url('AjaxRequest/editRoomRates'); ?>" ,
				dataType: 'json',
				data: formData,
				beforeSend: function(){
					resp.html('<p><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
				},
				success: function(res) {
					if (res.status == true){
						resp.html('<div class="alert alert-success"><strong>Success! </strong>'+res.msg+'</div>');
						console.log("done");
						 $("#editRoomRates")[0].reset();
						window.location.href = "<?php echo site_url("hotels/viewroomrates");?>"; 
					}else{
						resp.html('<div class="alert alert-danger"><strong>Error! </strong>'+res.msg+'</div>');
						console.log("error");
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
