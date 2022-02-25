<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Itineraries extends CI_Controller {
	public function __Construct(){
	   	parent::__Construct();
		validate_login();
		$this->load->model("customer_model");
		$this->load->model("itinerary_model");
	}
	
	//update itineraries temp date
	/* public function update_temp_date(){
		ini_set('max_execution_time', 10000);
		$all_iti = $this->global_model->getdata("itinerary", array( "iti_type" => 1, "del_status" => 0, "daywise_meta !=" => "" , "iti_id >=" => 15000 ) );
		//$all_iti = $this->global_model->getdata("itinerary", array( "iti_type" => 1, "del_status" => 0, "daywise_meta !=" => "" , "iti_id >=" => 10500, "iti_id <=" => 15000 ) );
		
		//dump( $all_iti ); die;
		
		foreach( $all_iti as $iti ){
			$iti_id = $iti->iti_id;
			$day_wise_meta = !empty( $iti->daywise_meta ) ? unserialize($iti->daywise_meta) : "";
			//$temp_t_d = !empty( $day_wise_meta ) && isset( $day_wise_meta[0]['tour_date'] ) ? $day_wise_meta[0]['tour_date'] : "";
			
			$temp_t_d = "";
			if(!empty( $day_wise_meta ) && isset( $day_wise_meta[0]['tour_date'] ) ){
				$end_d = end($day_wise_meta);
				$temp_t_d  = $end_d['tour_date'];
			} 
			
			if( !empty( $temp_t_d ) ){
				$this->db->where('iti_id', $iti_id);
				$this->db->update('itinerary',["t_end_date" => $temp_t_d]);				
			}
			
			echo "ITI_ID " . $iti_id . "\n";
			echo "Temp_date " . $temp_t_d . "    ";
			echo "Temp Date " . $iti->t_end_date . "<br>";
		}
	} */
	
	public function index(){
		$user = $this->session->userdata('logged_in');
		$user_id = $user["user_id"];
		$data['user_role'] 	= $user['role'];
		$data['user_id'] 	= $user['user_id'];
		if( $user['role'] == 99 || $user['role'] == 98 || $user['role'] == 97 || $user['role'] == 96 ){
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('itineraries/all_iti', $data);
			$this->load->view('inc/footer'); 
		}else if( $user['role'] == 95 ){
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('itineraries/all_declined_iti', $data);
			$this->load->view('inc/footer'); 
		}else if( $user['role'] == 93 ){ //93 = account team
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('itineraries/all_iti_accountsteam', $data);
			$this->load->view('inc/footer'); 
		}else{
			redirect(404);
		} 
	}

	public function confirmiti(){
		$user = $this->session->userdata('logged_in');
		$user_id = $user["user_id"];
		$data['user_role'] 	= $user['role'];
		$data['user_id'] 	= $user['user_id'];
		if( $user['role'] == 99 || $user['role'] == 98 || $user['role'] == 97 ){
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('itineraries/confirm_iti', $data);
			$this->load->view('inc/footer'); 
		}else{
			redirect(404);
		} 
	}
	public function revisediti(){
		$user = $this->session->userdata('logged_in');
		$user_id = $user["user_id"];
		$data['user_role'] 	= $user['role'];
		$data['user_id'] 	= $user['user_id'];
		if( $user['role'] == 99 || $user['role'] == 98 || $user['role'] == 97 ){
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('itineraries/revisediti', $data);
			$this->load->view('inc/footer'); 
		}else{
			redirect(404);
		} 
	}
	
	//add Itinerary
	public function add(){ 
		$user = $this->session->userdata('logged_in');
		$data["user_role"] = $user['role']; 
		$data["user_id"] = $user['user_id'];
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '96'){
			$req_id = $this->uri->segment(3);
			$temp_key = $this->uri->segment(4);
			$customer_id = trim($req_id);
			$chkIti = $this->global_model->getdata("itinerary", array("customer_id" =>  $customer_id, "del_status" => 0, "iti_type" => 1 ) );
			if( empty( $chkIti ) ){
				
				//get customer data  
				$where = array("customer_id" => $customer_id,"temp_key" => $temp_key, 'del_status' => 0);
				$get_cus = $this->customer_model->getdata( "customers_inquery", $where );
				
				//if customer exists
				if( $get_cus ){
					//create temp key for itinerary
					$rand = getTokenKey(8); 
					$date = date("Ymd"); 
					$time = time(); 
					$unique_key = $rand . "_" . $date . "_" . $time;
					
					$insert_data = array(
						'customer_id'		=> $customer_id,
						'package_routing' 	=> isset($get_cus[0]->destination) ? $get_cus[0]->destination : "",
						'adults' 			=> isset($get_cus[0]->adults) ? $get_cus[0]->adults : "",
						'child'				=> isset($get_cus[0]->child) ? $get_cus[0]->child : "",
						'child_age' 		=> isset($get_cus[0]->child_age) ? $get_cus[0]->child_age : "",
						'cab_category' 		=> isset($get_cus[0]->car_type_sightseen) ? $get_cus[0]->car_type_sightseen : "",
						'agent_id' 			=> isset($get_cus[0]->agent_id) ? $get_cus[0]->agent_id : $user['user_id'],
						'lead_created' 		=> isset($get_cus[0]->created) ? $get_cus[0]->created : date('Y-m-d'),
						'temp_key' 			=> $unique_key,
						'iti_type' 			=> 1, // 1 = holidays
					);
					
					$insert_iti = $this->global_model->insert_data('itinerary', $insert_data);
					if( $insert_iti ){
						redirect("itineraries/edit/{$insert_iti}/{$unique_key}");
					}else{
						echo "SOMETHING WENT WRONG. PLEASE TRY AGAIN!";
					}
				}else{
					redirect(404);
				}
			}else{
				$iti_id = $chkIti[0]->iti_id;
				$temp_key = $chkIti[0]->temp_key;
				redirect("itineraries/edit/{$iti_id}/{$temp_key}");
				//echo "Itinerary Already Created against this customer Id. Please check in itineraries section.";
			}	
		}else{
			redirect("dashboard");
		}
	}
	
	/* add_accommodation Itinerary */
	public function add_accommodation(){
		$user = $this->session->userdata('logged_in');
		$data["user_role"] = $user['role']; 
		$data["user_id"] = $user['user_id']; 
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '96'){
			$req_id = $this->uri->segment(3);
			$temp_key = $this->uri->segment(4);
			$customer_id = trim($req_id);
			$chkIti = $this->global_model->getdata("itinerary", array("customer_id" =>  $customer_id, "del_status" => 0, "iti_type" => 2 ) );
			if( empty( $chkIti ) ){ 
				//get customer data
				$where = array("customer_id" => $customer_id,"temp_key" => $temp_key, 'del_status' => 0);
				$get_cus = $this->customer_model->getdata( "customers_inquery", $where );
				if( $get_cus ){
					//create temp key for itinerary
					$rand = getTokenKey(8); 
					$date = date("Ymd"); 
					$time = time(); 
					$unique_key = $rand . "_" . $date . "_" . $time;
					
					$insert_data = array(
						'customer_id'		=> $customer_id,
						'adults' 			=> isset($get_cus[0]->adults) ? $get_cus[0]->adults : "",
						'child'				=> isset($get_cus[0]->child) ? $get_cus[0]->child : "",
						'child_age' 		=> isset($get_cus[0]->child_age) ? $get_cus[0]->child_age : "",
						'agent_id' 			=> isset($get_cus[0]->agent_id) ? $get_cus[0]->agent_id : $user['user_id'],
						'lead_created' 		=> isset($get_cus[0]->created) ? $get_cus[0]->created : date('Y-m-d'),
						'temp_key' 			=> $unique_key,
						'iti_type' 			=> 2, // 1 = accommodation
					);
					
					$insert_iti = $this->global_model->insert_data('itinerary', $insert_data);
					if( $insert_iti ){
						redirect("itineraries/edit/{$insert_iti}/{$unique_key}");
					}else{
						echo "SOMETHING WENT WRONG. PLEASE TRY AGAIN!";
					}
				}else{
					redirect(404);
				}
			}else{
				$iti_id = $chkIti[0]->iti_id;
				$temp_key = $chkIti[0]->temp_key;
				redirect("itineraries/edit/{$iti_id}/{$temp_key}");
				//echo "Itinerary Already Created against this customer Id. Please check in itineraries section.";
			}	
		}else{
			redirect("dashboard");
		}
	}
	
	/* View Itinerary */
	public function view_iti(){
		$iti_id = trim($this->uri->segment(3));
		$temp_key = trim($this->uri->segment(4));
		if( !empty( $iti_id ) && !empty( $temp_key ) ){
			$user = $this->session->userdata('logged_in');
			$user_id = $user['user_id'];
			$data["user_role"] = $user['role']; 
			$data["user_id"] = $user['user_id']; 
			
			//get itinerary follow up data
			/* $where = array( "iti_id" => $iti_id );
			$followUpData = $this->global_model->getdata("iti_followup", $where, "", "id"); */
			
			//get FolloupData
			$where = array( "parent_iti_id" => $iti_id );
			$orwhere = array( "iti_id" => $iti_id);
			$data["lastFollow"] = $this->itinerary_model->getchildItidata("iti_followup", $where, $orwhere,"iti_id","id", 1 );
			
			//check if itinerary has child itinerary or not
			$get_parent_id = $this->global_model->getdata( 'itinerary', array("iti_id" => $iti_id, "del_status" => 0), "parent_iti_id" );
			if( !empty( $get_parent_id  ) &&  $get_parent_id !== 0 ){
				$data['p_id'] = $get_parent_id;
				$orwhere = array( "iti_id" => $iti_id,"iti_id" => $get_parent_id, "parent_iti_id" => $iti_id, "parent_iti_id" => $get_parent_id );
			}else{	
				$data['p_id'] = "NO";
				$orwhere = array( "iti_id" => $iti_id, "parent_iti_id" => $iti_id);
			}	
			
			//get all followUpData child and parent itineraries
			$where = array();
			$followUpData = $this->itinerary_model->getchildItidata("iti_followup", $where, $orwhere, "", "id");
			
			$where_parent = array("parent_iti_id" => $iti_id, "pending_price !=" => "0" );
			$data['followUpData'] = $followUpData;
			$data["childItinerary"] 	= $this->global_model->getdata("itinerary", $where_parent);
			$data['discountPriceData'] 	= $this->global_model->getdata( 'itinerary_discount_price_data', array("iti_id" => $iti_id, "price_status" => 0) );
			$data['paymentDetails'] 	= $this->global_model->getdata( 'iti_payment_details', array("iti_id" => $iti_id) );
			$data['iti_clients_docs'] 	= $this->global_model->getdata( 'iti_clients_docs', array("iti_id" => $iti_id) );
			$data['countPrice'] = $this->global_model->count_all( 'itinerary_discount_price_data', array("iti_id" => $iti_id) );
			
			//get amendment itineraries if new price is not updated
			$data['amendment_itineraries'] = $this->global_model->getdata( 'iti_amendment_temp', array("iti_id" => $iti_id, "del_status" => 0, "new_package_cost" => "" ) );
			
			//get amendment itineraries if new price is not updated
			$data['old_itineraries'] = $this->global_model->getdata( 'iti_before_amendment', array( "iti_id" => $iti_id ) );
			
			//Get itinerary 
			$where_i = array("del_status" => 0, "iti_id" => $iti_id, "temp_key" => $temp_key);
			$get_iti = $this->global_model->getdata( 'itinerary', $where_i );
			
			//get view folder
			$view_file = !empty( $get_iti ) && $get_iti[0]->iti_type == 2  ? "accommodation/view_followup" : "itineraries/view_iti";
			
			if( $user['role'] == '99' || $user['role'] == '98' ){
				//get all child itinerary data
				$where = array("del_status" => 0, "iti_id" => $iti_id, "temp_key" => $temp_key);
				$data['itinerary'] = $get_iti;
				//Check if amendment id exists
				$this->load->view('inc/header');
				$this->load->view('inc/sidebar');
				$this->load->view($view_file, $data);
				$this->load->view('inc/footer');
			}elseif( $user['role'] == '97' ){
				//Get Hotel Booking 
				$data['hotel_bookings']	= $this->global_model->getdata("hotel_booking", array("iti_id" => $iti_id, "del_status" => 0 ));
				$data['cab_bookings']	= $this->global_model->getdata("cab_booking", array("iti_id" => $iti_id, "del_status" => 0 ));
				$data['vtf_bookings']	= $this->global_model->getdata("travel_booking", array("iti_id" => $iti_id, "del_status" => 0 ));
				$where = array("del_status" => 0, "iti_id" => $iti_id, "temp_key" => $temp_key);
				$data['itinerary'] = $this->global_model->getdata( 'itinerary', $where );
				$this->load->view('inc/header');
				$this->load->view('inc/sidebar');
				//Type 2 = accommodation
				if( !empty( $get_iti ) && $get_iti[0]->iti_type == 2 ){
					$this->load->view( 'accommodation/view_followup', $data );
				}else{
					$this->load->view( 'itineraries/view_iti_service', $data );
				}
				$this->load->view('inc/footer');
			}elseif($user['role'] == '96'){
				if( $teammem = is_teamleader() ){
					//$where = array("customer_id" => $customer_id, "agent_id" => $user_id, 'del_status' => 0);
					$where_in = !empty($teammem) ? implode(",", $teammem) : $u_id;
					//$custom_where = "(agent_id = {$user_id} OR agent_id IN ({$where_in}))";
					//$where_d = "customer_id = {$customer_id} AND (agent_id = {$user_id} OR agent_id IN ({$where_in})) AND del_status = 0 AND temp_key = '{$temp_key}'";
					$where = "del_status =0 AND (agent_id = {$user_id} OR agent_id IN ({$where_in})) AND iti_id = '{$iti_id}' AND temp_key = '{$temp_key}' ";
				}else{
					//$where = array("customer_id" => $customer_id, "agent_id" => $user_id, 'del_status' => 0);
					//$where_d = "customer_id = {$customer_id} AND agent_id = {$user_id} AND del_status = 0 AND temp_key = '{$temp_key}'";
					$where = "del_status =0 AND agent_id = {$user_id} AND iti_id = '{$iti_id}' AND temp_key = '{$temp_key}' ";
				}
				
				$data['itinerary'] = $this->global_model->getdata_where( 'itinerary', $where );
				$this->load->view('inc/header');
				$this->load->view('inc/sidebar');
				$this->load->view( $view_file , $data);
				$this->load->view('inc/footer');
			}else{
				redirect("dashboard");
			}	 
		}else{
			redirect(404);
		}	
	}
	/* View Itinerary */
	public function view(){
		$user = $this->session->userdata('logged_in');
		$user_id = $user['user_id'];
		$data["user_id"] = $user_id;
		$data["user_full_name"] = $user["fname"] . " " . $user["lname"];
		$data["user_role"] = $user['role']; 
		$iti_id = trim($this->uri->segment(3));
		$temp_key = trim($this->uri->segment(4));
		if( !empty( $iti_id ) && !empty( $temp_key ) ){
			//get comments
			$data['comments'] = $this->global_model->getdata( 'comments', array("iti_id" => $iti_id));
			$data['flight_details'] = $this->global_model->getdata( "flight_details", array("iti_id" => $iti_id) );
			$data['train_details'] = $this->global_model->getdata( "train_details", array("iti_id" => $iti_id) );
			$data['sec_key'] = md5($this->config->item("encryption_key"));
			
			//Get itinerary 
			$where_i = array("del_status" => 0, "iti_id" => $iti_id, "temp_key" => $temp_key);
			$get_iti = $this->global_model->getdata( 'itinerary', $where_i );
			
			//get view folder
			$view_file = !empty( $get_iti ) && $get_iti[0]->iti_type == 2  ? "accommodation/view" : "itineraries/view";
			
			//get discountPriceData
			$data['discountPriceData'] 	= $this->global_model->getdata( 'itinerary_discount_price_data', array("iti_id" => $iti_id, "price_status" => 0) );
			$data['paymentDetails'] 	= $this->global_model->getdata( 'iti_payment_details', array( "iti_id" => $iti_id ) );
			$data['iti_clients_docs'] 	= $this->global_model->getdata( 'iti_clients_docs', array("iti_id" => $iti_id) );
			
			$data['discount_pending_rates'] 	= $this->global_model->getdata( 'itinerary_discount_price_data', array("iti_id" => $iti_id, "price_status" => 1), "", "id" , $limit = 1 );
			$data['countPrice'] = $this->global_model->count_all( 'itinerary_discount_price_data', array("iti_id" => $iti_id) );
			//Get old itineraries
			$data['old_itineraries'] = $this->global_model->getdata( 'iti_before_amendment', array( "iti_id" => $iti_id ) );
			
			if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '97'){
				$where = array("del_status" => 0, "iti_id" => $iti_id, "temp_key" => $temp_key);
				$data['itinerary'] 	= $this->global_model->getdata( 'itinerary', $where );
				
				//Get Bookings 
				if( isset( $data['itinerary'][0]->iti_status ) && $data['itinerary'][0]->iti_status == 9 ){
					$data['hotel_bookings']	= $this->global_model->getdata("hotel_booking", array("iti_id" => $iti_id, "del_status" => 0, "booking_status" => 9 ));
					$data['cab_bookings']	= $this->global_model->getdata("cab_booking", array("iti_id" => $iti_id, "del_status" => 0 , "booking_status" => 9 ));
					$data['vtf_bookings']	= $this->global_model->getdata("travel_booking", array("iti_id" => $iti_id, "del_status" => 0 , "booking_status" => 9 ));
				}
				
				$this->load->view('inc/header');
				$this->load->view('inc/sidebar');
				$this->load->view($view_file, $data);
				$this->load->view('inc/footer');
				
			}elseif($user['role'] == '96'){
				if( is_teamleader() ){
					$teammem = is_teamleader();
					//$where = array("customer_id" => $customer_id, "agent_id" => $user_id, 'del_status' => 0);
					$where_in = !empty($teammem) ? implode(",", $teammem) : $u_id;
					//$custom_where = "(agent_id = {$user_id} OR agent_id IN ({$where_in}))";
					//$where_d = "customer_id = {$customer_id} AND (agent_id = {$user_id} OR agent_id IN ({$where_in})) AND del_status = 0 AND temp_key = '{$temp_key}'";
					$where = "del_status =0 AND (agent_id = {$user_id} OR agent_id IN ({$where_in})) AND iti_id = '{$iti_id}' AND temp_key = '{$temp_key}' ";
				}else{
					//$where = array("customer_id" => $customer_id, "agent_id" => $user_id, 'del_status' => 0);
					//$where_d = "customer_id = {$customer_id} AND agent_id = {$user_id} AND del_status = 0 AND temp_key = '{$temp_key}'";
					$where = "del_status = 0 AND agent_id = {$user_id} AND iti_id = '{$iti_id}' AND temp_key = '{$temp_key}' ";
				}
				
				//$where = array("del_status" => 0, "agent_id" => $user_id, "iti_id" => $iti_id, "temp_key" => $temp_key );
				//$data['discountPriceData'] 	= $this->global_model->getdata( 'itinerary_discount_price_data', array("iti_id" => $iti_id) );
				//$data['countPrice'] = $this->global_model->count_all( 'itinerary_discount_price_data', array("iti_id" => $iti_id) );
				$data['itinerary'] = $this->global_model->getdata_where( 'itinerary', $where );
				$this->load->view('inc/header');
				$this->load->view('inc/sidebar');
				$this->load->view($view_file, $data);
				$this->load->view('inc/footer');
			}elseif($user['role'] == '95'){
				$where = array("del_status" => 0, "iti_id" => $iti_id, "temp_key" => $temp_key );
				//$data['discountPriceData'] 	= $this->global_model->getdata( 'itinerary_discount_price_data', array("iti_id" => $iti_id) );
				//$data['countPrice'] = $this->global_model->count_all( 'itinerary_discount_price_data', array("iti_id" => $iti_id) );
				$data['itinerary'] = $this->global_model->getdata( 'itinerary', $where );
				$this->load->view('inc/header');
				$this->load->view('inc/sidebar');
				//$this->load->view('itineraries/view_declined', $data);
				
				//Type 2 = accommodation
				if( !empty( $get_iti ) && $get_iti[0]->iti_type == 2 ){
					$this->load->view( 'accommodation/view_declined_acc', $data );
				}else{
					$this->load->view( 'itineraries/view_declined', $data );
				}
				
				$this->load->view('inc/footer');
			}elseif($user['role'] == '93'){
				
				//Get Hotel Booking 
				$data['hotel_bookings']	= $this->global_model->getdata("hotel_booking", array("iti_id" => $iti_id, "del_status" => 0 ));
				$data['cab_bookings']	= $this->global_model->getdata("cab_booking", array("iti_id" => $iti_id, "del_status" => 0 ));
				$data['vtf_bookings']	= $this->global_model->getdata("travel_booking", array("iti_id" => $iti_id, "del_status" => 0 ));
				
				$where = array("del_status" => 0, "iti_id" => $iti_id, "temp_key" => $temp_key );
				$data['itinerary'] = $this->global_model->getdata( 'itinerary', $where );
				$this->load->view('inc/header');
				$this->load->view('inc/sidebar');
				
				//Type 2 = accommodation
				if( !empty( $get_iti ) && $get_iti[0]->iti_type == 2 ){
					$this->load->view( 'accommodation/view_accounts', $data );
				}else{
					$this->load->view( 'itineraries/view_accounts', $data );
				}
				$this->load->view('inc/footer');
			}else{
				redirect("dashboard");
			}	 
		}else{
			redirect(404);
		}	
	}
	
	/* Edit Itinerary */
	public function edit(){
		$iti_id = trim($this->uri->segment(3));
		$temp_key = trim($this->uri->segment(4));
		if( !empty( $iti_id ) && !empty( $temp_key ) ){
			$user = $this->session->userdata('logged_in');
			$user_id = $user['user_id'];
			$data["user_role"] = $user['role']; 
			$data['flight_details'] = $this->global_model->getdata( "flight_details", array("iti_id" => $iti_id) );
			$data['train_details'] = $this->global_model->getdata( "train_details", array("iti_id" => $iti_id) );
			
			//Get itinerary 
			$where_i = array("del_status" => 0, "iti_id" => $iti_id, "temp_key" => $temp_key);
			$get_iti = $this->global_model->getdata( 'itinerary', $where_i );
			
			//get view folder
			$view_file = !empty( $get_iti ) && $get_iti[0]->iti_type == 2  ? "accommodation/edit" : "itineraries/edit";
			
			if( $user['role'] == '99' || $user['role'] == '98'){
				$where = array("del_status" => 0, "iti_id" => $iti_id, "temp_key" => $temp_key );
				$data['itinerary'] = $this->global_model->getdata( "itinerary", $where );
				$this->load->view('inc/header');
				$this->load->view('inc/sidebar');
				$this->load->view($view_file, $data);
				$this->load->view('inc/footer');
			}elseif($user['role'] == '96'){
				//$where = array("del_status" => 0, "iti_id" => $iti_id, "temp_key" => $temp_key, "agent_id" => $user_id );
				if( $teammem = is_teamleader() ){
					//$where = array("customer_id" => $customer_id, "agent_id" => $user_id, 'del_status' => 0);
					$where_in = !empty($teammem) ? implode(",", $teammem) : $u_id;
					//$custom_where = "(agent_id = {$user_id} OR agent_id IN ({$where_in}))";
					//$where_d = "customer_id = {$customer_id} AND (agent_id = {$user_id} OR agent_id IN ({$where_in})) AND del_status = 0 AND temp_key = '{$temp_key}'";
					$where = "del_status =0 AND (agent_id = {$user_id} OR agent_id IN ({$where_in})) AND iti_id = '{$iti_id}' AND temp_key = '{$temp_key}' ";
				}else{
					//$where = array("customer_id" => $customer_id, "agent_id" => $user_id, 'del_status' => 0);
					//$where_d = "customer_id = {$customer_id} AND agent_id = {$user_id} AND del_status = 0 AND temp_key = '{$temp_key}'";
					$where = "del_status =0 AND agent_id = {$user_id} AND iti_id = '{$iti_id}' AND temp_key = '{$temp_key}' ";
				}
				
				$data['itinerary'] = $this->global_model->getdata_where( "itinerary", $where );
				//check for pending price if price update redirect user 
				$pending_price = $data['itinerary'][0]->pending_price;
				if( ( $pending_price != 2 && $pending_price != 4 ) || get_iti_booking_status( $iti_id ) == 3 ){
					//get_iti_booking_status == 3 reject by sale manager
					$this->load->view('inc/header');
					$this->load->view('inc/sidebar');
					$this->load->view($view_file, $data);
					$this->load->view('inc/footer');
				}else{
					redirect("itineraries");
				}
			}else if( $user['role'] == '93'){
				$where = array("del_status" => 0, "iti_id" => $iti_id, "temp_key" => $temp_key, "iti_close_status" => 1 );
				$data['itinerary'] = $this->global_model->getdata( "itinerary", $where );
				$this->load->view('inc/header');
				$this->load->view('inc/sidebar');
				$this->load->view($view_file, $data);
				$this->load->view('inc/footer');
			}else{
				redirect("dashboard");
			}	 
		}else{
			redirect(404);
		}	
	}
	
	/* data table get all Itineraries */
	public function ajax_itinerary_list(){
		$user = $this->session->userdata('logged_in');
		$u_id = $user['user_id'];
		$role = $user['role'];
		$custom_where = "";
		if( $role == '99' || $role == '98' ){
			//condition for quotation sent filter show child iti in list
			if( ( isset( $_POST["quotation"] ) && $_POST["quotation"] == "true" ) || ( trim( $_POST["filter"] ) == "getFollowUp" ) ){
				$where = array("itinerary.publish_status !=" => "draft" , "itinerary.email_count >" => 0, "itinerary.del_status" => 0 );
			}else{
				$where = array("itinerary.publish_status !=" => "draft" , "itinerary.parent_iti_id" => 0, "itinerary.del_status" => 0);
			}	
			
			//Iti type
			if( isset( $_POST["iti_type"] ) && !empty( $_POST["iti_type"] ) )
				$where["itinerary.iti_type"] = $_POST['iti_type'];
			
			//get itineraries by agent
			if( isset( $_POST['agent_id'] ) && !empty( $_POST['agent_id'] ) ){
				$where["itinerary.agent_id"] = $_POST['agent_id'];
			}
		}elseif( $role == '97' ){
			$where = array( "itinerary.publish_status" => "publish" ,  "itinerary.iti_status" => 9, "itinerary.del_status" => 0 );
			//Iti type
			if( isset( $_POST["iti_type"] ) && !empty( $_POST["iti_type"] ) )
				$where["itinerary.iti_type"] = $_POST['iti_type'];

			if( isset( $_POST["confirmiti"] ) ){

			}	
			
		}elseif( $role == '96' ){
			//condition for quotation sent filter
			if( (isset( $_POST["quotation"]) && $_POST["quotation"] == "true" ) || ( trim( $_POST["filter"] ) == "getFollowUp" ) ){
				$where = array( "itinerary.agent_id" => $u_id,"itinerary.email_count >" => 0, "itinerary.del_status" => 0 );
			}else{
				if( $teammem = is_teamleader() ){
					$where = array( "itinerary.parent_iti_id" => 0, "itinerary.del_status" => 0 );
					$where_in = !empty($teammem) ? implode(",", $teammem) : $u_id;
					$custom_where = "(itinerary.agent_id = {$u_id} OR itinerary.agent_id IN ({$where_in}))";
				}else{
					//$where = array("customers_inquery.del_status" => 0, "customers_inquery.agent_id" => $u_id);
					$where = array( "itinerary.agent_id" => $u_id, "itinerary.parent_iti_id" => 0, "itinerary.del_status" => 0 );
				}
			}
			
			//Iti type
			if( isset( $_POST["iti_type"] ) && !empty( $_POST["iti_type"] ) )
				$where["itinerary.iti_type"] = $_POST['iti_type'];
			
			//get itineraries by agent
			if( isset( $_POST['agent_id'] ) && !empty( $_POST['agent_id'] ) ){
				$where["itinerary.agent_id"] = $_POST['agent_id'];
			}
		}
		
		$list = $this->itinerary_model->get_datatables( $where, $custom_where );
		$data = array();
		$no = $_POST['start'];
		if( !empty($list) ){
			foreach ($list as $iti) {
			 	$pub_status = $iti->publish_status;
				$row_delete = $btn_edit="";
				$row_edit = "";
				$btncmt = "";
				$iti_s = "";
				$rev_btn_service = "";
				$amend_btn = "";
				$no++;
				$iti_id = $iti->iti_id;
				$key = $iti->temp_key;
				
				//get discount rate request
				$discount_request = $iti->discount_rate_request;
				$discReq = $discount_request == 1 ? "<strong class='red'> (Price Discount Request) </strong>" : " ";
				
				//Count All Child Itineraries
				$countChildIti = $this->global_model->count_all( 'itinerary', array("parent_iti_id" => $iti_id, "del_status" => 0) );
				$childLink = "<a title='View Child Itineraries' href=" . site_url("itineraries/childIti/{$iti_id}/{$key}") . " class='btn btn-success blue' ><i class='fa fa-child' aria-hidden='true'></i></a>";
				
				$showChildItiBtn = $countChildIti > 0 ? $childLink : "";
				
				//get iti_status
				$iti_status = $iti->iti_status;
				if( $pub_status == "publish" ){
					$p_status = "<strong>" . ucfirst($pub_status) . "</strong>";
				}elseif( $pub_status == "price pending" ){
					$p_status = "<strong class='blue'>" . ucfirst($pub_status) . "</strong>";
				}else{
					$p_status = "<strong class='red'>" . ucfirst($pub_status) . "</strong>";
				}
				//Lead Prospect Hot/Warm/Cold
				$cus_pro_status = get_iti_prospect($iti->iti_id);
				if( $cus_pro_status == "Warm" ){
					$l_pro_status = "<strong class='green'> ( " . $cus_pro_status . " )</strong>";
				}else if( $cus_pro_status == "Hot" ){
					$l_pro_status = "<strong class='black'> ( " . $cus_pro_status . " )</strong>";
				}else if( $cus_pro_status == "Cold" ){
					$l_pro_status = "<strong class='red'> ( " . $cus_pro_status . " )</strong>";
				}else{
					$l_pro_status = "";
				}
				
				//Get itinerary type 1=itinerary , 2=accommodation
				$iti_type = $iti->iti_type == 2 ? "<strong class='red'>Accommodation</strong>" : "<strong class='green'>Holiday</strong>";
				
				// count iti sent status 
				$iti_sent = $iti->email_count;
				$sent_status = $iti_sent > 0 ? "$iti_sent Time Sent" : "Not Sent";
				
				//travel start date
				if( $countChildIti > 0  ){
					$temp_t_d = check_latest_travel_date( $iti->iti_id );	
				}else{
					$temp_t_d = $iti->t_start_date;
				}	
				
				$row = array();
				$row[] = $no;
				$row[] = $iti->iti_id;
		 		$row[] = $iti_type;
				$row[] = $iti->customer_id;
				$row[] = $iti->customer_name;
				$row[] = $iti->customer_contact;
				$row[] = $iti->package_name . $l_pro_status;
				
				//Check temp travel date if publish_status != "draft" iti_type = 1 Itinerary , 2 = accommodation
				/* if( $iti->publish_status != "draft" && $iti->iti_type == 1 ){
					$day_wise_meta = !empty( $iti->daywise_meta ) ? unserialize($iti->daywise_meta) : "";
					$temp_t_d = !empty( $day_wise_meta ) && isset( $day_wise_meta[0]['tour_date'] ) ? $day_wise_meta[0]['tour_date'] : "";
				}else if( $iti->publish_status != "draft" && $iti->iti_type == 2  ){
				} */
				
				$row[] = $temp_t_d;
				//Booked iti travel date
				$row[] = $iti->travel_date;
				//buttons
				//if price is updated remove edit for agent get_iti_booking_status
				if( $iti->pending_price == 2 && $role == 96 ){
					$btn_edit = "<a title='Edit' href='javascript: void(0)' class='btn_pencil editPop' ><i class='fa fa-pencil' aria-hidden='true'></i></a>";
				}else{
					$btn_edit = "<a title='Edit' href=" . site_url("itineraries/edit/{$iti_id}/{$key}") . " class='btn_pencil' ><i class='fa fa-pencil' aria-hidden='true'></i></a>";
				}
				
				$btnview = "<a target='_blank' title='View' href=" . site_url("itineraries/view_iti/{$iti_id}/{$key}") . " class='btn_eye' ><i class='fa fa-eye' aria-hidden='true'></i></a>";
				
				 $btnview .= "<a target='_blank' title='View Pdf' href=" . site_url("itineraries/pdf/{$iti_id}/{$key}") . " class='btn_pdf' ><i class='fa fa-file-pdf-o' aria-hidden='true'></i></a>";
				$btn_view = "";
				// $btn_view = "<a title='client view' target='_blank' href=" . site_url("promotion/itinerary/{$iti_id}/{$key}") . " class='btn btn-success' >Client view New</a>";
				
				//Show if type=1=itinerary
				if( $iti->iti_type == 1 ){
					//$btn_view .= "<a title='client view' target='_blank' href=" . site_url("promotion/package/{$iti_id}/{$key}") . " class='btn btn-success' >Client view</a>";
				}
				
				//clone button
				if( empty( $iti->parent_iti_id ) &&  $countChildIti < 6  && $iti->iti_status == 0  && $iti->email_count > 0 && $pub_status == "publish" ){
					//type 2=accommodation
					if( $iti->iti_type == 2 ){
						$btn_view .= "<a data-customer_id='{$iti->customer_id}' data-iti_id='{$iti_id}' title='Duplicate Accommodation' href=" . site_url("itineraries/duplicate/{$iti_id}") . " class='btn btn-success child_clone' ><i class='fa fa-files-o' aria-hidden='true'></i></a>";
					}else{
						$btn_view .= "<a data-customer_id='{$iti->customer_id}' data-iti_id='{$iti_id}' title='Duplicate Itinerary' href=" . site_url(	"itineraries/duplicate/{$iti_id}") . " class='btn_duplicate duplicateItiBtn' ><i class='fa fa-files-o' aria-hidden='true'></i></a>";
					}	
				}	
				
				if( !empty( $iti->client_comment_status ) && $iti->client_comment_status == 1 ){
					$btncmt = "<a data-id={$iti_id} data-key={$key} title='Client Comment' href='javascript:void(0)' class='btn btn-success ajax_iti_status red'><span class='blink'><i class='fa fa fa-comment-o' aria-hidden='true'></i>  New Comment</span></a>";
				}
				
				//if itinerary status is publish
				if( $pub_status == "publish" || $pub_status == "price pending" ){
					//delete itinerary button only for admin
					if( is_admin_or_manager() && empty( $countChildIti ) ){ 
						$row_delete = "<a data-id={$iti_id} title='Delete Itinerary' href='javascript:void(0)' class='btn_trash ajax_delete_iti'><i class='fa fa-trash-o' aria-hidden='true'></i></a>";
					}
					//Check for iti status
					if( isset( $iti->booking_status ) && $iti->booking_status != 0 ){
						$it_status = "<a title='itinerary booked' class='btn btn-green' title='Itinerary Booked'>Hold</a>";
						$st = "On Hold";
						$iti_s = isset( $iti->booking_status ) && $iti->booking_status == 0 ? "APPROVED" : "ON HOLD";
					}else if( $iti_status == 9 ){
						$it_status ="";
						//$it_status = "<a title='itinerary booked' class='btn btn-green' title='Itinerary Booked'><i class='fa fa-check-circle-o' aria-hidden='true'></i></a>";
						$st = "<i title='itinerary booked' class='fa fa-check-circle-o' aria-hidden='true'></i>";
						$iti_s = "APPROVED";
					}else if( $iti_status == 7 ){
						$it_status = "<a title='itinerary declined' class='btn btn-danger'><i class='fa fa-ban' aria-hidden='true'></i></a>";
						$st = "<i title='itinerary declined' class='fa fa-ban' aria-hidden='true'></i>";
						$iti_s = "DECLINED";
					}else if( $iti_status == 6 ){
						$it_status ="";
						//$it_status = "<a title='Itinerary Rejected' class='btn btn-danger'><i class='fa fa-ban' aria-hidden='true'></i></a>";
						$st = "<span title='Itinerary Rejected' class='badge_danger_pill'>Rejected</span>";
						$iti_s = "REJECTED";
					}else{
						$it_status="";
						$st="";
						//$it_status = "<a title='working...' class='btn btn-success'><i class='fa fa-tasks' aria-hidden='true'></i></a>";
						//$st = "<i title='working...' class='fa fa-tasks' aria-hidden='true'></i>";
						
						//$iti_s = empty( $iti->followup_id ) ? "NOT PROCESS" : "WORKING";
						$iti_s = empty( is_iti_followup_exists( $iti->iti_id ) ) ? "NOT PROCESS" : "WORKING";
					}
					
					//Amendment Btn
					if( ( is_admin_or_manager() || is_salesteam() ) && $iti->is_amendment == 1 ){
						$amendment_id = $this->global_model->getdata( 'iti_amendment_temp', array("iti_id" => $iti_id), "id" );
						$amend_btn = " <a href='" . base_url("itineraries/view_amendment/{$amendment_id}") ."' class='btn btn-success' title='Click to view amendment itinerary'>View Amendment</a>";
						$amend_btn = !empty( $amendment_id ) ? $amend_btn : "";
					}else if( $iti->is_amendment == 2 ){
						$amend_btn = "<span class='btn btn-danger'>Revised</span>";
						$rev_btn_service = "<span class='btn btn-danger'>Revised</span>";
					}
					
					//show only view button for sales team
					if( $role == 97 ){
						//Hotel/cab/volvo book button 
						//check if hotel already booked for current iti
						$book_btn = "";
						
						$where_iti = array("iti_id" => $iti_id);
						$check_hotel_book 	= $this->global_model->getdata("hotel_booking", $where_iti );
						
						//Check if all hotel booking status done
						$voucher_status = $this->global_model->getdata( "iti_vouchers_status", $where_iti);
						
						$check_hotel_status	= !empty($voucher_status) && $voucher_status[0]->hotel_booking_status == 1 ? TRUE : FALSE;
						$h_class = !empty($check_hotel_book) ? "btn-success" : "btn-default";
						//if hotel status empty
						if( !$check_hotel_status ){
							$book_btn .= "<a  title='Book Hotel' href='" . site_url("hotelbooking/add/{$iti_id}") . "' class='btn {$h_class}' ><i class='fa fa-hotel' aria-hidden='true'></i>&nbsp; Book Hotel</a>";
						}
						
						//show book button if holidays package
						if( $iti->iti_type == 1 ){	
							$check_vtf_status	= !empty($voucher_status) && $voucher_status[0]->vtf_booking_status == 1 ? TRUE : FALSE;
							$check_cab_status	= !empty($voucher_status) && $voucher_status[0]->cab_booking_status == 1 ? TRUE : FALSE;
							$check_cab_book 	= $this->global_model->getdata("cab_booking", $where_iti );
							$check_volvo_book 	= $this->global_model->getdata("travel_booking", $where_iti );
							
							$c_class = !empty($check_cab_book) ? "btn-success" : "btn-default";
							$v_class = !empty($check_volvo_book) ? "btn-success" : "btn-default";
					
							if( !$check_cab_status ){
								$book_btn .= "<a  title='Book Vehicles' href='" . site_url("vehiclesbooking/bookcab/{$iti_id}") . "' class='btn {$c_class}' ><i class='fa fa-car' aria-hidden='true'></i>&nbsp; Book Cab</a>";
							}	
							
							if( !$check_vtf_status ){
								$book_btn .= "<a  title='Add details Volvo/Train/Flight' href='" . site_url("vehiclesbooking/addbookingdetails/{$iti_id}?type=volvo") . "' class='btn {$v_class}' ><i class='fa fa-plane' aria-hidden='true'></i>&nbsp; Book VTF</a>";
							}
						}
						
						$row[] = $btnview . $rev_btn_service . $book_btn;
					}else{
						$allBtns = $btncmt. $btn_edit . $btnview. $btn_view . $row_delete . $it_status . $showChildItiBtn;
						$row[] = "<a href='' class='btn btn-success optionToggleBtn'>View</a><div class='optionTogglePanel'>{$allBtns}</div>" . $st . $showChildItiBtn . $amend_btn;
					}	
				}else{ 
					//if itinerary in draft hide buttons for sales team
					$row[] = $btn_edit . "
						<a data-id={$iti_id} title='Delete Itinerary Permanent' href='javascript:void(0)' class='btn_trash delete_iti_permanent'><i class='fa fa-trash-o' aria-hidden='true'></i></a>";
				}	
				//$row[] = $iti->added;
				$row[] = $sent_status;
				$row[] = $p_status . $discReq;
				//if( $role != 96 ){
					$row[] = get_user_name( $iti->agent_id );
				//}
				$row[] = $iti_s;				
				$data[] = $row;
			}
		}


		$output = array(
			"draw"				=> $_POST['draw'],
			"recordsTotal" 		=> $this->itinerary_model->count_all($where, $custom_where),
			"recordsFiltered" 	=> $this->itinerary_model->count_filtered($where, $custom_where),
			"data" 				=> $data,
		);
		//output to json format
		echo json_encode($output);
	}
	
	
	/* data table get all Itineraries accounts */
	public function ajax_itinerary_list_accounts(){
		$user = $this->session->userdata('logged_in');
		$u_id = $user['user_id'];
		$role = $user['role'];
		$custom_where = "";
		$user = $this->session->userdata('logged_in');
		$u_id = $user['user_id'];
		$role = $user['role'];
		$custom_where = "";
		if( $role == '93' ){
			$where = array( "itinerary.publish_status" => "publish" ,  "itinerary.iti_status" => 9, "itinerary.del_status" => 0, "itinerary.iti_close_status" => 0 );
		}else{	
			$where = array( "itinerary.publish_status" => "publish" ,  "itinerary.iti_status" => 9, "itinerary.del_status" => 0 );
		}	
		
		//Iti type
		if( isset( $_POST["iti_type"] ) && !empty( $_POST["iti_type"] ) )
			$where["itinerary.iti_type"] = $_POST['iti_type'];
		
		
		$list = $this->itinerary_model->get_datatables( $where, $custom_where );
		$data = array();
		$no = $_POST['start'];
		if( !empty($list) ){
			foreach ($list as $iti) {
				$no++;
				$iti_id = $iti->iti_id;
				$key = $iti->temp_key;
				
				//Get itinerary type 1=itinerary , 2=accommodation
				if( $iti->iti_type == 2 ){
					$iti_type = "<strong class='red'>Accommodation</strong>";
					$voucher_booking_status = is_hotel_booking_done( $iti->iti_id );
				}else{	
					$iti_type = "<strong class='green'>Holiday</strong>";
					$voucher_booking_status = is_voucher_booking_status_done( $iti->iti_id );
				}
				
				$is_voucher_confirm = is_voucher_confirm( $iti->iti_id );
				
				//voucher_s
				$vs = "<strong class='' title='Processing'><i class='fa fa-refresh'></i></strong>";
				if( $is_voucher_confirm == 1 ){
					$vs = "<strong class='green'><i class='fa fa-check'></i> Confirm</strong>";
				}
				
				if( $voucher_booking_status ){
					$vs = "<strong class='red'>Pending</strong>";
				}
				
				// count iti sent status 
				$iti_sent = $iti->email_count;
				$sent_status = $iti_sent > 0 ? "$iti_sent Time Sent" : "Not Sent"; 
				$row = array();
				$row[] = $no;
				$row[] = $iti->iti_id;
		 		$row[] = $iti_type;
				$row[] = $iti->customer_id;
				$row[] = $iti->customer_name;
				$row[] = $iti->customer_contact;
				$row[] = $iti->package_name;
				
				$temp_t_d = $iti->t_start_date;
				//Booked iti travel date
				$row[] = $iti->travel_date;
				$row[] = !empty($iti->iti_close_status) ? "<strong class='red'>CLOSED</strong>" : "<strong class='green'>OPEN</strong>";
				//buttons
				$btn_view = "<a target='_blank' title='View' href=" . site_url("itineraries/view/{$iti_id}/{$key}") . " class='btn_eye' ><i class='fa fa-eye' aria-hidden='true'></i></a>";
				
				//check if itinerary closed
				$btn_view_receipt = "";
				if( $iti->iti_close_status == 1 ){
					//$btn_view .= "<a title='client view' target='_blank' href=" . site_url("promotion/closeitineraryurl/{$iti_id}/{$key}") . " class='btn btn-danger' >Client view </a>";
				}else{
					//$btn_view .= "<a title='client view' target='_blank' href=" . site_url("promotion/itinerary/{$iti_id}/{$key}") . " class='btn btn-success' >Client view </a>";
					
					$btn_view_receipt = "<a title='Create New Receipt' target='_blank' href=" . site_url("accounts/create_receipt/{$iti->customer_id}") . " class='btn btn-success' ><i class='fa fa-file-alt'></i> New Receipt </a>";
				}
				
				//check if itinerary invoice generate or not 1 = done, 0 = pending
				if( $iti->approved_by_account_team == 0) {
					$btn_view_receipt = "";
					$btn_view .= "<a target='_blank' title='Generate Receipt' href=" . site_url("accounts/create_receipt/{$iti->customer_id}") . " class='btn btn-danger' ><i class='fa fa-plus' aria-hidden='true'></i> Generate First Receipt</a>";
				}
				
				$row[] = $vs;
				$row[] = $btn_view . $btn_view_receipt;
				$row[] = get_user_name( $iti->agent_id );
				$row[] = $temp_t_d;
				$row[] = $sent_status;
				
				$data[] = $row;
			}
		}
		
		$output = array(
			"draw"				=> $_POST['draw'],
			"recordsTotal" 		=> $this->itinerary_model->count_all($where, $custom_where),
			"recordsFiltered" 	=> $this->itinerary_model->count_filtered($where, $custom_where),
			"data" 				=> $data,
		);
		
		//output to json format
		echo json_encode($output);
	}
	
	/* data table get all Declined Itineraries */
	public function ajax_declined_itinerary_list(){
		$user = $this->session->userdata('logged_in');
		$u_id = $user['user_id'];
		$role = $user['role'];
		
		$where = array( "itinerary.iti_status" => 7 );
		//get itineraries by agent
		if( isset( $_POST['agent_id'] ) && !empty( $_POST['agent_id'] ) ){
			$where["itinerary.agent_id"] = $_POST['agent_id'];
		}
		
		$list = $this->itinerary_model->get_datatables($where);
		
		$data = array();
		$no = $_POST['start'];
		if( !empty($list) ){
			foreach ($list as $iti) {
				$pub_status = $iti->publish_status;
				$row_delete = "";
				$row_edit = "";
				$btncmt = "";
				$no++;
				
				//Get customer info
				$get_customer_info = get_customer( $iti->customer_id ); 
				$cust = $get_customer_info[0];
				$c_name = "";
				$c_contact = "";
				if( !empty( $get_customer_info ) ){  
					$c_name = $cust->customer_name;
					$c_contact = $cust->customer_contact;
				} 
				
				/* count iti sent status */
				$iti_sent = $iti->email_count;
				$sent_status = $iti_sent > 0 ? "$iti_sent Time Sent" : "Not Sent";
				$row = array();
				$row[] = $no;
				$row[] = $iti->iti_id;
				$row[] = $iti->iti_type == 2 ? "<strong class='red'>Accommodation</strong>" : "<strong class='green'>Holiday</strong>";;
				$row[] = $iti->customer_id;
				$row[] = $c_name;
				$row[] = $c_contact;
				$row[] = $iti->package_name;
				$row[] = $iti->added;
				$row[] = get_user_name( $iti->agent_id ); 
				$dec_bnt = "<strong class='btn btn-danger'>Declined</strong>";
				
				//buttons
				$row[] =  "<a title='View' target='_blank' href=" . site_url("itineraries/view/{$iti->iti_id}/{$iti->temp_key}") . " class='btn btn-success' ><i class='fa fa-eye' aria-hidden='true'></i></a>" . $dec_bnt;
				
				$data[] = $row;
			}
		}	
		
		$output = array(
			"draw" 				=> $_POST['draw'],
			"recordsTotal" 		=> $this->itinerary_model->count_all($where),
			"recordsFiltered" 	=> $this->itinerary_model->count_filtered($where),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}
	
	//add itinerary
	public function addItinerary(){
		$user = $this->session->userdata('logged_in');
		$role = $user['role'];
		$inc_meta	 = $this->input->post('inc_meta');
		$iti_type	 = $this->input->post('iti_type');
		$h_meta = $this->input->post('hotel_meta');
		if( isset($_POST["package_name"]) && !empty( $inc_meta ) && !empty( $h_meta ) ){
			//Update data 
			$unique_id = trim( $_POST['temp_key'] );
			$where_key = array('temp_key' => $unique_id );
			$get_data = $this->global_model->getdata("itinerary", $where_key);
			$iti_id = $get_data[0]->iti_id;
			$temp_key = $get_data[0]->temp_key;
			$rate_meta = unserialize($get_data[0]->rates_meta);
			
			if( $role == 99 || $role == 98 ){
				$data = array(
					'publish_status' => "publish",
				);
			}else{
				if( empty($rate_meta) ){
					$data = array(
						'publish_status' => "price pending",
					);
				}else{
					$data = array(
						'publish_status' => "publish",
					);
				}	
			}	
			$update_data = $this->global_model->update_data("itinerary", $where_key, $data );
			if( $update_data ){
				$res = array('status' => true, 'msg' => "Itinerary added successfully!", 'iti_id' => $iti_id, 'temp_key' => $temp_key );
			}else{
				$res = array('status' => false, 'msg' => "Failed! Itinerary Not Updated.");
			}
		}else{
			$res = array('status' => false, 'msg' => "Failed! All Fields are required.");
		}
		die(json_encode($res));
	}
	
	//Accommodation Ajax for save value step by step
	//add Package
	public function ajax_acc_savedata_stepwise(){
		$user = $this->session->userdata('logged_in');
		$role = $user['role'];
		
		if( isset($_POST["temp_key"]) && !empty( $_POST['step'] ) ){
			$unique_id 	= trim( $_POST['temp_key'] );
			$step 		= trim( $_POST['step'] );
			
			switch( $step ){
				case 1:  
					$package_name 		= strip_tags($_POST['package_name']);
					$package_routing 	= strip_tags($_POST['package_routing']);
					$adults				= strip_tags($_POST['adults']);
					$child				= strip_tags($_POST['child']);
					$child_age			= strip_tags($_POST['child_age']);
					$customer_id 		= strip_tags($_POST['customer_id']);
					$agent_id 			= strip_tags($_POST['agent_id']);
					$iti_type 	= trim( $_POST['iti_type'] );
					$iti_package_type 	= isset($_POST['iti_package_type']) ? strip_tags($_POST['iti_package_type']) : "";
					
					$step_data = array(
						'package_name' 		=> $package_name,
						'temp_key'			=> $unique_id,
						'package_routing'	=> $package_routing,
						'adults'			=> $adults,
						'child'				=> $child,
						'child_age'			=> $child_age,
						'agent_id'			=> $agent_id,
						'customer_id'		=> $customer_id,
						'iti_type'			=> $iti_type,
						'iti_package_type'	=> $iti_package_type,
					);
				break;
				case 2:
					$startDate 			= strip_tags( $_POST['hotel_startdate'] );
					$endDate			= strip_tags( $_POST['hotel_enddate'] );
					$total_nights		= strip_tags($_POST['package_duration']);
					$hotel_meta 		= serialize($this->input->post('hotel_meta'));
					$hotel_note_meta 	= serialize($this->input->post('hotel_note_meta'));
					$step_data = array(
						't_start_date' 		=> $startDate,
						't_end_date' 		=> $endDate,
						'total_nights' 		=> $total_nights,
						'hotel_meta' 		=> $hotel_meta,
						'hotel_note_meta' 	=> $hotel_note_meta,
					);
				break;
				case 3:
					$inc_meta					= serialize($this->input->post('inc_meta'));
					$exc_meta					= serialize($this->input->post('exc_meta'));
					$special_inc_meta			= serialize($this->input->post('special_inc_meta', TRUE));
					$booking_benefits_meta		= serialize($this->input->post('booking_benefits_meta', TRUE));
					
					//if( is_admin_or_manager() ){
					if ( $role == 99 || is_cost_manager() || is_super_manager() || is_sales_manager() ){
						//2==accommodation
						//save perperson rate meta
						$rate_comment			= isset( $_POST['rate_comment'] ) ? $_POST['rate_comment'] : "";
						$per_person_ratemeta	= isset( $_POST['per_person_ratemeta'] ) ? serialize($this->input->post('per_person_ratemeta')) : "";
						$rate_meta				= isset( $_POST['rate_meta'] ) ? serialize($this->input->post('rate_meta')) : "";
						
						$step_data = array(
							'inc_meta'				=> $inc_meta,
							'exc_meta'				=> $exc_meta,
							'special_inc_meta'		=> $special_inc_meta,
							'rates_meta'			=> $rate_meta,
							'rate_comment'			=> $rate_comment,
							'per_person_ratemeta'	=> $per_person_ratemeta,
							'booking_benefits_meta'	=> $booking_benefits_meta,
						);
						
						if(!empty( $rate_meta ) ){
							$step_data["pending_price"] = 2;
						}
					}else{
						$step_data = array(
							'inc_meta'					=> $inc_meta,
							'exc_meta'					=> $exc_meta,
							'special_inc_meta'			=> $special_inc_meta,
							'booking_benefits_meta'		=> $booking_benefits_meta,
						);
					}	
				break;
			}
			
			//update data
			$where = array('temp_key' => $unique_id );
			$get_data = $this->global_model->getdata("itinerary", $where);
			if( empty( $get_data ) ){
				$step_data['lead_created'] = $this->input->post("lead_created", true);
				//insert if data not get
				$insert_data = $this->global_model->insert_data("itinerary", $step_data );
				if( $insert_data ){
					$res = array('status' => true, 'msg' => "Data save.");
				}else{
					$res = array('status' => false, 'msg' => "Error! Data not save.");
				}
			}else{
				//Update data 
				$where_key = array('temp_key' => $unique_id ); 
				$update_data = $this->global_model->update_data("itinerary", $where_key, $step_data );
				if( $update_data ){
					$res = array('status' => true, 'msg' => "Data save.");
				}else{
					$res = array('status' => false, 'msg' => "Error! Data not save.");
				}
			}
		}else{
			$res = array('status' => false, 'msg' => "Failed! Invalid request try again.");
		}
		die(json_encode($res));
	}
	
	//Accommodation Ajax for save value step by step
	//add Package
	public function ajax_amendment_accommodation_savedata(){
		$user = $this->session->userdata('logged_in');
		$role = $user['role'];
		
		if( isset($_POST["temp_key"]) && !empty( $_POST['step'] ) ){
			$id = trim( $_POST['id'] );
			$unique_id = trim( $_POST['temp_key'] );
			$step 	= trim( $_POST['step'] );
			switch( $step ){
				case 1:  
					$package_name 		= strip_tags($_POST['package_name']);
					$package_routing 	= strip_tags($_POST['package_routing']);
					$adults				= strip_tags($_POST['adults']);
					$child				= strip_tags($_POST['child']);
					$child_age			= strip_tags($_POST['child_age']);
					
					$step_data = array(
						'package_name' 		=> $package_name,
						'temp_key'			=> $unique_id,
						'package_routing'	=> $package_routing,
						'adults'			=> $adults,
						'child'				=> $child,
						'child_age'			=> $child_age,
					);
				break;
				case 2:
					$startDate 			= strip_tags( $_POST['hotel_startdate'] );
					$endDate			= strip_tags( $_POST['hotel_enddate'] );
					$total_nights		= strip_tags($_POST['package_duration']);
					$hotel_meta 		= serialize($this->input->post('hotel_meta'));
					$hotel_note_meta 	= serialize($this->input->post('hotel_note_meta'));
					$step_data = array(
						't_start_date' 		=> $startDate,
						't_end_date' 		=> $endDate,
						'total_nights' 		=> $total_nights,
						'hotel_meta' 		=> $hotel_meta,
						'hotel_note_meta' 	=> $hotel_note_meta,
					);
				break;
				case 3:
					$inc_meta					= serialize($this->input->post('inc_meta'));
					$exc_meta					= serialize($this->input->post('exc_meta'));
					$special_inc_meta			= serialize($this->input->post('special_inc_meta', TRUE));
					$booking_benefits_meta			= serialize($this->input->post('booking_benefits_meta', TRUE));
					$step_data = array(
						'inc_meta'					=> $inc_meta,
						'exc_meta'					=> $exc_meta,
						'special_inc_meta'			=> $special_inc_meta,
						'booking_benefits_meta'			=> $booking_benefits_meta,
					);
				break;
			}
			
			//Update data 
			$where_key = array('id' => $id ); 
			$update_data = $this->global_model->update_data("iti_amendment_temp", $where_key, $step_data );
			
			if( $update_data ){
				$res = array('status' => true, 'msg' => "Data save.");
			}else{
				$res = array('status' => false, 'msg' => "Error! Data not save.");
			}
		}else{
			$res = array('status' => false, 'msg' => "Failed! Invalid request try again.");
		}
		die(json_encode($res));
	}
	
	//Itinerary Ajax for save value step by step
	//add itinerary
	public function ajax_savedata_stepwise(){
		$user = $this->session->userdata('logged_in');
		$role = $user['role'];
		
		if( isset($_POST["temp_key"]) && isset( $_POST['step'] ) ){
			$unique_id = trim( $_POST['temp_key'] );
			$step 	= trim($_POST['step']);
			switch( $step ){
				case 1:  
					$iti_type 			= strip_tags($_POST['iti_type']);
					$package_name 		= strip_tags($_POST['package_name']);
					$quatation_date 	= strip_tags($_POST['quatation_date']);
					$package_routing 	= strip_tags($_POST['package_routing']);
					$adults				= strip_tags($_POST['adults']);
					$child				= strip_tags($_POST['child']);
					$child_age			= strip_tags($_POST['child_age']);
					$package_duration 	= strip_tags($_POST['package_duration']);
					$cab_category 		= strip_tags($_POST['cab_category']);
					$agent_id 			= strip_tags($_POST['agent_id']);
					$customer_id 		= strip_tags($_POST['customer_id']);
					$iti_package_type 	= isset($_POST['iti_package_type']) ? strip_tags($_POST['iti_package_type']) : "";
					$isflight			= isset($_POST['is_flight']) && !empty( $_POST['is_flight'] ) ? 1 : 0;
					$isTrain			= isset( $_POST['is_train'] ) && !empty( $_POST['is_train'] ) ? 1 : 0;
					$rooms_meta			= serialize($this->input->post('rooms_meta', TRUE));
					
					$step_data = array(
						'iti_type' 			=> $iti_type,
						'iti_package_type' 	=> $iti_package_type,
						'package_name' 		=> $package_name,
						'quatation_date' 	=> $quatation_date,
						'temp_key'			=> $unique_id,
						'package_routing'	=> $package_routing,
						'cab_category'		=> $cab_category,
						'adults'			=> $adults,
						'child'				=> $child,
						'child_age'			=> $child_age,
						'duration'			=> $package_duration,
						'is_flight'			=> $isflight,
						'is_train'			=> $isTrain,
						'agent_id'			=> $agent_id,
						'customer_id'		=> $customer_id,
						'rooms_meta'		=> $rooms_meta,
					);
				break;
				case 2:
					$day_wise = $this->input->post('tour_meta', TRUE);
					$t_start_date = "";
					$t_end_date = "";
					
					if( !empty( $day_wise ) && isset( $day_wise[0]['tour_date'] ) ){
						$t_start_date = $day_wise[0]['tour_date'];
						
						$end_d = end($day_wise);
						$t_end_date  = $end_d['tour_date'];						
					}
					
					$daywise_meta = serialize($this->input->post('tour_meta', TRUE));
					$step_data = array(
						't_start_date' 	=> $t_start_date,
						't_end_date' 	=> $t_end_date,
						'daywise_meta' 	=> $daywise_meta,
					);
				break;
				case 3:
					$inc_meta					= serialize($this->input->post('inc_meta', TRUE));
					$exc_meta					= serialize($this->input->post('exc_meta', TRUE));
					$special_inc_meta			= serialize($this->input->post('special_inc_meta', TRUE));
					$booking_benefits_meta		= serialize($this->input->post('booking_benefits_meta', TRUE));
					$step_data = array(
						'inc_meta'					=> $inc_meta,
						'exc_meta'					=> $exc_meta,
						'special_inc_meta'			=> $special_inc_meta,
						'booking_benefits_meta'		=> $booking_benefits_meta,
					);
				break;
				case 4:
					$hotel_meta				= serialize( $this->input->post('hotel_meta', TRUE) );
					$hotel_note_meta		= serialize( $this->input->post('hotel_note_meta', TRUE) );
					//if( $role == 99 || $role == 98 ){
					if ( $role == 99 || is_cost_manager() || is_super_manager() || is_sales_manager() ){
						$hotel_rate_meta		= serialize($this->input->post('rate_meta', TRUE));
						$rate_comment			= isset( $_POST['rate_comment'] ) ? $_POST['rate_comment'] : "";
						$per_person_ratemeta	= isset( $_POST['per_person_ratemeta'] ) ? serialize($this->input->post('per_person_ratemeta')) : "";
						
						$step_data = array(
							'hotel_meta'			=> $hotel_meta,
							'hotel_note_meta'		=> $hotel_note_meta,
							'rates_meta'			=> $hotel_rate_meta,
							'rate_comment'			=> $rate_comment,
							'pending_price'			=> 2,
							'per_person_ratemeta'	=> $per_person_ratemeta,
						);
					}else{
						$step_data = array(
							'hotel_meta'			=> $hotel_meta,
							'hotel_note_meta'		=> $hotel_note_meta,
						);
					}	
				break;
			}
			
			//update data
			$where = array('temp_key' => $unique_id );
			$get_data = $this->global_model->getdata("itinerary", $where);
			if( empty( $get_data ) ){
				//insert if data not get
				//push lead created date 
				$step_data['lead_created'] = $this->input->post("lead_created", true);
				$insert_data = $this->global_model->insert_data("itinerary", $step_data );
				if( $insert_data ){
					$res = array('status' => true, 'msg' => "Data save.");
				}else{
					$res = array('status' => false, 'msg' => "Error! Data not save.");
				}
			}else{
				//Update data 
				$where_key = array('temp_key' => $unique_id ); 
				$update_data = $this->global_model->update_data("itinerary", $where_key, $step_data );
				if( $update_data ){
					$res = array('status' => true, 'msg' => "Data save.");
				}else{
					$res = array('status' => false, 'msg' => "Error! Data not save.");
				}
			}
			
			//Enter Flight and Train Details if step=1
			if( $step == 1 ){
				//Get Itinerary Id
				$iti_id = $this->global_model->getdata("itinerary", array( 'temp_key' => $unique_id ), "iti_id" );
				$chkFdetails = $this->global_model->getdata( "flight_details", array("iti_id" => $iti_id) );
				$chkTdetails = $this->global_model->getdata( "train_details", array("iti_id" => $iti_id) );
				//Flight Details 
				$isflights	= isset($_POST['is_flight']) && !empty( $_POST['is_flight'] ) ? 1 : 0;
				$isTrains	= isset( $_POST['is_train'] ) && !empty( $_POST['is_train'] ) ? 1 : 0;
				if( $isflights == 1 ){
					//Get Flight Data 
					$flight_name	= strip_tags($_POST['flight_name']);
					$passengers     = strip_tags($_POST['passengers']);
					$dep_city		= strip_tags($_POST['dep_city']);
					$arr_city		= strip_tags($_POST['arr_city']);
					$arr_time		= strip_tags($_POST['arr_time']);
					$dep_date		= strip_tags($_POST['dep_date']);
					$return_date	= isset($_POST['return_date']) ? strip_tags($_POST['return_date']) : "";
					$return_arr_date = isset($_POST['return_arr_date']) ? strip_tags($_POST['return_arr_date']) : "";
					$f_class		= strip_tags($_POST['f_class']);
					$flight_price	= strip_tags($_POST['flight_cost']);
					$trip_r			= strip_tags($_POST['trip_r']);
					
					$f_data = array(
						"iti_id" 			=> $iti_id,
						"trip_type"			=> $trip_r,
						"flight_name" 		=> $flight_name,
						"flight_price" 		=> $flight_price,
						"dep_city" 			=> $dep_city,
						"arr_city"			=> $arr_city,
						"arr_time"			=> $arr_time,
						"dep_date"			=> $dep_date,
						"return_date"		=> $return_date,
						"return_arr_date"	=> $return_arr_date,
						"total_passengers"	=> $passengers,
						"flight_class"		=> $f_class,
						"in_itinerary"		=> 1,
					);
					
					//get Flight Data if exists
					$get_fdata = $this->global_model->getdata("flight_details", array( "iti_id" => $iti_id ));
					if( empty( $get_fdata ) ){
						//insert if data not get
						$this->global_model->insert_data("flight_details", $f_data );
					}else{
						//Update data 
						$where_key = array('iti_id' => $iti_id ); 
						$this->global_model->update_data("flight_details", $where_key, $f_data );
					}
				}else if( $isflights == 0 && !empty( $chkFdetails ) ){
					$this->global_model->update_data("flight_details", array('iti_id' => $iti_id ), array("in_itinerary" => 0 ) );
				}

				//Enter Train Details	
				if( $isTrains == 1 ){
					//Get Train Data 
					$train_name		= strip_tags($_POST['train_name']);
					$train_number	= strip_tags($_POST['train_number']);
					$passengers     = strip_tags($_POST['t_passengers']);
					$dep_city		= strip_tags($_POST['t_dep_city']);
					$arr_city		= strip_tags($_POST['t_arr_city']);
					$t_arr_time		= strip_tags($_POST['t_arr_time']);
					$dep_date		= strip_tags($_POST['t_dep_date']);
					$return_date	= isset($_POST['t_return_date']) ? strip_tags($_POST['t_return_date']) : "";
					$t_return_arr_date	= isset($_POST['t_return_arr_date']) ? strip_tags($_POST['t_return_arr_date']) : "";
					$f_class		= strip_tags($_POST['t_class']);
					$t_price		= strip_tags($_POST['t_cost']);
					$trip_r			= strip_tags($_POST['t_trip_r']);
					
					$f_data = array(
						"iti_id" 			=> $iti_id,
						"t_trip_type"		=> $trip_r,
						"train_name" 		=> $train_name,
						"train_number" 		=> $train_number,
						"t_cost" 			=> $t_price,
						"t_dep_city" 		=> $dep_city,
						"t_arr_city"		=> $arr_city,
						"t_arr_time"		=> $t_arr_time,
						"t_dep_date"		=> $dep_date,
						"t_return_date"		=> $return_date,
						"t_return_arr_date"	=> $t_return_arr_date,
						"t_passengers"		=> $passengers,
						"train_class"		=> $f_class,
						"in_itinerary"		=> 1,
					);
					
					//get train Data if exists
					$get_fdata = $this->global_model->getdata("train_details", array( "iti_id" => $iti_id ));
					if( empty( $get_fdata ) ){
						//insert if data not get
						$this->global_model->insert_data("train_details", $f_data );
					}else{
						//Update data 
						$where_key = array('iti_id' => $iti_id ); 
						$this->global_model->update_data("train_details", $where_key, $f_data );
					}
				}else if( $isTrains == 0 && !empty( $chkTdetails ) ){
					$this->global_model->update_data("train_details", array('iti_id' => $iti_id ), array("in_itinerary" => 0 ) );
				} 
			}
			die(json_encode($res));
		}else{
			$res = array('status' => false, 'msg' => "Failed! Invalid request try again.");
			die(json_encode($res));
		}
	}
	
	//delete draft iti
	public function delete_iti_permanently(){
		$id = $this->input->get('id');
		$where = array( "iti_id" => $id );
		$result = $this->global_model->delete_data( "itinerary", $where );
		if( $result){
			$res = array('status' => true, 'msg' => "Itinerary delete Successfully!");
		}else{
			$res = array('status' => false, 'msg' => "Error! please try again later");
		}
		die(json_encode($res));
	}
	//update price by manager
	public function update_price(){
		if( isset($_POST["action"]) && !empty( $_POST["iti_id"]) ){
			$action = $_POST["action"];
			//$res = array('status' => false, 'msg' => "Data not save. $action");
			//die( json_encode( $res ) );
			
			$iti_id 				= trim( $_POST['iti_id'] );
			$agent_id 				= trim( $_POST['agent_id'] );
			$temp_key 				= trim( $_POST['temp_key'] );
			$rate_comment 			= strip_tags( $_POST['rate_comment'] );
			$hotel_rate_meta		= serialize($this->input->post('rate_meta'));
			$per_person_ratemeta	= serialize($this->input->post('per_person_ratemeta'));
			
			$customer_id = $this->global_model->getdata("itinerary", array( "iti_id" => $iti_id ), "customer_id" );
			
			//Update data 
			$update_data = array(
				'rates_meta'			=> $hotel_rate_meta,
				'rate_comment'			=> $rate_comment,
				'per_person_ratemeta'	=> $per_person_ratemeta,
				'iti_status'			=> 0,
				'publish_status'		=> "publish",
				'approved_price_date'	=> current_datetime(),
			);
			
			$link = "<a class='btn btn-success' target='_blank' href=" . site_url("itineraries/view/{$iti_id}/{$temp_key}") . " title='View'>Click to view itinerary</a>";
			
			//Check Action if action == 'agent' OR 'supermanager'
			if( $action == 'supermanager'){
				//pending_price = 4 (Request to super manager) 
				$update_data["pending_price"] = 4;
				$to		 	= super_manager_email();
				$subject 	= "trackitinerary <Price verfiy/update request of Itinerary id: {$iti_id}>";
				$msg 		= "Price request to update by manager.Click below link to update/verfiy price.<br>";
				$msg 		.= "LEAD ID: {$customer_id} <br>";
				$msg 		.= "{$link}";
			}else if( $action == 'manager' ){
				//pending_price = 1 (Request to manager) 
				$update_data["pending_price"] = 1;
				$to		 	= manager_email();
				$subject 	= "trackitinerary <Price update request of Itinerary id: {$iti_id}>";
				$msg 		= "Price request to update by teamleader.Click below link to update price.<br>";
				$msg 		.= "LEAD ID: {$customer_id} <br>";
				$msg 		.= "{$link}";
			}else{
				//pending_price = 2 (for approved price) 
				$update_data["pending_price"] = 2;
				//Message to agent
				$to		 	= get_user_email($agent_id);
				$subject 	= "trackitinerary <Price Updated of Itinerary id: {$iti_id}>";
				$msg 		= "Price successfully updated by manager.Click below link to view itinerary.<br>";
				$msg 		.= "LEAD ID: {$customer_id} <br>";
				$msg 		.= "{$link}";
			}
			
			/**
			* NOTIFICATION SECTION 
			*/
			
			//Delete last notification for customer if/any
			$where_notif = array( "notification_type" => 3, "customer_id" => $customer_id );
			$this->global_model->delete_data("notifications", $where_notif);			
			if( $action != 'supermanager'){
				//Create notification if next call time exists
				$title 		= "Price Approved";
				$c_date 	= current_datetime();
				$notif_time = date("Y-m-d H:i:s", strtotime( $c_date . " +5 minutes") );
				$body 		= "Price Approved By Manager";
				$notif_link = "itineraries/view/{$iti_id}/{$temp_key}";
				$notification_data = array(
					"customer_id"		=> $customer_id,
					"notification_for"	=> 96, //96 = sales team
					"title"				=> $title,
					"body"				=> $body,
					"url"				=> $notif_link,
					"notification_time"	=> $notif_time,
					"agent_id"			=> $agent_id,
				);
				
				//Insert notification
				$this->global_model->insert_data( "notifications", $notification_data );
			}
			
			/*
			*END NOTIFICATION SECTION
			*/
			
			//Update data	
			$where = array('iti_id' => $iti_id ); 
			$update = $this->global_model->update_data("itinerary", $where, $update_data );
			if( $update ){
				//sent mail to Super Manager for update price
				$sent_mail = sendEmail($to, $subject, $msg);
				$res = array('status' => true, 'msg' => "Data save.");
			}else{
				$res = array('status' => false, 'msg' => "Data not save.");
			}
			
		}else{
			$res = array('status' => false, 'msg' => "Data not save.");
		}	
		die(json_encode($res));
	}
	
	
	//update price by Super manager
	public function update_price_supermanager(){
		if( isset($_POST["iti_id"]) && !empty( $_POST["iti_id"]) ){
			$iti_id 			= trim( $_POST['iti_id'] );
			$agent_id 			= trim( $_POST['agent_id'] );
			$temp_key 			= trim( $_POST['temp_key'] );
			$rate_comment 		= strip_tags( $_POST['rate_comment'] );
			$hotel_rate_meta	= serialize($this->input->post('rate_meta'));
			$per_person_ratemeta	= serialize($this->input->post('per_person_ratemeta'));
			
			//$res = array('status' => false, 'msg' => "Data not save. $rate_comment");
			//die( json_encode( $res ) );
			
			//Update data 
			$update_data = array(
				'rates_meta'			=> $hotel_rate_meta,
				'rate_comment'			=> $rate_comment,
				'pending_price'			=> 2,
				'iti_status'			=> 0,
				'publish_status'		=> "publish",
				'approved_price_date'	=> current_datetime(),
				'per_person_ratemeta'	=> $per_person_ratemeta,
			);
			
			/**
			* NOTIFICATION SECTION 
			*/
			$customer_id = $this->global_model->getdata("itinerary", array( "iti_id" => $iti_id ), "customer_id" );
			//Delete last notification for customer if/any
			$where_notif = array( "notification_type" => 3, "customer_id" => $customer_id );
			$this->global_model->delete_data("notifications", $where_notif);
			
			//Create notification if next call time exists
			$title 		= "Price Approved";
			$c_date 	= current_datetime();
			$notif_time = date("Y-m-d H:i:s", strtotime( $c_date . " +5 minutes") );
			$body 		= "Price Approved By Manager";
			$notif_link = "itineraries/view/{$iti_id}/{$temp_key}";
			$notification_data = array(
				"customer_id"		=> $customer_id,
				"notification_for"	=> 96, //96 = sales team
				"title"				=> $title,
				"body"				=> $body,
				"url"				=> $notif_link,
				"notification_time"	=> $notif_time,
				"agent_id"			=> $agent_id,
			);
			//Insert notification
			$this->global_model->insert_data( "notifications", $notification_data );
			
			/*
			*END NOTIFICATION SECTION
			*/
			
			
			$link = "<a class='btn btn-success' target='_blank' href=" . site_url("itineraries/view/{$iti_id}/{$temp_key}") . " title='View'>Click to view itinerary</a>";
			
			//Message to agent
			$to		 	= get_user_email($agent_id);
			$subject 	= "trackitinerary <Price Updated of Itinerary id: {$iti_id}>";
			$msg 		= "Price successfully updated by manager.Click below link to view itinerary.<br>";
			$msg 		.= "LEAD ID: {$customer_id} <br>";
			$msg 		.= "{$link}";
			//Update data	
			$where = array('iti_id' => $iti_id ); 
			$update = $this->global_model->update_data("itinerary", $where, $update_data );
			if( $update ){
				//sent mail to Super Manager for update price
				$sent_mail = sendEmail($to, $subject, $msg);
				$res = array('status' => true, 'msg' => "Data save.");
			}else{
				$res = array('status' => false, 'msg' => "Data not save.");
			}			
		}else{
			$res = array('status' => false, 'msg' => "Data not save.");
		}	
		die(json_encode($res));
	}
	
	//Reject Itinerary
	public function reject_itinerary(){
		$user = $this->session->userdata('logged_in');
		$u_id = $user['user_id'];
		$role = $user['role'];
		
		if( isset($_POST["iti_id"]) && !empty($_POST["iti_id"]) ){
			$iti_id = trim( $_POST['iti_id'] );
			$agent_id = trim( $_POST['agent_id'] );
			$iti_reject_comment = strip_tags( $this->input->post('iti_reject_comment', true) );
			$temp_key = get_iti_temp_key( $iti_id );
			//iti_status 6 for rejected itinerary
			$update_data = array(
				'iti_status'			=> 6,
				'pending_price'			=> 0,
				'iti_reject_comment'	=> $iti_reject_comment,
			);
			
			//Update data 
			$where = array('iti_id' => $iti_id ); 
			$update = $this->global_model->update_data("itinerary", $where, $update_data );
			if( $update ){
				
				/**
				* NOTIFICATION SECTION 
				*/
				$customer_id = $this->global_model->getdata("itinerary", array( "iti_id" => $iti_id ), "customer_id" );
				//Delete last notification for customer if/any
				$where_notif = array( "notification_type" => 3, "customer_id" => $customer_id );
				$this->global_model->delete_data("notifications", $where_notif);
				
				//Create notification if next call time exists
				$title 		= "Itinerary Rejected";
				$c_date 	= current_datetime();
				$notif_time = date("Y-m-d H:i:s", strtotime( $c_date . " +5 minutes") );
				$body 		= "Itinerary Rejected By Manager";
				$notif_link = "itineraries/view/{$iti_id}/{$temp_key}";
				$notification_data = array(
					"customer_id"		=> $customer_id,
					"notification_for"	=> 96, //96 = sales team
					"title"				=> $title,
					"body"				=> $body,
					"url"				=> $notif_link,
					"notification_time"	=> $notif_time,
					"agent_id"			=> $agent_id,
				);
				//Insert notification
				$this->global_model->insert_data( "notifications", $notification_data );
				
				/*
				*END NOTIFICATION SECTION
				*/
			
				//sent mail to agent after price updated
				$link = "<a class='btn btn-success' target='_blank' href=" . site_url("itineraries/view/{$iti_id}/{$temp_key}") . " title='View'>Click to view itinerary</a>";
				$to		 = get_user_email($agent_id);;
				$subject = "trackitinerary < Itinerary Rejected Itinerary id: {$iti_id}>";
				$msg = "Itinerary rejected by manager.Click below link to view itinerary.<br>";
				$msg .= "{$link}";
				
				$sent_mail = sendEmail($to, $subject, $msg);
				$res = array('status' => true, 'msg' => "Data save.");
			}else{
				$res = array('status' => false, 'msg' => "Data not save.");
			}
		}else{
			$res = array('status' => false, 'msg' => "Invalid Request.");
		}	
		die(json_encode($res));
	}
	
	//ajax request to update Itineraries call log
	public function updateItiStatus(){
		$user = $this->session->userdata('logged_in');
		$u_id = $user['user_id'];
		$user_id = $user['user_id'];
		$role = $user['role'];
		$call_status = 0;
		$booked_lead	=	false;
		if( isset( $_POST['iti_id'] ) && !empty( $_POST['iti_id'] ) && isset( $_POST['callType'] ) ){
			$iti_id					= strip_tags($this->input->post("iti_id", TRUE));
			//get itinerary
			$where_iti 	= array( "iti_id" => $iti_id , "del_status" => 0 );
			$data_iti 	= $this->global_model->getdata( "itinerary", $where_iti);
			if( !isset( $data_iti[0] ) ){
				$res = array('status' => false, 'msg' => "Invalid Itinerary. Please reload page and try again!");
				die( json_encode($res) );
			}
			
			$parent_iti_idIti 		= $data_iti[0]->parent_iti_id;
			$tmp 					= $data_iti[0]->temp_key;
			$iti_type 				= $data_iti[0]->iti_type;
			//$agent_id 				= $data_iti[0]->agent_id;
			$customer_id 			= $data_iti[0]->customer_id;
			$publish_status 		= $data_iti[0]->publish_status;			
			//publish_status
			
			//$tmp					= strip_tags(get_iti_temp_key($iti_id));
			//$parent_iti_idIti 	= strip_tags(get_parent_iti_id($iti_id));
			//$iti_type 			= strip_tags(check_iti_type($iti_id));
			//$customer_id			= strip_tags($this->input->post("customer_id", TRUE));
			$agent_id				= strip_tags($this->input->post("agent_id", TRUE));
			
			$callType 				= strip_tags($this->input->post("callType", TRUE));
			$callSummary 			= strip_tags($this->input->post("callSummary", TRUE));
			$callSummaryNotpicked 	= strip_tags($this->input->post("callSummaryNotpicked", TRUE));
			$nextCallTime 			= strip_tags($this->input->post("nextCallTime", TRUE));
			$nextCallTimeNotpicked 	= strip_tags($this->input->post("nextCallTimeNotpicked", TRUE));
			$txtProspect 			= strip_tags($this->input->post("txtProspect", TRUE));
			$txtProspectNotpicked 	= strip_tags($this->input->post("txtProspectNotpicked", TRUE));
			$final_amount 			= strip_tags($this->input->post("final_amount", TRUE));
			$comment 				= $this->input->post("comment", TRUE);
			$currentDate 			= current_datetime();
			
			$aahar_card_image_name  = "";
			$payment_image_name 	= "";
			
			//aadhar/payment image path
			$year = date("Y");
			$month = date("m");
			$doc_path =  dirname($_SERVER["SCRIPT_FILENAME"]) . '/site/assets/client_docs/'. date("Y") . '/' . date("m") . '/'  . $iti_id . '/';
			//Get customer info
			$get_customer_info 	= get_customer( $customer_id ); 
			$cust				= $get_customer_info[0];
			$customer_name 		= $cust->customer_name;
			$customer_contact	= $cust->customer_contact;
			$customer_email		= $cust->customer_email;
		
			if( $callType == "Picked call" ){
				$call_smry = $callSummary;
				$lead_status = $txtProspect;
				$nxt_call = $nextCallTime;
			}else if( $callType == "Call not picked" ){
				$call_smry = $callSummaryNotpicked;
				$lead_status = $txtProspectNotpicked;
				$nxt_call = $nextCallTimeNotpicked;
			}else if( $callType == "Close lead" ){
				$call_status = 1; //if lead book not upcoming notification
				//if itinerary declined by client
				$where_iti = array( "iti_id" => $iti_id );
				$call_smry = $this->input->post('iti_note_decline', TRUE);
				$decline_comment = $this->input->post('decline_comment',TRUE);
				$lead_status = "";
				$nxt_call = "";
				//Get Current Itinerary data
				$c_data = $data_iti[0];
				$parent_iti_id = $c_data->parent_iti_id;
				$temp_key = $c_data->temp_key;
				
				//count if parent id exists delete other itineries
				
				/*if( $parent_iti_id !== 0 && !empty( $parent_iti_id ) ){
					$del_where = array( "parent_iti_id" => $parent_iti_id , "temp_key !=" => $temp_key, "iti_type" => $iti_type );
					$orWhere = array( "iti_id" => $parent_iti_id );
					
					//Delete ITI followUpData
					$this->itinerary_model->delete_data( "iti_followup", $del_where, $orWhere); 
					$this->itinerary_model->delete_data( "itinerary", $del_where, $orWhere); 
				}
				
				//count if current itinerary have child itineraries
				$countChildIti = $this->global_model->count_all( 'itinerary', array("parent_iti_id" => $iti_id) );
				//delete other itinerary
				if( $countChildIti > 0 ){
					$del_where = array( "parent_iti_id" => $iti_id,  "iti_type" => $iti_type );
					//Delete ITI followUpData					
					$this->global_model->delete_data( "iti_followup", $del_where); 
					$this->global_model->delete_data( "itinerary", $del_where);
				}*/
				
				//delete iti followup
				$delete_where = array( "iti_id !=" => $iti_id, "customer_id" => $customer_id );
				$this->global_model->delete_data( "iti_followup",  $delete_where );
				//delete child itineraries
				$this->global_model->delete_data( "itinerary", $delete_where);
				
				//update data
				$u_data = array(
					"followup_status" => $call_smry, 
					"decline_comment" => $decline_comment, 
					"iti_status" => 7, 
					"iti_decline_approved_date" => current_datetime(),
					"parent_iti_id" => 0, 
					"discount_rate_request" => 0 
				);
				
				$update_status = $this->global_model->update_data( "itinerary", $where_iti, $u_data );
				
				//update customer status to declined=8
				$this->global_model->update_data( "customers_inquery", array("customer_id" => $customer_id ) , array("decline_comment" => $decline_comment , "cus_status" => 8, "lead_last_followup_date" => $currentDate ) );
			}elseif( $callType == "Booked lead" ){
				$call_status = 1; //if lead book not upcoming notification
				//check if itinerary not publish return false
				if( $publish_status != "publish" ){
					$res = array('status' => false, 'msg' => "You can't book this itinerary because its not publish.");
					die( json_encode($res) );
				}
				$file_prefix = date("Y") . "/".  date("m") . "/" . $iti_id . "/";
				//aadhar card upload
				if( isset( $_FILES['client_aadhar_card']['name'] ) && !empty( $_FILES['client_aadhar_card']['name'] ) ){
					
					$f_n = $_FILES['client_aadhar_card']['name'];
					$n = str_replace(' ', '_', $f_n);
					$file_name = $iti_id . "_adhar_{$u_id}_"  . $n;
					
					//check if path exists
					if(!is_dir($doc_path)){
						if (!mkdir($doc_path, 0777, true)) {
							//return false;
							$res = array('status' => false, 'msg' => "File not uploaded. Please contact administrator.");
							die( json_encode($res) );
						}
					}
					
					//$file_name = $iti_id . "_adhar_{$u_id}_"  . $n;
					
					$config['upload_path'] = $doc_path;
					$config['allowed_types'] = 'jpg|jpeg|png';
					$config['max_size'] = 1024 * 2;
					$config['max_width']  = 5000;
					$config['max_height'] = 3000;
					$config['file_name'] = $file_name;
					$this->load->library('upload', $config);
					
					if(!$this->upload->do_upload('client_aadhar_card')){
						$err = $this->upload->display_errors();
						$res = array('status' => false, 'msg' => "{$err}");
						die( json_encode($res) );
					}else{
						$data_a = $this->upload->data();
						$aahar_card_image_name = $file_prefix . $data_a['file_name'];
					}
					unset($config);
				}
				
				//payment screenshot upload payment_screenshot/client_aadhar_card final_amount
				if( isset( $_FILES['payment_screenshot']['name'] ) && !empty( $_FILES['payment_screenshot']['name'] ) ){
					//check if path exists
					if(!is_dir($doc_path)){
						if (!mkdir($doc_path, 0777, true)) {
							//return false;
							$res = array('status' => false, 'msg' => "File not uploaded. Please contact administrator.");
							die( json_encode($res) );
						}
					}
					
					$rand_key = time();
					$f_n = $_FILES['payment_screenshot']['name'];
					$n = str_replace(' ', '_', $f_n);
					$file_name = $iti_id . "_payment_{$rand_key}_{$u_id}_"  . $n;
					
					$config['upload_path'] = $doc_path;
					$config['allowed_types'] = 'jpg|jpeg|png';
					$config['max_size'] = 1024 * 2;
					$config['max_width']  = 5000; // client requirment
					$config['max_height'] = 3000;  // client requirment
					$config['file_name'] = $file_name;
					$this->load->library('upload', $config);
					
					if(!$this->upload->do_upload('payment_screenshot')){
						$err = $this->upload->display_errors();
						$res = array('status' => false, 'msg' => "{$err}");
						die( json_encode($res) );
					}else{
						$data_pay = $this->upload->data();
						$payment_image_name =  $file_prefix . $data_pay['file_name'];
					}
					unset($config);
				}
		
				$booked_lead	=	true;
				$where_iti = array( "iti_id" => $iti_id );
				$iti_note = $this->input->post('iti_note_booked');
				$call_smry = $this->input->post('iti_note_booked');
				$approved_package_category = $this->input->post('approved_package_category');
				$lead_status = "";
				$nxt_call = "";
				
				/* Add Payment Details */
				$advance_recieve 	= strip_tags($this->input->post("advance_recieve", TRUE));
				$next_payment_bal 	= strip_tags($this->input->post("next_payment_bal", TRUE));
				$next_payment_date 	= strip_tags($this->input->post("next_payment_date", TRUE));
				
				$third_payment_bal 	= strip_tags($this->input->post("third_payment_bal", TRUE));
				$third_payment_date = strip_tags($this->input->post("third_payment_date", TRUE));
				$final_payment_bal 	= strip_tags($this->input->post("final_payment_bal", TRUE));
				$final_payment_date = strip_tags($this->input->post("final_payment_date", TRUE));
				
				$total_balance 		= strip_tags($this->input->post("total_balance", TRUE));
				$bank_name 			= strip_tags($this->input->post("bank_name", TRUE));
				$transaction_date 	= strip_tags($this->input->post("transaction_date", TRUE));
				$travel_date		= strip_tags($this->input->post("travel_date", TRUE));
				$booking_date		= strip_tags($this->input->post("booking_date", TRUE));
				
				$iti_package_type	= strip_tags($this->input->post("package_type_iti", TRUE));
				
				$f_amount 			= $final_payment_bal;
				
				if( empty( $advance_recieve ) &&  empty( $bank_name ) && empty($final_amount) && empty( $iti_type ) ){
					$res = array('status' => false, 'msg' => "All Fields are required!");
					die( json_encode($res) );
				}elseif( trim($final_amount) < trim( $advance_recieve ) || !is_numeric( $advance_recieve ) || !is_numeric( $final_amount ) ){
					$res = array('status' => false, 'msg' => "Please Enter Valid Amount!");
					die( json_encode($res) );
				}
				
				$nxtPay 		= !empty( $next_payment_bal ) ? $next_payment_date : "";
				$third_ins_date = !empty( $third_payment_bal ) ? $third_payment_date : "";
				$f_date 		= !empty( $f_amount ) ? $final_payment_date : "";
				
				//Check for paid/unpaid
				$secPaid 		= !empty( $next_payment_bal ) ? "unpaid" : "";
				$thr_paid 		= !empty( $third_payment_bal ) ? "unpaid" : "";
				$f_paid 		= !empty( $f_amount ) ? "unpaid" : "";
				//$is_gst		= isset( $_POST['is_gst'] ) ? 1 : 0;
				$agent_margin   = isset( $_POST['agent_margin'] ) ? $_POST['agent_margin'] : 0;
				$is_below_base_price   = isset( $_POST['is_below_base_price'] ) ? $_POST['is_below_base_price'] : 0;
				$is_gst			= 1;
				
				//payment details
				$payData = array(
					'iti_id' 				=> $iti_id,
					'iti_type' 				=> $iti_type,
					'customer_id'			=> $customer_id,
					'customer_name'			=> $customer_name,
					'customer_email'		=> $customer_email,
					'customer_contact'		=> $customer_contact,
					'total_package_cost'	=> $final_amount,
					'package_actual_cost'	=> $final_amount,
					'agent_margin'			=> $agent_margin,
					'advance_recieved'		=> $advance_recieve,
					'bank_name'				=> $bank_name,
					'advance_trans_date'	=> $transaction_date,
					'booking_date'			=> $booking_date,
					'next_payment'			=> $next_payment_bal,
					'next_payment_due_date'	=> $nxtPay,
					'second_payment_bal'	=> $next_payment_bal,
					'second_payment_date'	=> $nxtPay,
					'second_pay_status'		=> $secPaid,
					'third_payment_bal'		=> $third_payment_bal,
					'third_payment_date'	=> $third_ins_date,
					'third_pay_status'		=> $thr_paid,
					'final_payment_bal'		=> $f_amount,
					'final_payment_date'	=> $f_date,
					'final_pay_status'		=> $f_paid,
					'total_balance_amount'	=> $total_balance,
					'travel_date'			=> $travel_date,
					'approved_note'			=> $iti_note,
					'agent_id'				=> $agent_id,
					'payment_screenshot'	=> $payment_image_name,
					'client_aadhar_card'	=> $aahar_card_image_name,
					'iti_booking_status'	=> 1, //1= on hold
					'is_gst'				=> $is_gst, //1= gst included
					'is_below_base_price'	=> $is_below_base_price, //1= gst included
					'iti_package_type'		=> $iti_package_type,
				);
				
				//payment_screenshot/client_aadhar_card
				
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
					
					foreach( $upload_files as $ind=>$file){
						$upload_docs_data[$ind]['file_url'] 	= $file_prefix . $file;
						$upload_docs_data[$ind]['comment'] 		= isset( $_POST['doc_comment'][$ind] ) ? $_POST['doc_comment'][$ind] : "";
						$upload_docs_data[$ind]['iti_id'] 		= $iti_id;
						$upload_docs_data[$ind]['customer_id'] 	= $customer_id;
						$upload_docs_data[$ind]['agent_id'] 	= $agent_id;
					}
				}
				
				//insert client docs
				if( !empty( $upload_docs_data ) ){
					$this->global_model->insert_batch_data("iti_clients_docs", $upload_docs_data );
				}	
				
				//check if iti id exists
				$pay_id = $this->global_model->getdata("iti_payment_details", array( "iti_id" => $iti_id ) );
				if( empty( $pay_id ) ){
					$insert_payment_details = $this->global_model->insert_data( "iti_payment_details", $payData );
					if ( !$insert_payment_details ){
						$res = array('status' => false, 'msg' => "Payment not updated please try again later!");
						die( json_encode($res) );
					}
					
					//update booking id
					$booking_id = "BID00-" . $insert_payment_details;
					$this->global_model->update_data("iti_payment_details", array("id" => $insert_payment_details), array("booking_id" => $booking_id ) );
				}else{
					$updatePay = $this->global_model->update_data( "iti_payment_details", array("iti_id" => $iti_id), $payData );
					if ( !$updatePay ){
						$res = array('status' => false, 'msg' => "Payment not updated please try again later!");
						die( json_encode($res) );
					}	
				}
				
				/* End Payment Details Section */
				
				//Get Current Itinerary data
				$c_data 		= $data_iti[0];
				$parent_iti_id 	= $c_data->parent_iti_id;
				$temp_key 		= $c_data->temp_key;
				
				//count if parent id exists delete other itineries
				/*if( $parent_iti_id !== 0 && !empty( $parent_iti_id ) ){
					$del_where = array( "parent_iti_id" => $parent_iti_id , "temp_key !=" => $temp_key , "iti_type" => $iti_type);
					$orWhere = array( "iti_id" => $parent_iti_id );
					//Delete ITI followUpData
					$this->itinerary_model->delete_data( "iti_followup", $del_where, $orWhere); 
					$this->itinerary_model->delete_data( "itinerary", $del_where, $orWhere); 
				}
				
				//count if current itinerary have child itineraries
				$countChildIti = $this->global_model->count_all( 'itinerary', array("parent_iti_id" => $iti_id) );
				//delete other itinerary
				if( $countChildIti > 0 ){
					$del_where = array( "parent_iti_id" => $iti_id , "iti_type" => $iti_type );
					$this->global_model->delete_data( "iti_followup", $del_where); 
					$this->global_model->delete_data( "itinerary", $del_where); 
				} */
				
				
				//delete iti followup
				$delete_where = array( "iti_id !=" => $iti_id, "customer_id" => $customer_id );
				$this->global_model->delete_data( "iti_followup",  $delete_where );
				//delete child itineraries
				$this->global_model->delete_data( "itinerary", $delete_where);
				
				
				//update itinerary data
				$booking_date_u = !empty( $booking_date ) ? $booking_date : current_datetime();
				$u_data = array( 
					"final_amount" => $final_amount,
					"followup_status" => $iti_note,
					"parent_iti_id" => 0,
					"pending_price" => 2,
					"discount_rate_request" => 0,
					"iti_decline_approved_date" => $booking_date_u,
					"approved_package_category" => $approved_package_category,
					"iti_status" => 9 
				);
				
				$update_status = $this->global_model->update_data( "itinerary", $where_iti, $u_data );
				$this->global_model->update_data( "customers_inquery", array("customer_id" => $customer_id ) , array("lead_last_followup_date" => $currentDate ) );
				
				//sent mail to admin/manager/customer
				$manager_email 	= manager_email();
				$hotel_booking_email = hotel_booking_email();
				$admins 		= array( $manager_email );
				$to				= get_customer_email( $customer_id );
				
				//sent mail to agent after price updated
				$link = "<a class='btn btn-success' target='_blank' href=" . site_url("itineraries/view/{$iti_id}/{$tmp}") . " title='View'>Click to view itinerary</a>";
				
				$sub 			= "New Itinerary Booked <Trackitinerary.org>";
				$msg 			= "Itinerary Booked <br>";
				$msg 			.= "Final Amount: {$final_amount} <br>";
				$msg 			.= "Itinerary Id: {$iti_id} <br>";
				$msg 			.= "Customer Name: {$customer_name} <br>";
				$msg 			.= "{$link}<br>";
				//send mail to manager 
				$sent_mail_admins	 = sendEmail($admins, $sub, $msg);
				$this->session->set_flashdata('success',"Form Submited Successfully. Itnerary is booked after verified by the sales manager.");				
				/*
				$link = "<a class='btn btn-success' target='_blank' href=" . site_url("itineraries/view/{$iti_id}/{$tmp}") . " title='View'>Click to view itinerary</a>";
				$linkClientView = "<a title='View' target='_blank' href=" . site_url("promotion/itinerary/{$iti_id}/{$tmp}") . " class='btn btn-success' >Click to check itinerary</a>";
				$sub 			= "New Itinerary Booked <Trackitinerary.org>";
				$msg 			= "Itinerary Booked <br>";
				$msg 			.= "Final Amount: {$final_amount} <br>";
				$msg 			.= "Itinerary Id: {$iti_id} <br>";
				$msg 			.= "Customer Name: {$customer_name} <br>";
				$msg 			.= "{$link}<br>";
				$sub_c 			= "Itinerary Booked <Trackitinerary.org>";
				$msg_c 			= "Itinerary Booked <br>";
				$msg_c 			.= "Final Amount: {$final_amount} <br>";
				$msg_c 			.= "Itinerary Id: {$iti_id} <br>";
				$msg_c 			.= "{$linkClientView}<br>";
				//send mail to customer
				$sent_mail	 = sendEmail($to, $sub_c, $msg_c);
				//send mail to manager and admin
				$sent_mail_admins	 = sendEmail($admins, $sub, $msg);
				
				//send msg for customer on Itinerary Booked 
				$iti_link = site_url("promotion/itinerary/{$iti_id}/{$tmp}");
				
				$mobile_customer_sms = "Your itinerary is booked. Please {$iti_link} .For more info contact us. Thanks<Trackitinerary>";
				$cus_mobile = "{$customer_contact}";
				if( !empty( $cus_mobile ) ){
					$sendcustomer_sms = pm_send_sms( $cus_mobile, $mobile_customer_sms );
				} */
			}
			
			/*
			* NOTIFICATION SECTION 
			*/
			//Delete last notification for customer if/any
			//notification_type = 2 for iti followup and 3 = price request
			//$where_notif 		= array( "notification_type" => 2, "customer_id" => $customer_id );
			//$where_notif_iti 	= array( "notification_type" => 3, "customer_id" => $customer_id );
			//$this->global_model->delete_data("notifications", $where_notif_iti);
			//$this->global_model->delete_data("notifications", $where_notif);
			
			$where_notif = "notification_type IN (1,2,3) AND customer_id = {$customer_id}";
			$this->global_model->delete_data_custom("notifications", $where_notif );
			
			//Create notification if next call time exists
			if( $callType == "Booked lead" ){
				$agent_name = get_user_name( $agent_id );
				$title 		= "Iti Verification Request";
				$c_date 	= current_datetime();
				$notif_time = date("Y-m-d H:i:s", strtotime( $c_date . " +10 minutes") );
				$body 		= "Itinerary Booked By {$agent_name}. Please Check and verify.";
				
				$notif_link = "customers/view_lead/{$customer_id}";
				
				$notification_data = array(
					array(
						"customer_id"		=> $customer_id,
						"notification_for"	=> 98, //96 = sales team
						"title"				=> $title,
						"body"				=> $body,
						"url"				=> $notif_link,
						"agent_id"			=> $agent_id,
						"notification_time"	=> $notif_time,
					)
				);
				//Insert notification
				$this->global_model->insert_batch_data( "notifications", $notification_data );
			}else if( $callType == "Close lead" ){
				$noti_a = array( "customer_id" => $customer_id );
				$this->global_model->delete_data("notifications", $noti_a);
			}else if( !empty( $nxt_call ) ){
				$title 		= "Iti Followp";
				$notif_time = date("Y-m-d H:i:s", strtotime( $nxt_call ));
				$body 		= "Next call time {$nxt_call}";
				//$notif_link = "itineraries/view_iti/{$iti_id}/{$tmp}";
				$notif_link = "customers/view_lead/{$customer_id}";
				$notification_data = array(
					"customer_id"		=> $customer_id,
					"notification_for"	=> 96, //96 = sales team
					"notification_type"	=> 2, //2=ITI followUp
					"title"				=> $title,
					"body"				=> $body,
					"url"				=> $notif_link,
					"notification_time"	=> $notif_time,
					"agent_id"			=> $agent_id,
				);
				//Insert notification
				$this->global_model->insert_data( "notifications", $notification_data );
			}
			
			/**
			* END NOTIFICATION SECTION
			**/
			
			//data to insert in followup table
			$f_data= array(
				'iti_id' 			=> $iti_id,
				'customer_id' 		=> $customer_id,
				'iti_type' 			=> $iti_type,
				'temp_key' 			=> $tmp,
				'callType' 			=> $callType,
				'callSummary' 		=> $call_smry,
				'comment' 			=> $comment,
				'nextCallDate'		=> $nxt_call,
				'itiProspect'		=> $lead_status,
				'agent_id'			=> $agent_id,
				'currentCallTime'	=> $currentDate,
				'parent_iti_id'		=> $parent_iti_idIti,
				'call_status'		=> $call_status,
			);
			
			//Update iti followUp call_status of current and parent_iti_id if exists
			$upf_data = array( "call_status" => 1 );
			//$this->itinerary_model->update_iti_followup_status($iti_id, $parent_iti_idIti);
			$this->global_model->update_data("iti_followup", array("customer_id" => $customer_id ), $upf_data );
			$insert_id = $this->global_model->insert_data( "iti_followup", $f_data );
			if( $insert_id ){
				$res = array('status' => true, 'msg' => "Call log detail update successfully!", "booked_lead" => $booked_lead );
			}else{
				$res = array('status' => false, 'msg' => "Call log detail not update successfully!");
			}	
		}else{
			$res = array('status' => false, 'msg' => "Invalid request please try again later!");
		}
		die( json_encode($res) );
	}
	
	//get client comment popup
	public function client_comment_popup(){
		$id = $this->input->post('iti_id');
		$where = array( "iti_id" => $id );
		$data_iti = $this->global_model->getdata( "itinerary", $where);
		if( $data_iti){
			$data = $data_iti[0];
			$comment = $data->client_comment;
			$printData = "<br>Client Comment: {$comment}";
			$res = array('status' => true, 'data' => $printData);
		}else{
			$res = array('status' => false, 'data' => "Error! please try again later");
		}
		die(json_encode($res));
	} 
	
	//Update Discount Price By Manager
	public function update_discount_price(){
		$user = $this->session->userdata('logged_in');
		if( $user['role'] == 98 || $user['role'] == 99 || is_teamleader() ){
			if( isset($_POST["iti_id"]) ){
				$action = $_POST["action"];
				//$res = array('status' => false, 'msg' => "Data not save. $action");
				//die( json_encode( $res ) );
				$rate_comment 		= strip_tags( $_POST['rate_comment'] );
				$iti_id 				= trim( $_POST['iti_id'] );
				$temp_key				= $this->input->post('temp_key');
				$customer_id			= $this->input->post('customer_id');
				$standard_rates			= $this->input->post('standard_rates');
				$deluxe_rates			= $this->input->post('deluxe_rates');
				$super_deluxe_rates		= $this->input->post('super_deluxe_rates');
				$luxury_rates			= $this->input->post('luxury_rates');
				$user_id				= $this->input->post('user_id');
				$agent_id				= $this->input->post('agent_id');
				$per_person_ratemeta	= serialize($this->input->post('per_person_ratemeta'));
			
				//get customer info 
				$get_customer_info = get_customer( $customer_id ); 
				$cust = $get_customer_info[0];
				$customer_name = $cust->customer_name;
				$customer_contact = $cust->customer_contact;
				$customer_email = $cust->customer_email;
				
				//update discount rate status
				$update_data = array(
					'discount_rate_request'	 	=> 0,
					'approved_price_date'		=> current_datetime(),
					'rate_comment'				=> $rate_comment
				);
				
				//check if reduce margin only
				if( isset( $_POST['discount_type'] ) && $_POST['discount_type'] == "reduce_margin" ){
					$standard_rates			= $this->input->post('last_standard_rates');
					$deluxe_rates			= $this->input->post('last_deluxe_rates');
					$super_deluxe_rates		= $this->input->post('last_super_deluxe_rates');
					$luxury_rates			= $this->input->post('last_luxury_rates');
					$last_person_ratemeta	= $this->input->post('last_per_person_ratemeta');
					$dis_agent_margin 		= $this->input->post('dis_agent_margin');
					
					//insert data
					$insert_data = array(
						'iti_id'			 	=> $iti_id,
						'standard_rates'	 	=> $standard_rates,
						'deluxe_rates'		 	=> $deluxe_rates,
						'super_deluxe_rates' 	=> $super_deluxe_rates,
						'luxury_rates'		 	=> $luxury_rates,
						'agent_id'			 	=> $user_id,
						'per_person_ratemeta'	=> $last_person_ratemeta,
						'agent_price'			=> $dis_agent_margin,
					);
				}else{
					//insert data
					$insert_data = array(
						'iti_id'			 	=> $iti_id,
						'standard_rates'	 	=> $standard_rates,
						'deluxe_rates'		 	=> $deluxe_rates,
						'super_deluxe_rates' 	=> $super_deluxe_rates,
						'luxury_rates'		 	=> $luxury_rates,
						'agent_id'			 	=> $user_id,
						'per_person_ratemeta'	=> $per_person_ratemeta,
					);
				}
				
				$link = "<a class='btn btn-success' target='_blank' href=" . site_url("itineraries/view/{$iti_id}/{$temp_key}") . " title='View'>Click to view itinerary</a>";
				
				//Delete last notification for customer if/any
				$where_notif = array( "notification_type" => 3, "customer_id" => $customer_id );
				$this->global_model->delete_data("notifications", $where_notif);
					
				//Check Action if action == 'agent' OR 'supermanager'
				if( $action == 'supermanager'){
					//pending_price = 1 (Request to super manager)  price_status == pending
					$insert_data["price_status"] = 1;
					//discount_rate_request = 2 (Sent to supermanager) 
					$update_data["discount_rate_request"] = 2;
					$to		 = super_manager_email();
					$subject = "trackitinerary <Price verfiy/update request of Itinerary id: {$iti_id}>";
					$msg = "Price request to update by manager.Click below link to update/verfiy price.<br>";
					$msg .= "{$link}";
					
				}else if( $action == 'manager' ){
					
					//pending_price = 1 (Request to super manager) 
					$insert_data["price_status"] = 1;
					//discount_rate_request = 2 (Sent to supermanager) 
					$update_data["discount_rate_request"] = 1;
					$to	 = manager_email();
					$subject = "trackitinerary <Price verfiy/update request of Itinerary id: {$iti_id}>";
					$msg = "Price request to update by manager.Click below link to update/verfiy price.<br>";
					$msg .= "{$link}";
				}else{
					
					/**
					* NOTIFICATION SECTION 
					*/
					//Create notification if next call time exists
					$title 		= "Price Updated";
					$c_date 	= current_datetime();
					$notif_time = date("Y-m-d H:i:s", strtotime( $c_date . " +5 minutes") );
					$body 		= "Price Updated By Manager For Itinerary";
					$notif_link = "itineraries/view/{$iti_id}/{$temp_key}";
					$notification_data = array(
						"customer_id"		=> $customer_id,
						"notification_for"	=> 96, //96 = sales team
						"title"				=> $title,
						"body"				=> $body,
						"url"				=> $notif_link,
						"notification_time"	=> $notif_time,
						"agent_id"			=> $agent_id,
					);
					//Insert notification
					$this->global_model->insert_data( "notifications", $notification_data );
					
					/*
					*END NOTIFICATION SECTION
					*/
				
					//Message to agent
					$to		 = get_user_email($agent_id);
					$subject = "trackitinerary <Price Updated of Itinerary id: {$iti_id}>";
					$msg = "Price successfully updated by manager.Click below link to view itinerary.<br>";
					$msg .= "{$link}";
					
					/*
					//Sent Mail to Customer 
					$link1 = "<a title='View' target='_blank' href=" . site_url("promotion/itinerary/{$iti_id}/{$temp_key}") . " class='btn btn-success' >Click to check itinerary</a>";
					$to_c = get_customer_email( $customer_id );
					$sub = "Check new rates on your itinerary <Trackitinerary.org>";
					$msgs = "New rates updated on your itinerary please check below link.<br>";
					$msgs .= "{$link1}";
					sendEmail($to_c, $sub, $msgs); 
					
					//send msg for customer on price updated
					$iti_link = site_url("promotion/itinerary/{$iti_id}/{$temp_key}");
					$mobile_customer_sms = "Discount Price Updated on your itinerary. Please {$iti_link} .Thanks <Trackitinerary Pvt Ltd.>";
					$cus_mobile = "{$customer_contact}";
					if( !empty( $cus_mobile ) ){
						$sendcustomer_sms = pm_send_sms( $cus_mobile, $mobile_customer_sms );
					}
					*/
				}
				
				//Update data discount status
				$where = array('iti_id' => $iti_id ); 
				$update = $this->global_model->update_data("itinerary", $where, $update_data );
				
				//insert data to price discount table
				$insert = $this->global_model->insert_data("itinerary_discount_price_data", $insert_data );
				if( $update ){
					$res = array('status' => true, 'msg' => "Data save.");
				}else{
					$res = array('status' => false, 'msg' => "Data not save.");
				}
			}else{
				$res = array('status' => false, 'msg' => "Invalid Request.");
			}	
			die(json_encode($res));
		}	
	} 
	
	public function update_discount_price_super_manager(){
		$user = $this->session->userdata('logged_in');
		$user_id = $user["user_id"];
		if( $user['role'] == 98 || $user['role'] == 99 ){
			if( isset($_POST["iti_id"]) ){
				$action = $_POST["action"];
				//$res = array('status' => false, 'msg' => "Data not save. $action");
				//die( json_encode( $res ) );
				$rate_comment 		= strip_tags( $_POST['rate_comment'] );
			
				$iti_id 				= trim( $_POST['iti_id'] );
				$temp_key 				= get_iti_temp_key( $_POST['iti_id'] );
				$id						= $this->input->post('discount_id');
				$customer_id			= $this->input->post('customer_id');
				$standard_rates			= $this->input->post('standard_rates');
				$deluxe_rates			= $this->input->post('deluxe_rates');
				$super_deluxe_rates		= $this->input->post('super_deluxe_rates');
				$luxury_rates			= $this->input->post('luxury_rates');
				$agent_id				= $this->input->post('agent_id');
				$per_person_ratemeta	= serialize($this->input->post('per_person_ratemeta'));
				//get customer info 
				$get_customer_info = get_customer( $customer_id ); 
				$cust = $get_customer_info[0];
				$customer_name = $cust->customer_name;
				$customer_contact = $cust->customer_contact;
				$customer_email = $cust->customer_email;
				
				
				
				/**
				* NOTIFICATION SECTION 
				*/
				//Delete last notification for customer if/any
				$where_notif = array( "notification_type" => 3, "customer_id" => $customer_id );
				$this->global_model->delete_data("notifications", $where_notif);
				
				//Create notification if next call time exists
				$title 		= "Price Updated";
				$c_date 	= current_datetime();
				$notif_time = date("Y-m-d H:i:s", strtotime( $c_date . " +5 minutes") );
				$body 		= "Price Updated By Manager For Itinerary";
				$notif_link = "itineraries/view/{$iti_id}/{$temp_key}";
				$notification_data = array(
					"customer_id"		=> $customer_id,
					"notification_for"	=> 96, //96 = sales team
					"title"				=> $title,
					"body"				=> $body,
					"url"				=> $notif_link,
					"notification_time"	=> $notif_time,
					"agent_id"			=> $agent_id,
				);
				//Insert notification
				$this->global_model->insert_data( "notifications", $notification_data );
				
				/*
				*END NOTIFICATION SECTION
				*/
			
				//update discount rate status
				$update_data = array(
					'discount_rate_request'	 	=> 0,
					'approved_price_date'		=> current_datetime(),
					'rate_comment'				=> $rate_comment,
				);
				
				//update discount data
				$update_dis_data = array(
					'price_status'			=> 0,
					'standard_rates'		=> $standard_rates,
					'deluxe_rates'		 	=> $deluxe_rates,
					'super_deluxe_rates' 	=> $super_deluxe_rates,
					'luxury_rates'		 	=> $luxury_rates,
					'agent_id'				=> $agent_id,
					'per_person_ratemeta'	=> $per_person_ratemeta,
				);
				
				//Update data discount status
				$where = array('iti_id' => $iti_id ); 
				$update = $this->global_model->update_data("itinerary", $where, $update_data );
				
				//update data to price discount table
				$upd = $this->global_model->update_data("itinerary_discount_price_data",array( "id" => $id ),  $update_dis_data );
				if( $upd ){
					
					/*
					//Sent Mail to Customer 
					$link1 = "<a title='View' target='_blank' href=" . site_url("promotion/itinerary/{$iti_id}/{$temp_key}") . " class='btn btn-success' >Click to check itinerary</a>";
					
					$to_c = get_customer_email( $customer_id );
					$sub = "Check new rates on your itinerary <Trackitinerary.org>";
					$msgs = "New rates updated on your itinerary please check below link.<br>";
					$msgs .= "{$link1}";
					sendEmail($to_c, $sub, $msgs); 
					
					// send msg for customer on price updated 
					$iti_link = site_url("promotion/itinerary/{$iti_id}/{$temp_key}");
					$mobile_customer_sms = "Discount Price Updated on your itinerary. Please {$iti_link} .Thanks <Trackitinerary Pvt Ltd.>";
					$cus_mobile = "{$customer_contact}";
					if( !empty( $cus_mobile ) ){
						$sendcustomer_sms = pm_send_sms( $cus_mobile, $mobile_customer_sms );
					}  
					*/
					
					//Message to agent on price update	
					$link = "<a class='btn btn-success' target='_blank' href=" . site_url("itineraries/view/{$iti_id}/{$temp_key}") . " title='View'>Click to view itinerary</a>";
					//Message to agent
					$to		 = get_user_email($agent_id);
					$subject = "trackitinerary <Price Updated of Itinerary id: {$iti_id}>";
					$msg = "Price successfully updated by manager.Click below link to view itinerary.<br>";
					$msg .= "{$link}";
				
					$res = array('status' => true, 'msg' => "Data save.");
				}else{
					$res = array('status' => false, 'msg' => "Data not save.");
				}
			}else{
				$res = array('status' => false, 'msg' => "Invalid Request.");
			}	
			die(json_encode($res));
		}	
	}
	
	/* clone itinerary */
	function duplicate(){
		$user = $this->session->userdata('logged_in');
		if( $user['role'] == 98 || $user['role'] == 99 || $user['role'] == 96 ){
			$iti_id = $this->uri->segment(3);
			if(  get_iti_booking_status($iti_id)  == 3 ){
				echo "You can't make duplicate itinerary because it's revised itinerary. For more detail contact your manager.";
				die;
			} 
			//Count All Child Itineraries
			$countChildIti = $this->global_model->count_all( 'itinerary', array("parent_iti_id" => $iti_id, "del_status" => 0) );
			$getItiData =  $this->global_model->getdata('itinerary', array("iti_id" => $iti_id, "del_status" =>0) );
			$iti_data = $getItiData[0];	
			
			if( $countChildIti < 6 && $iti_data->publish_status == "publish" ){
				$insert_id = $this->itinerary_model->duplicate_itinerary("itinerary", "iti_id", $iti_id);
				if( $insert_id ){
					$getNewIti =  $this->global_model->getdata('itinerary', array("iti_id" => $insert_id, "del_status" =>0 ) );
					$iti_dataNew = $getNewIti[0];	
					$temp_key = $iti_dataNew->temp_key;	
					$newItiId = $insert_id;
					
					//clone flight data if exists
					if( $iti_data->is_flight == 1 ){
						$in_fid = $this->itinerary_model->clone_flight_train_data("flight_details", "iti_id", $iti_id, $newItiId);
					}
					
					//clone Train data if exists
					if( $iti_data->is_train == 1 ){
						$in_tid = $this->itinerary_model->clone_flight_train_data("train_details", "iti_id", $iti_id, $newItiId);
					}
					
					//redirect to edit page
					$redirect_url = site_url("itineraries/edit/{$insert_id}/{$temp_key}");
					redirect( $redirect_url );
					exit;
				}else{
					echo "Error";
				}
			}else{
				echo "Your already clone five itineraries against this Itinerary ID Or Itinerary not publish";
			}
		}else{
			redirect("dashboard");
		}	
	}
	
	/* clone of child itinerary */
	function duplicate_child_iti(){
		$user = $this->session->userdata('logged_in');
		if( $user['role'] == 98 || $user['role'] == 99 || $user['role'] == 96 ){
			if( isset( $_GET['iti_id'] ) && isset( $_GET[ 'parent_iti_id' ] ) && !empty( $_GET['iti_id'] ) ){
				$iti_id = $_GET['iti_id'];
				$parent_iti_id = $_GET[ 'parent_iti_id' ];
				
				//Count All Child Itineraries
				$ckeck_valid_pid = $this->global_model->count_all( 'itinerary', array("iti_id" => $parent_iti_id, "del_status" => 0) );
				
				$countChildIti = $this->global_model->count_all( 'itinerary', array("parent_iti_id" => $parent_iti_id, "del_status" => 0) );
				$getItiData =  $this->global_model->getdata('itinerary', array("iti_id" => $iti_id, "del_status" =>0) );
				$iti_data = $getItiData[0];	
				
				if( $countChildIti < 6 && !empty($iti_data) && !empty($ckeck_valid_pid) ){
					$insert_id = $this->itinerary_model->duplicate_itinerary( "itinerary", "iti_id", $iti_id, $parent_iti_id );
					if( $insert_id ){
						$getNewIti =  $this->global_model->getdata('itinerary', array("iti_id" => $insert_id, "del_status" =>0 ) );
						$iti_dataNew = $getNewIti[0];	
						$temp_key = $iti_dataNew->temp_key;	
						$newItiId = $insert_id;
						
						//clone flight data if exists
						if( $iti_data->is_flight == 1 ){
							$in_fid = $this->itinerary_model->clone_flight_train_data("flight_details", "iti_id", $iti_id, $newItiId);
						}
						
						//clone Train data if exists
						if( $iti_data->is_train == 1 ){
							$in_tid = $this->itinerary_model->clone_flight_train_data("train_details", "iti_id", $iti_id, $newItiId);
						}
						
						//redirect to edit page
						$redirect_url = site_url("itineraries/edit/{$insert_id}/{$temp_key}");
						redirect( $redirect_url );
						exit;
					}else{
						die("Error: Please try again later." );
					}
				}else{
					echo "Your already clone six itineraries against this Itinerary. OR Invalid Itinerary Id";
				}
			}else{
				die("Invalid request");
			} 
		}else{
			redirect("dashboard");
		}	
	}
	
	/* View all child itineraries */
	public function childIti(){
		$iti_id = $this->uri->segment(3);
		$temp_key = $this->uri->segment(4);
		
		$user = $this->session->userdata('logged_in');
		$role = $user["role"];
		$u_id = $user["user_id"];
		$data["currentIti"] = $iti_id;
		$data["currentItiKey"] = $temp_key;
		$data["role"] = $role;
		//get FolloupData
		$where = array( "parent_iti_id" => $iti_id );
		$orwhere = array( "iti_id" => $iti_id);
		$data["lastFollow"] = $this->itinerary_model->getchildItidata("iti_followup", $where, $orwhere,"iti_id","id", 1 );
		if( $role == '99' || $role == '98' ){
			$where = array( "parent_iti_id" => $iti_id,"del_status" => 0, "pending_price !=" => 0 );
			$orwhere = array( "iti_id" => $iti_id);
			$data["childIti"] = $this->itinerary_model->getchildItidata("itinerary", $where, $orwhere );
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('itineraries/child_iti', $data);
			$this->load->view('inc/footer'); 
		}elseif( $role == '96' ){	
			$where = array( "agent_id" => $u_id, "parent_iti_id" => $iti_id, "del_status" => 0 );
			$orwhere = array( "iti_id" => $iti_id);
			$data["childIti"] = $this->itinerary_model->getchildItidata("itinerary", $where, $orwhere);
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('itineraries/child_iti', $data);
			$this->load->view('inc/footer'); 
		}else{
			redirect(404);
		} 
	}
	
	//Add New Comment
	public function ajax_add_agent_comment(){
		$iti_id 		= strip_tags($this->input->post('iti_id'));
		$temp_key 		= strip_tags($this->input->post('temp_key'));
		$client_comment = strip_tags($this->input->post('client_comment'));
		$customer_id	= strip_tags($this->input->post('customer_id'));
		$client_contact = strip_tags($this->input->post('client_contact'));
		$sec_key 		= $this->input->post('sec_key');
		$enc_key 		= md5( $this->config->item("encryption_key") );
		$agent_id		= $this->input->post('agent_id', true);
		
		//Get customer info
		$get_customer_info = get_customer( $customer_id ); 
		$cust			 = $get_customer_info[0];
		$client_name 	= $cust->customer_name;
		$client_contact = $cust->customer_contact;
		
		if( $sec_key !==  $enc_key  ){
			$res = array('status' => false, 'msg' => "Security Error! ");
			die(json_encode($res));
		}
		
		if( !empty($iti_id) && is_numeric( $iti_id )){
			$data = array( "iti_id" => $iti_id, "client_name" => $client_name,"temp_key"=> $temp_key, "comment_by" => "agent", "client_contact" => $client_contact,"agent_id" => $agent_id,"comment_content" => $client_comment );
			$insert = $this->global_model->insert_data("comments", $data );
			if( $insert ){
				//send email to customer
				$agent_username = get_user_name( trim($agent_id) );
				$link = "<a title='View' target='_blank' href=" . site_url("promotion/itinerary/{$iti_id}/{$temp_key}") . " class='btn btn-success' >Click to check itinerary</a>";
				$to = get_customer_email( $customer_id );
				$subject = "New comment on your itinerary <Trackitinerary.org>";
				$msg = "New comment on your itinerary by : <strong> {$agent_username} </strong>.<br>";
				$msg .= "{$link}";
				$sent_mail = sendEmail($to, $subject, $msg);
				
				$res = array('status' => true, 'msg' => "Your comment Submited successfully!");
				die(json_encode($res));
			}else{
				$res = array('status' => false, 'msg' => "Your comment not submit! Please try again.");
				die(json_encode($res));
			}
		}
	}
	
	//update comment status to read
	public function update_comment_status(){
		$id = $this->input->post('iti_id');
		$where = array( "iti_id" => $id );
		$up_data = array("client_comment_status" => 0 );
		$data_iti = $this->global_model->update_data( "itinerary", $where, $up_data);
		if( $data_iti){
			$res = array('status' => true, 'msg' => "done");
		}else{
			$res = array('status' => false, 'msg' => "Error! please try again later");
		}
		die(json_encode($res));
	} 
	
	//price update request to manager from agent
	public function priceReqestToManager(){
		$user 		= $this->session->userdata('logged_in');
		$iti_id		= $this->input->post('iti_id');
		$temp_key 	= $this->input->post('temp_key');
		$send_request_to 	= $this->input->post('send_request_to'); //2=team leader , 1 = manager
		$agent_id	= $user['user_id'];
		
		$agent_username = get_user_name( trim($agent_id) );
		
		//check for teamleader if exists
		$team_leader = get_teamleader_user_id();
		
		if( !empty( $iti_id ) && is_numeric($iti_id) ){
			$link = "<a class='btn btn-success' target='_blank' href=" . site_url("itineraries/view/{$iti_id}/{$temp_key}") . " title='View'>Click to view itinerary</a>";
			
			//check if teamleader exists
			if( $team_leader && $send_request_to == 2 ){
				$teamleader_email = get_user_email($team_leader);
				//update pending_price status
				//1="price pending",2="price updated", 4= "Request to super manager",5=request to teamleader
				$where = array( "iti_id" => trim($iti_id) );
				$update_data = $this->global_model->update_data("itinerary", $where, array( "pending_price" => 5, "pending_price_date" => current_datetime() ) );
				
				/**
				* NOTIFICATION SECTION 
				*/
				$customer_id = $this->global_model->getdata("itinerary", array( "iti_id" => $iti_id ), "customer_id" );				
				//Delete last notification for customer if/any
				$where_notif = array( "notification_type" => 3, "customer_id" => $customer_id );
				$this->global_model->delete_data("notifications", $where_notif);
				
				//Create notification if next call time exists
				$title 		= "Price Request";
				$c_date 	= current_datetime();
				$notif_time = date("Y-m-d H:i:s", strtotime( $c_date . " +5 minutes") );
				$body 		= "Price Request For Itinerary By {$agent_username}";
				$notif_link = "itineraries/view/{$iti_id}/{$temp_key}";
				
				$notification_data = array(
					"customer_id"		=> $customer_id,
					"notification_for"	=> 96, //96 = Sales Team
					"notification_type"	=> 3, //3 = PRICE PENDING
					"title"				=> $title,
					"body"				=> $body,
					"url"				=> $notif_link,
					"notification_time"	=> $notif_time,
					"agent_id"			=> $team_leader,
				);
				
				var_dump($notification_data);die;
				//Insert notification
				$this->global_model->insert_data( "notifications", $notification_data );
				
				/*
				*END NOTIFICATION SECTION
				*/
				
				//sent mail to manager
				//$manager_email = manager_email();
				$to		 	= $teamleader_email;
				$subject 	= "trackitinerary <price update request of itinerary id: {$iti_id}>";
				$msg 		= "New itnerary created by <strong> {$agent_username} </strong>.<br>";
				$msg 		.= "{$link}";
				$sent_mail 	= sendEmail( $to, $subject, $msg );
			}else{
				//if not team_leader send notification to manager
				//update pending_price status		
				//1="price pending",2="price updated", 4= "Request to super manager",5=request to teamleader
				$where = array( "iti_id" => trim($iti_id) );
				$update_data = $this->global_model->update_data("itinerary", $where, array( "pending_price" => 1, "pending_price_date" => current_datetime() ) );
				/**
				* NOTIFICATION SECTION 
				*/
				$customer_id = $this->global_model->getdata("itinerary", array( "iti_id" => $iti_id ), "customer_id" );
				//Delete last notification for customer if/any
				$where_notif = array( "notification_type" => 3, "customer_id" => $customer_id );
				$this->global_model->delete_data("notifications", $where_notif);
				
				//Create notification if next call time exists
				$title 		= "Price Request";
				$c_date 	= current_datetime();
				$notif_time = date("Y-m-d H:i:s", strtotime( $c_date . " +5 minutes") );
				$body 		= "Price Request For Itinerary By {$agent_username}";
				$notif_link = "itineraries/view/{$iti_id}/{$temp_key}";
				
				$notification_data = array(
					"customer_id"		=> $customer_id,
					"notification_for"	=> 98, //98 = Manager
					"notification_type"	=> 3, //3 = PRICE PENDING
					"title"				=> $title,
					"body"				=> $body,
					"url"				=> $notif_link,
					"notification_time"	=> $notif_time,
					"agent_id"			=> $agent_id,
				);
				
				//Insert notification
				$this->global_model->insert_data( "notifications", $notification_data );
				
				/*
				*END NOTIFICATION SECTION
				*/
				
				//sent mail to manager
				$manager_email = manager_email();
				$to		 	= $manager_email;
				$subject 	= "trackitinerary <price update request of itinerary id: {$iti_id}>";
				$msg 		= "New itnerary created by <strong> {$agent_username} </strong>.<br>";
				$msg 		.= "{$link}";
				$sent_mail 	= sendEmail( $to, $subject, $msg );
			}
			
			if( $sent_mail ){ 
				$res = array('status' => true, 'msg' => "Request Sent Successfully");
			}else{
				$res = array('status' => false, 'msg' => "Request not sent successfully");
			}	 
		}else{
			$res = array('status' => false, 'msg' => "Error! please try again later");
		}
		die(json_encode($res));
	} 
	
	//Discount price request agent to manager
	function updateDiscountPriceReq(){
		$iti_id 		= $this->input->post("iti_id", true);
		$temp_key		= $this->input->post("temp_key", true);
		$agent_id		= $this->input->post("agent_id", true);
		$agent_username = get_user_name( trim($agent_id) );
		$h_cat 			= $this->input->post("hotel_cat_dis", true);
		$send_request_to 	= $this->input->post('send_request_to'); //2=team leader , 1 = manager
		
		//check for teamleader if exists
		$team_leader = get_teamleader_user_id();
		//if teamleader exits 2 =teamleader
		if( $team_leader && $send_request_to == 2 ){
			$teamleader_email = get_user_email($team_leader);
			$hotel_cat	= !empty( $h_cat ) ? implode( ", ",  (array)$h_cat) : "";
			$where = array( "iti_id" => $iti_id, "del_status" => 0, "temp_key" => $temp_key );
			
			/* //update Discount status */
			$up_data = array(
				'discount_rate_request'	 	=> 3,
				'dis_hotel_cat'			 	=> $hotel_cat,
				"pending_price_date" 		=> current_datetime(),
			);
			
			$update_data = $this->global_model->update_data( "itinerary", $where, $up_data ); 
			if( $update_data ){
				
				/**
				* NOTIFICATION SECTION 
				*/
				$customer_id = $this->global_model->getdata("itinerary", array( "iti_id" => $iti_id ), "customer_id" );
				//Delete last notification for customer if/any
				$where_notif = array( "notification_type" => 3, "customer_id" => $customer_id );
				$this->global_model->delete_data("notifications", $where_notif);
				
				//Create notification if next call time exists
				$title 		= "Price Discount Request";
				$c_date 	= current_datetime();
				$notif_time = date("Y-m-d H:i:s", strtotime( $c_date . " +5 minutes") );
				$body 		= "Price Discount Request For Itinerary By {$agent_username}";
				$notif_link = "itineraries/view/{$iti_id}/{$temp_key}";
				$notification_data = array(
					"customer_id"		=> $customer_id,
					"notification_for"	=> 96, //96 = sales team
					"notification_type"	=> 3, //3 = PRICE PENDING
					"title"				=> $title,
					"body"				=> $body,
					"url"				=> $notif_link,
					"notification_time"	=> $notif_time,
					"agent_id"			=> $team_leader,
				);
				//Insert notification
				$this->global_model->insert_data( "notifications", $notification_data );
				
				/*
				*END NOTIFICATION SECTION
				*/
				
				//sent mail to manager
				$link = "<a class='btn btn-success' target='_blank' href=" . site_url("itineraries/view/{$iti_id}/{$temp_key}") . " title='View'>Click to view itinerary</a>";
				//$manager_email = manager_email();
				$to		 = $teamleader_email;
				$subject = "trackitinerary <Price Discount request of itinerary id: {$iti_id}>";
				$msg = "Price discount request by <strong> {$agent_username} </strong>.<br>";
				$msg .= "{$link}";
				
				sendEmail($to, $subject, $msg);
				
				$res = array('status' => true, 'msg' => "Discount request sent successfully.");
			}else{
				$res = array('status' => false, 'msg' => "Discount request not sent.");
			}
		}else{
			
			$hotel_cat	= !empty( $h_cat ) ? implode( ", ",  (array)$h_cat) : "";
			$where = array( "iti_id" => $iti_id, "del_status" => 0, "temp_key" => $temp_key );
			
			/* //update Discount status */
			$up_data = array(
				'discount_rate_request'	 	=> 1,
				'dis_hotel_cat'			 	=> $hotel_cat,
				"pending_price_date" 		=> current_datetime(),
			);
			$update_data = $this->global_model->update_data( "itinerary", $where, $up_data ); 
			if( $update_data ){
				
				/**
				* NOTIFICATION SECTION 
				*/
				$customer_id = $this->global_model->getdata("itinerary", array( "iti_id" => $iti_id ), "customer_id" );
				//Delete last notification for customer if/any
				$where_notif = array( "notification_type" => 3, "customer_id" => $customer_id );
				$this->global_model->delete_data("notifications", $where_notif);
				
				//Create notification if next call time exists
				$title 		= "Price Discount Request";
				$c_date 	= current_datetime();
				$notif_time = date("Y-m-d H:i:s", strtotime( $c_date . " +5 minutes") );
				$body 		= "Price Discount Request For Itinerary By {$agent_username}";
				$notif_link = "itineraries/view/{$iti_id}/{$temp_key}";
				$notification_data = array(
					"customer_id"		=> $customer_id,
					"notification_for"	=> 98, //96 = sales team
					"notification_type"	=> 3, //3 = PRICE PENDING
					"title"				=> $title,
					"body"				=> $body,
					"url"				=> $notif_link,
					"notification_time"	=> $notif_time,
					"agent_id"			=> $agent_id,
				);
				//Insert notification
				$this->global_model->insert_data( "notifications", $notification_data );
				
				/*
				*END NOTIFICATION SECTION
				*/
				
				//sent mail to manager
				$link = "<a class='btn btn-success' target='_blank' href=" . site_url("itineraries/view/{$iti_id}/{$temp_key}") . " title='View'>Click to view itinerary</a>";
				$manager_email = manager_email();
				$to		 = $manager_email;
				$subject = "trackitinerary <Price Discount request of itinerary id: {$iti_id}>";
				$msg = "Price discount request by <strong> {$agent_username} </strong>.<br>";
				$msg .= "{$link}";
				sendEmail($to, $subject, $msg);
				$res = array('status' => true, 'msg' => "Discount request sent successfully.");
			}else{
				$res = array('status' => false, 'msg' => "Discount request not sent.");
			}
		}	
		die( json_encode($res) );
	}	
	
	/* //Sent Itinerary Email */
	public function sendItinerary(){
		$iti_id 			= $this->input->post("iti_id", true);
		$temp_key 			= $this->input->post("temp_key", true);
		$subject 			= $this->input->post("subject", true);
		$customer_email 	= $this->input->post("cus_email", true);
		$customer_contact 	= $this->input->post("contact_number", true);
		$bcc_emails 		= $this->input->post("bcc_email", true);
		$cc_email 			= $this->input->post("cc_email", true);
		$additonal_contact 	= $this->input->post("add_contact_number", true);
		$rate_comment 		= $this->input->post("rate_comment", true);
		
		//increased price in percentage
		$agent_price 		= $this->input->post("inp_inc_price", true);
		$price_update_in 	= $this->input->post("price_update_in", true); //2= iti, 1 = discout iti table
		
		$user = $this->session->userdata('logged_in');
		$user_id = $user['user_id'];
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '96'){
			if( empty($iti_id) && empty($temp_key)  ){
				$res = array('status' => false, 'msg' => "Invalid Itinerary Id.");
				die( json_encode($res) );
			}
			$where = array( "iti_id" => $iti_id, "temp_key" => $temp_key );
			$itinerary = $this->global_model->getdata("itinerary", $where);
			if($itinerary){
				$data['itinerary'] = $itinerary;
				$iti = $itinerary[0];
				$itinerary_id 	= $iti->iti_id;
				$customer_id 	= $iti->customer_id;
				$email_count 	= $iti->email_count;
				


				$data['agentData'] = get_user_all($iti->agent_id);
				//Get customer info
				$get_customer_info = get_customer( $iti->customer_id ); 
				$cust = $get_customer_info[0];
				$customer_name = $cust->customer_name;
				$customer_email = $cust->customer_email;
				$customer_contact = $cust->customer_contact;
			 
				/* Get Agent Information */
				$agent_id = $iti->agent_id;
				$from = get_user_email($agent_id);
				
				//Check if BCC and CC Email exists
				$bccEmails 	= !empty($bcc_emails) ? $bcc_emails : "";
				$ccEmails 	= !empty($cc_email) ? $cc_email : "";
				
				// var_dump($iti->iti_type);die;
				/* //get message template */
				if( $iti->iti_type == 2 ){
					$message = $this->load->view("accommodation/mail", $data, TRUE);
				}else{
					$message = $this->load->view("itineraries/mail", $data, TRUE);
				}
				
				// var_dump($message);die;
				$to = trim( $customer_email );
				/*send email*/
				$sent_mail = sendEmail($to, $subject, $message, $bccEmails, $ccEmails);
				if( $sent_mail ){
					/* send msg for customer on itinerary send */
					$iti_link = site_url("promotion/itinerary/{$iti_id}/{$temp_key}");
					
					$mobile_customer_sms = "Updated Itinerary send to your email {$customer_email}. If you not recieve itinerary in your inbox please find the mail in spam. {$iti_link} .Thanks <Trackitinerary Pvt Ltd.>";
					
					//Check if additional contact is not empty
					$addContact = !empty($additonal_contact) ? $additonal_contact : "";
					$cus_mobile = "{$customer_contact}, {$addContact}";
					if( !empty( $cus_mobile ) ){
						$sendcustomer_sms = pm_send_sms( $cus_mobile, $mobile_customer_sms );
					}
					
					/*Get total email sent to current itinerary*/
					$where = array( "iti_id" => $itinerary_id );
					//$count_email = $this->global_model->getdata( "itinerary", $where, "email_count" );
					if( empty($email_count) ){
						$email_count = 0;
					}
					$email_inc = $email_count+1;
					
					//update Email count status
					$up_data = array(
						'email_count' 			=> $email_inc,
						'quotation_sent_date' 	=> current_datetime(),
						'rate_comment' 			=> $rate_comment,
					);
					$where_iti = array( "iti_id" => $itinerary_id );
					$this->global_model->update_data( "itinerary", $where_iti, $up_data );
					
					//update agent inc price
					if( isset($price_update_in) && $price_update_in > 0 ){
						$where_iti = array( "id" => $price_update_in );
						$this->global_model->update_data( "itinerary_discount_price_data" , $where_iti, array("sent_status" => 1, "agent_price" => $agent_price ) );
					}else{
						$where_iti = array( "iti_id" => $itinerary_id);
						$this->global_model->update_data( "itinerary" , $where_iti, array("agent_price" => $agent_price ) );
					}
					
					//Insert data to email followup
					$inc_data = array(
						"iti_id" 			=> $itinerary_id,
						"customer_id" 		=> $customer_id,
						"customer_name" 	=> $customer_name,
						"customer_contact" 	=> $customer_contact,
						"customer_email" 	=> $customer_email,
						"agent_id" 			=> $user_id,
					);
					$this->global_model->insert_data("iti_email_followup", $inc_data);
					
					$res = array('status' => true, 'msg' => "Itinerary Sent Successfully!");
				}else{
					$res = array('status' => false, 'msg' => "Itinerary Not Sent. Please Try Again Later.");
				}				
				die( json_encode($res) );
			}
		}else{
			redirect(404);
		}		
	}
	
	/* View PDF */
	public function pdf(){
		
		$this->load->library('Pdf');
		$iti_id = trim($this->uri->segment(3));
		$temp_key = trim($this->uri->segment(4));
		if( !empty( $iti_id ) && !empty($temp_key) ){
			$user = $this->session->userdata('logged_in');
			$user_id = $user['user_id'];
			//Get itinerary 
			$where_i = array("del_status" => 0, "iti_id" => $iti_id, "temp_key" => $temp_key);
			$get_iti = $this->global_model->getdata( 'itinerary', $where_i );
			//get view folder
			$view_file = !empty( $get_iti ) && $get_iti[0]->iti_type == 2  ? "accommodation/pdf" : "itineraries/pdf";
			$data['discountPriceData'] 	= $this->global_model->getdata( 'itinerary_discount_price_data', array("iti_id" => $iti_id, "price_status" => 0) );
			$data['flight_details'] = $this->global_model->getdata( "flight_details", array("iti_id" => $iti_id) );
			$data['train_details'] = $this->global_model->getdata( "train_details", array("iti_id" => $iti_id) );
			if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '97'){
				$where = array("del_status" => 0, "iti_id" => $iti_id, "temp_key" => $temp_key );
				$data['itinerary'] 	= $this->global_model->getdata( 'itinerary', $where );
				$this->load->view('inc/header');
				$this->load->view('inc/sidebar');
				$this->load->view($view_file, $data);
				$this->load->view('inc/footer');
			}elseif($user['role'] == '96'){
				//$data['discountPriceData'] 	= $this->global_model->getdata( 'itinerary_discount_price_data', array("iti_id" => $iti_id) );
				$where = array("del_status" => 0, "agent_id" => $user_id, "iti_id" => $iti_id, "temp_key" => $temp_key );
				$data['itinerary'] 		= $this->global_model->getdata( 'itinerary', $where );
				$this->load->view('inc/header');
				$this->load->view('inc/sidebar');
				$this->load->view($view_file, $data);
				$this->load->view('inc/footer');
			}else{
				redirect("dashboard");
			}	 
		}else{
			redirect(404);
		}	
	}
	
	//Clone package to itinerary ajax request
	public function cloneItineraryFromPackageId(){
		$user = $this->session->userdata('logged_in');
		$user_id = $user["user_id"];
		
		$package_id 	= trim($this->input->post('package_id'));
		$customer_id 	= trim($this->input->post('customer_id'));
		$parent_iti_id 	= trim($this->input->post('parent_iti_id'));
		
		//get Agent ID of iti
		$agent_id = $this->global_model->getdata( "itinerary", array("iti_id" => $parent_iti_id), "agent_id" );
		$agent_id = !empty( $agent_id ) ? $agent_id : $user_id;
		
		if(  get_iti_booking_status($parent_iti_id)  == 3 ){
			$res = array('status' => false, 'msg' => "You can't make duplicate itinerary because it's revised itinerary. For more detail contact your manager.");
			die(json_encode($res));
		} 
		
		if( !empty( $package_id ) && !empty( $customer_id ) &&  !empty( $parent_iti_id ) ){
			$insert_id = $this->itinerary_model->createItiFromPackageId("packages", "package_id", $package_id, $customer_id, $agent_id,$parent_iti_id );
			
			if( $insert_id ){
				$getNewIti =  $this->global_model->getdata('itinerary', $where = array("iti_id" => $insert_id) );
				$iti_dataNew = $getNewIti[0];	
				$new_iti_id = $iti_dataNew->iti_id;	
				$temp_key = $iti_dataNew->temp_key;	
				$res = array('status' => true, 'msg' => "Successfully Created" , "iti_id" => $new_iti_id, "temp_key" => $temp_key );
			}else{
				$res = array('status' => false, 'msg' => "Error! Please Try Again");
			}
		}else{
			$res = array('status' => false, 'msg' => "Error! All Fields are required");
		}	
		die(json_encode($res));
	}
	
	//Clone itinerary to amendment
	public function clone_iti_to_amendment(){
		$user = $this->session->userdata('logged_in');
		$user_id = $user['user_id'];
		$iti_id = trim($this->uri->segment(3));
		$clone_old = trim($this->uri->segment(4));
		
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '96'){
			//Check if already amendment request
			$check_iti = $this->global_model->getdata("iti_amendment_temp", array( "iti_id" => trim($iti_id), "new_package_cost" => "" ) );
			$total_amendments = !empty( $check_iti ) ? sizeof($check_iti) : 0 ;
			if( $total_amendments >= 3 ){
				$this->session->set_flashdata('error',"Only two amendment can created.");
				echo "You already created two amendments for this itinerary.For more info contact your manager/administrator.";
				die;
			}else{
				//clone iti to amendment table
				$insert_id = $this->itinerary_model->duplicate_itinerary_for_amendment("itinerary", "iti_id", $iti_id);
				
				//clone same iti to iti_before_amendment table if no amendment created
				//insert_old = if user make multiple amendments
				if( empty($total_amendments) || $clone_old == "insert_old" ){
					$old_iti_id = $this->itinerary_model->duplicate_itinerary_before_amendment("itinerary", "iti_id", $iti_id);
				}	
				
				if( $insert_id ){
					//Update parent itinerary amendment status
					$this->global_model->update_data("itinerary", array("iti_id" => $iti_id), array("is_amendment" => 1 ) );
					
					$getNewIti =  $this->global_model->getdata('iti_amendment_temp', array("id" => $insert_id ) );
					$iti_dataNew = $getNewIti[0];	
					$temp_key = $iti_dataNew->temp_key;	
					//redirect to edit page
					$redirect_url = site_url("itineraries/edit_amendment_iti/{$insert_id}/{$temp_key}");
					redirect( $redirect_url );
					exit;
				}else{
					echo "Error";
				}	
			}
		}else{
			redirect("dashboard");
		}	
	}
	
	/* Edit Amendment Itinerary */
	public function edit_amendment_iti(){
		$id			= trim($this->uri->segment(3));
		$temp_key 	= trim($this->uri->segment(4));
		$user 	= $this->session->userdata('logged_in');
		$user_id = $user['user_id'];
		$data["user_role"] = $user['role']; 
		if( $user['role'] == '99' || $user['role'] == '98'){
			$where = array("del_status" => 0, "id" => $id, "temp_key" => $temp_key );
			$get_iti = $this->global_model->getdata( "iti_amendment_temp", $where );
			$data['itinerary'] = $get_iti;
			//get view folder
			$view_file = !empty( $get_iti ) && $get_iti[0]->iti_type == 2  ? "accommodation/edit_amendment" : "itineraries/edit_amendment";
			
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view($view_file, $data);
			$this->load->view('inc/footer');
		}elseif( $user['role'] == '96' ){
			$where = array("del_status" => 0, "agent_id" => $user_id, "id" => $id, "temp_key" => $temp_key );
			$get_iti = $this->global_model->getdata( "iti_amendment_temp", $where );
			$data['itinerary'] = $get_iti;
			//get view folder
			$view_file = !empty( $get_iti ) && $get_iti[0]->iti_type == 2  ? "accommodation/edit_amendment" : "itineraries/edit_amendment";
			
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view($view_file, $data);
			$this->load->view('inc/footer');
		}else{
			redirect("dashboard");
		}	 
	}
	
	//Edit amendment itinerary
	public function ajax_amendment_iti_savedata(){
		$user = $this->session->userdata('logged_in');
		$role = $user['role'];
		
		if( isset($_POST["temp_key"]) && isset( $_POST['step'] ) ){
			$unique_id 	= trim( $_POST['temp_key'] );
			$id			= trim( $_POST['id'] );
			$step 		= trim($_POST['step']);
			switch( $step ){
				case 1:  
					$package_name 		= strip_tags($_POST['package_name']);
					$package_routing 	= strip_tags($_POST['package_routing']);
					$adults				= strip_tags($_POST['adults']);
					$child				= strip_tags($_POST['child']);
					$child_age			= strip_tags($_POST['child_age']);
					$package_duration 	= strip_tags($_POST['package_duration']);
					$cab_category 		= strip_tags($_POST['cab_category']);
					$rooms_meta 		= serialize($_POST['rooms_meta']);
					
					$step_data = array(
						'package_name' 		=> $package_name,
						'temp_key'			=> $unique_id,
						'package_routing'	=> $package_routing,
						'cab_category'		=> $cab_category,
						'adults'			=> $adults,
						'child'				=> $child,
						'child_age'			=> $child_age,
						'duration'			=> $package_duration,
						'rooms_meta'		=> $rooms_meta,
					);
				break;
				case 2:
					$daywise_meta 		= serialize($this->input->post('tour_meta', TRUE));
					$step_data = array(
						'daywise_meta' 	=> $daywise_meta,
					);
				break;
				case 3:
					$inc_meta					= serialize($this->input->post('inc_meta', TRUE));
					$exc_meta					= serialize($this->input->post('exc_meta', TRUE));
					$special_inc_meta			= serialize($this->input->post('special_inc_meta', TRUE));
					$booking_benefits_meta		= serialize($this->input->post('booking_benefits_meta', TRUE));
					$step_data = array(
						'inc_meta'					=> $inc_meta,
						'exc_meta'					=> $exc_meta,
						'special_inc_meta'			=> $special_inc_meta,
						'booking_benefits_meta'		=> $booking_benefits_meta,
					);
				break;
				case 4:
					$currentDate = $date;
					$hotel_meta				= serialize( $this->input->post('hotel_meta', TRUE) );
					$hotel_note_meta		= serialize( $this->input->post('hotel_note_meta', TRUE) );
					$new_package_cost 		= $this->input->post("new_package_cost", TRUE);
					$step_data = array(
						'hotel_meta'			=> $hotel_meta,
						'hotel_note_meta'		=> $hotel_note_meta,
						'new_package_cost'		=> $new_package_cost,
					);
				break;
			}
			
			//Update data 
			$where_key = array('id' => $id ); 
			$update_data = $this->global_model->update_data("iti_amendment_temp", $where_key, $step_data );
			
			if( $update_data ){
				$res = array('status' => true, 'msg' => "Data save.");
			}else{
				$res = array('status' => false, 'msg' => "Error! Data not save.");
			}
		}else{
			$res = array('status' => false, 'msg' => "Failed! Invalid request try again.");
		}
		die(json_encode($res));
	}
	
	//View Old Itinerary before amendment
	public function view_old_iti(){
		$user = $this->session->userdata('logged_in');
		$user_id = $user['user_id'];
		$data["user_id"] = $user_id;
		$data["user_role"] = $user['role']; 
		$id = trim($this->uri->segment(3));
		
		
			
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '97'){
			$where = array("del_status" => 0, "id" => $id);
			
			$data['itinerary'] 	= $this->global_model->getdata( 'iti_before_amendment', $where );
			$iti_id = !empty( $data['itinerary'] ) ? $data['itinerary'][0]->iti_id : "";
			
			//get amendment itineraries if new price is not updated
			//$data['old_itineraries'] = $this->global_model->getdata( 'iti_before_amendment', array( "iti_id" => $iti_id ) );
		
			//get view folder
			$view_file = !empty( $data['itinerary'] ) && $data['itinerary'][0]->iti_type == 2  ? "accommodation/view_old_iti" : "itineraries/view_old_iti";
			
			//Get Payment Transaction Details
			$data["payment_details"] = $this->global_model->getdata("iti_payment_details", array("iti_id" => $iti_id) );
			
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view($view_file, $data);
			$this->load->view('inc/footer');
		}elseif($user['role'] == '96'){
			$where = array("del_status" => 0, "agent_id" => $user_id, "id" => $id, );
			$data['itinerary'] = $this->global_model->getdata( 'iti_before_amendment', $where );
			$iti_id = !empty( $data['itinerary'] ) ? $data['itinerary'][0]->iti_id : "";
			
			//get amendment itineraries if new price is not updated
			//$data['old_itineraries'] = $this->global_model->getdata( 'iti_before_amendment', array( "iti_id" => $iti_id ) );
			//Get Payment Transaction Details
			$data["payment_details"] = $this->global_model->getdata("iti_payment_details", array("iti_id" => $iti_id) );
			
			//get view folder
			$view_file = !empty( $data['itinerary'] ) && $data['itinerary'][0]->iti_type == 2  ? "accommodation/view_old_iti" : "itineraries/view_old_iti";
			
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view($view_file, $data);
			$this->load->view('inc/footer');
		}else{
			redirect("dashboard");
		}
	}
	//Amendment Itinerary View
	public function view_amendment(){
		$user = $this->session->userdata('logged_in');
		$user_id = $user['user_id'];
		$data["user_id"] = $user_id;
		$data["user_role"] = $user['role']; 
		$id = trim($this->uri->segment(3));
		
		if( $user['role'] == '99' || $user['role'] == '98'){
			$where = array("del_status" => 0, "id" => $id);
			$data['itinerary'] 	= $this->global_model->getdata( 'iti_amendment_temp', $where );
			$iti_id = !empty( $data['itinerary'] ) ? $data['itinerary'][0]->iti_id : "";
			
			//get amendment itineraries if new price is not updated
			$data['old_itineraries'] = $this->global_model->getdata( 'iti_before_amendment', array( "iti_id" => $iti_id ) );
			
			//get view folder
			$view_file = !empty( $data['itinerary'] ) && $data['itinerary'][0]->iti_type == 2  ? "accommodation/view_amendment" : "itineraries/view_amendment";
			
			//Get Payment Transaction Details
			$data["payment_details"] = $this->global_model->getdata("iti_payment_details", array("iti_id" => $iti_id) );
			
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view($view_file, $data);
			$this->load->view('inc/footer');
		}elseif($user['role'] == '96'){
			$where = array("del_status" => 0, "agent_id" => $user_id, "id" => $id, );
			$data['itinerary'] = $this->global_model->getdata( 'iti_amendment_temp', $where );
			$iti_id = !empty( $data['itinerary'] ) ? $data['itinerary'][0]->iti_id : "";
			//Get Payment Transaction Details
			$data["payment_details"] = $this->global_model->getdata("iti_payment_details", array("iti_id" => $iti_id) );
			//get amendment itineraries if new price is not updated
			$data['old_itineraries'] = $this->global_model->getdata( 'iti_before_amendment', array( "iti_id" => $iti_id ) );
			//get view folder
			$view_file = !empty( $data['itinerary'] ) && $data['itinerary'][0]->iti_type == 2  ? "accommodation/view_amendment" : "itineraries/view_amendment";
			
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view($view_file, $data);
			$this->load->view('inc/footer');
		}else{
			redirect("dashboard");
		}
	}
	
	//Amendment request to manager by agent
	public function amendment_price_request_to_manager(){
		$user 			= $this->session->userdata('logged_in');
		$user_id 		= $user['user_id'];
		$iti_id		 	= $this->input->post('iti_id', TRUE);
		$id 			= $this->input->post('id', TRUE);
		$review_comment = strip_tags($this->input->post('review_comment', TRUE));
		
		$agent_username = get_user_name( trim( $user_id ) );
		
		if( !empty( $iti_id ) && is_numeric($iti_id) ){
			$link = "<a class='btn btn-success' target='_blank' href=" . site_url("itineraries/view_amendment/{$id}") . " title='View'>Click to view itinerary</a>";
			
			//update pending_price status
			$where = array( "id" => trim($id) );
			$update_data = $this->global_model->update_data("iti_amendment_temp", $where, array("sent_for_review" => 1, "review_update_date" => current_datetime(), "review_comment" => $review_comment ) );
			
			
			/**
			* NOTIFICATION SECTION 
			*/
			$customer_id = $this->global_model->getdata("itinerary", array( "iti_id" => $iti_id ), "customer_id" );
			//Delete last notification for customer if/any 3=price request
			$where_notif = array( "notification_type" => 3, "customer_id" => $customer_id );
			$this->global_model->delete_data("notifications", $where_notif);
			
			//Create notification if next call time exists
			$title 		= "Amendment Price Request";
			$c_date 	= current_datetime();
			$notif_time = date("Y-m-d H:i:s", strtotime( $c_date . " +5 minutes") );
			$body 		= "Amendment Itinerary Price Request {$agent_username}";
			$notif_link = "itineraries/view_amendment/{$id}";
			$notification_data = array(
				"customer_id"		=> $customer_id,
				"notification_for"	=> 98, //96 = sales team
				"notification_type"	=> 3, //3 = PRICE PENDING
				"title"				=> $title,
				"body"				=> $body,
				"url"				=> $notif_link,
				"notification_time"	=> $notif_time,
				"agent_id"			=> $user_id,
			);
			//Insert notification
			$this->global_model->insert_data( "notifications", $notification_data );
			
			/*
			*END NOTIFICATION SECTION
			*/
			
			
			//sent mail to manager
			$manager_email = manager_email();
			$admin_email = admin_email();
			$to	= array( $manager_email, $admin_email );
			$subject = "trackitinerary <price Amendment request of itinerary id: {$iti_id}>";
			$msg = "Itnerary amendment request By Agent: <strong> {$agent_username} </strong>.<br>";
			$msg .= "{$link}";
			$sent_mail = sendEmail($to, $subject, $msg);
			if( $sent_mail ){ 
				$res = array('status' => true, 'msg' => "Request Sent Successfully");
			}else{
				$res = array('status' => false, 'msg' => "Request not sent successfully");
			}	 
		}else{
			$res = array('status' => false, 'msg' => "Error! please try again later");
		}
		die(json_encode($res));
	}
	
	//update Amendment price by manager
	public function update_amendment_price_by_manager(){
		if( isset($_POST["iti_id"]) && !empty($_POST["new_package_cost"]) ){
			$iti_id = trim( $_POST['iti_id'] );
			$agent_id = trim( $_POST['agent_id'] );
			$id = trim( $_POST['id'] );
			$new_package_cost	= strip_tags($this->input->post('new_package_cost', TRUE));
			
			//$is_gst		= isset( $_POST['is_gst'] ) ? 1 : 0;
			$is_gst			= 1;
			
			//pending_price = 2 (for approved price) 
			$update_data = array(
				'new_package_cost'		=> $new_package_cost,
				'sent_for_review'		=> 2,
				'review_update_date'	=> current_datetime(),
				'is_gst'				=> $is_gst,
			);
			
			//Update data 
			$where = array('id' => $id ); 
			$update = $this->global_model->update_data("iti_amendment_temp", $where, $update_data );
			
			if( $update ){
				/**
				* NOTIFICATION SECTION 
				*/
				$customer_id = $this->global_model->getdata("itinerary", array( "iti_id" => $iti_id ), "customer_id" );
				//Delete last notification for customer if/any
				$where_notif = array( "notification_type" => 3, "customer_id" => $customer_id );
				$this->global_model->delete_data("notifications", $where_notif);
				
				//Create notification if next call time exists
				$title 		= "Amendment Price Approved";
				$c_date 	= current_datetime();
				$notif_time = date("Y-m-d H:i:s", strtotime( $c_date . " +5 minutes") );
				$body 		= "Amendment Itinerary Price Approved By Manager";
				$notif_link = "itineraries/view_amendment/{$id}";
				$notification_data = array(
					"customer_id"		=> $customer_id,
					"notification_for"	=> 96, //96 = sales team
					"title"				=> $title,
					"body"				=> $body,
					"url"				=> $notif_link,
					"notification_time"	=> $notif_time,
					"agent_id"			=> $agent_id,
				);
				//Insert notification
				$this->global_model->insert_data( "notifications", $notification_data );
				
				/*
				*END NOTIFICATION SECTION
				*/
			
				//sent mail to agent after price updated
				$link = "<a class='btn btn-success' target='_blank' href=" . site_url("itineraries/view_amendment/{$id}") . " title='View'>Click to view itinerary</a>";
				$to		 = get_user_email($agent_id);;
				$subject = "trackitinerary <Amendment In Price of Itinerary id: {$iti_id}>";
				$msg = "Price successfully updated by manager.Click below link to view itinerary.<br>";
				$msg .= "{$link}";
				
				$sent_mail = sendEmail($to, $subject, $msg);
				$res = array('status' => true, 'msg' => "Data save.");
			}else{
				$res = array('status' => false, 'msg' => "Data not save.");
			}
		}else{
			$res = array('status' => false, 'msg' => "Please Enter Valid New Price.");
		}	
		die(json_encode($res));
	}
	
	//Update hotel/volvo/flight booking status
	public function ajax_update_booking_status(){
		$user 			= $this->session->userdata('logged_in');
		$user_id		= $user['user_id'];
		$iti_id 		= $this->input->post("iti_id", true);
		$booking_type 	= $this->input->post("type", true);
		$b_type 		= $this->input->post("b_type", true);
		$btype			= ucfirst($b_type);
		
		$account_team_email = get_accounts_team_email();
		// var_dump($account_team_email);die;
		
		//check if iti status already updated
		$check_iti = $this->global_model->getdata("iti_vouchers_status", array("iti_id" => $iti_id ));
		if( $check_iti ){
			$up_data = array( $booking_type => 1, "agent_id" => $user_id  );
			$update_data	= $this->global_model->update_data("iti_vouchers_status", array("iti_id" => $iti_id ), $up_data );
		}else{
			$ins_d = array( $booking_type => 1, "iti_id" => $iti_id, "agent_id" => $user_id );
			$insert_data = $this->global_model->insert_data("iti_vouchers_status", $ins_d );
			$update_data =	$this->global_model->update_data("iti_vouchers_status", array("iti_id" => $iti_id ), array("voucher_id" => "VOU00-". $insert_data ) );
			
			//UPDATE VOUCHER ID
			$this->global_model->insert_data("iti_vouchers_status", array("id" => $insert_data), array("voucher_id" => "VOU00-". $insert_data ) );
			
		}
		
		if( $update_data || $insert_data ){
			$link_u = iti_view_single_link( $iti_id );
			//SEND MAIL TO volvo/train team 
			if( $b_type == "hotel" ){
				$to = hotel_booking_email();
			}else if( $b_type = "cab" ){
				$to = get_cab_team_email();
			}else{
				$to = vehicle_booking_email();
			}
			
			//sent mail to agent after price updated
			$link = "<a class='btn btn-success' target='_blank' href=" . $link_u . " title='View'>Click to view Booking</a>";
			
			$sub 			= "{$btype} Booking done by  service team <Trackitinerary.org>";
			$msg 			= "{$btype} booking done by service team.Please review itinerary.<br>";
			$msg 			.= "Itinerary Id: {$iti_id} <br>";
			$msg 			.= "{$link}<br>";
			
			//send mail to account team 
			$sent_mail	 = sendEmail($account_team_email, $sub, $msg);
			$this->session->set_flashdata('success',"Booking Status Updated Successfully.");
			$res = array( "status" => true, "msg" => "Booking Status Updated Successfully." );
		}else{
			$res = array( "status" => false, "msg" => "Booking Status Not Updated. Please try again." );
		}
		die( json_encode( $res ) );
	}	
	
	//Update Confirm voucher status
	public function ajax_confirm_voucher_status(){
		$user = $this->session->userdata('logged_in');
		$user_id = $user['user_id'];
		$iti_id 		= $this->input->post("iti_id", true);
		$agent_comment 	= $this->input->post("agent_comment", true);
		//check if iti status already updated
		$check_iti = $this->global_model->getdata("iti_vouchers_status", array("iti_id" => $iti_id ));
		$data = array( "iti_id" => $iti_id, "" );
		
		if( $check_iti ){
			$up_data = array( "confirm_voucher" => 1, "agent_comment" => $agent_comment,  "agent_id" => $user_id  );
			$update_data	= $this->global_model->update_data("iti_vouchers_status", array("iti_id" => $iti_id ), $up_data );
		}
		
		if( $update_data ){
			$this->session->set_flashdata('success', "Voucher Confirmed Successfully.");
			$res = array( "status" => true, "msg" => "Voucher Confirmed Successfully." );
		}else{
			$res = array( "status" => false, "msg" => "Voucher not confirmed. Please try again." );
		}
		die( json_encode( $res ) );
	}
	
	
	//update on hold status by sales manager
	public function update_iti_onhold_status(){
		$user = $this->session->userdata('logged_in');
		$user_id = $user['user_id'];
		if( ( $user['role'] == 99 || $user['role'] == 98 ) && !empty( $_POST['iti_id'] ) ){
			$iti_id 		= $this->input->post("iti_id");
			$get_iti_d 		= $this->global_model->getdata("itinerary", array( "iti_id" => $iti_id ) );
			$temp_key 		= $get_iti_d[0]->temp_key;
			$agent_id 		= $get_iti_d[0]->agent_id;
			$customer_id 	= $get_iti_d[0]->customer_id;
			//$customer_name 	= $get_iti_d[0]->customer_name;
			//$customer_email = $get_iti_d[0]->customer_email;
			//$customer_contact = $get_iti_d[0]->customer_contact;
			$final_amount = $get_iti_d[0]->final_amount;
			
			//Get customer info
			$get_customer_info = get_customer($customer_id); 
			//$customer_name = $customer_contact = $customer_email = $state_id = $count "";
			
			//if( $get_customer_info ){
			$cust = $get_customer_info[0];
			$customer_name 		= isset( $get_customer_info[0]->customer_name ) ? $cust->customer_name : "";
			$customer_contact 	= isset( $get_customer_info[0]->customer_contact ) ?  $cust->customer_contact : "";
			$customer_email		= isset( $get_customer_info[0]->customer_email ) ? $cust->customer_email : "";
			$state_id			= isset( $get_customer_info[0]->state_id ) ? $cust->state_id : "";
			$country_id		= isset( $get_customer_info[0]->country_id ) ? $cust->country_id : "";
			//} 
			
			//check form action
			if( isset( $_POST['action']) ){
				$action = "approved";
				$approved_note 	= $this->input->post("approved_note");
			}else if (isset($_POST['action_reject'])){
				$action = "reject";
				$approved_note 	= $this->input->post("reject_note");
			}else{
				$action = "";
				$approved_note 	= $this->input->post("approved_note");
			}
			
			//$doc_path =  dirname($_SERVER["SCRIPT_FILENAME"]).'/site/assets/client_docs/' . $iti_id . '/';
			$doc_path =  dirname($_SERVER["SCRIPT_FILENAME"]) . '/site/assets/client_docs/'. date("Y") . '/' . date("m") . '/'  . $iti_id . '/'; 
			$aahar_card_image_name = "";
			$payment_image_name = "";
			
			$update_data = array("approved_note" => $approved_note );
			
			if( $action == "approved" ){
				$get_pay_data = $this->global_model->getdata("iti_payment_details", array( "iti_id" => $iti_id ));
				
				$file_prefix = date("Y") . "/".  date("m") . "/" . $iti_id . "/";
				if( isset( $_FILES['client_aadhar_card']['name'] ) && !empty( $_FILES['client_aadhar_card']['name'] ) ){
					$f_n = $_FILES['client_aadhar_card']['name'];
					$n = str_replace(' ', '_', $f_n);
					//$file_name = $iti_id . "_adhar_{$user_id}_"  . $n;
					$file_name = $iti_id . "_adhar_{$user_id}_"  . $n;
					
					//check if path exists
					if(!is_dir($doc_path)){
						if (!mkdir($doc_path, 0777, true)) {
							//return false;
							$res = array('status' => false, 'msg' => "File not uploaded. Please contact administrator.");
							die( json_encode($res) );
						}
					}
					
					$config['upload_path'] = $doc_path;
					$config['allowed_types'] = 'jpg|jpeg|png';
					$config['max_size'] = 1024 * 2;
					$config['max_width']  = 5000;
					$config['max_height'] = 3500;
					$config['file_name'] = $file_name;
					$this->load->library('upload', $config);
					
					if(!$this->upload->do_upload('client_aadhar_card')){
						$err = $this->upload->display_errors();
						$res = array('status' => false, 'msg' => "{$err}");
						die( json_encode($res) );
					}else{
						$data = $this->upload->data();
						$update_data['client_aadhar_card'] = $file_prefix . $data['file_name'];
					}
					unset($config);
				}
				
				//payment screenshot upload payment_screenshot/client_aadhar_card
				if( isset( $_FILES['payment_screenshot']['name'] ) && !empty( $_FILES['payment_screenshot']['name'] ) ){
					unset($config);
					$f_n = $_FILES['payment_screenshot']['name'];
					$n = str_replace(' ', '_', $f_n);
					//$file_name = $iti_id . "_payment_{$user_id}_"  . $n;
					$file_name = $iti_id . "_payment_{$user_id}_"  . $n;
					
					//check if path exists
					if(!is_dir($doc_path)){
						if (!mkdir($doc_path, 0777, true)) {
							//return false;
							$res = array('status' => false, 'msg' => "File not uploaded. Please contact administrator.");
							die( json_encode($res) );
						}
					}
					
					$config['upload_path'] = $doc_path;
					$config['allowed_types'] = 'jpg|jpeg|png';
					$config['max_size'] = 1024 * 2;
					$config['max_width']  = 5000;
					$config['max_height'] = 3000;
					$config['file_name'] = $file_name;
					$this->load->library('upload', $config);
					
					if(!$this->upload->do_upload('payment_screenshot')){
						$err = $this->upload->display_errors();
						$res = array('status' => false, 'msg' => "{$err}");
						die( json_encode($res) );
					}else{
						$data = $this->upload->data();
						$update_data['payment_screenshot'] = $file_prefix . $data['file_name'];
					}
					unset($config);
				}
				
				//$this->do_multiple_upload('iti_clients_docs[]');
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
					
					foreach( $upload_files as $ind=>$file){
						$upload_docs_data[$ind]['file_url'] 	= $file_prefix . $file;
						$upload_docs_data[$ind]['comment'] 		= isset( $_POST['comment'][$ind] ) ? $_POST['comment'][$ind] : "";
						$upload_docs_data[$ind]['iti_id'] 		= $iti_id;
						$upload_docs_data[$ind]['customer_id'] 	= $customer_id;
						$upload_docs_data[$ind]['agent_id'] 	= $user_id;
					}
				}
				
				//insert client docs
				if( !empty( $upload_docs_data ) ){
					$this->global_model->insert_batch_data("iti_clients_docs", $upload_docs_data );
				}	
				
				//change iti status to approved 0 =approved
				$iti_package_type = isset( $_POST['package_type_iti'] ) ?  $_POST['package_type_iti'] : "";
				$update_data['iti_booking_status'] = 0;
				$update_data['iti_package_type'] = $iti_package_type;
				$this->global_model->update_data("iti_payment_details", array( "iti_id" => $iti_id ), $update_data );
				
				/**************************************
				****** ADD CUSTOMER ACCOUNT DETAILS ***
				***************************************/
				
				//check if account exists by customer email or contact
				$chec_cus_acc = check_customer_account_exists( $customer_email, $customer_contact );
				if( $chec_cus_acc ){
					$cus_idd = $chec_cus_acc->id;
					//check if iti id exists ac_booking_reference_details
					$chk_booking_id = $this->global_model->getdata("ac_booking_reference_details", array( "iti_id" => $iti_id ) );
					if( empty( $chk_booking_id ) ){
						$this->global_model->insert_data("ac_booking_reference_details", array("cus_account_id" => $cus_idd, "lead_id" => $customer_id, "iti_id" => $iti_id ) );
					}
				}else{
					$acc_cus_data = array(
						'customer_name' => $customer_name,
						'customer_email' => $customer_email,
						'customer_contact' => $customer_contact,
						'state_id'		=> $state_id,
						'country_id' 	=> $country_id,
						'updated_by' 	=> $user_id,
					);
					
					$last_in_id = $this->global_model->insert_data("ac_customer_accounts", $acc_cus_data );
					//insert iti id to booking table
					$this->global_model->insert_data("ac_booking_reference_details", array("cus_account_id" => $last_in_id, "lead_id" => $customer_id, "iti_id" => $iti_id ) );
				}
				
				/**************************************
				****** END CUSTOMER ACCOUNT DETAILS ***
				***************************************/
				
				//sent mail to client and agent tmp
				$manager_email 	= manager_email();
				//$hotel_booking_email = hotel_booking_email();
				$get_accounts_team_email = get_accounts_team_email();
				//$admins 		= array( $hotel_booking_email, "accounts1@Trackitinerary.in" );
				$admins 		= array( $get_accounts_team_email );
				$to				= get_customer_email( $customer_id );
				
				//sent mail to agent after price updated
				$link = "<a class='btn btn-success' target='_blank' href=" . site_url("itineraries/view/{$iti_id}/{$temp_key}") . " title='View'>Click to view itinerary</a>";
				$linkClientView = "<a title='View' target='_blank' href=" . site_url("promotion/itinerary/{$iti_id}/{$temp_key}") . " class='btn btn-success' >Click to check itinerary</a>";
				$sub 			= "New Itinerary Booked <Trackitinerary.org>";
				$msg 			= "Itinerary Booked <br>";
				$msg 			.= "Final Amount: {$final_amount} <br>";
				$msg 			.= "Itinerary Id: {$iti_id} <br>";
				$msg 			.= "Customer Name: {$customer_name} <br>";
				$msg 			.= "{$link}<br>";
				
				//send mail to manager and admin
				$sent_mail_admins	 = sendEmail($admins, $sub, $msg);
				
				//client message				
				$sub_c 			= "Itinerary Booked <Trackitinerary.org>";				
				$msg_c 			= "Itinerary Booked <br>";
				$msg_c 			.= "Final Amount: {$final_amount} <br>";
				$msg_c 			.= "Itinerary Id: {$iti_id} <br>";				
				//check if next ins. pending
				if( isset($get_pay_data[0]) && !empty($get_pay_data[0]->travel_date) ){
					$msg_c 	.= !empty( $get_pay_data[0]->second_payment_bal ) ? " Second Installment Dated on " . $get_pay_data[0]->second_payment_date . " of Rs. " . $get_pay_data[0]->second_payment_bal . " . If already paid please ignore this.<br>" : "";
					
					$msg_c 	.= !empty( $get_pay_data[0]->third_payment_bal ) ? " Third Installment Dated on " . $get_pay_data[0]->third_payment_date . " of Rs. " . $get_pay_data[0]->third_payment_bal . " . If already paid please ignore this. <br>"  : "";
				}				
				$msg_c 		.= "{$linkClientView}<br>";
				$msg_c 		.= " Thanks <Trackitinerary><br>";				
				//send mail to customer
				$sent_mail	 = sendEmail($to, $sub_c, $msg_c);
				
				
				
				/* send msg for customer on Itinerary Booked */
				$iti_link = site_url("promotion/itinerary/{$iti_id}/{$temp_key}");
				
				$mobile_customer_sms = "Your itinerary is booked. Please {$iti_link} .For more info contact us. Thanks<Trackitinerary>";
				$cus_mobile = "{$customer_contact}";
				if( !empty( $cus_mobile ) ){
					$sendcustomer_sms = pm_send_sms( $cus_mobile, $mobile_customer_sms );
				}
				
				/*
				* NOTIFICATION SECTION
				*/
				
				//Delete last notification for customer if/any
				//notification_type = 4 for payment
				$where_notif 		= array( "notification_type" => 4, "customer_id" => $customer_id );
				$this->global_model->delete_data( "notifications", $where_notif );
				//Create notification if next call time exists
				if( isset($get_pay_data[0]) && !empty( $get_pay_data[0]->next_payment_due_date )  ){					
					$nxtPay 	= $get_pay_data[0]->next_payment_due_date;
					$py_id 		= $get_pay_data[0]->id;
					$title 		= "Payment Pending";
					$c_date 	= date("Y-m-d", strtotime($nxtPay ));
					$notif_time = date("Y-m-d H:i:s", strtotime( $c_date . " 11:15:00") );
					$body 		= "Payment Pending Of Itinerary ID : {$iti_id}";
					$notif_link = "payments/update_payment/{$py_id}/{$iti_id}";
					$notif_link_ag = "itineraries/view/{$iti_id}/{$temp_key}";
					
					//if less then 50% payment received send notification to agent
					/* $total_payment_recieved_percentage = get_iti_pay_receive_percentage( $get_pay_data[0]->iti_id );
					if( $total_payment_recieved_percentage < 50 ){
						$agent_notify = array(
							"customer_id"		=> $customer_id,
							"notification_for"	=> 96, //96 = sales team
							"notification_type"	=> 4, //4 = payment pending
							"title"				=> $title,
							"body"				=> $body,
							"url"				=> $notif_link_ag,
							"notification_time"	=> $notif_time,
							"agent_id"			=> $agent_id
						);
						//Insert notification
						$this->global_model->insert_data( "notifications", $agent_notify );
					} */
					
					//notification to service team
					$notification_data = array(
						"customer_id"		=> $customer_id,
						"notification_for"	=> 93, //93 = accounts team
						"notification_type"	=> 4, //4 = payment pending
						"title"				=> $title,
						"body"				=> $body,
						"url"				=> $notif_link,
						"notification_time"	=> $notif_time,
						"agent_id"			=> $user_id,
					);
					
					//Insert notification
					$this->global_model->insert_data( "notifications", $notification_data );
				}
				
				/*
				* NOTIFICATION SECTION 
				*/
				
				//Delete last notification for customer if/any
				//notification_type = 2 for iti followup and 3 = price request
				//$where_notif 		= array( "notification_type" => 2, "customer_id" => $customer_id );
				//$where_notif_iti 	= array( "notification_type" => 3, "customer_id" => $customer_id );
				//$this->global_model->delete_data("notifications", $where_notif_iti);
				//$this->global_model->delete_data("notifications", $where_notif);
				
				$where_notif = "notification_type IN (2,3) AND customer_id = {$customer_id}";
				$this->global_model->delete_data_custom("notifications", $where_notif );
				
				//Create notification if next call time exists
				$agent_name = get_user_name( $agent_id );
				$title 		= "New Iti Booked";
				$c_date 	= current_datetime();
				$notif_time = date("Y-m-d H:i:s", strtotime( $c_date . " +10 minutes") );
				$body 		= "New Itinerary Booked By {$agent_name}";
				$title_agent = "Itinerary Verified";
				$body_agent	= "Itinerary Verified By Sales Manager";
				$notif_link_agent = "itineraries/view/{$iti_id}/{$temp_key}?firework=true";
				$notif_link = "itineraries/view/{$iti_id}/{$temp_key}";
				
				$notification_datan = array(
				
					array(
						"customer_id"		=> $customer_id,
						"notification_for"	=> 96, //96 = sales team
						"title"				=> $title_agent,
						"body"				=> $body_agent,
						"url"				=> $notif_link_agent,
						"notification_time"	=> $notif_time,
						"agent_id"			=> $agent_id,
					),
					
					/*
					array(
						"customer_id"		=> $customer_id,
						"notification_for"	=> 97, //97 = service team
						"title"				=> $title,
						"body"				=> $body,
						"url"				=> $notif_link,
						"notification_time"	=> $notif_time,
						"agent_id"			=> $agent_id,
					) */
				);
				
				//Insert notification
				$this->global_model->insert_batch_data( "notifications", $notification_datan );
				
				/**
				* END NOTIFICATION SECTION
				**/
				$this->session->set_flashdata('success',"Itinerary Approved Successfully.");
				$res = array('status' => true, 'msg' => "APPROVED Successfully.");
				
			}else if( $action == "reject" ){
				$reject_due_to = $this->input->post("reject_due_to");
				
				//change iti status to approved 0 =approved , 2 = rejected
				$reject_code = !empty($reject_due_to) ? trim($reject_due_to) : 2 ;
				
				$update_data['iti_booking_status'] = !empty($reject_due_to) ? trim($reject_due_to) : 2 ;
				$this->global_model->update_data("iti_payment_details", array( "iti_id" => $iti_id ), $update_data );
				
				if( $reject_code == 3 ){
					$update_iti_data = array("iti_status" => 6, "iti_reject_comment" => $approved_note );
				}else{
					$update_iti_data = array("iti_reject_comment" => $approved_note );
				}
				$this->global_model->update_data("itinerary", array( "iti_id" => $iti_id ),  $update_iti_data );
				
				/*
				* NOTIFICATION SECTION 
				*/
				
				//Delete last notification for customer if/any
				//notification_type = 2 for iti followup and 3 = price request
				//$where_notif 		= array( "notification_type" => 2, "customer_id" => $customer_id );
				//$where_notif_iti 	= array( "notification_type" => 3, "customer_id" => $customer_id );
				//$this->global_model->delete_data("notifications", $where_notif_iti);
				//$this->global_model->delete_data("notifications", $where_notif);
				
				$where_notif = "notification_type IN (2,3) AND customer_id = {$customer_id}";
				$this->global_model->delete_data_custom("notifications", $where_notif );
				
				//Create notification if next call time exists
					$agent_name = get_user_name( $agent_id );
					$title 		= "Itinerary Rejected";
					$c_date 	= current_datetime();
					$notif_time = date("Y-m-d H:i:s", strtotime( $c_date . " +10 minutes") );
					$body_agent	= "Itinerary Rejected By Sales Manager";
					$notif_link = "itineraries/view/{$iti_id}/{$temp_key}";
					
					$notification_datan = array(
						array(
							"customer_id"		=> $customer_id,
							"notification_for"	=> 96, //96 = sales team
							"title"				=> $title,
							"body"				=> $body_agent,
							"url"				=> $notif_link,
							"notification_time"	=> $notif_time,
							"agent_id"			=> $agent_id,
						)
					);
					
					//Insert notification
					$this->global_model->insert_batch_data( "notifications", $notification_datan );
					
					/**
					* END NOTIFICATION SECTION
					**/
				$this->session->set_flashdata('success',"Itinerary Rejected Successfully.");
				$res = array('status' => true, 'msg' => "Rejected Successfully.");
				
			}else{
				$res = array('status' => false, 'msg' => "Invalid Action.");
			}
			die( json_encode($res) );
		}	
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

	//update rejected booking by agent iti_note
	function update_reject_iti_booking_agent(){
		$user = $this->session->userdata('logged_in');
		$user_id = $user['user_id'];
		$reject_type	= $this->input->post("reject_type", true);
		$iti_id			= $this->input->post("iti_id", true);
		$customer_id	= $this->input->post("customer_id", true);
		$temp_key		= $this->input->post("temp_key", true);
		$agent_id		= $this->input->post("iti_id", true);
		$iti_note		= $this->input->post("iti_note_booked", true);
		
		// 2 = update payment details
		//if( $reject_type == 2 ){
			//$doc_path =  dirname($_SERVER["SCRIPT_FILENAME"]).'/site/assets/client_docs/' . $iti_id . '/';
			$doc_path =  dirname($_SERVER["SCRIPT_FILENAME"]) . '/site/assets/client_docs/'. date("Y") . '/' . date("m") . '/'  . $iti_id . '/'; 
			
			$approved_package_category = $this->input->post('approved_package_category');
			$final_amount 			= strip_tags($this->input->post("final_amount", TRUE));
			
			/* Add Payment Details */
			$next_payment_bal 	= strip_tags($this->input->post("next_payment_bal", TRUE));
			$next_payment_date 	= strip_tags($this->input->post("next_payment_date", TRUE));
			
			$third_payment_bal 	= strip_tags($this->input->post("third_payment_bal", TRUE));
			$third_payment_date = strip_tags($this->input->post("third_payment_date", TRUE));
			$final_payment_bal 	= strip_tags($this->input->post("final_payment_bal", TRUE));
			$final_payment_date = strip_tags($this->input->post("final_payment_date", TRUE));
			
			$total_balance 		= strip_tags($this->input->post("total_balance", TRUE));
			$booking_date		= strip_tags($this->input->post("booking_date", TRUE));
			$f_amount 			= $final_payment_bal;
			
			if( empty( $next_payment_bal ) && empty($final_amount) && empty( $iti_id ) ){
				$res = array('status' => false, 'msg' => "All Fields are required!");
				die( json_encode($res) );
			}elseif(  !is_numeric( $final_amount ) ){
				$res = array('status' => false, 'msg' => "Please Enter Valid Amount!");
				die( json_encode($res) );
			}
			
			$nxtPay 		= !empty( $next_payment_bal ) ? $next_payment_date : "";
			$third_ins_date = !empty( $third_payment_bal ) ? $third_payment_date : "";
			$f_date 		= !empty( $f_amount ) ? $final_payment_date : "";
			
			//Check for paid/unpaid
			$secPaid 		= !empty( $next_payment_bal ) ? "unpaid" : "";
			$thr_paid 		= !empty( $third_payment_bal ) ? "unpaid" : "";
			$f_paid 		= !empty( $f_amount ) ? "unpaid" : "";
			//$is_gst		= isset( $_POST['is_gst'] ) ? 1 : 0;
			$is_gst			= 1;
			
			$iti_package_type = isset( $_POST['package_type_iti'] ) ?  $_POST['package_type_iti'] : "";
			
			//payment details u_id
			$payData = array(
				'total_package_cost'	=> $final_amount,
				'package_actual_cost'	=> $final_amount,
				'booking_date'			=> $booking_date,
				'next_payment'			=> $next_payment_bal,
				'next_payment_due_date'	=> $nxtPay,
				'second_payment_bal'	=> $next_payment_bal,
				'second_payment_date'	=> $nxtPay,
				'second_pay_status'		=> $secPaid,
				'third_payment_bal'		=> $third_payment_bal,
				'third_payment_date'	=> $third_ins_date,
				'third_pay_status'		=> $thr_paid,
				'final_payment_bal'		=> $f_amount,
				'final_payment_date'	=> $f_date,
				'final_pay_status'		=> $f_paid,
				'total_balance_amount'	=> $total_balance,
				'approved_note'			=> $iti_note,
				'iti_booking_status'	=> 1, // 1= on hold
				'is_gst'				=> $is_gst, //1= gst included
				'iti_package_type'		=> $iti_package_type, 
			);
			
			$file_prefix = date("Y") . "/".  date("m") . "/" . $iti_id . "/";
			
			//aadhar card upload
			if( isset( $_FILES['client_aadhar_card']['name'] ) && !empty( $_FILES['client_aadhar_card']['name'] ) ){
				$f_n = $_FILES['client_aadhar_card']['name'];
				$n = str_replace(' ', '_', $f_n);
				//$file_name = $iti_id . "_adhar_{$agent_id}_"  . $n;
				
				$file_name = $iti_id . "_adhar_{$agent_id}_"  . $n;
				//check if path exists
				if(!is_dir($doc_path)){
					if (!mkdir($doc_path, 0777, true)) {
						//return false;
						$res = array('status' => false, 'msg' => "File not uploaded. Please contact administrator.");
						die( json_encode($res) );
					}
				}
				
				
				$config['upload_path'] = $doc_path;
				$config['allowed_types'] = 'jpg|jpeg|png';
				$config['max_size'] = 1024 * 2;
				$config['max_width']  = 5000;
				$config['max_height'] = 3000;
				$config['file_name'] = $file_name;
				$this->load->library('upload', $config);
				
				if(!$this->upload->do_upload('client_aadhar_card')){
					$err = $this->upload->display_errors();
					$res = array('status' => false, 'msg' => "{$err}");
					die( json_encode($res) );
				}else{
					$data = $this->upload->data();
					$payData["client_aadhar_card"] = $file_prefix . $data['file_name'];
				}
				unset($config);
			}
			
			//payment screenshot upload payment_screenshot/client_aadhar_card
			if( isset( $_FILES['payment_screenshot']['name'] ) && !empty( $_FILES['payment_screenshot']['name'] ) ){
				$f_n = $_FILES['payment_screenshot']['name'];
				$n = str_replace(' ', '_', $f_n);
				//$file_name = $iti_id . "_payment_{$agent_id}_"  . $n;
				$file_name = $iti_id . "_payment_{$agent_id}_"  . $n;
				//check if path exists
				if(!is_dir($doc_path)){
					if (!mkdir($doc_path, 0777, true)) {
						//return false;
						$res = array('status' => false, 'msg' => "File not uploaded. Please contact administrator.");
						die( json_encode($res) );
					}
				}
				
				$config['upload_path'] = $doc_path;
				$config['allowed_types'] = 'jpg|jpeg|png';
				$config['max_size'] = 1024 * 2;
				$config['max_width']  = 5000;
				$config['max_height'] = 3000;
				$config['file_name'] = $file_name;
				$this->load->library('upload', $config);
				
				if(!$this->upload->do_upload('payment_screenshot')){
					$err = $this->upload->display_errors();
					$res = array('status' => false, 'msg' => "{$err}");
					die( json_encode($res) );
				}else{
					$data = $this->upload->data();
					$payData["payment_screenshot"] = $file_prefix . $data['file_name'];
				}
			}
			
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
				
				foreach( $upload_files as $ind=>$file){
					$upload_docs_data[$ind]['file_url'] 	= $file_prefix . $file;
					
					$upload_docs_data[$ind]['comment'] 		= isset( $_POST['comment'][$ind] ) ? $_POST['comment'][$ind] : "";
					$upload_docs_data[$ind]['iti_id'] 		= $iti_id;
					$upload_docs_data[$ind]['customer_id'] 	= $customer_id;
					$upload_docs_data[$ind]['agent_id'] 	= $user_id;
				}
			}
			
			//insert client docs
			if( !empty( $upload_docs_data ) ){
				$this->global_model->insert_batch_data("iti_clients_docs", $upload_docs_data );
			}	
			
			//update payment details
			$uppay = $this->global_model->update_data("iti_payment_details", array("iti_id" => $iti_id), $payData );
			//update iti
			$this->global_model->update_data("itinerary", array("iti_id" => $iti_id), array("final_amount" => $final_amount, "approved_package_category" => $approved_package_category ) );
		//}else{
		//	$payData = array(
		//		'approved_note'			=> $iti_note,
		//		'iti_booking_status'	=> 1, // 1= on hold
		//	);
		//	$uppay = $this->global_model->update_data("iti_payment_details", array("iti_id" => $iti_id), $payData );
		//}
		
		//notification to manager
		$agent_name = get_user_name( $user_id );
		$title 		= "Iti Verification Request";
		$c_date 	= current_datetime();
		$notif_time = date("Y-m-d H:i:s", strtotime( $c_date . " +10 minutes") );
		$body 		= "Itinerary Verification Request By {$agent_name}. Please Check and verify.";
		$notif_link = "itineraries/view/{$iti_id}/{$temp_key}";
		
		$notification_data = array(
			array(
				"customer_id"		=> $customer_id,
				"notification_for"	=> 98, //96 = sales team
				"title"				=> $title,
				"body"				=> $body,
				"url"				=> $notif_link,
				"agent_id"			=> $user_id,
				"notification_time"	=> $notif_time,
			)
		);
		//Insert notification
		$this->global_model->insert_batch_data( "notifications", $notification_data );
		if(  $uppay ){
			$this->session->set_flashdata('success',"Itinerary Payment Updated Successfully.");
			$res = array('status' => true, 'msg' => "Payment updated successfully!");
		}else{
			$res = array('status' => false, 'msg' => "Payment not updated successfully!!");
		}
		die( json_encode($res) );

	}
	

	//delete clients documents
	public function delete_docs(){
		$id = $this->input->post('id');
		$where = array( "id" => $id );
		$image_name = $this->global_model->getdata( "iti_clients_docs", $where, "file_url" );
		$path = FCPATH .'site/assets/client_docs/' . $image_name;
		$result = $this->global_model->delete_data( "iti_clients_docs", $where );
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
	
	//ON HOLD ITINERARIES MANAGER
	public function onholditineraries(){
		$this->load->model("dashboard_model");
		$user = $this->session->userdata('logged_in');
		$user_id = $user["user_id"];
		$data['user_role'] 	= $user['role'];
		if( $user['role'] == 99 || $user['role'] == 98 ){
			$data['on_hold_itineraries'] = $this->dashboard_model->get_onhold_itieraries_list();
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('itineraries/onhold_iti', $data);
			$this->load->view('inc/footer'); 
		}else{
			redirect(404);
		}
	}
	
	//bookeditineraries
	public function bookeditineraries(){
		$user = $this->session->userdata('logged_in');
		$user_id = $user["user_id"];
		$data['user_role'] 	= $user['role'];
		if( $user['role'] == 99 || $user['role'] == 98 || $user['role'] == 96 ){
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('itineraries/all_booked_iti', $data);
			$this->load->view('inc/footer'); 
		}else{
			redirect(404);
		}	
		
	}
	
	/* data table get all Declined Itineraries */
	public function ajax_bookeditineraries_list(){
		$user = $this->session->userdata('logged_in');
		$u_id = $user['user_id'];
		$role = $user['role'];
		if( $user['role'] == 99 || $user['role'] == 98 ){
			$where = array( "itinerary.iti_status" => 9, "itinerary.del_status" => 0 );
			//$where = array("itinerary.publish_status !=" => "draft" , "itinerary.parent_iti_id" => 0, "itinerary.del_status" => 0);
			//get itineraries by agent
			if( isset( $_POST['agent_id'] ) && !empty( $_POST['agent_id'] ) ){
				$where["itinerary.agent_id"] = $_POST['agent_id'];
			}
			
		}else if( $user['role'] == 96 ){
			$where = array( "itinerary.iti_status" => 9, "itinerary.agent_id" => $u_id );
		}
		
		$list = $this->itinerary_model->get_datatables($where);
		$data = array();
		$no = $_POST['start'];
		if( !empty($list) ){
			foreach ($list as $iti) {
				$pub_status = $iti->publish_status;
				$row_delete = "";
				$row_edit = "";
				$btncmt = "";
				$no++;
				
				//Get customer info
				$get_customer_info = get_customer( $iti->customer_id ); 
				$cust = $get_customer_info[0];
				$c_name = "";
				$c_contact = "";
				if( !empty( $get_customer_info ) ){  
					$c_name = $cust->customer_name;
					$c_contact = $cust->customer_contact;
				} 
				
				/* count iti sent status */
				$iti_sent = $iti->email_count;
				$sent_status = $iti_sent > 0 ? "$iti_sent Time Sent" : "Not Sent";
				$row = array();
				$row[] = $no;
				$row[] = $iti->iti_id;
				$row[] = $iti->iti_type == 2 ? "<strong class='red'>Accommodation</strong>" : "<strong class='green'>Holiday</strong>";;
				$row[] = $iti->customer_id;
				$row[] = $c_name;
				$row[] = $iti->final_amount;
				$row[] = $iti->advance_recieved;
				$row[] = $iti->travel_date;
				$row[] = $iti->t_end_date;
				
				//review button
				$td = date("Y-m-d");
				$rev_btn = "--";
				$tend_d =  !empty($iti->t_end_date) ? change_date_format_dmy_to_ymd($iti->t_end_date) : "";
				if( !empty($tend_d) && $tend_d <= $td ){
					$check_if_request_sent = check_review_request_status( $iti->customer_id );
					if( $check_if_request_sent ){
						$rev_btn = "<i class='fa fa-check-circle-o'></i> Sent";
					}else{
						$rev_btn = "<a title='Send review link to customer' target='_blank' href='javascript: void(0)' class='btn btn-success sendReview_req' data-cusid = '{$iti->customer_id}' >Click to send</a>";
					}
				}
				
				//buttons
				$row[] =  "<a title='View' target='_blank' href=" . site_url("itineraries/view/{$iti->iti_id}/{$iti->temp_key}") . " class='btn_eye' ><i class='fa fa-eye' aria-hidden='true'></i></a>";
				
				$row[] = $rev_btn; 
				$row[] = date("d-m-Y", strtotime($iti->iti_decline_approved_date));
				$row[] = get_user_name( $iti->agent_id ); 
				$data[] = $row;
			}
		}
		
		$output = array(
			"draw" 				=> $_POST['draw'],
			"recordsTotal" 		=> $this->itinerary_model->count_all($where),
			"recordsFiltered" 	=> $this->itinerary_model->count_filtered($where),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
		
	}
	
	
	
	//closed iti
	public function closediti(){
		$user = $this->session->userdata('logged_in');
		$user_id = $user["user_id"];
		$data['user_role'] 	= $user['role'];
		
		if( $user['role'] == 99 || $user['role'] == 98 || $user['role'] == 93 ){
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('itineraries/all_closed_iti', $data);
			$this->load->view('inc/footer'); 
		}else{
			redirect(404);
		}	
		
	}
	
	/* data table get all closed Itineraries */
	public function ajax_closeditineraries_list(){
		$user 	= $this->session->userdata('logged_in');
		$u_id 	= $user['user_id'];
		$role 	= $user['role'];
		$where 	= array( "itinerary.iti_status" => 9, "itinerary.iti_close_status" => 1 );
		$list	= $this->itinerary_model->get_datatables( $where );
		$data = array();
		$no = $_POST['start'];
		if( !empty($list) ){
			foreach ($list as $iti) {
				$pub_status = $iti->publish_status;
				$row_delete = "";
				$row_edit = "";
				$btncmt = "";
				$no++;
				
				//Get customer info
				$get_customer_info = get_customer( $iti->customer_id ); 
				$cust 		= $get_customer_info[0];
				$c_name 	= "";
				$c_contact 	= "";
				if( !empty( $get_customer_info ) ){  
					$c_name 	= $cust->customer_name;
					$c_contact 	= $cust->customer_contact;
				} 
				
				/* count iti sent status */
				$iti_sent = $iti->email_count;
				$sent_status = $iti_sent > 0 ? "$iti_sent Time Sent" : "Not Sent";
				$row = array();
				$row[] = $no;
				$row[] = $iti->iti_id;
				$row[] = $iti->iti_type == 2 ? "<strong class='red'>Accommodation</strong>" : "<strong class='green'>Holiday</strong>";;
				$row[] = $iti->customer_id;
				$row[] = $c_name;
				$row[] = $iti->package_name;
				$row[] = $iti->travel_date;
				
				$row[] = date("d-m-Y", strtotime($iti->iti_decline_approved_date));
				
				//buttons
				$edit_bn = "";
				$inv_bn = "";
				if( $role == 99 || $role == 98 || $role == 93 ){
					$edit_bn = "<a title='Edit' target='_blank' href=" . site_url("itineraries/edit/{$iti->iti_id}/{$iti->temp_key}") . " class='btn btn-success' ><i class='fa fa-pencil' aria-hidden='true'></i></a>";
				
					//check invoice	
					$cinv = is_invoice_created( $iti->customer_id );
					if( $cinv ){
						$invId = $cinv[0]->id;
						$inv_bn = "<a title='View' target='_blank' href=" . site_url("accounts/view_invoice/{$invId}") . " class='btn btn-danger' ><i class='fa fa-eye' aria-hidden='true'></i> View invoice</a>";
					}else{
						$inv_bn = "<a title='View' target='_blank' href=" . site_url("accounts/generate_invoice/{$iti->customer_id}") . " class='btn btn-success' ><i class='fa fa-plus' aria-hidden='true'></i> Create invoice</a>";
					}
				}
				
				$row[] =  "<a title='View' target='_blank' href=" . site_url("itineraries/view/{$iti->iti_id}/{$iti->temp_key}") . " class='btn btn-success' ><i class='fa fa-eye' aria-hidden='true'></i></a> " . $edit_bn . $inv_bn;
				
				$data[] = $row;
			}
		}
		
		$output = array(
			"draw" 				=> $_POST['draw'],
			"recordsTotal" 		=> $this->itinerary_model->count_all($where),
			"recordsFiltered" 	=> $this->itinerary_model->count_filtered($where),
			"data" => $data,
		);
		
		//output to json format
		echo json_encode($output);
	}
	
	
	//get_package_price_html
	public function get_package_price_html(){
		if( isset($_POST['iti_id'] ) && is_numeric( $_POST['iti_id'] ) ){
			echo package_category_select_html( $_POST['iti_id'] );
		}else{
			echo "<option>Select Package Cat</option>";
		}
	}
}	
?>