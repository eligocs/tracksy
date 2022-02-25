<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Ledger_model extends CI_Model{	
	function __construct(){
        parent::__construct();
		validate_login();
	}
}
?>