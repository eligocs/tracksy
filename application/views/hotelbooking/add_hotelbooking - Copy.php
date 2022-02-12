<div class="page-container">
	<div class="page-content-wrapper">
		<div class="page-content">
			<div class="portlet box blue">
					<div class="portlet-title">
						<div class="caption"><i class="fa fa-hotel"></i>Book Hotel</div>
						<a class="btn btn-success" href="<?php echo site_url("hotelbooking"); ?>" title="Back">Back</a>
					</div>
			</div>		
		<?php if( $itinerary ){
			$iti = $itinerary[0];	
			
			$approved_hotel_cat = $iti->approved_package_category;	
			$total_tra = $iti->adults . " Adults"; 
			$total_tra = "Adults: " . $iti->adults; 
			$total_tra .= !empty($iti->child) ? " Child: {$iti->child} ( Age: {$iti->child_age} )" : ""; ?>
		
		
		<form class="form-horizontal" role="form" id="addHotelRoomRate">
			<div class="tour_info text-left">
				<h1 class="text-center">Tour Info</h1>
				<hr>
				<div class="col-md-4 well"><?php echo "<strong>Book Hotel Category: </strong> " . $approved_hotel_cat ; ?></div> 
				<div class="col-md-4 well"><?php echo "<strong>Itinerary ID: </strong> " . $iti->iti_id; ?></div> 
				<div class="col-md-4 well"><?php echo "<strong>Customer Name: </strong> " . get_customer_name($iti->customer_id); ?></div> 
				<div class="col-md-4 well"><?php echo "<strong>Total Travellers:</strong> " . $total_tra ; ?></div> 
				<div class="col-md-4 well"><?php echo "<strong>Package Routing: </strong> " . $iti->package_routing ; ?></div>
				<div class="col-md-4 well"><?php //echo "<strong>Tour Date:</strong>  " . $iti->travel_date . " - " . $iti->travel_end_date; ?></div>
				<div class="clearfix"></div>
				<br>
			</div>	
			<hr>
			<!--HOTEL Details SECTION-->
			<div class=""><h3>Hotel Details</h3></div>
			<?php $hotel_meta = unserialize($iti->hotel_meta); 
			if( !empty( $hotel_meta ) ){
				$count_hotel = count( $hotel_meta ); ?>
				<div class="table-responsive">
					<table class="table table-bordered">
						<thead class="thead-default">
							<tr class="thead-inverse">
								<th> Hotel Category</th>
								<th> Standard (1 Star)</th>
								<th> Deluxe (2 Star)</th>
								<th> Super Deluxe (3 Star)</th>
								<th> Luxury (4 Star)</th>
							</tr>
						</thead>
						<tbody>
							<?php 
							/* print_r( $hotel_meta ); */
							for ( $i = 0; $i < $count_hotel; $i++ ) {
								echo "<tr><td><strong>" .$hotel_meta[$i]["hotel_location"] . "</strong></td><td>";
									$hotel_standard =  $hotel_meta[$i]["hotel_standard"];
									echo $hotel_standard;
								echo "</td><td>";
									$hotel_deluxe =  $hotel_meta[$i]["hotel_deluxe"];
									echo $hotel_deluxe;
								echo "</td><td>";
									$hotel_super_deluxe =  $hotel_meta[$i]["hotel_super_deluxe"];
									echo $hotel_super_deluxe;
								echo "</td><td>";
									$hotel_luxury =  $hotel_meta[$i]["hotel_luxury"];
									echo $hotel_luxury;
								echo "</td></tr>";
							}
							?>
						</tbody>
					</table>
				</div>	
			<?php } ?>	
			<!--END HOTEL Details SECTION-->
			<div class="clearfix"></div>
			<div class="col-md-4">
				<div class="form-group2 select_city_err">
					<label class="">Enter City*</label>
					<input type="text" required id="hotelcity" class="form-control"  name="hotelcity" value="">
				</div>
			</div>
			<div class="col-md-4">
				<label>Select Hotel*</label> 
				<select required name="hotel" class="form-control">
					<option value="">Select Hotel</option>
					<?php $hotels = get_hotels();
					if($hotels){
						foreach( $hotels as $hotel ){
							$h_name = $hotel->hotel_name;
							$city = get_city_name($hotel->city_id);
							$cat = get_hotel_cat_name($hotel->hotel_category);
							$printD = "{$h_name}  {$cat}  AT ( {$city} )";
							echo '<option value="'. $hotel->id . '">' . $printD .' </option>';
						}
					}else{
						echo '<option value="">No hotel found! Contact your admin.</option>';
					}
					?>
				</select>
			</div>
			
			<div class="col-md-4">
				<label>Room Category*</label> 
				<select required name="room_type" class="form-control">
					<option value="">Select Category</option>
					<?php $roomcat = get_room_categories();
					if($roomcat){
						foreach( $roomcat as $rcat ){
							echo '<option value="'. $rcat->room_cat_id . '">' . $rcat->room_cat_name . '</option>';
						}
					}else{
						echo '<option value="">No category found! Contact your admin.</option>';
					}
					?>
				</select>
			</div>
			<div class="clearfix"></div>
			
			<div class="col-md-4">
				<div class="">
					<label class="">Total Guest*: </label> 
					<div class="clearfix"></div>
					<input type="text" id="total_tral" class="form-control"  required name="total_travellers" value="<?php echo $total_tra; ?>">
				</div>
			</div>	
				
			<div class="col-md-3">
				<div class="form-group2">
					<label class="">Booking Date*: </label> 
					<div class="clearfix"></div>
					<div class="input-group input-daterange">
						<input readonly required type="text" class="form-control" name="check_in" value="" id="check_in" >
						<span class="input-group-addon hotel_addon"> to </span>
						<input readonly required type="text" class="form-control" name="check_out" value="" id="check_out" > 
					</div>
				</div>
			</div>
			<div class="col-md-2">
				<label class=""><strong>Total Nights:</strong></label>
				<input readonly type="text" id="total_nights" class="form-control" value="">
			</div>
			<div class="col-md-3">
				<div class="form-group2">
				<label class="">Meal Plan *</label> 
				<?php $mealPlans = get_all_mealplans();
				if($mealPlans){ ?>
					<select name="meal_plan" required class="form-control">
						<option value="">Choose Meal Plan</option>
							<?php foreach( $mealPlans as $mp ){
								echo '<option value="'. $mp->id . '">' . $mp->name . '</option>';
							} ?>
					</select>
				<?php }else{ ?>
					<input type="text" required readonly class="form-control" placeholder="You need to add meal plan to proceed." value="">
					<a href="<?php echo base_url("hotels/addmealplan"); ?>" title="Add Meal Plan">Click here to add Meal Plan</a>
				<?php } ?>
			</div>
			</div>
					
					
					
				<div class="col-md-4">
					<div class="form-group2">
						<label  >Inclusion: </label>
						<textarea type="text" name="inclusion" placeholder="Inclusion" class="form-control"></textarea>	
					</div>
				</div>
				
				
				
				<div class="col-md-3">
				<div class="form-group2">
					<label class=" ">Room Rate(Per/room)*: </label>
					<input type="text" required placeholder="Room Rate" name="room_rates" class="form-control room_rates clearfield price_input" value=""/>
				</div> 
				</div>

		 
				<div class="col-md-2">
				<div class="form-group2">
					<label >Total Rooms*: </label>
						<select required name="total_rooms" class="form-control total_rooms clearfield">
							<option value=''>Select Rooms</option>
						<?php for( $i=1 ; $i<=15; $i++ ){
							echo '<option value=' . $i . '> '. $i . '</option>';
						} ?>
						</select>
					<label for="extra_bed_check"><input type="checkbox" id="extra_bed_check" name="extra_bed_check" value="Yes">Click Here to Add extra bed.</label>
				</div>
				</div>
				<div class="col-md-3">
					<label >Total Room Cost for 1 Night*: </label>
					<div class="form-group2">	
					<input class="form-control total_room_rates clearfield" readonly required type="text" name="total_room_rates" value="0" id="total_room_rates">	
					</div>	
				</div>	
				
				<div class="clearfix"></div>
				<div class="extra_bed_section">
					<div class="col-md-4">
					<label class=" " >Extra Bed Rate (Per/bed)*: </label> 
						<input required type="text" id="extra_bed_rate" name="extra_bed_rate" placeholder="Extra Bed Charges" class="form-control extra_bed_rate clearfield price_input" value=""/>
					</div>
				
						<div class="col-md-4">
						<label class=" " >Extra Bed*: </label> 
						<select required name="extra_bed" class="form-control extra_bed clearfield">
							<option value="">Select Rooms First</option>
						</select>
						</div>
					
					
						<div class="col-md-4">
					<label >Total Bed Cost for 1 Night*: </label>
					<div class="form-group2">	
					<input class="form-control clearfield" type="text" name="total_ex_bed_rate" value="0" id="total_ex_bed_rate" readonly />	
					</div>	
					</div>
				</div>
					
				<div class="clearfix"></div>
				
				<div class="col-md-3">
					<div class="form-group2">
						<label class=" "><strong>Inclusion Charges:</strong></label>
						<input class="form-control price_input" id="extra_charges" type="number" placeholder="eg: 100" name="extra_charges" value="" />
					</div>	 
				</div>	 
				
				
					
				
				<div class="col-md-3">
					<div class="form-group2">
						<label class=" "><strong>Hotel Tax:</strong></label>
						<input class="form-control price_input" id="hotel_tax" type="number" placeholder="eg: 100" name="hotel_tax" value="0" />
					</div>	 
				</div>	 
					<div class="col-md-3">
						<label class=""><strong>Total Cost:</strong></label>
						<a href="javascript: void(0)" id="calculate_cost">Calculate</a>
						<input readonly class="form-control clearfield price_input" id="total_cost" type="number" name="total_cost" value="">
					</div>
					<div class="clearfix"></div>	
				
			  
				<input type="hidden" name="customer_id" value="<?php echo $iti->customer_id; ?>">
				<input type="hidden" name="iti_id" value="<?php echo $iti->iti_id; ?>">
				<input type="hidden" name="agent_id" value="<?php echo $agent_id; ?>">
				<div class="margiv-top-10 col-md-12 text-right">
					<button type="submit" class="btn green uppercase add_hotel">Save and Exit</button>
				</div>
				<div class="margiv-top-10 col-md-12 text-right">
					<button type="submit" class="btn green uppercase save_and_continue">Save and Continue</button>
				</div>
				<div class="clearfix"></div>
				<div id="addresEd"></div>	
			
			</form>
			</div>
		<?php } ?>
	<!-- END CONTENT BODY -->
	</div>
