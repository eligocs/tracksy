<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Accounts_model extends CI_Model{
	
	function __construct(){
        parent::__construct();
		validate_login();
	}
	
	//check if account name already exists
	function is_account_name_exists( $table, $key, $val, $id = null ){
		$this->db->select('id');
		$this->db->where($key, trim($val) );
		//on update
		if( !empty( $id ) ){
			$this->db->where_not_in('id', $id);
		}
		$query = $this->db->get($table);
		if ($query->num_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	//get all pending customer accounts
	public function check_pending_customers_accounts(){
		$sql = "SELECT u.customer_id, u.customer_name,u.customer_email,u.customer_contact,u.iti_id, l.id FROM iti_payment_details as u LEFT JOIN ac_booking_reference_details as l on ( u.customer_id = l.lead_id ) WHERE l.id is NULL";
		$q = $this->db->query($sql);
		return $q->result();
	}
	
	//GET ALL customer accounts
	public function get_customer_accounts(){
		$sql = "SELECT c.*, ac.lead_id FROM `ac_customer_accounts` as c INNER JOIN `ac_booking_reference_details` as ac ON (c.id = ac.cus_account_id) WHERE c.status = 0 AND c.del_status = 0 AND ac.close_account = 0 GROUP by ac.lead_id ORDER by c.customer_name ASC";
		$q = $this->db->query($sql);
		return $q->result();
	}	

	
	//get all invoices
	public function get_all_receipts( $receipt_type = NULL ){
		$this->db->select('i.*,c.customer_name,c.customer_email,c.customer_contact,ac.account_name,ac.account_type')
		->from('ac_receipts as i')
		->join('ac_customer_accounts as c', 'i.customer_acc_id = c.id', 'INNER')
		->join('ac_bank_cash_account_listing as ac', 'i.account_type_id = ac.id', 'INNER')
		->where("i.del_status", 0);
		
		if( $receipt_type ){
			$this->db->where( "receipt_type", $receipt_type );
		}
		
		$this->db->order_by('i.id', "DESC");
		$q = $this->db->get();
		return $q->result();
	}
	
	//get all customer accounts
	public function get_all_customer_accounts(){
		$this->db->select('c.*,l.lead_id,l.iti_id')
		->from('ac_customer_accounts as c')
		->join('ac_booking_reference_details as l', 'l.cus_account_id = c.id', 'INNER')
		->where("c.del_status", 0);
		$this->db->group_by('c.id');
		$this->db->order_by('c.id', 'DESC');
		$q = $this->db->get();
		return $q->result();
	}
	
	
	//get all booked iti accounts
	public function check_booked_iti( $agent_id = NULL ){
		$where = "";
		if( $agent_id ){
			$where = " AND i.agent_id = {$agent_id} ";
		}
		$sql = "SELECT u.customer_name,u.customer_email,u.customer_contact,i.* FROM iti_payment_details as i INNER JOIN customers_inquery as u on ( u.customer_id = i.customer_id ) WHERE i.iti_close_status = 0 {$where}";
		$q = $this->db->query($sql);
		return $q->result();
	}
}
?>