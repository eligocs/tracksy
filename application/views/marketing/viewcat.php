<?php if($agent){ 	$agent = $agent[0];		?>
<div class="page-container">
	<div class="page-content-wrapper">
		<div class="page-content">
			<div class="portlet box blue">
				<div class="portlet-title">
					<div class="caption"><i class="fa fa-users"></i>User Name: <strong><?php echo $agent->user_name; ?></strong></div>
					<a class="btn btn-success" href="<?php echo site_url("agents"); ?>" title="Back">Back</a>
				</div>
			</div>
			<div class="portlet-body">
				<h3>User Details</h3>
				<div class="table-responsive">	
				<table class="table table-condensed table-hover">	
					<tr>
						<td width="20%"><div class="col-mdd-2 form_vl"><strong>First Name: </strong></div></td>	
						<td><div class="col-mdd-10 form_vr"><?php echo $agent->first_name; ?></div></td>
					</tr>
					<tr>
						<td width="20%"><div class="col-mdd-2 form_vl"><strong>Last Name: </strong></div></td>	
						<td><div class="col-mdd-10 form_vr"><?php echo $agent->last_name; ?></div></td>
					</tr>
					<tr>
						<td width="20%"><div class="col-mdd-2 form_vl"><strong>Email: </strong></div></td>	
						<td><div class="col-mdd-10 form_vr"><?php echo $agent->email; ?></div></td>
					</tr>	
					<tr>
						<td width="20%"><div class="col-mdd-2 form_vl"><strong>Office Timing: </strong></div></td>	
						<td>
							<?php echo $agent->in_time;?><strong> To </strong><?php echo $agent->out_time;?>
							</div>
						</td>
					</tr>					
					<tr>
						<td width="20%"><div class="col-mdd-2 form_vl"><strong>Mobile Number:</strong></div></td>	
						<td><div class="col-mdd-10 form_vr"><?php echo $agent->mobile; ?></div></td>
					</tr>
					<tr>
						<td width="20%"><div class="col-mdd-2 form_vl"><strong>Gender:</strong></div></td>	
						<td><div class="col-mdd-10 form_vr"><?php echo $agent->gender; ?></div></td>
					</tr>
					<?php	
					if($agent->user_type == 99){
						$agent_type = "Administrator";
					}elseif($agent->user_type == 98){
						$agent_type = "Manager";
					}elseif($agent->user_type == 97){
						$agent_type = "Service Team";
					}elseif($agent->user_type == 96){
						$agent_type = "Sales Team";
					}else{
						$agent_type = "Leads Team";
					} ?>
						
					<tr>
						<td width="20%"><div class="col-mdd-2 form_vl"><strong>User Role:</strong></div></td>	
						<td><div class="col-mdd-10 form_vr"><?php echo $agent_type; ?></div></td>
					</tr>
					<tr>
						<td width="20%"><div class="col-mdd-2 form_vl"><strong>Added By:</strong></div></td>	
						<td><div class="col-mdd-10 form_vr"><?php echo get_user_name($agent->added_by); ?></div></td>
					</tr>
					<tr>
						<td width="20%"><div class="col-mdd-2 form_vl"><strong>User Status:</strong></div></td>	
						<td><div class="col-mdd-10 form_vr"><?php echo $agent->user_status; ?></div></td>
					</tr>
					<tr>
						<td width="20%"><div class="col-mdd-2 form_vl"><strong>Website:</strong></div></td>	
						<td><div class="col-mdd-10 form_vr"><?php echo $agent->website; ?></div></td>
					</tr>
				</table>	
			</div>	
		</div>	
	</div>
</div>
<?php }else{
	redirect(404);
} ?>	

