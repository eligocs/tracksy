<style>
.yellow_row{ background-color: yellow !important;}
.hold_row{ background-color: pink !important;}
</style>
<div class="page-container">
	<div class="page-content-wrapper">
		<div class="page-content">
		<!-- BEGIN SAMPLE TABLE PORTLET-->
		<?php $message = $this->session->flashdata('success'); 
		if($message){ echo '<span class="help-block help-block-success">'.$message.'</span>';}
		?>
		<!--error message-->
		<?php $err = $this->session->flashdata('error'); 
		if($err){ echo '<span class="help-block help-block-error2 red">'.$err.'</span>';}
		?>
		<?php $sales_team_agents = get_all_sales_team_agents(); ?>
		<div class="portlet box blue">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-users"></i>All Customers
				</div> 
				<?php if( is_admin_or_manager() || is_teamleader() ){ ?>
					<a class="btn btn-success" href="<?php echo site_url("customers/add"); ?>" title="Add Customer">Add customer</a>
				<?php  } ?>
			</div>
		</div>
			<?php
				//Hide filter
				$hideClass = isset( $_GET["todayStatus"] ) || isset( $_GET["leadfrom"] ) ? "hideFilter" : "";
				if( isset( $todayStatus ) ){	
					$first_day_this_month = $todayStatus; 
					$last_day_this_month  = $todayStatus;
				}else{
					$first_day_this_month = ""; 
					$last_day_this_month  = "";
				}
			?>
			<div class="portlet-body">
			<!--sort by agent -->
				<?php /*
			<?php if( is_admin_or_manager() ){ ?>
				<div class="col-md-4">
					
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
			<?php } ?>
			<div class="marginBottom">
				<!--start filter section-->
				<form id="form-filter" class="form-horizontal <?php echo $hideClass; ?>">
					<div class="actions custom_filter pull-right form-inline">
						<strong>Filter: </strong>
						<!--Calender-->
						<input type="text" autocomplete="off" class="form-control" id="daterange" name="dateRange" value="" required />
						<!--End-->
						<div class="btn-group" data-toggle="buttons">
							<button class="btn btn-primary custom_active"><input type="radio" name="filter" value="all" id="all"/>All</button>
							<button class="btn btn-primary custom_active"><input type="radio" name="filter" value="pending" id="pending" />Working</button>
							<button class="btn btn-primary custom_active"><input type="radio" name="filter" value="notwork" id="notwork" />Not Process</button>
							<button class="btn btn-primary custom_active"><input type="radio" name="filter" value="8" id="declined" />Declined</button>
							<button class="btn btn-primary custom_active"><input type="radio" name="filter" value="9" id="approved" />Approved</button>
						</div>	
						<input type="hidden" name="date_from" id="date_from" data-date_from="<?php if( isset( $leadfrom ) ){ echo $leadfrom ; }else {echo $first_day_this_month; } ?>" value="" >
						<input type="hidden" name="date_to" id="date_to" data-date_to="<?php if( isset( $leadto ) ){ echo $leadto ; }else{ echo $last_day_this_month; } ?>" value="">
						<input type="hidden" name="filter_val" id="filter_val" value="<?php if( isset( $leadstatus ) ){ echo $leadstatus; }else{ echo "all"; } ?>">
						<input type="hidden" name="todayStatus" id="todayStatus" value="<?php if( isset( $todayStatus ) ){ echo $todayStatus; } ?>">
						<input type="submit" class="btn btn-success" value="Filter">
					</div>
				</form><!--End filter section-->	 
				
				
			</div> 
			<div class="clearfix"><br></div>
			<!--export button for admin and manager-->
			<?php if( is_admin_or_manager() ){ ?>
				<div class="clearfix export_section">
					<a href="<?php echo base_url("export/export_customers_fiter_data");?>" class="btn btn-danger pull-right export_btn"><i class="fa fa-file-excel"></i> Export</a>
				</div>	
			<?php } ?>
			*/ ?>
			
			<div class="filter-box">
			<div class="row3 marginBottom clearfix">
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
				<?php if( $user_role == 97 ){ ?>
					<!--start filter section-->
					<form id="form-filter" class="flex form-horizontal marginRight<?php echo $hideClass; ?>">
						<div class="actions custom_filter">
						
						<div class="row">
						<!--Calender-->
							<div class="col-md-3">	<strong>Filter: </strong><br>
								<input type="text" autocomplete="off" class="form-control" id="daterange" name="dateRange" value="" required />
							</div>
							<!--End-->
							<div class="col-md-3">	<strong>Itinerary Type: </strong><br>
								<select name="iti_type" class="form-control" id="iti_type">
									<option value="">All</option>
									<option value="1">Holidays</option>
									<option value="2">Accommodation</option>
								</select>
							</div>
							<div class="col-md-6"><strong>&nbsp; </strong><br>
							
							<div class="btn-group" data-toggle="buttons">
								<label class="btn btn-default btn-primary custom_active"><input type="radio" name="filter" value="all" id="all"/>All</label>
								<label class="btn btn-default btn-success custom_active"><input type="radio" name="filter" value="9" id="approved" />Approved</label>
								<label class="btn btn-default purple custom_active"><input type="radio" name="filter" value="revised" id="revised" />Revised</label>
								<label class="btn btn-default btn-danger custom_active"><input type="radio" name="filter" value="travel_date" id="travel_date" />Travel Date</label>
							</div>	
							<input type="hidden" name="date_from" id="date_from" data-date_from="<?php if( isset( $_GET["leadfrom"] ) ){ echo $_GET["leadfrom"] ; }  else { echo $first_day_this_month; } ?>" value="" >
							<input type="hidden" name="date_to" id="date_to" data-date_to="<?php if( isset( $_GET["leadto"] ) ){ echo $_GET["leadto"] ; } else{ echo $last_day_this_month; }  ?>" value="">
							<input type="hidden" name="filter_val" id="filter_val" value="<?php if( isset( $_GET["leadStatus"] ) ){ echo $_GET["leadStatus"]; }else{ echo "";	} ?>">
							<input type="hidden" id="quotation" value="<?php if( isset( $_GET['quotation'] ) ){ echo "true"; }else{ echo "false"; } ?>">
							<input type="hidden" name="todayStatus" id="todayStatus" value="<?php if( isset( $_GET["todayStatus"] ) ){ echo $_GET["todayStatus"]; } ?>">
							
							<input type="submit" class="btn btn-success" value="Filter">
							
						</div>
						</div>
						</div>
					</form><!--End filter section-->	
				<?php }else{ ?>	
				
					<!--start filter section-->
					<form id="form-filter" class="form-horizontal marginRight <?php echo $hideClass; ?>">
						<div class="actions custom_filter">
						<div class="row">
							<!--Calender-->
								<div class="col-md-2">	<strong>Filter: </strong><br>
									<input type="text" autocomplete="off" class="form-control" id="daterange" name="dateRange" value="" required />
								</div>
							<!--End-->
							<div class="col-md-2">	<strong>Itinerary Type: </strong><br>
								<select name="iti_type" class="form-control" id="iti_type">
									<option value="">All</option>
									<option value="1">Holidays</option>
									<option value="2">Accommodation</option>
								</select>
							</div>
							<div class="col-md-8"><strong>&nbsp; </strong><br>
							<div class="btn-group" data-toggle="buttons">
								<label class="btn btn-primary custom_active"><input type="radio" name="filter" value="all" id="all"/>All</label>
								<label class="btn btn-primary custom_active"><input type="radio" name="filter" value="draft" id="declined" />Draft</label>
								<label class="btn btn-primary custom_active" style="background-color: pink !important; color: black;"><input type="radio" name="filter" value="hold" id="hold" />Hold</label>
								<label class="btn btn-primary custom_active"><input type="radio" name="filter" value="pending" id="pending" />Working</label>
								<label class="btn btn-primary custom_active" style="background-color: yellow !important; color: black;"><input type="radio" name="filter" value="notwork" id="notwork" />Not Process</label>
								<label class="btn btn-primary custom_active"><input type="radio" name="filter" value="travel_date" id="travel_date" />Travel Date</label>
								<label class="btn btn-primary custom_active" style="background-color: green !important; color: white;"><input type="radio" name="filter" value="9" id="approved" />Approved</label>
								<label class="btn btn-primary custom_active"><input type="radio" name="filter" value="8" id="declined" />Declined</label>
								<label class="btn btn-primary custom_active" style="background-color: #3d3d3d !important; color: #fff;"><input type="radio" name="filter" value="revised" id="amendment" />Amendment</label>
							</div>
							<input type="hidden" name="date_from" id="date_from" data-date_from="<?php if( isset( $_GET["leadfrom"] ) ){ echo $_GET["leadfrom"] ; }  else { echo $first_day_this_month; } ?>" value="" >
							<input type="hidden" name="date_to" id="date_to" data-date_to="<?php if( isset( $_GET["leadto"] ) ){ echo $_GET["leadto"]; } else{ echo $last_day_this_month; }  ?>" value="">
							<input type="hidden" name="filter_val" id="filter_val" value="<?php if( isset( $_GET["leadStatus"] ) ){ echo $_GET["leadStatus"]; }else{ echo "all"; } ?>" />
							<input type="hidden" id="quotation" value="<?php if( isset( $_GET['quotation'] ) ){ echo "true"; }else{ echo "false";} ?>" />
							<input type="hidden" name="todayStatus" id="todayStatus" value="<?php if( isset( $_GET["todayStatus"] ) ){ echo $_GET["todayStatus"]; } ?>" />
							<input type="submit" class="btn btn-success" value="Filter">
						</div>
						</div> <!-- row -->
						</div>
					</form><!--End filter section-->	
				<?php } ?>	
			</div> 
			</div> 
			<?php if( is_admin_or_manager() ){ ?>
				<div class="row clearfix">
					<div class="col-md-3">
						<div class="form-group">
							<label for="sales_user_id">Select Sales Team User:</label>
							<select required class="form-control select_user" id='sales_user_id' name="user_id">
								<option value="">All Users</option>
								<?php foreach( $sales_team_agents as $user ){ ?>
									<option value="<?php echo $user->user_id; ?>"><?php echo $user->user_name . " ( " . ucfirst( $user->first_name ) . " "  . ucfirst( $user->last_name) . " )"; ?></option>
								<?php } ?>
							</select>
						</div> 
					</div>	
					<!--export button for admin and manager-->
					<a href="javscript:void(0)" class="btn btn-danger pull-right export_btn"><i class="fa fa-file-excel"></i> Export</a>
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
				<table id="customers" class="table table-striped table-hover">
					<thead>
						<tr>
							<th> # </th>
							<th> Lead ID </th>
							<?php if( is_admin_or_manager() ){  ?>
								<th> Type </th>
							<?php } ?>
							<th> Name</th>
							<th> Email </th>
							<th> Contact </th>
							<th> Last/Status </th>
							<th> Created </th>
							<?php if( is_admin_or_manager()  || is_teamleader() ){  ?>
								<th> Agent </th>
							<?php } ?>
							<th> Action </th>
							<th> Travel Date </th>
							<th> Status </th>
						</tr>
					</thead>
					<tbody>
						<!--DataTable goes here-->
					</tbody>
				</table>
			</div>
		</div><!--  -->
		</div>
		</div>
	</div>
</div>
<style>
#pakcageModal{top: 20%;}
</style>
<!-- package Modal -->
<div id="pakcageModal" class="modal" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">Close</button>
				<h4 class="modal-title">Select Package</h4>
			</div>
			<div class="modal-body"> 
				<form id="createIti">
					<div class="">
						<?php $prePackages = get_all_packages(); ?>
						<?php $getPackCat = get_package_categories(); ?>
						<?php $state_list = get_indian_state_list(); ?>
						<div class="form-group">
						<label>Select Package Category*</label>
						<select required name="package_cat_id" class="form-control" id="pkg_cat_id">
							<option value="">Choose Package</option>
							<?php if( $getPackCat ){ ?>
								<?php foreach($getPackCat as $pCat){ ?>
									<option value = "<?php echo $pCat->p_cat_id ?>" ><?php echo $pCat->package_cat_name; ?></option>
								<?php } ?>
							<?php }	?>
						</select>
						</div>
						
						<div class="form-group">
							<label>Select State*</label>
							<select required disabled name="satate_id" class="form-control" id="state_id">
								<option value="">Select State</option>
								<?php if( $state_list ){ 
									foreach($state_list as $state){
										echo '<option value="'.$state->id.'">'.$state->name.'</option>';
									}
								} ?>	
							</select>
						</div>
						
						
						<div class="form-group">
						<label>Select Package</label>
						<select required disabled name="packages" class="form-control" id="pkg_id">
							<option value="">Choose Package</option>
						</select>
						</div>
						
						<div class="form-actions">
							<input type="hidden" id="cust_id" value="">
							<input type="submit" class='btn btn-green' id="continue_package" value="Continue" >
						</div>
					</div>	
					<div id="pack_response"></div>	
				</form>	
				<hr>
				<h2><strong>OR</strong></h2>
				<div class="form-group">
					<a href="" class='btn btn-green' id="readyForQuotation" title='Add Itinerary'><i class='fa fa-plus'></i> Create New</a>
				</div>
			</div>
			<div class="modal-footer"></div>
		</div>
	</div>
</div>
<script type="text/javascript">
jQuery(document).ready(function($){
		//export btn click
	$(document).on("click",".export_btn", function(e){
		e.preventDefault();
		//get filtered perameters
		var filter 		= $("#filter_val").val(),
			d_from		= $("#date_from").attr("data-date_from"),
			end 		= $("#date_to").attr("data-date_to"),
			todayStatus = $("#todayStatus").val(),
			agent_id 	= $("#sales_user_id").val();
			
		var export_url = "<?php echo base_url('export/export_cus_merge_fiter_data?filter='); ?>" + filter + "&d_from=" + d_from + "&end=" + end + "&todayStatus=" + todayStatus + "&agent_id=" + agent_id;
		//redirect to export
		if( confirm( "Are you sure to export data ?" ) ){
			window.location.href = export_url;
		}	
	});	
	
	$(document).on("click", ".ajax_delete_customer",function(){
		var res= $("#res");
		var user_id = $(this).attr("data-id");
		//console.log(user_id);
		if (confirm("Are you sure?")) {
			$.ajax({
				url: "<?php echo base_url(); ?>" + "AjaxRequest/delete_customer",
				type:"POST",
				dataType: "json",
				data: {id: user_id},
				cache: false,
				beforeSend: function(){
					res.html("Please wait....");
				},
				success: function(r){
					if(r.status = true){
						res.hide();
						location.reload();
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
           'Tomorrow': [moment().add(1, 'days'), moment().add(1, 'days')],
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
		
		//Get all itineraries by agent 
		$(document).on("change", '#sales_user_id', function() {
			table.ajax.reload(null,true);
		});
		
		//On page loaddatatables
		table = $('#customers').DataTable({ 
			"aLengthMenu": [[10,25, 50, 100, -1], [10, 25, 50, 100, 'All']],
			"processing": true, //Feature control the processing indicator.
			"serverSide": true, //Feature control DataTables' server-side processing mode.
			"order": [], //Initial no order.
			"createdRow": function( row, data, dataIndex){
				//console.log( dataIndex );
				var iti_status = data.slice(-1)[0];
				
                if( iti_status ==  'NOT PROCESS')
                    $(row).addClass('yellow_row');
                else if( iti_status ==  'APPROVED' )
					$(row).addClass('green_row');	
				else if( iti_status ==  'DECLINED' )
					$(row).addClass('red_row');	
				if( iti_status ==  'ON HOLD')
					$(row).addClass('hold_row');	
            },
			language: {
				search: "<strong>Search By Lead ID:</strong>",
				searchPlaceholder: "Search..."
			},
			// Load data for the table's content from an Ajax source
			"ajax": {
				"url": "<?php echo site_url('customers/ajax_customers_list')?>",
				"type": "POST",
				"data": function ( data ) {
					//data.filter = $("#filter_val").val();
					//data.from = $("#date_from").attr("data-date_from");
					//data.end = $("#date_to").attr("data-date_to");
					//data.todayStatus = $("#todayStatus").val();
					//data.agent_id = $("#sales_user_id").val();
					data.filter 	= $("#filter_val").val();
					data.from 		= $("#date_from").attr("data-date_from");
					data.end 		= $("#date_to").attr("data-date_to");
					data.todayStatus = $("#todayStatus").val();
					data.quotation 	= $("#quotation").val();
					data.agent_id 	= $("#sales_user_id").val();
					data.iti_type 	= $("#iti_type").val();
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

<!-- Package Listing Modal -->
<script type="text/javascript">
jQuery(document).ready(function($){
	var ajaxReq;
	var resp = $("#pack_response");
	//ajax request if predefined package choose
	$("#createIti").validate({
		submitHandler: function(){
			if (ajaxReq) {
				ajaxReq.abort();
			}
			$("#continue_package, #readyForQuotation").addClass("disabledBtn");
			var package_id = $("#pkg_id").val();
			var customer_id = $("#cust_id").val();
			if( package_id == '' || customer_id == '' ){
				resp.html( "Please Choose Package First" );
				resp.html('<div class="alert alert-danger"><strong>Error! </strong>Please Choose Package First</div>');
				return false;
			}	
			//resp.html( "Package Id: " + package_id + "Customer Id: " + customer_id );
			ajaxReq = $.ajax({
				type: "POST",
				url: "<?php echo base_url('packages/createItineraryFromPackageId'); ?>",
				data: {package_id: package_id, customer_id: customer_id},
				dataType: "json",
				beforeSend: function(){
					resp.html('<p><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
				},
				success: function(res) {
					if (res.status == true){
						resp.html('<div class="alert alert-success"><strong>Success! </strong>'+res.msg+'</div>');
						window.location.href = "<?php echo site_url('itineraries/edit/');?>" + res.iti_id + "/" + res.temp_key;
					}else{
						resp.html('<div class="alert alert-danger"><strong>Error! </strong>'+res.msg+'</div>');
						//console.log("error");
					}
				},
				error: function(e){
					console.log(e);
					resp.html('<div class="alert alert-danger"><strong>Error!</strong> Please Try again later! </div>');
				}
			}); 
		}	
	});	
	
	//Open Modal On ready to quotation click
	$(document).on("click",".ajax_additi_table", function(e){
		e.preventDefault();
		$("#pakcageModal").show();
		var customer_id	= $(this).attr("data-id");
		var temp_key 	= $(this).attr("data-temp_key");
		var _this_href 	= $(this).attr("href");
		
		//If user not select package
		$("#cust_id").val(customer_id);
		$("#readyForQuotation").attr( "href", _this_href );
		
	});
	jQuery(document).on("click", ".close",function(){
		jQuery("#pakcageModal").fadeOut();
	});
	
	$(document).on('change', 'select#pkg_cat_id', function() {
		$("#state_id, #pkg_id").val("");
		$("#state_id").removeAttr("disabled");
	});
	
	/*get Packages by Package Category*/
	$(document).on('change', 'select#state_id', function() {
		var p_id = $("#pkg_cat_id option:selected").val();
		var state_id = $("#state_id option:selected").val();
		
		var _this = $(this);
		$("#pkg_id").val("");
		_this.parent().append('<p class="bef_send"><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
		$.ajax({
			type: "POST",
			url: "<?php echo base_url('packages/packagesByCatId'); ?>",
			data: { pid: p_id, state_id: state_id } 
		}).done(function(data){
			$(".bef_send").hide();
			$("#pkg_id").html(data);
			$("#pkg_id").removeAttr("disabled");
		}).error(function(){
			$(".bef_send").html("Error! Please try again later!");
		});
	});
});
</script>