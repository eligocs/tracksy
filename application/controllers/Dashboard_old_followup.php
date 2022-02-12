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
			$where_m_aAppr = array('cus_last_followup_status' => $callType, "reopen_by" => 0, "del_status" => 0 );
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
			$where_rev_m_Sent = array("lead_created <" => date('Y-m-01'));
			$where_m_qRevSentLike = array("quotation_sent_date" => date('Y-m') );
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
			$where_pr = array("del_status" => 0, "iti_status" => 0, "pending_price" => 1 );
			$orWhere = array('discount_rate_request' => 1 );
			$penLike = "";
			$data['itiPendingRates']	= $this->dashboard_model->getdatafilter("itinerary", $where_pr,"pending_price_date", $limit, $penLike, $orWhere);
			
			//Itinerary approved Rates limit=5
			$where_Appr = array("pending_price" => 2, "del_status" => 0 );
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
		//For service team dashboard
		elseif( $user['role'] == '97' ){
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
			
			//Get Hotel Booking
			$where = array( "del_status" => 0 , "email_count >" => 0, "booking_status" => 0 );
			$data['hotel_booking'] = $this->global_model->getdata( 'hotel_booking', $where, "", "", $limit );
			
			//Get approved booking with 50% iti payment received
			//$data['hotel_booking_aprroved'] = $this->dashboard_model->get_approved_hotel_booking($limit);
			
			//Get Cab Booking
			$where = array( "del_status" => 0 , "email_count >" => 0 );
			$data['cab_booking'] = $this->global_model->getdata( 'cab_booking', $where, "", "", $limit );
			
			//Get approved Cab booking with 50% iti payment received
			//$data['cab_booking_aprroved'] = $this->dashboard_model->get_approved_cab_booking($limit);
			
			//Get Volvo Booking
			$where = array( "del_status" => 0, "booking_type" => "volvo" );
			$data['volvo_booking'] = $this->global_model->getdata( 'travel_booking', $where, "", "", $limit );
			
			//Get volvo approved booking having 50% payment received
			//$where_type = "(booking_type='volvo')";
			//$data['volvo_booking_approved'] = $this->dashboard_model->get_approved_vtf_booking( $where_type, $limit );
			
			//Get Train/Flight Booking
			$where = "( booking_type = 'train' OR  booking_type = 'flight' AND del_status = 0 )";
			$data['train_flight_booking'] = $this->global_model->getdata_where( 'travel_booking', $where, "", "", $limit );
			
			//Get volvo approved booking having 50% payment received
			//$where_type = "(booking_type='train' OR booking_type='flight')";
			//$data['train_flight_booking_approved'] = $this->dashboard_model->get_approved_vtf_booking( $where_type, $limit );
			
			
			
			//Get All Payments details pending today
			$data['pendingPaymentsFollow']	= $this->dashboard_model->getTodaysPendingPayments( $limit );
			
			
			//AMENDMENT ITINERARIES
			$data['amendmentItineraries']	= $this->dashboard_model->get_amendment_itineraries();
			
			//REFUND PAYMENTS
			$data['get_refund_payments']	= $this->dashboard_model->get_refund_payments();
			
			//Confirmed Vouchers
			$data['confirmed_vouchers']	= $this->dashboard_model->confirmed_vouchers();
			
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('dashboard/service_dashboard', $data);
			$this->load->view('inc/footer');
		}
		elseif( $user['role'] == '96' ){
			//picked call and next call
			$limit = 30;
				/****************************** 
			* *******Todays Section *******
			******************************/
			
			//Total Call Picked Today Leads
			$callType = "Picked call";
			$where_aAppr = array('agent_id' => $user_id, 'cus_last_followup_status' => $callType, "reopen_by" => 0, "del_status" => 0 );
			$where_appItiLike = array("lead_last_followup_date" => date('Y-m-d'), "created" => date('Y-m-d') );
			$data['totalPickCallsToday'] = $this->dashboard_model->count_all_data("customers_inquery", $where_aAppr, $where_appItiLike);
			
			//Total Call Not Picked Today Leads
			$callType = "Call not picked";
			$where_aAppr = array('agent_id' => $user_id, 'cus_last_followup_status' => $callType, "reopen_by" => 0, "del_status" => 0 );
			$where_appItiLike = array("lead_last_followup_date" => date('Y-m-d'), "created" => date('Y-m-d') );
			$data['totalNotPickCallsToday']	= $this->dashboard_model->count_all_data("customers_inquery", $where_aAppr, $where_appItiLike);
			
			//Total Leads Today 
			$where_leads = array("del_status" => 0,"reopen_by" => 0, 'agent_id' => $user_id);
			$where_like = array("created" => date('Y-m-d') );
			$data['totalContLeadsToday']	= $this->dashboard_model->count_all_data("customers_inquery", $where_leads, $where_like);
			
			
			//Total Call Decline Today Leads 
			$callTypeD = 8;
			$where_dAppr = array('cus_status' => 8, "del_status" => 0, 'agent_id' => $user_id );
			$wDcLike = array("lead_last_followup_date" => date('Y-m-d'), "created" => date('Y-m-d')  );
			$data['totalDecLeadsToday']	= $this->dashboard_model->count_all_data("customers_inquery", $where_dAppr, $wDcLike);
			
			//Total 	 Today Leads 
			$whLead = array('cus_status' => 0, "del_status" => 0, 'agent_id' => $user_id );
			$wDcLke = array( "created" => date('Y-m-d'), "cus_last_followup_status" => 0   );
			$data['totalUnworkLeadsToday']	= $this->dashboard_model->count_all_data("customers_inquery", $whLead, $wDcLke);
			
			//Decline Itinerary Today
			$where_dc = array('iti_status' => 7, "del_status" => 0 , 'agent_id' => $user_id);
			$wItiLike = array("iti_decline_approved_date" => date('Y-m-d'), "lead_created" => date('Y-m-d') );
			$data['totalDecItiToday']	= $this->dashboard_model->count_all_data("itinerary", $where_dc, $wItiLike);
			
			//Working Itinerary Today
			$where_dc = array('iti_status' => 0,"publish_status" => "publish", "del_status" => 0, "parent_iti_id" => 0, 'agent_id' => $user_id );
			$wItiLike = array("lead_created" => date('Y-m-d') );
			$data['totalWorkingItiToday']	= $this->dashboard_model->count_all_data("itinerary", $where_dc, $wItiLike);
			
			//Approved Itinerary Today
			$where_dc = array('iti_status' => 9, "del_status" => 0, 'agent_id' => $user_id );
			$wItiLike = array("lead_created" => date('Y-m-d'), "iti_decline_approved_date" => date('Y-m-d') );
			$data['totalApprovedItiToday']	= $this->dashboard_model->count_all_data("itinerary", $where_dc, $wItiLike);
			
			//Total Quotation Sent Today
			$where_qSent = array('agent_id' => $user_id, "parent_iti_id" => 0 );
			$where_qSentLike = array("quotation_sent_date" => date('Y-m-d'), "lead_created" => date('Y-m-d') );
			$data['totalQuotSentToday']	= $this->dashboard_model->count_all_data("itinerary", $where_qSent, $where_qSentLike);
			
			//Total Revised Quotation Sent Today
			$where_qSent = array( "parent_iti_id !=" => 0, 'agent_id' => $user_id);
			$where_qSentLike = array("quotation_sent_date" => date('Y-m-d'), "lead_created" => date('Y-m-d') );
			$data['totalRevQuotSentToday']	= $this->dashboard_model->count_all_data("itinerary", $where_qSent, $where_qSentLike);
			
			//Total Leads Created Today
			$where_addLead = array( "del_status" => 0, "cus_status" => 0, 'agent_id' => $user_id );
			$wleadLike = array("created" => date('Y-m-d') , "cus_last_followup_status" => 0 );
			$data['totalLeadsToday']	= $this->dashboard_model->getdatafilter("customers_inquery", $where_addLead, "customer_id", $limit, $wleadLike);
			
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
			$where_rev_Sent = array("lead_created <" => date('Y-m-d'), 'agent_id' => $user_id);
			$where_qRevSentLike = array("quotation_sent_date" => date('Y-m-d') );
			$data['pastQuotSentToday']	= $this->dashboard_model->count_all_data("itinerary", $where_rev_Sent, $where_qRevSentLike);
			
			
			//Approved Revised Itinerary Today
			$where_dc = array('iti_status' => 9, "del_status" => 0 , "lead_created <" => date('Y-m-d'), 'agent_id' => $user_id );
			$wItiLike = array("iti_decline_approved_date" => date('Y-m-d') );
			$data['pastApprovedItiToday']	= $this->dashboard_model->count_all_data("itinerary", $where_dc, $wItiLike);
			
			//Approved Revised Itinerary Today
			$where_dc = array('iti_status' => 7, "del_status" => 0 , "lead_created <" => date('Y-m-d') , 'agent_id' => $user_id);
			$wItiLike = array("iti_decline_approved_date" => date('Y-m-d') );
			$data['pastDeclineItiToday']	= $this->dashboard_model->count_all_data("itinerary", $where_dc, $wItiLike);
			
			//Total Revised Leads Decline Today Leads 
			$where_dAppr = array('cus_status' => 8, "del_status" => 0, "created <" => date('Y-m-d') , 'agent_id' => $user_id );
			$wDcLike = array("lead_last_followup_date" => date('Y-m-d') );
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
			$where_m_aAppr = array('cus_last_followup_status' => $callType, "reopen_by" => 0, "del_status" => 0,'agent_id' => $user_id );
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
			$where_pr = array('agent_id' => $user_id, "pending_price" => 1, "del_status" => 0);
			$or_where_pr = array( "discount_rate_request" => 1 );
			/* $penLike = array("pending_price_date" => date('Y-m') ); */
			$penLike = "";
			$data['itiPendingRates']	= $this->dashboard_model->getdatafilter("itinerary", $where_pr, "pending_price_date", $limit, $penLike, $or_where_pr);
			
			//Itinerary approved Rates limit=5
			$where_Appr = array('agent_id' => $user_id,"pending_price" => 2, "del_status" => 0 );
			$where_ApprLike = array("approved_price_date" => date('Y-m-d') );
			$data['itiAppRates']	= $this->dashboard_model->getdatafilter( "itinerary", $where_Appr, "approved_price_date", $limit,$where_ApprLike );
			
			/*************************************** 
			* *******AMENDMENT PRICE Section *******
			****************************************/
			//Itinerary AMENDMENT Pending Rates
			$data['amendmentPendingRates']	= $this->dashboard_model->get_amendment_pending_price($user_id);
			
			//Itinerary AMENDMENT Approved Rates
			$data['amendmentAprRates'] = $this->dashboard_model->get_amendment_approved_price($user_id);
			
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
		
		//Total Call Picked Today Leads
			$callType = "Picked call";
			$where_aAppr = array('agent_id' => $user_id, 'cus_last_followup_status' => $callType, "reopen_by" => 0, "del_status" => 0 );
			$where_appItiLike = array("lead_last_followup_date" => date('Y-m-d'), "created" => date('Y-m-d') );
			$data['totalPickCallsToday'] = $this->dashboard_model->count_all_data("customers_inquery", $where_aAppr, $where_appItiLike);
			
			//Total Call Not Picked Today Leads
			$callType = "Call not picked";
			$where_aAppr = array('agent_id' => $user_id, 'cus_last_followup_status' => $callType, "reopen_by" => 0, "del_status" => 0 );
			$where_appItiLike = array("lead_last_followup_date" => date('Y-m-d'), "created" => date('Y-m-d') );
			$data['totalNotPickCallsToday']	= $this->dashboard_model->count_all_data("customers_inquery", $where_aAppr, $where_appItiLike);
			
			//Total Leads Today 
			$where_leads = array("del_status" => 0,"reopen_by" => 0, 'agent_id' => $user_id);
			$where_like = array("created" => date('Y-m-d') );
			$data['totalContLeadsToday']	= $this->dashboard_model->count_all_data("customers_inquery", $where_leads, $where_like);
			
			
			//Total Call Decline Today Leads 
			$callTypeD = 8;
			$where_dAppr = array('cus_status' => 8, "del_status" => 0, 'agent_id' => $user_id );
			$wDcLike = array("lead_last_followup_date" => date('Y-m-d'), "created" => date('Y-m-d')  );
			$data['totalDecLeadsToday']	= $this->dashboard_model->count_all_data("customers_inquery", $where_dAppr, $wDcLike);
			
			//Total Unwork Today Leads 
			$whLead = array('cus_status' => 0, "del_status" => 0, 'agent_id' => $user_id);
			$wDcLke = array( "created" => date('Y-m-d') ,"cus_last_followup_status" => 0  );
			$data['totalUnworkLeadsToday']	= $this->dashboard_model->count_all_data("customers_inquery", $whLead, $wDcLke);
			
			//Decline Itinerary Today
			$where_dc = array('iti_status' => 7, "del_status" => 0 , 'agent_id' => $user_id);
			$wItiLike = array("iti_decline_approved_date" => date('Y-m-d'), "lead_created" => date('Y-m-d') );
			$data['totalDecItiToday']	= $this->dashboard_model->count_all_data("itinerary", $where_dc, $wItiLike);
			
			//Working Itinerary Today
			$where_dc = array('iti_status' => 0,"publish_status" => "publish", "del_status" => 0, "parent_iti_id" => 0, 'agent_id' => $user_id );
			$wItiLike = array("lead_created" => date('Y-m-d') );
			$data['totalWorkingItiToday']	= $this->dashboard_model->count_all_data("itinerary", $where_dc, $wItiLike);
			
			//Approved Itinerary Today
			$where_dc = array('iti_status' => 9, "del_status" => 0, 'agent_id' => $user_id );
			$wItiLike = array("lead_created" => date('Y-m-d'), "iti_decline_approved_date" => date('Y-m-d') );
			$data['totalApprovedItiToday']	= $this->dashboard_model->count_all_data("itinerary", $where_dc, $wItiLike);
			
			//Total Quotation Sent Today
			$where_qSent = array('agent_id' => $user_id,"parent_iti_id" => 0);
			$where_qSentLike = array("quotation_sent_date" => date('Y-m-d'), "lead_created" => date('Y-m-d') );
			$data['totalQuotSentToday']	= $this->dashboard_model->count_all_data("itinerary", $where_qSent, $where_qSentLike);
			
			//Total Revised Quotation Sent Today
			$where_qSent = array( "parent_iti_id !=" => 0, 'agent_id' => $user_id);
			$where_qSentLike = array("quotation_sent_date" => date('Y-m-d'), "lead_created" => date('Y-m-d') );
			$data['totalRevQuotSentToday']	= $this->dashboard_model->count_all_data("itinerary", $where_qSent, $where_qSentLike);
			
			//Total Leads Created Today
			$where_addLead = array( "del_status" => 0, "cus_status" => 0, 'agent_id' => $user_id );
			$wleadLike = array("created" => date('Y-m-d') , "cus_last_followup_status" => 0 );
			$data['totalLeadsToday']	= $this->dashboard_model->getdatafilter("customers_inquery", $where_addLead, "customer_id", $limit, $wleadLike);
			
			//Leads Follow up Today 
			$data['leadsFollowupToday'] = $this->dashboard_model->getTodaysLeadsFollowup($user_id, $limit);
			
			//Itinerary Follow up Today 
			/* $w_iti = array('agent_id' => $user_id);
			$Andw_iti = "(callType='Picked call' OR callType='Call not picked')";
			$_tow_itiLike = array("nextCallDate" => date('Y-m-d'));
			$data['todayFollowup_iti']	= $this->dashboard_model->getdatafilter("iti_followup", $w_iti, "", $limit, $_tow_itiLike,"", $Andw_iti, "nextCallDate"); */
			
			/*************************************** 
			* *******Todays Revised Section *******
			****************************************/
			//Total Revised Quotation Sent Today Leads created before today
			$where_rev_Sent = array("lead_created <" => date('Y-m-d'), 'agent_id' => $user_id);
			$where_qRevSentLike = array("quotation_sent_date" => date('Y-m-d') );
			$data['pastQuotSentToday']	= $this->dashboard_model->count_all_data("itinerary", $where_rev_Sent, $where_qRevSentLike);
			
			
			//Approved Revised Itinerary Today
			$where_dc = array('iti_status' => 9, "del_status" => 0 , "lead_created <" => date('Y-m-d'), 'agent_id' => $user_id );
			$wItiLike = array("iti_decline_approved_date" => date('Y-m-d') );
			$data['pastApprovedItiToday']	= $this->dashboard_model->count_all_data("itinerary", $where_dc, $wItiLike);
			
			//Approved Revised Itinerary Today
			$where_dc = array('iti_status' => 7, "del_status" => 0 , "lead_created <" => date('Y-m-d') , 'agent_id' => $user_id);
			$wItiLike = array("iti_decline_approved_date" => date('Y-m-d') );
			$data['pastDeclineItiToday']	= $this->dashboard_model->count_all_data("itinerary", $where_dc, $wItiLike);
			
			//Total Revised Leads Decline Today Leads 
			$where_dAppr = array('cus_status' => 8, "del_status" => 0, "created <" => date('Y-m-d') , 'agent_id' => $user_id );
			$wDcLike = array("lead_last_followup_date" => date('Y-m-d') );
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
			$wDcLkeM = array( "created" => date('Y-m'), "cus_last_followup_status" => 0   );
			$data['totalUnworkLeadsMonth']	= $this->dashboard_model->count_all_data("customers_inquery", $whLeadM, $wDcLkeM);
			
			//Total Call Picked This Month Leads
			$callType = "Picked call";
			$where_m_aAppr = array('cus_last_followup_status' => $callType, "reopen_by" => 0, "del_status" => 0,'agent_id' => $user_id );
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
			$where_pr = array('agent_id' => $user_id, "pending_price" => 1, "del_status" => 0);
			$or_where_pr = array( "discount_rate_request" => 1 );
			/* $penLike = array("pending_price_date" => date('Y-m') ); */
			$penLike = "";
			$data['itiPendingRates']	= $this->dashboard_model->getdatafilter("itinerary", $where_pr, "pending_price_date", $limit, $penLike, $or_where_pr);
			
			//Itinerary approved Rates limit=5
			$where_Appr = array('agent_id' => $user_id,"pending_price" => 2, "del_status" => 0 );
			$where_ApprLike = array("approved_price_date" => date('Y-m-d') );
			$data['itiAppRates']	= $this->dashboard_model->getdatafilter( "itinerary", $where_Appr, "approved_price_date", $limit,$where_ApprLike );
			
			
			/*************************************** 
			* *******AMENDMENT PRICE Section *******
			****************************************/
			//Itinerary AMENDMENT Pending Rates
			$data['amendmentPendingRates']	= $this->dashboard_model->get_amendment_pending_price($user_id);
			
			//Itinerary AMENDMENT Approved Rates
			$data['amendmentAprRates'] = $this->dashboard_model->get_amendment_approved_price($user_id);
		
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('dashboard/sales_dashboard', $data);
			$this->load->view('inc/footer');
	}
	
	private function _manager_dashboard( $user_id ){
		//picked call and next call
		$limit = 20;
		
		/****************************** 
		* *******Todays Section *******
		******************************/
		
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
		
		//Total Leads Today 
		$where_leads = array("del_status" => 0,"reopen_by" => 0);
		$where_like = array("created" => date('Y-m-d') );
		$data['totalContLeadsToday']	= $this->dashboard_model->count_all_data("customers_inquery", $where_leads, $where_like);
		
		
		//Total Call Decline Today Leads 
		$callTypeD = 8;
		$where_dAppr = array('cus_status' => 8, "del_status" => 0 );
		$wDcLike = array("lead_last_followup_date" => date('Y-m-d'), "created" => date('Y-m-d')  );
		$data['totalDecLeadsToday']	= $this->dashboard_model->count_all_data("customers_inquery", $where_dAppr, $wDcLike);
		
		//Total Unwork Today Leads 
		$whLead = array('cus_status' => 0, "del_status" => 0 );
		$wDcLke = array( "created" => date('Y-m-d'), "cus_last_followup_status" => 0   );
		$data['totalUnworkLeadsToday']	= $this->dashboard_model->count_all_data("customers_inquery", $whLead, $wDcLke);
		
		//Quotation Sent This Month
		$where_mqSent = array("email_count >" => 0, "del_status" => 0, "parent_iti_id" => 0 );
		$where_mqSentLike = array("quotation_sent_date" => date('Y-m'), "lead_created" => date('Y-m') );
		$data['totalQuotSentMonth']	= $this->dashboard_model->count_all_data("itinerary", $where_mqSent, $where_mqSentLike);
		
		//Decline Itinerary Today
		$where_dc = array('iti_status' => 7, "del_status" => 0 );
		$wItiLike = array("iti_decline_approved_date" => date('Y-m-d'), "lead_created" => date('Y-m-d') );
		$data['totalDecItiToday']	= $this->dashboard_model->count_all_data("itinerary", $where_dc, $wItiLike);
		
		//Working Itinerary Today
		$where_dc = array('iti_status' => 0, "del_status" => 0, "parent_iti_id" => 0 );
		$wItiLike = array("lead_created" => date('Y-m-d') );
		$data['totalWorkingItiToday']	= $this->dashboard_model->count_all_data("itinerary", $where_dc, $wItiLike);
		
		//Approved Itinerary Today
		$where_dc = array('iti_status' => 9, "del_status" => 0 );
		$wItiLike = array("lead_created" => date('Y-m-d'), "iti_decline_approved_date" => date('Y-m-d') );
		$data['totalApprovedItiToday']	= $this->dashboard_model->count_all_data("itinerary", $where_dc, $wItiLike);
		
		//Total Quotation Sent Today
		$where_qSent = array("parent_iti_id" => 0);
		$where_qSentLike = array("quotation_sent_date" => date('Y-m-d'), "lead_created" => date('Y-m-d') );
		$data['totalQuotSentToday']	= $this->dashboard_model->count_all_data("itinerary", $where_qSent, $where_qSentLike);
		
		//Total Revised Quotation Sent Today
		$where_qSent = array( "parent_iti_id !=" => 0);
		$where_qSentLike = array("quotation_sent_date" => date('Y-m-d'), "lead_created" => date('Y-m-d') );
		$data['totalRevQuotSentToday']	= $this->dashboard_model->count_all_data("itinerary", $where_qSent, $where_qSentLike);
		
		//Total Leads of Created Today
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
		* *******Todays Revised Section *******
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
		
		//Total Revised Leads Decline Today Leads 
		$where_dAppr = array('cus_status' => 8, "del_status" => 0, "created <" => date('Y-m-d')  );
		$wDcLike = array("lead_last_followup_date" => date('Y-m-d') );
		$data['pastDecLeadsToday']	= $this->dashboard_model->count_all_data("customers_inquery", $where_dAppr, $wDcLike);
		
		/****************************** 
		* *******Month Section *******
		******************************/
		
		//Get Leads from current month  
		$where_leads = array("del_status" => 0, );
		$where_like = array("created" => date('Y-m') );
		$data['totalLeadsMonth']	= $this->dashboard_model->count_all_data("customers_inquery", $where_leads, $where_like);
		
		//Total Unwork Leads This Month 
		$whLeadM = array('cus_status' => 0, "del_status" => 0);
		$wDcLkeM = array( "created" => date('Y-m') , "cus_last_followup_status" => 0  );
		$data['totalUnworkLeadsMonth']	= $this->dashboard_model->count_all_data("customers_inquery", $whLeadM, $wDcLkeM);
		
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
		
		/****************************** 
		* *******Price Section *******
		******************************/
		//Itinerary Pending Rates
		$where_pr = array("del_status" => 0, "iti_status" => 0, "pending_price" => 1 );
		$orWhere = array('discount_rate_request' => 1 );
		$penLike = "";
		$data['itiPendingRates']	= $this->dashboard_model->getdatafilter("itinerary", $where_pr,"pending_price_date", $limit, $penLike, $orWhere);
		
		//Itinerary approved Rates limit=5
		$where_Appr = array("pending_price" => 2, "del_status" => 0 );
		$where_ApprLike = array("approved_price_date" => date('Y-m-d') );
		$data['itiAppRates']	= $this->dashboard_model->getdatafilter("itinerary", $where_Appr, "approved_price_date", $limit,$where_ApprLike);
		
		
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
			$result = $this->dashboard_model->getAllCustomerFollowup_by_agent( $user_id );
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
			
			$unique_res = array();
			$unique_res = $this->_unique_multidim_array($data_events,'cus_id', "e_date");
			echo json_encode( $unique_res );
		}
		exit();

	}
	
	private function _unique_multidim_array($array, $key, $key2) { 
		$temp_array = array(); 
		$i = 0; 
		$key_array = array(); 
		foreach($array as $val) { 
			//concatenate two keys
			$tempVal = $val[$key] . "_" . $val[$key2];
			//if values not found in array
			if ( !in_array( $tempVal , $key_array) ) {
				$key_array[$i] = $tempVal; 
				
				$temp_array[] = array(
				"id" 			=> $val["cus_id"],
				"cus_id" 		=> $val["cus_id"],
				"temp_key" 		=> $val["temp_key"],
				"title"			=> $val["title"],
				"end" 			=> $val["end"],
				"start" 		=> $val["start"],
				"nextCall" 		=> $val["nextCall"],
				"url" 			=> $val["url"],
				"agent" 		=> $val["agent"],
				); 
			} 
			$i++; 
		} 
		return $temp_array; 
	}
	
	/*Get all Itineraries Follow up For Calendar */
	public function getAllItiFollowup(){
		$user = $this->session->userdata('logged_in');
		$data['user_id'] = $user['user_id'];
		$user_id = $user['user_id'];
		
		if( $user['role'] == '99' || $user['role'] == '98' ){
			$result = $this->dashboard_model->getAllItiFollowup();
		}else if( $user['role'] == '96' ){	
			$result = $this->dashboard_model->getAllItiFollowup_by_agent( $user_id );
		}else{
			$result = "";
		}
		
		$data_events = array();
		if( !empty( $result ) ){
			foreach($result as $r) {
				//Convert time to 24 hours Format
				$e_date = $r->nextCallDate;
				
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
				);
			}
			
			$unique_res = array();
			$unique_res = $this->_unique_multidim_iti_array($data_events,'iti_id', "e_date");
			echo json_encode( $unique_res );
		}
		exit();

	}
	
	private function _unique_multidim_iti_array($array, $key, $key2) { 
		$temp_array = array(); 
		$i = 0; 
		$key_array = array(); 
		foreach($array as $val) { 
			//concatenate two keys
			$tempVal = $val[$key] . "_" . $val[$key2];
			//if values not found in array
			if ( !in_array( $tempVal , $key_array) ) {
				$key_array[$i] = $tempVal; 
				
				$temp_array[] = array(
				"id" 			=> $val["iti_id"],
				"iti_id" 		=> $val["iti_id"],
				"temp_key" 		=> $val["temp_key"],
				"title"			=> $val["title"],
				"end" 			=> $val["end"],
				"start" 		=> $val["start"],
				"nextCall" 		=> $val["nextCall"],
				"url" 			=> $val["url"],
				); 
			} 
			$i++; 
		} 
		return $temp_array; 
	}
	
	/*Get all payment Follow up For Calendar */
	public function getAllPaymentFollowupCalendar(){
		$user = $this->session->userdata('logged_in');
		$data['user_id'] = $user['user_id'];
		$user_id = $user['user_id'];
		
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '97' ){
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
		
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '97' ){
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
		
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '97' ){
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
