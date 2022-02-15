<?php $customer = $customer[0];  ?>
<div class="page-container customer_view_section view_call_info">
   <?php  if($customer){ ?>
   <div class="page-content-wrapper">
      <div class="page-content">
         <!-- BEGIN SAMPLE TABLE PORTLET-->
         <?php $message = $this->session->flashdata('success'); 
            if($message){ echo '<span class="help-block help-block-success">'.$message.'</span>';}
            ?>
         <div class="portlet box blue">
            <div class="portlet-title">
               <div class="caption"><i class="fa fa-users"></i><span>Customer Detail </span>
                  <?php if( is_admin_or_manager() ){ ?>
                  <a class="btn btn-danger" style="display:inline;"
                     href="<?php echo site_url("customers/edit/{$customer->customer_id}"); ?>"
                     title="Edit Customer Info">Edit Customer</a>
                  <?php } ?>
               </div>
               <div class="actions">
                  <a class="btn btn-success" href="<?php echo site_url("customers"); ?>" title="add hotel">Back To
                  All Leads</a>
               </div>
            </div>
         </div>
         <div class="portlet-body second_custom_card">
            <?php
               //$d = date("Y",strtotime("946665000000"));
               //echo $d;
               //echo date("Y-m-d", $d);
               ?>
            <div class="customer-details">
               <div class="row">
                  <div class="col-md-6 col-lg-4">
                     <div class="col-md-6 form_vl"><strong>Customer Id:</strong></div>
                     <div class="col-md-6 form_vr"><?php echo $customer->customer_id; ?></div>
                  </div>
                  <div class="col-md-6 col-lg-4">
                     <div class="col-md-6 form_vl"><strong>Customer Type:</strong></div>
                     <?php 
                        $cus_type 			= get_customer_type_name($customer->customer_type);
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
                     <div class="col-md-6 form_vr">
                        <?php echo !empty( $customer->child ) ? $customer->child : "N/A" ; ?>
                     </div>
                  </div>
                  <div class="col-md-6 col-lg-4">
                     <div class="col-md-6 form_vl"><strong>Child Age:</strong></div>
                     <div class="col-md-6 form_vr">
                        <?php echo !empty( $customer->child_age ) ? $customer->child_age : "N/A" ; ?>
                     </div>
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
                     <div class="col-md-6 form_vr"><?php echo display_date_month_name($customer->travel_date); ?>
                     </div>
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
                     <div class="col-md-6 form_vr"><?php echo get_car_name($customer->car_type_sightseen); ?>
                     </div>
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
               </div>
               <!-- row -->
            </div>
         </div>
         <div class="clearfix"></div>
         <hr>
         <!-- if customer approved query -->
         <?php if(  $customer->cus_status == 9 ){  ?>
         <div class="panel panel-default">
            <div class="panel-heading uppercase">
               <h4><?php echo $customer->quotation_type; ?> Package </strong></h4>
            </div>
            <div class="panel-body">
               <div class="note note-info">
                  <p style="font-size: 16px;">Query Approved By Customer. Please go through with Quotation</p>
               </div>
               <?php }elseif( $customer->cus_status == 8 ){ ?>
               <!-- if customer decline query  -->
               <div class="custom_card">
                  <h3 class="uppercase red font_size_18"><strong><?php echo $customer->quotation_type; ?> Package </strong></h3>
                  <!--reassign lead if not followup taken-->
                  <?php if( is_admin_or_manager() ){ ?>
                  <?php $action =  isset( $_GET['action'] ) && $_GET['action'] == "reopen" ? "true" : ""; ?>
                  <div class="row">
                     <label class="col-lg-4 d-flex align_items_center" for="btn_reopen">
                     <input title="REOPEN LEAD" type="checkbox" <?php echo $action ? "checked" : ""; ?>
                        class="form-control repopen_lead" id="btn_reopen"> Reopen Lead
                     </label>
                     <div class="col-lg-8" id="reopen_lead" style="display: <?php echo $action ? "block" : "none"; ?>;">
                        <form id="frmreopen_lead" class="form-inline">
                           <div class="form-group">
                              <label class="control-label">Assign To</label>
                              <select required name="reassign_agent_id" class="form-control">
                                 <option value="">Select Sales Team Agents</option>
                                 <?php $agents = get_all_sales_team_loggedin_today();
                                    if($agents){
                                       foreach( $agents as $a ){
                                          //if( $a->user_id == $customer->agent_id ) continue;
                                          $count_leads = get_assigned_leads_today($a->user_id);
                                          $count_leads = !empty( $count_leads ) ? "( {$count_leads} )" : "";
                                          $agent_full_name = $a->first_name . ' ' . $a->last_name;
                                          echo '<option value="'. $a->user_id . '">' . $a->user_name .' ( '. $agent_full_name . ' ) '. $count_leads .' </option>';
                                       }
                                    }else{
                                       echo '<option value="">No Loggedin Agent Found!</option>';
                                    }
                                    ?>
                              </select>
                           </div>
                           <div class="form-group">
                              <label class="control-label"></label>
                              <input type="hidden" name="customer_id" type="text"
                                 value="<?php echo $customer->customer_id; ?>" />
                              <button type="submit" class="btn green uppercase edit_Customer">Reopen Lead</button>
                           </div>
                           <div class="form-group">
                              <div class='rres'></div>
                           </div>
                        </form>
                        <div class='red'>Note: if you reopen this lead all related itineraries and followup will be
                           deleted.
                        </div>
                     </div>
                  </div>
                  <div class="clearfix"></div>
                  <?php } ?>
                  <!--edit additional information customer if exists -->
                  <div class="well well-sm margin-top-20">
                     <h3 class="font_size_18" style="margin: 0;">Query Decline By Customer</h3>
                     <!-- Reopen Lead -->
                     <?php /*<a class="btn btn-success" href="#" data-customer_id = "<?php echo $customer->customer_id; ?>"
                     data-temp_key = "<?php echo $customer->temp_key; ?>" id="reopenLead" title="Reopen"><i
                        class="fa fa-refresh" aria-hidden="true"></i> Reopen Lead</a>
                     <div id="rr"></div>
                     */ ?>
                  </div>
                  <p><strong>Reason: </strong> <?php echo $customer->decline_reason; ?> </p>
                  <p><strong>Comment: </strong> <?php echo $customer->decline_comment; ?> </p>
                  <?php }else if( $role != 95 ){ ?>
                  <!-- Process for customer followup  -->
                  <a class="btn btn-danger" href="#" id="add_call_btn" title="Back">Add Call Info</a>
                  <div class="call_log" id="call_log_section">
                     <form id="call_detais_form">
                        <div class="call_type_seciton">
                           <label class="radio-inline">
                           <input data-id="picked_call_panel" required id="picked_call" class="radio_toggle"
                              type="radio" name="callType" value="Picked call">Picked call
                           </label>
                           <label class="radio-inline"><input class="radio_toggle" data-id="call_not_picked_panel"
                              required id="call_not_picked" type="radio" name="callType"
                              value="Call not picked">Call not picked
                           </label>
                           <label class="radio-inline"><input class="radio_toggle" data-id="close_lead_panel"
                              required id="close_lead" type="radio" name="callType" value="8">Decline
                           </label>
                        </div>
                        <div id="panel_detail_section">
                           <div class="call_type_res col-md-4" id="picked_call_panel">
                              <!--picked call panel-->
                              <div class="col-md-">
                                 <div class="form-group">
                                    <label for="comment">Call summary<span style="color:red;">*</span>:</label>
                                    <textarea required class="form-control" rows="3" name="callSummary"
                                       id="callSummary"></textarea>
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
                                    <label><input id="nxtCallCk" type="radio" class="book_query"
                                       name="book_query" required value=""> Next call time</label>
                                 </div>
                                 <div id="next_call_cal">
                                    <label>Next calling time and date<span style="color:red;">*</span>:</label>
                                    <input size="16" required type="text" value="" name="nextCallTime" readonly
                                       class="form-control form_datetime">
                                 </div>
                              </div>
                              <div class="col-md-">
                                 <label for="readyQuotation"><input id="readyQuotation" class="book_query"
                                    name="book_query" required type="radio" value="9"> Ready for
                                 quotation</label>
                              </div>
                              <!--Quotation Type Holidays/Accommodation/Cab-->
                              <div id="quotation_type_section">
                                 <label class="radio-inline" for="holidays"><input id="holidays"
                                    class="quotation_type" name="quotation_type" required type="radio"
                                    value="holidays"> Holidays </label>
                                 <label class="radio-inline" for="accommodation"><input id="accommodation"
                                    class="quotation_type" name="quotation_type" required type="radio"
                                    value="accommodation"> Accommodation </label>
                                 <!--label class="radio-inline" for="cab_b"><input id="cab_b" class="quotation_type" name="quotation_type" required type="radio" value="cab"> Cab Booking </label-->
                              </div>
                           </div>
                           <!--end picked call panel-->
                           <div class="call_type_res" id="call_not_picked_panel">
                              <!--call_not_picked panel-->
                              <div class="col-md-12">
                                 <label class="radio-inline">
                                 <input required type="radio" name="callSummaryNotpicked"
                                    class="call_type_not_answer" value="Switched off">Switched off
                                 </label>
                                 <label class="radio-inline">
                                 <input required type="radio" name="callSummaryNotpicked"
                                    class="call_type_not_answer" value="Not reachable">Not reachable
                                 </label>
                                 <label class="radio-inline">
                                 <input required type="radio" name="callSummaryNotpicked"
                                    class="call_type_not_answer" value="Not answering">Not answering
                                 </label>
                                 <label class="radio-inline">
                                 <input required type="radio" name="callSummaryNotpicked"
                                    class="call_type_not_answer" value="Number does not exists">Number does
                                 not exists
                                 </label>
                                 <div class="clearfix"></div>
                                 <div class="col-md-6">
                                    <div class="row">
                                       <div class="col-md-">
                                          <div class="form-group">
                                             <label for="comment">Comment<span
                                                style="color:red;">*</span>:</label>
                                             <textarea required class="form-control" rows="3" name="comment"
                                                id="comment"></textarea>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="clearfix"></div>
                                 <div class="col-md-6">
                                    <div class="row">
                                       <div class="nxt_call">
                                          <div class="form-group">
                                             <label>Next calling time and date<span
                                                style="color:red;">*</span>:</label>
                                             <input size="16" required type="text" value="" readonly
                                                name="nextCallTimeNotpicked"
                                                class="form-control form_datetime">
                                          </div>
                                          <div class="form-group">
                                             <label>Lead prospect<span style="color:red;">*</span></label>
                                             <select required class="form-control"
                                                name="txtProspectNotpicked">
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
                                    <option value="Not answering call from 1 week">Not answering call from 1
                                       week
                                    </option>
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
                                    <textarea class="form-control" rows="3" name="decline_comment"
                                       id="decline_comment"></textarea>
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
                                 <input type="text" class="form-control" placeholder="Whatsapp Number"
                                    name="whatsapp_number" value="">
                              </div>
                           </div>
                           <div class="col-lg-4 col-md-6">
                              <div class="form-group">
                                 <label for="">Adults *:</label>
                                 <input required type="text" class="form-control" placeholder="No. of Adults"
                                    name="adults" value="">
                              </div>
                           </div>
                           <div class="col-lg-4 col-md-6">
                              <div class="form-group">
                                 <label for="">Child:</label>
                                 <input type="text" class="form-control" placeholder="No. of child" name="child"
                                    value="">
                              </div>
                           </div>
                           <div class="col-lg-4 col-md-6">
                              <div class="form-group">
                                 <label for="">Age of the child:</label>
                                 <input type="text" class="form-control" placeholder="Child age. eg: 13,12"
                                    name="child_age" value="">
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
                                    <input type="text" required class="form-control" name="package_type_other"
                                       id="pack_type_other">
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
                                 <input required type="text" class="form-control" readonly id="travel_date"
                                    name="travel_date" value="">
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
                           <div class="col-lg-4 col-md-6 hide_accommodation">
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
                                    <input type="text" required class="form-control" name="package_by_other"
                                       id="other_pack">
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
                                 <input type="text" class="form-control" placeholder="" name="honeymoon_kit"
                                    value="">
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
                                 <label class="control-label">Select Country*</label>
                                 <select required name="country" class="form-control country">
                                    <option value="">Choose Country</option>
                                    <?php $country = get_country_list();
                                       if($country){
                                       	foreach( $country as $c ){
                                       		//$selected = $c->id == 101 ? "selected='selected'" : ""; 
                                       		echo "<option value={$c->id}>{$c->name}</option>";
                                       	}
                                       }
                                       ?>
                                 </select>
                              </div>
                           </div>
                           <div class="col-lg-4 col-md-6">
                              <div class="form-group">
                                 <label class="control-label">Select State*</label>
                                 <select required name="state" class="form-control state">
                                    <option value="">Choose State</option>
                                    <?php /*$states = get_indian_state_list();
                                       if($states){
                                       	foreach( $states as $state ){
                                       		echo "<option value={$state->id}>{$state->name}</option>";
                                       	}
                                       }*/
                                       ?>
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
                        <input type="hidden" name="customer_id" value="<?php echo $customer->customer_id; ?>">
                        <input type="hidden" name="temp_key" value="<?php echo $customer->temp_key; ?>">
                        <input type="hidden" name="agent_id" value="<?php echo $customer->agent_id; ?>">
                        <div class="margiv-top-10">
                           <button type="submit" id="submit_frm"
                              class="btn green uppercase submit_frm">Submit</button>
                           <button class="btn red uppercase cancle_bnt">Cancel</button>
                        </div>
                        <div class="clearfix"></div>
                        <div id="resp"></div>
                     </form>
                  </div>
                  <?php  }  ?>
                  <?php 
                     //$time = "2018-07-21 3:17 PM";
                     //echo date("Y-m-d H:i:s", strtotime( $time ));
                     //Add 10 Minutes
                     //$newTime = date("Y-m-d H:i:s",strtotime($time." +10 minutes"));
                     //echo $newTime ;
                     //$notif_time = date("Y-m-d H:i:s",strtotime(date("Y-m-d H:i:s")." +10 minutes"));
                     //echo $notif_time;
                     ?>
                  <?php if( !empty( $followUpData ) ){ ?>
                  <!--div class="panel-group accordion call-time" id="accordion3"--->
                  <?php
                     $count = 1;
                     foreach( $followUpData as $callDetails ){ ?>
                  <?php $c_type = $callDetails->callType; 
                     if( $c_type == 9 ){
                     	$callType_status = "Approved";
                     }elseif( $c_type == 8 ){
                     	$callType_status = "Decline";
                     }else{
                     	$callType_status = $c_type;
                     }
                     ?>
                  <p></p>
                  <div class="col-md-6 col-lg-4">
                     <div class="mt-element-list">
                        <div class="mt-list-container list-todo" id="accordion1" role="tablist"
                           aria-multiselectable="true">
                           <div class="list-todo-line"></div>
                           <ul>
                              <li class="mt-list-item">
                                 <div class="list-todo-icon bg-white font-green-meadow">
                                    <i class="fa fa-clock-o"></i>
                                 </div>
                                 <div class="list-todo-item green-meadow">
                                    <a class="list-toggle-container" data-toggle="collapse"
                                       data-parent="#accordion1" onclick=" " href="#task-<?php echo $count;?>"
                                       aria-expanded="false">
                                       <div class="list-toggle done uppercase">
                                          <div class="list-toggle-title bold">Call Time:
                                             <?php echo $callDetails->currentCallTime;?>
                                          </div>
                                       </div>
                                    </a>
                                    <div class="task-list panel-collapse collapse"
                                       id="task-<?php echo $count;?>">
                                       <ul>
                                          <li class="task-list-item done">
                                             <div class="task-icon"><a href="javascript:;"><i
                                                class="fa fa-phone"></i></a></div>
                                             <div class="task-content">
                                                <h4 class="uppercase bold">
                                                   <a
                                                      href="javascript:;"><?php echo $callType_status;?></a>
                                                </h4>
                                                <p><strong>Call summary:</strong>
                                                   <?php echo $callDetails->callSummary;?>
                                                </p>
                                                <p><strong>Next Call Time:</strong>
                                                   <?php echo $callDetails->nextCallDate;?>
                                                </p>
                                                <p><strong><?php echo $callDetails->customer_prospect;?></strong>
                                                </p>
                                                <p><strong>Comment:</strong>
                                                   <?php echo $callDetails->comment;?>
                                                </p>
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
                  <?php $count++; ?>
                  <?php } ?>
                  <!--/div-->
                  <?php } ?>
                  <div class="clearfix"></div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<style>
   #customer_info_panel,
   #quotation_type_section {
   display: none;
   }
   #call_log_section {
   display: none;
   }
   #close_lead_panel,
   #booked_lead_panel,
   #call_not_picked_panel,
   #picked_call_panel,
   .nxt_call {
   display: none
   }
   #next_call_cal {
   display: none;
   }
   .tour_des {
   background: #faebcc;
   padding-top: 20px;
   padding-bottom: 40px;
   }
   #other_pack {
   display: none;
   }
   #pack_type_other {
   display: none;
   }
   #pakcageModal {
   top: 20%;
   }
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
                  <?php $getPackCat = get_package_categories(); ?>
                  <?php $state_list = get_indian_state_list(); ?>
                  <div class="form-group">
                     <label>Select Package Category</label>
                     <select required name="package_cat_id" class="form-control" id="pkg_cat_id">
                        <option value="">Choose Package</option>
                        <?php if( $getPackCat ){ ?>
                        <?php foreach($getPackCat as $pCat){ ?>
                        <option value="<?php echo $pCat->p_cat_id ?>"><?php echo $pCat->package_cat_name; ?>
                        </option>
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
                     <input type="hidden" id="cust_id" value="<?php echo $customer->customer_id; ?>">
                     <div class="text-center">
                        <input type="submit" class='btn btn-green disabledBtn' id="continue_package"
                           value="Continue">
                     </div>
                  </div>
               </div>
               <div id="pack_response"></div>
            </form>
            <h2 class="text-center"><strong>OR</strong></h2>
            <div class="form-group text-center">
               <a href="<?php echo site_url("itineraries/add/{$customer->customer_id}/{$customer->temp_key}");?>"
                  class='btn btn-green disabledBtn' id="readyForQuotation" title='Add Itinerary'><i
                  class='fa fa-plus'></i> Create New</a>
            </div>
         </div>
         <div class="modal-footer"></div>
      </div>
   </div>
</div>
<script type="text/javascript">
   //Show text box if other package_by choose
   $(document).on("change", "select[name='package_by']", function(e) {
       e.preventDefault();
       var _this = $(this);
       var _thisValue = _this.val();
       console.log(_thisValue);
       if (_thisValue == "Other") {
           $("#other_pack").show();
       } else {
           $("#other_pack").hide();
           $("#other_pack").val("");
       }
   });
   //Show text box if other Package Type choose
   $(document).on("change", "select[name='package_type']", function(e) {
       e.preventDefault();
       var _this = $(this);
       var _thisValue = _this.val();
       console.log(_thisValue);
       if (_thisValue == "Other") {
           $("#pack_type_other").show();
       } else {
           $("#pack_type_other").hide();
           $("#pack_type_other").val("");
       }
   
   });
</script>
<script type="text/javascript">
   jQuery(document).ready(function($) {
       /* Reopen Lead */
       $("#btn_reopen").click(function() {
           $("#reopen_lead").toggle();
       });
   
       $("#frmreopen_lead").validate({
           submitHandler: function() {
               var ajaxRst;
               var response = $(".rres");
               var formData = $("#frmreopen_lead").serializeArray();
               if (confirm("Are you sure to reopen lead ?")) {
                   if (ajaxRst) {
                       ajaxRst.abort();
                   }
                   ajaxRst = jQuery.ajax({
                       type: "POST",
                       url: "<?php echo base_url(); ?>" + "customers/ajax_reopenLead_manager",
                       dataType: 'json',
                       data: formData,
                       beforeSend: function() {
                           response.html(
                               '<p><i class="fa fa-spinner fa-spin"></i> Please wait...</p>'
                               );
                       },
                       success: function(res) {
                           if (res.status == true) {
                               response.html(
                                   '<div class="alert alert-success"><strong>Success! </strong>' +
                                   res.msg + '</div>');
                               location.reload();
                           } else {
                               response.html(
                                   '<div class="alert alert-danger"><strong>Error! </strong>' +
                                   res.msg + '</div>');
                               //console.log("error");
                           }
                       },
                       error: function() {
                           response.html(
                               '<div class="alert alert-danger"><strong>Error! </strong>Please Try again later! </div>'
                               );
                       }
                   });
               }
           }
       });
   });
</script>
<script type="text/javascript">
   jQuery(document).ready(function($) {
   
       /*get states from country*/
       $("select.country").change(function() {
           var selectCountry = $(".country option:selected").val();
           var _this = $(this);
           _this.parent().append(
               '<p class="bef_send"><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
           $.ajax({
               type: "POST",
               url: "<?php echo base_url('AjaxRequest/hotelStateData'); ?>",
               data: {
                   country: selectCountry
               }
           }).done(function(data) {
               $(".bef_send").hide();
               $(".state").html(data);
           }).error(function() {
               alert("Error! Please try again later!");
           });
       });
   
       $("#travel_date").datepicker({
           startDate: "-2d",
           format: "mm/dd/yyyy",
       });
       //reset all fields
       function resetForm() {
           $("#call_detais_form").find("input[type=text],input[type=number], textarea,select, .comment").val("");
           $("#call_detais_form").find('input:checkbox').removeAttr('checked');
           $("#call_detais_form").find('.call_type_not_answer').removeAttr('checked');
           $("#call_detais_form").find('#readyQuotation').removeAttr('checked');
           $("#call_detais_form").find('.quotation_type').removeAttr('checked');
           $("#call_detais_form").find('#nxtCallCk').removeAttr('checked');
           $(".nxt_call").hide();
   
       }
   
       //radio button calltype on change function
       $(document).on("change", ".radio_toggle", function(e) {
           e.preventDefault();
           var _this = $(this);
           var section_id = _this.attr("data-id");
           $("#panel_detail_section").show().find("#" + section_id).slideDown();
           $('.call_type_res').not('#' + section_id).hide();
           $("#customer_info_panel").hide();
           //reset form
           resetForm();
       });
   
       $(document).on("click", "#add_call_btn", function(e) {
           e.preventDefault();
           $("#call_log_section").slideDown();
           $(this).fadeOut();
       });
   
       //on cancle btn click
       $(document).on("click", ".cancle_bnt", function(e) {
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
       $(document).on("change", ".book_query", function(e) {
           e.preventDefault();
           var _this = $(this);
           if (_this.val() == 9) {
               $("#next_call_cal").hide();
               $(".form_datetime").val("");
               $("#quotation_type_section").slideDown();
           } else {
               $("#next_call_cal").show();
               $("#quotation_type_section").hide();
               $("#customer_info_panel").hide();
               $("#call_detais_form").find('.quotation_type').removeAttr('checked');
           }
       });
       //show book Query
       $(document).on("change", ".quotation_type", function(e) {
           e.preventDefault();
           var _this = $(this);
           if (_this.val() == "holidays") {
               $(".hide_accommodation").show();
               $("#customer_info_panel").slideDown();
           } else if (_this.val() == "accommodation") {
               $(".hide_accommodation input, .hide_accommodation select").val("");
               $(".hide_accommodation").hide();
               $("#customer_info_panel").slideDown();
           } else {
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
       $(".call_type_not_answer").click(function() {
           var _this_val = $(".call_type_not_answer:checked").val();
   
           if ($(this).is(':checked') && _this_val != "Number does not exists") {
               $(".nxt_call").show();
           } else {
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
               if (newrequest) {
                   newrequest.abort();
                   console.log("already sent");
                   //return false;
               }
   
               newrequest = $.ajax({
                   type: "POST",
                   url: "<?php echo base_url('customers/updateCustomerFollowup'); ?>",
                   dataType: 'json',
                   data: formData,
                   beforeSend: function() {
                       resp.html(
                           '<p><i class="fa fa-spinner fa-spin"></i> Please wait...</p>'
                           );
                   },
                   success: function(res) {
                       if (res.status == true) {
                           console.log(res);
                           if (res.approved == "holidays") {
                               resp.html(
                                   '<div class="alert alert-success"><strong>Success! </strong>' +
                                   res.msg + '</div>');
                               $("#pakcageModal").show();
                               $("#continue_package").removeClass("disabledBtn");
                               $("#readyForQuotation").removeClass("disabledBtn");
                               $("#call_detais_form")[0].reset();
                               $("#call_detais_form").hide();
                               //location.reload(); 
                           } else if (res.approved == "accommodation") {
                               resp.html(
                                   '<div class="alert alert-success"><strong>Success! </strong>' +
                                   res.msg + '</div>');
                               window.location.href =
                                   "<?php echo site_url();?>itineraries/add_accommodation/" +
                                   res.customer_id + "/" + res.temp_key;
                           } else {
                               location.reload();
                           }
                           //$("#call_detais_form")[0].reset();
                       } else {
                           //resp.html('<div class="alert alert-danger"><strong>Error! </strong>'+res.msg+'</div>');
                           console.log("error");
                       }
                   },
                   error: function(e) {
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
   jQuery(document).ready(function($) {
       var ajaxReq;
       var resp = $("#pack_response");
       //ajax request if predefined package choose
       $("#createIti").validate({
           submitHandler: function() {
   
               if (ajaxReq && ajaxReq.readyState != 4) {
                   ajaxReq.abort();
                   console.log("already sent");
               }
               var package_id = $("#pkg_id").val();
               var customer_id = $("#cust_id").val();
               if (package_id == '' || customer_id == '') {
                   resp.html("Please Choose Package First");
                   resp.html(
                       '<div class="alert alert-danger"><strong>Error! </strong>Please Choose Package First</div>'
                       );
                   return false;
               }
               //resp.html( "Package Id: " + package_id + "Customer Id: " + customer_id );
               ajaxReq = $.ajax({
                   type: "POST",
                   url: "<?php echo base_url('packages/createItineraryFromPackageId'); ?>",
                   data: {
                       package_id: package_id,
                       customer_id: customer_id
                   },
                   dataType: "json",
                   beforeSend: function() {
                       resp.html(
                           '<p><i class="fa fa-spinner fa-spin"></i> Please wait...</p>'
                           );
                   },
                   success: function(res) {
                       if (res.status == true) {
                           resp.html(
                               '<div class="alert alert-success"><strong>Success! </strong>' +
                               res.msg + '</div>');
                           window.location.href =
                               "<?php echo site_url('itineraries/edit/');?>" + res.iti_id +
                               "/" + res.temp_key;
                       } else {
                           resp.html(
                               '<div class="alert alert-danger"><strong>Error! </strong>' +
                               res.msg + '</div>');
                           //console.log("error");
                       }
                   },
                   error: function(e) {
                       console.log(e);
                       resp.html(
                           '<div class="alert alert-danger"><strong>Error!</strong> Please Try again later! </div>'
                           );
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
       jQuery(document).on("click", ".close", function() {
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
           _this.parent().append(
               '<p class="bef_send"><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
           $.ajax({
               type: "POST",
               url: "<?php echo base_url('packages/packagesByCatId'); ?>",
               data: {
                   pid: p_id,
                   state_id: state_id
               }
           }).done(function(data) {
               $(".bef_send").hide();
               $("#pkg_id").html(data);
               $("#pkg_id").removeAttr("disabled");
           }).error(function() {
               $(".bef_send").html("Error! Please try again later!");
           });
       });
   });
</script>
<?php }else{
   redirect(404);
   } ?>