<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Admin_model');
        $this->load->library('session');
        $this->load->helper('url');
        
        // Set local timezone
        date_default_timezone_set('Asia/Jakarta');
        
        if(!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }

        if($this->session->userdata('role') !== 'admin') {
            $this->session->set_flashdata('error', 'Akses ditolak! Anda bukan Admin.');
            redirect('dashboard');
        }
    }

    // 1. Dashboard Monitoring
    public function index()
    {
        $data['show_navbar'] = true;
        $data['active_menu'] = 'dashboard';
        $data['metrics'] = $this->Admin_model->get_dashboard_metrics();

        $this->load->view('layout/header', $data);
        $this->load->view('admin/dashboard', $data);
        $this->load->view('layout/footer');
    }

    // 2. Master Tarif
    public function tarif()
    {
        $data['show_navbar'] = true;
        $data['active_menu'] = 'tarif';
        $data['tarifs'] = $this->Admin_model->get_all_tarifs();

        $this->load->view('layout/header', $data);
        $this->load->view('admin/tarif', $data);
        $this->load->view('layout/footer');
    }

    public function save_tarif()
    {
        $id = $this->input->post('id');
        $data = [
            'vehicle_type' => $this->input->post('vehicle_type'),
            'mode' => $this->input->post('mode'),
            'flat_fare' => $this->input->post('flat_fare'),
            'hourly_fare' => $this->input->post('hourly_fare')
        ];

        $this->Admin_model->save_tarif($id, $data);
        $this->session->set_flashdata('success', 'Tarif berhasil disimpan!');
        redirect('admin/tarif');
    }

    public function delete_tarif($id)
    {
        $this->Admin_model->delete_tarif($id);
        $this->session->set_flashdata('success', 'Tarif berhasil dihapus!');
        redirect('admin/tarif');
    }

    // 3. List Vehicle
    public function vehicles()
    {
        $search = $this->input->get('search');
        $date = $this->input->get('date');
        $data['show_navbar'] = true;
        $data['active_menu'] = 'vehicles';
        $data['search'] = $search;
        $data['date'] = $date;
        $data['transactions'] = $this->Admin_model->get_all_vehicles($search, $date);

        $this->load->view('layout/header', $data);
        $this->load->view('admin/vehicles', $data);
        $this->load->view('layout/footer');
    }

    public function cancel_vehicle($id)
    {
        $this->Admin_model->cancel_vehicle($id);
        $this->session->set_flashdata('success', 'Kendaraan berhasil dibatalkan (Tidak jadi parkir).');
        redirect('admin/vehicles');
    }

    // 4. Headers
    public function headers()
    {
        $data['show_navbar'] = true;
        $data['active_menu'] = 'headers';
        $data['headers'] = $this->Admin_model->get_all_headers();

        $this->load->view('layout/header', $data);
        $this->load->view('admin/headers', $data);
        $this->load->view('layout/footer');
    }

    public function save_header()
    {
        $id = $this->input->post('id');
        $data = [
            'header_name' => $this->input->post('header_name')
        ];
        
        $this->Admin_model->save_header($id, $data);
        $this->session->set_flashdata('success', 'Header berhasil disimpan!');
        redirect('admin/headers');
    }

    public function delete_header($id)
    {
        $this->Admin_model->delete_header($id);
        $this->session->set_flashdata('success', 'Header berhasil dihapus!');
        redirect('admin/headers');
    }

    public function set_active_header($id)
    {
        $this->Admin_model->set_active_header($id);
        $this->session->set_flashdata('success', 'Header aktif berhasil diubah!');
        redirect('admin/headers');
    }
    // 5. Users Management
    public function users()
    {
        $data['show_navbar'] = true;
        $data['active_menu'] = 'users';
        $data['users'] = $this->Admin_model->get_all_users();

        $this->load->view('layout/header', $data);
        $this->load->view('admin/users', $data);
        $this->load->view('layout/footer');
    }

    public function save_user()
    {
        $id = $this->input->post('id');
        $data = [
            'name' => $this->input->post('name'),
            'email' => $this->input->post('email'),
            'role' => $this->input->post('role')
        ];
        
        $password = $this->input->post('password');
        if (!empty($password)) {
            $data['password'] = md5($password);
        }

        $this->Admin_model->save_user($id, $data);
        $this->session->set_flashdata('success', 'User berhasil disimpan!');
        redirect('admin/users');
    }

    public function delete_user($id)
    {
        $this->Admin_model->delete_user($id);
        $this->session->set_flashdata('success', 'User berhasil dihapus!');
        redirect('admin/users');
    }
}
