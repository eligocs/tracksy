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
		 <!-- BEGIN SAMPLE TABLE PORTLET-->
			<div class="portlet box blue">
				<div class="portlet-title">
					<div class="caption">
						<i class="fa fa-cogs"></i>All Customers Type
					</div>
					<a class="btn btn-success" href="<?php echo site_url("customers/savecustype"); ?>" title="add agent">Add Customer Type</a>
				</div>
			</div>
			<div class="portlet-body">
				<div class="table-responsive second_custom_card">
					<table class="table display" id="table" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th> # </th>
								<th> Customer Type </th>
								<th> Action </th>
							</tr>
						</thead>
						<tbody>
							<?php 
							if( isset($customer_types) && !empty($customer_types) ){
								$count = 1;
								//getAllCategory
								foreach($customer_types as $cat){	?>
								<tr>
									<td><?php echo $count;?></td>
									<td><?php echo $cat->name;?></td>
									<td>
										<?php if( $cat->id > 2 ){ ?>
											<a title='edit' href=" <?php echo site_url("customers/savecustype/".$cat->id);?>" class="btn_pencil ajax_edit_cat_table" ><i class='fa fa-pencil'></i></a>
										<?php } ?>
										
										
										<?php if( $cat->id > 2 ){ ?>
											<a title="delete" href="javascript:void(0)" data-id = "<?php echo $cat->id;?>" class='btn_trash ajax_delete_cat'><i class='fa fa-trash-o'></i></a>
										<?php }  ?>
										
									</td>
								</tr>
								<?php $count++;
								} 
							} else {?>
							<tr>
								<td colspan="3" style="text-align:center;"> No Records Found Click here to <a href="<?php echo site_url("customers/addcustomertype")?>">add new type</a></td>
							<?php } ?>
							</tr>
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
	$("#table").DataTable(); 
	
	$(document).on("click", ".ajax_delete_cat",function(){
		var id = $(this).attr("data-id");
		//alert(user_id);
		if (confirm("Are you sure?")) {
			$.ajax({
				url: "<?php echo base_url(); ?>" + "customers/ajax_delete_type",
				type:"POST",
				data:{id: id},
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
