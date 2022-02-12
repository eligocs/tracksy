<div class="page-container">
	<div class="page-content-wrapper">
		<?php $message = $this->session->flashdata('success'); 
			if($message){ echo '<span class="help-block help-block-success">'.$message.'</span>';}
		?>
		<div class="page-content">
		<?php if($hotels){ 	$hotel = $hotels[0]; ?>
			<div class="portlet box blue">
				<div class="portlet-title">
					<div class="caption"><i class="fa fa-users"></i>Hotel Name: <strong><?php  echo $hotel->hotel_name; ?></strong></div>
					<a class="btn btn-success" href="<?php echo site_url("hotels"); ?>" title="Back">Back</a>
				</div>
			</div>
			<form role="form" id="editHotel" enctype="multipart/form-data">
				<div class="form-group col-md-3">
					<label class="control-label">Hotel Name*:</label>
					<input type="text" placeholder="Hotel Name" name="name" class="form-control" value="<?php echo $hotel->hotel_name; ?>"/> 
				</div>
				<div class="form-group col-md-3">
					<label class="control-label">Hotel Country*: </label>
					<select name="country" class="form-control country">
					<option value="">Select Country</option>
						<?php $country = get_country_list();
						if($country){ 
							foreach( $country as $c ){ ?>
								<option value="<?php echo $c->id;?>" <?php if ($c->id == $hotel->country_id ) { ?> selected="selected" <?php } ?> > <?php echo $c->name ; ?></option>
							<?php }
						}
						?>
					</select>
				</div>
				<div id ="state_list" class="col-md-3">
					<div class="form-group">
						<label class="control-label">Hotel State*: </label>
						<select name="state" class="form-control state">
							<option value="">Select State</option>
							<?php $states = get_state_list($hotel->country_id);
							if($states){
								foreach( $states as $state ){ ?>
									<option value="<?php echo $state->id;?>" <?php if ($state->id == $hotel->state_id ) { ?> selected="selected" <?php } ?> > <?php echo $state->name ; ?></option>
								<?php }
							}
							?>
						</select>
					</div>
				</div>	
				<div id ="city_list" class="col-md-3">
					<div class="form-group">
						<label class="control-label">Hotel City*: </label>
						<select name="city" class="form-control city">
							<option value="">Select City</option>
							<?php $cities = get_city_list($hotel->state_id);
							if($cities){
								foreach( $cities as $city ){ ?>
									<option value="<?php echo $city->id;?>" <?php if ($city->id == $hotel->city_id ) { ?> selected="selected" <?php } ?> > <?php echo $city->name ; ?></option>
									
								<?php }
							}
							?>
						</select>
					</div>
				</div>
				<div class="clearfix"></div>
				<div class="form-group col-md-3">
					<label class="control-label">Hotel Category*</label>
					<select name="category" class="form-control cat">
						<option value="">Select Category</option>
						<?php $hotels_cat = hotel_categories();
						if($hotels_cat){
							foreach( $hotels_cat as $cat ){ ?>
								<option value="<?php echo $cat->star_id;?>" <?php if ($hotel->hotel_category == $cat->star_id ) { ?> selected="selected" <?php } ?> > <?php echo $cat->name ; ?></option>
							<?php }
						}
						?>
					</select>
					
				</div>
				
				<div class="form-group col-md-3">
					<label class="control-label">Hotel Email*</label>
					<input id="mulit_email" type="text" placeholder="Email for multi email.eg: hotel@test.com,hotel2@test.com" name="email" class="form-control" value="<?php echo $hotel->hotel_email; ?>"/> 
				</div>
				<div class="form-group col-md-3">
					<label class="control-label" >Hotel Address*</label>
					<textarea name="address" class="form-control"  placeholder="Hotel Full Address"><?php echo $hotel->hotel_address; ?></textarea>
				</div>
				
				<div class="form-group col-md-3">
					<label class="control-label">Hotel Contact Number*</label>
					<input type="text" placeholder="Hotel Phone Number" name="contact" class="form-control" value="<?php echo $hotel->hotel_contact; ?>"/> 
				</div>
				<div class="clearfix"></div>
				<div class="form-group col-md-3">
					<label class="control-label">Hotel Website</label>
					<input type="text" placeholder="Website Link" name="website" class="form-control" value="<?php echo $hotel->hotel_website; ?>"/> 
				</div>
				
				<div class="form-group col-md-4">
					<label class="control-label">Upload Hotel Image (optional)</label>
					<div class="form-group">
						<div class="fileinput fileinput-new" data-provides="fileinput">
							<div class="fileinput-new thumbnail" style="width: 100%; height: 150px;">
							<?php $h_image = site_url() . 'site/images/hotels/' . $hotel->hotel_image; ?>
								<img alt="" class="img-responsive editSlide-image" src="<?php echo $h_image; ?>" />
							</div>
							<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
							<div>
								<span class="btn default btn-file">
									<span class="fileinput-newa"> Click here to add/change hotel image </span>
									<span class="fileinput-existss"> </span>
									<input id="image_url" type="file" name="image_url" value=""> </span>
								<a href="javascript:;" class="btn default fileinput-exists" data-dismiss="fileinput"> Remove </a>
							</div>
						</div>
						<div class="clearfix margin-top-10">
							<span class="label label-danger">NOTE! </span>&nbsp;&nbsp;&nbsp;
							<span class='red'> Image size not bigger then 2 MB and dimensions(650px X 250px).</span>
						</div>
					</div>
				</div>
				
				<div class="clearfix"></div>
				<hr>
				<div class="margiv-top-10">
					<input type="hidden" name="id" id="hotel_id" value="<?php echo $hotel->id;?>"/>
					<button type="submit" class="btn green uppercase edit_hotel">Update Hotel</button>
				</div>
			</form>
			<div id="editHotelRes"></div>		
		<?php }else{
			echo "Invalid Hotel id";
		}?>
		</div>
	<!-- END CONTENT BODY -->
	</div>
