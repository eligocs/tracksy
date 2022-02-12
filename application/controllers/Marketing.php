<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Marketing extends CI_Controller {
	public function __Construct(){
	   	parent::__Construct();
		validate_login();
		$this->load->model("marketing_model");
		$this->load->model("Login_model");
	}
	
	public function index(){
		$data['categories']= $this->marketing_model->getAllCategory();
		$user = $this->session->userdata('logged_in');
		if( $user['role'] == '99' || is_super_manager() || $user['role'] == '95' || $user['role'] == '96' || $user['role'] == '97'){
			$data['check_assign_area'] = $this->Login_model->get_area_for_user( $user['user_id'] );
			$data['user_role'] = $user['role'];
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('marketing/alluserlist', $data);
			$this->load->view('inc/footer');
		}else{	
			redirect("dashboard");
		}
	}
	
	//add marketing user
	public function add(){
		$user = $this->session->userdata('logged_in');
		if( $user['role'] == '99' || is_super_manager() || $user['role'] == '95'){
			$data['row']= $this->marketing_model->getAllCategory();
			$data['user_id'] = $user['user_id'];
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('marketing/adduser', $data);
			$this->load->view('inc/footer');
		}elseif($user['role'] == '96' || $user['role'] == '97'){
			$id =  $user['user_id'];
			$data['views'] = $this->Login_model->get_area_for_user($id);
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('marketing/agentadduser' , $data);
			$this->load->view('inc/footer');
		}else{
			redirect("dashboard");
		}	
	}
	
	public function ajaxAdd_m_user(){
		$catId = $this->input->post("cat_id", TRUE);
		$email_id = $this->input->post("email_id", TRUE);
		
		if( !empty($catId) && !empty($email_id)){
			
			//Check if user exists
			$city = trim($this->input->post("city"));
			$company_name = trim($this->input->post("company_name"));
			$check_user = $this->marketing_model->isMarketingUserExists_insert($city, $company_name);
			if( $check_user ){
				$res = array('status' => false, 'msg' => "Marketing User Already Exists In This CIty");
				die( json_encode($res) );
			}
		
			$insert_id = $this->marketing_model->insertMarketingUser();
			if( $insert_id)
			{
				$this->session->set_flashdata('success',"User Add successfully.");
				$res = array('status' => true, 'msg' => "Marketing User Added Successfully!", "insert_id" => $insert_id);
			}
			else
			{
				$res = array('status' => false, 'msg' => "Please Try Again !");
			}
		}else{
			$res = array('status' => false, 'msg' => "Category and Email Id is required!");
		}	
		die( json_encode($res) );
	}
	
	//edit marketing user
	public function edit($id){
		$user = $this->session->userdata('logged_in');
		$m_id = trim( $id );
		
		$data['user_id'] = $user['user_id'];
		$data['row']= $this->marketing_model->getAllCategory();
		if( $user['role'] == '99' || is_super_manager() || $user['role'] == '95' ){
			$where = array("id" => $m_id);
			$data['m_user'] = $this->global_model->getdata( "marketing", $where );
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('marketing/edituser', $data);
			$this->load->view('inc/footer');
		}elseif( $user['role'] == '96' || $user['role'] == '97' ){
			$data['m_user'] = $this->marketing_model->get_marketing_user_by_agent( $m_id );
			$id =  $user['user_id'];
			$where = array( "id" => $m_id );
			$data['views'] = $this->Login_model->get_area_for_user( $user['user_id'] );
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('marketing/agent_edituser' , $data);
			$this->load->view('inc/footer');
		}else{
			redirect("dashboard");
		}	
	}
	
	//ajax request edit
	public function ajax_update_muser(){
		$m_id = $this->input->post("m_id", TRUE);
		if( !empty($m_id)){
			//Check if user exists
			$city	 = trim($this->input->post("city"));
			$company_name = trim($this->input->post("company_name"));
			$check_user = $this->marketing_model->isMarketingUserExists_update($m_id, $city, $company_name);
			if( $check_user ){
				$res = array('status' => false, 'msg' => "Marketing User Already Exists In This CIty");
				die( json_encode($res) );
			}
			
			$result = $this->marketing_model->updateMarketingUser();
			if( $result){
				$this->session->set_flashdata('success',"User Edit successfully.");
				$res = array('status' => true, 'msg' => "Category updated Successfully!");
			}else{
				$res = array('status' => false, 'msg' => "Please Try Again !");
			}
		}else{
			$res = array('status' => false, 'msg' => "Category is required!");
		}	
		die( json_encode($res) );
	}
	//view marketing user
	public function view($id){
		$user = $this->session->userdata('logged_in');
		$user_id = $user['user_id'];
		
		$data["user_id"] = $user_id;
		$data["role"] 	= $user['role'];
		if( $user['role'] == '99' || is_super_manager() || $user['role'] == '95' ){
			$m_id = trim( $id );
			$where2 = array( "customer_id" => $m_id);
			$followUpData = $this->global_model->getdata("marketing_customer_followup", $where2, "", "id");
			$data['followUpData'] = $followUpData;
			$where = array("id" => $m_id);
			$data['m_user'] = $this->global_model->getdata( "marketing", $where );
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('marketing/view', $data);
			$this->load->view('inc/footer');
		}else if( $user['role'] == '96' || $user['role'] == '97' ){
			$m_id = trim( $id );
			$where2 = array( "customer_id" => $m_id);
			$followUpData = $this->global_model->getdata("marketing_customer_followup", $where2, "", "id");
			$data['followUpData'] = $followUpData;
			$data['m_user'] = $this->marketing_model->get_marketing_user_by_agent( $m_id );
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('marketing/view', $data);
			$this->load->view('inc/footer');
		}else{
			redirect("dashboard");
		}
	}
	
	public function addcat(){
		$user = $this->session->userdata('logged_in');
		if( $user['role'] == '99' || is_super_manager() || $user['role'] == '95'){
			$data['user_id'] = $user['user_id'];
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('marketing/addcat', $data);
			$this->load->view('inc/footer');
		}else{
			redirect("dashboard");
		}	
	}
	
	public function editcat($id){
		$user = $this->session->userdata('logged_in');
		$data['user_id'] = $user['user_id'];
		if( $user['role'] == '99' || is_super_manager() || $user['role'] == '95'){
			$data['row']= $this->marketing_model->getCategoryDetails($id);
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('marketing/editcat', $data);
			$this->load->view('inc/footer');
		}else{
			redirect("dashboard");
		}	
	}
	
	public function viewcat(){
		$user = $this->session->userdata('logged_in');
		if( $user['role'] == '99' || is_super_manager() || $user['role'] == '95'){
			$data['row']= $this->marketing_model->getAllCategory();
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('marketing/alllistcat',$data);
			$this->load->view('inc/footer');
		}else{	
			redirect("dashboard");
		}
	}
	
	
	
	// update delete status marketing User
	public function ajax_deleteMUser(){
		$id = $this->input->get('id', TRUE);
		$where = array("id" => $id);
		$result = $this->global_model->update_del_status("marketing", $where);
		if( $result){
			$res = array('status' => true, 'msg' => "Marketing User delete Successfully!");
		}else{
			$res = array('status' => false, 'msg' => "Error! please try again later");
		}
		die(json_encode($res));
	}

	/* data table get all Marketing */
	public function ajax_marketing_user_list(){
		$user = $this->session->userdata('logged_in');
		$where = array("del_status" => 0);
		//Get filter Data
		if( isset( $_POST['city_id'])  && isset( $_POST['state_id'] ) && !empty($_POST['state_id']) ){
			//if city_id not exists
			if( $_POST['city_id'] != "all"  ){
				$where["city"] 	= $_POST['city_id'];
			}	
			$where["state"] 	= $_POST['state_id'];
			$where["cat_id"] 	= $_POST['cat_id'];
		}
		
		
		$list = $this->marketing_model->get_datatables($where );
		$data = array();
		$no = $_POST['start'];
		if( !empty($list) )
		{
			foreach ($list as $cat) 
			{
					$del="";
					$no++;
					$row = array();
					$row[] = $no;
					$row[] = $cat->name;
					$row[] = !empty( $cat->state ) ? get_state_name($cat->state) : "";
					$row[] = !empty( $cat->city ) ? get_city_name($cat->city) : "";
					$row[] = $cat->company_name;
					$row[] = $cat->email_id;
					$row[] = $cat->contact_number;
					$row[] = get_marking_cat_name($cat->cat_id);
					
					if( is_admin() ){
						$del = "<a title='delete' href='javascript:void(0)' data-id = {$cat->id} class='btn btn-danger ajax_delete_user'><i class='fa fa-trash-o'></i></a>";
					}
					$btn = "<a title='edit' href=" . site_url("marketing/edit/{$cat->id}") . " class='btn btn-success ajax_edit_user_table' ><i class='fa fa-pencil'></i></a>"; 
					$btn .= "<a title='edit' href=" . site_url("marketing/view/{$cat->id}") . " class='btn btn-success' ><i class='fa fa-eye'></i></a>"; 
					
					$row[] = $btn . $del;
					$row[] = !empty($cat->agent_id) ? get_user_name( $cat->agent_id ) : "";
					$data[] = $row;
			}
		}	
		
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->marketing_model->count_all($where),
			"recordsFiltered" => $this->marketing_model->count_filtered($where),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}
	
	/* Get City data By state Id */	
	public function cityListByStateId(){
		if(isset($_POST["state"])){
			$state_id = trim($_POST["state"]);
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
				echo '<option value="">Other City!</option>';
			}
			die();
		}
	}
	
	/* Get City data By state Id */	
	public function assigned_city_agent_by_state_id(){
		$user = $this->session->userdata('logged_in');
		$user_id = $user["user_id"];
		if(isset($_POST["state"])){
			$where = array( "user" => $user_id );
			$get_assiged_city = $this->global_model->getdata("assign_user_area", $where, "city");
			$get_assiged_city = !empty( $get_assiged_city ) ? explode(",", $get_assiged_city) : "";
			
			$state_id = trim($_POST["state"]);
			// Define state and city array
			$city_list = get_city_list( $state_id );
			if( $city_list ){
				if($state_id !== ''){
					echo '<option value="">Select City</option>';
					foreach($city_list as $city){
						if( !empty( $get_assiged_city ) && !in_array( $city->id, $get_assiged_city ) ){
							continue;
						} 
						
						echo '<option value="'. $city->id . '">' . $city->name . '</option>';
					}
				}
			}else{
				echo '<option value="">Other City!</option>';
			}
			die();
		}
	}
	
	
	/* Get City data By state Id */	
	public function cityListByStateIdMulti(){
		if(isset($_POST["state"]) && !empty($_POST["state"]) ){
			$states = $_POST["state"];
			$user_id = trim($_POST["user_id"]);
			$city_ex = explode(',', $_POST["assigned_city"]);
			$city_html = "";
			$already_assigned_city = $this->login_model->check_agents_assigned_city( $user_id );
			foreach( $states as $state ){
				// Define state and city array
				$city_list = get_city_list( $state );
				$state_name = get_state_name( $state );
				if( $city_list ){
					$city_html .= "<optgroup label='{$state_name}'>";
					foreach($city_list as $city){
						$selected =  in_array( $city->id , $city_ex)  ? "selected=selected" : "";		
						$disabled = !empty( $already_assigned_city ) && in_array( $city->id, $already_assigned_city ) ? "disabled=disabled" : "";
						$city_html .= "<option {$disabled} {$selected} value={$city->id}>{$city->name}</option>";
					}
					$city_html .= "</optgroup>";
				}else{
					$city_html .= '<option value="">Other City!</option>';
				}
			}	
			echo $city_html;
			die();
		}
	}
	
	/* public function cityListByStateIdMulti(){
		if(isset($_POST["state"])){
			$state_id = trim($_POST["state"]);
			$user_id = trim($_POST["user_id"]);
			// Define state and city array
			$city_list = get_city_list( $state_id );
			$already_assigned_city = $this->login_model->check_agents_assigned_city( $user_id );
			
			if( $city_list ){
				if($state_id !== ''){
					foreach($city_list as $city){
						$disabled = !empty( $already_assigned_city ) && in_array( $city->id, $already_assigned_city ) ? "disabled=disabled" : "";
						echo "<option {$disabled} value={$city->id}>{$city->name}</option>";
					}
				}
			}else{
				echo '<option value="">Other City!</option>';
			}
			die();
		}
	} */
	
	
	/* Get City data By state Id */	
	public function ajax_get_marketing_user_city_list(){
		$state 	= $this->input->post("state", true);
		$cat 	= $this->input->post("cat", true);
		$city_html = "";
		$where = array( "state" => $state, "cat_id" => $cat );
		$user_list = $this->marketing_model->get_city_list_by_cat_state( "marketing", $where );
		$date_between = "";
		if( isset( $_POST['date_from'] ) && !empty( $_POST['date_from'] ) ){
			$date_between = 'created BETWEEN "'. date('Y-m-d', strtotime($_POST['date_from'])). '" and "'. date('Y-m-d', strtotime($_POST['date_to'])).'"';
		}	

		if( $user_list ){
			$all_count = $this->marketing_model->count_all_musers( "marketing", $where, $date_between );
			//Export Data buttong
			$city_html = "<button class='btn' id='btn_export_data' data-state_id={$state} data-city_id='' data-cat_id ='{$cat}'> Export Data </button> ";
			
			$city_html .= "<button class='btn city_btn active' data-state_id={$state} data-city_id='all' data-cat_id ='{$cat}'> All ({$all_count}) </button> ";
			foreach( $user_list as $list ){
				$where_city = array( "city" => $list->city, "state" => $state, "cat_id" => $cat );
				$count_data = $this->marketing_model->count_all_musers("marketing", $where_city, $date_between );
				if( !empty( $list->city ) ){
					$city_name	 = get_city_name($list->city);
					$city_html .= "<button class='btn city_btn' data-state_id={$state} data-city_id={$list->city} data-cat_id = {$cat}> {$city_name} ({$count_data}) </button> ";
				}
			}
			$res = array( "status" => true, "msg" => "Success" , "city_data" => $city_html  );
		}else{
			$res = array( "status" => false, "msg" => "No Data Found."  );
		}
		die( json_encode( $res ) );
	}
	
	//Import marketing users
	public function import_marketing_users(){
		if( isset($_POST["Import"]) ){
			$filename = $_FILES["file"]["tmp_name"];
			if( $_FILES["file"]["size"] > 0 && $_FILES["file"]["type"] == "application/vnd.ms-excel" ){
				$file = fopen($filename, "r");
				$i = 0;
				$insert_data = array();
				while ( ( $getData = fgetcsv($file, 10000, ",") ) !== FALSE ){
					$i++;
					//skip first row
					if( $i == 1 ) continue;
					
					//Get all marketing users
					$check_if_email_exists = $this->global_model->getdata( "marketing", array("del_status" => 0, "email_id" => trim($getData[3]) ) );
					if( !empty( $check_if_email_exists ) ) continue;
					
					$name = str_replace("?", "", $getData[2]);
					
					$insert_data[] = array(
						"created"			=> trim( str_replace("?", "", $getData[0]) ),
						"cat_id"			=> trim( str_replace("?", "", $getData[1]) ),
						"name"				=> $name,
						"email_id"			=> trim( str_replace(" ", "", $getData[3]) ),
						"contact_number"	=> trim( str_replace(" ", "", $getData[4]) ),
						"whats_app_number"	=> trim( str_replace(" ", "", $getData[5]) ),
						"company_name"		=> trim( str_replace("?", "", $getData[6]) ),
						"state"				=> trim( str_replace("?", "", $getData[7]) ),
						"city"				=> trim( str_replace("?", "", $getData[8]) ),
						"place"				=> trim( str_replace("?", "", $getData[9]) ),
					);
				}
				//If data exists
				if( !empty( $insert_data ) ){
					$insert = $this->global_model->insert_batch_data( "marketing", $insert_data );
					if(!isset($insert)){
						//echo "<script type=\"text/javascript\">
							//	alert(\"Invalid File:Please Upload CSV File.\");
							 // </script>";
						$this->session->set_flashdata('error',"Error: Users not imported.");
					}else{
						$this->session->set_flashdata('success',"Users Imported successfully.");
						//echo "<script type=\"text/javascript\">
							//alert(\"User has been successfully Imported.\");
						//</script>";
					}
				}else{
					$this->session->set_flashdata('error',"Error: Users not imported.");
				}	
				fclose($file);	
			}else{
				$this->session->set_flashdata('error',"Invalid File:Please Upload CSV File.");
			}
			redirect("marketing");	
		}else{
			redirect("marketing");	
		}	
		exit();
	}
	//ajax request to update Customer followup
	public function updateCustomerFollowup(){
		$user = $this->session->userdata('logged_in');
		$u_id = $user['user_id'];
		$role = $user['role'];
		$customer_id			= strip_tags($this->input->post("customer_id", TRUE));
		//echo  $customer_id; die;
		$agent_id				= strip_tags($this->input->post("agent_id", TRUE));
		//$temp_key				= strip_tags($this->input->post("temp_key", TRUE));
		$callType 				= strip_tags($this->input->post("callType", TRUE));
		$callSummary 			= strip_tags($this->input->post("callSummary", TRUE));
		$callSummaryNotpicked 	= strip_tags($this->input->post("callSummaryNotpicked", TRUE));
		$nextCallTime 			= strip_tags($this->input->post("nextCallTime", TRUE));
		$nextCallTimeNotpicked 	= strip_tags($this->input->post("nextCallTimeNotpicked", TRUE));
		$txtProspect 			= strip_tags($this->input->post("txtProspect", TRUE));
		$txtProspectNotpicked 	= strip_tags($this->input->post("txtProspectNotpicked", TRUE));
		$final_amount 			= strip_tags($this->input->post("final_amount", TRUE));
		$book_query 			= strip_tags($this->input->post("book_query", TRUE));
		$comment 				= strip_tags($this->input->post("comment", TRUE));
		
		
		$currentDate = current_datetime();
		
	if( !empty($customer_id) && !empty($callType)){
		 if( $callType == "Picked call" ){
				
				$where_iti = array( "customer_id" => $customer_id );
				$u_data = array( "cus_last_followup_status" => "Picked call" , "lead_last_followup_date" => $currentDate);
				//$update_status = $this->global_model->update_data( "customers_inquery", $where_iti, $u_data );
					
				$call_smry = $callSummary;
				$lead_status = $txtProspect;
				$nxt_call = $nextCallTime;
			}else{
				$call_smry = $callSummaryNotpicked;
				$lead_status = $txtProspectNotpicked;
				$nxt_call = $nextCallTimeNotpicked;
			}
			//Update status
			if( $callType == "Call not picked" ){
				if( empty( $book_query ) ||  $book_query != "9" ){
					$where_iti = array( "customer_id" => $customer_id );
					$u_data = array( "cus_last_followup_status" => "Call not picked", "lead_last_followup_date" 	=> $currentDate );
					//$update_status = $this->global_model->update_data( "customers_inquery", $where_iti, $u_data );
				}	
			}	
			
			$approved = "false";
			
			//update Lead status on decline
			if( $callType == "8" ){
				$where_iti = array( "customer_id" => $customer_id );
				//if reopen lead decline by customer
				$u_data = array( 
					"decline_reason"				=> $this->input->post('decline_reason', TRUE), 
					"decline_comment"				=> $this->input->post('decline_comment', TRUE), 
					"cus_status" 					=>8, 
					"lead_last_followup_date" 		=> $currentDate,
					"cus_last_followup_status" 		=> 8 
				);
				//$update_status = $this->global_model->update_data( "customers_inquery", $where_iti, $u_data );
			} 
			
			$data= array(
				'customer_id' 		=> $customer_id,
				'callType' 			=> $callType,
				'callSummary' 		=> $call_smry,
				'comment' 			=> $comment,
				'nextCallDate'		=> $nxt_call,
				'customer_prospect'	=> $lead_status,
				'currentCallTime'	=> $currentDate,
				'agent_id'			=> $agent_id,
				'temp_key'			=> '',
			);
			
			//Update customer followUp last data
			$upf_data = array( "call_status" => 1 );
			$this->global_model->update_data("marketing_customer_followup", array( "customer_id" => $customer_id ), $upf_data );
			
			$insert_id = $this->global_model->insert_data( "marketing_customer_followup", $data );
			if( $insert_id ){
				$res = array('status' => true, 'msg' => "Call log detail update successfully!", "approved" => $approved, "customer_id" => $customer_id);
			}else{
				$res = array('status' => false, 'msg' => "Call log detail not update successfully!");
			}	
		}else{
			$res = array('status' => false, 'msg' => "Invalid request please try again later!");
		}
		die( json_encode($res) );
	}
	
	
	//STATES / CITY codes
	public function state_codes(){
		$user = $this->session->userdata('logged_in');
		$u_id = $user['user_id'];
		$role = $user['role'];
		if( $user ){
			
			$state_id = isset( $_GET['state_id'] ) ? $_GET['state_id'] : 14;
			//indian states  
			//$data['country'] = $this->global_model->getdata("countries", array( "id" => 101) );
			$data['states'] = $this->global_model->getdata("states", array( "country_id" => 101) );
			$data['cities'] = $this->global_model->getdata("cities", array( "state_id" => $state_id ) ); //14 = HP
			$data['state_id'] = $state_id;
			
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('marketing/state_codes', $data);
			$this->load->view('inc/footer'); 
		}else{
			redirect(404);
		}
	}
}	

?>