<link href="https://fonts.googleapis.com/css?family=Roboto:400,700" rel="stylesheet">
		<?php $hotel_book = $hotel_booking[0];  
		if($hotel_book){ 
		
			//Get Agent Info
			$agent_id = $hotel_book->agent_id;
			$user_info = get_user_info($agent_id);
			$agent 			= !empty( $user_info ) ? $user_info[0] : "";
			$agent_fullName	= !empty($user_info) ? $agent->first_name . " " . $agent->last_name : "";
			$agent_number	= !empty($user_info) ? $agent->mobile: "";
			$agent_email 	= !empty($user_info) ? $agent->email: "";
			$agent_timing	= !empty($user_info) ? $agent->in_time . " To " . $agent->out_time: "";
			$website		= !empty($user_info) ? $agent->website: "";
			
			$mail_html = "";
			$mail_html .= "<html><head>
				<style>
				body{font-family: 'Roboto', sans-serif; color:#555555;}
				.response_btn { text-align: center;
					clear: both;
					margin: 10px 0 20px;
					display: block;
					overflow: hidden; }
				.hotel-details td{vertical-align:top;}
					h1 {
					font-family: 'Roboto', sans-serif;
					text-align: center;
					color: #ffffff;
					font-size: 22px;
					background: #140046;
					padding: 20px 0;
					border-top: 1px solid #2c0094;
					margin-bottom: 10px;
					margin-top: 0;
					
				}
					
				h1 strong {
					color: #ffffff;
				}
								
				.regards{padding: 15px;background: #364150;    color: #fff;     margin-top: 26px;}
				.regards strong { min-width: 85px;    display: inline-block;    margin-bottom: 3px;}
				
				.btn {
					background-color: #4CAF50;
					border: none;
					border-radius: 5px;
					color: white;
					padding: 10px 20px;
					text-align: center;
					text-decoration: none;
					display: inline-block;
					font-size: 16px;
					margin: 10px 10px;
					cursor: pointer;
				}
				.btn:hover{box-shadow: 0 0 15px rgba(0, 0, 0, 0.38);    transform: translateY(1px);}
				.btn.btn-info{background-color: blue;}
				.btn.btn-danger{background-color: red;}
				.response_btn {text-align: center;
					clear: both;
					margin: 10px 0 20px;
					display: block;
					overflow: hidden;}
				
				.mail-container {
					max-width: 980px;
					margin: 0 auto;
					border: 1px solid #281557;
					padding: 0;
					background: #fff;
					box-shadow: 1px 5px 20px 0px rgba(0, 0, 0, 0.76);
					margin-bottom: 50px;
					
				}
								 
				strong.regards-text {
					font-size: 20px;
					font-weight: 500;
					margin-bottom: 18px;
				}
				 .room-details strong {
						display: block;
						width: 20%;
						float: left;
						padding: 5px 15px;
						margin-bottom: 2px;
					}
		
			.info {
				background: #f9f9f9;
				float: right;
				display: block;
				width: 70%;
				padding: 5px 15px;
				margin-bottom: 2px;
			}
			
			.greetingtext {
				padding: 10px 15px;
			}
			
			.regards a {
				color: #fff;
			}

			.room-details {
				padding: 0px 15px;
			}

			p {
				margin: 0;
				margin-bottom: 10px;
			}

			.mail-logo img {
				max-width: 400px;
			}

			h3 {
				text-align: center;
				margin-bottom: 5px;
				color: #ffffff;
				border-bottom: 1px solid #d2d2d2;
				padding: 10px;
				margin-top: 0;
				background: #140046;
				font-weight: 600;
			}

		.mail-logo {
			background: #1a0256;
			text-align: center;
			padding: 20px 0;
			border-bottom: 1px solid #11003c;
			background: #000000;
			text-align: center;
			padding: 20px 0;
			border-bottom: 1px solid #11003c;
			background-image: url(https://images.trvl-media.com/hotels/2000000/1710000/1709400/1709339/468cda6e_z.jpg);
			background-size: cover;
			background-position: 100%;
		}
		.clearfix{display: block !important;clear:both !important; overflow: hidden !important; }		
		
</style>
</head><body>	<div class='mail-container'>";
			$logo_url = base_url() . "site/images/trackv2-logo.png";
	$mail_html .= "<div class='mail-logo'><img src='{$logo_url }'></div>";
				
		 	$hotel_name = get_hotel_name($hotel_book->hotel_id);
			$mail_html .= "<h1><strong> Hotel Name: </strong> {$hotel_name}"."</h1>";
			if( !empty( $hotel_book->check_in ) && !empty($hotel_book->check_out) ){	
				$check_in =  $hotel_book->check_in; 
				$check_out =  $hotel_book->check_out;
				$date1 = new DateTime($check_in);
				$t_date2 =  new DateTime($check_out);
				$total_days =  $t_date2->diff($date1)->format("%a"); 
				$total_days = $total_days+1;
				if($total_days <= 1){
					$duration =  "Single Day";
				}else{
					$nights = $total_days - 1;
					$duration =  $nights . " Nights and " . $total_days . " Days";
					
				}
			}else{
				$duration =  "";
				$nights ="";
			}
			
			/* Calculate total cost */
			$total_rooms = $hotel_book->total_rooms;
			$room_rate = $hotel_book->room_cost;
			$total_room_cost_pernight = $total_rooms * $room_rate;
			$extra_bed = $hotel_book->extra_bed;
			$extra_bed_cost 	= !empty($hotel_book->extra_bed_cost) ? $hotel_book->extra_bed_cost : 0;
			$extra_bed_cost_per_night = $extra_bed * $extra_bed_cost;
			$total_cost_rooms = $extra_bed_cost_per_night + $total_room_cost_pernight;
			$inclusion_cost = $hotel_book->inclusion_cost;
			$hotel_tax 			= $hotel_book->hotel_tax;
			$total_cost = number_format($hotel_book->total_cost);
			$total_rc = number_format($total_room_cost_pernight);
			$tc_rooms = number_format($total_cost_rooms * $nights);
			
			//Html
			$client_name = get_customer_name($hotel_book->customer_id);
			$mail_html .= "<div class='greetingtext'><span>Dear Sir/Madam,</span>"; 
			$mail_html .= "<p>Greetings From '<span style='font-weight:bold;'>trackitinerary Pvt Ltd.</span>' !!</p>"; 
			$mail_html .= "<p style='font-weight: bold; font-size: 14px; text-align: left'>Kindly Cancel the below booking <span style='font-weight:bold;'>:-</span> </p></div>"; 
			$mail_html .= "<h3>Room Details</h3><div class='room-details'>"; 
			
			$mail_html .= "<strong>Invoice Id: </strong><div class='info'>{$hotel_book->invoice_id}</div>";
			$mail_html .= "<strong>Client Name: </strong><div class='info'>{$client_name}</div>";
			$total_tra = $hotel_book->total_travellers;
			 
			$mail_html .= "<strong>Number of adults: </strong><div class='info'> {$total_tra}</div>";
			$meal_plan_hotel = !empty($hotel_book->meal_plan) ? get_meal_plan_name($hotel_book->meal_plan) : "No";
			$mail_html .= "<strong>	Meal Plan: </strong><div class='info'>{$meal_plan_hotel}</div>";
			$room_cat = get_roomcat_name($hotel_book->room_type);
			$t_rooms = $hotel_book->total_rooms . " " . $room_cat;
			
			$mail_html .= "<strong>	Number of Rooms: </strong><div class='info'>{$t_rooms}</div> ";
			$mail_html .= "<strong>Duration: </strong><div class='info'>{$duration}</div>";
			$ck_in = display_month_name($hotel_book->check_in);
			$ck_out = display_month_name($hotel_book->check_out);
			$mail_html .= "<strong>Check In Date: </strong><div class='info'>{$ck_in}</div>";
			$mail_html .= "<strong>Check Out Date: </strong><div class='info'>{$ck_out}</div>";	
			
			$inclusion = $hotel_book->inclusion;
			if( !empty( $inclusion ) ){ 
				$mail_html .=  "<strong>Inclusion: </strong><div class='info'>{$inclusion}</div>";
			}
			
			
			$mail_html .= "<strong>Room Rate: </strong><div class='info'>{$room_rate} /-Per Night <span style='font-weight:700;color:blue;'>*</span> {$total_rooms} = {$total_rc} ( room rate * total rooms ) </div>";
			
			if( $extra_bed > 0 ){ 
				$mail_html .= "<strong>Extra Bed Cost: </strong><div class='info'>{$extra_bed_cost} /-Per Night * {$extra_bed} = {$extra_bed_cost_per_night}</div>"; 
			}			
			
			$mail_html .= 
				"<strong>Total Nights: </strong><div class='info'>{$nights}</div>
				<strong>Total Rooms Costs: </strong><div class='info'>{$tc_rooms}</div>
				<strong>Inclusion Charges: </strong><div class='info'>{$inclusion_cost}</div>
				<strong>Hotel Tax: </strong><div class='info'>{$hotel_tax}</div>
				<strong>Total Cost: </strong><div class='info'>{$total_cost} /-</div>
				<div><br></div>
				<div class='clearfix'>Looking forward to hear from you for fruitful relationship, if any assistance or clarification is required, please feel free to <a href='mailto:{$agent_email}'>e-mail</a> or <a href='tel:{$agent_number}'> call.</a></div>
				<div>&nbsp;</div>";
				
				//Cancel Button
				$mail_html .= "<div class='response_btn'><a title='Click to Cancel Hotel Booking' href=" . site_url("confirm/cancel_hotel_booking?hotel_id=" . base64_url_encode($hotel_book->hotel_id) . "&iti_id=" . base64_url_encode($hotel_book->iti_id) . "&token_key=" . base64_url_encode($hotel_book->id)) . "class='btn btn-success' >Click here to confirm Cancellation</a>";
				
			//Agent Info
			$mail_html .= "<div class='regards'><strong class='regards-text'>Thanks & Regards</strong><br>";
			$mail_html .= "<strong class='name'> {$agent_fullName}</strong><br>";
			$mail_html .= "<strong>Call Us : </strong> {$agent_number} <br>";
			$mail_html .= "<strong>Email : </strong> <a href=mailto:'{$agent_email}' target='_blank'> {$agent_email}</a><br>";
			$mail_html .= "<strong>Timing : </strong> {$agent_timing}<br>";
			$mail_html .= "<strong>Website : </strong><a href='{$website}' target='_blank'> {$website}</div>";
			 
		$mail_html .=' </div></div></body></html>';
		echo $mail_html;	
	} ?>
</div> <!-- mail-container -->