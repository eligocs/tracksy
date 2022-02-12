<link href="https://fonts.googleapis.com/css?family=Roboto:400,700" rel="stylesheet">
<?php
   if( !empty($itinerary )){
   $iti = $itinerary[0];
   	$iti_id = $iti->iti_id;
   	$mail_html = "";
   	$mail_html .= "<html><head>
   	<style>
   	body{ font-family: 'Open Sans', sans-serif; color:#555555; margin:0; padding:0;}
   	.hotel-details td{vertical-align:top;}
   	h1{   color: #004082;
       font-size: 20px;
       background: #FFE200;
       padding: 10px 5px;
       border: 1px solid #e8ce00;
       margin-bottom: 0;}
   	table td{border:1px solid #ccc;}
   	#payment th{     color: #ffffff;    font-size: 16px;    background: #364150;    padding: 3px 12px;    border: 1px solid #5f6873;}
   	#payment td{font-size:15px;    color: #000;}
   	.day, .date, .day-name {font-family: 'Roboto', sans-serif; text-align: center;
       font-size: 16px;
       background: #ececec;
       padding: 3px 12px;
       border: 1px solid #cccccc;
       margin-bottom: 5px;}
   	.description, .tour-stay, .meal, .tour-name {margin-bottom: 7px;}
   	p.description {margin-top: 6px;}
   	ul.list_style {padding: 0;}
   	ul.list_style li{     color: #505050;   list-style-type: disc;
       margin-bottom: 5px;
       border-bottom: 1px solid #cccccc;
       padding: 2px 7px 2px 15px;
       position: relative;
       list-style: none;
       background: #f9f9f9;}
   	ul.list_style li:before {
           content: ' ';
       position: absolute;
       width: 5px;
       height: 5px;
       left: 4px;
       top: 9px;
       width: 0;
       height: 0;
       border-top: 3px solid transparent;
       border-bottom: 3px solid transparent;
       border-left: 3px solid #000000;
   }
   	span.small { display: block; font-size: 80%;}	
   	.mail-logo{    text-align: center;
       background: #364150;
       padding: 16px;
       border: 1px solid #000;}
   	
   	.btn {
   		background-color: #4CAF50;
   		border: none;
   		border-radius: 5px;
   		color: white;
   		padding: 15px 32px;
   		text-align: center;
   		text-decoration: none;
   		display: inline-block;
   		font-size: 16px;
   		margin: 10px 10px;
   		cursor: pointer;
   	}
   	.btn.btn-info{
   		background-color: blue;
   	}
   	.btn.btn-danger{
   		background-color: red;
   	}
   	.response_btn {
   		text-align: center;
   	}
   	.text-center{text-align:center;}
   		.btn:hover {background: red !important;}
   		p {line-height: 140%;}
   	</style></head><body>";
   	$mail_html .= '<div style="background-color:#ececec; margin:0; padding:20px 0 50px;">
   		<div style="max-width:800px;margin: 0 auto;background-color: #fff;padding: 15px;    border: 1px solid #c5c5c5;">';
   	
   	// set some text to print
   	$logo_url = base_url() . "site/images/trackv2-logo.png";
   	$mail_html .= "<div class='mail-logo' style='text-align: center;
       background: #003367;
       padding: 16px;
       border: 1px solid #000;'><img style='max-width: 400px;' src='{$logo_url }'></div>";
   		$terms = get_terms_condition();
   		$greeting = "";
   		if( $terms ){
   			$terms = $terms[0];
   			$greeting 	= $terms->greeting_message;
   		}
   		//Get customer info
   		$get_customer_info = get_customer( $iti->customer_id ); 
   		$cust = $get_customer_info[0];
   		$customer_name = $cust->customer_name;
   			
   		
   		$mail_html .= "<p style='margin-bottom:20px;'><strong>Hi, {$customer_name}</strong></p>";
   		$mail_html .= '<h1 style="" >GREETINGS FROM Track Itinerary</h1>';
   		$mail_html .= "<p style='margin-bottom:20px;'>{$greeting}</p>";
   
    	$mail_html .= '<h1 style="" >Package Overview</h1>';
   	$total_tra = $iti->total_travellers;
   	$total_tra = "<strong> Adults: </strong> " . $iti->adults; 
   	if( !empty( $iti->child ) ){
   		$total_tra .= "  <strong> No. of Child: </strong> " . $iti->child; 
   		$total_tra .= " (" . $iti->child_age .")"; 
   	}
   	$cab = get_car_name($iti->cab_category);
   	
   	$mail_html .= "
   		<table cellspacing='0' cellpadding='8' border='0' width='100%' align='center'>
   			<tr>
   				<th style='background-color:#003367; color:#fff;'>Name of Package</th>
   				<th style='background-color:#003367; color:#fff;'>Routing</th>
   				<th style='background-color:#003367; color:#fff;'>Duration</th>
   			</tr>
   			<tr>
   				<td>{$iti->package_name}</td>
   				<td>{$iti->package_routing}</td>
   				<td>{$iti->duration}</td>
   			</tr>
   			<tr>
   				<th style='background-color:#003367; color:#fff;'>No of Travellers</th>
   				<th style='background-color:#003367; color:#fff;'>Cab</th>
   				<th style='background-color:#003367; color:#fff;'>Travel Date</th>
   			</tr>
   			<tr>
   				<td>{$total_tra}</td>
   				<td>{$cab}</td>
   				<td>{$iti->quatation_date}</td>
   				
   			</tr>
   		</table>";
   
   		// Day wise itinerary Section
    	/* 	$mail_html .= '<h1 style="" >Day Wise Itinerary</h1>';
   
   		$day_wise = $iti->daywise_meta; 
   		$tourData = unserialize($day_wise);
   		$count_day = count( $tourData );
   		if( $count_day > 0 ){
   			for ( $i = 0; $i < $count_day; $i++ ) {
   				$day = $i;
   				if( $day < 1){
   					$d = "<strong>Day:</strong> Arrival <br>";
   				}else{
   					$d = "<strong>Day:</strong> {$day} <br>";
   				}
   				$tour_name = $tourData[$i]['tour_name'];
   				$tour_date = $tourData[$i]['tour_date'];
   				$t_date = display_date_month($tour_date);
   				$nameOfDay = date('l', strtotime($t_date));
   				$meal_plan = $tourData[$i]['meal_plan'];
   				$night_stay = $tourData[$i]['night_stay'];
   				$tour_des = $tourData[$i]['tour_des'];
   				$mail_html .= "<table cellspacing='0' cellpadding='10' border='0'  width='100%'>
   					<tr>
   						<td style='width:20%; vertical-align: top;'><div class='day' >{$d} </div>
   								<div class='day-name'><strong> {$nameOfDay} </strong> </div>
   								<div class='date'>{$t_date}</div></td>
   						<td style='' colspan='2'>
   							<div class='tour-name'><strong>{$tour_name}</strong> <br></div>
   							<div class='meal'>	<strong>Meal Plan: </strong> {$meal_plan} </div>
   							<div class='tour-stay'>	<strong>Night Stay: </strong> {$night_stay}<div>
   								<p class='description'>{$tour_des}</p></td>
   						
   					</tr>
   				</table><br><br>";				
   			}	
   		}
   		
   		// Inclusion & Exclusion Section
   		$mail_html .= '<h1 style="" >Inclusion & Exclusion</h1>';
   		
   		$inclusion = unserialize($iti->inc_meta); 
   		$count_inc = count( $inclusion );
   		$exclusion = unserialize($iti->exc_meta); 
   		$count_exc = count( $exclusion );
   		$greater_list = $count_inc >= $count_exc ? $count_inc : $count_exc;
   		$j=0;
   		if( $greater_list > 0  ){
   			
   			$mail_html .= '<table cellspacing="0" cellpadding="10" border="0"  width="100%">
   			<tr><th>Inclusion</th><th>Exclusion</th></tr>';
   			for ( $i = 0; $i < $greater_list; $i++ ) {
   				if( $i < $count_inc ){
   					$inc = "<td>" . $inclusion[$i]["tour_inc"] . "</td>";
   				}else{
   					$inc = "<td></td>";
   				}
   				$mail_html .= "<tr>{$inc}";
   				if( $i < $count_exc ){
   					$exc = "<td>" . $exclusion[$i]["tour_exc"] . "</td>";
   				}else{
   					$exc = "<td></td>";
   				}
   			 	
   				$mail_html .= "{$exc}</tr>";
   			}
   			$mail_html .= '</table>';
   		}
   		
   		// Hotel Details Section
   		$mail_html .= '<h1 style="" >Hotel Details</h1>';
   		$hotel_meta = unserialize($iti->hotel_meta); 
   		$count_hotel = count( $hotel_meta );
   			$mail_html .= '<table cellspacing="0" cellpadding="5" border="0" width="100%" class="hotel-details">
   			<tr>
   				<th>Hotel Category</th>
   				<th>Standard <span class="small">( 1 Star )</span></th>
   				<th>Deluxe <span class="small"> ( 2 Star )</span></th>
   				<th>Super Deluxe<span class="small">( 3 Star )</span></th>
   				<th>Luxury <span class="small">( 4 Star )</span></th>
   			</tr>';
   		if( $count_hotel > 0 ){
   			$hotel_st = "";
   			$hotel_d = "";
   			$hotel_sd = "";
   			$hotel_lux = "";
   			for ( $i = 0; $i < $count_hotel; $i++ ) {
   				$mail_html .= "<tr>";
   				$city_name = get_city_name( $hotel_meta[$i]["city"] ); 
   				$hotel_standard =  $hotel_meta[$i]["hotel_standard"];
   				$hotel_st .= '<ul class="list_style">';
   				foreach( $hotel_standard as $hotel ){
   					$hotel_st .= "<li>" . get_hotel_name($hotel) . "</li>";
   				}
   				$hotel_st .= "</ul>";
   				$hotel_deluxe =  $hotel_meta[$i]["hotel_deluxe"];
   				$hotel_d .= '<ul class="list_style">';
   				foreach( $hotel_deluxe as $hotel ){
   					$hotel_d .= "<li>" . get_hotel_name($hotel). "</li>";
   				}
   				$hotel_d .= "</ul>";
   				$hotel_super_deluxe =  $hotel_meta[$i]["hotel_super_deluxe"];
   				$hotel_sd .= '<ul class="list_style">';
   				foreach( $hotel_super_deluxe as $hotel ){
   					$hotel_sd .= "<li>" . get_hotel_name($hotel). "</li>";
   				}
   				$hotel_sd .= "</ul>";
   				$hotel_luxury =  $hotel_meta[$i]["hotel_luxury"];
   				$hotel_lux .= '<ul class="list_style">';
   				foreach( $hotel_luxury as $hotel ){
   					$hotel_lux .= "<li>" . get_hotel_name($hotel). "</li>";
   				}
   				$hotel_lux .= "</ul>";
   				$mail_html .= "<td style='font-size: 16px; color:#000; font-weight:bold; vertical-align:middle;'>{$city_name}</td>
   					<td>{$hotel_st}</td>
   					<td>{$hotel_d}</td>
   					<td>{$hotel_sd}</td>
   					<td>{$hotel_lux}</td>
   				</tr>";
   			}
   		
   			$mail_html .= '</table><br>';
   		}
   		// Hotel Note
    		$mail_html .= "<strong>Notes:</strong>";
   		$hotel_note_meta = unserialize($iti->hotel_note_meta); 
   		$count_hotel_meta = count( $hotel_note_meta );
   		if( $count_hotel_meta > 0 ){
   			$mail_html .= "<ul>";
   			for ( $i = 0; $i < $count_hotel_meta; $i++ ) {
   				$mail_html .= "<li>" . $hotel_note_meta[$i]["hotel_note"] . "</li>";
   			}	
   			$mail_html .= "</ul>";
   		}
   		// Rates And Dates
    		$mail_html .= '<h1 style="" >Rates & Dates</h1>' ;
   		$rates_meta = unserialize($iti->rates_meta); 
   		$count_rates_meta = count( $rates_meta );
   		$mail_html .= '<table cellspacing="0" cellpadding="5" border="0" width="100%" style="text-align: left;">
   			<tr>
   				<th>Hotel Category</th>
   				<th>Car Category</th>
   				<th>Meal Plan</th>
   				<th>Total Package Cost</th>
   			</tr>';
   		if( $count_rates_meta > 0 ){
   			for ( $i = 0; $i < $count_rates_meta; $i++ ) {
   				$hotel_cat = $rates_meta[$i]["rates_hotel_cat"]; 
   				$car_cat =  get_car_name($rates_meta[$i]["rates_car_cat"]);
   				$meal_plan = $rates_meta[$i]["rates_meal_plan"]; 
   				$pack_cost = $rates_meta[$i]["rates_package_cost"];
   				$mail_html .= " <tr>
   				<td style=''>{$hotel_cat}</td>
   				<td style=''>{$car_cat}</td>
   				<td style=''>{$meal_plan}</td>
   				<td style=''>{$pack_cost}</td>
   			</tr>";
   			}	
   		}
   	$mail_html .= '</table><br>';
   	
   		// Rates & Dates Note
   		$mail_html .= "<strong>Notes:</strong>";
   		$rates_note_meta = unserialize($iti->rates_note_meta); 
   		$count_note_count = count( $rates_note_meta ); 
   		if( $count_note_count > 0 ){
   			$mail_html .= "<ul>";
   			for ( $i = 0; $i < $count_note_count; $i++ ) {
   				$mail_html .= "<li>" . $rates_note_meta[$i]["hote_note"] . "</li>";
   			}	
   			$mail_html .= "</ul>";
   		}
   		
   	// Bank Details Procedure
    		$mail_html .= "<h3>Bank Details: Cash/Cheque at Bank or Net Transfer</h3>";
   		$mail_html .= ' 
   			<table cellspacing="0" cellpadding="5" border="0" width="100%" style="text-align: left" id="payment">
   			<tr>
   				<th >Bank Name</th>
   				<th >Payee Name</th>
   				<th >A/c Type</th>
   				<th >A/c Number</th>
   				<th >Branch Address</th>
   				<th >IFSC Code</th>
   			</tr>';
   			$banks = get_all_banks(); 
   			if( $banks ){
   				foreach( $banks as $bank ){ 
   					$b_name = $bank->bank_name;
   					$payee_name = $bank->payee_name;
   					$ac_type = $bank->account_type;
   					$ac_number = $bank->account_number;
   					$b_address = $bank->branch_address;
   					$ifsc = $bank->ifsc_code;
   					
   					$mail_html .= "
   					<tr>
   						<td>{$b_name}</td>
   						<td>{$payee_name}</td>
   						<td>{$ac_type}</td>
   						<td>{$ac_number}</td>
   						<td>{$b_address}</td>
   						<td>{$ifsc}</td>
   					</tr>";
   				}
   			}
   $mail_html .= '</table>';
   
   	//Terms and Condition
   	$terms = get_terms_condition();
   	if( $terms ){
   		$terms = $terms[0];
   		$online_payment_terms = htmlspecialchars_decode($terms->bank_payment_terms_content);
   		$cancel_tour_by_client = htmlspecialchars_decode($terms->cancel_content);
   		$terms_condition = htmlspecialchars_decode($terms->terms_content);
   		$disclaimer = htmlspecialchars_decode($terms->disclaimer_content);
   		$mail_html .= $online_payment_terms;
   		$mail_html .= '<h1 style="" >Cancellation Of The Tour By Client</h1>';
   		$mail_html .= $cancel_tour_by_client;
   		$mail_html .= '<h1 style="" >Terms & Condition</h1>';
   		$mail_html .= $terms_condition;
   	}
   	$agent_id = $iti->agent_id;
   	$user_info = get_user_info($agent_id);
   	if($user_info){
   		$agent = $user_info[0];
   		$mail_html .= "<strong style='color: #000000; font-size: 18px;'>Thanks & Regards</strong><br>";
   		$mail_html .=  "<strong> " . $agent->first_name . " " . $agent->last_name . "</strong><br>";
   		$mail_html .=  "<strong>Call Us : </strong> " . $agent->mobile . "<br>";
   		$mail_html .=  "<strong>Email : </strong> " . $agent->email . "<br>";
   		$mail_html .=  "<strong>Timing : </strong> " . $agent->in_time . " To " . $agent->out_time . "<br>";
   		$mail_html .=  "<strong>Website : </strong> " . $agent->website;
   		
   	}
   		$mail_html .= "<br>";
   		//Button section
   		$mail_html .= "<div class='response_btn'><a title='Click to Approve' href=" . site_url("confirm?cus_id=". base64_url_encode($iti->customer_id) . "&iti_id=" . base64_url_encode($iti_id) . "&token_key=" . ($iti->temp_key)  . "&status=" . base64_url_encode(9)) . " class='btn btn-success' >Confirm</a>";
   		
   		$mail_html .= "<a title='Click to Postpone' href=" . site_url("confirm?cus_id=". base64_url_encode($iti->customer_id) . "&iti_id=" . base64_url_encode($iti_id) . "&token_key=" . ($iti->temp_key)  . "&status=" . base64_url_encode(8)) . " class='btn btn-info' >Postpone</a>";
   		
   		$mail_html .= "<a title='Click to Decline' href=" . site_url("confirm?cus_id=". base64_url_encode($iti->customer_id) . "&iti_id=" . base64_url_encode($iti_id) . "&token_key=" . ($iti->temp_key)  . "&status=" . base64_url_encode(7) ). " class='btn btn-danger' >Decline</a></div>";
   	
   	$mail_html .= "<hr>";
   	$disclaimer = htmlspecialchars_decode($terms->disclaimer_content);
   	$mail_html .=  "<br><strong>Disclaimer: </strong> {$disclaimer}"; */
   	
   	$mail_html .= "<p class='text-center'><a title='View' href=" . site_url("promotion/itinerary/{$iti->iti_id}/{$iti->temp_key}") . " class='btn btn-success' >Click here to view itinerary</a></p>";
   	
   	$mail_html .=' </div></div></body></html>';
   	//print mail_html
   	echo $mail_html;
   }
   ?>