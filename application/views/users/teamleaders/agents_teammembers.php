<style>
span.u_span {
    background: #3d3d3d;
    color: white;
    padding: 2px;
    margin-right: 3px;
}

.pending_agents {
    margin-bottom: 30px;
}

span.ua_agent {
    padding: 5px;
    background: red;
    margin-right: 3px;
    color: white;
    text-transform: capitalize;
}
</style>
<div class="page-container">
	<div class="page-content-wrapper">
		<div class="page-content">
		 <!-- BEGIN SAMPLE TABLE PORTLET-->
			<div class="portlet box blue">
				<div class="portlet-title">
					<div class="caption">
						<i class="fa fa-cogs"></i>All Team Members
					</div>
				</div>
			</div>
			<?php $message = $this->session->flashdata('success'); 
				if($message){ echo '<span class="help-block help-block-success">'.$message.'</span>'; }
			?>
			<div class="portlet-body">
				<div class="table-responsive">
					<table class="table table-bordered display" id="table" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th> # </th>
								<th> Member User Name </th>
								<th> Target (Pkg.) </th>
								<th> Booked (Pkg.) </th>
								<th> View Dashboard </th>
								<th> Status </th>
							</tr>
						</thead>
						<tbody>
						<?php if( $teammembers ){
							$all_memebers = explode(",", $teammembers[0]->assigned_members);
							$counter = 1;
							foreach( $all_memebers as $mem ){
								
								$m_target = get_agent_monthly_target($mem);
								$booked_pkg = get_agents_booked_packages( $mem );
								
								//Get online offline status
								$check_online_status = get_user_online_status( $mem );
								$user_dash_url = site_url("dashboard/user_dashboard?user_id=") . $mem;
								
								$online_offline_status = !empty( $check_online_status ) ? 
								'<i title="Online" class="fa fa-circle" style="font-size:16px;color:green"></i>' 
								: '<i title="Offline" class="fa fa-circle" style="font-size:16px;color:red"></i>';
					
								echo "<tr><td>{$counter}</td>";
								echo "<td>" . get_user_name( $mem ) . "</td>";
								echo "<td>" . $m_target . "</td>";
								echo "<td>" . $booked_pkg . "</td>";
								echo "<td><a class='btn btn-success' href='{$user_dash_url}'><i class='fa fa-home'></i> View Dashboard</a> </td>";
								echo "<td>" . $online_offline_status . "</td>";
								echo "</tr>";
								$counter++;
							}
						}else{
							echo "<tr><td colspan='2'> No Team Members Found.</td></tr>";
						} ?>
						<!--Data table -->
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
    table = $('#table').DataTable();
});
</script>
