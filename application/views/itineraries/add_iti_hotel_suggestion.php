<div class="page-container">
	<div class="page-content-wrapper">
		<div class="page-content">
			<div class="portlet box blue">
				<div class="portlet-title">
					<div class="caption"><i class="fa fa-newspaper-o" aria-hidden="true"></i>Create Itinerary</div>
					<a class="btn btn-success pull-right" href="<?php echo site_url("itineraries"); ?>" title="Back">Back</a>
				</div>
			</div>
		<?php if( $customer ){ 	$cus = $customer[0]; ?>
			<?php if( !empty($customer_iti) ){
			echo "<div class='text-center'><strong>$customer_iti</strong> Itinerary already generated against this customer.</div>";
		} ?>
		
		<div class="portlet light bordered" id="form_wizard_1">
			<div class="portlet-body form">
				<form id="itiForm_Frm">
				<div class="form-horizontal" id="itiForm_form">
					
					<!--Customer info Section-->
						<?php $get_customer_info = get_customer( $cus->customer_id ); 
						$cust = $get_customer_info[0];
						if( !empty( $get_customer_info ) ){  ?>
							<section class="well details-package">
							<h3 class="text-center">Package details</h3>
								<p class="text-center "><strong><u>Customer Details </u></strong></p>
								<label class="col-md-6 col-lg-2">Customer Name:</label>
								<div class="col-md-6 col-lg-2">
									<strong><?php if(isset($cust->customer_name)){ echo $cust->customer_name; }?></strong>
								</div>
								<label class="col-md-6 col-lg-2">Contact:</label>
								<div class="col-md-6 col-lg-2">
									<strong><?php if(isset($cust->customer_contact)){ echo $cust->customer_contact; }?></strong>
								</div>
								<label class="col-md-6 col-lg-2">Customer Email:</label>
								<div class="col-md-6 col-lg-2">
									<strong><?php if(isset($cust->customer_email)){ echo $cust->customer_email; }?> </strong>
								</div>
							 
								<label class="col-md-6 col-lg-2">Travel Date:</label>
								<div class="col-md-6 col-lg-2">
									<strong><?php if(isset($cust->travel_date)){ echo $cust->travel_date; }?></strong>
								</div>
								<label class="col-md-6 col-lg-2">Package Type:</label>
								<?php 
									$pkBy =	$cust->package_type;
									$pack_T = $pkBy == "Other" ? $cust->package_type_other : $pkBy; ?>
								<div class="col-md-6 col-lg-2">
									<strong><?php echo $pack_T;?></strong>
								</div>
								<label class="col-md-6 col-lg-2">Destination:</label>
								<div class="col-md-6 col-lg-2">
									<strong><?php if(isset($cust->destination)){ echo $cust->destination; }?> </strong>
								</div>
								 
								<label class="col-md-6 col-lg-2">Meal Plan:</label>
								<div class="col-md-6 col-lg-2">
									<strong><?php if(isset($cust->meal_plan)){ echo $cust->meal_plan; }?></strong>
								</div>
								<label class="col-md-6 col-lg-2">Hotel Category:</label>
								<div class="col-md-6 col-lg-2">
									<strong><?php if(isset($cust->hotel_category)){ echo $cust->hotel_category; }?></strong>
								</div>
								<label class="col-md-6 col-lg-2">Budget Approx:</label>
								<div class="col-md-6 col-lg-2">
									<strong><?php if(isset($cust->budget)){ echo $cust->budget; }?> </strong>
								</div>
								 
								<label class="col-md-6 col-lg-2">Total Travellers:</label>
								<div class="col-md-6 col-lg-2">
									<strong>Adults: <?php if(isset($cust->adults)){ echo $cust->adults; }?></strong>
									<strong><?php if(isset($cust->child)){ echo "Child: " . $cust->child . "( " . $cust->child_age . " )"; } ?></strong>
								</div>
								 
							</section>
						<?php } ?>
					<!--end Section Customer Section-->
					<div class="form-wizard">
						<div class="form-body">
							<ul class="nav nav-pills nav-justified steps">
								<li>
									<a href="#tab4" data-toggle="tab" class="step">
										<span class="number"> 1 </span>
										<span class="desc">
											<i class="fa fa-check"></i> Package Overview </span>
									</a>
								</li>
								<li>
									<a href="#tab2" data-toggle="tab" class="step">
										<span class="number"> 2 </span>
										<span class="desc">
											<i class="fa fa-check"></i> Day Wise Itinerary </span>
									</a>
								</li>
								<li>
									<a href="#tab3" data-toggle="tab" class="step active">
										<span class="number"> 3 </span>
										<span class="desc">
											<i class="fa fa-check"></i> Inclusion & Exclusion </span>
									</a>
								</li>
								<li>
									<a href="#tab4" data-toggle="tab" class="step">
										<span class="number"> 4 </span>
										<span class="desc">
											<i class="fa fa-check"></i> Hotel Details </span>
									</a>
								</li>
								<li>
									<a href="#tab7" data-toggle="tab" class="step">
										<span class="number"> 7 </span>
										<span class="desc">
											<i class="fa fa-check"></i> Submit Itinerary </span>
									</a>
								</li>
							</ul>
							<div id="bar" class="progress progress-striped" role="progressbar">
								<div class="progress-bar progress-bar-success"> </div>
							</div>
							<div class="tab-content">
								<div class="alert alert-danger display-none">
									<button class="close" data-dismiss="alert"></button> You have some form errors. Please check below. </div>
								<!--div class="alert alert-success display-none">
									<button class="close" data-dismiss="alert"></button> Your form validation is successful! </div-->
								<div class="tab-pane active" id="tab1">
									<h3 class="block">Provide Package details</h3>
									<div  class="col-md-6">
									<div class="form-group">
										<label class="control-label col-md-4">Package Name
											<span class="required"> * </span>
										</label>
										<div class="col-md-8">
											<input type="text" class="form-control" name="package_name" placeholder="Enter Package Name."/>
										</div>
									</div>
									</div>
									
									<div  class="col-md-6">
									<div class="form-group">
										<label class="control-label col-md-4">Routing
											<span class="required"> * </span>
										</label>
										<div class="col-md-8">
											<input type="text" required value= "" class="form-control" name="package_routing" placeholder="Enter Package Routing." />
										</div>
									</div>
									</div>
									<div  class="col-md-6">
										<div class="form-group">
											<label class="control-label col-md-4">No. of Persons
												<span class="required"> * </span>
											</label>
											<div class="col-md-2">
												<input type="text" required class="form-control" name="adults" maxlength='20' value="" placeholder="Adults" />
											</div>
											<div class="col-md-2 padding-0">
												<input type="text" class="form-control" name="child" maxlength='20' value="" placeholder="Children" />
											</div>
											<div class="col-md-4">
											<input type="text" class="form-control" name="child_age" value="" maxlength='50' placeholder="Child Age: eg. 12,15,18." />
											</div>
										</div>
									</div>
								 	<div  class="col-md-6">
									<div class="form-group">
										<label class="control-label col-md-4">Cab
											<span class="required"> * </span>
										</label>
										<div class="col-md-8">
											<select required name="cab_category" class="form-control">
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
									</div>
									
									<div  class="col-md-6">
										<div class="form-group">
											<label class="control-label col-md-4">Room Category
												<span class="required"> * </span>
											</label>
											<div class="col-md-4">
												<select title="Select Room Category" required name="rooms_meta[room_category]" class="form-control">
													<option value="">Select Room Category</option>
													<option value="00">0</option>
													<?php $room_cats = get_room_categories(); 
														if( $room_cats ){
															foreach($room_cats as $cat){
																echo '<option value = "'.$cat->room_cat_id .'" >'.$cat->room_cat_name.'</option>';
															}
														}
													?>
												</select>
											</div>
											<div class="col-md-4">
												<select title="Select Total Rooms" required name="rooms_meta[total_rooms]" class="form-control">
													<option value="">No. of Rooms</option>
													<option value="00">0</option>
													<?php 
													for( $room = 1 ; $room <= 20 ; $room ++  ){
														echo '<option value = "'.$room .'" >'.$room.'</option>';
													}
													?>
													<option value="20+">20+</option>
												</select>
											</div>
											
										</div>
									</div>
									
									<div  class="col-md-6">
										<div class="form-group">
											<label class="control-label col-md-4">Extra bed/Without extra bed</label>
											<div class="col-md-4">
												<select title="Select with extra bed" name="rooms_meta[with_extra_bed]" class="form-control">
													<option value="">Select Extra Bed</option>
													<option value="00">0</option>
													<?php $room_cats = get_room_categories(); 
														for( $eb = 1 ; $eb <= 20 ; $eb ++  ){
															echo '<option value = "'.$eb .'" >'.$eb.'</option>';
														}
													?>
												</select>
											</div>
											<div class="col-md-4">
												<select title="Select without extra bed" name="rooms_meta[without_extra_bed]" class="form-control">
													<option value="">Select Without Extra Bed</option>
													<option value="00">0</option>
													<?php 
													for( $wm = 1 ; $wm <= 20 ; $wm ++  ){
														echo '<option value = "'.$wm .'" >'.$wm.'</option>';
													}
													?>
												</select>
											</div>
											
										</div>
									</div>
									
									
									<div  class="col-md-6">
									<div class="form-group">
										<label class="control-label col-md-4">Duration
											<span class="required"> * </span>
										</label>
										<div class="col-md-8">
											<input type="text" required class="form-control" id="package_duration" name="package_duration" placeholder="Enter Package Duration eg. 3 Nights and 4 days." value=""/>
										</div>
									</div>
									</div>
									
									<div  class="col-md-6">
									<div class="form-group">
										<label class="control-label col-md-4">Quotation Date
											<span class="required"> * </span>
										</label>
										<div class="col-md-8">
											<input required readonly="readonly" class="input-group form-control quatation_date" id="quatation_date" size="16" type="text" value="" name="quatation_date"  />
										</div>
									</div>
									</div>
									
									<div  class="col-md-6">
									<div class="form-group">
										<label class="control-label col-md-4">Flight Details</label>
										<div class="col-md-8">
											<label class='mt-checkbox'> 
												<input type='checkbox' name="is_flight" id='flight_ck' class='input-group form-control' value="1"><span></span>
											</label>
										</div>
									</div>
									</div>
									<div  class="col-md-6">
									<div class="form-group">
										<label class="control-label col-md-4">Train Details</label>
										<div class="col-md-8">
											<label class='mt-checkbox'> 
												<input type='checkbox' name="is_train" id='train_ck' class='input-group form-control' value="1"><span></span>
											</label>
										</div>
									</div>
									</div>
									
									<div class="clearfix"></div>
									<!--Flight Section-->
									<section class="well details-package" id="flight_section">
										<h3 class="text-center">Flight details</h3>
										<div class="text-center">
											<div class="btn-group" data-toggle="buttons">
												<label class="btn btn-default custom_active active"><input type="radio" name="trip_r" checked class="trip_r" value="oneway" />One Way</label>
												<label class="btn btn-default custom_active"><input type="radio" name="trip_r" class="trip_r" value="round" />Round Trip</label>
											</div>	
										</div>	<p></p>
										<div class="clearfix"></div>
										<div  class="col-md-6">
											<div class="form-group">
												<label class="control-label col-md-4">Flight Name
													<span class="required"> * </span>
												</label>
												<div class="col-md-8">
													<input required class="input-group form-control" size="16" type="text" value="" name="flight_name" placeholder="Jet Airways,SpiceJet etc" />
												</div>
											</div>
										</div>
										<div  class="col-md-6">
											<div class="form-group">
												<label class="control-label col-md-4">No. of Passengers
													<span class="required"> * </span>
												</label>
												<div class="col-md-8">
													<input required class="input-group form-control" size="16" type="text" value="" name="passengers"  />
												</div>
											</div>
										</div>
										<div  class="col-md-6">
											<div class="form-group">
												<label class="control-label col-md-4">Departure City
													<span class="required"> * </span>
												</label>
												<div class="col-md-8">
													<input required class="input-group form-control" placeholder="Mumbai,Shimla etc" size="16" type="text" value="" name="dep_city"  />
												</div>
											</div>
										</div>
										<div  class="col-md-6">
											<div class="form-group">
												<label class="control-label col-md-4">Arrival city
													<span class="required"> * </span>
												</label>
												<div class="col-md-8">
													<input required class="input-group form-control" placeholder="Mumbai,Shimla etc" size="16" type="text" value="" name="arr_city"  />
												</div>
											</div>
										</div>
										<div  class="col-md-6">
											<div class="form-group">
												<label class="control-label col-md-4">Departure Date & Time
													<span class="required"> * </span>
												</label>
												<div class="col-md-8">
													<input required readonly class="input-group form-control flight_dateTime" size="16" type="text" value="" name="dep_date"  />
												</div>
											</div>
										</div>
										<div  class="col-md-6">
											<div class="form-group">
												<label class="control-label col-md-4">Arrival Date & Time
													<span class="required"> * </span>
												</label>
												<div class="col-md-8">
													<input required readonly class="input-group form-control flight_dateTime" size="16" type="text" value="" name="arr_time"  />
												</div>
												
											</div>
										</div>
										
										
										<div  class="col-md-6">
											<div class="form-group">
												<label class="control-label col-md-4">Return Date & Time
													<span class="required"> * </span>
												</label>
												<div class="col-md-8">
													<input readonly disabled class="input-group form-control" size="16" type="text" value="" name="return_date" id="return_date" />
												</div>
											</div>
										</div>
										
										<div  class="col-md-6">
											<div class="form-group">
												<label class="control-label col-md-4">Return Arrival Date & Time
													<span class="required"> * </span>
												</label>
												<div class="col-md-8">
													<input readonly disabled class="input-group form-control" size="16" type="text" value="" name="return_date" id="return_arr_date" />
												</div>
											</div>
										</div>
										
										<div  class="col-md-6">
											<div class="form-group">
												<label class="control-label col-md-4">Class
													<span class="required"> * </span>
												</label>
												<div class="col-md-8">
													<select required name="f_class" class="form-control">
														<option value="">Choose Class</option>
														<option value="Economy">Economy</option>
														<option value="Premium Economy">Premium Economy</option>
														<option value="Business">Business</option>
													</select>
												</div>
											</div>
										</div>
										
										<div  class="col-md-6">
											<div class="form-group">
												<label class="control-label col-md-4">Price
													<span class="required"> * </span>
												</label>
												<div class="col-md-8">
													<input required class="input-group form-control" size="16" placeholder="10000 etc." type="number" value="" name="flight_cost"  />
												</div>
											</div>
										</div>
									</section>	
									<!--End Flight Section-->
									<!--Train Section-->
									<section class="well details-package" id="train_section">
										<h3 class="text-center">Train details</h3>
										<div class="text-center">
											<div class="btn-group" data-toggle="buttons">
												<label class="btn btn-default custom_active active"><input type="radio" name="t_trip_r" checked class="trip_r" value="oneway" />One Way</label>
												<label class="btn btn-default custom_active"><input type="radio" name="t_trip_r" class="t_trip_r" value="round" />Round Trip</label>
											</div>	
										</div>	<p></p>
										<div class="clearfix"></div>
										<div  class="col-md-6">
											<div class="form-group">
												<label class="control-label col-md-4">Train Name
													<span class="required"> * </span>
												</label>
												<div class="col-md-8">
													<input required class="input-group form-control" size="16" type="text" value="" name="train_name" placeholder="Adi Duronto Express, Arunachal Express etc" />
												</div>
											</div>
										</div>
										<div  class="col-md-6">
											<div class="form-group">
												<label class="control-label col-md-4">Train Number
													<span class="required"> * </span>
												</label>
												<div class="col-md-8">
													<input required class="input-group form-control" size="16" type="text" value="" name="train_number" placeholder="11050, 11052 etc" />
												</div>
											</div>
										</div>
										<div  class="col-md-6">
											<div class="form-group">
												<label class="control-label col-md-4">No. of Passengers
													<span class="required"> * </span>
												</label>
												<div class="col-md-8">
													<input required class="input-group form-control" size="16" type="text" value="" name="t_passengers"  />
												</div>
											</div>
										</div>
										<div  class="col-md-6">
											<div class="form-group">
												<label class="control-label col-md-4">Departure City
													<span class="required"> * </span>
												</label>
												<div class="col-md-8">
													<input required class="input-group form-control" placeholder="Mumbai,Shimla etc" size="16" type="text" value="" name="t_dep_city"  />
												</div>
											</div>
										</div>
										<div  class="col-md-6">
											<div class="form-group">
												<label class="control-label col-md-4">Arrival city
													<span class="required"> * </span>
												</label>
												<div class="col-md-8">
													<input required class="input-group form-control" placeholder="Mumbai,Shimla etc" size="16" type="text" value="" name="t_arr_city"  />
												</div>
											</div>
										</div>
										<div  class="col-md-6">
											<div class="form-group">
												<label class="control-label col-md-4">Departure Date & Time
													<span class="required"> * </span>
												</label>
												<div class="col-md-8">
													<input required readonly class="input-group form-control train_dateTime" size="16" type="text" value="" name="t_dep_date"  />
												</div>
											</div>
										</div>
										<div  class="col-md-6">
											<div class="form-group">
												<label class="control-label col-md-4">Arrival Date & Time
													<span class="required"> * </span>
												</label>
												<div class="col-md-8">
													<input required readonly class="input-group form-control train_dateTime" size="16" type="text" value="" name="t_arr_time"  />
												</div>
												
											</div>
										</div>
										
										<div  class="col-md-6">
											<div class="form-group">
												<label class="control-label col-md-4">Return Date & Time
													<span class="required"> * </span>
												</label>
												<div class="col-md-8">
													<input readonly disabled class="input-group form-control" size="16" type="text" value="" name="t_return_date" id="t_return_date" />
												</div>
											</div>
										</div>
										
										<div  class="col-md-6">
											<div class="form-group">
												<label class="control-label col-md-4">Return Arrival Date & Time
													<span class="required"> * </span>
												</label>
												<div class="col-md-8">
													<input readonly disabled class="input-group form-control" size="16" type="text" value="" name="t_return_arr_date" id="t_return_arr_date" />
												</div>
											</div>
										</div>
										
										<div  class="col-md-6">
											<div class="form-group">
												<label class="control-label col-md-4">Class
													<span class="required"> * </span>
												</label>
												<div class="col-md-8">
													<select required name="t_class" class="form-control">
														<option value="">Choose Class</option>
														<option value="1AC">1AC</option>
														<option value="2AC">2AC</option>
														<option value="3AC">3AC</option>
														<option value="Sleeper class">Sleeper class</option>
													</select>
												</div>
											</div>
										</div>
										<div class="clearfix"></div>
										<div  class="col-md-6">
											<div class="form-group">
												<label class="control-label col-md-4">Price
													<span class="required"> * </span>
												</label>
												<div class="col-md-8">
													<input required class="input-group form-control" size="16" placeholder="10000 etc." type="number" value="" name="t_cost"  />
												</div>
											</div>
										</div>
									</section>	
									<!--End Train Section -->
									<div class="clearfix"></div>
								</div>
								<div class="tab-pane" id="tab2">
									<h3 class="block">Day Wise Itineray</h3>
									<div class="col-md-12">
										<div class="mt-repeater">
											<div data-repeater-list="tour_meta">

											<div data-repeater-item class="mt-repeater-item daywise_section">
											<!--strong>Day: </strong><strong class="sta_d">1</strong--> 
											<div class="clearfix"></div>
											<div class="row">
											<div class="col-md-8">
											<div class="row">
											<div class="col-md-2">
												<div class="mt-repeater-input form-group">
														<label class="control-label">Day</label><span class="required"> * </span>
														<br/>
														<input required  placeholder="Day 1" type="text" name="tour_day" class="form-control" value="" /> 
													</div>
											</div>
											
											<div class="col-md-2">
											<div class="mt-repeater-input">
														<label class="control-label">Tour Date*</label>
														<br/>
														<input required readonly="readonly" class="input-group form-control tour_dt" id="tour_dt" size="16" type="text" value="" name="tour_date"  />
													</div>
											</div>
											
											<div class="mt-repeater-input form-group t_title">
														<label class="control-label">Tour Title</label><span class="required"> * </span>
														<br/>
														<input required  placeholder="Shimla local sight" type="text" name="tour_name" class="form-control" value="" /> 
											</div>
											</div>
											</div>
											<div class="col-md-4">
											<div class="mt-repeater-input form-group">
														<label class="control-label">Meal Plan</label><span class="required"> * </span>
														<br/>
														<select required name="meal_plan" class="form-control">
															<option value="">Choose Meal Plan</option>
															<option value="Breakfast Only">Breakfast Only</option>
															<option value="Breakfast & Dinner">Breakfast & Dinner</option>
															<option value="Breakfast, Lunch & Dinner">Breakfast, Lunch & Dinner</option>
															<option value="Dinner Only">Dinner Only</option>
															<option value="No">No Meal Plan</option>
														</select>
													</div>
													<div class="mt-repeater-input form-group">
														<label class="control-label">Distance</label><span class="required"> * </span>
														<br/>
														<input required  placeholder="100 Km" type="number" name="tour_distance" class="form-control tour_distant" value="" /> 
													</div>
											</div>		
											</div> <!-- row close-->		
											<div class="clearfix"></div>	
											<div class="row">
											<div class="col-md-9">
											<div class="mt-repeater-input mt-repeater-textarea t_des" style="padding-left:0; padding-right:0;">
												<label class="control-label">Tour Description</label><span class="required"> * </span>
												<textarea required="required" name="tour_des" class="form-control" rows="2"></textarea>
												
											</div>
											</div>
											
											<div class="col-md-3">
												<div class="mt-repeater-input">
													<label class="control-label">Attraction</label>
													<div class="hot_des" style="float:none;">
														<input type="hidden" value="" class="tags_values" name="hot_des">
														<input type="text" value="" class="form-control" placeholder="Add a attraction points" />
													</div>
												</div>
											</div>
											</div>
											<div class="clearfix"></div>
											
													
													<!-- jQuery Repeater Container -->
													
											
													
												
													<div class="mt-repeater-input del_rep">
														<a href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-delete" style="position:relative;">
														<i class="fa fa-close"></i> Delete</a>
													</div>
												</div>
											</div>
											<a href="javascript:;" data-repeater-create class="btn btn-success mt-repeater-add addrep"><i class="fa fa-plus"></i> Add</a>
										</div>
									</div>
										<!-- Tour data preview -->
									<!--div class="col-md-3">
										<div id="tour_data_preview"></div>										
									</div-->	
								</div>
								<div class="tab-pane" id="tab3">
									<h3 class="block">Inclusion & Exclusion</h3>
									<div class="col-md-6">
										<div class="mt-repeater-inc tour_field_repeater">
											<h4>Inclusion</h4>
											<div data-repeater-list="inc_meta">
												<div data-repeater-item class="mt-repeater-inc-item form-group">
													<div class="mt-repeater-inc-cell">
														<div class="mt-repeater-inc-input col-md-9">
															<input required type="text" name="tour_inc" class="form-control" value="" /> 
														</div>
														<div class="mt-repeater-inc-input col-md-3">
															<a href="javascript:;" title="delete" data-repeater-delete class="btn btn-danger mt-repeater-delete">
																<i class="fa fa-close"></i></a>
														</div>
													</div>
												</div>
											</div><br>
											<a href="javascript:;" data-repeater-create class="btn btn-success mt-repeater-inc-add">
											<i class="fa fa-plus"></i> Add</a>
										</div>
										
									</div>	
									<div class="col-md-6">
										<?php $terms = get_terms_condition();
											if( $terms ){
												$terms = $terms[0];
												$hotel_exc = unserialize($terms->hotel_exclusion);
												$hotel_notes = unserialize($terms->hotel_notes);
												$rates_dates_notes = unserialize($terms->rates_dates_notes);
											}else{
												$hotel_exc = "";
												$hotel_notes = "";
												$rates_dates_notes = "";
											}
										?>	
										<div class="mt-repeater-exc tour_field_repeater">
											<h4>Exclusion</h4>
											<div data-repeater-list="exc_meta">  
											<?php $count_hotel_exc	= count( $hotel_exc );
												if( $count_hotel_exc > 0 ){ ?>
													<?php for ( $i = 0; $i < $count_hotel_exc; $i++ ) { ?>
														<div data-repeater-item class="mt-repeater-exc-item form-group">
															<!-- jQuery Repeater Container -->
															<div class="mt-repeater-exc-input col-md-9">
																<input required type="text" name="exc_meta[<?php echo $i; ?>][tour_exc]" class="form-control" value="<?php echo $hotel_exc[$i]["hotel_exc"] ;?>" /> 
															</div>
															
															<div class="mt-repeater-exc-input col-md-3">
																<a title="delete" href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-delete">
																	<i class="fa fa-close"></i> </a>
															</div>
														</div>
													<?php } ?>
												<?php }else{ ?>	
													<div data-repeater-item class="mt-repeater-exc-item form-group">
														<!-- jQuery Repeater Container -->
														<div class="mt-repeater-exc-input col-md-9">
															<input required type="text" name="tour_exc" class="form-control" value="" /> 
														</div>
														<div class="mt-repeater-exc-input col-md-3">
															<a title="delete" href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-delete">
																<i class="fa fa-close"></i> </a>
														</div>
													</div>
												<?php } ?>	
											</div>
											<a href="javascript:;" data-repeater-create class="btn btn-success mt-repeater-add">
											<i class="fa fa-plus"></i> Add</a>
										</div>
									</div>
									<div class="clearfix"></div>
									<div class="col-md-12">
										<!--Special Inclusion Section-->
										<div class="mt-repeater-spinc tour_field_repeater_sp">
											<h3 class="block">Special Inclusions</h3>
											<div data-repeater-list="special_inc_meta">
												<div data-repeater-item class="mt-repeater-spinc-item form-group">
													<div class="mt-repeater-spinc-cell">
														<div class="mt-repeater-spinc-input col-md-9">
															<input required type="text" name="tour_special_inc" class="form-control" value="" /> 
														</div>
														<div class="mt-repeater-spinc-input col-md-3">
															<a href="javascript:;" title="delete" data-repeater-delete class="btn btn-danger mt-repeater-delete">
																<i class="fa fa-close"></i></a>
														</div>
													</div>
												</div>
											</div><br>
											<a href="javascript:;" data-repeater-create class="btn btn-success mt-repeater-spinc-add">
											<i class="fa fa-plus"></i> Add</a>
										</div>
									</div>	
								</div>
								<div class="tab-pane" id="tab4">
									<h3 class="block">Hotel Details</h3>
									<h4 class="clearboth">Choose Hotel By Categories:</h4>
									<div class="mt-repeater-hotel tour_field_repeater">
										<div data-repeater-list="hotel_meta">
											<div data-repeater-item class="mt-repeater-hotel-item">
												<div class="row">
													<div class='mt-repeater-hotel-input  col-md-3' >
														<label><strong>Hotel Location:</strong></label>
														<input required type="text" name='hotel_location' class='form-control' placeholder="Eg. Shimla/Manali">
													</div>
													
													<!--add hotel suggesion -->
													<div class="col-md-3">
														<div class="mt-repeater-input">
															<label class="control-label">Attraction</label>
															<div class="autocomplete" style="width:300px;">
															<div class="hotel_des" style="float:none;">
																<input type="hidden" value="" class="hotel_tags_values" name="hot_des">
																	<input type="text" name="myCountry" class="form-control hotel_des_sug" placeholder="Add a attraction points">
																	<ul style="margin-left:15px;margin-right:0px;" role="menu" aria-labelledby="dropdownMenu"  class="dropdownhotels dropdown-menu txtcountry"></ul>
															</div>
															
															</div>
														</div>
											
													</div><!--end add hotel suggesion -->
											
													<div class='mt-repeater-hotel-input standard   col-md-2' >
														<label><strong>Deluxe:</strong></label>
														<textarea name="hotel_standard" required class='form-control'></textarea>
													</div>
													
													<div class='mt-repeater-hotel-input deluxe   col-md-2' >
														<label><strong>Super Deluxe:</strong></label>
														<textarea name="hotel_deluxe" required class='form-control'></textarea>
													</div>
													<div class='mt-repeater-hotel-input super_deluxe   col-md-2' >
														<label><strong>Luxury:</strong></label>
														<textarea name="hotel_super_deluxe" required class='form-control'></textarea>
													</div>
													<div class='mt-repeater-hotel-input luxury   col-md-2' >
														<label><strong>Super Luxury:</strong></label>
														<textarea name="hotel_luxury" required class='form-control'></textarea>
													</div>
													<div class="mt-repeater-hotel-input col-md-1">
														<a href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-delete">
															<i class="fa fa-close"></i> Delete</a>
													</div>
												</div> <!-- row -->
											</div>
										</div>
										<p></p>
										<a href="javascript:;" data-repeater-create class="btn btn-success mt-repeater-hotel-add">
										<i class="fa fa-plus"></i> Add Hotel</a>
										<?php if ( isset( $user_role ) && $user_role == "99" || $user_role == "98"  ){ ?>
											<!--Rate Meta-->
											<div class="row">
												<div class='mt-repeater-hotel-input  col-md-12' >
													<p class="text-center"><strong style="font-size: 22px;">Rates: </strong></p>
												</div>
												<div class='mt-repeater-hotel-input standard  form-group col-md-3' >
													<label><strong>Deluxe:</strong></label>
													<input required name="rate_meta[standard_rates]" type="number" class='form-control'></input>
												</div>
												
												<div class='mt-repeater-hotel-input deluxe   col-md-3' >
													<label><strong>Super Deluxe:</strong></label>
													<input required name="rate_meta[deluxe_rates]" type="number" class='form-control'></input>
												</div>
												<div class='mt-repeater-hotel-input super_deluxe   col-md-3' >
													<label><strong>Luxury:</strong></label>
													<input required name="rate_meta[super_deluxe_rates]" type="number" class='form-control'></input>
												</div>
												<div class='mt-repeater-hotel-input luxury   col-md-3' >
													<label><strong>Super Luxury:</strong></label>
													<input required name="rate_meta[luxury_rates]" type="number" class='form-control'></input>
												</div>
											</div> <!-- row -->
										<?php }else{ ?>	
											<!--Rate Meta-->
											<div class="row">
												<div class='mt-repeater-hotel-input   col-md-12' >
													<p class="text-center"><strong style="font-size: 22px;">Rates: </strong><span class="red"> ( Filled by Manager only )</span></p>
												</div>
												<div class='mt-repeater-hotel-input deluxe   col-md-3' >
													<label><strong>Deluxe:</strong></label>
													<input disabled type="number" class='form-control'></input>
												</div>
												<div class='mt-repeater-hotel-input super_deluxe  col-md-3' >
													<label><strong>Super Deluxe:</strong></label>
													<input disabled type="number" class='form-control'></input>
												</div>
												<div class='mt-repeater-hotel-input luxury   col-md-3' >
													<label><strong>Luxury:</strong></label>
													<input disabled type="number" class='form-control'></input>
												</div>
												<div class='mt-repeater-hotel-input standard    col-md-3' >
													<label><strong>Super Luxury:</strong></label>
													<input disabled type="number" class='form-control'></input>
												</div>
											</div> <!-- row -->
										<?php } ?>
										<hr>
									</div>
									
									
									<div class="mt-repeater-hotel-note tour_field_repeater">
										<div data-repeater-list="hotel_note_meta">
											<label class="control-label">Add Hotel Note: </label>
										<?php $count_hotel_notes = count( $hotel_notes );
											if( $count_hotel_notes > 0 ){ ?>
												<?php for ( $i = 0; $i < $count_hotel_notes; $i++ ) { ?>
													<div data-repeater-item class="mt-repeater-hotel-note-item form-group">
														<!-- jQuery Repeater Container -->
														<div class="mt-repeater-hotel-note-input col-md-9">
															<div class="mt-repeater-hotel-note-input">
																<input required type="text" name="hotel_note_meta[<?php echo $i; ?>][hotel_note]" class="form-control" value="<?php echo $hotel_notes[$i]["hotel_notes"] ;?>" /> 
															</div>
														</div>
														<div class="mt-repeater-hotel-note-input col-md-3">
															<a href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-delete">
															<i class="fa fa-close"></i> Delete</a>
														</div>
													</div>
												<?php } ?>	
											<?php }else{ ?>
												<div data-repeater-item class="mt-repeater-hotel-note-item form-group">
													<!-- jQuery Repeater Container -->
													<div class="mt-repeater-hotel-note-input col-md-9">
														<div class="mt-repeater-hotel-note-input">
															<input required type="text" name="hotel_note" class="form-control" value="" /> 
														</div>
													</div>
													<div class="mt-repeater-hotel-note-input col-md-3">
														<a href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-delete">
														<i class="fa fa-close"></i> Delete</a>
													</div>
												</div>
											<?php } ?>	
										</div>
										<a href="javascript:;" data-repeater-create class="btn btn-success mt-repeater-hotel-note">
										<i class="fa fa-plus"></i> Add Note</a>
									</div>
								</div>
								<div class="tab-pane" id="tab7">
									<div class="verify_msg">
										<p>You can review your inputs by clicking on Back Button. To save this itinerary Click on Submit Button.</p>
									</div>
								
								</div>
							</div>
						</div>
						<div class="form-actions">
							<div class="row">
								<div class="col-md-offset-3 col-md-9 text-right">
									<a href="javascript:;" class="btn default button-previous">
										<i class="fa fa-angle-left"></i> Back </a>
									<a href="javascript:;" class="btn btn-outline green button-next"> Save & Continue
										<i class="fa fa-angle-right"></i>
									</a>
									<a href="javascript:;" id="SubmitForm" class="btn green button-submit">Submit</a>
									<!--input type="submit" class="btn green button-submit" value="Submit"-->
									
								</div>
							</div>
						</div>
					</div>
					<input id="customer_id" type="hidden" value="<?php echo $cus->customer_id; ?>" name="customer_id">
					<input id="lead_created" type="hidden" value="<?php echo $cus->created; ?>" name="lead_created">
					<?php 
						$rand = getTokenKey(8); 
						$date = date("Ymd"); 
						$time = time(); 
						$unique_key = $rand . "_" . $date . "_" . $time; 
					?>
					<input id="unique_key" type="hidden" name="temp_key" value="<?php echo $unique_key; ?>">
					<input id="agent_id" type="hidden" name="agent_id" value="<?php echo $user_id; ?>">
					<!--Itinerary type 1=holidayz package, 2= accommondation package-->
					<input id="iti_type" type="hidden" name="iti_type" value="1">
				</form>	
				<div id="res"></div>
		</div>
		</div>
		<?php }else{ ?>
			<?php redirect("customers"); ?>
		<?php } ?>
	<!-- END CONTENT BODY -->
	</div>
 </div>
