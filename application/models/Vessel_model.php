<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *
 * Model Vessel_model
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

class Vessel_model extends CI_Model
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
  public function fetch_all_vessel($partner_id = false)
  {
    $this->db->select('*');
    $this->db->from('vessel_table');
    $this->db->where('partner_id', $partner_id);
    $query = $this->db->get();
    $result = $query->result_array();
    return $result;
  }

  // Function to fetch data from multiple related tables
  public function get_vessel_data($vessel_id,)
  {
    $partner_id = $this->session->userdata('partner_id');
    $this->db->select('vt.*, vs.*, vf.*, vc.*');
    $this->db->from('vessel_table vt');
    $this->db->join('vessel_specification vs', 'vs.vessel_id = vt.id', 'left');
    $this->db->join('vessel_features vf', 'vf.vessel_id = vt.id', 'left');
    $this->db->join('vessel_cabin vc', 'vc.vessel_id = vt.id', 'left');
    $this->db->where('vt.id', $vessel_id);
    $this->db->limit(1);
    $query = $this->db->get();

    // Process the result into a multi-dimensional array
    $result = $query->result_array();

    return $result;
  }

  // Insert function for vessel_table
  public function insert_vessel_table($data)
  {
    $this->db->insert('vessel_table', $data);
    return $this->db->insert_id(); // Return the ID of the inserted row
  }

  // Insert function for vessel_specification
  public function insert_vessel_specification($data)
  {
    return $this->db->insert('vessel_specification', $data);
  }

  // Insert function for vessel_features
  public function insert_vessel_features($data)
  {
    return $this->db->insert('vessel_features', $data);
  }
  public function insert_cabin_details($data)
  {

    $this->db->insert('cabin_details', $data);
    return true;
  }

  // Insert function for vessel_cabin
  public function insert_vessel_cabin($data)
  {
    return $this->db->insert('vessel_cabin', $data);
  }

  // Function to delete a vessel and all related data
  public function delete_vessel($vessel_id)
  {
    // Delete from vessel_cabin
    $this->db->where('vessel_id', $vessel_id);
    $this->db->delete('vessel_cabin');

    // Delete from vessel_features
    $this->db->where('vessel_id', $vessel_id);
    $this->db->delete('vessel_features');

    // Delete from vessel_specification
    $this->db->where('vessel_id', $vessel_id);
    $this->db->delete('vessel_specification');

    // Delete from vessel_table
    $this->db->where('id', $vessel_id);
    $this->db->delete('vessel_table');
  }
  public function update_vessel_table($vessel_id, $data)
  {
    // Prepare the data for updating
    unset($data['id']); // Remove id from data array if present

    // Update the vessel information
    $this->db->where('id', $vessel_id);
    return $this->db->update('vessel_table', $data); // Replace 'vessel_table_name' with your actual table name
  }

  public function update_vessel_specification($vessel_id, $data)
  {
    $this->db->where('vessel_id', $vessel_id);
    return $this->db->update('vessel_specification', $data); // Adjust the table name accordingly
  }

  public function update_vessel_feature($vessel_id, $data)
  {
    $this->db->where('vessel_id', $vessel_id);
    return $this->db->update('vessel_feature', $data); // Adjust the table name accordingly
  }
  public function removePhotoFromDatabase($photoPath)
  {
    // Query to find the record containing the photoPath
    $this->db->like('vessel_photos', $photoPath);
    $vessel = $this->db->get('vessel_table')->row();

    if ($vessel) {
      // Remove the photo path from the vessel_photos field
      $updatedPhotos = array_filter(
        explode(';', $vessel->vessel_photos),
        function ($photo) use ($photoPath) {
          return $photo !== $photoPath;
        }
      );

      $updatedPhotosString = implode(';', $updatedPhotos);

      // Update the record
      $this->db->where('id', $vessel->id);
      $this->db->update('vessel_table', ['vessel_photos' => $updatedPhotosString]);
    }
  }

  public function get_photos_by_vessel_id($vessel_id)
  {
    $this->db->select('vessel_photos');
    $this->db->from('vessel_table');
    $this->db->where('id', $vessel_id);
    $query = $this->db->get();
    $result = $query->row_array();
    return $result ? $result['vessel_photos'] : '';
  }
  public function update_vessel($vessel_id, $data)
  {
    $this->db->where('id', $vessel_id);
    return $this->db->update('vessel_table', $data);
  }

  public function delete_cabin($vessel_id)
  {

    $this->db->where('id', $vessel_id);
    $result = $this->db->delete('vessel_table');
    //delete specification and features

    $this->db->where('vessel_id', $vessel_id);
    $this->db->delete('vessel_specification');

    $this->db->where('vessel_id', $vessel_id);
    $this->db->delete('vessel_features');

    return $result;
  }

  // ------------------------------------------------------------------------

}

/* End of file Vessel_model.php */
/* Location: ./application/models/Vessel_model.php */