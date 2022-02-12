<?php if($account_listing){ 	$account_listing = $account_listing[0];		?>
<div class="page-container">
	<div class="page-content-wrapper">
		<div class="page-content">
			<div class="portlet box blue">
				<div class="portlet-title">
					<div class="caption"><i class="fa fa-users"></i>
						<strong>Name: <span class="red"><?php echo $account_listing->customer_name; ?></span></strong>
					</div>
					<a class="btn btn-success" href="<?php echo site_url("accounts/customeraccounts"); ?>" title="Back">Back</a>
				</div>
			</div>
			<?php $message = $this->session->flashdata('success'); 
				if($message){ echo '<span class="help-block help-block-success">'.$message.'</span>'; }
			?>
			<div class="portlet-body">
				<h3>Customer Details</h3>
				<div class="table-responsive">	
				<table class="table table-condensed table-hover">
					<tr>
						<td width="20%"><div class="col-mdd-2 form_vl"><strong>Name: </strong></div></td>	
						<td><div class="col-mdd-10 form_vr"><?php echo $account_listing->customer_name; ?></div></td>
					</tr>
					<tr>
						<td width="20%"><div class="col-mdd-2 form_vl"><strong>Email: </strong></div></td>	
						<td><div class="col-mdd-10 form_vr"><?php echo $account_listing->customer_email; ?></div></td>
					</tr>	
					
				
					<tr>
						<td width="20%"><div class="col-mdd-2 form_vl"><strong>Mobile Number:</strong></div></td>	
						<td><div class="col-mdd-10 form_vr"><?php echo $account_listing->customer_contact; ?></div></td>
					</tr>
					
					<tr>
						<td width="20%"><div class="col-mdd-2 form_vl"><strong>Alternate Number:</strong></div></td>	
						<td><div class="col-mdd-10 form_vr"><strong><?php echo $account_listing->alternate_contact_number; ?></strong></div></td>
					</tr>
					
					<tr>
						<td width="20%"><div class="col-mdd-2 form_vl"><strong>Address:</strong></div></td>	
						<td><div class="col-mdd-10 form_vr"><strong><?php echo $account_listing->address; ?></strong></div></td>
					</tr>
					<tr>
						<td width="20%"><div class="col-mdd-2 form_vl"><strong>Country:</strong></div></td>	
						<td><div class="col-mdd-10 form_vr"><strong><?php echo get_country_name($account_listing->country_id); ?></strong></div></td>
					</tr>
					<tr>
						<td width="20%"><div class="col-mdd-2 form_vl"><strong>State:</strong></div></td>	
						<td><div class="col-mdd-10 form_vr"><strong><?php echo get_state_name($account_listing->state_id); ?></strong></div></td>
					</tr>
					
					<tr>
						<td width="20%"><div class="col-mdd-2 form_vl red"><strong>Place of Supply:</strong></div></td>	
						<td><div class="col-mdd-10 form_vr red"><strong><?php echo get_state_name($account_listing->place_of_supply_state_id); ?></strong></div></td>
					</tr>
					
					<tr>
						<td width="20%"><div class="col-mdd-2 form_vl red"><strong>Client GST:</strong></div></td>	
						<td><div class="col-mdd-10 form_vr red"><strong><?php echo $account_listing->client_gst; ?></strong></div></td>
					</tr>
					
					<tr>
						<td width="20%"><div class="col-mdd-2 form_vl"><strong>Remarks:</strong></div></td>	
						<td><div class="col-mdd-10 form_vr"><strong><?php echo $account_listing->remarks; ?></strong></div></td>
					</tr>
					
					<tr>
						<td width="20%"><div class="col-mdd-2 form_vl"><strong>Status:</strong></div></td>	
						<td><div class="col-mdd-10 form_vr"><strong><?php echo $account_listing->status == 1 ? "Blacklist" : "Active"; ?></strong></div></td>
					</tr>
					
					
					
					<tr>
						<td width="20%"><div class="col-mdd-2 form_vl"><strong>Updated By:</strong></div></td>	
						<td><div class="col-mdd-10 form_vr"><strong><?php echo get_user_name($account_listing->updated_by); ?></strong></div></td>
					</tr>
					
					<tr>
						<td width="20%"><div class="col-mdd-2 form_vl"><strong>Created:</strong></div></td>	
						<td><div class="col-mdd-10 form_vr"><strong><?php echo $account_listing->created_at; ?></strong></div></td>
					</tr>
				</table>
			</div>	
			
			<div class="text-center">
				<a title='Edit User' href="<?php echo site_url("accounts/add_cus_account/{$account_listing->id}"); ?>" class="btn btn-success" ><i class="fa fa-pencil"></i> Edit Customer</a>
			</div>	
			
			<hr>
			<!--BOOKING DETAILS -->
			<h3>Booking Details</h3>
			<div class="table-responsive">	
				<table class="table table-condensed table-hover">
					<?php if( !empty( $booking_listing ) ){
						foreach( $booking_listing as $book ){
							if( $book->close_account == 1 ){
								$close_account = "<strong class='red'>Booking Closed</strong>";
								$invoice_btn = "";
							}else{
								$close_account = "<strong class='green'>Open</strong>";
								$invoice_link = site_url("accounts/create_receipt/{$book->lead_id}");
								$invoice_btn = "<a href='{$invoice_link}' target='_blank' data-toggle='tooltip' title='Click to generate Receipt' class='btn btn-success'><i class='fa fa-plus'></i> Generate Receipt</a>";
							}
							$iti_link = iti_view_single_link($book->iti_id);
							$btnv = "<a href='{$iti_link}' target='_blank' title='click to view'>{$book->lead_id}</a>";
							?>
							<tr>
								<td width="20%"><div class="col-mdd-2 form_vl"><strong>Lead Id: </strong></div></td>	
								<td><div class="col-mdd-10 form_vr"><?php echo $btnv . " ( {$close_account} ) {$invoice_btn}"  ?></div></td>
							</tr>
						<?php }
					} ?>	
				</table>	
			</div><!--END BOOKING DETAILS -->
			<hr>
			
			<!--INVOICES DETAILS -->
			<h3>INVOICES</h3>
			
			<div class="table-responsive">
				<table class="table table-condensed table-hover">
					<thead>
						<tr>
							<th> # </th>
							<th> Voucher No </th>
							<th> Lead Id </th>
							<th> Transfer Ref.</th>
							<th> Amount</th>
							<th> Action </th>								
						</tr>
					</thead>
					<tbody>
						<?php if( isset($invoices_listing) && !empty( $invoices_listing ) ){
							$i = 1;
							foreach($invoices_listing as $invoice) {
								
								echo " 
								<tr data-id={$invoice->id}>
									<td> {$i} </td>
									<td> {$invoice->voucher_number}</td>
									<td> {$invoice->lead_id}</td>
									<td> {$invoice->transfer_ref}</td>
									<td> {$invoice->amount_received}</td>
									<td><a target='_blank' href=" . site_url("accounts/update_receipt/{$invoice->id}") . " class='btn btn-success ajax_edit_hotel_table' title='Update Invoice' ><i class='fa fa-pencil'></i></a>
									<a target='_blank' href=" . site_url("accounts/view_receipt/{$invoice->id}") . " class='btn btn-success' title='view' ><i class='fa fa-eye'></i></a></td>
								</tr>";
								$i++; 
							}
						}else{
							echo "<tr><td colspan='9'>No Account Found !</td></tr>";
						} ?>	
					</tbody>	
				</table>	
			</div><!--END INVOICES DETAILS -->
			
				
				
			
		</div>	
	</div>
</div>
	<div class="loader"></div>
<?php }else{
	redirect(404);
} ?>	

<script>
jQuery( document ).ready(function($){
	 $('[data-toggle="tooltip"]').tooltip();
});
</script>