</div>

<script type="text/javascript">
jQuery(document).ready(function($){
	//prevent form to submit on enter
	/* $('#itiForm_form').on('keyup keypress', function(e) {
		var keyCode = e.keyCode || e.which;
		if (keyCode === 13) { 
			e.preventDefault();
			return false;
		}
	}); */
	//submit form
	$("#SubmitForm").click(function(){
		var formData = $('#itiForm_Frm').serializeArray();
		var resp = $("#res");
		var ajaxReq;
		if (ajaxReq) {
			ajaxReq.abort();
		}
		ajaxReq = $.ajax({
			type: "POST",
			url: "<?php echo base_url('itineraries/addItinerary'); ?>",
		   data: formData,
		   dataType: "json",
			beforeSend: function(){
				resp.html('<div class="alert alert-info"><i class="fa fa-spinner fa-spin"></i> Please wait...</div>');
			},
			success: function(res) {
				if (res.status == true){
					resp.html('<div class="alert alert-success"><strong>Success! </strong>'+res.msg+'</div>');
					//console.log("done");
					$('#itiForm_Frm')[0].reset();
					//console.log(res.msg);
					window.location.href = "<?php echo site_url('itineraries/view/');?>" + res.iti_id + "/" + res.temp_key; 
					
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
		//add here some ajax code to submit your form or just call form.submit() if you want to submit the form without ajax
	});
	//tour date picker on daywise itinerary
	/* $(document).on("click", '.tour_dt', function(){
		$(this).datepicker({startDate: '-1d', format: "dd/mm/yyyy"}).datepicker('show');
	}); */
	
	//Auto increment to tour date on first date picker change
	var count = 0;
	$(document).on("click", '.tour_dt:eq(0)', function(){
		count += 1;
		//Show alert only first click
		if (count == 1) {
			alert("Please Select First Day of tour. Next tour dates automatically changed.");
		}
		var firstSection 	= $(this).closest(".mt-repeater-item");
		var nextSection 	= firstSection.nextAll(".mt-repeater-item");
		$(this).datepicker({
			startDate: '-1d', 
			format: "dd/mm/yyyy"
		}).on('changeDate', function(ev){
			var _thisDate = ev.date;
			var z=1;
			nextSection.each(function(){
				var newT = $(this).find(".tour_dt").val().split("/");
				var newdate = moment(_thisDate).add(z++,'days'), nextDate1  = moment(newdate).format('DD/MM/YYYY');
				$(this).find(".tour_dt").val(nextDate1);
				//$(this).find(".tour_dt").datepicker('setStartDate', nextDate1);
				//console.log( z );
			});
		});
	}); 
	
	
	//set quotation defalut date
	$('.quatation_date').datepicker({startDate: 'now'});
	$('.quatation_date').datepicker('setDate', new Date());
	
	FormWizard.init();	
}); 
var FormWizard = function () {
    return {
        //main function to initiate the module
        init: function () {
            if (!jQuery().bootstrapWizard) {
                return;
            }
            var form = $('#itiForm_Frm');
            var error = $('.alert-danger', form);
            var success = $('.alert-success', form);
			var ajaxReq;
            form.validate({
                doNotHideMessage: true, //this option enables to show the error/success messages on tab switch.
                errorElement: 'span', //default input error message container
                errorClass: 'help-block help-block-error', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                rules: {
                    //package
                    package_name: {required: true},
                },
                errorPlacement: function (error, element) { // render error placement for each input type
                    error.insertAfter(element); // for other inputs, just perform default behavior
                },
                invalidHandler: function (event, validator) { //display error alert on form submit   
                    success.hide();
                    error.show();
                    App.scrollTo(error, -200);
                },
                highlight: function (element) { // hightlight error inputs
                    $(element).closest('.form-group').removeClass('has-success').addClass('has-error'); // set error class to the control group
                },
                unhighlight: function (element) { // revert the change done by hightlight
                    $(element).closest('.form-group').removeClass('has-error'); // set error class to the control group
                },

                success: function (label) {
                    label.addClass('valid').closest('.form-group').removeClass('has-error').addClass('has-success'); // set success class to the control group
                },
            });
			var handleTitle = function(tab, navigation, index) {
                var total = navigation.find('li').length;
                var current = index + 1;
                // set wizard title
                $('.step-title', $('#form_wizard_1')).text('Step ' + (index + 1) + ' of ' + total);
                // set done steps
                jQuery('li', $('#form_wizard_1')).removeClass("done");
                var li_list = navigation.find('li');
                for (var i = 0; i < index; i++) {
                    jQuery(li_list[i]).addClass("done");
                }

                if (current == 1) {
                    $('#form_wizard_1').find('.button-previous').hide();
                } else {
                    $('#form_wizard_1').find('.button-previous').show();
                }

                if (current >= total) {
                    $('#form_wizard_1').find('.button-next').hide();
                    $('#form_wizard_1').find('.button-submit').show();
                   
                } else {
                    $('#form_wizard_1').find('.button-next').show();
                    $('#form_wizard_1').find('.button-submit').hide();
                }
                App.scrollTo($('.page-title'));
            }

            // default form wizard
            $('#form_wizard_1').bootstrapWizard({
                'nextSelector': '.button-next',
                'previousSelector': '.button-previous',
                onTabClick: function (tab, navigation, index, clickedIndex) {
                    return false;
                    success.hide();
                    error.hide();
                    if (form.valid() == false) {
                        return false;
                    }
                    handleTitle(tab, navigation, clickedIndex);
                },
                onNext: function (tab, navigation, index) {
					var ajaxReq;
					var response = $("#res");
					success.hide();
                    error.hide();
					if (form.valid() == false) {
                        return false;
                    }
                    handleTitle(tab, navigation, index);
					
					 //Custom jquery
					var total = navigation.find('li').length;
					var currentIndex = index;
					
					//add hot destination on daywise iti
					if( currentIndex == 2 ){
						$(".hot_des").each(function(){
							var t_values = $(this).find(".tags_values");
							var spans = $(this).find("span");
							var tag_text_arr = $.map(spans, function(elem, index){
								return $( elem ).text();
							}).join(",");
							t_values.val(tag_text_arr);
						});
					}
					
				 	//get value for second step
					var formData 	= $('#itiForm_Frm').serializeArray();
					//Push step to form data
					var step = { name: "step",  value: currentIndex };
					formData.push(step);
					
					//check for ajax request
					if (ajaxReq) {
						ajaxReq.abort();
					}
					ajaxReq = $.ajax({
						type: "POST",
						url: "<?php echo base_url('itineraries/ajax_savedata_stepwise'); ?>",
						data: formData,
						dataType: "json",
						beforeSend: function(){
							//response.html('<p><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
						},
						success: function(res) {
							if (res.status == true){
								//$('#form_wizard_1').find('.button-next').show();
								console.log("save");
								//response.html("");
							}else{
								//response.html('<div class="alert alert-danger"><strong>Error! </strong>'+res.msg+'</div>');
								console.log("error"+ res.msg);
							}
						},
						error: function(e){
							//response.html('<div class="alert alert-danger"><strong>Error! </strong>Please try again.</div>');
							console.log("error");
						}
					});   
				},
                onPrevious: function (tab, navigation, index) {
                    success.hide();
                    error.hide();
                    handleTitle(tab, navigation, index);
                },
                onTabShow: function (tab, navigation, index) {
					//check if step is 2
					var total = navigation.find('li').length;
                    var current = index + 1;
                    var $percent = (current / total) * 100;
                    $('#form_wizard_1').find('.progress-bar').css({
                        width: $percent + '%'
                    });
                }, 
				
            });
            $('#form_wizard_1').find('.button-previous').hide();
            $('#form_wizard_1 .button-submit').hide(); 
        }
    };
}();

</script>

<script type="text/javascript">
var FormRepeater = function () {
    return {
        //main function to initiate the module
        init: function () {
			/*Day wise itinerary */
			jQuery('.mt-repeater').each(function(){
				var nexti = 1;
				$(this).find(".del_rep").hide();
				$(this).repeater({
					show: function () {
						//set day wise itinerary preview
						var from = $(this).prev(".mt-repeater-item").find(".tour_dt").val().split("/");
						var f = new Date(from[2], from[1] - 1, from[0]);
						var new1 = moment(f).add(1,'days'), nextDate  = moment(new1).format('DD/MM/YYYY');
                        $(this).find(".tour_dt").val(nextDate); 
						//	console.log($(this).prev(".mt-repeater-item").repeaterVal()); //to retrieve the latest list 
						var tour_data = $(this).prev(".mt-repeater-item").repeaterVal();
						var count_daywise_div	 = $('.daywise_section').length;
						var c_day = count_daywise_div-1;
						//console.log("day " + c_day);
						//console.log(tour_data);
						var resultData	  = $("#tour_data_preview");
						var tour_day 	  = tour_data["tour_meta"][0]["tour_day"];
						var tour_name 	  = tour_data["tour_meta"][0]["tour_name"];
						var tour_des 	  = tour_data["tour_meta"][0]["tour_des"];
						var tour_date 	  = tour_data["tour_meta"][0]["tour_date"];
						var tour_distant  = $(this).prev(".mt-repeater-item").find(".tour_distant").val();
						var meal_plan  	  = tour_data["tour_meta"][0]["meal_plan"];
						//console.log("Tour: " + tour_name);
						resultData.append("<div class='day_wise_preview' id=day_" + c_day  + "><strong class='day_pr'> Day: <span class='dd'>" + tour_day + "</span> </strong><h2>" + tour_name + "</h2><br>Tour Description: " + tour_des + "</div><br>Tour Date: " + tour_date + "</div><br>Meal Plan: " + meal_plan + "</div><br>Tour Distant: " + tour_distant + " Kilometer </div>" );
						
						//end set preview
						
						var ddd = $(this).prev(".mt-repeater-item").find(".sta_d").text();
						$(this).find(".sta_d").text(+ddd + +1);
						$(this).find(".del_rep").show();
	                	$(this).show();
						nexti++;
					},
		            hide: function (deleteElement) {
		                if(confirm('Are you sure you want to delete this element?')) {
							var get_current_div = $(this).find(".sta_d").text();
							//remove day from preview
							var rem_div = $("#tour_data_preview").find("#day_" + get_current_div );
							var nextDayDiv = rem_div.nextAll( ".day_wise_preview" );
							nextDayDiv.each(function(){
								var z=1;
								/*substract day*/
								var nexD = $(this).find(".dd").text(), ss = 1;
								var dSub = nexD - ss;
								$(this).find(".dd").text(dSub);
								$(this).attr("id", "day_" + dSub);
								ss++;
								console.log(nexD);
							});
							rem_div.remove();
							//console.log( get_current_div );
							nexti--;
						    $(this).slideUp(deleteElement);
							var nextDiv = $(this).nextAll(".mt-repeater-item");
							nextDiv.each(function(){
								var z=1;
								var newT = $(this).find(".tour_dt").val().split("/");
								var ff = new Date(newT[2], newT[1] - 1, newT[0]);
								var new11 = moment(ff).subtract(z++,'days'), nextDate1  = moment(new11).format('DD/MM/YYYY');
								$(this).find(".tour_dt").val(nextDate1);
								/*subtract day*/
								var nexD = $(this).find(".sta_d").text(), ss = 1;
								var dSub = nexD - ss;
								$(this).find(".sta_d").text(dSub);
								ss++;
							});
						}
		            },
		            ready: function (setIndexes) {
						
		            },
				});
			});
			/* Tour field repeater */
			jQuery('.tour_field_repeater').each(function(){
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
			/* Special inc Tour field repeater */
			jQuery('.tour_field_repeater_sp').each(function(){
				$(this).repeater({
					show: function () {
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

jQuery(document).ready(function($) {
	FormRepeater.init();
});
</script>   

<script type="text/javascript">
	$(function(){ 
		// ::: TAGS BOX
		$(document).on("focusout", ".hot_des input",function() {
			//var txt = this.value.replace(/[^a-z0-9\+\-\.\#]/ig,''); // allowed characters
			var txt = this.value;
			if(txt){
				$("<span/>", {text:txt.toLowerCase(), insertBefore:this});
			}	
			this.value = "";
		});
		$(document).on("keyup", ".hot_des input",function(ev) {
			// if: comma|enter (delimit more keyCodes with | pipe)
			if(/(188|13)/.test(ev.which)) $(this).focusout(); 
		});
		$(document).on("click", ".hot_des span, .hotel_des span", function() {
			$(this).remove(); 
		});
	});
</script>
<!--hotel suggesions script-->
<script>
//attraction
jQuery(document).ready(function ($) {
    $(document).on("keyup", ".hotel_des_sug",function(ev) {
		var _this = $(this);
		var dropdownUl = _this.parent().find('.dropdownhotels');
		dropdownUl.show();
		//console.log( dropdownUl );
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('/itineraries/get_hotels_suggestion'); ?>",
            data: {
                keyword: _this.val()
            },
            dataType: "json",
			success: function (data) {
				//console.log(data);
				if (data.length > 0) {
					dropdownUl.empty();
					_this.closest('.dropdown-menu').show();
				}
				
				else if (data.length == 0) {
					dropdownUl.html("");
					dropdownUl.append('<li role="displaycuslist" ><a role="menuitem dropdowncusli" data-city_id = "" class="dropdownlivalue"><strong>No Data Found</strong></a></li>');
				}
				
				$.each(data, function (key,value) {
					console.log( value );
					if (data.length >= 0){
						var hotel_name = value['hotel_name'];
						dropdownUl.append('<li role="displaycuslist" ><a role="menuitem dropdowncusli" data-hotel_id = '+ value['id'] +' data-hotel_name= "' + hotel_name + '" class="dropdownlivalue"><strong>' + value['hotel_name'] + ' - ' + value['city'] + '</strong> - ' + value['id'] + ' </a></li>');
					}	
				});
			}
        });
		//this.value = "";
    });
	
	$(document).on('click', 'ul.dropdownhotels li a', function (e) {
		e.preventDefault();
		var tags = $(this).parent().parent().parent().find(".hotel_tags_values");
		//console.log( tags );
		$(".hotel_des_sug").val("");
		var hotel_id = $(this).attr("data-hotel_id");
		var hotel_name = $(this).attr("data-hotel_name");
		//console.log( city_id );
		$('.dropdownhotels').hide();
		//resp.html("please wait...");
		if (!!hotel_name) {
			var txt = hotel_name;
			//console.log( txt );
			//$("<span></span>", {text:txt.toLowerCase(), insertBefore:tags });
		    $("<span data-hotel_id="+ hotel_id +">"+ txt.toLowerCase() +"</span>").insertBefore(tags);

		}
	});	
});
</script>

														
<!--script for flight section-->
<script type="text/javascript">
jQuery(document).ready(function($){
	//Show flight details section
	$(document).on("click", '#flight_ck', function() {
		if (!$(this).is(':checked')) {
			$("#flight_section").slideUp();
		}else{
			$("#flight_section").slideDown();
		}
	});		
	
	//round trip toggle		
	$(document).on("change", 'input[name=trip_r]:radio', function() {
		var filter_val = $(this).val();
		if( filter_val == "round" ){
			$("#return_date, #return_arr_date").addClass("flight_dateTime");
			$("#return_date, #return_arr_date").attr("required", "required");
			$("#return_date, #return_arr_date").removeAttr("disabled");
			//show datetimepicker
			$(".flight_dateTime").datetimepicker({
				format: "yyyy-mm-dd - HH:ii P",
				showMeridian: true,
				startDate: "+1d",
			});
		}else{
			$("#return_date, #return_arr_date").removeClass("flight_dateTime");
			$("#return_date, #return_arr_date").removeAttr("required");
			$("#return_date, #return_arr_date").attr("disabled", "disabled");
			$("#return_date, #return_arr_date").val("");
		}
		console.log(filter_val);
	});
	
	//show datetimepicker
	$(".flight_dateTime").datetimepicker({
		format: "yyyy-mm-dd - HH:ii P",
		showMeridian: true,
		startDate: "+1d",
	});
	
});
</script>
<!--script for Train section-->
<script type="text/javascript">
jQuery(document).ready(function($){
	//Show train details section
	$(document).on("click", '#train_ck', function() {
		if (!$(this).is(':checked')) {
			$("#train_section").slideUp();
		}else{
			$("#train_section").slideDown();
		}
	});		
	
	//round trip toggle		
	$(document).on("change", 'input[name=t_trip_r]:radio', function() {
		var filter_val = $(this).val();
		if( filter_val == "round" ){
			$("#t_return_date, #t_return_arr_date").addClass("train_dateTime");
			$("#t_return_date, #t_return_arr_date").attr("required", "required");
			$("#t_return_date, #t_return_arr_date").removeAttr("disabled");
			//show datetimepick#t_return_arr_dateer
			$(".train_dateTime").datetimepicker({
				format: "yyyy-mm-dd - HH:ii P",
				showMeridian: true,
				startDate: "+1d",
			});
		}else{
			$("#t_return_date, #t_return_arr_date").removeClass("train_dateTime");
			$("#t_return_date, #t_return_arr_date").removeAttr("required");
			$("#t_return_date, #t_return_arr_date").attr("disabled", "disabled");
			$("#t_return_date, #t_return_arr_date").val("");
		}
		console.log(filter_val);
	});
	
	//show datetimepicker
	$(".train_dateTime").datetimepicker({
		format: "yyyy-mm-dd - HH:ii P",
		showMeridian: true,
		startDate: "+1d",
	});
	
});
</script>