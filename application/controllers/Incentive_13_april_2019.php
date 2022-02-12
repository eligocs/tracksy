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
		$return_html = "";
		$target_html = "";
		$succ = 0;
		$terms_html = "";
		$total_incentive = 0;
		$incentive_fourth_slab = 0;
		if( ($user['role'] == '99' || $user['role'] == '98'  || $user['role'] == '96' ) && isset( $_POST['datefrom'] ) ){
			$month 		= !empty( $_POST['datefrom'] ) ? $_POST['datefrom'] : date("Y-m");
			$current_month = date("Y-m");
			$agent_id 	= $user['role'] == '96' && !is_teamleader() ? $uid : $this->input->post("user_id", TRUE);
			$get_booked_iti = $this->global_model->ajax_check_agent_incentive( $month, $agent_id );
			
			$total_booking = 0;
			if( isset( $get_booked_iti[0]->iti_id ) ){
				$counter = 1;
				//$total_booking = 13;
				$total_booking = count($get_booked_iti);
				//calculate slab4 incentive
				if( $total_booking >= 21 ){
					$incentive_fourth_slab = 10000;
				}else if( $total_booking < 21 && $total_booking >= 17 ){
					$incentive_fourth_slab = 5000;
				}else if( $total_booking < 17 && $total_booking >= 13 ){
					$incentive_fourth_slab = 3000;
				}else{
					$incentive_fourth_slab = 0;
				}
				
				foreach( $get_booked_iti as $iti_data ){
					$incentive = 0;
					$incentive_second_slab = 0;
					$incentive_third_slab = 0;
					$temp_key = $iti_data->temp_key;
					$pid 	= $iti_data->pid;
					$iti_url = base_url( "itineraries/view_iti/{$iti_data->iti_id}/{$temp_key}" );
					$agent_margin = !empty($iti_data->agent_margin) ? $iti_data->agent_margin : 0;
					$package_cost = $iti_data->package_cost;
					$booking_date = date("d/m/y", strtotime( $iti_data->booking_date ) );
					$travel_date = !empty($travel_date) ? date("d/m/y", strtotime( $iti_data->booking_date ) ) : "";
					$is_below_base_price = $iti_data->is_below_base_price;
					$bbp 	= $iti_data->is_below_base_price ? "BBP" : "";
					$bbptr 	= $iti_data->is_below_base_price ? "bbptr" : "";
					
					$below_price_btn = "";
					if( $user['role'] == '99' || $user['role'] == '98' ){
						$below_price_btn = 	$is_below_base_price == 1 ? "<label class='mt-checkbox'> <input type='checkbox' title='Checked if Cost is below base price' value='1' data-id ={$pid} class='form-control is_below_base_price' checked ><span></span></label>" : "<label class='mt-checkbox'> <input title='Checked if Cost is below base price' type='checkbox' value='0' data-id ={$pid} class='form-control is_below_base_price'> <span></span></label>";	
					}
					
					//calculate base price 
					if( !empty( $agent_margin ) ){
						$reverse_margin = $agent_margin / 100;
						$reverse_margin	 = $reverse_margin + 1 ;
						$base_price = round($package_cost / $reverse_margin );
					}else{
						$base_price = $package_cost;
					}		
					
					$advance 	= $iti_data->advance_recieved;
					$second_pay_status = $iti_data->second_pay_status;
					$second_pay_date = $second_pay_status == "unpaid" ? $iti_data->second_payment_date : "";
					
					//SLAB 3 INCENTIVE
					if( !empty( $is_below_base_price ) && $is_below_base_price == 1 ){
						if( $base_price >= 70000 ){
							$incentive_third_slab = 500;
						}else if( $base_price < 70000 &&  $base_price >= 10000 ){
							$incentive_third_slab = 200;
						}else{
							$incentive_third_slab = 0;
						}
					}else{
						//SLAB 1 INCENTIVE
						$incentive = 200;
						//check if margin exists
						if( !empty( $agent_margin ) ){
							//calculate incentive
							switch( $agent_margin ){
								case ( $agent_margin <= 5 ):
									$incentive = 200;
									break;
								case ($agent_margin > 5 && $agent_margin <= 10 ):
									$incentive = 300;
									break;
								case ($agent_margin > 10 && $agent_margin <= 15 ):
									$incentive = 500;
									break;
								case ($agent_margin > 15 && $agent_margin <= 20 ):
									$incentive = $base_price > 10000 ? 1000 : 500;
									break;
								default:
									if( $base_price > 20000 )
										$incentive =  2000;
									else if( $base_price <= 20000 && $base_price >= 10000 )
										$incentive =  1000;
									else
										$incentive =  500;
								break;
							}	
						}
					}	
					
					//SLAB 2 INCENTIVE
					if( $package_cost >= 30000 ){
						$check_fifty_per = round( $package_cost * 50 / 100 );
						//if advance recevied more or equal 50% of package cost
						if( $advance >=  $check_fifty_per ){
							$incentive_second_slab = round( $advance * 1 / 100 );
						}
					}
					
					//generate iti link
					$iti_link = "<a target='_blank' href='{$iti_url}' title='Click to view package'>{$iti_data->customer_id}</a>";
					$return_html .= "<tr class='{$bbptr}'>";
					$return_html .= "<td>{$counter}. {$bbp} {$below_price_btn}</td>
									<td>{$iti_link}</td>
									<td>{$booking_date}</td>
									<td>{$travel_date}</td>
									<td>{$base_price}</td>
									<td>{$agent_margin}</td>
									<td>{$package_cost}</td>
									<td>{$advance}</td>
									<td>{$second_pay_date}</td>
									<td>{$incentive}</td>
									<td>{$incentive_second_slab}</td>
									<td>{$incentive_third_slab}</td>";
					$return_html .= "</tr>";
					
					//total incentive
					$total_incentive += $incentive;
					$total_incentive += $incentive_second_slab;
					$total_incentive += $incentive_third_slab;
					$counter++;
				}
				
				//Get Total Incentive
				$total_incentive += $incentive_fourth_slab;
				$total_inc = number_format($total_incentive);
				
				//slab4
				$slab_4_html = !empty( $incentive_fourth_slab ) ? "Slab 4 Incentive = {$incentive_fourth_slab}" : "";
				
				$return_html .= "<tr><td colspan=9>{$slab_4_html}</td><td colspan=3>Total (Slab1+Slab2+Slab3+slab4) = <strong> {$total_inc}/- (Approx.) </strong></td>}</tr>";
			}else{
				$return_html .= "<tr><td colspan=12> No packages booked on Selected month </td></tr>";
			}
			
			//Check total target and incentive visit page visit by agent
			$target = get_agent_monthly_target($agent_id , $month);
			$target_html = "<strong> Target Assigned:</strong> [{$target}] <strong> Target Achieved: </strong>[{$total_booking}]";
			//TERMS AND CONDITIONS FOR GET THE INCENTIVE
			//check if agent achieved his/her target
			//$com_percentage = floor(($total_booking / $target) * 100);
			
			if( $total_booking >= $target ){
				$succ = 1;
				$terms_html = "<div class='alert alert-success'><strong>Warm Congratulation</strong> for your success in sales target achievement. Stay storng and keep going until you discover your true core of strength.</div>";
			}else{
				$diff_targ = $target - $total_booking;
				if( $month === $current_month ){
					$terms_html = "<div class='alert alert-info'>You need to book <strong>{$diff_targ}</strong> more packages to earn your incentive.</div>";
				}else{
					$terms_html = "<div class='alert alert-danger'> <strong>Sorry !</strong> No incentive earned this month because you haven't completed your target. </div>";
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
		if( ($user['role'] == '99' || $user['role'] == '98') && isset( $_GET['month'] ) ){
			$month = trim($_GET['month']);
			$get_booked_iti = $this->global_model->ajax_check_agent_incentive( $month );
			
			$month_name = date("F Y", strtotime($month));
			$ex_mon_name = str_replace(" ", "_", $month_name);
			
			
			if( isset( $get_booked_iti[0]->iti_id ) ){
				$dataToExports = [];
				
				$counter = 1;
				foreach( $get_booked_iti as $iti_data ){
					$incentive = 0;
					$incentive_second_slab = 0;
					$incentive_third_slab = 0;
					$temp_key = $iti_data->temp_key;
					$bbp 	= $iti_data->is_below_base_price ? "YES" : "";
					$agent_margin = !empty($iti_data->agent_margin) ? $iti_data->agent_margin : 0;
					$package_cost = $iti_data->package_cost;
					$booking_date = date("d/m/y", strtotime( $iti_data->booking_date ) );
					$travel_date = !empty($travel_date) ? date("d/m/y", strtotime( $iti_data->booking_date ) ) : "";
					
					//calculate base price 
					if( !empty( $agent_margin ) ){
						$reverse_margin = $agent_margin / 100;
						$reverse_margin	 = $reverse_margin + 1 ;
						$base_price = round($package_cost / $reverse_margin );
					}else{
						$base_price = $package_cost;
					}		
					
					$is_below_base_price = $iti_data->is_below_base_price;
					$advance 		= $iti_data->advance_recieved;
					$second_pay_status = $iti_data->second_pay_status;
					$second_pay_date = $second_pay_status == "unpaid" ? $iti_data->second_payment_date : "";
					
					//SLAB 3 INCENTIVE
					if( !empty( $is_below_base_price ) && $is_below_base_price == 1 ){
						if( $base_price >= 70000 ){
							$incentive_third_slab = 500;
						}else if( $base_price < 70000 &&  $base_price >= 10000 ){
							$incentive_third_slab = 200;
						}else{
							$incentive_third_slab = 0;
						}
					}else{
						//SLAB 1 INCENTIVE
						$incentive = 200;
						//check if margin exists
						if( !empty( $agent_margin ) ){
							//calculate incentive
							switch( $agent_margin ){
								case ( $agent_margin <= 5 ):
									$incentive = 200;
									break;
								case ($agent_margin > 5 && $agent_margin <= 10 ):
									$incentive = 300;
									break;
								case ($agent_margin > 10 && $agent_margin <= 15 ):
									$incentive = 500;
									break;
								case ($agent_margin > 15 && $agent_margin <= 20 ):
									$incentive = $base_price > 10000 ? 1000 : 500;
									break;
								default:
									if( $base_price > 20000 )
										$incentive =  2000;
									else if( $base_price <= 20000 && $base_price >= 15000 )
										$incentive =  1000;
									else
										$incentive =  500;
								break;
							}	
						}
					}	
					
					//SLAB 2 INCENTIVE
					if( $package_cost >= 30000 ){
						$check_fifty_per = round( $package_cost * 50 / 100 );
						//if advance recevied more or equal 50% of package cost
						if( $advance >=  $check_fifty_per ){
							$incentive_second_slab = round( $advance * 1 / 100 );
						}
					}
					
					$arrangeData['Sr. No'] 				= $counter;
					$arrangeData['Lead ID']				= trim($iti_data->customer_id);
					$arrangeData['Agent'] 				= get_user_name(trim($iti_data->agent_id));
					$arrangeData['Booking Date']		= trim($booking_date);
					$arrangeData['Travel Date']			= trim($travel_date);
					$arrangeData['Base Price']			= $base_price;
					$arrangeData['Agent Margin(%)'] 	= $agent_margin;
					$arrangeData['Package_cost'] 		= trim($package_cost);
					$arrangeData['Advance']		 		= trim($advance);
					$arrangeData['Second Ins. Date']	= trim($second_pay_date);
					$arrangeData['Incentive Slab1']		= $incentive;
					$arrangeData['Incentive Slab2']		= $incentive_second_slab;
					$arrangeData['Incentive Slab3']		= $incentive_third_slab;
					$arrangeData['Below Base Price']	= $bbp;
					
					$dataToExports[] 					= $arrangeData;
					$counter++;
					
					//total incentive
					$total_incentive += $incentive;
					$total_incentive += $incentive_second_slab;
					$total_incentive += $incentive_third_slab;
				}
				
				//add total incentive
				$addarr = array(
					'Sr. No' 			=> "",
					'Lead ID'			=> "",
					'Agent' 			=> "",
					'Booking Date'		=> "",
					'Travel Date'		=> "",
					'Base Price'		=> "",
					'Agent Margin(%)' 	=> "",
					'Advance'		 	=> "",
					'Next Inst.' 		=> "",
					'Package_cost' 		=> "",
					'Ins. Slab1' 		=> "",
					'Ins. Slab2'		=> "Total(Slab1+Slab2+Slab3)(Approx.): ",
					'Ins. Slab3' 		=> $total_incentive,
				);
				
				$dataToExports[] = $addarr;
				
				// set header
				$filename = "all_agents_incentive_{$ex_mon_name}.xls";
				header("Content-Type: application/vnd.ms-excel");
				header("Content-Disposition: attachment; filename=\"$filename\"");
				$ex = $this->_exportExcelData($dataToExports);
				$this->session->set_flashdata('success',"Data Export Successfully.");
				
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