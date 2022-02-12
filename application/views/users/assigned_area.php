<div class="page-container">
	<div class="page-content-wrapper">
		<div class="page-content">
		 <!-- BEGIN SAMPLE TABLE PORTLET-->
			<div class="portlet box blue">
				<div class="portlet-title">
					<div class="caption">

						<i class="fa fa-cogs"></i>All Users With Assigned Area
					</div>
					<a class="btn btn-success" href="<?php echo site_url("agents/assign_area"); ?>" title="add agent">Assign User</a>
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
								<th> State </th>
								<th> City </th>
								<th> Place </th>
								<th> Categories </th>
								<th> Action </th>
							</tr>
						</thead>
						<tbody>
							<?php if(!empty($views)):
							$ii=1;
							foreach($views as $view):  ?>
								<td> <?php echo $ii; ?> . </td>
							<td> <?php echo ucfirst(get_user_name($view->user));?></td>
							
							<td> <?php
								if( !empty( $view->state ) ){
									$in = 1;
									$passed = false;
									$states = explode(",", $view->state);
									foreach( $states as $st ){
										echo ($passed ? ',' : '' ) . ucfirst(get_state_name($st));
										$passed = true;
										if( $in==10 ) break;
										$in++;
									}
								}
								?>
							</td>	
							<td> <?php $id = explode(',',$view->city); 
								$passed = false;
								for($i=0; $i < count($id); $i++){
									$city = get_city_name($id[$i]);												
									//echo $city . "," ;
									echo ($passed ? ',' : '') . $city;
									$passed = true;
									if( $i==10 ) break;
								}
								?>
							</td>
									 </td>
										<td> <?php echo $view->place;?></td>
										<td> <?php echo get_category_name($view->category );?></td>
										<td>
										<a title='edit' href="<?php echo site_url()."agents/edit_user_area/".$view->user;?>" class='btn btn-success ajax_edit_user_table' ><i class='fa fa-pencil'></i></a>
										<?php //if( is_admin() ){ ?>
											<a title='delete' data-id = "<?php echo $view->id; ?>" href="" class='btn btn-danger ajax_delete_user' ><i class='fa fa fa-trash-o'></i></a>
										<?php //} ?>
										</td>
									</tr>
									<?php
									$ii++;
									endforeach; ?>
									<?php else :?>
									<tr><td colspan="7">No Data Found.</td></tr>
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
	 
	$(document).on("click", ".ajax_delete_user",function(){
		var user_id = $(this).attr("data-id");
		//alert(user_id);
		if (confirm("Are you sure?")) {
			$.ajax({
				url: "<?php echo base_url(); ?>" + "agents/ajax_deleteAssignedUser?id=" + user_id,
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