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
						<i class="fa fa-users"></i>All Vendor Accounts
					</div>
					<a class="btn btn-success" href="<?php echo site_url("ledger/add_vendor_account"); ?>" title="Add New Account">Add Vendor Account</a>
				</div>
			</div>
			<div class="portlet-body">
				<div class="table-responsive second_custom_card">
					<table class="table table-striped display ">
						<thead>
							<tr>
								<th> # </th>
								<th> Acc. ID</th>
								<th> Name</th>
								<th> Email  </th>
								<th> Contact </th>
								<th> Address </th>
								<th> Status</th>
								<th> Action </th>								
							</tr>
						</thead>
						<tbody>
						<div id="res"></div>
						<?php 
						if( isset($account_listing) && !empty( $account_listing ) ){
							$i = 1;
							foreach($account_listing as $account) {
								$status = $account->status == 1 ? "Blacklist" : "Active";
							echo " 
								<tr data-id={$account->id}>
									<td> {$i} </td>
									<td>{$account->id}</td>
									<td> {$account->name}</td>
									<td> {$account->email} </td>
									<td> {$account->contact} </td>
									<td> {$account->address}</td>
									<td> {$status}</td>
									<td><a href=" . site_url("ledger/add_vendor_account/{$account->id}") . " class='btn_pencil ajax_edit_hotel_table' title='Edit or add new booking id' ><i class='fa fa-pencil'></i></a>
									<a href=" . site_url("ledger/view_vendor/{$account->id}") . " class='btn_eye' title='view' ><i class='fa fa-eye'></i></a>
									<a href='javascript:void(0)' class='btn_trash ajax_delete_bank'><i class='fa fa-trash-o'></i></a></td>
								</tr>";
								$i++; 
							}
						}else{
							echo "<tr>";							
								echo "<td colspan=9>No Data Found !</td>";							
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
	<?php if( isset($account_listing) && !empty( $account_listing ) ){ ?>
		$(".table").DataTable();	
	<?php } ?>
	
	$(document).on("click", ".ajax_delete_bank", function(){
		var res= $("#res");
		var bank_id = $(this).closest("tr").attr("data-id");
		if (confirm("Are you sure?")) {
			$.ajax({
				url: "<?php echo base_url(); ?>" + "ledger/delete_vendor_account?id=" + bank_id,
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