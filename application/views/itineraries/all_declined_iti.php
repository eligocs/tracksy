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
					<i class="fa fa-users"></i>All Declined Itineraries
				</div>
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
			<div class="col-md-4">
				<?php $sales_team_agents = get_all_sales_team_agents(); ?>
				<div class="form-group">
					<label for="sales_user_id">Select Sales Team User:</label>
					<select required class="form-control" id='sales_user_id' name="user_id">
						<option value="">All Users</option>
						<?php foreach( $sales_team_agents as $user ){ ?>
							<option value="<?php echo $user->user_id; ?>"><?php echo $user->user_name . " ( " . ucfirst( $user->first_name ) . " "  . ucfirst( $user->last_name) . " )"; ?></option>
						<?php } ?>
					</select>
				 </div>
			</div>	
		
			
			<div class="marginBottom <?php echo $hideClass; ?>">
				<!--start filter section-->
				<form id="form-filter" class="form-horizontal">
					<div class="actions custom_filter pull-right form-inline">
						<strong>Filter: </strong>
						<!--Calender-->
						<input type="text" class="form-control" id="daterange" name="dateRange" value="" required />
						<!--End-->
						<input type="hidden" name="date_from" id="date_from" data-date_from="<?php if( isset( $_GET["leadfrom"] ) ){ echo $_GET["leadfrom"]; }else { echo $first_day_this_month; } ?>" value="" >
						<input type="hidden" name="date_to" id="date_to" data-date_to="<?php if( isset( $_GET["leadto"] ) ){ echo $_GET["leadto"]; }else{ echo $last_day_this_month; } ?>" value="">
						<input type="hidden" name="filter_val" id="filter_val" value="<?php if( isset( $_GET["leadStatus"] ) ){ echo $_GET["leadStatus"]; }else{ echo "7"; } ?>">
						<input type="hidden" name="todayStatus" id="todayStatus" value="<?php if( isset( $_GET["todayStatus"] ) ){ echo $_GET["todayStatus"]; } ?>">
						<input type="submit" class="btn btn-success" value="Filter">
					</div>
				</form><!--End filter section-->	
			</div> 
			
			<div class="portlet-body">
				<div class="table-responsive">
					<table id="itinerary" class="table table-bordered">
						<thead>
							<tr>
								<th> # </th>
								<th> Iti ID </th>
								<th> Iti Type </th>
								<th> Lead ID </th>
								<th> Customer Name </th>
								<th> Contact</th>
								<th> Package Name </th>
								<th> Iti Created</th>
								<th> Agent </th>
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
<script type="text/javascript">
jQuery(document).ready(function($){
	var date_from = $("#date_from").attr("data-date_from");
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
		showDropdowns: true,
		minDate: new Date(2016, 10 - 1, 25),
		//singleDatePicker: true,
		ranges: {
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
	},
	function(start, end, label) {
		$('#daterange').val( start.format('D MMMM, YYYY') + ' to ' +  end.format('D MMMM, YYYY'));
		$("#date_from").attr( "data-date_from", start.format('YYYY-MM-DD') );
		$("#date_to").attr( "data-date_to", end.format('YYYY-MM-DD') );
		$("#todayStatus").val("");
		console.log("A new date range was chosen: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
	});
});
</script>
<script type="text/javascript">
var table;
$(document).ready(function() {
	
		//Get all itineraries by agent 
		$(document).on("change", '#sales_user_id', function() {
			table.ajax.reload(null,true);
		});
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
		
	var table;
	var tableFilter;
	//datatables
	table = $('#itinerary').DataTable({ 
		"aLengthMenu": [[10,25, 50, 100, -1], [10, 25, 50, 100, 'All']],
		"processing": true, //Feature control the processing indicator.
		"serverSide": true, //Feature control DataTables' server-side processing mode.
		"order": [], //Initial no order.
		language: {
			search: "<strong>Search By Itinerary/Customer ID:</strong>",
			searchPlaceholder: "Search..."
		},
		// Load data for the table's content from an Ajax source
		"ajax": {
			"url": "<?php echo site_url('itineraries/ajax_declined_itinerary_list')?>",
			"type": "POST",
			"data": function ( data ) {
				data.filter = $("#filter_val").val();
				data.from = $("#date_from").attr("data-date_from");
				data.end = $("#date_to").attr("data-date_to");
				data.todayStatus = $("#todayStatus").val();
				data.agent_id = $("#sales_user_id").val();
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