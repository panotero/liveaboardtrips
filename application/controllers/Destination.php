<?php
defined('BASEPATH') or exit('No direct script access allowed');


/**
 *
 * Controller Destination
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

class Destination extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('Destination_model');
    $this->load->model('Vessel_model');
  }

  public function index()
  {
    // 
  }
  public function admin_destination_info($destination_id = false)
  {
    $post = $this->input->post();
    $this->data['postinput'] = $post;
    // $this->data['vessel_list'] = $this->Vessel_model->fetch_all_vessel();
    $this->data['destination_info'] = $this->Destination_model->get_all_destinations_byid($post['id']);
    $html = $this->load->view('admin/admin_destination_info', $this->data);
    return $html;
  }
  public function admin_destination_add()
  {
    $post = $this->input->post();
    $this->data['postinput'] = $post;
    $html = $this->load->view('admin/admin_destination_add', $this->data);
    return $html;
  }

  public function insert_destination_main()
  {
    $post = $this->input->post();

    $partner_id = $this->session->userdata('partner_id');
    // Define the base path and upload files as before
    $base_path = "uploads/$partner_id/destinations/img/";

    if (!is_dir($base_path)) {
      mkdir($base_path, 0777, true);
    }

    $destination_thumbnail = $this->upload_single_file('destination_thumbnail', $base_path);
    $destination_photos_paths = $this->upload_multiple_files('destination_photos', $base_path);
    $destination_photos = $destination_photos_paths ? implode(';', $destination_photos_paths) : '';

    // Insert main vessel data and get vessel ID
    $data = [
      'partner_id' => $partner_id,
      'destination_name' => $post['destination_name'],
      'destination_thumbnail' => $destination_thumbnail,
      'destination_popularity_points' => '0',
      'destination_photos' => $destination_photos,
      'destination_country' => $post['destination_country'],
      'vessel_id_list' => $post['destination_vessel_id'],
    ];

    $destination_id = $this->Destination_model->insert_destination($data);

    // If main data is inserted, process features
    if ($destination_id) {
      if (!empty($post['vessel_feature_type'])) {
        foreach ($post['vessel_feature_type'] as $index => $type) {
          $feature_data = [
            'vessel_id' => $destination_id,
            'vessel_feature_type' => $type,
            'vessel_feature_title' => $post['vessel_feature_title'][$index],
          ];
        }
      }
      echo "Vessel main data and features inserted with ID: $destination_id";
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
    if (isset($_FILES[$file_key]['name']) && count($_FILES[$file_key]['name']) > 0) {
      foreach ($_FILES[$file_key]['name'] as $key => $file_name) {
        if ($file_name != '') {
          $target_path = $base_path . basename($file_name);
          if (move_uploaded_file($_FILES[$file_key]['tmp_name'][$key], $target_path)) {
            $file_paths[] = $target_path;
          } else {
            return false; // Some uploads failed
          }
        }
      }
    }
    return $file_paths; // Return an array of uploaded file paths
  }

  public function delete_photo()
  {
    // Ensure it's an AJAX request
    if (!$this->input->is_ajax_request()) {
      show_404();
    }

    // Load necessary model
    $this->load->model('Destination_model');

    // Decode the JSON input
    $input = json_decode($this->input->raw_input_stream, true);
    // var_dump($input);
    if (!isset($input['photo']) || empty($input['photo'])) {
      echo json_encode(['success' => false, 'message' => 'No photo path provided.']);
      return;
    }

    $photoPath = $input['photo'];

    $this->Destination_model->removePhotoFromDatabase($photoPath);
    echo json_encode(['success' => true, 'message' => 'Photo deleted successfully.']);

    // // Ensure the file exists
    // if (file_exists($photfilepath)) {
    //   // Delete the file
    //   if (unlink($photfilepath)) {
    //     // Update the database record
    //     $this->Vessel_model->removePhotoFromDatabase($photoPath);

    //     echo json_encode(['success' => true, 'message' => 'Photo deleted successfully.']);
    //   } else {
    //     echo json_encode(['success' => false, 'message' => 'Failed to delete the photo file.']);
    //   }
    // } else {
    //   echo json_encode(['success' => false, 'message' => 'Photo file does not exist.']);
    // }
  }


  public function save_destination_modification()
  {
    $post = $this->input->post();

    // Define the base path using partner_id
    $partner_id = '22';
    $base_path = "uploads/$partner_id/vessel/img/";

    // Create the directory if it does not exist
    if (!is_dir($base_path)) {
      mkdir($base_path, 0777, true);
    }

    // Prepare data for modification
    $data = [
      'vessel_name' => $post['vessel_name'],
      // Only set thumbnail if it is uploaded
    ];

    // Upload vessel thumbnail if a new file is attached
    $vessel_thumbnail = $this->upload_single_file('vessel_thumbnail', $base_path);
    if (!empty($vessel_thumbnail)) {
      $data['vessel_thumbnail'] = $vessel_thumbnail; // Add it to data only if a new thumbnail is uploaded
    }

    // Upload vessel photos if new files are attached
    $vessel_photos_paths = $this->upload_multiple_files('vessel_photos', $base_path);
    if ($vessel_photos_paths) {
      $data['vessel_photos'] = implode(';', $vessel_photos_paths); // Add it to data only if new photos are uploaded
    }

    // Assuming vessel_id is part of $post for modification
    $vessel_id = $post['id'];

    // Update the database with modified data
    $this->Vessel_model->update_vessel_table($vessel_id, $data);

    // Prepare data for vessel specification
    $data_vessel_specification = [
      'vessel_year_model' => $post['vessel_year_model'],
      'vessel_year_renovation' => $post['vessel_year_renovation'],
      'vessel_beam' => $post['vessel_beam'],
      'vessel_fuel_capacity' => $post['vessel_fuel_capacity'],
      'vessel_cabin_capacity' => $post['vessel_cabin_capacity'],
      'vessel_bathroom_number' => $post['vessel_bathroom_number'],
      'vessel_topspeed' => $post['vessel_topspeed'],
      'vessel_cruisingspeed' => $post['vessel_cruisingspeed'],
      'vessel_engines' => $post['vessel_engines'],
      'vessel_max_guest_capacity' => $post['vessel_max_guest_capacity'],
      'vessel_freshwater_maker' => $post['vessel_freshwater_maker'],
      'vessel_tenders' => $post['vessel_tenders'],
      'vessel_water_capacity' => $post['vessel_water_capacity'],
    ];

    // Update vessel specifications
    $this->Vessel_model->update_vessel_specification($vessel_id, $data_vessel_specification);

    echo "Vessel data updated successfully.";
  }
  public function add_photos_to_destination()
  {
    $post = $this->input->post();
    $destination_id = $post['destination_id']; // Destination ID from the request

    // Define the base path for uploading photos
    $partner_id = '22'; // Replace with dynamic partner_id if needed
    $base_path = "uploads/$partner_id/destinations/img/";

    if (!is_dir($base_path)) {
      mkdir($base_path, 0777, true);
    }

    // Upload new photos
    $new_photos_paths = $this->upload_multiple_files('photos', $base_path);

    if (!$new_photos_paths) {
      echo json_encode(['status' => 'error', 'message' => 'Photo upload failed.']);
      return;
    }

    // Fetch existing photos from the database
    $existing_photos = $this->Destination_model->get_photos_by_destination_id($destination_id);
    $existing_photos_array = $existing_photos ? explode(';', $existing_photos) : [];

    // Merge existing photos with new ones
    $updated_photos_array = array_merge($existing_photos_array, $new_photos_paths);
    $updated_photos = implode(';', $updated_photos_array);

    // Update the destination_photos column in the database
    $update_data = ['destination_photos' => $updated_photos];
    $update_result = $this->Destination_model->update_destination($destination_id, $update_data);

    if ($update_result) {
      echo json_encode(['status' => 'success', 'message' => 'Photos added successfully.']);
    } else {
      echo json_encode(['status' => 'error', 'message' => 'Failed to update destination photos.']);
    }
  }


  public function delete_destination()
  {
    if (!$this->input->is_ajax_request()) {
      show_404();
    }


    // Decode the JSON input
    $input = json_decode($this->input->raw_input_stream, true);
    if (!isset($input['destination_id']) || empty($input['destination_id'])) {
      echo json_encode(['success' => false, 'message' => 'Invalid Cabin ID']);
      return;
    }
    $this->Destination_model->delete_destination($input['destination_id']);
    echo json_encode(['success' => true, 'message' => 'Cabin has been deleted successfully.']);
  }
}


/* End of file Destination.php */
/* Location: ./application/controllers/Destination.php */