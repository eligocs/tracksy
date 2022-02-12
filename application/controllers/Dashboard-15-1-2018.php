<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	
	public function __Construct(){
	   	parent::__Construct();
		validate_login();
		$this->load->model("dashboard_model");
	}

	public function index(){
		$user = $this->session->userdata('logged_in');
		$data['user_id'] = $user['user_id'];
		$user_id = $user['user_id'];
		/*user Roles: 99 = administrator, 98 = manager, 97: service team, 96: sales team */
		$where = array("del_status" => 0);
		$where_iti = array("del_status" => 0, "publish_status" => "publish" );
		$agents = $this->global_model->getdata("users", $where, "", "user_id");
		$itineraries = $this->global_model->getdata("itinerary", $where_iti, "", "iti_id" );
		$data['total_customers'] = $this->global_model->count_all("customers_inquery", $where);
		$data['total_vouchers'] = $this->global_model->count_all("vouchers", $where);
		$data['total_iti']		= $this->global_model->count_all( "itinerary", $where_iti );
		$data['total_agents'] 	= $this->global_model->count_all( "users", $where );
		$data['itineraries'] 	= $itineraries;
		$data['vouchers'] 		= $this->global_model->getdata("vouchers", $where, "", "voucher_id");
		$data['agents'] 		= $agents;
		
		if( $user['role'] == '99' ){
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('dashboard/admin_dashboard', $data);
			$this->load->view('inc/footer');
		}
		elseif( $user['role'] == '98' ){
			//picked call and next call
			$limit = 20;
			
			//Todays status
			//Total Call Picked Today Leads
			$callType = "Picked call";
			$where_aAppr = array('cus_last_followup_status' => $callType, "reopen_by" => 0, "del_status" => 0 );
			$where_appItiLike = array("lead_last_followup_date" => date('Y-m-d') );
			$data['totalPickCallsToday']	= $this->dashboard_model->count_all_data("customers_inquery", $where_aAppr, $where_appItiLike);
			
			//Total Call Not Picked Today Leads
			$callType = "Call not picked";
			$where_aAppr = array('cus_last_followup_status' => $callType, "reopen_by" => 0, "del_status" => 0 );
			$where_appItiLike = array("lead_last_followup_date" => date('Y-m-d') );
			$data['totalNotPickCallsToday']	= $this->dashboard_model->count_all_data("customers_inquery", $where_aAppr, $where_appItiLike);
			
			//Total Leads Today 
			$where_leads = array("del_status" => 0,"reopen_by" => 0);
			$where_like = array("created" => date('Y-m-d') );
			$data['totalContLeadsToday']	= $this->dashboard_model->count_all_data("customers_inquery", $where_leads, $where_like);
			
			
			//Total Call Decline Today Leads 
			$callTypeD = 8;
			$where_dAppr = array('cus_status' => 8, "del_status" => 0 );
			$wDcLike = array("lead_last_followup_date" => date('Y-m-d') );
			$data['totalDecLeadsToday']	= $this->dashboard_model->count_all_data("customers_inquery", $where_dAppr, $wDcLike);
			
			//Decline Itinerary Today
			$where_dc = array('iti_status' => 7, "del_status" => 0 );
			$wItiLike = array("iti_decline_approved_date" => date('Y-m-d') );
			$data['totalDecItiToday']	= $this->dashboard_model->count_all_data("itinerary", $where_dc, $wItiLike);
			
			//Total Quotation Sent Today
			$where_qSent = array();
			$where_qSentLike = array("quotation_sent_date" => date('Y-m-d'), "added" => date('Y-m-d') );
			$data['totalQuotSentToday']	= $this->dashboard_model->count_all_data("itinerary", $where_qSent, $where_qSentLike);
			
			//Total Revised Quotation Sent Today
			$where_qSent = array( "added <=" => date('Y-m-d'));
			$where_qSentLike = array("quotation_sent_date" => date('Y-m-d') );
			$data['totalRevQuotSentToday']	= $this->dashboard_model->count_all_data("itinerary", $where_qSent, $where_qSentLike);
			
			//Get Leads from current month  
			$where_leads = array("del_status" => 0, );
			$where_like = array("created" => date('Y-m') );
			$data['totalLeadsMonth']	= $this->dashboard_model->count_all_data("customers_inquery", $where_leads, $where_like);
			
			//Decline Leads of Current Month  
			$where_decleads = array("del_status" => 0, 'cus_status' => 8);
			$where_dlike = array("created" => date('Y-m') );
			$data['declineLeadsMonth']	= $this->dashboard_model->count_all_data("customers_inquery", $where_decleads, $where_dlike);
			
			//Decline Itinerary Current Month
			$where_deciti = array( "del_status" => 0, 'iti_status' => 7);
			$where_itilike = array("iti_decline_approved_date" => date('Y-m') );
			$data['declineItiMonth']	= $this->dashboard_model->count_all_data("itinerary", $where_deciti, $where_itilike);
			
			//Working Itineraries Total
			$where_working = array( "del_status" => 0, 'iti_status' => 0, "parent_iti_id" => 0, "publish_status" => "publish" );
			$data['workingItiTotal']	= $this->dashboard_model->count_all_data("itinerary", $where_working);
			
			//totalQuotaionSentMonth of Current Month  
			$where_qSent = array("email_count >" => 0 );
			$where_qSentLike = array("quotation_sent_date" => date('Y-m'));
			$data['totalQuotaionSentMonth']	= $this->dashboard_model->count_all_data("itinerary", $where_qSent, $where_qSentLike);
			
			//Booked Itinerary of Current Month  
			$where_appIti = array("del_status" => 0, 'iti_status' => 9);
			$where_appItiLike = array("iti_decline_approved_date" => date('Y-m') );
			$data['appItiMonth']	= $this->dashboard_model->count_all_data("itinerary", $where_appIti, $where_appItiLike);
			
			//Total Leads of Created Today
			$where_addLead = array( "del_status" => 0, "cus_status" => 0 );
			$wleadLike = array("created" => date('Y-m-d') , "cus_last_followup_status" => 0 );
			$data['totalLeadsToday']	= $this->dashboard_model->getdatafilter("customers_inquery", $where_addLead, "customer_id", $limit, $wleadLike);
			
			//Leads Followup Today 
			/* $where_toLead = array();
			$orWhere = "(callType='Picked call' OR callType='Call not picked')";
			$_toDayLike = array("nextCallDate" => date('Y-m-d') );
			$data['leadsFollowupToday']	= $this->dashboard_model->getdatafilter("customer_followup", $where_toLead, "id", $limit, $_toDayLike,"", $orWhere, "", "customer_id"); */
			$data['leadsFollowupToday'] = $this->dashboard_model->getTodaysLeadsFollowup($agent_id = "", $limit);
			
			/* echo "<pre>";
				print_r($toFollow);
			echo "</pre>";	
			die; */
			
			//Itinerary Pending Rates
			$where_pr = array("del_status" => 0, "iti_status" => 0, "pending_price" => 1 );
			$orWhere = array('discount_rate_request' => 1 );
			$penLike = "";
			$data['itiPendingRates']	= $this->dashboard_model->getdatafilter("itinerary", $where_pr,"pending_price_date", $limit, $penLike, $orWhere);
			
			//Itinerary approved Rates limit=5
			$where_Appr = array("pending_price" => 2, "del_status" => 0 );
			$where_ApprLike = array("approved_price_date" => date('Y-m-d') );
			$data['itiAppRates']	= $this->dashboard_model->getdatafilter("itinerary", $where_Appr, "approved_price_date", $limit,$where_ApprLike);
			
			//Itinerary Follow up Today 
			$w_iti = array();
			$Andw_iti = "(callType='Picked call' OR callType='Call not picked')";
			$_tow_itiLike = array("nextCallDate" => date('Y-m-d'));
			$data['todayFollowup_iti']	= $this->dashboard_model->getdatafilter("iti_followup", $w_iti, "", $limit, $_tow_itiLike,"", $Andw_iti, "nextCallDate");
			
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('dashboard/manager_dashboard', $data);
			$this->load->view('inc/footer');
		}
		elseif( $user['role'] == '97' ){
			$data['total_hotel_bookings']	= $this->global_model->count_all( "hotel_booking", $where );
			$data['total_cab_booking']		= $this->global_model->count_all( "cab_booking", $where );
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('dashboard/service_dashboard', $data);
			$this->load->view('inc/footer');
		}elseif( $user['role'] == '96' ){
			//picked call and next call
			$limit = 20;
		    //Get Leads from current month  
			$where_leads = array("del_status" => 0, 'agent_id' => $user_id );
			$where_like = array("created" => date('Y-m') );
			$data['totalLeadsMonth']	= $this->dashboard_model->count_all_data("customers_inquery", $where_leads, $where_like);
			
			//Decline Leads of Current Month  
			$where_decleads = array("del_status" => 0, 'agent_id' => $user_id, 'cus_status' => 8);
			$where_dlike = array("created" => date('Y-m') );
			$data['declineLeadsMonth']	= $this->dashboard_model->count_all_data("customers_inquery", $where_decleads, $where_dlike);
			
			//Decline Itinerary Current Month
			$where_deciti = array("del_status" => 0, 'iti_status' => 7, 'agent_id' => $user_id,);
			$where_itilike = array("iti_decline_approved_date" => date('Y-m') );
			$data['declineItiMonth']	= $this->dashboard_model->count_all_data("itinerary", $where_deciti, $where_itilike);
			
			//Working Itineraries Total
			$where_working = array( "del_status" => 0, 'iti_status' => 0, "parent_iti_id" => 0, "publish_status" => "publish", 'agent_id' => $user_id );
			$data['workingItiTotal']	= $this->dashboard_model->count_all_data("itinerary", $where_working);
			
			//Total Quotation Sent Current Month  
			$where_qSent = array('agent_id' => $user_id , "email_count >" => 0);
			$where_qSentLike = array("quotation_sent_date" => date('Y-m') );
			$data['totalQuotaionSentMonth']	= $this->dashboard_model->count_all_data("itinerary", $where_qSent, $where_qSentLike);
			
			//Booked Itinerary of Current Month  
			$where_appIti = array("del_status" => 0, 'agent_id' => $user_id, 'iti_status' => 9);
			$where_appItiLike = array("iti_decline_approved_date" => date('Y-m') );
			$data['appItiMonth']	= $this->dashboard_model->count_all_data("itinerary", $where_appIti, $where_appItiLike);
			
			//Total Leads of Added Today 
			$where_addLead = array("del_status" => 0, 'agent_id' => $user_id, "cus_status" => 0);
			$wleadLike = array("created" => date('Y-m-d'), "cus_last_followup_status" => 0 );
			$data['totalLeadsToday']	= $this->dashboard_model->getdatafilter("customers_inquery", $where_addLead, "customer_id", $limit, $wleadLike);
			
			//Leads Follow up Today 
			/* $where_toLead = array('agent_id' => $user_id);
			$orWhere = "(callType='Picked call' OR callType='Call not picked')";
			$_toDayLike = array("nextCallDate" => date('Y-m-d'));
			$data['leadsFollowupToday']	= $this->dashboard_model->getdatafilter("customer_followup", $where_toLead, "id", $limit, $_toDayLike,"", $orWhere); */
			$data['leadsFollowupToday'] = $this->dashboard_model->getTodaysLeadsFollowup($user_id, $limit);
			
			//Itinerary Follow up Today 
			$w_iti = array('agent_id' => $user_id);
			$Andw_iti = "(callType='Picked call' OR callType='Call not picked')";
			$_tow_itiLike = array("nextCallDate" => date('Y-m-d'));
			$data['todayFollowup_iti']	= $this->dashboard_model->getdatafilter("iti_followup", $w_iti, "", $limit, $_tow_itiLike,"", $Andw_iti, "nextCallDate");
			
			//Itinerary Pending Rates limit=5
			$where_pr = array('agent_id' => $user_id, "pending_price" => 1, "del_status" => 0);
			$or_where_pr = array( "discount_rate_request" => 1 );
			/* $penLike = array("pending_price_date" => date('Y-m') ); */
			$penLike = "";
			$data['itiPendingRates']	= $this->dashboard_model->getdatafilter("itinerary", $where_pr, "pending_price_date", $limit, $penLike, $or_where_pr);
			
			//Itinerary approved Rates limit=5
			$where_Appr = array('agent_id' => $user_id,"pending_price" => 2, "del_status" => 0 );
			$where_ApprLike = array("approved_price_date" => date('Y-m') );
			$data['itiAppRates']	= $this->dashboard_model->getdatafilter( "itinerary", $where_Appr, "approved_price_date", $limit,$where_ApprLike );
			
			//Total Call Picked Today Leads
			$callType = "Picked call";
			$where_aAppr = array('agent_id' => $user_id, 'cus_last_followup_status' => $callType, "reopen_by" => 0, "del_status" => 0 );
			$where_appItiLike = array("lead_last_followup_date" => date('Y-m-d') );
			$data['totalPickCallsToday']	= $this->dashboard_model->count_all_data("customers_inquery", $where_aAppr, $where_appItiLike);
			
			//Total Leads Today
			$where_leads = array("del_status" => 0, 'agent_id' => $user_id ,"reopen_by" => 0);
			$where_like = array("created" => date('Y-m-d') );
			$data['totalContLeadsToday']	= $this->dashboard_model->count_all_data("customers_inquery", $where_leads, $where_like);
			
			
			//Total Call Decline Today Leads 
			$callTypeD = 8;
			$where_dAppr = array('agent_id' => $user_id, "reopen_by" => 0, 'cus_last_followup_status' => $callTypeD, "del_status" => 0 );
			$wDcLike = array("lead_last_followup_date" => date('Y-m-d') );
			$data['totalDecLeadsToday']	= $this->dashboard_model->count_all_data("customers_inquery", $where_dAppr, $wDcLike);
			
			//Decline Itinerary Today
			$where_dc = array('agent_id' => $user_id,'iti_status' =>7, "del_status" => 0 );
			$wItiLike = array("iti_decline_approved_date" => date('Y-m-d') );
			$data['totalDecItiToday']	= $this->dashboard_model->count_all_data("itinerary", $where_dc, $wItiLike);
			
			//Total Quotation Sent Today
			$where_qSent = array('agent_id' => $user_id);
			$where_qSentLike = array("quotation_sent_date" => date('Y-m-d'), "added" => date('Y-m-d') );
			$data['totalQuotSentToday']	= $this->dashboard_model->count_all_data("itinerary", $where_qSent, $where_qSentLike);
			
			//Total Revised Quotation Sent Today
			$where_qSent = array('agent_id' => $user_id, "added <=" => date('Y-m-d'));
			$where_qSentLike = array("quotation_sent_date" => date('Y-m-d') );
			$data['totalRevQuotSentToday']	= $this->dashboard_model->count_all_data("itinerary", $where_qSent, $where_qSentLike);
			
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('dashboard/sales_dashboard', $data);
			$this->load->view('inc/footer');
		}elseif( $user['role'] == '95' ){
			$data["leads"] = "Leads data";
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('dashboard/leads_dashboard', $data);
			$this->load->view('inc/footer');
		}else{
			redirect("login");
		}
	}
	public function profile(){
		$user = $this->session->userdata('logged_in');
		if($user){
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('users/profile');
			$this->load->view('inc/footer');
		}
		
	}
	
	public function logout(){
		$this->session->unset_userdata('logged_in');
		redirect("login");
	}
	
	/******* User dashboard sales team ********/
	public function user_dashboard(){
		$user = $this->session->userdata('logged_in');
		$data['user_id'] = $user['user_id'];
		$user_id = $user['user_id'];
		/*user Roles: 99 = administrator, 98 = manager, 97: service team, 96: sales team */
		if( $user['role'] == '99' || $user['role'] == '98' ){
			//check if user_id 
			if( isset( $_GET['user_id'] ) && !empty( $_GET['user_id'] ) ){
				$uid = $_GET['user_id'];
				//check user role if not sales team redirect
				$user_role = get_user_role_by_id( $uid );
				if( $user_role == 96 ){
					$this->_sales_team_dashboard( $uid );
				}else{
					redirect("dashboard/user_dashboard");
				}
			}else{
				$where = array("del_status" => 0, "user_type" => 96 );
				$order = array("user_name" => "ASC");
				$all_users	 = $this->login_model->get_data( "users", $where, $order );
				
				$where_manager = array("del_status" => 0, "user_type" => 98 );
				$all_manager = $this->login_model->get_data( "users", $where_manager, $order );
				$data['sales_team_users']	 = $all_users;
				$data['managers'] = $all_manager;
				$this->load->view('inc/header');
				$this->load->view('inc/sidebar');
				$this->load->view('dashboard/admin_sales_dashboard', $data);
				$this->load->view('inc/footer');
			}	
		}else{
			redirect("dashboard");
		}	
	}	
	
	//get sales team dashboard
	private function _sales_team_dashboard( $user_id ){
		$user_id = trim( $user_id );
		//picked call and next call
		$limit = 20;
		$data["sales_user_id"] = $user_id;
		
		//get all sales team users
		$where = array("del_status" => 0, "user_type" => 96 , "user_status" => "active" );
		$order = array("user_name" => "ASC");
		$all_users	 = $this->login_model->get_data( "users", $where, $order );
		$data['users_data'] = $all_users;
		
		 //Get Leads from current month  
		$where_leads = array("del_status" => 0, 'agent_id' => $user_id );
		$where_like = array("created" => date('Y-m') );
		$data['totalLeadsMonth']	= $this->dashboard_model->count_all_data("customers_inquery", $where_leads, $where_like);
		
		//Decline Itinerary Current Month
		$where_deciti = array("del_status" => 0, 'iti_status' => 7, 'agent_id' => $user_id,);
		$where_itilike = array("iti_decline_approved_date" => date('Y-m') );
		$data['declineItiMonth']	= $this->dashboard_model->count_all_data("itinerary", $where_deciti, $where_itilike);
		
		//Decline Leads of Current Month  
		$where_decleads = array("del_status" => 0, 'agent_id' => $user_id, 'cus_status' => 8);
		$where_dlike = array("created" => date('Y-m') );
		$data['declineLeadsMonth']	= $this->dashboard_model->count_all_data("customers_inquery", $where_decleads, $where_dlike);
		
		//Total Quotation Sent Current Month  
		$where_qSent = array('agent_id' => $user_id, "email_count >" => 0);
		$where_qSentLike = array("quotation_sent_date" => date('Y-m') );
		$data['totalQuotaionSentMonth']	= $this->dashboard_model->count_all_data("itinerary", $where_qSent, $where_qSentLike);
		
		//Booked Itinerary of Current Month  
		$where_appIti = array("del_status" => 0, 'agent_id' => $user_id, 'iti_status' => 9);
		$where_appItiLike = array("iti_decline_approved_date" => date('Y-m') );
		$data['appItiMonth']	= $this->dashboard_model->count_all_data("itinerary", $where_appIti, $where_appItiLike);
		
		//Working Itineraries Total
		$where_working = array( "del_status" => 0, 'iti_status' => 0, "parent_iti_id" => 0, "publish_status" => "publish", 'agent_id' => $user_id );
		$data['workingItiTotal']	= $this->dashboard_model->count_all_data("itinerary", $where_working);
			
		//Total Leads of Added Today 
		$where_addLead = array("del_status" => 0, 'agent_id' => $user_id, "cus_status" => 0);
		$wleadLike = array("created" => date('Y-m-d'), "cus_last_followup_status" => 0 );
		$data['totalLeadsToday']	= $this->dashboard_model->getdatafilter("customers_inquery", $where_addLead, "customer_id", $limit, $wleadLike);
		
		//Leads Followup Today 
		/* $where_toLead = array('agent_id' => $user_id);
		$orWhere = "(callType='Picked call' OR callType='Call not picked')";
		$_toDayLike = array("nextCallDate" => date('Y-m-d'));
		$data['leadsFollowupToday']	= $this->dashboard_model->getdatafilter("customer_followup", $where_toLead, "id", $limit, $_toDayLike,"", $orWhere); */
		$data['leadsFollowupToday'] = $this->dashboard_model->getTodaysLeadsFollowup($user_id, $limit);
		
		//Itinerary Pending Rates limit=5
		$where_pr = array('agent_id' => $user_id, "pending_price" => 1, "del_status" => 0);
		$or_where_pr = array( "discount_rate_request" => 1 );
		/* $penLike = array("pending_price_date" => date('Y-m') ); */
		$penLike = "";
		$data['itiPendingRates']	= $this->dashboard_model->getdatafilter("itinerary", $where_pr, "pending_price_date", $limit, $penLike, $or_where_pr);
		
		//Itinerary approved Rates limit=5
		$where_Appr = array('agent_id' => $user_id,"pending_price" => 2, "del_status" => 0 );
		$where_ApprLike = array("approved_price_date" => date('Y-m') );
		$data['itiAppRates']	= $this->dashboard_model->getdatafilter( "itinerary", $where_Appr, "approved_price_date", $limit,$where_ApprLike );
		
		//Total Call Picked Today Leads
		$callType = "Picked call";
		$where_aAppr = array('agent_id' => $user_id, 'cus_last_followup_status' => $callType, "reopen_by" => 0, "del_status" => 0 );
		$where_appItiLike = array("lead_last_followup_date" => date('Y-m-d') );
		$data['totalPickCallsToday']	= $this->dashboard_model->count_all_data("customers_inquery", $where_aAppr, $where_appItiLike);
		
		//Total Leads Today
		$where_leads = array("del_status" => 0, 'agent_id' => $user_id ,"reopen_by" => 0);
		$where_like = array("created" => date('Y-m-d') );
		$data['totalContLeadsToday']	= $this->dashboard_model->count_all_data("customers_inquery", $where_leads, $where_like);
		
		//Itinerary Followup Today 
		$w_iti = array('agent_id' => $user_id);
		$Andw_iti = "(callType='Picked call' OR callType='Call not picked')";
		$_tow_itiLike = array("nextCallDate" => date('Y-m-d'));
		$data['todayFollowup_iti']	= $this->dashboard_model->getdatafilter("iti_followup", $w_iti, "", $limit, $_tow_itiLike,"", $Andw_iti, "nextCallDate");
		
		//Total Call Decline Today Leads 
		$callTypeD = 8;
		$where_dAppr = array('agent_id' => $user_id, "reopen_by" => 0, 'cus_last_followup_status' => $callTypeD, "del_status" => 0 );
		$wDcLike = array("lead_last_followup_date" => date('Y-m-d') );
		$data['totalDecLeadsToday']	= $this->dashboard_model->count_all_data("customers_inquery", $where_dAppr, $wDcLike);
		
		//Decline Itinerary Today
		$where_dc = array('agent_id' => $user_id,'iti_status' =>7, "del_status" => 0 );
		$wItiLike = array("iti_decline_approved_date" => date('Y-m-d') );
		$data['totalDecItiToday']	= $this->dashboard_model->count_all_data("itinerary", $where_dc, $wItiLike);
		
		//Total Quotation Sent Today
		$where_qSent = array('agent_id' => $user_id);
		$where_qSentLike = array("quotation_sent_date" => date('Y-m-d'), "added" => date('Y-m-d') );
		$data['totalQuotSentToday']	= $this->dashboard_model->count_all_data("itinerary", $where_qSent, $where_qSentLike);
		
		//Total Revised Quotation Sent Today
		$where_qSent = array('agent_id' => $user_id, "added <=" => date('Y-m-d'));
		$where_qSentLike = array("quotation_sent_date" => date('Y-m-d') );
		$data['totalRevQuotSentToday']	= $this->dashboard_model->count_all_data("itinerary", $where_qSent, $where_qSentLike);
		
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('dashboard/sales_dashboard', $data);
			$this->load->view('inc/footer');
	}
	
	private function _manager_dashboard( $user_id ){
		//picked call and next call
		$limit = 20;
		//Todays status
		//Total Call Picked Today Leads
		$callType = "Picked call";
		$where_aAppr = array('cus_last_followup_status' => $callType, "reopen_by" => 0, "del_status" => 0 );
		$where_appItiLike = array("lead_last_followup_date" => date('Y-m-d') );
		$data['totalPickCallsToday']	= $this->dashboard_model->count_all_data("customers_inquery", $where_aAppr, $where_appItiLike);
		
		//Total Leads Today
		$where_leads = array("del_status" => 0,"reopen_by" => 0);
		$where_like = array("created" => date('Y-m-d') );
		$data['totalContLeadsToday']	= $this->dashboard_model->count_all_data("customers_inquery", $where_leads, $where_like);
		
		//Working Itineraries Total
		$where_working = array( "del_status" => 0, 'iti_status' => 0, "parent_iti_id" => 0, "publish_status" => "publish" );
		$data['workingItiTotal']	= $this->dashboard_model->count_all_data("itinerary", $where_working);
		
		//Total Call Decline Today Leads 
		$callTypeD = 8;
		$where_dAppr = array('cus_status' => 8, "del_status" => 0 );
		$wDcLike = array("lead_last_followup_date" => date('Y-m-d') );
		$data['totalDecLeadsToday']	= $this->dashboard_model->count_all_data("customers_inquery", $where_dAppr, $wDcLike);
		
		//Decline Itinerary Today
		$where_dc = array('iti_status' => 7, "del_status" => 0 );
		$wItiLike = array("iti_decline_approved_date" => date('Y-m-d') );
		$data['totalDecItiToday']	= $this->dashboard_model->count_all_data("itinerary", $where_dc, $wItiLike);
		
		//Total Quotation Sent Today
		$where_qSent = array();
		$where_qSentLike = array("quotation_sent_date" => date('Y-m-d'), "added" => date('Y-m-d') );
		$data['totalQuotSentToday']	= $this->dashboard_model->count_all_data("itinerary", $where_qSent, $where_qSentLike);
		
		//Total Revised Quotation Sent Today
		$where_qSent = array( "added <=" => date('Y-m-d'));
		$where_qSentLike = array("quotation_sent_date" => date('Y-m-d') );
		$data['totalRevQuotSentToday']	= $this->dashboard_model->count_all_data("itinerary", $where_qSent, $where_qSentLike);
		
		//Get Leads from current month  
		$where_leads = array("del_status" => 0, );
		$where_like = array("created" => date('Y-m') );
		$data['totalLeadsMonth']	= $this->dashboard_model->count_all_data("customers_inquery", $where_leads, $where_like);
		
		//Decline Itinerary Current Month
		$where_deciti = array("del_status" => 0, 'iti_status' => 7);
		$where_itilike = array("iti_decline_approved_date" => date('Y-m') );
		$data['declineItiMonth']	= $this->dashboard_model->count_all_data("itinerary", $where_deciti, $where_itilike);
		
		//Decline Leads of Current Month  
		$where_decleads = array("del_status" => 0, 'cus_status' => 8);
		$where_dlike = array("created" => date('Y-m') );
		$data['declineLeadsMonth']	= $this->dashboard_model->count_all_data("customers_inquery", $where_decleads, $where_dlike);
		
		//totalQuotaionSentMonth of Current Month  
		$where_qSent = array( "email_count >" => 0);
		$where_qSentLike = array("quotation_sent_date" => date('Y-m') );
		$data['totalQuotaionSentMonth']	= $this->dashboard_model->count_all_data("itinerary", $where_qSent, $where_qSentLike);
		
		//Booked Itinerary of Current Month  
		$where_appIti = array("del_status" => 0, 'iti_status' => 9);
		$where_appItiLike = array("iti_decline_approved_date" => date('Y-m') );
		$data['appItiMonth']	= $this->dashboard_model->count_all_data("itinerary", $where_appIti, $where_appItiLike);
		
		//Total Leads of Created Today
		$where_addLead = array("del_status" => 0, "cus_status" => 0);
		$wleadLike = array("created" => date('Y-m-d'), "cus_last_followup_status" => 0 );
		$data['totalLeadsToday']	= $this->dashboard_model->getdatafilter("customers_inquery", $where_addLead, "customer_id", $limit, $wleadLike);
		
		//Leads Followup Today 
		/* $where_toLead = array();
		$orWhere = "(callType='Picked call' OR callType='Call not picked')";
		$_toDayLike = array("nextCallDate" => date('Y-m-d') );
		$data['leadsFollowupToday']	= $this->dashboard_model->getdatafilter("customer_followup", $where_toLead, "id", $limit, $_toDayLike,"", $orWhere); */
		$data['leadsFollowupToday'] = $this->dashboard_model->getTodaysLeadsFollowup($user_id = "", $limit);
		
		//Itinerary Pending Rates
		$where_pr = array("del_status" => 0, "iti_status" => 0, "pending_price" => 1 );
		$orWhere = array('discount_rate_request' => 1 );
		$penLike = "";
		$data['itiPendingRates']	= $this->dashboard_model->getdatafilter("itinerary", $where_pr,"pending_price_date", $limit, $penLike, $orWhere);
		
		//Itinerary approved Rates limit=5
		$where_Appr = array("pending_price" => 2, "del_status" => 0 );
		$where_ApprLike = array("approved_price_date" => date('Y-m-d') );
		$data['itiAppRates']	= $this->dashboard_model->getdatafilter("itinerary", $where_Appr, "approved_price_date", $limit,$where_ApprLike);
		
		//Itinerary Follow up Today 
		$w_iti = array();
		$Andw_iti = "(callType='Picked call' OR callType='Call not picked')";
		$_tow_itiLike = array("nextCallDate" => date('Y-m-d'));
		$data['todayFollowup_iti']	= $this->dashboard_model->getdatafilter("iti_followup", $w_iti, "", $limit, $_tow_itiLike,"", $Andw_iti, "nextCallDate");
		
		$this->load->view('inc/header');
		$this->load->view('inc/sidebar');
		$this->load->view('dashboard/manager_dashboard', $data);
		$this->load->view('inc/footer');
	}
	
	/* //email test
	public function mailtest(){
		$admin_email 	= admin_email();
		$manager_email 	= manager_email();
		
		$to = array( "premthakur999@gmail.com" );
		$sub = "test";
		$msg = "<b>BCC</b>";
		$msg .= "<strong>BCC</strong>";
		sendEmail( $to, $sub, $msg, "sanjaythermosharma@gmail.com" );
	}
	*/
	//SMS Testing
	/* public function smstest(){
		$mob = 9805890367;
		$msg = "Testing ";
		$msg .= "http://www.google.com";
		$s = pm_send_sms($mob, $msg);
		if( $s ){
			echo "sent";
		}else{
			echo "fail";
		}
	} */
	
	
}
