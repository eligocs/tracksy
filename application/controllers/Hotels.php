<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Hotels extends CI_Controller {
	
	public function __Construct(){
	   	parent::__Construct();
		validate_login();
		$this->load->model("hotel_model");
	}
	public function index(){
		$user = $this->session->userdata('logged_in');
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '97' || $user['role'] == '96'){
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('hotels/hotels' );
			$this->load->view('inc/footer');
		}else{
			redirect("dashboard");
		} 
	}
	
	/* add hotel */
	public function add(){
		$user = $this->session->userdata('logged_in');
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '97'){
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('hotels/addhotel');
			$this->load->view('inc/footer');
		}else{
			redirect("hotels");
		}
	}
	
	/* Add Hotel Ajax Request */
	function ajax_add_hotel(){
		if( isset($_POST["state"]) && !empty($_POST['name'])  ){
			$country			= strip_tags($this->input->post('country'));
			$state				= strip_tags($this->input->post('state'));
			$city				= strip_tags($this->input->post('city'));
			$category			= strip_tags($this->input->post('category'));
			$name				= strip_tags($this->input->post('name'));
			$contact			= strip_tags($this->input->post('contact'));
			$email 				= strip_tags($this->input->post('email[]'));
			$website 			= strip_tags($this->input->post('website'));
			$address 			= strip_tags($this->input->post('address'));
				
			$insert_data= array(
				'country_id'=> $country,
				'state_id'=> $state,
				'city_id'=> $city,
				'hotel_name'=> $name,
				'hotel_category'=> $category,
				'hotel_address'=> $address,
				'hotel_email'=> $email,
				'hotel_contact'=> $contact,
				'hotel_website'=> $website,
			);
			
		}else{
			echo "<div class='alert alert-danger'><strong>Error: </strong>Something went wrong.Please Fill all required fields.</div>";
			die();
		}	
		
		//Check if IMAGE UPLOAD
		if( isset($_FILES["image_url"]["name"]) && !empty($_FILES["image_url"]["name"]) ){
			$n = str_replace(' ', '_', $name);
			$file_name = $n . "_" . time(); 
			$config['upload_path'] = dirname($_SERVER["SCRIPT_FILENAME"]).'/site/images/hotels';
			$config['allowed_types'] = 'jpg|jpeg|png';
			$config['max_size'] = 1024 * 2;
			$config['max_width']  = 600;
            $config['max_height'] = 400;
            $config['file_name'] = $file_name;
			$this->load->library('upload', $config);
			if(!$this->upload->do_upload('image_url')){
				$err = $this->upload->display_errors();
				echo "<div class='alert alert-danger'>{$err}</div>";
				die();
			}else{
				$data = $this->upload->data();
				$img_fname = $data['file_name'];
				
				//Merge hotel_image path to insert_data array
				$insert_data["hotel_image"] = $img_fname;
			}
		}
		
		//Check if hotel exists
		$check_hotel = $this->hotel_model->isHotelExists_insert($city, $name);
		if( $check_hotel ){
			echo '<div class="alert alert-danger"><strong>Error: </strong>Hotel Already Exists in this city.</div>';
			die();
		}
		
		
		//Insert Data
		$insert_id = $this->global_model->insert_data( "hotels", $insert_data);
		if( $insert_id ){
			echo 'success';
		}else{
			echo '<div class="alert alert-danger"><strong>Error: </strong>Something went wrong. Please try again later.</div>';
		} 
		die();
	}
	
	
	/* Edit hotel */
	public function edit($id){
		$user = $this->session->userdata('logged_in');
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '97'){
			$data['hotels'] = $this->hotel_model->get_hotel_byid($id);
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('hotels/hoteledit', $data);
			$this->load->view('inc/footer');
		}else{
			redirect("hotels");
		}	
	} 
	
	/* Edit Hotel Ajax Request */
	function ajax_edit_hotel(){
		if( isset($_POST["id"]) && !empty($_POST['name'])  ){
			$id 		= strip_tags($this->input->post('id', TRUE));
			$country	= strip_tags($this->input->post('country'));
			$state		= strip_tags($this->input->post('state'));
			$city		= strip_tags($this->input->post('city'));
			$category	= strip_tags($this->input->post('category'));
			$name		= strip_tags($this->input->post('name'));
			$contact	= strip_tags($this->input->post('contact'));
			$email 		= strip_tags($this->input->post('email[]'));
			$website 	= strip_tags($this->input->post('website'));
			$address 	= strip_tags($this->input->post('address'));
			$country	= strip_tags($this->input->post('country'));
				
				
			$update_data= array(
				'country_id'	=> $country,
				'state_id'		=> $state,
				'city_id'		=> $city,
				'hotel_name'	=> $name,
				'hotel_category'=> $category,
				'hotel_address'	=> $address,
				'hotel_email'	=> $email,
				'hotel_contact'	=> $contact,
				'hotel_website'	=> $website,
			);
			
		}else{
			echo "<div class='alert alert-danger'><strong>Error: </strong>Something went wrong.Please Fill all required fields.</div>";
			die();
		}	
		
		//Check if IMAGE UPLOAD
		if( isset($_FILES["image_url"]["name"]) && !empty($_FILES["image_url"]["name"]) ){
			$n = str_replace(' ', '_', $name);
			$file_name = $n . "_" . time(); 
			$config['upload_path'] = dirname($_SERVER["SCRIPT_FILENAME"]).'/site/images/hotels';
			$config['allowed_types'] = 'jpg|jpeg|png';
			$config['max_size'] = 1024 * 2;
			$config['max_width']  = 600;
            $config['max_height'] = 400;
            $config['file_name'] = $file_name;
			$this->load->library('upload', $config);
			if(!$this->upload->do_upload('image_url')){
				$err = $this->upload->display_errors();
				echo "<div class='alert alert-danger'>{$err}</div>";
				die();
			}else{
				$data = $this->upload->data();
				$img_fname = $data['file_name'];
				
				//Merge hotel_image path to update_data array
				$update_data["hotel_image"] = $img_fname;
			}
		}
		
		//Check if hotel exists
		$check_hotel = $this->hotel_model->isHotelExists_update($id, $city, $name);
		if( $check_hotel ){
			echo '<div class="alert alert-danger"><strong>Error: </strong>Hotel Already Exists in this city.</div>';
			die();
		}
		
		//Update Data
		$update_data = $this->global_model->update_data( "hotels", array( "id" => $id ), $update_data);
		if( $update_data ){
			echo 'success';
		}else{
			echo '<div class="alert alert-danger"><strong>Error: </strong>Something went wrong. Please try again later.</div>';
		} 
		die();
	}
	
	/* View hotel */
	public function view($id){
		$user = $this->session->userdata('logged_in');
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '97' || $user['role'] == '96'){
			$data['hotels'] = $this->hotel_model->get_hotel_byid($id);
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('hotels/hotelview', $data);
			$this->load->view('inc/footer');
		}	
	} 
	
	/********** Room Category Section ***********/
	
	public function viewroomcategory(){
		$user = $this->session->userdata('logged_in');
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '97'){
			$where = array("del_status" => 0);
			$data['roomcategory'] = $this->global_model->getdata("room_category", $where);
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('hotels/viewroomcategory', $data);
			$this->load->view('inc/footer');
		}else{
			redirect("dashboard");
		} 
	}
	
	/* add Room Category */
	public function addroomcategory(){
		$user = $this->session->userdata('logged_in');
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '97'){
			$where = array("del_status" => 0);
			$roomcategory = $this->global_model->getdata("room_category", $where);
			/* if( count( $roomcategory ) >= 5 ){
				echo "You can add only five room categories";
				die;
			}else{ */
				$this->load->view('inc/header');
				$this->load->view('inc/sidebar');
				$this->load->view('hotels/addroomcategory');
				$this->load->view('inc/footer');
			/* } */	
		}	
	}
	
	/* Edit Room Category */
	
	public function roomcategoryedit($id)
	{
		$user = $this->session->userdata('logged_in');
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '97'){
			$data['categories'] = $this->hotel_model->get_roomcategory_byid($id);
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('hotels/roomcategoryedit', $data);
			$this->load->view('inc/footer');
		}	
	} 
	
	
	
	/********** Room Rates Section ***********/
	
	public function viewroomrates(){
		$user = $this->session->userdata('logged_in');
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '97'){
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('hotels/viewroomrates');
			$this->load->view('inc/footer');
		}else{
			redirect("dashboard");
		} 
	}
	
	/* add Room Rates */
	
	public function addroomrates(){
		$user = $this->session->userdata('logged_in');
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '97')
		{
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('hotels/addroomrates');
			$this->load->view('inc/footer');
		}else{
			redirect("dashboard");
		} 	
	}
	/* Edit Room Rates */
	public function add_room_rates(){
		$hotel_rates_meta =  $this->input->post('hotel_rates_meta', TRUE);
		echo sizeof( $hotel_rates_meta );
		
		$insert_data = array();
		
		echo "<pre>";
			print_r( $hotel_rates_meta );
		echo "</pre>";	
		
		$country 	= $this->input->post('country', TRUE);
		$state 		= $this->input->post('state', TRUE);
		$city		= $this->input->post('city', TRUE);
		$hotel_id 	= $this->input->post('hotel', TRUE);
		
		foreach( $hotel_rates_meta as $hotel_rate ){
			$hotel_cat_id = $hotel_rate["room_cat_id"];
			$rates_inner_meta = $hotel_rate["rates_inner_meta"];
			
			if( empty( $rates_inner_meta ) ) continue;
			
			$count_data = sizeof( $rates_inner_meta );
			
			//Get inner meta
			foreach( $rates_inner_meta as $inner_meta ){
				$season_id 		= $inner_meta["season_id"];
				$room_rates 	= $inner_meta["room_rates"];
				$extra_bed_rate = $inner_meta["extra_bed_rate"];
				$meal_plan_id 	= $inner_meta["meal_plan_id"];
				$extra_bed_rate_child 	= $inner_meta["extra_bed_rate_child"];
				
				$insert_data[] = array(
					"hotel_id" 			=> $hotel_id,
					"state_id" 			=> $state,
					"city_id" 			=> $city,
					"country_id" 		=> $country,
					"hotel_name" 		=> get_hotel_name($hotel_id) ,
					"room_cat_id" 		=> $hotel_cat_id,
					"season_id" 		=> $season_id,
					"room_rates" 		=> $room_rates,
					"extra_bed_rate" 	=> $extra_bed_rate,
					"extra_bed_rate_child" 	=> $extra_bed_rate_child,
					"meal_plan_id" 		=> $meal_plan_id,
				);
			}
		}
		
		$insert_data = $this->db->insert_batch('hotel_room_rates',$insert_data);

		echo "<br>";
		echo "<pre>";
			print_r( $insert_data );
		echo "</pre>";
		die;
		
	}
	
	public function editroomrates($id){
		$user = $this->session->userdata('logged_in');
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '97'){
			$data['roomrates'] = $this->hotel_model->get_hotelroomrates_byid($id);
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('hotels/roomratesedit', $data);
			$this->load->view('inc/footer');
		}	
	}
	
	/* data table get all Hotels */
	public function ajax_hotel_list(){
		$user = $this->session->userdata('logged_in');
		$u_id = $user['user_id'];
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '97' || $user['role'] == '96'){
			
			$list = $this->hotel_model->get_datatables();
			$data = array();
			$no = $_POST['start'];
			if( !empty($list) ){
				foreach ($list as $hotel) {
					$country = get_country_name($hotel->country_id);
					$state = get_state_name($hotel->state_id);
					$city = get_city_name($hotel->city_id);
					$hotel_cat = get_hotel_cat_name($hotel->hotel_category);
					
					$row_delete = $row_edit = "";
					$row1="";
					$no++;
					$row = array();
					$row[] = $no;
					$row[] = $hotel->hotel_name;
					$row[] = $hotel_cat;
					$row[] = $state;
					$row[] = $city;
					$row[] = $hotel->hotel_address;
					$row[] = $hotel->hotel_email;
					$row[] = $hotel->hotel_contact;
					
					$h_cat = $hotel->hotel_category;
					
					if( is_admin()){
						//Delete
						$row_delete = "<a title='delete' href='javascript:void(0)' data-id = {$hotel->id} class='btn btn-danger ajax_delete_hotel'><i class='fa fa-trash-o'></i></a>";
					}
					
					if( $user['role'] != '96' ){
						//edit
						$row_edit = "<a title='edit' href=" . site_url("hotels/edit/{$hotel->id}") . " class='btn btn-success ajax_edit_hotel_table' ><i class='fa fa-pencil'></i></a>";
					}
					// View 
					$row[] = "<a title='view' href=" . site_url("hotels/view/{$hotel->id}") . " class='btn btn-success viewhotel' ><i class='fa fa-eye'></i></a>". $row_edit . $row_delete; 
					$data[] = $row;
				}
			}	
			
			$output = array(
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->hotel_model->count_all(),
				"recordsFiltered" => $this->hotel_model->count_filtered(),
				"data" => $data,
			);
			//output to json format
			echo json_encode($output);
		}	
	}
	
	/* data table get all Room rates */
	public function ajax_roomrates_list(){
		$user = $this->session->userdata('logged_in');
		$u_id = $user['user_id'];
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '97'){
			
			$list = $this->hotel_model->get_datatables_room_rates();
			$data = array();
			$no = $_POST['start'];
			if( !empty($list) ){
				foreach ($list as $rate) {
					$hotelname =  get_hotel_name($rate->hotel_id);
					$city = get_city_name($rate->city_id);
					$roomcatname = get_room_category_by_id($rate->room_cat_id);
					
					$row_delete = "";
					$row1="";
					$no++;
					$row = array();
					$row[] = $no;
					$row[] = $hotelname;
					$row[] = $city;
					$row[] = $roomcatname;
					$row[] = $rate->room_rates;
					$row[] = $rate->extra_bed_rate;
					
					if( is_admin() ){
						//Delete
						$row_delete = "<a title='delete' href='javascript:void(0)' data-id = {$rate->htr_id} class='btn btn-danger ajax_delete_hotelroomrates'><i class='fa fa-trash-o'></i></a>";
					}
		
					// edit 
					$row[] = "<a title='edit' href=" . site_url("hotels/editroomrates/{$rate->htr_id}") . " class='btn btn-success' ><i class='fa fa-pencil'></i></a>". $row_delete; 
					
					$data[] = $row;
				}
			}	
			
			$output = array(
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->hotel_model->count_all_room_rates(),
				"recordsFiltered" => $this->hotel_model->count_filtered_room_rates(),
				"data" => $data,
			);
			//output to json format
			echo json_encode($output);
		}	
	}
	
	/****************Hotel Seasons section************/
	public function seasons(){
		$user = $this->session->userdata('logged_in');
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '97'){
			$where = array("del_status" => 0);
			$data['seasons'] = $this->global_model->getdata("season_type", $where);
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('hotels/seasons', $data );
			$this->load->view('inc/footer');
		}else{
			redirect("dashboard");
		} 
	}
	
	/* add Season */
	public function addseason(){
		$user = $this->session->userdata('logged_in');
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '97'){
			$where = array("del_status" => 0);
			$seasons = $this->global_model->getdata("season_type", $where);
			if( count($seasons) >= 3 ){
				echo "Your Can add only three seasons";
				die;
			}else{
				$this->load->view('inc/header');
				$this->load->view('inc/sidebar');
				$this->load->view('hotels/season_add');
				$this->load->view('inc/footer');
			}	
		}	
	}
	
	/* save Season */
	public function saveseason(){
		$user = $this->session->userdata('logged_in');
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '97'){
			if (isset($_POST['inp']['season_name']) && !empty($_POST['inp']['season_name'])) {
				$inp = $this->input->post('inp', TRUE);
				$season_date_meta = serialize($this->input->post('season_date_meta', TRUE));
				/* check if season name already exists */
				$season_name = $_POST['inp']['season_name'];
				
				$where_name = array("season_name" => trim($season_name), "del_status" => 0);
				$get_season = $this->global_model->getdata("season_type", $where_name);
				if( $get_season ){
					$this->session->set_flashdata('error',"Season name already exists.");
					redirect("hotels/addseason");
					exit();
				}
				
				//Get data
				$data = array( 
					"season_name" => $season_name,
					"season_date"	=> $season_date_meta,
				);
				$season_id = $this->global_model->insert_data("season_type", $data);
				if( $season_id ){
					$this->session->set_flashdata('success',"Season added successfully.");
					redirect("hotels/seasons");
				}else{
					$this->session->set_flashdata('error',"Season not added successfully.");
					redirect("hotels/addseason");
				}
			}else{
				$this->session->set_flashdata('error',"Season Name can't be empty.");
				redirect("hotels/addseason");
			}
			
		}	
	}
	/* Edit Season */
	public function editseason($id){
		$user = $this->session->userdata('logged_in');
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '97'){
			$season_id = trim($id);
			if( !empty( $season_id ) ){	
				$where = array( "id"=>$season_id );
				$data['season'] = $this->global_model->getdata("season_type", $where);
				$this->load->view('inc/header');
				$this->load->view('inc/sidebar');
				$this->load->view('hotels/season_edit', $data);
				$this->load->view('inc/footer');
			}else{
				redirect("hotels/seasons");
			}	
		}	
	}
	
	/* update Season */
	public function updateseason(){
		$user = $this->session->userdata('logged_in');
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '97'){
			if (isset($_POST['inp']['season_name']) && !empty($_POST['inp']['season_name'])) {
				$data = $this->input->post('inp', TRUE);
				$season_date_meta = serialize($this->input->post('season_date_meta', TRUE));
				$season_name = $_POST['inp']['season_name'];
				//Get data
				$data = array( 
					"season_name" => $season_name,
					"season_date"	=> $season_date_meta,
				);
				
				$id = $_POST['inp']['id'];
				/* check if season name already exists */
				$where_name = array("season_name" => trim($season_name), "del_status" => 0, "id !=" => $id );
				$get_season = $this->global_model->getdata("season_type", $where_name);
				if( $get_season ){
					$this->session->set_flashdata('error',"Season name already exists.");
					redirect("hotels/seasons");
				}else{
					$where = array( "id" => $id );
					$season_id = $this->global_model->update_data("season_type",$where, $data);
					if( $season_id ){
						$this->session->set_flashdata('success',"Season Update successfully.");
						redirect("hotels/seasons");
					}else{
						$this->session->set_flashdata('error',"Season not Update successfully.");
						redirect("hotels/editseason");
					}
				}	
			}else{
				$this->session->set_flashdata('error',"Season Name can't be empty.");
				redirect("hotels/editseason");
			}
			
		}	
	}
	
	//update delete status season
	public function season_delete(){
		$id = $this->input->get('id', TRUE);
		$where = array("id" => $id);
		$result = $this->global_model->update_del_status("season_type", $where);
		if( $result){
			$res = array('status' => true, 'msg' => "Season delete Successfully!");
			$this->session->set_flashdata('success',"Season delete Successfully!");
		}else{
			$res = array('status' => false, 'msg' => "Error! please try again later");
		}
		die(json_encode($res));
	}
	
	/****************Meal Plan section************/
	public function mealplan(){
		$user = $this->session->userdata('logged_in');
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '97'){
			$where = array("del_status" => 0);
			$data['mealplan'] = $this->global_model->getdata("meal_plan", $where);
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('hotels/mealplan', $data );
			$this->load->view('inc/footer');
		}else{
			redirect("dashboard");
		} 
	}
	
	/* add Meal Plan */
	public function addmealplan(){
		$user = $this->session->userdata('logged_in');
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '97'){
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('hotels/mealplan_add');
			$this->load->view('inc/footer');
		}	
	}
	
	/* save Meal Plan */
	public function savemealplan(){
		$user = $this->session->userdata('logged_in');
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '97'){
			if (isset($_POST['inp']['name']) && !empty($_POST['inp']['name'])) {
				$inp = $this->input->post('inp', TRUE);
				/* check if season name already exists */
				$name = $_POST['inp']['name'];
				$where_name = array("name" => trim( $name ), "del_status" => 0);
				$get_mp = $this->global_model->getdata("meal_plan", $where_name);
				if( $get_mp ){
					$this->session->set_flashdata('error',"Meal Plan already exists.");
					redirect("hotels/addmealplan");
					exit();
				}
				
				$meal_id = $this->global_model->insert_data("meal_plan", $inp);
				if( $meal_id ){
					$this->session->set_flashdata('success',"Meal Plan added successfully.");
					redirect("hotels/mealplan");
				}else{
					$this->session->set_flashdata('error',"Meal Plan not added successfully.");
					redirect("hotels/addmealplan");
				}
			}else{
				$this->session->set_flashdata('error',"Meal Plan can't be empty.");
				redirect("hotels/mealplan");
			}
			
		}	
	}
	/* Edit Meal Plan */
	public function editmealplan($id){
		$user = $this->session->userdata('logged_in');
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '97'){
			$meal_id = trim($id);
			if( !empty( $meal_id ) ){	
				$where = array( "id" => $meal_id );
				$data['mealplans'] = $this->global_model->getdata("meal_plan", $where);
				$this->load->view('inc/header');
				$this->load->view('inc/sidebar');
				$this->load->view('hotels/mealplan_edit', $data);
				$this->load->view('inc/footer');
			}else{
				redirect("hotels/mealplan");
			}	
		}	
	}
	
	/* update Meal Plan */
	public function updatemealplan(){
		$user = $this->session->userdata('logged_in');
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '97'){
			if (isset($_POST['inp']['name']) && !empty($_POST['inp']['name'])) {
				$data = $this->input->post('inp', TRUE);
				$id = $_POST['inp']['id'];
				$name = $_POST['inp']['name'];
				/* check if Meal Plan name already exists */
				$where_name = array("name" => trim($name), "del_status" => 0, "id !=" => $id);
				$mealPlan = $this->global_model->getdata("meal_plan", $where_name);
				if( $mealPlan ){
					$this->session->set_flashdata('error',"Meal Plan already exists.");
					redirect("hotels/mealplan");
				}else{
					$where = array( "id" => $id );
					$season_id = $this->global_model->update_data("meal_plan",$where, $data);
					if( $season_id ){
						$this->session->set_flashdata('success',"Meal Plan Update successfully.");
						redirect("hotels/mealplan");
					}else{
						$this->session->set_flashdata('error',"Meal Plan not Update successfully.");
						redirect("hotels/editmealplan");
					}
				}	
			}else{
				$this->session->set_flashdata('error',"Meal Plan can't be empty.");
				redirect("hotels/editmealplan");
			}
			
		}	
	}
	
	//update delete status Meal Plan
	public function mealplan_delete(){
		$id = $this->input->get('id', TRUE);
		$where = array("id" => $id);
		$result = $this->global_model->update_del_status("meal_plan", $where);
		if( $result){
			$res = array('status' => true, 'msg' => "Meal Plan delete Successfully!");
			$this->session->set_flashdata('success',"Meal Plan delete Successfully!");
		}else{
			$res = array('status' => false, 'msg' => "Error! please try again later");
		}
		die(json_encode($res));
	}
	
	//state codes
	public function statecodes(){
		$user = $this->session->userdata('logged_in');
		if( $user ){
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('hotels/state_codes');
			$this->load->view('inc/footer');
		}else{
			redirect("hotels");
		}
	}
	
	public function city_with_codes(){
		if(isset($_POST["state"])){
			$state_id = $_POST["state"];
			// Define state and city array
			$city_list = get_city_list( $state_id );
			if( $city_list ){
				if($state_id !== ''){
					//echo '<option value="">Select City</option>';
					foreach($city_list as $city){
						echo "<option value={$city->id}> {$city->name}  < Code : {$city->id} > </option>";
					}
				}
			}else{
				echo '<option value="">Select City!</option>';
			}	
			die();
		}
	}
	
}	

?>