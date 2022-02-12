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
					<i class="fa fa-users"></i>
					<?php if( $user_role == 97 ){
						echo "All Booked Accommodation";
					}else{
						echo "All Accommodation Packages";
					}	?>
				</div>
				<?php if( $user_role != 97 ){ ?>
					<a class="btn btn-success" href="<?php echo site_url("accommodation/add"); ?>" title="add hotel">Add Package</a>
				<?php } ?>	
			</div>
		</div>	
			<div class="row marginBottom">
				<?php
					if( isset( $_GET["todayStatus"] ) ){	
						$first_day_this_month = $_GET["todayStatus"]; 
						$last_day_this_month  = $_GET["todayStatus"];
					}else{
						$first_day_this_month = ""; 
						$last_day_this_month  = "";
					}
				?>
				<?php if( $user_role == 97 ){ ?>
					<!--start filter section-->
					<form id="form-filter" class="form-horizontal marginRight">
						<div class="actions custom_filter pull-right">
							<strong>Filter: </strong>
							
							<!--Calender-->
							<input type="text" class="" id="daterange" name="dateRange" value="" required />
							<!--End-->
							<div class="btn-group" data-toggle="buttons">
								<label class="btn btn-default custom_active"><input type="radio" name="filter" value="all" id="all"/>All</label>
								<label class="btn btn-default custom_active"><input type="radio" name="filter" value="9" id="approved" />Approved</label>
							</div>	
							<input type="hidden" name="date_from" id="date_from" data-date_from="<?php if( isset( $_GET["leadfrom"] ) ){ echo $_GET["leadfrom"] ; }  else { echo $first_day_this_month; } ?>" value="" >
							<input type="hidden" name="date_to" id="date_to" data-date_to="<?php if( isset( $_GET["leadto"] ) ){ echo $_GET["leadto"] ; } else{ echo $last_day_this_month; }  ?>" value="">
							<input type="hidden" name="filter_val" id="filter_val" value="<?php if( isset( $_GET["leadStatus"] ) ){ echo $_GET["leadStatus"]; }else{ echo "all";	} ?> ">
							<input type="hidden" id="quotation" value="<?php if( isset( $_GET['quotation'] ) ){ echo "true"; }else{ echo "false"; } ?>">
							
							<input type="hidden" name="todayStatus" id="todayStatus" value="<?php if( isset( $_GET["todayStatus"] ) ){ echo $_GET["todayStatus"]; } ?>">
							<input type="submit" class="btn btn-success" value="Filter">
						</div>
					</form><!--End filter section-->	
				<?php }else{ ?>	
					<!--start filter section-->
					<form id="form-filter" class="form-horizontal marginRight">
						<div class="actions custom_filter pull-right">
							<strong>Filter: </strong>
							<!--Calender-->
							<input type="text" class="" id="daterange" name="dateRange" value="" required />
							<!--End-->
							<div class="btn-group" data-toggle="buttons">
								<label class="btn btn-default custom_active"><input type="radio" name="filter" value="all" id="all"/>All</label>
								<label class="btn btn-default custom_active"><input type="radio" name="filter" value="draft" id="declined" />Draft</label>
								<label class="btn btn-default custom_active"><input type="radio" name="filter" value="pending" id="pending" />Working</label>
								<label class="btn btn-default custom_active"><input type="radio" name="filter" value="7" id="declined" />Declined</label>
								<label class="btn btn-default custom_active"><input type="radio" name="filter" value="9" id="approved" />Approved</label>
							</div>	
							<input type="hidden" name="date_from" id="date_from" data-date_from="<?php if( isset( $_GET["leadfrom"] ) ){ echo $_GET["leadfrom"] ; }  else { echo $first_day_this_month; } ?>" value="" >
							<input type="hidden" name="date_to" id="date_to" data-date_to="<?php if( isset( $_GET["leadto"] ) ){ echo $_GET["leadto"]; } else{ echo $last_day_this_month; }  ?>" value="">
							<input type="hidden" name="filter_val" id="filter_val" value="<?php if( isset( $_GET["leadStatus"] ) ){ echo $_GET["leadStatus"]; }else{ echo "all";	} ?> ">
							<input type="hidden" id="quotation" value="<?php if( isset( $_GET['quotation'] ) ){ echo "true"; }else{ echo "false";} ?>">
							<input type="hidden" name="todayStatus" id="todayStatus" value="<?php if( isset( $_GET["todayStatus"] ) ){ echo $_GET["todayStatus"]; } ?>">
							<input type="submit" class="btn btn-success" value="Filter">
						</div>
					</form><!--End filter section-->	
				<?php } ?>	
			</div> 
			
			<div class="portlet-body">
				<div class="table-responsive">
					<table id="itinerary" class="table table-bordered">
						<thead>
							<tr>
								<th> # </th>
								<th> Acc ID </th>
								<th> Lead ID </th>
								<th> Customer Name </th>
								<th> Contact</th>
								<th> Package Name </th>
								<th> Publish Status</th>
								<th> Action </th>
								<th> Created</th>
								<th> Sent Status</th>
								<?php if( $user_role != 96 ){ ?>
									<th> Agent </th>
								<?php } ?>
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
<style>#editModal, #duplicatePakcageModal{top: 20%; }</style>
<!-- Modal Edit Accommodation -->
<div id="editModal" class="modal" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close editPopClose" data-dismiss="modal">Close</button>
				<h4 class="modal-title">Permission denied</h4>
			</div>
			<div class="modal-body"> 
				Please contact to Manager or Administrator to edit Accommodation. Or Duplicate the Accommodation for revised quotation.
			</div>
			<div class="modal-footer"></div>
		</div>
	</div>
