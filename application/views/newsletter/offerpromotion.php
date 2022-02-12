<?php
 /*
?>
<div class="page-container">
	<div class="page-content-wrapper">
		<div class="page-content">
			<div class="portlet box blue">
				<div class="portlet-title">
					<div class="caption"><i class="fa fa-newspaper-o" aria-hidden="true"></i>Offer View</div>
					<a class="btn btn-success pull-right" href="<?php echo site_url("newsletters/offers"); ?>" title="Back">Back</a>
				</div>
			</div>
			<!--Show success message if Category edit/add -->
			<?php $message = $this->session->flashdata('success'); 
				if($message){ echo '<span class="help-block help-block-success">'.$message.'</span>'; }
			?>
			<div class="portlet-body">
			<h3 class="text-center">Offer sDetails</h3>
				
				<div class="table-responsive">	
					<table class="table table-condensed table-hover">	
						<tr>
							<td width="20%"><div class="col-mdd-2 form_vl"><strong>Offer  Id: </strong></div></td>	
							<td><div class="col-mdd-10 form_vr"><?php echo $offers->offerid; ?></div></td>
						</tr>
						<tr>
							<td width="20%"><div class="col-mdd-2 form_vl"><strong>Offer Title 1: </strong></div></td>	
							<td><div class="col-mdd-10 form_vr"><?php echo strip_tags($offers->title1); ?></div></td>
						</tr>
						<tr>
							<td width="20%"><div class="col-mdd-2 form_vl"><strong>Offer Content 1: </strong></div></td>	
							<td><div class="col-mdd-10 form_vr"><?php echo htmlspecialchars_decode($offers->content1); ?></div></td>
						</tr><tr>
							<td width="20%"><div class="col-mdd-2 form_vl"><strong>Offer Title 2: </strong></div></td>	
							<td><div class="col-mdd-10 form_vr"><?php echo strip_tags($offers->title2); ?></div></td>
						</tr><tr>
							<td width="20%"><div class="col-mdd-2 form_vl"><strong>Offer Content 2: </strong></div></td>	
							<td><div class="col-mdd-10 form_vr"><?php echo htmlspecialchars_decode($offers->content2); ?></div></td>
						</tr><tr>
							<td width="20%"><div class="col-mdd-2 form_vl"><strong>Offer Title 3: </strong></div></td>	
							<td><div class="col-mdd-10 form_vr"><?php echo strip_tags($offers->title3); ?></div></td>
						</tr><tr>
							<td width="20%"><div class="col-mdd-2 form_vl"><strong>Offer Content 3: </strong></div></td>	
							<td><div class="col-mdd-10 form_vr"><?php echo htmlspecialchars_decode($offers->content3); ?></div></td>
						</tr><tr>
							<td width="20%"><div class="col-mdd-2 form_vl"><strong>Offer Image Preview: </strong></div></td>	
							<td><div class="col-mdd-10 form_vr"><img width='30%' src="<?php echo base_url('site/images/offer/'.$offers->offer_image); ?>" alt='image' ></div></td>
						</tr>
					
						
					</table>
				</div>
			</div>	
		</div>
	</div>
</div>
<?php */?>	
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>Track Itinerary</title>
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url();?>site/assets/css/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,500" rel="stylesheet">
	<link href="<?php echo base_url();?>site/assets/css/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url();?>site/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url();?>site/assets/css/plugins.min.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url();?>site/assets/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
	<link rel="shortcut icon" href="favicon.ico" />
	
