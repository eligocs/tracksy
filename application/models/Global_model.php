<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/****Model for yatra helper and global settings***/
class Global_Model extends CI_Model 
{
    function __construct(){
        parent::__construct();
	}

	//insert Data
	public function insert_data($tablename, $data_array) {
        if ( $this->db->insert($tablename, $data_array) ) {
            $id = $this->db->insert_id();
			$result = $id;
        } else {
            $result = false;
        }
        return $result;
    }
	
	//insert batch Data
	public function insert_batch_data($tablename, $data_array) {
        if ( $this->db->insert_batch($tablename, $data_array) ) {
			$result = true;
        } else {
            $result = false;
        }
        return $result;
    }
	
	/*Get all countries*/
	public function get_all_countries(){
		$query = $this->db->select('*')->from('countries')->get();
		$res = $query->result();
		if($res){
			$result =  $res;
		}else{
			$result = false;
		}
		return $result;
	}
	
	/* get states by country id */
	public function get_states_by_country_id($id){
		$query = $this->db->select('*')->from('states')->where("country_id", $id)->get();
		$res = $query->result();
		if($res){
			$result =  $res;
		}else{
			$result = false;
		}
		return $result;
	}
	/* get cities by state ID*/
	public function get_cities($state_id){
		$this->db->select('*');
		$this->db->where("state_id", $state_id );
		$this->db->from("cities");
		$query = $this->db->get();
		
		$res = $query->result();
		if($res){
			$result =  $res;
		}else{
			$result = false;
		}
		return $result;
	}
	/*Get country name*/
	public function get_country_name($id){
		$query = $this->db->select('*')->from('countries')->where("id", $id )->get();
		$res = $query->result();
		if($res){
			$return =  $res[0]->name;
		}else{
			$return = false;
		}
		return $return;
	}
	
	/*Get Hotel name*/
	public function get_hotel_name($id){
		$query = $this->db->select('*')->from('hotels')->where("id", $id )->get();
		$res = $query->result();
		if($res){
			$return =  $res[0]->hotel_name;
		}else{
			$return = false;
		}
		return $return;
	}
	
	/*Get state name*/
	public function get_state_name($id){
		$query = $this->db->select('*')->from('states')->where("id", $id )->get();
		$res = $query->result();
		if($res){
			$return =  $res[0]->name;
		}else{
			$return = false;
		}
		return $return;
	}
	/*Get city name*/
	public function get_city_name($id){
		$query = $this->db->select('*')->from('cities')->where("id", $id )->get();
		$res = $query->result();
		if($res){
			$return =  $res[0]->name;
		}else{
			$return = false;
		}
		return $return;
	}
	
	/* get City by Hotel id */
	public function get_hotel_byy_city_id($id){
		$query = $this->db->select('*')->from('hotels')->where("city_id", $id)->where("del_status", 0)->order_by("hotel_name", "ASC")->get();		
		$res = $query->result();
		if($res){
			$result =  $res;
		}else{
			$result = false;
		}
		return $result;
	}
	
	/*Get city name*/
	public function get_hotels_by_city($id){
		$query = $this->db->select('*')->from('hotels')->where("city_id", $id )->where("hotel_category", 'Standard' )->get();
		$res = $query->result();
		if($res){
			//$return =  $res[0]->hotel_name;
			$return =  $res;
		}else{
			$return = false;
		}
		return $return;
	}
	
	/*Get all countries*/
	public function get_hotel_categories(){
		$query = $this->db->select('*')->from('hotel_categories')->get();
		$res = $query->result();
		if($res){
			$result =  $res;
		}else{
			$result = false;
		}
		return $result;
	}
	
