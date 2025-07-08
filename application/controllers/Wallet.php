<?php
defined('BASEPATH') or exit('No direct script access allowed');


/**
 *
 * Controller Wallet
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

class Wallet extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('Wallet_model');
  }

  public function index()
  {
    // 
    $partner_id = $this->session->userdata('partner_id');
    $this->prepare_invoice();
  }

  public function prepare_invoice()
  {
    $post = $this->input->post();
    //get partner id
    $cutoff_date = $post['date'];
    $partner_id = $this->session->userdata('partner_id');
    $ref_code_list = [];
    $file_name = 'invoice_' . $partner_id . time() . '.pdf';
    $file_path =  'assets/pdf/invoices/' . $partner_id . '/' . $file_name;
    $pdf_directory = base_url($file_path);
    $directory =  'assets/pdf/invoices/' . $partner_id;
    $invoice_number = $this->generate_invoice_nummner();
    $operator_info = $this->Wallet_model->get_operator_info($partner_id);
    if (!is_dir($directory)) {
      if (!mkdir($directory, 0777, true)) {
      }
    }
    $this->data['transaction_array'] = $this->Wallet_model->wallet_breakdown();
    $this->data['invoice_number'] = $invoice_number;
    $this->data['pdf_file_link'] = $pdf_directory;
    $this->data['invoice_details'] = [
      'invoice_nummber' => $invoice_number,
      'date' => date('F j, Y'),
      'operator_name' => $operator_info[0]['partner_name'],
      'operator_country' =>  $operator_info[0]['country'],
      'operator_address' =>  $operator_info[0]['partner_address'],
      'operator_contact' => $operator_info[0]['partner_contact'],

    ];
    $transactions = $this->data['transaction_array']['transactions'];
    // var_dump($this->data['transaction_array']);
    foreach ($transactions as $transaction) {
      $ref_code_list[] = $transaction['ref_code'];
      //update payout status on each ref_code
      $this->Wallet_model->update_payout_status($transaction['ref_code'], $transaction['payout_status']);
    }

    $refcode_list = json_encode($ref_code_list);
    if (count($ref_code_list) > 0) {

      //insert payoutrequest table
      $payout_request_details = [
        'ref_code_list' => $refcode_list,
        'transaction_id' => 0,
        'date' => date('Y-m-d H:i:s'),
        'invoice_number' => $invoice_number,
        'invoice_file_dir' => $pdf_directory,
        'payout_total_amount' => $this->data['transaction_array']['total'],
        'partner_id' => $partner_id,
        'cutoff_date' => $cutoff_date
      ];
      $this->Wallet_model->insert_payout_request($payout_request_details);
      $html = $this->load->view('invoice_template', $this->data, true);
      $invoice_attachment = $this->pdf->upload_pdf($html, $file_path);
    } else {

      echo json_encode(['success' => false, 'message' => 'generation failed']);
    }
    // $this->load->view('invoice_template', $this->data);

    echo json_encode(['success' => true, 'message' => 'generation success ']);
  }

  public function generate_invoice_nummner()
  {

    $partner_id = $this->session->userdata('partner_id');
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

    $random_char = '';
    for ($i = 0; $i < 5; $i++) {
      $random_char .= $characters[rand(0, strlen($characters) - 1)];
    }
    $invoice_number = 'INV-00' . $partner_id . date('Y-m-d') . $random_char;


    return $invoice_number;
  }


  public function wallet_overview()
  {
    //get partner id

    $this->data['transaction_array'] = $this->Wallet_model->wallet_breakdown();
    $this->data['payout_requests'] = $this->Wallet_model->get_payout_list();
    // var_dump($this->data['payout_requests']);
    // var_dump($result);
    $balance = $this->data['transaction_array']['total'];
    $this->data['grand_total'] = $balance;
    $this->data['transactions'] = $this->data['transaction_array']['transactions'];
    $dashboard = $this->load->view('/admin/wallet_page', $this->data);
    return $dashboard;
  }
}


/* End of file Wallet.php */
/* Location: ./application/controllers/Wallet.php */