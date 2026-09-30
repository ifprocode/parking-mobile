<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        
        // Ensure user is logged in
        if(!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
    }

    public function index()
    {
        $this->load->model('Parking_model');
        
        $data['show_navbar'] = true;
        $data['user_name'] = $this->session->userdata('name');
        
        $user_id = $this->session->userdata('id');
        
        $data['user_trx'] = $this->Parking_model->get_user_transaction_count($user_id);
        $data['total_trx'] = $this->Parking_model->get_total_transaction_count();
        $data['vehicle_types_today'] = $this->Parking_model->get_total_per_vehicle_type_today();
        
        $data['role'] = $this->session->userdata('role');
        
        if ($data['role'] === 'admin') {
            $this->load->model('Admin_model');
            $data['overall_metrics'] = $this->Admin_model->get_overall_metrics();
            $data['income_per_user'] = $this->Admin_model->get_income_per_user();
            $data['vehicle_types'] = $this->Admin_model->get_total_per_vehicle_type();
        }
        
        $this->load->view('layout/header', $data);
        $this->load->view('dashboard/index', $data);
        $this->load->view('layout/footer');
    }
}
