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
					<i class="fa fa-users"></i>All Booked Leads
				</div>
			</div>
		</div>	
			<div class="portlet-body second_custom_card">
				<div class="table-responsive">
					<table id="customers" class="table table-striped display">
						<thead>
							<tr>
								<th> # </th>
								<th> Lead ID </th>
								<th> Customer Name</th>
								<th> Email </th>
								<th> Contact </th>
								<th> Agent </th>
								<th> Created </th>
								<th> Action </th>
							</tr>
						</thead>
						<tbody>
						<?php $i=1; //dump($leads);die;
						if(!empty($leads)){
						foreach($leads as $lead){ 
 						?>
								<tr>
								<td><?php echo $i ++; ?></td>
								<td><?php echo $lead->customer_id; ?></td>
								<td><?php echo $lead->customer_name; ?></td>
								<td><?php echo $lead->customer_email; ?></td>
								<td><?php echo $lead->customer_contact; ?></td>
								<td><?php echo $lead->agent_id; ?></td>
								<td><?php $timestamp= strtotime($lead->Created);
										$date = date('d-m-Y', $timestamp);

									echo $date; ?></td>
								<td>
								<a href="<?php echo  site_url('search/?id=').$lead->customer_id ; ?>" title='View Customer' class='btn btn-success' ><i class='fa fa-eye'></i></a>
								</td>	
								</tr>
							
						<?php } }?>
							<!--DataTable goes here-->
						</tbody>
					</table>
				</div>
			</div>
		</div>
		</div>
	</div>
</div>
<script>
$(document).ready( function () {
    $('#customers').dataTable();
} );
</script>