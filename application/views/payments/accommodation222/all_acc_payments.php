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
					<i class="fa fa-users"></i>All Accommodation Payments
				</div>
			</div>
		</div>	
			<div class="portlet-body">
				<div class="table-responsive">
					<table id="payments" class="table table-bordered">
						<thead>
							<tr>
								<th> # </th>
								<th> Acc ID </th>
								<th> Customer Name </th>
								<th> Customer Contact </th>
								<th> Package Cost </th>
								<th> Balance</th>
								<th> Next Due Date</th>
								<th> Status</th>
								<th> Action </th>
							</tr>
						</thead>
						<tbody>
						<div class="loader"></div>
						<div id="res"></div>
							<!--DataTable Goes here-->
						</tbody>
					</table>
				</div>
			</div>
		</div>
		
		</div>
	</div>
	<!-- END CONTENT BODY -->
</div>
<div id="myModal" class="modal" role="dialog"></div>

<script type="text/javascript">
var table;
$(document).ready(function() {
	var table;
	var tableFilter;
	//datatables
	table = $('#payments').DataTable({ 
		"aLengthMenu": [[10,25, 50, 100, -1], [10, 25, 50, 100, 'All']],
		"processing": true, //Feature control the processing indicator.
		"serverSide": true, //Feature control DataTables' server-side processing mode.
		"order": [], //Initial no order.
		language: {
			search: "<strong>Search By Acc Id/Package Name:</strong>",
			searchPlaceholder: "Search..."
		},
		// Load data for the table's content from an Ajax source
		"ajax": {
			"url": "<?php echo site_url('payments/ajax_acc_payments_list')?>",
			"type": "POST",
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
