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
						<i class="fa fa-cart-plus"></i>All Bank/Cash Accounts
					</div>
					<a class="btn btn-success" href="<?php echo site_url("accounts/add_account"); ?>" title="Add New Account">Add account</a>
				</div>
			</div>
			<div class="portlet-body">
				<div class="table-responsive second_custom_card">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th> # </th>
								<th> Account Name</th>
								<th> Type  </th>
								<th> Address </th>
								<th> Account Number </th>								
								<th> IFSC Code</th>
								<th> Status</th>
								<th> Action </th>								
							</tr>
						</thead>
						<tbody>
						<div id="res"></div>
						<?php 
						if($account_listing){
							$i = 1;
							foreach($account_listing as $account) {
								$status = $account->acc_status == 1 ? "Blacklist" : "Active";
								echo " 
									<tr data-id={$account->id}>
										<td> {$i} </td>
										<td> {$account->account_name}</td>
										<td> {$account->account_type} </td>
										<td> {$account->address} </td>
										<td> {$account->account_number}</td>
										<td> {$account->ifsc_code}</td>
										<td> {$status}</td>
										<td><a href=" . site_url("accounts/add_account/{$account->id}") . " class='btn btn-success ajax_edit_hotel_table' ><i class='fa fa-pencil'></i></a>
										<a href='javascript:void(0)' class='btn btn-danger ajax_delete_bank'><i class='fa fa-trash-o'></i></a></td>
									</tr>";
								$i++; 
							}
						}else{
							echo "<tr>";
							for( $colspan = 1 ; $colspan <= 8; $colspan++ ){
								echo $colspan == 1 ? "<td style='border-left:none;border-right:none'>No Account Found !</td>" : "<td style='border-left:none;border-right:none'></td>";
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
		var bank_id = $(this).closest("tr").attr("data-id");
		if (confirm("Are you sure?")) {
			$.ajax({
				url: "<?php echo base_url(); ?>" + "accounts/delete_account?id=" + bank_id,
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