<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        // Check if user is logged in
        if(!$this->session->userdata('logged_in')) {
            redirect('auth/login/admin');
        }
        // Check if user is admin
        if($this->session->userdata('peran') !== 'admin') {
            redirect('auth/login/admin');
        }
        
        $this->load->model('admin_model');
        $this->load->model('kelas_model');
        $this->load->model('siswa_model');
        $this->load->model('instruktur_model');
    }

    public function index() {
        redirect('admin/dashboard');
    }

    public function dashboard() {
        $data['title'] = 'Dashboard Admin';
        
        // Get statistics
        $data['total_siswa'] = $this->siswa_model->count_all();
        $data['total_instruktur'] = $this->instruktur_model->count_all();
        $data['total_kelas'] = $this->kelas_model->count_all();
        
        // Get recent activities
        $data['recent_penilaian'] = $this->admin_model->get_recent_penilaian(5);
        $data['recent_users'] = $this->admin_model->get_recent_users(5);
        
        // Load views
        $this->load->view('templates/header', $data);
        $this->load->view('admin/dashboard', $data);
        $this->load->view('templates/footer');
    }

    public function users($role = 'all') {
        $data['title'] = 'Manajemen Pengguna';
        $data['role'] = $role;
        
        // Get users based on role
        if($role !== 'all') {
            $data['users'] = $this->admin_model->get_users_by_role($role);
        } else {
            $data['users'] = $this->admin_model->get_all_users();
        }
        
        $this->load->view('templates/header', $data);
        $this->load->view('admin/users/index', $data);
        $this->load->view('templates/footer');
    }

    public function add_user() {
        $data['title'] = 'Tambah Pengguna';
        
        $this->form_validation->set_rules('username', 'Username', 'required|trim|is_unique[pengguna.username]');
        $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[6]');
        $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required|trim');
        $this->form_validation->set_rules('peran', 'Peran', 'required|trim');
        
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('admin/users/add', $data);
            $this->load->view('templates/footer');
        } else {
            $user_data = [
                'username' => $this->input->post('username'),
                'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                'nama_lengkap' => $this->input->post('nama_lengkap'),
                'peran' => $this->input->post('peran')
            ];
            
            if($this->admin_model->add_user($user_data)) {
                $this->session->set_flashdata('message', '<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">Pengguna berhasil ditambahkan!</div>');
            } else {
                $this->session->set_flashdata('message', '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">Gagal menambahkan pengguna!</div>');
            }
            redirect('admin/users');
        }
    }

    public function edit_user($id) {
        $data['title'] = 'Edit Pengguna';
        $data['user'] = $this->admin_model->get_user_by_id($id);
        
        if(!$data['user']) {
            show_404();
        }
        
        $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required|trim');
        
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('admin/users/edit', $data);
            $this->load->view('templates/footer');
        } else {
            $user_data = [
                'nama_lengkap' => $this->input->post('nama_lengkap')
            ];
            
            // Update password if provided
            if($this->input->post('password')) {
                $user_data['password'] = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
            }
            
            if($this->admin_model->update_user($id, $user_data)) {
                $this->session->set_flashdata('message', '<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">Data pengguna berhasil diperbarui!</div>');
            } else {
                $this->session->set_flashdata('message', '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">Gagal memperbarui data pengguna!</div>');
            }
            redirect('admin/users');
        }
    }

    public function delete_user($id) {
        if($this->admin_model->delete_user($id)) {
            $this->session->set_flashdata('message', '<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">Pengguna berhasil dihapus!</div>');
        } else {
            $this->session->set_flashdata('message', '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">Gagal menghapus pengguna!</div>');
        }
        redirect('admin/users');
    }

    public function profile() {
        $data['title'] = 'Profil Admin';
        $data['user'] = $this->admin_model->get_user_by_id($this->session->userdata('user_id'));
        
        $this->load->view('templates/header', $data);
        $this->load->view('admin/profile', $data);
        $this->load->view('templates/footer');
    }

    public function update_profile() {
        $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required|trim');
        
        if ($this->form_validation->run() == FALSE) {
            redirect('admin/profile');
        } else {
            $user_data = [
                'nama_lengkap' => $this->input->post('nama_lengkap')
            ];
            
            // Handle photo upload if exists
            if(!empty($_FILES['foto']['name'])) {
                $config['upload_path'] = './assets/uploads/profile/';
                $config['allowed_types'] = 'gif|jpg|jpeg|png';
                $config['max_size'] = 2048;
                $config['file_name'] = 'admin_'.$this->session->userdata('user_id');
                
                $this->load->library('upload', $config);
                
                if($this->upload->do_upload('foto')) {
                    $user_data['foto_profil'] = $this->upload->data('file_name');
                }
            }
            
            if($this->admin_model->update_user($this->session->userdata('user_id'), $user_data)) {
                $this->session->set_flashdata('message', '<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">Profil berhasil diperbarui!</div>');
            } else {
                $this->session->set_flashdata('message', '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">Gagal memperbarui profil!</div>');
            }
            redirect('admin/profile');
        }
    }
}
