<?php if( $itinerary ){
	$iti = $itinerary[0];	
	
	$total_tra = $iti->adults . " Adults"; 
	$total_tra = "Adults: " . $iti->adults; 
	$total_tra .= !empty($iti->child) ? " Child: {$iti->child} ( Age: {$iti->child_age} )" : ""; 
	?>
<div class="page-container tour-info-booking">
	<div class="page-content-wrapper">
		<div class="page-content">
			<div class="portlet box blue mb0">
				<div class="portlet-title">
					<div class="caption">
						<i class="icon-plus"></i>Add  <?php echo $booking_type; ?> Booking Details Flight/Train/Volvo
					</div>
					<a class="btn btn-success" href="<?php echo site_url("itineraries"); ?>" title="Back">Back</a>
				</div>
			</div>
			<style>
				#arr_location-error {bottom: -35px; }
				#drop-error {top: 35px; }
			</style>
			
			<!--Show success message if hotel edit/add -->
			<?php $message = $this->session->flashdata('success'); 
				if($message){ echo '<span class="help-block help-block-success">'.$message.'</span>'; }
			?>
			
			<!--Show Volvo/Train/Flight booking if any-->
			<?php if( isset( $existing_bookings ) && !empty( $existing_bookings ) ){ ?>
				<div class="portlet box blue">
					<div class="portlet-title">
						<div class="caption"><i class="fa fa-calendar"></i>Existing Booking Details</div>
					</div>
				</div>
				<div class="table-responsive">
					<table class="table table-bordered">
						<thead class="thead-default">
							<tr>
								<th>Sr.</th>
								<th> Type </th>
								<th> Iti Id </th>
								<th> Departure Date </th>
								<th> Status </th>
								<th> Action </th>
							</tr>
						</thead>
						<tbody>
							<?php
							$i=1;
							foreach( $existing_bookings as $vtf_book ){
								//Get hotel booking status-->
								if( $vtf_book->booking_status == 9 ){
									$status = "<span class='green'>BOOKED</span>";
								}else if($vtf_book->booking_status == 8){
									$status = "<span class='red'>Declined</span>";
								}else{
									$status = "<span class='blue'>Processing</span>";
								}
								?>
								<tr>
									<td><?php echo $i; ?>.</td>
									<td><?php echo $vtf_book->booking_type; ?></td>
									<td><?php echo $vtf_book->iti_id; ?></td>
									<td><?php echo $vtf_book->dep_date; ?></td>
									<td><?php echo $status; ?></td>
									<td><a title='View' href="<?php echo site_url("vehiclesbooking/viewvehiclebooking/{$vtf_book->id}/{$vtf_book->iti_id}"); ?>" class='btn btn-success' ><i class='fa fa-eye' aria-hidden='true'></i></a></td>
								</tr>
							<?php $i++;
							} ?>
						</tbody>
					</table>
				</div>
				<?php } ?>
				<!--End Volvo/Train/Flight booking if any-->
			<!--End if existing booking-->
			<div class="tour_info text-left clearfix">
				<h4 class="text-center">Tour Info (<?php echo  ucfirst($booking_type) . " Booking Details"?>) 
				<a title='View' href="<?php echo site_url("itineraries/view_iti/{$iti->iti_id}/{$iti->temp_key}"); ?> " target="_blank" class='btn btn-success' ><i class='fa fa-eye' aria-hidden='true'></i>View Quotation</a></h4>
				
				<div class="col-md-4"><div class="note note-success"><?php echo "<strong>Total Travellers:</strong> " . $total_tra ."<br>"; ?></div></div> 
				<div class="col-md-8"><div class="note note-success"><?php echo "<strong>Package Routing: </strong> " . $iti->package_routing ."<br>"; ?></div></div>
			</div>
			<form class="form-horizontal" role="form" id="bookTrasVTF">
				<?php if( $booking_type == 'volvo' ){
					$type = "Vovlo";
					// Change form Field Name / Placeholder
					$t_name = "Bus Name";
					$t_name_placeholder = "Bus Name eg. Himsuta Vovlo Bus";
					$t_number = "Bus Number";
					$t_number_placeholder = "Bus number for multi buses use comma to seprate.eg: HP63-5656, HP64-5657";
				}elseif( $booking_type == 'train'  ){
					$type = "Train";
					// Change form Field Name / Placeholder
					$t_name = "Train Name";
					$t_name_placeholder = "Train Name eg. SHATABDI EXPRESS";
					$t_number = "Train Number";
					$t_number_placeholder = "Train number. eg: 01202, 01203";
				}elseif( $booking_type == 'flight' ){
					$type = "Flight";
					// Change form Field Name / Placeholder
					$t_name = "Flight Name";
					$t_name_placeholder = "Flight Name eg. Spicejet Flight";
					$t_number = "Flight Number";
					$t_number_placeholder = "Flight number .eg: AI 0946";
				}else{
					$type = "Invalid Type";
					echo "Invalid Request";
					die;
				} ?>
				
				<div class="col-md-offset-4 col-md-4">
					<div class="form-group2">
					<div class="note note-info">
						<label class="">Booking Type: </label> 
						<select name="inp[booking_type]" class="form-control book_type">
							<option <?php echo $booking_type == 'volvo' ? 'selected="selected"' : ''; ?> value='volvo'>Volvo</option>
							<option <?php echo $booking_type == 'train' ? 'selected="selected"' : ''; ?> value='train'>Train</option>
							<option <?php echo $booking_type == 'flight' ? 'selected="selected"' : ''; ?>  value='flight'>Flight</option>
						</select>
					</div>
					</div>
				</div>
				
				<div class="clearfix"></div>
				
			<div class="col-md-4">
				<div class="form-group2">
					<label class="">Itinerary Id: </label> 
					<input readonly type="text" name="inp[iti_id]" id="iti_id" class="form-control" id="iti_id" value="<?php echo $iti->iti_id; ?>">
				</div>
			</div>
			
			<div class="col-md-4">
				<div class="form-group2">
					<label class="">Customer Name: </label> 
					<input readonly type="text" id="customer_id" class="form-control" value="<?php echo get_customer_name($iti->customer_id); ?>">
					<input type="hidden" name="inp[customer_id]" class="form-control" value="<?php echo $iti->customer_id; ?>">
				</div>
			</div>
			
			<div class="col-md-4">
				<div class="form-group2">
					<label class=" ">Number of Passengers:</label>
					<input type="text" placeholder="Number of Passengers" name="inp[total_travellers]" class="form-control cab_rate " value="<?php echo $total_tra; ?>"/>
				</div> 
			</div>
			
			<div class="clearfix"></div>
			<div class="col-md-4">
				<div class="form-group2">
					<label class=""><?php echo $t_name; ?>: </label> 
						<input type="text" data-toggle="tooltip" placeholder="<?php echo $t_name; ?>" title="<?php echo $t_name_placeholder;?>" name="inp[t_name]" class="form-control" value=""/>
				</div>
			</div>
			
			<div class="col-md-4">
				<div class="form-group2">
					<label class=" "><?php echo $t_number;?>:</label>
					<input type="text" data-toggle="tooltip" placeholder="<?php $t_number; ?>" title="<?php echo $t_number_placeholder; ?>" name="inp[t_number]" class="form-control" value=""/>
				</div> 
			</div>
				
			<div class="col-md-4">
				<div class="form-group2">
					<label class="">Class Type: </label> 
					<select required name="inp[class_type]" class="form-control class_type ">
						<option value=''>Select Type</option>
						<?php if( $booking_type == 'volvo'){ ?>
							<option value='AC'>AC</option>
							<option value='NON/AC'>NON/AC</option>
							<option value='ordinary'>Ordinary</option>
							<option value='other'>other</option>
						<?php }elseif( $booking_type == 'train' ){  ?>
							<option value='First Class'>First Class</option>
							<option value='AC First Class'>AC First Class</option>
							<option value='AC 2-Tier'>AC 2-Tier</option>
							<option value='AC 3-Tier'>AC 3-Tier</option>
							<option value='AC Chair Car'>AC Chair Car</option>
							<option value='Second Sitting'>Second Sitting</option>
							<option value='Sleeper'>Sleeper</option>
							<option value='other'>other</option>
						<?php }elseif( $booking_type == 'flight' ){ ?>	
							<option value='Economy Class'>Economy Class</option>
							<option value='Business Class'>Business Class</option>
							<option value='First Class'>First Class</option>
							<option value='Other'>Other</option>
						<?php } ?>
					</select>
				</div>
			</div>
			
			<div class="clearfix"></div>
			<div class="col-md-4">
				<div class="form-group2">
					<label class="">Departure / Arrival Date*: </label> 
					<div class="clearfix"></div>
					<div class="input-group date-picker input-daterange  " data-date="" data-date-format="yyyy-mm-dd">
						<span class="input-group-addon"> Dep. </span>
						<input required readonly type="text" class="form-control" name="inp[dep_date]" value="" id="check_in" >
						<span class="input-group-addon"> Arr. </span>
						<input required readonly type="text" class="form-control" name="inp[arr_date]" value="" id="check_out" > 
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group2">
					<label class=" ">Departure/Arrival Time*</label>
					<div class="input-group">
						<span class="input-group-addon"> Dep. </span>
						<input required name="inp[dep_time]" type="text" class="form-control timepicker timepicker-no-seconds" value=""/>
						<span class="input-group-addon"> Arr. </span>
						<input required name="inp[arr_time]" type="text" class="form-control timepicker timepicker-no-seconds" value=""/>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group2">
					<label class=" ">Seat Numbers:</label>
					<textarea data-toggle="tooltip" placeholder="Seat number" title="Seat Number Seprated by Comma eg. 23,32,2. For Multi transporter use vehicle number eg: HP-63 6564(2,3,4,5), HP-63 6565(2,3,5)" name="inp[seat_numbers]" class="form-control"></textarea>
				</div> 
			</div>
			<div class="clearfix"></div>
			
			<div class="col-md-6">
				<div class="form-group2">
					<label class=" ">Departure/Arrival Location*</label>
					<div class="input-group">
						<span class="input-group-addon"> Dep. Location </span>
						<input type="text" required name="inp[dep_loc]" id="arr_location" placeholder="Departure Location" class="form-control" value="">
						<span class="input-group-addon"> Arr. Location</span>
						<input type="text" required name="inp[arr_loc]" id="drop" placeholder="Arrival Location" class="form-control" value="">
					</div>
				</div>
			</div>			
			<div class="col-md-3">
				<div class="form-group2">
					<label class=" ">Ticket Numbers:</label>
					<textarea  data-toggle="tooltip" placeholder="Ticket number" title="For Multi transporter use vehicle number eg: HP-63 6564(tick285,tick286,tick286), HP-63 6565(3332,3433,235)" name="inp[ticket_numbers]" class="form-control"></textarea>
				</div> 
			</div>
			
			<div class="col-md-3">
				<div class="form-group2">
					<label class=" ">Other Info:</label>
					<textarea placeholder="Booking other info" name="inp[other_info]" class="form-control"></textarea>
				</div> 
			</div>
			
			<div class="clearfix"></div>
			
			<div class="col-md-3">
					<div class="form-group2">
						<label >Number of Seats: </label>
							<select required name="inp[total_seats]" class="form-control total_seats ">
								<option value=''>Select Seats</option>
							<?php for( $i=1 ; $i<=50; $i++ ){
								echo '<option value=' . $i . '> '. $i . '</option>';
							} ?>
							</select>
					</div>
			</div>
			
			<div class="col-md-3">
				<div class="form-group2">
					<label class=" ">Cost per/seat:</label>
					<input type='number' required data-toggle="tooltip" placeholder="Cost Per/seat" title="Cost Per Seat" name="inp[cost_per_seat]" class="form-control cost_per_seat">
				</div> 
			</div>
			
			<!--div class="col-md-3">
				<div class="form-group2">
					<label class=" ">Total Cost:</label>
					<input type='number' readonly required data-toggle="tooltip" placeholder="Total Cost" title="Total Cost" class="form-control t_cost_per_seat">
				</div> 
			</div-->
			
			<div class="col-md-3">
				<div class="form-group2">
					<div class="mt-checkbox-list">
					<label for="return_ticket" class="mt-checkbox mt-checkbox-outline">Return ticket:
						<input type="checkbox" id="return_ticket" value="yes" class="return_ticket">
					<span></span>	
					</label>
					</div>
				</div>
			</div>
			
				<!--Return Ticket Process-->
				<div id="return">
					<div class="clearfix"></div>	
					<div class="col-md-3">
						<div class="form-group2">
							<label class=""><?php echo $t_name; ?> (Return Trip): </label> 
								<input required type="text" data-toggle="tooltip" placeholder="<?php echo $t_name; ?>" title="<?php echo $t_name_placeholder; ?>" name="inp[return_t_name]" class="form-control clearfield" value=""/>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group2">
							<label class=" "><?php echo $t_number; ?> (Return Trip):</label>
							<input type="text" data-toggle="tooltip" placeholder="<?php echo $t_number; ?> " title="<?php echo $t_number_placeholder; ?>" name="inp[return_t_number]" class="form-control clearfield" value=""/>
						</div> 
					</div>	
					<div class="col-md-3">
				<div class="form-group2">
					<label class="">Class Type (Return Trip): </label> 
					<select required name="inp[return_class_type]" class="form-control clearfield return_booking_type ">
						<option value=''>Select Type</option>
						<?php if( $booking_type == 'volvo'){ ?>
							<option value='AC'>AC</option>
							<option value='NON/AC'>NON/AC</option>
							<option value='ordinary'>Ordinary</option>
							<option value='other'>other</option>
						<?php }elseif( $booking_type == 'train' ){  ?>
							<option value='First Class'>First Class</option>
							<option value='AC First Class'>AC First Class</option>
							<option value='AC 2-Tier'>AC 2-Tier</option>
							<option value='AC 3-Tier'>AC 3-Tier</option>
							<option value='AC Chair Car'>AC Chair Car</option>
							<option value='Second Sitting'>Second Sitting</option>
							<option value='Sleeper'>Sleeper</option>
							<option value='other'>other</option>
						<?php }elseif( $booking_type == 'flight' ){ ?>	
							<option value='Economy Class'>Economy Class</option>
							<option value='Business Class'>Business Class</option>
							<option value='First Class'>First Class</option>
							<option value='Other'>Other</option>
						<?php }else{ ?>
							<option value='no'>No Type</option>
						<?php } ?>
					</select>
				</div>
				</div>
				
				<div class="col-md-3">
						<div class="form-group2">
							<label class="">Departure Date* (Return trip): </label> 
								<div class="clearfix"></div>
								<input type="text" readonly class="form-control datepicker clearfield" name="inp[return_dep_date]" value="" id="check_out" > 
						</div>
					</div>
					<div class="clearfix"></div>
					
					<div class="col-md-3">
						<div class="form-group">
							<label class=" ">Departure Time (Return trip): </label>
							<input name="inp[return_dep_time]" type="text" class="form-control timepicker timepicker-no-seconds clearfield" value=""/>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group2">
							<label>Departure Location (Return trip): </label>
							<input type="text" data-toggle="tooltip" name="inp[return_dep_loc]" id="return_dep_loc" title="Departure Location eg. (Manali-Shimla)" Placeholder="Departure Location" class="form-control clearfield" value="">
						</div>
					</div>
					<div class="col-md-3">
					<div class="form-group2">
						<label class=" ">Ticket Numbers (Return trip):</label>
						<textarea type="text" data-toggle="tooltip" placeholder="Ticket number" title="(Return Trip) For Multi transporter use vehicle number eg: HP-63 6564(tick285,tick286,tick286), HP-63 6565(3332,3433,235)" name="inp[return_ticket_numbers]" class="form-control clearfield"></textarea>
					</div> 
					</div>
			
					<div class="col-md-3">
						<div class="form-group2">
							<label class=" ">Seat Numbers (Return Trip):</label>
							<textarea type="text" data-toggle="tooltip" placeholder="Seat number" title="(Return Trip) Seat Number Seprated by Comma eg. 23,32,2. For Multi transporter use vehicle number eg: HP-63 6564(2,3,4,5), HP-63 6565(2,3,5)." name="inp[return_seat_numbers]" class="form-control clearfield" ></textarea>
						</div> 
					</div>
					<div class="clearfix"></div>
					
					<div class="col-md-3">
						<div class="form-group2">
							<label class=" ">Cost per/seat (Return Trip):</label>
							<input required type='number' data-toggle="tooltip" placeholder="Cost Per/seat (Return trip)" title="Cost Per Seat" name="inp[cost_per_seat_return_trip]" class="form-control cost_per_seat_return_trip clearfield">
						</div> 
					</div>
					
					<div class="col-md-3">
						<div class="form-group2">
							<label >Number of Seats (Return trip): </label>
								<select required name="inp[return_total_seats]" class="form-control return_total_seats clearfield">
									<option value=''>Select Seats</option>
								<?php for( $i=1 ; $i<=50; $i++ ){
									echo '<option value=' . $i . '> '. $i . '</option>';
								} ?>
								</select>
						</div>
					</div>
					
					<!--div class="col-md-3">
						<div class="form-group2">
							<label class=" ">Total Cost (Return Trip):</label>
							<input required type='number' readonly data-toggle="tooltip" placeholder="Total Cost(Return trip)" title="Total Cost Retrun trip" class="form-control t_cost_per_seat_return_trip">
						</div> 
					</div-->
					
				</div>
				<!--End Return Ticket Process-->
				<div class="clearfix"></div>	
				
				<hr>
				<div class="col-md-12">
					<button type="submit" class="btn green uppercase">Submit</button>
				</div>
				<div id="addresEd"></div>	
				<div class="clearfix"></div>
				<input type="hidden" name="inp[booking_type]" value="<?php echo $booking_type; ?>"/>
				<input type="hidden" name="inp[agent_id]" value="<?php echo $agent_id; ?>"/>
				<!--input type="hidden" name="inp[booking_status]" value="9" /-->
			</form>
		<?php }else{ ?>
			<form role="form" id="searchReqId" >
			<p> No Itineray Selected. If you have not Itinerary please select from here.</p>
			<p><strong class="red">Note:</strong> You can only Book Vehicles of <a href="<?php echo site_url("itineraries");?>">Selected Itinerary</a>. You can book Vehicle only for approved Itinerary.</p>
	<?php } ?>
	<!-- END CONTENT BODY -->
	</div>
	</div>
	
