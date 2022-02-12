<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PHPMailer_Library{
    public function __construct(){
        log_message('Debug', 'PHPMailer class is loaded.');
    }

    public function load(){
        require_once dirname(__FILE__) . '/phpmailer/autoload.php';
        $objMail = new PHPMailer;
        return $objMail;
    }
}