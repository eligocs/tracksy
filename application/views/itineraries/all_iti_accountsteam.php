<div class="page-container">
    <div class="page-content-wrapper">
        <div class="page-content">
            <!-- BEGIN SAMPLE TABLE PORTLET-->
            <?php $message = $this->session->flashdata('success'); 
		if($message){ echo '<span class="help-block help-block-success">'.$message.'</span>'; }
		?>
            <!--error message-->
            <?php $err = $this->session->flashdata('error'); 
		if($err){ echo '<span class="help-block help-block-error2 red">'.$err.'</span>';}
		?>
            <?php $sales_team_agents = get_all_sales_team_agents(); ?>
            <div class="portlet box blue" style="margin-bottom:0;">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-users"></i>
                        All Booked Itineraries
                    </div>

                </div>
            </div>
            <div class="filter-box custom_card margin-bottom-30">
                <div class="row clearfix">
                    <?php
				$hideClass = isset( $_GET["todayStatus"] ) || isset( $_GET["leadfrom"] ) ? "hideFilter" : "";
				if( isset( $_GET["todayStatus"] ) ){	
					$first_day_this_month = $_GET["todayStatus"];
					$last_day_this_month  = $_GET["todayStatus"];
				}else{
					$first_day_this_month = "";
					$last_day_this_month  = "";
				}
				?>
                    <!--start filter section-->
                    <form id="form-filter" class="bg_white flex1 form-horizontal margin_bottom_0 padding_10<?php echo $hideClass; ?>">
                        <div class="actions custom_filter">

                            <div class="row">
                                <!--Calender-->
                                <div class="col-md-3"> <strong>Filter: </strong><br>
                                    <input type="text" autocomplete="off" class="form-control" id="daterange"
                                        name="dateRange" value="" required />
                                </div>
                                <!--End-->
                                <div class="col-md-3"> <strong>ITI Type: </strong><br>
                                    <select name="iti_type" class="form-control" id="iti_type">
                                        <option value="">All</option>
                                        <option value="1">Holidays</option>
                                        <option value="2">Accommodation</option>
                                    </select>
                                </div>
                                <div class="col-md-3"><strong>&nbsp; </strong><br>

									<div class="filter_box">
										<select class="form-control" name="" id="">
											<option name="filter" value="all" id="all">All</option>
											<option name="filter" value="9" id="approved">Approved</option>
											<option name="filter" value="travel_date" id="travel_date">Travel Date</option>
											<option name="filter" value="pending_invoice" id="pending_invoice">Pending Bank Rec.</option>
										</select>
									</div>

                                    <!-- <div class="btn-group" data-toggle="buttons">
                                        <label class="btn btn-default btn-primary custom_active"><input type="radio"
                                                name="filter" value="all" id="all" />All</label>
                                        <label class="btn btn-default btn-success custom_active"><input type="radio"
                                                name="filter" value="9" id="approved" />Approved</label>

                                        <label title="Travel Date"
                                            class="btn btn-default btn-danger custom_active"><input type="radio"
                                                name="filter" value="travel_date" id="travel_date" />Travel Date</label>

                                        <label title="Pending Bank Receipt"
                                            class="btn btn-default btn-success custom_active"><input type="radio"
                                                name="filter" value="pending_invoice" id="pending_invoice" />Pending
                                            Bank Rec.</label>
                                    </div> -->


                                    <input type="hidden" name="date_from" id="date_from"
                                        data-date_from="<?php if( isset( $_GET["leadfrom"] ) ){ echo $_GET["leadfrom"] ; }  else { echo $first_day_this_month; } ?>"
                                        value="">
                                    <input type="hidden" name="date_to" id="date_to"
                                        data-date_to="<?php if( isset( $_GET["leadto"] ) ){ echo $_GET["leadto"] ; } else{ echo $last_day_this_month; }  ?>"
                                        value="">
                                    <input type="hidden" name="filter_val" id="filter_val"
                                        value="<?php if( isset( $_GET["leadStatus"] ) ){ echo $_GET["leadStatus"]; }else{ echo "";	} ?>">
                                    <input type="hidden" id="quotation"
                                        value="<?php if( isset( $_GET['quotation'] ) ){ echo "true"; }else{ echo "false"; } ?>">
                                    <input type="hidden" name="todayStatus" id="todayStatus"
                                        value="<?php if( isset( $_GET["todayStatus"] ) ){ echo $_GET["todayStatus"]; } ?>">

                                </div>
								<div class="col-md-3">
									<label class="d_block margin_bottom_0" for="">&nbsp;</label>
									<input type="submit" class="btn btn-success" value="Filter">
								</div>
                            </div>
                        </div>
                    </form>
                    <!--End filter section-->
                </div>
            </div>
            <div class="portlet-body custom_card">
                <div class="table-responsive">
                    <table id="itinerary" class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th> # </th>
                                <th> Iti ID </th>
                                <th> Type </th>
                                <th> Lead ID </th>
                                <th> Name </th>
                                <th> Contact</th>
                                <th> Package Name </th>
                                <th> Travel Date</th>
                                <th> Close Status</th>
                                <th> Voucher Status </th>
                                <th> Action </th>
                                <th> Agent </th>
                                <th> Temp. T/Date</th>
                                <th> Sent</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th> # </th>
                                <th> Iti ID </th>
                                <th> Type </th>
                                <th> Lead ID </th>
                                <th> Name </th>
                                <th> Contact</th>
                                <th> Package Name </th>
                                <th> Travel Date</th>
                                <th> Close Status</th>
                                <th> Voucher Status </th>
                                <th> Action </th>
                                <th> Agent </th>
                                <th> Temp. T/Date</th>
                                <th> Sent</th>
                            </tr>
                        </tfoot>
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

