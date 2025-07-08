<?php
defined('BASEPATH') or exit('No direct script access allowed');


/**
 *
 * Controller Payment
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

class Payment extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Cabin_model');
		$this->load->model('Booking_model');
		$this->load->model('Transaction_model');
		$this->load->model('Email_model');
	}

	public function index()
	{
		$get = $this->input->get();
		// var_dump($get);
		$this->data['ref_code'] = $get['ref_code'];
		//check if the status of ref code is confirmed
		$refcode_status = $this->Booking_model->check_ref_code_status($get['ref_code']);
		// var_dump($refcode_status);
		if ($refcode_status) {
			redirect(base_url('payment/payment_success?ref_code=') . $get['ref_code']);
		} else {

			//prepare breakdown of fees
			//get all booking details by ref_code
			$this->data['breakdown_of_fees'] = array();
			$guest_list = $this->Booking_model->get_breakdown_by_guest($get['ref_code']);

			//extract array from guestlist
			$guest_list = json_decode($guest_list[0]['guest_list'], true);
			// var_dump($guest_list);
			foreach ($guest_list as $item) {
				//get akk cabin table data
				$cabin_table_details = $this->Booking_model->get_cabin_table($item['cabin_id']);

				//calculate the percentage of surcharge
				$surchage_percent = $cabin_table_details[0]['surcharge_percentage'] / 100;

				//detect if the accommodation is for solo or not
				if ($item['solo_accommodation']) {
					$solo_accommodation = 1;
					$base_price = $cabin_table_details[0]['cabin_price'] + ($cabin_table_details[0]['cabin_price'] * $surchage_percent);
				} else {
					$solo_accommodation = 0;
					$base_price = $cabin_table_details[0]['cabin_price'];
				}
				$cabin_table_details = $this->Booking_model->get_cabin_table($item['cabin_id']);
				$this->data['breakdown_of_fees'][] = [
					'cabin_name' => $cabin_table_details[0]['cabin_name'],
					'base_price' => $base_price,
					'accommodation' => $solo_accommodation,
					'surcharge_percent' => $cabin_table_details[0]['surcharge_percentage']
				];
			}
			// var_dump($this->data['breakdown_of_fees']);

			$this->load->view('payment_page', $this->data);
		}
	}

	private function upload_single_file($file_key, $base_path)
	{
		if (isset($_FILES[$file_key]['name']) && $_FILES[$file_key]['name'] != '') {
			$file_name = basename($_FILES[$file_key]['name']);
			$target_path = $base_path . $file_name;

			// Move the uploaded file to the target path
			if (move_uploaded_file($_FILES[$file_key]['tmp_name'], $target_path)) {
				return $target_path;
			} else {
				return false; // File upload failed
			}
		}
		return null; // No file uploaded
	}

	public function submit_payment()
	{
		$post = $this->input->post();
		// var_dump($post);
		$result = $this->Booking_model->get_partner_id_byrefcode($post['ref_code']);
		$partner_id = $result[0]['partner_id'];

		//get commission percentage
		$partner_info = $this->Booking_model->get_commission_percentage($partner_id);
		$app_commission = $partner_info[0]['commission_percentage'];
		$comm = $post['total_due'] * ($app_commission / 100);
		$total = $post['total_due'];
		// Define the base path and upload files as before
		$base_path = "uploads/transaction/proof_of_payment/$partner_id/";
		if (!is_dir($base_path)) {
			mkdir($base_path, 0777, true);
		}

		$proof_of_payment_dir = $this->upload_single_file('proof_of_payment', $base_path);
		echo $proof_of_payment_dir;
		$now = new DateTime();
		//insert transaction data
		$insert_data = [
			'transaction_date' => $now->format('Y-m-d H:i:s'),
			'amount' => $total,
			'commission' => $comm,
			'status' => '0',
			'proof_of_payment' => $proof_of_payment_dir,
			'effective_commission_percentage' => $app_commission,
			'ref_code' => $post['ref_code'],
		];
		$this->Transaction_model->insert_transaction($insert_data);

		//update booking status to payment verification
		$this->Transaction_model->update_booking_status('2', $post['ref_code']);


		//send email to admin of liveaboardtrips that there is bank transfer has been made
		//get all email fro liveaboardtrips admin. role id = 0
		$this->Email_model->fetch_admin_email();
		$emailadd = 'minton.diaz005@gmail.com';
		$mail_data = [
			'header' => 'Bank Transfer has been made!',
			'message' => 'Hi Admin, There has been a payment made with above inforation',
			'subject' => 'Payment',
			'recepient' => $emailadd,
			'ref_code' => $post['ref_code']
		];
		$this->Email_model->send_mail($mail_data);
	}

	public function payment_success()
	{
		$this->data['ref_code'] = $_GET['ref_code'];
		$this->load->view('thankyou_page', $this->data);
	}

	public function fetch_payments()
	{
		$payment_list = $this->Transaction_model->get_all_payments();

		echo json_encode($payment_list);
	}
	public function payment_info()
	{
		$post = $this->input->post();
		$this->data['post'] = $post;
		$ref_code = $post['ref_code'];
		$this->data['payment_info'] = $this->Transaction_model->get_all_payments($ref_code);
		$html = $this->load->view('agent/payment_info', $this->data);
		return $html;
	}
	public function fetch_transactions()
	{
		$partner_id = $this->session->userdata('partner_id');
		$transactions = $this->Transaction_model->get_all_transaction($partner_id);
		echo json_encode($transactions);
	}
	public function fetch_payouts()
	{
		$partner_id = $this->session->userdata('partner_id');
		$transactions = $this->Transaction_model->get_all_payouts($partner_id);
		echo json_encode($transactions);
	}

	public function approve_payment()
	{
		$post = $this->input->post();
		$this->Transaction_model->update_payment_status('1', $post['ref_code']);
		echo json_encode($post);
		$this->Transaction_model->update_booking_status('4', $post['ref_code']);

		$emailadd = $this->Transaction_model->get_booking_email($post['ref_code']);
		$name = $emailadd[0]['last_name'] . ', ' . $emailadd[0]['first_name'];
		$emailadd = $emailadd[0]['email'];
		$mail_data = [
			'header' => 'Payment Confirmation',
			'message' => "Hi {$name}. please be informed that your payment has been confirmed!",
			'subject' => 'Payment',
			'recepient' => $emailadd,
			'ref_code' => $post['ref_code']
		];
		$this->Email_model->send_mail($mail_data);
	}

	public function decline_payment()
	{

		$post = $this->input->post();
		$this->Transaction_model->update_payment_status('2', $post['ref_code']);
		echo json_encode($post);
	}
	public function action_required_payment()
	{

		$post = $this->input->post();
		$this->Transaction_model->update_payment_status('3', $post['ref_code']);
		echo json_encode($post);
	}
}


/* End of file Payment.php */
/* Location: ./application/controllers/Payment.php */
