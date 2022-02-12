	<div class="page-content-wrapper">
		<div class="page-content">

	  <div class="panel-body"> 
	  		<?php $message = $this->session->flashdata('success'); 
		if($message){ echo '<span class="help-block help-block-success">'.$message.'</span>'; }
		?>
		<!--error message-->
		<?php $err = $this->session->flashdata('error'); 
		if($err){ echo '<span class="help-block help-block-error2 red">'.$err.'</span>';}
		?>
		
	 	
		<div class="portlet box blue">
			<div class="portlet-title">
				<div class="caption">
					<?php if(isset($id)){echo'<i class="fa fa-users"></i> Edit Promotion Details'; } else{echo'<i class="fa fa-users"></i> Promotion Details' ; }?>			
					</div> 
					<a class="btn btn-success pull-right" href="<?php echo site_url("flipbook/promotion"); ?>" title="Back">Back</a>
			</div>
		</div>
	  <div class="col-md-8">
		<form role="form" id="flipbook" method="post" action="<?Php echo base_url('flipbook/add_promotion'); ?>" enctype="multipart/form-data">
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label class="control-label">Promotion Name*</label>
							<input type="text" class="form-control"  name="promotion_name" value="<?php if(isset($pro[0]->promotion_name)){ echo $pro[0]->promotion_name;} ?>" placeholder="Title of the Promotion">
					</div>
				</div>
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label">State*</label>
					<select name="state" required class="form-control" id="state" >
					<option value="">Select state</option>
					<?php $states = get_indian_state_list();
						  foreach ($states as $state){
						  $selected =  $pro[0]->state == $state->id ? "selected=selected" : "";
						  echo "<option ". $selected ." value='".$state->id . "'>".$state->name ."</option>";} ?>
					</select>
					</div>
				</div>
				
				<div class="col-md-6">
					<div id ="city_list">
						<div class="form-group">
							<label class="control-label">City*</label>
							<select name="city"  class="form-control city"  id="city"></select>
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<div id ="city_list">
						<div class="form-group">
							<label class="control-label">Place*</label>
							<input type="text" required name="place" value="<?php if(isset($pro[0]->area)){echo $pro[0]->area;} ?>" class="form-control" placeholder="Promotion  Places" />
						</div>
					</div>
				</div>
				 
				 	<div class="col-md-12">
					<div id ="city_list">
						<div class="form-group">
							<input class="btn btn-primary" type='submit' name='submit'>	
						</div>
					</div>
					</div>
					</div>
				</form>
					
				</div>
			</div>
		</div>
		
		
<script type="text/javascript">
jQuery(document).ready(function($){
		/*get cities from state*/
		$(document).on('change', 'select#state', function() {
			var selectState = $("#state option:selected").val();
			//console.log(selectState);
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
				}); 
				 */

			}).error(function(){
				$("#city_list").html("Error! Please try again later!");
			});
		});
	}); 
</script>
