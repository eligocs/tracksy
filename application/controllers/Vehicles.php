<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Vehicles extends CI_Controller {
	public function __Construct(){
	   	parent::__Construct();
		validate_login();
		$this->load->model("vehicles_model");
	}
	
	public function index(){
		$user = $this->session->userdata('logged_in');
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '97'){
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('vehicles/all_vehicles');
			$this->load->view('inc/footer');
		}else{
			redirect("dashboard");
		} 
	}
	
	/* add cab */
	public function add(){
		$user = $this->session->userdata('logged_in');
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '97'){
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('vehicles/add');
			$this->load->view('inc/footer');
		}	
	}
	
	/* Edit car Category */
	public function edit($id){
		$user = $this->session->userdata('logged_in');
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '97'){
			$where = array("del_status" => 0, 'id' => $id);
			$data['vehicles'] = $this->global_model->getdata("vehicles", $where);
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('vehicles/edit', $data);
			$this->load->view('inc/footer');
		}	
	} 
	// Transporter
	public function transporters(){
		$user = $this->session->userdata('logged_in');
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '97'){
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('vehicles/transporter_all');
			$this->load->view('inc/footer');
		}else{
			redirect("dashboard");
		} 
		
	}
	
	/* add Transporter */
	public function transporteradd(){
		$user = $this->session->userdata('logged_in');
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '97'){
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('vehicles/transporter_add');
			$this->load->view('inc/footer');
		}else{
			redirect(404);
		}	
	}
	
	/* Edit Transporter */
	public function transporterview($id){
		$user = $this->session->userdata('logged_in');
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '97'){
			$where = array("del_status" => 0, 'id' => $id);
			$data['vehicles'] = $this->global_model->getdata("transporters", $where);
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('vehicles/transporter_view', $data);
			$this->load->view('inc/footer');
		}else{
			redirect(404);
		}		
	} 
	/* Edit Transporter */
	public function transporteredit($id){
		$user = $this->session->userdata('logged_in');
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '97'){
			$where = array("del_status" => 0, 'id' => $id);
			$data['vehicles'] = $this->global_model->getdata("transporters", $where);
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('vehicles/transporter_edit', $data);
			$this->load->view('inc/footer');
		}else{
			redirect(404);
		}	
	} 
	/* data table get all Hotels */
	public function ajax_cab_list(){
		$user = $this->session->userdata('logged_in');
		$u_id = $user['user_id'];
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '97'){
			$list = $this->vehicles_model->get_datatables();
			$data = array();
			$no = $_POST['start'];
			if( !empty($list) ){
				foreach ($list as $vehicle) {
					
					$row_delete = "";
					$row1="";
					$no++;
					$row = array();
					$row[] = $no;
					$row[] = $vehicle->car_name;
					$row[] = $vehicle->max_person;
					$row[] = $vehicle->car_rate ? $vehicle->car_rate . " /-" : '';
					if( is_admin() ){
						//Delete
						$row_delete = "<a title='delete' href='javascript:void(0)' data-id = {$vehicle->id} class='btn_trash ajax_delete_cabs'><i class='fa fa-trash-o'></i></a>";
					}
					
					//edit
					$row[] = "<a title='edit' href=" . site_url("vehicles/edit/{$vehicle->id}") . " class='btn_pencil' ><i class='fa fa-pencil'></i></a>" . $row_delete;
					$data[] = $row;
					
				}
			}	
			
			$output = array(
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->vehicles_model->count_all(),
				"recordsFiltered" => $this->vehicles_model->count_filtered(),
				"data" => $data,
			);
			//output to json format
			echo json_encode($output);
		}	
	}
	
	/* data table get all Transporter */
	public function ajax_trans_list(){
		$user = $this->session->userdata('logged_in');
		$u_id = $user['user_id'];
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '97'){
			$list = $this->vehicles_model->get_datatables_trans();
			$data = array();
			$no = $_POST['start'];
			if( !empty($list) ){
				foreach ($list as $trans) {
					$row_delete = "";
					$no++;
					$row = array();
					$row[] = $no;
					$row[] = $trans->trans_name;
					$row[] = $trans->trans_email;
					$row[] = $trans->trans_contact;
					$row[] = $trans->trans_address;
					
					$car_list = $trans->trans_cars_list;
					$c = "";
					if( !empty($car_list) ){
						$clist = explode(",",$car_list);
						$co = 1;
						foreach( $clist as $cc ){
							$c .= get_car_name($cc) . ", ";
							
							if( $co == 5 ){
								$c .= "...";
								break;
							} 
							$co++;
						}
					}
					$row[] = $c;
					if( is_admin() ){
						//Delete
						$row_delete = "<a title='delete' href='javascript:void(0)' data-id = {$trans->id} class='btn_trash ajax_delete_trans'><i class='fa fa-trash-o'></i></a>";
					}
					//edit
					$edit = "<a title='edit' href=" . site_url("vehicles/transporteredit/{$trans->id}") . " class='btn_pencil' ><i class='fa fa-pencil'></i></a>";
					
					//view
					$row[] = "<a title='view' href=" . site_url("vehicles/transporterview/{$trans->id}") . " class='btn_eye' ><i class='fa fa-eye'></i></a>" . $edit . $row_delete;
					$data[] = $row;
					
				}
			}	
			
			$output = array(
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->vehicles_model->count_all_trans(),
				"recordsFiltered" => $this->vehicles_model->count_filtered_trans(),
				"data" => $data,
			);
			//output to json format
			echo json_encode($output);
		}	
	}
	
	
	//All packages listing for vehicles rates
	public function vehicle_packages(){
		$user = $this->session->userdata('logged_in');
		if( $user['role'] == '99' || $user['role'] == '98' ){
			$data['all_packages'] = $this->global_model->getdata("vehicle_package_list");
			
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('vehicles/rates/index', $data );
			$this->load->view('inc/footer');
		}else{
			redirect("dashboard");
		}
	}
	
	//add vehicle tour
	public function add_veh_package(){
		$user = $this->session->userdata('logged_in');
		if( $user['role'] == '99' || $user['role'] == '98' ){
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('vehicles/package/add');
			$this->load->view('inc/footer');
		}else{
			redirect("vehicles");
		}
	}
	
	
	//car_rates_by_tour
	public function car_rates_by_tour(){
		$user = $this->session->userdata('logged_in');
		if( $user['role'] == '99' || $user['role'] == '98' ){
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('vehicles/rates/index');
			$this->load->view('inc/footer');
		}else{
			redirect("dashboard");
		}
	}
	
	//add vehicle tour rate
	public function add_vehicle_tour_rate(){
		$user = $this->session->userdata('logged_in');
		if( $user['role'] == '99' || $user['role'] == '98' ){
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('vehicles/rates/add');
			$this->load->view('inc/footer');
		}else{
			redirect("car_rates_by_tour");
		}
	}
	
	
	
}	

?>