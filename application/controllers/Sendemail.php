<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sendemail extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		validate_login();
		$this->load->model('sendemail_model');
		$this->load->helper('email');
		$this->load->helper('path');
	}
	/* //Sent Hotel Booking Email */
	public function senthotelbooking(){
		$id = $this->input->post("id", true);
		$hotel_id = $this->input->post("hotel_id", true);
		//$id = 2;
		//$hotel_id = 516;
		
		$user = $this->session->userdata('logged_in');
		$user_id = $user['user_id'];
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '97'){
			/* //check if empty id and hotel id */
			if( empty($id) && empty($hotel_id)  ){
				$res = array('status' => false, 'msg' => "Invalid Id.");
				die( json_encode($res) );
			}
			
			$where = array( 'id' => $id , 'hotel_id' => $hotel_id );
			$hotel_bookings = $this->global_model->getdata( 'hotel_booking', $where );
			$data['hotel_booking'] = $hotel_bookings;
			$hotel_book = $hotel_bookings[0];
			$booking_id = $hotel_book->id;
			$iti_id = $hotel_book->iti_id;
			/* // Get Customer Information */
			$cust_info = get_customer($hotel_book->customer_id);
			$customer_info = $cust_info[0];
			$customer_name = $customer_info->customer_name;
			$customer_contact = $customer_info->customer_contact;
			
			/* //Get Hotel Information */
			$htl_info = get_hotel_details($hotel_book->hotel_id);;
			$hotel_info = $htl_info[0];
			$hotel_name = $hotel_info->hotel_name;
			$hotel_emails = array($hotel_info->hotel_email);
			/* Check if hotel Email is empty */
			if( empty( $hotel_emails ) ){
				$res = array('status' => false, 'msg' => "Hotel Email Id Does Not Exists Or Invalid.");
				die( json_encode($res) );
			}
			
			/* //get message template */
			$message = $this->load->view("hotelbooking/mail", $data, TRUE);
			$subject = "Room Booking Confirmation Mail with <Itinerary id: {$iti_id} >"; 
			
			//echo $message;
			//die();
			/* Get admin emails */
			$admin_email = admin_email();
			$manager_email = manager_email();
			
			$bccEmails = array($admin_email, $manager_email);
			$sent_mail = sendEmail($hotel_emails, $subject, $message, $bccEmails);
			
			if( $sent_mail ){
				/* send msg for on Hotel booking */
				$hotel_email = $hotel_info->hotel_email;
				$mobile_hotelbooking_sms = "{$hotel_name}, Hotel booking email send to your email {$hotel_email}. If you not receive email in your inbox please find the mail in spam. Thanks <Trackitinerary Pvt Ltd.>";
				$hotel_mob = "{$hotel_info->hotel_contact}";
				if( !empty( $hotel_mob ) ){
					$sendhotel_sms = pm_send_sms( $hotel_mob, $mobile_hotelbooking_sms );
				}
		
				/* Get total email sent to current hotel bookin */
				$where = array( "id" => $booking_id );
				$count_email = $this->global_model->getdata( "hotel_booking", $where, "email_count" );
				if( empty($count_email) ){
					$count_email = 0;
				}
				$email_inc = $count_email+1;
				
				/* //update Email count status */
				$up_data = array(
					'email_count' => $email_inc,
				);
				$where_hotel_booking = array( "id" => $booking_id );
				$this->global_model->update_data( "hotel_booking", $where_hotel_booking, $up_data ); 
				$res = array('status' => true, 'msg' => "Hotel Booking Mail Sent Successfully!");
			}else{
				$res = array('status' => false, 'msg' => "Mail Not Sent. Please Try Again Later.");
			}
			die( json_encode($res) );
		}else{
			redirect(404);
		}
	}
	
	/* // Send Voucher Email  */
	public function sendvoucher(){
		/* // Load Pdf liberary */
		$this->load->library('Pdf');
		$voucher_id = $this->input->post("id", true);
		$temp_key = $this->input->post("key", true);
		
		$user = $this->session->userdata('logged_in');
		$user_id = $user['user_id'];
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '97'){
			/* check if empty voucher id*/
			 if( empty($voucher_id) ){
				$res = array('status' => false, 'msg' => "Invalid Id.");
				die( json_encode($res) );
			} 
			
			$where = array("voucher_id" => $voucher_id, "temp_key" => $temp_key );
			$vouchers = $this->global_model->getdata( "vouchers", $where );
			if( $vouchers  ){
				$data['vouchers'] = $vouchers;
				$voucher = $vouchers[0];
				
				$voucher_id = $voucher->voucher_id;
				
				/* Get Customer Information */
				$customer_name = $voucher->customer_name;
				$customer_contact = $voucher->customer_contact;
				$customer_email = $voucher->customer_email;
				
				$from =  "no-reply@Trackitinerary.com";
				/* //get message template	 */		
				$message = $this->load->view("vouchers/mail", $data, TRUE);	
				/*get Pdf attachment*/
				$pdf = $this->load->view("vouchers/pdf_mail", $data, TRUE);
			
				/* Get admin emails */
				$admin_email = admin_email();
				$manager_email = manager_email();
				$admin_emails_list = array($admin_email, $manager_email);
				$subject = "< {$customer_name} > Booking Voucher Mail <Trackitinerary>"; 
				$this->email->clear();
				/* send email*/
				$this->email
					->from($from, 'Track Itinerary Pvt. Ltd.')
					->to( $customer_email )
					->bcc( $admin_emails_list )
					->subject($subject)
					->message( $message )
					->set_mailtype('html');
					if( !empty( $pdf ) ){
						$this->email->attach($pdf);
					}
					$sent_mail = $this->email->send(); 
					if( $sent_mail ){
						/* send msg for customer on voucher send */
						$mobile_customer_sms = "Dear {$customer_name}, Voucher send to your email {$customer_email}. If you not recieve voucher in your inbox please find the mail in spam. Thanks <Trackitinerary Pvt Ltd.>";
						$cus_mobile = "{$customer_contact}";
						if( !empty( $cus_mobile ) ){
							$sendcustomer_sms = pm_send_sms( $cus_mobile, $mobile_customer_sms );
						}
						/*Get total email sent to current Voucher*/
						$where = array( "voucher_id" => $voucher_id );
						$count_email = $this->global_model->getdata( "vouchers", $where, "email_count" );
						if( empty($count_email) ){
							$count_email = 0;
						}
						$email_inc = $count_email+1;
						
						/*update Email count status*/
						$up_data = array(
							'email_count' => $email_inc,
						);
						$where_voucher = array( "voucher_id" => $voucher_id );
						$this->global_model->update_data( "vouchers", $where_voucher, $up_data ); 
						$res = array('status' => true, 'msg' => "Voucher Sent Successfully!");
						
					}else{
						$res = array('status' => true, 'msg' => "Mail Not Sent. Please Try Again Later.");
					}
				die( json_encode($res) );
			}else{
				$res = array('status' => false, 'msg' => "No Voucher found.");
				die( json_encode($res) );
			}	
		}else{
			redirect(404);
		}
	}
	
}
?>