<!-- Modal -->
 </div>


<script type="text/javascript">
jQuery(document).ready(function($){
	  jQuery.validator.addMethod("multiemail", function (value, element) {
        if (this.optional(element)) {
            return true;
        }
        var emails = value.split(','),
            valid = true;
        for (var i = 0, limit = emails.length; i < limit; i++) {
            value = emails[i];
            valid = valid && jQuery.validator.methods.email.call(this, value, element);
        }
        return valid;
    },  "Separate email with a comma without spaces.");
	/*get states from country*/
    $("select.country").change(function(){
        var selectCountry = $(".country option:selected").val();
		var _this = $(this);
		_this.parent().append('<p class="bef_send"><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
		$(".bef_send").hide();
		//console.log(selectCountry);
		$.ajax({
            type: "POST",
            url: "<?php echo base_url('AjaxRequest/hotelStateData'); ?>",
            data: { country: selectCountry } 
        }).done(function(data){
            $("#state_list").html("<div class='form-group'><label>State:</label><select name='state' class='form-control state'>" + data + "</select></div>");
		}).error(function(){
			$("#state_list").html("Error! Please try again later!");
		});
    });
	/*get cities from state*/
	$(document).on('change', 'select.state', function() {
		var _this = $(this);
		_this.parent().append('<p class="bef_send"><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
		$(".bef_send").hide();
        var selectState = $(".state option:selected").val();
	//	console.log(selectState);
		$.ajax({
            type: "POST",
            url: "<?php echo base_url('AjaxRequest/hotelCityData'); ?>",
            data: { state: selectState } 
        }).done(function(data){
            $("#city_list").html("<div class='form-group'><label>City:</label><select name='city' class='form-control city'>" + data + "</select></div>");
		}).error(function(){
			$("#city_list").html("Error! Please try again later!");
		});
    });
}); 

jQuery(document).ready(function($){
	var ajaxReq;
	var form = $("#editHotel");
	var resp = $("#editHotelRes");
	var hotel_id = $("#hotel_id").val();
	form.validate({
		rules: {
			state: {required: true},
			country: {required: true},
			city: {required: true},
			category: {required: true},
			name: {required: true},
			address: {required: true},
			contact: {required: true},
			email: {
				required: true,
				multiemail:true
			}
		}
	});
	
	$(document).on("submit",'#editHotel', function(e){
		e.preventDefault();
		var formData = $("#editHotel").serializeArray();
		//console.log(formData);
		if (ajaxReq) {
			ajaxReq.abort();
		}
		ajaxReq = $.ajax({
			type: "POST",
			url: "<?php echo base_url('hotels/ajax_edit_hotel'); ?>" ,
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
					window.location.href = "<?php echo site_url();?>hotels/view/" + hotel_id; 
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
	
	/* form.validate({
		rules: {
			state: {required: true},
			country: {required: true},
			city: {required: true},
			category: {required: true},
			name: {required: true},
			address: {required: true},
			contact: {required: true},
			email: {
				required: true,
				multiemail:true
			}
		},
		submitHandler: function(form) {
			var formData = $("#editHotel").serializeArray();
			//console.log(formData);
			$.ajax({
				type: "POST",
				url: "<?php echo base_url('AjaxRequest/editHotel'); ?>" ,
				dataType: 'json',
				data: formData,
				beforeSend: function(){
					resp.html('<p><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
				},
				success: function(res) {
					if (res.status == true){
						resp.html('<div class="alert alert-success"><strong>Success! </strong>'+res.msg+'</div>');
						console.log("done");
						$("#editHotel")[0].reset();
						window.location.href = "<?php echo site_url("hotels");?>"; 
						window.location.href = "<?php echo site_url();?>/hotels/view/" + hotel_id; 
					}else{
						resp.html('<div class="alert alert-danger"><strong>Error! </strong>'+res.msg+'</div>');
						console.log("error");
					}
				},
				error: function(e){
						//console.log(e);
					resp.html('<div class="alert alert-danger"><strong>Error!</strong>Please Try again later! </div>');
				}
			});
			return false;
		}
	});	 */
}); 
</script>
