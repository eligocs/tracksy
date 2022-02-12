<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Confirm extends CI_Controller {	
public function __Construct(){	   
	parent::__Construct();		
		$this->load->model("itinerary_model");
		$this->load->model("hotelbooking_model");
		$this->load->model("vehiclesbooking_model");	
		/* $this->load->library('session'); */	
		/* $this->load->library('email');	 */
		$this->load->helper('email');	
		$this->load->helper('path');	
	}
	public function index(){
		/* $user_id = $user['user_id']; */
		if(isset( $_GET['cus_id'] ) && !empty($_GET['iti_id']) && !empty( $_GET['token_key'] )  && !empty( $_GET['status'] ) ){
			$customer_id = base64_url_decode($_GET['cus_id']);
			$iti_id = base64_url_decode($_GET['iti_id']); 
			$temp_key = htmlentities($_GET['token_key']); 
			$status = base64_url_decode($_GET['status']);
			/* Status : 9 => "approve", 8 => "postpone", 7=> "decline" */	
			/* Check User Status */
			if( !empty($status) ){
				$where = array( "iti_id" => $iti_id, "customer_id" =>$customer_id , "temp_key" => $temp_key, 'del_status' => 0 );
				$status_id = $this->global_model->getdata("itinerary", $where , 'iti_status');
				if( $status_id ){
					echo "You Already Responde this itinerary. ";
					die();
				}
			}
			/* if Status is empty update itinerary status */
			if( !is_numeric( $customer_id ) && !is_numeric( $iti_id )){
				echo "Unauthorized User !";
				exit();
			}else{
				$data['sec_key'] = md5($this->config->item("encryption_key"));	
				$data['status']= $status;
				$data['itinerary_details'] = $this->itinerary_model->get_iti( trim($customer_id), trim($iti_id), $temp_key );
				$this->load->view('itineraries/status', $data);
			}
		}else{
			die( "Invalid Url" );
		}
	}
	/* Hotel Booking */
	public function hotelbooking(){
		/* $user_id = $user['user_id']; */
		if(isset( $_GET['hotel_id'] ) && !empty($_GET['iti_id']) && !empty( $_GET['token_key'] )  && !empty( $_GET['status'] ) ){
			$hotel_id = base64_url_decode($_GET['hotel_id']);
			$iti_id = base64_url_decode($_GET['iti_id']); 
			$booking_id = base64_url_decode($_GET['token_key']); 
			$status = base64_url_decode($_GET['status']);
			/* Status : 9 => "approve", 8 => "postpone", 7=> "decline" */	
			/* Check User Status*/
			if( !empty($status) ){
				$where = array( "iti_id" => $iti_id, "hotel_id" =>$hotel_id , "id" => $booking_id, 'del_status' => 0 );
				$status_id = $this->global_model->getdata("hotel_booking", $where , 'booking_status');
				if( $status_id ){
					echo "You Already Responde this Booking. ";
					die();
				}
			}
			/* if Status is empty update Booking status */
			if( !is_numeric( $hotel_id ) && !is_numeric( $iti_id )){
				echo "Unauthorized User !";
				exit();
			}else{
				$data['sec_key'] = md5($this->config->item("encryption_key"));	
				$data['status']= $status;
				$where = array( 'id' => $booking_id, 'iti_id' => $iti_id, 'hotel_id' => $hotel_id, 'del_status' => 0 );
				$data['booking_details'] = $this->global_model->getdata('hotel_booking', $where );
				$this->load->view('hotelbooking/status', $data);
			}
		}else{
			die( "Invalid Url" );
		}
	}
	
	/* Cancel Hotel Booking Email */
	public function cancel_hotel_booking(){
		/* $user_id = $user['user_id']; */
		if(isset( $_GET['hotel_id'] ) && !empty($_GET['iti_id']) && !empty( $_GET['token_key'] ) ){
			$hotel_id = base64_url_decode($_GET['hotel_id']);
			$iti_id = base64_url_decode($_GET['iti_id']); 
			$booking_id = base64_url_decode($_GET['token_key']); 
			
			/* Status : 9 => "approve", 8 => "postpone", 7=> "decline" */	
			/* Check User Status*/
			$where = array( "id" => $booking_id );
			$status_id = $this->global_model->getdata("hotel_booking", $where , 'hotel_cancel_booking_note');
			if( $status_id ){
				echo "You Already confirm cancellation for this Booking.";
				die();
			}
			/* if Status is empty update Booking status */
			if( !is_numeric( $hotel_id ) && !is_numeric( $iti_id )){
				echo "Unauthorized User !";
				exit();
			}else{
				$data['sec_key'] = md5($this->config->item("encryption_key"));	
				$where = array( 'id' => $booking_id, 'iti_id' => $iti_id, 'del_status' => 0 );
				$data['booking_details'] = $this->global_model->getdata('hotel_booking', $where );
				$this->load->view('hotelbooking/cancel_booking_status', $data);
			}
		}else{
			die( "Invalid Url" );
		}
	}
	
	//update cancellation note by hotel 
	public function ajax_update_cancel_note_by_hotel(){
		$id = $this->input->post('id');	
		$cancel_note = strip_tags($this->input->post('cancellation_note'));	
		if( empty($id) && !is_numeric($id) ){
			$res = array('status' => false, 'msg' => "Failed! Please try again later.");
			die(json_encode($res));
		}else{
			$data = array("hotel_cancel_booking_note" => $cancel_note );
			$where = array("id" => $id);
			$result = $this->global_model->update_data("hotel_booking", $where, $data);
			if( $result ){
				//get data
				$hotel_bookings = $this->global_model->getdata( 'hotel_booking', $where );
				$hotel_book = $hotel_bookings[0];
				//Sent mail to hotel booking team
				$hotel = get_hotel_name( $hotel_book->hotel_id );
				$hotel_booking_email = hotel_booking_email();
				
				$subject   = "Hotel Booking Cancellation is confirmed by hotel < Invoice Id: {$hotel_book->invoice_id} >";
				$message   = "Hotel Booking cancellation is confirmed by hotel. <br>";
				$message   .= "Hotel Name: {$hotel} <br>";
				$message   .= "Iti Id: {$hotel_book->iti_id} <br>";
				$message   .= "Invoice Id: {$hotel_book->invoice_id} <br>";
				$message   .= "Message: {$cancel_note} <br>";
				$from 	   = hotel_booking_email();
				$sent_mail = sendEmail($hotel_booking_email, $subject, $message, $bcc="", $cc="", $from); 
			
				$this->session->set_flashdata('success',"Hotel Booking Cancel Confirm successfully.");
				$res = array('status' => true, 'msg' => "Hotel Booking Update Confirm successfully!");
			}else{
				$res = array('status' => false, 'msg' => "Failed! Please try again later.");
			}
			die(json_encode($res));
		}
	}
	
	/* cabbooking */
	public function cabbooking(){
		if(isset( $_GET['booking_id'] ) && !empty($_GET['iti_id']) && !empty( $_GET['status'] ) ){
			$booking_id = base64_url_decode($_GET['booking_id']);
			$iti_id = base64_url_decode($_GET['iti_id']); 
			$status = base64_url_decode($_GET['status']);
			/* Status : 9 => "approve", 8 => "postpone", 7=> "decline" */	
			/* Check User Status*/
			if( !empty($status) ){
				$where = array( "iti_id" => $iti_id, "id" => $booking_id, 'del_status' => 0 );
				$status_id = $this->global_model->getdata("cab_booking", $where , 'booking_status');
				if( $status_id ){
					echo "You Already Response this Booking. ";
					die();
				}
			}
			/* if Status is empty update Booking status */
			if( !is_numeric( $booking_id ) && !is_numeric( $iti_id )){
				echo "Unauthorized User !";
				die();
			}else{
				$data['sec_key'] = md5($this->config->item("encryption_key"));	
				$data['status']= $status;
				$where = array( 'id' => $booking_id, 'iti_id' => $iti_id, 'del_status' => 0 );
				$data['booking_details'] = $this->global_model->getdata('cab_booking', $where );
				$this->load->view('vehiclesbooking/status', $data);
			}
		}else{
			die( "Invalid Url" );
		}
	}
	
	public function thankyou(){
		if( isset($_GET['key']) ){
			$sec_key = md5($this->config->item("encryption_key"));
			$key = $_GET['key'];
			if( $sec_key == $key ){
				$this->load->view('thankyou'); 
			}else{
				die( "Invalid Url" );
			} 
		}else{
			die( "Invalid Url" );
		}
	}
	
	
	/************* AJAX REQUEST ****************/
	//update Itinerary Status
	public function update_itinerary_status(){
		$iti_id = strip_tags($this->input->post('iti_id'));
		$temp_key = strip_tags($this->input->post('temp_key'));
		$customer_id = strip_tags($this->input->post('customer_id'));
		$iti_status = strip_tags($this->input->post('iti_status'));
		$sec_key = $this->input->post('sec_key');
		$enc_key = md5( $this->config->item("encryption_key") );
		
		if( $sec_key !==  $enc_key  ){
			$res = array('status' => false, 'msg' => "Security Error! ");
			die(json_encode($res));
		}
		
		if( !empty($customer_id) && !empty($iti_id) ){
			if( !is_numeric( $iti_id ) && !is_numeric( $customer_id ) && !is_numeric( $iti_status ) ){
				$res = array('status' => false, 'msg' => "Invalid Request!");
				die(json_encode($res));
			}else{				
				$result = $this->itinerary_model->update_itinerary_status( $iti_id, $customer_id, $temp_key);
				if( $result){
					/* Send itinerary confirm email to admin , manager & client */
					$where_iti = array( "iti_id" => $iti_id );
					$get_agent_id = $this->global_model->getdata( "itinerary", $where_iti, "agent_id");
					$where_user = array("user_id" => $get_agent_id );
					$u_email = $this->global_model->getdata( "users", $where_user, "email");
					$user_email = $u_email ? $u_email : "sales@Trackitinerary.com";
					/* Get Customer Information */
					$cust_info = get_customer( $customer_id );
					$customer_info = $cust_info[0];
					$customer_name = $customer_info->customer_name;
					$customer_contact = $customer_info->customer_contact;
					$customer_email = $customer_info->customer_email;	
					//$admin_email   = admin_email(); 			
					$manager_email = manager_email();			
					$service_team = sales_team_email();	
					$hotel_booking_email = hotel_booking_email();
					$admin_emails_list = array($manager_email, $service_team,$hotel_booking_email, $user_email);	
					$from =  "no-reply@Trackitinerary.com";	
					$msg = "";					
					if( $iti_status == 9 ){		
						/* customer message	*/
						$customer_subject = "Thankyou for confirm itinearary<Trackitinerary>";		
						$customer_message = "Thankyou for your confirmation against itinerary id: {$iti_id}.";	
							/* admin message */
						$subject = "{$iti_id} Itinerary has been approved";		
						$msg .= "Itinerary approved by customer. Please check the itinerary details in dashboard.<br/>";			
						$msg .= "Itinerary ID: {$iti_id}<br/>";			
						$msg .= "Client Name: {$customer_name}<br/>";	
						
					}elseif($iti_status == 8){			
						/* customer message	*/					
						$customer_subject = "Thankyou for your response<Trackitinerary>";			
						$customer_message = "Thankyou for your confirmation against itinerary id: {$iti_id}.";		
						/* admin message */
						$subject = "{$iti_id} Itinerary has been postponed";
						$msg .= "Itinerary postponed by customer. Please check the itinerary details in dashboard.<br/>";
						$msg .= "Itinerary ID: {$iti_id}<br/>";			
						$msg .= "Client Name: {$customer_name}<br/>";	
					/* For Decline	*/
					}elseif($iti_status == 7){	
					/* customer message	*/
						$customer_subject = "Thankyou for your response<Trackitinerary>";		
						$customer_message = "Thankyou for your confirmation against itinerary id: {$iti_id}.";	
						/* admin message */
						$subject = "{$iti_id} Itinerary has been declined";			
						$msg .= "Itinerary declined by customer. Please check the itinerary details in dashboard.<br/>";		
						$msg .= "Itinerary ID: {$iti_id}<br/>";					
						$msg .= "Client Name: {$customer_name}<br/>";				
					} 
					
					/* send msg for customer on Itinerary Responde */
					$mobile_customer_sms = "Dear {$customer_name}, Thanks For your response.Confirmation mail send to your email <{$customer_email}> .If you not find in inbox please check in spam or contact us. Thanks <Trackitinerary Pvt Ltd.>";
					$cus_mobile = "{$customer_contact}";
					if( !empty( $cus_mobile ) ){
						$sendcustomer_sms = pm_send_sms( $cus_mobile, $mobile_customer_sms );
					}
					$this->email->clear();
					/* Send Admin Email */
					$this->email		
					->from($from, 'trackitinerary Pvt. Ltd.')	
					->to( $admin_emails_list )				
					->subject( $subject )				
					->message( $msg )			
					->set_mailtype('html')		
					->send(); 	
					
					/* Send Customer Email	*/
					$this->email		
					->from($from, 'trackitinerary Pvt. Ltd.')			
					->to( $customer_email )			
					->subject( $customer_subject )	
					->message( $customer_message )	
					->set_mailtype('html')		
					->send();  
					
					/* send response to user */	
					$res = array('status' => true, 'msg' => "Successfully Submited! ");
				}else{
					$res = array('status' => false, 'msg' => "Error! Please Try again! ");
				}
				die(json_encode($res));
			}
		}else{
			$res = array('status' => false, 'msg' => "Invalid Url. ");
			die(json_encode($res));
		}	
	}
	
	
	// update_hotel_booking_status  
	public function update_hotel_booking_status(){
		$iti_id = strip_tags($this->input->post('iti_id'));
		$id = strip_tags($this->input->post('id'));
		$hotel_id = strip_tags($this->input->post('hotel_id'));
		$booking_status = strip_tags($this->input->post('booking_status'));
		$sec_key = $this->input->post('sec_key');
		$booking_note = strip_tags($this->input->post('booking_note'));
		$enc_key = md5( $this->config->item("encryption_key") );
		if( $sec_key !==  $enc_key  ){
			$res = array('status' => false, 'msg' => "Security Error! ");
			die(json_encode($res));
		}
		
		if( !empty($hotel_id) && !empty($iti_id) ){
			if( !is_numeric( $iti_id ) && !is_numeric( $hotel_id ) && !is_numeric( $booking_status ) ){
				$res = array('status' => false, 'msg' => "Invalid Request!");
				die(json_encode($res));
			}else{	
				$result = $this->hotelbooking_model->update_booking_status( $iti_id, $hotel_id, $id);
				if( $result){
					/* Send Hotel confirm email to admin , manager & client */
					/* //Get Hotel Information */
					$htl_info = get_hotel_details($hotel_id);;
					$hotel_info = $htl_info[0];
					$hotel_name = $hotel_info->hotel_name;
					$hotel_emails = array($hotel_info->hotel_email);
					/* get admin,manager and salesteam email ids */
					$hotel_team_email = hotel_booking_email();	
					$admin_emails_list = array($hotel_team_email);
					
		
					//get message template
					$where = array( 'id' => $id );
					$data['hotel_booking'] = $this->global_model->getdata( 'hotel_booking', $where );
					$data['show_approved_btn'] = false;
					$data['booking_note'] = $booking_note;
					
					$msg = $this->load->view("hotelbooking/mail", $data, TRUE);
					
					if( $booking_status == 9 ){		
						/* customer message	*/
						$hotel_subject = "Thanks for confirmation with <Itinerary id: {$iti_id} > <Trackitinerary>";		
						$hotel_msg = "Thanks for your booking confirmation with itinerary id: {$iti_id}.";	
						$subject = "{$iti_id} Hotel Booking has been approved <Hotel Name: {$hotel_name} >.";		
						/* send msg for hotel on hotel booking Responde */
						$mobile_hotel_sms = "{$hotel_name}, Thanks for the booking confirmation with itinearary Id: {$iti_id}. Please check your email. <Trackitinerary Pvt Ltd.>";							
					/* For Decline	*/
					}elseif( $booking_status == 8 ){	
						/* customer message	*/					
						$hotel_subject = "Thanks for your response  <Trackitinerary>";		
						$hotel_msg = "Thankyou for your confirmation against itinerary id: {$iti_id}.";		
						$subject = "{$iti_id} Hotel Booking has been declined <Hotel Name: {$hotel_name} >.";
						/* send msg for hotel on hotel booking Responde */
						$mobile_hotel_sms = "{$hotel_name}, Thanks for your response with itinearary Id: {$iti_id}. Please check your email.<Trackitinerary Pvt Ltd.>";						
					}
					$hotel_contact = "{$hotel_info->hotel_contact}";
					if( !empty( $hotel_contact ) ){
						$sendcustomer_sms = pm_send_sms( $hotel_contact, $mobile_hotel_sms );
					}
					
					$from = $hotel_team_email;
					//sent mail 
					$sent_mailAdmn = sendEmail($admin_emails_list, $subject, $msg, $bcc="", $cc="", $from );	
					$sent_mailHotel = sendEmail($hotel_emails, $hotel_subject, $hotel_msg, $bcc="", $cc="", $from );					
					
					$res = array('status' => true, 'msg' => "Successfully Submited! ");
				}else{
					$res = array('status' => false, 'msg' => "Error! Please Try again!");
				}
				die(json_encode($res)); 
			}
		}else{
			$res = array('status' => false, 'msg' => "Error! Invalid Url.");
			die(json_encode($res));
		}	
	}
	/* update_cab_booking_status  */
	public function update_cab_booking_status(){
		$iti_id = strip_tags($this->input->post('iti_id'));
		$id = strip_tags($this->input->post('id'));
		$booking_status = strip_tags($this->input->post('booking_status'));
		$sec_key = $this->input->post('sec_key');
		$enc_key = md5( $this->config->item("encryption_key") );
		if( $sec_key !==  $enc_key  ){
			$res = array('status' => false, 'msg' => "Security Error! ");
			die(json_encode($res));
		}
		
		if( !empty($id) && !empty($iti_id) ){
			if( !is_numeric( $iti_id ) && !is_numeric( $id ) && !is_numeric( $booking_status ) ){
				$res = array('status' => false, 'msg' => "Invalid Request!");
				die(json_encode($res));
			}else{	
				$result = $this->vehiclesbooking_model->update_booking_status( $id, $iti_id);
				if( $result){
					/* Send Cab confirm email to admin , manager & client */
					/* Get transporter Details */
					$where = array( 'id' => $id, 'del_status' => 0 );
					$cab_booking = $this->global_model->getdata( 'cab_booking', $where );
					$cab_book = $cab_booking[0];
					/* //Get Transporter Information */
					$transporter = get_transporter_details( $cab_book->transporter_id );
					$tran_name = get_transporter_name($cab_book->transporter_id);
					if( !empty( $transporter ) ){
						$trans = $transporter[0];
						$trans_email = $trans->trans_email;
						$trans_contact = $trans->trans_contact;
					}else{
						$trans_email = "";
						$trans_contact = "";
					}
					
					/* send msg for transporter on confirmation vehicle booking */
					$transporter_contact = "{$trans_contact}";
					$transporter_email = $trans_email;
					$transporter_name = $tran_name;
					$mobile_transporter_sms = "Dear {$transporter_name}, Thanks for your confirmation. Email sent to your email id {$transporter_email}. If you not recieve email in your inbox please find the mail in spam. Thanks <Trackitinerary Pvt Ltd.>";
					if( !empty( $transporter_contact ) ){
						$sendtras_sms = pm_send_sms( $transporter_contact, $mobile_transporter_sms );
					}
					/* get admin,manager and salesteam email ids */
					//$admin_email   = admin_email(); 			
					$manager_email = manager_email();			
					$vehicle_booking_team_email = vehicle_booking_email();	
					$admin_emails_list = array($manager_email, $vehicle_booking_team_email);	
					
					$from =  "sales@Trackitinerary.com";			
					$msg = "";					
					if( $booking_status == 9 ){		
						/* customer message	*/
						$trans_sub = "Thankyou <Trackitinerary>";		
						$trans_msg = "Thankyou for your confirmation against itinerary id: {$iti_id}.";	
						/* admin message */
						$subject = "<Trackitinerary> Vehicle Booking has been approved < Transporter Name: {$tran_name} >.";		
						$msg .= "Vehicle booking approved by transporter. Please check the vehicle booking details in dashboard.<br/>";			
						$msg .= "Itinerary ID: {$iti_id}<br/>";			
						$msg .= "Transporter Name: {$tran_name}<br/>";			
					/* For Decline	*/
					}elseif($booking_status == 8){
						/* customer message	*/					
						$trans_sub = "Thankyou <Trackitinerary>";			
						$trans_msg = "Thankyou for your confirmation against itinerary id: {$iti_id}.";		
						/* admin message */
						$subject = "<Trackitinerary> Vehicle Booking has been declined < Transporter Name: {$tran_name} >.";
						$msg .= "Vehicle Booking has been declined by transporter. Please check the hotel booking details in dashboard.<br/>";
						$msg .= "Itinerary ID: {$iti_id}<br/>";	
						$msg .= "Transporter Name: {$tran_name}<br/>";					
					}
					$this->email->clear();
					/* Send Admin Email */
					$this->email		
					->from($from, 'trackitinerary Pvt. Ltd.')	
					->to( $admin_emails_list )				
					->subject( $subject )				
					->message( $msg )			
					->set_mailtype('html')		
					->send(); 				
					/* Send Transporter Email	*/
					$this->email		
					->from($from, 'trackitinerary Pvt. Ltd.')			
					->to( $trans_email )			
					->subject( $trans_sub )	
					->message( $trans_msg )	
					->set_mailtype('html')		
					->send();  
					/* Send response */	
					$res = array('status' => true, 'msg' => "Successfully Submitted! ");
				}else{
					$res = array('status' => false, 'msg' => "Error! Please Try again!");
				}
				die(json_encode($res)); 
			}
		}else{
			$res = array('status' => false, 'msg' => "Error! Invalid Url!");
			die(json_encode($res)); 
		}	
	}
}	

?>