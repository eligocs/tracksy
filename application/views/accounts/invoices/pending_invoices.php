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
						<i class="fa fa-file-alt"></i>All Pending Invoices
					</div>
					<a class="btn btn-success" href="<?php echo site_url("accounts/invoices"); ?>" title="All Invoice">Confirmed Invoices</a>
				</div>
				
			</div>
			<div class="portlet-body">
				<div class="table-responsive">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th> # </th>
								<th> Lead Id </th>
								<th> Name </th>
								<th> Contact </th>
								<th> Package </th>
								<th> Checkout </th>
								<th> Agent </th>								
								<th> Action </th>
							</tr>
						</thead>
						
						<tbody>
						<div id="res"></div>
						<?php 
						if( isset($pending_invoices) && !empty( $pending_invoices ) ){
							$i = 1;
							foreach($pending_invoices as $invoice) {
								$agent = get_user_name($invoice->agent_id);
								echo " 
								<tr>
									<td> {$i} </td>
									<td> {$invoice->customer_id}</td>
									<td> {$invoice->customer_name}</td>
									<td> {$invoice->customer_contact}</td>
									<td> {$invoice->package_name}</td>
									<td> {$invoice->t_end_date}</td>
									<td> {$agent}</td>
									<td>
										<a href=" . site_url("accounts/generate_invoice/{$invoice->customer_id}") . " class='btn btn-success' target='_blank' title='Create Invoice' ><i class='fa fa-plus'></i> Create Invoice
										</a>
										
										<a href=" . site_url("itineraries/view/{$invoice->iti_id}/{$invoice->temp_key}") . " class='btn btn-success' target='_blank' title='Create Invoice' ><i class='fa fa-eye'></i> View Iti
										</a>
									</td>
								</tr>";
								$i++; 
							}
						}else{
							echo "<tr><td colspan='5'>No Invoice Found !</td></tr>";
						} ?>
						</tbody>
					</table>
				</div>
			</div>			</div>
	</div>
	<!-- END CONTENT BODY -->
</div>
<!-- Modal -->
<script type="text/javascript">
jQuery(document).ready(function($){	$(".table").DataTable();
});
</script>