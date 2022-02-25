<link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel = "stylesheet">
<script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
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

.remove_member{color: red;}

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

ol.unassign_list li {
    margin: 5px;
    padding: 2px 8px;
    border-radius: 2px !important;
}
.inner_agents li:hover .remove_member{cursor:pointer;}
.inner_agents li:hover,
ol.unassign_list li:hover{    cursor: move;}

.inner_agents li {
    padding: 5px;
    border: 1px solid #ccc;
    margin-bottom: 5px;
    border-radius: 5px !important;
    max-width: 175px;
    background-image: linear-gradient(#fff, #f0f0f0);
}

.inner_agents {
    list-style-position: inside;
}

.remove_member {
    color: red;
    float: right;
}
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
			<div class="portlet-body second_custom_card">
				<?php
				if( $all_unassigned_sales_agent ) {
					echo "<div class='pending_agents'>";
						echo "<h4 class='uppercase'>Unassigned Agents:</h4><div class='un-sales-agents1'><ol class='unassign_list list list-inline'>";
						foreach( $all_unassigned_sales_agent as $unassigned_agent ){
							//echo "<span class='ua_agent'>{$unassigned_agent->user_name}</span>";
							$mem_id = trim( $unassigned_agent->user_id );
							echo "<li class='drag_unassign btn grey-mint' data-id='{$mem_id}' data-tid='0' title='Drag This to team' >" . ucfirst(get_user_name($unassigned_agent->user_id)) . "</li>";
						}
					echo "</ol></div></div>";	
				}
				
				?>
				<div class="table-responsive">
					<table class="table table-striped display" id="table" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th> # </th>
								<th> Team Name </th>
								<th> Leader Name </th>
								<th title="Current Month Target"> Booked/Target (Pkg.) </th>
								<th> Assigned agents </th>
								<th> Updated By </th>
								<th> Action </th>
							</tr>
						</thead>
						<tbody>
						<?php if( $all_team_members ){
							$counter = 1;
							foreach( $all_team_members as $teamleader ){
								$agent_in = is_teamleader( $teamleader->leader_id );
								$mtarget = (int)get_total_target_by_month( $agent_in ); 
								$mbooked = (int)get_agents_booked_packages( NULL, NULL, $agent_in );
								
								//Get online offline status
								$check_online_status = get_user_online_status( $teamleader->leader_id );
								$online_offline_status = !empty( $check_online_status ) ? 
								'<i title="Online" class="fa fa-circle" style="font-size:16px;color:green"></i>' 
								: '<i title="Offline" class="fa fa-circle" style="font-size:16px;color:red"></i>';
								
								$editUrl = base_url("agents/edit_teamleader/{$teamleader->id}");
								echo "<tr data-row_id='{$teamleader->id}'><td>{$counter}. {$online_offline_status}</td>";
									echo "<td>" . $teamleader->team_name . "</td>";
									echo "<td>" . get_user_name( $teamleader->leader_id ) . "</td>";
									echo "<td title='Current Month Booked/Target'>{$mbooked}/{$mtarget}</td>";
									echo "<td><ol class='inner_agents' id='{$counter}'>";
										if( !empty( $teamleader->assigned_members ) ){
											$in = 1;
											$passed = false;
											$memebers = explode(",", $teamleader->assigned_members);
											foreach( $memebers as $mem ){
												$mem_id = trim( $mem );
												$dragble_class = count($memebers) > 1 ? "u_li" : "dr_list";
												//delete button
												$del_btn = count($memebers) > 1 ?  "<strong class='remove_member' ><i class='fa fa-trash-o'></i></strong>" : "";
												
												echo "<li class='{$dragble_class}' data-tid='{$teamleader->id}' data-id='{$mem_id}' >" . ucfirst(get_user_name($mem)) . "{$del_btn}</li>";
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
							echo "<tr><td colspan='7'> No Team Leader Found.</td></tr>";
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
	 
	//dragable add agent
	$(".unassign_list li").draggable({
		appendTo: "body",
		helper: "clone"
	});
	
	//dragable move agent
	$(".inner_agents").droppable({
		activeClass: "ui-state-default",
		hoverClass: "ui-state-hover",
		accept:".u_li, .drag_unassign",
		drop: function(event, ui) {
			var self = $(this);
			//console.log( ui );
			//self.find(".placeholder").remove();
			var m_agent_id = ui.draggable.attr("data-id");
			if (self.find("[data-id=" + m_agent_id + "]").length) return;
			if (confirm("Are you sure to move team member?")) {
				$("<li></li>", {
					"text": ui.draggable.text(),
					"data-id": m_agent_id
				}).appendTo(this);
				
				// To remove item from other shopping chart do this
				var cartid = self.closest('.inner_agents').attr('id');
				$(".inner_agents:not(#"+cartid+") [data-id="+m_agent_id+"]").remove();
				
				//AJAX REQUEST TO SAVE DATA
				var move_from_id = ui.draggable.attr("data-tid");
				var move_to_id	 = self.closest('tr').attr('data-row_id');
				console.log( "move_from_id"  + move_from_id);
				console.log( "move_to_id"  + move_to_id);
				$.ajax({
					url: "<?php echo base_url(); ?>" + "agents/ajax_drag_team_memaber",
					type:"POST",
					data:{ move_from_id : move_from_id, move_to_id: move_to_id, m_agent_id: m_agent_id },
					dataType: "json",
					cache: false,
					beforeSend: function(){
						$(".fullpage_loader").show();
					},
					success: function(r){
						$(".fullpage_loader").hide();
						if(r.status = true){
							alert("Team Member Move Successfully");
							//console.log("ok" + r.msg);
						}else{
							alert("Error! Please try again.");
						}
						location.reload();
					},
					error: function(e){
						$(".fullpage_loader").hide();
						alert( "Something went wrong please try again later. ");
					}
				});
			}
			
			return false;
			//END AJAX REQUEST
		}
	}).sortable({
		items: "li:not(.placeholder)",
		sort: function() {
			$(this).removeClass("ui-state-default");
		}
	});
	
	//remove agent
	$(document).on("click", ".remove_member",function(e){
		e.preventDefault();
		var __this = $(this);
		var user_id = __this.closest('.u_li').attr("data-id");
		var row_id = __this.closest('.u_li').attr("data-tid");
		
		//alert(user_id);
		if (confirm("Are you sure to remove agent from team?")) {
			$.ajax({
				url: "<?php echo base_url(); ?>" + "agents/ajax_remove_agent_from_team",
				type:"POST",
				data:{agent_id: user_id, id: row_id },
				dataType: "json",
				cache: false,
				beforeSend: function(){
					$(".fullpage_loader").show();
				},
				success: function(r){
					$(".fullpage_loader").hide();
					if(r.status = true){
						alert("Success! Agent removed from team.");
					}else{
						alert("Error! Please try again.");
					}
					
					location.reload();
				},
				error: function(e){
					$(".fullpage_loader").hide();
					alert( "Something went wrong please try again later. ");
				}
			});	
		}  
		
		
		console.log(user_id);
		console.log("row_id " + row_id);
		
	});	
	
	
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