<html lang="en">
   <head>
      <title>Track Itinerary | <?php echo isset( $receipts[0]->receipt_type ) ? ucfirst($receipts[0]->receipt_type) : ""; ?> Receipt</title>
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
         if( isset(  $receipts[0] ) && !empty( $receipts[0] ) ){
         	$receipt = $receipts[0];
         	$receipt_type 		= ucfirst( $receipt->receipt_type );
         	
         	$customer_account 	= get_customer_account( $receipt->lead_id );
         	$customer_name 		= isset($customer_account[0]->customer_name) ? $customer_account[0]->customer_name : "";
         	$customer_email 	= isset($customer_account[0]->customer_email) ? $customer_account[0]->customer_email : "";
         	$customer_contact 	= isset($customer_account[0]->customer_contact) ? $customer_account[0]->customer_contact : "";
         	$customer_address 	= isset($customer_account[0]->address) ? $customer_account[0]->address : "";
         	$country		 	= isset($customer_account[0]->country_id) ? get_country_name($customer_account[0]->country_id) : "";
         	$state 				= isset($customer_account[0]->state_id) ? get_state_name($customer_account[0]->state_id) : "";
         	
         	?>
      <!--wrapper --> 
      <div class="wrapper">
         <header class=" ">
            <div class="container header_section">
               <div class="row">
                  <div class="col-md-4">
                     <img src="<?php echo site_url(); ?>site/images/trackv2-logo.png" alt="Track Itinerary">
                     <!----div class="header-bottom-bar">
                        <span>(PAN)AARCS9601B</span><br>
                        <span>(GSTIN)02AARCS9601B2Z</span>
                        </div--> 
                  </div>
                  <div class="col-md-8 contact_details">
                     <address>
                        <strong>Track Itinerary Pvt. Ltd.</strong><br>
                        Demo Office<br>
                        Demo City, <br>
                        Demo State -171054
                     </address>
                  </div>
               </div>
               <div class="header-bottom-bar">
                  <span class="phone"><a href="tel:<?php echo company_contact(); ?>"><i class="fas fa-phone"></i> &nbsp; <?php echo company_contact(); ?></a></span>
                  <span><a href="mailto:info@trackitinerary.com"><i class="fas fa-envelope"></i> &nbsp; info@trackitinerary.com</a></span>
                  <span><a href="http://www.itinerary.com" target="_blank"><i class="fas fa-globe"></i> &nbsp; www.trackitineray.com</a></span>
               </div>
            </div>
         </header>
         <div class="breadcrumb bc-colored m-b-30 ">
            <div class="container">
               <div class="row">
                  <div class="col-sm-6">
                     <span>(PAN)<?php echo company_pan(); ?></span>
                  </div>
                  <div class="col-sm-6">
                     <span style="float:right;">(GSTIN)<?php echo company_gsttin(); ?></span>
                  </div>
               </div>
            </div>
         </div>
         <div class="breadcrumb bc-white mb-0 ">
            <div class="container">
               <div class="col-md-12">
                  <div class="Confirmation_voucher">
                     <strong>
                        <p style="text-transform: uppercase;"><?php echo $receipt_type; ?> Receipt</p>
                     </strong>
                  </div>
               </div>
            </div>
         </div>
         <div class="from_details">
            <div class="container">
               <div class="row">
                  <div class="col-md-8 from">
                     <h4>Received with thanks,</h4>
                     <h5 class="uppercase"><?php echo ucwords($customer_name); ?></h5>
                     <p><?php echo $customer_address; ?> </br>
                        State: <?php echo $state; ?>
                        <br> Country: <?php echo $country; ?>
                     </p>
                     <p>(M)<?php echo $customer_contact; ?></p>
                     </p>
                  </div>
                  <div class="col-md-4 d-flex align-items-center justify-content-end ">
                     <div class="border p-3 w-100 v-details">
                        <h3 class="text-center"><?php echo $receipt_type; ?> Receipt</h3>
                        <p><strong class="float-left"><?php echo $receipt->voucher_number; ?> </strong></p>
                        <p><strong class="float-right"><?php echo date("d/m/Y", strtotime( $receipt->voucher_date )); ?></strong></p>
                        <!--p><strong  class="float-right"> SY-3380</strong></p-->
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="container">
            <div class="bank_receipt_details">
               <h5 class="cost"><?php echo $receipt->transfer_type; ?> </h5>
               <div class="table-responsive">
                  <table class="table">
                     <tr>
                        <th>Particular</th>
                        <th>Transfer Reference</th>
                        <th class="text-right bg-gray">Amount</th>
                        <th> </th>
                     </tr>
                     <tr>
                        <td><?php echo $customer_name; ?></td>
                        <td><?php echo $receipt->transfer_ref; ?></td>
                        <td class="text-right bg-gray"><?php echo isset( $receipt->amount_received ) ? $receipt->amount_received : ""; ?></td>
                        <td>
                           <!--Credit -->
                        </td>
                     </tr>
                  </table>
               </div>
            </div>
         </div>
         <div class="container">
            <!-- Total Cost -->
            <div class="table-responsive">
               <table class="table">
                  <tr class="cost">
                     <th><strong>Tour Reference</strong></th>
                     <th>Tour Code </th>
                     <th>Start Date</th>
                     <th>End Date</th>
                  </tr>
                  <tr>
                     <td><?php echo isset( $iti_payment[0]->booking_id ) ? $iti_payment[0]->booking_id : ""; ?></td>
                     <td> </td>
                     <td><?php echo isset( $iti_payment[0]->iti_id ) ? get_tour_start_date( $iti_payment[0]->iti_id ) : ""; ?></td>
                     <td ><?php echo isset( $iti_payment[0]->iti_id ) ? get_tour_end_date( $iti_payment[0]->iti_id ) : ""; ?></td>
                  </tr>
                  <tr>
                     <th colspan="3">
                        <!--1st installment received T.P.C. 12960/- confirmed by Priyanka Dogra --> 
                     </th>
                     <th class="text-right bg-gray">Amount in </th>
                  </tr>
                  <tr>
                     <td colspan="3"></td>
                     <td class="text-right bg-gray"><?php echo number_format( $receipt->amount_received ); ?></td>
                  </tr>
               </table>
               <div class="text-right">E. & O. E.</div>
            </div>
            <!-- Total Cost end -->
            <hr>
            <!--terms-->
            <?php $user_info = get_user_info($receipt->agent_id);
               $agent_name 	= isset( $user_info[0]->first_name ) ? $user_info[0]->first_name . " " . $user_info[0]->last_name : ""; ?>
            <div class="terms">
               <h4>Terms</h4>
               <ol class="terms_list">
                  <li>Subject to realisation of Cheque.</li>
                  <li>Without original Receipt no refund is permissible.</li>
                  <li>Kindly check all details carefully to avoid un-necessary complications.</li>
                  <li>Subject to Shimla jurisdiction.</li>
               </ol>
            </div>
            <hr>
            <p class="text-right "><strong>for Track Itinerary PVT. LTD.</strong></p>
            <!--terms-->
            <div class="row bottom-sec">
               <div class="col-md-3">
                  <p>&nbsp;</p>
                  <p>&nbsp;</p>
                  <p>&nbsp;</p>
                  Receiver's Signature
               </div>
               <div class="col-md-6 text-center">
                  <p>&nbsp;</p>
                  <p>&nbsp;</p>
                  <p>&nbsp;</p>
                  (Prepared by: <?php echo $agent_name; ?>)
               </div>
               <div class="col-md-3 text-right">
                  <p>&nbsp;</p>
                  <p>&nbsp;</p>
                  <p>&nbsp;</p>
                  Authorized Signatory
               </div>
               <hr>
               <div class="col-md-3">
                  (Prepared by: <?php echo $agent_name; ?>)
               </div>
               <div class="col-md-6 text-center">
                  This is a Computer generated document and does not require any signature.
               </div>
               <div class="col-md-3 text-right">
               </div>
            </div>
         </div>
         <!-- container -->
         <p>&nbsp;</p>
         <p>&nbsp;</p>
      </div>
      <!-- footer -->  
      <!-- <footer class="">
         <div class="container bg-blue">
            <div class="row">
               <div class="col-md-6">
                  <div class="Approved">
                     <h5 class="Approved_by">Approved by</h5>
                     <div>
                        <img class="img-responsive"  src="https://trackitinerary.org/site/assets/images/approve.png" alt="Approve" width="100%">
                     </div>
                  </div>
               </div>
               <div class="col-md-6">
                  <div class="we">
                     <h5 class="wa text-capitalize">we accept all major credit and debit cards</h5>
                     <div class="sampurn">
                        <img class="img-responsive" src="https://Trackitinerary.org/site/assets/images/payment-type.png" alt="Payment Modes"     width="100%">
                     </div>
                  </div>
               </div>
            </div>
            <div class="row">
               <nav class="col-md-12">
                  <ul class="footer-menu" style="margin-top:64px;">
                     <li><a href="https://Trackitinerary.org/promotion/testimonials">Clients Feedback</a></li>
                     <li><a href="https://Trackitinerary.org/promotion/contact_us">Contact Us</a></li>
                  </ul>
               </nav>
               <div class="foot-boxs">
                  <div class="footer-box col-md-4 text-right">
                     <span>Stay Connected</span>
                     <ul class="social-media footer-social">
                        <li><a class="fab fa-google-plus-g" href="https://plus.google.com/u/0/5464654"  target="_blank"><span> </span></a></li>
                        <li><a class="fab fa-facebook-f" href="https://www.facebook.com/Tracitinerary/"  target="_blank"><span> </span></a></li>
                        <li><a class="fas fa-rss" href="https://www.rss.com/"  target="_blank"><span></span></a></li>
                        <li><a class="fab fa-pinterest" href="https://www.pinterest.com/trackitinerary/"  target="_blank"><span> </span></a></li>
                        <li><a class="fab fa-twitter" href="https://twitter.com/trackitinerary"  target="_blank"><span></span></a></li>
                        <li><a class="fab fa-linkedin-in" href="https://www.linkedin.com/"  target="_blank"><span></span></a></li>
                     </ul>
                  </div>
                  <div class="footer-box foot-box-md col-md-4">
                     <span class="contact-email"><i class="fas fa-envelope" aria-hidden="true"></i> &nbsp; <a href="mailto:info@trackitinerary.com"> info@Trackitinerary.com</a></span>
                     <span class="contact-phone"><i class="fas fa-phone" aria-hidden="true"></i>&nbsp; <a href="tel:<?php echo company_contact(); ?>"><?php echo company_contact(); ?></a></span>
                  </div>
                  <div class="footer-box col-md-4">
                     <span class="">© <?php echo date("Y"); ?> Track Itinerary. All Rights Reserved.</span>
                  </div>
               </div>
            </div>
         </div>
      </footer> -->
      <!-- footer end -->  
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
      <?php }else{
         redirect('promotion/pagenotfound');
         exit;
         } ?>
   </body>
</html>