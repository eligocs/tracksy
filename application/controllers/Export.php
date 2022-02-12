<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Export extends CI_Controller {
	public function __Construct(){
	   	parent::__Construct();
		validate_login();
		$this->load->model("export_model");
	}
	
	public function index(){
		$user = $this->session->userdata('logged_in');
		$user_id = $user["user_id"];
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '97' ){
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('vouchers/all_vouchers');
			$this->load->view('inc/footer'); 
		}else{
			redirect(404);
		}
	}
	
	//Export itineraries XLS data
	public function export_itinerary_fiter_data(){
		$this->load->model("itinerary_model");
		$user = $this->session->userdata('logged_in');
		$user_id = $user['user_id'];
		$role = $user['role'];
		
		if( $role == '99' || $role == '98' ){
			if( isset( $_GET['d_from'] ) && isset( $_GET["filter"] ) && isset( $_GET['end'] ) ){
				//Check todayStatus
				$todayStatus	= isset( $_GET['todayStatus'] ) && !empty( $_GET['todayStatus'] ) ? $_GET['todayStatus'] : "";
				$date_from		= isset( $_GET['d_from'] ) && !empty( $_GET['d_from'] ) ? $_GET['d_from'] : "";
				$date_to		= isset( $_GET['end'] ) && !empty( $_GET['end'] ) ? $_GET['end'] : "";
				
				$date_range_export = !empty( $todayStatus ) ? $todayStatus : "{$date_from} to {$date_to}"; 
				// todayStatus not exists
				if( empty( $todayStatus ) ){
					//Check for valid date
					$date_from_valid 	= check_valid_date( $_GET['d_from'], "Y-m-d" );
					$date_end_valid 	= check_valid_date( $_GET['end'], "Y-m-d" );
					//Check if date valid
					
					if(  empty( $_GET['d_from'] ) || empty( $_GET['end'] )  )	{
						$this->session->set_flashdata('error',"You need to select date range filter to export data.");
						redirect( "itineraries" );
						die();
					}else if( $date_from_valid && $date_end_valid ){
						$get_days = get_days_difference( $_GET['d_from'], $_GET['end'] );
						//If days differnce greater than 90 redirect user
						if( $get_days > 90 ){
							$this->session->set_flashdata('error',"You can export only three month data.");
							redirect( "itineraries" );
							die();
						}
					}
				}
				
				//condition for quotation sent filter show child iti in list
				if( ( isset( $_GET["quotation"] ) && $_GET["quotation"] == "true" ) || ( trim( $_GET["filter"] ) == "getFollowUp" ) ){
					$where = array("itinerary.pending_price !=" => 0 , "itinerary.email_count >" => 0, "itinerary.del_status" => 0 );
				}else{
					$where = array("itinerary.pending_price !=" => 0 , "itinerary.parent_iti_id" => 0, "itinerary.del_status" => 0);
				}	
				
				//get itineraries by agent
				if( isset( $_GET['agent_id'] ) && !empty( $_GET['agent_id'] ) ){
					$where["itinerary.agent_id"] = $_GET['agent_id'];
				}
				$agent_user_name = isset($_GET['agent_id']) && !empty( $_GET['agent_id'] ) ? get_user_name( $_GET['agent_id'] ) : "All Agents";
				$allData = $this->export_model->export_itinerary_fiter_data( $where );
				
				//dump( $allData );	die;
				if( $allData ){
						$dataToExports = [];
						$i = 1;
						foreach ($allData as $data) {
							$iti_id = $data->iti_id;
							//itinerary status
							$i_status = $data->iti_status;
							if( $i_status == 9 ){
								$status = "Approved";
							}else if( $i_status == 7 ){
								$status = "Declined";
							}else if( $i_status == 6 ){
								$status = "Rejected";
							}else if( $i_status == 0 && $data->iti_id ){
								$status = "Working";
							}else{
								$status = "";
							}	
							
							//Count All Child Itineraries
							//Check temp travel date if publish_status != "draft" iti_type = 1 Itinerary , 2 = accommodation
							//$temp_t_d = "";
							//if( $data->publish_status != "draft" && $data->iti_type == 1 ){
							//	$day_wise_meta = !empty( $data->daywise_meta ) ? unserialize($data->daywise_meta) : "";
							//	$temp_t_d = !empty( $day_wise_meta ) && isset( $day_wise_meta[0]['tour_date'] ) ? $day_wise_meta[0]['tour_date'] : "";
							//}else if( $data->publish_status != "draft" && $data->iti_type == 2  ){
							//	$temp_t_d = $data->t_start_date;
							//}
							$countChildIti = $this->global_model->count_all( 'itinerary', array("parent_iti_id" => $iti_id, "del_status" => 0) );
							//travel start date
							if( $countChildIti > 0  ){
								$temp_t_d = check_latest_travel_date( $iti_id );	
							}else{
								$temp_t_d = $data->t_start_date;
							}	
				
							
							//$temp_t_d = $data->t_start_date;
							
							$travelers = !empty( $data->adults ) ? "Adults: " . trim($data->adults) . " Child : " . trim($data->child) : "";
							
							//get_teamleader_user_id
							$team_leader = "";
							$tl = get_teamleader_user_id( $data->agent_id );
							if( $tl ){
								$team_leader = get_user_name( $tl );
							}	
							
							$arrangeData['Sr. No'] 				= $i;
							$arrangeData['Team Leader']			= $team_leader;
							$arrangeData['Iti Id'] 				= trim($data->iti_id);
							$arrangeData['Parent Iti'] 			= trim($data->parent_iti_id);
							$arrangeData['Lead Id'] 			= trim($data->customer_id);
							$arrangeData['Customer Name'] 		= trim($data->customer_name);
							$arrangeData['Customer Email'] 		= trim($data->customer_email);
							$arrangeData['Customer Contact'] 	= trim($data->customer_contact);
							$arrangeData['Package Name'] 		= trim($data->package_name);
							$arrangeData['Package Routing']		= trim($data->package_routing);
							$arrangeData['Package Duration']	= trim($data->duration);
							$arrangeData['Total Travellers']	= $travelers;
							$arrangeData['Temp Travel Date']	= $temp_t_d;
							$arrangeData['Travel Date']			= !empty( $data->travel_date ) ? display_month_name($data->travel_date) : "";
							$arrangeData['Cab']					= get_car_name( trim($data->cab_category) );
							$arrangeData['Status']				= $status;
							$arrangeData['Agent Margin']		= trim($data->agent_margin) . "%";
							$arrangeData['Final Price']			= trim($data->final_amount);
							$arrangeData['Booking Date']		= trim($data->booking_date);
							$arrangeData['Advance Received']	= trim($data->advance_recieved);
							
							$arrangeData['Second Ins Date']		= trim($data->second_payment_date);
							$arrangeData['Second Ins Amount']	= trim($data->second_payment_bal);
							$arrangeData['Second Ins Status']	= trim($data->second_pay_status);
							
							$arrangeData['Third Ins Date']		= trim($data->third_payment_date);
							$arrangeData['Third Ins Amount']	= trim($data->third_payment_bal);
							$arrangeData['Third Ins Status']	= trim($data->third_pay_status);
							
							$arrangeData['Final Ins Date']		= trim($data->final_payment_date);
							$arrangeData['Final Ins Amount']	= trim($data->final_payment_bal);
							$arrangeData['Final Ins Status']	= trim($data->final_pay_status);
							
							$arrangeData['Iti Created']			= trim($data->added);
							$arrangeData['Agent']				= get_user_name( trim($data->agent_id) );
							
							$dataToExports[] 					= $arrangeData;
							
							$i++;
							//Unset array in each row
							unset($arrangeData);
						}
						
						//dump( $dataToExports ); die;
						// set header
						$filename = "itinerary_{$date_range_export}_data_{$agent_user_name}.xls";
						header("Content-Type: application/vnd.ms-excel");
						header("Content-Disposition: attachment; filename=\"$filename\"");
						$ex = $this->_exportExcelData($dataToExports);
						
						//if export sent message to admin
						if( $ex ){
							//Get user info
							$super_manager_email 	= super_manager_email();
							$admin_email 			= admin_email();
							$user_name 				= get_user_name( $user_id );
							$user_link 				= "<a class='btn btn-success' target='_blank' href=" . site_url("agents/view/{$user_id}") . " title='View'>Click to view user details</a>";
							$subject = "Data Export Successfully <Trackitinerary.org>";
							
							$msg = "Itinerary data export successfully by <strong>{$user_name}</strong> <br>";
							$msg .= "Data export {$date_range_export} of {$agent_user_name} </strong> agent. <br>";
							$msg .= "{$user_link}";
							
							//Send mail if not admin
							if( is_manager() ){
								if( is_super_manager() ){
									sendEmail($admin_email, $subject, $msg);
								}else{
									sendEmail($super_manager_email, $subject, $msg, $admin_email);
								}	
							}
							
							$this->session->set_flashdata('success',"Data Exported successfully.");
						}
				}else{
					$this->session->set_flashdata('error',"No data found.");
					redirect("itineraries");	
				}
			}else{
				$this->session->set_flashdata('error',"Please select date range to export data.");
				redirect("itineraries");	
			}	
			die();
		}else{
			redirect(404);
		}
	}	
	
	//Export customers XLS data
	public function export_customers_fiter_data(){
		$this->load->model("itinerary_model");
		$user = $this->session->userdata('logged_in');
		$user_id = $user['user_id'];
		$role = $user['role'];
		if( $role == '99' || $role == '98' ){
			if( isset( $_GET['d_from'] ) && !empty( $_GET["filter"] ) && isset( $_GET['end'] ) ){
				//Check todayStatus
				$todayStatus	= isset( $_GET['todayStatus'] ) && !empty( $_GET['todayStatus'] ) ? $_GET['todayStatus'] : "";
				$date_from		= isset( $_GET['d_from'] ) && !empty( $_GET['d_from'] ) ? $_GET['d_from'] : "";
				$date_to		= isset( $_GET['end'] ) && !empty( $_GET['end'] ) ? $_GET['end'] : "";
				
				$date_range_export = !empty( $todayStatus ) ? $todayStatus : "{$date_from} to {$date_to}"; 
				// todayStatus not exists
				if( empty( $todayStatus ) ){
					//Check for valid date
					$date_from_valid 	= check_valid_date( $_GET['d_from'], "Y-m-d" );
					$date_end_valid 	= check_valid_date( $_GET['end'], "Y-m-d" );
					//Check if date valid
					
					if(  empty( $_GET['d_from'] ) || empty( $_GET['end'] )  )	{
						$this->session->set_flashdata('error',"You need to select date range filter to export data.");
						redirect( "customers" );
						die();
					}else if( $date_from_valid && $date_end_valid ){
						$get_days = get_days_difference( $_GET['d_from'], $_GET['end'] );
						//If days differnce greater than 90 redirect user
						if( $get_days > 90 ){
							$this->session->set_flashdata('error',"You can export only three month data.");
							redirect( "customers" );
							die();
						}
					}
				}
				
				//condition for quotation sent filter show child iti in list
				$where = array("customers_inquery.del_status" => 0);
				//get customers by agent
				if( isset( $_GET['agent_id'] ) && !empty( $_GET['agent_id'] ) ){
					$where["customers_inquery.agent_id"] = $_GET['agent_id'];
				}
				
				//Get date range
				
				
				$agent_user_name = isset($_GET['agent_id']) && !empty( $_GET['agent_id'] ) ? get_user_name( $_GET['agent_id'] ) : "All Agents";
				$allData = $this->export_model->export_customers_fiter_data( $where );
				//dump( $allData ); die;
				
				if( $allData ){
					$dataToExports = [];
					$i = 1;
					foreach ($allData as $data) {
						//cus status
						$i_status = $data->cus_status;
						if( $i_status == 9 ){
							$status = "Approved";
						}else if( $i_status == 8 ){
							$status = "Declined";
						}else{
							$status = "Working";
						}	
						//Get last followup
						$last_follow = trim($data->cus_last_followup_status);
						if( $last_follow == 9 )
							$l_follow = "Approved";
						else if( $i_status == 8 )
							$l_follow = "Declined";
						else
							$l_follow = $last_follow;
						
						$cus_type = get_customer_type_name($data->customer_type);
						
						//get_teamleader_user_id
						$team_leader = "";
						$tl = get_teamleader_user_id( $data->agent_id );
						if( $tl ){
							$team_leader = get_user_name( $tl );
						}	
						
						$travelers = !empty( $data->adults ) ? "Adults: " . trim($data->adults) . " Child : " . trim($data->child) : "";
						$arrangeData['Sr. No'] 				= $i;
						$arrangeData['Team Leader'] 		= $team_leader;
						$arrangeData['Lead Id'] 			= trim($data->customer_id);
						$arrangeData['Type'] 				= $cus_type;
						$arrangeData['Customer Name'] 		= trim($data->customer_name);
						$arrangeData['Customer Email'] 		= trim($data->customer_email);
						$arrangeData['Customer Contact'] 	= trim($data->customer_contact);
						$arrangeData['Package Type']	 	= trim($data->package_type);
						$arrangeData['Destination'] 		= trim($data->destination);
						$arrangeData['Last Followup']		= trim($l_follow);
						$arrangeData['Total Travellers']	= $travelers;
						$arrangeData['Travel Date']			= !empty( $data->travel_date ) ? display_date_month_name($data->travel_date) : "";
						$arrangeData['Status']				= $status;
						$arrangeData['Created']				= trim($data->created);
						$arrangeData['Agent']				= get_user_name( trim($data->agent_id) );
						
						$dataToExports[] 					= $arrangeData;
						
						$i++;
						//Unset array in each row
						unset($arrangeData);
					}
					
					//dump( $dataToExports ); die;
					
					// set header
					$filename = "Customers_{$date_range_export}_data_{$agent_user_name}.xls";
					header("Content-Type: application/vnd.ms-excel");
					header("Content-Disposition: attachment; filename=\"$filename\"");
					$ex = $this->_exportExcelData($dataToExports);
					
					//if export sent message to admin
					if( $ex ){
						//Get user info
						$super_manager_email 	= super_manager_email();
						$admin_email 			= admin_email();
						$user_name 				= get_user_name( $user_id );
						$user_link 				= "<a class='btn btn-success' target='_blank' href=" . site_url("agents/view/{$user_id}") . " title='View'>Click to view user details</a>";
						$subject = "Data Export Successfully <Trackitinerary.org>";
						
						$msg = "Customers data export successfully by <strong>{$user_name}</strong> <br>";
						$msg .= "Data export {$date_range_export} of {$agent_user_name} </strong> agent. <br>";
						$msg .= "{$user_link}";
						
						//Send mail if not admin
						if( is_manager() ){
							if( is_super_manager() ){
								sendEmail($admin_email, $subject, $msg);
							}else{
								sendEmail($super_manager_email, $subject, $msg, $admin_email);
							}	
						}	
						
						//echo "Data Exported successfully";
					}
				}else{
					$this->session->set_flashdata('error',"No data found.");
					redirect("customers");	
				}
			}else{
				$this->session->set_flashdata('error',"Invalid Request.");
				redirect("customers");	
			}	
			die;
		}else{
			redirect(404);
		}
	}	
	
	
	//Export customers XLS data
	public function export_cus_merge_fiter_data(){
		$this->load->model("itinerary_model");
		$user = $this->session->userdata('logged_in');
		$user_id = $user['user_id'];
		$role = $user['role'];
		
		if( $role == '99' || $role == '98' ){
			if( isset( $_GET['d_from'] ) && !empty( $_GET["filter"] ) && isset( $_GET['end'] ) ){
				//Check todayStatus
				$filter_data 	= trim($_GET['filter']);
				$todayStatus	= isset( $_GET['todayStatus'] ) && !empty( $_GET['todayStatus'] ) ? $_GET['todayStatus'] : "";
				$date_from		= isset( $_GET['d_from'] ) && !empty( $_GET['d_from'] ) ? $_GET['d_from'] : "";
				$date_to		= isset( $_GET['end'] ) && !empty( $_GET['end'] ) ? $_GET['end'] : "";
				
				$date_range_export = !empty( $todayStatus ) ? $todayStatus : "{$date_from} to {$date_to}"; 
				// todayStatus not exists
				if( empty( $todayStatus ) ){
					//Check for valid date
					$date_from_valid 	= check_valid_date( $_GET['d_from'], "Y-m-d" );
					$date_end_valid 	= check_valid_date( $_GET['end'], "Y-m-d" );
					//Check if date valid
					
					if(  empty( $_GET['d_from'] ) || empty( $_GET['end'] )  )	{
						$this->session->set_flashdata('error',"You need to select date range filter to export data.");
						redirect( "customers" );
						die();
					}else if( $date_from_valid && $date_end_valid ){
						$get_days = get_days_difference( $_GET['d_from'], $_GET['end'] );
						//If days differnce greater than 90 redirect user
						if( $get_days > 90 ){
							$this->session->set_flashdata('error',"You can export only three month data.");
							redirect( "customers" );
							die();
						}
					}
				}
				
				//condition for quotation sent filter show child iti in list
				$where = array("customers_inquery.del_status" => 0);
				//get customers by agent
				if( isset( $_GET['agent_id'] ) && !empty( $_GET['agent_id'] ) ){
					$where["customers_inquery.agent_id"] = $_GET['agent_id'];
				}
				
				
				
				
				
				//Get date range
				$agent_user_name = isset($_GET['agent_id']) && !empty( $_GET['agent_id'] ) ? get_user_name( $_GET['agent_id'] ) : "All Agents";
				$allData = $this->export_model->export_customers_merge_fiter_data( $where );
				//dump( $allData ); die;
				
				if( $allData ){
					$dataToExports = [];
					$i = 1;
					foreach ($allData as $data) {
						//cus status
						$i_status = $data->cus_status;
						if( $i_status == 9 ){
							//Check for iti status
							$iti_status = $data->iti_status;
							if( isset( $data->booking_status ) && $data->booking_status != 0 ){
								$status = isset( $data->booking_status ) && $data->booking_status == 0 ? "APPROVED" : "ON HOLD";
							}else if( $iti_status == 9 ){
								$status = "APPROVED";
							}else if( $iti_status == 7 ){
								$status = "DECLINED";
							}else if( $iti_status == 6 ){
								$status = "REJECTED";
							}else{
								$status = empty( $data->followup_id ) ? "NOT PROCESS" : "WORKING";
							}
							//$status = "Approved";
						}else if( $i_status == 8 ){
							$status = "Declined";
						}else{
							//$status = "Working";
							$status = empty( $data->followup_id ) ? "NOT PROCESS" : "WORKING";
						}	
						
						//Get last followup
						$last_follow = trim($data->cus_last_followup_status);
						if( $last_follow == 9 )
							$l_follow = "Approved";
						else if( $i_status == 8 )
							$l_follow = "Declined";
						else
							$l_follow = $last_follow;
						
						$cus_type = get_customer_type_name($data->customer_type);						
						$travelers = !empty( $data->adults ) ? "Adults: " . trim($data->adults) . " Child : " . trim($data->child) : "";
						
						//get_teamleader_user_id
						$team_leader = "";
						$tl = get_teamleader_user_id( $data->agent_id );
						
						if( $tl ){
							$team_leader = get_user_name( $tl );
						}
						
						$arrangeData['Sr. No'] 				= $i;
						$arrangeData['Team Leader'] 		= $team_leader;
						$arrangeData['Lead Id'] 			= trim($data->customer_id);
						$arrangeData['Type'] 				= $cus_type;
						$arrangeData['Customer Name'] 		= trim($data->customer_name);
						$arrangeData['Customer Email'] 		= trim($data->customer_email);
						$arrangeData['Customer Contact'] 	= trim($data->customer_contact);
						$arrangeData['Package Type']	 	= trim($data->package_type);
						$arrangeData['Package Name'] 		= trim($data->package_name);
						$arrangeData['Destination'] 		= trim($data->destination);
						
						//check next call date
						if( $filter_data == "getFollowUp" && !empty( $todayStatus ) ){
							$nxt_ftime = $this->export_model->check_cus_next_followup_time( $data->customer_id, $todayStatus );
							$arrangeData['Next Followup']		= trim($nxt_ftime);
						}
						
						$arrangeData['Last Followup']		= trim($l_follow);
						$arrangeData['Total Travellers']	= $travelers;
						$arrangeData['Travel Date']			= $data->travel_date;
						$arrangeData['Status']				= $status;
						$arrangeData['Created']				= trim($data->created);
						$arrangeData['Agent']				= get_user_name( trim($data->agent_id) );
						
						$dataToExports[] 					= $arrangeData;
						
						$i++;
						//Unset array in each row
						unset($arrangeData);
					}
					
					//dump( $dataToExports ); die;
					
					// set header
					$filename = "Customers_{$date_range_export}_data_{$agent_user_name}.xls";
					header("Content-Type: application/vnd.ms-excel");
					header("Content-Disposition: attachment; filename=\"$filename\"");
					$ex = $this->_exportExcelData($dataToExports);
					
					//if export sent message to admin
					if( $ex ){
						//Get user info
						$super_manager_email 	= super_manager_email();
						$admin_email 			= admin_email();
						$user_name 				= get_user_name( $user_id );
						$user_link 				= "<a class='btn btn-success' target='_blank' href=" . site_url("agents/view/{$user_id}") . " title='View'>Click to view user details</a>";
						$subject = "Data Export Successfully <Trackitinerary.org>";
						
						$msg = "Customers data export successfully by <strong>{$user_name}</strong> <br>";
						$msg .= "Data export {$date_range_export} of {$agent_user_name} </strong> agent. <br>";
						$msg .= "{$user_link}";
						
						//Send mail if not admin
						if( is_manager() ){
							if( is_super_manager() ){
								sendEmail($admin_email, $subject, $msg);
							}else{
								sendEmail($super_manager_email, $subject, $msg, $admin_email);
							}	
						}	
						
						//echo "Data Exported successfully";
					}
				}else{
					$this->session->set_flashdata('error',"No data found.");
					redirect("customers");	
				}
			}else{
				$this->session->set_flashdata('error',"Invalid Request.");
				redirect("customers");	
			}
		}else{
			redirect(404);
		}
		die;
	}	
	
	//Change array key
	public function _rename_arr_key($oldkey, $newkey, array &$arr) {
		if (array_key_exists($oldkey, $arr)) {
			$arr[$newkey] = $arr[$oldkey];
			unset($arr[$oldkey]);
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	//Export XLS data
	public function export_itinerary_data(){
		$user = $this->session->userdata('logged_in');
		$user_id = $user["user_id"];
		if( $user["role"] == "99" || $user["role"] == "98" ){
			if( isset( $_POST['date_from'] ) && isset( $_POST['date_to'] ) && isset( $_POST['agent_id'] ) && !empty( $_POST['date_from'] ) ){
				$date_from 	= trim($_POST['date_from']);
				$date_to 	= trim($_POST['date_to']);
				$agent_id 	= trim($_POST['agent_id']);
				$agent_user_name = $agent_id == "all" ? "All Agents" : get_user_name( $agent_id );
			
				$allData = $this->export_model->get_itinerary_data( $date_from, $date_to, $agent_id );
			
				if( $allData ){
					$dataToExports = [];
					$i = 1;
					foreach ($allData as $data) {
						//itinerary status
						$i_status = $data->iti_status;
						if( $i_status == 9 ){
							$status = "Approved";
						}else if( $i_status == 7 ){
							$status = "Declined";
						}else if( $i_status == 6 ){
							$status = "Rejected";
						}else if( $i_status == 0 && $data->iti_id ){
							$status = "Working";
						}else{
							$status = "";
						}	
						
						//Customer Status
						$c_status = $data->cus_status;
						if( $c_status == 9 )
							$lead_status = "Approved";
						else if( $c_status == 8 )
							$lead_status = "Declined";
						else
							$lead_status = "Working";
						
						//get_teamleader_user_id
						$team_leader = "";
						$tl = get_teamleader_user_id( $data->agent_id );
						if( $tl ){
							$team_leader = get_user_name( $tl );
						}
						
						$travelers = !empty( $data->adults ) ? "Adults: " . trim($data->adults) . " Child : " . trim($data->child) : "";
						
						$arrangeData['Sr. No'] 				= $i;
						$arrangeData['Team Leader']			= $team_leader;
						$arrangeData['Iti Id'] 				= trim($data->iti_id);
						$arrangeData['Parent Iti'] 			= trim($data->parent_iti_id);
						$arrangeData['Lead Id'] 			= trim($data->customer_id);
						$arrangeData['Customer Name'] 		= trim($data->customer_name);
						$arrangeData['Customer Email'] 		= trim($data->customer_email);
						$arrangeData['Customer Contact'] 	= trim($data->customer_contact);
						$arrangeData['Lead Status'] 		= trim($lead_status);
						$arrangeData['Package Name'] 		= trim($data->package_name);
						$arrangeData['Package Routing']		= trim($data->package_routing);
						$arrangeData['Package Duration']	= trim($data->duration);
						$arrangeData['Total Travellers']	= $travelers;
						$arrangeData['Quotation Date']		= display_date_month_name($data->quatation_date);
						$arrangeData['Travel Date']			= !empty( $data->travel_date ) ? display_month_name($data->travel_date) : "";
						$arrangeData['Cab']					= get_car_name( trim($data->cab_category) );
						$arrangeData['Status']				= $status;
						$arrangeData['Final Price']			= trim($data->final_amount);
						$arrangeData['Lead Created']		= trim($data->created);
						$arrangeData['Agent']				= get_user_name( trim($data->agent_id) );
						
						$dataToExports[] 					= $arrangeData;
						$i++;
					}
					// set header
					$filename = "{$date_from} To {$date_to}_itinerary_data_{$agent_user_name}.xls";
					header("Content-Type: application/vnd.ms-excel");
					header("Content-Disposition: attachment; filename=\"$filename\"");
					$ex = $this->_exportExcelData($dataToExports);
					
					//if export sent message to admin
					if( $ex ){
						//Get user info
						$super_manager_email 	= super_manager_email();
						$admin_email 			= admin_email();
						$user_name 				= get_user_name( $user_id );
						$user_link 				= "<a class='btn btn-success' target='_blank' href=" . site_url("agents/view/{$user_id}") . " title='View'>Click to view user details</a>";
						$subject = "Data Export Successfully <Trackitinerary.org>";
						
						$msg = "Itinerary data export successfully by <strong>{$user_name}</strong> <br>";
						$msg .= "Data export: {$date_from} To {$date_to} of <strong> {$agent_user_name} </strong> agent. <br>";
						$msg .= "{$user_link}";
						
						//Send mail if not admin
						if( is_manager() ){
							if( is_super_manager() ){
								sendEmail($admin_email, $subject, $msg);
							}else{
								sendEmail($super_manager_email, $subject, $msg, $admin_email);
							}	
						}	
					}
					
					//Set success message
					$this->session->set_flashdata('success',"Data Export Successfully.");
					//redirect("itineraries");
				}else{
					$this->session->set_flashdata('error',"No Data Found!.");
					redirect("itineraries");
				}	
				exit();
			}else{
				$this->session->set_flashdata('error',"Invalid Request.");
				redirect("itineraries");
			}	
		}else{
			redirect("dashboard");
		}	
	}
	
	//Export export_marketing_user_data XLS data
	public function export_marketing_user_data(){
		$user = $this->session->userdata('logged_in');
		$user_id = $user["user_id"];
		if( $user["role"] == "99" || is_super_manager() || $user["role"] == "95" ){
			if( isset( $_GET['state'] ) && isset( $_GET['category'] ) && !empty( $_GET['state'] ) && !empty( $_GET['category'] ) ){
				$state 		= $_GET['state'];
				$category 	= $_GET['category'];
				$city 		= $_GET['city'];
				$city_id 	= !empty( $city ) && $city != "all" ? $city : "";
				$city_name 	= !empty( $city ) && $city != "all" ? get_city_name($city) : "all_cities";
				if( !is_numeric( $state ) && !is_numeric( $category ) ) redirect("marketing");
				
				$state_name = get_state_name($state);
				$allData = $this->export_model->get_marketing_user_data( $state, $city_id , $category );
				if( $allData ){
					$dataToExports = [];
					$i = 1;
					foreach ($allData as $data) {
						
						$arrangeData['Sr. No'] 				= $i;
						$arrangeData['Name'] 				= trim($data->name);
						$arrangeData['Contact'] 			= trim($data->contact_number);
						$arrangeData['Whatsapp Number']		= trim($data->whats_app_number);
						$arrangeData['Email']				= trim($data->email_id);
						$arrangeData['State'] 				= !empty( $data->state ) ? get_state_name($data->state) : "";
						$arrangeData['City'] 				= !empty( $data->city ) ? get_city_name($data->city) : "";
						$arrangeData['Company Name'] 		= trim($data->company_name);
						$arrangeData['Category'] 			= get_marking_cat_name($data->cat_id);
						
						$dataToExports[] 					= $arrangeData;
						$i++;
					}
					
					// set header
					$filename = "{$city_name}_{$state_name}_marketing_users.xls";
					header("Content-Type: application/vnd.ms-excel");
					header("Content-Disposition: attachment; filename=\"$filename\"");
					$ex = $this->_exportExcelData($dataToExports);
					
					//if export sent message to admin
					if( $ex ){
						//Get user info
						$super_manager_email 	= super_manager_email();
						$admin_email 			= admin_email();
						$user_name 				= get_user_name( $user_id );
						$user_link 				= "<a class='btn btn-success' target='_blank' href=" . site_url("agents/view/{$user_id}") . " title='View'>Click to view user details</a>";
						$subject = "Data Export Successfully <Trackitinerary.org>";
						
						$msg = "Marketing User data export successfully by <strong>{$user_name}</strong> <br>";
						$msg .= "Data export: {$filename}. <br>";
						$msg .= "{$user_link}";
						
						//Send mail if not admin
						if( is_manager() || $user["role"] == 95 ){
							if( is_super_manager() ){
								sendEmail($admin_email, $subject, $msg);
							}else{
								sendEmail($super_manager_email, $subject, $msg, $admin_email);
							}	
						}	
					}
					//Set success message
					$this->session->set_flashdata('success',"Data Export Successfully.");
					//redirect("itineraries");
				}else{
					$this->session->set_flashdata('error',"No Data Found!.");
					redirect("marketing");
				}	
				exit();
			}else{
				$this->session->set_flashdata('error',"Invalid Request.");
				redirect("marketing");
			}	
		}else{
			redirect("marketing");
		}	
	}
	
	//Export export_ref_customers_data XLS data
	public function export_ref_customers_data(){
		$user = $this->session->userdata('logged_in');
		$user_id = $user["user_id"];
		if( $user["role"] == "99" || is_super_manager() || $user["role"] == "95" ){
			if( isset( $_GET['state'] ) && !empty( $_GET['state'] )  ){
				$state 		= $_GET['state'];
				$city 		= $_GET['city'];
				$city_id 	= !empty( $city ) && $city != "all" ? $city : "";
				$city_name 	= !empty( $city ) && $city != "all" ? get_city_name($city) : "all_cities";
				
				if( !is_numeric( $state ) ) redirect("reference_customers");
				
				$state_name = get_state_name($state);
				$allData = $this->export_model->get_ref_customers_data( $state, $city_id );
				if( $allData ){
					$dataToExports = [];
					$i = 1;
					foreach ($allData as $data) {
						
						$arrangeData['Sr. No'] 	= $i;
						$arrangeData['Name'] 	= trim($data->name);
						$arrangeData['Contact'] = trim($data->contact);
						$arrangeData['Email']	= trim($data->email);
						$arrangeData['State'] 	= !empty( $data->state ) ? get_state_name($data->state) : "";
						$arrangeData['City'] 	= !empty( $data->city ) ? get_city_name($data->city) : "";
						$dataToExports[] 		= $arrangeData;
						$i++;
					}
					// set header
					$filename = "{$city_name}_{$state_name}_reference_customers.xls";
					header("Content-Type: application/vnd.ms-excel");
					header("Content-Disposition: attachment; filename=\"$filename\"");
					$ex = $this->_exportExcelData($dataToExports);
					//if export sent message to admin
					if( $ex ){
						
						//Get user info
						$super_manager_email 	= super_manager_email();
						$admin_email 			= admin_email();
						$user_name 				= get_user_name( $user_id );
						$user_link 				= "<a class='btn btn-success' target='_blank' href=" . site_url("agents/view/{$user_id}") . " title='View'>Click to view user details</a>";
						$subject = "Data Export Successfully <Trackitinerary.org>";
						
						$msg = "Refernce Customers data export successfully by <strong>{$user_name}</strong> <br>";
						$msg .= "Data export: {$filename}. <br>";
						$msg .= "{$user_link}";
						
						//Send mail if not admin
						if( is_manager() || $user["role"] == 95 ){
							if( is_super_manager() ){
								sendEmail($admin_email, $subject, $msg);
							}else{
								sendEmail($super_manager_email, $subject, $msg, $admin_email);
							}	
						}
						
						//Set success message
						$this->session->set_flashdata('success',"Data Export Successfully.");
					}
				}else{
					$this->session->set_flashdata('error',"No Data Found!.");
					redirect("reference_customers");
				}
			}else{
				$this->session->set_flashdata('error',"Invalid Request.");
				redirect("reference_customers");
			}	
		}else{
			redirect("reference_customers");
		}	
		exit();
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
}	

?>