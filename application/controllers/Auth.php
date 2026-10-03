<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Auth_model');
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->helper('cookie');
    }

    public function index()
    {
        // Redirect if already logged in
        if($this->session->userdata('logged_in')) {
            redirect('dashboard');
        }
        $this->login();
    }

    public function login()
    {
        if ($this->input->post()) {
            $email = $this->input->post('email');
            $password = $this->input->post('password');

            $user = $this->Auth_model->check_login($email, $password);

            if ($user) {
                $session_data = array(
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => isset($user->role) ? $user->role : 'operator',
                    'gate' => isset($user->gate) ? $user->gate : '',
                    'logged_in' => TRUE
                );
                $this->session->set_userdata($session_data);
                
                if ($this->input->post('remember')) {
                    $cookie = array(
                        'name'   => 'remember_me',
                        'value'  => $user->id . ':' . md5($user->email . 'SECRET_SALT'),
                        'expire' => '2592000'
                    );
                    $this->input->set_cookie($cookie);
                }

                redirect('dashboard');
            } else {
                $this->session->set_flashdata('error', 'Invalid Email or Password');
                redirect('auth/login');
            }
        } else {
            // Check for remember me cookie
            $remember = $this->input->cookie('remember_me');
            if ($remember && !$this->session->userdata('logged_in')) {
                $parts = explode(':', $remember);
                if (count($parts) == 2) {
                    $user_id = $parts[0];
                    $token = $parts[1];
                    $this->db->where('id', $user_id);
                    $user = $this->db->get('users')->row();
                    if ($user && md5($user->email . 'SECRET_SALT') === $token) {
                        $session_data = array(
                            'id' => $user->id,
                            'name' => $user->name,
                            'email' => $user->email,
                            'role' => isset($user->role) ? $user->role : 'operator',
                            'gate' => isset($user->gate) ? $user->gate : '',
                            'logged_in' => TRUE
                        );
                        $this->session->set_userdata($session_data);
                        redirect('dashboard');
                    }
                }
            }

            $data['show_navbar'] = false;
            $this->load->view('layout/header', $data);
            $this->load->view('auth/login');
            $this->load->view('layout/footer');
        }
    }

    public function forgot_password()
    {
        if ($this->input->post()) {
            $email = $this->input->post('email');
            $new_password = $this->input->post('new_password');
            
            $this->db->where('email', $email);
            $query = $this->db->get('users');
            if ($query->num_rows() > 0) {
                $this->db->where('email', $email);
                $this->db->update('users', ['password' => md5($new_password)]);
                $this->session->set_flashdata('success', 'Password berhasil direset. Silakan login.');
                redirect('auth/login');
            } else {
                $this->session->set_flashdata('error', 'Email tidak ditemukan.');
                redirect('auth/forgot_password');
            }
        } else {
            $data['show_navbar'] = false;
            $this->load->view('layout/header', $data);
            $this->load->view('auth/forgot');
            $this->load->view('layout/footer');
        }
    }
    public function register()
    {
        if ($this->input->post()) {
            $name = $this->input->post('name');
            $email = $this->input->post('email');
            $password = $this->input->post('password');
            $confirm_password = $this->input->post('confirm_password');
            $gate = $this->input->post('gate');

            if ($password !== $confirm_password) {
                $this->session->set_flashdata('error', 'Password tidak cocok.');
                redirect('auth/register');
            }

            // Check if email already exists
            $this->db->where('email', $email);
            $query = $this->db->get('users');
            if ($query->num_rows() > 0) {
                $this->session->set_flashdata('error', 'Email sudah terdaftar.');
                redirect('auth/register');
            }

            // Insert new user
            $data = [
                'name' => $name,
                'email' => $email,
                'password' => md5($password),
                'role' => 'operator', // Default role
                'gate' => $gate
            ];

            if ($this->db->insert('users', $data)) {
                $this->session->set_flashdata('success', 'Registrasi berhasil. Silakan login.');
                redirect('auth/login');
            } else {
                $this->session->set_flashdata('error', 'Terjadi kesalahan saat registrasi.');
                redirect('auth/register');
            }
        } else {
            $data['show_navbar'] = false;
            $this->load->view('layout/header', $data);
            $this->load->view('auth/register');
            $this->load->view('layout/footer');
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        delete_cookie('remember_me');
        redirect('auth/login');
    }
}
