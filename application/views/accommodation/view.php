<!--link href="<?php echo base_url();?>site/assets/css/lightbox.min.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url();?>site/assets/js/lightbox-plus-jquery.min.js" type="text/javascript"></script-->
<style>.showonPchange, .new_pricesend{display: none;}</style>
<div class="page-container itinerary-view">
	<div class="page-content-wrapper">
		<div class="page-content">
		<!-- BEGIN SAMPLE TABLE PORTLET-->
		<?php $message = $this->session->flashdata('success'); 
		if($message){ echo '<span class="help-block help-block-success">'.$message.'</span>';}
		?>
			<?php if( !empty($itinerary[0] ) ){
				$iti = $itinerary[0];
				$doc_path =  base_url() .'site/assets/client_docs/';
				$is_amendment = $amendment_note = "";
				//show amendment note if revised itinerary
				if( $iti->is_amendment == 2 ){ 
					$is_amendment = "<h3 class='text-center red'>REVISED ITINERARY</h3>";
					$amendment_cmt = $this->global_model->getdata( "iti_amendment_temp", array( "iti_id" => $iti->iti_id ) );
					$amendment_note = !empty( $amendment_cmt ) ? "<p class='red'>Amendment: {$amendment_cmt[0]->review_comment}</p>" : "";
				} 
				
				//print_r( $iti );
				//get terms	
				$terms = get_hotel_terms_condition();
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
				$cust = $get_customer_info[0];
				$customer_name 		= !empty($get_customer_info) ? $cust->customer_name : "";
				$customer_contact 	= !empty($get_customer_info) ? $cust->customer_contact : "";
				$customer_email 	= !empty($get_customer_info) ? $cust->customer_email : "";
				
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
							<strong>Lead Id: </strong><span class=""> <?php echo $iti->customer_id; ?></span> &nbsp; &nbsp;
							<?php if( is_admin_or_manager() ){ ?>
								<strong>Lead Type: </strong><span class=""><?php echo $cus_type; ?>&nbsp; &nbsp;
								</span> <?php echo $ref_name . $ref_contact; ?>
							<?php } ?>
							<?php echo !empty($country_name) ? " From: <span class=''>" . $country_name . " ( $state_name ) </span>" : ""; ?>
							Q. Type: <strong class=""> <?php echo check_iti_type( $iti->iti_id ) . ' ( ' . $iti->iti_package_type . ')'; ?></strong>
						</div>
						<a class="btn btn-success pull-right" href="<?php echo site_url("itineraries"); ?>" title="Back">Back</a>
						<a class="btn btn-info pull-right" style='margin: 5px;' onclick="Print_iti();" href="javscript:void(0)" title="Back">Print</a>
					</div>
				</div>
				
					<!--if final_amount exits-->
					<?php if( isset( $paymentDetails[0] ) && !empty( $paymentDetails[0] ) && $iti->iti_status == 9 ){
						$pay_detail = $paymentDetails[0];
						//$is_gst_final = $pay_detail->is_gst == 1 ? "GST Inc." : "GST Extra";						
						$is_gst_final = "";						
						echo $is_amendment . $amendment_note;
						echo !empty($pay_detail->iti_package_type) ? "<h4 class='text-center red uppercase'>{$pay_detail->iti_package_type}</h4>" : "";
						if( $pay_detail->iti_booking_status == 0 ){
							echo '<h1 class="text-center green uppercase">Booked Itinerary</h1>';
						}else if( $pay_detail->iti_booking_status == 1 ){
							echo '<h1 class="text-center red uppercase">Itinerary On Hold</h1>';
						}else{
							echo '<h1 class="text-center red uppercase">Itinerary Rejected By Manager</h1>';
							echo "<p class='text-center'><strong class='red'> Reason: </strong> {$pay_detail->approved_note}</p>";
						} ?>
						
						<!--PRINT BUTTON-->
						<!--a href="javascript: void(0)" class="btn btn-success" onclick="window.print()">Print</a-->
						
						<div class="mt-element-step">
							<div class="row step-background-thin ">
								<div class="col-md-4 bg-grey-steel mt-step-col error ">
									<div class="mt-step-number">1</div>
									<div class="mt-step-title uppercase font-grey-cascade"><strong>INR <?php echo $iti->final_amount; ?>/- </strong></div>
									
									<div class="mt-step-content font-grey-cascade">Package Final Cost: <span style="color: #fff;">(<?php echo $is_gst_final;  ?>)</span></div>
								</div>
								<div class="col-md-4 bg-grey-steel mt-step-col active">
									<div class="mt-step-number">2</div>
									<div class="mt-step-title uppercase font-grey-cascade"><strong><?php echo $iti->approved_package_category; ?></strong></div>
									<div class="mt-step-content font-grey-cascade">Package Category</div>
								</div>
								<div class="col-md-4 bg-grey-steel mt-step-col done">
									<?php $t_date = get_travel_date($iti->iti_id); ?>
									<div class="mt-step-number">3</div>
									<div class="mt-step-title uppercase font-grey-cascade"><?php echo !empty($t_date) ? $t_date : "--/--/----"; ?></strong></div>
									<div class="mt-step-content font-grey-cascade">Travel Date</div>
								</div>
							</div>
						</div>
						<div class="clearfix"></div>
						<div class="mt-element-step">
							<div class="row step-background-thin ">
								<div class="col-md-4 bg-grey-steel mt-step-col done ">
									<div class="mt-step-number">1</div>
									<div class="mt-step-title uppercase font-grey-cascade"><strong>INR <?php echo $paymentDetails[0]->advance_recieved; ?>/- </strong></div>
									<div class="mt-step-content font-grey-cascade">Advance Recieved </div>
								</div>
								<div class="col-md-4 bg-grey-steel mt-step-col error">
									<div class="mt-step-number">2</div>
									<div class="mt-step-title uppercase font-grey-cascade"><strong><?php echo $paymentDetails[0]->total_balance_amount; ?>/-</strong></div>
									<div class="mt-step-content font-grey-cascade">Balance Pending</div>
								</div>
								<div class="col-md-4 bg-grey-steel mt-step-col active">
									<?php $booking_d = $paymentDetails[0]->booking_date; ?>
									<div class="mt-step-number">3</div>
									<div class="mt-step-title uppercase font-grey-cascade"><?php echo !empty($booking_d) ? display_month_name($booking_d ) : "--/--/----"; ?></strong></div>
									<div class="mt-step-content font-grey-cascade">Booking Date</div>
								</div>
							</div>
						</div>
						
						<div class="clearfix"></div>
						<!--show payment screenshot details-->
							<hr>
							<div id="update_iti_hold_status">
								<!-- client_aadhar_card payment_screenshot -->
								<?php
									
									$aadhar_card_img = !empty( $pay_detail->client_aadhar_card ) ? $pay_detail->client_aadhar_card : "";
									$payment_screenshot = !empty( $pay_detail->payment_screenshot ) ? $pay_detail->payment_screenshot : "";
								?>
								<div class="col-md-4">
									<h4 class="uppercase">Aadhar Card Screenshot</h4>
									<?php if($aadhar_card_img){ ?>
										<a target="_blank" href="<?php echo $doc_path . $aadhar_card_img; ?>" class="example-image-link" data-lightbox="example-set"  data-title="Adhar card Screenshot.">
											<img src="<?php echo $doc_path . $aadhar_card_img; ?>" width="150" height="150" class="image-responsive">
										</a>
									<?php }else{
										echo "<strong class='red'>Aadhar card Not Updated</strong>";
										//echo '<img src=" ' . $doc_path . 'dummy.jpg" width="150" height="150" class="image-responsive">';
									} ?>
								</div>
								<div class="col-md-4">
									<h4 class="uppercase">Payment Screenshot</h4>
									<?php if($payment_screenshot){ ?>
										<a target="_blank" href="<?php echo $doc_path . $payment_screenshot; ?>" class="example-image-link" data-lightbox="example-set"  data-title="Client Payment Screenshot.">
											<img src="<?php echo $doc_path . $payment_screenshot; ?>" width="150" height="150" class="image-responsive">
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
								<div class="col-md-12 other_docs">
									<?php if (isset( $iti_clients_docs ) && !empty( $iti_clients_docs ) ){
										echo '<hr><h4 class="uppercase">Other Documents</h4>'; ?>
										<div class="table-responsive">
											<table class="table table-striped table-hover">
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
																<a href="<?php echo $doc_path . $doc->file_url; ?>" target="_blank" class="btn btn-success" style="position:relative;">
																<i class="fa fa-eye"></i> View</a>
																
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
								<div class="clearfix"></div>
								<hr>
								<!--approved /reject onhold itierary by manager -->
								<?php if( is_admin_or_manager() && $pay_detail->iti_booking_status == 1 ){
									$aadhar_card_req		= empty( $pay_detail->client_aadhar_card ) ? "required='required'" : "";
									$payment_screenshot_req = empty( $pay_detail->payment_screenshot ) ? "required='required'" : "";	?>
									
									<div class="row" id="update_rates_section">
										<form id="frmappOnholditi">
											<div class="frm_section">
												<div class = "spinner_load"  style = "display: none;">
													<i class="fa fa-refresh fa-spin fa-3x fa-fw" ></i>
													<span class="sr-only">Loading...</span>
												</div>
												<div class='form-group col-md-12' >
													<p class="text-center uppercase"><strong style="font-size: 22px;">Please View And Update Itinerary: </strong></p>
												</div>
												<div class='form-group col-md-12 iti_info' >
													<p class="text-center">
													<strong> Final Cost: </strong><?php echo iti_final_cost($iti->iti_id); ?>
													<strong> Advance Recived: </strong><?php echo $pay_detail->advance_recieved; ?> <strong> Balance: </strong> <?php echo $pay_detail->total_balance_amount; ?><strong> Booking Date: </strong> <?php echo !empty( $pay_detail->booking_date ) ? display_month_name( $pay_detail->booking_date ) : ""; ?><strong> Package Category: </strong><?php echo $iti->approved_package_category; ?>
													</p>
												</div>
												<!--upload aadhar card section-->
												<div class="form-group col-md-3 remove_required">
													<div class="form-group2">
														<label class=" "><strong>Client Aadhar Card:</strong></label>
														<input class="form-control" <?php echo $aadhar_card_req; ?> id="client_aadhar_card" type="file" name="client_aadhar_card">
													</div>	 
													<img id="client_aadhar_card_priview" style="display: none;" width="100" height="100" />
												</div><!--end upload aadhar card section-->
												<!--upload aadhar Payment card section-->
												<div class="form-group col-md-3 remove_required">
													<div class="form-group2">
														<label class=" "><strong>Payment Screenshot:</strong></label>
														<input class="form-control" <?php echo $payment_screenshot_req; ?> id="payment_screenshot" type="file" name="payment_screenshot">
													</div>	 
													<img id="payment_screenshot_priview" style="display: none;" width="100" height="100" />
												</div>
												<!--end perperson rate meta -->
												<div class='form-group col-md-3' >
													<label><strong>Comments*</strong><span class="red" style="font-size: 12px;"> Note: This comment is also visible for agent.</span></label>
													<textarea required name="approved_note" placeholder="APPROVED NOTE" class='form-control'></textarea>
												</div>
												
												<div class="form-group col-md-3">
													<label class=""><strong>Package Type*:</strong></label>
													<select required name="package_type_iti" class="form-control">
														<option value="">Choose Package Type</option>
														<option <?php echo isset($pay_detail->iti_package_type) && $pay_detail->iti_package_type == "Honeymoon Package" ? 'selected' : '' ?> value="Honeymoon Package">Honeymoon Package</option>
														<option <?php echo isset($pay_detail->iti_package_type) && $pay_detail->iti_package_type == "Fixed Departure" ? 'selected' : '' ?> value="Fixed Departure">Fixed Departure</option>
														<option <?php echo isset($pay_detail->iti_package_type) && $pay_detail->iti_package_type == "Group Package" ? 'selected' : '' ?> value="Group Package">Group Package</option>
														<option <?php echo isset($pay_detail->iti_package_type) && $pay_detail->iti_package_type == "Other" ? 'selected' : '' ?> value="Other">Other</option>
													</select>
												</div>
												
												<div class="clearfix"></div>
												<div class="col-md-12 other_docs">
													<a href="javascript:;" id="add_other_docs_btn" class="btn btn-success mt-repeater-add addrep">
													<i class="fa fa-plus"></i> Add Other Docs</a><span class="red" style="font-size: 12px;"> Please upload only ( jpg|jpeg|png|pdf ) files and not more than 2MB.</span>
													<div class="other_docs_sec" style="display:none;">
														<div class="col-md-4">
															<div class="form-group2">
																<label class=" "><strong>Other Documents:</strong></label>
																<input class="form-control" required type="file" name="iti_clients_docs[]">
															</div>	
														</div>
														<div class="col-md-4">													
															<label class=" "><strong>Document Title:</strong></label>
															<input class="form-control" required type="text" name="comment[]">
														</div>
														<div class="col-md-4">		
															<div class="mt-repeater-input margin-top-20" >
																<a href="javascript:;" data-repeater-delete class="btn btn-danger del_upload" style="position:relative;">
																<i class="fa fa-close"></i> Delete</a>
															</div>														
														</div>
														<div class="clearfix"></div>
													</div>	
													<?php if (isset( $iti_clients_docs ) && !empty( $iti_clients_docs ) ){
														echo '<hr><h4 class="uppercase">Other Documents</h4>'; ?>
														<div class="table-responsive">
															<table class="table table-striped table-hover">
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
																		echo "<tr id='doc_row_{$doc->id}'>";
																			echo "<td>" . $docindex . "</td>";
																			echo "<td>" . $doc->file_url . "</td>";
																			echo "<td>" . $doc->comment . "</td>";
																			echo "<td>"; ?>
																				<a href="<?php echo $doc_path . $doc->file_url; ?>" target="_blank" class="btn btn-success" style="position:relative;">
																				<i class="fa fa-eye"></i></a>
																				<a href="javascript: void(0);" class="btn btn-danger del_client_docs" data-id ="<?php echo $doc->id; ?>" style="position:relative;">
																				<i class="fa fa-trash-o"></i></a>
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
												<div class="clearfix"></div>
											</div>
											<div class='form-group col-md-3'>
												<div class="button_sec" style="margin-top: 30px;">
													<button class="btn green button-submit" type="submit" value="approved">APPROVE</button>
													<strong class="red"> OR </strong>
													<button type="button" class="btn red reject_iti_btn" data-toggle="modal" data-target="#reject_iti_ModalS"> Reject</button>
												</div>	
											</div>
											
											<div class="clearfix"></div>
											<div class="response_div"></div>
											<input type="hidden" value="<?php echo $iti->iti_id; ?>" name="iti_id">
											<input type="hidden" value="approved" name="action">
										</form>	
										<!--Reject Itinerary Modal -->
										<div class="modal fade" id="reject_iti_ModalS" role="dialog">
											<div class="modal-dialog modal-lg2">
											  <div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal">&times;</button>
													<h4 class="modal-title">Reject Itinerary</h4>
												</div>
												<div class="modal-body">
													<form id="frm_rej_iti_manager">
														<div class="form-group">
															<label class="radio-inline">
																<input type="radio" required name="reject_due_to" value="2" >Due to Payment
															</label>
															<label class="radio-inline">
																<input type="radio" required name="reject_due_to" value="3">Due to Itinerary
															</label>
														</div>
														<div class="form-group">
														<div class="checkbox">
															<label for="email">Reject Comment*</label><br>
															<textarea required="required" name="reject_note" placeholder="Write a comment for agent why itinerary rejected..." class="form-control" rows="3"></textarea>
														</div>
														</div>
														<button type="submit" id="reqDis_rej_app" name="action_reject" class="btn btn-success">Submit To Reject</button>
														<input type="hidden" name="iti_id" value="<?php echo $iti->iti_id; ?>" >
														<div id="rej_res2"></div>
													</form>	
												</div>
												<div class="modal-footer">
												  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
												</div>
											  </div>
											</div>
										</div>
									</div> <!-- row -->
								<?php }else if( $pay_detail->iti_booking_status == 2 && is_salesteam() ){
									//iti_booking_status = 2 = iti rejected by sale manager due to payment
									$aadhar_card_req		= empty( $pay_detail->client_aadhar_card ) ? "required='required'" : "";
									$payment_screenshot_req = empty( $pay_detail->payment_screenshot ) ? "required='required'" : "";
									$p_booked_category = $iti->approved_package_category;
									$get_iti_package_category = get_iti_package_category();
									$advance_recieved = $pay_detail->advance_recieved ? $pay_detail->advance_recieved : 0;
									$second_payment_bal = $pay_detail->second_payment_bal ? $pay_detail->second_payment_bal : 0;
									$third_payment_bal = $pay_detail->third_payment_bal ? $pay_detail->third_payment_bal : 0;
									$final_payment_bal = $pay_detail->final_payment_bal ? $pay_detail->final_payment_bal : 0;
									
									$total_balance_amount = $pay_detail->total_balance_amount ? $pay_detail->total_balance_amount : 0;
									
									$second_payment_date = $pay_detail->second_payment_date;
									$third_payment_date = $pay_detail->third_payment_date;
									$final_payment_date = $pay_detail->final_payment_date;
									?>
									<form id="frm_update_booking_status_agent">
										<input type="hidden" id="inp_advance_recieved" value="<?php echo $advance_recieved; ?>">
										<div class="frm_section">
											<div class = "spinner_load"  style = "display: none;">
												<i class="fa fa-refresh fa-spin fa-3x fa-fw" ></i>
												<span class="sr-only">Loading...</span>
											</div>
											<div class='form-group col-md-12' >
												<h4 class="text-center uppercase"><strong>Please View And Update Itinerary: </strong></h4>
											</div>
											
											<?php // if( $pay_detail->iti_booking_status == 2 ){ ?>
												<div class='form-group col-md-12 iti_info' >
													<p class="text-center"><strong> Advance Recived: </strong><?php echo $pay_detail->advance_recieved; ?> <strong> Balance: </strong> <?php echo $pay_detail->total_balance_amount; ?><strong> Booking Date: </strong> <?php echo !empty( $pay_detail->booking_date ) ? display_month_name( $pay_detail->booking_date ) : ""; ?><strong> Package Category: </strong><?php echo $iti->approved_package_category; ?>
													</p>
												</div>
												<div class="booking_section" style="display:block;">
													<div class="form-group col-md-3">
														<label for="usr">Package Category<span style="color:red;"> *</span>:</label>
														<?php echo package_category_select_html( $iti->iti_id, $iti->approved_package_category ); ?>
														<?php /*
														<select required class="form-control" name="approved_package_category">
															<option value="">Select package category</option>
															<?php if($get_iti_package_category){
																foreach( $get_iti_package_category as $book_cat ){
																	$selected = $p_booked_category == $book_cat->name ? "selected" : "";
																	echo "<option {$selected} value='{$book_cat->name}'>{$book_cat->name}</option>";
																}
															} ?>
														</select> */ ?>
													</div>
													
													<div class="form-group col-md-3">
														<label class=""><strong>Package Type*:</strong></label>
														<select required name="package_type_iti" class="form-control">
															<option value="">Choose Package Type</option>
															<option value="Honeymoon Package">Honeymoon Package</option>
															<option value="Fixed Departure">Fixed Departure</option>
															<option value="Group Package">Group Package</option>
															<option value="Other">Other</option>
														</select>
													</div>
													
													<div class="form-group col-md-3">
														<label class=""><strong>Booking Date*:</strong></label>
														<input required readonly="readonly" data-date-format="yyyy-mm-dd" class="input-group form-control" id="booking_date" type="text" value="<?php echo isset( $pay_detail->booking_date ) ? $pay_detail->booking_date : ""; ?>" name="booking_date"  />
													</div>
													
													
													<?php 
														$get_tax = get_tax();
														$tax = !empty( $get_tax ) ? trim($get_tax) : 0;	
														
														//check if gst exists
														$is_gst = isset( $pay_detail->is_gst ) && $pay_detail->is_gst == 1 ? true : false;
														$total_pack_cost = $pay_detail->total_package_cost;
														
														if( $is_gst ){
															$get_sub_tax = ( $get_tax / 100 ) + 1;
															$f_amount = round( $total_pack_cost / $get_sub_tax );
														}else{
															$f_amount = $total_pack_cost;
														}
													?>
													<?php /*
													<div class="form-group col-md-2">
														<label for="usr">Package Cost<span style="color:red;"> *</span>:</label>
														<input type="number" required class="form-control" data-tax="<?php echo $tax; ?>" id="fnl_amount" placeholder="Total Package Cost" value="<?php echo $f_amount; ?>" />
													</div>
													<?php 
													//check if gst included
													
													?>
													<div class="form-group col-md-2">
														<label for="usr">Add GST <span style="color:red;"> (<?php echo $tax; ?>% Extra)</span>:</label>
														<input <?php echo $is_gst ? "checked" : ""; ?> title="Check/Uncheck this button to add/substract 5% extra GST with package cost" type="checkbox" name="is_gst" id ="tx" class="form-control" />
													</div>
													*/ ?> 
													<div class="form-group col-md-3">
														<label for="usr">Total Package Cost<span style="color:red;"> *</span>:</label>
														<input type="number" readonly required class="form-control" id="fnl_amount_tax" title="Total package cost after inc. tax" placeholder="Total package cost after inc. tax" value="<?php echo $total_pack_cost; ?>" name="final_amount" >
													</div>
													
													<div class="clearfix"></div>
													<!--Payment Details -->
													<div id="due_payment_section">
														<div class="form-group col-md-6">
															<label class=""><strong>Second Installment Amount:</strong></label>
															<input type="text" required id="next_pay_balance" data-date-format="yyyy-mm-dd" name="next_payment_bal" placeholder="Second Payment Balance" class="form-control" value="<?php echo $second_payment_bal; ?>">
														</div>
														
														<div class="form-group col-md-6">
															<label class=""><strong>Second Installment Due Date:</strong></label>
															<input  data-date-format="yyyy-mm-dd" class="input-group form-control date_picker" id="next_payment_date" readonly type="text" value="<?php echo $second_payment_date; ?>" name="next_payment_date"  />
														</div>
														
														<div class="form-group col-md-6">
															<label class=""><strong>3rd Installment Amount:</strong><span id="pendingBal"></span></label>
															<input type="number" readonly id="third_payment_bal" name="third_payment_bal" placeholder="Third Payment Amount" class="form-control" value="<?php echo $third_payment_bal; ?>">
														</div>
														
														<div class="form-group col-md-6">
															<label class=""><strong>3rd Installment Due Date:</strong></label>
															<input readonly="readonly" data-date-format="yyyy-mm-dd" class="input-group form-control date_picker_validation date_picker" id="third_payment_date" type="text" value="<?php echo $third_payment_date; ?>" name="third_payment_date"  />
														</div>
														
														<div class="form-group col-md-6">
															<label class=""><strong>Final Installment:</strong></label>
															<input type="number" readonly id="final_payment_bal" name="final_payment_bal" placeholder="Final Installment Amount" class="form-control" value="<?php echo $final_payment_bal; ?>">
														</div>
														
														<div class="form-group col-md-6">
															<label class=""><strong>Final Installment Due Date:</strong></label>
															<input readonly="readonly" data-date-format="yyyy-mm-dd" class="input-group form-control date_picker_validation date_picker" id="final_payment_date" type="text" value="<?php echo $final_payment_date; ?>" name="final_payment_date"  />
														</div>
													</div>	
													
													<div class="form-group col-md-6">
														<label class=""><strong>Total Balance Remaining:</strong></label>
														<input type="text" required readonly id="balance_pay" name="total_balance" placeholder="" class="form-control" value="<?php echo $total_balance_amount; ?>">
													</div>
													<div class="form-group col-md-6">
														<label for="usr">Please Enter Approval Note:<span style="color:red;"> *</span>:</label>
														<textarea required class="form-control" placeholder="Please Enter Approval Note" name="iti_note_booked" ></textarea>
													</div>
													<div class="clearfix"></div>
													<!--upload aadhar card section-->
													<div class="form-group col-md-6">
														<div class="form-group2">
															<label class=" "><strong>Client Aadhar Card:</strong></label>
															<input <?php echo $aadhar_card_req; ?> class="form-control" id="client_aadhar_card" type="file" name="client_aadhar_card">
														</div>	 
														<img id="client_aadhar_card_priview" src="<?php echo $doc_path . $pay_detail->client_aadhar_card; ?>" style="display: block;" width="100" height="100" />
													</div><!--end upload aadhar card section-->
													<!--upload aadhar Payment card section-->
													<div class="form-group col-md-6">
														<div class="form-group2">
															<label class=" "><strong>Payment Screenshot*:</strong></label>
															<input <?php echo $payment_screenshot_req; ?> class="form-control" id="payment_screenshot" type="file" name="payment_screenshot">
														</div>	 
														<img id="payment_screenshot_priview" src="<?php echo $doc_path . $pay_detail->payment_screenshot; ?>" style="display: block;" width="100" height="100" />
													</div>
												</div><!--booking section-->
												<div class="clearfix"></div>
											<?php /* }else{ ?>
												<!-- iti_booking_status = 3 rejected due to invalid itinerary -->
												<h3 class='text-center uppercase red'> Itinerary Rejected due to mistake in itineary</h3>
												<p class="text-center">to change itinerary 
												<a title='Edit Itinerary'  target="_blank" href="<?php echo site_url("itineraries/edit/{$iti->iti_id}/{$iti->temp_key}"); ?> " class='btn btn-success' ><i class='fa fa-pencil' aria-hidden='true'></i> Edit Itinerary</a>
												</p>
												<div class="form-group col-md-6">
													<label for="usr">Please Enter Approval Note:<span style="color:red;"> *</span>:</label>
													<textarea required class="form-control" placeholder="Please Enter Approval Note" name="iti_note_booked" ></textarea>
												</div>
											<?php */
											 // } ?>	
										</div>
										<div class="clearfix"></div>
										<hr>
										<div class='form-group col-md-3'>
											<div class="button_sec" style="margin-top: 30px;">
												<button name="action" class="btn green button-submit" type="submit" >UPDATE PAYMENT DETAILS</button>
											</div>	
										</div>
										
										<div class="clearfix"></div>
										<div class="response"></div>
										<input type="hidden" value="<?php echo $pay_detail->iti_booking_status; ?>" name="reject_type">
										<input type="hidden" value="<?php echo $iti->iti_id; ?>" name="iti_id">
										<input type="hidden" value="<?php echo $iti->customer_id; ?>" name="customer_id">
										<input type="hidden" value="<?php echo $iti->temp_key; ?>" name="temp_key">
									</form>
								<?php } ?>	
							</div>
						<div class="clearfix"></div>
						<hr>
					<?php } ?>
				
				<!-- Declined Reason -->
				<?php if($iti->iti_status == 7 ){ ?>
					<div class="well well-sm">
						<p class="red">Declined Reason: <strong><?php echo $iti->followup_status; ?></strong></p>
						<p class="red">Declined Comment: <strong><?php echo $iti->decline_comment; ?></strong></p>
					</div>
				<?php } 
				else if($iti->iti_status == 6 ){ ?>
				<!-- Rejected Reason -->
					<div class="well well-sm text-center">
						<h2 class="red">Rejected Itinerary</h2>
						<p class="red">Reason: <strong><?php echo $iti->iti_reject_comment; ?></strong></p>
					</div>
				<?php } ?>
				
				<?php 
				//Insert Rate meta if price is empty
				$get_rate_meta = unserialize( $iti->rates_meta );
				$hotel_meta 	= unserialize($iti->hotel_meta); 
				$check_hotel_cat = array();
				$check_hotel_cat = !empty($hotel_meta) ? array_column($hotel_meta, "hotel_inner_meta" ) : "";
				
				//Get all category
				$all_hotel_cats = [];
				foreach( $check_hotel_cat as $date => $array ) {
					$all_hotel_cats = array_merge($all_hotel_cats, array_column($array, "hotel_category"));
				}
				
				/* echo "<pre>";
					print_r( $all_hotel_cats );
				echo "</pre>"; */
				
				$is_standard	= !empty($all_hotel_cats) && in_array("Standard", $all_hotel_cats) ? TRUE : FALSE;
				$is_deluxe		= !empty($all_hotel_cats) && in_array("Deluxe",  $all_hotel_cats) ? TRUE : FALSE;
				$is_s_deluxe 	= !empty($all_hotel_cats) && in_array("Super Deluxe",  $all_hotel_cats) ? TRUE : FALSE;
				$is_luxury 		= !empty($all_hotel_cats) && in_array("Luxury", $all_hotel_cats ) ? TRUE : FALSE;
				
				//add required if category exists
				$st_req = !empty( $is_standard ) ? "required='required'" : "readonly='readonly'";
				$d_req = !empty( $is_deluxe ) ? "required='required'" : "readonly='readonly'";
				$sd_req = !empty( $is_s_deluxe ) ? "required='required'" : "readonly='readonly'";
				$l_req = !empty( $is_luxury ) ? "required='required'" : "readonly='readonly'";
				
				//print_r( $get_rate_meta );
				//if( empty($get_rate_meta) && is_admin_or_manager() && $iti->pending_price == 1 ){
				if( ( empty($get_rate_meta) || get_iti_booking_status($iti->iti_id)  == 3 ) && ( (  ( ( is_manager() && !is_leads_manager() ) || is_admin() ) && ( $iti->pending_price == 1 || $iti->pending_price == 5 ) ) || ( is_teamleader() && $iti->pending_price == 5 ) ) && !empty( $hotel_meta ) ){					
						$count_hotel = count( $hotel_meta ); 
						//print_r( $hotel_meta );
						?>
						<div class="row" id="update_rates_section">
							<form id="submitRates">
								<div class='form-group col-md-12' >
									<p class="text-center"><strong style="font-size: 22px;">Please Update Rates By Hotel Category: </strong></p>
								</div>
								
								<div class='standard  form-group col-md-2' >
									<label><strong>Deluxe:</strong></label>
									<input <?php echo $st_req; ?> name="rate_meta[standard_rates]" type="number" class='form-control'></input>
								</div>
								<div class='deluxe form-group col-md-2' >
									<label><strong>Super Deluxe:</strong></label>
									<input <?php echo $d_req; ?> name="rate_meta[deluxe_rates]" type="number" class='form-control'></input>
								</div>
								<div class='super_deluxe form-group col-md-2' >
									<label><strong>Luxury:</strong></label>
									<input <?php echo $sd_req; ?>name="rate_meta[super_deluxe_rates]" type="number" class='form-control'></input>
								</div>
								<div class='luxury form-group col-md-2' >
									<label><strong>Super Luxury:</strong></label>
									<input <?php echo $l_req; ?> name="rate_meta[luxury_rates]" type="number" class='form-control'></input>
								</div>
								
								<!--div class='form-group col-md-2' >
									<label><strong>GST Inc.:</strong></label>
									<input type="checkbox" value="1" class='form-control' id="incgst"></input>
								</div-->
								
								<div class='form-group col-md-2' >
									<label><strong>Below Base Price.:</strong></label>
									<input type="checkbox" value="1" title="Check if price is below Base Price" class='form-control' id="below_bp"></input>
									<input name="per_person_ratemeta[below_base_price]" type="hidden" value="" class='form-control below_bp'></input>
								</div>
							
								<input name="per_person_ratemeta[inc_gst]" type="hidden" value="1" class='form-control incgst'></input>
								<div class='form-group col-md-2' >
									<label><strong>Add Per/Person Rate:</strong></label> <!--inc_gst 1 = true -->
									<input type="checkbox" class='form-control' id="per_person_rate" ></input>
								</div>
								<div class="clearfix"></div>
								<!--perperson rate meta -->
								<div class="col-md-12 perperson_section" style="display: none;">
									<div class='standard  form-group col-md-3' >
										<label><strong>Deluxe (Per/Person):</strong></label>
										<input <?php echo $st_req; ?>  name="per_person_ratemeta[standard_rates]" type="number" class='form-control' placeholder="Deluxe Per/Person Cost"></input>
									</div>
									
									<div class='deluxe form-group col-md-3' >
										<label><strong>Super Deluxe (Per/Person):</strong></label>
										<input <?php echo $d_req; ?>  name="per_person_ratemeta[deluxe_rates]" type="number" class='form-control' placeholder="Super Deluxe Per/Person Cost"></input>
									</div>
									<div class='super_deluxe form-group col-md-3' >
										<label><strong>Luxury (Per/Person):</strong></label>
										<input <?php echo $sd_req; ?>  name="per_person_ratemeta[super_deluxe_rates]" type="number" class='form-control' placeholder="Luxury Per/Person Cost"></input>
									</div>
									<div class='luxury form-group col-md-3' >
										<label><strong>Super Luxury (Per/Person):</strong></label>
										<input <?php echo $l_req; ?>  name="per_person_ratemeta[luxury_rates]" type="number" class='form-control' placeholder="Super Deluxe Per/Person Cost"></input>
									</div>
									
									<div class="clearfix"></div>
									<!--child rate-->
									<div class='standard  form-group col-md-3' >
										<label><strong  class="red">Deluxe (Per/child):</strong><span style="font-size:10px; color: red;"> ( Leave empty if not exists)</span></label>
										<input <?php echo $st_req; ?> name="per_person_ratemeta[child_standard_rates]" type="number" class='form-control' placeholder="Deluxe Per/child Cost"></input>
									</div>
									
									<div class='deluxe form-group col-md-3' >
										<label><strong class="red">Super Deluxe (Per/child):</strong><span style="font-size:10px; color: red;"> ( Leave empty if not exists)</span></label>
										<input <?php echo $d_req; ?> name="per_person_ratemeta[child_deluxe_rates]" type="number" class='form-control' placeholder="Super Deluxe Per/child Cost"></input>
									</div>
									<div class='super_deluxe form-group col-md-3' >
										<label><strong  class="red">Luxury (Per/child):</strong><span style="font-size:10px; color: red;"> ( Leave empty if not exists)</span></label>
										<input <?php echo $sd_req; ?> name="per_person_ratemeta[child_super_deluxe_rates]" type="number" class='form-control' placeholder="Luxury Per/child Cost"></input>
									</div>
									<div class='luxury form-group col-md-3' >
										<label><strong  class="red">Super Luxury (Per/child):</strong><span style="font-size:10px; color: red;"> ( Leave empty if not exists)</span></label>
										<input <?php echo $l_req; ?> name="per_person_ratemeta[child_luxury_rates]" type="number" class='form-control' placeholder="Super Deluxe Per/child Cost"></input>
									</div>
								</div>
								<!--end perperson rate meta -->
							
							<div class='luxury form-group col-md-4' >
								<label><strong>Rate Comments*</strong><span class="red" style="font-size: 12px;"> Note: This comment is also visible for client.</span></label>
								<textarea required name="rate_comment" class='form-control'></textarea>
							</div>
								<input type="hidden" value="<?php echo $iti->iti_id; ?>" name="iti_id">
								<input type="hidden" value="<?php echo $iti->temp_key; ?>" name="temp_key">
								<input type="hidden" value="<?php echo $iti->agent_id; ?>" name="agent_id">
							<div class='form-group col-md-8'>
								<div class="button_sec" style="margin-top: 30px;">
									<button name="action" class="btn green button-submit" type="submit" value="agent">Send To Agent</button> <strong class="red"> OR </strong>
									<!--if team leader request to manager else req to supermanager -->
									<?php if( is_teamleader() ){ ?>
										<button name="action" class="btn green button-submit" type="submit" value="manager">Send To Manager</button> <strong class="red"> OR </strong>
									<?php }else{ ?>
										<button name="action" class="btn green button-submit" type="submit" value="supermanager">Send To Admin/Super Manager</button> <strong class="red"> OR </strong>
									<?php } ?>
									<button type="button" class="btn red reject_iti_btn" data-toggle="modal" data-target="#reject_iti_Modal">Reject</button>
								</div>	
							</div>
							<div class="clearfix"></div>
							<div id="response_div"></div>
						</form>	
					</div> <!-- row -->
					
					<!--Reject Itinerary Modal -->
					<div class="modal fade" id="reject_iti_Modal" role="dialog">
						<div class="modal-dialog modal-lg2">
						  <div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title">Reject Itinerary</h4>
							</div>
							<div class="modal-body">
								<form id="frm_rejectItinerary">
									<div class="form-group">
									<div class="checkbox">
										<label for="email">Reject Comment*</label><br>
										<textarea required="required" name="iti_reject_comment" placeholder="Write a comment for agent why itinerary rejected..." class="form-control" rows="3"></textarea>
									</div>
									</div>
									<input type="hidden" name="iti_id" value="<?php echo $iti->iti_id; ?>">
									<input type="hidden" name="agent_id" value="<?php echo $iti->agent_id; ?>">
									<button type="submit" id="rreqDis_btn" class="btn btn-success">Submit To Reject</button>
									<div id="rej_res"></div>
								</form>

							</div>
							<div class="modal-footer">
							  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							</div>
						  </div>
						</div>
					</div>
				<?php }	?>
				
				<!--Price update request to supermanager -->
				<?php if( !empty($get_rate_meta) && ( is_admin() || is_super_manager() ) && $iti->pending_price == 4 ){ ?>
					<div class="row" id="update_rates_section">
						<form id="update_price_supermanager">
							<?php 
							//get per person price
							$per_person_ratemeta 	= unserialize($iti->per_person_ratemeta);
							$s_pp = isset( $per_person_ratemeta["standard_rates"] ) && !empty($per_person_ratemeta["standard_rates"]) ?$per_person_ratemeta["standard_rates"] : "";
							$d_pp = isset( $per_person_ratemeta["deluxe_rates"] ) && !empty($per_person_ratemeta["deluxe_rates"]) ? $per_person_ratemeta["deluxe_rates"] : "";
							$sd_pp = isset( $per_person_ratemeta["super_deluxe_rates"] ) && !empty($per_person_ratemeta["super_deluxe_rates"]) ? $per_person_ratemeta["super_deluxe_rates"] : "";
							$l_pp = isset( $per_person_ratemeta["luxury_rates"] ) && !empty($per_person_ratemeta["luxury_rates"]) ? $per_person_ratemeta["luxury_rates"] : ""; 
							
							//child rates
							$child_s_pp = isset( $per_person_ratemeta["child_standard_rates"] ) && !empty($per_person_ratemeta["child_standard_rates"]) ?$per_person_ratemeta["child_standard_rates"] : "";
							$child_d_pp = isset( $per_person_ratemeta["child_deluxe_rates"] ) && !empty($per_person_ratemeta["child_deluxe_rates"]) ? $per_person_ratemeta["child_deluxe_rates"] : "";
							$child_sd_pp = isset( $per_person_ratemeta["child_super_deluxe_rates"] ) && !empty($per_person_ratemeta["child_super_deluxe_rates"]) ? $per_person_ratemeta["child_super_deluxe_rates"] : "";
							$child_l_pp = isset( $per_person_ratemeta["child_luxury_rates"] ) && !empty($per_person_ratemeta["child_luxury_rates"]) ? $per_person_ratemeta["child_luxury_rates"] : ""; 
							
							
							//check if per/person rate exists
							$inc_gst = isset( $per_person_ratemeta["inc_gst"] ) && $per_person_ratemeta["inc_gst"] == 1 ? 1 : 0;
							$check_perperson = !empty( $s_pp ) ||  !empty( $d_pp ) ||  !empty( $sd_pp ) ||  !empty( $l_pp ) ? 1 : 0;
							?>
							
							<div class='form-group col-md-12' >
								<p class="text-center"><strong style="font-size: 22px;">Please Update Rates By Hotel Category: </strong></p>
							</div>
							<div class='standard  form-group col-md-2' >
								<label><strong>Deluxe:</strong></label>
								<input <?php echo $st_req; ?> name="rate_meta[standard_rates]" type="number" class='form-control' value="<?php echo isset($get_rate_meta["standard_rates"]) ? $get_rate_meta["standard_rates"] : 0; ?>"></input>
							</div>
							<div class='deluxe form-group col-md-2' >
								<label><strong>Super Deluxe:</strong></label>
								<input <?php echo $d_req; ?> name="rate_meta[deluxe_rates]" type="number" class='form-control' value="<?php echo isset($get_rate_meta["deluxe_rates"]) ? $get_rate_meta["deluxe_rates"] : 0; ?>" ></input>
							</div>
							<div class='super_deluxe form-group col-md-2' >
								<label><strong>Luxury:</strong></label>
								<input <?php echo $sd_req; ?> name="rate_meta[super_deluxe_rates]" type="number" class='form-control' value="<?php echo isset($get_rate_meta["super_deluxe_rates"]) ? $get_rate_meta["super_deluxe_rates"] : 0; ?>" ></input>
							</div>
							<div class='luxury form-group col-md-2' >
								<label><strong>Super Luxury:</strong></label>
								<input <?php echo $l_req; ?> name="rate_meta[luxury_rates]" type="number" class='form-control' value="<?php echo isset($get_rate_meta["luxury_rates"]) ? $get_rate_meta["luxury_rates"] : 0; ?>" ></input>
							</div>
							
							<div class='form-group col-md-2' >
								<?php 
								$below_base_price = isset( $per_person_ratemeta["below_base_price"] ) && $per_person_ratemeta["below_base_price"] == 1 ? 1 : 0; ?>
								<label><strong>Below Base Price.:</strong></label>
								<input type="checkbox" <?php echo !empty($below_base_price) ? "checked='checked'" : "" ; ?> value="<?php echo $below_base_price; ?>" title="Check if price is below Base Price" class='form-control' id="below_bp"></input>
								
								<input name="per_person_ratemeta[below_base_price]" type="hidden" value="<?php echo $below_base_price; ?>" class='form-control below_bp'></input>
							</div>
							
							<!--div class='form-group col-md-2' >
								<label><strong>GST Inc.:</strong></label>
								<input type="checkbox" value="<?php //echo $inc_gst; ?>" class='form-control' <?php //echo !empty($inc_gst) ? "checked='checked'" : "" ; ?> id="incgst"></input>
							</div-->
							<input name="per_person_ratemeta[inc_gst]" type="hidden" value="1" class='form-control incgst'></input>
							
							<div class='form-group col-md-2' >
								<label><strong>Add Per/Person Rate:</strong></label> <!--inc_gst 1 = true -->
								<input type="checkbox" class='form-control' <?php echo !empty($check_perperson) ? "checked='checked'" : ""; ?> id="per_person_rate" ></input>
							</div>
								
							<div class="clearfix"></div>
							<!--perperson rate meta -->
							<div class="col-md-12 perperson_section" style="display: <?php echo !empty( $check_perperson ) ? "block" : "none"; ?>">
								<div class='standard  form-group col-md-3' >
									<label><strong>Deluxe (Per/Person):</strong></label>
									<input <?php echo $st_req; ?>  name="per_person_ratemeta[standard_rates]" type="number" class='form-control' value="<?php echo $s_pp; ?>" placeholder="Deluxe Per/Person Cost"></input>
								</div>
								
								<div class='deluxe form-group col-md-3' >
									<label><strong>Super Deluxe (Per/Person):</strong></label>
									<input <?php echo $d_req; ?>  name="per_person_ratemeta[deluxe_rates]" type="number"  value="<?php echo $d_pp; ?>" class='form-control' placeholder="Super Deluxe Per/Person Cost"></input>
								</div>
								<div class='super_deluxe form-group col-md-3' >
									<label><strong>Luxury (Per/Person):</strong></label>
									<input <?php echo $sd_req; ?>  name="per_person_ratemeta[super_deluxe_rates]" type="number"  value="<?php echo $sd_pp; ?>" class='form-control' placeholder="Luxury Per/Person Cost"></input>
								</div>
								<div class='luxury form-group col-md-3' >
									<label><strong>Super Luxury (Per/Person):</strong></label>
									<input <?php echo $l_req; ?>  name="per_person_ratemeta[luxury_rates]" type="number"  value="<?php echo $l_pp; ?>" class='form-control' placeholder="Super Deluxe Per/Person Cost"></input>
								</div>
								<div class="clearfix"></div>
								<!--child rates-->
								<!--child rate-->
								<div class='standard  form-group col-md-3' >
									<label><strong  class="red">Deluxe (Per/child):</strong><span style="font-size:10px; color: red;"> ( Leave empty if not exists)</span></label>
									<input <?php echo $st_req; ?> name="per_person_ratemeta[child_standard_rates]" type="number" class='form-control' placeholder="Deluxe Per/child Cost" value="<?php echo $child_s_pp; ?>" ></input>
								</div>
								
								<div class='deluxe form-group col-md-3' >
									<label><strong class="red">Super Deluxe (Per/child):</strong><span style="font-size:10px; color: red;"> ( Leave empty if not exists)</span></label>
									<input <?php echo $d_req; ?> name="per_person_ratemeta[child_deluxe_rates]" type="number" class='form-control' placeholder="Super Deluxe Per/child Cost" value="<?php echo $child_d_pp; ?>" ></input>
								</div>
								<div class='super_deluxe form-group col-md-3' >
									<label><strong  class="red">Luxury (Per/child):</strong><span style="font-size:10px; color: red;"> ( Leave empty if not exists)</span></label>
									<input <?php echo $sd_req; ?> name="per_person_ratemeta[child_super_deluxe_rates]" type="number" class='form-control' placeholder="Luxury Per/child Cost" value="<?php echo $child_sd_pp; ?>" ></input>
								</div>
								<div class='luxury form-group col-md-3' >
									<label><strong  class="red">Super Luxury (Per/child):</strong><span style="font-size:10px; color: red;"> ( Leave empty if not exists)</span></label>
									<input <?php echo $l_req; ?> name="per_person_ratemeta[child_luxury_rates]" type="number" class='form-control' placeholder="Super Deluxe Per/child Cost" value="<?php echo $child_l_pp; ?>" ></input>
								</div>
							</div>
							<!--end perperson rate meta -->
							<div class="clearfix"></div>
							<div class='luxury form-group col-md-4' >
								<label><strong>Rate Comments*</strong><span class="red" style="font-size: 12px;"> Note: This comment is also visible for client.</span></label>
								<textarea required name="rate_comment" class='form-control'><?php echo $iti->rate_comment; ?></textarea>
							</div>
							
							<div class='form-group col-md-4'>
								<input type="hidden" value="<?php echo $iti->iti_id; ?>" name="iti_id">
								<input type="hidden" value="<?php echo $iti->temp_key; ?>" name="temp_key">
								<input type="hidden" value="<?php echo $iti->agent_id; ?>" name="agent_id">
								<input class="btn green button-submit" type="submit" value="update">
							</div>
							<div class="clearfix"></div>
							<div id="res_update_price"></div>
						</form>	
					</div> <!-- row -->
				<?php }	?>
				
				<?php 
				//Discount Price Request
				$dis_price_status = $iti->discount_rate_request;
				//if( $dis_price_status == 1 && ( ( is_manager() && !is_leads_manager() ) || is_admin() ) && $countPrice < 6 && $iti->iti_status == 0  ){ 
				if( ( $dis_price_status == 1  || $dis_price_status == 3 ) && ( ( ( is_manager() && !is_leads_manager() ) || is_admin() ) || (is_teamleader() && $dis_price_status == 3 ) ) && $countPrice < 6 && $iti->iti_status == 0  ){ ?>
				
					<div class="row" id="update_rates_section">
						<!--Old Price Data -->
						<?php 
						//get per person price
						$per_person_ratemeta 	= unserialize($iti->per_person_ratemeta);
						//$inc_gst = isset( $per_person_ratemeta["inc_gst"] ) && $per_person_ratemeta["inc_gst"] == 1 ? "(GST Inc.)" : "(GST Extra)";
						$inc_gst = "";
						$s_pp = isset( $per_person_ratemeta["standard_rates"] ) && !empty($per_person_ratemeta["standard_rates"]) ? "RS. " . number_format($per_person_ratemeta["standard_rates"]) . "/- Per Person" : "";
						$d_pp = isset( $per_person_ratemeta["deluxe_rates"] ) && !empty($per_person_ratemeta["deluxe_rates"]) ? "RS. " . number_format($per_person_ratemeta["deluxe_rates"]) . "/- Per Person" : "";
						$sd_pp = isset( $per_person_ratemeta["super_deluxe_rates"] ) && !empty($per_person_ratemeta["super_deluxe_rates"]) ? "RS. " . number_format($per_person_ratemeta["super_deluxe_rates"]) . "/- Per Person" : "";
						$l_pp = isset( $per_person_ratemeta["luxury_rates"] ) && !empty($per_person_ratemeta["luxury_rates"]) ? "RS. " . number_format($per_person_ratemeta["luxury_rates"]) . "/- Per Person" : ""; 
						
						//child rates
						$child_s_pp = isset( $per_person_ratemeta["child_standard_rates"] ) && !empty($per_person_ratemeta["child_standard_rates"]) ? "RS. " . $per_person_ratemeta["child_standard_rates"] . "/- Per Child" : "";
						$child_d_pp = isset( $per_person_ratemeta["child_deluxe_rates"] ) && !empty($per_person_ratemeta["child_deluxe_rates"]) ? "RS. " . $per_person_ratemeta["child_deluxe_rates"] . "/- Per Child" : "";
						$child_sd_pp = isset( $per_person_ratemeta["child_super_deluxe_rates"] ) && !empty($per_person_ratemeta["child_super_deluxe_rates"]) ? "RS. " . $per_person_ratemeta["child_super_deluxe_rates"] . "/- Per Child" : "";
						$child_l_pp = isset( $per_person_ratemeta["child_luxury_rates"] ) && !empty($per_person_ratemeta["child_luxury_rates"]) ? "RS. " . $per_person_ratemeta["child_luxury_rates"] . "/- Per Child" : "";
						?>
						
						<div class="table-responsive">
							<table class="table table-bordered">
								<thead class="thead-default">
									<tr> <p class="text-center"><strong style="color: red; font-size: 22px;">Old Price</strong></p> </tr>
									<tr>
										<th> Deluxe</th>
										<th> Super Deluxe</th>
										<th> Luxury</th>
										<th> Super Luxury</th>
										<th> Agent Margin(%)</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<?php 
										$s_rates = isset( $get_rate_meta["standard_rates"] ) && !empty( $get_rate_meta["standard_rates"]) ? $get_rate_meta["standard_rates"] : 0;
										$d_rates = isset( $get_rate_meta["deluxe_rates"] ) && !empty( $get_rate_meta["deluxe_rates"]) ? $get_rate_meta["deluxe_rates"] : 0;
										$sd_rates = isset( $get_rate_meta["super_deluxe_rates"] ) && !empty( $get_rate_meta["super_deluxe_rates"]) ? $get_rate_meta["super_deluxe_rates"] : 0;
										$l_rates = isset( $get_rate_meta["luxury_rates"] ) && !empty( $get_rate_meta["luxury_rates"]) ? $get_rate_meta["luxury_rates"] : 0;
										
										$standard_rates = !empty( $s_rates ) ? number_format($s_rates) . "/- {$inc_gst} <br> {$s_pp}<br> {$child_s_pp}" : "N/A";
										$deluxe_rates = !empty( $d_rates ) ? number_format($d_rates) . "/- {$inc_gst} <br> {$d_pp}<br> {$child_d_pp}" : "N/A";
										$super_deluxe_rates = !empty( $sd_rates ) ? number_format($sd_rates) . "/- {$inc_gst} <br> {$sd_pp}<br> {$child_sd_pp}" : "N/A";
										$rate_luxry = !empty( $l_rates ) ? number_format($l_rates) . "/- {$inc_gst} <br> {$l_pp}<br> {$child_l_pp}" : "N/A";
										?>
										<td><?php echo $standard_rates; ?></td>
										<td><?php echo $deluxe_rates; ?></td>
										<td><?php echo $super_deluxe_rates; ?></td>
										<td><?php echo $rate_luxry; ?></td>
										<td><?php echo !empty($iti->agent_price) ? $iti->agent_price . "%" : ""; ?></td>
										
										<!--get last price/agent margin-->
										<?php
											$last_s_price = isset($get_rate_meta["standard_rates"]) ? $get_rate_meta["standard_rates"] : 0;
											$last_d_price = isset($get_rate_meta["deluxe_rates"]) ? $get_rate_meta["deluxe_rates"] : 0;
											$last_sd_price = isset($get_rate_meta["super_deluxe_rates"]) ? $get_rate_meta["super_deluxe_rates"] : 0;
											$last_l_price = isset($get_rate_meta["luxury_rates"]) ? $get_rate_meta["luxury_rates"] : 0;
											$last_person_ratemeta 	= $iti->per_person_ratemeta;
											$last_agent_margin = $iti->agent_price;
										?>
										
									</tr>
									<?php if( !empty( $discountPriceData ) ){
										foreach( $discountPriceData as $price ){
											$per_person_ratemeta 	= unserialize($price->per_person_ratemeta);
											//$inc_gst = isset( $per_person_ratemeta["inc_gst"] ) && $per_person_ratemeta["inc_gst"] == 1 ? "(GST Inc.)" : "(GST Extra)";
											$inc_gst = "";
											$s_pp = isset( $per_person_ratemeta["standard_rates"] ) && !empty($per_person_ratemeta["standard_rates"] ) ? "RS. " . number_format($per_person_ratemeta["standard_rates"]) . "/- Per Person" : "";
											$d_pp = isset( $per_person_ratemeta["deluxe_rates"] ) && !empty($per_person_ratemeta["deluxe_rates"]) ? "RS. " . number_format($per_person_ratemeta["deluxe_rates"]) . "/- Per Person" : "";
											$sd_pp = isset( $per_person_ratemeta["super_deluxe_rates"] ) && !empty($per_person_ratemeta["super_deluxe_rates"]) ? "RS. " . number_format($per_person_ratemeta["super_deluxe_rates"]) . "/- Per Person" : "";
											$l_pp = isset( $per_person_ratemeta["luxury_rates"] ) && !empty($per_person_ratemeta["luxury_rates"]) ? "RS. " . number_format($per_person_ratemeta["luxury_rates"]) . "/- Per Person" : "";
											
											//child rates
											$child_s_pp = isset( $per_person_ratemeta["child_standard_rates"] ) && !empty($per_person_ratemeta["child_standard_rates"]) ? "RS. " . $per_person_ratemeta["child_standard_rates"] . "/- Per Child" : "";
											$child_d_pp = isset( $per_person_ratemeta["child_deluxe_rates"] ) && !empty($per_person_ratemeta["child_deluxe_rates"]) ? "RS. " . $per_person_ratemeta["child_deluxe_rates"] . "/- Per Child" : "";
											$child_sd_pp = isset( $per_person_ratemeta["child_super_deluxe_rates"] ) && !empty($per_person_ratemeta["child_super_deluxe_rates"]) ? "RS. " . $per_person_ratemeta["child_super_deluxe_rates"] . "/- Per Child" : "";
											$child_l_pp = isset( $per_person_ratemeta["child_luxury_rates"] ) && !empty($per_person_ratemeta["child_luxury_rates"]) ? "RS. " . $per_person_ratemeta["child_luxury_rates"] . "/- Per Child" : "";
											
											$s_price = !empty( $price->standard_rates) ? number_format($price->standard_rates) . "/-" : "<strong class='red'>N/A</strong>";
											$d_price = !empty( $price->deluxe_rates) ? number_format($price->deluxe_rates) . "/-" : "<strong class='red'>N/A</strong>";
											$sd_price = !empty( $price->super_deluxe_rates) ? number_format($price->super_deluxe_rates) . "/-"  : "<strong class='red'>N/A</strong>";
											$l_price = !empty( $price->luxury_rates) ? number_format($price->luxury_rates) . "/-"  : "<strong class='red'>N/A</strong>";
											
											$sr = isset( $price->standard_rates ) && !empty( $price->standard_rates ) ? $price->standard_rates : 0;
											$dr = isset( $price->deluxe_rates ) && !empty( $price->deluxe_rates ) ? $price->deluxe_rates : 0;
											$sdr = isset( $price->super_deluxe_rates ) && !empty( $price->super_deluxe_rates ) ? $price->super_deluxe_rates : 0;
											$lr = isset( $price->luxury_rates ) && !empty( $price->luxury_rates ) ? $price->luxury_rates : 0;
									
											echo "<tr><td><strong>" . $s_price . " {$inc_gst} <br> {$s_pp} <br>{$child_s_pp}</strong></td>";
											echo "<td><strong>" . $d_price . " {$inc_gst} <br> {$d_pp}<br>{$child_d_pp}</strong></td>";
											echo "<td><strong>" . $sd_price . " {$inc_gst} <br> {$sd_pp}<br>{$child_sd_pp}</strong></td>";
											echo "<td><strong>" . $l_price . " {$inc_gst} <br> {$l_pp}<br>{$child_l_pp}</strong></td>";
											echo "<td>{$price->agent_price}</td></tr>";
											
											//STORE LAST ROW DATA
											$last_s_price = isset($price->standard_rates) ? $price->standard_rates : 0;
											$last_d_price = isset($price->deluxe_rates) ? $price->deluxe_rates : 0;
											$last_sd_price = isset($price->super_deluxe_rates) ? $price->super_deluxe_rates : 0;
											$last_l_price = isset($price->luxury_rates) ? $price->luxury_rates : 0;
											$last_person_ratemeta 	= $price->per_person_ratemeta;
											$last_agent_margin = $price->agent_price;
										}
									} ?>
								</tbody>
							</table>
						</div>
						
						<!--Discount Price form -->	
						<?php if( $iti->iti_status == 0 ){ ?>
							<form id="frmDiscountRates">
							
								<div class='form-group col-md-12' >
									<p class="text-center"><strong style="font-size: 22px; color: green;">Please Update Rates By Hotel Category : </strong>(DISCOUNT)</p>
								</div>
								
								<div class="col-md-12">
									<div class="text-center">
										<label class="radio-inline">
											<input required class="discount_type" type="radio" name="discount_type" value="reduce_margin">Reduce Agent Margin Only
										</label>
										<label class="radio-inline">
											<input required class="discount_type" type="radio" name="discount_type"  value="custom_discount">Set Custom Price
										</label>
									</div>
								</div>
								<div class="clearfix"></div>
								<hr>
								<div class='update_margin_discount' style="display: none;">
									<div class='standard  form-group col-md-6' >
										<label for="inp_inc_price">Set Margin In Base Price (%): <span class="red" style="font-size: 12px;"> Last Margin: <?php echo $last_agent_margin; ?>%</span></label>
										<select name="dis_agent_margin" id="dis_agent_margin" class="form-control" data-old_percentage="<?php echo !empty($old_per) ? $old_per : 0; ?>" >
											<option value="0">No Margin</option>
											<?php for($bpd = 1 ; $bpd<=100 ; $bpd++ ){
												$selectd = $last_agent_margin == $bpd ? 'selected' : '';
												echo "<option {$selectd} value={$bpd}>{$bpd}%</option>";
											} ?>
										</select>
										<input type='hidden' name='last_standard_rates' value="<?php echo $last_s_price; ?>">
										<input type='hidden' name='last_deluxe_rates' value="<?php echo $last_d_price; ?>">
										<input type='hidden' name='last_super_deluxe_rates' value="<?php echo $last_sd_price; ?>">
										<input type='hidden' name='last_luxury_rates' value="<?php echo $last_l_price; ?>">
										<textarea style='display:none;' name='last_per_person_ratemeta'><?php echo $last_person_ratemeta; ?></textarea>
									</div>
								</div>
								
								<div class='update_price_customprice' style="display: none;">
								<div class='standard  form-group col-md-2' >
									<label><strong>Standard:</strong></label>
									<input <?php echo $st_req; ?> name="standard_rates" type="number" class='form-control'></input>
								</div>
								<div class='deluxe form-group col-md-2' >
									<label><strong>Deluxe:</strong></label>
									<input <?php echo $d_req; ?> name="deluxe_rates" type="number" class='form-control'></input>
								</div>
								<div class='super_deluxe form-group col-md-2' >
									<label><strong>Super Deluxe:</strong></label>
									<input <?php echo $sd_req; ?> name="super_deluxe_rates" type="number" class='form-control'></input>
								</div>
								<div class='luxury form-group col-md-2' >
									<label><strong>Luxury:</strong></label>
									<input <?php echo $l_req; ?> name="luxury_rates" type="number" class='form-control'></input>
								</div>
								<!--div class='form-group col-md-2' >
									<label><strong>GST Inc.:</strong></label>
									<input type="checkbox" value="1" class='form-control' id="incgst"></input>
								</div-->
								
								<div class='form-group col-md-2' >
									<?php 
									$below_base_price = isset( $per_person_ratemeta["below_base_price"] ) && $per_person_ratemeta["below_base_price"] == 1 ? 1 : 0; ?>
									<label><strong>Below Base Price.:</strong></label>
									<input type="checkbox" <?php echo !empty($below_base_price) ? "checked='checked'" : "" ; ?> value="<?php echo $below_base_price; ?>" title="Check if price is below Base Price" class='form-control' id="below_bp"></input>
									
									<input name="per_person_ratemeta[below_base_price]" type="hidden" value="<?php echo $below_base_price; ?>" class='form-control below_bp'></input>
								</div>
								
								<input name="per_person_ratemeta[inc_gst]" type="hidden" value="1" class='form-control incgst'></input>
								
								<div class='form-group col-md-2' >
									<label><strong>Add Per/Person Rate:</strong></label> <!--inc_gst 1 = true -->
									<input type="checkbox" class='form-control' id="per_person_rate" ></input>
								</div>
								<div class="clearfix"></div>
								<!--perperson rate meta -->
								<div class="col-md-12 perperson_section" style="display: none;">
									<div class='standard  form-group col-md-3' >
										<label><strong>Deluxe (Per/Person):</strong></label>
										<input <?php echo $st_req; ?> name="per_person_ratemeta[standard_rates]" type="number" class='form-control' placeholder="Deluxe Per/Person Cost"></input>
									</div>
									
									<div class='deluxe form-group col-md-3' >
										<label><strong>Super Deluxe (Per/Person):</strong></label>
										<input <?php echo $d_req; ?> name="per_person_ratemeta[deluxe_rates]" type="number"  class='form-control' placeholder="Super Deluxe Per/Person Cost"></input>
									</div>
									<div class='super_deluxe form-group col-md-3' >
										<label><strong>Luxury (Per/Person):</strong></label>
										<input <?php echo $sd_req; ?> name="per_person_ratemeta[super_deluxe_rates]" type="number" class='form-control' placeholder="Luxury Per/Person Cost"></input>
									</div>
									<div class='luxury form-group col-md-3' >
										<label><strong>Super Luxury (Per/Person):</strong></label>
										<input <?php echo $l_req; ?> name="per_person_ratemeta[luxury_rates]" type="number"  class='form-control' placeholder="Super Deluxe Per/Person Cost"></input>
									</div>
									
									<!--child rate-->
									<div class='standard  form-group col-md-3' >
										<label><strong  class="red">Deluxe (Per/child):</strong><span style="font-size:10px; color: red;"> ( Leave empty if not exists)</span></label>
										<input <?php echo $st_req; ?> name="per_person_ratemeta[child_standard_rates]" type="number" class='form-control' placeholder="Deluxe Per/child Cost"></input>
									</div>
									
									<div class='deluxe form-group col-md-3' >
										<label><strong class="red">Super Deluxe (Per/child):</strong><span style="font-size:10px; color: red;"> ( Leave empty if not exists)</span></label>
										<input <?php echo $d_req; ?> name="per_person_ratemeta[child_deluxe_rates]" type="number" class='form-control' placeholder="Super Deluxe Per/child Cost"></input>
									</div>
									<div class='super_deluxe form-group col-md-3' >
										<label><strong  class="red">Luxury (Per/child):</strong><span style="font-size:10px; color: red;"> ( Leave empty if not exists)</span></label>
										<input <?php echo $sd_req; ?> name="per_person_ratemeta[child_super_deluxe_rates]" type="number" class='form-control' placeholder="Luxury Per/child Cost"></input>
									</div>
									<div class='luxury form-group col-md-3' >
										<label><strong  class="red">Super Luxury (Per/child):</strong><span style="font-size:10px; color: red;"> ( Leave empty if not exists)</span></label>
										<input <?php echo $l_req; ?> name="per_person_ratemeta[child_luxury_rates]" type="number" class='form-control' placeholder="Super Deluxe Per/child Cost"></input>
									</div>
									
								</div>
								</div><!--custom price-->
								<div class="clearfix"></div>
								<div class='luxury form-group col-md-4' >
									<label><strong>Rate Comments*</strong><span class="red" style="font-size: 12px;"> Note: This comment is also visible for client.</span></label>
									<textarea required name="rate_comment" class='form-control'></textarea>
								</div>
							
								<div class='form-group col-md-4' >
									<input type="hidden" value="<?php echo $iti->iti_id; ?>" name="iti_id">
									<input type="hidden" value="<?php echo $iti->temp_key; ?>" name="temp_key">
									<input type="hidden" value="<?php echo $iti->agent_id; ?>" name="user_id">
									<input type="hidden" value="<?php echo $iti->agent_id; ?>" name="agent_id">
									<input type="hidden" value="<?php echo $iti->customer_id; ?>" name="customer_id">
									<!--input type="submit" class="btn green button-submit" value="Update"-->
									<button name="action" title="Direct Update" class="btn green button-submit" type="submit" value="agent">Update</button>
									<?php if( !is_super_manager() ){ ?>
										<strong class="red"> OR </strong>
										<?php if( is_teamleader() ){ ?>
											<button name="action" class="btn green button-submit" type="submit" value="manager">Send To Manager
										<?php }else{ ?>
											<button name="action" title="Sent rates to supermanager for verfiy"  class="btn green button-submit" type="submit" value="supermanager">Send To Admin/Super Manager</button>
										<?php } ?>
									<?php } ?>
								</div>
								
								<div class="clearfix"></div>
								<div id="response_div"></div>
							</form>	
						<?php } ?>	
					</div> <!-- row -->
				<?php }	?>
				
				
				<!-- price updated by supermanager -->
				<?php if( !empty( $discount_pending_rates ) && ( is_admin() || is_super_manager() ) && $iti->discount_rate_request == 2 ){ ?>
					<?php 
					$dix_price = $discount_pending_rates[0];
					//get per person price
					$per_person_ratemeta 	= unserialize($dix_price->per_person_ratemeta);
					$s_pp = isset( $per_person_ratemeta["standard_rates"] ) && !empty($per_person_ratemeta["standard_rates"] ) ? $per_person_ratemeta["standard_rates"] : "";
					$d_pp = isset( $per_person_ratemeta["deluxe_rates"] ) && !empty($per_person_ratemeta["deluxe_rates"]) ? $per_person_ratemeta["deluxe_rates"] : "";
					$sd_pp = isset( $per_person_ratemeta["super_deluxe_rates"] ) && !empty($per_person_ratemeta["super_deluxe_rates"]) ? $per_person_ratemeta["super_deluxe_rates"] : "";
					$l_pp = isset( $per_person_ratemeta["luxury_rates"] ) && !empty($per_person_ratemeta["luxury_rates"]) ? $per_person_ratemeta["luxury_rates"] : "";
					
					
					//child rates
					$child_s_pp = isset( $per_person_ratemeta["child_standard_rates"] ) && !empty($per_person_ratemeta["child_standard_rates"]) ?$per_person_ratemeta["child_standard_rates"] : "";
					$child_d_pp = isset( $per_person_ratemeta["child_deluxe_rates"] ) && !empty($per_person_ratemeta["child_deluxe_rates"]) ? $per_person_ratemeta["child_deluxe_rates"] : "";
					$child_sd_pp = isset( $per_person_ratemeta["child_super_deluxe_rates"] ) && !empty($per_person_ratemeta["child_super_deluxe_rates"]) ? $per_person_ratemeta["child_super_deluxe_rates"] : "";
					$child_l_pp = isset( $per_person_ratemeta["child_luxury_rates"] ) && !empty($per_person_ratemeta["child_luxury_rates"]) ? $per_person_ratemeta["child_luxury_rates"] : ""; 
					
					//check if per/person rate exists
					$inc_gst = isset( $per_person_ratemeta["inc_gst"] ) && $per_person_ratemeta["inc_gst"] == 1 ? 1 : 0;
					$check_perperson = !empty( $s_pp ) ||  !empty( $d_pp ) ||  !empty( $sd_pp ) ||  !empty( $l_pp ) ? 1 : 0;
					
					$stand_r 	= isset( $dix_price->standard_rates  ) && !empty( $dix_price->standard_rates ) ? $dix_price->standard_rates : "";
					$del_r 		= isset( $dix_price->deluxe_rates ) && !empty( $dix_price->deluxe_rates ) ? $dix_price->deluxe_rates : "";
					$sdelux_r	= isset( $dix_price->super_deluxe_rates  ) && !empty( $dix_price->super_deluxe_rates ) ? $dix_price->super_deluxe_rates : "";
					$lux_r 		= isset(  $dix_price->luxury_rates  ) && !empty( $dix_price->luxury_rates ) ? $dix_price->luxury_rates : "";
					//dump( $discount_pending_rates ); ?>
					<form id="frmDiscountSupermanager">
						<div class='form-group col-md-12' >
							<p class="text-center"><strong style="font-size: 22px; color: green;">Please Approve/Update Rates By Hotel Category: </strong></p>
						</div>
						
						<div class='standard  form-group col-md-2' >
							<label><strong>Deluxe:</strong></label>
							<input name="standard_rates" type="number" <?php if( empty( $stand_r ) ){ echo "readonly"; }else{ echo "required"; } ?> class='form-control' value="<?php if( !empty( $stand_r ) ){ echo $stand_r; } ?>" ></input>
						</div>
						<div class='deluxe form-group col-md-2' >
							<label><strong>Super Deluxe:</strong></label>
							<input <?php if( empty( $del_r ) ){ echo "readonly"; }else{ echo "required"; } ?>  name="deluxe_rates" type="number" class='form-control' value="<?php if( !empty( $del_r ) ){ echo $del_r; } ?>" ></input>
						</div>
						<div class='super_deluxe form-group col-md-2' >
							<label><strong>Luxury:</strong></label>
							<input <?php if( empty( $sdelux_r ) ){ echo "readonly"; }else{ echo "required"; } ?>   name="super_deluxe_rates" type="number" class='form-control' value="<?php if( !empty( $sdelux_r ) ){ echo $sdelux_r; } ?>"></input>
						</div>
						<div class='luxury form-group col-md-2' >
							<label><strong>Super Luxury:</strong></label>
							<input <?php if( empty( $lux_r ) ){ echo "readonly"; }else{ echo "required"; } ?>  name="luxury_rates" type="number" class='form-control' value="<?php if( !empty( $lux_r ) ){ echo $lux_r; } ?>"></input>
						</div>
						<!--div class='form-group col-md-2' >
							<label><strong>GST Inc.:</strong></label>
							<input type="checkbox" value="<?php //echo $inc_gst; ?>" class='form-control' <?php //echo !empty($inc_gst) ? "checked='checked'" : "" ; ?> id="incgst"></input>
						</div-->
						
						<div class='form-group col-md-2' >
							<?php 
							$below_base_price = isset( $per_person_ratemeta["below_base_price"] ) && $per_person_ratemeta["below_base_price"] == 1 ? 1 : 0; ?>
							<label><strong>Below Base Price.:</strong></label>
							<input type="checkbox" <?php echo !empty($below_base_price) ? "checked='checked'" : "" ; ?> value="<?php echo $below_base_price; ?>" title="Check if price is below Base Price" class='form-control' id="below_bp"></input>
							
							<input name="per_person_ratemeta[below_base_price]" type="hidden" value="<?php echo $below_base_price; ?>" class='form-control below_bp'></input>
						</div>
						
						<input name="per_person_ratemeta[inc_gst]" type="hidden" value="1" class='form-control incgst'></input>
						
						<div class='form-group col-md-2' >
							<label><strong>Add Per/Person Rate:</strong></label> <!--inc_gst 1 = true -->
							<input type="checkbox" class='form-control' <?php echo !empty($check_perperson) ? "checked='checked'" : ""; ?> id="per_person_rate" ></input>
						</div>
						<div class="clearfix"></div>
						<!--perperson rate meta -->
						<div class="col-md-12 perperson_section" style="display: <?php echo !empty($check_perperson) ? "block" : "none"; ?>;">
							<div class='standard  form-group col-md-3' >
								<label><strong>Deluxe (Per/Person):</strong></label>
								<input name="per_person_ratemeta[standard_rates]"  value="<?php echo $s_pp; ?>"  type="number" <?php if( empty( $stand_r ) ){ echo "readonly"; }else{ echo "required"; } ?> class='form-control' placeholder="Deluxe Per/Person Cost"></input>
							</div>
							
							<div class='deluxe form-group col-md-3' >
								<label><strong>Super Deluxe (Per/Person):</strong></label>
								<input name="per_person_ratemeta[deluxe_rates]"  value="<?php echo $d_pp; ?>" type="number" <?php if( empty( $del_r ) ){ echo "readonly"; }else{ echo "required"; } ?> class='form-control' placeholder="Super Deluxe Per/Person Cost"></input>
							</div>
							<div class='super_deluxe form-group col-md-3' >
								<label><strong>Luxury (Per/Person):</strong></label>
								<input name="per_person_ratemeta[super_deluxe_rates]"  value="<?php echo $sd_pp; ?>" type="number" <?php if( empty( $sdelux_r ) ){ echo "readonly"; }else{ echo "required"; } ?> class='form-control' placeholder="Luxury Per/Person Cost"></input>
							</div>
							<div class='luxury form-group col-md-3' >
								<label><strong>Super Luxury (Per/Person):</strong></label>
								<input name="per_person_ratemeta[luxury_rates]" type="number" <?php if( empty( $lux_r ) ){ echo "readonly"; }else{ echo "required"; } ?> class='form-control' value="<?php echo $l_pp; ?>" placeholder="Super Deluxe Per/Person Cost"></input>
							</div>
							
							<div class="clearfix"></div>
							<!--child rates-->
							<!--child rate-->
							<div class='standard  form-group col-md-3' >
								<label><strong  class="red">Deluxe (Per/child):</strong><span style="font-size:10px; color: red;"> ( Leave empty if not exists)</span></label>
								<input <?php echo $st_req; ?> name="per_person_ratemeta[child_standard_rates]" type="number" class='form-control' placeholder="Deluxe Per/child Cost" value="<?php echo $child_s_pp; ?>" ></input>
							</div>
							
							<div class='deluxe form-group col-md-3' >
								<label><strong class="red">Super Deluxe (Per/child):</strong><span style="font-size:10px; color: red;"> ( Leave empty if not exists)</span></label>
								<input <?php echo $d_req; ?> name="per_person_ratemeta[child_deluxe_rates]" type="number" class='form-control' placeholder="Super Deluxe Per/child Cost" value="<?php echo $child_d_pp; ?>" ></input>
							</div>
							<div class='super_deluxe form-group col-md-3' >
								<label><strong  class="red">Luxury (Per/child):</strong><span style="font-size:10px; color: red;"> ( Leave empty if not exists)</span></label>
								<input <?php echo $sd_req; ?> name="per_person_ratemeta[child_super_deluxe_rates]" type="number" class='form-control' placeholder="Luxury Per/child Cost" value="<?php echo $child_sd_pp; ?>" ></input>
							</div>
							<div class='luxury form-group col-md-3' >
								<label><strong  class="red">Super Luxury (Per/child):</strong><span style="font-size:10px; color: red;"> ( Leave empty if not exists)</span></label>
								<input <?php echo $l_req; ?> name="per_person_ratemeta[child_luxury_rates]" type="number" class='form-control' placeholder="Super Deluxe Per/child Cost" value="<?php echo $child_l_pp; ?>" ></input>
							</div>
						</div>
						<!--end perperson rate meta -->
						
						<div class="clearfix"></div>
						<div class='luxury form-group col-md-4' >
							<label><strong>Rate Comments*</strong><span class="red" style="font-size: 12px;"> Note: This comment is also visible for client.</span></label>
							<textarea required name="rate_comment" class='form-control'></textarea>
						</div>
						
						<div class='form-group col-md-4' >
							<input type="hidden" value="<?php echo $dix_price->iti_id; ?>" name="iti_id">
							<input type="hidden" value="<?php echo $dix_price->id; ?>" name="discount_id">
							<input type="hidden" value="<?php echo $iti->agent_id; ?>" name="agent_id">
							<input type="hidden" value="<?php echo $iti->customer_id; ?>" name="customer_id">
							<button name="action" title="Direct Update" class="btn green button-submit" type="submit" value="agent">Approve/Update</button>
						</div>
						<p class="clearfix text-center red">Comment by Manager: <?php echo $iti->rate_comment; ?> </p>
						<div class="clearfix"></div>
						<div id="response_div"></div>
					</form>
				<?php } ?><!-- ENd price updated by supermanager -->
				
				
				<div class="row2">
					<?php // echo $greeting; ?>
					
					<!--BOOKING DETAILS-->
					<?php if( ($user_role == 99 || $user_role == 98 || $user_role == 97) && isset( $hotel_bookings ) && !empty( $hotel_bookings ) ){ ?>
					
						<?php 
						$total_p_cost = $paymentDetails[0]->total_package_cost;
						$total_booking_cost = 0; //hotel+cab+volvo
						$sr = 1;
						?>
					
						<div class="caption">
							<h3 style="background: green; color: #fff; padding: 5px;">BOOKING DETAILS</h3>
						</div>
					
						<div class="table-responsive booking_details_pro" style="background: #c9e6e4;">
							<table class="table table-bordered">
								<thead class="thead-default">
									<tr>
										<th>Sr.</th>
										<th> Booking Type </th>
										<th> Status </th>
										<th> Cost </th>
										<th> Action </th>
									</tr>
								</thead>
								<tbody>
									<!--HOTEL BOOKING LISTING-->
									<?php if( isset( $hotel_bookings ) && !empty( $hotel_bookings ) ){ 
										foreach( $hotel_bookings as $hotel_book ){
											$hotel_id = $hotel_book->hotel_id;
											$hotel_name = get_hotel_name( $hotel_id );
											$city = get_city_name($hotel_book->city_id);
											$total_cost	= number_format($hotel_book->total_cost);
											
											$view_btn = "<a title='View' href=" . site_url("hotelbooking/view/{$hotel_book->id}/{$hotel_book->iti_id}") . " class='btn btn-success' target='_blank' ><i class='fa fa-eye' aria-hidden='true'></i></a>";
											
											echo "<tr>
												<td>{$sr}.</td>
												<td><strong style='color: red'>HOTEL </strong><strong> {$hotel_name} ( {$city} ) </strong></td>
												<td>BOOKED</td>
												<td>{$total_cost}</td>
												<td>{$view_btn}</td>
												</tr>";
												$total_booking_cost += $hotel_book->total_cost;
											$sr++;
										}
									} ?>
									
									<!--CAB BOOKING LISTING-->
									<?php if( isset( $cab_bookings ) && !empty( $cab_bookings ) ){ 
										foreach( $cab_bookings as $c_book ){
											//$total_cabs = $c_book->total_cabs;
											//$cab_rate = $c_book->cab_rate;;
											//$total_cab_cost_perday = $total_cabs * $cab_rate;
											//$inclusion_cost = $c_book->extra_charges;
											$total_cost = number_format($c_book->total_cost);
											$cab = get_car_name($c_book->cab_id);
											$total_cab = $c_book->total_cabs;
											$view_btn = "<a title='View' href=" . site_url("vehiclesbooking/viewbooking/{$c_book->id}") . " class='btn btn-success' target='_blank' ><i class='fa fa-eye' aria-hidden='true'></i></a>";
											
											echo "<tr>
												<td>{$sr}.</td>
												<td><strong style='color: green'>CAB</strong> ( {$cab} * {$total_cab} ) </td>
												<td>BOOKED</td>
												<td>{$total_cost}</td>
												<td>{$view_btn}</td>
												</tr>";
												
												$total_booking_cost += $c_book->total_cost;
											$sr++;
										}
									} ?>
									
									<!--VOLVO/TRAIN/FLIGHT BOOKING LISTING-->
									<?php if( isset( $vtf_bookings ) && !empty( $vtf_bookings ) ){ 
										foreach( $vtf_bookings as $vtf_book ){
											$single_trip_cost = $vtf_book->cost_per_seat * $vtf_book->total_seats;
											$return_trip_cost = !empty( $vtf_book->cost_per_seat_return_trip ) ? $vtf_book->cost_per_seat_return_trip * $vtf_book->total_seats : 0;
											$tc = $single_trip_cost + $return_trip_cost;
											$total_cost = number_format( $tc );
											
											$view_btn = "<a title='View' href=" . site_url("vehiclesbooking/viewvehiclebooking/{$c_book->id}/{$vtf_book->id}/{$vtf_book->iti_id}") . " class='btn btn-success' target='_blank' ><i class='fa fa-eye' aria-hidden='true'></i></a>";
											$type = ucfirst($vtf_book->booking_type);
											echo "<tr>
												<td>{$sr}.</td>
												<td><strong>{$type}</strong></td>
												<td>BOOKED</td>
												<td>{$total_cost}</td>
												<td>{$view_btn}</td>
												</tr>";
												
												$total_booking_cost += $tc;
											$sr++;
										}
									} ?>
									
									<!--calculate profit/loss-->
									<?php 
										$profit = $total_p_cost - $total_booking_cost;
										$pro_text = $profit < 0 ? "<strong style='color: red'> ( Loss )</strong>" : "<strong style='color: green'> ( PROFIT ) </strong>";
									?>
									
									<tr><td colspan="2"></td>
										<td><strong>Total Expenses : </strong></td>
										<td colspan="2"><?php echo number_format($total_booking_cost); ?></td>
									</tr>
									<tr><td colspan="2"></td>
										<td><strong>Package Cost : </strong></td>
										<td colspan="2"><?php echo number_format($total_p_cost); ?></td>
									</tr>
									<tr><td colspan="2"></td>
										<td><strong>Profit/Loss : </strong></td>
										<td colspan="2"><strong><?php echo number_format($profit) . "</strong>" . $pro_text; ?></td>
									</tr>
								</tbody>
							</table>
						</div>
					<?php } ?>
					<!--END BOOKING DETAILS-->
				
					<div class="printable" id="printable"> <!--START PRINTABLE SECTION -->
					<?php if( isset( $paymentDetails[0] ) && !empty( $paymentDetails[0] ) && $iti->iti_status == 9 ){ 
						$pay_detail = $paymentDetails[0]; ?>
						<h3 style="background: #3d3d3d; color: #fff; padding: 5px;">PAYMENT DETAILS</h3>
						<div class="clearfix"></div>
						<div class="table-responsive">
							<table class="table table-bordered ">
								<tbody>
									<tr class="thead-inverse" >
										<td width="33%"><strong>FINAL COST</strong></td>
										<td width="33%"><strong>Package Category</strong></td>
										<td width="33%"><strong>Travel Date</strong></td>
									</tr>
									
									
									<tr class="" >
										<td width="33%"><strong>INR <?php echo $paymentDetails[0]->total_package_cost; ?>/-</strong></td>
										<td width="33%"><strong><?php echo $iti->approved_package_category; ?></strong></td>
										<td width="33%"><strong><?php echo !empty($t_date) ? $t_date : "--/--/----"; ?></strong></td>
									</tr>
									
									
									<tr class="thead-inverse" >
										<td width="33%"><strong>Advance Recieved</strong></td>
										<td width="33%"><strong>Balance Pending</strong></td>
										<td width="33%"><strong>Booking Date</strong></td>
									</tr>
									<?php $booking_d = $paymentDetails[0]->booking_date; ?>
									<tr class="" >
										<td width="33%"><strong>INR <?php echo $paymentDetails[0]->advance_recieved; ?>/-</strong></td>
										<td width="33%"><strong><?php echo $paymentDetails[0]->total_balance_amount; ?>/-</strong></td>
										<td width="33%"><strong><?php echo !empty($booking_d) ? display_month_name($booking_d ) : "--/--/----"; ?></strong></td>
									</tr>
									
									
									
								</tbody>
							</table>
						</div>
				<?php } ?>
				
					<div class="well well-sm"><h3>Package Overview</h3></div>
					<div class="table-responsive">
						<table class="table table-bordered ">
							<tbody>
								<tr class="thead-inverse" >
									<td width="33%"><strong>Name of Package</strong></td>
									<td width="33%"><strong>Routing</strong></td>
									<td width="33%"><strong>No of Travelers</strong></td>
								</tr>
								<tr>
									<td><?php echo $iti->package_name; ?></td>
									<td><?php echo $iti->package_routing; ?></td>
									<td><div class="traveller-info">
										<?php
										echo "<strong> Adults: </strong> " . $iti->adults; 
										if( !empty( $iti->child ) ){
											echo "  <strong> No. of Child: </strong> " . $iti->child; 
											echo " (" . $iti->child_age .")"; 
										}
										?>
										</div>
									</td>
								</tr>
								<tr class="thead-inverse">
									<td><strong>Tour Start Date</strong></td>
									<td><strong>Tour End Date</strong></td>
									<td><strong>Total Nights</strong></td>
								</tr>
								<tr>
									<td><?php echo $iti->t_start_date; ?></td>
									<td><?php echo $iti->t_end_date; ?></td>
									<td><?php echo $iti->total_nights . " Nights"; ?></td>
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
							</tbody>
						</table>
					</div>
					<div class="clearfix"></div>
					<hr>
					<div class="well well-sm"><h3>Hotel Details</h3></div>
					<?php $hotel_meta = unserialize($iti->hotel_meta); 
					$standard_html = "";
					$deluxe_html = "";
					$super_deluxe_html = "";
					$luxury_html = "";
					$table_start = "<table class='table table-bordered'><tr><th>City</th><th>Hotel Category</th><th>Check In</th>				<th>Check Out</th><th>Hotel</th><th>Room Category</th><th>Plan</th><th>Room</th><th>N/T</th></tr>";
					//print_r( $hotel_meta );
					if( !empty( $hotel_meta ) ){
						$count_hotel = count( $hotel_meta ); 
							/* print_r( $hotel_meta ); */
							if( $count_hotel > 0 ){
								for ( $i = 0; $i < $count_hotel; $i++ ){
									
									$hotel_location = $hotel_meta[$i]["hotel_location"];
									$check_in 		= $hotel_meta[$i]["check_in"];
									$check_out 		= $hotel_meta[$i]["check_out"];
									$total_room 	= $hotel_meta[$i]["total_room"];
									$total_nights 	= $hotel_meta[$i]["total_nights"];
									$extra_bed 		= !empty( $hotel_meta[$i]['extra_bed'] ) ? " + <strong>" . $hotel_meta[$i]['extra_bed'] . " </strong> Extra Bed" : "";
									
									$hotel_inner_meta = $hotel_meta[$i]["hotel_inner_meta"];
									//Fetch hotel inner meta
									$count_innermeta = count( $hotel_inner_meta );
									//print_r($hotel_inner_meta);
									
									if( !empty( $count_innermeta ) ){
										for( $ii = 0 ; $ii < $count_innermeta ; $ii++ ){
											$hotel_category	= $hotel_inner_meta[$ii]["hotel_category"];
											
											$room_category 	= $hotel_inner_meta[$ii]["room_category"];
											$hotel_name 	= $hotel_inner_meta[$ii]["hotel_name"];
											$meal_plan 		= $hotel_inner_meta[$ii]["meal_plan"];
											
											//hotel details html category wise
											switch( $hotel_category ){
												case "Standard":
													$standard_html .= "<tr>
														<td>{$hotel_location}</td>
														<td>Deluxe</td>
														<td>{$check_in}</td>
														<td>{$check_out}</td>
														<td>{$hotel_name}</td>
														<td>{$room_category}</td>
														<td>{$meal_plan}</td>
														<td>{$total_room}{$extra_bed}</td>
														<td>{$total_nights}</td>
													</tr>";
												break;
												case "Deluxe":
													$deluxe_html .= "<tr>
														<td>{$hotel_location}</td>
														<td>Super Deluxe</td>
														<td>{$check_in}</td>
														<td>{$check_out}</td>
														<td>{$hotel_name}</td>
														<td>{$room_category}</td>
														<td>{$meal_plan}</td>
														<td>{$total_room}{$extra_bed}</td>
														<td>{$total_nights}</td>
													</tr>";
												break;
												case "Super Deluxe":
													$super_deluxe_html .= "<tr>
														<td>{$hotel_location}</td>
														<td>Luxury</td>
														<td>{$check_in}</td>
														<td>{$check_out}</td>
														<td>{$hotel_name}</td>
														<td>{$room_category}</td>
														<td>{$meal_plan}</td>
														<td>{$total_room}{$extra_bed}</td>
														<td>{$total_nights}</td>
													</tr>";
												break;
												case "Luxury":
													$luxury_html .= "<tr>
														<td>{$hotel_location}</td>
														<td>Super Luxury</td>
														<td>{$check_in}</td>
														<td>{$check_out}</td>
														<td>{$hotel_name}</td>
														<td>{$room_category}</td>
														<td>{$meal_plan}</td>
														<td>{$total_room}{$extra_bed}</td>
														<td>{$total_nights}</td>
													</tr>";
												break;
												// default:
												// 	continue;
												// break;
											}
										}
									}
									
									
								} 	
								
								//print_r( array_column($hotel_meta, 'hotel_category') ); 
								//Check hotel category if exists
								/* $is_standard	= in_array("Standard", array_column($hotel_meta, 'hotel_category')) ? TRUE : FALSE;
								$is_deluxe		= in_array("Deluxe", array_column($hotel_meta, 'hotel_category')) ? TRUE : FALSE;
								$is_s_deluxe 	= in_array("Super Deluxe", array_column($hotel_meta, 'hotel_category')) ? TRUE : FALSE;
								$is_luxury 		= in_array("Luxury", array_column($hotel_meta, 'hotel_category')) ? TRUE : FALSE; */
								
								if( $is_standard ) {
									echo "<div class='well well-sm'><h3>Deluxe</h3></div>";
									echo $table_start . $standard_html . "</table>";
								}
								if( $is_deluxe ){
									echo "<div class='well well-sm'><h3>Super Deluxe</h3></div>";
									echo $table_start . $deluxe_html . "</table>";
								}
								if( $is_s_deluxe ){
									echo "<div class='well well-sm'><h3>Luxury</h3></div>";
									echo $table_start . $super_deluxe_html . "</table>";
								}
								if( $is_luxury ){
									echo "<div class='well well-sm'><h3>Super Luxury</h3></div>";
									echo $table_start . $luxury_html . "</table>";
								}
							} ?>
						
						<?php } ?>	
					<hr>
					<div class="well well-sm"><h3>Rates</h3></div>
					<!-- Rate Meta -->
					<table class='table table-bordered'><tr>
						<th>Hotel Category</th>
						<th>Deluxe</th>
						<th>Super Deluxe</th>
						<th>Luxury</th>
						<th>Super Luxury</th>
					</tr>
					<?php
					//Rate meta
					$rate_meta = unserialize($iti->rates_meta);
					$strike_class = !empty( $discountPriceData ) ? "strikeLine" : " ";
					//$strike_class_final = !empty( $iti->final_amount ) ? "strikeLine" : "";
					$strike_class_final = !empty( $iti->final_amount ) && $iti->iti_status == 9 ? "strikeLine" : "";
					//print_r( $rate_meta );
					$iti_close_status = $iti->iti_close_status;
					//print_r( $rate_meta );
					if( empty($iti_close_status) ){
					if( !empty( $rate_meta ) ){
						if( $iti->pending_price == 4 ){
							echo "<tr><td  colspan=5 class='red'>Awaiting price verfication from super manager.</td></tr>"; 
						}else{
							$agent_price_percentage = !empty($iti->agent_price) ? $iti->agent_price : 0;
							$app = !empty($iti->agent_price) ? "(". $iti->agent_price . "%)" : "";
							echo $app;
							//get per person price
							$per_person_ratemeta 	= unserialize($iti->per_person_ratemeta);
							//$inc_gst = isset( $per_person_ratemeta["inc_gst"] ) && $per_person_ratemeta["inc_gst"] == 1 ? "(GST Inc.)" : "(GST Extra)";
							$inc_gst = "";
							$below_base_price = isset( $per_person_ratemeta["below_base_price"] ) && $per_person_ratemeta["below_base_price"] == 1 ? "(Below BP.)" : "";
							$bbp_css = isset( $per_person_ratemeta["below_base_price"] ) && $per_person_ratemeta["below_base_price"] == 1 ? "bbptr" : "";				
							$agent_sp = $agent_dp = $agent_sdp = $agent_lp = "";
							//if percentage exists
							if( $agent_price_percentage ){
								$as_pp = isset( $per_person_ratemeta["standard_rates"] ) && !empty($per_person_ratemeta["standard_rates"]) ? " Rs." . ($per_person_ratemeta["standard_rates"] +  $per_person_ratemeta["standard_rates"] * $agent_price_percentage/100 ). " Per/Person" : "";
								$ad_pp = isset( $per_person_ratemeta["deluxe_rates"] ) && !empty($per_person_ratemeta["deluxe_rates"]) ? " Rs." . ($per_person_ratemeta["deluxe_rates"] +  $per_person_ratemeta["deluxe_rates"] * $agent_price_percentage/100 ). " Per/Person" : "";
								$asd_pp = isset( $per_person_ratemeta["super_deluxe_rates"] ) && !empty($per_person_ratemeta["super_deluxe_rates"]) ? " Rs." . ($per_person_ratemeta["super_deluxe_rates"] +  $per_person_ratemeta["super_deluxe_rates"] * $agent_price_percentage/100 ). " Per/Person" : "";
								$al_pp = isset( $per_person_ratemeta["luxury_rates"] ) && !empty($per_person_ratemeta["luxury_rates"]) ? " Rs." . ($per_person_ratemeta["luxury_rates"] +  $per_person_ratemeta["luxury_rates"] * $agent_price_percentage/100)  . " Per/Person" : "";

								//child rates
								$achild_s_pp = isset( $per_person_ratemeta["child_standard_rates"] ) && !empty($per_person_ratemeta["child_standard_rates"]) ? "RS. " .  number_format( $per_person_ratemeta["child_standard_rates"]  + $per_person_ratemeta["child_standard_rates"] * $agent_price_percentage/100  ) . "/- Per Child" : "";
								
								$achild_d_pp = isset( $per_person_ratemeta["child_deluxe_rates"] ) && !empty($per_person_ratemeta["child_deluxe_rates"]) ? "RS. " . number_format( $per_person_ratemeta["child_deluxe_rates"] +  $per_person_ratemeta["child_deluxe_rates"] * $agent_price_percentage/100 ) . "/- Per Child" : "";
								
								$achild_sd_pp = isset( $per_person_ratemeta["child_super_deluxe_rates"] ) && !empty($per_person_ratemeta["child_super_deluxe_rates"]) ? "RS. " . number_format( $per_person_ratemeta["child_super_deluxe_rates"] +  $per_person_ratemeta["child_super_deluxe_rates"] * $agent_price_percentage/100 ) . "/- Per Child" : "";
								
								$achild_l_pp = isset( $per_person_ratemeta["child_luxury_rates"] ) && !empty($per_person_ratemeta["child_luxury_rates"]) ? "RS. " .   number_format( $per_person_ratemeta["child_luxury_rates"] +  $per_person_ratemeta["child_luxury_rates"] * $agent_price_percentage/100 ) . "/- Per Child" : "";													
								
								$astandard_rates = !empty( $rate_meta["standard_rates"]) ? number_format($rate_meta["standard_rates"] + $rate_meta["standard_rates"] * $agent_price_percentage / 100 ) . "/- {$inc_gst}" : "<strong class='red'>On Request</strong>";
								
								$adeluxe_rates = !empty( $rate_meta["deluxe_rates"]) ? number_format($rate_meta["deluxe_rates"] + $rate_meta["deluxe_rates"] * $agent_price_percentage / 100 ) . "/- {$inc_gst}" : "<strong class='red'>On Request</strong>";
								
								$asuper_deluxe_rates = !empty( $rate_meta["super_deluxe_rates"]) ? number_format($rate_meta["super_deluxe_rates"] + $rate_meta["super_deluxe_rates"] * $agent_price_percentage / 100  ) . "/- {$inc_gst}" : "<strong class='red'>On Request</strong>";
								$arate_luxry = !empty( $rate_meta["luxury_rates"]) ? number_format($rate_meta["luxury_rates"] + $rate_meta["luxury_rates"] * $agent_price_percentage / 100 ) . "/- {$inc_gst}" : "<strong class='red'>On Request</strong>";
								
								$agent_sp = "<br><strong class='aprice'> AP( " . $astandard_rates . "</strong> <br> {$as_pp} <br> {$achild_s_pp} )";
								$agent_dp = "<br><strong class='aprice'> AP( " . $adeluxe_rates . "</strong> <br> {$ad_pp} <br> {$achild_d_pp} )";
								$agent_sdp = "<br><strong class='aprice'> AP( " . $asuper_deluxe_rates . "</strong> <br> {$asd_pp} <br> {$achild_sd_pp} )";
								$agent_lp = "<br><strong class='aprice'> AP( " . $arate_luxry . "</strong> <br> {$al_pp} <br> {$achild_l_pp} )";
							}
							
							$s_pp = isset( $per_person_ratemeta["standard_rates"] ) && !empty($per_person_ratemeta["standard_rates"]) ? "RS. " . number_format($per_person_ratemeta["standard_rates"]) . "/- Per Person" : "";
							$d_pp = isset( $per_person_ratemeta["deluxe_rates"] ) && !empty($per_person_ratemeta["deluxe_rates"]) ? "RS. " . number_format($per_person_ratemeta["deluxe_rates"]) . "/- Per Person" : "";
							$sd_pp = isset( $per_person_ratemeta["super_deluxe_rates"] ) && !empty($per_person_ratemeta["super_deluxe_rates"]) ? "RS. " . number_format($per_person_ratemeta["super_deluxe_rates"]) . "/- Per Person" : "";
							$l_pp = isset( $per_person_ratemeta["luxury_rates"] ) && !empty($per_person_ratemeta["luxury_rates"]) ? "RS. " . number_format($per_person_ratemeta["luxury_rates"]) . "/- Per Person" : "";
							
							//child rates
							$child_s_pp = isset( $per_person_ratemeta["child_standard_rates"] ) && !empty($per_person_ratemeta["child_standard_rates"]) ? "RS. " . $per_person_ratemeta["child_standard_rates"] . "/- Per Child" : "";
							$child_d_pp = isset( $per_person_ratemeta["child_deluxe_rates"] ) && !empty($per_person_ratemeta["child_deluxe_rates"]) ? "RS. " . $per_person_ratemeta["child_deluxe_rates"] . "/- Per Child" : "";
							$child_sd_pp = isset( $per_person_ratemeta["child_super_deluxe_rates"] ) && !empty($per_person_ratemeta["child_super_deluxe_rates"]) ? "RS. " . $per_person_ratemeta["child_super_deluxe_rates"] . "/- Per Child" : "";
							$child_l_pp = isset( $per_person_ratemeta["child_luxury_rates"] ) && !empty($per_person_ratemeta["child_luxury_rates"]) ? "RS. " . $per_person_ratemeta["child_luxury_rates"] . "/- Per Child" : "";
							
							$s_rates = isset( $rate_meta["standard_rates"] ) && !empty( $rate_meta["standard_rates"]) ? $rate_meta["standard_rates"] : 0;
							$d_rates = isset( $rate_meta["deluxe_rates"] ) && !empty( $rate_meta["deluxe_rates"]) ? $rate_meta["deluxe_rates"] : 0;
							$sd_rates = isset( $rate_meta["super_deluxe_rates"] ) && !empty( $rate_meta["super_deluxe_rates"]) ? $rate_meta["super_deluxe_rates"] : 0;
							$l_rates = isset( $rate_meta["luxury_rates"] ) && !empty( $rate_meta["luxury_rates"]) ? $rate_meta["luxury_rates"] : 0;
							
							$standard_rates = !empty( $s_rates ) ? number_format($s_rates) . "/- {$inc_gst}" : "--";
							$deluxe_rates = !empty( $d_rates ) ? number_format($d_rates) . "/- {$inc_gst}" : "--";
							$super_deluxe_rates = !empty( $sd_rates ) ? number_format($sd_rates) . "/- {$inc_gst}" : "--";
							$rate_luxry = !empty( $l_rates ) ? number_format($l_rates) . "/- {$inc_gst}" : "--";
							
							echo "<tr class='{$strike_class} {$strike_class_final} {$bbp_css}'><td>Price {$below_base_price} {$app}</td>
								<td>		
									<strong> BP( " . $standard_rates . "</strong> <br> {$s_pp} <br> {$child_s_pp} )
									{$agent_sp}
								</td>
								<td>
									<strong>BP( " . $deluxe_rates . "</strong> <br> {$d_pp}<br> {$child_d_pp} )
									{$agent_dp}
								</td>
								<td>
									<strong>BP( " . $super_deluxe_rates . "</strong> <br> {$sd_pp}<br> {$child_sd_pp} )
									{$agent_sdp}
								</td>
								<td>
									<strong>BP(  " . $rate_luxry . "</strong> <br> {$l_pp}<br> {$child_l_pp} )
									{$agent_lp}
								</td></tr>";
									
									if( !empty( $discountPriceData ) ){
										foreach( $discountPriceData as $price ){
											$agent_price_percentage = !empty($price->agent_price) ? $price->agent_price : 0;
											$app = !empty($price->agent_price) ? "(". $price->agent_price . "%)" : "";
											echo $app;
											$sent_status = $price->sent_status;
											//get per person price
											$per_person_ratemeta 	= unserialize($price->per_person_ratemeta);
											//$inc_gst = isset( $per_person_ratemeta["inc_gst"] ) && $per_person_ratemeta["inc_gst"] == 1 ? "(GST Inc.)" : "(GST Extra)";
											$inc_gst = "";
											
											$below_base_price = isset( $per_person_ratemeta["below_base_price"] ) && $per_person_ratemeta["below_base_price"] == 1 ? "(Below BP.)" : "";
											$bbp_css = isset( $per_person_ratemeta["below_base_price"] ) && $per_person_ratemeta["below_base_price"] == 1 ? "bbptr" : "";
											
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
												$ad_s_price = !empty( $price->standard_rates) ? number_format($price->standard_rates + $price->standard_rates * $agent_price_percentage/100 ) . "/- {$inc_gst} <br> {$ad_s_pp} <br> {$ad_child_s_pp}" : "<strong class='red'>On Request</strong>";
												
												$ad_d_price = !empty( $price->deluxe_rates) ? number_format($price->deluxe_rates + $price->deluxe_rates * $agent_price_percentage/100) . "/- {$inc_gst} <br> {$ad_d_pp} <br> {$ad_child_d_pp}" : "<strong class='red'>On Request</strong>";
												
												$ad_sd_price = !empty( $price->super_deluxe_rates) ? number_format($price->super_deluxe_rates + $price->super_deluxe_rates * $agent_price_percentage/100) . "/- {$inc_gst} <br> {$ad_sd_pp} <br> {$ad_child_sd_pp}"  : "<strong class='red'>On Request</strong>";
												
												$ad_l_price = !empty( $price->luxury_rates) ? number_format($price->luxury_rates + $price->luxury_rates * $agent_price_percentage/100) . "/- {$inc_gst} <br> {$ad_l_pp} <br> {$ad_child_l_pp}"  : "<strong class='red'>On Request</strong>";
												
												$agent_sp = "<br><strong class='aprice'> AP( " . $ad_s_price . "</strong>)";
												$agent_dp = "<br><strong class='aprice'>  AP( " . $ad_d_price . "</strong>)";
												$agent_sdp = "<br><strong class='aprice'> AP( " . $ad_sd_price . "</strong>)";
												$agent_lp = "<br><strong class='aprice'>  AP( " . $ad_l_price . "</strong>)";
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
											
											$s_price = !empty( $price->standard_rates) ? number_format($price->standard_rates) . "/- {$inc_gst} <br> {$s_pp} <br> {$child_s_pp}" : "<strong class='red'>N/A</strong>";
											$d_price = !empty( $price->deluxe_rates) ? number_format($price->deluxe_rates) . "/- {$inc_gst} <br> {$d_pp} <br> {$child_d_pp}" : "<strong class='red'>N/A</strong>";
											$sd_price = !empty( $price->super_deluxe_rates) ? number_format($price->super_deluxe_rates) . "/- {$inc_gst} <br> {$sd_pp} <br> {$child_sd_pp}"  : "<strong class='red'>N/A</strong>";
											$l_price = !empty( $price->luxury_rates) ? number_format($price->luxury_rates) . "/- {$inc_gst} <br> {$l_pp} <br> {$child_l_pp}"  : "<strong class='red'>N/A</strong>";
											
											$sr = isset( $price->standard_rates ) && !empty( $price->standard_rates ) ? $price->standard_rates : 0;
											$dr = isset( $price->deluxe_rates ) && !empty( $price->deluxe_rates ) ? $price->deluxe_rates : 0;
											$sdr = isset( $price->super_deluxe_rates ) && !empty( $price->super_deluxe_rates ) ? $price->super_deluxe_rates : 0;
											$lr = isset( $price->luxury_rates ) && !empty( $price->luxury_rates ) ? $price->luxury_rates : 0;
									
											//Calculate Total Cost
											$total_cost_after_dis = $sr + $dr + $sdr + $lr;
											
											$count_price = count( $discountPriceData );
											$strike_class = ($price !== end($discountPriceData) && $count_price > 1 ) ? "strikeLine" : "";
											//echo "<tr class='$strike_class'><td>Price</td><td><strong>" . $s_price . "</strong></td>";
											//echo "<td><strong>" . $d_price . "</strong></td>";
											//echo "<td><strong>" . $sd_price . "</strong></td>";
											//echo "<td><strong>" . $l_price . "</strong></td></tr>";
											echo "<tr class='{$strike_class} {$strike_class_final} {$bbp_css}'><td>Price {$below_base_price} {$app}</td>
											<td>BP( <strong>" . $s_price . "</strong>) {$agent_sp} </td>";
											echo "<td>BP(<strong>" . $d_price . "</strong>) {$agent_dp} </td>";
											echo "<td>BP(<strong>" . $sd_price . "</strong>) {$agent_sdp} </td>";
											echo "<td>BP(<strong>" . $l_price . "</strong>) {$agent_lp} </td></tr>";
										}
									}
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
					}
					?>
					</table>
					
				</div> <!--END PRINTABLE-->
					<div class="well well-sm"><h3>Notes:</h3></div>
					<ul>
					<?php $hotel_note_meta = unserialize($iti->hotel_note_meta); 
					$count_hotel_meta = count( $hotel_note_meta );
					
					if( !empty($hotel_note_meta) ){
						for ( $i = 0; $i < $count_hotel_meta; $i++ ) {
							echo "<li>" . $hotel_note_meta[$i]["hotel_note"] . "</li>";
						}	
					} ?>
					</ul>
					<hr>
					<div class="well well-sm"><h3>Inclusion & Exclusion</h3></div>
					<div class="table-responsive">
						<table class="table table-bordered">
							<thead class="thead-default">
								<tr class="thead-inverse">
									<th  width="50%"> Inclusion</th>
									<th  width="50%"> Exclusion</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$inclusion = unserialize($iti->inc_meta); 
								$count_inc = count( $inclusion );
								$exclusion = unserialize($iti->exc_meta); 
								$count_exc = count( $exclusion );
								echo "<tr><td><ul>";
								if( !empty($inclusion) ){
									for ( $i = 0; $i < $count_inc; $i++ ) {
										echo "<li>" . $inclusion[$i]["tour_inc"] . "</li>";
									}	
								}
								echo "</ul></td><td><ul>";
								if( !empty($exclusion) ){
									for ( $i = 0; $i < $count_exc; $i++ ) {
										echo "<li>" . $exclusion[$i]["tour_exc"] . "</li>";
									}	
								}
								echo "</ul></td></tr>";
								?>
							</tbody>
						</table>
					</div>	
					
					<hr>	
					<?php 
					//check if special inclusion exists
					$sp_inc = unserialize($iti->special_inc_meta); 
					$count_sp_inc = count( $sp_inc );
					
					if( !empty($sp_inc) ){
						echo '<div class="well well-sm"><h3>Special Inclusions</h3></div>';
						echo "   <ul class='inclusion'>";
						if( $count_sp_inc > 0 ){
							for ( $i = 0; $i < $count_sp_inc; $i++ ) {	
								echo "<li>" . $sp_inc[$i]["tour_special_inc"] . "</li>";
							}	
						}
						echo "</ul>";
					}
					?>		

					<?php 
					//check if benefits
					$benefits_m = unserialize($iti->booking_benefits_meta); 
					$count_bn_inc = count( $benefits_m );
					if( !empty($benefits_m) ){
						echo '<div class="well well-sm"><h3>Benefits of Booking With Us</h3></div>';
						echo "   <ul class='inclusion'>";
						if( $count_bn_inc > 0 ){
							for ( $i = 0; $i < $count_bn_inc; $i++ ) {	
								echo isset($benefits_m[$i]["benefit_inc"]) ? "<li>" . $benefits_m[$i]["benefit_inc"] . "</li>" : "";
							}	
						}
						echo "</ul>";
					}
					?>					
					
					<div class="well well-sm"><h3>Bank Details: Cash/Cheque at Bank or Net Transfer</h3></div>
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
					<?php
						//bank payment terms
						$count_bank_payment_terms	= count( $online_payment_terms ); 
						$count_bankTerms			= $count_bank_payment_terms-1; 
						if(isset($online_payment_terms["heading"]) ) { 
							echo "<div class='well well-sm'><h3>" . $online_payment_terms["heading"] . "</h3></div>"; 
						}
						if( $count_bankTerms > 0 ){
							echo "<ul class='client_listing'>";
								for ( $i = 0; $i < $count_bankTerms; $i++ ) { 
									echo "<li>" . $online_payment_terms[$i]["terms"] . "</li>";
								}
							echo "</ul>";
						}
							//how to book section
							$count_book_package	= count( $book_package_terms );
							if(isset($book_package_terms["heading"]) ) { 
								echo "<div class='well well-sm'><h3>". $book_package_terms["heading"]  ."</h3></div>";
							}
							if(isset($book_package_terms["sub_heading"]) ) { 
								echo "<h5>". $book_package_terms["sub_heading"]  ."</h5>";
							}							
							if( $count_book_package > 0 ){
								echo '<div class="table-responsive">
											<table class="table table-bordered tbl_policy_view">
												<thead class="thead-default">
													<tr>
														<th colspan=3> Booking Policy </th>
													</tr>
												</thead>
												<tbody>';
												$counter = 1;
									for ( $i = 0; $i < $count_book_package-2; $i++ ) { 
										$book_title = isset($book_package_terms[$i]["hotel_book_terms"]) ? $book_package_terms[$i]["hotel_book_terms"] : "";
										$book_val = isset($book_package_terms[$i]["hotel_book_terms_right"]) ? $book_package_terms[$i]["hotel_book_terms_right"] : "";
										echo "<tr>
											<td>" . $counter . "</td>
											<td>" . $book_title . "</td>
											<td>" . $book_val . "</td>
										</tr>";
										$counter++;
									}
								echo "</tbody></table></div>";
							}	
							
							// advance payment section 
							$count_ad_pay	= count( $advance_payment_terms );
							if(isset($advance_payment_terms["heading"]) ) { 
								echo "<div class='well well-sm'><h3>". $advance_payment_terms["heading"]  ."</h3></div>";
							}						
							if( $count_book_package > 0 ){
								echo "<ul class='client_listing'>";
									for ( $i = 0; $i < $count_ad_pay-1; $i++ ) { 
										echo "<li>" . $advance_payment_terms[$i]["terms"] . "</li>";
									}
								echo "</ul>";
							}
							
							//PAYMENT POLICY
							if(isset($payment_policy["heading"]) ) { 
								echo "<div class='well well-sm'><h3>". $payment_policy["heading"]  ."</h3></div>";
							}	
							$count_payment_policy	= count( $payment_policy );
							if( $count_payment_policy > 0 ){
								echo '<div class="table-responsive">
											<table class="table table-bordered tbl_policy_view">
												<thead class="thead-default">
													<tr>
														<th colspan=3> Payment Policy </th>
													</tr>
												</thead>
												<tbody>';
									$counter_pay = 1;
									for ( $i = 0; $i < $count_payment_policy-1; $i++ ) { 
										$book_title = isset($payment_policy[$i]["pay_policy"]) ? $payment_policy[$i]["pay_policy"] : "";
										$book_val = isset($payment_policy[$i]["pay_policy_right"]) ? $payment_policy[$i]["pay_policy_right"] : "";
										echo "<tr>
											<td>" . $counter_pay . "</td>
											<td>" . $book_title . "</td>
											<td>" . $book_val . "</td>
										</tr>";
										$counter_pay++;
									}
								echo "</tbody></table></div>";
							}								
							//end payment policy
							
							//AMENDMENT POLICY section	
							if(isset($amendment_policy["heading"]) ) { 
								echo "<div class='well well-sm'><h3>". $amendment_policy["heading"]  ."</h3></div>";
							}	
							$count_amendment_policy	= count( $amendment_policy );
							
							if( $count_amendment_policy > 0 ){
								echo '<div class="table-responsive">
											<table class="table table-bordered tbl_policy_view">
												<thead class="thead-default">
													<tr>
														<th colspan=3> Amendment Policy </th>
													</tr>
												</thead>
												<tbody>';
									$counter_a = 1;
									for ( $i = 0; $i < $count_amendment_policy-1; $i++ ) { 
										$book_title = isset($amendment_policy[$i]["amend_policy"]) ? $amendment_policy[$i]["amend_policy"] : "";
										$book_val = isset($amendment_policy[$i]["amend_policy_right"]) ? $amendment_policy[$i]["amend_policy_right"] : "";
										echo "<tr>
											<td>" . $counter_a . "</td>
											<td>" . $book_title . "</td>
											<td>" . $book_val . "</td>
										</tr>";
										$counter_a++;
									}
								echo "</tbody></table></div>";
							}
							
							//refund policy
							if(isset($amendment_policy["heading"]) ) { 
								echo "<div class='well well-sm'><h3>". $cancel_tour_by_client["heading"]  ."</h3></div>";
							}
							
							$count_cancel_content	= count( $cancel_tour_by_client );
							
							if( $count_cancel_content > 0 ){
								echo '<div class="table-responsive">
											<table class="table table-bordered tbl_policy_view">
												<thead class="thead-default">
													<tr>
														<th colspan=3> Cancellation and Refund Policy </th>
													</tr>
												</thead>
												<tbody>';
									$counter_ra = 1;
									for ( $i = 0; $i < $count_cancel_content-1; $i++ ) { 
										$book_title = isset($cancel_tour_by_client[$i]["cancel_terms"]) ? $cancel_tour_by_client[$i]["cancel_terms"] : "";
										$book_val = isset($cancel_tour_by_client[$i]["cancel_terms_right"]) ? $cancel_tour_by_client[$i]["cancel_terms_right"] : "";
										echo "<tr>
											<td>" . $counter_ra . "</td>
											<td>" . $book_title . "</td>
											<td>" . $book_val . "</td>
										</tr>";
										$counter_ra++;
									}
								echo "</tbody></table></div>";
							}
							
							//terms and condition
							if(isset($terms_condition["heading"]) ) { 
								echo "<div class='well well-sm'><h3>". $terms_condition["heading"]  ."</h3></div>";
							}
							$count_cancel_content	= count( $terms_condition );
							if( $count_cancel_content > 0 ){
								echo "<ul class='client_listing'>";
									for ( $i = 0; $i < $count_cancel_content-1; $i++ ) { 
										echo "<li>" . $terms_condition[$i]["terms"] . "</li>";
									}
								echo "</ul>";
							}
						?>	
						<hr>
						
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
						<!--if amendment is done show old itinerary-->
						<?php if( !empty( $old_itineraries ) && $iti->is_amendment != 0 ){  ?>
							<p class="text-center">
							<?php $old_count = 1;
							foreach( $old_itineraries as $old_iti ){ ?>
								<a title='View Old Quotation' target="_blank" href=" <?php echo site_url("itineraries/view_old_iti/{$old_iti->id}") ; ?> " class='btn btn-danger' ><i class='fa fa-eye' aria-hidden='true'></i> View Old Quotation <?php echo $old_count; ?></a>
							<?php $old_count++; } ?>
							</p>
						<?php } ?>
					
					<hr>
					<!--Request manager to add price to itinerary get_iti_booking_status == rejected iti-->
					<?php if( $user_role == 96 && ($iti->pending_price == "1" || $iti->pending_price == "4" || $iti->pending_price == "5" ) ){ ?>
						<p class="text-center"><strong class="alert alert-info">Waiting for price update from manager..</strong></p>
					<?php }else if( $user_role == 96 && ( $iti->pending_price == "0" || (  $iti->iti_status == 6 && get_iti_booking_status( $iti->	iti_id ) == 3 )  ) ) { ?>
						<p class="text-center">
							<!--a class="btn btn-success" data-iti_id="<?php echo $iti->iti_id; ?>" data-temp_key="<?php echo $iti->temp_key; ?>" href="#" data-agent_id="<?php echo $iti->agent_id; ?>" id="send_price_request" title="Sent Price request for manager">Sent Price Request To Manager</a-->
							
							<a class="btn btn-success" data-iti_id="<?php echo $iti->iti_id; ?>" data-temp_key="<?php echo $iti->temp_key; ?>" href="#" data-agent_id="<?php echo $iti->agent_id; ?>" id="send_price_request" title="Sent Price request for manager">Sent Price Request To Manager</a>
							<div class="modal fade" id="price_req_modal" role="dialog">
								<div class="modal-dialog modal-lg2">
								  <div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal">&times;</button>
										<h4 class="modal-title">Request For Update Price</h4>
									</div>
									<div class="modal-body">
										<form id="frm_price_req_modal">
											<div class="form-group">
												<div class="radio">
												  <label><input type="radio" class='' required name="send_request_to" value='1'>Request To Manager</label>
												</div>
												
												<div class="radio">
												  <label><input type="radio" class='' required name="send_request_to" value='2'>Request To Teamleader</label>
												</div>

											</div>
											<input type="hidden" name="iti_id" value="<?php echo $iti->iti_id; ?>">
											<input type="hidden" name="temp_key" value="<?php echo $iti->temp_key; ?>">
											<input type="hidden" name="agent_id" value="<?php echo $iti->agent_id; ?>">
											<button type="submit" id="reqDis_btnd" class="btn btn-default">Send</button>
											<div id="fpriceRes"></div>
										</form>
									</div>
									<div class="modal-footer">
									  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
									</div>
								  </div>
								</div>
							</div>
						</p>
						<div id="price_req"></div>
					<?php } ?>
					<!--End Request manager to add price to itinerary -->
					<!--Sent Accommodation To Customer-->
					<?php if( is_admin_or_manager_or_sales() && $iti->publish_status == "publish" ) { ?>
						<div class="form-group col-md-12">
							<input type="hidden" name="iti_id" value="<?php echo $iti->iti_id; ?>" id="iti_send_id">
							<input type="hidden" name="temp_key" value="<?php echo $iti->temp_key; ?>" id="iti_send_key">
							
							<a href="<?php echo site_url("itineraries"); ?>" class="btn green uppercase iti_back" title="Back">Back</a>
							<!--Edit itinerary button if iti_status is zero-->
							
							<?php if( ( $iti->iti_status == 0 || $iti->iti_status == 6 ) && is_admin_or_manager_or_sales() ){ ?>
								<a title='Edit' href=" <?php echo site_url("itineraries/edit/{$iti->iti_id}/{$iti->temp_key}") ; ?> " class='btn btn-success' ><i class='fa fa-pencil' aria-hidden='true'></i></a>
							<?php } ?>
							
							<!-- Request For Update Price -->
							<?php if( is_admin_or_manager_or_sales() && !empty( $get_rate_meta ) && $iti->email_count > 0 && $iti->discount_rate_request == 0 && $iti->iti_status == 0 && $countPrice < 6 ){   ?>
							<?php /* if( $iti->discount_rate_request == 0 && $iti->pending_price != 0 && $iti->iti_status == 0 && $countPrice < 6 ){   */ ?>
								<span class="btn btn-green reqPrice_update" title="Request For Update Price">Request Manager To Update Price</span>
								<!-- Modal Discount Price itinerary-->
									<!-- The Modal -->
									<div class="modal fade" id="update_priceModal" role="dialog">
										<div class="modal-dialog modal-lg2">
										  <div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal">&times;</button>
												<h4 class="modal-title">Request for discount price</h4>
											</div>
											<?php 
											//add required if category exists
											$st_req = empty( $is_standard ) ? "disabled='disabled'" : "checked='checked'";
											$d_req 	= empty( $is_deluxe ) 	? "disabled='disabled'" : "checked='checked'";
											$sd_req = empty( $is_s_deluxe ) ? "disabled='disabled'" : "checked='checked'";
											$l_req 	= empty( $is_luxury ) 	? "disabled='disabled'" : "checked='checked'";
											?>
											<div class="modal-body">
												<form id="reqPriceForm">
													<div class="form-group">
														<div class="checkbox" style="display: none;">
															<label for="email">Please Select Hotel Category for price discount</label><br>
															 
															<label><input <?php echo $st_req; ?> name="hotel_cat_dis[]" required type="checkbox" value="Standard"> <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span><strong>Deluxe</strong></label><br>
															<label><input <?php echo $d_req; ?> name="hotel_cat_dis[]" required type="checkbox" value="Deluxe"> <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span><strong>Super Deluxe</strong></label><br>
															<label><input <?php echo $sd_req; ?> name="hotel_cat_dis[]" required type="checkbox" value="Super Deluxe"> <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span><strong>Luxury</strong></label><br>
															<label><input <?php echo $l_req; ?> type="checkbox" required name="hotel_cat_dis[]" value="Luxury"> <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span><strong>Super Luxury</strong></label>
														</div>
													</div>
													
													<div class="form-group">
														<label for="ce"><strong>Request To : </strong></label><br>
														<div class="radio">
														  <label><input type="radio" class='' required name="send_request_to" value='1'>Request To Manager</label>
														</div>
													
														<div class="radio">
														  <label><input type="radio" class='' required name="send_request_to" value='2'>Request To Teamleader</label>
														</div>
													</div>
													
													<input type="hidden" name="iti_id" value="<?php echo $iti->iti_id; ?>">
													<input type="hidden" name="temp_key" value="<?php echo $iti->temp_key; ?>">
													<input type="hidden" name="agent_id" value="<?php echo $iti->agent_id; ?>">
													<button type="submit" id="reqDis_btn" class="btn btn-default green">Sent Request</button>
													<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
													<div id="priceRes"></div>
												</form>
											</div>
											<div class="modal-footer">
											</div>
										  </div>
										</div>
									</div>
							<?php  }else if( ($iti->discount_rate_request == 1 || $iti->discount_rate_request == 3 ) && $user_role == 96  ){
								echo "<div class='alert alert-info text-center red'><td  colspan=5 class='red'>Awaiting price discount from manager.</td></div>";  
							}else if( $iti->discount_rate_request == 2 ){
								echo "<div class='alert alert-info text-center red'><td  colspan=5 class='red'>Awaiting discount price approval from Super Manager.</td></div>";
							} ?>
							<!-- End Request For Update Price -->
							<!--Sent Accommodation section -->
							<?php  
							$iti_sent_counter = $iti->email_count;
								/*if( $iti->iti_status == 0 && $iti->pending_price == 2 ){  ?>
									<?php echo "<div class=' btn btn-info pull-right'>Accommodation Sent " . $iti_sent_counter . " Times.</div>"; ?>
									<a href="#" class="btn green uppercase pull-right" id="iti_send">Send</a>
									<!-- Modal sent Accommodation-->
									<div class="modal fade" id="sendItiModal" role="dialog">
										<div class="modal-dialog modal-lg">
										  <div class="modal-content">
											<div class="modal-header">
											  <button type="button" class="close" data-dismiss="modal">&times;</button>
											  <h4 class="modal-title">Send Accommodation Quotation</h4>
											</div>
											<div class="modal-body">
												<form id="sentItiForm">
													<div class="form-group">
													  <label for="email">Customer Email:</label>
													  <input required type="email" readonly value="<?php echo $customer_email; ?>" class="form-control" id="email" placeholder="Enter customer email" name="cus_email">
													</div>
													<!--CC Email Address-->
													<div class="form-group">
													  <label for="cc_email">CC Email:</label>
													  <input type="text" value="" class="form-control" id="cc_email" placeholder="Enter CC Email.eg. admin@Trackitinerary.org" name="cc_email">
													</div>
													<!--BCC Email Address-->
													<div class="form-group">
													  <label for="bcc_email">BCC Email:</label>
													  <input type="text" value="" class="form-control" id="bcc_email" placeholder="Enter BCC email eg. manager@Trackitinerary.org" name="bcc_email">
													</div>
													<div class="form-group">
													  <label for="sub">Subject:</label>
													  <input type="text" required class="form-control" id="sub" placeholder="Final confirmation Mail" name="subject" value="" >
													</div>
													<div class="form-group">
														<label for="pwd">Contact Number:</label>
														<input type="text" readonly value="<?php echo $customer_contact; ?>" class="form-control" id="pwd" placeholder="Enter Contact Number" name="contact_number">
													</div>
													<div class="form-group">
														<label for="cn">Additional Contact Number:</label>
														<input type="text" value="" class="form-control" id="cn" placeholder="Enter Contact Number(Admin/Manager).Not Required" name="add_contact_number">
													</div>
													<input type="hidden" name="iti_id" value="<?php echo $iti->iti_id; ?>">
													<input type="hidden" name="temp_key" value="<?php echo $iti->temp_key; ?>">
													<button type="submit" id="sentIti_btn" class="btn btn-default">Submit</button>
													<div id="mailSentResponse" class="sam_res"></div>
												</form>
											</div>
											<div class="modal-footer">
											  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
											</div>
										  </div>
										</div>
									</div>
								<?php } */ ?>
								
								<?php echo "<div class=' btn btn-info pull-right'>Quotation Sent " . $iti_sent_counter . " Times.</div>"; ?>
								<?php if( $iti->iti_status == 0 && $iti->pending_price == 2 ){  ?>
									<a href="#" class="btn green uppercase pull-right" id="iti_send">Send</a>
									<!-- Modal sent Accommodation-->
									<div class="modal fade" id="sendItiModal" role="dialog">
										<div class="modal-dialog modal-lg">
										  <div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal">&times;</button>
												<h4 class="modal-title">Send Accommodation Quotation</h4>
											</div>
											<div class="modal-body">
												<form id="sentItiForm">
													<div class="frm_section">
														<!--loader-->
														<div class = "spinner_load"  style = "display: none;">
															<i class="fa fa-refresh fa-spin fa-3x fa-fw" ></i>
															<span class="sr-only">Loading...</span>
														</div><!--end loader-->
														
														<div class="form-group">
														  <label for="email">Customer Email:</label>
														  <input required type="email" readonly value="<?php echo $customer_email; ?>" class="form-control" id="email" placeholder="Enter customer email" name="cus_email">
														</div>
														
														<div class="form-group">
															<label for="sub">Subject:</label>
															<input type="text" required class="form-control" id="sub" placeholder="Final confirmation Mail" name="subject" value="" >
														</div>
														
														<div class="clearfix"></div>
														<!--CC Email Address-->
														<div class="form-group col-md-6">
															<label for="cc_email">CC Email:</label>
															<input type="text" value="" class="form-control" id="cc_email" placeholder="Enter CC Email.eg. admin@Trackitinerary.org" name="cc_email">
														</div>
														
														<!--BCC Email Address-->
														<div class="form-group col-md-6">
															<label for="bcc_email">BCC Email:</label>
															<input type="text" value="" class="form-control" id="bcc_email" placeholder="Enter BCC email eg. manager@Trackitinerary.org" name="bcc_email">
														</div>
														<div class="clearfix"></div>
														<div class="form-group col-md-6">
															<label for="pwd">Contact Number:</label>
															<input type="text" readonly value="<?php echo $customer_contact; ?>" class="form-control" id="pwd" placeholder="Enter Contact Number" name="contact_number">
														</div>
														<div class="form-group col-md-6">
															<label for="cn">Additional Contact Number:</label>
															<input type="text" value="" class="form-control" id="cn" placeholder="Enter Contact Number(Admin/Manager).Not Required" name="add_contact_number">
														</div>
													
														<div class="clearfix"></div>
															<div class="col-md-6">
																<label for="inp_inc_price">Rate Comment*:</label>
																<textarea required class="form-control" name="rate_comment" ><?php echo isset($iti->rate_comment) ? $iti->rate_comment : ""; ?></textarea>
															</div>
															
															<!--div class="clearfix"></div-->
															<?php
																$dis_arr = isset($discountPriceData) && !empty($discountPriceData) ? end($discountPriceData) : array();
																$old_per = isset($dis_arr->agent_price) ? $dis_arr->agent_price : $iti->agent_price;
															?>
															
															<!--hide if discount data exists-->
															<?php if( empty($dis_arr) && $iti->iti_package_type !== "Fixed Departure" ){ 
															/*
															?>
																	<div class="col-md-6">
																		<label for="inp_inc_price">Add Margin In Base Price (%):</label>
																		<select name="inp_inc_price" id="inp_inc_price" class="form-control" data-old_percentage="<?php echo !empty($old_per) ? $old_per : 0; ?>" required  name="agnem" >
																			<!--option value="0">No Margin</option-->
																			<option value="">Select Margin</option>
																			<?php for($bp = 2 ; $bp<=20 ; $bp++ ){
																				echo "<option value={$bp}>{$bp}%</option>";
																			} ?>
																		</select>
																	</div>	
																	*/ ?>
																	<?php /* ?>
																	<div class="form-group col-md-12">
																	<label for="incPriceByAgent">Add Margin In Base Price
																		<input type='checkbox' id='incPriceByAgent' required name="chkmarg" class='form-control'>
																	</label>
																	<div class="clearfix"></div>
																	<div class="showonPchange">
																		<div class="col-md-6">
																			<label for="inp_inc_price">Increase Price (%):</label>
																			<select name="inp_inc_price" id="inp_inc_price" class="form-control" data-old_percentage="<?php echo !empty($old_per) ? $old_per : 0; ?>" >
																				<!--option value="0">No Margin</option-->
																				<?php for($bp = 10 ; $bp<=100 ; $bp++ ){
																					echo "<option value={$bp}>{$bp}%</option>";
																				} ?>
																			</select>
																		</div>	
																	</div>
																	</div>
																	*/ ?>
															<?php } ?>
															<div class="table-responsive showonPchange1 col-md-12" id='a_price_table'>
																<table class="table table-striped table-hover">
																	<thead class="thead-default">
																		<tr> <p class="text-center"><strong style="color: red; font-size: 22px;">Price</strong></p> </tr>
																		<tr>
																			<th> Deluxe</th>
																			<th> Super Deluxe</th>
																			<th> Luxury</th>
																			<th> Super Luxury</th>
																			<th> Agent Margin (%) </th>
																		</tr>
																	</thead>
																	<tbody>
																		<?php if( isset( $dis_arr ) && !empty($dis_arr) ){ ?>
																			<?php $inc_in = $dis_arr->id; 
																				//update itinerary_discount_price_data table ?>
																				<tr>
																					<td><?php echo !empty($dis_arr->standard_rates) ? "<strong class='s_base_price'>" . $dis_arr->standard_rates . "/-</strong>" : '--'; ?></td>
																					<td><?php echo !empty($dis_arr->deluxe_rates) ? "<strong class='d_base_price'>" . $dis_arr->deluxe_rates . "/-</strong>" : '--'; ?></td>
																					<td><?php echo !empty($dis_arr->super_deluxe_rates) ? "<strong class='sd_base_price'>" . $dis_arr->super_deluxe_rates . "/-</strong>" : '--'; ?></td>
																					<td><?php echo !empty($dis_arr->luxury_rates) ? "<strong class='l_base_price'>" . $dis_arr->luxury_rates . "/-</strong>" : '--'; ?></td>
																					<td> <?php echo $dis_arr->agent_price; ?>%</td>
																				</tr>
																		<?php }else{ ?>
																			<?php $inc_in = 0; // update iti table ?>
																			<tr>
																				<td><?php echo isset( $get_rate_meta["standard_rates"] ) && !empty($get_rate_meta["standard_rates"]) ?  "<strong class='s_base_price'>" . $get_rate_meta["standard_rates"] . "/-</strong>" : '--'; ?> </td>
																				<td><?php echo isset( $get_rate_meta["deluxe_rates"] ) ? "<strong class='d_base_price'>" . $get_rate_meta["deluxe_rates"] . "/-</strong>" : '--'; ?></td>
																				<td><?php echo isset($get_rate_meta["super_deluxe_rates"]) ? "<strong class='sd_base_price'>" . $get_rate_meta["super_deluxe_rates"] . "/-</strong>" : '--'; ?></td>
																				<td><?php echo isset( $get_rate_meta["luxury_rates"] ) ? "<strong class='l_base_price'>" . $get_rate_meta["luxury_rates"] . "/-</strong>" : '--'; ?></td>
																				<td> <?php echo $iti->agent_price; ?>%</td>
																			</tr>
																		<?php } ?>	
																		<tr class="new_pricesend2">
																			<td><strong class='ns_base_price empty_this'></strong></td>
																			<td><strong class='nd_base_price empty_this'></strong></td>
																			<td><strong class='nsd_base_price empty_this'></strong></td>
																			<td><strong class='nl_base_price empty_this'></strong></td>
																			<td><strong class="newPer empty_this"></strong> </td>
																		</tr>
																	</tbody>
																</table>
														</div>
														
														<div class="clearfix"></div>
													</div>	
													<hr>
													<input type="hidden" id="inp_inc_priceText" value="<?php echo !empty($old_per) ? $old_per : 0; ?>" name="inp_inc_price" >
													<input type="hidden" name="price_update_in" value="<?php echo $inc_in; ?>">
													<input type="hidden" name="iti_id" value="<?php echo $iti->iti_id; ?>">
													<input type="hidden" name="temp_key" value="<?php echo $iti->temp_key; ?>">
													<button type="submit" id="sentIti_btn" class="btn btn-success">Send Itinerary</button>
													<div id="mailSentResponse" class="sam_res"></div>
												</form>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
											</div>
										  </div>
										</div>
									</div>
								<?php } ?>
						</div>
					<?php } ?>	
					<div class="clearfix"></div>
					<!--Comments Section -->
					<div id="UpdatePanel1">
					  <div class="modal-body">
					  <?php if( $iti->iti_status == 0 && $iti->email_count > 0 && $iti->publish_status == "publish" && is_salesteam() ){ ?>
						<div class="contactForm">
							<form id="confirmForm">
								<h3>Enter Your Comment For Client</h3>
								<div class="form-group feedback">
									<textarea required placeholder="Please Enter comment here...." rows="4" cols="20" name="client_comment" class="form-control client_textarea"/></textarea> 
								</div>
								<input type="hidden" name="iti_id" value="<?php echo $iti->iti_id; ?>">
								<input type="hidden" name="temp_key" value="<?php echo $iti->temp_key; ?>">
								<input type="hidden" name="sec_key" id="sec_key" value="<?php echo $sec_key; ?>">
								<input type="hidden" name="agent_id" id="agent_id" value="<?php echo $iti->agent_id; ?>">
								<input type="hidden" name="customer_id" id="customer_id" value="<?php echo $iti->customer_id; ?>">
								<div class="form-group col-md-12 row">
									<button id="LinkButton1" type="submit" class="btn green uppercase app_iti">Submit</button>
								</div>
								<div class="clearfix"></div>
								<div class="response"></div>
							</form>	
					  </div>	<?php } ?>
						<!--comments section-->
						<div id="comments">
						<?php if( !empty( $comments ) ){ ?>
							<div class="old-comments">
								<?php foreach( $comments as $comment ){ ?>
									<div class="single_comment"> 
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
	<!-- END CONTENT BODY -->
</div>
<!-- Modal -->
<!--FIRE WORK IF Itinerary Booked -->
<?php if( isset( $_GET['firework'] ) && !empty($_GET['firework']) ){
	//Get agent full name
	$agent_fullName =  isset($user_full_name) ? $user_full_name : get_user_name($user_id); ?>
	<div class="fix_cong_section"></div>
	<div class="congo_text">
		<div class="canvas_text showMe">
			<p class="text-congrat">Congratulations</p>
			<h3 class="agent_name"><?php echo ucfirst($agent_fullName); ?></h3>
		</div>
	</div>
	<script src="<?php echo base_url();?>site/assets/js/jquery.fireworks.js" type="text/javascript"></script>
	<script>
		setTimeout( '$(".congo_text, .fix_cong_section ").remove()', 10000 );
		$('.congo_text').fireworks({
			sound: false,
			opacity: 0.6, 
			width: '100%',
			height: '100%'
		});
	</script>
<?php  } ?>
<!--END FIRE WORK IF Itinerary Booked -->
<!-- Booking Payment Script -->
<script type="text/javascript">
jQuery(document).ready(function($){
	
	//show booking section
	$(document).on("change", ".discount_type", function(e){
		e.preventDefault();
		var _this_val = $(this).val();
		if( _this_val == "reduce_margin" ){
			$(".update_margin_discount").show();
			$(".update_price_customprice").hide();
		}else{
			$(".update_price_customprice").show();
			$(".update_margin_discount").hide();
		}
	});
	
	//checkbox change
	$('#incPriceByAgent').change(function(){
		var old_per = $("#inp_inc_price").attr("data-old_percentage");
        if( $(this).is(':checked') ){
           // Do something...
		   $(".showonPchange").show();
        }else{	
			$("#inp_inc_price").val(old_per);
			$("#inp_inc_priceText").val(old_per);
			$(".showonPchange").hide();
			$(".empty_this").text("");
		}   
	});
	
	//new_pricesend
	$('#inp_inc_price').change(function(){
		var s_base_price 	= 	parseInt($(".s_base_price").text());
		var d_base_price 	= 	parseInt($(".d_base_price").text());
		var sd_base_price 	= 	parseInt($(".sd_base_price").text());
		var l_base_price 	= 	parseInt($(".l_base_price").text());
		var selectPer 		= $("#inp_inc_price option:selected").val();
		if ( parseInt(selectPer) >= 0 ){
			$("#inp_inc_priceText").val(selectPer);
			$(".newPer").text(selectPer + "%");
			$(".new_pricesend").show();
			var percentage = parseInt($(this).val());
			
			//inc standard
			if( s_base_price > 0 ){
				var add_per = s_base_price * percentage / 100;
				var nsub = add_per+s_base_price;
				$(".ns_base_price").html( "NP: " + nsub );
			}
			
			//inc nsd_base_price
			if( d_base_price > 0 ){
				var add_per = d_base_price * percentage / 100;
				var nsub = add_per+d_base_price;
				$(".nd_base_price").html( "NP: " + nsub );
			}
			
			//inc sd_base_price
			if( sd_base_price > 0 ){
				var add_per = sd_base_price * percentage / 100;
				var nsub = add_per+sd_base_price;
				$(".nsd_base_price").html( "NP: " + nsub );
			}
			
			//inc l_base_price
			if( l_base_price > 0 ){
				var add_per = l_base_price * percentage / 100;
				var nsub = add_per+l_base_price;
				$(".nl_base_price").html( "NP: " + nsub );
			}
		}else{
			var old_per = $("#inp_inc_price").attr("data-old_percentage");
			$("#inp_inc_priceText").val(old_per);
		} 
	});
	//delete client docs
	$(".del_client_docs").click(function(e){
		var _doc_id = $(this).attr("data-id");
		var _this = $(this);
		if( _doc_id > 0 ) {
			swal({
				buttons: {
					cancel: true,
					confirm: true,
				},
				title: "Are you sure?",
				text: "You will not be able to recover this document!",
				icon: "warning",
				confirmButtonClass: "btn-danger",
				confirmButton: "Yes, delete it!",
				cancelButton: "No, cancel!",
				closeModal: false,
			}).then((willDelete) => {
				if (willDelete) {
					$.ajax({
						url: "<?=site_url('itineraries/delete_docs')?>",
						type: "POST",
						data: {id: _doc_id},
						dataType: "json",
						success: function(res) {
							console.log(res);
							if(res.status == true ) {
								swal("Deleted!", "Document has been deleted.", "success");
								_this.parents('tr').remove();
							} else {
								swal("Error!", "Something went wrong!", "danger");
							}
						},
						error: function(err) {
							swal("Error!", "Something went wrong2!", "danger");
						}
					});
				}
			});
		} else {
			_this.parents('tr').remove();
		}
	});	
	//add_other_docs_btn
	$("#add_other_docs_btn").click(function(e){
		e.preventDefault();
		//console.log("click");
		var totalLength = $('div.other_docs_sec:visible').length;
		if( totalLength == 0 ){ 
			$(".other_docs_sec").show();
		}else if( totalLength >= 5 ){
			swal("Warning!", "You can add only five documents!", "warning");
		}else{	
			copyConfig = $('div.other_docs_sec:last').clone();
			copyConfig.find('input').prop('value','');
			//copyConfig.find('input[name^=iti_clients_docs]').attr('name','iti_clients_docs['+(parseInt(totalLength))+'][]');
			$('div.other_docs_sec:last').after(copyConfig);
		}	
	});
	
	//delete upload
	$(document).on('click','.del_upload', function(e) {
		e.preventDefault();
		var totalLength = $('div.other_docs_sec').length;
		console.log(totalLength);
		if(totalLength == 1) {
			$(this).parents('div.other_docs_sec').find("input").val("");
			$(this).parents('div.other_docs_sec').hide();
			return false;
		}
		$(this).parents('div.other_docs_sec').remove();
	});
	$("#frm_update_booking_status_agent").validate();
		$(document).on("submit",'#frm_update_booking_status_agent', function(event){
			event.preventDefault();
			var loader = $(".spinner_load");
			var resp = $(".response");
			$("#submit_frm").attr("disabled", "disabled");
			var formData =  new FormData(this);
			formData.append("client_aadhar_card", $('#client_aadhar_card')[0].files[0]);
			formData.append("payment_screenshot", $('#payment_screenshot')[0].files[0]);
			var ajaxReq;
			
			if (ajaxReq) {
				ajaxReq.abort();
			}
			ajaxReq = $.ajax({
			type: "POST",
			url: "<?php echo base_url('itineraries/update_reject_iti_booking_agent'); ?>" ,
			dataType: 'json',
			data: formData,
			cache: false,
			contentType: false,
			processData: false,
			beforeSend: function(){
				loader.show();
				resp.html('<div class="alert alert-success"><i class="fa fa-spinner fa-spin"></i> Please wait...</div>');
			},
			success: function(res) {
				loader.hide();
				if (res.status == true){
					$("#frm_update_booking_status_agent")[0].reset();
					resp.html('<div class="alert alert-success"><strong>Success! </strong>'+res.msg+'</div>');
					location.reload(); 
				}else{
					resp.html('<div class="alert alert-danger"><strong>Error! </strong>'+res.msg+'</div>');
					$("#submit_frm").removeAttr("disabled");
				}
			},
			error: function(e){
				loader.hide();
				$("#submit_frm").removeAttr("disabled");
				resp.html('<div class="alert alert-danger"><strong>Error! </strong>Please reload page and try again.</div>');
				//console.log(e);
			}
		});
		//return false;
	});	
	
	/* On Final Amount blur */
	$('#fnl_amount').keypress(function(e){ 
		$("#tx").prop('checked',false);
		if (this.value.length == 0 && e.which == 48 ){
		  return false;
		}
	});
	
	$(document).on("change", "#tx", function(){
		$("#due_payment_section").find('input').val('');
		$("#balance_pay").val("");
		$("#pack_advance_recieve").val("");
		
		if($("#tx").prop('checked') == true){
			//Calculate tax
			var sub = 0;
			var rate = parseInt($('#fnl_amount').val());
			var tax_rate = parseInt($('#fnl_amount').attr("data-tax"));
			var tax_amount = rate * tax_rate / 100;
			sub = rate+tax_amount;
			var amount_after_tax = Math.round(sub);
			$("#fnl_amount_tax").val( amount_after_tax );
			//console.log('true');
			
			var sub =  $("#fnl_amount_tax").val();
			var amount_after_tax = Math.round(sub);
			
			var advance			= parseFloat($("#inp_advance_recieved").val());
			var calTotalBal  = (amount_after_tax - advance).toFixed(0);
			$("#balance_pay").val(calTotalBal);
			
			//calculate 50% of total amount after tax
			//var calcFiftyPercentage  = (amount_after_tax - ( amount_after_tax * 50 / 100 )).toFixed(0);
			//$("#fiftyPer").text("Fifty Percentage: " + calcFiftyPercentage);
	
		}else{
			//console.log('false');
			$("#fnl_amount_tax").val($('#fnl_amount').val());
			var sub =  $("#fnl_amount_tax").val();
			var advance			= parseFloat($("#inp_advance_recieved").val());
			var calTotalBal  = (sub - advance).toFixed(0);
			$("#balance_pay").val(calTotalBal);
			//var amount_after_tax = Math.round(sub);
			//calculate 50% of total amount after tax
			//var calcFiftyPercentage  = (amount_after_tax - ( amount_after_tax * 50 / 100 )).toFixed(0);
			//$("#fiftyPer").text("Fifty Percentage: " + calcFiftyPercentage);
		}
	});
	//Empty date picker if second installment empty
	$(".date_picker_validation").each(function(){
		$(this).click(function(e){
			e.preventDefault();
			var nextPayDate = $("#next_payment_date").datepicker("getDate");
			//console.log( "nextPayDate " + nextPayDate );
			if( nextPayDate == null ){
				alert("Please Enter Second Installment Date First");
				//$(this).val("");
				$(".date_picker_validation").datepicker("hide");
				$('#next_payment_date').focus();
				return false;
			}
		});
	});
	
	//Set Min Date 
	var Ad_pay = $("#pack_advance_recieve").val(), fifPer = $("#fiftyPer").val();
	//var end_date = Ad_pay >= fifPer ? "+30d" : "+10d";
	$('#next_payment_date').datepicker({
        format: "yyyy-mm-dd",
		startDate: "now",
	//	endDate: end_date
    }).on('changeDate', function(ev){
		$('.date_picker_validation').val("");
		var _thisDate = ev.date;
		var nextDayMin = moment(_thisDate).add(1, 'day').toDate();
		$('.date_picker_validation').datepicker('setStartDate', nextDayMin);
	});
	
	$('#third_payment_date').datepicker({
        format: "yyyy-mm-dd",
    }).on('changeDate', function(ev){
		$('#final_payment_date').val("");
		var _thisDate = ev.date;
		var nextDayMin = moment(_thisDate).add(1, 'day').toDate();
		$('#final_payment_date').datepicker('setStartDate', nextDayMin);
	});
	
	
	$(document).on("click", ".date_picker", function(){
		$(this).datepicker({startDate: "now", todayHighlight: true, todayHighlight: true}).datepicker('show');
	}); 
	
	//$(".date_picker").datepicker({startDate: "now", todayHighlight: true});
	$(".transaction_date").datepicker({startDate: "-10d", todayHighlight: true});
	$("#booking_date").datepicker({startDate: "-10d", todayHighlight: true});
	
	
	
	//Prevent Dot from number field
	$("input[type='number']").on('keyup keypress', function(e) {
		var keyCode = e.keyCode || e.which;
		if( keyCode == 8 ) return true;
		if( this.value.length==8 ) return false;
		
		if ( keyCode != 8 ) {
            if (keyCode < 48 || keyCode > 57) {
				return false;
			}else {
                return true;
            }
        }else {
            return true;
        }
		
	});
	/* On Final Amount blur next_pay_balance */
	$('#fnl_amount').keypress(function(e){ 
	   if (this.value.length == 0 && e.which == 48 ){
		  return false;
	   }
	});
	
	$(document).on("change", "#appCatList", function(){
		//if ($(this).attr("readonly")) return false;
		var selected_category_price = $("#appCatList option:selected").attr("data-price");
		
		//Empty field
		$("#fnl_amount_tax").val('');
		$("#due_payment_section").find('input').val('');
		$("#due_payment_section").find('.date_picker').datepicker('clearDates');
		$("#due_payment_section").find('input').removeAttr('required');
		
		if( !selected_category_price ){
			$("#next_pay_balance, #third_payment_bal").attr("readonly", "readonly");
		}else{
			$("#next_pay_balance").removeAttr("readonly");
		}	
		
		var cat_price = parseFloat( selected_category_price );
		if( cat_price < 0 || $.isNumeric( cat_price ) == false ){
			$(".resPonse").html('<div class="alert alert-danger"><strong>Error! </strong>Please enter positive Final Amount value</div>');
			return false;
		}else{
			$(".resPonse").html("");
		}
		
		$("#fnl_amount_tax").val( cat_price );
		var sub =  $("#fnl_amount_tax").val();
		var amount_after_tax = Math.round(sub);
		
		//calculate 50% of total amount after tax
		var calcFiftyPercentage  = (amount_after_tax - ( amount_after_tax * 50 / 100 )).toFixed(0);
		$("#fiftyPer").text("Fifty Percentage: " + calcFiftyPercentage);
		$("#balance_pay").val("");
		$("#pack_advance_recieve").val("");
	});
	
	/* On Next payment blur */
	$(document).on("blur", "#next_pay_balance", function(){
		if ($(this).attr("readonly")) return false;
		
		$("#final_payment_bal, #third_payment_bal").val("");
		$("#final_payment_date").removeAttr("required");
		$(".date_picker_validation").datepicker("clearDates");
		var _this = $(this);
		var _this_val		= parseFloat($(this).val());
		var total_cost		= $("#fnl_amount_tax").val();
		//var total_cost		= $("#fnl_amount").val();
		//var advance			= $("#pack_advance_recieve").val();
		var advance			= parseFloat($("#inp_advance_recieved").val());
		var balance_pay 	= $("#balance_pay");
		var thrPay 			= $("#third_payment_bal");
		
		//if not valid input
		if( _this_val == '' || !$.isNumeric(_this_val) || _this_val < 0 ){
			swal("Warning!", "Please enter positive value!", "warning");
			$(".resPonse").html('<div class="alert alert-danger"><strong>Error! </strong>Please enter positive value</div>');
			_this.val("");
			return false;
		}else{
			$(".resPonse").html('');
		}
		
		//Check Pending Balace 
		var pending = (total_cost - advance).toFixed(0);
		//if advance is greater than final amount
		if( _this_val > pending ){
			swal("Warning!", "Next Payment should be less than or equal Pending amount = " + pending , "warning");
			$(".resPonse").html('<div class="alert alert-danger"><strong>Error! </strong>Next Payment should be less than or equal Pending amount = '+ pending +'</div>');
			_this.val("");
			return false;			
		}else{
			$(".resPonse").html('');
		}
		var removeAt = _this_val >= pending ? thrPay.attr("readonly", "readonly") : thrPay.removeAttr("readonly");
		var addAttr = _this_val < pending ? $("#third_payment_bal, #third_payment_date").attr("required", "required") : $("#third_payment_bal, #third_payment_date").removeAttr("required");
	});
	
	/* On Third payment blur */
	$(document).on("blur", "#third_payment_bal", function(){
		if ($(this).attr("readonly")) return false;
		
		var _this = $(this);
		var _this_val		= parseFloat($(this).val());
		$("#final_payment_date").datepicker("clearDates");
		var total_cost		= parseFloat($("#fnl_amount_tax").val());
		//var total_cost		= parseFloat($("#fnl_amount").val());
		//var advance			= parseFloat($("#pack_advance_recieve").val());
		var advance			= parseFloat($("#inp_advance_recieved").val());
		var nextPay		 	= parseFloat($("#next_pay_balance").val());
		$("#final_payment_bal").val("");
		var fDat = $("#final_payment_date");
		fDat.removeAttr("required");
		
		//if not valid input
		if( _this_val == '' || !$.isNumeric(_this_val) || _this_val < 0 ){
			$(".resPonse").html('<div class="alert alert-danger"><strong>Error! </strong>Please enter positive value</div>');
			_this.val("");
			return false;
		}else{
			$(".resPonse").html('');
		}
		
		//Check Pending Balace 
		var totalF = advance + nextPay;
		var pending = (total_cost - totalF ).toFixed(0);
		console.log( totalF );
		//if advance is greater than final amount
		if( _this_val > pending ){
			swal("Warning!", "Payment should be less than Pending amount = " + pending, "warning");
			$(".resPonse").html('<div class="alert alert-danger"><strong>Error! </strong>Next Payment should be less than Pending amount = '+ pending +'</div>');
			_this.val("");
			return false;			
		}else{
			$(".resPonse").html('');
		}
		
		//check for final amount 
		var r = advance + nextPay + _this_val ;
		var finalAmount  = (total_cost - r  ).toFixed(0);
		$("#final_payment_bal").val(finalAmount);
		var addAtt = finalAmount >= 1 ? fDat.attr("required", "required") : fDat.removeAttr("required");
	});
});
</script>
<script>
	jQuery( document ).ready(function($){
		//reject iti sales manager
		$("#frm_rej_iti_manager").validate({
			submitHandler: function(form) {
				var ajaxReq;
				var resp = $("#rej_res2");
				var formData = $("#frm_rej_iti_manager").serializeArray();
				if (ajaxReq) {
					ajaxReq.abort();
				}
				ajaxReq = $.ajax({
					type: "POST",
					url: "<?php echo base_url('itineraries/update_iti_onhold_status'); ?>" ,
					dataType: 'json',
					data: formData,
					beforeSend: function(){
						resp.html("<div class='alert alert-info'><strong>Please wait</strong> sending.....</div>");
					},
					success: function(res) {
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
							//console.log(e);
						resp.html('<div class="alert alert-danger"><strong>Error!</strong> Please Try again later! </div>');
					}
				});
			}	
		}); 
		
		//update frmappOnholditi
		var resp = $(".response_div");
		$("#frmappOnholditi").validate();
		//	submitHandler: function(form, event) {
		$(document).on("submit",'#frmappOnholditi', function(event){
			event.preventDefault();
			var formData =  new FormData(this);
			//var formData = new FormData();
			//formData.append("fieldname","value");
			formData.append("client_aadhar_card", $('#client_aadhar_card')[0].files[0]);
			formData.append("payment_screenshot", $('#payment_screenshot')[0].files[0]);
			$.ajax({
				type: "POST",
				url: "<?php echo base_url('itineraries/update_iti_onhold_status'); ?>" ,
				dataType: 'json',
				data: formData,
				cache: false,
				contentType: false,
				processData: false,
				beforeSend: function(){
					$(".spinner_load").show();
					resp.html('<div class="alert alert-success"><i class="fa fa-spinner fa-spin"></i> Please wait...</div>');
				},
				success: function(res) {
					$(".spinner_load").hide();
					console.log(res);
					resp.html('<div class="alert alert-success"><i class="fa fa-spinner fa-spin"></i> '+res.msg+'</div>');
					location.reload();
				},
				error: function(e){
					$(".spinner_load").hide();
					resp.html('<div class="alert alert-danger"><strong>Error! </strong>Try again later.</div>');
				}
			});
		});	
		
		//get privew aadhar frmappOnholditi
		var a_id = document.getElementById("client_aadhar_card");
		var p_id = document.getElementById("payment_screenshot");
		if( a_id ){
			a_id.onchange = function () {
				var reader = new FileReader();
				reader.onload = function (e) {
					// get loaded data and render thumbnail.
					document.getElementById("client_aadhar_card_priview").style.display = "block";
					document.getElementById("client_aadhar_card_priview").src = e.target.result;
				};
				// read the image file as a data URL.
				reader.readAsDataURL(this.files[0]);
			};
		}	
		
		//get privew aadhar
		if( p_id ){
			p_id.onchange = function () {
				var reader = new FileReader();
				reader.onload = function (e) {
					// get loaded data and render thumbnail.
					document.getElementById("payment_screenshot_priview").style.display = "block";
					document.getElementById("payment_screenshot_priview").src = e.target.result;
				};
				// read the image file as a data URL.
				reader.readAsDataURL(this.files[0]);
			};
		}	
	});	
</script>
<script>
jQuery( document ).ready(function($){
	<!--show rate perperson section -->
	$(document).on("click", "#per_person_rate", function(e){
		if($(this).is(":checked"))   
			$(".perperson_section").show();
		else
			$(".perperson_section").hide();
	});
	
	$(document).on("click", "#incgst", function(e){
		if($(this).is(":checked"))   
			$(".incgst").val(1);
		else
			$(".incgst").val(0);
	});
	
	//below base price
	$(document).on("click", "#below_bp", function(e){
		if($(this).is(":checked"))   
			$(".below_bp").val(1);
		else
			$(".below_bp").val(0);
	});
	<!--end show rate perperson section -->
	
	$("#send_price_request").click(function(e){
		e.preventDefault();
		$("#price_req_modal").modal('show');
	});	
	$("#frm_price_req_modal").validate({
		submitHandler: function(form) {
			var ajaxReq;
			var resp = $("#fpriceRes");
			var formData = $("#frm_price_req_modal").serializeArray();
			if (ajaxReq) {
				ajaxReq.abort();
			}
			if( confirm("Are you sure ? ") ){
				ajaxReq = $.ajax({
					type: "POST",
					url: "<?php echo base_url('itineraries/priceReqestToManager'); ?>" ,
					dataType: 'json',
					//data: {iti_id: iti_id, temp_key: temp_key, agent_id: agent_id },
					data: formData,
					beforeSend: function(){
						resp.html("<div class='alert alert-info'><strong>Please wait</strong> Please wait request sending to manager....</div>");
					},
					success: function(res) {
						if (res.status == true){
							$("#send_price_request").hide();
							resp.html('<div class="alert alert-success"><strong>Success! </strong>'+res.msg+'</div>');
							alert(res.msg);
							//swal("success!", res.msg , "success");
							//console.log(res.msg);
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
			}
		}		
	});
});
</script>
<script type="text/javascript">
jQuery(document).ready(function($){
	//open price modal reqPriceForm
	$(".reqPrice_update").click(function(){
		$("#update_priceModal").modal('show');
	});
	$("#reqPriceForm").validate({
		submitHandler: function(form) {
			var ajaxReq;
			var resp = $("#priceRes");
			var formData = $("#reqPriceForm").serializeArray();
			if (ajaxReq) {
				ajaxReq.abort();
			}
			ajaxReq = $.ajax({
				type: "POST",
				url: "<?php echo base_url('itineraries/updateDiscountPriceReq'); ?>" ,
				dataType: 'json',
				data: formData,
				beforeSend: function(){
					resp.html("<div class='alert alert-info'><strong>Please wait</strong> sending mail.....</div>");
				},
				success: function(res) {
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
						//console.log(e);
					resp.html('<div class="alert alert-danger"><strong>Error!</strong> Please Try again later! </div>');
				}
			});
		}	
	}); 
	
	
	//open modal 
	$("#iti_send").click(function(e){
		e.preventDefault();
		$('#sendItiModal').modal('show');
	});
	
	$("#sentItiForm").validate({
		submitHandler: function(form) {
			$("#sentIti_btn").attr("disabled", "disabled");
			var ajaxReq;
			var resp = $("#mailSentResponse");
			var formData = $("#sentItiForm").serializeArray();
			if (ajaxReq) {
				ajaxReq.abort();
			}
			ajaxReq = $.ajax({
				type: "POST",
				url: "<?php echo base_url('itineraries/sendItinerary'); ?>" ,
				dataType: 'json',
				data: formData,
				beforeSend: function(){
					$(".spinner_load").show();
					resp.html("<div class='alert alert-info'><strong>Please wait</strong> sending mail.....</div>");
				},
				success: function(res) {
					$(".spinner_load").hide();
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
					$(".spinner_load").hide();
					//console.log(e);
					resp.html('<div class="alert alert-danger"><strong>Error!</strong> Please Reload Page and Try again later! </div>');
				}
			});
		}	
	}); 
	
	/* Update price by supermanager */
	$("#update_price_supermanager").validate({
		submitHandler: function(form) {
		var formData = $('#update_price_supermanager').serializeArray();
		var resp = $("#res_update_price");
		$.ajax({
				type: "POST",
				url: "<?php echo base_url('itineraries/update_price_supermanager'); ?>" ,
				dataType: 'json',
				data: formData,
				beforeSend: function(){
					resp.html('<div class="alert alert-success"><i class="fa fa-spinner fa-spin"></i> Please wait...</div>');
				},
				success: function(res) {
					if (res.status == true){
						resp.html('<div class="alert alert-success"><strong>Redirecting.....</strong></div>');
						//console.log("done");
						$("#update_price_supermanager")[0].reset();
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
	
	//Update price
	$("#submitRates").validate({
		submitHandler: function(form) {
		var formData = $('#submitRates').serializeArray();
		var resp = $("#response_div");
		$.ajax({
				type: "POST",
				url: "<?php echo base_url('itineraries/update_price'); ?>" ,
				dataType: 'json',
				data: formData,
				beforeSend: function(){
					resp.html('<p class="alert alert-success"><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
				},
				success: function(res) {
					if (res.status == true){
						resp.html('<div class="alert alert-success"><strong>Redirecting.....</strong></div>');
						//console.log("done");
						$("#submitRates")[0].reset();
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
	
	//Reject Itinerary
	$("#frm_rejectItinerary").validate({
		submitHandler: function(form) {
		var formData = $('#frm_rejectItinerary').serializeArray();
		var resp = $("#rej_res");
		$.ajax({
				type: "POST",
				url: "<?php echo base_url('itineraries/reject_itinerary'); ?>" ,
				dataType: 'json',
				data: formData,
				beforeSend: function(){
					resp.html('<div class="alert alert-success"><i class="fa fa-spinner fa-spin"></i> Please wait...</div>');
				},
				success: function(res) {
					if (res.status == true){
						resp.html('<div class="alert alert-success"><strong>Redirecting.....</strong></div>');
						console.log(res);
						$("#frm_rejectItinerary")[0].reset();
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
	
	//Discount Price
	$("#frmDiscountRates").validate({
		submitHandler: function(form) {
		var formData = $('#frmDiscountRates').serializeArray();
		var resp = $("#response_div");
		$.ajax({
				type: "POST",
				url: "<?php echo base_url('itineraries/update_discount_price'); ?>" ,
				dataType: 'json',
				data: formData,
				beforeSend: function(){
					resp.html('<div class="alert alert-success"><i class="fa fa-spinner fa-spin"></i> Please wait...</div>');
				},
				success: function(res) {
					if (res.status == true){
						resp.html('<div class="alert alert-success"><strong>Redirecting.....</strong></div>');
						//console.log("done");
						$("#frmDiscountRates")[0].reset();
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
	
	//Price Discount approved by Super Manager
	$("#frmDiscountSupermanager").validate({
		submitHandler: function(form) {
		var formData = $('#frmDiscountSupermanager').serializeArray();
		var resp = $("#response_div");
		$.ajax({
				type: "POST",
				url: "<?php echo base_url('itineraries/update_discount_price_super_manager'); ?>" ,
				dataType: 'json',
				data: formData,
				beforeSend: function(){
					resp.html('<div class="alert alert-success"><i class="fa fa-spinner fa-spin"></i> Please wait...</div>');
				},
				success: function(res) {
					if (res.status == true){
						resp.html('<div class="alert alert-success"><strong>Redirecting.....</strong></div>');
						//console.log("done");
						$("#frmDiscountSupermanager")[0].reset();
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
	/* submit comment */
	jQuery(document).ready(function($){
		var ajaxReq;
		/* Itinerary comment */
		$("#confirmForm").validate({
			submitHandler: function(form) {
				var resp = $(".response");
				var sec_key = $("#sec_key").val();
				var formData = $("#confirmForm").serializeArray();
				//console.log(formData);
				if (ajaxReq) {
					ajaxReq.abort();
				}
				ajaxReq = $.ajax({
					type: "POST",
					url: "<?php echo base_url('itineraries/ajax_add_agent_comment'); ?>" ,
					dataType: 'json',
					data: formData,
					beforeSend: function(){
						resp.html('<p><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
					},
					success: function(res) {
						if (res.status == true){
							resp.html('<div class="alert alert-success"><strong>Success! </strong>'+res.msg+'</div>');
							/*console.log("done");*/
							location.reload();
							//window.location.href = "<?php echo site_url('confirm/thankyou'); ?>?key=" + sec_key ; 
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
	
	//Prevent Dot from number field
	$("input[type='number']").on('keyup keypress', function(e) {
		var keyCode = e.keyCode || e.which;
		if( keyCode == 8 ) return true;
		if( this.value.length==8 ) return false;
		
		if ( keyCode != 8 ) {
            if (keyCode < 48 || keyCode > 57) {
				return false;
			}else {
                return true;
            }
        }else {
            return true;
        }
		
	});
</script>
<?php }else{
		redirect("itineraries");
	} ?>