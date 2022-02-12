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
					<i class="fa fa-users"></i>All Closed Itineraries
				</div>
			</div>
		</div>	
			<div class="portlet-body">
				<div class="table-responsive second_custom_card">
					<table id="itinerary" class="table table-striped display">
						<thead>
							<tr>
								<th> # </th>
								<th> Iti ID </th>
								<th> Iti Type </th>
								<th> Lead ID </th>
								<th> Name </th>
								<th> Package Name</th>
								<th> Tra. Date</th>
								<th> Booking Date</th>
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
<script type="text/javascript">
var table;
$(document).ready(function() {
	
		//Get all itineraries by agent 
		$(document).on("change", '#sales_user_id', function() {
			table.ajax.reload(null,true);
		});
	//Custom Filter
	$("#form-filter").validate({
		rules: {
			filter: {required: true},
			dateRange: {required: true},
		},
	});
		
	$("#form-filter").submit(function(e){
		e.preventDefault();
		table.ajax.reload(null,true);
	});
	
	var table;
	var tableFilter;
	//datatables
	table = $('#itinerary').DataTable({ 
		"aLengthMenu": [[10,25, 50, 100, -1], [10, 25, 50, 100, 'All']],
		"processing": true, //Feature control the processing indicator.
		"serverSide": true, //Feature control DataTables' server-side processing mode.
		"order": [], //Initial no order.
		language: {
			search: "<strong>Search By Itinerary/Customer ID:</strong>",
			searchPlaceholder: "Search..."
		},
		// Load data for the table's content from an Ajax source
		"ajax": {
			"url": "<?php echo site_url('itineraries/ajax_closeditineraries_list')?>",
			"type": "POST",
			"data": function ( data ) {
				data.filter = $("#filter_val").val();
				data.from = $("#date_from").attr("data-date_from");
				data.end = $("#date_to").attr("data-date_to");
				data.todayStatus = $("#todayStatus").val();
				data.agent_id = $("#sales_user_id").val();
			},
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