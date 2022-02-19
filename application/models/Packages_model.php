<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class packages_model extends CI_Model{
	/* datatable filter varibles for hotels */
	public $table = 'packages';
	public $column_order = array(null,'package_id'); //set column field database for datatable orderable
	public $column_search = array('package_id','publish_status', 'package_name'); //set column field database for datatable searchable 
	
	public $order = array('package_id' => 'DESC'); // default order 
	public $column_search2 = array('p_cat_id','package_cat_name'); //set column field database for datatable searchable 
	public $column_order2 = array(null,'p_cat_id'); //set column field database for datatable orderable
	public $order2 = array('p_cat_id' => 'DESC'); // default order 
	
	
	function __construct(){
        parent::__construct();
	}
	
	//datatable view all packages
	private function _get_datatables_query($where){
		if (!empty($where)) {
			foreach($where as $key => $value){
				$this->db->where( $key, $value );
			}
        }
		
		$this->db->from($this->table);
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
					$this->db->group_end(); //close bracket
			}
			$i++;
		}
		
		if(isset($_POST['order'])){
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		}else if(isset($this->order)){
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatables( $where = array() ){
		$this->_get_datatables_query($where);
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}
	
	function count_filtered($where = array()){
		$this->_get_datatables_query( $where );
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
	
	//clone Package to itinerary
	function clone_package_to_itinerary($table, $primary_key_field, $primary_key_val, $customer_id, $agent_id){
	   /* generate the select query */
	   $this->db->where($primary_key_field, $primary_key_val); 
	   $query = $this->db->get("packages");
		
		foreach ($query->result() as $row){   
			foreach($row as $key=>$val){  
			
				if($key != "customer_id"){ 
					$this->db->set("customer_id", $customer_id);  
					$this->db->set("lead_created", leadGenerationDate($customer_id) ); 					
					$this->db->set("quatation_date", date("m/d/Y") );               
				}
				
				/* if($key != "quatation_date"){ 
				} */
				
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
						continue 2;
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
	
	
	// Package Category
	
	private function _get_datatables_query_cat($where){
		if (!empty($where)) {
			foreach($where as $key => $value){
				$this->db->where( $key, $value );
			}
        }
		
		$this->db->from('package_category');
		$i = 0;
		foreach ($this->column_search2 as $item){
			if(  isset($_POST['search']['value'])){
				if($i===0){
					$this->db->group_start();
					$this->db->like($item, $_POST['search']['value']);
				}else{
					$this->db->or_like($item, $_POST['search']['value']);
				}
				if(count($this->column_search2) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
			}
			$i++;
		}
		
		if(isset($_POST['order'])){
			$this->db->order_by($this->column_order2[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		}else if(isset($this->order2)){
			$order = $this->order2;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}
	
	function get_datatables_cat( $where = array() ){
		$this->_get_datatables_query_cat($where);
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}
	
	public function count_all_cat( $where = array() ){
		if (!empty($where)) {
			foreach($where as $key => $value){
				$this->db->where( $key, $value );
			}
        }
		$this->db->from('package_category');
		return $this->db->count_all_results();
	}
	
	function count_filtered_cat($where = array()){
		$this->_get_datatables_query_cat( $where );
		$query = $this->db->get();
		//print_r($query);
		return $query->num_rows();
	}
	
	public function insertCategory() {
        $catname = strip_tags($this->input->post('package_cat_name'));
		$data= array(
			'package_cat_name'=> $catname,
		);
		
        if ($this->db->insert("package_category", $data)) {
            //$result = $this->db->insert_id();
			$result = true;
        } else {
            $result = false;
        }
        return $result;
    }
	
	
	public function updateCategory() {
        $catname = strip_tags($this->input->post('package_cat_name'));
		$catId = strip_tags($this->input->post('cat_id'));
		$data= array(
			'package_cat_name'=> $catname,
		);
		
		$this->db->where('p_cat_id',$catId);
		$this->db->update('package_category',$data);
		return true;
		
    }
	
	
		
}
?>