<style>
	.page-content {width: 800px; padding: 20px;	border: 1px dashed #b7b7b7;		margin: 20px auto 0; box-shadow: 0 8px 107px 0 rgba(0,0,0,.2), 0 6px 155px 0 rgba(0, 0, 0, 0);}
	.logo{margin-bottom: 30px;  padding:10px;}
	.logo img {max-width: 350px;    padding: 20px;}
	.logo { margin: -20px -20px 0 -20px;    background: #00307b;}

	.copyright.text-center {margin: 20px 0;}
	
body.status {color: #000; position: relative; background: #000000;  font-family: 'Roboto', sans-serif;}
body.status .container .page-content {
	background: white;
    border: 1px solid #676767;
    outline: 1px solid #9e9e9e;
    outline-offset: -3px;
	margin-bottom:20px;
}

h2.iti_heading {padding: 10px; margin: 0 -15px 20px; background: #00307b; color: #fff; font-weight: 500;}
body.status:before {
    content: " "; background: #000000ad;width: 100%; height: 100%; position: absolute;  z-index: -1;
    filter: blur(1px);
    opacity: .3;
    background: #000000 url(https://images.unsplash.com/photo-1446944987594-eb9bb99c6e22?ixlib=rb-0.3.5…EyMDd9&s=d8cc23e…&auto=format&fit=crop&w=1953&q=80) bottom center fixed no-repeat;
  }

 

.iti_list .day_wise_iti {position: relative; background: #ef4f4f; color: #fff; margin-bottom: 50px; padding: 10px 20px;  margin-left: 70px; min-height: 80px; box-shadow: inset 0px 0px 0px 1px #00000030;  border: 1px solid #ce2020;  box-sizing: border-box;  font-size: 20px;  z-index: 9;}

.iti_list span.day {position: absolute; left: -73px; background: #051626;  padding: 8px 21px; top: -1px; display: flex; flex-direction: column-reverse;
min-height: 80px;   justify-content: flex-end;  border: 1px solid #051626;  border-right: 0;  text-align: center;}

.iti_list .day_wise_iti:nth-child(odd) span.day { left: unset;  right: -74px;  border-left: 0;  z-index: -1;}
span.day_no {display: block; font-size: 30px;  line-height: 100%;  clear: both;  width: 100%;}

.iti_list .day_wise_iti:nth-child(odd) { margin-right: 70px; margin-left: 0; text-align: right;}
.iti_list .day_wise_iti:last-child:before { display: none;}
.inclusion ul {list-style: none; padding: 0px 15px;}
.inclusion ul li i {margin-right: 10px;  color: #000;}
.inclusion ul li {color: #676262;  padding: 5px 0; border-bottom: 1px dashed #eaeaea;}
.inclusion h3 { font-weight: 500;  background: #ef4f4f;  padding: 10px;  color: #fff;  margin-top: 0;}
.inclusion {border: 1px solid #e0e0e0;  position: relative;  z-index: 99999;}
.inclusion ul li:last-child {border-bottom: 0;}
.iti_list .day_wise_iti:before {content: ""; position: absolute;  left: -40px;  top: 0;  z-index: -1;  width: 4px; height: 200%; border-left: 3px solid #051626;}
.iti_list .day_wise_iti:nth-child(odd):before { left:unset;  right: -40px;}
.iti_list {overflow: hidden;  width: 100%; box-sizing: border-box; padding: 0 15px 15px 15px; border: 1px solid #e0e0e0; margin-bottom: 20px;}
.iti_list .day_wise_iti:last-child {margin-bottom: 0;} 
 
.offer {
    background: url(http://maxxerp.com/wp-content/uploads/2015/04/Offer-Schemes.png) 0 center no-repeat;
    width: 300px; text-align: center; position: absolute; top: 2px; right: 1px; font-size: 20px; color: #fff; min-height: 116px; background-size: 100px; padding-left: 70px;
    padding-top: 30px;}

.offer .offer-text {z-index: 9;  position: relative; font-weight: 700;}
.offer .offer-text span{display: block; animation: colorchange 3s infinite;}

 @keyframes colorchange
    {
      0%   {color: #ffb3b3;  transition: color 2s, font-size 2s;}
      25%  {color: #ffffba;  transition: color 2s, font-size 2s;}
      50%  {color: #bcbcff;  transition: color 2s, font-size 2s;}
      75%  {color: #c7ffc7;  transition: color 2s, font-size 2s;}
      100% {color: #ffbebe;  transition: color 2s, font-size 2s;}
    }

    @-webkit-keyframes colorchange /* Safari and Chrome - necessary duplicate */
    {
      0%   {color: #ffb3b3;}
      25%  {color: #ffffba;}
      50%  {color: #bcbcff;}
      75%  {color: #c7ffc7;}
      100% {color: #ffbebe;}
    }

h4.greeting-text {margin-bottom: 20px;}
.page-content {position: relative;}

.equilizer {height: 100px; width: 100px; transform: rotate(180deg);}
.bar {fill: white;  width: 18px;  animation: equalize 4s 0s infinite;}
svg.equilizer {position: absolute; top: 0;  z-index: 0;  opacity: .3;}

.bar:nth-child(1) {animation-delay: -1.9s;}
.bar:nth-child(2) {animation-delay: -2s;}
.bar:nth-child(3) {animation-delay: -2.3s;}
.bar:nth-child(4) {animation-delay: -2.4s;}
.bar:nth-child(5) {animation-delay: -2.1s;}

@keyframes equalize {
	0% {height: 60px;}
	4% {height: 50px;}
	8% {height: 40px;}
	12% {height: 30px;}
	16% {height: 20px;}
	20% {height: 30px;}
	24% {height: 40px;}
	28% {height: 10px;}
	32% {height: 40px;}
	36% {height: 60px;}
	40% {height: 20px;}
	44% {height: 40px;}
	48% {height: 70px;}
	52% {height: 30px;}
	56% {height: 10px;}
	60% {height: 30px;}
	64% {height: 50px;}
	68% {height: 60px;}
	72% {height: 70px;}
	76% {height: 80px;}
	80% {height: 70px;}
	84% {height: 60px;}
	88% {height: 50px;}
	92% {height: 60px;}
	96% {height: 70px;}
	100% {height: 80px;}
}

.offer2{background: #ef4f4f;padding: 70px 0 50px;margin-bottom: 30px;outline: 1px dashed #efbdbd; outline-offset: -12px;/* border: 1px dashed #fff; */position: relative;     background: #ef4f4f url(http://maxxerp.com/wp-content/uploads/2015/04/Offer-Schemes.png) 0 center no-repeat;
    background-size: 120px;}
.offer-text2{
    max-width: 500px;
    border: 2px solid #fff;
    margin: 0 auto;
    position: relative;
    text-align: center;
    z-index: 9;
}
.text-offer{
    display: inline-block;
    color: #fff900;
    text-align: center;
    font-size: 70px;
    position: relative;
    top: -41px;
    background: #ef4f4f;
    line-height: 100%;
    padding: 0 15px;
}
.title-offer{
    display: block;
    font-size: 50px;
    color: aliceblue;
    position: relative;
    top: -30px;
    font-weight: 500;
}

.offer2:after {
    content: " ";
    position: absolute;
    border: 4px solid #00307b;
    width: 100%;
    height: 100%;
    top: 0;
    z-index: 0;
}

.hotel-p-t.text-center {
    clear: both;
    overflow: hidden;
    margin-top: 15px;
}

.hotel-p-t.text-center>div h4 {
    font-weight: 500;
    background: #ef4f4f;
    padding: 10px;
    color: #fff;
    margin: 0 -15px;
}

.hotel-p-t.text-center p {
    font-size: 24px;
}

.hotel-p-t.text-center>div {
    border: 1px solid #e0e0e0;
}
	
	</style>
</head>
<body class="status">
	<div class="content">
		<div class="container">
			<div class="page-content">
				<div class="logo"><a href="https://www.trackitinerary.com/"><img src="<?php echo site_url() ?>site/images/trackv2-logo.png" alt="Track Itinerary Software"></a></div>
			
				<?php  if($offer){ 	$offers = $offer[0]; ?>
				<div class="newsletter_section promotion">
				
				
				<div class="offer pull-right">
					
					<svg xmlns="http://www.w3.org/2000/svg" class="equilizer" viewBox="0 0 128 128">
					  <g>
						<title>Audio Equilizer</title>
						<rect class="bar" transform="translate(0,0)" y="15"></rect>
						<rect class="bar" transform="translate(25,0)" y="15"></rect>
						<rect class="bar" transform="translate(50,0)" y="15"></rect>
						<rect class="bar" transform="translate(75,0)" y="15"></rect>
						<rect class="bar" transform="translate(100,0)" y="15"></rect>
					  </g>
					</svg>
					
				</div>
					<div class="col-mdd-10 form_vr"><img width='100%' src="<?php echo base_url('site/images/offer/'.$offers->offer_image); ?>" alt='image' >
							</div>					

				
					<div class="offer-text"><h2><span><?php echo htmlspecialchars_decode($offers->title1); ?></span></h2></div>
					<div class="offer-text"><p><span><?php echo htmlspecialchars_decode($offers->content1); ?></span></p></div>
					<div class="offer-text"><h2><span><?php echo htmlspecialchars_decode($offers->title2); ?></span></h2></div>
					<div class="offer-text"><span><?php echo htmlspecialchars_decode($offers->content2); ?></span></div>
					<div class="offer-text"><h2><span><?php echo htmlspecialchars_decode($offers->title3); ?></span></h2></div>
					<div class="offer-text"> <span><?php echo htmlspecialchars_decode($offers->content3); ?></span></div>
				
				
				
							
				<div class="clearfix"></div>
						

				
				
			</div>					

			<div class="clearfix"></div>
			<div class="copyright text-center"> <?php echo date("Y"); ?> © Track Itineray.</div>
		</div>
	</div>
<script src="<?php echo base_url();?>site/assets/js/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>site/assets/js/bootstrap.min.js" type="text/javascript"></script>
<?php	}else{ ?>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="error-template">
					<h1>
						Oops!</h1>
					<h2>
						404 Not Found</h2>
					<div class="error-details">
						Sorry, an error has occured, Requested page not found!
					</div>
					
				</div>
			</div>
		</div>
	</div>

	<?php die();
} ?>	



</body>
</html>

