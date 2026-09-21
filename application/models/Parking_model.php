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
        // In a real app, this would be an insert query
        // $this->db->insert('parking_transactions', $data);
        // return $this->db->insert_id();

        // Returning a fake receipt number
        return 'SP-' . rand(10000, 99999);
    }

    public function get_transaction_by_receipt($receipt)
    {
        // In a real app, query the database by receipt number
        // return $this->db->get_where('parking_transactions', ['receipt_number' => $receipt])->row();

        // Mock response
        return (object) [
            'receipt_number' => $receipt,
            'plate_number' => 'AB 1234 CD',
            'time_in' => '2023-10-24 12:00:00',
            'photo_in' => 'car1.jpg' // placeholder
        ];
    }

    public function save_outflow($receipt, $data)
    {
        // In a real app, this would be an update query
        // $this->db->where('receipt_number', $receipt);
        // $this->db->update('parking_transactions', $data);

        return true;
    }
}
