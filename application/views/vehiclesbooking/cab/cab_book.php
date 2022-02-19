<div class="page-container">
	<div class="page-content-wrapper">
		<div class="page-content">
		<div class="portlet box blue">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-bus"></i>Book Cab
				</div>
				<a class="btn btn-success" href="<?php echo site_url("vehiclesbooking"); ?>" title="Back">Back</a>
			</div>
		</div>
		<?php if( $itinerary ){

		$iti = $itinerary[0];	
		
		$total_tra = $iti->adults . " Adults"; 
		$total_tra = "Adults: " . $iti->adults; 
		$total_tra .= !empty($iti->child) ? " Child: {$iti->child} ( Age: {$iti->child_age} )" : ""; 
		?>
		<div class="custom_card">
		<div class="tour_info text-left">
			<h1 class="text-center">Tour Info</h1>
			<div class="col-md-4 note note-success"><?php echo "<strong>Cab Category:</strong>  " . get_car_name($iti->cab_category); ?></div>
			<div class="col-md-4 note note-success"><?php echo "<strong>Total Travellers:</strong> " . $total_tra ."<br>"; ?></div> 
			<div class="col-md-4 note note-success"><?php echo "<strong>Package Routing: </strong> " . $iti->package_routing ."<br>"; ?></div>
			<div class="col-md-4 note note-success"><?php echo "<strong>Itinerary Id:</strong>  " . $iti->iti_id ; ?></div>
		</div>	
		<div class="clearfix"></div>
		</div>

		<hr>
		
		<div class="custom_card">

		<!--Show hotel booking if any-->
			<?php if( $existing_bookings ){  ?>
			<div class="portlet box blue">
				<div class="portlet-title">
					<div class="caption"><i class="fa fa-calendar"></i>Existing Cab Booking Against This Itinerary</div>
				</div>
			</div>
			<div class="table-responsive">
				<table class="table table-bordered table-hover">
					<thead class="thead-default">
						<tr>
							<th> Cab </th>
							<th> Transporter Name </th>
							<th> Routing </th>
							<th> Sent Status </th>
							<th> Status </th>
							<th> Action </th>
						</tr>
					</thead>
					<tbody>
						<?php foreach( $existing_bookings as $c_book ){
							//Get hotel booking status-->
							if( $c_book->booking_status == 9 ){
								$status = "<span class='green'>BOOKED</span>";
							}else if($c_book->booking_status == 8){
								$status = "<span class='red'>Declined</span>";
							}else if( $c_book->booking_status == 7 ){
								$status = "<strong class='red'><i class='fa fa-window-close' aria-hidden='true'></i> &nbsp;Canceled</strong>";
							}else{
								$status = "<span class='blue'>Processing</span>";
							}
							?>
							<tr>
								<td><?php echo get_car_name($c_book->cab_id); ?></td>
								<td><?php echo get_transporter_name($c_book->transporter_id); ?></td>
								<td><?php echo $c_book->pic_location . " - " . $c_book->drop_location; ?></td>
								<td><?php echo $c_book->email_count . " Time Sent"; ?></td>
								<td><?php echo $status; ?></td>
								<td><a title='View' href="<?php echo site_url("vehiclesbooking/viewbooking/{$c_book->id}"); ?>" class='btn_eye' ><i class='fa fa-eye' aria-hidden='true'></i></a></td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>	
			<?php } ?>
			<!--End hotel booking if any-->
		
		<form class="form-horizontal" role="form" id="BookCab">
			<div class="col-md-4">
			<div class="form-group2">
				<label class="">Select Vehicle*</label>
				<select required name="inp[cab_id]" class="form-control vehicle col-md-4">
					<option value="">Choose Vehicle</option>
					<?php $cars = get_car_categories(); 
						if( $cars ){
							foreach($cars as $car){
								echo '<option value = "'.$car->id .'" >'.$car->car_name.'</option>';
							}
						}else{
							echo '<option value="">No vehicle available. </option>';
						}
					?>
				</select>
			</div>
			</div>
			<div class="col-md-4">
				<div class="transporter_list">
					<label>Select Transporter*</label> 
					<select disabled required name="inp[transporter_id]" class="form-control transporter">
						<option value="">Select Transporter</option>
					</select>
					<div class="rhRes"></div>
				</div>
			</div>

			<div class="col-md-4">
					<div class="form-group2">
					<label class="">Total Travellers*: </label> 
					<input type="text" required class="form-control" name="inp[total_travellers]" value="<?php echo $total_tra; ?>">
				</div>
			</div>
				<div class="clearfix"></div>
				<div class="col-md-4">
					<div class="form-group2">
						<label class="">Booking Date*: </label> 
						<div class="clearfix"></div>
						<div class="input-group input-daterange">
							<input readonly required type="text" class="form-control" name="inp[picking_date]" value="" id="check_in" >
							<span class="input-group-addon hotel_addon"> to </span>
							<input readonly required type="text" class="form-control" name="inp[droping_date]" value="" id="check_out" > 
						</div>
					</div>
				</div>
				
				<div class="col-md-4">
				<div class="form-group">
					<label class="control-label">Reporting/Departure Time*</label>
					<div class="input-group input-large">
						<span class="input-group-addon"> Rep. </span>
						<input name="inp[reporting_time]" type="text" class="form-control timepicker timepicker-no-seconds" value=""/>
						<span class="input-group-addon"> Dep.</span>
						<input name="inp[departure_time]" type="text" class="form-control timepicker timepicker-no-seconds" value=""/>
					</div>
				</div>
				</div>
				<div class="col-md-4">
					<div class="form-group2">
						<label class="">Booking Duration*: </label> 
						<input type="text" readonly required name="inp[booking_duration]" id="booking_duration" class="form-control" value="">
					</div>
				</div>
				<div class="clearfix"></div>
				<div class="col-md-4">
					<div class="form-group2">
					<label class="">Picking Location*</label> 
					<input type="text" required name="inp[pic_location]" id="pic_location" placeholder="Picking Location" class="form-control" value="">
				</div>
				</div>
			
				<div class="col-md-4">
					<div class="form-group2">
						<label>Dropping Location*: </label>
						<input type="text" required name="inp[drop_location]" id="drop_location" placeholder="Droping Location" class="form-control" value="">
					</div>
				</div>
				
				<div class="clearfix"></div>
				
				<div class="col-md-4">
				<div class="form-group2">
					<label class=" ">Cab Rate (Per/day)*: </label>
					<input required type="text" placeholder="Cab Rate" name="inp[cab_rate]" class="form-control cab_rate clearfield" value="0"/>
				</div> 
				</div>
		 
				<div class="col-md-4">
				<div class="form-group2">
					<label >Total Cabs*: </label>
						<select required disabled name="inp[total_cabs]" class="form-control total_cabs clearfield">
							<option value=''>Select Cabs</option>
						<?php for( $i=1 ; $i<=10; $i++ ){
							echo '<option value=' . $i . '> '. $i . '</option>';
						} ?>
						</select>
				</div>
				</div>
				<div class="col-md-4">
				<div class="form-group2">
					<label >Total Cabs Cost (per/day)*: </label>
						<input readonly required type="text" placeholder="Cab Total Cost per/day" id ="cab_total_cost" class="form-control cab_total_cost clearfield" value=""/>
				</div>
				</div>
				<div class="clearfix"></div>
				<div class="col-md-4">
				<div class="form-group2">
					<label class=" "><strong>Inclusion Charges:</strong></label>
					 <input class="form-control" id="extra_charges" type="text" placeholder="eg. 100" name="inp[extra_charges]" value="0">
				</div>	 
				</div>
				<div class="col-md-4">
					<label class=""><strong>Total Days*:</strong></label>
					<input readonly type="text" required id="total_days" class="form-control" value="0">
				</div>
				<div class="col-md-4">
					<label class=""><strong>Total Cost*:</strong></label>
					<a href="javascript: void(0)" id="calculate_cost">Calculate</a>
					<input readonly class="form-control clearfield" required id="total_cost" type="number" name="inp[total_cost]" value="">
				</div>
				<hr>
				
				<div class="margiv-top-10 col-md-12 text-right">
					<button type="submit" data-click_val="9" class="btn green uppercase add_hotel bookbtn">Save and Exit</button>
					<button type="submit" data-click_val="8" class="btn green uppercase save_and_continue bookbtn">Save and Continue</button>
				</div>
				
				<div class="clearfix"></div>
				<div id="addresEd"></div>	
				<input type="hidden" name="inp[customer_id]" value="<?php echo $iti->customer_id; ?>">
				<input type="hidden" name="inp[iti_id]" value="<?php echo $iti->iti_id; ?>">
				<input type="hidden" name="inp[agent_id]" value="<?php echo $agent_id; ?>">
				<input type="hidden" id="submit_type" value="9">
			</form>
		<?php }else{
			redirect(404);
		} ?>
			</div>

		
	<!-- END CONTENT BODY -->
	</div>
	</div>
	
<!-- Modal -->
 </div>
</div>

<script type="text/javascript">
/* Calculate Total Cost for Cab Booking */
jQuery(document).ready(function($){
	
	//Get click val
	$(document).on("click", ".bookbtn", function(){
		var data_click = $(this).attr("data-click_val");
		$("#submit_type").val( data_click );
	});
	
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
		
		var days = calculateNights(starD, endD);
		//console.log(days);
		$("#booking_duration,#total_days").val( days+1 );
		$("#total_cost").val("");
		//alert("A new date range was chosen: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
	});
	
	
	//calculate total days
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
		var picking_time = $("#check_in").val();
		if( picking_time == '' ){
			alert("Please select picking and droping time");
		}		
		var _total = $("#total_cost"), tc = 0, tt=0, total=0;
		var tn = $("#total_days").val(),
			inc_charge = $("#extra_charges").val(),
			rc = $("#cab_total_cost").val();
		var total_days = tn < 1 ? 1 : tn;	
		var inclu_charges = inc_charge < 1 ? 0 : inc_charge;	
		var total_cab_cost = rc < 1 ? 0 : rc;	
		
		var total_days = parseInt(total_days);
		var inclu_charges = parseFloat(inclu_charges);
		var total_cab_cost = parseFloat(total_cab_cost);
	
		/*calculate total cost*/
		tc = total_cab_cost;
		tt = tc * total_days;
		total = inclu_charges + tt;
		_total.val(total);
		console.log( total );
	});
	
	//cab_rate blur
	$(document).on("blur", ".cab_rate", function(){
		$("#total_cost").val("");
		var _this = $(this).val();
		$(".total_cabs").removeAttr("disabled");
		var total_cabs =  $(".total_cabs").val() != "" ? parseInt( $(".total_cabs").val() ) : 1;
		//console.log( total_cabs );
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
			
			total = total_cabs*value;
			$("#cab_total_cost").val(total);
		}
	});
	
	/* total cabs cost */
	$(document).on("change", ".total_cabs", function(){
		var room_rate = parseFloat($(".cab_rate").val());
		var _this = $(this), _val = parseInt(_this.val()),
		total = _val*room_rate;
		if( _val > 0){
			$("#cab_total_cost").val(total);
			$("#total_cost").val("");
			
		}else{
			$("#cab_total_cost").val("");
			$("#total_cost").val("");
		}
	});
	/* .extra_bed cost */
	$(document).on("change", ".extra_bed", function(){
		var _this = $(this),
		extra_bed_rate = parseFloat($("#extra_bed_rate").val());
		var total = _this.val()*extra_bed_rate;
		$("#total_ex_bed_rate").val(total);
		$("#total_ex_bed_rate").attr("value", total);
		$("#total_cost").val("");
	});
	
	/* Inclusion Charges */
	$(document).on("blur", "#extra_charges", function(){
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
	function resetAllValues() {
		$('.clearfield').val('');
		$(".total_cabs").attr("disabled", "disabled");
	}
	/* get Transporter By Vehicles */
    $("select.vehicle").change(function(){
		resetAllValues();
		var vehicle = $(".vehicle option:selected").val();
		
		$.ajax({
            type: "POST",
            url: "<?php echo base_url('AjaxRequest/gettransporter_by_vec_id'); ?>",
            data: { vec_id: vehicle } ,
			dataType: 'json',
			beforeSend: function(){
				
			},
			success: function(res){
				if(res.status == true){
					$(".transporter").removeAttr("disabled").html(res.trans);
					
					var rr = res.cabrate;
					if( typeof(rr) === "undefined" ){
						alert("Cab rate not defined please Contact Administrator/Manager.");
						$(".cab_rate").val('');
					}else{
						$(".cab_rate").val(rr);
					}	
					
				}else{
					$(".transporter").html('<option value="">Select Transporter.</option>');
					$(".cab_rate").val('');
				}
				
			},
			error: function(){
				$("#transporter_list").html("Error! Please try again later!");
			}
        });
    });
	
	/*get transporters*/
	$(document).on('change', 'select.transporter', function() {
		$(".total_cabs").val("");
		$(".total_cabs").removeAttr("disabled");
	});	
	
	//submit form
	$("#BookCab").validate({
		submitHandler: function(form) {
		var resp = $("#addresEd"),
		submit_type = $("#submit_type").val();
			var formData = $("#BookCab").serializeArray();
			$.ajax({
				type: "POST",
				url: "<?php echo base_url('vehiclesbooking/ajax_book_cab'); ?>" ,
				dataType: 'json',
				data: formData,
				beforeSend: function(){
					LOADER.show();
					resp.html('<p><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
				},
				success: function(res) {
					LOADER.hide();
					if (res.status == true){
						resp.html('<div class="alert alert-success"><strong>Success! </strong>'+res.msg+'</div>');
						//console.log("done");
						$("#BookCab")[0].reset();
						if( submit_type == 9 )
							window.location.href = "<?php echo site_url("vehiclesbooking/viewbooking/");?>" + res.booking_id; 
						else
							location.reload();	
						
					}else{
						resp.html('<div class="alert alert-danger"><strong>Error! </strong>'+res.msg+'</div>');
						//console.log("error");
					}
				},
				error: function(e){
					LOADER.hide();
					//console.log(e);
					resp.html('<div class="alert alert-danger"><strong>Error!</strong> Please Try again later! </div>');
				}
			});
			return false;
		}
	});	
	
}); 
</script>