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
					<i class="fa fa-users"></i>All Vehicles Bookings
				</div>
				<a class="btn btn-success" href="<?php echo site_url("itineraries"); ?>" title="Book Vehicle">Book Cab</a>
			</div>
		</div>
		<!--start filter section-->
		<div class="row marginBottom second_custom_card">
			<form id="form-filter" class="form-horizontal marginRight margin-bottom-0 bg_white padding_zero">
				<div class="actions custom_filter ">
					<strong>Filter: </strong>
					<div class="btn-group" data-toggle="buttons">
						<label class="btn btn-default custom_active active"><input type="radio" name="filter" value="all" checked="checked" id="all"/>All</label>
						<label class="btn btn-default custom_active"><input type="radio" name="filter" value="upcomming" id="upcomming" />Upcomming</label>
						<label class="btn btn-default custom_active"><input type="radio" name="filter" value="past" id="past" />Past</label>
						<label class="btn btn-default custom_active"><input type="radio" name="filter" value="approved" id="approved" />Approved</label>
						<label class="btn btn-default custom_active"><input type="radio" name="filter" value="declined" id="declined" />Declined</label>
						<label class="btn btn-default custom_active"><input type="radio" name="filter" value="cancel" id="cancel" />Cancel</label>	
						<label class="btn btn-default custom_active"><input type="radio" name="filter" value="pending" id="pending" />Pending</label>
					</div>
				</div>
				<input type="hidden" name="filter_val" id="filter_val" value="all">
			</form><!--End filter section-->	
		</div>
			<div class="clearfix"></div> 		
			<div class="portlet-body">
				<div class="table-responsive custom_card">
					<table id= "vehicles_booking" class="table table-striped display">
						<thead>
							<tr>
								<th> # </th>
								<th> Booking ID </th>
								<th> Itinerary ID </th>
								<th> Transporter Name </th>
								<th> Cab Catergory</th>
								<th> Total Cabs</th>
								<th> Booking Date </th>
								<th> Total Cost </th>
								<th> Sent Status</th>
								<th>Status</th>
								<th>Action</th>
								
							</tr>
						</thead>
						<tbody>
							<!--datatables goes here-->
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<!-- END CONTENT BODY -->
</div>
<div id="myModal" class="modal" role="dialog"></div>
<!-- Modal -->
<script type="text/javascript">
jQuery(document).ready(function($){
	$(document).on("click",".ajax_delete_booking",function(){
		var id = $(this).attr("data-id");
		if (confirm("Are you sure?")) {
			$.ajax({
				url: "<?php echo base_url(); ?>" + "AjaxRequest/ajax_delete_cab_booking?id=" + id,
				type:"GET",
				data:id,
				dataType: 'json',
				cache: false,
				success: function(r){
					if(r.status = true){
						location.reload();
						console.log("ok")
					}else{
						alert("Error! Please try again.");
					}
				},
			});	
		}   
	});
});
jQuery(document).ready(function($){
	var ajaxReq;
	$(document).on("click", ".ajax_booking_status", function(){
		var iti_id = $(this).attr("data-id");
		if (ajaxReq) {
				ajaxReq.abort();
			}
			ajaxReq = $.ajax({
			url: "<?php echo base_url(); ?>" + "AjaxRequest/cab_booking_status",
			type:"POST",
			data:{ id: iti_id },
			dataType: "json",
			cache: false,
			beforeSend: function(){
				/*console.log("Please wait.......");*/
			},
			success: function(r){
				if(r.status = true){
					$( "#myModal" ).html('<div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal">Close</button><h4 class="modal-title"> '  + r.s +' </h4></div><div class="modal-body"> <p>' + r.data + '</p></div><div class="modal-footer"></div></div></div>').fadeIn();
					//console.log("ok" + r.data);
				}else{
					console.log("Error.......");
				}
			},
			error: function(){
				console.log("error");
			}
		});
	});
	jQuery(document).on("click", ".close",function(){
		jQuery("#myModal").fadeOut();
	});
});
</script>
<script type="text/javascript">
var table;
$(document).ready(function() {
	//Custom Filter
	$(document).on("change", 'input[name=filter]:radio', function() {
		var filter_val = $(this).val();
		$("#filter_val").val( filter_val );
		table.ajax.reload(null,true); 
	});
	
    //datatables
    table = $('#vehicles_booking').DataTable({ 
		"aLengthMenu": [[10,25, 50, 100, -1], [10, 25, 50, 100, 'All']],
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
		language: {
			search: "<strong>Search By Itinerary ID:</strong>",
			searchPlaceholder: "Search..."
		},
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('vehiclesbooking/ajax_vehiclesbooking_list')?>",
            "type": "POST",
			"data": function ( data ) {
				data.filter = $("#filter_val").val();
			} 
			// ajax error
				/* error: function(jqXHR, textStatus, errorThrown){
				  console.log(jqXHR);
				  console.log(textStatus);
				  console.log(errorThrown);
				} */
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