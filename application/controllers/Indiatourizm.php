<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Indiatourizm extends CI_Controller {
	
	public function __Construct(){
	   	parent::__Construct();
		validate_login();
		$this->load->model("customer_model");
		$this->load->library('form_validation');
	}
	
	//Get all leads from Itinerary Genrator
	public function index(){
		$user = $this->session->userdata('logged_in');
		$u_id = $user['user_id'];
		$role = $user['role'];
		if( $role == 99 || is_leads_manager() ){
			$data["role"] = $role;
			//$data["team_leaders"] = $this->global_model->getdata("teamleaders");;
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('indiatourizm/indiatourizm_queries', $data);
			$this->load->view('inc/footer');
		}else{
			redirect("dashboard");
		}
	}
	
	
	//get all queries list
	public function ajax_queries_list(){
		//Sort Variables
		$table = "it_queries";
		$column_order = array(null, 'name','email', "mobile", "destination", "package_link", "query_from", "created_at"); 
		$column_search = array('name', "email", "mobile", "destination");
		$order = array('id' => 'DESC'); // default order 
		$where = array();
		$list = $this->global_model->get_datatables( $table, $where, $column_order, $column_search, $order );
		
		$data = array();
		$no = $_POST['start'];
		if( !empty($list) ){
			foreach ($list as $lead) {
				//assign to AGENT_ID
				$btn_as = "<span class='green'>ASSIGNED</span>  ";
				$check_box = "";
				if( !empty( $lead->agent_id ) ){
					$assign_btn = get_user_name( $lead->agent_id );
				}else{
					$check_box = "<input type='checkbox' class='multi_assign' title='select' value='{$lead->id}'>";
					$assign_btn =  "--";
					$btn_as = "<a href='#' title='View lead' data-data_id='{$lead->id}' class='btn btn-success assign_lead_agent'><i class='fa fa-refresh'></i> Assign</a>";
				}
				$id = $lead->id;
				$row_delete = "";
				$no++;
				$row = array();
				$row[] = $no . " " . $check_box;
				$row[] = $lead->name;
				$row[] = $lead->email;
				$row[] = $lead->mobile;
				$row[] = $lead->destination;
				$row[] = $lead->package_name;
				$row[] = $lead->package_link;
				$row[] = $lead->query_from;
				$row[] = !empty($lead->lang) ? ucfirst( $lead->lang ) : "";
				
				//Delete if admin
				if( empty($lead->agent_id) ){
					$row_delete = "<a href='javascript:void(0)' data-id = {$lead->id} class='btn btn-danger ajax_delete_review' title='Delete lead'><i class='fa fa-trash-o'></i></a>";
				}
				
				
				// View btn 
				$row[] = $btn_as .  $row_delete;  
				$row[] = $lead->created_at;
				$row[] = $assign_btn;  
				
				$data[] = $row;
			}
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->global_model->count_all_data($table, $where),
			"recordsFiltered" => $this->global_model->count_filtered($table, $where, $column_order, $column_search, $order ),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);		
		
	}
	
	//delete query
	public function delete_query(){
		$id = $this->input->post('id', TRUE);
		$where = array("id" => $id);
		$result = $this->global_model->delete_data("it_queries", $where);
		if( $result){
			$this->session->set_flashdata('success',"Queries delete successfully.");
			$res = array('status' => true, 'msg' => "Queries delete Successfully!");
		}else{
			$res = array('status' => false, 'msg' => "Error! please try again later");
		}
		die(json_encode($res));
	}
	
	//Get Instant call details from Itinerary Genrator
	public function instant_call(){
		$user = $this->session->userdata('logged_in');
		$u_id = $user['user_id'];
		$role = $user['role'];
		if( $role == 99 || is_leads_manager() ){
			$data["role"] = $role;
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('indiatourizm/indiatourizm_instant_call', $data);
			$this->load->view('inc/footer');
		}else{
			redirect("dashboard");
		}
	}
	
	
	//instant call section
	//get all queries list
	public function ajax_instant_call_list(){
		//Sort Variables
		$table = "it_instant_call_details";
		$column_order = array(null, "mobile", "query_from", "created_at", "followup"); 
		$column_search = array("mobile");
		$order = array('id' => 'DESC'); // default order 
		$where = array();
		$list = $this->global_model->get_datatables( $table, $where, $column_order, $column_search, $order );
		
		$data = array();
		$no = $_POST['start'];
		if( !empty($list) ){
			foreach ($list as $lead) {
				$id = $lead->id;
				$row_delete = "";
				$no++;
				$row = array();
				$row[] = $no;
				$row[] = $lead->mobile;
				$row[] = $lead->query_from;
				$row[] = $lead->created_at;
				$row[] = !empty($lead->followup) ? "<strong class='green'>DONE</strong>" : "<strong class='red'><a href='javascript:void(0)' title='Update Lead Followup to Done' class='btn btn-success update_followup' data-data_id = '{$lead->id}' ><i class='fa fa-refresh'></i> Update Status</a></strong>";
				
				if( is_admin() ){
					//Delete
					$row_delete = "<a href='javascript:void(0)' data-id = {$lead->id} class='btn btn-danger ajax_delete_review' title='Delete lead'><i class='fa fa-trash-o'></i></a>";
				}
				
				// View 
				$row[] = "-- " . $row_delete;  
				$data[] = $row;
			}
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->global_model->count_all_data($table, $where),
			"recordsFiltered" => $this->global_model->count_filtered($table, $where, $column_order, $column_search, $order ),
			"data" => $data,
		);
		
		//output to json format
		echo json_encode($output);		
	}
	
	//UPDATE instant call STATUS
	public function udpate_instant_query(){
		$id = $this->input->post('id', TRUE);
		$where = array("id" => $id);
		$result = $this->global_model->update_data("it_instant_call_details", $where, array("followup" => 1 ) );
		if( $result){
			$this->session->set_flashdata('success',"Queries updated successfully.");
			$res = array('status' => true, 'msg' => "Queries updated Successfully!");
		}else{
			$res = array('status' => false, 'msg' => "Error! please try again later");
		}
		die(json_encode($res));
	}
	
	//delete instant call
	public function delete_instant_query(){
		$id = $this->input->post('id', TRUE);
		$where = array("id" => $id);
		$result = $this->global_model->delete_data("it_instant_call_details", $where);
		if( $result){
			$this->session->set_flashdata('success',"Queries delete successfully.");
			$res = array('status' => true, 'msg' => "Queries delete Successfully!");
		}else{
			$res = array('status' => false, 'msg' => "Error! please try again later");
		}
		die(json_encode($res));
	}
	
	
	//Assign lead
	public function assign_lead_to_agent(){
		$user = $this->session->userdata('logged_in');
		$u_id = $user['user_id'];
		$role = $user['role'];
		if( ( is_admin_or_manager() || is_teamleader() ) && ( isset( $_POST['name'] ) ) ){
			$email 				= $this->input->post("email", TRUE);
			$mobile 			= $this->input->post("mobile", TRUE);
			$name 				= $this->input->post("name", TRUE);
			$agent_id 			= $this->input->post("agent_id", TRUE);
			//$assign_to 			= $this->input->post("assign_to", TRUE);
			$destination 		= $this->input->post("destination", TRUE);
			$id 				= $this->input->post("id", TRUE);
			$customer_type 		= $this->input->post("customer_type", TRUE);
			$temp_key			= getTokenKey(15);
			
			//$assigned_user = $assign_to == "teamleader" ? $leader_id : $agent_id;
			
			//if assign to team leader update it_queries
			if( isset( $_POST['assign_to'] ) && $_POST['assign_to'] == "teamleader" ){
				$leader_id 			= $this->input->post("leader_id", TRUE);
				$this->global_model->update_data("it_queries", array("id" => $id), array( "agent_id" => $leader_id, "teamleader_assined_status" => 1 ) );
				
					//send notifcation agents/pending_leads
					
					/**
					* NOTIFICATION SECTION 
					*/
					
					//Create notification new lead assign
					$title 		= "New Lead Assign";
					$c_date 	= current_datetime();
					$notif_time = date("Y-m-d H:i:s", strtotime( $c_date . " +10 minutes") );
					$body 		= "New Lead Assign To You. Click here to view.";
					$notif_link = "agents/pending_leads";
					$notification_data = array(
						"customer_id"		=> 999,
						"notification_for"	=> 96, //96 = sales team
						"title"				=> $title,
						"body"				=> $body,
						"url"				=> $notif_link,
						"notification_time"	=> $notif_time,
						"agent_id"			=> $leader_id,
					);
					
					//Insert notification
					$this->global_model->insert_data( "notifications", $notification_data );
					
					/**
					* END NOTIFICATION SECTION
					**/
				$this->session->set_flashdata('success',"Customer Assign Successfully.");
				$res = array('status' => true, 'msg' => "Customer Assign Successfully!");
			}else{
				$data = array(
					"customer_name"		=> $name,
					"customer_contact"	=> $mobile,
					"customer_email"	=> $email,
					"agent_id"			=> $agent_id,
					"assign_by"			=> $u_id,
					"customer_type"		=> $customer_type,
					"temp_key"			=> $temp_key,
					"destination"		=> $destination,
					"destination"		=> $destination,
				);
				
				$customer_id = $this->global_model->insert_data("customers_inquery", $data);
				if( $customer_id ){
					//$cus = $this->global_model->getdata("customers_inquery", array( "customer_id" =>  $customer_id ) );
					//$agent_id 	= $cus[0]->agent_id;
					//$temp_key 	= $cus[0]->temp_key;
					
					/**
					* NOTIFICATION SECTION 
					*/
					
					//Create notification new lead assign
					$title 		= "New Lead Assign";
					$c_date 	= current_datetime();
					$notif_time = date("Y-m-d H:i:s", strtotime( $c_date . " +10 minutes") );
					$body 		= "New Lead Assign To You. Click here to view.";
					//$notif_link = "customers/view/{$customer_id}/{$temp_key}";
					$notif_link = "search?id={$customer_id}";
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
					
					/**
					* END NOTIFICATION SECTION
					**/
					$this->global_model->update_data("it_queries", array("id" => $id), array("agent_id" => $agent_id, "teamleader_assined_status" => 0 ) );
					$this->session->set_flashdata('success',"Customer Assign Successfully.");
					$res = array('status' => true, 'msg' => "Customer Assign Successfully!");
				}else{
					$res = array('status' => false, 'msg' => "Email and Name is required!");
				}
			}		
			die( json_encode($res) );
		}else{
			redirect("dashboard");
		}
	}
	
	//Assign lead multiple to teamleader
	public function assign_lead_to_teamleader(){
		$user = $this->session->userdata('logged_in');
		$u_id = $user['user_id'];
		$role = $user['role'];
		if( is_admin_or_manager() && isset( $_POST['ids'] ) ){
			$id = $this->input->post("ids", TRUE);
			$leader_id 	= $this->input->post("leader_id", TRUE);
			$data = array("agent_id" => $leader_id, "teamleader_assined_status" => 1);
			
			//update data
			$this->db->where_in('id', explode(",", $id ));
			$up = $this->db->update('it_queries', $data); 
			
			if( $up ){
				//send notifcation agents/pending_leads
				/**
				* NOTIFICATION SECTION 
				*/
				//Create notification new lead assign
				$title 		= "New Lead Assign";
				$c_date 	= current_datetime();
				$notif_time = date("Y-m-d H:i:s", strtotime( $c_date . " +10 minutes") );
				$body 		= "New Lead Assign To You. Click here to view.";
				$notif_link = "agents/pending_leads";
				$notification_data = array(
					"customer_id"		=> 999,
					"notification_for"	=> 96, //96 = sales team
					"title"				=> $title,
					"body"				=> $body,
					"url"				=> $notif_link,
					"notification_time"	=> $notif_time,
					"agent_id"			=> $leader_id,
				);
				//Insert notification
				$this->global_model->insert_data( "notifications", $notification_data );
				
				/**
				* END NOTIFICATION SECTION
				**/
				$this->session->set_flashdata('success',"Customer Assign Successfully.");
				$res = array('status' => true, 'msg' => "Customer Assign Successfully!");
			}else{
				$res = array('status' => false, 'msg' => "Error: Customer Not Assign!");
			}	
			die( json_encode($res) );
		}else{
			redirect("dashboard");
		}
	}
}	
?>