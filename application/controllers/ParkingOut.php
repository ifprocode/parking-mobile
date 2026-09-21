<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ParkingOut extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Parking_model');
        $this->load->library('session');
        $this->load->helper('url');
        
        if(!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
    }

    public function scan()
    {
        $data['show_navbar'] = false;
        $this->load->view('layout/header', $data);
        $this->load->view('parking_out/scan');
        $this->load->view('layout/footer');
    }

    public function confirm()
    {
        // Mock getting transaction by receipt
        $receipt = $this->input->post('receipt') ?? 'SP-12345';
        $transaction = $this->Parking_model->get_transaction_by_receipt($receipt);

        $data['show_navbar'] = true;
        $data['receipt'] = $transaction->receipt_number;
        $data['plate'] = $transaction->plate_number;
        $data['time_in'] = date('H:i:s d M Y', strtotime($transaction->time_in));
        $data['time_out'] = date('H:i:s d M Y'); // current time for mock
        
        $this->load->view('layout/header', $data);
        $this->load->view('parking_out/confirm', $data);
        $this->load->view('layout/footer');
    }

    public function receipt()
    {
        // Mock fare calculation
        $time_in_str = $this->input->post('time_in');
        $time_out_str = $this->input->post('time_out');
        
        // Mock saving outflow
        $receipt = $this->input->post('receipt') ?? 'SP-12345';
        $this->Parking_model->save_outflow($receipt, ['time_out' => date('Y-m-d H:i:s')]);

        $data['show_navbar'] = true;
        $data['receipt'] = $receipt;
        $data['duration'] = '15 Menit'; // Hardcoded mock
        $data['total_fare'] = 'Rp 15.000'; // Hardcoded mock

        $this->load->view('layout/header', $data);
        $this->load->view('parking_out/receipt', $data);
        $this->load->view('layout/footer');
    }
}
