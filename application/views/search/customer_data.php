

<div class="page-container">
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
   </style>
   <div class="page-content-wrapper">
      <div class="page-content">
         <?php  $id = isset($_GET['id']) && !empty($_GET['id']) ? $_GET['id']:0 ;  ?>
         <!-- BEGIN SAMPLE TABLE PORTLET-->
         <?php $message = $this->session->flashdata('success'); 
            if($message){ echo '<span class="help-block help-block-success">'.$message.'</span>';}
            ?>
         <div class="portlet box blue">
            <div class="portlet-title">
               <div class="caption">
                  <i class="fa fa-users"></i>Search Customers Status
               </div>
            </div>
            <input id="sId" type="hidden" value="<?php if(isset($id)){ echo $id ; } ?>" >
            <div class="portlet-body">
               <div class="marginBottom">
                  <!--start filter section-->
                  <div class="note">If you have not customer id <a target="_blank" href="<?php echo base_url("customers"); ?>">Click here</a></div>
                  <form id="search_customer_data" class="form-inline">
                     <div class="form-group">
                        <label for="customer_id">Enter Customer ID/name/contact:</label>
                        <input type="text" id="customer_id" required maxlength="20" name="keyword" value="<?php if(isset($id)){ echo $id ; } ?>"  class="form-control" placeholder="Type Customer Id or Customer Name" title="Type Customer Id or Customer Name or Contact Number" /> 
                        <ul class="dropdown-menu txtcustomer" style="margin-left:150px;margin-right:0px;" role="menu" aria-labelledby="dropdownMenu"  id="DropdownCusInfo"></ul>
                     </div>
                     <!--button id="sbmt" type="submit" class="btn btn-success"><i class="fa fa-search"></i> Search</button-->
                  </form>
                  <hr class="clearfix"/>
                  <!--ajax response data-->
               </div>
            </div>
         </div>
         <div class="response"></div>
         <div class="clearfix"></div>
         <div class="result_data" style="display: none;">
            <div class="row">
               <div class="col-md-6">
                  <div class="row customer_info_res"></div>
                  <!--customer information-->
               </div>
               <div class="col-md-6">
                  <div class="iti_followup_response"></div>
                  <div class="cus_followup_response"></div>
                  <div class="clearfix"></div>
               </div>
            </div>
         </div>
         <hr>
         <!-- Process for customer followup  -->
         <div id="customer_f" class="col-md-12 clearfix" style="display: none;">
            <a class="btn btn-danger" href="#" id="add_call_btn" title="Back">Add Call Info</a>
            <div class="call_log" id="call_log_section">
               <form id="call_detais_form" id="lead_frm">
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
                        <div class="call_type_res col-md-4" id="picked_call_panel">
                           <!--picked call panel-->
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
                        </div>
                        <!--end picked call panel-->
                        <div class="call_type_res" id="call_not_picked_panel">
                           <!--call_not_picked panel-->
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
                              <div class="clearfix"></div>
                              <div class="col-md-6">
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
                           <div class="form-group col-md-6">
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
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label for="comment">Decline Comment:</label>
                                 <textarea class="form-control" rows="3" name="decline_comment" id="decline_comment"></textarea>
                              </div>
                           </div>
                        </div>
                        <!--end close_lead_panel-->	
                     </div>
                     <!--panel_section end-->
                     <div class="clearfix"></div>
                     <div id="customer_info_panel">
                        <div class="clearfix"></div>
                        <div class="col-lg-4 col-md-6">
                           <div class="form-group">
                              <label for="">Whatsapp Number:</label>
                              <input type="text" class="form-control" placeholder="Whatsapp Number" name="whatsapp_number" value="">
                           </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                           <div class="form-group">
                              <label for="">Adults *:</label>
                              <input required type="text" class="form-control" placeholder="No. of Adults" name="adults" value="">
                           </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                           <div class="form-group">
                              <label for="">Child:</label>
                              <input type="text" class="form-control" placeholder="No. of child" name="child" value="">
                           </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                           <div class="form-group">
                              <label for="">Age of the child:</label>
                              <input type="text" class="form-control" placeholder="Child age. eg: 13,12" name="child_age" value="">
                           </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
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
                        <div class="col-lg-4 col-md-6">
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
                        <div class="col-lg-4 col-md-6">
                           <div class="form-group">
                              <label for="">Travel Date *:</label>
                              <input required type="text" class="form-control" readonly id="travel_date" name="travel_date" value="">
                           </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                           <div class="form-group">
                              <label for="">Destination *:</label>
                              <input required type="text" class="form-control" name="destination" value="">
                           </div>
                        </div>
                        <div class="col-lg-4 col-md-6 hide_accommodation">
                           <div class="form-group">
                              <label for="">Pick Up Point *:</label>
                              <input required type="text" class="form-control" name="pick_point" value="">
                           </div>
                        </div>
                        <div class="col-lg-4 col-md-6 hide_accommodation" >
                           <div class="form-group">
                              <label for="">Dropping Point *:</label>
                              <input required type="text" class="form-control" name="drop_point" value="">
                           </div>
                        </div>
                        <div class="col-lg-4 col-md-6 hide_accommodation">
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
                        <div class="col-lg-4 col-md-6">
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
                        <div class="col-lg-4 col-md-6">
                           <div class="form-group">
                              <label for="">Honeymoon Kit *:</label>
                              <input type="text" class="form-control" placeholder="" name="honeymoon_kit" value="">
                           </div>
                        </div>
                        <div class="col-lg-4 col-md-6 hide_accommodation">
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
                        <div class="col-lg-4 col-md-6">
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
                        <div class="col-lg-4 col-md-6">
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
                     </div>
                     <!--End customer info Section-->
                     <div class="clearfix"></div>
                  </div>
                  <input type="hidden" name="customer_id" value="" id="customer_id_followup">
                  <div class="clearfix"></div>
                  <div class="margiv-top-10">
                     <button type="submit" id="submit_frm" class="btn green uppercase submit_frm">Submit</button>
                     <button class="btn red uppercase cancle_bnt">Cancel</button>
                  </div>
                  <div class="clearfix"></div>
                  <div id="resp"></div>
               </form>
            </div>
         </div>
         <!--end customer followup status-->
         <!--chart section-->
         <div class="clearfix"></div>
         <hr>
         <div id="chartContainer" style="height: 300px; width: 100%;"></div>
         <div id="line_chart"></div>
      </div>
   </div>
   <!--div class="clearfix"></div>
      <div class="col-md-6">
      	<h3 class='text-center uppercase'>Total Itineraries</h3>
      	<div class="total_iti_response"></div>
      </div-->
