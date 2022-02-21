<div class="page-container">
    <div class="page-content-wrapper">
        <div class="page-content">
            <!--Show success message if hotel edit/add -->
            <?php $message = $this->session->flashdata('success'); 
				if($message){ echo '<span class="help-block help-block-success">'.$message.'</span>'; }
			?>
			<?php $tra_booking = $travel_booking[0];  ?>
			<?php if($tra_booking){ ?>
				<div class="portlet box blue">
					<div class="portlet-title">
						<div class="caption"><i class="fa fa-users"></i>Booking Type: <strong><?php echo ucfirst($tra_booking->booking_type); ?></strong></div>
						<a class="btn btn-success" href="<?php echo site_url("vehiclesbooking/allvehiclesbookings"); ?>" title="Back">Back</a>
						<a class="btn btn-danger pull-right" target="_blank" style="margin: 3px;" href="<?php echo iti_view_single_link($tra_booking->iti_id); ?>" title="View Itinerary">View Itinerary</a>
					</div>
				</div>
                
				
				<div  class="custom_card mail-info well d-flex justify_content_between align_items_center">
					<?php 
					if( $role == 99 || $role == 98 || $role == 97  ){
						//show sent button if booking not canceled or declined
						/*if(  $tra_booking->is_approved_by_gm == 0 ){
							echo '<a id="hotel_quotation_sent" href="#" data-id="' . $tra_booking->id . '" class="btn green uppercase ">Send Quotation To GM</a><div class="clearfix"></div>';
						}else if( $tra_booking->is_approved_by_gm == 1 ){	
							echo "<div class='alert alert-info'>Awaiting Quotation Confirmation by GM.</div>";
						} */
						
						//send btn
						//if( $tra_booking->booking_status != 8 && $tra_booking->booking_status != 7 && $tra_booking->is_approved_by_gm == 2 ){
						if( $tra_booking->booking_status != 8 && $tra_booking->booking_status != 7 ){
							$update_ticket_btn = site_url("vehiclesbooking/update_vtf_tickets/{$tra_booking->id}");	
							//echo "<div class='alert alert-success'>Quotation Confirmed by GM.</div>";
							echo '<a id="cab_email_sent1" href="' . $update_ticket_btn . '" class="btn green uppercase ">Update Ticket Details</a><div class="clearfix"></div>';
						}
					}
					?>

					<?php if( $tra_booking->booking_status == 9 ){ ?>
					<div class="close_iti text-right">
						<p class="text-center d_inline_block margin_zero"><strong class="badge_success_pill"><i class="fa fa-check" aria-hidden="true"></i> Booking Approved</strong></p>
						<?php if( $role == 99 || $role == 98 || $role == 97  ){ ?>
							<a href="javascript: void(0)" id="update_closeStatus" data-id = "<?php echo $tra_booking->id; ?>" data-iti_id ="<?php echo $tra_booking->iti_id; ?>" class="btn btn-danger" title="click to Cancel Booking"><i class="fa fa-close" aria-hidden="true"></i> Cancel Booking</a>
						<?php } ?>
					</div>
				<?php }elseif( $tra_booking->booking_status == 8 ){
					echo '<p class="text-center"><strong class="badge_danger-pill"><i class="fa fa-close" aria-hidden="true"></i> Booking Canceled</strong></p>';
				}else{
					echo '<p class="text-center d_inline_block margin_zero"><strong class="badge_lightpurple_pill"><i class="fa fa-spinner" aria-hidden="true"></i> Booking Processing</strong></p>'; ?>
					<!--Cancel BOOKING -->
					<?php if( $role == 99 || $role == 98 || $role == 97  ){ ?>
					<div class="text-center">
						<a href="javascript: void(0)" id="update_closeStatus" data-id = "<?php echo $tra_booking->id; ?>" data-iti_id ="<?php echo $tra_booking->iti_id; ?>" class="btn btn-danger" title="click to Cancel Booking"><i class="fa fa-close" aria-hidden="true"></i> Cancel Booking</a>
					</div>
					
				<?php } ?>
				<?php } ?>
				</div>
				<hr>
				
				<div class="portlet-body custom_card">
					<h3 class="margin-bottom-30">Booking Details ( <strong class='green'> <?php echo ucfirst($tra_booking->booking_type); ?></strong> )</h3>
						<div class="table-responsive">	
							<table class="table table-condensed table-hover table-striped table-bordered">			
							<tr>
								<td width="20%"><div class="col-mdd-2 form_vl border_right_none"><strong>Itinerary ID: </strong></div></td>	
								<td><div class="col-mdd-10 form_vr"><?php echo $tra_booking->iti_id; ?></div></td>
							</tr>
							<tr>
								<td><div class="col-mdd-2 form_v_hotel_book"><strong>Customer Name:</strong></div></td>		
								<td><div class="col-mdd-10 form_vr"><?php echo get_customer_name($tra_booking->customer_id); ?></div></td>			
							</tr>
							<tr>
								<td><div class="col-mdd-2 form_v_hotel_book"><strong>Booking Type:</strong></div></td>		
								<td><div class="col-mdd-10 form_vr"><?php echo $tra_booking->booking_type; ?></div></td>			
							</tr>							
							
							<tr>
								<td width="20%"><div class="col-mdd-2 form_vl border_right_none"><strong>Total Passengers: </strong></div></td>	
								<td><div class="col-mdd-10 form_vr"><?php echo $tra_booking->total_travellers; ?></div></td>
							</tr>
							<tr>
								<td><div class="col-mdd-2 form_v_hotel_book"><strong>Vehicle Name: </strong></div></td>					
								<td><div class="col-mdd-10 form_vr"><?php echo $tra_booking->t_name; ?></div></td>			
							</tr>
							<tr>
								<td><div class="col-mdd-2 form_v_hotel_book"><strong>Vehicle Number: </strong></div></td>					
								<td><div class="col-mdd-10 form_vr"><?php echo $tra_booking->t_number; ?></div></td>			
							</tr>
							<tr>
								<td><div class="col-mdd-2 form_v_hotel_book"><strong>Class Type: </strong></div></td>					
								<td><div class="col-mdd-10 form_vr"><?php echo $tra_booking->class_type; ?></div></td>			
							</tr>
							<tr>
								<td><div class="col-mdd-2 form_v_hotel_book"><strong>Departure Date/time:</strong></div></td>	
								<td><div class="col-mdd-10 form_vr"><?php echo $tra_booking->dep_date ."( " . $tra_booking->dep_time . " )" ; ?></div></td>				
							</tr>
							<tr>
								<td><div class="col-mdd-2 form_v_hotel_book"><strong>Arrival Date/time:</strong></div></td>	
								<td><div class="col-mdd-10 form_vr"><?php echo $tra_booking->arr_date ."( " . $tra_booking->arr_time . " ) "  ; ?></div></td>				
							</tr>
							
							<tr>
								<td><div class="col-mdd-2 form_v_hotel_book"><strong>Departure/Arrival Location:</strong></div></td>	
								<td><div class="col-mdd-10 form_vr"><?php echo $tra_booking->dep_loc ." - " . $tra_booking->arr_loc; ?></div></td>				
							</tr>
							
							<tr>
								<td><div class="col-mdd-2 form_v_hotel_book"><strong>Total Seats:</strong></div></td>	
								<td><div class="col-mdd-10 form_vr"><?php echo $tra_booking->total_seats; ?></div></td>				
							</tr>
							
							<tr>
								<td><div class="col-mdd-2 form_v_hotel_book"><strong>Cost Per/seat:</strong></div></td>	
								<td><div class="col-mdd-10 form_vr"><?php echo $tra_booking->cost_per_seat; ?></div></td>				
							</tr>
							
							<tr>
								<td><div class="col-mdd-2 form_v_hotel_book"><strong>Total Cost Single Trip:</strong></div></td>	
								<td><div class="col-mdd-10 form_vr"><?php echo $tra_booking->cost_per_seat * $tra_booking->total_seats; ?>/-</div></td>				
							</tr>
							
							
							<tr>	
								<td><div class="col-mdd-2 form_v_hotel_book"><strong>Seat Numbers: </strong></div></td>		
								<td><div class="col-mdd-10 form_vr"><?php echo $tra_booking->seat_numbers;  ?></div></td>		
							</tr>	
							<tr>	
								<td><div class="col-mdd-2 form_v_hotel_book"><strong>Ticket Numbers: </strong></div></td>		
								<td><div class="col-mdd-10 form_vr"><?php echo $tra_booking->ticket_numbers;  ?></div></td>		
							</tr>	
							<tr>	
								<td><div class="col-mdd-2 form_v_hotel_book"><strong>Ticket Numbers: </strong></div></td>		
								<td><div class="col-mdd-10 form_vr"><?php echo $tra_booking->ticket_numbers;  ?></div></td>		
							</tr>	
							<?php if( !empty($tra_booking->return_t_name) || !empty($tra_booking->return_dep_date) ) { ?>
								<tr><td><div class="col-mdd-10 form_v_hotel_book"><strong>Return Ticket: </strong></div></td>
								<td><div class="col-mdd-10 form_vr"><?php echo 'YES'; ?></div></td>	</tr>
								<tr><td><div class="col-mdd-12 form_v_hotel_book"><h4>Return Ticket Info: </h4></div><td></td></tr>
								<tr>
									<td><div class="col-mdd-2 form_v_hotel_book"><strong>Vehicle Name(Return trip): </strong></div></td>		
									<td><div class="col-mdd-10 form_vr"><?php echo $tra_booking->return_t_name; ?></div></td>			
								</tr>
								<tr>
									<td><div class="col-mdd-2 form_v_hotel_book"><strong>Vehicle Number (Return trip): </strong></div></td>	
									<td><div class="col-mdd-10 form_vr"><?php echo $tra_booking->return_t_number; ?></div></td>			
								</tr>
								<tr>
									<td><div class="col-mdd-2 form_v_hotel_book"><strong>Class Type (Return trip): </strong></div></td>			
									<td><div class="col-mdd-10 form_vr"><?php echo $tra_booking->return_class_type; ?></div></td>			
								</tr>
								<tr>
									<td><div class="col-mdd-2 form_v_hotel_book"><strong>Departure Date/time (Return trip): </strong></div></td>
									<td><div class="col-mdd-10 form_vr"><?php echo $tra_booking->return_dep_date . "( " . $tra_booking->return_dep_time . " )"; ?></div></td>			
								</tr>
								<tr>
									<td><div class="col-mdd-2 form_v_hotel_book"><strong>Departure Location (Return trip): </strong></div></td>
									<td><div class="col-mdd-10 form_vr"><?php echo $tra_booking->return_dep_loc; ?></div></td>			
								</tr>
								<tr>
									<td><div class="col-mdd-2 form_v_hotel_book"><strong>Total Seats (Return trip): </strong></div></td>
									<td><div class="col-mdd-10 form_vr"><?php echo $tra_booking->return_total_seats; ?></div></td>			
								</tr>
								
								<tr>
									<td><div class="col-mdd-2 form_v_hotel_book"><strong>Cost Per/seat  (Return trip):</strong></div></td>	
									<td><div class="col-mdd-10 form_vr"><?php echo $tra_booking->cost_per_seat_return_trip; ?></div></td>				
								</tr>
								
								<tr>
									<td><div class="col-mdd-2 form_v_hotel_book"><strong>Total Cost (Return trip):</strong></div></td>	
									<td><div class="col-mdd-10 form_vr"><?php echo $tra_booking->cost_per_seat_return_trip * $tra_booking->return_total_seats; ?>/-</div></td>				
								</tr>
								
								<?php /* if( $tra_booking->is_approved_by_gm == 2 ){ ?>
									<tr>
										<td><div class="col-mdd-2 form_v_hotel_book red"><strong>OLD Cost Per/seat:</strong></div></td>	
										<td><div class="col-mdd-10 form_vr red"><?php echo $tra_booking->old_cost_per_seat_return_trip	; ?></div></td>
									</tr>
								<?php } */ ?>
							
								<tr>
									<td><div class="col-mdd-2 form_v_hotel_book"><strong>Ticket Number(Return trip): </strong></div></td>
									<td><div class="col-mdd-10 form_vr"><?php echo $tra_booking->return_ticket_numbers; ?></div></td>			
								</tr>
								<tr>
									<td><div class="col-mdd-2 form_v_hotel_book"><strong>Departure Location (Return trip): </strong></div></td>
									<td><div class="col-mdd-10 form_vr"><?php echo $tra_booking->return_dep_loc; ?></div></td>			
								</tr>
							<?php }else{ ?>
								<tr><td><div class="col-mdd-10 form_v_hotel_book"><strong>Return Ticket: </strong></div></td>
								<td><div class="col-mdd-10 form_vr"><?php echo 'No'; ?></div></td>	
								</tr>
							<?php } ?>
							<tr>
								<td><div class="col-mdd-2 form_v_hotel_book"><strong>Other Info: </strong></div></td>
								<td><div class="col-mdd-10 form_vr"><?php echo $tra_booking->other_info; ?></div></td>			
							</tr>
						
					
				</table>
			</div>	
			
			<?php if (isset( $vtf_booking_docs ) && !empty( $vtf_booking_docs ) ){
				$doc_path =  base_url() . 'site/assets/client_tickets_docs/';
				echo '<hr><h4 class="uppercase">Other Documents</h4>'; ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="thead-default">
                            <tr>
                                <th> Sr. </th>
                                <th> Title</th>
                                <th> Link</th>
                                <th> Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
							$docindex = 1; 
							foreach( $vtf_booking_docs as $ind => $doc ){
								echo "<tr id='doc_row_{$doc->id}'>";
									echo "<td>" . $docindex . "</td>";
									echo "<td>" . $doc->description . "</td>";
									echo "<td>" . $doc->file_url . "</td>";
									echo "<td>"; ?>
                            <a href="<?php echo $doc_path . $doc->file_url; ?>" target="_blank" class="btn btn-success"
                                style="position:relative;">
                                <i class="fa fa-download" aria-hidden="true"></i></a>
                            </td>
                            <?php 	
								echo "</tr>";	
								$docindex++;
							} ?>
                        </tbody>
                    </table>
                </div>
                <?php } ?>
                <!--Edit Button if booking not canceled-->
                <?php if( $tra_booking->booking_status != 8 ){ ?>
                <div class="text-center">
                    <a title='Edit booking'
                        href="<?php echo site_url("vehiclesbooking/editvtf/{$tra_booking->id}/{$tra_booking->iti_id}"); ?>"
                        class=""><i class="fa fa-pencil"></i> Edit Booking</a>
                </div>
                <?php } ?>
                <div class="well">
                    <?php
			$agent_id = $tra_booking->agent_id;
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
        <?php }else{
	redirect(404);
} ?>

    </div>
