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
						<i class="fa fa-users"></i>All Pending Cab Bookings Quotation  By Agent
					</div>
				</div>
			</div>	
			
			<div class="portlet-body">
				<div class="table-responsive">
					<table id= "hotels-booking" class="table table-bordered">
						<thead>
							<tr>
								<th> # </th>
								<th> ID </th>
								<th> Iti ID </th>
								<th> Transporter Name </th>
								<th> Cab</th>
								<th> Total Cabs</th>
								<th> B. Date </th>
								<th> Total Cost </th>
								<th>Action</th>
								<th>Agent</th>
							</tr>
						</thead>
						<tbody>
							<?php if( isset( $cab_booking ) && !empty( $cab_booking ) ){
								$i = 1;
								foreach( $cab_booking as $cab_book ){
									$customer_name = get_customer_name($cab_book->customer_id);
									$iti_id 			= $cab_book->iti_id;
									$transporter_name 	= get_transporter_name($cab_book->transporter_id);
									$cab_name 			= get_car_name( $cab_book->cab_id );
									$booking_id 		= $cab_book->id;
									$booking_date = date("d/m/Y", strtotime($cab_book->picking_date)) . " - " . date("d/m/Y", strtotime($cab_book->droping_date));
									$agent = get_user_name($cab_book->agent_id);
									
									$edit = "<a target='_blank' title='Edit and approve' href=" . site_url("vehiclesbooking/editcabbooking/{$booking_id}") . " class='btn btn-success' ><i class='fa fa-refresh' aria-hidden='true'></i> Edit And Approve</a>";
									
									echo "<tr>
										<td>{$i}</td>
										<td>{$cab_book->id}</td>
										<td>{$cab_book->iti_id}</td>
										<td>{$transporter_name}</td>
										<td>{$cab_name}</td>
										<td>{$cab_book->total_cabs}</td>
										<td>{$booking_date}</td>
										<td>{$cab_book->total_cost}</td>
										<td>{$edit}</td>
										<td>{$agent}</td>
									</tr>";
									$i++;
								}
							}else{
								echo "<tr><td colspan=12>No Pending Request</td></tr>";
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