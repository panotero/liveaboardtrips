<?php
defined('BASEPATH') or exit('No direct script access allowed');


/**
 *
 * Controller Booking
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

class Booking extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Cabin_model');
		$this->load->model('Booking_model');
		$this->load->model('Email_model');
	}

	public function index()
	{
		// 
		$this->data['title'] = 'Booking Form';
		$this->data['page'] = 'booking_form';
		$get = $this->input->get();
		$this->data['schedule_id'] = $get['schedule_id'];

		$this->data['cabin_list'] = $this->Cabin_model->get_cabin_list($get['vessel_id']);
		// var_dump($this->data['cabin_list']);

		$this->load->view("template/main_template", $this->data);
	}

	public function second_step()
	{
		$post = $this->input->post();
		// var_dump($post);
		$this->data['title'] = 'Payment';
		$this->data['page'] = 'booking_payment';
		$this->data['post'] = $post;
		$ref_code = $this->generate_reference_code();
		// check if the generated code exists
		$result = $this->Booking_model->check_ref_code($ref_code);
		if ($result) {
			$ref_code = $this->generate_reference_code();
		}
		$this->data['ref_code'] = $ref_code;
		$this->data['schedule_id'] = $post['schedule_id'];
		$this->load->view("template/main_template", $this->data);
	}

	public function fetch_booking()
	{
		$partner_id = $this->session->userdata('partner_id');
		$post = $this->input->post();
		$booking_list = $this->Booking_model->get_all_booking($partner_id);


		echo json_encode($booking_list);
	}

	public function booking_info($post_id = false)
	{
		$partner_id = $this->session->userdata('partner_id');
		$post = $this->input->post();

		$partner_info = $this->Booking_model->get_commission_percentage($partner_id);
		$app_commission = $partner_info[0]['commission_percentage'];
		if (!$post_id) {
			$post_id = $post['id'];
		} else {

			$post_id = $post_id;
		}
		$this->data['postinput'] = $post;
		$this->data['post_id'] = $post_id;
		$this->data['booking_info'] = $this->Booking_model->get_all_booking($partner_id, $post['id']);
		$this->data['application_commission'] = $app_commission;
		// var_dump($this->data['booking_info'][0]['bt_ref_code']);

		//prepare breakdown of fees
		//get all booking details by ref_code
		$this->data['breakdown_of_fees'] = array();
		$guest_list = $this->Booking_model->get_breakdown_by_guest($this->data['booking_info'][0]['bt_ref_code']);

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


		$html = $this->load->view('admin/admin_booking_info', $this->data);
		return $html;
	}
	public function generate_reference_code()
	{
		// Generate a random 10-character alphanumeric string
		$characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
		$inputData = json_decode(file_get_contents('php://input'), true);

		if ($inputData) {
			$selectedCabin = $inputData['selected_cabin'];
			$refCode = $inputData['ref_code'];
			$postData = $inputData['post_data'];

			// Process booking logic here
			// Example response:
			$response = [
				'success' => true,
				'message' => 'Booking processed successfully!'
			];
		} else {
			$response = [
				'success' => false,
				'message' => 'Invalid data received!'
			];
		}


		$randomString = '';
		for ($i = 0; $i < 10; $i++) {
			$randomString .= $characters[rand(0, strlen($characters) - 1)];
		}
		return $randomString;
	}

	public function process_booking()
	{
		// $post =  $this->input->post();
		$inputData = json_decode(file_get_contents('php://input'), true);

		if ($inputData) {
			$selectedCabin = json_decode($inputData['selected_cabin'], true);
			$selectedCabin = json_decode($selectedCabin, true);
			$refCode = $inputData['ref_code'];
			$postData = $inputData['post_data'];
			$schedule_id =  $inputData['schedule_id'];
			$timezone = $inputData['timezone'];
			date_default_timezone_set($timezone);
			//get partner id
			$partner_id = $this->Booking_model->get_partner_id($schedule_id);
			// Process booking logic here
			//save booking client info
			//create user_id save user info first
			$bui_data = [
				'ref_code' => $refCode,
				'first_name' => $postData['first_name'],
				'last_name' => $postData['last_name'],
				'address_1' => $postData['address'],
				'address_2' => json_encode($selectedCabin),
				'country' => $postData['country'],
				'city' => $postData['city'],
				'mobile' => $postData['mobile'],
				'email' => $postData['email'],
				'phone' => $postData['phone'],
				'guest_list' => json_encode($inputData['guests'])
			];

			$user_id = $this->Booking_model->insert_userinfo($bui_data);

			foreach ($selectedCabin as $cabin) {
				if ($cabin['quantity'] != 0) {

					//booking details
					$bd_data = [
						'ref_code' => $refCode,
						'schedule_id' => $schedule_id,
						'cabin_id' => $cabin['id'],
						'guest_number' => $cabin['quantity'],
					];
					$this->Booking_model->insert_details($bd_data);
				}
			}
			//booking_table data
			$bt_data = [
				'ref_code' => $refCode,
				'user_id' =>  $user_id,
				'booking_details_id' => '',
				'trip_year' => '',
				'partner_id' => $partner_id[0]['partner_id'],
				'schedule_id' => $schedule_id,
				'booking_date' => date('Y-m-d H:i:s'),
				'status' => '0',
			];
			$booking_id = $this->Booking_model->insert_booking_table($bt_data);
			$email = $postData['email'];
			//send email notif to client
			$mail_data = [
				'header' => 'Booking Submitted.',
				'message' => 'We have received your booking request. please give us atleast 3 working days for confirmation. Thank you!',
				'subject' => 'Booking Submission',
				'recepient' => $email,
				'ref_code' => $refCode
			];
			$this->Email_model->send_mail($mail_data);
			if ($booking_id) {
				//select * user admin based on the partner id
				$email = $this->Booking_model->get_admin_emails($partner_id[0]['partner_id'],);
				if ($email) {
					foreach ($email as $emailadd) {
						$emailadd = $emailadd['email'];
						//send email notif to client
						$mail_data = [
							'header' => 'New Booking!',
							'message' => 'We got New booking for you with reference code:',
							'subject' => 'New Booking',
							'recepient' => $emailadd,
							'ref_code' => $refCode
						];
						$this->Email_model->send_mail($mail_data);
					}
				}
			}


			//save guest list info

			//send email to client

			//send email notif to operator





			// Example response:
			$response = [
				'success' => true,
				'message' => 'Booking processed successfully! ',
				'ref_code' => $refCode,
			];
		} else {
			$response = [
				'success' => false,
				'message' => 'Invalid data received!'
			];
		}



		echo json_encode($response);
	}

	public function booking_accept()
	{
		//get all posted inputs
		$post = $this->input->post();
		$post_id = $post['id'];
		$breakdown = json_decode($post['breakdown'], true);
		// var_dump($breakdown);
		//get ref_code
		$ref_code = $post['ref_code'];
		//get email
		$email_recepients = [$post['email']];
		$app_com = $post['app_comm'];


		foreach ($email_recepients as $email) {

			//send email notif to client
			$mail_data = [
				'header' => 'Your booking has been confirmed.',
				'message' => 'Please be informed that your booking with reference code above has been confirmed. please pay the fees indicated below',
				'subject' => 'Booking Confirmation',
				'recepient' => $email,
				'ref_code' => $ref_code,
				'breakdown' => $breakdown
			];
			$this->Email_model->send_mail($mail_data);
		}

		//update ref_code status to confirmed
		$this->update_booking_status('1', $ref_code);

		return $this->booking_info($post_id);
	}

	public function update_booking_status($status, $ref_code)
	{
		$this->Booking_model->update_booking_status($status, $ref_code);
	}


	public function email_template()
	{
		$this->load->view('email_template');
	}

	public function success_page()
	{
		$get = $this->input->get();

		// var_dump($post);
		$this->data['title'] = 'Booking Success';
		$this->data['page'] = 'booking_success';
		$this->data['get'] = $get;
		$this->data['booking_details'] = $this->Booking_model->fetch_booking_summary($get['ref_code']);
		$this->load->view("template/main_template", $this->data);
	}
}


/* End of file Booking.php */
/* Location: ./application/controllers/Booking.php */
