<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Search_model extends CI_Model{
	
	function __construct(){
        parent::__construct();
	}
	
	
	public function GetCustomersData($keyword, $agent_id) { 
		$this->db->select("customer_id, customer_name, customer_contact");
		$this->db->where("del_status" , 0 );
		
		//$this->db->where("(customer_id LIKE '$keyword' OR customer_name LIKE '$keyword' OR customer_contact LIKE '$keyword' )");
		$like_conditions = $this->_multi_like_conditions(array("customer_id", "customer_name", "customer_contact"), $keyword);
		$this->db->where($like_conditions);
		//if agent_id exist
		if( !empty( $agent_id ) ){
			$this->db->where("agent_id" , $agent_id );
		}
		
		$this->db->limit(10);
		$this->db->order_by("customer_id", "DESC");
        return $this->db->get('customers_inquery')->result_array();
    }
	
	//multiple like or
	private function _multi_like_conditions (array $fields, $search_text) {
		$likes = array();
		foreach ($fields as $field) {
			$likes[] = "$field LIKE '%$search_text%'";
		}
		return '('.implode(' || ', $likes).')';
	}

	
	//Get itinerary follow up data by customer_id
	public function get_iti_followup_data( $customer_id,  $agent_id=null  ) { 
		$this->db->select('iti_f.*');
		$this->db->from('iti_followup AS iti_f'); // I use aliasing make joins easier
		$this->db->join('itinerary AS iti', 'iti_f.iti_id = iti.iti_id', 'INNER');
		$this->db->join('customers_inquery AS cus', 'cus.customer_id = iti.customer_id', 'INNER');
		$this->db->where( "cus.customer_id", $customer_id );
		if( !empty( $agent_id ) ){
			$this->db->where( "iti.agent_id", $agent_id );
		}
		$this->db->order_by( "iti_f.id", "DESC" );
		return $this->db->get()->result();
		
    }
	
	
	//Get Customer follow up data by customer_id
	public function get_cus_followup_data( $customer_id, $agent_id=null ) { 
		$this->db->select('cus_f.*, cus.customer_name, cus.customer_contact');
		$this->db->from('customer_followup AS cus_f'); // I use aliasing make joins easier
		$this->db->join('customers_inquery AS cus', 'cus.customer_id = cus_f.customer_id', 'INNER');
		$this->db->where( "cus.customer_id", $customer_id );
		if( !empty( $agent_id ) ){
			$this->db->where( "cus.agent_id", $agent_id );
		}
		$this->db->order_by( "cus_f.id", "DESC" );
		return $this->db->get()->result();
		
    }
	
	//Get Total Itinerary follow up data by customer_id
	public function get_total_iti_data( $customer_id,  $agent_id=null  ) { 
		$this->db->select('cus_f.customer_id, iti.package_name, iti.iti_id');
		$this->db->from('customers_inquery AS cus_f'); // I use aliasing make joins easier
		$this->db->join('itinerary AS iti', 'cus_f.customer_id = iti.customer_id', 'INNER');
		$this->db->where( "cus_f.customer_id", $customer_id );
		if( !empty( $agent_id ) ){
			$this->db->where( "iti.agent_id", $agent_id );
		}
		$this->db->order_by( "iti.iti_id", "DESC" );
		return $this->db->get()->result();
    }
	
	function getcustomerdata($id=null){
        $this->db->select('customer_followup.customer_prospect as c_pros,customer_followup.currentCallTime as c_time,customer_followup.callType');
		$this->db->from('customer_followup');
        $this->db->where('customer_followup.customer_id',$id);
        $this->db->where('customer_followup.customer_prospect !=','');
        $query = $this->db->get();
        return $query->result_array();
		
    }
	function getitidata($id = null){
        $this->db->select('iti.itiProspect as i_pros,iti.currentCallTime as i_time');
		$this->db->from('iti_followup as iti');
        $this->db->where('iti.customer_id',$id);
        $this->db->where('iti.itiProspect !=','');
        $query = $this->db->get();
        return $query->result_array();
		
    }
	
}
?>