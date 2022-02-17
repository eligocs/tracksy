<!doctype html/>
<html lang="en">
  <head>
<meta charset="utf-8" />
<title>Checkout | trackitinerary Pvt. Lmt.</title>
<link href="https://fonts.googleapis.com/css?family=Nixie+One" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,900" rel="stylesheet">
<link href="<?php echo base_url();?>site/assets/css/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />	
<link rel="stylesheet" href="<?php echo base_url();?>site/assets/css/style_client_view_new.css">
<link href="<?php echo base_url();?>site/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
 <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url();?>site/images/favicon.ico" /> 
	<style>
		h1.text-center.pnf {
			color: red;
			margin-top: 40px;
			margin-bottom: 10px;
			font-weight: 800;
		}
		.error{ color: red; }
		#checkout_page{
			margin: 0 auto;
			width:80% /* value of your choice which suits your alignment */
		}
		form#frmChkout {
			margin: 50px 5px;
		}
	</style>
</head>
<body>

<div class="content_area">

	<div class="logo">
		<div class="container ">
			<a href="https://www.trackitinerary.org/"><img src="<?php echo base_url();?>site/images/trackv2-logo.png" class="template_logo"></a>
		</div>
	</div>
	
	<div class="container">
		<div class="row">
			<h1 class='text-center pnf'>CHECKOUT!</h1>
			
			<?php if( isset( $iti_link ) && !empty( $iti_link ) ){ ?>
				<div class='text-center'>
					<a class='btn btn-success' target="_blank" href="<?php echo $iti_link; ?>" title='View Itinerary' ><i class='fa fa-eye'></i> View Itinerary</a>
				</div>	
			<?php } ?>
			<!--form errors-->
			<div class='form-validation-errors'>
				<?php echo validation_errors(); ?>
			</div>	
			
			<div id="checkout_page">
				<?php
				//check if error exists
				if( isset( $error ) && !empty( $error ) ){
					echo "<div class='text-center'style='margin-top:20px;'>";
						echo "<div class='alert alert-danger'>{$error}</div>";
					echo "<a href='https://www.trackitinerary.org/' class='btn btn-success'><i class='fa fa-home'></i> Back To Homepage</a> ";
					echo "</div>";
					
				}else{ ?>
					<?php
						//check if expire link exists
						if( isset( $link_expire_date ) && !empty( $link_expire_date ) ){
							$disabled_btn = "";
							$link_expire_date = strtotime($link_expire_date); //gives value in Unix Timestamp (seconds since 1970)
							$current_d = strtotime( date("Y-m-d H:i:s") );
							
							if ( $link_expire_date < $current_d ){
								$disabled_btn = "disabled";
							} 
							
							?>
							<style> 
							#t_countdown{ 
								text-align: center; 
								font-size: 25px; 
							} 
							</style> 
							</head> 
							<body> 
							<p id="t_countdown"></p>
							<script> 
								var deadline = new Date(<?php echo $link_expire_date*1000 ?>).getTime();
								//console.log( date );
								//var deadline = new Date("Jan 5, 2020 15:37:25").getTime(); 
								var x = setInterval(function() { 
									var now = new Date().getTime(); 
									var t = deadline - now; 
									var days = Math.floor(t / (1000 * 60 * 60 * 24)); 
									var hours = Math.floor((t%(1000 * 60 * 60 * 24))/(1000 * 60 * 60)); 
									var minutes = Math.floor((t % (1000 * 60 * 60)) / (1000 * 60)); 
									var seconds = Math.floor((t % (1000 * 60)) / 1000); 
									document.getElementById("t_countdown").innerHTML = "Link Expire in: " + days + "d " 
									+ hours + "h " + minutes + "m " + seconds + "s ";
									//console.log( now );
									if ( t < 0 ) {
										clearInterval(x); 
										document.getElementById("t_countdown").innerHTML = "LINK EXPIRED";
										document.getElementById("checkout_btn").disabled = true;
									}else{
										if( days == 0 && hours == 0 && minutes == 0 && seconds == 0 ){
											alert("LINK HAS BEEN EXPIRED.");
										}
									} 
								}, 1000); 
							</script>
						<?php } ?>	<!--END EXPIRE LINK SECTION-->
						
					<form role="form" id='frmChkout' method="post" action="<?php echo site_url("checkout/generatePaymentRequest"); ?>">
						<input type="hidden" name="sec_key" id="sec_key" value="<?php echo $sec_key; ?>">
						
						<div class="form-group col-xs-10 col-sm-6 col-md-6 col-lg-6">
							<label for="exampleInputEmail1">Itinerary ID</label>
							<input type="text" readonly class="form-control" id="exampleInputEmail1" placeholder="Enter email" value='<?php echo isset($iti_id) ? $iti_id : ""; ?>'>
						</div>
						
						<?php if( isset($link_token) && !empty( $link_token ) ){ ?>
						<div class="form-group col-xs-10 col-sm-6 col-md-6 col-lg-6">
							<label for="exampleInputEmail1">Amount*</label>
							<input type="text" disabled class="form-control"  value='<?php echo isset( $amount ) ? $amount : ""; ?>'>
							<input title="Amount" required tabindex="10" type="hidden" name="TXN_AMOUNT" value="<?php echo isset( $amount ) ? $amount : ""; ?>">
						</div>
						<?php }else{ ?>
							<div class="form-group col-xs-10 col-sm-6 col-md-6 col-lg-6">
								<label for="exampleInputEmail1">Amount*</label>
								<input title="Enter Amount" required tabindex="10" class="form-control" type="number" name="TXN_AMOUNT" value="<?php echo isset( $amount ) ? $amount : ""; ?>">
							</div>
						<?php }  ?>
						<div class="clearfix"></div>
						
						<div class="form-group col-xs-10 col-sm-6 col-md-6 col-lg-6">
							<label for="exampleInputEmail1">Name*</label>
							<input type="text"  required class="form-control"  placeholder="Enter Name" name="customer_name" value="<?php echo isset($customer_name) ? $customer_name : ""; ?>">
						</div>
						
						<div class="form-group col-xs-10 col-sm-6 col-md-6 col-lg-6">
							<label for="exampleInputEmail1">Email address*</label>
							<input type="email" required name="customer_email" class="form-control" placeholder="Enter email" value="<?php echo isset($customer_email) ? $customer_email : ''; ?>">
						</div>
						<div class="clearfix"></div>
						
						<div class="form-group col-xs-10 col-sm-6 col-md-6 col-lg-6">
							<label for="exampleInputPassword1">Contact*</label>
							<input type="text" maxlength='10' required class="form-control" placeholder="Contact Number" name="customer_contact" value="<?php echo isset($customer_contact) ? $customer_contact : ""; ?>">
						</div>
						<div class="form-group col-xs-10 col-sm-6 col-md-6 col-lg-6">
							<label for="exampleInputPassword1">Description*</label>
							<textarea required name="description"  class="form-control" placeholder="Type Short description about payment.."><?php echo isset( $description ) ? $description : ''; ?></textarea>
						</div>
						<div class="clearfix"></div>
						<hr>
						
						<div class="col-md-offset-4 col-xs-10 col-sm-6 col-md-6 col-lg-6">
							<button  type="submit" class='btn btn-success' ><i class='fa fa-shopping-cart'></i> Continue to checkOut</button>
						</div>
						
						<input id="CUST_ID" tabindex="2" maxlength="12" type="hidden" size="12" name="customer_id" autocomplete="off" value="<?php echo isset($customer_id) ? $customer_id : ""; ?>">
						
						<input type='hidden' name='iti_id' value="<?php echo isset($iti_id) ? $iti_id : ""; ?>">
						<input type='hidden' name='link_token' value="<?php echo isset($link_token) && !empty( $link_token ) ? $link_token : ""; ?>">
					</form>
				<?php } ?>
			<div class="clearfix"></div>
			<hr>
		</div>
		</div>
	</div><!--FORM SECTION -->	
