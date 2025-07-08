<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *
 * Model Destination_model
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

class Destination_model extends CI_Model
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

  public function get_all_destinations($partner_id)
  {

    $this->db->select('*');
    $this->db->from('destination_table');
    $this->db->where('partner_id', $partner_id);
    $query = $this->db->get();
    $result = $query->result_array();
    return $result;
  }
  public function get_all_destinations_byid($id)
  {

    $this->db->select('*');
    $this->db->from('destination_table');
    $this->db->where('id', $id);
    $query = $this->db->get();
    $result = $query->result_array();
    return $result;
  }

  public function insert_destination($params)
  {

    $this->db->insert('destination_table', $params);
    return $this->db->insert_id(); // Return the ID of the inserted row
  }

  public function removePhotoFromDatabase($photoPath)
  {
    // Query to find the record containing the photoPath
    $this->db->like('destination_photos', $photoPath);
    $destination = $this->db->get('destination_table')->row();

    if ($destination) {
      // Remove the photo path from the vessel_photos field
      $updatedPhotos = array_filter(
        explode(';', $destination->destination_photos),
        function ($photo) use ($photoPath) {
          return $photo !== $photoPath;
        }
      );

      $updatedPhotosString = implode(';', $updatedPhotos);

      // Update the record
      $this->db->where('id', $destination->id);
      $this->db->update('destination_table', ['destination_photos' => $updatedPhotosString]);
    }
  }
  public function get_photos_by_destination_id($destination_id)
  {
    $this->db->select('destination_photos');
    $this->db->from('destination_table');
    $this->db->where('id', $destination_id);
    $query = $this->db->get();
    $result = $query->row_array();
    return $result ? $result['destination_photos'] : '';
  }
  public function update_destination($destination_id, $data)
  {
    $this->db->where('id', $destination_id);
    return $this->db->update('destination_table', $data);
  }

  public function delete_destination($destination_id)
  {

    $this->db->where('id', $destination_id);
    $result = $this->db->delete('destination_table');
    return $result;
  }

  // ------------------------------------------------------------------------

}

/* End of file Destination_model.php */
/* Location: ./application/models/Destination_model.php */