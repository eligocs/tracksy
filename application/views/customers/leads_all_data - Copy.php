<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>		
	<link href="<?php echo base_url(); ?>site/assets/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
	<script src="<?php echo base_url(); ?>/site/assets/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
<style>
#customer_info_panel, #quotation_type_section{display: none;} 
#call_log_section{display: none;} 
#close_lead_panel,#booked_lead_panel,#call_not_picked_panel,#picked_call_panel, .nxt_call{display: none}
#next_call_cal{display: none;}
.tour_des {
    background: #faebcc;
    padding-top: 20px;
    padding-bottom: 40px;
}
#other_pack{display: none;}
#pack_type_other{display: none;}
#pakcageModal{top: 20%;}
.iti_leads_followup_section {
    height: 500px;
    overflow-y: scroll;
}
div#quotation_type_section, #readyQuotation {
    margin: 15px;
}
.call_type_res{overflow: visible !important; }
</style>
<div class="page-container customer_view_section view_call_info">
	<div class="page-content-wrapper">
			<div class="page-content">
			<?php if( isset($customer[0]) && !empty($customer[0])) {
				$customer = $customer[0];
				?>
				<input id="sId" type="hidden" value="<?php echo $customer->customer_id; ?>" >
				<!-- BEGIN SAMPLE TABLE PORTLET-->
				<?php $message = $this->session->flashdata('success'); 
				if($message){ echo '<span class="help-block help-block-success">'.$message.'</span>';}
				?>
				<div class="portlet box blue">
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-users"></i>Lead Full Detail </div>
						<div class="actions">
						<a class="btn btn-success" href="<?php echo site_url("customers"); ?>" title="add hotel">Back To All Leads</a>
						</div>
					</div>
				</div>	
				
				<!--search customer-->
				<div class="portlet-body">
					<div class="marginBottom text-center">
						<!--start filter section-->
						<form id="search_customer_data" class="form-horizontal">
							<div class="form-group">
								<label class="control-label col-sm-4"  for="customer_id">Enter Customer ID/name/contact:</label>
								<div class="col-sm-4">
									<input type="text" id="customer_id" required maxlength="20" name="keyword" value="<?php echo $customer->customer_id; ?>"  class="form-control" placeholder="Type Lead Id or Customer Name or Contact Number" title="Type Lead Id or Customer Name or Contact Number" /> 
									<ul class="dropdown-menu txtcustomer" style="margin-left:20px;margin-right:0px;" role="menu" aria-labelledby="dropdownMenu"  id="DropdownCusInfo"></ul>
								</div>
							</div>
						</form>
						<hr class="clearfix"/>
						<!--ajax response data-->
					</div>		
					<!--customer details-->
					<div class="customer-details">	
						<div class=" ">
							<h3 class='text-center uppercase'>Lead Info</h3>
							<div class="col-md-6 col-lg-4">
								<div class="col-md-6 form_vl"><strong>Lead Id:</strong></div>	
								<div class="col-md-6 form_vr"><?php echo $customer->customer_id; ?></div>
							</div>
							<div class="col-md-6 col-lg-4">
								<div class="col-md-6 form_vl"><strong>Customer Type:</strong></div>	
								<?php 
									$cus_type 	= get_customer_type_name($customer->customer_type);
								?>
								<div class="col-md-6 form_vr"><?php echo $cus_type; ?></div>
							</div>
							<?php if( $customer->customer_type == 2 ){ ?>
							<div class="col-md-6 col-lg-4">
								<div class="col-md-6 form_vl"><strong>Reference Name:</strong></div>	
								<div class="col-md-6 form_vr"><?php echo $customer->reference_name; ?></div>
							</div>
							<div class="col-md-6 col-lg-4">
								<div class="col-md-6 form_vl"><strong>Reference Contact:</strong></div>	
								<div class="col-md-6 form_vr"><?php echo $customer->reference_contact_number; ?></div>
							</div>
							<?php } ?>
							
							<div class="col-md-6 col-lg-4">
								<div class="col-md-6 form_vl"><strong>Customer Name:</strong></div>	
								<div class="col-md-6 form_vr"><?php echo $customer->customer_name; ?></div>
							</div>

							<div class="col-md-6 col-lg-4">
								<div class="col-md-6 form_vl"><strong>Customer Email:</strong></div>	
								<div class="col-md-6 form_vr"><?php echo $customer->customer_email; ?></div>
							</div>

							<div class="col-md-6 col-lg-4">	
								<div class="col-md-6 form_vl"><strong>Customer Contact:</strong></div>	
								<div class="col-md-6 form_vr"><?php echo $customer->customer_contact; ?></div>
							</div>	
							<div class="col-md-6 col-lg-4">	
								<div class="col-md-6 form_vl"><strong>Created:</strong></div>	
								<div class="col-md-6 form_vr"><?php echo $customer->created; ?></div>
							</div>	
							<div class="col-md-6 col-lg-4">			
								<div class="col-md-6 form_vl"><strong>Destination:</strong></div>	
								<div class="col-md-6 form_vr"><?php echo $customer->destination; ?></div>
							</div>
							<!--if Customer Info exists-->
							<?php if( !empty( $customer->adults ) && !empty($customer->hotel_category) ){ ?>
							<div class="col-md-6 col-lg-4">			
								<div class="col-md-6 form_vl"><strong>Whatsapp Number:</strong></div>	
								<div class="col-md-6 form_vr"><?php echo $customer->whatsapp_number; ?></div>
							</div>
							<div class="col-md-6 col-lg-4">			
								<div class="col-md-6 form_vl"><strong>Adults:</strong></div>	
								<div class="col-md-6 form_vr"><?php echo $customer->adults; ?></div>
							</div>
							
							<div class="col-md-6 col-lg-4">
								<div class="col-md-6 form_vl"><strong>Child:</strong></div>	
								<div class="col-md-6 form_vr"><?php echo !empty( $customer->child ) ? $customer->child : "N/A" ; ?></div>
							</div>
							
							<div class="col-md-6 col-lg-4">			
								<div class="col-md-6 form_vl"><strong>Child Age:</strong></div>	
								<div class="col-md-6 form_vr"><?php echo !empty( $customer->child_age ) ? $customer->child_age : "N/A" ; ?></div>
							</div>
							
							<div class="col-md-6 col-lg-4">			
								<div class="col-md-6 form_vl"><strong>Package Type:</strong></div>	
								<?php 
								$pkBy =	$customer->package_type;
								$pack_T = $pkBy == "Other" ? $customer->package_type_other : $pkBy; ?>
								<div class="col-md-6 form_vr"><?php echo $pack_T; ?></div>
							</div>
							
							<div class="col-md-6 col-lg-4">			
								<div class="col-md-6 form_vl"><strong>Total Rooms:</strong></div>	
								<div class="col-md-6 form_vr"><?php echo $customer->total_rooms; ?></div>
							</div>
							
							<div class="col-md-6 col-lg-4">			
								<div class="col-md-6 form_vl"><strong>Travel Date:</strong></div>	
								<div class="col-md-6 form_vr"><?php echo display_date_month_name($customer->travel_date); ?></div>
							</div>
							<div class="col-md-6 col-lg-4">			
								<div class="col-md-6 form_vl"><strong>Pick Up Point:</strong></div>	
								<div class="col-md-6 form_vr"><?php echo $customer->pickup_point; ?></div>
							</div>
							
							<div class="col-md-6 col-lg-4">			
								<div class="col-md-6 form_vl"><strong>Dropping Point:</strong></div>	
								<div class="col-md-6 form_vr"><?php echo $customer->droping_point; ?></div>
							</div>
							
							<div class="col-md-6 col-lg-4">				
								<div class="col-md-6 form_vl"><strong>Package By:</strong></div>
								<?php 
								$cp_type =	$customer->package_car_type;
								$pack_car_type = $cp_type == "Other" ? $customer->package_car_type_other : $cp_type; ?>
								<div class="col-md-6 form_vr"><?php echo $pack_car_type; ?></div>
							</div>
							
							<div class="col-md-6 col-lg-4">			
								<div class="col-md-6 form_vl"><strong>Meal Plan:</strong></div>	
								<div class="col-md-6 form_vr"><?php echo $customer->meal_plan; ?></div>
							</div>
							
							<div class="col-md-6 col-lg-4">			
								<div class="col-md-6 form_vl"><strong>Honeymoon Kit:</strong></div>	
								<div class="col-md-6 form_vr"><?php echo $customer->honeymoon_kit; ?></div>
							</div>
							
							<div class="col-md-6 col-lg-4">			
								<div class="col-md-6 form_vl"><strong>Car Type for sightseeing:</strong></div>	
								<div class="col-md-6 form_vr"><?php echo get_car_name($customer->car_type_sightseen); ?></div>
							</div>
							
							<div class="col-md-6 col-lg-4">			
								<div class="col-md-6 form_vl"><strong>Hotel Category:</strong></div>	
								<div class="col-md-6 form_vr"><?php echo $customer->hotel_category; ?></div>
							</div>
							<div class="col-md-6 col-lg-4">			
								<div class="col-md-6 form_vl"><strong>Budget Approx:</strong></div>	
								<div class="col-md-6 form_vr"><?php echo $customer->budget; ?></div>
							</div>
							<div class="col-md-6 col-lg-4">			
								<div class="col-md-6 form_vl"><strong>Country:</strong></div>	
								<div class="col-md-6 form_vr"><?php echo get_country_name($customer->country_id); ?></div>
							</div>
							<div class="col-md-6 col-lg-4">			
								<div class="col-md-6 form_vl"><strong>State:</strong></div>	
								<div class="col-md-6 form_vr"><?php echo get_state_name($customer->state_id); ?></div>
							</div>
								<?php } ?>
							<div class="col-md-6 col-lg-4">
								<div class="col-md-6 form_vl"><strong>Customer Assign To:</strong></div>	
								<div class="col-md-6 form_vr"><?php echo get_user_name($customer->agent_id); ?></div>
							</div>
							<!--Show agent username if customer is assign by leads team -->
							<?php if( !empty( $customer->assign_by ) ){ ?>
							<div class="col-md-6 col-lg-4">	
								<div class="col-md-6 form_vl"><strong>Customer Assign By:</strong></div>	
								<div class="col-md-6 form_vr"><?php echo get_user_name($customer->assign_by); ?></div>
							</div>
							<?php } ?>
						</div> <!-- row -->
					<!--get itinerary accommodation add/edit buttons-->
					<?php
					$add_acc = "";
					$add_iti = "";
					switch( $customer->cus_status ){
						case 9:
							//check if itinerary created against current leadStatus
							//if iti not booked
							if( get_iti_status( $customer->customer_id ) != 9 ){
								if( is_admin_or_manager_or_sales() ){
									$where3 = array( "customer_id" => $customer->customer_id , "iti_type" => 1 );
									$get_iti = $this->global_model->getdata( "itinerary", $where3 );
									if( !empty( $get_iti ) ){
										$iti_id = $get_iti[0]->iti_id;
										$temp_key = $get_iti[0]->temp_key;
										$pub_status = $get_iti[0]->publish_status;
										
										if( $pub_status == "draft" ){
											$add_iti = "<a href=" . site_url("itineraries/edit/{$iti_id}/{$temp_key}") . " class='btn btn-blue' title='Draft Itinerary'><i class='fa fa-pencil'></i> Edit Itinerary</a>";
										}else{
											$add_iti = "<a href=" . site_url("itineraries/view/{$iti_id}/{$temp_key}") . " class='btn btn-blue' title='View Itinerary'><i class='fa fa-plus'></i> View Itinerary</a>";
										}
										
									}else{						
										$add_iti = "<a href=" . site_url("itineraries/add/{$customer->customer_id}/{$customer->temp_key}") . " class='btn btn-green ajax_additi_table' data-id='{$customer->customer_id}' data-temp_key ='{$customer->temp_key}' title='Add Itinerary'><i class='fa fa-plus'></i> Ready for quotation</a>";
									}	
									//check if Accommodation created against current leadStatus cus
									$where4 = array( "customer_id" => $customer->customer_id , "iti_type" => 2);
									$get_acc = $this->global_model->getdata( "itinerary", $where4 );
									if( !empty( $get_acc ) ){
										$iti_id = $get_acc[0]->iti_id;
										$temp_key = $get_acc[0]->temp_key;
										$pub_status = $get_acc[0]->publish_status;
										if( $pub_status == "draft" ){
											$add_acc = "<a href=" . site_url("itineraries/edit/{$iti_id}/{$temp_key}") . " class='btn btn-blue' title='Draft Accommodation'><i class='fa fa-pencil'></i> Edit Acc.</a>";
										}else{
											$add_acc = "<a href=" . site_url("itineraries/view/{$iti_id}/{$temp_key}") . " class='btn btn-blue' title='View Accommodation'><i class='fa fa-plus'></i> View Acc.</a>";
										}
									}else{	
										$add_acc = "<a href=" . site_url("itineraries/add_accommodation/{$customer->customer_id}/{$customer->temp_key}") . " class='btn btn-green' data-id='{$customer->customer_id}' data-temp_key ='{$customer->temp_key}' title='Add Accommodation Package'><i class='fa fa-plus'></i> Acc. Quotation</a>";
									}	 
								}
							}	
							//$add_acc = "";
							//$add_iti = "";
							$decUserStatus = "<strong class='btn btn-success green'>Lead Approved</strong>";
							break;
						case 8:
							$add_iti = "";
							$add_acc = "";
							$decUserStatus = "<strong class='btn btn-danger'>Lead Declined</strong>";
							break;
						default:
							$add_acc = "";
							$add_iti = "";
							$decUserStatus = "<strong class='btn btn-success'>Working...</strong>";
							break;
					}
					
					//View Buttons
					echo '<div class="clearfix"></div><hr>';
					$c_view = "<a target='_blank' href=" . site_url("customers/view/{$customer->customer_id}/{$customer->temp_key}") . " title='View Customer' class='btn btn-success' ><i class='fa fa-eye'></i> View Customer</a>";
					echo  "<div class=' col-md-12 btn_section text-center margin-top-10'>{$add_iti} {$add_acc} {$decUserStatus} {$c_view}</div>";
					?>
					<div class="clearfix"></div>
					<hr>
				</div><!--end customer info section-->
				
				<!--itineraries section -->
				<div class="col-md-12">
					<div class="iti_section">
						<h3 class='text-center uppercase'>Itineraries Info</h3>
						<?php if( isset( $itineraries ) && !empty( $itineraries ) ){ 
							$index = 1;
						?> 
							<div class="table-responsive">
								<table id="itineraries_tbl" class="table table-striped table-hover">
									<thead>
										<tr>
											<th> # </th>
											<th> Iti Id </th>
											<th> Package Name </th>
											<th> Type </th>
											<th> Pub. Staus </th>
											<th> Temp/Travel Date </th>
											<th> Travel Date </th>
											<th> Created </th>
											<?php if( is_admin_or_manager() ){  ?>
												<th> Agent </th>
											<?php } ?>
											<th> Sent Status </th>
											<th> Action </th>
										</tr>
									</thead>
									<tbody>
										<?php foreach( $itineraries as $iti ){ ?>
										<!--DataTable goes here-->
											<tr>
												<?php 
												$row_delete = $btn_edit="";
													$row_edit = "";
													$btncmt = "";
													$iti_s = "";
													$rev_btn_service = "";
													$amend_btn = "";
													$iti_id = $iti->iti_id;
													$pub_status = $iti->publish_status;
													$key = $iti->temp_key;
													//get discount rate request
													$discount_request = $iti->discount_rate_request;
													$discReq = $discount_request == 1 ? "<strong class='red'> (Price Discount Request) </strong>" : " ";
													
													//Count All Child Itineraries
													$countChildIti = $this->global_model->count_all( 'itinerary', array("parent_iti_id" => $iti_id, "del_status" => 0) );
													
													$childLink = "<a title='View Child Itineraries' href=" . site_url("itineraries/childIti/{$iti_id}/{$key}") . " class='btn btn-success blue' ><i class='fa fa-child' aria-hidden='true'></i></a>";
													
													$showChildItiBtn = $countChildIti > 0 ? $childLink : "";
													
													//get iti_status
													$iti_status = $iti->iti_status;
													if( $pub_status == "publish" ){
														$p_status = "<strong>" . ucfirst($pub_status) . "</strong>";
													}elseif( $pub_status == "price pending" ){
														$p_status = "<strong class='blue'>" . ucfirst($pub_status) . "</strong>";
													}else{
														$p_status = "<strong class='red'>" . ucfirst($pub_status) . "</strong>";
													}
													//Lead Prospect Hot/Warm/Cold
													$cus_pro_status = get_iti_prospect($iti->iti_id);
													if( $cus_pro_status == "Warm" ){
														$l_pro_status = "<strong class='green'> ( " . $cus_pro_status . " )</strong>";
													}else if( $cus_pro_status == "Hot" ){
														$l_pro_status = "<strong class='black'> ( " . $cus_pro_status . " )</strong>";
													}else if( $cus_pro_status == "Cold" ){
														$l_pro_status = "<strong class='red'> ( " . $cus_pro_status . " )</strong>";
													}else{
														$l_pro_status = "";
													}
													
													//Get itinerary type 1=itinerary , 2=accommodation
													$iti_type = $iti->iti_type == 2 ? "<strong class='red'>Accommodation</strong>" : "<strong class='green'>Holiday</strong>";
													
													
													$row[] = $iti_type;
													
													$row[] = $iti->package_name . $l_pro_status;
													
													//Check temp travel date if publish_status != "draft" iti_type = 1 Itinerary , 2 = accommodation
													/* $temp_t_d = "";
													if( $iti->publish_status != "draft" && $iti->iti_type == 1 ){
														$day_wise_meta = !empty( $iti->daywise_meta ) ? unserialize($iti->daywise_meta) : "";
														$temp_t_d = !empty( $day_wise_meta ) && isset( $day_wise_meta[0]['tour_date'] ) ? $day_wise_meta[0]['tour_date'] : "";
													}else if( $iti->publish_status != "draft" && $iti->iti_type == 2  ){
														$temp_t_d = $iti->t_start_date;
													} */
													
													$temp_t_d = $iti->t_start_date;
													
													
													//buttons
													//if price is updated remove edit for agent get_iti_booking_status
													if( $iti->pending_price == 2 && $role == 96 ){
														$btn_edit = "<a title='Edit' href='javascript: void(0)' class='btn btn-success editPop' ><i class='fa fa-pencil' aria-hidden='true'></i></a>";
													}else{
														$btn_edit = "<a title='Edit' href=" . site_url("itineraries/edit/{$iti_id}/{$key}") . " class='btn btn-success' ><i class='fa fa-pencil' aria-hidden='true'></i></a>";
													}
													
													$btnview = "<a target='_blank' title='View' href=" . site_url("itineraries/view_iti/{$iti_id}/{$key}") . " class='btn btn-success' ><i class='fa fa-eye' aria-hidden='true'></i></a>";
													
													$btnview .= "<a target='_blank' title='View Pdf' href=" . site_url("itineraries/pdf/{$iti_id}/{$key}") . " class='btn btn-success' ><i class='fa fa-file-pdf-o' aria-hidden='true'></i></a>";
													
													$btn_view = "<a title='client view' target='_blank' href=" . site_url("promotion/itinerary/{$iti_id}/{$key}") . " class='btn btn-success' >Client view New</a>";
													
													//Show if type=1=itinerary
													if( $iti->iti_type == 1 ){
														$btn_view .= "<a title='client view' target='_blank' href=" . site_url("promotion/package/{$iti_id}/{$key}") . " class='btn btn-success' >Client view</a>";
													}
													
													//clone button
													if( empty( $iti->parent_iti_id ) &&  $countChildIti < 6  && $iti->iti_status == 0  && $iti->email_count > 0 && $pub_status == "publish" ){
														//type 2=accommodation
														if( $iti->iti_type == 2 ){
															$btn_view .= "<a data-customer_id='{$iti->customer_id}' data-iti_id='{$iti_id}' title='Duplicate Accommodation' href=" . site_url("itineraries/duplicate/{$iti_id}") . " class='btn btn-success child_clone' ><i class='fa fa-files-o' aria-hidden='true'></i></a>";
														}else{
															$btn_view .= "<a data-customer_id='{$iti->customer_id}' data-iti_id='{$iti_id}' title='Duplicate Itinerary' href=" . site_url(	"itineraries/duplicate/{$iti_id}") . " class='btn btn-success duplicateItiBtn' ><i class='fa fa-files-o' aria-hidden='true'></i></a>";
														}	
													}	
													
													if( !empty( $iti->client_comment_status ) && $iti->client_comment_status == 1 ){
														$btncmt = "<a data-id={$iti_id} data-key={$key} title='Client Comment' href='javascript:void(0)' class='btn btn-success ajax_iti_status red'><span class='blink'><i class='fa fa fa-comment-o' aria-hidden='true'></i>  New Comment</span></a>";
													}
													
													//if itinerary status is publish
													if( $pub_status == "publish" || $pub_status == "price pending" ){
														//delete itinerary button only for admin
														if( is_admin_or_manager() && empty( $countChildIti ) ){ 
															$row_delete = "<a data-id={$iti_id} title='Delete Itinerary' href='javascript:void(0)' class='btn btn-danger ajax_delete_iti'><i class='fa fa-trash-o' aria-hidden='true'></i></a>";
														}
														//Check for iti status
														if( isset( $iti->booking_status ) && $iti->booking_status != 0 ){
															$it_status = "<a title='itinerary booked' class='btn btn-green' title='Itinerary Booked'>Hold</a>";
															$st = "On Hold";
															$iti_s = isset( $iti->booking_status ) && $iti->booking_status == 0 ? "APPROVED" : "ON HOLD";
														}else if( $iti_status == 9 ){
															$it_status = "<a title='itinerary booked' class='btn btn-green' title='Itinerary Booked'><i class='fa fa-check-circle-o' aria-hidden='true'></i></a>";
															$st = "<i title='itinerary booked' class='fa fa-check-circle-o' aria-hidden='true'></i>";
															$iti_s = "APPROVED";
														}else if( $iti_status == 7 ){
															$it_status = "<a title='itinerary declined' class='btn btn-danger'><i class='fa fa-ban' aria-hidden='true'></i></a>";
															$st = "<i title='itinerary declined' class='fa fa-ban' aria-hidden='true'></i>";
															$iti_s = "DECLINED";
														}else if( $iti_status == 6 ){
															$it_status = "<a title='Itinerary Rejected' class='btn btn-danger'><i class='fa fa-ban' aria-hidden='true'></i></a>";
															$st = "<span title='Itinerary Rejected' class='rejected_iti'>Rejected</span>";
															$iti_s = "REJECTED";
														}else{
															$it_status = "<a title='working...' class='btn btn-success'><i class='fa fa-tasks' aria-hidden='true'></i></a>";
															$st = "<i title='working...' class='fa fa-tasks' aria-hidden='true'></i>";
															
															$iti_s = empty( $iti->followup_id ) ? "NOT PROCESS" : "WORKING";
														}
														
														//Amendment Btn
														if( ( is_admin_or_manager() || is_salesteam() ) && $iti->is_amendment == 1 ){
															$amendment_id = $this->global_model->getdata( 'iti_amendment_temp', array("iti_id" => $iti_id), "id" );
															$amend_btn = " <a href='" . base_url("itineraries/view_amendment/{$amendment_id}") ."' class='btn btn-success' title='Click to view amendment itinerary'>View Amendment</a>";
															$amend_btn = !empty( $amendment_id ) ? $amend_btn : "";
														}else if( $iti->is_amendment == 2 ){
															$amend_btn = "<span class='btn btn-danger'>Revised</span>";
															$rev_btn_service = "<span class='btn btn-danger'>Revised</span>";
														}
														
														//show only view button for sales team
														if( $role == 97 ){
															$btns = $btnview;
														}else{
															$allBtns = $btncmt. $btn_edit . $btnview. $btn_view . $row_delete . $it_status . $showChildItiBtn;
															$btns = "<a href='' class='btn btn-success optionToggleBtn'>View</a><div class='optionTogglePanel'>{$allBtns}</div>" . $st . $showChildItiBtn . $amend_btn;
														}	
													}else{ 
														//if itinerary in draft hide buttons for sales team
														$btns =  $btn_edit . "
															<a data-id={$iti_id} title='Delete Itinerary Permanent' href='javascript:void(0)' class='btn btn-danger delete_iti_permanent'><i class='fa fa-trash-o' aria-hidden='true'></i></a>";
													}
													
													//get iti sent status
													$iti_sent = $iti->email_count;
													$sent_status = $iti_sent > 0 ? "$iti_sent Time Sent" : "Not Sent"; 
				
													//Booked iti travel date
													$travel_date = get_travel_date( $iti->iti_id);
													//print data
													echo "<td>" . $index . "</td>";
													echo "<td>" . $iti->iti_id . "</td>";
													echo "<td>" . $iti->package_name . "</td>";
													echo "<td>" . $iti_type . "</td>";
													echo "<td>" . $p_status . " " . $discReq . "</td>";
													echo "<td>" . $temp_t_d . "</td>";
													echo "<td>" . $travel_date . "</td>";
													echo "<td>" . $iti->added . "</td>";
													if( $role != 96 ){
														echo "<td>" .  get_user_name( $iti->agent_id ) . "</td>";
													}
													echo "<td>". $btns ."</td>";	
													echo "<td>". $sent_status ."</td>";	
												?>
											</tr>
										<?php 
											$index++;
										} ?>
									</tbody>
								</table>
							</div><!--end table-->
						<?php }else{
							echo "<div class='alert alert-info'>No Itineraries Found!</div>";
						} ?>
					</div>
				</div><!--end itineraries section -->
				<div class="clearfix"></div>
				<!--followup section -->
				<hr>
				<div class="col-md-12">
					<div class="col-md-6">
					<h3 class="text-center uppercase">Take Follow up</h3>
					<div class="customer_followup text-center">
						<!-- Process for customer followup  -->
						<?php if( is_admin_or_manager_or_sales() && $customer->cus_status == 0 ){ ?>
							<div id="customer_f" class="col-md-12 clearfix" style="display: block;">
								<a class="btn btn-danger" href="#" id="add_call_btn" title="Back">Add Call Info</a>
								<div class="call_log" id="call_log_section"><!--lead followup-->
									<form id="call_detais_form" class="lead_frm">
									<!-- #lead_frm .spinner_load-->
										<div class="frm_section">
											<div class = "spinner_load"  style = "display: none;">
												<i class="fa fa-refresh fa-spin fa-3x fa-fw" ></i>
												<span class="sr-only">Loading...</span>
											</div>
										<div class="call_type_seciton">
											<label class="radio-inline">
												<input data-id="picked_call_panel" required id="picked_call" class="radio_toggle" type="radio" name="callType" value="Picked call">Picked call
											</label>
											<label class="radio-inline"><input class="radio_toggle" data-id="call_not_picked_panel" required id="call_not_picked" type="radio" name="callType" value="Call not picked">Call not picked</label>
											<label class="radio-inline"><input class="radio_toggle" data-id="close_lead_panel" required id="close_lead" type="radio" name="callType" value="8">Decline</label>
										</div>	
										
										<div id="panel_detail_section">
											<div class="call_type_res col-md-12" id="picked_call_panel"><!--picked call panel-->
												<div class="col-md-">
													<div class="form-group">
													  <label for="comment">Call summary<span style="color:red;">*</span>:</label>
													  <textarea required class="form-control" rows="3" name="callSummary" id="callSummary"></textarea>
													</div> 
												</div>
												<div class="col-md-">
													<div class="form-group">
														<label>Lead prospect<span style="color:red;">*</span></label>
														<select required class="form-control" name="txtProspect">
															<option value="Hot">Hot</option>
															<option value="Warm">Warm</option>
															<option value="Cold">Cold</option>
														</select>
													</div>
												</div>
												<div class="col-md-">
													<div class="checkbox1">
														<label><input id="nxtCallCk" type="radio" class="book_query" name="book_query" required value=""> Next call time</label>
													</div>
													<div id="next_call_cal">
														<label>Next calling time and date<span style="color:red;">*</span>:</label> 
														<input size="16" required type="text" value="" name="nextCallTime" readonly class="form-control form_datetime">  
													</div>	
												</div>
												<div class="col-md-">
													<label for="readyQuotation"><input id="readyQuotation" class="book_query" name="book_query" required type="radio" value="9"> Ready for quotation</label>
												</div>
												
												<!--Quotation Type Holidays/Accommodation/Cab-->
												<div id="quotation_type_section">
													<label class="radio-inline" for="holidays"><input id="holidays" class="quotation_type" name="quotation_type" required type="radio" value="holidays"> Holidays </label>
													<label class="radio-inline" for="accommodation"><input id="accommodation" class="quotation_type" name="quotation_type" required type="radio" value="accommodation"> Accommodation </label>
													<!--label class="radio-inline" for="cab_b"><input id="cab_b" class="quotation_type" name="quotation_type" required type="radio" value="cab"> Cab Booking </label-->
												</div>
											</div><!--end picked call panel-->
											<div class="call_type_res" id="call_not_picked_panel"><!--call_not_picked panel-->
												<div class="col-md-12">
													<label class="radio-inline">
														<input required type="radio" name="callSummaryNotpicked" class="call_type_not_answer" value="Switched off">Switched off
													</label>
													<label class="radio-inline">
														<input required type="radio" name="callSummaryNotpicked" class="call_type_not_answer" value="Not reachable">Not reachable
													</label>
													<label class="radio-inline">
														<input required type="radio" name="callSummaryNotpicked" class="call_type_not_answer" value="Not answering">Not answering
													</label>
													<label class="radio-inline">
														<input required type="radio" name="callSummaryNotpicked" class="call_type_not_answer" value="Number does not exists">Number does not exists
													</label>
													<div class="clearfix"></div>
													<div class="col-md-12">
														<div class="row">
															<div class="col-md-">
																<div class="form-group">
																  <label for="comment">Comment<span style="color:red;">*</span>:</label>
																  <textarea required class="form-control" rows="3" name="comment" id="comment"></textarea>
																</div> 
															</div>
														</div>	
													</div>	
													<div class="clearfix"></div>
													<div class="col-md-12">
													<div class="row">
													<div class="nxt_call">
														<div class="form-group">
															<label>Next calling time and date<span style="color:red;">*</span>:</label> 
															<input size="16" required type="text" value="" readonly name="nextCallTimeNotpicked" class="form-control form_datetime"> 
														</div>
														
														<div class="form-group">
															<label>Lead prospect<span style="color:red;">*</span></label>
															<select required class="form-control" name="txtProspectNotpicked">
																<option value="Hot">Hot</option>
																<option value="Warm">Warm</option>
																<option value="Cold">Cold</option>
															</select>
														</div>
													</div>	
													</div>	
													</div>
												</div>
											</div>
											<!--end call not picked panel-->	
											<!--close_lead_panel panel-->
											<div class="call_type_res" id="close_lead_panel">
												<div class="form-group col-md-12">
													<select required class="form-control" name="decline_reason">
														<option value="">Select Reason</option>
														<option value="Booked with someone else">Booked with someone else</option>
														<option value="Not interested">Not interested</option>
														<option value="Not answering call from 1 week">Not answering call from 1 week</option>
														<option value="Plan cancelled">Plan cancelled</option>
														<option value="Wrong number">Wrong number</option>
														<option value="Denied to post lead">Denied to post lead</option>
														<option value="Other">Other</option>
													</select>
												</div>
												<div class="clearfix"></div>
												<div class="col-md-12">
													<div class="form-group">
														<label for="comment">Decline Comment:</label>
														<textarea class="form-control" rows="3" required name="decline_comment" id="decline_comment"></textarea>
													</div> 
												</div>
											</div><!--end close_lead_panel-->	
										</div><!--panel_section end-->
										<div class="clearfix"></div>
										<div id="customer_info_panel">
										<div class="clearfix"></div>
											<div class="col-lg-6 col-md-6">
											<div class="form-group">
												<label for="">Whatsapp Number:</label>
												<input type="text" class="form-control" placeholder="Whatsapp Number" name="whatsapp_number" value="">
											</div>
											</div>
											<div class="col-lg-6 col-md-6">
											<div class="form-group">
												<label for="">Adults *:</label>
											  <input required type="text" class="form-control" placeholder="No. of Adults" name="adults" value="">
											</div>
											</div>
											
											<div class="col-lg-6 col-md-6">
											<div class="form-group">
												<label for="">Child:</label>
												<input type="text" class="form-control" placeholder="No. of child" name="child" value="">
											</div>
											</div>
											<div class="col-lg-6 col-md-6">
											<div class="form-group">
												<label for="">Age of the child:</label>
												<input type="text" class="form-control" placeholder="Child age. eg: 13,12" name="child_age" value="">
											</div>
											</div>
											
											<div class="col-lg-6 col-md-6">
											<div class="form-group row">
											<div class="col-sm-6">
												<label for="">Your Package Type *:</label>
												<select required name="package_type" class="form-control">
													<option value="">Choose Package Type</option>
													<option value="Honeymoon Package">Honeymoon Package</option>
													<option value="Fixed Departure">Fixed Departure</option>
													<option value="Group Package">Group Package</option>
													<option value="Other">Other</option>
												</select>
											</div>
											<div class="col-sm-6">
											<label for="">&nbsp;</label>
												<input type="text" required class="form-control" name="package_type_other" id="pack_type_other">
											</div>
											
											</div>
											</div>
											<div class="col-lg-6 col-md-6">
											<div class="form-group">
												<label for="">No. of rooms *:</label>
												<select required name="total_rooms" class="form-control">
													<option value="">Select Rooms</option>
													<?php 
														for( $i=1 ; $i <=20 ; $i++ ){
															echo "<option value='{$i}'>{$i}</option>";
														}
													?>
												</select>
											</div>
											</div>
											
											<div class="col-lg-6 col-md-6">
											<div class="form-group">
												<label for="">Travel Date *:</label>
												<input required type="text" class="form-control" readonly id="travel_date" name="travel_date" value="">
											</div>
											</div>
											<div class="clearfix"></div>
											<div class="col-lg-6 col-md-6">
											<div class="form-group">
												<label for="">Destination *:</label>
												<input required type="text" class="form-control" name="destination" value="">
											</div>
											</div>
											
											<div class="col-lg-6 col-md-6 hide_accommodation">
											<div class="form-group">
												<label for="">Pick Up Point *:</label>
												<input required type="text" class="form-control" name="pick_point" value="">
											</div>
											</div>
											<div class="clearfix"></div>
											<div class="col-lg-6 col-md-6 hide_accommodation" >
											<div class="form-group">
												<label for="">Dropping Point *:</label>
												<input required type="text" class="form-control" name="drop_point" value="">
											</div>
											</div>
											
											<div class="col-lg-6 col-md-6 hide_accommodation">
											<div class="form-group row">
												<div class="col-sm-6">
												<label for="">Package By *:</label>
												<select required name="package_by" class="form-control">
													<option value="">Choose Package By</option>
													<option value="Car">Car</option>
													<option value="Volvo">Volvo</option>
													<option value="Other">Other</option>
												</select>
												</div>
												<div class="col-sm-6">
													<label for="">&nbsp;</label>
													<input type="text" required class="form-control" name="package_by_other" id="other_pack">
												</div>	
											</div>
											</div>
											<div class="clearfix"></div>
											<div class="col-lg-6 col-md-6">
											<div class="form-group">
												<label for="">Meal Plan *:</label>
												<select required name="meal_plan" class="form-control">
													<option value="">Choose Meal Plan</option>
													<option value="Breakfast Only">Breakfast Only</option>
													<option value="Breakfast & Dinner">Breakfast & Dinner</option>
													<option value="Breakfast, Lunch & Dinner">Breakfast, Lunch & Dinner</option>
													<option value="Dinner Only">Dinner Only</option>
													<option value="No Meal Plan">No Meal Plan</option>
												</select>
											</div>
											</div>
											
											
											<div class="col-lg-6 col-md-6">
											<div class="form-group">
												<label for="">Honeymoon Kit *:</label>
												<input type="text" class="form-control" placeholder="" name="honeymoon_kit" value="">
											</div>
											</div>
											<div class="clearfix"></div>
											<div class="col-lg-6 col-md-6 hide_accommodation">
											<div class="form-group">
												<label for="">Car type for sightseeing *:</label>
												<select required name="car_type_sightseen" class="form-control">
													<option value="">Choose Car Category</option>
													<?php $cars = get_car_categories(); 
														if( $cars ){
															foreach($cars as $car){
																echo '<option value = "'.$car->id .'" >'.$car->car_name.'</option>';
															}
														}
													?>
												</select>
											</div>
											</div>
											
											<div class="col-lg-6 col-md-6">
											<div class="form-group">
												<label for="">Hotel type *:</label>
												<select required name="hotel_type" class="form-control">
													<option value="">Choose Hotel Category</option>
													<option value="Deluxe">Deluxe</option>
													<option value="Super Deluxe">Super Deluxe</option>
													<option value="Luxury">Luxury</option>
													<option value="Super Luxury">Super Luxury</option>
												</select>
											</div>
											</div>
											<div class="clearfix"></div>
											<div class="col-lg-6 col-md-6">
												<div class="form-group">
													<label class="control-label">Select Country*</label>
													<select required name="country" class="form-control country">
														<option value="">Choose Country</option>
														<?php $country = get_country_list();
														if($country){
															foreach( $country as $c ){
																//$selected = $c->id == 101 ? "selected" : ""; 
																echo "<option value={$c->id}>{$c->name}</option>";
															}
														}
														?>
													</select>
												</div>
											</div>
											<div class="col-lg-6 col-md-6">
												<div class="form-group">
													<label class="control-label">Select State*</label>
													<select required name="state" class="form-control state">
														<option value="">Choose State</option>
														<?php $states = get_indian_state_list();
														if($states){
															foreach( $states as $state ){
																echo "<option {$selected} value={$state->id}>{$state->name}</option>";
															}
														}
														?>
													</select>
												</div>
											</div>
											<div class="clearfix"></div>
											<div class="col-lg-6 col-md-6">
											<div class="form-group">
												<label for="">Budget Approx *:</label>
												<select required name="budget" class="form-control">
													<option value="">Choose Budget</option>
													<option value="0-5000">0-5000</option>
													<option value="5001-15000">5001 - 15000</option>
													<option value="15001-30000">15001 - 30000</option>
													<option value="30001-50000">30001 - 50000</option>
													<option value="50001-100000">50001 - 100000</option>
													<option value="100001-150000">100001 - 150000</option>
													<option value=">150000">>150000</option>
												</select>
											</div>
											</div>
										</div><!--End customer info Section-->
										<div class="clearfix"></div>
										</div>
										<input type="hidden" name="customer_id" value="<?php echo $customer->customer_id; ?>" id="customer_id_followup">
										<input type="hidden" name="agent_id" value="<?php echo $customer->agent_id; ?>">
										<div class="clearfix"></div>
										<div class="margiv-top-10">
											<button type="submit" id="submit_frm" class="btn green uppercase submit_frm">Submit</button>
											<button class="btn red uppercase cancle_bnt">Cancel</button>
										</div>
										<div class="clearfix"></div>
										<div id="resp"></div>
									</form>
								</div>
						</div><!--end customer followup status-->
						<!--if customer status 9 show iti followup -->
						<?php }else if( $customer->cus_status == 8 ){ ?>
							<div class="alert alert-danger">LEAD DECLINED</div>
						<?php }else if( isset($itineraries[0]->iti_status) && $itineraries[0]->iti_status == 9 ){ ?>
							<div class="alert alert-success">LEAD APPROVED</div>
						<?php }else if( $customer->cus_status == 9 && isset( $itineraries ) && !empty( $itineraries ) && $itineraries[0]->iti_status != 7  && $itineraries[0]->iti_status != 9 && is_admin_or_manager_or_sales() )
						{ ?>
							<a class="btn btn-danger" href="#" id="add_call_btn" title="Back">Add Call Info</a>
							<div class="call_log" id="call_log_section">
								<form id="iti_call_detais_form" enctype="multipart/form-data">
								<div class="frm_section">
									<div class = "spinner_load"  style = "display: none;">
										<i class="fa fa-refresh fa-spin fa-3x fa-fw" ></i>
										<span class="sr-only">Loading...</span>
									</div>
									<div class="call_type_seciton">
										<label class="radio-inline">
											<input data-id="picked_call_panel" required id="picked_call" class="radio_toggle" type="radio" name="callType" value="Picked call">Picked call
										</label>
										<label class="radio-inline">
											<input class="radio_toggle" data-id="call_not_picked_panel" required id="call_not_picked" type="radio" name="callType" value="Call not picked">Call not picked</label>
										<label class="radio-inline">
											<input class="radio_toggle" data-id="close_lead_panel" required id="close_lead" type="radio" name="callType" value="Close lead">Decline Itinerary</label>
										<label class="radio-inline">
											<input class="radio_toggle" data-id="booked_lead_panel" required id="booked_lead" type="radio" name="callType" value="Booked lead">Booked Itinerary</label>
										<!--iti id listing-->
										<div class="form-group col-md-12">
											<label for="usr">Iti Id<span style="color:red;"> *</span>:</label>
											<select required class="form-control" name="iti_id">
												<option value="">Select Iti ID</option>
												<?php if( isset( $itineraries ) && !empty( $itineraries ) ){
													foreach( $itineraries as $iti_list ){
														//iti_status == 9 or 7 (approved/declined)
														if( $iti_list->iti_status == 9 || $iti_list->iti_status == 7 ) continue;
														$iti_id 		= $iti_list->iti_id;
														$package_name 	= $iti_list->package_name;
														$iti_type = $iti_list->iti_type == 2 ? "Accommodation" : "Holidays";
														$op_name	= $iti_id . "( " . $iti_type . " )";
														echo "<option value={$iti_id}>{$op_name}</option>";
													}
												} ?>
											</select>
										</div>
									</div>
									<div id="panel_detail_section">
										<div class="call_type_res" id="picked_call_panel"><!--picked call panel-->
											<div class="col-md-6">
												<div class="form-group">
												  <label for="comment">Call summary<span style="color:red;">*</span>:</label>
												  <textarea required class="form-control" rows="3" name="callSummary" id="callSummary"></textarea>
												</div> 
											</div>
											<div class="col-md-3">
												<div class="checkbox">
													<label><input id="nxtCallCk" type="checkbox" value="">Next call time</label>
												</div>
												<div id="next_call_cal">
													<label>Next calling time and date<span style="color:red;">*</span>:</label> 
													<input size="16" required type="text" value="" name="nextCallTime" readonly class="form-control form_datetime">  
												</div>	
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<label>Lead prospect<span style="color:red;">*</span></label>
													<select required class="form-control" name="txtProspect">
														<option value="Hot">Hot</option>
														<option value="Warm">Warm</option>
														<option value="Cold">Cold</option>
													</select>
												</div>
											</div>
										</div><!--end picked call panel-->
										<div class="call_type_res" id="call_not_picked_panel"><!--call_not_picked panel-->
											<div class="col-md-12">
												<label class="radio-inline">
													<input required type="radio" name="callSummaryNotpicked" class="call_type_not_answer" value="Switched off">Switched off
												</label>
												<label class="radio-inline">
													<input required type="radio" name="callSummaryNotpicked" class="call_type_not_answer" value="Not reachable">Not reachable
												</label>
												<label class="radio-inline">
													<input required type="radio" name="callSummaryNotpicked" class="call_type_not_answer" value="Not answering">Not answering
												</label>
												<div class="nxt_call">
													<div class="col-md-6">
														<label>Next calling time and date<span style="color:red;">*</span>:</label> 
														<input size="16" required type="text" value="" readonly name="nextCallTimeNotpicked" class="form-control form_datetime"> 
													</div>
													
													<div class="col-md-6">
														<div class="form-group">
															<label>Lead prospect<span style="color:red;">*</span></label>
															<select required class="form-control" name="txtProspectNotpicked">
																<option value="Hot">Hot</option>
																<option value="Warm">Warm</option>
																<option value="Cold">Cold</option>
															</select>
														</div>
													</div>
												</div>
												<div class="clearfix"></div>
												<div class="col-md-6">
													<div class="row">
														<div class="col-md-">
															<div class="form-group">
															  <label for="comment">Comment<span style="color:red;">*</span>:</label>
															  <textarea required class="form-control" rows="3" name="comment" id="comment"></textarea>
															</div> 
														</div>
													</div>	
												</div>	
											
											</div>
										</div><!--end call not picked panel-->	
										<!--booked_lead_panel panel If itinerary booked-->
										<div class="call_type_res" id="booked_lead_panel" >
											<div class="col-md-12">
												<div class="call_type_secitontest">
													<label class="radio-inline">
														<input required class="is_travel_date" type="radio" name="is_travel_date" value="fixed">Fixed Travel Date
													</label>
													<label class="radio-inline">
														<input required class="is_travel_date" type="radio" name="is_travel_date"  value="notfixed">Not Fixed Travel Date
													</label>
												</div>
											</div>
											<div class="clearfix"></div>
											<div class="booking_section" style="display:none;">
												<?php 
													$get_iti_package_category = get_iti_package_category();
												?>
												
													
													<div class="form-group col-md-6">
														<label for="usr">Package Category<span style="color:red;"> *</span>:</label>
														<select required class="form-control" name="approved_package_category">
															<option value="">Select package category</option>
															<?php if($get_iti_package_category){
																foreach( $get_iti_package_category as $book_cat ){
																	echo "<option value='{$book_cat->name}'>{$book_cat->name}</option>";
																}
															} ?>
														</select>
													</div>
													<div class="form-group col-md-6">
														<label class=""><strong>Booking Date*:</strong></label>
														<input required readonly="readonly" data-date-format="yyyy-mm-dd" class="input-group form-control" id= "booking_date" type="text" value="" name="booking_date"  />
													</div>
													<?php $get_tax = get_tax();
													$tax = !empty( $get_tax ) ? trim($get_tax) : 0;	?>
													
													<div class="form-group col-md-6">
														<label for="usr">Package Cost<span style="color:red;"> *</span>:</label>
														<input type="number" required name="before_gst_final_amount" class="form-control" data-tax="<?php echo $tax; ?>" id="fnl_amount" placeholder="Total Package Cost" />
													</div>
													
													<div class="form-group col-md-6">
														<label for="usr">Add GST <span style="color:red;"> (<?php echo $tax; ?>% Extra)</span>:</label>
														<input type="checkbox" id ="tx" name="is_gst" class="form-control" />
													</div>
													
													<div class="form-group col-md-6">
														<label for="usr">Total Package Cost<span style="color:red;"> *</span>:</label>
														<input type="number" readonly required class="form-control" id="fnl_amount_tax" title="Total package cost after inc. tax" placeholder="Total package cost after inc. tax" name="final_amount" >
													</div>
													
													<div class="clearfix"></div>
													<div class="form-group col-md-6">
														<label class=""><strong>Advance Received:</strong>* <span id="fiftyPer"></span></label>
														<input required type="number" id="pack_advance_recieve" name="advance_recieve" placeholder="Advance Received. eg: 5000" class="form-control" value="">
													</div>
													
													
													<div class="form-group col-md-6">
														<label class=""><strong>Transaction Date(1st installment):</strong> *</label>
														<input required readonly="readonly" data-date-format="yyyy-mm-dd" class="input-group form-control transaction_date" id="transaction_date" type="text" value="" name="transaction_date"  />
													</div>
													<div class="clearfix"></div>
													
													<!--Payment Details -->
													<div id="due_payment_section">
														<div class="form-group col-md-6">
															<label class=""><strong>Second Installment Amount:</strong></label>
															<input type="text" readonly id="next_pay_balance" data-date-format="yyyy-mm-dd" name="next_payment_bal" placeholder="Second Payment Balance" class="form-control" value="">
														</div>
														
														<div class="form-group col-md-6">
															<label class=""><strong>Second Installment Due Date:</strong></label>
															<input readonly="readonly"  data-date-format="yyyy-mm-dd" class="input-group form-control date_picker" id="next_payment_date" type="text" value="" name="next_payment_date"  />
														</div>
														
														<div class="form-group col-md-6">
															<label class=""><strong>3rd Installment Amount:</strong><span id="pendingBal"></span></label>
															<input type="number" readonly id="third_payment_bal" name="third_payment_bal" placeholder="Third Payment Amount" class="form-control" value="">
														</div>
														
														<div class="form-group col-md-6">
															<label class=""><strong>3rd Installment Due Date:</strong></label>
															<input readonly="readonly" data-date-format="yyyy-mm-dd" class="input-group form-control date_picker_validation date_picker" id="third_payment_date" type="text" value="" name="third_payment_date"  />
														</div>
														
														<div class="form-group col-md-6">
															<label class=""><strong>Final Installment:</strong></label>
															<input type="number" readonly id="final_payment_bal" name="final_payment_bal" placeholder="Final Installment Amount" class="form-control" value="">
														</div>
														
														<div class="form-group col-md-6">
															<label class=""><strong>Final Installment Due Date:</strong></label>
															<input readonly="readonly" data-date-format="yyyy-mm-dd" class="input-group form-control date_picker_validation date_picker" id="final_payment_date" type="text" value="" name="final_payment_date"  />
														</div>
													</div>	
													<div class="form-group col-md-6">
														<label class=""><strong>Total Balance Remaining:</strong></label>
														<input type="text" required readonly id="balance_pay" name="total_balance" placeholder="" class="form-control" value="">
													</div>
													<div class="form-group col-md-6" id="ttravel_date">
														<label class=""><strong>Travel Date*:</strong></label>
														<input readonly="readonly" required data-date-format="yyyy-mm-dd" class="input-group form-control date_picker" id="travel_date_iti" type="text" value="" name="travel_date"  />
													</div>
													<div class="form-group col-md-6">
														<div class="form-group2">
															<label class=" "><strong>Bank Name*:</strong></label>
															<input required class="form-control" id="bank_name" type="text" placeholder="eg: HDFC, ICIC" name="bank_name" value="">
														</div>	 
													</div>
													<div class="form-group col-md-6">
														<label for="usr">Please Enter Approval Note:<span style="color:red;"> *</span>:</label>
														<textarea required class="form-control" placeholder="Please Enter Approval Note" name="iti_note_booked" ></textarea>
													</div>
													<div class="clearfix"></div>
													<!--upload aadhar card section-->
													<div class="form-group col-md-6">
														<div class="form-group2">
															<label class=" "><strong>Client Aadhar Card:</strong> <span class="red" style="font-size: 10px;">(Max size 2 MB) </span></label>
															<input class="form-control" id="client_aadhar_card" type="file" name="client_aadhar_card">
														</div>	 
														<img id="client_aadhar_card_priview" style="display: none;" width="100" height="100" />
													</div><!--end upload aadhar card section-->
													<!--upload aadhar Payment card section-->
													<div class="form-group col-md-6">
														<div class="form-group2">
															<label class=" "><strong>Payment Screenshot*:</strong> <span class="red" style="font-size: 10px;">(Max size 2 MB) </span></label>
															<input required class="form-control" id="payment_screenshot" type="file" name="payment_screenshot">
														</div>	 
														<img id="payment_screenshot_priview" style="display: none;" width="100" height="100" />
													</div>
													<div class="clearfix"></div>
												<div class="col-md-12 other_docs">
													<a href="javascript:;" id="add_other_docs_btn" class="btn btn-success mt-repeater-add addrep">
													<i class="fa fa-plus"></i> Add Other Docs</a><span class="red" style="font-size: 10px;"> Please upload only ( jpg|jpeg|png|pdf ) files and not more than 2MB.</span>
													<div class="other_docs_sec" style="display:none;">
														<div class="col-md-4">
															<div class="form-group2">
																<label class=" "><strong>Other Documents:</strong></label>
																<input class="form-control" required type="file" name="iti_clients_docs[]">
															</div>	
														</div>
														<div class="col-md-4">													
															<label class=" "><strong>Document Title:</strong></label>
															<input class="form-control" required type="text" name="doc_comment[]">
														</div>
														<div class="col-md-4">		
															<div class="mt-repeater-input margin-top-20" >
																<a href="javascript:;" data-repeater-delete class="btn btn-danger del_upload" style="position:relative;">
																<i class="fa fa-close"></i> Delete</a>
															</div>														
														</div>
														<div class="clearfix"></div>
													</div>	
													<div class="clearfix"></div>
												</div>
											</div>
											<!--End Payment Details -->
										</div><!--end booked_lead panel-->	
										
										<div class="call_type_res" id="close_lead_panel"><!--close_lead_panel panel-->
											<div class="form-group col-md-6">
												<select required class="form-control" name="iti_note_decline">
													<option value="">Select Reason</option>
													<option value="Booked with someone else">Booked with someone else</option>
													<option value="Not interested">Not interested</option>
													<option value="Price is high">Price is high</option>
													<option value="Not answering call from 1 week">Not answering call from 1 week</option>
													<option value="Plan cancelled">Plan cancelled</option>
													<option value="Wrong number">Wrong number</option>
													<option value="Denied to post lead">Denied to post lead</option>
													<option value="Other">Other</option>
												</select>
											</div>
											<div class="clearfix"></div>
											<div class="form-group col-md-6">
												<div class="form-group">
													<label for="comment">Decline Comment:</label>
													<textarea class="form-control" rows="3" name="decline_comment" id="decline_comment"></textarea>
												</div> 
											</div>
										</div><!--end close_lead_panel-->	
									</div><!--panel_section end-->
									
									<!--input type="hidden" name="iti_id" id="hid_iti_id" value="<?php //echo $itineraries[0]->iti_id; ?>"-->
									<!--input type="hidden" name="temp_key" id="hid_temp_key" value="<?php //echo $itineraries[0]->temp_key; ?>"-->
									<!--input type="hidden" name="customer_id" value="<?php //echo $customer->customer_id; ?>"-->
									<!--input type="hidden" name="parent_iti_id" value="<?php //echo $itineraries[0]->parent_iti_id; ?>"-->
									<input type="hidden" name="agent_id" value="<?php echo $customer->agent_id; ?>">
									<!--input type="hidden" name="iti_type" value="<?php //echo $itineraries[0]->iti_type; ?>"-->
									<div class="clearfix"></div>
								</div><!--booking section-->
								<div class="clearfix"></div>
								<hr>
									<div class="margiv-top-10">
										<button type="submit" id="submit_frm" class="btn green uppercase submit_frm">Submit</button>
										<button class="btn red uppercase cancle_bnt">Cancel</button>
									</div>
									<div class="resPonse"></div>
								</form>
							</div><!--end iti followup section-->
						<?php }else{
							echo "<div class='alert alert-info'>Lead approved to take next followup you need to create itinerary.</div>";
						} ?>
					</div>
					</div>
					<div class="col-md-6"><!--leads followup details-->
						<h3 class="text-center uppercase">Follow up history</h3>
						<div class="iti_leads_followup_section">
							<?php if( isset( $itineary_followup ) && !empty( $itineary_followup ) ){
									$count = 1;
									$iti_html = "";
									foreach( $itineary_followup as $iti_follow ){
										$c_type = $iti_follow->callType;
										$call_time_i = display_month_name_with_time($iti_follow->currentCallTime);
										$link = iti_view_link( $iti_follow->iti_id  );
										$view_btn_i = "<a href='{$link}' target='_blank' class='btn-blue' title='View'><i class='fa fa-plus'></i> View</a>";
										
										if( $c_type == "Booked lead" ){
											$callType_status = "<strong class='green'>{$c_type}</strong>";
										}elseif( $c_type == "Close lead" ){
										$callType_status = "<strong class='red'>{$c_type}</strong>";
										}else{
											$callType_status = $c_type;
										}
										
										$iti_html .= "
										<div class='col-md-12 col-lg-12'>
													<div class='mt-element-list'>	
													
														<div class='mt-list-container list-todo' id='accordion1' role='tablist' aria-multiselectable='true'>
													<div class='list-todo-line'></div>
													<ul>
														<li class='mt-list-item'>
															<div class='list-todo-icon bg-white font-green-meadow'>
																<i class='fa fa-clock-o'></i>
															</div>
															<div class='list-todo-item green-meadow'>
																<a class='list-toggle-container' data-toggle='collapse' data-parent='#accordion1' onclick=' ' href='#task_iti-{$count}' aria-expanded='false'>
																	<div class='list-toggle done uppercase'>
																		<div class='list-toggle-title bold'>Call Time: {$call_time_i}</div>

																	</div>
																</a>
																<div class='note note-success'>
																		<div class='list-toggle-title '>{$view_btn_i  }<span></span><span><b>  Iti Id: </b></span>{$iti_follow->iti_id}<span><b>  Status: </b></span>{$callType_status}
																			</div>

																	</div>
																<div class='task-list panel-collapse collapse' id='task_iti-{$count}'>
																	<ul>
																		<li class='task-list-item done'>
																			<div class='task-icon'><a href='javascript:;'><i class='fa fa-phone'></i></a></div>

																			<div class='task-content'>
																				<h4 class='uppercase bold'>
																					<a href='javascript:;'>{$callType_status}</a>
																				</h4>
																	<p><strong>Itinerary Id:</strong>{$iti_follow->iti_id}</p>
																		<p><strong>{$callType_status}</strong></p>
																		<p><strong>Call summary:{$iti_follow->callSummary}</p>
																		<p><strong>Next Call Time:</strong>{$iti_follow->nextCallDate}</p>
																		<p><strong>Comment: {$iti_follow->comment}</strong></p>
																		<p><strong>{$iti_follow->itiProspect}</strong></p>
																			</div>
																		</li>
																	</ul>
																</div>
															</div>
														</li>
													</ul>
												</div>
											</div>
										</div>
									";
										$count++;
									}
									echo $iti_html;
							} ?>
							
							<?php if( isset( $lead_followup ) && !empty( $lead_followup ) ){
								$count = 1;
								$cus_html = "";
								foreach( $lead_followup as $cus_follow ){
									$c_type = $cus_follow->callType;
									$link = customer_view_link( $cus_follow->customer_id  );
									$view_btn = "<a href='{$link}' target='_blank' class='btn btn-blue' title='View'><i class='fa fa-plus'></i> View</a>";
									
									$call_time = display_month_name_with_time($cus_follow->currentCallTime);
									
									if( $c_type == 9 ){
										$callType_status = "<strong class='green'>Approved</strong>";
									}elseif( $c_type == 8 ){
										$callType_status = "<strong class='red'>Decline</strong>";
									}else{
										$callType_status = $c_type;
									}
									$cus_html .= "<div class='col-md-12 col-lg-12'>
												<div class='mt-element-list'>			 
													<div class='mt-list-container list-todo' id='accordion1' role='tablist' aria-multiselectable='true'>
												<div class='list-todo-line'></div>
												<ul>
													<li class='mt-list-item'>
														<div class='list-todo-icon bg-white font-green-meadow'>
															<i class='fa fa-clock-o'></i>
														</div>
														<div class='list-todo-item green-meadow'>
															<a class='list-toggle-container' data-toggle='collapse' data-parent='#accordion1' onclick=' ' href='#task-{$count}' aria-expanded='false'>
																<div class='list-toggle done uppercase'>
																	<div class='list-toggle-title bold '>Call Time: {$call_time} <br>
																	</div>
																</div>
															</a>";
															
														if(!empty($cus_follow->nextCallDate)){
															$cus_html .=	"<div class='note note-success'><p><strong>Next Call Time: </strong> {$cus_follow->nextCallDate}</p></div>";
														}
														$cus_html .= "
															<div class='task-list panel-collapse collapse' id='task-{$count}'>
																<ul>
																	<li class='task-list-item done'>
																		<div class='task-icon'><a href='javascript:;'><i class='fa fa-phone'></i></a></div>

																		<div class='task-content'>
																			<h4 class='uppercase bold'>
																				<a href='javascript:;'>{$callType_status}</a>
																			</h4>
																	<p><strong>Call summary: </strong> {$cus_follow->callSummary}</p>
																	<p><strong>Next Call Time: </strong> {$cus_follow->nextCallDate}</p>
																	<p><strong>Comment: </strong> {$cus_follow->comment}</p>
																	<p><strong>{$cus_follow->customer_prospect}</strong></p>
																	<p><strong>{$view_btn}</strong></p>
																		</div>
																	</li>
																</ul>
															</div>
														</div>
													</li>
												</ul>
											</div>
										</div>
									</div>";
									$count++;					
								}
								echo $cus_html;
							} ?>
						</div>
					</div><!--end leads followup details-->
				</div><!--end followup section -->
				<!--chart section-->
				<div class="clearfix"></div>
				<hr>
				<div id="chartContainer" style="height: 300px; width: 100%;"></div>
				<div id="line_chart"></div><!--end chart section-->
			</div>	
		</div>
	</div>	
</div><!--page section-->
<!-- Modal -->
<div id="pakcageModal" class="modal" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">Close</button>
				<h4 class="modal-title">Select Package</h4>
			</div>
			<div class="modal-body"> 
				<form id="createIti">
					<div class="">
						<?php $prePackages = get_all_packages(); ?>
						<?php $getPackCat = get_package_categories(); ?>
						<?php $state_list = get_indian_state_list(); ?>
						
						
						<div class="form-group">
						<label>Select Package Category*</label>
						<select required name="package_cat_id" class="form-control" id="pkg_cat_id">
							<option value="">Choose Package</option>
							<?php if( $getPackCat ){ ?>
								<?php foreach($getPackCat as $pCat){ ?>
									<option value = "<?php echo $pCat->p_cat_id ?>" ><?php echo $pCat->package_cat_name; ?></option>
								<?php } ?>
							<?php }	?>
						</select>
						</div>
						
						<div class="form-group">
							<label>Select State*</label>
							<select required disabled name="satate_id" class="form-control" id="state_id">
								<option value="">Select State</option>
								<?php if( $state_list ){ 
									foreach($state_list as $state){
										echo '<option value="'.$state->id.'">'.$state->name.'</option>';
									}
								} ?>	
							</select>
						</div>
						<div class="form-group">
						<label>Select Package</label>
						<select required disabled name="packages" class="form-control" id="pkg_id">
							<option value="">Choose Package</option>
						</select>
						</div>
						
						<div class="form-actions">
							<input type="hidden" id="cust_id" value="">
							<input type="submit" class='btn btn-green' id="continue_package" value="Continue" >
						</div>
					</div>	
					<div id="pack_response"></div>	
				</form>	
				<hr>
				<h2><strong>OR</strong></h2>
				<div class="form-group">
					<a href="" class='btn btn-green' id="readyForQuotation" title='Add Itinerary'><i class='fa fa-plus'></i> Create New</a>
				</div>
			</div>
			<div class="modal-footer"></div>
		</div>
		
		
	<?php }else{ ?>
		<div class="marginBottom text-center">
			<!--start filter section-->
			<form id="search_customer_data" class="form-horizontal">
				<div class="form-group">
					<label class="control-label col-sm-4"  for="customer_id">Enter Customer ID/name/contact:</label>
					<div class="col-sm-4">
						<input type="text" id="customer_id" required maxlength="20" name="keyword" value=""  class="form-control" placeholder="Type Lead Id or Customer Name or Contact Number" title="Type Lead Id or Customer Name or Contact Number" /> 
						<ul class="dropdown-menu txtcustomer" style="margin-left:10px;margin-right:0px;" role="menu" aria-labelledby="dropdownMenu"  id="DropdownCusInfo"></ul>
					</div>
				</div>
			</form>
			<hr class="clearfix"/>
			<!--ajax response data-->
		</div>	
	
 <?php } ?> 
 
	</div>
