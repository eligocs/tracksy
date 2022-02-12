<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Purchaseleads extends CI_Controller {
	public function __Construct(){
	   	parent::__Construct();
		validate_login();
		$this->load->model("purchase_model");
		$this->load->library('form_validation');
	}
	public function index(){
		$user = $this->session->userdata('logged_in');
		$user_id = $user['user_id'];
		$data['user_role'] = $user['role'];
	
		
		if( $user['role'] == '95' ) {
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('customers/allpurchaseleads', $data);
			$this->load->view('inc/footer');
		}/* elseif( $user['role'] == '95' ){
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('customers/declined_customers', $data);
			$this->load->view('inc/footer'); 
		} */else{
			redirect("dashboard");
		}
	}
	/* add Customer */
	public function add(){
		$user = $this->session->userdata('logged_in');
		if( $user['role'] == '95'){
			$data['agent_id'] = $user['user_id'];
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('customers/addpurchaselead', $data);
			$this->load->view('inc/footer');
		}else{
			redirect("dashboard");
		}
	}
	/* save Lead */
	public function saveleads(){
			$user = $this->session->userdata('logged_in');

			$this->form_validation->set_rules('c_name', 'Customer Name', 'required');
			$this->form_validation->set_rules('c_number', 'Contact Number', 'required|numeric|min_length[8]|max_length[20]');
			$this->form_validation->set_rules('c_email', 'Email', 'valid_email|required');
			
			if ($this->form_validation->run() == FALSE){
				$this->load->view('inc/header');
				$this->load->view('inc/sidebar');
				$this->load->view('customers/addpurchaselead');
				$this->load->view('inc/footer');
			}
			else{ 
				$name    =  $this->input->post("c_name");
				$email   =  $this->input->post("c_email");
				$con_no  =  $this->input->post("c_number");
				$agentId =   $user['user_id'];
	
				$data['c_name']=$name;
				$data['c_contact']=$con_no;
				$data['c_email']=$email;
				$data['agent_id']=$agentId;
			if ($this->db->insert("purchase_leads", $data)) {
				//$result = $this->db->insert_id();
				$result = true;
				$this->session->set_flashdata('success','Lead added !');
	
				redirect("purchaseleads");
				} 
			else{
					$result = false;
				}
				return $result;
			}
		}
/* data table get all agents */
	public function ajax_list(){
		$list = $this->purchase_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
		
        foreach ($list as $customer) {
            $row = array();
			
            $row[] = $customer->id;
            $row[] = $customer->c_name;
            $row[] = $customer->c_email;
            $row[] = $customer->c_contact;
            $row[] = $customer->created;
			$btn = "<a title='edit' href=" . site_url("purchaseleads/editlead/{$customer->id}") . " class='btn btn-success ajax_edit_user_table' ><i class='fa fa-pencil'></i></a>"; 
			$view = "<a title='view' href=" . site_url("purchaseleads/viewlead/{$customer->id}") . " class='btn btn-success' ><i class='fa fa-eye'></i></a>"; 
			$row[] = $btn . $view;
			           
            $data[] = $row;
        }
 
        $output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->purchase_model->count_all(),
			"recordsFiltered" => $this->purchase_model->count_filtered(),
			"data" => $data,
        );
		
        //output to json format
        echo json_encode($output);
    }

	public function editlead($id){
		$user = $this->session->userdata('logged_in');
			if( $user['role'] == '95'){
			$data['user'] = $this->purchase_model->get_user_by_id($id);
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$data['id'] = $id; 
			$this->load->view('customers/editlead', $data);
			$this->load->view('inc/footer');
			}
			else{
			redirect("dashboard");
			}
		}
	//Update  user
	public function update_lead($id){
			$user = $this->session->userdata('logged_in');

			$this->form_validation->set_rules('c_name', 'Customer Name', 'required');
			$this->form_validation->set_rules('c_number', 'Contact Number', 'required|numeric|min_length[8]|max_length[20]');
			$this->form_validation->set_rules('c_email', 'Email', 'valid_email|required');
			
			if ($this->form_validation->run() == FALSE){
				$this->load->view('inc/header');
				$this->load->view('inc/sidebar');
				$this->load->view('customers/addpurchaselead');
				$this->load->view('inc/footer');
			}
			else{ 
				$name    =  $this->input->post("c_name");
				$email   =  $this->input->post("c_email");
				$con_no  =  $this->input->post("c_number");
		        $agentId =   $user['user_id'];

	
				$data['c_name']=$name;
				$data['c_contact']=$con_no;
				$data['c_email']=$email;
				$data['agent_id']=$agentId;
				
        if ($this->db->where('id' , $id )->update("purchase_leads", $data)) {
            //$result = $this->db->insert_id();
			$result = true;
			
			$this->session->set_flashdata('success','User details has been Updated !');
			
			redirect("purchaseleads");
        } 
		else {
            $result = false;
			}
        return $result;
		}
	}
	public function viewlead($id){
	$user = $this->session->userdata('logged_in');
		if( $user['role'] == '95'){
		$data['customer'] = $this->purchase_model->get_user_by_id($id);
		$this->load->view('inc/header');
		$this->load->view('inc/sidebar');
		$data['id'] = $id; 
		$this->load->view('customers/view_lead', $data);
		$this->load->view('inc/footer');
		}
		else{
		redirect("dashboard");
		}
	}

		
}
	
?>