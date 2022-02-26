<?php
/*
* Custom Functions
*/

	/* 
	* Get Site Name
	*/
	function get_site_name() {
		$ci = & get_instance();
		$res = $ci->global_model->getdata( "settings", "", "site_title","",1 );
		if( $res ){
			$result = $res;
		}else{
			$result = "Track It";
		}	
		return $result;
	}

	/*get site link name */
	function get_site_link() {
		$ci = & get_instance();
		$res = $ci->global_model->getdata( "settings", "", "site_link","",1 );
		if( $res ){
			$result = $res;
		}else{
			$result = "Track It";
		}	
		return $result;
	}


	function getLogo(){
		$ci = & get_instance();
		$image_name = $ci->global_model->getdata( "homepage_setting", "", "logo_url","",1 );
		if( $image_name ){
			$result = $image_name;
		}else{
			$result = "trackv2logo.png";
		}	
		return $result;

	}


	function favicon(){
		$ci = & get_instance();
		$favicon = $ci->global_model->getdata( "homepage_setting", "", "favicon","",1 );
		if( $favicon ){
			$result = $favicon;
		}else{
			$result = "trackv2logo.png";
		}	
		return $result;
	}
	
	/* 
	* Get User Name by ID
	*/
	function get_user_name($id) {
		if( trim($id) ){
			$ci = & get_instance();
			$res = $ci->global_model->get_user_name($id);
		}else{
			$res = false;
		}	
		return $res;
	}

	
	/*
	* Last Login
	*/
	function get_last_login() {
		$user_id = validate_login();
		if( $user_id ){
			$ci = & get_instance();
			$user_data 	= $ci->session->userdata('logged_in');
			$last_login =  !empty( $user_data['last_login'] ) ? date("d-m-Y h:i:s", strtotime($user_data['last_login'])) : "" ; 
			$login_ip 	=  $user_data['login_ip']; 
			echo "Name: " . $user_data['fname'] . " Last Login: " . $last_login . ", IP: {$login_ip}";
		}	
	}

	/* 
	* Get User Email by ID
	*/
	function get_user_email($id) {
		if( trim($id) ){
			$ci = & get_instance();
			$res = $ci->global_model->getdata( "users", array("user_id" => $id), "email" );
		}else{
			$res = false;
		}	
		return $res;
	}


	function get_user_all($id) {
		if( trim($id) ){
			$ci = & get_instance();
			$res = $ci->global_model->getuserdata($id);
		}else{
			$res = false;
		}	
		return $res;
	}
	
	/* 
	* Itinerary STATUS PAYMENT 
	*/
	function get_iti_booking_status($iti_id) {
		if( trim($iti_id) ){
			$ci = & get_instance();
			$res = $ci->global_model->getdata( "iti_payment_details", array("iti_id" => $iti_id), "iti_booking_status" );
			if( $res ){
				$result = $res;
			}else{
				$result = false;
			}
		}else{
			$result = false;
		}	
		return $res;
	}
	
	
	/*
	 * Update user last_visit
	*/
	
	function update_user_online_status() {
		$ci = & get_instance();
		$user_id =  validate_login(); 
		if (isset($user_id) && !empty($user_id)) {
			$curr_time = current_datetime();
			//update current time
			$ci->global_model->update_data( "users", array("user_id" => $user_id), array("last_visit" => $curr_time ) );
		}
	}
	
	/* 
	* get user online/offline status
	*/
	function get_user_online_status( $user_id ) {
		$online_offline_status = 0;
		if( $user_id ){
			$ci = & get_instance();
			$current_time = strtotime(current_datetime());
			//update current time
			$last_login = $ci->global_model->getdata( "users", array("user_id" => $user_id), "last_visit" );
			$last_visit = strtotime( $last_login ); // LAST VISITED TIME
			$time_period = floor(round(abs($current_time - $last_visit)/60,2)); //CALCULATING MINUTES
			if ($time_period <= 10){
                $online_offline_status = 1; // Means User is ONLINE
            } else {
                $online_offline_status = 0; // Means User is OFFLINE
            }
		}
		return $online_offline_status;
	}

	/* 
	* Get Customer Email by ID
	*/
	function get_customer_email($id) {
		if( trim($id) ){
			$ci = & get_instance();
			$res = $ci->global_model->getdata( "customers_inquery", array("customer_id" => $id), "customer_email" );
		}else{
			$res = false;
		}	
		return $res;
	}
	
	/* 
	* Get ITI STATUS
	*/
	function get_iti_status($customer_id) {
		if( trim($customer_id) ){
			$ci = & get_instance();
			$res = $ci->global_model->getdata( "itinerary", array("customer_id" => $customer_id), "iti_status" );
		}else{
			$res = false;
		}	
		return $res;
	}
	
	/*
	 * Validate login
	*/
	
	function validate_login() {
		$ci = & get_instance();
		$user_data = $ci->session->userdata('logged_in');
		$user_id =  $user_data['user_id']; 
		if (isset($user_id) && !empty($user_id)) {
			//$curr_time = current_datetime();
			//update current time
			//$ci->global_model->update_data( "users", array("user_id" => $user_id), array("last_visit" => $curr_time ) );
			return  $user_id;
		} else {
			redirect("/");
			die();
		}
	}
	/*
	 * Get Curent datetime
	*/
	function current_datetime(){
		// set the timezone first
		if(function_exists('date_default_timezone_set')) {
			date_default_timezone_set("Asia/Kolkata");
		}
		
		//Substract 7 minutes because of timezone issue on trackitinerary
		//if( base_url() == "https://trackitinerary.org/" || base_url() == "http://trackitinerary.org/" ){
			//substract 7 minutes from time for live only
		//	$newTime = strtotime('-7 minutes');
		//	return date('Y-m-d H:i:s', $newTime);
		//}else{
			// then use the date functions, not the other way around
			$date = date("Y-m-d H:i:s");
			return $date;
		//}	
	}
	//get user role 
	function get_user_role() {
		$ci = & get_instance();
		$user_data = $ci->session->userdata('logged_in');
		if( $user_data ){
			$role =  $user_data['role']; 
			if (isset($role) && !empty($role)) {
				return  $role;
			}else{
				return false;
			}
		}else{
			return false;
		}	
	}

	/*
	* Validate Username avoid special characters and whitespace
	*/
	function validate_username($str){
		return preg_match('/^[a-zA-Z0-9_@#$.]+$/',$str);
	}

	/*
	 * Get Admin
	*/
	function is_admin() {
		$ci = & get_instance();
		$user_data = $ci->session->userdata('logged_in');
		$role =  $user_data['role'];
		
		if (isset($role) && !empty($role) && $role == 99 ) {
			return  $role;
		}
	}
	
	/*
	 * Get Super Manager
	*/
	function is_super_manager() {
		$ci = & get_instance();
		$user_data = $ci->session->userdata('logged_in');
		$role 		=  $user_data['role']; 
		$user_id 	=  $user_data['user_id']; 
		if (isset($role) && !empty($role) ) {
			$is_super = $ci->global_model->getdata( "users", array( "user_id" => $user_id, "user_type" => 98, "is_super_manager" => 1 ) );
			return  !empty($is_super) ? true : false;
		}else{
			return false;
		}
	}
	
	/*
	 * Get Leads Manager
	*/
	function is_leads_manager() {
		$ci = & get_instance();
		$user_data = $ci->session->userdata('logged_in');
		$role 		=  $user_data['role']; 
		$user_id 	=  $user_data['user_id']; 
		if (isset($role) && !empty($role) ) {
			$is_super = $ci->global_model->getdata( "users", array( "user_id" => $user_id, "user_type" => 98, "is_super_manager" => 2 ) );
			return  !empty($is_super) ? true : false;
		}else{
			return false;
		}
	}
	
	/*
	 * Get Sales Manager
	*/
	function is_sales_manager() {
		$ci = & get_instance();
		$user_data = $ci->session->userdata('logged_in');
		$role 		=  $user_data['role']; 
		$user_id 	=  $user_data['user_id']; 
		if (isset($role) && !empty($role) ) {
			$is_super = $ci->global_model->getdata( "users", array( "user_id" => $user_id, "user_type" => 98, "is_super_manager" => 3 ) );
			return  !empty($is_super) ? true : false;
		}else{
			return false;
		}
	}
	
	/*
	* Get Account Manager
	*/
	function is_account_manager() {
		$ci = & get_instance();
		$user_data = $ci->session->userdata('logged_in');
		$role 		=  $user_data['role']; 
		$user_id 	=  $user_data['user_id']; 
		if (isset($role) && !empty($role) ) {
			$is_super = $ci->global_model->getdata( "users", array( "user_id" => $user_id, "user_type" => 98, "is_super_manager" => 4 ) );
			return  !empty($is_super) ? true : false;
		}else{
			return false;
		}
	}
	
	/*
	* Get General Manager
	*/
	function is_gm() {
		$ci = & get_instance();
		$user_data = $ci->session->userdata('logged_in');
		$role 		=  $user_data['role']; 
		$user_id 	=  $user_data['user_id']; 
		if (isset($role) && !empty($role) ) {
			$is_super = $ci->global_model->getdata( "users", array( "user_id" => $user_id, "user_type" => 98, "is_super_manager" => 5 ) );
			return  !empty($is_super) ? true : false;
		}else{
			return false;
		}
	}
	
	
	/*
	* Get Cost Manager
	*/
	function is_cost_manager() {
		$ci = & get_instance();
		$user_data = $ci->session->userdata('logged_in');
		$role 		=  $user_data['role']; 
		$user_id 	=  $user_data['user_id']; 
		if (isset($role) && !empty($role) ) {
			$is_super = $ci->global_model->getdata( "users", array( "user_id" => $user_id, "user_type" => 98, "is_super_manager" => 0 ) );
			return  !empty($is_super) ? true : false;
		}else{
			return false;
		}
	}
	

	/*
	 * Get User Role
	*/
	function get_user_role_by_id( $user_id = '' ) {
		$ci = & get_instance();
		if( !empty( $user_id ) ){
			$where = array("user_id" => $user_id );
			$user_role = $ci->global_model->getdata( "users", $where, "user_type" );
			return $user_role;
		}else{
			return false;
		}
	}
	
	/*
	 * Get Manager
	*/
	function is_manager() {
		$ci = & get_instance();
		$user_data = $ci->session->userdata('logged_in');
		$role =  $user_data['role']; 
		
		if ( isset($role) && !empty($role) && $role == 98 ) {
			return  $role;
		}else{
			return false;
		}
	}
	
	/*
	 * Get Sales Man
	*/
	
	function is_salesteam() {
		$ci = & get_instance();
		$user_data = $ci->session->userdata('logged_in');
		$role =  $user_data['role']; 
		
		if ( isset($role) && !empty($role) && $role == 96 ) {
			return  $role;
		}else{
			return false;
		}
	}
	
	/*
	* Check if agent is TEAMLEADER table: teamleaders
	*/
	
	function is_teamleader( $agent_id = NULL ) {
		$ci = & get_instance();
		$user_data = $ci->session->userdata('logged_in');
		$role		= $user_data['role']; 
		$user_id 	= !empty( $agent_id ) ? $agent_id : $user_data['user_id'];
		$res = false;
		if ( $user_id ) {
			$is_true = $ci->global_model->getdata( "teamleaders", array( "leader_id" => $user_id ) );			
			//retrun teammembers
			$res =  !empty($is_true[0]->assigned_members) ? array_map('trim', explode(",", $is_true[0]->assigned_members ) ) : "";
		}
		return $res;
	}
	
	/*
	 * Check Teamleader
	*/
	function get_teamleader( $agent_id = NULL ){
		$ci =& get_instance();
		$user_data		= $ci->session->userdata('logged_in');
		$role			= $user_data['role']; 
		$user_id 		=  $user_data['user_id'];
		$agent_id  		= !empty( $agent_id ) ? $agent_id : $user_id;
		if( !empty( $agent_id ) ){
			$agent_id = trim($agent_id);
			$q = $ci->db->query("SELECT * FROM teamleaders WHERE find_in_set( {$agent_id}, assigned_members)");
			$res = $q->result();
			if( isset($res[0]->leader_id ) ){
				$team_name = ucfirst($res[0]->team_name);
				$leader_name = ucfirst(get_user_name($res[0]->leader_id));
				return $team_name . " ( {$leader_name} )";
			}else{
				return false;
			}
		}else{
			return false;
		}	
	}
	
	/*
	 * Check Teamleader USER ID
	*/
	
	function get_teamleader_user_id( $agent_id = NULL ){
		$ci =& get_instance();
		$user_data		= $ci->session->userdata('logged_in');
		$role			= $user_data['role']; 
		$user_id 		=  $user_data['user_id'];
		$agent_id  		= !empty( $agent_id ) ? $agent_id : $user_id;
		if(!empty( $agent_id )){
			$agent_id = trim($agent_id);
			$q = $ci->db->query("SELECT * FROM teamleaders WHERE find_in_set( {$agent_id}, assigned_members )");
			$res = $q->result();
			if( isset($res[0]->leader_id ) ){
				return $res[0]->leader_id;
			}else{
				return false;
			}
		}else{
			return false;
		}	
	}
	
	//get teammembers
	function check_teammembers() {
		$ci = & get_instance();
		$user_data = $ci->session->userdata('logged_in');
		$role =  $user_data['role']; 
		$user_id =  $user_data['user_id']; 
		if ( isset($role) && !empty($role) ) {
			$is_true = $ci->global_model->getdata( "teamleaders", array("leader_id" => $user_id) );
			if( $is_true )
				return  !empty($is_true[0]->assigned_members) ? array_map('trim',explode(",", $is_true[0]->assigned_members )) : $user_id;
			else 
				return false;
		}else{
			return false;
		}
	}
	
	/*
	 * Get Service Team
	*/
	function is_serviceteam() {
		$ci = & get_instance();
		$user_data = $ci->session->userdata('logged_in');
		$role =  $user_data['role']; 
		
		if ( isset($role) && !empty($role) && $role == 97 ) {
			return  $role;
		}
	}
	
	/*
	 * Get if manager or admin
	*/
	
	function is_admin_or_manager() {
		$ci = & get_instance();
		$user_data = $ci->session->userdata('logged_in');
		$role =  $user_data['role']; 
		
		if ( isset($role) && !empty($role) && ( $role == 98 || $role == 99 ) ) {
			return true;
		}else{
			return false;
		}
	}
	
	/*
	 * Get if manager or admin or sales
	*/
	function is_admin_or_manager_or_sales() {
		$ci = & get_instance();
		$user_data = $ci->session->userdata('logged_in');
		$role =  $user_data['role']; 
		
		if ( isset($role) && !empty($role) && ( $role == 98 || $role == 99 || $role == 96 ) ) {
			return true;
		}else{
			return false;
		}
	}

	/*
	 * Get User details
	*/

	function get_user_info($user_id = '') {
		$user_id = (empty($user_id)) ? validate_login() : $user_id;
		$ci = & get_instance();
		$res = $ci->login_model->get_user_byid($user_id);
		if( $res ){
			$result = $res;
		}else{
			$result = false;
		}
		return $result;
	}
	/*
	 * Get Customer details
	*/
	function get_customer($customer_id = '') {
		if(!empty($customer_id)){
			$ci = & get_instance();
			$where = array("customer_id" => $customer_id);
			$res = $ci->global_model->getdata("customers_inquery", $where);
			return $res;
		}else{
			return false;
		}
	}

	/*
	 * Get Customer details
	*/
	function get_hotel_details($hotel_id = '') {
		if(!empty($hotel_id)){
			$ci = & get_instance();
			$where = array("id" => $hotel_id);
			$res = $ci->global_model->getdata("hotels", $where);
			return $res;
		}else{
			return false;
		}
	}

	/*
	 * Get All Hotels
	*/
	function get_hotels() {
		$ci = & get_instance();
		$where = array("del_status" => 0 );
		$res = $ci->global_model->get_all_hotels();
		return $res;
	}

	/*
	 * Get Transporter details
	*/
	function get_transporter_details($id) {
		if(!empty($id)){
			$ci = & get_instance();
			$where = array("id" => $id);
			$res = $ci->global_model->getdata("transporters", $where);
			return $res;
		}else{
			return false;
		}
	}
	
	/*
	 * Get All Transporters By Vehicle Id
	*/
	function get_all_transporter_by_vehicle_id( $id ){
		if(!empty($id)){
			$ci =& get_instance();
			$cab_id = trim($id);
			$q = $ci->db->query("SELECT * FROM transporters WHERE find_in_set( {$cab_id}, trans_cars_list) AND del_status = '0'");
			$res = $q->result();
			if( $res ){
				return $res;
			}else{
				return false;
			}
		}else{
			return false;
		}	
	}
	/*
	 * Get Settings
	*/
	function get_settings() {
		$ci = & get_instance();
		$res = $ci->global_model->getdata("settings");
		if( $res ){
			$return = $res[0];
		}else{
			$return = false;
		}
		return $return;
	}
	
	/*
	 * check if online payments are enabled
	*/
	
	function is_online_payments() {
		$ci = & get_instance();
		$where = array();
		$res = $ci->global_model->getdata("settings", $where, "online_payments");
		if( $res && $res == 1 ){
			return true;
		}else{
			redirect('promotion/pagenotfound');
			die();
		}
		return false;
	}
	
	function is_online_payments_status() {
		$ci = & get_instance();
		$where = array();
		$res = $ci->global_model->getdata("settings", $where, "online_payments");
		if( $res && $res == 1 ){
			return true;
		}
		return false;
	}
	
	/*
	 * Get Admin Email
	*/
	
	function admin_email() {
		$ci = & get_instance();
		$where = array();
		$res = $ci->global_model->getdata("settings", $where, "admin_email");
		if($res){	
			$result = $res;
		}else{
			$result = "admin@trackitinerary.com";
		}
		return $result;
	}
	

	
	/*
	 * Get Company Email
	*/
	function company_email() {
		$ci = & get_instance();
		$where = array();
		$res = $ci->global_model->getdata("settings", $where, "company_email");
		return $res;
	}
	
	/*
	 * Get Company Contact
	*/
	function company_contact() {
		$ci = & get_instance();
		$where = array();
		$res = $ci->global_model->getdata("settings", $where, "company_contact");
		return $res;
	}
	/*
	 * Get Company Info
	*/
	function company_info() {
		$ci = & get_instance();
		$where = array();
		$data = $ci->global_model->getdata("settings", $where, "company_info");
		$res = html_entity_decode( $data );
		return $res;
	}

	/*
	 * Get Tagline
	*/
	function get_tagline() {
		$ci = & get_instance();
		$where = array();
		$data = $ci->global_model->getdata("settings", $where, "tagline");
		$res = html_entity_decode( $data );
		return $res;
	}
	
	/*
	 * Get Manager Email
	*/
	
	function manager_email() {
		$ci = & get_instance();
		$where = array();
		$res = $ci->global_model->getdata("settings", $where, "manager_email");
		if($res){	
			$result = $res;
		}else{
			$result = "manager@trackitinerary.com";
		}
		return $result;
	}
	
	
	//Get Accounts Team Email
	function get_accounts_team_email(){
		$ci =& get_instance();
		return $ci->config->item('accounts_team_email');
	}
	
	
	//Get GM Email
	function get_gm_email(){
		$ci =& get_instance();
		return $ci->config->item('gm_email');
	}
	
	//Get GM Email
	function get_cab_team_email(){
		$ci =& get_instance();
		return $ci->config->item('cab_team_email');
	}
	
	//Get TRAIN BOOKING Email
	function get_train_booking_email(){
		$ci =& get_instance();
		return $ci->config->item('train_booking_email');
	}
	
	//Get FLIGHT Email
	function get_flight_booking_email(){
		$ci =& get_instance();
		return $ci->config->item('flight_booking_email');
	}
	
	//Get pan card number
	function company_pan(){
		$ci =& get_instance();
		return $ci->config->item('pancard');
	}
	
	//Get gst number
	function company_gsttin(){
		$ci =& get_instance();
		return $ci->config->item('gsttin');
	}
	
	//Get hsnsac card number
	function hsn_sac_number(){
		$ci =& get_instance();
		return $ci->config->item('hsn_sac_number');
	}
	
	/*
	 * Get Super Manager Email
	*/
	function super_manager_email() {
		$ci = & get_instance();
		$where = array();
		$res = $ci->global_model->getdata("settings", $where, "super_manager_email");
		if($res){	
			$result = $res;
		}else{
			$result = "super_manager@trackitinerary.com";
		}
		return $result;
	}
	
	/*
	 * Get Hotel Team Email
	*/
	function hotel_booking_email() {
		$ci = & get_instance();
		$where = array();
		$res = $ci->global_model->getdata("settings", $where, "hotel_email");
		if($res){	
			$result = $res;
		}else{
			$result = "hotel@trackitinerary.com";
		}
		return $result;
	}
	
	/*
	 * Get Sales Team Email
	*/
	function sales_team_email() {
		$ci = & get_instance();
		$where = array();
		$res = $ci->global_model->getdata("settings", $where, "sales_email");
		
		if($res){	
			$result = $res;
		}else{
			$result = "service@trackitinerary.com";
		}
		return $result;
	}

	/*
	 * Get Vehicle Email
	*/
	function vehicle_booking_email() {
		$ci = & get_instance();
		$where = array();
		$res = $ci->global_model->getdata("settings", $where, "vehicle_email");
		if($res){	
			$result = $res;
		}else{
			$result = "volvo@trackitinerary.com";
		}
		return $res;
	}

	/*
	 * Get Tax
	*/
	function get_tax() {
		$ci = & get_instance();
		$where = array();
		$res = $ci->global_model->getdata("settings", $where, "tax");
		if($res){	
			$result = $res;
		}else{
			$result = 5;
		}
		return $result;
	}
	
	
	//Get cgst
	function get_cgst(){
		$ci =& get_instance();
		return $ci->config->item('CGST');
	}
	
	//Get Sgst
	function get_sgst(){
		$ci =& get_instance();
		return $ci->config->item('SGST');
	}
	
	
	/*
	 * Get User details
	*/
	function get_agent_info($user_id) {
		$ci = & get_instance();
		$res = $ci->login_model->get_user_byid($user_id);
		return $res;
	}

	/*
	* Date Filter Format: d/m/Y
	*/
	function display_date_month($date) {
		if( !empty($date) ){
		$myDateTime = DateTime::createFromFormat('d/m/Y', $date);
		$newDateString = $myDateTime->format('d F, Y');
		return $newDateString;
		}else{
			return false;
		}
	}
	
	/*
	* Date Filter Format: d/m/Y to Y-m-d
	*/
	function change_date_format_dmy_to_ymd($date) {
		if( !empty($date) ){
			$myDateTime = DateTime::createFromFormat('d/m/Y', $date);
			$newDateString = $myDateTime->format('Y-m-d');
			return $newDateString;
		}else{
			return false;
		}
	}
	
	/*
	* Date Filter Format: m/d/Y
	*/
	function display_date_month_name($date) {
		if( !empty($date) ){
		$myDateTime = DateTime::createFromFormat('m/d/Y', $date);
		$newDateString = $myDateTime->format('d M, Y'); 
		return $newDateString;
		}else{
			return false;
		}
	}

	/*
	* Date Filter Format: Y-m-d
	*/
	function display_month_name($date) {
		if( !empty($date) ){
			$date = str_replace('/', '-', $date);
			$date = date("Y-m-d", strtotime($date) );
			$myDateTime = DateTime::createFromFormat('Y-m-d', $date);
			$newDateString = $myDateTime->format('d F, Y'); 
			return $newDateString;
		}else{
			return false;
		}
	}
	
	/*
	* Date Filter Format: Y-m-d H:i:s
	*/
	function display_month_name_with_time($date) {
		if( !empty($date) ){
			$date = str_replace('/', '-', $date);
			$new_time = DateTime::createFromFormat('Y-m-d H:i:s', $date);
			$time_12 = $new_time->format('d F, Y h:i A');
			return $time_12;
		}else{
			return false;
		}
	}

	/* date format */
	function reformatDate($date) {
		$newDateString =  date_create($date)->format('Y-m-d');
		return $newDateString;
	}
	
	/*
	* Date Filter  d/m/y to Y-m-d
	*/
	function change_date_format($date) {
		$myDateTime = DateTime::createFromFormat('d/m/Y', $date);
		$newDateString = $myDateTime->format('Y-m-d');
		return $newDateString;
	}
	/* 
	* Get Countries List
	*/
	function get_country_list() {
		$ci = & get_instance();
		$res = $ci->global_model->get_all_countries();
		return $res;
	}

	/* 
	* Get All Agents
	*/
	function get_all_sales_team_agents() {
		$ci = & get_instance();
		$res = $ci->global_model->get_all_sales_team_agents();
		return $res;
	}
	
	/* 
	* Get All get_all_sales_team_loggedin_today
	*/
	function get_all_sales_team_loggedin_today() {
		$ci = & get_instance();
		$res = $ci->global_model->get_all_sales_team_loggedin_today();
		return $res;
	}
	
	//check agent is loggedin today or not
	function is_agent_login_today( $agent_id ){
		$ci = & get_instance();
		$query = $ci->db->select('user_id')->from('users')
		->where("del_status", 0)
		->where( "user_id", $agent_id )
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
	
	
	/* 
	* Get All get_all_sales_team_loggedin_today
	*/
	function get_all_teamleaders_loggedin_today() {
		$ci = & get_instance();
		$res = $ci->global_model->get_all_teamleaders_loggedin_today();
		return $res;
	}

	
	/* 
	* Get State by country id
	*/
	function get_state_list( $id ) {
		if(trim($id)){
			$ci = & get_instance();
			$res = $ci->global_model->get_states_by_country_id($id);
		}else{
			$res = false;
		}	
		return $res;
	}

	/* 
	* Get Indian State
	*/
	function get_indian_state_list() {
		$ci = & get_instance();
		$res = $ci->global_model->getdata( "states", array("country_id" => 101 ));
		if( $res ){	
			$return = $res;
		}else{
			$return = false;
		}	
		return $return;
	}

	/* 
	* Get Cities by state id
	*/
	function get_city_list( $id) {
		if(trim($id)){
			$ci = & get_instance();
			$res = $ci->global_model->get_cities($id );
		}else{
			$res = false;
		}	
		return $res;
	}
	
	/* 
	* Get Country Name by ID
	*/
	function get_country_name($id) {
		if( trim($id) ){
			$ci = & get_instance();
			$res = $ci->global_model->get_country_name($id);
		}else{
			$res = false;
		}	
		return $res;
	}
	/* 
	* Get State Name by ID
	*/
	function get_state_name($id) {
		if( trim($id) ){
			$ci = & get_instance();
			$res = $ci->global_model->get_state_name($id);
		}else{
			$res = false;
		}	
		return $res;
	}
	/* 
	* Get City Name by ID
	*/
	function get_city_name($id) {
		if( trim($id) ){
			$ci = & get_instance();
			$res = $ci->global_model->get_city_name($id);
		}else{
			$res = false;
		}
		return $res;
	}

	//get hotel list by city id
	function get_hotel_list( $city_id ) {
		if( trim( $city_id ) ){
			$ci = & get_instance();
			$res = $ci->global_model->get_hotel_byy_city_id($city_id);
		}else{
			$res = false;
		}	
		return $res;
	}

	/* 
	* Get Hotel Name by ID
	*/
	function get_hotel_name($id) {
		if( is_numeric($id) ){
			$ci = & get_instance();
			$res = $ci->global_model->get_hotel_name($id);
		}else{
			$res = "No";
		}
		return $res;
	}

	/* 
	* Get Room Category Name By category Id
	*/
	function get_roomcat_name($id) {
		if( is_numeric($id) ){
			$ci = & get_instance();
			$where = array( "room_cat_id" => $id );
			$res = $ci->global_model->getdata("room_category", $where, 'room_cat_name');
			if( $res ){
				$result = $res;
			}else{
				$result = false;
			}
		}else{
			$result = false;
		}
		return $result;
	}
	
	/* 
	*Get Room Category Name By category Id
	*/
	function check_iti_type($iti_id) {
		if( is_numeric($iti_id) ){
			$ci = & get_instance();
			$where = array( "iti_id" => $iti_id );
			$res = $ci->global_model->getdata("itinerary", $where, 'iti_type');
			if( $res ){
				$result = $res == 2 ? "Accommodation" : "Holidays";
			}else{
				$result = false;
			}
		}else{
			$result = false;
		}
		return $result;
	}
	
	/* 
	* Get Car Name By id
	*/
	function get_car_name($id) {
		if( is_numeric($id) && !empty($id) ){
			$ci = & get_instance();
			$where = array( "id" => $id );
			$res = $ci->global_model->getdata("vehicles", $where, 'car_name');
			if( $res ){
				$result = $res;
			}else{
				$result = false;
			}
		}else{
			$result = false;
		}
		return $result;
	}

	/* 
	* Get Marketing Cat Name By id
	*/
	function get_marking_cat_name($id) {
		if( is_numeric($id) && !empty($id) ){
			$ci = & get_instance();
			$where = array( "id" => $id );
			$res = $ci->global_model->getdata("marketing_category", $where, 'category_name');
			if( $res ){
				$result = $res;
			}else{
				$result = false;
			}
		}else{
			$result = false;
		}
		return $result;
	}
	/* 
	* Get Transporter Name by id
	*/
	function get_transporter_name($id) {
		if( is_numeric($id) && !empty($id) ){
			$ci = & get_instance();
			$where = array( "id" => $id );
			$res = $ci->global_model->getdata("transporters", $where, 'trans_name');
			return $res;
		}else{
			return false;
		}
	}
	/* 
	* Get Transporter Contact by id
	*/
	function get_transporter_contact($id) {
		if( is_numeric($id) && !empty($id) ){
			$ci = & get_instance();
			$where = array( "id" => $id );
			$res = $ci->global_model->getdata("transporters", $where, 'trans_contact');
			return $res;
		}else{
			return false;
		}
	}
	/* 
	* Get Customer Name By category Id
	*/
	function get_customer_name($id) {
		if( is_numeric($id) ){
			$ci = & get_instance();
			$where = array( "customer_id" => $id );
			$res = $ci->global_model->getdata("customers_inquery", $where, 'customer_name');
			if( $res ){
				$result = $res;
			}else{
				$result = false;
			}
		}else{
			$result = false;
		}
		return $result;
	}
	/* 
	* Get Hotels By City ID
	*/
	function get_hotel_by_city_id($id) {
		if( trim($id) ){
			$ci = & get_instance();
			$res = $ci->global_model->get_hotels_by_city($id);
		}else{
			$res = false;
		}	
		return $res;
	}

	/*
	* Get Hotel Categries
	*/
	function hotel_categories(){
		 $ci = & get_instance();
		$res = $ci->global_model->get_hotel_categories();
		return $res;
	}

	/*
	* Get Car Categries
	*/
	function get_car_categories(){
		$ci = & get_instance();
		$res = $ci->global_model->get_car_categories();
		return $res;
	}

	/*
	* Get Packages categories.
	*/
	
	function get_package_categories(){
		$ci = & get_instance();
		$res = $ci->global_model->get_package_categories();
		return $res;
	}
	
	/*
	* Get Packages category name.
	*/
	
	function get_package_cat_name($id){
		$ci = & get_instance();
		$res = $ci->global_model->getdata("package_category", array("p_cat_id" => $id), "package_cat_name");
		return $res;
	}

	/*
	* Get Room Categries
	*/
	
	function get_room_categories(){
		$ci = & get_instance();
		$where = array( "del_status" => 0  );
		$res = $ci->global_model->getdata("room_category", $where);
		return $res;
	}

	/*
	* Get Seasons
	*/

	function get_all_seasons(){
		$ci = & get_instance();
		$where = array( "del_status" => 0  );
		$res = $ci->global_model->getdata("season_type", $where);
		return $res;
	}

	/*
	* Get Meal Plans
	*/

	function get_all_mealplans(){
		$ci = & get_instance();
		$res = $ci->global_model->get_all_mealplans();
		return $res;
	}

	function get_meal_plan_name($id){
		$ci = & get_instance();
		$res = $ci->global_model->getdata("meal_plan", array( "id" => trim($id) ), "name" );
		return $res;
	}

	function get_room_category_by_id($id){
		if( !empty($id) ){
			$ci = & get_instance();
			$res = $ci->global_model->get_room_category_by_id($id);
		}else{
			$res = false;
		}
		return $res;
	}

	/* 
	* Get City Name by ID
	*/
	function get_hotel_cat_name($id) {
		if( trim($id) ){
			$ci = & get_instance();
			$res = $ci->global_model->get_hotel_cat_name($id);
		}else{
			$res = false;
		}
		return $res;
	}

	/* Unique Token Key Generator */
	function getTokenKey($length = 10){
		$token = "";
		$codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
		$codeAlphabet.= "0123456789";
		$max = strlen($codeAlphabet); // edited

		for ($i=0; $i < $length; $i++) {
			$token .= $codeAlphabet[crypto_rand_secure(0, $max-1)];
		}
		return $token;
	}
	
	function crypto_rand_secure($min, $max){
		$range = $max - $min;
		if ($range < 1) return $min; // not so random...
		$log = ceil(log($range, 2));
		$bytes = (int) ($log / 8) + 1; // length in bytes
		$bits = (int) $log + 1; // length in bits
		$filter = (int) (1 << $bits) - 1; // set all lower bits to 1
		do {
			$rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
			$rnd = $rnd & $filter; // discard irrelevant bits
		} while ($rnd > $range);
		return $min + $rnd;
	}
	/* End Unique Token Key Generator */
		
		//Get All banks
		function get_all_banks(){
			$ci = & get_instance();
			$where = array("status" => "active");
			$res = $ci->global_model->getdata("bank_details", $where);
			if($res){
				$return = $res;
			}else{
				$return = false;
			}
			return $return;
		}
		
		//Get Itinerary terms and condition
		function get_terms_condition(){
			$ci = & get_instance();
			$where = array("term_type" => "itinerary");
			$res = $ci->global_model->getdata("terms", $where);
			if($res){
				$return = $res;
			}else{
				$return = false;
			}
			return $return;
		}
		
		//Get Booking with us Benefits
		function get_booking_benefits(){
			$ci = & get_instance();
			$where = array("term_type" => "itinerary");
			$res = $ci->global_model->getdata("terms", $where, "booking_benefits_terms");
			if( $res ){
				$return = unserialize( $res );
			}else{
				$return = false;
			}
			return $return;
		}
		
		//Get Hotel terms and condition
		function get_hotel_terms_condition(){
			$ci = & get_instance();
			$where = array("term_type" => "hotel");
			$res = $ci->global_model->getdata("terms", $where);
			if($res){
				$return = $res;
			}else{
				$return = false;
			}
			return $return;
		}
		//Get Cab terms and condition
		function get_cab_terms_condition(){
			$ci = & get_instance();
			$where = array("term_type" => "cab");
			$res = $ci->global_model->getdata("terms", $where);
			if($res){
				$return = $res;
			}else{
				$return = false;
			}
			return $return;
		}
		//Get online transfer terms and condition
		function get_company_details(){
			$ci = & get_instance();
			$res = $ci->global_model->getdata("settings");
			if($res){
				$return = $res;
			}else{
				$return = false;
			}
			return $return;
		}
		//Get Office branches
		function get_office_branches(){
			$ci = & get_instance();
			$where = array( "del_status" => 0 , "head_office !=" => 1 );
			$res = $ci->global_model->getdata("office_branches", $where);
			if($res){
				$return = $res;
			}else{
				$return = false;
			}
			return $return;
		}
		//Get Head Office
		function get_head_office(){
			$ci = & get_instance();
			$where = array( "del_status" => 0 , "head_office" => 1 );
			$res = $ci->global_model->getdata("office_branches", $where);
			if($res){
				$return = $res;
			}else{
				$return = false;
			}
			return $return;
		}
		
		// base 64_decode safeurl
		function base64_url_encode($data) { 
		  return rtrim(strtr(base64_encode($data), '+/', '-_'), '='); 
		} 
		
		function base64_url_decode($data) { 
		  return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT)); 
		}
		
		/* create unique slug */	
		function create_unique_slug( $string, $table, $field='slug', $key=NULL, $value=NULL ){
			$t =& get_instance();
			$slug = url_title($string);
			$slug = strtolower($slug);
			$i = 0;
			$params = array ();
			$params[$field] = $slug;

			if($key)$params["$key !="] = $value; 

			while ($t->db->where($params)->get($table)->num_rows()){	
				if (!preg_match ('/-{1}[0-9]+$/', $slug ))
					$slug .= '-' . ++$i;
				else
					$slug = preg_replace ('/[0-9]+$/', ++$i, $slug );
				
				$params [$field] = $slug;
			}   
			return $slug;	
		}

	/*
	 * Get Data By Key
	*/
	function get_soical_api( $key ) {
		$ci = & get_instance();
		if( !empty($key) ){
			$where = array();
			$res = $ci->global_model->getdata("social_api", $where, $key);
			if($res){	
				$result = $res;
			}else{
				$result = false;
			}
		}else{
			$result = false;
		}	
		return $result;
	}

	/*
	* Sent Mail
	*/
	function sendEmail( $to, $subject="", $msg="", $bcc="", $cc ="", $from="" ){
		// return true;
		$CI =& get_instance();
		$CI->load->library('email');
		
		//From email
		$from_address = !empty( $from ) ? $from : "no-reply@trackitinerary.com";
		$fromName = "trackitinerary";
		
		//or autoload it from /application/config/autoload.php
		$CI->email->from( $from_address, $fromName );
		$CI->email->to( $to );
		
		//send CC
		if( !empty( $cc ) ){
			$CI->email->cc( $cc );
		}
		
		//send bcc
		if( !empty( $bcc ) ){
			$CI->email->bcc( $bcc );
		}
		
		$CI->email->subject($subject);
		$CI->email->message( $msg );
		$CI->email->set_mailtype('html');
		$sent = $CI->email->send();
		if( $sent ){
			return true;
		}else{
			//print_r($CI->email->print_debugger()); DIE;
			return false;
		}	
	}

	//check if itinerary has child itinerary or not
	function check_child_iti( $iti_id ){
		$CI =& get_instance();
		$CI->load->model("itinerary_model");
		$iti_id = trim( $iti_id );
		if( !empty( $iti_id ) && is_numeric( $iti_id ) ){
			$get_parent_id = $CI->global_model->getdata( 'itinerary', array( "iti_id" => $iti_id ), "parent_iti_id" );
			$where = array( "iti_id" => $iti_id, "del_status" => 0 );
			if( !empty( $get_parent_id  ) &&  $get_parent_id !== 0 ){
				$orwhere = array( "iti_id" => $get_parent_id, "parent_iti_id" => $iti_id, "parent_iti_id" => $get_parent_id );
			}else{	
				$orwhere = array( "parent_iti_id" => $iti_id );
			}	
			$fetch_data = $CI->itinerary_model->getchildItidata( "itinerary", $where, $orwhere );
			$return = $fetch_data;
		}else{
			$return = false;
		}	
		return $return;
	}
	
	//Get All Predefined Packages
	function get_all_packages(){
		$ci = & get_instance();
		$where = array("del_status" => "0");
		$res = $ci->global_model->getdata("packages", $where);
		if($res){
			$return = $res;
		}else{
			$return = false;
		}
		return $return;
	}

	/* 
	* Get Itinerary Term By Itinerary Field
	*/
	function get_itinerary_field( $iti_id = "", $coulmn_name = "" ) {
		if( trim($iti_id) && !empty($coulmn_name) ){
			$ci = & get_instance();
			$res = $ci->global_model->getdata( "itinerary", array("iti_id" => $iti_id), $coulmn_name );
		}else{
			$res = false;
		}	
		return $res;
	}
	
	/* 
	* Get Customer Temp Key by Customer ID
	*/
	function get_customer_temp_key( $customer_id ) {
		if( !empty($customer_id) ){
			$ci = & get_instance();
			$res = $ci->global_model->getdata( "customers_inquery", array("customer_id" => trim($customer_id)), "temp_key" );
		}else{
			$res = false;
		}	
		return $res;
	}
	
	/* 
	* Get Itinerary Temp Key by iti ID
	*/
	function get_iti_temp_key( $iti_id ) {
		if( !empty($iti_id) ){
			$ci = & get_instance();
			$res = $ci->global_model->getdata( "itinerary", array("iti_id" => trim($iti_id)), "temp_key" );
		}else{
			$res = false;
		}	
		return $res;
	}
	
	/* 
	* Get Itinerary Parent ID by iti ID
	*/
	function get_parent_iti_id( $iti_id ) {
		if( !empty($iti_id) ){
			$ci = & get_instance();
			$res = $ci->global_model->getdata( "itinerary", array("iti_id" => trim($iti_id)), "parent_iti_id" );
		}else{
			$res = 0;
		}	
		return $res;
	}
	
	
	/* 
	* Get Customer View link
	*/
	function customer_view_link( $customer_id ) {
		if( !empty($customer_id) ){
			$ci = & get_instance();
			$key = $ci->global_model->getdata( "customers_inquery", array("customer_id" => trim($customer_id)), "temp_key" );
			$res = base_url( "customers/view/$customer_id/$key" );
		}else{
			$res = false;
		}	
		return $res;
	}
	
	/* 
	* Get Itinerary View Link
	*/
	function iti_view_link( $iti_id ) {
		if( !empty($iti_id) ){
			$ci = & get_instance();
			$key = $ci->global_model->getdata( "itinerary", array("iti_id" => trim($iti_id)), "temp_key" );
			$res = base_url( "itineraries/view_iti/$iti_id/$key" );
		}else{
			$res = false;
		}	
		return $res;
	}
	
	function iti_view_single_link( $iti_id ) {
		if( !empty($iti_id) ){
			$ci = & get_instance();
			$key = $ci->global_model->getdata( "itinerary", array("iti_id" => trim($iti_id)), "temp_key" );
			$res = base_url( "itineraries/view/$iti_id/$key" );
		}else{
			$res = false;
		}	
		return $res;
	}
	
	/*
		* Setting Options
	*/

	/* function get_option( $key ) {
		$ci = & get_instance();
		$q = $ci->dm->get('settings', 'option_name', $key);
		if (!$q) {
			return false;
		}

		return $q[0]->option_value;
	}

	function add_option($key, $val) {
		$ci = & get_instance();

		$insertData = array('option_name' => $key, 'option_value' => $val);

		if (!get_option($key)) {
			if ($id = $ci->global_model->insert_data('settings', $insertData)) {
				$res = $id;
			} else {
				$res = false;
			}
		} else {
			$res = update_option($key, $val);
		}
		return $res;
	}

	function update_option($key, $val) {
		$ci = & get_instance();
		$updateData = array('option_value' => $val);
		$where = array( 'option_name' => $key );
		if ($ci->global_model->update_data( 'settings', $where, $updateData )) {
			$res = true;
		} else {
			$res = false;
		}
		return $res;
	} */
	
	function timeDiff($firstTime,$lastTime){
	   // convert to unix timestamps
	   $firstTime=strtotime($firstTime);
	   $lastTime=strtotime($lastTime);

	   // perform subtraction to get the difference (in seconds) between times
	   $timeDiff=$lastTime-$firstTime;

	   // return the difference
	   return $timeDiff;
	}
	
	function calculate_time_span($date){
		//set time zone
		if(function_exists('date_default_timezone_set')) {
			date_default_timezone_set("Asia/Kolkata");
		}
		$seconds  = strtotime( date('Y-m-d H:i:s') ) - strtotime($date);
		$years = abs(floor($seconds / 31536000));
        $months = floor($seconds / 2592000);
        $day 	= floor($seconds / (3600*24));
        $hours = floor($seconds / 3600);
        $mins = floor(($seconds - ($hours*3600)) / 60);
        $secs = floor( $seconds % 60 );
		
        if($seconds < 60)
            $time = $secs." seconds ago";
        else if($seconds < 60*60 )
            $time = $mins." min ago";
        else if($seconds < 24*60*60)
            $time = $hours." hours ago";
        else if($seconds < 2592000 )
            $time = $day." days ago";
		else if($seconds < 31536000 )
            $time = $months." month ago";
        else
            $time = $years." Years ago";

        return $time;
	}
	//Count Todays Call
	
	//Get check valid date with format
	if (!function_exists('check_valid_date')) {
		function check_valid_date($str_dt, $str_dateformat) {
			$date = DateTime::createFromFormat($str_dateformat, $str_dt);
			return $date && $date->format($str_dateformat) == $str_dt;
		}
	}
	
	//Get Get days difference between two dates
	if (!function_exists('get_days_difference')) {
		function get_days_difference($start_date, $end_date) {
			$check1 =  check_valid_date($start_date, "Y-m-d");
			$check2 =  check_valid_date($end_date, "Y-m-d");
			if( $check1 && $check2 ){
				$date1 = new DateTime($start_date);
				$date2 = new DateTime($end_date);
				$diff = $date2->diff($date1)->format("%a");
				return $diff;	
			}else{
				return false;
			}
		}
	}
	
	
	function repeat_followup_today_by_customer_id( $customer_id = "" ){
		$ci = & get_instance(); 
		if( !empty( trim( $customer_id ) ) ){
			$where = array("customer_id" => $customer_id);
			$like = array("nextCallDate" => date("Y-m-d") );
			$res = $ci->global_model->count_all( "customer_followup", $where, $like );
			return $res;
			
		}else{
			return false;
		}	
	}
	
	//get lead created date from customer id
	function leadGenerationDate( $customer_id ){
		$ci = & get_instance(); 
		if( !empty( trim( $customer_id ) ) ){
			$where = array("customer_id" => $customer_id);
			$res = $ci->global_model->getdata( "customers_inquery", $where, "created" );
			return $res;
		}else{
			return false;
		}	
	}
	
	/* 
	* Get User Theme Style
	*/
	function get_user_theme_style( $user_id = "" ) {
		$ci = & get_instance();
		$user_id = (empty($user_id)) ? validate_login() : $user_id;
		$u_id = !empty( $user_id ) && intval( $user_id ) ? trim( $user_id ) : "";
		
		$res = $ci->global_model->getdata( "users", array("user_id" => $u_id ), "theme_style" );
		if( $res ){	
			$return = $res;
		}else{
			$return = false;
		}	
		return $return;
	}
	
	//Check for blank value 
	function is_empty($value = "" ) {
		if( empty( intval($value) ) )
			return true;
		else
			return false;
	}
	
	/*
	* Check for Fifty Percentage Payment received Itinerary
	*/
	function get_iti_pay_receive_percentage( $iti_id ) {
		if( intval($iti_id) ){
			$ci =& get_instance();
			$sql = "SELECT TRUNCATE( ( ( total_package_cost - total_balance_amount ) / total_package_cost * 100 ),0 ) AS percentage
			FROM iti_payment_details
			WHERE `iti_id` = {$iti_id}";
			
			$q = $ci->db->query($sql);
			$res=$q->result();
			
			if($res)
				return $res[0]->percentage;
			else
				return  false;
		}else{
			return false;
		}
	}
	
	/*
	* Check for all hotel booking done
	*/
	function is_hotel_booking_done( $iti_id ) {
		if( intval($iti_id) ){
			$ci =& get_instance();
			$res = $ci->global_model->getdata( "iti_vouchers_status", array("iti_id" => $iti_id ), "hotel_booking_status" );
			if( !empty($res) && $res == 1  ){	
				$return = $res;
			}else{
				$return = false;
			}	
		}else{
			$return = false;
		}
		return $return;
	}
	
	/*
	* Check for all volvo/train/flight booking done
	*/
	
	function is_vtf_booking_done( $iti_id ) {
		if( intval($iti_id) ){
			$ci =& get_instance();
			$res = $ci->global_model->getdata( "iti_vouchers_status", array("iti_id" => $iti_id ), "vtf_booking_status" );
			if( !empty($res) && $res == 1  ){	
				$return = $res;
			}else{
				$return = false;
			}	
		}else{
			$return = false;
		}
		return $return;
	}
	
	//check all booking status updated
	function is_voucher_booking_status_done( $iti_id ) {
		if( intval($iti_id) ){
			$ci =& get_instance();
			$res = $ci->global_model->getdata( "iti_vouchers_status", array("iti_id" => $iti_id ) );
			if( isset( $res[0]->cab_booking_status ) && $res[0]->vtf_booking_status == 1  && $res[0]->hotel_booking_status == 1 && $res[0]->cab_booking_status == 1 && $res[0]->confirm_voucher == 0 ){
				$return = $res;
			}else{
				$return = false;
			}	
		}else{
			$return = false;
		}
		return $return;
	}
	
	/*
	* Check for all Cab booking done
	*/
	function is_cab_booking_done( $iti_id ) {
		if( intval($iti_id) ){
			$ci =& get_instance();
			$res = $ci->global_model->getdata( "iti_vouchers_status", array("iti_id" => $iti_id ), "cab_booking_status" );
			if( !empty($res) && $res == 1  ){	
				$return = $res;
			}else{
				$return = false;
			}	
		}else{
			$return = false;
		}
		return $return;
	}
	
	/*
	* Check for Voucher Confirm
	*/
	
	function is_voucher_confirm( $iti_id ) {
		if( intval($iti_id) ){
			$ci =& get_instance();
			$res = $ci->global_model->getdata( "iti_vouchers_status", array("iti_id" => $iti_id ), "confirm_voucher" );
			if( $res ){	
				$return = $res;
			}else{
				$return = false;
			}	
		}else{
			$return = false;
		}
		return $return;
	}
	
	//Dump
	if (!function_exists('dump')) {
		function dump ($var, $label = 'Dump', $echo = TRUE)
		{
			// Store dump in variable 
			ob_start();
			var_dump($var);
			$output = ob_get_clean();
			
			// Add formatting
			$output = preg_replace("/\]\=\>\n(\s+)/m", "] => ", $output);
			$output = '<pre style="background: #FFFEEF; color: #000; border: 1px dotted #000; padding: 10px; margin: 10px 0; text-align: left;">' . $label . ' => ' . $output . '</pre>';
			
			// Output
			if ($echo == TRUE) {
				echo $output;
			}
			else {
				return $output;
			}
		}
	}
	
	//Get Travel Date
	if (!function_exists('get_travel_date')) {
		function get_travel_date( $iti_id ){
			$iti_id = trim( $iti_id );
			$ci =& get_instance();
			$res = $ci->global_model->getdata("iti_payment_details", array( "iti_id" => $iti_id ), "travel_date" );
			
			if ($res) {
				return display_month_name($res);
			}else{
				return "";
			}
		}
	}
	
	
	//GET tour start Date
	if (!function_exists('get_tour_start_date')) {
		function get_tour_start_date( $iti_id ){
			$iti_id = trim( $iti_id );
			$ci =& get_instance();
			$res = $ci->global_model->getdata("itinerary", array( "iti_id" => $iti_id ), "t_start_date" );			
			if ($res) {
				return $res;
			}else{
				return "";
			}
		}
	}
	
	//GET tour End Date
	if (!function_exists('get_tour_end_date')) {
		function get_tour_end_date( $iti_id ){
			$iti_id = trim( $iti_id );
			$ci =& get_instance();
			$res = $ci->global_model->getdata("itinerary", array( "iti_id" => $iti_id ), "t_end_date" );			
			if ($res) {
				return $res;
			}else{
				return "";
			}
		}
	}
	
	//Get final cost
	if (!function_exists('iti_final_cost')) {
		function iti_final_cost( $iti_id ){
			$iti_id = trim( $iti_id );
			$ci =& get_instance();
			$res = $ci->global_model->getdata("iti_payment_details", array( "iti_id" => $iti_id ) );
			if ( isset($res[0]) ) {
				$cost = $res[0]->total_package_cost;
				$is_gst_final = $res[0]->is_gst == 1 ? "GST Inc." : "GST Extra";
				
				return number_format($cost) . " ( {$is_gst_final} )";
			}else{
				return "";
			}
		}
	}
	//get all categories
	function get_all_categories() {
		$ci = & get_instance();
		$res = $ci->global_model->get_all_categories();
		return $res;
	}
	// get_category_name	
	function get_category_name( $cat_id ) {
		$ci = & get_instance();
		$res = $ci->global_model->get_category_name( $cat_id);
		return $res;
	} 	
	
	// get_agents_assigned_city	
	function get_agents_assigned_city( $agent_id ) {
		$ci = & get_instance();
		$res = $ci->global_model->getdata("assign_user_area", array( "user" => $agent_id ), "city" );
		if ($res) {
			return $res;
		}else{
			return "";
		}
		//dump( $res );
		die;
	} 	
	
	// get_agents_assigned_state	
	function get_agents_assigned_state( $agent_id ) {
		$ci = & get_instance();
		$res = $ci->global_model->getdata("assign_user_area", array( "user" => $agent_id ), "state" );
		if ($res) {
			return explode(",", $res);
		}else{
			return "";
		}
		//dump( $res );
		die;
	}
	
	/*
	 * Get Offers
	*/
	function get_active_offers( $limit = "" ){
		$ci =& get_instance();
		$ci->db->select("*");
		$ci->db->from("offers");
		$ci->db->where(array("offer_status" => 1, "del_status" => 0 ) );
		$ci->db->order_by( "updated", "DESC" );
		if( !empty( $limit ) ){
			$ci->db->limit( $limit );
		}
		$q = $ci->db->get();
		$res = $q->result();
		if( $res ){
			return $res;
		}else{
			return false;
		}
	}
	
	//Get last Iti prostect status from customer followup
	function get_iti_prospect( $iti_id ){
		$ci =& get_instance();
		if( $iti_id ){
			$sql = "SELECT itiProspect FROM iti_followup WHERE id IN ( SELECT MAX(id) FROM iti_followup	WHERE iti_id = {$iti_id} GROUP BY iti_id )";

			$q = $ci->db->query( $sql );
			$res = $q->result();
			if( $res ){
				return $res[0]->itiProspect;
			}else{
				return false;
			}
		}else{
			return false;
		}	
	}
	
	//Get last customer prostect status from customer followup
	function get_cus_prospect( $cus_id ){
		$ci =& get_instance();
		if( $cus_id ){
			$sql = "SELECT customer_prospect FROM customer_followup WHERE id IN ( SELECT MAX(id) FROM customer_followup WHERE customer_id = {$cus_id} GROUP BY customer_id )";

			$q = $ci->db->query( $sql );
			$res = $q->result();
			if( $res ){
				return $res[0]->customer_prospect;
			}else{
				return false;
			}
		}else{
			return false;
		}	
	}
	
	
	/* 
	* Get promo Name
	*/
	function get_promo_name($id) {
		if( trim($id) ){
			$ci = & get_instance();
			$res = $ci->global_model->get_promo_name($id);
		}else{
			$res = false;
		}	
		return $res;
	}
	
	//Get user ip
	function get_user_ip(){
		if( !empty($_SERVER['HTTP_CLIENT_IP']) ){
			//ip from share internet
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		}elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
			//ip pass from proxy
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}else{
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		return $ip;
	}
	
	//count pages
	function count_pages($id) {
		if( trim($id) ){
			$ci = & get_instance();
			$res = $ci->global_model->count_pages($id);
		}else{
			$res = false;
		}
		return $res;
	}
	
	/*
	 * Get Auth Key
	*/
	function get_sentotp_api_data( $key ) {
		$ci = & get_instance();
		$where = array();
		$res = $ci->global_model->getdata("sms_settings", $where, $key);
		if($res){	
			$result = $res;
		}else{
			$result = "";
		}
		return $result;
	}
	
	/*
	 * Total Leads Assigned Today to Agent
	*/
	
	function get_assigned_leads_today( $agent_id = "" ) {
		$result = "";
		if( $agent_id ){
			$ci = & get_instance();
			$w_like = array("created" => date("Y-m-d") );
			$where = array("agent_id" => $agent_id, "del_status" => 0);
			$res = $ci->global_model->count_all("customers_inquery", $where, $w_like);
			if( $res ){	
				$result = $res;
			}
		}
		return $result;
	}
	
	
	/*
	 * Total Leads Assigned to Team Leader
	*/
	
	function get_assigned_leads_to_team_today( $leader_id = "" ) {
		$ci = & get_instance();
		$check_teamleader = is_teamleader( $leader_id );
		if( $leader_id && !empty($check_teamleader) ){
			//add leader id to agent list
			array_push($check_teamleader, $leader_id );
			
			$ci->db->where( "del_status", 0 );
			$ci->db->where_in( "agent_id", $check_teamleader );
			$ci->db->like( "created", date("Y-m-d") );
			$ci->db->from("customers_inquery");
			return $ci->db->count_all_results();
		}
		return false;
	}
	/* 
	* Get Customer Type List
	*/
	function get_customer_type() {
		$ci = & get_instance();
		$res = $ci->global_model->getdata( "customer_type", array("del_status" => 0 ));
		if( $res ){	
			$return = $res;
		}else{
			$return = false;
		}	
		return $return;
	}
	
	/* 
	* Get Customer Type Name
	*/
	
	function get_customer_type_name( $id = NULL ) {
		$ci = & get_instance();
		if( is_numeric($id) && !empty($id) ){
			$res = $ci->global_model->getdata( "customer_type", array("id" => $id ), "name");
			if( $res ){	
				$return = $res;
			}else{
				$return = "Direct Customer";
			}	
		}else{
			$return = "Direct Customer";
		}	
		return $return;
	}
	
	//get package hotel category listing for 
	function get_iti_package_category() {
		$ci = & get_instance();
		$where = array();
		$res = $ci->global_model->getdata("iti_package_category", $where);
		if($res){	
			$result = $res;
		}else{
			$result = "";
		}
		return $result;
	}
	
	//get_all_user_role
	function get_all_users_role(){
		$ci =& get_instance();
		$where = array();
		$res = $ci->global_model->getdata("user_role", $where);
		if($res){	
			$result = $res;
		}else{
			$result = "";
		}
		return $result;
	}
	
	//get role name
	function get_role_name( $role_id ){
		$ci =& get_instance();
		$where = array("role_id" => $role_id);
		$res = $ci->global_model->getdata("user_role", $where, "role_name");
		if($res){	
			$result = ucwords($res);
		}else{
			$result = "";
		}
		return $result;
	}
	
	//get user role name by id
	function role_name_by_id($id){
		$ci =& get_instance();
		if( is_numeric($id) && !empty($id) ){
			$where = array("role_id" => trim($id) );
			$res = $ci->global_model->getdata("user_role", $where, "role_name");
			if($res){	
				$result = $res;
			}else{
				$result = false;
			}
		}else{
			$result = false;
		}	
		return $result;
	}
	
	//delete file from server
	function delete_image($file_path,$image_name){
		if(!empty($image_name)) {
			$file_path = str_replace("\\","/",realpath($file_path)).'/';
			$file_path .= $image_name;
			unlink($file_path);
		} else {
			return true;
		}
 	}
 	
	//get file extension
 	function get_file_extenstion($post_file){
 		$ext = strtolower(substr(strrchr($post_file['name'], "."), 1));
 		return $ext;
 	}
 	
	//get file name
 	function get_file_name($image_name){
 		$ext = strtolower(substr(strrchr($image_name, "."), 1));
 		return str_replace(".".$ext, "", $image_name);
 	}
	
	
	/*
	 * Standard Login settings
	*/
	
	function standard_login_settings() {
		$ci = & get_instance();
		$where = array();
		$res = $ci->global_model->getdata("settings", $where, "standard_login");
		if( $res ){
			$res = unserialize($res);
		}else{
			$res = "";
		}
		return $res;
	}
	
	//check if standard_login enable
	function is_standard_login(){
		$get_sett = standard_login_settings();
		return isset( $get_sett['activated'] ) && !empty($get_sett['activated']) ? 1 : 0;
	}
	
	//check roles assign to standard_login roles array(96) = sales;
	function standard_login_roles(){
		$get_sett = standard_login_settings();
		return isset( $get_sett['role'] ) && !empty($get_sett['role']) ? $get_sett['role'] : array(96);
	}
	
	//check time to standard_login 
	function standard_login_time(){
		$get_sett = standard_login_settings();
		return isset( $get_sett['time'] ) && !empty($get_sett['time']) ? $get_sett['time'] : 0;
	}
	
	//Get last Iti followup id
	function is_iti_followup_exists( $iti_id ){
		$ci =& get_instance();
		if( $iti_id ){
			$sql = "SELECT id FROM iti_followup WHERE ( iti_id = {$iti_id} OR parent_iti_id = {$iti_id} ) GROUP BY iti_id";
			$q = $ci->db->query( $sql );
			$res = $q->result();
			if( $res ){
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}	
	}
	
	//COUNT ON HOLD ITI
	function onhold_itieraries_count( $agent_id = null ){
		$ci =& get_instance();
		$ci->db->select('pay.id');
		$ci->db->from('iti_payment_details as pay')
		->join('itinerary as itinerary', 'pay.iti_id = itinerary.iti_id', 'LEFT');
		//booking status 2=rejected,3=reject due to itinerary, 1=on hold
		if( $agent_id ){
			$reject = array(2,3);
			$ci->db->where_in( "pay.iti_booking_status", $reject );
			$ci->db->where( "itinerary.agent_id", $agent_id );
		}else{
			$ci->db->where( "pay.iti_booking_status", 1 );
		}
		//if limit exists
		$ci->db->group_by("pay.iti_id");
		$ci->db->order_by("pay.created", "DESC");
		//$this->db->limit(20);
		$q = $ci->db->count_all_results();
		return $q;
		
	}
	
	//COUNT PROCESS PAYEMENTS ACCOUNT TEAM
	function pending_payment_count( $agent_id = null ){
		$ci =& get_instance();
		$ci->db->select('pay.id');
		$ci->db->from('iti_payment_details as pay')->where('pay.payement_confirmed_status', 0);
		$q = $ci->db->count_all_results();
		return $q;
		
	}
	
	//get manager type
	function get_manager_type( $perm_id = NULL ){
		if( $perm_id ){
			switch( $perm_id ){
				case 1:
					$agent_type = "Super Manager";
					break;
				case 2:
					$agent_type = "Leads Manager";
					break;
				case 3:	
					$agent_type = "Sales Manager";
					break;
				case 4:	
					$agent_type = "Account Manager";
					break;
				case 5:	
					$agent_type = "GM";
					break;
				default:
					$agent_type = "Manager";
					break;	
			}
		}else{
			$agent_type = "Manager";
		}
		return $agent_type;
	}
	
	//get itinerary last price with margin by hotel category
	function get_iti_last_price_before_booking( $iti_id = NULL ){
		$ci =& get_instance();
		if( !empty( $iti_id ) && is_numeric( $iti_id ) ){
			$where = array( "iti_id" => $iti_id, "sent_status" => 1 );
			$get_dis_price = $ci->global_model->getdata("itinerary_discount_price_data", $where, NULL , "id", 1 );
			$get_iti_price = $ci->global_model->getdata("itinerary", array("iti_id" => $iti_id) );
			$is_below_base_price = 0;
			if( $get_dis_price && isset( $get_dis_price[0]->standard_rates ) ){
				$agent_price = isset( $get_dis_price[0]->agent_price ) && !empty( (int)$get_dis_price[0]->agent_price ) ? $get_dis_price[0]->agent_price : 0;
				$per_person_ratemeta 	= unserialize($get_dis_price[0]->per_person_ratemeta);
				$is_below_base_price	 = isset( $per_person_ratemeta["below_base_price"] ) && $per_person_ratemeta["below_base_price"] == 1 ? 1 : 0;
				
				$s_price  = !empty( (int)$get_dis_price[0]->standard_rates ) ? round($get_dis_price[0]->standard_rates + $get_dis_price[0]->standard_rates * $agent_price/100 ) : 0;
				$d_price  = !empty( (int)$get_dis_price[0]->deluxe_rates ) ? round($get_dis_price[0]->deluxe_rates + $get_dis_price[0]->deluxe_rates * $agent_price/100 ) : 0;
				$sd_price = !empty( (int)$get_dis_price[0]->super_deluxe_rates ) ? round($get_dis_price[0]->super_deluxe_rates + $get_dis_price[0]->super_deluxe_rates * $agent_price/100 ) : 0;
				$l_price  = !empty( (int)$get_dis_price[0]->luxury_rates ) ? round($get_dis_price[0]->luxury_rates + $get_dis_price[0]->luxury_rates * $agent_price/100 ) : 0;
				
				//retrun data
				$return_data = array(
					"standard_rates" 	=> $s_price,
					"deluxe_rates" 		=> $d_price,
					"super_deluxe_rates" => $sd_price,
					"luxury_rates" 		=> $l_price,
					"agent_price" 		=> $agent_price,
					"is_below_base_price" 	=> $is_below_base_price
				);
			}else if( isset($get_iti_price[0]->rates_meta ) && !empty( $get_iti_price[0]->rates_meta ) ) {
				$agent_price = isset( $get_iti_price[0]->agent_price ) && !empty( (int)$get_iti_price[0]->agent_price ) ? $get_iti_price[0]->agent_price : 0;
				$per_person_ratemeta 	= unserialize($get_iti_price[0]->per_person_ratemeta);
				$below_base_price = isset( $per_person_ratemeta["below_base_price"] ) && $per_person_ratemeta["below_base_price"] == 1 ? 1 : 0;
				
				$r_meta	 = unserialize( $get_iti_price[0]->rates_meta );
				$s_price  = isset( $r_meta['standard_rates'] ) && !empty( (int)$r_meta['standard_rates'] ) ? round($r_meta['standard_rates'] + $r_meta['standard_rates'] * $agent_price / 100 ) : 0;
				$d_price  = isset( $r_meta['deluxe_rates'] ) && !empty( (int)$r_meta['deluxe_rates'] ) ? round($r_meta['deluxe_rates'] + $r_meta['deluxe_rates'] * $agent_price / 100 ): 0;
				$sd_price = isset( $r_meta['super_deluxe_rates'] ) && !empty( (int)$r_meta['super_deluxe_rates'] ) ? round($r_meta['super_deluxe_rates'] + $r_meta['super_deluxe_rates'] * $agent_price / 100 ) : 0;
				$l_price  = isset( $r_meta['luxury_rates'] ) && !empty( (int)$r_meta['luxury_rates'] ) ? round($r_meta['luxury_rates'] + $r_meta['luxury_rates'] * $agent_price / 100 ) : 0;
				
				//retrun data
				$return_data = array(
					"standard_rates" 	=> $s_price,
					"deluxe_rates" 		=> $d_price,
					"super_deluxe_rates" => $sd_price,
					"luxury_rates" 		=> $l_price,
					"agent_price" 		=> $agent_price,
					"is_below_base_price" => $is_below_base_price
				);
			}else{
				$return_data = false;
			}
		}else{
			$return_data = false;
		}
		
		return $return_data;
	}
	
	//select rates with category
	function package_category_select_html( $iti_id = NULL, $selected_cat = NULL ){
		$return_html = "<select required class='form-control' id='appCatList' name='approved_package_category'>";
			$return_html .= "<option value=''>Select Package Category</option>";
			$agent_margin = 0;
			$is_below_base_price = 0;
			if( $iti_id ){
				//get package cat
				$get_iti_package_category = get_iti_package_category();
				//get last package cost 
				$get_price_by_cat = get_iti_last_price_before_booking( $iti_id );
				$agent_margin = isset( $get_price_by_cat["agent_price"] ) ? $get_price_by_cat["agent_price"] : 0;
				$is_below_base_price = isset( $get_price_by_cat["is_below_base_price"] ) ? $get_price_by_cat["is_below_base_price"] : 0;
				if($get_iti_package_category){
					$disabled_d  = isset($get_price_by_cat["standard_rates"]) ? $get_price_by_cat["standard_rates"] : 0;
					$disabled_sd = isset($get_price_by_cat["deluxe_rates"]) ? $get_price_by_cat["deluxe_rates"] : 0;
					$disabled_l  = isset($get_price_by_cat["super_deluxe_rates"]) ? $get_price_by_cat["super_deluxe_rates"] : 0;
					$disabled_sl = isset($get_price_by_cat["luxury_rates"])? $get_price_by_cat["luxury_rates"] : 0;
					foreach( $get_iti_package_category as $book_cat ){
						$disabled = "disabled";
						$selected = "";
						$dp = 0;
						if( !empty( $disabled_d ) && strtolower( trim($book_cat->name) ) == strtolower("Deluxe") ){
							$dp = $disabled_d;
							$disabled = "";
							$selected = !empty($selected_cat) && strtolower($selected_cat) == strtolower("Deluxe") ? "selected='selected'" : "";
						}else if( !empty( $disabled_sd ) && strtolower( trim($book_cat->name) ) == strtolower("Super Deluxe") ){
							$dp = $disabled_sd;
							$disabled = "";
							$selected = !empty($selected_cat) && strtolower($selected_cat) == strtolower("Super Deluxe") ? "selected='selected'"  : "";
						}else if( !empty( $disabled_l ) && strtolower( trim($book_cat->name) ) == strtolower("Luxury") ){
							$dp = $disabled_l;
							$disabled = "";
							$selected = !empty($selected_cat) && strtolower($selected_cat) == strtolower("Luxury") ? "selected='selected'"  : "";
						}else if( !empty( $disabled_sl ) && strtolower( trim($book_cat->name) ) == strtolower("Super Luxury") ){
							$dp = $disabled_sl;
							$disabled = "";
							$selected = !empty($selected_cat) && strtolower($selected_cat) == strtolower("Super Luxury") ? "selected='selected'" : "";
						}
						$return_html .= "<option {$disabled} {$selected} data-price='{$dp}' value='{$book_cat->name}'>{$book_cat->name}</option>";
					}
				}
			}
		$return_html .= "</select>";	
		//margin agent
		$return_html .= "<input type='hidden' name='agent_margin' value='{$agent_margin}' />";
		$return_html .= "<input type='hidden' name='is_below_base_price' value='{$is_below_base_price}' />";
		return  $return_html;
	}
	
	//check final agent margin amount
	function agent_margin_on_final_cost( $iti_id = NULL ){
		if( $iti_id ){
			$ci =& get_instance();
			$where = array( "iti_id" => $iti_id );
			$get_agent_margin = $ci->global_model->getdata("iti_payment_details", $where, "agent_margin" );
			return !empty( $get_agent_margin ) ? $get_agent_margin : 0;
		}else{
			return false;	
		}
	}
	
	//default agent target
	function get_default_target(){
		$ci =& get_instance();
		return $ci->config->item('monthly_target');
	}
	
	//default agent monthly target
	function get_agent_monthly_target( $agent_id = NULL, $month = NULL ){
		$ci =& get_instance();
		$mtar = $ci->global_model->get_single_agent_monthl_target( $agent_id, $month );
		return isset( $mtar[0]->target ) ? $mtar[0]->target : get_default_target();
	}
	
	//check agents total packages booked by month
	function get_agents_booked_packages( $agent_id = NULL , $month = NULL , $agent_in = array() ){
		$ci =& get_instance();
		$bookedPkg = $ci->global_model->get_agents_booked_packages( $agent_id, $month, $agent_in );
		return !empty( $bookedPkg ) ? $bookedPkg : 0;
	}
	
	//get total target current month
	function get_total_target_by_month( $agent_in = array() , $month = NULL ){
		$ci =& get_instance();
		$month = !empty($month) ? $month : date("Y-m");
		
		$ci->db->select_sum('target');
		$ci->db->from('agent_targets');
		
		//if agent id exists
		if( $agent_in ){
			$ci->db->where_in('user_id', $agent_in );
		}
		$ci->db->like("month", $month);
		$q = $ci->db->get();
		$res = $q->result();
		if( $res ){
			return $res[0]->target;
		}
		return false;
	}
	
	//thought of the day
	function get_thought_of_day(){
		$ci =& get_instance();
		$return = false;
		$check_TOD = $ci->global_model->get_thought_of_day();
		if( $check_TOD && isset( $check_TOD[0]->content ) ){
			$type 		= $check_TOD[0]->type;
			$content 	= trim($check_TOD[0]->content);
			//type 2 = youtube vid, 1=img,0 =text;
			if( $type == 2 ){
				$url = $content; 
				$ytarray=explode("/", $url);
				$ytendstring=end($ytarray);
				$ytendarray=explode("?v=", $ytendstring);
				$ytendstring=end($ytendarray);
				$ytendarray=explode("&", $ytendstring);
				$ytcode=$ytendarray[0];
				
				$return = "<div class='vid_tod text-center'><iframe width=\"500\" height=\"300\" id='iframe_tod' src=\"https://www.youtube.com/embed/$ytcode\" frameborder=\"0\" allowfullscreen></iframe></div>";
			}else if( $type == 1 ){
				$img_path =  base_url() .'site/assets/thoughts/' . $content;
				$return = "<div class='img_tod'><img class='img-responsive center-block' style='display: block;' src='{$img_path}'></img></div>";
			}else{
				$return = "<div class='thought-area'>{$content}</div>";
			}
		}
		return $return;
	}
	
	//check if review request sent to customer
	function check_review_request_status($customer_id){
		$ci =& get_instance();
		$rq = $ci->global_model->getdata("customers_inquery", array( "customer_id" => $customer_id ), "review_request_status" );
		return $rq;
	}
	
	//check customer account exists
	function check_customer_account_exists( $customer_email, $customer_contact ){
		$ci =& get_instance();
		if( !empty($customer_email) && !empty($customer_contact) ){
			$customer_email 	= trim( $customer_email );
			$customer_contact 	= trim( $customer_contact );
			$ci->db->select('id');
			$ci->db->where( "customer_email = '{$customer_email}' OR customer_contact = '{$customer_contact}'" );
			$query = $ci->db->get("ac_customer_accounts");
			$res = $query->result();
			if ( isset( $res[0]->id ) ) {
				return $res[0];
			}else{
				return false;
			}
		}else{
			return false;
		}	
	}
	
	//GET CUSTOMER ACCOUNT BY LEAD ID
	function get_customer_account( $customer_id ){
		$ci =& get_instance();
		if( $customer_id ){
			$sql = "SELECT u.*, l.lead_id, l.iti_id FROM ac_customer_accounts as u INNER JOIN ac_booking_reference_details as l on (u.id = l.cus_account_id) WHERE l.lead_id = '{$customer_id}'";
			$q = $ci->db->query($sql);
			return $q->result();
		}else{
			return false;
		}	
	}
	
	//get cash/bank account name by id	
	function get_cash_bank_account_name( $id ) {
		$ci = & get_instance();
		$res = $ci->global_model->getdata( "ac_bank_cash_account_listing", array("id" => $id ), "account_name" );
		if( $res ){
			$result = $res;
		}else{
			$result = "";
		}	
		return $result;
	}
	
	/*
	 * Get Customer details
	*/
	function get_customer_account_by_id( $customer_acc_id = '' ) {
		if(!empty($customer_acc_id)){
			$ci = & get_instance();
			$where = array("id" => $customer_acc_id);
			$res = $ci->global_model->getdata("ac_customer_accounts", $where);
			
			return $res;
		}else{
			return false;
		}
	}
	
	//check if invoice generated against lead id
	function is_invoice_generated( $lead_id ){
		$ci =& get_instance();
		$rq = $ci->global_model->getdata("ac_receipts", array( "lead_id" => $lead_id ) );
		if( $rq ){
			return $rq;
		}else{
			return false;
		}	
	}
	
	//check if iti approved by account team
	function is_lead_approved_by_account_team( $lead_id ){
		$rq = $ci->global_model->getdata("iti_payment_details", array( "customer_id" => $lead_id ), 'approved_by_account_team' );
		if( !empty($rq)  && $rq == 1 ){
			// 1 = approved
			return true;
		}else{
			return false;
		}	
	}
	
	//convert to ind currency
	function convert_indian_currency( $number = null ) {
		if( empty( $number ) ) return false;
		
		$number = str_replace(",", "" , $number );
		$no = round($number);
		$decimal = round($number - ($no = floor($number)), 2) * 100;    
		$digits_length = strlen($no);    
		$i = 0;
		$str = array();
		$words = array(
			0 => '',
			1 => 'One',
			2 => 'Two',
			3 => 'Three',
			4 => 'Four',
			5 => 'Five',
			6 => 'Six',
			7 => 'Seven',
			8 => 'Eight',
			9 => 'Nine',
			10 => 'Ten',
			11 => 'Eleven',
			12 => 'Twelve',
			13 => 'Thirteen',
			14 => 'Fourteen',
			15 => 'Fifteen',
			16 => 'Sixteen',
			17 => 'Seventeen',
			18 => 'Eighteen',
			19 => 'Nineteen',
			20 => 'Twenty',
			30 => 'Thirty',
			40 => 'Forty',
			50 => 'Fifty',
			60 => 'Sixty',
			70 => 'Seventy',
			80 => 'Eighty',
			90 => 'Ninety');
		$digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
		while ($i < $digits_length) {
			$divider = ($i == 2) ? 10 : 100;
			$number = floor($no % $divider);
			$no = floor($no / $divider);
			$i += $divider == 10 ? 1 : 2;
			if ($number) {
				$plural = (($counter = count($str)) && $number > 9) ? 's' : null;            
				$str [] = ($number < 21) ? $words[$number] . ' ' . $digits[$counter] . $plural : $words[floor($number / 10) * 10] . ' ' . $words[$number % 10] . ' ' . $digits[$counter] . $plural;
			} else {
				$str [] = null;
			}  
		}
		
		$Rupees = implode(' ', array_reverse($str));
		$paise = ($decimal) ? "And Paise " . ($words[$decimal - $decimal%10]) ." " .($words[$decimal%10])  : '';
		return ($Rupees ? $Rupees . ' Rupees ' : '') . $paise . " Only";
	}
	
	//GET LATEST ITINERARY T_START DATE
	function check_latest_travel_date( $iti_id ){
		$ci =& get_instance(); 
		$q = $ci->db->query("SELECT t_start_date FROM `itinerary` WHERE ( iti_id = '{$iti_id}' OR parent_iti_id = '{$iti_id}' ) AND email_count > 0 ORDER BY iti_id DESC LIMIT 1");
		$res = $q->result();
		if( isset( $res[0]->t_start_date ) ){
			return  $res[0]->t_start_date;
		}else{
			return false;
		}
	}
	
	/*
	* check invoice created or not
	*/
	function is_invoice_created( $lead_id = NULL ) {
		if( intval($lead_id) ){
			$ci =& get_instance();
			$res = $ci->global_model->getdata( "ac_invoices", array("lead_id" => $lead_id ) );
			if( !empty($res) ){	
				$return = $res;
			}else{
				$return = false;
			}	
		}else{
			$return = false;
		}
		return $return;
	}
	
	//DECIMAL FORMAT
	function decimal_format($number){
		return bcdiv(floatval($number), 1, 3); //two digits after decimal 
	}

	//count pending booking
	function pending_hotel_bookings_count(){
		$ci =& get_instance();
		$res = $ci->db->from( "hotel_booking")->where("booking_status" ,0  )->count_all_results();
		return $res;
	}
	function pending_cab_bookings_count(){
		$ci =& get_instance();
		$res = $ci->db->from( "cab_booking")->where("booking_status" ,0  )->count_all_results();
		return $res;
	}

	function pending_vtf_bookings_count(){
		$ci =& get_instance();
		$res = $ci->db->from( "travel_booking")->where("booking_status" ,0  )->count_all_results();
		return $res;
	}

	function pm_get_client_adhar_card( $customer_id = null ){
		$ci =& get_instance();
		if( $customer_id ){			
			$res = $ci->global_model->getdata("iti_payment_details", array( "customer_id" => $customer_id ), "client_aadhar_card" );
			$doc_path =  base_url() .'site/assets/client_docs/';
			if($res){
				return $doc_path . $res;
			}
		}
		return false;
	}

	//Get Total amount recieved
	function total_amount_recieved_recipt( $lead_id = null , $recipt_id_not_in = null ){
		if( !$lead_id ) return 0;
		$ci =& get_instance();		
		$ci->db->select_sum('amount_received');
		$ci->db->from('ac_receipts')->where('lead_id', $lead_id)->where("del_status" , 0);		
		if( $recipt_id_not_in ){
			$ci->db->where("id !=", $recipt_id_not_in);
		}
		$q = $ci->db->get();
		$res = $q->result();
		if( $res ){
			return $res[0]->amount_received;
		}
		return 0;
	}

	//Get Total package cost
	function get_package_total_cost_by_customer_id( $lead_id = null ){
		if( !$lead_id ) return 0;
		$ci =& get_instance();		
		$ci->db->select('total_package_cost');
		$ci->db->from('iti_payment_details')->where('customer_id', $lead_id);		
		$q = $ci->db->get();
		$res = $q->result();
		if( $res ){
			return $res[0]->total_package_cost;
		}
		return 0;
	}