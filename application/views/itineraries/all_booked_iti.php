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
                        <i class="fa fa-users"></i>All Booked Itineraries
                    </div>
                    <?php 
                  $rev_link 	= $this->config->item('google_review_link');
                  if( !empty( $rev_link ) ){
                  ?>
                    <div class="pull-right">
                        <button class="btn btn-success margin_top_4" onclick="copy_rev_link()">Copy Review Link</button>
                        <strong id="altPassTemp" class='hide'><?php echo $rev_link; ?></strong>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <?php
            //Hide filter
            $hideClass = isset( $_GET["todayStatus"] ) || isset( $_GET["leadfrom"] ) ? "hideFilter" : "";
            if( isset( $_GET["todayStatus"] ) ){	
            	$first_day_this_month = $_GET["todayStatus"]; 
            	$last_day_this_month  = $_GET["todayStatus"];
            }else{
            	$first_day_this_month = ""; 
            	$last_day_this_month  = "";
            }
            ?>
            <!--sort by agent -->
            <div class="row margin-bottom-25 second_custom_card">
                <?php if( $user_role == 99 || $user_role == 98 ){ ?>
                <div class="col-md-2">
                    <?php $sales_team_agents = get_all_sales_team_agents(); ?>
                    <div class="form-group">
                        <label for="sales_user_id">Select Sales Team User:</label>
                        <select required class="form-control" id='sales_user_id' name="user_id">
                            <option value="">All Users</option>
                            <?php foreach( $sales_team_agents as $user ){ ?>
                            <option value="<?php echo $user->user_id; ?>">
                                <?php echo $user->user_name . " ( " . ucfirst( $user->first_name ) . " "  . ucfirst( $user->last_name) . " )"; ?>
                            </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <?php } ?>
                <!--start filter section-->
                <form id="form-filter" class="form-horizontal bg_white padding_zero">
                    <div class="marginBottom <?php echo $hideClass; ?> col-md-3">
                        <div class="actions custom_filter pull-left">
                            <label>Filter: </label>
                            <!--Calender-->
                            <input type="text" autocomplete="off" class="form-control d_block" id="daterange"
                                name="dateRange" value="" required />


                            <!-- <div class="btn-group" data-toggle="buttons">
                                <label class="btn btn-default btn-primary custom_active">
									<input type="radio" name="filter" value="9" id="all" />All</label>
                                <label class="btn btn-default btn-success custom_active"><input type="radio"
                                        name="filter" value="9" id="approved" />Booking Date</label>
                                <label title="Travel Date" class="btn btn-default btn-danger custom_active"><input
                                        type="radio" name="filter" value="travel_date" id="travel_date" />Travel
                                    Date</label>
                                <label title="Travel Date" class="btn btn-default btn-danger custom_active"><input
                                        type="radio" name="filter" value="travel_end_date"
                                        id="travel_end_date" />Checkout</label>
                            </div> -->
                            <!--End-->
                            <input type="hidden" name="date_from" id="date_from"
                                data-date_from="<?php if( isset( $_GET["leadfrom"] ) ){ echo $_GET["leadfrom"]; }else { echo $first_day_this_month; } ?>"
                                value="">
                            <input type="hidden" name="date_to" id="date_to"
                                data-date_to="<?php if( isset( $_GET["leadto"] ) ){ echo $_GET["leadto"]; }else{ echo $last_day_this_month; } ?>"
                                value="">
                            <input type="hidden" name="filter_val" id="filter_val"
                                value="<?php if( isset( $_GET["leadStatus"] ) ){ echo $_GET["leadStatus"]; }else{ echo "9"; } ?>">
                            <input type="hidden" name="todayStatus" id="todayStatus"
                                value="<?php if( isset( $_GET["todayStatus"] ) ){ echo $_GET["todayStatus"]; } ?>">

                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="filter_box">
                            <label for="">&nbsp;</label>
                            <select class="form-control" name="filter" id="">
                                <option name="filter" value="9" id="all">All</option>
                                <option name="filter" value="9" id="approved">Approved</option>
                                <option name="filter" value="travel_date" id="travel_date">Travel Date</option>
                                <option name="filter" value="travel_end_date" id="travel_end_date">Checkout</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="" class="d_block">&nbsp;</label>
                        <input type="submit" class="btn btn-success" value="Filter">
                        <?php if( $user_role == 99 || $user_role == 98 ){ ?>
                                <a href="<?php echo base_url("export/export_itinerary_fiter_data");?>"
                                    class="btn btn-danger pull-right export_btn"><i class="fa fa-file-excel"></i>
                                    Export</a>
                        <?php } ?>
                    </div>
                </form>
                <!--End filter section-->
                <!-- <?php// if( $user_role == 99 || $user_role == 98 ){ ?>
                <div class="col-md-2">
                    <div class="form-group">
                        <a href="<?php// echo base_url("export/export_itinerary_fiter_data");?>"
                            class="btn btn-danger pull-right export_btn"><i class="fa fa-file-excel"></i> Export</a>
                    </div>
                </div>
                <?php// } ?> -->
            </div>
            <div class="clearfix"></div>
            <div class="spinner_load" style="display: none;">
                <i class="fa fa-refresh fa-spin fa-3x fa-fw"></i>
                <span class="sr-only">Loading...</span>
            </div>
            <!--export button for admin and manager-->
            <div class="portlet-body">
                <div class="table-responsive custom_card">
                    <table id="itinerary" class="table table-striped display">
                        <thead>
                            <tr>
                                <th> # </th>
                                <th> Iti ID </th>
                                <th> Iti Type </th>
                                <th> Lead ID </th>
                                <th> Name </th>
                                <th> Final Cost</th>
                                <th> Ad. Received</th>
                                <th> Tra. Date</th>
                                <th> Checkout </th>
                                <th> Action </th>
                                <th> Review Request </th>
                                <th> Booking Date</th>
                                <th> Agent </th>
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
jQuery(document).ready(function($) {
    //SENT GOOGLE REVIEW LINK TO CUSTOMER
    $(document).on("click", '.sendReview_req', function(e) {
        e.preventDefault();
        var _this = $(this);
        var cus_id = _this.attr("data-cusid");
        if (confirm("Are you sure to send review request to customer ?")) {
            $(".spinner_load").show();
            $.ajax({
                url: "<?php echo base_url(); ?>" +
                    "customers/update_review_status?customer_id=" + cus_id,
                type: "GET",
                data: cus_id,
                dataType: 'json',
                cache: false,
                success: function(r) {
                    $(".spinner_load").hide();
                    if (r.status = true) {
                        alert("Request sent successfully. ");
                        _this.removeClass("sendReview_req").html(
                            "<i class='fa fa-check-circle-o'></i> Sent");
                        //location.reload();
                    } else {
                        alert("Error! Please try again.");
                    }
                }
            });

        }
    });


    $(document).on("change", 'input[name=filter]:radio', function() {
        var filter_val = $(this).val();
        $("#filter_val").val(filter_val);
        console.log(filter_val);
    });

    //Export Data filter
    $(document).on("click", ".export_btn", function(e) {
        e.preventDefault();
        //get filtered perameters
        var filter = $("#filter_val").val(),
            d_from = $("#date_from").attr("data-date_from"),
            end = $("#date_to").attr("data-date_to"),
            todayStatus = $("#todayStatus").val(),
            //quotation 	= $("#quotation").val(),
            agent_id = $("#sales_user_id").val();

        var export_url = "<?php echo base_url('export/export_itinerary_fiter_data?filter='); ?>" +
            filter + "&d_from=" + d_from + "&end=" + end + "&todayStatus=" + todayStatus +
            "&agent_id=" + agent_id;
        //redirect to export
        if (confirm("Are you sure to export data ?")) {
            window.location.href = export_url;
        }
    });

    //calendar
    var date_from = $("#date_from").attr("data-date_from");
    if (date_from != "") {
        $('#daterange').val($("#date_from").attr("data-date_from") + '-' + $("#date_to").attr("data-date_to"));
    } else {
        $('#daterange').val("");
    }
    //Date range
    $("#daterange").daterangepicker({
            locale: {
                format: 'YYYY-MM-DD'
            },
            autoUpdateInput: false,
            showDropdowns: true,
            minDate: new Date(2016, 10 - 1, 25),
            //singleDatePicker: true,
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month')
                    .endOf('month')
                ]
            },
        },
        function(start, end, label) {
            $('#daterange').val(start.format('D MMMM, YYYY') + ' to ' + end.format('D MMMM, YYYY'));
            $("#date_from").attr("data-date_from", start.format('YYYY-MM-DD'));
            $("#date_to").attr("data-date_to", end.format('YYYY-MM-DD'));
            $("#todayStatus").val("");
            console.log("A new date range was chosen: " + start.format('YYYY-MM-DD') + ' to ' + end.format(
                'YYYY-MM-DD'));
        });
});
</script>
<script type="text/javascript">
var table;
$(document).ready(function() {

    //Get all itineraries by agent 
    $(document).on("change", '#sales_user_id', function() {
        table.ajax.reload(null, true);
    });
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

    var table;
    var tableFilter;
    //datatables
    table = $('#itinerary').DataTable({
        "aLengthMenu": [
            [10, 25, 50, 100, -1],
            [10, 25, 50, 100, 'All']
        ],
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
        language: {
            search: "<strong>Search By Itinerary/Customer ID:</strong>",
            searchPlaceholder: "Search..."
        },
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('itineraries/ajax_bookeditineraries_list')?>",
            "type": "POST",
            "data": function(data) {
                data.filter = $("#filter_val").val();
                data.from = $("#date_from").attr("data-date_from");
                data.end = $("#date_to").attr("data-date_to");
                data.todayStatus = $("#todayStatus").val();
                data.agent_id = $("#sales_user_id").val();
            },
        },
        //Set column definition initialisation properties.
        "columnDefs": [{
            "targets": [0], //first column / numbering column
            "orderable": false, //set not orderable
        }, ],

    });
});
//copy review link
function copy_rev_link() {
    /* Get the text field */
    var element = document.getElementById("altPassTemp");
    /* Alert the copied text */
    var $temp = $("<input>");
    $("body").append($temp);
    $temp.val($(element).text()).select();
    var copyText = document.execCommand("copy");
    //alert("Review Link Copied: " + $(element).text() );
    swal("Copied!", "The link to Review has been copied to clipboard!.", "success");

    $temp.remove();
}
</script>