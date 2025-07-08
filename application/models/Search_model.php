<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *
 * Model Search_model
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

class Search_model extends CI_Model
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

  public function search($params = false)
  {
    $destination = $params['destination']; // Example destination
    $month = $params['month'];          // Example month
    $year = $params['year'];                // Example year

    $this->db->select('st.id,vt.id as "vesselid", dt.destination_name, dt.destination_country, vt.vessel_name, vt.description, vt.vessel_photos, st.schedule_from, YEAR(st.schedule_from) as schedule_year, MONTHNAME(st.schedule_from) as schedule_month');
    $this->db->from('schedules st');
    $this->db->join('vessel_table vt', 'vt.id = st.vessel_id');
    $this->db->join('destination_table dt', 'dt.id = st.destination_id');

    // Group the OR conditions for destination checks
    $this->db->group_start();
    $this->db->like('dt.destination_country', $destination);
    $this->db->or_like('dt.destination_name', $destination);
    $this->db->group_end();

    // Add the month and year conditions
    $this->db->where('MONTHNAME(st.schedule_from)', $month);
    $this->db->where('YEAR(st.schedule_from)', $year);

    // Group by vessel id
    $this->db->group_by('vt.id');



    $query = $this->db->get();
    $result = $query->result_array();
    if (count($result) === 0) {
      return false; // or you can return an empty array if preferred
    } else {

      return $result;
    }
  }

  public function get_cabin_prices($vessel_id = false, $search_data = false)
  {
    $this->db->select('st.id, st.schedule_from, st.schedule_to, ct.cabin_price, dt.destination_name, dt.destination_country');
    $this->db->from('schedules st');

    // Manually adding the subquery for the join
    $this->db->join('(SELECT vessel_id, MIN(cabin_price) AS max_price FROM cabin_table GROUP BY vessel_id) ct_max', 'ct_max.vessel_id = st.vessel_id', 'inner');
    $this->db->join('cabin_table ct', 'ct.vessel_id = st.vessel_id AND ct.cabin_price = ct_max.max_price', 'inner');
    $this->db->join('destination_table dt', 'dt.id = st.destination_id', 'inner');

    // Adding conditions
    $this->db->where('st.vessel_id', $vessel_id);
    $this->db->where('MONTHNAME(st.schedule_from)', $search_data['month']);
    $this->db->where('YEAR(st.schedule_from)', $search_data['year']);

    // Grouping and limiting results
    $this->db->group_by('st.id');
    $this->db->limit(5);

    $query = $this->db->get();
    $result = $query->result_array();
    if (count($result) === 0) {
      return false; // or you can return an empty array if preferred
    } else {

      return $result;
    }
  }



  // ------------------------------------------------------------------------

}

/* End of file Search_model.php */
/* Location: ./application/models/Search_model.php */