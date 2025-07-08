<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *
 * Model Email_model
 *
 * This Model for ...
 * 
 * @package		CodeIgniter
 * @category	Model
 * @author    Setiawan Jodi <jodisetiawan@fisip-untirta.ac.id>
 * @link      https://github.com/setdjod/myci-extension/
 * @param     ...
 * @return    ...
 *
 */

class Email_model extends CI_Model
{

	// ------------------------------------------------------------------------

	public function __construct()
	{
		parent::__construct();
	}

	// ------------------------------------------------------------------------


	// ------------------------------------------------------------------------
	public function index()
	{
		// 
	}

	public function send_mail($params = false)
	{
		$data = [
			'header' => $params['header'],
			'message' => $params['message'],
			'ref_code' => $params['ref_code'] ?? null,
			'breakdown' => $params['breakdown'] ?? null
		];
		$html = $this->load->view('email_template', $data, TRUE);

		$this->load->library('Email_lib');
		// $email_data = [
		//   'email_recepient' => $params['email_recepients'],
		//   'email_body' =>  $params['email_body'],
		//   'email_subject' =>  $params['email_subject']
		// ];
		$email_data = [
			'alias' => '[no-reply] Live Aboard Trips',
			'email_recepients' => $params['recepient'],
			'email_body' =>  $html,
			'email_subject' => $params['subject']
		];
		$result = $this->email_lib->email_sent($email_data);
	}

	public function fetch_admin_email()
	{
		$this->db->select('email')
			->from('user_admin')
			->where('partner_id', '0');

		$result = $this->db->get()->result_array();
		return $result;
	}

	// ------------------------------------------------------------------------

}

/* End of file Email_model.php */
/* Location: ./application/models/Email_model.php */
