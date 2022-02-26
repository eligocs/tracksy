<!--link href="<?php echo base_url();?>site/assets/css/lightbox.min.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url();?>site/assets/js/lightbox-plus-jquery.min.js" type="text/javascript"></script-->
<style>
.showonPchange,
.new_pricesend {
    display: none;
}
</style>
<style>
.mt-element-step .step-line .mt-step-number>i {
    top: 78%;
}
</style>
<div class="page-container itinerary-view">
    <div class="page-content-wrapper">
        <div class="page-content">
            <!-- BEGIN SAMPLE TABLE PORTLET-->
            <?php $message = $this->session->flashdata('success');
		if($message){ echo '<span class="help-block help-block-success">'.$message.'</span>'; }
		?>
            <?php if( !empty($itinerary[0] ) ){ 			
				$iti = $itinerary[0];
				$doc_path =  base_url() .'site/assets/client_docs/';
				$is_amendment = $amendment_note = "";
				$get_rate_meta = unserialize( $iti->rates_meta );
				
				//show amendment note if revised itinerary
				if( $iti->is_amendment == 2 ){ 
					$is_amendment = "<h3 class='text-center red'>REVISED ITINERARY</h3>";
					$amendment_cmt = $this->global_model->getdata( "iti_amendment_temp", array( "iti_id" => $iti->iti_id ) );
					$amendment_note = !empty( $amendment_cmt ) ? "<p class='red'>Amendment: {$amendment_cmt[0]->review_comment}</p>" : "";
				}
				
				$terms = get_terms_condition();
				$online_payment_terms	 	= isset($terms[0]) && !empty($terms[0]->bank_payment_terms_content) ? unserialize($terms[0]->bank_payment_terms_content) : "";
				$advance_payment_terms		= isset($terms[0]) && !empty($terms[0]->advance_payment_terms) ? unserialize($terms[0]->advance_payment_terms	) : "";
				$cancel_tour_by_client 		= isset($terms[0]) && !empty($terms[0]->cancel_content) ? unserialize( $terms[0]->cancel_content) : "";
				$terms_condition			= isset($terms[0]) && !empty($terms[0]->terms_content) ? unserialize($terms[0]->terms_content) : "";
				$disclaimer 				= isset($terms[0]) && !empty($terms[0]->disclaimer_content) ? htmlspecialchars_decode($terms[0]->disclaimer_content) : "";
				$greeting 					= isset($terms[0]) && !empty($terms[0]->greeting_message) ? $terms[0]->greeting_message : "";
				$amendment_policy			= isset($terms[0]) && !empty($terms[0]->amendment_policy) ? unserialize( $terms[0]->amendment_policy) : "";
				$book_package_terms			= isset($terms[0]) && !empty($terms[0]->book_package) ? unserialize( $terms[0]->book_package) : "";
				$signature					= isset($terms[0]) && !empty($terms[0]->promotion_signature) ?  htmlspecialchars_decode($terms[0]->promotion_signature) : "";
				$payment_policy				= isset($terms[0]) && !empty($terms[0]->payment_policy) ? unserialize($terms[0]->payment_policy) : "";
				
				//Get customer info
				$get_customer_info = get_customer( $iti->customer_id ); 
				$customer_name = $customer_contact = $customer_email = $ref_name = $ref_contact = $cus_type = "";
				$country_name 	= isset($get_customer_info[0]) ? get_country_name($get_customer_info[0]->country_id) : "";
				$state_name 	= isset($get_customer_info[0]) ? get_state_name($get_customer_info[0]->state_id) : "";
				if( $get_customer_info ){
					$cust = $get_customer_info[0];
					$customer_name 		= $cust->customer_name;
					$customer_contact 	= $cust->customer_contact;
					$customer_email		= $cust->customer_email;
					
					$cus_type 			= get_customer_type_name($cust->customer_type);
					if( $cust->customer_type == 2 ){
						$ref_name = "< Ref. Name: " . $cust->reference_name;
						$ref_contact = " Ref. Contact: " . $cust->reference_contact_number . " >";
					}
				}
				?>

            <div class="portlet box blue mb0">
                <div class="portlet-title">
                    <div class="caption"><i class="fa fa-users"></i>
                        <strong>Lead Id: </strong><span class=""> <?php echo $iti->customer_id; ?></span> &nbsp;
                        &nbsp;&nbsp; &nbsp;
                        <?php if( is_admin_or_manager() ){ ?>
                        <strong>Lead Type: </strong><span class=""><?php echo $cus_type; ?>&nbsp; &nbsp;&nbsp; &nbsp;
                        </span> <?php echo $ref_name . $ref_contact; ?>
                        <?php } ?>
                        Q. Type: <strong class="">
                            <?php echo check_iti_type( $iti->iti_id ) . ' ( ' . $iti->iti_package_type . ')'; ?></strong>

                        <?php echo !empty($country_name) ? " From: <span class=''>" . $country_name . " ( $state_name ) </span>" : ""; ?>
                    </div>
                    <a class="btn btn-success pull-right" href="<?php echo site_url("itineraries"); ?>"
                        title="Back">Back</a>
                    <a class="btn btn-info pull-right" style='margin: 5px;' onclick="Print_iti();"
                        href="javscript:void(0)" title="Back">Print</a>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="custom_card">
                <?php if( isset( $paymentDetails[0] ) && !empty( $paymentDetails[0] ) && $iti->iti_status == 9 ){ 
						$pay_detail = $paymentDetails[0];
						$doc_path =  base_url() .'site/assets/client_docs/';
						//$is_gst_final = $paymentDetails[0]->is_gst == 1 ? "GST Inc." : "GST Extra";
						$is_gst_final = "";

						if( $iti->iti_close_status == 1 ){
							$close_status = "<strong class='red'>ITINERARY CLOSED</strong>";
							$invoice_btn = "";
						}else{
							$close_status = "<strong class='green'>ITINERARY OPEN</strong>";
							$invoice_btn = "<a target='_blank' href='" . site_url("/accounts/create_receipt/{$iti->customer_id}") . "' title='Click here to generate invoice' class='btn btn-success'>Click Here To Generate Invoice</a>";
						}
						echo "<h1 class='text-center margin-bottom-30'>" . $close_status. "</h1>";
						?>

                <div class="mt-element-step">
                    <div class="row step-background-thin ">
                        <div class="col-md-4 bg-grey-steel mt-step-col error ">
                            <div class="mt-step-number">1</div>
                            <div class="mt-step-title uppercase font-grey-cascade"><strong>INR
                                    <?php echo $iti->final_amount; ?>/- </strong></div>

                            <div class="mt-step-content font-grey-cascade">Package Final Cost: <span
                                    style="color: #fff;">(<?php echo $is_gst_final;  ?>)</span></div>
                        </div>
                        <div class="col-md-4 bg-grey-steel mt-step-col active">
                            <div class="mt-step-number">2</div>
                            <div class="mt-step-title uppercase font-grey-cascade">
                                <strong><?php echo $iti->approved_package_category; ?></strong>
                            </div>
                            <div class="mt-step-content font-grey-cascade">Package Category</div>
                        </div>
                        <div class="col-md-4 bg-grey-steel mt-step-col done">
                            <?php $t_date = get_travel_date($iti->iti_id); ?>
                            <div class="mt-step-number">3</div>
                            <div class="mt-step-title uppercase font-grey-cascade">
                                <?php echo !empty($t_date) ? $t_date : "--/--/----"; ?></strong></div>
                            <div class="mt-step-content font-grey-cascade">Travel Date</div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="mt-element-step">
                    <div class="row step-background-thin ">
                        <div class="col-md-4 bg-grey-steel mt-step-col done ">
                            <div class="mt-step-number">1</div>
                            <div class="mt-step-title uppercase font-grey-cascade"><strong>INR
                                    <?php echo $paymentDetails[0]->advance_recieved; ?>/- </strong></div>
                            <div class="mt-step-content font-grey-cascade">Advance Recieved </div>
                        </div>
                        <div class="col-md-4 bg-grey-steel mt-step-col error">
                            <div class="mt-step-number">2</div>
                            <div class="mt-step-title uppercase font-grey-cascade">
                                <strong><?php echo $paymentDetails[0]->total_balance_amount; ?>/-</strong>
                            </div>
                            <div class="mt-step-content font-grey-cascade">Balance Pending</div>
                        </div>
                        <div class="col-md-4 bg-grey-steel mt-step-col active">
                            <?php $booking_d = $paymentDetails[0]->booking_date; ?>
                            <div class="mt-step-number">3</div>
                            <div class="mt-step-title uppercase font-grey-cascade">
                                <?php echo !empty($booking_d) ? display_month_name($booking_d ) : "--/--/----"; ?></strong>
                            </div>
                            <div class="mt-step-content font-grey-cascade">Booking Date</div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>

            <!--show payment screenshot details-->
            <hr>
            <div class="custom_card" id="update_iti_hold_status">
                <!-- client_aadhar_card payment_screenshot -->
                <?php
                $aadhar_card_img = !empty( $pay_detail->client_aadhar_card ) ? $pay_detail->client_aadhar_card : "";
                $payment_screenshot = !empty( $pay_detail->payment_screenshot ) ? $pay_detail->payment_screenshot : "";
				?>
                <div class="col-md-4">
                    <h4 class="uppercase">Aadhar Card Screenshot</h4>
                    <?php if($aadhar_card_img){ ?>
                        <a target="_blank" href="<?php echo $doc_path . $aadhar_card_img; ?>" class="example-image-link"
                            data-lightbox="example-set" data-title="Adhar card Screenshot.">
                            <img src="<?php echo $doc_path . $aadhar_card_img; ?>" width="150" height="150"
                                class="image-responsive">
                        </a>
                    <?php }else{
                        echo "<strong class='red'>Aadhar card Not Updated</strong>";
                        //echo '<img src=" ' . $doc_path . 'dummy.jpg" width="150" height="150" class="image-responsive">';
                    } ?>
                </div>
                <div class="col-md-4">
                    <h4 class="uppercase">Payment Screenshot</h4>
                    <?php if($payment_screenshot){ ?>
                    <a target="_blank" href="<?php echo $doc_path . $payment_screenshot; ?>" class="example-image-link"
                        data-lightbox="example-set" data-title="Client Payment Screenshot.">
                        <img src="<?php echo $doc_path . $payment_screenshot; ?>" width="150" height="150"
                            class="image-responsive">
                    </a>
                    <?php }else{
                        echo "<strong class='red'>Payment Screenshot Not Updated</strong>";
                        //echo '<img src=" ' . $doc_path . 'dummy.jpg" width="150" height="150" class="image-responsive">';
                    } ?>
                </div>
                <div class="col-md-4">
                    <h4 class="uppercase">Iti Status</h4>
                    <?php 
							if( $pay_detail->iti_booking_status == 0 ){
								echo "<strong class='green'>APPROVED</strong>";
							}else if( $pay_detail->iti_booking_status == 1 ){ 
								echo '<strong class="red">ON HOLD</strong>';
							}else{ 
								echo '<strong class="red">REJECTED BY SALES MANAGER</strong>';
							} ?>
                    <p><span class="red">Comment: </span><?php echo $pay_detail->approved_note; ?></p>
                </div>
                <div class="clearfix"></div>

                <!--INVOICE BUTTON -->
                <hr>
                <div class="invoice_btn text-center margin-top-10 margin-bottom-10"><?php echo $invoice_btn; ?>
                </div>

                <div class="clearfix"></div>

                <div class="col-md-12 other_docs">
                    <?php if (isset( $iti_clients_docs ) && !empty( $iti_clients_docs ) ){
										echo '<hr><h4 class="uppercase">Other Documents</h4>'; ?>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-default">
                                <tr>
                                    <th> Sr. </th>
                                    <th> Title</th>
                                    <th> Comment</th>
                                    <th> Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
										$docindex = 1; 
										foreach( $iti_clients_docs as $ind => $doc ){
											echo "<tr>";
												echo "<td>" . $docindex . "</td>";
												echo "<td>" . $doc->file_url . "</td>";
												echo "<td>" . $doc->comment . "</td>";
												echo "<td>"; ?>
												<a href="<?php echo $doc_path . $doc->file_url; ?>" target="_blank" class="btn_eye"
													style="position:relative;">
													<i class="fa fa-eye"></i></a>
                                </td>
                                <?php 	
										echo "</tr>";	
										$docindex++;
									} ?>
                            </tbody>
                        </table>
                    </div>
                    <?php } ?>
                </div>

                <?php } ?>
            </div>

            <div class="clearfix"></div>

            <?php if( $iti->iti_close_status == 0 ){ ?>
            <!--VOUCHER GENERATION SECTION IF ITINERARY OPEN-->
            <hr>
            <div class="mt-element-step">
                <div class="row step-line">
                    <div class="mt-step-desc custom_card">
                        <div class="font-dark bold uppercase text-center">
                            <h2>BOOKING STATUS</h2>
                        </div>
                        <div class="caption-desc font-grey-cascade"></div>
                        <br />
                    </div>

                    <!--BOOKING DETAILS -->

                    <!--Show cab booking if any-->

                    <div class="portlet box blue margin-top-40">
                        <div class="portlet-title">
                            <div class="custom_title"><i class="fa fa-cab"></i> Cab Booking Details</div>
                        </div>
                        <div class="portlet-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="thead-default">
                                        <tr>
                                            <th>Sr.</th>
                                            <th> Cab </th>
                                            <th> Transporter Name </th>
                                            <th> Routing </th>
                                            <th> Sent Status </th>
                                            <th> Status </th>
                                            <th> Action </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
													$continue_cab = TRUE;
													if( $cab_bookings ){	
													$cc = 1;
														foreach( $cab_bookings as $c_book ){
															//Get hotel booking status-->
															if( $c_book->booking_status == 9 ){
																$status = "<span class='green'>BOOKED</span>";
															}else if($c_book->booking_status == 8){
																$status = "<span class='red'>Declined</span>";
															}else if( $c_book->booking_status == 7 ){
																$status = "<strong class='red'><i class='fa fa-close' aria-hidden='true'></i> &nbsp;Canceled</strong>";
															}else{
																$continue_cab = false;
																$status = "<span class='blue'><i class='fa fa-refresh'></i> Processing</span>";
															}
															?>
                                        <tr>
                                            <td><?php echo $cc; ?>.</td>
                                            <td><?php echo get_car_name($c_book->cab_id); ?></td>
                                            <td><?php echo get_transporter_name($c_book->transporter_id); ?></td>
                                            <td><?php echo $c_book->pic_location . " - " . $c_book->drop_location; ?>
                                            </td>
                                            <td><?php echo $c_book->email_count . " Time Sent"; ?></td>
                                            <td><?php echo $status; ?></td>
                                            <td><a title='View'
                                                    href="<?php echo site_url("vehiclesbooking/viewbooking/{$c_book->id}"); ?>"
                                                    class='btn_eye'><i class='fa fa-eye' aria-hidden='true'></i></a>
                                            </td>
                                        </tr>
                                        <?php $cc++; ?>
                                        <?php }
													}else{ ?>
                                        <tr>
                                            <td colspan="4">No Cab booking create against this itinerary.</td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <!--End cab booking if any-->
                        </div>
                    </div>

                    <!--Show Volvo/Train/Flight booking if any-->
                    <div class="portlet box blue">
                        <div class="portlet-title">
                            <div class="custom_title"><i class="fa fa-plane"></i> Volvo/Train/Flight Booking Details
                            </div>
                        </div>
                        <div class="portlet-body ">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="thead-default">
                                        <tr>
                                            <th> Sr. </th>
                                            <th> Type </th>
                                            <th> Iti Id </th>
                                            <th> Departure Date </th>
                                            <th> Status </th>
                                            <th> Action </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
												$continue_vtf = TRUE;
												if( $vtf_bookings ){ 
													$cv = 1;
													foreach( $vtf_bookings as $vtf_book ){
														//Get hotel booking status-->
														if( $vtf_book->booking_status == 9 ){
															$status = "<span class='green'>BOOKED</span>";
														}else if($vtf_book->booking_status == 8){
															$status = "<span class='red'>Declined</span>";
														}else{
															$continue_vtf = false;
															$status = "<span class='blue'><i class='fa fa-refresh'></i> Processing</span>";
														}
														?>
                                        <tr>
                                            <td><?php echo $cv; ?></td>
                                            <td><?php echo $vtf_book->booking_type; ?></td>
                                            <td><?php echo $vtf_book->iti_id; ?></td>
                                            <td><?php echo $vtf_book->dep_date; ?></td>
                                            <td><?php echo $status; ?></td>
                                            <td><a title='View'
                                                    href="<?php echo site_url("vehiclesbooking/viewvehiclebooking/{$vtf_book->id}/{$vtf_book->iti_id}"); ?>"
                                                    class='btn btn-success'><i class='fa fa-eye'
                                                        aria-hidden='true'></i></a></td>
                                        </tr>
                                        <?php 
														$cv++;
													} ?>
                                        <?php }else{ ?>
                                        <tr>
                                            <td colspan="4">No Volvo/Train/Flight booking create against this
                                                itinerary.</td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                                <!--all vtf booking confirmation button -->
                            </div>
                        </div>
                    </div>
                    <!--End Volvo/Train/Flight booking if any-->

                    <!--Show hotel booking if any-->
                    <div class="portlet box blue">
                        <div class="portlet-title">
                            <div class="custom_title"><i class="fa fa-calendar"></i> Hotel Booking Details</div>
                        </div>
                        <div class="portlet-body ">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="thead-default">
                                        <tr>
                                            <th>Sr.</th>
                                            <th> City </th>
                                            <th> Hotel Name </th>
                                            <th> Sent Status </th>
                                            <th> Status </th>
                                            <th> Action </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
												$continue_hotel = true;
												if( $hotel_bookings ){ 
													$ch = 1;
													foreach( $hotel_bookings as $h_book ){
														//Get hotel booking status-->
														if( $h_book->booking_status == 9 ){
															$status = "<span class='green'>BOOKED</span>";
														}else if($h_book->booking_status == 8){
															$status = "<span class='red'>Declined</span>";
														}else if( $h_book->booking_status == 7 ){
															$status = "<strong class='red'><i class='fa fa-window-close' aria-hidden='true'></i> &nbsp;Canceled</strong>";
														}else{
															$continue_hotel = false;
															$status = "<span class='blue'><i class='fa fa-refresh'></i> Processing</span>";
														}
														?>

                                        <tr>
                                            <td><?php echo $ch; ?></td>
                                            <td><?php echo get_city_name($h_book->city_id); ?></td>
                                            <td><?php echo get_hotel_name($h_book->hotel_id); ?></td>
                                            <td><?php echo $h_book->email_count . " Time Sent"; ?></td>
                                            <td><?php echo $status; ?></td>
                                            <td><a title='View'
                                                    href="<?php echo site_url("hotelbooking/view/{$h_book->id}/{$h_book->iti_id}"); ?>"
                                                    class='btn_eye'><i class='fa fa-eye' aria-hidden='true'></i></a>
                                            </td>
                                        </tr>
                                        <?php 
														$ch++;
													} ?>
                                        <?php }else{ ?>
                                        <tr>
                                            <td colspan="5">No hotel booking create against this itinerary.</td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!--End hotel booking if any-->
                    <!--BOOKING DETAILS -->
                    <div class="portlet box blue">
                        <div class="portlet-body">
                            <?php 
								$hotel_booking_status 		= is_hotel_booking_done( $iti->iti_id );
								$vtf_booking_status			= is_vtf_booking_done( $iti->iti_id );
								$cab_booking_status			= is_cab_booking_done( $iti->iti_id );
								$total_payment_recieved_percentage = get_iti_pay_receive_percentage( $iti->iti_id );
								$is_voucher_confirm			 = is_voucher_confirm( $iti->iti_id );
								
								$pay_class 	=  $total_payment_recieved_percentage >= 50 ? "done" : "error"; 
								$hotel_class	 =  !empty( $hotel_booking_status ) ? "done" : "error";
								$vtf_class	 =  !empty($vtf_booking_status) ? "done" : "error"; 
								$cab_class	 =  !empty($cab_booking_status) ? "done" : "error"; ?>

                            <div class="col-md-3 mt-step-col <?php echo $vtf_class; ?>"
                                title="Volvo/Train/Flight Booking Status. Green = done, Red = Pending"
                                data-toggle="tooltip">
                                <div class="mt-step-number bg-white">
                                    <i class="fa fa-plane"></i>
                                </div>
                                <div class="mt-step-title uppercase font-grey-cascade">Fight/Train/volvo</div>
                            </div>

                            <div class="col-md-3 mt-step-col <?php echo $hotel_class; ?>"
                                title="Hotel Booking Status. Green = done, Red = Pending" data-toggle="tooltip">
                                <div class="mt-step-number bg-white">
                                    <i class="fa fa-bed"></i>
                                </div>
                                <div class="mt-step-title uppercase font-grey-cascade">Hotel Booking</div>
                            </div>

                            <div class="col-md-3 mt-step-col <?php echo $cab_class; ?>"
                                title="Cab Booking Status. Green = done, Red = Pending" data-toggle="tooltip">
                                <div class="mt-step-number bg-white">
                                    <i class="fa fa-bus"></i>
                                </div>
                                <div class="mt-step-title uppercase font-grey-cascade">Cab Booking</div>
                            </div>

                            <div class="col-md-3 mt-step-col <?php echo $pay_class; ?>"
                                title="Cab Booking Status. (Green >= 50 %, Red < 50%) Amount received"
                                data-toggle="tooltip">
                                <div class="mt-step-number bg-white">
                                    <i class="fa fa-inr"></i>
                                </div>
                                <div class="mt-step-title uppercase font-grey-cascade">Payments</div>
                                <div class="mt-step-content font-grey-cascade">Min. Fifty Percentage Amount
                                    ( Received Amount: <?php echo $total_payment_recieved_percentage; ?>% )</div>
                            </div>

							</div>
                    </div>
                            <!--show confirm voucher button if hotel and volovo/train/flight booking confirmed-->
                            <p class="text-center" style="font-size:12px; color: red;"><strong>Note: </strong>To confirm
                                voucher make sure that the all booking has been done.</p>
                            <?php if( $is_voucher_confirm ){
							echo "<p class='alert alert-success text-center green'><strong>Voucher has been Confirmed.</strong></p>";
							}else if( $hotel_booking_status && $vtf_booking_status && $cab_booking_status ){ ?>
                            <div class="text-center confirm_voucher">
                                <button type="submit" data-iti_id="<?php echo $iti->iti_id; ?>"
                                    class="btn green uppercase cnfrim_voucher" title="Confirm Voucher">Confirm
                                    Voucher</button>
                                <p style="font-size:12px; color: red;"><strong>Note: </strong>To confirm voucher make
                                    sure
                                    that the payment is received greater than <strong>50%</strong>.</p>
                            </div>

               
                    <div id="confirmVoucherModal" class="modal" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">Close</button>
                                    <h4 class="modal-title">Confirm Voucher</h4>
                                </div>
                                <div class="modal-body">
                                    <form id="frm_confirm_voucher">
                                        <div class="form-group">
                                            <label for="comment">Comment<span style="color:red;">*</span>:</label>
                                            <textarea required class="form-control" rows="3"
                                                name="agent_comment"></textarea>
                                        </div>
                                        <hr>
                                        <div class="form-group">
                                            <input type="hidden" name="iti_id" value="<?php echo $iti->iti_id; ?>">
                                            <input type="submit" class='btn btn-green' id="clone_current_iti"
                                                title='Confirm Voucher' value="Confirm Voucher" />
                                        </div>
                                        <div class="cnf_res"></div>
                                    </form>
                                </div>
                                <div class="modal-footer"></div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
                <!--End step line start-->
                <?php } ?>

                <div class="clearfix"></div>


                <!--GENERATE INVOICE AND PROCEED TO SERVICE TEAM SECTION-->

                <!--END GENERATE INVOICE AND PROCEED TO SERVICE TEAM -->
                <div class="clearfix"></div>
                <div class="row2">
                    <?php // echo $greeting; ?>
                    <div class="printable" id="printable">
                        <!--START PRINTABLE SECTION -->

                        <div class="portlet box blue margin-top-40 margin-top-40 margin-bottom-20">
                            <?php if( isset( $paymentDetails[0] ) && !empty( $paymentDetails[0] ) && $iti->iti_status == 9 ){ 
						$pay_detail = $paymentDetails[0]; ?>
                            <div class="portlet-title">
                                <h3 class="custom_title">Payments Details</h3>
                            </div>
                            <div class="clearfix"></div>
                            <div class="portlet-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered ">
                                        <tbody>
                                            <tr class="thead-inverse">
                                                <td width="33%"><strong>FINAL COST</strong></td>
                                                <td width="33%"><strong>Package Category</strong></td>
                                                <td width="33%"><strong>Travel Date</strong></td>
                                            </tr>


                                            <tr class="">
                                                <td width="33%"><strong>INR
                                                        <?php echo $paymentDetails[0]->total_package_cost; ?>/-</strong>
                                                </td>
                                                <td width="33%">
                                                    <strong><?php echo $iti->approved_package_category; ?></strong>
                                                </td>
                                                <td width="33%">
                                                    <strong><?php echo !empty($t_date) ? $t_date : "--/--/----"; ?></strong>
                                                </td>
                                            </tr>


                                            <tr class="thead-inverse">
                                                <td width="33%"><strong>Advance Recieved</strong></td>
                                                <td width="33%"><strong>Balance Pending</strong></td>
                                                <td width="33%"><strong>Booking Date</strong></td>
                                            </tr>
                                            <?php $booking_d = $paymentDetails[0]->booking_date; ?>
                                            <tr class="">
                                                <td width="33%"><strong>INR
                                                        <?php echo $paymentDetails[0]->advance_recieved; ?>/-</strong>
                                                </td>
                                                <td width="33%">
                                                    <strong><?php echo $paymentDetails[0]->total_balance_amount; ?>/-</strong>
                                                </td>
                                                <td width="33%">
                                                    <strong><?php echo !empty($booking_d) ? display_month_name($booking_d ) : "--/--/----"; ?></strong>
                                                </td>
                                            </tr>



                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <?php } ?>
                        </div>


                        <div class="portlet box blue margin-top-40">

                            <div class="portlet-title">
                                <div class="custom_title">Package Overview</div>
                            </div>

                            <div class="portlet-body ">
                                <div class="table-responsive">
                                    <table class="table table-bordered ">
                                        <tbody>
                                            <tr class="thead-inverse">
                                                <td width="33%"><strong>Name of Package</strong></td>
                                                <td width="33%"><strong>Routing</strong></td>
                                                <td width="33%"><strong>Duration</strong></td>
                                            </tr>
                                            <tr>
                                                <td><?php echo $iti->package_name; ?></td>
                                                <td><?php echo $iti->package_routing; ?></td>
                                                <td><?php echo $iti->duration; ?></td>
                                            </tr>

                                            <tr class="thead-inverse">
                                                <td><strong>No of Travellers</strong></td>
                                                <td><strong>Cab</strong></td>
                                                <td><strong>Quotation Date</strong></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="traveller-info">
                                                        <?php
										echo "<strong> Adults: </strong> " . $iti->adults; 
										if( !empty( $iti->child ) ){
											echo "  <strong> No. of Child: </strong> " . $iti->child; 
											echo " (" . $iti->child_age .")"; 
										}
										?>
                                                    </div>
                                                </td>
                                                <td><?php echo get_car_name($iti->cab_category); ?></td>
                                                <td><?php echo display_date_month_name($iti->quatation_date); ?>
                                                </td>
                                            </tr>
                                            <tr class="thead-inverse">
                                                <td><strong>Customer Name</strong></td>
                                                <td><strong>Contact</strong></td>
                                                <td><strong>Customer Email</strong></td>
                                            </tr>
                                            <tr>
                                                <td><?php echo $customer_name; ?></td>
                                                <td><?php echo $customer_contact; ?></td>
                                                <td><?php echo $customer_email; ?></td>
                                            </tr>
                                            <!--rooms meta section -->
                                            <?php
									$room_category = $total_rooms = $with_extra_bed  = $without_extra_bed = "-";
									if( isset( $iti->rooms_meta) && !empty( $iti->rooms_meta ) ){
										$rooms_meta 	= unserialize( $iti->rooms_meta );
										$room_category 	= isset($rooms_meta["room_category"]) && !empty( $rooms_meta["room_category"] ) ? get_roomcat_name($rooms_meta["room_category"]) : "-";
										$total_rooms 		= isset($rooms_meta["total_rooms"]) && !empty( $rooms_meta["total_rooms"] ) ? $rooms_meta["total_rooms"] : "-";
										$with_extra_bed 	= isset($rooms_meta["with_extra_bed"]) && !empty( $rooms_meta["with_extra_bed"] ) ? $rooms_meta["with_extra_bed"] : "-";
										$without_extra_bed 	= isset($rooms_meta["without_extra_bed"]) && !empty( $rooms_meta["without_extra_bed"] )  ? $rooms_meta["without_extra_bed"] : "-";
									}  ?>
                                            <tr>
                                                <td><strong>Room Category</strong></td>
                                                <td><strong>No. Of Rooms</strong></td>
                                                <td><strong>With Extra Bed</strong></td>
                                            </tr>
                                            <tr>
                                                <td><?php echo $room_category; ?></td>
                                                <td><?php echo $total_rooms; ?></td>
                                                <td><?php echo $with_extra_bed; ?></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Without Extra Bed</strong></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td><strong><?php echo $without_extra_bed; ?></strong></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>


                        <!--If Flight Exists-->
                        <?php if( isset( $flight_details ) && !empty( $flight_details ) && $iti->is_flight == 1 ){ ?>
                        <?php $flight = $flight_details[0]; ?>
                        <div class="portlet box blue">
                            <div class="portlet-title">
                                <h3 class="custom_title">Flight Details</h3>
                            </div>
                            <div class="portlet-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered ">
                                        <tbody>
                                            <tr class="thead-inverse">
                                                <td width="33%"><strong>Trip Type</strong></td>
                                                <td width="33%"><strong>Flight Name</strong></td>
                                                <td width="33%"><strong>Class</strong></td>
                                            </tr>
                                            <tr>
                                                <td><?php echo ucfirst($flight->trip_type); ?></td>
                                                <td><?php echo $flight->flight_name; ?></td>
                                                <td><?php echo $flight->flight_class; ?></td>
                                            </tr>
                                            <tr class="thead-inverse">
                                                <td width="33%"><strong>Departure City</strong></td>
                                                <td width="33%"><strong>Arrival city</strong></td>
                                                <td width="33%"><strong>No. of Passengers</strong></td>
                                            </tr>
                                            <tr>
                                                <td><?php echo $flight->dep_city; ?></td>
                                                <td><?php echo $flight->arr_city; ?></td>
                                                <td><?php echo $flight->total_passengers; ?></td>
                                            </tr>
                                            <tr class="thead-inverse">
                                                <td width="33%"><strong>Arrival Date/Time</strong></td>
                                                <td width="33%"><strong>Departure Date/Time</strong></td>
                                                <td width="33%"><strong>Return Date/Time</strong></td>
                                            </tr>
                                            <tr>
                                                <td><?php echo $flight->arr_time; ?></td>
                                                <td><?php echo $flight->dep_date; ?></td>
                                                <td><?php echo $flight->return_date; ?></td>
                                            </tr>
                                            <tr class="thead-inverse">
                                                <td width="33%"><strong>Return Arrival Date/Time</strong></td>
                                                <td width="33%"><strong>Price</strong></td>
                                            </tr>
                                            <tr>
                                                <td><?php echo $flight->return_arr_date; ?></td>
                                                <td><?php echo $flight->flight_price; ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>

                        <?php } ?>
                        <!--End Flight Section-->
                        <!--If Train Exists-->
                        <?php if( isset( $train_details ) && !empty( $train_details ) && $iti->is_train == 1 ){ ?>
                        <?php $train = $train_details[0]; ?>
                        <div class="portlet box blue">
                            <div class="portlet-title">
                                <h3 class="custom_title">Train Details</h3>
                            </div>
                            <div class="portlet-body">
                                <table class="table table-bordered ">
                                    <tbody>
                                        <tr class="thead-inverse">
                                            <td width="33%"><strong>Trip Type</strong></td>
                                            <td width="33%"><strong>Train Name</strong></td>
                                            <td width="33%"><strong>Train Number</strong></td>
                                        </tr>
                                        <tr>
                                            <td><?php echo ucfirst($train->t_trip_type); ?></td>
                                            <td><?php echo $train->train_name; ?></td>
                                            <td><?php echo $train->train_number; ?></td>
                                        </tr>
                                        <tr class="thead-inverse">
                                            <td width="33%"><strong>Departure City</strong></td>
                                            <td width="33%"><strong>Arrival city</strong></td>
                                            <td width="33%"><strong>No. of Passengers</strong></td>
                                        </tr>
                                        <tr>
                                            <td><?php echo $train->t_dep_city; ?></td>
                                            <td><?php echo $train->t_arr_city; ?></td>
                                            <td><?php echo $train->t_passengers; ?></td>
                                        </tr>
                                        <tr class="thead-inverse">
                                            <td width="33%"><strong>Arrival Date/Time</strong></td>
                                            <td width="33%"><strong>Departure Date/Time</strong></td>
                                            <td width="33%"><strong>Return Date/Time</strong></td>

                                        </tr>
                                        <tr>
                                            <td><?php echo $train->t_arr_time; ?></td>
                                            <td><?php echo $train->t_dep_date; ?></td>
                                            <td><?php echo $train->t_return_date; ?></td>
                                        </tr>
                                        <tr class="thead-inverse">
                                            <td width="33%"><strong>Return Arrival Date/Time</strong></td>
                                            <td width="33%"><strong>Price</strong></td>
                                            <td width="33%"><strong>Class</strong></td>
                                        </tr>
                                        <tr>
                                            <td><?php echo $train->t_return_arr_date; ?></td>
                                            <td><?php echo $train->t_cost; ?></td>
                                            <td><?php echo $train->train_class; ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="clearfix"></div>

                        <?php } ?>
                        <!--End Flight Section-->
                        <div class="portlet box blue margin-top-40">
                            <div class="portlet-title">
                                <h3 class="custom_title">Day Wise Itinerary</h3>
                            </div>
                            <div class="portlet-body">
                                <div class="table-responsive2">
                                    <table class="table table-bordered">
                                        <tbody>
                                            <?php //$day_wise = $iti->daywise_meta; 
														$tourData = unserialize($iti->daywise_meta);
														$count_day = count( $tourData );
														if( $count_day > 0 ){
															//print_r( $tourData );
															for ( $i = 0; $i < $count_day; $i++ ) {
															echo "<tr><td width='10%'>";
																$day = $i+1;
																echo "<span class=''><strong>Day: ".$tourData[$i]['tour_day']."</strong> </span>";
																echo "</td><td width='80%'>";
																echo "<!--<div class='some-space'></div>--><strong>" . $tourData[$i]['tour_name'] . "</strong>"; 
																echo "<strong>Tour Date:</strong><em> " .display_date_month($tourData[$i]['tour_date']) . "</em>"; 
																echo "<strong>Meal Plan:</strong><em> " .$tourData[$i]['meal_plan'] . "</em>"; 
																echo "<strong>Tour Description:</strong><em> " .$tourData[$i]['tour_des'] . "</em>"; 
																echo "<strong>Distance:</strong><em> " .$tourData[$i]['tour_distance'] . " KMS</em>";
																//hot destination
																if( isset($tourData[$i]['hot_des'] ) && !empty( $tourData[$i]['hot_des'] ) ){
																	$hot_dest = '';
																	$htd = explode(",", $tourData[$i]['hot_des']);
																	foreach($htd as $t) {
																		$t = trim($t);
																		$hot_dest .= "<span>" . $t . "</span>";
																	}
																	echo '<div class="hot_des_view "><strong>Attraction: </strong>' . $hot_dest . '</div>';
																}	
																echo "</td>";
															echo "</tr>";
															}
														}	?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="portlet box blue margin-top-40">
                            <div class='portlet-title'>
                                <h3 class="custom_title">Inclusion & Exclusion</h3>
                            </div>
                            <div class="portlet-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead class="thead-default">
                                            <tr class="thead-inverse">
                                                <th width="50%"> Inclusion</th>
                                                <th width="50%"> Exclusion</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
													$inclusion = unserialize($iti->inc_meta); 
													$count_inc = count( $inclusion );
													$exclusion = unserialize($iti->exc_meta); 
													$count_exc = count( $exclusion );
													echo "<tr><td><ul>";
													if( $count_inc > 0 ){
														for ( $i = 0; $i < $count_inc; $i++ ) {
															echo "<li>" . $inclusion[$i]["tour_inc"] . "</li>";
														}	
													}
													echo "</ul></td><td><ul>";
													if( $count_exc > 0 ){
														for ( $i = 0; $i < $count_exc; $i++ ) {
															echo "<li>" . $exclusion[$i]["tour_exc"] . "</li>";
														}	
													}
													echo "</ul></td></tr>";
													?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>


                        <div class="portlet box blue margin-top-40">
                            <?php 
												//check if special inclusion exists
												$sp_inc = unserialize($iti->special_inc_meta); 
												$count_sp_inc = count( $sp_inc );
											
												if( !empty($sp_inc) ){
													echo '<div class="portlet-title"><h3 class="custom_title">Special Inclusions</h3></div>';
													echo "<div class='portlet-body'>  <ul class='inclusion'>";
													if( $count_sp_inc > 0 ){
														for ( $i = 0; $i < $count_sp_inc; $i++ ) {	
															echo "<li>" . $sp_inc[$i]["tour_special_inc"] . "</li>";
														}	
													}
													echo "</ul> </div>";
													}
											?>
                        </div>


                        <div class="portlet box blue margin-top-40">
                            <div class='portlet-title'>
                                <h3 class="custom_title">Hotel Details</h3>
                            </div>
                            <div class="portlet-body">
                                <?php 
											$f_cost =  !empty( $iti->final_amount )  && $iti->iti_status == 9  && get_iti_booking_status($iti->iti_id) == 0 ? "<strong class='green'> " . number_format($iti->final_amount) . " /-</strong> " : "";
											//echo $f_cost;
											//if final price exists strike all price
											$strike_class_final = !empty( $iti->final_amount ) && $iti->iti_status == 9 ? "strikeLine" : "";
											
											$hotel_meta = unserialize($iti->hotel_meta); 
											if( !empty( $hotel_meta ) ){
												$count_hotel = count( $hotel_meta ); ?>
                                <div class="table-responsive margin_bottom_0">
                                    <table class="table table-bordered">
                                        <thead class="thead-default">
                                            <tr class="thead-inverse">
                                                <th> Hotel Category</th>
                                                <th> Deluxe</th>
                                                <th> Super Deluxe</th>
                                                <th> Luxury</th>
                                                <th> Super Luxury</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
												/* print_r( $hotel_meta ); */
												if( $count_hotel > 0 ){
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
													//Rate meta
													$rate_meta 	  = unserialize($iti->rates_meta);
													$strike_class = !empty( $discountPriceData ) ? "strikeLine" : " ";
													//print_r( $rate_meta );
													$iti_close_status = $iti->iti_close_status;
													//print_r( $rate_meta );
													if( empty($iti_close_status) ){
													if( !empty( $rate_meta ) ){
														if( $iti->pending_price == 4 ){
															echo "<tr><td  colspan=5 class='red'>Awaiting price verfication from super manager.</td></tr>"; 
														}else{
															$per_person_ratemeta 	= unserialize($iti->per_person_ratemeta);
															//$inc_gst = isset( $per_person_ratemeta["inc_gst"] ) && $per_person_ratemeta["inc_gst"] == 1 ? "(GST Inc.)" : "(GST Extra)";
															$inc_gst = "";
															//get percentage added by agent
															$agent_price_percentage = !empty($iti->agent_price) ? $iti->agent_price : 0;
															$agent_sp = $agent_dp = $agent_sdp = $agent_lp = "";
															//if percentage exists
															if( $agent_price_percentage ){
																$as_pp = isset( $per_person_ratemeta["standard_rates"] ) && !empty($per_person_ratemeta["standard_rates"]) ? " Rs." . ( $per_person_ratemeta["standard_rates"] +  $per_person_ratemeta["standard_rates"] * $agent_price_percentage/100 ). " Per/Person" : "";
																$ad_pp = isset( $per_person_ratemeta["deluxe_rates"] ) && !empty($per_person_ratemeta["deluxe_rates"]) ? " Rs." . ($per_person_ratemeta["deluxe_rates"] +  $per_person_ratemeta["deluxe_rates"] * $agent_price_percentage/100 ). " Per/Person" : "";
																$asd_pp = isset( $per_person_ratemeta["super_deluxe_rates"] ) && !empty($per_person_ratemeta["super_deluxe_rates"]) ? " Rs." . ( $per_person_ratemeta["super_deluxe_rates"] +  $per_person_ratemeta["super_deluxe_rates"] * $agent_price_percentage/100 ) . " Per/Person" : "";
																$al_pp = isset( $per_person_ratemeta["luxury_rates"] ) && !empty($per_person_ratemeta["luxury_rates"]) ? " Rs." . ( $per_person_ratemeta["luxury_rates"] +  $per_person_ratemeta["luxury_rates"] * $agent_price_percentage/100 ) . " Per/Person" : "";

																//child rates
																$achild_s_pp = isset( $per_person_ratemeta["child_standard_rates"] ) && !empty($per_person_ratemeta["child_standard_rates"]) ? "RS. " .  number_format( $per_person_ratemeta["child_standard_rates"]  + $per_person_ratemeta["child_standard_rates"] * $agent_price_percentage/100  ) . "/- Per Child" : "";
																
																$achild_d_pp = isset( $per_person_ratemeta["child_deluxe_rates"] ) && !empty($per_person_ratemeta["child_deluxe_rates"]) ? "RS. " . number_format( $per_person_ratemeta["child_deluxe_rates"] +  $per_person_ratemeta["child_deluxe_rates"] * $agent_price_percentage/100 ) . "/- Per Child" : "";
																
																$achild_sd_pp = isset( $per_person_ratemeta["child_super_deluxe_rates"] ) && !empty($per_person_ratemeta["child_super_deluxe_rates"]) ? "RS. " . number_format( $per_person_ratemeta["child_super_deluxe_rates"] +  $per_person_ratemeta["child_super_deluxe_rates"] * $agent_price_percentage/100 ) . "/- Per Child" : "";
																
																$achild_l_pp = isset( $per_person_ratemeta["child_luxury_rates"] ) && !empty($per_person_ratemeta["child_luxury_rates"]) ? "RS. " .   number_format( $per_person_ratemeta["child_luxury_rates"] +  $per_person_ratemeta["child_luxury_rates"] * $agent_price_percentage/100 ) . "/- Per Child" : "";													
																
																$astandard_rates = !empty( $rate_meta["standard_rates"]) ? number_format($rate_meta["standard_rates"] + $rate_meta["standard_rates"] * $agent_price_percentage / 100 ) . "/- {$inc_gst}" : "<strong class='red'>On Request</strong>";
																
																$adeluxe_rates = !empty( $rate_meta["deluxe_rates"]) ? number_format($rate_meta["deluxe_rates"] + $rate_meta["deluxe_rates"] * $agent_price_percentage / 100 ) . "/- {$inc_gst}" : "<strong class='red'>On Request</strong>";
																
																$asuper_deluxe_rates = !empty( $rate_meta["super_deluxe_rates"]) ? number_format($rate_meta["super_deluxe_rates"] + $rate_meta["super_deluxe_rates"] * $agent_price_percentage / 100  ) . "/- {$inc_gst}" : "<strong class='red'>On Request</strong>";
																$arate_luxry = !empty( $rate_meta["luxury_rates"]) ? number_format($rate_meta["luxury_rates"] + $rate_meta["luxury_rates"] * $agent_price_percentage / 100 ) . "/- {$inc_gst}" : "<strong class='red'>On Request</strong>";
																
																$agent_sp = "<strong class='aprice'> AP( " . $astandard_rates . "</strong>  {$as_pp}  {$achild_s_pp} )";
																$agent_dp = "<strong class='aprice'> AP( " . $adeluxe_rates . "</strong>  {$ad_pp}  {$achild_d_pp} )";
																$agent_sdp = "<strong class='aprice'> AP( " . $asuper_deluxe_rates . "</strong>  {$asd_pp}  {$achild_sd_pp} )";
																$agent_lp = "<strong class='aprice'> AP( " . $arate_luxry . "</strong>  {$al_pp}  {$achild_l_pp} )";
															}
															
															//get per person price
															$s_pp = isset( $per_person_ratemeta["standard_rates"] ) && !empty($per_person_ratemeta["standard_rates"]) ? "RS. " . number_format($per_person_ratemeta["standard_rates"]) . "/- Per Person" : "";
															
															$d_pp = isset( $per_person_ratemeta["deluxe_rates"] ) && !empty($per_person_ratemeta["deluxe_rates"]) ? "RS. " . number_format($per_person_ratemeta["deluxe_rates"]) . "/- Per Person" : "";
															
															$sd_pp = isset( $per_person_ratemeta["super_deluxe_rates"] ) && !empty($per_person_ratemeta["super_deluxe_rates"]) ? "RS. " . number_format($per_person_ratemeta["super_deluxe_rates"]) . "/- Per Person" : "";
															
															$l_pp = isset( $per_person_ratemeta["luxury_rates"] ) && !empty($per_person_ratemeta["luxury_rates"]) ? "RS. " . number_format($per_person_ratemeta["luxury_rates"]) . "/- Per Person" : "";
															
															//child rates
															$child_s_pp = isset( $per_person_ratemeta["child_standard_rates"] ) && !empty($per_person_ratemeta["child_standard_rates"]) ? "RS. " . $per_person_ratemeta["child_standard_rates"] . "/- Per Child" : "";
															$child_d_pp = isset( $per_person_ratemeta["child_deluxe_rates"] ) && !empty($per_person_ratemeta["child_deluxe_rates"]) ? "RS. " . $per_person_ratemeta["child_deluxe_rates"] . "/- Per Child" : "";
															
															$child_sd_pp = isset( $per_person_ratemeta["child_super_deluxe_rates"] ) && !empty($per_person_ratemeta["child_super_deluxe_rates"]) ? "RS. " . $per_person_ratemeta["child_super_deluxe_rates"] . "/- Per Child" : "";
															
															$child_l_pp = isset( $per_person_ratemeta["child_luxury_rates"] ) && !empty($per_person_ratemeta["child_luxury_rates"]) ? "RS. " . $per_person_ratemeta["child_luxury_rates"] . "/- Per Child" : "";
															
														
															$standard_rates = !empty( $rate_meta["standard_rates"]) ? "RS. " . number_format($rate_meta["standard_rates"]) . "/- {$inc_gst}" : "<strong class='red'>On Request</strong>";
															
															$deluxe_rates = !empty( $rate_meta["deluxe_rates"]) ? "RS. " . number_format($rate_meta["deluxe_rates"]) . "/- {$inc_gst}" : "<strong class='red'>On Request</strong>";
															
															$super_deluxe_rates = !empty( $rate_meta["super_deluxe_rates"]) ? "RS. " . number_format($rate_meta["super_deluxe_rates"]) . "/- {$inc_gst}" : "<strong class='red'>On Request</strong>";
															
															$rate_luxry = !empty( $rate_meta["luxury_rates"]) ? "RS. " . number_format($rate_meta["luxury_rates"]) . "/- {$inc_gst}" : "<strong class='red'>On Request</strong>";
															
															echo "<tr class='{$strike_class} {$strike_class_final}'><td>Price</td>
																	<td>		
																		<strong> BP( " . $standard_rates . "</strong>  {$s_pp}  {$child_s_pp} )
																		{$agent_sp}
																	</td>
																	<td>
																		<strong>BP( " . $deluxe_rates . "</strong>  {$d_pp} {$child_d_pp} )
																		{$agent_dp}
																	</td>
																	<td>
																		<strong>BP( " . $super_deluxe_rates . "</strong>  {$sd_pp} {$child_sd_pp} )
																		{$agent_sdp}
																	</td>
																	<td>
																		<strong>BP(  " . $rate_luxry . "</strong>  {$l_pp} {$child_l_pp} )
																		{$agent_lp}
																	</td></tr>";
														}		
													}else{
														echo "<tr><td><strong class='red'>Price</strong></td>
																<td>
																	<strong class='red'> Coming Soon </strong>
																</td>
																<td>
																	<strong class='red'> Coming Soon</strong>
																</td>
																<td>
																	<strong class='red'> Coming Soon </strong>
																</td>
																<td>
																	<strong class='red'> Coming Soon </strong>
																</td></tr>";
													}
													//discount data
													if( !empty( $discountPriceData ) ){
														foreach( $discountPriceData as $price ){
															$agent_price_percentage = !empty($price->agent_price) ? $price->agent_price : 0;
															$sent_status = $price->sent_status;
															//get per person price
															$per_person_ratemeta 	= unserialize($price->per_person_ratemeta);
															//$inc_gst = isset( $per_person_ratemeta["inc_gst"] ) && $per_person_ratemeta["inc_gst"] == 1 ? "(GST Inc.)" : "(GST Extra)";
															$inc_gst = "";
															
															$agent_sp = $agent_dp = $agent_sdp = $agent_lp = "";
															//if percentage exists
															if( $agent_price_percentage ){
																$ad_s_pp = isset( $per_person_ratemeta["standard_rates"] ) && !empty($per_person_ratemeta["standard_rates"] ) ? "RS. " . number_format( $per_person_ratemeta["standard_rates"] +  $per_person_ratemeta["standard_rates"] * $agent_price_percentage/100 ) . "/- Per Person" : "";
																$ad_d_pp = isset( $per_person_ratemeta["deluxe_rates"] ) && !empty($per_person_ratemeta["deluxe_rates"]) ? "RS. " . number_format($per_person_ratemeta["deluxe_rates"] +  $per_person_ratemeta["deluxe_rates"] * $agent_price_percentage/100 ) . "/- Per Person" : "";
																$ad_sd_pp = isset( $per_person_ratemeta["super_deluxe_rates"] ) && !empty($per_person_ratemeta["super_deluxe_rates"]) ? "RS. " . number_format($per_person_ratemeta["super_deluxe_rates"] +  $per_person_ratemeta["super_deluxe_rates"] * $agent_price_percentage/100) . "/- Per Person" : "";
																$ad_l_pp = isset( $per_person_ratemeta["luxury_rates"] ) && !empty($per_person_ratemeta["luxury_rates"]) ? "RS. " . number_format($per_person_ratemeta["luxury_rates"] +  $per_person_ratemeta["luxury_rates"] * $agent_price_percentage/100 ) . "/- Per Person" : "";
																
																//child rates
																$ad_child_s_pp = isset( $per_person_ratemeta["child_standard_rates"] ) && !empty($per_person_ratemeta["child_standard_rates"]) ? "RS. " . number_format($per_person_ratemeta["child_standard_rates"] +  $per_person_ratemeta["child_standard_rates"] * $agent_price_percentage/100 ) . "/- Per Child" : "";
																$ad_child_d_pp = isset( $per_person_ratemeta["child_deluxe_rates"] ) && !empty($per_person_ratemeta["child_deluxe_rates"]) ? "RS. " . number_format($per_person_ratemeta["child_deluxe_rates"] +  $per_person_ratemeta["child_deluxe_rates"] * $agent_price_percentage/100) . "/- Per Child" : "";
																$ad_child_sd_pp = isset( $per_person_ratemeta["child_super_deluxe_rates"] ) && !empty($per_person_ratemeta["child_super_deluxe_rates"]) ? "RS. " . number_format($per_person_ratemeta["child_super_deluxe_rates"] +  $per_person_ratemeta["child_super_deluxe_rates"] * $agent_price_percentage/100 ) . "/- Per Child" : "";
																$ad_child_l_pp = isset( $per_person_ratemeta["child_luxury_rates"] ) && !empty($per_person_ratemeta["child_luxury_rates"]) ? "RS. " . number_format($per_person_ratemeta["child_luxury_rates"] +  $per_person_ratemeta["child_luxury_rates"] * $agent_price_percentage/100 ) . "/- Per Child" : "";			
																
																//get rates
																$ad_s_price = !empty( $price->standard_rates) ? number_format($price->standard_rates + $price->standard_rates * $agent_price_percentage/100 ) . "/- {$inc_gst}  {$ad_s_pp}  {$ad_child_s_pp}" : "<strong class='red'>On Request</strong>";
																
																$ad_d_price = !empty( $price->deluxe_rates) ? number_format($price->deluxe_rates + $price->deluxe_rates * $agent_price_percentage/100) . "/- {$inc_gst}  {$ad_d_pp}  {$ad_child_d_pp}" : "<strong class='red'>On Request</strong>";
																
																$ad_sd_price = !empty( $price->super_deluxe_rates) ? number_format($price->super_deluxe_rates + $price->super_deluxe_rates * $agent_price_percentage/100) . "/- {$inc_gst}  {$ad_sd_pp}  {$ad_child_sd_pp}"  : "<strong class='red'>On Request</strong>";
																
																$ad_l_price = !empty( $price->luxury_rates) ? number_format($price->luxury_rates + $price->luxury_rates * $agent_price_percentage/100) . "/- {$inc_gst} {$ad_l_pp}  {$ad_child_l_pp}"  : "<strong class='red'>On Request</strong>";
																
																$agent_sp = "><strong class='aprice'> AP( " . $ad_s_price . "</strong>)";
																$agent_dp = "<strong class='aprice'>  AP( " . $ad_d_price . "</strong>)";
																$agent_sdp = "<strong class='aprice'> AP( " . $ad_sd_price . "</strong>)";
																$agent_lp = "<strong class='aprice'>  AP( " . $ad_l_price . "</strong>)";
															}
															
															
															$s_pp = isset( $per_person_ratemeta["standard_rates"] ) && !empty($per_person_ratemeta["standard_rates"] ) ? "RS. " . number_format($per_person_ratemeta["standard_rates"]) . "/- Per Person" : "";
															$d_pp = isset( $per_person_ratemeta["deluxe_rates"] ) && !empty($per_person_ratemeta["deluxe_rates"]) ? "RS. " . number_format($per_person_ratemeta["deluxe_rates"]) . "/- Per Person" : "";
															$sd_pp = isset( $per_person_ratemeta["super_deluxe_rates"] ) && !empty($per_person_ratemeta["super_deluxe_rates"]) ? "RS. " . number_format($per_person_ratemeta["super_deluxe_rates"]) . "/- Per Person" : "";
															$l_pp = isset( $per_person_ratemeta["luxury_rates"] ) && !empty($per_person_ratemeta["luxury_rates"]) ? "RS. " . number_format($per_person_ratemeta["luxury_rates"]) . "/- Per Person" : "";
															
															//child rates
															$child_s_pp = isset( $per_person_ratemeta["child_standard_rates"] ) && !empty($per_person_ratemeta["child_standard_rates"]) ? "RS. " . $per_person_ratemeta["child_standard_rates"] . "/- Per Child" : "";
															$child_d_pp = isset( $per_person_ratemeta["child_deluxe_rates"] ) && !empty($per_person_ratemeta["child_deluxe_rates"]) ? "RS. " . $per_person_ratemeta["child_deluxe_rates"] . "/- Per Child" : "";
															$child_sd_pp = isset( $per_person_ratemeta["child_super_deluxe_rates"] ) && !empty($per_person_ratemeta["child_super_deluxe_rates"]) ? "RS. " . $per_person_ratemeta["child_super_deluxe_rates"] . "/- Per Child" : "";
															$child_l_pp = isset( $per_person_ratemeta["child_luxury_rates"] ) && !empty($per_person_ratemeta["child_luxury_rates"]) ? "RS. " . $per_person_ratemeta["child_luxury_rates"] . "/- Per Child" : "";
															
															$s_price = !empty( $price->standard_rates) ? number_format($price->standard_rates) . "/- {$inc_gst}  {$s_pp}  {$child_s_pp}" : "<strong class='red'>N/A</strong>";
															
															$d_price = !empty( $price->deluxe_rates) ? number_format($price->deluxe_rates) . "/- {$inc_gst} {$d_pp}  {$child_d_pp}" : "<strong class='red'>N/A</strong>";
															
															$sd_price = !empty( $price->super_deluxe_rates) ? number_format($price->super_deluxe_rates) . "/- {$inc_gst} {$sd_pp}  {$child_sd_pp}"  : "<strong class='red'>N/A</strong>";
															
															$l_price = !empty( $price->luxury_rates) ? number_format($price->luxury_rates) . "/- {$inc_gst} {$l_pp}  {$child_l_pp}"  : "<strong class='red'>N/A</strong>";
															
															$count_price = count( $discountPriceData );
															$strike_class = ($price !== end($discountPriceData) && $count_price > 1 ) ? "strikeLine" : "";
															
															echo "<tr class='{$strike_class} {$strike_class_final}'><td>Price</td>
															<td>BP( <strong>" . $s_price . "</strong>) {$agent_sp} </td>";
															echo "<td>BP(<strong>" . $d_price . "</strong>) {$agent_dp} </td>";
															echo "<td>BP(<strong>" . $sd_price . "</strong>) {$agent_sdp} </td>";
															echo "<td>BP(<strong>" . $l_price . "</strong>) {$agent_lp} </td></tr>";
														}
													} 
													} 

													$rate_comment = isset( $iti->rate_comment ) && $iti->pending_price == 2 && $iti->discount_rate_request == 0 ? $iti->rate_comment : "";
													echo "<tr><td colspan=5><p class='red margin_zero'><strong>Note: </strong>{$rate_comment} </td></tr>";
													echo "<tr><td colspan=5><p class='red margin_zero'><strong>Final Package Cost: </strong>{$f_cost} </td></tr>";
												} ?>
                                        </tbody>
                                    </table>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                        <!--END PRINTABLE-->



                        <div class="portlet box blue margin-top-40">
                            <div class="portlet-title">
                                <h3 class="custom_title">Notes:</h3>
                            </div>
                            <div class="portlet-body">
                                <ul>
                                    <?php $hotel_note_meta = unserialize($iti->hotel_note_meta); 
											$count_hotel_meta = count( $hotel_note_meta );
											
											if( $count_hotel_meta > 0 ){
												for ( $i = 0; $i < $count_hotel_meta; $i++ ) {
													echo "<li>" . $hotel_note_meta[$i]["hotel_note"] . "</li>";
												}	
											} ?>
                                </ul>
                            </div>
                        </div>


                        <div class="portlet box blue margin-top-40">
                            <div class="portlet-title">
                                <h3 class="custom_title">Bank Details: Cash/Cheque at Bank or Net Transfer</h3>
                            </div>
                            <div class="portlet-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead class="thead-default">
                                            <tr class="thead-inverse">
                                                <th> Bank Name</th>
                                                <th> Payee Name</th>
                                                <th> Account Type</th>
                                                <th> Account Number</th>
                                                <th> Branch Address</th>
                                                <th> IFSC Code</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $banks = get_all_banks(); 
										if( $banks ){
											foreach( $banks as $bank ){ 
												echo "<tr>";
													echo "<td>" . $bank->bank_name . "</td>";
													echo "<td>" . $bank->payee_name . "</td>";
													echo "<td>" . $bank->account_type . "</td>";
													echo "<td>" . $bank->account_number . "</td>";
													echo "<td>" . $bank->branch_address . "</td>";
													echo "<td>" . $bank->ifsc_code . "</td>";
												echo "</tr>";
											}
										}
										?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="custom_card">
                            <?php
								$agent_id = $iti->agent_id;
								$user_info = get_user_info($agent_id);
								if($user_info){
									$agent = $user_info[0];
									echo "<strong>Regards</strong><br>";
									echo "<strong> " . $agent->first_name . " " . $agent->last_name . "</strong><br>";
									echo "<strong>Call Us : </strong> " . $agent->mobile . "<br>";
									echo "<strong>Email : </strong> " . $agent->email . "<br>";
									echo "<strong>Timing : </strong> " . $agent->in_time . " To " . $agent->out_time . "<br>";
									echo "<strong>Website : </strong> " . $agent->website;
								}	
								?>
                            <hr>
                            <div class="signature"><?php echo $signature; ?></div>
                        </div>

                        <hr>
                        <div class="clearfix"></div>
                        <!--Comments Section -->

                        <div id="UpdatePanel1">
                            <div class="modal-body">
                                <?php if( $iti->iti_status == 0 && $iti->email_count > 0 && $iti->publish_status == "publish" ){ ?>
                                <div class="contactForm">
                                    <form id="confirmForm">
                                        <h3>Enter Your Comment For Client</h3>
                                        <div class="form-group feedback">
                                            <textarea required placeholder="Please Enter comment here...." rows="4"
                                                cols="20" name="client_comment"
                                                class="form-control client_textarea" /></textarea>
                                        </div>
                                        <input type="hidden" name="iti_id" value="<?php echo $iti->iti_id; ?>">
                                        <input type="hidden" name="temp_key" value="<?php echo $iti->temp_key; ?>">
                                        <input type="hidden" name="sec_key" id="sec_key"
                                            value="<?php echo $sec_key; ?>">
                                        <input type="hidden" name="agent_id" id="agent_id"
                                            value="<?php echo $iti->agent_id; ?>">
                                        <input type="hidden" name="customer_id" id="customer_id"
                                            value="<?php echo $iti->customer_id; ?>">
                                        <div class="form-group col-md-12 row">
                                            <button id="LinkButton1" type="submit"
                                                class="btn green uppercase app_iti">Submit</button>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="response"></div>
                                    </form>
                                </div> <?php } ?>
                                <!--comments section-->
                                <div id="comments">
                                    <?php if( !empty( $comments ) ){ ?>
                                    <div class="old-comments">
                                        <?php foreach( $comments as $comment ){ ?>
                                        <div class="well well-sm">
                                            <?php $comment_by = empty( $comment->agent_id ) || $comment->agent_id == 0  ? "<span class='cc_cmt'>Comment by Client:</span>" : "<span class='r_cmt'>Comment by you:</span>"; ?>
                                            <strong><?php echo $comment_by; ?></strong>
                                            <p><?php echo $comment->comment_content; ?></p>
                                            <p>Date: <?php echo $comment->created; ?></p>
                                        </div>
                                        <?php } ?>
                                    </div>
                                    <?php } ?>
                                </div>
                                <!--End comments section-->
                            </div>
                        </div>

                    </div>

                </div>
            </div>
            <!-- END CONTENT BODY -->
            <!-- Booking Payment Script -->
            <script type="text/javascript">
            jQuery(document).ready(function($) {

                //Confirm voucher click
                $(document).on("click", ".cnfrim_voucher", function(e) {
                    e.preventDefault();
                    $("#confirmVoucherModal").show();
                });

                $(document).on("click", ".close", function(e) {
                    $("#confirmVoucherModal").hide();
                });

                //update status voucher
                $("#frm_confirm_voucher").validate({
                    submitHandler: function() {
                        var formData = $("#frm_confirm_voucher").serializeArray();
                        $.ajax({
                            type: "POST",
                            url: "<?php echo base_url('itineraries/ajax_confirm_voucher_status'); ?>",
                            dataType: 'json',
                            data: formData,
                            beforeSend: function() {
                                $(".cnf_res").html("updating.....");
                                console.log("sending...");
                            },
                            success: function(res) {
                                $(".cnf_res").html("");
                                alert(res.msg);
                                location.reload();
                            },
                            error: function(e) {
                                $(".cnf_res").html("");
                                alert("Error: Please reload the page and try again.");
                                console.log(e);
                                //response.html('<div class="alert alert-danger"><strong>Error!</strong>Please Try again later! </div>');
                            }
                        });
                    }
                });

                /*
                //checkbox change
                $("#generate_invoice_frm").validate({
                	submitHandler: function(form) {
                		var ajaxReq;
                		var resp = $(".response");
                		var fullpage_loader = $(".fullpage_loader");
                		var formData = $("#generate_invoice_frm").serializeArray();				
                		if (ajaxReq) {
                			ajaxReq.abort();
                		}
                		ajaxReq = $.ajax({				
                			type: "POST",
                			url: "<?php// echo base_url('payments/ajax_generate_bank_receipt'); ?>",
                			dataType: 'json',
                			data: formData,
                			beforeSend: function(){
                				fullpage_loader.show();
                				resp.html("<div class='alert alert-info'><strong>Please wait</strong> sending mail.....</div>");
                			},
                			success: function(res) {
                				fullpage_loader.hide();
                				if (res.status == true){
                					resp.html('<div class="alert alert-success"><strong>Success! </strong>'+res.msg+'</div>');
                					//console.log(res.msg);
                					location.reload();
                				}else{
                					resp.html('<div class="alert alert-danger"><strong>Error! </strong>'+res.msg+'</div>');
                					console.log("error");
                				}
                			},
                			error: function(e){
                				fullpage_loader.hide();
                				//console.log(e);
                				resp.html('<div class="alert alert-danger"><strong>Error!</strong> Please Try again later! </div>');
                			}
                		});
                	}	
                }); */
            });
            </script>
            <?php }else{
	redirect("itineraries");
} ?>