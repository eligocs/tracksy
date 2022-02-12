<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fileupload extends CI_Controller {
	//functions
	public function index(){
		$this->load->view("file");
	}
	function ajax_upload(){
		if(isset($_FILES["profile_pic"]["name"])){
			$config['upload_path'] = dirname($_SERVER["SCRIPT_FILENAME"]).'/site/images/userprofile';
			$config['allowed_types'] = 'jpg|jpeg|png';
			$config['max_size'] = 1024 * 2;
			$this->load->library('upload', $config);
			if(!$this->upload->do_upload('profile_pic')){
				echo $this->upload->display_errors();
				die();
			}else{
				$data = $this->upload->data();
					echo "success";
				//echo '<img src="http://localhost/codeigniter/upload/'.$data["file_name"].'" width="300" height="225" class="img-thumbnail" />';
				die();
			}
		}
	}
}	