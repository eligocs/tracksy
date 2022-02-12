<div class="page-container">
	<div class="page-content-wrapper">
		<div class="page-content">
		 <!-- BEGIN SAMPLE TABLE PORTLET-->
		 <div id="messageres"></div>
		<div class="portlet box blue">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-cogs"></i>View All Packages List
				</div>
				
				<a class="btn btn-success" href="<?php echo site_url("vehicles/add_veh_package"); ?>" title="add Vehicle">Add Package</a>
			</div>
			</div>
			<div class="portlet-body">
				<div class="table-responsive">
					<table id="cabs" class="table table-bordered">
						<thead>
							<tr>
								<th> # </th>
								<th> Package Name </th>
								<th> State </th>
								<th> Action </th>
							</tr>
						</thead>
						<tbody>
						<?php if( isset( $all_packages ) && !empty( $all_packages ) ){
							$counter = 1;
							foreach( $all_packages as $package ){ ?>
								<tr>
									<td><?php echo $counter; ?> .</td>
									<td><?php echo get_state_name($package->state_id); ?></td>
									<td><?php echo $package->package_name; ?></td>
									<td><a href="<?php echo base_url("vehicles/viewpackagecost/{$package->id}"); ?>"><i class="fa fa-eyes"></i> View<a></td>
								</tr>
							<?php }
						}else{ ?>
							<tr><td>No Data found</td></tr>
						<?php } ?>
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
<!-- Modal -->
<script type="text/javascript">
jQuery(document).ready(function($){
	var resp = $("#addresEd");
	$(document).on("click", ".ajax_delete_cabs", function(){
		var cab_id = $(this).attr("data-id");
		
		if (confirm("Are you sure?")) {
			$.ajax({
				url: "<?php echo base_url(); ?>" + "vehicles/ajax_deletecabpack?id=" + cab_id,
				type:"GET",
				data:cab_id,
				dataType: "json",
				cache: false,
				success: function(r){
					console.log("error");
					if(r.status = true){
						location.reload();
					  console.log("ok" + r.msg);
					}else{
						resp.html('<div class="alert alert-danger"><strong>Error! </strong>'+r.msg+'</div>');
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
    table = $('#cabs').DataTable({ 
		"aLengthMenu": [[10,25, 50, 100, -1], [10, 25, 50, 100, 'All']],
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
		language: {
			search: "<strong>Search By Vehicle Name:</strong>",
			searchPlaceholder: "Search..."
		},
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('vehicles/ajax_cab_packages_list')?>",
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
