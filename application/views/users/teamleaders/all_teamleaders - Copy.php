<style>
span.u_span {
    background: #3d3d3d;
    color: white;
    padding: 4px 6px;
    margin-right: 3px;
	cursor: pointer;
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
    display: inline-block;
    margin-top: 5px;
}
.un-sales-agents {display: flex;    flex-wrap: wrap;}
</style>
<div class="page-container">
	<div class="page-content-wrapper">
		<div class="page-content">
		 <!-- BEGIN SAMPLE TABLE PORTLET-->
			<div class="portlet box blue">
				<div class="portlet-title">
					<div class="caption">
						<i class="fa fa-cogs"></i>All Team Leaders
					</div>
					<a class="btn btn-success" href="<?php echo site_url("agents/add_teamleader"); ?>" title="add teamleader">Add Teamleader</a>
				</div>
			</div>
			<?php $message = $this->session->flashdata('success'); 
				if($message){ echo '<span class="help-block help-block-success">'.$message.'</span>'; }
			?>
			<div class="portlet-body">
				<?php
				if( $all_unassigned_sales_agent ) {
					echo "<div class='pending_agents'>";
						echo "<h4 class='uppercase'>Unassigned Agents:</h4><div class='un-sales-agents'>";
						foreach( $all_unassigned_sales_agent as $unassigned_agent ){
							echo "<span class='ua_agent'>{$unassigned_agent->user_name}</span>";
						}
					echo "</div></div><hr>";	
				}
				?>
				<div class="table-responsive">
				
					<table class="table table-bordered display" id="table" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th> # </th>
								<th> Team Name </th>
								<th> Leader Name </th>
								<th> Assigned agents </th>
								<th> Created By </th>
								<th> Action </th>
							</tr>
						</thead>
						<tbody>
						<?php if( $all_team_members ){
							$counter = 1;
							foreach( $all_team_members as $teamleader ){
								//Get online offline status
								$check_online_status = get_user_online_status( $teamleader->leader_id );
								$online_offline_status = !empty( $check_online_status ) ? 
								'<i title="Online" class="fa fa-circle" style="font-size:16px;color:green"></i>' 
								: '<i title="Offline" class="fa fa-circle" style="font-size:16px;color:red"></i>';
								
								$editUrl = base_url("agents/edit_teamleader/{$teamleader->id}");
								echo "<tr><td>{$counter}. {$online_offline_status}</td>";
									echo "<td>" . $teamleader->team_name . "</td>";
									echo "<td>" . get_user_name( $teamleader->leader_id ) . "</td>";
									echo "<td><div class='inner_agents'>";
									if( !empty( $teamleader->assigned_members ) ){
										$in = 1;
										$passed = false;
										$memebers = explode(",", $teamleader->assigned_members);
										foreach( $memebers as $mem ){
											$mem_id = trim( $mem );
											//echo "<span class='u_span'>" . ($passed ? ',' : '' ) . ucfirst(get_user_name($mem)) . "</span>";
											echo "<span class='u_span' data-id='{$mem_id}' >" . ucfirst(get_user_name($mem)) . "</span>";
											$passed = true;
											if( $in%6 == 0 ){
												echo "<br><br>";	
											}
											$in++;
										}
									}
									echo "</div></td>";
									echo "<td>" . get_user_name( $teamleader->leader_created_by ) . "</td>";
									echo "<td>
										<a href='{$editUrl}' class='btn btn-success' title='view/edit teamleaders'><i class='fa fa-pencil'></i><a>
										<a href='javascript:void(0)' data-id={$teamleader->id} class='btn btn-danger ajax_delete_user' title='delete teamleaders'><i class='fa fa-trash-o'></i><a>
									</td>";
								echo "</tr>";
								$counter++;
							}
						}else{
							echo "<tr><td colspan='6'> No Team Leader Found.</td></tr>";
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
<!-- Modal -->
<script type="text/javascript">
 jQuery(document).ready(function($){
	//delete 
	$(document).on("click", ".ajax_delete_user",function(){
		var user_id = $(this).attr("data-id");
		//alert(user_id);
		if (confirm("Are you sure to delete teamleaders? You can create new after delete.")) {
			$.ajax({
				url: "<?php echo base_url(); ?>" + "agents/delete_teamleader?id=" + user_id,
				type:"GET",
				data:user_id,
				dataType: "json",
				cache: false,
				success: function(r){
					if(r.status = true){
						location.reload();
						console.log("ok" + r.msg);
					}else{
						alert("Error! Please try again.");
					}
				}
			});	
		}   
	});
}); 
</script>