<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Customer_Model extends CI_Model{
	/* datatable filter varibles for hotels */
	public $table = 'customers_inquery';
	public $column_order = array(null, 'customers_inquery.customer_id','customers_inquery.customer_type', 'customers_inquery.customer_name', 'customers_inquery.customer_email', '','','customers_inquery.created', 'customers_inquery.agent_id'); //set column field database for datatable orderable
	public $column_search = array('customers_inquery.customer_id','customers_inquery.customer_name','customers_inquery.customer_contact'); //set column field database for datatable searchable 
	public $order = array('customers_inquery.customer_id' => 'DESC'); // default order 
	
	function __construct(){
        parent::__construct();
		validate_login();
	}
	
	public function insert_customer($tablename, $data_array) {
        if ($this->db->insert($tablename, $data_array)) {
            $result = $this->db->insert_id();
        } else {
            $result = false;
        }
        return $result;
    }
	
	public function getdata($tablename, $where = array(), $getCol = '') {
        $table = $tablename;
		if (!empty($getCol)) {
            $this->db->select($getCol);
        }
	    if (!empty($where)) {
			foreach($where as $key => $value){
				$this->db->where( $key, $value );
			}
        }
		$this->db->from($table);
        $q = $this->db->get();
		/* $this->output->enable_profiler(TRUE); */
		$res = $q->result();
		/*  echo $this->db->last_query();*/
        if ($res) {
            $result = $res;
        } else {
            $result = false;
        }
        return $result;
    }
	
	//edit hotel
	public function update_customer($id, $tablename, $data_array) {
		$temp_key = $this->input->post("temp_key");
		//check if reassign lead exists
		if( isset( $_POST["reassign_agent_id"] ) && !empty( $_POST["reassign_agent_id"] ) ){
			$data_array["agent_id"] = $_POST["reassign_agent_id"];
		}
		
		$this->db->where('customer_id',$id);
    	$this->db->where('temp_key',$temp_key);
		$this->db->update($tablename,$data_array);
		return true;
	}
	
	//datatable view all customers
	private function _get_datatables_query( $where ){
		$user = $this->session->userdata('logged_in');
		$u_id = $user['user_id'];
		$role = $user['role'];
		
		ini_set('max_execution_time', 10000);
		$this->db->select('customers_inquery.*');
        $this->db->from('customers_inquery AS customers_inquery');
		$this->db->join('customer_followup AS cf', 'customers_inquery.customer_id = cf.customer_id', 'LEFT');
		//add custom filter with Date Range
		if( isset( $_POST['filter'] ) && isset( $_POST['from'] ) && isset( $_POST['end'] ) ){
			$filter_data = trim($this->input->post('filter'));
			$date_from 	 = $this->input->post('from');
			$date_end 	 = $this->input->post('end');
			if( isset( $_POST['todayStatus'] ) && !empty( $_POST['todayStatus'] ) ){
				$date = $_POST['todayStatus'];
				//date can be month or day format eg: Y-m or Y-m-d
				$todayDate = $date;
				//$todayDate = date('Y-m-d', strtotime($today));
				switch( $filter_data ){
					case "9":
						$this->db->where( "customers_inquery.cus_status", "9" );
						$this->db->like( "customers_inquery.lead_last_followup_date", $todayDate );
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
						$this->db->where( array( "customers_inquery.cus_status" => "0" ) );
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
					case "all":
						$this->db->like( "customers_inquery.created", $todayDate );
						break;
					default:
						// continue2;
						break;
				} 
			}else if( !empty($filter_data) && !empty($date_from) && !empty($date_end) ){
				$d_from 	= date('Y-m-d', strtotime($date_from));
				$d_to	 	= date('Y-m-d H:i:s', strtotime($date_end . "23:59:59"));
				$_month	 	= date('Y-m', strtotime($date_from));
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
						// continue2;
						break;
				} 
			}
        }
		//End Filter section
		if (!empty($where)) {
			foreach($where as $key => $value){
				$this->db->where( $key, $value );
			}
        }
		//$this->db->from($this->table);
		$i = 0;
		foreach ($this->column_search as $item){
			if(  isset($_POST['search']['value'])){
				if($i===0){
					$this->db->group_start();
					$this->db->like($item, $_POST['search']['value']);
				}else{
					$this->db->or_like($item, $_POST['search']['value']);
				}
				if(count($this->column_search) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket select
			}
			$i++;
		}
		$this->db->group_by( "customers_inquery.customer_id" );
	}

	function get_datatables( $where = array() ){
		$this->_get_datatables_query($where);
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		if(isset($_POST['order'])){
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		}else if(isset($this->order)){
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
		$query = $this->db->get();
		return $query->result();
	}
	
	function count_filtered($where = array()){
		$this->_get_datatables_query($where);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all( $where = array() ){
		if (!empty($where)) {
			foreach($where as $key => $value){
				$this->db->where( $key, $value );
			}
        }
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}
	
	//clone Customer
	function duplicate_lead($table, $primary_key_field, $primary_key_val){
		$user = $this->session->userdata('logged_in');
		$user_id = $user["user_id"];
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
					case ( $key == "parent_customer_id" ):
						$this->db->set($key, $primary_key_val);
					break;
					case ( $key == "cus_status" ):
						$this->db->set($key, "9");
					break;
					case ( $key == "cus_last_followup_status"):
						$this->db->set($key, 9);
					break;
					case ( $key == "lead_last_followup_date"):
						$this->db->set($key, $currentDate);
					break;
					case ($key == "temp_key" ):	
						$this->db->set($key, $unique_key); 
					break;
					case ($key == "decline_reason" ):	
						$this->db->set($key, ""); 
					break;
					case ($key == "assign_by" ):	
						$this->db->set($key, $user_id); 
					break;
					case ($key == "reopen_by" ):	
						$this->db->set($key, "0"); 
					break;
					case ($key == "reopen_status" ):	
						$this->db->set($key, 0); 
					break;
					case ($key == "created" ):	
						$this->db->set($key, $currentDate );
					break;
					default:
						continue 2; 
					break;
				}
			}//endforeach
		}//endforeach

		/* insert the new record into table*/
		$this->db->insert($table); 
		return $this->db->insert_id();
	}
	
		/* 
	* Get booked_leads
	*/
	function booked_leads(){
		$query = "SELECT customers_inquery.temp_key ,customers_inquery.customer_id ,customers_inquery.customer_name , itinerary.iti_status,customers_inquery.customer_email,customers_inquery.customer_contact,customers_inquery.agent_id,customers_inquery.Created from customers_inquery left join itinerary on customers_inquery.customer_id = itinerary.customer_id where itinerary.iti_status = 9";

		$q = $this->db->query($query);
		
		$res = $q->result();		
	if($res){
			return   $res;
		}else{
			$return = false;
		}
		return $return;
	}
}
?>