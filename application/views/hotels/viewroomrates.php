<div class="page-container">
	<div class="page-content-wrapper">
		<div class="page-content">
		 <!-- BEGIN SAMPLE TABLE PORTLET-->
		<div class="portlet box blue">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-cogs"></i>All Hotel Room Rates 
				</div>
				<a class="btn btn-success" href="<?php echo site_url("hotels/addroomrates"); ?>" title="Add Hotel Room Rates">Add Hotel Room Rates</a>
			</div>
			<div class="portlet-body">
				<div class="table-responsive margin-top-15">
					<table id="room_rates" class="table table-striped display">
						<thead>
							<tr>
								<th> # </th>
								<th> Hotel Name</th>
								<th> City </th>
								<th> Room Category </th>
								<th> Room Rate </th>
								<th> Extra Bed Rate</th>
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
	<!-- END CONTENT BODY -->
</div>
<!-- Modal -->
 


<script type="text/javascript">
jQuery(document).ready(function($){
	$(document).on("click",".ajax_delete_hotelroomrates", function(){
		var room_id = $(this).attr("data-id");
		
		if (confirm("Are you sure?")) {
			$.ajax({
				url: "<?php echo base_url(); ?>" + "AjaxRequest/ajax_deleteHotelRoomRates?id=" + room_id,
				type:"GET",
				data:room_id,
				dataType: "json",
				cache: false,
				success: function(r){
					if(r.status = true){
						location.reload();
					  //console.log("ok" + r.msg);
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
    table = $('#room_rates').DataTable({ 
		"aLengthMenu": [[5,10, 50, 100, -1], [5, 10, 50, 100, 'All']],
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
		language: {
			search: "<strong>Search By Hotel Name:</strong>",
			searchPlaceholder: "Search..."
		},
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('hotels/ajax_roomrates_list')?>",
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