</div>
<style>#editModal, #duplicatePakcageModal{top: 20%; }</style>
<!-- Modal Edit Itinerary -->
<div id="editModal" class="modal" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close editPopClose" data-dismiss="modal">Close</button>
				<h4 class="modal-title">Permission denied</h4>
			</div>
			<div class="modal-body"> 
				Please contact to Manager or Administrator to edit Itinerary. Or Duplicate the Itinerary for revised quotation.
			</div>
			<div class="modal-footer"></div>
		</div>
	</div>
</div>
<!-- Modal Duplicate Itinerary-->
<div id="duplicatePakcageModal" class="modal" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">Close</button>
				<h4 class="modal-title">Select Package</h4>
			</div>
			<div class="modal-body"> 
				<form id="dup_createIti">
					<div class="">
						<?php $prePackages = get_all_packages(); ?>
						<?php $getPackCat = get_package_categories(); ?>
						<?php $state_list = get_indian_state_list(); ?>
						<div class="form-group">
						<label>Select Package Category*</label>
						<select required name="package_cat_id" class="form-control" id="dup_pkg_cat_id">
							<option value="">Choose Package</option>
							<?php if( $getPackCat ){ ?>
								<?php foreach($getPackCat as $pCat){ ?>
									<option value = "<?php echo $pCat->p_cat_id ?>" ><?php echo $pCat->package_cat_name; ?></option>
								<?php } ?>
							<?php }	?>
						</select>
						</div>
						<div class="form-group">
							<label>Select State*</label>
							<select required disabled name="satate_id" class="form-control" id="dup_state_id">
								<option value="">Select State</option>
								<?php if( $state_list ){ 
									foreach($state_list as $state){
										echo '<option value="'.$state->id.'">'.$state->name.'</option>';
									}
								} ?>	
							</select>
						</div>
						
						<div class="form-group">
						<label>Select Package*</label>
						<select required disabled name="packages" class="form-control" id="dup_pkg_id">
							<option value="">Choose Package</option>
						</select>
						</div>
						
						<div class="form-actions">
							<input type="hidden" id="dup_cust_id" value="">
							<input type="hidden" id="dup_iti_id" value="">
							<input type="submit" class='btn btn-green disabledBtn' id="dup_continue_package" value="Continue" >
						</div>
					</div>	
					<div id="pack_response"></div>	
				</form>	
				<hr>
				<h2><strong>OR</strong></h2>
				<div class="form-group">
					<a href="" class='btn btn-green disabledBtn' id="dup_clone_current_iti" title='Clone Itinerary'><i class='fa fa-plus'></i> Clone Current Itinerary</a>
				</div>
			</div>
			<div class="modal-footer"></div>
		</div>
	</div>