	/*Get all Cars*/
	public function get_car_categories(){
		$query = $this->db->select('*')->where("del_status", 0)->from('vehicles')->order_by("car_name", "ASC")->get();
		$res = $query->result();
		if($res){
			$result =  $res;
		}else{
			$result = false;
		}
		return $result;
	}
	/* 
	* Get hotecategory Name by ID
	*/
	function get_hotel_cat_name($id) {
	   $query = $this->db->select('*')->from('hotel_categories')->where("star_id", $id )->get();
		$res = $query->result();
		if($res){
			$return =  $res[0]->name;
		}else{
			$return = false;
		}
		return $return;
	}
	/* 
	* Get user Name by ID
	*/
	function get_user_name($id){
		$query = $this->db->select('*')->from('users')->where("user_id", $id )->get();
		$res = $query->result();
		if($res){
			$return =  $res[0]->user_name;
		}else{
			$return = false;
		}
		return $return;
	}
	/*Get all Service team*/
	public function get_all_sales_team_agents(){
		$query = $this->db->select('*')->from('users')->where("user_type", 96)
		->where("del_status", 0)
		->where("user_status", "active")
		->order_by("user_name", "ASC")->get();
		$res = $query->result();
		if($res){
			$result =  $res;
		}else{
			$result = false;
		}
		return $result;
	}
	
	//get agents which are not assigned in teamleader
	public function get_all_sales_not_in_team_leaders( $not_in = array() ){
		$not_in = $this->get_all_in_teamleaders();
		$this->db->select('*')->from('users')->where("user_type", 96)
		->where("del_status", 0)
		->where("user_status", "active");
		
		if( !empty( $not_in ) ){
			$this->db->where_not_in("user_id", $not_in );
		}
		$this->db->order_by("user_name", "ASC");
		$query = $this->db->get();
		$res = $query->result();
		if($res){
			$result =  $res;
		}else{
			$result = false;
		}
	
		return $result;
	}
	
	//get all agenets which are in teamleader section
	public function get_all_in_teamleaders( $id = NULL ){
		$where = array();
		$this->db->select('*')->from('teamleaders');
		if( $id ){ 
			$this->db->where("id", $id);
		}
		
		$query = $this->db->get();
		$res = $query->result();
		if($res){
			$agents_id = array();
			foreach( $res as $key => $agent ){
				$agents_id[] = $agent->leader_id;
				if( !empty($agent->assigned_members) ){
					$a_agent = explode( ",", $agent->assigned_members );
					foreach( $a_agent as $as ){
						$agents_id[] = $as;
					}
				} 
			}
			$result =  $agents_id;
		}else{
			$result = array();
		}
		return $result;
	}
	
	//get sales team agents login in today
	public function get_all_sales_team_loggedin_today(){
		$query = $this->db->select('*')->from('users')->where("user_type", 96)
		->where("del_status", 0)
		->where("user_status", "active")
		->like("last_login", date("Y-m-d") )
		->order_by("user_name", "ASC")->get();
		$res = $query->result();
		if($res){
			$result =  $res;
		}else{
			$result = false;
		}
		return $result;
	}
	
	//get team leaders login today
	public function get_all_teamleaders_loggedin_today(){
		$today = date("Y-m-d");
		$sql = "SELECT u.user_name as username, u.user_id as user_id FROM users as u INNER JOIN teamleaders as l on (u.user_id = l.leader_id) WHERE u.user_status = 'active' AND u.last_login LIKE '%{$today}%'";
		$q = $this->db->query($sql);
		return $q->result();
	}
	
