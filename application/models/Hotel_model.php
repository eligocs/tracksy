<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hotel_Model extends CI_Model 
{
	
	/* datatable filter varibles for hotels */
	public $table = 'hotels';

	public $column_order = array(null, 'hotel_category','hotel_name','country_id','state_id','city_id', 'hotel_address', 'hotel_email', 'hotel_contact', 'hotel_website'); //set column field database for datatable orderable
	public $column_search = array('hotel_name','country_id','state_id','city_id', 'hotel_category', 'hotel_address', 'hotel_email', 'hotel_contact', 'hotel_website'); //set column field database for datatable searchable 
	public $order = array('id' => 'DESC'); // default order 
	
	/* datatable filter varibles for Hotel room rates */
	public $table_room_rates = 'hotel_room_rates';
	public $column_order_rates = array(null,'hotel_id','room_rates', 'extra_bed_rate',); //set column field database for datatable orderable
	public $column_search_rates = array('hotel_id','hotel_name','state_id','city_id', 'room_cat_id', 'room_rates', 'extra_bed_rate'); //set column field database for datatable searchable 
	public $order_rates = array('hotel_name' => 'ASC'); // default order 
	
    function __construct(){
        parent::__construct();
	}
	
	//insert
	public function insert_hotel() {
		$country			= strip_tags($this->input->post('country'));
    	$state				= strip_tags($this->input->post('state'));
    	$city				= strip_tags($this->input->post('city'));
    	$category			= strip_tags($this->input->post('category'));
    	$name				= strip_tags($this->input->post('name'));
    	$contact			= strip_tags($this->input->post('contact'));
    	$email 				= strip_tags($this->input->post('email[]'));
		$website 			= strip_tags($this->input->post('website'));
		$address 			= strip_tags($this->input->post('address'));
		
		$data= array(
			'country_id'=> $country,
			'state_id'=> $state,
			'city_id'=> $city,
			'hotel_name'=> $name,
			'hotel_category'=> $category,
			'hotel_address'=> $address,
			'hotel_email'=> $email,
			'hotel_contact'=> $contact,
			'hotel_website'=> $website,
		);
		
        if ($this->db->insert("hotels", $data)) {
            $result = $this->db->insert_id();
        } else {
            $result = false;
        }
        return $result;
    }
	
	//edit hotel
	public function edit_hotel($id) {
		
    	$country			= strip_tags($this->input->post('country'));
    	$state				= strip_tags($this->input->post('state'));
    	$city				= strip_tags($this->input->post('city'));
    	$category			= strip_tags($this->input->post('category'));
    	$name				= strip_tags($this->input->post('name'));
    	$contact			= strip_tags($this->input->post('contact'));
    	$district			= strip_tags($this->input->post('district'));
		$email 				= strip_tags($this->input->post('email'));
		$website 			= strip_tags($this->input->post('website'));
		$address 			= strip_tags($this->input->post('address'));
			
		$data= array(
			'country_id'=> $country,
			'state_id'=> $state,
			'city_id'=> $city,
			'hotel_name'=> $name,
			'hotel_category'=> $category,
			'hotel_address'=> $address,
			'hotel_email'=> $email,
			'hotel_contact'=> $contact,
			'hotel_website'=> $website,
		);
		
		$this->db->where('id',$id);
		$this->db->update('hotels',$data);
		return true;
	}
		// Delete hotel by id
	function deleteHotel($id){
		
		$this->db->where("id", $id);
		$this->db->delete("hotels");
		return $this->db->affected_rows();
	}
	
	/*get hotel by id */
	public function get_hotel_byid( $id ){
		$query = $this->db->select('*')->from('hotels')->where("id = $id ")->get();
		return $query->result();
	}
	
	/*get hotel by id */
	public function get_hotel_by_city_id( $id ){
		$query = $this->db->select('*')->from('hotels')->where("city_id",$id )->get();
		$res = $query->result();
		if($res){
			$result = $res;
		}else{
			$result = false;
		}
		return $result;
	}
	
	/***************** Room Rates ************/
	public function get_hotelroomrates_byid( $id ){
		$query = $this->db->select('*')->from('hotel_room_rates')->where("htr_id = $id ")->get();
		return $query->result();
	}
	
	public function insert_hotelroomrates(){
		$country			= strip_tags($this->input->post('country'));
    	$state				= strip_tags($this->input->post('state'));
    	$city				= strip_tags($this->input->post('city'));
    	$hotel				= strip_tags($this->input->post('hotel'));
    	$room_cat_id		= strip_tags($this->input->post('room_cat_id'));
    	$room_rates			= strip_tags($this->input->post('room_rates'));
    	$extra_bed_rate 	= strip_tags($this->input->post('extra_bed_rate'));
		$hotel_name 		= get_hotel_name($hotel);
			
		$data= array(
			'country_id'=> $country,
			'state_id'=> $state,
			'city_id'=> $city,
			'hotel_id'=> $hotel,
			'hotel_name'=> $hotel_name,
			'room_cat_id'=> $room_cat_id,
			'room_rates'=> $room_rates,
			'extra_bed_rate'=> $extra_bed_rate,			
		);
		
        if ($this->db->insert("hotel_room_rates", $data)) {
            $result = $this->db->insert_id();
			$result = true;
        } else {
            $result = false;
        }
        return $result;
    }
	
	
	public function edit_roomrates($id) {
	   	$room_rates			= strip_tags($this->input->post('room_rates'));
    	$extra_bed_rate 	= strip_tags($this->input->post('extra_bed_rate'));
		$data= array(
			'room_rates'=> $room_rates,
			'extra_bed_rate'=> $extra_bed_rate,			
		);
		
		$this->db->where('htr_id',$id);
		$this->db->update('hotel_room_rates',$data);
		return true;
	}
	
	
	function deleteRoomRates($id)
	{
		$this->db->where("htr_id", $id);
		$this->db->delete("hotel_room_rates");
		return $this->db->affected_rows();
	}
	
	
	/***************** Room Category ************/
	public function insert_roomcategory() {
		$roomcatname 			= strip_tags($this->input->post('room_cat_name'));
		$data= array(
			'room_cat_name'=> $roomcatname,
		);
		
        if ($this->db->insert("room_category", $data)) {
            $result = $this->db->insert_id();
        } else {
            $result = false;
        }
        return $result;
    }
	
	public function edit_rooomcategory($id) {
		
    	$room_cat_name 	= strip_tags($this->input->post('room_cat_name'));
			
		$data= array(
			'room_cat_name'=> $room_cat_name,
		);
		
		$this->db->where('room_cat_id',$id);
		$this->db->update('room_category',$data);
		return true;
	}
	
	public function get_roomcategory_byid( $id ){
		$query = $this->db->select('*')->from("room_category")->where("room_cat_id = $id ")->get();
		return $query->result();
	}

	// get datatable all hotels
	private function _get_datatables_query(){
		//add custom filter here
		if( isset( $_POST['city'] ) && !empty( $_POST['city'] ) ){
			
			$city 		= trim($this->input->post('city'));
			$hotel_cat 	= trim($this->input->post('hotel_cat'));
			
			if( !empty( $city ) && !empty( $hotel_cat ) ){
				$this->db->where("city_id", $city );
				if( $hotel_cat != "all" ){
					$this->db->where("hotel_category", $hotel_cat );
				}	
			} 
        }
		
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
	
	// get datatable all Room rates
	private function _get_datatables_query_room_rates(){
		$this->db->from($this->table_room_rates);
		$this->db->where("del_status", 0);
		$i = 0;
		foreach ($this->column_search_rates as $item){
			if(  isset($_POST['search']['value'])){
				if($i===0){
					$this->db->group_start();
					$this->db->like($item, $_POST['search']['value']);
				}else{
					$this->db->or_like($item, $_POST['search']['value']);
				}
				if(count($this->column_search_rates) - 1 == $i)
					$this->db->group_end(); //close bracket
			}
			$i++;
		}
		
		if(isset($_POST['order'])){
			$this->db->order_by($this->column_order_rates[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		}elseif(isset($this->order_rates)){
			$order = $this->order_rates;
			$this->db->order_by(key($order), $order[key($order)]);
		}
		
		//Group By hotel ID
		$this->db->group_by("hotel_id");
	}

	function get_datatables_room_rates(){
		$this->_get_datatables_query_room_rates();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}
	
	function count_filtered_room_rates(){
		$this->_get_datatables_query_room_rates();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_room_rates(){
		$this->db->from($this->table_room_rates);
		return $this->db->count_all_results();
	}
	
	
	/*check hotel if exist in current city */
	function isHotelExists_insert( $city_id, $hotel_name ) {
		$this->db->select('id');
		$this->db->where(array('city_id'=> $city_id, 'hotel_name' => trim($hotel_name)) );
		$query = $this->db->get('hotels');
		if ($query->num_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	/* check if hotel exists excluded current */
	function isHotelExists_update( $hotel_id, $city_id, $hotel_name  ) {
		$this->db->select('id');
		$this->db->where(array('city_id'=> trim($city_id), 'hotel_name' => trim($hotel_name)) );
		$this->db->where_not_in('id', $hotel_id);
		$query = $this->db->get('hotels');
	
		if ($query->num_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	
}
?>