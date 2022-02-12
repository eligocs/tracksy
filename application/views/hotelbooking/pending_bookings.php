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
						<i class="fa fa-users"></i>All Pending Hotel Bookings Quotation  By Agent
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
								<th> Lead ID </th>
								<th> G/Name </th>
								<th> City </th>
								<th> Hotel Name </th>
								<th> Room Cat</th>
								<th> Booking Date </th>
								<th> Total Cost </th>
								<th>Action</th>
								<th>Agent</th>
							</tr>
						</thead>
						<tbody>
							<?php if( isset( $hotel_booking ) && !empty( $hotel_booking ) ){
								$i = 1;
								foreach( $hotel_booking as $booking ){
									$customer_name = get_customer_name($booking->customer_id);
									$hotel_id = $booking->hotel_id;
									$iti_id = $booking->iti_id;
									$booking_id = $booking->id;
									$hotel_name = get_hotel_name( $hotel_id );
									$room_cat = get_roomcat_name( $booking->room_type );
									$city = get_city_name($booking->city_id);
									$booking_status = $booking->booking_status;
									$booking_date = date("d/m/Y", strtotime($booking->check_in)) . " - " . date("d/m/Y", strtotime($booking->check_out));
									$agent = get_user_name($booking->agent_id);
									
									$edit = "<a target='_blank' title='Edit and approve' href=" . site_url("hotelbooking/edit/{$booking_id}/{$iti_id}") . " class='btn btn-success' ><i class='fa fa-refresh' aria-hidden='true'></i> Update And Approve</a>";
									
									echo "<tr>
										<td>{$i}</td>
										<td>{$booking->id}</td>
										<td>{$booking->customer_id}</td>
										<td>{$customer_name}</td>
										<td>{$city}</td>
										<td>{$hotel_name}</td>
										<td>{$room_cat}</td>
										<td>{$booking_date}</td>
										<td>{$booking->total_cost}</td>
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
	$(".table").DataTable();
});
</script>