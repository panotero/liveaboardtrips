<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Phpmailer_lib {
    public function __construct() {
        require_once(APPPATH.'libraries/src/Exception.php');
        require_once(APPPATH.'libraries/src/PHPMailer.php');
        require_once(APPPATH.'libraries/src/SMTP.php');
    }

    public function load() {
        $mail = new PHPMailer(true);
        return $mail;
    }
}