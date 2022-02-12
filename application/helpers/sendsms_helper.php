<?php
/* 
* Send Sms
*/

function pm_send_sms($mobiles, $msg ){
	///Your authentication key
	//$authKey = "145769Aqv7GZHZxP592e5681";
	$auth = get_msg_api_data("auth_key");
	$authKey = trim($auth);
	//Multiple mobiles numbers separated by comma
	$mobileNumber = $mobiles;
	//Sender ID,While using route4 sender id should be 6 characters long.
	//$senderId = "TPSHUB";
	$sender_Id = get_msg_api_data("sender_id");
	$senderId = trim($sender_Id);
	//Your message to send, Add URL encoding here.
	$message = urlencode( $msg );
	//Define route json
	$route = 4;
	//Prepare you post parameters
	$postData = array(
		'authkey' => $authKey,
		'mobiles' => $mobileNumber,
		'message' => $message,
		'sender' => $senderId,
		'route' => $route
	);
	//API URL
	$url="https://api.msg91.com/api/sendhttp.php";
	// init the resource
	$ch = curl_init();
	curl_setopt_array($ch, array(
		CURLOPT_URL => $url,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_POST => true,
		CURLOPT_POSTFIELDS => $postData
		//,CURLOPT_FOLLOWLOCATION => true
	));
	//Ignore SSL certificate verification
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	//get response
	$output = curl_exec($ch);
	
	//Print error if any
	if(curl_errno($ch)){
		//$res = 'Error:' . curl_error($ch);
		$res = false;
	}else{
		$res = true;
	}
	curl_close($ch);
	return $res;
}

/*
 * Get Auth Key
*/
function get_msg_api_data( $key ) {
	$ci = & get_instance();
	$where = array();
	$res = $ci->global_model->getdata("sms_settings", $where, $key);
	if($res){	
		$result = $res;
	}else{
		$result = "";
	}
	return $result;
}