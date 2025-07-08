<?php
defined('BASEPATH') or exit('No direct script access allowed');


/**
 *
 * Controller Vessel
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

class Vessel extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('Vessel_model');
    $this->load->model('Destination_model');
    $this->load->model('Search_model');
    $this->load->model('Cabin_model');
  }

  public function index($vessel_id = false) {}

  public function vessel_info($vessel_id)
  {
    // 
    $get = $this->input->get();

    $search_data = [
      'destination' =>  $_GET['destination'],
      'month' => $_GET['month'],
      'year' =>  $_GET['year'],
    ];
    // var_dump($get);
    $this->data['title'] = 'Vessel Information';
    $this->data['page'] = 'vessel_info_page';
    $this->data['vessel_info'] = $this->Vessel_model->get_vessel_data($get['vessel_id']);

    $this->data['cabin_info'] = $this->Search_model->get_cabin_prices($get['vessel_id'], $search_data);
    $this->data['cabin_list'] = $this->Cabin_model->get_cabin_list($get['vessel_id']);
    // var_dump($cabin_price);
    $this->load->view("template/main_template", $this->data);
  }
  public function admin_vessel_info()
  {
    $post = $this->input->post();
    $this->data['postinput'] = $post;
    $this->data['vessel_info'] = $this->Vessel_model->get_vessel_data($post['id']);

    $html = $this->load->view('admin/admin_vessel_info', $this->data);
    return $html;
  }
  public function admin_vessel_add()
  {
    $post = $this->input->post();
    $this->data['postinput'] = $post;
    $html = $this->load->view('admin/admin_vessel_add', $this->data);
    return $html;
  }
  public function insert_vessel_main()
  {
    $post = $this->input->post();

    // Define the base path and upload files as before
    $partner_id = $this->session->userdata('partner_id');
    $base_path = "uploads/$partner_id/vessel/img/";

    if (!is_dir($base_path)) {
      mkdir($base_path, 0777, true);
    }

    $vessel_thumbnail = $this->upload_single_file('vessel_thumbnail', $base_path);
    $vessel_photos_paths = $this->upload_multiple_files('vessel_photos', $base_path);
    $vessel_photos = $vessel_photos_paths ? implode(';', $vessel_photos_paths) : '';

    // Insert main vessel data and get vessel ID
    $data = [
      'partner_id' => $partner_id,
      'vessel_name' => $post['vessel_name'],
      'vessel_thumbnail' => $vessel_thumbnail,
      'vessel_photos' => $vessel_photos,
    ];

    $vessel_id = $this->Vessel_model->insert_vessel_table($data);

    // If main data is inserted, process features
    if ($vessel_id) {
      if (!empty($post['vessel_feature_type'])) {
        foreach ($post['vessel_feature_type'] as $index => $type) {
          $feature_data = [
            'vessel_id' => $vessel_id,
            'vessel_feature_type' => $type,
            'vessel_feature_title' => $post['vessel_feature_title'][$index],
          ];
          $this->Vessel_model->insert_vessel_features($feature_data);
        }
      }
      echo "Vessel main data and features inserted with ID: $vessel_id";
    } else {
      echo "Failed to insert vessel main data.";
    }
    $this->insert_vessel_specification($vessel_id);
  }

  public function save_vessel_modification()
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

  public function insert_vessel_specification($vessel_id)
  {
    $post = $this->input->post();
    $data = [
      'vessel_id' => $vessel_id,
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
      'vessel_water_capacity' => $post['vessel_water_capacity']
    ];

    $this->Vessel_model->insert_vessel_specification($data);
    echo "Vessel specification data inserted.";
  }

  public function insert_vessel_features($vessel_id)
  {
    $post = $this->input->post();
    $data = [
      'vessel_id' => $vessel_id,
      'vessel_feature_type' => $post['vessel_feature_type'],
      'vessel_feature_title' => $post['vessel_feature_title']
    ];

    $this->Vessel_model->insert_vessel_features($data);
    echo "Vessel feature data inserted.";
  }

  public function insert_vessel_cabin($vessel_id)
  {
    $post = $this->input->post();
    $data = [
      'vessel_id' => $vessel_id,
      'cabin_title' => $post['cabin_title'],
      'cabin_description' => $post['cabin_description'],
      'cabin_max_guests' => $post['cabin_max_guests'],
      'cabin_bed_number' => $post['cabin_bed_number'],
      'cabin_base_price' => $post['cabin_base_price'],
      'cabin_availability' => $post['cabin_availability']
    ];

    $this->Vessel_model->insert_vessel_cabin($data);
    echo "Vessel cabin data inserted.";
  }

  public function delete_vessel()
  {
    if (!$this->input->is_ajax_request()) {
      show_404();
    }


    // Decode the JSON input
    $input = json_decode($this->input->raw_input_stream, true);
    if (!isset($input['vessel_id']) || empty($input['vessel_id'])) {
      echo json_encode(['success' => false, 'message' => 'Invalid Cabin ID']);
      return;
    }
    $this->Vessel_model->delete_cabin($input['vessel_id']);
    echo json_encode(['success' => true, 'message' => 'Cabin has been deleted successfully.']);
  }
  public function delete_photo()
  {
    // Ensure it's an AJAX request
    if (!$this->input->is_ajax_request()) {
      show_404();
    }

    // Load necessary model
    $this->load->model('Vessel_model');

    // Decode the JSON input
    $input = json_decode($this->input->raw_input_stream, true);
    // var_dump($input);
    if (!isset($input['photo']) || empty($input['photo'])) {
      echo json_encode(['success' => false, 'message' => 'No photo path provided.']);
      return;
    }

    $photoPath = $input['photo'];

    $this->Vessel_model->removePhotoFromDatabase($photoPath);
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

  public function add_photos_to_destination()
  {
    $post = $this->input->post();
    $vessel_id = $post['vessel_id']; // Destination ID from the request

    // Define the base path for uploading photos
    $partner_id = $this->session->userdata('partner_id'); // Replace with dynamic partner_id if needed
    $base_path = "uploads/$partner_id/vessel/img/";

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
    $existing_photos = $this->Vessel_model->get_photos_by_vessel_id($vessel_id);
    $existing_photos_array = $existing_photos ? explode(';', $existing_photos) : [];

    // Merge existing photos with new ones
    $updated_photos_array = array_merge($existing_photos_array, $new_photos_paths);
    $updated_photos = implode(';', $updated_photos_array);

    // Update the destination_photos column in the database
    $update_data = ['vessel_photos' => $updated_photos];
    $update_result = $this->Vessel_model->update_vessel($vessel_id, $update_data);

    if ($update_result) {
      echo json_encode(['status' => 'success', 'message' => 'Photos added successfully.']);
    } else {
      echo json_encode(['status' => 'error', 'message' => 'Failed to update destination photos.']);
    }
  }
}


/* End of file Vessel.php */
/* Location: ./application/controllers/Vessel.php */
