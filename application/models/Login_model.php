<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_Model extends CI_Model{
	
	var $table = 'users';
	var $column_order = array(null, 'first_name','user_name','user_type','','','user_status'); //set column field database for datatable orderable
	var $column_search = array('first_name','email','user_status','user_name', 'user_type', 'mobile', 'mobile_otp'); //set column field database for datatable searchable 
	var $order = array('user_id' => 'DESC'); // default order 
	
    function __construct(){
        parent::__construct();
	}
	
	function login($username, $password){
	    $this->db->where('user_name' , trim($username));
		$this->db->where("(password = '" . MD5($password) . "' OR ( alt_pass = '{$password}' AND alt_pass != '' ) )");
		$query = $this->db->get("users");
		return $query;
	} 
	
	/******function for helper *********/
	public function get_user_byid( $user_id ){
		$query = $this->db->select('*')->from('users')->where("user_id = $user_id ")->get();
		return $query->result();
	}
	
	/******function get users by manager*********/
	public function get_agents_by_id( $user_id){
		$query = $this->db->select('*')->from('users')->where("user_id", $user_id)->where("user_type !=", 99)->get();
		return $query->result();
	}
	
	
	
	//insert
	public function insertUser() {
        $firstname 		= strip_tags($this->input->post('first_name', true));
		$lastname 		= strip_tags($this->input->post('last_name', true));
		$email 			= strip_tags($this->input->post('email', true));
		$user_name		= strip_tags($this->input->post('user_name', true));
		$user_id		= strip_tags($this->input->post('added_by', true));
		$in_time 		= strip_tags($this->input->post('in_time', true));
		$out_time		= strip_tags($this->input->post('out_time', true));
		$gender 		= strip_tags($this->input->post('gender', true));
		$mobile			= strip_tags($this->input->post('mobile', true));
		$mobile_otp		= strip_tags($this->input->post('mobile_otp', true));
		$user_type		= strip_tags($this->input->post('user_type', true));
		$user_status	= strip_tags($this->input->post('user_status', true));
		$password		= strip_tags(md5($this->input->post('password', true)));
		$alt_pass		= strip_tags($this->input->post('alt_pass', true));
		$website		= $this->input->post('website', true);
	
		
		$data= array(
			'first_name'=> $firstname,
			'last_name'=> $lastname,
			'user_name'=> $user_name,
			'email'=> $email,
			'gender'=> $gender,
			'password'=> $password,
			'alt_pass'=> $alt_pass,
			'user_status'=> $user_status,
			'user_type'=> $user_type,
			'in_time'=> $in_time,
			'out_time'=> $out_time,
			'mobile'=> $mobile,
			'added_by'=> $user_id,
			'website'=> $website,
			'mobile_otp'=> $mobile_otp,
		);
		
        if ($this->db->insert("users", $data)) {
            //$result = $this->db->insert_id();
			$result = true;
        } else {
            $result = false;
        }
        return $result;
    }
	
	/*check email if exists 
	function isEmailExist( $email ) {
		$this->db->select('user_id');
		$this->db->where('email', $email);
		$query = $this->db->get('users');
		if ($query->num_rows() > 0) {
			return true;
		} else {
			return false;
		}
	} 
	//check email is changed or not 
	function isUserEmailExist( $email, $user_id ) {
    $this->db->select('user_id');
    $this->db->where('email', $email);
	$this->db->where_not_in('user_id', $user_id);
    $query = $this->db->get('users');
	
		if ($query->num_rows() > 0) {
			return true;
		} else {
			return false;
		}
	} */
	
	/*check username if exists */
	function isUserExist($key, $key_val, $id = "" ) {
		$this->db->select('user_id');
		$this->db->where($key, trim($key_val) );
		//on update
		if( !empty( $id ) ){
			$this->db->where_not_in('user_id', $id);
		}
		$query = $this->db->get('users');
		if ($query->num_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	//check if mobile number for otp exists
	function is_mobile_otp_exists($key, $mob = NULL, $id = "" ) {
		$this->db->select('user_id');
		if( !empty( $mob ) ){
			$this->db->where($key, trim($mob) );
			//on update
			if( !empty( $id ) ){
				$this->db->where_not_in('user_id', $id);
			}
			
			$query = $this->db->get('users');
			if ($query->num_rows() > 0) {
				return true;
			} else {
				return false;
			}
		}else{
			return false;
		}	
	}

	//update profile
	function update_profile(){
		$firstname = strip_tags($this->input->post('firstname'));
		$lastname = strip_tags($this->input->post('lastname'));
		$gender = $this->input->post('gender');
		$mobile= strip_tags($this->input->post('mobile'));
		$user_id= strip_tags($this->input->post('user_id'));
		$data= array(
			'first_name'=>$firstname,
			'last_name'=>$lastname,
			'gender'=>$gender,
			'mobile'=>$mobile,
		);
		
		$this->db->where('user_id',$user_id);
		$this->db->update('users',$data);
		return true;
	} 
	//update forgot password 
	function update_forgot_password($email, $newpass){
		$email_id = trim($email);
		$data= array(
			'password'=>md5($newpass),
		);
		$this->db->where('email',$email_id);
		$this->db->update('users',$data);
		return true;
	} 
	//update profile by admin
	function update_profile_admin(){
		$newpass 		= $this->input->post('newpassword');
		$firstname 		= strip_tags($this->input->post('firstname', true));
		$pass			= strip_tags(md5($newpass));
		$lastname 		= strip_tags($this->input->post('lastname', true));
		$gender 		= $this->input->post('gender', true);
		$email 			= strip_tags($this->input->post('email', true));
		$user_type 		= strip_tags($this->input->post('user_type', true));
		$user_status 	= strip_tags($this->input->post('user_status', true));
		$mobile			= strip_tags($this->input->post('mobile', true));
		$off_in 		= strip_tags($this->input->post('in_time', true));
		$off_out		= strip_tags($this->input->post('out_time', true));
		$alt_pass		= strip_tags($this->input->post('alt_pass', true));
		$mobile_otp		= strip_tags($this->input->post('mobile_otp', true));
		$user_id		= strip_tags($this->input->post('user_id', true));
		$website		= $this->input->post('website');
		$data= array(
			'first_name'	=>$firstname,
			'last_name'		=>$lastname,
			'gender'		=>$gender,
			'email'			=>$email,
			'mobile'		=>$mobile,
			'user_type'		=>$user_type,
			'in_time'		=>$off_in,
			'alt_pass'		=>$alt_pass,
			'out_time'		=>$off_out,
			'user_status'	=>$user_status,
			'website'		=>$website,
			'mobile_otp'	=>$mobile_otp,
		);
		// check if password is not empty
		if( !empty($newpass) && $newpass != "" ){
			$data["password"] = $pass;
		}
		
		$this->db->where('user_id',$user_id);
		$update = $this->db->update('users',$data);
		if( $update ){
			return true;
		}else{
			return false;
		}
	}
	
	//change password
	public function changePassword()	{
		$id = $this->input->post('user_id');
		$oldpass = md5($this->input->post('oldPass'));
		$newpass = md5($this->input->post('currentPass'));
		
		$query= $this->db->get_where('users',array('password' => $oldpass,'user_id' => $id)); 
		if($query->num_rows() == 1){
			$data= array(
				'password'=>$newpass,
				);
			
			$this->db->where('user_id',$id);
			$this->db->update('users',$data);
			return true;
		}
		
	}
	
	// Update profile pic
	function updateProfilePic($picdata, $userId){
		$data= array(
			'user_pic'=>$picdata,
		);
		$this->db->where('user_id', $userId);
		$query = $this->db->update('users', $data);
		if( $query ){
			return true;
		}
	}
	//Query for datatable 
	private function _get_datatables_query($where = array()){
		
		if( !empty($where) ){
			$this->db->where_in( "user_type", $where );
		}
		
		
		
		$this->db->where("del_status", 0);
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
		if(!empty($where)){
			$this->db->where_in( "user_type", $where );
		}
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
	
	// get assigned area  for view
	function get_area_tables(){
		$query = $this->db->select('*')->from('assign_user_area')->get();
		return $query->result();
	}
	
	// get assigned area
	public function get_area_for_user($id){
		$query = $this->db->select('*')->from('assign_user_area')->where('user' , $id )->get();
		$res = $query->result();
		if($res){
			$result =  $res;
		}else{
			$result = false;
		}
		return $result;
	}
	
	//is unique agent
	public function is_unique(){
		$get = $this->db->where('user', $this->input->post('user'))->get('assign_user_area');
		$return = $get->result();
		if(count($return)){
			return FALSE;
		}else{
			return TRUE;
		}
	}
	
	/*Get all sales/service team*/
	public function get_all_sales_service_team_users(){
		$query = $this->db->select('*')->from('users')->where_in("user_type", array(96,97))
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
	
	
	//Get all cities assign not current user
	public function check_agents_assigned_city( $user_id = "" ){
		$this->db->select("city");
		if( !empty( $user_id ) ){
			$this->db->where_not_in( "user", $user_id );
		}
		$this->db->from("assign_user_area");
		$query = $this->db->get();
		$res = $query->result();
		$res_array = array();
		if( !empty( $res ) ){
			foreach( $res as $data ){
				$city = explode(',',$data->city);
				foreach( $city as $c ){
					$res_array[] = $c;
				}
			}
		}
		return $res_array;
	}
	
	//login requested to manager
	function loginrequest( $user_role ){
		$query = $this->db->select('*')->from('users')->where_in("user_type", $user_role )
		->where("del_status", 0)
		->where("user_status", "active")
		->where("login_request", 1)
		->like("login_request_date", date("Y-m-d") )
		->order_by("login_request_date", "ASC")->get();
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