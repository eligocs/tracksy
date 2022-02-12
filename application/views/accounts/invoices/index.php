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
						<i class="fa fa-file-alt"></i>All Invoices
					</div>
					<a class="btn btn-success" href="<?php echo site_url("accounts/pending_invoices"); ?>" title="All Invoice">Generate Invoice</a>
				</div>
			</div>
			<div class="portlet-body second_custom_card">
				<div class="table-responsive">
					<table class="table table-striped display">
						<thead>
							<tr>
								<th> # </th>
								<th title="Customer Account ID"> Cus. Acc. Id </th>
								<th> Lead Id </th>
								<th> Financial Year </th>
								<th> Invoice No</th>
								<th> Booking ID </th>
								<th> Agent </th>								
								<th> Action </th>
							</tr>
						</thead>
						
						<tbody>
						<div id="res"></div>
						<?php 
						if( isset($invoices) && !empty( $invoices ) ){
							$i = 1;
							foreach($invoices as $invoice) {
								$agent = get_user_name($invoice->agent_id);
								$customer_acc = get_customer_account( $invoice->lead_id );
								$customer_acc_id = isset( $customer_acc[0]->id ) ? $customer_acc[0]->id : 0;
								echo " 
								<tr data-id={$invoice->id}>
									<td> {$i} </td>
									<td> {$customer_acc_id} </td>
									<td> {$invoice->lead_id}</td>
									<td> {$invoice->financial_year}</td>
									<td> {$invoice->invoice_no}</td>
									<td> {$invoice->booking_id}</td>
									<td> {$agent}</td>
									
									<td>
										<a href=" . site_url("accounts/view_invoice/{$invoice->id}") . " class='btn btn-success' target='_blank' title='View Invoice' ><i class='fa fa-eye'></i>
										</a>";
										
										if( $user_role == 93 ){
											echo "<a data-id='{$invoice->id}' href='javascript:void(0)' class='btn btn-danger delete_invoice' target='_blank' title='Delete Invoice' ><i class='fa fa-trash-o'></i></a>";
										}
										
									echo "</td></tr>";
								$i++; 
							}
						}else{
							echo "<tr><td colspan='8'>No Invoice Found !</td></tr>";
						} ?>
						</tbody>
					</table>
				</div>
			</div>
			</div>
	</div>
	<!-- END CONTENT BODY -->
</div>
<!-- Modal -->
<script type="text/javascript">
jQuery(document).ready(function($){
	$(".table").DataTable();
	
	//delete
	$(document).on("click", ".delete_invoice", function(){
		var id = $(this).attr("data-id");
		if (confirm("Are you sure?")) {
			$.ajax({
				url: "<?php echo base_url(); ?>" + "accounts/delete_invoice_perm?id=" + id,
				type:"GET",
				data:id,
				dataType: 'json',
				cache: false,
				success: function(r){
					if(r.status = true){
						location.reload();
					  //console.log("ok" + r.msg);
						//console.log(r.msg);
					}else{
						alert("Error! Please try again.");
					}
				}
			});	
		}   
	});
	
	
});
</script>