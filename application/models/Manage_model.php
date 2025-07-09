<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *
 * Model Manage_model
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

class Manage_model extends CI_Model
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

	// ------------------------------------------------------------------------
	// Fetch all schedules
	public function get_all_schedules($partner_id)
	{
		$this->db->where('partner_id', $partner_id);
		$query = $this->db->get('schedules');
		return $query->result();
	}
	public function get_all_schedules_bydate($month, $year, $partner_id)
	{
		// Add a WHERE clause to filter by month and year of the 'schedule_from' column
		$this->db->where('MONTH(schedule_from)', $month);
		$this->db->where('YEAR(schedule_from)', $year);
		$this->db->where('partner_id', $partner_id);

		// Execute the query to fetch the filtered schedules
		$query = $this->db->get('schedules');

		// Return the result as an array of objects
		return $query->result();
	}

	// Insert a new schedule
	public function insert_schedule($data)
	{
		return $this->db->insert('schedules', $data);
	}
	public function get_all_cabin($partner_id)
	{
		$this->db->select('ct.*, cd.cabin_name, cd.cabin_description, vt.vessel_name');
		$this->db->where('ct.partner_id', $partner_id);
		$this->db->join('vessel_table as vt', 'vt.id = ct.vessel_id', 'left');
		$this->db->join('cabin_details as cd', 'cd.id = ct.cabin_details_id', 'left');
		$this->db->from('cabin_table as ct');
		$query = $this->db->get();
		return $query->result();
	}
	// Insert a new schedule
	public function insert_cabin($data)
	{
		return $this->db->insert('cabin_table', $data);
	}

	// Update a schedule by ID
	public function update_schedule($id, $data)
	{
		$this->db->where('id', $id);
		return $this->db->update('schedules', $data);
	}

	// Delete a schedule by ID
	public function cancel_schedule($id)
	{

		$this->db->set('status', 1);
		$this->db->where('id', $id);
		return $this->db->update('schedules');
	}
	// Delete a schedule by ID
	public function delete_cabin($id)
	{
		$this->db->where('id', $id);
		return $this->db->delete('cabin_table');
	}
	public function delete_cabin_price($id)
	{
		$this->db->where('id', $id);
		return $this->db->delete('cabin_table');
	}
	// Function to get all vessels from the vessel_table
	public function get_all_vessels()
	{
		$query = $this->db->get('vessel_table');
		return $query->result_array();
	}

	public function fetch_settings_roles()
	{
		$this->db->select('*');
		$this->db->from('settings_role_type');
		if ($this->session->userdata('role_id') != '1') {
			$this->db->where('id !=', '1');
		}
		$query = $this->db->get();
		return $query->result_array();
	}
	public function fetch_partners()
	{
		$this->db->select('*');
		$this->db->from('partners_table');
		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_booking_counts($range = 'weekly')
	{
		$counts = [];

		if ($range == 'weekly') {
			// Last 7 days
			for ($i = 6; $i >= 0; $i--) {
				$date = date('Y-m-d', strtotime("-$i days"));
				$this->db->where("DATE(booking_date)", $date);
				$counts[] = $this->db->count_all_results('booking_table');
			}
		} elseif ($range == 'monthly') {
			// January to December of current year
			$year = date('Y');
			for ($month = 1; $month <= 12; $month++) {
				$month_str = str_pad($month, 2, '0', STR_PAD_LEFT);
				$year_month = "$year-$month_str";

				$this->db->from('booking_table');
				$this->db->where("DATE_FORMAT(booking_date, '%Y-%m') = '$year_month'", null, false);
				$counts[] = $this->db->count_all_results();
			}
		} elseif ($range == 'yearly') {
			// Last 7 years
			for ($i = 6; $i >= 0; $i--) {
				$year = date('Y', strtotime("-$i years"));
				$this->db->where("YEAR(booking_date)", $year);
				$counts[] = $this->db->count_all_results('booking_table');
			}
		}

		return $counts;
	}

	public function get_recent_booking($partner_id)
	{

		$this->db->select('
    bt.id AS bt_id,
    bt.ref_code AS bt_ref_code,
    bt.user_id AS bt_user_id,
    bt.booking_details_id AS bt_booking_details_id,
    bt.trip_year AS bt_trip_year,
    sbs.status AS sbs_status,
    bt.booking_date AS bt_booking_date,
    bt.schedule_id AS bt_schedule_id,
    bt.partner_id AS bt_partner_id,
    bui.id AS bui_id,
    bui.ref_code AS bui_ref_code,
    bui.first_name AS bui_first_name,
    bui.last_name AS bui_last_name,
    bui.address_1 AS bui_address_1,
    bui.address_2 AS bui_address_2,
    bui.country AS bui_country,
    bui.city AS bui_city,
    bui.mobile AS bui_mobile,
    bui.email AS bui_email,
    bui.phone AS bui_phone,
    bui.guest_list AS bui_guest_list,
    s.id AS s_id,
    s.schedule_title AS s_schedule_title,
    s.schedule_from AS s_schedule_from,
    s.schedule_to AS s_schedule_to,
    s.vessel_id AS s_vessel_id,
    s.itinerary AS s_itinerary,
    s.destination_id AS s_destination_id,
    s.partner_id AS s_partner_id,
    dt.id AS dt_id,
    dt.destination_name AS dt_destination_name,
    dt.destination_country AS dt_destination_country,
    dt.destination_popularity_points AS dt_destination_popularity_points,
    dt.vessel_id_list AS dt_vessel_id_list,
    dt.partner_id AS dt_partner_id,
    dt.destination_photos AS dt_destination_photos,
    dt.destination_thumbnail AS dt_destination_thumbnail,
    dt.description AS dt_description
');
		$this->db->from('booking_table AS bt');
		$this->db->join('booking_userinfo AS bui', 'bui.ref_code = bt.ref_code AND bui.id = bt.user_id');
		$this->db->join('schedules AS s', 's.id = bt.schedule_id');
		$this->db->join('destination_table AS dt', 'dt.id = s.destination_id');
		$this->db->join('settings_booking_status AS sbs', 'sbs.id = bt.status');
		$this->db->where('bt.partner_id', $partner_id);
		$this->db->order_by('bt_id', 'DESC');
		$this->db->limit(5);
		$result = $this->db->get()->result_array();
		return $result;
	}

	public function get_admin_info($partner_id)
	{
		$this->db->select('
    (SELECT COUNT(*) FROM booking_table WHERE partner_id = ' . $partner_id . ') AS booking_count,
    (SELECT COUNT(*) FROM vessel_table WHERE partner_id = ' . $partner_id . ') AS active_vessel_count,
    (SELECT COUNT(*) FROM schedules WHERE partner_id = ' . $partner_id . ' AND status = 0 AND schedule_to >= CURRENT_DATE) AS active_schedule_count
');
		$result = $this->db->get()->result_array();
		return $result;
	}

	public function check_schedule_status($partner_id)
	{
		$this->db->set('status', 1);
		$this->db->where('partner_id', $partner_id);
		$this->db->update('schedules');
	}
}

/* End of file Manage_model.php */
/* Location: ./application/models/Manage_model.php */
