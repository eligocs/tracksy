<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Sendotp {
    private  $auth_key = "https://sendotp.msg91.com/api";
	public function generate_api_msg91( $request ){
		$otp_expiry		= 5; //in minutes
		$countryCode 	= $request['countryCode'];
		$mob_number 	= $countryCode . $request['mobileNumber'];
		$auth_key 		= get_sentotp_api_data("auth_key");
		$sender_id 		= get_sentotp_api_data("sender_id");
		
		
		//dump($auth_key);
		//dump($sender_id);
		//dump($mob_number);
		//die;
		
		$data_string = "http://control.msg91.com/api/sendotp.php?authkey={$auth_key}&sender={$sender_id}&mobile={$mob_number}&otp_expiry={$otp_expiry}";
		
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => $data_string,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => "",
			CURLOPT_SSL_VERIFYHOST => 0,
			CURLOPT_SSL_VERIFYPEER => 0,
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);
		return $response;
		
		// if ($err) {
			//echo "cURL Error #:" . $err;
		//} else {
			//echo $response;
		//} 
	}
	
    public function generateOTP($request){
        //call generateOTP API
        $response  = $this->generate_api_msg91($request);
        $response = json_decode($response,true);
		
        if($response["type"] == "error"){
            //customize this as per your framework
            return $response['message'];
            //return json_encode($resp);
        }else{
            $resp['message'] = "OTP SENT SUCCESSFULLY";
            //return json_encode($resp);
			return $resp['message'];
        }
    }
	
	//verfiy otp
	public function verifyBySendOtp( $request ){
		$countryCode 	= $request['countryCode'];
		$otp 			= $request['oneTimePassword'];
		$mob_number 	= $countryCode . $request['mobileNumber'];
		$auth_key 		= get_sentotp_api_data("auth_key");
		
		$data_string = "https://control.msg91.com/api/verifyRequestOTP.php?authkey={$auth_key}&mobile={$mob_number}&otp={$otp}";
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => $data_string,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => "",
			CURLOPT_SSL_VERIFYHOST => 0,
			CURLOPT_SSL_VERIFYPEER => 0,
			CURLOPT_HTTPHEADER => array(
				"content-type: application/x-www-form-urlencoded"
			),
		));
		
		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);
		
		$response = json_decode($response,true);
		if( $response["type"] == "error" ){
            //customize this as per your framework
            return $response['message'];
            //return json_encode($resp);
        }else{
            $resp['message'] = "NUMBER VERIFIED SUCCESSFULLY";
            //return json_encode($resp);
			return $resp['message'];
        }
		exit;
	}	
	
	
	//Resend otp
	public function resendOtp($request){
		$countryCode 	= $request['countryCode'];
		$mob_number 	= $countryCode . $request['mobileNumber'];
		$auth_key 		= get_sentotp_api_data("auth_key");
		$type 			= "voice";  //text or voice
		
		$data_string = "http://control.msg91.com/api/retryotp.php?authkey={$auth_key}&mobile={$mob_number}&retrytype={$type}";
		$curl = curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_URL => $data_string,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => "",
		  CURLOPT_SSL_VERIFYHOST => 0,
		  CURLOPT_SSL_VERIFYPEER => 0,
		  CURLOPT_HTTPHEADER => array(
			"content-type: application/x-www-form-urlencoded"
		  ),
		));

		$response = curl_exec($curl);
		$err	 = curl_error($curl);
		curl_close($curl);

		
		$response = json_decode($response,true);
		if( $response["type"] == "error" ){
            //customize this as per your framework
            return $response['message'];
            //return json_encode($resp);
        }else{
            $resp['message'] = "otp_sent_successfully";
            //return json_encode($resp);
			return $resp['message'];
        }
		exit;
	}
}

?>