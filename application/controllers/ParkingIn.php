<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ParkingIn extends CI_Controller {

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

    public function photo()
    {
        $data['show_navbar'] = false; // Hide navbar for camera view like mockup
        $this->load->view('layout/header', $data);
        $this->load->view('parking_in/photo');
        $this->load->view('layout/footer');
    }

    public function save()
    {
        // Mock processing the incoming parking
        $data_to_save = [
            'plate_number' => 'AB 1234 CD',
            'time_in' => date('Y-m-d H:i:s'),
            'operator_id' => $this->session->userdata('id')
        ];
        
        $receipt = $this->Parking_model->save_inflow($data_to_save);

        $data['show_navbar'] = true;
        $data['receipt'] = $receipt;
        $data['plate'] = $data_to_save['plate_number'];
        $data['time_in'] = date('H:i:s d M Y', strtotime($data_to_save['time_in']));
        
        $this->load->view('layout/header', $data);
        $this->load->view('parking_in/save', $data);
        $this->load->view('layout/footer');
    }
}
