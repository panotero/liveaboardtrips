<?php
defined('BASEPATH') or exit('No direct script access allowed');


/**
 *
 * Controller Manage
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

class Manage extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('User_model');
		$this->load->model('Manage_model');
		$this->load->model('Vessel_model');
	}

	public function index()
	{
		// 
		echo 'hellos';
	}
	// Fetch all schedules
	public function fetch_schedules()
	{
		$partner_id = $this->session->userdata('partner_id');
		$post = $this->input->post();
		if (isset($post['month']) && isset($post['year'])) {
			$schedules = $this->Manage_model->get_all_schedules_bydate($post['month'], $post['year'], $partner_id);
		} else {

			$schedules = $this->Manage_model->get_all_schedules($partner_id);
		}
		echo json_encode($schedules);
	}
	// Insert a new schedule
	public function insert_schedule()
	{
		$partner_id = $this->session->userdata('partner_id');
		$data = [
			'schedule_title' => $this->input->post('schedule_title'),
			'schedule_from' => $this->input->post('schedule_from'),
			'schedule_to' => $this->input->post('schedule_to'),
			'vessel_id' => $this->input->post('vessel_id'),
			'destination_id' => $this->input->post('destination_id'),
			'itinerary' => $this->input->post('itinerary'),
			'partner_id' => $partner_id
		];

		$result = $this->Manage_model->insert_schedule($data);
		echo json_encode(['success' => $result]);
	}
	// Fetch all schedules
	public function fetch_cabin()
	{
		$partner_id = $this->session->userdata('partner_id');
		$post = $this->input->post();
		$cabin = $this->Manage_model->get_all_cabin($partner_id);
		echo json_encode($cabin);
	}
	public function insert_cabin_price()
	{

		$partner_id = $this->session->userdata('partner_id');
		$data = [
			'cabin_details_id' => $this->input->post('cabin_id'),
			'cabin_price' => $this->input->post('cabin_price'),
			'vessel_id' => $this->input->post('vessel_id'),
			'schedule_id' => "",
			'trip_year' => "",
			'partner_id' => $partner_id,
			'surcharge_percentage' => $this->input->post('surcharge_percentage')
		];

		$result = $this->Manage_model->insert_cabin($data);
		echo json_encode(['success' => $result]);
	}

	// Update a schedule by ID
	public function update_schedule($id)
	{
		$data = [
			'schedule_title' => $this->input->post('schedule_title'),
			'schedule_from' => $this->input->post('schedule_from'),
			'schedule_to' => $this->input->post('schedule_to'),
			'vessel_id' => $this->input->post('vessel_id'),
			'itinerary' => $this->input->post('itinerary')
		];

		$result = $this->Manage_model->update_schedule($id, $data);
		echo json_encode(['success' => $result]);
	}

	// Delete a schedule by ID
	public function cancel_schedule()
	{
		$post = $this->input->post();

		if (is_array($post['id'])) {
			foreach ($post['id'] as $id) {
				$result = $this->Manage_model->cancel_schedule($id);
				if (!$result) {
					// If any deletion fails, return false
					echo json_encode(['success' => false, 'message' => 'Error deleting some schedules.']);
					return;
				}
			}
		} else {
			$result = $this->Manage_model->cancel_schedule($post['id']);
			if (!$result) {
				// If any deletion fails, return false
				echo json_encode(['success' => false, 'message' => 'Error deleting some schedules.']);
				return;
			}
		}
		// If all deletions succeed, return success
		echo json_encode(['success' => true]);
	}
	// Delete a schedule by ID
	public function delete_cabin()
	{
		$post = $this->input->post();

		if (is_array($post['id'])) {
			foreach ($post['id'] as $id) {
				$result = $this->Manage_model->delete_cabin($id);
				if (!$result) {
					// If any deletion fails, return false
					echo json_encode(['success' => false, 'message' => 'Error deleting some records.']);
					return;
				}
			}
		} else {
			$result = $this->Manage_model->delete_cabin($post['id']);
			if (!$result) {
				// If any deletion fails, return false
				echo json_encode(['success' => false, 'message' => 'Error deleting some records.']);
				return;
			}
		}
		// If all deletions succeed, return success
		echo json_encode(['success' => true]);
	}

	public function delete_cabin_price()
	{
		$post = $this->input->post();

		if (is_array($post['cabinprice_id'])) {
			foreach ($post['cabinprice_id'] as $id) {
				$result = $this->Manage_model->delete_cabin_price($id);
				if (!$result) {
					// If any deletion fails, return false
					echo json_encode(['success' => false, 'message' => 'Error deleting some records.']);
					return;
				}
			}
		} else {
			$result = $this->Manage_model->delete_cabin_price($post['cabinprice_id']);
			if (!$result) {
				// If any deletion fails, return false
				echo json_encode(['success' => false, 'message' => 'Error deleting some records.']);
				return;
			}
		}
		// If all deletions succeed, return success
		echo json_encode(['success' => true]);
	}
	// Function to fetch all vessels
	public function fetch_vessels()
	{
		$partner_id = $this->session->userdata('partner_id');
		$vessels = $this->Vessel_model->fetch_all_vessel($partner_id);
		echo json_encode($vessels);
	}
	public function fetch_settings_roles()
	{

		$roles = $this->Manage_model->fetch_settings_roles();
		echo json_encode($roles);
	}
	public function fetch_partners()
	{

		$roles = $this->Manage_model->fetch_partners();
		echo json_encode($roles);
	}
	public function disable_user()
	{
		$user_id = $this->input->post('user_id');

		$result = $this->User_model->disable_user($user_id);

		if ($result) {
			echo json_encode(['success' => true, 'message' => 'User disabled successfully.']);
		} else {
			echo json_encode(['success' => false, 'message' => 'Failed to disable user.']);
		}
	}
	public function enable_user()
	{
		$user_id = $this->input->post('user_id');

		$result = $this->User_model->enable_user($user_id);

		if ($result) {
			echo json_encode(['success' => true, 'message' => 'User Enabled successfully.']);
		} else {
			echo json_encode(['success' => false, 'message' => 'Failed to enable user.']);
		}
	}
}


/* End of file Manage.php */
/* Location: ./application/controllers/Manage.php */
