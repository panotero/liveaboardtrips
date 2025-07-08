<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *
 * Libraries Email
 *
 * This Libraries for ...
 * 
 * @package		CodeIgniter
 * @category	Libraries
 * @author    Setiawan Jodi <jodisetiawan@fisip-untirta.ac.id>
 * @link      https://github.com/setdjod/myci-extension/
 * @param     ...
 * @return    ...
 *
 */

class Email
{

  // ------------------------------------------------------------------------

  public function __construct()
  {
    // 
  }

  // ------------------------------------------------------------------------


  // ------------------------------------------------------------------------

  public function index()
  {
    // 
  }

  public function send_mail($params)
  {

    $this->load->library('Email_lib');
    $email_info1 = [
      'email_recepient' => $params['email_recepients'],
      'email_body' =>  $params['email_body'],
      'email_subject' =>  $params['email_subject']
    ];
    $result1 = $this->email_lib->email_sent($email_info1);
  }

  // ------------------------------------------------------------------------
}

/* End of file Email.php */
/* Location: ./application/libraries/Email.php */