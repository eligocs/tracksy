<div class="page-container">
	<div class="page-content-wrapper">
		<div class="page-content">
			<?php $message = $this->session->flashdata('success'); 
				if($message){ echo '<span class="help-block help-block-success">'.$message.'</span>'; }
			?>
			<?php $cab_booking = $cab_booking[0];  ?>
			<?php if($cab_booking){ ?>
				
				<div class="portlet box blue">
					<div class="portlet-title">
						<div class="caption"><i class="fa fa-users"></i>Transporter Name: <strong><?php echo get_transporter_name($cab_booking->transporter_id); ?></strong></div>
						<a class="btn btn-success" href="<?php echo site_url("vehiclesbooking"); ?>" title="Back">Back</a>
						<a class="btn btn-danger pull-right" target="_blank" style="margin: 3px;" href="<?php echo iti_view_single_link($cab_booking->iti_id); ?>" title="View Itinerary">View Itinerary</a>
						
					</div>
				</div>
				
				<!-- SHOW CAB BOOKING STATUS -->
				<div class="well well-sm d-flex align_items_center justify_content_between custom_card margin-bottom-30">
					<h4>Hotel Booking Status</h4>
					<?php if($cab_booking->booking_status == 9 ){ ?>
						<p class="green"><strong> BOOKING CONFIRMED </strong></p>
						<p class="green">Comment: <strong><?php echo $cab_booking->booking_note; ?></strong></p>
						<?php if( $role == 99 || $role == 98 || $role == 97  ){ ?>
							<div class="close_iti">
								<a href="javascript: void(0)" id="update_closeStatus" data-id = "<?php echo $cab_booking->id; ?>" class="btn btn-danger" title="click to Cancel Booking"><i class="fa fa-close" aria-hidden="true"></i> Cancel Booking</a>	
							</div>
						<?php }  ?>
					<?php }else if( $cab_booking->booking_status == 8 ){ ?>
						<p class="red"><strong> BOOKING DECLINED </strong></p>
						<p class="red">Comment: <strong><?php echo $cab_booking->booking_note; ?></strong></p>
					<?php }else if( $cab_booking->booking_status == 7 ){ ?>
						<p class="red"><strong> BOOKING CANCENLED </strong></p>
					<?php }else{ ?>
						<p class="blue"><strong> PROCESSING </strong></p>
						<!--Cancel BOOKING -->
						<?php if( $role == 99 || $role == 98 || $role == 97  ){ ?>
							<div class="">
								<a href="javascript: void(0)" id="cancle_pre_booking" data-id = "<?php echo $cab_booking->id; ?>" class="btn btn-danger" title="click to Cancel Booking"><i class="fa fa-close" aria-hidden="true"></i> Cancel Booking</a>	
							</div>
						<?php } ?>
					<?php } ?>
				</div><!-- END CAB BOOKING STATUS -->
				
				<div class="portlet-body custom_card">
					<h3>Cab Details</h3>
					<div class="form-group col-md-12">
						<?php $cabbookingemail = $cab_booking->email_count; ?>
							<?php /*
								<div  class="mail-info well ">
									//show sent button if booking not canceled or declined
									if( $cab_booking->booking_status != 8 && $cab_booking->booking_status != 7  ){ 
										echo '<a id="cab_email_sent" href="#" class="btn green uppercase ">Send</a><div class="clearfix"></div>';
									}
									
									if( $cabbookingemail == 0  && ( $cab_booking->booking_status != 8 || $cab_booking->booking_status != 7 ) ){ 
										echo "<div class=' btn blue btn-outline sbold'>Cab booking email not send yet.</div>";
									}else{ 
										echo "<div class=' btn btn-outline sbold green-haze '>Cab booking Sent " . $cabbookingemail . " Times.</div>";
									} 
								</div>
							*/
							?>
						<div  class="mail-info well align_items_center bg_white d-flex justify_content_between mail-info margin-top-20 padding_zero well">
							<?php 
							if( $role == 99 || $role == 98 || $role == 97  ){
								//show sent button if booking not canceled or declined
								/*if(  $cab_booking->is_approved_by_gm == 0 ){
									echo '<a id="hotel_quotation_sent" href="#" data-id="' . $cab_booking->id . '" class="btn green uppercase ">Send Quotation To GM</a><div class="clearfix"></div>';
								}else if( $cab_booking->is_approved_by_gm == 1 ){	
									echo "<div class='alert alert-danger'>Awaiting Quotation Confirmation by GM.</div>";
								} */
								
								//send btn
								//if( $cab_booking->booking_status != 8 && $cab_booking->booking_status != 7 && $cab_booking->is_approved_by_gm == 2 ){ 
								if( $cab_booking->booking_status != 8 && $cab_booking->booking_status != 7 ){ 
									//echo "<div class='alert alert-success'>Quotation Confirmed by GM.</div>";
									echo '<a id="cab_email_sent" href="#" class="btn green uppercase ">Send</a><div class="clearfix"></div>';
								}
								
								if( $cabbookingemail == 0  && ( $cab_booking->booking_status != 8 || $cab_booking->booking_status != 7 ) ){ 
									echo "<div class='btn blue btn-outline sbold'>Cab booking email not send yet.</div>";
								}else{ 
									echo "<div class='btn btn-outline sbold green-haze '>Cab booking Sent " . $cabbookingemail . " Times.</div>";
								}
								
							}	
							?>
						</div>
					
					</div>
					<div class="clearfix"></div>
						<div class="table-responsive">	
							<table class="table table-condensed table-hover">			
							<tr>
								<td width="20%"><div class="col-mdd-2 form_vl border_right_none"><strong>Itinerary ID: </strong></div></td>	
								<td><div class="col-mdd-10 form_vr"><?php echo $cab_booking->iti_id; ?></div></td>
							</tr>
							<tr>
								<td><div class="col-mdd-2 form_v_hotel_book"><strong>Transporter Name:</strong></div></td>		
								<td><div class="col-mdd-10 form_vr"><?php echo get_transporter_name($cab_booking->transporter_id); ?></div></td>			
							</tr>	
							<?php //get transporter details
							$transporter = get_transporter_details( $cab_booking->transporter_id );
							if( !empty( $transporter ) ){
								$trans = $transporter[0]; ?>
								<tr>
									<td><div class="col-mdd-2 form_v_hotel_book"><strong>Transporter Contact Number:</strong></div></td>		
									<td><div class="col-mdd-10 form_vr"><?php echo $trans->trans_contact; ?></div></td>			
								</tr>
								<tr>
									<td><div class="col-mdd-2 form_v_hotel_book"><strong>Transporter Email:</strong></div></td>		
									<td><div class="col-mdd-10 form_vr"><?php echo $trans->trans_email; ?></div></td>			
								</tr>								
							<?php } ?>
							<tr>
								<td width="20%"><div class="col-mdd-2 form_vl border_right_none"><strong>Client Name: </strong></div></td>	
								<td><div class="col-mdd-10 form_vr"><?php echo get_customer_name($cab_booking->customer_id); ?></div></td>
							</tr>
								<tr>
								<td><div class="col-mdd-2 form_v_hotel_book"><strong>Total Travellers: </strong></div></td>					
								<td><div class="col-mdd-10 form_vr"><?php echo $cab_booking->total_travellers; ?></div></td>			
							</tr>
							<tr>
								<td><div class="col-mdd-2 form_v_hotel_book"><strong>Picking/Droping Location: </strong></div></td>					
								<td><div class="col-mdd-10 form_vr"><?php echo $cab_booking->pic_location ." - " . $cab_booking->drop_location; ?></div></td>			
							</tr>
							<tr>
								<td><div class="col-mdd-2 form_v_hotel_book"><strong>Booking Date: </strong></div></td>					
								<td><div class="col-mdd-10 form_vr"><?php echo $cab_booking->picking_date . "( " . $cab_booking->reporting_time . " ) - " . $cab_booking->droping_date . " ( " . $cab_booking->departure_time  . " ) " ; ?></div></td>			
							</tr>
							<tr>
								<td><div class="col-mdd-2 form_v_hotel_book"><strong>Cab Category:</strong></div></td>	
								<td><div class="col-mdd-10 form_vr"><?php echo get_car_name($cab_booking->cab_id); ?></div></td>				
							</tr>
							<tr>
								<td><div class="col-mdd-2 form_v_hotel_book"><strong>Total Cabs:</strong></div></td>	
								<td><div class="col-mdd-10 form_vr"><?php echo $cab_booking->total_cabs; ?></div></td>				
							</tr>			
							<?php $cab_meta = unserialize($cab_booking->cab_meta); 
								$count_cab_meta = !empty($cab_meta) ?  count( $cab_meta ) : ''; ?>
								<?php 
								if( $count_cab_meta > 0 ){
									for ( $i = 0; $i < $count_cab_meta; $i++ ) {
										$cab_i = $i+1;
										$cab_num	= $cab_meta[$i]["taxi_number"];
										$dr_name 	= $cab_meta[$i]["driver_name"];
										$dr_contact = $cab_meta[$i]["driver_contact"];
										echo "<tr><td><div class='col-mdd-2 form_v_hotel_book'><strong>Cab Details ( Cab $cab_i  ) :</strong></div></td>";	
										echo "<td><div class='col-mdd-10 form_vr'> Cab Number: $cab_num , Driver Name: $dr_name , Driver Contact: $dr_contact </div></td></tr>";
									}
								} ?>							
							<tr>	
								<td><div class="col-mdd-2 form_v_hotel_book"><strong>Duration </strong></div></td>		
								<td><div class="col-mdd-10 form_vr"><?php echo $cab_booking->booking_duration; ?></div></td>		
							</tr>					
					
					<?php 
						/* Calculate total cost */
						$total_cabs = $cab_booking->total_cabs;
						$cab_rate = $cab_booking->cab_rate;;
						$total_cab_cost_perday = $total_cabs * $cab_rate;
						$inclusion_cost = $cab_booking->extra_charges;
						$total_cost = number_format($cab_booking->total_cost);
					?>	

					<!--IF APPROVED BY GM SHOW OLD ROOM Cost-->
					<?php /* if( $cab_booking->is_approved_by_gm == 2 && $cab_booking->cab_rate_old_by_agent > 0 ){ ?>
						<tr>
							<td><div class="col-mdd-2 form_v_hotel_book red"><strong>Old Cab Cost per/day: </strong></div></td>	
							<td><div class="col-mdd-2 form_v_hotel_book red"><strong><?php echo $cab_booking->cab_rate_old_by_agent; ?></strong></div></td>
						</tr>
					<?php } */ ?><!--End APPROVED BY GM SHOW OLD ROOM Cost-->
					
					<tr>		
						<td><div class="col-mdd-2 form_v_hotel_book"><strong>Cab Rate: </strong></div></td>
						<td><div class="col-mdd-10 form_vr"><?php echo $cab_rate . " /-Per Day * " . $total_cabs . " = " . number_format($total_cab_cost_perday) ; ?></div></td>				
					</tr>
					<tr>	
						<td><div class="col-mdd-2 form_v_hotel_book"><strong>Total Days: </strong></div></td>				
						<td><div class="col-mdd-10 form_vr"><?php echo $cab_booking->booking_duration; ?></div></td>				
					</tr>					
					<tr>	
						<td><div class="col-mdd-2 form_v_hotel_book"><strong>Total Cab Costs: </strong></div></td>	
						<td><div class="col-mdd-10 form_vr"><?php echo number_format($total_cab_cost_perday * $cab_booking->booking_duration); ?></div></td>	
					</tr>			
					<tr>
						<td><div class="col-mdd-2 form_v_hotel_book"><strong>Inclusion Charges: </strong></div></td>					
						<td><div class="col-mdd-10 form_vr"><?php echo " + " . $inclusion_cost; ?></div></td>			
					<tr>		
						<td><div class="col-mdd-2 form_v_hotel_book"><strong>Total Cost: </strong></div></td>		
						<td><div class="col-mdd-10 form_vr"><?php echo $total_cost . " /-"; ?></div></td>			
					</tr>
					<?php 
					$booking_status = $cab_booking->booking_status;
					if( $booking_status == 9 ){
						$status = "Approved";
					}elseif( $booking_status == 8 ){
						$status = "Declined";
					}else{
						$status = "No Review";
					} ?>
					
					<tr>		
						<td><div class="col-mdd-2 form_v_hotel_book"><strong>Booking Status: </strong></div></td>		
						<td><div class="col-mdd-10 form_vr"><?php echo $status; ?></div></td>			
					</tr>
				</table>
				<hr>
				<?php 
				$cab_meta = unserialize( $cab_booking->cab_meta ); 
				$t_cabs = $cab_booking->total_cabs;
				if( $booking_status == 9 && !empty( $cab_meta ) ){ 
					echo '<h3 class="text-center">CAB DETAILS</h3>';
					echo '<table class="table table-bordered">
						<thead>
							<tr>
								<th> # </th>
								<th> Category </th>
								<th> Cab Number </th>
								<th> Driver Name </th>
								<th> Driver Contact </th>
							</tr>
						</thead>
						<tbody>';
						for( $i=0; $i < $t_cabs; $i++ ){ ?>
							<tr>
								<td>Cab <?php echo $i+1; ?></td>
								<td><?php echo get_car_name($cab_booking->cab_id); ?></td>
								<td><?php echo isset($cab_meta[$i]['taxi_number']) ? $cab_meta[$i]['taxi_number'] : ""; ?></td>
								<td><?php echo isset($cab_meta[$i]['driver_name']) ? $cab_meta[$i]['driver_name'] : ""; ?></td>
								<td><?php echo isset($cab_meta[$i]['driver_contact']) ? $cab_meta[$i]['driver_contact'] : ""; ?></td>
							</tr>
						<?php }
					echo "</tbody></table>";
				}  ?>	
				
			</div>

			<div class='text-center'>
				<?php if( empty( $cab_booking->booking_status ) ){ ?>
					<a class="" style="display:inline;" href="<?php echo site_url("vehiclesbooking/editcabbooking/{$cab_booking->id}"); ?>" title="Edit Cab Booking Info"><i class="fa fa-pencil"></i> Update Booking</a>
				<?php }else if( $cab_booking->booking_status == 9 ){
					echo "<a  href='" . site_url("vehiclesbooking/update_cab_details/{$cab_booking->id}") . "' title='Update Cab Info' href='javascript:void(0)' class='btn btn-success'><i class='fa fa-refresh' aria-hidden='true'></i> &nbsp; Update Cab Details</a>";
				} ?>	
			</div>	
				<hr>
		<div class="well bg_white">
			<?php
			$agent_id = $cab_booking->agent_id;
			$user_info = get_user_info($agent_id);
			if($user_info){
				$agent = $user_info[0];
				echo "<strong>Regards</strong><br>";
				echo "<strong> " . $agent->first_name . " " . $agent->last_name . "</strong><br>";
				echo "<strong>Call Us : </strong> " . $agent->mobile . "<br>";
				echo "<strong>Email : </strong> " . $agent->email . "<br>";
				echo "<strong>Timing : </strong> " . $agent->in_time . " To " . $agent->out_time . "<br>";
				echo "<strong>Website : </strong> " . $agent->website;
			} ?>	
		</div>
					
	</div>
</div>

<!--Sent CAB Cancel Mail Modal-->
<div class="modal fade" id="cancelHotelBookingModal" role="dialog">
	<div class="modal-dialog modal-lg">
	  <div class="modal-content">
		<div class="modal-header">
		  <button type="button" class="close" data-dismiss="modal">&times;</button>
		  <h4 class="modal-title">Cancel Cab Booking</h4>
		</div>
		<div class="modal-body">
			<form id="cancelhotelBookForm">
			<?php //Get Hotel Information 
				$transporter = get_transporter_details($cab_booking->transporter_id);;
				$trans = $transporter[0];
				$tra_emails = $trans->trans_email; ?>
				
				<div class="form-group">
				  <label for="email">Transporter Emails*:</label>
				  <input required type="text" readonly value="<?php echo $tra_emails; ?>" name="trans_emails" class="form-control" id="email" placeholder="Enter customer email" >
				</div>
				<div class="form-group">
				  <label for="sub">Subject*:</label>
				  <input type="text" required class="form-control" id="sub" placeholder="Booking Cancellation" name="subject" value="" >
				</div>
				<input type="hidden" name="iti_id" value="<?php echo $cab_booking->iti_id; ?>">
				<input type="hidden" name="cab_id" value="<?php echo $cab_booking->cab_id; ?>">
				<input type="hidden" name="id" value="<?php echo $cab_booking->id; ?>">
				<button type="submit" id="sentIticnf_btn" class="btn btn-success">Send Cancellation Mail</button>
				<div class="sam_res"></div>
			</form>
		</div>
	  </div>
	</div>
</div>

<!--Sent Cab Booking Mail Modal-->
<div class="modal fade" id="sendCabBookingModal" role="dialog">
	<div class="modal-dialog modal-lg">
	  <div class="modal-content">
		<div class="modal-header">
		  <button type="button" class="close" data-dismiss="modal">&times;</button>
		  <h4 class="modal-title">Send Cab Booking</h4>
		</div>
		<div class="modal-body">
			<form id="senthotelBookForm">
			<?php //Get Hotel Information 
				$transporter = get_transporter_details($cab_booking->transporter_id);;
				$trans = $transporter[0];
				$tra_emails = $trans->trans_email; ?>
				<div class="form-group">
				  <label for="email">Transporter Emails*:</label>
				  <input required type="text" readonly value="<?php echo $tra_emails; ?>" name="trans_emails" class="form-control" id="email" placeholder="Enter customer email" >
				</div>
				<div class="form-group">
				  <label for="sub">Subject*:</label>
				  <input type="text" required class="form-control" id="sub" placeholder="Final confirmation Mail" name="subject" value="" >
				</div>
				<input type="hidden" name="id" value="<?php echo $cab_booking->id; ?>">
				<button type="submit" id="sentIti_btn" class="btn btn-success">Send Mail</button>
				<div id="mailSentResponse" class="sam_res"></div>
			</form>
		</div>
		<div class="modal-footer">
		  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		</div>
	  </div>
	</div>
</div>
<?php }else{
	redirect(404);
} ?>	
		
		</div>
	</div>
	<!-- END CONTENT BODY -->
