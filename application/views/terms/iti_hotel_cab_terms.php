<link href="<?php echo base_url();?>site/assets/bootstrap-summernote/summernote.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url();?>site/assets/bootstrap-summernote/summernote.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>site/assets/js/components-editors.js" type="text/javascript"></script>
<div class="page-container" id="global_terms">
	<div class="page-content-wrapper">
		<div class="page-content">
			<div class="row">
				<div class="col-md-12">
					<!-- BEGIN PROFILE CONTENT -->
					<div class="profile-content">
						<div class="row">
							<div class="col-md-12">
								<div class="portlet light ">
									<div class="portlet-title tabbable-line">
										<div class="caption caption-md">
											<i class="icon-globe theme-font hide"></i>
											<span class="caption-subject font-blue-madison bold uppercase"><?php echo $page_heading; ?></span>
										</div>
										<ul class="nav nav-tabs">
											<li class="active">
												<a href="#tab_1_5" data-toggle="tab">Greeting</a>
											</li>
											<li>
												<a href="#tab_1_7" data-toggle="tab">How to book package</a>
											</li>
											<li>
												<a href="#tab_1_2" data-toggle="tab">Refund & Cancellation</a>
											</li>
											<li>
												<a href="#tab_1_8" data-toggle="tab">Amendment Policy</a>
											</li>
											<li>
												<a href="#tab_1_10" data-toggle="tab">Payment Policy</a>
											</li>
											<li>
												<a href="#tab_1_3" data-toggle="tab">T&C </a>
											</li>
											<li>
												<a href="#tab_1_4" data-toggle="tab">Promotion Signature</a>
											</li>
											<li class="">
												<a href="#tab_1_1" data-toggle="tab">Bank Terms</a>
											</li>
											<li class="">
												<a href="#tab_1_6" data-toggle="tab">Hotel Exclusion & Notes</a>
											</li>
											<?php if( $term_type == "itinerary" ){ ?>
												<li class="">
													<a href="#tab_1_11" data-toggle="tab">Benefits</a>
												</li>
											<?php } ?>
										</ul>
									</div>
									<div class="portlet-body">
										<!--update Hotel terms Form-->
										<form role="form" class="form-horizontal2 form-bordered" id="updateHotelTerms">
										<div class="tab-content">
											<!-- PERSONAL INFO TAB -->
											<div class="tab-pane" id="tab_1_1">
												<?php $term_meta_bank = $terms[0];
														//get data if exists
														$bank_payment_terms			= isset($term_meta_bank->bank_payment_terms_content) ? unserialize( $term_meta_bank->bank_payment_terms_content ) : ""; 
														$count_bank_payment_terms	= count( $bank_payment_terms ); 
														$count_bankTerms			= $count_bank_payment_terms-1; 
														?>
														<label class="control-label"><strong>Bank Payment Terms Heading</strong></label><br>
															<input name="group_bankPay_condition[heading]" required type="text" placeholder="eg. Bank Payment Terms" value="<?php if(isset($bank_payment_terms["heading"]) ) { echo $bank_payment_terms["heading"] ; } ?>" class="form-control" />
															<hr style="border:none;">
															<div class="form-group mt-repeater">
																<label class="control-label"><strong>Bank Payment Terms</strong></label> 
																<div data-repeater-list="group_bankPay_condition">
																	<?php if( $count_bankTerms > 0 ){ ?>
																		<?php for ( $i = 0; $i < $count_bankTerms; $i++ ) { ?>
																		<div data-repeater-item class="mt-repeater-item mt-overflow">
																			<div class="mt-repeater-cell">
																				<input name="group_bankPay_condition[<?php echo $i; ?>][terms]" required type="text" placeholder="Add Terms & Condition" value="<?php echo $bank_payment_terms[$i]["terms"] ;?>" class="form-control mmt-repeater-input-inline" />
																				<a href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-delete mt-repeater-del-right mt-repeater-btn-inline">
																					<i class="fa fa-close"></i>
																				</a>
																			</div>
																		</div>	
																		<?php } ?>	
																	<?php }else{ ?>
																		<div data-repeater-item class="mt-repeater-item mt-overflow">
																			<div class="mt-repeater-cell">
																				<input name="terms" required type="text" placeholder="Terms & Condition" class="form-control mmt-repeater-input-inline" />
																				<a href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-delete mt-repeater-del-right mt-repeater-btn-inline">
																					<i class="fa fa-close"></i>
																				</a>
																			</div>
																		</div>
																	<?php } ?>
																</div>
																<a href="javascript:;" data-repeater-create class="btn btn-success mt-repeater-add pull-right">
																<i class="fa fa-plus"></i> Add new</a>
															</div>
											</div>
											<!-- END PERSONAL INFO TAB -->
											<!-- Refund Policy & Cancellation -->
											 <div class="tab-pane" id="tab_1_2">
													<?php $term_meta = $terms[0];
														//get data if exists
														$cancel_content = isset($term_meta->cancel_content) ? unserialize( $term_meta->cancel_content) : ""; 
														$count_cancel_content	= count( $cancel_content ); 
														$countCancelContent	= $count_cancel_content-1; 
														?>
													<div class="col-md-12">
														<label class="control-label"><strong>Refund Policy & Cancellation Heading</strong></label><br>
															
														<input name="group_cancel_terms[heading]" required type="text" placeholder="CANCELLATION & REFUND POLICY:" value="<?php if(isset($cancel_content["heading"]) ) { echo $cancel_content["heading"] ; } ?>" class="form-control" />
														<hr style="border:none;">
														<div class="form-group mt-repeater">
															<label class="control-label"><strong>Refund Policy & Cancellation Terms</strong></label> 
													 
															<div data-repeater-list="group_cancel_terms">
																<?php if( $countCancelContent > 0 ){ ?>
																	<?php for ( $i = 0; $i < $countCancelContent; $i++ ) { ?>
																	<div data-repeater-item class="mt-repeater-item mt-overflow">
																		<div class="mt-repeater-cell">
																			<div class="col-md-6">
																			<input name="group_cancel_terms[<?php echo $i; ?>][cancel_terms]" required type="text" placeholder="Add tour cancel & refund terms title" value="<?php echo isset($cancel_content[$i]["cancel_terms"]) ? $cancel_content[$i]["cancel_terms"] : "";?>" class="form-control mmt-repeater-input-inline" />
																			</div>
																			<div class="col-md-5">
																			<input name="group_cancel_terms[<?php echo $i; ?>][cancel_terms_right]" required type="text" placeholder="Add tour cancel & refund terms value" value="<?php echo isset($cancel_content[$i]["cancel_terms_right"]) ? $cancel_content[$i]["cancel_terms_right"] : "";?>" class="form-control mmt-repeater-input-inline" />
																			</div>
																			<div class="col-md-1">
																			<a href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-delete mt-repeater-del-right mt-repeater-btn-inline">
																				<i class="fa fa-close"></i>
																			</a>
																			</div>
																		</div>
																	</div>	
																	<?php } ?>	
																<?php }else{ ?>
																	<div data-repeater-item class="mt-repeater-item mt-overflow">
																		<div class="mt-repeater-cell">
																			<div class="col-md-6">
																				<input name="cancel_terms" required type="text" placeholder="Add tour cancel & refund terms" class="form-control mmt-repeater-input-inline" />
																			</div>	
																			<div class="col-md-5">
																				<input name="cancel_terms_right" required type="text" placeholder="Add tour cancel & refund terms value" class="form-control mmt-repeater-input-inline" />
																			</div>	
																			<div class="col-md-1">
																				<a href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-delete mt-repeater-del-right mt-repeater-btn-inline">
																				<i class="fa fa-close"></i>
																			</a>
																			</div>
																		</div>
																	</div>
																<?php } ?>
															</div>
															<a href="javascript:;" data-repeater-create class="btn btn-success mt-repeater-add pull-right">
															<i class="fa fa-plus"></i> Add new</a>
														</div>
													</div>	
												</div>
											<!-- END CHANGE AVATAR TAB -->
											<!-- CHANGE PASSWORD TAB -->
											<div class="tab-pane" id="tab_1_3">
												<?php $term_meta_terms = $terms[0];
												//get data if exists
												$terms_content 			= isset($term_meta_terms->terms_content) ? unserialize( $term_meta_terms->terms_content) : ""; 
												$count_terms_content	= count( $terms_content ); 
												$counttermContent		= $count_terms_content-1; 
												?>
												<label class="control-label"><strong>Terms & Condition Heading</strong></label><br>
												
												<input name="group_terms_condition[heading]" required type="text" placeholder="eg. Terms & Condition" value="<?php if(isset($terms_content["heading"]) ) { echo $terms_content["heading"] ; } ?>" class="form-control" />
												<hr style="border:none">
												<div class="form-group mt-repeater">
													<label class="control-label"><strong>Terms & Condition</strong></label>
													<div data-repeater-list="group_terms_condition">
														<?php if( $counttermContent > 0 ){ ?>
															<?php for ( $i = 0; $i < $counttermContent; $i++ ) { ?>
															<div data-repeater-item class="mt-repeater-item mt-overflow">
																<div class="mt-repeater-cell">
																	<input name="group_terms_condition[<?php echo $i; ?>][terms]" required type="text" placeholder="Add Terms & Condition" value="<?php echo $terms_content[$i]["terms"] ;?>" class="form-control mmt-repeater-input-inline" />
																	<a href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-delete mt-repeater-del-right mt-repeater-btn-inline">
																		<i class="fa fa-close"></i>
																	</a>
																</div>
															</div>	
															<?php } ?>	
														<?php }else{ ?>
															<div data-repeater-item class="mt-repeater-item mt-overflow">
																<div class="mt-repeater-cell">
																	<input name="terms" required type="text" placeholder="Terms & Condition" class="form-control mmt-repeater-input-inline" />
																	<a href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-delete mt-repeater-del-right mt-repeater-btn-inline">
																		<i class="fa fa-close"></i>
																	</a>
																</div>
															</div>
														<?php } ?>
													</div>
													<a href="javascript:;" data-repeater-create class="btn btn-success mt-repeater-add pull-right">
													<i class="fa fa-plus"></i> Add new</a>
												</div>
											</div>
											<!-- Promotion Signature Tab -->
											<div class="tab-pane" id="tab_1_4">
													<div class="form-group">
														<label class="control-label">Promotion Signature</label>
														<textarea id="summernote_4" name="promotion_signature"><?php if($terms!= NULL){ echo htmlspecialchars_decode($terms[0]->promotion_signature); }?></textarea>
														
													</div>
											</div>
											<!-- Greeting Tab -->
											<div class="tab-pane active" id="tab_1_5">
													<div class="form-group">
														<label class="control-label">Greeting Message</label>
														<textarea required id="summernote_5" name="greeting_message"><?php if($terms!= NULL){ echo $terms[0]->greeting_message; }?></textarea>
													</div>
											</div>
											<!-- Hotel Exclusion Tab -->
											<div class="tab-pane" id="tab_1_6">
													<?php $term_meta = $terms[0];
														//get data if exists
														$hotel_exc = isset($term_meta->hotel_exclusion) && !empty($term_meta->hotel_exclusion) ? unserialize( $term_meta->hotel_exclusion) : 5; 
														$count_hotel_exc	= count( $hotel_exc );
													
														?>
														
													<div class="col-md-4">
														<div class="form-group mt-repeater">
															<label class="control-label"><strong>Hotel Exclusion </strong></label>
															<div data-repeater-list="group_hotel_exc">
																<?php if( $count_hotel_exc > 0 ){ ?>
																	<?php for ( $i = 0; $i < $count_hotel_exc; $i++ ) { ?>
																	<div data-repeater-item class="mt-repeater-item mt-overflow">
																		<div class="mt-repeater-cell">
																			<input name="group_hotel_exc[<?php echo $i; ?>][hotel_exc]" required type="text" placeholder="Enter hotel exclusion" value="<?php echo $hotel_exc[$i]["hotel_exc"] ;?>" class="form-control mmt-repeater-input-inline" />
																			<a href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-delete mt-repeater-del-right mt-repeater-btn-inline">
																				<i class="fa fa-close"></i>
																			</a>
																		</div>
																	</div>	
																	<?php } ?>	
																<?php }else{ ?>
																	<div data-repeater-item class="mt-repeater-item mt-overflow">
																		<div class="mt-repeater-cell">
																			<input name="hotel_exc" required type="text" placeholder="Enter hotel exclusion" class="form-control mmt-repeater-input-inline" />
																			<a href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-delete mt-repeater-del-right mt-repeater-btn-inline">
																				<i class="fa fa-close"></i>
																			</a>
																		</div>
																	</div>
																<?php } ?>
															</div>
															<a href="javascript:;" data-repeater-create class="btn btn-success mt-repeater-add pull-right">
															<i class="fa fa-plus"></i> Add new</a>
														</div>
													</div>	
													<?php $hotel_notes = isset($term_meta->hotel_notes) ? unserialize( $term_meta->hotel_notes) : ""; 
														$count_hotel_notes	= !empty($hotel_notes) ? count( $hotel_notes ) : 0;
														?>
													
													<div class="col-md-4">
														<div class="form-group mt-repeater">
															<label class="control-label"><strong>Hotel Notes</strong></label>
															<div data-repeater-list="group_hotel_notes">
															<?php if( $count_hotel_notes > 0 ){ ?>
																	<?php for ( $i = 0; $i < $count_hotel_notes; $i++ ) { ?>
																	<div data-repeater-item class="mt-repeater-item mt-overflow">
																		<div class="mt-repeater-cell">
																			<input name="group_hotel_notes[<?php echo $i; ?>][hotel_notes]" required type="text" placeholder="Enter hotel notes" value="<?php echo $hotel_notes[$i]["hotel_notes"] ;?>" class="form-control mmt-repeater-input-inline" />
																			<a href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-delete mt-repeater-del-right mt-repeater-btn-inline">
																				<i class="fa fa-close"></i>
																			</a>
																		</div>
																	</div>	
																	<?php } ?>	
																<?php }else{ ?>
																	<div data-repeater-item class="mt-repeater-item mt-overflow">
																		<div class="mt-repeater-cell">
																			<input name="hotel_notes" required type="text" placeholder="Enter hotel notes" class="form-control mt-repeater-input-inline" />
																			<a href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-delete mt-repeater-del-right mt-repeater-btn-inline">
																				<i class="fa fa-close"></i>
																			</a>
																		</div>
																	</div>
																<?php } ?>
															</div>
															<a href="javascript:;" data-repeater-create class="btn btn-success mt-repeater-add pull-right">
															<i class="fa fa-plus"></i> Add new</a>
														</div>
													</div>	
														<?php 
														$rates_dates_notes = isset($term_meta->rates_dates_notes) && !empty( $term_meta->rates_dates_notes ) ? unserialize( $term_meta->rates_dates_notes) : ""; 
														$count_rates_notes  = !empty( $rates_dates_notes ) ? count( $rates_dates_notes ) : 0 ;
														?>
													<div class="col-md-4">
														<div class="form-group mt-repeater">
															<label class="control-label"><strong>Rates and Dates Notes</strong></label>
															<div data-repeater-list="group_hotel_rates_notes">
																<?php if( $count_rates_notes > 0 ){ ?>
																	<?php for ( $i = 0; $i < $count_rates_notes; $i++ ) { ?>
																	<div data-repeater-item class="mt-repeater-item mt-overflow">
																		<div class="mt-repeater-cell">
																			<input name="group_hotel_rates_notes[<?php echo $i; ?>][rates_notes]" required type="text" placeholder="Enter hotel notes" value="<?php if( isset( $rates_dates_notes[$i]["rates_notes"] ) ){ echo $rates_dates_notes[$i]["rates_notes"] ; } ?>" class="form-control mmt-repeater-input-inline" />
																			<a href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-delete mt-repeater-del-right mt-repeater-btn-inline">
																				<i class="fa fa-close"></i>
																			</a>
																		</div>
																	</div>	
																	<?php } ?>	
																<?php }else{ ?>
																	<div data-repeater-item class="mt-repeater-item mt-overflow">
																		<div class="mt-repeater-cell">
																			<input name="rates_notes" required type="text" placeholder="Enter rates and dates notes exclustion" class="form-control mt-repeater-input-inline" />
																			<a href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-delete mt-repeater-del-right mt-repeater-btn-inline">
																				<i class="fa fa-close"></i>
																			</a>
																		</div>
																	</div>
																<?php } ?>	
															</div>
															<a href="javascript:;" data-repeater-create class="btn btn-success mt-repeater-add pull-right">
															<i class="fa fa-plus"></i> Add new</a>
														</div>
													</div>	
											</div><!--end hotel exclusion-->
											
											<!-- How to book package -->
											<div class="tab-pane" id="tab_1_7">
													<?php $term_meta = $terms[0];
														//get data if exists
														$book_package = isset($term_meta->book_package) ? unserialize( $term_meta->book_package) : ""; 
														$count_book_package	= count( $book_package ); 
														
														//remove two element from array
														$tour_list = $count_book_package - 2;
														?>
													<div class="col-md-6">
													<div class="form-group">
														<label class="control-label"><strong>HOW TO BOOK PACKAGE HEADING </strong></label>
														
														<input name="group_book_pacakge_terms[heading]" required type="text" placeholder="How to book package heading" value="<?php if(isset($book_package["heading"]) ) { echo $book_package["heading"] ; } ?>" class="form-control" />
														<hr>
														<label class="control-label"><strong>HOW TO BOOK PACKAGE SUBHEADING </strong></label><br>
														<input name="group_book_pacakge_terms[sub_heading]" required type="text" placeholder="How to book package sub heading" value="<?php if(isset($book_package["sub_heading"]) ){ echo $book_package["sub_heading"] ; } ?>" class="form-control" />
														<hr>
														<label class="control-label"><strong>HOW TO BOOK PACKAGE TERMS </strong></label><br>
														<div class="form-group mt-repeater">
															<div data-repeater-list="group_book_pacakge_terms">
																<?php if( $tour_list > 0 ){ ?>
																	<?php for ( $i = 0; $i < $tour_list; $i++ ) { ?>
																		<div data-repeater-item class="mt-repeater-item mt-overflow">
																			<div class="mt-repeater-cell">
																				<input name="group_book_pacakge_terms[<?php echo $i; ?>][hotel_book_terms]" required type="text" placeholder="Booking Terms Title" value="<?php echo isset($book_package[$i]["hotel_book_terms"]) ? $book_package[$i]["hotel_book_terms"] : "";?>" class="form-control mmt-repeater-input-inline" />
																				
																				<input name="group_book_pacakge_terms[<?php echo $i; ?>][hotel_book_terms_right]" required type="text" placeholder="Booking Terms Value" value="<?php echo isset($book_package[$i]["hotel_book_terms_right"]) ? $book_package[$i]["hotel_book_terms_right"] : "";?>" class="form-control mmt-repeater-input-inline" />
																				
																				<a href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-delete mt-repeater-del-right mt-repeater-btn-inline">
																					<i class="fa fa-close"></i>
																				</a>
																			</div>
																		</div>	
																	<?php } ?>	
																<?php }else{ ?>
																	<div data-repeater-item class="mt-repeater-item mt-overflow">
																		<div class="mt-repeater-cell">
																			<input name="hotel_book_terms" required type="text" placeholder="Enter Booking title" class="form-control mmt-repeater-input-inline" />
																			
																			<input name="hotel_book_terms_right" required type="text" placeholder="Enter Booking terms" class="form-control mmt-repeater-input-inline" />
																			
																			<a href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-delete mt-repeater-del-right mt-repeater-btn-inline">
																				<i class="fa fa-close"></i>
																			</a>
																		</div>
																	</div>
																<?php } ?>
															</div>
															<a href="javascript:;" data-repeater-create class="btn btn-success mt-repeater-add  pull-right">
															<i class="fa fa-plus"></i> Add new</a>
														</div>
													</div>	
													</div>	
													<div class="col-md-6">
														<?php $term_meta_ad = $terms[0];
														//get data if exists
														$advance_pay_terms = isset($term_meta_ad->advance_payment_terms) ? unserialize( $term_meta_ad->advance_payment_terms) : ""; 
														$count_advance_pay	= count( $advance_pay_terms ); 
														
														//remove one element from array for heading
														$tour_ad_list = $count_advance_pay - 1;
														?>
														<label class="control-label"><strong>PROCESS OF MAKING ADVANCE PAYMENT:</strong></label><br>
														<input name="group_pro_advance_pay[heading]" required type="text" placeholder="PROCESS OF MAKING ADVANCE PAYMENT:" value="<?php if(isset($advance_pay_terms["heading"]) ) { echo $advance_pay_terms["heading"] ; } ?>" class="form-control" />
														<hr>
														<label class="control-label"><strong>PROCESS OF MAKING ADVANCE PAYMENT TERMS </strong></label><br>
														<div class="form-group mt-repeater">
															<div data-repeater-list="group_pro_advance_pay">
																<?php if( $tour_ad_list > 0 ){ ?>
																	<?php for ( $i = 0; $i < $tour_ad_list; $i++ ) { ?>
																		<div data-repeater-item class="mt-repeater-item mt-overflow">
																			<div class="mt-repeater-cell">
																				<input name="group_pro_advance_pay[<?php echo $i; ?>][terms]" required type="text" placeholder="Hotel Booking Terms" value="<?php echo $advance_pay_terms[$i]["terms"] ;?>" class="form-control mmt-repeater-input-inline" />
																				<a href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-delete mt-repeater-del-right mt-repeater-btn-inline">
																					<i class="fa fa-close"></i>
																				</a>
																			</div>
																		</div>	
																	<?php } ?>	
																<?php }else{ ?>
																	<div data-repeater-item class="mt-repeater-item mt-overflow">
																		<div class="mt-repeater-cell">
																			<input name="terms" required type="text" placeholder="Enter Booking terms" class="form-control mmt-repeater-input-inline" />
																			<a href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-delete mt-repeater-del-right mt-repeater-btn-inline">
																				<i class="fa fa-close"></i>
																			</a>
																		</div>
																	</div>
																<?php } ?>
															</div>
															<a href="javascript:;" data-repeater-create class="btn btn-success mt-repeater-add pull-right">
															<i class="fa fa-plus"></i> Add new</a>
														</div>
													</div>
											</div><!--end How to book package--->
											
											<!-- Amendment Policy (Prepend/Postpend) -->
											<div class="tab-pane" id="tab_1_8">
												<?php $term_meta = $terms[0];
												//get data if exists
												$amendment_policy = isset($term_meta->amendment_policy) ? unserialize( $term_meta->amendment_policy) : ""; 
												$count_amendment_policy	= count( $amendment_policy );
												$count_amendmentpolicy	= $count_amendment_policy-1;
												?>
												<div class="col-md-12">
													<label class="control-label"><strong>Amendment Policy (Prepend/Postpend) Heading</strong></label><br>
													
													<input name="group_amendment_policy_terms[heading]" required type="text" placeholder="Amendment Policy (Prepend/Postpend)" value="<?php if(isset($amendment_policy["heading"]) ) { echo $amendment_policy["heading"] ; } ?>" class="form-control" />
													<hr style="border:none">
													<div class="form-group mt-repeater">
														<label class="control-label"><strong>Amendment Policy (Prepend/Postpend)</strong></label>
														<div data-repeater-list="group_amendment_policy_terms">
															<?php if( $count_amendmentpolicy > 0 ){ ?>
																<?php for ( $i = 0; $i < $count_amendmentpolicy; $i++ ) { ?>
																<div data-repeater-item class="mt-repeater-item mt-overflow">
																	<div class="mt-repeater-cell">
																		<div class="col-md-6">
																			<input name="group_amendment_policy_terms[<?php echo $i; ?>][amend_policy]" required type="text" placeholder="Add amendment terms title" value="<?php echo isset($amendment_policy[$i]["amend_policy"]) ? $amendment_policy[$i]["amend_policy"] : ""; ?>" class="form-control mmt-repeater-input-inline" />
																		</div>
																		<div class="col-md-5">
																			<input name="group_amendment_policy_terms[<?php echo $i; ?>][amend_policy_right]" required type="text" placeholder="Add amendment terms value" value="<?php echo isset($amendment_policy[$i]["amend_policy_right"]) ? $amendment_policy[$i]["amend_policy_right"] : ""; ?>" class="form-control mmt-repeater-input-inline" />
																		</div>	
																		<div class="col-md-1">											
																			<a href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-delete mt-repeater-del-right mt-repeater-btn-inline">
																			<i class="fa fa-close"></i>
																			</a>
																		</div>
																	</div>
																</div>	
																<?php } ?>	
															<?php }else{ ?>
																<div data-repeater-item class="mt-repeater-item mt-overflow">
																	<div class="mt-repeater-cell">
																		<div class="col-md-6">
																			<input name="amend_policy" required type="text" placeholder="Enter Amendment terms title" class="form-control mmt-repeater-input-inline" />
																		</div>	
																		<div class="col-md-5">
																			<input name="amend_policy_right" required type="text" placeholder="Enter Amendment terms value" class="form-control mmt-repeater-input-inline" />
																		</div>	
																		<div class="col-md-1">
																			<a href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-delete mt-repeater-del-right mt-repeater-btn-inline">
																			<i class="fa fa-close"></i>
																			</a>
																		</div>	
																	</div>
																</div>
															<?php } ?>
														</div>
														<a href="javascript:;" data-repeater-create class="btn btn-success mt-repeater-add  pull-right">
														<i class="fa fa-plus"></i> Add new</a>
													</div>
												</div>
											</div><!--Amendment Policy (Prepend/Postpend)--->
											
											<!-- Amendment Policy (Prepend/Postpend) -->
											<div class="tab-pane" id="tab_1_10">
												<?php $term_meta = $terms[0];
												//get data if exists
												$payment_policy = isset($term_meta->payment_policy) ? unserialize( $term_meta->payment_policy) : ""; 
												$count_payment_policy	= count( $payment_policy );
												$count_paymentpolicy	= $count_payment_policy-1;
												?>
												<div class="col-md-12">
													<label class="control-label"><strong>Payment Policy (After receiving Booking cost)</strong></label><br>
													<input name="payment_policy[heading]" required type="text" placeholder="Payment Policy (Payment Policy (After receiving Booking cost)" value="<?php if(isset($payment_policy["heading"]) ) { echo $payment_policy["heading"] ; } ?>" class="form-control" />
													<hr style="border:none">
													<div class="form-group mt-repeater">
														<label class="control-label"><strong>Payment Policy (After receiving Booking cost)</strong></label> 
														<div data-repeater-list="payment_policy">
															<?php if( $count_paymentpolicy > 0 ){ ?>
																<?php for ( $i = 0; $i < $count_paymentpolicy; $i++ ) { ?>
																<div data-repeater-item class="mt-repeater-item mt-overflow">
																	<div class="mt-repeater-cell">
																		<div class="col-md-6">
																			<input name="payment_policy[<?php echo $i; ?>][pay_policy]" required type="text" placeholder="Add payment terms title" value="<?php echo isset($payment_policy[$i]["pay_policy"]) ? $payment_policy[$i]["pay_policy"] : ""; ?>" class="form-control mmt-repeater-input-inline" />
																		</div>
																		<div class="col-md-5">	
																			<input name="payment_policy[<?php echo $i; ?>][pay_policy_right]" required type="text" placeholder="Add payment terms value" value="<?php echo isset($payment_policy[$i]["pay_policy_right"]) ? $payment_policy[$i]["pay_policy_right"] : ""; ?>" class="form-control mmt-repeater-input-inline" />
																		</div>
																		<div class="col-md-1">	
																			<a href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-delete mt-repeater-del-right mt-repeater-btn-inline">
																			<i class="fa fa-close"></i>
																			</a>
																		</div>
																	</div>
																</div>	
																<?php } ?>	
															<?php }else{ ?>
																<div data-repeater-item class="mt-repeater-item mt-overflow">
																	<div class="mt-repeater-cell">
																		<div class="col-md-6">
																			<input name="pay_policy" required type="text" placeholder="Enter payment terms title" class="form-control mmt-repeater-input-inline" />
																		</div>
																		<div class="col-md-5">
																			<input name="pay_policy_right" required type="text" placeholder="Enter payment terms value" class="form-control mmt-repeater-input-inline" />
																		</div>	
																		<div class="col-md-1">	
																			<a href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-delete mt-repeater-del-right mt-repeater-btn-inline">
																			<i class="fa fa-close"></i>
																			</a>
																		</div>	
																	</div>
																</div>
															<?php } ?>
														</div>
														<a href="javascript:;" data-repeater-create class="btn btn-success mt-repeater-add  pull-right">
														<i class="fa fa-plus"></i> Add new</a>
													</div>
												</div>
											</div><!--Amendment Policy (Prepend/Postpend)--->
											
											<?php if( $term_type == "itinerary" ){ ?>
												<!-- Amendment Policy (Prepend/Postpend) -->
												<div class="tab-pane" id="tab_1_11">
													<?php $term_meta = $terms[0];
													//get data if exists
													$booking_benefits_terms = isset($term_meta->booking_benefits_terms) ? unserialize( $term_meta->booking_benefits_terms) : ""; 
													$bcount	= count( $booking_benefits_terms );
													$bcount_t	= $bcount;
													?>
													<div class="col-md-12">
														<label class="control-label"><strong>Booking With Us Benefits</strong></label><br>
														<hr style="border:none">
														<div class="form-group mt-repeater">
															<div data-repeater-list="booking_benefits_terms">
																<?php if( $bcount_t > 0 ){ ?>
																	<?php for ( $i = 0; $i < $bcount_t; $i++ ) { ?>
																	<div data-repeater-item class="mt-repeater-item mt-overflow">
																		<div class="mt-repeater-cell">
																			<div class="col-md-6">
																				<input name="booking_benefits_terms[<?php echo $i; ?>][benefit_inc]" required type="text" placeholder="Add Booking benefits" value="<?php echo isset($booking_benefits_terms[$i]["benefit_inc"]) ? $booking_benefits_terms[$i]["benefit_inc"] : ""; ?>" class="form-control mmt-repeater-input-inline" />
																			</div>
																			<div class="col-md-1">	
																				<a href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-delete mt-repeater-del-right mt-repeater-btn-inline">
																				<i class="fa fa-close"></i>
																				</a>
																			</div>
																		</div>
																	</div>	
																	<?php } ?>	
																<?php }else{ ?>
																	<div data-repeater-item class="mt-repeater-item mt-overflow">
																		<div class="mt-repeater-cell">
																			<div class="col-md-6">
																				<input name="benefit_inc" required type="text" placeholder="Enter Booking benefits" class="form-control mmt-repeater-input-inline" />
																			</div>
																			<div class="col-md-1">	
																				<a href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-delete mt-repeater-del-right mt-repeater-btn-inline">
																				<i class="fa fa-close"></i>
																				</a>
																			</div>	
																		</div>
																	</div>
																<?php } ?>
															</div>
															<a href="javascript:;" data-repeater-create class="btn btn-success mt-repeater-add  pull-right">
															<i class="fa fa-plus"></i> Add new</a>
														</div>
													</div>
												</div><!--Amendment Policy (Prepend/Postpend)--->
											<?php } ?>
										</div>
										<hr>
										<div class="form-actions">
											<input type="hidden" name="term_id" value="<?php if($terms!= NULL){ echo $terms[0]->term_id; } ?>" />	
											<input type="hidden" name="type" value="<?php if($terms!= NULL){ echo "Edit"; } else { echo "Add";} ?>" />
											<input type="hidden" name="term_type" value="<?php echo $term_type; ?>" />
											<div class="col-md-10">
												<button type="submit" class="btn green">
												<i class="fa fa-check"></i>Save</button>
											</div>
										</div>
									</form>
									<div class="clearfix"></div>
									<div id="response"></div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- END PROFILE CONTENT -->
				</div>
			</div>
		</div>
		<!-- END CONTENT BODY -->
	</div>
	<!-- END CONTENT -->

