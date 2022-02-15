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
                        <i class="fa fa-users"></i>All Packages Category
                    </div>
                    <a class="btn btn-success" href="<?php echo site_url("packages/addcat"); ?>" title="add hotel">Add
                        Package Category</a>
                </div>
            </div>
            <div class="portlet-body second_custom_card">
                <div class="table-responsive margin-top-15">
                    <table id="packageslist" class="table table-striped display">
                        <thead>
                            <tr>
                                <th> # </th>
                                <th> Package Category</th>
                                <th> Added date</th>
                                <th> Action </th>
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
<div id="myModal" class="modal" role="dialog"></div>
<!-- Modal -->
<script type="text/javascript">
//update package del status
jQuery(document).ready(function($) {
    $(document).on("click", ".ajax_delete_package_cat", function() {
        var id = $(this).attr("data-id");
        if (confirm("Are you sure?")) {
            $.ajax({
                url: "<?php echo base_url(); ?>" +
                    "packages/update_del_status_package_cat?id=" + id,
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
    //datatables
    table = $('#packageslist').DataTable({
        "aLengthMenu": [
            [10, 25, 50, 100, -1],
            [10, 25, 50, 100, 'All']
        ],
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
        language: {
            search: "<strong>Search By Package Id/Package Category Name:</strong>",
            searchPlaceholder: "Search..."
        },
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('packages/ajax_packages_cat_list')?>",
            "type": "POST",
        },
        //Set column definition initialisation properties.
        "columnDefs": [{
            "targets": [0], //first column / numbering column
            "orderable": false, //set not orderable
        }, ],

    });

});
</script>