</div>
<!-- Modal -->
<!--cancellation cab booking email-->
<script>
jQuery(document).ready(function($){
	
	$("#hotel_quotation_sent").click(function(e){
		var id = $(this).attr("data-id");
		var _this = $(this);
		if( id > 0 ) {
			swal({
				buttons: {
					cancel: true,
					confirm: true,
				},
				title: "Are you sure?",
				text: "You will not be able to edit current booking after sent to review!",
				icon: "warning",
				confirmButtonClass: "btn-danger",
				confirmButton: "Yes, Send it!",
				cancelButton: "No, cancel!",
				closeModal: false,
			}).then((willDelete) => {
				if (willDelete) {
					LOADER.show();
					$.ajax({
						url: "<?=site_url('vehiclesbooking/ajax_send_quotaion_to_gm')?>",
						type: "POST",
						data: {id: id},
						dataType: "json",
						success: function(res) {
							LOADER.hide();
							console.log(res);
							if( res.status == true ) {
								swal("Success!", "Request sent successfully.", "success");
								location.reload();
							} else {
								swal("Error!", "Something went wrong!", "danger");
							}
						},
						error: function(err) {
							LOADER.hide();
							swal("Error!", "Something went wrong!", "danger");
						}
					});
				}
			});
		}
	});	
	
	//Cab mail sent
	$("#cab_email_sent").click(function(e){
		e.preventDefault();
		//open modal 
		$('#sendCabBookingModal').modal('show');
	});	
	
	//Sent Mail to transporter
	$("#senthotelBookForm").validate({
		submitHandler: function(form) {
			$("#sentIti_btn").attr("disabled", "disabled");
			var ajaxReq;
			var resp = $("#mailSentResponse");
			var formData = $("#senthotelBookForm").serializeArray();
			if (ajaxReq) {
				ajaxReq.abort();
			}
			ajaxReq = $.ajax({
				type: "POST",
				url: "<?php echo base_url('vehiclesbooking/sentcabbooking'); ?>" ,
				dataType: 'json',
				data: formData,
				beforeSend: function(){
					resp.html("<div class='alert alert-info'><strong>Please wait</strong> sending mail.....</div>");
				},
				success: function(res) {
					if (res.status == true){
						resp.html('<div class="alert alert-success"><strong>Success! </strong>'+res.msg+'</div>');
						//console.log(res.msg);
						alert(res.msg);
						location.reload();
					}else{
						resp.html('<div class="alert alert-danger"><strong>Error! </strong>'+res.msg+'</div>');
						console.log("error");
					}
				},
				error: function(e){
					//console.log(e);
					resp.html('<div class="alert alert-danger"><strong>Error!</strong> Please Reload Page and Try again later! </div>');
				}
			});
		}	
	}); 
	
	
	//Cancel Booking Status
	$(document).on("click", "#cancle_pre_booking", function(e){
		e.preventDefault();
		var id = $(this).attr("data-id");
		if (confirm("Are you sure to cancel cab booking?")) {
			$.ajax({
				url: "<?php echo base_url(); ?>" + "vehiclesbooking/ajax_update_cancelstatus?id=" + id,
				type:"GET",
				data:id,
				dataType: 'json',
				cache: false,
				success: function(r){
					if(r.status = true){
						location.reload();
						console.log("ok")
					}else{
						alert("Error! Please try again.");
					}
				},
			});	
		} 		
	});
	
	//Cancel Booking Status
	$(document).on("click", "#update_closeStatus", function(e){
		e.preventDefault();
		$('#cancelHotelBookingModal').modal('show');
	});		
	//cancel booking
	$("#cancelhotelBookForm").validate({
		submitHandler: function(form) {
			$("#sentIticnf_btn").attr("disabled", "disabled");
			var ajaxReq;
			var resp = $(".sam_res");
			var formData = $("#cancelhotelBookForm").serializeArray();
			if (ajaxReq) {
				ajaxReq.abort();
			}
			ajaxReq = $.ajax({
				type: "POST",
				url: "<?php echo base_url('vehiclesbooking/cancel_cab_booking'); ?>" ,
				dataType: 'json',
				data: formData,
				beforeSend: function(){
					resp.html("<div class='alert alert-info'><strong>Please wait</strong> sending mail.....</div>");
				},
				success: function(res) {
					if (res.status == true){
						resp.html('<div class="alert alert-success"><strong>Success! </strong>'+res.msg+'</div>');
						//console.log(res.msg);
						alert(res.msg);
						location.reload();
					}else{
						resp.html('<div class="alert alert-danger"><strong>Error! </strong>'+res.msg+'</div>');
						console.log("error");
					}
				},
				error: function(e){
					//console.log(e);
					resp.html('<div class="alert alert-danger"><strong>Error!</strong> Please Reload Page and Try again later! </div>');
				}
			});
		}	
	}); 
}); 
</script>
<script type="text/javascript">
/* jQuery(document).ready(function($){
	var ajaxReq;
	$("#cab_email").click(function(e){
		e.preventDefault();
		var id = $("#cab_booking_id").val();
		var resp = $("#response");
		if (ajaxReq) {
            ajaxReq.abort();
		}
		ajaxReq = $.ajax({
			type: "POST",
			url: "<?php echo base_url('sendemail/sentcabbooking'); ?>" ,
			dataType: 'json',
			data: {id: id},
			beforeSend: function(){
				resp.html("<div class='alert alert-info'><strong>Please wait</strong> email sending.....</div>");
			},
			success: function(res) {
				if (res.status == true){
					resp.html('<div class="alert alert-success"><strong>Success! </strong>'+res.msg+'</div>');
					//console.log(res.msg);
					alert(res.msg);
					location.reload();
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
	}); 
}); */
</script>