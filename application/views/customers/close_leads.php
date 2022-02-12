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
					<i class="fa fa-users"></i>All Close Leads
				</div>
			</div>
		</div>	
			<div class="portlet-body">
				<div class="table-responsive">
					<table id="customers" class="table table-bordered">
						<thead>
							<tr>
								<th> # </th>
								<th> Lead ID </th>
								<th> Customer Name</th>
								<th> Email </th>
								<th> Contact </th>
								<th> Agent </th>
								<th> Created </th>
								<th> Action </th>
							</tr>
						</thead>
						<tbody>
							<!--DataTable goes here-->
						</tbody>
					</table>
				</div>
			</div>
		</div>
		</div>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function() {
	var table;
	//On page loaddatatables
		table = $('#customers').DataTable({ 
			"aLengthMenu": [[15,30, 50, 100, -1], [15, 30, 50, 100, 'All']],
			"processing": true, //Feature control the processing indicator.
			"serverSide": true, //Feature control DataTables' server-side processing mode.
			"order": [], //Initial no order.
			language: {
				search: "<strong>Search By Customer ID:</strong>",
				searchPlaceholder: "Search..."
			},
			// Load data for the table's content from an Ajax source
			"ajax": {
				"url": "<?php echo site_url('customers/ajax_close_customers_list')?>",
				"type": "POST",
				/* "data": function ( data ) {
					data.sortBy = "lead_last_followup_date";
				}, */ 
				beforeSend: function(){
					console.log("sending....");
				}
			},
			//Set column definition initialisation properties.
			"columnDefs": [
			{ 
				"targets": [ 0 ], //first column / numbering column
				"orderable": false, //set not orderable
			},
			],

		});
			
});
</script>