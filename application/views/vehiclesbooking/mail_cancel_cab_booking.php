<link href="https://fonts.googleapis.com/css?family=Roboto:400,700" rel="stylesheet">
		<?php $cab_booking = $cab_booking[0];  
		if($cab_booking){
			//Get Agent Info
			$agent_id = $cab_booking->agent_id;
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
				
		 	$transporter_name = get_transporter_name($cab_booking->transporter_id);
			$mail_html .= "<h1><strong> Transporter Name: </strong> {$transporter_name}"."</h1>";
			
			//Html
			$client_name = get_customer_name($cab_booking->customer_id);
			$mail_html .= "<div class='greetingtext'><span>Dear Sir/Madam,</span>
				<p>Greetings From '<span style='font-weight:bold;'>trackitinerary Pvt Ltd.</span>' !!</p> 
				<p style='font-weight: bold; font-size: 14px; text-align: left'>Kindly Cancel the below booking <span style='font-weight:bold;'>:-</span> </p></div>
				<h3>Cab Details</h3><div class='room-details'> 
				<strong>Client Name: </strong><div class='info'>{$client_name}</div>";
			
			
			$cab 		= get_car_name($cab_booking->cab_id);
			$routing 	= $cab_booking->pic_location . " - " . $cab_booking->drop_location ;
			 
			$booking_date =  $cab_booking->picking_date . "( " . $cab_booking->reporting_time . " ) - " . $cab_booking->droping_date . " ( " . $cab_booking->departure_time  . " ) ";
			
			$mail_html .= "<strong>Number of Travelers: </strong><div class='info'> {$cab_booking->total_travellers}</div>
					<strong>Itinerary ID: </strong><div class='info'> {$cab_booking->iti_id}</div>
					<strong>Routing: </strong><div class='info'> {$routing}</div>
					<strong>Cab Name: </strong><div class='info'> {$cab}</div>
					<strong>Total Cabs: </strong><div class='info'> {$cab_booking->total_cabs}</div>
					<strong>Booking Duration: </strong><div class='info'> {$booking_date}</div>";
					
			$mail_html .= "
				<div class='clearfix'>Looking forward to hear from you for fruitful relationship, if any assistance or clarification is required, please feel free to <a href='mailto:{$agent_email}'>e-mail</a> or <a href='tel:{$agent_number}'> call.</a></div>
				<div>&nbsp;</div>";
				
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