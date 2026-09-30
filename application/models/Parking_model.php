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

    public function get_user_transaction_count($user_id)
    {
        $today = date('Y-m-d');
        $this->db->where('CONVERT(date, time_in) =', $today);
        $this->db->where('operator_id', $user_id);
        return $this->db->count_all_results('parking_transactions');
    }

    public function get_total_transaction_count()
    {
        $today = date('Y-m-d');
        $this->db->where('CONVERT(date, time_in) =', $today);
        return $this->db->count_all_results('parking_transactions');
    }

    public function get_total_per_vehicle_type_today()
    {
        $today = date('Y-m-d');
        $this->db->select('t.vehicle_type, COUNT(p.id) as total_count');
        $this->db->from('parking_transactions p');
        $this->db->join('tarifs t', 'p.tarif_id = t.id');
        $this->db->where('CONVERT(date, p.time_in) =', $today);
        $this->db->group_by('t.id, t.vehicle_type');
        return $this->db->get()->result();
    }
}
