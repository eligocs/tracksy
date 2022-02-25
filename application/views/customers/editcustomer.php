<div class="page-container customer_content">
	<div class="page-content-wrapper">
		<div class="page-content">
		<?php if( $customers ){
			$customer = $customers[0];		?>
			<?php $attributes = array('id' => 'editCustomer'); ?>
				<?php echo form_open('customers/editcustomer', $attributes); ?>
				<div class="portlet box blue">
					<div class="portlet-title">
						<div class="caption"><i class="fa fa-users"></i>Customer Name: <strong><?php  echo $customer->customer_name; ?></strong>  Customer Type: <strong class=''><?php  echo get_customer_type_name($customer->customer_type); ?></strong>
							<?php echo $customer->cus_status == "8" ? "<< <strong class=''>Declined Lead</strong> >> " : "";  ?>
						</div>
						<a class="btn btn-success" href="<?php echo site_url("customers"); ?>" title="Back">Back</a>
					</div>
				</div>
				<!--Hide Extra fields if quotation type == accommodation -->
				<?php $quo_type = $customer->quotation_type; 
					$hide_accommodation = $quo_type == "accommodation" ? "hide_accommodation" : "";
				?>
				<style> .hide_accommodation{display: none; }</style>
				
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4>Quotation Type: <?php echo ucfirst ( $quo_type ); ?> 
							<?php if( is_admin_or_manager() ){ ?>
								<strong class="pull-right">Agent:  <span class='green'><?php echo get_user_name( $customer->agent_id ); ?></span></strong>
							<?php } ?>
						</h4>
						</div>
				
				<div class="panel-body row">
				<div class="col-md-4">
				<div class="form-group">
					<label class="control-label">Customer Name*</label>
					<input required type="text" placeholder="Customer Name eg: Prem Thakur" name="inp[customer_name]" class="form-control textfield" value="<?php if(isset($customer->customer_name)){ echo $customer->customer_name; }else{ echo set_value('inp[customer_name]'); } ?>"/> 
				</div>
				</div>
				<div class="col-md-4">
				<div class="form-group">
					<label class="control-label">Email*</label>
					<input required type="email" placeholder="Email" name="inp[customer_email]" class="form-control" value="<?php if(isset($customer->customer_email)){ echo $customer->customer_email; }else{ echo set_value('inp[customer_email]'); } ?>"/> 
				</div>
				</div>
			
				<div class="col-md-4">
					<div class="form-group">
						<label class="control-label">Contact Number*</label>
						<input required type="number" placeholder="Customer Phone Number" name="inp[customer_contact]" class="form-control" value="<?php if(isset($customer->customer_contact)){ echo $customer->customer_contact; }else{ echo set_value('inp[customer_contact]'); } ?>"/> 
					</div>
				</div>
				
				<!--reassign lead if not followup taken-->
				<?php if( empty( $customer->cus_status ) &&  empty($customer->cus_last_followup_status) ){ ?>
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Reassign To</label>
							<select name="reassign_agent_id" class="form-control">
								<option  value="">Select Sales Team Agents</option>
								<?php 
									if( is_admin_or_manager() ){
										$agents = get_all_sales_team_loggedin_today();
										if($agents){
											foreach( $agents as $a ){
												if( $a->user_id == $customer->agent_id ) continue;
												$count_leads = get_assigned_leads_today( $a->user_id );
												$count_leads = !empty( $count_leads ) ? "( {$count_leads} )" : "";
												$agent_full_name = $a->first_name . ' ' . $a->last_name;
												echo '<option value="'. $a->user_id . '">' . $a->user_name .' ( '. $agent_full_name . ' ) '. $count_leads .' </option>';
											}
										}else{
											echo '<option value="">No Loggedin Agent Found!</option>';
										}	
									}else if( is_teamleader() ){
										$logedin_agents = is_teamleader();
										if( $logedin_agents ){
											foreach( $logedin_agents as $agent ){
												//if( !is_agent_login_today( $agent ) ) continue;
												$count_leads = get_assigned_leads_today($agent);
												$count_leads = !empty( $count_leads ) ? "( {$count_leads} )" : "";
												echo '<option value="'. $agent . '">' . get_user_name($agent) . $count_leads .' </option>';
											}
										}else{
											echo '<option value="">No Loggedin Agent Found!</option>';
										}	
									}else{
										echo '<option value="">No Loggedin Agent Found!</option>';
									}	
								?>
							</select>
						</div>
					</div>
				<?php } ?>
				<!--edit additional information customer if exists -->
				
				
				<?php if( !empty( $customer->adults ) && !empty($customer->hotel_category) ){ ?>
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Adults*</label>
							<input required type="text" placeholder="No. of adults" name="inp[adults]" class="form-control" value="<?php if(isset($customer->adults)){ echo $customer->adults; }else{ echo set_value('inp[adults]'); } ?>"/> 
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Whatsapp Number</label>
							<input type="text" placeholder="Whatsapp Number" name="inp[whatsapp_number]" class="form-control" value="<?php if(isset($customer->whatsapp_number)){ echo $customer->whatsapp_number; }else{ echo set_value('inp[whatsapp_number]'); } ?>"/> 
						</div>
					</div>
					
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">No. of Child</label>
							<input type="text" placeholder="No. of child" name="inp[child]" class="form-control" value="<?php if(isset($customer->child)){ echo $customer->child; }else{ echo set_value('inp[child]'); } ?>"/> 
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Child age</label>
							<input type="text" placeholder="Child age. eg: 12,13" name="inp[child_age]" class="form-control" value="<?php if(isset($customer->child_age)){ echo $customer->child_age; }else{ echo set_value('inp[child_age]'); } ?>"/> 
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group row">
							<div class="col-sm-6">
								<label class="control-label">Package Type*</label>
								<?php $pkgType = $customer->package_type; ?>

								<select required name="inp[package_type]" id="package_type" class="form-control">
									<option value="">Choose Package Type</option>
									<option <?php if ( $pkgType == "Honeymoon Package" ) { ?> selected="selected" <?php } ?> value="Honeymoon Package">Honeymoon Package</option>
									<option value="Fixed Departure" <?php if ( $pkgType == "Fixed Departure" ) { ?> selected="selected" <?php } ?>>Fixed Departure</option>
									<option value="Group Package" <?php if ( $pkgType == "Group Package" ) { ?> selected="selected" <?php } ?>>Group Package</option>
									<option value="Other" <?php if ( $pkgType == "Other" ) { ?> selected="selected" <?php } ?>>Other</option>
								</select>
							</div>	
							<div class="col-sm-6">
							<label>&nbsp;</label>
							<?php $othPack = $pkgType == "Other" ? "block" : "none"; ?>
								<input style="display: <?php echo $othPack; ?>;" type="text" required class="form-control" value="<?php if(isset($customer->package_type_other)){ echo $customer->package_type_other; }else{ echo set_value('inp[package_type_other]'); } ?>" name="inp[package_type_other]" id="pack_type_other">
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Total Rooms*</label>
							<?php $srooms =  isset($customer->total_rooms) ? $customer->total_rooms : ""; ?>
							<select required class="form-control" name="inp[total_rooms]">
								<option value="">Select Rooms</option>
								<?php for( $r=1 ; $r <=20 ; $r++ ){ ?>
									<option value="<?php echo $r; ?>" <?php if( $srooms == $r ){ ?> selected="selected" <?php } ?> ><?php echo $r; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Travel Date*</label>
							<input required readonly type="text" name="inp[travel_date]" class="form-control" id="travel_date" value="<?php if(isset($customer->travel_date)){ echo $customer->travel_date; }else{ echo set_value('inp[travel_date]'); } ?>"/> 
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Destination*</label>
							<input required placeholder="Destination" type="text" name="inp[destination]" class="form-control" id="destination" value="<?php if(isset($customer->destination)){ echo $customer->destination; }else{ echo set_value('inp[destination]'); } ?>"/> 
						</div>
					</div>
					<div class="col-md-4 <?php echo $hide_accommodation; ?>">
						<div class="form-group">
							<label class="control-label">Pick Up Point*</label>
							<input required placeholder="Pick Up Point" type="text" name="inp[pickup_point]" class="form-control" id="pickup_point" value="<?php if(isset($customer->pickup_point)){ echo $customer->pickup_point; }else{ echo set_value('inp[pickup_point]'); } ?>"/> 
						</div>
					</div>
					<div class="col-md-4 <?php echo $hide_accommodation; ?>">
						<div class="form-group">
							<label class="control-label">Dropping Point*</label>
							<input required placeholder="No. of rooms required" type="text" name="inp[droping_point]" class="form-control" id="droping_point" value="<?php if(isset($customer->droping_point)){ echo $customer->droping_point; }else{ echo set_value('inp[droping_point]'); } ?>"/> 
						</div>
					</div>
					<div class="col-md-4 <?php echo $hide_accommodation; ?>">
						<div class="form-group row">
							<div class="col-sm-6">
							<label class="control-label">Package By Car/volvo*</label>
							<?php $pkgBy = $customer->package_car_type; ?>
							<select required name="inp[package_car_type]" id="package_by" class="form-control">
								<option value="">Choose Package By</option>
								<option <?php if ( $pkgBy == "Car" ) { ?> selected="selected" <?php } ?> value="Car">Car</option>
								<option <?php if ( $pkgBy == "Volvo" ) { ?> selected="selected" <?php } ?> value="Volvo">Volvo</option>
								<option <?php if ( $pkgBy == "Other" ) { ?> selected="selected" <?php } ?> value="Other">Other</option>
							</select>
							</div>
							<div class="col-sm-6">
							<label>&nbsp;</label>
								<?php $ostyle = $pkgBy == "Other" ? "block" : "none"; ?>
								<input style="display: <?php echo $ostyle; ?>;" type="text" required class="form-control" value="<?php if(isset($customer->package_car_type_other)){ echo $customer->package_car_type_other; }else{ echo set_value('inp[package_car_type_other]'); } ?>" name="inp[package_car_type_other]" id="other_pack">
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Meal Plan*</label>
							<select required name="inp[meal_plan]" class="form-control">
								<option value="">Choose Meal Plan</option>
								<option value="Breakfast Only" <?php if ( $customer->meal_plan == "Breakfast Only" ) { ?> selected="selected" <?php } ?> >Breakfast Only</option>
								<option <?php if ( $customer->meal_plan == "Breakfast & Dinner" ) { ?> selected="selected" <?php } ?> value="Breakfast & Dinner"> Breakfast & Dinner</option>
								<option <?php if ( $customer->meal_plan == "Breakfast, Lunch & Dinner" ) { ?> selected="selected"  <?php } ?> value="Breakfast, Lunch & Dinner">Breakfast, Lunch & Dinner</option>
								<option <?php if ( $customer->meal_plan == "Dinner Only" ) { ?> selected="selected" <?php } ?> value="Dinner Only">Dinner Only</option>
								<option <?php if ( $customer->meal_plan == "No Meal Plan" ) { ?> selected="selected" <?php } ?> value="No Meal Plan">No Meal Plan</option>
							</select>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Honeymoon Kit</label>
							<input placeholder="" type="text" name="inp[honeymoon_kit]" class="form-control" id="honeymoon_kit" value="<?php if(isset($customer->honeymoon_kit)){ echo $customer->honeymoon_kit; }else{ echo set_value('inp[honeymoon_kit]'); } ?>"/> 
						</div>
					</div>
					<div class="col-md-4 <?php echo $hide_accommodation; ?>">
						<div class="form-group">
							<label class="control-label">Car Type for sightseeing*</label>
							<?php $car_type = isset($customer->car_type_sightseen) ? $customer->car_type_sightseen : ""; ?>
							<select required name="inp[car_type_sightseen]" class="form-control">
								<option value="">Choose Car Category</option>
								<?php $cars = get_car_categories(); 
									if( $cars ){
										foreach($cars as $car){
											$selected = $car_type == $car->id ? "selected = selected" : "";
											echo '<option value = "'.$car->id .'" ' . $selected . ' >'.$car->car_name.'</option>';
										}
									}
								?>
							</select>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Hotel Category*</label>
							<select required name="inp[hotel_category]" class="form-control">
								<option value="">Choose hotel category</option>
								<option <?php if ( $customer->hotel_category == "Deluxe" ) { ?> selected="selected" <?php } ?> value="Deluxe">Deluxe</option>
								<option <?php if ( $customer->hotel_category == "Super Deluxe" ) { ?> selected="selected"  <?php } ?> value="Super Deluxe">Super Deluxe</option>
								<option <?php if ( $customer->hotel_category == "Luxury" ) { ?> selected="selected" <?php } ?> value="Luxury">Luxury</option>
								<option <?php if ( $customer->hotel_category == "Super Luxury" ) { ?> selected="selected" <?php } ?> value="Super Luxury">Super Luxury</option>
							</select> 
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Budget Approx*</label>
							<input required placeholder="" type="text" name="inp[budget]" class="form-control" id="budget" value="<?php if(isset($customer->budget)){ echo $customer->budget; }else{ echo set_value('inp[budget]'); } ?>"/> 
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Country*</label>
							<select required name="inp[country_id]" class="form-control country">
								<option value="">Select country</option>
								<?php $country = get_country_list();
								if($country){
									foreach( $country as $c ){
										$selected = $c->id == $customer->country_id ? "selected" : ""; 
										echo "<option {$selected} value={$c->id}>{$c->name}</option>";
									}
								}
								?>
							</select> 
						</div>
					</div>
					
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">State*</label>
							<select required name="inp[state_id]" class="form-control state">
								<option value="">Select state</option>
								<?php $states = get_state_list($customer->country_id);
								if($states){
									foreach( $states as $state ){
										$selected = $state->id == $customer->state_id ? "selected" : ""; 
										echo "<option {$selected} value={$state->id}>{$state->name}</option>";
									}
								}
								?>
							</select> 
						</div>
					</div>
					
				<?php } ?>
				
				<div class="clearfix"></div>
				<div class="margiv-top-10 col-md-4">
					<input type="hidden" name="customer_id" type="text" value="<?php echo $customer->customer_id; ?>"/>
					<input type="hidden" name="temp_key" type="text" value="<?php echo $customer->temp_key; ?>"/>
					<button type="submit" class="btn green uppercase edit_Customer">Save Customer</button>
				</div>
			</form>
			<div id="res"></div>		
		</div>
		</div>
		</div>
		<?php }else{
			redirect("customers");
		} ?>
	<!-- END CONTENT BODY -->
	</div>
<!-- Modal -->
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
	
	//Show text box if other package_by choose
	$(document).on("change", "#package_by", function(e){
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
	$(document).on("change", "#package_type", function(e){
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
	
	$("#travel_date").datepicker();
	var form = $("#editCustomer");
	form.validate();

	/* jQuery.validator.addMethod("lettersonly", function(value, element) {
	  return this.optional(element) || /^[a-z]+$/i.test(value);
	}, "Letters only please"); 
	//validate textfield
	jQuery.validator.addClassRules('textfield', {
        required: true ,
		lettersonly: true
    });	 */
}); 
</script>
