<style>select#city,select#state{min-height: 180px;}</style>
<div class="page-container">
	<div class="page-content-wrapper">
		<div class="page-content">
			<form role="form" id="frm_user_area" method="post" action="<?php echo site_url('agents/assign_user_area'); ?>" >
			<div class="portlet box blue">
			<div class="portlet-title">
					<div class="caption"><i class="fa fa-user"></i>Assign user area </div>
					<a class="btn btn-success" href="<?php echo site_url("agents/view_assign_area"); ?>" title="Back">Back</a>
				</div>
			</div>
			<?php echo $this->session->flashdata('message'); ?>
			
			<div class="portlet-body">
			
				<div class="col-md-4">
				<div class="form-group-2">
					<label class="control-label">User*</label>
					
					<select name="user" id="user" required class="form-control">
						<option value="">Select user</option>
					<?php 
						//$sales_team = get_all_sales_team_agents();
						foreach ($sales_service_team as $user){
							echo "<option ". $selected ." value='".$user->user_id . "'>".$user->first_name ." ".$user->last_name ."</option>";
						}
					?>
					</select>		
				</div>	
				<div id="error_msg"> </div>
				</div>
				
				<div class="col-md-4">
					<div class="form-group-2">
						<label class="control-label">State*</label><span style="font-size: 12px; color: red;"> (Ctr + click) for multi select</span> 
						<select name="state[]" required multiple class="form-control" id="state" >
							<?php 
							$states = get_indian_state_list();
							foreach ($states as $state){
								echo "<option ". $selected ." value='".$state->id . "'>".$state->name ."</option>";
							} ?>
						</select>
					</div>
				</div>
				
				<div class="col-md-4">
					<div id ="city_list">
						<div class="form-group-2">
							<label class="control-label">city*</label><span style="font-size: 12px; color: red;"> (Ctr + click) for multi select</span> 
							<select name="city[]" required class="form-control city" multiple id="city" >
							
							</select>
						</div>
					</div>
				</div>
				<div class="clearfix"></div>
				<div class="col-md-4">
					<div id ="city_list">
						<div class="form-group-2">
							<label class="control-label">Place*</label>
							<input type="text" name="place" class="form-control" placeholder="Place" />
						</div>
					</div>
				</div>
				
				<div class="col-md-4">
				<div class="form-group-2">
					<label class="control-label">Assign Category*</label>
					<select name="category[]" required class="form-control">
					
					<?php 
					$categories = get_all_categories();
						foreach ($categories as $category){
							echo "<option ". $selected ." value='".$category->id . "'>".$category->category_name ."</option>";
						} ?>
					</select>
				</div>
				</div>
				<div class="clearfix"></div>
			
			<hr>
			<div class="col-md-12">
				<div class="margiv-top-10">
					<input type="hidden" name="added_by" value="<?php echo $user_id; ?>">
					<input type="submit" class="btn green uppercase add_agent" id='button'/>
				</div>
			</div>	
			</form>
			<div id="addresEd"></div>		
			
			</div><!-- portlet body -->

		</div>
	<!-- END CONTENT BODY -->
	</div>
</div>
<!-- Modal -->
<style>select option:disabled {color:red;}</style>
<script type="text/javascript">
jQuery(document).ready(function($){
 $('#user').change(checkagent);
 $("#frm_user_area").validate();
	
});

function checkagent(){
 var user = $('#user').val();
 if( user !== "" ){$.ajax({
   type: "post",
   url: "<?php echo  base_url('agents/checkagent'); ?>",
   cache: false,    
   data:{user:user},
   success: function(response)
   {
	   console.log(response);
		if(response == 0){
			$('#error_msg').html("<strong style='color: red'>User Already  Assigned !.</strong>");      
			document.getElementById('button').disabled = true;      
		}
		else{
			$('#error_msg').html("<strong style='color: green'>User not  Assigned !.</strong>");      
			document.getElementById('button').disabled = false;      

		}  
    }
   });
 }
} 
</script>
<script type="text/javascript">
	jQuery(document).ready(function(){
		/*get cities from state*/
		$(document).on('change', 'select#state', function() {
			//var selectState = $("#state option:selected").val();
			var selectState = $('#state').val();
			
			console.log(selectState);
			$("#city").html("");
			//$("#city").multiSelect( 'refresh' );
			
			var _this = $( this );
			_this.parent().append('<p class="bef_send"><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
			$.ajax({
				type: "POST",
				url: "<?php echo base_url('marketing/cityListByStateIdMulti'); ?>",
				data: { state: selectState, user_id: "" } 
			}).done(function(data){
				//console.log(data);
				$(".bef_send").hide();
				$(".city").html(data);
				$(".city").removeAttr("disabled");
				//City multiselect
			/* 	$('#city').multiselect({
					columns: 2,
					placeholder: 'Select City',
					search: true,
					searchOptions: {
						'default': 'Search City'
					},
					selectAll: true
				}); */
				

			}).error(function(){
				$("#city_list").html("Error! Please try again later!");
			});
		});
	});
</script>