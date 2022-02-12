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
					<i class="fa fa-users"></i>All Declined Leads
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
								<th> Declined By </th>
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
				"url": "<?php echo site_url('customers/ajax_declined_customers_list')?>",
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
<script type="text/javascript">
	/* Reopen Lead */
	jQuery(document).ready(function($){
		$(document).on("click", "#reopenLead", function(e){
			e.preventDefault();
			var ajaxRst;
			var cus_id = $(this).attr("data-customer_id");
			var temp_key = $(this).attr("data-temp_key");
			var response = $("#rr");
			
			if (confirm("Are you sure to reopen lead ?")) {
				if (ajaxRst) {
					ajaxRst.abort();
				}
				ajaxRst =	jQuery.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>" + "customers/ajax_reopenLead",
					dataType: 'json',
					data: {customer_id: cus_id, temp_key: temp_key},
					beforeSend: function(){
						response.show().html('<p><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
						
					},
					success: function(res) {
						if (res.status == true){
							window.location.href = "<?php echo site_url('customers/view/');?>" + cus_id + "/" + temp_key; 
						}else{
							response.html('<div class="alert alert-danger"><strong>Error! </strong>'+res.msg+'</div>');
							//console.log("error");
						}
					},
					error: function(){
						response.html('<div class="alert alert-danger"><strong>Error! </strong>Please Try again later! </div>');
					}
				});
			}		
		});
	});	
</script>