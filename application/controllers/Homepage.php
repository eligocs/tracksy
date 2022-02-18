<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Homepage extends CI_Controller {
	

	public function index(){
		$data['info'] = $this->global_model->getdata('homepage_setting');
		$this->load->view('homepage/commingsoon',$data);
		//$this->load->view('homepage/homepage',$data);
	}
	
	public function update_Info(){
		$id = $this->input->post('id');
		$counter = serialize($this->input->post('counter'));

		if($id){
			//$data = $this->input->post('inp', TRUE);
			$data = array(
					"logo_url"  => $this->input->post( 'logo_url'),
					"video_url" => $this->input->post( 'video_url'),
					"api_key"   => $this->input->post( 'api_key'),
					"address"   => $this->input->post( 'address'),
					"contact_no"=> $this->input->post( 'contact_no'),
					"counter"=> $counter,
					"website"   => $this->input->post( 'website'),
				);	
			$where = array("id"=>$id);	
			$result = $this->global_model->update_data("homepage_setting", $where, $data);
			if($result == true){
				$this->session->set_flashdata('success','Updated Homepage Info !');
				redirect("settings/homepage");
			}else{
				$this->session->set_flashdata('success','Error !');
				redirect("settings/homepage");
			}
	
		}
	}
		//$NEW SLIDE Images
	// public function do_upload(){
	// $data = $_POST['image'];
	
	// list($type, $data) = explode(';', $data);
	// list(, $data)      = explode(',', $data);
	
	
	// $data = base64_decode($data);
	// $imageName = 'logo'.time().'.png';
	// file_put_contents('site/images/'.$imageName, $data);
	// $data = array( "logo_url" => $imageName );
	// $id=1;
	// $where = array("id"=>$id);	
	// $result = $this->global_model->update_data("homepage_setting", $where, $data);			
	// if( $result ){
	// 	echo 'success';
	// }else{
	// 	echo "error";
	// 	} 
	// 			die();
	// }	


	public function do_upload(){
		if(isset($_POST['type'])){
			$data = $_POST['image'];
			
			list($type, $data) = explode(';', $data);
			list(, $data)      = explode(',', $data);
			
			$data = base64_decode($data);
			$imageName = 'logo'.time().'.png';
			file_put_contents('site/images/'.$imageName, $data);
			$data = array( "favicon" => $imageName );
			$id=1;
			$where = array("id"=>$id);	
			$result = $this->global_model->update_data("homepage_setting", $where, $data);			
			if( $result ){
				echo 'success';
			}else{
				echo "error";
				} 
						die();
		}else{
			$data = $_POST['image'];
			
			list($type, $data) = explode(';', $data);
			list(, $data)      = explode(',', $data);
			
			
			$data = base64_decode($data);
			$imageName = 'logo'.time().'.png';
			file_put_contents('site/images/'.$imageName, $data);
			$data = array( "logo_url" => $imageName );
			$id=1;
			$where = array("id"=>$id);	
			$result = $this->global_model->update_data("homepage_setting", $where, $data);			
			if( $result ){
				echo 'success';
			}else{
				echo "error";
				} 
						die();
			}
		}
	
} 
  