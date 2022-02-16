<div class="page-container">
	<div class="page-content-wrapper">
		<div class="page-content">
			<div class="portlet box blue">
				<div class="portlet-title">
					<div class="caption">
						<i class="fa fa-cogs"></i>View All Instant Call From Query Generator
					</div>
				</div>
			</div>
			<?php $message = $this->session->flashdata('success'); 
				if($message){ echo '<span class="help-block help-block-success">'.$message.'</span>'; }
			?>
			<div class="portlet-body">
				<div class="table-responsive second_custom_card">
					<table id="sliders" class="table table-striped">
						<thead>
							<tr>
								<th> # </th>
								<th> Mobile </th>
								<th> Query From </th>
								<th> Created </th>
								<th> Followup </th>
								<th> Action </th>
							</tr>
						</thead>
						<tbody>
						<!--data table goes here -->
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
jQuery(document).ready(function($){
	$(document).on("click", ".ajax_delete_review", function(){
		var id = $(this).attr("data-id");
		if (confirm("Are you sure?")) {
			$.ajax({
				url: "<?php echo base_url(); ?>" + "indiatourizm/delete_instant_query",
				type:"POST",
				data:{id: id},
				dataType: "json",
				cache: false,
				success: function(r){
					console.log("error");
					if(r.status = true){
						location.reload();
						console.log("ok" + r.msg);
					}else{
						alert("error");
					}
				}
			});	
		}   
	});
	
	//update followup status
	$(document).on("click", ".update_followup", function(e){
		e.preventDefault();
		var id = $(this).attr("data-data_id");
		if (confirm("Are you sure to change status to DONE?")) {
			$.ajax({
				url: "<?php echo base_url(); ?>" + "indiatourizm/udpate_instant_query",
				type:"POST",
				data:{id: id},
				dataType: "json",
				cache: false,
				success: function(r){
					console.log("success");
					if(r.status = true){
						location.reload();
						//console.log("ok" + r.msg);
					}else{
						alert("error");
					}
				}
			});	
		}   
	});
});
</script>
<script type="text/javascript">
var table;
$(document).ready(function() {
    //datatables
    table = $('#sliders').DataTable({ 
		"aLengthMenu": [[10, 50, 100, -1], [10, 50, 100, 'All']],
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
		language: {
			search: "<strong>Search By name:</strong>",
			searchPlaceholder: "Search..."
		},
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('indiatourizm/ajax_instant_call_list')?>",
            "type": "POST"
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