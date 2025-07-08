<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *
 * Model Booking_model
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

class Booking_model extends CI_Model
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

	public function get_all_booking($partner_id, $booking_id = false)
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
		if ($booking_id) {
			$this->db->where('bt.id', $booking_id);
		}
		$this->db->order_by('bt_id', 'DESC');
		$result = $this->db->get()->result_array();
		return $result;
	}

	public function get_partner_id($schedule_id)
	{
		$this->db->select('partner_id');
		$this->db->from('schedules');
		$this->db->where('id', $schedule_id);
		$this->db->limit(1);
		$result = $this->db->get()->result_array();

		return $result;
	}

	public function insert_userinfo($params)
	{
		$this->db->insert('booking_userinfo', $params);
		return $this->db->insert_id();
	}

	public function insert_details($params)
	{
		$this->db->insert('booking_details', $params);
		return $this->db->insert_id();
	}

	public function insert_booking_table($params)
	{
		$this->db->insert('booking_table', $params);
		return $this->db->insert_id();
	}

	public function get_breakdown_by_guest($ref_code)
	{

		$this->db->select('guest_list');
		$this->db->from('booking_userinfo');
		$this->db->where('ref_code', $ref_code);
		$result = $this->db->get()->result_array();
		if (count($result) > 0) {
			return $result;
		} else {
			return false;
		}
	}

	public function get_cabin_table($cabin_id)
	{
		$this->db->select('ct.*, cd.cabin_name');
		$this->db->from('cabin_table ct');
		$this->db->join('cabin_details cd', 'cd.id = ct.cabin_details_id', 'inner');
		$this->db->where('ct.id', $cabin_id);
		$result = $this->db->get()->result_array();
		if (count($result) > 0) {
			return $result;
		} else {
			return false;
		}
	}

	public function update_booking_status($status, $ref_code)
	{
		$update_data = [
			'status' => $status
		];
		$this->db->where('ref_code', $ref_code);
		$this->db->update('booking_table', $update_data);
	}

	public function get_booking_details($ref_code = false)
	{
		if ($ref_code) {
			$this->db->select(
				'
      bd.id as bd_id, 
      bd.ref_code, 
      bd.cabin_id, 
      bd.guest_number, 
      bd.schedule_id, 
      ct.id as ct_id, 
      ct.cabin_details_id, 
      ct.cabin_price, 
      ct.vessel_id, 
      ct.schedule_id as ct_schedule_id, 
      ct.trip_year, 
      ct.partner_id'
			);

			$this->db->from('booking_details bd');
			$this->db->join('cabin_table ct', 'ct.id = bd.cabin_id', 'inner');
			$this->db->where('ref_code', $ref_code);
			$result = $this->db->get()->result_array();
			if (count($result) > 0) {
				return $result;
			} else {
				return false;
			}
		}
	}
	public function get_admin_emails($partner_id)
	{
		$this->db->select('*');
		$this->db->from('user_admin');
		$this->db->where('email_notif', '1');
		$this->db->where('partner_id', $partner_id);
		$result = $this->db->get()->result_array();
		if (count($result) > 0) {
			return $result;
		} else {
			return false;
		}
	}
	public function fetch_booking_summary($ref_code)
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
		$this->db->where('bt.ref_code', $ref_code);
		// $this->db->limit(1, true);

		$result = $this->db->get()->result_array();
		return $result;
	}

	public function get_partner_id_byrefcode($ref_code)
	{
		$this->db->select('partner_id');
		$this->db->from('booking_table');
		$this->db->where('ref_code', $ref_code);
		$this->db->limit(1);
		$result = $this->db->get()->result_array();
		return $result;
	}

	public function check_ref_code($ref_code)
	{
		$this->db->select('count(*) as count');
		$this->db->where('ref_code', $ref_code);
		$this->db->from('booking_table');
		$result = $this->db->get()->result_array();
		if ($result[0]['count'] >= 1) {
			return true;
		}
		return false;
	}

	public function check_ref_code_status($ref_code)
	{
		$this->db->select('status');
		$this->db->where('ref_code', $ref_code);
		$this->db->from('booking_table');
		$this->db->limit(1);
		$result = $this->db->get()->result_array();
		if ($result[0]['status'] == 2) {
			return true;
		}
		return false;
	}

	public function get_commission_percentage($partner_id)
	{
		$this->db->select('*');
		$this->db->from('partners_table pt');
		$this->db->where('pt.id', $partner_id);
		$result = $this->db->get()->result_array();
		if (count($result) <= 0) {
			return false;
		}
		return $result;
	}

	// ------------------------------------------------------------------------

}

/* End of file Booking_model.php */
/* Location: ./application/models/Booking_model.php */
