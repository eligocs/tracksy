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
						<i class="fa fa-users"></i>All Confirmed Vouchers
					</div>
				</div>
			</div>
			<div class="clearfix"></div>			
			<div class="clearfix"></div> 				
			<div class="portlet-body second_custom_card">
				<div class="table-responsive">
					<table id="table_vouchers" class="table table-striped display">
						<thead>
							<tr>
								<th> # </th>
								<th> V.id </th>
								<th> Iti ID </th>
								<th> Type </th>
								<th> Name </th>
								<th> Contact </th>
								<th> Email </th>
								<th> Package Name </th>
								<th> Travel Date </th>
								<th> Agent </th>
								<th> Action </th>
							</tr>
						</thead>
						<tbody>
						<div id="res"></div>
							<!--DataTable Goes here-->
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
	$(document).on("click",".ajax_iti_status", function(){
		var iti_id = $(this).attr("data-id");
		$.ajax({
			url: "<?php echo base_url(); ?>" + "AjaxRequest/iti_status_popup",
			type:"POST",
			data:{ iti_id: iti_id },
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
//update iti del status
jQuery(document).ready(function($){
	$(document).on("click", ".ajax_delete_voucher", function(){
		var id = $(this).attr("data-id");
		if (confirm("Are you sure?")) {
			$.ajax({
				url: "<?php echo base_url(); ?>" + "AjaxRequest/ajax_delete_voucher?id=" + id,
				type:"GET",
				data:id,
				dataType: 'json',
				cache: false,
				success: function(r){
					if(r.status = true){
						location.reload();
					  //console.log("ok" + r.msg);
						//console.log(r.msg);
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
	//Custom Filter
	$(document).on("change", 'input[name=filter]:radio', function() {
		var filter_val = $(this).val();
		$("#filter_val").val( filter_val );
		table.ajax.reload(null,true); 
	});
	//datatables
    table = $('#table_vouchers').DataTable({ 
		"aLengthMenu": [[10,25, 50, 100, -1], [10, 25, 50, 100, 'All']],
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
		language: {
			search: "<strong>Search By Customer Name/Iti ID:</strong>",
			searchPlaceholder: "Search..."
		},
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('vouchers/ajax_voucher_list')?>",
            "type": "POST",
			"data": function ( data ) {
				data.filter = $("#filter_val").val();
			} 
			/* beforeSend: function(){
				console.log("Please wait...");
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