<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>Trak Itinerary </title>
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url();?>site/assets/css/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url();?>site/assets/css/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url();?>site/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url();?>site/assets/css/plugins.min.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url();?>site/assets/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
	<link rel="shortcut icon" href="favicon.ico" />
	
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
					<?php $cab_booking = $booking_details[0];  ?>
					<?php if($cab_booking){ ?>
						<div class="portlet box blue">
							<div class="portlet-title">
								<div class="caption">Welcome: <?php echo get_transporter_name($cab_booking->transporter_id); ?></div>
							</div>
						</div>
						<form id="confirmForm">
							<input type="hidden" id="sec_key" name="sec_key" value="<?php echo $sec_key; ?>">
						<!-- Status = 9 For Approve-->
						<?php if( $status == 9 ){ ?>
							<h3 class="approve_heading">Approve</h3>
								<?php echo "<strong>Booking Date : </strong> " . $cab_booking->picking_date . " To " . $cab_booking->droping_date; ?>
								<?php echo "<br><strong>Vehicle Category: </strong> " . get_car_name($cab_booking->cab_id); ?>
								<?php echo "<br><strong>Total Cabs: </strong> " . $cab_booking->total_cabs; ?>
								<div class="form-group feedback">
									<label class="control-label">Please Enter Approval Note Below:</label>
									<textarea required placeholder="eg. Your booking is approved." name="booking_note" class="form-control"/></textarea> 
								</div>
						<!-- Status = 8 For Decline-->
						<?php }elseif( $status == 8 ){ ?>
						<h3 class="decline_heading">Decline</h3>
							<?php echo "<strong>Booking Date : </strong> " . $cab_booking->picking_date . " To " . $cab_booking->droping_date; ?>
								<?php echo "<br><strong>Vehicle Category: </strong> " . get_car_name($cab_booking->cab_id); ?>
								<?php echo "<br><strong>Total Cabs: </strong> " . $cab_booking->total_cabs; ?>
								<div class="form-group">
									<label class="control-label">Please Enter Decline Reason</label>
									<textarea required placeholder="eg. No rooms availble." name="booking_note" class="form-control"/></textarea> 
								</div>
							
							<?php } ?>
								<input type="hidden" value="<?php echo $status; ?>" name="booking_status" id="booking_status">	
								<input type="hidden" value="<?php echo $cab_booking->iti_id;?>" name="iti_id" id="iti_id">
								<input type="hidden" value="<?php echo $cab_booking->id;?>" name="id" id="id">
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
			</div>
			<div class="clearfix"></div>
			<div class="copyright text-center"> <?php echo date("Y"); ?> © Track Itinerary.</div>
		</div>
	</div>
<script src="<?php echo base_url();?>site/assets/js/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>site/assets/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>site/assets/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>site/assets/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url();?>site/assets/js/bootstrap-multiselect.js"></script>
<script type="text/javascript">
jQuery(document).ready(function($){
	/* Booking Approve */
		var ajaxReq;
	$("#confirmForm").validate({
		submitHandler: function(form) {
			var resp = $(".response");
			var sec_key = $("#sec_key").val();
			var formData = $("#confirmForm").serializeArray();
			/*console.log(formData);*/
			if (ajaxReq) {
						ajaxReq.abort();
					}
					ajaxReq = 	$.ajax({
				type: "POST",
				url: "<?php echo base_url('confirm/update_cab_booking_status'); ?>" ,
				dataType: 'json',
				data: formData,
				beforeSend: function(){
					resp.html('<div class="alert alert-success"><i class="fa fa-spinner fa-spin"></i> Please wait...</div>');
				},
				success: function(res) {
					if (res.status == true){
						resp.html('<div class="alert alert-success"><strong>Success! </strong>'+res.msg+'</div>');
						console.log("done");
						window.location.href = "<?php echo site_url('confirm/thankyou'); ?>?key=" + sec_key ; 
					}else{
						resp.html('<div class="alert alert-danger"><strong>Error! </strong>'+res.msg+'</div>');
						console.log("error");
					}
				},
				error: function(e,eType, eee){
						console.log(eType);
					resp.html('<div class="alert alert-danger"><strong>Error!</strong>Please Try again later! </div>');
				}
			});
			return false;
		}
	});
	
});
</script>
</body>
</html>