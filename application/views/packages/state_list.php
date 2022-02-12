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
				</div>
			</div>	
			<div class="portlet-body">
				<div class="table-responsive">
					<table id="packageslist" class="table table-bordered">
						<thead>
							<tr>
								<th> # </th>
								<th> State Name</th>
								<th> Image</th>
								<th> Action </th>
							</tr>
						</thead>
						<tbody>
						<div class="loader"></div>
						<div id="res"></div>
							<?php if( isset( $states ) ){
								$i = 1;
								foreach( $states as $state ){
									echo "<tr data-id='{$state->id}'>
										<td>{$i}</td>
										<td>{$state->name}</td>
										<td>{$state->state_image}</td>
										<td><a href='javascript: void(0)' title='Change State Image'><i class='fa fa-pencil'></i></td>
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
});
</script>
