<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Search extends CI_Controller {
	public function __Construct(){
	   	parent::__Construct();
		validate_login();
		$this->load->model("search_model");
		$this->load->library('form_validation');
		$this->load->model("customer_model");
		$this->load->model("search_model");
		$this->load->model("itinerary_model");
		
	}
	
	/*public function index(){
		$user = $this->session->userdata('logged_in');
		$user_id = $user['user_id'];
		$data['user_role'] = $user['role'];
		if( $user ) {
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('search/customer_data', $data);
			$this->load->view('inc/footer');
		}else{
			redirect("dashboard");
		}
	}*/
	
	//MERGE ITINERARY AND CUSTOMER VIEW
	public function index(){
		$user = $this->session->userdata('logged_in');
		$customer_id = isset( $_GET["id"] ) && !empty( $_GET["id"]) ?   $_GET["id"] : 0;
		$user_id = $user['user_id'];
		$data["user_id"] = $user['user_id'];
		$data["role"] 	= $user['role'];
		//get Customer followup data
		$where_follow		 = array( "customer_id" => $customer_id );
		$data['lead_followup'] 		= $this->global_model->getdata("customer_followup", $where_follow, "", "id");
		$data['itineary_followup'] 	= $this->global_model->getdata("iti_followup", $where_follow, "", "id");
		
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '95'){
			$where = array("customer_id" => $customer_id ,'del_status' => 0);
			$data['customer'] 			= $this->customer_model->getdata( "customers_inquery", $where );
			$data['itineraries'] 		= $this->global_model->getdata("itinerary", $where);
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('customers/leads_all_data', $data);
			$this->load->view('inc/footer');
		}elseif($user['role'] == '96'){
			$where = array("customer_id" => $customer_id, "agent_id" => $user_id, 'del_status' => 0);
			$data['customer'] 		= $this->customer_model->getdata( "customers_inquery", $where );
			$data['itineraries'] 	= $this->global_model->getdata("itinerary", $where);
			
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('customers/leads_all_data', $data);
			$this->load->view('inc/footer');
		}else{
			redirect("404");
		}
	}
	
	
	
	//Ajax request to get customer list
	public function ajax_get_customer_ids(){
		$user = $this->session->userdata('logged_in');
		$user_id = $user['user_id'];
		
		//if sales team show result by agent_id
		$agent_id = $user['role'] == '96' ? $user_id : "";
			
        $keyword=$this->input->post('keyword');
        $data=$this->search_model->GetCustomersData($keyword, $agent_id);        
        echo json_encode($data);
    }
	
	//Get customer data
	public function get_customer_followup_data(){
		$user = $this->session->userdata('logged_in');
		$user_id = $user['user_id'];
		$cus_html = "No Customer Followup data.";
		$iti_html = "No Itineraries Followup data.";
		$iti_links_html = "No Data Found";
		$cus_Follow_info_html = false;
		$cus_info_html = "No Data Found";
        $customer_id = strip_tags($this->input->post('customer_id', true));
		
		//if sales team show result by agent_id
		if( $user['role'] == '96' ){
			$where = array( "customer_id" => $customer_id, "del_status" => 0, "agent_id" => $user_id );
			$agent_id = $user_id;
		}else{
			$where = array( "customer_id" => $customer_id, "del_status" => 0 );
			$agent_id = "";
		}
		
		if( !is_numeric( $customer_id ) ){
			$res = array("status" => false, "msg" => "Please Enter Valid Customer Id");
			die( json_encode($res) );
		}
		
		//$customer_id = 1000;
		$cus_info 			= $this->global_model->getdata("customers_inquery", $where );
		$get_cus_followup	= $this->search_model->get_cus_followup_data($customer_id);
		$get_iti_followup 	= $this->search_model->get_iti_followup_data($customer_id, $agent_id );
		$get_total_iti 		= $this->search_model->get_total_iti_data($customer_id, $agent_id );
		$add_acc = "";
		$add_iti = "";
		//get customer data
		if( $cus_info ){
			$cus 		= $cus_info[0];
			$cust_id    = $cus->customer_id;
			$temp_key   = $cus->temp_key;
			$agent_id   = $cus->agent_id;
			$agent 		= get_user_name($cus->agent_id);
			$cus_info_html = "<div class='customer-details'>
				<h3 class='text-center uppercase'>Customer Info</h3>";
				//Add itinerary /acc link
					switch( $cus->cus_status ){
						case 9:
							//if quotation type holidays
							//if( $customer->quotation_type == "holidays" ){
								//check if itinerary created against current leadStatus
							if( is_admin_or_manager_or_sales() ){
								$where3 = array( "customer_id" => $cus->customer_id , "iti_type" => 1 );
								$get_iti = $this->global_model->getdata( "itinerary", $where3 );
								if( !empty( $get_iti ) ){
									$iti_id = $get_iti[0]->iti_id;
									$temp_key = $get_iti[0]->temp_key;
									$pub_status = $get_iti[0]->publish_status;
									
									if( $pub_status == "draft" ){
										$add_iti = "<a href=" . site_url("itineraries/edit/{$iti_id}/{$temp_key}") . " class='btn btn-blue' title='Draft Itinerary'><i class='fa fa-pencil'></i> Edit Itinerary</a>";
									}else{
										$add_iti = "<a href=" . site_url("itineraries/view/{$iti_id}/{$temp_key}") . " class='btn btn-blue' title='View Itinerary'><i class='fa fa-plus'></i> View Itinerary</a>";
									}
									
								}else{						
									$add_iti = "<a href=" . site_url("itineraries/add/{$cus->customer_id}/{$cus->temp_key}") . " class='btn btn-green ajax_additi_table' data-id='{$cus->customer_id}' data-temp_key ='{$cus->temp_key}' title='Add Itinerary'><i class='fa fa-plus'></i> Ready for quotation</a>";
								}	
							//}elseif( $cus->quotation_type == "accommodation" ){
								//if quotation type holidays
								//check if Accommodation created against current leadStatus
								$where4 = array( "customer_id" => $cust_id , "iti_type" => 2);
								$get_acc = $this->global_model->getdata( "itinerary", $where4 );
								if( !empty( $get_acc ) ){
									$iti_id = $get_acc[0]->iti_id;
									$temp_key = $get_acc[0]->temp_key;
									$pub_status = $get_acc[0]->publish_status;
									if( $pub_status == "draft" ){
										$add_acc = "<a href=" . site_url("itineraries/edit/{$iti_id}/{$temp_key}") . " class='btn btn-blue' title='Draft Accommodation'><i class='fa fa-pencil'></i> Edit Acc.</a>";
									}else{
										$add_acc = "<a href=" . site_url("itineraries/view/{$iti_id}/{$temp_key}") . " class='btn btn-blue' title='View Accommodation'><i class='fa fa-plus'></i> View Acc.</a>";
									}
								}else{	
									$add_acc = "<a href=" . site_url("itineraries/add_accommodation/{$cus->customer_id}/{$cus->temp_key}") . " class='btn btn-green' data-id='{$cus->customer_id}' data-temp_key ='{$cus->temp_key}' title='Add Accommodation Package'><i class='fa fa-plus'></i> Acc. Quotation</a>";
								}	 
							}
							//$add_acc = "";
							//$add_iti = "";
							$decUserStatus = "<strong class='btn btn-success green'>Lead Approved</strong>";
							break;
						case 8:
							$add_iti = "";
							$add_acc = "";
							$decUserStatus = "<strong class='btn btn-danger'>Lead Declined</strong>";
							break;
						default:
							//show add call info if agent/manager
							if( is_admin_or_manager_or_sales() ){
								$cus_Follow_info_html = true;
							}
							
							$add_acc = "";
							$add_iti = "";
							$decUserStatus = "<strong class='btn btn-success'>Working...</strong>";
							break;
					}
					
					//View Buttons
					$c_view = "<a href=" . site_url("customers/view/{$cus->customer_id}/{$cus->temp_key}") . " title='View Customer' class='btn btn-success' ><i class='fa fa-eye'></i> View Customer</a></div>";
				
				$cus_info_html .= "<div class=' col-md-12 btn_section'>{$add_iti} {$add_acc} {$decUserStatus} {$c_view}</div>";
				
				//End  itinerary /acc link
				
				$cus_info_html .= "<div class='clearfix'></div>";
				$cus_info_html .= "<div class='col-md-6 col-lg-6'>
					<div class='col-md-6 form_vl'><strong>Customer Id:</strong></div>	
					<div class='col-md-6 form_vr'>{$cus->customer_id}</div>
				</div>
				<div class='col-md-6 col-lg-6'>
					<div class='col-md-6 form_vl'><strong>Customer Name:</strong></div>	
					<div class='col-md-6 form_vr'>{$cus->customer_name}</div>
				</div>
				<div class='col-md-6 col-lg-6'>
					<div class='col-md-6 form_vl'><strong>Contact:</strong></div>	
					<div class='col-md-6 form_vr'>{$cus->customer_contact}</div>
				</div>
				<div class='col-md-6 col-lg-6'>
					<div class='col-md-6 form_vl'><strong>Email:</strong></div>	
					<div class='col-md-6 form_vr'>{$cus->customer_email}</div>
				</div>";
				
			
			//If full details available
			if( !empty( $cus->adults ) && !empty($cus->hotel_category) ){ 
				$child 		= !empty( $cus->child ) ? $cus->child : "N/A";
				$child_age	= !empty( $cus->child_age ) ? $cus->child_age : "N/A";
				$pkBy 		=	$cus->package_type;
				$pack_T 	= $pkBy == "Other" ? $cus->package_type_other : $pkBy;
				$cp_type	=	$cus->package_car_type;
				$pack_car_type = $cp_type == "Other" ? $cus->package_car_type_other : $cp_type;
				$car_name = get_car_name($cus->car_type_sightseen);
				$tra_date = display_date_month_name($cus->travel_date);
				
				$cus_info_html .= "<div class='col-md-6 col-lg-6'>
					<div class='col-md-6 form_vl'><strong>Whatsapp Number</strong></div>	
					<div class='col-md-6 form_vr'>{$cus->whatsapp_number}</div>
				</div>
				<div class='col-md-6 col-lg-6'>
					<div class='col-md-6 form_vl'><strong>Adults:</strong></div>	
					<div class='col-md-6 form_vr'>{$cus->adults}</div>
				</div>
				<div class='col-md-6 col-lg-6'>
					<div class='col-md-6 form_vl'><strong>Child:</strong></div>	
					<div class='col-md-6 form_vr'>{$child}</div>
				</div>
				<div class='col-md-6 col-lg-6'>
					<div class='col-md-6 form_vl'><strong>Child Age:</strong></div>	
					<div class='col-md-6 form_vr'>{$child_age}</div>
				</div>
				<div class='col-md-6 col-lg-6'>
					<div class='col-md-6 form_vl'><strong>Package Type:</strong></div>	
					<div class='col-md-6 form_vr'>{$pack_T}</div>
				</div>
				<div class='col-md-6 col-lg-6'>
					<div class='col-md-6 form_vl'><strong>Total Rooms:</strong></div>	
					<div class='col-md-6 form_vr'>{$cus->total_rooms}</div>
				</div>
				<div class='col-md-6 col-lg-6'>
					<div class='col-md-6 form_vl'><strong>Travel Date:</strong></div>	
					<div class='col-md-6 form_vr'>{$tra_date}</div>
				</div>
				<div class='col-md-6 col-lg-6'>
					<div class='col-md-6 form_vl'><strong>Destination:</strong></div>	
					<div class='col-md-6 form_vr'>{$cus->destination}</div>
				</div>
				<div class='col-md-6 col-lg-6'>
					<div class='col-md-6 form_vl'><strong>Pick Up Point:</strong></div>	
					<div class='col-md-6 form_vr'>{$cus->pickup_point}</div>
				</div>
				<div class='col-md-6 col-lg-6'>
					<div class='col-md-6 form_vl'><strong>Dropping Point:</strong></div>	
					<div class='col-md-6 form_vr'>{$cus->droping_point}</div>
				</div>
				<div class='col-md-6 col-lg-6'>
					<div class='col-md-6 form_vl'><strong>Package By:</strong></div>	
					<div class='col-md-6 form_vr'>{$pack_car_type}</div>
				</div>
				<div class='col-md-6 col-lg-6'>
					<div class='col-md-6 form_vl'><strong>Meal Plan:</strong></div>	
					<div class='col-md-6 form_vr'>{$cus->meal_plan}</div>
				</div>
				<div class='col-md-6 col-lg-6'>
					<div class='col-md-6 form_vl'><strong>Honeymoon Kit:</strong></div>	
					<div class='col-md-6 form_vr'>{$cus->honeymoon_kit}</div>
				</div>
				<div class='col-md-6 col-lg-6'>
					<div class='col-md-6 form_vl'><strong>Car Type for sightseeing:</strong></div>	
					<div class='col-md-6 form_vr'>{$car_name}</div>
				</div>
				<div class='col-md-6 col-lg-6'>
					<div class='col-md-6 form_vl'><strong>Hotel Category:</strong></div>	
					<div class='col-md-6 form_vr'>{$cus->hotel_category}</div>
				</div>
				<div class='col-md-6 col-lg-6'>
					<div class='col-md-6 form_vl'><strong>Budget Approx:</strong></div>	
					<div class='col-md-6 form_vr'>{$cus->budget}</div>
				</div>";
			}
			$cus_info_html .= "<div class='col-md-6 col-lg-6'>
					<div class='col-md-6 form_vl'><strong>Customer Assign To:</strong></div>	
					<div class='col-md-6 form_vr'>{$agent}</div>
				</div></div>";
		}
		
		
		//get Total Itineraries
		if( $get_total_iti ){
			$iti_links_html = "";
			$ct = 1;
			foreach( $get_total_iti as $t_iti ){
				$link = iti_view_link( $t_iti->iti_id  );
				$view_btn_i = "<a href='{$link}' target='_blank' class='btn btn-blue' title='View'><i class='fa fa-plus'></i> View</a>";
				$iti_links_html .= "
				<tr>
					<td>{$ct}.</td>
					<td>{$t_iti->iti_id}</td>
					<td>{$t_iti->package_name}</td>
					<td>{$view_btn_i}</td>
				</tr>";		
				$ct++;					
			}
			$iti_links_html .= "</tbody></table></div>";
		}
		
		//if customer follow up data
		if( $get_cus_followup ){
			$cus_html = "";
			$count = 1;
			foreach( $get_cus_followup as $cus_follow ){
				$c_type = $cus_follow->callType;
				$link = customer_view_link( $cus_follow->customer_id  );
				$view_btn = "<a href='{$link}' target='_blank' class='btn btn-blue' title='View'><i class='fa fa-plus'></i> View</a>";
				
				$call_time = display_month_name_with_time($cus_follow->currentCallTime);
				
				if( $c_type == 9 ){
					$callType_status = "<strong class='green'>Approved</strong>";
				}elseif( $c_type == 8 ){
					$callType_status = "<strong class='red'>Decline</strong>";
				}else{
					$callType_status = $c_type;
				}
				$cus_html .= "<div class='col-md-12 col-lg-12'>
							<div class='mt-element-list'>			 
								<div class='mt-list-container list-todo' id='accordion1' role='tablist' aria-multiselectable='true'>
							<div class='list-todo-line'></div>
							<ul>
								<li class='mt-list-item'>
									<div class='list-todo-icon bg-white font-green-meadow'>
										<i class='fa fa-clock-o'></i>
									</div>
									<div class='list-todo-item green-meadow'>
										<a class='list-toggle-container' data-toggle='collapse' data-parent='#accordion1' onclick=' ' href='#task-{$count}' aria-expanded='false'>
											<div class='list-toggle done uppercase'>
												<div class='list-toggle-title bold '>Call Time: {$call_time} <br>
												</div>
											</div>
										</a>";
									if(!empty($cus_follow->nextCallDate)){
										$cus_html .=	"<div class='note note-success'><p><strong>Next Call Time: </strong> {$cus_follow->nextCallDate}</p></div>";
									}
									$cus_html .= "
										<div class='task-list panel-collapse collapse' id='task-{$count}'>
											<ul>
												<li class='task-list-item done'>
													<div class='task-icon'><a href='javascript:;'><i class='fa fa-phone'></i></a></div>

													<div class='task-content'>
														<h4 class='uppercase bold'>
															<a href='javascript:;'>{$callType_status}</a>
														</h4>
												<p><strong>Call summary: </strong> {$cus_follow->callSummary}</p>
												<p><strong>Next Call Time: </strong> {$cus_follow->nextCallDate}</p>
												<p><strong>Comment: </strong> {$cus_follow->comment}</p>
												<p><strong>{$cus_follow->customer_prospect}</strong></p>
												<p><strong>{$view_btn}</strong></p>
													</div>
												</li>
											</ul>
										</div>
									</div>
								</li>
							</ul>
						</div>
					</div>
				</div>";
				$count++;					
			}
		}
		
		//if iti follow up data
		if( $get_iti_followup ){
			$iti_html = "";
			$c = 1;
			foreach( $get_iti_followup as $iti_follow ){
				$c_type = $iti_follow->callType;
				$call_time_i = display_month_name_with_time($iti_follow->currentCallTime);
				$link = iti_view_link( $iti_follow->iti_id  );
				$view_btn_i = "<a href='{$link}' target='_blank' class='btn-blue' title='View'><i class='fa fa-plus'></i> View</a>";
				
				if( $c_type == "Booked lead" ){
					$callType_status = "<strong class='green'>{$c_type}</strong>";
				}elseif( $c_type == "Close lead" ){
				$callType_status = "<strong class='red'>{$c_type}</strong>";
				}else{
					$callType_status = $c_type;
				}
				
				$iti_html .= "
				<div class='col-md-12 col-lg-12'>
							<div class='mt-element-list'>	
							
								<div class='mt-list-container list-todo' id='accordion1' role='tablist' aria-multiselectable='true'>
							<div class='list-todo-line'></div>
							<ul>
								<li class='mt-list-item'>
									<div class='list-todo-icon bg-white font-green-meadow'>
										<i class='fa fa-clock-o'></i>
									</div>
									<div class='list-todo-item green-meadow'>
										<a class='list-toggle-container' data-toggle='collapse' data-parent='#accordion1' onclick=' ' href='#task-{$count}' aria-expanded='false'>
											<div class='list-toggle done uppercase'>
												<div class='list-toggle-title bold'>Call Time: {$call_time_i}</div>

											</div>
										</a>
										<div class='note note-success'>
												<div class='list-toggle-title '>{$view_btn_i  }<span></span><span><b>  Iti Id: </b></span>{$iti_follow->iti_id}<span><b>  Status: </b></span>{$callType_status}
													</div>

											</div>
										<div class='task-list panel-collapse collapse' id='task-{$count}'>
											<ul>
												<li class='task-list-item done'>
													<div class='task-icon'><a href='javascript:;'><i class='fa fa-phone'></i></a></div>

													<div class='task-content'>
														<h4 class='uppercase bold'>
															<a href='javascript:;'>{$callType_status}</a>
														</h4>
											<p><strong>Itinerary Id:</strong>{$iti_follow->iti_id}</p>
												<p><strong>{$callType_status}</strong></p>
												<p><strong>Call summary:{$iti_follow->callSummary}</p>
												<p><strong>Next Call Time:</strong>{$iti_follow->nextCallDate}</p>
												<p><strong>Comment: {$iti_follow->comment}</strong></p>
												<p><strong>{$iti_follow->itiProspect}</strong></p>
													</div>
												</li>
											</ul>
										</div>
									</div>
								</li>
							</ul>
						</div>
					</div>
				</div>
			";
				$c++;
			}
		}
		
		
		if( $cus_info || $get_cus_followup || $get_iti_followup ){
			$res = array("status" => true, "msg" => "Success", "cus_info_html" => $cus_info_html, "cus_html" => $cus_html, "iti_html" => $iti_html, "iti_links" => $iti_links_html, "cus_followup_data" => $cus_Follow_info_html );
		}else{
			$res = array( "status" => false, "msg" => "Error: No Data Found. Please check customer id." );
		}
		die( json_encode($res) );
		
	}
	
		//get chart data
		function getprospect_chartdata(){
			$id = $_POST['id'];
			$data  = $this->search_model->getcustomerdata($id);
			$data2  = $this->search_model->getitidata($id);
			$data_array = array();
			$data_array2 = array();
			if($data){
				foreach($data as $val){
					$x = $val['c_time'];
					//$c = strtotime($x);
					//$R = date('d-m-Y',$c); 
					$d = $val['c_pros'];
					//$strtime = strtotime($i_time);
					//$z = date('d-m-Y',$strtime); /*i time*/
					if($d == 'Hot'){
						$y=3;	
					}elseif($d=='Warm'){
						$y=2;
					}else{
						$y=1;
					}	
					$data_array[] = array("label" => $x, "y" => $y, "name" => $d );
				}
			}
			if($data2){
				foreach($data2 as $value){
					$i_pros = $value['i_pros']; /*iti followup*/ 
					$i_time = $value['i_time'];
					//$strtime = strtotime($i_time);
					//$z = date('d-m-Y',$strtime); /*i time*/
						//iti followup
					if($i_pros == 'Hot'){
							$iq=3;	
					}elseif($i_pros=='Warm'){
							$iq=2;
					}else{
						$iq=1;
					}				
					$data_array[] = array("label" => $i_time, "y" => $iq, "name" => $i_pros );
				}
			}
			die( json_encode( array("data1" => $data_array, "data2" => $data_array2) ) );
		}
	
}	
?>