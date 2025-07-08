<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *
 * Model User_model
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

class User_model extends CI_Model
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

  public function verify_user($username_or_email, $password)
  {
    // Check for the user by username or email
    $this->db->select('*');
    $this->db->where('username', $username_or_email);
    $this->db->or_where('email', $username_or_email);
    $query = $this->db->get('user_admin');

    if ($query->num_rows() > 0) {
      $user = $query->row_array();

      // Verify the password using bcrypt
      if (password_verify($password, $user['password'])) {
        return $user; // Valid user
      }
    }
    return false; // Invalid user
  }

  public function insert_user($data)
  {
    $this->db->insert('user_admin', $data);
    return true;
  }

  public function fetch_all_users($partner_id)
  {
    $this->db->select('ua.*, srt.role_type ');
    $this->db->from('user_admin as ua');
    $this->db->join('settings_role_type as srt', 'ua.role_id = srt.id', 'left');
    if ($partner_id != '0') {
      $this->db->where('ua.partner_id', $partner_id);
    }
    $query = $this->db->get();
    return $query->result_array();
  }

  public function get_user_admin_info($useradmin_id)
  {

    $this->db->where('username', $username_or_email);
    $query = $this->db->get('user_admin');
  }

  public function disable_user($user_id)
  {
    $this->db->where('id', $user_id);
    $this->db->update('user_admin', ['status' => 1]);
    return true;
  }
  public function enable_user($user_id)
  {
    $this->db->where('id', $user_id);
    $this->db->update('user_admin', ['status' => 0]);
    return true;
  }
  // ------------------------------------------------------------------------

}

/* End of file User_model.php */
/* Location: ./application/models/User_model.php */