<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ParkingIn extends CI_Controller {

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

    public function photo()
    {
        $data['show_navbar'] = false; // Hide navbar for camera view like mockup
        $this->load->view('layout/header', $data);
        $this->load->view('parking_in/photo');
        $this->load->view('layout/footer');
    }

    public function save()
    {
        $post_plate = $this->input->post('plate_number');
        $post_photo = $this->input->post('photo_base64');
        $receipt = 'SP-' . rand(10000, 99999);
        $filename = '';

        // Handle Base64 Image Saving
        if (!empty($post_photo)) {
            // Strip the base64 prefix
            $image_parts = explode(";base64,", $post_photo);
            if (count($image_parts) == 2) {
                $image_base64 = base64_decode($image_parts[1]);
                $filename = $receipt . '.jpg';
                $filepath = FCPATH . 'foto/' . $filename;
                file_put_contents($filepath, $image_base64);
            }
        }
        
        $data_to_save = [
            'receipt_number' => $receipt,
            'plate_number' => $post_plate ? $post_plate : 'AB 1234 CD',
            'time_in' => date('Y-m-d H:i:s'),
            'operator_id' => $this->session->userdata('id'),
            'photo_in' => $filename 
        ];
        
        $this->Parking_model->save_inflow($data_to_save);

        $data['show_navbar'] = true;
        $data['receipt'] = $receipt;
        $data['plate'] = $data_to_save['plate_number'];
        $data['time_in'] = date('H:i:s d M Y', strtotime($data_to_save['time_in']));
        
        // Pass the actual image URL to the view
        $data['photo_src'] = $filename ? base_url('foto/' . $filename) : 'https://placehold.co/60x40/333/fff?text=Car';
        
        $this->load->view('layout/header', $data);
        $this->load->view('parking_in/save', $data);
        $this->load->view('layout/footer');
    }

    public function update_plate()
    {
        $receipt = $this->input->post('receipt');
        $plate = $this->input->post('plate');
        
        if ($receipt && $plate) {
            $this->db->where('receipt_number', $receipt);
            $this->db->update('parking_transactions', ['plate_number' => $plate]);
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No receipt provided.']);
        }
    }

    public function print_ticket($receipt)
    {
        $this->load->model('Admin_model');
        
        $data['trx'] = $this->Parking_model->get_transaction_by_receipt($receipt);
        if (!$data['trx']) {
            show_404();
        }
        
        $data['app_name'] = $this->Admin_model->get_active_header();
        
        $this->load->view('parking_in/print_ticket', $data);
    }
}
