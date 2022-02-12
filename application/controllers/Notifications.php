<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Notifications extends CI_Controller {
	public function __Construct(){
	   	parent::__Construct();
		validate_login();
	}
	
	//Get all desktop notifications
	public function get_notifications(){
		$user		= $this->session->userdata('logged_in');
		$user_id 	= $user['user_id'];
		$user_role 	= $user['role'];
		$BASE_URL 	= base_url();
		if( $user ){
			$get_notifications = $this->global_model->get_notifications();
			//dump( $get_notifications ); die;
			if( $get_notifications ){
				$resultStr="[";
				foreach( $get_notifications as $notification ){
					$url = $BASE_URL . $notification['url'];
					$body 	= $notification['body'];
					$agent 	= $notification['agent_id'];
					$agent_name = get_user_name( $agent );
					
					//if user role = 98 manager show agent name on msg 1=lead followup,2=iti folloup
					$notification_type = $notification['notification_type'];
					if( $user_role == 98 ){
						if( $notification_type == 1 || $notification_type == 2  ){
							$body .= " \\n Agent: {$agent_name}";
						}
					}
					$body .= " \\n Lead ID: {$notification['customer_id']}";
					$resultStr .= "{\"id\":".$notification["id"].",\"title\":\"". $notification['title']. "\",\"body\":\"". $body . "\",\"url\":\"". $url . "\"},";
				}
				$resultStr = substr( $resultStr,0,strlen( $resultStr) -1)."]";
				echo $resultStr;
			}else{
				echo "no_data";
			}	
		}else{	
			echo "no_data";
		}
		exit;
	}
	
	//Update notification read status
	public function update_notification_read_status(){
		$notification_id = isset( $_POST['id'] ) ? $_POST['id'] : 0;
		$where = array( "id" => $notification_id );
		$data = array( "read_status" => 1 );
		$up = $this->global_model->update_data("notifications", $where, $data );
		
		//get data if customer_id = 999 delete 999 =customer from indiatourizm
		$where_lead_from_indiaTourizm = array("customer_id" => 999, "read_status" => 1 );
		$this->global_model->delete_data("notifications", $where_lead_from_indiaTourizm );
		exit();
	}
	
}	

?>