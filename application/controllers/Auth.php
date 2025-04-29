<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('auth_model');
    }

    public function login($role = '') {
        if($this->session->userdata('logged_in')) {
            redirect('dashboard');
        }

        // Validate role
        if (!in_array($role, ['admin', 'instruktur', 'siswa'])) {
            redirect('home');
        }

        $data['title'] = 'Login ' . ucfirst($role);
        $data['role'] = $role;

        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('auth/login', $data);
            $this->load->view('templates/footer');
        } else {
            $this->_login();
        }
    }

    private function _login() {
        $username = $this->input->post('username', true);
        $password = $this->input->post('password', true);
        $role = $this->input->post('role', true);

        $user = $this->auth_model->get_user_by_username($username);

        // User exists
        if($user) {
            // Check password
            if(password_verify($password, $user['password'])) {
                // Check role
                if($user['peran'] == $role) {
                    $data = [
                        'user_id' => $user['id'],
                        'username' => $user['username'],
                        'nama_lengkap' => $user['nama_lengkap'],
                        'peran' => $user['peran'],
                        'logged_in' => TRUE
                    ];
                    $this->session->set_userdata($data);

                    // Redirect based on role
                    switch($role) {
                        case 'admin':
                            redirect('admin/dashboard');
                            break;
                        case 'instruktur':
                            redirect('instruktur/dashboard');
                            break;
                        case 'siswa':
                            redirect('siswa/dashboard');
                            break;
                        default:
                            redirect('home');
                    }
                } else {
                    $this->session->set_flashdata('message', '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">Anda tidak memiliki akses untuk peran ini!</div>');
                    redirect('auth/login/' . $role);
                }
            } else {
                $this->session->set_flashdata('message', '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">Password salah!</div>');
                redirect('auth/login/' . $role);
            }
        } else {
            $this->session->set_flashdata('message', '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">Username tidak ditemukan!</div>');
            redirect('auth/login/' . $role);
        }
    }

    public function logout() {
        $this->session->unset_userdata('user_id');
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('nama_lengkap');
        $this->session->unset_userdata('peran');
        $this->session->unset_userdata('logged_in');

        $this->session->set_flashdata('message', '<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">Anda telah berhasil logout!</div>');
        redirect('home');
    }
}
