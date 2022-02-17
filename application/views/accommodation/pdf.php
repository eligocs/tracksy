<?php
if( !empty($itinerary )){
$acc = $itinerary[0];
	$pdf_name = $acc->iti_id . '_' . $acc->temp_key;
	$pdf_html = "";
	$pdf_html .= <<<EOF
	<style>
		.heading{    border: 1px solid #5E76E0; background-color: #5E76E0; font-family: 'Open Sans', sans-serif; font-size: 14px !important; text-transform: uppercase; color: rgb(255, 255, 255); font-weight:bold; }
		th{background-color: #003367; font-weight:bold; color:#fff;}
		ul.list_style{ }
		.strikeLine{ text-decoration: line-through; }
		.fa{font-family: fontawesome; color: #004082; font-size: 16px;}
		.pdf{font-family:georg; font-size:14px;}
		.pdf {font-family: sans-serif; color: #484848; line-height:130%;}
			table{margin-bottom:200px;}
		.border-black{border:2px solid #003367 !important;}

	</style>
EOF;

	//get details terms and customer information
	$terms = get_hotel_terms_condition();
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
	$get_customer_info = get_customer( $acc->customer_id ); 
	$cust = $get_customer_info[0];
	
	$customer_name 		= !empty($get_customer_info) ? $cust->customer_name : "";
	$customer_contact 	= !empty($get_customer_info) ? $cust->customer_contact : "";
	$customer_email 	= !empty($get_customer_info) ? $cust->customer_email : "";
	
	
	// Set various pdf options
	$pdf = new PDF("", PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
	//	$fontname = TCPDF_FONTS::addTTFfont('fonts/fontawesome-webfont.ttf', 'TrueTypeUnicode', '', 32);

	// set document information
	$pdf->SetCreator(PDF_CREATOR);
	$pdf->SetAuthor('trackitinerary');
	$pdf->SetTitle('trackitinerary Pvt. Ltd.');
	$pdf->SetSubject('trackitinerary Itinerary');
	
	
	// Add Page
	$pdf->AddPage();
	// set font

	// set some text to print
	$pdf_html .= '<div class="pdf">';
	$pdf_html .= "Hi {$customer_name},";
	// Set font
	$pdf_html .= '<div class="clear-fix"></div>';
 		$pdf_html .= '<table  cellpadding="7"  cellspacing="0"  width="100%"><tr><td class="heading">GREETINGS FROM TRACKITINERARY</td></tr></table>';
		$pdf_html .= "<br>";
		$pdf_html .= "<br>";
		$pdf_html .= $greeting;
		
 		$pdf_html .= '<div class="clear-fix"></div>';
 		$pdf_html .= '<table  cellpadding="7"  cellspacing="0"   width="100%" ><tr><td class="heading">Package Overview</td></tr></table>';
	
		$pdf->SetFont('dejavusans', '', 10);
		$tt = "<strong> Adults: </strong> " . $acc->adults; 
		if( !empty( $acc->child ) ){
			$tt .=  "<strong> No. of Child: </strong> " . $acc->child; 
			$tt .=  "<strong> Child age: </strong> " . $acc->child_age; 
		}
		
		$pdf_html .= <<<EOD
			<table cellspacing="0" cellpadding="8" border="1" bordercolor="red">
			
				<tr>
					<th>Name of Package</th>
					<th>Routing</th>
					<th>Duration</th>
				</tr>
				<tr>
					<td>{$acc->package_name}</td>
					<td>{$acc->package_routing}</td>
					<td>{$acc->total_nights}</td>
				</tr>
				<tr>
					<th>No of Travellers</th>
					<th>Tour Start</th>
					<th>Tour End</th>
					
				</tr>
				<tr>
					<td>{$tt}</td>
					<td>{$acc->t_start_date}</td>
					<td>{$acc->t_end_date}</td>
				</tr>
			</table>
EOD;
	
 		// Hotel Details Section
		$hotel_meta = unserialize($acc->hotel_meta); 
		$check_hotel_cat = array();
		$check_hotel_cat = !empty($hotel_meta) ? array_column($hotel_meta, "hotel_inner_meta" ) : "";
		
		//Get all category
		$all_hotel_cats = [];
		foreach( $check_hotel_cat as $date => $array ) {
			$all_hotel_cats = array_merge($all_hotel_cats, array_column($array, "hotel_category"));
		}
		
		/* echo "<pre>";
			print_r( $all_hotel_cats );
		echo "</pre>"; */
		
		$is_standard	= !empty($all_hotel_cats) && in_array("Standard", $all_hotel_cats) ? TRUE : FALSE;
		$is_deluxe		= !empty($all_hotel_cats) && in_array("Deluxe",  $all_hotel_cats) ? TRUE : FALSE;
		$is_s_deluxe 	= !empty($all_hotel_cats) && in_array("Super Deluxe",  $all_hotel_cats) ? TRUE : FALSE;
		$is_luxury 		= !empty($all_hotel_cats) && in_array("Luxury", $all_hotel_cats ) ? TRUE : FALSE;
		
		$pdf_html .= "<br>";
		$pdf_html .= "<br>";
		$pdf->SetFont('courier', 'B', 14);
		$pdf_html .= '<table  cellpadding="7"  cellspacing="0"   width="100%" bgcolor="#FFE200"><tr><td class="heading">Hotel Details</td></tr></table>';
		
		$standard_html = "";
		$deluxe_html = "";
		$super_deluxe_html = "";
		$luxury_html = "";
		$table_start = '<table cellspacing="0" cellpadding="5" border="1"><tr>
				<th>City</th>
				<th>Hotel Category</th>
				<th>Check In</th>
				<th>Check Out</th>
				<th>Hotel</th>
				<th>Room Category</th>
				<th>Plan</th>
				<th>Room</th>
				<th>N/T</th>
			</tr>';
		if( !empty( $hotel_meta ) ){
			$count_hotel = count( $hotel_meta );
			/* print_r( $hotel_meta ); */
			if( $count_hotel > 0 ){
				for ( $i = 0; $i < $count_hotel; $i++ ) {
					
					$hotel_location = $hotel_meta[$i]["hotel_location"];
					$check_in 		= $hotel_meta[$i]["check_in"];
					$check_out 		= $hotel_meta[$i]["check_out"];
					$total_room 	= $hotel_meta[$i]["total_room"];
					$total_nights 	= $hotel_meta[$i]["total_nights"];
					$extra_bed 		= !empty( $hotel_meta[$i]['extra_bed'] ) ? " + <strong>" . $hotel_meta[$i]['extra_bed'] . " </strong> Extra Bed" : "";
					
					$hotel_inner_meta = $hotel_meta[$i]["hotel_inner_meta"];
					//Fetch hotel inner meta
					$count_innermeta = count( $hotel_inner_meta );
					//print_r($hotel_inner_meta);
					
					if( !empty( $count_innermeta ) ){
						for( $ii = 0 ; $ii < $count_innermeta ; $ii++ ){
							$hotel_category	= $hotel_inner_meta[$ii]["hotel_category"];
							$room_category 	= $hotel_inner_meta[$ii]["room_category"];
							$hotel_name 	= $hotel_inner_meta[$ii]["hotel_name"];
							$meal_plan 		= $hotel_inner_meta[$ii]["meal_plan"];
							
							//hotel details html category wise
							switch( $hotel_category ){
								case "Standard":
									$standard_html .= "<tr>
										<td>{$hotel_location}</td>
										<td>Deluxe</td>
										<td>{$check_in}</td>
										<td>{$check_out}</td>
										<td>{$hotel_name}</td>
										<td>{$room_category}</td>
										<td>{$meal_plan}</td>
										<td>{$total_room}{$extra_bed}</td>
										<td>{$total_nights}</td>
									</tr>";
								break;
								case "Deluxe":
									$deluxe_html .= "<tr>
										<td>{$hotel_location}</td>
										<td>Super Deluxe</td>
										<td>{$check_in}</td>
										<td>{$check_out}</td>
										<td>{$hotel_name}</td>
										<td>{$room_category}</td>
										<td>{$meal_plan}</td>
										<td>{$total_room}{$extra_bed}</td>
										<td>{$total_nights}</td>
									</tr>";
								break;
								case "Super Deluxe":
									$super_deluxe_html .= "<tr>
										<td>{$hotel_location}</td>
										<td>Luxury</td>
										<td>{$check_in}</td>
										<td>{$check_out}</td>
										<td>{$hotel_name}</td>
										<td>{$room_category}</td>
										<td>{$meal_plan}</td>
										<td>{$total_room}{$extra_bed}</td>
										<td>{$total_nights}</td>
									</tr>";
								break;
								case "Luxury":
									$luxury_html .= "<tr>
										<td>{$hotel_location}</td>
										<td>Super Luxury</td>
										<td>{$check_in}</td>
										<td>{$check_out}</td>
										<td>{$hotel_name}</td>
										<td>{$room_category}</td>
										<td>{$meal_plan}</td>
										<td>{$total_room}{$extra_bed}</td>
										<td>{$total_nights}</td>
									</tr>";
								break;
								default:
									continue;
								break;
							}
						}
					} /**end hotel inner meta*/
				} 	
				
				if( $is_standard ) {
					$pdf->SetFont('courier', 'B', 14);
					$pdf_html .= '<table  cellpadding="7"  cellspacing="0"   width="100%" bgcolor="#FFE200"><tr><td class="heading"> Deluxe</td></tr></table>';
					$pdf->SetFont('courier', 'B', 12);
			
					$pdf_html .= $table_start;
					$pdf_html .=  $standard_html . "</table>";
				}
				if( $is_deluxe ){
					$pdf->SetFont('courier', 'B', 14);
					$pdf_html .= '<table  cellpadding="7"  cellspacing="0"   width="100%" bgcolor="#FFE200"><tr><td class="heading"> Super Deluxe</td></tr></table>';
					$pdf->SetFont('courier', 'B', 12);
			
					$pdf_html .= $table_start;
					$pdf_html .=  $deluxe_html . "</table>";
				}
				if( $is_s_deluxe ){
					$pdf->SetFont('courier', 'B', 14);
					$pdf_html .= '<table  cellpadding="7"  cellspacing="0"   width="100%" bgcolor="#FFE200"><tr><td class="heading"> Luxury</td></tr></table>';
					$pdf->SetFont('courier', 'B', 12);
			
					$pdf_html .= $table_start;
					$pdf_html .=  $super_deluxe_html . "</table>";
				}
				
				if( $is_luxury ){
					$pdf->SetFont('courier', 'B', 14);
					$pdf_html .= '<table  cellpadding="7"  cellspacing="0"   width="100%" bgcolor="#FFE200"><tr><td class="heading"> Super Luxury</td></tr></table>';
					$pdf->SetFont('courier', 'B', 12);
					$pdf_html .= $table_start;
					$pdf_html .=  $luxury_html . "</table>";
				}
			} 
		
		} /* end hotel meta */ 
		$pdf_html .= "<br>";
		$pdf_html .= "<br>";
		$pdf->SetFont('courier', 'B', 14);
		$pdf_html .= '<table  cellpadding="7"  cellspacing="0"   width="100%" bgcolor="#FFE200"><tr><td class="heading"> Rates</td></tr></table>';
		$pdf->SetFont('courier', 'B', 12);
			//Rate meta
			$rate_meta = unserialize($acc->rates_meta);
			//add strike line on price is 
			$strike = !empty( $discountPriceData ) ? "<strike>" : " ";
			$strike_end = !empty( $discountPriceData ) ? "</strike>" : " ";
			//print_r( $rate_meta );
			$iti_close_status = $iti->iti_close_status;
			//print_r( $rate_meta );
			if( empty($iti_close_status) ){
			if( !empty( $rate_meta ) ){
				$agent_price_percentage = !empty($acc->agent_price) ? $acc->agent_price : 0;
				//get per person price
				$per_person_ratemeta 	= unserialize($acc->per_person_ratemeta);
				//$inc_gst = isset( $per_person_ratemeta["inc_gst"] ) && $per_person_ratemeta["inc_gst"] == 1 ? "(GST Inc.)" : "(GST Extra)";
				$inc_gst = "";
				
				$s_pp = isset( $per_person_ratemeta["standard_rates"] ) && !empty($per_person_ratemeta["standard_rates"] ) ? "RS. " . number_format($per_person_ratemeta["standard_rates"] + $per_person_ratemeta["standard_rates"] * $agent_price_percentage/100 ) . "/- Per Person" : "";
				$d_pp = isset( $per_person_ratemeta["deluxe_rates"] ) && !empty($per_person_ratemeta["deluxe_rates"]) ? "RS. " . number_format($per_person_ratemeta["deluxe_rates"] + $per_person_ratemeta["deluxe_rates"] * $agent_price_percentage/100) . "/- Per Person" : "";
				$sd_pp = isset( $per_person_ratemeta["super_deluxe_rates"] ) && !empty($per_person_ratemeta["super_deluxe_rates"]) ? "RS. " . number_format($per_person_ratemeta["super_deluxe_rates"] + $per_person_ratemeta["super_deluxe_rates"] * $agent_price_percentage/100) . "/- Per Person" : "";
				$l_pp = isset( $per_person_ratemeta["luxury_rates"] ) && !empty($per_person_ratemeta["luxury_rates"]) ? "RS. " . number_format($per_person_ratemeta["luxury_rates"] + $per_person_ratemeta["luxury_rates"] * $agent_price_percentage/100) . "/- Per Person" : "";
				
				//child rates
				$child_s_pp = isset( $per_person_ratemeta["child_standard_rates"] ) && !empty($per_person_ratemeta["child_standard_rates"]) ? "RS. " . number_format($per_person_ratemeta["child_standard_rates"] + $per_person_ratemeta["child_standard_rates"] * $agent_price_percentage/100) . "/- Per Child" : "";
				$child_d_pp = isset( $per_person_ratemeta["child_deluxe_rates"] ) && !empty($per_person_ratemeta["child_deluxe_rates"]) ? "RS. " . number_format($per_person_ratemeta["child_deluxe_rates"] + $per_person_ratemeta["child_deluxe_rates"] * $agent_price_percentage/100) . "/- Per Child" : "";
				$child_sd_pp = isset( $per_person_ratemeta["child_super_deluxe_rates"] ) && !empty($per_person_ratemeta["child_super_deluxe_rates"]) ? "RS. " . number_format($per_person_ratemeta["child_super_deluxe_rates"] + $per_person_ratemeta["child_super_deluxe_rates"] * $agent_price_percentage/100 ) . "/- Per Child" : "";
				$child_l_pp = isset( $per_person_ratemeta["child_luxury_rates"] ) && !empty($per_person_ratemeta["child_luxury_rates"]) ? "RS. " . number_format($per_person_ratemeta["child_luxury_rates"] + $per_person_ratemeta["child_luxury_rates"] * $agent_price_percentage/100 ) . "/- Per Child" : "";	
				
				$standard_rates = !empty( $rate_meta["standard_rates"]) ? number_format($rate_meta["standard_rates"] + $rate_meta["standard_rates"] * $agent_price_percentage / 100 ) . "/- {$inc_gst} <br> {$s_pp}  <br> {$child_s_pp}" : "<strong class='red'>On Request</strong>";
				$deluxe_rates = !empty( $rate_meta["deluxe_rates"]) ? number_format($rate_meta["deluxe_rates"] + $rate_meta["deluxe_rates"] * $agent_price_percentage / 100 ) . "/- {$inc_gst} <br> {$d_pp}  <br> {$child_d_pp}" : "<strong class='red'>On Request</strong>";
				$super_deluxe_rates = !empty( $rate_meta["super_deluxe_rates"]) ? number_format($rate_meta["super_deluxe_rates"] + $rate_meta["super_deluxe_rates"] * $agent_price_percentage / 100 ) . "/- {$inc_gst} <br> {$sd_pp}  <br> {$child_sd_pp}" : "<strong class='red'>On Request</strong>";
				$rate_luxry = !empty( $rate_meta["luxury_rates"]) ? number_format($rate_meta["luxury_rates"] + $rate_meta["luxury_rates"] * $agent_price_percentage / 100 ) . "/- {$inc_gst} <br> {$l_pp}  <br> {$child_l_pp}" : "<strong class='red'>On Request</strong>"; 
				
				$pdf_html .= <<<EOD
				<table cellspacing="0" cellpadding="5" border="1"><tr><th>Hotel Category</th><th>Deluxe</th><th>Super Deluxe</th><th>Luxury</th><th>Super Luxury</th></tr>
				<tr>
					<td style="font-size: 12px;">Price</td>
					<td>{$strike}{$standard_rates}{$strike_end}</td>
					<td>{$strike}{$deluxe_rates}{$strike_end}</td>
					<td>{$strike}{$super_deluxe_rates}{$strike_end}</td>
					<td>{$strike}{$rate_luxry}{$strike_end}</td>
				</tr>
EOD;
		
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
						$s_pp = isset( $per_person_ratemeta["standard_rates"] ) && !empty($per_person_ratemeta["standard_rates"] ) ? "RS. " . number_format($per_person_ratemeta["standard_rates"] + $per_person_ratemeta["standard_rates"] * $agent_price_percentage/100 ) . "/- Per Person" : "";
						$d_pp = isset( $per_person_ratemeta["deluxe_rates"] ) && !empty($per_person_ratemeta["deluxe_rates"]) ? "RS. " . number_format($per_person_ratemeta["deluxe_rates"] + $per_person_ratemeta["deluxe_rates"] * $agent_price_percentage/100) . "/- Per Person" : "";
						$sd_pp = isset( $per_person_ratemeta["super_deluxe_rates"] ) && !empty($per_person_ratemeta["super_deluxe_rates"]) ? "RS. " . number_format($per_person_ratemeta["super_deluxe_rates"] + $per_person_ratemeta["super_deluxe_rates"] * $agent_price_percentage/100) . "/- Per Person" : "";
						$l_pp = isset( $per_person_ratemeta["luxury_rates"] ) && !empty($per_person_ratemeta["luxury_rates"]) ? "RS. " . number_format($per_person_ratemeta["luxury_rates"] + $per_person_ratemeta["luxury_rates"] * $agent_price_percentage/100) . "/- Per Person" : "";
						
						//child rates
						$child_s_pp = isset( $per_person_ratemeta["child_standard_rates"] ) && !empty($per_person_ratemeta["child_standard_rates"]) ? "RS. " . number_format($per_person_ratemeta["child_standard_rates"] + $per_person_ratemeta["child_standard_rates"] * $agent_price_percentage/100) . "/- Per Child" : "";
						$child_d_pp = isset( $per_person_ratemeta["child_deluxe_rates"] ) && !empty($per_person_ratemeta["child_deluxe_rates"]) ? "RS. " . number_format($per_person_ratemeta["child_deluxe_rates"] + $per_person_ratemeta["child_deluxe_rates"] * $agent_price_percentage/100) . "/- Per Child" : "";
						$child_sd_pp = isset( $per_person_ratemeta["child_super_deluxe_rates"] ) && !empty($per_person_ratemeta["child_super_deluxe_rates"]) ? "RS. " . number_format($per_person_ratemeta["child_super_deluxe_rates"] + $per_person_ratemeta["child_super_deluxe_rates"] * $agent_price_percentage/100 ) . "/- Per Child" : "";
						$child_l_pp = isset( $per_person_ratemeta["child_luxury_rates"] ) && !empty($per_person_ratemeta["child_luxury_rates"]) ? "RS. " . number_format($per_person_ratemeta["child_luxury_rates"] + $per_person_ratemeta["child_luxury_rates"] * $agent_price_percentage/100 ) . "/- Per Child" : "";	
					
						$s_price = !empty( $price->standard_rates) ? number_format($price->standard_rates + $price->standard_rates * $agent_price_percentage/100 ) . "/- {$inc_gst} <br> {$s_pp}  <br> {$child_s_pp}" : "<strong class='red'>N/A</strong>";
						$d_price = !empty( $price->deluxe_rates) ? number_format($price->deluxe_rates + $price->deluxe_rates * $agent_price_percentage/100) . "/- {$inc_gst} <br> {$d_pp}  <br> {$child_d_pp}" : "<strong class='red'>N/A</strong>";
						$sd_price = !empty( $price->super_deluxe_rates) ? number_format($price->super_deluxe_rates + $price->super_deluxe_rates * $agent_price_percentage/100) . "/- {$inc_gst} <br> {$sd_pp}  <br> {$child_sd_pp}"  : "<strong class='red'>N/A</strong>";
						$l_price = !empty( $price->luxury_rates) ? number_format($price->luxury_rates + $price->luxury_rates * $agent_price_percentage/100) . "/- {$inc_gst} <br> {$l_pp}  <br> {$child_l_pp}"  : "<strong class='red'>N/A</strong>";
						
						$count_price = count( $discountPriceData );
						$st = ($price !== end($discountPriceData) && $count_price > 1 ) ? "<strike>" : "";
						$stend = ($price !== end($discountPriceData) && $count_price > 1 ) ? "</strike>" : "";
					$pdf_html .= <<<EOD
			<tr>
				<td style="font-size: 12px;">Price</td>
				<td>{$st}{$s_price}{$stend}</td>
				<td>{$st}{$d_price}{$stend}</td>
				<td>{$st}{$sd_price}{$stend}</td>
				<td>{$st}{$l_price}{$stend}</td>
			</tr>
EOD;
			
				}
				
				}
			}  
$pdf_html .= <<<EOD
			</table>
			
EOD;
			
		}
		}
		
		
		// Inclusion & Exclusion Section
		$pdf_html .= "<br>";
		$pdf_html .= "<br>";
	 
 		$pdf_html .= '<table cellpadding="7"  cellspacing="0"   width="100%" bgcolor="#FFE200"><tr><td class="heading">Inclusion & Exclusion</td></tr></table>';
	
		$inclusion = unserialize($acc->inc_meta); 
		$count_inc = count( $inclusion );
		$sp_inc = unserialize($acc->special_inc_meta); 
		$count_sp_inc = count( $sp_inc );
		$exclusion = unserialize($acc->exc_meta); 
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
				$si = $sp_inc[$ii]['tour_special_inc'];
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
		
		
		
		// Hotel Note
		$pdf_html .= "<br>";
		$pdf_html .= "<br>";
 		$pdf_html .= "<strong>Notes:</strong>";
			
		$hotel_note_meta = unserialize($acc->hotel_note_meta); 
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
		$countTc	= count( $terms_condition );
		if(  !empty( $terms_condition ) ){
			
			$pdf_html .= "<ul class='client_listing'>";
				for ( $i = 0; $i < $countTc-1; $i++ ) { 
					$pdf_html .= "<li>" . $terms_condition[$i]["terms"] . "</li>";
				}
			$pdf_html .= "</ul>";
		}
		
		//Get office branches
		$head_off = get_head_office();
		$head_office = $head_off[0];
		if( !empty(  $head_office ) ){ 
			$pdf->SetFont('', 'B', 14);
			$pdf_html .= '<table  cellpadding="7"  cellspacing="0"   width="100%" bgcolor="#FFE200"><tr><td class="heading">trackitinerary HEAD OFFICE</td></tr></table>';
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
	$agent_id = $acc->agent_id;
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