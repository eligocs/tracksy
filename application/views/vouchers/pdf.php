<?php
if( !empty($itinerary )){
	$iti = $itinerary[0];
	$pay = $iti_payment_details[0];
	$voucher 	= $vouchers[0];

	$customer_id = $customer[0]->customer_id;
	$customer_account = get_customer_account( $customer_id );
	if( $customer_account && !empty( $customer_account[0]->customer_name ) ){
		$customer_name 		= $customer_account[0]->customer_name;
		$customer_email 	= $customer_account[0]->customer_email;
		$customer_contact 	= $customer_account[0]->customer_contact;
		$customer_address 	= $customer_account[0]->address;
	}else{
		$customer_name 		= $customer[0]->customer_name;
		$customer_email 	= $customer[0]->customer_email;
		$customer_contact 	= $customer[0]->customer_contact;
		$customer_address 	= $customer[0]->customer_address;
	}
			
	//$pdf_name = $iti->iti_id . '_' . $iti->temp_key;
	$pdf_html = "";
	$pdf_html .= <<<EOF
	<style>
		.heading{    border: 1px solid #e8ce00; background-color: #FFE200; font-family: 'Open Sans', sans-serif; font-size: 14px !important; text-transform: uppercase; color: rgb(0, 64, 130); font-weight:bold; }
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
	$terms = $iti->iti_type == 2 ? get_hotel_terms_condition() : get_terms_condition();
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
	
	$pdf_name = 'voucher_' . $voucher->voucher_id . '_' . str_replace(' ', '_' ,$customer_name);
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
	$pdf_html .= '<table  cellpadding="7"  cellspacing="0"  width="100%"><tr><td class="heading">VOUCHER ID: ' . $voucher->voucher_id . '</td></tr></table>';
	$pdf_html .= "Hi {$customer_name},";
	// Set font
	$pdf_html .= '<div class="clear-fix"></div>';
 		$pdf_html .= '<table  cellpadding="7"  cellspacing="0"  width="100%"><tr><td class="heading">GREETINGS FROM trackitinerary</td></tr></table>';
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
		
		$travel_date = $iti->t_start_date . " - " . $iti->t_end_date;
		$duration = $iti->iti_type == 2 ? $iti->total_nights . " Nights" : $iti->duration;
		$pdf_html .= <<<EOD
			<table cellspacing="0" cellpadding="8" border="1" bordercolor="red">
			
				<tr>
					<th>Name of Package</th>
					<th>Duration</th>
					<th>Travel Date</th>
				</tr>
				<tr>
					<td>{$iti->package_name}</td>
					<td>{$duration}</td>
					<td>{$travel_date}</td>
				</tr>
				<tr>
					<th>Email</th>
					<th>No of Travellers</th>
					<th>Cab Category</th>
				</tr>
				<tr>
					<td>{$customer_email}</td>
					<td>{$tt}</td>
					<td>{$cab}</td>
				</tr>
			</table>
EOD;
	
		
		
		// Day wise itinerary Section
		$pdf_html .= "<br>";
		$pdf_html .= "<br>";
		
		
		//if holiday package
		if( $iti->iti_type == 1 ){ 
			$pdf_html .= '<table cellpadding="7"  cellspacing="0"   width="100%" bgcolor="#FFE200"><tr class="border-black"><td class="heading">Day Wise Programme:</td></tr></table>';
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
		}
		
		//ACCOMMODATIONS DETAILS
		if( $hotels ){
			$pdf_html .= '<table cellpadding="7"  cellspacing="0"   width="100%" bgcolor="#FFE200"><tr class="border-black"><td class="heading">Accommodation:</td></tr></table>';
			
			$pdf_html .= <<<EOD
			<table cellspacing="0" cellpadding="5" border="1">
			<tr>
				<th>Sr.</th>
				<th>City</th>
				<th>Check In</th>
				<th>Check Out</th>
				<th>Hotel</th>
				<th>Room Category</th>
				<th>Rooms</th>
				<th>N/t</th>
			</tr>
EOD;
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
				
				//Get Hotel Information 
				$htl_info = get_hotel_details($hotel->hotel_id);;
				$hotel_info = $htl_info[0];
				$hotel_name = $hotel_info->hotel_name;
				$hotel_emails = $hotel_info->hotel_email;
				$city = get_city_name( $hotel->city_id );
				$check_in_m = display_month_name( $hotel->check_in );
				$check_out_m = display_month_name( $hotel->check_out );
				$room_cat = get_roomcat_name( $hotel->room_type );
				
				$pdf_html .= <<<EOD
				<tr nobr="true" style="font-size: 12px;">
					<td>{$ch}.</td>
					<td>{$city}</td>
					<td>{$check_in_m}</td>
					<td>{$check_out_m}</td>
					<td>{$hotel_name}</td>
					<td>{$room_cat}</td>
					<td>{$hotel->total_rooms}</td>
					<td>{$nights}</td>
				</tr>	
EOD;
				$ch++;
			}
			$pdf_html .= <<<EOD
			</table>			
EOD;
		}
		//end accommodation section
		
		
		
		//Vehicle DETAILS
		if( $cab_booking ){
			$pdf_html .= '<table cellpadding="7"  cellspacing="0"   width="100%" bgcolor="#FFE200"><tr class="border-black"><td class="heading">Vehicle:</td></tr></table>';
			
			$pdf_html .= <<<EOD
			<table cellspacing="0" cellpadding="5" border="1">
			<tr>
				<th>Sr.</th>
				<th>Vehicle</th>
				<th>Pick. Date</th>
				<th>Drop. Date</th>
				<th>Tarrif</th>
			</tr>
EOD;
			$chd = 1;
			foreach ( $cab_booking as $cab_book ) {
				//Get cab_book Information 
				$cab_name = get_car_name($cab_book->cab_id);
				$picking_date = display_month_name($cab_book->picking_date);
				$droping_date = display_month_name($cab_book->droping_date);
					$pdf_html .= <<<EOD
					<tr nobr="true" style="font-size: 12px;">
						<td>{$chd}.</td>
						<td>{$cab_name}</td>
						<td>{$picking_date}</td>
						<td>{$droping_date}</td>
						<td>{$cab_book->pic_location} - {$cab_book->drop_location}</td>
					</tr>	
EOD;
					//cab meta driver info
					$cab_meta = unserialize( $cab_book->cab_meta ); 
					$t_cabs = $cab_book->total_cabs;
					if( !empty( $cab_meta ) ){
						for( $i=0; $i < $t_cabs; $i++ ){
							$taxi_number = isset($cab_meta[$i]['taxi_number']) ? $cab_meta[$i]['taxi_number'] : "";
							$driver_name = isset($cab_meta[$i]['driver_name']) ? $cab_meta[$i]['driver_name'] : "";
							$driver_contact = isset($cab_meta[$i]['driver_contact']) ? $cab_meta[$i]['driver_contact'] : "";
							
							$pdf_html .= <<<EOD
								<tr nobr="true" style="font-size: 12px;">
									<td></td>
									<td><strong>Taxi Number: </strong> {$taxi_number}</td>
									<td><strong>Driver Name: </strong> {$driver_name} </td>
									<td colspan=2><strong>Driver Contact: </strong> {$driver_contact}</td>
								</tr>	
EOD;
						}	
					}
				$chd++;
			}
			$pdf_html .= <<<EOD
			</table>			
EOD;
		}
		//end vehicle section
		
		
		//PAYMENT SECTION
		if( isset( $iti_payment_details ) && !empty( $iti_payment_details ) ){
			$pdf_html .= '<table cellpadding="7"  cellspacing="0"   width="100%" bgcolor="#FFE200"><tr class="border-black"><td class="heading">Package / Tour Cost & Advance Received Details:</td></tr></table>';
			
			$p_cost		= isset($pay->total_package_cost) ? number_format($pay->total_package_cost) : "";
			$advance 	= isset($pay->advance_recieved) ? $pay->advance_recieved : ""; 
			$balance 	= isset($pay->total_balance_amount) ?  $pay->total_balance_amount : "";
			
			$pdf_html .= <<<EOD
			<table cellspacing="0" cellpadding="5" border="1">
			<tr>
			<td>Package Cost: </td>
			<td>{$p_cost}</td></tr>
			<tr><td>Advance Received (1st Ins.): </td>
			<td>{$advance}</td></tr>
			<tr><td>Total Balance Pending: </td>
			<td>{$balance}</td></tr>
EOD;
			$pdf_html .= <<<EOD
			</table>			
EOD;
		}
		//end payment section
		
		
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
		// Contact Numbers Regarding Booking
		$get_sales_team_details = get_settings();
		$pdf->SetFont('courier', 'B', 14);
 		$pdf_html .= '<table  cellpadding="7"  cellspacing="0"   width="100%" bgcolor="#FFE200"><tr><td class="heading">Contact Numbers Regarding Booking</td></tr><tr><td class="heading">Please Contact Regarding booking & payment Detail Given Below:-</td></tr></table>';
		
		$pdf_html .=  <<<EOD
			<table cellspacing="0" cellpadding="5" border="1">
			<tr>
				<th> Sr. No.</th>
				<th> Contact For</th>
				<th> Contact Person</th>
				<th> Mobile Number</th>
				<th> Email Id</th>
			</tr>
			<tr>
				<td>1.</td>
				<td>Volvo</td>
				<td>{$get_sales_team_details->vehicle_team_name}</td>
				<td>{$get_sales_team_details->vehicle_team_contact}</td>
				<td>{$get_sales_team_details->vehicle_email}</td>
			</tr>
			<tr>
				<td>2.</td>
				<td>Hotel</td>
				<td>{$get_sales_team_details->hotel_team_name}</td>
				<td>{$get_sales_team_details->hotel_team_contact}</td>
				<td>{$get_sales_team_details->hotel_email}</td>
			</tr>
			<tr>
				<td>3.</td>
				<td>Payment</td>
				<td>{$get_sales_team_details->sales_team_name}</td>
				<td>{$get_sales_team_details->sales_team_contact}</td>
				<td>{$get_sales_team_details->sales_email}</td>
			</tr>
EOD;
			
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
			$pdf_html .= '<table  cellpadding="7"  cellspacing="0"   width="100%" bgcolor="#FFE200"><tr><td class="heading">trackitinerary HEAD OFFICE</td></tr></table>';
			$pdf_html .= "<br>";
			
			$pdf_html .= '<table  cellpadding="7"  cellspacing="0"   width="100%">
						<tr>
							<td width="20%"><strong>'. $head_office->branch_name .'</strong></td>
							<td width="80%">'. $head_office->branch_address .'<br> '. $head_office->branch_contact .' <br> ' . $head_office->email_address .'</td>
						</tr>
				</table>';	
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
	redirect("vouchers");
}