<style>
.yellow_row {
    background-color: yellow !important;
}

.hold_row {
    background-color: pink !important;
}
</style>

<script type="text/javascript">
//update iti del status
jQuery(document).ready(function($) {
    $(document).on("click", ".ajax_delete_iti", function() {
        var id = $(this).attr("data-id");
        if (confirm("Are you sure?")) {
            $.ajax({
                url: "<?php echo base_url(); ?>" + "AjaxRequest/ajax_delete_iti?id=" + id,
                type: "GET",
                data: id,
                dataType: 'json',
                cache: false,
                success: function(r) {
                    if (r.status = true) {
                        location.reload();
                        //console.log("ok" + r.msg);
                        //console.log(r.msg);
                    } else {
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
    var table;
    var tableFilter;
    //Custom Filter
    $("#form-filter").validate({
        rules: {
            filter: {
                required: true
            },
            dateRange: {
                required: true
            },
        },
    });
    $("#form-filter").submit(function(e) {
        e.preventDefault();
        table.ajax.reload(null, true);
    });

    $(document).on("change", 'input[name=filter]:radio', function() {
        var filter_val = $(this).val();
        $("#filter_val").val(filter_val);
        console.log(filter_val);
    });

    //Get all itineraries by agent 
    $(document).on("change", '#sales_user_id', function() {
        table.ajax.reload(null, true);
    });

    //datatables
    table = $('#itinerary').DataTable({
        "aLengthMenu": [
            [10, 25, 50, 100, -1],
            [10, 25, 50, 100, 'All']
        ],
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
        "createdRow": function(row, data, dataIndex) {
            //console.log( dataIndex );
            var iti_status = data.slice(-1)[0];

            if (iti_status == 'NOT PROCESS')
                $(row).addClass('yellow_row');
            else if (iti_status == 'APPROVED')
                $(row).addClass('green_row');
            else if (iti_status == 'DECLINED')
                $(row).addClass('red_row');
            if (iti_status == 'ON HOLD')
                $(row).addClass('hold_row');
        },

        language: {
            search: "<strong>Search By Itinerary Id/Customer:</strong>",
            searchPlaceholder: "Search..."
        },
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('itineraries/ajax_itinerary_list_accounts')?>",
            "type": "POST",
            "data": function(data) {
                data.filter = $("#filter_val").val();
                data.from = $("#date_from").attr("data-date_from");
                data.end = $("#date_to").attr("data-date_to");
                data.todayStatus = $("#todayStatus").val();
                data.quotation = $("#quotation").val();
                data.agent_id = $("#sales_user_id").val();
                data.iti_type = $("#iti_type").val();
            },
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
jQuery(document).ready(function($) {
    //btn toggle
    $(document).on("click", ".optionToggleBtn", function(e) {
        e.preventDefault();
        var _this = $(this);
        _this.parent().find(".optionTogglePanel").slideToggle();
    });
    var date_from = $("#date_from").attr("data-date_from");
    //console.log("date_from"+date_from);
    if (date_from != "") {
        $('#daterange').val($("#date_from").attr("data-date_from") + '-' + $("#date_to").attr("data-date_to"));
    } else {
        $('#daterange').val("");
    }

    //Date range for exportdata
    $("#date_range_export").daterangepicker({
            locale: {
                format: 'YYYY-MM-DD'
            },
            dateLimit: {
                days: 90
            },
            showDropdowns: true,
            minDate: new Date(2016, 10 - 1, 25),
            //singleDatePicker: true,
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Tomorrow': [moment().add(1, 'days'), moment().add(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Next 30 Days': [moment(), moment().add(30, 'days')],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month')
                    .endOf('month')
                ],
                'Last Three Month': [moment().subtract(3, 'month').startOf('month'), moment().subtract(1,
                    'month').endOf('month')],
                'Next Three Month': [moment().add(1, 'month').startOf('month'), moment().add(3, 'month')
                    .endOf('month')
                ]
            },
            autoUpdateInput: false,
        },
        function(start, end, label) {
            $('#date_range_export').val(start.format('D MMMM, YYYY') + ' to ' + end.format('D MMMM, YYYY'));
            //$('#daterange').val(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            $("#ex_date_from").val(start.format('YYYY-MM-DD'));
            $("#ex_date_to").val(end.format('YYYY-MM-DD'));
            $("#date_range_export").attr("data-date_from", start.format('YYYY-MM-DD'));
            $("#date_range_export").attr("data-date_to", end.format('YYYY-MM-DD'));
            console.log("A new date range was chosen: " + start.format('YYYY-MM-DD') + ' to ' + end.format(
                'YYYY-MM-DD'));
        });

    //Date range for filter
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
                ]
            },
            autoUpdateInput: false,
            // startDate: moment().startOf('month'),
            //endDate: moment().endOf('month'), 
            // startDate: $("#date_from").attr("data-date_from"),
            //endDate: $("#date_to").attr("data-date_to"),  
        },
        function(start, end, label) {
            $('#daterange').val(start.format('D MMMM, YYYY') + ' to ' + end.format('D MMMM, YYYY'));
            //$('#daterange').val(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            $("#date_from").attr("data-date_from", start.format('YYYY-MM-DD'));
            $("#date_to").attr("data-date_to", end.format('YYYY-MM-DD'));
            $("#todayStatus").val("");
            console.log("A new date range was chosen: " + start.format('YYYY-MM-DD') + ' to ' + end.format(
                'YYYY-MM-DD'));

        });

    //Show Modal if itinerary price updated for agent
    $(document).on("click", ".editPop", function() {
        $("#editModal").show();
    });
    $(document).on("click", ".close", function() {
        $(".modal").hide();
        $("#continue_package, #clone_current_iti").addClass("disabledBtn");
    });
});
</script>