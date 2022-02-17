<?php
if( !empty($itinerary )){
$iti = $itinerary[0];
	//$pdf_name = $iti->iti_id . '_' . $iti->temp_key;
	$pdf_html = "";
	$pdf_html .= <<<EOF
	<style>
		.heading{    border: 1px solid #5E76E0; background-color: #5E76E0; font-family: 'Open Sans', sans-serif; font-size: 14px !important; text-transform: uppercase; color: rgb(255,255,255); font-weight:bold; }
		th{background-color: #003367; font-weight:bold; color:#fff;}
		ul.list_style{ }
		.strikeLine{ text-decoration: line-through !important; }	
		.fa{font-family: fontawesome; color: #004082; font-size: 16px;}
		.pdf{font-family:georg; font-size:14px;}
		.pdf {font-family: sans-serif; color: #484848; line-height:130%;}
			table{margin-bottom:200px;}
		.border-black{border:2px solid #003367 !important;}

	</style>
EOF;

	//get details terms and customer information
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
	
	$customer_name 		= !empty($get_customer_info) ? $cust->customer_name  : "";;
	$customer_contact 	= !empty($get_customer_info) ? $cust->customer_contact : "";
	$customer_email		= !empty($get_customer_info) ? $cust->customer_email : "";
	
	$pdf_name = 'itinerary_' . $iti->iti_id . '_' . str_replace(' ', '_' ,$customer_name);
	// Set various pdf options
	$pdf = new PDF("", PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
	//	$fontname = TCPDF_FONTS::addTTFfont('fonts/fontawesome-webfont.ttf', 'TrueTypeUnicode', '', 32);

	// set document information
	$pdf->SetCreator(PDF_CREATOR);
	$pdf->SetAuthor('Track Itinerary');
	$pdf->SetTitle('Track Itinerary Pvt. Ltd.');
	$pdf->SetSubject('Track Itinerary');
	
	
	// Add Page
	$pdf->AddPage();
	// set font

	// set some text to print
	$pdf_html .= '<div class="pdf">';
	$pdf_html .= "Hi {$customer_name},";
	// Set font
	$pdf_html .= '<div class="clear-fix"></div>';
 		$pdf_html .= '<table  cellpadding="7"  cellspacing="0"  width="100%"><tr><td class="heading">GREETINGS FROM  TRACKITINERARY</td></tr></table>';
		$pdf_html .= "<br>";
		$pdf_html .= "<br>";
		$pdf_html .= $greeting;
		
 		$pdf_html .= '<div class="clear-fix"></div>';
 		$pdf_html .= '<table  cellpadding="7"  cellspacing="0"   width="100%" ><tr><td class="heading">Package Overview</td></tr></table>';
	
		$pdf->SetFont('dejavusans', '', 10);
		$tt = "<strong> Adults: </strong> " . $iti->adults; 
		if( !empty( $iti->child ) ){
			$tt .=  "<strong> No. of Child: </strong> " . $iti->child; 
			$tt .=  "<strong> Child age: </strong> " . $iti->child_age; 
		}
		$cab = get_car_name( $iti->cab_category);
		
		$pdf_html .= <<<EOD
			<table cellspacing="0" cellpadding="8" border="1" bordercolor="red">
			
				<tr>
					<th>Name of Package</th>
					<th>Routing</th>
					<th>Duration</th>
				</tr>
				<tr>
					<td>{$iti->package_name}</td>
					<td>{$iti->package_routing}</td>
					<td>{$iti->duration}</td>
				</tr>
				<tr>
					<th>No of Travellers</th>
					<th>Cab Category</th>
					<th>Quotation Date</th>
				</tr>
				<tr>
					<td>{$tt}</td>
					<td>{$cab}</td>
					<td>{$iti->quatation_date}</td>
				</tr>
			</table>
EOD;
	
		
		
		// Day wise itinerary Section
		$pdf_html .= "<br>";
		$pdf_html .= "<br>";
		
 
 		$pdf_html .= '<table cellpadding="7"  cellspacing="0"   width="100%" bgcolor="#FFE200"><tr class="border-black"><td class="heading">DETAILED ITINERARY:</td></tr></table>';
 
	 
		$day_wise = $iti->daywise_meta; 
		$tourData = unserialize($day_wise);
		$count_day = count( $tourData );
		if( $count_day > 0 ){
			
			for ( $i = 0; $i < $count_day; $i++ ) {
				$day = $tourData[$i]['tour_day'];
				$tour_name = $tourData[$i]['tour_name'];
				$tour_date = $tourData[$i]['tour_date'];
				$meal_plan = $tourData[$i]['meal_plan'];
				$tourDes = $tourData[$i]['tour_des'];
				$hot_destination = "";
				if( isset($tourData[$i]['hot_des'] ) && !empty( $tourData[$i]['hot_des'] ) ){
					$hot_dest = '';
					$htd = explode(",", $tourData[$i]['hot_des']);
					foreach($htd as $t) {
						$t = trim($t);
						$hot_dest .= "<span>" . $t . "</span>, ";
					}
					$hot_destination = '<div class="hot_destination_view"><div class="day_yellow">Attraction :</div>' . $hot_dest . '</div>';
				}	
				$pdf_html .= 
				<<<EOD
			<table cellspacing="0" cellpadding="5" border="1" >
				<tr nobr="true">
					<td style="font-size: 12px;">Day: {$day} <br>
							<strong>Date:</strong> {$tour_date}</td>
					<td style="font-size: 10px;" colspan="2"><strong>{$tour_name}</strong> <br>
							<strong>Meal Plan: </strong> {$meal_plan} <br>
							<strong>Night Stay: </strong> {$tourDes}<br>
							{$hot_destination}</td>
				</tr>
			</table><br><br>
EOD;
				
			}	
			
		}
		
		// Inclusion & Exclusion Section
		$pdf_html .= "<br>";
		$pdf_html .= "<br>";
	 
 		$pdf_html .= '<table cellpadding="7"  cellspacing="0"   width="100%" bgcolor="#FFE200"><tr><td class="heading">Inclusion & Exclusion</td></tr></table>';
	
		$inclusion = unserialize($iti->inc_meta); 
		$count_inc = count( $inclusion );
		$sp_inc = unserialize($iti->special_inc_meta); 
		$count_sp_inc = count( $sp_inc );
		$exclusion = unserialize($iti->exc_meta); 
		$count_exc = count( $exclusion );
		$greater_list = $count_inc >= $count_exc ? $count_inc : $count_exc;
		$j=0;
		if( $greater_list > 0  ){
			
			$pdf_html .= <<<EOD
			<table cellspacing="0" cellpadding="5" border="1">	<tr><th>Inclusion</th><th>Exclusion</th></tr>
EOD;
			for ( $i = 0; $i < $greater_list; $i++ ) {
				if( $i < $count_inc ){
					$inc = "<td >" . $inclusion[$i]["tour_inc"] . "</td>";
				}else{
					$inc = "<td></td>";
				}
				$pdf_html .= <<<EOD
					<tr nobr="true" style="font-size: 12px;">{$inc}
				
				
EOD;
				if( $i < $count_exc ){
					$exc = "<td>" . $exclusion[$i]["tour_exc"] . "</td>";
				}else{
					$exc = "<td></td>";
				}
			 	
				$pdf_html .= <<<EOD
				{$exc}
EOD;
				$pdf_html .= <<<EOD
			</tr>			
EOD;
			}
			$pdf_html .= <<<EOD
			</table>			
EOD;

			
		}
		//show special inclusion if exists
		if( !empty( $sp_inc ) ){
			$pdf_html .= "<br>";
			$pdf_html .= "<br>";
			$pdf_html .= <<<EOD
			<table cellspacing="0" cellpadding="5" border="1">	<tr><th>Special Inclusion</th></tr>
EOD;
			for ( $ii = 0; $ii < $count_sp_inc; $ii++ ) {
				$si = isset($sp_inc[$ii]['tour_special_inc']) ? $sp_inc[$ii]['tour_special_inc']: "";
$pdf_html .= <<<EOD
		<tr nobr="true" style="font-size: 12px;"><td>{$si}</td></tr>
EOD;
			}
		
$pdf_html .= <<<EOD
			</table>			
EOD;
			
		}
		
		//show Benefits
		$benefits_m = unserialize($iti->booking_benefits_meta); 
		$count_bn_inc = count( $benefits_m );
		if( !empty( $benefits_m ) ){
			$pdf_html .= "<br>";
			$pdf_html .= "<br>";
			$pdf_html .= <<<EOD
			<table cellspacing="0" cellpadding="5" border="1">	<tr><th>Benefits of Booking With Us</th></tr>
EOD;
			for ( $ii = 0; $ii < $count_bn_inc; $ii++ ) {
				$si = isset($benefits_m[$ii]['benefit_inc']) ? $benefits_m[$ii]['benefit_inc']: "";
$pdf_html .= <<<EOD
		<tr nobr="true" style="font-size: 12px;"><td>{$si}</td></tr>
EOD;
			}
		
$pdf_html .= <<<EOD
			</table>			
EOD;
			
		}
		
		
		// Hotel Details Section
		$pdf_html .= "<br>";
		$pdf_html .= "<br>";
		$pdf->SetFont('courier', 'B', 14);
		$pdf_html .= '<table  cellpadding="7"  cellspacing="0"   width="100%" bgcolor="#FFE200"><tr><td class="heading">Hotel Details</td></tr></table>';
			
	 
		
		$hotel_meta = unserialize($iti->hotel_meta); 
		if( !empty( $hotel_meta ) ){
		$count_hotel = count( $hotel_meta );
			$pdf_html .= <<<EOD
			<table cellspacing="0" cellpadding="5" border="1">
			<tr>
				<th> Hotel Category</th>
				<th> Deluxe</th>
				<th> Super Deluxe</th>
				<th> Luxury</th>
				<th> Super Luxury</th>
			</tr>
EOD;
		
		if( $count_hotel > 0 ){
			$hotel_st = "";
			$hotel_d = "";
			$hotel_sd = "";
			$hotel_lux = "";
			for ( $i = 0; $i < $count_hotel; $i++ ) {
				$city_name = $hotel_meta[$i]["hotel_location"]; 
				$hotel_standard =  $hotel_meta[$i]["hotel_standard"];
				$hotel_deluxe =  $hotel_meta[$i]["hotel_deluxe"];
				$hotel_super_deluxe =  $hotel_meta[$i]["hotel_super_deluxe"];
				$hotel_luxury =  $hotel_meta[$i]["hotel_luxury"];
				$pdf_html .= <<<EOD
			<tr>
				<td style="font-size: 12px;"><strong>{$city_name}</strong></td>
				<td style="font-size: 12px;">{$hotel_standard}</td>
				<td style="font-size: 12px;">{$hotel_deluxe}</td>
				<td style="font-size: 12px;">{$hotel_super_deluxe}</td>
				<td style="font-size: 12px;">{$hotel_luxury}</td>
			</tr>
EOD;
			}
			//Rate meta
			$rate_meta = unserialize($iti->rates_meta);
			$f_cost =  !empty( $iti->final_amount ) && get_iti_booking_status($iti->iti_id) == 0 ? "<strong style='color: green;'> " . number_format($iti->final_amount) . " /-</strong> " : "";
			$strike_class_final = !empty( $iti->final_amount ) && get_iti_booking_status($iti->iti_id) == 0 ? "strikeLine" : "";
			//add strike line on price is 
			//$strike_class = !empty( $discountPriceData ) ? "strikeLine" : " ";
			//print_r( $rate_meta );
			$iti_close_status = $iti->iti_close_status;
			//print_r( $rate_meta );
			if( empty($iti_close_status) ){
			if( !empty( $rate_meta ) ){
				$agent_price_percentage = !empty($iti->agent_price) ? $iti->agent_price : 0;
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
				
				$pdf_html .= <<<EOD
			<tr>
				<td style="font-size: 12px;">Price</td>
				<td>{$standard_rates}</td>
				<td>{$deluxe_rates}</td>
				<td>{$super_deluxe_rates}</td>
				<td>{$rate_luxry}</td>
			</tr>
EOD;
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
					$pdf_html .= <<<EOD
			<tr>
				<td style="font-size: 12px;">Price</td>
				<td class='{$strike_class}'>{$s_price}</td>
				<td class='{$strike_class}'>{$d_price}</td>
				<td class='{$strike_class}'>{$sd_price}</td>
				<td class='{$strike_class}'>{$l_price}</td>
			</tr>
EOD;
				
				}
			}
			}  
			}  
$pdf_html .= <<<EOD
			</table>
			
EOD;

			if( !empty($f_cost)){
				$pdf_html .= "Final Package Cost: {$f_cost}";
			}	
		
		}
		}
		//Check for flight and train details
		if( isset( $flight_details ) && !empty( $flight_details ) && $iti->is_flight == 1 ){ 
		$flight = $flight_details[0]; 
		$pdf_html .= "<br><br>";
		$pdf->SetFont('courier', 'B', 14);
		$pdf_html .= '<table  cellpadding="7"  cellspacing="0"   width="100%" bgcolor="#FFE200"><tr><td class="heading">Flight Details</td></tr></table>';
		$pdf->SetFont('dejavusans', '', 10);
			$pdf_html .= <<<EOD
			<table cellspacing="0" cellpadding="8" border="1" bordercolor="red">
			
				<tr>
					<th>Trip Type</th>
					<th>Flight Name</th>
					<th>Class</th>
				</tr>
				<tr>
					<td>{$flight->trip_type}</td>
					<td>{$flight->flight_name}</td>
					<td>{$flight->flight_class}</td>
				</tr>
				<tr>
					<th>Departure City</th>
					<th>Arrival city</th>
					<th>No. of Passengers</th>
				</tr>
				<tr>
					<td>{$flight->dep_city}</td>
					<td>{$flight->arr_city}</td>
					<td>{$flight->total_passengers}</td>
				</tr>
				<tr>
					<th>Arrival Date/Time</th>
					<th>Departure Date/Time</th>
					<th>Return Date/Time</th>
				</tr>
				<tr>
					<td>{$flight->arr_time}</td>
					<td>{$flight->dep_date}</td>
					<td>{$flight->return_date}</td>
				</tr>
				<tr>
					<th>Return Arrival Date/Time</th>
					<th>Price</th>
				</tr>
				<tr>
					<td>{$flight->return_arr_date}</td>
					<td>{$flight->flight_price}</td>
				</tr>
			</table>
EOD;
				
		} 
		//End Flight Section
		//If Train Exists
		if( isset( $train_details ) && !empty( $train_details ) && $iti->is_train == 1 ){ 
		$train = $train_details[0]; 
		$pdf_html .= "<br><br>";
		$pdf->SetFont('courier', 'B', 14);
		$pdf_html .= '<table  cellpadding="7"  cellspacing="0"   width="100%" bgcolor="#FFE200"><tr><td class="heading">Train Details</td></tr></table>';
			$pdf_html .= <<<EOD
			<table cellspacing="0" cellpadding="8" border="1" bordercolor="red">
			
				<tr>
					<th>Trip Type</th>
					<th>Train Name</th>
					<th>Train Number</th>
					<th>Class</th>
				</tr>
				<tr>
					<td>{$train->t_trip_type}</td>
					<td>{$train->train_name}</td>
					<td>{$train->train_number}</td>
					<td>{$train->train_class}</td>
				</tr>
				<tr>
					<th>Departure City</th>
					<th>Arrival city</th>
					<th>No. of Passengers</th>
					<th>Price</th>
				</tr>
				<tr>
					<td>{$train->t_dep_city}</td>
					<td>{$train->t_arr_city}</td>
					<td>{$train->t_passengers}</td>
					<td>{$train->t_cost}</td>
				</tr>
				<tr>
					<th>Arrival Date/Time</th>
					<th>Departure Date/Time</th>
					<th>Return Date/Time</th>
					<th>Return Arrival Date/Time</th>
				</tr>
				<tr>
					<td>{$train->t_arr_time}</td>
					<td>{$train->t_dep_date}</td>
					<td>{$train->t_return_date}</td>
					<td>{$train->t_return_arr_date}</td>
				</tr>
				
			</table>
EOD;
		} 
		//End Flight Section
		
		// Hotel Note
		$pdf_html .= "<br>";
		$pdf_html .= "<br>";
 		$pdf_html .= "<strong>Notes:</strong>";
			
		$hotel_note_meta = unserialize($iti->hotel_note_meta); 
		$count_hotel_meta = count( $hotel_note_meta );
		 
		
		if( $count_hotel_meta > 0 ){
			$pdf_html .= "<ul>";
			for ( $i = 0; $i < $count_hotel_meta; $i++ ) {
				$pdf_html .= "<li>" . $hotel_note_meta[$i]["hotel_note"] . "</li>";
			}	
			$pdf_html .= "</ul>";
		}
	
		//how to book section
		$count_book_package	= count( $book_package_terms );
		if(isset($book_package_terms["heading"]) ) { 
			$pdf->SetFont('courier', 'B', 14);
			$pdf_html .= '<table  cellpadding="7"  cellspacing="0"   width="100%" bgcolor="#FFE200"><tr><td class="heading">' . $book_package_terms['heading'] . '</td></tr></table>';
		}
		if(isset($book_package_terms["sub_heading"]) ) { 
			$pdf_html .= "<h5>{$book_package_terms['sub_heading']}</h5>";
		}							
		if( $count_book_package > 0 ){
			//$pdf_html .= "<ul class='client_listing'>";
			$pdf_html .= '<table  cellpadding="7" border="1" cellspacing="0"   width="100%">';
				for ( $i = 0; $i < $count_book_package-2; $i++ ) {
					$book_title = isset($book_package_terms[$i]["hotel_book_terms"]) ? $book_package_terms[$i]["hotel_book_terms"] : "";
					$book_val = isset($book_package_terms[$i]["hotel_book_terms_right"]) ? $book_package_terms[$i]["hotel_book_terms_right"] : "";
					$pdf_html .= "<tr><td>{$book_title}</td><td>{$book_val}</td></tr>";
				}
			$pdf_html .= "</table>";
			//$pdf_html .= "</ul>";
		}	
		$pdf_html .= "<hr>";
		// advance payment section 
		$count_ad_pay	= count( $advance_payment_terms );
		if(isset($advance_payment_terms["heading"]) ) {
			$pdf_html .= '<table  cellpadding="7"  cellspacing="0"   width="100%" bgcolor="#FFE200"><tr><td class="heading">' . $advance_payment_terms['heading'] . '</td></tr></table>';
		 
		}						
		if( $count_book_package > 0 ){
			$pdf->SetFont('courier', 'B', 12);
			$pdf_html .= "<ul class='client_listing'>";
				for ( $i = 0; $i < $count_ad_pay-1; $i++ ) { 
					$pdf_html .= "<li>" . $advance_payment_terms[$i]["terms"] . "</li>";
				}
			$pdf_html .= "</ul>";
		}
	// Bank Details Procedure
		$pdf->SetFont('courier', 'B', 14);
 		$pdf_html .= '<table  cellpadding="7"  cellspacing="0"   width="100%" bgcolor="#FFE200"><tr><td class="heading">Bank Details: Cash/Cheque at Bank or Net Transfer</td></tr></table>';
		 
		
		
		$pdf_html .=  <<<EOD
			<table cellspacing="0" cellpadding="5" border="1">
			<tr>
				<th>Bank Name</th>
				<th>Payee Name</th>
				<th>Account Type</th>
				<th>Account Number</th>
				<th>Branch Address</th>
				<th>IFSC Code</th>
			</tr>
EOD;
			$banks = get_all_banks(); 
			if( $banks ){
					
				foreach( $banks as $bank ){ 
					$b_name = $bank->bank_name;
					$payee_name = $bank->payee_name;
					$ac_type = $bank->account_type;
					$ac_number = $bank->account_number;
					$b_address = $bank->branch_address;
					$ifsc = $bank->ifsc_code;
					
					$pdf_html .= <<<EOD
					<tr>
						<td>{$b_name}</td>
						<td>{$payee_name}</td>
						<td>{$ac_type}</td>
						<td>{$ac_number}</td>
						<td>{$b_address}</td>
						<td>{$ifsc}</td>
					</tr>
EOD;
					
				}
			}
$pdf_html .= <<<EOD
		</table>
EOD;

	
		//bank payment terms
		$count_bank_payment_terms	= count( $online_payment_terms ); 
		$count_bankTerms			= $count_bank_payment_terms-1; 
		if(isset($online_payment_terms["heading"]) ) { 
			$pdf_html .= "<br>";
			$pdf_html .= "<br>";
			$pdf_html .= '<table  cellpadding="7"  cellspacing="0"   width="100%" bgcolor="#FFE200"><tr><td class="heading">' . $online_payment_terms["heading"] . '</td></tr></table>';
			
		}
		if( $count_bankTerms > 0 ){
			$pdf_html .= "<ul class='client_listing'>";
				for ( $i = 0; $i < $count_bankTerms; $i++ ) { 
					$pdf_html .= "<li>" . $online_payment_terms[$i]["terms"] . "</li>";
				}
			$pdf_html .= "</ul>";
		}
		
		
		//AMENDMENT POLICY section	
		if(isset($amendment_policy["heading"]) ) {
			$pdf_html .= "<br>";
			$pdf_html .= "<br>";	
			$pdf_html .= '<table  cellpadding="7"  cellspacing="0"   width="100%" bgcolor="#FFE200"><tr><td class="heading">' . $amendment_policy["heading"]  . '</td></tr></table>';
			
		}
		
		$count_amendment_policy	= count( $amendment_policy );
		if( $count_amendment_policy > 0 ){
			$pdf_html .= '<table  cellpadding="7" border="1" cellspacing="0"   width="100%">';
				for ( $i = 0; $i < $count_amendment_policy-1; $i++ ) {
					$book_title = isset($amendment_policy[$i]["amend_policy"]) ? $amendment_policy[$i]["amend_policy"] : "";
					$book_val = isset($amendment_policy[$i]["amend_policy_right"]) ? $amendment_policy[$i]["amend_policy_right"] : "";
					$pdf_html .= "<tr><td>{$book_title}</td><td>{$book_val}</td></tr>";
				}
			$pdf_html .= "</table>";
		}	
		$pdf_html .= "<hr>";
		
		//payment policy
		if(isset($payment_policy["heading"]) ) { 
		$pdf_html .= "<br>";
		$pdf_html .= "<br>";
		$pdf_html .= "<br>";
			$pdf_html .= '<table  cellpadding="7"  cellspacing="0"   width="100%" bgcolor="#FFE200"><tr><td class="heading">' . $payment_policy["heading"]   . '</td></tr></table>';
		}
		$count_payPolicy	= count( $payment_policy );
		if( $count_payPolicy > 0 ){
			$pdf_html .= '<table  cellpadding="7" border="1" cellspacing="0"   width="100%">';
				for ( $i = 0; $i < $count_payPolicy-1; $i++ ) {
					$book_title = isset($payment_policy[$i]["pay_policy"]) ? $payment_policy[$i]["pay_policy"] : "";
					$book_val = isset($payment_policy[$i]["pay_policy_right"]) ? $payment_policy[$i]["pay_policy_right"] : "";
					$pdf_html .= "<tr><td>{$book_title}</td><td>{$book_val}</td></tr>";
				}
			$pdf_html .= "</table>";
		}	
		
		//refund policy
		if(isset($cancel_tour_by_client["heading"]) ) { 
		$pdf_html .= "<br>";
		$pdf_html .= "<br>";
		$pdf_html .= "<br>";
			$pdf_html .= '<table  cellpadding="7"  cellspacing="0"   width="100%" bgcolor="#FFE200"><tr><td class="heading">' . $cancel_tour_by_client["heading"]   . '</td></tr></table>';
			 
		}
		
		$count_cancel_content	= count( $cancel_tour_by_client );
		/* if( $count_cancel_content > 0 ){
			
			$pdf_html .= "<ul class='client_listing'>";
				for ( $i = 0; $i < $count_cancel_content-1; $i++ ) { 
					$pdf_html .= "<li>" . $cancel_tour_by_client[$i]["cancel_terms"] . "</li>";
				}
			$pdf_html .= "</ul>";
			
		}	 */
		
		if( $count_cancel_content > 0 ){
			$pdf_html .= '<table  cellpadding="7" border="1" cellspacing="0"   width="100%">';
				for ( $i = 0; $i < $count_cancel_content-1; $i++ ) {
					$book_title = isset($cancel_tour_by_client[$i]["cancel_terms"]) ? $cancel_tour_by_client[$i]["cancel_terms"] : "";
					$book_val = isset($cancel_tour_by_client[$i]["cancel_terms_right"]) ? $cancel_tour_by_client[$i]["cancel_terms_right"] : "";
					$pdf_html .= "<tr><td>{$book_title}</td><td>{$book_val}</td></tr>";
				}
			$pdf_html .= "</table>";
		}	
		//terms and condition
		if(isset($terms_condition["heading"]) ) { 
			$pdf_html .= "<br>";
		$pdf_html .= "<br>";
			$pdf_html .= '<table  cellpadding="7"  cellspacing="0"   width="100%" bgcolor="#FFE200"><tr><td class="heading">' . $terms_condition["heading"] . '</td></tr></table>';
		 
		}
		$count_cancel_content	= count( $terms_condition );
		if( $count_cancel_content > 0 ){
			
			$pdf_html .= "<ul class='client_listing'>";
				for ( $i = 0; $i < $count_cancel_content-1; $i++ ) { 
					$pdf_html .= "<li>" . $terms_condition[$i]["terms"] . "</li>";
				}
			$pdf_html .= "</ul>";
		}
		
		//Get office branches
		$head_off = get_head_office();
		$head_office = $head_off[0];
		if( !empty(  $head_office ) ){ 
			$pdf->SetFont('', 'B', 14);
			$pdf_html .= '<table  cellpadding="7"  cellspacing="0"   width="100%" bgcolor="#FFE200"><tr><td class="heading">Track Itinerary HEAD OFFICE</td></tr></table>';
			$pdf_html .= "<br>";
			
			$pdf_html .= '<table  cellpadding="7"  cellspacing="0"   width="100%">
						<tr>
							<td width="20%"><strong>'. $head_office->branch_name .'</strong></td>
							<td width="80%">'. $head_office->branch_address .'<br> '. $head_office->branch_contact .' <br> ' . $head_office->email_address .'</td>
						</tr>
				</table>';
			
			

			//$pdf_html .= "<div class='address_new_email'><p><span><i class='fa fa-phone-square' aria-hidden='true'></i></i></span>" . $head_office->branch_contact . "</p>";
			//$pdf_html .= "<p><span><i class='fa fa-envelope' aria-hidden='true'></i></span>" . $head_office->email_address . "</p> </div>";
			
		}
		
		
		//branches
		
		$office_branches = get_office_branches();
		if( !empty( $office_branches ) ){
		 
			$pdf_html .= '<table  cellpadding="7"  cellspacing="0"   width="100%" bgcolor="#FFE200"><tr><td class="heading">BRANCHES</td></tr></table>';
			
			foreach( $office_branches as $branch ){
				
				$pdf_html .= '<table  cellpadding="7"  cellspacing="0"   width="100%">
						<tr>
							<td width="20%"><strong>'. $branch->branch_name .'</strong></td>
							<td width="80%">'. $branch->branch_address .'<br> '. $branch->branch_contact .' <br> ' . $branch->email_address .'</td>
						</tr>
				</table>';
			
			
			/*
				$pdf_html .= "<div class='branch_section'>";
				$pdf_html .=  "<h3>" . $branch->branch_name . "</h3>";
					$pdf_html .=  "<p> <span><i class='fa fa-home' aria-hidden='true'></i></span>" . $branch->branch_address . "</p>";
					$pdf_html .=  "<p><span><i class='fa fa-phone-square' aria-hidden='true'></i> </span>" . $branch->branch_contact . "</p>";
					$pdf_html .=  "<p><span><i class='fa fa-envelope' aria-hidden='true'></i></span>" . $branch->email_address . "</p>";
				$pdf_html .= "</div>";	*/
			}
		}
	$agent_id = $iti->agent_id;
	$user_info = get_user_info($agent_id);
	if($user_info){
		$agent = $user_info[0];
		$pdf_html .= "<strong>Regards</strong><br>";
		$pdf_html .=  "<strong>" . $agent->first_name . " " . $agent->last_name . "</strong><br>";
		$pdf_html .=  "<strong>Call Us : </strong> " . $agent->mobile . "<br>";
		$pdf_html .=  "<strong>Email : </strong> " . $agent->email . "<br>";
		$pdf_html .=  "<strong>Timing : </strong> " . $agent->in_time . " To " . $agent->out_time . "<br>";
		$pdf_html .=  "<strong>Website : </strong> " . $agent->website;
		
	}
	$pdf_html .=  "<br><br>" . $signature;
	$pdf->SetFont('courier', '', 12);
	
	$pdf_html .=  "</div>";
	$pdf->writeHTML($pdf_html, true, false, true, false, '');
	ob_end_clean();
	// Output the PDF to the browser
   $pdf->Output( $pdf_name . '.pdf' , 'I'); // the second option D forces the browser to download the PDF. Passing I will tell the browser to show it 
}else{
	redirect("itineraries");
}