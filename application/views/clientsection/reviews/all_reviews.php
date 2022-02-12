<div class="page-container">
	<div class="page-content-wrapper">
		<div class="page-content">
			<div class="portlet box blue">
				<div class="portlet-title">
					<div class="caption">
						<i class="fa fa-cogs"></i>View All Reviews
					</div>
					<a class="btn btn-success" href="<?php echo site_url("clientsection/review_add"); ?>" title="add review">Add Review</a>
				</div>
			</div>
			<?php $message = $this->session->flashdata('success'); 
				if($message){ echo '<span class="help-block help-block-success">'.$message.'</span>'; }
			?>
			<div class="portlet-body">
				<div class="table-responsive second_custom_card">
					<table id="reviews" class="table table-striped display">
						<thead>
							<tr>
								<th> # </th>
								<th> Client Name </th>
								<th> Client Contact </th>
								<th> Rating </th>
								<th> In Slider </th>
								<th> Created </th>
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
		var rev_id = $(this).attr("data-id");
		if (confirm("Are you sure?")) {
			$.ajax({
				url: "<?php echo base_url(); ?>" + "clientsection/ajax_deletereview?id=" + rev_id,
				type:"GET",
				data:rev_id,
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
});
</script>
<script type="text/javascript">
var table;
$(document).ready(function() {
    //datatables
    table = $('#reviews').DataTable({ 
		"aLengthMenu": [[10, 50, 100, -1], [10, 50, 100, 'All']],
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
		language: {
			search: "<strong>Search By Rating:</strong>",
			searchPlaceholder: "Search..."
		},
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('clientsection/ajax_review_list')?>",
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
<!-- Show review in slider section on/off button -->
<script>
	jQuery(document).ready(function($){
		$(document).on("click", '#inSlider', function() {
			var ajaxReq;
			//get review status
			if (!$(this).is(':checked')) {
				var chkVal = 0;
			}else{
				var chkVal = 1;
			}
			//get review id
			var id = $(this).attr("data-id");
			console.log( id );
			console.log( chkVal );
			if (ajaxReq) {
				ajaxReq.abort();
			}
			//ajax request to update status	
			ajaxReq = $.ajax({
				url: "<?php echo base_url(); ?>" + "clientsection/ajax_updateSliderStatus",
				type:"POST",
				data:{ "id":  id, "is_slider": chkVal },
				dataType: 'json',
				cache: false,
				success: function(r){
					if(r.status = true){
						location.reload();
					  console.log("ok" + r.msg);
						//console.log(r.msg);
					}else{
						alert("Error! Please try again.");
					}
				}
			});
		});
	});	
</script>