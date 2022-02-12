<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Promotion extends CI_Controller {
	
	public function __Construct(){
		parent::__Construct();
		$this->load->model("newsletter_model");
		$this->load->model("voucher_model");
	}
	
	public function article(){
		$newsletter_slug = $this->uri->segment(3);
		$news_slug = trim( $newsletter_slug );
		if( !empty( $newsletter_slug )   ){
			/* check newsletter slug if exists */
			$where = array( "slug" => $news_slug, "del_status" => 0 );
			$data['newsletter'] = $this->global_model->getdata( "newsletters", $where );
			$this->load->view("newsletter/promotion", $data);
		}else{
			redirect('promotion/pagenotfound');
			die( "Invalid Url" );
		}
	}
	
	//package for client view
	public function package(){
		$iti_id = trim($this->uri->segment(3));
		$temp_key = trim($this->uri->segment(4));
		if( !empty( $iti_id ) && !empty( $temp_key ) ){
			$where = array( "del_status" => 0, "iti_id" => $iti_id, "temp_key" => $temp_key );
			$iti = $this->global_model->getdata( "itinerary", $where );
			if( isset($iti[0]->iti_close_status) && $iti[0]->iti_close_status != 1 ){
				$data['itinerary'] = $iti;
				$data['flight_details'] = $this->global_model->getdata( "flight_details", array("iti_id" => $iti_id) );
				$data['train_details'] = $this->global_model->getdata( "train_details", array("iti_id" => $iti_id) );
				$data['discountPriceData'] 	= $this->global_model->getdata( 'itinerary_discount_price_data', array("iti_id" => $iti_id, "price_status" => 0) );
				$data['countPrice'] = $this->global_model->count_all( 'itinerary_discount_price_data', array("iti_id" => $iti_id) );
				$data['sec_key'] = md5($this->config->item("encryption_key"));
				$this->load->view('itineraries/view_iti_client', $data);
				//$this->load->view('itineraries/view_iti_public', $data);
			
				//save visitor data
				$this->global_model->update_leads_counter( $iti_id );
			}else{
				redirect('promotion/pagenotfound');
				die( "Invalid link or the URL has expired." );
			}
		}else{
			redirect('promotion/pagenotfound');
			die( "Invalid Url" );
		}
	}
	
	//package for client view
	public function itinerary(){
		$iti_id = trim($this->uri->segment(3));
		$temp_key = trim($this->uri->segment(4));
		if( !empty( $iti_id ) && !empty( $temp_key ) ){
			$where = array("del_status" => 0, "iti_id" => $iti_id, "temp_key" => $temp_key);
			$iti = $this->global_model->getdata( "itinerary", $where );
			//if( !empty($iti) ){
			if( isset($iti[0]->iti_close_status) && $iti[0]->iti_close_status != 1 ){
				$data['itinerary'] = $iti;
				$data['flight_details'] = $this->global_model->getdata( "flight_details", array("iti_id" => $iti_id) );
				$data['train_details'] = $this->global_model->getdata( "train_details", array("iti_id" => $iti_id) );
				$data['discountPriceData'] 	= $this->global_model->getdata( 'itinerary_discount_price_data', array("iti_id" => $iti_id, "price_status" => 0) );
				//get reviews
				$limit = 10;
				$data['reviews_data'] = $this->global_model->getdata( 'client_reviews', array("in_slider" => 1, "del_status" => 0), "", "id", $limit );
				//get sliders
				$data['slider_data'] = $this->global_model->getdata( 'sliders', array("in_slider" => 1, "del_status" => 0), "", "id", $limit );
				
				//get youtube videos
				$data['youtube_data'] = $this->global_model->getdata( 'youtube_videos', array("in_slider" => 1, "del_status" => 0), "", "id", $limit );
				
				//get comments 
				$data['comments'] = $this->global_model->getdata( 'comments', array("iti_id" => $iti_id));
				
				$data['countPrice'] = $this->global_model->count_all( 'itinerary_discount_price_data', array("iti_id" => $iti_id) );
				$data['sec_key'] = md5($this->config->item("encryption_key"));
				
				
				//get view folder
				$view_file = !empty( $iti ) && $iti[0]->iti_type == 2  ? "accommodation/accommodation_client_view" : 'itineraries/view_iti_client_new';
				
				
				$this->load->view($view_file, $data);
				//$this->load->view('itineraries/view_iti_public', $data);
			
				//save visitor data
				$this->global_model->update_leads_counter( $iti_id );
			}else{
				redirect('promotion/pagenotfound');
				die( "Invalid link or the URL has expired." );
			}
		}else{
			redirect('promotion/pagenotfound');
			die( "Invalid Url" );
		}
	}
	
	//closed itinerary view
	public function closeitineraryurl(){
		$iti_id = trim($this->uri->segment(3));
		$temp_key = trim($this->uri->segment(4));
		if( !empty( $iti_id ) && is_numeric( $iti_id ) && !empty( $temp_key ) ){
			$where = array( "del_status" => 0, "iti_id" => $iti_id,"temp_key" => $temp_key, "iti_close_status" => 1 );
			$iti = $this->global_model->getdata( "itinerary", $where );
			if( !empty($iti) ){
				$data['itinerary'] = $iti;
				$data['flight_details'] = $this->global_model->getdata( "flight_details", array("iti_id" => $iti_id) );
				$data['train_details'] = $this->global_model->getdata( "train_details", array("iti_id" => $iti_id) );
				$data['discountPriceData'] 	= $this->global_model->getdata( 'itinerary_discount_price_data', array("iti_id" => $iti_id, "price_status" => 0) );
				//get reviews
				$limit = 10;
				$data['reviews_data'] = $this->global_model->getdata( 'client_reviews', array("in_slider" => 1, "del_status" => 0), "", "id", $limit );
				//get sliders
				$data['slider_data'] = $this->global_model->getdata( 'sliders', array("in_slider" => 1, "del_status" => 0), "", "id", $limit );
				
				//get youtube videos
				$data['youtube_data'] = $this->global_model->getdata( 'youtube_videos', array("in_slider" => 1, "del_status" => 0), "", "id", $limit );
				
				//get comments 
				$data['comments'] = $this->global_model->getdata( 'comments', array("iti_id" => $iti_id));
				
				$data['countPrice'] = $this->global_model->count_all( 'itinerary_discount_price_data', array("iti_id" => $iti_id) );
				$data['sec_key'] = md5($this->config->item("encryption_key"));
				
				
				//get view folder
				$view_file = !empty( $iti ) && $iti[0]->iti_type == 2  ? "accommodation/accommodation_client_view_close" : 'itineraries/view_iti_client_new_close';
				
				$this->load->view($view_file, $data);
				
				//save visitor data
				$this->global_model->update_leads_counter( $iti_id );
			}else{
				redirect('promotion/pagenotfound');
				die( "Invalid link or the URL has expired." );
			}
		}else{
			redirect('promotion/pagenotfound');
			die( "Invalid Url" );
		}
	}
	
	//Amendment package client view
	public function amendment_view(){
		$id = trim($this->uri->segment(3));
		$iti_id = trim($this->uri->segment(4));
		$temp_key = trim($this->uri->segment(5));
		
		if( !empty( $id ) && !empty( $temp_key ) ){
			$where = array("del_status" => 0, "id" => $id, "temp_key" => $temp_key, "sent_for_review !=" => 3  );
			$iti = $this->global_model->getdata( "iti_amendment_temp", $where );
			if( !empty($iti) ){
				$data['itinerary'] = $iti;
				$data['flight_details'] = $this->global_model->getdata( "flight_details", array("iti_id" => $iti_id) );
				$data['train_details'] = $this->global_model->getdata( "train_details", array("iti_id" => $iti_id) );
				$data['discountPriceData'] 	= $this->global_model->getdata( 'itinerary_discount_price_data', array("iti_id" => $iti_id, "price_status" => 0) );
				//get reviews
				$limit = 10;
				$data['reviews_data'] = $this->global_model->getdata( 'client_reviews', array("in_slider" => 1, "del_status" => 0), "", "id", $limit );
				//get sliders
				$data['slider_data'] = $this->global_model->getdata( 'sliders', array("in_slider" => 1, "del_status" => 0), "", "id", $limit );
				
				//get youtube videos
				$data['youtube_data'] = $this->global_model->getdata( 'youtube_videos', array("in_slider" => 1, "del_status" => 0), "", "id", $limit );
				
				//get comments 
				$data['comments'] = $this->global_model->getdata( 'comments', array("iti_id" => $iti_id));
				
				$data['countPrice'] = $this->global_model->count_all( 'itinerary_discount_price_data', array("iti_id" => $iti_id) );
				$data['sec_key'] = md5($this->config->item("encryption_key"));
				
				//get view folder
				$view_file = !empty( $iti ) && $iti[0]->iti_type == 2  ? "accommodation/view_acc_client_amendment" : "itineraries/view_iti_client_amendment";
			
				$this->load->view($view_file, $data);
				//$this->load->view('itineraries/view_iti_public', $data);
			}else{
				redirect('promotion/pagenotfound');
				die( "Invalid link or the URL has expired." );
			}
		}else{
			redirect('promotion/pagenotfound');
			die( "Invalid Url" );
		}
	}
	
	//Add New Comment
	public function ajax_add_comment(){
		$iti_id 		= strip_tags($this->input->post('iti_id'));
		$agent_id 		= strip_tags($this->input->post('agent_id'));
		$temp_key 		= strip_tags($this->input->post('temp_key'));
		$client_comment = strip_tags($this->input->post('client_comment'));
		$customer_id	= strip_tags($this->input->post('customer_id'));
		$sec_key 		= $this->input->post('sec_key');
		$enc_key 		= md5( $this->config->item("encryption_key") );
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
			$data = array( "iti_id" => $iti_id, "client_name" => $client_name,"comment_by" => "client","temp_key" => $temp_key, "client_contact" => $client_contact, "comment_content" => $client_comment );
			
			$insert = $this->global_model->insert_data("comments", $data );
			if( $insert ){
				//update itinerary last comment status as unread
				$update_iti_seen_status = $this->global_model->update_data("itinerary", array("iti_id" => $iti_id ), array("client_comment_status" => 1 ) );
				
				//send email to agent
				$link = "<a title='View' target='_blank' href=" . site_url("itineraries/view/{$iti_id}/{$temp_key}") . " class='btn btn-success' >Click to check itinerary</a>";
				$to = get_user_email( $agent_id );
				$subject = "New comment on your itinerary <Trackitinerary.org>";
				$msg = "New comment on Itinerary ID:{$iti_id} by <strong> {$client_name} </strong>.<br>";
				$msg .= "{$link}";
				$sent_mail = sendEmail($to, $subject, $msg);
				
				$res = array('status' => true, 'msg' => "Your comment Submitted successfully!");
				die(json_encode($res));
			}else{
				$res = array('status' => false, 'msg' => "Your comment not submit! Please try again.");
				die(json_encode($res));
			}
		}
	}
	
	//Show All Testimonials
	public function testimonials(){
		$this->load->library('pagination');
		$config = array();
		$config["base_url"] = base_url() . "promotion/testimonials";
		
		//if filter exists
		if( isset( $_GET['filter_review'] )  && !empty( $_GET['filter_review'] ) ){
			$rating = $_GET['filter_review'];
			$wh = array( "del_status" => 0, "rating" => trim( $rating ) );
		}else{
			$wh = array( "del_status" => 0 );
		}
		
		
		$total_row = $this->global_model->count_all( "client_reviews", $wh );
		$t_rows = $this->global_model->count_all( "client_reviews");
		//Show less than 100 only
		$totalRows = $total_row <= 100 ? $total_row : 100;  
		
		//$config["total_rows"] = $total_row;
		$config["total_rows"] = $totalRows;
		$config["per_page"] = 10;
		$config["uri_segment"] = 3;
		$config['use_page_numbers'] = TRUE;
		//$config['num_links']  = $total_row;
		$config['num_links']  = $totalRows;
		$config['full_tag_open'] = '<ul class="pagination pagination-sm">';
		$config['full_tag_close'] = '</ul><!--pagination-->';
		$config['cur_tag_open'] = "<li class='active'><a href='#'>";
		$config['cur_tag_close'] = "</a></li>";
		
		$config['num_tag_open'] ="<li>";
		$config['num_tag_close'] ="</li>";
		$config['prev_tag_open'] = "<li>";
		$config['prev_tag_close'] = "</li>";
		
		$config['first_link'] = '<a href="#"><i class="fa fa-angle-left"></i></a>';
		$config['first_tag_open'] = '<a class="prev-button">';
		$config['first_tag_close'] = '</a>';
		
		$config['last_link'] = '<a href="#"><i class="fa fa-angle-right"></i></a></i>';
		$config['last_tag_open'] = '<a class="next-button">';
		$config['last_tag_close'] = '</a>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
 
		$this->pagination->initialize($config);
		//$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$page = ($this->uri->segment(3)) ? ($this->uri->segment(3) - 1) : 0;
		$data['testimonials']= $this->global_model->getAllTestimonials( $wh , $config["per_page"], $page * $config["per_page"] );
		$data["links"] = $this->pagination->create_links();
		$data['total'] = $total_row;
		$data['t_rows'] = $t_rows;
		$data['page'] = $page;
		
		// Get showing result
		if($config["total_rows"] > 10){
			if($this->pagination->cur_page == 1 )
				$start = $this->pagination->cur_page;
			else
				$start = (($this->pagination->cur_page-1) * $this->pagination->per_page)+1;

			if($this->pagination->cur_page * $this->pagination->per_page > $config["total_rows"])
				$end = $config["total_rows"];
			else
				$end = $this->pagination->cur_page * $this->pagination->per_page;

			$data['pagination_des'] = "Displaying Testimonial <b>".($start)."&nbsp;-&nbsp;".($end)."</b> of <b>". $config["total_rows"]."</b> in total";
		}else{
			$data['pagination_des'] = "Displaying Testimonial <b>".($this->pagination->cur_page+1)."&nbsp;-&nbsp;".($config["total_rows"])."</b> of <b>". $config["total_rows"]."</b> in total";
		}
		//Get reviews count
		$data["excellent"] = $this->global_model->count_all("client_reviews", array( "del_status" => 0 , "rating" => 5 ) );
		$data["v_good"] = $this->global_model->count_all("client_reviews", array( "del_status" => 0 , "rating" => 4 ) );
		$data["good"] = $this->global_model->count_all("client_reviews", array( "del_status" => 0 , "rating" => 3 ) );
		$data["poor"] = $this->global_model->count_all("client_reviews", array( "del_status" => 0 , "rating" => 2 ) );
		$data["bad"] = $this->global_model->count_all("client_reviews", array( "del_status" => 0 , "rating" => 1 ) );
		
		//count positive reviews
		$exce_rev 	= !empty( $data["excellent"] ) ? $data["excellent"] : 0;
		$v_good 	= !empty( $data["v_good"] ) ? $data["v_good"] : 0;
		$good_rev 	= !empty( $data["good"] ) ? $data["good"] : 0;
		
		$count_total = $exce_rev + $v_good + $good_rev;
		
		if( !empty( $t_rows ) ){
			$pos_rev = $count_total * 100 / $t_rows; 
			$data["positive_rev_percentage"] = round( $pos_rev , 2 );
		}else{
			$data["positive_rev_percentage"] = "";
		}	
	
		//load view
		$this->load->view("public/testimonials", $data);
	}
	
	//Contact Us
	public function contact_us(){
		/* check newsletter slug if exists */
		$this->load->view("public/contactus");
	}
	
	/* View PDF */
	public function pdf(){
		$this->load->library('Pdf');
		$iti_id = trim($this->uri->segment(3));
		$temp_key = trim($this->uri->segment(4));
		$data['flight_details'] = $this->global_model->getdata( "flight_details", array("iti_id" => $iti_id) );
		$data['train_details'] = $this->global_model->getdata( "train_details", array("iti_id" => $iti_id) );
			
		if( !empty( $iti_id ) && !empty($temp_key) ){
			$data['discountPriceData'] 	= $this->global_model->getdata( 'itinerary_discount_price_data', array("iti_id" => $iti_id, "price_status" => 0) );
			$where = array("del_status" => 0, "iti_id" => $iti_id, "temp_key" => $temp_key );
			$data['itinerary'] 			= $this->global_model->getdata( 'itinerary', $where );
			
			//get view folder
			$view_file = !empty( $data['itinerary'] ) && $data['itinerary'][0]->iti_type == 2  ? "accommodation/pdf" : "itineraries/pdf";
			
			$this->load->view($view_file, $data);
		}else{
			redirect('promotion/pagenotfound');
			die;
		}	
	}
		public function templateText(){
		$texttemp_slug = $this->uri->segment(3);
		$news_slug = trim( $texttemp_slug );
		if( !empty( $news_slug )   ){
			/* check newsletter slug if exists */
			$where = array( "slug" => $news_slug);
			$data['template'] = $this->global_model->getdata( "text_template", $where );
			$this->load->view("newsletter/textTemplatepromotion",$data);
		}else{
			redirect('promotion/pagenotfound');
		}
	}
	public function templateImage(){
		$texttemp_slug = $this->uri->segment(3);
		$news_slug = trim( $texttemp_slug );
		if( !empty( $news_slug )   ){
			/* check newsletter slug if exists */
			$where = array( "slug" => $news_slug);
			$data['image'] = $this->global_model->getdata( "image_template", $where );
			$this->load->view("newsletter/textTemplatepromotion",$data);
		}else{
			redirect('promotion/pagenotfound');
		}
	}
	public function offer(){
		$offer_slug = $this->uri->segment(3);
		$news_slug = trim( $offer_slug );
		if( !empty( $news_slug )   ){
			/* check newsletter slug if exists */
			$where = array( "offerslug" => $news_slug);
			$data['offer'] = $this->global_model->getdata( "offer", $where );
			$this->load->view("newsletter/offerpromotion",$data);
		}else{
			redirect('promotion/pagenotfound');
		}
	}
	
	
	/**************
	****VOUCHERS****
	**************/
	public function voucher( $voucher_id , $iti_id ){
		$voucher_id = base64_url_decode( $voucher_id );
		$iti_id = base64_url_decode( $iti_id );
		// Check for itineray if approved or not
		$where = array("iti_id" => $iti_id, 'iti_status' => 9, 'del_status' => 0 );
		$data['itinerary'] = $this->voucher_model->getdata( "itinerary", $where );
		if( !empty( $iti_id ) && !empty( $voucher_id ) && isset( $data['itinerary'][0]->customer_id ) ){
			//GET VOUCHER
			$where_voucher = array( "iti_id" => $iti_id, "voucher_id" => $voucher_id, "confirm_voucher" => 1 );
			$data['vouchers'] = $this->voucher_model->getdata("iti_vouchers_status", $where_voucher);
			$error = "";
			$data['iti_payment_details'] = $this->voucher_model->getdata( "iti_payment_details", array( "iti_id" => $iti_id ) );
			
			//get customer info
			$data['customer'] = $this->voucher_model->getdata( "customers_inquery", array( "customer_id" => $data['itinerary'][0]->customer_id ) );
			
			// Check for Hotel Booking if approved or not
			$where_hotel = array("iti_id" => $iti_id, 'booking_status' => 9, 'del_status' => 0 );
			$data['hotels'] = $this->voucher_model->getdata( "hotel_booking", $where_hotel , "check_in", "ASC" );
			
			// Check for Cab Booking if approved or not
			$where_cab = array("iti_id" => $iti_id, 'booking_status' => 9, 'del_status' => 0 );
			$data['cab_booking']  = $this->voucher_model->getdata( "cab_booking", $where_cab, "picking_date" , "ASC" );
			
			$where_vtf = array("iti_id" => $iti_id, 'del_status' => 0, 'booking_status' => 9 );
			$data['vtf_booking'] = $this->voucher_model->getdata( "travel_booking", $where_vtf, "dep_date", "ASC" );
			
			if( empty($data['itinerary']) || !isset( $data['vouchers'][0]->id ) ){
				redirect('promotion/pagenotfound');
				exit;
			}
			
			if( empty( $data['hotels'] ) ){
				redirect('promotion/pagenotfound');
				exit;
			}
			
			$data['error']			= $error;
			//$data['agent_id'] 		= $user_id;
			$this->load->view('vouchers/client_view', $data);
		}else{
			redirect('promotion/pagenotfound');
		}	
	}
	
	
	//RECEIPT LINK
	public function receipt( $receipt_id , $receipt_number ){
		$receipt_id		 	= base64_url_decode( $receipt_id );
		$receipt_number 	= base64_url_decode( $receipt_number );
		$data['receipts'] = $this->global_model->getdata("ac_receipts", array( 'id' => $receipt_id, 'voucher_number' => $receipt_number, 'del_status' => 0) );
		if( !empty( $receipt_id ) && !empty( $receipt_number ) && isset( $data['receipts'][0]->id ) ){
			$data['iti_payment'] = $this->global_model->getdata( "iti_payment_details", array( "customer_id" => $data['receipts'][0]->lead_id ) );
			//$data['agent_id'] 		= $user_id;
			$this->load->view('accounts/receipts/receipt_client_view', $data);
		}else{
			redirect('promotion/pagenotfound');
		}	
	}
	
	//FRONT END 404
	public function pagenotfound(){
		$this->load->view("public/404");
	}
	
	
}	

?>