<div class="page-container">
	<div class="page-content-wrapper">
		<div class="page-content">
		<!-- BEGIN SAMPLE TABLE PORTLET-->
		<?php $message = $this->session->flashdata('success'); 
		if($message){ echo '<span class="help-block help-block-success">'.$message.'</span>';}
		?>
			<div class="portlet box blue" style="margin-bottom:0;">
				<div class="portlet-title">
					<div class="caption">
						<i class="fa fa-users"></i>All Pending Volvo/train/flight ticket Bookings Quotation  By Agent
					</div>
				</div>
			</div>	
			
			<div class="portlet-body">
				<div class="table-responsive">
					<table id= "hotels-booking" class="table table-bordered">
						<thead>
							<tr>
								<th> # </th>
								<th> Iti ID </th>
								<th> Type </th>
								<th> Dep. Date </th>
								<th> Cost per/seat</th>
								<th>Agent</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php if( isset( $cab_booking ) && !empty( $cab_booking ) ){
								$i = 1;
								foreach( $cab_booking as $cab_book ){
									$customer_name = get_customer_name($cab_book->customer_id);
									$iti_id 			= $cab_book->iti_id;
									$booking_type 		= ucfirst($cab_book->booking_type);
									$booking_id 		= $cab_book->id;
									$booking_date = date("d/m/Y", strtotime($cab_book->dep_date)) . " - " . date("d/m/Y", strtotime($cab_book->arr_date));
									$agent = get_user_name($cab_book->agent_id);
									
									$edit = "<a target='_blank' title='Edit and approve' href=" . site_url("vehiclesbooking/editvtf/{$booking_id}/{$iti_id}") . " class='btn btn-success' ><i class='fa fa-refresh' aria-hidden='true'></i> Update And Approve</a>";
									
									echo "<tr>
										<td>{$i}</td>
										<td>{$cab_book->iti_id}</td>
										<td>{$booking_type}</td>
										<td>{$booking_date}</td>
										<td>{$cab_book->cost_per_seat}</td>
										<td>{$agent}</td>
										<td>{$edit}</td>
									</tr>";
									$i++;
								}
							}else{
								echo "<tr><td colspan=7>No Pending Request</td></tr>";
							} ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<!-- END CONTENT BODY -->
</div>
<script>
jQuery(document).ready(function($){
	jQuery(".table").DataTable();
});	
</script>
