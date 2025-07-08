<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *
 * Model Wallet_model
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

class Wallet_model extends CI_Model
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

  public function get_total($partner_id)
  {
    $this->db->select('*');
    $this->db->from('transaction_table tt');
    $this->db->join('booking_table bt', 'bt.ref_code = tt.ref_code');
    $this->db->join('schedules st', 'st.id = bt.schedule_id');
    $this->db->where('bt.partner_id', $partner_id);
    $this->db->where('tt.status', '1');
    $this->db->where_in('tt.payout_status', ['0', '1']);

    //get total transactions
    $result = $this->db->get()->result_array();


    $this->db->select('partial_payment_percentage');
    $this->db->from('partners_table');
    $this->db->where('id', $partner_id);

    //get partial_payment_percentage
    $partial_percentage = $this->db->get()->result_array();


    if (count($result) <= 0) {
      $result = null;
    }
    $result_array = [
      'result' => $result,
      'partial_payment_percentage'  =>  $partial_percentage,
    ];

    return $result_array;
  }

  public function wallet_breakdown()
  {
    $partner_id = $this->session->userdata('partner_id');
    $total = $this->Wallet_model->get_total($partner_id);
    // Fetch transactions from the model
    $transactions = $total['result'];

    // Fetch partial payment percentage from the model
    $partial_payment_percentage = $total['partial_payment_percentage'];
    if ($partial_payment_percentage) {

      $percentage = $partial_payment_percentage[0]['partial_payment_percentage'] / 100;
    }
    $today = new DateTime();
    $total = 0;
    $processed_transactions = [];
    if ($transactions) {

      foreach ($transactions as $transaction) {
        $schedule_from = new DateTime($transaction['schedule_from']);
        $maturity = $today->diff($schedule_from)->days;
        $transaction_total = 0;
        $commission = 0;
        $subtotal = 0;

        //payout status
        //0 - New | 1 - Initial Payment | 2 - Full Payment
        $payout_status = 0;

        if ($maturity <= 90) {
          if ($transaction['initialpayment_status'] == 1) {
            // Compute the total partial payment
            $partial_payment_total = ($transaction['amount'] * $percentage);
            $commission = $transaction['commission'] - ($transaction['commission'] * $percentage);
            $transaction_total = $transaction['amount'] - $partial_payment_total;
            $subtotal = $transaction_total - $commission;
          } else {
            // Compute the total partial payment
            $commission = $transaction['commission'];
            $transaction_total = $transaction['amount'];
            $subtotal = $transaction_total - $commission;
          }

          $payout_status = 2;
        } else {
          if ($transaction['initialpayment_status'] == 1) {
            continue;
          }

          // Compute the total payment
          $commission = $transaction['commission'] * $percentage;
          $transaction_total = $transaction['amount'] * $percentage;
          $subtotal = $transaction_total - $commission;
          $payout_status = 1;
        }

        $total += $subtotal;

        // Add processed data to array
        $processed_transactions[] = [
          'ref_code' => $transaction['ref_code'],
          'transaction_total' => $transaction_total,
          'commission' => $commission,
          'subtotal' => $subtotal,
          'payout_status' => $payout_status
        ];
      }
    }

    // Pass data to view
    $ressult_array  = [
      'transactions' => $processed_transactions,
      'total' => $total
    ];

    return $ressult_array;
  }


  //insert payout approval table
  public function insert_payout_request($params = false)
  {
    $this->db->insert('payout_table', $params);
  }

  //update payout status from transaction table.
  public function update_payout_status($ref_code, $status)
  {
    $update_array = [
      'payout_status' => $status,
      'initialpayment_status' => $status
    ];
    $this->db->where('ref_code', $ref_code);
    $this->db->update('transaction_table', $update_array);
  }

  public function get_operator_info($partner_id)
  {
    $this->db->select('*');
    $this->db->from('partners_table');
    $this->db->where('id', $partner_id);

    $result = $this->db->get()->result_array();
    if (count($result) <= 0) {
      return false;
    }
    return $result;
  }

  public function get_payout_list()
  {

    $partner_id = $this->session->userdata('partner_id');
    $this->db->select('*');
    $this->db->from('payout_table');
    $this->db->where('partner_id', $partner_id);
    $result = $this->db->get()->result_array();
    if (count($result) <= 0) {
      return false;
    }
    return $result;
  }


  // ------------------------------------------------------------------------

}

/* End of file Wallet_model.php */
/* Location: ./application/models/Wallet_model.php */