</div>
<script type="text/javascript">
jQuery(document).ready(function($){
	
	/*get states from country*/
    $("select.country").change(function(){
        var selectCountry = $(".country option:selected").val();
		var _this = $(this);
		_this.parent().append('<p class="bef_send"><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
		$.ajax({
            type: "POST",
            url: "<?php echo base_url('AjaxRequest/hotelStateData'); ?>",
            data: { country: selectCountry } 
        }).done(function(data){
			$(".bef_send").hide();
            $(".state").html(data);
		}).error(function(){
			alert("Error! Please try again later!");
		});
    });
	
	//open modal on duplicate iti btn click
	$(document).on("click", ".duplicateItiBtn", function(e){
		e.preventDefault();
		var _this = $(this);
		var _this_href = _this.attr("href");
		var iti_id = _this.data("iti_id");
		var customer_id = _this.data("customer_id");
		$("#dup_clone_current_iti").attr("href", _this_href);
		$("#dup_iti_id").val(iti_id);
		$("#dup_cust_id").val(customer_id);
		$("#duplicatePakcageModal").show();
		$("#dup_continue_package, #dup_clone_current_iti").removeClass("disabledBtn");
		//console.log(iti_id + " " + customer_id);
	});
	
	$(document).on('change', 'select#dup_pkg_cat_id', function() {
		$("#dup_state_id, #dup_pkg_id").val("");
		$("#dup_state_id").removeAttr("disabled");
	});
	/*get Packages by Package Category*/
	$(document).on('change', 'select#dup_state_id', function() {
		var p_id = $("#dup_pkg_cat_id option:selected").val();
		var state_id = $("#dup_state_id option:selected").val();
		
		var _this = $(this);
		$("#dup_pkg_id").val("");
		_this.parent().append('<p class="bef_send"><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
		$.ajax({
			type: "POST",
			url: "<?php echo base_url('packages/packagesByCatId'); ?>",
			data: { pid: p_id, state_id: state_id } 
		}).done(function(data){
			$(".bef_send").hide();
			$("#dup_pkg_id").html(data);
			$("#dup_pkg_id").removeAttr("disabled");
		}).error(function(){
			$(".bef_send").html("Error! Please try again later!");
		});
	});
	
	//ajax request if predefined package choose
	var ajaxReq;
	$("#dup_createIti").validate({
		submitHandler: function(){
			if (ajaxReq) {
				ajaxReq.abort();
			}
			$("#dup_continue_package, #dup_clone_current_iti").addClass("disabledBtn");
			var resp = $("#dup_pack_response");
			var package_id = $("#dup_pkg_id").val();
			var customer_id = $("#dup_cust_id").val();
			var iti_id		 = $("#dup_iti_id").val();
			
			if( package_id == '' || customer_id == '' || iti_id == '' ){
				resp.html( "Please Choose Package First" );
				resp.html('<div class="alert alert-danger"><strong>Error! </strong>Please Choose Package First OR Reload page and try again.</div>');
				return false;
			}	
			//resp.html( "Iti Id: " + iti_id + "Package Id: " + package_id + "Customer Id: " + customer_id );
			ajaxReq = $.ajax({
				type: "POST",
				url: "<?php echo base_url('itineraries/cloneItineraryFromPackageId'); ?>",
				data: {package_id: package_id, customer_id: customer_id, parent_iti_id: iti_id},
				dataType: "json",
				beforeSend: function(){
					resp.html('<p><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
				},
				success: function(res) {
					if (res.status == true){
						resp.html('<div class="alert alert-success"><strong>Success! </strong>'+res.msg+'</div>');
						window.location.href = "<?php echo site_url('itineraries/edit/');?>" + res.iti_id + "/" + res.temp_key;
					}else{
						resp.html('<div class="alert alert-danger"><strong>Error! </strong>'+res.msg+'</div>');
						//console.log("error");
					}
				},
				error: function(e,r){
					console.log(r);
					resp.html('<div class="alert alert-danger"><strong>Error!</strong> Please Try again later! </div>');
				}
			}); 
		}	
	});	
	
	
	$(document).on("click", '.child_clone', function () {
		return confirm('Are you sure to create duplicate itinerary ?');
	});
	
});
</script>
<script type="text/javascript">
jQuery(document).ready(function($){
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
	
	//btn toggle
	$(document).on("click", ".optionToggleBtn", function(e){
		e.preventDefault();
		var _this = $(this);
		_this.parent().find(".optionTogglePanel").slideToggle();
	});
	var customer_id = $("#sId").val();
	if( customer_id == "" || customer_id == 0 ){
		console.log("e");
	}else{
		getprospect_chartdata(customer_id);
		//console.log( search_id );	
	}
	
	//open followup on click
	$(document).on("click", 'ul.txtcustomer li a', function (e){
		e.preventDefault();
		var customer_id = $(this).attr("data-customer_id");
		window.location.href = "<?php echo site_url();?>customers/view_lead/" + customer_id;
	});	
	
	//load customer followup data
	function getprospect_chartdata( customer_id ){
		var dataPoints = [];
		var dataPoints2 = [];
		$.ajax({
			type: 'POST',
			dataType: 'json',
			url: '<?php echo base_url('search/getprospect_chartdata'); ?>',
			data:{'id':customer_id}, 
			beforeSend: function(){
				//$("canvas").remove();
			},
			success: function (data1) {
				if(data1.data1){
					var jsonData =JSON.stringify(data1.data1);
					var jsonData2 =JSON.stringify(data1.data2);
					console.log(jsonData2);
					for (var i = 0; i < jsonData.length; i++){
							dataPoints.push({label: jsonData[i].label,name: jsonData[i].name, y: parseFloat(jsonData[i].y)})}
							
					for (var i = 0; i < jsonData2.length; i++){
							dataPoints2.push({label: jsonData2[i].label,name: jsonData2[i].name, y: parseFloat(jsonData2[i].y)})} 
							
					var chart = new CanvasJS.Chart("chartContainer",
					{
					title: {
							text: "Customer Prospect Status",
							},
					axisY:{
							labelFormatter: function(e){
							  if( e.value == 3 ){
								return  "Hot";
							  }
							  else if( e.value == 2 ){
								return  "Warm";
							  }
							  else if( e.value == 1 ){
								return  "Cold";
							  }
							  else{
								return  "";
							  }
							}
						},
					data: [{
							type: "line",
							showInLegend: true,
							name: "Customer FollowUp",
							toolTipContent:'{name}',
							markerType: "square",
							xValueFormatString: "DD MMM, YYYY",
							color: "#000",
							dataPoints: data1.data1
							},
							{
							type: "line",
							showInLegend: true,
							toolTipContent:'{name}',
							name: "Iti FollowUp",
							markerType: "circle",
							xValueFormatString: "DD MMM, YYYY",
							color: "#F08080",
							dataPoints: data1.data2
							},
						]         								
						
						});
						chart.render();
					}
			}
		});
			
			// get customer followup data 
		/*	
			if( customer_id != "" ){
				//console.log("cus id exists" + customer_id );
				var resp = $(".response"), ajaxReq;
				//var customer_id = $("#customer_id").val();
				var cus_info_res = $(".customer_info_res"),
				cusFollowRes = $(".cus_followup_response"), 
				totalIti = $(".total_iti_response"), 
				customer_id_followup = $("#customer_id_followup"), 
				customer_f = $("#customer_f"), 
				iti_follow = $(".iti_followup_response");
				customer_f.hide();
				
				//console.log(formData);
					if (ajaxReq) {
						ajaxReq.abort();
					}
					ajaxReq = $.ajax({
					type: "POST",
					url: "<?php echo base_url('search/get_customer_followup_data'); ?>" ,
					dataType: 'json',
					data: {customer_id: customer_id },
					beforeSend: function(){
						//console.log(customer_id);
						resp.html('<p class="alert alert-info"><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
					},
					success: function(res) {
						console.log( res.cus_followup_data );
						if (res.status == true){
							$(".result_data").show();
							resp.html("");
							cus_info_res.html(res.cus_info_html);
							cusFollowRes.html(res.cus_html);
							iti_follow.html(res.iti_html);
							totalIti.html(res.iti_links);
							//check if customer followup exists
							if( res.cus_followup_data ){
								customer_id_followup.val( customer_id );
								customer_f.show();
							}
							//resp.html('<div class="alert alert-success"><strong>Success! </strong>'+res.msg+'</div>');
						}else{
							$(".result_data").hide();
							resp.html('<div class="alert alert-danger"><strong>Error! </strong>'+res.msg+'</div>');
							console.log("error");
						}
					},
					error: function(e){
						console.log(e);
						//response.html('<div class="alert alert-danger"><strong>Error!</strong>Please Try again later! </div>');
					}
				});
			}else{
				console.log("no id");
				return false;
			}
		*/
	}
	//Get Customer data on keyup
	$("#customer_id").on("keyup", function () {
		$('#DropdownCusInfo').show();
		var resp = $(".response"), ajaxReq;
		//console.log( $(this).val() );
		$.ajax({
			type: "POST",
			url: "<?php echo base_url("search/ajax_get_customer_ids"); ?>",
			data: {
				keyword: $(this).val()
			},
			dataType: "json",
			beforeSend: function(){
				resp.html('<p class="alert alert-info"><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
			},
			success: function (data) {
				
				$("#sId").val("");
				resp.html('');
				//console.log(data);
				if (data.length > 0) {
					$('#DropdownCusInfo').empty();
					//$('#customer_id').attr("data-toggle", "dropdown");
					//$('#DropdownCusInfo').dropdown('toggle');
					$('#DropdownCusInfo').show();
				}
				else if (data.length == 0) {
					$('#DropdownCusInfo').html("");
					$('#DropdownCusInfo').append('<li role="displaycuslist" ><a role="menuitem dropdowncusli" data-customer_id = "" class="dropdownlivalue"><strong>No Data Found</strong></a></li>');
					$('#customer_id').attr("data-toggle", "");
				}
				$.each(data, function (key,value) {
					if (data.length >= 0){
						$('#DropdownCusInfo').append('<li role="displaycuslist" ><a role="menuitem dropdowncusli" data-customer_id = '+ value['customer_id'] +' class="dropdownlivalue"><strong>' + value['customer_id'] + '</strong> - '  + value['customer_name'] + ' - '  + value['customer_contact']  + ' </a></li>');
					}	
				});
			}
		});
	});
});
</script>

<!-- JS FOR CUSTOMER FollowUp -->
<script type="text/javascript">
	//Show text box if other package_by choose
	$(document).on("change", "select[name='package_by']", function(e){
		e.preventDefault();
		var _this = $(this);
		var _thisValue = _this.val();
		console.log( _thisValue );
		if( _thisValue == "Other" ){
			$("#other_pack").show();
		}else{
			$("#other_pack").hide();
			$("#other_pack").val("");
		}
	});
	//Show text box if other Package Type choose
	$(document).on("change", "select[name='package_type']", function(e){
		e.preventDefault();
		var _this = $(this);
		var _thisValue = _this.val();
		console.log( _thisValue );
		if( _thisValue == "Other" ){
			$("#pack_type_other").show();
		}else{
			$("#pack_type_other").hide();
			$("#pack_type_other").val("");
		}
		
	});
</script>
<script type="text/javascript">
	/* Reopen Lead */
	jQuery(document).ready(function($){
		$("#reopenLead").click(function(e){
			e.preventDefault();
			var ajaxRst;
			var cus_id = $(this).attr("data-customer_id");
			var temp_key = $(this).attr("data-temp_key");
			var response = $("#rr");
			
			if (confirm("Are you sure to reopen lead ?")) {
				if (ajaxRst) {
					ajaxRst.abort();
				}
				ajaxRst =	jQuery.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>" + "customers/ajax_reopenLead",
					dataType: 'json',
					data: {customer_id: cus_id, temp_key: temp_key},
					beforeSend: function(){
						response.show().html('<p class="alert alert-info"><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
						
					},
					success: function(res) {
						if (res.status == true){
							response.html('<div class="alert alert-success"><strong>Success! </strong>'+res.msg+'</div>');
							location.reload();
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
		});
	});	
</script>
<script type="text/javascript">
jQuery(document).ready(function($){
	//Show Modal if itinerary price updated for agent
	$(document).on("click",".editPop",function(){
		$("#editModal").show();
	});
	
	$("#travel_date").datepicker({ startDate: "-2d" , format: "mm/dd/yyyy",});
	$("#travel_date_iti").datepicker({ startDate: "-2d" , format: "yyyy-mm-dd",});
	//reset all fields
	function resetForm(){
		$("#call_detais_form").find("input[type=text],input[type=number], textarea,select, .comment").val("");
		$("#call_detais_form").find('input:checkbox').removeAttr('checked');
		$("#call_detais_form").find('.call_type_not_answer').removeAttr('checked');
		$("#call_detais_form").find('#readyQuotation').removeAttr('checked');
		$("#call_detais_form").find('.quotation_type').removeAttr('checked');
		$("#call_detais_form").find('#nxtCallCk').removeAttr('checked');
		$(".nxt_call").hide();
		$("#quotation_type_section").hide();
	}
	
	//radio button calltype on change function
	$(document).on("change", ".radio_toggle", function(e){
		e.preventDefault();
		var _this = $(this);
		var section_id = _this.attr("data-id");
		$("#panel_detail_section").show().find("#"+section_id).slideDown();
		$('.call_type_res').not('#' + section_id).hide();
		$("#customer_info_panel").hide();
		//reset form
		resetForm();
	});
	
	$(document).on("click", "#add_call_btn", function(e){
		e.preventDefault();
		$("#call_log_section").slideDown();
		$(this).fadeOut();
	});
	
	//on cancle btn click
	$(document).on("click", ".cancle_bnt", function(e){
		e.preventDefault();
		$("#call_log_section").slideUp();
		$("#add_call_btn").fadeIn();
		$("#panel_detail_section").hide();
		$("#customer_info_panel").hide();
		//reset form
		$("#call_detais_form").find('.radio_toggle').removeAttr('checked');
		resetForm();
	});
	
	//on picked call select
	var date = new Date();
	date.setDate(date.getDate());
	$(".form_datetime").datetimepicker({
		format: "yyyy-mm-dd HH:ii P",
		showMeridian: true,
		startDate: date,
	});
	//show book Query
	$(document).on("change", ".book_query", function(e){
		e.preventDefault();
		var _this = $(this);
		if( _this.val() == 9 ){
			$("#next_call_cal").hide();
			$(".form_datetime").val("");
			$("#quotation_type_section").slideDown();
		}else{
			$("#next_call_cal").show();
			$("#quotation_type_section").hide();
			$("#customer_info_panel").hide();
			$("#call_detais_form").find('.quotation_type').removeAttr('checked');
		}
	});	
	//show book Query
	$(document).on("change", ".quotation_type", function(e){
		e.preventDefault();
		var _this = $(this);
		if( _this.val() == "holidays" ){
			$(".hide_accommodation").show();
			$("#customer_info_panel").slideDown();
		}else if( _this.val() == "accommodation" ){
			$(".hide_accommodation input, .hide_accommodation select").val("");
			$(".hide_accommodation").hide();
			$("#customer_info_panel").slideDown();
		}else{
			$("#customer_info_panel").slideDown();
		}
	});
	
	/* $(document).on('click','#nxtCallCk', function() {
		var isChecked = $('#nxtCallCk').prop('checked');
		if ( isChecked ) {
			$("#next_call_cal").show();
		}else{
			$("#next_call_cal").hide();
			$(".form_datetime").val("");
		}	
    }); */
	
	//show next call section if call not picked and number does not exists
	$(".call_type_not_answer").click(function(){
		var _this_val = $(".call_type_not_answer:checked").val();
		if( $(this).is(':checked') && _this_val != "Number does not exists" ) { 
			$(".nxt_call").show();
		}else{
			$(".nxt_call").hide();
		}
	});
	
	//validate form
	var newrequest;
	$("#call_detais_form").validate({
		submitHandler: function(form, event) {
			event.preventDefault();
			$("#submit_frm").attr("disabled", "disabled");
			var formData = $("#call_detais_form").serializeArray();
			var resp = $("#resp");
			console.log(formData);
			
				//Get call type value
				var callType = $('input[name=callType]:checked').val();
				console.log(callType);
				if ( newrequest ) {
					newrequest.abort();
					console.log("already sent");
					//return false;
				}
				newrequest = $.ajax({
				type: "POST",
				url: "<?php echo base_url('customers/updateCustomerFollowup'); ?>",
				dataType: 'json',
				data: formData,
				beforeSend: function(){
					$(".spinner_load").show();
					resp.html('<p class="alert alert-info"><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
				},
				
				success: function(res) {
					$(".spinner_load").hide();
					if (res.status == true){
						console.log(res);
						$("#cust_id").val(res.customer_id);
						if( res.approved == "holidays" ){
							resp.html('<div class="alert alert-success"><strong>Success! </strong>'+res.msg+'</div>');
							$("#pakcageModal").show();
							$("#continue_package").removeClass("disabledBtn");
							$("#readyForQuotation").removeClass("disabledBtn");
							$("#call_detais_form")[0].reset();
							$("#call_detais_form").hide();
							//location.reload(); 
							var _this_href = "<?php echo site_url(); ?>itineraries/add/" + res.customer_id + "/" + res.temp_key;
							$("#readyForQuotation").attr( "href", _this_href );
						}else if( res.approved == "accommodation" ){
							resp.html('<div class="alert alert-success"><strong>Success! </strong>'+res.msg+'</div>');
							window.location.href = "<?php echo site_url();?>itineraries/add_accommodation/" + res.customer_id + "/" + res.temp_key;
						}else{
							window.location.href = "<?php echo site_url();?>customers/view_lead/" + res.customer_id;
							//location.reload(); 
						}
						//$("#call_detais_form")[0].reset();
					}else{
						//resp.html('<div class="alert alert-danger"><strong>Error! </strong>'+res.msg+'</div>');
						console.log("error");
					}
				},
				error: function(e){
					$(".spinner_load").hide();
					console.log(e);
				}
			});
			return false;
		} 
	});
});
</script>

<!-- Package Listing Modal -->
<script type="text/javascript">
jQuery(document).ready(function($){
	var ajaxReq;
	var resp = $("#pack_response");
	//ajax request if predefined package choose
	$("#createIti").validate({
		submitHandler: function(){
			
			if (ajaxReq && ajaxReq.readyState != 4 ) {
				ajaxReq.abort();
				console.log("already sent");
			}
			var package_id = $("#pkg_id").val();
			var customer_id = $("#cust_id").val();
			if( package_id == '' || customer_id == '' ){
				resp.html( "Please Choose Package First" );
				resp.html('<div class="alert alert-danger"><strong>Error! </strong>Please Choose Package First</div>');
				return false;
			}	
			//resp.html( "Package Id: " + package_id + "Customer Id: " + customer_id );
			ajaxReq = $.ajax({
				type: "POST",
				url: "<?php echo base_url('packages/createItineraryFromPackageId'); ?>",
				data: {package_id: package_id, customer_id: customer_id},
				dataType: "json",
				beforeSend: function(){
					resp.html('<p><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
				},
				success: function(res) {
					if (res.status == true){
						resp.html('<div class="alert alert-success"><strong>Success! </strong>'+res.msg+'</div>');
						window.location.href = "<?php echo site_url('itineraries/edit/');?>" + res.iti_id + "/" + res.temp_key;
					}else{
						resp.html('<div class="alert alert-danger"><strong>Error! </strong>'+res.msg+'</div>');
						//console.log("error");
					}
				},
				error: function(e){
					console.log(e);
					resp.html('<div class="alert alert-danger"><strong>Error!</strong> Please Try again later! </div>');
				}
			}); 
		}	
	});	
	
	//Open Modal On ready to quotation click
	/* 	$(document).on("click",".ajax_additi_table", function(e){
		e.preventDefault();
		$("#pakcageModal").show();
		var customer_id	= $(this).attr("data-id");
		var temp_key 	= $(this).attr("data-temp_key");
		var _this_href 	= $(this).attr("href");
		$("#cust_id").val(customer_id);
		$("#readyForQuotation").attr( "href", _this_href );
	}); */
	
	jQuery(document).on("click", ".close",function(){
		jQuery("#pakcageModal").fadeOut();
		location.reload();
	});
	
	$(document).on('change', 'select#pkg_cat_id', function() {
		$("#state_id, #pkg_id").val("");
		$("#state_id").removeAttr("disabled");
	});
	
	/*get Packages by Package Category*/
	$(document).on('change', 'select#state_id', function() {
		var p_id = $("#pkg_cat_id option:selected").val();
		var state_id = $("#state_id option:selected").val();
		
		var _this = $(this);
		$("#pkg_id").val("");
		_this.parent().append('<p class="bef_send"><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
		$.ajax({
			type: "POST",
			url: "<?php echo base_url('packages/packagesByCatId'); ?>",
			data: { pid: p_id, state_id: state_id } 
		}).done(function(data){
			$(".bef_send").hide();
			$("#pkg_id").html(data);
			$("#pkg_id").removeAttr("disabled");
		}).error(function(){
			$(".bef_send").html("Error! Please try again later!");
		});
	});
	
	
	//Open Modal On ready to quotation click
	$(document).on("click",".ajax_additi_table", function(e){
		e.preventDefault();
		$("#pakcageModal").show();
		var customer_id	= $(this).attr("data-id");
		var temp_key 	= $(this).attr("data-temp_key");
		var _this_href 	= $(this).attr("href");
		
		//If user not select package
		$("#cust_id").val(customer_id);
		$("#readyForQuotation").attr( "href", _this_href );
		
	});
});
</script>

<!-- Booking Payment Script ITINERARY FOLLOW UP-->
<script type="text/javascript">
jQuery(document).ready(function($){
	//show booking section
	$(document).on("change", ".is_travel_date", function(e){
		e.preventDefault();
		$('.booking_section').show();
		var _this_val = $(this).val();
		$("#travel_date_iti").val("");
		if( _this_val == "fixed" ){
			$("#ttravel_date").show();
		}else{
			$("#ttravel_date").hide();
		}
	});
	
	//get privew aadhar
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
				
				//calculate 50% of total amount after tax
				var calcFiftyPercentage  = (amount_after_tax - ( amount_after_tax * 50 / 100 )).toFixed(0);
				$("#fiftyPer").text("Fifty Percentage: " + calcFiftyPercentage);
				
		
			}else{
				console.log('false');
				$("#fnl_amount_tax").val($('#fnl_amount').val());
				var sub =  $("#fnl_amount_tax").val();
				var amount_after_tax = Math.round(sub);
				
				//calculate 50% of total amount after tax
				var calcFiftyPercentage  = (amount_after_tax - ( amount_after_tax * 50 / 100 )).toFixed(0);
				$("#fiftyPer").text("Fifty Percentage: " + calcFiftyPercentage);
			}
	});
	
	//On click amdment_btn
	$(document).on("click", ".amdment_btn", function(e){
		e.preventDefault();
		var _this_url = $(this).attr("href");
		if (confirm("Are you sure to amendment in this itinerary?")) {
			window.location.href = _this_url;
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
	
	//Set Min Date travel_date
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
	/* On Final Amount blur */
	$('#fnl_amount').keypress(function(e){ 
	   if (this.value.length == 0 && e.which == 48 ){
		  return false;
	   }
	});
	$(document).on("blur", "#fnl_amount", function(){
		if ($(this).attr("readonly")) return false;
		
		//Empty field
		$("#fnl_amount_tax").val('');
		$("#due_payment_section").find('input').val('');
		$("#due_payment_section").find('.date_picker').datepicker('clearDates');
		$("#due_payment_section").find('input').removeAttr('required');
		$("#next_pay_balance, #third_payment_bal").attr("readonly", "readonly");
		var value = parseFloat($(this).val());
		if( value < 0 || $.isNumeric( $(this).val() ) == false ){
			$(".resPonse").html('<div class="alert alert-danger"><strong>Error! </strong>Please enter positive Final Amount value</div>');
			$(this).val("");
			return false;
		}else{
			$(".resPonse").html("");
		}	
		
		//Calculate tax
		//var sub = 0;
		//var rate = parseInt($(this).val());
       // var tax_rate = parseInt($(this).attr("data-tax"));
       // var tax_amount = rate * tax_rate / 100;
		//sub = rate+tax_amount;
	//	var amount_after_tax = Math.round(sub);
		
		//var amount_after_tax= $("#fnl_amount_tax");
		//amount_after_tax.val(value);
		
		$("#fnl_amount_tax").val( value );
		var sub =  $("#fnl_amount_tax").val();
		var amount_after_tax = Math.round(sub);
		
		//calculate 50% of total amount after tax
		var calcFiftyPercentage  = (amount_after_tax - ( amount_after_tax * 50 / 100 )).toFixed(0);
		$("#fiftyPer").text("Fifty Percentage: " + calcFiftyPercentage);
		$("#balance_pay").val("");
		$("#pack_advance_recieve").val("");
	});
	
	/* On advance payment blur */
	$(document).on("blur", "#pack_advance_recieve", function(){
		if ($(this).attr("readonly")) return false;
		$("#due_payment_section").find('input').val('');
		$("#due_payment_section").find('.date_picker').datepicker('clearDates');
		$("#due_payment_section").find('input').removeAttr('required');
		$("#third_payment_bal").attr("readonly", "readonly");
		var _this = $(this);
		var _this_val = parseFloat($(this).val());
		var total_cost		= $("#fnl_amount_tax").val();
		//var total_cost		= $("#fnl_amount").val();
		var balance_pay 	= $("#balance_pay");
		var next_pay_balance = $("#next_pay_balance");
		//if not valid input
		if( _this_val == '' || !$.isNumeric(_this_val) || _this_val < 0 ){
			$(".resPonse").html('<div class="alert alert-danger"><strong>Error! </strong>Please enter positive value</div>');
			_this.val("");
			return false;
		}else{
			$(".resPonse").html('');
		}
		//if advance is greater than final amount
		if( _this_val > total_cost ){
			swal("Warning!", "Advance should be less than final amount", "warning");
			$(".resPonse").html('<div class="alert alert-danger"><strong>Error! </strong>Advance should be less than final amount</div>');
			_this.val("");
			return false;			
		}else{
			$(".resPonse").html('');
		}
		//check if advance payment is less than 50% calculate next payment balance
		var calcFiftyPercentage  = (total_cost - ( total_cost * 50 / 100 )).toFixed(0);
		var nxtPay = (calcFiftyPercentage - _this_val).toFixed(0);
		if( _this_val <  calcFiftyPercentage ){
			next_pay_balance.val(nxtPay);
			next_pay_balance.attr("readonly", "readonly");
			$("#third_payment_bal").removeAttr("readonly");
			$("#third_payment_bal, #third_payment_date").attr("required", "required");
			next_pay_balance.removeAttr("readonly");
			//$('#next_payment_date').datepicker('setEndDate', "+10d");
			$('#next_payment_date').datepicker('setEndDate', "+120d");
		}else{
			$('#next_payment_date').datepicker('setEndDate', "+120d");
			next_pay_balance.val("");
			next_pay_balance.attr("required", "required");
			next_pay_balance.removeAttr("readonly");
		}
		
		
		//calculate Total Balance
		var calTotalBal  = (total_cost - _this_val).toFixed(0);
		balance_pay.val(calTotalBal);
		
		//remove required attribute if Balance is null
		if( $("#balance_pay").val() < 1 ){
			$("#next_payment_date,#next_pay_balance").removeAttr("required");
			//next_pay_balance.val("");
			$("#next_pay_balance, #third_payment_bal").attr("readonly", "readonly");
			//$("#third_payment_bal, #third_payment_date").removeAttr("required", "required");
		}else{
			$("#next_payment_date, #next_pay_balance").attr("required", "required");
		}
		
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
		var advance			= $("#pack_advance_recieve").val();
		var balance_pay 	= $("#balance_pay");
		var thrPay 			= $("#third_payment_bal");
		
		//if not valid input
		if( _this_val == '' || !$.isNumeric(_this_val) || _this_val < 0 ){
			$(".resPonse").html('<div class="alert alert-danger"><strong>Error! </strong>Please enter positive value</div>');
			_this.val("");
			return false;
		}else{
			$(".resPonse").html('');
		}
		
		//Check Pending Balace 
		var pending = (total_cost - advance).toFixed(0);
		
		//Check Second installment
		var calcFiftyPercentage  = (total_cost - ( total_cost * 50 / 100 )).toFixed(0);
		var second_ins = calcFiftyPercentage - advance;
		if( _this_val < second_ins ){
			$(".resPonse").html('<div class="alert alert-danger"><strong>Error! </strong>Next Payment should be Greater than or equal amount = '+ second_ins +'</div>');
			_this.val("");
			return false;
		}	
		
		//if advance is greater than final amount
		if( _this_val > pending ){
			swal("Warning!", "Next Payment should be less than or equal Pending amount = " + pending  , "warning");
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
		var advance			= parseFloat($("#pack_advance_recieve").val());
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
			swal("Warning!", "Next Payment should be less than Pending amount = " + pending, "warning");
			$(".resPonse").html('<div class="alert alert-danger"><strong>Error! </strong>Next Payment should be less than Pending amount = ' + pending +'</div>');
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
<!--iti followup-->
<script type="text/javascript">
jQuery(document).ready(function($){
	//reset all fields
	function resetForm(){
		$("#iti_call_detais_form").find("input[type=text],input[type=number], textarea,select").val("");
		$("#iti_call_detais_form").find(".is_travel_date").removeAttr('checked');
		$("#iti_call_detais_form").find('input:checkbox').removeAttr('checked');
		$("#iti_call_detais_form").find('.call_type_not_answer').removeAttr('checked');
		$(".nxt_call").hide();
		$(".booking_section").hide();
	}
	//radio button calltype on change function
	$(document).on("change", ".radio_toggle", function(e){
		e.preventDefault();
		var _this = $(this);
		var section_id = _this.attr("data-id");
		$("#panel_detail_section").show().find("#"+section_id).slideDown();
		$('.call_type_res').not('#' + section_id).hide();
		//reset form
		resetForm();
	});
	
	
	
	$(document).on("click", "#add_call_btn", function(e){
		e.preventDefault();
		$("#call_log_section").slideDown();
		$(this).fadeOut();
	});
	
	//on cancle btn click
	$(document).on("click", ".cancle_bnt", function(e){
		e.preventDefault();
		$("#call_log_section").slideUp();
		$("#add_call_btn").fadeIn();
		$("#panel_detail_section").hide();
		$("#submit_frm").removeAttr("disabled");
		//reset form
		$("#call_detais_form").find('.radio_toggle').removeAttr('checked');
		$("#iti_call_detais_form").find('.radio_toggle').removeAttr('checked');
		resetForm();
	});
	
	//on picked call select
	var date = new Date();
	date.setDate(date.getDate());
	$(".form_datetime").datetimepicker({
		format: "yyyy-mm-dd hh:ii:ss",
		showMeridian: true,
		startDate: date,
	});
	//show date picker
	$(document).on('click','#nxtCallCk', function() {
		if (!$(this).is(':checked')) {
			$("#next_call_cal").slideUp();
			$(".form_datetime").val("");
		}else{
			$("#next_call_cal").slideDown();
		}	
    });
	
	//show next call section if call not picked
	$(".call_type_not_answer").click(function(){
		if($(this).is(':checked')) { 
			$(".nxt_call").show();
		}else{
			$(".nxt_call").hide();
		}
	});
	//End on picked call selection
	$('input.pck_cost').change(function() {
		var _this = $(this);
		var car_cat = _this.parent().parent().find(".car_cat_v").val();
		var m_plan = _this.parent().parent().find(".m_plan_v").val();
		var pack_cost = _this.parent().parent().find(".pack_cost_v").val();
		$(".car_cat").val(car_cat);
		$(".m_plan").val(m_plan);
		$(".pack_cost").val(pack_cost);
	});
	
	//validate form
	var ajaxReq;
	var resp = $(".resPonse");
	$("#iti_call_detais_form").validate();
	//	submitHandler: function(form, event) {
		$(document).on("submit",'#iti_call_detais_form', function(event){
			event.preventDefault();
			$("#submit_frm").attr("disabled", "disabled");
			//var formData = $("#call_detais_form").serializeArray();
			
			var formData =  new FormData(this);
			
			//var formData = new FormData();
			//formData.append("fieldname","value");
			formData.append("client_aadhar_card", $('#client_aadhar_card')[0].files[0]);
			formData.append("payment_screenshot", $('#payment_screenshot')[0].files[0]);
			//formData.push({ name: 'client_aadhar_card', value: $('#client_aadhar_card')[0].files[0] });
			
				if (ajaxReq) {
					ajaxReq.abort();
				}
				ajaxReq = $.ajax({
				type: "POST",
				url: "<?php echo base_url('itineraries/updateItiStatus'); ?>" ,
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
					var hid_iti_id 		= $("#hid_iti_id").val();
					var hid_temp_key 	= $("#hid_temp_key").val();
					
					if (res.status == true){
						$("#iti_call_detais_form")[0].reset();
						var booked_lead = res.booked_lead;
						resp.html('<div class="alert alert-success"><strong>Success! </strong>'+res.msg+'</div>');
						console.log("done");
						//if booked itinerary
						if( booked_lead ){
							//window.location.href = "<?php echo site_url('itineraries/view/');?>" + hid_iti_id + "/" + hid_temp_key + "?firework=true";
							alert("Form Submited Successfully. Itnerary is booked after verified by the sales manager.");
							//window.location.href = "<?php echo site_url('itineraries/view/');?>" + hid_iti_id + "/" + hid_temp_key;
							location.reload(); 
						}else{
							location.reload(); 
						}	
					}else{
						resp.html('<div class="alert alert-danger"><strong>Error! </strong>'+res.msg+'</div>');
						$("#submit_frm").removeAttr("disabled");
						//alert("error");
						console.log("error");
					}
				},
				error: function(e){
					$(".spinner_load").hide();
					$("#submit_frm").removeAttr("disabled");
					resp.html('<div class="alert alert-danger"><strong>Error! </strong>Try again later.</div>');
					console.log(e);
				}
			});
			//return false;
	});	
});
</script>
<!-- End Booking Payment Script -->
