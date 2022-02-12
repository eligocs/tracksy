<div class="page-container">
	<div class="page-content-wrapper">
		<div class="page-content">
			<div class="portlet box blue">
			<div class="portlet-title">
					<div class="caption"><i class="fa fa-user"></i>Add user</div>
					<a class="btn btn-success" href="<?php echo site_url("marketing"); ?>" title="Back">Back</a>
				</div>
			</div>
			<div class="portlet-body">
			<?php if( $views ){ ?>
			<form role="form" id="addUser">
				<?php foreach( $views as $view ){ ?>
				<div class="col-md-4">	
					<div class="form-group">
						<label class="control-label">Choose Category*</label>
							<select name="cat_id" required  class="form-control">
							<option value="">Select Category</option>
								<option value="<?php echo $view->category;?>"><?php echo get_category_name($view->category );?></option>
						</select>
					
					</div>
				</div>
				<?php } ?>		
				<div class="col-md-4">	
				<div class="form-group">
					<label class="control-label">Full Name*</label>
					<input  type="text" required placeholder="Full Name" name="name" class="form-control" value="" /> 
				</div>
				</div>
				
				<div class="col-md-4">
				<div class="form-group">
					<label class="control-label">Email Id*</label>
					<input type="email" required placeholder="Email Id" name="email_id" class="form-control" value="" /> 
				</div>
				</div>
				
				<div class="col-md-4">
				<div class="form-group">
					<label class="control-label">Contact Number*</label>
					<input type="number" required placeholder="Contact Number" name="contact_number" class="form-control" value="" /> 
				</div>
				</div>
				
				
				<div class="col-md-4">
				<div class="form-group">
					<label class="control-label">Whats App Number</label>
					<input  type="number"  placeholder="Whats App Number" name="whats_app_number" class="form-control" value="" /> 
				</div>
				</div>
				
				
				<div class="col-md-4">
				<div class="form-group">
					<label class="control-label">Business Name*</label>
					<input  type="text" required placeholder="Business Name" name="company_name" class="form-control" value="" /> 
				</div>
				</div>
				
				<div class="col-md-4">
					<label class="control-label">Address( State )*</label>
					<div class="form-group">
						<select name='state' required class='form-control' id='state'>
							<option value="">Select State</option>
							<?php if( !empty( $view->state ) ){
								$state_ex = explode( "," , $view->state );
								foreach( $state_ex as $state  ){
									echo "<option value={$state}>" . get_state_name($state). "</option>";
								}
							} ?>
						</select>
					</div>
				</div>
				
				<div class="col-md-4">
					<div id ="city_list">
						<div class='form-group'>
						<label>City*:</label>
						<select required name='city' class='form-control city'>
							<option value="">Select City</option>
							<?php /* $city = explode(',',$view->city); 
							if( $city ){
								for($i=0; $i < count($city); $i++){
									$city_name = get_city_name($city[$i]);												
									echo '<option value='.$city[$i].'>'.$city_name.'</option>';
								}
							} */ ?>
						</select>
						</div>
					</div>
				</div>
				<div class="col-md-4">
				<label class="control-label">Place</label>
					<div class="form-group">
						<input  type="text" id="place" placeholder="Place" name="place" class="form-control" value="" /> 
					</div>
				</div>
				
			
			<div class="clearfix"></div>
			<hr>
			<div class="col-md-12">
				<div class="margiv-top-10">
					<button type="submit" class="btn green uppercase add_user">Add User</button>
				</div>
			</div>
			
				<div class="clearfix"></div>
				<div id="addresEd"></div>		
			</form>
				
			<?php }else{
				echo "No area assign to you.Please Contact your manager.";
			} ?>
			</div><!-- portlet body -->
			</div> <!-- portlet -->
			
		</div>
	<!-- END CONTENT BODY -->
	</div>
<!-- Modal -->
 </div>
<script type="text/javascript">
jQuery(document).ready(function($){
	var form = $("#addUser");
	var ajaxReq;
	$("#addUser").validate({
		rules: {
			
			name: {
			  required: true,
			},
			company_name: {
			  required: true,
			},

		},
		submitHandler: function(form) {
			var resp = $("#addresEd");
			var formData = $("#addUser").serializeArray();
			console.log(formData);
			//console.log(formData);
				if (ajaxReq) {
					ajaxReq.abort();
				}
				ajaxReq = $.ajax({
				type: "POST",
				url: "<?php echo base_url('Marketing/ajaxAdd_m_user'); ?>" ,
				dataType: 'json',
				data: formData,
				beforeSend: function(){
					resp.html('<p><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
				},
				success: function(res) {
					if (res.status == true){
						resp.html('<div class="alert alert-success"><strong>Success! </strong>'+res.msg+'</div>');
						//console.log("done");
						$("#addUser")[0].reset();
						//window.location.href = "<?php echo site_url("marketing");?>"; 
						window.location.href = "<?php echo site_url("marketing/view/");?>" + res.insert_id; 
					}else{
						resp.html('<div class="alert alert-danger"><strong>Error! </strong>'+res.msg+'</div>');
						console.log(res.msg);
					}
				},
				error: function(e){
						console.log(e);
					//response.html('<div class="alert alert-danger"><strong>Error!</strong>Please Try again later! </div>');
				}
			});
			return false;
		}
	});	
}); 
</script>
<script type="text/javascript">
	jQuery(document).ready(function(){
		/*get cities from state*/
		$(document).on('change', 'select#state', function() {
			var selectState = $("#state option:selected").val();
			var _this = $(this);
			console.log(selectState);
			$("#place").val("");
			_this.parent().append('<p class="bef_send"><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
			$.ajax({
				type: "POST",
				url: "<?php echo base_url('marketing/assigned_city_agent_by_state_id'); ?>",
				data: { state: selectState } 
			}).done(function(data){
				$(".bef_send").hide();
				$(".city").html(data);
				$(".city").removeAttr("disabled");
			}).error(function(){
				$("#city_list").html("Error! Please try again later!");
			});
		});
	});
</script>
