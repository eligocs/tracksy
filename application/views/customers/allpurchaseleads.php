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
					<i class="fa fa-users"></i>All Purchase Leads
				</div>
				<?php if( $user_role = 95 ){ ?>
					<a class="btn btn-success" href="<?php echo site_url("purchaseleads/add"); ?>" title="Add Customer">Add Leads</a>
				<?php } ?>
			</div>
		</div>	
			
		
			<div class="portlet-body">
	
		 
				<div class="table-responsive">
					<table id="leads" class="table table-striped table-hover">
						<thead>
							<tr>
								<th> Customer ID </th>
								<th> Customer Name</th>
								<th> Email </th>
								<th> Contact </th>
								<th> Created </th>
								<th> Action </th>
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
<!-- Modal -->
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
		//On page loaddatatables
		table = $('#leads').DataTable({ 
			"aLengthMenu": [[15,30, 50, 100, -1], [15, 30, 50, 100, 'All']],
			"processing": true, //Feature control the processing indicator.
			"serverSide": true, //Feature control DataTables' server-side processing mode.
			"order": [], //Initial no order.
			language: {
				search: "<strong>Search By Customer ID:</strong>",
				searchPlaceholder: "Search..."
			},
			// Load data for the table's content from an Ajax source
			"ajax": {
				"url": "<?php echo site_url('purchaseleads/ajax_list')?>",
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