</div>
<!--end ajax response data-->
<style>
   #pakcageModal{top: 20%;}
</style>
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
   </div>
</div>
<script type="text/javascript">
   jQuery(document).ready(function($){
   	var search_id = $("#sId").val();
   	if( search_id == "" || search_id == 0 ){
   		console.log("e");
   	}else{
   		load_customer_follup_data(search_id);
   		console.log( search_id );	
   	}
   	
   	//open followup on click
   	$(document).on("click", 'ul.txtcustomer li a', function (e){
   		e.preventDefault();
   		$("#call_log_section").slideUp();
   		$("#add_call_btn").fadeIn();
   		console.log("clicked");
   		$('#customer_id').val( $(this).attr("data-customer_id") );
   		$('#DropdownCusInfo').hide();
   		var customer_id = $(this).attr("data-customer_id");
   		load_customer_follup_data(customer_id, );
   	});	
   	
   	//load customer followup data
   	function load_customer_follup_data( customer_id ){
   		//list select
   		//$('ul.txtcustomer').on('click', 'li a', function (){
   		//chart data
   		//var siD=$('#customer_id').val();
   		//console.log(customer_id);
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
   	$("#travel_date").datepicker({ startDate: "-2d" , format: "mm/dd/yyyy",});
   	//reset all fields
   	function resetForm(){
   		$("#call_detais_form").find("input[type=text],input[type=number], textarea,select, .comment").val("");
   		$("#call_detais_form").find('input:checkbox').removeAttr('checked');
   		$("#call_detais_form").find('.call_type_not_answer').removeAttr('checked');
   		$("#call_detais_form").find('#readyQuotation').removeAttr('checked');
   		$("#call_detais_form").find('.quotation_type').removeAttr('checked');
   		$("#call_detais_form").find('#nxtCallCk').removeAttr('checked');
   		$(".nxt_call").hide();
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
   							
   							window.location.href = "<?php echo site_url();?>search/?id=" + res.customer_id;
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

