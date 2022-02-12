<link href="https://fonts.googleapis.com/css?family=Roboto:400,700" rel="stylesheet">
		<?php $cab_booking = $cab_booking[0];  
		if($cab_booking){ 
			$mail_html = "";
			$mail_html .= "<html><head>
				<style>
				body{font-family: 'Roboto', sans-serif; color:#555555;}
				.hotel-details td{vertical-align:top;}
				h1{         font-family: 'Roboto', sans-serif;
					text-align: center;
					color: #3598dc;
					font-size: 22px;
					background: #364150;
					padding: 20px 0;
					border-top: 1px dashed #ffffff;
					margin-bottom: 10px;
					margin-top: 0;}
				h1 strong {
					color: #ffffff;
				}
								
				.regards{padding: 20px;background: #364150;    color: #fff;     margin-top: 26px;}
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
					border: 10px solid #3598dc;
					padding: 0;
				}
				hr { border-top: 1px dashed #000; background: #fff;}
				strong.regards-text {
					font-size: 20px;
					font-weight: 500;
					margin-bottom: 18px;
				}
			.table strong {
				display: block;
				width: 40%;
				float: left;
				min-height: 25px;
				padding: 5px 0 0;
				margin: 2px 0;
			}
			.info {
			    background: #f9f9f9;
				float: left;
				display: block;
				width: 57%;
				min-height: 25px;
				padding: 5px 0 0 3%;
				margin: 2px 0;
				border-bottom: 1px solid #e4e4e4;
			}
			.greetingtext {
				padding: 10px 20px 0;
			}

h3 {text-align: center;
    margin-bottom: 5px;
    /* background: #f9f9f9; */
    color: #7b62d6;
    border-bottom: 1px solid #d2d2d2;
    padding: 10px;
}
.table {padding: 0 25px;}
.mail-logo {background: #364150;  text-align: center;    padding: 20px 0;}
				</style></head><body>	<div class='mail-container'>";
			$logo_url = base_url() . "site/images/trackv2-logo.png";
	$mail_html .= "<div class='mail-logo'><img src='{$logo_url }'></div>";
				
		 	$tran_name = get_transporter_name($cab_booking->transporter_id);
			$mail_html .= "<h1><strong> Transporter Name: </strong> <br>{$tran_name}"."</h1>";
		
			$client_name = get_customer_name($cab_booking->customer_id);
			$mail_html .= "<div class='greetingtext'><span>Dear Sir/Madam,</span>"; 
			$mail_html .= "<p>Greetings From '<span style='font-weight:bold;'>trackitinerary Pvt Ltd.</span>' !!</p>"; 
			$mail_html .= "<p style='font-weight: bold; font-size: 20px; text-align: left'>Kindly confirm the below booking <span style='font-weight:bold;'>:-</span> </p></div>"; 
			$mail_html .= "<h3>Booking Details</h3><div class='table'>"; 
			$mail_html .= "<strong>Client Name: </strong><div class='info'>{$client_name}</div>";
			$total_tra = $cab_booking->total_travellers;
				$mail_html .= "<strong>Number of Travelers: </strong><div class='info'> {$total_tra}</div>";
				
				$picking_date = $cab_booking->picking_date;
				$droping_date = $cab_booking->droping_date;
				$reporting_time = $cab_booking->reporting_time;
				$cab_cat = get_car_name($cab_booking->cab_id);
				$duration =  $cab_booking->booking_duration;
				/* Calculate total cost */
				$total_cabs = $cab_booking->total_cabs;
				$cab_rate = $cab_booking->cab_rate;;
				$total_cab_cost_perday = $total_cabs * $cab_rate;
				$inclusion_cost = $cab_booking->extra_charges;
				$total_cost = number_format($cab_booking->total_cost);
				
			$mail_html .= "<strong>Cab Category: </strong><div class='info'>{$cab_cat}</div>";
			$mail_html .= "<strong>	Booking Date: </strong><div class='info'>{$picking_date} - {$droping_date}</div> ";
			$mail_html .= "<strong>	Picking Location: </strong><div class='info'>{$cab_booking->pic_location}</div> ";
			$mail_html .= "<strong>	Droping Location: </strong><div class='info'>{$cab_booking->drop_location}</div> ";
			
			$mail_html .= "<strong>Reporting Time: </strong><div class='info'>{$reporting_time}</div>";
			$mail_html .= "<strong>Duration: </strong><div class='info'>{$duration}</div>";
			$mail_html .= "<strong>Total Cabs: </strong><div class='info'>{$cab_booking->total_cabs}</div>";
			
			// Calculate total cost 
			$total_cabs = $cab_booking->total_cabs;
			$cab_rate = $cab_booking->cab_rate;;
			$total_cab_cost_perday = $total_cabs * $cab_rate;
			$inclusion_cost = $cab_booking->extra_charges;
			$total_cost = number_format($cab_booking->total_cost);
			
			$mail_html .= "<strong>Cab Rate (Per day): </strong><div class='info'>{$cab_rate}<span style='font-weight:700;color:blue;'> *</span> {$total_cabs} = {$total_cab_cost_perday} ( cab perday cost * total cabs)</div>";
			$mail_html .= "<strong>Inclusion Charges: </strong><div class='info'>{$inclusion_cost}</div>";
			$mail_html .= "<strong>Total Cost: </strong><div class='info'>{$total_cost}/- ( total cabs cost * Duration + inclusion )</div>";
			$mail_html .= "<div>&nbsp;</div>";
			$mail_html .= "<div class=''>Looking forward to hear from you for fruitful relationship, if any assistance or clarification is required, please feel free to e-mail or call.</div>";
			$mail_html .= "<div>&nbsp;</div>";
			
			
			//Button section
			$mail_html .= "<div class='response_btn'><a title='Click to Approve Cab Booking' href=" . site_url("confirm/cabbooking?booking_id=". base64_url_encode($cab_booking->id) . "&iti_id=" . base64_url_encode($cab_booking->iti_id) . "&status=" . base64_url_encode(9) ) . " class='btn btn-success' >Confirm</a>";
			$mail_html .=  "<a title='Click to Decline' href=" . site_url("confirm/cabbooking?booking_id=". base64_url_encode($cab_booking->id) . "&iti_id=" . base64_url_encode($cab_booking->iti_id) . "&status=" . base64_url_encode(8)) . " class='btn btn-danger' >Decline</a></div></div>";
			
			$mail_html .= "<hr>";
	
			$agent_id = $cab_booking->agent_id;
			$user_info = get_user_info($agent_id);
			if($user_info){
				$agent = $user_info[0];
				$mail_html .= "<div class='regards'><strong class='regards-text'>Thanks & Regards</strong><br>";
				$mail_html .= "<strong class='name'> {$agent->first_name} {$agent->last_name}</strong><br>";
				$mail_html .= "<strong>Call Us : </strong> {$agent->mobile} <br>";
				$mail_html .= "<strong>Email : </strong> {$agent->email}<br>";
				$mail_html .= "<strong>Timing : </strong> {$agent->in_time} To {$agent->out_time}<br>";
				$mail_html .= "<strong>Website : </strong> {$agent->website}</div>";
			}  
		$mail_html .=' </div></div></body></html>';
		echo $mail_html;	
	} ?>
</div> <!-- mail-container -->