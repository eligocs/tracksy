<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Socialpost{
    function __construct(){
		require_once dirname(__FILE__) . '/facebook/autoload.php';
		require_once dirname(__FILE__) . '/twitter/codebird.php';
        //parent::__construct();
    }
}