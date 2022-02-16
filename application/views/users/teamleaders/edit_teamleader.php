<style>select#city,select#state{min-height: 180px;}</style>
<?php if( $leader_data ){ ?>
<div class="page-container">
	<div class="page-content-wrapper">
		<div class="page-content">
			<div class="portlet box blue">
			<div class="portlet-title">
					<div class="caption"><i class="fa fa-user"></i>Edit Team</div>
						<a class="btn btn-success" href="<?php echo site_url("agents/teamleaders"); ?>" title="Back">Back</a>
			</div>
			</div>
			<?php echo $this->session->flashdata('message'); ?>
			<div class="portlet-body">
				<?php /*  if( empty($all_unassigned_sales_agent) ){
					echo "<div class='alert alert-danger'>No agents found</div>";
				}else{  */ ?>
					<form role="form" id="frm_user_area" >
					<div class="col-md-4">
						<div id ="city_list">
							<div class="form-group-2">
								<label class="control-label">Team Name*</label>
								<input type="text" required name="team_name" class="form-control" value="<?php echo isset( $leader_data[0]->team_name ) ? $leader_data[0]->team_name : ""; ?>" placeholder="Team Name" />
							</div>
						</div>
					</div>
					<?php //dump( $assigned_mem ); ?>
					<?php //echo $leader_data[0]->leader_id; ?>
					<?php// dump( $all_unassigned_sales_agent ); ?>
								<?php 
								foreach ($assigned_mem as $user){
									$selected =  $leader_data[0]->leader_id == $user ? "selected=selected" : "";
									echo "<option ". $selected ." value='".$user . "'>" . ucfirst(get_user_name($user)) . "</option>";
								}
								?>
					<div class="col-md-4">
						<div class="form-group-2">
							<label class="control-label">Select Team Leader*</label>
							<select name="leader_id" id="leader_id" required class="form-control">
								<option value="">Select team leader</option>
							</select>		
						</div>
					</div>
					
					<div class="col-md-4">
						<div class="form-group-2">
							<label class="control-label">Assign agents*</label><span style="font-size: 12px; color: red;"> (Ctr + click) for multi select</span> 
							<select name="assign_agents[]" required multiple class="form-control" id="assign_agents" >
								<?php if( isset( $leader_data[0]->assigned_members ) && !empty( $leader_data[0]->assigned_members ) ){
									$ass_mem = explode(",", $leader_data[0]->assigned_members);
									foreach( $ass_mem as $aslead ){
										if( !$aslead ) continue;
										echo "<option selected value='".trim($aslead)."'>" . ucfirst(get_user_name($aslead)) . "</option>";
									}
								} 
								if( $all_unassigned_sales_agent ){
									foreach ($all_unassigned_sales_agent as $user){
										echo "<option value='".$user->user_id . "'>".get_user_name($user->user_id)."</option>";
									}
								}
								?>
								
							</select>
						</div>
					</div>
					<div class="clearfix"></div>
				<hr>
				
				<div class="col-md-12">
					<div class="margiv-top-10">
						<input type="hidden" name="id" id="team_id" value="<?php echo isset( $leader_data[0]->id ) ? $leader_data[0]->id : ""; ?>">
						<button type="submit" class="btn green uppercase add_agent">Update Team</button>
					</div>
				</div>	
				</form><div class="clearfix"></div>
				<div id="addresEd"></div>
				<?php //} ?>
			</div><!-- portlet body -->
		</div>
	<!-- END CONTENT BODY -->
	</div>
</div>
<?php }else{
	redirect(404);
} ?>

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
					url: "<?php echo base_url('agents/ajax_update_teamleader'); ?>" ,
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
			var team_id = $("#team_id").val();
			var _this = $( this );
			_this.parent().append('<p class="bef_send"><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
			$.ajax({
				type: "POST",
				url: "<?php echo base_url('agents/get_all_unassigned_teammember_list'); ?>",
				data: { leader_id: leader_id, team_id: team_id } 
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