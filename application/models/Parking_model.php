<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Parking_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function save_inflow($data)
    {
        // Insert into database
        $this->db->insert('parking_transactions', $data);
        return $data['receipt_number'];
    }

    public function get_transaction_by_receipt($receipt)
    {
        // Query the database by receipt number
        return $this->db->get_where('parking_transactions', ['receipt_number' => $receipt])->row();
    }

    public function save_outflow($receipt, $data)
    {
        // Update query for outflow
        $this->db->where('receipt_number', $receipt);
        $this->db->update('parking_transactions', $data);
        
        return true;
    }
}
