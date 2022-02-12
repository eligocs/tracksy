<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Terms extends CI_Controller {
	
	public function __Construct(){
	   	parent::__Construct();
		validate_login();
		$this->load->model("terms_model");
		$this->load->library('form_validation');
	}
	
	//Itinerary Terms
	public function index(){
		$user = $this->session->userdata('logged_in');
		$user_id = $user['user_id'];
		if( $user['role'] == '99' || is_super_manager() ){
			//$data['terms'] = $this->terms_model->getTermsData();
		/* 	$where = array( "term_type" => "itinerary" );
			$data['terms'] = $this->global_model->getdata("terms", $where);
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('terms/itinerary_terms',$data);
			$this->load->view('inc/footer'); */
			$where = array( "term_type" => "itinerary" );
			$data['terms'] = $this->global_model->getdata("terms", $where);
			$data['term_type'] = "itinerary";
			$data["page_heading"] = "Holiday Terms";
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('terms/iti_hotel_cab_terms',$data);
			$this->load->view('inc/footer');
			
		}else{
			redirect("dashboard");
		}
	}
	
	//hotel terms
	public function hotel_terms(){
		$user = $this->session->userdata('logged_in');
		$user_id = $user['user_id'];
		if( $user['role'] == '99' || is_super_manager() ){
			$where = array( "term_type" => "hotel" );
			$data['terms'] = $this->global_model->getdata("terms", $where);
			$data['term_type'] = "hotel";
			$data["page_heading"] = "Hotel Terms";
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('terms/iti_hotel_cab_terms',$data);
			$this->load->view('inc/footer');
		}else{
			redirect("dashboard");
		}
	}
	//update hotel terms
	public function ajax_update_hotel_terms_data(){
		$id 						= $this->security->xss_clean($this->input->post('term_id'));
		$type 						= strip_tags( $this->security->xss_clean($this->input->post('type')) );
		$term_type					= strip_tags( $this->security->xss_clean($this->input->post('term_type')) );
		$greeting 					= strip_tags($this->input->post('greeting_message'));
		$promotion_signature		= htmlspecialchars($this->input->post('promotion_signature'));
		$group_terms_condition 		= serialize($this->input->post('group_terms_condition'));
		$cancel_content 			= serialize($this->input->post('group_cancel_terms'));
		$group_book_pacakge_terms 	= serialize($this->input->post('group_book_pacakge_terms'));
		$group_pro_advance_pay 		= serialize($this->input->post('group_pro_advance_pay'));
		$group_amend_terms 			= serialize($this->input->post('group_amendment_policy_terms'));
		$group_bankPay_condition 	= serialize($this->input->post('group_bankPay_condition'));
		$hotel_exc 			 		= serialize($this->input->post('group_hotel_exc'));
		$hotel_notes 		 		= serialize($this->input->post('group_hotel_notes'));
		$rates_dates_notes 	 		= serialize($this->input->post('group_hotel_rates_notes'));
		$payment_policy 	 		= serialize($this->input->post('payment_policy'));
		$booking_benefits_terms 	=  isset( $_POST['booking_benefits_terms'] ) ? serialize($this->input->post('booking_benefits_terms')) : NULL;
		
		//data
		$data = array(
			"greeting_message"				=> $greeting,
			"promotion_signature"			=> $promotion_signature,
			"terms_content"					=> $group_terms_condition,
			"cancel_content"				=> $cancel_content,
			"book_package"					=> $group_book_pacakge_terms,
			"advance_payment_terms"			=> $group_pro_advance_pay,
			"amendment_policy"				=> $group_amend_terms,
			"bank_payment_terms_content"	=> $group_bankPay_condition,
			'hotel_exclusion'				=> $hotel_exc,
			'hotel_notes'		 			=> $hotel_notes,
			'rates_dates_notes'  			=> $rates_dates_notes,
			'payment_policy'  				=> $payment_policy,
			'booking_benefits_terms'  		=> $booking_benefits_terms,
		);

		$where = array( 'term_id' => $id );
		$result = $this->terms_model->update_data("terms", $type, $where, $data);
		if( $result){
			$res = array('status' => true, 'msg' => "Terms is updated Successfully!");
		}else{
			$res = array('status' => false, 'msg' => "Please Try Again ! cannot be updated");
		}
		die(json_encode($res));
	}
	
	//hotel terms
	public function cab_terms(){
		$user = $this->session->userdata('logged_in');
		$user_id = $user['user_id'];
		if( $user['role'] == '99' || is_super_manager() ){
			$where = array( "term_type" => "cab" );
			$data['terms'] = $this->global_model->getdata("terms", $where);
			$data['term_type'] = "cab";
			$data["page_heading"] = "Cab Booking Terms";
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('terms/iti_hotel_cab_terms',$data);
			$this->load->view('inc/footer');
		}else{
			redirect("dashboard");
		}
	}
	
	//Office Address
	public function office_branches(){
		$user = $this->session->userdata('logged_in');
		$user_id = $user['user_id'];
		if( $user['role'] == '99' || is_super_manager() ){
			$where = array("del_status" => 0);
			$data['branches'] = $this->global_model->getdata( "office_branches", $where );
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('office_branches/office_branches', $data);
			$this->load->view('inc/footer');
		}
		else{
			redirect("dashboard");
		}
	}
	/* add office branch */
	public function add_branch(){
		$user = $this->session->userdata('logged_in');
		if( $user['role'] == '99' || is_super_manager() ){
			$data['agent_id'] = $user['user_id'];
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('office_branches/addbranch', $data);
			$this->load->view('inc/footer');
		}else{
			redirect("dashboard");
		}
	}
	
	/* Edit office branch */
	public function edit_branch(){
		$user = $this->session->userdata('logged_in');
		if( $user['role'] == '99' || is_super_manager() ){
			$branch_id = trim($this->uri->segment(3));
			$where = array( "del_status" => 0, "branch_id" => $branch_id );
			$get_brach = $this->global_model->getdata( "office_branches", $where );
			$data["branch_data"] = $get_brach;
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('office_branches/editbranch', $data);
			$this->load->view('inc/footer');
		}else{
			redirect("dashboard");
		}
	}
	
	/* add office branch */
	public function ajax_add_office_branches(){
		$user = $this->session->userdata('logged_in');
		if( $user['role'] == '99' || is_super_manager() ){
			if (isset($_POST['inp']['branch_name']) && !empty($_POST['inp']['branch_name'])) {
				$branch_name = $_POST['inp']['branch_name'];
				$inp = $this->input->post('inp', TRUE);
				$branch_id = $this->global_model->insert_data("office_branches", $inp);
				if( $branch_id){
					$res = array('status' => true, 'msg' => "Branch Add Successfully");
				}else{
					$res = array('status' => false, 'msg' => "Error! please try again later");
				}
				die(json_encode($res));
			}else{
				$res = array('status' => false, 'msg' => "Error! All fields are required!");
				die(json_encode($res));
			}
		}else{
			redirect("dashboard");
		}
	}
	/* add office branch */
	public function ajax_edit_office_branches(){
		$user = $this->session->userdata('logged_in');
		if( $user['role'] == '99' || is_super_manager() ){
			if (isset($_POST['inp']['branch_name']) && !empty($_POST['inp']['branch_name'])) {
				$branch_id = $_POST['branch_id'];				
				$head_office = $_POST['inp']['head_office'];
				//check if head office already assign
		 		if( $head_office == 1 ){
					$wh = array('del_status' => 0, 'branch_id !=' => $branch_id, "head_office" => 1 );
					$g_branch = $this->global_model->getdata("office_branches", $wh);
					
					if( !empty($g_branch ) ){
						$res = array('status' => false, 'msg' => "Head office already assign to another address! Please remove this as head office first.");
						die(json_encode($res));
					}
				}  
				
				$inp = $this->input->post('inp', TRUE);
				$where = array("branch_id" => $branch_id, "del_status" => 0 );
				$update_data = $this->global_model->update_data("office_branches", $where, $inp );
				if( $update_data){
					$res = array('status' => true, 'msg' => "Branch Edit Successfully" );
				}else{
					$res = array('status' => false, 'msg' => "Error! please try again later");
				}
				die(json_encode($res));
			}else{
				$res = array('status' => false, 'msg' => "Error! All fields are required!");
				die(json_encode($res));
			}
		}else{
			redirect("dashboard");
		}
	}
	/* Delete office branch */
	public function branch_delete(){
		$id = $this->input->get('id', TRUE);
		$where = array("branch_id" => $id);
		$result = $this->global_model->update_del_status("office_branches", $where);
		if( $result){
			$res = array('status' => true, 'msg' => "Branch delete Successfully!");
		}else{
			$res = array('status' => false, 'msg' => "Error! please try again later");
		}
		die(json_encode($res));
	}
	//update greeting ajax
	public function ajax_greeting(){
		$type = strip_tags($this->security->xss_clean($this->input->post('type')));
		$data = array('greeting_message' => strip_tags($this->input->post('greeting_message')));
		$id = $this->security->xss_clean($this->input->post('term_id'));
		$where = array( 'term_id' => $id );
		$result = $this->terms_model->update_data("terms", $type, $where, $data);
		if( $result){
			$res = array('status' => true, 'msg' => " Greeting is updated Successfully!");
		}else{
			$res = array('status' => false, 'msg' => "Please Try Again ! cannot be updated");
		}
		die(json_encode($res));
	}
	
	//update disclaimer
	public function ajax_signature(){
		$type = $this->security->xss_clean($this->input->post('type'));
		$data = array('promotion_signature' => htmlspecialchars($this->input->post('promotion_signature')));
		$id = $this->security->xss_clean($this->input->post('term_id'));
		$where = array( 'term_id' => $id );
		$result = $this->terms_model->update_data("terms", $type, $where, $data);
		
		if( $result){
			$res = array('status' => true, 'msg' => "Promotion Signature is updated Successfully!");
		}else{
			$res = array('status' => false, 'msg' => "Please Try Again ! cannot be updated");
		}
		die(json_encode($res));
	}
	
	//update terms and condition
	public function ajax_termscondition(){
		$type = $this->security->xss_clean($this->input->post('type'));
		$group_terms_condition 	= serialize($this->input->post('group_terms_condition'));
		$data = array('terms_content' => $group_terms_condition);
		
		$id = $this->security->xss_clean($this->input->post('term_id'));
		$where = array( 'term_id' => $id );
		$result = $this->terms_model->update_data("terms", $type, $where, $data);
		
		if( $result){
			$res = array('status' => true, 'msg' => " terms is updated Successfully!");
		}else{
			$res = array('status' => false, 'msg' => "Please Try Again ! cannot be updated");
		}
		die(json_encode($res));
	}
	
	//update bank cancelpolicy
	public function ajax_bankcancelpolicy(){
		$type = $this->security->xss_clean($this->input->post('type'));
		$id = $this->security->xss_clean($this->input->post('term_id'));
		$cancel_content 	= serialize($this->input->post('group_cancel_terms'));
		$data = array('cancel_content' => $cancel_content);
		
		$where = array( 'term_id' => $id );
		$result = $this->terms_model->update_data("terms", $type, $where, $data);
		
		if( $result){
			$res = array('status' => true, 'msg' => "cancelpolicy is updated Successfully!");
		}else{
			$res = array('status' => false, 'msg' => "Please Try Again ! cannot be updated");
		}
		die(json_encode($res));
	}
	
	//update How to book terms
	public function ajax_book_package_term(){
		$type = $this->security->xss_clean($this->input->post('type'));
		$group_book_pacakge_terms 	= serialize($this->input->post('group_book_pacakge_terms'));
		$group_pro_advance_pay 	= serialize($this->input->post('group_pro_advance_pay'));
		$data = array('book_package' => $group_book_pacakge_terms, 'advance_payment_terms' => $group_pro_advance_pay);
		
		$id = $this->security->xss_clean($this->input->post('term_id'));
		$where = array( 'term_id' => $id );
		$result = $this->terms_model->update_data("terms", $type, $where, $data);
		if( $result){
			$res = array('status' => true, 'msg' => "Book Package term is updated Successfully!");
		}else{
			$res = array('status' => false, 'msg' => "Please Try Again ! cannot be updated");
		}
		die(json_encode($res));
	}
	
	//update Amendment terms
	public function ajax_UpdateAmendment_term(){
		$type = $this->security->xss_clean($this->input->post('type'));
		
		$group_amend_terms 	= serialize($this->input->post('group_amendment_policy_terms'));
		$data = array('amendment_policy' => $group_amend_terms);
		
		$id = $this->security->xss_clean($this->input->post('term_id'));
		$where = array( 'term_id' => $id );
		$result = $this->terms_model->update_data("terms", $type, $where, $data);
		
		if( $result){
			$res = array('status' => true, 'msg' => "Amendment terms is updated Successfully!");
		}else{
			$res = array('status' => false, 'msg' => "Please Try Again ! cannot be updated");
		}
		die(json_encode($res));
	}
	
	
	//update bank Bank term update
	public function ajax_banktermsUpdate(){
		$type = $this->security->xss_clean($this->input->post('type'));
		$group_bankPay_condition 	= serialize($this->input->post('group_bankPay_condition'));
		$data = array('bank_payment_terms_content' => $group_bankPay_condition);
		
		$id = $this->security->xss_clean($this->input->post('term_id'));
		$where = array( 'term_id' => $id );
		$result = $this->terms_model->update_data("terms", $type, $where, $data);
		
		if( $result){
			$res = array('status' => true, 'msg' => "Bank terms is updated Successfully!");
		}else{
			$res = array('status' => false, 'msg' => "Please Try Again ! cannot be updated");
		}
		die(json_encode($res));
	}
	
	//update exclusion
	public function ajax_hotel_exclusion_update(){
		$type = $this->security->xss_clean($this->input->post('type'));
		
		$hotel_exc 			 = serialize($this->input->post('group_hotel_exc'));
		$hotel_notes 		 = serialize($this->input->post('group_hotel_notes'));
		$rates_dates_notes 	 = serialize($this->input->post('group_hotel_rates_notes'));
		
		$data = array(
			'hotel_exclusion'	 => $hotel_exc,
			'hotel_notes'		 => $hotel_notes,
			'rates_dates_notes'  => $rates_dates_notes
		);
		
		/* $res = array('status' => false, 'msg' => "Hotel exclusion is updated Successfully! $data");
		die(json_encode($res)); */
		$id = $this->security->xss_clean($this->input->post('term_id'));
		$where = array( 'term_id' => $id );
		$result = $this->terms_model->update_data("terms", $type, $where, $data);
		
		if( $result){
			$res = array('status' => true, 'msg' => "Hotel exclusion is updated Successfully!");
		}else{
			$res = array('status' => false, 'msg' => "Please Try Again ! cannot be updated");
		}
		die(json_encode($res));
	}
	
}	

?>