</div>
<!--FOOTER-->
<!-- <div class="bg-blue">
	<div class="container">
		<div class="row">
			<div class="row iata">
				<div class="col-md-6 iatacol ">
					<div class="grabber fff ptb">
						<h5 class="wa text-capitalize">Approved by</h5>
					   <div>
						   <img src="<?php echo base_url();?>site/assets/images/approve.png" alt="Approve">
					   </div>
					</div>
				</div>
				<div class="col-md-6 iatacol">
					<div class="grabber grabberwa fff ptb">
						<h5 class="wa text-capitalize">we accept all major credit and debit cards</h5>
						<div class="mitem">
						  <img src="<?php echo base_url();?>site/assets/images/payment-type.png" alt="Payment Modes">
						</div>
					</div>
				</div>
			</div>
		</div>		
		<div class="row">
			<div class="col-md-12">
				<span class="">© <?php echo date('Y');?> trackitinerary. All Rights Reserved.</span>
			</div>
		</div>
	</div>
</div>		 -->

	<!--Include all compiled plugins (below), or include individual files as needed -->
	<script src="<?php echo base_url();?>site/assets/js/jquery.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url();?>site/assets/js/jquery.validate.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url();?>site/assets/js/bootstrap.min.js" type="text/javascript"></script>		

	<script>
		jQuery(document).ready(function($){
			$("form").validate();
		});
	</script>
	
</body>
</html>