<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hotelbooking_model extends CI_Model{
	public $table = 'hotel_booking';
	public $column_order = array(null, 'h_book.id','h_book.iti_id'); //set column field database for datatable orderable
	public $column_search = array('h_book.customer_id','h_book.id','h_book.check_in','h_book.check_out','h_book.iti_id','hotels.hotel_name', 'cus.customer_name'); //set column field database for datatable searchable 
	public $order = array('h_book.id' => 'DESC'); // default order 
	
	function __construct(){
        parent::__construct();
	}
	/*********************** Hotel Booking start here ************************/

	public function insert_hotelbooking() {
		/* Post Value from itinerary */
		$hotel_id				= strip_tags($this->input->post('hotel', TRUE));
		$invoice_id				= strip_tags($this->input->post('invoice_id', TRUE));
		$room_type				= strip_tags($this->input->post('room_type', TRUE));
		$total_travellers		= strip_tags($this->input->post('total_travellers', TRUE));
		$check_in				= strip_tags($this->input->post('check_in', TRUE));
		$check_out				= strip_tags($this->input->post('check_out', TRUE));
		$inclusion				= strip_tags($this->input->post('inclusion', TRUE));
		$meal_plan				= strip_tags($this->input->post('meal_plan', TRUE));
		$room_cost				= strip_tags($this->input->post('room_rates', TRUE));		
		$total_rooms			= strip_tags($this->input->post('total_rooms', TRUE));
		$extra_bed_cost			= strip_tags($this->input->post('extra_bed_rate', TRUE));		
		$without_extra_bed		= strip_tags($this->input->post('without_extra_bed', TRUE));		
		$without_extra_bed_cost	= strip_tags($this->input->post('without_extra_bed_cost', TRUE));		
		$extra_bed				= strip_tags($this->input->post('extra_bed', TRUE));		
		$inclusion_cost			= strip_tags($this->input->post('extra_charges', TRUE));
		$hotel_tax				= strip_tags($this->input->post('hotel_tax', TRUE));
		$total_cost				= strip_tags($this->input->post('total_cost', TRUE));
		$customer_id			= strip_tags($this->input->post('customer_id', TRUE));
		$state_id				= strip_tags($this->input->post('state_id', TRUE));
		$city					= strip_tags($this->input->post('hotelcity', TRUE));
		$iti_id					= strip_tags($this->input->post('iti_id', TRUE));
		$agent_id				= strip_tags($this->input->post('agent_id', TRUE));
		$is_approved_by_gm		= is_admin_or_manager() ? 2 : 0;
	
		$data_array= array(
			'hotel_id'			=> $hotel_id,		
			'invoice_id'		=> $invoice_id,		
			'city_id'			=> $city,		
			'state_id'			=> $state_id,		
			'customer_id'		=> $customer_id,	
			'iti_id'			=> $iti_id,		
			'total_travellers'	=> $total_travellers,		
	 		'total_rooms'		=> $total_rooms,	
			'room_cost'			=> $room_cost,		
			'extra_bed'			=> $extra_bed,		
			'extra_bed_cost'	=> $extra_bed_cost,
			'without_extra_bed'			=> $without_extra_bed,		
			'without_extra_bed_cost'	=> $without_extra_bed_cost,
			'inclusion_cost'	=> $inclusion_cost,
			'check_in'			=> $check_in,		
			'check_out'			=> $check_out,		
			'meal_plan'			=> $meal_plan,		
			'inclusion'			=> $inclusion,		
			'room_type'			=> $room_type,		
			'hotel_tax'			=> $hotel_tax,		
			'total_cost'		=> $total_cost,	
			'agent_id'			=> $agent_id,
			'is_approved_by_gm'	=> $is_approved_by_gm,
		);
		
		if ($this->db->insert('hotel_booking', $data_array)) {
            $result = $this->db->insert_id();
        } else {
            $result = false;
        }
        return $result;
    }
	/* Update booking Status */
	//update profile
	
	function update_booking_status($iti_id, $hotel_id, $id ){
		$booking_note = strip_tags($this->input->post('booking_note'));
		$booking_status = $this->input->post('booking_status');
		$data = array(
			'booking_note' => $booking_note,
			'booking_status' => $booking_status,
		);
		$this->db->where('iti_id', $iti_id);
		$this->db->where('hotel_id', $hotel_id);
		$this->db->where('id', $id);
		$this->db->update('hotel_booking', $data);
		return true;
	} 
	/*********************** Hotel Booking Ends here ************************/
	
	//datatable view all Hotel Bookings
	private function _get_datatables_query($where){
		
		$this->db->select('h_book.*'); 
		$this->db->from('hotel_booking as h_book')
		->join('hotels as hotels', 'h_book.hotel_id = hotels.id', 'LEFT')
		->join('customers_inquery as cus', 'h_book.customer_id = cus.customer_id', 'LEFT');

		if( isset($_POST['date_from']) && $_POST['date_from'] ){
			$check_in = date("Y-m-d", strtotime( $_POST['date_from'] ));
			$check_in_to = date("Y-m-d", strtotime( $_POST['date_to'] ));
			$this->db->where("h_book.check_in >=", $check_in );
			$this->db->where("h_book.check_in <=", date('Y-m-d H:i:s', strtotime($check_in_to . "23:59:59")) );
		}
		
		//add custom filter here
		if( isset( $_POST['filter'] ) ){
			$filter_data = trim($this->input->post('filter'));
			switch( $filter_data ){
				case "approved":
					$this->db->where( "h_book.booking_status", 9 );
					break;
				case "declined":
					$this->db->where( "h_book.booking_status", 8 );
					break;
				case "cancel":
					$this->db->where( "h_book.booking_status", 7 );
					break;
				case "pending":
					$this->db->where( "h_book.booking_status", 0 );
					break;
					
				case "pending_gm":
					$this->db->where( "h_book.is_approved_by_gm", 1 );
					break;
					
				case "upcomming":
					$today = date("Y-m-d");
					$this->db->where("h_book.check_in >= ",$today);
					$this->db->where( "h_book.booking_status", 9 );
					$this->db->order_by( "h_book.check_in", "DESC" );
					break;
				case "past":
					$today = date("Y-m-d");
					$this->db->where("h_book.check_in < ",$today);
					$this->db->order_by( "h_book.check_in", "DESC" );
					break;	
				default:					
					break;
			} 
        }
		
		if (!empty($where)) {
			foreach($where as $key => $value){
				$this->db->where( $key, $value );
			}
        }
		$this->db->where("h_book.del_status", 0);
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
	
	//clone hotel booking
	function duplicate_hotel_booking($table, $primary_key_field, $primary_key_val){
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
				switch( $key ){
					
					case ( $key == "booking_status" || $key == "email_count" || $key == "is_approved_by_gm" || $key == "room_cost_old_by_agent" ):
						$this->db->set($key, "0");
					break;
					case ( $key == "booking_cancel_note" || $key == "hotel_cancel_booking_note" || $key == "booking_note" || $key == "invoice_id" ):
						$this->db->set($key, "");
					break;
					case ($key == "created_date" ):	
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
	
	
	
	
	
	
	
}
?>
