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
						<i class="fa fa-inr"></i>All Cash Receipts
					</div>
					<a class="btn btn-success" href="<?php echo site_url("accounts/create_receipt"); ?>" title="Create New Invoice">Generate New Receipt</a>
				</div>
			</div>
			<div class="portlet-body">
				<div class="table-responsive">
					<table class="table table-bordered">
					
						<thead>
							<tr>
								<th> # </th>
								<th> Lead Id </th>
								<th> Receipt</th>
								<th> Voucher No </th>
								<th> Customer Name</th>
								<th> Email  </th>
								<th> Contact </th>
								<th> Transfer Ref.</th>
								<th> Amount</th>
								<th> Sent</th>
								<th> Action </th>								
								<th> Agent </th>								
							</tr>
						</thead>
						
						<tbody>
						<div id="res"></div>
						<?php 
						if( isset($invoices_listing) && !empty( $invoices_listing ) ){
							$i = 1;
							foreach($invoices_listing as $invoice) {
								$rtype = ucfirst($invoice->receipt_type);
								$agent = get_user_name($invoice->agent_id);
								//client view
								$vid = base64_url_encode( $invoice->id );
								$voucher_number = base64_url_encode( $invoice->voucher_number );
								
								$client_v = "<a title='Client Reciept View' href=" . site_url("promotion/receipt/{$vid}/{$voucher_number}") . " class='btn btn-danger' target='_blank' ><i class='fa fa-eye' aria-hidden='true'></i> Client View</a>";
								echo " 
								<tr data-id={$invoice->id}>
									<td> {$i} </td>
									<td> {$invoice->lead_id}</td>
									<td> {$rtype}</td>
									<td> {$invoice->voucher_number}</td>
									<td> {$invoice->customer_name}</td>
									<td> {$invoice->customer_email} </td>
									<td> {$invoice->customer_contact} </td>
									<td> {$invoice->transfer_ref}</td>
									<td> {$invoice->amount_received}</td>
									<td> {$invoice->sent_count} Times</td>
									<td><a href=" . site_url("accounts/update_receipt/{$invoice->id}") . " class='btn btn-success ajax_edit_hotel_table' title='Update Invoice' ><i class='fa fa-pencil'></i></a>
									<a href=" . site_url("accounts/view_receipt/{$invoice->id}") . " class='btn btn-success' title='view' ><i class='fa fa-eye'></i></a>
									{$client_v}
									<a href='javascript:void(0)' class='btn btn-danger ajax_delete_bank'><i class='fa fa-trash-o'></i></a></td>
									<td> {$agent}</td>
								</tr>";
								$i++; 
							}
						}else{
							echo "<tr>";
							for( $colspan = 1 ; $colspan <= 12; $colspan++ ){
								echo $colspan == 1 ? "<td style='border-left:none;border-right:none'>No Data Found !</td>" : "<td style='border-left:none;border-right:none'></td>";
							}
							echo "</tr>";
						
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
	$(document).on("click", ".ajax_delete_bank", function(){
		var res= $("#res");
		var bank_id = $(this).closest("tr").attr("data-id");		if (confirm("Are you sure?")) {			$.ajax({
				url: "<?php echo base_url(); ?>" + "accounts/delete_invoice?id=" + bank_id,
				type:"GET",
				data:bank_id,
				dataType: "json",
				cache: false,
				success: function(r){
					if(r.status = true){						alert(r.msg);
						location.reload();
					}else{
						alert("Error! Please try again.");
					}
				}
			});	
		}   
	});
});
</script>