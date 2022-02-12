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
						<i class="fa fa-building"></i>All State/city
					</div>
				</div>
			</div>	
			
			<!--Filter-->
			<div class="cat_wise_filter second_custom_card margin-bottom-20">
				<form role="form" id="filter_frm" method="post">
					<div class="col-md-6">
						<label class="control-label">Country </label>
						<div class="form-group">
							<select name='CD' class='form-control' id='cdd'>
								<option value="">INDIA ( CODE: 101 )</option>
							</select>	
						</div>
					</div>
					<div class="col-md-6">
						<label class="control-label">State </label>
						<div class="form-group">
							<select name='state' class='form-control' id='state'>
								<?php $state_list = get_indian_state_list(); 
									if( $states ){
										foreach($states as $state){
											$selected = isset($state_id) && $state_id == $state->id ? "selected" : "";
											echo "<option {$selected} value='{$state->id}'>{$state->name} ( Code: {$state->id} ) </option>";
										}
									} ?>
							</select>	
						</div>
					</div>
				</form>	
				<div class="clearfix"></div>
				<div class="res"></div>
			</div>
			<!--End Filter-->
			
			<div class="portlet-body">
				<div class="table-responsive custom_card">
					<table id="packageslist" class="table table-striped display">
						<thead>
							<tr>
								<th> # </th>
								<th>City Code</th>
								<th>City Name</th>
								<th>State Code</th>
							</tr>
						</thead>
						<tbody>
						<div class="loader"></div>
						<div id="res"></div>
							<?php if( isset( $cities ) ){
								$i = 1;
								foreach( $cities as $city ){
									echo "<tr data-id='{$city->id}'>
										<td>{$i}</td>
										<td>{$city->id}</td>
										<td>{$city->name}</td>
										<td>{$city->state_id}</td>
									</tr>";
									$i++;
								}
							} ?>
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
$(document).ready(function() {
	$('#packageslist').DataTable();
	//state change
	$('#state').on('change', function () {
		var id = $(this).val(); // get selected value
		var url = BASE_URL + "marketing/state_codes?state_id=" + id; // get selected value
		window.location = url; // redirect
	});
});
</script>
