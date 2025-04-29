<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Siswa extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        // Check if user is logged in
        if(!$this->session->userdata('logged_in')) {
            redirect('auth/login/siswa');
        }
        // Check if user is siswa
        if($this->session->userdata('peran') !== 'siswa') {
            redirect('auth/login/siswa');
        }
        
        $this->load->model('siswa_model');
        $this->load->model('penilaian_model');
        $this->load->model('surat_model');
    }

    public function index() {
        redirect('siswa/dashboard');
    }

    public function dashboard() {
        $data['title'] = 'Dashboard Siswa';
        $id_siswa = $this->siswa_model->get_id_by_user($this->session->userdata('user_id'));
        
        // Get student data
        $data['siswa'] = $this->siswa_model->get_profile($this->session->userdata('user_id'));
        
        // Get statistics
        $data['statistik'] = $this->siswa_model->get_statistics($id_siswa);
        
        // Get recent evaluations
        $data['penilaian_terbaru'] = $this->penilaian_model->get_by_siswa($id_siswa, 5);
        
        // Get progress
        $data['pencapaian'] = $this->siswa_model->get_pencapaian($id_siswa);
        
        // Load views
        $this->load->view('templates/header', $data);
        $this->load->view('siswa/dashboard', $data);
        $this->load->view('templates/footer');
    }

    public function nilai() {
        $data['title'] = 'Nilai Saya';
        $id_siswa = $this->siswa_model->get_id_by_user($this->session->userdata('user_id'));
        
        // Get all evaluations
        $data['penilaian'] = $this->penilaian_model->get_by_siswa($id_siswa);
        
        // Calculate averages
        $data['rata_rata'] = $this->penilaian_model->get_averages($id_siswa);
        
        $this->load->view('templates/header', $data);
        $this->load->view('siswa/nilai', $data);
        $this->load->view('templates/footer');
    }

    public function pencapaian() {
        $data['title'] = 'Pencapaian Hafalan';
        $id_siswa = $this->siswa_model->get_id_by_user($this->session->userdata('user_id'));
        
        // Get all achievements
        $data['pencapaian'] = $this->siswa_model->get_pencapaian($id_siswa);
        
        // Get all surahs for reference
        $data['surat'] = $this->surat_model->get_all();
        
        $this->load->view('templates/header', $data);
        $this->load->view('siswa/pencapaian', $data);
        $this->load->view('templates/footer');
    }

    public function rapor() {
        $data['title'] = 'Rapor Tahfizh';
        $id_siswa = $this->siswa_model->get_id_by_user($this->session->userdata('user_id'));
        
        // Get student data
        $data['siswa'] = $this->siswa_model->get_profile($this->session->userdata('user_id'));
        
        // Get all evaluations
        $data['penilaian'] = $this->penilaian_model->get_by_siswa($id_siswa);
        
        // Get achievements
        $data['pencapaian'] = $this->siswa_model->get_pencapaian($id_siswa);
        
        // Calculate averages
        $data['rata_rata'] = $this->penilaian_model->get_averages($id_siswa);
        
        $this->load->view('templates/header', $data);
        $this->load->view('siswa/rapor', $data);
        $this->load->view('templates/footer');
    }

    public function profile() {
        $data['title'] = 'Profil Saya';
        $data['siswa'] = $this->siswa_model->get_profile($this->session->userdata('user_id'));
        
        $this->load->view('templates/header', $data);
        $this->load->view('siswa/profile', $data);
        $this->load->view('templates/footer');
    }

    public function update_profile() {
        $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required|trim');
        
        if ($this->form_validation->run() == FALSE) {
            redirect('siswa/profile');
        } else {
            $user_data = [
                'nama_lengkap' => $this->input->post('nama_lengkap')
            ];
            
            // Handle photo upload if exists
            if(!empty($_FILES['foto']['name'])) {
                $config['upload_path'] = './assets/uploads/profile/';
                $config['allowed_types'] = 'gif|jpg|jpeg|png';
                $config['max_size'] = 2048;
                $config['file_name'] = 'siswa_'.$this->session->userdata('user_id');
                
                $this->load->library('upload', $config);
                
                if($this->upload->do_upload('foto')) {
                    $user_data['foto_profil'] = $this->upload->data('file_name');
                }
            }
            
            if($this->siswa_model->update_profile($this->session->userdata('user_id'), $user_data)) {
                $this->session->set_flashdata('message', '<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">Profil berhasil diperbarui!</div>');
            } else {
                $this->session->set_flashdata('message', '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">Gagal memperbarui profil!</div>');
            }
            redirect('siswa/profile');
        }
    }

    public function cetak_rapor() {
        $id_siswa = $this->siswa_model->get_id_by_user($this->session->userdata('user_id'));
        
        // Get student data
        $data['siswa'] = $this->siswa_model->get_profile($this->session->userdata('user_id'));
        
        // Get all evaluations
        $data['penilaian'] = $this->penilaian_model->get_by_siswa($id_siswa);
        
        // Get achievements
        $data['pencapaian'] = $this->siswa_model->get_pencapaian($id_siswa);
        
        // Calculate averages
        $data['rata_rata'] = $this->penilaian_model->get_averages($id_siswa);
        
        // Load view for PDF
        $this->load->view('siswa/cetak_rapor', $data);
    }
}
