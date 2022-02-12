<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Checkout extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');
		$this->output->set_header("Expires: 0");
		//load library
		$this->load->library('Paytm');
		$this->load->library('encryption');
		
		//check if online payments enabled
		is_online_payments();
	}
	
	public function index(){
		if( isset( $_GET['i'] ) && isset($_GET['k']) && !empty( $_GET['i'] ) && !empty( $_GET['k'] ) ){
			$iti_get	 	=  $_GET['i'];
			$itikey_get 	=  $_GET['k'];
			//$enc_key_get	=  $_GET['enc_key'];
			$iti_id   		= base64_url_decode( $iti_get );
			$temp_key 		= base64_url_decode( $itikey_get );
			//$sec_key 		= base64_url_decode( $enc_key_get );
			
			//$enc_key 		= md5( $this->config->item("encryption_key") );
			//if( $sec_key !==  $enc_key  ){
			//	redirect('promotion/pagenotfound');
			//	exit;
			//}
			
			//check if itnerary exists
			$get_iti = $this->global_model->getdata("itinerary", array( "iti_id" => $iti_id, "temp_key" => $temp_key, "iti_status" => 0 ) );
			if( $get_iti ){
				$iti = $get_iti[0];
				
				//customer info
				$customer_id = $iti->customer_id;
				//$order_id 	= "ORDS" . rand(1000,9999) . time();
				$iti_id 	= $iti->iti_id;
				$temp_key 	= $iti->temp_key;
				
				
				//data
				$data['sec_key'] 		= md5( $this->config->item("encryption_key") );
				$data['link_token'] 		= "";
				$data['customer_id'] 	= $customer_id;
				$data['iti_id'] 		= $iti_id;
				
				//get customer account
				$customer_account 		= get_customer_account( $customer_id );
				if( $customer_account && !empty( $customer_account[0]->customer_name ) ){
					$customer_name 		= $customer_account[0]->customer_name;
					$customer_email 	= $customer_account[0]->customer_email;
					$customer_contact 	= $customer_account[0]->customer_contact;
					$customer_address 	= $customer_account[0]->address;
					$country		 	= get_country_name($customer_account[0]->country_id);
					$state 				= get_state_name($customer_account[0]->state_id);
					$state_id 			= $customer_account[0]->state_id;
				}else{
					$customer = get_customer( $customer_id );
					$customer_name 		= $customer[0]->customer_name;
					$customer_email 	= $customer[0]->customer_email;
					$customer_contact 	= $customer[0]->customer_contact;
					$customer_address 	= $customer[0]->customer_address;
					$country		 	= get_country_name($customer[0]->country_id);
					$state 				= get_state_name($customer[0]->state_id);
					$state_id			= $customer[0]->state_id;
				}
				
				//customer data
				$data['customer_name'] 		= $customer_name;
				$data['customer_email'] 	= $customer_email;
				$data['customer_contact'] 	= $customer_contact;
				
				//iti link
				$data['iti_link'] = site_url("promotion/itinerary/{$iti_id}/{$temp_key}");
				
				//set tem session to store customer id and iti id
				$_SESSION['iti_id'] 		= $iti_id;
				$_SESSION['payment_temp_token'] = md5('TEMP' . rand(555,99999) . time());
				
				$this->load->view("accounts/payments/index", $data);
			}else{
				redirect('promotion/pagenotfound');
				exit;
			}	
		}else{
			redirect('promotion/pagenotfound');
			exit;
		}
    }
	
	//pay by link
	public function payinstallment(){
		if( isset( $_GET['i'] ) && !empty( $_GET['i'] ) ){
			$order_id	 	=  $_GET['i'];
			//$enc_key_get	=  $_GET['enc_key'];
			$link_token   	= base64_url_decode( $order_id );
			//$sec_key 		= base64_url_decode( $enc_key_get );
			//$enc_key 		= md5( $this->config->item("encryption_key") );
			
			//if( $sec_key !==  $enc_key  ){
				//redirect('promotion/pagenotfound');
				//exit;
			//}
			
			//check if order exists
			$get_payemt_link = $this->global_model->getdata("ac_payment_links", array( "link_token" => $link_token, "status" => 0 , 'paid_status' => 0 ) );
			
			if( $get_payemt_link ){
				$ord = $get_payemt_link[0];
				//customer info
				$customer_id 	= $ord->customer_id;
				$link_token 	= $ord->link_token;
				$iti_id 		= $ord->iti_id;
				$amount 		= $ord->trans_amount;
				
				//data
				$data['sec_key'] 			= md5( $this->config->item("encryption_key") );
				$data['link_token'] 		= $link_token;
				$data['customer_id'] 		= $customer_id;
				$data['amount'] 			= $amount;
				$data['iti_id'] 			= $iti_id;
				$data['link_expire_date'] 	= $ord->link_expire_date;
				
				//get customer account
				$customer_account 		= get_customer_account( $customer_id );
				if( $customer_account && !empty( $customer_account[0]->customer_name ) ){
					$customer_name 		= $customer_account[0]->customer_name;
					$customer_email 	= $customer_account[0]->customer_email;
					$customer_contact 	= $customer_account[0]->customer_contact;
					$customer_address 	= $customer_account[0]->address;
					$country		 	= get_country_name($customer_account[0]->country_id);
					$state 				= get_state_name($customer_account[0]->state_id);
					$state_id 			= $customer_account[0]->state_id;
				}else{
					$customer = get_customer( $customer_id );
					$customer_name 		= $customer[0]->customer_name;
					$customer_email 	= $customer[0]->customer_email;
					$customer_contact 	= $customer[0]->customer_contact;
					$customer_address 	= $customer[0]->customer_address;
					$country		 	= get_country_name($customer[0]->country_id);
					$state 				= get_state_name($customer[0]->state_id);
					$state_id			= $customer[0]->state_id;
				}
				
				//customer data
				$data['customer_name'] 		= $customer_name;
				$data['customer_email'] 	= $customer_email;
				$data['customer_contact'] 	= $customer_contact;
				
				//expire link
				if( !empty($ord->link_expire_date) ){
					$link_expire_date = strtotime($ord->link_expire_date); //gives value in Unix Timestamp (seconds since 1970)
					$current_d = strtotime( date("Y-m-d H:i:s") );
					
					if ( $link_expire_date < $current_d ){
						$data['error'] = "Payment Link has been Expired.";
					}
				}
				
				//set tem session to store customer id and iti id
				$_SESSION['iti_id'] 		= $iti_id;
				$_SESSION['link_token'] 	= $link_token;
				$_SESSION['payment_temp_token'] = md5('TEMP' . rand(555,99999) . time());
				
				$this->load->view("accounts/payments/index", $data);
			}else{
				redirect('promotion/pagenotfound');
				exit;
			}	
		}else{
			redirect('promotion/pagenotfound');
			exit;
		}
    }
	
	//start payement
	public function generatePaymentRequest(){
		if( isset( $_POST["customer_id"] ) && isset( $_POST['sec_key'] ) ){
			$sec_key 	= $_POST['sec_key'];
			$enc_key 	= md5( $this->config->item("encryption_key") );
			if( $sec_key !==  $enc_key  ){
				echo "Security Error! ";
				exit;
			}
			
			//set rules
			$this->form_validation->set_rules('customer_name', 'Customer Name', 'required');
			$this->form_validation->set_rules('customer_email', 'Email', 'required|valid_email');
			$this->form_validation->set_rules('customer_contact', 'Contact Number', 'required|numeric|max_length[10]|min_length[10]');
			$this->form_validation->set_rules('TXN_AMOUNT', 'Amount', 'required|max_length[20]|numeric|greater_than_equal_to[10]');
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
			
			//check if form validation true/false
			if ($this->form_validation->run() == FALSE){
				//data
				$data['sec_key'] 			= md5( $this->config->item("encryption_key") );
				$data['link_token'] 		= $this->input->post('link_token', true);
				$data['customer_id'] 		= $this->input->post('customer_id', true);
				$data['customer_name'] 		= $this->input->post('customer_name', true);
				$data['customer_email'] 	= $this->input->post('customer_email', true);
				$data['customer_contact'] 	= $this->input->post('customer_contact', true);
				$data['amount'] 			= $this->input->post('TXN_AMOUNT', true);
				$data['iti_id'] 			= $this->input->post('iti_id', true);
				$data['description'] 		= $this->input->post('description', true);
				
				//check order
				$get_order = $this->global_model->getdata("ac_payment_links", array( "link_token" => $data['link_token'], "status" => 0 , 'paid_status' => 0 ) );
				$data['link_expire_date'] 	= isset( $get_order[0]->link_expire_date ) ? $get_order[0]->link_expire_date : "";
				
				$this->load->view("accounts/payments/index", $data);
			}else{
				$checkSum = "";
				$paramList = array();
				
				//GET POST DATA
				$customer_name 		= strip_tags($this->input->post('customer_name', true));
				$customer_contact 	= strip_tags($this->input->post('customer_contact', true));
				$customer_email 	= strip_tags($this->input->post('customer_email', true));
				$description 		= strip_tags($this->input->post('description', true));
				$iti_id 			= strip_tags($this->input->post('iti_id', true));
				
				//get form data
				//check if order id exists
				if( isset( $_POST['link_token'] ) && !empty( $_POST['link_token'] ) ){
					//$order_id = trim( $_POST['order_id'] );
					//check payement data by order data
					$check_order = $this->global_model->getdata("ac_payment_links", array( "link_token" => $_POST['link_token'], "status" => 0 , 'paid_status' => 0 ) );
					
					//if order does not exists
					if( !$check_order ){
						redirect('promotion/pagenotfound');
						exit;
					}
					//$ORDER_ID 		= $order_id;
					$CUST_ID 		= $check_order[0]->customer_id;
					$TXN_AMOUNT 	= $check_order[0]->trans_amount;
				}else{
					$CUST_ID 			= $this->input->post("customer_id", TRUE);
					$TXN_AMOUNT 		= $this->input->post("TXN_AMOUNT", TRUE);
				}
				
				//generate order id
				$ORDER_ID 			= "ORDS" . rand(1000,9999) . time();
				
				//get customer info
				//$get_customer_info	= get_customer( $CUST_ID );
				//$customer_name 		= isset($get_customer_info[0]) ? $get_customer_info[0]->customer_name : "";
				//$customer_contact 	= isset($get_customer_info[0]) ? $get_customer_info[0]->customer_contact : "";
				//$customer_email		= isset($get_customer_info[0]) ? $get_customer_info[0]->customer_email : "";

				// Create an array having all required parameters for creating checksum.
				$paramList["MID"] 		= PAYTM_MERCHANT_MID;
				$paramList["ORDER_ID"] 	= $ORDER_ID;      
				$paramList["CUST_ID"] 	= $CUST_ID;   /// according to your logic
				$paramList["INDUSTRY_TYPE_ID"] = 'RETIAL';
				$paramList["CHANNEL_ID"] = 'WEB';
				$paramList["TXN_AMOUNT"] = $TXN_AMOUNT;
				
				//$paramList["PAYMENT_MODE_ONLY"] = 'YES'; //IF ONLY PAYTM 
				$paramList["WEBSITE"] 		= PAYTM_MERCHANT_WEBSITE;
				$paramList["CALLBACK_URL"] 	= base_url("checkout/confirmation");
				$paramList["MSISDN"] 		= $customer_contact; //Mobile number of customer
				$paramList["EMAIL"] 		= $customer_email;
				$paramList["VERIFIED_BY"] 	= "EMAIL"; //
				$paramList["IS_USER_VERIFIED"] = "YES"; //
				//print_r($paramList);
				$checkSum = getChecksumFromArray($paramList, PAYTM_MERCHANT_KEY);
				
				
				//SAVE client DATA
				$user_data = array(
					'payment_temp_token'	=> $_SESSION['payment_temp_token'],
					'customer_name' 		=> $customer_name,
					'customer_contact' 		=> $customer_contact,
					'customer_email'	 	=> $customer_email,
					'description' 			=> $description,
					'iti_id' 				=> $iti_id,
					'customer_id' 			=> $CUST_ID,
					'client_ip' 			=> $_SERVER['REMOTE_ADDR'],
				);
				$this->global_model->insert_data( 'ac_online_transactions', $user_data );
				?>
				<!--submit form to payment gateway OR in api environment you can pass this form data-->
				<form id="cpmyForm" action="<?php echo PAYTM_TXN_URL ?>" method="post">
					<?php
						foreach ($paramList as $a => $b) {
							echo '<input type="hidden" name="' . htmlentities($a).'" value="' . htmlentities($b).'">';
						}
					?>
					<input type="hidden" name="CHECKSUMHASH" value="<?php echo $checkSum ?>">
				</form>
				<script type="text/javascript">
					document.getElementById('cpmyForm').submit();
				</script>
				<?php
			}	
		}else{
			redirect('promotion/pagenotfound');
			exit;
		}	
    }

    /////////// response from paytm gateway////////////
    public function confirmation(){
        $paytmChecksum = "";
        $paramList = array();
        $isValidChecksum = "FALSE";
        $paramList = $_POST;
        $insert_data = array();
		$data = array();
		
        //echo "<pre>";
        //print_r($paramList);
		//CHECK
		$paytmChecksum = isset($_POST["CHECKSUMHASH"]) ? $_POST["CHECKSUMHASH"] : ""; //Sent by Paytm pg
		$isValidChecksum = verifychecksum_e($paramList, PAYTM_MERCHANT_KEY, $paytmChecksum); //will return TRUE or FALSE string.
		if( $isValidChecksum == "TRUE" ){
			$data['response_data'] = $paramList;
			
			$iti_id 		= isset($_SESSION['iti_id']) ? $_SESSION['iti_id'] : 0;
			//$customer_id 	= isset($_SESSION['customer_id']) ? $_SESSION['customer_id'] : 0;
			
			//iti link
			$temp_key 			= get_iti_temp_key( $iti_id );
			$data['iti_link'] 	= site_url("promotion/itinerary/{$iti_id}/{$temp_key}");
			$data['iti_id'] 	= $iti_id;
			
			if ( $_POST["STATUS"] == "TXN_SUCCESS" ){
				/// put your to save into the database // tansaction successfull
				//echo "success. <br>";
				//var_dump($paramList);
				
				//insert data
				$insert_data['order_id'] 		= $_POST['ORDERID'];
				//$insert_data['customer_id'] 	= $customer_id;
				//$insert_data['iti_id'] 		= $iti_id;
				$insert_data['trans_id'] 		= $_POST['TXNID'];
				$insert_data['trans_amount'] 	= $_POST['TXNAMOUNT'];
				$insert_data['payment_mode'] 	= $_POST['PAYMENTMODE'];
				$insert_data['currency'] 		= $_POST['CURRENCY'];
				$insert_data['trans_date'] 		= $_POST['TXNDATE'];
				$insert_data['trans_status'] 	= $_POST['STATUS'];
				$insert_data['t_response_code'] = $_POST['RESPCODE'];
				$insert_data['t_response_msg'] 	= $_POST['RESPMSG'];
				$insert_data['gatwayname'] 		= $_POST['GATEWAYNAME'];
				$insert_data['bank_trans_id'] 	= $_POST['BANKTXNID'];
				$insert_data['bank_name'] 		= $_POST['BANKNAME'];
			
			
				//check if form re-submit
				$this->db->where( "trans_id", $_POST['TXNID'] );
				$query = $this->db->get('ac_online_transactions');
				if ( $query->num_rows() == 0 ) {
					//get customer details
					$cus_data = $this->global_model->getdata('ac_online_transactions', array('payment_temp_token' => $_SESSION['payment_temp_token']));
					
					$cus_name 	 = isset( $cus_data[0]->customer_name ) ? $cus_data[0]->customer_name : "";
					$cus_email 	 = isset( $cus_data[0]->customer_email ) ? $cus_data[0]->customer_email : "";
					$cus_contact = isset( $cus_data[0]->customer_contact ) ? $cus_data[0]->customer_contact : "";
					$iti_id 	 = isset( $cus_data[0]->iti_id ) ? $cus_data[0]->iti_id : "";
					$customer_id = isset( $cus_data[0]->customer_id ) ? $cus_data[0]->customer_id : "";
					
					//SEND EMAIL TO CUSTOMER
					$subject = "Payment Received Successfully. Order ID : {$_POST['ORDERID']}";
					$msg_client = "Dear {$cus_name},<br> Thanks, we have received the payment of <strong>Rs. {$_POST['TXNAMOUNT']} /- </strong>. <br>";
					$msg_client .= "<strong> Transaction ID: </strong> {$_POST['TXNID']}<br>";
					$msg_client .= "<strong> Order ID: </strong> {$_POST['ORDERID']}<br>";
					$msg_client .= "<strong> ITI ID: </strong> {$iti_id}<br>";
					$msg_client .= "We will contact you shortly. <br>";
					$msg_client .= "trackitinerary.";
					
					//message to admin
					$admin_email = admin_email();
					$to	= array( $admin_email );
					$admin_msg = "We have received the payment of <strong>Rs. {$_POST['TXNAMOUNT']} /- </strong>. <br>";
					$admin_msg .= "<strong> Transaction ID: </strong> {$_POST['TXNID']}<br>";
					$admin_msg .= "<strong> Order ID: </strong> {$_POST['ORDERID']}<br>";
					$admin_msg .= "<strong> Client Name: </strong> {$cus_name}<br>";
					$admin_msg .= "<strong> ITI ID: </strong> {$iti_id}<br>";
					$admin_msg .= "<strong> Lead ID: </strong> {$customer_id}";
					
					@sendEmail($to, $subject, $admin_msg);
					@sendEmail($cus_email, $subject, $msg_client);
					//END EMAIL SECTION
					
					//$this->db->insert('ac_online_transactions', $insert_data);
					$this->global_model->update_data('ac_online_transactions', array('payment_temp_token' => $_SESSION['payment_temp_token']), $insert_data);
					
					//update status
					if( isset( $_SESSION['link_token'] ) ){
						$this->global_model->update_data('ac_payment_links', array('link_token' => $_SESSION['link_token']), array('paid_status' => 1, 'order_id' => $_POST['ORDERID'] ) );
					}	
				}
				
			}else { /// failed
				//insert data
				$insert_data['order_id'] 		= $_POST['ORDERID'];
				//$insert_data['customer_id'] 	= $customer_id;
				//$insert_data['iti_id'] 			= $iti_id;
				$insert_data['trans_amount'] 	= $_POST['TXNAMOUNT'];
				$insert_data['trans_status'] 	= $_POST['STATUS'];
				$insert_data['t_response_code'] = $_POST['RESPCODE'];
				$insert_data['t_response_msg'] 	= $_POST['RESPMSG'];
				
				/*
				01 Txn Successful TXN_SUCCESS
				202 User does not have enough credit limit. Bank has declined the
				transaction TXN_FAILURE
				205 Transaction has been declined by the bank. TXN_FAILURE
				207 Card used by customer has expired TXN_FAILURE
				208 Transaction has been declined by the acquirer bank. TXN_FAILURE
				209 Card details entered by the user is/are invalid. TXN_FAILURE
				210 Lost Card received TXN_FAILURE
				220 Bank communication error TXN_FAILURE
				222 Transaction amount return by the gateway does not match with
				Paytm transaction amount TXN_FAILURE
				227 Txn Failed TXN_FAILURE
				229 3D Secure Verification failed TXN_FAILURE
				232 Invalid account details TXN_FAILURE
				295 No Description available TXN_FAILURE
				296 We are facing problem at bank's end. Try using another Payment
				mode TXN_FAILURE
				297 Cancel and Redirect to 3D Page TXN_FAILURE
				401 Abandoned transaction TXN_FAILURE
				402 Transaction abandoned from CCAvenue TXN_FAILURE
				810 Closed after page load TXN_FAILURE
				2271 User cancelled the transaction on banks net banking page TXN_FAILURE
				2272 User cancelled the transaction from 3D secure/OTP page TXN_FAILURE
				3102 Invalid card details TXN_FAILURE */
				
				//$this->db->insert('ac_online_transactions', $insert_data);
				$this->global_model->update_data('ac_online_transactions', array('payment_temp_token' => $_SESSION['payment_temp_token']), $insert_data);
			}
			
			
			//unset
			unset(
				$_SESSION['iti_id'],
				$_SESSION['link_token'],
				$_SESSION['payment_temp_token']
			);
		
		}else{
			$data['response_data'] = "INVALID";
			//////////////suspicious
			// put your code here
		} 
		
		//LOAD VIEW
		$this->load->view( "accounts/payments/pgResponse", $data );
    }
}
