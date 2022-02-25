<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Voucher_model extends CI_Model{
	/* datatable filter varibles for hotels */
	public $table = 'iti_vouchers_status';
	public $column_order = array(null, 'v.id','v.iti_id'); //set column field database for datatable orderable
	public $column_search = array('v.id','v.iti_id','c.customer_name','c.customer_contact', 'v.voucher_id'); //set column field database for datatable searchable 
	public $order = array('v.id' => 'DESC'); // default order 
	
	
	function __construct(){
        parent::__construct();
	}
	
	//datatable view all Vouchers
	private function _get_datatables_query($where){
		$user = $this->session->userdata('logged_in');
		$u_id = $user['user_id'];
		$role = $user['role'];
		//get data
		$this->db->select('v.*,p2.package_name,p2.temp_key, p2.iti_type, c.customer_name, c.customer_contact,c.customer_email')
		->from('iti_vouchers_status as v')
		->join('itinerary as p2', 'v.iti_id = p2.iti_id', 'INNER')
		->join('customers_inquery as c', 'c.customer_id = p2.customer_id', 'INNER');

		if( $role == 96 ){
			$this->db->where( 'p2.agent_id', $u_id );
		}
		
		if (!empty($where)) {
			foreach($where as $key => $value){
				$this->db->where( $key, $value );
			}
        }
		
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
	
	//get data for csv as array
	public function getdatacsv($tablename, $where = array() ) {
        $table = $tablename;
		if (!empty($where)) {
			foreach($where as $key => $value){
				$this->db->where( $key, $value );
			}
        }
		$this->db->from($table);
		
        $q = $this->db->get();
		$res = $q->result_array();
		if ($res) {
			$result = $res;
		} else {
            $result = false;
        }
        return $result;
    }
	
	
	//get all data
	public function getdata( $tablename, $where = array(), $order_key = NULL, $order_val = NULL ) {
        $table = $tablename;
		
	    if (!empty($where)) {
			foreach($where as $key => $value){
				$this->db->where( $key, $value );
			}
        }
		
		$this->db->from($table);
		
		if( !empty ($order_key) && !empty( $order_val ) ){
			$this->db->order_by($order_key, $order_val );
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
	
	
	//get pending voucher
	public function get_pending_vouchers_list(){
		$this->db->select('iti.*')
		->from('itinerary as iti')
		->join('iti_vouchers_status as iti_v', 'iti.iti_id = iti_v.iti_id', 'INNER')
		//->where("iti_v.hotel_booking_status", 1)
		->where("(iti.iti_type = 1 AND iti_v.vtf_booking_status = 1 AND iti_v.cab_booking_status = 1  AND iti_v.hotel_booking_status = 1 AND iti_v.confirm_voucher=0 ) OR ( iti.iti_type = 2 AND iti_v.hotel_booking_status = 1 AND iti_v.confirm_voucher=0 ) ")
		//->where("iti_v.vtf_booking_status", 1)
		//->where("iti_v.cab_booking_status", 1)
		//->where("iti_v.confirm_voucher", 0)
		->where("iti.del_status", 0)
		->where("iti.iti_status", 9)
		->where("iti.iti_close_status", 0);
		$this->db->order_by( "iti_v.id", "DESC" );
		$this->db->group_by( "iti.iti_id");
		$q = $this->db->get();
		return $q->result();
	}
	
}
?>
