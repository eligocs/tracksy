<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Agents extends CI_Controller {
	public function __Construct(){
	   	parent::__Construct();
		validate_login();
		$this->load->model('Login_model');
	}
	
	public function index(){
		$user = $this->session->userdata('logged_in');
		if( $user['role'] == '99' || is_super_manager() ){
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('users/agents');
			$this->load->view('inc/footer');
		}else if( $user['role'] == '95' ){
			$where = array( "user_type" => 94, "del_status" => 0 );
			$data["get_leads_agents"] = $this->global_model->getdata("users", $where);
			
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('users/leads_agents', $data);
			$this->load->view('inc/footer');
		}else{
			redirect("dashboard");
		}
	}
	
	/* Edit agent */ 
	public function editagent($id=""){
		$id = trim($id);
		if( !empty($id) ){
			$user = $this->session->userdata('logged_in');
			$u_id = $user['user_id'];
			if( $user['role'] == '99'){
				$data['agent'] = $this->login_model->get_user_byid($id);
				$this->load->view('inc/header');
				$this->load->view('inc/sidebar');
				$this->load->view('users/agentedit', $data);
				$this->load->view('inc/footer');
			}elseif( is_super_manager() ){
				$data['agent'] = $this->login_model->get_agents_by_id($id);
				$this->load->view('inc/header');
				$this->load->view('inc/sidebar');
				$this->load->view('users/agentedit', $data);
				$this->load->view('inc/footer');
			}elseif( $user['role'] == '95' ){
				$data['agent'] = $this->global_model->getdata("users", array("user_id" => $id, "user_type" => 94 ) );
				$this->load->view('inc/header');
				$this->load->view('inc/sidebar');
				$this->load->view('users/market_agent_edit', $data);
				$this->load->view('inc/footer');
			}else{
				redirect("dashboard");
			}
		}else{
			redirect(404);
		}
	}
	
	/* View agent */ 
	public function view($id = "" ){
		$id = trim($id);
		if( !empty($id) ){
			$user = $this->session->userdata('logged_in');
			$u_id = $user['user_id'];
			if( $user['role'] == '99'){
				$data['agent'] = $this->login_model->get_user_byid($id);
				$this->load->view('inc/header');
				$this->load->view('inc/sidebar');
				$this->load->view('users/view', $data);
				$this->load->view('inc/footer');
			}elseif( is_super_manager() ){
				$data['agent'] = $this->login_model->get_agents_by_id($id);
				$this->load->view('inc/header');
				$this->load->view('inc/sidebar');
				$this->load->view('users/view', $data);
				$this->load->view('inc/footer');
			}else if($user['role'] == '95'){
				$data['agent'] = $this->global_model->getdata("users", array("user_id" => $id, "user_type" => 94 ) );
				$this->load->view('inc/header');
				$this->load->view('inc/sidebar');
				$this->load->view('users/view', $data);
				$this->load->view('inc/footer');
			}else{
				redirect("dashboard");
			}
		}else{
			redirect("404");
		}	
	}
	/* add agent */
	public function addagent(){
		$user = $this->session->userdata('logged_in');
		if( $user['role'] == '99' || is_super_manager() ){
			$data['user_id'] = $user['user_id'];
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('users/addagent', $data);
			$this->load->view('inc/footer');
		}else if($user['role'] == '95'){
			$data['user_id'] = $user['user_id'];
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('users/add_market_agent', $data);
			$this->load->view('inc/footer');
		}else{
			redirect("dashboard");
		}	
	}
	
	/* assign user area */
	public function assign_area(){
		$user = $this->session->userdata('logged_in');
		if( $user['role'] == '99' || is_super_manager() || $user['role'] == '95'  ){
			$data['user_id'] = $user['user_id'];
			$data['sales_service_team'] = $this->login_model->get_all_sales_service_team_users();
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('users/assign_userarea', $data);
			$this->load->view('inc/footer');
		}else{
			redirect("dashboard");
		}	
	}
	
	/* Edit user area */
	public function edit_user_area($id){
		$data['sales_service_team'] = $this->login_model->get_all_sales_service_team_users();
		$user = $this->session->userdata('logged_in');
		if( $user['role'] == '99' || is_super_manager() || $user['role'] == '95' ){
			$data['user_id'] = $user['user_id'];
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$data['views'] = $this->Login_model->get_area_for_user($id);
			$this->load->view('users/edit_assigned_user_area', $data);
			$this->load->view('inc/footer');
		}else{
			redirect("dashboard");
		}	
	}
	
	//Detele assigned user
	public function ajax_deleteAssignedUser(){
		$id = $this->input->get('id', TRUE);
		$where = array("id" => $id);
		$result = $this->global_model->delete_data("assign_user_area", $where);
		if( $result){
			$res = array('status' => true, 'msg' => "Assigned Area Deteled Successfully!");
		}else{
			$res = array('status' => false, 'msg' => "Error! please try again later");
		}
		die(json_encode($res));
	}
	
	/* data table get all agents */
	public function ajax_list(){
		$user = $this->session->userdata('logged_in');
		$u_id = $user['user_id'];
		if( $user['role'] == '99'){
			$list = $this->login_model->get_datatables();
			$where_count_user_type = array();
		}elseif( is_super_manager() ){
			// 96=agent, 97 service team, 95 leads team
			$where_user_type = array(95,96,97,94,93);
			$list = $this->login_model->get_datatables( $where_user_type );
			$where_count_user_type = array(95,96,97,94);
		}else{
			
		}
		$data = array();
		$no = $_POST['start'];
		if( !empty($list) ){
			foreach ($list as $agent) {
				if( $u_id !=  $agent->user_id && $agent->is_super_admin != "1" ){
					$id = $agent->user_id;
					//Get online offline status
					$check_online_status = get_user_online_status( $agent->user_id );
					$online_offline_status = !empty( $check_online_status ) ? 
					'<i title="Online" class="fa fa-circle" style="font-size:16px;color:green"></i>' 
					: '<i title="Offline" class="fa fa-circle" style="font-size:16px;color:red"></i>';
					
					if($agent->user_type == 99){
						$agent_type = "Administrator";
					}elseif($agent->user_type == 98){
						$agent_type = get_manager_type( $agent->is_super_manager );
						
						/* if(   $agent->is_super_manager == 1 ){
							$agent_type = "Super Manager";
						}else if( $agent->is_super_manager == 2 ){
							$agent_type = "Leads Manager";
						}else{
							$agent_type = get_role_name($agent->user_type);
						} */
					}else{
						$agent_type = get_role_name($agent->user_type);
					}
					
					//Update status button
					$u_status = $agent->user_status;
					$inSliderBtn = $u_status;
					if( $u_status == "active" || $u_status == "inactive" ){
						$inSliderBtn = $u_status == "active" ? "<label class='mt-checkbox' title='Active/inactive'> <input type='checkbox' title='Active/inactive' value='active' data-id ={$id} id='inSlider' class='form-control' checked><span></span></label>" : "<label class='mt-checkbox' title='Active/inactive'> <input  title='Active/inactive'  type='checkbox' value='inactive' data-id ={$id} id='inSlider' class='form-control'> <span></span></label>";
					}
					
					$row1="";
					$no++;
					$row = array();
					$row[] = $no . "  " . $online_offline_status;
					$row[] = $agent->first_name . " " . $agent->last_name;
					$row[] = $agent->user_name;
					$row[] = $agent_type;
					$row[] = $agent->email;
					$row[] = $agent->mobile;
					$row[] = $agent->user_status;
					
					if( is_admin() ){
						$row1 = "<a title='delete' href='javascript:void(0)' data-id = {$agent->user_id} class='btn_trash ajax_delete_user'><i class='fa fa-trash-o'></i></a>";
					}
					
					$rowedit = "<a title='edit' href=" . site_url("agents/editagent/{$agent->user_id}") . " class='btn_pencil ajax_edit_user_table' ><i class='fa fa-pencil'></i></a>";
					$row[] = "<a title='view' href=" . site_url("agents/view/{$agent->user_id}") . " class='btn_eye' ><i class='fa fa-eye'></i></a>" . $rowedit . $row1;
					
					$row[] = $inSliderBtn;
					$row[] = $agent->last_login;
					$data[] = $row;
				}	
			}
		}
		
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->login_model->count_all($where_count_user_type),
			"recordsFiltered" => $this->login_model->count_filtered($where_count_user_type),
			"data" => $data,
		);
		
		//output to json format
		echo json_encode($output);
	}
	
	
	/* Update user status */
	public function ajax_user_updateStatus(){
		$id = $this->input->post('id', TRUE);
		$ustatus = $this->input->post('ustatus', TRUE);
		$where = array("user_id" => $id);
		$data = array( "user_status" => $ustatus );
		$result = $this->global_model->update_data("users", $where, $data);
		if( $result){
			$this->session->set_flashdata('success',"Status Updated successfully.");
			$res = array('status' => true, 'msg' => "Status Updated successfully!");
		}else{
			$res = array('status' => false, 'msg' => "Error! please try again later");
		}
		die(json_encode($res));
	}
	
	//Assign user area 
	public function assign_user_area(){
		$name 	= $this->input->post("user");
		$state 	= $this->input->post("state");
		$cty = $this->input->post("city");
		$city 	= !empty( $cty ) ? implode(',' , $cty) : "";
		$state 	= !empty( $state ) ? implode(',' , $state) : "";
		$place 	= $this->input->post("place");
		$category = implode(',' ,$this->input->post("category"));
		$data = array(
			"user" => $name,
			"category" => $category,
			"state" => $state,
			"city" => $city,
			"place" => $place,
		);	
		
        if ($this->db->insert("assign_user_area", $data)) {
            //$result = $this->db->insert_id();
			$result = true;
			$this->session->set_flashdata('message','User area has been Assigned !');

			redirect("agents/view_assign_area");
        } else {
            $result = false;
        }
        return $result;
	}
	
	//Update Assign user area 
	public function update_assign_user_area($id){
		$name = $this->input->post("user");
		$state = $this->input->post("state");
		$state 	= !empty( $state ) ? implode(',' , $state) : "";
		$place = $this->input->post("place");
		$city =implode(',' , $this->input->post("city"));
		$category = implode(',' ,$this->input->post("category"));
	
		
		$data = array(
			"user" => $name,
			"category" => $category,
			"state" => $state,
			"city" => $city,
			"place" => $place,
		);	
			
		
        if ($this->db->where('id' , $id )->update("assign_user_area", $data)) {
            //$result = $this->db->insert_id();
			$result = true;
			
			$this->session->set_flashdata('message','User details has been Updated !');

			redirect("agents/view_assign_area");
        } else {
            $result = false;
        }
        return $result;
	}
	//view assign user area 
    public function view_assign_area(){
		$user = $this->session->userdata('logged_in');
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '95'){
			$this->data['views'] = $this->Login_model->get_area_tables();
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('users/assigned_area' , $this->data);
			$this->load->view('inc/footer');
		}else{	
			redirect("dashboard");
		}
	}
	
	public function checkagent(){
		$check = $this->Login_model->is_unique();
		if($check){
			echo 1;
		}else{
			echo 0;
		}
	}
	
	//Update Super admin status
	public function update_super_manager_status(){
		$user = $this->session->userdata('logged_in');
		if( $user["role"] == 99 ){
			$is_super_manager 	= intval($this->input->post('is_super_manager', TRUE));
			$user_id 			= $this->input->post('user_id', TRUE);
			$data = array( "is_super_manager" => trim( $is_super_manager ) );
			$result = $this->global_model->update_data( "users", array( "user_id" => trim($user_id), "user_type" => 98 ) , $data );
			if( $result){
				$this->session->set_flashdata('success',"User Updated successfully.");
				$res = array('status' => true, 'msg' => "Status updated successfully!");
			}else{
				$res = array('status' => false, 'msg' => "Status not updated");
			}
		}else{
				$res = array('status' => false, 'msg' => "Invalid action.");
		}	
		die(json_encode($res));
	}
	
	public function check_city(){
		echo get_agents_assigned_city(264);
		die;
	}
	
	
	//Update user avatar
	public function update_user_avatar(){
		$data = $_POST['image'];
		$agentId = $_POST['user_id'];
		
		list($type, $data) = explode(';', $data);
		list(, $data)      = explode(',', $data);
		
		$data = base64_decode($data);
		$imageName = 'user_avatar'.time().'.png';
		file_put_contents('site/images/userprofile/'.$imageName, $data);
		$up_data = array("user_pic" => $imageName );
		$update_data = $this->global_model->update_data( "users", array("user_id" => $agentId), $up_data );
		if( $update_data ){
			$this->session->set_flashdata('success',"Profile Updated successfully.");
			echo 'success';
		}else{
			echo '<div class="alert alert-danger"><strong>Error: </strong>Something went wrong. Please try again later.</div>';
		} 
		die();
	}
	
	
	//add market agent
	public function ajax_market_agent(){
		$user = $this->session->userdata('logged_in');
		$user_id = $user['user_id'];
		if( $user['role'] != '95'  ){
			$res = array('status' => false, 'msg' => "Invalid user!");
			die( json_encode($res) );
		}
		
		$email 		= $this->input->post("email", TRUE);
		$user_name 	= $this->input->post("user_name", TRUE);
		$mobile_otp = $this->input->post("mobile_otp", TRUE);
		
		//Avoid special characters from username
		if( !validate_username( $user_name ) ){
			$res = array('status' => false, 'msg' => "Don't Use whitespace and special character in username.");
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
				
				//data 
				$firstname 		= strip_tags($this->input->post('first_name', true));
				$lastname 		= strip_tags($this->input->post('last_name', true));
				$email 			= strip_tags($this->input->post('email', true));
				$user_name		= strip_tags($this->input->post('user_name', true));
				$user_id		= $user_id;
				$in_time 		= strip_tags($this->input->post('in_time', true));
				$out_time		= strip_tags($this->input->post('out_time', true));
				$gender 		= strip_tags($this->input->post('gender', true));
				$mobile			= strip_tags($this->input->post('mobile', true));
				$mobile_otp		= strip_tags($this->input->post('mobile_otp', true));
				$user_type		= 94; //market agent
				$user_status	= strip_tags($this->input->post('user_status', true));
				$password		= strip_tags(md5($this->input->post('password', true)));
				$website		= base_url();
				
				$data= array(
					'first_name'=> $firstname,
					'last_name'=> $lastname,
					'user_name'=> $user_name,
					'email'=> $email,
					'gender'=> $gender,
					'password'=> $password,
					'user_status'=> $user_status,
					'user_type'=> $user_type,
					'in_time'=> $in_time,
					'out_time'=> $out_time,
					'mobile'=> $mobile,
					'added_by'=> $user_id,
					'website'=> $website,
					'mobile_otp'=> $mobile_otp,
				);
				
				$result = $this->global_model->insert_data("users", $data);
				
				if( $result ){
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
	
	//Edit market agent
	public function ajax_edit_market_agent(){
		
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
				$newpass 		= $this->input->post('newpassword');
				$firstname 		= strip_tags($this->input->post('firstname', true));
				$pass			= strip_tags(md5($newpass));
				$lastname 		= strip_tags($this->input->post('lastname', true));
				$gender 		= $this->input->post('gender', true);
				$email 			= strip_tags($this->input->post('email', true));
				$user_status 	= strip_tags($this->input->post('user_status', true));
				$mobile			= strip_tags($this->input->post('mobile', true));
				$off_in 		= strip_tags($this->input->post('in_time', true));
				$off_out		= strip_tags($this->input->post('out_time', true));
				$mobile_otp		= strip_tags($this->input->post('mobile_otp', true));
				
				$data= array(
					'first_name'	=>$firstname,
					'last_name'		=>$lastname,
					'gender'		=>$gender,
					'email'			=>$email,
					'mobile'		=>$mobile,
					'in_time'		=>$off_in,
					'out_time'		=>$off_out,
					'user_status'	=>$user_status,
					'mobile_otp'	=>$mobile_otp,
				);
				// check if password is not empty
				if( !empty($newpass) && $newpass != "" ){
					$data["password"] = $pass;
				}
		
				$result = $this->global_model->update_data("users",array("user_id" => $user_id ),$data);
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
	
	//login requests
	public function loginrequest(){
		$user = $this->session->userdata('logged_in');
		if( $user['role'] == '99' || $user['role'] == '98' ){
			$user_role = standard_login_roles();
			$this->data['req_user_data_list'] = $this->Login_model->loginrequest($user_role);
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('users/login_requests' , $this->data);
			$this->load->view('inc/footer');
		}else{
			redirect("dashboard");
		}	
	}
	
	//allow user to login by manager
	public function ajax_allow_user_to_login(){
		$id = $this->input->get('id', TRUE);
		$where = array("user_id" => $id);
		$data = array( 
			'login_request' 		=>  "0",
			'login_request_date' 	=> date('Y-m-d h:i:s'),
		);
		$result = $this->global_model->update_data("users", $where, $data);
		if( $result){
			$res = array('status' => true, 'msg' => "User allow successfully!");
		}else{
			$res = array('status' => false, 'msg' => "Error! please try again later.");
		}
		die(json_encode($res));
	}
	
	
	//TeamLeaders
	public function teamleaders(){
		$user = $this->session->userdata('logged_in');
		if( $user['role'] == '99' || $user['role'] == '98' ){
			$this->data['all_unassigned_sales_agent'] = $this->global_model->get_all_sales_not_in_team_leaders();
			$this->data['all_team_members'] = $this->global_model->getdata("teamleaders");
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('users/teamleaders/all_teamleaders' , $this->data );
			$this->load->view('inc/footer');
		}else{
			redirect("dashboard");
		}	
	}
	
	//add team leader
	public function add_teamleader(){
		$user = $this->session->userdata('logged_in');
		if( $user['role'] == '99' || $user['role'] == '98' ){
			$this->data['user_id'] = $user['user_id'];
			$this->data['all_unassigned_sales_agent'] = $this->global_model->get_all_sales_not_in_team_leaders();
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('users/teamleaders/add_teamleader' , $this->data );
			$this->load->view('inc/footer');
		}else{
			redirect("dashboard");
		}	
	}
	
	//edit assigned_mem
	public function edit_teamleader($id){
		$user = $this->session->userdata('logged_in');
		if( ($user['role'] == '99' || $user['role'] == '98') && $id ){
			$this->data['user_id'] = $user['user_id'];
			$this->data['leader_data'] = $this->global_model->getdata("teamleaders", array("id" => $id ));
			$this->data['all_unassigned_sales_agent'] = $this->global_model->get_all_sales_not_in_team_leaders();
			$this->data['assigned_mem'] = $this->global_model->get_all_in_teamleaders($id);
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('users/teamleaders/edit_teamleader' , $this->data );
			$this->load->view('inc/footer');
		}else{
			redirect("404");
		}	
	}
	
	//ajax request to check unasssgined users
	public function get_all_unassigned_teammember_list(){
		if(isset($_POST["leader_id"]) && !empty($_POST["leader_id"]) ){
			$leader_id = $_POST["leader_id"];
			$teamhtml = "";
			$unassigned_agents = $this->global_model->get_all_sales_not_in_team_leaders();
			
			//check if already assigned agent found
			if(isset( $_POST["team_id"] ) && !empty( $_POST["team_id"] )){
				$check_la = $this->global_model->get_all_in_teamleaders($_POST["team_id"]);
				foreach( $check_la as $team ){
					if( $team == $leader_id ) continue;
					$user_name = ucfirst( get_user_name($team) );
					$teamhtml .= "<option value='{$team}'>{$user_name}</option>";
				}
			}
			
			if( $unassigned_agents ){
				foreach( $unassigned_agents as $agent ){
					if( $agent->user_id == $leader_id ) continue;
					$user_name = ucfirst($agent->user_name);
					$teamhtml .= "<option value='{$agent->user_id}'>{$user_name}</option>";
				}
				
			}else{
				$teamhtml .= '<option value="">No agents found.</option>';
			}	
			
			echo $teamhtml;
			die();
		}
	}
	
	//add team leader
	public function ajax_add_teamleader(){
		$user = $this->session->userdata('logged_in');
		if( $user['role'] == '99' || $user['role'] == '98' ){
			//if post request
			$leader_id 		= $this->input->post("leader_id", TRUE);
			$assign_agents 	= $this->input->post("assign_agents", TRUE);
			$team_name 		= $this->input->post("team_name", TRUE);
			$assign_agents 	= !empty( $assign_agents ) ? implode(", ", $assign_agents) : "";
			
			$data = array(
				"team_name" 		=> $team_name,
				"leader_id" 		=> $leader_id,
				"assigned_members" 	=> $assign_agents,
				"leader_created_by"	=> $user['user_id'],
			);
			
			//check team name 
			if( $this->__check_teamname( $team_name ) ){
				$res = array("status" => false, "msg" => "Team Name Already Exists.");
				die( json_encode($res) );
			}
			
			$insert = $this->global_model->insert_data("teamleaders", $data);
			if( $insert ){
				$this->session->set_flashdata('success',"Team Leader added successfully.");
				$res = array("status" => true, "msg" => "Team Leader added successfully");
			}else{
				$this->session->set_flashdata('error',"Team Leader added not added successfully.");
				$res = array("status" => false, "msg" => "Team Leader added not added successfully");
			}
		}else{
			$res = array("status" => false, "msg" => "Invalid request");
		}
		die( json_encode($res) );
		
	}
	
	//update team leader
	public function ajax_update_teamleader(){
		$user = $this->session->userdata('logged_in');
		if( $user['role'] == '99' || $user['role'] == '98' ){
			//if post request
			$id 			= $this->input->post("id", TRUE);
			$leader_id 		= $this->input->post("leader_id", TRUE);
			$assign_agents 	= $this->input->post("assign_agents", TRUE);
			$team_name 		= $this->input->post("team_name", TRUE);
			$assign_agents 	= !empty( $assign_agents ) ? implode(",", $assign_agents) : "";
			
			$data = array(
				"team_name" 		=> $team_name,
				"leader_id" 		=> $leader_id,
				"assigned_members" 	=> $assign_agents,
				"leader_created_by"	=> $user['user_id'],
			);
			
			//check team name if exits
			$chk = $this->__check_teamname( $team_name, $id );
			if( !empty($chk) ){
				$res = array("status" => false, "msg" => "Team Name Already Exists.");
				die( json_encode($res) );
			}
			
			$update_data = $this->global_model->update_data("teamleaders", array("id" => $id) , $data);
			if( $update_data ){
				$this->session->set_flashdata('success',"Team Leader updated successfully.");
				$res = array("status" => true, "msg" => "Team Leader updated successfully");
			}else{
				$this->session->set_flashdata('error',"Team Leader not updated successfully.");
				$res = array("status" => false, "msg" => "Team Leader not updated successfully");
			}
		}else{
			$res = array("status" => false, "msg" => "Invalid request");
		}
		die( json_encode($res) );
		
	}
	
	//check if team name already registered
	private function __check_teamname($team_name, $id = NULL){
		if( $id ) 
			$where = array("id !=" => $id, "team_name" => $team_name);
		else
			$where = array("team_name" => $team_name);
			
		$check = $this->global_model->getdata("teamleaders", $where);
		if( $check ){
			return true;
		}else{
			return false;
		}
	}
	
	//delete team 
	public function delete_teamleader(){
		$id = $this->input->get('id', TRUE);
		$where = array("id" => $id);
		$result = $this->global_model->delete_data("teamleaders", $where);
		if( $result){
			$this->session->set_flashdata('success',"Team Leader deleted successfully.");
			$res = array('status' => true, 'msg' => "Assigned Area Deteled Successfully!");
		}else{
			$res = array('status' => false, 'msg' => "Error! please try again later");
		}
		die(json_encode($res));
	}
	
	//agents teammembers
	public function myteammembers(){
		$user = $this->session->userdata('logged_in');
		$user_id = $user['user_id'];
		if( $user['role'] == '96' ){
			$get_teammembers = $this->global_model->getdata("teamleaders", array( "leader_id" => $user_id ) );
			if( $get_teammembers ){
				$this->data['teammembers'] = $get_teammembers;
				$this->data['user_id'] = $user_id;
				$this->load->view('inc/header');
				$this->load->view('inc/sidebar');
				$this->load->view('users/teamleaders/agents_teammembers' , $this->data );
				$this->load->view('inc/footer');
			}else{
				redirect(404);
			}
		}else{
			redirect(404);
		}
	}
	
	//assigned leads to team leader
	public function pending_leads(){
		$user = $this->session->userdata('logged_in');
		$u_id = $user['user_id'];
		$role = $user['role'];
		$data["role"] = $role;
		if( $data["role"] == 99 || $data["role"] == 98 ){
			$data['logedin_agents'] = get_all_sales_team_loggedin_today();
			$data["pending_leads"] = $this->global_model->getdata("it_queries", array("agent_id !=" => "", "teamleader_assined_status" => 1 ) );;
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('indiatourizm/teamleader_pending_queries', $data);
			$this->load->view('inc/footer');
		}else if( is_teamleader() ){
			$data["pending_leads"] = $this->global_model->getdata("it_queries", array( "agent_id" => $u_id, "teamleader_assined_status" => 1 ) );;
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('indiatourizm/teamleader_pending_queries', $data);
			$this->load->view('inc/footer');
		}else{
			redirect("dashboard");
		}
	}
	
	//drage teammeber
	public function ajax_drag_team_memaber(){
		$user = $this->session->userdata('logged_in');
		$u_id = $user['user_id'];
		$role = $user['role'];
		$data["role"] = $role;
		if( ($data["role"] == 99 || $data["role"] == 98) && isset( $_POST['move_to_id'] ) && !empty( $_POST['m_agent_id'] ) ){
			$remove_from_id = trim($_POST['move_from_id']);
			$move_to_id 	= trim($_POST['move_to_id']);
			$m_agent_id 	= trim($_POST['m_agent_id']);
			
			//remove agent from old team
			$remove_agent_ = $this->global_model->getdata("teamleaders", array("id" => $remove_from_id), "assigned_members");
			if( $remove_agent_ && $remove_from_id ){
				$array1 = array($m_agent_id);
				$array2 = explode(',', $remove_agent_);
				$array3 = array_diff($array2, $array1);
				$output_ = implode(',', $array3);
				
				//up data
				$update_old_data = array(
					"assigned_members" => $output_ ,
					"leader_created_by" => $u_id 
				);
				
				//update row
				$this->global_model->update_data("teamleaders", array( "id" => $remove_from_id ), $update_old_data );
			}
			
			//PUSH team member to new team
			$add_agent_ = $this->global_model->getdata("teamleaders", array("id" => $move_to_id), "assigned_members");
			$array1_a = $m_agent_id;
			$array2_a = explode(',', $add_agent_);
			array_push( $array2_a, $array1_a );
			$arr_unique = array_unique( $array2_a );
			$output_a = implode(',', $arr_unique);
			
			//up data
			$update_new_data = array(
				"assigned_members" => $output_a ,
				"leader_created_by" => $u_id 
			);
			
			//update row
			$update_d = $this->global_model->update_data("teamleaders", array("id" => $move_to_id), $update_new_data );
			if( $update_d ){
				$res = array("status" => true, "msg" => "success.");
			}else{
				$res = array("status" => false, "msg" => "Error.");
			}
		}else{
			$res = array("status" => false, "msg" => "Invalid request.");
		}	
		die( json_encode($res) );
	}
	
	
	//remove agent from team
	public function ajax_remove_agent_from_team(){
		$user = $this->session->userdata('logged_in');
		$u_id = $user['user_id'];
		$role = $user['role'];
		$data["role"] = $role;
		if( ($data["role"] == 99 || $data["role"] == 98) && isset( $_POST['agent_id'] ) && !empty( $_POST['id'] ) ){
			$agent_id = trim($_POST['agent_id']);
			$id 	= trim($_POST['id']);
			//remove agent from old team
			$remove_agent_ = $this->global_model->getdata("teamleaders", array("id" => $id), "assigned_members");
			$array1 = array($agent_id);
			$array2 = explode(',', $remove_agent_);
			$array3 = array_diff($array2, $array1);
			$output_ = implode(',', $array3);
			
			//up data
			$update_old_data = array(
				"assigned_members" => $output_ ,
				"leader_created_by" => $u_id 
			);
			
			//update row
			$update_d = $this->global_model->update_data("teamleaders", array( "id" => $id ), $update_old_data );
			if( $update_d ){
				$res = array("status" => true, "msg" => "success.");
			}else{
				$res = array("status" => false, "msg" => "Error.");
			}
		}else{
			$res = array("status" => false, "msg" => "Invalid request.");
		}	
		die( json_encode($res) );
	}
	
	
	//THOUGHT OF DAY
	public function thought_of_day(){
		$user = $this->session->userdata('logged_in');
		$u_id = $user['user_id'];
		$role = $user['role'];
		$data["role"] = $role;
		if( $data["role"] == 99 || $data["role"] == 98 ){
			$data["thought_of_day"] = $this->global_model->getdata("thought_of_day");
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('users/thoughtofday/update', $data);
			$this->load->view('inc/footer');
		}else{
			redirect("dashboard");
		}
	}
	
	//update thought of day status
	function ajax_update_thoughtofday_status(){
		$user = $this->session->userdata('logged_in');
		$user_id = $user['user_id'];
		$role = $user['role'];
		if( isset( $_POST['type'] ) ){
			$id 		= $this->input->post('id', true);
			$type 		= $this->input->post('type', true);
			$doc_path 	=  dirname($_SERVER["SCRIPT_FILENAME"]) . '/site/assets/thoughts/';
			
			$check_img = $this->global_model->getdata("thought_of_day", array( 'id' => $id ), "content" );
			$exists_name = dirname($_SERVER["SCRIPT_FILENAME"]) . '/site/assets/thoughts/' . $check_img;
			//check status type 2= youtube link, 1= image, 0 = text
			if( $type == 2 ){
				$match;
				$content 	= $this->input->post('youtube_vid_link', true);
				//check for valid youtube video link
				if( !preg_match("/(youtube.com|youtu.be)\/(watch)?(\?v=)?(\S+)?/", $content, $match) ){
					echo '<div class="alert alert-danger"><strong>Error: </strong>Sorry, not a youtube URL.Please enter valid youtube link.</div>';
					die();
				}
			}else if( $type == 1 ){
				if( isset($_FILES["image_url"]["name"]) && !empty( $_FILES["image_url"]["name"] ) ){
					if(!is_dir($doc_path)){
						if (!mkdir($doc_path, 0777, true)) {
							//return false;
							echo '<div class="alert alert-danger"><strong>Error: </strong>File not uploaded. Please contact administrator.</div>';
							die;
						}
					}
					
					$n = "THOUGHT_OF_DAY";
					$file_name = $n . "_" . time(); 
					$config['upload_path'] = $doc_path;
					$config['allowed_types'] = 'jpg|jpeg|png';
					$config['max_size'] = 1024 * 2;
					$config['max_width']  = 1600;
					$config['max_height'] = 1600;
					$config['file_name'] = $file_name;
					$this->load->library('upload', $config);
					
					if( !$this->upload->do_upload('image_url') ){
						$err = $this->upload->display_errors();
						echo "<div class='alert alert-danger'>{$err}</div>";
						die();
					}else{
						$data = $this->upload->data();
						$img_fname = $data['file_name'];
						$up_data = array( "type" => $type, "updated_by" => $user_id, "content" => $img_fname );
						$where = array("id" => $id);
						if( $id ){
							$u_data = $this->global_model->update_data( "thought_of_day", $where, $up_data);
						}else{
							$u_data = $this->global_model->insert_data( "thought_of_day",$up_data);
						}	
						if( $u_data ){
							if (file_exists($exists_name)){
								@unlink($exists_name);
							}
							echo 'success';
						}else{
							echo '<div class="alert alert-danger"><strong>Error: </strong>Something went wrong. Please try again later.</div>';
						} 
					}
				}else{
					echo '<div class="alert alert-danger"><strong>Error: </strong>Something went wrong. Please try again later.</div>';
				}
				die();
			}else{
				$content 	= $this->input->post('text_status', true);
			}
			
			$up_data = array( "type" => $type, "updated_by" => $user_id, "content" => $content );
			if( $id ){
				$u_data = $this->global_model->update_data( "thought_of_day", array("id" => $id), $up_data);
			}else{
				$u_data = $this->global_model->insert_data( "thought_of_day",$up_data);
			}	
			
			if( $u_data ){
				if (file_exists($exists_name)){
					@unlink($exists_name);
				}
				echo 'success';
			}else{
				echo '<div class="alert alert-danger"><strong>Error: </strong>Something went wrong. Please try again later.</div>';
			} 
			
			die();
		}	
	}
	
	
	//enable / disable TOD
	function ajax_tod_updateStatus(){
		$id = $this->input->post('id', TRUE);
		$in_slider = $this->input->post('is_slider', TRUE);
		$where = array("id" => $id);
		$data = array( "status" => $in_slider );
		$result = $this->global_model->update_data("thought_of_day", $where, $data);
		if( $result){
			$this->session->set_flashdata('success',"Status Updated successfully.");
			$res = array('status' => true, 'msg' => "update Successfully!");
		}else{
			$res = array('status' => false, 'msg' => "Error! please try again later");
		}
		die(json_encode($res));
	}
	
}
?>