<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings_Model extends CI_Model{
	
	function __construct(){
        parent::__construct();
	}
	public function update_data( $tablename, $data ){
		$type = $this->input->post('type', TRUE);
		if($type == 'Add'){
			$insert = $this->db->insert($tablename, $data);
			if( $insert ){
				return true;
			}else{
				return false;
			}
		}else{
			$id= $this->security->xss_clean($this->input->post('inp[id]'));
			$this->db->where('id',$id);
			$update = $this->db->update($tablename ,$data);
			if( $update ){
				return true;
			}else{
				return false;
			}
		}
		return false;
	} 
	//update sms settings
	public function update_sms_settings(){
		$type = $this->input->post('type');
		if($type == 'Add'){
			$data = array(
				'auth_key' 	=>$this->input->post('auth_key', true),
				'sender_id' => $this->input->post( 'sender_id', true ),
			);
			$insert = $this->db->insert('sms_settings',$data);
			if( $insert ){
				return true;
			}else{
				return false;
			}
		}else{
			$id= $this->security->xss_clean($this->input->post('id'));
			$data = array(
				'auth_key' 	=>$this->input->post('auth_key', true),
				'sender_id' => $this->input->post( 'sender_id', true ),
			);
			$this->db->where('id',$id);
			$update = $this->db->update('sms_settings',$data);
			if( $update ){
				return true;
			}else{
				return false;
			}
		}
		return false;
	} 
	
	
}
 
?>
