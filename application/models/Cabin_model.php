
<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *
 * Model Cabin_model
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

class Cabin_model extends CI_Model
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

	public function fetch_all_cabin($partnerid)
	{
		$this->db->select('*');
		$this->db->from('cabin_details');
		$this->db->where('partner_id', $partnerid);
		$result = $this->db->get()->result_array();
		if (count($result) != 0) {
			return $result;
		} else {
			return false;
		}
	}

	public function get_cabin_info($cabin_id)
	{
		$this->db->select('cd.*, ct.* ');
		$this->db->from('cabin_details cd');

		$this->db->join('cabin_table ct', 'ct.cabin_details_id = cd.id', 'inner');
		$this->db->where('cd.id', $cabin_id);
		$this->db->limit(1);
		$result = $this->db->get()->result_array();
		if (count($result) != 0) {
			return $result;
		} else {
			return false;
		}
	}

	public function delete_photo_from_cabin($photoPath, $cabin_id)
	{

		// Query to find the record containing the photoPath
		$this->db->like('cabin_photos', $photoPath);
		$result = $this->db->get('cabin_details')->row();

		if ($result) {
			// Remove the photo path from the vessel_photos field
			$updatedPhotos = array_filter(
				explode(';', $result->cabin_photos),
				function ($photo) use ($photoPath) {
					return $photo !== $photoPath;
				}
			);

			$updatedPhotosString = implode(';', $updatedPhotos);

			// Update the record
			$this->db->where('id', $cabin_id);
			$this->db->update('cabin_details', ['cabin_photos' => $updatedPhotosString]);
		}
	}

	public function get_cabin_list($vessel_id = false)
	{

		$this->db->select('ct.id,ct.cabin_price, ct.surcharge_percentage ,cd.cabin_name, cd.cabin_description, ct.cabin_price, cd.cabin_thumbnail, cd.cabin_photos, cd.guest_capacity, cd.bed_number, cd.cabin_thumbnail');
		$this->db->from('cabin_table ct');
		$this->db->join('cabin_details cd', 'cd.id = ct.cabin_details_id', 'inner');
		$this->db->where('ct.vessel_id', $vessel_id);
		$query = $this->db->get();
		$result = $query->result_array();
		if (count($result) === 0) {
			return false; // or you can return an empty array if preferred
		} else {

			return $result;
		}
	}

	public function delete_cabin($cabin_id)
	{
		$this->db->where('id', $cabin_id);
		$result = $this->db->delete('cabin_details');


		$this->db->where('cabin_details_id', $cabin_id);
		$this->db->delete('cabin_table');


		return $result;
	}

	public function fetch_cabin_list($vessel_id)
	{
		if (isset($vessel_id)) {

			$this->db->select('*');
			$this->db->from('cabin_details');
			$this->db->where('vessel_id', $vessel_id);
			$result = $this->db->get()->result_array();
			return $result;
		} else {
			return false;
		}
	}

	public function insert_cabin($params)
	{
		$this->db->insert('cabin_details', $params);
		return $this->db->insert_id();
	}


	// ------------------------------------------------------------------------

}

/* End of file Cabin_model.php */
/* Location: ./application/models/Cabin_model.php */
