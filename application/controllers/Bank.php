<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Bank extends CI_Controller {
	
	public function __Construct(){
	   	parent::__Construct();
		validate_login();
		$this->load->model("bank_model");
		$this->load->library('form_validation');
	}
	
	public function index(){
		$user = $this->session->userdata('logged_in');
		$user_id = $user['user_id'];
		if( $user['role'] == '99' || is_super_manager() ) 
		{
			$data['banks'] = $this->bank_model->get_all_banks();
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('bank/bank', $data);
			$this->load->view('inc/footer');
		}
		else{
			redirect("dashboard");
		}
	}
		
	/* add Banks */
	public function add(){
		$user = $this->session->userdata('logged_in');
		if( $user['role'] == '99' || is_super_manager() ){
			$data['agent_id'] = $user['user_id'];
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('bank/addbank', $data);
			$this->load->view('inc/footer');
		}else{
			redirect("dashboard");
		}
	}
	/* save Banks */
	public function savebank(){
		$user = $this->session->userdata('logged_in');
		if( $user['role'] == '99' || is_super_manager() )
		{
 			$data['bank_name'] = strip_tags($this->input->post("inp[bank_name]"));
			$data['payee_name'] = strip_tags($this->input->post("inp[payee_name]"));
			$data['account_type'] = strip_tags($this->input->post("inp[account_type]"));
			$data['account_number'] = strip_tags($this->input->post("inp[account_number]"));
			$data['branch_address'] = strip_tags($this->input->post("inp[branch_address]"));
			$data['ifsc_code'] = strip_tags($this->input->post("inp[ifsc_code]"));
			
			/*form validation*/
			$this->form_validation->set_rules('inp[bank_name]', 'Bank Name', 'required');
			$this->form_validation->set_rules('inp[payee_name]', 'Payee Name', 'required');
			$this->form_validation->set_rules('inp[account_type]', 'Account Type', 'required');
			$this->form_validation->set_rules('inp[account_number]', 'Account Number', 'required|numeric');
			$this->form_validation->set_rules('inp[branch_address]', 'Branch Address', 'required');
			$this->form_validation->set_rules('inp[ifsc_code]', 'IFSC Code', 'required');

			if ($this->form_validation->run() == FALSE){
				$this->load->view('inc/header');
				$this->load->view('inc/sidebar');
				$this->load->view('bank/addbank', $data);
				$this->load->view('inc/footer');
			}else{
				if (isset($_POST['inp']['bank_name']) && !empty($_POST['inp']['payee_name'])) {
					$inp = $this->input->post('inp', TRUE);
					$ac_no = $_POST['inp']['account_number'];
					
					$unique_ac = $this->bank_model->isAccountNumber($ac_no);					
					if( $unique_ac ){
						$this->session->set_flashdata('error',"Account Number Already Exists.");
						redirect("bank/add");
					}else{
						$bank_id = $this->bank_model->insert_bank("bank_details", $inp);
						if( $bank_id ){
							$this->session->set_flashdata('success',"Bank added successfully.");
							redirect("bank");
						}else{
							$this->session->set_flashdata('error',"Bank not added successfully.");
							redirect("bank/add");
						}
					}	
				}else{
					redirect("bank/add");
				}
			}
		}	
	}
	
	/* Edit Bank */
	 public function edit($bank_id = '' ){
		$user = $this->session->userdata('logged_in');
		$user_id = $user['user_id'];

		if( $user['role'] == '99' || is_super_manager() ){
			$data['banks'] = $this->bank_model->get_bank( $bank_id );
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('bank/editbank', $data);
			$this->load->view('inc/footer');
		}
		else
		{	
			redirect("bank/add");
		}
	} 


	public function editbank(){
		$user = $this->session->userdata('logged_in');
		if( $user['role'] == '99' || is_super_manager() ){
			if (isset($_POST['inp']['bank_name']) && !empty($_POST['inp']['payee_name'])) {
				$id = $this->input->post("bank_id");
				
				$inp = $this->input->post('inp', TRUE);
				$result = $this->bank_model->update_bank($id ,"bank_details", $inp);
				if( $result ){
					$this->session->set_flashdata('success',"Bank edit successfully.");
					redirect("bank");
				}else{
					$this->session->set_flashdata('error',"Bank not edit successfully.");
					redirect("bank/edit");
				}
			}else{
				redirect("bank/edit");
			}
			
		}	
	}

	/*edit and save Banks*/
	
}	

?>