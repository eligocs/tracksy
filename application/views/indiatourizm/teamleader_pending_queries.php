<div class="page-container">
   <div class="page-content-wrapper">
      <div class="page-content">
         <div class="portlet box blue">
            <div class="portlet-title">
               <div class="caption">
                  <i class="fa fa-cogs"></i>View All Pending Leads To Assign
               </div>
            </div>
         </div>
         <?php $message = $this->session->flashdata('success'); 
            if($message){ echo '<span class="help-block help-block-success">'.$message.'</span>'; }
            ?>
         <div class="portlet-body second_custom_card">
            <div class="table-responsive">
               <table id="sliders" class="table table-striped">
                  <thead>
                     <tr>
                        <th> # </th>
                        <th> Name </th>
                        <th> Email </th>
                        <th> Mobile </th>
                        <th> Destination </th>
                        <th> Lang </th>
                        <th> Leader </th>
                        <th> Action </th>
                     </tr>
                  </thead>
                  <tbody>
                     <!--data table goes here -->
                     <?php if( $pending_leads ){
                        //dump( $pending_leads ); die;
                        $counter = 1;
                        foreach( $pending_leads as $lead ){
                        	$user_name = get_user_name( $lead->agent_id );
                        	$lang = !empty($lead->lang) ? ucfirst( $lead->lang ) : "";
                        	$btn_as = "<a href='#' title='View lead' data-data_id='{$lead->id}' class='btn btn-success assign_lead_agent'><i class='fa fa-refresh'></i> Assign</a>";
                        	echo "<tr>
                        		<td>{$counter}</td>
                        		<td>{$lead->name}</td>
                        		<td>{$lead->email}</td>
                        		<td>{$lead->mobile}</td>
                        		<td>{$lead->destination}</td>
                        		<td>{$lang}</td>
                        		<td>{$user_name}</td>
                        		<td>{$btn_as}</td>
                        	</tr>";
                        	$counter++;
                        }
                        }else{
                        echo "<tr ><td colspan=8>No Pending Leads Found!.</tr>";
                        } ?>
                  </tbody>
               </table>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- END CONTENT BODY -->
<style>
   #pakcageModal{top: 10%; z-index: 999999999; }
