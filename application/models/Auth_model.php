<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        // Load database connection just in case
        $this->load->database();
    }

    public function check_login($email, $password)
    {
        // Placeholder logic: in real app, query database
        // For demonstration purposes based on the mock, we assume success
        // return $this->db->get_where('users', ['email' => $email, 'password' => md5($password)])->row();

        if ($email == 'admin@smartpark.com' && $password == 'admin') {
            return (object) [
                'id' => 1,
                'name' => 'Andi',
                'email' => $email
            ];
        }

        return false;
    }
}
