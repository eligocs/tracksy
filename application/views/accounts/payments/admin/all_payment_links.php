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
						<i class="fa fa-inr"></i>All Online Transactions
					</div>
					<a class="btn btn-success" href="<?php echo site_url("accounts/create_payment_link"); ?>" title="All Invoice">Create Payment Link</a>
				</div>
				
			</div>
			<div class="portlet-body second_custom_card">
				<div class="table-responsive">
					<table class="table table-striped display">
						<thead>
							<tr>
								<th> # </th>
								<th> ID</th>
								<th> Order Id</th>
								<th> Lead Id </th>
								<th> Iti ID </th>								
								<th> Amount </th>
								<th> Status </th>
								<th> Agent</th>
								<th> Action </th>
							</tr>
						</thead>
						<tbody>
						<div id="res"></div>
						<?php 
						if( isset($payment_links) && !empty( $payment_links ) ){
							$i = 1;
							foreach( $payment_links as $pay_link ) {
								$agent = get_user_name( $pay_link->agent_id );
								$pay_status = $pay_link->paid_status == 1 ? "<strong class='green'>PAID</strong>" : "<strong class='red'>UNPAID</strong>";
								
								$link_token	= base64_url_encode( $pay_link->link_token );
								//$enc_key 	= base64_url_encode(md5( $this->config->item("encryption_key") ));
								$client_link = $delLink = $edLink = "";
								
								if( $pay_link->paid_status == 0 ){
									$client_link = "<a class='btn btn_blue_outline' href='" . base_url("checkout/payinstallment?i={$link_token}") . "' target='_blank' title='Pay Now'><i class='fa fa-inr'></i> Client Payment Link</a>";
									
									$delLink = "<a href='javascript: void(0)' data-id='{$pay_link->id}' class='btn_trash  ajax_delete_bank' target='_blank' title='Delete Payement Link' ><i class='fa fa-trash'></i>
										</a>";
										
									$edLink = "<a href='" . base_url("accounts/create_payment_link/{$pay_link->id}") . "' class='btn_pencil ' target='_blank' title='Update Payement Link' ><i class='fa fa-pencil'></i>
										</a>";
								}	
								
								echo " 
								<tr data-id={$pay_link->id}>
									<td> {$i} </td>
									<td> {$pay_link->link_token}</td>
									<td> {$pay_link->order_id}</td>
									<td> {$pay_link->customer_id}</td>
									<td> {$pay_link->iti_id}</td>
									<td> {$pay_link->trans_amount}</td>
									<td> {$pay_status}</td>
									<td> {$agent}</td>
									<td>
										<a href=" . site_url("accounts/view_payment_link/{$pay_link->id}") . " class='btn_eye' target='_blank' title='View Payement' ><i class='fa fa-eye'></i>
										{$edLink}
										{$delLink}
										{$client_link}
									</td>
								</tr>";
								$i++; 
							}
						}else{
							
							echo "<tr>";
							for( $colspan = 1 ; $colspan <= 9; $colspan++ ){
								echo $colspan == 1 ? "<td style='border-left:none;border-right:none'>No Data Found !</td>" : "<td style='border-left:none;border-right:none'></td>";
							}
							echo "</tr>";
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
	
	$(document).on("click", ".ajax_delete_bank", function(){
		var res= $("#res");
		var bank_id = $(this).attr("data-id");
		if (confirm("Are you sure?")) {
			$.ajax({
				url: "<?php echo base_url(); ?>" + "accounts/delete_paylink?id=" + bank_id,
				type:"GET",
				data:bank_id,
				dataType: "json",
				cache: false,
				success: function(r){
					if(r.status = true){
						alert(r.msg);
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