</div>
<script type="text/javascript">
jQuery(document).ready(function($){
	$(document).on("click",".ajax_iti_status", function(){
		var acc_id = $(this).attr("data-id");
		var temp_key = $(this).attr("data-key");
		$.ajax({
			url: "<?php echo base_url(); ?>" + "accommodation/update_comment_status",
			type:"POST",
			data:{ acc_id: acc_id },
			dataType: "json",
			cache: false,
			beforeSend: function(){
				$(".loader").show();
				/* console.log("Please wait......."); */
			},
			success: function(r){
				$(".loader").hide();
				if(r.status = true){
					window.location.href = "<?php echo site_url('accommodation/view/');?>" + acc_id + "/" + temp_key + "#comments"; 
				}else{
					$(".loader").hide();
					alert("error");
					console.log("Error.......");
					
				}
			},
			error: function(){
				$(".loader").hide();
				alert("error");
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
	$(document).on("click", ".ajax_delete_iti", function(){
		var id = $(this).attr("data-id");
		if (confirm("Are you sure?")) {
			$.ajax({
				url: "<?php echo base_url(); ?>" + "accommodation/ajax_update_delete_status?id=" + id,
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
	//delete permanently Draft Accommodation
	$(document).on("click", ".delete_iti_permanent", function(){
		var id = $(this).attr("data-id");
		if (confirm("Are you sure?")) {
			$.ajax({
				url: "<?php echo base_url(); ?>" + "accommodation/delete_acc_permanently?id=" + id,
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
	var table;
	var tableFilter;
	//Custom Filter
	$("#form-filter").validate({
		rules: {
			filter: {required: true},
			dateRange: {required: true},
		},
	});
	$("#form-filter").submit(function(e){
		e.preventDefault();
		table.ajax.reload(null,true);
	});
	
	$(document).on("change", 'input[name=filter]:radio', function() {
		var filter_val = $(this).val();
		$("#filter_val").val( filter_val );
		console.log(filter_val);
	});
	
	//datatables
	table = $('#itinerary').DataTable({ 
		"aLengthMenu": [[10,25, 50, 100, -1], [10, 25, 50, 100, 'All']],
		"processing": true, //Feature control the processing indicator.
		"serverSide": true, //Feature control DataTables' server-side processing mode.
		"order": [], //Initial no order.
		language: {
			search: "<strong>Search By Accommodation/Customer ID:</strong>",
			searchPlaceholder: "Search..."
		},
		// Load data for the table's content from an Ajax source
		"ajax": {
			"url": "<?php echo site_url('accommodation/ajax_accommodation_list')?>",
			"type": "POST",
			"data": function ( data ) {
				data.filter = $("#filter_val").val();
				data.from = $("#date_from").attr("data-date_from");
				data.end = $("#date_to").attr("data-date_to");
				data.todayStatus = $("#todayStatus").val();
				data.quotation = $("#quotation").val();
			},
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
<script type="text/javascript">
jQuery(document).ready(function($){
	//btn toggle
	$(document).on("click", ".optionToggleBtn", function(e){
		e.preventDefault();
		var _this = $(this);
		_this.parent().find(".optionTogglePanel").slideToggle();
	});
	var date_from = $("#date_from").attr("data-date_from");
	console.log("date_from"+date_from);
	if( date_from != "" ){
		$('#daterange').val( $("#date_from").attr("data-date_from") + '-' +  $("#date_to").attr("data-date_to")  );
	}else{
		$('#daterange').val("");
	}	
	//Date range
	$("#daterange").daterangepicker({
		locale: {
		  format: 'YYYY-MM-DD'
		},
		autoUpdateInput: false,
		/* startDate: moment().startOf('month'),
		endDate: moment().endOf('month'), */
		/* startDate: $("#date_from").attr("data-date_from"),
		endDate: $("#date_to").attr("data-date_to"),  */
	}, 
	function(start, end, label) {
		$('#daterange').val( start.format('YYYY-MM-DD') + '-' +  end.format('YYYY-MM-DD')  );
		$("#date_from").attr( "data-date_from", start.format('YYYY-MM-DD') );
		$("#date_to").attr( "data-date_to", end.format('YYYY-MM-DD') );
		$("#todayStatus").val("");
		console.log("A new date range was chosen: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
	});
	
	//Show Modal if Accommodation price updated for agent
	$(document).on("click",".editPop",function(){
		$("#editModal").show();
	});
	$(document).on("click",".close",function(){
		$(".modal").hide();
		$("#continue_package").addClass("disabledBtn");
	});
});
</script>