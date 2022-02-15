<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Packages extends CI_Controller {
	public function __Construct(){
	   	parent::__Construct();
		validate_login();
		$this->load->model("packages_model");
	}
	//Show all Packages
	public function index(){
		$user = $this->session->userdata('logged_in');
		$user_id = $user["user_id"];
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '96' ){
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('packages/all_packages');
			$this->load->view('inc/footer'); 
		}else{
			redirect(404);
		} 
	}
	
	/* add Package */
	public function add(){
		$user = $this->session->userdata('logged_in');
		$data["user_id"] = $user['user_id'];
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '96' ){
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('packages/add_package', $data);
			$this->load->view('inc/footer');
		}else{
			redirect("dashboard");
		}
	}
	
	/* View Package */
	public function view(){
		$package_id = trim($this->uri->segment(3));
		$temp_key = trim($this->uri->segment(4));
		if( !empty( $package_id ) && !empty( $temp_key ) ){
			$user = $this->session->userdata('logged_in');
			if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '96'){
				$where = array("del_status" => 0, "package_id" => $package_id, "temp_key" => $temp_key);
				$data['package'] 	= $this->global_model->getdata( 'packages', $where );
				$this->load->view('inc/header');
				$this->load->view('inc/sidebar');
				$this->load->view('packages/view', $data);
				$this->load->view('inc/footer');
			}else{
				redirect("dashboard");
			}	 
		}else{
			redirect(404);
		}	
	}
	/* Edit Package */
	public function edit(){
		$user = $this->session->userdata('logged_in');
		$user_id = $user['user_id'];
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '96'){
			$temp_key = trim($this->uri->segment(4));
			$package_id = trim($this->uri->segment(3));
			if( !empty( $package_id ) && !empty( $temp_key ) ){
				$data["user_role"] = $user['role']; 
				$where = array("del_status" => 0, "package_id" => $package_id, "temp_key" => $temp_key );
				$data['itinerary'] = $this->global_model->getdata( "packages", $where );
				$this->load->view('inc/header');
				$this->load->view('inc/sidebar');
				$this->load->view('packages/edit', $data);
				$this->load->view('inc/footer');
			}else{
				redirect(404);
			}	 
		}else{
			redirect("dashboard");
		}	
	}
	
	
	/*****Add Package Category*****/
	
	
	public function addCat(){
		$user = $this->session->userdata('logged_in');
		$user_id = $user["user_id"];
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '96' ){
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('packages/add_package_cat');
			$this->load->view('inc/footer'); 
		}else{
			redirect(404);
		} 
	}
	
	/* Edit Category */
	public function editcat(){
		$user = $this->session->userdata('logged_in');
		$user_id = $user['user_id'];
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '96'){
			$catid = trim($this->uri->segment(3));
			if( !empty( $catid )){
				$data["user_role"] = $user['role']; 
				$where = array("del_status" => 0, "p_cat_id" => $catid);
				$data['row'] = $this->global_model->getdata( "package_category", $where );
				//print_r($data);
				$this->load->view('inc/header');
				$this->load->view('inc/sidebar');
				$this->load->view('packages/edit_pcat', $data);
				$this->load->view('inc/footer');
			}else{
				redirect(404);
			}	 
		}else{
			redirect("dashboard");
		}	
	}
	
	/************ View Category ************/
	
	public function viewCategory(){
		$user = $this->session->userdata('logged_in');
		$user_id = $user["user_id"];
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '96' ){
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('packages/all_package_cat');
			$this->load->view('inc/footer'); 
		}else{
			redirect(404);
		} 
	}
	
	public function ajax_add_cat(){
		$cat_name = $this->input->post("package_cat_name", TRUE);
		if( !empty($cat_name)){
			$result = $this->packages_model->insertCategory();
			if( $result){
				$res = array('status' => true, 'msg' => "Category Added Successfully!");
			}else{
				$res = array('status' => false, 'msg' => "Please Try Again !");
			}
		}else{
			$res = array('status' => false, 'msg' => "Category is required!");
		}	
		die( json_encode($res) );
	}
	
	public function ajax_edit_cat(){
		$cat_name = $this->input->post("package_cat_name", TRUE);
		if( !empty($cat_name)){
			$result = $this->packages_model->updateCategory();
			if( $result){
				$res = array('status' => true, 'msg' => "Category updated Successfully!");
			}else{
				$res = array('status' => false, 'msg' => "Please Try Again !");
			}
		}else{
			$res = array('status' => false, 'msg' => "Category is required!");
		}	
		die( json_encode($res) );
	}
	
	/* data table get all packages */
	public function ajax_packages_list(){
		$user = $this->session->userdata('logged_in');
		$u_id = $user['user_id'];
		$role = $user['role'];
		if( $role == '99' || $role == '98' || $role == '96' ){
			$where = array("del_status" => 0 );
			
			//if state filter exists
			if( isset( $_POST['state_id'] ) && !empty($_POST['state_id']) )
				$where['state_id'] = $_POST['state_id'];
			
			//if cat_id filter exists
			if( isset( $_POST['cat_id'] ) && !empty($_POST['cat_id']) )
				$where['p_cat_id'] = $_POST['cat_id'];
			
			$list = $this->packages_model->get_datatables($where);
		}
		$data = array();
		$no = $_POST['start'];
		if( !empty($list) ){
			foreach ($list as $package) {
				$pub_status = $package->publish_status;
				$row_delete = "";
				$row_edit = "";
				$btncmt = "";
				$no++;
				$package_id = $package->package_id;
				$key = $package->temp_key;
				
				//get publish status
				if( $pub_status == "publish" ){
					$p_status = "<strong>" . ucfirst($pub_status) . "</strong>";
				}else{
					$p_status = "<strong class='red'>" . ucfirst($pub_status) . "</strong>";
				}
				
				$row = array();
				$row[] = $no;
				$row[] = $package->package_id;
				$row[] = $package->package_name;
				$row[] = get_state_name($package->state_id);
				$row[] = get_package_cat_name($package->p_cat_id);
				$row[] = $p_status;
				$row[] = $package->created;
				
				//buttons
				$btn_edit = "<a title='Edit' href=" . site_url("packages/edit/{$package_id}/{$key}") . " class='btn_pencil' ><i class='fa fa-pencil' aria-hidden='true'></i></a>";
				$btn_view = "<a title='View' href=" . site_url("packages/view/{$package_id}/{$key}") . " class='btn_eye' ><i class='fa fa-eye' aria-hidden='true'></i></a>";
				
				//if Package status is publish
				if( $pub_status == "publish" ){
					//delete Package button only for admin
					if( ( is_admin() || is_manager() ) ){ 
						$row_delete = "<a data-id={$package_id} title='Delete Package' href='javascript:void(0)' class='btn_trash ajax_delete_package'><i class='fa fa-trash-o' aria-hidden='true'></i></a>";
					}
					
					$allBtns = $btn_edit . $btn_view . $row_delete;
					$row[] = $allBtns;
				}else{ 
					//if Package in draft hide buttons for sales team
					$row[] = $btn_edit . "
						<a data-id={$package_id} title='Delete Package Permanent' href='javascript:void(0)' class='btn_trash delete_package_permanent'><i class='fa fa-trash-o' aria-hidden='true'></i></a>";
				}	 
				
				$data[] = $row;
			}
		}	
		
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->packages_model->count_all($where),
			"recordsFiltered" => $this->packages_model->count_filtered($where),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}
	
	public function ajax_packages_cat_list(){
		$user = $this->session->userdata('logged_in');
		$u_id = $user['user_id'];
		$role = $user['role'];
		if( $role == '99' || $role == '98' || $role == '96' ){
			$where = array("del_status" => 0 );
			$list = $this->packages_model->get_datatables_cat($where);
		}
		$data = array();
		$no = $_POST['start'];
		if( !empty($list) ){
			foreach ($list as $cat) {
				$row_delete = "";
				$row_edit = "";
				$no++;
				$catId = $cat->p_cat_id;
				
				
				//get publish status
				
				$row = array();
				$row[] = $no;
				$row[] = $cat->package_cat_name;
				$row[] = $cat->added_date;
				
				//buttons
				$btn_edit = "<a title='Edit' href=" . site_url("packages/editcat/{$catId}") . " class='btn_pencil' ><i class='fa fa-pencil' aria-hidden='true'></i></a>";
				//delete Package button only for admin
				if( ( is_admin() || is_manager() ) && $catId != 1 ){ 
					$row_delete = "<a data-id={$catId} title='Delete Package Category' href='javascript:void(0)' class='btn_trash ajax_delete_package_cat'><i class='fa fa-trash-o' aria-hidden='true'></i></a>";
				}
					
				$allBtns = $btn_edit . $row_delete;
				$row[] = $allBtns;
				
				$data[] = $row;
			}
		}
			
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->packages_model->count_all_cat($where),
			"recordsFiltered" => $this->packages_model->count_filtered_cat($where),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}
	
	//add Package
	public function addPackage(){
		$user = $this->session->userdata('logged_in');
		$role = $user['role'];
		$inc_meta	 = $this->input->post('inc_meta');
		$tour_meta 	= $this->input->post('tour_meta');
		$h_meta = $this->input->post('hotel_meta');
		if( isset($_POST["package_name"]) && !empty( $inc_meta ) && !empty( $tour_meta ) && !empty( $h_meta ) ){
			//Update data 
			$unique_id = trim( $_POST['temp_key'] );
			$where_key = array('temp_key' => $unique_id );
			$get_data = $this->global_model->getdata("packages", $where_key);
			$package_id = $get_data[0]->package_id;
			$temp_key = $get_data[0]->temp_key;
			
			$data = array(
				'publish_status' => "publish",
			);
			
			$update_data = $this->global_model->update_data("packages", $where_key, $data );
			
			if( $update_data ){
				$res = array('status' => true, 'msg' => "Package added successfully!", 'package_id' => $package_id, 'temp_key' => $temp_key );
			}else{
				$res = array('status' => false, 'msg' => "Failed! Please try again later.");
			}
		}else{
			$res = array('status' => false, 'msg' => "Failed! All Fields are required.");
		}
		die(json_encode($res));
	}
	//Package Ajax for save value step by step
	//add Package
	public function ajax_savedata_stepwise(){
		$user = $this->session->userdata('logged_in');
		$role = $user['role'];
		
		if( isset($_POST["temp_key"]) ){
			$unique_id = trim( $_POST['temp_key'] );
			$step 	= $_POST['step'];
			switch( $step ){
				case 1:  
					$state_id 			= strip_tags($_POST['state']);
					$package_cat_id 	= strip_tags($_POST['p_cat_id']);
					$package_name 		= strip_tags($_POST['package_name']);
					$package_routing 	= strip_tags($_POST['package_routing']);
					$adults				= strip_tags($_POST['adults']);
					$child				= strip_tags($_POST['child']);
					$child_age			= strip_tags($_POST['child_age']);
					$package_duration 	= strip_tags($_POST['package_duration']);
					$cab_category 		= strip_tags($_POST['cab_category']);
					$agent_id 			= strip_tags($_POST['agent_id']);
					
					$step_data = array(
						'state_id' 			=> $state_id,
						'p_cat_id' 			=> $package_cat_id,
						'package_name' 		=> $package_name,
						'temp_key'			=> $unique_id,
						'package_routing'	=> $package_routing,
						'cab_category'		=> $cab_category,
						'adults'			=> $adults,
						'child'				=> $child,
						'child_age'			=> $child_age,
						'duration'			=> $package_duration,
						'agent_id'			=> $agent_id,
					);
				break;
				case 2:
					$daywise_meta 		= serialize($this->input->post('tour_meta'));
					$step_data = array(
						'daywise_meta' 		=> $daywise_meta,
					);
				break;
				case 3:
					$inc_meta					= serialize($this->input->post('inc_meta'));
					$exc_meta					= serialize($this->input->post('exc_meta'));
					$special_inc_meta			= serialize($this->input->post('special_inc_meta'));
					$step_data = array(
						'inc_meta'					=> $inc_meta,
						'exc_meta'					=> $exc_meta,
						'special_inc_meta'			=> $special_inc_meta,
					);
				break;
				case 4:
					$currentDate = $date;
					$hotel_meta				= serialize($this->input->post('hotel_meta'));
					$hotel_note_meta		= serialize($this->input->post('hotel_note_meta'));
					
					$step_data = array(
						'hotel_meta'			=> $hotel_meta,
						'hotel_note_meta'		=> $hotel_note_meta,
					);
				break;
			}
			
			//update data
			$where = array('temp_key' => $unique_id );
			$get_data = $this->global_model->getdata("packages", $where);
			if( empty( $get_data ) ){
				//insert if data not get
				$insert_data = $this->global_model->insert_data("packages", $step_data );
				if( $insert_data ){
					$res = array('status' => true, 'msg' => "Data save.");
				}else{
					$res = array('status' => false, 'msg' => "Error! Data not save.");
				}
			}else{
				//Update data 
				$where_key = array('temp_key' => $unique_id ); 
				$update_data = $this->global_model->update_data("packages", $where_key, $step_data );
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
	
	//delete draft package
	public function delete_package_permanently(){
		$id = $this->input->get('id');
		$where = array( "package_id" => $id );
		$result = $this->global_model->delete_data( "packages", $where );
		if( $result){
			$res = array('status' => true, 'msg' => "Itinerary delete Successfully!");
		}else{
			$res = array('status' => false, 'msg' => "Error! please try again later");
		}
		die(json_encode($res));
	}
	// update del status if publish
	public function update_del_status_package(){
		$id = $this->input->get('id');
		$where = array( "package_id" => $id );
		$data = array( "del_status" => 1 );
		$result = $this->global_model->update_data( "packages", $where, $data );
		if( $result){
			$res = array('status' => true, 'msg' => "Package delete Successfully!");
		}else{
			$res = array('status' => false, 'msg' => "Error! please try again later");
		}
		die(json_encode($res));
	}
	
	public function update_del_status_package_cat(){
		$id = $this->input->get('id');
		$where = array( "p_cat_id" => $id );
		$data = array( "del_status" => 1 );
		$result = $this->global_model->update_data( "package_category", $where, $data );
		if( $result){
			$res = array('status' => true, 'msg' => "Package Category deleted Successfully!");
		}else{
			$res = array('status' => false, 'msg' => "Error! please try again later");
		}
		die(json_encode($res));
	}
	
	//Package to itinerary ajax request
	public function createItineraryFromPackageId(){
		$user = $this->session->userdata('logged_in');
		$user_id = $user["user_id"];
		
		$package_id 	= trim($this->input->post('package_id'));
		$customer_id 	= trim($this->input->post('customer_id'));
		
		//check if itinerary already created for customer
		$where3 = array( "customer_id" => $customer_id , "parent_iti_id" => "0", "iti_type" => 1 );
		$get_iti = $this->global_model->getdata( "itinerary", $where3 );
		if( $get_iti ){
			$res = array('status' => false, 'msg' => "Itinerary Already For Created This Customer" );
			die(json_encode($res));
		}
		
		//get Agent ID of customer
		$agent_id = $this->global_model->getdata( "customers_inquery", array("customer_id" => $customer_id), "agent_id" );
		$agent_id = !empty( $agent_id ) ? $agent_id : $user_id;
		
		
		if( !empty( $package_id ) && !empty( $customer_id ) ){
			$insert_id = $this->packages_model->clone_package_to_itinerary("packages", "package_id", $package_id, $customer_id, $agent_id);
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
	
	/* Get Package By p_cat_id Id */	
	public function packagesByCatId(){
		if( isset($_POST["pid"]) && isset($_POST["state_id"]) ){
			$state_id = $_POST["state_id"];
			$pid = trim($_POST["pid"]);
			if( !$state_id || !$pid  ){
				echo "<option value=''>Please Select Package Category and State First!</option>";
				die();
			}
			
			$packages = $this->global_model->getdata( "packages", array("p_cat_id" => $pid, "state_id" => $state_id, "del_status" => 0 )  );
			if( $packages ){
				echo '<option value="">Select Package</option>';
				foreach($packages as $pk){
					echo '<option value="'.$pk->package_id.'">' . $pk->package_name . '</option>';
				}
			}else{
				echo "<option value=''>No Package Found Of This Category !</option>";
			}
			die();
		}
	}
	
	//STATES 
	public function managestates(){
		$user = $this->session->userdata('logged_in');
		$u_id = $user['user_id'];
		$role = $user['role'];
		
		if( $role == '99' || $role == '98' ){
			//indian states 
			$data['states'] = $this->global_model->getdata("states", array( "country_id" => 101) );
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('packages/state_list', $data);
			$this->load->view('inc/footer'); 
		}
	}
}	
?>