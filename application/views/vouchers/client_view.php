<html lang="en">
   <head>
      <title>Track Itinerary | Voucher</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
      <link href="https://fonts.googleapis.com/css?family=Rubik:400,500,700" rel="stylesheet">
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
      <link href="<?php echo base_url();?>site/assets/css/style_voucher.css" type="text/css" rel="stylesheet"/>
      <link rel="shortcut icon" type="image/x-icon" href="<?php echo site_url()  . 'site/images/' . favicon() ?>" />
   </head>
   <body>
      <?php 
         if( isset(  $itinerary[0] ) && !empty( $vouchers[0] ) && !empty( $hotels[0] ) ){
            // var_dump("dfsajflkdsf");die;
         	$iti 		= $itinerary[0];
         	$pay		= $iti_payment_details[0];
         	$voucher 	= $vouchers[0];
         	
         	$customer_id 		= $customer[0]->customer_id;
         	$customer_account 	= get_customer_account( $customer_id );
         	if( $customer_account && !empty( $customer_account[0]->customer_name ) ){
         		$customer_name 		= $customer_account[0]->customer_name;
         		$customer_email 	= $customer_account[0]->customer_email;
         		$customer_contact 	= $customer_account[0]->customer_contact;
         		$customer_address 	= $customer_account[0]->address;
         		$country		 	= get_country_name($customer_account[0]->country_id);
         		$state 				= get_state_name($customer_account[0]->state_id);
         	}else{
         		$customer_name 		= $customer[0]->customer_name;
         		$customer_email 	= $customer[0]->customer_email;
         		$customer_contact 	= $customer[0]->customer_contact;
         		$customer_address 	= $customer[0]->customer_address;
         		$country		 	= get_country_name($customer[0]->country_id);
         		$state 				= get_state_name($customer[0]->state_id);
         	}
         	?>
      <!--wrapper --> 
      <div class="wrapper">
         <header class=" ">
            <div class="container header_section">
               <div class="row">
                  <div class="col-md-4">
                  <div class="logo text-center"><img src="<?php echo site_url()  . 'site/images/' . getLogo() ?>" alt="Itinerary Software"></div>
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
                  <span><a href="http://www.trackitinerary.com" target="_blank"><i class="fas fa-globe"></i> &nbsp; www.trackitinerary.com</a></span>
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
                        <p style="text-transform: uppercase;">Tour Confirmation Voucher</p>
                     </strong>
                     <p class="day_night"><?php echo $iti->duration; ?> ( <?php echo $iti->package_name; ?> )</p>
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
                     <p><?php echo $customer_address; ?> </br>
                        State: <?php echo $state; ?>
                        <br> Country: <?php echo $country; ?>
                     </p>
                     <p>(M)<?php echo $customer_contact; ?></p>
                     </p>
                  </div>
                  <div class="col-md-4 d-flex align-items-center justify-content-end ">
                     <div class="border p-3 w-100 v-details">
                        <p>Voucher No.: &nbsp; <strong class="float-right"><?php echo $voucher->voucher_id; ?></strong></p>
                        <p>Date: <strong class="float-right"><?php echo date("d/m/Y"); ?></strong></p>
                        <p>Reference No.:<strong  class="float-right"> <?php echo isset($pay->booking_id) ? $pay->booking_id : ""; ?></strong></p>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="container">
            <div class="start_date">
               <div class="table-responsive">
                  <table class="table">
                     <tr>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Duration</th>
                        <th>Adults/s</th>
                        <th>Child</th>
                        <!--th>Extra Adults/s</th>
                           <th>Child N/B</th>
                           <th>Infant</th-->
                        <th>Total</th>
                     </tr>
                     <tr>
                        <td><?php echo $iti->t_start_date; ?></td>
                        <td><?php echo $iti->t_end_date; ?></td>
                        <td><?php echo $itinerary[0]->iti_type == 2 ? $itinerary[0]->total_nights . " Nights" : $itinerary[0]->duration; ?></td>
                        <td><?php echo $iti->adults; ?></td>
                        <td><?php echo $iti->child; ?></td>
                        <!--td> </td>
                           <td> </td>
                           <td> </td>
                           <td> </td-->
                        <td><?php echo !empty($iti->child) ? $iti->adults + $iti->child : $iti->adults; ?></td>
                  </table>
               </div>
            </div>
         </div>
         <div class="container">
            <div class="Travel_details">
               <h5 class="cost">Traveller Detail</h5>
               <div class="table-responsive">
                  <table class="table">
                     <tr>
                        <th>Name</th>
                        <!--th>Birth Date</th>
                           <th>age</th>
                           <th>Passport No.</th>
                           <th>Nationality</th-->
                        <th>MP</th>
                        <th>Notes</th>
                     </tr>
                     <tr>
                        <td><?php echo ucwords( $customer_name ); ?></td>
                        <!--td></td>
                           <td></td>
                           <td></td>
                           <td>Indain</td-->
                        <td><?php echo $customer[0]->meal_plan; ?></td>
                        <td>CONFIRMED</td>
                  </table>
               </div>
            </div>
         </div>
         <!-- Accomodation -->
         <?php if( $hotels ){ ?>
         <div class="container">
            <h5 class="cost">Accommodation</h5>
            <div class="Travel_details">
               <div class="table-responsive">
                  <table class="table">
                     <tr class="city">
                        <th>Sr.</th>
                        <th>City</th>
                        <th>Check In</th>
                        <th>Check Out</th>
                        <th>Hotel</th>
                        <th>Room Category</th>
                        <th>Plan</th>
                        <th>Inclusion</th>
                        <th>Room</th>
                        <th>N/t</th>
                     </tr>
                     <?php
                        $ch = 1;
                        foreach ( $hotels as $hotel ) {
                        	if( !empty( $hotel->check_in ) && !empty($hotel->check_out) ){
                        		$check_in 	=  $hotel->check_in; 
                        		$check_out 	=  $hotel->check_out;
                        		$date1 		=	 new DateTime($check_in);
                        		$t_date2 	= 	 new DateTime($check_out);
                        		$total_days =  $t_date2->diff($date1)->format("%a"); 
                        		$total_days = $total_days+1;
                        		if( $total_days <= 1 ){
                        			$duration =  "Single Day";
                        		}else{
                        			$nights = $total_days - 1;
                        			$duration =  $nights . " Nights";
                        			
                        		}
                        	}else{
                        		$duration =  "";
                        		$nights ="";
                        	}
                        	
                        	$map = $hotel->meal_plan ? get_meal_plan_name($hotel->meal_plan) : "No";
                        	//Get Hotel Information 
                        	$htl_info = get_hotel_details($hotel->hotel_id);;
                        	$hotel_info = $htl_info[0];
                        	$hotel_name = $hotel_info->hotel_name;
                        	$hotel_emails = $hotel_info->hotel_email;
                        	$city = get_city_name( $hotel->city_id );
                        	$check_in_m = display_month_name( $hotel->check_in );
                        	$check_out_m = display_month_name( $hotel->check_out );
                        	$room_cat = get_roomcat_name( $hotel->room_type );
                        	echo "<tr>
                        			<td>{$ch}.</td>
                        			<td>{$city}</td>
                        			<td>{$check_in_m}</td>
                        			<td>{$check_out_m}</td>
                        			<td>{$hotel_name}</td>
                        			<td>{$room_cat}</td>
                        			<td>{$map}</td>
                        			<td>{$hotel->inclusion}</td>
                        			<td>{$hotel->total_rooms}</td>
                        			<td>{$nights}</td>
                        		</tr>";
                        	$ch++;
                        } ?>						
                  </table>
               </div>
            </div>
         </div>
         <?php } ?> 
         <!-- Accomodation End -->
         <!-- Vechicle  -->
         <?php if( $cab_booking ){ ?>
         <div class="container">
            <h5 class="cost">Vechicle</h5>
            <div class="Travel_details">
               <div class="table-responsive">
                  <table class="table">
                     <tr class="city">
                        <th>Sr.</th>
                        <th>Vechicle</th>
                        <th>On Date </th>
                        <th>Tariff</th>
                     </tr>
                     <?php
                        $chd = 1;
                        foreach ( $cab_booking as $cab_book ) {
                        	//Get cab_book Information 
                        	$cab_name = get_car_name($cab_book->cab_id);
                        	$picking_date = display_month_name($cab_book->picking_date);
                        	$droping_date = display_month_name($cab_book->droping_date);
                        	echo "<tr>
                        			<td>{$chd}.</td>
                        			<td>{$cab_name}</td>
                        			<td>{$picking_date} - {$droping_date}</td>
                        			<td>{$cab_book->pic_location} - {$cab_book->drop_location}</td>
                        		</tr>";
                        		//cab meta driver info
                        		$cab_meta = unserialize( $cab_book->cab_meta ); 
                        		$t_cabs = $cab_book->total_cabs;
                        		if( !empty( $cab_meta ) ){
                        			for( $i=0; $i < $t_cabs; $i++ ){
                        				$taxi_number = isset($cab_meta[$i]['taxi_number']) ? $cab_meta[$i]['taxi_number'] : "";
                        				$driver_name = isset($cab_meta[$i]['driver_name']) ? $cab_meta[$i]['driver_name'] : "";
                        				$driver_contact = isset($cab_meta[$i]['driver_contact']) ? $cab_meta[$i]['driver_contact'] : "";
                        				
                        				echo "<tr class='row_dot'>
                        					<td></td>
                        					<td><strong>Taxi Number: </strong> {$taxi_number}</td>
                        					<td><strong>Driver Name: </strong> {$driver_name} </td>
                        					<td colspan=2><strong>Driver Contact: </strong> {$driver_contact}</td>
                        				</tr>";
                        			}	
                        		}
                        
                        	$chd++;	
                        } ?>
                     <!--tr>
                        <td>Swift Dzire</td>
                        <td>02/03/2019</td>
                        <td>PICKUP-SIGHTSEEING-DROP</td>
                        <td></td>
                        <td>5</td>
                        <td>Vinney</td>
                        </tr>
                        <tr>
                        <td>HP 01 D 4369</td>
                        <td></td>
                        <td>(Delhi-Airport/Railway Station to Delhi-Airport/Railway Station)</td>
                        <td></td>
                        <td></td>
                        <td>09805161079</td>
                        </tr-->
                  </table>
               </div>
            </div>
         </div>
         <?php } ?> 	
         <!-- Vechicle end -->
         <!--if holidays iti show daywise data-->
         <?php if( isset($vtf_booking[0]) ){ ?>
         <div class="container">
            <h5 class="cost">Volvo/Train/Flight Tickets Detail</h5>
            <div class="Travel_details">
               <div class="table-responsive">
                  <table class="table">
                     <thead class="thead-default">
                        <th>Sr.</th>
                        <th>Type</th>
                        <th>Docs/Tickets</th>
                     </thead>
                     <tbody>
                        <?php
                           $vd = 1;
                           $doc_path =  base_url() . 'site/assets/client_tickets_docs/';
                           foreach ( $vtf_booking as $v_booking ) {
                           	//Get cab_book Information 
                           	$vtf_booking_docs = $this->global_model->getdata( 'vtf_booking_docs', array("booking_id" => $v_booking->id ) );
                           	echo "<tr>
                           			<td>{$vd}.</td>
                           			<td>{$v_booking->booking_type}</td>";
                           			echo "<td>";
                           			if( $vtf_booking_docs ){
                           				echo "<table class='table table-bordered'>";
                           				$vbd = 1;
                           				foreach( $vtf_booking_docs as $b_docs  ){
                           					$d_link = '<a href="' . $doc_path . $b_docs->file_url .'" title="Click here to view/download" target="_blank" class="btn btn-success" style="position:relative;"><i class="fa fa-download"aria-hidden="true"></i></a>';
                           					
                           					echo "<tr>
                           						<td>{$vbd}.</td>
                           						<td>{$b_docs->description}</td>
                           						<td>{$d_link}</td>
                           					</tr>";	
                           					
                           					$vbd++;
                           				}	
                           				echo "</table>";
                           			}
                           			echo "</td>";
                           		echo "</tr>";
                           	$vd++;	
                           } ?>
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
         <?php } ?>
         <!-- Excursion -->
         <!--div class="container">
            <h5 class="cost">Inclusion</h5>
            <div class="Travel_details">
            <div class="table-responsive">
               <table class="table">
            <tr class="city">
            <th>City</th>
            <th>On Date </th>
            <th>Excursion</th>
            </tr>
            <tr>
            <td>Manali</td>
            <td>03/03/2019</td>
            <td class="honeymoon"></td>
            </tr>
               </table>
            </div>
            </div>
            </div-->
         <!-- Excursion end -->
         <!--itinerary-days --> 
         <?php if( $iti->iti_type == 1 ){ ?>
         <div class="itinerary-days">
            <span class="timeline__year row">Detail Itinerary</span>
            <div class="day-wise">
               <?php
                  //$day_wise = $iti->daywise_meta; 
                  //dump( $iti->daywise_meta ); die;
                  $tourData = unserialize( $iti->daywise_meta );
                  $count_day = count( $tourData );
                  if( $count_day > 0 ){
                  	//print_r( $tourData );
                  	for ( $i = 0; $i < $count_day; $i++ ) { 
                  		$day = $i+1;
                  		?>
               <div class="timeline__group">
                  <div class="timeline__box">
                     <div class="timeline__date" >
                        <span class="timeline__day">Day</span>
                        <span class="timeline__month"><?php echo $day; ?></span>
                     </div>
                     <div class="timeline__post">
                        <div class="timeline__content">
                           <h6><?php echo $tourData[$i]['tour_name']; ?> <span>( <?php echo display_date_month($tourData[$i]['tour_date']); ?> )</span></h6>
                           <p><?php echo $tourData[$i]['tour_des']; ?> </p>
                           <p>DISTANCE: <?php echo $tourData[$i]['tour_distance']; ?> KM </p>
                           <?php
                              //hot destination
                              if( isset($tourData[$i]['hot_des'] ) && !empty( $tourData[$i]['hot_des'] ) ){
                              	$hot_dest = '';
                              	$htd = explode(",", $tourData[$i]['hot_des']);
                              	foreach($htd as $t) {
                              		$t = trim($t);
                              		$hot_dest .= "<span>" . $t . "</span>";
                              	}
                              	echo '<div class="hot_des_view "><strong>Attraction: </strong>' . $hot_dest . '</div>';
                              }
                              ?>
                           <hr>
                           </hr>
                           <span class="icon-box">  
                           <span><i class="fas fa-binoculars"></i> Sightseeing</span>
                           <span><i class="fas fa-taxi"></i> Cab Transfer</span>
                           <span><i class="fas fa-utensils"></i> <?php echo $tourData[$i]['meal_plan']; ?></span>
                           </span>                      
                        </div>
                     </div>
                  </div>
               </div>
               <?php
                  }
                  }	?>
            </div>
         </div>
         <?php } ?>
         <!--itinerary-days end -->       
         <div class="container">
            <!-- Total Cost -->
            <?php
               $total_package_cost	= isset( $pay->total_package_cost) ? $pay->total_package_cost : 0;
               //$p_cost		= isset($pay->total_package_cost) ? number_format($pay->total_package_cost) : "";
               $advance 	= isset($pay->advance_recieved) ? $pay->advance_recieved : ""; 
               $balance 	= isset($pay->total_balance_amount) ?  $pay->total_balance_amount : "";
               $tax 		= get_tax();
               
               $is_gst_final = $pay->is_gst == 1 ? 1 : 0;
               //$is_gst_final = 0;
               
               if( $is_gst_final ){
               	$reverse_margin = $tax / 100;
               	$reverse_margin	 = $reverse_margin + 1;
               	$p_cost_n = round($total_package_cost / $reverse_margin );
               	$package_cost_tax = $total_package_cost - $p_cost_n;
               	$grand_total = number_format($total_package_cost);
               }else{
               	$p_cost_n = $total_package_cost;
               	$package_cost_tax = $total_package_cost * $tax / 100;
               	$grand_total = number_format($package_cost_tax + $total_package_cost);
               }
               
               ?>
            <div class="table-responsive">
               <table class="table">
                  <tr class="cost">
                     <th><strong>Tour Cost</strong></th>
                     <th>Rate For</th>
                     <th>Traveller</th>
                     <th>Rate</th>
                     <th>Currency</th>
                     <th>Conversion</th>
                     <th>Amount</th>
                  </tr>
                  <tr>
                     <th colspan="3"></th>
                     <th class="gross" colspan="3">Total</th>
                     <th class="text-right"><?php echo $p_cost_n; ?></th>
                  </tr>
                  <tr>
                     <td colspan="3"></td>
                     <td colspan="3">Add GST</td>
                     <td class="text-right"><?php echo $package_cost_tax; ?></td>
                  </tr>
                  <tr>
                     <th colspan="3" class="bal"><?php echo convert_indian_currency($grand_total); ?></th>
                     <th colspan="3" class="bal"><strong>Tour Cost in</strong> </th>
                     <th class="bal text-right"><strong><?php echo $grand_total; ?></strong></th>
                  </tr>
                  <tr>
                     <td colspan="3"></td>
                     <td colspan="3">Advance Received (1st ins.)</td>
                     <td class="text-right"><?php echo $advance; ?></td>
                  </tr>
                  <tr>
                     <td  colspan="3"></td>
                     <td colspan="3" class="bal"><strong>Total Balance Amount</strong></td>
                     <td class="text-right"><?php echo $balance; ?></td>
                  </tr>
               </table>
            </div>
            <!-- Total Cost end -->
            <!-- escalation --> 
            <?php $get_sales_team_details = get_settings(); ?>
            <div class="table-responsive">
               <table class="table">
                  <tr>
                     <th>
                        <h4>For any assistance/help please follow the escalation matrix given below</h4>
                     </th>
                  </tr>
                  <tr>
                     <td>
                        <strong>Volvo Contact :-</strong> 8215478547 <?php echo $get_sales_team_details->vehicle_email; ?> <br>
                        <strong>Cab Contact :-</strong> 8215478547 <?php echo get_cab_team_email(); ?>  <br>
                        <strong>Hotel Contact :- </strong> 8215478547 <?php echo $get_sales_team_details->hotel_email; ?> <br>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <h4> Payment (Balance payment will be collected at the time of checkin into the Package or Hotel) </h4>
                        <strong>Manali :</strong>-8215478547  <br>
                        <strong>Shimla :</strong>- 8215478547, 8215478547 <br>
                        <strong>Others :</strong>- 8215478547, 8215478547, sales@Trackitinerary.com  <br>
                        <strong>Complaint:</strong>- 8215478547, 8215478547, 8215478547, info@trackitinerary.com
                     </td>
                  </tr>
                  <?php
                     $agent_id = $iti->agent_id;
                     $user_info = get_user_info($agent_id);
                     $agent_name 	= isset( $user_info[0]->first_name ) ? $user_info[0]->first_name . " " . $user_info[0]->last_name : "";
                     $agent_mobile 	= isset( $user_info[0]->mobile ) ? $user_info[0]->mobile : "";
                     $agent_email 	= isset( $user_info[0]->email ) ? $user_info[0]->email : "";
                     ?>
                  <tr>
                     <td>
                        <h4>Sales Executive Detail</h4>
                        <?php echo $agent_name . " , " . $agent_mobile . " , " . $agent_email; ?>
                     </td>
                  </tr>
               </table>
            </div>
            <!-- escalation end--> 
            <hr>
            <!--Includes  Excludes -->
            <div class="row">
               <div class="col-md-6">
                  <h4>Includes</h4>
                  <ul class="list include">
                     <?php 
                        $inclusion = unserialize($iti->inc_meta); 
                        $count_inc = count( $inclusion );
                        $exclusion = unserialize($iti->exc_meta); 
                        $count_exc = count( $exclusion );
                        if( $count_inc > 0 ){
                        	for ( $i = 0; $i < $count_inc; $i++ ) {
                        		echo "<li><i class='fas fa-check'></i>" . $inclusion[$i]["tour_inc"] . "</li>";
                        	}	
                        }
                        ?>
                  </ul>
               </div>
               <div class="col-md-6">
                  <h4> Excludes</h4>
                  <ul  class="list exclude">
                     <?php if( $count_exc > 0 ){
                        for ( $i = 0; $i < $count_exc; $i++ ) {
                        	echo "<li> <i class='fas fa-times'></i>" . $exclusion[$i]["tour_exc"] . "</li>";
                        }	
                        }
                        ?>
                  </ul>
               </div>
            </div>
            <!--Includes  Excludes -->
            <hr>
            <!--terms-->
            <div class="terms">
               <h4>Terms and Condition</h4>
               <strong>Please Note </strong> There is no Contract between the company and the client until the company has received the initial deposit amount per person as specified for each tour package.<br>
               <ol class="terms_list">
                  <li>The full payment must be received in accordance with procedures laid down under Payments Terms. If not paid in that time, the company shall not refund the token amount of the package cost also expect the token amount rest of the payment will be the refunded as per the cancellation policy. </li>
                  <li>To amend, alter, vary or withdraw any tour, holiday, excursion or facility it has advertised or published or to substitute an Independent Contractor of similar class if it is deemed advisable or necessary. In either case, the Company shall not be liable for any damage, additional expense, or consequential loss suffered by the Clients or for any compensation claims made.</li>
                  <li>It is clear understanding between either parties that any loss arising on account of cancellation of flight / train / bus tickets booked by the Clients; either through the Company or on his/her own or through a third party; the Company shall not be liable for such losses or additional expense, or consequential loss suffered by the Clients. </li>
                  <li>No person other than the Company, in writing, has the authority to vary, add, amplify or waive any stipulation, representation, term or condition in this brochure.</li>
                  <li>In the event of the Company exercising its rights to amend or alter any of the services as mentioned in the itinerary, after such tour or holiday has been booked, the Client shall have the right: To continue with the tour or holiday as amended or altered. To accept any alternative tour or holiday which the company may offer. In either of these above cases the Client shall not be entitled to, or the Company shall not be liable to the Client for any damage. Additional expense, consequential loss suffered by him or to pay any amount as refund. </li>
                  <li>HEALTH & SAFETY The Company shall in no circumstances whatsoever will be liable to the Client or any person traveling for: Any death personal injury, sickness,
                     accident, loss , delay , discomfort ,increased expenses, consequential loss and / or damage or any misadventure howsoever caused Any act, omission, default or Independent Contractor or other person or be any servant or agent , employed by them who may be engaged or concerned in the provision of accommodation, refreshment, carriage facilities or service for the Client or for any person travelling with him howsoever caused.
                  </li>
                  <li>If the Client has any complaint in respect of the services provided by any of the Independent Contractors, the Client shall immediately notify the same in writing to the Independent Contractor and a copy thereof should be handed over to the Tour Manager of the Company in order to enable the Company to take up the matter with theIndependent Contractor so that in future other Clients do not face the same difficulty. </li>
                  <li>Any claim or complaint by the Client must be notified to the Company in writing within 7 days of the end of this holiday tour. No claim notified to this Company beyond this period will be entertained and the Company shall incur no liability whatsoever in respect thereof. </li>
                  <li>It is hereby declared that the immunities provided under this Contract shall be available to the Company's managers, including Tour managers, employees, servants and agents but not to the Independent Contractors selected by the Company. </li>
                  <li>INSURANCE The tour cost does not include the costs towards the insurance premium. Hence, it is advisable that the clients get insurance cover at their own costs. However, please note that the Client has to deal directly with the insurance providing company in case of settlement of any claims whatsoever. </li>
                  <li>The price quoted in our proposal has been calculated at the rate prevailing at the time of printing this brochure. The Company reserves the right to amend the price published in this brochure in case of costs increased before the date of departure. All such increases in price must be paid for in full before departure by the Client. </li>
                  <li>FORCE MAJORED Acts of god (including exceptional adverse weather conditions), earthquake, fire , war (declared or undeclared), invasion, rebellion, revolt, riot, civil commotion, civil war, nuclear fission, strike, act(s) of omission/commission by any concerned government(s), or government agencies, judicial or quasi-judicial authorities, occurrence of any event can force the Company to change or extended. Hence any additional expenditure occurred due to the above reasons the same will be borne by the passengers.</li>
               </ol>
               <p><strong>MEALS MENU</strong> The menus are pre-set menus provided for breakfast/lunch/dinner on the tour as mentioned under each Tour itinerary as printed in our brochure. We cannot process a special meal nor do we guarantee the special diet to the customer. We however reserve the right to change the meal arrangement if circumstances make it necessary to do so. In the event that a tour participant wakes up late and misses the breakfast offered to him and in the event that the tour participant is out on his own and reaches late and misses lunch/ dinner, then no claim can be made for the meal which he has missed and not utilized. </p>
               <p><strong>ITINERARY CHANGES</strong> For the comfort and convenience of our passengers, we will sometimes reverse the direction, or slightly amend the itinerary. We will try to advise you of these amendments, prior to the start of the tour or on tour. In the event that a tour participant misses on any part of the sightseeing tour or any such tour due to delay on his part, he will not be entitled to claim refund of the same. </p>
               <p><strong> TERMS</strong> We have mentioned the names of the Hotels for each tour, we reserve the right to change the same due to unavoidable circumstances. In that case we may provide alternative, similar accommodation for which we are not liable to pay any refund. We will not be responsible or liable in case of loss of property or life at the Hotel.</p>
               <p>Similarly any damages caused to the hotel rooms during your stay, shall be payable by the Clients and the Company will not be liable for the same. </p>
               <ol>
                  <li>The hotel confirmed will be as per the brochure or an alternate hotel of similar category& We are not resposible for the services of one star & two star hotels.</li>
                  <li>It is mandatory to carry a Government recognised photo identity card (Passport / Driving Licence / Voter ID card)</li>
                  <li>Free! Two child under 6 years stays free of charge when using existing beds.</li>
                  <li>Extra Charge! child Above 6 years To 15 years treated as child with bed</li>
                  <li>The primary guest checking in to the hotel must be at least 18 years of age. Children accompanying adults must be between 1-15 years. </li>
                  <li>The inclusion of extra bed with a booking is facilitated with a folding cot or a mattress as an extra bed. </li>
                  <li>Early check-in or late check-out is subject to availability and may be chargeable by the hotel. The standard check-in time is 12 PM and the standard check-out time is 12 PM. After booking you will be sent an email confirmation with hotel phone number. You can contact the hotel directly for early check-in or late check-out.</li>
                  <li>The amount paid for the room does not include charges for optional services and facilities (such as room service, mini bar, snacks or telephone calls). These will be charged at the time of check-out. </li>
                  <li> The hotel reserves the right of admission. Accommodation can be denied to guests posing as a couple if suitable proof of identification is not presented at check-in. Track Itinerary will not be responsible for any check-in denied by the hotel due to the aforesaid reason. </li>
                  <li>The hotel reserves the right of admission for local residents. Accommodation can be denied to guests residing in the same city. Track Itinerary will not be responsible for any check-in denied by the hotel due to the aforesaid reason. </li>
               </ol>
               <p><strong>TRANSPORT / COACH /SITTING</strong> We use Deluxe 2 X 2 Luxury Coaches or vehicles such as Tempo Traveller, Tata Winger, Chevrolet Tavera, Mahindra Scorpio, Toyota Qualis, Tata Sumo as per the availability of vehicles and actual size of the group. In case of Coach / Mini coach /Tempo Traveller the seat numbers are allocated on a first come first serve basis, as per the booking date and the same will remain same throughout the tour. Our tour manager / local representative will take reasonable care of your luggage but if you are carrying any high value items on the coach, we advise you not to leave them behind when you leave the coach. We will not be responsible or liable in case of theft or robbery of the said items from the coach. All baggage and personal effects are at all times and under all circumstances your responsibility. Any damages caused to the hotel rooms / coach during your stay, shall be payable by the Clients and the Company will not be liable for the same. The drivers of the vehicles are bound by specific rules like maximum driving hours within a day/during a week, rest period per day/week etc. Clients will have to strictly adhere to the prescribed timetable for the day so that the driver can complete the travel. In case, any of the sightseeing schedules is missed due to delays caused by the client, the same will not be refunded to the client under any circumstances. Vehicle will be provided as per group size.</p>
               <p><strong>TRANSFER FROM ONE TOUR TO ANOTHER</strong> A transfer from one tour to another of the originally booked tour will be treated as a cancellation on that tour, thereby attracting the cancellation charges as stated in these terms and a fresh booking on another.</p>
               <p><strong>BOOKING & PAYMENT CONDITIONS</strong> For booking confirmation, need to pay 50 % amount as First Installment in company account by Checque/Cash/Net banking/Credit card /Debit card in our company account & online through our website. (www.trackitinerary.com ). Second Installment amount should be paid at the time of check in at hotel.</p>
               <p><strong>PREPONE AND POSTPONE</strong> For postpone/Prepone of tour packages are to be communicated in written and need to be inform us at least 12 days prior of tour date. INR 3000/- will be charged extra for prepone/postpone.</p>
               <p><strong>Law & Jurisdiction</strong> For all complaints, suits, claims or disputes of whatsoever nature relating to any products including tours by the Company and third party products and tours, the courts and tribunals in Manali, India alone shall have exclusive jurisdiction. All tours are subject to laws, rules of RBI / Govt. of India Upon signing the booking form, the above-mentioned terms & conditions shall be binding on both the Company and the Cleint and shall become the only basis of relations between the parties and all previous communication in whatsoever form or mode whether oral or otherwise, with respect to any terms & conditions of the tour and services shall stand cancelled / revoked /terminated.</p>
            </div>
            <!--terms-->
            <hr>
            <!--Notes -->
            <h4> Notes</h4>
            <p>
               The hotel confirmed will be as per the brochure or an alternate hotel of similar category. It is mandatory to carry a Government recognized photo identity card (Passport / Driving Licence / Voter ID card)</br>
               Free! Two child under 6 years stays free of charge when using existing beds.<br>
               Extra Charge! child Above 6 years To 15 years treated as child with bed. The primary guest checking in to the hotel must be at least 18 years of age. Children accompanying adults must be between 1-15 years. <br>
               The inclusion of extra bed with a booking is facilitated with a folding cot or a mattress as an extra bed. Early check-in or late check-out is subject to availability and may be chargeable by the hotel. The standard check-in time is 12 PM and the standard check-out time is 12 PM. After booking you will be sent an email confirmation with hotel phone number. You can contact the hotel directly for early check-in or late check-out. <br>
               The amount paid for the room does not include charges for optional services and facilities (such as room service, mini bar, snacks or telephone calls). These will be charged at the time of check-out. The hotel reserves the right of admission. Accommodation can be denied to guests posing as a couple if suitable proof of identification is not presented at check-in. Track Itinerary will not be responsible for any check-in denied by the hotel due to the aforesaid reason. <br>
               The hotel reserves the right of admission for local residents. Accommodation can be denied to guests residing in the same city. Track Itineray will not be responsible for any check-in denied by the hotel due to the aforesaid reason.<br>   
            </p>
            <!--Notes -->
            <hr>
            <!--Cancellation Policy -->
            <h4>Cancellation Policy </h4>
            <strong>Cancellation Of The Tour By Client</strong>
            <p>If the Client is willing to amend or cancel his/her booking because of whatsoever reasons including death, accident,illness, or any other personal reasons including non-payment of the balance payment, the Company is liable to recover Cancellation charges from the Client.All cancellations are to be communicated in written and advance amount is non refundable, besides the forfeiture of the deposit amount of the tour. If you wish to cancel your tour, you must intimate the Company as follows provided that such intimation should be given on a working day within working hours:</p>
            By fax at 0177 2625636 followed by a written communication to our Registered Office listed below<br>
            <p class="text-center"> OR</p>
            By email to contact@trackitinerary followed by a written communication to our Registered Office listed below 
            <p class="text-center"> OR</p>
            In writing on working days within working hours at the Registered Office of the <br>
            <strong>When a cancellation is made Cancellation charges</strong><br>
            Clear 30 to 15 working days prior to the date of departure of the Tour. 50 % of the Tour Cost<br>
            Clear 15 to 07 working days prior to the date of departure of the Tour. 75 % of the Tour Cost<br>
            Less than 07 clear working days prior to the date of departure of the Tour. 100 % of the Tour Cost Regards<br>
            <p>&nbsp;</p>
            <strong>Track in_itinerary Team.</strong> <br>
            Call Us : 9816155636 / 9418066636 / 0177- 2625636 <br>
            E-mail : : info@trackitinerary.com / contact@trackitinerary.com <br>
            Timing : 9:00 AM To 8:00 PM (IST) : <br>
            <hr>
            <div class="row">
               <div class="col-md-6">
                  <strong>Refund</strong> <br>
                  TOKEN AMOUNT: Token amount is Non - Refundable in any case.
               </div>
               <div class="col-md-6">
                  <strong>Jurisdiction</strong><br>
                  SHIMLA
               </div>
            </div>
            <p>E. & O. E. for Track Itinerary PVT LTD</p>
            <hr>
            <div class="row">
               <div class="col-md-6">
                  <p>&nbsp;</p>
                  <p>&nbsp;</p>
                  <p>&nbsp;</p>
                  Customer's Signature
               </div>
               <div class="col-md-6 text-right">
                  <p>&nbsp;</p>
                  <p>&nbsp;</p>
                  Authorized Signatory<br>
                  <!--em>(Prepared by: ABHISHEK CHAUHAN) </em-->
               </div>
            </div>
            <hr>
            <p class="text-center small"><em>This is a Computer generated document and does not require any signature.</em></p>
         </div>
         <!-- container -->
      </div>
      <!--wrapper end-->
      <!-- footer -->  
      <!-- <footer class="bg-blue">
         <div class="container">
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
                        <img class="img-responsive" src="https://trackitinerary.org/site/assets/images/payment-type.png" alt="Payment Modes"     width="100%">
                     </div>
                  </div>
               </div>
            </div>
            <div class="row">
               <nav class="col-md-12">
                  <ul class="footer-menu">
                     <li><a href="https://trackitinerary.org/promotion/testimonials">Clients Feedback</a></li>
                     <li><a href="https://tracktinerary.org/promotion/contact_us">Contact Us</a></li>
                  </ul>
               </nav>
               <div class="foot-boxs">
                  <div class="footer-box col-md-4 text-right">
                     <span>Stay Connected</span>
                     <ul class="social-media footer-social">
                        <li><a class="fab fa-google-plus-g" href="https://plus.google.com/u/0/454445456"  target="_blank"><span> </span></a></li>
                        <li><a class="fab fa-facebook-f" href="https://www.facebook.com/trackitinerary/"  target="_blank"><span> </span></a></li>
                        <li><a class="fas fa-rss" href="https://www.rss.com/"  target="_blank"><span></span></a></li>
                        <li><a class="fab fa-pinterest" href="https://www.pinterest.com/trackitinerary/"  target="_blank"><span> </span></a></li>
                        <li><a class="fab fa-twitter" href="https://twitter.com/trackitinerary"  target="_blank"><span></span></a></li>
                        <li><a class="fab fa-linkedin-in" href="https://www.linkedin.com/"  target="_blank"><span></span></a></li>
                     </ul>
                  </div>
                  <div class="footer-box foot-box-md col-md-4">
                     <span class="contact-email"><i class="fas fa-envelope" aria-hidden="true"></i> &nbsp; <a href="mailto:info@trackitinerary.com"> info@trackitinerary.com</a></span>
                     <span class="contact-phone"><i class="fas fa-phone" aria-hidden="true"></i>&nbsp; <a href="tel:<?php echo company_contact(); ?>"><?php echo company_contact(); ?></a></span>
                  </div>
                  <div class="footer-box col-md-4">
                     <span class="">© <?php echo date("Y"); ?> Trackitinerary. All Rights Reserved.</span>
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