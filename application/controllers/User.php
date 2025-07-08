<?php
defined('BASEPATH') or exit('No direct script access allowed');


/**
 *
 * Controller User
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

class User extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('User_model');
  }

  public function index()
  {
    // 
  }

  public function login()
  {
    $post = $this->input->post();
    // var_dump($post);
    // Call the model function to verify user credentials
    $user = $this->User_model->verify_user($post['username'], $post['password']);
    if ($user) {
      $session_data = array(
        'username' => $user['username'],
        'id' => $user['id'],
        'email' => $user['email'],
        'role_id' => $user['role_id'],
        'first_name' => $user['first_name'],
        'last_name' => $user['last_name'],
        'partner_id' => $user['partner_id'],
        'logged_in' => TRUE
      );
      $this->session->set_userdata($session_data);
      redirect(base_url('/admin/dashboard'));
    } else {
      $data['error'] = 'Invalid username/email or password';
      $this->load->view('/admin/login_page', $data);
    }
  }

  public function logout()
  {
    // Destroy the session and redirect to login page
    $this->session->sess_destroy();
    $this->load->view('/admin/login_page');
  }
  public function create_user()
  {
    $this->load->model('User_model');

    // Get input data
    $data = array(
      'first_name' => $this->input->post('first_name'),
      'last_name' => $this->input->post('last_name'),
      'email' => $this->input->post('email'),
      'username' => $this->input->post('username'),
      'password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT),
      'role_id' => $this->input->post('role_type')
    );

    // Insert user and check success
    if ($this->User_model->insert_user($data)) {
      echo json_encode(['success' => true, 'message' => 'User created successfully.']);
    } else {
      echo json_encode(['success' => false, 'message' => 'Failed to create user. Please try again.']);
    }
  }

  public function get_all_users()
  {
    $partner_id = $this->session->userdata('partner_id');
    $users = $this->User_model->fetch_all_users($partner_id);
    echo  json_encode($users);
    return json_encode($users);
  }
}


/* End of file User.php */
/* Location: ./application/controllers/User.php */