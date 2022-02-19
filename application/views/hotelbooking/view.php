<?php $hotel_book = $hotel_booking[0];  ?>
<div class="page-container hotelbooking-page">
    <div class="page-content-wrapper">
        <div class="page-content">
            <style>
            .error {
                bottom: -35px !important;
            }
            </style>

            <?php if($hotel_book){ 
			$message = $this->session->flashdata('success'); 
			if($message){ echo '<span class="help-block help-block-success">'.$message.'</span>';} ?>

            <div class="portlet box blue mb0">
                <div class="portlet-title">
                    <div class="caption"><i class="fa fa-users"></i>Hotel Name:
                        <strong><?php echo get_hotel_name($hotel_book->hotel_id); ?></strong> At
                        <?php echo get_city_name($hotel_book->city_id); ?>
                    </div>

                    <a class="btn btn-success" href="<?php echo site_url("hotelbooking"); ?>" title="Back">Back</a>
                    <a class="btn btn-danger pull-right" target="_blank" style="margin: 3px;"
                        href="<?php echo iti_view_single_link($hotel_book->iti_id); ?>" title="View Itinerary">View
                        Itinerary</a>
                </div>
            </div>
            <!-- SHOW HOTEL STATUS -->
            <div class="well well-sm custom_card">

                <?php if( $hotel_book->booking_status == 9 ){ ?>

                <div class="col-md-6">
                    <h4>Hotel Booking Status</h4>
                    <div class="progress" style="height:30px;">
                        <div class="progress-bar progress-bar-striped  progress-bar-success active" role="progressbar"
                            aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"
                            style="width:100%;    padding: 6px;">BOOKING CONFIRMED</div>
                    </div>
                    <?php if( $role == 99 || $role == 98 || $role == 97  ){ ?>
                    <div class="close_iti">
                        <a href="javascript: void(0)" id="update_closeStatus" data-id="<?php echo $hotel_book->id; ?>"
                            class="btn btn-danger" title="click to Cancel Booking"><i class="fa fa-close"
                                aria-hidden="true"></i> Cancel Booking</a>
                    </div>
                    <?php } ?>

                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Comment:</label>
                        <blockquote>
                            <div class="form-control" placeholder="Disabled" disabled="">
                                <?php echo $hotel_book->booking_note; ?></div>
                        </blockquote>
                    </div>
                </div>

                <div class="clearfix"></div>

                <?php }else if( $hotel_book->booking_status == 8 ){ ?>

                <div class="col-md-6">
                    <h4>Hotel Booking Status</h4>
                    <div class="progress" style="height:30px;">
                        <div class="progress-bar progress-bar-striped progress-bar-danger active" role="progressbar"
                            aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:100%; padding: 6px;">
                            BOOKING DECLINED</div>
                    </div>
                    <?php if( $role == 99 || $role == 98 || $role == 97  ){ ?>
                    <div>
                        <a href="<?php echo base_url("hotelbooking/duplicate_hotel_booking/{$hotel_book->id}");?>"
                            id="clone_hotel_booking" class="btn btn-success" title="click to clone Booking"><i
                                class='fa fa-files-o' aria-hidden='true'></i> Duplicate Booking</a>
                        <!--clone booking btn-->
                    </div>
                    <?php } ?>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Comment:</label>
                        <blockquote>
                            <div class="form-control" placeholder="Disabled" disabled="">
                                <?php echo $hotel_book->booking_note; ?></div>
                        </blockquote>
                    </div>
                </div>
                <div class="clearfix"></div>


                <?php }else if( $hotel_book->booking_status == 7 ){ ?>
                <div class="col-md-6">
                    <h4>Hotel Booking Status</h4>
                    <div class="progress" style="height:30px;">
                        <div class="progress-bar progress-bar-striped progress-bar-danger active" role="progressbar"
                            aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:100%; padding: 6px;">
                            BOOKING CANCENLED</div>
                    </div>
                    <?php if( $role == 99 || $role == 98 || $role == 97  ){ ?>
                    <div>
                        <a href="<?php echo base_url("hotelbooking/duplicate_hotel_booking/{$hotel_book->id}");?>"
                            id="clone_hotel_booking" class="btn btn-success" title="click to clone Booking"><i
                                class='fa fa-files-o' aria-hidden='true'></i> Duplicate Booking</a>
                    </div>
                    <!--clone booking btn-->
                    <?php } ?>
                </div>



                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label"> Cancellation Note By Agent:</label>
                        <blockquote>
                            <div class="form-control" placeholder="Disabled" disabled="">
                                <?php echo $hotel_book->booking_cancel_note; ?></div>
                        </blockquote>
                    </div>

                    <div class="form-group">
                        <label class="control-label">Cancellation Confirm Note By Hotel:</label>
                        <blockquote>
                            <div class="form-control" placeholder="Disabled" disabled="">
                                <?php echo !empty( $hotel_book->hotel_cancel_booking_note ) ?  $hotel_book->hotel_cancel_booking_note : "<span class='red'>Pending</span>"; ?>
                            </div>
                        </blockquote>
                    </div>
                </div>
                <div class="clearfix"></div>
                <?php }else{ ?>

                <div class="col-md-12">
                    <h4>Hotel Booking Status</h4>
                    <div class="progress" style="height:30px;">
                        <div class="progress-bar progress-bar-striped  active" role="progressbar" aria-valuenow="40"
                            aria-valuemin="0" aria-valuemax="100" style="width:90%; padding: 6px;">PROCESSING</div>
                    </div>
                    <?php if( $role == 99 || $role == 98 || $role == 97  ){ ?>
                    <div class="">
                        <a href="javascript: void(0)" id="cancle_pre_booking" data-id="<?php echo $hotel_book->id; ?>"
                            class="btn btn-danger" title="click to Cancel Booking"><i class="fa fa-close"
                                aria-hidden="true"></i> Cancel Booking</a>

                        <!--APPROVED OR DECLINE BUTTON-->
                        <?php 
						if( $hotel_book->email_count > 0 ){
							echo "<a title='Click to Approve Hotel Booking' href=" . site_url("confirm/hotelbooking?hotel_id=". base64_url_encode($hotel_book->hotel_id) . "&iti_id=" . base64_url_encode($hotel_book->iti_id) . "&token_key=" . base64_url_encode($hotel_book->id) ) . "&status=" . base64_url_encode(9) . " target='_blank' class='btn btn-success' ><i class='fa fa fa-check' aria-hidden='true'></i> Confirm Booking</a>";
						}	
						?>
                    </div>
                    <?php } ?>
                </div>
                <div class="clearfix"></div>

                <?php } ?>
            </div>




            <!-- END SHOW HOTEL STATUS -->
            <?php 
				if( !empty( $hotel_book->check_in ) && !empty($hotel_book->check_out) ){
					$check_in 	=  $hotel_book->check_in; 
					$check_out 	=  $hotel_book->check_out;
					
					$date1 		=	 new DateTime($check_in);
					$t_date2 	= 	 new DateTime($check_out);
					$total_days =  $t_date2->diff($date1)->format("%a"); 
					$total_days = $total_days+1;
					if( $total_days <= 1 ){
						$duration =  "Single Day";
					}else{
						$nights = $total_days - 1;
						$duration =  $nights . " Nights";
						
					}
				}else{
					$duration =  "";
					$nights ="";
				}
				?>

            <div style="margin-bottom:80px;"></div>
            <div class="portlet box blue mb0">
                <div class="portlet-title">
                    <div class="caption">Room Details</div>
                    <h4 class='text-right'><strong>Invoice Id : <?php echo $hotel_book->invoice_id; ?></strong>
                </div>
            </div>

            <div class="portlet-body custom_card">
                <div class="form-group ">
                    <?php $hotelbooking_sent = $hotel_book->email_count; ?>
                    <div class="mail-info well d-flex align_items_center justify_content_between bg_white padding_zero">
                        <?php 
						if( $role == 99 || $role == 98 || $role == 97  ){
							//show sent button if booking not canceled or declined
							//if(  $hotel_book->is_approved_by_gm == 0 ){
								//echo '<a id="hotel_quotation_sent" href="#" data-id="' . $hotel_book->id . '" class="btn green uppercase ">Send Quotation To GM</a><div class="clearfix"></div>';
							//}else if( $hotel_book->is_approved_by_gm == 1 ){	
								//echo "<div class='alert alert-danger'>Awaiting Quotation Confirmation by GM.</div>";
							//}
							
							//send btn
							//if( $hotel_book->booking_status != 8 && $hotel_book->booking_status != 7 && $hotel_book->is_approved_by_gm == 2 ){ 
							if( $hotel_book->booking_status != 8 && $hotel_book->booking_status != 7 ){ 
								//echo "<div class='alert alert-success'>Quotation Confirmed by GM.</div>";
								echo '<a id="hotel_email_sent" href="#" class="btn green uppercase ">Send</a><div class="clearfix"></div>';
							}
							
							if( $hotelbooking_sent == 0  && ( $hotel_book->booking_status != 8 || $hotel_book->booking_status != 7 ) ){ 
								echo "<div class=' btn blue btn-outline sbold'>Hotel booking email not send yet.</div>";
							}else{ 
								echo "<div class=' btn btn-outline sbold green-haze '>Hotel booking Sent " . $hotelbooking_sent . " Times.</div>";
							}
						}
						?>
                    </div>
                    <div class="clearfix"></div>
                    <div id="response" class="sam_res"></div>
                </div>
                <div class="clearfix"></div>

                <div class=" col-md-12 padding-0 table-responsive">
                    <table class="table table-condensed table-hover table-striped table-bordered">
                        <!--IF APPROVED BY GM SHOW OLD ROOM Cost-->
                        <?php //if( $hotel_book->is_approved_by_gm == 2 && $hotel_book->room_cost_old_by_agent > 0 ){ ?>
                        <tr>
                            <td>
                                <div class="col-mdd-2 form_v_hotel_book green"><strong>Room Cost per/day: </strong>
                                </div>
                            </td>
                            <td>
                                <div class="col-mdd-2 form_v_hotel_book green">
                                    <strong><?php echo $hotel_book->room_cost; ?></strong>
                                </div>
                            </td>
                            <td></td>
                            <td></td>
                        </tr>
                        <?php //} ?>
                        <!--End APPROVED BY GM SHOW OLD ROOM Cost-->
                        <tr>
                            <td>
                                <div class="col-mdd-2 form_v_hotel_book"><strong>Client Name: </strong></div>
                            </td>
                            <td>
                                <div class="col-mdd-10 form_vr">
                                    <?php echo get_customer_name($hotel_book->customer_id); ?></div>
                            </td>
                            <?php
								$total_tra = $hotel_book->total_travellers;
								//Get Hotel Information
								$htl_info = get_hotel_details($hotel_book->hotel_id);
								$hotel_info = $htl_info[0];

								$hotel_contact = $hotel_info->hotel_contact;

								$hotel_email = $hotel_info->hotel_email; ?>





                            <td>
                                <div class="col-mdd-2 form_v_hotel_book"><strong>Number of Rooms</strong></div>
                            </td>

                            <td>
                                <div class="col-mdd-10 form_vr">
                                    <?php echo $hotel_book->total_rooms . " " . get_roomcat_name($hotel_book->room_type); ?>
                                </div>
                            </td>

                        </tr>



                        <tr>

                            <td>
                                <div class="col-mdd-2 form_v_hotel_book"><strong>Number of Guest</strong></div>
                            </td>

                            <td>
                                <div class="col-mdd-10 form_vr"><?php echo $total_tra; ?></div>
                            </td>

                            <td>
                                <div class="col-mdd-2 form_v_hotel_book"><strong>Check In Date</strong></div>
                            </td>

                            <td>
                                <div class="col-mdd-10 form_vr"><?php echo display_month_name($hotel_book->check_in); ?>
                                </div>
                            </td>

                        </tr>



                        <tr>

                            <td>
                                <div class="col-mdd-2 form_v_hotel_book"><strong>Hotel Email:</strong></div>
                            </td>

                            <td>
                                <div class="col-mdd-10 form_vr"><?php echo $hotel_email; ?></div>
                            </td>

                            <td>
                                <div class="col-mdd-2 form_v_hotel_book"><strong>Check Out Date</strong></div>
                            </td>

                            <td>
                                <div class="col-mdd-10 form_vr">
                                    <?php echo display_month_name($hotel_book->check_out); ?></div>
                            </td>

                        </tr>



                        <tr>

                            <td>
                                <div class="col-mdd-2 form_v_hotel_book"><strong>Hotel Contact Number:</strong></div>
                            </td>

                            <td>
                                <div class="col-mdd-10 form_vr"><?php echo $hotel_contact; ?></div>
                            </td>

                            <td>
                                <div class="col-mdd-2 form_v_hotel_book"><strong>Duration </strong></div>
                            </td>

                            <td>
                                <div class="col-mdd-10 form_vr"><?php echo $duration; ?></div>
                            </td>



                        </tr>



                        <?php 

						/* Calculate total cost */

						$total_rooms 	= $hotel_book->total_rooms;

						$room_rate 		= $hotel_book->room_cost;

						$total_room_cost_pernight = $total_rooms * $room_rate;

						$extra_bed 			= $hotel_book->extra_bed;

						$extra_bed_cost 	= !empty($hotel_book->extra_bed_cost) ? $hotel_book->extra_bed_cost : 0;

						$extra_bed_cost_per_night = $extra_bed * $extra_bed_cost;

						

						//Without extra bed default: 1 for old entries
						$w_extra_bed 		= !empty($hotel_book->without_extra_bed) ? $hotel_book->without_extra_bed : 1;
						$without_extra_bed_cost = !empty($hotel_book->without_extra_bed_cost) ? $hotel_book->without_extra_bed_cost * $w_extra_bed : 0;
						$total_cost_rooms 	= $extra_bed_cost_per_night + $total_room_cost_pernight + $without_extra_bed_cost;
						$inclusion_cost 	= $hotel_book->inclusion_cost;
						$hotel_tax 			= $hotel_book->hotel_tax;
						$total_cost			 = number_format($hotel_book->total_cost);
					?>

                        <tr>
                            <td>
                                <div class="col-mdd-2 form_v_hotel_book"><strong>Meal Plan</strong></div>
                            </td>

                            <td>
                                <div class="col-mdd-10 form_vr">
                                    <?php echo $hotel_book->meal_plan ? get_meal_plan_name($hotel_book->meal_plan) : "No"; ?>
                                </div>
                            </td>





                            <td>
                                <div class="col-mdd-2 form_v_hotel_book"><strong>Room Rate:</strong>(room rate*total
                                    rooms) </div>
                            </td>
                            <td>
                                <div class="col-mdd-10 form_vr">INR.
                                    <?php echo $room_rate . " /-Per Night * " . $total_rooms . " = "." INR." . number_format($total_room_cost_pernight) ; ?>
                                </div>
                            </td>




                        </tr>

                        <tr>

                            <?php $inclusion = $hotel_book->inclusion; ?>

                            <?php $inc =  !empty( $inclusion ) ? $inclusion : ""; ?>



                            <td>
                                <div class="col-mdd-2 form_v_hotel_book"><strong>Inclusion: </strong></div>
                            </td>

                            <td>
                                <div class="col-mdd-10 form_vr"><?php echo $inc ; ?></div>
                            </td>

                            <td>
                                <div class="col-mdd-2 form_v_hotel_book"><strong>Extra Bed Cost:(bed cost*total bed)
                                    </strong></div>
                            </td>

                            <?php if( $extra_bed > 0 ){ ?>

                            <td>
                                <div class="col-mdd-10 form_vr">
                                    <?php echo $extra_bed_cost . " /-Per Bed * " . $extra_bed . " = " . number_format($extra_bed_cost_per_night); ?>
                                </div>

                            </td>

                            <?php }else{ ?>

                            <td>
                                <div class="col-mdd-10 form_vr">-</div>
                            </td>

                            <?php } ?>

                        </tr>

                        <!--without extra bed-->

                        <?php if( !empty( $without_extra_bed_cost ) ){ ?>

                        <tr>

                            <td></td>

                            <td></td>

                            <td>
                                <div class="col-mdd-2 form_v_hotel_book"><strong>Without Extra Bed Costs ( without bed
                                        cost*total without bed): </strong></div>
                            </td>

                            <td>
                                <div class="col-mdd-10 form_vr">
                                    <?php echo $hotel_book->without_extra_bed_cost . " * " . $w_extra_bed . " = " . number_format($without_extra_bed_cost); ?>
                                </div>
                            </td>

                        </tr>

                        <?php } ?>

                        <tr>

                            <td></td>

                            <td></td>

                            <td>
                                <div class="col-mdd-2 form_v_hotel_book"><strong>Total Nights
                                        Cost:</strong>(TRC+WBC+EBC)*TN</div>
                            </td>

                            <td>
                                <div class="col-mdd-10 form_vr">INR.
                                    <?php echo number_format($total_cost_rooms) . " * " . $nights; ?></div>
                            </td>

                        </tr>

                        <tr>

                            <td></td>

                            <td></td>

                            <td>
                                <div class="col-mdd-2 form_v_hotel_book"><strong>Total Rooms Costs: </strong></div>
                            </td>

                            <td>
                                <div class="col-mdd-10 form_vr">INR.
                                    <?php echo number_format($total_cost_rooms * $nights); ?></div>
                            </td>

                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>
                                <div class="col-mdd-2 form_v_hotel_book"><strong>Inclusion Charges: </strong></div>
                            </td>

                            <td>
                                <div class="col-mdd-10 form_vr">INR.
                                    <?php echo  !empty($inclusion_cost) ? $inclusion_cost : 0; ?></div>
                            </td>

                        </tr>



                        <tr>

                            <td></td>

                            <td></td>

                            <td>
                                <div class="col-mdd-2 form_v_hotel_book"><strong>Hotel Tax: </strong></div>
                            </td>

                            <td>
                                <div class="col-mdd-10 form_vr">INR. <?php echo  !empty($hotel_tax) ? $hotel_tax : 0; ?>
                                </div>
                            </td>

                        </tr>

                        <tr class="total-cost">
                            <td></td>
                            <td></td>
                            <td>
                                <div class="col-mdd-2 form_v_hotel_book"><strong>Total Cost: </strong></div>
                            </td>
                            <td>
                                <div class="col-mdd-10 form_vr">INR. <?php echo $total_cost . " /-"; ?></div>
                            </td>
                        </tr>
                    </table>
                </div>

                <?php if( empty( $hotel_book->booking_status ) ){ ?>
                <div class="text-center"><a style="display:inline;"
                        href="<?php echo site_url("hotelbooking/edit/{$hotel_book->id}/{$hotel_book->iti_id}"); ?>"
                        class='btn btn-success' title="Update Hotel Booking Info"><i class='fa fa-pencil'></i> Update
                        Booking</a></div>
                <hr>
                <?php } ?>


                <div class="clearfix well bg_white">
                    <?php
				$agent_id = $hotel_book->agent_id;
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

        <!--Sent Hotel Booking Mail Modal-->
        <div class="modal fade" id="sendHotelBookingModal" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Send Hotel Booking</h4>
                    </div>
                    <div class="modal-body">
                        <form id="senthotelBookForm">
                            <?php //Get Hotel Information 
			$htl_info = get_hotel_details($hotel_book->hotel_id);;
			$hotel_info = $htl_info[0];
			$hotel_name = $hotel_info->hotel_name;
			$hotel_emails = $hotel_info->hotel_email; ?>
                            <div class="form-group">
                                <label for="email">Hotel Emails:</label>
                                <input required type="text" readonly value="<?php echo $hotel_emails; ?>"
                                    class="form-control" id="email" placeholder="Enter customer email">
                            </div>
                            <div class="form-group">
                                <label for="sub">Subject:</label>
                                <input type="text" required class="form-control" id="sub"
                                    placeholder="Final confirmation Mail" name="subject" value="">
                            </div>
                            <input type="hidden" name="iti_id" value="<?php echo $hotel_book->iti_id; ?>">
                            <input type="hidden" name="hotel_id" value="<?php echo $hotel_book->hotel_id; ?>">
                            <input type="hidden" name="id" value="<?php echo $hotel_book->id; ?>">
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

        <!--Sent Hotel Cancel Mail Modal-->
        <div class="modal fade" id="cancelHotelBookingModal" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Cancel Hotel Booking</h4>
                    </div>
                    <div class="modal-body">
                        <form id="cancelhotelBookForm">
                            <?php //Get Hotel Information 
			$htl_info = get_hotel_details($hotel_book->hotel_id);;
			$hotel_info = $htl_info[0];
			$hotel_name = $hotel_info->hotel_name;
			$hotel_emails = $hotel_info->hotel_email; ?>
                            <div class="form-group">
                                <label for="email">Hotel Emails:</label>
                                <textarea required readonly class="form-control" id="email"
                                    name=""><?php echo $hotel_emails; ?></textarea>
                                <!--input required type="hidden" readonly value="<?php //echo $hotel_emails; ?>" class="form-control" id="email" placeholder="Enter customer email" -->
                            </div>
                            <div class="form-group">
                                <label for="sub">Subject*:</label>
                                <input type="text" required class="form-control" id="sub"
                                    placeholder="Cancellation confirmation Mail" name="subject" value="">
                            </div>

                            <div class="form-group">
                                <label for="sub">Comment*:</label>
                                <textarea required class="form-control" placeholder="Cancellation Comment"
                                    name="comment"></textarea>
                            </div>

                            <input type="hidden" name="iti_id" value="<?php echo $hotel_book->iti_id; ?>">
                            <input type="hidden" name="hotel_id" value="<?php echo $hotel_book->hotel_id; ?>">
                            <input type="hidden" name="id" value="<?php echo $hotel_book->id; ?>">
                            <button type="submit" id="sentIti_btn" class="btn btn-success">Send Cancellation
                                Mail</button>
                            <div class="sam_res"></div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!--Sent Hotel Cancel Mail Modal-->
        <div class="modal fade" id="pre_cancelHotelBookingModal" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Cancel Hotel Booking</h4>
                    </div>
                    <div class="modal-body">
                        <form id="pre_cancelhotelBookForm">
                            <div class="form-group">
                                <label for="sub">Comment*:</label>
                                <textarea required class="form-control" placeholder="Cancellation Comment"
                                    name="comment"></textarea>
                            </div>
                            <input type="hidden" name="id" value="<?php echo $hotel_book->id; ?>">
                            <button type="submit" id="sentIti_btn" class="btn btn-success">Cancel Booking</button>
                            <div class="sam_ress"></div>
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
                        url: "<?=site_url('hotelbooking/ajax_send_quotaion_to_gm')?>",
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

    //Duplicate Button click
    $(document).on("click", "#clone_hotel_booking", function(e) {
        e.preventDefault();
        var _href = $(this).attr("href");
        if (confirm("Are you sure to Clone hotel booking?")) {
            window.location.href = _href;
        }
    });
    //Cancel Booking Status
    $(document).on("click", "#cancle_pre_booking", function(e) {
        e.preventDefault();
        var id = $(this).attr("data-id");
        $("#pre_cancelHotelBookingModal").modal("show");
        /* if (confirm("Are you sure to cancel hotel booking?")) {
        	$.ajax({
        		url: "<?php echo base_url(); ?>" + "hotelbooking/ajax_update_cancelstatus?id=" + id,
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
        } 		 */
    });

    //cancel booking
    $("#pre_cancelhotelBookForm").validate({
        submitHandler: function(form) {
            var resp = $(".sam_ress");
            var formData = $("#pre_cancelhotelBookForm").serializeArray();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('hotelbooking/ajax_update_cancelstatus'); ?>",
                dataType: 'json',
                data: formData,
                beforeSend: function() {
                    resp.html(
                        "<div class='alert alert-info'><strong>Please wait</strong> sending mail.....</div>"
                    );
                },
                success: function(res) {
                    if (res.status == true) {
                        resp.html(
                            '<div class="alert alert-success"><strong>Success! </strong>' +
                            res.msg + '</div>');
                        //console.log(res.msg);
                        alert(res.msg);
                        location.reload();
                    } else {
                        resp.html(
                            '<div class="alert alert-danger"><strong>Error! </strong>' +
                            res.msg + '</div>');
                        console.log("error");
                    }
                },
                error: function(e) {
                    //console.log(e);
                    resp.html(
                        '<div class="alert alert-danger"><strong>Error!</strong> Please Reload Page and Try again later! </div>'
                    );
                }
            });
        }
    });

    var ajaxReq;
    $("#hotel_email_sent").click(function(e) {
        e.preventDefault();
        //open modal 
        $('#sendHotelBookingModal').modal('show');
    });


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
                url: "<?php echo base_url('hotelbooking/senthotelbooking'); ?>",
                dataType: 'json',
                data: formData,
                beforeSend: function() {
                    resp.html(
                        "<div class='alert alert-info'><strong>Please wait</strong> sending mail.....</div>"
                    );
                },
                success: function(res) {
                    if (res.status == true) {
                        resp.html(
                            '<div class="alert alert-success"><strong>Success! </strong>' +
                            res.msg + '</div>');
                        //console.log(res.msg);
                        alert(res.msg);
                        location.reload();
                    } else {
                        resp.html(
                            '<div class="alert alert-danger"><strong>Error! </strong>' +
                            res.msg + '</div>');
                        console.log("error");
                    }
                },
                error: function(e) {
                    //console.log(e);
                    resp.html(
                        '<div class="alert alert-danger"><strong>Error!</strong> Please Reload Page and Try again later! </div>'
                    );
                }
            });
        }
    });
});
</script>