</style>
<!-- Modal -->
<div id="pakcageModal" class="modal" role="dialog">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">Close</button>
            <h4 class="modal-title">Assign Leads</h4>
            Client Language : <strong id="lang"></strong>
         </div>
         <div class="modal-body">
            <form id="assign_lead_form">
               <div class="clearfix">
                  <div class="row ">
                     <?php if( is_admin_or_manager() ){ ?>
                     <div class="form-group col-md-6 agent_select" >
                        <label class="control-label">Assign To Agent*</label>
                        <select required name="agent_id" class="form-control">
                           <option  value="">Select Sales Team Agents</option>
                           <?php 
                              if($logedin_agents){
                              	foreach( $logedin_agents as $a ){
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
                     <?php }else{ ?>
                     <div class="form-group col-md-6 agent_select" >
                        <label class="control-label">Assign To Agent*</label>
                        <select required name="agent_id" class="form-control">
                           <option  value="">Select Team Members</option>
                           <?php 
                              $logedin_agents = is_teamleader();
                              if( $logedin_agents ){
                              	foreach( $logedin_agents as $agent ){
                              		if( !is_agent_login_today( $agent ) ) continue;
                              		$count_leads = get_assigned_leads_today($agent);
                              		$count_leads = !empty( $count_leads ) ? "( {$count_leads} )" : "";
                              		echo '<option value="'. $agent . '">' . get_user_name($agent) . $count_leads .' </option>';
                              	}
                              }else{
                              	echo '<option value="">No Loggedin Agent Found!</option>';
                              }
                              ?>
                        </select>
                     </div>
                     <?php } ?>
                  </div>
                  <div class="row">
                     <?php $get_cus_type = get_customer_type(); ?>
                     <div class="form-group col-md-6">
                        <label class="control-label">Customer Type*</label>
                        <select required name="customer_type" class="form-control" id="cus_type">
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
                     <div class="form-group col-md-6">
                        <label class="control-label">Destination*</label>
                        <input type="text" required name="destination" id="destination" class="form-control">
                     </div>
                  </div>
                  <div class="row ">
                     <div class="form-group col-md-6">
                        <label class="control-label">Name*</label>
                        <input type="text" required name="name" id="cname" class="form-control">
                     </div>
                     <div class="form-group col-md-6">
                        <label class="control-label">Email*</label>
                        <input type="text" required name="email" id="cemail" class="form-control">
                     </div>
                  </div>
                  <div class="row ">
                     <div class="form-group col-md-6">
                        <label class="control-label">Mobile*</label>
                        <input type="text" required name="mobile" id="cmobile" class="form-control">
                     </div>
                  </div>
                  <div class="form-actions">
                     <input type="hidden" id="id" value="" name="id">
                     <input type="submit" class='btn btn-green' id="continue_package" value="Assign Lead" >
                  </div>
               </div>
               <div id="pack_response"></div>
            </form>
         </div>
         <div class="modal-footer"></div>
      </div>
   </div>
</div>
</div>
<script type="text/javascript">
   jQuery(document).ready(function($){
   	//Open Modal On ready to quotation click
   	$(document).on("click",".assign_lead_agent", function(e){
   		e.preventDefault();
   		$("#pakcageModal").show();
   		
   		var id = $(this).attr("data-data_id");
   		//get data
   		var name		= $(this).closest("tr").find("td:eq(1)").text();
   		var email		= $(this).closest("tr").find("td:eq(2)").text();
   		var mobile		= $(this).closest("tr").find("td:eq(3)").text();
   		var destination	= $(this).closest("tr").find("td:eq(4)").text();
   		var lang		= $(this).closest("tr").find("td:eq(5)").text();
   		
   		//append data
   		$("#lang").html(lang);
   		$("#cname").val(name);
   		$("#cemail").val(email);
   		$("#cmobile").val(mobile);
   		$("#id").val(id);
   		$("#destination").val(destination);
   		
   		
   	});
   	
   	jQuery(document).on("click", ".close",function(){
   		jQuery("#pakcageModal").fadeOut();
   		$("#assign_lead_form")[0].reset();
   	});
   	
   	//Assign lead
   	$("#assign_lead_form").validate({
   		submitHandler: function(form) {
   			var resp = $("#pack_response");
   			var ajaxReq;
   			var formData = $("#assign_lead_form").serializeArray();
   			//console.log(formData);
   			if (ajaxReq) {
   				ajaxReq.abort();
   			}
   			
   			ajaxReq = $.ajax({
   				type: "POST",
   				url: "<?php echo base_url('indiatourizm/assign_lead_to_agent'); ?>" ,
   				dataType: 'json',
   				data: formData,
   				beforeSend: function(){
   					$("#continue_package").attr("disabled", "disabled");
   					resp.html('<p class="alert alert-info"><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
   				},
   				success: function(res) {
   					//$("#continue_package").removeAttr("disabled");
   					if (res.status == true){
   						resp.html('<div class="alert alert-success"><strong>Success! </strong>'+res.msg+'</div>');
   						$("#assign_lead_form")[0].reset();
   						alert( res.msg );
   						jQuery("#pakcageModal").fadeOut();
   						location.reload();
   					}else{
   						resp.html('<div class="alert alert-danger"><strong>Error! </strong>'+res.msg+'</div>');
   						console.log("error");
   					}
   				},
   				error: function(e){
   					console.log(e);
   					resp.html('<div class="alert alert-danger"><strong>Error!</strong>Please Try again later! </div>');
   				}
   			});
   			return false;
   		}
   	});
   	
   });
</script>
<script type="text/javascript">
   var table;
   $(document).ready(function() {
       //datatables
       table = $('#sliders').DataTable();
   });
</script>