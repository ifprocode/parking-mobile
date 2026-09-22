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
        // Query the database
        $this->db->where('email', $email);
        $this->db->where('password', md5($password));
        $query = $this->db->get('users');
        
        if ($query->num_rows() == 1) {
            return $query->row();
        }
        
        return false;
    }
}
