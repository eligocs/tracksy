<div class="page-container customer_content">
	<div class="page-content-wrapper">
		<div class="page-content">
			<?php //echo get_country_name(101);	?>
			<div class="portlet box blue">
				<div class="portlet-title">
					<div class="caption"><i class="icon-plus"></i>Add Vehicle Rate</div>
					<a class="btn btn-success" href="<?php echo site_url("vehicles/add_tour_rate"); ?>" title="Back">Back</a>
				</div>
			</div>
			
			<form role="form" id="addRates" enctype="multipart/form-data">
				<div class="portlet-body">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label">Select Country*</label>
								<select name="country" class="form-control country">
									<option value="">Choose Country</option>
									<?php $country = get_country_list();
									if($country){
										foreach( $country as $c ){
											echo '<option value="'. $c->id . '">' . $c->name . '</option>';
										}
									}
									?>
								</select>
							</div>
						</div>
						<div class="col-md-6">
						<div id ="state_list"><div class='form-group'><label>State*:</label><select disabled name='state' class='form-control state'><option value="">Select state</option></select></div></div>
						</div>
						<div class="clearfix"></div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label">Package Name* (with duration)</label>
								<input type="text" placeholder="Package Name. Eg: Delhi/Ambala-shimla-manali-chandigarh-delhi/ambala (6 Days)" name="package_name" class="form-control" value=""/> 
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="">Vehicle*:</label>
								<select required name="car_type_sightseen" class="form-control">
									<option value="">Choose Vehicle Category</option>
									<?php $cars = get_car_categories(); 
									if( $cars ){
										foreach($cars as $car){
											$max_per = $car->max_person;
											echo "<option value = {$car->id} >{$car->car_name} ( Max. {$max_per} Person )</option>";
										}
									} ?>
								</select>
							</div>
						</div>
						<div class="clearfix"></div>
					</div> <!-- row -->
					<hr>
					<div class="col-md-12 text-left">
						<div class="margiv-top-10">
							<button type="submit" class="btn green uppercase">Add Vehicle Rate</button>
						</div>
					</div>
					<div class="clearfix"></div>
					<div id="addresEd" class="sam_res"></div>	
				</div><!-- portlet body -->
			</form>
			
			</div> <!-- portlet -->
		</div>
	<!-- END CONTENT BODY -->
	</div>
<!-- Modal -->
 </div>
<script type="text/javascript">
 jQuery(document).ready(function($){
	/*get states from country*/
    $("select.country").change(function(){
        var selectCountry = $(".country option:selected").val();
		var _this = $(this);
		_this.parent().append('<p class="bef_send"><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
		$.ajax({
            type: "POST",
            url: "<?php echo base_url('AjaxRequest/hotelStateData'); ?>",
            data: { country: selectCountry } 
        }).done(function(data){
			$(".bef_send").hide();
            $(".state").html(data);
			$(".state").removeAttr("disabled");
			$(".city").html("<option vlaue=''>select city</option>");

		}).error(function(){
			$("#state_list").html("Error! Please try again later!");
		});
    });
}); 

jQuery(document).ready(function($){
	var ajaxReq;
	var form = $("#addRates");
	$("#addRates").validate();	
	
	$(document).on("submit",'#addRates', function(e){
		e.preventDefault();
		var resp = $("#addresEd");
		var formData = $("#addRates").serializeArray();
		//console.log(formData);
		if (ajaxReq) {
			ajaxReq.abort();
		}
		ajaxReq = $.ajax({
			type: "POST",
			url: "<?php echo base_url('hotels/ajax_add_hotel'); ?>" ,
			data: new FormData(this),
			contentType: false,
			cache: false,
			processData:false,
			beforeSend: function(){
				resp.html('<p><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
			},
			success:function(data){
				console.log(data);
				if( data == "success" ){
					resp.html('<div class="alert alert-success"><strong>Success: </strong> Hotel add successfully!</div>');
					$("#addRates")[0].reset();
				}else{
					resp.html(data);
				}
			},
			error: function(e){
				//console.log(e);
				resp.html('<div class="alert alert-danger"><strong>Error!</strong>Please Try again later! </div>');
			}
		});
		return false;
		
	});	
}); 
</script>
