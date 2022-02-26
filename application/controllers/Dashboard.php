<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	
	public function __Construct(){
	   	parent::__Construct();
		validate_login();
		$this->load->model("dashboard_model");
	}
	
	public function index(){
		//echo ENVIRONMENT; die;
		$user = $this->session->userdata('logged_in');
		$data['user_id'] = $user['user_id'];
		$user_id = $user['user_id'];
		/*user Roles: 99 = administrator, 98 = manager, 97: service team, 96: sales team */
		if( $user['role'] == '99' ){
			$limit = 30;
			$where = array( "del_status" => 0 );
			$where_iti = array("del_status" => 0, "publish_status" => "publish", "parent_iti_id" => 0 );
			$agents 				= $this->global_model->getdata("users", $where, "", "user_id");
			$data['total_customers'] = $this->global_model->count_all("customers_inquery", $where);
			$data['total_iti']		= $this->global_model->count_all( "itinerary", $where_iti );
			$data['total_agents'] 	= $this->global_model->count_all( "users", array("del_status" => 0, "user_status" => "active") );
			$data['total_vouchers'] = $this->global_model->count_all( "iti_vouchers_status", array("confirm_voucher" => 1 ) );
			
			//Total Itineraries Month
			//$where_dc = array('parent_iti_id' => 0, "del_status" => 0 );
			//$wItiLike = array("added" => date('Y-m') );
			//$data['total_iti_month']	= $this->dashboard_model->count_all_data("itinerary", $where_dc, $wItiLike);
			//$wAppDec = array( "iti_decline_approved_date" => date('Y-m') );
			//$data['total_iti_booked_month']	= $this->dashboard_model->count_all_data("itinerary", array( "iti_status" => 9 ) , $wAppDec);
			//$data['total_iti_dec_month']	= $this->dashboard_model->count_all_data("itinerary", array( "iti_status" => 7 ) , $wAppDec);
			//$data['voucher_confirm_month']	= $this->dashboard_model->count_all_data("iti_vouchers_status", array( "confirm_voucher" => 1 ) , array( "created" => date("Y-m") ));
			
			//Total Customers Month
			//$where_dcc = array("del_status" => 0 );
			//$wItiLikec = array("created" => date('Y-m') );
			//$data['total_cus_month']	= $this->dashboard_model->count_all_data("customers_inquery", $where_dcc, $wItiLikec);
			//$wAppDecc = array( "lead_last_followup_date" => date('Y-m') );
			//$data['total_cus_booked_month']	= $this->dashboard_model->count_all_data("customers_inquery", array( "cus_status" => 9 ) , $wAppDecc);
			//$data['total_cus_dec_month']	= $this->dashboard_model->count_all_data("customers_inquery", array( "cus_status" => 8 ) , $wAppDecc);
			//$data['working_lead_month']	= $this->dashboard_model->count_all_data("customers_inquery", array( "cus_status" => 0 ) , $wItiLikec );
			
			
			/****************************** 
			* *******Todays Section *******
			******************************/
			
			//Total Leads Created Today 
			$where_leads = array("del_status" => 0,"reopen_by" => 0);
			$where_like = array("created" => date('Y-m-d') );
			$data['totalContLeadsToday']	= $this->dashboard_model->count_all_data("customers_inquery", $where_leads, $where_like);
			
			//Total Call Picked Today Leads
			$callType = "Picked call";
			$where_aAppr = array('cus_last_followup_status' => $callType, "reopen_by" => 0, "del_status" => 0 );
			$where_appItiLike = array("lead_last_followup_date" => date('Y-m-d'), "created" => date('Y-m-d') );
			$data['totalPickCallsToday'] = $this->dashboard_model->count_all_data("customers_inquery", $where_aAppr, $where_appItiLike);
			
			//Total Call Not Picked Today Leads
			$callType = "Call not picked";
			$where_aAppr = array('cus_last_followup_status' => $callType, "reopen_by" => 0, "del_status" => 0 );
			$where_appItiLike = array("lead_last_followup_date" => date('Y-m-d'), "created" => date('Y-m-d') );
			$data['totalNotPickCallsToday']	= $this->dashboard_model->count_all_data("customers_inquery", $where_aAppr, $where_appItiLike);
			
			//Total Call Decline Today Leads 
			$callTypeD = 8;
			$where_dAppr = array('cus_status' => 8, "del_status" => 0 );
			$wDcLike = array("lead_last_followup_date" => date('Y-m-d'), "created" => date('Y-m-d')  );
			$data['totalDecLeadsToday']	= $this->dashboard_model->count_all_data("customers_inquery", $where_dAppr, $wDcLike);
			
			//Total Unwork Today Leads 
			$whLead = array('cus_status' => 0, "del_status" => 0 );
			$wDcLke = array( "created" => date('Y-m-d'), "cus_last_followup_status" => 0   );
			$data['totalUnworkLeadsToday']	= $this->dashboard_model->count_all_data("customers_inquery", $whLead, $wDcLke);
			
			//Total Quotation Sent Today
			$where_qSent = array("parent_iti_id" => 0);
			$where_qSentLike = array("quotation_sent_date" => date('Y-m-d'), "lead_created" => date('Y-m-d') );
			$data['totalQuotSentToday']	= $this->dashboard_model->count_all_data("itinerary", $where_qSent, $where_qSentLike);
			
			//Decline Itinerary Today
			$where_dc = array('iti_status' => 7, "del_status" => 0 );
			$wItiLike = array("iti_decline_approved_date" => date('Y-m-d'), "lead_created" => date('Y-m-d') );
			$data['totalDecItiToday']	= $this->dashboard_model->count_all_data("itinerary", $where_dc, $wItiLike);
			
			//Working Itinerary Today
			$where_dc = array('iti_status' => 0, "publish_status" => "publish", "del_status" => 0, "parent_iti_id" => 0 );
			$wItiLike = array("lead_created" => date('Y-m-d') );
			$data['totalWorkingItiToday']	= $this->dashboard_model->count_all_data("itinerary", $where_dc, $wItiLike);
			
			//Approved Itinerary Today
			$where_dc = array('iti_status' => 9, "del_status" => 0 );
			$wItiLike = array("lead_created" => date('Y-m-d'), "iti_decline_approved_date" => date('Y-m-d') );
			$data['totalApprovedItiToday']	= $this->dashboard_model->count_all_data("itinerary", $where_dc, $wItiLike);
			
			//Total Revised Quotation Sent Today
			$it_like = array("created_at" => date('Y-m-d') );
			$data['today_ind_tour_query']	= $this->dashboard_model->count_all_data("it_queries", array(), $it_like);
			
			/*************************************** 
			********Todays Revised Section *********
			****************************************/
			//Total Revised Quotation Sent Today Leads created before today
			$where_rev_Sent = array("lead_created <" => date('Y-m-d'));
			$where_qRevSentLike = array("quotation_sent_date" => date('Y-m-d') );
			$data['pastQuotSentToday']	= $this->dashboard_model->count_all_data("itinerary", $where_rev_Sent, $where_qRevSentLike);
			
			//Approved Revised Itinerary Today
			$where_dc = array('iti_status' => 9, "del_status" => 0 , "lead_created <" => date('Y-m-d') );
			$wItiLike = array("iti_decline_approved_date" => date('Y-m-d') );
			$data['pastApprovedItiToday']	= $this->dashboard_model->count_all_data("itinerary", $where_dc, $wItiLike);
			
			//Approved Revised Itinerary Today
			$where_dc = array('iti_status' => 7, "del_status" => 0 , "lead_created <" => date('Y-m-d') );
			$wItiLike = array("iti_decline_approved_date" => date('Y-m-d') );
			$data['pastDeclineItiToday']	= $this->dashboard_model->count_all_data("itinerary", $where_dc, $wItiLike);
			
			//Total Revised Leads Decline Today 
			$where_dAppr = array('cus_status' => 8, "del_status" => 0, "created <" => date('Y-m-d')  );
			$wDcLike = array("lead_last_followup_date" => date('Y-m-d') );
			$data['pastDecLeadsToday']	= $this->dashboard_model->count_all_data("customers_inquery", $where_dAppr, $wDcLike);
			
			/****************************** 
			* *******Month Section *******
			******************************/
			
			//Get Leads from current month  
			$where_m_leads = array("del_status" => 0, );
			$where_m_like = array("created" => date('Y-m') );
			$data['totalLeadsMonth']	= $this->dashboard_model->count_all_data("customers_inquery", $where_m_leads, $where_m_like);
			
			//Total Unwork Leads This Month 
			$whLeadM = array('cus_status' => 0, "del_status" => 0);
			$wDcLkeM = array( "created" => date('Y-m') , "cus_last_followup_status" => 0  );
			$data['totalUnworkLeadsMonth']	= $this->dashboard_model->count_all_data("customers_inquery", $whLeadM, $wDcLkeM);
			
			//Total Call Picked This Month Leads
			$callType = "Picked call";
			$where_m_aAppr = array('cus_last_followup_status' => $callType, "reopen_by" => 0, "del_status" => 0, "cus_status !=" => 8 );
			$where_m_picklike = array("lead_last_followup_date" => date('Y-m'), "created" => date('Y-m') );
			$data['totalPickCallsMonth'] = $this->dashboard_model->count_all_data("customers_inquery", $where_m_aAppr, $where_m_picklike);
			
			//Total Call Not Picked This Month Leads
			$callType = "Call not picked";
			$where_mcnp = array('cus_last_followup_status' => $callType, "reopen_by" => 0, "del_status" => 0 );
			$like_m_notPick = array("lead_last_followup_date" => date('Y-m'), "created" => date('Y-m') );
			$data['totalNotPickCallsMonth']	= $this->dashboard_model->count_all_data("customers_inquery", $where_mcnp, $like_m_notPick);
			
			//Total Call Decline This Month Leads 
			$callTypeD = 8;
			$where_m_d = array('cus_status' => 8, "del_status" => 0 );
			$wDcLikeMon = array("lead_last_followup_date" => date('Y-m'), "created" => date('Y-m')  );
			$data['totalDecLeadsMonth']	= $this->dashboard_model->count_all_data("customers_inquery", $where_m_d, $wDcLikeMon);
			
			//Quotation Sent This Month
			$where_mqSent = array("email_count >" => 0, "del_status" => 0, "parent_iti_id" => 0 );
			$where_mqSentLike = array("quotation_sent_date" => date('Y-m'), "lead_created" => date('Y-m') );
			$data['totalQuotSentMonth']	= $this->dashboard_model->count_all_data("itinerary", $where_mqSent, $where_mqSentLike);
			
			//Decline Itinerary This Month
			$where_mdc = array('iti_status' => 7, "del_status" => 0 );
			$wmItiLike = array("iti_decline_approved_date" => date('Y-m'), "lead_created" => date('Y-m') );
			$data['totalDecItiMonth']	= $this->dashboard_model->count_all_data("itinerary", $where_mdc, $wmItiLike);
			
			//Working Itinerary This Month
			$where_dcm = array('iti_status' => 0, "publish_status" => "publish", "del_status" => 0, "parent_iti_id" => 0 );
			$wItiLikem = array("lead_created" => date('Y-m') );
			$data['totalWorkingItiMonth']	= $this->dashboard_model->count_all_data("itinerary", $where_dcm, $wItiLikem);
			
			//Approved Itinerary This Month
			$where_M_dc = array('iti_status' => 9, "del_status" => 0 );
			$wItiLike_M = array("lead_created" => date('Y-m'), "iti_decline_approved_date" => date('Y-m') );
			$data['totalApprovedItiMonth']	= $this->dashboard_model->count_all_data("itinerary", $where_M_dc, $wItiLike_M);
			
			//Total Revised Quotation Sent This Month
			$where_qmSent = array( "parent_iti_id !=" => 0);
			$where_qmSentLike = array("quotation_sent_date" => date('Y-m'), "lead_created" => date('Y-m') );
			$data['totalRevQuotSentMonth']	= $this->dashboard_model->count_all_data("itinerary", $where_qmSent, $where_qmSentLike);
			
			
			/******************************************* 
			********This Month Revised Section *********
			*******************************************/
			//Total Revised Quotation Sent This Month Leads created before This Month
			$where_rev_m_Sent 		= array("lead_created <" => date('Y-m-01'));
			$where_m_qRevSentLike 	= array("quotation_sent_date" => date('Y-m') );
			$data['pastQuotSentMonth']	= $this->dashboard_model->count_all_data("itinerary", $where_rev_m_Sent, $where_m_qRevSentLike);
			
			//Approved Revised Itinerary This Month
			$where_dcm = array('iti_status' => 9, "del_status" => 0 , "lead_created <" => date('Y-m-01') );
			$wItim_Like = array("iti_decline_approved_date" => date('Y-m') );
			$data['pastApprovedItiMonth']	= $this->dashboard_model->count_all_data("itinerary", $where_dcm, $wItim_Like);
			
			//Approved Revised Itinerary This Month
			$where_m_dc = array('iti_status' => 7, "del_status" => 0 , "lead_created <" => date('Y-m-01') );
			$wItiLim_ke = array("iti_decline_approved_date" => date('Y-m') );
			$data['pastDeclineItiMonth']	= $this->dashboard_model->count_all_data("itinerary", $where_m_dc, $wItiLim_ke);
			
			//Total Revised Leads Decline This Month Leads 
			$where_m_dAppr = array( 'cus_status' => 8, "del_status" => 0, "created <" => date("Y-m-01") );
			$wDcLim_ke = array("lead_last_followup_date" => date('Y-m'));
			$data['pastDecLeadsMonth']	= $this->dashboard_model->count_all_data("customers_inquery", $where_m_dAppr, $wDcLim_ke);
			
			
			//UPDATE PRICE REQUEST
			$where_prm = array("del_status" => 0 );
			$orWhere_p = ( "pending_price = 4 OR discount_rate_request = 2" );
			$pensLike = "";
			$data['itiPendingRates_Manager'] = $this->dashboard_model->getdatafilter("itinerary", $where_prm,"pending_price_date", $limit, $pensLike, "", $orWhere_p);
			
			//CHECK ABOVE FOURTY THOUSAND PACKAGES ON WORKING
			$data['above_fourty_thousand_wrk_pkg'] = $this->dashboard_model->__check_above_fourty_thousand_working_packages();
			
			$data['agents'] = $agents;
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('dashboard/admin_dashboard', $data);
			$this->load->view('inc/footer');
		}elseif( $user['role'] == '98' ){
			
			//picked call and next call
			$limit = 30;
			
			/****************************** 
			* *******Todays Section *******
			******************************/
			
			//Total Leads Created Today 
			$where_leads = array("del_status" => 0,"reopen_by" => 0);
			$where_like = array("created" => date('Y-m-d') );
			$data['totalContLeadsToday']	= $this->dashboard_model->count_all_data("customers_inquery", $where_leads, $where_like);
			
			//Total Call Picked Today Leads
			$callType = "Picked call";
			$where_aAppr = array('cus_last_followup_status' => $callType, "reopen_by" => 0, "del_status" => 0 );
			$where_appItiLike = array("lead_last_followup_date" => date('Y-m-d'), "created" => date('Y-m-d') );
			$data['totalPickCallsToday'] = $this->dashboard_model->count_all_data("customers_inquery", $where_aAppr, $where_appItiLike);
			
			//Total Call Not Picked Today Leads
			$callType = "Call not picked";
			$where_aAppr = array('cus_last_followup_status' => $callType, "reopen_by" => 0, "del_status" => 0 );
			$where_appItiLike = array("lead_last_followup_date" => date('Y-m-d'), "created" => date('Y-m-d') );
			$data['totalNotPickCallsToday']	= $this->dashboard_model->count_all_data("customers_inquery", $where_aAppr, $where_appItiLike);
			
			//Total Call Decline Today Leads 
			$callTypeD = 8;
			$where_dAppr = array('cus_status' => 8, "del_status" => 0 );
			$wDcLike = array("lead_last_followup_date" => date('Y-m-d'), "created" => date('Y-m-d')  );
			$data['totalDecLeadsToday']	= $this->dashboard_model->count_all_data("customers_inquery", $where_dAppr, $wDcLike);
			
			//Total Unwork Today Leads 
			$whLead = array('cus_status' => 0, "del_status" => 0 );
			$wDcLke = array( "created" => date('Y-m-d'), "cus_last_followup_status" => 0   );
			$data['totalUnworkLeadsToday']	= $this->dashboard_model->count_all_data("customers_inquery", $whLead, $wDcLke);
			
			//Total Quotation Sent Today
			$where_qSent = array("parent_iti_id" => 0);
			$where_qSentLike = array("quotation_sent_date" => date('Y-m-d'), "lead_created" => date('Y-m-d') );
			$data['totalQuotSentToday']	= $this->dashboard_model->count_all_data("itinerary", $where_qSent, $where_qSentLike);
			
			//Decline Itinerary Today
			$where_dc = array('iti_status' => 7, "del_status" => 0 );
			$wItiLike = array("iti_decline_approved_date" => date('Y-m-d'), "lead_created" => date('Y-m-d') );
			$data['totalDecItiToday']	= $this->dashboard_model->count_all_data("itinerary", $where_dc, $wItiLike);
			
			//Working Itinerary Today
			$where_dc = array('iti_status' => 0, "publish_status" => "publish", "del_status" => 0, "parent_iti_id" => 0 );
			$wItiLike = array("lead_created" => date('Y-m-d') );
			$data['totalWorkingItiToday']	= $this->dashboard_model->count_all_data("itinerary", $where_dc, $wItiLike);
			
			//Approved Itinerary Today
			$where_dc = array('iti_status' => 9, "del_status" => 0 );
			$wItiLike = array("lead_created" => date('Y-m-d'), "iti_decline_approved_date" => date('Y-m-d') );
			$data['totalApprovedItiToday']	= $this->dashboard_model->count_all_data("itinerary", $where_dc, $wItiLike);
			
			//Total Revised Quotation Sent Today
			$where_qSent = array( "parent_iti_id !=" => 0 );
			$where_qSentLike = array("quotation_sent_date" => date('Y-m-d'), "lead_created" => date('Y-m-d') );
			$data['totalRevQuotSentToday']	= $this->dashboard_model->count_all_data("itinerary", $where_qSent, $where_qSentLike);
			
			//Total Leads Data Created Today
			$where_addLead = array( "del_status" => 0, "cus_status" => 0 );
			$wleadLike = array("created" => date('Y-m-d') , "cus_last_followup_status" => 0 );
			//$data['totalLeadsToday']	= $this->dashboard_model->getdatafilter("customers_inquery", $where_addLead, "customer_id", $limit, $wleadLike);
			
			//Leads Follow up Today 
			//$data['leadsFollowupToday'] = $this->dashboard_model->getTodaysLeadsFollowup($agent_id = "", $limit);
			
			//Itinerary Follow up Today 
			/* $w_iti = array();
			$Andw_iti = "(callType='Picked call' OR callType='Call not picked')";
			$_tow_itiLike = array("nextCallDate" => date('Y-m-d'));
			$data['todayFollowup_iti']	= $this->dashboard_model->getdatafilter("iti_followup", $w_iti, "", $limit, $_tow_itiLike,"", $Andw_iti, "nextCallDate"); */
			
			/*************************************** 
			********Todays Revised Section *********
			****************************************/
			//Total Revised Quotation Sent Today Leads created before today
			$where_rev_Sent = array("lead_created <" => date('Y-m-d'));
			$where_qRevSentLike = array("quotation_sent_date" => date('Y-m-d') );
			$data['pastQuotSentToday']	= $this->dashboard_model->count_all_data("itinerary", $where_rev_Sent, $where_qRevSentLike);
			
			//Approved Revised Itinerary Today
			$where_dc = array('iti_status' => 9, "del_status" => 0 , "lead_created <" => date('Y-m-d') );
			$wItiLike = array("iti_decline_approved_date" => date('Y-m-d') );
			$data['pastApprovedItiToday']	= $this->dashboard_model->count_all_data("itinerary", $where_dc, $wItiLike);
			
			//Approved Revised Itinerary Today
			$where_dc = array('iti_status' => 7, "del_status" => 0 , "lead_created <" => date('Y-m-d') );
			$wItiLike = array("iti_decline_approved_date" => date('Y-m-d') );
			$data['pastDeclineItiToday']	= $this->dashboard_model->count_all_data("itinerary", $where_dc, $wItiLike);
			
			//Total Revised Leads Decline Today 
			$where_dAppr = array('cus_status' => 8, "del_status" => 0, "created <" => date('Y-m-d')  );
			$wDcLike = array("lead_last_followup_date" => date('Y-m-d') );
			$data['pastDecLeadsToday']	= $this->dashboard_model->count_all_data("customers_inquery", $where_dAppr, $wDcLike);
			
			/****************************** 
			* *******Month Section *******
			******************************/
			
			//Get Leads from current month  
			$where_m_leads = array("del_status" => 0, );
			$where_m_like = array("created" => date('Y-m') );
			$data['totalLeadsMonth']	= $this->dashboard_model->count_all_data("customers_inquery", $where_m_leads, $where_m_like);
			
			//Total Unwork Leads This Month 
			$whLeadM = array('cus_status' => 0, "del_status" => 0);
			$wDcLkeM = array( "created" => date('Y-m') , "cus_last_followup_status" => 0  );
			$data['totalUnworkLeadsMonth']	= $this->dashboard_model->count_all_data("customers_inquery", $whLeadM, $wDcLkeM);
			
			//Total Call Picked This Month Leads
			$callType = "Picked call";
			$where_m_aAppr = array('cus_last_followup_status' => $callType, "reopen_by" => 0, "del_status" => 0 , "cus_status !=" => 8 );
			$where_m_picklike = array("lead_last_followup_date" => date('Y-m'), "created" => date('Y-m') );
			$data['totalPickCallsMonth'] = $this->dashboard_model->count_all_data("customers_inquery", $where_m_aAppr, $where_m_picklike);
			
			//Total Call Not Picked This Month Leads
			$callType = "Call not picked";
			$where_mcnp = array('cus_last_followup_status' => $callType, "reopen_by" => 0, "del_status" => 0 );
			$like_m_notPick = array("lead_last_followup_date" => date('Y-m'), "created" => date('Y-m') );
			$data['totalNotPickCallsMonth']	= $this->dashboard_model->count_all_data("customers_inquery", $where_mcnp, $like_m_notPick);
			
			//Total Call Decline This Month Leads 
			$callTypeD = 8;
			$where_m_d = array('cus_status' => 8, "del_status" => 0 );
			$wDcLikeMon = array("lead_last_followup_date" => date('Y-m'), "created" => date('Y-m')  );
			$data['totalDecLeadsMonth']	= $this->dashboard_model->count_all_data("customers_inquery", $where_m_d, $wDcLikeMon);
			
			//Quotation Sent This Month
			$where_mqSent = array("email_count >" => 0, "del_status" => 0, "parent_iti_id" => 0 );
			$where_mqSentLike = array("quotation_sent_date" => date('Y-m'), "lead_created" => date('Y-m') );
			$data['totalQuotSentMonth']	= $this->dashboard_model->count_all_data("itinerary", $where_mqSent, $where_mqSentLike);
			
			//Decline Itinerary This Month
			$where_mdc = array('iti_status' => 7, "del_status" => 0 );
			$wmItiLike = array("iti_decline_approved_date" => date('Y-m'), "lead_created" => date('Y-m') );
			$data['totalDecItiMonth']	= $this->dashboard_model->count_all_data("itinerary", $where_mdc, $wmItiLike);
			
			//Working Itinerary This Month
			$where_dcm = array('iti_status' => 0, "publish_status" => "publish", "del_status" => 0, "parent_iti_id" => 0 );
			$wItiLikem = array("lead_created" => date('Y-m') );
			$data['totalWorkingItiMonth']	= $this->dashboard_model->count_all_data("itinerary", $where_dcm, $wItiLikem);
			
			//Approved Itinerary This Month
			$where_M_dc = array('iti_status' => 9, "del_status" => 0 );
			$wItiLike_M = array("lead_created" => date('Y-m'), "iti_decline_approved_date" => date('Y-m') );
			$data['totalApprovedItiMonth']	= $this->dashboard_model->count_all_data("itinerary", $where_M_dc, $wItiLike_M);
			
			//Total Revised Quotation Sent This Month
			$where_qmSent = array( "parent_iti_id !=" => 0);
			$where_qmSentLike = array("quotation_sent_date" => date('Y-m'), "lead_created" => date('Y-m') );
			$data['totalRevQuotSentMonth']	= $this->dashboard_model->count_all_data("itinerary", $where_qmSent, $where_qmSentLike);
			
			
			/******************************************* 
			********This Month Revised Section *********
			*******************************************/
			//Total Revised Quotation Sent This Month Leads created before This Month
			$where_rev_m_Sent 		= array("lead_created <" => date('Y-m-01'));
			$where_m_qRevSentLike 	= array("quotation_sent_date" => date('Y-m') );
			$data['pastQuotSentMonth']	= $this->dashboard_model->count_all_data("itinerary", $where_rev_m_Sent, $where_m_qRevSentLike);
			
			//Approved Revised Itinerary This Month
			$where_dcm = array('iti_status' => 9, "del_status" => 0 , "lead_created <" => date('Y-m-01') );
			$wItim_Like = array("iti_decline_approved_date" => date('Y-m') );
			$data['pastApprovedItiMonth']	= $this->dashboard_model->count_all_data("itinerary", $where_dcm, $wItim_Like);
			
			//Approved Revised Itinerary This Month
			$where_m_dc = array('iti_status' => 7, "del_status" => 0 , "lead_created <" => date('Y-m-01') );
			$wItiLim_ke = array("iti_decline_approved_date" => date('Y-m') );
			$data['pastDeclineItiMonth']	= $this->dashboard_model->count_all_data("itinerary", $where_m_dc, $wItiLim_ke);
			
			//Total Revised Leads Decline This Month Leads 
			$where_m_dAppr = array( 'cus_status' => 8, "del_status" => 0, "created <" => date("Y-m-01") );
			$wDcLim_ke = array("lead_last_followup_date" => date('Y-m'));
			$data['pastDecLeadsMonth']	= $this->dashboard_model->count_all_data("customers_inquery", $where_m_dAppr, $wDcLim_ke);
			
			/* //Decline Leads of Current Month  
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
			$data['appItiMonth']	= $this->dashboard_model->count_all_data("itinerary", $where_appIti, $where_appItiLike); */
			
			/*****************************
			* *******Price Section *******
			******************************/
			//Itinerary Pending Rates
			$where_pr = array("del_status" => 0);
			$orWhere =( "pending_price = 1 OR discount_rate_request = 1 OR discount_rate_request = 2" );
			$penLike = "";
			$data['itiPendingRates'] = $this->dashboard_model->getdatafilter("itinerary", $where_pr,"pending_price_date", $limit, $penLike,"", $orWhere);
			
			//Itinerary approved Rates limit=5
			$where_Appr = array("pending_price" => 2, "del_status" => 0, 'discount_rate_request' => 0 );
			$where_ApprLike = array("approved_price_date" => date('Y-m-d') );
			$data['itiAppRates'] = $this->dashboard_model->getdatafilter("itinerary", $where_Appr, "approved_price_date", $limit, $where_ApprLike);
			
			
			/*************************************** 
			* *******AMENDMENT PRICE Section *******
			****************************************/
			//Itinerary AMENDMENT Pending Rates
			$data['amendmentPendingRates']	= $this->dashboard_model->get_amendment_pending_price();
			
			//Itinerary AMENDMENT Approved Rates
			$data['amendmentAprRates'] = $this->dashboard_model->get_amendment_approved_price();
			
			//ON HOLD ITINERIES LIST
			//$data["on_hold_itineraries"] = $this->dashboard_model->get_onhold_itieraries_list();
			
			//CHECK TODAY'S CHECKOUT
			$data["todays_checkout"] = $this->dashboard_model->check_todays_checkout_customer();
			
			//IF GM
			//if( is_gm() ){
				//$where = array( 'is_approved_by_gm' => 1, 'del_status' => 0, 'booking_status' => 0 );
				//$data['hotel_pending_booking'] = $this->global_model->getdata( 'hotel_booking', $where , "", "id", 10 );	
				//$data['cab_pending_booking'] = $this->global_model->getdata( 'cab_booking', $where , "", "id", 10 );	
				//$data['vtf_pending_booking'] = $this->global_model->getdata( 'travel_booking', $where , "", "id", 10 );	
			//}
			
			//Itinerary Pending Rates for supermanager
			if( is_super_manager() ){ 
				$where_prm = array("del_status" => 0 );
				$orWhere_p = ( "pending_price = 4 OR discount_rate_request = 2" );
				$pensLike = "";
				$data['itiPendingRates_Manager'] = $this->dashboard_model->getdatafilter("itinerary", $where_prm,"pending_price_date", $limit, $pensLike, "", $orWhere_p);
			}
			
			//if sales manager
			if( is_sales_manager() ){ 
				$data['above_fourty_thousand_wrk_pkg'] = $this->dashboard_model->__check_between_fourty_and_lac_working_packages();
				$data['above_one_lac_wrk_pkg'] = $this->dashboard_model->__check_between_fourty_and_lac_working_packages(">");
			}
			
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('dashboard/manager_dashboard', $data);
			$this->load->view('inc/footer');
		}
		//For service team dashboard
		elseif( $user['role'] == '97' ){
			$limit = 30;
			//Count Pending Payment Today
			$where_payment = array();
			$where_paymentLike = array("next_payment_due_date" => date('Y-m-d') );
			$notLike = array("last_payment_received_date" => date('Y-m-d') );
			//$data['pendingPaymentsToday']	= $this->dashboard_model->count_all_data("iti_payment_details", $where_payment, $where_paymentLike, $notLike);
			
			//Count Payment Received Today
			$where_payment = array();
			$where_paymentLike = array("last_payment_received_date" => date('Y-m-d') );
			//$data['receivedPaymentsToday']	= $this->dashboard_model->count_all_data("iti_payment_details", $where_payment, $where_paymentLike);
			
			
			//Count Pending Payment Month
			$where_paymentLike = array("next_payment_due_date" => date('Y-m') );
			$notLike = array("last_payment_received_date" => date('Y-m') );
			//$data['pendingPaymentsMonth']	= $this->dashboard_model->count_all_data("iti_payment_details", $where_payment, $where_paymentLike, $notLike);
			
			//Count Payment Received Month
			$where_payment = array();
			$where_paymentLike = array("last_payment_received_date" => date('Y-m') );
			//$data['receivedPaymentsMonth']	= $this->dashboard_model->count_all_data("iti_payment_details", $where_payment, $where_paymentLike);
			
			
			//Approved Itinerary Today
			$where_dc = array('iti_status' => 9, "del_status" => 0 );
			$wItiLike = array("iti_decline_approved_date" => date('Y-m-d') );
			$data['totalApprovedItiToday']	= $this->dashboard_model->count_all_data("itinerary", $where_dc, $wItiLike);
			
			//Approved Itinerary This Month
			$where_M_dc = array('iti_status' => 9, "del_status" => 0 );
			$wItiLike_M = array("iti_decline_approved_date" => date('Y-m') );
			$data['totalApprovedItiMonth']	= $this->dashboard_model->count_all_data("itinerary", $where_M_dc, $wItiLike_M);
			
			
			//Get All Advance Payments Pending This Month Counts ( amont recived less than 50% )
			//$data['advance_payment_pending_count']	= $this->dashboard_model->advance_payment_pending_count( "<" );
			
			//Get All Advance Payments Pending This Month Counts ( amont recived less than 50% )
			//$data['balance_payment_pending_count']	= $this->dashboard_model->advance_payment_pending_count( ">=" );
			
			
			//Get Hotel Booking
			//$where1 = array( "del_status" => 0 , "email_count >" => 0, "booking_status" => 0 );
			//$data['hotel_booking'] = $this->global_model->getdata( 'hotel_booking', $where1, "", "", $limit );
			
			//Get approved booking with 50% iti payment received
			//$data['hotel_booking_aprroved'] = $this->dashboard_model->get_approved_hotel_booking($limit);
			
			//Get Cab Booking pendingPaymentsFollow
			//$where2 = array( "del_status" => 0 , "email_count >" => 0 );
			//$data['cab_booking'] = $this->global_model->getdata( 'cab_booking', $where2, "", "", $limit );
			
			//Get approved Cab booking with 50% iti payment received
			//$data['cab_booking_aprroved'] = $this->dashboard_model->get_approved_cab_booking($limit);
			
			//Get Volvo Booking
			//$where3 = array( "del_status" => 0, "booking_type" => "volvo" );
			//$data['volvo_booking'] = $this->global_model->getdata( 'travel_booking', $where3, "", "", $limit );
			
			//Get volvo approved booking having 50% payment received
			//$where_type = "(booking_type='volvo')";
			//$data['volvo_booking_approved'] = $this->dashboard_model->get_approved_vtf_booking( $where_type, $limit );
			
			//Get Train/Flight Booking
			//$where4 = "( booking_type = 'train' OR  booking_type = 'flight' AND del_status = 0 )";
			//$data['train_flight_booking'] = $this->global_model->getdata_where( 'travel_booking', $where4, "", "", $limit );
			
			//Get volvo approved booking having 50% payment received
			//$where_type3 = "(booking_type='train' OR booking_type='flight')";
			//$data['train_flight_booking_approved'] = $this->dashboard_model->get_approved_vtf_booking( $where_type3, $limit );
			
			//Get All Payments details pending today
			//$data['pendingPaymentsFollow']	= $this->dashboard_model->getTodaysPendingPayments( $limit );
			
			//AMENDMENT ITINERARIES
			$data['amendmentItineraries']	= $this->dashboard_model->get_amendment_itineraries("", $limit);
			
			//REFUND PAYMENTS
			//$data['get_refund_payments']	= $this->dashboard_model->get_refund_payments($limit);
			
			//Pending Vouchers
			$data['pending_vouchers']		= $this->dashboard_model->pending_vouchers($limit);
			
			//Confirmed Vouchers
			$data['confirmed_vouchers']		= $this->dashboard_model->confirmed_vouchers($limit);
			
			//dump( $data['pending_vouchers'] ); 
		//	dump( $data['confirmed_vouchers'] ); 
			
		//	die;
			
			
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('dashboard/service_dashboard', $data);
			$this->load->view('inc/footer');
		}elseif( $user['role'] == '96' ){
			
			//if teamleader show all data including teammember
			if( is_teamleader() ){
				$agent_in = is_teamleader();
				array_push($agent_in, $user_id );
			}else{
				$agent_in = array( $user_id );
			}
			
			//picked call and next call
			$limit = 30;
			
			/****************************** 
			* *******Todays Section *******
			******************************/
			$where_in = array( 'agent_id' => $agent_in );
			
			//Total Leads Today 
			$where_leads = array("del_status" => 0, "reopen_by" => 0);
			$where_like = array("created" => date('Y-m-d') );
			$data['totalContLeadsToday']	= $this->dashboard_model->count_all_data("customers_inquery", $where_leads, $where_like, "", $where_in );
			
			//Total Call Picked Today Leads
			$callType = "Picked call";
			$where_aAppr = array('cus_last_followup_status' => $callType, "reopen_by" => 0, "del_status" => 0 );
			$where_appItiLike = array("lead_last_followup_date" => date('Y-m-d'), "created" => date('Y-m-d') );
			$data['totalPickCallsToday'] = $this->dashboard_model->count_all_data("customers_inquery", $where_aAppr, $where_appItiLike, "" , $where_in );
			
			//Total Call Not Picked Today Leads
			$callType = "Call not picked";
			$where_aAppr = array('cus_last_followup_status' => $callType, "reopen_by" => 0, "del_status" => 0 );
			$where_appItiLike = array("lead_last_followup_date" => date('Y-m-d'), "created" => date('Y-m-d') );
			$data['totalNotPickCallsToday']	= $this->dashboard_model->count_all_data("customers_inquery", $where_aAppr, $where_appItiLike, "", $where_in);
			
			//Total Call Decline Today Leads 
			$callTypeD = 8;
			$where_dAppr = array('cus_status' => 8, "del_status" => 0);
			$wDcLike = array("lead_last_followup_date" => date('Y-m-d'), "created" => date('Y-m-d')  );
			$data['totalDecLeadsToday']	= $this->dashboard_model->count_all_data("customers_inquery", $where_dAppr, $wDcLike, "", $where_in);
			
			//Total 	 Today Leads 
			$whLead = array('cus_status' => 0, "del_status" => 0 );
			$wDcLke = array( "created" => date('Y-m-d'), "cus_last_followup_status" => 0   );
			$data['totalUnworkLeadsToday']	= $this->dashboard_model->count_all_data("customers_inquery", $whLead, $wDcLke, "", $where_in);
			
			//Decline Itinerary Today
			$where_dc = array('iti_status' => 7, "del_status" => 0 );
			$wItiLike = array("iti_decline_approved_date" => date('Y-m-d'), "lead_created" => date('Y-m-d') );
			$data['totalDecItiToday']	= $this->dashboard_model->count_all_data("itinerary", $where_dc, $wItiLike, "", $where_in);
			
			//Working Itinerary Today
			$where_dc = array('iti_status' => 0,"publish_status" => "publish", "del_status" => 0, "parent_iti_id" => 0 );
			$wItiLike = array("lead_created" => date('Y-m-d') );
			$data['totalWorkingItiToday']	= $this->dashboard_model->count_all_data("itinerary", $where_dc, $wItiLike, "", $where_in );
			
			//Approved Itinerary Today
			$where_dc = array('iti_status' => 9, "del_status" => 0 );
			$wItiLike = array("lead_created" => date('Y-m-d'), "iti_decline_approved_date" => date('Y-m-d') );
			$data['totalApprovedItiToday']	= $this->dashboard_model->count_all_data("itinerary", $where_dc, $wItiLike, "",$where_in);
			
			//Total Quotation Sent Today
			$where_qSent = array("parent_iti_id" => 0 );
			$where_qSentLike = array("quotation_sent_date" => date('Y-m-d'), "lead_created" => date('Y-m-d') );
			$data['totalQuotSentToday']	= $this->dashboard_model->count_all_data("itinerary", $where_qSent, $where_qSentLike, "", $where_in);
			
			//Total Revised Quotation Sent Today
			$where_qSent = array( "parent_iti_id !=" => 0);
			$where_qSentLike = array("quotation_sent_date" => date('Y-m-d'), "lead_created" => date('Y-m-d') );
			$data['totalRevQuotSentToday']	= $this->dashboard_model->count_all_data("itinerary", $where_qSent, $where_qSentLike, "", $where_in);
			
			//Total Leads Created Today
			$where_addLead = array( "del_status" => 0, "cus_status" => 0 );
			$wleadLike = array("created" => date('Y-m-d') , "cus_last_followup_status" => 0 );
			$data['totalLeadsToday']	= $this->dashboard_model->getdatafilter("customers_inquery", $where_addLead, "customer_id", $limit, $wleadLike, "", "", "", "", $where_in );
			
			//Leads Follow up Today 
			$data['leadsFollowupToday'] = $this->dashboard_model->getTodaysLeadsFollowup($user_id, $limit);
			
			//Itinerary Follow up Today 
		/* 	$w_iti = array('agent_id' => $user_id);
			$Andw_iti = "(callType='Picked call' OR callType='Call not picked')";
			$_tow_itiLike = array("nextCallDate" => date('Y-m-d'));
			$data['todayFollowup_iti']	= $this->dashboard_model->getdatafilter("iti_followup", $w_iti, "", $limit, $_tow_itiLike,"", $Andw_iti, "nextCallDate"); */
			
			/*************************************** 
			* *******Todays Revised Section *******
			****************************************/
			//Total Revised Quotation Sent Today Leads created before today
			$where_rev_Sent = array("lead_created <" => date('Y-m-d'));
			$where_qRevSentLike = array("quotation_sent_date" => date('Y-m-d') );
			$data['pastQuotSentToday']	= $this->dashboard_model->count_all_data("itinerary", $where_rev_Sent, $where_qRevSentLike, "", $where_in);
			
			
			//Approved Revised Itinerary Today
			$where_dc = array('iti_status' => 9, "del_status" => 0 , "lead_created <" => date('Y-m-d') );
			$wItiLike = array("iti_decline_approved_date" => date('Y-m-d') );
			$data['pastApprovedItiToday']	= $this->dashboard_model->count_all_data("itinerary", $where_dc, $wItiLike, "", $where_in);
			
			//Approved Revised Itinerary Today
			$where_dc = array('iti_status' => 7, "del_status" => 0 , "lead_created <" => date('Y-m-d') );
			$wItiLike = array("iti_decline_approved_date" => date('Y-m-d') );
			$data['pastDeclineItiToday']	= $this->dashboard_model->count_all_data("itinerary", $where_dc, $wItiLike, "", $where_in);
			
			//Total Revised Leads Decline Today Leads 
			$where_dAppr = array('cus_status' => 8, "del_status" => 0, "created <" => date('Y-m-d') );
			$wDcLike = array("lead_last_followup_date" => date('Y-m-d') );
			$data['pastDecLeadsToday']	= $this->dashboard_model->count_all_data("customers_inquery", $where_dAppr, $wDcLike, "", $where_in );
			
			/****************************** 
			* *******Month Section *******
			******************************/
			
			//Get Leads from current month  
			$where_m_leads = array("del_status" => 0 );
			$where_m_like = array("created" => date('Y-m') );
			$data['totalLeadsMonth']	= $this->dashboard_model->count_all_data("customers_inquery", $where_m_leads, $where_m_like, "", $where_in);
			
			//Total Unwork Leads This Month 
			$whLeadM = array('cus_status' => 0, "del_status" => 0);
			$wDcLkeM = array( "created" => date('Y-m') , "cus_last_followup_status" => 0   );
			$data['totalUnworkLeadsMonth']	= $this->dashboard_model->count_all_data("customers_inquery", $whLeadM, $wDcLkeM, "", $where_in);
			
			//Total Call Picked This Month Leads
			$callType = "Picked call";
			$where_m_aAppr = array('cus_last_followup_status' => $callType, "reopen_by" => 0, "del_status" => 0,"cus_status !=" => 8);
			$where_m_picklike = array("lead_last_followup_date" => date('Y-m'), "created" => date('Y-m') );
			$data['totalPickCallsMonth'] = $this->dashboard_model->count_all_data("customers_inquery", $where_m_aAppr, $where_m_picklike, "", $where_in);
			
			//Total Call Not Picked This Month Leads
			$callType = "Call not picked";
			$where_mcnp = array('cus_last_followup_status' => $callType, "reopen_by" => 0, "del_status" => 0);
			$like_m_notPick = array("lead_last_followup_date" => date('Y-m'), "created" => date('Y-m') );
			$data['totalNotPickCallsMonth']	= $this->dashboard_model->count_all_data("customers_inquery", $where_mcnp, $like_m_notPick, "", $where_in);
			
			//Total Call Decline This Month Leads 
			$callTypeD = 8;
			$where_m_d = array('cus_status' => 8, "del_status" => 0 );
			$wDcLikeMon = array("lead_last_followup_date" => date('Y-m'), "created" => date('Y-m')  );
			$data['totalDecLeadsMonth']	= $this->dashboard_model->count_all_data("customers_inquery", $where_m_d, $wDcLikeMon, "", $where_in);
			
			//Quotation Sent This Month
			$where_mqSent = array("email_count >" => 0, "del_status" => 0 ,"parent_iti_id" => 0);
			$where_mqSentLike = array("quotation_sent_date" => date('Y-m'), "lead_created" => date('Y-m') );
			$data['totalQuotSentMonth']	= $this->dashboard_model->count_all_data("itinerary", $where_mqSent, $where_mqSentLike, "", $where_in);
			
			//Decline Itinerary This Month
			$where_mdc = array('iti_status' => 7, "del_status" => 0 );
			$wmItiLike = array("iti_decline_approved_date" => date('Y-m'), "lead_created" => date('Y-m') );
			$data['totalDecItiMonth']	= $this->dashboard_model->count_all_data("itinerary", $where_mdc, $wmItiLike, "", $where_in);
			
			//Working Itinerary This Month
			$where_dcm = array('iti_status' => 0, "publish_status" => "publish", "del_status" => 0, "parent_iti_id" => 0 );
			$wItiLikem = array("lead_created" => date('Y-m') );
			$data['totalWorkingItiMonth']	= $this->dashboard_model->count_all_data("itinerary", $where_dcm, $wItiLikem, "", $where_in);
			
			//Approved Itinerary This Month
			$where_M_dc = array('iti_status' => 9, "del_status" => 0 );
			$wItiLike_M = array("lead_created" => date('Y-m'), "iti_decline_approved_date" => date('Y-m') );
			$data['totalApprovedItiMonth']	= $this->dashboard_model->count_all_data("itinerary", $where_M_dc, $wItiLike_M, "", $where_in);
			
			//Total Revised Quotation Sent This Month
			$where_qmSent = array( "parent_iti_id !=" => 0 );
			$where_qmSentLike = array("quotation_sent_date" => date('Y-m'), "lead_created" => date('Y-m') );
			$data['totalRevQuotSentMonth']	= $this->dashboard_model->count_all_data("itinerary", $where_qmSent, $where_qmSentLike, "", $where_in);
			
			
			/******************************************* 
			********This Month Revised Section *********
			*******************************************/
			//Total Revised Quotation Sent This Month Leads created before This Month
			$where_rev_m_Sent = array("lead_created <" => date('Y-m-01') );
			$where_m_qRevSentLike = array("quotation_sent_date" => date('Y-m') );
			$data['pastQuotSentMonth']	= $this->dashboard_model->count_all_data("itinerary", $where_rev_m_Sent, $where_m_qRevSentLike, "", $where_in);
			
			//Approved Revised Itinerary This Month
			$where_dcm = array( 'iti_status' => 9, "del_status" => 0 , "lead_created <" => date('Y-m-01') );
			$wItim_Like = array("iti_decline_approved_date" => date('Y-m') );
			$data['pastApprovedItiMonth']	= $this->dashboard_model->count_all_data("itinerary", $where_dcm, $wItim_Like, "", $where_in);
			
			//Approved Revised Itinerary This Month
			$where_m_dc = array('iti_status' => 7, "del_status" => 0 , "lead_created <" => date('Y-m-01') );
			$wItiLim_ke = array("iti_decline_approved_date" => date('Y-m') );
			$data['pastDeclineItiMonth']	= $this->dashboard_model->count_all_data("itinerary", $where_m_dc, $wItiLim_ke, "", $where_in);
			
			//Total Revised Leads Decline This Month Leads 
			$where_m_dAppr = array( 'cus_status' => 8, "del_status" => 0, "created <" => date("Y-m-01") );
			$wDcLim_ke = array("lead_last_followup_date" => date('Y-m'));
			$data['pastDecLeadsMonth']	= $this->dashboard_model->count_all_data("customers_inquery", $where_m_dAppr, $wDcLim_ke, "", $where_in);
			
			/****************************** 
			* *******Month Section *******
			******************************/
		   /*  //Get Leads from current month  
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
			$data['appItiMonth']	= $this->dashboard_model->count_all_data("itinerary", $where_appIti, $where_appItiLike); */
			
			
			
			/****************************** 
			* *******Price Section *******
			******************************/
			
			//Itinerary Pending Rates limit=5
			$where_pr = array( "del_status" => 0);
			$or_where_pr = ( "pending_price = 1 OR discount_rate_request = 1 OR discount_rate_request = 2" );
			/* $penLike = array("pending_price_date" => date('Y-m') ); */
			$penLike = "";
			$data['itiPendingRates'] = $this->dashboard_model->getdatafilter("itinerary", $where_pr, "pending_price_date", $limit, $penLike,"",$or_where_pr, "", "", $where_in );
			
			//Itinerary approved Rates limit=5
			$where_Appr = array("pending_price" => 2, "del_status" => 0, "discount_rate_request" => 0 );
			$where_ApprLike = array("approved_price_date" => date('Y-m-d') );
			$data['itiAppRates']	= $this->dashboard_model->getdatafilter( "itinerary", $where_Appr, "approved_price_date", $limit,$where_ApprLike, "", "", "", "", $where_in );
			
			/*************************************** 
			* *******AMENDMENT PRICE Section *******
			****************************************/
			//Itinerary AMENDMENT Pending Rates
			$data['amendmentPendingRates']	= $this->dashboard_model->get_amendment_pending_price($agent_in);
			
			//Itinerary AMENDMENT Approved Rates
			$data['amendmentAprRates'] = $this->dashboard_model->get_amendment_approved_price($agent_in);
			
			
			//ON HOLD ITINERIES LIST
			$data["on_hold_itineraries"] = $this->dashboard_model->get_onhold_itieraries_list($agent_in);
			
			//CHECK TODAY'S CHECKOUT
			$data["todays_checkout"] = $this->dashboard_model->check_todays_checkout_customer( $agent_in );
			
			//check if team leader
			if( is_teamleader() ){
				$teammem = is_teamleader();
				$where_agent_in = !empty($teammem) ? implode(",", $teammem) : $user_id;
				$data['above_fourty_thousand_wrk_pkg'] = $this->dashboard_model->__check_between_fourty_and_lac_working_packages();
				$data['above_one_lac_wrk_pkg'] = $this->dashboard_model->__check_between_fourty_and_lac_working_packages(">", $where_agent_in );
				
				//pending price by teammbers
				$agents_in = !empty($teammem) ? implode(",", $teammem) : "";
				$data["iti_team_members_pendingRates"] = $this->dashboard_model->get_teammembers_pending_price_request( $agents_in, 15 );
			}
			
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('dashboard/sales_dashboard', $data);
			$this->load->view('inc/footer');
		}elseif( $user['role'] == '95' ){
			$data["leads"] = "Leads Team Dashboard";
			//Total Leads declined today
			$where_dAppr = array('cus_status' => 8, "del_status" => 0 );
			$wDcLike = array("lead_last_followup_date" => date("Y-m-d") );
			$data['leads_declined_today']	= $this->dashboard_model->count_all_data("customers_inquery", $where_dAppr, $wDcLike);
			
			//Total Leads declined this month
			$whe_lead = array('cus_status' => 8, "del_status" => 0 );
			$whe_like = array("lead_last_followup_date" => date("Y-m") );
			$data['leads_declined_month']	= $this->dashboard_model->count_all_data("customers_inquery", $whe_lead, $whe_like);
			
			//Decline Itinerary Today
			$where_dc = array( 'iti_status' => 7, "del_status" => 0 );
			$wItiLike = array("iti_decline_approved_date" => date('Y-m-d') );
			$data['totalDecItiToday']	= $this->dashboard_model->count_all_data("itinerary", $where_dc, $wItiLike);
			
			//Decline Itinerary This Month
			$where_mdc = array('iti_status' => 7, "del_status" => 0 );
			$wmItiLike = array("iti_decline_approved_date" => date('Y-m') );
			$data['totalDecItiMonth']	= $this->dashboard_model->count_all_data("itinerary", $where_mdc, $wmItiLike);
			
			//Marketing User Created Today
			$m_user = array("del_status" => 0 );
			$m_like = array("created" => date("Y-m-d") );
			$data['marketing_user_today']	= $this->dashboard_model->count_all_data("marketing", $m_user, $m_like);
			
			//Marketing User Created This Month
			$m_user = array("del_status" => 0 );
			$m_like = array("created" => date("Y-m") );
			$data['marketing_user_month']	= $this->dashboard_model->count_all_data("marketing", $m_user, $m_like);
			
			
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('dashboard/leads_dashboard', $data);
			$this->load->view('inc/footer');
		}else if( $user['role'] == '94' ){
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('dashboard/lead_agent_dashboard', $data);
			$this->load->view('inc/footer');
		}else if( $user['role'] == '93' ){ //Accounts Team
		
			$limit = 30;
			//Count Pending Payment Today
			$where_payment = array();
			$where_paymentLike = array("next_payment_due_date" => date('Y-m-d') );
			$notLike = array("last_payment_received_date" => date('Y-m-d') );
			$data['pendingPaymentsToday']	= $this->dashboard_model->count_all_data("iti_payment_details", $where_payment, $where_paymentLike, $notLike);
			
			//Count Payment Received Today
			$where_payment = array();
			$where_paymentLike = array("last_payment_received_date" => date('Y-m-d') );
			$data['receivedPaymentsToday']	= $this->dashboard_model->count_all_data("iti_payment_details", $where_payment, $where_paymentLike);
			
			
			//Count Pending Payment Month
			$where_paymentLike = array("next_payment_due_date" => date('Y-m') );
			$notLike = array("last_payment_received_date" => date('Y-m') );
			$data['pendingPaymentsMonth']	= $this->dashboard_model->count_all_data("iti_payment_details", $where_payment, $where_paymentLike, $notLike);
			
			//Count Payment Received Month
			$where_payment = array();
			$where_paymentLike = array("last_payment_received_date" => date('Y-m') );
			$data['receivedPaymentsMonth']	= $this->dashboard_model->count_all_data("iti_payment_details", $where_payment, $where_paymentLike);
			
			
			//Approved Itinerary Today
			//$where_dc = array('iti_status' => 9, "del_status" => 0 );
			//$wItiLike = array("iti_decline_approved_date" => date('Y-m-d') );
			$todaya = date('Y-m-d');
			$data['totalApprovedItiToday']	= $this->dashboard_model->count_all_iti_booked($todaya);
			
			//Approved Itinerary This Month
			//$where_M_dc = array('iti_status' => 9, "del_status" => 0 );
			//$wItiLike_M = array("iti_decline_approved_date" => date('Y-m') );
			$thism = date('Y-m');
			$data['totalApprovedItiMonth']	= $this->dashboard_model->count_all_iti_booked( $thism );
			
			
			//Get All Advance Payments Pending This Month Counts ( amont recived less than 50% )
			$data['advance_payment_pending_count']	= $this->dashboard_model->advance_payment_pending_count( "<" );
			
			//Get All Advance Payments Pending This Month Counts ( amont recived less than 50% )
			$data['balance_payment_pending_count']	= $this->dashboard_model->advance_payment_pending_count( ">=" );
			
			//Get All Payments details pending today
			$data['pendingPaymentsFollow']	= $this->dashboard_model->getTodaysPendingPayments( $limit );
			
			//REFUND PAYMENTS
			$data['get_refund_payments']	= $this->dashboard_model->get_refund_payments($limit);
			
			//AMENDMENT ITINERARIES
			$data['amendmentItineraries']	= $this->dashboard_model->get_amendment_itineraries("", $limit);
			
			//TODAY PAYMENT RECIEVED
			$where_pay = array('t_response_code' => 1);
			$pay_like = array('trans_date' => date("Y-m-d") );
			$data['todayPaymentReceived']	= $this->dashboard_model->getdatafilter("ac_online_transactions", $where_pay, "id", $limit, $pay_like);
			
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('dashboard/accounts_team_dashboard', $data);
			$this->load->view('inc/footer');
			
		}else{
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('dashboard/default_dashboard', $data);
			$this->load->view('inc/footer');
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
				$date = isset($_GET['date']) && !empty( $_GET['date'] ) ? $_GET['date'] : date("Y-m-d");
				//check user role if not sales team redirect
				$user_role = get_user_role_by_id( $uid );
				
				if( $user_role == 96 ){
					$this->_sales_team_dashboard( $uid, $date );
				}else{
					redirect("dashboard/user_dashboard");
				}
				
			}else{
				
				$where = array("del_status" => 0, "user_type" => 96, "user_status" => "active" );
				$order = array("user_name" => "ASC");
				$all_users	 = $this->login_model->get_data( "users", $where, $order );
				
				$where_manager = array("del_status" => 0, "user_type" => 98, "user_status" => "active" );
				$all_manager = $this->login_model->get_data( "users", $where_manager, $order );
				$data['sales_team_users']	 = $all_users;
				$data['managers'] = $all_manager;
				$this->load->view('inc/header');
				$this->load->view('inc/sidebar');
				$this->load->view('dashboard/admin_sales_dashboard', $data);
				$this->load->view('inc/footer');
			}	
		}else if( is_teamleader() ){
			$team_leader = is_teamleader();
			if( isset( $_GET['user_id'] ) && !empty( $_GET['user_id'] ) ){
				$uid = $_GET['user_id'];
				$date = isset($_GET['date']) && !empty( $_GET['date'] ) ? $_GET['date'] : date("Y-m-d");
				//check user role if not sales team redirect
				$user_role = get_user_role_by_id( $uid );
				if( $user_role == 96 &&  in_array($uid, $team_leader) ){
					$this->_sales_team_dashboard( $uid, $date );
				}else{
					redirect("dashboard/user_dashboard");
				}
			}
		}else{
			redirect("dashboard");
		}	
	}
	
	//get sales team dashboard
	private function _sales_team_dashboard( $user_id, $date ){
		$user_id = trim( $user_id );
		//picked call and next call
		$data["sales_user_id"] = $user_id;
		$limit = 20;
		//get all sales team users
		$where = array("del_status" => 0, "user_type" => 96 , "user_status" => "active" );
		$order = array("user_name" => "ASC");
		$all_users	 = $this->login_model->get_data( "users", $where, $order );
		$data['users_data'] = $all_users;
		
		/****************************** 
		********Todays Section *******
		******************************/
		
		//Total Call Picked Today Leads
		$callType = "Picked call";
		$where_aAppr = array('agent_id' => $user_id, 'cus_last_followup_status' => $callType, "reopen_by" => 0, "del_status" => 0 );
		$where_appItiLike = array("lead_last_followup_date" => $date, "created" => $date );
		$data['totalPickCallsToday'] = $this->dashboard_model->count_all_data("customers_inquery", $where_aAppr, $where_appItiLike);
		
		//Total Call Not Picked Today Leads
		$callType = "Call not picked";
		$where_aAppr = array('agent_id' => $user_id, 'cus_last_followup_status' => $callType, "reopen_by" => 0, "del_status" => 0 );
		$where_appItiLike = array("lead_last_followup_date" => $date, "created" => $date );
		$data['totalNotPickCallsToday']	= $this->dashboard_model->count_all_data("customers_inquery", $where_aAppr, $where_appItiLike);
		
		//Total Leads Today 
		$where_leads = array("del_status" => 0,"reopen_by" => 0, 'agent_id' => $user_id);
		$where_like = array("created" => $date );
		$data['totalContLeadsToday']	= $this->dashboard_model->count_all_data("customers_inquery", $where_leads, $where_like);
		
		
		//Total Call Decline Today Leads 
		$callTypeD = 8;
		$where_dAppr = array('cus_status' => 8, "del_status" => 0, 'agent_id' => $user_id );
		$wDcLike = array("lead_last_followup_date" => $date, "created" => $date  );
		$data['totalDecLeadsToday']	= $this->dashboard_model->count_all_data("customers_inquery", $where_dAppr, $wDcLike);
		
		//Total 	 Today Leads 
		$whLead = array('cus_status' => 0, "del_status" => 0, 'agent_id' => $user_id );
		$wDcLke = array( "created" => $date, "cus_last_followup_status" => 0   );
		$data['totalUnworkLeadsToday']	= $this->dashboard_model->count_all_data("customers_inquery", $whLead, $wDcLke);
		
		//Decline Itinerary Today
		$where_dc = array('iti_status' => 7, "del_status" => 0 , 'agent_id' => $user_id);
		$wItiLike = array("iti_decline_approved_date" => $date, "lead_created" => $date );
		$data['totalDecItiToday']	= $this->dashboard_model->count_all_data("itinerary", $where_dc, $wItiLike);
		
		//Working Itinerary Today
		$where_dc = array('iti_status' => 0,"publish_status" => "publish", "del_status" => 0, "parent_iti_id" => 0, 'agent_id' => $user_id );
		$wItiLike = array("lead_created" => $date );
		$data['totalWorkingItiToday']	= $this->dashboard_model->count_all_data("itinerary", $where_dc, $wItiLike);
		
		//Approved Itinerary Today
		$where_dc = array('iti_status' => 9, "del_status" => 0, 'agent_id' => $user_id );
		$wItiLike = array("lead_created" => $date, "iti_decline_approved_date" => $date );
		$data['totalApprovedItiToday']	= $this->dashboard_model->count_all_data("itinerary", $where_dc, $wItiLike);
		
		//Total Quotation Sent Today
		$where_qSent = array('agent_id' => $user_id, "parent_iti_id" => 0 );
		$where_qSentLike = array("quotation_sent_date" => $date, "lead_created" => $date );
		$data['totalQuotSentToday']	= $this->dashboard_model->count_all_data("itinerary", $where_qSent, $where_qSentLike);
		
		//Total Revised Quotation Sent Today
		$where_qSent = array( "parent_iti_id !=" => 0, 'agent_id' => $user_id);
		$where_qSentLike = array("quotation_sent_date" => $date, "lead_created" => $date );
		$data['totalRevQuotSentToday']	= $this->dashboard_model->count_all_data("itinerary", $where_qSent, $where_qSentLike);
		
		//Total Leads Created Today
		$where_addLead = array( "del_status" => 0, "cus_status" => 0, 'agent_id' => $user_id );
		$wleadLike = array("created" => $date , "cus_last_followup_status" => 0 );
		$data['totalLeadsToday']	= $this->dashboard_model->getdatafilter("customers_inquery", $where_addLead, "customer_id", $limit, $wleadLike);
		
		//Leads Follow up Today 
		$data['leadsFollowupToday'] = $this->dashboard_model->getTodaysLeadsFollowup($user_id, $limit, $date );
		
		//Itinerary Follow up Today 
		/* 	$w_iti = array('agent_id' => $user_id);
			$Andw_iti = "(callType='Picked call' OR callType='Call not picked')";
			$_tow_itiLike = array("nextCallDate" => date('Y-m-d'));
			$data['todayFollowup_iti']	= $this->dashboard_model->getdatafilter("iti_followup", $w_iti, "", $limit, $_tow_itiLike,"", $Andw_iti, "nextCallDate"); */
			
			/*************************************** 
			* *******Todays Revised Section *******
			****************************************/
			//Total Revised Quotation Sent Today Leads created before today
			$where_rev_Sent = array("lead_created <" => $date, 'agent_id' => $user_id);
			$where_qRevSentLike = array("quotation_sent_date" => $date );
			$data['pastQuotSentToday']	= $this->dashboard_model->count_all_data("itinerary", $where_rev_Sent, $where_qRevSentLike);
			
			
			//Approved Revised Itinerary Today
			$where_dc = array('iti_status' => 9, "del_status" => 0 , "lead_created <" => $date, 'agent_id' => $user_id );
			$wItiLike = array("iti_decline_approved_date" => $date );
			$data['pastApprovedItiToday']	= $this->dashboard_model->count_all_data("itinerary", $where_dc, $wItiLike);
			
			//Approved Revised Itinerary Today
			$where_dc = array('iti_status' => 7, "del_status" => 0 , "lead_created <" => $date , 'agent_id' => $user_id);
			$wItiLike = array("iti_decline_approved_date" => $date );
			$data['pastDeclineItiToday']	= $this->dashboard_model->count_all_data("itinerary", $where_dc, $wItiLike);
			
			//Total Revised Leads Decline Today Leads 
			$where_dAppr = array('cus_status' => 8, "del_status" => 0, "created <" => $date , 'agent_id' => $user_id );
			$wDcLike = array("lead_last_followup_date" => $date );
			$data['pastDecLeadsToday']	= $this->dashboard_model->count_all_data("customers_inquery", $where_dAppr, $wDcLike);
			
			/****************************** 
			* *******Month Section *******
			******************************/
			
			//Get Leads from current month  
			$where_m_leads = array("del_status" => 0,'agent_id' => $user_id );
			$where_m_like = array("created" => date('Y-m') );
			$data['totalLeadsMonth']	= $this->dashboard_model->count_all_data("customers_inquery", $where_m_leads, $where_m_like);
			
			//Total Unwork Leads This Month 
			$whLeadM = array('cus_status' => 0, "del_status" => 0, 'agent_id' => $user_id);
			$wDcLkeM = array( "created" => date('Y-m') , "cus_last_followup_status" => 0   );
			$data['totalUnworkLeadsMonth']	= $this->dashboard_model->count_all_data("customers_inquery", $whLeadM, $wDcLkeM);
			
			//Total Call Picked This Month Leads
			$callType = "Picked call";
			$where_m_aAppr = array('cus_last_followup_status' => $callType, "reopen_by" => 0, "del_status" => 0,'agent_id' => $user_id , "cus_status !=" => 8);
			$where_m_picklike = array("lead_last_followup_date" => date('Y-m'), "created" => date('Y-m') );
			$data['totalPickCallsMonth'] = $this->dashboard_model->count_all_data("customers_inquery", $where_m_aAppr, $where_m_picklike);
			
			//Total Call Not Picked This Month Leads
			$callType = "Call not picked";
			$where_mcnp = array('cus_last_followup_status' => $callType, "reopen_by" => 0, "del_status" => 0 ,'agent_id' => $user_id);
			$like_m_notPick = array("lead_last_followup_date" => date('Y-m'), "created" => date('Y-m') );
			$data['totalNotPickCallsMonth']	= $this->dashboard_model->count_all_data("customers_inquery", $where_mcnp, $like_m_notPick);
			
			//Total Call Decline This Month Leads 
			$callTypeD = 8;
			$where_m_d = array('cus_status' => 8, "del_status" => 0 ,'agent_id' => $user_id);
			$wDcLikeMon = array("lead_last_followup_date" => date('Y-m'), "created" => date('Y-m')  );
			$data['totalDecLeadsMonth']	= $this->dashboard_model->count_all_data("customers_inquery", $where_m_d, $wDcLikeMon);
			
			//Quotation Sent This Month
			$where_mqSent = array("email_count >" => 0, "del_status" => 0 ,'agent_id' => $user_id, "parent_iti_id" => 0);
			$where_mqSentLike = array("quotation_sent_date" => date('Y-m'), "lead_created" => date('Y-m') );
			$data['totalQuotSentMonth']	= $this->dashboard_model->count_all_data("itinerary", $where_mqSent, $where_mqSentLike);
			
			//Decline Itinerary This Month
			$where_mdc = array('iti_status' => 7, "del_status" => 0 ,'agent_id' => $user_id);
			$wmItiLike = array("iti_decline_approved_date" => date('Y-m'), "lead_created" => date('Y-m') );
			$data['totalDecItiMonth']	= $this->dashboard_model->count_all_data("itinerary", $where_mdc, $wmItiLike);
			
			//Working Itinerary This Month
			$where_dcm = array('iti_status' => 0, "publish_status" => "publish", "del_status" => 0, "parent_iti_id" => 0 ,'agent_id' => $user_id);
			$wItiLikem = array("lead_created" => date('Y-m') );
			$data['totalWorkingItiMonth']	= $this->dashboard_model->count_all_data("itinerary", $where_dcm, $wItiLikem);
			
			//Approved Itinerary This Month
			$where_M_dc = array('iti_status' => 9, "del_status" => 0 ,'agent_id' => $user_id);
			$wItiLike_M = array("lead_created" => date('Y-m'), "iti_decline_approved_date" => date('Y-m') );
			$data['totalApprovedItiMonth']	= $this->dashboard_model->count_all_data("itinerary", $where_M_dc, $wItiLike_M);
			
			//Total Revised Quotation Sent This Month
			$where_qmSent = array( "parent_iti_id !=" => 0 ,'agent_id' => $user_id);
			$where_qmSentLike = array("quotation_sent_date" => date('Y-m'), "lead_created" => date('Y-m') );
			$data['totalRevQuotSentMonth']	= $this->dashboard_model->count_all_data("itinerary", $where_qmSent, $where_qmSentLike);
			
			
			/******************************************* 
			********This Month Revised Section *********
			*******************************************/
			//Total Revised Quotation Sent This Month Leads created before This Month
			$where_rev_m_Sent = array("lead_created <" => date('Y-m-01') ,'agent_id' => $user_id);
			$where_m_qRevSentLike = array("quotation_sent_date" => date('Y-m') );
			$data['pastQuotSentMonth']	= $this->dashboard_model->count_all_data("itinerary", $where_rev_m_Sent, $where_m_qRevSentLike);
			
			//Approved Revised Itinerary This Month
			$where_dcm = array('iti_status' => 9, "del_status" => 0 , "lead_created <" => date('Y-m-01'),'agent_id' => $user_id );
			$wItim_Like = array("iti_decline_approved_date" => date('Y-m') );
			$data['pastApprovedItiMonth']	= $this->dashboard_model->count_all_data("itinerary", $where_dcm, $wItim_Like);
			
			//Approved Revised Itinerary This Month
			$where_m_dc = array('iti_status' => 7, "del_status" => 0 , "lead_created <" => date('Y-m-01'),'agent_id' => $user_id );
			$wItiLim_ke = array("iti_decline_approved_date" => date('Y-m') );
			$data['pastDeclineItiMonth']	= $this->dashboard_model->count_all_data("itinerary", $where_m_dc, $wItiLim_ke);
			
			//Total Revised Leads Decline This Month Leads 
			$where_m_dAppr = array( 'cus_status' => 8, "del_status" => 0, "created <" => date("Y-m-01") ,'agent_id' => $user_id);
			$wDcLim_ke = array("lead_last_followup_date" => date('Y-m'));
			$data['pastDecLeadsMonth']	= $this->dashboard_model->count_all_data("customers_inquery", $where_m_dAppr, $wDcLim_ke);
			
			/****************************** 
			* *******Month Section *******
			******************************/
		   /*  //Get Leads from current month  
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
			$data['appItiMonth']	= $this->dashboard_model->count_all_data("itinerary", $where_appIti, $where_appItiLike); */
			
			
			
			/****************************** 
			* *******Price Section *******
			******************************/
			
			//Itinerary Pending Rates limit=5
			$where_pr = array('agent_id' => $user_id, "del_status" => 0);
			$or_where_pr = ( "pending_price = 1 OR discount_rate_request = 1 OR discount_rate_request = 2" );
			/* $penLike = array("pending_price_date" => date('Y-m') ); */
			$penLike = "";
			$data['itiPendingRates']	= $this->dashboard_model->getdatafilter("itinerary", $where_pr, "pending_price_date", $limit, $penLike, "",$or_where_pr);
			
			//Itinerary approved Rates limit=5
			$where_Appr = array('agent_id' => $user_id,"pending_price" => 2, "del_status" => 0,"discount_rate_request" => 0);
			$where_ApprLike = array("approved_price_date" => date('Y-m-d') );
			$data['itiAppRates']	= $this->dashboard_model->getdatafilter( "itinerary", $where_Appr, "approved_price_date", $limit,$where_ApprLike );
			
			/*************************************** 
			* *******AMENDMENT PRICE Section *******
			****************************************/
			//Itinerary AMENDMENT Pending Rates
			$data['amendmentPendingRates']	= $this->dashboard_model->get_amendment_pending_price( array($user_id) );
			
			//Itinerary AMENDMENT Approved Rates
			$data['amendmentAprRates'] = $this->dashboard_model->get_amendment_approved_price( array($user_id) );
			
		
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('dashboard/sales_team_user_dashboard', $data);
			$this->load->view('inc/footer');
	}
	
	private function _manager_dashboard( $user_id ){
		//picked call and next call
			$limit = 30;
			
			/****************************** 
			* *******Todays Section *******
			******************************/
			
			//Total Leads Created Today 
			$where_leads = array("del_status" => 0,"reopen_by" => 0);
			$where_like = array("created" => date('Y-m-d') );
			$data['totalContLeadsToday']	= $this->dashboard_model->count_all_data("customers_inquery", $where_leads, $where_like);
			
			//Total Call Picked Today Leads
			$callType = "Picked call";
			$where_aAppr = array('cus_last_followup_status' => $callType, "reopen_by" => 0, "del_status" => 0 );
			$where_appItiLike = array("lead_last_followup_date" => date('Y-m-d'), "created" => date('Y-m-d') );
			$data['totalPickCallsToday'] = $this->dashboard_model->count_all_data("customers_inquery", $where_aAppr, $where_appItiLike);
			
			//Total Call Not Picked Today Leads
			$callType = "Call not picked";
			$where_aAppr = array('cus_last_followup_status' => $callType, "reopen_by" => 0, "del_status" => 0 );
			$where_appItiLike = array("lead_last_followup_date" => date('Y-m-d'), "created" => date('Y-m-d') );
			$data['totalNotPickCallsToday']	= $this->dashboard_model->count_all_data("customers_inquery", $where_aAppr, $where_appItiLike);
			
			//Total Call Decline Today Leads 
			$callTypeD = 8;
			$where_dAppr = array('cus_status' => 8, "del_status" => 0 );
			$wDcLike = array("lead_last_followup_date" => date('Y-m-d'), "created" => date('Y-m-d')  );
			$data['totalDecLeadsToday']	= $this->dashboard_model->count_all_data("customers_inquery", $where_dAppr, $wDcLike);
			
			//Total Unwork Today Leads 
			$whLead = array('cus_status' => 0, "del_status" => 0 );
			$wDcLke = array( "created" => date('Y-m-d'), "cus_last_followup_status" => 0   );
			$data['totalUnworkLeadsToday']	= $this->dashboard_model->count_all_data("customers_inquery", $whLead, $wDcLke);
			
			//Total Quotation Sent Today
			$where_qSent = array("parent_iti_id" => 0);
			$where_qSentLike = array("quotation_sent_date" => date('Y-m-d'), "lead_created" => date('Y-m-d') );
			$data['totalQuotSentToday']	= $this->dashboard_model->count_all_data("itinerary", $where_qSent, $where_qSentLike);
			
			//Decline Itinerary Today
			$where_dc = array('iti_status' => 7, "del_status" => 0 );
			$wItiLike = array("iti_decline_approved_date" => date('Y-m-d'), "lead_created" => date('Y-m-d') );
			$data['totalDecItiToday']	= $this->dashboard_model->count_all_data("itinerary", $where_dc, $wItiLike);
			
			//Working Itinerary Today
			$where_dc = array('iti_status' => 0, "publish_status" => "publish", "del_status" => 0, "parent_iti_id" => 0 );
			$wItiLike = array("lead_created" => date('Y-m-d') );
			$data['totalWorkingItiToday']	= $this->dashboard_model->count_all_data("itinerary", $where_dc, $wItiLike);
			
			//Approved Itinerary Today
			$where_dc = array('iti_status' => 9, "del_status" => 0 );
			$wItiLike = array("lead_created" => date('Y-m-d'), "iti_decline_approved_date" => date('Y-m-d') );
			$data['totalApprovedItiToday']	= $this->dashboard_model->count_all_data("itinerary", $where_dc, $wItiLike);
			
			//Total Revised Quotation Sent Today
			$where_qSent = array( "parent_iti_id !=" => 0 );
			$where_qSentLike = array("quotation_sent_date" => date('Y-m-d'), "lead_created" => date('Y-m-d') );
			$data['totalRevQuotSentToday']	= $this->dashboard_model->count_all_data("itinerary", $where_qSent, $where_qSentLike);
			
			//Total Leads Data Created Today
			$where_addLead = array( "del_status" => 0, "cus_status" => 0 );
			$wleadLike = array("created" => date('Y-m-d') , "cus_last_followup_status" => 0 );
			$data['totalLeadsToday']	= $this->dashboard_model->getdatafilter("customers_inquery", $where_addLead, "customer_id", $limit, $wleadLike);
			
			//Leads Follow up Today 
			$data['leadsFollowupToday'] = $this->dashboard_model->getTodaysLeadsFollowup($agent_id = "", $limit);
			
			//Itinerary Follow up Today 
			/* $w_iti = array();
			$Andw_iti = "(callType='Picked call' OR callType='Call not picked')";
			$_tow_itiLike = array("nextCallDate" => date('Y-m-d'));
			$data['todayFollowup_iti']	= $this->dashboard_model->getdatafilter("iti_followup", $w_iti, "", $limit, $_tow_itiLike,"", $Andw_iti, "nextCallDate"); */
			
			/*************************************** 
			********Todays Revised Section *********
			****************************************/
			//Total Revised Quotation Sent Today Leads created before today
			$where_rev_Sent = array("lead_created <" => date('Y-m-d'));
			$where_qRevSentLike = array("quotation_sent_date" => date('Y-m-d') );
			$data['pastQuotSentToday']	= $this->dashboard_model->count_all_data("itinerary", $where_rev_Sent, $where_qRevSentLike);
			
			//Approved Revised Itinerary Today
			$where_dc = array('iti_status' => 9, "del_status" => 0 , "lead_created <" => date('Y-m-d') );
			$wItiLike = array("iti_decline_approved_date" => date('Y-m-d') );
			$data['pastApprovedItiToday']	= $this->dashboard_model->count_all_data("itinerary", $where_dc, $wItiLike);
			
			//Approved Revised Itinerary Today
			$where_dc = array('iti_status' => 7, "del_status" => 0 , "lead_created <" => date('Y-m-d') );
			$wItiLike = array("iti_decline_approved_date" => date('Y-m-d') );
			$data['pastDeclineItiToday']	= $this->dashboard_model->count_all_data("itinerary", $where_dc, $wItiLike);
			
			//Total Revised Leads Decline Today 
			$where_dAppr = array('cus_status' => 8, "del_status" => 0, "created <" => date('Y-m-d')  );
			$wDcLike = array("lead_last_followup_date" => date('Y-m-d') );
			$data['pastDecLeadsToday']	= $this->dashboard_model->count_all_data("customers_inquery", $where_dAppr, $wDcLike);
			
			/****************************** 
			* *******Month Section *******
			******************************/
			
			//Get Leads from current month  
			$where_m_leads = array("del_status" => 0, );
			$where_m_like = array("created" => date('Y-m') );
			$data['totalLeadsMonth']	= $this->dashboard_model->count_all_data("customers_inquery", $where_m_leads, $where_m_like);
			
			//Total Unwork Leads This Month 
			$whLeadM = array('cus_status' => 0, "del_status" => 0);
			$wDcLkeM = array( "created" => date('Y-m') , "cus_last_followup_status" => 0  );
			$data['totalUnworkLeadsMonth']	= $this->dashboard_model->count_all_data("customers_inquery", $whLeadM, $wDcLkeM);
			
			//Total Call Picked This Month Leads
			$callType = "Picked call";
			$where_m_aAppr = array('cus_last_followup_status' => $callType, "reopen_by" => 0, "del_status" => 0 , "cus_status !=" => 8);
			$where_m_picklike = array("lead_last_followup_date" => date('Y-m'), "created" => date('Y-m') );
			$data['totalPickCallsMonth'] = $this->dashboard_model->count_all_data("customers_inquery", $where_m_aAppr, $where_m_picklike);
			
			//Total Call Not Picked This Month Leads
			$callType = "Call not picked";
			$where_mcnp = array('cus_last_followup_status' => $callType, "reopen_by" => 0, "del_status" => 0 );
			$like_m_notPick = array("lead_last_followup_date" => date('Y-m'), "created" => date('Y-m') );
			$data['totalNotPickCallsMonth']	= $this->dashboard_model->count_all_data("customers_inquery", $where_mcnp, $like_m_notPick);
			
			//Total Call Decline This Month Leads 
			$callTypeD = 8;
			$where_m_d = array('cus_status' => 8, "del_status" => 0 );
			$wDcLikeMon = array("lead_last_followup_date" => date('Y-m'), "created" => date('Y-m')  );
			$data['totalDecLeadsMonth']	= $this->dashboard_model->count_all_data("customers_inquery", $where_m_d, $wDcLikeMon);
			
			//Quotation Sent This Month
			$where_mqSent = array("email_count >" => 0, "del_status" => 0, "parent_iti_id" => 0 );
			$where_mqSentLike = array("quotation_sent_date" => date('Y-m'), "lead_created" => date('Y-m') );
			$data['totalQuotSentMonth']	= $this->dashboard_model->count_all_data("itinerary", $where_mqSent, $where_mqSentLike);
			
			//Decline Itinerary This Month
			$where_mdc = array('iti_status' => 7, "del_status" => 0 );
			$wmItiLike = array("iti_decline_approved_date" => date('Y-m'), "lead_created" => date('Y-m') );
			$data['totalDecItiMonth']	= $this->dashboard_model->count_all_data("itinerary", $where_mdc, $wmItiLike);
			
			//Working Itinerary This Month
			$where_dcm = array('iti_status' => 0, "publish_status" => "publish", "del_status" => 0, "parent_iti_id" => 0 );
			$wItiLikem = array("lead_created" => date('Y-m') );
			$data['totalWorkingItiMonth']	= $this->dashboard_model->count_all_data("itinerary", $where_dcm, $wItiLikem);
			
			//Approved Itinerary This Month
			$where_M_dc = array('iti_status' => 9, "del_status" => 0 );
			$wItiLike_M = array("lead_created" => date('Y-m'), "iti_decline_approved_date" => date('Y-m') );
			$data['totalApprovedItiMonth']	= $this->dashboard_model->count_all_data("itinerary", $where_M_dc, $wItiLike_M);
			
			//Total Revised Quotation Sent This Month
			$where_qmSent = array( "parent_iti_id !=" => 0);
			$where_qmSentLike = array("quotation_sent_date" => date('Y-m'), "lead_created" => date('Y-m') );
			$data['totalRevQuotSentMonth']	= $this->dashboard_model->count_all_data("itinerary", $where_qmSent, $where_qmSentLike);
			
			
			/******************************************* 
			********This Month Revised Section *********
			*******************************************/
			//Total Revised Quotation Sent This Month Leads created before This Month
			$where_rev_m_Sent 		= array("lead_created <" => date('Y-m-01'));
			$where_m_qRevSentLike 	= array("quotation_sent_date" => date('Y-m') );
			$data['pastQuotSentMonth']	= $this->dashboard_model->count_all_data("itinerary", $where_rev_m_Sent, $where_m_qRevSentLike);
			
			//Approved Revised Itinerary This Month
			$where_dcm = array('iti_status' => 9, "del_status" => 0 , "lead_created <" => date('Y-m-01') );
			$wItim_Like = array("iti_decline_approved_date" => date('Y-m') );
			$data['pastApprovedItiMonth']	= $this->dashboard_model->count_all_data("itinerary", $where_dcm, $wItim_Like);
			
			//Approved Revised Itinerary This Month
			$where_m_dc = array('iti_status' => 7, "del_status" => 0 , "lead_created <" => date('Y-m-01') );
			$wItiLim_ke = array("iti_decline_approved_date" => date('Y-m') );
			$data['pastDeclineItiMonth']	= $this->dashboard_model->count_all_data("itinerary", $where_m_dc, $wItiLim_ke);
			
			//Total Revised Leads Decline This Month Leads 
			$where_m_dAppr = array( 'cus_status' => 8, "del_status" => 0, "created <" => date("Y-m-01") );
			$wDcLim_ke = array("lead_last_followup_date" => date('Y-m'));
			$data['pastDecLeadsMonth']	= $this->dashboard_model->count_all_data("customers_inquery", $where_m_dAppr, $wDcLim_ke);
			
			/* //Decline Leads of Current Month  
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
			$data['appItiMonth']	= $this->dashboard_model->count_all_data("itinerary", $where_appIti, $where_appItiLike); */
			
			/****************************** 
			* *******Price Section *******
			******************************/
			//Itinerary Pending Rates
			$where_pr = array("del_status" => 0);
			$orWhere =( "pending_price = 1 OR discount_rate_request = 1 OR discount_rate_request = 2" );
			$penLike = "";
			$data['itiPendingRates'] = $this->dashboard_model->getdatafilter("itinerary", $where_pr,"pending_price_date", $limit, $penLike,"", $orWhere);
			
			//Itinerary Pending Rates for supermanager
			if( is_super_manager() ){ 
				$where_prm = array("del_status" => 0 );
				$orWhere_p = ( "pending_price = 4 OR discount_rate_request = 2" );
				$pensLike = "";
				$data['itiPendingRates_Manager'] = $this->dashboard_model->getdatafilter("itinerary", $where_prm,"pending_price_date", $limit, $pensLike, "", $orWhere_p);
			}	
			
			
			//Itinerary approved Rates limit=5
			$where_Appr = array("pending_price" => 2, "del_status" => 0, 'discount_rate_request' => 0 );
			$where_ApprLike = array("approved_price_date" => date('Y-m-d') );
			$data['itiAppRates'] = $this->dashboard_model->getdatafilter("itinerary", $where_Appr, "approved_price_date", $limit, $where_ApprLike);
			
			
			/*************************************** 
			* *******AMENDMENT PRICE Section *******
			****************************************/
			//Itinerary AMENDMENT Pending Rates
			$data['amendmentPendingRates']	= $this->dashboard_model->get_amendment_pending_price();
			
			//Itinerary AMENDMENT Approved Rates
			$data['amendmentAprRates'] = $this->dashboard_model->get_amendment_approved_price();
			
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('dashboard/manager_dashboard', $data);
			$this->load->view('inc/footer');
	}
	
	
	/*Get all Customer Follow up For Calendar */
	public function getAllCustomerFollowup(){
		$user = $this->session->userdata('logged_in');
		$data['user_id'] = $user['user_id'];
		$user_id = $user['user_id'];
		
		if( $user['role'] == '99' || $user['role'] == '98' ){
			$result = $this->dashboard_model->getAllCustomerFollowup();
		}else if( $user['role'] == '96' ){	
			$result = $this->dashboard_model->getAllCustomerFollowup( $user_id );
		}else{
			$result = "";
		}
		
		$data_events = array();
		if( !empty( $result ) ){
			foreach($result as $r) {
				//Convert time to 24 hours Format
				$new_time = DateTime::createFromFormat('Y-m-d h:i A', $r->nextCallDate);
				$time_24 = $new_time->format('Y-m-d H:i:s');
				$e_date = $new_time->format('Y-m-d');
				$agnet_name = get_user_name($r->agent_id);
				$data_events[] = array(
					"id" 			=> $r->customer_id,
					"cus_id" 		=> $r->customer_id,
					"temp_key" 		=> $r->temp_key,
					"title"			=> $r->callType,
					"end" 			=> $time_24,
					"start" 		=> $time_24,
					"nextCall" 		=> $r->nextCallDate,
					"url" 			=> base_url("customers/view/$r->customer_id/$r->temp_key"),
					"e_date" 		=> $e_date,
					"agent" 		=> $agnet_name,
				);
			}
			
			//$unique_res = array();
			//$unique_res = $this->_unique_multidim_array($data_events,'cus_id', "e_date");
			echo json_encode( $data_events );
		}
		exit();
	}
	
	
	public function getAllCustomerFollowup_merge(){
		$user = $this->session->userdata('logged_in');
		$data['user_id'] = $user['user_id'];
		$user_id = $user['user_id'];
		
		if( $user['role'] == '99' || $user['role'] == '98' ){
			$result = $this->dashboard_model->getAllCustomerFollowup();
			$result2 = $this->dashboard_model->getAllItiFollowup();
		}else if( $user['role'] == '96' ){	
		
			//if teamleader show all data including teammember
			if( is_teamleader() ){
				$agent_in = is_teamleader();
				array_push($agent_in, $user_id );
				$where_in = !empty($agent_in) ? implode(",", $agent_in) : $user_id;
			}else{
				$where_in = $user_id;
			}
			
			$result = $this->dashboard_model->getAllCustomerFollowup( $where_in );
			$result2 = $this->dashboard_model->getAllItiFollowup( $where_in );
			
		}else{
			$result = "";
			$result2 = "";
		}
		
		$data_events = array();
		if( !empty( $result ) || !empty( $result2 ) ){
			
			foreach($result as $r) {
				$url = base_url("customers/view_lead/$r->customer_id");
				//Convert time to 24 hours Format 
				$new_time = DateTime::createFromFormat('Y-m-d h:i A', $r->nextCallDate);
				$time_24 = $new_time->format('Y-m-d H:i:s');
				$e_date = $new_time->format('Y-m-d');
				$agnet_name = get_user_name($r->agent_id);
				$data_events[] = array(
					"id" 			=> 9999 . $r->customer_id, // 9999 = just for unique
					"cus_id" 		=> $r->customer_id,
					"temp_key" 		=> $r->temp_key,
					"title"			=> $r->callType,
					"end" 			=> $time_24,
					"start" 		=> $time_24,
					"nextCall" 		=> $r->nextCallDate,
					"url" 			=> $url,
					"e_date" 		=> $e_date,
					"agent" 		=> $agnet_name,
				);
			}
			
			//if itinerary followup exists
			if( !empty( $result2 ) ){
				foreach($result2 as $rf) {
					//Convert time to 24 hours Format 
					$e_date = $rf->nextCallDate;
					$agnet_name = get_user_name($rf->agent_id);
					$url = base_url("customers/view_lead/$rf->customer_id");
					$data_events[] = array(
						"id" 			=> 8888 . $rf->customer_id, //8888 = just for uniqe
						"cus_id" 		=> $rf->customer_id,
						"temp_key" 		=> $rf->temp_key,
						"title"			=> $rf->callType,
						"end" 			=> $e_date,
						"start" 		=> $e_date,
						"nextCall" 		=> $rf->nextCallDate,
						"url" 			=> $url,
						"e_date" 		=> $e_date,
						"agent" 		=> $agnet_name,
					);
				}
				
				//$unique_res = array();
				//$unique_res = $this->_unique_multidim_iti_array($data_events,'iti_id', "e_date");
				//echo json_encode( $data_events );
			}
			
			//$unique_res = array();
			//$unique_res = $this->_unique_multidim_array($data_events,'cus_id', "e_date");
			echo json_encode( $data_events );
		}
		exit();
	}
	
	/*Get all Itineraries Follow up For Calendar */
	public function getAllItiFollowup(){
		$user = $this->session->userdata('logged_in');
		$data['user_id'] = $user['user_id'];
		$user_id = $user['user_id'];
		
		if( $user['role'] == '99' || $user['role'] == '98' ){
			$result = $this->dashboard_model->getAllItiFollowup();
		}else if( $user['role'] == '96' ){	
			$result = $this->dashboard_model->getAllItiFollowup( $user_id );
		}else{
			$result = "";
		}
		
		$data_events = array();
		if( !empty( $result ) ){
			foreach($result as $r) {
				//Convert time to 24 hours Format
				$e_date = $r->nextCallDate;
				$agnet_name = get_user_name($r->agent_id);
				
				$data_events[] = array(
					"id" 			=> $r->iti_id,
					"iti_id" 		=> $r->iti_id,
					"temp_key" 		=> $r->temp_key,
					"title"			=> $r->callType,
					"end" 			=> $e_date,
					"start" 		=> $e_date,
					"nextCall" 		=> $r->nextCallDate,
					"url" 			=> base_url("itineraries/view_iti/$r->iti_id/$r->temp_key"),
					"e_date" 		=> $e_date,
					"agent" 		=> $agnet_name,
				);
			}
			
			//$unique_res = array();
			//$unique_res = $this->_unique_multidim_iti_array($data_events,'iti_id', "e_date");
			echo json_encode( $data_events );
		}
		exit();

	}
	
	/*Get all payment Follow up For Calendar */
	public function getAllPaymentFollowupCalendar(){
		$user = $this->session->userdata('logged_in');
		$data['user_id'] = $user['user_id'];
		$user_id = $user['user_id'];
		
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '97' || $user['role'] == '93' ){
			$result = $this->dashboard_model->getAllPaymentFollowupCalendar();
		}else{
			$result = "";
		}
		
		//If data exists
		if( !empty( $result ) ){
			$data_events = array();
			foreach( $result as $r ){
				$second_ins 	= $r->second_payment_bal;
				$second_date 	= $r->second_payment_date;
				$third_ins 		= $r->third_payment_bal;
				$third_date 	= $r->third_payment_date;
				$final_ins		= $r->final_payment_bal;
				$final_date		= $r->final_payment_date;
				
				$url = base_url("payments/update_payment/$r->id/$r->iti_id");
				//Check if second installment not empty
				if( !empty( $second_ins ) && !empty($second_date) ){
					$start = $this->_convert_date_format( $second_date );
					$data_events[] = array(
						"id" 			=> $r->id,
						"iti_id" 		=> $r->iti_id,
						"title"			=> $r->customer_name,
						"end" 			=> $start,
						"start" 		=> $start,
						"amount" 		=> $second_ins,
						"url" 			=> $url,
						"e_date" 		=> $second_date,
					);
				}
				
				//Check if third installment not empty
				if( !empty ($third_ins) && !empty($second_ins) ){
					$start = $this->_convert_date_format( $third_date );
					$data_events[] = array(
						"id" 			=> $r->id,
						"iti_id" 		=> $r->iti_id,
						"title"			=> $r->customer_name,
						"end" 			=> $start,
						"start" 		=> $start,
						"amount" 		=> $third_ins,
						"url" 			=> $url,
						"e_date" 		=> $third_date,
					);
				}
				
				//Check if Final installment not empty
				if( !empty( $final_ins ) && !empty($final_date) ){
					$start = $this->_convert_date_format( $final_date );
					$data_events[] = array(
						"id" 			=> $r->id,
						"iti_id" 		=> $r->iti_id,
						"title"			=> $r->customer_name,
						"end" 			=> $start,
						"start" 		=> $start,
						"amount" 		=> $final_ins,
						"url" 			=> $url,
						"e_date" 		=> $final_date,
					);
				}
			}
			echo json_encode( $data_events );
		}	
		
		/* echo "<pre>";
			print_r( $data_events );
		echo "</pre>"; */
		
		exit();
	}
	
	//Get Advance payment pending follow up
	public function advance_payment_pending_followup(){
		$user = $this->session->userdata('logged_in');
		$data['user_id'] = $user['user_id'];
		$user_id = $user['user_id'];
		
		//Get payment type 1 =advance pending , 2 = after advance received pending
		$condition = isset( $_GET['type'] ) && $_GET['type']  == 2 ? ">=" : "<";
		
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '97' || $user['role'] == '93' ){
			$result = $this->dashboard_model->advance_payment_pending_followup( $condition );
		}else{
			$result = "";
		}
		
		/* dump($result);
		die; */
		
		//If data exists
		if( !empty( $result ) ){
			$data_events = array();
			foreach( $result as $r ){
				$second_ins 	= $r->second_payment_bal;
				$second_date 	= $r->second_payment_date;
				$third_ins 		= $r->third_payment_bal;
				$third_date 	= $r->third_payment_date;
				$final_ins		= $r->final_payment_bal;
				$final_date		= $r->final_payment_date;
				
				$url = base_url("payments/update_payment/$r->id/$r->iti_id");
				//Check if second installment not empty
				if( !empty( $second_ins ) && !empty($second_date) && $r->second_pay_status == 'unpaid' ){
					$start = $this->_convert_date_format( $second_date );
					$data_events[] = array(
						"id" 			=> $r->id,
						"iti_id" 		=> $r->iti_id,
						"title"			=> $r->customer_name,
						"end" 			=> $start,
						"start" 		=> $start,
						"amount" 		=> $second_ins,
						"url" 			=> $url,
						"e_date" 		=> $second_date,
					);
				}
				
				//Check if third installment not empty
				if( !empty ($third_ins) && !empty($second_ins) && $r->third_pay_status == 'unpaid' ){
					$start = $this->_convert_date_format( $third_date );
					$data_events[] = array(
						"id" 			=> $r->id,
						"iti_id" 		=> $r->iti_id,
						"title"			=> $r->customer_name,
						"end" 			=> $start,
						"start" 		=> $start,
						"amount" 		=> $third_ins,
						"url" 			=> $url,
						"e_date" 		=> $third_date,
					);
				}
				
				//Check if Final installment not empty
				if( !empty( $final_ins ) && !empty($final_date) && $r->final_pay_status == 'unpaid' ){
					$start = $this->_convert_date_format( $final_date );
					$data_events[] = array(
						"id" 			=> $r->id,
						"iti_id" 		=> $r->iti_id,
						"title"			=> $r->customer_name,
						"end" 			=> $start,
						"start" 		=> $start,
						"amount" 		=> $final_ins,
						"url" 			=> $url,
						"e_date" 		=> $final_date,
					);
				}
			}
			echo json_encode( $data_events );
		}	
		
		/* echo "<pre>";
			print_r( $data_events );
		echo "</pre>"; */
		
		exit();
	}
	
	
	/*Get Travel dates calendar */
	public function getAllTravelDatesCalendar(){
		$user = $this->session->userdata('logged_in');
		$data['user_id'] = $user['user_id'];
		$user_id = $user['user_id'];
		
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '97' || $user['role'] == '93' ){
			$result = $this->dashboard_model->getAllTravelDatesCalendar();
		}else{
			$result = "";
		}
	
		//If data exists
		if( !empty( $result ) ){
			$data_events = array();
			foreach( $result as $r ){
				$iti_id 		= $r->iti_id;
				$travel_date 	= $r->travel_date;
				$customer_name 	= $r->customer_name;
				$temp_key 		= get_iti_temp_key( $iti_id );
				$url = base_url("itineraries/view_iti/$iti_id/$temp_key");
				
				$start = $this->_convert_date_format( $travel_date );
				$data_events[] = array(
					"id" 			=> $r->iti_id,
					"iti_id" 		=> $r->iti_id,
					"title"			=> $r->customer_name,
					"end" 			=> $start,
					"start" 		=> $start,
					"url" 			=> $url,
					"e_date" 		=> $travel_date,
				);
			}
			echo json_encode( $data_events );
		}	
		exit();
	}
	
	
	//Convert date format
	private function _convert_date_format( $date ){
		//Convert time to 24 hours Format
		$new_time = DateTime::createFromFormat('Y-m-d', $date);
		$time_24 = $new_time->format('Y-m-d H:i:s');
		return $time_24;
	}
	
