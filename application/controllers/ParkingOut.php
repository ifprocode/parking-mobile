<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ParkingOut extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Parking_model');
        $this->load->library('session');
        $this->load->helper('url');
        
        // Set local timezone
        date_default_timezone_set('Asia/Jakarta');
        
        if(!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
    }

    public function scan()
    {
        $data['show_navbar'] = false;
        $this->load->view('layout/header', $data);
        $this->load->view('parking_out/scan', $data);
        $this->load->view('layout/footer');
    }

    public function confirm()
    {
        $receipt = $this->input->post('receipt') ?? '';
        $transaction = $this->Parking_model->get_transaction_by_receipt($receipt);

        // Validation: Transaction not found
        if (!$transaction) {
            $this->session->set_flashdata('error', 'Resi tidak ditemukan!');
            redirect('parkingout/scan');
        }

        // Validation: Already scanned out
        if ($transaction->time_out != NULL) {
            $this->session->set_flashdata('error', 'Kendaraan ini sudah diproses keluar sebelumnya!');
            redirect('parkingout/scan');
        }

        $data['show_navbar'] = true;
        $data['receipt'] = $transaction->receipt_number;
        $data['plate'] = $transaction ? $transaction->plate_number : 'NOT FOUND';
        $data['time_in'] = $transaction ? date('H:i:s d M Y', strtotime($transaction->time_in)) : date('H:i:s d M Y');
        $data['time_out'] = date('H:i:s d M Y'); // current time
        $data['photo_in'] = ($transaction && $transaction->photo_in) ? base_url('foto/' . $transaction->photo_in) : 'https://placehold.co/150x100/333/fff?text=No+Photo';
        
        $this->load->view('layout/header', $data);
        $this->load->view('parking_out/confirm', $data);
        $this->load->view('layout/footer');
    }

    public function receipt()
    {
        $receipt = $this->input->post('receipt');
        $time_out_str = $this->input->post('time_out');
        
        $transaction = $this->Parking_model->get_transaction_by_receipt($receipt);
        
        $time_in = strtotime($transaction->time_in);
        // Convert submitted time string back to timestamp (format: H:i:s d M Y)
        $time_out = strtotime($time_out_str); 
        
        $diff_seconds = $time_out - $time_in;
        if ($diff_seconds < 0) $diff_seconds = 0;
        
        $days = floor($diff_seconds / 86400);
        $hours = floor(($diff_seconds % 86400) / 3600);
        $minutes = floor(($diff_seconds % 3600) / 60);
        
        $duration_text = "{$days} Hari {$hours} Jam {$minutes} Menit";
        
        // Save outflow
        $this->Parking_model->save_outflow($receipt, [
            'time_out' => date('Y-m-d H:i:s', $time_out),
            'status' => 'out'
        ]);

        $data['show_navbar'] = true;
        $data['receipt'] = $receipt;
        $data['duration'] = $duration_text;
        $data['total_fare'] = 'Rp ' . number_format($transaction->total_fare, 0, ',', '.');
        $data['photo_in'] = $transaction->photo_in ? base_url('foto/' . $transaction->photo_in) : 'https://placehold.co/150x100/333/fff?text=Car+In';

        $this->load->view('layout/header', $data);
        $this->load->view('parking_out/receipt', $data);
        $this->load->view('layout/footer');
    }

    public function print_receipt($receipt)
    {
        $this->load->model('Admin_model');
        
        $data['trx'] = $this->Parking_model->get_transaction_by_receipt($receipt);
        if (!$data['trx']) {
            show_404();
        }
        
        $data['app_name'] = $this->Admin_model->get_active_header();
        
        // Calculate exact duration
        $diff = strtotime($data['trx']->time_out) - strtotime($data['trx']->time_in);
        if ($diff < 0) $diff = 0;
        
        $days = floor($diff / 86400);
        $hours = floor(($diff % 86400) / 3600);
        $minutes = floor(($diff % 3600) / 60);
        
        $data['duration_exact'] = "{$days} Hari {$hours} Jam {$minutes} Menit";
        
        $this->load->view('parking_out/print_receipt', $data);
    }

    public function mark_paid()
    {
        $receipt = $this->input->post('receipt');
        if ($receipt) {
            $this->db->where('receipt_number', $receipt);
            $this->db->update('parking_transactions', ['status' => 'paid']);
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No receipt provided.']);
        }
    }
}
