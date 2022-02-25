<?php if($account_listing){ 
	$account_listing = $account_listing[0];		?>
<div class="page-container">
	<div class="page-content-wrapper">
		<div class="page-content">
			<div class="portlet box blue">
				<div class="portlet-title">
					<div class="caption"><i class="fa fa-users"></i>
						<strong>Name: <span class=""><?php echo $account_listing->name; ?></span></strong>
					</div>
					<a class="btn btn-success" href="<?php echo site_url("ledger"); ?>" title="Back">Back</a>
				</div>
			</div>
			<?php $message = $this->session->flashdata('success'); 
				if($message){ echo '<span class="help-block help-block-success">'.$message.'</span>'; }
			?>
			<div class="portlet-body custom_card">
				<h3>Customer Details</h3>
				<div class="table-responsive">	
				<table class="table table-condensed table-hover table-bordered">
					<tr>
						<td width="20%"><div class="col-mdd-2 form_vl border_right_none"><strong>Name: </strong></div></td>	
						<td><div class="col-mdd-10 form_vr"><?php echo $account_listing->name; ?></div></td>
					</tr>
					<tr>
						<td width="20%"><div class="col-mdd-2 form_vl border_right_none"><strong>Email: </strong></div></td>	
						<td><div class="col-mdd-10 form_vr"><?php echo $account_listing->email; ?></div></td>
					</tr>	
					
				
					<tr>
						<td width="20%"><div class="col-mdd-2 form_vl border_right_none"><strong>Mobile Number:</strong></div></td>	
						<td><div class="col-mdd-10 form_vr"><?php echo $account_listing->contact; ?></div></td>
					</tr>
					
					<tr>
						<td width="20%"><div class="col-mdd-2 form_vl border_right_none"><strong>Alternate Number:</strong></div></td>	
						<td><div class="col-mdd-10 form_vr"><strong><?php echo $account_listing->alternate_contact_number; ?></strong></div></td>
					</tr>
					
					<tr>
						<td width="20%"><div class="col-mdd-2 form_vl border_right_none"><strong>Address:</strong></div></td>	
						<td><div class="col-mdd-10 form_vr"><strong><?php echo $account_listing->address; ?></strong></div></td>
					</tr>
					
					<tr>
						<td width="20%"><div class="col-mdd-2 form_vl border_right_none"><strong>Remarks:</strong></div></td>	
						<td><div class="col-mdd-10 form_vr"><strong><?php echo $account_listing->remarks; ?></strong></div></td>
					</tr>
					
					<tr>
						<td width="20%"><div class="col-mdd-2 form_vl border_right_none"><strong>Status:</strong></div></td>	
						<td><div class="col-mdd-10 form_vr"><strong><?php echo $account_listing->status == 1 ? "Blacklist" : "Active"; ?></strong></div></td>
					</tr>
					
					
					
					<tr>
						<td width="20%"><div class="col-mdd-2 form_vl border_right_none"><strong>Updated By:</strong></div></td>	
						<td><div class="col-mdd-10 form_vr"><strong><?php echo get_user_name($account_listing->updated_by); ?></strong></div></td>
					</tr>
					
					<tr>
						<td width="20%"><div class="col-mdd-2 form_vl border_right_none"><strong>Created:</strong></div></td>	
						<td><div class="col-mdd-10 form_vr"><strong><?php echo $account_listing->created_at; ?></strong></div></td>
					</tr>
					
				</table>
			</div>				
			<div class="text-center">
				<a title='Edit User' href="<?php echo site_url("ledger/add_vendor_account/{$account_listing->id}"); ?>" class="btn btn-success" ><i class="fa fa-pencil"></i> Edit </a>
			</div>	
			
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
									<td><a target='_blank' href=" . site_url("accounts/update_receipt/{$invoice->id}") . " class='btn_pencil ajax_edit_hotel_table' title='Update Invoice' ><i class='fa fa-pencil'></i></a>
									<a target='_blank' href=" . site_url("accounts/view_receipt/{$invoice->id}") . " class='btn_eye' title='view' ><i class='fa fa-eye'></i></a></td>
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
