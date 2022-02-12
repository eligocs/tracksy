<div class="page-container">
	<div class="page-content-wrapper">
		<div class="page-content">
		<!-- BEGIN SAMPLE TABLE PORTLET-->
		<?php $message = $this->session->flashdata('success'); 
		if($message){ echo '<span class="help-block help-block-success">'.$message.'</span>';}
		?>
		<div class="portlet box blue">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-users"></i>On Hold Itineraries
				</div>
			</div>
		</div>	
			
			<div class="portlet-body">
				<div class="table-responsive second_custom_card">
					<table id="itinerary" class="table table-striped display">
						<thead>
							<tr>
								<th> # </th>
								<th> Iti ID </th>
								<th> Iti Type </th>
								<th> Lead ID </th>
								<th> Customer Name </th>
								<th> Package Name </th>
								<th> Agent </th>
								<th> Action </th>
							</tr>
						</thead>
						<tbody>
							<!--DataTable Goes here-->
							<?php 
							$counter = 1;
							if( isset($on_hold_itineraries) && !empty($on_hold_itineraries) ) { 
								foreach( $on_hold_itineraries as $onhold ){ 
									$iti_type =  $onhold->iti_type == 2 ? "Accommodation" : "Holiday";
									$view_link = site_url("itineraries/view/{$onhold->iti_id}/{$onhold->temp_key}#update_iti_hold_status");
									?>
									<tr>
										<td><?php echo $counter; ?></td>
										<td><?php echo $onhold->iti_id; ?></td>
										<td><?php echo $iti_type; ?></td>
										<td><?php echo $onhold->customer_id; ?></td>
										<td><?php echo $onhold->customer_name; ?></td>
										<td><?php echo $onhold->package_name; ?></td>
										<td><?php echo get_user_name( $onhold->agent_id ); ?></td>
										<td>
											<a class="btn btn-custom" target="_blank" href="<?php echo $view_link; ?>">View</a>
										</td>
									</tr>
								<?php 
									$counter++;
								} 
							}else{ ?>	
								<tr><td colspan="8" class="text-center">No Data found.</td></tr>
							<?php } ?> 
						
						</tbody>
					</table>
				</div>
			</div>
		</div>
		
		</div>
	</div>
	<!-- END CONTENT BODY -->
</div>
<script>
jQuery(document).ready(function($){
	$("#itinerary").dataTable();
});
</script>