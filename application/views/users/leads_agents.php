<div class="page-container">
	<div class="page-content-wrapper">
		<div class="page-content">
		 <!-- BEGIN SAMPLE TABLE PORTLET-->
			<div class="portlet box blue">
				<div class="portlet-title">
					<div class="caption">
						<i class="fa fa-cogs"></i>All Users
					</div>
					<a class="btn btn-success" href="<?php echo site_url("agents/addagent"); ?>" title="add agent">Add User</a>
				</div>
			</div>
			<div class="portlet-body">
				<div class="table-responsive">
					<table class="table table-bordered display" id="table" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th> # </th>
								<th> Name </th>
								<th> User Name </th>
								<th> User Role </th>
								<th> Email </th>
								<th> Mobile </th>
								<th> Status </th>
								<th> Last Login </th>
								<th> Action </th>
							</tr>
						</thead>
						<tbody>
						<!--Data table -->
						<?php if( $get_leads_agents ){
							$counter = 1;
							foreach( $get_leads_agents as $agent ){
								$agent_type = get_role_name($agent->user_type);
								echo "<tr>";
								//Get online offline status
								$check_online_status = get_user_online_status( $agent->user_id );
								$online_offline_status = !empty( $check_online_status ) ? 
								'<i title="Online" class="fa fa-circle" style="font-size:16px;color:green"></i>' 
								: '<i title="Offline" class="fa fa-circle" style="font-size:16px;color:red"></i>';
								
								$view_btn = "<a title='view' href=" . site_url("agents/view/{$agent->user_id}") . " class='btn btn-success' ><i class='fa fa-eye'></i></a>";
								$view_btn .= "<a title='Edit' href=" . site_url("agents/editagent/{$agent->user_id}") . " class='btn btn-success' ><i class='fa fa-pencil'></i></a>";
								
								echo "<td>" . $counter . "  " . $online_offline_status . "</td>"; 
								echo "<td>" . $agent->first_name . " " . $agent->last_name . "</td>"; 
								echo "<td>" .$agent->user_name . "</td>"; 
								echo "<td>" .$agent_type . "</td>"; 
								echo "<td>" . $agent->email . "</td>"; 
								echo "<td>" . $agent->mobile . "</td>"; 
								echo "<td>" . $agent->user_status . "</td>"; 
								echo "<td>" . $agent->last_login . "</td>"; 
								echo "<td>" . $view_btn . "</td>";
								
								echo "</tr>";
								
								$counter++;
							}
						} ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		
		</div>
	</div>
	<!-- END CONTENT BODY -->
</div>

<script type="text/javascript">
var table;
$(document).ready(function() {
    //datatables
    table = $('#table').DataTable({ 
		"aLengthMenu": [[10,25, 50, 100, -1], [10, 25, 50, 100, 'All']],
    });
});
</script>