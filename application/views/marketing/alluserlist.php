<div class="page-container">
	<div class="page-content-wrapper">
		<div class="page-content">
		 <!-- BEGIN SAMPLE TABLE PORTLET-->
			<div class="portlet box blue">
				<div class="portlet-title">
					<div class="caption">
						<i class="fa fa-cogs"></i>All Marketing Users
					</div>
					<a class="btn btn-success" href="<?php echo site_url("marketing/add"); ?>" title="add user">Add Marketing User</a>
				</div>
			</div>
			<div class="cat_wise_filter second_custom_card">
				<!--check if no area assign to service and sales team ; -->
				<?php if( ( $user_role == 96 || $user_role == 97 ) &&  !$check_assign_area ){ 
					echo "<p>No area assign to you.Please Contact your manager.</p>";
				}else{ ?>
				<!--Show success message if hotel edit/add -->
				<?php $message = $this->session->flashdata('success'); 
					if($message){ echo '<span class="help-block help-block-success">'.$message.'</span>'; }
				$eerr = $this->session->flashdata('error'); 
					if($eerr){ echo '<span class="help-block help-block-success"><span class="red">'.$eerr.'</span></span>'; }
				?>
				<?php if( !is_salesteam() && !is_serviceteam() ){ ?>
				<!--Filter-->
				<form role="form" id="filter_frm" method="post">
					<div class="col-md-3">
					<label class="control-label">State </label>
						<div class="form-group">
							<select name='state' class='form-control' id='state'>
								<option value="">Select State</option>
								<?php $state_list = get_indian_state_list(); 
									if( $state_list ){
										foreach($state_list as $state){
											echo '<option value="' . $state->id .'">'.$state->name.'</option>';
										}
									} ?>
							</select>	
						</div>
					</div>
					<div class="col-md-3">	
						<div class="form-group">
							<label class="control-label">Choose Category*</label>
							<select required name="cat" class="form-control" id="all_cat_list">
								<option value="">Select Category</option>
								<?php if(!empty($categories)) { ?>
								<?php foreach($categories as $cat){?>
									<option value="<?php echo $cat->id;?>"><?php echo $cat->category_name;?></option>
								<?php }	?>
								<?php } ?>
							</select>
						</div>
					</div>
					
					<div class="col-md-3">	
						<div class="form-group">
							<label class="control-label">Date Range</label>
							<input type="text" class="form-control" autocomplete="off" id="daterange" name="dateRange" value="" />
						</div>
					</div>
					
					<div class="col-md-3 margin-top-15 padding-tb-10">	
						<div class="margiv-top-10">
							<button type="submit" class="btn green uppercase add_user">Filter</button>
							<a href="javascript:void(0);" class="btn green uppercase reset_filter"><i class="fa fa-refresh"></i> Reset</a>
						</div>
					</div>
					<input type="hidden" id="stateID" value="" />
					<input type="hidden" id="cityID" value="" />
					<input type="hidden" id="catID" value="" />
					<input type="hidden" name="date_from" id="date_from" value="" >
					<input type="hidden" name="date_to" id="date_to" value="">
					
					<?php $todayStatus = isset( $_GET["todayStatus"] ) && !empty( $_GET["todayStatus"] ) ? $_GET["todayStatus"] : "";	?>
					<input type="hidden" id="todayStatus" value="<?php echo $todayStatus; ?>" />
			
				</form>	
				<div class="clearfix"></div>
				<div class="res"></div>
			</div>
			<!--End Filter-->
			<div class="filter_city_list"></div><!--city filter-->
			<hr class="clearfix" />
			<div class="custom_card">
				<div class="upload_user_section">
					<form class="" action="<?php echo base_url(); ?>marketing/import_marketing_users" method="post" name="upload_excel" enctype="multipart/form-data">
							<!-- File Button -->
							<div class="col-md-4">	
							<div class="form-group">
								<label class="control-label" for="filebutton">Select Csv File</label>
								<div class="d_inline_block">
									<input required type="file" name="file" id="file" class="input-large">
								</div>
							</div>
							</div>
							<div class="col-md-4">	
							<!-- Button -->
							<div class="form-group">
								<label class="control-label" for="singlebutton">Import User</label>
								<div class="d_inline_block">
									<button type="submit" id="submit" name="Import" class="btn green uppercase button-loading" data-loading-text="Loading...">Import</button>
								</div>
							</div>
							</div>
					</form>
				</div>
				<?php } ?>
				<div class="clearfix"></div>	
				<div class="portlet-body">
					<div class="table-responsive">
						<table class="table table-striped display" id="table" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th> # </th>
									<th> Name </th>
									<th> State</th>
									<th> City</th>
									<th> Company Name</th>
									<th> Email </th>
									<th> Contact </th>
									<th> Marketing Category </th>
									<th> Action </th>
									<th> Agent </th>
								</tr>
							</thead>
							<tbody>
							<!--Data table -->
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<?php } ?>
		</div>
		</div>
	</div>
	<!-- END CONTENT BODY -->
