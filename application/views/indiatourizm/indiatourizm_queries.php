<div class="page-container">
	<div class="page-content-wrapper">
		<div class="page-content">
			<div class="portlet box blue">
				<div class="portlet-title">
					<div class="caption">
						<i class="fa fa-cogs"></i>View All Queries From Query Generator
					</div>
					<?php if( is_admin() || is_leads_manager() ){ ?>
						<a class="btn btn-success" href="<?php echo site_url("customers/add"); ?>" title="Add Customer">Add customer</a>
					<?php } ?>
				</div>
			</div>
			<?php $message = $this->session->flashdata('success'); 
				if($message){ echo '<span class="help-block help-block-success">'.$message.'</span>'; }
			?>
			<div class="portlet-body">
				<div class="table-responsive second_custom_card">
					<table id="sliders" class="table table-striped display">
						<thead>
							<tr>
								<th> # </th>
								<th> Name </th>
								<th> Email </th>
								<th> Mobile </th>
								<th> Destination </th>
								<th> Package </th>
								<th> Page Link </th>
								<th> Query From </th>
								<th> Lang </th>
								<th> Action </th>
								<th> Created </th>
								<th> Agent </th>
							</tr>
						</thead>
						<tbody>
						<!--data table goes here -->
						</tbody>
					</table>
				</div>
			</div>
		</div>
		
		</div>
	</div>
