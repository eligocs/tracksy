<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Vehiclesbooking extends CI_Controller {
	public function __Construct(){
	   	parent::__Construct();
		validate_login();
		$this->load->model("vehiclesbooking_model");
	}
	
	//List All Cab Bookings
	public function index(){
		$user = $this->session->userdata('logged_in');
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '97'){
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('vehiclesbooking/cab/all_cab_booking');
			$this->load->view('inc/footer');
		}else{
			redirect("dashboard");
		} 
	}
	
	//List All Train/Volvo/Flight Bookings
	public function allvehiclesbookings(){
		$user = $this->session->userdata('logged_in');
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '97'){
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('vehiclesbooking/all_volvo_train_booking');
			$this->load->view('inc/footer');
		}else{
			redirect("dashboard");
		}
	}
	
	/* book cab */
	public function bookcab(){
		$user = $this->session->userdata('logged_in');
		$req_id = $this->uri->segment(3);
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '97'){
			
			//Get Existing Bookings
			$where = array("iti_id" => $req_id , "del_status" => 0 );
			$exist_booking = $this->global_model->getdata( "cab_booking", $where );
			$data["existing_bookings"] = $exist_booking;
		
			$where = array("iti_id" => $req_id, "iti_status" => 9, 'del_status' => 0 );
			$data['itinerary'] = $this->global_model->getdata( "itinerary", $where );
			$data['agent_id'] = $user['user_id'];
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('vehiclesbooking/cab/cab_book', $data);
			$this->load->view('inc/footer');
		}	
	}
	
	/* Edit Cab Booking */
	public function editcabbooking(){
		$booking_id = $this->uri->segment(3);
		$user = $this->session->userdata('logged_in');
		$user_id = $user['user_id'];
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '97'){
			$where = array( 'id' => $booking_id  );
			$data['cab_booking'] = $this->global_model->getdata( 'cab_booking', $where );
			if( $user['role'] == 97 && $data['cab_booking'][0]->is_approved_by_gm != 0  ){
				echo "You can't edit this booking because its already sent to GM for approve or approved by GM.";
				exit;
			}	
			
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('vehiclesbooking/cab/editcab_booking', $data);
			$this->load->view('inc/footer');
		}else{
			redirect(404);
		}
	}
	
	//update cab details
	public function update_cab_details( $id = NULL ){
		$booking_id = $id;
		$user = $this->session->userdata('logged_in');
		$user_id = $user['user_id'];
		if( ($user['role'] == '99' || $user['role'] == '98' || $user['role'] == '97' ) && !empty( $id ) ){
			$where = array( 'id' => $booking_id , "booking_status" => 9 , "del_status" => 0 );
			$data['cab_booking'] = $this->global_model->getdata( 'cab_booking', $where );
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('vehiclesbooking/cab/update_cab_details', $data);
			$this->load->view('inc/footer');
		}else{
			redirect(404);
		}
	}
	
	//update cab detail
	public function ajax_update_cab_details(){
		$user = $this->session->userdata('logged_in');
		$user_id = $user['user_id'];
		if( isset($_POST['id']) && !empty($_POST['id']) && isset( $_POST['cab_meta'] ) ) {
			$id = $_POST['id'];
			
			$cab_meta = serialize($this->input->post('cab_meta', TRUE));
			$booking_id = $this->global_model->update_data("cab_booking", array("id" => $id ), array( "cab_meta" => $cab_meta, "agent_id" => $user_id ) );
			
			if( $booking_id){
				$this->session->set_flashdata('success',"Cab Details Updated Successfully.");
				$res = array('status' => true, 'msg' => "Cab Details Updated Successfully", "booking_id" => $id );
			}else{
				$booking_id = array('status' => false, 'msg' => "Error! please try again later");
			}
			die(json_encode($res));
		}else{
			$res = array('status' => false, 'msg' => "Error! Please fill all fields!");
			die(json_encode($res));
		}
	}
	
	/* View Cab booking */
	public function viewbooking(){
		$booking_id = $this->uri->segment(3);
		$user = $this->session->userdata('logged_in');
		$user_id = $user['user_id'];
		$data['role'] = $user['role'];
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '97' || $user['role'] = 93 ){
			$where = array( 'id' => $booking_id  );
			$data['cab_booking'] = $this->global_model->getdata( 'cab_booking', $where );
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('vehiclesbooking/cab/view_cab_booking', $data);
			$this->load->view('inc/footer');
		}else{
			redirect(404);
		}
	}
	
	/* Add Volvo , train , flight tickets details */
	public function addbookingdetails(){
		$user = $this->session->userdata('logged_in');
		$req_id = $this->uri->segment(3);
		
		//check if all booking confirmed by agent
		$check_all_vtf_booking = is_vtf_booking_done( $req_id );
		if( $check_all_vtf_booking ){
			echo "You can't create new booking for this itinerary. Because All booking status has been updated.For more info contact your administrator.";
			die;
		}
		
		$where = array("iti_id" => $req_id , "del_status" => 0 );
		$exist_booking = $this->global_model->getdata( "travel_booking", $where );
		$data["existing_bookings"] = $exist_booking;
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '97'){
			if( isset( $_GET['type'] ) && !empty( $req_id ) ){
				$booking_type =  $_GET['type'];
				/* if( $exist_booking ){
					$data['booking_type'] = $booking_type;
					$data['agent_id'] = $user['user_id'];
					$data['exist_booking'] = $booking_type;
					$this->load->view('inc/header');
					$this->load->view('inc/sidebar');
					$this->load->view('vehiclesbooking/train_flight_booking', $data);
					$this->load->view('inc/footer');
				}else{	 	 */		
				$where = array("iti_id" => $req_id, "iti_status" => 9 );
				$where_approve = array("iti_status" => 9, 'del_status' => 0 );
				$data['iti_lists'] = $this->global_model->getdata( "itinerary", $where_approve );
				$itinerary = $this->global_model->getdata( "itinerary", $where );
				if( !empty($itinerary) ){
					$data['itinerary'] = $itinerary;
					$data['booking_type'] = $booking_type;
					$data['agent_id'] = $user['user_id'];
					$this->load->view('inc/header');
					$this->load->view('inc/sidebar');
					$this->load->view('vehiclesbooking/train_flight_booking', $data);
					$this->load->view('inc/footer');
				}else{
					redirect(404);
				}
			}else{
				$where_approve = array("iti_status" => 9 );
				$data['booking_type'] = 'volvo';
				$data['iti_lists'] = $this->global_model->getdata( "itinerary", $where_approve );
				$where = array("iti_id" => $req_id, "iti_status" => 9 );
				$data['itinerary'] = $this->global_model->getdata( "itinerary", $where );
				$data['agent_id'] = $user['user_id'];
				$this->load->view('inc/header');
				$this->load->view('inc/sidebar');
				$this->load->view('vehiclesbooking/train_flight_booking', $data);
				$this->load->view('inc/footer');
			}	
		}else{
			redirect(404);
		}
	}
	
	//Ajax request to insert data train/volvo/flight
	public function volTrainFlight_booking_details(){
		// var_dump( (int)$_POST['inp']['cost_per_seat'] > 0);die;
		// if( isset($_POST['inp']['t_name']) && !empty($_POST['inp']['dep_date']) && (int)$_POST['inp']['cost_per_seat'] < 0 ) {
		if( isset($_POST['inp']['t_name']) && !empty($_POST['inp']['dep_date']) && (int)$_POST['inp']['cost_per_seat'] > 0 ) {
			$iti_id = $_POST['inp']['iti_id'];
			$inp = $this->input->post('inp', TRUE);
			$booking_id = $this->global_model->insert_data("travel_booking", $inp);
			// var_dump($booking_id);die;
			if( $booking_id){
				$this->session->set_flashdata('success',"Booking Added Successfully.");
				$res = array('status' => true, 'msg' => "Booking Details Add Successfully", "booking_id" => $booking_id );
			}else{
				$booking_id = array('status' => false, 'msg' => "Error! please try again later");
			}
			die(json_encode($res));
		}else{
			$res = array('status' => false, 'msg' => "Error! Please fill all fields!");
			die(json_encode($res));
		}
	}
	
	
	/* Edit all vehicles Train/Volvo/Flight */
	public function editvtf(){
		$booking_id = $this->uri->segment(3);
		$iti_id = $this->uri->segment(4);
		$user = $this->session->userdata('logged_in');
		$user_id = $user['user_id'];
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '97' ){
			$where = array( 'id' => $booking_id , 'iti_id' => $iti_id );
			$data['travel_booking'] = $this->global_model->getdata( 'travel_booking', $where );
			if( $user['role'] == 97 && $data['travel_booking'][0]->is_approved_by_gm != 0  ){
				echo "You can't edit this booking because its already sent to GM for approve or approved by GM.";
				exit;
			}	
			
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('vehiclesbooking/edit_vtf_booking', $data);
			$this->load->view('inc/footer');
		}
		/*elseif($user['role'] == '97'){
			$where = array( 'id' => $booking_id , 'iti_id' => $iti_id, 'agent_id' => $user_id );
			$data['travel_booking'] = $this->global_model->getdata( 'travel_booking', $where );
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('vehiclesbooking/edit_vtf_booking', $data);
			$this->load->view('inc/footer');
		} */
		else{
			redirect(404);
		}
	}
	
	//Cancel volvo/train/flight Booking
	public function cancel_vtf_booking(){
		$id = $this->input->post("id", TRUE);
		$user = $this->session->userdata('logged_in');
		$user_id = $user['user_id'];
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '97'){
			$where = array("id" => $id );
			$booking_id = $this->global_model->update_data( "travel_booking", $where, array("booking_status" => 8 ) );
			if( $booking_id){
				$this->session->set_flashdata('success',"Booking Cancel Successfully.");
				$res = array('status' => true, 'msg' => "Booking Cancel Successfully" );
			}else{
				$res = array('status' => false, 'msg' => "Error! please try again later");
			}
		}else{
			$res = array('status' => false, 'msg' => "Error! Invalid Request!");
		}
		die(json_encode($res));
	}
	
	//Ajax request to Update data train/volvo/flight
	public function ajax_edit_vtf(){
		if (isset($_POST['inp']['t_name']) && !empty($_POST['inp']['dep_date'])) {
			$id = $_POST['inp']['id'];
			$inp = $this->input->post('inp', TRUE);
			
			//CHECK IF APPROVED BY GM
			/* if( isset( $_POST['approve_pending'] ) && $_POST['approve_pending'] == 1 ){
				$check_old_price = $this->global_model->getdata("travel_booking", array("id" => $id ) );
				$inp['old_cost_per_seat'] 				= $check_old_price[0]->cost_per_seat;
				$inp['old_cost_per_seat_return_trip'] 	= $check_old_price[0]->cost_per_seat_return_trip;
				$inp['is_approved_by_gm'] = 2;
				$type = $check_old_price[0]->booking_type;
				$iti_id = $check_old_price[0]->iti_id;
				$customer_id = $check_old_price[0]->customer_id;
				$agent_id = $check_old_price[0]->agent_id;
				
				//SEND MAIL TO volvo/train team 
				if( $type == "flight" ){
					$hotel_booking_email = get_flight_booking_email();
				}else if( $type = "train" ){
					$hotel_booking_email = get_train_booking_email();
				}else{
					$hotel_booking_email = vehicle_booking_email();
				}
				
				$admins 		= array( $hotel_booking_email );
				//sent mail to agent after price updated
				$link = "<a class='btn btn-success' target='_blank' href=" . site_url("vehiclesbooking/viewvehiclebooking/{$id}/{$iti_id}") . " title='View'>Click to view Booking</a>";					
				$sub 			= "{$type} Booking Quotation Approved By GM <Trackitinerary.org>";
				$msg 			= "{$type} booking quotation approved by GM. Now you can send this booking to transporter for confirmation.<br>";
				$msg 			.= "Itinerary Id: {$iti_id} <br>";
				$msg 			.= "{$link}<br>";
				//send mail to manager 
				$sent_mail_admins	 = sendEmail($admins, $sub, $msg);
				
				//NOTIFICATION TO SERVICE TEAM
				$title 		= "{$type} Quotation Approved";
				$c_date 	= current_datetime();
				$notif_time = date("Y-m-d H:i:s", strtotime( $c_date . " +5 minutes") );
				$body 		= "{$type} Booking Quotation Approved By GM";
				$notif_link = "vehiclesbooking/viewvehiclebooking/{$id}/{$iti_id}";
				$notification_data = array(
					"customer_id"		=> $customer_id,
					"notification_for"	=> 97, //97 = service team
					"title"				=> $title,
					"body"				=> $body,
					"url"				=> $notif_link,
					"notification_time"	=> $notif_time,
					"agent_id"			=> $agent_id,
				);
				$this->global_model->insert_data( "notifications", $notification_data );
				//end  notification
			} */
			
			$where = array("id" => $id );
			$booking_id = $this->global_model->update_data("travel_booking", $where, $inp);
			if( $booking_id){
				$this->session->set_flashdata('success',"Booking Edit Successfully.");
				$res = array('status' => true, 'msg' => "Booking Details Edit Successfully", "booking_id" => $booking_id );
			}else{
				$res = array('status' => false, 'msg' => "Error! please try again later");
			}
		}else{
			$res = array('status' => false, 'msg' => "Error! Please fill all fields!");
		}
		die(json_encode($res));
	}
	
	
	/* View all vehicles Train/Volvo/Flight */
	public function viewvehiclebooking(){
		$booking_id = $this->uri->segment(3);
		$iti_id = $this->uri->segment(4);
		$user = $this->session->userdata('logged_in');
		$user_id = $user['user_id'];
		$data['role'] = $user['role'];
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] = 97 || $user['role'] = 93 ){
			$where = array( 'id' => $booking_id , 'iti_id' => $iti_id );
			$data['travel_booking'] = $this->global_model->getdata( 'travel_booking', $where );
			$data['vtf_booking_docs'] = $this->global_model->getdata( 'vtf_booking_docs', array("booking_id" => $booking_id ) );
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('vehiclesbooking/view_vtf_booking', $data);
			$this->load->view('inc/footer');
		}
		/*elseif($user['role'] == '97'){
			$where = array( 'id' => $booking_id , 'iti_id' => $iti_id, 'agent_id' => $user_id );
			$data['travel_booking'] = $this->global_model->getdata( 'travel_booking', $where );
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('vehiclesbooking/view_vtf_booking', $data);
			$this->load->view('inc/footer');
		}
		*/
		else{
			redirect(404);
		}
	}
	/* data table get all Cab Booking */
	public function ajax_cab_booking_list(){
		$user = $this->session->userdata('logged_in');
		$u_id = $user['user_id'];
		$role = $user['role'];
		if( $role == '99' || $role == '98' || $role == '97' ){
			$where = array();
			$list = $this->vehiclesbooking_model->get_datatables();
		}
		$data = array();
		$no = $_POST['start'];
		if( !empty($list) ){
			foreach ($list as $cab_book) {
				$row_delete = "";
				$row_edit = "";
				$cab_info_btn = "";
				$no++;
				$booking_id 		= $cab_book->id;
				$iti_id				= $cab_book->iti_id;
				$transporter_name 	= get_transporter_name($cab_book->transporter_id);
				$cab_name 			= get_car_name( $cab_book->cab_id );
				$booking_status		= $cab_book->booking_status;
				if( $booking_status == 9 ){
					$status = "<a data-id={$booking_id} title='Cab Booking Approved' href='javascript:void(0)' class='btn btn-success ajax_booking_status'><i class='fa fa fa-thumbs-o-up' aria-hidden='true'></i> &nbsp; Approved</a>";
					
					//update cab info button
					$cab_info_btn = "<a  href='" . site_url("vehiclesbooking/update_cab_details/{$booking_id}") . "' title='Update Cab Info' href='javascript:void(0)' class='btn btn-success'><i class='fa fa-refresh' aria-hidden='true'></i> &nbsp; Update Cab Details</a>";
					
				}elseif( $booking_status == 8 ){
					$status = "<a data-id={$booking_id} title='Cab Booking Declined' href='javascript:void(0)' class='btn btn-danger ajax_booking_status'><i class='fa fa fa-times' aria-hidden='true'></i> &nbsp; Declined</a>";
				}elseif( $booking_status == 7 ){
					$status = "<strong class='red'>Canceled</strong>";
				}else{
					$status = "No Review";
				}
				
				/* count iti sent status */
				$cab_book_sent = $cab_book->email_count;
				$sent_status = $cab_book_sent > 0 ? "$cab_book_sent Time Sent" : "Not Sent";
				$row = array();
				$row[] = $no;
				$row[] = $booking_id; 
				$row[] = $iti_id;
				$row[] = $transporter_name; 
				$row[] = $cab_name;
				$row[] = $cab_book->total_cabs; 
				$row[] = $cab_book->picking_date . " - " . $cab_book->droping_date; 
				$row[] = number_format($cab_book->total_cost) . " /-"; 
				$row[] = $sent_status; 
				
				if( empty($booking_status) && $cab_book_sent > 0 ){
					$row[] = "<a title='Click to Approve Booking' href=" . site_url("confirm/cabbooking?booking_id=". base64_url_encode($booking_id) . "&iti_id=" . base64_url_encode($iti_id) ) . "&status=" . base64_url_encode(9) . " class='btn btn-success' ><i class='fa fa fa-check' aria-hidden='true'></i></a>
					<a title='Click to Decline' href=" . site_url("confirm/cabbooking?booking_id=". base64_url_encode($booking_id) . "&iti_id=" . base64_url_encode($iti_id)) . "&status=" . base64_url_encode(8) . " class='btn btn-danger' ><i class='fa fa fa-ban' aria-hidden='true'></i></a>";
					
				}else{
					$row[] = $status;
				} 
				
				if( is_admin() || is_gm() ){ 
					$row_delete = "<a data-id={$booking_id} title='Delete Hotel Booking' href='javascript:void(0)' class='btn_trash ajax_delete_booking'><i class='fa fa-trash-o' aria-hidden='true'></i></a>";
				}
				
				$row_edit = "";
				if( ( $role == 97 && $cab_book->is_approved_by_gm == 0 ) || is_gm() || $role == 99  ){
					$row_edit = "<a title='Edit' href=" . site_url("vehiclesbooking/editcabbooking/{$booking_id}") . " class='btn_pencil' ><i class='fa fa-pencil' aria-hidden='true'></i></a>";
				}
				
				
				$row[] = "<a title='View' href=" . site_url("vehiclesbooking/viewbooking/{$booking_id}") . " class='btn_eye' ><i class='fa fa-eye' aria-hidden='true'></i></a>" . $row_edit . $cab_info_btn . $row_delete;
			
				$data[] = $row;
			}
		}	
		
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->vehiclesbooking_model->count_all($where),
			"recordsFiltered" => $this->vehiclesbooking_model->count_filtered($where),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}
	
	
	/* data table get all train / flights/ volvo */
	public function ajax_all_vehiclesbooking_list(){
		$user = $this->session->userdata('logged_in');
		$u_id = $user['user_id'];
		$role = $user['role'];
		if( $role == '99' || $role == '98' || $role == '97' ){
			$where = array();
			$list = $this->vehiclesbooking_model->get_datatables_vol();
		}	
		$data = array();
		
		$no = $_POST['start'];
		if( !empty($list) ){
			foreach ($list as $veh_book) {
				$row_delete = "";
				$row_edit = "";
				$no++;
				$booking_id 		= $veh_book->id;
				$iti_id				= $veh_book->iti_id;
				$customer_name 		= get_customer_name($veh_book->customer_id);
				$booking_type 		= ucfirst($veh_book->booking_type);
				$booking_status		= $veh_book->booking_status;
				
				$row = array();
				$row[] = $no;
				$row[] = $booking_id; 
				$row[] = $iti_id;
				$row[] = $customer_name; 
				$row[] = $booking_type;
				$row[] = $veh_book->dep_date . " - " . $veh_book->arr_date;
				if( $booking_status == 9 ){ 
					$b_stat = "<strong class='green'>Approved</strong>";
				}else if( $booking_status == 8 ){
					$b_stat = "<strong class='red'>Canceled</strong>";
				}else{
					if( $veh_book->is_approved_by_gm == 1 ){
						$b_stat = "<strong class='red'>Pending GM</strong>";	
					}else{
						$b_stat = "<strong class=''>Working</strong>";	
					}
				}	
				$row[] = $b_stat;
				
				/* if( $booking_status	== 9 ){
				$row[] =  '<div class="btn-group btn-toggle" data-toggle="buttons">
						<label class="btn btn-primary active disabled btn-success">
						  <input data-id=' . $booking_id .' value="9" checked="checked" type="radio"> Approved
						</label>
						<label class="btn btn-default update_status btn-danger">
						  <input data-id=' . $booking_id .' value="0" type="radio"> Decline
						</label>
					</div>';
				}else{
					$row[] =  '<div class="btn-group btn-toggle" data-toggle="buttons">
						<label class="btn btn-primary update_status btn-success">
						  <input data-id=' . $booking_id .' value="9" type="radio"> Approve
						</label>
						<label class="btn btn-default active disabled btn-danger">
						  <input data-id=' . $booking_id .' value="0" checked="checked" type="radio"> Declined
						</label>
					</div>';
				} */
				
				//if( is_admin() || is_gm() ){ 
				//}
				
				if( ( $role == 97 && $veh_book->is_approved_by_gm == 0 ) || is_gm() || $role == 99  ){
					$row_delete = "<a data-id={$booking_id} title='Delete Vehicle Booking' href='javascript:void(0)' class='btn_trash ajax_delete_booking'><i class='fa fa-trash-o' aria-hidden='true'></i></a>";
					$row_edit = "<a title='Edit' href=" . site_url("vehiclesbooking/editvtf/{$booking_id}/{$iti_id}") . " class='btn_pencil' ><i class='fa fa-pencil' aria-hidden='true'></i></a>";
				}	
				
				//UPDATE AND APPROVE TICKETS BUTTON
				if( $veh_book->is_approved_by_gm == 2 && $veh_book->booking_status != 8  ){
					$row_edit .= "<a title='Edit' href=" . site_url("vehiclesbooking/update_vtf_tickets/{$booking_id}") . " class='btn_pencil' ><i class='fa fa-refresh' aria-hidden='true'></i> Update Tickets</a>";
				}
				
				$row[] = "<a title='Edit' href=" . site_url("vehiclesbooking/viewvehiclebooking/{$booking_id}/{$iti_id}") . " class='btn_eye' ><i class='fa fa-eye' aria-hidden='true'></i></a>" . $row_edit . $row_delete;
			
				$data[] = $row;
			}
		}	
		
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->vehiclesbooking_model->count_all_vol($where),
			"recordsFiltered" => $this->vehiclesbooking_model->count_filtered_vol($where),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}
	
	
	/****************** Cab Booking start here ******************/
	public function ajax_book_cab(){
		$cab_rate 	= $this->input->post('inp[cab_rate]');	
		$total_cost = $this->input->post('inp[total_cost]');	
		$total_cabs = $this->input->post('inp[total_cabs]');
		
		if( !is_numeric($cab_rate) || empty($cab_rate)){
			$res = array('status' => false, 'msg' => "Failed! $cab_rate Please select other Cab category or Contact Administrator/Manager.");
			die(json_encode($res));
		}
		if( !is_numeric($total_cost) || empty($total_cost)){
			$res = array('status' => false, 'msg' => "Failed! Please Calculate Total cost(click on calculate ).");
			die(json_encode($res));
		}
		if( !is_numeric($total_cabs) || empty($total_cabs) ){
			$res = array('status' => false, 'msg' => "Failed! Select Cabs.");
			die(json_encode($res));
		}
		if( isset($_POST['inp']['cab_id']) && !empty($_POST["inp"]["transporter_id"])){
			$data = $this->input->post("inp", TRUE);
			
			//strip tags from input
			foreach( $data as $key=>$val ){
				$data[$key] = strip_tags($val); 
			}
			
			//if admin or manager approved booking
			$is_approved_by_gm	= is_admin_or_manager() ? 2 : 0;
			$data["is_approved_by_gm"] = strip_tags($is_approved_by_gm);
			
			$book_id = $this->global_model->insert_data("cab_booking", $data);
			if( $book_id ){
				$this->session->set_flashdata('success',"Cab Booking Add successfully.");
				$res = array('status' => true, 'msg' => "Cab Booking add successfully!", "booking_id" => $book_id );
			}else{
				$res = array('status' => false, 'msg' => "Failed! Please try again later.");
			}
			die(json_encode($res));
		}
	}
	//Edit cab booking
	public function update_cab_booking(){
		$id = $this->input->post('booking_id');	
		if( empty($id) && !is_numeric($id) ){
			$res = array('status' => false, 'msg' => "Failed! Please try again later.");
			die(json_encode($res));
		}else{
			$data = $this->input->post("inp", TRUE);
			//strip tags from input
			foreach( $data as $key=>$val ){
				$data[$key] = strip_tags($val); 
			}
			
			//CHECK IF APPROVED BY GM
			/* if( isset( $_POST['approve_pending'] ) && $_POST['approve_pending'] == 1 ){
				$check_old_price = $this->global_model->getdata("cab_booking", array("id" => $id ) );
				$data['cab_rate_old_by_agent'] = $check_old_price[0]->cab_rate;
				$data['is_approved_by_gm'] = 2;
				$iti_id = $check_old_price[0]->iti_id;
				$customer_id = $check_old_price[0]->customer_id;
				$agent_id = $check_old_price[0]->agent_id;
				
				//SEND MAIL TO HOTEL TEAM
				$hotel_booking_email = get_cab_team_email();
				$admins 		= array( $hotel_booking_email );
				//sent mail to agent after price updated
				$link = "<a class='btn btn-success' target='_blank' href=" . site_url("vehiclesbooking/viewbooking/{$id}") . " title='View'>Click to view Booking</a>";					
				$sub 			= "Cab Booking Quotation Approved By GM <Trackitinerary.org>";
				$msg 			= "Cab booking quotation approved by GM. Now you can send this booking to transporter for confirmation.<br>";
				$msg 			.= "Itinerary Id: {$iti_id} <br>";
				$msg 			.= "{$link}<br>";
				//send mail to manager 
				$sent_mail_admins	 = sendEmail($admins, $sub, $msg);
				
				//NOTIFICATION TO SERVICE TEAM
				$title 		= "Cab Quotation Approved";
				$c_date 	= current_datetime();
				$notif_time = date("Y-m-d H:i:s", strtotime( $c_date . " +5 minutes") );
				$body 		= "Cab Booking Quotation Approved By GM";
				$notif_link = "vehiclesbooking/viewbooking/{$id}";
				$notification_data = array(
					"customer_id"		=> $customer_id,
					"notification_for"	=> 97, //97 = service team
					"title"				=> $title,
					"body"				=> $body,
					"url"				=> $notif_link,
					"notification_time"	=> $notif_time,
					"agent_id"			=> $agent_id,
				);
				$this->global_model->insert_data( "notifications", $notification_data );
				//end  notification
			} */
			
			$where = array("id" => $id);
			$result = $this->global_model->update_data("cab_booking", $where, $data);
			if( $result ){
				$this->session->set_flashdata('success',"Cab Booking Updated successfully.");
				$res = array('status' => true, 'msg' => "Cab Booking Update successfully!");
			}else{
				$res = array('status' => false, 'msg' => "Failed! Please try again later.");
			}
			die(json_encode($res));
		}
	}
	
	//Cancel Cab Booking
	public function cancel_cab_booking(){
		$user = $this->session->userdata('logged_in');
		$user_id = $user['user_id'];
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '97'){
			$id 			= $this->input->post("id", TRUE);
			$subject		= strip_tags( $this->input->post("subject", true) );
			$trans_emails 	= strip_tags( $this->input->post("trans_emails", true) );
			
			$where = array( 'id' => $id);
			$cab_booking = $this->global_model->getdata( 'cab_booking', $where );
			$data['cab_booking'] = $cab_booking;
			
			//Check if hotel Email is empty
			if( empty( $trans_emails ) ){
				$res = array('status' => false, 'msg' => "Transporter Email Id Does Not Exists Or Invalid.");
				die( json_encode($res) );
			}
			
			//get message template
			$message = $this->load->view("vehiclesbooking/cab/mail_cancel_cab_booking", $data, TRUE);
			
			//Get admin emails
			$admin_email = admin_email();
			$manager_email = manager_email();
			
			$bccEmails = array($admin_email, $manager_email);
			$sent_mail = sendEmail($trans_emails, $subject, $message, $bccEmails); 
			
			$where = array("id" => $id );
			//7=cancel booking
			$update_d = $this->global_model->update_data("cab_booking", $where, array("booking_status" => 7 ) );
			if( $update_d){
				$this->session->set_flashdata('success',"Booking Cancel Mail Sent Successfully.");
				$res = array('status' => true, 'msg' => "Booking Cancel Successfully" );
			}else{
				$res = array('status' => false, 'msg' => "Error! please try again later");
			}
		}else{
			$res = array('status' => false, 'msg' => "Error! Invalid Request!");
		}
		die(json_encode($res));
	}
	
	//Update cancel status cab
	public function ajax_update_cancelstatus(){
		$id = $this->input->get('id');	
		if( empty($id) && !is_numeric($id) ){
			$res = array('status' => false, 'msg' => "Failed! Please try again later.");
			die(json_encode($res));
		}else{
			$data = array("booking_status" => 7);
			$where = array("id" => $id);
			$result = $this->global_model->update_data("cab_booking", $where, $data);
			if( $result ){
				$this->session->set_flashdata('success',"Cab Booking Cancel successfully.");
				$res = array('status' => true, 'msg' => "Cab Booking Update successfully!");
			}else{
				$res = array('status' => false, 'msg' => "Failed! Please try again later.");
			}
			die(json_encode($res));
		}
	}
	
	/* Sent Cab Email */
	public function sentcabbooking(){
		$user = $this->session->userdata('logged_in');
		$user_id = $user['user_id'];
		$id 			= $this->input->post("id", true);
		$trans_emails 	= strip_tags( $this->input->post("trans_emails", true) );
		$subject 		= strip_tags( $this->input->post("subject", true) );
		
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '97'){
			$where = array( 'id' => $id);
			$cab_booking = $this->global_model->getdata( 'cab_booking', $where );
			if( $cab_booking  ){
				$data['cab_booking'] = $cab_booking;
				$cab_book = $cab_booking[0];
				
				//Get Customer Information 
				$cust_info = get_customer($cab_book->customer_id);
				$customer_name	 = !empty($cust_info) ? $cust_info[0]->customer_name : "";
				$customer_contact	 = !empty($cust_info) ? $cust_info[0]->customer_contact : "";
				
				//Get Transporter Information 
				$transporter = get_transporter_details( $cab_book->transporter_id );
				$tran_name = !empty($transporter) ? $transporter[0]->trans_name : "";
				$trans_email = !empty($transporter) ? $transporter[0]->trans_email : "";
				$trans_contact = !empty($transporter) ? $transporter[0]->trans_contact : "";
				
				//Check if hotel Email is empty
				if( empty( $trans_emails ) ){
					$res = array('status' => false, 'msg' => "Transporter Email Id Does Not Exists Or Invalid.");
					die( json_encode($res) );
				}
				
				//get message template
				$message = $this->load->view("vehiclesbooking/cab/mail_cab", $data, TRUE);
				
				/* Get admin emails */
				$admin_email = admin_email();
				$manager_email = manager_email();
				
				$bccEmails = array($admin_email, $manager_email);
				$sent_mail = sendEmail($trans_emails, $subject, $message, $bccEmails);
				if( $sent_mail ){
					/* send msg for transporter on vehicle booking */
					$mobile_transporter_sms = "Dear {$tran_name}, Vehicle booking email send to your email {$trans_emails}. If you not receive email in your inbox please find the mail in spam. Thanks <Track Itinerary pvt. ltd.>";
					if( !empty( $trans_contact ) ){
						$sendtras_sms = pm_send_sms( $trans_contact, $mobile_transporter_sms );
					}
					
					//Get total email sent to current itinerary 
					$count_email = empty( $cab_book->email_count ) ? 0 : $cab_book->email_count;
					$email_inc = $count_email+1;
					
					//update Email count status 
					$up_data = array(
						'email_count' => $email_inc,
					);
					
					$this->global_model->update_data( "cab_booking", $where, $up_data ); 
					
					$res = array('status' => true, 'msg' => "Cab Booking Mail Sent Successfully!");
				}else{
					$res = array('status' => true, 'msg' => "Mail Not Sent. Please Try Again Later.");
				}
			}else{
				$res = array('status' => false, 'msg' => "No cab booking found.");
			}	
			die( json_encode($res) );
		}else{
			redirect(404);
		}
	}
	
	
	
	//pending CAB confirmation request for manager 
	function pending_confirmation_request(){
		$user = $this->session->userdata('logged_in');
		if( $user['role'] == 99 || is_gm() ){
			$where = array( 'is_approved_by_gm' => 1, 'del_status' => 0, 'booking_status' => 0 );
			$data['cab_booking'] = $this->global_model->getdata( 'cab_booking', $where , "", "id");
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('vehiclesbooking/cab/pending_bookings', $data);
			$this->load->view('inc/footer');
		}else{
			redirect("404");
		}	
	}
	
	//pending volvo train flight ticket confirmation by gm
	function pending_vtf_confirmation_request(){
		$user = $this->session->userdata('logged_in');
		if( $user['role'] == 99 || is_gm() ){
			$where = array( 'is_approved_by_gm' => 1, 'del_status' => 0, 'booking_status' => 0 );
			$data['cab_booking'] = $this->global_model->getdata( 'travel_booking', $where , "", "id");
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('vehiclesbooking/pending_vtf_bookings', $data);
			$this->load->view('inc/footer');
		}else{
			redirect("404");
		}	
	}
	
	//sent request to GM
	public function ajax_send_quotaion_to_gm(){
		$id = $this->input->post('id');
		if( empty($id) && !is_numeric($id) ){
			$res = array('status' => false, 'msg' => "Failed! Please try again later.");
			die(json_encode($res));
		}else{
			$get_booking_data = $this->global_model->getdata("cab_booking", array("id" => $id ) );
			$iti_id = $get_booking_data[0]->iti_id;
			$lead_id = $get_booking_data[0]->customer_id;
			
			//SEND MAIL TO GM
			$gm_email 	= get_gm_email();
			$admins 	= array( $gm_email );
			//sent mail to agent after price updated
			$link = "<a class='btn btn-success' target='_blank' href=" . site_url("vehiclesbooking/viewbooking/{$id}") . " title='View'>Click to view Booking</a>";					
			$sub 			= "New cab booking quotation request.<Trackitinerary.org>";
			$msg 			= "Cab booking quotation approval request sent by agent. Please review quotation by click on below link and confirm.<br>";
			$msg 			.= "Itinerary Id: {$iti_id} <br>";
			$msg 			.= "Lead Id: {$lead_id} <br>";
			$msg 			.= "{$link}<br>";
			//send mail to manager 
			$sent_mail_admins	 = sendEmail($admins, $sub, $msg);
			
			$data = array("is_approved_by_gm" => 1 );
			$where = array("id" => $id);
			$result = $this->global_model->update_data("cab_booking", $where, $data);
			if( $result ){
				$this->session->set_flashdata('success',"Cab Booking Quotation sent successfully to GM.");
				$res = array('status' => true, 'msg' => "Cab Booking not sent successfully!");
			}else{
				$res = array('status' => false, 'msg' => "Failed! Please try again later.");
			}
			die(json_encode($res));
		}	
	}
	
	 
	//sent request to GM
	public function ajax_send_volvo_quotation_to_gm(){
		$id = $this->input->post('id');
		if( empty($id) && !is_numeric($id) ){
			$res = array('status' => false, 'msg' => "Failed! Please try again later.");
			die(json_encode($res));
		}else{
			
			$get_booking_data = $this->global_model->getdata("travel_booking", array( "id" => $id ) );
			$iti_id 		= $get_booking_data[0]->iti_id;
			$lead_id 		= $get_booking_data[0]->customer_id;
			$booking_type 	= $get_booking_data[0]->booking_type;
			
			//SEND MAIL TO GM
			$gm_email 	= get_gm_email();
			$admins 	= array( $gm_email );
			
			//sent mail to agent after price updated
			$link = "<a class='btn btn-success' target='_blank' href=" . site_url("vehiclesbooking/viewvehiclebooking/{$id}/{$iti_id}") . " title='View'>Click to view Booking</a>";					
			$sub 			= "New {$booking_type} booking quotation request.<trackitineray.org>";
			$msg 			= "{$booking_type} booking quotation approval request sent by agent. Please review quotation by click on below link and confirm.<br>";
			$msg 			.= "Itinerary Id: {$iti_id} <br>";
			$msg 			.= "Lead Id: {$lead_id} <br>";
			$msg 			.= "{$link}<br>";
			
			//send mail to manager 
			$sent_mail_admins	 = sendEmail($admins, $sub, $msg);
			$data = array("is_approved_by_gm" => 1 );
			$where = array("id" => $id);
			$result = $this->global_model->update_data("travel_booking", $where, $data);
			if( $result ){
				$this->session->set_flashdata('success',"{$booking_type} Booking Quotation sent successfully to GM.");
				$res = array('status' => true, 'msg' => "{$booking_type} Booking not sent successfully!");
			}else{
				$res = array('status' => false, 'msg' => "Failed! Please try again later.");
			}
			die(json_encode($res));
		}	
	}
	
	
	//update_vtf_tickets
	public function update_vtf_tickets(){
		$booking_id = $this->uri->segment(3);
		$user = $this->session->userdata('logged_in');
		$user_id = $user['user_id'];
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '97' ){
			$where = array( 'id' => $booking_id , 'is_approved_by_gm' => 2 );
			//$where = array( 'id' => $booking_id );
			$data['travel_booking'] = $this->global_model->getdata( 'travel_booking', $where );
			$data['vtf_booking_docs'] = $this->global_model->getdata( 'vtf_booking_docs', array("booking_id" => $booking_id ) );

			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('vehiclesbooking/update_vtf_tickets', $data);
			$this->load->view('inc/footer');
		}
		/*elseif($user['role'] == '97'){
			$where = array( 'id' => $booking_id , 'iti_id' => $iti_id, 'agent_id' => $user_id );
			$data['travel_booking'] = $this->global_model->getdata( 'travel_booking', $where );
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('vehiclesbooking/edit_vtf_booking', $data);
			$this->load->view('inc/footer');
		} */
		else{
			redirect(404);
		}
	
	}
	
	public function ajax_update_ticket_vtf(){
		$user = $this->session->userdata('logged_in');
		$user_id = $user['user_id'];
		if ( isset($_POST['inp']['t_name']) && !empty($_POST['inp']['dep_date']) ) {
			$id 	= $_POST['inp']['id'];
			$iti_id = $_POST['inp']['iti_id'];
			$inp = $this->input->post('inp', TRUE);
			//update doc path
			$doc_path =  dirname($_SERVER["SCRIPT_FILENAME"]) . '/site/assets/client_tickets_docs/'. date("Y") . '/' . date("m") . '/'  . $iti_id . '/'; 
			//upload file section
			$upload_docs_data = array();
			if( isset( $_FILES['iti_clients_docs']['name'] ) && !empty( $_FILES['iti_clients_docs']['name'] ) && file_exists($_FILES['iti_clients_docs']['tmp_name'][0]) ){
				$filesCount = count($_FILES['iti_clients_docs']['name']);
				//	echo $filesCount;
				//check if path exists
				if(!is_dir($doc_path)){
					if (!mkdir($doc_path, 0777, true)) {
						//return false;
						$res = array('status' => false, 'msg' => "File not uploaded. Please contact administrator.");
						die( json_encode($res) );
					}
				}
				
				$title = $iti_id;
				$upload_files = $this->pm_upload_files($doc_path, "client_docs_{$title}", $_FILES['iti_clients_docs'] );
				if( !$upload_files ){
					$res = array('status' => false, 'msg' => "File not uploaded. Please select valid file format(jpg|jpeg|png|pdf).");
					die( json_encode($res) );
				}
				$file_prefix = date("Y") . "/".  date("m") . "/" . $iti_id . "/";
				foreach( $upload_files as $ind=>$file){
					$upload_docs_data[$ind]['file_url'] 	= $file_prefix . $file;
					$upload_docs_data[$ind]['description']	= isset( $_POST['description'][$ind] ) ? $_POST['description'][$ind] : "";
					$upload_docs_data[$ind]['iti_id'] 		= $iti_id;
					$upload_docs_data[$ind]['booking_id']	= $id;
					$upload_docs_data[$ind]['agent_id'] 	= $user_id;
				}
			}
			
			//insert client docs
			if( !empty( $upload_docs_data ) ){
				$this->global_model->insert_batch_data("vtf_booking_docs", $upload_docs_data );
			}
			
			//approve status
			$inp['booking_status'] = 9;
			
			$where = array("id" => $id );
			$booking_id = $this->global_model->update_data("travel_booking", $where, $inp);
			if( $booking_id){
				$this->session->set_flashdata('success',"Booking updated Successfully.");
				$res = array('status' => true, 'msg' => "Booking Details Edit Successfully", "booking_id" => $booking_id );
			}else{
				$res = array('status' => false, 'msg' => "Error! please try again later");
			}
		}else{
			$res = array('status' => false, 'msg' => "Error! Please fill all fields!");
		}
		die(json_encode($res));
	}
	
	//upload multiple files
	private function pm_upload_files($path, $title, $files ){
		
        $config = array(
            'upload_path'   => $path,
            'allowed_types' => 'jpg|jpeg|png|pdf',
            'overwrite'     => 1,                       
        );
		
        $this->load->library('upload', $config);
        $images = array();
        foreach ($files['name'] as $key => $image) {
            $_FILES['images[]']['name']= $files['name'][$key];
            $_FILES['images[]']['type']= $files['type'][$key];
            $_FILES['images[]']['tmp_name']= $files['tmp_name'][$key];
            $_FILES['images[]']['error']= $files['error'][$key];
            $_FILES['images[]']['size']= $files['size'][$key];
			$rand_key = time();
            $fileName = $title . '_' . $rand_key . '_' . $image;
			$fileName = str_replace(' ', '_', $fileName);
            $config['file_name'] = $fileName;
            $this->upload->initialize($config);

            if ($this->upload->do_upload('images[]')) {
				$data 		= $this->upload->data();
				$images[] 	=  $data['file_name'];
            } else {
                return false;
            }
        }
        return $images;
    }
	
	//delete clients documents
	public function delete_docs(){
		$id = $this->input->post('id');
		$where = array( "id" => $id );
		$image_name = $this->global_model->getdata( "vtf_booking_docs", $where, "file_url" );
		$path = FCPATH .'site/assets/client_tickets_docs/' . $image_name;
		$result = $this->global_model->delete_data( "vtf_booking_docs", $where );
		if( $result){
			if (file_exists($path)) {
				unlink($path);
			}
			$res = array('status' => true, 'msg' => "docs delete Successfully!");
		}else{
			$res = array('status' => false, 'msg' => "Error! please try again later");
		}
		die(json_encode($res));
	}
	
}	

?>