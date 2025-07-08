<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *
 * Model Transaction_model
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

class Transaction_model extends CI_Model
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

	public function insert_transaction($insert_data)
	{
		$this->db->insert('transaction_table', $insert_data);
	}
	public function update_booking_status($status, $ref_code)
	{
		$update_data = [
			'status' => $status
		];
		$this->db->where('ref_code', $ref_code);
		$this->db->update('booking_table', $update_data);
	}

	public function get_all_payments($ref_code = false)
	{
		$this->db->select('*');
		$this->db->from('transaction_table tt');
		$this->db->join('settings_payment_status sps', 'sps.id = tt.status');
		if ($ref_code) {
			$this->db->where('ref_code', $ref_code);
			$this->db->limit(1);
		}
		$this->db->order_by('tt.status', 'ASC');
		$result = $this->db->get()->result_array();
		if (count($result) <= 0) {
			return false;
		}
		return $result;
	}
	public function get_all_payouts($invoice_number = false)
	{
		$this->db->select('*');
		$this->db->from('payout_table');
		if ($invoice_number) {
			$this->db->where('invoice_number', $invoice_number);
			$this->db->limit(1);
		}
		$this->db->order_by('status', 'ASC');
		$result = $this->db->get()->result_array();
		if (count($result) <= 0) {
			return false;
		}
		return $result;
	}

	public function get_all_transaction($partner_id)
	{
		$this->db->select('tt.*, bt.partner_id , bui.first_name , bui.last_name , sps.status ');
		$this->db->from('transaction_table tt');
		$this->db->join('booking_table bt', 'bt.ref_code = tt.ref_code');
		$this->db->join('booking_userinfo bui', 'bui.ref_code = tt.ref_code');
		$this->db->join('settings_payment_status sps', 'sps.id = tt.status');
		$this->db->where('bt.partner_id', $partner_id);
		$result = $this->db->get()->result_array();
		if (count($result) <= 0) {
			return false;
		}
		return $result;
	}


	public function update_payment_status($status, $ref_code)
	{

		$update_data = [
			'status' => $status
		];
		$this->db->where('ref_code', $ref_code);
		$this->db->update('transaction_table', $update_data);
	}
	public function update_transaction_payout_status($status, $ref_code)
	{

		$update_data = [
			'payout_status' => $status,
			'initialpayment_status' => $status
		];
		$this->db->where('ref_code', $ref_code);
		$this->db->update('transaction_table', $update_data);
	}

	public function update_payout_status($status, $invoice_number, $transaction_ref_code = false)
	{
		if (!$transaction_ref_code) {
			$update_data = [
				'status' => $status
			];
		} else {

			$update_data = [
				'status' => $status,
				'transfer_ref_code' => $transaction_ref_code
			];
		}
		$this->db->where('invoice_number', $invoice_number);
		$this->db->update('payout_table', $update_data);
	}

	public function update_ref_list_status($invoice_number)
	{
		$this->db->select('ref_code_list');
		$this->db->from('payout_table');
		$this->db->where('invoice_number', $invoice_number);
		$refcodelist = $this->db->get()->result_array();
		$result = json_decode($refcodelist[0]['ref_code_list']);
		// var_dump($result);
		foreach ($result as $ref_code) {
			// echo $ref_code;
			//update the status
			$this->update_transaction_payout_status('0', $ref_code);
		}

		return $result;
	}

	public function get_booking_email($ref_code = false)
	{
		$this->db->select('email, first_name, last_name')
			->from('booking_userinfo')
			->where('ref_code', $ref_code);
		$result = $this->db->get()->result_array();
		return $result;
	}

	// ------------------------------------------------------------------------

}

/* End of file Transaction_model.php */
/* Location: ./application/models/Transaction_model.php */