<style>
.city_filter .btn:hover {
  background-color: #32c5d2 !important;
}
.city_filter .btn.active {
  background-color: #32c5d2 !important;
}
</style>

<script type="text/javascript">
 jQuery(document).ready(function($){
	$(document).on("click", ".ajax_delete_user",function(){
		var user_id = $(this).attr("data-id");
		//alert(user_id);
		if (confirm("Are you sure?")) {
			$.ajax({
				url: "<?php echo base_url(); ?>" + "marketing/ajax_deleteMUser?id=" + user_id,
				type:"GET",
				data:user_id,
				dataType: "json",
				cache: false,
				success: function(r){
					if(r.status = true){
						location.reload();
					  console.log("ok" + r.msg);
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
$(document).ready(function() {
	var ajaxReq, table;
	$("#filter_frm").validate({
		submitHandler: function(form) {
			var resp = $(".res");
			var city_d = $(".filter_city_list");
			var formData = $("#filter_frm").serializeArray();
			
			//Reload data table
			$("input#stateID").val($("#state").val());
			$("input#cityID").val("all");
			$("input#catID").val($("#all_cat_list").val());
			table.ajax.reload(null,true);
		
			//console.log(formData);
			if (ajaxReq) {
					ajaxReq.abort();
				}
				ajaxReq = $.ajax({
				type: "POST",
				url: "<?php echo base_url('marketing/ajax_get_marketing_user_city_list'); ?>" ,
				dataType: 'json',
				data: formData,
				beforeSend: function(){
					resp.html('<p><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
				},
				success: function(res) {
					if (res.status == true){
						resp.html("");
						city_d.html('<div class="city_filter">'+res.city_data+'</div>');
						//console.log("done");
					}else{
						resp.html('<div class="alert alert-danger"><strong>Error! </strong>'+res.msg+'</div>');
						city_d.html("");
						console.log("error");
					}
				},
				error: function(e){
					console.log(e);
					//response.html('<div class="alert alert-danger"><strong>Error!</strong>Please Try again later! </div>');
				}
			});
			return false;
		}
	});	
	
	//Add active class to city list filter
	$(document).on("click", ".city_btn", function(e){
		var _this = $(this);
		e.preventDefault();
		$(".city_btn").removeClass("active");
		_this.addClass("active");
		
		//Get city id and category id
		var city_id = _this.attr("data-city_id");
		var cat_id = _this.attr("data-cat_id");
		var state_id = _this.attr("data-state_id");
		
		//add city to export button
		$("#btn_export_data").attr("data-city_id", city_id);
		
		$("input#stateID").val(state_id);
		$("input#cityID").val(city_id);
		$("input#catID").val(cat_id);
		
		//reload data table
		table.ajax.reload(null,true);
	});
	
	//Export data btn click
	$(document).on("click", "#btn_export_data", function(e){
		var state 	= $(this).attr("data-state_id");
		var city	 = $(this).attr("data-city_id");
		var cat 	= $(this).attr("data-cat_id");
		var ex_url = "<?php echo base_url( "export/export_marketing_user_data?state=" );?>" + state + "&city=" + city + "&category=" + cat;
		//console.log( ex_url );
		if( confirm( "Are you sure to export data ? " ) ){
			window.location.href = ex_url;
		}	
	});	
	
	//Reset filter
	$(document).on("click", ".reset_filter" ,function(e){
		e.preventDefault();
		$("form#filter_frm").find("input,select").val("");
		$(".filter_city_list, .res").html("");
		table.ajax.reload(null,true);
	});
	
    //data tables
    table = $('#table').DataTable({ 
		"aLengthMenu": [[10,25, 50, 100, -1], [10, 25, 50, 100, 'All']],
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
		language: {
			search: "<strong>Search By User name/Email Id:</strong>",
			searchPlaceholder: "Search..."
		},
        // Load data for the table's content from an Ajax source
		"ajax": {
            "url": "<?php echo site_url('marketing/ajax_marketing_user_list')?>",
            "type": "POST",
			"data": function ( data ) {
				data.state_id = $("#stateID").val();
				data.city_id = $("#cityID").val();
				data.cat_id = $("#catID").val();
				data.todayStatus = $("#todayStatus").val();
				data.dfrom = $("#date_from").val();
				data.dend = $("#date_to").val();
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
           'Tomorrow': [moment().add(1, 'days'), moment().add(1, 'days')],
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
	},
	function(start, end, label) {
		$('#daterange').val( start.format('D MMMM, YYYY') + ' to ' +  end.format('D MMMM, YYYY'));
		$("#date_from").val(start.format('YYYY-MM-DD') );
		$("#date_to").val(end.format('YYYY-MM-DD') );
		console.log("A new date range was chosen: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
	});
});
</script>
