<?php
defined('BASEPATH') or exit('No direct script access allowed');


/**
 *
 * Controller Cabin
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

class Cabin extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Cabin_model');
		$this->load->model('Manage_model');
	}

	public function index()
	{
		// 
	}

	public function admin_cabin_info()
	{
		$post = $this->input->post();
		$this->data['postinput'] = $post;
		$this->data['cabin_info'] = $this->Cabin_model->get_cabin_info($post['id']);

		$html = $this->load->view('admin/admin_cabin_info', $this->data);
		return $html;
	}

	public function delete_cabin_photo()
	{
		if (!$this->input->is_ajax_request()) {
			show_404();
		}


		// Decode the JSON input
		$input = json_decode($this->input->raw_input_stream, true);
		// var_dump($input);
		if (!isset($input['photo']) || empty($input['photo'])) {
			echo json_encode(['success' => false, 'message' => 'No photo path provided.']);
			return;
		}

		$photoPath = $input['photo'];
		$cabin_id = $input['cabin_id'];

		$this->Cabin_model->delete_photo_from_cabin($photoPath, $cabin_id);
		echo json_encode(['success' => true, 'message' => 'Photo deleted successfully.']);
	}

	public function insert_cabin()
	{

		$post = $this->input->post();
		// var_dump($_FILES);
		// Define the base path and upload files as before
		$partner_id = $this->session->userdata('partner_id');
		$base_path = "uploads/$partner_id/cabin/img/";

		if (!is_dir($base_path)) {
			mkdir($base_path, 0777, true);
		}

		$cabin_thumbnail = $this->upload_single_file('cabin_thumbnail', $base_path);
		$cabin_photos_paths = $this->upload_multiple_files('cabin_photos', $base_path);
		$cabin_photos = $cabin_photos_paths ? implode(';', $cabin_photos_paths) : '';
		echo $cabin_photos;
		// Insert main vessel data and get vessel ID
		$data = [
			'partner_id' => $partner_id,
			'cabin_name' => $post['cabin_name'],
			'cabin_description' => $post['cabin_description'],
			'guest_capacity' => $post['guest_capacity'],
			'bed_number' => $post['bed_number'],
			'cabin_number' => $post['cabin_number'],
			'cabin_thumbnail' => $cabin_thumbnail,
			'vessel_id' => $post['vessel_id'],
			'cabin_photos' => $cabin_photos,
		];

		$cabin_id = $this->Cabin_model->insert_cabin($data);

		$data = [
			'cabin_details_id' => $cabin_id,
			'cabin_price' => $post['cabin_price'],
			'vessel_id' => $post['vessel_id'],
			'schedule_id' => "",
			'trip_year' => "",
			'partner_id' => $partner_id,
			'surcharge_percentage' => $post['cabin_surcharge']
		];

		$result = $this->Manage_model->insert_cabin($data);

		// If main data is inserted, process features
		if ($cabin_id) {
			echo "Vessel main data and features inserted with ID: $cabin_id";
		} else {
			echo "Failed to insert vessel main data.";
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

	private function upload_multiple_files($file_key, $base_path)
	{
		$file_paths = [];
		$partner_id = $this->session->userdata('partner_id');
		$date_str = date('dmY'); // Format: 24062025
		if (isset($_FILES[$file_key]['name']) && count($_FILES[$file_key]['name']) > 0) {
			foreach ($_FILES[$file_key]['name'] as $key => $original_name) {
				if ($original_name != '') {
					// Get file extension
					$ext = pathinfo($original_name, PATHINFO_EXTENSION);

					// Generate new file name
					$new_name = "cab_{$partner_id}_{$date_str}_{$key}." . $ext;

					// Full path
					$target_path = $base_path . basename($new_name);

					// Move the file
					if (move_uploaded_file($_FILES[$file_key]['tmp_name'][$key], $target_path)) {
						$file_paths[] = $target_path; // Just store the filename, or use $target_path if you want full path
					} else {
						return false; // If any upload fails
					}
				}
			}
		}

		return $file_paths; // Returns array of filenames
	}



	public function delete_cabin()
	{
		if (!$this->input->is_ajax_request()) {
			show_404();
		}


		// Decode the JSON input
		$input = json_decode($this->input->raw_input_stream, true);
		if (!isset($input['cabin_id']) || empty($input['cabin_id'])) {
			echo json_encode(['success' => false, 'message' => 'Invalid Cabin ID']);
			return;
		}
		$this->Cabin_model->delete_cabin($input['cabin_id']);
		echo json_encode(['success' => true, 'message' => 'Cabin has been deleted successfully.']);
	}

	public function fetch_cabin_list()
	{
		$post = $this->input->post();
		$vessel_id = $post['vessel_id'];
		// var_dump($post);
		$cabin_list = $this->Cabin_model->fetch_cabin_list($vessel_id);
		if ($post['vessel_id'] == "") {
			echo json_encode("");
		} else {

			echo json_encode($cabin_list);
		}
	}
}


/* End of file Cabin.php */
/* Location: ./application/controllers/Cabin.php */
