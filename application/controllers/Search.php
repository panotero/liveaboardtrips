<?php
defined('BASEPATH') or exit('No direct script access allowed');


/**
 *
 * Controller Search
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

class Search extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('Search_model');
  }

  public function index()
  {
    $post = $this->input->post();
    $get = $this->input->get();
    $this->data['title'] = 'Search';
    $this->data['page'] = 'search_result_page';
    $this->data['post'] = $post;
    $this->data['available_vessel'] = [];
    $search_data = [
      'destination' =>  $_GET['destination'],
      'month' => $_GET['month'],
      'year' =>  $_GET['year'],
    ];

    $sched_result = $this->Search_model->search($search_data);

    // var_dump($sched_result);
    if ($sched_result) {
      $photos = explode(';', $sched_result[0]['vessel_photos']); //fordissecting of value separated by ';'
      $photos = array_map('trim', $photos); //for cleaning whitespaces

      foreach ($sched_result as $vessel) {
        //fetch the pricing here
        $cabin_price = $this->Search_model->get_cabin_prices($vessel['vesselid'], $search_data);

        // var_dump($cabin_price);
        $available_trips = [];
        foreach ($cabin_price as $cabin) {
          $available_trips[$cabin['id']] = [
            'destination_name' => $cabin['destination_name'],
            'destination_country' => $cabin['destination_country'],
            'schedule_from' => $cabin['schedule_from'],
            'schedule_to' => $cabin['schedule_to'],
            'trip_schedule' =>  $cabin['schedule_from'] . ' to ' . $cabin['schedule_to'],
            'price_start' => $cabin['cabin_price']
          ];
        }
        $this->data['available_vessel'][$vessel['id']] = [
          'vessel_id' => $vessel['vesselid'],
          'vessel_name' => $vessel['vessel_name'],
          'vessel_description' => $vessel['description'],
          'vessel_photos' => $photos,
          'features' => ['nitrox', 'wifi'],
          'available_trips' => $available_trips

        ];
      }

      // var_dump($this->data['available_vessel']);
      $this->load->view("template/main_template", $this->data);
    } else {

      $this->session->set_flashdata('error', 'No vessel found!');
      redirect(base_url());
    }
  }
}


/* End of file Search.php */
/* Location: ./application/controllers/Search.php */