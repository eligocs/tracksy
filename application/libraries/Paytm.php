<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Paytm{
    function __construct(){
		require_once(APPPATH."libraries/paytm/lib/config_paytm.php");
		require_once(APPPATH."libraries/paytm/lib/encdec_paytm.php");
        //parent::__construct();
    }
}