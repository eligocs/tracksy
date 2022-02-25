<style>select#city,select#state{min-height: 180px;}</style>
<div class="page-container">
	<div class="page-content-wrapper">
		<div class="page-content">
			<div class="portlet box blue">
				<div class="portlet-title">
					<div class="caption"><i class="fa fa-user"></i>Add Team</div>
					<a class="btn btn-success" href="<?php echo site_url("agents/teamleaders"); ?>" title="Back">Back</a>
				</div>
			</div>
			<?php echo $this->session->flashdata('message'); ?>
			<div class="portlet-body custom_card">
				<?php if( empty($all_unassigned_sales_agent) ){
					echo "<div class='alert alert-danger'>No agents found</div>";
				}else{ ?>
					<form role="form" id="frm_user_area" >
					<div class="col-md-4">
						<div id ="city_list">
							<div class="form-group-2">
								<label class="control-label">Team Name*</label>
								<input type="text" required name="team_name" class="form-control" placeholder="Team Name" />
							</div>
						</div>
					</div>
					
					<div class="col-md-4">
						<div class="form-group-2">
							<label class="control-label">Select Team Leader*</label>
							<select name="leader_id" id="leader_id" required class="form-control">
								<option value="">Select team leader</option>
								<?php 
								foreach ($all_unassigned_sales_agent as $user){
									echo "<option value='".$user->user_id . "'>".$user->first_name ." ".$user->last_name ."</option>";
								}
								?>
							</select>		
						</div>	
						<div id="error_msg"> </div>
					</div>
					
					<div class="col-md-4">
						<div class="form-group-2">
							<label class="control-label">Assign agents*</label><span style="font-size: 12px; color: red;"> (Ctr + click) for multi select</span> 
							<select name="assign_agents[]" required multiple class="form-control" id="assign_agents" >
								<option>Please select team leader first</option>
							</select>
						</div>
					</div>
					<div class="clearfix"></div>
				
				<div class="col-md-12 margin-top-30">
					<div class="margiv-top-10">
						<button type="submit" class="btn green uppercase add_agent">Add Team</button>
					</div>
				</div>	
				</form><div class="clearfix"></div>
				<div id="addresEd"></div>
				<?php } ?>
			</div><!-- portlet body -->
		</div>
	<!-- END CONTENT BODY -->
	</div>
</div>
<!-- Modal -->
<style>select option:disabled {color:red;}</style>
<script type="text/javascript">
	jQuery(document).ready(function(){
		//submit form
		$("#frm_user_area").validate({
			submitHandler: function(form) {
				
				var resp = $("#addresEd");
				var formData = $("#frm_user_area").serializeArray();
				//console.log(formData);
					
				$.ajax({
					type: "POST",
					url: "<?php echo base_url('agents/ajax_add_teamleader'); ?>" ,
					dataType: 'json',
					data: formData,
					beforeSend: function(){
						resp.html('<p class="alert alert-info"><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
					},
					success: function(res) {
						if (res.status == true){
							resp.html('<div class="alert alert-success"><strong>Success! </strong>'+res.msg+'</div>');
							console.log("done");
							$("#frm_user_area")[0].reset();
							window.location.href = "<?php echo site_url("agents/teamleaders");?>"; 
						}else{
							resp.html('<div class="alert alert-danger"><strong>Error! </strong>'+res.msg+'</div>');
							console.log("error");
						}
					},
					error: function(e){
							console.log(e);
						//response.html('<div class="alert alert-danger"><strong>Error!</strong>Please Try again later! </div>');
					}
				});
			}
		});
		
		
		/*get cities from state*/
		$(document).on('change', 'select#leader_id', function() {
			var leader_id = $("#leader_id option:selected").val();
			$("#assign_agents").html("");
			var _this = $( this );
			_this.parent().append('<p class="bef_send"><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
			$.ajax({
				type: "POST",
				url: "<?php echo base_url('agents/get_all_unassigned_teammember_list'); ?>",
				data: { leader_id: leader_id } 
			}).done(function(data){
				//console.log(data);
				$(".bef_send").hide();
				$("#assign_agents").html(data);
			}).error(function(){
				alert("Error! Please try again later!");
			});
		});
	});
</script>