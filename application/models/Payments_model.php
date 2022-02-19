<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Payments_model extends CI_Model{
	/* datatable filter varibles for hotels */
	public $table = 'iti_payment_details';
	public $column_order = array(null,'iti_id'); //set column field database for datatable orderable
	public $column_search = array('iti_id','customer_id', 'customer_name', 'customer_contact'); //set column field database for datatable searchable 
	public $order = array('id' => 'DESC'); // default order 
	
	function __construct(){
        parent::__construct();
	}
	
	//datatable view all packages
	private function _get_datatables_query($where){
		//add custom filter with Date Range
		if( isset( $_POST['filter'] ) && isset( $_POST['from'] ) && isset( $_POST['end'] ) ){
			$filter_data = trim($this->input->post('filter'));
			$date_from 	 = $this->input->post('from');
			$date_end 	 = $this->input->post('end');
			if( isset( $_POST['todayStatus'] ) && !empty( $_POST['todayStatus'] ) ){
				$date = $_POST['todayStatus'];
				//date can be month or day format eg: Y-m or Y-m-d
				$todayDate = $date;
				//$todayDate = date('Y-m-d', strtotime($today));
				switch( $filter_data ){
					case "pending":
						$this->db->like( "next_payment_due_date", $todayDate );
						$this->db->not_like( "last_payment_received_date", $todayDate );
						break;
					case "advance_pending":
						$this->db->like( "next_payment_due_date", $todayDate );
						$this->db->where("TRUNCATE( ((total_package_cost - total_balance_amount )/total_package_cost  * 100 ),0) < 50");
						break;
					case "bal_pending":
						$this->db->like( "next_payment_due_date", $todayDate );
						$this->db->where("TRUNCATE( ((total_package_cost - total_balance_amount )/total_package_cost  * 100 ),0) >= 50");
						break;						
					case "pay_received":
						$this->db->like( array( "last_payment_received_date" => $todayDate ) );
						break;
					case "travel_date":
						$this->db->like( array( "travel_date" => $todayDate ) );
						break;
					case "all":
						$this->db->like( "created", $todayDate );
						break;
					default:
						continue2;
						break;
				} 
			}else if( !empty($filter_data) && !empty($date_from) && !empty($date_end) ){
				$d_from 	= date('Y-m-d', strtotime($date_from));
				$d_to	 	= date('Y-m-d H:i:s', strtotime($date_end . "23:59:59"));
				
				switch( $filter_data ){
					case "pending":
						$this->db->where("(next_payment_due_date BETWEEN '" . $d_from . "' AND '". $d_to ."')");
						break;
					case "pay_received":
						$this->db->where("(last_payment_received_date BETWEEN '" . $d_from . "' AND '". $d_to ."')");
						break;
					case "complete":
						$this->db->where( "total_balance_amount", 0 );
						$this->db->where("(created BETWEEN '" . $d_from . "' AND '". $d_to ."')");
						break;
					case "refund":
						$this->db->where(array("refund_amount >" => 0, "refund_status" => 'unpaid'));
						break;
					case "travel_date":
						$this->db->where("travel_date >=", date('Y-m-d', strtotime($date_from)));
						$this->db->where("travel_date <=", date('Y-m-d', strtotime($date_end)));
						break;
					case "pm_oi":
						$this->db->where( array( "iti_close_status" => "0" ) );
						break;
					case "pending_confirm":
						$this->db->where( array( "payement_confirmed_status" => 0 ) );
						break;
					case "pm_ci":
						$this->db->where( array( "iti_close_status" => "1" ) );						
						break;
					case "all":
						$this->db->where("(created BETWEEN '" . $d_from . "' AND '". $d_to ."')");
						break;
					default:
						continue2;
						break;
				}
					
			}
        }
		
		if (!empty($where)) {
			foreach($where as $key => $value){
				$this->db->where( $key, $value );
			}
        }
		
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
	
	
	/* update Data function */
	function update_discount( $tablename, $where = array(), $discount = null ){
		if (!empty($where)) {
			$this->db->set('total_discount', "total_discount + $discount", FALSE);
			
			foreach($where as $key => $value){
				$this->db->where( $key, $value );
			}
			$this->db->update($tablename);
			return true;
        }else{
			return false;
		}
	}
	
	//delete Amendment Itineraries
	function delete_amendment($id , $iti_id ){
		$this->db->where( "id != '$id' AND iti_id = '$iti_id' ");
		$this->db->delete("iti_amendment_temp");
		return $this->db->affected_rows();
	}
	
}
?>
