<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Clientsection extends CI_Controller {
	
	public function __Construct(){
	   	parent::__Construct();
		validate_login();
		$this->load->library('form_validation');
	}
	
	public function index(){
		redirect("dashboard");
	}
	
	/*********************Reviews Section ***********************/
	//All Reviews
	public function reviews(){
		$user = $this->session->userdata('logged_in');
		$user_id = $user['user_id'];
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '96'){
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('clientsection/reviews/all_reviews');
			$this->load->view('inc/footer');
		}
		else{
			redirect("dashboard");
		}
	}
	/* add review */
	public function review_add(){
		$user = $this->session->userdata('logged_in');
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '96'){
			$data['agent_id'] = $user['user_id'];
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('clientsection/reviews/add', $data);
			$this->load->view('inc/footer');
		}else{
			redirect("dashboard");
		}
	}
	
	/* add review ajax request */
	public function ajax_add_review(){
		if (isset($_POST['inp']) && !empty($_POST['inp']['client_name']) && !empty($_POST['inp']['agent_id'])) {
			$inpFields = $this->input->post('inp', TRUE);
			$insert_id = $this->global_model->insert_data( "client_reviews", $inpFields );
			if( $insert_id){
				$this->session->set_flashdata('success',"Review added successfully.");
				$res = array('status' => true, 'msg' => "Review Add Successfully", "id"=> $insert_id );
			}else{
				$res = array('status' => false, 'msg' => "Error! please try again later");
			}
			die(json_encode($res));
		}	 
	}
	
	/* Edit review */
	public function review_edit(){
		$user = $this->session->userdata('logged_in');
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '96'){
			$review_id = trim($this->uri->segment(3));
			$where = array( "del_status" => 0, "id" => $review_id );
			$get_rev = $this->global_model->getdata( "client_reviews", $where );
			$data["review_data"] = $get_rev;
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('clientsection/reviews/edit', $data);
			$this->load->view('inc/footer');
		}else{
			redirect("dashboard");
		}
	}
	
	/* add review ajax request */
	public function ajax_edit_review(){
		if (isset($_POST['inp']) && !empty($_POST['inp']['client_name']) && !empty($_POST['inp']['agent_id'])) {
			$inpFields = $this->input->post('inp', TRUE);
			$id = $this->input->post('review_id', TRUE);
			$where = array( "id" => $id );
			$insert_id = $this->global_model->update_data( "client_reviews", $where, $inpFields );
			if( $insert_id){
				$this->session->set_flashdata('success',"Review edit successfully.");
				$res = array('status' => true, 'msg' => "Review Add Successfully");
			}else{
				$res = array('status' => false, 'msg' => "Error! please try again later");
			}
			die(json_encode($res));
		}	 
	}
	
	/* View review */
	public function review_view(){
		$user = $this->session->userdata('logged_in');
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '96'){
			$review_id = trim($this->uri->segment(3));
			$where = array( "del_status" => 0, "id" => $review_id );
			$get_rev = $this->global_model->getdata( "client_reviews", $where );
			$data["review_data"] = $get_rev;
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('clientsection/reviews/view', $data);
			$this->load->view('inc/footer');
		}else{
			redirect("dashboard");
		}
	}
	
	//delete Review
	public function ajax_deletereview(){
		$id = $this->input->get('id', TRUE);
		$where = array("id" => $id);
		$result = $this->global_model->update_del_status("client_reviews", $where);
		if( $result){
			$this->session->set_flashdata('success',"Review Deleted successfully.");
			$res = array('status' => true, 'msg' => "Review delete Successfully!");
		}else{
			$res = array('status' => false, 'msg' => "Error! please try again later");
		}
		die(json_encode($res));
	}
	/* Update slider status */
	public function ajax_updateSliderStatus(){
		$id = $this->input->post('id', TRUE);
		$in_slider = $this->input->post('is_slider', TRUE);
		$where = array("id" => $id);
		$data = array( "in_slider" => $in_slider );
		$result = $this->global_model->update_data("client_reviews", $where, $data);
		if( $result){
			$this->session->set_flashdata('success',"Review Updated successfully.");
			$res = array('status' => true, 'msg' => "Review delete Successfully!");
		}else{
			$res = array('status' => false, 'msg' => "Error! please try again later");
		}
		die(json_encode($res));
	}
	/* data table get all Reviews */
	public function ajax_review_list(){
		$user = $this->session->userdata('logged_in');
		$u_id = $user['user_id'];
		$role = $user['role'];
		
		//Sort Variables
		$table = "client_reviews";
		$column_order = array(null, 'client_name','rating'); 
		$column_search = array('client_name', "rating");
		$order = array('id' => 'DESC'); // default order 
		
		if( $role == '99' || $role == '98' || $role == '96' ){
			$where = array("del_status" => 0);
			$list = $this->global_model->get_datatables( $table, $where, $column_order, $column_search, $order );
		}
		$data = array();
		$no = $_POST['start'];
		if( !empty($list) ){
			foreach ($list as $review) {
				$id = $review->id;
				$row_delete = "";
				$row_edit = "";
				//rating
				$rating = $review->rating;
				$check1 ="";
				$check2 ="";
				$check3 ="";
				$check4 ="";
				$check5 ="";
				//Checked Rating
				switch( $rating ){
					case 5:
						$check5 = "checked";
					break;
					case 4:
						$check4 = "checked";
					break;
					case 3:
						$check3 = "checked";
					break;
					case 2:
						$check2 = "checked";
					break;
					case 1:
						$check1 = "checked";
					break;
					default:
						$check1 ="";
						$check2 ="";
						$check3 ="";
						$check4 ="";
						$check5 ="";
					break;	
				}
				//get rating star
				$rating_star =
				"<div class='star-rating'>
				  <fieldset>
					<input type='radio' disabled id='star5' {$check5} /><label for='star5' title='Outstanding'>5 stars</label>
					<input id='star4' type='radio' disabled {$check4} /><label for='star4' title='Very Good'>4 stars</label>
					<input type='radio' disabled id='star3'  {$check3} /><label for='star3' title='Good'>3 stars</label>
					<input type='radio' disabled id='star2'  {$check2} /><label for='star2' title='Poor'>2 stars</label>
					<input type='radio' disabled id='star1'  {$check1} /><label for='star1' title='Very Poor'>1 star</label>
				</fieldset>
				</div>";
				//radio button swith
				$inSlider = $review->in_slider;
				$inSliderBtn = 	$inSlider == 1 ? "<label class='mt-checkbox'> <input type='checkbox' value='1' data-id ={$id} id='inSlider' class='form-control' checked><span></span></label>" : "<label class='mt-checkbox'> <input type='checkbox' value='0' data-id ={$id} id='inSlider' class='form-control'> <span></span></label>";								
				$no++;
				$row = array();
				$row[] = $no;
				$row[] = $review->client_name;
				$row[] = $review->client_contact;
				$row[] = $rating_star;
				$row[] = $inSliderBtn;
				$row[] = $review->created;
				
				if( is_admin() || is_manager() ){
					//Delete
					$row_delete = "<a href='javascript:void(0)' data-id = {$review->id} class='btn btn-danger ajax_delete_review' title='Delete Review'><i class='fa fa-trash-o'></i></a>";
				}
			
				//edit
				$row_edit = "<a href=" . site_url("clientsection/review_edit/{$review->id}") . " class='btn btn-success ajax_edit_customer_table' title='Edit Review'><i class='fa fa-pencil'></i></a>";
				// View 
				$row[] = "<a href=" . site_url("clientsection/review_view/{$review->id}") . " title='View review' class='btn btn-success' ><i class='fa fa-eye'></i></a>". $row_edit . $row_delete;  
				$data[] = $row;
			}
		}	
		
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->global_model->count_all_data($table, $where),
			"recordsFiltered" => $this->global_model->count_filtered($table, $where, $column_order, $column_search, $order ),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}
	
	/*********************End Reviews Section ***********************/
	
	/*******************
	** Slider Section **
	********************/
	//All Sliders
	public function sliders(){
		$user = $this->session->userdata('logged_in');
		$user_id = $user['user_id'];
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '96'){
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('clientsection/sliders/all_sliders');
			$this->load->view('inc/footer');
		}
		else{
			redirect("dashboard");
		}
	}
	/* add slider */
	public function slider_add(){
		$user = $this->session->userdata('logged_in');
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '96'){
			$data['agent_id'] = $user['user_id'];
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('clientsection/sliders/add', $data);
			$this->load->view('inc/footer');
		}else{
			redirect("dashboard");
		}
	}
	/* upload Slider image */
	function ajax_add_slide(){
		$slide_name = $this->input->post('name', true);
		if( isset($_FILES["image_url"]["name"]) ){
			$agent_id = $this->input->post('agent_id', true);
			
			$n = str_replace(' ', '_', $slide_name);
			$file_name = $n . "_" . time(); 
			$config['upload_path'] = dirname($_SERVER["SCRIPT_FILENAME"]).'/site/images/sliders';
			$config['allowed_types'] = 'jpg|jpeg|png';
			$config['max_size'] = 1024 * 2;
			$config['max_width']  = 600;
            $config['max_height'] = 400;
            $config['file_name'] = $file_name;
			$this->load->library('upload', $config);
			if(!$this->upload->do_upload('image_url')){
				$err = $this->upload->display_errors();
				echo "<div class='alert alert-danger'>{$err}</div>";
				die();
			}else{
				$data = $this->upload->data();
				$img_fname = $data['file_name'];
				$insert_data = array( "name" => $slide_name, "agent_id" => $agent_id, "image_url" => $img_fname );
				$insert_id = $this->global_model->insert_data( "sliders", $insert_data);
				if( $insert_id ){
					$this->session->set_flashdata('success',"Slide Added successfully.");
					echo 'success';
				}else{
					echo '<div class="alert alert-danger"><strong>Error: </strong>Something went wrong. Please try again later.</div>';
					
				} 
				die();
			}
		}else{
			echo '<div class="alert alert-danger"><strong>Error: </strong>Something went wrong. Please try again later.</div>';
			die();
		}
	}
	
	/* Edit slide */
	public function slide_edit(){
		$user = $this->session->userdata('logged_in');
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '96'){
			$id = trim($this->uri->segment(3));
			$where = array( "del_status" => 0, "id" => $id );
			$get_rev = $this->global_model->getdata( "sliders", $where );
			$data["slide_data"] = $get_rev;
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('clientsection/sliders/edit', $data);
			$this->load->view('inc/footer');
		}else{
			redirect("dashboard");
		}
	}
	
	
	//$NEW SLIDE Images
	public function do_upload(){
		$data = $_POST['image'];
		$name = $_POST['name'];
		$agentId = $_POST['id'];
		
		list($type, $data) = explode(';', $data);
		list(, $data)      = explode(',', $data);
		
		
		$data = base64_decode($data);
		$imageName = 'logo'.time().'.png';
		file_put_contents('site/images/sliders/'.$imageName, $data);
		$insert_data = array( "name" => $name, "agent_id" => $agentId, "image_url" => $imageName );
		$insert_id = $this->global_model->insert_data( "sliders", $insert_data);
		if( $insert_id ){
			$this->session->set_flashdata('success',"Slide Added successfully.");
			echo 'success';
		}else{
			echo '<div class="alert alert-danger"><strong>Error: </strong>Something went wrong. Please try again later.</div>';
			
		} 
		die();
	}	
	
	//$Edit SLIDE Images
	public function edit_upload(){
		$data = $_POST['image'];
		$slide_name = $_POST['name'];
		$agentId = $_POST['id'];
		$sid = $_POST['sid'];
		
		list($type, $data) = explode(';', $data);
		list(, $data)      = explode(',', $data);
		
		
		$data = base64_decode($data);
		$imageName = 'logo'.time().'.png';
		file_put_contents('site/images/sliders/'.$imageName, $data);
		$updateData = array( "name" => $slide_name, "image_url" => $imageName, "agent_id" => $agentId );
		$where = array( "id" => $sid );
		$insert_id = $this->global_model->update_data( "sliders",$where,$updateData);
		if( $insert_id ){
			$this->session->set_flashdata('success',"Slide Updated successfully.");
			echo 'success';
		}else{
			echo '<div class="alert alert-danger"><strong>Error: </strong>Something went wrong. Please try again later.</div>';
			
		} 
		die();
	}	
	/* edit slide ajax request */
	/* upload Slider image */
	function ajax_edit_slide(){
		$slide_name = $this->input->post('name', true);
		$id = trim($this->input->post('id', true));
		if( isset($_FILES["image_url"]["name"]) ){
			$agent_id = $this->input->post('agent_id', true);
			$n = str_replace(' ', '_', $slide_name);
			$file_name = $n . "_" . time() ; 
			$config['upload_path'] = dirname($_SERVER["SCRIPT_FILENAME"]).'/site/images/sliders';
			$config['allowed_types'] = 'jpg|jpeg|png';
			$config['max_size'] = 1024 * 2;
			$config['max_width']  = 600;
            $config['max_height'] = 400;
            $config['file_name'] = $file_name;
			$this->load->library('upload', $config);
			if( !empty( $_FILES['image_url']['name'] ) ){
				if(!$this->upload->do_upload('image_url')){
					$err = $this->upload->display_errors();
					echo "<div class='alert alert-danger'>{$err}</div>";
					die();
				}else{
					$data = $this->upload->data();
					$img_fname = $data['file_name'];
					$updateData = array( "name" => $slide_name, "image_url" => $img_fname );
					$where = array( "id" => $id );
					$insert_id = $this->global_model->update_data( "sliders",$where,$updateData);
					if( $insert_id ){
						$this->session->set_flashdata('success',"Slide Updated successfully.");
						echo 'success';
					}else{
						echo '<div class="alert alert-danger"><strong>Error: </strong>Something went wrong. Please try again later.</div>';
						
					} 
					die();
				}
			}else{
				$updateData = array( "name" => $slide_name );
				$where = array( "id" => $id );
				$insert_id = $this->global_model->update_data( "sliders",$where,$updateData);
				if( $insert_id ){
					echo 'success';
				}else{
					echo '<div class="alert alert-danger"><strong>Error: </strong>Something went wrong. Please try again later.</div>';
				} 
				die();
			}	
		}else{
			echo '<div class="alert alert-danger"><strong>Error: </strong>Something went wrong. Please try again later.</div>';
			die();
		}
	}
	/* View slide */
	public function slide_view(){
		$user = $this->session->userdata('logged_in');
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '96'){
			$id = trim($this->uri->segment(3));
			$where = array( "del_status" => 0, "id" => $id );
			$get_rev = $this->global_model->getdata( "sliders", $where );
			$data["slide_data"] = $get_rev;
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('clientsection/sliders/view', $data);
			$this->load->view('inc/footer');
		}else{
			redirect("dashboard");
		}
	}
	
	//delete Slide
	public function ajax_deleteslide(){
		$id = $this->input->get('id', TRUE);
		$where = array("id" => $id);
		$result = $this->global_model->update_del_status("sliders", $where);
		if( $result){
			$this->session->set_flashdata('success',"Slide Deleted successfully.");
			$res = array('status' => true, 'msg' => "Slide Deleted successfully!");
		}else{
			$res = array('status' => false, 'msg' => "Error! please try again later");
		}
		die(json_encode($res));
	}
	
	/* Update slider status */
	public function ajax_slide_updateStatus(){
		$id = $this->input->post('id', TRUE);
		$in_slider = $this->input->post('is_slider', TRUE);
		$where = array("id" => $id);
		$data = array( "in_slider" => $in_slider );
		$result = $this->global_model->update_data("sliders", $where, $data);
		if( $result){
			$this->session->set_flashdata('success',"Status Updated successfully.");
			$res = array('status' => true, 'msg' => "Status Updated successfully!");
		}else{
			$res = array('status' => false, 'msg' => "Error! please try again later");
		}
		die(json_encode($res));
	}
	/* data table get all Slider Images */
	public function ajax_slider_list(){
		$user = $this->session->userdata('logged_in');
		$u_id = $user['user_id'];
		$role = $user['role'];
		
		//Sort Variables
		$table = "sliders";
		$column_order = array(null, 'name'); 
		$column_search = array('name');
		$order = array('id' => 'DESC'); // default order 
		
		if( $role == '99' || $role == '98' || $role == '96' ){
			$where = array("del_status" => 0);
			$list = $this->global_model->get_datatables( $table, $where, $column_order, $column_search, $order );
		}
		$data = array();
		$no = $_POST['start'];
		if( !empty($list) ){
			foreach ($list as $slider) {
				$id = $slider->id;
				$row_delete = "";
				$row_edit = "";
				$no++;
				//show in slider
				$inSlider = $slider->in_slider;
				$inSliderBtn = 	$inSlider == 1 ? "<label class='mt-checkbox'> <input type='checkbox' value='1' data-id ={$id} id='inSlider' class='form-control' checked><span></span></label>" : "<label class='mt-checkbox'> <input type='checkbox' value='0' data-id ={$id} id='inSlider' class='form-control'> <span></span></label>";
				
				//slide image
				$slide_img_path = site_url() . 'site/images/sliders/' .$slider->image_url;
				$s_image = "<img class='' src='{$slide_img_path}' width='' height='150px' />";
				
				$row = array();
				$row[] = $no;
				$row[] = $slider->name;
				$row[] = $s_image;
				$row[] = $inSliderBtn;
				$row[] = $slider->created;
				
				if( is_admin() || is_manager() ){
					//Delete
					$row_delete = "<a href='javascript:void(0)' data-id = {$slider->id} class='btn btn-danger ajax_delete_review' title='Delete slide'><i class='fa fa-trash-o'></i></a>";
				}
			
				//edit
				$row_edit = "<a href=" . site_url("clientsection/slide_edit/{$slider->id}") . " class='btn btn-success ajax_edit_customer_table' title='Edit slide'><i class='fa fa-pencil'></i></a>";
				// View 
				$row[] = "<a href=" . site_url("clientsection/slide_view/{$slider->id}") . " title='View slide' class='btn btn-success' ><i class='fa fa-eye'></i></a>". $row_edit . $row_delete;  
				$data[] = $row;
			}
		}	
		
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->global_model->count_all_data($table, $where),
			"recordsFiltered" => $this->global_model->count_filtered($table, $where, $column_order, $column_search, $order ),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}
	
	/*********************End Slider Section***********************/
	
	/*******************
	** Youtube Section **
	********************/
	//All Youtube videos listing
	public function youtube(){
		$user = $this->session->userdata('logged_in');
		$user_id = $user['user_id'];
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '96'){
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('clientsection/youtube/all');
			$this->load->view('inc/footer');
		}
		else{
			redirect("dashboard");
		}
	}
	/* add youtube */
	public function youtube_vid_add(){
		$user = $this->session->userdata('logged_in');
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '96'){
			$data['agent_id'] = $user['user_id'];
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('clientsection/youtube/add', $data);
			$this->load->view('inc/footer');
		}else{
			redirect("dashboard");
		}
	}
	
	/* upload Youtube Video */
	function ajax_add_youtube_vid(){
		$slide_name = $this->input->post('name', true);
		$youtube_url = $this->input->post('youtube_vid_link', true);
		$match;
		//check for valid youtube video link
		if( !preg_match("/(youtube.com|youtu.be)\/(watch)?(\?v=)?(\S+)?/", $youtube_url, $match) ){
			echo '<div class="alert alert-danger"><strong>Error: </strong>Sorry, not a youtube URL.Please enter valid youtube link.</div>';
			die();
		}
		
		if( isset($_FILES["image_url"]["name"]) ){
			$agent_id = $this->input->post('agent_id', true);
			$youtube_vid_url = $this->input->post('youtube_vid_link', true);
			$n = str_replace(' ', '_', $slide_name);
			$file_name = $n . "_" . time() ; 
			$config['upload_path'] = dirname($_SERVER["SCRIPT_FILENAME"]).'/site/images/youtube_poster';
			$config['allowed_types'] = 'jpg|jpeg|png';
			$config['max_size'] = 1024 * 1;
			$config['max_width']  = 800;
            $config['max_height'] = 600;
            $config['file_name'] = $file_name;
			$this->load->library('upload', $config);
			if(!$this->upload->do_upload('image_url')){
				$err = $this->upload->display_errors();
				echo "<div class='alert alert-danger'>{$err}</div>";
				die();
			}else{
				$data = $this->upload->data();
				$img_fname = $data['file_name'];
				$insert_data = array( "name" => $slide_name, "agent_id" => $agent_id, "	poster_url" => $img_fname, "youtube_vid_url	" => $youtube_vid_url );
				$insert_id = $this->global_model->insert_data( "youtube_videos", $insert_data);
				if( $insert_id ){
					$this->session->set_flashdata('success',"Data added successfully.");
					echo 'success';
				}else{
					echo '<div class="alert alert-danger"><strong>Error: </strong>Something went wrong. Please try again later.</div>';
				} 
				die();
			}
		}else{
			echo '<div class="alert alert-danger"><strong>Error: </strong>Something went wrong. Please try again later.</div>';
			die();
		}
	}
	
	//delete youtube vid
	public function ajax_delete_youtube_vid(){
		$id = $this->input->get('id', TRUE);
		$where = array("id" => $id);
		$result = $this->global_model->update_del_status("youtube_videos", $where);
		if( $result){
			$this->session->set_flashdata('success',"Video Deleted successfully.");
			$res = array('status' => true, 'msg' => "Video delete Successfully!");
		}else{
			$res = array('status' => false, 'msg' => "Error! please try again later");
		}
		die(json_encode($res));
	}
	
	/* Update slider status */
	public function ajax_youtube_updateStatus(){
		$id = $this->input->post('id', TRUE);
		$in_slider = $this->input->post('is_slider', TRUE);
		$where = array("id" => $id);
		$data = array( "in_slider" => $in_slider );
		$result = $this->global_model->update_data("youtube_videos", $where, $data);
		if( $result){
			$this->session->set_flashdata('success',"Status Updated successfully.");
			$res = array('status' => true, 'msg' => "Youtube Video update Successfully!");
		}else{
			$res = array('status' => false, 'msg' => "Error! please try again later");
		}
		die(json_encode($res));
	}
	
	/* View slide */
	public function youtube_vid_view(){
		$user = $this->session->userdata('logged_in');
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '96'){
			$id = trim($this->uri->segment(3));
			$where = array( "del_status" => 0, "id" => $id );
			$get_rev = $this->global_model->getdata( "youtube_videos", $where );
			$data["you_data"] = $get_rev;
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('clientsection/youtube/view', $data);
			$this->load->view('inc/footer');
		}else{
			redirect("dashboard");
		}
	}
	
	/* Edit slide */
	public function youtube_vid_edit(){
		$user = $this->session->userdata('logged_in');
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '96'){
			$id = trim($this->uri->segment(3));
			$where = array( "del_status" => 0, "id" => $id );
			$get_rev = $this->global_model->getdata( "youtube_videos", $where );
			$data["youtube_vid_data"] = $get_rev;
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('clientsection/youtube/edit', $data);
			$this->load->view('inc/footer');
		}else{
			redirect("dashboard");
		}
	}
	
	/* edit youtube ajax request */
	function ajax_edit_youtube_vid(){
		$slide_name = $this->input->post('name', true);
		$youtube_url = $this->input->post('youtube_vid_link', true);
		$agent_id = $this->input->post('agent_id', true);
		$id = $this->input->post('id', true);
		$match;
		//check for valid youtube video link
		if( !preg_match("/(youtube.com|youtu.be)\/(watch)?(\?v=)?(\S+)?/", $youtube_url, $match) ){
			echo '<div class="alert alert-danger"><strong>Error: </strong>Sorry, not a youtube URL.Please enter valid youtube link.</div>';
			die();
		}
		
		if( isset($_FILES["image_url"]["name"]) && !empty( $_FILES["image_url"]["name"] ) ){
			$n = str_replace(' ', '_', $slide_name);
			$file_name = $n . "_" . time() ; 
			$config['upload_path'] = dirname($_SERVER["SCRIPT_FILENAME"]).'/site/images/youtube_poster';
			$config['allowed_types'] = 'jpg|jpeg|png';
			$config['max_size'] = 1024 * 1;
			$config['max_width']  = 800;
            $config['max_height'] = 600;
            $config['file_name'] = $file_name;
			$this->load->library('upload', $config);
			
			if( !$this->upload->do_upload('image_url') ){
				$err = $this->upload->display_errors();
				echo "<div class='alert alert-danger'>{$err}</div>";
				die();
			}else{
				$data = $this->upload->data();
				$img_fname = $data['file_name'];
				$up_data = array( "name" => $slide_name, "agent_id" => $agent_id, "poster_url" => $img_fname, "youtube_vid_url" => $youtube_url );
				$where = array("id" => $id);
				$u_data = $this->global_model->update_data( "youtube_videos", $where, $up_data);
				if( $u_data ){
					echo 'success';
				}else{
					echo '<div class="alert alert-danger"><strong>Error: </strong>Something went wrong. Please try again later.</div>';
				} 
				die();
			}
		}else{
			$up_data = array( "name" => $slide_name, "agent_id" => $agent_id, "youtube_vid_url" => $youtube_url );
			$where = array("id" => $id);
			$u_data = $this->global_model->update_data( "youtube_videos", $where, $up_data);
			if( $u_data ){
				echo 'success';
			}else{
				echo '<div class="alert alert-danger"><strong>Error: </strong>Something went wrong. Please try again later.</div>';
			} 
			die();
		}	
		
	}
	/* data table get all Youtube Videos */
	public function ajax_youtube_list(){
		$user = $this->session->userdata('logged_in');
		$u_id = $user['user_id'];
		$role = $user['role'];
		
		//Sort Variables
		$table = "youtube_videos";
		$column_order = array(null, 'name'); 
		$column_search = array('name');
		$order = array('id' => 'DESC'); // default order 
		
		if( $role == '99' || $role == '98' || $role == '96' ){
			$where = array("del_status" => 0);
			$list = $this->global_model->get_datatables( $table, $where, $column_order, $column_search, $order );
		}
		$data = array();
		$no = $_POST['start'];
		if( !empty($list) ){
			foreach ($list as $youtube) {
				$id = $youtube->id;
				$row_delete = "";
				$row_edit = "";
				$no++;
				//show in youtube
				$inSlider = $youtube->in_slider;
				$inSliderBtn = 	$inSlider == 1 ? "<label class='mt-checkbox'> <input type='checkbox' value='1' data-id ={$id} id='inSlider' class='form-control' checked><span></span></label>" : "<label class='mt-checkbox'> <input type='checkbox' value='0' data-id ={$id} id='inSlider' class='form-control'> <span></span></label>";
				
				//slide image
				$slide_img_path = site_url() . 'site/images/youtube_poster/' .$youtube->poster_url;
				$poster_image = "<img class='' src='{$slide_img_path}' width='100%' height='150px' />";
				
				$row = array();
				$row[] = $no;
				$row[] = $youtube->name;
				$row[] = $poster_image;
				$row[] = $youtube->youtube_vid_url;
				$row[] = $inSliderBtn;
				$row[] = $youtube->created;
				
				if( is_admin() || is_manager() ){
					//Delete
					$row_delete = "<a href='javascript:void(0)' data-id = {$youtube->id} class='btn btn-danger ajax_delete_review' title='Delete slide'><i class='fa fa-trash-o'></i></a>";
				}
			
				//edit
				$row_edit = "<a href=" . site_url("clientsection/youtube_vid_edit/{$youtube->id}") . " class='btn btn-success' title='Edit slide'><i class='fa fa-pencil'></i></a>";
				// View 
				$row[] = "<a href=" . site_url("clientsection/youtube_vid_view/{$youtube->id}") . " title='View slide' class='btn btn-success' ><i class='fa fa-eye'></i></a>". $row_edit . $row_delete;  
				$data[] = $row;
			}
		}	
		
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->global_model->count_all_data($table, $where),
			"recordsFiltered" => $this->global_model->count_filtered($table, $where, $column_order, $column_search, $order ),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}
	
	
	/*********************OFFERS Section ***********************/
	//All offers
	public function offers(){
		$user = $this->session->userdata('logged_in');
		$user_id = $user['user_id'];
		if( $user['role'] == '99' || is_super_manager() ){
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('clientsection/offers/all_offers');
			$this->load->view('inc/footer');
		}else{
			redirect("dashboard");
		}
	}
	/* add offer */
	public function offer_add(){
		$user = $this->session->userdata('logged_in');
		if( $user['role'] == '99' || is_super_manager() ){
			$data['agent_id'] = $user['user_id'];
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('clientsection/offers/add', $data);
			$this->load->view('inc/footer');
		}else{
			redirect("dashboard");
		}
	}
	
	/* add offer ajax request */
	public function ajax_add_offer(){
		if (isset($_POST['inp']) && !empty($_POST['inp']['coupon_code']) && !empty($_POST['inp']['agent_id'])) {
			$inpFields = $this->input->post('inp', TRUE);
			$insert_id = $this->global_model->insert_data( "offers", $inpFields );
			if( $insert_id ){
				$this->session->set_flashdata('success',"offer added successfully.");
				$res = array('status' => true, 'msg' => "Offer Add Successfully", "id" => $insert_id );
			}else{
				$res = array('status' => false, 'msg' => "Error! please try again later");
			}
			die(json_encode($res));
		}	 
	}
	
	/* Edit review */
	public function offer_edit(){
		$user = $this->session->userdata('logged_in');
		if( $user['role'] == '99' || is_super_manager() ){
			$offer_id = trim($this->uri->segment(3));
			$where = array( "del_status" => 0, "id" => $offer_id );
			$data["offer_data"] = $this->global_model->getdata( "offers", $where );
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('clientsection/offers/edit', $data);
			$this->load->view('inc/footer');
		}else{
			redirect("dashboard");
		}
	}
	
	/* add review ajax request */
	public function ajax_edit_offer(){
		if (isset($_POST['inp']) && !empty($_POST['inp']['coupon_code']) && !empty($_POST['inp']['title'])) {
			$inpFields = $this->input->post('inp', TRUE);
			$id = $this->input->post('offer_id', TRUE);
			$where = array( "id" => $id );
			$updated = $this->global_model->update_data( "offers", $where, $inpFields );
			if( $updated){
				$this->session->set_flashdata('success',"offer Updated successfully.");
				$res = array('status' => true, 'msg' => "Review Add Successfully");
			}else{
				$res = array('status' => false, 'msg' => "Error! please try again later");
			}
			die(json_encode($res));
		}	 
	}
	
	/* View review */
	public function offer_view(){
		$user = $this->session->userdata('logged_in');
		if( $user['role'] == '99' || is_super_manager() ){
			$offer_id = trim($this->uri->segment(3));
			$where = array( "del_status" => 0, "id" => $offer_id );
			$data["offer_data"] = $this->global_model->getdata( "offers", $where );
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('clientsection/offers/view', $data);
			$this->load->view('inc/footer');
		}else{
			redirect("dashboard");
		}
	}
	
	//delete Review
	public function ajax_deleteoffer(){
		$id = $this->input->get('id', TRUE);
		$where = array("id" => $id);
		$result = $this->global_model->update_del_status("offers", $where);
		if( $result){
			$this->session->set_flashdata('success',"Offer deleted successfully.");
			$res = array('status' => true, 'msg' => "Review delete Successfully!");
		}else{
			$res = array('status' => false, 'msg' => "Error! please try again later");
		}
		die(json_encode($res));
	}
	/* Update slider status */
	public function ajax_updateOfferStatus(){
		$id = $this->input->post('id', TRUE);
		$in_slider = $this->input->post('is_slider', TRUE);
		$where = array("id" => $id);
		$data = array( "offer_status" => $in_slider );
		$result = $this->global_model->update_data("offers", $where, $data);
		if( $result){
			$this->session->set_flashdata('success',"Status Updated successfully.");
			$res = array('status' => true, 'msg' => "Branch delete Successfully!");
		}else{
			$res = array('status' => false, 'msg' => "Error! please try again later");
		}
		die(json_encode($res));
	}
	/* data table get all Reviews */
	public function ajax_offers_list(){
		$user = $this->session->userdata('logged_in');
		$u_id = $user['user_id'];
		$role = $user['role'];
		
		//Sort Variables
		$table = "offers";
		$column_order = array(null, 'title','offer_type'); 
		$column_search = array('title', "offer_type", "coupon_code");
		$order = array('id' => 'DESC'); // default order 
		
		$where = array("del_status" => 0);
		$list = $this->global_model->get_datatables( $table, $where, $column_order, $column_search, $order );
	
		$data = array();
		$no = $_POST['start'];
		if( !empty($list) ){
			foreach ($list as $offer) {
				$id = $offer->id;
				$row_delete = "";
				$row_edit = "";
				
				
				//radio button swith
				$enable_coupon = $offer->offer_status;
				$show_coupon = 	$enable_coupon == 1 ? "<label class='mt-checkbox'> <input type='checkbox' value='1' data-id ={$id} id='inSlider' class='form-control' checked><span></span></label>" : "<label class='mt-checkbox'> <input type='checkbox' value='0' data-id ={$id} id='inSlider' class='form-control'> <span></span></label>";								
				$no++;
				$row = array();
				$row[] = $no;
				$row[] = $offer->title;
				$row[] = $offer->offer_type;
				$row[] = $offer->coupon_code;
				$row[] = $show_coupon;
				$row[] = $offer->created;
				$row[] = get_user_name($offer->agent_id);
				
				if( is_admin() || is_manager() ){
					//Delete
					$row_delete = "<a href='javascript:void(0)' data-id = {$offer->id} class='btn btn-danger ajax_delete_review' title='Delete offer'><i class='fa fa-trash-o'></i></a>";
				}
			
				//edit
				$row_edit = "<a href=" . site_url("clientsection/offer_edit/{$offer->id}") . " class='btn btn-success ajax_edit_customer_table' title='Edit offer'><i class='fa fa-pencil'></i></a>";
				// View 
				$row[] = "<a href=" . site_url("clientsection/offer_view/{$offer->id}") . " title='View offer' class='btn btn-success' ><i class='fa fa-eye'></i></a>". $row_edit . $row_delete;  
				$data[] = $row;
			}
		}	
		
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->global_model->count_all_data($table, $where),
			"recordsFiltered" => $this->global_model->count_filtered($table, $where, $column_order, $column_search, $order ),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}
	
	/*********************End Reviews Section ***********************/
}	

?>