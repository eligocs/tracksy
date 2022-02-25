<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vehiclesbooking_model extends CI_Model{
	//For cab booking
	public $table = 'cab_booking';
	public $column_order = array(null, 'id','iti_id', 'customer_id',);
	public $column_search = array('customer_id','id','picking_date','droping_date','iti_id',);
	public $order = array('id' => 'DESC');
	
	// For train, volvo & flight booking
	public $table_vol = 'travel_booking';
	public $column_order_vol = array(null, 'id', 'customer_id','iti_id');
	public $column_search_vol = array('customer_id','id','dep_date','arr_date','dep_loc','arr_loc','iti_id','booking_type');
	public $order_vol = array('id' => 'DESC');
	
	function __construct(){
        parent::__construct();
	}
	
	public function get_transporter_by_vehicle_id( $id ){
		$table = 'transporters';
		$this->db->where("del_status", 0);
		$q = $this->db->query("SELECT * FROM {$table} WHERE find_in_set( {$id}, trans_cars_list) AND del_status = '0'");
		$res = $q->result();
		if( $res ){
			$result = $res;
		}else{
			$result = false;
		}
        return $res;
	}
	
	/* Update booking Status */
	function update_booking_status($id , $iti_id){
		$booking_note = strip_tags($this->input->post('booking_note'));
		$booking_status = $this->input->post('booking_status');
		$data = array(
			'booking_note' => $booking_note,
			'booking_status' => $booking_status,
		);
		$this->db->where('id', $id);
		$this->db->where('iti_id', $iti_id);
		$this->db->update('cab_booking', $data);
		return true;
	} 
	
	// update_booking_status_vtf Volvo train flight
	
	function update_booking_status_vtf($id , $status){
		$data = array(
			'booking_status' => $status,
		);
		$this->db->where('id', $id);
		$this->db->update('travel_booking', $data);
		return true;
	} 
	
	//datatable view all Cab Bookings
	private function _get_datatables_query($where){
		if( isset($_POST['date_from']) && $_POST['date_from'] ){
			$check_in = date("Y-m-d", strtotime( $_POST['date_from'] ));
			$check_in_to = date("Y-m-d", strtotime( $_POST['date_to'] ));
			$this->db->where("picking_date >=", $check_in );
			$this->db->where("picking_date <=", date('Y-m-d H:i:s', strtotime($check_in_to . "23:59:59")) );
		}

		//add custom filter here
		if( isset( $_POST['filter'] ) ){
			$filter_data = trim($this->input->post('filter'));
			switch( $filter_data ){
				case "approved":
					$this->db->where( "booking_status", 9 );
					break;
				case "declined":
					$this->db->where( "booking_status", 8 );
					break;
				case "cancel":
					$this->db->where( "booking_status", 7 );
					break;
				case "pending":
					$this->db->where( "booking_status", 0 );
					break;
				case "pending_gm":
					$this->db->where( "is_approved_by_gm", 1 );
					break;
				case "upcomming":
					$today = date("Y-m-d");
					$this->db->where("date_format(STR_TO_DATE(picking_date, '%d/%m/%Y'),'%Y-%m-%d') >= ",$today);
					$this->db->where( "booking_status", 9 );
					$this->db->order_by( "picking_date", "DESC" );
					break;
				case "past":
					$today = date("Y-m-d");
					$this->db->where("date_format(STR_TO_DATE(picking_date, '%d/%m/%Y'),'%Y-%m-%d') < ",$today);
					$this->db->order_by( "picking_date", "DESC" );
					break;	
				default:
					// continue22;
					break;
			} 
        }
		
		if (!empty($where)) {
			foreach($where as $key => $value){
				$this->db->where( $key, $value );
			}
        }
		$this->db->where("del_status", 0);
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
	
	//datatable view all Vehicles Bookings
	private function _get_datatables_query_vol($where){

		if( isset($_POST['date_from']) && $_POST['date_from'] ){
			$check_in = date("Y-m-d", strtotime( $_POST['date_from'] ));
			$check_in_to = date("Y-m-d", strtotime( $_POST['date_to'] ));
			$this->db->where("dep_date >=", $check_in );
			$this->db->where("dep_date <=", date('Y-m-d H:i:s', strtotime($check_in_to . "23:59:59")) );
		}

		//add custom filter here
		if( isset( $_POST['filter'] ) ){
			$filter_data = trim($this->input->post('filter'));
			$booking_type = trim($this->input->post('booking_type'));
			
			//if not empty booking type
			if( !empty( $booking_type ) ){
				$this->db->where( "booking_type", $booking_type );
			}
			
			switch( $filter_data ){
				case "approved":
					$this->db->where( "booking_status", 9 );
					break;
				case "cancel":
					$this->db->where( "booking_status", 8 );
					break;
				case "pending":
					$this->db->where( "booking_status", 0 );
					break;
				case "pending_gm":
					$this->db->where( "is_approved_by_gm", 1 );
					break;
				case "upcomming":
					$today = date("Y-m-d");
					$this->db->where("dep_date >= ",$today);
					$this->db->where( "booking_status", 9 );
					$this->db->order_by( "dep_date", "DESC" );
					break;
				case "past":
					$today = date("Y-m-d");
					$this->db->where("dep_date < ",$today);
					$this->db->order_by( "dep_date", "DESC" );
					break;	
				default:
					// continue22;
				break;
			} 
        }
		
		if (!empty($where)) {
			foreach($where as $key => $value){
				$this->db->where( $key, $value );
			}
        }
		$this->db->where("del_status", 0);
		$this->db->from("travel_booking");
		$i = 0;
		foreach ($this->column_search_vol as $item){
			if(  isset($_POST['search']['value'])){
				if($i===0){
					$this->db->group_start();
					$this->db->like($item, $_POST['search']['value']);
				}else{
					$this->db->or_like($item, $_POST['search']['value']);
				}
				if(count($this->column_search_vol) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
			}
			$i++;
		}
		
		if(isset($_POST['order'])){
			$this->db->order_by($this->column_order_vol[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		}else if(isset($this->order_vol)){
			$order = $this->order_vol;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatables_vol( $where = array() ){
		$this->_get_datatables_query_vol($where);
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}
	
	function count_filtered_vol($where = array()){
		$this->_get_datatables_query_vol( $where );
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_vol( $where = array() ){
		if (!empty($where)) {
			foreach($where as $key => $value){
				$this->db->where( $key, $value );
			}
        }
		$this->db->from("travel_booking");
		return $this->db->count_all_results();
	}
	
	
}
?>