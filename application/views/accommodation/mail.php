<link href="https://fonts.googleapis.com/css?family=Roboto:400,700" rel="stylesheet">
<?php
if( !empty($itinerary )){
$acc = $itinerary[0];
	$acc_id = $acc->iti_id;
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
		$get_customer_info = get_customer( $acc->customer_id ); 
		$cust = $get_customer_info[0];
		$customer_name = $cust->customer_name;
			
		
		$mail_html .= "<p style='margin-bottom:20px;'><strong>Hi, {$customer_name}</strong></p>";
		$mail_html .= '<h1 style="" >GREETINGS FROM trackitinerary</h1>';
		$mail_html .= "<p style='margin-bottom:20px;'>{$greeting}</p>";

 	$mail_html .= '<h1 style="" >Package Overview</h1>';
	$total_tra = "<strong> Adults: </strong> " . $acc->adults; 
	if( !empty( $acc->child ) ){
		$total_tra .= "  <strong> No. of Child: </strong> " . $acc->child; 
		$total_tra .= " (" . $acc->child_age .")"; 
	}
	
	$mail_html .= "
		<table cellspacing='0' cellpadding='8' border='0' width='100%' align='center'>
			<tr>
				<th style='background-color:#003367; color:#fff;'>Name of Package</th>
				<th style='background-color:#003367; color:#fff;'>Routing</th>
				<th style='background-color:#003367; color:#fff;'>No of Travelers</th>
			</tr>
			<tr>
				<td>{$acc->package_name}</td>
				<td>{$acc->package_routing}</td>
				<td>{$total_tra}</td>
			</tr>
			<tr>
				<th style='background-color:#003367; color:#fff;'>Tour Start Date</th>
				<th style='background-color:#003367; color:#fff;'>Tour End Date</th>
				<th style='background-color:#003367; color:#fff;'>Total Nights</th>
			</tr>
			<tr>
				<td>{$acc->t_start_date}</td>
				<td>{$acc->t_end_date}</td>
				<td>{$acc->total_nights}</td>				
			</tr>
		</table>";
	
	$mail_html .= "<p class='text-center'><a title='View' href=" . site_url("promotion/itinerary/{$acc->iti_id}/{$acc->temp_key}") . " class='btn btn-success' >Click here to view Accommodation Quotation</a></p>";
	
	$mail_html .=' </div></div></body></html>';
	//print mail_html
	echo $mail_html;
}
?>