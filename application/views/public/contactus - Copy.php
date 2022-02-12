<!doctype html/>
<html lang="en">
  <head>
<meta charset="utf-8" />
<title>Contact Us | trackitinerary Pvt. Lmt.</title>
<link href="http://fonts.googleapis.com/css?family=Nixie+One" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,900" rel="stylesheet">
<link href="<?php echo base_url();?>site/assets/css/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />	
<link href="<?php echo base_url();?>site/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?php echo base_url();?>site/assets/css/style_client_view_new.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<div class="content_area">
	<div class="logo">
	<div class="container ">
		<img src="<?php echo base_url();?>site/images/trackv2-logo.png" class="template_logo">
	</div>
	</div>
	<div class="container bothwrapper">
		<div class="row">
			<div id="contact-us">
			<!--get offices -->
		 <?php $get_head_office 	= get_head_office(); ?>
		 <?php $get_office_branches = get_office_branches(); ?>
			
		<div class="col-md-12">	
		<div class="head_off_section">
			<h2  class="text-center">trackitinerary HEAD OFFICE</h2>
			<!--HEAD OFFICE-->
		 <?php dump($get_head_office); ?>
		 <?php dump($get_office_branches); ?>
			<?php if( !empty( $get_head_office ) ){
				$head_off = $get_head_office[0]
			?>
			<h3 class="branch_location">Shimla</h3>
			<div class="address well">
					<i class="fa fa-home" aria-hidden="true"></i>
					<address> trackitinerary Pvt. Ltd,<br>
					Ground Floor , Mukund Complex,<br>
					Shiv Nager , Panthagathi (HP) Pin: 171009</address>
					
					<div class="address_new_email">
						<p><span><i class="fa fa-phone-square" aria-hidden="true"></i></span><a href="tel:0177-2625636"> 0177-2625636</a></p>
							<i class="fa fa-envelope" aria-hidden="true"></i>	
							<div class="multi"> 
								<a href="mailto:sales@trackitinerary.com">sales@trackitinerary.com</a>, <br>
								<a href="mailto:info@trackitinerary.com">info@trackitinerary.com</a>
							</div> 
					</div>
					
					<div class="logo-side"><img src="<?php echo base_url();?>site/images/trackv2-logo.png" class="template_logo2"></div>
			</div> 
			 
			</div>
			
			
		 
	 


		<div class="branch_row">
		<h2 class="text-center">OTHER BRANCHES</h2>
		
		<div class="row flex-box">
		<div class="col-md-4">
			<h3 class="branch_location">DELHI</h3>
			<div class="branch_section well">
				<i class="fa fa-home" aria-hidden="true"></i>
				<address>21 &amp; 22 Parshvnath Metro Mall,<br> 
				Nr. Kashmiri Gate Metro Station Gate No. 2,<br> New Delhi -110006</address>
				
				<div class="address_new_email">
				<i class="fa fa-phone-square" aria-hidden="true"></i>
						<div class="multi"> 
							<a href="tel:+92108-07636">92108-07636</a>,  
							<a href="tel:+9816155636">9816155636</a>,<br>
							<a href="tel:+011-65654636">011-65654636</a>, 
							<a href="tel:+011-65650636">011-65650636</a>,<br>
							<a href="tel:+011-65651636">011-5651636</a> 
					</div>		
					</div>		
				<div class="address_new_email">	
		 		<i class="fa fa-envelope" aria-hidden="true"></i></span> 
				<div class="multi"> 
					<a href="mailto:sales@trackitinerary.com">sales@trackitinerary.com</a>,<br> 
					<a href="mailto:info@trackitinerary.com">info@trackitinerary.com</a> 
				</div>	
			</div>
			</div>
			</div>
			
			
			<div class="col-md-4">
			<h3  class="branch_location">MANALI</h3>
			<div class="branch_section well">
				<i class="fa fa-home" aria-hidden="true"></i> <address>Hotel Adarsh Annexe, <br>2nd Lane, Mall Road, <br>Opposite Mission Hospital Manali, <br>Himachal Pradesh 175131</address>
				
				<p><span><i class="fa fa-phone-square" aria-hidden="true"></i> </span> <a href="tel:+098161-55636">098161-55636</a> </p>
				
				<div class="address_new_email">	
				<i class="fa fa-envelope" aria-hidden="true"></i>
				<div class="multi">
				<a href="mailto:sales@trackitinerary.com">sales@trackitinerary.com</a>,<br> 
				<a href="mailto:info@trackitinerary.com">info@trackitinerary.com</a></p>
				</div>
				</div>
				
			</div>
			</div>
			
			<div class="col-md-4">
			<h3 class="branch_location">SRINAGAR</h3>
				<div class="branch_section well">
					<i class="fa fa-home" aria-hidden="true"></i><address>   Boulvard Road, Dalgate, Srinagar<br>
						Near Kahve-D-restaurant<br>
						Pin No 190001</address>
										
				<p><span><i class="fa fa-phone-square" aria-hidden="true"></i> </span><a href="tel:+98161-55636">98161-55636</a></p>
				
					<div class="address_new_email">	
					<i class="fa fa-envelope" aria-hidden="true"></i>
				<div class="multi">	
				
					<a href="mailto:sales@trackitinerary.com">sales@trackitinerary.com</a>, <br>
					<a href="mailto:info@trackitinerary.com">info@trackitinerary.com</a>
				</div>
				</div>
		</div>
		</div>
		</div> <!--row -->
		
		
		
		</div>
		</div>
	</div>
	</div>
	<!-- Include all compiled plugins (below), or include individual files as needed -->
	<script src="<?php echo base_url();?>site/assets/js/jquery.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url();?>site/assets/js/bootstrap.min.js" type="text/javascript"></script>
</div>	
</div>	

<div class="bg-blue">
<div class="container">


<div class="row">
	<div class="row iata">
     <div class="col-md-6 iatacol ">
     <div class="grabber fff ptb">
       <h5 class="wa text-capitalize">Approved by</h5>
   <div>
 	   <img src="<?php echo site_url('/');?>site/assets/images/approve.png" alt="Approve">
   </div>
   </div>
    </div>
    <div class="col-md-6 iatacol">
     <div class="grabber grabberwa fff ptb">
        <h5 class="wa text-capitalize">we accept all major credit and debit cards</h5>
	<div class="mitem">
	  <img src="<?php echo site_url('/');?>site/assets/images/payment-type.png" alt="Payment Modes">
	
    </div>
  </div>
</div>
</div>
</div>		
						<div class="row">
							<nav class="col-md-12">
								<ul class="footer-menu">
									<li><a href="<?php echo site_url('/');?>promotion/testimonials">Clients Feedback</a></li>
									<li><a href="<?php echo site_url('/');?>promotion/contact_us">Contact Us</a></li>
																		
								</ul>
							</nav>
							
							<div class="foot-boxs">
								<div class="foot-box col-md-4 text-right">
									<span>Stay Connected</span>
									<ul class="social-media footer-social">
										<li><a class="fa fa-google" href="https://plus.google.com/u/0/108839684823653144097"><span>Google</span></a></li>
										<li><a class="fa fa-facebook" href="https://www.facebook.com/trackitineraryaa/"><span>Facebook</span></a></li>
										<li><a class="fa fa-rss" href="https://www.rss.com/"><span>RSS</span></a></li>
										<li><a class="fa fa-pinterest-p" href="https://www.pinterest.com/trackitinerary/"><span>Pinterest</span></a></li>
										<li><a class="fa fa-twitter" href="https://twitter.com/Trackitinerary"><span>Twitter</span></a></li>
										<li><a class="linkdin_link" href="https://www.linkedin.com/"><span>Linkdin</span></a></li>
									</ul>
								</div>
								<div class="foot-box foot-box-md col-md-4">
									<span class="contact-email"><i class="fa fa-envelope" aria-hidden="true"></i> &nbsp; <a href="mailto:info@trackitinerary.com"> info@trackitinerary.com</a></span>
									<span class="contact-phone"><i class="fa fa-phone" aria-hidden="true"></i>&nbsp; <a href="tel:+9816155636">9816155636</a></span>
								</div>
								<div class="foot-box col-md-4">
						<span class="">© <?php echo date('Y');?> trackitinerary. All Rights Reserved.</span>
								</div>
							</div>
						</div>
					</div>
</div>					
</body>
</html>