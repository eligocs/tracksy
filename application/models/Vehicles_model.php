<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vehicles_model extends CI_Model{
	public $table = 'vehicles';
	public $column_order = array(null, 'car_name','car_rate'); 
	public $column_search = array('car_name','car_rate');
	public $order = array('car_name' => 'ASC'); 
	//Transporter filter
	public $table_trans = 'transporters';
	public $column_order_trans = array(null, 'trans_name','trans_email'); 
	public $column_search_trans = array('trans_name','trans_email', 'trans_address', 'trans_cars_list');
	public $order_trans = array('trans_name' => 'ASC'); 

    function __construct(){
        parent::__construct();
	}
	
	//update
	public function update_vehicle($id) {
		$car_name 	= strip_tags($this->input->post('car_name'));
		$car_rate 	= strip_tags($this->input->post('car_rate'));
		$max_person 	= strip_tags($this->input->post('max_person'));
		$data= array(
			'car_name'=> $car_name,
			'car_rate'=> $car_rate,
			'max_person'=> $max_person,
		);
		
		$this->db->where('id',$id);
		$this->db->update('vehicles',$data);
		return true;
	}
	
	// get datatable all cars
	private function _get_datatables_query(){
		$this->db->where("del_status", 0);
		$this->db->from($this->table);
		$i = 0;
		foreach ($this->column_search as $item) // loop column 
		{
			if(  isset($_POST['search']['value'])) // if datatable send POST for search
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

	function get_datatables(){
		$this->_get_datatables_query();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}
	
	function count_filtered(){
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all(  ){
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}
	
	/* Transporter Section */
	// Insert
	public function insert_transporter() {
		$trans_name			= $this->input->post('trans_name');
		$trans_address		= $this->input->post('trans_address');
		$trans_email		= $this->input->post('trans_email');
		$trans_contact		= $this->input->post('trans_contact');
		$trans_cars_list	= $this->input->post('trans_cars_list');
		$cars = implode(",",$trans_cars_list);
	
		$data_array= array(
			'trans_name'			=> $trans_name,
			'trans_email'			=> $trans_email,
			'trans_contact'			=> $trans_contact,
			'trans_address'			=> $trans_address,
			'trans_cars_list'		=> $cars,

		);
		
		if ($this->db->insert('transporters', $data_array)) {
            $result = $this->db->insert_id();
        } else {
            $result = false;
        }
        return $result;
    }
	// update
	public function editTransporter($id) {
		$trans_name			= $this->input->post('trans_name');
		$trans_address		= $this->input->post('trans_address');
		$trans_email		= $this->input->post('trans_email');
		$trans_contact		= $this->input->post('trans_contact');
		$trans_cars_list	= $this->input->post('trans_cars_list');
		$cars = implode(",",$trans_cars_list);
	
		$data_array= array(
			'trans_name'			=> $trans_name,
			'trans_email'			=> $trans_email,
			'trans_contact'			=> $trans_contact,
			'trans_address'			=> $trans_address,
			'trans_cars_list'		=> $cars,

		);
		$this->db->where('id',$id);
		$q = $this->db->update('transporters',$data_array);
		if ($q) {
			$result = true;
        } else {
            $result = false;
        }
        return $result;
    }
	
	// get datatable all cars
	private function _get_datatables_query_trans(){
		$this->db->where("del_status", 0);
		$this->db->from($this->table_trans);
		$i = 0;
		foreach ($this->column_search_trans as $item) // loop column 
		{
			if(  isset($_POST['search']['value'])) // if datatable send POST for search
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

				if(count($this->column_search_trans) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
			}
			$i++;
		}
		
		if(isset($_POST['order'])) // here order processing
		{
			$this->db->order_by($this->column_order_trans[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order_trans))
		{
			$order = $this->order_trans;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatables_trans(){
		$this->_get_datatables_query_trans();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}
	
	function count_filtered_trans(){
		$this->_get_datatables_query_trans();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_trans(  ){
		$this->db->from($this->table_trans);
		return $this->db->count_all_results();
	}
	
}
?>