	//get all data
	public function getdata( $tablename, $where = array(), $getCol = NULL, $order_key = NULL, $limit= NULL ) {
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
			$this->db->order_by($order_key, "DESC");
		}
		//if limit exists
		if (!empty($limit)) {
			$this->db->limit($limit);
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
	
	//get all data without key=>value in where
	public function getdata_where( $tablename, $where = NULL , $getCol = NULL, $order_key = NULL, $limit=NULL ) {
        $table = $tablename;
		if (!empty($getCol)) {
            $this->db->select($getCol);
        }
	    if (!empty($where)) {
			$this->db->where( $where);
        }
		$this->db->from($table);
		if( !empty ($order_key)){
			$this->db->order_by($order_key, "DESC");
		}
		//if limit exists
		if (!empty($limit)) {
			$this->db->limit($limit);
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
	
	//get rooms by category id
	public function get_room_category_by_id($id){
		$query = $this->db->select('*')->from('room_category')->where("room_cat_id", $id )->get();
		$res = $query->result();
		if($res){
			$result =  $res[0]->room_cat_name;
		}else{
			$result = false;
		}
		return $result;
	}
	
	/* update itinerary del status  */
	function update_del_status( $tablename, $where = array() ){
		if (!empty($where)) {
			$data = array(
				'del_status' => 1,
			);
			foreach($where as $key => $value){
				$this->db->where( $key, $value );
			}
			$this->db->update($tablename , $data);
			return true;
        }else{
			return false;
		}
	}
	
	/* update Data Global function */
	function update_data( $tablename, $where = array(), $data = array() ){
		if (!empty($where)) {
			foreach($where as $key => $value){
				$this->db->where( $key, $value );
			}
			$this->db->update($tablename , $data);
			return true;
        }else{
			return false;
		}
	}
	
	//Count data
	public function count_all( $table_name, $where = array(), $like = array() ){
		if (!empty($where)) {
			foreach($where as $key => $value){
				$this->db->where( $key, $value );
			}
        }
		
		if( !empty( $like ) ){
			foreach($like as $key => $value){
				$this->db->like( $key, $value );
			}
		}
		
		$this->db->from($table_name);
		return $this->db->count_all_results();
	}
	
	//delete permanent
	function delete_data($table, $where){
		if (!empty($where)) {
			foreach($where as $key => $value){
				$this->db->where( $key, $value );
			}
			$this->db->delete($table);
			return $this->db->affected_rows();
		}else{
			return false;
		}
	}
	
	//delete permanent where id in
	function delete_data_custom($table, $where){
		if (!empty($where)) {
			$this->db->where( $where );
			$this->db->delete($table);
			return $this->db->affected_rows();
		}else{
			return false;
		}
	}
	
	/* save leads visitor session data */
	function update_leads_counter($iti_id) {
	// return current article views 
		
		$this->db->where('iti_id', $iti_id );
		$this->db->select('visit_count');
		$count = $this->db->get('itinerary_visiter_data')->row();
		// set the timezone first
		if(function_exists('date_default_timezone_set')) {
			date_default_timezone_set("Asia/Kolkata");
		}
		// then use the date functions, not the other way around
		$current_date = date("d-M-Y h:i:s A");
		
		//if iti exists update data else insert
		if( !empty($count) ){
			// then increase by one 
			$this->db->where('iti_id',  $iti_id);
			$this->db->set('visit_count', ($count->visit_count + 1));
			$this->db->set('last_visit', $current_date);
			$this->db->update('itinerary_visiter_data');
		}else{
			$data_array = array("iti_id" => $iti_id, "visit_count" => 1, "last_visit" => $current_date, "first_visit" => $current_date );
			$this->db->insert("itinerary_visiter_data", $data_array);
            $id = $this->db->insert_id();
			return $id;
		}
	}
	
	//get all testimonial by limit
	function getAllTestimonials( $where = array() , $limit = "", $start = "" ){
		
		if (!empty($where)) {
			foreach($where as $key => $value){
				$this->db->where( $key, $value );
			}
        }
		
		$this->db->limit($limit, $start);
		$this->db->order_by("id", "DESC");
		$query = $this->db->get('client_reviews');
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
	}
	
	// get all package category
	public function get_package_categories(){
		$query = $this->db->select('*')->where("del_status", 0)->from('package_category')->order_by("p_cat_id", "ASC")->get();
		$res = $query->result();
		if($res){
			$result =  $res;
		}else{
			$result = false;
		}
		return $result;
	}
	
	
	//Data table Query
	private function _get_datatables_query( $table, $where, $column_order, $column_search, $order ){
		if (!empty($where)) {
			foreach($where as $key => $value){
				$this->db->where( $key, $value );
			}
        }
		$this->db->from($table);
		$i = 0;
		if( !empty( $column_search ) ){
			foreach ($column_search as $item){
				if(  isset($_POST['search']['value'])){
					if($i===0){
						$this->db->group_start();
						$this->db->like($item, $_POST['search']['value']);
					}else{
						$this->db->or_like($item, $_POST['search']['value']);
					}
					if(count($column_search) - 1 == $i) //last loop
						$this->db->group_end(); //close bracket
				}
				$i++;
			}
		} 	
		
		if(isset($_POST['order'])){
			$this->db->order_by($column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		}else if(isset($order) && !empty( $order ) ){
			$order = $order;
			$this->db->order_by(key($order), $order[key($order)]);
		} 
	}

	function get_datatables( $table, $where = array(), $column_order = array(), $column_search=array(), $order = array() ){
		$this->_get_datatables_query($table, $where, $column_order,$column_search,$order );
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}
	
	function count_filtered( $table, $where = array(), $column_order = array(), $column_search=array(), $order = array() ){
		$this->_get_datatables_query($table, $where, $column_order,$column_search,$order );
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_data( $table, $where = array() ){
		if (!empty($where)) {
			foreach($where as $key => $value){
				$this->db->where( $key, $value );
			}
        }
		$this->db->from($table);
		return $this->db->count_all_results();
	}
	//End Data table
	
	//Get All Hotels
	function get_all_hotels(){
		$this->db->select('*');
		$this->db->where('del_status',0);
		$this->db->order_by("hotel_name", "ASC");
		$this->db->from("hotels");
		$query=$this->db->get();
		return $query->result();
	}
	
	//Get All Meal Plan
	function get_all_mealplans(){
		$this->db->select('*');
		$this->db->where('del_status',0);
		$this->db->order_by("name", "ASC");
		$this->db->from("meal_plan");
		$query=$this->db->get();
		return $query->result();
	}
	
	//get all fields itinerary
	function get_table_fields($table_name){
		$result = $this->db->list_fields( $table_name );
		$data = array();
		foreach($result as $field){
			$data[] = $field;
		}
		return $data;
	}
	//get all categories
	public function get_all_categories(){
		$query = $this->db->select('*')->from('marketing_category')->get();
		$res = $query->result();
		if($res){
			$result =  $res;
		}else{
			$result = false;
		}
		return $result;
	}
	
	//get categories name 
	public function get_category_name( $cat_id ){
		$query = $this->db->select('category_name')->where("id", $cat_id)->from('marketing_category')->get();
		$res = $query->result();
		if($res){
			$result =  $res[0]->category_name;
		}else{
			$result = false;
		}
		return $result;
	}
	
	/*Get get_promo_name */
	public function get_promo_name($id){
		$query = $this->db->select('*')->from('promotion_details')->where("id", $id )->get();
		$res = $query->result();
		if($res){
			$return =  $res[0]->promotion_name;
		}else{
			$return = false;
		}
		return $return;
	}
	
	
	//update flipbook visitor count
	
	public function update_flipbook_counter($id = NULL ) {
		// return current article views 
		$this->db->where('id',$id);
		$this->db->select('visitor_count');
		$count = $this->db->get('promotion_details')->row();
		// then increase by one 
		$this->db->where('id', $id);
		$this->db->set('visitor_count', ($count->visitor_count + 1));
		$this->db->update('promotion_details');
	}
	
	//count_pages
	function count_pages($id){
		//echo $id; die;
		$today = date('Y-m-d');
	   $query = $this->db->select('id')->from('promotion_pages')->where('promotion_id',$id)->get();
		$res = $query->result();
		if($res){
			$return =  count($res);
		}else{
			$return = false;
		}
		return $return;
	}
	
	//GET NOTIFICATIONS
/* 	public function get_notifications(){
		$user = $this->session->userdata('logged_in');
		$user_id 	= $user['user_id'];
		$user_role 	= $user['role'];
		//Get notifications query
		$sql = "SELECT * FROM notifications where read_status = 0 AND notification_time > now() AND notification_time < DATE_SUB(NOW(), INTERVAL -15 MINUTE) AND notification_for = {$user_role}";
		
		if( $user_role == 96 ){
			$sql .= " AND agent_id = {$user_id}";
		}	
		
		$sql .= " order by id DESC";
		$q = $this->db->query($sql);
		return $q->result_array();
	} */
	
	public function get_notifications(){
		$user = $this->session->userdata('logged_in');
		$user_id 	= $user['user_id'];
		$user_role 	= $user['role'];
		$manager_condition = "";
		//if user role = 98 (manager)
		//notification_type = 1 = leads followup,2=iti followup
		if( $user_role == 98 ){
			//$manager_condition = " OR ( ( notification_type = 1 OR notification_type = 2 ) AND notification_time <= now() AND notification_for = 96  )";
			//Get notifications query 
			//OR ( notification_for = 98 AND read_status = 0 )
			//show followup notification to manager after +30 minute
			$sql = "SELECT * FROM notifications where 
			( ( read_status = 0 AND notification_type != 1 AND notification_type != 2 AND notification_for = 98 AND notification_time > now() AND notification_time < DATE_SUB(NOW(), INTERVAL -15 MINUTE) ) 
			OR  ( ( notification_type = 1 OR notification_type = 2 ) AND notification_time < DATE_SUB(NOW(), INTERVAL +30 MINUTE) AND notification_for = 96 ) )";
		}elseif( $user_role == 95 ){ //leads team
			$sql = "SELECT * FROM notifications where ( (read_status = 0 AND notification_time > now() AND notification_time < DATE_SUB(NOW(), INTERVAL -15 MINUTE)) OR ( ( notification_type = 10 or notification_type = 11) AND notification_time <= now() )) AND notification_for = 95"; 
		}elseif( $user_role == 93 ){ //accounts
			$sql = "SELECT * FROM notifications where ( (read_status = 0 AND notification_time > now() AND notification_time < DATE_SUB(NOW(), INTERVAL -15 MINUTE)) OR ( ( notification_type = 10 or notification_type = 11) AND notification_time <= now() )) AND notification_for = 93"; 
		}else if( $user_role == 96 ) { //sales team
		
			//if team leader
			if( is_teamleader() ){
				$sql = "SELECT * FROM notifications where ( (read_status = 0 AND notification_time > now() AND notification_time < DATE_SUB(NOW(), INTERVAL -15 MINUTE)) OR  ( ( notification_type != 0 ) AND notification_time <= now() ) ) AND notification_for = {$user_role} AND agent_id = {$user_id}";
			}else{
				$sql = "SELECT * FROM notifications where ( (read_status = 0 AND notification_time > now() AND notification_time < DATE_SUB(NOW(), INTERVAL -15 MINUTE)) OR  ( ( notification_type != 0 AND notification_type != 3 ) AND notification_time <= now() ) ) AND notification_for = {$user_role} AND agent_id = {$user_id}";
			}
			
		}else{
			$sql = "SELECT * FROM notifications where 
			( (read_status = 0 AND notification_time > now() AND notification_time < DATE_SUB(NOW(), INTERVAL -15 MINUTE)) 
			OR  ( ( notification_type != 0 AND notification_type != 3 ) AND notification_time <= now() ) ) AND notification_for = {$user_role}";
		}
		
		$sql .= " order by id DESC";
		//$sql .= " LIMIT 1";
		$q = $this->db->query($sql);
		//echo $this->db->last_query();
		//die;
		return $q->result_array();
	}
	
	
	//ajax_check_agent_incentive
	public function ajax_check_agent_incentive( $month, $agent_id = NULL ){
		if( $month ){
			$this->db->select('iti.iti_id,iti.temp_key, iti.customer_id, iti.adults, iti.child, iti.iti_decline_approved_date as booking_date, iti.approved_package_category as category, pay.travel_date, pay.package_actual_cost as package_cost,pay.advance_recieved,pay.is_below_base_price, pay.agent_margin, pay.second_pay_status,pay.second_payment_date,iti.agent_id, pay.id as pid, pay.iti_package_type as package_type')
			->from('itinerary as iti')
			->join('iti_payment_details as pay', 'iti.iti_id = pay.iti_id', 'INNER')
			->where("iti.del_status", 0)
			->where("iti.iti_status", 9)
			->where("pay.iti_booking_status", 0);
			if( $agent_id ){
				$this->db->where("iti.agent_id", $agent_id );
			}	
			$this->db->like( "iti.iti_decline_approved_date", $month );
			$this->db->order_by( "iti.agent_id", "DESC" );
			$q = $this->db->get();
			
			return $q->result();
		}else{
			return false;
		}
	}
	
	
	//Get agents monthly targets
	function get_agents_monthly_targets( $month = NULL , $agent_id = NULL ){
		$month = !empty($month) ? $month : date("Y-m");
		$this->db->select('u.user_id, CONCAT(u.first_name, " ",  u.last_name) as name, u.user_name,at.target,at.target_assigned_by');
        $this->db->from('users AS u');
        $this->db->join("agent_targets AS at", "u.user_id = at.user_id AND at.month LIKE '{$month}'", 'LEFT');
		$this->db->where( "u.user_status ", 'active' );
		$this->db->where( "u.del_status ", 0 );
		$this->db->where( "u.user_type ", 96 );
		
		if( !empty( $agent_id ) && $agent_id > 0 ){
			$this->db->where('u.user_id', $agent_id);
		}
		
		$this->db->order_by("u.user_name", "ASC"); 
		$this->db->group_by("u.user_id"); 
		$q = $this->db->get();
		$res = $q->result();
		
        return $res;
	}
	
	//Get agents monthly targets
	function get_single_agent_monthl_target( $agent_id = NULL , $month = NULL ){
		$user 		= $this->session->userdata('logged_in');
		$role 		= $user['role'];
		$user_id 	= $user['user_id'];
		//$agent_id   = $role == 96 ? $user_id : $agent_id;
		if( $role == 96 ){
			$agent_id   = is_teamleader() && !empty( $agent_id ) ? $agent_id : $user_id;
		}
		
		$month = !empty($month) ? $month : date("Y-m");
		$this->db->select('target');
        $this->db->from( 'agent_targets' );
        $this->db->like( 'month', $month );
		
		if( !empty( $agent_id ) && $agent_id > 0 ){
			$this->db->where('user_id', $agent_id);
		}
		
		$this->db->group_by("user_id"); 
		$q = $this->db->get();
		$res = $q->result();
        return $res;
	}
	
	
	
	//Get agents booked packages
	function get_agents_booked_packages( $agent_id = NULL , $month = NULL , $agent_in = array() ){
		$user 		= $this->session->userdata('logged_in');
		$role 		= $user['role'];
		$user_id 	= $user['user_id'];
		$agent_id   = $role == 96 && !is_teamleader() ? $user_id : $agent_id;
		$month = !empty($month) ? $month : date("Y-m");
		
		$this->db->select('iti.iti_id')
		->from('itinerary as iti')
		->join('iti_payment_details as pay', 'iti.iti_id = pay.iti_id', 'INNER')
		->where("iti.del_status", 0)
		->where("iti.iti_status", 9)
		->where("pay.iti_booking_status", 0);
		
		if( $agent_id ){
			$this->db->where("iti.agent_id", $agent_id );
		}
		
		//agent in exists
		if( $agent_in ){
			$this->db->where_in("iti.agent_id", $agent_in );
		}
		
		$this->db->like( "iti.iti_decline_approved_date", $month );
		$this->db->order_by( "iti.agent_id", "DESC" );
		return $this->db->count_all_results();
	}

	//get thought of the day
	function get_thought_of_day(){
		$this->db->select("*")
		->from('thought_of_day')
		->where('status', 0)
		->like('updated', date("Y-m-d") );
		$q = $this->db->get();
		return $q->result();
	}
}
?>