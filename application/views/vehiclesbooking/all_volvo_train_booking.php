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
                    <a class="btn btn-success" href="<?php echo site_url("itineraries"); ?>" title="Book Vehicle">Book
                        Volvo/Train/Flight</a>
                </div>
            </div>
            <div class="row marginBottom second_custom_card">
                <!--start filter section-->
                <form id="form-filter" class="form-horizontal marginRight bg_white margin_bottom_0 padding_zero">
                    <div class="actions custom_filter">
                        <div class="col-md-3">
                            <label>Filter: </label>
                            <select class="form-control booking_type" name="booking_type">
                                <option value="">All</option>
                                <option value="volvo">Volvo</option>
                                <option value="train">Train</option>
                                <option value="flight">Flight</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>Travel Date: </label>
                            <input type="text" autocomplete="off" class="form-control" id="daterange"
                                                        name="dateRange" title="Travel date filter" placeholder='Travel date' />
                                <input type="hidden" name="date_from" id="date_from">
                                <input type="hidden" name="date_to" id="date_to">
                            </div>                        
                        <div class="col-md-6">
                            <div class="btn-group" data-toggle="buttons">
								<label class="d_block" for="">&nbsp;</label>
                                <label class="btn btn-default custom_active active"><input type="radio" name="filter"
                                        value="all" checked="checked" id="all" />All</label>
                                <label class="btn btn-default custom_active"><input type="radio" name="filter"
                                        value="upcomming" id="upcomming" />Upcomming</label>

                                <label class="btn btn-default custom_active"><input type="radio" name="filter"
                                        value="past" id="past" />Past</label>

                                <label class="btn btn-default custom_active"><input type="radio" name="filter"
                                        value="approved" id="approved" />Approved</label>
                                <label class="btn btn-default custom_active"><input type="radio" name="filter"
                                        value="cancel" id="cancel" />Cancel</label>

                                <label class="btn btn-default custom_active"><input type="radio" name="filter"
                                        value="pending" id="pending" />Pending</label>

                                <!--label class="btn btn-default custom_active"><input type="radio" name="filter" value="pending_gm" id="pending_gm" />Pending GM</label-->

                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="filter_val" id="filter_val" value="all">
                </form>
                <!--End filter section-->
            </div>
            <div class="portlet-body">
                <div class="table-responsive custom_card">
                    <table id="vehicles_booking" class="table table-striped display">
                        <thead>
                            <tr>
                                <th> # </th>
                                <th> Booking ID </th>
                                <th> Itinerary ID </th>
                                <th> Customer Name </th>
                                <th> Booking Type </th>
                                <th> Booking Date </th>
                                <th> Booking Status </th>
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
jQuery(document).ready(function($) {
    $(document).on("click", ".ajax_delete_booking", function() {
        var id = $(this).attr("data-id");
        if (confirm("Are you sure?")) {
            $.ajax({
                url: "<?php echo base_url(); ?>" + "AjaxRequest/ajax_delete_veh_booking?id=" +
                    id,
                type: "GET",
                data: id,
                dataType: 'json',
                cache: false,
                success: function(r) {
                    if (r.status = true) {
                        location.reload();
                        console.log("ok")
                    } else {
                        alert("Error! Please try again.");
                    }
                },
            });
        }
    });
});
jQuery(document).ready(function($) {
    $(document).on("click", ".ajax_booking_status", function() {
        var iti_id = $(this).attr("data-id");
        $.ajax({
            url: "<?php echo base_url(); ?>" + "AjaxRequest/cab_booking_status",
            type: "POST",
            data: {
                id: iti_id
            },
            dataType: "json",
            cache: false,
            beforeSend: function() {
                /*console.log("Please wait.......");*/
            },
            success: function(r) {
                if (r.status = true) {
                    $("#myModal").html(
                            '<div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal">Close</button><h4 class="modal-title"> ' +
                            r.s + ' </h4></div><div class="modal-body"> <p>' + r.data +
                            '</p></div><div class="modal-footer"></div></div></div>')
                        .fadeIn();
                    //console.log("ok" + r.data);
                } else {
                    console.log("Error.......");
                }
            },
            error: function() {
                console.log("error");
            }
        });
    });
    jQuery(document).on("click", ".close", function() {
        jQuery("#myModal").fadeOut();
    });
});
</script>
<script type="text/javascript">
var table;
$(document).ready(function() {
    $("#daterange").daterangepicker({
        locale: {
            format: 'YYYY-MM-DD'
        },
        showDropdowns: true,
        minDate: new Date(2016, 10 - 1, 25),
        //singleDatePicker: true,
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Tomorrow': [moment().add(1, 'days'), moment().add(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'Next 30 Days': [moment(), moment().add(30, 'days')],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month')
                .endOf('month')
            ],
            'Last Three Month': [moment().subtract(3, 'month').startOf('month'), moment().subtract(1,
                'month').endOf('month')],
        },
        autoUpdateInput: false,            
    },
    function(start, end, label) {
        $('#daterange').val(start.format('D MMMM, YYYY') + ' to ' + end.format('D MMMM, YYYY'));
        //$('#daterange').val(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        $("#date_from").val(start.format('YYYY-MM-DD'));
        $("#date_to").val(end.format('YYYY-MM-DD'));            
        table.ajax.reload(null,true); 
    });
    //Custom Filter
    //$(document).on("change", 'input[name=filter]:radio', function() {
    $(document).on("click", '.custom_active', function() {
        var filter_val = $(this).find("input[name=filter]").val();
        $("#filter_val").val(filter_val);
        table.ajax.reload(null, true);
    });
    //datatables
    table = $('#vehicles_booking').DataTable({
        "aLengthMenu": [
            [10, 25, 50, 100, -1],
            [10, 25, 50, 100, 'All']
        ],
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
        language: {
            search: "<strong>Search By Itinerary ID:</strong>",
            searchPlaceholder: "Search..."
        },
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('vehiclesbooking/ajax_all_vehiclesbooking_list')?>",
            "type": "POST",
            "data": function(data) {
                data.filter = $("#filter_val").val();
                data.booking_type = $(".booking_type").val();
                data.date_from = $("#date_from").val();
   				data.date_to = $("#date_to").val();
            }
        },
        //Set column definition initialisation properties.
        "columnDefs": [{
            "targets": [0], //first column / numbering column
            "orderable": false, //set not orderable
        }, ],

    });
});
</script>

<script type="text/javascript">
/* jQuery(document).ready(function($) {
	$(document).on("click", '.update_status',function() {
		var id = $(this).find("input[type=radio]").attr("data-id");
		var status = $(this).find("input[type=radio]").val();
		
		var cnfrm = confirm("Are you sure to update booking status ? ");
		if (cnfrm !== true) {
			return false;
		}else{
			$.ajax({
				url: "<?php echo base_url(); ?>" + "AjaxRequest/update_vtf_booking_status",
				type:"GET",
				data:{id : id, status: status},
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
}); */
</script>