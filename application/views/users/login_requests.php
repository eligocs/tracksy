<div class="page-container">
	<div class="page-content-wrapper">
		<div class="page-content">
		 <!-- BEGIN SAMPLE TABLE PORTLET-->
			<div class="portlet box blue">
				<div class="portlet-title">
					<div class="caption">
						<i class="fa fa-cogs"></i>All Login Requested
					</div>
				</div>
			</div>
			<?php $message = $this->session->flashdata('success'); 
				if($message){ echo '<span class="help-block help-block-success">'.$message.'</span>'; }
			?>
			<div class="portlet-body second_custom_card">
				<div class="table-responsive">
					<table class="table table-striped display" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th> # </th>
								<th> Name </th>
								<th> User Name </th>
								<th> Requested Time </th>
								<th> Action </th>
							</tr>
						</thead>
						<tbody>
							<?php if(!empty($req_user_data_list)):
								$ii=1;
								foreach($req_user_data_list as $list):  ?>
									<tr>
										<td> <?php echo $ii;?>.</td>
										<td> <?php echo ucwords( $list->first_name . " " . $list->last_name  ); ?></td>
										<td> <?php echo ucfirst(get_user_name($list->user_id));?></td>
										<td> <?php echo $list->login_request_date; ?></td>
										<td> <a href="javascript: void(0)" data-id="<?php echo $list->user_id; ?>" class="btn btn-success ajax_permit_user">
										<i class="fa fa-check-circle" aria-hidden="true"></i> Allow To Login</a></td>
									</tr>
									<?php
									$ii++;
								endforeach; ?>
							<?php else :?>
								<tr><td colspan="7">No Request Found.</td></tr>
							<?php endif; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		
		</div>
	</div>
	<!-- END CONTENT BODY -->
</div>
<!-- Modal -->

<script type="text/javascript">
 jQuery(document).ready(function($){
	$(".display").dataTable({});
	$(document).on("click", ".ajax_permit_user",function(){
		var user_id = $(this).attr("data-id");
		//alert(user_id);
		if (confirm("Are you sure to allow? ")) {
			$.ajax({
				url: "<?php echo base_url(); ?>" + "agents/ajax_allow_user_to_login?id=" + user_id,
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