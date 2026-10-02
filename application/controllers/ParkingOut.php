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

        // Calculate exact duration
        $time_in_stamp = strtotime($transaction->time_in);
        $time_out_stamp = time();
        $diff_seconds = $time_out_stamp - $time_in_stamp;
        if ($diff_seconds < 0) $diff_seconds = 0;
        
        $days = floor($diff_seconds / 86400);
        $hours = floor(($diff_seconds % 86400) / 3600);
        $minutes = floor(($diff_seconds % 3600) / 60);
        $duration_text = "{$days} Hari {$hours} Jam {$minutes} Menit";
        
        // Save outflow automatically without button
        $this->Parking_model->save_outflow($receipt, [
            'time_out' => date('Y-m-d H:i:s', $time_out_stamp),
            'status' => 'out'
        ]);

        $data['show_navbar'] = true;
        $data['receipt'] = $transaction->receipt_number;
        $data['duration'] = $duration_text;
        $data['total_fare'] = 'Rp ' . number_format($transaction->total_fare, 0, ',', '.');
        $data['photo_in'] = ($transaction && $transaction->photo_in) ? base_url('foto/' . $transaction->photo_in) : 'https://placehold.co/150x100/333/fff?text=No+Photo';

        $this->load->view('layout/header', $data);
        $this->load->view('parking_out/receipt', $data);
        $this->load->view('layout/footer');
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
