<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Marketing_model extends CI_Model{
	
	var $table = 'marketing';
	var $column_order = array(null, 'name'); //set column field database for datatable orderable
	var $column_search = array('name', 'contact_number', 'company_name'); //set column field database for datatable searchable 
	var $order = array('id' => 'DESC'); // default order 
	
    function __construct(){
        parent::__construct();
	}
	//insert
	public function insertCategory() {
        $catname = strip_tags($this->input->post('category_name'));
		$data= array(
			'category_name'=> $catname,
		);
		
        if ($this->db->insert("marketing_category", $data)) {
            $result = $this->db->insert_id();
			//$result = true;
        } else {
            $result = false;
        }
        return $result;
    }
	
	public function updateCategory() {
        $catname = strip_tags($this->input->post('category_name'));
        $catId = strip_tags($this->input->post('cat_id'));
		$data= array(
			'category_name'=> $catname,
		);
		
		$this->db->where('id',$catId);
		$this->db->update('marketing_category',$data);
		return true;
    }

	
	public function getAllCategory()
	{
		$this->db->where("del_status",0);
		$this->db->from("marketing_category");
		$query = $this->db->get();
		return $query->result();
	}
	
	public function getCategoryDetails($id)
	{
		$this->db->where(array("id" => $id, "del_status" => 0 ) );
		$this->db->from( "marketing_category" );
		$query = $this->db->get();
		return $query->result();
	}

	
	// Marketing User
	
	//insert
	public function insertMarketingUser(){
		$user = $this->session->userdata('logged_in');
		$user_id = $user['user_id'];
		
        $catId 		= strip_tags($this->input->post('cat_id'), TRUE);
        $name 		= strip_tags($this->input->post('name'), TRUE);
        $email 		= preg_replace('/\s+/', '', strip_tags($this->input->post('email_id'), TRUE));
        $contact	= preg_replace('/\s+/', '', strip_tags($this->input->post('contact_number'), TRUE));
        $whatsapp 	= preg_replace('/\s+/', '', strip_tags($this->input->post('whats_app_number'), TRUE));
		
		
        $state 		= strip_tags($this->input->post('state'), TRUE);
        $city 		= strip_tags($this->input->post('city'), TRUE);
        $place 		= strip_tags($this->input->post('place'), TRUE);
        $company 	= strip_tags($this->input->post('company_name'), TRUE);
        $website 	= strip_tags($this->input->post('website'), TRUE);
        $agentId 	= $user_id;
		
		$data= array(
			'cat_id'			=> $catId,
			'name'				=> $name,
			'email_id'			=> $email,
			'contact_number'	=> $contact,
			'whats_app_number'	=> $whatsapp,
			'state'				=> $state,
			'city'				=> $city,
			'place'				=> $place,
			'agent_id'			=> $agentId,
			'company_name'		=> $company,
			'website'			=> $website,
		);
		
        if ($this->db->insert("marketing", $data)) {
            $result = $this->db->insert_id();
        } else {
            $result = false;
        }
        return $result;
    }
	
	public function updateMarketingUser() {
        $m_id 		= strip_tags($this->input->post('m_id'), TRUE);
        $catId 		= strip_tags($this->input->post('cat_id'), TRUE);
        $name 		= strip_tags($this->input->post('name'), TRUE);
		
		$email 		= preg_replace('/\s+/', '', strip_tags($this->input->post('email_id'), TRUE));
        $contact	= preg_replace('/\s+/', '', strip_tags($this->input->post('contact_number'), TRUE));
        $whatsapp 	= preg_replace('/\s+/', '', strip_tags($this->input->post('whats_app_number'), TRUE));
		
        $state		= strip_tags($this->input->post('state'), TRUE);
        $city 		= strip_tags($this->input->post('city'), TRUE);
        $place 		= strip_tags($this->input->post('place'), TRUE);
        $company 	= strip_tags($this->input->post('company_name'), TRUE);
        $website 	= strip_tags($this->input->post('website'), TRUE);
		
		$data= array(
			'cat_id'=> $catId,
			'name'=> $name,
			'email_id'=> $email,
			'contact_number'=> $contact,
			'whats_app_number'=> $whatsapp,
			'state'=> $state,
			'city'=> $city,
			'place'=> $place,
			'company_name'=> $company,
			'website'=> $website,
		);
		
		$this->db->where('id',$m_id);
		$this->db->update('marketing',$data);
		return true;
    }
	
	//Query for datatable 
	private function _get_datatables_query($where = array()){
		$user = $this->session->userdata('logged_in');
		
		//Check if sale or service team than get user by assigned city
		if( $user["role"] == 96 || $user["role"] == 97 ){
			$city_in = get_agents_assigned_city($user["user_id"]);
			$this->db->where( "city IN ($city_in)" );
		}   
		
		if ( !empty($where) ) {
			foreach($where as $key => $value){
				$this->db->where( $key, $value );
			}
        }
		
		
		//Get today's status filter
		if( isset( $_POST['todayStatus'])  && !empty( $_POST['todayStatus'] ) ){
			$this->db->like( array( "created" => $_POST['todayStatus'] ) );
		}	
		
		
		//If date range not empty
		if( isset( $_POST['dfrom'])  && isset( $_POST['dend'] ) && !empty($_POST['dfrom']) ){
			$this->db->where("created >=", date('Y-m-d', strtotime($_POST['dfrom'])) );
			$this->db->where("created <=", date('Y-m-d H:i:s', strtotime($_POST['dend'] . "23:59:59")) ); 
		}
		
		$this->db->from($this->table);
		$i = 0;
		foreach ($this->column_search as $item) // loop column 
		{
			if($_POST['search']['value']) // if datatable send POST for search
			{
				if($i===0) // first loop
				{
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->like($item, $_POST['search']['value']);
				}
				else
				{
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if(count($this->column_search) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
			}
			$i++;
		}
		
		if(isset($_POST['order'])) // here order processing
		{
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order))
		{
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatables($where = array()){
		$this->_get_datatables_query($where);
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}
	
	function count_filtered( $where = array() ){
		$this->_get_datatables_query( $where );
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all( $where = array()  ){
		$this->db->where("del_status", 0);
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}
	
	//get all data
	public function get_data($tablename, $where = array(), $order_key = array() , $limit="") {
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
		if( !empty ($order_key)){
			foreach($order_key as $key => $value){
				$this->db->order_by($key, $value );
			}
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
	
	
	//get city data
	public function get_city_list_by_cat_state($tablename, $where = array()) {
        $table = $tablename;
	    if (!empty($where)) {
			foreach($where as $key => $value){
				$this->db->where( $key, $value );
			}
        }
		
		//If date range not empty
		if( isset( $_POST['date_to'])  && isset( $_POST['date_from'] ) && !empty($_POST['date_to']) ){
			$this->db->where("created >=", date('Y-m-d', strtotime($_POST['date_from'])) );
			$this->db->where("created <=", date('Y-m-d H:i:s', strtotime($_POST['date_to'] . "23:59:59")) ); 
		}
		
		$this->db->from($tablename);
		$this->db->group_by("city");
        $q = $this->db->get();
		$res = $q->result();
		return $res;
    }
	
	//Count data
	public function count_all_musers( $table_name, $where = array(), $where_custom = "", $like = array() ){
		if (!empty($where)) {
			foreach($where as $key => $value){
				$this->db->where( $key, $value );
			}
        }
		
		if( !empty( $where_custom ) ){
			$this->db->where( $where_custom );
		}
		
		if( !empty( $like ) ){
			foreach($like as $key => $value){
				$this->db->like( $key, $value );
			}
		}
		$this->db->from($table_name);
		return $this->db->count_all_results();
	}
	
	
	/* update Contacts concnate */
	function update_data_contacts_log($id="", $contacts = ""  ){
		$this->db->set('sent_to', "CONCAT(sent_to,',','".$contacts."')", FALSE); 
		$this->db->where( 'id', $id );
		$this->db->update('msg_log');
		return true;
	}
	
	
	//Get pending customers
	public function get_customer_contact_list($table, $where = array(), $not_in_key = "", $data_not_in = array(), $limit = "" ) {
		$user = $this->session->userdata('logged_in');
		$user_role = $user["role"];
		$user_id = $user["user_id"];
		
		if (!empty($where)) {
			foreach($where as $key => $value){
				$this->db->where( $key, $value );
			}
        }
		
		//check if user_role = 96 get customer
		if( $user_role == 96 ){
			$this->db->where( "agent_id", $user_id );
			
			if( isset( $_POST["date_from"] ) && !empty(  $_POST["date_from"] ) ){
				$d_from =	$_POST["date_from"];
				$d_to	= 	$_POST["date_to"];
				$d_from 	= date('Y-m-d', strtotime($d_from));
				$d_to	 	= date('Y-m-d H:i:s', strtotime($d_to . "23:59:59"));
				$this->db->where("created >=", $d_from );
				$this->db->where("created <=", $d_to );
			}
			
		}
		
		if( !empty( $data_not_in ) ){
			$this->db->where_not_in( $not_in_key, $data_not_in );
		}
		$this->db->from($table);
		//if limit exists
		if (!empty($limit)) {
			$this->db->limit($limit);
		}
        $q = $this->db->get();
		$res = $q->result();
		return $res;
    }
	
	
	
	
						
	//Get processing user list
	function get_process_leads_lists( $data_not_in = array(), $limit = "" ){
		$user = $this->session->userdata('logged_in');
		$user_role = $user["role"];
		$user_id = $user["user_id"];
		
		$this->db->select('C.customer_name, C.customer_contact,C.customer_email,C.customer_id');
        $this->db->from('customers_inquery AS C');
        $this->db->join('itinerary AS iti', 'C.customer_id = iti.customer_id', 'INNER');
		$this->db->where("iti.iti_close_status", 0 );
		$this->db->where("iti.del_status", 0 );
		
		//check if user_role = 96 get customer
		if( $user_role == 96 ){
			$this->db->where( "iti.agent_id", $user_id );
			$this->db->where( "C.lead_close_status", 0 );
		}else{
			$this->db->where("iti.iti_status", 9 );
		}
		
		if( !empty( $data_not_in ) ){
			$this->db->where_not_in( "C.customer_contact", $data_not_in );
		}
		if (!empty($limit)) {
			$this->db->limit($limit);
		}
		$q = $this->db->get();
		$res = $q->result();
        return $res;
	}
	//get email list
	function get_process_leads_email_lists( $data_not_in = array(), $limit = "" ){
		$user = $this->session->userdata('logged_in');
		$user_role = $user["role"];
		$user_id = $user["user_id"];
		
		$this->db->select('C.customer_name, C.customer_contact,C.customer_email,C.customer_id');
        $this->db->from('customers_inquery AS C');
        $this->db->join('itinerary AS iti', 'C.customer_id = iti.customer_id', 'INNER');
		
		$this->db->where("iti.iti_close_status", 0 );
		$this->db->where("iti.del_status", 0 );
		
		//check if user_role = 96 get customer
		if( $user_role == 96 ){
			$this->db->where( "iti.agent_id", $user_id );
			$this->db->where( "C.lead_close_status", 0 );
		}else{
			$this->db->where("iti.iti_status", 9 );
		}
		
		if( !empty( $data_not_in ) ){
			$this->db->where_not_in( "C.customer_email", $data_not_in );
		}
		if (!empty($limit)) {
			$this->db->limit($limit);
		}
		$q = $this->db->get();
		$res = $q->result();
        return $res;
	}
	
	
	//check company exist in current city
	function isMarketingUserExists_insert( $city_id, $company_name ) {
		$this->db->select('id');
		$this->db->where(array('city'=> $city_id, 'company_name' => trim($company_name)) );
		$query = $this->db->get('marketing');
		if ($query->num_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	//check company exist in current city
	function isMarketingUserExists_update( $user_id, $city_id, $company_name  ) {
		$this->db->select('id');
		$this->db->where(array('city'=> trim($city_id), 'company_name' => trim($company_name)) );
		$this->db->where_not_in('id', $user_id);
		$query = $this->db->get('marketing');
	
		if ($query->num_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	//get marketing user assign to agent
	public function get_marketing_user_by_agent($id = null){
		if( !$id ) return false;
		
		$user = $this->session->userdata('logged_in');
		$user_id = $user['user_id'];
		
		$assign_state 	= get_agents_assigned_state( $user_id );
		$assign_cities 	=  get_agents_assigned_city( $user_id );
		$ex_city = !empty($assign_cities) ? explode(",", $assign_cities ) : "";
		
		
		$query = $this->db->select('*')->from('marketing')
			->where_in('state' , $assign_state )
			->where_in('city' , $ex_city )
			->get();
		$res = $query->result();
		
		if($res){
			$result =  $res;
		}else{
			$result = false;
		}
		return $result;
	}
	
}
?>