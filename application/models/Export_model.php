<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Export_model extends CI_Model{
	function __construct(){
        parent::__construct();
	}
	
	//Export itinerary data
	public function get_itinerary_data( $date_from = "" , $date_to = "", $agent_id = "" ){
		$this->db->select('itinerary.iti_id,itinerary.parent_iti_id,itinerary.package_name, itinerary.package_routing, itinerary.duration, itinerary.adults,itinerary.child,itinerary.child_age,itinerary.quatation_date,itinerary.cab_category,iti_status,final_amount,cus.customer_id, cus.agent_id, cus.created, cus.customer_name,cus.customer_contact,cus.customer_email, cus.cus_status,pay.travel_date, pay.advance_recieved, pay.agent_margin');
		
		$this->db->from('customers_inquery as cus')
		->join('itinerary as itinerary', 'cus.customer_id = itinerary.customer_id', 'LEFT')
		->join('iti_payment_details as pay', 'itinerary.iti_id = pay.iti_id', 'LEFT')
		->where("cus.created >=", date('Y-m-d', strtotime($date_from)) )
		->where("cus.created <=", date('Y-m-d H:i:s', strtotime($date_to . "23:59:59")) ); 
		
		//If agent_id exists
		if( $agent_id != "all" ){
			$this->db->where("cus.agent_id", $agent_id);
		}
		
		$this->db->order_by("itinerary.iti_id", "DESC");
		$q = $this->db->get();
		return $q->result();
	}	
	
	//Export Marketing user data
	public function get_marketing_user_data( $state = '' , $city='' , $category = '' ){
		$this->db->where( array( "state" => $state, "cat_id" => $category ) );
		if( !empty( $city ) && is_numeric( $city ) ){
			$this->db->where( "city", $city );
		}
		$this->db->from("marketing");
		$this->db->order_by("id", "DESC");
		$q = $this->db->get();
		return $q->result();
	}	
	
	//Export Marketing user data
	public function get_ref_customers_data( $state = '' , $city='' ){
		$this->db->where( array( "state" => $state ) );
		if( !empty( $city ) && is_numeric( $city ) ){
			$this->db->where( "city", $city );
		}
		$this->db->from("reference_customers");
		$this->db->order_by("id", "DESC");
		$q = $this->db->get();
		return $q->result();
	}	
	
	
	//datatable view all Itinerary
	public function export_itinerary_fiter_data($where){
		$user = $this->session->userdata('logged_in');
		$role = $user['role'];
		
		$this->db->select('itinerary.*,cus.customer_name,cus.customer_contact,cus.customer_email,pay.travel_date, pay.second_payment_bal, pay.second_payment_date, pay.third_payment_bal, pay.third_payment_date , pay.final_payment_bal,pay.final_payment_date,pay.second_pay_status,pay.third_pay_status, pay.final_pay_status, pay.advance_recieved,pay.agent_margin, pay.booking_date'); 
		
		//$this->db->select('itinerary.*,cus.customer_name,cus.customer_contact,cus.customer_email,pay.travel_date');
		$this->db->from('itinerary as itinerary')
		->join('customers_inquery as cus', 'itinerary.customer_id = cus.customer_id', 'INNER')
		->join('iti_payment_details as pay', 'itinerary.iti_id = pay.iti_id', 'LEFT')
		->join('iti_followup AS iti_f', 'itinerary.iti_id = iti_f.iti_id', 'LEFT')
		->join('iti_vouchers_status AS iti_v', 'itinerary.iti_id = iti_v.iti_id AND iti_v.confirm_voucher = 1', 'LEFT');
		
		//Service team show if voucher not confirmed
		if( $role == 97 ){
			$this->db->where("iti_v.iti_id IS NULL");
		}
		
		//add custom filter with Date Range
		if( isset( $_GET['filter'] ) && isset( $_GET['d_from'] ) && isset( $_GET['end'] ) ){
			$filter_data 	= trim($_GET['filter']);
			$date_from	 	= $_GET['d_from'];
			$date_end 		= $_GET['end'];
			
			//For Today's Stat
			if( isset( $_GET['todayStatus'] ) && !empty( $_GET['todayStatus'] ) ){
				$today = $_GET['todayStatus'];
				//date can be month or day format eg: Y-m or Y-m-d
				$todayDate = $today;
				//$todayDate = date('Y-m-d', strtotime($today));
				switch( $filter_data ){
					case "9":
						$this->db->where( "itinerary.iti_status", "9" );
						$this->db->like( array(  "itinerary.iti_decline_approved_date" => $todayDate, "itinerary.lead_created" => $todayDate ) );
						break;
					case "approved":
						$this->db->where( "itinerary.iti_status", "9" );
						$this->db->like( array(  "itinerary.iti_decline_approved_date" => $todayDate ) );
						break;
					case "revApproved":
						$this->db->where( "itinerary.iti_status", "9" );
						$this->db->where( "itinerary.lead_created <", $todayDate  );
						$this->db->like( array(  "itinerary.iti_decline_approved_date" => $todayDate ) );
						break;
					case "revDecline":
						$this->db->where( "itinerary.iti_status", "7" );
						$this->db->where( "itinerary.lead_created <", $todayDate  );
						$this->db->like( array(  "itinerary.iti_decline_approved_date" => $todayDate ) );
						break;
					case "7":
						$this->db->where( "itinerary.iti_status", "7" );
						$this->db->like( array(  "itinerary.iti_decline_approved_date" => $todayDate, "itinerary.lead_created" => $todayDate ) );
						break;
					case "pending":
						$this->db->where( array( "itinerary.iti_status" => "0", "itinerary.publish_status" => "publish" ) );
						$this->db->like( "itinerary.lead_created", $todayDate );
					break;
					case "Qsent":
						$this->db->where( "itinerary.parent_iti_id" , 0 );
						$this->db->like( array( "itinerary.lead_created" => $todayDate, "itinerary.quotation_sent_date" => $todayDate ) );
					break;
					case "QsentPast":
						$this->db->where("itinerary.lead_created <", $todayDate );
						$this->db->like( array("itinerary.quotation_sent_date" => $todayDate ));
					break;
					case "QsentRevised":
						$this->db->where( "itinerary.parent_iti_id !=" , 0 );
						$this->db->like( array( "itinerary.quotation_sent_date" => $todayDate, "itinerary.lead_created" => $todayDate ) );
					break;
					case "getFollowUp":
						//$this->db->where("iti_f.call_status", 0 );
						//$this->db->like("iti_f.nextCallDate", $todayDate);
						//$this->db->join('iti_followup AS ifup', 'customers_inquery.customer_id = ifup.customer_id', 'LEFT');
						//$this->db->where( "cf.call_status = 0 AND cf.nextCallDate LIKE '%$todayDate%'");
						//$this->db->or_where( "ifup.call_status = 0 AND ifup.nextCallDate LIKE '%$todayDate%'");
						$this->db->join('iti_followup AS ifup', 'customers_inquery.customer_id = ifup.customer_id', 'LEFT');
						$this->db->where( "(( cf.call_status = 0 AND cf.nextCallDate LIKE '%$todayDate%') 	OR ( ifup.call_status = 0 AND ifup.nextCallDate LIKE '%$todayDate%' ))");
					break;	
					case "all":
						$this->db->like( "itinerary.added", $todayDate );
						break;
					default:
						continue2;
				} 
			}else if( !empty($filter_data) && !empty($date_from) && !empty($date_end) ){
				$_month = date('Y-m', strtotime($date_from));
				switch( $filter_data ){
					case "9":
						$this->db->where( "itinerary.iti_status", "9" );
						$this->db->where("itinerary.iti_decline_approved_date >=", date('Y-m-d', strtotime($date_from)) );
						$this->db->where("itinerary.iti_decline_approved_date <=", date('Y-m-d H:i:s', strtotime($date_end . "23:59:59")) );
						break;
					case "7":
						$this->db->where( "itinerary.iti_status", "7" );
						$this->db->where("itinerary.iti_decline_approved_date >=", date('Y-m-d', strtotime($date_from)) );
						$this->db->where("itinerary.iti_decline_approved_date <=", date('Y-m-d H:i:s', strtotime($date_end . "23:59:59")) );
						break;
					case "pending":
						$this->db->where( array( "itinerary.iti_status" => "0", "itinerary.publish_status" => "publish" ) );
						$this->db->where("iti_f.iti_id IS NOT NULL");
						$this->db->where("itinerary.added >=", date('Y-m-d', strtotime($date_from)) );
						$this->db->where("itinerary.added <=", date('Y-m-d H:i:s', strtotime($date_end . "23:59:59")) ); 
						break;
					case "notwork": //not work if folloup not take
						$this->db->join('iti_followup AS iti_ff', 'itinerary.iti_id = iti_ff.parent_iti_id', 'LEFT');
						$this->db->where( array( "itinerary.iti_status" => "0", "itinerary.publish_status" => "publish" ) );
						$this->db->where("iti_f.iti_id IS NULL");
						$this->db->where("iti_ff.iti_id IS NULL");
						$this->db->where("itinerary.added >=", date('Y-m-d', strtotime($date_from)) );
						$this->db->where("itinerary.added <=", date('Y-m-d H:i:s', strtotime($date_end . "23:59:59")) );
						break;
					case "draft":
						$this->db->where( "itinerary.publish_status", "draft" );
						$this->db->where("itinerary.added <=", date('Y-m-d H:i:s', strtotime($date_end . "23:59:59")) ); 
						break;
					case "QsentMonth":
						$this->db->where("itinerary.quotation_sent_date >=", date('Y-m-d', strtotime($date_from)) );
						$this->db->where("itinerary.quotation_sent_date <=", date('Y-m-d H:i:s', strtotime($date_end . "23:59:59")) );
						break;
					case "revised":
						$this->db->where("itinerary.is_amendment", 2 );
						break;
					case "travel_date":
						$this->db->where("pay.travel_date >=", date('Y-m-d', strtotime($date_from)));
						$this->db->where("pay.travel_date <=", date('Y-m-d', strtotime($date_end)));
						break;
					case "temp_travel_date":
						$this->db->where("DATE_FORMAT(STR_TO_DATE(itinerary.t_start_date , '%d/%m/%Y'), '%Y-%m-%d') >=", date('Y-m-d', strtotime($date_from)));
						$this->db->where("DATE_FORMAT(STR_TO_DATE(itinerary.t_start_date , '%d/%m/%Y'), '%Y-%m-%d') <=", date('Y-m-d', strtotime($date_end)));
						break;
					case "QsentPastMonth":
						$this->db->where("itinerary.lead_created <", $date_from );
						$this->db->like( array("itinerary.quotation_sent_date" => $_month ));
						break;
					case "revApprovedMonth":
						$this->db->where( "itinerary.iti_status", "9" );
						$this->db->where( "itinerary.lead_created <", $date_from  );
						$this->db->like( array(  "itinerary.iti_decline_approved_date" => $_month ) );
						break;
					case "revDeclineMonth":
						$this->db->where( "itinerary.iti_status", "7" );
						$this->db->where( "itinerary.lead_created <", $date_from  );
						$this->db->like( array(  "itinerary.iti_decline_approved_date" => $_month ) );
						break;
					case "all":
						$this->db->where("itinerary.added >=", date('Y-m-d', strtotime($date_from)) );
						$this->db->where("itinerary.added <=", date('Y-m-d H:i:s', strtotime($date_end . "23:59:59")) ); 
						break;
					default:
						continue2;
				} 
			}
        }
		//End Filter section
		if (!empty($where)) {
			foreach($where as $key => $value){
				$this->db->where( $key, $value );
			}
        }
		$this->db->group_by( "itinerary.iti_id" );
		$this->db->order_by( "itinerary.iti_id" );
		$query = $this->db->get();
		return $query->result();
	}
	
	
	//datatable view all customers
	public function export_customers_fiter_data( $where ){
		$this->db->select('customers_inquery.*');
        $this->db->from('customers_inquery AS customers_inquery');
		$this->db->join('customer_followup AS cf', 'customers_inquery.customer_id = cf.customer_id', 'LEFT');
		
		//add custom filter with Date Range
		if( isset( $_GET['filter'] ) && isset( $_GET['d_from'] ) && isset( $_GET['end'] ) ){
			$filter_data = trim($_GET['filter']);
			$date_from 	 = $_GET['d_from'];
			$date_end 	 = $_GET['end'];
			if( isset( $_GET['todayStatus'] ) && !empty( $_GET['todayStatus'] ) ){
				$date = $_GET['todayStatus'];
				$todayDate = $date;
				switch( $filter_data ){
					case "9":
						$this->db->where( "customers_inquery.cus_status", "9" );
						$this->db->like( "customers_inquery.lead_last_followup_date", $todayDate );
						break;
					case "8":
						$this->db->where( "customers_inquery.cus_status", "8" );
						$this->db->like( array( "customers_inquery.lead_last_followup_date" => $todayDate, "customers_inquery.created" => $todayDate ) );
						break;
					case "revDeclineLeads":
						$this->db->where( "customers_inquery.cus_status", "8" );
						$this->db->where( "customers_inquery.created <", $todayDate );
						$this->db->like( array( "customers_inquery.lead_last_followup_date" => $todayDate ) );
						break;
					case "callpicked":
						$this->db->where( 'customers_inquery.cus_last_followup_status' ,"Picked call");
						$this->db->like( array( "customers_inquery.lead_last_followup_date" => $todayDate, "customers_inquery.created" => $todayDate ) );
						break;
					case "callnotpicked":
						$this->db->where( 'customers_inquery.cus_last_followup_status' ,"Call not picked");
						$this->db->like( array( "customers_inquery.lead_last_followup_date" => $todayDate, "customers_inquery.created" => $todayDate ) );
						break;
					case "unwork":
						$this->db->like( array( "customers_inquery.created" => $todayDate, "customers_inquery.cus_last_followup_status" => 0  ) );
						break;
					case "pending":
						$this->db->where( array( "customers_inquery.cus_status" => "0" ) );
						$this->db->like( "customers_inquery.created", $todayDate );
					break;
					//if get todays customer follow up
					case "getFollowUp":
						$this->db->join('iti_followup AS ifup', 'customers_inquery.customer_id = ifup.customer_id', 'LEFT');
						$this->db->where( "(( cf.call_status = 0 AND cf.nextCallDate LIKE '%$todayDate%') 	OR ( ifup.call_status = 0 AND ifup.nextCallDate LIKE '%$todayDate%' ))");
						
						//$this->db->join('iti_followup AS ifup', 'customers_inquery.customer_id = ifup.customer_id', 'LEFT');
						//$this->db->where( "cf.call_status = 0 AND cf.nextCallDate LIKE '%$todayDate%'");
						//$this->db->or_where( "ifup.call_status = 0 AND ifup.nextCallDate LIKE '%$todayDate%'");
						//$this->db->where("cf.call_status", 0 );
						//$this->db->like("cf.nextCallDate", $todayDate);
					break;
					
					case "all":
						$this->db->like( "customers_inquery.created", $todayDate );
						break;
					default:
						continue2;
				} 
			}else if( !empty($filter_data) && !empty($date_from) && !empty($date_end) ){
				$d_from 	= date('Y-m-d', strtotime($date_from));
				$d_to	 	= date('Y-m-d H:i:s', strtotime($date_end . "23:59:59"));
				$_month	 = date('Y-m', strtotime($date_from));
				switch( $filter_data ){
					case "9":
						$this->db->where( "customers_inquery.cus_status", "9" );
						$this->db->where("customers_inquery.lead_last_followup_date >=", $d_from );
						$this->db->where("customers_inquery.lead_last_followup_date <=", $d_to );
						break;
					case "8":
						$this->db->where( "customers_inquery.cus_status", "8" );
						$this->db->where("customers_inquery.lead_last_followup_date >=", $d_from );
						$this->db->where("customers_inquery.lead_last_followup_date <=", $d_to );
						break;
					case "callpicked":
						$this->db->where( "customers_inquery.cus_status", "Picked call" );
						$this->db->where("customers_inquery.lead_last_followup_date", $d_from );
						$this->db->where("customers_inquery.lead_last_followup_date <=", $d_to );
						$this->db->like( array( "customers_inquery.lead_last_followup_date" => $_month, "customers_inquery.created" => $_month ) );
						break;
					case "callnotpicked":
						$this->db->where( "customers_inquery.cus_status", "Call not picked" );
						$this->db->where("customers_inquery.lead_last_followup_date >=", $d_from );
						$this->db->where("customers_inquery.lead_last_followup_date <=", $d_to );
						break;
					case "pending":
						$this->db->where( array( "customers_inquery.cus_status" => "0" ) );
						$this->db->where("cf.customer_id IS NOT NULL");
						$this->db->where("customers_inquery.created >=", $d_from );
						$this->db->where("customers_inquery.created <=", $d_to ); 
						break;
					case "notwork": //not work if folloup not take
						$this->db->where( array( "customers_inquery.cus_status" => "0" ) );
						$this->db->where("cf.customer_id IS NULL");
						$this->db->where("customers_inquery.created >=", $d_from );
						$this->db->where("customers_inquery.created <=", $d_to ); 
					break;
						
					case "revDeclineLeadsMonth":
						$this->db->where( "customers_inquery.cus_status", "8" );
						$this->db->where( "customers_inquery.created <", $d_from );
						$this->db->like( array( "customers_inquery.lead_last_followup_date" => $_month ) );
						break;
					case "all":
						$this->db->where("customers_inquery.created >=", $d_from );
						$this->db->where("customers_inquery.created <=", $d_to ); 
						break;
					default:
						continue2;
				} 
			}
        }
		
		//End Filter section
		if (!empty($where)) {
			foreach($where as $key => $value){
				$this->db->where( $key, $value );
			}
        }
		
		$this->db->group_by( "customers_inquery.customer_id" );
		$this->db->order_by( "customers_inquery.customer_id" );
		$query = $this->db->get();
		return $query->result();
	}
	
	//export data after merge iti and cus
	public function export_customers_merge_fiter_data( $where ){
		ini_set('max_execution_time', 10000);
		
		$this->db->select('customers_inquery.*,pay.travel_date,pay.iti_booking_status as booking_status, cf.customer_id as followup_id, itinerary.iti_status, itinerary.package_name');
        $this->db->from('customers_inquery AS customers_inquery');
		$this->db->join('customer_followup AS cf', 'customers_inquery.customer_id = cf.customer_id', 'LEFT')
		->join('itinerary as itinerary', 'customers_inquery.customer_id = itinerary.customer_id', 'LEFT')
		->join('iti_payment_details as pay', 'customers_inquery.customer_id = pay.customer_id', 'LEFT');
		
		//add custom filter with Date Range
		if( isset( $_GET['filter'] ) && isset( $_GET['d_from'] ) && isset( $_GET['end'] ) ){
			$filter_data = trim($_GET['filter']);
			$date_from 	 = $_GET['d_from'];
			$date_end 	 = $_GET['end'];
			if( isset( $_GET['todayStatus'] ) && !empty( $_GET['todayStatus'] ) ){
				$date = $_GET['todayStatus'];
				//date can be month or day format eg: Y-m or Y-m-d
				$todayDate = $date;
				//$todayDate = date('Y-m-d', strtotime($today));
				switch( $filter_data ){
					case "9":
						//$this->db->where( "customers_inquery.cus_status", "9" );
						//$this->db->like( "customers_inquery.lead_last_followup_date", $todayDate );
						$this->db->where( "itinerary.iti_status", "9" );
						$this->db->like( array(  "itinerary.iti_decline_approved_date" => $todayDate, "itinerary.lead_created" => $todayDate ) );
						break;
					case "approved":
						$this->db->where( "itinerary.iti_status", "9" );
						$this->db->like( array(  "itinerary.iti_decline_approved_date" => $todayDate ) );
						break;
					case "revApproved":
						$this->db->where( "itinerary.iti_status", "9" );
						$this->db->where( "itinerary.lead_created <", $todayDate  );
						$this->db->like( array(  "itinerary.iti_decline_approved_date" => $todayDate ) );
						break;
					case "8":
						$this->db->where( "customers_inquery.cus_status", "8" );
						$this->db->like( array( "customers_inquery.lead_last_followup_date" => $todayDate, "customers_inquery.created" => $todayDate ) );
						break;
					case "declined":
						$this->db->where( "customers_inquery.cus_status", "8" );
						$this->db->like( array( "customers_inquery.lead_last_followup_date" => $todayDate ) );
						break;
					case "revDeclineLeads":
						$this->db->where( "customers_inquery.cus_status", "8" );
						$this->db->where( "customers_inquery.created <", $todayDate );
						$this->db->like( array( "customers_inquery.lead_last_followup_date" => $todayDate ) );
						break;
					case "callpicked":
						$this->db->where( 'customers_inquery.cus_last_followup_status' ,"Picked call");
						$this->db->like( array( "customers_inquery.lead_last_followup_date" => $todayDate, "customers_inquery.created" => $todayDate ) );
						break;
					case "callnotpicked":
						$this->db->where( 'customers_inquery.cus_last_followup_status' ,"Call not picked");
						$this->db->like( array( "customers_inquery.lead_last_followup_date" => $todayDate, "customers_inquery.created" => $todayDate ) );
						break;
					case "unwork":
						$this->db->like( array( "customers_inquery.created" => $todayDate, "customers_inquery.cus_last_followup_status" => 0  ) );
						break;
					case "pending":
						$this->db->where("(customers_inquery.cus_status = 0 OR itinerary.iti_status = 0 )");
						//$this->db->where( array( "customers_inquery.cus_status" => "0" ) );
						$this->db->like( "customers_inquery.created", $todayDate );
					break;
					//if get todays customer follow up customers_inquery
					case "getFollowUp":
						$this->db->join('iti_followup AS ifup', 'customers_inquery.customer_id = ifup.customer_id', 'LEFT');
						$this->db->where( "(( cf.call_status = 0 AND cf.nextCallDate LIKE '%$todayDate%') 	OR ( ifup.call_status = 0 AND ifup.nextCallDate LIKE '%$todayDate%' ))");
						//$this->db->or_where( "ifup.call_status = 0 AND ifup.nextCallDate LIKE '%$todayDate%'");
						//$this->db->where("cf.call_status", 0 );
						//$this->db->like("cf.nextCallDate", $todayDate);
					break;
					case "Qsent":
						$this->db->where( "itinerary.parent_iti_id" , 0 );
						$this->db->like( array( "itinerary.lead_created" => $todayDate, "itinerary.quotation_sent_date" => $todayDate ) );
					break;
					case "QsentPast":
						$this->db->where("itinerary.lead_created <", $todayDate );
						$this->db->like( array("itinerary.quotation_sent_date" => $todayDate ));
					break;
					case "QsentRevised":
						$this->db->where( "itinerary.parent_iti_id !=" , 0 );
						$this->db->like( array( "itinerary.quotation_sent_date" => $todayDate, "itinerary.lead_created" => $todayDate ) );
					break;
					case "all":
						$this->db->like( "customers_inquery.created", $todayDate );
						break;
					default:
						continue2;
				} 
			}else if( !empty($filter_data) && !empty($date_from) && !empty($date_end) ){
				$d_from 	= date('Y-m-d', strtotime($date_from));
				$d_to	 	= date('Y-m-d H:i:s', strtotime($date_end . "23:59:59"));
				$_month	 	= date('Y-m', strtotime($date_from));
				switch( $filter_data ){
					case "9":
						//$this->db->where( "customers_inquery.cus_status", "9" );
						//$this->db->where("customers_inquery.lead_last_followup_date >=", $d_from );
						//$this->db->where("customers_inquery.lead_last_followup_date <=", $d_to );
						$this->db->where( "itinerary.iti_status", "9" );
						$this->db->where("itinerary.iti_decline_approved_date >=", $d_from );
						$this->db->where("itinerary.iti_decline_approved_date <=", $d_to );
						break;
					case "8":
						$this->db->where( "customers_inquery.cus_status", "8" );
						$this->db->where("customers_inquery.lead_last_followup_date >=", $d_from );
						$this->db->where("customers_inquery.lead_last_followup_date <=", $d_to );
						break;
					case "callpicked":
						$this->db->where( "customers_inquery.cus_status", "Picked call" );
						$this->db->where("customers_inquery.lead_last_followup_date", $d_from );
						$this->db->where("customers_inquery.lead_last_followup_date <=", $d_to );
						$this->db->like( array( "customers_inquery.lead_last_followup_date" => $_month, "customers_inquery.created" => $_month ) );
						break;
					case "callnotpicked":
						$this->db->where( "customers_inquery.cus_status", "Call not picked" );
						$this->db->where("customers_inquery.lead_last_followup_date >=", $d_from );
						$this->db->where("customers_inquery.lead_last_followup_date <=", $d_to );
						break;
					case "pending":
						//$this->db->where( array( "customers_inquery.cus_status" => "0" ) );
						$this->db->where("((customers_inquery.cus_status = 0 AND cf.customer_id IS NOT NULL) OR itinerary.iti_status = 0 )");
						$this->db->where("customers_inquery.created >=", $d_from );
						$this->db->where("customers_inquery.created <=", $d_to ); 
						break;
					case "notwork": //not work if folloup not take
						$this->db->where( array( "customers_inquery.cus_status" => "0" ) );
						$this->db->where("cf.customer_id IS NULL");
						$this->db->where("customers_inquery.created >=", $d_from );
						$this->db->where("customers_inquery.created <=", $d_to ); 
					break;
					case "revDeclineLeadsMonth":
						$this->db->where( "customers_inquery.cus_status", "8" );
						$this->db->where( "customers_inquery.created <", $d_from );
						$this->db->like( array( "customers_inquery.lead_last_followup_date" => $_month ) );
						break;
					case "all":
						$this->db->where("customers_inquery.created >=", $d_from );
						$this->db->where("customers_inquery.created <=", $d_to ); 
						break;
					case "revised":
						$this->db->where("itinerary.is_amendment", 2 );
						$this->db->where("customers_inquery.created >=", $d_from );
						$this->db->where("customers_inquery.created <=", $d_to ); 
						break;
					case "hold":
						//$this->db->where( array( "itinerary.iti_status" => "9", "itinerary.publish_status" => "publish" ) );
						$this->db->where( array( "itinerary.publish_status" => "publish" ) );
						$this->db->where("pay.iti_booking_status !=", 0 );
						$this->db->where("customers_inquery.created >=", $d_from );
						$this->db->where("customers_inquery.created <=", $d_to ); 
						break;
					case "draft":
						$this->db->where( "itinerary.publish_status", "draft" );
						$this->db->where("customers_inquery.created >=", $d_from );
						$this->db->where("customers_inquery.created <=", $d_to ); 
						break;
					case "travel_date":
						$this->db->where("pay.travel_date >=", $d_from );
						$this->db->where("pay.travel_date <=", $d_to ); 
						break;
					case "QsentMonth":
						$this->db->where("itinerary.quotation_sent_date >=", date('Y-m-d', strtotime($date_from)) );
						$this->db->where("itinerary.quotation_sent_date <=", date('Y-m-d H:i:s', strtotime($date_end . "23:59:59")) );
						break;
					case "QsentPastMonth":
						$this->db->where("itinerary.lead_created <", $date_from );
						$this->db->like( array("itinerary.quotation_sent_date" => $_month ));
						break;
					case "revApprovedMonth":
						$this->db->where( "itinerary.iti_status", "9" );
						$this->db->where( "itinerary.lead_created <", $date_from  );
						$this->db->like( array(  "itinerary.iti_decline_approved_date" => $_month ) );
						break;
					case "revDeclineMonth":
						$this->db->where( "itinerary.iti_status", "7" );
						$this->db->where( "itinerary.lead_created <", $date_from  );
						$this->db->like( array(  "itinerary.iti_decline_approved_date" => $_month ) );
						break;
					default:
						continue2;
				} 
			}
        }
		//End Filter section
		
		//End Filter section
		if (!empty($where)) {
			foreach($where as $key => $value){
				$this->db->where( $key, $value );
			}
        }
		
		$this->db->group_by( "customers_inquery.customer_id" );
		$this->db->order_by( "customers_inquery.customer_id" );
		$query = $this->db->get();
		return $query->result();
	}		
	
	
	//customer next followup time
	function check_cus_next_followup_time( $customer_id, $date ){
		$sql = "SELECT cf.customer_id, cf.nextCallDate as next_cus_followup , cf.call_status, itf.nextCallDate as next_iti_followup, itf.call_status as cfs FROM `customer_followup` as cf
		LEFT JOIN iti_followup as itf ON ( cf.customer_id = itf.customer_id )
		WHERE cf.customer_id = {$customer_id} AND ( (cf.call_status = 0 AND cf.nextCallDate LIKE '%{$date}%' )  OR ( itf.call_status = 0 AND itf.nextCallDate LIKE '%{$date}%' ) ) GROUP by cf.customer_id";
		$q = $this->db->query($sql);
		$result = $q->result();
		if( !empty($result) && isset( $result[0]->next_cus_followup ) ) {
			return !empty( $result[0]->next_iti_followup ) ? $result[0]->next_iti_followup : $result[0]->next_cus_followup;
		}
		return false;
	}
}
?>
