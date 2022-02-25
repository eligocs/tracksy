<?php $todAy = date("Y-m-d"); ?>
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
                        <?php if( $user_role == 97 ){
                     echo "All Booked Itineraries";
                     }else{
                     echo "All Itineraries";
                     }	?>
                    </div>
                    <?php if( $user_role != 97 ){ ?>
                    <a class="btn btn-success" href="<?php echo site_url("customers"); ?>" title="add Itineraries">Add
                        Itinerary</a>
                    <?php } ?>
                </div>
            </div>
            
            <div class="portlet-body custom_card">
                <?php if( is_admin_or_manager() ){ ?>
                <div class="row clearfix">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="sales_user_id">Select Sales Team User:</label>
                            <select required class="form-control select_user" id='sales_user_id' name="user_id">
                                <option value="">All Users</option>
                                <?php foreach( $sales_team_agents as $user ){ ?>
                                <option value="<?php echo $user->user_id; ?>">
                                    <?php echo $user->user_name . " ( " . ucfirst( $user->first_name ) . " "  . ucfirst( $user->last_name) . " )"; ?>
                                </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <!--export button for admin and manager-->
                    
                    <a href="<?php echo site_url("itineraries"). "/?todayStatus={$todAy}&leadStatus=Qsent&quotation=true"; ?>"
                        class="btn btn-success pull-right"><i class="fa fa-envelope"></i> Today Sent Quotation</a>
                    <a href="<?php echo site_url("itineraries"). "/?todayStatus={$todAy}&leadStatus=QsentPast&quotation=true"; ?>"
                        class="btn btn-info pull-right"><i class="fa fa-envelope"></i> Today Revised Quotation Sent</a>
                </div>
                <?php }else if( is_teamleader() ){
				$team_members = is_teamleader(); ?>
                <div class="row clearfix">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="sales_user_id">Select Team Member:</label>
                            <select required class="form-control select_user" id='sales_user_id' name="user_id">
                                <option value="">All Teammembers</option>
                                <?php echo "<option value={$user_id}>Myself</option>"; ?>
                                <?php if( $team_members ){
							foreach( $team_members as $mem ){
								$user_n = get_user_name($mem);
								echo "<option value={$mem}>{$user_n}</option>";
							}
							} ?>
                            </select>
                        </div>
                    </div>
                </div>
                <?php } ?>
                <div class="table-responsive">
                    <table id="itinerary" class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th> # </th>
                                <th> Iti ID </th>
                                <th> Type </th>
                                <th> Lead ID </th>
                                <th> Customer Name </th>
                                <th> Contact</th>
                                <th> Package Name </th>
                                <th> Temp. T/Date</th>
                                <th> Travel Date</th>
                                <th> Action </th>
                                <th> Sent Status</th>
                                <th> Publish Status</th>
                                <?php //if( $user_role != 96 ){ ?>
                                <th> Agent </th>
                                <?php //} ?>
                                <th> Iti status </th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th> # </th>
                                <th> Iti ID </th>
                                <th> Type </th>
                                <th> Lead ID </th>
                                <th> Customer Name </th>
                                <th> Contact</th>
                                <th> Package Name </th>
                                <th> Temp. T/Date</th>
                                <th> Travel Date</th>
                                <th> Publish Status</th>
                                <th> Action </th>
                                <th> Sent Status</th>
                                <?php //if( $user_role != 96 ){ ?>
                                <th> Agent </th>
                                <?php //} ?>
                                <th> Iti status </th>
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
/* .yellow_row {
    background-color: yellow !important;
} */

.hold_row {
    background-color: pink !important;
}
</style>

<div id="myModal" class="modal" role="dialog"></div>
<style>
#editModal,
#duplicatePakcageModal {
    top: 20%;
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
    //delete permanently Draft Itineraries
    $(document).on("click", ".delete_iti_permanent", function() {
        var id = $(this).attr("data-id");
        if (confirm("Are you sure?")) {
            $.ajax({
                url: "<?php echo base_url(); ?>" + "itineraries/delete_iti_permanently?id=" +
                    id,
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
            "url": "<?php echo site_url('itineraries/ajax_itinerary_list')?>",
            "type": "POST",
            "data": function(data) {
                data.filter = $("#filter_val").val();
                data.from = $("#date_from").attr("data-date_from");
                data.end = $("#date_to").attr("data-date_to");
                data.todayStatus = $("#todayStatus").val();
                data.quotation = $("#quotation").val();
                data.agent_id = $("#sales_user_id").val();
                data.iti_type = $("#iti_type").val();
                data.confirmiti = true;
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