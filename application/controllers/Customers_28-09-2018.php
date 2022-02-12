<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Customers extends CI_Controller {
	public function __Construct(){
	   	parent::__Construct();
		validate_login();
		$this->load->model("customer_model");
		$this->load->library('form_validation');
	}
	
	
	public function index(){
		$user = $this->session->userdata('logged_in');
		$user_id = $user['user_id'];
		$data['user_role'] = $user['role'];
		//get filter parameters
		if( isset( $_GET["leadfrom"] ) && isset( $_GET["leadto"]   ) ){
			$data["leadfrom"] 		= $_GET["leadfrom"];
			$data["leadto"] 		= $_GET["leadto"];
		}
		if( isset( $_GET["leadStatus"]   ) ){
			$data["leadstatus"] = $_GET["leadStatus"];
		}
		//Get todays Data
		if( isset( $_GET["todayStatus"]   ) ){
			$data["todayStatus"] 	= $_GET["todayStatus"];
		}
		
		//Get Working Leads
		if( isset( $_GET["leadsType"]   ) ){
			$data["leadsType"] 	= $_GET["leadsType"];
		}
		
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '96' || $user['role'] == '95') {
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('customers/customers', $data);
			$this->load->view('inc/footer');
		}
		
		/* elseif( $user['role'] == '95' ){
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('customers/declined_customers', $data);
			$this->load->view('inc/footer'); 
		} */
		else{
			redirect("dashboard");
		}
	}
	/* add Customer */
	public function add(){
		$user = $this->session->userdata('logged_in');
		if( $user['role'] == '99' || $user['role'] == '98' ){
			$data['agent_id'] = $user['user_id'];
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('customers/addcustomer', $data);
			$this->load->view('inc/footer');
		}else{
			redirect("customers");
		}
	}
	/* save Customer */
	public function savecustomer(){
		$user = $this->session->userdata('logged_in');
		$user_id = $user["user_id"];
		if( $user['role'] == '99' || $user['role'] == '98' ){
			$data['customer_name'] 		= strip_tags($this->input->post("inp[customer_name]"));
			$data['customer_contact']	= strip_tags($this->input->post("inp[customer_contact]"));
			$data['agent_id']			= strip_tags($this->input->post("inp[agent_id]"));
			
			//form validation
			$this->form_validation->set_rules('inp[customer_name]', 'Customer Name', 'required');
			$this->form_validation->set_rules('inp[customer_contact]', 'Contact Number', 'required|numeric|min_length[8]|max_length[20]');
			$this->form_validation->set_rules('inp[customer_email]', 'Email', 'valid_email|required');
			
			if ($this->form_validation->run() == FALSE){
				$this->load->view('inc/header');
				$this->load->view('inc/sidebar');
				$this->load->view('customers/addcustomer', $data);
				$this->load->view('inc/footer');
			}else{
				if (isset($_POST['inp']['customer_name']) && !empty($_POST['inp']['customer_name'])) {
					$inp = $this->input->post('inp', TRUE);
					//strip tags from input
					foreach( $inp as $key=>$val ){
						$inp[$key] = strip_tags($val); 
					}
					
					//add assign_by
					$inp["assign_by"] = $user_id;
					
					$customer_id = $this->customer_model->insert_customer("customers_inquery", $inp);
					
					//Save Customer as marketing user if customer_type == 1
					$customer_type = $_POST['inp']['customer_type'];
					if( $customer_type == 1 ){
						$cName 		= strip_tags($this->input->post("inp[customer_name]"));
						$cContact 	= strip_tags($this->input->post("inp[customer_contact]"));
						$cEmail 	= strip_tags($this->input->post("inp[customer_email]"));
						$m_data = array(
							"name"				=> $cName,
							"email_id"			=> $cEmail,
							"contact_number"	=> $cContact,
						);
						//Insert data
						$this->global_model->insert_data("marketing", $m_data);
					}
					
					if( $customer_id ){
						$cus = $this->global_model->getdata("customers_inquery", array( "customer_id" =>  $customer_id ) );
						$agent_id 	= $cus[0]->agent_id;
						$temp_key 	= $cus[0]->temp_key;
						
						//$temp_key = get_customer_temp_key( $customer_id );
						
						/**
						* NOTIFICATION SECTION 
						*/
						
						//Delete last notification for customer if/any
						//$where_notif = array( "notification_type" => 1, "customer_id" => $customer_id );
						//$this->global_model->delete_data("notifications", $where_notif);
						
						//Create notification if next call time exists
						
						$title 		= "New Lead Assign";
						$c_date 	= current_datetime();
						$notif_time = date("Y-m-d H:i:s", strtotime( $c_date . " +10 minutes") );
						$body 		= "New Lead Assign To You. Click here to view. Lead ID: {$customer_id}";
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
						
						
						$this->session->set_flashdata('success',"Customer added successfully.");
						redirect("customers/view/{$customer_id}/{$temp_key}");
					}else{
						$this->session->set_flashdata('error',"Customer not added successfully.");
						redirect("customers/add");
					}
				}else{
					redirect("customers/add");
				}
			}
		}	
	}
	
	/* Edit Customer */
	public function edit($request_id = '' ){
		$user = $this->session->userdata('logged_in');
		$user_id = $user['user_id'];
		if( $user['role'] == '99' || $user['role'] == '98' ){
			$where = array("customer_id" => $request_id);
			$data['customers'] = $this->customer_model->getdata( "customers_inquery", $where );
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('customers/editcustomer', $data);
			$this->load->view('inc/footer');
		}
		/* elseif( $user['role'] == '96' ){
			$where = array("customer_id" => $request_id ,"agent_id" => $user_id);
			$data['customers'] = $this->customer_model->getdata( "customers_inquery", $where );
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('customers/editcustomer', $data);
			$this->load->view('inc/footer'); 
		} */
		else{	
			redirect("customers/add");
		}
	}
	
	/*edit and save customer*/
	public function editcustomer(){
		$user = $this->session->userdata('logged_in');
		$id = $this->input->post("customer_id");
		$user_id = $user['user_id'];
		if( $user['role'] == '99' || $user['role'] == '98'  ){
			$where = array("customer_id" => $id);
			$data['customers'] = $this->customer_model->getdata( "customers_inquery", $where );
			if (isset($_POST['inp']['customer_name']) && !empty($_POST['inp']['customer_name'])) {
				$id = $this->input->post("customer_id");
				$tmp_key = $this->input->post("temp_key");
				$inp = $this->input->post('inp', TRUE);
				//strip tags from input
				foreach( $inp as $key=>$val ){
					$inp[$key] = strip_tags($val); 
				}
				$customer_id = $this->customer_model->update_customer($id ,"customers_inquery", $inp);
				if( $customer_id ){
					$this->session->set_flashdata('success',"Customer edit successfully.");
					//redirect("customers/view/{$id}/{$tmp_key}");
					redirect("search?id={$id}");
				}else{
					$this->session->set_flashdata('error',"Customer not edit successfully.");
					redirect("customers/edit");
				}
			}else{
				redirect("customers/edit");
			}
		}else{
			redirect(404);
		}
		
	}
	
	/*View Customer*/
	public function view(){
		$customer_id = $this->uri->segment(3);
		$temp_key = $this->uri->segment(4);
		$user = $this->session->userdata('logged_in');
		$user_id = $user['user_id'];
		$data["user_id"] = $user['user_id'];
		$data["role"] 	= $user['role'];
		//get Customer followup data
		$where = array( "customer_id" => $customer_id);
		$followUpData = $this->global_model->getdata("customer_followup", $where, "", "id");
		$data['followUpData'] = $followUpData;
		
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '95'){
			$where = array("customer_id" => $customer_id , "temp_key" => $temp_key, 'del_status' => 0);
			$data['customer'] = $this->customer_model->getdata( "customers_inquery", $where );
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('customers/view', $data);
			$this->load->view('inc/footer');
		}elseif($user['role'] == '96'){
			$where = array("customer_id" => $customer_id , "temp_key" => $temp_key, "agent_id" => $user_id, 'del_status' => 0);
			$data['customer'] = $this->customer_model->getdata( "customers_inquery", $where );
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('customers/view', $data);
			$this->load->view('inc/footer');
		}else{
			redirect("dashboard");
		}	
	}
	
	//Declined Leads
	public function declinedleads(){
		$user = $this->session->userdata('logged_in');
		$user_id = $user['user_id'];
		$data['user_role'] = $user['role'];
		if($user['role'] == '95'){ 
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('customers/declined_customers', $data);
			$this->load->view('inc/footer'); 
		}else{
			redirect("dashboard");
		}
	}	
	
	//Declined Leads View
	public function declineView(){
		$user = $this->session->userdata('logged_in');
		$user_id = $user['user_id'];
		$data["user_id"] = $user['user_id'];
		$data["role"] 	= $user['role'];	
		if($user['role'] == '95'){ 
			$customer_id = $this->uri->segment(3);
			$temp_key = $this->uri->segment(4);
			//get Customer followup data
			$whered = array( "customer_id" => $customer_id);
			$followUpData = $this->global_model->getdata("customer_followup", $whered, "", "id");
			$data['followUpData'] = $followUpData;
		
			$where = array("customer_id" => $customer_id , "temp_key" => $temp_key, "cus_status" => 8, 'del_status' => 0);
			$data['customer'] = $this->customer_model->getdata( "customers_inquery", $where );
			//get approved leads data if exists
			$wh = array( "parent_customer_id" => $customer_id);
			$data['approved_cus'] = $this->customer_model->getdata( "customers_inquery", $wh );
			
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('customers/declined_view', $data);
			$this->load->view('inc/footer');
		}else{
			redirect("dashboard");
		}	
	}		
	
	//Working Leads
	public function workingleads(){
		$user = $this->session->userdata('logged_in');
		$user_id = $user['user_id'];
		$data['user_role'] = $user['role'];
		if($user['role'] == '95'){ 
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('customers/working_leads', $data);
			$this->load->view('inc/footer'); 
		}else{
			redirect("dashboard");
		}
	}	
	
	//Close Leads
	public function closeleads(){
		$user = $this->session->userdata('logged_in');
		$user_id = $user['user_id'];
		$data['user_role'] = $user['role'];
		if($user['role'] == '95'){ 
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('customers/close_leads', $data);
			$this->load->view('inc/footer'); 
		}else{
			redirect("dashboard");
		}
	}	
	
	/* data table get all Customers */
	public function ajax_customers_list(){
		
		$user = $this->session->userdata('logged_in');
		$u_id = $user['user_id'];
		$role = $user['role'];
		if( $role == '99' || $role == '98' || $role == '95' ){
			$where = array("customers_inquery.del_status" => 0);
			//get customers by agent
			if( isset( $_POST['agent_id'] ) && !empty( $_POST['agent_id'] ) ){
				$where["customers_inquery.agent_id"] = $_POST['agent_id'];
			}
		}elseif( $role == '96' ){
			$where = array("customers_inquery.agent_id" => $u_id, "customers_inquery.del_status" => 0);
		} 
		$list = $this->customer_model->get_datatables($where);
		$data = array();
		$no = $_POST['start'];
		if( !empty($list) ){
			foreach ($list as $customer) {
				$cust_id = $customer->customer_id;
				$row_delete = "";
				$row_edit = "";
				$add_iti = "";
				$reassign = "";
				$reopen_s = "";
				
				//Lead Prospect Hot/Warm/Cold
				$cus_pro_status = get_cus_prospect($customer->customer_id);
				if( $cus_pro_status == "Warm" ){
					$l_class = "green";
				}else if( $cus_pro_status == "Hot" ){
					$l_class = "black";
				}else if( $cus_pro_status == "Cold" ){
					$l_class = "red";
				}else{
					$l_class = "";
				}
				
				$no++;
				$row = array();
				$row[] = $no;
				$row[] = $customer->customer_id;
				
				if( is_admin_or_manager() ){
					$row[] = get_customer_type_name($customer->customer_type);
				}
				$row[] = $customer->customer_name;
				$row[] = $customer->customer_email;
				$row[] = $customer->customer_contact;
				$row[] = "<strong class='{$l_class}'>" . $cus_pro_status . "</strong>";
				$row[] = $customer->created;
				if( is_admin_or_manager() )
				$row[] = get_user_name($customer->agent_id);
				
				if( is_admin() ){
					//Delete
					$row_delete = "<a href='javascript:void(0)' data-id = {$customer->customer_id} class='btn btn-danger ajax_delete_customer' title='Delete Customer'><i class='fa fa-trash-o'></i></a>";
				}
				
				if( is_admin_or_manager() ){
					//edit
					$row_edit = "<a href=" . site_url("customers/edit/{$customer->customer_id}") . " class='btn btn-success ajax_edit_customer_table' title='Edit Customer'><i class='fa fa-pencil'></i></a>";
					
					//reassign option if no-followUp
					if( empty( $customer->cus_status ) &&  empty($customer->cus_last_followup_status) ){
						$reassign ="<a class='btn btn-success' href=" . site_url("customers/edit/{$customer->customer_id}/{$customer->temp_key}") . " title='Reassign'><i class='fa fa-refresh' aria-hidden='true'></i> Reassign Lead</a>";
					}
					
					if( $customer->cus_status == 8 ){
						//reopen if lead is declined
						$reopen_s ="<a class='btn btn-danger' href=" . site_url("customers/view/{$customer->customer_id}/{$customer->temp_key}?action=reopen") . " title='Reopen'><i class='fa fa-refresh' aria-hidden='true'></i> Reopen Lead</a>";
					}	
				}
				
				//Check customer status 9=approved,8=decline,0=working
				switch( $customer->cus_status ){
					case 9:
						//if quotation type holidays
						//if( $customer->quotation_type == "holidays" ){
							//check if itinerary created against current leadStatus
						/*	$where3 = array( "customer_id" => $cust_id , "iti_type" => 1 );
							$get_iti = $this->global_model->getdata( "itinerary", $where3 );
							if( !empty( $get_iti ) ){
								$iti_id = $get_iti[0]->iti_id;
								$temp_key = $get_iti[0]->temp_key;
								$pub_status = $get_iti[0]->publish_status;
								
								if( $pub_status == "draft" ){
									$add_iti = "<a href=" . site_url("itineraries/edit/{$iti_id}/{$temp_key}") . " class='btn btn-blue' title='Draft Itinerary'><i class='fa fa-pencil'></i> Edit Itinerary</a>";
								}else{
									$add_iti = "<a href=" . site_url("itineraries/view/{$iti_id}/{$temp_key}") . " class='btn btn-blue' title='View Itinerary'><i class='fa fa-plus'></i> View Itinerary</a>";
								}
								
							}else{						
								$add_iti = "<a href=" . site_url("itineraries/add/{$customer->customer_id}/{$customer->temp_key}") . " class='btn btn-green ajax_additi_table' data-id='{$customer->customer_id}' data-temp_key ='{$customer->temp_key}' title='Add Itinerary'><i class='fa fa-plus'></i> Ready for quotation</a>";
							}	
						//}elseif( $customer->quotation_type == "accommodation" ){
							//if quotation type holidays
							//check if Accommodation created against current leadStatus
							$where4 = array( "customer_id" => $cust_id , "iti_type" => 2);
							$get_acc = $this->global_model->getdata( "itinerary", $where4 );
							if( !empty( $get_acc ) ){
								$iti_id = $get_acc[0]->iti_id;
								$temp_key = $get_acc[0]->temp_key;
								$pub_status = $get_acc[0]->publish_status;
								if( $pub_status == "draft" ){
									$add_acc = "<a href=" . site_url("itineraries/edit/{$iti_id}/{$temp_key}") . " class='btn btn-blue' title='Draft Accommodation'><i class='fa fa-pencil'></i> Edit Acc.</a>";
								}else{
									$add_acc = "<a href=" . site_url("itineraries/view/{$iti_id}/{$temp_key}") . " class='btn btn-blue' title='View Accommodation'><i class='fa fa-plus'></i> View Acc.</a>";
								}
							}else{	
								$add_acc = "<a href=" . site_url("itineraries/add_accommodation/{$customer->customer_id}/{$customer->temp_key}") . " class='btn btn-green' data-id='{$customer->customer_id}' data-temp_key ='{$customer->temp_key}' title='Add Accommodation Package'><i class='fa fa-plus'></i> Acc. Quotation</a>";
							}	
						//}else{
						//	$add_iti = "<a href=" . site_url("cab/add/{$customer->customer_id}/{$customer->temp_key}") . " class='btn btn-green ' data-id='{$customer->customer_id}' data-temp_key ='{$customer->temp_key}' title='Add Cab Quotation'><i class='fa fa-plus'></i> Ready for Cab quotation</a>";
					//	} */
						$decUserStatus = "<strong class='btn btn-success'>Lead Approved</strong>";
						$add_iti = "<strong class='btn btn-success greenbtn'>Lead Verified</strong>";
						break;
					case 8:
						$add_iti = "<strong class='btn btn-danger red'>Lead Declined</strong>";
						
						$decUserStatus = "<strong class='btn btn-danger'>Lead Declined</strong>";
						break;
					default:
						
						$add_iti = "<strong class='btn btn-success'>Working...</strong>";
						$decUserStatus = "<strong class='btn btn-success'>Working...</strong>";
						break;
				}
				
				if( $role == '95' ){
					$row[] = "<a href=" . site_url("search?id=").$customer->customer_id . " title='View Customer' class='btn btn-success' ><i class='fa fa-eye'></i></a>" . $decUserStatus;
				}else{
					// View 
					$row[] = "<a href=" . site_url("search?id=") . $customer->customer_id . " title='View Customer' class='btn btn-success' ><i class='fa fa-eye'></i></a>". $row_edit . $row_delete . $add_iti . $reassign . $reopen_s; 
				}

					
				$data[] = $row;
			}
		}	
		
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->customer_model->count_all($where),
			"recordsFiltered" => $this->customer_model->count_filtered($where),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}
	
	
	//Booked  Leads
	public function bookedleads(){
		$user = $this->session->userdata('logged_in');
		$user_id = $user['user_id'];
		$data['user_role'] = $user['role'];
		if($user['role'] == '95'){ 
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$data['leads'] = $this->customer_model->booked_leads();
			$this->load->view('customers/booked_leads', $data);
			$this->load->view('inc/footer'); 
		}else{
			redirect("dashboard");
		}
	}
	
	/* data table get Declined Customers */
	public function ajax_declined_customers_list(){
		$user = $this->session->userdata('logged_in');
		$u_id = $user['user_id'];
		$role = $user['role'];
		if( $role == '99' || $role == '98' || $role == '95'){
			$where 	= array("del_status" => 0, "cus_status" => 8 );
			$list 	= $this->customer_model->get_datatables($where);
		}
		$data = array();
		$no = $_POST['start'];
		if( !empty($list) ){
			foreach ($list as $customer) {
				$cust_id = $customer->customer_id;
				$row_delete = "";
				$row_edit = "";
				$row1="";
				$no++;
				$row = array();
				$row[] = $no;
				$row[] = $customer->customer_id;
				$row[] = $customer->customer_name;
				$row[] = $customer->customer_email;
				$row[] = $customer->customer_contact;
				$row[] = get_user_name( $customer->agent_id );
				$row[] = $customer->created;
				
				//reopend satatus
				if( $customer->reopen_status == 9 ){
					$reopen_s = "<strong class='btn btn-green'>Approved</strong>";
				}elseif( $customer->reopen_status == 8 ){
					$reopen_s = "<strong class='btn btn-danger'>Lead Declined</strong>";
				}elseif($customer->reopen_status == 7 ){
					$reopen_s = "<strong class='btn btn-success'>Working</strong>";
				}else{
					$reopen_s = '<a class="btn btn-success" href="#" data-customer_id="'. $customer->customer_id .'" data-temp_key = "'. $customer->temp_key .'" id="reopenLead" title="Reopen"><i class="fa fa-refresh" aria-hidden="true"></i> Reopen Lead</a> 
					<div id="rr"></div> ';
				}
				// View 
				$row[] = "<a href=" . site_url("customers/declineView/{$customer->customer_id}/{$customer->temp_key}") . " title='View Customer' class='btn btn-success' ><i class='fa fa-eye'></i></a>". $reopen_s;
				$data[] = $row;
			}
		}	
		
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->customer_model->count_all($where),
			"recordsFiltered" => $this->customer_model->count_filtered($where),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}
	
	/* data table get Working Leads */
	public function ajax_working_customers_list(){
		$user = $this->session->userdata('logged_in');
		$u_id = $user['user_id'];
		$role = $user['role'];
		if( $role == '99' || $role == '98' || $role == '95'){
			$where 	= array("del_status" => 0, "cus_status" => 0 );
			$list 	= $this->customer_model->get_datatables($where);
		}
		$data = array();
		$no = $_POST['start'];
		if( !empty($list) ){
			foreach ($list as $customer) {
				$cust_id = $customer->customer_id;
				$row_delete = "";
				$row_edit = "";
				$row1="";
				$no++;
				$row = array();
				$row[] = $no;
				$row[] = $customer->customer_id;
				$row[] = $customer->customer_name;
				$row[] = $customer->customer_email;
				$row[] = $customer->customer_contact;
				$row[] = get_user_name( $customer->agent_id );
				$row[] = $customer->created;
				
				// View 
				$row[] = "<a href=" . site_url("customers/view/{$customer->customer_id}/{$customer->temp_key}") . " title='View Customer' class='btn btn-success' ><i class='fa fa-eye'></i></a>";
				$data[] = $row;
			}
		}	
		
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->customer_model->count_all($where),
			"recordsFiltered" => $this->customer_model->count_filtered($where),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}
	
	/* data table get Close Leads */
	public function ajax_close_customers_list(){
		$user = $this->session->userdata('logged_in');
		$u_id = $user['user_id'];
		$role = $user['role'];
		if( $role == '99' || $role == '98' || $role == '95'){
			$where 	= array("del_status" => 0, "lead_close_status" => 1 );
			$list 	= $this->customer_model->get_datatables($where);
		}
		$data = array();
		$no = $_POST['start'];
		if( !empty($list) ){
			foreach ($list as $customer) {
				$cust_id = $customer->customer_id;
				$row_delete = "";
				$row_edit = "";
				$row1="";
				$no++;
				$row = array();
				$row[] = $no;
				$row[] = $customer->customer_id;
				$row[] = $customer->customer_name;
				$row[] = $customer->customer_email;
				$row[] = $customer->customer_contact;
				$row[] = get_user_name( $customer->agent_id );
				$row[] = $customer->created;
				
				// View 
				$row[] = "<a href=" . site_url("customers/view/{$customer->customer_id}/{$customer->temp_key}") . " title='View Customer' class='btn btn-success' ><i class='fa fa-eye'></i></a>";
				$data[] = $row;
			}
		}	
		
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->customer_model->count_all($where),
			"recordsFiltered" => $this->customer_model->count_filtered($where),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}
	
	//ajax request to update Customer followup
	public function updateCustomerFollowup(){
		$user = $this->session->userdata('logged_in');
		$u_id = $user['user_id'];
		$role = $user['role'];
		$customer_id			= strip_tags($this->input->post("customer_id", TRUE));
		//$agent_id				= strip_tags($this->input->post("agent_id", TRUE));
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
		
		//get customer data
		$get_d = $this->global_model->getdata("customers_inquery", array( "customer_id" => $customer_id ) );
		$temp_key = !empty($get_d) ? $get_d[0]->temp_key : "";
		$agent_id = !empty($get_d) ? $get_d[0]->agent_id : "";
		
		$currentDate = current_datetime();
		
		if( !empty($customer_id) && !empty($callType)){
			if( $callType == "Picked call" ){
				
				$where_iti = array( "customer_id" => $customer_id );
				$u_data = array( "cus_last_followup_status" => "Picked call" , "lead_last_followup_date" => $currentDate);
				$update_status = $this->global_model->update_data( "customers_inquery", $where_iti, $u_data );
					
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
					$update_status = $this->global_model->update_data( "customers_inquery", $where_iti, $u_data );
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
				$update_status = $this->global_model->update_data( "customers_inquery", $where_iti, $u_data );
			}
			
			//Update data if lead approved
			if( $book_query == "9" ){
				//Get customer info
				$customer_id 			= trim($this->input->post("customer_id"));
				$quotation_type			= trim($this->input->post("quotation_type"));
				$whatsapp_number 		= strip_tags($this->input->post("whatsapp_number"));
				$adults 				= strip_tags($this->input->post("adults"));
				$child 					= strip_tags($this->input->post("child"));
				$child_age 				= strip_tags($this->input->post("child_age"));
				$package_type 			= strip_tags($this->input->post("package_type"));
				$package_type_other		= strip_tags($this->input->post("package_type_other"));
				$package_car_type_other = strip_tags($this->input->post("package_by_other"));
				$total_rooms 			= strip_tags($this->input->post("total_rooms"));
				$travel_date 			= strip_tags($this->input->post("travel_date"));
				$destination 			= strip_tags($this->input->post("destination"));
				$pickup_point 			= strip_tags($this->input->post("pick_point"));
				$droping_point 			= strip_tags($this->input->post("drop_point"));
				$package_car_type 		= strip_tags($this->input->post("package_by"));
				$meal_plan 				= strip_tags($this->input->post("meal_plan"));
				$honeymoon_kit 			= strip_tags($this->input->post("honeymoon_kit"));
				$car_type_sightseen 	= strip_tags($this->input->post("car_type_sightseen"));
				$hotel_category 		= strip_tags($this->input->post("hotel_type"));
				$budget 				= strip_tags($this->input->post("budget"));
				
				
				//update Data
				$u_data = array(
					"quotation_type" 		=> $quotation_type,
					"whatsapp_number" 		=> $whatsapp_number,
					"adults" 				=> $adults,
					"child" 				=> $child,
					"child_age"				=> $child_age,
					"package_type" 			=> $package_type,
					"package_type_other" 	=> $package_type_other,
					"package_car_type_other" => $package_car_type_other,
					"travel_date" 			=> $travel_date,
					"total_rooms" 			=> $total_rooms,
					"destination" 			=> $destination,
					"pickup_point" 			=> $pickup_point,
					"droping_point" 		=> $droping_point,
					"package_car_type" 		=> $package_car_type,
					"meal_plan" 			=> $meal_plan,
					"honeymoon_kit" 		=> $honeymoon_kit,
					"car_type_sightseen" 	=> $car_type_sightseen,
					"hotel_category" 		=> $hotel_category,
					"budget" 				=> $budget,
					"cus_status" 			=> 9,
					"lead_last_followup_date" 	=> $currentDate,
					
				);
				$where_c = array( "customer_id" => $customer_id );
				$update_data = $this->global_model->update_data("customers_inquery", $where_c, $u_data );
				$callType = "9";
				$approved = $quotation_type;
				
				
				
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
				'temp_key'			=> $temp_key,
			);
			
			
			/**
			* NOTIFICATION SECTION 
			*/
			
			//Delete last notification for customer if/any
			$where_notif = array( "notification_type" => 1, "customer_id" => $customer_id );
			$this->global_model->delete_data("notifications", $where_notif);
			
			//Create notification if next call time exists
			if( !empty( $nxt_call ) && $callType != "8" && $book_query != 9 && $callSummaryNotpicked != "Number does not exists" ){
				$title 		= "Lead Followp";
				$notif_time = date("Y-m-d H:i:s", strtotime( $nxt_call ));
				$body 		= "Next call time {$nxt_call}";
				$notif_link = "customers/view/{$customer_id}/{$temp_key}";
				$notification_data = array(
					"customer_id"		=> $customer_id,
					"notification_for"	=> 96, //96 = sales team
					"notification_type"	=> 1, //1=lead followUp
					"title"				=> $title,
					"body"				=> $body,
					"url"				=> $notif_link,
					"notification_time"	=> $notif_time,
					"agent_id"			=> $u_id,
				);
				//Insert notification
				$this->global_model->insert_data( "notifications", $notification_data );
			}
			
			/**
			* END NOTIFICATION SECTION
			**/
			
			//Update customer followUp last data
			$upf_data = array( "call_status" => 1 );
			$this->global_model->update_data("customer_followup", array( "customer_id" => $customer_id ), $upf_data );
			
			$insert_id = $this->global_model->insert_data( "customer_followup", $data );
			if( $insert_id ){
				$res = array('status' => true, 'msg' => "Call log detail update successfully!", "approved" => $approved, "customer_id" => $customer_id, "temp_key" => $temp_key);
			}else{
				$res = array('status' => false, 'msg' => "Call log detail not update successfully!");
			}	
		}else{
			$res = array('status' => false, 'msg' => "Invalid request please try again later!");
		}
		die( json_encode($res) );
	}
	
	//Reopen Lead
	function ajax_reopenLead(){
		$customer_id 	= $this->input->post("customer_id");
		$temp_key 		= $this->input->post("temp_key");
		$user = $this->session->userdata('logged_in');
		$u_id = $user['user_id'];
		
		if( !empty( $customer_id ) && !empty( $temp_key ) ){
			$where = array("customer_id" => $customer_id, "temp_key" => $temp_key );
			$inp = array( "reopen_status" => 7, "reopen_by" => $u_id, "cus_last_followup_status" => "" );
			$update_data = $this->global_model->update_data("customers_inquery", $where, $inp );
			if( $update_data){
				$res = array('status' => true, 'msg' => "Lead Reopen Successfully" );
			}else{
				$res = array('status' => false, 'msg' => "Error! Lead not Reopen.Please try again later");
			}
			die( json_encode($res) );
		}else{
			$res = array('status' => false, 'msg' => "Invalid Request.");
			die( json_encode($res) );
		}
	}
	
	//Reopen Lead Manager
	function ajax_reopenLead_manager(){
		$customer_id 	= $this->input->post("customer_id");
		$reassign_agent_id 	= $this->input->post("reassign_agent_id");
		$user = $this->session->userdata('logged_in');
		$u_id = $user['user_id'];
		if( !empty( $customer_id ) ){
			$where = array("customer_id" => $customer_id );
			$inp = array( "cus_status" => 0, "assign_by" => $u_id, "agent_id" => $reassign_agent_id );
			$update_data = $this->global_model->update_data("customers_inquery", $where, $inp );
			if( $update_data){
				/**
				* NOTIFICATION SECTION 
				*/
				//Delete last notification for customer if/any
				$where_notif = array( "notification_type" => 1, "customer_id" => $customer_id );
				$this->global_model->delete_data("notifications", $where_notif);
				//Create notification if next call time exists
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
					"agent_id"			=> $reassign_agent_id,
				);
				//Insert notification
				$this->global_model->insert_data( "notifications", $notification_data );
				/**
				* END NOTIFICATION SECTION
				**/
						
				
				
				$a_name = get_user_name($reassign_agent_id);
				$this->session->set_flashdata('success',"Lead Successfully Assign to {$a_name}");
				$res = array('status' => true, 'msg' => "Lead Reopen Successfully" );
			}else{
				$res = array('status' => false, 'msg' => "Error! Lead not Reopen.Please try again later");
			}
			die( json_encode($res) );
		}else{
			$res = array('status' => false, 'msg' => "Invalid Request.");
			die( json_encode($res) );
		}
	}
	
	//ajax request to update Customer followup of declined leads
	public function updateCustomerFollowupDeclinedLeads(){
		$user = $this->session->userdata('logged_in');
		$u_id = $user['user_id'];
		$role = $user['role'];
		$customer_id			= strip_tags($this->input->post("customer_id", TRUE));
		$agent_id				= strip_tags($this->input->post("agent_id", TRUE));
		$temp_key				= strip_tags($this->input->post("temp_key", TRUE));
		$callType 				= strip_tags($this->input->post("callType", TRUE));
		$callSummary 			= strip_tags($this->input->post("callSummary", TRUE));
		$callSummaryNotpicked 	= strip_tags($this->input->post("callSummaryNotpicked", TRUE));
		$nextCallTime 			= strip_tags($this->input->post("nextCallTime", TRUE));
		$nextCallTimeNotpicked 	= strip_tags($this->input->post("nextCallTimeNotpicked", TRUE));
		$txtProspect 			= strip_tags($this->input->post("txtProspect", TRUE));
		$txtProspectNotpicked 	= strip_tags($this->input->post("txtProspectNotpicked", TRUE));
		$final_amount 			= strip_tags($this->input->post("final_amount", TRUE));
		$book_query 			= strip_tags($this->input->post("book_query", TRUE));
		
		$currentDate = current_datetime();
		
		if( !empty($customer_id) && !empty($callType)){
			if( $callType == "Picked call" ){
				
				$where_iti = array( "customer_id" => $customer_id );
				$u_data = array( "cus_last_followup_status" => "Picked call", "lead_last_followup_date" => $currentDate );
				$update_status = $this->global_model->update_data( "customers_inquery", $where_iti, $u_data );
					
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
					$u_data = array( "cus_last_followup_status" => "Call not picked", "lead_last_followup_date" => $currentDate );
					$update_status = $this->global_model->update_data( "customers_inquery", $where_iti, $u_data );
				}	
			}
			
			//update Lead status on decline
			if( $callType == "8" ){
				$where_iti = array( "customer_id" => $customer_id );
				//if reopen lead decline by customer
				$u_data = array( 
					"decline_reason"				=> $this->input->post('decline_reason'), 
					"decline_comment"				=> $this->input->post('decline_comment', TRUE), 
					"reopen_status" 				=> 8, 
					"cus_status" 					=> 8, 
					"lead_last_followup_date" 		=> $currentDate,
					"cus_last_followup_status" 		=> 8 
				);
				$update_status = $this->global_model->update_data( "customers_inquery", $where_iti, $u_data );
			}
			//Update data if lead approved
			if( $book_query == "9" ){
				//update old lead status
				$w_old = array( "customer_id" => $customer_id );
				$w_data = array( "reopen_status" => 9 );
				$update_old_lead = $this->global_model->update_data("customers_inquery", $w_old, $w_data );
				
				//Get customer info
				$customer_id 			= trim($this->input->post("customer_id"));
				$whatsapp_number 		= strip_tags($this->input->post("whatsapp_number"));
				$adults 				= strip_tags($this->input->post("adults"));
				$child 					= strip_tags($this->input->post("child"));
				$child_age 				= strip_tags($this->input->post("child_age"));
				$package_type 			= strip_tags($this->input->post("package_type"));
				$total_rooms 			= strip_tags($this->input->post("total_rooms"));
				$travel_date 			= strip_tags($this->input->post("travel_date"));
				$destination 			= strip_tags($this->input->post("destination"));
				$pickup_point 			= strip_tags($this->input->post("pick_point"));
				$droping_point 			= strip_tags($this->input->post("drop_point"));
				$package_car_type 		= strip_tags($this->input->post("package_by"));
				$meal_plan 				= strip_tags($this->input->post("meal_plan"));
				$honeymoon_kit 			= strip_tags($this->input->post("honeymoon_kit"));
				$car_type_sightseen 	= strip_tags($this->input->post("car_type_sightseen"));
				$hotel_category 		= strip_tags($this->input->post("hotel_type"));
				$budget 				= strip_tags($this->input->post("budget"));
				$assign_to 				= strip_tags($this->input->post("assign_to"));
				$package_type_other		= strip_tags($this->input->post("package_type_other"));
				$package_car_type_other = strip_tags($this->input->post("package_by_other"));
				
				//duplicate leads and update data
				$insert_id = $this->customer_model->duplicate_lead("customers_inquery", "customer_id", $customer_id);
				
				//update Data
				$u_data = array(
					"whatsapp_number" 			=> $whatsapp_number,
					"adults" 					=> $adults,
					"child" 					=> $child,
					"child_age"					=> $child_age,
					"package_type" 				=> $package_type,
					"travel_date" 				=> $travel_date,
					"total_rooms" 				=> $total_rooms,
					"destination" 				=> $destination,
					"package_type_other" 		=> $package_type_other,
					"package_car_type_other"	=> $package_car_type_other,
					"pickup_point" 			=> $pickup_point,
					"droping_point" 		=> $droping_point,
					"package_car_type" 		=> $package_car_type,
					"meal_plan" 			=> $meal_plan,
					"honeymoon_kit" 		=> $honeymoon_kit,
					"car_type_sightseen" 	=> $car_type_sightseen,
					"hotel_category" 		=> $hotel_category,
					"budget" 				=> $budget,
					'agent_id'				=> $assign_to,
					"cus_status" 			=> 9,
					"lead_last_followup_date" => $currentDate,
				);
				
				$where_c = array( "customer_id" => $insert_id );
				$update_data = $this->global_model->update_data("customers_inquery", $where_c, $u_data );
				$callType = "9";
			}
			
			//data to insert in followup table
			$data= array(
				'customer_id' 		=> $customer_id,
				'callType' 			=> $callType,
				'callSummary' 		=> $call_smry,
				'nextCallDate'		=> $nxt_call,
				'customer_prospect'	=> $lead_status,
				'currentCallTime'	=> $currentDate,
				'agent_id'			=> $agent_id,
				'temp_key'			=> $temp_key,
			);
			
			//Update customer followUp last data
			$upf_data = array( "call_status" => 1 );
			$this->global_model->update_data("customer_followup", array( "customer_id" => $customer_id ), $upf_data );
			
			$insert_id = $this->global_model->insert_data( "customer_followup", $data );
			if( $insert_id ){
				$res = array('status' => true, 'msg' => "Call log detail update successfully!", "customer_id" => $customer_id, "temp_key" => $temp_key);
			}else{
				$res = array('status' => false, 'msg' => "Call log detail not update successfully!");
			}	
		}else{
			$res = array('status' => false, 'msg' => "Invalid request please try again later!");
		}
		die( json_encode($res) );
	}
	
	
	//customer type list
	public function customer_type(){
		$user = $this->session->userdata('logged_in');
		$u_id = $user['user_id'];
		$role = $user['role'];
		if( $role == 99 || $role == 98 ){
			$data["customer_types"] = $this->global_model->getdata("customer_type", array("del_status" => 0 ));
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('customers/customer_type', $data);
			$this->load->view('inc/footer');
		}else{
			redirect(404);
		}
	}
	
	//customer type list
	public function savecustype( $id = null ){
		$user = $this->session->userdata('logged_in');
		$u_id = $user['user_id'];
		$role = $user['role'];
		if( $role == 99 || $role == 98 ){
			$d = array();
			if( !empty( $id ) && $id > 2 ){
				$d = $this->global_model->getdata("customer_type", array("del_status" => 0, "id" => $id ));
				if( !$d ) redirect("customers/customer_type");
			}
			$data["customer_type"] = $d;
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('customers/savecustype', $data);
			$this->load->view('inc/footer');
		}else{
			redirect(404);
		}
	}
	
	
	//updatecustomertype
	public function updatecustomertype(){
		$user = $this->session->userdata('logged_in');
		$u_id = $user['user_id'];
		$role = $user['role'];
		if( $role == 99 || $role == 98 ){
			$id 						= $this->input->post("id");
			$data['customer_type'] 		= strip_tags($this->input->post("customer_type"));
			$data['id'] 				= $id;
			//form validation
			$this->form_validation->set_rules('customer_type', 'Customer Type', 'required');
			if ($this->form_validation->run() == FALSE){
				$this->load->view('inc/header');
				$this->load->view('inc/sidebar');
				$this->load->view('customers/savecustype', $data);
				$this->load->view('inc/footer');
			}else{
				$name = trim($this->input->post("customer_type"));
				
				$check_if_exists = $this->global_model->getdata("customer_type", array("name" => $name, "id !=" => $id ) );
				if( $check_if_exists ){
					$this->session->set_flashdata('error',"{$name} Customer type aleardy exists.");
					redirect("customers/savecustype/{$id}");
					exit;
				}
				
				$data_up = array("name" => $name, "added_by" => $u_id );
				if( $id ){
					$this->global_model->update_data("customer_type", array("id" => $id ), $data_up );
				}else{
					$this->global_model->insert_data("customer_type", $data_up );
				}
				$this->session->set_flashdata('success',"Customer type added successfully.");
				redirect("customers/customer_type");
			}
		}else{
			redirect(404);
		}
	}
	
	//delete type
	public function ajax_delete_type(){
		$id = $this->input->post("id");
		$up = $this->global_model->update_data("customer_type", array("id" => $id), array("del_status" => 1 ));
		if( $up ){
			$this->session->set_flashdata('success',"Customer type deleted successfully. {$id}");
			$res = array('status' => true, 'msg' => "Customer Type Deleted");
		}else{
			$res = array('status' => false, 'msg' => "Error To delete!");
		}	
		die(json_encode( $res ));
	}
	
	
}	
?>