</div>
<script type="text/javascript">
/* Calculate Total Cost for Hotel Booking */
jQuery(document).ready(function($){
	//Prevent Dot from number field
	$(".price_input").on('keyup keypress', function(e) {
		var keyCode = e.keyCode || e.which;
		if (keyCode === 46) { 
			e.preventDefault();
			return false;
		}
	});
	
	function resetAllfields() {
		$('.clearfield').val('');
		$(".total_rooms").attr("disabled", "disabled");
		$("#extra_bed_check").attr("disabled", "disabled");	
		$(".extra_bed").attr("disabled", "disabled");	
		$("#check_in").val("");
		$("#check_out").val("");
	}
	
	//Get Total Nights on datepicker change
	var today = new Date();
	$('.input-daterange').daterangepicker({
		locale: {
		  format: 'YYYY-MM-DD'
		},
		startDate: new Date(today.getFullYear(), today.getMonth(), today.getDate()),
		minDate:today
	}, 
	function(start, end, label) {
		var starD = start.format('YYYY-MM-DD');
		var endD = end.format('YYYY-MM-DD');
		$('#check_in').val(starD);
		$('#check_out').val(endD);
		
		var nights = calculateNights(starD, endD);
		//console.log(nights);
		$("#total_nights").val(nights);
		$("#total_cost").val("");
		//alert("A new date range was chosen: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
	});
	
	
	//calculate total nights
	function calculateNights(start_Date , End_Date){
		if(jQuery.type(start_Date) === "undefined" && jQuery.type(End_Date) === "undefined"){
			return false;
		}else{
			var startDate = Date.parse(start_Date);
            var endDate = Date.parse(End_Date);
            var timeDiff = endDate - startDate;
            daysDiff = Math.floor(timeDiff / (1000 * 60 * 60 * 24));
			return daysDiff;
		}	
	}
	/*calculate total cost*/
	$(document).on("click", "#calculate_cost", function(){
		var _total = $("#total_cost"), tc = 0, tt=0, total=0,
			tn = $("#total_nights").val(),
			inc_charge = $("#extra_charges").val(),
			rc = $("#total_room_rates").val(),
			exbed = $("#total_ex_bed_rate").val();
		var total_nights = tn < 1 ? 1 : tn;	
		var inclu_charges = inc_charge < 1 ? 0 : inc_charge;	
		var total_room_cost = rc < 1 ? 0 : rc;	
		var extra_bed_cost = exbed < 1 ? 0 : exbed;	
		
		var total_nights = parseInt(total_nights),
			inclu_charges = parseFloat(inclu_charges),
			total_room_cost = parseFloat(total_room_cost),
			extra_bed_cost = parseFloat(extra_bed_cost),
			hotel_tax = parseFloat($("#hotel_tax").val());
			
		
		if( tn == 0 || tn == "" ){
			alert("Please Select valid check_in and check_out dates");
			$("#check_in").focus();
			return false;
		}
		
		/*calculate total cost*/
		tc = total_room_cost + extra_bed_cost;
		tt = tc * total_nights;
		total = inclu_charges + tt + hotel_tax;
		_total.val( total.toFixed(0) );
	});
	/* total rooms cost */
	$(document).on("change", ".total_rooms", function(){
		var roomRate = $(".room_rates").val();
		if( roomRate == "" || roomRate == 0 ){
			alert("Please Add room rate first!");
			$(".room_rates").focus();
			$(this).val("");
			return false;
		}	
		var room_rate = parseFloat($(".room_rates").val());
		var _this = $(this),
		total = _this.val()*room_rate;
		$("#total_room_rates").val(total.toFixed(0) );
		$("#total_cost").val("");
	});
	$(document).on("change", ".room_rates", function(){ $(".total_rooms").val("") });
	$(document).on("change", "#extra_bed_rate", function(){ $(".extra_bed").val("") });
	/* .extra_bed cost */
	$(document).on("change", ".extra_bed", function(){
		var _this = $(this),
		eRate = $("#extra_bed_rate").val(),
		extra_bed_rate = parseFloat(eRate);
		if( eRate == "" || eRate == 0 ){
			alert("Please Add extra bed rate rate first!");
			$("#extra_bed_rate").focus();
			$(this).val("");
			return false;
		}
		var total = _this.val()*extra_bed_rate;
		$("#total_ex_bed_rate").val(total.toFixed(0));
		$("#total_ex_bed_rate").attr("value", total.toFixed(0));
		$("#total_cost").val("");
	});
	
	/* Inclusion Charges */
	$(document).on("blur", ".price_input", function(){
		$("#total_cost").val("");
		var _this = $(this).val();
		var value = parseFloat($(this).val());
		if( value < 0 || $.isNumeric( $(this).val() ) == false ){
			alert("Please enter positive numeric value");
			$(this).val(0);
			$(this).attr('value', 0);
			$(this).attr('value', value);
		}else{
			if( _this != '' ){
				$(this).attr('value', value);
			}else{
				$(this).val(0);
				$(this).attr('value', 0);
			}
		}
	});
}); 
</script>

