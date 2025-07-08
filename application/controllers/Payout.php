<?php
defined('BASEPATH') or exit('No direct script access allowed');


/**
 *
 * Controller Payout
 *
 * This controller for ...
 *
 * @package   CodeIgniter
 * @category  Controller CI
 * @author    Setiawan Jodi <jodisetiawan@fisip-untirta.ac.id>
 * @author    Raul Guerrero <r.g.c@me.com>
 * @link      https://github.com/setdjod/myci-extension/
 * @param     ...
 * @return    ...
 *
 */

class Payout extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Transaction_model');
	}

	public function index()
	{
		// 
	}

	public function fetch_payouts()
	{

		$payout_list = $this->Transaction_model->get_all_payouts();

		echo json_encode($payout_list);
	}

	public function payout_info()
	{
		$post = $this->input->post();
		$this->data['post'] = $post;
		$invoice_nummber = $post['invoice_number'];
		$this->data['payout_info'] = $this->Transaction_model->get_all_payouts($invoice_nummber);
		$html = $this->load->view('agent/payout_info', $this->data);
		return $html;
	}

	public function accept_payout()
	{

		$post = $this->input->post();
		$transfer_ref_code = $post['transfer_reference'];
		$this->Transaction_model->update_payout_status('1', $post['invoice_number'], $transfer_ref_code);
		echo json_encode($post);
	}

	public function decline_payout()
	{

		$post = $this->input->post();
		$ref_code_list = $this->Transaction_model->update_ref_list_status($post['invoice_number']);
		$this->Transaction_model->update_payout_status('2', $post['invoice_number']);
		// var_dump($ref_code_list);
		//update reverse the status of transaction list

		echo json_encode($post);
	}
}


/* End of file Payout.php */
/* Location: ./application/controllers/Payout.php */
