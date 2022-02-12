<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bank_Model extends CI_Model{
	
	function __construct(){
        parent::__construct();
	}
	
	public function insert_bank($tablename, $data_array) {
		
        if ($this->db->insert($tablename, $data_array)) {
            $result = $this->db->insert_id();
			$result = true;
        } else {
            $result = false;
        }
        return $result;
    }
	
	/*check Account Number if exists */
	function isAccountNumber( $ac_no ) {
    $this->db->select('bank_id');
    $this->db->where('account_number', $ac_no);
    $this->db->where('del_status', 0);
    $query = $this->db->get('bank_details');
		if ($query->num_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	//Get All banks
	function get_all_banks( $id = '' ){
		if( !empty( $id )){
			$this->db->select('*');
			$this->db->order_by("bank_id", "DESC");
			$this->db->from("bank_details");
			$query=$this->db->get();
		} else{
			$this->db->select('*');
			$this->db->order_by("bank_id", "DESC");
			$this->db->from("bank_details");
			$query=$this->db->get();
		} 
		return $query->result();
	}
	
	//get custom by id 
	public function get_bank( $id ){
		$this->db->select('*')->from('bank_details')->where("bank_id", $id);
		$query = $this->db->get();
		
		if ( $query->result() ){
			$result = $query->result();
		}else{
			$result = false;
		}
		return $result;
	}
	
	
	//delete bank delete_customer
	function delete_bank($id){
		$this->db->where('bank_id', $id);
		$this->db->delete('bank_details');
		return $this->db->affected_rows();
	}
	
	//update bank
	
	//edit hotel
	public function update_bank($id, $tablename, $data_array) {
		$this->db->where('bank_id',$id);
		$this->db->update($tablename,$data_array);
		return true;
	}
}
 
?>
