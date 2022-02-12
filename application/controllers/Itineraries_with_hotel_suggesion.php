<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Itineraries extends CI_Controller {
	public function __Construct(){
	   	parent::__Construct();
		validate_login();
		$this->load->model("customer_model");
		$this->load->model("itinerary_model");
	}
	
	public function index(){
		$user = $this->session->userdata('logged_in');
		$user_id = $user["user_id"];
		if( $user['role'] == 99 || $user['role'] == 98 || $user['role'] == 97 || $user['role'] == 96 ){
			$data['user_role'] = $user['role'];
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('itineraries/all_iti', $data);
			$this->load->view('inc/footer'); 
		}else if( $user['role'] == 95 ){
			$data['user_role'] = $user['role'];
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('itineraries/all_declined_iti', $data);
			$this->load->view('inc/footer'); 
		}else{
			redirect(404);
		} 
	}
	
	/* add Itinerary */
	public function add(){
		$user = $this->session->userdata('logged_in');
		$data["user_role"] = $user['role']; 
		$data["user_id"] = $user['user_id']; 
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '96'){
			$req_id = $this->uri->segment(3);
			$temp_key = $this->uri->segment(4);
			$customer_id = trim($req_id);
		
			$chkIti = $this->global_model->getdata("itinerary", array("customer_id" =>  $customer_id, "del_status" => 0, "iti_type" => 1 ) );
			if( empty( $chkIti ) ){ 
				//Count Itineraries against current Customer
				$where_cus = array( "customer_id" => $customer_id, "del_status" => 0, "publish_status" => "publish" );
				$data['customer_iti'] = $this->global_model->count_all("itinerary", $where_cus);
				//get customer data
				$where = array("customer_id" => $customer_id,"temp_key" => $temp_key, 'del_status' => 0);
				$get_cus = $this->customer_model->getdata( "customers_inquery", $where );
				$data['customer'] = $get_cus;
				$this->load->view('inc/header');
				$this->load->view('inc/sidebar');
				$this->load->view('itineraries/add_iti', $data);
				$this->load->view('inc/footer');
			}else{
				$iti_id = $chkIti[0]->iti_id;
				$temp_key = $chkIti[0]->temp_key;
				redirect("itineraries/edit/{$iti_id}/{$temp_key}");
				//echo "Itinerary Already Created against this customer Id. Please check in itineraries section.";
			}	
		}else{
			redirect("dashboard");
		}
	}
	
	/* add_accommodation Itinerary */
	public function add_accommodation(){
		$user = $this->session->userdata('logged_in');
		$data["user_role"] = $user['role']; 
		$data["user_id"] = $user['user_id']; 
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '96'){
			$req_id = $this->uri->segment(3);
			$temp_key = $this->uri->segment(4);
			$customer_id = trim($req_id);
			
			$chkIti = $this->global_model->getdata("itinerary", array("customer_id" =>  $customer_id, "del_status" => 0, "iti_type" => 2 ) );
			if( empty( $chkIti ) ){ 
				//Count Itineraries against current Customer
				$where_cus = array( "customer_id" => $customer_id, "del_status" => 0, "publish_status" => "publish" );
				$data['customer_iti'] = $this->global_model->count_all("itinerary", $where_cus);
				//get customer data
				$where = array("customer_id" => $customer_id,"temp_key" => $temp_key, 'del_status' => 0);
				$get_cus = $this->customer_model->getdata( "customers_inquery", $where );
				$data['customer'] = $get_cus;
				
				$this->load->view('inc/header');
				$this->load->view('inc/sidebar');
				$this->load->view('accommodation/add_package', $data);
				$this->load->view('inc/footer');
			}else{
				$iti_id = $chkIti[0]->iti_id;
				$temp_key = $chkIti[0]->temp_key;
				redirect("itineraries/edit/{$iti_id}/{$temp_key}");
				//echo "Itinerary Already Created against this customer Id. Please check in itineraries section.";
			}	
		}else{
			redirect("dashboard");
		}
	}
	
	/* View Itinerary */
	public function view_iti(){
		$iti_id = trim($this->uri->segment(3));
		$temp_key = trim($this->uri->segment(4));
		if( !empty( $iti_id ) && !empty( $temp_key ) ){
			$user = $this->session->userdata('logged_in');
			$user_id = $user['user_id'];
			$data["user_role"] = $user['role']; 
			$data["user_id"] = $user['user_id']; 
			
			//get itinerary follow up data
			/* $where = array( "iti_id" => $iti_id );
			$followUpData = $this->global_model->getdata("iti_followup", $where, "", "id"); */
			
			//get FolloupData
			$where = array( "parent_iti_id" => $iti_id );
			$orwhere = array( "iti_id" => $iti_id);
			$data["lastFollow"] = $this->itinerary_model->getchildItidata("iti_followup", $where, $orwhere,"iti_id","id", 1 );
			
			//check if itinerary has child itinerary or not
			$get_parent_id = $this->global_model->getdata( 'itinerary', array("iti_id" => $iti_id, "del_status" => 0), "parent_iti_id" );
			if( !empty( $get_parent_id  ) &&  $get_parent_id !== 0 ){
				$data['p_id'] = $get_parent_id;
				$orwhere = array( "iti_id" => $iti_id,"iti_id" => $get_parent_id, "parent_iti_id" => $iti_id, "parent_iti_id" => $get_parent_id );
			}else{	
				$data['p_id'] = "NO";
				$orwhere = array( "iti_id" => $iti_id, "parent_iti_id" => $iti_id);
			}	
			
			//get all followUpData child and parent itineraries
			$where = array();
			$followUpData = $this->itinerary_model->getchildItidata("iti_followup", $where, $orwhere, "", "id");
			
			$where_parent = array("parent_iti_id" => $iti_id, "pending_price !=" => "0" );
			$data['followUpData'] = $followUpData;
			$data["childItinerary"] 	= $this->global_model->getdata("itinerary", $where_parent);
			$data['discountPriceData'] 	= $this->global_model->getdata( 'itinerary_discount_price_data', array("iti_id" => $iti_id) );
			$data['paymentDetails'] 	= $this->global_model->getdata( 'iti_payment_details', array("iti_id" => $iti_id) );
			$data['countPrice'] = $this->global_model->count_all( 'itinerary_discount_price_data', array("iti_id" => $iti_id) );
			$data['amendment_itineraries'] = $this->global_model->getdata( 'iti_amendment_temp', array("iti_id" => $iti_id, "del_status" => 0) );
			
			//Get itinerary 
			$where_i = array("del_status" => 0, "iti_id" => $iti_id, "temp_key" => $temp_key);
			$get_iti = $this->global_model->getdata( 'itinerary', $where_i );
			
			//get view folder
			$view_file = !empty( $get_iti ) && $get_iti[0]->iti_type == 2  ? "accommodation/view_followup" : "itineraries/view_iti";
			
			if( $user['role'] == '99' || $user['role'] == '98' ){
				//get all child itinerary data
				$where = array("del_status" => 0, "iti_id" => $iti_id, "temp_key" => $temp_key);
				$data['itinerary'] = $get_iti;
				//Check if amendment id exists
				$this->load->view('inc/header');
				$this->load->view('inc/sidebar');
				$this->load->view($view_file, $data);
				$this->load->view('inc/footer');
			}elseif( $user['role'] == '97' ){
				//Get Hotel Booking 
				$data['hotel_bookings']	= $this->global_model->getdata("hotel_booking", array("iti_id" => $iti_id, "del_status" => 0 ));
				$data['cab_bookings']	= $this->global_model->getdata("cab_booking", array("iti_id" => $iti_id, "del_status" => 0 ));
				$data['vtf_bookings']	= $this->global_model->getdata("travel_booking", array("iti_id" => $iti_id, "del_status" => 0 ));
				$where = array("del_status" => 0, "iti_id" => $iti_id, "temp_key" => $temp_key);
				$data['itinerary'] = $this->global_model->getdata( 'itinerary', $where );
				$this->load->view('inc/header');
				$this->load->view('inc/sidebar');
				//Type 2 = accommodation
				if( !empty( $get_iti ) && $get_iti[0]->iti_type == 2 ){
					$this->load->view( 'accommodation/view_followup', $data );
				}else{
					$this->load->view( 'itineraries/view_iti_service', $data );
				}
				$this->load->view('inc/footer');
			}elseif($user['role'] == '96'){
				$where = array("del_status" => 0, "agent_id" => $user_id, "iti_id" => $iti_id, "temp_key" => $temp_key );
				$data['itinerary'] = $this->global_model->getdata( 'itinerary', $where );
				$this->load->view('inc/header');
				$this->load->view('inc/sidebar');
				$this->load->view( $view_file , $data);
				$this->load->view('inc/footer');
			}else{
				redirect("dashboard");
			}	 
		}else{
			redirect(404);
		}	
	}
	/* View Itinerary */
	public function view(){
		$iti_id = trim($this->uri->segment(3));
		$temp_key = trim($this->uri->segment(4));
		if( !empty( $iti_id ) && !empty( $temp_key ) ){
			$user = $this->session->userdata('logged_in');
			$user_id = $user['user_id'];
			$data["user_id"] = $user_id;
			$data["user_role"] = $user['role']; 
			//get comments
			$data['comments'] = $this->global_model->getdata( 'comments', array("iti_id" => $iti_id));
			$data['flight_details'] = $this->global_model->getdata( "flight_details", array("iti_id" => $iti_id) );
			$data['train_details'] = $this->global_model->getdata( "train_details", array("iti_id" => $iti_id) );
			$data['sec_key'] = md5($this->config->item("encryption_key"));
			
			//Get itinerary 
			$where_i = array("del_status" => 0, "iti_id" => $iti_id, "temp_key" => $temp_key);
			$get_iti = $this->global_model->getdata( 'itinerary', $where_i );
			
			//get view folder
			$view_file = !empty( $get_iti ) && $get_iti[0]->iti_type == 2  ? "accommodation/view" : "itineraries/view";
			
			if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '97'){
				$where = array("del_status" => 0, "iti_id" => $iti_id, "temp_key" => $temp_key);
				$data['itinerary'] 			= $this->global_model->getdata( 'itinerary', $where );
				$data['discountPriceData'] 	= $this->global_model->getdata( 'itinerary_discount_price_data', array("iti_id" => $iti_id) );
				$data['countPrice'] = $this->global_model->count_all( 'itinerary_discount_price_data', array("iti_id" => $iti_id) );
				$this->load->view('inc/header');
				$this->load->view('inc/sidebar');
				$this->load->view($view_file, $data);
				$this->load->view('inc/footer');
			}elseif($user['role'] == '96'){
				$where = array("del_status" => 0, "agent_id" => $user_id, "iti_id" => $iti_id, "temp_key" => $temp_key );
				$data['discountPriceData'] 	= $this->global_model->getdata( 'itinerary_discount_price_data', array("iti_id" => $iti_id) );
				$data['countPrice'] = $this->global_model->count_all( 'itinerary_discount_price_data', array("iti_id" => $iti_id) );
				$data['itinerary'] = $this->global_model->getdata( 'itinerary', $where );
				$this->load->view('inc/header');
				$this->load->view('inc/sidebar');
				$this->load->view($view_file, $data);
				$this->load->view('inc/footer');
			}elseif($user['role'] == '95'){
				$where = array("del_status" => 0, "iti_id" => $iti_id, "temp_key" => $temp_key );
				$data['discountPriceData'] 	= $this->global_model->getdata( 'itinerary_discount_price_data', array("iti_id" => $iti_id) );
				$data['countPrice'] = $this->global_model->count_all( 'itinerary_discount_price_data', array("iti_id" => $iti_id) );
				$data['itinerary'] = $this->global_model->getdata( 'itinerary', $where );
				$this->load->view('inc/header');
				$this->load->view('inc/sidebar');
				//$this->load->view('itineraries/view_declined', $data);
				
				//Type 2 = accommodation
				if( !empty( $get_iti ) && $get_iti[0]->iti_type == 2 ){
					$this->load->view( 'accommodation/view_declined_acc', $data );
				}else{
					$this->load->view( 'itineraries/view_declined', $data );
				}
				
				$this->load->view('inc/footer');
			}else{
				redirect("dashboard");
			}	 
		}else{
			redirect(404);
		}	
	}
	
	/* Edit Itinerary */
	public function edit(){
		$iti_id = trim($this->uri->segment(3));
		$temp_key = trim($this->uri->segment(4));
		if( !empty( $iti_id ) && !empty( $temp_key ) ){
			$user = $this->session->userdata('logged_in');
			$user_id = $user['user_id'];
			$data["user_role"] = $user['role']; 
			$data['flight_details'] = $this->global_model->getdata( "flight_details", array("iti_id" => $iti_id) );
			$data['train_details'] = $this->global_model->getdata( "train_details", array("iti_id" => $iti_id) );
			
			//Get itinerary 
			$where_i = array("del_status" => 0, "iti_id" => $iti_id, "temp_key" => $temp_key);
			$get_iti = $this->global_model->getdata( 'itinerary', $where_i );
			
			//get view folder
			$view_file = !empty( $get_iti ) && $get_iti[0]->iti_type == 2  ? "accommodation/edit" : "itineraries/edit";
			
			if( $user['role'] == '99' || $user['role'] == '98'){
				$where = array("del_status" => 0, "iti_id" => $iti_id, "temp_key" => $temp_key );
				$data['itinerary'] = $this->global_model->getdata( "itinerary", $where );
				$this->load->view('inc/header');
				$this->load->view('inc/sidebar');
				$this->load->view($view_file, $data);
				$this->load->view('inc/footer');
			}elseif($user['role'] == '96'){
				$where = array("del_status" => 0, "iti_id" => $iti_id, "temp_key" => $temp_key, "agent_id" => $user_id );
				$data['itinerary'] = $this->global_model->getdata( "itinerary", $where );
				//check for pending price if price update redirect user
				$pending_price = $data['itinerary'][0]->pending_price;
				if( $pending_price != 2 && $pending_price != 4 ){
					$this->load->view('inc/header');
					$this->load->view('inc/sidebar');
					$this->load->view($view_file, $data);
					$this->load->view('inc/footer');
				}else{
					redirect("itineraries");
				}
			}else{
				redirect("dashboard");
			}	 
		}else{
			redirect(404);
		}	
	}
	
	/* data table get all Itineraries */
	public function ajax_itinerary_list(){
		$user = $this->session->userdata('logged_in');
		$u_id = $user['user_id'];
		$role = $user['role'];
		if( $role == '99' || $role == '98' ){
			//condition for quotation sent filter show child iti in list
			if( ( isset( $_POST["quotation"] ) && $_POST["quotation"] == "true" ) || ( trim( $_POST["filter"] ) == "getFollowUp" ) ){
				$where = array("itinerary.pending_price !=" => 0 , "itinerary.email_count >" => 0, "itinerary.del_status" => 0 );
			}else{
				$where = array("itinerary.pending_price !=" => 0 , "itinerary.parent_iti_id" => 0, "itinerary.del_status" => 0);
			}	
			//Iti type
			if( isset( $_POST["iti_type"] ) && !empty( $_POST["iti_type"] ) )
				$where["itinerary.iti_type"] = $_POST['iti_type'];
			
			//get itineraries by agent
			if( isset( $_POST['agent_id'] ) && !empty( $_POST['agent_id'] ) ){
				$where["itinerary.agent_id"] = $_POST['agent_id'];
			}
		}elseif( $role == '97' ){
			$where = array( "itinerary.publish_status" => "publish" ,  "itinerary.iti_status" => 9, "itinerary.del_status" => 0 );
			
			//Iti type
			if( isset( $_POST["iti_type"] ) && !empty( $_POST["iti_type"] ) )
				$where["itinerary.iti_type"] = $_POST['iti_type'];
			
		}elseif( $role == '96' ){	
			//condition for quotation sent filter
			if( (isset( $_POST["quotation"]) && $_POST["quotation"] == "true" ) || ( trim( $_POST["filter"] ) == "getFollowUp" ) ){
				$where = array( "itinerary.agent_id" => $u_id,"itinerary.email_count >" => 0, "itinerary.del_status" => 0 );
			}else{
				$where = array( "itinerary.agent_id" => $u_id, "itinerary.parent_iti_id" => 0, "itinerary.del_status" => 0 );
			}
			
			//Iti type
			if( isset( $_POST["iti_type"] ) && !empty( $_POST["iti_type"] ) )
				$where["itinerary.iti_type"] = $_POST['iti_type'];
		}
		
		$list = $this->itinerary_model->get_datatables( $where );
		$data = array();
		$no = $_POST['start'];
		if( !empty($list) ){
			foreach ($list as $iti) {
				$pub_status = $iti->publish_status;
				$row_delete = $btn_edit="";
				$row_edit = "";
				$btncmt = "";
				$rev_btn_service = "";
				$amend_btn = "";
				$no++;
				$iti_id = $iti->iti_id;
				$key = $iti->temp_key;
				//get discount rate request
				$discount_request = $iti->discount_rate_request;
				$discReq = $discount_request == 1 ? "<strong class='red'> (Price Discount Request) </strong>" : " ";
				
				//Count All Child Itineraries
				$countChildIti = $this->global_model->count_all( 'itinerary', array("parent_iti_id" => $iti_id, "del_status" => 0) );
				
				$childLink = "<a title='View Child Itineraries' href=" . site_url("itineraries/childIti/{$iti_id}/{$key}") . " class='btn btn-success blue' ><i class='fa fa-child' aria-hidden='true'></i></a>";
				
				$showChildItiBtn = $countChildIti > 0 ? $childLink : "";
				
				//get iti_status
				$iti_status = $iti->iti_status;
				if( $pub_status == "publish" ){
					$p_status = "<strong>" . ucfirst($pub_status) . "</strong>";
				}elseif( $pub_status == "price pending" ){
					$p_status = "<strong class='blue'>" . ucfirst($pub_status) . "</strong>";
				}else{
					$p_status = "<strong class='red'>" . ucfirst($pub_status) . "</strong>";
				}
				//Lead Prospect Hot/Warm/Cold
				$cus_pro_status = get_iti_prospect($iti->iti_id);
				if( $cus_pro_status == "Warm" ){
					$l_pro_status = "<strong class='green'> ( " . $cus_pro_status . " )</strong>";
				}else if( $cus_pro_status == "Hot" ){
					$l_pro_status = "<strong class='black'> ( " . $cus_pro_status . " )</strong>";
				}else if( $cus_pro_status == "Cold" ){
					$l_pro_status = "<strong class='red'> ( " . $cus_pro_status . " )</strong>";
				}else{
					$l_pro_status = "";
				}
				
				//Get itinerary type 1=itinerary , 2=accommodation
				$iti_type = $iti->iti_type == 2 ? "<strong class='red'>Accommodation</strong>" : "<strong class='green'>Holiday</strong>";
				
				/* count iti sent status */
				$iti_sent = $iti->email_count;
				$sent_status = $iti_sent > 0 ? "$iti_sent Time Sent" : "Not Sent";
				$row = array();
				$row[] = $no;
				$row[] = $iti->iti_id;
				$row[] = $iti_type;
				$row[] = $iti->customer_id;
				$row[] = $iti->customer_name;
				$row[] = $iti->customer_contact;
				$row[] = $iti->package_name . $l_pro_status;
				$row[] = $iti->travel_date;
				
				//buttons
				//if price is updated remove edit for agent
				if( $iti->pending_price == 2 && $role == 96 ){
					$btn_edit = "<a title='Edit' href='javascript: void(0)' class='btn btn-success editPop' ><i class='fa fa-pencil' aria-hidden='true'></i></a>";
				}else{
					$btn_edit = "<a title='Edit' href=" . site_url("itineraries/edit/{$iti_id}/{$key}") . " class='btn btn-success' ><i class='fa fa-pencil' aria-hidden='true'></i></a>";
				}
				
				$btnview = "<a target='_blank' title='View' href=" . site_url("itineraries/view_iti/{$iti_id}/{$key}") . " class='btn btn-success' ><i class='fa fa-eye' aria-hidden='true'></i></a>";
				
				$btnview .= "<a target='_blank' title='View Pdf' href=" . site_url("itineraries/pdf/{$iti_id}/{$key}") . " class='btn btn-success' ><i class='fa fa-file-pdf-o' aria-hidden='true'></i></a>";
				
				$btn_view = "<a title='client view' target='_blank' href=" . site_url("promotion/itinerary/{$iti_id}/{$key}") . " class='btn btn-success' >Client view New</a>";
				
				//Show if type=1=itinerary
				if( $iti->iti_type == 1 ){
					$btn_view .= "<a title='client view' target='_blank' href=" . site_url("promotion/package/{$iti_id}/{$key}") . " class='btn btn-success' >Client view</a>";
				}
				
				//clone button
				if( empty( $iti->parent_iti_id ) &&  $countChildIti < 6  && $iti->iti_status == 0  && $iti->email_count > 0 && $pub_status == "publish" ){
					//type 2=accommodation
					if( $iti->iti_type == 2 ){
						$btn_view .= "<a data-customer_id='{$iti->customer_id}' data-iti_id='{$iti_id}' title='Duplicate Accommodation' href=" . site_url("itineraries/duplicate/{$iti_id}") . " class='btn btn-success child_clone' ><i class='fa fa-files-o' aria-hidden='true'></i></a>";
					}else{
						$btn_view .= "<a data-customer_id='{$iti->customer_id}' data-iti_id='{$iti_id}' title='Duplicate Itinerary' href=" . site_url(	"itineraries/duplicate/{$iti_id}") . " class='btn btn-success duplicateItiBtn' ><i class='fa fa-files-o' aria-hidden='true'></i></a>";
					}	
				}	
				
				if( !empty( $iti->client_comment_status ) && $iti->client_comment_status == 1 ){
					$btncmt = "<a data-id={$iti_id} data-key={$key} title='Client Comment' href='javascript:void(0)' class='btn btn-success ajax_iti_status red'><span class='blink'><i class='fa fa fa-comment-o' aria-hidden='true'></i>  New Comment</span></a>";
				}
				
				//if itinerary status is publish
				if( $pub_status == "publish" || $pub_status == "price pending" ){
					//delete itinerary button only for admin
					if( is_admin_or_manager() && empty( $countChildIti ) ){ 
						$row_delete = "<a data-id={$iti_id} title='Delete Itinerary' href='javascript:void(0)' class='btn btn-danger ajax_delete_iti'><i class='fa fa-trash-o' aria-hidden='true'></i></a>";
					}
					//Check for iti status
					if( $iti_status == 9 ){
						$it_status = "<a title='itinerary booked' class='btn btn-green' title='Itinerary Booked'><i class='fa fa-check-circle-o' aria-hidden='true'></i></a>";
						$st = "<i title='itinerary booked' class='fa fa-check-circle-o' aria-hidden='true'></i>";
					}else if( $iti_status == 7 ){
						$it_status = "<a title='itinerary declined' class='btn btn-danger'><i class='fa fa-ban' aria-hidden='true'></i></a>";
						$st = "<i title='itinerary declined' class='fa fa-ban' aria-hidden='true'></i>";
					}else if( $iti_status == 6 ){
						$it_status = "<a title='Itinerary Rejected' class='btn btn-danger'><i class='fa fa-ban' aria-hidden='true'></i></a>";
						$st = "<span title='Itinerary Rejected' class='rejected_iti'>Rejected</span>";
					}else{
						$it_status = "<a title='working...' class='btn btn-success'><i class='fa fa-tasks' aria-hidden='true'></i></a>";
						$st = "<i title='working...' class='fa fa-tasks' aria-hidden='true'></i>";
					}
					
					//Amendment Btn
					if( ( is_admin_or_manager() || is_salesteam() ) && $iti->is_amendment == 1 ){
						$amendment_id = $this->global_model->getdata( 'iti_amendment_temp', array("iti_id" => $iti_id), "id" );
						$amend_btn = " <a href='" . base_url("itineraries/view_amendment/{$amendment_id}") ."' class='btn btn-success' title='Click to view amendment itinerary'>View Amendment</a>";
						$amend_btn = !empty( $amendment_id ) ? $amend_btn : "";
						
					}else if( $iti->is_amendment == 2 ){
						$amend_btn = "<span class='btn btn-danger'>Revised</span>";
						$rev_btn_service = "<span class='btn btn-danger'>Revised</span>";
					}
					
					//show only view button for sales team
					if( $role == 97 ){
						//Hotel/cab/volvo book button 
						//check if hotel already booked for current iti
						$book_btn = "";
						
						$where_iti = array("iti_id" => $iti_id);
						$check_hotel_book 	= $this->global_model->getdata("hotel_booking", $where_iti );
						
						//Check if all hotel booking status done
						$voucher_status 	= $this->global_model->getdata( "iti_vouchers_status", $where_iti);
						$check_hotel_status	= !empty($voucher_status) && $voucher_status[0]->hotel_booking_status == 1 ? TRUE : FALSE;
						
						
						$h_class = !empty($check_hotel_book) ? "btn-success" : "btn-default";
						
						//if hotel status empty
						if( !$check_hotel_status ){
							$book_btn .= "<a  title='Book Hotel' href='" . site_url("hotelbooking/add/{$iti_id}") . "' class='btn {$h_class}' ><i class='fa fa-hotel' aria-hidden='true'></i>&nbsp; Book Hotel</a>";
						}
						
						//show book button if holidays package
						if( $iti->iti_type == 1 ){	
							$check_vtf_status	= !empty($voucher_status) && $voucher_status[0]->vtf_booking_status == 1 ? TRUE : FALSE;
							//$c_class = !empty($check_cab_book) ? "btn-success" : "btn-default";
							$v_class = !empty($check_volvo_book) ? "btn-success" : "btn-default";
							//$check_cab_book 	= $this->global_model->getdata("cab_booking", $where_iti );
							$check_volvo_book 	= $this->global_model->getdata("travel_booking", $where_iti );
					
							/*$book_btn .= "<a  title='Book Vehicles' href='" . site_url("vehiclesbooking/bookcab/{$iti_id}") . "' class='btn {$c_class}' ><i class='fa fa-car' aria-hidden='true'></i>&nbsp; Book Cab</a>";*/
							
							if( !$check_vtf_status ){
								$book_btn .= "<a  title='Add details Volvo/Train/Flight' href='" . site_url("vehiclesbooking/addbookingdetails/{$iti_id}?type=volvo") . "' class='btn {$v_class}' ><i class='fa fa-plane' aria-hidden='true'></i>&nbsp; Book VTF</a>";
							}
						}
					
						$row[] = $btnview . $rev_btn_service . $book_btn;
					}else{
						$allBtns = $btncmt. $btn_edit . $btnview. $btn_view . $row_delete . $it_status . $showChildItiBtn;
						$row[] = "<a href='' class='btn btn-success optionToggleBtn'>View</a><div class='optionTogglePanel'>{$allBtns}</div>" . $st . $showChildItiBtn . $amend_btn;
					}	
				}else{ 
					//if itinerary in draft hide buttons for sales team
					$row[] = $btn_edit . "
						<a data-id={$iti_id} title='Delete Itinerary Permanent' href='javascript:void(0)' class='btn btn-danger delete_iti_permanent'><i class='fa fa-trash-o' aria-hidden='true'></i></a>";
				}	
				//$row[] = $iti->added;
				$row[] = $sent_status;
				$row[] = $p_status . $discReq;
				if( $role != 96 ){
					$row[] = get_user_name( $iti->agent_id );
				}
				$data[] = $row;
			}
		}	
		
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->itinerary_model->count_all($where),
			"recordsFiltered" => $this->itinerary_model->count_filtered($where),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}
	
	/* data table get all Declined Itineraries */
	public function ajax_declined_itinerary_list(){
		$user = $this->session->userdata('logged_in');
		$u_id = $user['user_id'];
		$role = $user['role'];
		
		$where = array( "itinerary.iti_status" => 7 );
		//get itineraries by agent
		if( isset( $_POST['agent_id'] ) && !empty( $_POST['agent_id'] ) ){
			$where["itinerary.agent_id"] = $_POST['agent_id'];
		}
		
		$list = $this->itinerary_model->get_datatables($where);
		
		$data = array();
		$no = $_POST['start'];
		if( !empty($list) ){
			foreach ($list as $iti) {
				$pub_status = $iti->publish_status;
				$row_delete = "";
				$row_edit = "";
				$btncmt = "";
				$no++;
				
				//Get customer info
				$get_customer_info = get_customer( $iti->customer_id ); 
				$cust = $get_customer_info[0];
				$c_name = "";
				$c_contact = "";
				if( !empty( $get_customer_info ) ){  
					$c_name = $cust->customer_name;
					$c_contact = $cust->customer_contact;
				} 
				
				/* count iti sent status */
				$iti_sent = $iti->email_count;
				$sent_status = $iti_sent > 0 ? "$iti_sent Time Sent" : "Not Sent";
				$row = array();
				$row[] = $no;
				$row[] = $iti->iti_id;
				$row[] = $iti->iti_type == 2 ? "<strong class='red'>Accommodation</strong>" : "<strong class='green'>Holiday</strong>";;
				$row[] = $iti->customer_id;
				$row[] = $c_name;
				$row[] = $c_contact;
				$row[] = $iti->package_name;
				$row[] = $iti->added;
				$row[] = get_user_name( $iti->agent_id ); 
				$dec_bnt = "<strong class='btn btn-danger'>Declined</strong>";
				//buttons
				$row[] =  "<a title='View' target='_blank' href=" . site_url("itineraries/view/{$iti->iti_id}/{$iti->temp_key}") . " class='btn btn-success' ><i class='fa fa-eye' aria-hidden='true'></i></a>" . $dec_bnt;
				
				$data[] = $row;
			}
		}	
		
		$output = array(
			"draw" 				=> $_POST['draw'],
			"recordsTotal" 		=> $this->itinerary_model->count_all($where),
			"recordsFiltered" 	=> $this->itinerary_model->count_filtered($where),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}
	
	//add itinerary
	public function addItinerary(){
		$user = $this->session->userdata('logged_in');
		$role = $user['role'];
		$inc_meta	 = $this->input->post('inc_meta');
		$h_meta = $this->input->post('hotel_meta');
		if( isset($_POST["package_name"]) && !empty( $inc_meta ) && !empty( $h_meta ) ){
			//Update data 
			$unique_id = trim( $_POST['temp_key'] );
			$where_key = array('temp_key' => $unique_id );
			$get_data = $this->global_model->getdata("itinerary", $where_key);
			$iti_id = $get_data[0]->iti_id;
			$temp_key = $get_data[0]->temp_key;
			$rate_meta = unserialize($get_data[0]->rates_meta);
			
			if( $role == 99 || $role == 98 ){
				$data = array(
					'publish_status' => "publish",
				);
			}else{
				if( empty($rate_meta) ){
					$data = array(
						'publish_status' => "price pending",
					);
				}else{
					$data = array(
						'publish_status' => "publish",
					);
				}	
			}	
			$update_data = $this->global_model->update_data("itinerary", $where_key, $data );
			if( $update_data ){
				$res = array('status' => true, 'msg' => "Itinerary added successfully!", 'iti_id' => $iti_id, 'temp_key' => $temp_key );
			}else{
				$res = array('status' => false, 'msg' => "Failed! Please try again later.");
			}
			die(json_encode($res));
		}else{
			$res = array('status' => false, 'msg' => "Failed! All Fields are required.");
			die(json_encode($res));
		}
	}
	
	//Accommodation Ajax for save value step by step
	//add Package
	public function ajax_acc_savedata_stepwise(){
		$user = $this->session->userdata('logged_in');
		$role = $user['role'];
		
		if( isset($_POST["temp_key"]) && !empty( $_POST['step'] ) ){
			$unique_id = trim( $_POST['temp_key'] );
			$step 	= trim( $_POST['step'] );
			
			switch( $step ){
				case 1:  
					$package_name 		= strip_tags($_POST['package_name']);
					$package_routing 	= strip_tags($_POST['package_routing']);
					$adults				= strip_tags($_POST['adults']);
					$child				= strip_tags($_POST['child']);
					$child_age			= strip_tags($_POST['child_age']);
					$customer_id 		= strip_tags($_POST['customer_id']);
					$agent_id 			= strip_tags($_POST['agent_id']);
					$iti_type 	= trim( $_POST['iti_type'] );
					
					$step_data = array(
						'package_name' 		=> $package_name,
						'temp_key'			=> $unique_id,
						'package_routing'	=> $package_routing,
						'adults'			=> $adults,
						'child'				=> $child,
						'child_age'			=> $child_age,
						'agent_id'			=> $agent_id,
						'customer_id'		=> $customer_id,
						'iti_type'			=> $iti_type,
					);
				break;
				case 2:
					$startDate 			= strip_tags( $_POST['hotel_startdate'] );
					$endDate			= strip_tags( $_POST['hotel_enddate'] );
					$total_nights		= strip_tags($_POST['package_duration']);
					$hotel_meta 		= serialize($this->input->post('hotel_meta'));
					$hotel_note_meta 	= serialize($this->input->post('hotel_note_meta'));
					$step_data = array(
						't_start_date' 		=> $startDate,
						't_end_date' 		=> $endDate,
						'total_nights' 		=> $total_nights,
						'hotel_meta' 		=> $hotel_meta,
						'hotel_note_meta' 	=> $hotel_note_meta,
					);
				break;
				case 3:
					$inc_meta					= serialize($this->input->post('inc_meta'));
					$exc_meta					= serialize($this->input->post('exc_meta'));
					$special_inc_meta			= serialize($this->input->post('special_inc_meta', TRUE));
					$step_data = array(
						'inc_meta'					=> $inc_meta,
						'exc_meta'					=> $exc_meta,
						'special_inc_meta'			=> $special_inc_meta,
					);
				break;
			}
			
			//update data
			$where = array('temp_key' => $unique_id );
			$get_data = $this->global_model->getdata("itinerary", $where);
			if( empty( $get_data ) ){
				$step_data['lead_created'] = $this->input->post("lead_created", true);
				//insert if data not get
				$insert_data = $this->global_model->insert_data("itinerary", $step_data );
				if( $insert_data ){
					$res = array('status' => true, 'msg' => "Data save.");
				}else{
					$res = array('status' => false, 'msg' => "Error! Data not save.");
				}
			}else{
				//Update data 
				$where_key = array('temp_key' => $unique_id ); 
				$update_data = $this->global_model->update_data("itinerary", $where_key, $step_data );
				if( $update_data ){
					$res = array('status' => true, 'msg' => "Data save.");
				}else{
					$res = array('status' => false, 'msg' => "Error! Data not save.");
				}
			}
		}else{
			$res = array('status' => false, 'msg' => "Failed! Invalid request try again.");
		}
		die(json_encode($res));
	}
	
	//Accommodation Ajax for save value step by step
	//add Package
	public function ajax_amendment_accommodation_savedata(){
		$user = $this->session->userdata('logged_in');
		$role = $user['role'];
		
		if( isset($_POST["temp_key"]) && !empty( $_POST['step'] ) ){
			$id = trim( $_POST['id'] );
			$unique_id = trim( $_POST['temp_key'] );
			$step 	= trim( $_POST['step'] );
			switch( $step ){
				case 1:  
					$package_name 		= strip_tags($_POST['package_name']);
					$package_routing 	= strip_tags($_POST['package_routing']);
					$adults				= strip_tags($_POST['adults']);
					$child				= strip_tags($_POST['child']);
					$child_age			= strip_tags($_POST['child_age']);
					
					$step_data = array(
						'package_name' 		=> $package_name,
						'temp_key'			=> $unique_id,
						'package_routing'	=> $package_routing,
						'adults'			=> $adults,
						'child'				=> $child,
						'child_age'			=> $child_age,
					);
				break;
				case 2:
					$startDate 			= strip_tags( $_POST['hotel_startdate'] );
					$endDate			= strip_tags( $_POST['hotel_enddate'] );
					$total_nights		= strip_tags($_POST['package_duration']);
					$hotel_meta 		= serialize($this->input->post('hotel_meta'));
					$hotel_note_meta 	= serialize($this->input->post('hotel_note_meta'));
					$step_data = array(
						't_start_date' 		=> $startDate,
						't_end_date' 		=> $endDate,
						'total_nights' 		=> $total_nights,
						'hotel_meta' 		=> $hotel_meta,
						'hotel_note_meta' 	=> $hotel_note_meta,
					);
				break;
				case 3:
					$inc_meta					= serialize($this->input->post('inc_meta'));
					$exc_meta					= serialize($this->input->post('exc_meta'));
					$special_inc_meta			= serialize($this->input->post('special_inc_meta', TRUE));
					$step_data = array(
						'inc_meta'					=> $inc_meta,
						'exc_meta'					=> $exc_meta,
						'special_inc_meta'			=> $special_inc_meta,
					);
				break;
			}
			
			//Update data 
			$where_key = array('id' => $id ); 
			$update_data = $this->global_model->update_data("iti_amendment_temp", $where_key, $step_data );
			
			if( $update_data ){
				$res = array('status' => true, 'msg' => "Data save.");
			}else{
				$res = array('status' => false, 'msg' => "Error! Data not save.");
			}
		}else{
			$res = array('status' => false, 'msg' => "Failed! Invalid request try again.");
		}
		die(json_encode($res));
	}
	
	//Itinerary Ajax for save value step by step
	//add itinerary
	public function ajax_savedata_stepwise(){
		$user = $this->session->userdata('logged_in');
		$role = $user['role'];
		
		if( isset($_POST["temp_key"]) && isset( $_POST['step'] ) ){
			$unique_id = trim( $_POST['temp_key'] );
			$step 	= trim($_POST['step']);
			switch( $step ){
				case 1:  
					$iti_type 			= strip_tags($_POST['iti_type']);
					$package_name 		= strip_tags($_POST['package_name']);
					$quatation_date 	= strip_tags($_POST['quatation_date']);
					$package_routing 	= strip_tags($_POST['package_routing']);
					$adults				= strip_tags($_POST['adults']);
					$child				= strip_tags($_POST['child']);
					$child_age			= strip_tags($_POST['child_age']);
					$package_duration 	= strip_tags($_POST['package_duration']);
					$cab_category 		= strip_tags($_POST['cab_category']);
					$agent_id 			= strip_tags($_POST['agent_id']);
					$customer_id 		= strip_tags($_POST['customer_id']);
					$isflight			= isset($_POST['is_flight']) && !empty( $_POST['is_flight'] ) ? 1 : 0;
					$isTrain			= isset( $_POST['is_train'] ) && !empty( $_POST['is_train'] ) ? 1 : 0;
					$rooms_meta			= serialize($this->input->post('rooms_meta', TRUE));
					
					$step_data = array(
						'iti_type' 			=> $iti_type,
						'package_name' 		=> $package_name,
						'quatation_date' 	=> $quatation_date,
						'temp_key'			=> $unique_id,
						'package_routing'	=> $package_routing,
						'cab_category'		=> $cab_category,
						'adults'			=> $adults,
						'child'				=> $child,
						'child_age'			=> $child_age,
						'duration'			=> $package_duration,
						'is_flight'			=> $isflight,
						'is_train'			=> $isTrain,
						'agent_id'			=> $agent_id,
						'customer_id'		=> $customer_id,
						'rooms_meta'		=> $rooms_meta,
					);
				break;
				case 2:
					$daywise_meta 		= serialize($this->input->post('tour_meta', TRUE));
					$step_data = array(
						'daywise_meta' 	=> $daywise_meta,
					);
				break;
				case 3:
					$inc_meta					= serialize($this->input->post('inc_meta', TRUE));
					$exc_meta					= serialize($this->input->post('exc_meta', TRUE));
					$special_inc_meta			= serialize($this->input->post('special_inc_meta', TRUE));
					$step_data = array(
						'inc_meta'					=> $inc_meta,
						'exc_meta'					=> $exc_meta,
						'special_inc_meta'			=> $special_inc_meta,
					);
				break;
				case 4:
					$currentDate = $date;
					$hotel_meta				= serialize( $this->input->post('hotel_meta', TRUE) );
					$hotel_note_meta		= serialize( $this->input->post('hotel_note_meta', TRUE) );
					if( $role == 99 || $role == 98 ){
						$hotel_rate_meta		= serialize($this->input->post('rate_meta', TRUE));
						$step_data = array(
							'hotel_meta'			=> $hotel_meta,
							'hotel_note_meta'		=> $hotel_note_meta,
							'rates_meta'			=> $hotel_rate_meta,
							'pending_price'			=> 2,
						);
					}else{
						$step_data = array(
							'hotel_meta'			=> $hotel_meta,
							'hotel_note_meta'		=> $hotel_note_meta,
						);
					}	
				break;
			}
			
			//update data
			$where = array('temp_key' => $unique_id );
			$get_data = $this->global_model->getdata("itinerary", $where);
			if( empty( $get_data ) ){
				//insert if data not get
				//push lead created date 
				$step_data['lead_created'] = $this->input->post("lead_created", true);
				$insert_data = $this->global_model->insert_data("itinerary", $step_data );
				if( $insert_data ){
					$res = array('status' => true, 'msg' => "Data save.");
				}else{
					$res = array('status' => false, 'msg' => "Error! Data not save.");
				}
			}else{
				//Update data 
				$where_key = array('temp_key' => $unique_id ); 
				$update_data = $this->global_model->update_data("itinerary", $where_key, $step_data );
				if( $update_data ){
					$res = array('status' => true, 'msg' => "Data save.");
				}else{
					$res = array('status' => false, 'msg' => "Error! Data not save.");
				}
			}
			
			//Enter Flight and Train Details if step=1
			if( $step == 1 ){
				//Get Itinerary Id
				$iti_id = $this->global_model->getdata("itinerary", array( 'temp_key' => $unique_id ), "iti_id" );
				$chkFdetails = $this->global_model->getdata( "flight_details", array("iti_id" => $iti_id) );
				$chkTdetails = $this->global_model->getdata( "train_details", array("iti_id" => $iti_id) );
				//Flight Details 
				$isflights	= isset($_POST['is_flight']) && !empty( $_POST['is_flight'] ) ? 1 : 0;
				$isTrains	= isset( $_POST['is_train'] ) && !empty( $_POST['is_train'] ) ? 1 : 0;
				if( $isflights == 1 ){
					//Get Flight Data 
					$flight_name	= strip_tags($_POST['flight_name']);
					$passengers     = strip_tags($_POST['passengers']);
					$dep_city		= strip_tags($_POST['dep_city']);
					$arr_city		= strip_tags($_POST['arr_city']);
					$arr_time		= strip_tags($_POST['arr_time']);
					$dep_date		= strip_tags($_POST['dep_date']);
					$return_date	= isset($_POST['return_date']) ? strip_tags($_POST['return_date']) : "";
					$return_arr_date = isset($_POST['return_arr_date']) ? strip_tags($_POST['return_arr_date']) : "";
					$f_class		= strip_tags($_POST['f_class']);
					$flight_price	= strip_tags($_POST['flight_cost']);
					$trip_r			= strip_tags($_POST['trip_r']);
					
					$f_data = array(
						"iti_id" 			=> $iti_id,
						"trip_type"			=> $trip_r,
						"flight_name" 		=> $flight_name,
						"flight_price" 		=> $flight_price,
						"dep_city" 			=> $dep_city,
						"arr_city"			=> $arr_city,
						"arr_time"			=> $arr_time,
						"dep_date"			=> $dep_date,
						"return_date"		=> $return_date,
						"return_arr_date"	=> $return_arr_date,
						"total_passengers"	=> $passengers,
						"flight_class"		=> $f_class,
						"in_itinerary"		=> 1,
					);
					
					//get Flight Data if exists
					$get_fdata = $this->global_model->getdata("flight_details", array( "iti_id" => $iti_id ));
					if( empty( $get_fdata ) ){
						//insert if data not get
						$this->global_model->insert_data("flight_details", $f_data );
					}else{
						//Update data 
						$where_key = array('iti_id' => $iti_id ); 
						$this->global_model->update_data("flight_details", $where_key, $f_data );
					}
				}else if( $isflights == 0 && !empty( $chkFdetails ) ){
					$this->global_model->update_data("flight_details", array('iti_id' => $iti_id ), array("in_itinerary" => 0 ) );
				}

				//Enter Train Details	
				if( $isTrains == 1 ){
					//Get Train Data 
					$train_name		= strip_tags($_POST['train_name']);
					$train_number	= strip_tags($_POST['train_number']);
					$passengers     = strip_tags($_POST['t_passengers']);
					$dep_city		= strip_tags($_POST['t_dep_city']);
					$arr_city		= strip_tags($_POST['t_arr_city']);
					$t_arr_time		= strip_tags($_POST['t_arr_time']);
					$dep_date		= strip_tags($_POST['t_dep_date']);
					$return_date	= isset($_POST['t_return_date']) ? strip_tags($_POST['t_return_date']) : "";
					$t_return_arr_date	= isset($_POST['t_return_arr_date']) ? strip_tags($_POST['t_return_arr_date']) : "";
					$f_class		= strip_tags($_POST['t_class']);
					$t_price		= strip_tags($_POST['t_cost']);
					$trip_r			= strip_tags($_POST['t_trip_r']);
					
					$f_data = array(
						"iti_id" 			=> $iti_id,
						"t_trip_type"		=> $trip_r,
						"train_name" 		=> $train_name,
						"train_number" 		=> $train_number,
						"t_cost" 			=> $t_price,
						"t_dep_city" 		=> $dep_city,
						"t_arr_city"		=> $arr_city,
						"t_arr_time"		=> $t_arr_time,
						"t_dep_date"		=> $dep_date,
						"t_return_date"		=> $return_date,
						"t_return_arr_date"	=> $t_return_arr_date,
						"t_passengers"		=> $passengers,
						"train_class"		=> $f_class,
						"in_itinerary"		=> 1,
					);
					
					//get train Data if exists
					$get_fdata = $this->global_model->getdata("train_details", array( "iti_id" => $iti_id ));
					if( empty( $get_fdata ) ){
						//insert if data not get
						$this->global_model->insert_data("train_details", $f_data );
					}else{
						//Update data 
						$where_key = array('iti_id' => $iti_id ); 
						$this->global_model->update_data("train_details", $where_key, $f_data );
					}
				}else if( $isTrains == 0 && !empty( $chkTdetails ) ){
					$this->global_model->update_data("train_details", array('iti_id' => $iti_id ), array("in_itinerary" => 0 ) );
				} 
			}
			die(json_encode($res));
		}else{
			$res = array('status' => false, 'msg' => "Failed! Invalid request try again.");
			die(json_encode($res));
		}
	}
	
	//delete draft iti
	public function delete_iti_permanently(){
		$id = $this->input->get('id');
		$where = array( "iti_id" => $id );
		$result = $this->global_model->delete_data( "itinerary", $where );
		if( $result){
			$res = array('status' => true, 'msg' => "Itinerary delete Successfully!");
		}else{
			$res = array('status' => false, 'msg' => "Error! please try again later");
		}
		die(json_encode($res));
	}
	//update price by manager
	public function update_price(){
		if( isset($_POST["action"]) && !empty( $_POST["iti_id"]) ){
			$action = $_POST["action"];
			//$res = array('status' => false, 'msg' => "Data not save. $action");
			//die( json_encode( $res ) );
			
			$iti_id 			= trim( $_POST['iti_id'] );
			$agent_id 			= trim( $_POST['agent_id'] );
			$temp_key 			= trim( $_POST['temp_key'] );
			$rate_comment 		= strip_tags( $_POST['rate_comment'] );
			$hotel_rate_meta	= serialize($this->input->post('rate_meta'));
			
			//Update data 
			$update_data = array(
				'rates_meta'			=> $hotel_rate_meta,
				'rate_comment'			=> $rate_comment,
				'iti_status'			=> 0,
				'publish_status'		=> "publish",
				'approved_price_date'	=> current_datetime(),
			);
			
			$link = "<a class='btn btn-success' target='_blank' href=" . site_url("itineraries/view/{$iti_id}/{$temp_key}") . " title='View'>Click to view itinerary</a>";
			//Check Action if action == 'agent' OR 'supermanager'
			if( $action == 'supermanager'){
				//pending_price = 4 (Request to super manager) 
				$update_data["pending_price"] = 4;
				$to		 = super_manager_email();
				$subject = "trackitinerary <Price verfiy/update request of Itinerary id: {$iti_id}>";
				$msg = "Price request to update by manager.Click below link to update/verfiy price.<br>";
				$msg .= "{$link}";
			}else{
				//pending_price = 2 (for approved price) 
				$update_data["pending_price"] = 2;
				//Message to agent
				$to		 = get_user_email($agent_id);
				$subject = "trackitinerary <Price Updated of Itinerary id: {$iti_id}>";
				$msg = "Price successfully updated by manager.Click below link to view itinerary.<br>";
				$msg .= "{$link}";
			}

			//Update data	
			$where = array('iti_id' => $iti_id ); 
			$update = $this->global_model->update_data("itinerary", $where, $update_data );
			if( $update ){
				//sent mail to Super Manager for update price
				$sent_mail = sendEmail($to, $subject, $msg);
				$res = array('status' => true, 'msg' => "Data save.");
			}else{
				$res = array('status' => false, 'msg' => "Data not save.");
			}			
		}else{
			$res = array('status' => false, 'msg' => "Data not save.");
		}	
		die(json_encode($res));
	}
	
	
	//update price by Super manager
	public function update_price_supermanager(){
		
		if( isset($_POST["iti_id"]) && !empty( $_POST["iti_id"]) ){
			$iti_id 			= trim( $_POST['iti_id'] );
			$agent_id 			= trim( $_POST['agent_id'] );
			$temp_key 			= trim( $_POST['temp_key'] );
			$rate_comment 		= strip_tags( $_POST['rate_comment'] );
			$hotel_rate_meta	= serialize($this->input->post('rate_meta'));
			
			//$res = array('status' => false, 'msg' => "Data not save. $rate_comment");
			//die( json_encode( $res ) );
			
			//Update data 
			$update_data = array(
				'rates_meta'			=> $hotel_rate_meta,
				'rate_comment'			=> $rate_comment,
				'pending_price'			=> 2,
				'iti_status'			=> 0,
				'publish_status'		=> "publish",
				'approved_price_date'	=> current_datetime(),
			);
			
			$link = "<a class='btn btn-success' target='_blank' href=" . site_url("itineraries/view/{$iti_id}/{$temp_key}") . " title='View'>Click to view itinerary</a>";
			
			//Message to agent
			$to		 = get_user_email($agent_id);
			$subject = "trackitinerary <Price Updated of Itinerary id: {$iti_id}>";
			$msg = "Price successfully updated by manager.Click below link to view itinerary.<br>";
			$msg .= "{$link}";
			//Update data	
			$where = array('iti_id' => $iti_id ); 
			$update = $this->global_model->update_data("itinerary", $where, $update_data );
			if( $update ){
				//sent mail to Super Manager for update price
				$sent_mail = sendEmail($to, $subject, $msg);
				$res = array('status' => true, 'msg' => "Data save.");
			}else{
				$res = array('status' => false, 'msg' => "Data not save.");
			}			
		}else{
			$res = array('status' => false, 'msg' => "Data not save.");
		}	
		die(json_encode($res));
	}
	
	//Reject Itinerary
	public function reject_itinerary(){
		
		if( isset($_POST["iti_id"]) && !empty($_POST["iti_id"]) ){
			$iti_id = trim( $_POST['iti_id'] );
			$agent_id = trim( $_POST['agent_id'] );
			$iti_reject_comment = strip_tags( $this->input->post('iti_reject_comment', true) );
			$temp_key = get_iti_temp_key( $iti_id );
			//iti_status 6 for rejected itinerary
			$update_data = array(
				'iti_status'			=> 6,
				'pending_price'			=> 0,
				'iti_reject_comment'	=> $iti_reject_comment,
			);
			
			//Update data 
			$where = array('iti_id' => $iti_id ); 
			$update = $this->global_model->update_data("itinerary", $where, $update_data );
			if( $update ){
				//sent mail to agent after price updated
				$link = "<a class='btn btn-success' target='_blank' href=" . site_url("itineraries/view/{$iti_id}/{$temp_key}") . " title='View'>Click to view itinerary</a>";
				$to		 = get_user_email($agent_id);;
				$subject = "trackitinerary < Itinerary Rejected Itinerary id: {$iti_id}>";
				$msg = "Itinerary rejected by manager.Click below link to view itinerary.<br>";
				$msg .= "{$link}";
				
				$sent_mail = sendEmail($to, $subject, $msg);
				$res = array('status' => true, 'msg' => "Data save.");
			}else{
				$res = array('status' => false, 'msg' => "Data not save.");
			}
		}else{
			$res = array('status' => false, 'msg' => "Invalid Request.");
		}	
		die(json_encode($res));
	}
	
	//ajax request to update Itineraries call log
	public function updateItiStatus(){
		$iti_id					= strip_tags($this->input->post("iti_id", TRUE));
		$iti_type				= strip_tags($this->input->post("iti_type", TRUE));
		$tmp					= strip_tags($this->input->post("temp_key", TRUE));
		$customer_id			= strip_tags($this->input->post("customer_id", TRUE));
		$agent_id				= strip_tags($this->input->post("agent_id", TRUE));
		$callType 				= strip_tags($this->input->post("callType", TRUE));
		$callSummary 			= strip_tags($this->input->post("callSummary", TRUE));
		$callSummaryNotpicked 	= strip_tags($this->input->post("callSummaryNotpicked", TRUE));
		$nextCallTime 			= strip_tags($this->input->post("nextCallTime", TRUE));
		$nextCallTimeNotpicked 	= strip_tags($this->input->post("nextCallTimeNotpicked", TRUE));
		$txtProspect 			= strip_tags($this->input->post("txtProspect", TRUE));
		$txtProspectNotpicked 	= strip_tags($this->input->post("txtProspectNotpicked", TRUE));
		$final_amount 			= strip_tags($this->input->post("final_amount", TRUE));
		$parent_iti_idIti 		= strip_tags($this->input->post("parent_iti_id", TRUE));
		$comment 				= strip_tags($this->input->post("comment", TRUE));
		$currentDate 			= current_datetime();
		
		//Get customer info
		$get_customer_info 	= get_customer( $customer_id ); 
		$cust				= $get_customer_info[0];
		$customer_name 		= $cust->customer_name;
		$customer_contact	= $cust->customer_contact;
		$customer_email		= $cust->customer_email;
		
		if( !empty($iti_id) && !empty($callType)){
			if( $callType == "Picked call" ){
				$call_smry = $callSummary;
				$lead_status = $txtProspect;
				$nxt_call = $nextCallTime;
			}else if( $callType == "Call not picked" ){
				$call_smry = $callSummaryNotpicked;
				$lead_status = $txtProspectNotpicked;
				$nxt_call = $nextCallTimeNotpicked;
			}else if( $callType == "Close lead" ){
				//if itinerary declined by client
				$where_iti = array( "iti_id" => $iti_id );
				$call_smry = $this->input->post('iti_note_decline', TRUE);
				$decline_comment = $this->input->post('decline_comment',TRUE);
				$lead_status = "";
				$nxt_call = "";
				//Get Current Itinerary data
				$data_iti = $this->global_model->getdata( "itinerary", $where_iti);
				$c_data = $data_iti[0];
				$parent_iti_id = $c_data->parent_iti_id;
				$temp_key = $c_data->temp_key;
				
				//count if parent id exists delete other itineries
				if( $parent_iti_id !== 0 && !empty( $parent_iti_id ) ){
					$del_where = array( "parent_iti_id" => $parent_iti_id , "temp_key !=" => $temp_key );
					$orWhere = array( "iti_id" => $parent_iti_id );
					$this->itinerary_model->delete_data( "itinerary", $del_where, $orWhere); 
					
					//Delete ITI followUpData
					$this->itinerary_model->delete_data( "iti_followup", $del_where, $orWhere); 
				}
				
				//count if current itinerary have child itineraries
				$countChildIti = $this->global_model->count_all( 'itinerary', array("parent_iti_id" => $iti_id) );
				//delete other itinerary
				if( $countChildIti > 0 ){
					$del_where = array( "parent_iti_id" => $iti_id );
					$this->global_model->delete_data( "itinerary", $del_where);
					//Delete ITI followUpData					
					$this->global_model->delete_data( "iti_followup", $del_where); 
				}
				
				$u_data = array( "followup_status" => $call_smry, "decline_comment" => $decline_comment, "iti_status" => 7, "iti_decline_approved_date" => current_datetime(), "parent_iti_id" => 0, "discount_rate_request" => 0 );
				$update_status = $this->global_model->update_data( "itinerary", $where_iti, $u_data );
			}elseif( $callType == "Booked lead" ){
				$where_iti = array( "iti_id" => $iti_id );
				$iti_note = $this->input->post('iti_note_booked');
				$call_smry = $this->input->post('iti_note_booked');
				$approved_package_category = $this->input->post('approved_package_category');
				$lead_status = "";
				$nxt_call = "";
				
				/* Add Payment Details */
				$advance_recieve 	= strip_tags($this->input->post("advance_recieve", TRUE));
				$next_payment_bal 	= strip_tags($this->input->post("next_payment_bal", TRUE));
				$next_payment_date 	= strip_tags($this->input->post("next_payment_date", TRUE));
				
				$third_payment_bal 	= strip_tags($this->input->post("third_payment_bal", TRUE));
				$third_payment_date = strip_tags($this->input->post("third_payment_date", TRUE));
				$final_payment_bal 	= strip_tags($this->input->post("final_payment_bal", TRUE));
				$final_payment_date = strip_tags($this->input->post("final_payment_date", TRUE));
				
				$total_balance 		= strip_tags($this->input->post("total_balance", TRUE));
				$bank_name 			= strip_tags($this->input->post("bank_name", TRUE));
				$transaction_date 	= strip_tags($this->input->post("transaction_date", TRUE));
				$travel_date		= strip_tags($this->input->post("travel_date", TRUE));
				$booking_date		= strip_tags($this->input->post("booking_date", TRUE));
				
				$f_amount 			= $final_payment_bal;
				
				if( empty( $advance_recieve ) &&  empty( $bank_name ) && empty($final_amount) ){
					$res = array('status' => false, 'msg' => "All Fields are required!");
					die( json_encode($res) );
				}elseif( trim($final_amount) < trim( $advance_recieve ) || !is_numeric( $advance_recieve ) || !is_numeric( $final_amount ) ){
					$res = array('status' => false, 'msg' => "Please Enter Valid Amount!");
					die( json_encode($res) );
				}
				
				$nxtPay 		= !empty( $next_payment_bal ) ? $next_payment_date : "";
				$third_ins_date = !empty( $third_payment_bal ) ? $third_payment_date : "";
				$f_date 		= !empty( $f_amount ) ? $final_payment_date : "";
				
				//Check for paid/unpaid
				$secPaid 		= !empty( $next_payment_bal ) ? "unpaid" : "";
				$thr_paid 		= !empty( $third_payment_bal ) ? "unpaid" : "";
				$f_paid 		= !empty( $f_amount ) ? "unpaid" : "";
				
				//payment details
				$payData = array(
					'iti_id' 				=> $iti_id,
					'iti_type' 				=> $iti_type,
					'customer_id'			=> $customer_id,
					'customer_name'			=> $customer_name,
					'customer_email'		=> $customer_email,
					'customer_contact'		=> $customer_contact,
					'total_package_cost'	=> $final_amount,
					'advance_recieved'		=> $advance_recieve,
					'bank_name'				=> $bank_name,
					'advance_trans_date'	=> $transaction_date,
					'booking_date'			=> $booking_date,
					'next_payment'			=> $next_payment_bal,
					'next_payment_due_date'	=> $nxtPay,
					'second_payment_bal'	=> $next_payment_bal,
					'second_payment_date'	=> $nxtPay,
					'second_pay_status'		=> $secPaid,
					'third_payment_bal'		=> $third_payment_bal,
					'third_payment_date'	=> $third_ins_date,
					'third_pay_status'		=> $thr_paid,
					'final_payment_bal'		=> $f_amount,
					'final_payment_date'	=> $f_date,
					'final_pay_status'		=> $f_paid,
					'total_balance_amount'	=> $total_balance,
					'travel_date'			=> $travel_date,
					'approved_note'			=> $iti_note,
					'agent_id'				=> $agent_id,
				);
				
				//check if iti id exists
				$pay_id = $this->global_model->getdata("iti_payment_details", array( "iti_id" => $iti_id ) );
				if( empty( $pay_id ) ){
					$insert_payment_details = $this->global_model->insert_data( "iti_payment_details", $payData );
					if ( !$insert_payment_details ){
						$res = array('status' => false, 'msg' => "Payment not updated please try again later!");
						die( json_encode($res) );
					}	
				}else{
					$updatePay = $this->global_model->update_data( "iti_payment_details", array("iti_id" => $iti_id), $payData );
					if ( !$updatePay ){
						$res = array('status' => false, 'msg' => "Payment not updated please try again later!");
						die( json_encode($res) );
					}	
				}
				/* End Payment Details Section */
				
				//Get Current Itinerary data
				$data_iti 		= $this->global_model->getdata( "itinerary", $where_iti);
				$c_data 		= $data_iti[0];
				$parent_iti_id 	= $c_data->parent_iti_id;
				$temp_key 		= $c_data->temp_key;
				
				//count if parent id exists delete other itineries
				if( $parent_iti_id !== 0 && !empty( $parent_iti_id ) ){
					$del_where = array( "parent_iti_id" => $parent_iti_id , "temp_key !=" => $temp_key );
					$orWhere = array( "iti_id" => $parent_iti_id );
					$this->itinerary_model->delete_data( "itinerary", $del_where, $orWhere); 
					//Delete ITI followUpData
					$this->itinerary_model->delete_data( "iti_followup", $del_where, $orWhere); 
				}
				
				//count if current itinerary have child itineraries
				$countChildIti = $this->global_model->count_all( 'itinerary', array("parent_iti_id" => $iti_id) );
				//delete other itinerary
				if( $countChildIti > 0 ){
					$del_where = array( "parent_iti_id" => $iti_id );
					$this->global_model->delete_data( "itinerary", $del_where); 
					$this->global_model->delete_data( "iti_followup", $del_where); 
				}
				
				//update itinerary data
				$u_data = array( 
					"final_amount" => $final_amount,
					"followup_status" => $iti_note,
					"parent_iti_id" => 0,
					"discount_rate_request" => 0,
					"iti_decline_approved_date" => current_datetime(),
					"approved_package_category" => $approved_package_category,
					"iti_status" => 9 
				);
				$update_status = $this->global_model->update_data( "itinerary", $where_iti, $u_data );
				
				//sent mail to admin/manager/customer
				$manager_email 	= manager_email();
				$hotel_booking_email = hotel_booking_email();
				$admins 		= array( $manager_email, $hotel_booking_email, "accounts1@Trackitinerary.in" );
				$to				= get_customer_email( $customer_id );
				
				//sent mail to agent after price updated
				$link = "<a class='btn btn-success' target='_blank' href=" . site_url("itineraries/view/{$iti_id}/{$tmp}") . " title='View'>Click to view itinerary</a>";
				$linkClientView = "<a title='View' target='_blank' href=" . site_url("promotion/itinerary/{$iti_id}/{$tmp}") . " class='btn btn-success' >Click to check itinerary</a>";
				$sub 			= "New Itinerary Booked <Trackitinerary.org>";
				$msg 			= "Itinerary Booked <br>";
				$msg 			.= "Final Amount: {$final_amount} <br>";
				$msg 			.= "Itinerary Id: {$iti_id} <br>";
				$msg 			.= "Customer Name: {$customer_name} <br>";
				$msg 			.= "{$link}<br>";
				$sub_c 			= "Itinerary Booked <Trackitinerary.org>";
				$msg_c 			= "Itinerary Booked <br>";
				$msg_c 			.= "Final Amount: {$final_amount} <br>";
				$msg_c 			.= "Itinerary Id: {$iti_id} <br>";
				$msg_c 			.= "{$linkClientView}<br>";
				//send mail to customer
				$sent_mail	 = sendEmail($to, $sub_c, $msg_c);
				//send mail to manager and admin
				$sent_mail_admins	 = sendEmail($admins, $sub, $msg);
				
				/* send msg for customer on Itinerary Booked */
				$iti_link = site_url("promotion/itinerary/{$iti_id}/{$tmp}");
				$mobile_customer_sms = "Your itinerary is booked. Please {$iti_link} .For more info contact us. Thanks<Trackitinerary>";
				$cus_mobile = "{$customer_contact}";
				if( !empty( $cus_mobile ) ){
					$sendcustomer_sms = pm_send_sms( $cus_mobile, $mobile_customer_sms );
				}
			}
			
			//data to insert in followup table
			$data= array(
				'iti_id' 			=> $iti_id,
				'iti_type' 			=> $iti_type,
				'temp_key' 			=> $tmp,
				'callType' 			=> $callType,
				'callSummary' 		=> $call_smry,
				'comment' 			=> $comment,
				'nextCallDate'		=> $nxt_call,
				'itiProspect'		=> $lead_status,
				'agent_id'			=> $agent_id,
				'currentCallTime'	=> $currentDate,
				'parent_iti_id'		=> $parent_iti_idIti,
			);
			
			//Update iti followUp call_status of current and parent_iti_id if exists
			$upf_data = array( "call_status" => 1 );
			$this->itinerary_model->update_iti_followup_status($iti_id, $parent_iti_idIti);
			
			$insert_id = $this->global_model->insert_data( "iti_followup", $data );
			if( $insert_id ){
				$res = array('status' => true, 'msg' => "Call log detail update successfully!");
			}else{
				$res = array('status' => false, 'msg' => "Call log detail not update successfully!");
			}	
		}else{
			$res = array('status' => false, 'msg' => "Invalid request please try again later!");
		}
		die( json_encode($res) );
	}
	
	//get client comment popup
	public function client_comment_popup(){
		$id = $this->input->post('iti_id');
		$where = array( "iti_id" => $id );
		$data_iti = $this->global_model->getdata( "itinerary", $where);
		if( $data_iti){
			$data = $data_iti[0];
			$comment = $data->client_comment;
			$printData = "<br>Client Comment: {$comment}";
			$res = array('status' => true, 'data' => $printData);
		}else{
			$res = array('status' => false, 'data' => "Error! please try again later");
		}
		die(json_encode($res));
	} 
	
	//Update Discount Price By Manager
	public function update_discount_price(){
		$user = $this->session->userdata('logged_in');
		if( $user['role'] == 98 || $user['role'] == 99 ){
			if( isset($_POST["iti_id"]) ){
				$iti_id = trim( $_POST['iti_id'] );
				$temp_key				= $this->input->post('temp_key');
				$customer_id			= $this->input->post('customer_id');
				$standard_rates			= $this->input->post('standard_rates');
				$deluxe_rates			= $this->input->post('deluxe_rates');
				$super_deluxe_rates		= $this->input->post('super_deluxe_rates');
				$luxury_rates			= $this->input->post('luxury_rates');
				$user_id				= $this->input->post('user_id');
				$agent_id				= $this->input->post('agent_id');
			
				//get customer info 
				$get_customer_info = get_customer( $customer_id ); 
				$cust = $get_customer_info[0];
				$customer_name = $cust->customer_name;
				$customer_contact = $cust->customer_contact;
				$customer_email = $cust->customer_email;
				
				//update discount rate status
				$update_data = array(
					'discount_rate_request'	 	=> 0,
					'approved_price_date'		=> current_datetime(),
				);
				//Update data discount status
				$where = array('iti_id' => $iti_id ); 
				$update = $this->global_model->update_data("itinerary", $where, $update_data );
				
				//insert data
				$insert_data = array(
					'iti_id'			 => $iti_id,
					'standard_rates'	 => $standard_rates,
					'deluxe_rates'		 => $deluxe_rates,
					'super_deluxe_rates' => $super_deluxe_rates,
					'luxury_rates'		 => $luxury_rates,
					'agent_id'			 => $user_id,
				);
				
				//insert data to price discount table
				$insert = $this->global_model->insert_data("itinerary_discount_price_data", $insert_data );
				if( $update ){
					//Sent Mail to Customer 
					$link1 = "<a title='View' target='_blank' href=" . site_url("promotion/itinerary/{$iti_id}/{$temp_key}") . " class='btn btn-success' >Click to check itinerary</a>";
					
					$to_c = get_customer_email( $customer_id );
					$sub = "Check new rates on your itinerary <Trackitinerary.org>";
					$msgs = "New rates updated on your itinerary please check below link.<br>";
					$msgs .= "{$link1}";
					sendEmail($to_c, $sub, $msgs); 
					
					/* send msg for customer on price updated */
					$iti_link = site_url("promotion/itinerary/{$iti_id}/{$temp_key}");
					$mobile_customer_sms = "Discount Price Updated on your itinerary. Please {$iti_link} .Thanks <Trackitinerary Pvt Ltd.>";
					$cus_mobile = "{$customer_contact}";
					if( !empty( $cus_mobile ) ){
						$sendcustomer_sms = pm_send_sms( $cus_mobile, $mobile_customer_sms );
					}  
					
					//sent mail to agent after price updated
					$link = "<a class='btn btn-success' target='_blank' href=" . site_url("itineraries/view/{$iti_id}/{$temp_key}") . " title='View'>Click to view itinerary</a>";
					$to		 = get_user_email( $agent_id );
					$subject = "trackitinerary <Price Updated of Itinerary id: {$iti_id}>";
					$msg = "Price successfully updated by manager.Click below link to view itinerary.<br>";
					$msg .= "{$link}";
					
					sendEmail($to, $subject, $msg);
					
					$res = array('status' => true, 'msg' => "Data save.");
				}else{
					$res = array('status' => false, 'msg' => "Data not save.");
				}
			}else{
				$res = array('status' => false, 'msg' => "Invalid Request.");
			}	
			die(json_encode($res));
		}	
	} 
	
	
	/* clone itinerary */
	function duplicate(){
		$user = $this->session->userdata('logged_in');
		if( $user['role'] == 98 || $user['role'] == 99 || $user['role'] == 96 ){
			$iti_id = $this->uri->segment(3);
			//Count All Child Itineraries
			$countChildIti = $this->global_model->count_all( 'itinerary', array("parent_iti_id" => $iti_id, "del_status" => 0) );
			$getItiData =  $this->global_model->getdata('itinerary', array("iti_id" => $iti_id, "del_status" =>0) );
			$iti_data = $getItiData[0];	
			
			if( $countChildIti < 6 && $iti_data->publish_status == "publish" ){
				$insert_id = $this->itinerary_model->duplicate_itinerary("itinerary", "iti_id", $iti_id);
				if( $insert_id ){
					$getNewIti =  $this->global_model->getdata('itinerary', array("iti_id" => $insert_id, "del_status" =>0 ) );
					$iti_dataNew = $getNewIti[0];	
					$temp_key = $iti_dataNew->temp_key;	
					$newItiId = $insert_id;
					
					//clone flight data if exists
					if( $iti_data->is_flight == 1 ){
						$in_fid = $this->itinerary_model->clone_flight_train_data("flight_details", "iti_id", $iti_id, $newItiId);
					}
					
					//clone Train data if exists
					if( $iti_data->is_train == 1 ){
						$in_tid = $this->itinerary_model->clone_flight_train_data("train_details", "iti_id", $iti_id, $newItiId);
					}
					
					//redirect to edit page
					$redirect_url = site_url("itineraries/edit/{$insert_id}/{$temp_key}");
					redirect( $redirect_url );
					exit;
				}else{
					echo "Error";
				}
			}else{
				echo "Your already clone five itineraries against this Itinerary ID Or Itinerary not publish";
			}
		}else{
			redirect("dashboard");
		}	
	}
	
	/* clone of child itinerary */
	function duplicate_child_iti(){
		$user = $this->session->userdata('logged_in');
		if( $user['role'] == 98 || $user['role'] == 99 || $user['role'] == 96 ){
			if( isset( $_GET['iti_id'] ) && isset( $_GET[ 'parent_iti_id' ] ) && !empty( $_GET['iti_id'] ) ){
				$iti_id = $_GET['iti_id'];
				$parent_iti_id = $_GET[ 'parent_iti_id' ];
				
				//Count All Child Itineraries
				$ckeck_valid_pid = $this->global_model->count_all( 'itinerary', array("iti_id" => $parent_iti_id, "del_status" => 0) );
				
				$countChildIti = $this->global_model->count_all( 'itinerary', array("parent_iti_id" => $parent_iti_id, "del_status" => 0) );
				$getItiData =  $this->global_model->getdata('itinerary', array("iti_id" => $iti_id, "del_status" =>0) );
				$iti_data = $getItiData[0];	
				
				if( $countChildIti < 6 && !empty($iti_data) && !empty($ckeck_valid_pid) ){
					$insert_id = $this->itinerary_model->duplicate_itinerary( "itinerary", "iti_id", $iti_id, $parent_iti_id );
					if( $insert_id ){
						$getNewIti =  $this->global_model->getdata('itinerary', array("iti_id" => $insert_id, "del_status" =>0 ) );
						$iti_dataNew = $getNewIti[0];	
						$temp_key = $iti_dataNew->temp_key;	
						$newItiId = $insert_id;
						
						//clone flight data if exists
						if( $iti_data->is_flight == 1 ){
							$in_fid = $this->itinerary_model->clone_flight_train_data("flight_details", "iti_id", $iti_id, $newItiId);
						}
						
						//clone Train data if exists
						if( $iti_data->is_train == 1 ){
							$in_tid = $this->itinerary_model->clone_flight_train_data("train_details", "iti_id", $iti_id, $newItiId);
						}
						
						//redirect to edit page
						$redirect_url = site_url("itineraries/edit/{$insert_id}/{$temp_key}");
						redirect( $redirect_url );
						exit;
					}else{
						die("Error: Please try again later." );
					}
				}else{
					echo "Your already clone six itineraries against this Itinerary. OR Invalid Itinerary Id";
				}
			}else{
				die("Invalid request");
			} 
		}else{
			redirect("dashboard");
		}	
	}
	
	/* View all child itineraries */
	public function childIti(){
		$iti_id = $this->uri->segment(3);
		$temp_key = $this->uri->segment(4);
		
		$user = $this->session->userdata('logged_in');
		$role = $user["role"];
		$u_id = $user["user_id"];
		$data["currentIti"] = $iti_id;
		$data["currentItiKey"] = $temp_key;
		$data["role"] = $role;
		//get FolloupData
		$where = array( "parent_iti_id" => $iti_id );
		$orwhere = array( "iti_id" => $iti_id);
		$data["lastFollow"] = $this->itinerary_model->getchildItidata("iti_followup", $where, $orwhere,"iti_id","id", 1 );
		if( $role == '99' || $role == '98' ){
			$where = array( "parent_iti_id" => $iti_id,"del_status" => 0, "pending_price !=" => 0 );
			$orwhere = array( "iti_id" => $iti_id);
			$data["childIti"] = $this->itinerary_model->getchildItidata("itinerary", $where, $orwhere );
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('itineraries/child_iti', $data);
			$this->load->view('inc/footer'); 
		}elseif( $role == '96' ){	
			$where = array( "agent_id" => $u_id, "parent_iti_id" => $iti_id, "del_status" => 0 );
			$orwhere = array( "iti_id" => $iti_id);
			$data["childIti"] = $this->itinerary_model->getchildItidata("itinerary", $where, $orwhere);
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view('itineraries/child_iti', $data);
			$this->load->view('inc/footer'); 
		}else{
			redirect(404);
		} 
	}
	
	//Add New Comment
	public function ajax_add_agent_comment(){
		$iti_id 		= strip_tags($this->input->post('iti_id'));
		$temp_key 		= strip_tags($this->input->post('temp_key'));
		$client_comment = strip_tags($this->input->post('client_comment'));
		$customer_id	= strip_tags($this->input->post('customer_id'));
		$client_contact = strip_tags($this->input->post('client_contact'));
		$sec_key 		= $this->input->post('sec_key');
		$enc_key 		= md5( $this->config->item("encryption_key") );
		$agent_id		= $this->input->post('agent_id', true);
		
		//Get customer info
		$get_customer_info = get_customer( $customer_id ); 
		$cust			 = $get_customer_info[0];
		$client_name 	= $cust->customer_name;
		$client_contact = $cust->customer_contact;
		
		if( $sec_key !==  $enc_key  ){
			$res = array('status' => false, 'msg' => "Security Error! ");
			die(json_encode($res));
		}
		
		if( !empty($iti_id) && is_numeric( $iti_id )){
			$data = array( "iti_id" => $iti_id, "client_name" => $client_name,"temp_key"=> $temp_key, "comment_by" => "agent", "client_contact" => $client_contact,"agent_id" => $agent_id,"comment_content" => $client_comment );
			$insert = $this->global_model->insert_data("comments", $data );
			if( $insert ){
				//send email to customer
				$agent_username = get_user_name( trim($agent_id) );
				$link = "<a title='View' target='_blank' href=" . site_url("promotion/itinerary/{$iti_id}/{$temp_key}") . " class='btn btn-success' >Click to check itinerary</a>";
				$to = get_customer_email( $customer_id );
				$subject = "New comment on your itinerary <Trackitinerary.org>";
				$msg = "New comment on your itinerary by : <strong> {$agent_username} </strong>.<br>";
				$msg .= "{$link}";
				$sent_mail = sendEmail($to, $subject, $msg);
				
				$res = array('status' => true, 'msg' => "Your comment Submited successfully!");
				die(json_encode($res));
			}else{
				$res = array('status' => false, 'msg' => "Your comment not submit! Please try again.");
				die(json_encode($res));
			}
		}
	}
	
	//update comment status to read
	public function update_comment_status(){
		$id = $this->input->post('iti_id');
		$where = array( "iti_id" => $id );
		$up_data = array("client_comment_status" => 0 );
		$data_iti = $this->global_model->update_data( "itinerary", $where, $up_data);
		if( $data_iti){
			$res = array('status' => true, 'msg' => "done");
		}else{
			$res = array('status' => false, 'msg' => "Error! please try again later");
		}
		die(json_encode($res));
	} 
	
	//price update request to manager from agent
	public function priceReqestToManager(){
		$user = $this->session->userdata('logged_in');
		$iti_id		= $this->input->post('iti_id');
		$temp_key 	= $this->input->post('temp_key');
		
		$agent_id = $user['user_id'];
		$agent_username = get_user_name( trim($agent_id) );
		
		if( !empty( $iti_id ) && is_numeric($iti_id) ){
			$link = "<a class='btn btn-success' target='_blank' href=" . site_url("itineraries/view/{$iti_id}/{$temp_key}") . " title='View'>Click to view itinerary</a>";
			
			//update pending_price status
			$where = array( "iti_id" => trim($iti_id) );
			$update_data = $this->global_model->update_data("itinerary", $where, array( "pending_price" => 1, "pending_price_date" => current_datetime() ) );
			
			//sent mail to manager
			$manager_email = manager_email();
			$to		 = $manager_email;
			$subject = "trackitinerary <price update request of itinerary id: {$iti_id}>";
			$msg = "New itnerary created by <strong> {$agent_username} </strong>.<br>";
			$msg .= "{$link}";
			$sent_mail = sendEmail( $to, $subject, $msg );
			
			if( $sent_mail ){ 
				$res = array('status' => true, 'msg' => "Request Sent Successfully");
			}else{
				$res = array('status' => false, 'msg' => "Request not sent successfully");
			}	 
		}else{
			$res = array('status' => false, 'msg' => "Error! please try again later");
		}
		die(json_encode($res));
	} 
	
	//Discount price request agent to manager
	function updateDiscountPriceReq(){
		$iti_id 	= $this->input->post("iti_id", true);
		$temp_key	= $this->input->post("temp_key", true);
		$agent_id	= $this->input->post("agent_id", true);
		$agent_username = get_user_name( trim($agent_id) );
		$hotel_cat	= implode( ", ", $this->input->post("hotel_cat_dis", true) );
		$where = array( "iti_id" => $iti_id, "del_status" => 0, "temp_key" => $temp_key );
		/* //update Discount status */
		$up_data = array(
			'discount_rate_request'	 	=> 1,
			'dis_hotel_cat'			 	=> $hotel_cat,
			"pending_price_date" 		=> current_datetime(),
		);
		$update_data = $this->global_model->update_data( "itinerary", $where, $up_data ); 
		if( $update_data ){
			//sent mail to manager
			$link = "<a class='btn btn-success' target='_blank' href=" . site_url("itineraries/view/{$iti_id}/{$temp_key}") . " title='View'>Click to view itinerary</a>";
			$manager_email = manager_email();
			$to		 = $manager_email;
			$subject = "trackitinerary <Price Discount request of itinerary id: {$iti_id}>";
			$msg = "Price discount request by <strong> {$agent_username} </strong>.<br>";
			$msg .= "{$link}";
			
			sendEmail($to, $subject, $msg);
			
			$res = array('status' => true, 'msg' => "Discount request sent successfully.");
		}else{
			$res = array('status' => false, 'msg' => "Discount request not sent.");
		}
		die( json_encode($res) );
	}	
	
	/* //Sent Itinerary Email */
	public function sendItinerary(){
		$iti_id 			= $this->input->post("iti_id", true);
		$temp_key 			= $this->input->post("temp_key", true);
		$subject 			= $this->input->post("subject", true);
		$customer_email 	= $this->input->post("cus_email", true);
		$customer_contact 	= $this->input->post("contact_number", true);
		$bcc_emails 		= $this->input->post("bcc_email", true);
		$cc_email 			= $this->input->post("cc_email", true);
		$additonal_contact 	= $this->input->post("add_contact_number", true);
		
		$user = $this->session->userdata('logged_in');
		$user_id = $user['user_id'];
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '96'){
			if( empty($iti_id) && empty($temp_key)  ){
				$res = array('status' => false, 'msg' => "Invalid Itinerary Id.");
				die( json_encode($res) );
			}
			$where = array( "iti_id" => $iti_id, "temp_key" => $temp_key );
			$itinerary = $this->global_model->getdata("itinerary", $where);
			if($itinerary){
				$data['itinerary'] = $itinerary;
				$iti = $itinerary[0];
				$itinerary_id 	= $iti->iti_id;
				$customer_id 	= $iti->customer_id;
				//Get customer info
				$get_customer_info = get_customer( $iti->customer_id ); 
				$cust = $get_customer_info[0];
				$customer_name = $cust->customer_name;
				$customer_email = $cust->customer_email;
				$customer_contact = $cust->customer_contact;
			 
				/* Get Agent Information */
				$agent_id = $iti->agent_id;
				$from = get_user_email($agent_id);
				
				//Check if BCC and CC Email exists
				$bccEmails 	= !empty($bcc_emails) ? $bcc_emails : "";
				$ccEmails 	= !empty($cc_email) ? $cc_email : "";
				
				/* //get message template */
				if( $iti->iti_type == 2 ){
					$message = $this->load->view("accommodation/mail", $data, TRUE);
				}else{
					$message = $this->load->view("itineraries/mail", $data, TRUE);
				}	
				$to = trim( $customer_email );
				/*send email*/
				$sent_mail = sendEmail($to, $subject, $message, $bccEmails, $ccEmails);
				if( $sent_mail ){
					/* send msg for customer on itinerary send */
					$iti_link = site_url("promotion/itinerary/{$iti_id}/{$temp_key}");
					
					$mobile_customer_sms = "Itinerary send to your email {$customer_email}. If you not recieve itinerary in your inbox please find the mail in spam. {$iti_link} .Thanks <Trackitinerary Pvt Ltd.>";
					
					//Check if additional contact is not empty
					$addContact = !empty($additonal_contact) ? $additonal_contact : "";
					$cus_mobile = "{$customer_contact}, {$addContact}";
					if( !empty( $cus_mobile ) ){
						$sendcustomer_sms = pm_send_sms( $cus_mobile, $mobile_customer_sms );
					}
					
					/*Get total email sent to current itinerary*/
					$where = array( "iti_id" => $itinerary_id );
					$count_email = $this->global_model->getdata( "itinerary", $where, "email_count" );
					if( empty($count_email) ){
						$count_email = 0;
					}
					$email_inc = $count_email+1;
					
					/* update Email count status*/
					$up_data = array(
						'email_count' 			=> $email_inc,
						'quotation_sent_date' 	=> current_datetime(),
					);
					$where_iti = array( "iti_id" => $itinerary_id );
					$this->global_model->update_data( "itinerary", $where_iti, $up_data );
					
					//Insert data to email followup
					$inc_data = array(
						"iti_id" 			=> $itinerary_id,
						"customer_id" 		=> $customer_id,
						"customer_name" 	=> $customer_name,
						"customer_contact" 	=> $customer_contact,
						"customer_email" 	=> $customer_email,
						"agent_id" 			=> $user_id,
					);
					$this->global_model->insert_data("iti_email_followup", $inc_data);
					
					$res = array('status' => true, 'msg' => "Itinerary Sent Successfully!");
				}else{
					$res = array('status' => false, 'msg' => "Itinerary Not Sent. Please Try Again Later.");
				}				
				die( json_encode($res) );
			}
		}else{
			redirect(404);
		}		
	}
	
	/* View PDF */
	public function pdf(){
		$this->load->library('Pdf');
		$iti_id = trim($this->uri->segment(3));
		$temp_key = trim($this->uri->segment(4));
		
		if( !empty( $iti_id ) && !empty($temp_key) ){
			$user = $this->session->userdata('logged_in');
			$user_id = $user['user_id'];
			
			//Get itinerary 
			$where_i = array("del_status" => 0, "iti_id" => $iti_id, "temp_key" => $temp_key);
			$get_iti = $this->global_model->getdata( 'itinerary', $where_i );
			
			//get view folder
			$view_file = !empty( $get_iti ) && $get_iti[0]->iti_type == 2  ? "accommodation/pdf" : "itineraries/pdf";
			
			$data['flight_details'] = $this->global_model->getdata( "flight_details", array("iti_id" => $iti_id) );
			$data['train_details'] = $this->global_model->getdata( "train_details", array("iti_id" => $iti_id) );
			if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '97'){
				$data['discountPriceData'] 	= $this->global_model->getdata( 'itinerary_discount_price_data', array("iti_id" => $iti_id) );
				$where = array("del_status" => 0, "iti_id" => $iti_id, "temp_key" => $temp_key );
				$data['itinerary'] 	= $this->global_model->getdata( 'itinerary', $where );
				$this->load->view('inc/header');
				$this->load->view('inc/sidebar');
				$this->load->view($view_file, $data);
				$this->load->view('inc/footer');
			}elseif($user['role'] == '96'){
				$data['discountPriceData'] 	= $this->global_model->getdata( 'itinerary_discount_price_data', array("iti_id" => $iti_id) );
				$where = array("del_status" => 0, "agent_id" => $user_id, "iti_id" => $iti_id, "temp_key" => $temp_key );
				$data['itinerary'] 		= $this->global_model->getdata( 'itinerary', $where );
				$this->load->view('inc/header');
				$this->load->view('inc/sidebar');
				$this->load->view($view_file, $data);
				$this->load->view('inc/footer');
			}else{
				redirect("dashboard");
			}	 
		}else{
			redirect(404);
		}	
	}
	
	//Clone package to itinerary ajax request
	public function cloneItineraryFromPackageId(){
		$user = $this->session->userdata('logged_in');
		$user_id = $user["user_id"];
		
		$package_id 	= trim($this->input->post('package_id'));
		$customer_id 	= trim($this->input->post('customer_id'));
		$parent_iti_id 	= trim($this->input->post('parent_iti_id'));
		
		//get Agent ID of iti
		$agent_id = $this->global_model->getdata( "itinerary", array("iti_id" => $parent_iti_id), "agent_id" );
		$agent_id = !empty( $agent_id ) ? $agent_id : $user_id;
		
		if( !empty( $package_id ) && !empty( $customer_id ) &&  !empty( $parent_iti_id ) ){
			$insert_id = $this->itinerary_model->createItiFromPackageId("packages", "package_id", $package_id, $customer_id, $agent_id,$parent_iti_id );
			
			if( $insert_id ){
				$getNewIti =  $this->global_model->getdata('itinerary', $where = array("iti_id" => $insert_id) );
				$iti_dataNew = $getNewIti[0];	
				$new_iti_id = $iti_dataNew->iti_id;	
				$temp_key = $iti_dataNew->temp_key;	
				$res = array('status' => true, 'msg' => "Successfully Created" , "iti_id" => $new_iti_id, "temp_key" => $temp_key );
			}else{
				$res = array('status' => false, 'msg' => "Error! Please Try Again");
			}
		}else{
			$res = array('status' => false, 'msg' => "Error! All Fields are required");
		}	
		die(json_encode($res));
	}
	
	//Clone itinerary to amendment
	public function clone_iti_to_amendment(){
		$user = $this->session->userdata('logged_in');
		$user_id = $user['user_id'];
		$iti_id = trim($this->uri->segment(3));
		
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '96'){
			//Check if already amendment request
			$check_iti = $this->global_model->getdata("iti_amendment_temp", array( "iti_id" => trim($iti_id) ) );
			$total_amendments = !empty( $check_iti ) ? sizeof($check_iti) : 0 ;
			if( $total_amendments >= 3 ){
				$this->session->set_flashdata('error',"Only two amendment can created.");
				echo "You already created two amendments for this itinerary.For more info contact your manager/administrator.";
				die;
			}else{
				//clone iti to amendment table
				$insert_id = $this->itinerary_model->duplicate_itinerary_for_amendment("itinerary", "iti_id", $iti_id);
				
				//clone same iti to iti_before_amendment table if no amendment created
				if( empty($total_amendments) ){
					$old_iti_id = $this->itinerary_model->duplicate_itinerary_before_amendment("itinerary", "iti_id", $iti_id);
				}	
				
				if( $insert_id ){
					//Update parent itinerary amendment status
					$this->global_model->update_data("itinerary", array("iti_id" => $iti_id), array("is_amendment" => 1 ) );
					
					$getNewIti =  $this->global_model->getdata('iti_amendment_temp', array("id" => $insert_id ) );
					$iti_dataNew = $getNewIti[0];	
					$temp_key = $iti_dataNew->temp_key;	
					//redirect to edit page
					$redirect_url = site_url("itineraries/edit_amendment_iti/{$insert_id}/{$temp_key}");
					redirect( $redirect_url );
					exit;
				}else{
					echo "Error";
				}	
			}
		}else{
			redirect("dashboard");
		}	
	}
	
	/* Edit Amendment Itinerary */
	public function edit_amendment_iti(){
		$id			= trim($this->uri->segment(3));
		$temp_key 	= trim($this->uri->segment(4));
		$user 	= $this->session->userdata('logged_in');
		$user_id = $user['user_id'];
		$data["user_role"] = $user['role']; 
		if( $user['role'] == '99' || $user['role'] == '98'){
			$where = array("del_status" => 0, "id" => $id, "temp_key" => $temp_key );
			$get_iti = $this->global_model->getdata( "iti_amendment_temp", $where );
			$data['itinerary'] = $get_iti;
			//get view folder
			$view_file = !empty( $get_iti ) && $get_iti[0]->iti_type == 2  ? "accommodation/edit_amendment" : "itineraries/edit_amendment";
			
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view($view_file, $data);
			$this->load->view('inc/footer');
		}elseif( $user['role'] == '96' ){
			$where = array("del_status" => 0, "agent_id" => $user_id, "id" => $id, "temp_key" => $temp_key );
			$get_iti = $this->global_model->getdata( "iti_amendment_temp", $where );
			$data['itinerary'] = $get_iti;
			//get view folder
			$view_file = !empty( $get_iti ) && $get_iti[0]->iti_type == 2  ? "accommodation/edit_amendment" : "itineraries/edit_amendment";
			
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view($view_file, $data);
			$this->load->view('inc/footer');
		}else{
			redirect("dashboard");
		}	 
	}
	
	//Edit amendment itinerary
	public function ajax_amendment_iti_savedata(){
		$user = $this->session->userdata('logged_in');
		$role = $user['role'];
		
		if( isset($_POST["temp_key"]) && isset( $_POST['step'] ) ){
			$unique_id = trim( $_POST['temp_key'] );
			$id			= trim( $_POST['id'] );
			$step 	= trim($_POST['step']);
			switch( $step ){
				case 1:  
					$package_name 		= strip_tags($_POST['package_name']);
					$package_routing 	= strip_tags($_POST['package_routing']);
					$adults				= strip_tags($_POST['adults']);
					$child				= strip_tags($_POST['child']);
					$child_age			= strip_tags($_POST['child_age']);
					$package_duration 	= strip_tags($_POST['package_duration']);
					$cab_category 		= strip_tags($_POST['cab_category']);
					
					$step_data = array(
						'package_name' 		=> $package_name,
						'temp_key'			=> $unique_id,
						'package_routing'	=> $package_routing,
						'cab_category'		=> $cab_category,
						'adults'			=> $adults,
						'child'				=> $child,
						'child_age'			=> $child_age,
						'duration'			=> $package_duration,
					);
				break;
				case 2:
					$daywise_meta 		= serialize($this->input->post('tour_meta', TRUE));
					$step_data = array(
						'daywise_meta' 	=> $daywise_meta,
					);
				break;
				case 3:
					$inc_meta					= serialize($this->input->post('inc_meta', TRUE));
					$exc_meta					= serialize($this->input->post('exc_meta', TRUE));
					$special_inc_meta			= serialize($this->input->post('special_inc_meta', TRUE));
					$step_data = array(
						'inc_meta'					=> $inc_meta,
						'exc_meta'					=> $exc_meta,
						'special_inc_meta'			=> $special_inc_meta,
					);
				break;
				case 4:
					$currentDate = $date;
					$hotel_meta				= serialize( $this->input->post('hotel_meta', TRUE) );
					$hotel_note_meta		= serialize( $this->input->post('hotel_note_meta', TRUE) );
					$new_package_cost 		= $this->input->post("new_package_cost", TRUE);
					$step_data = array(
						'hotel_meta'			=> $hotel_meta,
						'hotel_note_meta'		=> $hotel_note_meta,
						'new_package_cost'		=> $new_package_cost,
					);
				break;
			}
			
			//Update data 
			$where_key = array('id' => $id ); 
			$update_data = $this->global_model->update_data("iti_amendment_temp", $where_key, $step_data );
			
			if( $update_data ){
				$res = array('status' => true, 'msg' => "Data save.");
			}else{
				$res = array('status' => false, 'msg' => "Error! Data not save.");
			}
		}else{
			$res = array('status' => false, 'msg' => "Failed! Invalid request try again.");
		}
		die(json_encode($res));
	}
	
	//View Old Itinerary before amendment
	public function view_old_iti(){
		$user = $this->session->userdata('logged_in');
		$user_id = $user['user_id'];
		$data["user_id"] = $user_id;
		$data["user_role"] = $user['role']; 
		$id = trim($this->uri->segment(3));
		
		
		if( $user['role'] == '99' || $user['role'] == '98' || $user['role'] == '97'){
			$where = array("del_status" => 0, "iti_id" => $id);
			$data['itinerary'] 	= $this->global_model->getdata( 'iti_before_amendment', $where );
			$iti_id = !empty( $data['itinerary'] ) ? $data['itinerary'][0]->iti_id : "";
			
			//get view folder
			$view_file = !empty( $data['itinerary'] ) && $data['itinerary'][0]->iti_type == 2  ? "accommodation/view_old_iti" : "itineraries/view_old_iti";
			
			//Get Payment Transaction Details
			$data["payment_details"] = $this->global_model->getdata("iti_payment_details", array("iti_id" => $iti_id) );
			
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view($view_file, $data);
			$this->load->view('inc/footer');
		}elseif($user['role'] == '96'){
			$where = array("del_status" => 0, "agent_id" => $user_id, "iti_id" => $id, );
			$data['itinerary'] = $this->global_model->getdata( 'iti_before_amendment', $where );
			$iti_id = !empty( $data['itinerary'] ) ? $data['itinerary'][0]->iti_id : "";
			//Get Payment Transaction Details
			$data["payment_details"] = $this->global_model->getdata("iti_payment_details", array("iti_id" => $iti_id) );
			
			//get view folder
			$view_file = !empty( $data['itinerary'] ) && $data['itinerary'][0]->iti_type == 2  ? "accommodation/view_old_iti" : "itineraries/view_old_iti";
			
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view($view_file, $data);
			$this->load->view('inc/footer');
		}else{
			redirect("dashboard");
		}
	}
	//Amendment Itinerary View
	public function view_amendment(){
		$user = $this->session->userdata('logged_in');
		$user_id = $user['user_id'];
		$data["user_id"] = $user_id;
		$data["user_role"] = $user['role']; 
		$id = trim($this->uri->segment(3));
		
		if( $user['role'] == '99' || $user['role'] == '98'){
			$where = array("del_status" => 0, "id" => $id);
			$data['itinerary'] 	= $this->global_model->getdata( 'iti_amendment_temp', $where );
			$iti_id = !empty( $data['itinerary'] ) ? $data['itinerary'][0]->iti_id : "";
			
			//get view folder
			$view_file = !empty( $data['itinerary'] ) && $data['itinerary'][0]->iti_type == 2  ? "accommodation/view_amendment" : "itineraries/view_amendment";
			
			//Get Payment Transaction Details
			$data["payment_details"] = $this->global_model->getdata("iti_payment_details", array("iti_id" => $iti_id) );
			
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view($view_file, $data);
			$this->load->view('inc/footer');
		}elseif($user['role'] == '96'){
			$where = array("del_status" => 0, "agent_id" => $user_id, "id" => $id, );
			$data['itinerary'] = $this->global_model->getdata( 'iti_amendment_temp', $where );
			$iti_id = !empty( $data['itinerary'] ) ? $data['itinerary'][0]->iti_id : "";
			//Get Payment Transaction Details
			$data["payment_details"] = $this->global_model->getdata("iti_payment_details", array("iti_id" => $iti_id) );
			
			//get view folder
			$view_file = !empty( $data['itinerary'] ) && $data['itinerary'][0]->iti_type == 2  ? "accommodation/view_amendment" : "itineraries/view_amendment";
			
			$this->load->view('inc/header');
			$this->load->view('inc/sidebar');
			$this->load->view($view_file, $data);
			$this->load->view('inc/footer');
		}else{
			redirect("dashboard");
		}
	}
	
	//Amendment request to manager by agent
	public function amendment_price_request_to_manager(){
		$user 			= $this->session->userdata('logged_in');
		$user_id 		= $user['user_id'];
		$iti_id		 	= $this->input->post('iti_id', TRUE);
		$id 			= $this->input->post('id', TRUE);
		$review_comment = strip_tags($this->input->post('review_comment', TRUE));
		
		$agent_username = get_user_name( trim( $user_id ) );
		
		if( !empty( $iti_id ) && is_numeric($iti_id) ){
			$link = "<a class='btn btn-success' target='_blank' href=" . site_url("itineraries/view_amendment/{$id}") . " title='View'>Click to view itinerary</a>";
			
			//update pending_price status
			$where = array( "id" => trim($id) );
			$update_data = $this->global_model->update_data("iti_amendment_temp", $where, array("sent_for_review" => 1, "review_update_date" => current_datetime(), "review_comment" => $review_comment ) );
			
			//sent mail to manager
			$manager_email = manager_email();
			$admin_email = admin_email();
			$to	= array( $manager_email, $admin_email );
			$subject = "trackitinerary <price Amendment request of itinerary id: {$iti_id}>";
			$msg = "Itnerary amendment request By Agent: <strong> {$agent_username} </strong>.<br>";
			$msg .= "{$link}";
			$sent_mail = sendEmail($to, $subject, $msg);
			if( $sent_mail ){ 
				$res = array('status' => true, 'msg' => "Request Sent Successfully");
			}else{
				$res = array('status' => false, 'msg' => "Request not sent successfully");
			}	 
		}else{
			$res = array('status' => false, 'msg' => "Error! please try again later");
		}
		die(json_encode($res));
	}
	
	//update Amendment price by manager
	public function update_amendment_price_by_manager(){
		if( isset($_POST["iti_id"]) && !empty($_POST["new_package_cost"]) ){
			$iti_id = trim( $_POST['iti_id'] );
			$agent_id = trim( $_POST['agent_id'] );
			$id = trim( $_POST['id'] );
			$new_package_cost	= strip_tags($this->input->post('new_package_cost', TRUE));
			
			//pending_price = 2 (for approved price) 
			$update_data = array(
				'new_package_cost'		=> $new_package_cost,
				'sent_for_review'		=> 2,
				'review_update_date'	=> current_datetime(),
			);
			
			//Update data 
			$where = array('id' => $id ); 
			$update = $this->global_model->update_data("iti_amendment_temp", $where, $update_data );
			if( $update ){
				//sent mail to agent after price updated
				$link = "<a class='btn btn-success' target='_blank' href=" . site_url("itineraries/view_amendment/{$id}") . " title='View'>Click to view itinerary</a>";
				$to		 = get_user_email($agent_id);;
				$subject = "trackitinerary <Amendment In Price of Itinerary id: {$iti_id}>";
				$msg = "Price successfully updated by manager.Click below link to view itinerary.<br>";
				$msg .= "{$link}";
				
				$sent_mail = sendEmail($to, $subject, $msg);
				$res = array('status' => true, 'msg' => "Data save.");
			}else{
				$res = array('status' => false, 'msg' => "Data not save.");
			}
		}else{
			$res = array('status' => false, 'msg' => "Please Enter Valid New Price.");
		}	
		die(json_encode($res));
	}
	
	//Update hotel/volvo/flight booking status
	public function ajax_update_booking_status(){
		$user = $this->session->userdata('logged_in');
		$user_id = $user['user_id'];
		$iti_id 		= $this->input->post("iti_id", true);
		$booking_type 	= $this->input->post("type", true);
		//check if iti status already updated
		$check_iti = $this->global_model->getdata("iti_vouchers_status", array("iti_id" => $iti_id ));
		$data = array( "iti_id" => $iti_id, "" );
		
		if( $check_iti ){
			$up_data = array( $booking_type => 1, "agent_id" => $user_id  );
			$update_data	= $this->global_model->update_data("iti_vouchers_status", array("iti_id" => $iti_id ), $up_data );
		}else{
			$ins_d = array( $booking_type => 1, "iti_id" => $iti_id, "agent_id" => $user_id );
			$insert_data = $this->global_model->insert_data("iti_vouchers_status", $ins_d );
		}
		
		if( $update_data || $insert_data ){
			$this->session->set_flashdata('success',"Booking Status Updated Successfully.");
			$res = array( "status" => true, "msg" => "Booking Status Updated Successfully." );
		}else{
			$res = array( "status" => false, "msg" => "Booking Status Not Updated. Please try again." );
		}
		
		die( json_encode( $res ) );
	}	
	
	//Update Confirm voucher status
	public function ajax_confirm_voucher_status(){
		$user = $this->session->userdata('logged_in');
		$user_id = $user['user_id'];
		$iti_id 		= $this->input->post("iti_id", true);
		$agent_comment 	= $this->input->post("agent_comment", true);
		//check if iti status already updated
		$check_iti = $this->global_model->getdata("iti_vouchers_status", array("iti_id" => $iti_id ));
		$data = array( "iti_id" => $iti_id, "" );
		
		if( $check_iti ){
			$up_data = array( "confirm_voucher" => 1, "agent_comment" => $agent_comment,  "agent_id" => $user_id  );
			$update_data	= $this->global_model->update_data("iti_vouchers_status", array("iti_id" => $iti_id ), $up_data );
		}
		
		if( $update_data ){
			$this->session->set_flashdata('success', "Voucher Confirmed Successfully.");
			$res = array( "status" => true, "msg" => "Voucher Confirmed Successfully." );
		}else{
			$res = array( "status" => false, "msg" => "Voucher not confirmed. Please try again." );
		}
		die( json_encode( $res ) );
	}
	
	
	//Ajax request to get hotels list
	public function get_hotels_suggestion(){
		$user = $this->session->userdata('logged_in');
		$user_id = $user['user_id'];
		//if sales team show result by agent_id
        $keyword=$this->input->post('keyword');
        $data=$this->itinerary_model->getHotelListing($keyword);        
        echo json_encode($data);
    }
	
}	
?>