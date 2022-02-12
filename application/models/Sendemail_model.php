<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sendemail_Model extends CI_Model 
{
    function __construct(){
        parent::__construct();
		$this->load->library('email');
	}
	
	// Send Itinerary email to Customer
	/* public function senditinerarymail($iti_id, $temp_key){
		
		
		$name = $user->firstname.' '.$user->lastname;
		$to = $user->emailid;
		$subject = "Reminder For Article Payment";
		
		$articlename = $articleq->product_type;
		
		$message = '<p>Hello '.$name.',<br/>
					Greetings for the day!<br/><br/>
					This email comes in to remind you about payment for article, which is still pending with you. Please clear it asap so that we could release the pledged amount to the publisher.<br/><br/>
					Click here to <a href="'.base_url().'/paypal/paynow/'.$id.'">Paynow</a><br/><br/>
					Best Regards<br/>
					Dr Prem Network Team.</p>';					
		
		$from = "no-reply@drprem.com";
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= "From: Support Team <" . $from. ">\r\n";
		@mail($to,$subject,$message,$headers);
		
		return true;
		
	} */
}
?>