<!-- END CONTENT BODY -->
<style>
#pakcageModal, #teamleader_modal{top: 10%; z-index: 999999999; }
strong.btn.btn-success.assign_btn {
    left: 20%;
    position: absolute;
}
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
						<div class="form-group col-md-6">
							<label class="control-label">Assign To*</label>
							<br>
							<label><input class="form-control assign_to" type="radio" id="assing_teamleader" required name="assign_to" value="teamleader">Teamleader</label>&nbsp;&nbsp;&nbsp;
							<label><input class="form-control assign_to" type="radio" id="assing_agent" required name="assign_to" value="agent">Agent</label> 
						</div>
						<div class="form-group col-md-6 agent_select" style="display: none;">
							<label class="control-label">Assign To Agent*</label>
							<select required name="agent_id" class="form-control">
								<option  value="">Select Sales Team Agents</option>
								<?php $agents = get_all_sales_team_loggedin_today();
								if($agents){
									foreach( $agents as $a ){
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
						<div class="form-group col-md-6 team_leaders_select" style="display: none;">
							<label class="control-label">Assign To Team Leader*</label>
							<select required name="leader_id" class="form-control">
								<option  value="">Select Teamleader</option>
								<?php if( get_all_teamleaders_loggedin_today() ){ 
									$team_leaders = get_all_teamleaders_loggedin_today();
									foreach( $team_leaders as $leader ){
										$t_leader =  $leader->username;
										$count_leads = get_assigned_leads_today($leader->user_id );
										$count_leads = !empty( $count_leads ) ? "( {$count_leads} )" : "";
										echo "<option value={$leader->user_id }>{$t_leader}{$count_leads}</option>";
									}
								}else{
									echo "<option value=''>No Teamleader Found</option>";
								} ?>
							</select>
						</div>
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

<!--assign to teamleader-->
<div id="teamleader_modal" class="modal" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">Close</button>
				<h4 class="modal-title">Assign Leads</h4>
			</div>
			<div class="modal-body"> 
				<form id="teamleader_frm">
					<div class="clearfix">
					<div class="row ">
						<div class="form-group col-md-6 team_leaders_select">
							<label class="control-label">Assign To Team Leader*</label>
							<select required name="leader_id" class="form-control">
								<option  value="">Select Teamleader</option>
								<?php if($team_leaders = get_all_teamleaders_loggedin_today() ){ ?>
									<?php foreach( $team_leaders as $leader ){ ?>
										<?php 
											$t_leader =  $leader->username;
											$count_leads = get_assigned_leads_today($leader->user_id );
											$count_leads = !empty( $count_leads ) ? "( {$count_leads} )" : "";
											echo "<option value={$leader->user_id }>{$t_leader}{$count_leads}</option>";
										?>
									<?php } ?>
								<?php }else{
									echo "<option value=''>No Teamleader Found</option>";
								} ?>
							</select>
						</div>
					</div>
					<div class="form-actions">
						<input type="hidden" id="ids" value="" name="ids">
						<input type="submit" class='btn btn-green' id="assign_teambtn" value="Assign Lead" >
					</div>
					</div>	
					<div id="pack_response_aj"></div>	
				</form>	
			</div>
			<div class="modal-footer"></div>
		</div>
	</div>
</div>

</div>
<script type="text/javascript">
jQuery(document).ready(function($){
	//show div on change assign_to
	$(".assign_to").change(function(){
		if ($("#assing_agent").is(":checked")) {
            $('.agent_select').show();
			$('.team_leaders_select').hide();
        }
        else if ($("#assing_teamleader").is(":checked")) {
			$('.team_leaders_select').show();
			$('.agent_select').hide();
        }
	});
	
	
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
		var lang		= $(this).closest("tr").find("td:eq(8)").text();
		
		//append data
		$("#lang").html(lang);
		$("#cname").val(name);
		$("#cemail").val(email);
		$("#cmobile").val(mobile);
		$("#id").val(id);
		$("#destination").val(destination);
		
		
	});
	
	jQuery(document).on("click", ".close",function(){
		jQuery("#pakcageModal, #teamleader_modal").fadeOut();
		$("#assign_lead_form, #teamleader_frm")[0].reset();
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
					$("#continue_package").removeAttr("disabled");
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
	
	//Assign lead to teamleader multiple
	$("#teamleader_frm").validate({
		submitHandler: function(form) {
			var resp = $("#pack_response_aj");
			var ajaxReq;
			var formData = $("#teamleader_frm").serializeArray();
			//console.log(formData);
			if (ajaxReq) {
				ajaxReq.abort();
			}
			
			ajaxReq = $.ajax({
				type: "POST",
				url: "<?php echo base_url('indiatourizm/assign_lead_to_teamleader'); ?>" ,
				dataType: 'json',
				data: formData,
				beforeSend: function(){
					$("#assign_teambtn").attr("disabled", "disabled");
					resp.html('<p class="alert alert-info"><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
				},
				success: function(res) {
					$("#assign_teambtn").removeAttr("disabled");
					if (res.status == true){
						resp.html('<div class="alert alert-success"><strong>Success! </strong>'+res.msg+'</div>');
						$("#teamleader_frm")[0].reset();
						alert( res.msg );
						jQuery("#teamleader_modal").fadeOut();
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
	
	//delete
	$(document).on("click", ".ajax_delete_review", function(){
		var id = $(this).attr("data-id");
		if (confirm("Are you sure?")) {
			$.ajax({
				url: "<?php echo base_url(); ?>" + "indiatourizm/delete_query",
				type:"POST",
				data:{id: id},
				dataType: "json",
				cache: false,
				success: function(r){
					console.log("error");
					if(r.status = true){
						location.reload();
						console.log("ok" + r.msg);
					}else{
						alert("error");
					}
				}
			});	
		}   
	});
});
</script>
<script type="text/javascript">
var table;
$(document).ready(function() {
	//multi_assign
    $(document).on("click", ".assign_btn", function(){
		var q_ids = [];
		$.each($("input[class='multi_assign']:checked"), function(){            
			q_ids.push($(this).val());
		});
		//
		//console.log(q_ids);
		if (typeof q_ids !== 'undefined' && q_ids.length > 0) {
			$("#teamleader_modal").show();
			$("#ids").val( q_ids.join(",") );
			//alert("My favourite sports are: " + q_ids.join(", "));
		}else{
			swal("Alert!", "Please select Lead first!", "warning");
		}	
	});
	
	//show hide button on checkbox click
	$(document).on("click", ".multi_assign", function () {
		var checked_id = [];
		$.each($("input[class='multi_assign']:checked"), function(){            
			checked_id.push($(this).val());
		});
		
		
		if (typeof checked_id !== 'undefined' && checked_id.length > 0) {
			$(".assign_btn").removeClass("hide");
		}else{
			$(".assign_btn").addClass("hide");
		}	
    });
	
    //datatables
    table = $('#sliders').DataTable({ 
		"aLengthMenu": [[10, 50, 100, -1], [10, 50, 100, 'All']],
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
		language: {
			search: "<strong class='btn btn-success assign_btn hide'>Assign To Teamleader</strong> <strong>Search By name:</strong>",
			searchPlaceholder: "Search..."
		},
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('indiatourizm/ajax_queries_list')?>",
            "type": "POST"
        },
        //Set column definition initialisation properties.
        "columnDefs": [
			{ 
				"targets": [ 0 ], //first column / numbering column
				"orderable": false, //set not orderable
			},
        ],
    });
});
</script>