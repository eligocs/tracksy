<!doctype html/>
<html lang="en">
   <head>
      <meta charset="utf-8" />
      <title>Track Itinerary Pvt. Lmt.</title>
      <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
      <link href="https://fonts.googleapis.com/css?family=Open+Sans|Oswald|Raleway|Source+Sans+Pro" rel="stylesheet">
      <link href="<?php echo base_url();?>site/assets/css/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
      <link rel="stylesheet" href="<?php echo base_url();?>site/assets/css/style_client_view.css">
      <link rel="shortcut icon" type="image/x-icon" href="<?php echo site_url(); ?>site/images/favicon.ico" />
      <!--link rel="text/javascript" href="js/javascript.js"-->
      <script src="<?php echo base_url();?>site/assets/js/jquery.min.js" type="text/javascript"></script>
      <script src="<?php echo base_url();?>site/assets/js/jquery.validate.min.js" type="text/javascript"></script>
      <script type="text/javascript" async="" src="http://www.google-analytics.com/ga.js"></script>
      <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js" integrity="sha256-xNjb53/rY+WmG+4L6tTl9m6PpqknWZvRt0rO1SRnJzw=" crossorigin="anonymous"></script>
      <style>tr.strikeLine {text-decoration: line-through;}
         blink {
         -webkit-animation: 1s linear infinite condemned_blink_effect; // for android
         animation: 1s linear infinite condemned_blink_effect;
         }
         @-webkit-keyframes condemned_blink_effect { // for android
         0% {
         visibility: hidden;
         color: red;
         }
         50% {
         visibility: hidden;
         }
         100% {
         visibility: visible;
         }
         }
         @keyframes condemned_blink_effect {
         0% {
         visibility: hidden;
         color: red;
         }
         50% {
         visibility: hidden;
         }
         100% {
         visibility: visible;
         }
         }
      </style>
   </head>
   <body class="view_client_iti">
      <?php if( !empty($itinerary[0] ) ){  
         $iti = $itinerary[0];
         
         //terms
         $terms = get_terms_condition();
         $online_payment_terms	 	= isset($terms[0]) && !empty($terms[0]->bank_payment_terms_content) ? unserialize($terms[0]->bank_payment_terms_content) : "";
         $advance_payment_terms		= isset($terms[0]) && !empty($terms[0]->advance_payment_terms) ? unserialize($terms[0]->advance_payment_terms	) : "";
         $cancel_tour_by_client 		= isset($terms[0]) && !empty($terms[0]->cancel_content) ? unserialize( $terms[0]->cancel_content) : "";
         $terms_condition			= isset($terms[0]) && !empty($terms[0]->terms_content) ? unserialize($terms[0]->terms_content) : "";
         $disclaimer 				= isset($terms[0]) && !empty($terms[0]->disclaimer_content) ? htmlspecialchars_decode($terms[0]->disclaimer_content) : "";
         $greeting 					= isset($terms[0]) && !empty($terms[0]->greeting_message) ? $terms[0]->greeting_message : "";
         $amendment_policy			= isset($terms[0]) && !empty($terms[0]->amendment_policy) ? unserialize( $terms[0]->amendment_policy) : "";
         $book_package_terms			= isset($terms[0]) && !empty($terms[0]->book_package) ? unserialize( $terms[0]->book_package) : "";
         $signature					= isset($terms[0]) && !empty($terms[0]->promotion_signature) ?  htmlspecialchars_decode($terms[0]->promotion_signature) : "";
         $payment_policy				= isset($terms[0]) && !empty($terms[0]->payment_policy) ? unserialize($terms[0]->payment_policy) : "";				
         
         //Get customer info
         $get_customer_info = get_customer( $iti->customer_id ); 
         $cust = $get_customer_info[0];
         if( !empty( $get_customer_info ) ){  
         	$customer_name = $cust->customer_name;
         	$customer_contact = $cust->customer_contact;
         	$customer_email = $cust->customer_email;
         }else{
         	$customer_name = "";
         	$customer_contact = "";
         	$customer_email = "";
         }
         ?>
      <div id="snow"></div>
      <div class="back_white">
         <div class="header">
            <div class="logo_samouran_yatra"></div>
            <div class="address_bar">
               <ul>
                  <li>Phone No: <?php echo company_contact(); ?></li>
                  <li>Email:info@trackitinerary.com</li>
                  <li>Website:www.trackitinerary.com</li>
               </ul>
            </div>
         </div>
      </div>
      <div class="template">
         <div class="content">
            <div class="customer_info">Hi <span><?php echo $customer_name; ?> </span>,</div>
            <div class="greetings well well-sm">
               <h3 class="heading_track">GREETINGS FROM Track Itinerary</h3>
               <p><?php echo $greeting; ?></p>
            </div>
            <hr>
            <div class="well well-sm">
               <h3 class="heading_new">Package Overview</h3>
            </div>
            <div class="table-1">
               <table class="table-bordered ">
                  <tbody>
                     <tr class="thead-inverse">
                        <td><strong>Name of Package</strong></td>
                        <td><strong>Routing</strong></td>
                        <td><strong>Duration</strong></td>
                     </tr>
                     <tr>
                        <td><?php echo $iti->package_name; ?></td>
                        <td><?php echo $iti->package_routing; ?></td>
                        <td><?php echo $iti->duration; ?></td>
                     </tr>
                     <tr class="thead-inverse">
                        <td><strong>No of Travellers</strong></td>
                        <td><strong>Cab Category</strong></td>
                        <td><strong>Quotation Date</strong></td>
                     </tr>
                     <tr>
                        <td>
                           <?php
                              echo "<strong> Adults: </strong> " . $iti->adults; 
                              if( !empty( $iti->child ) ){
                              	echo "<strong> No. of Child: </strong> " . $iti->child; 
                              	echo "<strong> Child age: </strong> " . $iti->child_age; 
                              }
                              ?>
                        </td>
                        <td><?php echo get_car_name( $iti->cab_category); ?></td>
                        <td><?php echo $iti->quatation_date; ?></td>
                     </tr>
                     <?php
                        $room_category = $total_rooms = $with_extra_bed  = $without_extra_bed = "-";
                        if( isset( $iti->rooms_meta) && !empty( $iti->rooms_meta ) ){
                        	$rooms_meta 	= unserialize( $iti->rooms_meta );
                        	$room_category 	= isset($rooms_meta["room_category"]) && !empty( $rooms_meta["room_category"] ) ? get_roomcat_name($rooms_meta["room_category"]) : "-";
                        	$total_rooms 		= isset($rooms_meta["total_rooms"]) && !empty( $rooms_meta["total_rooms"] ) ? $rooms_meta["total_rooms"] : "-";
                        	$with_extra_bed 	= isset($rooms_meta["with_extra_bed"]) && !empty( $rooms_meta["with_extra_bed"] ) ? $rooms_meta["with_extra_bed"] : "No";
                        	$without_extra_bed 	= isset($rooms_meta["without_extra_bed"]) && !empty( $rooms_meta["without_extra_bed"] )  ? $rooms_meta["without_extra_bed"] : "No";
                        }  ?>
                     <tr class="thead-inverse">
                        <td>Room Category</td>
                        <td>Total Rooms</td>
                        <td>With extra bed</td>
                     </tr>
                     <tr>
                        <td><?php echo $room_category; ?></td>
                        <td><?php echo $total_rooms; ?></td>
                        <td><?php echo $with_extra_bed; ?></td>
                     </tr>
                     <tr class="thead-inverse">
                        <td>Without extra bed</td>
                     </tr>
                     <tr>
                        <td><?php echo $without_extra_bed; ?></td>
                     </tr>
                  </tbody>
               </table>
            </div>
         </div>
         <hr>
         <div class="itenerary_packages well well-sm">
            <h3>DETAILED ITINERARY:</h3>
            <?php $day_wise = $iti->daywise_meta; 
               $tourData = unserialize($day_wise);
               $count_day = count( $tourData );
               if( $count_day > 0 ){
               	//print_r( $tourData );
               	for ( $i = 0; $i < $count_day; $i++ ) {
               		//echo "";
               			echo "<div class='meta'><div class='desc'><span class='day'>Day: ".$tourData[$i]['tour_day']. "</span> <span class='date'><i class='fa fa-calendar-check-o' aria-hidden='true'></i> " .$tourData[$i]['tour_date'] . "</span> <span class='meal'><i class='fa fa-cutlery' aria-hidden='true'></i> " .$tourData[$i]['meal_plan'] ." </span></div></div>";
               			echo "<div class='trip'> <h2 class='tour_title_name'> ".  $tourData[$i]['tour_name'] . "( " . $tourData[$i]['tour_distance'] . " KMS ) </h2> <p class='description'>" .$tourData[$i]['tour_des'] . "</p>";
               			//echo "<div id='inline-meal-plan'>"; 
               			//echo "</div>"; 
               			//hot destination
               			if( isset($tourData[$i]['hot_des'] ) && !empty( $tourData[$i]['hot_des'] ) ){
               				$hot_dest = '';
               				$htd = explode(",", $tourData[$i]['hot_des']);
               				foreach($htd as $t) {
               					$t = trim($t);
               					$hot_dest .= "<span>" . $t . "</span>";
               				}
               				echo '<div class="hot_destination_view"><div class="day_yellow"><i class="fa fa-map-marker" aria-hidden="true"></i>Hot Destination :</div>' . $hot_dest . '</div>';
               			}	
               		echo "</div>";
               	}
               }	?>
         </div>
         <div class="row2">
            <hr>
            <div class="well well-sm">
               <h3>Inclusion &amp; Exclusion</h3>
            </div>
            <div class="table-responsive inclusion">
               <table class="table table-bordered">
                  <thead class="thead-default">
                     <tr>
                        <th> Inclusion</th>
                        <th> Exclusion</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php 
                        $inclusion = unserialize($iti->inc_meta); 
                        $count_inc = count( $inclusion );
                        $exclusion = unserialize($iti->exc_meta); 
                        $count_exc = count( $exclusion );
                        echo "<tr><td><ul>";
                        if( $count_inc > 0 ){
                        	for ( $i = 0; $i < $count_inc; $i++ ) {
                        		echo "<li>" . $inclusion[$i]["tour_inc"] . "</li>";
                        	}	
                        }
                        echo "</ul></td><td><ul>";
                        if( $count_exc > 0 ){
                        	for ( $i = 0; $i < $count_exc; $i++ ) {
                        		echo "<li>" . $exclusion[$i]["tour_exc"] . "</li>";
                        	}	
                        }
                        echo "</ul></td></tr>";
                        ?>
                  </tbody>
               </table>
            </div>
            <?php 
               //check if special inclusion exists
               $sp_inc = unserialize($iti->special_inc_meta); 
               $count_sp_inc = count( $sp_inc );
               if( !empty($sp_inc) ){  ?>
            <div class="well well-sm">
               <h3>Special Inclusions</h3>
            </div>
            <?php
               echo "   <ul class='inclusion'>";
               if( $count_sp_inc > 0 ){
               	for ( $i = 0; $i < $count_sp_inc; $i++ ) {	
               		echo "<li> <i class='fa fa-check-circle-o' aria-hidden='true'></i> " . $sp_inc[$i]["tour_special_inc"] . "</li>";
               	}	
               }
               echo "</ul>";
               } ?>
            <?php 
               //check benefits 
               $benefits_m = unserialize($iti->booking_benefits_meta); 
               $count_bn_inc = count( $benefits_m );
               if( !empty($benefits_m) ){ ?>
            <div class="well well-sm">
               <h3  style="background: green !important; color: #fff;">
                  <blink>Benefits of Booking With Us:</blink>
               </h3>
            </div>
            <?php
               echo "   <ul class='inclusion'>";
               if( $count_bn_inc > 0 ){
               	for ( $i = 0; $i < $count_bn_inc; $i++ ) {
               		$si = isset($benefits_m[$i]['benefit_inc']) ? $benefits_m[$i]['benefit_inc']: "";
               		echo "<li> <i class='fa fa-check-circle-o' aria-hidden='true'></i> " . $si . "</li>";
               	}	
               }
               echo "</ul>";
               } ?>
            <hr>
            <div class="well well-sm">
               <h3>Hotel Details</h3>
            </div>
            <div class="table-2">
               <?php $hotel_meta = unserialize($iti->hotel_meta); 
                  if( !empty( $hotel_meta ) ){
                  	$count_hotel = count( $hotel_meta );
                  	$strike_class_final = !empty( $iti->final_amount ) && get_iti_booking_status($iti->iti_id) == 0 ? "strikeLine" : "";
                  	$f_cost =  !empty( $iti->final_amount ) && get_iti_booking_status($iti->iti_id) == 0 ? "<strong class='green'> " . number_format($iti->final_amount) . " /-</strong> " : "";
                  	?>
               <table class="table table-bordered">
                  <thead class="thead-default">
                     <tr>
                        <th> Hotel Category</th>
                        <th> Deluxe</th>
                        <th> Super Deluxe</th>
                        <th> Luxury</th>
                        <th> Super Luxury</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php 
                        /* print_r( $hotel_meta ); */
                        if( $count_hotel > 0 ){
                        	//get percentage added by agent
                        	$agent_price_percentage = !empty($iti->agent_price) ? $iti->agent_price : 0;
                        	for ( $i = 0; $i < $count_hotel; $i++ ) {
                        		echo "<tr><td><strong>" .$hotel_meta[$i]["hotel_location"] . "</strong></td><td>";
                        			$hotel_standard =  $hotel_meta[$i]["hotel_standard"];
                        			echo $hotel_standard;
                        		echo "</td><td >";
                        			$hotel_deluxe =  $hotel_meta[$i]["hotel_deluxe"];
                        			echo $hotel_deluxe;
                        		echo "</td><td>";
                        			$hotel_super_deluxe =  $hotel_meta[$i]["hotel_super_deluxe"];
                        			echo $hotel_super_deluxe;
                        		echo "</td><td>";
                        			$hotel_luxury =  $hotel_meta[$i]["hotel_luxury"];
                        			echo $hotel_luxury;
                        		echo "</td></tr>";
                        	} 	
                        	//Rate meta
                        	$rate_meta = unserialize($iti->rates_meta);
                        	$strike_class = !empty( $discountPriceData ) ? "strikeLine" : " ";
                        	//print_r( $rate_meta );
                        	if( !empty( $rate_meta ) && $iti->pending_price == 2 ){
                        		//get per person price
                        		$per_person_ratemeta 	= unserialize($iti->per_person_ratemeta);
                        		//$inc_gst = isset( $per_person_ratemeta["inc_gst"] ) && $per_person_ratemeta["inc_gst"] == 1 ? "(GST Inc.)" : "(GST Extra)";
                        		$inc_gst = "";
                        		
                        		$s_pp = isset( $per_person_ratemeta["standard_rates"] ) && !empty($per_person_ratemeta["standard_rates"]) ? " Rs." . $per_person_ratemeta["standard_rates"] +  $per_person_ratemeta["standard_rates"] * $agent_price_percentage/100 . " Per/Person" : "";
                        		$d_pp = isset( $per_person_ratemeta["deluxe_rates"] ) && !empty($per_person_ratemeta["deluxe_rates"]) ? " Rs." . $per_person_ratemeta["deluxe_rates"] +  $per_person_ratemeta["deluxe_rates"] * $agent_price_percentage/100 . " Per/Person" : "";
                        		$sd_pp = isset( $per_person_ratemeta["super_deluxe_rates"] ) && !empty($per_person_ratemeta["super_deluxe_rates"]) ? " Rs." . $per_person_ratemeta["super_deluxe_rates"] +  $per_person_ratemeta["super_deluxe_rates"] * $agent_price_percentage/100 . " Per/Person" : "";
                        		$l_pp = isset( $per_person_ratemeta["luxury_rates"] ) && !empty($per_person_ratemeta["luxury_rates"]) ? " Rs." . $per_person_ratemeta["luxury_rates"] +  $per_person_ratemeta["luxury_rates"] * $agent_price_percentage/100  . " Per/Person" : "";
                        
                        		//child rates
                        		$child_s_pp = isset( $per_person_ratemeta["child_standard_rates"] ) && !empty($per_person_ratemeta["child_standard_rates"]) ? "RS. " .  number_format( $per_person_ratemeta["child_standard_rates"]  + $per_person_ratemeta["child_standard_rates"] * $agent_price_percentage/100  ) . "/- Per Child" : "";
                        		
                        		$child_d_pp = isset( $per_person_ratemeta["child_deluxe_rates"] ) && !empty($per_person_ratemeta["child_deluxe_rates"]) ? "RS. " . number_format( $per_person_ratemeta["child_deluxe_rates"] +  $per_person_ratemeta["child_deluxe_rates"] * $agent_price_percentage/100 ) . "/- Per Child" : "";
                        		
                        		$child_sd_pp = isset( $per_person_ratemeta["child_super_deluxe_rates"] ) && !empty($per_person_ratemeta["child_super_deluxe_rates"]) ? "RS. " . number_format( $per_person_ratemeta["child_super_deluxe_rates"] +  $per_person_ratemeta["child_super_deluxe_rates"] * $agent_price_percentage/100 ) . "/- Per Child" : "";
                        		
                        		$child_l_pp = isset( $per_person_ratemeta["child_luxury_rates"] ) && !empty($per_person_ratemeta["child_luxury_rates"]) ? "RS. " .   number_format( $per_person_ratemeta["child_luxury_rates"] +  $per_person_ratemeta["child_luxury_rates"] * $agent_price_percentage/100 ) . "/- Per Child" : "";													
                        		
                        		$standard_rates = !empty( $rate_meta["standard_rates"]) ? number_format($rate_meta["standard_rates"] + $rate_meta["standard_rates"] * $agent_price_percentage / 100 ) . "/-" : "<strong class='red'>On Request</strong>";
                        		
                        		$deluxe_rates = !empty( $rate_meta["deluxe_rates"]) ? number_format($rate_meta["deluxe_rates"] + $rate_meta["deluxe_rates"] * $agent_price_percentage / 100 ) . "/-" : "<strong class='red'>On Request</strong>";
                        		
                        		$super_deluxe_rates = !empty( $rate_meta["super_deluxe_rates"]) ? number_format($rate_meta["super_deluxe_rates"] + $rate_meta["super_deluxe_rates"] * $agent_price_percentage / 100  ) . "/-" : "<strong class='red'>On Request</strong>";
                        		$rate_luxry = !empty( $rate_meta["luxury_rates"]) ? number_format($rate_meta["luxury_rates"] + $rate_meta["luxury_rates"] * $agent_price_percentage / 100 ) . "/-" : "<strong class='red'>On Request</strong>";
                        	    
                        	    
                        		echo "<tr class='{$strike_class} {$strike_class_final}'><td>Price</td>
                        				<td>
                        					Rs. <strong>" . $standard_rates. "</strong> {$inc_gst} <br> {$s_pp} <br> {$child_s_pp} 
                        				</td>
                        				<td>
                        					Rs. <strong>" .$deluxe_rates. "</strong> {$inc_gst} <br> {$d_pp}<br> {$child_d_pp} 
                        				</td>
                        				<td>
                        					Rs. <strong>" . $super_deluxe_rates. "</strong> {$inc_gst} <br> {$sd_pp}<br> {$child_sd_pp} 
                        				</td>
                        				<td>
                        					Rs. <strong>" . $rate_luxry . "</strong> {$inc_gst} <br> {$l_pp}<br> {$child_l_pp} 
                        				</td></tr>";
                        	}else{
                        		echo "<tr><td><strong class='red'>Price</strong></td>
                        				<td>
                        					<strong class='red'> Coming Soon </strong>
                        				</td>
                        				<td>
                        					<strong class='red'> Coming Soon</strong>
                        				</td>
                        				<td>
                        					<strong class='red'> Coming Soon </strong>
                        				</td>
                        				<td>
                        					<strong class='red'> Coming Soon </strong>
                        				</td></tr>";
                        	}
                        	
                        	//discount data
                        	if( !empty( $discountPriceData ) ){
                        		foreach( $discountPriceData as $price ){
                        			$agent_price_percentage = !empty($price->agent_price) ? $price->agent_price : 0;
                        			$sent_status = $price->sent_status;
                        			if( $sent_status ){
                        				//get per person price
                        				$per_person_ratemeta 	= unserialize($price->per_person_ratemeta);
                        				//$inc_gst = isset( $per_person_ratemeta["inc_gst"] ) && $per_person_ratemeta["inc_gst"] == 1 ? "(GST Inc.)" : "(GST Extra)";
                        				$inc_gst = "";
                        				$s_pp = isset( $per_person_ratemeta["standard_rates"] ) && !empty($per_person_ratemeta["standard_rates"] ) ? "RS. " . number_format( $per_person_ratemeta["standard_rates"] +  $per_person_ratemeta["standard_rates"] * $agent_price_percentage/100 ) . "/- Per Person" : "";
                        				$d_pp = isset( $per_person_ratemeta["deluxe_rates"] ) && !empty($per_person_ratemeta["deluxe_rates"]) ? "RS. " . number_format($per_person_ratemeta["deluxe_rates"] +  $per_person_ratemeta["deluxe_rates"] * $agent_price_percentage/100 ) . "/- Per Person" : "";
                        				$sd_pp = isset( $per_person_ratemeta["super_deluxe_rates"] ) && !empty($per_person_ratemeta["super_deluxe_rates"]) ? "RS. " . number_format($per_person_ratemeta["super_deluxe_rates"] +  $per_person_ratemeta["super_deluxe_rates"] * $agent_price_percentage/100) . "/- Per Person" : "";
                        				$l_pp = isset( $per_person_ratemeta["luxury_rates"] ) && !empty($per_person_ratemeta["luxury_rates"]) ? "RS. " . number_format($per_person_ratemeta["luxury_rates"] +  $per_person_ratemeta["luxury_rates"] * $agent_price_percentage/100 ) . "/- Per Person" : "";
                        				
                        				//child rates
                        				$child_s_pp = isset( $per_person_ratemeta["child_standard_rates"] ) && !empty($per_person_ratemeta["child_standard_rates"]) ? "RS. " . number_format($per_person_ratemeta["child_standard_rates"] +  $per_person_ratemeta["child_standard_rates"] * $agent_price_percentage/100 ) . "/- Per Child" : "";
                        				$child_d_pp = isset( $per_person_ratemeta["child_deluxe_rates"] ) && !empty($per_person_ratemeta["child_deluxe_rates"]) ? "RS. " . number_format($per_person_ratemeta["child_deluxe_rates"] +  $per_person_ratemeta["child_deluxe_rates"] * $agent_price_percentage/100) . "/- Per Child" : "";
                        				$child_sd_pp = isset( $per_person_ratemeta["child_super_deluxe_rates"] ) && !empty($per_person_ratemeta["child_super_deluxe_rates"]) ? "RS. " . number_format($per_person_ratemeta["child_super_deluxe_rates"] +  $per_person_ratemeta["child_super_deluxe_rates"] * $agent_price_percentage/100 ) . "/- Per Child" : "";
                        				$child_l_pp = isset( $per_person_ratemeta["child_luxury_rates"] ) && !empty($per_person_ratemeta["child_luxury_rates"]) ? "RS. " . number_format($per_person_ratemeta["child_luxury_rates"] +  $per_person_ratemeta["child_luxury_rates"] * $agent_price_percentage/100 ) . "/- Per Child" : "";			
                        				
                        				//get rates
                        				$s_price = !empty( $price->standard_rates) ? number_format($price->standard_rates + $price->standard_rates * $agent_price_percentage/100 ) . "/- {$inc_gst} <br> {$s_pp} <br> {$child_s_pp}" : "<strong class='red'>On Request</strong>";
                        				
                        				$d_price = !empty( $price->deluxe_rates) ? number_format($price->deluxe_rates + $price->deluxe_rates * $agent_price_percentage/100) . "/- {$inc_gst} <br> {$d_pp} <br> {$child_d_pp}" : "<strong class='red'>On Request</strong>";
                        				
                        				$sd_price = !empty( $price->super_deluxe_rates) ? number_format($price->super_deluxe_rates + $price->super_deluxe_rates * $agent_price_percentage/100) . "/- {$inc_gst} <br> {$sd_pp} <br> {$child_sd_pp}"  : "<strong class='red'>On Request</strong>";
                        				
                        				$l_price = !empty( $price->luxury_rates) ? number_format($price->luxury_rates + $price->luxury_rates * $agent_price_percentage/100) . "/- {$inc_gst} <br> {$l_pp} <br> {$child_l_pp}"  : "<strong class='red'>On Request</strong>";
                        				
                        				$count_price = count( $discountPriceData );
                        				$strike_class = ($price !== end($discountPriceData) && $count_price > 1 ) ? "strikeLine" : "";
                        		
                        				echo "<tr class='{$strike_class} {$strike_class_final}'><td>Price</td><td>" . $s_price . "</td>";
                        				echo "<td>" . $d_price . "</td>";
                        				echo "<td>" . $sd_price . "</td>";
                        				echo "<td>" . $l_price . "</td></tr>";
                        			}	
                        		}
                        	}
                        	
                        	$rate_comment = isset( $iti->rate_comment ) && $iti->pending_price == 2 && $iti->discount_rate_request == 0 ? $iti->rate_comment : "";
                        	echo "<tr><td colspan=5><p class='red'><strong>Note: </strong>{$rate_comment} </td></tr>";
                        	echo "<tr><td colspan=5><p class='red'><strong>Final Package Cost: </strong>{$f_cost} </td></tr>";
                        } ?>							
                  </tbody>
               </table>
               <?php } ?> 	
            </div>
            <hr>
            <!--If Flight Exists-->
            <?php if( isset( $flight_details ) && !empty( $flight_details ) && $iti->is_flight == 1 ){ ?>
            <?php $flight = $flight_details[0]; ?>
            <div class="well well-sm">
               <h3>Flight Details</h3>
            </div>
            <div class="table-responsive">
               <table class="table table-bordered ">
                  <tbody>
                     <tr class="thead-inverse" >
                        <td width="33%"><strong>Trip Type</strong></td>
                        <td width="33%"><strong>Flight Name</strong></td>
                        <td width="33%"><strong>Class</strong></td>
                     </tr>
                     <tr>
                        <td><?php echo ucfirst($flight->trip_type); ?></td>
                        <td><?php echo $flight->flight_name; ?></td>
                        <td><?php echo $flight->flight_class; ?></td>
                     </tr>
                     <tr class="thead-inverse" >
                        <td width="33%"><strong>Departure City</strong></td>
                        <td width="33%"><strong>Arrival city</strong></td>
                        <td width="33%"><strong>No. of Passengers</strong></td>
                     </tr>
                     <tr>
                        <td><?php echo $flight->dep_city; ?></td>
                        <td><?php echo $flight->arr_city; ?></td>
                        <td><?php echo $flight->total_passengers; ?></td>
                     </tr>
                     <tr class="thead-inverse" >
                        <td width="33%"><strong>Arrival Date/Time</strong></td>
                        <td width="33%"><strong>Departure Date/Time</strong></td>
                        <td width="33%"><strong>Return Date/Time</strong></td>
                     </tr>
                     <tr>
                        <td><?php echo $flight->arr_time; ?></td>
                        <td><?php echo $flight->dep_date; ?></td>
                        <td><?php echo $flight->return_date; ?></td>
                     </tr>
                     <tr class="thead-inverse" >
                        <td width="33%"><strong>Return Arrival Date/Time</strong></td>
                        <td width="33%"><strong>Price</strong></td>
                     </tr>
                     <tr>
                        <td><?php echo $flight->return_arr_date; ?></td>
                        <td><?php echo $flight->flight_price; ?></td>
                     </tr>
                  </tbody>
               </table>
            </div>
            <hr>
            <?php } ?>
            <!--End Flight Section-->
            <!--If Train Exists-->
            <?php if( isset( $train_details ) && !empty( $train_details ) && $iti->is_train == 1 ){ ?>
            <?php $train = $train_details[0]; ?>
            <div class="well well-sm">
               <h3>Train Details</h3>
            </div>
            <div class="table-responsive">
               <table class="table table-bordered ">
                  <tbody>
                     <tr class="thead-inverse" >
                        <td width="33%"><strong>Trip Type</strong></td>
                        <td width="33%"><strong>Train Name</strong></td>
                        <td width="33%"><strong>Train Number</strong></td>
                     </tr>
                     <tr>
                        <td><?php echo ucfirst($train->t_trip_type); ?></td>
                        <td><?php echo $train->train_name; ?></td>
                        <td><?php echo $train->train_number; ?></td>
                     </tr>
                     <tr class="thead-inverse" >
                        <td width="33%"><strong>Departure City</strong></td>
                        <td width="33%"><strong>Arrival city</strong></td>
                        <td width="33%"><strong>No. of Passengers</strong></td>
                     </tr>
                     <tr>
                        <td><?php echo $train->t_dep_city; ?></td>
                        <td><?php echo $train->t_arr_city; ?></td>
                        <td><?php echo $train->t_passengers; ?></td>
                     </tr>
                     <tr class="thead-inverse" >
                        <td width="33%"><strong>Arrival Date/Time</strong></td>
                        <td width="33%"><strong>Departure Date/Time</strong></td>
                        <td width="33%"><strong>Return Date/Time</strong></td>
                     </tr>
                     <tr>
                        <td><?php echo $train->t_arr_time; ?></td>
                        <td><?php echo $train->t_dep_date; ?></td>
                        <td><?php echo $train->t_return_date; ?></td>
                     </tr>
                     <tr class="thead-inverse" >
                        <td width="33%"><strong>Return Arrival Date/Time</strong></td>
                        <td width="33%"><strong>Class</strong></td>
                        <td width="33%"><strong>Price</strong></td>
                     </tr>
                     <tr>
                        <td><?php echo $train->t_return_arr_date; ?></td>
                        <td><?php echo $train->train_class; ?></td>
                        <td><?php echo $train->t_cost; ?></td>
                     </tr>
                  </tbody>
               </table>
            </div>
            <hr>
            <?php } ?>
            <!--End Flight Section-->
            <div id="snow1" class="well well-sm">
               <h3>Notes:</h3>
               <ul class="client_listing">
                  <?php $hotel_note_meta = unserialize($iti->hotel_note_meta); 
                     $count_hotel_meta = count( $hotel_note_meta );
                     
                     if( $count_hotel_meta > 0 ){
                     	for ( $i = 0; $i < $count_hotel_meta; $i++ ) {
                     		echo "<li>" . $hotel_note_meta[$i]["hotel_note"] . "</li>";
                     	}	
                     } ?>
               </ul>
               <hr>
               <?php 
                  //how to book section
                  $count_book_package	= count( $book_package_terms );
                  if(isset($book_package_terms["heading"]) ) { 
                  	echo "<div class='well well-sm'><h3>". $book_package_terms["heading"]  ."</h3></div>";
                  }
                  if(isset($book_package_terms["sub_heading"]) ) { 
                  	echo "<h5>". $book_package_terms["sub_heading"]  ."</h5>";
                  }							
                  if( $count_book_package > 0 ){
                  	echo '<div class="table-responsive">
                  				<table class="table table-bordered tbl_policy_view">
                  					<thead class="thead-default">
                  						<tr>
                  							<th colspan=3> Booking Policy </th>
                  						</tr>
                  					</thead>
                  					<tbody>';
                  					$counter = 1;
                  		for ( $i = 0; $i < $count_book_package-2; $i++ ) { 
                  			$book_title = isset($book_package_terms[$i]["hotel_book_terms"]) ? $book_package_terms[$i]["hotel_book_terms"] : "";
                  			$book_val = isset($book_package_terms[$i]["hotel_book_terms_right"]) ? $book_package_terms[$i]["hotel_book_terms_right"] : "";
                  			echo "<tr>
                  				<td>" . $counter . "</td>
                  				<td>" . $book_title . "</td>
                  				<td>" . $book_val . "</td>
                  			</tr>";
                  			$counter++;
                  		}
                  	echo "</tbody></table></div>";
                  }	
                  
                  // advance payment section 
                  $count_ad_pay	= count( $advance_payment_terms );
                  if(isset($advance_payment_terms["heading"]) ) { 
                  	echo "<div class='well well-sm'><h3>". $advance_payment_terms["heading"]  ."</h3></div>";
                  }						
                  if( $count_book_package > 0 ){
                  	echo "<ul class='client_listing'>";
                  		for ( $i = 0; $i < $count_ad_pay-1; $i++ ) { 
                  			echo "<li>" . $advance_payment_terms[$i]["terms"] . "</li>";
                  		}
                  	echo "</ul>";
                  }
                  ?>
               <hr>
               <div class="well well-sm">
                  <h3>Bank Details: Cash/Cheque at Bank or Net Transfer</h3>
               </div>
               <div class="table-responsive">
                  <table class="table table-bordered">
                     <thead class="thead-default">
                        <tr>
                           <th> Bank Name</th>
                           <th> Payee Name</th>
                           <th> Account Type</th>
                           <th> Account Number</th>
                           <th> Branch Address</th>
                           <th> IFSC Code</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php $banks = get_all_banks(); 
                           if( $banks ){
                           	foreach( $banks as $bank ){ 
                           		echo "<tr>";
                           			echo "<td>" . $bank->bank_name . "</td>";
                           			echo "<td>" . $bank->payee_name . "</td>";
                           			echo "<td>" . $bank->account_type . "</td>";
                           			echo "<td>" . $bank->account_number . "</td>";
                           			echo "<td>" . $bank->branch_address . "</td>";
                           			echo "<td>" . $bank->ifsc_code . "</td>";
                           		echo "</tr>";
                           	 }
                           }
                           ?>
                     </tbody>
                  </table>
               </div>
               <hr>
               <?php
                  //bank payment terms
                  $count_bank_payment_terms	= count( $online_payment_terms ); 
                  $count_bankTerms			= $count_bank_payment_terms-1; 
                  if(isset($online_payment_terms["heading"]) ) { 
                  	echo "<div class='well well-sm'><h3>" . $online_payment_terms["heading"] . "</h3></div>"; 
                  }
                  if( $count_bankTerms > 0 ){
                  	echo "<ul class='client_listing'>";
                  		for ( $i = 0; $i < $count_bankTerms; $i++ ) { 
                  			echo "<li>" . $online_payment_terms[$i]["terms"] . "</li>";
                  		}
                  	echo "</ul>";
                  }
                  	
                  	
                  	//PAYMENT POLICY
                  	if(isset($payment_policy["heading"]) ) { 
                  		echo "<div class='well well-sm'><h3>". $payment_policy["heading"]  ."</h3></div>";
                  	}	
                  	$count_payment_policy	= count( $payment_policy );
                  	if( $count_payment_policy > 0 ){
                  		echo '<div class="table-responsive">
                  					<table class="table table-bordered tbl_policy_view">
                  						<thead class="thead-default">
                  							<tr>
                  								<th colspan=3> Payment Policy </th>
                  							</tr>
                  						</thead>
                  						<tbody>';
                  			$counter_pay = 1;
                  			for ( $i = 0; $i < $count_payment_policy-1; $i++ ) { 
                  				$book_title = isset($payment_policy[$i]["pay_policy"]) ? $payment_policy[$i]["pay_policy"] : "";
                  				$book_val = isset($payment_policy[$i]["pay_policy_right"]) ? $payment_policy[$i]["pay_policy_right"] : "";
                  				echo "<tr>
                  					<td>" . $counter_pay . "</td>
                  					<td>" . $book_title . "</td>
                  					<td>" . $book_val . "</td>
                  				</tr>";
                  				$counter_pay++;
                  			}
                  		echo "</tbody></table></div>";
                  	}								
                  	//end payment policy
                  	
                  	//AMENDMENT POLICY section	
                  	if(isset($amendment_policy["heading"]) ) { 
                  		echo "<div class='well well-sm'><h3>". $amendment_policy["heading"]  ."</h3></div>";
                  	}	
                  	$count_amendment_policy	= count( $amendment_policy );
                  	
                  	if( $count_amendment_policy > 0 ){
                  		echo '<div class="table-responsive">
                  					<table class="table table-bordered tbl_policy_view">
                  						<thead class="thead-default">
                  							<tr>
                  								<th colspan=3> Amendment Policy </th>
                  							</tr>
                  						</thead>
                  						<tbody>';
                  			$counter_a = 1;
                  			for ( $i = 0; $i < $count_amendment_policy-1; $i++ ) { 
                  				$book_title = isset($amendment_policy[$i]["amend_policy"]) ? $amendment_policy[$i]["amend_policy"] : "";
                  				$book_val = isset($amendment_policy[$i]["amend_policy_right"]) ? $amendment_policy[$i]["amend_policy_right"] : "";
                  				echo "<tr>
                  					<td>" . $counter_a . "</td>
                  					<td>" . $book_title . "</td>
                  					<td>" . $book_val . "</td>
                  				</tr>";
                  				$counter_a++;
                  			}
                  		echo "</tbody></table></div>";
                  	}
                  	
                  	//refund policy
                  	if(isset($amendment_policy["heading"]) ) { 
                  		echo "<div class='well well-sm'><h3>". $cancel_tour_by_client["heading"]  ."</h3></div>";
                  	}
                  	
                  	$count_cancel_content	= count( $cancel_tour_by_client );
                  	
                  	if( $count_cancel_content > 0 ){
                  		echo '<div class="table-responsive">
                  					<table class="table table-bordered tbl_policy_view">
                  						<thead class="thead-default">
                  							<tr>
                  								<th colspan=3> Cancellation and Refund Policy </th>
                  							</tr>
                  						</thead>
                  						<tbody>';
                  			$counter_ra = 1;
                  			for ( $i = 0; $i < $count_cancel_content-1; $i++ ) { 
                  				$book_title = isset($cancel_tour_by_client[$i]["cancel_terms"]) ? $cancel_tour_by_client[$i]["cancel_terms"] : "";
                  				$book_val = isset($cancel_tour_by_client[$i]["cancel_terms_right"]) ? $cancel_tour_by_client[$i]["cancel_terms_right"] : "";
                  				echo "<tr>
                  					<td>" . $counter_ra . "</td>
                  					<td>" . $book_title . "</td>
                  					<td>" . $book_val . "</td>
                  				</tr>";
                  				$counter_ra++;
                  			}
                  		echo "</tbody></table></div>";
                  	}
                  	
                  	
                  	//terms and condition
                  	if(isset($terms_condition["heading"]) ) { 
                  		echo "<div class='well well-sm'><h3>". $terms_condition["heading"]  ."</h3></div>";
                  	}
                  	$count_cancel_content	= count( $terms_condition );
                  	if( $count_cancel_content > 0 ){
                  		echo "<ul class='client_listing'>";
                  			for ( $i = 0; $i < $count_cancel_content-1; $i++ ) { 
                  				echo "<li>" . $terms_condition[$i]["terms"] . "</li>";
                  			}
                  		echo "</ul>";
                  	}
                  ?>	
               <hr>
               <!-- Get office branches -->
               <?php 
                  $head_off = get_head_office();
                  $head_office = $head_off[0];
                  if( !empty(  $head_office ) ){ 
                  	echo "<div class='head_off_section'>";
                  		echo "<h3>Track Itinerary HEAD OFFICE</h3>";
                  		echo "<div class='branch_name'>" . $head_office->branch_name . "</div> <br>";
                  		echo "<div class='address'><span><i class='fa fa-home' aria-hidden='true'></i></span> " . $head_office->branch_address . "</p></div> ";
                  		echo "<div class='address_new_email'><p><span><i class='fa fa-phone-square' aria-hidden='true'></i></i></span>" . $head_office->branch_contact . "</p>";
                  		echo "<p><span><i class='fa fa-envelope' aria-hidden='true'></i></span>" . $head_office->email_address . "</p> </div>";
                  	echo "</div>";	
                  }
                  $office_branches = get_office_branches();
                  if( !empty( $office_branches ) ){
                  	echo "<div class='branch_row'>";
                  		echo "<h3>BRANCHES</h3>";
                  		foreach( $office_branches as $branch ){
                  			echo "<div class='branch_section'>";
                  				echo "<h3>" . $branch->branch_name . "</h3>";
                  				echo "<p> <span><i class='fa fa-home' aria-hidden='true'></i></span>" . $branch->branch_address . "</p>";
                  				echo "<p><span><i class='fa fa-phone-square' aria-hidden='true'></i> </span>" . $branch->branch_contact . "</p>";
                  				echo "<p><span><i class='fa fa-envelope' aria-hidden='true'></i></span>" . $branch->email_address . "</p>";
                  			echo "</div>";	
                  		}	
                  	echo "</div>";	
                  }
                  echo "<hr>";
                  ?>
               <?php
                  $agent_id = $iti->agent_id;
                  $user_info = get_user_info($agent_id);
                  if($user_info){
                  	$agent = $user_info[0];
                  	echo "<strong>Regards</strong><br>";
                  	echo "<strong> " . $agent->first_name . " " . $agent->last_name . "</strong><br>";
                  	echo "<strong>Call Us : </strong> " . $agent->mobile . "<br>";
                  	echo "<strong>Email : </strong> " . $agent->email . "<br>";
                  	echo "<strong>Timing : </strong> " . $agent->in_time . " To " . $agent->out_time . "<br>";
                  	echo "<strong>Website : </strong> " . $agent->website;
                  }	
                  echo "<br>";
                  echo "<hr>";
                  echo "<div class='signature'>". $signature . "</div>";
                  ?>						
            </div>
         </div>
      </div>
      <div class="footer">
         <div class="footer_curve_back">
         </div>
         <p><?php echo date("Y"); ?> &copy; Track Itinerary Develop By EligoCs</p>
      </div>
      </div>
      <?php } ?>	
      <script>
         var snowmax = 400; // flakes on screen
         var snowcolor = ["#fff", "#fff", "#fff"]; // flake color
         var snowletter = "&#10052;";
         var sinkspeed = 1; // fall speed
         var snowmaxsize = 10; // flake max size
         var snowminsize = 5; // flake min size
         var snow = [];
         var marginbottom = window.innerHeight;
         var marginright = window.innerWidth;
         
         var x_mv = [];
         var crds = [];
         var lftrght = [];
         
         function randommaker(range) {
             rand = Math.floor(range * Math.random());
             return rand;
         }
         
         window.onload = function () {
             var snowsizerange = snowmaxsize - snowminsize;
             for (var i = 0; i <= snowmax; i++) {
                 crds[i] = 0;
                 lftrght[i] = Math.random() * 15;
                 x_mv[i] = 0.03 + Math.random() / 10;
         
                 var flake = document.createElement('span');
                 //var stuff
                 flake.size = randommaker(snowsizerange) + snowminsize;
                 flake.sink = sinkspeed * flake.size / 5;
                 //css stuff
                 flake.style.fontSize = flake.size + 'px';
                 flake.style.color = snowcolor[randommaker(snowcolor.length)];
                 flake.innerHTML = snowletter;
         
                 flake.posx = randommaker(marginright - flake.size);
                 flake.posy = randommaker(marginbottom - 2 * flake.size);
                 flake.style.left = flake.posx + 'px';
                 flake.style.top = flake.posy + 'px';
                 //attr stuff
                 flake.id = 's' + i;
                 flake.className = 'flake';
                 snow[i] = flake;
                document.getElementById('snow').appendChild(flake);
                // document.getElementById('snow1').appendChild(flake);
             }
             movesnow();
         };
         
         window.onresize = function () {
             marginbottom = window.innerHeight;
             marginright = window.innerWidth;
         };
         
         function movesnow() {
             for (var i = 0; i <= snowmax; i++) {
                 crds[i] += x_mv[i];
                 snow[i].posy += snow[i].sink;
                 var posx = snow[i].posx + lftrght[i] * Math.sin(crds[i]);
                 var posy = snow[i].posy;
                 snow[i].style.left = posx + 'px';
                 snow[i].style.top = posy + 'px';
         
                 if (snow[i].posy >= marginbottom - 2 * snow[i].size || parseInt(snow[i].style.left) > (marginright - 3 * lftrght[i])) {
                     snow[i].posx = randommaker(marginright - snow[i].size);
                     snow[i].posy = 0;
                 }
             }
             setTimeout(movesnow, 50);
         }
      </script>
   </body>
</html>