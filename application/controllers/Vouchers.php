<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Vouchers extends CI_Controller {
	public function __Construct(){
	   	parent::__Construct();
		validate_login();
		$this->load->model("voucher_model");
	}
	public function index(){
		$user = $this->session->userdata('logged_in');
		$user_id = $user["user_id"];
		if( $user['role'] == '99' || is_super_manager() || $user['role'] == '97' || $user['role'] == '93' ){
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('vouchers/all_vouchers');
			$this->load->view('inc/footer'); 
		}else{
			redirect(404);
		}
	}
	
	
	public function pendingvouchers(){
		$user = $this->session->userdata('logged_in');
		$user_id = $user["user_id"];
		if( $user['role'] == '99' || is_super_manager() || $user['role'] == '97' || $user['role'] == '93' ){
			$data['pending_vouchers'] = $this->voucher_model->get_pending_vouchers_list();
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('vouchers/pending_vouchers', $data);
			$this->load->view('inc/footer'); 
		}else{
			redirect(404);
		}
	}
	
	
	/* View Voucher */
	public function view(){
		$voucher_id = $this->uri->segment(3);
		$temp_key = $this->uri->segment(4);
		$user = $this->session->userdata('logged_in');
		$user_id = $user['user_id'];
		if( $user['role'] == '99' || is_super_manager() || $user['role'] == '97' || $user['role'] == '93'){
			$where = array("voucher_id" => $voucher_id, "temp_key" => $temp_key );
			$data['vouchers'] = $this->global_model->getdata( "vouchers", $where );
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('vouchers/view', $data);
			$this->load->view('inc/footer');
		}else{
			redirect("dashboard");
		}	
	}
	
	/* data table get all Vouchers */
	public function ajax_voucher_list(){
		$user = $this->session->userdata('logged_in');
		$u_id = $user['user_id'];
		$role = $user['role'];
		if( $role == '99' || is_super_manager() ||  $role == '97' || $user['role'] == '93' ){
			$where = array( "confirm_voucher" => 1 );
			$list = $this->voucher_model->get_datatables( $where );
		}
		$data = array();
		$no = $_POST['start'];
		if( !empty($list) ){
			foreach ($list as $voucher) {
				$no++;
				$row = array();
				$row[] = $no;
				$row[] = $voucher->voucher_id;
				$row[] = $voucher->iti_id;
				$row[] = $voucher->iti_type == 2 ? "<span class='red'>Accommodation</span>" : "<span class='green'>Holiday</span>";
				$row[] = $voucher->customer_name; 
				$row[] = $voucher->customer_contact;
				$row[] = $voucher->customer_email;
				$row[] = $voucher->package_name;
				$row[] = get_travel_date( $voucher->iti_id );
				$row[] = get_user_name( $voucher->agent_id );

				$voucher_btn = "<a title='Generate Voucher' href=" . site_url("vouchers/generate_voucher/{$voucher->iti_id}") . " class='btn btn-success' target='_blank' ><i class='fa fa-plus' aria-hidden='true'></i> Generate Voucher</a>";
				
				//client view
				$vid = base64_url_encode( $voucher->voucher_id );
				$viti_id = base64_url_encode( $voucher->iti_id );
				
				$voucher_btn .= "<a title='Generate Voucher' href=" . site_url("promotion/voucher/{$vid}/{$viti_id}") . " class='btn btn-danger' target='_blank' ><i class='fa fa-eye' aria-hidden='true'></i> Client View</a>";
				
				$pdf_btn = "<a title='Generate PDF' href=" . site_url("vouchers/generate_pdf/{$voucher->iti_id}") . " class='btn btn-success' target='_blank' ><i class='fa fa-file-pdf-o' aria-hidden='true'></i> Pdf</a>";
				
				$row[] = "<a title='View' href=" . site_url("itineraries/view/{$voucher->iti_id}/{$voucher->temp_key}") . " class='btn btn-success' target='_blank' ><i class='fa fa-eye' aria-hidden='true'></i> View Iti</a>" . $voucher_btn . $pdf_btn;
				$data[] = $row;
			}
		}	
		
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->voucher_model->count_all($where),
			"recordsFiltered" => $this->voucher_model->count_filtered($where),
			"data" => $data,
		);
		
		//output to json format
		echo json_encode($output);
	}
	
	
	//GENERATE PDF
	public function generate_pdf( $iti_id = NULL ){
		$this->load->library('Pdf');
		$user = $this->session->userdata('logged_in');
		$user_id = $user['user_id'];
		$role = $user['role'];
		// Check for itineray if approved or not
		$where = array("iti_id" => $iti_id, 'iti_status' => 9, 'del_status' => 0 );
		$data['itinerary'] = $this->voucher_model->getdata( "itinerary", $where );
		if( ($role == '99' || $role == '98' ||  $role == '97' || $user['role'] == '93') && !empty( $iti_id ) && isset( $data['itinerary'][0]->customer_id ) ){
			$error = "";
			
			$data['iti_payment_details'] = $this->voucher_model->getdata( "iti_payment_details", array( "iti_id" => $iti_id ) );
			//get customer info
			$data['customer'] = $this->voucher_model->getdata( "customers_inquery", array( "customer_id" => $data['itinerary'][0]->customer_id ) );
			
			// Check for Hotel Booking if approved or not
			$where_hotel = array("iti_id" => $iti_id, 'booking_status' => 9, 'del_status' => 0 );
			$data['hotels'] = $this->voucher_model->getdata( "hotel_booking", $where_hotel , "check_in", "ASC" );
			
			// Check for Cab Booking if approved or not
			$where_cab = array("iti_id" => $iti_id, 'booking_status' => 9, 'del_status' => 0 );
			$data['cab_booking']  = $this->voucher_model->getdata( "cab_booking", $where_cab, "picking_date" , "ASC" );
			
			$where_vtf = array("iti_id" => $iti_id, 'del_status' => 0, 'booking_status' => 9 );
			$data['vtf_booking'] = $this->voucher_model->getdata( "travel_booking", $where_vtf, "dep_date", "ASC" );
			
			//Count voucher against current itinerary data
			$where_iti = array( "iti_id" => $iti_id, "confirm_voucher" => 1 );
			$data['vouchers'] = $this->voucher_model->getdata("iti_vouchers_status", $where_iti);
			
			//dump( $data['customer'] ); die;
			
			if( empty($data['itinerary']) || !isset( $data['vouchers'][0]->id ) ){
				$error = "You can't generate voucher pdf against this itinerary because itinerary not approved OR voucher is not confirmed. Please contact service/account team.";
				echo $error;
				exit;
			}
			
			if( empty( $data['hotels'] ) ){
				$error = "Hotel not booked or approved for Itinerary Id: " . $iti_id . " . To generate a voucher pdf hotel booking is required. You can't proceed without book hotel.";
				echo $error;
				exit;
			}
			
			$data['error']			= $error;
			$data['agent_id'] 		= $user_id;
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('vouchers/pdf', $data);
			$this->load->view('inc/footer');
		}else{
			redirect(404);
		}	
	}
	
	//GENERATE Voucher
	public function generate_voucher( $iti_id = NULL ){
		$user = $this->session->userdata('logged_in');
		$user_id = $user['user_id'];
		$role = $user['role'];
		// Check for itineray if approved or not
		$where = array("iti_id" => $iti_id, 'iti_status' => 9, 'del_status' => 0 );
		$data['itinerary'] = $this->voucher_model->getdata( "itinerary", $where );
		if( ($role == '99' || $role == '98' ||  $role == '97' || $user['role'] == '93') && !empty( $iti_id ) && isset( $data['itinerary'][0]->customer_id ) ){
			$error = "";
			
			$data['iti_payment_details'] = $this->voucher_model->getdata( "iti_payment_details", array( "iti_id" => $iti_id ) );
			//get customer info
			$data['customer'] = $this->voucher_model->getdata( "customers_inquery", array( "customer_id" => $data['itinerary'][0]->customer_id ) );
			
			// Check for Hotel Booking if approved or not
			$where_hotel = array("iti_id" => $iti_id, 'booking_status' => 9, 'del_status' => 0 );
			$data['hotels'] = $this->voucher_model->getdata( "hotel_booking", $where_hotel , "check_in", "ASC" );
			
			// Check for Cab Booking if approved or not
			$where_cab = array("iti_id" => $iti_id, 'booking_status' => 9, 'del_status' => 0 );
			$data['cab_booking']  = $this->voucher_model->getdata( "cab_booking", $where_cab, "picking_date" , "ASC" );
			
			$where_vtf = array("iti_id" => $iti_id, 'del_status' => 0, 'booking_status' => 9 );
			$data['vtf_booking'] = $this->voucher_model->getdata( "travel_booking", $where_vtf, "dep_date", "ASC" );
			
			//Count voucher against current itinerary data
			$where_iti = array( "iti_id" => $iti_id, "confirm_voucher" => 1 );
			$data['vouchers'] = $this->voucher_model->getdata("iti_vouchers_status", $where_iti);
			
			//dump( $data['customer'] ); die;
			
			if( empty($data['itinerary']) || !isset( $data['vouchers'][0]->id ) ){
				$error = "You can't generate voucher against this itinerary because itinerary not approved OR voucher is not confirmed. Please contact service/account team.";
				//echo $error;
				//exit;
			}
			
			if( empty( $data['hotels'] ) ){
				$error = "Hotel not booked or approved for Itinerary Id: " . $iti_id . " . To generate a voucher hotel booking is required. You can't proceed without book hotel.";
			}
			
			$data['error']			= $error;
			$data['agent_id'] 		= $user_id;
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('vouchers/generate_voucher', $data);
			$this->load->view('inc/footer');
			
		}else{
			redirect(404);
		}	
	}

	//Create csv
	public function csv(){
		$user = $this->session->userdata('logged_in');
		$u_id = $user['user_id'];
		$role = $user['role'];
		if( $role == '99' || is_super_manager() ||  $role == '97' || $user['role'] == '93' ){
			$filename = "voucher_" . date("YmdH_i_s") . ".csv";
			
			//Headers for create csv files
			header("Content-type: text/csv");
			header("Content-Disposition: attachment; filename={$filename}");
			header("Cache-Control: post-check=0, pre-check=0");
			header("Pragma: no-cache");
			header("Expires: 0"); 
			//Get data
			$where = array("del_status" => 0);
			$voucher_data = $this->voucher_model->getdatacsv("vouchers", $where);
			
			if( $voucher_data ){
				$fileout = @fopen( 'php://output', 'w' );
				fputcsv($fileout, array(
						'Sr. No',
						'Customer Name',
						'Contact',
						'Package Name',
						'Vehicle Type',
						'Hotel',
						'Rooms',
						'Tour Date',
						'Tour End Date',
						'Duration',
						'Package Cost',
						'Advance Payment',
						'Balance Payment',
					)
				); 
				$i=1;
			 	$csvData = array();
				foreach( $voucher_data as $voucher ){
					$hotel_ids = $voucher["hotel_ids"];
					$hotels_id = explode( ",", $hotel_ids );
					$hotel_name = "";
					foreach( $hotels_id as $h_id ){
						$name = get_hotel_name( $h_id );
						$hotel_name .= "({$name})";
					}
					
					$travel_date	 = $voucher['travel_date'];
					$travel_end_date = $voucher['travel_end_date'];
					//count duration
					if( !empty( $travel_date ) && !empty($travel_end_date) ){	
						$t_date =  change_date_format($travel_date);
						$t_date1 =  new DateTime($t_date);
						$leav_date =  change_date_format($travel_end_date); 
						$date1 = new DateTime($t_date);
						$date2 = new DateTime($leav_date);
						$total_days =  $date2->diff($t_date1)->format("%a"); 
						$days = $date2->diff($date1)->format("%a");
						if($days <= 1){
							$duration =  "Single Day";
						}else{
							$nights = $days-1;
							$duration =  $nights . " Nights and " . $days . " Days";
						}
					}
					$csvData[] = $i;
					$csvData[] = $voucher['customer_name'];
					$csvData[] = $voucher['customer_contact'];
					$csvData[] = $voucher['package_name'];
					$csvData[] = $voucher['vehicle_type'];
					$csvData[] = $hotel_name;
					$csvData[] = $voucher['total_rooms'];
					$csvData[] = $voucher['travel_date'];
					$csvData[] = $voucher['travel_end_date'];
					$csvData[] = $duration;
					$csvData[] = $voucher['grand_total'];
					$csvData[] = $voucher['advance_payment'];
					$csvData[] = $voucher['balance_payment'];
					
					fputcsv( $fileout, $csvData);
					$i++;
					//Unset array in each row
					unset($csvData);
				} 
				
				/* echo "<pre>";
				print_r( $data );
				echo "</pre>"; */
				
				fclose($fileout);
				exit;
			}	
		}
	}
	
	//send voucher
	public function sendVoucher(){
		$iti_id 			= $this->input->post("iti_id", true);
		$id 				= $this->input->post("id", true);
		$subject 			= $this->input->post("subject", true);
		$customer_email 	= $this->input->post("customer_email", true);
		
		$user = $this->session->userdata('logged_in');
		$user_id = $user['user_id'];
		$voucher = $this->global_model->getdata( "iti_vouchers_status", array( "id" => $id ) );
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '93' || $user['role'] == '97'){
			if( empty($iti_id) ){
				$res = array('status' => false, 'msg' => "Invalid Itinerary Id.");
				die( json_encode($res) );
			}
			
			$where = array( "iti_id" => $iti_id );
			$itinerary = $this->global_model->getdata("itinerary", $where);
			if( $itinerary ){
				$data['itinerary'] = $itinerary;
				$iti = $itinerary[0];
				$itinerary_id 	= $iti->iti_id;
				$customer_id 	= $iti->customer_id;
				$temp_key 		= $iti->temp_key;
				
				//Get customer info
				$get_customer_info = get_customer( $iti->customer_id ); 
				$cust = $get_customer_info[0];
				$customer_name = $cust->customer_name;
				$customer_email = !empty($customer_email) ? $customer_email : $cust->customer_email;
				
				//get agent info
				$agent_id = $iti->agent_id;
				$from = get_user_email( $agent_id );
				
				//message
				//client view
				$vid 		= base64_url_encode( $voucher[0]->voucher_id );
				$viti_id 	= base64_url_encode( $voucher[0]->iti_id );
				
				$voucher_link = "<a title='View Voucher' href=" . site_url("promotion/voucher/{$vid}/{$viti_id}") . " class='btn btn-danger' target='_blank' ><i class='fa fa-eye' aria-hidden='true'></i> Click here to view voucher</a>";
				
				//$message = "VOUCHER LINK COMMING SOON";
				$message 			= "TOUR CONFIRMATION VOUCHER <br>";
				$message 			.= "Itinerary Id: {$iti->iti_id} <br>";
				//$message 			.= "Customer Name: {$customer_name} <br>";
				$message 			.= "{$voucher_link}<br>";
				
				//Check if BCC and CC Email exists
				$bcc_emails 		= $this->input->post("bcc_email", true);
				$cc_email 			= $this->input->post("cc_email", true);
				$bccEmails 	= !empty($bcc_emails) ? $bcc_emails : "";
				$ccEmails 	= !empty($cc_email) ? $cc_email : "";
				
				$to = trim( $customer_email );
				//$to = "premthakur@eligocs.com";
				//$sent_mail = sendEmail($to, $subject, $message );
				$sent_mail = sendEmail($to, $subject, $message, $bccEmails, $ccEmails);
				if( $sent_mail ){
					//send message
					//$iti_link = site_url("promotion/voucher/{$id}/{$iti_id}/{$temp_key}");
					//$mobile_customer_sms = "Voucher send to your email {$customer_email}. If you not recieve itinerary in your inbox please find the mail in spam. {$iti_link} .Thanks <Trackitinerary Pvt Ltd.>";
					//Check if additional contact is not empty
					//$addContact = !empty($additonal_contact) ? $additonal_contact : "";
					//$cus_mobile = "{$customer_contact}, {$addContact}";
					//if( !empty( $cus_mobile ) ){
						//$sendcustomer_sms = pm_send_sms( $cus_mobile, $mobile_customer_sms );
					//}
					
					//email count
					$email_count = $voucher[0]->sent_count;
					if( empty($email_count) ){
						$email_count = 0;
					}
					$email_inc = $email_count+1;
					
					//update Email count status
					$up_data = array(
						'sent_count' 			=> $email_inc,
					);
					$where_iti = array( "id" => $id );
					$this->global_model->update_data( "iti_vouchers_status", $where_iti, $up_data );
					
					$res = array('status' => true, 'msg' => "Voucher Sent Successfully!");
				}else{
					$res = array('status' => false, 'msg' => "Voucher Not Sent. Please Try Again Later.");
				}				
			}else{
				$res = array('status' => false, 'msg' => "Invalid id. Please Try Again Later.");
			}
			die( json_encode($res) );
		}else{
			redirect(404);
		}		
	}
	
	public function test(){
		$sn = sendEmail("premthakur@eligocs.com","test", "dd" );
		if( $sn ) 
			echo "sent";
		else
			echo "err";
	}
}	

?>