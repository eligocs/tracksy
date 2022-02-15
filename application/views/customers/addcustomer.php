<div class="page-container customer_content">
   <div class="page-content-wrapper">
      <div class="page-content">
         <?php echo validation_errors('<span class="help-block help-block-error1">', '</span>'); ?>
         <?php $message = $this->session->flashdata('error'); 
            if($message){ echo '<span class="help-block help-block-error1 red">'.$message.'</span>';}
            ?>
         <div class="portlet box blue">
            <div class="portlet-title">
               <div class="caption"><i class="fa fa-users"></i>Add Customer</div>
               <a class="btn btn-success" href="<?php echo site_url("customers"); ?>" title="Back">Back</a>
            </div>
         </div>
         <div class="second_custom_card">
            <?php //echo form_open('customers/savecustomer', array("id" => "customer_form")); ?>
            <form id="customer_form" action="<?php echo base_url(); ?>customers/savecustomer" method="post">
               <input type="hidden" name="inp[temp_key]" value="<?php echo getTokenKey(15); ?>">
               <div class="col-md-4">
                  <div class="form-group">
                     <label class="control-label">Customer Name*</label>
                     <input required type="text" placeholder="eg. Mr. Prem Thakur" name="inp[customer_name]" class="form-control textfield" value="<?php if(isset($customer_name)){ echo $customer_name; }else{ echo set_value('inp[customer_name]'); } ?>"/> 
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="form-group">
                     <label class="control-label">Email*</label>
                     <input required type="email" placeholder="eg: your-name@domain.com" name="inp[customer_email]" class="form-control" value="<?php if(isset($customer_email)){ echo $customer_email; }else{ echo set_value('inp[customer_email]'); } ?>"/> 
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="form-group">
                     <label class="control-label">Contact Number*</label>
                     <input required type="number" placeholder="eg: 9816098160" name="inp[customer_contact]" class="form-control numberfield" value="<?php if(isset($customer_contact)){ echo $customer_contact; }else{ echo set_value('inp[customer_contact]'); } ?>"/> 
                  </div>
               </div>
               <div class="clearfix"></div>
               <div class="col-md-4">
                  <?php $get_cus_type = get_customer_type(); ?>
                  <div class="form-group">
                     <label class="control-label">Customer Type*</label>
                     <select required name="inp[customer_type]" class="form-control" id="cus_type">
                        <option value="">Select Customer Type</option>
                        <option value="0">Direct Customer</option>
                        <?php if( !empty( $get_cus_type ) ){
                           foreach( $get_cus_type as $type ){
                           	echo "<option value='{$type->id}'>{$type->name}";
                           }
                           } ?>
                        <!--option value="1">Travel Partner</option>
                           <option value="2">Reference</option-->
                     </select>
                  </div>
               </div>
               <div id="reference_section" style="display: none;">
                  <div class="col-md-4">
                     <div class="form-group">
                        <label class="control-label">Reference Name*</label>
                        <input required type="text" placeholder="eg. Reference Name" name="inp[reference_name]" class="form-control textfield" value=""/> 
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group">
                        <label class="control-label">Reference Contact Number*</label>
                        <input required type="number" placeholder="Reference Phone Number" name="inp[reference_contact_number]" class="form-control numberfield" value=""/> 
                     </div>
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="form-group">
                     <label class="control-label">Assign To *</label>
                     <select required name="inp[agent_id]" class="form-control">
                        <option  value="">Select Sales Team Agents</option>
                        <?php if( is_admin_or_manager() ){
                           $agents = get_all_sales_team_loggedin_today();
                           // var_dump($agent);die;
                           if($agents){
                           	$teamL = "";
                           	$teamM = "";
                           	foreach( $agents as $a ){
                           		//remove teamleader
                           		//if( is_teamleader( $a->user_id ) ) continue; 		
                           		$agent_full_name = $a->first_name . ' ' . $a->last_name;
                           		//echo '<option value="'. $a->user_id . '">' . $a->user_name .' ( '. $agent_full_name . ' ) '. $count_leads .' </option>';
                           		if( is_teamleader( $a->user_id ) ){
                           			$count_leads = get_assigned_leads_to_team_today( $a->user_id );
                           			$count_leads = !empty( $count_leads ) ? "( {$count_leads} )" : "";
                           			
                           			$team_na = "<strong style='color: red;' > ( TEAM LEADER ) </strong>";
                           			$teamL .= "<option value='{$a->user_id}'>{$a->user_name} ( {$agent_full_name} ) {$count_leads} {$team_na}  </option>";	
                           		}else{
                           			$count_leads = get_assigned_leads_today( $a->user_id );
                           			$count_leads = !empty( $count_leads ) ? "( {$count_leads} )" : "";
                           			$teamM .= "<option value='{$a->user_id}'>{$a->user_name} ( {$agent_full_name} ) {$count_leads} </option>";	
                           		}
                           	}
                           	echo $teamL . $teamM;
                           }else{
                           	echo '<option value="">No Loggedin Agent Found!</option>';
                           }
                           }else if( is_teamleader() ) {
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
               <div class="clearfix"></div>
               <div class="col-md-12 text-left">
                  <!--input type="hidden" name="inp[agent_id]" value="<?php //if($agent_id){echo $agent_id; } ?>"-->
                  <div class="margiv-top-10">
                     <button type="submit" class="btn green uppercase add_Customer">Add Customer</button>
                  </div>
               </div>
               <div class="clearfix"></div>
            </form>
         </div>
         <div id="res"></div>
      </div>
      <!-- END CONTENT BODY -->
   </div>
   <!-- Modal -->
</div>
<script type="text/javascript">
   jQuery(document).ready(function($){
   	$("#customer_form").validate({
   		submitHandler: function(form){
   			console.log("submit");
   			checkBeforeSubmit();
   			form.submit();	
   		}
   	});
   	
   	//Prevent click
   	var wasSubmitted = false;    
   	function checkBeforeSubmit(){
   	  if(!wasSubmitted) {
   		wasSubmitted = true;
   		return wasSubmitted;
   	  }
   	  return false;
   	}  
   	
   	/* jQuery.validator.addMethod("lettersonly", function(value, element) {
   	  return this.optional(element) || /^[a-z]+$/i.test(value);
   	}, "Letters only please"); 
   	//validate textfield
   	jQuery.validator.addClassRules('textfield', {
           required: true ,
   		lettersonly: true
       }); */
   	
   	//Show reference_section
   	var ref_section = $("#reference_section");
   	$("#cus_type").change(function(){
   		var _this_val = $(this).val();
   		if( _this_val == 2 ){
   			ref_section.show();
   		}else{
   			ref_section.hide();
   			$("#reference_section input").val('');
   		}
   	});
   	
   }); 
</script>
<script type="text/javascript">
   /*
   	var wasSubmitted = false;    
       function checkBeforeSubmit(){
         if(!wasSubmitted) {
           wasSubmitted = true;
           return wasSubmitted;
         }
         return false;
       }    */
</script>