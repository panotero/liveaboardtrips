<?php
defined('BASEPATH') or exit('No direct script access allowed');


/**
 *
 * Controller Aboutus
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

class Aboutus extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
  }

  public function index()
  {
    $this->data['title'] = 'About Us Page';
    $this->data['page'] = 'about_us';
    $this->load->view("template/main_template", $this->data);
  }
}


/* End of file Aboutus.php */
/* Location: ./application/controllers/Aboutus.php */