<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Terms_Model extends CI_Model{
	
	function __construct(){
        parent::__construct();
	}

	public function getTermsData(){
		$query = $this->db->get('terms');
		return $query->result();
	}
	
	/* update Data Global function Terms */
	function update_data( $tablename, $type, $where = array(), $data = array() ){
		$term_type = $this->security->xss_clean($this->input->post('term_type'));
		if($type == 'Add'){
			$data["term_type"] = $term_type;
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
}
 
?>
