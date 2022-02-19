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
						<i class="fa fa-users"></i>All Pending Vouchers
					</div>
				</div>
			</div>
			<div class="clearfix"></div>			
			<div class="clearfix"></div> 				
			<div class="portlet-body second_custom_card">
				<div class="table-responsive">
					<table id="table_vouchers" class="table table-striped display">
						<thead>
							<tr>
								<th> # </th>
								<th> Lead ID </th>
								<th> Iti ID </th>
								<th> Type </th>
								<th> Package Name </th>
								<th> Travel Date </th>
								<th> Agent </th>
								<th> Action </th>
							</tr>
						</thead>
						<tbody>
						<div id="res"></div>
							<?php if( isset( $pending_vouchers ) && !empty( $pending_vouchers ) ){ 
								$counter = 1;
								foreach( $pending_vouchers as $voucher ){
									$type = $voucher->iti_type == 2 ? "Accommodation" : "Holiday";
									$tr_date = get_travel_date($voucher->iti_id);
									$agent = get_user_name($voucher->agent_id);
									$btn_view = "<a target='_blank' title='View' href=" . site_url("itineraries/view/{$voucher->iti_id}/{$voucher->temp_key}") . " class='btn_eye' ><i class='fa fa-eye' aria-hidden='true'></i></a>";
									echo "<tr>
										<td>{$counter}</td>
										<td>{$voucher->customer_id}</td>
										<td>{$voucher->iti_id}</td>
										<td>{$type}</td>
										<td>{$voucher->package_name}</td>
										<td>{$tr_date}</td>
										<td>{$agent}</td>
										<td>{$btn_view}</td>
									</tr>";
									
									$counter++;
								}
							}else{ ?>
								<tr><td colspan="10" >No Pending Voucher Found!</td></tr>
							<?php } ?>
							<!--DataTable Goes here-->
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<!-- END CONTENT BODY -->
</div>

<script>
	jQuery( document ).ready(function($){
		$(".table").DataTable();
	});
</script>
