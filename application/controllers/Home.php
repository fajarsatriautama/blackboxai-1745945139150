<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $data['title'] = 'Rapor Tahfizh';
        $data['description'] = 'Sistem Informasi Rapor Tahfizh';
        
        // Load views
        $this->load->view('templates/header', $data);
        $this->load->view('home/index', $data);
        $this->load->view('templates/footer');
    }

    public function login() {
        if($this->session->userdata('logged_in')) {
            redirect('dashboard');
        }
        
        $data['title'] = 'Login - Rapor Tahfizh';
        
        // Load views
        $this->load->view('templates/header', $data);
        $this->load->view('auth/login');
        $this->load->view('templates/footer');
    }
}
