<div class="page-container">
	<div class="page-content-wrapper">
		<div class="page-content">
		<!-- BEGIN SAMPLE TABLE PORTLET-->
		<?php $message = $this->session->flashdata('success'); 
		if($message){ echo '<span class="help-block help-block-success">'.$message.'</span>';}
		?>
		<?php
			if( isset( $_GET["todayStatus"] ) ){	
				$todayStatus = $_GET["todayStatus"];
				$first_day_this_month = $todayStatus; 
				$last_day_this_month  = $todayStatus;
				$hideClass = "hideFilter";
			}else{
				$todayStatus = "";
				$first_day_this_month = ""; 
				$last_day_this_month  = "";
				$hideClass = "";
			}
		?>
		<div class="portlet box blue" style="margin-bottom:0;">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-users"></i>All Payments
				</div>
			</div>
		</div>	
		
			<div class=" ">
				<!--start filter section-->
				<form id="form-filter" class="form-horizontal <?php echo $hideClass; ?>">
					<div class="actions custom_filter">
						<div class="col-sm-3">
							<div class="row">
							<div class="col-sm-2">
								<strong>Filter: </strong>
							</div>	
							<div class="col-sm-10">
							<!--Calender-->
							<input type="text" class="form-control" id="daterange" autocomplete="off" name="dateRange" value="" required />
							</div>
							<!--End-->
							</div>
						</div>
						
						<div class="col-sm-8">
							<div class="btn-group btn-group-justified" data-toggle="buttons">
								<label class="btn btn-primary custom_active"><input type="radio" name="filter" value="all" id="all"/>All</label>
								<label class="btn btn-success custom_active"><input type="radio" name="filter" value="pending" id="pending" />Pending</label>
								<label class="btn btn-primary purple custom_active"><input type="radio" name="filter" value="pay_received" id="received" />Received</label>
								<label class="btn btn-danger custom_active"><input type="radio" name="filter" value="complete" id="complete" />Complete</label>
								<label class="btn btn-blue custom_active"><input type="radio" name="filter" value="refund" id="refund" />Refund</label>
								<label title="Travel Date" class="btn btn-default btn-danger custom_active"><input type="radio" name="filter" value="travel_date" id="travel_date" />TD</label>
								<label title="Closed Itineraris" class="btn btn-default btn-danger custom_active"><input type="radio" name="filter" value="pm_ci" id="pm_ci" />Closed</label>
								<label title="Open Itineraris" class="btn btn-success  purple custom_active"><input type="radio" name="filter" value="pm_oi" id="pm_oi" />Open</label>
								<label class="btn btn-danger custom_active" title="Pending payment confirmation" ><input type="radio" name="filter" title="Pending Payment Confirmation" value="pending_confirm" id="pending_confirm" />PPC</label>
							</div>	
						</div>
						
						<div class="col-sm-1">	
						<input type="hidden" name="date_from" id="date_from" data-date_from="<?php if( isset( $_GET['leadfrom'] ) ){ echo $_GET['leadfrom'] ; }else {echo $first_day_this_month; } ?>" value="" >
						<input type="hidden" name="date_to" id="date_to" data-date_to="<?php if( isset( $_GET['leadto'] ) ){ echo $_GET['leadto'] ; }else{ echo $last_day_this_month; } ?>" value="">
						<input type="hidden" name="filter_val" id="filter_val" value="<?php if( isset( $_GET['payStatus'] ) ){ echo $_GET['payStatus']; }else{ echo "all";	} ?> ">
						<input type="hidden" name="todayStatus" id="todayStatus" value="<?php echo $todayStatus; ?>">
						<input type="submit" class="btn btn-success btn-block" value="Filter">
						</div>
					
				</form><!--End filter section-->	
			</div> 
			
			<div class="portlet-body">
				<div class="table-responsive">
					<table id="payments" class="table table-bordered">
						<thead>
							<tr>
								<th> # </th>
								<th> Iti ID </th>
								<th> Type </th>
								<th> Customer Name </th>
								<th> Customer Contact </th>
								<th> Package Cost </th>
								<th> Balance</th>
								<th> Next Due Date</th>
								<th> Status</th>
								<th> Action </th>
								<th> Pay. Confirm Status </th>
								<th> TD </th>
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


<script type="text/javascript">
var table;
$(document).ready(function() {
	//UPDATE CONFIRM PAYMENT STATUS
	$(document).on("click", '.is_payment_confirmed', function() {
		var _this = $(this);
		var ajaxReq;
		//get review id
		var id = $(this).attr("data-id");
		swal({
			buttons: {
				cancel: true,
				confirm: true,
			},
			title: "Are you sure to Update Payment Confirm Status?",
			text: "",
			icon: "warning",
			confirmButtonClass: "btn-danger",
			confirmButton: "Yes, Update it!",
			cancelButton: "No, cancel!",
			closeModal: false,
		}).then((willDelete) => {
			if (willDelete) {
				$.ajax({
					url: "<?php echo base_url(); ?>" + "payments/ajax_payment_confirm_updateStatus",
					type:"POST",
					data:{ "id":  id },
					dataType: 'json',
					success: function(res) {
						if(res.status == true ) {
							swal("Updated!", res.msg , "success");
						} else {
							swal("Error!", "Something went wrong!", "danger");
						}
						location.reload();
					},
					error: function(err) {
						swal("Error!", "Something went wrong!", "danger");
					}
				});
			}else{
				swal("Cancelled!", "Action Cancelled!", "success");			
				_this.attr('checked', false);
			}	
		});
	});
	
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
	table = $('#payments').DataTable({ 
		"aLengthMenu": [[10,25, 50, 100, -1], [10, 25, 50, 100, 'All']],
		"processing": true, //Feature control the processing indicator.
		"serverSide": true, //Feature control DataTables' server-side processing mode.
		"order": [], //Initial no order.
		language: {
			search: "<strong>Search By Iti id/customer name:</strong>",
			searchPlaceholder: "Search..."
		},
		
		// Load data for the table's content from an Ajax source
		"ajax": {
			"url": "<?php echo site_url('payments/ajax_payments_list')?>",
			"type": "POST",
			"data": function ( data ) {
				data.filter = $("#filter_val").val();
				data.from = $("#date_from").attr("data-date_from");
				data.end = $("#date_to").attr("data-date_to");
				data.todayStatus = $("#todayStatus").val();
			},
			beforeSend: function(){
				console.log("sending....");
			}
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
		ranges: {
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Tomorrow': [moment().add(1, 'days'), moment().add(1, 'days')],
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
		   'Next 30 Days': [moment(), moment().add(30, 'days')],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
           'Last Three Month': [moment().subtract(3, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
           'Next Three Month': [moment().add(1, 'month').startOf('month'), moment().add(3, 'month').endOf('month')]
        },
	},
	function(start, end, label) {
		//$('#daterange').val( start.format('YYYY-MM-DD') + '-' +  end.format('YYYY-MM-DD')  );
		$('#daterange').val( start.format('D MMMM, YYYY') + ' to ' +  end.format('D MMMM, YYYY')  );
		//$('#daterange').val( start.format('YYYY-MM-DD') + '-' +  end.format('YYYY-MM-DD')  );
		$("#date_from").attr( "data-date_from", start.format('YYYY-MM-DD') );
		$("#date_to").attr( "data-date_to", end.format('YYYY-MM-DD') );
		$("#todayStatus").val("");
		console.log("A new date range was chosen: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
	});
});
</script>
