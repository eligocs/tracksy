<html lang="en">
   <head>
      <title>Track Itinerary | Invoice</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
      <link href="https://fonts.googleapis.com/css?family=Rubik:400,500,700" rel="stylesheet">
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
      <link href="<?php echo base_url();?>site/assets/css/style_voucher.css" type="text/css" rel="stylesheet"/>
	  <link rel="shortcut icon" type="image/x-icon" href="<?php echo site_url(); ?>site/images/favicon.ico" /> 
   </head>
   <body>
	<?php 
		if( isset(  $invoice[0] ) && !empty( $invoice[0] ) && !empty( $iti_payment_details[0] ) ){
			$iti 		= $itinerary[0];
			$pay		= $iti_payment_details[0];
			$inv	 	= $invoice[0];
			$client_gst = 0;
			$stateofsup = 0;
			$customer_id 			= $customer[0]->customer_id;
			$customer_account 		= get_customer_account( $customer_id );
			if( $customer_account && !empty( $customer_account[0]->customer_name ) ){
				$customer_name 		= $customer_account[0]->customer_name;
				$customer_email 	= $customer_account[0]->customer_email;
				$customer_contact 	= $customer_account[0]->customer_contact;
				$customer_address 	= $customer_account[0]->address;
				$country		 	= get_country_name($customer_account[0]->country_id);
				$state 				= get_state_name($customer_account[0]->state_id);
				$state_id 			= $customer_account[0]->state_id;
				$place_of_supply_state_id = $customer_account[0]->place_of_supply_state_id;
				$stateofsup = $customer_account[0]->place_of_supply_state_id;
				$client_gst = $customer_account[0]->client_gst;
			}else{
				$customer_name 		= $customer[0]->customer_name;
				$customer_email 	= $customer[0]->customer_email;
				$customer_contact 	= $customer[0]->customer_contact;
				$customer_address 	= $customer[0]->customer_address;
				$country		 	= get_country_name($customer[0]->country_id);
				$state 				= get_state_name($customer[0]->state_id);
				$state_id			= $customer[0]->state_id;
				$place_of_supply_state_id = $state_id;
			}
			?>
			
          <!--wrapper --> 
        <div class="wrapper">
		<header class=" ">
			<div class="container header_section">
				<div class="row align-items-center">
				   <div class="col-md-6 ">
					<div class="logo-image">
					  <img src="<?php echo site_url(); ?>site/images/trackv2-logo.png" alt="Track Itinerary Software">
					  </div>
					  <!----div class="header-bottom-bar">
						 <span>(PAN)AARCS9601B</span><br>
						 <span>(GSTIN)02AARCS9601B2Z</span>
						 </div--> 
				   </div>
				   
				   <div class="col-md-6 contact_details">
						<address>
						<strong>Track Itinerary Pvt. Ltd.</strong><br>
							Demo Office, <br> Demo City, Demo State -171065
						</address>
				   <div><span class="phone"><a href="tel:<?php echo company_contact(); ?>"><i class="fas fa-phone"></i> &nbsp; <?php echo company_contact(); ?></a></span></div>
				   <div><span><a href="mailto:info@trackitinerary.com"><i class="fas fa-envelope"></i> &nbsp; info@trackitinerary.com</a></span></div>
				   <div><span><a href="http://www.trackitinerary.com" target="_blank"><i class="fas fa-globe"></i> &nbsp; www.trackitineray.com</a></span></div>
				   </div>
				</div>
				<div class="header-bottom-bar">
				  
				</div>
			</div>
      </header>
		<style type="text/css">
			@media print {
				.hideprint {
					display :  none;
				}
			}
			.hideprint {
				border: none;
			}	
		</style>

		<div class="breadcrumb bc-colored mb-1 ">
			<div class="container">
				<div class="row">
				   <div class="col-sm-6">
					  <span>(PAN) <b><?php echo company_pan(); ?></b></span>
				   </div>
				   <div class="col-sm-6">
					  <span style="float:right;">(GSTIN) <b><?php echo company_gsttin(); ?></b></span>
				   </div>
				</div>
			</div>
		</div>
		
		<div class="breadcrumb bc-white p-0 mb-0 ">
			<div class="container">
				<div class="col-md-12">
				   <div class="Confirmation_voucher">
						<strong>
							<p style="">Tax Invoice</p>
						</strong>
					  <!--p class="day_night"><?php //echo $iti->duration . " ( " . $iti->package_name . " )"; ?></p-->
					  <!--print btn-->
						<div class="clearfix text-center hideprint">
							<button class='btn btn-danger' id="printbtn" onclick="return window.print()"><i class='fa fa-print'></i> Print Invoice</button>
						</div>	
						<div class="clearfix"></div>
				   </div>
				</div>
			</div>
		</div>
		
		<div class="from_details">
         <div class="container">
            <div class="row">
               <div class="col-md-8 from">
					<h4>TO,</h4>
					<h5 class="uppercase"><?php echo ucwords($customer_name); ?></h5>
					<p>
						<?php echo $customer_address; ?> </br>
						<b>State:</b> <?php echo $state; ?><br> 
						<b>Country:</b> <?php echo $country; ?><br>
						<b>Email:</b> <?php echo $customer_email; ?>
						<!--state of supply-->
						<?php if( $stateofsup ){
								$sof = get_state_name( $stateofsup );
							echo "<br><b>State Of Supply: </b>{$sof}";
						} ?>
						
						<!--Client GST-->
						<?php if($client_gst){
							echo "<br><b>GST: </b>{$client_gst}";
						} ?>
						
					</p>
                  
               </div>
			   
			   <div class="col-md-4 d-flex align-items-center justify-content-end ">
                  <div class="border p-3 w-100 v-details">
                     <!--h4 class="text-center">Tax Invoice</h4-->
                     <p>Booking ID: &nbsp; <strong class="float-right"><?php echo $inv->booking_id; ?></strong></p>
                     <p>Dated: <strong class="float-right"><?php echo $iti->t_end_date; ?></strong></p>
                     <p>Invoice No.:<strong  class="float-right"><?php echo $inv->invoice_no; ?></strong></p>
                  </div>
               </div>
               
            </div>
         </div>
      </div>

	  
		<?php 
		$cgst = get_cgst();
		$sgst = get_sgst();
		$tax  = get_tax(); //IGST
		$tax  = isset( $place_of_supply_state_id ) && $place_of_supply_state_id == 14 ? $cgst + $sgst : $tax;
		$total_package_cost	= isset( $pay->total_package_cost) ? $pay->total_package_cost : 0;
		//$total_package_cost	= 45645;
		
		$is_gst_final = $pay->is_gst == 1 ? 1 : 0;
		//CALCULATE CGST/SGST/IGST AND GRAND TOTAL
		if( $is_gst_final ){
			$reverse_margin = $tax / 100;
			$reverse_margin	 = $reverse_margin + 1;
			//$p_cost_n = round( $total_package_cost / $reverse_margin );
			$p_cost_n = decimal_format( $total_package_cost / $reverse_margin );
			$package_cost_tax = decimal_format($total_package_cost - $p_cost_n);
			
			$grand_total = number_format($total_package_cost, 2);
			//$grand_total = decimal_format($total_package_cost);
			
			//CGST
			//$c_reverse_margin 	= $cgst / 100;
			//$c_reverse_margin	= $c_reverse_margin + 1;
			//$c_p_cost_n 		= round( $total_package_cost / $c_reverse_margin );
			//$c_package_cost_tax = $total_package_cost - $c_p_cost_n;
			
			//IGST
			//$s_reverse_margin 		= $sgst / 100;
			//$s_reverse_margin	 	= $s_reverse_margin + 1;
			//$s_p_cost_n				= round( $total_package_cost / $s_reverse_margin );
			//$s_package_cost_tax 	= $total_package_cost - $s_p_cost_n;
			
			//CGST
			$c_package_cost_tax = decimal_format($p_cost_n * $cgst / 100);
			//SGST
			$s_package_cost_tax = decimal_format($p_cost_n * $sgst / 100);
			
		}else{
			$p_cost_n 			= $total_package_cost;
			$package_cost_tax 	= decimal_format($total_package_cost * $tax / 100);
			$grand_total 		= number_format($package_cost_tax + $total_package_cost, 2);
			
			//CGST
			$c_package_cost_tax = decimal_format($total_package_cost * $cgst / 100);
			//SGST
			$s_package_cost_tax = decimal_format($total_package_cost * $sgst / 100);
		}
		
		//GET CGST/IGST
		?>
   <div class="container">
         <div class="start_date">
               <div class="table-responsive">
                  <!--  <h5 class="cost"><?php // echo ucwords($customer_name); ?></h5> -->
					<table class="table">
					   <tr>
						  <th width="10%" class="bg-gray">Sr. No.</th>
						  <th width="60%" class="bg-gray">Particular</th>
						  <th width="15%" class="bg-gray">HSN/SAC</th>
						  <th width="15%" class="text-right bg-gray">Amount <small> (in Rs.)</small></th>
					   </tr>
					   <tr>
						  <td>1</td>
						  <td><?php echo $iti->duration; ?> ( <?php echo $iti->package_name; ?> )  </td>
						  <td><?php echo hsn_sac_number(); ?></td>
						  <td class="text-right bg-gray"><?php echo number_format($p_cost_n,2); ?></td>
						</tr>

						<tr>
						  <td></td>
						  <td></td>
						  <td></td>
						  <td class="text-right bg-gray">&nbsp;</td>
						</tr><tr>
						  <td></td>
						  <td></td>
						  <td></td>
						  <td class="text-right bg-gray">&nbsp;</td>
						</tr><tr>
						  <td></td>
						  <td></td>
						  <td></td>
						  <td class="text-right bg-gray">&nbsp;</td>
						</tr><tr>
						  <td></td>
						  <td></td>
						  <td></td>
						  <td class="text-right bg-gray">&nbsp;</td>
						</tr><tr>
						  <td></td>
						  <td></td>
						  <td></td>
						  <td class="text-right bg-gray">&nbsp;</td>
						</tr><tr>
						  <td></td>
						  <td></td>
						  <td></td>
						  <td class="text-right bg-gray">&nbsp;</td>
						</tr>
					</table>
					<p>&nbsp;</p>
					
				<table class="table">
					<tr>
						<th width="60%" class="bg-gray"></th>
						<th class="bg-gray">Gross Total</th>
						<th class="bg-gray"></th>
						<th class="bg-gray text-right"><?php echo number_format($p_cost_n,2); ?></th>
					</tr>  
					
					<!--IF H.P. client add CGST AND SGST -->
					<?php if( isset( $place_of_supply_state_id ) && $place_of_supply_state_id == 14  ){ ?>
						
							<tr>
							<td></td>
							<td>Add CGST</td>
							<td><?php echo $cgst; ?>%</td>
							<td class="text-right"><?php echo number_format($c_package_cost_tax,2); ?></td>
						</tr>

						<tr>
							<td></td>
							<td>Add SGST</td>
							<td><?php echo $sgst; ?>%</td>
							<td class="text-right"><?php echo number_format($s_package_cost_tax,2); ?></td>
						</tr> 
						
					<?php }else{ ?>
					
						<tr>
							<td></td>
							<td>Add IGST</td>
							<td><?php echo $tax; ?>%</td>
							<td class="text-right"><?php echo number_format($package_cost_tax, 2); ?></td>
						</tr> 
					
					 
					
					
					<?php } ?>
					
					<tr>
						<td><?php echo convert_indian_currency($grand_total); ?></td>
						<td>Total Amount <small> (in Rs.)</small></td>
						<td> </td>
						<td class="text-right"><?php echo $grand_total; ?></td>
					</tr>    
				</table>
         </div>
         </div>
      </div>
   
    <hr>
            <div class="container">    
               <!--terms-->
               <div class="terms">
                    <h4>Terms</h4>
                    <ol class="terms_list">
                        <li>Subject to Shimla jurisdiction</li>
                        <li>Without original invoice no refund is permissible</li>
                        <li>Cheque to be drawn in favour of "Company Name"</li>
                        <li>Kindly check all details carefully to avoid un-necessary complications.</li>
                    </ol>
                    <hr>
                    <p class="text-right"><strong>for Track Itinerary PVT. LTD.</strong></p>
                
                    <div class="row">
                            <div class="col-md-6">
							
                            </div>
                            <div class="col-md-6 text-right">
                                Authorized Signatory<br>
                            </div>   
                            </div>
                <hr>
                <p class="text-center small"><em>This is a Computer generated document and does not require any signature.</em></p>
                
               </div>
            </div> <!-- container -->
       <!-- footer -->  

       <!-- footer -->  
       <!--footer class="bg-blue">
         <div class="container">
            <div class="row">
               <div class="col-md-6">
                  <div class="Approved">
                     <h5 class="Approved_by">Approved by</h5>
                     <div>
                        <img class="img-responsive"  src="https://trackitineray.org/site/assets/images/approve.png" alt="Approve" width="100%">
                     </div>
                  </div>
               </div>
               <div class="col-md-6">
                  <div class="we">
                     <h5 class="wa text-capitalize">we accept all major credit and debit cards</h5>
                     <div class="sampurn">
                        <img class="img-responsive" src="https://trackitineray.org/site/assets/images/payment-type.png" alt="Payment Modes"     width="100%">
                     </div>
                  </div>
               </div>
            </div>
            <div class="row">
               <nav class="col-md-12">
                  <ul class="footer-menu">
                     <li><a href="https://trackitineray.org/promotion/testimonials">Clients Feedback</a></li>
                     <li><a href="https://trackitineray.org/promotion/contact_us">Contact Us</a></li>
                  </ul>
               </nav>
               <div class="foot-boxs">
                  <div class="footer-box col-md-4 text-right">
                     <span>Stay Connected</span>
                     <ul class="social-media footer-social">
                        <li><a class="fab fa-google-plus-g" href="https://plus.google.com/u/0/5454"  target="_blank"><span> </span></a></li>
                        <li><a class="fab fa-facebook-f" href="https://www.facebook.com/trackitineray/"  target="_blank"><span> </span></a></li>
                        <li><a class="fas fa-rss" href="https://www.rss.com/"  target="_blank"><span></span></a></li>
                        <li><a class="fab fa-pinterest" href="https://www.pinterest.com/trackitineray/"  target="_blank"><span> </span></a></li>
                        <li><a class="fab fa-twitter" href="https://twitter.com/trackitineray"  target="_blank"><span></span></a></li>
                        <li><a class="fab fa-linkedin-in" href="https://www.linkedin.com/"  target="_blank"><span></span></a></li>
                     </ul>
                  </div>
                  <div class="footer-box foot-box-md col-md-4">
                     <span class="contact-email"><i class="fas fa-envelope" aria-hidden="true"></i> &nbsp; <a href="mailto:info@trackitineray.com"> info@trackitineray.com</a></span>
                     <span class="contact-phone"><i class="fas fa-phone" aria-hidden="true"></i>&nbsp; <a href="tel:+9816155636">9816155636</a></span>
                  </div>
                  <div class="footer-box col-md-4">
                     <span class="">© 2019 trackitineray. All Rights Reserved.</span>
                  </div>
               </div>
            </div>
         </div>
      </footer-->  <!-- footer end -->  
        <!-- footer end -->  
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
		<?php }else{
			redirect(404);
			exit;
		} ?>
   </body>
</html>