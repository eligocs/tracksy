<div class="page-container customer_content">
	<div class="page-content-wrapper">
		<div class="page-content">
			<?php //echo get_country_name(101);	?>
			<div class="portlet box blue">
			<div class="portlet-title">
				<div class="caption"><i class="icon-plus"></i>All State Codes</div>
				<a class="btn btn-success" href="<?php echo site_url("hotels"); ?>" title="Back">Back</a>
			</div>
			</div>
			
			<form role="form" id="addHotel" enctype="multipart/form-data">
			
			<div class="portlet-body">
			<div class="row">
			
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label">Select Country*</label>
					<select required name="state_id" class="form-control state" id='state'>
						<option value="">Select state</option>
						<?php $state_list = get_indian_state_list(); 
						if( $state_list ){
							foreach($state_list as $state){
								echo "<option value={$state->id}>{$state->name} < Code : {$state->id} ></option>";
							}
						} ?>
					</select>
				</div>
			</div>
			<div class="col-md-4">
				<label>City with code</label> 
				<select required name="hotelcity" class="form-control city">
					<option value="">Select City</option>
				</select>
			</div>
				
				
				</div> <!-- row -->
			</div><!-- portlet body -->
			</div> <!-- portlet -->
		</div>
	<!-- END CONTENT BODY -->
	</div>

<script type="text/javascript">
 jQuery(document).ready(function($){
		$(document).on('change', 'select.state', function() {
			var selectState = $(".state option:selected").val();
			var _this = $(this);
			
			_this.parent().append('<p class="bef_send"><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
			$.ajax({
				type: "POST",
				url: "<?php echo base_url('hotels/city_with_codes'); ?>",
				data: { state: selectState } 
			}).done(function(data){
				$(".bef_send").hide();
				$(".city").html(data);
			}).error(function(){
				
			});
		});
}); 
</script>
