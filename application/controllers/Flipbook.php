<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Flipbook extends CI_Controller {
	public function __Construct(){
	   	parent::__Construct();
		$this->load->model('Global_model');
		}
	//Add Promotion View
	public function index(){
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('flipbook/flipbook');
			$this->load->view('inc/footer');
		}
	// Promotion Add & edit	
    public function add($id=0){
	   if(empty($id)){
		   	$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('flipbook/flipbook');
			$this->load->view('inc/footer');
}
	   else{
			$tablename = 'promotion_details'; 
			$where = array('id'=>$id);
			$data['id'] = $id;
			$data['pro'] = $this->global_model->getdata($tablename,$where);
	   		$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('flipbook/flipbook',$data);
			$this->load->view('inc/footer');
			}
		}		
	//Add Promotion to data
	public function add_promotion(){
		if(isset($_POST['promotion_name']) && !empty($_POST['promotion_name'])){
			$c_name=$_POST['city'];
			$state=$_POST['state'];
			$area=$_POST['place'];
			$p_name=$_POST['promotion_name'];
			$rand = getTokenKey(8); 
						$date = date("Ymd"); 
						$time = time(); 
			$unique_key = $rand . "_" . $date . "_" . $time; 
			$insdata= array('area'=>$area,
					'city'=>$c_name,
					'state'=>$state,
					'promotion_name'=>$p_name,
					'tmp_key'=>$unique_key,
				);
			$result = $this->db->insert("promotion_details", $insdata);
			$this->session->set_flashdata('success',"Promotion Added successfully.");
				redirect('flipbook/promotion');}
		else{
			$this->session->set_flashdata('error',"Unable To Add Promotion.");
			redirect('flipbook/add_promotion');
			}
		}
	//Promotion List Index
	public function promotion(){
		$user = $this->session->userdata('logged_in');
		$user_id = $user['user_id'];
		$role = $user['role'] ;
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '96'){
			$tablename = 'promotion_details'; 
			$data['promo'] =	$this->global_model->getdata($tablename);
			$data['user_role'] = $role;
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('flipbook/promotionIndex',$data);
			$this->load->view('inc/footer');
		}
	}
	//Promotion View List
	public function view($id){
		$user = $this->session->userdata('logged_in');
		$user_id = $user['user_id'];
		$role = $user['role'] ;
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '96'){
			$tablename = 'promotion_details'; 
			$where = array('id'=>$id);
			$data['promotion'] =	$this->global_model->getdata($tablename,$where);
			$data['pages'] = $this->global_model->getdata('promotion_pages',array('promotion_id'=>$id));
			$data['user_role'] = $role;
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('flipbook/viewPromotion',$data);
			$this->load->view('inc/footer');
		}
	}
	//Add Promotion Page View
	public function addPages($id){
			$data['id'] = $id;
			
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('flipbook/page',$data);
			$this->load->view('inc/footer');
	}
			
	//$NEW Flipboomk Images
	public function do_upload(){
		$data = $_POST['image'];
		$title = $_POST['title'];
		$promoId = $_POST['pid'];
		
			$nameP = get_promo_name($promoId);
			$proName = str_replace(' ','_',$nameP);
		
		list($type, $data) = explode(';', $data);
		list(, $data)      = explode(',', $data);
		
		
		$data = base64_decode($data);
		$imageName = $proName.time().'.'.'jpg';
		file_put_contents('site/images/promotions/'.$imageName, $data);
		$insdata= array(
							'promotion_id'=>$promoId,
							'page_type'=>0,
							'page_title'=>$title,
							'content'=>$imageName,
							);
			$result = $this->db->insert("promotion_pages", $insdata); 
		if($result){
				$this->session->set_flashdata('success',"Slide Added successfully.");
				echo 'success';
		}
		else{
			echo '<div class="alert alert-danger"><strong>Error: </strong>Something went wrong. Please try again later.</div>';
			}
			die();
	}
	
	//Edit Flipboomk Images
	public function do_upload_edit(){
		$data = $_POST['image'];
		$title = $_POST['title'];
		$id = $_POST['pgId'];
		$proId = $_POST['proId'];
		
		$nameP = get_promo_name($proId);
		$proName = str_replace(' ','_',$nameP);
		
		list($type, $data) = explode(';', $data);
		list(, $data)      = explode(',', $data);
		
		
		$data = base64_decode($data);
		$imageName = $proName.time().'.'.'jpg';
		file_put_contents('site/images/promotions/'.$imageName, $data);
		$insdata= array(
							'promotion_id'=>$proId,
							'page_type'=>0,
							'page_title'=>$title,
							'content'=>$imageName,
							);
			$where = array('id'=>$id);
			$result = $this->global_model->update_data("promotion_pages",$where, $insdata); 
		if($result){
				$this->session->set_flashdata('success',"Slide Added successfully.");
				echo 'success';
		}
		else{
			echo '<div class="alert alert-danger"><strong>Error: </strong>Something went wrong. Please try again later.</div>';
			}
			die();
	}
	
	//Add Page Image 
	public function addImage(){
			$title = $_POST['title'];
			$promoId = $_POST['promotion_id'];
			$type = 0;
			$nameP = get_promo_name($promoId);
			$proName = str_replace(' ','_',$nameP); 
			$data = $_POST['image'];
		
		
		list($type, $data) = explode(';', $data);
		list(, $data)      = explode(',', $data);
		
		
		$data = base64_decode($data);

			$file_name = $_FILES['files']['name'];
			$file_size =$_FILES['files']['size'];
			$file_tmp =$_FILES['files']['tmp_name'];
			$file_type=$_FILES['files']['type'];
			$ext = pathinfo($file_name, PATHINFO_EXTENSION);
			$imageName = $proName.time().'.'.$ext;
			$dir = "site/images/promotions/";
			$uploadfile = $dir . basename($imageName);
		if(is_dir($dir)==false){
				mkdir($dir, 0700);
				move_uploaded_file($file_tmp, $uploadfile);}
		else{
			move_uploaded_file($file_tmp, $uploadfile);
		}
			$insdata= array(
							'promotion_id'=>$promoId,
							'page_type'=>$type,
							'page_title'=>$title,
							'content'=>$imageName,
							);
			$result = $this->db->insert("promotion_pages", $insdata); 
		if($result){
				$this->session->set_flashdata('success',"Image Added successfully.");
				redirect($_SERVER['HTTP_REFERER']);}
		else{
			$this->session->set_flashdata('error',"Unable To Add Image.");
			redirect($_SERVER['HTTP_REFERER']);
				}
	}
	//Insert Text to Page
	public function addText(){
			$title = $_POST['page_title'];
			$promoId = $_POST['promotion_id'];
			$type = $_POST['page_type'];
			$content = $_POST['content'];
		if(isset($_POST["submit"]) && !empty($promoId)){ 
			$insdata= array(
							'promotion_id'=>$promoId,
							'page_type'=>$type,
							'page_title'=>$title,
							'content'=>$content,
							);
			$result = $this->db->insert("promotion_pages", $insdata);
			$this->session->set_flashdata('success',"Text Added successfully.");
				redirect("flipbook/view/$promoId");
				}
		else{
			$this->session->set_flashdata('error',"Unable To Update Text successfully.");
			redirect($_SERVER['HTTP_REFERER']);
			} 
		}
	//Order Promotion Pages 		
	public function order(){
		$tablename = 'promotion_pages'; 
		if(isset($_POST["submit"])){
			for ($i = 0; $i < count($_POST['pageId']); $i++) {
			$p = $_POST['pageId'][$i];
			$o = $_POST['order'][$i];
			$where = array('id'=>$p);
			$data  = array('p_order' => $o);
			$update = $this->global_model->update_data($tablename, $where, $data  );
			}
			$this->session->set_flashdata('success',"Order Update successfully.");
				redirect($_SERVER['HTTP_REFERER']);
			}
		else{
			$this->session->set_flashdata('error',"Unable To Update Order successfully.");
			redirect($_SERVER['HTTP_REFERER']);
			}
		}
	//Manage Pages View Add/del
	public function managePages($id){
		$user = $this->session->userdata('logged_in');
		$user_id = $user['user_id'];
		$role = $user['role'] ;
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '96'){
			$tablename = 'promotion_details'; 
			$where = array('id'=>$id);
			$data['promotion'] =	$this->global_model->getdata($tablename,$where);
			
			$data['pages'] = $this->global_model->getdata('promotion_pages',array('promotion_id'=>$id));
			$data['user_role'] = $role;
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('flipbook/managePages',$data);
			$this->load->view('inc/footer');
		}
	}
	//Delete Promotion
	public function deletePromo($id=0){
		if($id){
			$where = array('id'=>$id);
			$page = array('promotion_id'=>$id);
			$table = 'promotion_details';
			$tab   = 'promotion_pages';
			$delete = $this->global_model->delete_data($table, $where);
			$deletePages = $this->global_model->delete_data($tab,$page);
		if($delete){	
				$this->session->set_flashdata('success',"Promotion Deleted successfully.");
				redirect($_SERVER['HTTP_REFERER']);
				}
		else{
			$this->session->set_flashdata('error',"Unable To Delete Promotion successfully.");
			redirect($_SERVER['HTTP_REFERER']);
			}
		   }
		else{
			echo '404';
			}
		}
	//View FlipBook
	public function viewpromotion($id,$key){
		$qry = $this->db->select('tmp_key')->from('promotion_details')->where("id", $id)->get();
		$kk = $qry->result();
		$tmpkey = $kk[0]->tmp_key; 
	 if($tmpkey == $key){
		$this->db->select('*')->from('promotion_pages')->where("promotion_id", $id)->order_by('p_order','asc');
		$query = $this->db->get();
		$result = $query->result();
		$data['images']= $result; 
		$this->load->view('flipbook/test',$data);
		}
	else{
		$this->session->set_flashdata('error',"key Didn't matched.");
		redirect($_SERVER['HTTP_REFERER']);
		}
	}
	//Order Page Ajax
	public function orderr(){
		$data['sortable'] = TRUE;
		$this->load->view('inc/header');
		$this->load->view('inc/sidebar');
		$this->load->view('flipbook/order',$data);
		$this->load->view('inc/footer');
	}
	//Order Page Ajax
	public function orderajax(){
	  if(isset($_POST['id'])){
		$id = $_POST['id'];}
	  if(isset($_POST['sortable'])){
		$pages = $_POST['sortable'];
	  if(count($pages)){
		foreach ($pages as $order => $page){
			$pg = explode('_', $page);
			$p = $pg[1];
		  if ($page != ''){
				$tablename = 'promotion_pages';
				$where = array('id'=>$p);
				$data  = array('p_order' => $order);
				$update = $this->global_model->update_data($tablename, $where, $data);
			  }
			}
          }
	    }
		$pg = $this->db->select('*')->from('promotion_pages')->where('promotion_id',$id)->order_by('p_order')->get();
		$data['pages'] = $pg->result_array();
		$this->load->view('flipbook/order_ajax',$data);
	}
	//View Individual Page
	public function viewPage($id){
		$pg = $this->db->select('*')->from('promotion_pages')->where('id',$id)->get();
		$page = $pg->result();
		$data['page'] =$pg->result();
		$type = $page[0]->page_type;
	 if($type ==0 ){
		$this->load->view('inc/header');
		$this->load->view('inc/sidebar');
		$this->load->view('flipbook/viewImage',$data);
		$this->load->view('inc/footer');
		 } 
	else{
		$this->load->view('inc/header');
		$this->load->view('inc/sidebar');
		$this->load->view('flipbook/viewText',$data);
		$this->load->view('inc/footer');
		}			
	}
	//Edit Single Page 
	public function editPage($id){
		$pg = $this->db->select('*')->from('promotion_pages')->where('id',$id)->get();
		$page = $pg->result();
		$data['page'] =$pg->result();
		$type = $page[0]->page_type;
	 if($type ==0 ){
		$this->load->view('inc/header');
		$this->load->view('inc/sidebar');
		$this->load->view('flipbook/editImage',$data);
		$this->load->view('inc/footer');
		} 
	else{
		$this->load->view('inc/header');
		$this->load->view('inc/sidebar');
		$this->load->view('flipbook/editText',$data);
		$this->load->view('inc/footer');
		}			
	}
	//Edit Pages Text
	public function editText(){
		$title = $_POST['page_title'];
		$pageId = $_POST['pageId'];
		$type = $_POST['page_type'];
		$content = $_POST['content'];
	if(isset($_POST["submit"])){ 
		$data= array(
					'page_title'=>$title,
					'content'=>$content,
					);
		$tablename ='promotion_pages';
		$where = array('id'=>$pageId);
		$result =$this->global_model->update_data($tablename,$where,$data);
		$this->session->set_flashdata('success',"Text Updated successfully.");
		redirect($_SERVER['HTTP_REFERER']);
		}
	else{
		$this->session->set_flashdata('error',"Unable To Update Text successfully.");
		redirect($_SERVER['HTTP_REFERER']);
		} 
	}
	//Edit Image In PAge
	public function editImage(){
			$title = $_POST['title'];
			$pID = $_POST['pageId'];
			$nameP = $_POST['proName'];
			
			$proName = str_replace(' ','_',$nameP);
			$file_name = $_FILES['files']['name'];
			$file_size =$_FILES['files']['size'];
			$file_tmp =$_FILES['files']['tmp_name'];
			$file_type=$_FILES['files']['type'];
			$ext = pathinfo($file_name, PATHINFO_EXTENSION);
			$imageName = $proName.time().'.'.$ext;
			$dir = "site/images/promotions/";
			$uploadfile = $dir . basename($imageName);
		 if(is_dir($dir)==false){
			mkdir($dir, 0700);
			move_uploaded_file($file_tmp, $uploadfile);
			}
		else{
			move_uploaded_file($file_tmp, $uploadfile);
			}
			$updatedata= array(
						'page_title'=>$title,
						'content'=>$imageName,
						);
			$where = array('id'=>$pID); 		
			$result =$this->global_model->update_data('promotion_pages',$where,$updatedata);
		if($result){
			$this->session->set_flashdata('success',"Image Added successfully.");
			redirect($_SERVER['HTTP_REFERER']);
			}
		else{
			$this->session->set_flashdata('error',"Unable To Add Image.");
			redirect($_SERVER['HTTP_REFERER']);
			}
		}
//delete Pages
	public function deletePage($id){
		$where = array('id'=>$id); 		
		$result =$this->global_model->delete_data('promotion_pages',$where);
		//dump($result);die;
		if($result){
		$this->session->set_flashdata('success',"Page Deleted successfully.");
			redirect($_SERVER['HTTP_REFERER']);
			}
		else{
			$this->session->set_flashdata('error',"Unable To delete page.");
			redirect($_SERVER['HTTP_REFERER']);
			}
		}
		//steve job s?
		public function steveJob(){
			$this->load->view('flipbook/steve/index');
		}
	
	
}
	?>