<script type="text/javascript">
jQuery(document).ready(function($){
	$(document).on("change", ".total_rooms", function(){ 
		$("#total_ex_bed_rate").val("");
		var total_rooms = $(this).val();
		var ext_beds = $(".extra_bed");
		ext_beds.html("<option value=''>Select extra beds</option>");
		for( var i=1; i<= total_rooms; i++){
			ext_beds.append( "<option value=" + i + ">"+ i + "</option>");
		} 
	});
	/* Check for extra bed */
	$(document).on('click', '#extra_bed_check', function(e){
		$("#total_ex_bed_rate, #total_cost,.extra_bed, #extra_bed_rate ").val("");
		if ($('#extra_bed_check').is(':checked')) {
      	   $(".extra_bed_section").show();
		   $(".extra_bed_rate").addClass("ex_rate");
		} else {
			$(".extra_bed_rate").removeClass("ex_rate");
			$(".extra_bed_section").hide();
      	}
    });
	$(".extra_bed_section").hide();
	
	//Submit form
	var ajaxReq;
	$("#addHotelRoomRate").validate({
		rules: {
			total_cost: {required: true, number: true },
		},
		submitHandler: function(form) {
			var resp = $("#addresEd");
			var formData = $("#addHotelRoomRate").serializeArray();
			//console.log( formData );
			if (ajaxReq) {
				ajaxReq.abort();
			}
			
			ajaxReq = $.ajax({
				type: "POST",
				url: "<?php echo base_url('hotelbooking/ajax_book_hotel'); ?>" ,
				dataType: 'json',
				data: formData,
				beforeSend: function(){
					resp.html('<p><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
				},
				success: function(res) {
					if (res.status == true){
						resp.html('<div class="alert alert-success"><strong>Success !</strong> ' + res.msg + '</div>');
						//console.log("done");
						$("#addHotelRoomRate")[0].reset();
						//window.location.href = "<?php echo site_url("hotelbooking");?>"; 
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

<script type="text/javascript">
 jQuery(document).ready(function($){
	function resetAllValues() {
		$('.clearfield').val('');
		$(".total_rooms").attr("disabled", "disabled");
		$("#extra_bed_check").attr("disabled", "disabled");	
		$(".extra_bed").attr("disabled", "disabled");	
	}
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
    }, "Please separate valid email addresses with a comma and do not use spaces.");
	/* get Hotels from City */
	$(document).on('change', 'select.hotel', function() {
		$(".roomcat").removeAttr("disabled");
		$(".roomcat").val("");
		resetAllValues();
	});	
	
	/*get Hotels Rate By Hotel ID from City*/
	$(document).on('change', 'select.roomcat', function() {
		/* $("#total_cost").val("");
		$(".total_rooms").val(""); */
		resetAllValues();
        var room_cat = $(".roomcat option:selected").val();
        var hotel_id = $(".hotel").val();
		if( room_cat == "" ){
			alert("Please Select Room Category!");
			$("input[name='room_rates']").val("");
			$("input[name='extra_bed_rate']").val("");
			$(".total_rooms").attr("disabled", "disabled");
			$("#extra_bed_check").attr("disabled", "disabled");	
			$(".extra_bed").attr("disabled", "disabled");	
		}else{
			$.ajax({
				type: "POST",
				dataType: 'json',
				url: "<?php echo base_url('AjaxRequest/get_rooms_rates'); ?>",
				data: { room_cat : room_cat, hotel_id : hotel_id },
				beforeSend: function(){
					
				},
				success: function(res){
					if(res.status = true){
						var rr = res.room_rate;
						var ex = res.extra_bed;
						if( typeof(rr) === "undefined" && typeof(ex) === "undefined" ){
							alert("Select other hotel/room category or Contact Administrator/Manager.Because Room Rate Not Found!.");
							$(".total_rooms").attr("disabled", "disabled");
							$("#extra_bed_check").attr("disabled", "disabled");	
							$(".extra_bed").attr("disabled", "disabled");	
							$("input[name='room_rates']").val("");
							$("input[name='extra_bed_rate']").val("");
						}else{
							$(".total_rooms").removeAttr("disabled");
							$("#extra_bed_check").removeAttr("disabled");
							$(".extra_bed").removeAttr("disabled");
							$("input[name='room_rates']").val(rr);
							$("input[name='extra_bed_rate']").val(ex);
						}	
						//console.log(rr);
						//console.log(ex);
					}else{
						//console.log( "error" );
						alert("Select other hotel/room category or Contact Administrator/Manager.");
					}
				},
				error: function(){
					//console.log( "error 1 " );
					alert("Before you proceed please add room rate! or Contact Administrator/Manager.");
				}
			});
		}	
    }); 
	
}); 
 
</script>
