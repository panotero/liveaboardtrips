<?php
defined('BASEPATH') or exit('No direct script access allowed');


/**
 *
 * Controller Home
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

class Home extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
  }

  public function index()
  {
    $this->data['title'] = 'Home Page';
    $this->data['page'] = 'home_page';
    $this->load->view("template/main_template", $this->data);
  }

  public function get_destinations()
  {
    // Sample multidimensional array for destinations
    $locations = [
      'Philippines' => ['Manila', 'Cebu', 'Palawan', 'Tubbataha'],
      'Japan' => ['Tokyo', 'Osaka', 'Kyoto'],
      'Australia' => ['Sydney', 'Melbourne', 'Brisbane'],
      'United States' => ['New York', 'Los Angeles', 'Chicago'],
      'France' => ['Paris', 'Lyon', 'Marseille']
    ];

    // Return the JSON response
    echo json_encode($locations);
  }
}


/* End of file Home.php */
/* Location: ./application/controllers/Home.php */