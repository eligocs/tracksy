<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Newsletter_model extends CI_Model{
	public $table = 'newsletters';
	public $column_order = array(null, 'id'); 
	public $column_search = array('id','subject');
	public $order = array('id' => 'DESC'); 
	function __construct(){
        parent::__construct();
	}
	
	public function getdata( $tablename , $order_key = "" ){
		$this->db->from($tablename);
		if( $order_key ){
			$this->db->order_by($order_key, "DESC");
		}	
		$query = $this->db->get();
		return $query->result();
	}
	
	/* update Data Global function */
	function update_data( $tablename, $type, $where = array(), $data = array() ){
		if($type == 'Add'){
			$this->db->insert($tablename,$data);
		}else{
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
		return true;
	}
	/* update Emails concnate */
	function update_data_emails( $tablename,$where = array(), $emails = array() ){
		$news_emails = implode("," , $emails );
		$this->db->set('emails', "CONCAT(emails,',','".$news_emails."')", FALSE); 
		$this->db->where( 'id', $this->input->post('id') );
		$this->db->update('newsletters');
		return true;
	}
	/*check email if exists */
	function is_slug_exists( $slug ) {
		$this->db->select('id');
		$this->db->where('slug', $slug);
		$query = $this->db->get('newsletters');
		if ( $query->num_rows() > 0 ) {
			return true;
		} else {
			return false;
		}
	}
	//get all customers
	public function getcustomers( $limit = "", $data_not_in = array() ) {
        $this->db->select("customer_email");
		$this->db->distinct();
		$this->db->where( "del_status", 0 );
		$this->db->where( "is_subscriber", 0 );
		if( !empty( $limit ) ){
			$this->db->limit($limit);
		}
		
		if( !empty( $data_not_in ) ){
			$this->db->where_not_in( 'customer_email', $data_not_in );
		}
		$this->db->from("customers_inquery");
		$this->db->order_by("customer_email", "ASC");
		$q = $this->db->get();
		$res = $q->result();
		if ($res) {
			$result = $res;
		} else {
            $result = false;
        }
        return $result;
    }
	
	/* pagination */
	public function ajax_pagination_getcustomers($page, $data_not_in = array()) {
		$offset = 1000*$page;
		$limit = 1000;
		
        $this->db->select("customer_email");
		$this->db->distinct();
		$this->db->where( "del_status", 0 );
		$this->db->where( "is_subscriber", 0 );
		$this->db->limit($limit, $offset);
		$this->db->order_by("customer_email", "ASC");
		if( !empty( $data_not_in ) ){
			$this->db->where_not_in( 'customer_email', $data_not_in );
		}
		$this->db->from("customers_inquery");
		$q = $this->db->get();
		$res = $q->result();
		if ($res) {
			$result = $res;
		} else {
            $result = false;
        }
        return $result;
    }
	
	// get datatable all Newsletters
	private function _get_datatables_query(){
		$user = $this->session->userdata('logged_in');
		$u_id = $user['user_id'];
		$user_role = $user['role'];
		//if agent get newsletters of current user only
		if( $user_role == 96  ){
			$this->db->where( "agent_id", $u_id );
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
}
 
?>
