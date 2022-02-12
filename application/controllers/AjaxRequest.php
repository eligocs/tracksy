<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class AjaxRequest extends CI_Controller {
	public function __Construct(){
	   	parent::__Construct();
		validate_login();
		$this->load->model("login_model");
		$this->load->model("marketing_model");
		$this->load->model("hotel_model");
		$this->load->model("customer_model");
		$this->load->model("itinerary_model");
		$this->load->model("hotelbooking_model");
		$this->load->model("bank_model");
		$this->load->model("terms_model");
		$this->load->model("vehicles_model");
		$this->load->model("vehiclesbooking_model");
		$this->load->model("voucher_model");
		$this->load->helper('email');	
		$this->load->helper('path');
	}
	
	public function index(){
		validate_login();
	}
	
	//add user by Admin
	public function ajaxAdduser(){
		$email 		= $this->input->post("email", TRUE);
		$user_name 	= $this->input->post("user_name", TRUE);
		$mobile_otp = $this->input->post("mobile_otp", TRUE);
		
		//Avoid special characters from username
		if( !validate_username( $user_name ) ){
			$res = array('status' => false, 'msg' => "Don't Use whitespace and special character in username.You can use only these special characters : _@#.$");
			die( json_encode($res) );
		}
		
		if( !empty($email) && !empty($user_name)){
			$exists 		= $this->login_model->isUserExist("email", $email);
			$user_exists 	= $this->login_model->isUserExist("user_name", $user_name);
			$mobile_otp 	= $this->login_model->isUserExist("mobile_otp", $mobile_otp);
			if( $exists ){
				$res = array('status' => false, 'msg' => "Email already exists!");
			}elseif( $mobile_otp ){
				$res = array('status' => false, 'msg' => "Mobile Number for OTP must be unique. Number already exists!");
			}elseif( $user_exists ){
				$res = array('status' => false, 'msg' => "User name already exists!");
			}else{
				$result = $this->login_model->insertUser();
				if( $result){
					$res = array('status' => true, 'msg' => "User Insert Successfully!");
				}else{
					$res = array('status' => false, 'msg' => "Please Try Again !");
				}
			}
		}else{
			$res = array('status' => false, 'msg' => "Email and Username is required!");
		}	
		die( json_encode($res) );
	}
	
	
	//update user
	public function ajax_profileUpdate(){
		$result = $this->login_model->update_profile();
		if( $result){
			$res = array('status' => true, 'msg' => "Your Profile is updated Successfully!");
		}else{
			$res = array('status' => false, 'msg' => "Please Try Again ! Profile cannot be updated");
		}
		die(json_encode($res));
	}

	//Edit Agent By Admin and Manager
	public function ajax_admin_profileUpdate(){
		$email = $this->input->post("email", TRUE);
		$mobile_otp = $this->input->post("mobile_otp", TRUE);
		$user_id = $this->input->post("user_id", TRUE);
		
		//$res = array('status' => false, 'msg' => "Mobile Number for OTP must be unique. Number already exists! $mobile_otp");
		//die(json_encode($res));
		if( !empty($email) ){
			$exists = $this->login_model->isUserExist("email", $email, $user_id);
			$mobile_otp_res = $this->login_model->is_mobile_otp_exists("mobile_otp", $mobile_otp, $user_id);
			if( $exists ){
				$res = array('status' => false, 'msg' => "Email already exists!");
			}else if( $mobile_otp_res  ){
				$res = array('status' => false, 'msg' => "Mobile Number for OTP must be unique. Number already exists!");
			}else{
				$result = $this->login_model->update_profile_admin();
				if( $result){
					$this->session->set_flashdata('success',"User Updated successfully.");
					$res = array('status' => true, 'msg' => "Profile is updated Successfully!");
				}else{
					$res = array('status' => false, 'msg' => "Please Try Again ! Profile cannot be updated");
				}
			}	
		}else{
			$res = array('status' => false, 'msg' => "Email is required!");
		}	
		die(json_encode($res));
		
	}
	
	//delete user
	public function ajax_deleteUser(){
		$id = $this->input->get('id', TRUE);
		$where = array("user_id" => $id);
		$result = $this->global_model->update_del_status("users", $where);
		if( $result){
			$res = array('status' => true, 'msg' => "User delete Successfully!");
		}else{
			$res = array('status' => false, 'msg' => "Error! please try again later");
		}
		die(json_encode($res));
	}
	
	//change password user
	public function ajaxChangePass(){
		$result = $this->login_model->changePassword();
		if( $result ){
			$res = array('status' => true, 'msg' => "Your Password is updated Successfully!");
		}else{
			$res = array('status' => false, 'msg' => "Old Password is incorrect!");
		}
		die(json_encode($res));
	}	
	
	/* upload profile pic */
	function ajax_upload(){
		if(isset($_FILES["profile_pic"]["name"])){
			$uid = $this->input->post('user_id');
			if(!$uid){
				echo "<div class='alert alert-danger'><strong>Error! </strong>Invalid User.</div>";
				die();
			}
			$file_name = time()."_" . $uid; 
			
			$config['upload_path'] = dirname($_SERVER["SCRIPT_FILENAME"]).'/site/images/userprofile';
			$config['allowed_types'] = 'jpg|jpeg|png';
			$config['max_size'] = 1024 * 1;
			$config['max_width']  = 1024;
            $config['max_height'] = 768;
            $config['file_name'] = $file_name;
			$this->load->library('upload', $config);
			if(!$this->upload->do_upload('profile_pic')){
				$err = $this->upload->display_errors();
				echo "<div class='alert alert-danger'>{$err}</div>";
				die();
			}else{
				$data = $this->upload->data();
				$file_id = $this->login_model->updateProfilePic( $data['file_name'], $uid);
				if($file_id){
					echo 'success';
				}else{
					echo '<div class="alert alert-danger"><strong>Error: </strong>Something went wrong. Please try again later.</div>';
				} 
				die();
			}
			
		}
	}
	/* Hotel state data from country id */	
	public function hotelStateData(){
		if(isset($_POST["country"])){
			$country = $_POST["country"];
			// Define state and city array
			$state_list = get_state_list( $country );
			if( $state_list ){
				if($country !== 'Select'){
					echo '<option value="">Select State</option>';
					foreach($state_list as $state){
						echo '<option value="'.$state->id.'">'.$state->name.'</option>';
					}
				}
			}else{
				echo '<option value="">Select State!</option>';
				echo '<option value="no">No states found!</option>';
			}	
			die();
		}
	}	
	
	/* Hotel City data */	
	public function hotelCityData(){
		if(isset($_POST["state"])){
			$state_id = $_POST["state"];
			// Define state and city array
			$city_list = get_city_list( $state_id );
			if( $city_list ){
				if($state_id !== ''){
					echo '<option value="">Select City</option>';
					foreach($city_list as $city){
						echo '<option value="'.$city->id.'">'.$city->name.'</option>';
					}
				}
			}else{
				echo '<option value="">Select City!</option>';
			}	
			die();
		}
	}
	
	//add hotel
	public function addHotel(){
		if( isset($_POST["state"]) && !empty($_POST['name'])  ){
			$result = $this->hotel_model->insert_hotel();
			if( $result ){
				$this->session->set_flashdata('success',"Hotel Add successfully.");
				$res = array('status' => true, 'msg' => "Hotel add successfully!" , "hotel_id" => $result );
			}else{
				$res = array('status' => false, 'msg' => "Failed! Please try again later.");
			}
			die(json_encode($res));
		}
	}
	
	//edit hotel
	public function editHotel(){
		$hotel_id = $this->input->post("id",TRUE);
		if( isset($_POST["state"]) && !empty($_POST['name'])  ){
			$result = $this->hotel_model->edit_hotel( $hotel_id );
			if( $result ){
				$this->session->set_flashdata('success',"Hotel Edit successfully.");
				$res = array('status' => true, 'msg' => "Hotel successfully updated!");
			}else{
				$res = array('status' => false, 'msg' => "Error!");
			}
			die(json_encode($res));
		}
	}
	
	//delete hotel 
	public function ajax_deleteHotel(){
		$id = $this->input->get('id');
		$where = array( "id" => $id );
		$result = $this->global_model->update_del_status('hotels', $where);
		if( $result){
			$this->session->set_flashdata('success',"Hotel Delete successfully.");
			$res = array('status' => true, 'msg' => "Hotel delete Successfully!");
		}else{
			$res = array('status' => false, 'msg' => "Error! please try again later");
		}
		die(json_encode($res));
	}
	
	
	//delete customer
	public function delete_customer(){
		$id = $this->input->post('id');
		$where = array( "customer_id" => $id );
		$result = $this->global_model->update_del_status('customers_inquery', $where);
		if( $result){
			$this->session->set_flashdata('success',"Customer Delete successfully.");
			$res = array('status' => true, 'msg' => "customer delete Successfully!");
		}else{
			$res = array('status' => false, 'msg' => "Error! please try again later" . $id);
		}
		die(json_encode($res));
	}
	
	
	//delete Bank
	public function delete_bank(){
		$id = $this->input->get('id');
		$result = $this->bank_model->delete_bank($id);
		if( $result){
			$this->session->set_flashdata('success',"Bank Delete successfully.");
			$res = array('status' => true, 'msg' => "Bank delete Successfully!");
		}else{
			$res = array('status' => false, 'msg' => "Error! please try again later");
		}
		die(json_encode($res));
	}
	
	/* search customer id */
	public function searchReqId(){
		$req_id = $this->input->get("id", TRUE);
		$req_id = preg_replace('/\s+/', '', $req_id);
	
		if( !is_numeric($req_id) ){
			$res = array('status' => false, 'msg' => "Please Enter Valid Request Id ");
			die(json_encode($res));
		}
		$user = $this->session->userdata('logged_in');
		$user_id = $user['user_id'];
		if( $user['role'] == '99' || $user['role'] == '98'){
			$data['agent_id'] = $user['user_id'];
			$where = array("customer_id" => $req_id);
			$result = $this->customer_model->getdata( "customers_inquery", $where );
			if( $result){
				$res = array('status' => true, 'id' => $req_id );
			}else{
				$res = array('status' => false, 'msg' => "$req_id is invalid Request ID.");
			}
			die(json_encode($res));
		}elseif( $user['role'] == '96'){
			$where = array("agent_id" => $user_id, "customer_id" => $req_id);
			$result = $this->customer_model->getdata( "customers_inquery", $where );
			if( $result){
				$res = array('status' => true, 'id' => $req_id);
			}else{
				$res = array('status' => false, 'msg' => "$req_id is invalid Request ID.");
			}
			die(json_encode($res));
		}else{
			$res = array('status' => false, 'msg' => "Invalid user! ");
			die(json_encode($res));
		}
	}
	/* Search Itinerary approved */
	public function searchItineraryReqId(){
		$req_id = $this->input->get("id", TRUE);
		$req_id = preg_replace('/\s+/', '', $req_id);
	
		if( !is_numeric($req_id) ){
			$res = array('status' => false, 'msg' => "Please Enter Valid Itinerary Id ");
			die(json_encode($res));
		}
		$user = $this->session->userdata('logged_in');
		$user_id = $user['user_id'];
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '97' ){
			$data['agent_id'] = $user['user_id'];
			$where = array("iti_id" => $req_id, "iti_status" => 9 );
			$result = $this->global_model->getdata( "itinerary", $where );
			if( $result){
				$res = array('status' => true, 'id' => $req_id );
			}else{
				$res = array('status' => false, 'msg' => "$req_id is not approved or invalid Itinerary ID.");
			}
			die(json_encode($res));
		}
	}
	/* Search Hotels By City IDs */
	public function getHotelsByCityId(){
		$id = $this->input->get("city_id", TRUE);
		$city_id = trim($id);
		if($city_id){
			$hotels = $this->hotel_model->get_hotel_by_city_id($city_id);
			if($hotels ){
				$s =  "<option value='no'>No hotels!</option>";
				$d =  "<option value='no'>No hotels!</option>";
				$sd = "<option value='no'>No hotels!</option>";
				$l =  "<option value='no'>No hotels!</option>";
				foreach( $hotels as $hotel ){
					if( $hotel->hotel_category == '1' ){
						$s .= '<option value="'.$hotel->id.'">'.$hotel->hotel_name.'</option>';
					} elseif( $hotel->hotel_category == '2' ){
						$d .= '<option value="'.$hotel->id.'">'.$hotel->hotel_name.'</option>';
					}elseif( $hotel->hotel_category == '3' ){
						$sd .= '<option value="'.$hotel->id.'">'.$hotel->hotel_name.'</option>';
					}else{
						$l .= '<option value="'.$hotel->id.'">'.$hotel->hotel_name.'</option>';
					} 						
				}
				$res = array('status' => true, 's' => $s, 'd' => $d, 'sd' => $sd, 'l' => $l);
				die(json_encode($res));
			}else{
				$data = '<option value="no">No hotels found!</option>';
				$res = array('status' => false, 'data' => $data);
				die(json_encode($res));
			}
		}else{
			$res = array('status' => false, 'msg' => "Invalid city! ");
			die(json_encode($res));
		}
	}
	
	/****************** Start Room Category Section ******************/
	public function addRoomCategory(){
		if( isset($_POST["room_cat_name"])){
			$room_cat = $_POST["room_cat_name"];
			$where = array("room_cat_name" => $room_cat, "del_status" => 0);
			$get_cat = $this->global_model->getdata("room_category", $where);
			if( !empty($get_cat) ){
				$res = array('status' => false, 'msg' => "This category already exists.");
				die(json_encode($res));
			}
			
			$result = $this->hotel_model->insert_roomcategory();
			if( $result ){
				$this->session->set_flashdata('success',"Hotel Category Add successfully.");
				$res = array('status' => true, 'msg' => "Room Category add successfully!");
			}else{
				$res = array('status' => false, 'msg' => "Failed! Please try again later.");
			}
			die(json_encode($res));
		}
	}
	
	public function editRoomCategory(){
		$roomcat_id = $this->input->post("id",TRUE);
		if( isset($_POST["room_cat_name"])){
			$room_cat = $_POST["room_cat_name"];
			$where = array("room_cat_name" => $room_cat, "room_cat_id !=" => $roomcat_id );
			$get_cat = $this->global_model->getdata("room_category", $where);
			if( !empty($get_cat) ){
				$res = array('status' => false, 'msg' => "This category already exists enter new.");
				die(json_encode($res));
			}
			$result = $this->hotel_model->edit_rooomcategory( $roomcat_id );
			if( $result ){
				$this->session->set_flashdata('success',"Hotel Category Edit successfully.");
				$res = array('status' => true, 'msg' => "Room Category successfully updated!");
			}else{
				$res = array('status' => false, 'msg' => "Error!");
			}
			die(json_encode($res));
		}
	}
	
	public function ajax_deleteRoomCategory(){
		$id = $this->input->get('id');
		$where = array("room_cat_id" => $id );
		$result = $this->global_model->update_del_status('room_category', $where);
		if( $result){
			$this->session->set_flashdata('success',"Hotel Category Delete successfully.");
			$res = array('status' => true, 'msg' => "Room Category delete Successfully!");
		}else{
			$res = array('status' => false, 'msg' => "Error! please try again later");
		}
		die(json_encode($res));
	} 
	/****************** Vehicles Section************************/
	//add
	public function addVehicles(){
		if (isset($_POST['inp']['car_name']) && !empty($_POST['inp']['car_rate'])) {
			$carname = $_POST['inp']['car_name'];
			$maxPer = $_POST['inp']['max_person'];
			$where = array( "car_name" => $carname, "max_person" => $maxPer );
			//check if car exists
			$exists = $this->global_model->getdata('vehicles', $where);
			if( $exists ){
				$res = array('status' => false, 'msg' => "Failed! You already add this vehicle.");
				die(json_encode($res));
			}
			
			$inp = $this->input->post('inp', TRUE);
			$vehicle_id = $this->global_model->insert_data("vehicles", $inp);
			if( $vehicle_id){
				$res = array('status' => true, 'msg' => "Vehicles Add Successfully");
			}else{
				$vehicle_id = array('status' => false, 'msg' => "Error! please try again later");
			}
			die(json_encode($res));
		}else{
			$res = array('status' => false, 'msg' => "Error! Please enter vehicle name!");
			die(json_encode($res));
		}
	}	
	//edit
	public function editcabs(){
		$id = $this->input->post('id');
		$carname = $_POST['car_name'];
		$maxPer = $_POST['max_person'];
		$where = array( "car_name" => $carname, "max_person" => $maxPer, "id !=" => $id );
		//check if car exists
		$exists = $this->global_model->getdata('vehicles', $where);
		if( $exists ){
			$res = array('status' => false, 'msg' => "Failed! You already add this vehicle.");
			die(json_encode($res));
		}
		
		$result = $this->vehicles_model->update_vehicle($id);
		if( $result){
			$res = array('status' => true, 'msg' => "vehicles update Successfully!");
		}else{
			$res = array('status' => false, 'msg' => "Error! please try again later");
		}
		die(json_encode($res));
	} 
	//delete
	public function ajax_deletecab(){
		$id = $this->input->get('id');
		$where = array( "id" => $id );
		$result = $this->global_model->update_del_status('vehicles', $where);
		if( $result){
			$res = array('status' => true, 'msg' => "vehicles delete Successfully!");
		}else{
			$res = array('status' => false, 'msg' => "Error! please try again later");
		}
		die(json_encode($res));
	} 
	/****************** Transporter Section************************/
	//add
	public function addTranspoter(){
		if (isset($_POST['trans_name']) && !empty($_POST['trans_contact'])) {
			$trans_id = $this->vehicles_model->insert_transporter();
			if( $trans_id){
				$this->session->set_flashdata('success',"Transporter Added successfully.");
				$res = array('status' => true, 'msg' => "Transporter Add Successfully", "tra_id" => $trans_id);
			}else{
				$trans_id = array('status' => false, 'msg' => "Error! please try again later");
			}
			die(json_encode($res));
		}else{
			$res = array('status' => false, 'msg' => "Error! Please enter Transporter name!");
			die(json_encode($res));
		}
	}	
	//delete
	public function ajax_deletetrans(){
		$id = $this->input->get('id');
		$where = array( "id" => $id );
		$result = $this->global_model->update_del_status('transporters', $where);
		if( $result){
			$this->session->set_flashdata('success',"Transporter Deleted successfully.");
			$res = array('status' => true, 'msg' => "Transporter delete Successfully!");
		}else{
			$res = array('status' => false, 'msg' => "Error! please try again later");
		}
		die(json_encode($res));
	} 
	//edit transporters
	public function editTransporter(){
		$trans_id = $this->input->post("id",TRUE);
		if( isset($_POST["trans_name"]) && !empty($_POST['trans_contact'])  ){
			$result = $this->vehicles_model->editTransporter( $trans_id );
			if( $result ){
				$this->session->set_flashdata('success',"Transporter Edit successfully.");
				$res = array('status' => true, 'msg' => "Transporter successfully updated!");
			}else{
				$res = array('status' => false, 'msg' => "Error!");
			}
			die(json_encode($res));
		}
	}
	
	/************************* Start Here  Room Rates ************/
	public function hotellistByCityId(){
		$city_id = $this->input->post("hotel", TRUE);
		if($city_id){
			$hotel_list = get_hotel_list($city_id);
			if($hotel_list ){
				echo '<option value="">Select Hotel</option>';
					foreach( $hotel_list as $hotel ){	
						$h_cat = get_hotel_cat_name($hotel->hotel_category);
 						echo '<option value="'.$hotel->id.'">'. $hotel->hotel_name . ' ('. $h_cat .')</option>';					
					}	
				}else{
					echo '<option value="">No Hotels found! Choose other city</option>';
				}
			die();
		}
	}
	
	
	public function hotelByCityIdandHotelCategory(){
		$city_id = $this->input->post("hotel", TRUE);
		$hotelcat = $this->input->post("hotelcat", TRUE);
		if($city_id && !empty( $hotelcat )){
			switch( $hotelcat ){
				case "Standard":
					$h_cat = "1";
					$hotel_category = "hotel_category";
				break;
				case "Deluxe":
					$h_cat = "2";
					$hotel_category = "hotel_category";
				break;
				case "Super Deluxe":
					$h_cat = "3";
					$hotel_category = "hotel_category";
				break;
				default:
					$h_cat = "4";
					$hotel_category = "hotel_category >= ";
				break;			
			}
			
			$where = array("city_id" => $city_id, $hotel_category => $h_cat );
			$hotel_list = $this->global_model->getdata( "hotels", $where );
		
			/* $hotel_list = get_hotel_list($city_id); */
			if($hotel_list ){
				echo '<option value="">Select Hotel</option>';
				foreach( $hotel_list as $hotel ){	
					echo '<option value="'.$hotel->id.'">'. $hotel->hotel_name . '</option>';					
				}	
			}
			else{
				echo '<option value="">Select Hotel!</option>';
				echo '<option value="no">No Hotels found!</option>';
			}
			die();
		}
	}
	
	public function addHotelRoomRates(){
		if( isset($_POST["state"]) && !empty($_POST["room_rates"])){
			$hotel_id = $this->input->post("hotel");
			$room_cat_id = $this->input->post("room_cat_id");
			$where = array( "hotel_id" => $hotel_id, "room_cat_id" => $room_cat_id );
			$exists = $this->global_model->getdata('hotel_room_rates', $where);
			if( $exists ){
				$res = array('status' => false, 'msg' => "Failed! You already add rates for this category.");
				die(json_encode($res));
			}
			
			$result = $this->hotel_model->insert_hotelroomrates();
			if( $result ){
				$res = array('status' => true, 'msg' => "Hotel Room Rates add successfully!");
			}else{
				$res = array('status' => false, 'msg' => "Failed! Please try again later.");
			}
			die(json_encode($res));
		}
	}
	
	public function editRoomRates(){
		$roomrates_id = $this->input->post("id",TRUE);
		if( !empty($_POST['room_rates'])  ){
			$result = $this->hotel_model->edit_roomrates( $roomrates_id );
			if( $result ){
				$res = array('status' => true, 'msg' => "Hotel Room Rates successfully updated!");
			}else{
				$res = array('status' => false, 'msg' => "Error!");
			}
			die(json_encode($res));
		}
	}
	
	public function ajax_deleteHotelRoomRates(){
		$id = $this->input->get('id', TRUE);
		$where = array( "htr_id" => $id );
		$result = $this->global_model->update_del_status('hotel_room_rates', $where);
		if( $result){
			$res = array('status' => true, 'msg' => "Room Rates delete Successfully!!");
		}else{
			$res = array('status' => false, 'msg' => "Error! please try again later");
		}
		die(json_encode($res));
		
	} 
	
	/* Get Room rates by hotel_id and room_cat_id */
	public function get_rooms_rates(){
		$hotel_id = $this->input->post("hotel_id");
		$room_cat = $this->input->post("room_cat");
	
		if( !empty( $room_cat ) &&  !empty( $hotel_id ) ){
			$where = array( 'hotel_id' => $hotel_id, 'room_cat_id' => $room_cat );
			$rates = $this->global_model->getdata('hotel_room_rates', $where);
			if( $rates ){
				$rate =  $rates[0];
				$room_rate = $rate->room_rates;
				$extra_bed = $rate->extra_bed_rate;
				$res = array('status' => true, 'room_rate' => $room_rate, 'extra_bed' => $extra_bed, "msg" =>"done" );
			}else{
				$res = array('status' => false, 'msg' => "Error! Before you proceed please add room rate! or Contact Administrator/Manager.");
			}
			die(json_encode($res));
		}else{
			$res = array('status' => false);
			die(json_encode($res));
		}
		
	}
	/****************** Room Rates Ends Here ******************/
	public function iti_status_popup(){
		$id = $this->input->post('iti_id');
		$where = array( "iti_id" => $id );
		$data_iti = $this->global_model->getdata( "itinerary", $where);
		if( $data_iti){
			$data = $data_iti[0];
			$status = $data->iti_status;
			$iti_status_note = $data->iti_note;
			if( $status == 9 ){
				$s = "Itinerary Approved";
				$printData = $iti_status_note;
			}elseif( $status == 8 ){
				$s = "Itinerary Postpone";
				$printData = $iti_status_note;
			}elseif( $status == 7 ){
				$s = "Itinerary Decline";
				$printData = $iti_status_note;
			}
			$res = array('status' => true, 'data' => $printData,  's' => $s);
		}else{
			$res = array('status' => false, 'data' => "Error! please try again later");
		}
		die(json_encode($res));
	} 
	
	/* hotelbooking_status_popup */
	public function hotelbooking_status_popup(){
		$id = $this->input->post('id');
		$where = array( "id" => $id );
		$data_hotel_book = $this->global_model->getdata( "hotel_booking", $where);
		if( $data_hotel_book){
			$data = $data_hotel_book[0];
			$status = $data->booking_status;
			$iti_status_note = $data->booking_note;
			if( $status == 9 ){
				$s = "Approved";
				$printData = $iti_status_note;
			}elseif( $status == 8 ){
				$s = "Decline";
				$printData = $iti_status_note;
			}
			
			$res = array('status' => true, 'data' => $printData,  's' => $s);
		}else{
			$res = array('status' => false, 'data' => "Error! please try again later");
		}
		die(json_encode($res));
	} 
	
	/* cab_booking_status */
	public function cab_booking_status(){
		$id = $this->input->post('id');
		$where = array( "id" => $id );
		$data_hotel_book = $this->global_model->getdata( "cab_booking", $where);
		if( $data_hotel_book){
			$data = $data_hotel_book[0];
			$status = $data->booking_status;
			$iti_status_note = $data->booking_note;
			if( $status == 9 ){
				$s = "Approved";
				$printData = $iti_status_note;
			}elseif( $status == 8 ){
				$s = "Decline";
				$printData = $iti_status_note;
			}
			
			$res = array('status' => true, 'data' => $printData,  's' => $s);
		}else{
			$res = array('status' => false, 'data' => "Error! please try again later");
		}
		die(json_encode($res));
	} 
	
	/*hotel booking update del status */
	//delete 
	public function ajax_delete_booking(){
		$id = $this->input->get('id', TRUE);
		$where = array( "id" => $id );
		$result = $this->global_model->update_del_status('hotel_booking', $where);
		if( $result){
			$res = array('status' => true, 'msg' => "Booking delete Successfully!");
		}else{
			$res = array('status' => false, 'msg' => "Error! please try again later");
		}
		die(json_encode($res));
	}
	
	//delete 
	public function ajax_delete_cab_booking(){
		$id = $this->input->get('id', TRUE);
		$where = array( "id" => $id );
		$result = $this->global_model->update_del_status('cab_booking', $where);
		if( $result){
			$res = array('status' => true, 'msg' => "Booking delete Successfully!");
		}else{
			$res = array('status' => false, 'msg' => "Error! please try again later");
		}
		die(json_encode($res));
	}
	
	//delete 
	public function ajax_delete_veh_booking(){
		$id = $this->input->get('id', TRUE);
		$where = array( "id" => $id );
		$result = $this->global_model->update_del_status('travel_booking', $where);
		if( $result){
			$res = array('status' => true, 'msg' => "Booking delete Successfully!");
		}else{
			$res = array('status' => false, 'msg' => "Error! please try again later");
		}
		die(json_encode($res));
	}
	
	//update Booking status Volvo, Train/Flight
	public function update_vtf_booking_status(){
		$id = $this->input->get('id');
		$status = $this->input->get('status');
		
		if( empty($id) || !is_numeric($status) ){
			$res = array('status' => false, 'msg' => "Error! please try again later");
			die(json_encode($res));
		} 
		
		$result = $this->vehiclesbooking_model->update_booking_status_vtf( $id, $status );
		if( $result){
			$res = array('status' => true, 'msg' => "Booking Update Successfully!");
		}else{
			$res = array('status' => false, 'msg' => "Error! please try again later");
		}
		die(json_encode($res));
	}
	/* itinerary  update del status */
	public function ajax_delete_iti(){
		$id = $this->input->get('id', TRUE);
		$where = array( "iti_id" => $id );
		$result = $this->global_model->update_del_status('itinerary', $where);
		if( $result){
			$res = array('status' => true, 'msg' => "Itinerary delete Successfully!");
		}else{
			$res = array('status' => false, 'msg' => "Error! please try again later");
		}
		die(json_encode($res));
	}
	
	/* Get Transporter List By vehicle Id */	
	public function gettransporter_by_vec_id(){
		if(isset($_POST["vec_id"]) && !empty( $_POST["vec_id"] ) ){
			$vec_id = $_POST["vec_id"];
			$id = trim( $vec_id );
			
			//get cab rates
			$where = array( "id" => $id );
			$cabRate = $this->global_model->getdata( 'vehicles', $where, 'car_rate' );
			if( $cabRate ){
				$cab_rate = $cabRate;
			}else{
				$cab_rate="No rates found for this vehicle please contact your administrator!.";
			}
			
			$vehicles = $this->vehiclesbooking_model->get_transporter_by_vehicle_id( $id );
			if( $vehicles ){
				$data ="";
				if($vec_id !== ''){
					$data .= '<option value="">Select Transporter</option>';
					foreach($vehicles as $vic){
						$data .=  '<option value="'.$vic->id.'">'.$vic->trans_name.'</option>';
					}
				}
			}else{
				$data =  '<option value="">No Transporter found!</option>';
			}
			$res = array('status' => true, 'trans' => $data, 'cabrate' => $cab_rate);			
			die(json_encode($res));
		}else{
			$res = array('status' => false, 'msg' => "Please select id");			
			die(json_encode($res));
		}
		
	}	
	
	/****************** Add Trasporter Details Volvo/Train/Flight ************************/
	//add Voucher
	public function createVoucher(){
		if( isset($_POST["iti_id"]) && !empty($_POST["travel_date"])){
			//Security Check
			$sec_key = $this->input->post('sec_key');
			$enc_key = md5( $this->config->item("encryption_key") );
			if( $sec_key !==  $enc_key  ){
				$res = array('status' => false, 'msg' => "Security Error! Please try again later.");
				die(json_encode($res));
			}
			$result = $this->voucher_model->insert_voucher();
			if( $result ){
				$res = array('status' => true, 'msg' => "Voucher Created successfully!");
			}else{
				$res = array('status' => false, 'msg' => "Failed! Please try again later.");
			}
			die(json_encode($res));
		}else{
			$res = array('status' => false, 'msg' => "Failed! Please Fill all required fields.");
			die(json_encode($res));
		}
	}	
	
	// Update voucher del status
		/* itinerary  update del status */
	public function ajax_delete_voucher(){
		$id = $this->input->get('id', TRUE);
		$where = array( "voucher_id" => $id );
		$result = $this->global_model->update_del_status('vouchers', $where);
		if( $result){
			$res = array('status' => true, 'msg' => "Voucher delete Successfully!");
		}else{
			$res = array('status' => false, 'msg' => "Error! please try again later");
		}
		die(json_encode($res));
	}
	
	// Search Voucher
	public function searchVoucherReqId(){
		$req_id = $this->input->get("id", TRUE);
		$iti_id = preg_replace('/\s+/', '', $req_id);
		$user = $this->session->userdata('logged_in');
		$user_id = $user['user_id'];
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '97'){
			if( !is_numeric($iti_id) || empty($iti_id)){
				$res = array('status' => false, 'msg' => "Please Enter Valid Itinerary Id ");
				die(json_encode($res));
			}
			$data['agent_id'] = $user['user_id'];
			// Check for itineray if approved or not
			$where = array("iti_id" => $iti_id, 'iti_status' => 9, 'del_status' => 0);
			$get_approved_iti = $this->global_model->getdata( "itinerary", $where );
			
			// Check for Hotel Booking if approved or not
			$where_hotel = array("iti_id" => $iti_id, 'booking_status' => 9, 'del_status' => 0);
			$get_approved_hotels = $this->global_model->getdata( "hotel_booking", $where_hotel );
			
			// Check for Cab Booking if approved or not
			$where_cab = array("iti_id" => $iti_id, 'booking_status' => 9, 'del_status' => 0);
			$get_approved_cabs  = $this->global_model->getdata( "cab_booking", $where_cab );
			
			$where_vtf = array("iti_id" => $iti_id, 'del_status' => 0, 'booking_status' => 9);
			$get_approved_vtf = $this->global_model->getdata( "travel_booking", $where_vtf );
			
			if( empty($get_approved_iti) ){
				$res = array('status' => false, 'msg' => "$iti_id is not approved or invalid Itinerary ID");
				die(json_encode($res));
			}elseif( empty($get_approved_hotels) ){
				$res = array('status' => false, 'msg' => "Hotel not booked or approved for Itinerary Id: " . $iti_id );
				die(json_encode($res));
			}elseif( empty($get_approved_cabs) ){
				$res = array('status' => false, 'msg' => "Cab not booked or approved for Itinerary Id: " . $iti_id );
				die(json_encode($res));
			}else{
				$res = array('status' => true, 'id' => $iti_id );
				die(json_encode($res));
			}
		}else{
			$res = array('status' => false, 'msg' => "Invalid Itinerary! ");
			die(json_encode($res));
		}
	}

	/****************** Marketing Sections  **************************/
	
	
	public function ajaxAddCat(){
		$cat_name = $this->input->post("category_name", TRUE);
		if( !empty($cat_name))
		{
			$result = $this->marketing_model->insertCategory();
				if( $result)
				{
					$res = array('status' => true, 'msg' => "Category Added Successfully!");
				}
				else
				{
					$res = array('status' => false, 'msg' => "Please Try Again !");
				}
			
		}
		else
		{
			$res = array('status' => false, 'msg' => "Category is required!");
		}	
		die( json_encode($res) );
	}
	
	public function ajax_edit_cat(){
		$cat_name = $this->input->post("category_name", TRUE);
		if( !empty($cat_name))
		{
			$result = $this->marketing_model->updateCategory();
				if( $result)
				{
					$res = array('status' => true, 'msg' => "Category updated Successfully!");
				}
				else
				{
					$res = array('status' => false, 'msg' => "Please Try Again !");
				}
			
		}
		else
		{
			$res = array('status' => false, 'msg' => "Category is required!");
		}	
		die( json_encode($res) );
	}
		
	// delete category
	
	public function ajax_deleteCat(){
		$id = $this->input->get('id', TRUE);
		$where = array("id" => $id);
		$result = $this->global_model->update_del_status("marketing_category", $where);
		if( $result){
			$res = array('status' => true, 'msg' => "Category delete Successfully!");
		}else{
			$res = array('status' => false, 'msg' => "Error! please try again later");
		}
		die(json_encode($res));
	}
	
	//Update user theme color
	public function update_user_theme_style(){
		$user = $this->session->userdata('logged_in');
		$user_id = $user['user_id'];
		$theme_color = $this->input->post('theme_color', TRUE);
		$data = array( "theme_style" => trim( $theme_color ) );
		
		$result = $this->global_model->update_data( "users", array("user_id" => $user_id) , $data );
		if( $result){
			$res = array('status' => true, 'msg' => "Theme Updated!");
		}else{
			$res = array('status' => false, 'msg' => "Theme not updated");
		}
		die(json_encode($res));
	}
	//Assign user area 
	public function ajax_assign_user_area(){
		$name = $this->input->post("user", TRUE);
		$state = $this->input->post("state", TRUE);
		$Category = $this->input->post("category", TRUE);
		//Avoid special characters from username
		
		if( !empty($name) && !empty($state)){
			$data = array(
			  'state'=>'state', 
			  'category'=>'category', 
			  'username'=>'name', 
			  
			);
				$result = $this->global_model->insert_data('assign_user_area',$data);
				if( $result){
					$res = array('status' => true, 'msg' => "Area assigned Successfully!");
				}else{
					$res = array('status' => false, 'msg' => "Please Try Again !");
				}
			}
			else{
			$res = array('status' => false, 'msg' => "Select options to assign Area !");
		}	
		die( json_encode($res) );
		}

}	
