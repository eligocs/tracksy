<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Dashboard_Model extends CI_Model{
	function __construct(){
        parent::__construct();
		validate_login();
	}
	
	//get picked call data
	public function getCallData($where, $limit = "") {
        $table = "customer_followup";
		// set the timezone first
		if(function_exists('date_default_timezone_set')) {
			date_default_timezone_set("Asia/Kolkata");
		}
		// then use the date functions, not the other way around
		$today = date("Y-m-d h:i:s");
		$this->db->where("str_to_date(nextCallDate, '%Y-%m-%d %h:%i') >= ", $today);
		
		if (!empty($where)) {
			foreach($where as $key => $value){
				$this->db->where( $key, $value );
			}
        }
		
		//$this->db->where( "callType", "Picked call" );
		$this->db->from($table);
		$this->db->order_by("nextCallDate", "ASC");
		//if limit exists
		if (!empty($limit)) {
			$this->db->limit($limit);
		}	

		$q = $this->db->get();
		$res = $q->result();
		if ($res) {
			$result = $res;
        } else {
            $result = false;
        }
        return $result;
    }
	
	//Count data
	public function count_all_data( $table_name, $where = array(), $like = array(), $notLike = array() , $where_in = array() ){
		
		//where
		if (!empty($where)) {
			foreach($where as $key => $value){
				$this->db->where( $key, $value );
			}
        }
		
		//where in
		if( !empty( $where_in ) ){
			foreach($where_in as $key => $value){
				$this->db->where_in( $key, $value );
			}
		}
		
		//IF LIKE NOT EMPTY
		if (!empty($like)) {
			foreach($like as $key => $value){
				$this->db->like( $key, $value );
			}
        }
		
		//IF NOT LIKE NOT EMPTY
		if (!empty($notLike)) {
			foreach($notLike as $key => $value){
				$this->db->not_like( $key, $value );
			}
        }
		

		$this->db->from($table_name);
		return $this->db->count_all_results();
	}
	
	
	//Count booked iti 
	public function count_all_iti_booked( $date ){
		$this->db->select('itinerary.iti_id')
		->from('itinerary as itinerary')
		->join('iti_payment_details as pay', 'itinerary.iti_id = pay.iti_id', 'INNER')
		->where("itinerary.del_status", 0)
		->where("itinerary.iti_status", 9)
		->where("pay.iti_booking_status", 0)
		->like( "itinerary.iti_decline_approved_date", $date );
		return $this->db->count_all_results();
	}
	
	//get data all
	public function getdatafilter( $tablename, $where = array(), $order_key = '', $limit="", $like=array() , $orWhere = array(), $whereAnd = "", $order_key_ASC = "", $distinct = "" , $where_in = array() ) {
        $table = $tablename;
		//Distinct
		//$this->db->distinct('customer_id');
		
		if (!empty($where)) {
			foreach($where as $key => $value){
				$this->db->where( $key, $value );
			}
        }
		
		//where in
		if( !empty( $where_in ) ){
			foreach($where_in as $key => $value){
				$this->db->where_in( $key, $value );
			}
		}
		
		//OR WHERE
		if (!empty($orWhere)) {
			foreach($orWhere as $key => $value){
				$this->db->or_where( $key, $value );
			}
        }
		
		//and where
		if (!empty($whereAnd)) {
			$this->db->where( $whereAnd );
        }
		
		//IF LIKE NOT EMPTY
		if (!empty($like)) {
		    $this->db->group_start();
			foreach($like as $key => $value){
				$this->db->like( $key, $value );
			}
			$this->db->group_end();
        }
		
		$this->db->from($table);
		
		if( !empty ($order_key)){
			$this->db->order_by($order_key, "DESC");
		}
		
		//ASC
		if( !empty ($order_key_ASC)){
			$this->db->order_by($order_key_ASC, "ASC");
		}
		
		//if limit exists
		if (!empty($limit)) {
			$this->db->limit($limit);
		}
        $q = $this->db->get();
		$res = $q->result();
		if ($res) {
			$result = $res;
        } else {
            $result = false;
        }
        return $result;
    }
	
	/* Get Count Today Status by agent */
	function countTodayLeadsFollowup_by_agent( $agent_id, $callType ){
		$this->db->select('C.*, CF.customer_id');
        $this->db->from('customer_followup AS CF');
        $this->db->join('customers_inquery AS C', 'C.customer_id = CF.customer_id', 'INNER');
		$this->db->like( "C.created", date('Y-m-d') );
        $this->db->like( "CF.created", date('Y-m-d') );
		$this->db->where('CF.agent_id', $agent_id);
        $this->db->where('CF.callType', $callType);
		$this->db->distinct('CF.customer_id'); 
		$q = $this->db->get();
		$res = $q->result();
		$row = count( $res );
        return $row;
	}
	
	//Get Today follow up 
	function getTodaysLeadsFollowup( $agent_id = "", $limit = "" ){
		$tod = date('Y-m-d');
		//$this->db->query("SELECT p1.* FROM customer_followup p1 LEFT JOIN customer_followup p2 ON (p1.customer_id = p2.customer_id AND p1.id < p2.id) WHERE  p1.nextCallDate LIKE '%2018-01-11%'  AND p2.id IS NULL ORDER BY p1.nextCallDate DESC");
		
		//$q = $this->db->query("SELECT p1.* FROM customer_followup p1 LEFT JOIN customer_followup p2 ON (p1.customer_id = p2.customer_id AND p1.id < p2.id) WHERE  p1.nextCallDate LIKE '%2018-01-12%' AND ( p1.callType='Picked call' OR p1.callType='Call not picked') AND p1.agent_id = 236 AND p2.id IS NULL ORDER BY p1.nextCallDate DESC");
		
		$this->db->select('C.*');
        $this->db->from('customer_followup AS C');
        $this->db->join('customer_followup AS CF', 'C.customer_id = CF.customer_id AND C.id < CF.id', 'LEFT');
		$this->db->where( "(C.callType='Picked call' OR C.callType='Call not picked') " );
		$this->db->like( "C.nextCallDate", date('Y-m-d') );
		$this->db->where("CF.id IS NULL");
		
		if( !empty( $agent_id ) ){
			$this->db->where('C.agent_id', $agent_id);
		}	
		//if limit exists
		if (!empty($limit)) {
			$this->db->limit($limit);
		}
		$this->db->order_by("C.nextCallDate", "ASC"); 
		$q = $this->db->get();
		$res = $q->result();
		
        return $res;
	}
	/*
	//Get All Customer Follow up Calendar view
	public function getAllCustomerFollowup(){
		$sql = "SELECT C.* FROM customer_followup C 
		WHERE C.nextCallDate 
		BETWEEN '" . $_GET['start'] . "' AND '". $_GET['end'] ."'
		AND C.callType IN ('Picked call','Call not picked' )
		AND C.call_status = 0 
		ORDER BY C.id DESC";  
		$q = $this->db->query($sql);
		return $q->result();
	}
	
	//Get All Itineraries Follow up Calendar view
	public function getAllItiFollowup(){
		$sql = "SELECT C.* FROM iti_followup C
		WHERE C.nextCallDate 
		BETWEEN '" . $_GET['start'] . "' AND '". $_GET['end'] ."'
		AND C.callType IN ('Picked call','Call not picked' )
		AND C.call_status = 0
		ORDER BY C.id DESC";  
		
		$q = $this->db->query($sql);
		return $q->result();
	}
	*/
	//Get All Customer Follow up By Agent ID Calendar view
	public function getAllCustomerFollowup( $agent_id = ""  ){
		$sql = "SELECT C.* FROM customer_followup C 
		WHERE C.nextCallDate 
		BETWEEN '" . $_GET['start'] . "' AND '". $_GET['end'] ."'
		AND C.callType IN ('Picked call','Call not picked' )
		AND C.call_status = 0";
		
		if( $agent_id ){
			//$sql .= " AND C.agent_id = {$agent_id}";
			$sql .= " AND C.agent_id IN({$agent_id})";
		}
		
		$sql .= " ORDER BY C.id DESC";  
		$q = $this->db->query($sql);
		return $q->result();
	}
	
	//Get All Itineraries Follow up By Agent ID Calendar view
	public function getAllItiFollowup( $agent_id = "" ){
		$sql = "SELECT C.* FROM iti_followup C 
		WHERE C.nextCallDate 
		BETWEEN '" . $_GET['start'] . "' AND '". $_GET['end'] ."'
		AND C.callType IN ('Picked call','Call not picked' )";
		
		if( $agent_id ){
			//$sql .= " AND C.agent_id = {$agent_id}";
			$sql .= " AND C.agent_id IN({$agent_id})";
		}
		$sql .= " AND C.call_status = 0 
		ORDER BY C.id DESC";
		
		$q = $this->db->query($sql);
		return $q->result();
	}
	
	//Get All Itineraries Payments Follow up  Calendar view
	public function getAllPaymentFollowupCalendar( $agent_id = "" ){
	/* 	$sql = "SELECT C.* FROM iti_payment_details C 
		WHERE C.second_payment_date BETWEEN '" . $_GET['start'] . "' AND '". $_GET['end'] ."'
		OR C.third_payment_date BETWEEN '" . $_GET['start'] . "' AND '". $_GET['end'] ."'
		OR C.final_payment_date BETWEEN '" . $_GET['start'] . "' AND '". $_GET['end'] ."'
		ORDER BY C.id DESC";  */ 
		
		$this->db->select("C.* FROM iti_payment_details C");
		$this->db->where("C.second_payment_date BETWEEN '" . $_GET['start'] . "' AND '". $_GET['end'] ."'
		OR C.third_payment_date BETWEEN '" . $_GET['start'] . "' AND '". $_GET['end'] ."'
		OR C.final_payment_date BETWEEN '" . $_GET['start'] . "' AND '". $_GET['end'] ."'");
		$this->db->where("C.iti_close_status", 0);
		$this->db->order_by("C.id", "DESC");
		$q = $this->db->get();
		
		/* $sql = "SELECT p1.*  FROM iti_payment_details p1 WHERE  
			p1.second_payment_date BETWEEN '2018-01-31' AND '2018-02-28'
			OR p1.third_payment_date BETWEEN '2018-01-31' AND '2018-02-28'
			OR p1.final_payment_date BETWEEN '2018-01-31' AND '2018-02-28'
			ORDER BY p1.next_payment_due_date DESC";  */
		
		//$q = $this->db->query($sql);
		
		return $q->result();
		
	}
	
	//Get All Itineraries payment received less than 50 %
	public function advance_payment_pending_followup( $condition = "<" ){
	 /* 	$sql = "SELECT p.* FROM iti_payment_details p 
		WHERE (p.second_payment_date BETWEEN '" . $_GET['start'] . "' AND '". $_GET['end'] ."'
		OR p.third_payment_date BETWEEN '" . $_GET['start'] . "' AND '". $_GET['end'] ."'
		OR p.final_payment_date BETWEEN '" . $_GET['start'] . "' AND '". $_GET['end'] ."')
		AND (p.second_pay_status = 'unpaid' OR p.third_pay_status = 'unpaid' OR p.final_pay_status = 'unpaid')
		AND TRUNCATE( (( p.total_package_cost - p.total_balance_amount )/p.total_package_cost  * 100 ),0) < 50
		ORDER BY p.id DESC";  
		$q = $this->db->query($sql); */
		
		$this->db->select("p.* FROM iti_payment_details p");
		$this->db->where("(p.second_payment_date BETWEEN '" . $_GET['start'] . "' AND '". $_GET['end'] ."'
		OR p.third_payment_date BETWEEN '" . $_GET['start'] . "' AND '". $_GET['end'] ."'
		OR p.final_payment_date BETWEEN '" . $_GET['start'] . "' AND '". $_GET['end'] ."')");
		$this->db->where("(p.second_pay_status = 'unpaid' OR p.third_pay_status = 'unpaid' OR p.final_pay_status = 'unpaid')");
		$this->db->where("p.iti_close_status", 0);
		$this->db->where("TRUNCATE( (( p.total_package_cost - p.total_balance_amount )/p.total_package_cost  * 100 ),0) $condition 50");
		$this->db->order_by("p.id", "DESC");
		$q = $this->db->get(); 
		
		/* $sql = "SELECT TRUNCATE( ( ( p.total_package_cost - p.total_balance_amount )/p.total_package_cost  * 100 ),0) as recieved_pay, p.*  FROM iti_payment_details p WHERE  
			(p.second_payment_date BETWEEN '2018-01-31' AND '2018-02-28'
			OR p.third_payment_date BETWEEN '2018-01-31' AND '2018-02-28'
			OR p.final_payment_date BETWEEN '2018-01-31' AND '2018-02-28')
			AND (p.second_pay_status = 'unpaid' OR p.third_pay_status = 'unpaid' OR p.final_pay_status = 'unpaid')
			AND (TRUNCATE( ( ( p.total_package_cost - p.total_balance_amount )/p.total_package_cost  * 100 ),0) < 50)
			ORDER BY p.next_payment_due_date DESC";  
			$q = $this->db->query($sql);  */
		
		return $q->result();
		
	}
	
	//Get All Travel Dates Calendar view
	public function getAllTravelDatesCalendar(){
		$this->db->select("iti_id,customer_name,travel_date");
		$this->db->from("iti_payment_details");
		$this->db->where( "travel_date BETWEEN '" . $_GET['start'] . "' AND '". $_GET['end'] . "'" );
		//$this->db->where("`travel_date` BETWEEN '2018-01-01' AND '2018-12-31' ");
		$this->db->order_by( "id", "DESC" );
		$q = $this->db->get();
		return $q->result();
	}
	
	//get todays pending payment 
	public function getTodaysPendingPayments( $limit = "" ){
		$this->db->select("*");
		$this->db->from("iti_payment_details");
		$this->db->where("iti_close_status", 0);
		$this->db->like( array( "next_payment_due_date" => date('Y-m-d') ) );
		$this->db->not_like( array( "last_payment_received_date" => date('Y-m-d') ) );
		
		//Limit
		if (!empty($limit)) {
			$this->db->limit($limit);
		}
		$this->db->order_by( "id", "DESC" );
		$q = $this->db->get();
		$res = $q->result();
		
		return $res;
	}
	
	
	
	//Get approved hotel booking which have minimum 50% iti payment received 
	public function get_approved_hotel_booking($limit=10){
		$q = $this->db->select('h.*')
			->from('hotel_booking as h')
			->join('iti_payment_details as p', 'h.iti_id = p.iti_id', 'INNER')
			->where( "concat(round(( ( p.total_package_cost - p.total_balance_amount ) / p.total_package_cost * 100 ),0)) >= 50"  )
			->where("h.booking_status",9)
			->where("h.del_status",0)
			->order_by("h.id","DESC")
			->limit($limit)
			->get();
			
		return $q->result();
	}
	
	//Get approved Cab booking which have minimum 50% iti payment received 
	public function get_approved_cab_booking($limit=10){
		$q = $this->db->select('h.*')
			->from('cab_booking as h')
			->join('iti_payment_details as p', 'h.iti_id = p.iti_id', 'INNER')
			->where( "concat(round(( ( p.total_package_cost - p.total_balance_amount ) / p.total_package_cost * 100 ),0)) >= 50"  )
			->where("h.booking_status",9)
			->where("h.del_status",0)
			->order_by("h.id","DESC")
			->limit($limit)
			->get();
			
		return $q->result();
	}
	//Get approved Volvo/train/flight booking which have minimum 50% iti payment received 
	public function get_approved_vtf_booking($where_type="", $limit=10){
		$this->db->select('h.*')
		->from('travel_booking as h')
		->join('iti_payment_details as p', 'h.iti_id = p.iti_id', 'INNER')
		->where( "concat(round(( ( p.total_package_cost - p.total_balance_amount ) / p.total_package_cost * 100 ),0)) >= 50"  )
		->where("h.booking_status",9)
		->where("h.del_status",0);
		if( !empty( $where_type ) ){
			$this->db->where( $where_type );
		}
		$this->db->order_by("h.id","DESC");
		$this->db->limit($limit);
		$q = $this->db->get();
		
		return $q->result();
	}
	
	
	//Get Amendment Pending Price
	public function get_amendment_pending_price( $agent_id = array() ){
		$this->db->select('a.*, c.customer_name, c.customer_contact')
		->from('iti_amendment_temp as a')
		->join('customers_inquery as c', 'a.customer_id = c.customer_id', 'INNER')
		->where("a.sent_for_review",1)
		->where("a.del_status",0);
		
		//agents
		if( !empty( $agent_id ) ){
			//$this->db->where("a.agent_id", $agent_id);
			$this->db->where_in("a.agent_id", $agent_id);
		}
		
		$this->db->order_by("a.id","DESC");
		
		$q = $this->db->get();
		return $q->result();
	}
	
	//Get Amendment APPROVED Price Today
	public function get_amendment_approved_price( $agent_id = array()   ){
		$this->db->select('a.*, c.customer_name, c.customer_contact')
		->from('iti_amendment_temp as a')
		->join('customers_inquery as c', 'a.customer_id = c.customer_id', 'INNER')
		->where("(a.sent_for_review = 2 OR a.sent_for_review = 3)" )
		->where("a.del_status", 0)
		->like("a.review_update_date", date('Y-m-d'));
		
		if( !empty( $agent_id ) ){
			//$this->db->where("a.agent_id", $agent_id);
			$this->db->where_in("a.agent_id", $agent_id);
		}
		$this->db->order_by("a.id","DESC");
		$q = $this->db->get();
		return $q->result();
	}
	
	//Get Amendment Itineraries
	public function get_amendment_itineraries($agent_id = "", $limit=20 ){
		$this->db->select('a.iti_id,a.temp_key,a.package_name,a.agent_id, c.customer_name, c.customer_contact, voc.hotel_booking_status')
		->from('itinerary as a')
		->join('customers_inquery as c', 'a.customer_id = c.customer_id', 'INNER')
		->join('iti_vouchers_status as voc', 'a.iti_id = voc.iti_id AND (voc.hotel_booking_status = 1 OR voc.vtf_booking_status = 1 OR voc.confirm_voucher = 1)', 'LEFT')
		->where("voc.iti_id IS NULL")
		->where("a.is_amendment", 2)
		->where("a.del_status",0);
		if( !empty( $agent_id ) ){
			$this->db->where("a.agent_id", $agent_id);
		}
		$this->db->order_by("a.iti_id","DESC");
		
		$this->db->limit($limit);
		$q = $this->db->get();
		return $q->result();
	}
	
	//Get REFUND Payments
	public function get_refund_payments( $limit=20 ){
		$this->db->select('a.*, c.customer_name, c.customer_contact')
		->from('iti_payment_details as a')
		->join('customers_inquery as c', 'a.customer_id = c.customer_id', 'INNER')
		->where("a.refund_amount >", 0)
		->where("a.refund_status", 'unpaid');
		$this->db->order_by("a.id","DESC");
		
		$this->db->limit($limit);
		$q = $this->db->get();
		return $q->result();
	}
	
	//Get Confirmed Vouchers
	public function confirmed_vouchers( $limit=20 ){
		$this->db->select('a.*,p2.package_name,p2.temp_key, c.customer_name, c.customer_contact')
		->from('iti_vouchers_status as a')
		->join('itinerary as p2', 'a.iti_id = p2.iti_id', 'INNER')
		->join('customers_inquery as c', 'c.customer_id = p2.customer_id', 'INNER')
		->where("a.confirm_voucher = 1 ");
		$this->db->group_by("p2.iti_id");
		$this->db->order_by("a.id","DESC");
		$this->db->limit($limit);
		$q = $this->db->get();
		return $q->result();
	}
	
	//Get Pending Vouchers
	public function pending_vouchers( $limit=20 ){
		$this->db->select('p2.iti_id, p2.package_name,p2.agent_id, p2.temp_key, c.customer_name, c.customer_contact')
		->from('itinerary as p2')
		->join('customers_inquery as c', 'c.customer_id = p2.customer_id', 'INNER')
		->join('iti_vouchers_status as voc', 'p2.iti_id = voc.iti_id', 'LEFT')
		->join('hotel_booking as h', 'p2.iti_id = h.iti_id', 'LEFT')
		->join('travel_booking as vtf', 'p2.iti_id = vtf.iti_id', 'LEFT')
		->where("(h.iti_id IS NOT NULL OR vtf.iti_id IS NOT NULL)")
		->where("(voc.confirm_voucher IS NULL OR voc.confirm_voucher=0)")
		->where('p2.iti_status', 9 )
		->where('p2.del_status', 0 );
		$this->db->group_by("p2.iti_id");
		$this->db->order_by("p2.iti_id","DESC");
		$this->db->limit($limit);
		$q = $this->db->get();
		return $q->result();
	}
	
	//Get All Itineraries payment received less than 50 %
	public function advance_payment_pending_count( $condition = "<" ){
		//get first and last date of month
		$from = date('Y-m-01');
		$to = date('Y-m-t');
		$this->db->select("id");
		$this->db->from("iti_payment_details");
		$this->db->where("(next_payment_due_date BETWEEN '" . $from . "' AND '". $to ."')");
		$this->db->where("next_payment != '' ");
		$this->db->where("TRUNCATE( ((total_package_cost - total_balance_amount )/total_package_cost  * 100 ),0) $condition 50");
		return $this->db->count_all_results();
	}
	
	//Get monthly itinerary count for echart working iti
	public function get_monthly_iti_data( $year = '', $type = NULL, $agent_id = NULL ){
		$sql = "SELECT count(p.iti_id) AS start_count FROM( SELECT '01' as month UNION ALL SELECT '02' AS month UNION ALL SELECT '03' AS month UNION ALL SELECT '04' AS month UNION ALL SELECT '05' AS month UNION ALL SELECT '06' AS month UNION ALL SELECT '07' AS month UNION ALL SELECT '08' AS month UNION ALL SELECT '09' AS month UNION ALL SELECT '10' AS month UNION ALL SELECT '11' AS month UNION ALL SELECT '12' AS month ) AS m LEFT JOIN itinerary p ON m.month = MONTH(p.added) AND YEAR(p.added) = $year  AND MONTH(p.added) IN ('01', '02', '03','04','05','06','07','08','09','10','11','12') 
		AND p.iti_status = 0 AND p.parent_iti_id = 0 AND p.del_status = 0";
		if( $agent_id ){
			$sql .= " AND p.agent_id = {$agent_id}";
		}		
		$sql .= " GROUP BY m.month order BY m.month";
		$q = $this->db->query( $sql );
		return $q->result();
	}
	
	//Get monthly itinerary count for echart approved/declined iti
	public function get_monthly_iti_app_dec_data( $year = '', $type = "", $agent_id = NULL ){
		$sql = "SELECT count(p.iti_id) AS start_count FROM( SELECT '01' as month UNION ALL SELECT '02' AS month UNION ALL SELECT '03' AS month UNION ALL SELECT '04' AS month UNION ALL SELECT '05' AS month UNION ALL SELECT '06' AS month UNION ALL SELECT '07' AS month UNION ALL SELECT '08' AS month UNION ALL SELECT '09' AS month UNION ALL SELECT '10' AS month UNION ALL SELECT '11' AS month UNION ALL SELECT '12' AS month ) AS m LEFT JOIN itinerary p ON m.month = MONTH(p.iti_decline_approved_date) AND YEAR(p.iti_decline_approved_date) = {$year}  AND MONTH(p.iti_decline_approved_date) IN ('01', '02', '03','04','05','06','07','08','09','10','11','12') 
		AND p.iti_status = {$type} AND p.parent_iti_id = 0 AND p.del_status = 0";
		if( $agent_id ){
			$sql .= " AND p.agent_id = {$agent_id}";
		}
		$sql .= " GROUP BY m.month order BY m.month";
		$q = $this->db->query( $sql );
		return $q->result();
	}
	
	
	//Get monthly LEADS count for echart working iti
	public function get_monthly_leads_data( $year = '', $type = "" , $agent_id = NULL ){
		$sql = "SELECT count(p.customer_id) AS start_count FROM( SELECT '01' as month UNION ALL SELECT '02' AS month UNION ALL SELECT '03' AS month UNION ALL SELECT '04' AS month UNION ALL SELECT '05' AS month UNION ALL SELECT '06' AS month UNION ALL SELECT '07' AS month UNION ALL SELECT '08' AS month UNION ALL SELECT '09' AS month UNION ALL SELECT '10' AS month UNION ALL SELECT '11' AS month UNION ALL SELECT '12' AS month ) AS m LEFT JOIN customers_inquery p ON m.month = MONTH(p.created) AND YEAR(p.created) = $year  AND MONTH(p.created) IN ('01', '02', '03','04','05','06','07','08','09','10','11','12') 
		AND p.cus_status = 0 AND p.del_status = 0";
		if( $agent_id ){
			$sql .= " AND p.agent_id = {$agent_id}";
		}
		$sql .= " GROUP BY m.month order BY m.month";
		$q = $this->db->query( $sql );
		return $q->result();
	}
	
	//Get monthly LEADS count for echart approved/declined iti
	public function get_monthly_leads_app_dec_data( $year = '', $type = "" , $agent_id = NULL){
		$sql = "SELECT count(p.customer_id) AS start_count FROM( SELECT '01' as month UNION ALL SELECT '02' AS month UNION ALL SELECT '03' AS month UNION ALL SELECT '04' AS month UNION ALL SELECT '05' AS month UNION ALL SELECT '06' AS month UNION ALL SELECT '07' AS month UNION ALL SELECT '08' AS month UNION ALL SELECT '09' AS month UNION ALL SELECT '10' AS month UNION ALL SELECT '11' AS month UNION ALL SELECT '12' AS month ) AS m LEFT JOIN customers_inquery p ON m.month = MONTH(p.lead_last_followup_date) AND YEAR(p.lead_last_followup_date) = {$year}  AND MONTH(p.lead_last_followup_date) IN ('01', '02', '03','04','05','06','07','08','09','10','11','12') 
		AND p.cus_status = {$type} AND p.del_status = 0";
		
		if( $agent_id ){
			$sql .= " AND p.agent_id = {$agent_id}";
		}
		$sql .= " GROUP BY m.month order BY m.month";
		$q = $this->db->query( $sql );
		return $q->result();
	}
	
	//GET ON HOLD ITINERARIES from iti_payment_details
	public function get_onhold_itieraries_list( $agent_id = array() ){
		$this->db->select('pay.*, itinerary.package_name, itinerary.temp_key');
		$this->db->from('iti_payment_details as pay')
		->join('itinerary as itinerary', 'pay.iti_id = itinerary.iti_id', 'LEFT');
		//booking status 2=rejected,3=reject due to itinerary, 1=on hold
		if( $agent_id ){
			$reject = array(2,3);
			$this->db->where_in( "pay.iti_booking_status", $reject );
			//$this->db->where( "itinerary.agent_id", $agent_id );
			$this->db->where_in( "itinerary.agent_id", $agent_id );
		}else{
			$this->db->where( "pay.iti_booking_status", 1 );
		}
		//if limit exists
		$this->db->group_by("pay.iti_id");
		$this->db->order_by("pay.created", "DESC");
		//$this->db->limit(20);
		$q = $this->db->get();
		return $q->result();
	}
	
	//check today's checkout
	public function check_todays_checkout_customer( $agent_id = array() ){
		$todayDate = date("Y-m-d");
		$this->db->select("*");
		$this->db->from("itinerary");
		$this->db->where("del_status", 0);
		$this->db->where("iti_status", 9);
		$this->db->like("DATE_FORMAT(STR_TO_DATE(t_end_date , '%d/%m/%Y'), '%Y-%m-%d')", $todayDate );
		//if agent id exists
		if( $agent_id ){
			//$this->db->where( "agent_id", $agent_id );
			$this->db->where_in( "agent_id", $agent_id );
		}
		$q = $this->db->get();
		return $q->result();
	}
	
	//CHECK ABOVE 40000 PACKAGES ON WORKING
	public function __check_above_fourty_thousand_working_packages( $limit = 50 ){
		$sql = 'SELECT i.iti_id,i.package_name, i.agent_id,i.customer_id,i.temp_key,
		GREATEST(
			CAST(REPLACE(TRIM( IFNULL( SUBSTRING_INDEX(SUBSTRING_INDEX(i.rates_meta,";",2),":",-1), 0)), "\"" , "") AS DECIMAL ),
            CAST(REPLACE(TRIM( IFNULL( SUBSTRING_INDEX(SUBSTRING_INDEX(i.rates_meta,";",4),":",-1), 0)), "\"" , "") AS DECIMAL ),
            CAST(REPLACE(TRIM( IFNULL( SUBSTRING_INDEX(SUBSTRING_INDEX(i.rates_meta,";",6),":",-1), 0)), "\"" , "") AS DECIMAL ),
            CAST(REPLACE(TRIM( IFNULL( SUBSTRING_INDEX(SUBSTRING_INDEX(i.rates_meta,";",8),":",-1), 0)), "\"" , "") AS DECIMAL )
		) AS MAXP
		FROM itinerary as i
		WHERE i.iti_status = 0 AND i.del_status = 0
		GROUP BY i.customer_id HAVING MAXP >= 40000 ORDER BY i.iti_id DESC LIMIT ' . $limit . ' ';
		$q = $this->db->query( $sql );
		return $q->result();
	}
	
	//check packages above 40k
	public function __check_between_fourty_and_lac_working_packages( $condition = NULL, $where = NULL, $limit = 50 ){
		$where_con = "";
		//check if condition exists
		if( $condition == ">" ){
			$condition = " >= 100000";
		}else{
			$condition = " BETWEEN 40000 AND 100000";
		}
		//where pacakges in
		if( $where ){
			$where_con = " AND i.agent_id IN ({$where})";
		}
		
		$sql = 'SELECT i.iti_id,i.package_name, i.agent_id,i.customer_id,i.temp_key,
		GREATEST(
			CAST(REPLACE(TRIM( IFNULL( SUBSTRING_INDEX(SUBSTRING_INDEX(i.rates_meta,";",2),":",-1), 0)), "\"" , "") AS DECIMAL ),
            CAST(REPLACE(TRIM( IFNULL( SUBSTRING_INDEX(SUBSTRING_INDEX(i.rates_meta,";",4),":",-1), 0)), "\"" , "") AS DECIMAL ),
            CAST(REPLACE(TRIM( IFNULL( SUBSTRING_INDEX(SUBSTRING_INDEX(i.rates_meta,";",6),":",-1), 0)), "\"" , "") AS DECIMAL ),
            CAST(REPLACE(TRIM( IFNULL( SUBSTRING_INDEX(SUBSTRING_INDEX(i.rates_meta,";",8),":",-1), 0)), "\"" , "") AS DECIMAL )
		) AS MAXP
		FROM itinerary as i
		WHERE i.iti_status = 0 AND i.del_status = 0 ' . $where_con . '
		HAVING MAXP '. $condition . ' ORDER BY i.iti_id DESC LIMIT '. $limit . ' ';
		$q = $this->db->query( $sql );
		return $q->result();
	}
	
	//get pending price requests by teammembers
	public function get_teammembers_pending_price_request( $teammembers = NULL, $limit = 10 ){
		
		//Itinerary Pending Rates limit=5
		//$where_pr = array('agent_id' => $user_id, "del_status" => 0);
		//$or_where_pr = ( "pending_price = 1 OR discount_rate_request = 1 OR discount_rate_request = 2" );
		
		if( $teammembers ){
			$this->db->where("pending_price = 5 OR discount_rate_request = 3");
			$this->db->where("del_status", 0 );
			$this->db->where("iti_status", 0 );
			$this->db->where( "agent_id IN ({$teammembers})" );
			$this->db->from("itinerary");
			//if limit exists
			if (!empty($limit)) {
				$this->db->limit($limit);
			}
			$q = $this->db->get();
			$res = $q->result();
			if ($res) {
				$result = $res;
			} else {
				$result = false;
			}
			return $result;
			
		}else{
			return false;
		}
	}
	
}
?>
