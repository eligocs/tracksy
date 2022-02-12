<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Incentive extends CI_Controller {
	
	public function __Construct(){
	   	parent::__Construct();
		validate_login();
		$this->load->model('Login_model');
	}
	public function index(){
		$user = $this->session->userdata('logged_in');
		if( $user['role'] == '99' || $user['role'] == '98' ){
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('users/incentive/index');
			$this->load->view('inc/footer');
		}else if( $user['role'] == '96' ){
			$data["role"] = $user['role'];
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('users/incentive/agent_index', $data);
			$this->load->view('inc/footer');
		}else{
			redirect("dashboard");
		}
	}
	
	//ajax request to get agent incentive
	public function ajax_check_agent_incentive(){
		$user = $this->session->userdata('logged_in');
		$uid = $user["user_id"];
		$current_month = date("Y-m");
		$return_html = "";
		$target_html = "";
		$succ = 0;
		$terms_html = "";
		$total_incentive = 0;
		$incentive_fourth_slab = 0;
		$incentive_fifth_slab = 0;
		$incentive = 0;
		$incentive_second_slab = 0;
		$total_booking = 0;
		$total_pacages_cost = 0;
		if( ($user['role'] == '99' || $user['role'] == '98'  || $user['role'] == '96' ) && isset( $_POST['datefrom'] ) ){
			$month = !empty( $_POST['datefrom'] ) ? $_POST['datefrom'] : date("Y-m");
			//check incentive session
			if( strtotime($month) <= strtotime("2019-03") ){
				$incentive_session = '2018-2019';
			}else{
				$incentive_session = '2019-2020';
			}
			
			$agent_id 	= $user['role'] == '96' && !is_teamleader() ? $uid : $this->input->post("user_id", TRUE);
			$get_booked_iti = $this->global_model->ajax_check_agent_incentive( $month, $agent_id );
			
			if( isset( $get_booked_iti[0]->iti_id ) ){
				$counter = 1;
				//$total_booking = 13;
				$total_booking = count($get_booked_iti);
				
				//INCLUDE FILE incentive file incentive_before_july_2019
				if( strtotime($month) < strtotime("2019-07") ){
					@require_once( APPPATH . "views/users/incentive/includes/incentive_before_july_2019.php");
				}else{
					@require_once( APPPATH . "views/users/incentive/includes/incentive_after_july_2019.php");
				}
				
			}else{
				$return_html .= "<tr><td colspan=13> No packages booked on Selected month </td></tr>";
			}
			
			//Check total target and incentive visit page visit by agent
			$target = get_agent_monthly_target($agent_id , $month);
			$target_html = "<strong> Target Assigned:</strong> [{$target}] <strong> Target Achieved: </strong>[{$total_booking}]";
			//TERMS AND CONDITIONS FOR GET THE INCENTIVE
			//check if agent achieved his/her target
			//$com_percentage = floor(($total_booking / $target) * 100);
			
			if( ($total_booking >= $target) && !empty( $target ) ){
				$succ = 1;
				$terms_html .= "<div class='alert alert-success'><strong>Warm Congratulation</strong> for your success in sales target achievement. Stay storng and keep going until you discover your true core of strength.</div>";
			}else{
				$diff_targ = $target - $total_booking;
				if( $month === $current_month ){
					$terms_html .= "<div class='alert alert-info'>You need to book <strong>{$diff_targ}</strong> more packages to earn your incentive.</div>";
				}else{
					$terms_html .= "<div class='alert alert-danger'> <strong>Sorry !</strong> No incentive earned this month because you haven't completed your target. </div>";
				} 
			}
			
			
			//UPDATE AGENT Visit COUNTER
			$check_data = $this->global_model->getdata("agent_targets", array("user_id" => $agent_id, "month" => $month ) );
			if(  $user['role'] == '99' ||  $user['role'] == '98' ){
				$incentive_view = isset($check_data[0]->incentive_view) && !empty( $check_data[0]->incentive_view ) ? $check_data[0]->incentive_view  : 0;
				$target_html .= "<strong class='pull-right'><span class='avss'>Agent Visit: </span> [{$incentive_view}] Times </strong>";
			}
			
			if( $user['role'] == '96' ){
				if( !is_teamleader() ){
					if( isset($check_data[0]->incentive_view ) ){
						$incentive_view = isset($check_data[0]->incentive_view) && !empty( $check_data[0]->incentive_view ) ? $check_data[0]->incentive_view  : 0;
						
						$incentive_view += 1;
						$this->global_model->update_data("agent_targets", array("user_id" => $agent_id, "month" => $month ), array( "incentive_view" => $incentive_view ) );
					}else{
						$this->global_model->insert_data("agent_targets", array("user_id" => $agent_id, "month" => $month , "target" => get_default_target() , "incentive_view" => 1 ) );
					}
				}
			}
			
			//send response
			$res = array('status' => true, 'msg' => "done", 'data' => $return_html, "target_data" => $target_html, "terms" => $terms_html, "succ" => $succ );
		}else{
			$res = array('status' => false, 'msg' => "Invalid action", 'data' => "" , "target_data" => $target_html, "terms" => $terms_html, "succ" => $succ);
		}
		die(json_encode($res));
	}
	
	//generate all agents csv
	public function export_incentive_all_agents(){
		$user = $this->session->userdata('logged_in');
		$uid = $user["user_id"];
		$total_incentive = 0;
		$incentive_fifth_slab = 0;
		if( ($user['role'] == '99' || $user['role'] == '98') && isset( $_GET['month'] ) ){
			$month = trim($_GET['month']);
			$get_booked_iti = $this->global_model->ajax_check_agent_incentive( $month );
			//check incentive session
			if( strtotime($month) <= strtotime("2019-03") ){
				$incentive_session = '2018-2019';
			}else{
				$incentive_session = '2019-2020';
			}
			
			$month_name = date("F Y", strtotime($month));
			$ex_mon_name = str_replace(" ", "_", $month_name);
			
			if( isset( $get_booked_iti[0]->iti_id ) ){
				$dataToExports = [];
				$counter = 1;
				
				//INCLUDE FILE incentive file incentive_before_july_2019
				if( strtotime($month) < strtotime("2019-07") ){
					@require_once( APPPATH . "views/users/incentive/includes/export/incentive_before_july_2019.php");
				}else{
					@require_once( APPPATH . "views/users/incentive/includes/export/incentive_after_july_2019.php");
				}
				
				die();
			}else{
				$this->session->set_flashdata('error',"No data found of {$month_name}.");
				redirect("incentive");	
			}
		}else{
			redirect(404);
		}	
	}
	
	//Export
	private function _exportExcelData($records){
		$heading = false;
		if (!empty($records)){
			foreach ($records as $row) {
				if (!$heading) {
					// display field/column names as a first row
					echo implode("\t", array_keys($row)) . "\n";
					$heading = true;
				}
				echo implode("\t", ($row)) . "\n";
			}
			return true;
		}else{
			return false;
		}	
	}
	
	//update below base price status
	public function ajax_below_base_price_updateStatus(){
		$user = $this->session->userdata('logged_in');
		$user_id = $user['user_id'];
		$id 		= $this->input->post("id", true);
		$is_below_base_price 	= $this->input->post("is_below_base_price", true);
		//check if iti status already updated
		$up_data = array( "is_below_base_price" => $is_below_base_price  );
		$update_data	= $this->global_model->update_data("iti_payment_details", array("id" => $id ), $up_data );
		
		if( $update_data ){
			$this->session->set_flashdata('success',"BBP Status Updated Successfully.");
			$res = array( "status" => true, "msg" => "BBP Status Updated Successfully." );
		}else{
			$res = array( "status" => false, "msg" => "BBP Status Not Updated. Please try again." );
		}
		die( json_encode( $res ) );
	}
	
	
	/***************************
	****AGENTS TARGET SECTION **
	***************************/
	public function agenttargets(){
		$user = $this->session->userdata('logged_in');
		if( $user['role'] == '99' || $user['role'] == '98' ){
			$month = isset( $_GET['month'] ) && !empty($_GET['month']) ? $_GET['month'] : date("Y-m");
			$data['monthly_targets'] = $this->global_model->get_agents_monthly_targets($month, $agent_id = NULL);
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('users/targets/index', $data);
			$this->load->view('inc/footer');
		}else{
			redirect("dashboard");
		}
	}
	
	//update agent target
	public function update_agenttarget(){
		$user = $this->session->userdata('logged_in');
		$user_id = $user['user_id'];
		$res = array('status' => false, 'msg' => "error" );
		if( ($user['role'] == '99' || $user['role'] == '98') && isset( $_POST['agent_id'] ) ) {
			$month = $_POST['month'];
			$target = $_POST['target'];
			$agent_id = $_POST['agent_id'];
			
			//check if month exists
			$check_data = $this->global_model->getdata("agent_targets", array("user_id" => $agent_id, "month" => $month ) );
			if( $check_data ){
				$this->global_model->update_data("agent_targets", array("user_id" => $agent_id, "month" => $month ), array("target" => $target, "target_assigned_by" => $user_id) );
				$res = array('status' => true, 'msg' => "done" );
			}else{
				$this->global_model->insert_data("agent_targets", array("user_id" => $agent_id, "month" => $month , "target" => $target, "target_assigned_by" => $user_id ) );
				$res = array('status' => true, 'msg' => "done" );
			}
			die(json_encode($res));
		}else{
			redirect("dashboard");
		}
	}
	
}
?>