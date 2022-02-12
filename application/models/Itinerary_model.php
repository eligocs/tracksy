<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Itinerary_model extends CI_Model{
	/* datatable filter varibles for hotels */
	public $table = 'itinerary';
	public $column_order = array(null,'itinerary.iti_id','itinerary.iti_type', 'itinerary.customer_id','cus.customer_name','cus.customer_contact','itinerary.package_name',null, 'pay.travel_date', null, 'itinerary.email_count', 'itinerary.publish_status', 'itinerary.agent_id' ); //set column field database for datatable orderable
	public $column_search = array('itinerary.iti_id','itinerary.customer_id','itinerary.publish_status', 'cus.customer_name', 'cus.customer_contact', 'cus.customer_email', 'itinerary.agent_id' ); //set column field database for datatable searchable 
	public $order = array('itinerary.iti_id' => 'DESC'); // default order
	
	function __construct(){
        parent::__construct();
	}
	
	/* Get All Itinerary */
	function getAllItinerary(){
		$this->db->select('A.*, C.customer_name, C.customer_email');
        $this->db->from('itinerary AS A');
        $this->db->join('customers_inquery AS C', 'C.customer_id = A.customer_id', 'INNER');
        $this->db->where('A.del_status', '0');
        $this->db->order_by('A.iti_id', "DESC");
       	$q = $this->db->get();
		/*echo $this->db->last_query();*/
		if ($q) {
            $res = $q->result();
		}else{
			$res = false;
		}
		return $res;		
	}
	/* Get All Itinerary by agent */
	function getAllItinerary_by_agent($agent_id){
		$this->db->select('A.*, C.customer_name, C.customer_email');
        $this->db->from('itinerary AS A');
        $this->db->join('customers_inquery AS C', 'C.customer_id = A.customer_id', 'INNER');
        $this->db->where('A.del_status', '0');
        $this->db->where('A.agent_id', $agent_id);
        $this->db->order_by('A.iti_id', "DESC");
       	$q = $this->db->get();
		/*echo $this->db->last_query();*/
		if ($q) {
            $res = $q->result();
		}else{
			$res = false;
		}
		return $res;		
	}
	/* Get Single Itinerary */
	function getiti( $iti_id, $temp_key){
		$this->db->select('A.*, C.customer_name, C.customer_email, C.customer_contact, C.customer_address');
        $this->db->from('itinerary AS A');
        $this->db->join('customers_inquery AS C', 'C.customer_id = A.customer_id', 'INNER');
        $this->db->where('A.del_status', '0');
        $this->db->where('A.iti_id', $iti_id);
        $this->db->where('A.temp_key', $temp_key);
        $this->db->order_by('A.iti_id', "DESC");
       	$q = $this->db->get();
		/*echo $this->db->last_query();*/
		if ($q) {
            $res = $q->result();
		}else{
			$res = false;
		}
		return $res;		
	}
	/* Get Single Itinerary By agent*/
	function getiti_agent( $iti_id, $temp_key, $user_id){
		$this->db->select('A.*, C.customer_name, C.customer_email, C.customer_contact, C.customer_address');
        $this->db->from('itinerary AS A');
        $this->db->join('customers_inquery AS C', 'C.customer_id = A.customer_id', 'INNER');
        $this->db->where('A.del_status', '0');
        $this->db->where('A.iti_id', $iti_id);
        $this->db->where('A.agent_id', $user_id);
        $this->db->where('A.temp_key', $temp_key);
        $this->db->order_by('A.iti_id', "DESC");
       	$q = $this->db->get();
		/*echo $this->db->last_query();*/
		if ($q) {
            $res = $q->result();
		}else{
			$res = false;
		}
		return $res;		
	}
	/*Get Itinerary by iti_id, customer_id, temp_key*/
	function get_iti( $customer_id, $iti_id, $temp_key ){
		$this->db->select('A.*, C.customer_name, C.customer_email, C.customer_contact, C.customer_address');
        $this->db->from('itinerary AS A');
        $this->db->join('customers_inquery AS C', 'C.customer_id = A.customer_id', 'INNER');
        $this->db->where('A.del_status', '0');
        $this->db->where('A.iti_id', $iti_id);
        $this->db->where('A.customer_id', $customer_id);
        $this->db->where('A.temp_key', $temp_key);
        $this->db->order_by('A.iti_id', "DESC");
       	$q = $this->db->get();
		if ($q) {
            $res = $q->result();
		}else{
			$res = false;
		}
		return $res;	
	}
	
	/* Update Itinerary Status */
	function update_itinerary_status($iti_id, $customer_id, $temp_key ){
		$iti_note = serialize($this->input->post('iti_note[]'));
		$iti_status = strip_tags($this->input->post('iti_status'));
		$data= array(
			'iti_note'=>$iti_note,
			'iti_status'=>$iti_status,
		);
		$this->db->where('iti_id',$iti_id);
		$this->db->where('customer_id',$customer_id);
		$this->db->where('temp_key',$temp_key);
		$this->db->update('itinerary',$data);
		return true;
	} 
	
	//datatable view all Itinerary
	private function _get_datatables_query($where, $q_type = "" , $custom_where = NULL){
		ini_set('max_execution_time', 10000);
		//$this->db->query("SET SESSION sql_mode='STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION'");
		
		$user = $this->session->userdata('logged_in');
		$role = $user['role'];
		
		if( $q_type == "count" ){
			$this->db->select('itinerary.iti_id'); 
		}else{	
			$this->db->select('itinerary.*,cus.customer_name,cus.customer_contact,cus.customer_email,pay.travel_date,pay.advance_recieved, pay.iti_booking_status as booking_status, pay.approved_by_account_team, iti_f.iti_id as followup_id'); 
		}
		
		//$this->db->select('itinerary.*,cus.customer_name,cus.customer_contact,cus.customer_email,pay.travel_date');
		$this->db->from('itinerary as itinerary')
		->join('customers_inquery as cus', 'itinerary.customer_id = cus.customer_id', 'INNER')
		->join('iti_payment_details as pay', 'itinerary.iti_id = pay.iti_id', 'LEFT')
		->join('iti_followup AS iti_f', 'itinerary.iti_id = iti_f.iti_id', 'LEFT');
		
		
		//Service team show if voucher not confirmed
		if( $role == 97 ){
			$this->db->join('iti_vouchers_status AS iti_v', 'itinerary.iti_id = iti_v.iti_id AND iti_v.confirm_voucher = 1', 'LEFT');
			$this->db->where("pay.iti_booking_status", 0 );
			$this->db->where("pay.approved_by_account_team", 1 );
			$this->db->where("iti_v.iti_id IS NULL");
		}
		
		//Accounts team show if iti not in hold 
		if( $role == 93 ){
			$this->db->where("pay.iti_booking_status", 0 );
		}
		
		//add custom filter with Date Range revised
		if( isset( $_POST['filter'] ) && isset( $_POST['from'] ) && isset( $_POST['end'] ) ){
			$filter_data = trim($this->input->post('filter'));
			$date_from 	= $this->input->post('from');
			$date_end = $this->input->post('end');
			
			//For Today's Stat
			if( isset( $_POST['todayStatus'] ) && !empty( $_POST['todayStatus'] ) ){
				$today = $_POST['todayStatus'];
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
					case "declined":
						$this->db->where( "itinerary.iti_status", "7" );
						$this->db->like( array(  "itinerary.iti_decline_approved_date" => $todayDate ) );
						break;
					case "pm_ci":
						$this->db->where( "itinerary.iti_close_status", "1" );
						$this->db->like( array(  "itinerary.iti_decline_approved_date" => $todayDate ) );
						break;
					case "pm_oi":
						$this->db->where( "itinerary.iti_close_status", "0" );
						$this->db->like( array(  "itinerary.iti_decline_approved_date" => $todayDate ) );
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
						$this->db->where("iti_f.call_status", 0 );
						$this->db->like("iti_f.nextCallDate", $todayDate);
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
					case "pm_oi":
						$this->db->where( array( "itinerary.iti_close_status" => "0" ) );
						$this->db->where("itinerary.iti_decline_approved_date >=", date('Y-m-d', strtotime($date_from)) );
						$this->db->where("itinerary.iti_decline_approved_date <=", date('Y-m-d H:i:s', strtotime($date_end . "23:59:59")) ); 
						break;
					case "pm_ci":
						$this->db->where( array( "itinerary.iti_close_status" => "1" ) );
						$this->db->where("itinerary.iti_decline_approved_date >=", date('Y-m-d', strtotime($date_from)) );
						$this->db->where("itinerary.iti_decline_approved_date <=", date('Y-m-d H:i:s', strtotime($date_end . "23:59:59")) ); 
						break;
					case "hold":
						//$this->db->where( array( "itinerary.iti_status" => "9", "itinerary.publish_status" => "publish" ) );
						$this->db->where( array( "itinerary.publish_status" => "publish" ) );
						$this->db->where("pay.iti_booking_status !=", 0 );
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
					case "travel_end_date":
						$this->db->where("DATE_FORMAT(STR_TO_DATE(itinerary.t_end_date , '%d/%m/%Y'), '%Y-%m-%d') >=", date('Y-m-d', strtotime($date_from)));
						$this->db->where("DATE_FORMAT(STR_TO_DATE(itinerary.t_end_date , '%d/%m/%Y'), '%Y-%m-%d') <=", date('Y-m-d', strtotime($date_end)));
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
					case "agent_margen_20":
						$this->db->where( "itinerary.agent_price >=", "20" );
						$this->db->where("itinerary.added >=", date('Y-m-d', strtotime($date_from)) );
						$this->db->where("itinerary.added <=", date('Y-m-d H:i:s', strtotime($date_end . "23:59:59")) ); 
						break;
					case "pending_invoice":	
						$this->db->where( "pay.approved_by_account_team", 0 );						
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
		
		if (!empty($custom_where)) {
			$this->db->where($custom_where);
        }
		$i = 0;
		foreach ( $this->column_search as $item ){
			if(  isset($_POST['search']['value']) && !empty( $_POST['search']['value']) ) {
			//if(  isset($_POST['search']['value']) ) {
				if($i===0){
					$this->db->group_start();
					$this->db->like($item, $_POST['search']['value']);
				}else{
					$this->db->or_like($item, $_POST['search']['value']);
				}
				if(count($this->column_search) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
			}
			$i++;
		}
		
		/* if(isset($_POST['order'])){
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		}else if(isset($this->order)){
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}  */
		
		$this->db->group_by( "itinerary.iti_id" );
	}

	function get_datatables( $where = array(), $custom_where = NULL ){
		$this->_get_datatables_query($where, NULL, $custom_where );
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
	
		if(isset($_POST['order'])){
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		}else if(isset($this->order)){
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		} 
	
		$query = $this->db->get();
		
		//Last query
		//$lq = $this->db->last_query();
		//echo $lq; 
		//die();
		
		return $query->result();
	}
	
	function count_filtered($where = array(), $custom_where = NULL){
		$this->_get_datatables_query( $where , "count", $custom_where);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all( $where = array() , $custom_where = NULL){
		if (!empty($where)) {
			foreach($where as $key => $value){
				$this->db->where( $key, $value );
			}
        }
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}
	
	//clone itinerary
	function duplicate_itinerary($table, $primary_key_field, $primary_key_val, $parent_id = "" ){
	   /* generate the select query */
	   $this->db->where($primary_key_field, $primary_key_val); 
	   $query = $this->db->get($table);
	  
		foreach ($query->result() as $row){   
			foreach($row as $key=>$val){  
				if($key != $primary_key_field){ 
					$this->db->set($key, $val);               
				}
				// set the timezone first
				$currentDate = current_datetime();
				//create temp key
				$rand = getTokenKey(8); 
				$date = date("Ymd"); 
				$time = time(); 
				$unique_key = $rand . "_" . $date . "_" . $time; 
				
				switch( $key ){
					case ( $key == "parent_iti_id" ):
						if( !empty($parent_id) ){
							$this->db->set($key, $parent_id);
						}else{
							$this->db->set($key, $primary_key_val);
						}	
					break;
					case ( $key == "pending_price" ):
						$this->db->set($key, "0");
					break;
					
					case ( $key == "rates_meta" || $key == "per_person_ratemeta" || $key == "quotation_sent_date" || $key == "approved_price_date" || $key == "pending_price_date" || $key == "client_comment_status" || $key == "client_comment" || $key == "followup_status" || $key == "iti_decline_approved_date" ):
						$this->db->set($key, "");
					break;
					
					case ( $key == "discount_rate_request" || $key == "agent_price"):
						$this->db->set($key, "0");
					break;
					case ($key == "email_count" ):	
						$this->db->set($key, "0"); 
					break;
					case ($key == "publish_status" ):	
						$this->db->set($key, "price pending"); 
					break;
					case ($key == "temp_key" ):	
						$this->db->set($key, $unique_key); 
					break;
					case ($key == "added" ):	
						$this->db->set($key, $currentDate );
					break;
					default:
						continue2; 
					break;
				}
			}//endforeach
		}//endforeach

		/* insert the new record into table*/
		$this->db->insert($table); 
		return $this->db->insert_id();
	}
	
	//clone itinerary for amendment
	function duplicate_itinerary_for_amendment($table, $primary_key_field, $primary_key_val){
		/* generate the select query */
	   $this->db->where($primary_key_field, $primary_key_val); 
	   $query = $this->db->get($table);
	   
		$all_iti_fields = $this->global_model->get_table_fields( "iti_amendment_temp" );
		//create temp key
		$rand = getTokenKey(8); 
		$date = date("Ymd"); 
		$time = time(); 
		$unique_key = $rand . "_" . $date . "_" . $time; 

		foreach ($query->result() as $row){   
			foreach($row as $key=>$val){
				
				if(in_array($key, $all_iti_fields) ){ 
					$this->db->set($key, $val);               
				}
				switch( $key ){
					case ($key == "final_amount" ):	
						$this->db->set("old_package_cost", $val); 
					break;
					case ($key == "temp_key" ):	
						$this->db->set($key, $unique_key); 
					break;
					default:
						continue2; 
					break;
				}
				
			}//endforeach
		}//endforeach

		/* insert the new record into table*/
		$this->db->insert("iti_amendment_temp"); 
		return $this->db->insert_id();
	}
	
	//clone itinerary for amendment
	function duplicate_itinerary_before_amendment($table, $primary_key_field, $primary_key_val){
		/* generate the select query */
	   $this->db->where($primary_key_field, $primary_key_val); 
	   $query = $this->db->get($table);
	   
		$all_iti_fields = $this->global_model->get_table_fields( "iti_before_amendment" );
		
		/* echo "<pre>";
			print_r( $all_iti_fields );
		echo "</pre>";
		die; */
		//create temp key
		$rand = getTokenKey(8); 
		$date = date("Ymd"); 
		$time = time(); 
		$unique_key = $rand . "_" . $date . "_" . $time; 

		foreach ($query->result() as $row){   
			foreach($row as $key=>$val){
				
				if(in_array($key, $all_iti_fields) ){ 
					$this->db->set($key, $val);               
				}
				switch( $key ){
					case ($key == "final_amount" ):	
						$this->db->set("old_package_cost", $val); 
					break;
					case ($key == "temp_key" ):	
						$this->db->set($key, $unique_key); 
					break;
					default:
						continue2; 
					break;
				}
				
			}//endforeach
		}//endforeach

		/* insert the new record into table*/
		$this->db->insert("iti_before_amendment"); 
		return $this->db->insert_id();
	}
	
	//Update Old Itinerary data after amendment payment updated
	function update_old_itinerary($table, $primary_key_field, $primary_key_val ){
		/* Get Itinerary */
		$this->db->where($primary_key_field, $primary_key_val); 
		$query = $this->db->get($table);
		$res = $query->result();
		$new_iti = $res[0];
		$iti_id = $new_iti->iti_id;
		
		$update_new_data = array(
			"is_amendment" 		=> 2,
			"package_name" 		=> $new_iti->package_name,
			"package_routing" 	=> $new_iti->package_routing,
			"duration"			=> $new_iti->duration,
			"rooms_meta"		=> $new_iti->rooms_meta,
			"cab_category" 		=> $new_iti->cab_category,
			"adults" 			=> $new_iti->adults,
			"child" 			=> $new_iti->child,
			"daywise_meta" 		=> $new_iti->daywise_meta,
			"inc_meta" 			=> $new_iti->inc_meta,
			"special_inc_meta" 	=> $new_iti->special_inc_meta,
			"exc_meta" 			=> $new_iti->exc_meta,
			"hotel_meta" 		=> $new_iti->hotel_meta,
			"hotel_note_meta" 	=> $new_iti->hotel_note_meta,
			"final_amount" 		=> $new_iti->new_package_cost,
		);
		//update
		$this->db->where("iti_id", $iti_id); 
		return $this->db->update("itinerary", $update_new_data);
	}
	
	
	//clone Flight Data
	function clone_flight_train_data($table, $primary_key_field, $primary_key_val, $newItiId){
	   /* generate the select query */
	   $this->db->where($primary_key_field, $primary_key_val); 
	   $query = $this->db->get($table);
	  
		foreach ($query->result() as $row){   
			foreach($row as $key=>$val){ 
				if( $key != "id" ){
					$this->db->set($key, $val);               
				}
				switch( $key ){
					case ( $key == $primary_key_field ):
						$this->db->set($key, $newItiId);
					break;
					default:
						continue2; 
					break;
				}
				
			}//endforeach
		}//endforeach

		/* insert the new record into table*/
		$this->db->insert($table); 
		return $this->db->insert_id();
	}
	
	
	//delete permanent cloned itineraries
	function delete_data( $table, $where=array(), $orWhere=array() ){
		if (!empty($where)) {
			foreach($where as $key => $value){
				$this->db->where( $key, $value );
			}
        }
		if (!empty($orWhere)) {
			foreach($orWhere as $key => $value){
				$this->db->or_where( $key, $value );
			}
        }
		$this->db->delete($table);
		return $this->db->affected_rows();
	}
	
	//get all child itineries
	public function getchildItidata( $tablename, $where = array(), $orWhere = '', $getCol = '',$order_key = '',  $limit="" ) {
        $table = $tablename;
		if (!empty($getCol)) {
            $this->db->select($getCol);
        }
		if (!empty($where)) {
			foreach($where as $key => $value){
				$this->db->where( $key, $value );
			}
        }
		if (!empty($orWhere)) {
			foreach($orWhere as $key => $value){
				$this->db->or_where( $key, $value );
			}
        }
		//if limit exists
		if (!empty($limit)) {
			$this->db->limit($limit);
		}
		$this->db->from($table);
		if( !empty ($order_key)){
			$this->db->order_by($order_key, "DESC");
		}
		$q = $this->db->get();
		$res = $q->result();
		if ($res) {
			if (!empty($getCol)) {
				$result =  $res[0]->$getCol;
			}else{
				$result = $res;
			}
        } else {
            $result = false;
        }
        return $result;
    }
	
	//clone Package to itinerary
	function createItiFromPackageId($table, $primary_key_field, $primary_key_val, $customer_id, $agent_id, $parent_iti_id=""){
	   /* generate the select query */
	   $this->db->where($primary_key_field, $primary_key_val); 
	   $query = $this->db->get("packages");
		
		foreach ($query->result() as $row){   
			foreach($row as $key=>$val){  
				if($key != "customer_id"){ 
					$this->db->set("customer_id", $customer_id);               
					$this->db->set("lead_created", leadGenerationDate($customer_id) );               
					$this->db->set("parent_iti_id", $parent_iti_id);               
					$this->db->set("quatation_date", date("m/d/Y") );               
				} 
				
				// set the timezone first
				$currentDate = current_datetime();
			
				//create temp key
				$rand = getTokenKey(8); 
				$date = date("Ymd"); 
				$time = time(); 
				$unique_key = $rand . "_" . $date . "_" . $time; 
			
				switch( $key ){
					case ($key == "publish_status" ):	
						$this->db->set($key, "draft"); 
					break;
					case ($key == "temp_key" ):	
						$this->db->set($key, $unique_key); 
					break;
					case ($key == "agent_id" ):	
						$this->db->set($key, $agent_id); 
					break;
					case ($key == "created" || $key == "package_id" || $key == "p_cat_id" || $key == "state_id"  ):	
						continue2;
					break;
					default:
						$this->db->set($key, $val); 
					break;
				}
			}//endforeach
		}//endforeach

		/* insert the new record into table*/
		$this->db->insert("itinerary"); 
		return $this->db->insert_id();
	}
	
	// update call status
	public function update_iti_followup_status( $iti_id, $parent_iti_idIti = 0 ){
		$data = array( "call_status" => 1 );
		$this->db->where( "iti_id = '$iti_id' OR parent_iti_id = '$iti_id'" );
		//if parent_iti_id exists
		if( !empty( $parent_iti_idIti ) ){
			$this->db->or_where( "iti_id = '$parent_iti_idIti'" );
		}
		$update = $this->db->update("iti_followup" , $data);
		
		if( $update )
			return true;
		else
			return false;
	}
	
	
	//Get city list suggestion
	public function getHotelListing($keyword) {      
		$resp = array();
		$this->db->select("h.id,h.hotel_name,c.name as city");
		$this->db->from('hotels AS h'); // I use aliasing make joins easier
		$this->db->join('cities AS c', 'c.id = h.city_id', 'INNER');
		$this->db->like( "h.hotel_name", $keyword );
		$this->db->limit(10);
		$this->db->order_by("h.hotel_name", "ASC");
        return $this->db->get()->result_array();
	}
	
}
?>
