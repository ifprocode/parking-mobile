<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    // Dashboard Metrics
    public function get_dashboard_metrics()
    {
        $today = date('Y-m-d');
        
        // Total In Today
        $this->db->where('DATE(time_in) =', $today);
        $this->db->where("(status != 'cancelled' OR status IS NULL)", null, false);
        $total_in = $this->db->count_all_results('parking_transactions');

        // Total Out Today
        $this->db->where('DATE(time_out) =', $today);
        $this->db->where("(status != 'cancelled' OR status IS NULL)", null, false);
        $total_out = $this->db->count_all_results('parking_transactions');

        // Total Currently Inside
        $this->db->where('time_out IS NULL', null, false);
        $this->db->where("(status != 'cancelled' OR status IS NULL)", null, false);
        $total_inside = $this->db->count_all_results('parking_transactions');

        // Total Income Today
        $this->db->select_sum('total_fare');
        $this->db->where('DATE(time_out) =', $today);
        $this->db->where("(status != 'cancelled' OR status IS NULL)", null, false);
        $query = $this->db->get('parking_transactions');
        $income_row = $query->row();
        $total_income = $income_row->total_fare ? $income_row->total_fare : 0;

        // Total Cancelled Today
        $this->db->where('DATE(time_in) =', $today);
        $this->db->where('status', 'cancelled');
        $total_cancelled = $this->db->count_all_results('parking_transactions');

        return [
            'total_in' => $total_in,
            'total_out' => $total_out,
            'total_inside' => $total_inside,
            'total_income' => $total_income,
            'total_cancelled' => $total_cancelled
        ];
    }

    public function get_overall_metrics()
    {
        $this->db->select_sum('total_fare');
        $this->db->where("(status != 'cancelled' OR status IS NULL)", null, false);
        $query = $this->db->get('parking_transactions');
        $total_income = $query->row()->total_fare ? $query->row()->total_fare : 0;

        $this->db->where("(status != 'cancelled' OR status IS NULL)", null, false);
        $total_in = $this->db->count_all_results('parking_transactions');

        $this->db->where('time_out IS NOT NULL', null, false);
        $this->db->where("(status != 'cancelled' OR status IS NULL)", null, false);
        $total_out = $this->db->count_all_results('parking_transactions');

        $this->db->where('time_out IS NULL', null, false);
        $this->db->where("(status != 'cancelled' OR status IS NULL)", null, false);
        $total_inside = $this->db->count_all_results('parking_transactions');

        return [
            'total_income' => $total_income,
            'total_in' => $total_in,
            'total_out' => $total_out,
            'total_inside' => $total_inside
        ];
    }

    public function get_income_per_user()
    {
        $this->db->select('u.name, SUM(p.total_fare) as total_income');
        $this->db->from('parking_transactions p');
        $this->db->join('users u', 'p.operator_id = u.id');
        $this->db->where("(p.status != 'cancelled' OR p.status IS NULL)", null, false);
        $this->db->group_by('u.id, u.name');
        return $this->db->get()->result();
    }

    public function get_total_per_vehicle_type()
    {
        $this->db->select('t.vehicle_type, COUNT(p.id) as total_count');
        $this->db->from('parking_transactions p');
        $this->db->join('tarifs t', 'p.tarif_id = t.id');
        $this->db->where("(p.status != 'cancelled' OR p.status IS NULL)", null, false);
        $this->db->group_by('t.id, t.vehicle_type');
        return $this->db->get()->result();
    }

    // Tarifs
    public function get_all_tarifs()
    {
        return $this->db->get('tarifs')->result();
    }

    public function save_tarif($id, $data)
    {
        if ($id) {
            $data['updated_at'] = date('Y-m-d H:i:s');
            $this->db->where('id', $id);
            return $this->db->update('tarifs', $data);
        } else {
            return $this->db->insert('tarifs', $data);
        }
    }

    public function delete_tarif($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('tarifs');
    }

    // App Headers
    public function get_all_headers()
    {
        $this->db->order_by('id', 'ASC');
        return $this->db->get('app_headers')->result();
    }

    public function get_active_header()
    {
        $query = $this->db->get_where('app_headers', ['is_active' => 1]);
        if ($query->num_rows() > 0) {
            return $query->row()->header_name;
        }
        return 'Parking Mobile'; // fallback
    }

    public function save_header($id, $data)
    {
        if ($id) {
            $this->db->where('id', $id);
            $this->db->update('app_headers', $data);
        } else {
            // If it's the first one, make it active
            if ($this->db->count_all_results('app_headers') == 0) {
                $data['is_active'] = 1;
            }
            $this->db->insert('app_headers', $data);
        }
    }

    public function delete_header($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('app_headers');
    }

    public function set_active_header($id)
    {
        // Set all to 0
        $this->db->update('app_headers', ['is_active' => 0]);
        // Set selected to 1
        $this->db->where('id', $id);
        $this->db->update('app_headers', ['is_active' => 1]);
    }

    // Vehicles
    public function get_all_vehicles($search = null, $date = null)
    {
        if ($search) {
            $this->db->group_start();
            $this->db->like('receipt_number', $search);
            $this->db->or_like('plate_number', $search);
            $this->db->group_end();
        }
        if ($date) {
            $this->db->where('DATE(time_in) =', $date);
        }
        $this->db->order_by('time_in', 'DESC');
        return $this->db->get('parking_transactions')->result();
    }

    public function cancel_vehicle($id)
    {
        $data = [
            'status' => 'cancelled',
            'time_out' => date('Y-m-d H:i:s'),
            'total_fare' => 0
        ];
        $this->db->where('id', $id);
        return $this->db->update('parking_transactions', $data);
    }
    // Users
    public function get_all_users()
    {
        return $this->db->get('users')->result();
    }

    public function save_user($id, $data)
    {
        if ($id) {
            $this->db->where('id', $id);
            return $this->db->update('users', $data);
        } else {
            return $this->db->insert('users', $data);
        }
    }

    public function delete_user($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('users');
    }
}
