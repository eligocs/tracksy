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
					<i class="fa fa-users"></i>All Banks
				</div>
				<a class="btn btn-success" href="<?php echo site_url("terms/add_branch"); ?>" title="Add Bank Details">Add Branch</a>
			</div></div>
			<div class="portlet-body">
				<div class="table-responsive second_custom_card">
					<table class="table table-striped display dataTable">
						<thead>
							<tr>
								<th> # </th>
								<th> Branch Name</th>
								<th> Branch Address  </th>
								<th> Contact Number </th>
								<th> Action </th>
							</tr>
						</thead>
						<tbody>
						<div id="res"></div>
						<?php 
						if($branches){
							$i = 1;
							foreach($branches as $branch) {
								$head = $branch->head_office;
								if( $head == 1 ){
									$h = "(<strong> Head Office </strong>)";
								}else{
									$h = "";
								}
							echo " 
								<tr data-id={$branch->branch_id}>
									<td> {$i}{$h} </td>
									<td> {$branch->branch_name}</td>
									<td> {$branch->branch_address} </td>
									<td> {$branch->branch_contact} </td>
									<td><a href=" . site_url("terms/edit_branch/{$branch->branch_id}") . " class='btn_eye' ><i class='fa fa-eye'></i></a><a href='javascript:void(0)' class='btn_trash ajax_delete_branch'><i class='fa fa-trash-o'></i></a></td>
								</tr>";
								$i++; 
							}	
						}else{
							echo "<tr><td colspan='9'>No Branch Found !</td></tr>";
						} ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		
		</div>
	</div>
	<!-- END CONTENT BODY -->
</div>
<!-- Modal -->
<script type="text/javascript">
jQuery(document).ready(function($){
	$(".ajax_delete_branch").click(function(){
		var res= $("#res");
		var branch_id = $(this).closest("tr").attr("data-id");
		
		if (confirm("Are you sure?")) {
			$.ajax({
				url: "<?php echo base_url(); ?>" + "terms/branch_delete?id=" + branch_id,
				type:"POST",
				data:branch_id,
				dataType: "json",
				cache: false,
				success: function(r){
					if(r.status = true){
						location.reload();
					  console.log("ok" + r.msg);
					}else{
						alert("Error! Please try again.");
					}
				}
			});	
		}   
	});
});
</script>