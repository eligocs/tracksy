<style>select#city,select#state{min-height: 180px;}</style>
<div class="page-container">
	<div class="page-content-wrapper">
		<?php $message = $this->session->flashdata('success'); 
			if($message){ echo '<span class="help-block help-block-success">'.$message.'</span>'; }
		?>
		<div class="page-content">	<?php  
			if( empty( $views ) ) redirect( "agents/view_assign_area" );
				$view = $views[0];
				$userId = $view->user;
				$stat = !empty($view->state) ? explode(',', $view->state) : "";
				$city_ex = explode(',', $view->city);
				$place = $view->place;
				$cat = explode(',' ,$view->category);
				$id = $view->id;
			?>
			<form role="form" method="post" action="<?php echo site_url('agents/update_assign_user_area/').$id; ?>" >
			<div class="portlet box blue">
			<div class="portlet-title">
					<div class="caption"><i class="fa fa-user"></i>Assign user area </div>
					<a class="btn btn-success" href="<?php echo site_url("agents/assign_area"); ?>" title="Back">Back</a>
				</div>
			</div>
			<div class="portlet-body">
				<div class="col-md-4">
				<div class="form-group-2">
					<label class="control-label">User*</label>
					<select name="user" id="user" class="form-control">	
						<?php 
						$sales_team = $sales_service_team;
						foreach ($sales_team as $user){
						$selected =  $user->user_id == $userId ? "selected=selected" : "";
						echo "<option ". $selected ." value='".$user->user_id . "'>".$user->first_name ." ".$user->last_name ."</option>";
						} ?>
					</select>		
				</div>	
					<div id="error_msg"> </div>
				</div>	
				<div class="col-md-4">
					<div class="form-group-2">
						<label class="control-label">State*</label><span style="font-size: 12px; color: red;"> (Ctr + click) for multi select</span> 
						<select name="state[]" class="form-control" id="state"  multiple="multiple" >
						<?php 
						$states = get_indian_state_list();
						foreach ($states as $state){
							$selected = in_array($state->id,$stat ) ? "selected=selected" : "";					
							echo "<option " . $selected . " value='".$state->id . "'>".$state->name ."</option>";
						} ?>
						</select>
					</div>
				</div>
				<div class="col-md-4">
				<div class="form-group-2">
					<?php 
					//$cities = get_city_list( $stat );
					$already_assigned_city = $this->login_model->check_agents_assigned_city( $view->user );
					$city_html = '';
					if( $stat ){	
						foreach( $stat as $state ){
							// Define state and city array
							$city_list = get_city_list( $state );
							$state_name = get_state_name( $state );
							if( $city_list ){
								$city_html .= "<optgroup label='{$state_name}'>";
								foreach($city_list as $city){
									$selected =  in_array( $city->id , $city_ex)  ? "selected=selected" : "";		
									$disabled = !empty( $already_assigned_city ) && in_array( $city->id, $already_assigned_city ) ? "disabled=disabled" : "";
									$city_html .= "<option {$disabled} {$selected} value={$city->id}>{$city->name}</option>";
								}
								$city_html .= "</optgroup>";
							}else{
								$city_html .= '<option value="">Other City!</option>';
							}
						}	
					}
					?>
					<label class="control-label">City*</label><span style="font-size: 12px; color: red;"> (Ctr + click) for multi select</span> 
					<select name="city[]" multiple="multiple" id="city"  class="form-control city" >
						<?php echo $city_html; ?>
					<?php /*if( $cities ){
						foreach ($cities as $c){
							$disabled = !empty( $already_assigned_city ) && in_array( $c->id, $already_assigned_city ) ? "disabled=disabled" : "";
							$selected = in_array( $c->id , $city) ? "selected=selected" : "";					
							echo "<option {$disabled} {$selected} value={$c->id}>{$c->name}</option>";
						} ?>
					<?php } */ ?>	
					</select>
				</div>
				</div> 
				
				<div class="col-md-3">
					<div id ="city_list">
						<div class="form-group-2">
							<label class="control-label">Place*</label>
							<input type="text" name="place" class="form-control" value="<?php echo $view->place; ?>" placeholder="Place" />
						</div>
					</div>
				</div>
				
				<div class="col-md-4">
				<div class="form-group-2">
					<label class="control-label">Assign Category</label>
					<select name="category[]" class="form-control">
					
					<?php 
					$categories = get_all_categories();
					
						foreach ($categories as $category){
							$selected = in_array( $category->id , $cat) ? "selected=selected" : "";
							echo "<option ". $selected ." value='".$category->id . "'>".$category->category_name ."</option>";
						} 
						?>
					</select>
				</div>
				</div>
				<div class="clearfix"></div>
			<hr>
			<div class="col-md-12">
				<div class="margiv-top-10">
					<input type="submit" id="button" class="btn green uppercase add_agent" />
					<input type="hidden" id="user_id" class="" value="<?php echo $view->user; ?>" />
					<input type="hidden" id="assigned_city" class="" value="<?php echo $view->city; ?>" />
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
 if(user !== ""){$.ajax({
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
		var user = $('#user_id').val();
		console.log( user );
		$(document).on('change', 'select#state', function() {
			//var selectState = $("#state option:selected").val();
			var selectState = $('#state').val();
			var assigned_city = $('#assigned_city').val();
			//console.log(selectState);
			$("#city").html("");
			//$("#city").multiSelect( 'refresh' );
			
			var _this = $( this );
			
			_this.parent().append('<p class="bef_send"><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
			$.ajax({
				type: "POST",
				url: "<?php echo base_url('marketing/cityListByStateIdMulti'); ?>",
				data: { state: selectState, user_id : user, assigned_city: assigned_city } 
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