<?php
defined('BASEPATH') or exit('No direct script access allowed');


/**
 *
 * Controller Admin
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

class Admin extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('User_model');
		$this->load->model('Vessel_model');
		$this->load->model('Destination_model');
		$this->load->model('Manage_model');
		$this->load->model('Cabin_model');
		$this->load->model('Wallet_model');
		$this->load->model('Booking_model');
		$this->load->model('Transaction_model');
	}

	public function index()
	{
		// 

		$this->adminlogin();
	}

	public function adminlogin()
	{
		//fetch all userinfo
		$this->load->view('/admin/login_page');
	}
	public function dashboard()
	{ //get partner id
		$partner_id = $this->session->userdata('partner_id');

		$total = $this->Wallet_model->get_total($partner_id);
		$this->data['transactions'] = $total['result'];
		$this->data['partial_payment_percentage'] = $total['partial_payment_percentage'];
		// var_dump($result);
		if ($this->data['partial_payment_percentage']) {

			$percentage = $this->data['partial_payment_percentage'][0]['partial_payment_percentage'] / 100;
		}
		$today = new DateTime();
		$total = 0;
		$commission = 0;
		if ($this->data['transactions']) {

			foreach ($this->data['transactions'] as $transaction) {
				$schedule_from = new DateTime($transaction['schedule_from']);
				$maturity = $today->diff($schedule_from)->days;


				if ($maturity <= 90) {
					if ($transaction['initialpayment_status'] == 1) {

						//compute the total partial payment
						$partial_payment_total = ($transaction['amount'] * $percentage);
						$commission = $transaction['commission'] - ($transaction['commission'] * $percentage);

						$transaction_total = $transaction['amount'] - $partial_payment_total;
						$subtotal = $transaction_total - $commission;
					} else {
						//compute the total partial payment
						$commission = $transaction['commission'];

						$transaction_total = $transaction['amount'];
						$subtotal = $transaction_total - $commission;
					}
				} else {
					if ($transaction['initialpayment_status'] == 1) {
						continue;
					}


					//compute the total payment payment
					$commission = $transaction['commission'] * $percentage;

					$transaction_total = $transaction['amount'] * $percentage;
					$subtotal = $transaction_total - $commission;
				}
				$total += $subtotal;
			}
			$balance =  $total;

			$this->data['wallet_balance'] = $balance;
		}
		// var_dump($this->data['admimn_info']);
		$this->load->view('/admin/dashboard_page', $this->data);
	}

	public function content_load_dashboard()
	{

		$partner_id = $this->session->userdata('partner_id');
		$this->data['admin_info'] = $this->Manage_model->get_admin_info($partner_id);
		$dashboard = $this->load->view('/admin/content_dashboard', $this->data);
		return $dashboard;
	}
	public function content_load_manage_user()
	{
		$dashboard = $this->load->view('/admin/content_manage_user');
		return $dashboard;
	}
	public function content_load_manage_schedules()
	{
		$partner_id = $this->session->userdata('partner_id');
		$data['destinations'] = $this->Destination_model->get_all_destinations($partner_id);
		$dashboard = $this->load->view('/admin/content_manage_schedule', $data);
		return $dashboard;
	}

	public function content_load_agent_payments()
	{

		$data['payment_list'] = $this->Transaction_model->get_all_payments();
		$dashboard = $this->load->view('/agent/payments', $data);
		return $dashboard;
	}
	public function content_load_manage_vessel()
	{
		$partner_id = $this->session->userdata('partner_id');
		$data['vessel_data'] = $this->Vessel_model->fetch_all_vessel($partner_id);
		$data['destinations'] = $this->Destination_model->get_all_destinations($partner_id);
		$dashboard = $this->load->view('/admin/content_manage_vessel', $data);
		return $dashboard;
	}
	public function content_load_manage_booking()
	{
		$partner_id = $this->session->userdata('partner_id');
		$data['booking'] = $this->Booking_model->get_all_booking($partner_id);
		$dashboard = $this->load->view('/admin/content_manage_booking', $data);
		return $dashboard;
	}
	public function content_load_report_booking()
	{
		$dashboard = $this->load->view('/admin/content_report_booking');
		return $dashboard;
	}
	public function content_load_report_vessel()
	{
		$dashboard = $this->load->view('/admin/content_report_vessel');
		return $dashboard;
	}
	public function content_load_manage_cabin()
	{
		$partner_id = $this->session->userdata('partner_id');
		$data['vessel_list'] = $this->Vessel_model->fetch_all_vessel($partner_id);
		$data['cabin_data'] = $this->Cabin_model->fetch_all_cabin($partner_id);
		// var_dump($data);
		$dashboard = $this->load->view('/admin/content_manage_cabin', $data);
		return $dashboard;
	}
	public function content_load_manage_cabin_pricing()
	{

		$partner_id = $this->session->userdata('partner_id');
		$data['vessel_data'] = $this->Vessel_model->fetch_all_vessel($partner_id);
		$dashboard = $this->load->view('/admin/content_manage_cabin_pricing');
		return $dashboard;
	}

	public function content_load_manage_destinations()
	{
		$partner_id = $this->session->userdata('partner_id');
		$data['vessel_list'] = $this->Vessel_model->fetch_all_vessel($partner_id);
		$data['destinations'] = $this->Destination_model->get_all_destinations($partner_id);
		$dashboard = $this->load->view('/admin/content_manage_destinations', $data);
		return $dashboard;
	}

	public function content_load_payout()
	{
		$dashboard = $this->load->view('/admin/content_payout');
		return $dashboard;
	}

	public function content_load_agent_payouts()
	{


		$this->data['payout_list'] = $this->Transaction_model->get_all_payouts();
		$dashboard = $this->load->view('/agent/payouts', $this->data);
		return $dashboard;
	}

	public function get_booking_trends()
	{
		$weekly = $this->Manage_model->get_booking_counts('weekly');
		$monthly = $this->Manage_model->get_booking_counts('monthly');
		$yearly = $this->Manage_model->get_booking_counts('yearly');

		$data = [
			'weekly' => $weekly,
			'monthly' => $monthly,
			'yearly' => $yearly
		];

		// Return JSON for frontend JavaScript
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
	}
}


/* End of file Admin.php */
/* Location: ./application/controllers/Admin.php */