<script type="text/javascript">
jQuery(document).ready(function($) {
    //Cancel Booking Status
    $(document).on("click", "#update_closeStatus", function(e) {
        e.preventDefault();
        $('#cancelHotelBookingModal').modal('show');
    });
    //cancel booking
    $("#cancelhotelBookForm").validate({
        submitHandler: function(form) {
            $("#sentIti_btn").attr("disabled", "disabled");
            var ajaxReq;
            var resp = $(".sam_res");
            var formData = $("#cancelhotelBookForm").serializeArray();
            if (ajaxReq) {
                ajaxReq.abort();
            }
            ajaxReq = $.ajax({
                type: "POST",
                url: "<?php echo base_url('hotelbooking/cancel_hotel_booking'); ?>",
                dataType: 'json',
                data: formData,
                beforeSend: function() {
                    resp.html(
                        "<div class='alert alert-info'><strong>Please wait</strong> sending mail.....</div>"
                    );
                },
                success: function(res) {
                    if (res.status == true) {
                        resp.html(
                            '<div class="alert alert-success"><strong>Success! </strong>' +
                            res.msg + '</div>');
                        //console.log(res.msg);
                        alert(res.msg);
                        location.reload();
                    } else {
                        resp.html(
                            '<div class="alert alert-danger"><strong>Error! </strong>' +
                            res.msg + '</div>');
                        console.log("error");
                    }
                },
                error: function(e) {
                    //console.log(e);
                    resp.html(
                        '<div class="alert alert-danger"><strong>Error!</strong> Please Reload Page and Try again later! </div>'
                    );
                }
            });
        }
    });
    /* var _this = $(this);
		var id = _this.attr("data-id");
		
		if (confirm("Are you sure you want to cancel booking.?")) {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url('hotelbooking/cancel_hotel_booking'); ?>" ,
				dataType: 'json',
				data: {id: id},
				beforeSend: function(){
					//resp.html('<p><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
				},
				success: function(res) {
					if (res.status == true){
						console.log("done");
						location.reload(); 
					}else{
						alert("Error! Please try again later.");
						console.log("error");
					}
				},
				error: function(e){
					console.log(e);
				}
			});
		}	
	}); */
});
</script>