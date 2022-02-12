<div class="page-container">
	<div class="page-content-wrapper">
		<div class="page-content">
			<!-- BEGIN SAMPLE TABLE PORTLET-->
			<?php $message = $this->session->flashdata('success'); 
				if($message){ echo '<span class="help-block help-block-success">'.$message.'</span>'; }
			?>
			<div class="portlet box blue">
				<div class="portlet-title">
					<div class="caption">
						<i class="fa fa-newspaper-o" aria-hidden="true"></i>All Sent Newsletter
					</div>
					<a class="btn btn-success" href="<?php echo site_url("newsletters/create"); ?>" title="Create Newsletter">Create Newsletter</a>
				</div>
				<div class="portlet-body second_custom_card">
					<div class="table-responsive margin-top-20">
						<table class="table table-striped display" id="table" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th> # </th>
									<th> Newsletter ID </th>
									<th> Subject </th>
									<th> Sent To </th>
									<th> Sent Date/time </th>
									<th> Agent </th>
									<th> Action </th>
								</tr>
							</thead>
							<tbody>
							<!--Data table -->
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
	$(document).on("click", ".ajax_delete_newsletter",function(){
		var id = $(this).attr("data-id");
		//alert(user_id);
		if (confirm("Are you sure?")) {
			$.ajax({
				url: "<?php echo base_url(); ?>" + "newsletters/update_newsletter_del_status?id=" + id,
				type:"GET",
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
<script type="text/javascript">
var table;
$(document).ready(function() {
    //datatables
    table = $('#table').DataTable({ 
		"aLengthMenu": [[10,25, 50, 100, -1], [10, 25, 50, 100, 'All']],
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
		language: {
			search: "<strong>Search By Newsletter ID:</strong>",
			searchPlaceholder: "Search..."
		},
        // Load data for the table's content from an Ajax source
		"ajax": {
            "url": "<?php echo site_url('newsletters/newsletter_list')?>",
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