//filter by customer type
	public function leadsFilterByType(){
		$user = $this->session->userdata('logged_in');
		$date = $this->input->post('selectedDate'); 
		$agent_id = $this->input->post('agent_id');
		$leadsFilterdata = $this->dashboard_model->leads_data($date, $agent_id);
		if(!empty($leadsFilterdata)){
			$typeName = [];
			foreach( $leadsFilterdata as $key => $value){
				$typeName[] = $value['name'];
			}
		}
			$res = array('res' => true, 'msg'=> 'success', 'totalNo' => $leadsFilterdata, 'name' => $typeName);
		die(json_encode( $res ));
	}


	public function leadsFilter(){
		$user = $this->session->userdata('logged_in');
		$date = $this->input->post('selectedDate'); 
		$agent_id = $this->input->post('agent_id');
		$leadsFilterdata = $this->dashboard_model->getLeadsByRefrence($date, $agent_id);
		if(!empty($leadsFilterdata)){
			$totalNo = [];
			$typeName = [];
			foreach( $leadsFilterdata as $key => $value){	
					$totalNo[] =  $value['value'];
					$typeName[] = $value['name'];
				}
			}

			// if($totalNo != 0){
			if( $leadsFilterdata || $typeName){
				$res = array('res' => true, 'msg'=> 'success', 'totalNo' => $leadsFilterdata, 'name' =>  $typeName);
			}else{
				$res = array('res' => false, 'msg'=> 'No Data Found', 'totalNo' => '', 'name' => '');
			}
		// }else{
		// 	$res = array('res' => false, 'msg'=> 'No Data Found', 'totalNo' => '', 'name' => '');
		// }
			die(json_encode( $res ));
		}
	
	//Get Monthly Data for Itineraries Bar Chart
	public function chart_data_monthly_iti_ajax(){
		$user = $this->session->userdata('logged_in');
		$theYear = $this->input->post('year');
		$agent_id = $this->input->post('agent_id');
		
		//$theYear = 2018;
		$year = !empty( $theYear ) ? trim($theYear) : date("Y");
		
		//Get Data 0=working, 9 = approved, 7 = declined
		$list_data_iti_working	 = $this->dashboard_model->get_monthly_iti_data($year, $type = "0",$agent_id );
		$list_data_iti_approved = $this->dashboard_model->get_monthly_iti_app_dec_data($year, $type = "9" , $agent_id);
		$list_data_iti_declined = $this->dashboard_model->get_monthly_iti_app_dec_data($year, $type = "7" , $agent_id);
		
	 	//Get data for opt1
		$data_1 = array();
		foreach( $list_data_iti_working as $res ){
			$data_1[] = $res->start_count;
		}	
		
		//Get data for opt2
		$data_2 = array();
		foreach( $list_data_iti_approved as $res_2 ){
			$data_2[] = $res_2->start_count;
		}

		//Get data for opt2
		$data_3 = array();
		foreach( $list_data_iti_declined as $res_3 ){
			$data_3[] = $res_3->start_count;
		}
		
		//dump($data_3);
		//die; 
		
		if( $list_data_iti_working || $list_data_iti_approved || $list_data_iti_declined ){
			$res = array('res' => true, 'msg'=> 'success', 'data1' => $data_1, 'data2' => $data_2, 'data3' => $data_3 );
		}else{
			$res = array('res' => false, 'msg'=> 'No Data Found', 'data1' => '', 'data2' => '', 'data3' => '' );
		}	
		die(json_encode( $res ));
    }
	
	
	//Get Monthly Data for LEADS Bar Chart
	public function chart_data_monthly_leads_ajax(){
		$user = $this->session->userdata('logged_in');
		$theYear = $this->input->post('year');
		$agent_id = $this->input->post('agent_id');
		
		//$theYear = 2018;
		$year = !empty( $theYear ) ? trim($theYear) : date("Y");
		
		//Get Data 0=working, 9 = approved, 7 = declined
		$list_data_leads_working  = $this->dashboard_model->get_monthly_leads_data($year, $type = "0" , $agent_id );
		$list_data_leads_approved = $this->dashboard_model->get_monthly_leads_app_dec_data($year, $type = "9" , $agent_id);
		$list_data_leads_declined = $this->dashboard_model->get_monthly_leads_app_dec_data($year, $type = "8" , $agent_id);
		
	 	//Get data for opt1
		$data_1 = array();
		foreach( $list_data_leads_working as $res ){
			$data_1[] = $res->start_count;
		}	
		
		//Get data for opt2
		$data_2 = array();
		foreach( $list_data_leads_approved as $res_2 ){
			$data_2[] = $res_2->start_count;
		}

		//Get data for opt2
		$data_3 = array();
		foreach( $list_data_leads_declined as $res_3 ){
			$data_3[] = $res_3->start_count;
		}
		
		//dump($data_3);
		//die; 
		
		if( $list_data_leads_working || $list_data_leads_approved || $list_data_leads_declined ){
			$res = array('res' => true, 'msg'=> 'success', 'data1' => $data_1, 'data2' => $data_2, 'data3' => $data_3 );
		}else{
			$res = array('res' => false, 'msg'=> 'No Data Found', 'data1' => '', 'data2' => '', 'data3' => '' );
		}	
		die(json_encode( $res ));
    }
	
	 //email test
	// public function mailtest(){
	// 	$admin_email 	= admin_email();
	// 	$manager_email 	= manager_email();
		
	// 	$to = array( "hem@eligocs.com" );
	// 	$sub = "test";
	// 	$msg = "<b>BCC</b>";
	// 	$msg .= "<strong>BCC</strong>";
	// 	sendEmail( $to, $sub, $msg, "hem@eligocs.com" );
	// }
	
	/*
	//SMS Testing
	/*
	public function smstest(){
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
	
	
	//Send otp test
	public function testotp(){
		$this->load->library('sendotp');
		$req = array("mobileNumber" => 9805890367, 'countryCode' => 91 );
		$send_otp = $this->sendotp->generateOTP($req);
		echo $send_otp;
		//dump( $send_otp );
		die;
	}

// Iti Sale this month by one agent 

	public function agentSalesThisMonth(){
		$user = $this->session->userdata('logged_in');
		$data['user_id'] = $user['user_id'];
		$user_id = $user['user_id'];
		$month = date('Y-m');
		$get_booked_iti = $this->global_model->ajax_check_agent_incentive( $month , $user_id);
		$total_pacages_cost  = 0;
		foreach( $get_booked_iti as $key => $iti_Data){
			$package_cost = $iti_Data->package_cost;
			$total_pacages_cost += $package_cost;
		}

		$total_booking = count($get_booked_iti);
		$incentive = 0;
		$turnover_slab = 0;


		if( !empty( $total_booking ) ){
			//calculate incentive
			switch( $total_booking ){
				case ( $total_booking <= 10 ):
					$incentive = $total_booking * 250; //250 per package
					break;
				case ($total_booking > 10 && $total_booking <= 20 ):
					$incentive = $total_booking * 300; //300 per package;
					break;
				case ($total_booking > 20):
					$incentive = $total_booking * 500; //500 per package;
					break;
				default:
					$incentive =  0;
				break;
			}	
		}

		//turn over slab
		if( $total_pacages_cost > 300000 ){
			$turnover_slab = ( $total_pacages_cost * 1 ) / 100;
		}else{
			$remain = 300000 - $total_pacages_cost;
		}
		//total incentive
		$total_inc = $turnover_slab + $incentive;

		if($get_booked_iti){
			$res = array('res' => true, 'msg'=> 'success', 'totalsale' => $total_pacages_cost, 'totInc' => $total_inc);
		}else{
			$res = array('res' => false, 'msg'=> 'No Data Found', 'totalsale' => '', 'totInc' => '');
		}
		die(json_encode( $res ));
	}
	
}