<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>Track Itinerary</title>
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url();?>site/assets/css/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url();?>site/assets/css/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url();?>site/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url();?>site/assets/css/plugins.min.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url();?>site/assets/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
	<link rel="shortcut icon" href="favicon.ico" />
	<script src="<?php echo base_url();?>site/assets/js/jquery.min.js" type="text/javascript"></script>
	<style>
	.page-content {width: 800px;
    padding: 20px;
    border: 1px dashed #b7b7b7;
    margin: 20px auto 0;
    box-shadow: 0 8px 107px 0 rgba(0,0,0,.2), 0 6px 155px 0 rgba(0, 0, 0, 0);}
	
	.logo{margin-bottom: 30px; background: #3598dc; padding:10px;}
	.logo img {width: 200px;}

	.feedback{margin:20px 0;}
	.error {color: red; font-size: 13px;}
	.copyright.text-center {margin: 20px 0;}
	
td.disabled.day {
    color: #ccc;
}

.datepicker .day {font-weight: 500!important;}

th.datepicker-switch {
    color: #fff !important;
    text-align: center;
}

.datepicker-days thead tr:nth-child(1),
.datepicker-days thead tr:nth-child(2) {
    background: #364150;
    color: #fff !important;
}
.datepicker-days thead tr:nth-child(2) i{color:#fff;}

.datepicker.dropdown-menu {
    box-shadow: 0px 0px 100px rgba(0, 0, 0, 0.34);
}
	.postpone-label {margin-top: 30px;}
	
	</style>
	
	
</head>
<body class="status">
	<div class="content">
		<div class="container">
			<div class="page-content">
			<div class="logo text-center"><img src="<?php echo site_url() ?>site/images/trackv2-logo.png" alt="Track Itinerary"></div>
				<div class="iti_status">	
					<?php $iti = $itinerary_details[0];  ?>
					<?php if($iti){ ?>
						<div class="portlet box blue">
							<div class="portlet-title">
								<div class="caption">Welcome: <?php echo $iti->customer_name; ?></div>
							</div>
						</div>
						<form id="confirmForm">
							<input type="hidden" name="sec_key" id="sec_key" value="<?php echo $sec_key; ?>">
						<!-- Status = 9 For Approve-->
						<?php if( $status == 9 ){ ?>
							<h3 class="approve_heading">Approve</h3>
								<?php // echo "<strong>Tour Date : </strong> " . $iti->travel_date . " To " . $iti->travel_end_date; ?>
								<?php $rates_meta = unserialize($iti->rates_meta); 
									$count_rates_meta = count( $rates_meta ); ?>
									<div class="table-responsive">
										<table class="table table-bordered">
											<thead class="thead-default">
												<tr>
													<th> Hotel Category</th>
													<th> Car Category</th>
													<th> Meal Plan</th>
													<th> Total Package Cost</th>
												</tr>
											</thead>
											<tbody>
											<?php 
											if( $count_rates_meta > 0 ){
												for ( $i = 0; $i < $count_rates_meta; $i++ ) {
													$j = $i+1;
													$hotel_cat = $rates_meta[$i]["rates_hotel_cat"];
													$car_category = $rates_meta[$i]["rates_car_cat"];
													$meal_plan = $rates_meta[$i]["rates_meal_plan"];
													$package_cost = $rates_meta[$i]["rates_package_cost"];
													echo "<tr><td><input required id=hotel_{$j} class='pck_cost' type='radio' name='iti_note[pack_cat]' value='". $hotel_cat ."'> <label for=hotel_{$j}>" . $hotel_cat . "</label></td>
													<input class='car_cat_v' type='hidden' value='". $car_category ."'>
													<input class='m_plan_v' type='hidden' value='". $meal_plan ."'>
													<input class='pack_cost_v' type='hidden' value='". $package_cost ."'>
													<td class='carcat'>" . get_car_name($rates_meta[$i]["rates_car_cat"]) ."</td>
													<td class='meal_pln'>". $rates_meta[$i]["rates_meal_plan"] ."</td>
													<td class='pk_cost'>". number_format($rates_meta[$i]["rates_package_cost"]) ." /-</td></tr>";
												}	
												echo "<input class='car_cat' type='hidden' name='iti_note[car_category]' value='". $car_category ."'>";
												echo "<input class='m_plan' type='hidden' name='iti_note[meal_plan]' value='". $meal_plan ."'>";
												echo "<input class='pack_cost' type='hidden' name='iti_note[package_cost]' value='". $package_cost ."'>";
											} ?>
										</table>
									</div>										
								
								<div class="form-group feedback">
									<label class="control-label">Please Enter Approval Note Below:</label>
									<textarea required placeholder="Please Enter Note Here" name="iti_note[note]" class="form-control"/></textarea> 
								</div>
								<script type="text/javascript">
									jQuery(document).ready(function($){
										$('input.pck_cost').change(function() {
											var _this = $(this);
											var car_cat = _this.parent().parent().find(".car_cat_v").val();
											var m_plan = _this.parent().parent().find(".m_plan_v").val();
											var pack_cost = _this.parent().parent().find(".pack_cost_v").val();
											$(".car_cat").val(car_cat);
											$(".m_plan").val(m_plan);
											$(".pack_cost").val(pack_cost);
										});
									});
								</script>
						<!-- Status = 8 For Postpone-->
						<?php }elseif( $status == 8 ){  ?>
							<h3 class="post_pone_heading">Postpone</h3>
								<?php // echo "<strong>Tour Date : </strong>" . $iti->travel_date . " To " . $iti->travel_end_date; ?>
								<input type="hidden" id="tour_post_date" value="<?php echo $iti->travel_date; ?>">
								<div class="form-group">
									<label class="control-label postpone-label">Postpone Your Tour Date*</label>
									<div class="input-group input-large date-picker input-daterange" data-date="" data-date-format="dd/mm/yyyy">
										<input required type="text" class="form-control" name="iti_note[post_tour_date]" value="">
										<span class="input-group-addon"> to </span>
										<input required type="text" class="form-control" name="iti_note[post_tour_end_date]" value=""> 
									</div>
								</div>
								<div class="form-group">
									<label class="control-label">Description about Tour</label>
									<textarea required placeholder="Please Enter Tour Other Details." name="iti_note[note]" class="form-control"/></textarea> 
								</div>
						<!-- Status = 7 For Decline-->
						<?php }elseif( $status == 7 ){ ?>
						<h3 class="decline_heading">Decline</h3>
								<div class="form-group">
									<label class="control-label">Please Enter Decline Reason</label>
									<textarea required placeholder="Please Enter Tour Other Details." name="iti_note[note]" class="form-control"/></textarea> 
								</div>
							
						<?php } ?>
								<input type="hidden" value="<?php echo $status; ?>" name="iti_status" id="iti_status">	
								<input type="hidden" value="<?php echo $iti->customer_id?>" name="customer_id" id="cus_id">
								<input type="hidden" value="<?php echo $iti->iti_id?>" name="iti_id" id="iti_id">
								<input type="hidden" value="<?php echo $iti->temp_key?>" name="temp_key" id="temp_key">
								<div class="form-group col-md-12 row">
									<button type="submit" class="btn green uppercase app_iti">Submit</button>
								</div>
								<div class="clearfix"></div>
								<div class="response"></div>
							</form>
					<?php }else{
						echo "Unauthorized User !";
					} ?>		
				</div>
				<div class="clearfix"></div>				
			</div>
			<div class="clearfix"></div>
			<div class="copyright text-center"> <?php echo date("Y"); ?> © Track Track Itinerary.</div>
		</div>
	</div>
<script src="<?php echo base_url();?>site/assets/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>site/assets/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>site/assets/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url();?>site/assets/js/bootstrap-multiselect.js"></script>
<script type="text/javascript">
jQuery(document).ready(function($){
	/* postpone date */
	/* var tour_date = $("#tour_post_date").val();
	console.log( tour_date ); */
	$('.input-daterange').datepicker({startDate: '-1d'});
	
	var ajaxReq;
	/*get states from country*/
    $("select.package_cat").change(function(){
        var select_pack = $(".package_cat option:selected").val();
        var iti_id = $("#iti_id").val();
		var temp_key = $("#temp_key").val();
		var resp = $(".findCity");
		//alert( select_pack );
		$.ajax({
            type: "POST",
			dataType: "json",
            url: "<?php echo base_url('confirm/get_city_data'); ?>",
            data: { package_cat: select_pack, temp_key: temp_key, iti_id: iti_id }, 
       		beforeSend: function(){
				resp.html('<p><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
			},
			success: function(res) {
				resp.hide();
				if (res.status = true ){
					$("#city_list").html("<div class='form-group'><label>Select City:</label><select onchange='fetchHotel(this.value)' id='newcity'  multiple='multiple' name='iti_note[city]' class='form-control city'>" + res.city + "</select></div>");					
					
				}else{
					$("#city_list").html("<div class='form-group'><label>Select City:</label><select  multiple='multiple' name='iti_note[city]' class='form-control city'>" + res.city + "</select></div>");
				}
			},
			error: function(e){
				//console.log(e);
				resp.html('<div class="alert alert-danger"><strong>Error!</strong>Please Try again later! </div>');
			}
		});
	});
	
	
	/* Itinerary Approve */
	$("#confirmForm").validate({
		submitHandler: function(form) {
			var resp = $(".response");
			var sec_key = $("#sec_key").val();
			var formData = $("#confirmForm").serializeArray();
			//console.log(formData);
			if (ajaxReq) {
				ajaxReq.abort();
			}
					ajaxReq = $.ajax({
				type: "POST",
				url: "<?php echo base_url('confirm/update_itinerary_status'); ?>" ,
				dataType: 'json',
				data: formData,
				beforeSend: function(){
					resp.html('<p><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
				},
				success: function(res) {
					if (res.status == true){
						resp.html('<div class="alert alert-success"><strong>Success! </strong>'+res.msg+'</div>');
						/*console.log("done");*/
						location.reload();
						//window.location.href = "<?php echo site_url('confirm/thankyou'); ?>?key=" + sec_key ; 
					}else{
						resp.html('<div class="alert alert-danger"><strong>Error! </strong>'+res.msg+'</div>');
						//console.log("error");
					}
				},
				error: function(e){
						//console.log(e);
					resp.html('<div class="alert alert-danger"><strong>Error!</strong>Please Try again later! </div>');
				}
			});
			return false;
		}
	});
	
});

function fetchHotel(cityId)
{
	if(cityId != "" )
	{
		var cityId=cityId;
		var select_pack = $(".package_cat option:selected").val();
		var iti_id = $("#iti_id").val();
		var temp_key = $("#temp_key").val();
		var resp = $(".findHotel");
		//alert(iti_id);
			 $.ajax({
				type: "POST",
				dataType: "json",
				url: "<?php echo base_url('confirm/get_hotel_data'); ?>",
				data: { cityId: cityId, select_pack,temp_key: temp_key, iti_id: iti_id }, 
				beforeSend: function(){
					resp.html('<p><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
				},
				success:  function(res)
				{ 
					resp.hide();
					if (res.status = true ){						
						$("#hotel_list").html("<div class='form-group'><label>Select Hotel:</label><select name='iti_note[hotel]' class='form-control hotel'>" + res.hotel + "</select></div>");
						console.log("done");						
						
					}else{
						$("#hotel_list").html("<div class='form-group'><label>Select Hotel:</label><select name='iti_note[hotel]' class='form-control hotel'>" + res.hotel + "</select></div>");
						console.log("error" + res.msg);
					}
				},
				error: function(e){
				//console.log(e);
				resp.html('<div class="alert alert-danger"><strong>Error!</strong>Please Try again later! </div>');
			}
		}); 
	}	
}
</script>
</body>
</html>