<!-- Modal -->
 </div>
<script type="text/javascript">
jQuery(document).ready(function($){
	$(".book_type").change(function(){
		var _thisVal = $(this).val();
		var iti_id = $("#iti_id").val();
		window.location.href = "<?php echo site_url('vehiclesbooking/addbookingdetails/');?>" + iti_id +"?type=" +_thisVal; 
	});
	//submit form
	$("#bookTrasVTF").validate({
		submitHandler: function(form) {
		var resp = $("#addresEd");
			var formData = $("#bookTrasVTF").serializeArray();
			$.ajax({
				type: "POST",
				url: "<?php echo base_url('vehiclesbooking/volTrainFlight_booking_details'); ?>" ,
				dataType: 'json',
				data: formData,
				beforeSend: function(){
					resp.html('<p><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
				},
				success: function(res) {
					if (res.status == true){
						resp.html('<div class="alert alert-success"><strong>Success! </strong>'+res.msg+'</div>');
						//console.log("done");
						$("#bookTrasVTF")[0].reset();
						//window.location.href = "<?php echo site_url("vehiclesbooking/allvehiclesbookings");?>"; 
						location.reload();
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
<script type="text/javascript">
jQuery(document).ready(function($){
	$("#return").hide();
	var ch_inDate = $("#tra_date").val();
	var ch_outDate = $("#tra_end_date").val();
	
	$('.input-daterange').datepicker({
		startDate: "1d"
	}).on('changeDate', function(ev){
		$('input.datepicker').val("");
		var _thisDate = ev.date;
		var nextDayMin = moment(_thisDate).add(1, 'day').toDate();
		$('input.datepicker').datepicker('setStartDate', nextDayMin);
	});
	$('.datepicker').datepicker({startDate: "1d", format: "yyyy-mm-dd"}); 
	/* Check for Return Ticket */
	$(document).on('click', '.return_ticket', function(e){
		if ($('.return_ticket').is(':checked')) {
      	   $("#return").show();
		}else {
			$("#return").hide();
			clearfield();
      	}
    });
	function clearfield(){
		return $(".clearfield").val("");
	}
});

jQuery(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip({
        placement : 'top'
    });
});
</script>

<script type="text/javascript">
jQuery(document).ready(function($){
		//empty itinerary dropdown on search
		$(document).on("blur", "#search_id",function(){
			$(".select_iti").val("");
		});
		//empty search on change select_iti
		$(document).on("change", ".select_iti",function(){
			$("#search_id").val("");
		});
	$("#searchReqId").validate({
		submitHandler: function(form) {
		var resp = $("#serchRes");
		var select_iti = $(".select_iti").val();
		var _booking_type = $(".booking_type").val();
		var searchId = $("#search_id").val();
		
		if( searchId=='' ){
			sr = select_iti;
		}else{
			sr = searchId;
		}
		if( searchId == '' && select_iti == '' ){
			alert( "Please Enter or select itinerary ID" );
			return false;
		}
			$.ajax({
				type: "GET",
				url: "<?php echo base_url('AjaxRequest/searchItineraryReqId'); ?>" ,
				dataType: 'json',
				data: { id: sr },
				beforeSend: function(){
					resp.html('<p><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
				},
				success: function(res) {
					if (res.status == true){
						resp.html('<div class="alert alert-success"><strong>Redirecting.....</strong></div>');
						//console.log("done");
						//$("#searchReqId")[0].reset();
						$("#searchReqId").fadeOut();
						window.location.href = "<?php echo site_url();?>vehiclesbooking/addbookingdetails/" + res.id + "?type=" +_booking_type; 
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