</div>
<script type="text/javascript">
	/* Hotel Exclusion repeater */
	jQuery(document).ready(function($) {
		FormRepeater.init();
	});
	var FormRepeater = function () {
		return {
			init: function () {
				jQuery('.mt-repeater').each(function(){ 
					$(this).find(".mt-repeater-delete:eq( 0 )").hide();
					$(this).repeater({
						show: function () {
							$(this).find(".mt-repeater-delete:eq( 0 )").show();
							$(this).show();
						},
						hide: function (deleteElement) {
							if(confirm('Are you sure you want to delete this element?')) {
								$(this).slideUp(deleteElement);
							}
						},
						ready: function (setIndexes) {

						}

					});
				});
			}	
		};
	}();
</script>
<script type="text/javascript">
// Ajax Update Hotel Terms 
jQuery(document).ready(function($) {
	var ajaxRstr;
	/*Hotel Exclusion and notes*/
	$("#updateHotelTerms").validate({
		submitHandler: function(form){
			var response = $("#response");
			var formData = $("#updateHotelTerms").serializeArray();
			var type = $("input[name='type']").val();
			console.log( type );
			if (confirm("Are you sure to save changes ?")) {
				if (ajaxRstr) {
					ajaxRstr.abort();
				}
				ajaxRstr = jQuery.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>" + "terms/ajax_update_hotel_terms_data",
					dataType: 'json',
					data: formData,
					beforeSend: function(){
						response.show().html('<p><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
					},
					success: function(res) {
						if (res.status == true){
							response.html('<div class="alert alert-success"><strong>Success! </strong>'+res.msg+'</div>');
							//console.log("done");
							if( type == "Edit" ){
								setTimeout(function() { response.fadeOut('fast'); }, 2000); // <-- time in milliseconds
							}else{
								location.reload();
							}	
						}else{
							response.html('<div class="alert alert-danger"><strong>Error! </strong>'+res.msg+'</div>');
							//console.log("error");
						}
					},
					error: function(){
						response.html('<div class="alert alert-danger"><strong>Error! </strong>Please Try again later! </div>');
					}
				});
			}
		}
	});
});	

</script>