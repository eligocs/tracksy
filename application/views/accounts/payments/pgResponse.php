<!doctype html/>
<html lang="en">
  <head>
<meta charset="utf-8" />
<title>Checkout | trackitinerary Pvt. Lmt.</title>
<link href="https://fonts.googleapis.com/css?family=Nixie+One" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,900" rel="stylesheet">
<link href="<?php echo base_url();?>site/assets/css/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />	
<link href="<?php echo base_url();?>site/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?php echo base_url();?>site/assets/css/style_client_view_new.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
 <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url();?>site/images/favicon.ico" /> 
 <style>h1.text-center.pnf {
    color: red;
    margin-top: 60px;
    font-weight: 800;
}</style>
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
			<div id="res_page" class='payemnts-page'>
				<?php if( isset( $response_data ) && $response_data != "INVALID" ){ ?>
					<?php if( isset( $response_data['STATUS'] ) && $response_data['STATUS'] == 'TXN_SUCCESS' ){ ?>
					    <h4 class="alert alert-success">Thank you! Your payment was successful.</h4>
						<!-- TRANSACTION SUCCESS -->
						<?php
							$msg 		= $response_data['RESPMSG'];
							$order_id	= $response_data['ORDERID'];
							$TXNID		= $response_data['TXNID'];
							$TXNAMOUNT	= $response_data['TXNAMOUNT'];
							$iti_id		= isset($iti_id) ? $iti_id : '';
							/* foreach( $response_data as $paramName => $paramValue ) {
								echo "<br/>" . $paramName . " = " . $paramValue;
							} */
						?>
						<div class="table-responsive">
							<table class="table">
								<tr>
									<td>ORDER ID: </td>
									<td><?php echo $order_id; ?> </td>
								</tr>
								
								<tr>
									<td>Transaction ID: </td>
									<td><?php echo $TXNID; ?> </td>
								</tr>
								
								<tr>
									<td>Amount: </td>
									<td><?php echo $TXNAMOUNT; ?> </td>
								</tr>
								<tr>
									<td>Itinerary Id: </td>
									<td><?php echo $iti_id; ?> </td>
								</tr>
							</table>
						</div>
					<?php }else{ ?>
						<!--TRANSACTION FAILED-->
						<h4 class="alert alert-danger">Transaction is failure..</h4>
						<?php 
						$msg = $response_data['RESPMSG'];
						$order_id = $response_data['ORDERID'];
						//echo $msg;
						//echo $order_id;
						//foreach($response_data as $paramName => $paramValue) {
							//echo "<br/>" . $paramName . " = " . $paramValue;
						//} 
						?>
						<div class="table-responsive">
							<table class="table">
								<tr>
									<td>ORDER ID: </td>
									<td><?php echo $order_id; ?> </td>
								</tr>
								<tr>
									<td>Itinerary Id: </td>
									<td><?php echo $iti_id; ?> </td>
								</tr>
								<tr>
									<td>Reason: </td>
									<td><?php echo $msg; ?> </td>
								</tr>
							</table>
						</div>
					<?php } ?>
					
					<a class='btn btn-success' href="<?php echo isset( $iti_link ) ? $iti_link : ""; ?>" title='Back to Itinerary' >Back to Itinerary</a>
				<?php }else{ 
					redirect('promotion/pagenotfound');
				} ?>
			</div>
		</div>
	</div>	
</div>
<script>
	history.pushState(null, null, location.href);
		window.onpopstate = function () {
		history.go(1);
	};
</script>
	
<div class="bg-blue">
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
				<span class="">� <?php echo date('Y');?> trackitinerary. All Rights Reserved.</span>
			</div>
		</div>
	</div>
</div>		

<!-- Include all compiled plugins (below), or include individual files as needed -->
	<script src="<?php echo base_url();?>site/assets/js/jquery.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url();?>site/assets/js/bootstrap.min.js" type="text/javascript"></script>			
</body>
</html>