</div>
<!-- END CONTENT BODY -->
</div>
<!-- Modal -->
<script type="text/javascript">
jQuery(document).ready(function($) {

    $("#hotel_quotation_sent").click(function(e) {
        var id = $(this).attr("data-id");
        var _this = $(this);
        if (id > 0) {
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
                        url: "<?php echo site_url('vehiclesbooking/ajax_send_volvo_quotation_to_gm'); ?>",
                        type: "POST",
                        data: {
                            id: id
                        },
                        dataType: "json",
                        success: function(res) {
                            LOADER.hide();
                            console.log(res);
                            if (res.status == true) {
                                swal("Success!", "Request sent successfully.",
                                    "success");
                                //location.reload();
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

    //Cancel Booking Status
    $(document).on("click", "#update_closeStatus", function(e) {
        e.preventDefault();
        var _this = $(this);
        var id = _this.attr("data-id");

        if (confirm("Are you sure you want to cancel booking.?")) {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('vehiclesbooking/cancel_vtf_booking'); ?>",
                dataType: 'json',
                data: {
                    id: id
                },
                beforeSend: function() {
                    //resp.html('<p><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
                },
                success: function(res) {
                    if (res.status == true) {
                        console.log("done");
                        location.reload();
                    } else {
                        alert("Error! Please try again later.");
                        console.log("error");
                    }
                },
                error: function(e) {
                    console.log(e);
                }
            });
        }
    });
});
</script>